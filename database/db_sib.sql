-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2020 at 07:07 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sib`
--

-- --------------------------------------------------------

--
-- Table structure for table `beasiswa`
--

CREATE TABLE `beasiswa` (
  `kd_bsw` char(3) NOT NULL,
  `nama_bsw` varchar(99) NOT NULL,
  `dtl_bsw` text NOT NULL,
  `tgl_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tgl_tutup` datetime NOT NULL,
  `tampilkan` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `beasiswa`
--

INSERT INTO `beasiswa` (`kd_bsw`, `nama_bsw`, `dtl_bsw`, `tgl_update`, `tgl_tutup`, `tampilkan`) VALUES
('01', 'Beasiswa Kebutuhan', 'Ditawarkan kepada mahasiswa minimal telah duduk di semester II yang mengalami kesulitan finansial.', '2020-06-21 09:42:41', '2020-06-22 00:00:00', 1),
('03', 'Pinjaman Registrasi', 'Ditawarkan kepada mahasiswa minimal telah duduk di semester II yang mengalami kesulitan finansial.', '2020-06-21 09:42:41', '2020-06-18 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `informasi`
--

CREATE TABLE `informasi` (
  `id_info` int(11) NOT NULL,
  `jdl_info` varchar(255) NOT NULL,
  `detail_info` text NOT NULL,
  `tgl_ditambah` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tgl_diubah` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tags` varchar(255) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `informasi`
--

INSERT INTO `informasi` (`id_info`, `jdl_info`, `detail_info`, `tgl_ditambah`, `tgl_diubah`, `tags`, `status`) VALUES
(1, 'Pengumuman', 'Program Online Academy (OA) merupakan program beasiswa pelatihan dan sertifikasi ditujukan kepada 10.000 peserta terpilih yang ingin meningkatkan keterampilan di bidang IT. Program Online Academy merupakan kerjasama Kementerian Komunikasi dan Informatika dengan Global Techology Company.\r\n\r\nMateri Pelatihan dalam Online Academy disusun oleh Global Technology Company yang bertujuan untuk memenuhi kebutuhan sumber daya manusia di bidang IT dan meningkatkan kompetensi sumber daya manusia Indonesia yang memiliki keahlian di bidang profesi masing-masing untuk memperoleh kompetensi tambahan serta menciptakan sumber daya manusia yang lebih adaptif dan produktif dengan mengoptimalisasi teknologi, Online Academy juga bertujuan untuk meningkatkan kualitas sumber daya manusia di bidang IT demi memenangkan persaingan global.', '2020-06-21 10:03:30', '2020-06-21 12:05:31', '', 1),
(2, 'Pengumuman', 'Program Online Academy (OA) merupakan program beasiswa pelatihan dan sertifikasi ditujukan kepada 10.000 peserta terpilih yang ingin meningkatkan keterampilan di bidang IT. Program Online Academy merupakan kerjasama Kementerian Komunikasi dan Informatika dengan Global Techology Company.\r\n\r\nMateri Pelatihan dalam Online Academy disusun oleh Global Technology Company yang bertujuan untuk memenuhi kebutuhan sumber daya manusia di bidang IT dan meningkatkan kompetensi sumber daya manusia Indonesia yang memiliki keahlian di bidang profesi masing-masing untuk memperoleh kompetensi tambahan serta menciptakan sumber daya manusia yang lebih adaptif dan produktif dengan mengoptimalisasi teknologi, Online Academy juga bertujuan untuk meningkatkan kualitas sumber daya manusia di bidang IT demi memenangkan persaingan global.', '2020-06-21 10:03:30', '2020-06-21 12:05:31', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `kd_bayar` int(11) NOT NULL,
  `kd_daftar` char(8) NOT NULL,
  `tgl_bayar` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nominal_bayar` int(11) NOT NULL,
  `semester` char(5) NOT NULL,
  `kd_sts_bayar` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `kd_daftar` char(8) NOT NULL,
  `nim` char(8) NOT NULL,
  `kd_bsw` char(3) NOT NULL,
  `tgl_daftar` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `semester` char(9) NOT NULL,
  `thn_ajaran` char(6) NOT NULL,
  `nominal_pengajuan` int(11) NOT NULL,
  `nominal_disetujui` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ref_fakultas`
--

CREATE TABLE `ref_fakultas` (
  `kd_fakultas` char(2) NOT NULL,
  `nama_fakultas` varchar(99) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ref_fakultas`
--

INSERT INTO `ref_fakultas` (`kd_fakultas`, `nama_fakultas`) VALUES
('1', 'Fakultas Teknologi Informasi');

-- --------------------------------------------------------

--
-- Table structure for table `ref_gender`
--

CREATE TABLE `ref_gender` (
  `gender` char(1) NOT NULL,
  `nama_gender` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ref_gender`
--

INSERT INTO `ref_gender` (`gender`, `nama_gender`) VALUES
('1', 'Pria'),
('2', 'Wanita');

-- --------------------------------------------------------

--
-- Table structure for table `ref_prodi`
--

CREATE TABLE `ref_prodi` (
  `kd_prodi` char(2) NOT NULL,
  `nama_prodi` varchar(99) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ref_prodi`
--

INSERT INTO `ref_prodi` (`kd_prodi`, `nama_prodi`) VALUES
('71', 'Informatika'),
('72', 'Sistem Informasi');

-- --------------------------------------------------------

--
-- Table structure for table `ref_role`
--

CREATE TABLE `ref_role` (
  `id_role` int(1) NOT NULL,
  `nama_role` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ref_role`
--

INSERT INTO `ref_role` (`id_role`, `nama_role`) VALUES
(1, 'Administrator'),
(2, 'Wakil Dekan 3 Fakultas'),
(3, 'Mahasiswa');

-- --------------------------------------------------------

--
-- Table structure for table `ref_sts_bayar`
--

CREATE TABLE `ref_sts_bayar` (
  `kd_sts_byr` char(2) NOT NULL,
  `sts_byr` varchar(99) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ref_sts_bayar`
--

INSERT INTO `ref_sts_bayar` (`kd_sts_byr`, `sts_byr`) VALUES
('1', 'Dikonfirmasi'),
('2', 'Sedang Dikonfirmasi'),
('3', 'Mohon menggunjungi Biro 3');

-- --------------------------------------------------------

--
-- Table structure for table `ref_syarat`
--

CREATE TABLE `ref_syarat` (
  `kd_syarat` char(3) NOT NULL,
  `nama_syarat` varchar(99) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `syarat_bsw`
--

CREATE TABLE `syarat_bsw` (
  `kd_syarat_bsw` int(11) NOT NULL,
  `kd_syarat` char(3) NOT NULL,
  `kd_bsw` char(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `syarat_daftar`
--

CREATE TABLE `syarat_daftar` (
  `kd_syarat_dftr` int(11) NOT NULL,
  `kd_daftar` char(8) NOT NULL,
  `kd_syarat_bsw` int(11) NOT NULL,
  `isi_syarat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_acc`
--

CREATE TABLE `user_acc` (
  `id_acc` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_acc` varchar(99) NOT NULL,
  `gender` char(1) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `email` varchar(99) NOT NULL,
  `alamat` varchar(999) NOT NULL,
  `kode_pos` char(5) NOT NULL,
  `no_telp` char(12) NOT NULL,
  `kd_fakultas` char(2) NOT NULL,
  `kd_prodi` char(2) NOT NULL,
  `kd_role` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_acc`
--

INSERT INTO `user_acc` (`id_acc`, `username`, `password`, `nama_acc`, `gender`, `tgl_lahir`, `email`, `alamat`, `kode_pos`, `no_telp`, `kd_fakultas`, `kd_prodi`, `kd_role`) VALUES
(1, 'willy', '$2y$10$biOI1T7.vdq0kgCOmv6vC.ndpob2oi26QqCmWg4wcxrJV9K8FR8Qu', '', '1', '2020-06-02', '', '', '', '', '1', '0', '3');

-- --------------------------------------------------------

--
-- Table structure for table `user_admin`
--

CREATE TABLE `user_admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_admin` varchar(99) NOT NULL,
  `gender` char(1) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `email` varchar(99) NOT NULL,
  `alamat` varchar(999) NOT NULL,
  `kode_pos` char(5) NOT NULL,
  `no_telp` char(12) NOT NULL,
  `kd_role` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_admin`
--

INSERT INTO `user_admin` (`id_admin`, `username`, `password`, `nama_admin`, `gender`, `tgl_lahir`, `email`, `alamat`, `kode_pos`, `no_telp`, `kd_role`) VALUES
(1, 'admin', '$2y$10$biOI1T7.vdq0kgCOmv6vC.ndpob2oi26QqCmWg4wcxrJV9K8FR8Qu', '', '', '0000-00-00', '', '', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `beasiswa`
--
ALTER TABLE `beasiswa`
  ADD PRIMARY KEY (`kd_bsw`);

--
-- Indexes for table `informasi`
--
ALTER TABLE `informasi`
  ADD PRIMARY KEY (`id_info`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`kd_bayar`),
  ADD KEY `pengembalian_ibfk_1` (`kd_daftar`),
  ADD KEY `kd_sts_bayar` (`kd_sts_bayar`);

--
-- Indexes for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`kd_daftar`),
  ADD KEY `nim` (`nim`),
  ADD KEY `kode_bsw` (`kd_bsw`);

--
-- Indexes for table `ref_fakultas`
--
ALTER TABLE `ref_fakultas`
  ADD PRIMARY KEY (`kd_fakultas`),
  ADD KEY `kd_fakultas` (`kd_fakultas`) USING BTREE;

--
-- Indexes for table `ref_gender`
--
ALTER TABLE `ref_gender`
  ADD PRIMARY KEY (`gender`);

--
-- Indexes for table `ref_prodi`
--
ALTER TABLE `ref_prodi`
  ADD PRIMARY KEY (`kd_prodi`);

--
-- Indexes for table `ref_role`
--
ALTER TABLE `ref_role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indexes for table `ref_sts_bayar`
--
ALTER TABLE `ref_sts_bayar`
  ADD PRIMARY KEY (`kd_sts_byr`);

--
-- Indexes for table `ref_syarat`
--
ALTER TABLE `ref_syarat`
  ADD PRIMARY KEY (`kd_syarat`);

--
-- Indexes for table `syarat_bsw`
--
ALTER TABLE `syarat_bsw`
  ADD PRIMARY KEY (`kd_syarat_bsw`),
  ADD KEY `kd_syarat` (`kd_syarat`),
  ADD KEY `kd_bsw` (`kd_bsw`);

--
-- Indexes for table `syarat_daftar`
--
ALTER TABLE `syarat_daftar`
  ADD PRIMARY KEY (`kd_syarat_dftr`),
  ADD KEY `kd_daftar` (`kd_daftar`),
  ADD KEY `syarat_daftar_ibfk_2` (`kd_syarat_bsw`);

--
-- Indexes for table `user_acc`
--
ALTER TABLE `user_acc`
  ADD PRIMARY KEY (`id_acc`),
  ADD KEY `gender` (`gender`),
  ADD KEY `kd_fakultas` (`kd_fakultas`) USING BTREE,
  ADD KEY `role` (`kd_role`);

--
-- Indexes for table `user_admin`
--
ALTER TABLE `user_admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD KEY `gender` (`gender`),
  ADD KEY `role` (`kd_role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `informasi`
--
ALTER TABLE `informasi`
  MODIFY `id_info` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `kd_bayar` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ref_role`
--
ALTER TABLE `ref_role`
  MODIFY `id_role` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `syarat_bsw`
--
ALTER TABLE `syarat_bsw`
  MODIFY `kd_syarat_bsw` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `syarat_daftar`
--
ALTER TABLE `syarat_daftar`
  MODIFY `kd_syarat_dftr` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_acc`
--
ALTER TABLE `user_acc`
  MODIFY `id_acc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_admin`
--
ALTER TABLE `user_admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`kd_daftar`) REFERENCES `pendaftaran` (`kd_daftar`),
  ADD CONSTRAINT `pembayaran_ibfk_2` FOREIGN KEY (`kd_sts_bayar`) REFERENCES `ref_sts_bayar` (`kd_sts_byr`);

--
-- Constraints for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD CONSTRAINT `pendaftaran_ibfk_1` FOREIGN KEY (`nim`) REFERENCES `user_mhs` (`NIM`),
  ADD CONSTRAINT `pendaftaran_ibfk_2` FOREIGN KEY (`kd_bsw`) REFERENCES `beasiswa` (`kd_bsw`);

--
-- Constraints for table `syarat_bsw`
--
ALTER TABLE `syarat_bsw`
  ADD CONSTRAINT `syarat_bsw_ibfk_1` FOREIGN KEY (`kd_syarat`) REFERENCES `ref_syarat` (`kd_syarat`),
  ADD CONSTRAINT `syarat_bsw_ibfk_2` FOREIGN KEY (`kd_bsw`) REFERENCES `beasiswa` (`kd_bsw`);

--
-- Constraints for table `syarat_daftar`
--
ALTER TABLE `syarat_daftar`
  ADD CONSTRAINT `syarat_daftar_ibfk_1` FOREIGN KEY (`kd_daftar`) REFERENCES `pendaftaran` (`kd_daftar`),
  ADD CONSTRAINT `syarat_daftar_ibfk_2` FOREIGN KEY (`kd_syarat_bsw`) REFERENCES `syarat_bsw` (`kd_syarat_bsw`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
