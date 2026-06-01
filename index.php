<!DOCTYPE html>
<html>
<head>
<title>Sistem Pencarian Lokasi Terdekat</title>

<style>
body{
font-family: Arial;
margin:0;
background:#f4f6f9;
}

/* HEADER */
.header{
background:#2c3e50;
color:white;
padding:15px;
font-size:20px;
}

/* LAYOUT */
.container{
display:flex;
}

/* SIDEBAR */
.sidebar{
width:220px;
background:#34495e;
height:100vh;
color:white;
}

.sidebar a{
display:block;
padding:15px;
color:white;
text-decoration:none;
}

.sidebar a:hover{
background:#2c3e50;
}

/* CONTENT */
.content{
flex:1;
padding:30px;
}

/* CARD */
.card{
background:white;
padding:20px;
border-radius:10px;
box-shadow:0 2px 10px rgba(0,0,0,0.1);
margin-bottom:20px;
}

/* INPUT */
input{
width:100%;
padding:10px;
margin:10px 0;
border:1px solid #ddd;
border-radius:5px;
}

/* BUTTON */
button{
padding:10px 15px;
border:none;
border-radius:5px;
cursor:pointer;
}

.btn-primary{
background:#3498db;
color:white;
}

.btn-success{
background:#27ae60;
color:white;
}
</style>
</head>

<body>

<div class="header">
SISTEM PENCARIAN LOKASI TERDEKAT
</div>

<div class="container">
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

<div class="card">
<h2>Cari Lokasi Terdekat</h2>

<form action="proses_haversine.php" method="POST">

<label>Latitude</label>
<input type="text" id="lat" name="latitude" required>

<label>Longitude</label>
<input type="text" id="lng" name="longitude" required>

<button type="button" class="btn-primary" onclick="getLocation()">
Ambil Lokasi Saya
</button>

<button type="submit" class="btn-success">
Cari Lokasi Terdekat
</button>

</form>
</div>

<div class="card">
<h3>Status Sistem</h3>
<p>✅ Sistem aktif</p>
<p>✅ GPS terhubung</p>
<p>✅ Database terkoneksi</p>
</div>

</div>
</div>

<script>
function getLocation(){
if(navigator.geolocation){
navigator.geolocation.getCurrentPosition(function(position){
document.getElementById("lat").value = position.coords.latitude;
document.getElementById("lng").value = position.coords.longitude;
});
}else{
alert("Browser tidak mendukung GPS");
}
}
</script>

</body>
</html>



