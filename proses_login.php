<?php

session_start();


include 'koneksi.php';


$username = mysqli_real_escape_string($koneksi, $_POST['username']);
$password = mysqli_real_escape_string($koneksi, $_POST['password']);


$query = "SELECT * FROM pengguna WHERE username='$username'";
$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_assoc($result);


if ($data && password_verify($password, $data['password'])) {
    
    $_SESSION['id_pengguna'] = $data['id_pengguna'];
    $_SESSION['username'] = $data['username'];
    $_SESSION['nama_pengguna'] = $data['nama_pengguna'];
    $_SESSION['level_akses'] = $data['level_akses'];
    $_SESSION['status'] = "login"; 

    
    header("Location: dashboard.php");
    exit(); 
} else {
    
    header("Location: login.php?pesan=gagal");
    exit();
}
?>