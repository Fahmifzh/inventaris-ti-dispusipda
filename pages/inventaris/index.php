<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../../config/database.php';

// Ambil data inventaris
$query = mysqli_query($conn, "SELECT * FROM inventaris ORDER BY id ASC");
$assets = mysqli_fetch_all($query, MYSQLI_ASSOC);

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

    <!-- Custom CSS (Diberi path relatif ../../) -->
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
            padding: 24px 32px;
            min-height: 100vh;
            background: #f8fafc;
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

        /* RESPONSIVE SIDEBAR */
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

        <!-- SIDEBAR -->
        <nav class="sidebar d-md-block">
            <div class="position-sticky">
                <div class="sidebar-brand d-flex align-items-center">
                    <i class="bi bi-shield-check fs-3 me-2"></i>
                    <div>
                        DISPUSIPDA
                        <small>Provinsi Jawa Barat</small>
                    </div>
                </div>
                
                <div class="px-3 pt-3 text-uppercase text-muted fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">MENU UTAMA</div>
                
                <ul class="nav flex-column mt-2">
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

                <!-- User Profile di Sidebar -->
                <div class="sidebar-user">
                    <div class="name"><i class="bi bi-person-circle me-2"></i>Admin TI</div>
                    <div class="email">admin@dispusipda.jabarprov</div>
                    <a href="../../logout.php" class="logout mt-2 d-inline-block"><i class="bi bi-box-arrow-right me-1"></i> Keluar Sistem</a>
                </div>
            </div>
        </nav>

        <!-- MAIN CONTENT -->
        <main class="main-content">

            <!-- HEADER HALAMAN -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold m-0 text-dark">Data Inventaris</h3>
                    <p class="text-secondary small m-0">Daftar seluruh aset perangkat TI DISPUSIPDA Provinsi Jawa Barat</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-emerald text-white px-3 py-2 fw-semibold d-flex align-items-center gap-2" style="background-color: #00a86b; border-radius: 8px;" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="bi bi-plus-lg"></i> Tambah Inventaris Baru
                    </button>
                    <div class="bg-white p-2 rounded-circle border shadow-sm"><i class="bi bi-bell text-secondary"></i></div>
                    <div class="d-flex align-items-center gap-2 bg-white px-3 py-1 rounded-pill border shadow-sm">
                        <i class="bi bi-person-circle fs-5 text-primary"></i>
                        <span class="small fw-semibold">Admin TI</span>
                    </div>
                </div>
            </div>

            <!-- NOTIFIKASI SUKSES -->
            <?php if ($success == '1'): ?>
                <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> Data berhasil disimpan!
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- FILTER BAR -->
            <div class="row g-3 mb-4">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" id="searchInput" class="form-control border-start-0 bg-white" placeholder="Cari kode aset atau nama perangkat…" />
                    </div>
                </div>
                <div class="col-md-3">
                    <select id="filterKategori" class="form-select bg-white">
                        <option value="">Semua Kategori</option>
                        <?php foreach (['Laptop', 'Desktop', 'Printer', 'Networking', 'Server', 'UPS', 'Monitor', 'Lainnya'] as $kat): ?>
                            <option value="<?= $kat ?>"><?= $kat ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <select id="filterStatus" class="form-select bg-white">
                        <option value="">Semua Status</option>
                        <option value="Tersedia">Tersedia</option>
                        <option value="Dipinjam">Dipinjam</option>
                        <option value="Maintenance">Maintenance</option>
                    </select>
                </div>
            </div>

            <!-- TABLE CARD -->
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="inventarisTable">
                        <thead class="bg-light text-muted small text-uppercase fw-bold">
                            <tr>
                                <th class="ps-4">No</th>
                                <th>Kode Aset</th>
                                <th>Nama Hardware</th>
                                <th>Kategori</th>
                                <th>Spesifikasi</th>
                                <th>Lokasi</th>
                                <th>Tahun</th>
                                <th>Status</th>
                                <th class="text-center pe-4">Aksi</th>
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
                                    <td class="ps-4 text-secondary"><?= $no++ ?></td>
                                    <td><span class="fw-bold text-primary"><?= htmlspecialchars($asset['kode_aset']) ?></span></td>
                                    <td class="fw-semibold text-dark"><?= htmlspecialchars($asset['nama_hardware']) ?></td>
                                    <td><span class="badge bg-light text-dark border"><?= htmlspecialchars($asset['kategori']) ?></span></td>
                                    <td class="text-secondary small" style="max-width: 200px;"><?= htmlspecialchars($asset['spesifikasi']) ?></td>
                                    <td class="text-secondary small"><?= htmlspecialchars($asset['lokasi']) ?></td>
                                    <td class="text-secondary small"><?= $asset['tahun'] ?></td>
                                    <td>
                                        <?php
                                        $statusClass = 'bg-success-subtle text-success';
                                        if ($asset['status'] == 'Dipinjam') $statusClass = 'bg-primary-subtle text-primary';
                                        if ($asset['status'] == 'Maintenance') $statusClass = 'bg-warning-subtle text-warning';
                                        ?>
                                        <span class="badge rounded-pill <?= $statusClass ?> px-3 py-2 fw-medium">
                                            • <?= htmlspecialchars($asset['status']) ?>
                                        </span>
                                    </td>
                                    <td class="text-center pe-4">
                                        <button class="btn btn-sm btn-light border text-secondary me-1" title="Detail"><i class="bi bi-eye"></i></button>
                                        <button class="btn btn-sm btn-light border text-danger" title="Hapus" onclick="confirmDelete(<?= $asset['id'] ?>)"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- TABLE FOOTER -->
                <div class="card-footer bg-white border-0 py-3 d-flex justify-content-between align-middle">
                    <span class="text-muted small">Menampilkan <strong><?= count($assets) ?></strong> data aset</span>
                    <nav>
                        <ul class="pagination pagination-sm m-0">
                            <li class="page-item disabled"><a class="page-link" href="#">← Prev</a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next →</a></li>
                        </ul>
                    </nav>
                </div>
            </div>

        </main>
    </div>
</div>

<!-- MODAL TAMBAH -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <form action="proses/tambah.php" method="POST">
                <div class="modal-header border-0 pb-0">
                    <div>
                        <h5 class="fw-bold"><i class="bi bi-plus-circle me-2 text-success"></i>Isi Data Perangkat</h5>
                        <small class="text-muted">Tambah inventaris aset TI baru ke sistem</small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold">Kode Aset</label>
                            <input type="text" name="kode_aset" class="form-control" placeholder="AST-011" required />
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold">Kategori</label>
                            <select name="kategori" class="form-select" required>
                                <?php foreach (['Laptop', 'Desktop', 'Printer', 'Networking', 'Server', 'UPS', 'Monitor', 'Lainnya'] as $kat): ?>
                                    <option value="<?= $kat ?>"><?= $kat ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Nama Hardware</label>
                            <input type="text" name="nama_hardware" class="form-control" placeholder="Contoh: Laptop Dell Latitude 5530" required />
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Spesifikasi</label>
                            <textarea name="spesifikasi" class="form-control" rows="2" placeholder="Processor, RAM, Storage, dll."></textarea>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold">Lokasi</label>
                            <input type="text" name="lokasi" class="form-control" placeholder="Lt. 2 – Bidang TI" />
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold">Tahun</label>
                            <input type="number" name="tahun" class="form-control" value="2025" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn text-white px-4" style="background-color: #00a86b;">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL HAPUS -->
<div class="modal fade" id="modalHapus" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content text-center border-0 shadow rounded-4">
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

<!-- SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Filter & Search
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const filterKategori = document.getElementById('filterKategori');
    const filterStatus = document.getElementById('filterStatus');
    const rows = document.querySelectorAll('#inventarisTable tbody tr');

    function filterTable() {
        const search = searchInput.value.toLowerCase();
        const kategori = filterKategori.value;
        const status = filterStatus.value;

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

    searchInput?.addEventListener('keyup', filterTable);
    filterKategori?.addEventListener('change', filterTable);
    filterStatus?.addEventListener('change', filterTable);
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