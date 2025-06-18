<?php
$page_title = "Data Absensi Hari Ini";
include '../template/header.php';



$tanggal_hari_ini = date("Y-m-d");


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['absen_masuk'])) {
        $id_karyawan = $_POST['id_karyawan'];
        $waktu_masuk = date("H:i:s");

      
        $cek_query = "SELECT * FROM absensi WHERE id_karyawan = '$id_karyawan' AND tanggal_absensi = '$tanggal_hari_ini'";
        $cek_result = mysqli_query($koneksi, $cek_query);

        if (mysqli_num_rows($cek_result) == 0) {
            
            $insert_query = "INSERT INTO absensi (id_karyawan, tanggal_absensi, waktu_masuk, status_kehadiran) 
                             VALUES ('$id_karyawan', '$tanggal_hari_ini', '$waktu_masuk', 'Hadir')";
            mysqli_query($koneksi, $insert_query);
        }
        
        header("Location: data.php");
        exit();

    } elseif (isset($_POST['absen_keluar'])) {
        $id_karyawan = $_POST['id_karyawan'];
        $waktu_keluar = date("H:i:s");

     
        $update_query = "UPDATE absensi SET waktu_keluar = '$waktu_keluar' 
                         WHERE id_karyawan = '$id_karyawan' AND tanggal_absensi = '$tanggal_hari_ini'";
        mysqli_query($koneksi, $update_query);
        
        header("Location: data.php");
        exit();
    }
}
// ... (kode PHP di bagian atas tetap sama) ...
?>

<div class="content">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <h4>Tanggal: <?php echo date("d F Y", strtotime($tanggal_hari_ini)); ?></h4>
        <a href="tambah_ketidakhadiran.php" class="btn btn-info">Input Izin / Sakit</a>
    </div>
    
    <table class="data-table">
        <thead>
            </thead>
        <tbody>
            <?php
            // Query untuk mengambil semua karyawan aktif dan data absensi mereka hari ini
            // Query diubah sedikit untuk mengambil status dan keterangan
            $query = "SELECT k.id_karyawan, k.nama_lengkap, j.nama_jabatan, 
                             a.waktu_masuk, a.waktu_keluar, a.status_kehadiran, a.keterangan
                      FROM karyawan k
                      JOIN jabatan j ON k.id_jabatan = j.id_jabatan
                      LEFT JOIN absensi a ON k.id_karyawan = a.id_karyawan AND a.tanggal_absensi = '$tanggal_hari_ini'
                      WHERE k.status_karyawan = 'Aktif'
                      ORDER BY k.nama_lengkap ASC";
            
            $result = mysqli_query($koneksi, $query);
            $no = 1;

            while ($data = mysqli_fetch_assoc($result)) {
            ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($data['nama_lengkap']); ?></td>
                    <td><?php echo htmlspecialchars($data['nama_jabatan']); ?></td>
                    <td><?php echo $data['waktu_masuk'] ? $data['waktu_masuk'] : '-'; ?></td>
                    <td><?php echo $data['waktu_keluar'] ? $data['waktu_keluar'] : '-'; ?></td>
                    <td>
                        <?php // --- BLOK STATUS BARU ---
                        if ($data['status_kehadiran'] == 'Hadir') {
                            echo "<span class='status-hadir'>Hadir</span>";
                        } elseif ($data['status_kehadiran'] == 'Izin') {
                            echo "<span class='status-izin'>Izin</span>";
                        } elseif ($data['status_kehadiran'] == 'Sakit') {
                            echo "<span class='status-sakit'>Sakit</span>";
                        } else {
                            echo "<span class='status-alpha'>Alpha</span>";
                        }
                        ?>
                    </td>
                    <td>
                        <?php // --- BLOK AKSI BARU ---
                        // Tombol hanya muncul jika statusnya bukan Izin atau Sakit
                        if ($data['status_kehadiran'] != 'Izin' && $data['status_kehadiran'] != 'Sakit') {
                        ?>
                            <form method="post" action="data.php" style="display:inline;">
                                <input type="hidden" name="id_karyawan" value="<?php echo $data['id_karyawan']; ?>">
                                <?php if (!$data['waktu_masuk']) { ?>
                                    <button type="submit" name="absen_masuk" class="btn btn-success btn-sm">Absen Masuk</button>
                                <?php } elseif (!$data['waktu_keluar']) { ?>
                                    <button type="submit" name="absen_keluar" class="btn btn-warning btn-sm">Absen Keluar</button>
                                <?php } else { ?>
                                    <span class="status-selesai">Selesai</span>
                                <?php } ?>
                            </form>
                        <?php
                        } else {
                            // Jika Izin atau Sakit, tampilkan keterangan
                            echo "<small><i>" . htmlspecialchars($data['keterangan']) . "</i></small>";
                        }
                        ?>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<?php include '../template/footer.php'; ?>