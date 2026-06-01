<?php
include "config/koneksi.php";

mysqli_query($koneksi,"
INSERT INTO lokasi (nama_lokasi,latitude,longitude)
VALUES('$_POST[nama_lokasi]','$_POST[latitude]','$_POST[longitude]')
");

header("Location: dashboard.php");
