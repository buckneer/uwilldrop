<div id='map' style='width: 100%; height: 100%;'></div>


<script type="text/javascript">
    const token = '{{ env('MAPBOX_TOKEN') }}';
    mapboxgl.accessToken = token;
    const from = [{{ $from->longitude }}, {{ $from->latitude }}];
    const to = [{{ $to->longitude }}, {{ $to->latitude }}];

    const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/willbuckneer/clv9ryxwp00rm01qudqstasdm',
        center: [{{ $from->longitude }}, {{ $from->latitude }}],
        zoom: 6.3
    });


    function drawRoute() {
        var routeData = {
            "type": "Feature",
            "geometry": {
                "type": "LineString",
                "coordinates": {{ $journey['route_data'] }}
            }
        };

        map.on('load', function () {
            map.addSource('route', {
                'type': 'geojson',
                'data': routeData
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

        })
    }

    drawRoute();
</script>
