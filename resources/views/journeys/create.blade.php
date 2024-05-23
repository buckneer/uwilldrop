@extends('layouts.app')
@section('title', 'New Journey')

@section('content')
    <div class="h-screen  relative">
        <div id="journey-container" class="absolute top-0 left-0 w-full h-full flex flex-col justify-center items-center">
            <div class="journey bg-white p-5 rounded-2xl shadow-2xl  z-[9998]">
                <h1 class="mt-2 font-black text-2xl">New Journey</h1>

                <div class="locations flex justify-between gap-4">
                    <div class="flex flex-col ">
                        <label>From Location: </label>
                        <input id="from" class="w-1/2" type="search" dir="ltr" spellcheck=false autocomplete="off" autocapitalize="off" />
                    </div>

                    <div class="autocomplete-container  flex flex-col">
                        <label>To Location: </label>
                        <input id="to" type="search" dir="ltr" spellcheck=false autocomplete="off" autocapitalize="off" />
                    </div>
                </div>

                <div class="form-group flex flex-col">
                    <label for="date">Date</label>
                    <input class="form-input date-form" type="datetime-local" id="date" name="date" placeholder="Date">
                </div>
                <div class="group flex justify-between gap-4">
                    <div class="form-group flex flex-col">
                        <label for="to">Price</label>
                        <input class="form-input" type="number" id="price" name="price" placeholder="Price">
                    </div>
                    <div class="from-group flex flex-col">
                        <label for="seats">Seats</label>
                        <input class="form-input" type="number" id="seats" name="seats" placeholder="Seats" />
                    </div>
                </div>
                <div class="flex justify-start items-center gap-2 mt-2 ">
                    <input class="border border-[#c4c8ce] rounded;" type="checkbox" id="template" name="template" />
                    <label>Save as template</label>
                </div>

                <div class="button-container w-full">
                    <button id="submitBtn" class="w-full mt-3 bg-orange-400 rounded-2xl shadow-xl py-2 px-3 flex justify-center text-white font-black cursor-pointer transition-all hover:bg-orange-500 active:shadow-none active:bg-orange-700 disabled:bg-gray-500">Publish</button>
                </div>

            </div>
            <div class="bg-white z-[9999] mt-2 rounded-2xl p-2 shadow mx-5">
                <h1 class="text-muted mb-2 ms-2">Or select from template</h1>
                <div class="grid grid-cols-3 gap-2 pb-2">
                    @forelse($routes as $route)
                        <form method="POST" action="{{ route('route.share') }}">
                            @csrf
                            <input type="hidden" name="journey_id" value="{{ $route->journey->id }}" />
                            <button class="flex flex-col gap-2 border rounded p-2 hover:bg-gray-100 cursor-pointer text-start active:scale-90 transition-all">
                                <div class="">
                                    <p>From: <span class="font-bold">{{ $route->journey->from }}</span></p>
                                    <p>To: <span class="font-bold">{{ $route->journey->to }}</span></p>
                                </div>
                                <div class="">
                                    <p>Price: <span class="font-bold">{{ $route->journey->price }} RSD </span></p>
                                    <p>Seats: <span class="font-bold">{{ $route->journey->seats }} </span></p>
                                </div>
                            </button>
                        </form>

                    @empty
                        <h1 class="text-muted mt-5">Your templates will appear here</h1>
                    @endforelse

                </div>
            </div>

        </div>
        <div id="journey-add" class="absolute hidden bottom-5 right-5 bg-orange-500 z-[9999] rounded-full p-3 text-white hover:bg-orange-700 transition-all active:scale-90">
            <x-heroicon-o-plus class="w-[40px]" />
        </div>
        <div class="hidden lg:block col-md-6 w-full h-full">
            <div id='map' style='width: 100%; height: 100%;'></div>
        </div>



        @if(session('error'))
            <x-toast-notification type="error" message="{{ session('error') }}" />
        @elseif(session('success'))
            <x-toast-notification type="success" message="{{ session('success') }}" />
        @endif

    </div>

    <script type="text/javascript">

        const accToken = '{{ env("MAPBOX_TOKEN") }}';
        mapboxgl.accessToken = '{{ env("MAPBOX_TOKEN") }}'; // Replace with your Mapbox access token

        const map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/willbuckneer/cluzkj8az005a01qp7xh7d1ba',
            zoom: 2 // Starting zoom
        });

        $("#map").on('click', function() {
            $("#journey-container").fadeOut(500);
            $("#journey-add").fadeIn(500);
        })

        $("#journey-add").on('click', function() {
            $("#journey-container").fadeIn(500);
            $("#journey-add").fadeOut(500);
        })

    </script>


@endsection
