<?php

session_start();

include '../../config/database.php';

$id = $_GET['id'];

$query = mysqli_query($conn,"
SELECT
m.*,
i.kode_aset,
i.nama_hardware,
i.merk
FROM maintenance m
LEFT JOIN inventaris i
ON m.inventaris_id = i.id
WHERE m.id='$id'
");

$data = mysqli_fetch_assoc($query);

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Detail Maintenance</title>

<link rel="stylesheet" href="../../assets/css/maintenance.css">

</head>
<body>

<div class="form-card">

<h2>Detail Maintenance</h2>

<p><b>Kode Aset :</b> <?= $data['kode_aset']; ?></p>
<p><b>Perangkat :</b> <?= $data['nama_hardware']; ?></p>
<p><b>Merk :</b> <?= $data['merk']; ?></p>
<p><b>Kerusakan :</b> <?= $data['kerusakan']; ?></p>
<p><b>Keparahan :</b> <?= $data['keparahan']; ?></p>
<p><b>Status :</b> <?= $data['status']; ?></p>

<br>

<a href="index.php" class="btn-batal">
Kembali
</a>

</div>

</body>
</html>