<?php

namespace App\Http\Controllers;

use App\Models\Journey;
use App\Models\Ride;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $upcoming_rides = Ride::where('user_id', $user_id)->where('user_done', false)->get();
        $rate_rides = Ride::where([['user_id', $user_id], ['user_done', true]], ['rating', "==", 0.0])->get();
        return view('ride.index', compact('upcoming_rides', 'rate_rides'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = json_decode($request->getContent(), true);



        try {
            $journey = Journey::find($data['journey_id']);

            $ride = new Ride;

            $ride->user_id = auth()->id();
            $ride->journey_id = $data['journey_id'];
            $ride->rider_id = $journey->user_id;


            $ride->save();

            $journey = Journey::find($data['journey_id']);

            $journey->used_seats += 1;
            $journey->save();

            return response()->json(['message' => 'Journey created successfully'], 201);
        } catch (QueryException $e) {
            echo 'Error: ' . $e->getMessage();
            return response()->json(['message' => $e->getMessage()], 500);
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function doneUser(Request $request) {
        try {
            $ride = Ride::where('user_id', auth()->id())
                ->where('id', $request['ride_id'])
                ->firstOrFail();

            $ride->user_done = true;

            if($ride->driver_done) {
                $ride->active = false;
            }

            $ride->save();
            return redirect('ride')->with(['success' => 'Ride marked as done']);
        } catch (Exception $e) {
            return redirect('ride')->with(['error' => $e->getMessage()]);
        }

    }

    public function doneDriver(Request $request) {
        $ride = Ride::where('user_id', auth()->id())
            ->where('id', $request->post('ride_id'))
            ->firstOrFail();

        if($ride->user_done) {
            $ride->active = false;
        }

        $ride->driver_done = true;
        $ride->save();
        return redirect('ride')->with(['success' => 'Ride marked as done']);
    }

    public function addRating(Request $request) {

        try {

            $ride = Ride::where('id', $request['ride_id'])->firstOrFail();

            if($ride->user_id != auth()->id()) {
                return redirect('ride')->with(['error' => 'You are not allowed to add a rating for this ride']);
            }

            $ride->user_done = true;
            $ride->rating = $request['rating'];
            $ride->comment = $request['comment'];

            $ride->save();
            return redirect('ride')->with(['success' => 'Ride rated']);
        } catch (Exception $e) {
            return redirect('ride')->with(['error' => $e->getMessage()]);
        }
    }

    public function displayByUser(Request $request)
    {
        $user = Auth::user()->id;
        $rides = Ride::where('user_id', $user)
            ->where('driver_done', false)->get();

        return view('ride.user', compact('rides'));
    }
}
