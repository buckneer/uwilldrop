@extends('layouts.app')
@section('title', 'Home')

@section('content')
    <div class="flex w-full">
        <div class="mt-5 ms-5 w-full flex flex-col justify-center">
            <h1 class="text-2xl font-black ms-2">All Journeys</h1>

            <div class="list">
                @foreach($journeys as $journey)
                    <x-journey-item :journey="$journey" />
                @endforeach
            </div>
        </div>
        <div class="flex-1">

        </div>
    </div>
@endsection
