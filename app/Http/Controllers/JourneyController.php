<?php

namespace App\Http\Controllers;

use App\Models\Journey;
use App\Models\Route;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class JourneyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        $journeys = Journey::whereRaw('seats - used_seats != 0')->where('user_id', auth()->id())->get();

        $userId = Auth::id();
        $journeys = Journey::where('user_id', '!=', $userId)
            ->whereRaw('NOT EXISTS (
                    SELECT 1 FROM rides AS r
                    WHERE r.journey_id = journeys.id AND r.user_id =?
                  )', [$userId])
            ->whereRaw('seats - used_seats > 0')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('journeys.index', compact('journeys'));
    }

    public function filter(Request $request) {

        $from = $request->from;
        $to = $request->to;

        $userId = Auth::id();
        $journeys = Journey::where('user_id', '!=', $userId)
            ->whereRaw('NOT EXISTS (
                    SELECT 1 FROM rides AS r
                    WHERE r.journey_id = journeys.id AND r.user_id =?
                  )', [$userId])
            ->whereRaw('seats - used_seats > 0')
            ->where('from', $from)
            ->where('to', $to)
            ->whereDate("departure_time", '>=', Carbon::today()->toDateString())
            ->orderBy('created_at', 'desc')
            ->get();
        return view('journeys.index', compact('journeys'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $userId = Auth::id();
        $routes = Route::where('user_id', $userId)->orderBy("created_at", "DESC")->paginate(3);
        return view('journeys.create', compact('routes'));
    }

    function formatTravelTime($seconds) {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $timeString = "";

        if ($hours > 0) {
            $timeString .= $hours . " h ";
        }
        if ($minutes > 0) {
            $timeString .= $minutes . " m ";
        }

        return $timeString;
    }

    public function route(Request $request) {
        try {
            $data = json_decode($request->getContent(), true);

            $token = env('MAPBOX_TOKEN');
            $url = "https://api.mapbox.com/directions/v5/mapbox/driving/{$data['from']['longitude']}%2C{$data['from']['latitude']}%3B{$data['to']['longitude']}%2C{$data['to']['latitude']}?alternatives=true&geometries=geojson&language=en&overview=simplified&steps=false&access_token={$token}";
            $client = new Client();

            $response = $client->request('GET', $url);
            $res_data = json_decode($response->getBody()->getContents(), true);
            $coordinates = $res_data['routes'][0]['geometry']['coordinates'];
            return response()->json($coordinates);
        } catch (GuzzleException $e) {
            return response()->json(['Guzzle Message' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $token = env('MAPBOX_TOKEN');

        $url = "https://api.mapbox.com/directions/v5/mapbox/driving/{$data['from']['long']}%2C{$data['from']['lat']}%3B{$data['to']['long']}%2C{$data['to']['lat']}?alternatives=true&geometries=geojson&language=en&overview=simplified&steps=false&access_token={$token}";
        $client = new Client();
        try {
            $response = $client->request('GET', $url);
            $res_data = json_decode($response->getBody()->getContents(), true);
            $coordinates = $res_data['routes'][0]['geometry']['coordinates'];
            $duration = $res_data['routes'][0]['duration'];
            $fDuration = $this->formatTravelTime($duration);
            $user_id = auth()->id();

            $journey = new Journey;

            $journey->from = $data['from']['name'];
            $journey->to = $data['to']['name'];
            $journey->from_coordinates = json_encode(['latitude' => $data['from']['lat'], 'longitude' => $data['from']['long']]);
            $journey->to_coordinates = json_encode(['latitude' => $data['to']['lat'], 'longitude' => $data['to']['long']]);
            $journey->price = $data['price'];
            $journey->departure_time = $data['departure_time'];
            $journey->seats = $data['seats'];
            $journey->duration = $fDuration;
            $journey->user_id = $user_id;
            $journey->route_data = json_encode($coordinates);

            $journey->save();

            if($data['template']) {
                $route = new Route;
                $route->user_id = $user_id;
                error_log($journey->id);
                $route->journey_id = $journey->id;
                $route->save();
            }


            return response()->json(['message' => 'Journey created successfully']);


        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();

            return response()->json(['message' => $e->getMessage()], 500);
        } catch (GuzzleException $e) {
            echo 'Guzzle Error: ' . $e->getMessage();

            return response()->json(['Guzzle Message' => $e->getMessage()], 500);
        }

    }

    public function search(Request $request) {
        return view("journeys.search");
    }

    public function autocompleteFrom(Request $request) {
        $query = $request->input('from');
//        $results = Journey::where('from', 'LIKE', "%{$query}%")->take(10)->get();
        $data = Journey::where('from', 'LIKE', '%'. $request->get('query'). '%')
            ->take(10)
            ->get();

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Journey $journey)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Journey $journey)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Journey $journey)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Journey $journey)
    {
        //
    }

}
