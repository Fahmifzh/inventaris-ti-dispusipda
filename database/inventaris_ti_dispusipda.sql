-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 28, 2026 at 03:57 AM
-- Server version: 10.4.32-MariaDB-log
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventaris_ti_dispusipda`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `nama`, `username`, `password`, `created_at`) VALUES
(1, 'Administrator', 'admin', '0192023a7bbd73250516f069df18b500', '2026-07-28 01:25:08');

-- --------------------------------------------------------

--
-- Table structure for table `gedung`
--

CREATE TABLE `gedung` (
  `id` int(11) NOT NULL,
  `nama_gedung` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gedung`
--

INSERT INTO `gedung` (`id`, `nama_gedung`, `created_at`) VALUES
(1, 'Gedung Perpustakaan', '2026-07-28 01:25:29'),
(2, 'Gedung Arsip', '2026-07-28 01:25:29');

-- --------------------------------------------------------

--
-- Table structure for table `inventaris`
--

CREATE TABLE `inventaris` (
  `id` int(11) NOT NULL,
  `nama_hardware` varchar(255) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `merk` varchar(100) DEFAULT NULL,
  `jumlah` int(11) DEFAULT 1,
  `spesifikasi` text DEFAULT NULL,
  `ruangan_id` int(11) DEFAULT NULL,
  `tahun_pengadaan` year(4) NOT NULL,
  `kondisi` enum('Baik','Rusak Ringan','Rusak Berat') DEFAULT 'Baik',
  `status` enum('Tersedia','Dipinjam','Maintenance') DEFAULT 'Tersedia',
  `kode_aset` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lantai`
--

CREATE TABLE `lantai` (
  `id` int(11) NOT NULL,
  `gedung_id` int(11) NOT NULL,
  `nama_lantai` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lantai`
--

INSERT INTO `lantai` (`id`, `gedung_id`, `nama_lantai`, `created_at`) VALUES
(1, 1, 'Lantai 1', '2026-07-28 01:28:55'),
(2, 1, 'Lantai 2', '2026-07-28 01:28:55'),
(3, 1, 'Lantai 3', '2026-07-28 01:28:55'),
(4, 1, 'Lantai 4', '2026-07-28 01:28:55'),
(5, 2, 'Lantai 1', '2026-07-28 01:28:55'),
(6, 2, 'Lantai 2', '2026-07-28 01:28:55'),
(7, 2, 'Lantai 3', '2026-07-28 01:28:55'),
(8, 2, 'Lantai 4', '2026-07-28 01:28:55'),
(9, 2, 'Lantai 5', '2026-07-28 01:28:55'),
(10, 2, 'Lantai 6', '2026-07-28 01:28:55'),
(11, 2, 'Lantai 7', '2026-07-28 01:28:55');

-- --------------------------------------------------------

--
-- Table structure for table `maintenance`
--

CREATE TABLE `maintenance` (
  `id` int(11) NOT NULL,
  `inventaris_id` int(11) NOT NULL,
  `tanggal_lapor` date NOT NULL,
  `kerusakan` text NOT NULL,
  `keparahan` enum('Rendah','Sedang','Tinggi') DEFAULT 'Sedang',
  `teknisi` varchar(100) DEFAULT NULL,
  `tindakan` text DEFAULT NULL,
  `status` enum('Menunggu','Dalam Perbaikan','Selesai') DEFAULT 'Menunggu',
  `tanggal_selesai` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int(11) NOT NULL,
  `inventaris_id` int(11) NOT NULL,
  `nama_peminjam` varchar(150) NOT NULL,
  `divisi` varchar(150) DEFAULT NULL,
  `tanggal_pinjam` date NOT NULL,
  `est_kembali` date DEFAULT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `status` enum('Dipinjam','Dikembalikan') DEFAULT 'Dipinjam',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ruangan`
--

CREATE TABLE `ruangan` (
  `id` int(11) NOT NULL,
  `lantai_id` int(11) NOT NULL,
  `kode_ruangan` varchar(20) NOT NULL,
  `nama_ruangan` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ruangan`
--

INSERT INTO `ruangan` (`id`, `lantai_id`, `kode_ruangan`, `nama_ruangan`, `created_at`) VALUES
(1, 1, 'RAK', 'Ruang Anak dan Keluarga', '2026-07-28 01:41:59'),
(2, 1, 'TP', 'Tempat Pengembalian', '2026-07-28 01:41:59'),
(3, 1, 'REG', 'Registrasi', '2026-07-28 01:41:59'),
(4, 1, 'RAG', 'Anggota RAG', '2026-07-28 01:41:59'),
(5, 2, 'RBD1', 'Ruang Baca Dewasa 1', '2026-07-28 01:41:59'),
(6, 2, 'RBD2', 'Ruang Baca Dewasa 2', '2026-07-28 01:41:59'),
(7, 2, 'PHUSAKA', 'PHUSAKA', '2026-07-28 01:41:59'),
(8, 2, 'BIC', 'BI Corner', '2026-07-28 01:41:59'),
(9, 2, 'RK', 'Ruang Kabel', '2026-07-28 01:41:59'),
(10, 3, 'REF', 'Ruang Referensi', '2026-07-28 01:41:59'),
(11, 3, 'REM', 'Ruang Remaja', '2026-07-28 01:41:59'),
(12, 3, 'RK', 'Ruang Kabel', '2026-07-28 01:41:59'),
(13, 3, 'GCO', 'Galeri COVID', '2026-07-28 01:41:59'),
(14, 4, 'RK', 'Ruang Kabel', '2026-07-28 01:41:59'),
(15, 4, 'RPUS', 'Ruang Pustakawan', '2026-07-28 01:41:59'),
(16, 4, 'AULA', 'Aula', '2026-07-28 01:41:59'),
(17, 5, 'PLI', 'Pusat Layanan Informasi', '2026-07-28 01:41:59'),
(18, 5, 'TR', 'Teater', '2026-07-28 01:41:59'),
(19, 5, 'ADM', 'Ruang Administrasi', '2026-07-28 01:41:59'),
(20, 5, 'R.HUM', 'Humas', '2026-07-28 01:41:59'),
(21, 5, 'RPT', 'Ruang Rapat', '2026-07-28 01:41:59'),
(22, 5, 'TUPIM', 'TU Pimpinan', '2026-07-28 01:41:59'),
(23, 5, 'RBAK', 'Subag Keuangan dan Aset', '2026-07-28 01:41:59'),
(24, 5, 'KEP.U', 'Kepegawaian dan Umum', '2026-07-28 01:41:59'),
(25, 5, 'RP', 'Perencanaan', '2026-07-28 01:41:59'),
(26, 5, 'LIK', 'R.LIK Layanan Informasi Kearsipan', '2026-07-28 01:41:59'),
(27, 5, 'BPBGM', 'BPBGM', '2026-07-28 01:41:59'),
(28, 5, 'KBBPGM', 'Ruang Kepala Bagian BPBGM', '2026-07-28 01:41:59'),
(29, 6, 'RPAS', 'R.PAS Ruang Bagian Arsip', '2026-07-28 01:41:59'),
(30, 6, 'KBPAS', 'KBPAS Kabid Pengelolaan Arsip Statis', '2026-07-28 01:41:59'),
(31, 6, 'KBPPK', 'Kabid Pelayanan Perpustakaan dan Kearsipan', '2026-07-28 01:41:59'),
(32, 6, 'TUPPK', 'TU Bidang PPK', '2026-07-28 01:41:59'),
(33, 6, 'RED', 'Ruang Entri Data', '2026-07-28 01:41:59'),
(34, 6, 'RPAD', 'RPAD', '2026-07-28 01:41:59'),
(35, 6, 'KBPAD', 'KBPAD', '2026-07-28 01:41:59'),
(36, 6, 'BIDEP', 'Bidang Deposit', '2026-07-28 01:41:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `gedung`
--
ALTER TABLE `gedung`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventaris`
--
ALTER TABLE `inventaris`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_aset` (`kode_aset`),
  ADD KEY `ruangan_id` (`ruangan_id`);

--
-- Indexes for table `lantai`
--
ALTER TABLE `lantai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gedung_id` (`gedung_id`);

--
-- Indexes for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventaris_id` (`inventaris_id`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventaris_id` (`inventaris_id`);

--
-- Indexes for table `ruangan`
--
ALTER TABLE `ruangan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lantai_id` (`lantai_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gedung`
--
ALTER TABLE `gedung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `inventaris`
--
ALTER TABLE `inventaris`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lantai`
--
ALTER TABLE `lantai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `maintenance`
--
ALTER TABLE `maintenance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ruangan`
--
ALTER TABLE `ruangan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inventaris`
--
ALTER TABLE `inventaris`
  ADD CONSTRAINT `inventaris_ibfk_1` FOREIGN KEY (`ruangan_id`) REFERENCES `ruangan` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `lantai`
--
ALTER TABLE `lantai`
  ADD CONSTRAINT `lantai_ibfk_1` FOREIGN KEY (`gedung_id`) REFERENCES `gedung` (`id`);

--
-- Constraints for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD CONSTRAINT `maintenance_ibfk_1` FOREIGN KEY (`inventaris_id`) REFERENCES `inventaris` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`inventaris_id`) REFERENCES `inventaris` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ruangan`
--
ALTER TABLE `ruangan`
  ADD CONSTRAINT `ruangan_ibfk_1` FOREIGN KEY (`lantai_id`) REFERENCES `lantai` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
