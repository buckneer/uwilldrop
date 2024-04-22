<?php

namespace App\Http\Controllers;

use App\Models\Journey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Decode the JSON data from the request
        $data = json_decode($request->getContent(), true);

        // Create a new journey instance
        $journey = new Journey;

//        TODO before sending request, drop DATE!

        // Map the incoming data to the model's fields
        $journey->from = $data['from']['name'];
        $journey->to = $data['to']['name'];
        $journey->from_coordinates = json_encode(['latitude' => $data['from']['lat'], 'longitude' => $data['from']['long']]);
        $journey->to_coordinates = json_encode(['latitude' => $data['to']['lat'], 'longitude' => $data['to']['long']]);
        $journey->price = $data['price'];
        $journey->departure_time = $data['departure_time'];
        $journey->seats = $data['seats'];
        $journey->duration = $data['duration'];
        $journey->user_id = auth()->id(); // Assuming you want to associate the journey with the currently authenticated user

        // Save the journey to the database
        $journey->save();

        // Return a response
        return response()->json(['message' => 'Journey created successfully'], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Journey $journey)
    {

        return view('journeys.show', compact('journey'));
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
