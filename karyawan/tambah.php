<?php
$page_title = "Tambah Karyawan";
include '../template/header.php';
include '../koneksi.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nik = mysqli_real_escape_string($koneksi, $_POST['nik']);
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $id_jabatan = mysqli_real_escape_string($koneksi, $_POST['id_jabatan']);
    $nomor_telepon = mysqli_real_escape_string($koneksi, $_POST['nomor_telepon']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $status_karyawan = mysqli_real_escape_string($koneksi, $_POST['status_karyawan']);

 
    $query = "INSERT INTO karyawan (nik, nama_lengkap, id_jabatan, nomor_telepon, alamat, status_karyawan) 
              VALUES ('$nik', '$nama_lengkap', '$id_jabatan', '$nomor_telepon', '$alamat', '$status_karyawan')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data karyawan berhasil ditambahkan!'); window.location.href='data.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan data: " . mysqli_error($koneksi) . "');</script>";
    }
}
?>

<div class="content">
    <form action="tambah.php" method="post" class="form-input">
        <div class="form-group">
            <label for="nik">NIK (Nomor Induk Karyawan)</label>
            <input type="text" id="nik" name="nik" required>
        </div>
        <div class="form-group">
            <label for="nama_lengkap">Nama Lengkap</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" required>
        </div>
        <div class="form-group">
            <label for="id_jabatan">Jabatan</label>
            <select id="id_jabatan" name="id_jabatan" required>
                <option value="">-- Pilih Jabatan --</option>
                <?php
                
                $query_jabatan = "SELECT * FROM jabatan ORDER BY nama_jabatan";
                $result_jabatan = mysqli_query($koneksi, $query_jabatan);
                while ($jabatan = mysqli_fetch_assoc($result_jabatan)) {
                    echo "<option value='" . $jabatan['id_jabatan'] . "'>" . htmlspecialchars($jabatan['nama_jabatan']) . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="nomor_telepon">Nomor Telepon</label>
            <input type="tel" id="nomor_telepon" name="nomor_telepon">
        </div>
        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea id="alamat" name="alamat" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label for="status_karyawan">Status Karyawan</label>
            <select id="status_karyawan" name="status_karyawan" required>
                <option value="Aktif">Aktif</option>
                <option value="Tidak Aktif">Tidak Aktif</option>
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Simpan Data</button>
            <a href="data.php" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<?php include '../template/footer.php'; ?>