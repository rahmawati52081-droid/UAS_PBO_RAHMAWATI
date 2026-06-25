-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2026 at 08:33 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_uas_pbo_ti1d_rahmawati`
--

-- --------------------------------------------------------

--
-- Table structure for table `tabel_mahasiswa`
--

CREATE TABLE `tabel_mahasiswa` (
  `id_mahasiswa` int(11) NOT NULL,
  `nama_mahasiswa` varchar(100) NOT NULL,
  `nim` varchar(15) NOT NULL,
  `semester` int(11) NOT NULL,
  `tarif_ukt_nominal` decimal(10,2) NOT NULL,
  `jenis_pembayaran` enum('mandiri','bidikmisi','prestasi') NOT NULL,
  `golongan_ukt` varchar(10) DEFAULT NULL,
  `nama_wali` varchar(100) DEFAULT NULL,
  `nomor_kip_kuliah` varchar(30) DEFAULT NULL,
  `dana_saku_subsidi` decimal(10,2) DEFAULT NULL,
  `nama_instansi_beasiswa` varchar(100) DEFAULT NULL,
  `minimal_ipk_syarat` decimal(3,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tabel_mahasiswa`
--

INSERT INTO `tabel_mahasiswa` (`id_mahasiswa`, `nama_mahasiswa`, `nim`, `semester`, `tarif_ukt_nominal`, `jenis_pembayaran`, `golongan_ukt`, `nama_wali`, `nomor_kip_kuliah`, `dana_saku_subsidi`, `nama_instansi_beasiswa`, `minimal_ipk_syarat`) VALUES
(1, 'Ahmad Fauzi', '230101001', 2, 5000000.00, 'mandiri', 'Golongan 3', 'Budi Santoso', NULL, NULL, NULL, NULL),
(2, 'Siti Aminah', '230101002', 2, 7500000.00, 'mandiri', 'Golongan 5', 'Hendro Utomo', NULL, NULL, NULL, NULL),
(3, 'Rian Hidayat', '230101003', 4, 6000000.00, 'mandiri', 'Golongan 4', 'Slamet Riyadi', NULL, NULL, NULL, NULL),
(4, 'Dewi Lestari', '230101004', 4, 5000000.00, 'mandiri', 'Golongan 3', 'Agus Setiawan', NULL, NULL, NULL, NULL),
(5, 'Fajar Nugroho', '230101005', 6, 9000000.00, 'mandiri', 'Golongan 6', 'Dedi Wijaya', NULL, NULL, NULL, NULL),
(6, 'Citra Kirana', '230101006', 6, 7500000.00, 'mandiri', 'Golongan 5', 'Iwan Fals', NULL, NULL, NULL, NULL),
(7, 'Bagas Kara', '230101007', 2, 6000000.00, 'mandiri', 'Golongan 4', 'Surono', NULL, NULL, NULL, NULL),
(8, 'Eko Prasetyo', '230101008', 2, 0.00, 'bidikmisi', NULL, NULL, 'KIP-2023-9901', 1200000.00, NULL, NULL),
(9, 'Fitriani', '230101009', 2, 0.00, 'bidikmisi', NULL, NULL, 'KIP-2023-9902', 1200000.00, NULL, NULL),
(10, 'Gilang Dirga', '230101010', 4, 0.00, 'bidikmisi', NULL, NULL, 'KIP-2022-8801', 1200000.00, NULL, NULL),
(11, 'Hana Pertiwi', '230101011', 4, 0.00, 'bidikmisi', NULL, NULL, 'KIP-2022-8802', 1200000.00, NULL, NULL),
(12, 'Indra Wijaya', '230101012', 6, 0.00, 'bidikmisi', NULL, NULL, 'KIP-2021-7701', 1400000.00, NULL, NULL),
(13, 'Joko Susilo', '230101013', 6, 0.00, 'bidikmisi', NULL, NULL, 'KIP-2021-7702', 1400000.00, NULL, NULL),
(14, 'Kurniawati', '230101014', 2, 0.00, 'bidikmisi', NULL, NULL, 'KIP-2023-9903', 1200000.00, NULL, NULL),
(15, 'Lesti Kejora', '230101015', 2, 1500000.00, 'prestasi', NULL, NULL, NULL, NULL, 'Djarum Foundation', 3.50),
(16, 'Muhammad Rizky', '230101016', 2, 2000000.00, 'prestasi', NULL, NULL, NULL, NULL, 'Beasiswa Tanoto', 3.40),
(17, 'Nadia Vega', '230101017', 4, 0.00, 'prestasi', NULL, NULL, NULL, NULL, 'Bank Indonesia', 3.60),
(18, 'Oki Setiana', '230101018', 4, 1500000.00, 'prestasi', NULL, NULL, NULL, NULL, 'Djarum Foundation', 3.50),
(19, 'Putra Perkasa', '230101019', 6, 0.00, 'prestasi', NULL, NULL, NULL, NULL, 'Pemprov Jateng', 3.30),
(20, 'Qori Sandioriva', '230101020', 6, 2000000.00, 'prestasi', NULL, NULL, NULL, NULL, 'Beasiswa Tanoto', 3.40),
(21, 'Rendra Karno', '230101021', 2, 0.00, 'prestasi', NULL, NULL, NULL, NULL, 'Bank Indonesia', 3.60);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tabel_mahasiswa`
--
ALTER TABLE `tabel_mahasiswa`
  ADD PRIMARY KEY (`id_mahasiswa`),
  ADD UNIQUE KEY `nim` (`nim`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tabel_mahasiswa`
--
ALTER TABLE `tabel_mahasiswa`
  MODIFY `id_mahasiswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
