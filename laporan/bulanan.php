<?php
$page_title = "Laporan Absensi Bulanan";
include '../template/header.php';
include '../koneksi.php';

// Tentukan bulan dan tahun
$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');

// Nama bulan dalam bahasa Indonesia
$nama_bulan = DateTime::createFromFormat('!m', $bulan)->format('F');

// Jumlah hari dalam bulan yang dipilih
$jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
?>

<div class="content">
    <div class="form-input" style="margin-bottom: 20px;">
        <form method="get" action="bulanan.php">
            <div style="display: flex; gap: 15px; align-items: center;">
                <div class="form-group">
                    <label for="bulan">Pilih Bulan:</label>
                    <select name="bulan" id="bulan">
                        <?php
                        for ($i = 1; $i <= 12; $i++) {
                            $selected = ($i == $bulan) ? 'selected' : '';
                            echo "<option value='" . str_pad($i, 2, '0', STR_PAD_LEFT) . "' $selected>" . DateTime::createFromFormat('!m', $i)->format('F') . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tahun">Pilih Tahun:</label>
                    <select name="tahun" id="tahun">
                        <?php
                        for ($i = date('Y'); $i >= date('Y') - 5; $i--) {
                            $selected = ($i == $tahun) ? 'selected' : '';
                            echo "<option value='$i' $selected>$i</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group" style="margin-top:20px;">
                    <button type="submit" class="btn btn-primary">Tampilkan Laporan</button>
                </div>
            </div>
        </form>
    </div>

    <h4>Laporan Bulan: <?php echo $nama_bulan . " " . $tahun; ?></h4>
    <div class="table-responsive">
        <table class="data-table report-table">
            <thead>
                <tr>
                    <th rowspan="2">Nama Karyawan</th>
                    <th colspan="<?php echo $jumlah_hari; ?>">Tanggal</th>
                    <th colspan="4">Total</th>
                </tr>
                <tr>
                    <?php for ($i = 1; $i <= $jumlah_hari; $i++) echo "<th>$i</th>"; ?>
                    <th>H</th>
                    <th>S</th>
                    <th>I</th>
                    <th>A</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // 1. Ambil semua karyawan aktif
                $karyawan_query = "SELECT id_karyawan, nama_lengkap FROM karyawan WHERE status_karyawan = 'Aktif' ORDER BY nama_lengkap";
                $karyawan_result = mysqli_query($koneksi, $karyawan_query);
                
                // 2. Ambil semua data absensi pada bulan dan tahun terpilih
                $absensi_query = "SELECT id_karyawan, tanggal_absensi, status_kehadiran FROM absensi WHERE MONTH(tanggal_absensi) = '$bulan' AND YEAR(tanggal_absensi) = '$tahun'";
                $absensi_result = mysqli_query($koneksi, $absensi_query);

                // 3. Olah data absensi ke dalam array agar mudah diakses
                $data_absensi = [];
                while ($row = mysqli_fetch_assoc($absensi_result)) {
                    $tanggal = date('j', strtotime($row['tanggal_absensi'])); // Ambil harinya saja (1-31)
                    $data_absensi[$row['id_karyawan']][$tanggal] = $row['status_kehadiran'];
                }

                // 4. Looping untuk setiap karyawan
                while ($karyawan = mysqli_fetch_assoc($karyawan_result)) {
                    $id_karyawan = $karyawan['id_karyawan'];
                    echo "<tr><td>" . htmlspecialchars($karyawan['nama_lengkap']) . "</td>";
                    
                    // Inisialisasi counter total
                    $total_hadir = $total_sakit = $total_izin = $total_alpha = 0;

                    // 5. Looping untuk setiap hari dalam sebulan
                    for ($hari = 1; $hari <= $jumlah_hari; $hari++) {
                        $status = '-';
                        if (isset($data_absensi[$id_karyawan][$hari])) {
                            $status_db = $data_absensi[$id_karyawan][$hari];
                            if ($status_db == 'Hadir') { $status = 'H'; $total_hadir++; }
                            elseif ($status_db == 'Sakit') { $status = 'S'; $total_sakit++; }
                            elseif ($status_db == 'Izin') { $status = 'I'; $total_izin++; }
                        } else {
                            // Cek jika hari ini adalah hari libur (Sabtu/Minggu)
                            $nama_hari = date('N', strtotime("$tahun-$bulan-$hari"));
                            if ($nama_hari == 6 || $nama_hari == 7) {
                                $status = 'L'; // Libur
                            } else {
                                $status = 'A'; // Alpha
                                $total_alpha++;
                            }
                        }
                        // Beri warna sesuai status
                        echo "<td class='status-cell-$status'>$status</td>";
                    }

                    // Tampilkan total
                    echo "<td>$total_hadir</td>";
                    echo "<td>$total_sakit</td>";
                    echo "<td>$total_izin</td>";
                    echo "<td>$total_alpha</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../template/footer.php'; ?>