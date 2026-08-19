-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 19, 2026 at 01:56 AM
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
  `tahun_pengadaan` year(4) DEFAULT NULL,
  `kondisi` varchar(100) DEFAULT 'Baik',
  `status` enum('Tersedia','Dipinjam','Maintenance') DEFAULT 'Tersedia',
  `kode_aset` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventaris`
--

INSERT INTO `inventaris` (`id`, `nama_hardware`, `kategori`, `merk`, `jumlah`, `spesifikasi`, `ruangan_id`, `tahun_pengadaan`, `kondisi`, `status`, `kode_aset`, `created_at`) VALUES
(1, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-7100U, Windows 10 Pro, Storage 512 GB', 17, '2024', 'Baik', 'Tersedia', 'ARSIP-L1-PLI-PC-01', '2026-08-18 02:02:06'),
(2, 'Epson', 'Printer', 'Epson', 1, 'Epson L3250', 17, '2021', 'Baik', 'Tersedia', 'ARSIP-L1-PLI-PRN-01', '2026-08-18 02:02:06'),
(3, 'ViewSonic', 'Proyektor', 'ViewSonic', 1, '-', 18, '2023', 'Baik', 'Tersedia', 'ARSIP-L1-TR-PJT-01', '2026-08-18 02:02:06'),
(4, 'Tenda', 'Switch', 'Tenda', 1, '8 Port', 18, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-TR-SW-01', '2026-08-18 02:02:06'),
(5, 'TP-Link', 'Switch', 'TP-Link', 1, '8 Port', 19, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-ADM-SW-01', '2026-08-18 02:02:06'),
(6, 'HP', 'PC', 'HP', 1, 'RAM 2 GB, Intel Core i3-4170T, Windows 10 Pro, Storage 256 GB', 19, '2012', 'Baik', 'Tersedia', 'ARSIP-L1-ADM-PC-01', '2026-08-18 02:02:06'),
(7, 'LG', 'Monitor', 'LG', 1, '-', 20, '2021', 'Baik', 'Tersedia', 'ARSIP-L1-R.HUM-MON-01', '2026-08-18 02:02:06'),
(8, 'PowerLogic', 'CPU', 'PowerLogic', 1, 'RAM 16 GB, Intel Core i5-10400F, Windows 10 Pro, Storage 1.03 TB', 20, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-R.HUM-CPU-01', '2026-08-18 02:02:06'),
(9, 'Dell', 'Monitor', 'Dell', 1, '-', 20, '2013', 'Baik', 'Tersedia', 'ARSIP-L1-R.HUM-MON-02', '2026-08-18 02:02:06'),
(10, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-8130U, Windows 11 Pro, Storage 256 GB', 20, '2019', 'Baik', 'Tersedia', 'ARSIP-L1-R.HUM-PC-01', '2026-08-18 02:02:06'),
(11, 'Epson', 'Printer', 'Epson', 1, 'Epson L3250', 20, '2022', 'Baik', 'Tersedia', 'ARSIP-L1-R.HUM-PRN-01', '2026-08-18 02:02:06'),
(12, 'TP-Link', 'Switch', 'TP-Link', 1, '8 Port', 20, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-R.HUM-SW-01', '2026-08-18 02:02:06'),
(13, 'TP-Link', 'Switch', 'TP-Link', 1, '8 Port', 20, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-R.HUM-SW-02', '2026-08-18 02:02:06'),
(14, 'TP-Link', 'Access Point', 'TP-Link', 1, '8 Port', 21, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-RPT-AP-01', '2026-08-18 02:02:06'),
(15, 'TP-Link', 'Switch', 'TP-Link', 1, '8 Port', 21, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-RPT-SW-01', '2026-08-18 02:02:06'),
(16, 'Lenovo', 'PC', 'Lenovo', 1, 'Spesifikasi belum diketahui', 21, '2020', 'Baik', 'Tersedia', 'ARSIP-L1-RPT-PC-01', '2026-08-18 02:02:06'),
(17, 'Asus', 'Laptop', 'Asus', 1, 'RAM 4 GB, Intel Core i3-6006U, Windows 10 Pro, Storage 128 GB', 22, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-TUPIM-LTP-01', '2026-08-18 02:02:06'),
(18, 'Epson', 'Printer', 'Epson', 1, 'Epson L360', 22, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-TUPIM-PRN-01', '2026-08-18 02:02:06'),
(19, 'Epson', 'Printer', 'Epson', 1, 'Epson L405', 22, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-TUPIM-PRN-02', '2026-08-18 02:02:06'),
(20, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-2120, Windows 10 Pro, Storage 512 GB', 22, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-TUPIM-PC-01', '2026-08-18 02:02:06'),
(21, 'Epson', 'Scanner', 'Epson', 1, 'DS-1630', 22, '2025', 'Baik', 'Tersedia', 'ARSIP-L1-TUPIM-SCN-01', '2026-08-18 02:02:06'),
(22, 'Ubiquiti UniFi', 'Access Point', 'Ubiquiti UniFi', 1, '-', 22, '2016', 'Baik', 'Tersedia', 'ARSIP-L1-TUPIM-AP-01', '2026-08-18 02:02:06'),
(23, 'Acer', 'PC', 'Acer', 1, 'RAM 8 GB, Intel Core i5-13400, Windows 11, Storage 512 GB', 23, '2025', 'Baik', 'Tersedia', 'ARSIP-L1-RBAK-PC-01', '2026-08-18 02:02:06'),
(24, 'Epson', 'Printer', 'Epson', 1, 'Epson L3250', 23, '2022', 'Baik', 'Tersedia', 'ARSIP-L1-RBAK-PRN-01', '2026-08-18 02:02:06'),
(25, 'Canon', 'Scanner', 'Canon', 1, 'DR-F120', 23, '2023', 'Baik', 'Tersedia', 'ARSIP-L1-RBAK-SCN-01', '2026-08-18 02:02:06'),
(26, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-2120, Windows 10, Storage 1 TB', 23, '2012', 'Baik', 'Tersedia', 'ARSIP-L1-RBAK-PC-02', '2026-08-18 02:02:06'),
(27, 'Acer', 'PC', 'Acer', 1, 'RAM 8 GB, Intel Core i5-1400, Windows 11, Storage 512 GB', 23, '2025', 'Baik', 'Tersedia', 'ARSIP-L1-RBAK-PC-03', '2026-08-18 02:02:06'),
(28, 'Epson', 'Printer', 'Epson', 1, 'Epson L3250', 23, '2021', 'Baik', 'Tersedia', 'ARSIP-L1-RBAK-PRN-02', '2026-08-18 02:02:06'),
(29, 'Axioo', 'PC', 'Axioo', 1, 'RAM 16 GB, Intel Core i5-1155G7, Windows 11, Storage 512 GB', 23, '2023', 'Baik', 'Tersedia', 'ARSIP-L1-RBAK-PC-04', '2026-08-18 02:02:06'),
(30, 'Epson', 'Printer', 'Epson', 1, 'Epson L3550', 23, '2025', 'Baik', 'Tersedia', 'ARSIP-L1-RBAK-PRN-03', '2026-08-18 02:02:06'),
(31, 'Epson', 'Scanner', 'Epson', 1, 'DS-1630', 23, '2022', 'Baik', 'Tersedia', 'ARSIP-L1-RBAK-SCN-02', '2026-08-18 02:02:06'),
(32, 'Axioo', 'PC', 'Axioo', 1, 'RAM 16 GB, Intel Core i5-1155G7, Windows 11, Storage 512 GB', 23, '2023', 'Baik', 'Tersedia', 'ARSIP-L1-RBAK-PC-05', '2026-08-18 02:02:06'),
(33, 'Epson', 'Printer', 'Epson', 1, 'Epson L3250', 23, '2021', 'Baik', 'Tersedia', 'ARSIP-L1-RBAK-PRN-04', '2026-08-18 02:02:06'),
(34, 'Acer', 'PC', 'Acer', 1, 'RAM 8 GB, Intel Core i5-13400, Windows 11, Storage 512 GB', 23, '2025', 'Baik', 'Tersedia', 'ARSIP-L1-RBAK-PC-06', '2026-08-18 02:02:06'),
(35, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-7100U, Windows 10 Pro, Storage 512 GB', 23, '2017', 'Baik', 'Tersedia', 'ARSIP-L1-RBAK-PC-07', '2026-08-18 02:02:06'),
(36, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-4170T, Windows 10 Pro, Storage 512 GB', 23, '2017', 'Baik', 'Tersedia', 'ARSIP-L1-RBAK-PC-08', '2026-08-18 02:02:06'),
(37, 'Acer', 'PC', 'Acer', 1, 'RAM 8 GB, Intel Core i5-13400, Windows 11, Storage 512 GB', 23, '2025', 'Baik', 'Tersedia', 'ARSIP-L1-RBAK-PC-09', '2026-08-18 02:02:06'),
(38, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-2120, Windows 10 Pro, Storage 512 GB', 23, '2012', 'Baik', 'Tersedia', 'ARSIP-L1-RBAK-PC-10', '2026-08-18 02:02:06'),
(39, 'D-Link', 'Switch', 'D-Link', 1, '16 Port', 23, '2015', 'Baik', 'Tersedia', 'ARSIP-L1-RBAK-SW-01', '2026-08-18 02:02:06'),
(40, 'Epson', 'Printer', 'Epson', 1, 'Epson L360', 23, '2016', 'Baik', 'Tersedia', 'ARSIP-L1-RBAK-PRN-05', '2026-08-18 02:02:06'),
(41, 'Epson', 'Printer', 'Epson', 1, 'Epson L405', 23, '2018', 'Baik', 'Tersedia', 'ARSIP-L1-RBAK-PRN-06', '2026-08-18 02:02:06'),
(42, 'Epson', 'Printer', 'Epson', 1, 'Epson L3150', 24, '2019', 'Rusak Ringan', 'Maintenance', 'ARSIP-L1-KEP.U-PRN-01', '2026-08-18 02:02:06'),
(43, 'HP', 'PC', 'HP', 1, 'RAM 8 GB, Intel Core i5-8500T, Windows 10 Pro, Storage 1.14 TB', 24, '2019', 'Baik', 'Tersedia', 'ARSIP-L1-KEP.U-PC-01', '2026-08-18 02:02:06'),
(44, 'Epson', 'Scanner', 'Epson', 1, 'GT-1500', 24, '2017', 'Baik', 'Tersedia', 'ARSIP-L1-KEP.U-SCN-01', '2026-08-18 02:02:06'),
(45, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-2120, Windows 10 Pro, Storage 128 GB', 24, '2018', 'Baik', 'Tersedia', 'ARSIP-L1-KEP.U-PC-02', '2026-08-18 02:02:06'),
(46, 'Epson', 'Printer', 'Epson', 1, 'Epson L360', 24, '2018', 'Baik', 'Tersedia', 'ARSIP-L1-KEP.U-PRN-02', '2026-08-18 02:02:06'),
(47, 'Epson', 'Printer', 'Epson', 1, 'Epson L3250', 24, '2019', 'Baik', 'Tersedia', 'ARSIP-L1-KEP.U-PRN-03', '2026-08-18 02:02:06'),
(48, 'HP', 'PC', 'HP', 1, 'Spesifikasi belum diketahui', 24, '2018', 'Baik', 'Tersedia', 'ARSIP-L1-KEP.U-PC-03', '2026-08-18 02:02:06'),
(49, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-2120, Windows 10 Pro, Storage 128 GB', 24, '2018', 'Baik', 'Tersedia', 'ARSIP-L1-KEP.U-PC-04', '2026-08-18 02:02:06'),
(50, 'Epson', 'Printer', 'Epson', 1, 'Epson L405', 24, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-KEP.U-PRN-04', '2026-08-18 02:02:06'),
(51, 'TP-Link', 'Switch', 'TP-Link', 1, '8 Port', 24, '2023', 'Baik', 'Tersedia', 'ARSIP-L1-KEP.U-SW-01', '2026-08-18 02:02:06'),
(52, 'Lenovo', 'CPU', 'Lenovo', 1, 'Spesifikasi belum diketahui', 25, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-RP-CPU-01', '2026-08-18 02:02:06'),
(53, 'Lenovo', 'Monitor', 'Lenovo', 1, '-', 25, NULL, 'Rusak Ringan', 'Tersedia', 'ARSIP-L1-RP-MON-01', '2026-08-18 02:02:06'),
(54, 'HP', 'PC', 'HP', 1, 'RAM 12 GB, Intel Core i3-3240, Windows 10 Pro, Storage 1 TB', 25, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-RP-PC-01', '2026-08-18 02:02:06'),
(55, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-3240, Windows 10, Storage 512 GB', 25, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-RP-PC-02', '2026-08-18 02:02:06'),
(56, 'Epson', 'Printer', 'Epson', 1, 'Epson L3150', 25, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-RP-PRN-01', '2026-08-18 02:02:06'),
(57, 'Axioo', 'PC', 'Axioo', 1, 'RAM 16 GB, Intel Core i5-1155G7, Windows 11, Storage 512 GB', 25, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-RP-PC-03', '2026-08-18 02:02:06'),
(58, 'Epson', 'Printer', 'Epson', 1, 'Epson L3150', 25, '2019', 'Baik', 'Tersedia', 'ARSIP-L1-RP-PRN-02', '2026-08-18 02:02:06'),
(59, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-8130U, Windows 10, Storage 512 GB', 25, '2018', 'Baik', 'Tersedia', 'ARSIP-L1-RP-PC-04', '2026-08-18 02:02:06'),
(60, 'Dell', 'Monitor', 'Dell', 1, '-', 25, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-RP-MON-02', '2026-08-18 02:02:06'),
(61, 'Epson', 'Printer', 'Epson', 1, 'Epson L360', 25, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-RP-PRN-03', '2026-08-18 02:02:06'),
(62, 'Acer', 'Laptop', 'Acer', 1, 'RAM 8 GB, Intel Core i7-1165G7, Windows 11, Storage 512 GB', 25, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-RP-LTP-01', '2026-08-18 02:02:06'),
(63, 'Brother', 'Printer', 'Brother', 1, 'DCP-L3560CDW', 25, '2025', 'Baik', 'Tersedia', 'ARSIP-L1-RP-PRN-04', '2026-08-18 02:02:06'),
(64, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-8130U, Windows 11 Pro, Storage 256 GB', 25, NULL, 'Rusak Ringan', 'Tersedia', 'ARSIP-L1-RP-PC-05', '2026-08-18 02:02:06'),
(65, 'Polytron', 'Smart TV', 'Polytron', 1, 'PLD55UG599', 25, '2023', 'Baik', 'Tersedia', 'ARSIP-L1-RP-STV-01', '2026-08-18 02:02:06'),
(66, 'Axioo', 'PC', 'Axioo', 1, 'RAM 8 GB, Intel Core i5-1135G7, Windows 11, Storage 256 GB', 25, '2023', 'Baik', 'Tersedia', 'ARSIP-L1-RP-PC-06', '2026-08-18 02:02:06'),
(67, 'Canon', 'Scanner', 'Canon', 1, 'DR-F120', 25, '2023', 'Baik', 'Tersedia', 'ARSIP-L1-RP-SCN-01', '2026-08-18 02:02:06'),
(68, 'TP-Link', 'Switch', 'TP-Link', 1, '8 Port Gigabit', 25, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-RP-SW-01', '2026-08-18 02:02:06'),
(69, 'Axioo', 'PC', 'Axioo', 1, 'RAM 16 GB, Intel Core i5-1155G7, Windows 11 Pro, Storage 512 GB', 26, '2023', 'Baik', 'Tersedia', 'ARSIP-L1-R.LIK-PC-01', '2026-08-18 02:02:06'),
(70, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-2120, Windows 8, Storage 512 GB', 26, '2012', 'Baik', 'Tersedia', 'ARSIP-L1-R.LIK-PC-02', '2026-08-18 02:02:06'),
(71, 'Epson', 'Scanner', 'Epson', 1, 'DS-1630', 26, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-R.LIK-SCN-01', '2026-08-18 02:02:06'),
(72, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-2120, Windows 10 Pro, Storage 512 GB', 26, '2012', 'Baik', 'Tersedia', 'ARSIP-L1-R.LIK-PC-03', '2026-08-18 02:02:06'),
(73, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-2120, Windows 10 Pro, Storage 512 GB', 26, '2012', 'Baik', 'Tersedia', 'ARSIP-L1-R.LIK-PC-04', '2026-08-18 02:02:06'),
(74, 'TP-Link', 'Switch', 'TP-Link', 1, '16 Port Gigabit', 26, '2025', 'Baik', 'Tersedia', 'ARSIP-L1-R.LIK-SW-01', '2026-08-18 02:02:06'),
(75, 'Epson', 'Printer', 'Epson', 1, 'Epson L360', 26, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-R.LIK-PRN-01', '2026-08-18 02:02:06'),
(76, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-8130U, Windows 10 Pro, Storage 1 TB', 26, '2019', 'Baik', 'Tersedia', 'ARSIP-L1-R.LIK-PC-05', '2026-08-18 02:02:06'),
(77, 'Acer', 'PC', 'Acer', 1, 'RAM 8 GB, Intel Core i5-13400, Windows 11, Storage 512 GB', 26, '2025', 'Baik', 'Tersedia', 'ARSIP-L1-R.LIK-PC-06', '2026-08-18 02:02:06'),
(78, 'PowerLogic', 'CPU', 'PowerLogic', 1, 'RAM 4 GB, Intel Pentium, Windows 8, Storage 512 GB', 26, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-R.LIK-CPU-01', '2026-08-18 02:02:06'),
(79, 'PowerLogic', 'CPU', 'PowerLogic', 1, 'RAM 4 GB, Intel Pentium, Windows 8, Storage 512 GB', 26, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-R.LIK-CPU-02', '2026-08-18 02:02:06'),
(80, 'LG', 'Monitor', 'LG', 1, '-', 26, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-R.LIK-MON-01', '2026-08-18 02:02:06'),
(81, 'LG', 'Monitor', 'LG', 1, '-', 26, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-R.LIK-MON-02', '2026-08-18 02:02:06'),
(82, 'PowerLogic', 'CPU', 'PowerLogic', 1, 'RAM 4 GB, Intel Pentium, Windows 8, Storage 512 GB', 26, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-R.LIK-CPU-03', '2026-08-18 02:02:06'),
(83, 'LG', 'Monitor', 'LG', 1, '-', 26, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-R.LIK-MON-03', '2026-08-18 02:02:06'),
(84, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-2120, Windows 8, Storage 512 GB', 27, '2011', 'Baik', 'Tersedia', 'ARSIP-L1-BPBGM-PC-01', '2026-08-18 02:02:06'),
(85, 'Epson', 'Printer', 'Epson', 1, 'Epson L3150', 27, '2020', 'Baik', 'Tersedia', 'ARSIP-L1-BPBGM-PRN-01', '2026-08-18 02:02:06'),
(86, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-4170T, Windows 10 Pro, Storage 256 GB', 27, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-BPBGM-PC-02', '2026-08-18 02:02:06'),
(87, 'Epson', 'Printer', 'Epson', 1, 'Epson L3250', 27, '2023', 'Baik', 'Tersedia', 'ARSIP-L1-BPBGM-PRN-02', '2026-08-18 02:02:06'),
(88, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-2120, Windows 10 Pro, Storage 512 GB', 27, '2011', 'Baik', 'Tersedia', 'ARSIP-L1-BPBGM-PC-03', '2026-08-18 02:02:06'),
(89, 'Epson', 'Scanner', 'Epson', 1, 'DS-1630', 27, '2021', 'Baik', 'Tersedia', 'ARSIP-L1-BPBGM-SCN-01', '2026-08-18 02:02:06'),
(90, 'Acer', 'PC', 'Acer', 1, 'RAM 8 GB, Intel Core i5-1400, Windows 11, Storage 512 GB', 27, '2025', 'Baik', 'Tersedia', 'ARSIP-L1-BPBGM-PC-04', '2026-08-18 02:02:06'),
(91, 'Acer', 'PC', 'Acer', 1, 'RAM 8 GB, Intel Core i5-1400, Windows 11, Storage 512 GB', 27, '2025', 'Baik', 'Tersedia', 'ARSIP-L1-BPBGM-PC-05', '2026-08-18 02:02:06'),
(92, 'Epson', 'Printer', 'Epson', 1, 'Epson L405', 27, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-BPBGM-PRN-03', '2026-08-18 02:02:06'),
(93, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-8130U, Windows 10 Pro, Storage 128 GB', 27, '2019', 'Baik', 'Tersedia', 'ARSIP-L1-BPBGM-PC-06', '2026-08-18 02:02:06'),
(94, 'AP Link', 'Switch', 'AP Link', 1, '24 Port', 27, '2021', 'Baik', 'Tersedia', 'ARSIP-L1-BPBGM-SW-01', '2026-08-18 02:02:06'),
(95, 'Epson', 'Printer', 'Epson', 1, 'Epson L360', 27, NULL, 'Rusak Ringan', 'Tersedia', 'ARSIP-L1-BPBGM-PRN-04', '2026-08-18 02:02:06'),
(96, 'Acer', 'PC', 'Acer', 1, 'RAM 4 GB, Intel Core i3-3227U, Windows 8, Storage 256 GB', 27, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-BPBGM-PC-07', '2026-08-18 02:02:06'),
(97, 'Epson', 'Scanner', 'Epson', 1, 'DS-1630', 27, '2021', 'Baik', 'Tersedia', 'ARSIP-L1-BPBGM-SCN-02', '2026-08-18 02:02:06'),
(98, 'TP-Link', 'Switch', 'TP-Link', 1, '4 Port', 27, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-BPBGM-SW-02', '2026-08-18 02:02:06'),
(99, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Processor belum diketahui, Windows 10 Pro, Storage 128 GB', 27, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-BPBGM-PC-08', '2026-08-18 02:02:06'),
(100, 'Epson', 'Printer', 'Epson', 1, 'Epson L3150', 27, '2019', 'Baik', 'Tersedia', 'ARSIP-L1-BPBGM-PRN-05', '2026-08-18 02:02:06'),
(101, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-8130U, Windows 10 Pro, Storage 128 GB', 27, '2019', 'Baik', 'Tersedia', 'ARSIP-L1-BPBGM-PC-09', '2026-08-18 02:02:06'),
(102, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-8130U, Windows 10 Pro, Storage 128 GB', 27, '2019', 'Baik', 'Tersedia', 'ARSIP-L1-BPBGM-PC-10', '2026-08-18 02:02:06'),
(103, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-8130U, Windows 10 Pro, Storage 128 GB', 27, '2019', 'Baik', 'Tersedia', 'ARSIP-L1-BPBGM-PC-11', '2026-08-18 02:02:06'),
(104, 'Epson', 'Printer', 'Epson', 1, 'Epson L3150', 28, '2020', 'Baik', 'Tersedia', 'ARSIP-L1-KB.BPBGM-PRN-01', '2026-08-18 02:02:06'),
(105, 'Axioo', 'PC', 'Axioo', 1, 'RAM 16 GB, Intel Core i5-1155G7, Windows 11 Pro, Storage 512 GB', 28, '2023', 'Baik', 'Tersedia', 'ARSIP-L1-KB.BPBGM-PC-01', '2026-08-18 02:02:06'),
(106, 'LG', 'Smart TV', 'LG', 1, '43UT801C0SB', 28, '2026', 'Baik', 'Tersedia', 'ARSIP-L1-KB.BPBGM-STV-01', '2026-08-18 02:02:06'),
(107, 'Acer', 'PC', 'Acer', 1, 'RAM 8 GB, Intel Core i5-13400, Windows 11, Storage 512 GB', 37, '2025', 'Baik', 'Tersedia', 'ARSIP-L1-RU-PC-01', '2026-08-18 02:02:06'),
(108, 'Canon', 'Scanner', 'Canon', 1, 'Canon DR-F120', 37, '2025', 'Baik', 'Tersedia', 'ARSIP-L1-RU-SCN-01', '2026-08-18 02:02:06'),
(109, 'Epson', 'Printer', 'Epson', 1, 'Epson L605', 37, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-RU-PRN-01', '2026-08-18 02:02:06'),
(110, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-8130U, Windows 11 Pro, Storage 512 GB', 37, '2019', 'Baik', 'Tersedia', 'ARSIP-L1-RU-PC-02', '2026-08-18 02:02:06'),
(111, 'Epson', 'Printer', 'Epson', 1, 'Epson L3150', 37, '2019', 'Baik', 'Tersedia', 'ARSIP-L1-RU-PRN-02', '2026-08-18 02:02:06'),
(112, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-2120, Windows 10 Pro, Storage 1 TB', 37, '2011', 'Baik', 'Tersedia', 'ARSIP-L1-RU-PC-03', '2026-08-18 02:02:06'),
(113, 'Lenovo', 'PC', 'Lenovo', 1, 'RAM 8 GB, Intel Core i5-8400T, Windows 11 Pro, Storage 256 GB', 37, '2020', 'Baik', 'Tersedia', 'ARSIP-L1-RU-PC-04', '2026-08-18 02:02:06'),
(114, 'Epson', 'Printer', 'Epson', 1, 'Epson L3250', 37, '2022', 'Baik', 'Tersedia', 'ARSIP-L1-RU-PRN-03', '2026-08-18 02:02:06'),
(115, 'Epson', 'Scanner', 'Epson', 1, 'Epson DS-1630', 37, '2025', 'Baik', 'Tersedia', 'ARSIP-L1-RU-SCN-02', '2026-08-18 02:02:06'),
(116, 'LG', 'Monitor', 'LG', 1, '-', 37, '2007', 'Baik', 'Tersedia', 'ARSIP-L1-RU-MON-01', '2026-08-18 02:02:06'),
(117, 'Lenovo', 'CPU', 'Lenovo', 1, 'RAM 4 GB, Intel Core i3-4160, Windows 8, Storage 1 TB', 37, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-RU-CPU-01', '2026-08-18 02:02:06'),
(118, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-8130U, Windows 11, Storage 1 TB', 37, '2019', 'Baik', 'Tersedia', 'ARSIP-L1-RU-PC-05', '2026-08-18 02:02:06'),
(119, 'Epson', 'Printer', 'Epson', 1, 'Epson L405', 37, '2018', 'Baik', 'Tersedia', 'ARSIP-L1-RU-PRN-04', '2026-08-18 02:02:06'),
(120, 'Lenovo', 'Monitor', 'Lenovo', 1, '-', 37, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-RU-MON-02', '2026-08-18 02:02:06'),
(121, 'Lenovo', 'CPU', 'Lenovo', 1, 'RAM 4 GB, Intel Core i3-4160, Windows 10 Pro, Storage 128 GB', 37, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-RU-CPU-02', '2026-08-18 02:02:06'),
(122, 'Epson', 'Printer', 'Epson', 1, 'Epson L3150', 37, '2019', 'Baik', 'Tersedia', 'ARSIP-L1-RU-PRN-05', '2026-08-18 02:02:06'),
(123, 'Lenovo', 'PC', 'Lenovo', 1, 'RAM 8 GB, Intel Core i3-1005G1, Windows 11 Pro, Storage 256 GB', 37, '2021', 'Baik', 'Tersedia', 'ARSIP-L1-RU-PC-06', '2026-08-18 02:02:06'),
(124, 'Canon', 'Scanner', 'Canon', 1, 'Canon DR-F120', 37, '2019', 'Baik', 'Tersedia', 'ARSIP-L1-RU-SCN-03', '2026-08-18 02:02:06'),
(125, 'Epson', 'Printer', 'Epson', 1, 'Epson L3150', 37, '2019', 'Baik', 'Tersedia', 'ARSIP-L1-RU-PRN-06', '2026-08-18 02:02:06'),
(126, 'Axioo', 'PC', 'Axioo', 1, 'RAM 8 GB, Intel Core i5-1135G7, Windows 11 Pro, Storage 256 GB', 37, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-RU-PC-07', '2026-08-18 02:02:06'),
(127, 'Epson', 'Printer', 'Epson', 1, 'Epson L3250', 37, '2021', 'Baik', 'Tersedia', 'ARSIP-L1-RU-PRN-07', '2026-08-18 02:02:06'),
(128, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, AMD E2-9000 Radeon R2, Windows 10 Pro, Storage 256 GB', 37, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-RU-PC-08', '2026-08-18 02:02:06'),
(129, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-8130U, Windows 10 Pro, Storage 1 TB', 37, '2019', 'Baik', 'Tersedia', 'ARSIP-L1-RU-PC-09', '2026-08-18 02:02:06'),
(130, 'TP-Link', 'Switch', 'TP-Link', 1, '4 Port', 37, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-RU-SW-01', '2026-08-18 02:02:06'),
(131, 'TP-Link', 'Switch', 'TP-Link', 1, '8 Port', 37, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-RU-SW-02', '2026-08-18 02:02:06'),
(132, 'D-Link', 'Switch', 'D-Link', 1, '24 Port GB', 37, '2020', 'Baik', 'Tersedia', 'ARSIP-L1-RU-SW-03', '2026-08-18 02:02:06'),
(133, 'Lenovo', 'PC', 'Lenovo', 1, 'RAM 8 GB, Intel Core i3-1005G1, Windows 10 Pro, Storage 1 TB', 38, '2021', 'Baik', 'Tersedia', 'ARSIP-L1-RSEK-PC-01', '2026-08-18 02:02:06'),
(134, 'TP-Link', 'Switch', 'TP-Link', 1, '8 Port', 38, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-RSEK-SW-01', '2026-08-18 02:02:06'),
(135, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-2120, Windows 8, Storage 1 TB', 39, '2011', 'Baik', 'Tersedia', 'ARSIP-L1-RRC-PC-01', '2026-08-18 02:02:06'),
(136, 'Lenovo', 'PC', 'Lenovo', 1, 'RAM 8 GB, Intel Core i5-9400T, Windows 11, Storage 256 GB', 39, '2020', 'Baik', 'Tersedia', 'ARSIP-L1-RRC-PC-02', '2026-08-18 02:02:06'),
(137, 'Acer', 'PC', 'Acer', 1, 'RAM 4 GB, Intel Core i3-3227U, Windows 8, Storage 256 GB', 39, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-RRC-PC-03', '2026-08-18 02:02:06'),
(138, 'Epson', 'Printer', 'Epson', 1, 'Epson L3150', 39, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-RRC-PRN-01', '2026-08-18 02:02:06'),
(139, 'TP-Link', 'Switch', 'TP-Link', 1, '8 Port', 39, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-RRC-SW-01', '2026-08-18 02:02:06'),
(140, 'Tenda', 'Access Point', 'Tenda', 1, '-', 39, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-RRC-AP-01', '2026-08-18 02:02:06'),
(141, 'Lenovo', 'PC', 'Lenovo', 1, 'RAM 8 GB, Intel Core i3-1005G1, Windows 11 Pro, Storage 512 GB', 40, '2021', 'Baik', 'Tersedia', 'ARSIP-L1-RPTM-PC-01', '2026-08-18 02:02:06'),
(142, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i5-4460T, Windows 10 Pro, Storage 256 GB', 40, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-RPTM-PC-02', '2026-08-18 02:02:06'),
(143, 'TP-Link', 'Switch', 'TP-Link', 1, '8 Port', 40, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-RPTM-SW-01', '2026-08-18 02:02:06'),
(144, 'Acer', 'PC', 'Acer', 1, 'RAM 4 GB, Intel Core i3-3227U, Windows 10 Pro, Storage 1 TB', 41, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-PRESIP-PC-01', '2026-08-18 02:02:06'),
(145, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-2120, Windows 10 Pro, Storage 512 GB', 41, '2011', 'Baik', 'Tersedia', 'ARSIP-L1-PRESIP-PC-02', '2026-08-18 02:02:06'),
(146, 'Epson', 'Printer', 'Epson', 1, 'Epson L3150', 41, '2019', 'Baik', 'Tersedia', 'ARSIP-L1-PRESIP-PRN-01', '2026-08-18 02:02:06'),
(147, 'TP-Link', 'Switch', 'TP-Link', 1, '-', 41, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-PRESIP-SW-01', '2026-08-18 02:02:06'),
(148, 'Epson', 'Scanner', 'Epson', 1, 'SureColor T7270D', 41, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-PRESIP-SCN-01', '2026-08-18 02:02:06'),
(149, 'Epson', 'Printer', 'Epson', 1, 'Epson WorkForce WF-7711', 41, '2019', 'Baik', 'Tersedia', 'ARSIP-L1-PRESIP-PRN-02', '2026-08-18 02:02:06'),
(150, 'Acer', 'PC', 'Acer', 1, 'RAM 4 GB, Intel Core i3-3227U, Windows 8, Storage 512 GB', 41, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-PRESIP-PC-03', '2026-08-18 02:02:06'),
(151, 'InFocus', 'Proyektor', 'InFocus', 1, 'InFocus IN114AB', 41, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-PRESIP-PRJ-01', '2026-08-18 02:02:06'),
(152, 'Epson', 'Printer', 'Epson', 1, 'Epson L3210', 41, NULL, 'Baik', 'Tersedia', 'ARSIP-L1-PRESIP-PRN-03', '2026-08-18 02:02:06'),
(153, 'Axioo', 'PC', 'Axioo', 1, 'RAM 16 GB, Intel Core i5-1135G7, Windows 11 Pro, Storage 512 GB', 42, '2023', 'Baik', 'Tersedia', 'ARSIP-L1-RKADIS-PC-01', '2026-08-18 02:02:06'),
(154, 'Epson', 'Printer', 'Epson', 1, 'Epson L3150', 42, '2020', 'Baik', 'Tersedia', 'ARSIP-L1-RKADIS-PRN-01', '2026-08-18 02:02:06'),
(155, 'TOTOLINK', 'Access Point', 'TOTOLINK', 1, '-', 42, '2017', 'Baik', 'Tersedia', 'ARSIP-L1-RKADIS-AP-01', '2026-08-18 02:02:06'),
(156, 'D-Link', 'Switch', 'D-Link', 1, '8 Port GB', 42, '2021', 'Baik', 'Tersedia', 'ARSIP-L1-RKADIS-SW-01', '2026-08-18 02:02:06'),
(157, 'Allos', 'Smart TV', 'Allos', 1, 'Interactive Flat Panel IFP-65', 42, '2026', 'Baik', 'Tersedia', 'ARSIP-L1-RKADIS-STV-01', '2026-08-18 02:02:06'),
(158, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-8130U, Windows 11 Pro, Storage 512 GB', 29, '2019', 'Baik', 'Tersedia', 'ARSIP-L2-R.PAS-PC-01', '2026-08-18 02:02:06'),
(159, 'Canon', 'Scanner', 'Canon', 1, 'DR-F120', 29, NULL, 'Baik', 'Tersedia', 'ARSIP-L2-R.PAS-SCN-01', '2026-08-18 02:02:06'),
(160, 'Tenda', 'Switch', 'Tenda', 1, '8 Port', 29, NULL, 'Baik', 'Tersedia', 'ARSIP-L2-R.PAS-SW-01', '2026-08-18 02:02:06'),
(161, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-2120, Windows 10 Pro, Storage 1 TB', 29, '2011', 'Baik', 'Tersedia', 'ARSIP-L2-R.PAS-PC-02', '2026-08-18 02:02:06'),
(162, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-2120, Windows 10 Pro, Storage 512 GB', 29, '2011', 'Baik', 'Tersedia', 'ARSIP-L2-R.PAS-PC-03', '2026-08-18 02:02:06'),
(163, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-8130U, Windows 8, Storage 1 TB', 29, '2019', 'Baik', 'Tersedia', 'ARSIP-L2-R.PAS-PC-04', '2026-08-18 02:02:06'),
(164, 'Canon', 'Scanner', 'Canon', 1, 'DR-F120', 29, NULL, 'Baik', 'Tersedia', 'ARSIP-L2-R.PAS-SCN-02', '2026-08-18 02:02:06'),
(165, 'Epson', 'Printer', 'Epson', 1, 'Epson L3150', 29, '2019', 'Baik', 'Tersedia', 'ARSIP-L2-R.PAS-PRN-01', '2026-08-18 02:02:06'),
(166, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-3240, Windows 10 Pro, Storage 1 TB', 29, '2013', 'Baik', 'Tersedia', 'ARSIP-L2-R.PAS-PC-05', '2026-08-18 02:02:06'),
(167, 'Acer', 'PC', 'Acer', 1, 'RAM 8 GB, Intel Core i5-14400, Windows 11, Storage 512 GB', 29, '2025', 'Baik', 'Tersedia', 'ARSIP-L2-R.PAS-PC-06', '2026-08-18 02:02:06'),
(168, 'Epson', 'Scanner', 'Epson', 1, 'Epson V850', 29, '2025', 'Baik', 'Tersedia', 'ARSIP-L2-R.PAS-SCN-03', '2026-08-18 02:02:06'),
(169, 'Epson', 'Scanner', 'Epson', 1, 'DS-1630', 29, '2021', 'Baik', 'Tersedia', 'ARSIP-L2-R.PAS-SCN-04', '2026-08-18 02:02:06'),
(170, 'Epson', 'Printer', 'Epson', 1, 'Epson L3150', 29, '2021', 'Baik', 'Tersedia', 'ARSIP-L2-R.PAS-PRN-02', '2026-08-18 02:02:06'),
(171, 'Epson', 'Scanner', 'Epson', 1, 'DS-1630', 29, '2021', 'Baik', 'Tersedia', 'ARSIP-L2-R.PAS-SCN-05', '2026-08-18 02:02:06'),
(172, 'Lenovo', 'PC', 'Lenovo', 1, 'RAM 8 GB, Intel Core i5-9400T, Windows 10 Pro, Storage 256 GB', 29, '2020', 'Baik', 'Tersedia', 'ARSIP-L2-R.PAS-PC-07', '2026-08-18 02:02:06'),
(173, 'Lenovo', 'Printer', 'Lenovo', 1, 'Epson L120', 29, NULL, 'Baik', 'Tersedia', 'ARSIP-L2-R.PAS-PRN-03', '2026-08-18 02:02:06'),
(174, 'Lenovo', 'PC', 'Lenovo', 1, 'RAM 8 GB, Intel Core i3-1005G1, Windows 10 Pro, Storage 256 GB', 29, '2020', 'Baik', 'Tersedia', 'ARSIP-L2-R.PAS-PC-08', '2026-08-18 02:02:06'),
(175, 'Epson', 'Printer', 'Epson', 1, 'Epson L405', 29, NULL, 'Baik', 'Tersedia', 'ARSIP-L2-R.PAS-PRN-04', '2026-08-18 02:02:06'),
(176, 'Epson', 'Printer', 'Epson', 1, 'Epson L3150', 29, '2019', 'Baik', 'Tersedia', 'ARSIP-L2-R.PAS-PRN-05', '2026-08-18 02:02:06'),
(177, 'Axioo', 'PC', 'Axioo', 1, 'RAM 16 GB, Intel Core i5-1155G7, Windows 11 Pro, Storage 512 GB', 30, '2023', 'Baik', 'Tersedia', 'ARSIP-L2-KBPAS-PC-01', '2026-08-18 02:02:06'),
(178, 'Toshiba', 'Smart TV', 'Toshiba', 1, '43L5450', 30, NULL, 'Baik', 'Tersedia', 'ARSIP-L2-KBPAS-STV-01', '2026-08-18 02:02:06'),
(179, 'Samsung', 'Smart TV', 'Samsung', 1, '-', 31, NULL, 'Baik', 'Tersedia', 'ARSIP-L2-KBPPK-STV-01', '2026-08-18 02:02:06'),
(180, 'Acer', 'PC', 'Acer', 1, 'RAM 8 GB, Intel Core i5-14400, Windows 10 Pro, Storage 512 GB', 31, '2025', 'Baik', 'Tersedia', 'ARSIP-L2-KBPPK-PC-01', '2026-08-18 02:02:06'),
(181, 'Lenovo', 'PC', 'Lenovo', 1, 'RAM 8 GB, Intel Core i3-1005G1, Windows 10 Pro, Storage 1 TB', 31, '2021', 'Baik', 'Tersedia', 'ARSIP-L2-KBPPK-PC-02', '2026-08-18 02:02:06'),
(182, 'Epson', 'Printer', 'Epson', 1, 'Epson L405', 32, NULL, 'Baik', 'Tersedia', 'ARSIP-L2-TUPPK-PRN-01', '2026-08-18 02:02:06'),
(183, 'Epson', 'Printer', 'Epson', 1, 'Epson L360', 32, NULL, 'Baik', 'Tersedia', 'ARSIP-L2-TUPPK-PRN-02', '2026-08-18 02:02:06'),
(184, 'HP', 'PC', 'HP', 1, 'RAM 2 GB, Intel Core i3-2120, Windows 10 Pro, Storage 212 GB', 32, '2012', 'Baik', 'Tersedia', 'ARSIP-L2-TUPPK-PC-01', '2026-08-18 02:02:06'),
(185, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-8130U, Windows dan storage (Tidak diketahui/pc di password)', 32, '2019', 'Baik', 'Tersedia', 'ARSIP-L2-TUPPK-PC-02', '2026-08-18 02:02:06'),
(186, 'Epson', 'Printer', 'Epson', 1, 'Epson L3250', 32, '2021', 'Baik', 'Tersedia', 'ARSIP-L2-TUPPK-PRN-03', '2026-08-18 02:02:06'),
(187, 'Epson', 'Scanner', 'Epson', 1, '65402887', 32, NULL, 'Baik', 'Tersedia', 'ARSIP-L2-TUPPK-SCN-01', '2026-08-18 02:02:06'),
(188, 'TP-Link', 'Switch', 'TP-Link', 1, '8 Port', 32, NULL, 'Baik', 'Tersedia', 'ARSIP-L2-TUPPK-SW-01', '2026-08-18 02:02:06'),
(189, 'Canon', 'Printer', 'Canon', 1, 'Tidak digunakan / spesifikasi tidak diketahui', 32, '2020', 'Rusak Berat', 'Tersedia', 'ARSIP-L2-TUPPK-PRNCARD-01', '2026-08-18 02:02:06'),
(190, 'Acer', 'CPU', 'Acer', 1, 'Tidak digunakan / spesifikasi tidak diketahui', 32, NULL, 'Rusak Berat', 'Tersedia', 'ARSIP-L2-TUPPK-CPU-01', '2026-08-18 02:02:06'),
(191, 'HP', 'PC', 'HP', 1, 'Tidak digunakan / spesifikasi tidak diketahui', 32, '2012', 'Rusak Berat', 'Tersedia', 'ARSIP-L2-TUPPK-PC-03', '2026-08-18 02:02:06'),
(192, 'HP', 'PC', 'HP', 1, 'Tidak digunakan / spesifikasi tidak diketahui', 32, '2012', 'Rusak Berat', 'Tersedia', 'ARSIP-L2-TUPPK-PC-04', '2026-08-18 02:02:06'),
(193, 'D-Link', 'Switch', 'D-Link', 1, '16 port', 33, '2015', 'Baik', 'Tersedia', 'ARSIP-L2-RED-SW-01', '2026-08-18 02:02:06'),
(194, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-8130U, Windows 11 Pro, Storage 512 GB', 33, '2019', 'Baik', 'Tersedia', 'ARSIP-L2-RED-PC-01', '2026-08-18 02:02:06'),
(195, 'Epson', 'Printer', 'Epson', 1, 'Epson L365', 33, '2015', 'Baik', 'Tersedia', 'ARSIP-L2-RED-PRN-01', '2026-08-18 02:02:06'),
(196, 'Axioo', 'PC', 'Axioo', 1, 'RAM 16 GB, Intel Core i5-1155G7, Windows 11 Pro, Storage 512 GB', 33, '2023', 'Baik', 'Tersedia', 'ARSIP-L2-RED-PC-02', '2026-08-18 02:02:06'),
(197, 'Epson', 'Printer', 'Epson', 1, 'Epson L365', 33, '2015', 'Baik', 'Tersedia', 'ARSIP-L2-RED-PRN-02', '2026-08-18 02:02:06'),
(198, 'Acer', 'PC', 'Acer', 1, 'RAM 4 GB, Intel Core i3-3240, Windows 10 Pro, Storage 1 TB', 33, '2013', 'Baik', 'Tersedia', 'ARSIP-L2-RED-PC-03', '2026-08-18 02:02:06'),
(199, 'Scanner', 'Scanner', 'Scanner', 1, 'Epson DS-1630', 33, '2022', 'Baik', 'Tersedia', 'ARSIP-L2-RED-SCN-01', '2026-08-18 02:02:06'),
(200, 'D-Link', 'Switch', 'D-Link', 1, '8 Port GB', 33, '2021', 'Baik', 'Tersedia', 'ARSIP-L2-RED-SW-02', '2026-08-18 02:02:06'),
(201, 'Acer', 'Laptop', 'Acer', 1, 'RAM 8 GB, Intel Core i7-1165G7, Windows 11 Pro, Storage 512', 33, NULL, 'Baik', 'Tersedia', 'ARSIP-L2-RED-LTP-01', '2026-08-18 02:02:06'),
(202, 'Lenovo', 'CPU', 'Lenovo', 1, '4 GB, Intel Core i5-8400, Windows 10 Pro, Storage 1 TB', 33, '2019', 'Baik', 'Tersedia', 'ARSIP-L2-RED-CPU-01', '2026-08-18 02:02:06'),
(203, 'Lenovo', 'Monitor', 'Lenovo', 1, '-', 33, '2019', 'Baik', 'Tersedia', 'ARSIP-L2-RED-MON-01', '2026-08-18 02:02:06'),
(204, 'D-Link', 'Switch', 'D-Link', 1, '8 Port GB', 33, '2016', 'Baik', 'Tersedia', 'ARSIP-L2-RED-SW-03', '2026-08-18 02:02:06'),
(205, 'Epson', 'Printer', 'Epson', 1, 'Epson L3150', 33, NULL, 'Baik', 'Tersedia', 'ARSIP-L2-RED-PRN-03', '2026-08-18 02:02:06'),
(206, 'HP', 'PC', 'HP', 1, '-', 34, '2011', 'Baik', 'Tersedia', 'ARSIP-L2-RPAD-PC-01', '2026-08-18 02:02:06'),
(207, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-8130U, Windows 10 Pro, Storage 128 GB', 34, '2019', 'Baik', 'Tersedia', 'ARSIP-L2-RPAD-PC-02', '2026-08-18 02:02:06'),
(208, 'TP-Link', 'Switch', 'TP-Link', 1, '8 Port', 34, NULL, 'Baik', 'Tersedia', 'ARSIP-L2-RPAD-SW-02', '2026-08-18 02:02:06'),
(209, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-3227U, Windows 10 Pro, Storage 128 GB', 34, '2021', 'Baik', 'Tersedia', 'ARSIP-L2-RPAD-PC-03', '2026-08-18 02:02:06'),
(210, 'Epson', 'Printer', 'Epson', 1, 'Epson L3250', 34, '2021', 'Baik', 'Tersedia', 'ARSIP-L2-RPAD-PRN-01', '2026-08-18 02:02:06'),
(211, 'Epson', 'Scanner', 'Epson', 1, 'Epson DS-3550', 34, '2021', 'Baik', 'Tersedia', 'ARSIP-L2-RPAD-SCN-01', '2026-08-18 02:02:06'),
(212, 'Epson', 'Printer', 'Epson', 1, 'Epson L3250', 34, '2023', 'Baik', 'Tersedia', 'ARSIP-L2-RPAD-PRN-02', '2026-08-18 02:02:06'),
(213, 'Canon', 'Scanner', 'Canon', 1, 'Canon DR-C4120', 34, NULL, 'Baik', 'Tersedia', 'ARSIP-L2-RPAD-SCN-02', '2026-08-18 02:02:06'),
(214, 'Epson', 'Printer', 'Epson', 1, 'Epson L360', 34, NULL, 'Baik', 'Tersedia', 'ARSIP-L2-RPAD-PRN-03', '2026-08-18 02:02:06'),
(215, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-2120, Windows 10 Pro, Storage 512 GB', 34, '2012', 'Baik', 'Tersedia', 'ARSIP-L2-RPAD-PC-04', '2026-08-18 02:02:06'),
(216, 'HP', 'PC', 'HP', 1, 'Epson L360', 34, NULL, 'Baik', 'Tersedia', 'ARSIP-L2-RPAD-PRN-04', '2026-08-18 02:02:06'),
(217, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-8130U, Windows 10 Pro, Storage 1 TB', 34, '2019', 'Baik', 'Tersedia', 'ARSIP-L2-RPAD-PC-05', '2026-08-18 02:02:06'),
(218, 'TP-Link', 'Switch', 'TP-Link', 1, '8 Port', 34, NULL, 'Baik', 'Tersedia', 'ARSIP-L2-RPAD-SW-03', '2026-08-18 02:02:06'),
(219, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-8130U, Windows 11 Pro, Storage 1 TB', 34, '2019', 'Baik', 'Tersedia', 'ARSIP-L2-RPAD-PC-06', '2026-08-18 02:02:06'),
(220, 'Epson', 'Printer', 'Epson', 1, 'Epson L3250', 34, '2023', 'Baik', 'Tersedia', 'ARSIP-L2-RPAD-PRN-05', '2026-08-18 02:02:06'),
(221, 'Epson', 'Proyektor', 'Epson', 1, 'Bmst604E1236', 34, NULL, 'Baik', 'Tersedia', 'ARSIP-L2-RPAD-PRJ-01', '2026-08-18 02:02:06'),
(222, 'HP', 'PC', 'HP', 1, 'RAM 8 GB, Intel Core i3-2120, Windows 10 Pro, Storage 1 TB', 34, '2012', 'Baik', 'Tersedia', 'ARSIP-L2-RPAD-PC-07', '2026-08-18 02:02:06'),
(223, 'HP', 'PC', 'HP', 1, 'RAM 8 GB, Intel Core i3-2120, Windows 10 Pro, Storage 1 TB', 34, '2012', 'Baik', 'Tersedia', 'ARSIP-L2-RPAD-PC-08', '2026-08-18 02:02:06'),
(224, 'TP-Link', 'Switch', 'TP-Link', 1, '8 Port', 34, NULL, 'Baik', 'Tersedia', 'ARSIP-L2-RPAD-SW-04', '2026-08-18 02:02:06'),
(225, 'Acer', 'PC', 'Acer', 1, 'RAM 8 GB, Intel Core i5-14400, Windows 11 Pro, Storage 512 GB', 35, '2025', 'Baik', 'Tersedia', 'ARSIP-L2-KBPAD-PC-01', '2026-08-18 02:02:06'),
(226, 'Epson', 'Printer', 'Epson', 1, 'Epson L3250', 35, '2022', 'Baik', 'Tersedia', 'ARSIP-L2-KBPAD-PRN-01', '2026-08-18 02:02:06'),
(227, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-2120, Windows 10, Storage 1 TB', 36, '2012', 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-PC-01', '2026-08-18 02:02:06'),
(228, 'HP', 'Printer', 'HP', 1, 'LaserJet Pro MPP M125a (Rusak tinta hitam gak keluar)', 36, NULL, 'Rusak Ringan', 'Tersedia', 'ARSIP-L2-BIDEP-PRN-01', '2026-08-18 02:02:06'),
(229, 'HP', 'PC', 'HP', 1, 'RAM 8 GB, Intel Core i7 (Gen 3), Storage 256 GB', 36, '2018', 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-PC-02', '2026-08-18 02:02:06'),
(230, 'Lenovo', 'Monitor', 'Lenovo', 1, 'Gen 4, RAM 4 GB, SSD 500 GB, Storage 1 TB', 36, NULL, 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-MON-01', '2026-08-18 02:02:06'),
(231, 'Lenovo', 'Monitor', 'Lenovo', 1, '-', 36, NULL, 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-MON-02', '2026-08-18 02:02:06'),
(232, 'Lenovo', 'CPU', 'Lenovo', 1, '-', 36, NULL, 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-CPU-01', '2026-08-18 02:02:06'),
(233, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-7100U, Windows 10 Pro, Storage 512 GB', 36, '2018', 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-PC-03', '2026-08-18 02:02:06'),
(234, 'Epson', 'Printer', 'Epson', 1, 'Epson L360', 36, '2018', 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-PRN-02', '2026-08-18 02:02:06'),
(235, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-2120, Windows 8.1 Pro, Storage 1 TB', 36, '2012', 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-PC-04', '2026-08-18 02:02:06'),
(236, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-2120, Windows 10 Pro, Storage 256 GB', 36, '2012', 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-PC-05', '2026-08-18 02:02:06'),
(237, 'Canon', 'Scanner', 'Canon', 1, 'DR-F120', 36, '2023', 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-SCN-01', '2026-08-18 02:02:06'),
(238, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-8130U, Windows 10 Pro, Storage 1 TB', 36, '2019', 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-PC-06', '2026-08-18 02:02:06'),
(239, 'Epson', 'Printer', 'Epson', 1, 'Epson L360', 36, '2019', 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-PRN-03', '2026-08-18 02:02:06'),
(240, 'Canon', 'Scanner', 'Canon', 1, 'Canon M111221', 36, '2023', 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-SCN-02', '2026-08-18 02:02:06'),
(241, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-2120, Windows 10 Pro, Storage 256 GB', 36, '2012', 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-PC-07', '2026-08-18 02:02:06'),
(242, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-2120, Windows 10 Pro, Storage 256 GB', 36, '2012', 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-PC-08', '2026-08-18 02:02:06'),
(243, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-8108, Windows 10 Pro, Storage 256 GB', 36, '2012', 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-PC-09', '2026-08-18 02:02:06'),
(244, 'Epson', 'Printer', 'Epson', 1, 'Epson TMC350(001)', 36, NULL, 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-PRNLB-01', '2026-08-18 02:02:06'),
(245, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-8108, Windows 10 Pro, Storage 256 GB', 36, '2019', 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-PC-10', '2026-08-18 02:02:06'),
(246, 'Epson', 'Printer', 'Epson', 1, 'Epson L405', 36, '2019', 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-PRN-04', '2026-08-18 02:02:06'),
(247, 'HP', 'PC', 'HP', 1, 'RAM 8 GB, Intel Core i3-1005G1, Windows 10 Pro, Storage 256 GB', 36, '2021', 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-PC-11', '2026-08-18 02:02:06'),
(248, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-7100U, Windows 10 Pro, Storage 256 GB', 36, '2018', 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-PC-12', '2026-08-18 02:02:06'),
(249, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-2120, Windows 10 Pro, Storage 256 GB', 36, '2012', 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-PC-13', '2026-08-18 02:02:06'),
(250, 'Epson', 'Printer', 'Epson', 1, 'Epson L3250', 36, '2024', 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-PRN-05', '2026-08-18 02:02:06'),
(251, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-8130U, Windows 11', 36, '2019', 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-PC-14', '2026-08-18 02:02:06'),
(252, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-2120, Windows 8.1 Pro, Storage 1 TB', 36, NULL, 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-PC-15', '2026-08-18 02:02:06'),
(253, 'D-Link', 'Switch', 'D-Link', 1, '16 Port GB', 36, '2025', 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-SW-01', '2026-08-18 02:02:06'),
(254, 'Acer', 'PC', 'Acer', 1, 'RAM 8 GB, Intel Core i5-14400, Windows 11, Storage 512 GB', 36, '2025', 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-PC-16', '2026-08-18 02:02:06'),
(255, 'Epson', 'Printer', 'Epson', 1, 'Epson LX350', 36, NULL, 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-PRN-06', '2026-08-18 02:02:06'),
(256, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-8130U, Windows 11, Storage 512 GB', 36, NULL, 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-PC-17', '2026-08-18 02:02:06'),
(257, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-2120, Windows 8.1 Pro, Storage 1 TB', 36, NULL, 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-PC-18', '2026-08-18 02:02:06'),
(258, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-7100U, Windows 10 Pro, Storage 512 GB', 36, '2012', 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-PC-19', '2026-08-18 02:02:06'),
(259, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-7100U, Windows 10 Pro, Storage 512 GB', 36, '2019', 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-PC-20', '2026-08-18 02:02:06'),
(260, 'Epson', 'Scanner', 'Epson', 1, 'Epson DS-1630', 36, '2021', 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-SCN-03', '2026-08-18 02:02:06'),
(261, 'Epson', 'Printer', 'Epson', 1, 'Epson TM-C3510', 36, '2019', 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-PRNLB-02', '2026-08-18 02:02:06'),
(262, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-2120, Windows 10 Pro, Storage 512 GB', 36, '2012', 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-PC-21', '2026-08-18 02:02:06'),
(263, 'Epson', 'Printer', 'Epson', 1, 'Epson L3250', 36, '2023', 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-PRN-07', '2026-08-18 02:02:06'),
(264, 'TP-Link', 'Switch', 'TP-Link', 1, '8 Port', 36, NULL, 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-SW-02', '2026-08-18 02:02:06'),
(265, 'Acer', 'PC', 'Acer', 1, 'RAM 8 GB, Intel Core i5-14400, Windows 11, Storage 512 GB', 36, '2025', 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-PC-22', '2026-08-18 02:02:06'),
(266, 'Epson', 'Printer', 'Epson', 1, 'Epson L3250', 36, '2025', 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-PRN-08', '2026-08-18 02:02:06'),
(267, 'Axioo', 'PC', 'Axioo', 1, 'RAM 8 GB, Intel Core i5-1135G7, Windows 11 Pro, Storage 512 GB (Milik PHUSAKA - Disimpan di BIDEP)', 36, '2023', 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-PC-23', '2026-08-18 02:02:06'),
(268, 'Samsung', 'Smart TV', 'Samsung', 1, 'UA48H6400AW', 36, NULL, 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-STV-01', '2026-08-18 02:02:06'),
(269, 'D-Link', 'Switch', 'D-Link', 1, '8 Port', 36, NULL, 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-SW-03', '2026-08-18 02:02:06'),
(270, 'Dell', 'Monitor', 'Dell', 1, '-', 36, NULL, 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-MON-03', '2026-08-18 02:02:06'),
(271, 'Lenovo', 'CPU', 'Lenovo', 1, 'RAM 8 GB, Intel Core i3-4000M, Windows 10 Pro, Storage 256 GB', 36, NULL, 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-CPU-02', '2026-08-18 02:02:06'),
(272, 'Toshiba', 'Smart TV', 'Toshiba', 1, '219001690041PJ1', 36, NULL, 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-STV-02', '2026-08-18 02:02:06'),
(273, 'Axioo', 'PC', 'Axioo', 1, 'RAM 16 GB, Intel Core i5-1155G7, Windows 11 Pro, Storage 512 GB', 36, '2023', 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-PC-24', '2026-08-18 02:02:06'),
(274, 'Epson', 'Printer', 'Epson', 1, 'Epson L3250', 36, '2023', 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-PRN-09', '2026-08-18 02:02:06'),
(275, 'Canon', 'Scanner', 'Canon', 1, 'Canon DR-F120', 36, '2023', 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-SCN-04', '2026-08-18 02:02:06'),
(276, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-8130U, Windows 11 Pro, Storage 512 GB', 36, '2017', 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-PC-25', '2026-08-18 02:02:06'),
(277, 'Epson', 'Printer', 'Epson', 1, 'Epson L3150', 36, '2020', 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-PRN-10', '2026-08-18 02:02:06'),
(278, 'D-Link', 'Switch', 'D-Link', 1, '8 Port', 36, NULL, 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-SW-04', '2026-08-18 02:02:06'),
(279, 'Lenovo', 'PC', 'Lenovo', 1, 'RAM 8 GB, Intel Core i5-9400T, Windows 11 Pro, Storage 512 GB', 36, '2020', 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-PC-26', '2026-08-18 02:02:06'),
(280, 'D-Link', 'Switch', 'D-Link', 1, '24 Port GB', 36, '2021', 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-SW-05', '2026-08-18 02:02:06'),
(281, 'TP-Link', 'Switch', 'TP-Link', 1, '8 Port', 36, NULL, 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-SW-06', '2026-08-18 02:02:06'),
(282, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-8130U, Windows 11 Pro, Storage 128 GB', 36, '2019', 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-PC-27', '2026-08-18 02:02:06'),
(283, 'CZUR', 'Scanner', 'CZUR', 1, 'CZUR Scanner', 36, NULL, 'Baik', 'Tersedia', 'ARSIP-L2-BIDEP-SCN-05', '2026-08-18 02:02:06'),
(284, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-7100U, Windows 10 Pro, Storage 512 GB', 43, '2012', 'Baik', 'Tersedia', 'ARSIP-L3-RGAS-PC-01', '2026-08-18 22:22:21'),
(285, 'TP-Link', 'Switch', 'TP-Link', 1, '8 Port', 43, '0000', 'Baik', 'Tersedia', 'ARSIP-L3-RGAS-SW-01', '2026-08-18 22:22:21'),
(286, 'Ubiquiti', 'Access Point', 'Ubiquiti', 1, NULL, 43, '2023', 'Baik', 'Tersedia', 'ARSIP-L3-RGAS-AP-01', '2026-08-18 22:22:21'),
(287, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-2120, Windows 8, Storage 512 GB', 43, '2011', 'Baik', 'Tersedia', 'ARSIP-L3-RGAS-PC-02', '2026-08-18 22:22:21'),
(288, 'Lenovo', 'Monitor', 'Lenovo', 1, NULL, 43, '0000', 'Baik', 'Tersedia', 'ARSIP-L3-RGAS-MON-01', '2026-08-18 22:22:21'),
(289, 'Lenovo', 'CPU', 'Lenovo', 1, 'RAM 4 GB, Intel Core i3-4160, Windows 8, Storage 1 TB', 43, '0000', 'Baik', 'Tersedia', 'ARSIP-L3-RGAS-CPU-01', '2026-08-18 22:22:21'),
(290, 'Lenovo', 'Monitor', 'Lenovo', 1, NULL, 43, '0000', 'Baik', 'Tersedia', 'ARSIP-L3-RGAS-MON-02', '2026-08-18 22:22:21'),
(291, 'Lenovo', 'CPU', 'Lenovo', 1, 'RAM 4 GB, Intel Core i3-4160, Windows 8, Storage 1 TB', 43, '0000', 'Baik', 'Tersedia', 'ARSIP-L3-RGAS-CPU-02', '2026-08-18 22:22:21'),
(292, 'Acer', 'PC', 'Acer', 1, 'RAM 4 GB, Intel Core i3-3227U, Windows 8, Storage 512 GB', 43, '0000', 'Baik', 'Tersedia', 'ARSIP-L3-RGAS-PC-03', '2026-08-18 22:22:21'),
(293, 'Lenovo', 'Monitor', 'Lenovo', 1, NULL, 44, '0000', 'Baik', 'Tersedia', 'ARSIP-L4-RPSTS-MON-01', '2026-08-18 22:22:21'),
(294, 'Lenovo', 'CPU', 'Lenovo', 1, 'RAM 6 GB, Intel Core i3-4160, Windows 10 Pro, Storage 1 TB', 44, '0000', 'Baik', 'Tersedia', 'ARSIP-L4-RPSTS-CPU-01', '2026-08-18 22:22:21'),
(295, 'Canon', 'Scanner', 'Canon', 1, 'Canon DR-F120', 44, '2023', 'Baik', 'Tersedia', 'ARSIP-L4-RPSTS-SCN-01', '2026-08-18 22:22:21'),
(296, 'Lenovo', 'Monitor', 'Lenovo', 1, NULL, 44, '0000', 'Baik', 'Tersedia', 'ARSIP-L4-RPSTS-MON-02', '2026-08-18 22:22:21'),
(297, 'Lenovo', 'CPU', 'Lenovo', 1, 'RAM 4 GB, Intel Core i3-4160, Windows 7, Storage 1 TB', 44, '0000', 'Baik', 'Tersedia', 'ARSIP-L4-RPSTS-CPU-02', '2026-08-18 22:22:21'),
(298, 'HP', 'Printer Laser', 'HP', 1, NULL, 44, '0000', 'Baik', 'Tersedia', 'ARSIP-L4-RPSTS-PRNLSR-01', '2026-08-18 22:22:21'),
(299, 'Acer', 'PC', 'Acer', 1, 'RAM 4 GB, Intel Core i3-3227U, Windows 10 Pro, Storage 1 TB', 44, '0000', 'Baik', 'Tersedia', 'ARSIP-L4-RPSTS-PC-01', '2026-08-18 22:22:21'),
(300, 'Tenda', 'Switch', 'Tenda', 1, NULL, 44, '0000', 'Baik', 'Tersedia', 'ARSIP-L4-RPSTS-SW-01', '2026-08-18 22:22:21'),
(301, 'D-Link', 'Switch', 'D-Link', 1, NULL, 45, '0000', 'Baik', 'Tersedia', 'ARSIP-L4-RGAS4-SW-01', '2026-08-18 22:22:21'),
(302, 'Acer', 'Monitor', 'Acer', 1, NULL, 45, '0000', 'Baik', 'Tersedia', 'ARSIP-L4-RGAS4-MON-01', '2026-08-18 22:22:21'),
(303, 'HP', 'CPU', 'HP', 1, 'RAM 16 GB, Intel Core i7-6700, Windows 8, Storage 1 TB', 45, '0000', 'Baik', 'Tersedia', 'ARSIP-L4-RGAS4-CPU-01', '2026-08-18 22:22:21'),
(304, 'Epson', 'Scanner', 'Epson', 1, 'Epson GT-1500', 45, '0000', 'Baik', 'Tersedia', 'ARSIP-L4-RGAS4-SCN-01', '2026-08-18 22:22:21'),
(305, 'Lenovo', 'PC', 'Lenovo', 1, 'RAM 8 GB, Intel Core i5-9400T, Windows 11 Pro, Storage 1 TB', 45, '2020', 'Baik', 'Tersedia', 'ARSIP-L4-RGAS4-PC-01', '2026-08-18 22:22:21'),
(306, 'Epson', 'Printer', 'Epson', 1, 'Epson L350', 45, '2022', 'Baik', 'Tersedia', 'ARSIP-L4-RGAS4-PRN-01', '2026-08-18 22:22:21'),
(307, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-8130U, Windows 11 Pro, Storage 512 GB', 45, '0000', 'Baik', 'Tersedia', 'ARSIP-L4-RGAS4-PC-02', '2026-08-18 22:22:21'),
(308, 'Lenovo', 'PC', 'Lenovo', 1, 'RAM 8 GB, Intel Core i5-9400T, Windows 11, Storage 256 GB', 46, '2020', 'Baik', 'Tersedia', 'ARSIP-L4-DEPOB-PC-01', '2026-08-18 22:22:21'),
(309, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-8130U, Windows 10 Pro, Storage 1 TB', 46, '2019', 'Baik', 'Tersedia', 'ARSIP-L4-DEPOB-PC-02', '2026-08-18 22:22:21'),
(310, 'Epson', 'Printer', 'Epson', 1, 'Epson L3250', 46, '2022', 'Baik', 'Tersedia', 'ARSIP-L4-DEPOB-PRN-01', '2026-08-18 22:22:21'),
(311, 'Tenda', 'Switch', 'Tenda', 1, NULL, 46, '0000', 'Baik', 'Tersedia', 'ARSIP-L4-DEPOB-SW-01', '2026-08-18 22:22:21'),
(312, 'Epson', 'Scanner', 'Epson', 1, 'Epson DS-410', 46, '2024', 'Baik', 'Tersedia', 'ARSIP-L4-DEPOB-SCN-01', '2026-08-18 22:22:21'),
(313, 'Epson', 'Printer', 'Epson', 1, 'Epson L3150', 46, '2020', 'Baik', 'Tersedia', 'ARSIP-L4-DEPOB-PRN-02', '2026-08-18 22:22:21'),
(314, 'Acer', 'PC', 'Acer', 1, 'RAM 8 GB, Intel Core i5-14400, Windows 10 Pro, Storage 512 GB', 46, '2024', 'Baik', 'Tersedia', 'ARSIP-L4-DEPOB-PC-03', '2026-08-18 22:22:21'),
(315, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-2120, Windows 10 Pro, Storage 1 TB', 46, '2012', 'Baik', 'Tersedia', 'ARSIP-L4-DEPOB-PC-04', '2026-08-18 22:22:21'),
(316, 'Ubiquiti', 'Access Point', 'Ubiquiti', 1, NULL, 46, '2012', 'Baik', 'Tersedia', 'ARSIP-L4-DEPOB-AP-01', '2026-08-18 22:22:21'),
(317, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-4170T, Windows 10, Storage 128 GB', 46, '0000', 'Baik', 'Tersedia', 'ARSIP-L4-DEPOB-PC-05', '2026-08-18 22:22:21'),
(318, 'Acer', 'PC', 'Acer', 1, 'RAM 8 GB, Intel Core i3-3227U, Windows 8, Storage 256 GB', 46, '0000', 'Baik', 'Tersedia', 'ARSIP-L4-DEPOB-PC-06', '2026-08-18 22:22:21'),
(319, 'TP-Link', 'Switch', 'TP-Link', 1, NULL, 46, '0000', 'Baik', 'Tersedia', 'ARSIP-L4-DEPOB-SW-02', '2026-08-18 22:22:21'),
(320, 'TP-Link', 'Switch', 'TP-Link', 1, '8 Port', 47, '0000', 'Baik', 'Tersedia', 'ARSIP-L5-RPAI-SW-01', '2026-08-18 22:22:21'),
(321, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Prosesor Intel Core i3-2120, Windows 8.1 Pro, Storage 1 TB', 48, '2012', 'Baik', 'Tersedia', 'ARSIP-L5-DEPOB-PC-01', '2026-08-18 22:22:21'),
(322, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Prosesor Intel Core i3-2120, Windows 7, Storage 512 GB', 48, '2012', 'Baik', 'Tersedia', 'ARSIP-L5-DEPOB-PC-02', '2026-08-18 22:22:21'),
(323, 'D-Link', 'Switch', 'D-Link', 1, '-', 48, '0000', 'Baik', 'Tersedia', 'ARSIP-L5-DEPOB-SW-01', '2026-08-18 22:22:21'),
(324, 'Ubiquiti', 'Access Point', 'Ubiquiti', 1, '-', 48, '2021', 'Baik', 'Tersedia', 'ARSIP-L5-DEPOB-AP-01', '2026-08-18 22:22:21'),
(325, 'D-Link', 'Switch', 'D-Link', 1, '-', 49, '0000', 'Baik', 'Tersedia', 'ARSIP-L6-RPAI6-SW-01', '2026-08-18 22:22:21'),
(326, 'Acer', 'PC', 'Acer', 1, 'RAM 8 GB, Storage 512 GB, Intel Core i5-14400, Windows 11', 49, '2025', 'Baik', 'Tersedia', 'ARSIP-L6-RPAI6-PC-01', '2026-08-18 22:22:21'),
(327, 'Acer', 'PC', 'Acer', 1, 'RAM 4 GB, Storage 1 TB, Intel Core i3-3227U, Windows 10', 49, '0000', 'Baik', 'Tersedia', 'ARSIP-L6-RPAI6-PC-02', '2026-08-18 22:22:21'),
(328, 'Epson', 'Printer', 'Epson', 1, 'Epson L3150', 49, '2019', 'Baik', 'Tersedia', 'ARSIP-L6-RPAI6-PRN-01', '2026-08-18 22:22:21'),
(329, 'Ubiquiti', 'Access Point', 'Ubiquiti', 1, 'Dual Band 2.4 GHz + 5 GHz', 49, '2017', 'Baik', 'Tersedia', 'ARSIP-L6-RPAI6-AP-01', '2026-08-18 22:22:21'),
(330, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Storage 512 GB, Intel Core i3-2120, Windows 7', 50, '0000', 'Baik', 'Tersedia', 'ARSIP-L7-RLTJB-PC-01', '2026-08-18 22:22:21'),
(331, 'D-Link', 'Switch', 'D-Link', 1, '8 Port Gigabit', 50, '0000', 'Baik', 'Tersedia', 'ARSIP-L7-RLTJB-SW-01', '2026-08-18 22:22:21'),
(332, 'Wearnes', 'CPU', 'Wearnes', 1, '-', 50, '2007', 'Baik', 'Tersedia', 'ARSIP-L7-RLTJB-CPU-01', '2026-08-18 22:22:21'),
(333, 'D-Link', 'Switch', 'D-Link', 1, '8 Port', 50, '0000', 'Baik', 'Tersedia', 'ARSIP-L7-RLTJB-SW-02', '2026-08-18 22:22:21'),
(334, 'TP-Link', 'Access Point', 'TP-Link', 1, '-', 50, '0000', 'Baik', 'Tersedia', 'ARSIP-L7-RLTJB-AP-01', '2026-08-18 22:46:38'),
(335, '3M', 'SCNRF (Scanner RF)', '3', 1, '-', 1, '2013', 'Baik', 'Tersedia', 'PER-L1-RAK-SCNRF-01', '2026-08-18 22:49:38'),
(336, 'HP', 'PC', 'HP', 1, 'RAM 2 GB, Intel Core i3-2120, Windows 8, Storage 512 GB', 1, '2012', 'Baik', 'Tersedia', 'PER-L1-RAK-PC-01', '2026-08-18 22:49:38'),
(337, 'HP', 'PC', 'HP', 1, 'RAM 2 GB, Intel Core i3-2120, Windows 10, Storage 256 GB', 1, '2012', 'Baik', 'Tersedia', 'PER-L1-RAK-PC-02', '2026-08-18 22:49:38'),
(338, 'Kassen', 'Scanner QR', 'Kassen', 1, 'RS-720B', 1, '2025', 'Baik', 'Tersedia', 'PER-L1-RAK-SCNQR-01', '2026-08-18 22:49:38');
INSERT INTO `inventaris` (`id`, `nama_hardware`, `kategori`, `merk`, `jumlah`, `spesifikasi`, `ruangan_id`, `tahun_pengadaan`, `kondisi`, `status`, `kode_aset`, `created_at`) VALUES
(339, 'Eppson', 'Printer', 'Eppson', 1, 'Epson M188B', 1, '2013', 'Baik', 'Tersedia', 'PER-L1-RAK-PRN-01', '2026-08-18 22:49:38'),
(340, 'TP Link', 'Switch', 'TP Link', 1, 'Switch 8-Port; Port: 8 Port', 1, '2017', 'Baik', 'Tersedia', 'PER-L1-RAK-SW-01', '2026-08-18 22:49:38'),
(341, 'Tenda', 'Access Point', 'Tenda', 1, 'Frekuensi 2,4 GHz, Tenda_863F68', 1, '2020', 'Baik', 'Tersedia', 'PER-L1-RAK-AP-01', '2026-08-18 22:49:38'),
(342, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-2120, Windows 8.1 Pro, Storage 512 GB', 1, '2012', 'Baik', 'Tersedia', 'PER-L1-RAK-PC-03', '2026-08-18 22:49:38'),
(343, 'VSC', 'Scanner QR', 'VSC', 1, 'VSC BS-895A', 1, '2023', 'Baik', 'Tersedia', 'PER-L1-RAK-SCNQR-02', '2026-08-18 22:49:38'),
(344, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-2120, Windows 8, Storage 256 GB', 2, '2012', 'Baik', 'Tersedia', 'PER-L1-TP-PC-01', '2026-08-18 22:49:38'),
(345, 'Kassen', 'Scanner QR', 'Kassen', 1, 'RS-720B', 2, '2025', 'Baik', 'Tersedia', 'PER-L1-TP-SCNQR-01', '2026-08-18 22:49:38'),
(346, 'Epson', 'Printer', 'Epson', 1, 'Epson TM-L120 Receipt', 2, '2013', 'Baik', 'Tersedia', 'PER-L1-TP-PRN-01', '2026-08-18 22:49:38'),
(347, '3M', 'Scanner RF', '3M', 1, '-', 2, '2013', 'Baik', 'Tersedia', 'PER-L1-TP-SCNRF-01', '2026-08-18 22:49:38'),
(348, 'Lenovo', 'CPU', 'Lenovo', 1, 'RAM 4 GB, Intel Core i3-4160, Windows 8, Storage 256 GB', 3, '2012', 'Baik', 'Tersedia', 'PER-L1-REG-CPU-01', '2026-08-18 22:49:38'),
(349, 'Elo', 'Monitor', 'Elo', 1, '-', 3, '2012', 'Baik', 'Tersedia', 'PER-L1-REG-MON-01', '2026-08-18 22:49:38'),
(350, 'Intel i3', 'CPU', 'Intel i3', 1, 'RAM 4 GB, Intel Core i3-4130, Windows 11, Storage 1 TB', 3, '2022', 'Baik', 'Tersedia', 'PER-L1-REG-CPU-02', '2026-08-18 22:49:38'),
(351, 'Elo', 'Monitor', 'Elo', 1, '-', 3, '2013', 'Baik', 'Tersedia', 'PER-L1-REG-MON-02', '2026-08-18 22:49:38'),
(352, 'Eppos', 'Scanner QR', 'Eppos', 1, 'RP 5000G', 3, '2023', 'Baik', 'Tersedia', 'PER-L1-REG-SCNQR-01', '2026-08-18 22:49:38'),
(353, 'Symbol', 'Scanner QR', 'Symbol', 1, '-', 3, '2008', 'Rusak Ringan', 'Tersedia', 'PER-L1-REG-SCNQR-02', '2026-08-18 22:49:38'),
(354, 'Intel i3', 'CPU', 'Intel i3', 1, 'RAM 4 GB, Intel Core i3-4130, Windows 11, Storage 1 TB', 3, '2022', 'Baik', 'Tersedia', 'PER-L1-REG-CPU-03', '2026-08-18 22:49:38'),
(355, 'Elo', 'Monitor', 'Elo', 1, '-', 3, '2013', 'Baik', 'Tersedia', 'PER-L1-REG-MON-03', '2026-08-18 22:49:38'),
(356, 'VSC', 'Scanner QR', 'VSC', 1, 'VSC BS-985A', 3, '2023', 'Baik', 'Tersedia', 'PER-L1-REG-SCNQR-03', '2026-08-18 22:49:38'),
(357, 'TP Link', 'Switch', 'TP Link', 1, 'Switch 8-Port; Port: 8', 3, '2015', 'Baik', 'Tersedia', 'PER-L1-REG-SW-01', '2026-08-18 22:49:38'),
(358, 'Lenovo', 'PC', 'Lenovo', 1, 'RAM 8 GB, Intel Core i5-9400T, Windows 11, Storage 1 TB', 4, '2020', 'Baik', 'Tersedia', 'PER-L1-RAG-PC-01', '2026-08-18 22:49:38'),
(359, '', 'Printer Kartu', NULL, 1, NULL, 4, '0000', 'Baik', 'Tersedia', 'PER-L1-RAG-PRN-KARTU-01', '2026-08-18 22:49:38'),
(360, 'HP', 'PC', 'HP', 1, 'Intel Core i3 Generasi 8', 4, '2019', 'Rusak Berat', 'Tersedia', 'PER-L1-RAG-PC-02', '2026-08-18 22:49:38'),
(361, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-2120, Windows 10, Storage 256 GB', 5, '2012', 'Baik', 'Tersedia', 'PER-L2-RBD1-PC-01', '2026-08-18 22:49:38'),
(362, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-2120, Windows 8, Storage 512 GB', 5, '2012', 'Baik', 'Tersedia', 'PER-L2-RBD1-PC-02', '2026-08-18 22:49:38'),
(363, '3M', 'Scanner RF', '3M', 1, '-', 5, '2013', 'Baik', 'Tersedia', 'PER-L2-RBD1-SCNRF-01', '2026-08-18 22:49:38'),
(364, 'Kassen', 'Scanner QR', 'Kassen', 1, '-', 5, '2025', 'Baik', 'Tersedia', 'PER-L2-RBD1-SCNQR-01', '2026-08-18 22:49:38'),
(365, 'Epson', 'Printer', 'Epson', 1, '-', 5, '2013', 'Baik', 'Tersedia', 'PER-L2-RBD1-PRN-01', '2026-08-18 22:49:38'),
(366, 'D-Link', 'Switch', 'D-Link', 1, 'DGS-108GL (GB)', 5, '2022', 'Baik', 'Tersedia', 'PER-L2-RBD1-SW-01', '2026-08-18 22:49:38'),
(367, 'HP', 'PC', 'HP', 1, 'RAM 2 GB, Intel Core i3-2120, Windows 7, Storage 512 GB', 5, '2012', 'Baik', 'Tersedia', 'PER-L2-RBD1-PC-03', '2026-08-18 22:49:38'),
(368, 'VSC', 'Scanner QR', 'VSC', 1, 'VSC BS-895A', 5, '2023', 'Baik', 'Tersedia', 'PER-L2-RBD1-SCNQR-02', '2026-08-18 22:49:38'),
(369, '-', 'CPU', '-', 1, 'RAM 4 GB, Intel Core i3-3240, Windows 10 Pro, Storage 256 GB', 5, '2012', 'Baik', 'Tersedia', 'PER-L2-RBD1-CPU-01', '2026-08-18 22:49:38'),
(370, '-', 'Monitor', '-', 1, '-', 5, '2012', 'Baik', 'Tersedia', 'PER-L2-RBD1-MON-01', '2026-08-18 22:49:38'),
(371, 'Ubiquiti', 'Access Point', 'Ubiquiti', 1, 'Dual Band', 5, '2023', 'Baik', 'Tersedia', 'PER-L2-RBD1-AP-01', '2026-08-18 22:49:38'),
(372, 'TP-LINK', 'Access Point', 'TP-LINK', 1, 'Single Band 5-port', 5, '2026', 'Baik', 'Tersedia', 'PER-L2-RBD1-AP-02', '2026-08-18 22:49:38'),
(373, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-2120, Windows 10 Pro, Storage 512 GB', 6, '2012', 'Baik', 'Tersedia', 'PER-L2-RBD2-PC-01', '2026-08-18 22:49:38'),
(374, 'Epson', 'Printer', 'Epson', 1, 'Epson L360', 6, '2013', 'Baik', 'Tersedia', 'PER-L2-RBD2-PRN-01', '2026-08-18 22:49:38'),
(375, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-2120, Windows 8, Storage 256 GB', 6, '2012', 'Baik', 'Tersedia', 'PER-L2-RBD2-PC-02', '2026-08-18 22:49:38'),
(376, 'Epson kecil', 'Printer', 'Epson kecil', 1, '-', 6, '0000', 'Baik', 'Tersedia', 'PER-L2-RBD2-PRN-02', '2026-08-18 22:49:38'),
(377, '3M', 'Scanner RF', '3M', 1, '-', 6, '2013', 'Baik', 'Tersedia', 'PER-L2-RBD2-SCNRF-01', '2026-08-18 22:49:38'),
(378, 'Kassen', 'Scanner QR', 'Kassen', 1, '-', 6, '0000', 'Baik', 'Tersedia', 'PER-L2-RBD2-SCNQR-01', '2026-08-18 22:49:38'),
(379, 'Eppos', 'Scanner Barcode', 'Eppos', 1, 'RP5000G', 6, '2023', 'Baik', 'Tersedia', 'PER-L2-RBD2-SCNBR-01', '2026-08-18 22:49:38'),
(380, '-', 'CPU', '-', 1, 'RAM 2 GB, Intel Core i3-3240, Windows 8 Pro, Storage 256 GB', 6, '2012', 'Baik', 'Tersedia', 'PER-L2-RBD2-CPU-01', '2026-08-18 22:49:38'),
(381, '-', 'Monitor', '-', 1, '-', 6, '2012', 'Baik', 'Tersedia', 'PER-L2-RBD2-MON-01', '2026-08-18 22:49:38'),
(382, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-2120, Windows 8 Pro, Storage 512 GB', 6, '2012', 'Baik', 'Tersedia', 'PER-L2-RBD2-PC-03', '2026-08-18 22:49:38'),
(383, 'VSC', 'Scanner QR', 'VSC', 1, 'VSC BS-895A', 6, '2023', 'Baik', 'Tersedia', 'PER-L2-RBD2-SCNQR-02', '2026-08-18 22:49:38'),
(384, 'TP-LINK', 'Switch', 'TP-LINK', 1, 'Switch 4-Port (PERLU VERIFIKASI)', 6, '2015', 'Baik', 'Tersedia', 'PER-L2-RBD2-SW-01', '2026-08-18 22:49:38'),
(385, 'Ubiquiti', 'Access Point', 'Ubiquiti', 1, 'Dual Band', 6, '2023', 'Baik', 'Tersedia', 'PER-L2-RBD2-AP-01', '2026-08-18 22:49:38'),
(386, 'AXIOO', 'PC (BELUM DICEK)', 'AXIOO', 5, NULL, 7, '0000', 'Baik', 'Tersedia', 'PER-L2-PHUSAKA-PC-01', '2026-08-18 22:49:38'),
(387, 'Samsung', 'STV', 'Samsung', 1, NULL, 7, '0000', 'Baik', 'Tersedia', 'PER-L2-PUST-STV-01', '2026-08-18 22:49:38'),
(388, 'Asus', 'CPU', 'Asus', 1, NULL, 7, '0000', 'Baik', 'Tersedia', 'PER-L2-PUST-CPU-01', '2026-08-18 22:49:38'),
(389, 'TP LINK', 'Access Point', 'TP LINK', 1, NULL, 7, '2015', 'Baik', 'Tersedia', 'PER-L2-PUST-AP-01', '2026-08-18 22:49:38'),
(390, 'TP LINK', 'Switch', 'TP LINK', 1, 'Switch 8-Port', 7, '2015', 'Baik', 'Tersedia', 'PER-L2-PUST-SW-01', '2026-08-18 22:49:38'),
(391, '', 'TV', NULL, 1, NULL, 8, '0000', 'Baik', 'Tersedia', 'PER-L2-BIC-TV-01', '2026-08-18 22:49:38'),
(392, '', 'Monitor', NULL, 1, 'RAM 2 GB, Intel Pentium, Windows 8', 8, '2020', 'Baik', 'Tersedia', 'PER-L2-BIC-MON-01', '2026-08-18 22:49:38'),
(393, 'Aruba', 'Switch Managed', 'Aruba', 1, 'Switch 24-port (GB) dengan uplink 10G', 9, '2021', 'Baik', 'Tersedia', 'PER-L2-RK-SW-01', '2026-08-18 22:49:38'),
(394, 'Totolink', 'Switch Unmanaged', 'Totolink', 1, 'Switch 24-port (GB)', 9, '0000', 'Baik', 'Tersedia', 'PER-L2-RK-SW-02', '2026-08-18 22:49:38'),
(395, 'Alcatroz', 'CPU', 'Alcatroz', 1, 'RAM 4 GB, Intel Core i3-6100, Windows 10, Storage 1 TB', 10, '2012', 'Baik', 'Tersedia', 'PER-L3-REF-CPU-01', '2026-08-18 22:49:38'),
(396, '-', 'Monitor', '-', 1, '-', 10, '2012', 'Baik', 'Tersedia', 'PER-L3-REF-MON-01', '2026-08-18 22:49:38'),
(397, 'HP', 'PC', 'HP', 1, 'RAM 2 GB, Intel Core i3-2120, Windows 7, Storage 1 TB', 10, '2012', 'Baik', 'Tersedia', 'PER-L3-REF-PC-01', '2026-08-18 22:49:38'),
(398, 'Kassen', 'Scanner QR', 'Kassen', 1, '-', 10, '2025', 'Baik', 'Tersedia', 'PER-L3-REF-SCNQR-01', '2026-08-18 22:49:38'),
(399, 'HP', 'PC', 'HP', 1, 'RAM 2 GB, Intel Core i3-2120, Windows 10 Pro, Storage 512 GB', 10, '2012', 'Baik', 'Tersedia', 'PER-L3-REF-PC-02', '2026-08-18 22:49:38'),
(400, 'TP-Link', 'Switch', 'TP-Link', 1, '8-Port Switch; Port: 8', 10, '2020', 'Baik', 'Tersedia', 'PER-L3-REF-SW-01', '2026-08-18 22:49:38'),
(401, 'Ubiquiti', 'Access Point', 'Ubiquiti', 1, 'Dual Band', 10, '2023', 'Baik', 'Tersedia', 'PER-L3-REF-AP-01', '2026-08-18 22:49:38'),
(402, 'Intei3 core i3', 'CPU', 'Intei3 core i3', 1, 'RAM 2 GB, Intel Core i3-3240, Windows 8, Storage 256 GB', 11, '2012', 'Baik', 'Tersedia', 'PER-L3-REM-CPU-01', '2026-08-18 22:49:38'),
(403, '-', 'Monitor', '-', 1, '-', 11, '2012', 'Baik', 'Tersedia', 'PER-L3-REM-MON-01', '2026-08-18 22:49:38'),
(404, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-2120, Windows 8, Storage 512 GB', 11, '2012', 'Baik', 'Tersedia', 'PER-L3-REM-PC-01', '2026-08-18 22:49:38'),
(405, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-2120, Windows 10, Storage 512 GB', 11, '2012', 'Baik', 'Tersedia', 'PER-L3-REM-PC-02', '2026-08-18 22:49:38'),
(406, 'Epson', 'Printer', 'Epson', 1, 'Epson TM-L120 Receipt4', 11, '2012', 'Baik', 'Tersedia', 'PER-L3-REM-PRN-01', '2026-08-18 22:49:38'),
(407, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3-2120, Windows 8, Storage 512 GB', 11, '2012', 'Baik', 'Tersedia', 'PER-L3-REM-PC-03', '2026-08-18 22:49:38'),
(408, 'Kassen', 'Scanner QR', 'Kassen', 1, '-', 11, '2025', 'Baik', 'Tersedia', 'PER-L3-REM-SCNQR-01', '2026-08-18 22:49:38'),
(409, 'Eppos', 'Scanner Barcode', 'Eppos', 1, 'RP5000G', 11, '2023', 'Baik', 'Tersedia', 'PER-L3-REM-SCNBR-01', '2026-08-18 22:49:38'),
(410, '3M', 'Scanner RF', '3M', 1, '-', 11, '2013', 'Baik', 'Tersedia', 'PER-L3-REM-SCNRF-01', '2026-08-18 22:49:38'),
(411, 'TP-Link', 'Switch', 'TP-Link', 1, '8-Port Switch; Port: 8', 11, '2020', 'Baik', 'Tersedia', 'PER-L3-REM-SW-01', '2026-08-18 22:49:38'),
(412, 'VSC', 'Scanner QR', 'VSC', 1, 'BS895A', 11, '2023', 'Baik', 'Tersedia', 'PER-L3-REM-SCNQR-02', '2026-08-18 22:49:38'),
(413, 'Ubiquiti', 'Access Point', 'Ubiquiti', 1, 'Dual Band', 11, '2023', 'Baik', 'Tersedia', 'PER-L3-REM-AP-01', '2026-08-18 22:49:38'),
(414, 'Nec', 'Proyektor', 'Nec', 1, 'NP-PA500XG', 11, '2013', 'Baik', 'Tersedia', 'PER-L3-REM-PJT-01', '2026-08-18 22:49:38'),
(415, 'TP-LINK', 'Switch', 'TP-LINK', 1, '16-Port Switch', 12, '2015', 'Baik', 'Tersedia', 'PER-L3-RK-SW-01', '2026-08-18 22:49:38'),
(416, 'HP', 'PC', 'HP', 1, 'RAM 4 GB, Intel Core i3 Gen 8, Windows 11, Storage 1 TB', 13, '2019', 'Rusak Ringan', 'Tersedia', 'PER-L3-GCO-PC-01', '2026-08-18 22:49:38'),
(417, 'D-Link', 'Switch', 'D-Link', 1, 'DGS-108GL (GB)', 14, '2022', 'Baik', 'Tersedia', 'PER-L4-RK-SW-01-GB', '2026-08-18 22:49:38'),
(418, 'D-Link', 'Switch', 'D-Link', 1, '-', 14, '2016', 'Baik', 'Tersedia', 'PER-L4-RK-SW-02-MB', '2026-08-18 22:49:38'),
(419, 'LG', 'Smart TV', 'LG', 1, '55UT801C0SB', 15, '2026', 'Baik', 'Tersedia', 'PER-L4-RPUS-STV-01', '2026-08-18 22:49:38'),
(420, 'HP', 'PC', 'HP', 1, 'Intel Core i3-2120, RAM 4 GB, Storage 256 GB, Windows 10', 15, '2012', 'Baik', 'Tersedia', 'PER-L4-RPUS-PC-01', '2026-08-18 22:49:38'),
(421, 'TP-LINK', 'Switch', 'TP-LINK', 1, '8-Port Switch; Port: 8', 15, '2020', 'Baik', 'Tersedia', 'PER-L4-RPUS-SW-01', '2026-08-18 22:49:38'),
(422, 'Ubiquiti', 'Access Point (AP)', 'Ubiquiti', 1, 'Dual Band', 16, '2023', 'Baik', 'Tersedia', 'PER-L4-R.AU-AP-01', '2026-08-18 22:49:38'),
(423, 'Ubiquiti', 'Access Point (AP)', 'Ubiquiti', 1, 'Dual Band', 16, '2023', 'Baik', 'Tersedia', 'PER-L4-R.AU-AP-02', '2026-08-18 22:49:38'),
(424, 'Ubiquiti', 'Access Point (AP)', 'Ubiquiti', 1, 'Dual Band', 16, '2017', 'Baik', 'Tersedia', 'PER-L4-R.AU-AP-03', '2026-08-18 22:49:38'),
(425, 'Panasonic', 'Proyektor', 'Panasonic', 1, '-', 16, '2023', 'Baik', 'Tersedia', 'PER-L4-R.AU-PJT-01', '2026-08-18 22:49:38'),
(426, 'Panasonic', 'Proyektor', 'Panasonic', 1, '-', 16, '2023', 'Baik', 'Tersedia', 'PER-L4-R.AU-PJT-02', '2026-08-18 22:49:38'),
(427, 'NEC', 'Proyektor', 'NEC', 1, 'NP-PA500XG', 16, '2013', 'Baik', 'Tersedia', 'PER-L4-R.AU-PJT-03', '2026-08-18 22:49:38');

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
-- Table structure for table `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id` int(11) NOT NULL,
  `aktivitas` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `log_aktivitas`
--

INSERT INTO `log_aktivitas` (`id`, `aktivitas`, `deskripsi`, `tanggal`) VALUES
(1, 'Test aktivitas', 'Pengujian log aktivitas berhasil dilakukan.', '2026-08-19 06:02:31'),
(2, 'Inventaris baru', 'Perangkat pc dell dengan kode aset test-001 berhasil ditambahkan ke sistem.', '2026-08-19 06:08:34'),
(3, 'Inventaris dihapus', 'Perangkat pc dell dengan kode aset test-001 berhasil dihapus dari sistem.', '2026-08-19 06:12:49'),
(4, 'Maintenance baru', 'Perangkat Epson dengan kode aset ARSIP-L1-KEP.U-PRN-01 dilaporkan mengalami kerusakan dan masuk ke proses maintenance.', '2026-08-19 06:21:41'),
(5, 'Maintenance diperbarui', 'Data maintenance perangkat Epson dengan kode aset ARSIP-L1-KEP.U-PRN-01 telah diperbarui. Status: Menunggu.', '2026-08-19 06:23:34'),
(6, 'Maintenance baru', 'Perangkat  dengan kode aset PER-L1-RAG-PRN-KARTU-01 dilaporkan mengalami kerusakan dan masuk ke proses maintenance.', '2026-08-19 06:24:29'),
(7, 'Maintenance dihapus', 'Data maintenance perangkat  dengan kode aset PER-L1-RAG-PRN-KARTU-01 telah dihapus dan perangkat dikembalikan ke status Tersedia.', '2026-08-19 06:24:34'),
(8, 'Perangkat dipinjam', 'Perangkat 3M dengan kode aset PER-L1-TP-SCNRF-01 dipinjam oleh pak ahmad dari divisi bidang arsip.', '2026-08-19 06:26:17'),
(9, 'Perangkat dikembalikan', 'Perangkat 3M dengan kode aset PER-L1-TP-SCNRF-01 telah dikembalikan oleh pak ahmad dari divisi bidang arsip dan kembali tersedia untuk digunakan.', '2026-08-19 06:27:07'),
(10, 'Perangkat dipinjam', 'Perangkat Acer dengan kode aset ARSIP-L1-RP-LTP-01 dipinjam oleh pa yusuf dari divisi bidang arsip.', '2026-08-19 06:41:25'),
(11, 'Perangkat dikembalikan', 'Perangkat Acer dengan kode aset ARSIP-L1-RP-LTP-01 telah dikembalikan oleh pa yusuf dari divisi bidang arsip dan kembali tersedia untuk digunakan.', '2026-08-19 06:42:06');

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

--
-- Dumping data for table `maintenance`
--

INSERT INTO `maintenance` (`id`, `inventaris_id`, `tanggal_lapor`, `kerusakan`, `keparahan`, `teknisi`, `tindakan`, `status`, `tanggal_selesai`, `created_at`) VALUES
(2, 42, '2026-08-19', 'Hasil cetak putus putus', 'Sedang', 'bapak budi', 'head cleaning', 'Menunggu', NULL, '2026-08-18 23:21:41');

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

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `inventaris_id`, `nama_peminjam`, `divisi`, `tanggal_pinjam`, `est_kembali`, `tanggal_kembali`, `status`, `created_at`) VALUES
(1, 347, 'pak ahmad', 'bidang arsip', '2026-08-19', '2026-08-26', '2026-08-19', 'Dikembalikan', '2026-08-18 23:26:17'),
(2, 62, 'pa yusuf', 'bidang arsip', '2026-08-19', '2026-08-20', '2026-08-19', 'Dikembalikan', '2026-08-18 23:41:25');

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
(36, 6, 'BIDEP', 'Bidang Deposit', '2026-07-28 01:41:59'),
(37, 5, 'RU', 'Umum', '2026-08-11 03:01:22'),
(38, 5, 'RSEK', 'Ruangan Sekretaris', '2026-08-11 03:01:22'),
(39, 5, 'RRC', 'Ruang Data Center', '2026-08-11 03:01:22'),
(40, 5, 'R.PTM', 'Pustama', '2026-08-11 03:01:22'),
(41, 5, 'PRESIP', 'R Preservasi Arsip', '2026-08-11 03:01:22'),
(42, 5, 'RKADIS', 'Kepala Dinas', '2026-08-11 03:01:22'),
(43, 7, 'R.GAS', 'Ruangan Petugas', '2026-08-11 03:01:22'),
(44, 8, 'RPSTS', 'Ruang Pengolahan Arsip Statis', '2026-08-11 03:01:22'),
(45, 8, 'RGAS4', 'Ruangan Petugas', '2026-08-11 03:01:22'),
(46, 8, 'DEPOB', 'Depo Arsip B', '2026-08-11 03:01:22'),
(47, 9, 'RPAI', 'Ruang Pengelolaan Arsip Inaktif', '2026-08-11 03:01:22'),
(48, 9, 'DEPOB', 'Depo Arsip B', '2026-08-11 03:01:22'),
(49, 10, 'RPAI6', 'Ruang Pengelolaan Arsip Inaktif LT6', '2026-08-11 03:01:22'),
(50, 11, 'RLTJB', 'Ruang Literatur Tentang Jawa Barat', '2026-08-11 03:01:22');

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
  ADD KEY `ruangan_id` (`ruangan_id`);

--
-- Indexes for table `lantai`
--
ALTER TABLE `lantai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gedung_id` (`gedung_id`);

--
-- Indexes for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=429;

--
-- AUTO_INCREMENT for table `lantai`
--
ALTER TABLE `lantai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `maintenance`
--
ALTER TABLE `maintenance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ruangan`
--
ALTER TABLE `ruangan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

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
