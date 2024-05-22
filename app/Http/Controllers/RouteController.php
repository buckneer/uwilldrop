<?php

namespace App\Http\Controllers;

use App\Models\Journey;
use App\Models\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $journey_id = $request->journey_id;
        $user_id = Auth::user()->id;

        if (Route::where('journey_id', '=', $journey_id)->exists()) {
            return redirect()->route('journey.search')->with('error', 'Template Already Saved');
        }

        $route = Route::create($user_id, $journey_id);

        return redirect()->route('journey.search')->with('success', 'Template Saved');
    }


    public function share(Request $request)
    {
        $journey_id = $request->journey_id;
        $journey = Journey::find($journey_id);
        $newJourney = $journey->replicate();
        $newJourney->save();

        return redirect()->route('journey.search')->with('success', 'Template Shared');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $route = Route::find($id);
        $route->delete();
        return redirect()->route('journey.search')->with('success', 'Template Deleted');
    }
}
