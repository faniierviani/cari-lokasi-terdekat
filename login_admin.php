<?php
session_start();
include "config/koneksi.php";

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $q = mysqli_query($koneksi,
    "SELECT * FROM user
    WHERE username='$username'
    AND password='$password'");

    if(mysqli_num_rows($q) > 0){

        $d = mysqli_fetch_assoc($q);

        $_SESSION['user'] = $d['user'];
        $_SESSION['username'] = $d['username'];

        header("Location: data_lokasi.php");
        exit;

    } else {

        $error = "Username atau Password Salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login Sistem Pencarian Lokasi</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins', sans-serif;
}

body{
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:
    linear-gradient(
    135deg,
    #0f172a,
    #1e3a8a,
    #2563eb
    );

    overflow:hidden;
    position:relative;
}

/* ===============================
   BACKGROUND CIRCLE
=================================*/

.circle1,
.circle2{
    position:absolute;
    border-radius:50%;
    filter:blur(80px);
}

.circle1{
    width:300px;
    height:300px;
    background:#38bdf8;
    top:-80px;
    left:-80px;
}

.circle2{
    width:350px;
    height:350px;
    background:#60a5fa;
    bottom:-100px;
    right:-100px;
}

/* ===============================
   LOGIN BOX
=================================*/

.login-container{
    width:400px;
    background:rgba(255,255,255,0.1);
    backdrop-filter:blur(20px);
    border:1px solid rgba(255,255,255,0.2);
    padding:40px;
    border-radius:25px;
    box-shadow:0 8px 30px rgba(0,0,0,0.3);
    color:white;
    z-index:10;
    animation:fadeIn 1s ease;
}

/* ===============================
   ANIMASI
=================================*/

@keyframes fadeIn{
    from{
        opacity:0;
        transform:translateY(30px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

/* ===============================
   TITLE
=================================*/

.login-container h1{
    text-align:center;
    font-size:30px;
    margin-bottom:10px;
}

.login-container p{
    text-align:center;
    color:#dbeafe;
    margin-bottom:30px;
    font-size:14px;
}

/* ===============================
   INPUT
=================================*/

.input-group{
    margin-bottom:20px;
}

.input-group label{
    display:block;
    margin-bottom:8px;
    font-size:14px;
}

.input-group input{
    width:100%;
    padding:14px;
    border:none;
    border-radius:12px;
    background:rgba(255,255,255,0.15);
    color:white;
    font-size:15px;
    outline:none;
    transition:0.3s;
}

.input-group input::placeholder{
    color:#dbeafe;
}

.input-group input:focus{
    background:rgba(255,255,255,0.25);
    transform:scale(1.02);
}

/* ===============================
   BUTTON
=================================*/

.login-btn{
    width:100%;
    padding:14px;
    border:none;
    border-radius:12px;
    background:#38bdf8;
    color:white;
    font-size:16px;
    font-weight:600;
    cursor:pointer;
    transition:0.3s;
}

.login-btn:hover{
    background:#0ea5e9;
    transform:translateY(-2px);
    box-shadow:0 6px 15px rgba(0,0,0,0.2);
}

/* ===============================
   ERROR
=================================*/

.error{
    background:#ef4444;
    padding:12px;
    border-radius:10px;
    text-align:center;
    margin-bottom:20px;
    font-size:14px;
}

/* ===============================
   FOOTER
=================================*/

.footer{
    margin-top:25px;
    text-align:center;
    font-size:12px;
    color:#dbeafe;
}

</style>
</head>

<body>

<div class="circle1"></div>
<div class="circle2"></div>

<div class="login-container">

    <h1>🔐 Login Admin</h1>

    <p>
        Sistem Informasi Geografis
        Pencarian Lokasi Terdekat
    </p>

    <?php
    if(isset($error)){
        echo "<div class='error'>$error</div>";
    }
    ?>

    <form method="POST">

        <div class="input-group">
            <label>Username</label>

            <input
            type="text"
            name="username"
            placeholder="Masukkan Username"
            required>
        </div>

        <div class="input-group">
            <label>Password</label>

            <input
            type="password"
            name="password"
            placeholder="Masukkan Password"
            required>
        </div>

        <button type="submit"
        name="login"
        class="login-btn">

        Login Sekarang

        </button>

    </form>

    <div class="footer">
        © 2026 Sistem Pencarian Lokasi Terdekat
    </div>

</div>

</body>
</html>