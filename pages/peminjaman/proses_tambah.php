<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

include '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: index.php");
    exit;
}

$nama_peminjam  = mysqli_real_escape_string($conn, $_POST['nama_peminjam']);
$divisi         = mysqli_real_escape_string($conn, $_POST['divisi']);
$inventaris_id  = (int)$_POST['inventaris_id'];
$tanggal_pinjam = mysqli_real_escape_string($conn, $_POST['tanggal_pinjam']);
$est_kembali    = mysqli_real_escape_string($conn, $_POST['est_kembali']);

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

// Simpan data peminjaman
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

    // ubah status inventaris
    mysqli_query($conn,"
        UPDATE inventaris
        SET status='Dipinjam'
        WHERE id='$inventaris_id'
    ");

    $_SESSION['flash_success']="Peminjaman berhasil ditambahkan.";

} else {

    $_SESSION['flash_error']="Gagal menyimpan data.";

}

header("Location: index.php");
exit;