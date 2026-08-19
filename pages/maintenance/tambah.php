<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

include '../../config/database.php';
require_once '../../config/activity_log.php';

// Ambil data inventaris untuk dropdown
$inventaris = mysqli_query($conn, "
    SELECT id, kode_aset, nama_hardware
    FROM inventaris
    ORDER BY nama_hardware ASC
");

if(isset($_POST['simpan'])){

    $inventaris_id   = (int)$_POST['inventaris_id'];
    $tanggal_lapor   = mysqli_real_escape_string($conn, $_POST['tanggal_lapor']);
    $kerusakan       = mysqli_real_escape_string($conn, $_POST['kerusakan']);
    $keparahan       = mysqli_real_escape_string($conn, $_POST['keparahan']);
    $teknisi         = mysqli_real_escape_string($conn, $_POST['teknisi']);
    $tindakan        = mysqli_real_escape_string($conn, $_POST['tindakan']);


    // ========================================
    // Ambil informasi perangkat
    // ========================================
    $query_perangkat = mysqli_query($conn, "
        SELECT kode_aset, nama_hardware
        FROM inventaris
        WHERE id = '$inventaris_id'
    ");

    if (!$query_perangkat || mysqli_num_rows($query_perangkat) === 0) {

        header("Location: index.php?error=" . urlencode("Perangkat tidak ditemukan."));
        exit;
    }

    $data_perangkat = mysqli_fetch_assoc($query_perangkat);

    $kode_aset = $data_perangkat['kode_aset'];
    $nama_hardware = $data_perangkat['nama_hardware'];


    // ========================================
    // INSERT Maintenance
    // ========================================
    $query_maintenance = mysqli_query($conn,"
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


    // ========================================
    // Cek INSERT Maintenance
    // ========================================
    if ($query_maintenance) {

        // ========================================
        // Ubah status inventaris
        // ========================================
        $query_status = mysqli_query($conn,"
            UPDATE inventaris
            SET status='Maintenance'
            WHERE id='$inventaris_id'
        ");


        // ========================================
        // Catat Log Aktivitas
        // ========================================
        logAktivitas(
            $conn,
            "Maintenance baru",
            "Perangkat " . $nama_hardware .
            " dengan kode aset " . $kode_aset .
            " dilaporkan mengalami kerusakan dan masuk ke proses maintenance."
        );


        // ========================================
        // Kembali ke halaman maintenance
        // ========================================
        header("Location:index.php");
        exit;

    } else {

        // ========================================
        // Jika INSERT maintenance gagal
        // ========================================
        header(
            "Location: index.php?error=" .
            urlencode(mysqli_error($conn))
        );

        exit;
    }
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
                                <?= htmlspecialchars($i['kode_aset']); ?> -
                                <?= htmlspecialchars($i['nama_hardware']); ?>
                            </option>

                        <?php } ?>

                    </select>
                </div>

                <div class="form-group">
                    <label>Tanggal Lapor</label>

                    <input
                        type="date"
                        name="tanggal_lapor"
                        value="<?= date('Y-m-d'); ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label>Kerusakan</label>

                    <textarea
                        name="kerusakan"
                        required
                        placeholder="Masukkan deskripsi kerusakan..."
                    ></textarea>
                </div>

                <div class="form-group">
                    <label>Keparahan</label>

                    <select name="keparahan">

                        <option value="Rendah">
                            Rendah
                        </option>

                        <option value="Sedang" selected>
                            Sedang
                        </option>

                        <option value="Tinggi">
                            Tinggi
                        </option>

                    </select>
                </div>

                <div class="form-group">
                    <label>Teknisi</label>

                    <input
                        type="text"
                        name="teknisi"
                        placeholder="Nama Teknisi (opsional)"
                    >
                </div>

                <div class="form-group">
                    <label>Tindakan</label>

                    <textarea
                        name="tindakan"
                        placeholder="Tindakan awal (opsional)..."
                    ></textarea>
                </div>

                <div class="btn-group">

                    <button
                        type="submit"
                        name="simpan"
                        class="btn-simpan"
                    >
                        <i class="fa-solid fa-floppy-disk"></i>
                        Simpan Laporan
                    </button>

                    <a
                        href="index.php"
                        class="btn-batal"
                    >
                        <i class="fa-solid fa-arrow-left"></i>
                        Kembali
                    </a>

                </div>

            </form>
        </div>

    </div>

</body>
</html>