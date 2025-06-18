<?php
$page_title = "Tambah Keterangan Tidak Hadir";
include '../template/header.php';


// Logika untuk memproses form saat disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_karyawan = $_POST['id_karyawan'];
    $tanggal_absensi = $_POST['tanggal_absensi'];
    $status_kehadiran = $_POST['status_kehadiran'];
    $keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);

    // Cek apakah sudah ada data absensi untuk karyawan ini di tanggal yang sama
    $cek_query = "SELECT id_absensi FROM absensi WHERE id_karyawan = '$id_karyawan' AND tanggal_absensi = '$tanggal_absensi'";
    $cek_result = mysqli_query($koneksi, $cek_query);

    if (mysqli_num_rows($cek_result) > 0) {
        // Jika sudah ada, UPDATE data yang ada
        $data = mysqli_fetch_assoc($cek_result);
        $id_absensi = $data['id_absensi'];
        $query = "UPDATE absensi SET status_kehadiran = '$status_kehadiran', keterangan = '$keterangan', waktu_masuk = NULL, waktu_keluar = NULL WHERE id_absensi = '$id_absensi'";
    } else {
        // Jika belum ada, INSERT data baru
        $query = "INSERT INTO absensi (id_karyawan, tanggal_absensi, status_kehadiran, keterangan) VALUES ('$id_karyawan', '$tanggal_absensi', '$status_kehadiran', '$keterangan')";
    }

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data keterangan berhasil disimpan!'); window.location.href='data.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan data: " . mysqli_error($koneksi) . "');</script>";
    }
}
?>

<div class="content">
    <form action="tambah_ketidakhadiran.php" method="post" class="form-input">
        <div class="form-group">
            <label for="id_karyawan">Pilih Karyawan</label>
            <select id="id_karyawan" name="id_karyawan" required>
                <option value="">-- Pilih Karyawan --</option>
                <?php
                // Mengambil data karyawan aktif
                $query_karyawan = "SELECT id_karyawan, nama_lengkap FROM karyawan WHERE status_karyawan = 'Aktif' ORDER BY nama_lengkap";
                $result_karyawan = mysqli_query($koneksi, $query_karyawan);
                while ($karyawan = mysqli_fetch_assoc($result_karyawan)) {
                    echo "<option value='" . $karyawan['id_karyawan'] . "'>" . htmlspecialchars($karyawan['nama_lengkap']) . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="tanggal_absensi">Tanggal</label>
            <input type="date" id="tanggal_absensi" name="tanggal_absensi" value="<?php echo date('Y-m-d'); ?>" required>
        </div>
        <div class="form-group">
            <label for="status_kehadiran">Status Kehadiran</label>
            <select id="status_kehadiran" name="status_kehadiran" required>
                <option value="Izin">Izin</option>
                <option value="Sakit">Sakit</option>
            </select>
        </div>
        <div class="form-group">
            <label for="keterangan">Keterangan (Alasan)</label>
            <textarea id="keterangan" name="keterangan" rows="3"></textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Simpan Keterangan</button>
            <a href="data.php" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<?php include '../template/footer.php'; ?>