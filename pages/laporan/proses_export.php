<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

include '../../config/database.php';

$jenis = $_GET['jenis'] ?? '';
$format = $_GET['format'] ?? '';

$judul_map = [
    'inventaris' => 'Laporan Inventaris Bulanan',
    'maintenance' => 'Laporan Maintenance',
    'peminjaman' => 'Laporan Sirkulasi Peminjaman',
    'kritis' => 'Laporan Inventaris Kritis & Aging',
];

if (!isset($judul_map[$jenis])) {
    die('Jenis laporan tidak valid.');
}
$judul = $judul_map[$jenis];

// mengambil data sesuai jenis laporan
switch ($jenis) {
    case 'inventaris':
        $kolom = ['Kode Aset', 'Nama Hardware', 'Kategori', 'Ruangan ID', 'Tahun', 'Status'];
        $res = mysqli_query($conn, "SELECT kode_aset, nama_hardware, kategori, ruangan_id, tahun_pengadaan, status FROM inventaris ORDER BY id ASC");
        $baris_key = ['kode_aset', 'nama_hardware', 'kategori', 'ruangan_id', 'tahun_pengadaan', 'status'];
        break;

    case 'maintenance':
        $kolom = ['Kode Aset', 'Nama Hardware', 'Tanggal Lapor', 'Kerusakan', 'Keparahan', 'Status', 'Teknisi'];
        $res = mysqli_query($conn, "
            SELECT i.kode_aset, i.nama_hardware, m.tanggal_lapor, m.kerusakan, m.keparahan, m.status, m.teknisi
            FROM maintenance m
            LEFT JOIN inventaris i ON m.inventaris_id = i.id
            ORDER BY m.id DESC
        ");
        $baris_key = ['kode_aset', 'nama_hardware', 'tanggal_lapor', 'kerusakan', 'keparahan', 'status', 'teknisi'];
        break;

    case 'peminjaman':
        $kolom = ['Nama Peminjam', 'Divisi', 'Perangkat', 'Kode', 'Tgl Pinjam', 'Est. Kembali', 'Status'];
        $res = mysqli_query($conn, "
            SELECT p.nama_peminjam, p.divisi, i.nama_hardware, i.kode_aset, p.tanggal_pinjam, p.est_kembali, p.status
            FROM peminjaman p
            JOIN inventaris i ON p.inventaris_id = i.id
            ORDER BY p.tanggal_pinjam DESC
        ");
        $baris_key = ['nama_peminjam', 'divisi', 'nama_hardware', 'kode_aset', 'tanggal_pinjam', 'est_kembali', 'status'];
        break;

    case 'kritis':
        $tahun_kritis = date('Y') - 5;
        $kolom = ['Kode Aset', 'Nama Hardware', 'Tahun Pengadaan', 'Umur (tahun)', 'Status'];
        $res = mysqli_query($conn, "
            SELECT kode_aset, nama_hardware, tahun_pengadaan, status
            FROM inventaris
            WHERE tahun_pengadaan IS NOT NULL AND tahun_pengadaan <= $tahun_kritis
            ORDER BY tahun_pengadaan ASC
        ");
        $baris_key = ['kode_aset', 'nama_hardware', 'tahun_pengadaan', null, 'status']; // null = kolom hitung manual (umur)
        break;
}

$data = [];
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $data[] = $row;
    }
}

// format excel
if ($format === 'excel') {
    $filename = 'Laporan_' . ucfirst($jenis) . '_' . date('Y-m-d_His') . '.xls';
    header('Content-Type: application/vnd.ms-excel; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $navy = '#16215C';
    $navyDark = '#0F1740';
    $grayLight = '#F5F6FA';
    $borderColor = '#C9CDE0';
    $totalKolom = count($kolom) + 1; // +1 untuk kolom "No"
    ?>
    <!DOCTYPE html>
    <html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel"
        xmlns="http://www.w3.org/TR/REC-html40">

    <head>
        <meta charset="UTF-8">
        <!--[if gte mso 9]>
<xml>
<x:ExcelWorkbook>
<x:ExcelWorksheets>
<x:ExcelWorksheet>
<x:Name><?= htmlspecialchars(substr($judul, 0, 30)) ?></x:Name>
<x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions>
</x:ExcelWorksheet>
</x:ExcelWorksheets>
</x:ExcelWorkbook>
</xml>
<![endif]-->
        <style>
            table {
                border-collapse: collapse;
                font-family: Calibri, Arial, sans-serif;
            }

            td,
            th {
                border: 1px solid
                    <?= $borderColor ?>
                ;
                padding: 6px 10px;
                font-size: 12px;
            }
        </style>
    </head>

    <body>

        <table>
            <!-- ===== KOP SURAT ===== -->
            <tr>
                <td colspan="<?= $totalKolom ?>" style="border:none; text-align:center; padding:4px;">
                    <span style="font-size:13px; font-weight:bold; color:#333;">PEMERINTAH PROVINSI JAWA BARAT</span>
                </td>
            </tr>
            <tr>
                <td colspan="<?= $totalKolom ?>" style="border:none; text-align:center; padding:2px;">
                    <span
                        style="font-size:18px; font-weight:bold; color:<?= $navy ?>; letter-spacing:1px;">DISPUSIPDA</span>
                </td>
            </tr>
            <tr>
                <td colspan="<?= $totalKolom ?>" style="border:none; text-align:center; padding:2px 4px 10px;">
                    <span style="font-size:11px; color:#666;">Dinas Perpustakaan dan Kearsipan Daerah — Sistem Inventaris
                        Perangkat TI</span>
                </td>
            </tr>
            <tr>
                <td colspan="<?= $totalKolom ?>"
                    style="border:none; border-bottom:3px solid <?= $navy ?>; padding:0; line-height:2px;">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="<?= $totalKolom ?>" style="border:none; padding:4px;">&nbsp;</td>
            </tr>

            <!-- ===== JUDUL LAPORAN (dinamis sesuai jenis) ===== -->
            <tr>
                <td colspan="<?= $totalKolom ?>" style="border:none; text-align:center; padding:2px;">
                    <span
                        style="font-size:15px; font-weight:bold; color:#1c1c2b;"><?= htmlspecialchars(mb_strtoupper($judul)) ?></span>
                </td>
            </tr>
            <tr>
                <td colspan="<?= $totalKolom ?>"
                    style="border:none; text-align:center; padding:2px 2px 14px; color:#888; font-size:10.5px;">
                    Dicetak pada <?= date('d-m-Y H:i') ?> WIB
                </td>
            </tr>

            <!-- ===== HEADER TABEL ===== -->
            <tr>
                <th
                    style="background:<?= $navy ?>; color:#ffffff; font-weight:bold; text-align:center; padding:8px 10px; border:1px solid <?= $navyDark ?>;">
                    No</th>
                <?php foreach ($kolom as $k): ?>
                    <th
                        style="background:<?= $navy ?>; color:#ffffff; font-weight:bold; text-align:center; padding:8px 10px; border:1px solid <?= $navyDark ?>;">
                        <?= htmlspecialchars($k) ?>
                    </th>
                <?php endforeach; ?>
            </tr>

            <!-- ===== DATA ===== -->
            <?php if (empty($data)): ?>
                <tr>
                    <td colspan="<?= $totalKolom ?>" style="text-align:center; padding:16px; color:#888;">Tidak ada data.</td>
                </tr>
            <?php else: ?>
                <?php $no = 1;
                foreach ($data as $row): ?>
                    <tr style="background:<?= ($no % 2 === 0) ? $grayLight : '#ffffff' ?>;">
                        <td style="text-align:center;"><?= $no++ ?></td>
                        <?php foreach ($baris_key as $i => $key): ?>
                            <?php
                            $isKode = ($kolom[$i] ?? '') === 'Kode' || ($kolom[$i] ?? '') === 'Kode Aset';
                            $isStatus = ($kolom[$i] ?? '') === 'Status';
                            $nilai = $key === null
                                ? (date('Y') - (int) $row['tahun_pengadaan'])
                                : ($row[$key] ?? '-');
                            $warna = '';
                            if ($isKode)
                                $warna = "font-weight:bold; color:{$navy};";
                            if ($isStatus) {
                                $warna = 'font-weight:bold;';
                                if (in_array($nilai, ['Dipinjam', 'Proses', 'Menunggu']))
                                    $warna .= 'color:#B8770F;';
                                elseif (in_array($nilai, ['Dikembalikan', 'Selesai', 'Tersedia', 'Aktif']))
                                    $warna .= 'color:#1F9D55;';
                                elseif ($nilai === 'Maintenance')
                                    $warna .= 'color:#D64545;';
                            }
                            ?>
                            <td style="<?= ($isKode || $isStatus) ? 'text-align:center;' : '' ?> <?= $warna ?>">
                                <?= htmlspecialchars((string) $nilai) ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="<?= $totalKolom ?>" style="border:none; padding:10px 4px 2px; font-size:10.5px; color:#888;">
                        Total <?= count($data) ?> data
                    </td>
                </tr>
            <?php endif; ?>
        </table>

    </body>

    </html>
    <?php
    exit;
}

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($judul) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 32px 40px;
            color: #1c1c2b;
        }

        .kop-surat {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 18px;
            text-align: center;
            padding-bottom: 14px;
        }

        .kop-surat img {
            width: 64px;
            height: 64px;
            object-fit: contain;
        }

        .logo-fallback {
            display: none;
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: #16215c;
            color: #fff;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 0.02em;
            flex-shrink: 0;
        }

        .kop-text h2 {
            margin: 0;
            font-size: 13px;
            font-weight: 600;
            color: #333;
            letter-spacing: 0.03em;
        }

        .kop-text h1 {
            margin: 3px 0;
            font-size: 21px;
            font-weight: 700;
            color: #16215c;
            letter-spacing: 0.06em;
        }

        .kop-text p {
            margin: 0;
            font-size: 11.5px;
            color: #666;
        }

        .kop-garis-tebal {
            border-bottom: 3px solid #16215c;
            margin-top: 4px;
        }

        .kop-garis-tipis {
            border-bottom: 1px solid #16215c;
            margin-bottom: 22px;
            margin-top: 2px;
        }

        h1.judul-laporan {
            font-size: 18px;
            margin: 0 0 3px;
            text-align: center;
        }

        .sub {
            color: #666;
            font-size: 12px;
            margin-bottom: 22px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 7px 9px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
            font-weight: 700;
        }

        .no-print {
            margin-bottom: 16px;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="kop-surat">
        <img src="../../assets/img/logo.png" alt="Logo DISPUSIPDA"
            onerror="this.style.display='none'; document.getElementById('logoFallback').style.display='flex';">
        <div class="logo-fallback" id="logoFallback">DP</div>
        <div class="kop-text">
            <h2>PEMERINTAH PROVINSI JAWA BARAT</h2>
            <h1>DISPUSIPDA</h1>
            <p>Dinas Perpustakaan dan Kearsipan Daerah — Sistem Inventaris Perangkat TI</p>
        </div>
    </div>
    <div class="kop-garis-tebal"></div>
    <div class="kop-garis-tipis"></div>

    <h1 class="judul-laporan"><?= htmlspecialchars($judul) ?></h1>
    <p class="sub">Dicetak pada <?= date('d-m-Y H:i') ?> — DISPUSIPDA Provinsi Jawa Barat</p>

    <button class="no-print" onclick="window.print()">🖨️ Print / Save as PDF</button>

    <table>
        <thead>
            <tr>
                <?php foreach ($kolom as $k): ?>
                    <th><?= htmlspecialchars($k) ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($data)): ?>
                <tr>
                    <td colspan="<?= count($kolom) ?>">Tidak ada data.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <?php foreach ($baris_key as $key): ?>
                            <td>
                                <?php
                                if ($key === null) {
                                    echo date('Y') - (int) $row['tahun_pengadaan'];
                                } else {
                                    echo htmlspecialchars($row[$key] ?? '-');
                                }
                                ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <script>
        window.onload = function () { window.print(); };
    </script>

</body>

</html>