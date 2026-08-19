<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

include 'config/database.php';
require_once 'config/activity_log.php';

// ===============================
// Total Inventaris
// ===============================
$result = mysqli_query($conn, "SELECT * FROM inventaris");
$total_aset = ($result) ? mysqli_num_rows($result) : 0;

// ===============================
// Maintenance
// ===============================
// Status maintenance yang masih dalam proses:
// Menunggu dan Dalam Perbaikan
$result = mysqli_query($conn, "
SELECT * FROM maintenance
WHERE status IN ('Menunggu', 'Dalam Perbaikan')
");
$total_maintenance = ($result) ? mysqli_num_rows($result) : 0;

// ===============================
// Aset Aktif
// ===============================
$result = mysqli_query($conn, "
SELECT * FROM inventaris
WHERE status = 'Tersedia'
");
$total_ready = ($result) ? mysqli_num_rows($result) : 0;

// ===============================
// Log Aktivitas Terbaru
// ===============================
$result_aktivitas = mysqli_query($conn, "
SELECT
    id,
    aktivitas,
    deskripsi,
    tanggal
FROM log_aktivitas
ORDER BY tanggal DESC, id DESC
LIMIT 5
");

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard | DISPUSIPDA</title>

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/sidebar.css">
    <link rel="stylesheet" href="assets/css/topbar.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

</head>

<body>

    <?php include 'includes/sidebar.php'; ?>

    <div class="main-content">

        <?php

        $page_title = "Dashboard";

        $page_subtitle = "Ringkasan status inventaris perangkat TI DISPUSIPDA Provinsi Jawa Barat";

        include 'includes/topbar.php';

        ?>


        <!-- ================= CARD ================= -->

        <div class="dashboard-cards">

            <div class="card">

                <div class="icon blue">

                    <i class="fa-solid fa-computer"></i>

                </div>

                <div class="info">

                    <span>INVENTARIS</span>

                    <h1><?= $total_aset; ?></h1>

                    <p>Total Aset TI</p>

                    <small>Terdaftar dalam sistem</small>

                </div>

            </div>



            <div class="card">

                <div class="icon orange">

                    <i class="fa-solid fa-screwdriver-wrench"></i>

                </div>

                <div class="info">

                    <span>PERBAIKAN</span>

                    <h1><?= $total_maintenance; ?></h1>

                    <p>Unit Maintenance</p>

                    <small>Dalam proses perbaikan</small>

                </div>

            </div>



            <div class="card">

                <div class="icon green">

                    <i class="fa-solid fa-circle-check"></i>

                </div>

                <div class="info">

                    <span>AKTIF</span>

                    <h1><?= $total_ready; ?></h1>

                    <p>Aset Aktif / Ready</p>

                    <small>Siap digunakan</small>

                </div>

            </div>

        </div>



        <!-- ================= LOG ================= -->

        <div class="activity-card">

            <div class="activity-header">

                <h3>

                    <i class="fa-solid fa-clock-rotate-left"></i>

                    Log Aktivitas Terbaru

                </h3>

                <span><?= date('d F Y'); ?></span>

            </div>



            <div class="activity-list">

                <?php if ($result_aktivitas && mysqli_num_rows($result_aktivitas) > 0): ?>

                    <?php while ($aktivitas = mysqli_fetch_assoc($result_aktivitas)): ?>

                        <?php
                        // Menentukan warna titik berdasarkan jenis aktivitas
                        $dot_class = 'blue';

                        if (
                            stripos($aktivitas['aktivitas'], 'Maintenance') !== false ||
                            stripos($aktivitas['aktivitas'], 'Rusak') !== false
                        ) {
                            $dot_class = 'yellow';
                        } elseif (
                            stripos($aktivitas['aktivitas'], 'selesai') !== false ||
                            stripos($aktivitas['aktivitas'], 'dikembalikan') !== false
                        ) {
                            $dot_class = 'green';
                        } elseif (
                            stripos($aktivitas['aktivitas'], 'dipinjam') !== false
                        ) {
                            $dot_class = 'blue';
                        }
                        ?>

                        <div class="activity-item">

                            <div class="dot <?= $dot_class; ?>"></div>

                            <div class="activity-text">

                                <h4>
                                    <?= htmlspecialchars($aktivitas['aktivitas']); ?>
                                </h4>

                                <p>
                                    <?= htmlspecialchars($aktivitas['deskripsi']); ?>
                                </p>

                            </div>

                            <span>
                                <?= date('d M Y', strtotime($aktivitas['tanggal'])); ?>
                            </span>

                        </div>

                    <?php endwhile; ?>

                <?php else: ?>

                    <div class="activity-item">

                        <div class="dot blue"></div>

                        <div class="activity-text">

                            <h4>Belum ada aktivitas</h4>

                            <p>
                                Belum terdapat aktivitas terbaru dalam sistem.
                            </p>

                        </div>

                        <span>
                            <?= date('d M Y'); ?>
                        </span>

                    </div>

                <?php endif; ?>

            </div>

        </div>

    </div>

</body>

</html>