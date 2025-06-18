<?php

session_start();


include 'koneksi.php';


$username = $_POST['username'];
$password = $_POST['password'];


$query = "SELECT * FROM pengguna WHERE username='" . mysqli_real_escape_string($koneksi, $username) . "'";
$result = mysqli_query($koneksi, $query);


$cek = mysqli_num_rows($result);

if ($cek > 0) {
    $data = mysqli_fetch_assoc($result);

    
    if ($password == $data['password']) {
        
        $_SESSION['id_pengguna'] = $data['id_pengguna'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['nama_pengguna'] = $data['nama_pengguna'];
        $_SESSION['level_akses'] = $data['level_akses'];
        $_SESSION['status'] = "login";

       
        header("Location: dashboard.php");
        exit();
    }
}


header("Location: login.php?pesan=gagal");
exit();
?>