<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

include '../../config/database.php';

// ===== SET VARIABEL TOPBAR =====
$page_title = "Laporan & Statistik";
$page_subtitle = "Rekapitulasi dan analisis data inventaris perangkat TI DISPUSIPDA";
$show_add_button = false;
// ================================

// =====================================================================
// ⚠️ Query di bawah pakai status 'Tersedia' (bukan 'Aktif') mengikuti
// modul Inventaris. Kalau kamu belum benerin Bug 1 di peminjaman,
// angka di card "Sirkulasi Peminjaman" tetap akurat karena dihitung
// dari tabel peminjaman langsung, bukan dari status inventaris.
// =====================================================================

// ---------- 1. Total aset (untuk card "Laporan Inventaris Bulanan") ----------
$q_aset = mysqli_query($conn, "SELECT COUNT(*) AS total FROM inventaris");
$total_aset = $q_aset ? (mysqli_fetch_assoc($q_aset)['total'] ?? 0) : 0;

// ---------- 2. Insiden maintenance kuartal berjalan ----------
$bulan_sekarang = (int) date('n');
if ($bulan_sekarang <= 3) {
    $q_awal = date('Y') . '-01-01';
    $q_akhir = date('Y') . '-03-31';
    $kuartal = 'Q1';
} elseif ($bulan_sekarang <= 6) {
    $q_awal = date('Y') . '-04-01';
    $q_akhir = date('Y') . '-06-30';
    $kuartal = 'Q2';
} elseif ($bulan_sekarang <= 9) {
    $q_awal = date('Y') . '-07-01';
    $q_akhir = date('Y') . '-09-30';
    $kuartal = 'Q3';
} else {
    $q_awal = date('Y') . '-10-01';
    $q_akhir = date('Y') . '-12-31';
    $kuartal = 'Q4';
}

$q_maint = mysqli_query($conn, "
    SELECT COUNT(*) AS total FROM maintenance
    WHERE tanggal_lapor BETWEEN '$q_awal' AND '$q_akhir'
");
$total_maintenance = $q_maint ? (mysqli_fetch_assoc($q_maint)['total'] ?? 0) : 0;

// ---------- 3. Transaksi peminjaman bulan ini ----------
$bulan_ini = date('Y-m');
$q_pinjam = mysqli_query($conn, "
    SELECT COUNT(*) AS total FROM peminjaman
    WHERE DATE_FORMAT(tanggal_pinjam, '%Y-%m') = '$bulan_ini'
");
$total_peminjaman = $q_pinjam ? (mysqli_fetch_assoc($q_pinjam)['total'] ?? 0) : 0;

// ---------- 4. Aset kritis & aging (umur > 5 tahun) ----------
$tahun_kritis = date('Y') - 5;

$q_kritis = mysqli_query($conn, "
    SELECT COUNT(*) AS total
    FROM inventaris
    WHERE tahun_pengadaan IS NOT NULL
      AND tahun_pengadaan <= $tahun_kritis
");
$total_kritis = $q_kritis ? (mysqli_fetch_assoc($q_kritis)['total'] ?? 0) : 0;

// Label bulan Indonesia untuk periode
$nama_bulan = [
    '01' => 'Januari',
    '02' => 'Februari',
    '03' => 'Maret',
    '04' => 'April',
    '05' => 'Mei',
    '06' => 'Juni',
    '07' => 'Juli',
    '08' => 'Agustus',
    '09' => 'September',
    '10' => 'Oktober',
    '11' => 'November',
    '12' => 'Desember'
];
$periode_bulan_ini = $nama_bulan[date('m')] . ' ' . date('Y');

$bulan_awal_kuartal = (int) substr($q_awal, 5, 2);
$bulan_akhir_kuartal = (int) substr($q_akhir, 5, 2);
$periode_kuartal = $nama_bulan[str_pad($bulan_awal_kuartal, 2, '0', STR_PAD_LEFT)] . ' – ' . $nama_bulan[str_pad($bulan_akhir_kuartal, 2, '0', STR_PAD_LEFT)] . ' ' . date('Y');
?>
<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Laporan & Statistik | DISPUSIPDA</title>

    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/sidebar.css">
    <link rel="stylesheet" href="../../assets/css/topbar.css">
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
    <link rel="stylesheet" href="../../assets/css/laporan.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

</head>

<body>

    <?php include '../../includes/sidebar.php'; ?>

    <div class="main-content">

        <!-- ===== TOPBAR ===== -->
        <?php include '../../includes/topbar.php'; ?>

        <div class="laporan-grid">

            <!-- Card 1: Laporan Inventaris Bulanan -->
            <div class="laporan-card" onclick="pilihExport('inventaris', 'Laporan Inventaris Bulanan')">
                <div class="laporan-icon blue"><i class="fa-solid fa-chart-column"></i></div>
                <h3>Laporan Inventaris Bulanan</h3>
                <p>Rekap seluruh aset TI terdaftar per <?= $periode_bulan_ini ?></p>
                <div class="laporan-footer">
                    <div>
                        <span class="label">PERIODE</span>
                        <strong><?= $periode_bulan_ini ?></strong>
                    </div>
                    <div class="text-right">
                        <span class="label">DATA</span>
                        <strong class="value blue"><?= $total_aset ?> Aset</strong>
                    </div>
                </div>
            </div>

            <!-- Card 2: Laporan Maintenance Kuartal -->
            <div class="laporan-card"
                onclick="pilihExport('maintenance', 'Laporan Maintenance <?= $kuartal ?> <?= date('Y') ?>')">
                <div class="laporan-icon orange"><i class="fa-solid fa-chart-column"></i></div>
                <h3>Laporan Maintenance <?= $kuartal ?> <?= date('Y') ?></h3>
                <p>Rekap insiden kerusakan dan perbaikan triwulan
                    <?= $kuartal === 'Q1' ? 'I' : ($kuartal === 'Q2' ? 'II' : ($kuartal === 'Q3' ? 'III' : 'IV')) ?>
                </p>
                <div class="laporan-footer">
                    <div>
                        <span class="label">PERIODE</span>
                        <strong><?= $periode_kuartal ?></strong>
                    </div>
                    <div class="text-right">
                        <span class="label">DATA</span>
                        <strong class="value orange"><?= $total_maintenance ?> Insiden</strong>
                    </div>
                </div>
            </div>

            <!-- Card 3: Laporan Sirkulasi Peminjaman -->
            <div class="laporan-card" onclick="pilihExport('peminjaman', 'Laporan Sirkulasi Peminjaman')">
                <div class="laporan-icon green"><i class="fa-solid fa-chart-column"></i></div>
                <h3>Laporan Sirkulasi Peminjaman</h3>
                <p>Data peminjaman dan pengembalian perangkat TI</p>
                <div class="laporan-footer">
                    <div>
                        <span class="label">PERIODE</span>
                        <strong><?= $periode_bulan_ini ?></strong>
                    </div>
                    <div class="text-right">
                        <span class="label">DATA</span>
                        <strong class="value green"><?= $total_peminjaman ?> Transaksi</strong>
                    </div>
                </div>
            </div>

            <!-- Card 4: Inventaris Kritis & Aging -->
            <div class="laporan-card" onclick="pilihExport('kritis', 'Inventaris Kritis & Aging')">
                <div class="laporan-icon red"><i class="fa-solid fa-chart-column"></i></div>
                <h3>Inventaris Kritis & Aging</h3>
                <p>Aset berumur &gt;5 tahun yang memerlukan evaluasi segera</p>
                <div class="laporan-footer">
                    <div>
                        <span class="label">PERIODE</span>
                        <strong><?= $periode_bulan_ini ?></strong>
                    </div>
                    <div class="text-right">
                        <span class="label">DATA</span>
                        <strong class="value red"><?= $total_kritis ?> Perangkat</strong>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- ================= Modal: Pilih Format Export ================= -->
    <div class="modal-overlay" id="modalExport">
        <div class="modal-box modal-export">
            <div class="export-icon"><i class="fa-solid fa-download"></i></div>
            <h3 id="exportTitle">Export Laporan</h3>
            <p id="exportSubtitle">Pilih format file yang ingin diunduh</p>

            <div class="export-options">
                <a id="btnExportPdf" href="#" class="btn-export pdf">
                    <i class="fa-solid fa-file-pdf"></i>
                    <span>Export PDF</span>
                </a>
                <a id="btnExportExcel" href="#" class="btn-export excel">
                    <i class="fa-solid fa-file-excel"></i>
                    <span>Export Excel</span>
                </a>
            </div>

            <button type="button" class="btn-batal" onclick="tutupModalExport()">Batal</button>
        </div>
    </div>

    <script>
        function pilihExport(jenis, judul) {
            document.getElementById('exportTitle').textContent = judul;
            // proses_export.php belum dibuat, ini baru target URL-nya
            document.getElementById('btnExportPdf').href = 'proses_export.php?jenis=' + jenis + '&format=pdf';
            document.getElementById('btnExportExcel').href = 'proses_export.php?jenis=' + jenis + '&format=excel';
            document.getElementById('modalExport').classList.add('is-open');
        }

        function tutupModalExport() {
            document.getElementById('modalExport').classList.remove('is-open');
        }

        // Klik area gelap di luar modal box untuk menutup
        document.querySelectorAll('.modal-overlay').forEach(function (modal) {
            modal.addEventListener('click', function (e) {
                if (e.target === this) this.classList.remove('is-open');
            });
        });
    </script>

</body>

</html>