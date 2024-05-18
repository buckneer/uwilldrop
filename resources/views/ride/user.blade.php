@extends('layouts.app')
@section('title', "My Journeys")

@section('content')
    <div class="flex w-full gap-5">
        <div class="ms-5 flex flex-col h-screen overflow-y-scroll">
            <div class="mt-5">
                <h1 class="text-2xl font-black ms-2">Active Rides</h1>
                <p class="ms-2">Click on ride to mark it as done and rate your passenger</p>

                <div class="list mr-2 px-2">
                    @foreach($rides as $ride)
                        <div class="journey-item">
                            <x-rate-user :ride="$ride" />
                        </div>
                    @endforeach
                </div>
                <div class="mt-5 mx-5">
                    {{ $rides->links() }}
                </div>
            </div>
        </div>
        <div class="ms-5 flex flex-col h-screen">
            <div class="mt-5">
                <h1 class="text-2xl font-black ms-2">All Journeys</h1>
                <p class="ms-2">All Journeys you've ever created</p>

                <div class="list mr-2 px-2">
                    @foreach($journeys as $journey)
                        <div class="journey-item">
                            <x-journey-item :journey="$journey" />
                        </div>
                    @endforeach
                </div>
                <div class="mt-5 mx-5">
                    {{ $journeys->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection



