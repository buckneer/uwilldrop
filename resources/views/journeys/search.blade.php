@extends('layouts.app')
@section('title', 'Home')


@section('content')
    <div class="flex h-screen">
        <div class="flex-1 grow flex w-full justify-center items-center relative h-100">
            <div id='searchMap' class="hidden lg:block" style='width: 100%; height: 100%;'></div>
            <div class="absolute w-full h-full flex z-[9999] items-start"  >
                <div class="bg-white rounded-2xl w-full lg:w-auto shadow-xl py-2 m-5 px-3 flex flex-col justify-start text-black font-black">
                    <h1 class="text-2xl text-center py-5">Search for a ride!</h1>
                    <form class="forms-controller flex flex-col items-center gap-5" method="GET" action="{{ route('journey.filter') }}">
                        <div class="flex flex-col">
                            <label>From Location: </label>
                            <div class="autocomplete relative inline-block">
                                <input id="searchFrom" name="from" type="search" dir="ltr" spellcheck=false autocomplete="off" autocapitalize="off">
                            </div>
                        </div>
                        <div class="autocomplete-container  flex flex-col">
                            <label>To Location: </label>
                            <div class="autocomplete relative inline-block">
                                <input id="searchTo" class="form-input" type="search" name="to" placeholder="To"  autocomplete="off">
                            </div>
                        </div>

                        <button class="bg-orange-400 w-full rounded-2xl shadow-xl py-2 px-3 flex justify-center text-white font-black cursor-pointer transition-all hover:bg-orange-500 active:shadow-none active:bg-orange-700 disabled:bg-gray-500">
                            Search
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        const accToken = '{{ env("MAPBOX_TOKEN") }}';
        mapboxgl.accessToken = accToken;
    </script>
    @vite('resources/js/search.js')
@endsection
