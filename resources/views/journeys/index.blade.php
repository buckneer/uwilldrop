@extends('layouts.app')
@section('title', 'Home')

@section('content')
    <div class="flex w-full gap-5">
        <div class="ms-5 flex flex-col h-screen overflow-y-scroll">
            <div class="mt-5">
                <h1 class="text-2xl font-black ms-2">All Journeys</h1>
                @if($journeys->empty())
                    <div class="flex flex-col ms-2 mt-5 justify-center items-start">
                        <h1 class="text-2xl">No Journeys for that location</h1>
                        <a class="decoration-1 text-blue-500 text-xl" href="#">You should be the first to make one!</a>
                    </div>

                @endif

                <div class="list mr-2 px-2">
                    @foreach($journeys as $journey)
                        <div class="journey-item" data-route-data="{{ $journey->route_data }}" data-journey="{{ $journey->id }}">
                            <x-journey-item :journey="$journey" />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="hidden lg:block flex-1 grow flex w-full justify-center items-center relative h-100">
            <div id='map' style='width: 100%; height: 100%;'></div>
            <button  class="book-ride absolute bottom-14 left-[20%] right-[20%] bg-orange-400 rounded-2xl shadow-xl py-2 px-3 flex justify-center text-white font-black cursor-pointer transition-all hover:bg-orange-500 active:shadow-none active:bg-orange-700 disabled:bg-gray-500">
                Book a ride
            </button>
        </div>

        <div class="block lg:hidden fixed bottom-14 w-full flex justify-center">
            <button class="book-ride w-1/2 bottom-14 bg-orange-400 rounded-2xl shadow-xl py-2 px-3 flex justify-center text-white font-black cursor-pointer transition-all hover:bg-orange-500 active:shadow-none active:bg-orange-700 disabled:bg-gray-500">
                Book a ride
            </button>
        </div>
    </div>


    <script>

        let activeJourney = null; // Initialize activeJourney as null

        $(document).ready(function() {

            mapboxgl.accessToken = '{{ env("MAPBOX_TOKEN") }}';
            const map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/willbuckneer/cluzkj8az005a01qp7xh7d1ba',
                zoom: 0
            });

            function updateMap(routeData) {
                if (map.getSource('route')) {
                    map.removeLayer('route');
                    map.removeSource('route');
                }

                map.addSource('route', {
                    'type': 'geojson',
                    'data': {
                        "type": "Feature",
                        "geometry": {
                            "type": "LineString",
                            "coordinates": routeData
                        }
                    }
                });
                map.addLayer({
                    'id': 'route',
                    'type': 'line',
                    'source': 'route',
                    'layout': {
                        'line-join': 'round',
                        'line-cap': 'round'
                    },
                    'paint': {
                        'line-color': '#3887be',
                        'line-width': 5,
                        'line-opacity': 0.75
                    }
                });

                // Calculate the bounds of the route
                const bounds = new mapboxgl.LngLatBounds();
                routeData.forEach(coord => {
                    bounds.extend(coord);
                });

                // Fit the map to the bounds of the route
                map.fitBounds(bounds, {
                    padding: 20, // Add some padding around the route
                    maxZoom: 10 // Optionally set a maximum zoom level
                });
            }


            function updateButtonState() {
                if (activeJourney) {
                    $('.book-ride').prop('disabled', false);
                } else {
                    $('.book-ride').prop('disabled', true);
                }
            }

            // Call the function initially to set the button's state
            updateButtonState();

            $('.journey-item').click(function() {
                const journey = $(this).data('journey');
                const routeData = $(this).data('route-data');

                updateMap(routeData);
                activeJourney = journey;
                updateButtonState();
            });



            $('.book-ride').click(function () {


                let data = {
                    journey_id: activeJourney,
                }

                $.ajax({
                    url: '/ride/',
                    method: "POST",
                    data: JSON.stringify(data),
                    beforeSend: function(xhr) {
                        // Show the loader
                        $('.loader-container').show();
                        xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
                        xhr.setRequestHeader('Content-Type', 'application/json');
                    },
                    complete: function() {
                        // Hide the loader
                        $('.loader-container').hide();
                    },
                    success: function(response) {
                        // Handle success
                        console.log(response);

                        // Check if the success message exists and update the notification
                        if (response.success) {
                            showNotification('success', response.success.message);
                            // $('#success p').text(response.success.message);
                            // $('#success').fadeIn().delay(10000).fadeOut(); // Show the success notification, wait 10 seconds, then fade out
                        } else if (response.error) {
                            console.log(response.error.message);
                            showNotification('error', response.error.message);
                            // $('#error p').text(response.error.message);
                            // $('#error').fadeIn().delay(10000).fadeOut();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // Handle error
                        console.error(textStatus, errorThrown);

                        // Check if the error message exists and update the notification
                        showNotification('error', jqXHR.responseJSON.message || 'An unknown error occurred');
                    }
                });
            })
        });
    </script>
@endsection
