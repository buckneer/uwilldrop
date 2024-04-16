<?php

namespace App\Http\Controllers;

use App\Models\Journey;
use Illuminate\Http\Request;

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
        $validatedData = $request->validate([
            'from' => 'required|string|max:255',
            'to' => 'required|string|max:255',
            'date' => 'required|date',
            'price' => 'nullable|numeric|min:0', // Make price optional and allow null values
        ]);

        $journey = Journey::create([
            'from' => $validatedData['from'],
            'to' => $validatedData['to'],
            'date' => $validatedData['date'],
            'price' => $validatedData['price'],
            'user_id' => auth()->id()
        ]);

        return redirect()->route('journeys.index')
            ->with('success', 'Journey created successfully.');
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
