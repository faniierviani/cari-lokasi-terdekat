function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        alert("Browser tidak mendukung geolocation");
    }
}

function showPosition(position) {
    document.getElementById("lat").value = position.coords.latitude;
    document.getElementById("lng").value = position.coords.longitude;
}
