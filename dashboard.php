<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

include 'config/database.php';

// ===============================
// Total Inventaris
// ===============================
$result = mysqli_query($conn, "SELECT * FROM inventaris");
$total_aset = ($result) ? mysqli_num_rows($result) : 10;

// ===============================
// Maintenance
// ===============================
$result = mysqli_query($conn, "
SELECT * FROM maintenance
WHERE status='Proses'
");
$total_maintenance = ($result) ? mysqli_num_rows($result) : 1;

// ===============================
// Aset Aktif
// ===============================
$result = mysqli_query($conn, "
SELECT * FROM inventaris
WHERE status='tersedia'
");
$total_ready = ($result) ? mysqli_num_rows($result) : 8;
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

                <span>15 Juli 2026</span>

            </div>



            <div class="activity-list">

                <div class="activity-item">

                    <div class="dot yellow"></div>

                    <div class="activity-text">

                        <h4>Laporan kerusakan baru</h4>

                        <p>
                            Monitor LG 24MK430H dilaporkan rusak -
                            garis horizontal pada layar
                        </p>

                    </div>

                    <span>12 Jul 2026</span>

                </div>



                <div class="activity-item">

                    <div class="dot blue"></div>

                    <div class="activity-text">

                        <h4>Perangkat dipinjam</h4>

                        <p>

                            Laptop Dell Latitude dipinjam
                            oleh Bapak Ahmad Yusuf

                        </p>

                    </div>

                    <span>10 Jul 2026</span>

                </div>



                <div class="activity-item">

                    <div class="dot green"></div>

                    <div class="activity-text">

                        <h4>Maintenance selesai</h4>

                        <p>

                            Printer HP LaserJet selesai
                            diperbaiki oleh Teknisi

                        </p>

                    </div>

                    <span>08 Jul 2026</span>

                </div>



                <div class="activity-item">

                    <div class="dot yellow"></div>

                    <div class="activity-text">

                        <h4>Laporan kerusakan baru</h4>

                        <p>

                            Switch Cisco Catalyst
                            port 12 tidak aktif

                        </p>

                    </div>

                    <span>08 Jul 2026</span>

                </div>



                <div class="activity-item">

                    <div class="dot green"></div>

                    <div class="activity-text">

                        <h4>Perangkat dikembalikan</h4>

                        <p>

                            Laptop Dell Latitude telah
                            dikembalikan ke ruang arsip

                        </p>

                    </div>

                    <span>05 Jul 2026</span>

                </div>

            </div>

        </div>

    </div>

</body>

</html>