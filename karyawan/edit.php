<?php
$page_title = "Edit Karyawan";
include '../template/header.php';


// --- LOGIKA UNTUK PROSES UPDATE DATA (Method: POST) ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil semua data dari form
    $id_karyawan = $_POST['id_karyawan'];
    $nik = mysqli_real_escape_string($koneksi, $_POST['nik']);
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $id_jabatan = mysqli_real_escape_string($koneksi, $_POST['id_jabatan']);
    $nomor_telepon = mysqli_real_escape_string($koneksi, $_POST['nomor_telepon']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $status_karyawan = mysqli_real_escape_string($koneksi, $_POST['status_karyawan']);

    // Buat query UPDATE
    $query = "UPDATE karyawan SET 
                nik = '$nik', 
                nama_lengkap = '$nama_lengkap', 
                id_jabatan = '$id_jabatan', 
                nomor_telepon = '$nomor_telepon', 
                alamat = '$alamat', 
                status_karyawan = '$status_karyawan' 
              WHERE id_karyawan = '$id_karyawan'";

    if (mysqli_query($koneksi, $query)) {
        // Jika berhasil, redirect kembali ke halaman data.php dengan pesan sukses
        echo "<script>alert('Data karyawan berhasil diperbarui!'); window.location.href='data.php';</script>";
        exit();
    } else {
        // Jika gagal, tampilkan pesan error
        echo "<script>alert('Gagal memperbarui data: " . mysqli_error($koneksi) . "');</script>";
    }
}

// --- LOGIKA UNTUK MENAMPILKAN FORM DENGAN DATA AWAL (Method: GET) ---
// Ambil ID dari URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Query untuk mengambil data karyawan spesifik
    $query_karyawan = "SELECT * FROM karyawan WHERE id_karyawan = $id";
    $result_karyawan = mysqli_query($koneksi, $query_karyawan);
    
    if (mysqli_num_rows($result_karyawan) == 1) {
        $karyawan = mysqli_fetch_assoc($result_karyawan);
    } else {
        echo "Data karyawan tidak ditemukan.";
        exit();
    }
} else {
    echo "ID Karyawan tidak valid.";
    exit();
}
?>

<div class="content">
    <form action="edit.php" method="post" class="form-input">
        <input type="hidden" name="id_karyawan" value="<?php echo $karyawan['id_karyawan']; ?>">

        <div class="form-group">
            <label for="nik">NIK (Nomor Induk Karyawan)</label>
            <input type="text" id="nik" name="nik" required value="<?php echo htmlspecialchars($karyawan['nik']); ?>">
        </div>
        <div class="form-group">
            <label for="nama_lengkap">Nama Lengkap</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" required value="<?php echo htmlspecialchars($karyawan['nama_lengkap']); ?>">
        </div>
        <div class="form-group">
            <label for="id_jabatan">Jabatan</label>
            <select id="id_jabatan" name="id_jabatan" required>
                <option value="">-- Pilih Jabatan --</option>
                <?php
                // Mengambil data jabatan dari database untuk dropdown
                $query_jabatan = "SELECT * FROM jabatan ORDER BY nama_jabatan";
                $result_jabatan = mysqli_query($koneksi, $query_jabatan);
                while ($jabatan = mysqli_fetch_assoc($result_jabatan)) {
                    // Cek jika ID jabatan sama dengan ID jabatan karyawan, maka tandai sebagai 'selected'
                    $selected = ($jabatan['id_jabatan'] == $karyawan['id_jabatan']) ? 'selected' : '';
                    echo "<option value='" . $jabatan['id_jabatan'] . "' $selected>" . htmlspecialchars($jabatan['nama_jabatan']) . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="nomor_telepon">Nomor Telepon</label>
            <input type="tel" id="nomor_telepon" name="nomor_telepon" value="<?php echo htmlspecialchars($karyawan['nomor_telepon']); ?>">
        </div>
        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea id="alamat" name="alamat" rows="3"><?php echo htmlspecialchars($karyawan['alamat']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="status_karyawan">Status Karyawan</label>
            <select id="status_karyawan" name="status_karyawan" required>
                <option value="Aktif" <?php if ($karyawan['status_karyawan'] == 'Aktif') echo 'selected'; ?>>Aktif</option>
                <option value="Tidak Aktif" <?php if ($karyawan['status_karyawan'] == 'Tidak Aktif') echo 'selected'; ?>>Tidak Aktif</option>
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="data.php" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<?php include '../template/footer.php'; ?>