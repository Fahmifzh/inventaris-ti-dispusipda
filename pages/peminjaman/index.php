<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

include '../../config/database.php';


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

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
/>

<style>
    .main-content {
    margin-left: 260px;
    padding: 30px;
    width: calc(100% - 260px);
    box-sizing: border-box;
}

.peminjaman-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 24px;
    gap: 16px;
    flex-wrap: wrap;
}
.peminjaman-header h2 { margin: 0 0 4px; }
.peminjaman-header p { margin: 0; color: #8a8fa3; font-size: 13.5px; }

.btn-tambah-peminjaman {
    background: #16215c;
    color: #fff;
    border: none;
    padding: 11px 20px;
    border-radius: 8px;
    font-size: 13.5px;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}
.btn-tambah-peminjaman:hover { background: #1c2a72; }

.alert-box { padding: 12px 16px; border-radius: 8px; font-size: 13.5px; margin-bottom: 18px; }
.alert-success { background: #e7f7ee; color: #1f9d55; }
.alert-error { background: #fdecec; color: #d64545; }

.card-peminjaman {
    background: #fff;
    border-radius: 14px;
    padding: 8px 0 0;
    box-shadow: 0 1px 3px rgba(20, 25, 60, 0.05);
    overflow-x: auto;
}

.table-peminjaman { width: 100%; border-collapse: collapse; min-width: 860px; }
.table-peminjaman thead th {
    text-align: left;
    font-size: 11px;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    color: #8a8fa3;
    font-weight: 600;
    padding: 14px 20px;
    border-bottom: 1px solid #edeef3;
}
.table-peminjaman tbody td {
    padding: 16px 20px;
    font-size: 13.5px;
    border-bottom: 1px solid #edeef3;
    color: #1c1c2b;
}
.table-peminjaman tbody tr:last-child td { border-bottom: none; }
.table-peminjaman tbody tr:hover { background: #fafbfe; }

.cell-nama { font-weight: 600; }
.badge-kode {
    background: #eef0fb;
    color: #2b3f9e;
    font-size: 11.5px;
    font-weight: 700;
    padding: 3px 9px;
    border-radius: 6px;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 12.5px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
}
.status-badge i { font-size: 7px; }
.status-dipinjam { background: #fef3e2; color: #d98b1f; }
.status-dikembalikan { background: #e7f7ee; color: #1f9d55; }

.btn-kembalikan {
    background: #fff;
    border: 1px solid #1f9d55;
    color: #1f9d55;
    font-size: 12px;
    font-weight: 600;
    padding: 6px 12px;
    border-radius: 7px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.btn-kembalikan:hover { background: #e7f7ee; }
.text-selesai { color: #8a8fa3; font-size: 12.5px; }
.empty-state { text-align: center; color: #8a8fa3; padding: 40px 20px !important; }
.table-footer-info { padding: 14px 20px; font-size: 12.5px; color: #8a8fa3; }

.modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(15, 20, 45, 0.45);
    align-items: center;
    justify-content: center;
    z-index: 100;
}
.modal-overlay.is-open { display: flex; }
.modal-box {
    background: #fff;
    width: 420px;
    max-width: 92vw;
    border-radius: 14px;
    padding: 24px;
    box-shadow: 0 20px 50px rgba(15, 20, 45, 0.25);
}
.modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; }
.modal-header h3 { margin: 0; font-size: 17px; color: #16215c; }
.modal-close { background: none; border: none; font-size: 22px; line-height: 1; color: #8a8fa3; cursor: pointer; }
.modal-form .form-group { margin-bottom: 16px; }
.form-row { display: flex; gap: 12px; }
.form-row .form-group { flex: 1; }
.modal-form label { display: block; font-size: 12.5px; font-weight: 600; color: #1c1c2b; margin-bottom: 6px; }
.modal-form input, .modal-form select {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #edeef3;
    border-radius: 8px;
    font-size: 13.5px;
    color: #1c1c2b;
    background: #fff;
}
.modal-form input:focus, .modal-form select:focus { outline: none; border-color: #2b3f9e; }
.modal-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 6px; }
.btn-batal {
    background: #fff;
    color: #1c1c2b;
    border: 1px solid #edeef3;
    padding: 10px 18px;
    border-radius: 8px;
    font-size: 13.5px;
    font-weight: 600;
    cursor: pointer;
}

@media (max-width: 768px) {
    .peminjaman-header { flex-direction: column; align-items: stretch; }
    .form-row { flex-direction: column; }
}
</style>

</head>

<body>

<?php include '../../includes/sidebar.php'; ?>

<div class="main-content">

    <div class="peminjaman-header">
        <div>
            <h2>Peminjaman Perangkat</h2>
            <p>Sirkulasi dan manajemen peminjaman aset TI pegawai DISPUSIPDA</p>
        </div>
        <button type="button" class="btn-tambah-peminjaman" onclick="document.getElementById('modalTambah').classList.add('is-open')">
            <i class="fa-solid fa-plus"></i> Input Peminjaman Baru
        </button>
    </div>

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
                            <td class="cell-nama"><?= htmlspecialchars($row['nama_peminjaman']) ?></td>
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
                                    <form action="proses_pengembalian.php" method="POST" style="display:inline;"
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
                <label for="nama_pegawai">Nama Pegawai</label>
                <input type="text" name="nama_pegawai" id="nama_pegawai" placeholder="Contoh: Drs. Ahmad Yusuf, M.M." required>
            </div>

            <div class="form-group">
                <label for="divisi">Divisi / Bidang</label>
                <input type="text" name="divisi" id="divisi" placeholder="Contoh: Bidang Pelestarian Arsip" required>
            </div>

            <div class="form-group">
                <label for="inventaris_id">Perangkat (hanya yang berstatus Tersedia)</label>
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
                    <label for="tgl_pinjam">Tanggal Pinjam</label>
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