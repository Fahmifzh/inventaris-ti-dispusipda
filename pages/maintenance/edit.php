<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

include '../../config/database.php';

$id = $_GET['id'];

$inventaris = mysqli_query($conn,"
SELECT id,kode_aset,nama_hardware
FROM inventaris
ORDER BY nama_hardware ASC
");

$query = mysqli_query($conn,"
SELECT *
FROM maintenance
WHERE id='$id'
");

$data = mysqli_fetch_assoc($query);

if(isset($_POST['update'])){

    $inventaris_id   = $_POST['inventaris_id'];
    $tanggal_lapor   = $_POST['tanggal_lapor'];
    $kerusakan       = $_POST['kerusakan'];
    $keparahan       = $_POST['keparahan'];
    $teknisi         = $_POST['teknisi'];
    $tindakan        = $_POST['tindakan'];
    $status          = $_POST['status'];
    $tanggal_selesai = $_POST['tanggal_selesai'];

    mysqli_query($conn,"
    UPDATE maintenance SET
        inventaris_id='$inventaris_id',
        tanggal_lapor='$tanggal_lapor',
        kerusakan='$kerusakan',
        keparahan='$keparahan',
        teknisi='$teknisi',
        tindakan='$tindakan',
        status='$status',
        tanggal_selesai='$tanggal_selesai'
    WHERE id='$id'
    ");

    if($status=="Selesai"){

        mysqli_query($conn,"
        UPDATE inventaris
        SET status='Tersedia'
        WHERE id='$inventaris_id'
        ");

    }else{

        mysqli_query($conn,"
        UPDATE inventaris
        SET status='Maintenance'
        WHERE id='$inventaris_id'
        ");

    }

    header("Location:index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Edit Maintenance</title>

<link rel="stylesheet" href="../../assets/css/style.css">
<link rel="stylesheet" href="../../assets/css/sidebar.css">
<link rel="stylesheet" href="../../assets/css/dashboard.css">
<link rel="stylesheet" href="../../assets/css/Maintenance.css">

<link rel="preconnect" href="https://fonts.googleapis.com">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>

</head>

<body>

<?php include '../../includes/sidebar.php'; ?>

<div class="main-content">

<div class="topbar">

<div>

<h2>Edit Maintenance</h2>

<p>Perbarui data maintenance perangkat TI DISPUSIPDA</p>

</div>

<div class="top-right">

<div class="notification">
<i class="fa-regular fa-bell"></i>
</div>

<div class="profile">

<div class="profile-photo">
<i class="fa-solid fa-user"></i>
</div>

<div>
<h4><?= htmlspecialchars($_SESSION['nama']); ?></h4>
<span>Admin DISPUSIPDA</span>
</div>

</div>

</div>

</div>


<div class="form-card">

<form method="POST">

<div class="form-group">

<label>Perangkat</label>

<select name="inventaris_id" required>

<?php while($i=mysqli_fetch_assoc($inventaris)){ ?>

<option
value="<?= $i['id']; ?>"
<?= ($i['id']==$data['inventaris_id'])?'selected':''; ?>>

<?= $i['kode_aset']; ?> - <?= $i['nama_hardware']; ?>

</option>

<?php } ?>

</select>

</div>


<div class="form-group">

<label>Tanggal Lapor</label>

<input
type="date"
name="tanggal_lapor"
value="<?= $data['tanggal_lapor']; ?>"
required>

</div>


<div class="form-group">

<label>Kerusakan</label>

<textarea
name="kerusakan"
required><?= $data['kerusakan']; ?></textarea>

</div>


<div class="form-group">

<label>Keparahan</label>

<select name="keparahan">

<option value="Rendah" <?= $data['keparahan']=="Rendah"?"selected":""; ?>>Rendah</option>

<option value="Sedang" <?= $data['keparahan']=="Sedang"?"selected":""; ?>>Sedang</option>

<option value="Tinggi" <?= $data['keparahan']=="Tinggi"?"selected":""; ?>>Tinggi</option>

</select>

</div>


<div class="form-group">

<label>Teknisi</label>

<input
type="text"
name="teknisi"
value="<?= $data['teknisi']; ?>">

</div>


<div class="form-group">

<label>Tindakan</label>

<textarea
name="tindakan"><?= $data['tindakan']; ?></textarea>

</div>


<div class="form-group">

<label>Status</label>

<select name="status">

<option value="Menunggu" <?= $data['status']=="Menunggu"?"selected":""; ?>>Menunggu</option>

<option value="Dalam Perbaikan" <?= $data['status']=="Dalam Perbaikan"?"selected":""; ?>>Dalam Perbaikan</option>

<option value="Selesai" <?= $data['status']=="Selesai"?"selected":""; ?>>Selesai</option>

</select>

</div>


<div class="form-group">

<label>Tanggal Selesai</label>

<input
type="date"
name="tanggal_selesai"
value="<?= $data['tanggal_selesai']; ?>">

</div>


<div class="btn-group">

<button
type="submit"
name="update"
class="btn-simpan">

<i class="fa-solid fa-floppy-disk"></i>

Update

</button>

<a href="index.php" class="btn-batal">

<i class="fa-solid fa-arrow-left"></i>

Kembali

</a>

</div>

</form>

</div>

</div>

</body>
</html>