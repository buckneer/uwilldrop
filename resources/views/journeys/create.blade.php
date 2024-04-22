@extends('layouts.app')
@section('title', 'New Journey')

@section('content')
    <div class="flex">
        <div class="bg-light w-100 h-100 flex flex-col gap-5 items-center border-right ms-5">
            <h1 class="mt-2 font-black text-2xl">New Journey</h1>

            <div class="autocomplete-container flex flex-col">
                <label>From Location: </label>
                <div class="autocomplete relative inline-block">
                    <input class="form-input" id="from" type="text" name="from" placeholder="From " autocomplete="off">
                </div>
            </div>

            <div class="autocomplete-container  flex flex-col">
                <label>To Location: </label>
                <div class="autocomplete relative inline-block">
                    <input id="to" class="form-input" type="text" name="to" placeholder="To"  autocomplete="off">
                </div>
            </div>

            <div class="form-group flex flex-col">
                <label for="to">Date</label>
                <input class="form-input" type="datetime-local" id="date" name="date" placeholder="Date">
            </div>
            <div class="form-group flex flex-col">
                <label for="to">Price</label>
                <input class="form-input" type="number" id="price" name="price" placeholder="Price">
            </div>
            <div class="from-group flex flex-col">
                <label for="seats">Seats</label>
                <input class="form-input" type="number" id="seats" name="seats" placeholder="Seats" />
            </div>

            <button id="submitBtn" class="mt-3">Publish</button>
        </div>
        <div class="col-md-6 w-100">
            {{--            <x-mapbox id="map" map-style="mapbox/navigation-night-v1" :center="['long' => 20.849131, 'lat' => 42.8886509 ]"/>--}}
        </div>
    </div>

    <script type="text/javascript">

        const mapboxAccessToken = '{{ env('MAPBOX_TOKEN') }}'; // Replace with your Mapbox access token
    </script>

    @vite('resources/js/autocomplete.js')
@endsection
