<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Load koneksi database
require_once __DIR__ . '/../../config/database.php';

// Cek koneksi
if (!$conn) {
    die("❌ Koneksi database gagal: " . mysqli_connect_error());
}

// Ambil data inventaris
$query = "SELECT * FROM inventaris ORDER BY id ASC";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("❌ Gagal mengambil data: " . mysqli_error($conn));
}

$assets = [];
while ($row = mysqli_fetch_assoc($result)) {
    $assets[] = $row;
}

$success = isset($_GET['success']) ? $_GET['success'] : '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DISPUSIPDA - Data Inventaris</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <!-- Custom CSS -->
    <link href="../../assets/css/dashboard.css" rel="stylesheet" />
    <link href="../../assets/css/inventaris.css" rel="stylesheet" />
    <link href="../../assets/css/sidebar.css" rel="stylesheet" />
</head>
<body>

<div class="container-fluid p-0">
    <div class="row g-0">

        <!-- ========================== -->
        <!-- SIDEBAR - DIPANGGIL DARI includes/ -->
        <!-- ========================== -->
        <?php include __DIR__ . '/../../includes/sidebar.php'; ?>

        <!-- ========================== -->
        <!-- MAIN CONTENT               -->
        <!-- ========================== -->
        <main class="main-content">

            <!-- TOPBAR -->
            <div class="topbar">
                <div>
                    <h2>📦 Data Inventaris</h2>
                    <p>Daftar seluruh aset perangkat TI DISPUSIPDA Provinsi Jawa Barat</p>
                </div>
                <div class="top-right">
                    <div class="notification">
                        <i class="bi bi-bell"></i>
                    </div>
                    <div class="profile">
                        <div class="profile-photo">A</div>
                        <div>
                            <h4>Admin TI</h4>
                            <span>Administrator</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- NOTIFIKASI SUKSES -->
            <?php if ($success === '1'): ?>
                <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> Data berhasil disimpan!
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- TOMBOL TAMBAH -->
            <div class="d-flex justify-content-end mb-3">
                <button class="btn-tambah-inventaris" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="bi bi-plus-circle"></i> Tambah Inventaris Baru
                </button>
            </div>

            <!-- FILTER BAR -->
            <div class="filter-bar">
                <div class="search-wrapper">
                    <span class="search-icon"><i class="bi bi-search"></i></span>
                    <input type="text" id="searchInput" placeholder="Cari kode aset atau nama perangkat…" />
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

            <!-- TABLE CARD -->
            <div class="table-card">
                <div class="table-header">
                    <h5><i class="bi bi-list-ul me-2"></i>Daftar Aset</h5>
                    <span class="badge-count"><?= count($assets) ?> Data</span>
                </div>

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
                            <?php if (empty($assets)): ?>
                                <tr>
                                    <td colspan="9" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                        Belum ada data inventaris.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php $no = 1; foreach ($assets as $asset): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><span class="kode-aset"><?= htmlspecialchars($asset['kode_aset'] ?? '') ?></span></td>
                                    <td class="nama-hardware"><?= htmlspecialchars($asset['nama_hardware'] ?? '') ?></td>
                                    <td><span class="badge-kategori"><?= htmlspecialchars($asset['kategori'] ?? '') ?></span></td>
                                    <td class="spesifikasi"><?= htmlspecialchars($asset['spesifikasi'] ?? '-') ?></td>
                                    <td><?= htmlspecialchars($asset['lokasi'] ?? '-') ?></td>
                                    <td><?= htmlspecialchars((string)($asset['tahun'] ?? '')) ?></td>
                                    <td>
                                        <?php
                                        $status = $asset['status'] ?? 'Tersedia';
                                        $statusMap = [
                                            'Tersedia'   => 'status-tersedia',
                                            'Dipinjam'   => 'status-dipinjam',
                                            'Maintenance' => 'status-maintenance'
                                        ];
                                        $statusClass = $statusMap[$status] ?? 'status-default';
                                        ?>
                                        <span class="status-badge <?= $statusClass ?>">
                                            <span class="dot"></span> <?= htmlspecialchars($status) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn-action primary" title="Detail"><i class="bi bi-eye"></i></button>
                                        <button class="btn-action danger" title="Hapus" onclick="confirmDelete(<?= (int)$asset['id'] ?>)"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- TABLE FOOTER -->
                <div class="table-footer">
                    <span class="info">Menampilkan <strong><?= count($assets) ?></strong> data aset</span>
                    <div class="pagination-custom">
                        <button class="page-btn" disabled>← Prev</button>
                        <button class="page-btn active">1</button>
                        <button class="page-btn">2</button>
                        <button class="page-btn">Next →</button>
                    </div>
                </div>
            </div>

        </main>
    </div>
</div>

<!-- ========================== -->
<!-- MODAL TAMBAH               -->
<!-- ========================== -->
<div class="modal fade modal-inventaris" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="proses/tambah.php" method="POST">
                <div class="modal-header">
                    <div>
                        <h5><i class="bi bi-plus-circle me-2 text-success"></i>Isi Data Perangkat</h5>
                        <small class="text-muted">Tambah inventaris aset TI baru ke sistem</small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label">Kode Aset</label>
                            <input type="text" name="kode_aset" class="form-control" placeholder="AST-011" required />
                        </div>
                        <div class="col-6">
                            <label class="form-label">Kategori</label>
                            <select name="kategori" class="form-select" required>
                                <?php foreach (['Laptop', 'Desktop', 'Printer', 'Networking', 'Server', 'UPS', 'Monitor', 'Lainnya'] as $kat): ?>
                                    <option value="<?= htmlspecialchars($kat) ?>"><?= htmlspecialchars($kat) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Nama Hardware</label>
                            <input type="text" name="nama_hardware" class="form-control" placeholder="Contoh: Laptop Dell Latitude 5530" required />
                        </div>
                        <div class="col-12">
                            <label class="form-label">Spesifikasi</label>
                            <textarea name="spesifikasi" class="form-control" rows="2" placeholder="Processor, RAM, Storage, dll."></textarea>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Lokasi</label>
                            <input type="text" name="lokasi" class="form-control" placeholder="Lt. 2 – Bidang TI" />
                        </div>
                        <div class="col-6">
                            <label class="form-label">Tahun</label>
                            <input type="number" name="tahun" class="form-control" value="2026" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-tambah-inventaris" style="padding: 10px 28px;">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========================== -->
<!-- MODAL HAPUS                -->
<!-- ========================== -->
<div class="modal fade modal-inventaris" id="modalHapus" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content text-center">
            <div class="modal-body p-4">
                <div class="text-danger mb-3"><i class="bi bi-trash3 fs-1"></i></div>
                <h6 class="fw-bold">Konfirmasi Hapus</h6>
                <p class="text-secondary small">Apakah Anda yakin ingin menghapus data ini?</p>
                <form id="formHapus" action="proses/hapus.php" method="POST">
                    <input type="hidden" name="id" id="hapusId" />
                    <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ========================== -->
<!-- SCRIPTS                    -->
<!-- ========================== -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const filterKategori = document.getElementById('filterKategori');
    const filterStatus = document.getElementById('filterStatus');
    const rows = document.querySelectorAll('#inventarisTable tbody tr');

    function filterTable() {
        const search = searchInput ? searchInput.value.toLowerCase() : '';
        const kategori = filterKategori ? filterKategori.value : '';
        const status = filterStatus ? filterStatus.value : '';

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            if (cells.length < 8) return;

            const kode = cells[1]?.textContent.toLowerCase() || '';
            const nama = cells[2]?.textContent.toLowerCase() || '';
            const kat = cells[3]?.textContent.trim() || '';
            const stat = cells[7]?.textContent.trim() || '';

            const matchSearch = kode.includes(search) || nama.includes(search);
            const matchKategori = kategori === '' || kat === kategori;
            const matchStatus = status === '' || stat.includes(status);

            row.style.display = (matchSearch && matchKategori && matchStatus) ? '' : 'none';
        });
    }

    if (searchInput) searchInput.addEventListener('keyup', filterTable);
    if (filterKategori) filterKategori.addEventListener('change', filterTable);
    if (filterStatus) filterStatus.addEventListener('change', filterTable);
});

function confirmDelete(id) {
    document.getElementById('hapusId').value = id;
    const modal = new bootstrap.Modal(document.getElementById('modalHapus'));
    modal.show();
}
</script>

</body>
</html>