<?php
include "config/koneksi.php";

/* ===============================
   VALIDASI INPUT
=================================*/
if(!isset($_POST['latitude']) || !isset($_POST['longitude'])){
    die("Lokasi belum diisi");
}

$lat = $_POST['latitude'];
$lng = $_POST['longitude'];

/* ===============================
   HITUNG LOKASI TERDEKAT
=================================*/
$query = mysqli_query($koneksi, "
SELECT *,
(6371 * acos(
cos(radians($lat)) *
cos(radians(latitude)) *
cos(radians(longitude) - radians($lng)) +
sin(radians($lat)) *
sin(radians(latitude))
)) AS jarak
FROM lokasi
ORDER BY jarak ASC
");

/* lokasi terdekat */
$data = mysqli_fetch_assoc($query);

/* ambil semua lokasi */
mysqli_data_seek($query, 0);


$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html>
<head>
<title>Navigasi Lokasi Terdekat</title>

<style>
body{
    margin:0;
    font-family:Arial, sans-serif;
    display:flex;
}

/* ===============================
   SIDEBAR
=================================*/
.sidebar{
    width:300px;
    height:100vh;
    background:#1e293b;
    color:white;
    padding:20px;
    box-sizing:border-box;
    overflow:auto;
}

.sidebar h2{
    margin-top:0;
    text-align:center;
    color:#38bdf8;
}

.sidebar .card{
    background:#334155;
    padding:15px;
    border-radius:10px;
    margin-bottom:15px;
}

.sidebar p{
    margin:8px 0;
    font-size:14px;
}

.sidebar .rumus{
    background:#0f172a;
    padding:10px;
    border-radius:8px;
    font-size:13px;
    line-height:1.6;
    overflow:auto;
}
.btn-kembali,
.btn-rute{
    display:block;
    width:100%;
    padding:12px;
    margin-bottom:10px;
    border:none;
    border-radius:8px;
    text-decoration:none;
    text-align:center;
    font-weight:bold;
    cursor:pointer;
    box-sizing:border-box;
}

.btn-kembali{
    background:#38bdf8;
    color:white;
}

.btn-rute{
    background:#22c55e;
    color:white;
}

/* ===============================
   MAP AREA
=================================*/
.main{
    flex:1;
    position:relative;
}

#map{
    height:100vh;
    width:100%;
}

/* ===============================
   TOP BAR
=================================*/
.top-bar{
    position:fixed;
    top:20px;
    left:55%;
    transform:translateX(-50%);
    background:white;
    padding:12px 20px;
    border-radius:10px;
    box-shadow:0 4px 10px rgba(0,0,0,0.2);
    z-index:999;
    font-weight:bold;
}

/* ===============================
   INFO PANEL
=================================*/
.info-panel{
    position:fixed;
    bottom:0;
    left:300px;
    right:0;
    background:white;
    padding:20px;
    box-shadow:0 -3px 15px rgba(0,0,0,0.2);
    border-radius:20px 20px 0 0;
}

.info-panel h3{
    margin:0;
    color:#2c3e50;
}

.info-panel p{
    margin:5px 0;
}
</style>
</head>

<body>

<!-- ===============================
     SIDEBAR
===================================-->
<div class="sidebar">

    <h2>Metode Haversine</h2><a href="dashboard.php" class="btn-kembali">
    ⬅️ Kembali Dashboard
</a>

<button onclick="tampilkanRute()" class="btn-rute">
    🛣️ Tampilkan Rute
</button>


    <div class="card">
        <p><b>Latitude User:</b></p>
        <p><?php echo $lat; ?></p>

        <p><b>Longitude User:</b></p>
        <p><?php echo $lng; ?></p>
    </div>

    <div class="card">
        <p><b>Lokasi Tujuan:</b></p>
        <p><?php echo $data['nama_lokasi']; ?></p>

        <p><b>Latitude Tujuan:</b></p>
        <p><?php echo $data['latitude']; ?></p>

        <p><b>Longitude Tujuan:</b></p>
        <p><?php echo $data['longitude']; ?></p>
    </div>

    <div class="card">
        <p><b>Hasil Perhitungan:</b></p>
        <p>Jarak terdekat:</p>
        <h3><?php echo round($data['jarak'],2); ?> KM</h3>
    </div>

    <div class="card">
        <p><b>Rumus Haversine:</b></p>

        <div class="rumus">
            d = 6371 × acos( <br>
            cos(radians(lat1)) × <br>
            cos(radians(lat2)) × <br>
            cos(radians(lon2) - radians(lon1)) + <br>
            sin(radians(lat1)) × <br>
            sin(radians(lat2)) <br>
            )
        </div>
    </div>

</div>

<!-- ===============================
     MAP AREA
===================================-->
<div class="main">

<div class="top-bar">
    📍 Navigasi Lokasi Terdekat
</div>

<div id="map"></div>

<div class="info-panel">
    <h3><?php echo $data['nama_lokasi']; ?></h3>
    <p>Jarak: <?php echo round($data['jarak'],2); ?> km</p>
    <p id="waktu">Menghitung estimasi waktu...</p>
</div>

</div>

<script>
function initMap(){

    /* ===============================
       LOKASI USER & TUJUAN
    =================================*/
    let lokasiUser = {
        lat: <?php echo $lat; ?>,
        lng: <?php echo $lng; ?>
    };

    let lokasiTujuan = {
        lat: <?php echo $data['latitude']; ?>,
        lng: <?php echo $data['longitude']; ?>
    };

    /* ===============================
       BUAT MAP
    =================================*/
    let map = new google.maps.Map(document.getElementById('map'),{
        zoom:14,
        center: lokasiUser
    });

    /* ===============================
       ROUTE SERVICE
    =================================*/
    const directionsService = new google.maps.DirectionsService();

    const directionsRenderer = new google.maps.DirectionsRenderer({
        suppressMarkers:false
    });

    directionsRenderer.setMap(map);

    /* ===============================
       HITUNG RUTE
    =================================*/
    directionsService.route({
        origin: lokasiUser,
        destination: lokasiTujuan,
        travelMode:"DRIVING"
    }, function(result, status){

        if(status === "OK"){

            directionsRenderer.setDirections(result);

            let durasi =
            result.routes[0].legs[0].duration.text;

            document.getElementById("waktu").innerHTML =
                "Estimasi waktu: " + durasi;

        } else {

            document.getElementById("waktu").innerHTML =
                "Rute tidak ditemukan";
        }
    });
}
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCEi7fn9HvcN8sGH3AlI6NlVQJrFGE1oJs&callback=initMap" async defer></script>

</body>
</html>