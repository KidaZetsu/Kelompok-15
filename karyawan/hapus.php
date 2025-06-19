<?php
session_start();
include '../koneksi.php';


if ($_SESSION['status'] != "login") {
    header("location:../login.php?pesan=belum_login");
    exit();
}


if (isset($_GET['id'])) {
    $id_karyawan = $_GET['id'];

   
    $query = "DELETE FROM karyawan WHERE id_karyawan = '$id_karyawan'";

    if (mysqli_query($koneksi, $query)) {
        
        echo "<script>alert('Data karyawan berhasil dihapus!'); window.location.href='data.php';</script>";
    } else {
       
        echo "<script>alert('Gagal menghapus data: " . mysqli_error($koneksi) . "'); window.location.href='data.php';</script>";
    }
} else {
    
    header("Location: data.php");
}
?>