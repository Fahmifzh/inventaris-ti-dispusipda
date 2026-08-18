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

$id_peminjaman = (int)($_POST['id_peminjaman'] ?? 0);

if (!$id_peminjaman) {
    $_SESSION['flash_error'] = "Data peminjaman tidak valid.";
    header("Location: index.php");
    exit;
}

// Ambil data peminjaman terkait
$cek = mysqli_query($conn, "SELECT inventaris_id, status FROM peminjaman WHERE id = $id_peminjaman");
$row = $cek ? mysqli_fetch_assoc($cek) : null;

if (!$row) {
    $_SESSION['flash_error'] = "Data peminjaman tidak ditemukan.";
    header("Location: index.php");
    exit;
}

if ($row['status'] === 'Dikembalikan') {
    $_SESSION['flash_error'] = "Perangkat ini sudah dikembalikan sebelumnya.";
    header("Location: index.php");
    exit;
}

$inventaris_id = (int)$row['inventaris_id'];

// Update status peminjaman jadi Dikembalikan + isi tgl_kembali
$update = mysqli_query($conn, "
    UPDATE peminjaman
    SET status = 'Dikembalikan', tanggal_kembali = CURDATE()
    WHERE id = $id_peminjaman
");

if ($update) {
    // Aset balik jadi Aktif / tersedia dipinjam lagi
    mysqli_query($conn, "UPDATE inventaris SET status = 'Tersedia' WHERE id = $inventaris_id");
    $_SESSION['flash_success'] = "Perangkat berhasil dikembalikan.";
} else {
    $_SESSION['flash_error'] = "Gagal memproses pengembalian: " . mysqli_error($conn);
}

header("Location: index.php");
exit;