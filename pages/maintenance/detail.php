<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

include '../../config/database.php';

// Pastikan ID ada di URL
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int)$_GET['id'];

// Ambil data detail maintenance beserta data inventaris
$query = mysqli_query($conn, "
    SELECT 
        m.*,
        i.kode_aset,
        i.nama_hardware,
        i.merk
    FROM maintenance m
    LEFT JOIN inventaris i ON m.inventaris_id = i.id
    WHERE m.id = '$id'
");

$data = mysqli_fetch_assoc($query);

// Jika data tidak ditemukan
if (!$data) {
    header("Location: index.php");
    exit;
}

// Set Judul Halaman untuk Topbar Bawaan Sistem (Sama seperti Tambah Maintenance)
$page_title = "Detail Maintenance";
$page_subtitle = "Informasi detail laporan kerusakan perangkat TI DISPUSIPDA";
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Maintenance TI</title>

    <!-- CSS Links -->
    <link rel="stylesheet" href="../../assets/css/style.css?v=2.0">
    <link rel="stylesheet" href="../../assets/css/sidebar.css?v=2.0">
    <link rel="stylesheet" href="../../assets/css/topbar.css?v=2.0">
    <link rel="stylesheet" href="../../assets/css/maintenance.css?v=2.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>
</head>

<body>

    <!-- INCLUDE SIDEBAR -->
    <?php include '../../includes/sidebar.php'; ?>

    <div class="main-content">

        <!-- INCLUDE TOPBAR RESMI (Pakai Topbar Bawaan Sistem) -->
        <?php include '../../includes/topbar.php'; ?>

        <!-- FORM / DETAIL CARD -->
        <div class="form-card" style="margin-top: 25px;">
            <h3 style="margin-bottom: 20px; color: #1e293b; font-weight: 600;">Data Maintenance</h3>

            <div class="form-group">
                <label>Kode Aset</label>
                <input type="text" value="<?= htmlspecialchars($data['kode_aset']); ?>" readonly style="background-color: #f8fafc;">
            </div>

            <div class="form-group">
                <label>Nama Perangkat</label>
                <input type="text" value="<?= htmlspecialchars($data['nama_hardware']); ?><?= !empty($data['merk']) ? ' ('.$data['merk'].')' : ''; ?>" readonly style="background-color: #f8fafc;">
            </div>

            <div class="form-group">
                <label>Tanggal Lapor</label>
                <input type="text" value="<?= date('d F Y', strtotime($data['tanggal_lapor'])); ?>" readonly style="background-color: #f8fafc;">
            </div>

            <div class="form-group">
                <label>Kerusakan</label>
                <textarea readonly style="background-color: #f8fafc;"><?= htmlspecialchars($data['kerusakan']); ?></textarea>
            </div>

            <div class="form-group">
                <label>Keparahan</label>
                <input type="text" value="<?= htmlspecialchars($data['keparahan']); ?>" readonly style="background-color: #f8fafc;">
            </div>

            <div class="form-group">
                <label>Status</label>
                <input type="text" value="<?= htmlspecialchars($data['status']); ?>" readonly style="background-color: #f8fafc;">
            </div>

            <div class="form-group">
                <label>Teknisi</label>
                <input type="text" value="<?= htmlspecialchars($data['teknisi'] ?? '-'); ?>" readonly style="background-color: #f8fafc;">
            </div>

            <div class="form-group">
                <label>Tindakan</label>
                <textarea readonly style="background-color: #f8fafc;"><?= htmlspecialchars($data['tindakan'] ?? '-'); ?></textarea>
            </div>

            <div class="btn-group" style="margin-top: 25px;">
                <a href="edit.php?id=<?= $data['id']; ?>" class="btn-simpan" style="text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-pen"></i> Edit Data
                </a>
                <a href="index.php" class="btn-batal">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
            </div>

        </div>

    </div>

</body>
</html>