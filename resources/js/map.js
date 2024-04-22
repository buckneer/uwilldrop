
function formatTravelTime(seconds) {
    let hours = Math.floor(seconds / 3600);
    let minutes = Math.floor((seconds % 3600) / 60);
    let timeString = "";

    if (hours > 0) {
        timeString += hours + " h" + (hours > 1 ? "s" : "") + " ";
    }
    if (minutes > 0) {
        timeString += minutes + " m";
    }

    return timeString;
}




