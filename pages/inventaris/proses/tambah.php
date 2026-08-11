<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../../login.php");
    exit;
}

include '../../../config/database.php';

// Ambil data dari form
$kode_aset = mysqli_real_escape_string($conn, $_POST['kode_aset']);
$kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
$nama_hardware = mysqli_real_escape_string($conn, $_POST['nama_hardware']);
$spesifikasi = mysqli_real_escape_string($conn, $_POST['spesifikasi']);
$ruangan_id = (int)$_POST['lokasi'];
$tahun = (int)$_POST['tahun'];
$status = 'Tersedia';
$kondisi = 'Baik';
$created_at = date('Y-m-d H:i:s');

// Cek apakah kode_aset sudah ada
$cek = mysqli_query($conn, "SELECT id FROM inventaris WHERE kode_aset = '$kode_aset'");
if (mysqli_num_rows($cek) > 0) {
    header("Location: ../index.php?error=Kode Aset sudah terdaftar!");
    exit;
}

// Query insert
$query = "INSERT INTO inventaris (
    kode_aset,
    kategori,
    nama_hardware,
    spesifikasi,
    ruangan_id,
    tahun_pengadaan,
    status,
    kondisi,
    created_at
) VALUES (
    '$kode_aset',
    '$kategori',
    '$nama_hardware',
    '$spesifikasi',
    $ruangan_id,
    $tahun,
    '$status',
    '$kondisi',
    '$created_at'
)";

if (mysqli_query($conn, $query)) {
    header("Location: ../index.php?success=1");
} else {
    header("Location: ../index.php?error=" . urlencode(mysqli_error($conn)));
}
exit;
?>