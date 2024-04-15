@extends('layouts.app')
@section('title', 'Home')

@section('content')
    <div class="journeys w-100">
        <div class="row ">
            <div class="journeys col-md-6 d-flex flex-column align-items-center">
                <h1 class="my-5">All Journeys</h1>
                @foreach($journeys as $journey)

                    <x-journey-item :journey="$journey" />

                @endforeach
{{--                <x-journey-item />--}}
{{--                <x-journey-item />--}}
{{--                <x-journey-item />--}}
{{--                <x-journey-item />--}}
            </div>
            <div class="col-md-6">
                <h1>Hello</h1>
{{--                Display a map!--}}
            </div>
        </div>
    </div>
@endsection
