<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

$page_title = "Profile";
$page_subtitle = "Informasi akun administrator";

$userName = $_SESSION['nama'];
$userInitial = strtoupper(substr($_SESSION['nama'],0,1));

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Profile</title>

<link rel="stylesheet" href="../../assets/css/style.css">
<link rel="stylesheet" href="../../assets/css/sidebar.css">
<link rel="stylesheet" href="../../assets/css/topbar.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<style>

.profile-card{
    max-width:700px;
    background:#fff;
    border-radius:18px;
    padding:30px;
    box-shadow:0 8px 25px rgba(0,0,0,.07);
}

.profile-header{
    display:flex;
    align-items:center;
    gap:20px;
    margin-bottom:30px;
}

.profile-avatar{
    width:90px;
    height:90px;
    border-radius:50%;
    background:#1e40af;
    color:#fff;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:32px;
    font-weight:700;
}

.profile-name h3{
    color:#1e3a8a;
    margin-bottom:5px;
}

.profile-name p{
    color:#777;
}

.profile-info{
    display:grid;
    grid-template-columns:180px 1fr;
    gap:15px;
}

.profile-label{
    font-weight:600;
    color:#555;
}

.profile-value{
    color:#333;
}

@media(max-width:768px){

    .profile-header{
        flex-direction:column;
        text-align:center;
    }

    .profile-info{
        grid-template-columns:1fr;
    }

}

</style>

</head>

<body>

<?php include '../../includes/sidebar.php'; ?>

<div class="main-content">

<?php include '../../includes/topbar.php'; ?>

<div class="profile-card">

<div class="profile-header">

<div class="profile-avatar">

<?= strtoupper(substr($_SESSION['nama'],0,1)); ?>

</div>

<div class="profile-name">

<h3><?= htmlspecialchars($_SESSION['nama']); ?></h3>

<p>Administrator DISPUSIPDA</p>

</div>

</div>

<div class="profile-info">

<div class="profile-label">Nama</div>
<div class="profile-value"><?= htmlspecialchars($_SESSION['nama']); ?></div>

<div class="profile-label">Username</div>
<div class="profile-value">admin</div>

<div class="profile-label">Role</div>
<div class="profile-value">Administrator</div>

<div class="profile-label">Status</div>
<div class="profile-value">Aktif</div>

</div>

</div>

</div>

</body>

</html>