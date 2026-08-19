<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

include '../../config/database.php';
require_once '../../config/activity_log.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: index.php");
    exit;
}

$nama_peminjam  = mysqli_real_escape_string($conn, $_POST['nama_peminjam']);
$divisi         = mysqli_real_escape_string($conn, $_POST['divisi']);
$inventaris_id  = (int)$_POST['inventaris_id'];
$tanggal_pinjam = mysqli_real_escape_string($conn, $_POST['tanggal_pinjam']);
$est_kembali    = mysqli_real_escape_string($conn, $_POST['est_kembali']);


// ========================================
// Validasi data
// ========================================
if (
    empty($nama_peminjam) ||
    empty($divisi) ||
    empty($inventaris_id) ||
    empty($tanggal_pinjam) ||
    empty($est_kembali)
) {
    $_SESSION['flash_error'] = "Semua data harus diisi.";
    header("Location: index.php");
    exit;
}


// ========================================
// Ambil data perangkat
// ========================================
$query_perangkat = mysqli_query($conn, "
    SELECT
        kode_aset,
        nama_hardware
    FROM inventaris
    WHERE id='$inventaris_id'
");


// ========================================
// Cek perangkat
// ========================================
if (!$query_perangkat || mysqli_num_rows($query_perangkat) === 0) {

    $_SESSION['flash_error'] = "Perangkat tidak ditemukan.";
    header("Location: index.php");
    exit;
}


$data_perangkat = mysqli_fetch_assoc($query_perangkat);

$kode_aset = $data_perangkat['kode_aset'];
$nama_hardware = $data_perangkat['nama_hardware'];


// ========================================
// Simpan data peminjaman
// ========================================
$query = mysqli_query($conn, "
INSERT INTO peminjaman
(
    inventaris_id,
    nama_peminjam,
    divisi,
    tanggal_pinjam,
    est_kembali,
    status
)
VALUES
(
    '$inventaris_id',
    '$nama_peminjam',
    '$divisi',
    '$tanggal_pinjam',
    '$est_kembali',
    'Dipinjam'
)
");


if ($query) {

    // ========================================
    // Ubah status inventaris
    // ========================================
    $update_inventaris = mysqli_query($conn,"
        UPDATE inventaris
        SET status='Dipinjam'
        WHERE id='$inventaris_id'
    ");


    // ========================================
    // Catat Log Aktivitas
    // ========================================
    logAktivitas(
        $conn,
        "Perangkat dipinjam",
        "Perangkat " . $nama_hardware .
        " dengan kode aset " . $kode_aset .
        " dipinjam oleh " . $nama_peminjam .
        " dari divisi " . $divisi . "."
    );


    // ========================================
    // Pesan sukses
    // ========================================
    $_SESSION['flash_success'] = "Peminjaman berhasil ditambahkan.";

} else {

    // ========================================
    // Pesan gagal
    // ========================================
    $_SESSION['flash_error'] = "Gagal menyimpan data.";

}


header("Location: index.php");
exit;
?>