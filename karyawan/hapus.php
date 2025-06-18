<?php
session_start();
include '../koneksi.php';

// Cek otorisasi, pastikan pengguna sudah login
if ($_SESSION['status'] != "login") {
    header("location:../login.php?pesan=belum_login");
    exit();
}

// Cek apakah ada ID yang dikirimkan
if (isset($_GET['id'])) {
    $id_karyawan = $_GET['id'];

    // Buat query untuk menghapus data
    $query = "DELETE FROM karyawan WHERE id_karyawan = '$id_karyawan'";

    if (mysqli_query($koneksi, $query)) {
        // Jika berhasil, redirect kembali ke halaman data.php dengan pesan sukses
        echo "<script>alert('Data karyawan berhasil dihapus!'); window.location.href='data.php';</script>";
    } else {
        // Jika gagal, tampilkan pesan error
        echo "<script>alert('Gagal menghapus data: " . mysqli_error($koneksi) . "'); window.location.href='data.php';</script>";
    }
} else {
    // Jika tidak ada ID, redirect kembali
    header("Location: data.php");
}
?>