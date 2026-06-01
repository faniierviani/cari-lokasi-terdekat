<?php
session_start();
include "config/koneksi.php";

if(!isset($_SESSION['username'])){
    header("Location: login_admin.php");
    exit;
}

/* =========================
   TAMBAH DATA
========================= */
if(isset($_POST['simpan'])){

    mysqli_query($koneksi,"
    INSERT INTO tbl_wisata
    (nama, latitude, longitude)

    VALUES(
    '$_POST[nama]',
    '$_POST[latitude]',
    '$_POST[longitude]'
    )
    ");

    header("Location:data_lokasi.php");
}

/* =========================
   HAPUS DATA
========================= */
if(isset($_GET['hapus'])){

    mysqli_query($koneksi,
    "DELETE FROM tbl_wisata
    WHERE id='$_GET[hapus]'");

    header("Location:data_lokasi.php");
}

/* =========================
   EDIT DATA
========================= */
if(isset($_POST['update'])){

    mysqli_query($koneksi,"
    UPDATE tbl_wisata SET

    nama='$_POST[nama]',
    latitude='$_POST[latitude]',
    longitude='$_POST[longitude]'

    WHERE id='$_POST[id]'
    ");

    header("Location:data_lokasi.php");
}

/* =========================
   AMBIL DATA EDIT
========================= */
$edit = null;

if(isset($_GET['edit'])){

$qEdit = mysqli_query($koneksi,
"SELECT * FROM tbl_wisata
WHERE id='$_GET[edit]'");

$edit = mysqli_fetch_assoc($qEdit);

}
?>

<!DOCTYPE html>
<html>
<head>
<title>Data Lokasi</title>

<style>

body{
margin:0;
font-family:Arial;
background:#f4f6f9;
display:flex;
}

/* SIDEBAR */
.sidebar{
width:220px;
height:100vh;
background:#1e293b;
padding:20px;
color:white;
position:fixed;
}

.sidebar h2{
margin-bottom:30px;
}

.sidebar a{
display:block;
color:white;
text-decoration:none;
padding:12px;
margin-bottom:10px;
border-radius:8px;
transition:.3s;
}

.sidebar a:hover{
background:#334155;
}

/* CONTENT */
.content{
margin-left:240px;
padding:30px;
width:100%;
}

/* CARD */
.card{
background:white;
padding:25px;
border-radius:15px;
box-shadow:0 6px 15px rgba(0,0,0,0.08);
margin-bottom:25px;
}

/* FORM */
form input{
width:100%;
padding:12px;
margin-bottom:15px;
border:1px solid #ccc;
border-radius:8px;
}

form button{
padding:12px 20px;
background:#3b82f6;
color:white;
border:none;
border-radius:8px;
cursor:pointer;
}

/* TABLE */
table{
width:100%;
border-collapse:collapse;
}

table th, table td{
padding:12px;
border-bottom:1px solid #ddd;
}

table th{
background:#f1f5f9;
}

/* BUTTON */
.btn-edit{
background:#f59e0b;
padding:8px 12px;
color:white;
border-radius:6px;
text-decoration:none;
}

.btn-hapus{
background:#ef4444;
padding:8px 12px;
color:white;
border-radius:6px;
text-decoration:none;
}

</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">

<h2>📍 Sistem Geografis</h2>

<a href="dashboard.php">🏠 Dashboard</a>
<a href="data_lokasi.php">📌 Data Lokasi</a>
<a href="index.php">🔎 Cari Lokasi</a>
<a href="logout.php">🚪 Logout</a>

</div>

<!-- CONTENT -->
<div class="content">

<!-- FORM -->
<div class="card">

<h2>
<?= $edit ? 'Edit Lokasi' : 'Tambah Lokasi'; ?>
</h2>

<form method="POST">

<input type="hidden"
name="id"
value="<?= $edit['id'] ?? '' ?>">

<input
type="text"
name="nama"
placeholder="Nama Lokasi"
required
value="<?= $edit['nama'] ?? '' ?>">

<input
type="text"
name="latitude"
placeholder="Latitude"
required
value="<?= $edit['latitude'] ?? '' ?>">

<input
type="text"
name="longitude"
placeholder="Longitude"
required
value="<?= $edit['longitude'] ?? '' ?>">

<button
name="<?= $edit ? 'update' : 'simpan'; ?>">

<?= $edit ? 'Update Data' : 'Simpan Data'; ?>

</button>

</form>

</div>

<!-- TABLE -->
<div class="card">

<h2>Daftar Lokasi</h2>

<table>

<tr>
<th>No</th>
<th>Nama</th>
<th>Latitude</th>
<th>Longitude</th>
<th>Aksi</th>
</tr>

<?php
$no=1;

$q = mysqli_query($koneksi,
"SELECT * FROM tbl_wisata");

while($d = mysqli_fetch_assoc($q)){
?>

<tr>

<td><?= $no++ ?></td>

<td><?= $d['nama']; ?></td>

<td><?= $d['latitude']; ?></td>

<td><?= $d['longitude']; ?></td>

<td>

<a class="btn-edit"
href="?edit=<?= $d['id']; ?>">
Edit
</a>

<a class="btn-hapus"
href="?hapus=<?= $d['id']; ?>"
onclick="return confirm('Hapus data ini?')">
Hapus
</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>
</html>