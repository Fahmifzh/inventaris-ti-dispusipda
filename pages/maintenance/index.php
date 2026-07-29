<?php
session_start();

include '../../config/database.php';

$query = mysqli_query($conn,"
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

include '../../includes/header.php';
include '../../includes/sidebar.php';
include '../../includes/navbar.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance TI</title>

    <!-- Panggil style umum & sidebar (opsional jika ada) -->
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/sidebar.css">

    <!-- PERBAIKAN: Gunakan Maintenance.css (M Kapital) -->
    <link rel="stylesheet" href="../../assets/css/Maintenance.css">
</head>

<body>

<div class="page-header">

    <div>

        <h1>Maintenance TI</h1>

        <p>
            Kelola laporan kerusakan dan perbaikan perangkat TI
        </p>

    </div>

    <a href="tambah.php" class="btn-tambah">

        + Laporkan Kerusakan

    </a>

</div>

<div class="table-card">

<table>

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

<?= $row['kode_aset']; ?>

</td>

<td>

<?= $row['nama_hardware']; ?>

<br>

<small>

<?= $row['merk']; ?>

</small>

</td>

<td>

<?= $row['kerusakan']; ?>

</td>

<td>

<?= $row['keparahan']; ?>

</td>

<td>

<?php

if($row['status'] == 'Menunggu'){

    echo '<span class="badge-menunggu">Menunggu</span>';

}elseif($row['status'] == 'Dalam Perbaikan'){

    echo '<span class="badge-proses">Dalam Perbaikan</span>';

}else{

    echo '<span class="badge-selesai">Selesai</span>';

}

?>

</td>

<td>

<a
href="detail.php?id=<?= $row['id']; ?>"
class="btn-detail"
>
Detail
</a>

<a
href="edit.php?id=<?= $row['id']; ?>"
class="btn-edit"
>
Edit
</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</body>

</html>