@extends('layouts.app')
@section('title', 'Home')

@section('content')
    <div class="flex w-full gap-5" x-data="{ open: false, data: {} }">
        <div class="ms-5 flex flex-col h-screen overflow-y-scroll">
            <div class="mt-5">
                <h1 class="text-2xl font-black ms-2">All Journeys</h1>

                <div class="list mr-2 pr-2">
                    @foreach($journeys as $journey)
                        <x-journey-item :journey="$journey" />
                    @endforeach
                </div>
            </div>
        </div>
        <div class="flex-1 grow flex w-full justify-center items-center relative h-100">
           <x-map :journey="$journeys[0]" />
        </div>
    </div>
@endsection
