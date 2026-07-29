<?php

session_start();

include '../../config/database.php';

if(isset($_POST['simpan'])){

    $inventaris_id = $_POST['inventaris_id'];

    $kerusakan = $_POST['kerusakan'];

    $keparahan = $_POST['keparahan'];

    mysqli_query($conn,"
    INSERT INTO maintenance
    (
        inventaris_id,
        tanggal_lapor,
        kerusakan,
        keparahan
    )
    VALUES
    (
        '$inventaris_id',
        CURDATE(),
        '$kerusakan',
        '$keparahan'
    )
    ");

    header("Location:index.php");
    exit;
}

$inventaris = mysqli_query($conn,"
SELECT *
FROM inventaris
ORDER BY nama_hardware ASC
");

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Tambah Maintenance</title>

<link rel="stylesheet"
href="../../assets/css/maintenance.css">

</head>

<body>

<div class="form-card">

<h2>Tambah Laporan Kerusakan</h2>

<form method="POST">

<label>Perangkat</label>

<select name="inventaris_id" required>

<option value="">
Pilih Perangkat
</option>

<?php while($i=mysqli_fetch_assoc($inventaris)){ ?>

<option value="<?= $i['id']; ?>">

<?= $i['kode_aset']; ?>

-

<?= $i['nama_hardware']; ?>

</option>

<?php } ?>

</select>

<label>Deskripsi Kerusakan</label>

<textarea
name="kerusakan"
rows="5"
required>
</textarea>

<label>Keparahan</label>

<select name="keparahan">

<option value="Rendah">
Rendah
</option>

<option value="Sedang">
Sedang
</option>

<option value="Tinggi">
Tinggi
</option>

</select>

<div class="btn-group">

<a
href="index.php"
class="btn-batal">

Batal

</a>

<button
type="submit"
name="simpan"
class="btn-simpan">

Simpan

</button>

</div>

</form>

</div>

</body>
</html>