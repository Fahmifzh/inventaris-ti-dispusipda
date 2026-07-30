<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

include '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

$nama_hardware  = mysqli_real_escape_string($conn, $_POST['nama_hardware'] ?? '');
$divisi        = mysqli_real_escape_string($conn, $_POST['divisi'] ?? '');
$inventaris_id = (int)($_POST['id_inventaris'] ?? 0);
$tanggal_pinjam    = mysqli_real_escape_string($conn, $_POST['tanggal_pinjam'] ?? '');
$est_kembali   = mysqli_real_escape_string($conn, $_POST['est_kembali'] ?? '');

// Validasi dasar
if ($nama_hardware === '' || $divisi === '' || !$inventaris_id || $tanggal_pinjam === '' || $est_kembali === '') {
    $_SESSION['flash_error'] = "Semua field wajib diisi.";
    header("Location: index.php");
    exit;
}

if (strtotime($est_kembali) < strtotime($tanggal_pinjam)) {
    $_SESSION['flash_error'] = "Estimasi kembali tidak boleh sebelum tanggal pinjam.";
    header("Location: index.php");
    exit;
}

// Pastikan aset masih berstatus "Aktif" (hindari double booking)
$cekAset = mysqli_query($conn, "SELECT status FROM inventaris WHERE id = $inventaris_id");
$asetRow = $cekAset ? mysqli_fetch_assoc($cekAset) : null;

if (!$asetRow || $asetRow['status'] !== 'Aktif') {
    $_SESSION['flash_error'] = "Perangkat yang dipilih tidak lagi berstatus Aktif/Tersedia.";
    header("Location: index.php");
    exit;
}

// Insert peminjaman + update status inventaris
$insert = mysqli_query($conn, "
    INSERT INTO peminjaman (nama_hardware, divisi, inventaris_id, tanggal_pinjam, est_kembali, status)
    VALUES ('$nama_hardware', '$divisi', $inventaris_id, '$tanggal_pinjam', '$est_kembali', 'Dipinjam')
");

if ($insert) {
    mysqli_query($conn, "UPDATE inventaris SET status = 'Dipinjam' WHERE id = $inventaris_id");
    $_SESSION['flash_success'] = "Peminjaman berhasil disimpan.";
} else {
    $_SESSION['flash_error'] = "Gagal menyimpan peminjaman: " . mysqli_error($conn);
}

header("Location: index.php");
exit;