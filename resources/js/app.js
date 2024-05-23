import '@popperjs/core';
import 'mapbox-gl/dist/mapbox-gl.css';
import '@fortawesome/fontawesome-free/css/all.css';
import Alpine from 'alpinejs'
import autoComplete from "@tarekraafat/autocomplete.js";

window.Alpine = Alpine

Alpine.start()

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

const searchApi = async (query) => {
    const api = await fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${query}.json?access_token=${accToken}`);
    const data = await api.json();
    return data.features;
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

const fromSelection = (event) => {
    let sel = selection(event);
    fromCoordinates = sel;
    fromAutocomplete.input.value = sel.name;
}

const toSelection = (event) => {
    let sel = selection(event);
    toCoordinates = sel;
    toAutocomplete.input.value = sel.name;
}


const fromAutocomplete = new autoComplete({
    placeHolder: "Search for start location...",
    selector: "#from",
    data: {
        src: searchApi,
        keys: ["place_name"]
    },
    resultItem: {
        highlight: true
    },
    events: {
        input: {
            selection: fromSelection
        }
    }
});

const toAutocomplete = new autoComplete({
    placeHolder: "Search for end location...",
    selector: "#to",
    data: {
        src: searchApi,
        keys: ["place_name"]
    },
    resultItem: {
        highlight: true
    },
    events: {
        input: {
            selection: toSelection
        }
    }
});



$('#submitBtn').click(function() {

    let date = $("#date").val();
    let seats = $("#seats").val();
    let price = $("#price").val();
    let template = $("#template").is(":checked");

    var today = new Date();
    var selectedDate = new Date(date);
    if (selectedDate < today) {
        showNotification('error', "Can't select date older than today");
        $("#date").val = "";
        return;
    }

    let startCoordinates = {
        name: fromCoordinates.name,
        lat: fromCoordinates.latitude,
        long: fromCoordinates.longitude
    };
    let endCoordinates = {
        name: toCoordinates.name,
        lat: toCoordinates.latitude,
        long: toCoordinates.longitude
    };


    let data = {
        from: startCoordinates,
        to: endCoordinates,
        departure_time: date,
        seats: seats,
        price: price,
        template: template
    };

    sendAjaxRequest(data);

});

function sendAjaxRequest(data) {
    $.ajaxSetup({
        beforeSend: function(xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
            xhr.setRequestHeader('Content-Type', 'application/json');
        }
    });

    $.ajax({
        url: '/journey/',
        type: 'POST',
        data: JSON.stringify(data),
        success: function(response) {
            console.log(response);
            console.log(data);
            showNotification('success', response.message);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            // Handle error
            console.error(textStatus, errorThrown);

            // Check if the error message exists and update the notification
            showNotification('error', jqXHR.responseJSON.message || 'An unknown error occurred');
        }
    });
}

