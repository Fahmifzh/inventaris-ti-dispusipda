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

    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/sidebar.css">
    <link rel="stylesheet" href="../../assets/css/topbar.css">
<link rel="stylesheet" href="../../assets/css/maintenance.css?v=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>

</head>

<body>

    <?php include '../../includes/sidebar.php'; ?>

    <div class="main-content">

        <?php include '../../includes/topbar.php'; ?>

        <div class="page-header">

            <div></div>

            <a href="tambah.php" class="btn-tambah">

                <i class="fa-solid fa-plus"></i>

                Laporkan Kerusakan

            </a>

        </div>

        <div class="table-card">
    <div class="table-responsive">
        <table>
</div>
                <thead>

                    <tr>

                        <th>Kode Aset</th>
                        <th>Perangkat</th>
                        <th>Kerusakan</th>
                        <th>Keparahan</th>
                        <th>Status</th>
                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    <?php while($row = mysqli_fetch_assoc($query)){ ?>

                    <tr>

                        <td>

                            <strong><?= htmlspecialchars($row['kode_aset']); ?></strong>

                        </td>

                        <td>

                            <?= htmlspecialchars($row['nama_hardware']); ?>

                            <br>

                            <small><?= htmlspecialchars($row['merk']); ?></small>

                        </td>

                        <td>

                            <?= htmlspecialchars($row['kerusakan']); ?>

                        </td>

                        <td>

                            <?= htmlspecialchars($row['keparahan']); ?>

                        </td>

                        <td>

                            <?php

                            if($row['status'] == "Menunggu"){

                                echo '<span class="badge-menunggu">Menunggu</span>';

                            }elseif($row['status'] == "Dalam Perbaikan"){

                                echo '<span class="badge-proses">Dalam Perbaikan</span>';

                            }else{

                                echo '<span class="badge-selesai">Selesai</span>';

                            }

                            ?>

                        </td>

                        <td>

                            <a href="detail.php?id=<?= $row['id']; ?>" class="btn-detail">
                                <i class="fa-solid fa-eye"></i>
                                Detail
                            </a>

                            <a href="edit.php?id=<?= $row['id']; ?>" class="btn-edit">
                                <i class="fa-solid fa-pen"></i>
                                Edit
                            </a>

                            <a
                                href="hapus.php?id=<?= $row['id']; ?>"
                                class="btn-hapus"
                                onclick="return confirm('Yakin ingin menghapus data maintenance ini?')">

                                <i class="fa-solid fa-trash"></i>

                                Hapus

                            </a>

                        </td>

                    </tr>

                    <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</body>

</html>