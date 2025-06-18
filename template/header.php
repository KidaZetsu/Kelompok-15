<?php
// koneksi.php sudah mendefinisikan BASE_URL, jadi kita panggil sebelum session_start
// Ini juga akan memastikan koneksi ada untuk semua halaman
include_once __DIR__ . '/../koneksi.php'; 

session_start();

// Cek apakah pengguna sudah login, jika belum, lempar ke halaman login
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    // Gunakan BASE_URL untuk redirect yang pasti benar
    header("location:" . BASE_URL . "login.php?pesan=belum_login");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - Sistem Absensi BDL</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
</head>
<body>
    <div class="container">
        <?php include 'sidebar.php'; ?>
        <div class="main-content">
            <header>
                <h2><?php echo $page_title; ?></h2>
            </header>
            <main>