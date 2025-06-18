<?php
$page_title = "Data Karyawan";
include '../template/header.php';
include '../koneksi.php'; 
?>

<div class="content">
    <a href="tambah.php" class="btn btn-primary">+ Tambah Karyawan Baru</a>
    <br><br>
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama Lengkap</th>
                <th>Jabatan</th>
                <th>No. Telepon</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            
            $query = "SELECT karyawan.*, jabatan.nama_jabatan 
                      FROM karyawan 
                      JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan
                      ORDER BY karyawan.nama_lengkap ASC";
            $result = mysqli_query($koneksi, $query);
            $no = 1;

            if (mysqli_num_rows($result) > 0) {
                while ($data = mysqli_fetch_assoc($result)) {
            ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo htmlspecialchars($data['nik']); ?></td>
                        <td><?php echo htmlspecialchars($data['nama_lengkap']); ?></td>
                        <td><?php echo htmlspecialchars($data['nama_jabatan']); ?></td>
                        <td><?php echo htmlspecialchars($data['nomor_telepon']); ?></td>
                        <td><span class="status-<?php echo strtolower($data['status_karyawan']); ?>"><?php echo htmlspecialchars($data['status_karyawan']); ?></span></td>
                        <td>
                            <a href="edit.php?id=<?php echo $data['id_karyawan']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="hapus.php?id=<?php echo $data['id_karyawan']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Hapus</a>
                        </td>
                    </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='7' style='text-align:center;'>Belum ada data karyawan.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include '../template/footer.php'; ?>