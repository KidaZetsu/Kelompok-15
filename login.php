<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Absensi Bengkel BDL</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="login-body">
    <div class="login-container">
        <h2>Login Sistem Absensi</h2>
        <h3>Bengkel BDL</h3>
        <hr>
        <?php
        
        if (isset($_GET['pesan'])) {
            if ($_GET['pesan'] == "gagal") {
                echo "<div class='alert-error'>Login gagal! Username atau password salah.</div>";
            } else if ($_GET['pesan'] == "logout") {
                echo "<div class='alert-success'>Anda telah berhasil logout.</div>";
            } else if ($_GET['pesan'] == "belum_login") {
                echo "<div class='alert-warning'>Anda harus login untuk mengakses halaman.</div>";
            }
        }
        ?>
        <form action="proses_login.php" method="post">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" placeholder="Masukkan username" required>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Masukkan password" required>

            <button type="submit" class="btn-login">LOGIN</button>
        </form>
    </div>
</body>
</html>