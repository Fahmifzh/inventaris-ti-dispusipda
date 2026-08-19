<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../../login.php");
    exit;
}

include '../../../config/database.php';
require_once '../../../config/activity_log.php';


// ========================================
// Ambil ID inventaris
// ========================================
$id = (int)$_POST['id'];


// ========================================
// Ambil data perangkat sebelum dihapus
// ========================================
$query_data = "
    SELECT 
        nama_hardware,
        kode_aset
    FROM inventaris
    WHERE id = $id
";

$result_data = mysqli_query($conn, $query_data);


// ========================================
// Cek apakah data inventaris ditemukan
// ========================================
if (!$result_data || mysqli_num_rows($result_data) === 0) {

    header(
        "Location: ../index.php?error=" .
        urlencode("Data inventaris tidak ditemukan.")
    );

    exit;
}


// ========================================
// Simpan data perangkat ke variabel
// ========================================
$data = mysqli_fetch_assoc($result_data);

$nama_hardware = $data['nama_hardware'];
$kode_aset = $data['kode_aset'];


// ========================================
// Hapus inventaris
// ========================================
$query = "DELETE FROM inventaris WHERE id = $id";


// ========================================
// Jalankan DELETE
// ========================================
if (mysqli_query($conn, $query)) {

    // ========================================
    // Catat aktivitas ke log_aktivitas
    // ========================================
    logAktivitas(
        $conn,
        "Inventaris dihapus",
        "Perangkat " . $nama_hardware .
        " dengan kode aset " . $kode_aset .
        " berhasil dihapus dari sistem."
    );

    // ========================================
    // Kembali ke halaman inventaris
    // ========================================
    header("Location: ../index.php?success=2");
    exit;

} else {

    // ========================================
    // Jika DELETE gagal
    // ========================================
    header(
        "Location: ../index.php?error=" .
        urlencode(mysqli_error($conn))
    );

    exit;
}
?>