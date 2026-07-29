<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

include '../../config/database.php';

$id = $_GET['id'];

$query = mysqli_query($conn,"
SELECT
m.*,
i.kode_aset,
i.nama_hardware,
i.merk,
i.kategori,
i.spesifikasi
FROM maintenance m
JOIN inventaris i
ON m.inventaris_id=i.id
WHERE m.id='$id'
");

$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Detail Maintenance</title>

<link rel="stylesheet" href="../../assets/css/style.css">
<link rel="stylesheet" href="../../assets/css/sidebar.css">
<link rel="stylesheet" href="../../assets/css/dashboard.css">
<link rel="stylesheet" href="../../assets/css/Maintenance.css">

<link rel="preconnect" href="https://fonts.googleapis.com">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>

</head>

<body>

<?php include '../../includes/sidebar.php'; ?>

<div class="main-content">

<div class="topbar">

<div>

<h2>Detail Maintenance</h2>

<p>Informasi lengkap laporan maintenance perangkat TI</p>

</div>

<div class="top-right">

<div class="notification">

<i class="fa-regular fa-bell"></i>

</div>

<div class="profile">

<div class="profile-photo">

<i class="fa-solid fa-user"></i>

</div>

<div>

<h4><?= htmlspecialchars($_SESSION['nama']); ?></h4>

<span>Admin DISPUSIPDA</span>

</div>

</div>

</div>

</div>


<div class="form-card">

<h2>Data Maintenance</h2>

<div class="form-group">
<label>Kode Aset</label>
<input type="text" value="<?= $data['kode_aset']; ?>" readonly>
</div>

<div class="form-group">
<label>Nama Perangkat</label>
<input type="text" value="<?= $data['nama_hardware']; ?>" readonly>
</div>

<div class="form-group">
<label>Merk</label>
<input type="text" value="<?= $data['merk']; ?>" readonly>
</div>

<div class="form-group">
<label>Kategori</label>
<input type="text" value="<?= $data['kategori']; ?>" readonly>
</div>

<div class="form-group">
<label>Spesifikasi</label>
<textarea readonly><?= $data['spesifikasi']; ?></textarea>
</div>

<div class="form-group">
<label>Tanggal Lapor</label>
<input type="date" value="<?= $data['tanggal_lapor']; ?>" readonly>
</div>

<div class="form-group">
<label>Kerusakan</label>
<textarea readonly><?= $data['kerusakan']; ?></textarea>
</div>

<div class="form-group">
<label>Keparahan</label>
<input type="text" value="<?= $data['keparahan']; ?>" readonly>
</div>

<div class="form-group">
<label>Teknisi</label>
<input type="text" value="<?= $data['teknisi']; ?>" readonly>
</div>

<div class="form-group">
<label>Tindakan</label>
<textarea readonly><?= $data['tindakan']; ?></textarea>
</div>

<div class="form-group">
<label>Status</label>
<input type="text" value="<?= $data['status']; ?>" readonly>
</div>

<div class="form-group">
<label>Tanggal Selesai</label>
<input type="date" value="<?= $data['tanggal_selesai']; ?>" readonly>
</div>

<div class="btn-group">

<a href="index.php" class="btn-batal">

<i class="fa-solid fa-arrow-left"></i>

Kembali

</a>

<a href="edit.php?id=<?= $data['id']; ?>" class="btn-simpan">

<i class="fa-solid fa-pen"></i>

Edit

</a>

</div>

</div>

</div>

</body>

</html>