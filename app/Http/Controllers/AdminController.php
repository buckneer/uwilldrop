<?php

namespace App\Http\Controllers;

use App\Models\Journey;
use App\Models\Ride;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Exception;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function index() {
        $start = Carbon::parse(User::min("created_at"));
        $end = Carbon::now();
        $period = CarbonPeriod::create($start, "1 month", $end);

        $usersPerMonth = collect($period)->map(function ($date) {
            $endDate = $date->copy()->endOfMonth();

            return [
                "count" => User::where("created_at", "<=", $endDate)->count(),
                "month" => $endDate->format("Y-m-d")
            ];
        });

        $data = $usersPerMonth->pluck("count")->toArray();
        $labels = $usersPerMonth->pluck("month")->toArray();

        $chart = app()
            ->chartjs->name("Users")
            ->type("line")
            ->labels($labels)
            ->datasets([
                [
                    "label" => "",
                    "backgroundColor" => "rgba(38, 185, 154, 0.31)",
                    "borderColor" => "rgba(38, 185, 154, 0.7)",
                    "data" => $data
                ]
            ])
            ->options([
                'scales' => [
                    'x' => [
                        'type' => 'time',
                        'time' => [
                            'unit' => 'month'
                        ],
                        'min' => $start->format("Y-m-d"),
                        'display' => false
                    ],

                    'y' => [
                        'display' => false
                    ]
                ],
                'plugins' => [
                    'title' => [
                        'display' => false,
                        'text' => 'Monthly User Registrations'
                    ]
                ]
            ]);

        $journeyStart = Carbon::parse(Journey::min("created_at"));
        $journeyPeriod = CarbonPeriod::create($journeyStart, "1 month", $end);

        $journeyPerMonth = collect($journeyPeriod)->map(function ($date) {
            $endDate = $date->copy()->endOfMonth();

            return [
                "count" => Journey::where("created_at", "<=", $endDate)->count(),
                "month" => $endDate->format("Y-m-d")
            ];
        });

        $journeyData = $journeyPerMonth->pluck("count")->toArray();
        $journeyLabels = $journeyPerMonth->pluck("month")->toArray();

        $journeyChart = app()
            ->chartjs->name("Journeys")
            ->type("line")
            ->labels($journeyLabels)
            ->datasets([
                [
                    "label" => "",
                    "backgroundColor" => "rgba(38, 185, 154, 0.31)",
                    "borderColor" => "rgba(38, 185, 154, 0.7)",
                    "data" => $journeyData
                ]
            ])
            ->options([
                'scales' => [
                    'x' => [
                        'type' => 'time',
                        'time' => [
                            'unit' => 'month'
                        ],
                        'min' => $journeyStart->format("Y-m-d"),
                        'display' => false
                    ],

                    'y' => [
                        'display' => false
                    ]
                ],
                'plugins' => [
                    'title' => [
                        'display' => false,
                        'text' => 'Monthly User Registrations'
                    ]
                ]
            ]);

        return view('admin.index', compact('chart', 'usersPerMonth', 'journeyChart', 'journeyPerMonth'));
    }

    public function users() {
        $users = User::withCount('rides', 'passenger')->paginate(6);

        return view('admin.users', compact('users'));
    }

    public function journeys() {
        $journeys = Journey::withCount('rides')->paginate(8);
        return view('admin.journey', compact('journeys'));
    }

    public function rides() {
        $rides = Ride::with('journey', 'user', 'driver')->paginate(11);
        return view('admin.ride', compact('rides'));
    }


    public function role(Request $request) {
        try {
            $user_id = $request->user_id;
            $user = User::find($user_id);

            if($user->email == auth()->user()->email) {
                return redirect()->back()->with(['error' => 'This is you.']);
            }

            $current_role = $user->role;

            if($current_role == "user") {
                $user->role = "admin";
            } else {
                $user->role = "user";
            }

            $user->save();

            return redirect()->back()->with(['success' => "Role Updated Successfully."]);
        } catch (\Exception $exception) {
            return redirect()->back()->with(['error' => "Internal Server Error"]);
        }
    }

    public function deleteUser(Request $request) {
        try {
            $user_id = $request->user_id;
            $user = User::find($user_id);

            if($user->email == auth()->user()->email) {
                return redirect()->back()->with(['error' => 'This is you.']);
            }

            $user->delete();
            return redirect()->back()->with(['success' => "User Deleted Successfully."]);
        } catch (Exception $e) {
            return redirect()->back()->with(['error' => "Internal Server Error"]);
        }
    }
    public function deleteJourney(Request $request) {
        try {
            $journey_id = $request->journey_id;
            $journey = Journey::find( $journey_id);


            $journey->delete();
            return redirect()->back()->with(['success' => "Journey Deleted Successfully."]);
        } catch (Exception $e) {
            return redirect()->back()->with(['error' => "Internal Server Error"]);
        }
    }

    public function deleteRide(Request $request) {
        try {
            $ride_id = $request->ride_id;
            $ride = Ride::find($ride_id);


            $ride->delete();
            return redirect()->back()->with(['success' => "Ride Deleted Successfully."]);
        } catch (Exception $e) {
            return redirect()->back()->with(['error' => "Internal Server Error"]);
        }
    }

    public function done(Request $request) {
        try {
            $ride_id = $request->ride_id;
            $ride = Ride::find($ride_id);

            if ($ride->active == false) {
                return redirect()->back()->with(['error' => "Ride Already Done."]);
            }
            $ride->active = false;
            $ride->save();
            return redirect()->back()->with(['success' => "Ride Done."]);
        } catch (Exception $e) {
            return redirect()->back()->with(['error' => "Internal Server Error"]);
        }
    }

}
