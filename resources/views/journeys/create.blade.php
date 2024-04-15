@extends('layouts.app')
@section('title', 'New Journey')

@section('content')
    <div class="row">
        <div class="col-md-6 bg-light w-100 h-100 d-flex flex-column align-items-center border-right border-primary">
            <h1 class="mt-2">New Journey</h1>
            <form method="post" action="{{ route('journey.store')  }}" class="mt-5">
                @csrf
                <div class="form-group mb-2  d-flex flex-column">
                    <label for="from">From</label>
                    <input type="text" id="from" name="from" placeholder="From Place">
                </div>
                <div class="form-group d-flex flex-column">
                    <label for="to">To</label>
                    <input type="text" id="to" name="to" placeholder="To Place">
                </div>
                <div class="form-group d-flex flex-column">
                    <label for="to">Date</label>
                    <input type="date" id="to" name="date" placeholder="Date">
                </div>
                <div class="form-group d-flex flex-column">
                    <label for="to">Price</label>
                    <input type="number" id="price" name="price" placeholder="Price">
                </div>
                <h3 class="mt-4">Stops Between</h3>
                <div class="form-group d-flex flex-column">
                    <label for="stop">Stop</label>
                    <input class="" type="text" id="stop" name="stop" placeholder="Place">
                </div>
                <button type="submit" class="mt-3">Publish</button>
            </form>
        </div>
        <div class="col-md-6 w-100">
            {{--            <x-mapbox id="map" map-style="mapbox/navigation-night-v1" :center="['long' => 20.849131, 'lat' => 42.8886509 ]"/>--}}
        </div>
    </div>
@endsection
