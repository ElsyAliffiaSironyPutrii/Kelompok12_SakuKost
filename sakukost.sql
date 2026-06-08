-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 08, 2026 at 12:24 AM
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
('A1', 'Regular (Kamar Mandi Luar)', 500000, 'terisi'),
('A2', 'Regular (Kamar Mandi Luar)', 500000, 'tersedia'),
('B1', 'Premium (Kamar Mandi Dalam)', 850000, 'terisi'),
('B2', 'Premium (Kamar Mandi Dalam)', 850000, 'tersedia'),
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
(2, 8, 'Lampu', 'Kamar Mandi Luar', 'Lampunya mati tidak mau hidup', 'Selesai', '2026-06-07 15:59:09');

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
(7, 10, 'Juni 2026', 850000, 'Telah ditransfer via Bank Syariah Indonesia (BSI) atas nama M. Rafi Al-Musthafa pada pukul 11:00 WIB.', 'diterima', '2026-06-07 16:19:50'),
(8, 9, 'Juni 2026', 1500000, 'Transfer via: Aplikasi Dana (an Kharisma Jaka Harum)\r\nTanggal/Jam: 8 Juni / Jam 11.15 WIB', 'diterima', '2026-06-07 16:20:41'),
(9, 8, 'Juni 2026', 500000, 'Transfer via BCA an Elsy Aliffia - Jam 14.30 WIB', 'diterima', '2026-06-07 16:21:12');

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
(6, 'admin', '$2y$10$EEUiil2jgY9VV4BZpc7S.eCkk4Gtm6if.GgzGrTBM9kwjOFEAqA5y', 'Admin SakuKost', 'admin@gmail.com', '081234567890', 'admin', '-'),
(8, 'Elsy', '$2y$10$K94Qe5WWKFm9RBG/87NEmO7fpt1vXipnagNgJivCSpTCr89cyx8re', 'Elsy Aliffia Sirony Putri', 'elsy@gmail.com', '098646856756', 'user', 'A1'),
(9, 'Kharisma', '$2y$10$TScI3NY7qLsr7zJyssmxU.JavUvx5d7oO3uxrycFhucSiAZITHmNy', 'Kharisma Jaka Harum', 'kharisma@gmail.com', '087656787676', 'user', 'VIP'),
(10, 'Rafi', '$2y$10$1zwsoPjabaxiZ305dPZzhuQp6U94pWHQqN/mqsq7spzvFWcq52oYm', 'M. Rafi Al-Musthafa', 'rafi@gmail.com', '087656787654', 'user', 'B1');

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
