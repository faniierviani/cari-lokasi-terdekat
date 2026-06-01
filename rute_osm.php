<?php
include "config/koneksi.php";

if(!isset($_POST['latitude']) || !isset($_POST['longitude'])){
    die("Lokasi belum diisi");
}

$lat_user = $_POST['latitude'];
$lng_user = $_POST['longitude'];

/* HAVERSINE */
$query = mysqli_query($koneksi,"
SELECT *,
(6371 * acos(
cos(radians($lat_user)) *
cos(radians(latitude)) *
cos(radians(longitude) - radians($lng_user)) +
sin(radians($lat_user)) *
sin(radians(latitude))
)) AS jarak
FROM lokasi
ORDER BY jarak ASC
LIMIT 1
");

$data = mysqli_fetch_assoc($query);

$lat_tujuan = $data['latitude'];
$lng_tujuan = $data['longitude'];
$nama = $data['nama_lokasi'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Rute Lokasi Terdekat</title>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<style>
#map{height:500px;}
body{font-family:Arial;}
</style>
</head>

<body>

<h2>Lokasi Terdekat: <?= $nama ?></h2>

<div id="map"></div>

<script>

let latUser = <?= $lat_user ?>;
let lngUser = <?= $lng_user ?>;
let latTujuan = <?= $lat_tujuan ?>;
let lngTujuan = <?= $lng_tujuan ?>;

let map = L.map('map').setView([latUser, lngUser], 13);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

L.marker([latUser,lngUser]).addTo(map).bindPopup("Lokasi Anda");
L.marker([latTujuan,lngTujuan]).addTo(map).bindPopup("<?= $nama ?>");

/* ROUTE OSRM */
fetch(`https://router.project-osrm.org/route/v1/driving/${lngUser},${latUser};${lngTujuan},${latTujuan}?overview=full&geometries=geojson`)
.then(res=>res.json())
.then(data=>{
    if(data.routes.length>0){
        let route = L.geoJSON(data.routes[0].geometry).addTo(map);
        map.fitBounds(route.getBounds());
    }else{
        alert("Rute tidak ditemukan");
    }
})
.catch(()=>alert("Gagal mengambil rute"));

</script>

</body>
</html>

