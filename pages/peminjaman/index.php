<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

include '../../config/database.php';

// ===== SET VARIABEL TOPBAR =====
$page_title = "Peminjaman Perangkat";
$page_subtitle = "Sirkulasi dan manajemen peminjaman aset TI pegawai DISPUSIPDA";
$show_add_button = true;
$add_button_text = "Tambah";
$add_button_icon = "fa-solid fa-plus";
$add_button_target = "#modalTambah";


$result = mysqli_query($conn, "
    SELECT p.*, i.kode_aset, i.nama_hardware
    FROM peminjaman p
    JOIN inventaris i ON p.inventaris_id = i.id
    ORDER BY p.tanggal_pinjam DESC
");

$daftar_peminjaman = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $daftar_peminjaman[] = $row;
    }
}
$total_transaksi = count($daftar_peminjaman);

$result_aset = mysqli_query($conn, "
    SELECT id, kode_aset, nama_hardware
    FROM inventaris
    WHERE status = 'Tersedia'
    ORDER BY nama_hardware
");
$aset_tersedia = [];
if ($result_aset) {
    while ($row = mysqli_fetch_assoc($result_aset)) {
        $aset_tersedia[] = $row;
    }
}

function formatTglID($tanggal) {
    if (empty($tanggal) || $tanggal === '0000-00-00') return '-';
    $bulan = ['01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'Mei','06'=>'Jun',
              '07'=>'Jul','08'=>'Agu','09'=>'Sep','10'=>'Okt','11'=>'Nov','12'=>'Des'];
    $d = date('d', strtotime($tanggal));
    $m = $bulan[date('m', strtotime($tanggal))];
    $y = date('Y', strtotime($tanggal));
    return "$d $m $y";
}
?>
<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Peminjaman | DISPUSIPDA</title>

<!-- path dari pages/peminjaman/ ke assets/ butuh naik 2 folder -->
<link rel="stylesheet" href="../../assets/css/style.css">
<link rel="stylesheet" href="../../assets/css/sidebar.css">
  <link rel="stylesheet" href="../../assets/css/topbar.css">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
/>

<link rel="stylesheet" href="../../assets/css/peminjaman.css">


</head>

<body>

<?php include '../../includes/sidebar.php'; ?>

<div class="main-content peminjaman-content">

    <?php include '../../includes/topbar.php'; ?>

    <?php if (isset($_SESSION['flash_success'])): ?>
        <div class="alert-box alert-success"><?= htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['flash_error'])): ?>
        <div class="alert-box alert-error"><?= htmlspecialchars($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?></div>
    <?php endif; ?>

    <div class="card-peminjaman">
        <table class="table-peminjaman">
            <thead>
                <tr>
                    <th>Nama Pegawai</th>
                    <th>Divisi / Bidang</th>
                    <th>Perangkat</th>
                    <th>Kode</th>
                    <th>Tgl Pinjam</th>
                    <th>Est. Kembali</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($total_transaksi === 0): ?>
                    <tr>
                        <td colspan="8" class="empty-state">Belum ada transaksi peminjaman.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($daftar_peminjaman as $row): ?>
                        <tr>
                            <td class="cell-nama"><?= htmlspecialchars($row['nama_peminjam']) ?></td>
                            <td><?= htmlspecialchars($row['divisi']) ?></td>
                            <td><?= htmlspecialchars($row['nama_hardware']) ?></td>
                            <td><span class="badge-kode"><?= htmlspecialchars($row['kode_aset']) ?></span></td>
                            <td><?= formatTglID($row['tanggal_pinjam']) ?></td>
                            <td><?= formatTglID($row['est_kembali']) ?></td>
                            <td>
                                <?php if ($row['status'] === 'Dipinjam'): ?>
                                    <span class="status-badge status-dipinjam"><i class="fa-solid fa-circle"></i> Dipinjam</span>
                                <?php else: ?>
                                    <span class="status-badge status-dikembalikan"><i class="fa-solid fa-circle"></i> Dikembalikan</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($row['status'] === 'Dipinjam'): ?>
                                    <form action="proses_kembalikan.php" method="POST" style="display:inline;"
                                          onsubmit="return confirm('Konfirmasi pengembalian perangkat ini?');">
                                        <input type="hidden" name="id_peminjaman" value="<?= (int)$row['id'] ?>">
                                        <button type="submit" class="btn-kembalikan">
                                            <i class="fa-solid fa-rotate-left"></i> Kembalikan
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-selesai">Selesai</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="table-footer-info">Total <?= $total_transaksi ?> transaksi peminjaman</div>
    </div>

</div>

<!-- ================= Modal: Input Peminjaman Baru ================= -->
<div class="modal-overlay" id="modalTambah">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Input Peminjaman Baru</h3>
            <button type="button" class="modal-close" onclick="document.getElementById('modalTambah').classList.remove('is-open')">&times;</button>
        </div>
        <!-- action cukup nama file, karena proses_tambah.php ada di folder yang SAMA -->
        <form action="proses_tambah.php" method="POST" class="modal-form">
            <div class="form-group">
                <label for="nama_peminjam">Nama Pegawai</label>
                <input type="text" name="nama_peminjam" id="nama_peminjam" placeholder="Contoh: Drs. Ahmad Yusuf, M.M." required>
            </div>

            <div class="form-group">
                <label for="divisi">Divisi / Bidang</label>
                <input type="text" name="divisi" id="divisi" placeholder="Contoh: Bidang Pelestarian Arsip" required>
            </div>

            <div class="form-group">
                <label for="inventaris_id">Perangkat (hanya yang berstatus Aktif)</label>
                <select name="inventaris_id" id="inventaris_id" required>
                    <option value="" disabled selected>Pilih perangkat</option>
                    <?php foreach ($aset_tersedia as $a): ?>
                        <option value="<?= (int)$a['id'] ?>">
                            <?= htmlspecialchars($a['kode_aset']) ?> — <?= htmlspecialchars($a['nama_hardware']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="tanggal_pinjam">Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" value="<?= date('Y-m-d') ?>" required>
                </div>
                <div class="form-group">
                    <label for="est_kembali">Estimasi Kembali</label>
                    <input type="date" name="est_kembali" id="est_kembali" required>
                </div>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-batal" onclick="document.getElementById('modalTambah').classList.remove('is-open')">Batal</button>
                <button type="submit" class="btn-tambah-peminjaman">Simpan Peminjaman</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>