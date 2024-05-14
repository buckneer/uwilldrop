<?php

namespace App\Http\Controllers;

use App\Models\Journey;
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
        $journeys = Journey::all();
        return view('journeys.index', compact('journeys'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        return view('journeys.create');
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


            $journey = new Journey;

            $journey->from = $data['from']['name'];
            $journey->to = $data['to']['name'];
            $journey->from_coordinates = json_encode(['latitude' => $data['from']['lat'], 'longitude' => $data['from']['long']]);
            $journey->to_coordinates = json_encode(['latitude' => $data['to']['lat'], 'longitude' => $data['to']['long']]);
            $journey->price = $data['price'];
            $journey->departure_time = $data['departure_time'];
            $journey->seats = $data['seats'];
            $journey->duration = $fDuration;
            $journey->user_id = auth()->id();
            $journey->route_data = json_encode($coordinates);

            $journey->save();

            return response()->json(['message' => 'Journey created successfully'], 201);


        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();

            return response()->json(['message' => $e->getMessage()], 500);
        } catch (GuzzleException $e) {
            echo 'Guzzle Error: ' . $e->getMessage();

            return response()->json(['Guzzle Message' => $e->getMessage()], 500);
        }

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
