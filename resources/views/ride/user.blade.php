@extends('layouts.app')
@section('title', "My Journeys")

@section('content')
    <div class="flex w-full gap-5">
        <div class="ms-5 flex flex-col h-screen overflow-y-scroll">
            <div class="mt-5">
                <h1 class="text-2xl font-black ms-2">All Journeys</h1>

                <div class="list mr-2 px-2">
                    @foreach($rides as $ride)
                        <div class="journey-item">
                            <x-journey-item :journey="$ride->journey" />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection



