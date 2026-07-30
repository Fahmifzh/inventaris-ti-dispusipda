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

    <!-- Font Awesome 6 (untuk sidebar) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <!-- Custom CSS -->
    <link href="../../assets/css/dashboard.css" rel="stylesheet" />
    <link href="../../assets/css/inventaris.css" rel="stylesheet" />

    <style>
        /* ==========================
           STRUKTUR UTAMA
        ========================== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f5f7fb;
            display: flex;
            min-height: 100vh;
        }

        /* ==========================
           SIDEBAR (dari file terpisah)
        ========================== */
        .sidebar {
            width: 260px;
            background: #0c2461;
            padding: 20px 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            flex-shrink: 0;
        }

        .sidebar .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 24px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar .logo img {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            object-fit: cover;
        }

        .sidebar .logo h3 {
            color: #fff;
            font-size: 18px;
            font-weight: 700;
            margin: 0;
        }

        .sidebar .logo small {
            display: block;
            font-size: 11px;
            font-weight: 400;
            color: #94a3b8;
        }

        .sidebar .menu-title {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.8px;
            color: #6b7a8f;
            text-transform: uppercase;
            padding: 20px 24px 8px;
        }

        .sidebar .menu {
            list-style: none;
            padding: 0 12px;
            margin: 0;
        }

        .sidebar .menu li {
            margin-bottom: 4px;
        }

        .sidebar .menu li a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            border-radius: 10px;
            color: #adb5bd;
            text-decoration: none;
            font-size: 14px;
            transition: 0.3s;
        }

        .sidebar .menu li a:hover {
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
        }

        .sidebar .menu li a.active {
            background: #fff;
            color: #0c2461;
            font-weight: 600;
        }

        .sidebar .menu li a i {
            font-size: 18px;
            width: 24px;
            text-align: center;
        }

        .sidebar-footer {
            margin-top: auto;
            padding: 16px 24px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar-footer .user {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 10px;
        }

        .sidebar-footer .user .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 18px;
        }

        .sidebar-footer .user h4 {
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            margin: 0;
        }

        .sidebar-footer .user span {
            color: #94a3b8;
            font-size: 12px;
        }

        .sidebar-footer .logout {
            color: #f87171;
            text-decoration: none;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.3s;
        }

        .sidebar-footer .logout:hover {
            color: #fca5a5;
        }

        /* ==========================
           MAIN CONTENT
        ========================== */
        .main-content {
            flex: 1;
            padding: 30px 40px;
            background: #f5f7fb;
            min-height: 100vh;
        }

        .main-content .container-inventaris {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* ==========================
           TOPBAR
        ========================== */
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .topbar h2 {
            color: #1e3a8a;
            font-size: 28px;
            font-weight: 700;
            margin: 0;
        }

        .topbar p {
            margin: 4px 0 0 0;
            color: #777;
            font-size: 14px;
        }

        .top-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .notification {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 18px rgba(0, 0, 0, 0.08);
            cursor: pointer;
        }

        .notification i {
            color: #555;
            font-size: 20px;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .profile .profile-photo {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #1e40af;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 600;
        }

        .profile h4 {
            color: #333;
            font-size: 15px;
            margin: 0;
        }

        .profile span {
            color: #888;
            font-size: 13px;
        }

        /* ==========================
           FILTER BAR
        ========================== */
        .filter-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 24px;
        }

        .filter-bar .search-wrapper {
            flex: 1 1 280px;
            max-width: 380px;
            position: relative;
        }

        .filter-bar .search-wrapper input {
            width: 100%;
            padding: 12px 16px 12px 48px;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            font-size: 14px;
            background: #fff;
            transition: 0.3s;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .filter-bar .search-wrapper input:focus {
            outline: none;
            border-color: #1e3a8a;
            box-shadow: 0 0 0 4px rgba(30, 58, 138, 0.1);
        }

        .filter-bar .search-wrapper .search-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 18px;
        }

        .filter-bar select {
            padding: 12px 18px;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            font-size: 14px;
            background: #fff;
            color: #1e293b;
            min-width: 140px;
            max-width: 200px;
            transition: 0.3s;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2364748b' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            padding-right: 44px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .filter-bar select:focus {
            outline: none;
            border-color: #1e3a8a;
            box-shadow: 0 0 0 4px rgba(30, 58, 138, 0.1);
        }

        /* ==========================
           BUTTON TAMBAH
        ========================== */
        .btn-tambah-wrapper {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        .btn-tambah-inventaris {
            background: #059669;
            color: #fff;
            border: none;
            padding: 10px 22px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: 0.3s;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(5, 150, 105, 0.25);
        }

        .btn-tambah-inventaris:hover {
            background: #047857;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(5, 150, 105, 0.35);
        }

        /* ==========================
           TABLE CARD
        ========================== */
        .table-card {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.07);
            overflow: hidden;
        }

        .table-card .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 24px;
            border-bottom: 1px solid #eee;
        }

        .table-card .table-header h5 {
            font-weight: 600;
            color: #1e3a8a;
            font-size: 16px;
            margin: 0;
        }

        .table-card .table-header .badge-count {
            background: #e8f1ff;
            color: #2563eb;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        /* ==========================
           TABLE
        ========================== */
        .table-inventaris {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .table-inventaris thead {
            background: #f8fafc;
        }

        .table-inventaris thead th {
            padding: 14px 20px;
            text-align: left;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #94a3b8;
            border-bottom: 1px solid #eef2f6;
        }

        .table-inventaris tbody tr {
            border-bottom: 1px solid #f1f5f9;
            transition: 0.2s;
        }

        .table-inventaris tbody tr:hover {
            background: #f8fafc;
        }

        .table-inventaris tbody td {
            padding: 14px 20px;
            vertical-align: middle;
            color: #1e293b;
        }

        .kode-aset {
            font-family: 'Courier New', monospace;
            font-weight: 700;
            font-size: 13px;
            color: #1e3a8a;
        }

        .nama-hardware {
            font-weight: 600;
            color: #0f172a;
        }

        .badge-kategori {
            background: #f1f5f9;
            color: #475569;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
        }

        .spesifikasi {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: #64748b;
            font-size: 13px;
        }

        /* ==========================
           STATUS BADGE
        ========================== */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 5px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-badge .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
        }

        .status-tersedia {
            background: #d1fae5;
            color: #065f46;
        }
        .status-tersedia .dot {
            background: #059669;
        }

        .status-dipinjam {
            background: #fef3c7;
            color: #92400e;
        }
        .status-dipinjam .dot {
            background: #d97706;
        }

        .status-maintenance {
            background: #fee2e2;
            color: #991b1b;
        }
        .status-maintenance .dot {
            background: #dc2626;
        }

        .status-default {
            background: #f1f5f9;
            color: #475569;
        }
        .status-default .dot {
            background: #94a3b8;
        }

        /* ==========================
           ACTION BUTTONS
        ========================== */
        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border: none;
            border-radius: 8px;
            background: transparent;
            color: #94a3b8;
            transition: 0.2s;
            cursor: pointer;
        }

        .btn-action:hover {
            background: #f1f5f9;
            color: #1e293b;
        }

        .btn-action.danger:hover {
            background: #fee2e2;
            color: #dc2626;
        }

        .btn-action.primary:hover {
            background: #dbeafe;
            color: #1e3a8a;
        }

        /* ==========================
           TABLE FOOTER & PAGINATION
        ========================== */
        .table-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 24px;
            background: #fafcfc;
            border-top: 1px solid #eef2f6;
            flex-wrap: wrap;
            gap: 10px;
        }

        .table-footer .info {
            font-size: 13px;
            color: #94a3b8;
        }

        .table-footer .info strong {
            color: #1e293b;
        }

        .pagination-custom {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .pagination-custom .page-btn {
            padding: 6px 14px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            font-size: 13px;
            color: #64748b;
            background: #fff;
            cursor: pointer;
            transition: 0.2s;
        }

        .pagination-custom .page-btn:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
        }

        .pagination-custom .page-btn.active {
            background: #1e3a8a;
            border-color: #1e3a8a;
            color: #fff;
            font-weight: 600;
        }

        .pagination-custom .page-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* ==========================
           MODAL
        ========================== */
        .modal-inventaris .modal-content {
            border-radius: 18px;
            border: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .modal-inventaris .modal-header {
            border-bottom: 1px solid #f1f5f9;
            padding: 20px 28px;
        }

        .modal-inventaris .modal-header h5 {
            font-weight: 700;
            color: #1e3a8a;
        }

        .modal-inventaris .modal-body {
            padding: 24px 28px;
        }

        .modal-inventaris .modal-footer {
            border-top: 1px solid #f1f5f9;
            padding: 16px 28px 24px;
        }

        .modal-inventaris .form-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #94a3b8;
            margin-bottom: 4px;
        }

        .modal-inventaris .form-control,
        .modal-inventaris .form-select {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 10px 16px;
            font-size: 14px;
            transition: 0.3s;
        }

        .modal-inventaris .form-control:focus,
        .modal-inventaris .form-select:focus {
            border-color: #1e3a8a;
            box-shadow: 0 0 0 4px rgba(30, 58, 138, 0.08);
        }

        /* ==========================
           RESPONSIVE
        ========================== */
        @media (max-width: 992px) {
            .sidebar {
                width: 100%;
                min-height: auto;
                height: auto;
                position: relative;
            }
            .sidebar .menu {
                display: flex;
                flex-wrap: wrap;
                gap: 4px;
                padding: 0 12px;
            }
            .sidebar .menu li {
                margin-bottom: 0;
            }
            .sidebar .menu li a {
                white-space: nowrap;
                font-size: 12px;
                padding: 8px 12px;
            }
            .sidebar .logo {
                padding: 12px 20px;
            }
            .sidebar-footer {
                display: none;
            }
            .main-content {
                padding: 20px;
            }
            .filter-bar .search-wrapper {
                flex: 1 1 100%;
                max-width: 100%;
            }
            .filter-bar select {
                width: 100%;
                max-width: 100%;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 16px;
            }
            .topbar {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }
            .top-right {
                width: 100%;
                justify-content: flex-start;
            }
            .table-inventaris thead th,
            .table-inventaris tbody td {
                padding: 10px 12px;
                font-size: 11px;
            }
            .spesifikasi {
                max-width: 100px;
            }
            .table-footer {
                flex-direction: column;
                align-items: flex-start;
            }
            .table-footer .pagination-custom {
                align-self: flex-end;
            }
            .profile h4,
            .profile span {
                display: none;
            }
        }
    </style>
</head>
<body>

    <!-- ========================== -->
    <!-- SIDEBAR - DIPANGGIL DARI FILE TERPISAH -->
    <!-- ========================== -->
    <?php include __DIR__ . '/../../includes/sidebar.php'; ?>

    <!-- ========================== -->
    <!-- MAIN CONTENT               -->
    <!-- ========================== -->
    <main class="main-content">

        <div class="container-inventaris">

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
            <div class="btn-tambah-wrapper">
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

        </div>
    </main>

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