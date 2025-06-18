<?php
$page_title = "Dashboard"; 
include 'template/header.php'; 
?>

<div class="content">
    <h3>Selamat Datang, <?php echo $_SESSION['nama_pengguna']; ?>!</h3>
    <p>Anda login sebagai <strong><?php echo $_SESSION['level_akses']; ?></strong>.</p>
    <p>Ini adalah halaman utama sistem informasi absensi karyawan Bengkel BDL.</p>
    
    <div class="dashboard-stats">
        <div class="stat-card">
            <h4>Total Karyawan Aktif</h4>
            <p>15</p> </div>
        <div class="stat-card">
            <h4>Hadir Hari Ini</h4>
            <p>12</p> </div>
        <div class="stat-card">
            <h4>Izin/Sakit Hari Ini</h4>
            <p>3</p> </div>
    </div>
</div>

<?php
include 'template/footer.php'; // Menampilkan footer
?>