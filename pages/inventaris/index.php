<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Load file koneksi PDO
require_once '../../config/database.php';

try {
    // Ambil data inventaris menggunakan PDO
    $stmt = $pdo->query("SELECT * FROM inventaris ORDER BY id ASC");
    $assets = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Gagal mengambil data inventaris: " . $e->getMessage());
}

// Cek apakah ada notifikasi sukses
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

    <!-- Custom CSS -->
    <link href="../../assets/css/style.css" rel="stylesheet" />
    <link href="../../assets/css/inventaris.css" rel="stylesheet" />

    <style>
        /* SIDEBAR STYLE */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 100;
            padding: 0;
            box-shadow: inset -1px 0 0 rgba(0,0,0,0.1);
            background: #0c2461 !important;
            width: 240px;
        }
        .sidebar .nav-link {
            color: #adb5bd;
            padding: 10px 20px;
            border-radius: 8px;
            margin: 2px 12px;
            font-size: 14px;
        }
        .sidebar .nav-link:hover {
            background: #1a3a8a;
            color: #fff;
        }
        .sidebar .nav-link.active {
            background: #ffffff;
            color: #0c2461;
            font-weight: 600;
        }
        .sidebar .nav-link i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }
        .sidebar-brand {
            font-size: 18px;
            font-weight: 700;
            color: #fff;
            padding: 20px 20px 10px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar-brand small {
            display: block;
            font-size: 11px;
            font-weight: 400;
            color: #94a3b8;
            margin-top: 2px;
        }

        /* MAIN CONTENT OFFSET */
        .main-content {
            margin-left: 240px;
            padding: 24px 32px 40px;
            min-height: 100vh;
            background: #f5f7fb;
        }

        /* USER PROFILE DI SIDEBAR */
        .sidebar-user {
            padding: 16px 20px;
            border-top: 1px solid rgba(255,255,255,0.08);
            margin-top: 20px;
        }
        .sidebar-user .name {
            color: #fff;
            font-size: 14px;
            font-weight: 600;
        }
        .sidebar-user .email {
            color: #94a3b8;
            font-size: 12px;
        }
        .sidebar-user .logout {
            color: #f87171;
            text-decoration: none;
            font-size: 13px;
        }
        .sidebar-user .logout:hover {
            color: #fca5a5;
        }

        /* MENU UTAMA LABEL */
        .menu-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.8px;
            color: #6b7a8f;
            text-transform: uppercase;
            padding: 12px 20px 6px;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                min-height: 60px;
            }
            .sidebar .nav {
                flex-direction: row;
                overflow-x: auto;
                flex-wrap: nowrap;
            }
            .sidebar .nav-link {
                white-space: nowrap;
            }
            .main-content {
                margin-left: 0;
                padding: 16px;
            }
            .sidebar-brand {
                text-align: center;
            }
            .sidebar-user {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="container-fluid p-0">
    <div class="row g-0">

        <!-- ============================================ -->
        <!-- SIDEBAR (MANDIRI)                            -->
        <!-- ============================================ -->
        <nav class="sidebar d-md-block">
            <div class="position-sticky">
                <div class="sidebar-brand d-flex align-items-center">
                    <i class="bi bi-shield-check fs-3 me-2"></i>
                    <div>
                        DISPUSIPDA
                        <small>Provinsi Jawa Barat</small>
                    </div>
                </div>

                <div class="menu-label">MENU UTAMA</div>

                <ul class="nav flex-column mt-1">
                    <li class="nav-item">
                        <a class="nav-link" href="../dashboard/index.php">
                            <i class="bi bi-grid-fill"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">
                            <i class="bi bi-box-seam-fill"></i> Inventaris
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../maintenance/index.php">
                            <i class="bi bi-wrench-adjustable"></i> Maintenance
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../peminjaman/index.php">
                            <i class="bi bi-arrow-left-right"></i> Peminjaman
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../laporan/index.php">
                            <i class="bi bi-bar-chart-line-fill"></i> Laporan
                        </a>
                    </li>
                </ul>

                <!-- User Profile -->
                <div class="sidebar-user">
                    <div class="name"><i class="bi bi-person-circle me-2"></i>Admin TI</div>
                    <div class="email">admin@dispusipda.jabarprov</div>
                    <a href="../../logout.php" class="logout mt-2 d-inline-block"><i class="bi bi-box-arrow-right me-1"></i> Keluar Sistem</a>
                </div>
            </div>
        </nav>

        <!-- ============================================ -->
        <!-- MAIN CONTENT                                 -->
        <!-- ============================================ -->
        <main class="main-content">

            <!-- HEADER -->
            <div class="inventaris-header">
                <div>
                    <h4>📦 Data Inventaris</h4>
                    <p class="subtitle">Daftar seluruh aset perangkat TI DISPUSIPDA Provinsi Jawa Barat</p>
                </div>
                <button class="btn-tambah-inventaris" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="bi bi-plus-circle"></i> Tambah Inventaris Baru
                </button>
            </div>

            <!-- NOTIFIKASI SUKSES -->
            <?php if ($success === '1'): ?>
                <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> Data berhasil disimpan!
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

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
                                    <td colspan="9" class="text-center py-4 text-muted">Belum ada data inventaris.</td>
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

<!-- ============================================ -->
<!-- MODAL TAMBAH                                 -->
<!-- ============================================ -->
<div class="modal fade modal-inventaris" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="proses/tambah.php" method="POST">
                <div class="modal-header">
                    <div>
                        <h5><i class="bi bi-plus-circle me-2 text-success"></i>Isi Data Perangkat</h5>
                        <small>Tambah inventaris aset TI baru ke sistem</small>
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

<!-- ============================================ -->
<!-- MODAL HAPUS                                  -->
<!-- ============================================ -->
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

<!-- ============================================ -->
<!-- SCRIPTS                                      -->
<!-- ============================================ -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Filter & Search
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

// Confirm Delete
function confirmDelete(id) {
    document.getElementById('hapusId').value = id;
    const modal = new bootstrap.Modal(document.getElementById('modalHapus'));
    modal.show();
}
</script>

</body>
</html>