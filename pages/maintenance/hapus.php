<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

include '../../config/database.php';
require_once '../../config/activity_log.php';


// ========================================
// Validasi ID
// ========================================
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int)$_GET['id'];


// ========================================
// Ambil data maintenance + data perangkat
// sebelum maintenance dihapus
// ========================================
$query = mysqli_query($conn, "
    SELECT
        maintenance.inventaris_id,
        inventaris.nama_hardware,
        inventaris.kode_aset
    FROM maintenance
    INNER JOIN inventaris
        ON maintenance.inventaris_id = inventaris.id
    WHERE maintenance.id = '$id'
");


// ========================================
// Cek apakah data maintenance ditemukan
// ========================================
if (!$query || mysqli_num_rows($query) === 0) {

    header(
        "Location: index.php?error=" .
        urlencode("Data maintenance tidak ditemukan.")
    );

    exit;
}


// ========================================
// Ambil data perangkat
// ========================================
$data = mysqli_fetch_assoc($query);

$inventaris_id = (int)$data['inventaris_id'];
$nama_hardware = $data['nama_hardware'];
$kode_aset = $data['kode_aset'];


// ========================================
// Kembalikan status inventaris menjadi Tersedia
// ========================================
$update_inventaris = mysqli_query($conn, "
    UPDATE inventaris
    SET status='Tersedia'
    WHERE id='$inventaris_id'
");


// ========================================
// Cek apakah update inventaris berhasil
// ========================================
if (!$update_inventaris) {

    header(
        "Location: index.php?error=" .
        urlencode(mysqli_error($conn))
    );

    exit;
}


// ========================================
// Hapus data maintenance
// ========================================
$hapus_maintenance = mysqli_query($conn, "
    DELETE FROM maintenance
    WHERE id='$id'
");


// ========================================
// Jika DELETE berhasil
// ========================================
if ($hapus_maintenance) {

    // ========================================
    // Catat aktivitas ke log_aktivitas
    // ========================================
    logAktivitas(
        $conn,
        "Maintenance dihapus",
        "Data maintenance perangkat " . $nama_hardware .
        " dengan kode aset " . $kode_aset .
        " telah dihapus dan perangkat dikembalikan ke status Tersedia."
    );


    // ========================================
    // Kembali ke halaman maintenance
    // ========================================
    header("Location: index.php");
    exit;

} else {

    // ========================================
    // Jika DELETE gagal
    // ========================================
    header(
        "Location: index.php?error=" .
        urlencode(mysqli_error($conn))
    );

    exit;
}
?>