<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

include '../../config/database.php';

$jenis  = $_GET['jenis'] ?? '';
$format = $_GET['format'] ?? '';

$judul_map = [
    'inventaris'  => 'Laporan Inventaris Bulanan',
    'maintenance' => 'Laporan Maintenance',
    'peminjaman'  => 'Laporan Sirkulasi Peminjaman',
    'kritis'      => 'Laporan Inventaris Kritis & Aging',
];

if (!isset($judul_map[$jenis])) {
    die('Jenis laporan tidak valid.');
}
$judul = $judul_map[$jenis];

// ---------- Ambil data sesuai jenis ----------
switch ($jenis) {
    case 'inventaris':
        $kolom = ['Kode Aset', 'Nama Hardware', 'Kategori', 'Lokasi', 'Tahun', 'Status'];
        $res = mysqli_query($conn, "SELECT kode_aset, nama_hardware, kategori, lokasi, tahun_pengadaan, status FROM inventaris ORDER BY id ASC");
        $baris_key = ['kode_aset', 'nama_hardware', 'kategori', 'lokasi', 'tahun_pengadaan', 'status'];
        break;

    case 'maintenance':
        $kolom = ['Kode Aset', 'Nama Hardware', 'Tanggal Lapor', 'Kerusakan', 'Keparahan', 'Status', 'Teknisi'];
        $res = mysqli_query($conn, "
            SELECT i.kode_aset, i.nama_hardware, m.tanggal_lapor, m.kerusakan, m.keparahan, m.status, m.teknisi
            FROM maintenance m
            LEFT JOIN inventaris i ON m.inventaris_id = i.id
            ORDER BY m.id DESC
        ");
        $baris_key = ['kode_aset', 'nama_hardware', 'tanggal_lapor', 'kerusakan', 'keparahan', 'status', 'teknisi'];
        break;

    case 'peminjaman':
        // ⚠️ Pakai kolom nama_peminjam mengikuti proses_tambah.php.
        // Kalau di database kamu kolomnya ternyata nama_pegawai, ganti di query ini.
        $kolom = ['Nama Peminjam', 'Divisi', 'Perangkat', 'Kode', 'Tgl Pinjam', 'Est. Kembali', 'Status'];
        $res = mysqli_query($conn, "
            SELECT p.nama_peminjam, p.divisi, i.nama_hardware, i.kode_aset, p.tanggal_pinjam, p.est_kembali, p.status
            FROM peminjaman p
            JOIN inventaris i ON p.inventaris_id = i.id
            ORDER BY p.tanggal_pinjam DESC
        ");
        $baris_key = ['nama_peminjam', 'divisi', 'nama_hardware', 'kode_aset', 'tanggal_pinjam', 'est_kembali', 'status'];
        break;

    case 'kritis':
        $tahun_kritis = date('Y') - 5;
        $kolom = ['Kode Aset', 'Nama Hardware', 'Tahun Pengadaan', 'Umur (tahun)', 'Status'];
        $res = mysqli_query($conn, "
            SELECT kode_aset, nama_hardware, tahun_pengadaan, status
            FROM inventaris
            WHERE tahun_pengadaan IS NOT NULL AND tahun_pengadaan <= $tahun_kritis
            ORDER BY tahun_pengadaan ASC
        ");
        $baris_key = ['kode_aset', 'nama_hardware', 'tahun_pengadaan', null, 'status']; // null = kolom hitung manual (umur)
        break;
}

$data = [];
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $data[] = $row;
    }
}

// =====================================================================
// FORMAT EXCEL → di-export sebagai CSV (bisa langsung dibuka Excel,
// tidak butuh library tambahan)
// =====================================================================
if ($format === 'excel') {
    $filename = 'laporan_' . $jenis . '_' . date('Y-m-d') . '.csv';
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    $output = fopen('php://output', 'w');
    fputcsv($output, $kolom);

    foreach ($data as $row) {
        $baris = [];
        foreach ($baris_key as $key) {
            if ($key === null) {
                // kolom "Umur (tahun)" dihitung manual untuk laporan kritis
                $baris[] = date('Y') - (int) $row['tahun_pengadaan'];
            } else {
                $baris[] = $row[$key] ?? '-';
            }
        }
        fputcsv($output, $baris);
    }

    fclose($output);
    exit;
}

// =====================================================================
// FORMAT PDF → belum ada library PDF di project ini (TCPDF/mPDF/dst).
// Solusi sementara: tampilkan halaman siap-cetak, browser otomatis buka
// dialog Print — user tinggal pilih "Save as PDF" di situ.
// =====================================================================
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($judul) ?></title>
<style>
    body { font-family: Arial, sans-serif; padding: 32px 40px; color: #1c1c2b; }

    .kop-surat {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 18px;
        text-align: center;
        padding-bottom: 14px;
    }
    .kop-surat img { width: 64px; height: 64px; object-fit: contain; }
    .logo-fallback {
        display: none;
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: #16215c;
        color: #fff;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: 700;
        letter-spacing: 0.02em;
        flex-shrink: 0;
    }
    .kop-text h2 { margin: 0; font-size: 13px; font-weight: 600; color: #333; letter-spacing: 0.03em; }
    .kop-text h1 { margin: 3px 0; font-size: 21px; font-weight: 700; color: #16215c; letter-spacing: 0.06em; }
    .kop-text p { margin: 0; font-size: 11.5px; color: #666; }

    .kop-garis-tebal { border-bottom: 3px solid #16215c; margin-top: 4px; }
    .kop-garis-tipis { border-bottom: 1px solid #16215c; margin-bottom: 22px; margin-top: 2px; }

    h1.judul-laporan { font-size: 18px; margin: 0 0 3px; text-align: center; }
    .sub { color: #666; font-size: 12px; margin-bottom: 22px; text-align: center; }

    table { width: 100%; border-collapse: collapse; font-size: 12px; }
    th, td { border: 1px solid #ccc; padding: 7px 9px; text-align: left; }
    th { background: #f2f2f2; font-weight: 700; }

    .no-print { margin-bottom: 16px; }
    @media print {
        .no-print { display: none; }
    }
</style>
</head>
<body>

<div class="kop-surat">
    <img src="../../assets/img/logo.png" alt="Logo DISPUSIPDA"
         onerror="this.style.display='none'; document.getElementById('logoFallback').style.display='flex';">
    <div class="logo-fallback" id="logoFallback">DP</div>
    <div class="kop-text">
        <h2>PEMERINTAH PROVINSI JAWA BARAT</h2>
        <h1>DISPUSIPDA</h1>
        <p>Dinas Perpustakaan dan Kearsipan Daerah — Sistem Inventaris Perangkat TI</p>
    </div>
</div>
<div class="kop-garis-tebal"></div>
<div class="kop-garis-tipis"></div>

<h1 class="judul-laporan"><?= htmlspecialchars($judul) ?></h1>
<p class="sub">Dicetak pada <?= date('d-m-Y H:i') ?> — DISPUSIPDA Provinsi Jawa Barat</p>

<button class="no-print" onclick="window.print()">🖨️ Print / Save as PDF</button>

<table>
<thead>
<tr>
<?php foreach ($kolom as $k): ?>
    <th><?= htmlspecialchars($k) ?></th>
<?php endforeach; ?>
</tr>
</thead>
<tbody>
<?php if (empty($data)): ?>
    <tr><td colspan="<?= count($kolom) ?>">Tidak ada data.</td></tr>
<?php else: ?>
    <?php foreach ($data as $row): ?>
    <tr>
        <?php foreach ($baris_key as $key): ?>
            <td>
                <?php
                if ($key === null) {
                    echo date('Y') - (int) $row['tahun_pengadaan'];
                } else {
                    echo htmlspecialchars($row[$key] ?? '-');
                }
                ?>
            </td>
        <?php endforeach; ?>
    </tr>
    <?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>

<script>
    // Otomatis buka dialog print begitu halaman selesai dimuat
    window.onload = function () { window.print(); };
</script>

</body>
</html>