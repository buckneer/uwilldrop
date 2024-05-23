import autoComplete from "@tarekraafat/autocomplete.js";


const searchApi = async (query) => {
    const api = await fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${query}.json?access_token=${accToken}`);
    const data = await api.json();
    return data.features;
}

const searchMap = new mapboxgl.Map({
    container: 'searchMap',
    style: 'mapbox://styles/willbuckneer/cluzkj8az005a01qp7xh7d1ba',
    zoom: 2
});



let searchFromCoordinates = {
    longitude: null,
    latitude: null,
    name: null
};
let searchToCoordinates = {
    longitude: null,
    latitude: null,
    name: null
}


const selection = (event) => {
    const selection = event.detail.selection.value;
    const coords = selection.geometry.coordinates;
    const place = selection.place_name;

    return {
        longitude: coords[0],
        latitude: coords[1],
        name: place,
    }
}

const searchFromSelection = (event) => {
    let sel = selection(event);
    searchFromCoordinates = sel;
    searchMap.flyTo({center: [searchFromCoordinates.longitude, searchFromCoordinates.latitude], zoom: 10});
    searchFromAutocomplete.input.value = sel.name;
}

const searchToSelection = (event) => {
    let sel = selection(event);
    searchToCoordinates = sel;
    getRoute().then(resp => { drawOnMap(resp) });
    searchToAutocomplete.input.value = sel.name;
}

const searchFromAutocomplete = new autoComplete({
    placeHolder: "Search for start location...",
    selector: "#searchFrom",
    data: {
        src: searchApi,
        keys: ["place_name"]
    },
    resultItem: {
        highlight: true
    },
    events: {
        input: {
            selection: searchFromSelection
        }
    }
});

const searchToAutocomplete = new autoComplete({
    placeHolder: "Search for end location...",
    selector: "#searchTo",
    data: {
        src: searchApi,
        keys: ["place_name"]
    },
    resultItem: {
        highlight: true
    },
    events: {
        input: {
            selection: searchToSelection
        }
    }
});

function getRoute() {
    return new Promise((resolve, reject) => {
        let data = {
            from: searchFromCoordinates,
            to: searchToCoordinates
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

function drawOnMap(routeData) {
    if (searchMap.getSource('route')) {
        searchMap.removeLayer('route');
        searchMap.removeSource('route');
    }

    searchMap.addSource('route', {
        'type': 'geojson',
        'data': {
            "type": "Feature",
            "geometry": {
                "type": "LineString",
                "coordinates": routeData
            }
        }
    });

    searchMap.addLayer({
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

    const bounds = new mapboxgl.LngLatBounds();
    routeData.forEach(coord => {
        bounds.extend(coord);
    });
    searchMap.fitBounds(bounds, {
        padding: 20,
        maxZoom: 10
    });
}
