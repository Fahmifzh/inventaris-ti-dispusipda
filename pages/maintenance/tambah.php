<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

include '../../config/database.php';

// Ambil data inventaris untuk dropdown
$inventaris = mysqli_query($conn, "
    SELECT id, kode_aset, nama_hardware
    FROM inventaris
    ORDER BY nama_hardware ASC
");

if(isset($_POST['simpan'])){

    $inventaris_id   = $_POST['inventaris_id'];
    $tanggal_lapor   = $_POST['tanggal_lapor'];
    $kerusakan       = $_POST['kerusakan'];
    $keparahan       = $_POST['keparahan'];
    $teknisi         = $_POST['teknisi'];
    $tindakan        = $_POST['tindakan'];

    mysqli_query($conn,"
        INSERT INTO maintenance(
            inventaris_id,
            tanggal_lapor,
            kerusakan,
            keparahan,
            teknisi,
            tindakan,
            status
        )
        VALUES(
            '$inventaris_id',
            '$tanggal_lapor',
            '$kerusakan',
            '$keparahan',
            '$teknisi',
            '$tindakan',
            'Menunggu'
        )
    ");

    mysqli_query($conn,"
        UPDATE inventaris
        SET status='Maintenance'
        WHERE id='$inventaris_id'
    ");

    header("Location:index.php");
    exit;
}

// Judul Halaman untuk Topbar Include
$page_title = "Tambah Maintenance";
$page_subtitle = "Laporkan kerusakan perangkat TI DISPUSIPDA";
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Maintenance TI</title>

    <!-- CSS Links -->
    <link rel="stylesheet" href="../../assets/css/style.css?v=2.0">
    <link rel="stylesheet" href="../../assets/css/sidebar.css?v=2.0">
    <link rel="stylesheet" href="../../assets/css/topbar.css?v=2.0">
    <link rel="stylesheet" href="../../assets/css/maintenance.css?v=2.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>
</head>

<body>

    <!-- INCLUDE SIDEBAR -->
    <?php include '../../includes/sidebar.php'; ?>

    <div class="main-content">

        <!-- INCLUDE TOPBAR RESMI (Pakai Topbar Bawaan Sistem) -->
        <?php include '../../includes/topbar.php'; ?>

        <!-- FORM CARD -->
        <div class="form-card">
            <form method="POST">

                <div class="form-group">
                    <label>Perangkat</label>
                    <select name="inventaris_id" required>
                        <option value="">-- Pilih Perangkat --</option>
                        <?php while($i=mysqli_fetch_assoc($inventaris)){ ?>
                            <option value="<?= $i['id']; ?>">
                                <?= $i['kode_aset']; ?> - <?= $i['nama_hardware']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Tanggal Lapor</label>
                    <input type="date" name="tanggal_lapor" value="<?= date('Y-m-d'); ?>" required>
                </div>

                <div class="form-group">
                    <label>Kerusakan</label>
                    <textarea name="kerusakan" required placeholder="Masukkan deskripsi kerusakan..."></textarea>
                </div>

                <div class="form-group">
                    <label>Keparahan</label>
                    <select name="keparahan">
                        <option value="Rendah">Rendah</option>
                        <option value="Sedang" selected>Sedang</option>
                        <option value="Tinggi">Tinggi</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Teknisi</label>
                    <input type="text" name="teknisi" placeholder="Nama Teknisi (opsional)">
                </div>

                <div class="form-group">
                    <label>Tindakan</label>
                    <textarea name="tindakan" placeholder="Tindakan awal (opsional)..."></textarea>
                </div>

                <div class="btn-group">
                    <button type="submit" name="simpan" class="btn-simpan">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Laporan
                    </button>

                    <a href="index.php" class="btn-batal">
                        <i class="fa-solid fa-arrow-left"></i> Kembali
                    </a>
                </div>

            </form>
        </div>

    </div>

</body>
</html>