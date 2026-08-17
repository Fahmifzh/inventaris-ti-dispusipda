<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

include '../../config/database.php';

// Validasi parameter ID
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int)$_GET['id'];

// Ambil data inventaris untuk dropdown
$inventaris = mysqli_query($conn, "
    SELECT id, kode_aset, nama_hardware
    FROM inventaris
    ORDER BY nama_hardware ASC
");

// Ambil data maintenance berdasarkan ID
$query = mysqli_query($conn, "
    SELECT *
    FROM maintenance
    WHERE id = '$id'
");

$data = mysqli_fetch_assoc($query);

if (!$data) {
    header("Location: index.php");
    exit;
}

// Proses Update Data
if (isset($_POST['update'])) {

    $inventaris_id   = $_POST['inventaris_id'];
    $tanggal_lapor   = $_POST['tanggal_lapor'];
    $kerusakan       = $_POST['kerusakan'];
    $keparahan       = $_POST['keparahan'];
    $teknisi         = $_POST['teknisi'];
    $tindakan        = $_POST['tindakan'];
    $status          = $_POST['status'];
    $tanggal_selesai = !empty($_POST['tanggal_selesai']) ? $_POST['tanggal_selesai'] : NULL;

    if ($tanggal_selesai) {
        mysqli_query($conn, "
            UPDATE maintenance SET
                inventaris_id = '$inventaris_id',
                tanggal_lapor = '$tanggal_lapor',
                kerusakan     = '$kerusakan',
                keparahan     = '$keparahan',
                teknisi       = '$teknisi',
                tindakan      = '$tindakan',
                status        = '$status',
                tanggal_selesai = '$tanggal_selesai'
            WHERE id = '$id'
        ");
    } else {
        mysqli_query($conn, "
            UPDATE maintenance SET
                inventaris_id = '$inventaris_id',
                tanggal_lapor = '$tanggal_lapor',
                kerusakan     = '$kerusakan',
                keparahan     = '$keparahan',
                teknisi       = '$teknisi',
                tindakan      = '$tindakan',
                status        = '$status',
                tanggal_selesai = NULL
            WHERE id = '$id'
        ");
    }

    // Update Status Inventaris
    if ($status == "Selesai") {
        mysqli_query($conn, "
            UPDATE inventaris
            SET status = 'Tersedia'
            WHERE id = '$inventaris_id'
        ");
    } else {
        mysqli_query($conn, "
            UPDATE inventaris
            SET status = 'Maintenance'
            WHERE id = '$inventaris_id'
        ");
    }

    header("Location: index.php");
    exit;
}

// Judul Halaman untuk Topbar Include Resmi
$page_title = "Edit Maintenance";
$page_subtitle = "Perbarui data maintenance perangkat TI DISPUSIPDA";
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Maintenance TI</title>

    <!-- CSS Links -->
    <link rel="stylesheet" href="../../assets/css/style.css?v=2.0">
    <link rel="stylesheet" href="../../assets/css/sidebar.css?v=2.0">
    <link rel="stylesheet" href="../../assets/css/topbar.css?v=2.0">
    <link rel="stylesheet" href="../../assets/css/maintenance.css?v=2.0">

    <!-- GOOGLE FONT & FONT AWESOME -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>
</head>

<body>

    <!-- INCLUDE SIDEBAR -->
    <?php include '../../includes/sidebar.php'; ?>

    <div class="main-content">

        <!-- INCLUDE TOPBAR RESMI -->
        <?php include '../../includes/topbar.php'; ?>

        <!-- FORM CARD -->
        <div class="form-card" style="margin-top: 25px;">
            <form method="POST">

                <div class="form-group">
                    <label>Perangkat</label>
                    <select name="inventaris_id" required>
                        <?php while ($i = mysqli_fetch_assoc($inventaris)) { ?>
                            <option
                                value="<?= $i['id']; ?>"
                                <?= ($i['id'] == $data['inventaris_id']) ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($i['kode_aset']); ?> - <?= htmlspecialchars($i['nama_hardware']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Tanggal Lapor</label>
                    <input
                        type="date"
                        name="tanggal_lapor"
                        value="<?= htmlspecialchars($data['tanggal_lapor']); ?>"
                        required>
                </div>

                <div class="form-group">
                    <label>Kerusakan</label>
                    <textarea
                        name="kerusakan"
                        required><?= htmlspecialchars($data['kerusakan']); ?></textarea>
                </div>

                <div class="form-group">
                    <label>Keparahan</label>
                    <select name="keparahan">
                        <option value="Rendah" <?= ($data['keparahan'] == "Rendah") ? "selected" : ""; ?>>Rendah</option>
                        <option value="Sedang" <?= ($data['keparahan'] == "Sedang") ? "selected" : ""; ?>>Sedang</option>
                        <option value="Tinggi" <?= ($data['keparahan'] == "Tinggi") ? "selected" : ""; ?>>Tinggi</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Teknisi</label>
                    <input
                        type="text"
                        name="teknisi"
                        value="<?= htmlspecialchars($data['teknisi'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label>Tindakan</label>
                    <textarea
                        name="tindakan"><?= htmlspecialchars($data['tindakan'] ?? ''); ?></textarea>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status">
                        <option value="Menunggu" <?= ($data['status'] == "Menunggu") ? "selected" : ""; ?>>Menunggu</option>
                        <option value="Dalam Perbaikan" <?= ($data['status'] == "Dalam Perbaikan") ? "selected" : ""; ?>>Dalam Perbaikan</option>
                        <option value="Selesai" <?= ($data['status'] == "Selesai") ? "selected" : ""; ?>>Selesai</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Tanggal Selesai</label>
                    <input
                        type="date"
                        name="tanggal_selesai"
                        value="<?= htmlspecialchars($data['tanggal_selesai'] ?? ''); ?>">
                </div>

                <div class="btn-group">
                    <button
                        type="submit"
                        name="update"
                        class="btn-simpan">
                        <i class="fa-solid fa-floppy-disk"></i> Update
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