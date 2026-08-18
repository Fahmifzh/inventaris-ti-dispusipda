<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

// ===== PERBAIKI PATH =====
$rootPath = $_SERVER['DOCUMENT_ROOT'] . '/inventaris-ti-dispusipda';
require $rootPath . '/vendor/autoload.php';
require $rootPath . '/config/database.php';
// =========================

use PhpOffice\PhpSpreadsheet\IOFactory;

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

if (isset($_POST['import']) && isset($_FILES['file_excel'])) {
    
    if ($_FILES['file_excel']['error'] !== UPLOAD_ERR_OK) {
        $uploadErrors = [
            UPLOAD_ERR_INI_SIZE => "File terlalu besar! Maksimal " . ini_get('upload_max_filesize'),
            UPLOAD_ERR_FORM_SIZE => "File terlalu besar!",
            UPLOAD_ERR_PARTIAL => "File hanya terupload sebagian!",
            UPLOAD_ERR_NO_FILE => "Tidak ada file yang diupload!",
            UPLOAD_ERR_NO_TMP_DIR => "Folder temporary tidak ditemukan!",
            UPLOAD_ERR_CANT_WRITE => "Gagal menulis file!",
            UPLOAD_ERR_EXTENSION => "Upload dihentikan oleh ekstensi PHP!",
        ];
        $errorMsg = $uploadErrors[$_FILES['file_excel']['error']] ?? "Unknown upload error";
        header("Location: ../index.php?error=" . urlencode($errorMsg));
        exit;
    }

    $fileTmpPath = $_FILES['file_excel']['tmp_name'];
    
    if ($_FILES['file_excel']['size'] == 0) {
        header("Location: ../index.php?error=" . urlencode("File kosong!"));
        exit;
    }

    try {
        $spreadsheet = IOFactory::load($fileTmpPath);
        
        // ============================================================
        // AMBIL SEMUA DATA RUANGAN DARI DATABASE (NAMA + KODE)
        // ============================================================
        $mapRuangan = [];
        $resRuangan = mysqli_query($conn, "SELECT id, nama_ruangan, kode_ruangan FROM ruangan");
        if ($resRuangan) {
            while ($r = mysqli_fetch_assoc($resRuangan)) {
                $id = $r['id'];
                $nama = strtolower(trim($r['nama_ruangan']));
                $kode = strtolower(trim($r['kode_ruangan']));
                
                // Mapping by kode
                $mapRuangan[$kode] = $id;
                
                // Mapping by nama
                $mapRuangan[$nama] = $id;
                
                // Mapping tanpa spasi
                $mapRuangan[preg_replace('/\s+/', '', $nama)] = $id;
                $mapRuangan[preg_replace('/\s+/', '', $kode)] = $id;
                
                // Mapping by kode dengan titik (contoh: R.LIK → rlik)
                $kodeNoDot = str_replace('.', '', $kode);
                if ($kodeNoDot != $kode) {
                    $mapRuangan[$kodeNoDot] = $id;
                }
                
                // Mapping by kode dengan huruf besar/kecil (contoh: KEP.U → kepu)
                $kodeLower = strtolower($kode);
                $mapRuangan[$kodeLower] = $id;
            }
        }

        // ============================================================
        // MAPPING KHUSUS (MANUAL) UNTUK RUANGAN YANG SERING ERROR
        // ============================================================
        $manualMapping = [
            // ARSIP L1
            'r.pas' => 'RPAS',
            'r.pas ruang bagian arsip' => 'RPAS',
            'r.pas ruang bagian arsip (rp as)' => 'RPAS',
            'kep.u' => 'KEP.U',
            'kepegawaian dan umum kep.u' => 'KEP.U',
            'kepegawaian dan umum' => 'KEP.U',
            'r.lik' => 'LIK',
            'r.lik layanan informasi kearsipan' => 'LIK',
            'kbbpgm' => 'KBBPGM',
            'ruang kepala bagian bpbgm kbbpbgm' => 'KBBPGM',
            'ruang kepala bagian bpbgm' => 'KBBPGM',
            'r.ptm' => 'R.PTM',
            'pustama (r.ptm)' => 'R.PTM',
            'pustama' => 'R.PTM',
            'r.gas' => 'R.GAS',
            'ruangan petugas r.gas' => 'R.GAS',
            'rgas4' => 'RGAS4',
            'rgas4 ruangan petugas' => 'RGAS4',
            'depob' => 'DEPOB',
            'rpai' => 'RPAI',
            'ruang pengelolaan arsip inaktif (rpai)' => 'RPAI',
            'ruang pengelolaan arsip inaktif' => 'RPAI',
            'rpai6' => 'RPAI6',
            'ruang pengelolaan arsip inaktif lt6' => 'RPAI6',
            'rltjb' => 'RLTJB',
            'ruang literatur tentang jawa barat' => 'RLTJB',
            'pusat layanan informasi' => 'PLI',
            'pusat layanan informasi (pli)' => 'PLI',
            'teater' => 'TR',
            'teater(tr)' => 'TR',
            'ruang administrasi' => 'ADM',
            'ruang administrasi(adm)' => 'ADM',
            'humas' => 'R.HUM',
            'r.hum' => 'R.HUM',
            'ruang rapat' => 'RPT',
            'ruang rapat rpt' => 'RPT',
            'tu pimpinan' => 'TUPIM',
            'tu pimpinan tupim' => 'TUPIM',
            'tupim' => 'TUPIM',
            'subag keuangan dan aset' => 'RBAK',
            'rba' => 'RBAK',
            'perencanaan' => 'RP',
            'bpbgm' => 'BPBGM',
            'umum' => 'RU',
            'ruangan sekretaris' => 'RSEK',
            'ruang data center' => 'RRC',
            'r preservasi arsip' => 'PRESIP',
            'kepala dinas' => 'RKADIS',
            'kbpas' => 'KBPAS',
            'kbppk' => 'KBPPK',
            'tuppk' => 'TUPPK',
            'ruang entri data' => 'RED',
            'rpsts' => 'RPSTS',
            'ruang pengolahan arsip statis' => 'RPSTS',
            'depo arsip b' => 'DEPOB',
            
            // PERPUS
            'perpustakaan' => 'PERPUS',
            'ruang anak dan keluarga' => 'RAK',
            'tempat pengembalian' => 'TP',
            'registrasi' => 'REG',
            'anggota rag' => 'RAG',
            'ruang baca dewasa 1' => 'RBD1',
            'ruang baca dewasa 2' => 'RBD2',
            'phusaka' => 'PHUSAKA',
            'bi corner' => 'BIC',
            'ruang kabel' => 'RK',
            'ruang referensi' => 'REF',
            'referensi' => 'REF',
            'ruang remaja' => 'REM',
            'remaja' => 'REM',
            'galeri covid' => 'GCO',
            'ruang pustakawan' => 'RPUS',
            'aula' => 'AULA',
            
            // BIDEP
            'bidang deposit' => 'BIDEP',
            'bidep' => 'BIDEP',
        ];

        // ============================================================
        // FUNGSI MENCARI RUANGAN_ID DARI NAMA RUANGAN DI EXCEL
        // ============================================================
        function cariRuanganId($namaRuangan, $mapRuangan, $manualMapping) {
            if (empty($namaRuangan)) return null;
            
            $nama = strtolower(trim($namaRuangan));
            
            // 0. Cek manual mapping dulu
            if (isset($manualMapping[$nama])) {
                $kodeManual = strtolower($manualMapping[$nama]);
                if (isset($mapRuangan[$kodeManual])) {
                    return $mapRuangan[$kodeManual];
                }
            }
            
            // 1. Coba langsung
            if (isset($mapRuangan[$nama])) {
                return $mapRuangan[$nama];
            }
            
            // 2. Coba tanpa spasi
            $noSpace = preg_replace('/\s+/', '', $nama);
            if (isset($mapRuangan[$noSpace])) {
                return $mapRuangan[$noSpace];
            }
            
            // 3. Coba ambil kode dalam kurung (contoh: "PUSAT LAYANAN INFORMASI (PLI)" → "pli")
            if (preg_match('/\(([^)]+)\)/', $nama, $matches)) {
                $kodeDalamKurung = strtolower(trim($matches[1]));
                if (isset($mapRuangan[$kodeDalamKurung])) {
                    return $mapRuangan[$kodeDalamKurung];
                }
            }
            
            // 4. Coba ambil kata terakhir (contoh: "Ruang Rapat RPT" → "rpt")
            $words = preg_split('/[\s\-]+/', $nama);
            $lastWord = end($words);
            if (!empty($lastWord) && isset($mapRuangan[$lastWord])) {
                return $mapRuangan[$lastWord];
            }
            
            // 5. Coba ambil kata pertama (contoh: "R.PAS RUANG BAGIAN ARSIP" → "rpas")
            $firstWord = $words[0] ?? '';
            if (!empty($firstWord) && isset($mapRuangan[$firstWord])) {
                return $mapRuangan[$firstWord];
            }
            
            // 6. Coba ambil singkatan (contoh: "Ruang Anak dan Keluarga" → "rak")
            $singkatan = '';
            $stopWords = ['dan', 'di', 'ke', 'dari', 'untuk', 'yang', 'atau', 'dan', 'ruang', 'bagian', 'pusat', 'layanan', 'informasi'];
            foreach ($words as $w) {
                $wClean = strtolower(trim($w));
                if (!empty($wClean) && strlen($wClean) > 1 && !in_array($wClean, $stopWords)) {
                    $singkatan .= substr($wClean, 0, 1);
                }
            }
            if (strlen($singkatan) >= 2 && isset($mapRuangan[$singkatan])) {
                return $mapRuangan[$singkatan];
            }
            
            // 7. Coba cari dengan menghilangkan semua karakter non-huruf
            $cleanKey = preg_replace('/[^a-z0-9]/', '', $nama);
            foreach ($mapRuangan as $dbKey => $id) {
                $dbClean = preg_replace('/[^a-z0-9]/', '', $dbKey);
                if ($cleanKey == $dbClean) {
                    return $id;
                }
            }
            
            return null;
        }

        // ============================================================
        // MAPPING HEADER EXCEL → DATABASE
        // ============================================================
        $headerMapping = [
            'ruangan' => ['ruangan', 'lokasi', 'ruang', 'nama_ruangan', 'kode_ruangan'],
            'jenis_perangkat' => ['jenis perangkat', 'jenis', 'kategori', 'jenis_perangkat', 'jenisperangkat', 'perangkat'],
            'merk' => ['merk', 'brand', 'merek', 'merk laptop', 'merk pc'],
            'jumlah' => ['jumlah', 'qty', 'quantity', 'jml'],
            'spesifikasi' => ['spesifikasi', 'spec', 'spesifikasi', 'detail', 'keterangan'],
            'kondisi' => ['kondisi', 'condition', 'status_kondisi', 'kondisi barang'],
            'tahun' => ['tahun', 'tahun_pengadaan', 'thn', 'year', 'tahun perolehan'],
            'kode' => ['kode', 'kode aset', 'kode_aset', 'kode-aset', 'id', 'no', 'nomor']
        ];

        $totalInserted = 0;
        $totalSkipped = 0;
        $totalSheets = 0;
        $ruanganNotFound = [];

        // ============================================================
        // LOOP SEMUA SHEET
        // ============================================================
        foreach ($spreadsheet->getAllSheets() as $sheetIndex => $worksheet) {
            $sheetName = $worksheet->getTitle();
            $rows = $worksheet->toArray();
            
            if (empty($rows)) continue;
            
            // Cari baris header
            $headerRowIndex = -1;
            $foundHeader = false;
            
            for ($i = 0; $i < min(10, count($rows)); $i++) {
                $row = $rows[$i];
                if (empty($row)) continue;
                
                $rowString = strtolower(implode(' ', array_filter($row)));
                if (strpos($rowString, 'ruangan') !== false || 
                    strpos($rowString, 'jenis perangkat') !== false ||
                    strpos($rowString, 'kode') !== false) {
                    $headerRowIndex = $i;
                    $foundHeader = true;
                    break;
                }
            }
            
            if (!$foundHeader) continue;
            
            $headerRow = $rows[$headerRowIndex];
            $header = array_map(fn($v) => strtolower(trim((string)$v)), $headerRow);
            
            // Cari posisi kolom
            $idxMap = [];
            foreach ($headerMapping as $dbField => $variants) {
                foreach ($variants as $variant) {
                    $pos = array_search($variant, $header);
                    if ($pos !== false) {
                        $idxMap[$dbField] = $pos;
                        break;
                    }
                }
            }
            
            if (!isset($idxMap['kode']) || !isset($idxMap['jenis_perangkat'])) {
                continue;
            }
            
            $idxRuangan   = $idxMap['ruangan'] ?? -1;
            $idxKategori  = $idxMap['jenis_perangkat'];
            $idxMerk      = $idxMap['merk'] ?? -1;
            $idxJumlah    = $idxMap['jumlah'] ?? -1;
            $idxSpek      = $idxMap['spesifikasi'] ?? -1;
            $idxKondisi   = $idxMap['kondisi'] ?? -1;
            $idxTahun     = $idxMap['tahun'] ?? -1;
            $idxKode      = $idxMap['kode'];
            
            // ============================================================
            // VARIABEL UNTUK MENYIMPAN NAMA RUANGAN TERAKHIR (MERGE CELL)
            // ============================================================
            $lastRuangan = '';
            
            // Loop data
            for ($i = $headerRowIndex + 1; $i < count($rows); $i++) {
                $row = $rows[$i];
                if (empty(array_filter($row))) continue;
                
                // ===== AMBIL NAMA RUANGAN =====
                $namaRuangan = '';
                if ($idxRuangan >= 0 && isset($row[$idxRuangan])) {
                    $namaRuangan = trim((string)$row[$idxRuangan]);
                }
                
                // ===== JIKA NAMA RUANGAN KOSONG, PAKAI YANG TERAKHIR (MERGE CELL) =====
                if (empty($namaRuangan) && !empty($lastRuangan)) {
                    $namaRuangan = $lastRuangan;
                } elseif (!empty($namaRuangan)) {
                    // Update lastRuangan jika ada isi
                    $lastRuangan = $namaRuangan;
                }
                
                // Ambil data lainnya
                $kodeAset    = isset($row[$idxKode]) ? trim((string)$row[$idxKode]) : '';
                $kategori    = isset($row[$idxKategori]) ? trim((string)$row[$idxKategori]) : '';
                $merk        = isset($row[$idxMerk]) && $idxMerk >= 0 ? trim((string)$row[$idxMerk]) : '';
                $jumlah      = isset($row[$idxJumlah]) && $idxJumlah >= 0 && is_numeric($row[$idxJumlah]) ? (int)$row[$idxJumlah] : 1;
                $spesifikasi = isset($row[$idxSpek]) && $idxSpek >= 0 ? trim((string)$row[$idxSpek]) : '';
                $kondisi     = isset($row[$idxKondisi]) && $idxKondisi >= 0 ? trim((string)$row[$idxKondisi]) : 'Baik';
                $tahun       = isset($row[$idxTahun]) && $idxTahun >= 0 && is_numeric($row[$idxTahun]) ? (int)$row[$idxTahun] : date('Y');
                
                if (empty($kodeAset) && empty($kategori)) continue;
                
                if (empty($kodeAset)) {
                    $kodeAset = 'AST-' . strtoupper(substr($kategori, 0, 3)) . '-' . rand(100, 999);
                }
                
                $namaHardware = !empty($merk) ? $merk : $kategori;
                
                // ===== CARI RUANGAN_ID =====
                $ruanganId = cariRuanganId($namaRuangan, $mapRuangan, $manualMapping);
                
                // Catat ruangan yang tidak ditemukan
                if ($ruanganId === null && !empty($namaRuangan)) {
                    $ruanganNotFound[] = $namaRuangan;
                }
                
                // Cek duplikasi
                $stmtCheck = mysqli_prepare($conn, "SELECT id FROM inventaris WHERE kode_aset = ?");
                if ($stmtCheck) {
                    mysqli_stmt_bind_param($stmtCheck, "s", $kodeAset);
                    mysqli_stmt_execute($stmtCheck);
                    mysqli_stmt_store_result($stmtCheck);
                    
                    if (mysqli_stmt_num_rows($stmtCheck) == 0) {
                        $sqlInsert = "INSERT INTO inventaris 
                            (kode_aset, nama_hardware, kategori, merk, jumlah, spesifikasi, ruangan_id, tahun_pengadaan, kondisi, status) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Tersedia')";

                        $stmt = mysqli_prepare($conn, $sqlInsert);
                        if ($stmt) {
                            mysqli_stmt_bind_param($stmt, "ssssisiis", 
                                $kodeAset, 
                                $namaHardware, 
                                $kategori, 
                                $merk, 
                                $jumlah, 
                                $spesifikasi, 
                                $ruanganId, 
                                $tahun, 
                                $kondisi
                            );
                            
                            if (mysqli_stmt_execute($stmt)) {
                                $totalInserted++;
                            } else {
                                $totalSkipped++;
                            }
                            mysqli_stmt_close($stmt);
                        }
                    } else {
                        $totalSkipped++;
                    }
                    mysqli_stmt_close($stmtCheck);
                }
            }
            $totalSheets++;
        }

        // ===== BUAT PESAN HASIL =====
        $msg = "Berhasil import $totalInserted data dari $totalSheets sheet";
        if ($totalSkipped > 0) {
            $msg .= ", $totalSkipped data di-skip (duplikat atau error)";
        }
        
        // Tambahkan info ruangan yang tidak ditemukan
        if (!empty($ruanganNotFound)) {
            $uniqueRuangan = array_unique($ruanganNotFound);
            $maxShow = 10;
            $countRuangan = count($uniqueRuangan);
            $ruanganList = implode(', ', array_slice($uniqueRuangan, 0, $maxShow));
            if ($countRuangan > $maxShow) {
                $ruanganList .= ", dan " . ($countRuangan - $maxShow) . " lainnya";
            }
            $msg .= " | ⚠️ Ruangan tidak ditemukan: $ruanganList";
        }
        
        header("Location: ../index.php?success=1&msg=" . urlencode($msg));
        exit;

    } catch (Exception $e) {
        header("Location: ../index.php?error=" . urlencode("Error: " . $e->getMessage()));
        exit;
    }
} else {
    header("Location: ../index.php");
    exit;
}
?>