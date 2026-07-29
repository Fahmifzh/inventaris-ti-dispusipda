<?php

session_start();

include 'config/database.php';

if(isset($_POST['username'])){

    $username = mysqli_real_escape_string(
        $conn,
        $_POST['username']
    );

    $password = md5($_POST['password']);

    $query = mysqli_query(
        $conn,
        "SELECT * FROM admin
        WHERE username='$username'
        AND password='$password'"
    );

    if(mysqli_num_rows($query) > 0){

        $data = mysqli_fetch_assoc($query);

        $_SESSION['login'] = true;
        $_SESSION['admin_id'] = $data['id'];
        $_SESSION['nama'] = $data['nama'];

        header("Location: dashboard.php");
        exit;

    }else{

        $error = "Username atau Password salah";

    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - DISPUSIPDA</title>

<link rel="stylesheet" href="assets/css/login.css">

</head>
<body>

<div class="login-wrapper">

    <div class="logo-area">

        <img src="assets/img/logo.png" alt="Logo">

        <h4>PEMERINTAH PROVINSI JAWA BARAT</h4>

        <h1>DISPUSIPDA</h1>

        <p>Dinas Perpustakaan dan Kearsipan Daerah</p>

    </div>

    <div class="login-card">

        <div class="card-header">

            <h3>Sistem Inventaris Perangkat TI</h3>

            <p>Masuk menggunakan akun dinas Anda untuk melanjutkan</p>

        </div>
<?php if(isset($error)){ ?>
<div class="error-message">
    <?= $error; ?>
</div>
<?php } ?>
        <form method="POST">

            <label>USERNAME</label>

            <input
                type="text"
                name="username"
                placeholder="Masukkan username"
                required
            >

            <label>PASSWORD</label>

            <input
                type="password"
                name="password"
                placeholder="Masukkan password"
                required
            >

            <button type="submit">
                Masuk Sistem
            </button>

        </form>

        <div class="footer-text">
            © 2026 DISPUSIPDA Provinsi Jawa Barat
        </div>

    </div>

</div>

</body>
</html>