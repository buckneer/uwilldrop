@extends('layouts.app')
@section('title', 'Home')


@section('content')
    <div class="flex h-screen">
        <div class="flex-1 grow flex w-full justify-center items-center relative h-100">
            <div id='map' style='width: 100%; height: 100%;'></div>
            <div class="absolute w-full h-full flex z-[9999] items-start"  >
                <div class="bg-white rounded-2xl shadow-xl py-2 m-5 px-3 flex flex-col justify-start text-black font-black">
                    <h1 class="text-2xl text-center py-5">Search for a ride!</h1>
                    <form class="forms-controller flex flex-col items-center gap-5" method="GET" action="{{ route('journey.filter') }}">
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

                        <button class="bg-orange-400 w-full rounded-2xl shadow-xl py-2 px-3 flex justify-center text-white font-black cursor-pointer transition-all hover:bg-orange-500 active:shadow-none active:bg-orange-700 disabled:bg-gray-500">
                            Search
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        let fromCoordinates = {
            longitude: null,
            latitude: null,
            name: null
        };

        let toCoordinates = {
            longitude: null,
            latitude: null,
            name: null
        }
        $(document).ready(function() {
            mapboxgl.accessToken = '{{ env("MAPBOX_TOKEN") }}'; // Ensure you replace this with your actual Mapbox access token
            mapboxAccessToken = '{{ env("MAPBOX_TOKEN") }}'
            const map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/willbuckneer/cluzkj8az005a01qp7xh7d1ba',
                zoom: 2 // Starting zoom
            });

            // Define the autocomplete function with a callback
            function autocomplete(inp, coordinates, callback) {
                var currentFocus;

                $(inp).on("input", function(e) {
                    var a, b, val = $(this).val();
                    closeAllLists();
                    if (!val) { return false; }
                    currentFocus = -1;
                    a = $("<div>").attr({
                        "id": this.id + "autocomplete-list",
                        "class": "autocomplete-items"
                    });
                    $(this).parent().append(a);
                    $.getJSON(`https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(val)}.json?access_token=${mapboxAccessToken}`, function(data) {
                        $.each(data.features, function(i, suggestion) {
                            b = $("<div>").html("<strong>" + suggestion.place_name.substr(0, val.length) + "</strong>" + suggestion.place_name.substr(val.length) + "<input type='hidden' value='" + suggestion.place_name + "'>");
                            b.on("click", function(e) {
                                $(inp).val(this.getElementsByTagName("input")[0].value);
                                coordinates.name = suggestion.place_name;
                                coordinates.longitude = suggestion.geometry.coordinates[0];
                                coordinates.latitude = suggestion.geometry.coordinates[1];
                                console.log(coordinates);

                                // Call the callback function to update the map
                                if (callback) {
                                    callback(coordinates);
                                }

                                closeAllLists();
                            });
                            a.append(b);
                        });
                    });
                });

                $(inp).on("keydown", function(e) {
                    var x = $("#" + this.id + "autocomplete-list").find("div");
                    if (e.keyCode == 40) {
                        currentFocus++;
                        addActive(x);
                    } else if (e.keyCode == 38) { //up
                        currentFocus--;
                        addActive(x);
                    } else if (e.keyCode == 13) {
                        e.preventDefault();
                        if (currentFocus > -1) {
                            x.eq(currentFocus).trigger("click");
                        }
                    }
                });

                function addActive(x) {
                    if (!x) return false;
                    removeActive(x);
                    if (currentFocus >= x.length) currentFocus = 0;
                    if (currentFocus < 0) currentFocus = (x.length - 1);
                    x.eq(currentFocus).addClass("autocomplete-active");
                }

                function removeActive(x) {
                    x.removeClass("autocomplete-active");
                }

                function closeAllLists(elmnt) {
                    $(".autocomplete-items").each(function() {
                        if (this!= elmnt && this!= inp) {
                            $(this).remove();
                        }
                    });
                }

                $(document).on("click", function (e) {
                    closeAllLists(e.target);
                });
            }

            autocomplete(document.getElementById("from"), fromCoordinates, function(selectedLocation) {
                let location = [selectedLocation.longitude, selectedLocation.latitude]
                // new mapboxgl.Marker()
                //     .setLngLat(location)
                //     .addTo(map);

                map.flyTo({center: [selectedLocation.longitude, selectedLocation.latitude], zoom: 10});

            });
            autocomplete(document.getElementById("to"), toCoordinates, function(selectedLocation) {
                let location = [selectedLocation.longitude, selectedLocation.latitude]
                if(fromCoordinates.name == null) {
                    new mapboxgl.Marker()
                        .setLngLat(location)
                        .addTo(map);
                    map.flyTo({center: [selectedLocation.longitude, selectedLocation.latitude], zoom: 10});
                } else {
                    getRoute().then(resp => {
                        console.log(resp);
                        updateMap(resp);
                    });
                }
            });

            function getRoute() {
                return new Promise((resolve, reject) => {
                    let data = {
                        from: fromCoordinates,
                        to: toCoordinates
                    }

                    $.ajaxSetup({
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
                            xhr.setRequestHeader('Content-Type', 'application/json');
                        }
                    });

                    $.ajax({
                        url: '/journey/route',
                        type: 'POST',
                        data: JSON.stringify(data),
                        success: function(response) {

                            resolve(response);
                        },
                        error: function(error) {
                            reject(error);
                        }
                    });
                })
            }

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
                // Calculate the bounds that encompass both the "From" and "To" locations
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

        });


    </script>
@endsection
