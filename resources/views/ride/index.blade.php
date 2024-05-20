@extends('layouts.app')
@section('title', 'Rides')



@section('content')
    <div class="flex w-full gap-10 h-screen">
        <div class="ms-5 flex-1 flex flex-col justify-between pb-5 ">
            <div class="mt-5">
                <h1 class="text-2xl font-black ms-2">Active rides</h1>
                <div class="list mr-2 px-2">
                    @foreach($upcoming_rides as $ride)
                        <x-ride-item :ride="$ride" />
                    @endforeach

                    @if(count($upcoming_rides) == 0)

                        <a href="{{ route('journey.index') }}" class="border-2 rounded-2xl flex justify-center items-center flex-col m-5 p-4 gap-2 hover:bg-gray-100 hover:shadow-lg active:shadow-none select-none transition-all cursor-pointer">
                            <x-heroicon-s-map-pin class="w-[30px] text-green-700"/>
                            <p class="font-bold">See journeys to reserve ride</p>
                        </a>
                    @endif
                </div>
            </div>
            <div class="">
                {{ $upcoming_rides->links() }}
            </div>
        </div>

        @if(session('error'))
            <x-toast-notification type="error" message="{{ session('error') }}" />
        @elseif(session('success'))
            <x-toast-notification type="success" message="{{ session('success') }}" />
        @endif

        <div class="mt-5 flex-1">

        </div>


    </div>
@endsection
