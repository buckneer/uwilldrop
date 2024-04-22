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

    function getRouteData(startLng, startLat, endLng, endLat) {
        let url = `https://api.mapbox.com/directions/v5/mapbox/driving/${startLng}%2C${startLat}%3B${endLng}%2C${endLat}?alternatives=true&geometries=geojson&language=en&overview=simplified&steps=false&access_token=${token}`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                drawRoute(data);
            })
            .catch(error => console.error('Error:', error));
    }

    function drawRoute(data) {
        var routeData = {
            "type": "Feature",
            "geometry": {
                "type": "LineString",
                "coordinates": data.routes[0].geometry.coordinates
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
    getRouteData(from[0], from[1], to[0], to[1]);
</script>
