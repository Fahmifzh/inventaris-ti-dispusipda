-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: inventaris_ti_dispusipda
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'Administrator','admin','0192023a7bbd73250516f069df18b500','2026-07-28 01:25:08');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gedung`
--

DROP TABLE IF EXISTS `gedung`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gedung` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_gedung` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gedung`
--

LOCK TABLES `gedung` WRITE;
/*!40000 ALTER TABLE `gedung` DISABLE KEYS */;
INSERT INTO `gedung` VALUES (1,'Gedung Perpustakaan','2026-07-28 01:25:29'),(2,'Gedung Arsip','2026-07-28 01:25:29');
/*!40000 ALTER TABLE `gedung` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventaris`
--

DROP TABLE IF EXISTS `inventaris`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventaris` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode_aset` (`kode_aset`),
  KEY `ruangan_id` (`ruangan_id`),
  CONSTRAINT `inventaris_ibfk_1` FOREIGN KEY (`ruangan_id`) REFERENCES `ruangan` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventaris`
--

LOCK TABLES `inventaris` WRITE;
/*!40000 ALTER TABLE `inventaris` DISABLE KEYS */;
/*!40000 ALTER TABLE `inventaris` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lantai`
--

DROP TABLE IF EXISTS `lantai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lantai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gedung_id` int(11) NOT NULL,
  `nama_lantai` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `gedung_id` (`gedung_id`),
  CONSTRAINT `lantai_ibfk_1` FOREIGN KEY (`gedung_id`) REFERENCES `gedung` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lantai`
--

LOCK TABLES `lantai` WRITE;
/*!40000 ALTER TABLE `lantai` DISABLE KEYS */;
INSERT INTO `lantai` VALUES (1,1,'Lantai 1','2026-07-28 01:28:55'),(2,1,'Lantai 2','2026-07-28 01:28:55'),(3,1,'Lantai 3','2026-07-28 01:28:55'),(4,1,'Lantai 4','2026-07-28 01:28:55'),(5,2,'Lantai 1','2026-07-28 01:28:55'),(6,2,'Lantai 2','2026-07-28 01:28:55'),(7,2,'Lantai 3','2026-07-28 01:28:55'),(8,2,'Lantai 4','2026-07-28 01:28:55'),(9,2,'Lantai 5','2026-07-28 01:28:55'),(10,2,'Lantai 6','2026-07-28 01:28:55'),(11,2,'Lantai 7','2026-07-28 01:28:55');
/*!40000 ALTER TABLE `lantai` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `maintenance`
--

DROP TABLE IF EXISTS `maintenance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `maintenance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inventaris_id` int(11) NOT NULL,
  `tanggal_lapor` date NOT NULL,
  `kerusakan` text NOT NULL,
  `keparahan` enum('Rendah','Sedang','Tinggi') DEFAULT 'Sedang',
  `teknisi` varchar(100) DEFAULT NULL,
  `tindakan` text DEFAULT NULL,
  `status` enum('Menunggu','Dalam Perbaikan','Selesai') DEFAULT 'Menunggu',
  `tanggal_selesai` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `inventaris_id` (`inventaris_id`),
  CONSTRAINT `maintenance_ibfk_1` FOREIGN KEY (`inventaris_id`) REFERENCES `inventaris` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `maintenance`
--

LOCK TABLES `maintenance` WRITE;
/*!40000 ALTER TABLE `maintenance` DISABLE KEYS */;
/*!40000 ALTER TABLE `maintenance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `peminjaman`
--

DROP TABLE IF EXISTS `peminjaman`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `peminjaman` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inventaris_id` int(11) NOT NULL,
  `nama_peminjam` varchar(150) NOT NULL,
  `divisi` varchar(150) DEFAULT NULL,
  `tanggal_pinjam` date NOT NULL,
  `est_kembali` date DEFAULT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `status` enum('Dipinjam','Dikembalikan') DEFAULT 'Dipinjam',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `inventaris_id` (`inventaris_id`),
  CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`inventaris_id`) REFERENCES `inventaris` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peminjaman`
--

LOCK TABLES `peminjaman` WRITE;
/*!40000 ALTER TABLE `peminjaman` DISABLE KEYS */;
/*!40000 ALTER TABLE `peminjaman` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ruangan`
--

DROP TABLE IF EXISTS `ruangan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ruangan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lantai_id` int(11) NOT NULL,
  `kode_ruangan` varchar(20) NOT NULL,
  `nama_ruangan` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `lantai_id` (`lantai_id`),
  CONSTRAINT `ruangan_ibfk_1` FOREIGN KEY (`lantai_id`) REFERENCES `lantai` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ruangan`
--

LOCK TABLES `ruangan` WRITE;
/*!40000 ALTER TABLE `ruangan` DISABLE KEYS */;
INSERT INTO `ruangan` VALUES (1,1,'RAK','Ruang Anak dan Keluarga','2026-07-28 01:41:59'),(2,1,'TP','Tempat Pengembalian','2026-07-28 01:41:59'),(3,1,'REG','Registrasi','2026-07-28 01:41:59'),(4,1,'RAG','Anggota RAG','2026-07-28 01:41:59'),(5,2,'RBD1','Ruang Baca Dewasa 1','2026-07-28 01:41:59'),(6,2,'RBD2','Ruang Baca Dewasa 2','2026-07-28 01:41:59'),(7,2,'PHUSAKA','PHUSAKA','2026-07-28 01:41:59'),(8,2,'BIC','BI Corner','2026-07-28 01:41:59'),(9,2,'RK','Ruang Kabel','2026-07-28 01:41:59'),(10,3,'REF','Ruang Referensi','2026-07-28 01:41:59'),(11,3,'REM','Ruang Remaja','2026-07-28 01:41:59'),(12,3,'RK','Ruang Kabel','2026-07-28 01:41:59'),(13,3,'GCO','Galeri COVID','2026-07-28 01:41:59'),(14,4,'RK','Ruang Kabel','2026-07-28 01:41:59'),(15,4,'RPUS','Ruang Pustakawan','2026-07-28 01:41:59'),(16,4,'AULA','Aula','2026-07-28 01:41:59'),(17,5,'PLI','Pusat Layanan Informasi','2026-07-28 01:41:59'),(18,5,'TR','Teater','2026-07-28 01:41:59'),(19,5,'ADM','Ruang Administrasi','2026-07-28 01:41:59'),(20,5,'R.HUM','Humas','2026-07-28 01:41:59'),(21,5,'RPT','Ruang Rapat','2026-07-28 01:41:59'),(22,5,'TUPIM','TU Pimpinan','2026-07-28 01:41:59'),(23,5,'RBAK','Subag Keuangan dan Aset','2026-07-28 01:41:59'),(24,5,'KEP.U','Kepegawaian dan Umum','2026-07-28 01:41:59'),(25,5,'RP','Perencanaan','2026-07-28 01:41:59'),(26,5,'LIK','R.LIK Layanan Informasi Kearsipan','2026-07-28 01:41:59'),(27,5,'BPBGM','BPBGM','2026-07-28 01:41:59'),(28,5,'KBBPGM','Ruang Kepala Bagian BPBGM','2026-07-28 01:41:59'),(29,6,'RPAS','R.PAS Ruang Bagian Arsip','2026-07-28 01:41:59'),(30,6,'KBPAS','KBPAS Kabid Pengelolaan Arsip Statis','2026-07-28 01:41:59'),(31,6,'KBPPK','Kabid Pelayanan Perpustakaan dan Kearsipan','2026-07-28 01:41:59'),(32,6,'TUPPK','TU Bidang PPK','2026-07-28 01:41:59'),(33,6,'RED','Ruang Entri Data','2026-07-28 01:41:59'),(34,6,'RPAD','RPAD','2026-07-28 01:41:59'),(35,6,'KBPAD','KBPAD','2026-07-28 01:41:59'),(36,6,'BIDEP','Bidang Deposit','2026-07-28 01:41:59'),(37,5,'RU','Umum','2026-08-11 03:01:22'),(38,5,'RSEK','Ruangan Sekretaris','2026-08-11 03:01:22'),(39,5,'RRC','Ruang Data Center','2026-08-11 03:01:22'),(40,5,'R.PTM','Pustama','2026-08-11 03:01:22'),(41,5,'PRESIP','R Preservasi Arsip','2026-08-11 03:01:22'),(42,5,'RKADIS','Kepala Dinas','2026-08-11 03:01:22'),(43,7,'R.GAS','Ruangan Petugas','2026-08-11 03:01:22'),(44,8,'RPSTS','Ruang Pengolahan Arsip Statis','2026-08-11 03:01:22'),(45,8,'RGAS4','Ruangan Petugas','2026-08-11 03:01:22'),(46,8,'DEPOB','Depo Arsip B','2026-08-11 03:01:22'),(47,9,'RPAI','Ruang Pengelolaan Arsip Inaktif','2026-08-11 03:01:22'),(48,9,'DEPOB','Depo Arsip B','2026-08-11 03:01:22'),(49,10,'RPAI6','Ruang Pengelolaan Arsip Inaktif LT6','2026-08-11 03:01:22'),(50,11,'RLTJB','Ruang Literatur Tentang Jawa Barat','2026-08-11 03:01:22');
/*!40000 ALTER TABLE `ruangan` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-08-11 10:35:53
