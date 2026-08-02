-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 25 Jul 2026 pada 03.10
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

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
-- Struktur dari tabel `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id_admin` int NOT NULL,
  `nama` varchar(50) NOT NULL,
  `kelas` varchar(20) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `tb_admin`
--

INSERT INTO `tb_admin` (`id_admin`, `nama`, `kelas`, `password`) VALUES
(10, 'Febri Pratama', '12 RPL 1', 'piketos2026');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kandidat`
--

CREATE TABLE `tb_kandidat` (
  `id` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `visi` text NOT NULL,
  `misi` text NOT NULL,
  `image` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `tb_kandidat`
--

INSERT INTO `tb_kandidat` (`id`, `nama`, `visi`, `misi`, `image`) VALUES
(1, 'Febri', 'menjadikan smk informatika menjadi maju', 'mengubah menjadi smk dengan gaya profesional religius', ''),
(2, 'fahri nasluroh', 'menjadi siswa yang aktif dan unggul', 'menjadi smk informatika yang aman yang nyaman untuk belajar ', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_siswa`
--

CREATE TABLE `tb_siswa` (
  `token` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kelas` varchar(20) NOT NULL,
  `status` tinyint(1) DEFAULT '0',
  `voted` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `tb_siswa`
--

INSERT INTO `tb_siswa` (`token`, `nama`, `kelas`, `status`, `voted`) VALUES
('0206', 'Nexdy experiment', '11 RPL 1', 1, 1),
('25D3', 'Nexdy experiment', '11 RPL 1', 0, 0),
('89P7', 'Nexdy experiment', '11 RPL 1', 0, 0),
('ABCD', 'febri pratama', '11 RPL 1', 0, 0),
('DFJK', 'muhammad ramdhani ', '11 RPL 1', 0, 0),
('HIJK', 'aditya anugrah', '11 RPL 1', 0, 0),
('NXYZ', 'Nexdy experiment', '11 RPL 1', 0, 0),
('ONBE', 'Nexdy experiment', '11 RPL 1', 0, 0),
('OPQR', 'fahri nasluroh', '11 RPL 1', 0, 0),
('RSTU', 'cahya permana', '11 RPL 1', 0, 0),
('TUVW', 'ridwan saepuloh', '11 RPL 1', 0, 0),
('TZ8B', 'Nexdy experiment', '11 RPL 1', 0, 0),
('X8O5', 'Nexdy experiment', '11 RPL 1', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `tb_kandidat`
--
ALTER TABLE `tb_kandidat`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD PRIMARY KEY (`token`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tb_kandidat`
--
ALTER TABLE `tb_kandidat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
