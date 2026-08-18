<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

// ===== SET VARIABEL TOPBAR =====
$page_title = "Data Inventaris";
$page_subtitle = "Daftar seluruh aset perangkat TI DISPUSIPDA Provinsi Jawa Barat";
$show_add_button = true;
$add_button_text = "Tambah";
$add_button_icon = "fa-solid fa-plus";
$add_button_target = "#modalTambah";
// ================================

include '../../config/database.php';

// ============================================================
// AMBIL DATA INVENTARIS DENGAN JOIN KE RUANGAN, LANTAI, GEDUNG
// ============================================================
$query = "
    SELECT 
        i.*,
        r.nama_ruangan,
        r.kode_ruangan,
        l.nama_lantai,
        g.nama_gedung
    FROM inventaris i
    LEFT JOIN ruangan r ON i.ruangan_id = r.id
    LEFT JOIN lantai l ON r.lantai_id = l.id
    LEFT JOIN gedung g ON l.gedung_id = g.id
    ORDER BY i.id ASC
";
$result = mysqli_query($conn, $query);
$assets = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $assets[] = $row;
    }
}
$total_aset = count($assets);

$success = isset($_GET['success']) ? $_GET['success'] : '';
$error = isset($_GET['error']) ? $_GET['error'] : '';

// ============================================================
// AMBIL DATA LOKASI UNTUK DROPDOWN DI MODAL TAMBAH
// ============================================================
$queryLokasi = "
    SELECT 
        g.nama_gedung,
        l.nama_lantai,
        r.kode_ruangan,
        r.nama_ruangan,
        r.id as ruangan_id
    FROM ruangan r
    JOIN lantai l ON r.lantai_id = l.id
    JOIN gedung g ON l.gedung_id = g.id
    ORDER BY g.nama_gedung, l.nama_lantai, r.nama_ruangan
";
$resultLokasi = mysqli_query($conn, $queryLokasi);
$listLokasi = [];
if ($resultLokasi) {
    while ($row = mysqli_fetch_assoc($resultLokasi)) {
        $listLokasi[] = $row;
    }
}

// ============================================================
// DAFTAR KATEGORI (UNTUK FILTER DAN FORM)
// ============================================================
$kategoriList = ['PC', 'Printer', 'Proyektor', 'Monitor', 'CPU', 'Laptop', 'Scanner', 'Access Point', 'Switch', 'Smart TV'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris | DISPUSIPDA</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/topbar.css">
    <link rel="stylesheet" href="../../assets/css/sidebar.css">
    <link rel="stylesheet" href="../../assets/css/inventaris.css?v=<?= time(); ?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>

<?php include '../../includes/sidebar.php'; ?>

<div class="main-content">

    <!-- ===== TOPBAR ===== -->
    <?php include '../../includes/topbar.php'; ?>

    <!-- NOTIFIKASI SUKSES -->
    <?php if ($success === '1'): ?>
        <div class="alert-box alert-success">
            <i class="fa-solid fa-check-circle"></i> Data berhasil disimpan!
        </div>
    <?php endif; ?>

    <?php if ($success === '2'): ?>
        <div class="alert-box alert-success">
            <i class="fa-solid fa-check-circle"></i> Data berhasil dihapus!
        </div>
    <?php endif; ?>

    <!-- NOTIFIKASI ERROR -->
    <?php if (!empty($error)): ?>
        <div class="alert-box alert-error">
            <i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <!-- FILTER BAR -->
    <div class="filter-bar" style="display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap;">
        <div style="display: flex; gap: 12px; flex: 1; min-width: 280px;">
            <div class="search-wrapper" style="flex: 1;">
                <span class="search-icon"><i class="fa-solid fa-search"></i></span>
                <input type="text" id="searchInput" placeholder="Cari kode aset atau nama perangkat…">
            </div>
            <select id="filterKategori">
                <option value="">Semua Kategori</option>
                <?php foreach ($kategoriList as $kat): ?>
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
        <div>
            <button type="button" class="btn-import-excel" onclick="document.getElementById('modalImport').classList.add('is-open')" title="Import Excel">
                <i class="fa-solid fa-file-excel"></i>
            </button>
        </div>
    </div>

    <!-- TABLE / CARD CONTAINER -->
    <div class="card-inventaris">
        <div class="table-responsive">
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
                        <tr class="empty-row">
                            <td colspan="9" class="empty-state">
                                <i class="fa-solid fa-inbox"></i>
                                <span>Belum ada data inventaris.</span>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($assets as $asset): ?>
                        <tr>
                            <td data-label="No"><?= $no++ ?></td>
                            <td data-label="Kode Aset"><span class="cell-kode"><?= htmlspecialchars($asset['kode_aset']) ?></span></td>
                            <td data-label="Nama Hardware" class="cell-nama"><?= htmlspecialchars($asset['nama_hardware']) ?></td>
                            <td data-label="Kategori"><span class="badge-kategori"><?= htmlspecialchars($asset['kategori']) ?></span></td>
                            <td data-label="Spesifikasi"><span class="spesifikasi-text"><?= htmlspecialchars($asset['spesifikasi'] ?? '-') ?></span></td>
                            <td data-label="Lokasi">
                                <?php 
                                if (!empty($asset['nama_gedung'])) {
                                    echo htmlspecialchars($asset['nama_gedung']) . ' - ' . 
                                         htmlspecialchars($asset['nama_lantai']) . ' - ' . 
                                         htmlspecialchars($asset['nama_ruangan']);
                                } else {
                                    echo '-';
                                }
                                ?>
                            </td>
                            <td data-label="Tahun"><?= htmlspecialchars($asset['tahun_pengadaan'] ?? '-') ?></td>
                            <td data-label="Status">
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
                            <td data-label="Aksi">
                                <div class="action-buttons">
                                    <button class="btn-action" title="Detail"><i class="fa-solid fa-eye"></i></button>
                                    <button class="btn-action danger" title="Hapus" onclick="confirmDelete(<?= (int)$asset['id'] ?>)">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="table-footer-info">Total <?= $total_aset ?> data aset</div>
    </div>

</div>

<!-- ================= MODAL IMPORT EXCEL ================= -->
<div class="modal-overlay" id="modalImport">
    <div class="modal-box">
        <div class="modal-header">
            <h3><i class="fa-solid fa-file-excel" style="color:#107c41;"></i> Import Data Excel</h3>
            <button type="button" class="modal-close" onclick="document.getElementById('modalImport').classList.remove('is-open')">&times;</button>
        </div>
        <form action="proses/process_import.php" method="POST" enctype="multipart/form-data" class="modal-form">
            <div class="form-group">
                <label for="file_excel">Pilih File Excel (.xlsx)</label>
                <input type="file" name="file_excel" id="file_excel" accept=".xlsx, .xls" required style="padding: 8px;">
                <small style="color: #666; font-size: 12px; margin-top: 6px; display: block;">
                    * Pastikan file yang diunggah sesuai format sheet inventaris DISPUSIPDA.
                </small>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-batal" onclick="document.getElementById('modalImport').classList.remove('is-open')">Batal</button>
                <button type="submit" name="import" class="btn-simpan" style="background-color: #107c41;">Upload & Import</button>
            </div>
        </form>
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
                        <?php foreach ($kategoriList as $kat): ?>
                            <option value="<?= htmlspecialchars($kat) ?>"><?= htmlspecialchars($kat) ?></option>
                        <?php endforeach; ?>
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
                    <select name="lokasi" id="lokasi" required>
                        <option value="">-- Pilih Lokasi --</option>
                        <?php foreach ($listLokasi as $lok): ?>
                            <option value="<?= htmlspecialchars($lok['ruangan_id']) ?>">
                                <?= htmlspecialchars($lok['nama_gedung']) ?> - 
                                <?= htmlspecialchars($lok['nama_lantai']) ?> - 
                                <?= htmlspecialchars($lok['nama_ruangan']) ?> 
                                (<?= htmlspecialchars($lok['kode_ruangan']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
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
    <div class="modal-box modal-box-sm">
        <div class="modal-header modal-header-center">
            <div class="delete-icon-wrapper">
                <i class="fa-solid fa-trash-can"></i>
            </div>
        </div>
        <h3 class="modal-title-center">Konfirmasi Hapus</h3>
        <p class="modal-text-center">Apakah Anda yakin ingin menghapus data ini?</p>
        <form id="formHapus" action="proses/hapus.php" method="POST">
            <input type="hidden" name="id" id="hapusId">
            <div class="modal-actions-center">
                <button type="button" class="btn-batal" onclick="document.getElementById('modalHapus').classList.remove('is-open')">Batal</button>
                <button type="submit" class="btn-hapus-confirm">Ya, Hapus</button>
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