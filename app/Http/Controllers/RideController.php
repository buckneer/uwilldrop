<?php

namespace App\Http\Controllers;

use App\Models\Journey;
use App\Models\Ride;
use App\Models\Transaction;
use App\Models\User;
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
        $upcoming_rides = Ride::where('user_id', $user_id)->where('user_done', false)->orderBy('created_at', 'DESC')->simplePaginate(2);
        return view('ride.index', compact('upcoming_rides'));
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

            $user = Auth::user();
            $transaction = new Transaction;
            $driverTransaction = new Transaction;
            $driver = $journey->user;


            if($user->wallet < $journey->price) {
                return response()->json(['error' => ['message' => 'Not enough money']]);
            }

            $driver->wallet += $journey->price;
            $driverTransaction->type = 2;
            $driverTransaction->amount = $journey->price;
            $driverTransaction->wallet = true;
            $driverTransaction->user_id = $driver->id;


            $currWallet = $user->wallet;
            $user->wallet = $currWallet - $journey->price;
            $transaction->type = 0;
            $transaction->amount = $journey->price;
            $transaction->card_id = null;
            $transaction->user_id = $user->id;
            $transaction->wallet = true;


            $ride = new Ride;

            $ride->user_id = auth()->id();
            $ride->journey_id = $data['journey_id'];
            $ride->rider_id = $journey->user_id;


            $ride->save();
            $journey = Journey::find($data['journey_id']);

            $journey->used_seats += 1;
            $journey->save();
            $user->save();
            $transaction->save();
            $driver->save();
            $driverTransaction->save();

            return response()->json(['success' => ['message' => 'Ride Booked!']]);
        } catch (QueryException $e) {
            echo 'Error: ' . $e->getMessage();
            return response()->json(['error' => "Couldn't book journey"]);
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

            $this->updateDriverRating($request);

            return redirect('ride')->with(['success' => 'Ride rated']);
        } catch (Exception $e) {
            return redirect('ride')->with(['error' => $e->getMessage()]);
        }
    }

    public function addUserRating(Request $request) {
        try {
            $ride = Ride::where('id', $request['ride_id'])->firstOrFail();

            if($ride->rider_id != auth()->id()) {
                return redirect('ride')->with(['errors' => 'You are not allowed to add a rating for this ride']);
            }

            $ride->driver_done = true;
            $ride->user_rating = $request['rating'];
            $ride->user_comment = $request['comment'];

            $ride->save();

            $this->updateUserRating($request);
            return redirect('ride/active')->with(['success' => 'Ride rated']);
        } catch (Exception $e) {
            return redirect('ride')->with(['errors' => $e->getMessage()]);
        }
    }

    public function updateDriverRating(Request $request) {
        try {

            $ride = Ride::where('id', $request['ride_id'])->firstOrFail();
            $user_id = $ride->journey->user_id;

            $rides = Ride::whereHas('journey', function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            })->get();

            $averageRating = $rides->avg('rating');

            $user = User::findOrFail($user_id);
            $user->rating = $averageRating;
            $user->save();

        } catch (Exception $e) {
            return redirect('ride')->with(['error' => $e->getMessage()]);
        }
    }

    public function updateUserRating(Request $request) {
        try {

            $ride = Ride::where('id', $request['ride_id'])->firstOrFail();
            $user_id = $ride->journey->user_id;

            $rides = Ride::whereHas('journey', function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            })->get();

            $averageRating = $rides->avg('user_rating');

            $user = User::findOrFail($user_id);
            $user->user_rating = $averageRating;
            $user->save();

        } catch (Exception $e) {
            return redirect('ride')->with(['error' => $e->getMessage()]);
        }
    }

    public function displayByUser(Request $request)
    {
        $user = auth()->id();
        $rides = Ride::where('rider_id', $user)
            ->where('driver_done', false)->simplePaginate(2, '*', 'rides')->withQueryString();

        $journeys = Journey::where('user_id', $user)->simplePaginate(2, '*', 'journeys')->withQueryString();

        return view('ride.user', compact('rides', 'journeys'));
    }
}
