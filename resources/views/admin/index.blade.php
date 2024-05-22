@extends('layouts.admin')
@section('title', 'Home')

@section('content')

    <div class="bg-gray-100 w-full h-screen">
        <div class="grid grid-cols-2">

            <div class="card-container m-5 bg-white p-4 flex rounded-2xl shadow-lg border">
                <div class="flex flex-col justify-between">
                    <h1 class="font-black text-2xl">Active users</h1>
                    <h1 class="font-black text-5xl text-green-600">{{ $usersPerMonth->last()['count'] }}</h1>
                </div>
                <div class="w-full">
                    {!! $chart->render() !!}
                </div>
            </div>

            <div class="card-container m-5 bg-white p-4 flex rounded-2xl shadow-lg border">
                <div class="flex flex-col justify-between">
                    <h1 class="font-black text-2xl">Journeys This Month</h1>
                    <h1 class="font-black text-5xl text-green-600">{{ $journeyPerMonth->last()['count'] }}</h1>
                </div>
                <div class="w-full">
                    {!! $journeyChart->render() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
