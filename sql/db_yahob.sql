-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2022 at 07:47 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_yahob`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `pic` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `nama`, `password`, `pic`) VALUES
(1, 'Graham', 'Graham', '$2y$10$Z0BkhKGUjoE03lRDtrsf8ePiZw6jypAZ6A3oAtg0AvrDmCZYBmCiO', 'img/admin.png');

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `pengarang` varchar(32) NOT NULL,
  `tahun` year(4) NOT NULL,
  `id_jenis` int(11) NOT NULL,
  `stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id`, `judul`, `pengarang`, `tahun`, `id_jenis`, `stok`) VALUES
(36, 'Fast-Track Your PROGRAMMING', 'Rayford M. Waller', 1991, 3, 3),
(37, 'Java Programming 1', 'Jacob, John', 2017, 5, 2),
(38, 'Java 2 : Network Programming', 'Setyabudi, Hadi', 2019, 5, 4),
(39, 'Analisis dan Desain Sistem', 'Kusumo, dkk', 2015, 4, 0),
(40, 'Brownis Cook-Receipt-Instruction by Robot', 'Sawi, Nugraha', 2018, 6, 3);

-- --------------------------------------------------------

--
-- Table structure for table `jenis_buku`
--

CREATE TABLE `jenis_buku` (
  `id` int(11) NOT NULL,
  `jenis` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jenis_buku`
--

INSERT INTO `jenis_buku` (`id`, `jenis`) VALUES
(1, 'Novel'),
(2, 'Non-Fiksi'),
(3, 'Umum'),
(4, 'Sistem Informasi'),
(5, 'Pemrograman'),
(6, 'Kecerdasan Buatan');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id` int(11) NOT NULL,
  `nim` varchar(9) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id`, `nim`, `nama`, `password`, `email`, `no_hp`, `alamat`) VALUES
(3, 'H1D021043', 'Irfan Priatna', '$2y$10$Iweyqdxn8nXpiTIierhaneBEDE4i8lTg3BsapjxCeYVs4YNSuxcdm', 'irfan.priatna@mhs.unsoed.ac.id', '0895375115609', 'Jalan In Aja No.333'),
(4, 'H1D0210xx', 'GrahamElías Domeño Moon', '$2y$10$SRFhSQuQzl3OvOpkq6Xc4OKUPIUS..Fzp3kknrR5BGlSOjfjOUICe', 'hvelias21@yopmail.com', '8882119', 'Calle b No. 328'),
(6, 'H1Z021035', 'Lembah Pratama', '$2y$10$p9b9TZIExwQehuEtldsgQeP/aoZeqfTpWNABOxqs2OvXyAvd2D3AS', 'sharyanti@aryani.tv', '(+62) 725 9021 ', 'Kpg. Sampangan No. 330, Banjar 59900, NTB '),
(7, 'H1Z021024', 'Ella Lestari', '$2y$10$3o0iJYDcD9IDbMNyoi1TZerfizY6uFTuEuwXid67iAHeu6pi0sa7a', 'blatupono@gmail.co.id', '0999 4387 9485', 'Gg. Halim No. 555, Jambi 58154, SulTra'),
(8, 'H1Z021021', 'Anggabaya Mangunsong', '$2y$10$dXWKqlcMYJkZqtkB9/5Fo.bgMaGzbnB57jlTtcCZ.4ZRmOCjC0tlK', 'nashiruddin.anastasia@gmail.co.id', '0238 0340 791', 'Jln. Asia Afrika No. 421, Yogyakarta 49343, KalUt');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int(11) NOT NULL,
  `id_buku` int(11) NOT NULL,
  `id_anggota` varchar(9) NOT NULL,
  `tanggal_pinjam` text NOT NULL,
  `tanggal_kembali` text NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `id_buku`, `id_anggota`, `tanggal_pinjam`, `tanggal_kembali`, `status`) VALUES
(67, 39, 'gadasiang', '2022-12-02 01:36:46pm', '', 'process'),
(68, 37, 'H1D0210xx', '2022-12-02 01:37:03pm', '', 'process'),
(69, 39, 'H1D0210xx', '2022-12-02 01:37:18pm', '2022-12-02 01:38:25pm', 'done'),
(70, 38, 'H1Z021021', '2022-12-02 01:37:37pm', '', 'process'),
(71, 40, 'H1Z021035', '2022-12-02 01:38:11pm', '2022-12-02 01:38:18pm', 'done'),
(72, 39, 'H1Z021035', '2022-12-02 01:39:36pm', '', 'book'),
(73, 39, 'gadasiang', '2022-12-02 01:44:41pm', '', 'book'),
(74, 36, 'maimunari', '2022-12-02 01:45:38pm', '', 'book');

-- --------------------------------------------------------

--
-- Table structure for table `tamu`
--

CREATE TABLE `tamu` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `nama` varchar(64) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tamu`
--

INSERT INTO `tamu` (`id`, `username`, `nama`, `password`, `email`, `no_hp`, `alamat`) VALUES
(3, 'priyana', 'priyana123', '$2y$10$cHdpdrTDn7h6FeF9Bg2dYeoJduTEPriRPP2lpYnOs3TyLGYPkJNk.', 'priyana@email.com', '70889074087', 'Jalan alamat'),
(5, 'gues', 'gues', '$2y$10$bwPXsRebq50ZrK44yY4n2eKvk1lI1ktbrS2CruW1BrYqc0UmUtL5S', 'gues@email.email', '1-089-248', '0480 -- Window street'),
(6, 'maimunari', 'Maimunah Mayasari', '$2y$10$/HYxBYBOCGb5KDJJjhNbO./dg/tPlA29jlgFLsCPq5tRfHRQHJ2Uu', 'elisa94@hakim.name', '(+62) 536 6993 ', ' Kpg. Juanda No. 436, Tangerang 60252, Lampung'),
(7, 'gadasiang', 'Gada Sihotang', '$2y$10$4fgTUAXNMVsUrAvc7Wd7merhhK5mQwwTJP2QM8roGzaHEF6u6UeyO', 'aditya46@nainggolan.name', '(+62) 879 2695 ', 'Gg. Antapani Lama No. 110, Tanjung Pinang 82265, SumSel'),
(8, 'balijan', 'Balijan Gunawan', '$2y$10$3X9/UK7MAXZ/hE7ZBDf34u6NuhHkJ2ec4rF3du39/JYxBYHtmUnuq', 'mustofa.jelita@yahoo.com', '(+62) 830 5615 ', 'Ki. Madiun No. 509, Tidore Kepulauan 82919, Aceh');

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
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_jenis` (`id_jenis`);

--
-- Indexes for table `jenis_buku`
--
ALTER TABLE `jenis_buku`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nim` (`nim`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_buku` (`id_buku`);

--
-- Indexes for table `tamu`
--
ALTER TABLE `tamu`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `jenis_buku`
--
ALTER TABLE `jenis_buku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `tamu`
--
ALTER TABLE `tamu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `fk_jenis` FOREIGN KEY (`id_jenis`) REFERENCES `jenis_buku` (`id`);

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `fk_buku` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
