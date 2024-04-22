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

function autocomplete(inp, coordinates) {
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
            if (this != elmnt && this != inp) {
                $(this).remove();
            }
        });
    }

    $(document).on("click", function (e) {
        closeAllLists(e.target);
    });
}


autocomplete(document.getElementById("from"), fromCoordinates);
autocomplete(document.getElementById("to"), toCoordinates);

function formatTravelTime(seconds) {
    let hours = Math.floor(seconds / 3600);
    let minutes = Math.floor((seconds % 3600) / 60);
    let timeString = "";

    if (hours > 0) {
        timeString += hours + " h";
    }
    if (minutes > 0) {
        timeString += minutes + " m";
    }

    return timeString;
}

function getRouteData(startLng, startLat, endLng, endLat) {
    let url = `https://api.mapbox.com/directions/v5/mapbox/driving/${startLng}%2C${startLat}%3B${endLng}%2C${endLat}?alternatives=true&geometries=geojson&language=en&overview=simplified&steps=false&access_token=${mapboxAccessToken}`;

    return fetch(url)
        .then(response => response.json())
        .then(data => {
            const travelTime = data.routes[0].duration;
            return formatTravelTime(travelTime);
        })
        .catch(error => console.error('Error:', error));
}

$('#submitBtn').click(function() {

    let date = $("#date").val();
    let seats = $("#seats").val();
    let price = $("#price").val();

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


    getRouteData(startCoordinates.long, startCoordinates.lat, endCoordinates.long, endCoordinates.lat)
        .then(travelTime => {
            // Add travel time to the data object
            let data = {
                from: startCoordinates,
                to: endCoordinates,
                departure_time: date,
                seats: seats,
                price: price,
                duration: travelTime // Add travel time here
            };

            console.log(data);

            // Proceed with AJAX request
            sendAjaxRequest(data);
        })
        .catch(error => console.error('Error fetching travel time:', error));

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
        },
        error: function(error) {
            console.error(error);
        }
    });
}