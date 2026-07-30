<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

include '../../config/database.php';

// Ambil data inventaris
$result = mysqli_query($conn, "SELECT * FROM inventaris ORDER BY id ASC");
$assets = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $assets[] = $row;
    }
}
$total_aset = count($assets);

// Hitung statistik
$total_tersedia = $total_dipinjam = $total_maintenance = 0;
foreach ($assets as $a) {
    if ($a['status'] === 'Tersedia') $total_tersedia++;
    elseif ($a['status'] === 'Dipinjam') $total_dipinjam++;
    elseif ($a['status'] === 'Maintenance') $total_maintenance++;
}

$success = isset($_GET['success']) ? $_GET['success'] : '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris | DISPUSIPDA</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/sidebar.css">
    <link rel="stylesheet" href="../../assets/css/inventaris.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>

<?php include '../../includes/sidebar.php'; ?>

<div class="main-content">

    <!-- HEADER -->
    <div class="inventaris-header">
        <div>
            <h2>📦 Data Inventaris</h2>
            <p>Daftar seluruh aset perangkat TI DISPUSIPDA Provinsi Jawa Barat</p>
        </div>
        <button type="button" class="btn-tambah-inventaris" onclick="document.getElementById('modalTambah').classList.add('is-open')">
            <i class="fa-solid fa-plus"></i> Tambah Inventaris Baru
        </button>
    </div>

    <!-- NOTIFIKASI SUKSES -->
    <?php if ($success === '1'): ?>
        <div class="alert-box alert-success">
            <i class="fa-solid fa-check-circle"></i> Data berhasil disimpan!
        </div>
    <?php endif; ?>

    <!-- STATISTIK -->
    <div class="stat-grid">
        <div class="stat-card">
            <div class="icon blue"><i class="fa-solid fa-computer"></i></div>
            <div class="info">
                <h4><?= $total_aset ?></h4>
                <span>Total Aset</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="icon green"><i class="fa-solid fa-check-circle"></i></div>
            <div class="info">
                <h4><?= $total_tersedia ?></h4>
                <span>Tersedia</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="icon yellow"><i class="fa-solid fa-hand"></i></div>
            <div class="info">
                <h4><?= $total_dipinjam ?></h4>
                <span>Dipinjam</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="icon red"><i class="fa-solid fa-screwdriver-wrench"></i></div>
            <div class="info">
                <h4><?= $total_maintenance ?></h4>
                <span>Maintenance</span>
            </div>
        </div>
    </div>

    <!-- FILTER BAR -->
    <div class="filter-bar">
        <div class="search-wrapper">
            <span class="search-icon"><i class="fa-solid fa-search"></i></span>
            <input type="text" id="searchInput" placeholder="Cari kode aset atau nama perangkat…">
        </div>
        <select id="filterKategori">
            <option value="">Semua Kategori</option>
            <?php foreach (['Laptop', 'Desktop', 'Printer', 'Networking', 'Server', 'UPS', 'Monitor', 'Lainnya'] as $kat): ?>
                <option value="<?= htmlspecialchars($kat) ?>"><?= htmlspecialchars($kat) ?></option>
            <?php endforeach; ?>
        </select>
        <select id="filterStatus">
            <option value="">Semua Status</option>
            <option value="Tersedia">Tersedia</option>
            <option value="Dipinjam">Dipinjam</option>
            <option value="Maintenance">Maintenance</option>
        </select>
    </div>

    <!-- TABLE -->
    <div class="card-inventaris">
        <table class="table-inventaris" id="inventarisTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Aset</th>
                    <th>Nama Hardware</th>
                    <th>Kategori</th>
                    <th>Spesifikasi</th>
                    <th>Lokasi</th>
                    <th>Tahun</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($total_aset === 0): ?>
                    <tr><td colspan="9" class="empty-state">
                        <i class="fa-solid fa-inbox fa-2x d-block mb-2" style="color:#d0d3e0;"></i>
                        Belum ada data inventaris.
                    </td></tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($assets as $asset): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><span class="cell-kode"><?= htmlspecialchars($asset['kode_aset']) ?></span></td>
                        <td class="cell-nama"><?= htmlspecialchars($asset['nama_hardware']) ?></td>
                        <td><span class="badge-kategori"><?= htmlspecialchars($asset['kategori']) ?></span></td>
                        <td><span class="spesifikasi-text"><?= htmlspecialchars($asset['spesifikasi'] ?? '-') ?></span></td>
                        <td><?= htmlspecialchars($asset['lokasi'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($asset['tahun'] ?? '-') ?></td>
                        <td>
                            <?php
                            $status = $asset['status'] ?? 'Tersedia';
                            $class = 'status-tersedia';
                            if ($status === 'Dipinjam') $class = 'status-dipinjam';
                            elseif ($status === 'Maintenance') $class = 'status-maintenance';
                            ?>
                            <span class="status-badge <?= $class ?>">
                                <i class="fa-solid fa-circle"></i> <?= htmlspecialchars($status) ?>
                            </span>
                        </td>
                        <td>
                            <button class="btn-action" title="Detail"><i class="fa-solid fa-eye"></i></button>
                            <button class="btn-action danger" title="Hapus" onclick="confirmDelete(<?= (int)$asset['id'] ?>)">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="table-footer-info">Total <?= $total_aset ?> data aset</div>
    </div>

</div>

<!-- ================= MODAL TAMBAH ================= -->
<div class="modal-overlay" id="modalTambah">
    <div class="modal-box">
        <div class="modal-header">
            <h3><i class="fa-solid fa-plus-circle" style="color:#1f9d55;"></i> Isi Data Perangkat</h3>
            <button type="button" class="modal-close" onclick="document.getElementById('modalTambah').classList.remove('is-open')">&times;</button>
        </div>
        <form action="proses/tambah.php" method="POST" class="modal-form">
            <div class="form-row">
                <div class="form-group">
                    <label for="kode_aset">Kode Aset</label>
                    <input type="text" name="kode_aset" id="kode_aset" placeholder="AST-011" required>
                </div>
                <div class="form-group">
                    <label for="kategori">Kategori</label>
                    <select name="kategori" id="kategori" required>
                        <option value="Laptop">Laptop</option>
                        <option value="Desktop">Desktop</option>
                        <option value="Printer">Printer</option>
                        <option value="Networking">Networking</option>
                        <option value="Server">Server</option>
                        <option value="UPS">UPS</option>
                        <option value="Monitor">Monitor</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="nama_hardware">Nama Hardware</label>
                <input type="text" name="nama_hardware" id="nama_hardware" placeholder="Contoh: Laptop Dell Latitude 5530" required>
            </div>
            <div class="form-group">
                <label for="spesifikasi">Spesifikasi</label>
                <textarea name="spesifikasi" id="spesifikasi" placeholder="Processor, RAM, Storage, dll." rows="2"></textarea>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="lokasi">Lokasi</label>
                    <input type="text" name="lokasi" id="lokasi" placeholder="Lt. 2 – Bidang TI">
                </div>
                <div class="form-group">
                    <label for="tahun">Tahun</label>
                    <input type="number" name="tahun" id="tahun" value="<?= date('Y') ?>">
                </div>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-batal" onclick="document.getElementById('modalTambah').classList.remove('is-open')">Batal</button>
                <button type="submit" class="btn-simpan">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<!-- ================= MODAL HAPUS ================= -->
<div class="modal-overlay" id="modalHapus">
    <div class="modal-box" style="max-width:400px; text-align:center;">
        <div class="modal-header" style="justify-content:center; border-bottom:none; padding-bottom:0;">
            <div style="width:56px; height:56px; border-radius:50%; background:#fdecec; display:flex; align-items:center; justify-content:center; margin-bottom:8px;">
                <i class="fa-solid fa-trash-can" style="font-size:24px; color:#d64545;"></i>
            </div>
        </div>
        <h3 style="margin:0 0 6px; font-size:18px; color:#1c1c2b;">Konfirmasi Hapus</h3>
        <p style="color:#8a8fa3; font-size:14px; margin-bottom:20px;">Apakah Anda yakin ingin menghapus data ini?</p>
        <form id="formHapus" action="proses/hapus.php" method="POST">
            <input type="hidden" name="id" id="hapusId">
            <div style="display:flex; justify-content:center; gap:10px;">
                <button type="button" class="btn-batal" onclick="document.getElementById('modalHapus').classList.remove('is-open')">Batal</button>
                <button type="submit" style="background:#d64545; color:#fff; border:none; padding:10px 24px; border-radius:8px; font-size:13.5px; font-weight:600; cursor:pointer;">Ya, Hapus</button>
            </div>
        </form>
    </div>
</div>

<!-- SCRIPTS -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const filterKategori = document.getElementById('filterKategori');
    const filterStatus = document.getElementById('filterStatus');
    const rows = document.querySelectorAll('#inventarisTable tbody tr');

    function filterTable() {
        const search = searchInput?.value.toLowerCase() || '';
        const kategori = filterKategori?.value || '';
        const status = filterStatus?.value || '';

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            if (cells.length < 9) return;
            const kode = cells[1]?.textContent.toLowerCase() || '';
            const nama = cells[2]?.textContent.toLowerCase() || '';
            const kat = cells[3]?.textContent.trim() || '';
            const stat = cells[7]?.textContent.trim() || '';
            row.style.display = (kode.includes(search) || nama.includes(search)) &&
                (kategori === '' || kat === kategori) &&
                (status === '' || stat.includes(status)) ? '' : 'none';
        });
    }

    if (searchInput) searchInput.addEventListener('keyup', filterTable);
    if (filterKategori) filterKategori.addEventListener('change', filterTable);
    if (filterStatus) filterStatus.addEventListener('change', filterTable);
});

function confirmDelete(id) {
    document.getElementById('hapusId').value = id;
    document.getElementById('modalHapus').classList.add('is-open');
}

document.querySelectorAll('.modal-overlay').forEach(modal => {
    modal.addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('is-open');
    });
});
</script>

</body>
</html>