<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

include '../../config/database.php';

$query = mysqli_query($conn, "
    SELECT
        m.*,
        i.kode_aset,
        i.nama_hardware,
        i.merk
    FROM maintenance m
    LEFT JOIN inventaris i
        ON m.inventaris_id = i.id
    ORDER BY m.id DESC
");

$page_title = "Maintenance TI";
$page_subtitle = "Kelola laporan kerusakan dan perbaikan perangkat TI DISPUSIPDA";
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance TI</title>

    <!-- CSS UTAMA -->
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/sidebar.css">
    <link rel="stylesheet" href="../../assets/css/topbar.css">
    <link rel="stylesheet" href="../../assets/css/maintenance.css?v=<?php echo time(); ?>">

    <!-- GOOGLE FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- STYLE PAKSA AGAR TOMBOL SUSUN KE BAWAH -->
    <style>
        .action-buttons {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 6px !important;
            width: 100% !important;
        }

        .action-buttons a,
        .btn-detail,
        .btn-edit,
        .btn-hapus {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 6px !important;
            width: 100px !important;
            height: 34px !important;
            padding: 0 10px !important;
            border-radius: 8px !important;
            color: #ffffff !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            text-decoration: none !important;
            white-space: nowrap !important;
            box-sizing: border-box !important;
        }

        .btn-detail { background-color: #3b82f6 !important; }
        .btn-edit { background-color: #f59e0b !important; }
        .btn-hapus { background-color: #ef4444 !important; }

        .th-aksi, .td-aksi {
            width: 130px !important;
            min-width: 130px !important;
            text-align: center !important;
        }
    </style>
</head>

<body>

    <!-- =========================
         SIDEBAR
    ========================== -->

    <?php include '../../includes/sidebar.php'; ?>


    <!-- =========================
         MAIN CONTENT
    ========================== -->

    <div class="main-content">


        <!-- =========================
             TOPBAR
        ========================== -->

        <?php include '../../includes/topbar.php'; ?>


        <!-- =========================
             PAGE HEADER
        ========================== -->

        <div class="page-header">

            <div></div>

            <a href="tambah.php" class="btn-tambah">

                <i class="fa-solid fa-plus"></i>

                <span>Laporkan Kerusakan</span>

            </a>

        </div>


        <!-- =========================
             TABLE CARD
        ========================== -->

        <div class="table-card">

            <div class="table-responsive">

                <table>

                    <!-- =========================
                         TABLE HEADER
                    ========================== -->

                    <thead>

                        <tr>

                            <th>Kode Aset</th>

                            <th>Perangkat</th>

                            <th>Kerusakan</th>

                            <th>Keparahan</th>

                            <th>Status</th>

                            <th style="width: 140px; text-align: center;">Aksi</th>

                        </tr>

                    </thead>


                    <!-- =========================
                         TABLE BODY
                    ========================== -->

                    <tbody>

                        <?php if (mysqli_num_rows($query) > 0): ?>

                            <?php while ($row = mysqli_fetch_assoc($query)): ?>

                                <tr>


                                    <!-- =====================
                                         KODE ASET
                                    ====================== -->

                                    <td data-label="Kode Aset">

                                        <strong>
                                            <?= htmlspecialchars($row['kode_aset']); ?>
                                        </strong>

                                    </td>


                                    <!-- =====================
                                         PERANGKAT
                                    ====================== -->

                                    <td data-label="Perangkat">

                                        <?= htmlspecialchars($row['nama_hardware']); ?>

                                        <?php if (!empty($row['merk'])): ?>

                                            <small style="display: block; color: #64748b;">
                                                <?= htmlspecialchars($row['merk']); ?>
                                            </small>

                                        <?php endif; ?>

                                    </td>


                                    <!-- =====================
                                         KERUSAKAN
                                    ====================== -->

                                    <td data-label="Kerusakan">

                                        <?= htmlspecialchars($row['kerusakan']); ?>

                                    </td>


                                    <!-- =====================
                                         KEPARAHAN
                                    ====================== -->

                                    <td data-label="Keparahan">

                                        <?= htmlspecialchars($row['keparahan']); ?>

                                    </td>


                                    <!-- =====================
                                         STATUS
                                    ====================== -->

                                    <td data-label="Status">

                                        <?php if ($row['status'] == "Menunggu"): ?>

                                            <span class="badge-menunggu">
                                                Menunggu
                                            </span>

                                        <?php elseif ($row['status'] == "Dalam Perbaikan"): ?>

                                            <span class="badge-proses">
                                                Dalam Perbaikan
                                            </span>

                                        <?php else: ?>

                                            <span class="badge-selesai">
                                                Selesai
                                            </span>

                                        <?php endif; ?>

                                    </td>


                                    <!-- =====================
                                         AKSI
                                    ====================== -->

                                    <td data-label="Aksi" style="text-align: center;">

                                        <div class="action-buttons">


                                            <!-- DETAIL -->

                                            <a
                                                href="detail.php?id=<?= (int)$row['id']; ?>"
                                                class="btn-detail"
                                                title="Lihat Detail"
                                            >

                                                <i class="fa-solid fa-eye"></i>

                                                <span>Detail</span>

                                            </a>


                                            <!-- EDIT -->

                                            <a
                                                href="edit.php?id=<?= (int)$row['id']; ?>"
                                                class="btn-edit"
                                                title="Edit Data"
                                            >

                                                <i class="fa-solid fa-pen"></i>

                                                <span>Edit</span>

                                            </a>


                                            <!-- HAPUS -->

                                            <a
                                                href="hapus.php?id=<?= (int)$row['id']; ?>"
                                                class="btn-hapus"
                                                title="Hapus Data"
                                                onclick="return confirm('Yakin ingin menghapus data maintenance ini?')"
                                            >

                                                <i class="fa-solid fa-trash"></i>

                                                <span>Hapus</span>

                                            </a>


                                        </div>

                                    </td>


                                </tr>

                            <?php endwhile; ?>


                        <?php else: ?>


                            <!-- =====================
                                 DATA KOSONG
                            ====================== -->

                            <tr>

                                <td
                                    colspan="6"
                                    style="
                                        text-align:center;
                                        padding:40px;
                                    "
                                >

                                    <i
                                        class="fa-solid fa-inbox"
                                        style="
                                            font-size:32px;
                                            color:#94a3b8;
                                            margin-bottom:10px;
                                        "
                                    ></i>

                                    <div>
                                        Belum ada data maintenance.
                                    </div>

                                </td>

                            </tr>


                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</body>

</html>