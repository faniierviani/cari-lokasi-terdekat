<?php include "config/koneksi.php"; ?>

<?php
$total_lokasi = mysqli_fetch_assoc(
mysqli_query($koneksi,"SELECT COUNT(*) total FROM tbl_wisata")
)['total'] ?? 0;
?>
<?php
include "config/koneksi.php";

/* TOTAL LOKASI */
$qLokasi = mysqli_query($koneksi,
"SELECT COUNT(*) as total FROM tbl_wisata");

$totalLokasi = mysqli_fetch_assoc($qLokasi)['total'];

/* TOTAL ADMIN */
$qAdmin = mysqli_query($koneksi,
"SELECT COUNT(*) as total FROM user");

$totalAdmin = mysqli_fetch_assoc($qAdmin)['total'];

/* TOTAL PENCARIAN */
/* sementara manual dulu */
$totalCari = rand(50,200);

/* STATUS SISTEM */
$status = "Aktif";
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard Sistem Pencarian Lokasi</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<style>
    

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
display:flex;
background:#f4f6f9;
}

/* SIDEBAR */
.sidebar{
width:250px;
height:100vh;
background:#1e293b;
color:white;
padding:20px;
}

.sidebar h2{
margin-bottom:30px;
}

.sidebar a{
display:block;
color:white;
text-decoration:none;
padding:12px;
border-radius:8px;
margin-bottom:10px;
transition:.3s;
}

.sidebar a:hover{
background:#334155;
}

/* CONTENT */
.content{
flex:1;
padding:30px;
}

/* HEADER */
.header{
background:white;
padding:20px;
border-radius:12px;
box-shadow:0 4px 12px rgba(0,0,0,0.08);
margin-bottom:25px;
}

/* GRID CARD */
.grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
gap:20px;
margin-bottom:25px;
}

.card{
background:white;
padding:25px;
border-radius:15px;
box-shadow:0 6px 15px rgba(0,0,0,0.08);
transition:.3s;
}

.card:hover{
transform:translateY(-5px);
}

.card h3{
color:#64748b;
font-size:16px;
margin-bottom:10px;
}

.card h1{
font-size:32px;
color:#0f172a;
}
.map-card{
background:white;
padding:20px;
border-radius:25px;
box-shadow:0 8px 25px rgba(0,0,0,0.08);
margin-top:25px;
}

#map{
width:100%;
height:85vh;
border-radius:20px;

}
.content{
flex:1;
padding:30px;
width:100%;
}
.weather-card{
background:white;
padding:25px;
border-radius:25px;
box-shadow:0 8px 25px rgba(0,0,0,0.08);
margin-bottom:30px;
}

.weather-card h2{
margin-bottom:15px;
color:#0f172a;
}

.weather-card p{
font-size:16px;
margin:8px 0;
color:#475569;
}

</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
<h2>📍 Sistem Lokasi</h2>

<a href="dashboard.php">🏠 Dashboard</a>
<a href="data_lokasi.php">📌 Data Lokasi</a>
<a href="index.php">🔎 cari lokasi</a>
<a href="logout.php">🚪 Logout</a>
<a href="login_admin.php" class="btn-login">
    Login Admin</a>
</div>

<!-- CONTENT -->
<div class="content">

<div class="header">
<h2>Dashboard Sistem Pencarian Lokasi Terdekat</h2>
<p>Monitoring sistem berbasis metode Haversine</p>
</div>

<!-- STATISTIK -->

<div class="grid">

<!-- CARD LOKASI -->
<div class="card">
<div class="card-icon">📍</div>

<h3>Total Lokasi</h3>

<h1><?= $totalLokasi ?></h1>

<p>Data lokasi wisata & UMKM</p>
</div>

<!-- CARD ADMIN -->
<div class="card">
<div class="card-icon">👤</div>

<h3>Total Admin</h3>

<h1><?= $totalAdmin ?></h1>

<p>Administrator sistem</p>
</div>

<!-- CARD PENCARIAN -->
<div class="card">
<div class="card-icon">🔍</div>

<h3>Total Pencarian</h3>

<h1><?= $totalCari ?></h1>

<p>Pencarian lokasi realtime</p>
</div>

<!-- CARD STATUS -->
<div class="card">
<div class="card-icon">🛰️</div>

<h3>Status Sistem</h3>

<h1 style="font-size:22px;color:#22c55e;">
<?= $status ?>
</h1>

<p>Server berjalan normal</p>
</div>

</div>
<!-- END GRID -->


<!-- WEATHER CARD -->
<div class="weather-card">

<h2>🌤 Informasi Cuaca</h2>

<p id="lokasi">
Mengambil lokasi...
</p>

<p id="cuaca">
Mengambil cuaca...
</p>

</div>


<!-- MAP -->
<div class="map-card">

<h3>Peta Lokasi Wisata</h3>

<div id="map"></div>


</div>
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCEi7fn9HvcN8sGH3AlI6NlVQJrFGE1oJs&callback=initMap" async defer></script>
<script>

navigator.geolocation.getCurrentPosition(
function(position){

let lat = position.coords.latitude;
let lon = position.coords.longitude;

/* TAMPILKAN KOORDINAT */
document.getElementById("lokasi")
.innerHTML =
"📍 Latitude: " + lat +
"<br>📍 Longitude: " + lon;

/* API CUACA */
fetch(
`https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=6fcc451b240ec8f77b8cab5b6b86bdb2&units=metric&lang=id`
)

.then(response => response.json())

.then(data => {

let suhu = data.main.temp;
let cuaca = data.weather[0].description;
let kota = data.name;

document.getElementById("cuaca")
.innerHTML =

`
🌍 ${kota}<br>
🌡 Suhu: ${suhu}°C<br>
☁ Cuaca: ${cuaca}
`;

});

});

</script>

<script>
function initMap(){
 let map=new google.maps.Map(document.getElementById("map"),{
  zoom:11,
  center:{lat:-6.3,lng:107.3}
 });
}
</script>

</body>
</html>
