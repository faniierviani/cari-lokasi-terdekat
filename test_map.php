<!DOCTYPE html>
<html>
<head>
<title>Test Map</title>
<style>
#map { height:400px; width:100%; }
</style>
</head>
<body>

<div id="map"></div>

<script>
function initMap(){
    var lokasi = {lat:-6.305, lng:107.296};
    var map = new google.maps.Map(document.getElementById("map"), {
        zoom: 12,
        center: lokasi
    });
}
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCEi7fn9HvcN8sGH3AlI6NlVQJrFGE1oJs&callback=initMap" async defer></script>

</body>
</html>
