<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

include '../../config/database.php';
require_once '../../config/activity_log.php';


// ========================================
// Pastikan request berasal dari POST
// ========================================
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}


// ========================================
// Ambil ID peminjaman
// ========================================
$id_peminjaman = (int)($_POST['id_peminjaman'] ?? 0);


if (!$id_peminjaman) {

    $_SESSION['flash_error'] = "Data peminjaman tidak valid.";

    header("Location: index.php");
    exit;
}


// ========================================
// Ambil data peminjaman + perangkat
// ========================================
$cek = mysqli_query($conn, "
    SELECT
        peminjaman.inventaris_id,
        peminjaman.status,
        peminjaman.nama_peminjam,
        peminjaman.divisi,
        inventaris.kode_aset,
        inventaris.nama_hardware
    FROM peminjaman
    INNER JOIN inventaris
        ON peminjaman.inventaris_id = inventaris.id
    WHERE peminjaman.id = $id_peminjaman
");


$row = $cek ? mysqli_fetch_assoc($cek) : null;


// ========================================
// Cek data peminjaman
// ========================================
if (!$row) {

    $_SESSION['flash_error'] = "Data peminjaman tidak ditemukan.";

    header("Location: index.php");
    exit;
}


// ========================================
// Cek apakah sudah dikembalikan
// ========================================
if ($row['status'] === 'Dikembalikan') {

    $_SESSION['flash_error'] =
        "Perangkat ini sudah dikembalikan sebelumnya.";

    header("Location: index.php");
    exit;
}


// ========================================
// Ambil data perangkat
// ========================================
$inventaris_id = (int)$row['inventaris_id'];

$kode_aset = $row['kode_aset'];

$nama_hardware = $row['nama_hardware'];

$nama_peminjam = $row['nama_peminjam'];

$divisi = $row['divisi'];


// ========================================
// Update status peminjaman
// ========================================
$update = mysqli_query($conn, "
    UPDATE peminjaman
    SET
        status = 'Dikembalikan',
        tanggal_kembali = CURDATE()
    WHERE id = $id_peminjaman
");


if ($update) {


    // ========================================
    // Aset kembali menjadi Tersedia
    // ========================================
    $update_inventaris = mysqli_query(
        $conn,
        "
        UPDATE inventaris
        SET status = 'Tersedia'
        WHERE id = $inventaris_id
        "
    );


    // ========================================
    // Catat Log Aktivitas
    // ========================================
    logAktivitas(
        $conn,
        "Perangkat dikembalikan",
        "Perangkat " . $nama_hardware .
        " dengan kode aset " . $kode_aset .
        " telah dikembalikan oleh " . $nama_peminjam .
        " dari divisi " . $divisi .
        " dan kembali tersedia untuk digunakan."
    );


    // ========================================
    // Pesan sukses
    // ========================================
    $_SESSION['flash_success'] =
        "Perangkat berhasil dikembalikan.";


} else {


    // ========================================
    // Pesan gagal
    // ========================================
    $_SESSION['flash_error'] =
        "Gagal memproses pengembalian: " .
        mysqli_error($conn);

}


// ========================================
// Kembali ke halaman peminjaman
// ========================================
header("Location: index.php");
exit;

?>