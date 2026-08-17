-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 17, 2026 at 02:39 PM
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
-- Database: `db_piketos`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id_admin` int NOT NULL,
  `admin` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `kelas` varchar(20) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_admin`
--

INSERT INTO `tb_admin` (`id_admin`, `admin`, `kelas`, `password`) VALUES
(10, 'Febri Pratama', '12 RPL 1', 'piketos2026');

-- --------------------------------------------------------

--
-- Table structure for table `tb_kandidat`
--

CREATE TABLE `tb_kandidat` (
  `id` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `visi` text NOT NULL,
  `misi` text NOT NULL,
  `image` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_kandidat`
--

INSERT INTO `tb_kandidat` (`id`, `nama`, `visi`, `misi`, `image`) VALUES
(60, 'Geisika Yoan', 'Menjadikan OSIS sebagai organisasi yang menjadi wadah aspirasi warga SMK Informatika Sumedang, serta mengembangkan potensi siswa agar aktif, kreatif dan berani berpendapat.', '1. Mengembangkan siswa siswi SMK Informatika Sumedang untuk lebih aktif dalam bersosialisasi.\r\n2. Meningkatkan minat literasi dikalangan siswa.\r\n3. Membentuk lingkungan sekolah yang peduli terhadap kebersihan dan kesehatan.\r\n4. Membangun keterampilan dan pengetahuan siswa.', 'kandidat_6a6f3bb88ca50.png'),
(61, 'Arisu Dela', 'Mewujudkan OSIS SMK Informatika Sumedang yang unggul dalam prestasi, solid dalam kebersamaan, dan hebat dalam karya menuju generasi yang berkarakter, berdaya saing, dan berpengaruh positif bagi sekolah.', '1. Membangun OSIS yang aktif, inspiratif, dan meningkatkan kualitas diri dari pengurus osis yang menjadi contoh nyata bagi seluruh siswa\r\n2. Menciptakan lingkungan sekolah yang nyaman, kreatif, dan penuh semangat kolaborasi.\r\n3. Mengembangkan potensi setiap siswa melalui kegiatan inovatif dan berbasis teknologi.\r\n4. Menumbuhkan semangat peduli, disiplin, dan bertanggung jawab dalam setiap tindakan.\r\n5. Menjadikan OSIS sebagai wadah aspirasi, tempat berkembang, tempat semua suara di dengar dan ruang perubahan.', 'kandidat_6a6f702aa265a.jpg'),
(64, 'Febri Pratama', 'Mewujudkan osis smk informatika sumedang sebagai osis yang kreatif,dan terampil, dan bisa mewujudkan keteladanan yang disiplin dan bertanggung jawab.', '1. Menyelenggarakan perlombaan supaya meningkatkan kreativitas dan meningkatkan minat bakat siswa.\r\n2. Menciptakan organisasi OSIS lebih kreatif, inovatif, serta memiliki kepedulian terhadap sesama siswa.\r\n3. Menjalani komunikasi yang baik antar semua pihak sekolah agar menciptakan hubungan yang harmonis.\r\n4. Mendorong siswa untuk menciptakan karya yang inovatif dan kreatif untuk wadah kesuksesan sebuah talenta siswa.', 'kandidat_6a6f705b42c16.png');

-- --------------------------------------------------------

--
-- Table structure for table `tb_settings`
--

CREATE TABLE `tb_settings` (
  `id` int NOT NULL,
  `nama_sekolah` varchar(40) NOT NULL,
  `judul_pemilihan` varchar(30) NOT NULL,
  `tahun_ajaran` varchar(20) NOT NULL,
  `status_voting` enum('0','1') NOT NULL,
  `waktu_mulai` datetime NOT NULL,
  `waktu_selesai` datetime NOT NULL,
  `logo_sekolah` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_settings`
--

INSERT INTO `tb_settings` (`id`, `nama_sekolah`, `judul_pemilihan`, `tahun_ajaran`, `status_voting`, `waktu_mulai`, `waktu_selesai`, `logo_sekolah`) VALUES
(836197, 'SMK Informatika Sumedang', 'E-Vote OSIS', '2026 - 2027', '0', '2026-10-05 12:22:00', '2026-11-30 12:22:00', 'logo_1786966071.png');

-- --------------------------------------------------------

--
-- Table structure for table `tb_siswa`
--

CREATE TABLE `tb_siswa` (
  `token` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kelas` varchar(20) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `voted` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_siswa`
--

INSERT INTO `tb_siswa` (`token`, `nama`, `kelas`, `status`, `voted`) VALUES
('0206', 'Nexdy experiment', '11 RPL 1', 1, 60),
('25D3', 'Nexdy experiment', '11 RPL 1', 0, 0),
('7O14', 'Ramdhani', '12 RPL 1', 0, 0),
('89P7', 'Nexdy experiment', '11 RPL 1', 0, 0),
('ABCD', 'febri pratama', '11 RPL 1', 1, 64),
('DFJK', 'muhammad ramdhani ', '11 RPL 1', 1, 61),
('F9RW', 'Ridwan Saepuloh', '12 RPL 1', 0, 0),
('NX74', 'Aditya Anugrah', '12 RPL 1', 0, 0),
('NXYZ', 'Nexdy experiment', '11 RPL 1', 1, 60),
('ONBE', 'Nexdy experiment', '11 RPL 1', 1, 61),
('OPQR', 'fahri nasluroh', '11 RPL 1', 1, 60),
('TZ11', 'Muhammad Syarif Badrudin', '12 RPL 2', 0, 0),
('TZ8B', 'Nexdy experiment', '11 RPL 1', 1, 60),
('U4S4', 'Hafidz', '11 RPL 1', 0, 0),
('X8O5', 'Nexdy experiment', '11 RPL 1', 1, 64);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `tb_kandidat`
--
ALTER TABLE `tb_kandidat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_settings`
--
ALTER TABLE `tb_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD PRIMARY KEY (`token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tb_kandidat`
--
ALTER TABLE `tb_kandidat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `tb_settings`
--
ALTER TABLE `tb_settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=836198;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
