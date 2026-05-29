-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 29, 2026 at 07:06 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sakukost`
--

-- --------------------------------------------------------

--
-- Table structure for table `kamar`
--

CREATE TABLE `kamar` (
  `no_kamar` varchar(10) NOT NULL,
  `tipe` varchar(50) NOT NULL,
  `harga` int NOT NULL,
  `status` enum('tersedia','terisi') DEFAULT 'tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kamar`
--

INSERT INTO `kamar` (`no_kamar`, `tipe`, `harga`, `status`) VALUES
('A1', 'Regular (Kamar Mandi Luar)', 500000, 'tersedia'),
('A2', 'Regular (Kamar Mandi Luar)', 500000, 'terisi'),
('B1', 'Premium (Kamar Mandi Dalam)', 850000, 'tersedia'),
('B2', 'Premium (Kamar Mandi Dalam)', 850000, 'terisi'),
('VIP', 'Eksklusif (AC & Kamar Mandi Dalam)', 1500000, 'terisi');

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `fasilitas` varchar(100) NOT NULL,
  `lokasi` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `status_laporan` varchar(20) DEFAULT 'Pending',
  `tanggal` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `laporan`
--

INSERT INTO `laporan` (`id`, `user_id`, `fasilitas`, `lokasi`, `deskripsi`, `status_laporan`, `tanggal`) VALUES
(1, 2, 'Lampu', 'Kamar Mandi Luar', 'Lampu sering kedap kedip', 'Selesai', '2026-05-28 14:02:55');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `bulan` varchar(20) NOT NULL,
  `jumlah` int NOT NULL,
  `catatan` text,
  `status` enum('menunggu','diterima','ditolak') DEFAULT 'menunggu',
  `tanggal` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `user_id`, `bulan`, `jumlah`, `catatan`, `status`, `tanggal`) VALUES
(1, 2, 'Januari 2026', 500000, 'Sudah lunas ya bu, bulan ini ;)', 'diterima', '2026-05-28 16:25:57'),
(2, 5, 'Januari 2026', 850000, '', 'diterima', '2026-05-29 03:36:29'),
(3, 4, 'Mei 2026', 1500000, 'Transfer melalui BCA an. Kharisma Jaka Harum, No. Rek 1234567890, via M-BCA, tgl 29/05/2026', 'diterima', '2026-05-29 03:39:46');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `hp` varchar(20) DEFAULT NULL,
  `role` enum('admin','user') NOT NULL,
  `kamar` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama`, `email`, `hp`, `role`, `kamar`) VALUES
(2, 'Elsy', '$2y$10$HEd2kqUr4Ves/mpoACNd5OpMCVlhn61PNt7fSihMyrJaTU95.kysa', 'Elsy Aliffia Sirony Putri', 'elsyaliffia@gmail.com', '0852687365417', 'user', 'A2'),
(3, 'admin', '$2y$10$1yG0tdSeD.DG1XU2Z2IZM.isMgtmPQAAdTS5MIVMOKfFkE9Wxt6Se', 'Pemilik Kost', 'admin@sakukost.com', '081234567891', 'admin', NULL),
(4, 'Kharisma', '$2y$10$4OSrmkTinMhHI.AnpX10K.z0uzyKaRzdR9KlDQiPgbLzK0xpEJLoa', 'Kharisma Jaka Harum', 'kharisma@gmail.com', '0987654345', 'user', 'VIP'),
(5, 'Rafi', '$2y$10$bt7X45mV7IVfk39fjMgzReSxV7ixS/To1x9isNiJd8MO5lptzwE7i', 'M. Rafi Al-Mustafa', 'rafi@gmail.com', '0987654778', 'user', 'B2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kamar`
--
ALTER TABLE `kamar`
  ADD PRIMARY KEY (`no_kamar`);

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `laporan`
--
ALTER TABLE `laporan`
  ADD CONSTRAINT `laporan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
