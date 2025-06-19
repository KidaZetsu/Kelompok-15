<?php

define('BASE_URL', 'http://localhost/Kelompok15_AbsensiKaryawan/');

$hostname = "localhost";
$username = "root"; 
$password = "";     
$database = "absensi"; 


$koneksi = mysqli_connect($hostname, $username, $password, $database);


if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>