-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2021 at 05:55 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spplte`
--

-- --------------------------------------------------------

--
-- Table structure for table `agenda`
--

CREATE TABLE `agenda` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `warna` varchar(7) DEFAULT NULL,
  `tgl_mulai` datetime NOT NULL,
  `tgl_selesai` datetime DEFAULT NULL,
  `stdel` int(11) NOT NULL DEFAULT '0',
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `agenda`
--

INSERT INTO `agenda` (`id`, `nama`, `warna`, `tgl_mulai`, `tgl_selesai`, `stdel`, `cby`, `cdate`, `uby`, `udate`, `dby`, `ddate`) VALUES
(7, '  123', '#008000', '2020-12-29 00:00:00', '2020-12-30 00:00:00', 1, 1, '2021-01-17 16:14:36', 1, '2021-01-17 16:44:08', 1, '2021-01-17 16:44:13'),
(8, 'COBA AGENDA', '#40E0D0', '2021-01-11 00:00:00', '2021-01-12 00:00:00', 0, 1, '2021-01-17 16:44:41', 1, '2021-01-20 09:07:43', NULL, NULL),
(9, 'dsadsad', '#008000', '2021-01-04 00:00:00', '2021-01-05 00:00:00', 1, 1, '2021-01-17 16:45:40', 1, '2021-01-17 16:47:53', 1, '2021-01-17 16:47:57'),
(10, '12344', '#0071c5', '2021-01-06 00:00:00', '2021-01-07 00:00:00', 1, 1, '2021-01-18 23:47:00', 1, '2021-01-18 23:47:41', 1, '2021-01-18 23:47:47'),
(11, 'APA AJA', '#FF0000', '2021-02-08 00:00:00', '2021-02-09 00:00:00', 1, 1, '2021-02-08 01:52:33', 1, '2021-02-08 01:53:41', 1, '2021-02-08 01:53:51'),
(12, 'fdfsdfdsf', '#40E0D0', '2021-02-06 00:00:00', '2021-02-10 00:00:00', 1, 1, '2021-02-08 01:53:59', 1, '2021-02-08 01:54:13', 1, '2021-02-11 22:34:39');

-- --------------------------------------------------------

--
-- Table structure for table `akun_biaya`
--

CREATE TABLE `akun_biaya` (
  `idAkun` int(11) NOT NULL,
  `idSubAkun` int(11) DEFAULT NULL,
  `kodeAkun` varchar(20) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `jenisAkun` enum('Akun Utama','Sub Menu 1','Sub Menu 2','Sub Menu 3') NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `unitSekolah` int(11) NOT NULL,
  `saldo_awal_debit` double DEFAULT NULL,
  `saldo_awal_kredit` double DEFAULT NULL,
  `stdel` int(11) DEFAULT '0',
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `akun_biaya`
--

INSERT INTO `akun_biaya` (`idAkun`, `idSubAkun`, `kodeAkun`, `keterangan`, `jenisAkun`, `kategori`, `unitSekolah`, `saldo_awal_debit`, `saldo_awal_kredit`, `stdel`, `cby`, `cdate`, `uby`, `udate`, `dby`, `ddate`) VALUES
(1, NULL, '1-10000', 'AKTIVA', 'Akun Utama', '#', 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 1, '1-10100', 'Aktiva', 'Sub Menu 1', '#', 5, NULL, NULL, 1, 1, '2021-01-28 01:15:24', 1, '2021-01-28 01:16:19', 1, '2021-01-28 01:16:23'),
(4, 1, '1-10100', 'Aktiva SMP TMI', 'Sub Menu 1', '#', 5, NULL, NULL, 0, 1, '2021-01-28 01:17:16', 1, '2021-02-14 00:31:57', NULL, NULL),
(5, 1, '1-10200', 'Aktiva SMA TMI', 'Sub Menu 1', '#', 6, NULL, NULL, 0, 1, '2021-01-28 01:17:27', 1, '2021-02-14 00:32:28', NULL, NULL),
(6, 1, '1-10300', 'Aktiva Tahfidz', 'Sub Menu 1', '#', 1, NULL, NULL, 0, 1, '2021-01-28 01:17:33', 1, '2021-02-14 00:32:51', NULL, NULL),
(7, 4, '1-10101', 'Kas Tunai SMP TMI', 'Sub Menu 2', 'Keuangan', 5, 0, 0, 0, 1, '2021-01-28 01:25:02', 1, '2021-02-14 00:32:07', NULL, NULL),
(8, 4, '1-10102', 'Kas Bank  SMP TMI', 'Sub Menu 2', 'Keuangan', 5, 0, 0, 0, 1, '2021-01-28 01:26:46', 1, '2021-02-14 00:32:13', NULL, NULL),
(10, NULL, '2-20000', 'PASIVA', 'Akun Utama', '#', 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 4, '1-10103', 'ffff', 'Sub Menu 2', 'Keuangan', 1, 0, 0, 1, 1, '2021-01-28 01:51:07', NULL, NULL, 1, '2021-01-28 01:51:11'),
(12, 7, '1-10101.1', 'sss1111', 'Sub Menu 3', 'Pembayaran', 6, NULL, NULL, 1, 1, '2021-01-28 01:54:57', 1, '2021-01-28 02:02:46', 1, '2021-01-28 02:02:57'),
(13, 5, '1-10201', 'Kas Tunai SMA TMI', 'Sub Menu 2', 'Keuangan', 6, 0, 0, 0, 1, '2021-01-28 02:04:24', 1, '2021-02-14 00:32:35', NULL, NULL),
(14, 5, '1-10202', 'Kas Bank SMA TMI', 'Sub Menu 2', 'Keuangan', 6, 0, 0, 0, 1, '2021-01-28 02:04:32', 1, '2021-02-14 00:32:40', NULL, NULL),
(15, 6, '1-10301', 'Kas Tunai Tahfidz', 'Sub Menu 2', 'Keuangan', 1, 0, 0, 0, 1, '2021-01-28 02:04:54', 1, '2021-02-14 00:33:00', NULL, NULL),
(16, 6, '1-10302', 'Kas Bank Tahfidz', 'Sub Menu 2', 'Keuangan', 1, 0, 0, 0, 1, '2021-01-28 02:05:06', 1, '2021-02-14 00:33:11', NULL, NULL),
(17, NULL, '3-30000', 'MODAL', 'Akun Utama', '#', 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(18, NULL, '4-40000', 'PENDAPATAN', 'Akun Utama', '#', 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(19, NULL, '5-50000', 'BEBAN', 'Akun Utama', '#', 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 18, '4-40100', 'Pendapatan SMP TMI', 'Sub Menu 1', '#', 5, NULL, NULL, 0, 1, '2021-01-28 02:06:50', 1, '2021-02-14 00:38:19', NULL, NULL),
(21, 20, '4-40101', 'SPP SMP TMI', 'Sub Menu 2', 'Pembayaran', 5, 0, 0, 0, 1, '2021-01-28 02:07:23', 1, '2021-02-14 00:38:26', NULL, NULL),
(22, 20, '4-40102', 'DU Smt-1 SMP TMI', 'Sub Menu 2', 'Pembayaran', 5, 0, 0, 0, 1, '2021-01-28 02:07:50', 1, '2021-02-14 00:38:33', NULL, NULL),
(23, 20, '4-40103', 'DU Smt-2 SMP TMI', 'Sub Menu 2', 'Pembayaran', 5, 0, 0, 0, 1, '2021-01-28 02:08:03', 1, '2021-02-14 00:38:39', NULL, NULL),
(24, 20, '4-40104', 'ZIS donatur SMP TMI', 'Sub Menu 2', 'Keuangan', 5, 0, 0, 0, 1, '2021-01-28 02:08:22', 1, '2021-02-14 00:38:47', NULL, NULL),
(25, 20, '4-40105', 'Dana BOS Daerah SMP TMI', 'Sub Menu 2', 'Keuangan', 5, 0, 0, 0, 1, '2021-01-28 02:08:38', 1, '2021-02-14 00:38:58', NULL, NULL),
(26, 20, '4-40106', 'Tunggakan TA lalu SMP TMI', 'Sub Menu 2', 'Pembayaran', 5, 0, 0, 0, 1, '2021-01-28 02:08:51', 1, '2021-02-14 00:39:11', NULL, NULL),
(27, 20, '4-40107', 'Sarana Santri Baru SMP TMI', 'Sub Menu 2', 'Pembayaran', 5, 0, 0, 0, 1, '2021-01-28 02:09:07', 1, '2021-02-14 00:39:21', NULL, NULL),
(28, 20, '4-40108', 'Kitab Santri Baru SMP TMI', 'Sub Menu 2', 'Pembayaran', 5, 0, 0, 0, 1, '2021-01-28 02:09:51', 1, '2021-02-14 00:39:27', NULL, NULL),
(29, 1, '1-10400', 'Piutang SMP TMI', 'Sub Menu 1', '#', 5, NULL, NULL, 0, 1, '2021-01-28 02:13:36', 1, '2021-02-14 00:37:01', NULL, NULL),
(30, 1, '1-10500', 'Piutang SMA TMI', 'Sub Menu 1', '#', 6, NULL, NULL, 0, 1, '2021-01-28 02:13:50', 1, '2021-02-14 00:37:42', NULL, NULL),
(31, 1, '1-10600', 'Piutang Tahfidz', 'Sub Menu 1', '#', 1, NULL, NULL, 0, 1, '2021-01-28 02:14:03', 1, '2021-02-14 00:35:30', NULL, NULL),
(32, 29, '1-10401', 'Piutang Siswa SMP TMI', 'Sub Menu 2', 'Keuangan', 5, 0, 0, 0, 1, '2021-01-28 02:14:24', 1, '2021-02-14 00:36:49', NULL, NULL),
(33, 30, '1-10501', 'Piutang Siswa SMA TMI', 'Sub Menu 2', 'Keuangan', 6, 0, 0, 0, 1, '2021-01-28 02:14:33', 1, '2021-02-14 00:37:53', NULL, NULL),
(34, 31, '1-10601', 'Piutang Siswa Tahfidz', 'Sub Menu 2', 'Keuangan', 1, 0, 0, 0, 1, '2021-01-28 02:14:44', 1, '2021-02-14 00:33:25', NULL, NULL),
(35, 18, '4-40200', 'Pendapatan SMA TMI', 'Sub Menu 1', '#', 6, NULL, NULL, 0, 1, '2021-01-28 19:11:04', 1, '2021-02-14 00:39:53', NULL, NULL),
(36, 35, '4-40201', 'SPP SMA TMI', 'Sub Menu 2', 'Pembayaran', 6, 0, 0, 0, 1, '2021-01-28 19:11:50', 1, '2021-02-14 00:39:45', NULL, NULL),
(37, 35, '4-40202', 'DU Smt-1 SMA TMI', 'Sub Menu 2', 'Pembayaran', 6, 0, 0, 0, 1, '2021-01-28 19:12:08', 1, '2021-02-14 00:40:03', NULL, NULL),
(38, 35, '4-40203', 'DU Smt-2 SMA TMI', 'Sub Menu 2', 'Pembayaran', 6, 0, 0, 0, 1, '2021-01-28 19:12:20', 1, '2021-02-14 00:40:11', NULL, NULL),
(39, 35, '4-40204', 'ZIS donatur SMA TMI', 'Sub Menu 2', 'Keuangan', 6, 0, 0, 0, 1, '2021-01-28 19:12:47', 1, '2021-02-14 00:40:17', NULL, NULL),
(40, 35, '4-40205', 'Dana BOS Daerah SMA TMI', 'Sub Menu 2', 'Keuangan', 6, 0, 0, 0, 1, '2021-01-28 19:13:08', 1, '2021-02-14 00:40:26', NULL, NULL),
(41, 35, '4-40206', 'Tunggakan TA lalu SMA TMI', 'Sub Menu 2', 'Pembayaran', 6, 0, 0, 0, 1, '2021-01-28 19:13:27', 1, '2021-02-14 00:40:36', NULL, NULL),
(42, 35, '4-40207', 'Sarana Santri Baru SMA TMI', 'Sub Menu 2', 'Pembayaran', 6, 0, 0, 0, 1, '2021-01-28 19:13:43', 1, '2021-02-14 00:40:45', NULL, NULL),
(43, 35, '4-40208', 'IURAN PENGOBATAN SMA TMI', 'Sub Menu 2', 'Pembayaran', 6, 0, 0, 0, 1, '2021-01-28 19:14:02', 1, '2021-02-14 00:40:59', NULL, NULL),
(44, 35, '4-40209', 'Kitab Santri Baru SMA TMI', 'Sub Menu 2', 'Pembayaran', 6, 0, 0, 0, 1, '2021-01-28 19:14:20', 1, '2021-02-14 00:41:08', NULL, NULL),
(45, 18, '4-40300', 'Pendapatan Tahfidz', 'Sub Menu 1', '#', 1, NULL, NULL, 0, 1, '2021-01-28 19:16:05', 1, '2021-02-14 00:41:35', NULL, NULL),
(46, 45, '4-40301', 'SPP Tahfidz', 'Sub Menu 2', 'Pembayaran', 1, 0, 0, 0, 1, '2021-01-28 19:16:44', 1, '2021-02-14 00:33:43', NULL, NULL),
(47, 45, '4-40302', 'ZIS donatur Tahfidz', 'Sub Menu 2', 'Keuangan', 1, 0, 0, 0, 1, '2021-01-28 19:16:59', 1, '2021-02-14 00:34:45', NULL, NULL),
(48, 45, '4-40303', 'Daftar Ulang Santri Baru Tahfidz', 'Sub Menu 2', 'Pembayaran', 1, 0, 0, 0, 1, '2021-01-28 19:17:14', 1, '2021-02-14 00:34:56', NULL, NULL),
(49, 45, '4-40304', 'Tunggakan TA lalu Tahfidz', 'Sub Menu 2', 'Pembayaran', 1, 0, 0, 0, 1, '2021-01-28 19:17:29', 1, '2021-02-14 00:35:05', NULL, NULL),
(50, 1, '1-10700', 'Kas Bank', 'Sub Menu 1', '#', 5, NULL, NULL, 1, 1, '2021-01-30 23:10:21', NULL, NULL, 1, '2021-01-30 23:12:22'),
(51, 50, '1-10701', '222', 'Sub Menu 2', 'Pembayaran', 5, 0, 0, 1, 1, '2021-01-30 23:10:36', NULL, NULL, 1, '2021-01-30 23:12:16'),
(52, 19, '5-50100', 'Pengeluaran SMP TMI', 'Sub Menu 1', '#', 5, NULL, NULL, 0, 1, '2021-02-01 10:14:35', 1, '2021-02-14 00:41:56', NULL, NULL),
(53, 52, '5-50101', 'Biaya Gaji SMP TMI', 'Sub Menu 2', 'Keuangan', 5, 0, 0, 0, 1, '2021-02-01 10:15:00', 1, '2021-02-14 00:42:05', NULL, NULL),
(54, 52, '5-50102', 'Biaya ATK SMP TMI', 'Sub Menu 2', 'Keuangan', 5, 0, 0, 0, 1, '2021-02-01 10:15:15', 1, '2021-02-14 00:42:11', NULL, NULL),
(55, 52, '5-50103', 'Biaya Perawatan Elektronik SMP TMI', 'Sub Menu 2', 'Keuangan', 5, 0, 0, 0, 1, '2021-02-01 10:15:32', 1, '2021-02-14 00:42:19', NULL, NULL),
(56, 52, '5-50104', 'Biaya Perjalanan Dinas SMP TMI', 'Sub Menu 2', 'Keuangan', 5, 0, 0, 0, 1, '2021-02-01 10:15:47', 1, '2021-02-14 00:42:35', NULL, NULL),
(57, 19, '5-50200', 'Pengeluaran SMA TMI', 'Sub Menu 1', '#', 6, NULL, NULL, 0, 1, '2021-02-01 10:16:04', 1, '2021-02-14 00:42:45', NULL, NULL),
(58, 57, '5-50201', 'Biaya Gaji SMA TMI', 'Sub Menu 2', 'Keuangan', 6, 0, 0, 0, 1, '2021-02-01 10:16:24', 1, '2021-02-14 00:42:55', NULL, NULL),
(59, 57, '5-50202', 'Biaya ATK SMA TMI', 'Sub Menu 2', 'Keuangan', 6, 0, 0, 0, 1, '2021-02-01 10:16:39', 1, '2021-02-14 00:43:07', NULL, NULL),
(60, 57, '5-50203', 'Biaya Perawatan Elektronik SMA TMI', 'Sub Menu 2', 'Keuangan', 6, 0, 0, 0, 1, '2021-02-01 10:16:53', 1, '2021-02-14 00:43:18', NULL, NULL),
(61, 57, '5-50204', 'Biaya Perjalanan Dinas SMA TMI', 'Sub Menu 2', 'Keuangan', 6, 0, 0, 0, 1, '2021-02-01 10:17:08', 1, '2021-02-14 00:43:25', NULL, NULL),
(62, 19, '5-50300', 'Pengeluaran Tahfidz', 'Sub Menu 1', '#', 1, NULL, NULL, 0, 1, '2021-02-01 10:17:23', 1, '2021-02-14 00:34:30', NULL, NULL),
(63, 62, '5-50301', 'Biaya Gaji Tahfidz', 'Sub Menu 2', 'Keuangan', 1, 0, 0, 0, 1, '2021-02-01 10:17:40', 1, '2021-02-14 00:34:23', NULL, NULL),
(64, 62, '5-50302', 'Biaya ATK Tahfidz', 'Sub Menu 2', 'Keuangan', 1, 0, 0, 0, 1, '2021-02-01 10:17:53', 1, '2021-02-14 00:34:11', NULL, NULL),
(65, 62, '5-50303', 'Biaya Perawatan Elektronik Tahfidz', 'Sub Menu 2', 'Keuangan', 1, 0, 0, 0, 1, '2021-02-01 10:18:07', 1, '2021-02-14 00:34:03', NULL, NULL),
(66, 62, '5-50304', 'Biaya Perjalanan Dinas Tahfidz', 'Sub Menu 2', 'Keuangan', 1, 0, 0, 0, 1, '2021-02-01 10:18:20', 1, '2021-02-14 00:33:52', NULL, NULL),
(67, 10, '2-20100', 'Hutang SMP TMI', 'Sub Menu 1', '#', 5, NULL, NULL, 0, 1, '2021-02-01 21:21:42', 1, '2021-02-14 00:37:13', NULL, NULL),
(68, 67, '2-20101', 'Hutang Pegawai SMP TMI', 'Sub Menu 2', 'Keuangan', 5, 0, 0, 0, 1, '2021-02-01 21:21:58', 1, '2021-02-14 00:37:23', NULL, NULL),
(69, 17, '3-30100', 'Modal Tahfidz', 'Sub Menu 1', '#', 1, NULL, NULL, 0, 1, '2021-02-14 03:20:31', NULL, NULL, NULL, NULL),
(70, 69, '3-30101', 'Modal Tahfidz', 'Sub Menu 2', 'Keuangan', 1, 0, 0, 0, 1, '2021-02-14 03:20:53', 1, '2021-02-15 03:43:36', NULL, NULL),
(71, 17, '3-30200', 'Modal SMP TMI', 'Sub Menu 1', '#', 5, NULL, NULL, 0, 1, '2021-02-15 03:43:56', NULL, NULL, NULL, NULL),
(72, 17, '3-30300', 'Modal SMA TMI', 'Sub Menu 1', '#', 6, NULL, NULL, 0, 1, '2021-02-15 03:44:10', NULL, NULL, NULL, NULL),
(73, 71, '3-30201', 'Modal SMP TMI', 'Sub Menu 2', 'Keuangan', 5, 0, 0, 0, 1, '2021-02-15 03:44:34', NULL, NULL, NULL, NULL),
(74, 72, '3-30301', 'Modal SMA TMI', 'Sub Menu 2', 'Keuangan', 6, 0, 0, 0, 1, '2021-02-15 03:44:51', NULL, NULL, NULL, NULL),
(75, 1, '1-10700', 'Akun Bank ', 'Sub Menu 1', '#', 1, NULL, NULL, 0, 1, '2021-04-09 03:22:57', 1, '2021-04-10 11:58:40', NULL, NULL),
(76, 1, '1-10800', 'Akun Tunai', 'Sub Menu 1', '#', 1, NULL, NULL, 0, 1, '2021-04-09 22:01:45', 1, '2021-04-10 11:58:51', NULL, NULL),
(77, 1, '1-10900', 'Akun Bank', 'Sub Menu 1', '#', 5, NULL, NULL, 0, 1, '2021-04-10 12:02:23', 1, '2021-04-10 12:04:24', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `angsurantoko`
--

CREATE TABLE `angsurantoko` (
  `id_angsurantoko` varchar(10) NOT NULL,
  `id_hutangtoko` varchar(10) NOT NULL,
  `tanggal` date NOT NULL,
  `angsuran` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `angsurantoko`
--

INSERT INTO `angsurantoko` (`id_angsurantoko`, `id_hutangtoko`, `tanggal`, `angsuran`) VALUES
('AP001', 'HT001', '2019-11-05', 2000),
('AP002', 'HT001', '2020-01-16', 3000),
('AP003', 'HT001', '2020-01-25', 3),
('AP004', 'HT002', '2020-01-25', 600000),
('AP005', 'HT003', '2020-01-26', 120000),
('AP006', 'HT001', '2020-01-26', 440000),
('AP007', 'HT003', '2020-01-27', 100000),
('AP008', 'HT001', '2020-02-18', 20000),
('AP009', 'HT004', '2020-02-18', 200000),
('AP010', 'HT005', '2020-02-23', 100000),
('AP011', 'HT003', '2020-03-09', 0),
('AP012', 'HT007', '2020-03-11', 100000),
('AP013', 'HT008', '2020-03-11', 250000000),
('AP014', 'HT008', '2020-03-11', 250000000),
('AP015', 'HT009', '2020-04-28', 50000),
('AP016', 'HT001', '2020-06-10', 0);

-- --------------------------------------------------------

--
-- Table structure for table `bulan`
--

CREATE TABLE `bulan` (
  `idBulan` varchar(15) NOT NULL DEFAULT '0',
  `nmBulan` varchar(25) DEFAULT NULL,
  `urutan` int(2) DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bulan`
--

INSERT INTO `bulan` (`idBulan`, `nmBulan`, `urutan`, `uby`, `udate`) VALUES
('1', 'Januari', 7, NULL, NULL),
('10', 'Oktober', 4, NULL, NULL),
('11', 'November', 5, NULL, NULL),
('12', 'Desember', 6, NULL, NULL),
('2', 'Februari', 8, NULL, NULL),
('3', 'Maret', 9, NULL, NULL),
('4', 'April', 10, NULL, NULL),
('5', 'Mei', 11, NULL, NULL),
('6', 'Juni', 12, NULL, NULL),
('7', 'Juli', 1, 1, '2021-01-25 01:38:48'),
('8', 'Agustus', 2, 1, '2021-01-19 01:06:50'),
('9', 'September', 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hutangtoko`
--

CREATE TABLE `hutangtoko` (
  `id_hutangtoko` varchar(10) NOT NULL,
  `hutangke` varchar(50) NOT NULL,
  `tanggal` date NOT NULL,
  `ket` varchar(100) NOT NULL,
  `nominal` int(11) NOT NULL,
  `sisa` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `hutang_bayar`
--

CREATE TABLE `hutang_bayar` (
  `idBayarHutang` int(11) NOT NULL,
  `idDetailHutang` int(11) DEFAULT NULL,
  `tanggalBayar` date DEFAULT NULL,
  `idAkunKas` int(11) DEFAULT NULL,
  `cicilan` varchar(50) DEFAULT NULL,
  `nominal` double DEFAULT NULL,
  `keterangan` enum('Lunas','Belum Lunas') DEFAULT NULL,
  `stdel` int(11) DEFAULT '0',
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hutang_bayar`
--

INSERT INTO `hutang_bayar` (`idBayarHutang`, `idDetailHutang`, `tanggalBayar`, `idAkunKas`, `cicilan`, `nominal`, `keterangan`, `stdel`, `cby`, `cdate`, `uby`, `udate`, `dby`, `ddate`) VALUES
(60, 13, NULL, NULL, 'Cicilan 1', 500000, 'Belum Lunas', 1, 1, '2021-02-12 16:04:36', 1, '2021-02-15 04:16:04', 1, '2021-02-15 04:17:23'),
(61, 13, NULL, NULL, 'Cicilan 2', 500000, 'Belum Lunas', 1, 1, '2021-02-12 16:04:36', 1, '2021-02-15 04:14:59', 1, '2021-02-15 04:17:23'),
(62, 13, NULL, NULL, 'Cicilan 3', 500000, 'Belum Lunas', 1, 1, '2021-02-12 16:04:36', 1, '2021-02-15 04:14:56', 1, '2021-02-15 04:17:23'),
(63, 13, NULL, NULL, 'Cicilan 4', 500000, 'Belum Lunas', 1, 1, '2021-02-12 16:04:36', 1, '2021-02-15 01:54:16', 1, '2021-02-15 04:17:23'),
(64, 13, NULL, NULL, 'Cicilan 5', 500000, 'Belum Lunas', 1, 1, '2021-02-12 16:04:36', NULL, NULL, 1, '2021-02-15 04:17:23'),
(65, 13, NULL, NULL, 'Cicilan 6', 500000, 'Belum Lunas', 1, 1, '2021-02-12 16:04:36', NULL, NULL, 1, '2021-02-15 04:17:23'),
(66, 13, NULL, NULL, 'Cicilan 7', 500000, 'Belum Lunas', 1, 1, '2021-02-12 16:04:36', NULL, NULL, 1, '2021-02-15 04:17:23'),
(67, 13, NULL, NULL, 'Cicilan 8', 500000, 'Belum Lunas', 1, 1, '2021-02-12 16:04:36', NULL, NULL, 1, '2021-02-15 04:17:23'),
(68, 13, NULL, NULL, 'Cicilan 9', 500000, 'Belum Lunas', 1, 1, '2021-02-12 16:04:36', NULL, NULL, 1, '2021-02-15 04:17:23'),
(69, 13, NULL, NULL, 'Cicilan 10', 500000, 'Belum Lunas', 1, 1, '2021-02-12 16:04:36', NULL, NULL, 1, '2021-02-15 04:17:23'),
(70, 14, NULL, NULL, 'Cicilan 1', 250000, 'Belum Lunas', 0, 1, '2021-02-12 16:04:59', 1, '2021-02-15 04:16:56', NULL, NULL),
(71, 14, NULL, NULL, 'Cicilan 2', 250000, 'Belum Lunas', 0, 1, '2021-02-12 16:04:59', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hutang_pos`
--

CREATE TABLE `hutang_pos` (
  `idPosHutang` int(11) NOT NULL,
  `idAkunHutang` int(11) NOT NULL,
  `namaPosHutang` varchar(100) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `stdel` int(11) DEFAULT '0',
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hutang_pos`
--

INSERT INTO `hutang_pos` (`idPosHutang`, `idAkunHutang`, `namaPosHutang`, `keterangan`, `stdel`, `cby`, `cdate`, `uby`, `udate`, `dby`, `ddate`) VALUES
(1, 68, '111', '11222', 1, 1, '2021-02-01 21:24:13', 1, '2021-02-01 21:32:47', 1, '2021-02-01 21:34:53'),
(2, 68, 'ok', 'ok', 1, 1, '2021-02-01 21:35:05', NULL, NULL, 1, '2021-02-02 16:09:20'),
(3, 68, 'OK', 'OK', 0, 1, '2021-02-02 16:18:09', NULL, NULL, NULL, NULL),
(4, 68, 'AA', '222', 0, 1, '2021-02-14 01:25:35', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hutang_setting`
--

CREATE TABLE `hutang_setting` (
  `idSettingHutang` int(11) NOT NULL,
  `idUnit` int(11) NOT NULL,
  `idPosHutang` int(11) NOT NULL,
  `idTahunAjaran` int(11) NOT NULL,
  `stdel` int(11) DEFAULT '0',
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hutang_setting`
--

INSERT INTO `hutang_setting` (`idSettingHutang`, `idUnit`, `idPosHutang`, `idTahunAjaran`, `stdel`, `cby`, `cdate`, `uby`, `udate`, `dby`, `ddate`) VALUES
(5, 5, 3, 3, 0, 1, '2021-02-12 16:02:09', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hutang_setting_detail`
--

CREATE TABLE `hutang_setting_detail` (
  `idDetailHutang` int(11) NOT NULL,
  `noRefrensi` varchar(100) NOT NULL,
  `tanggal` date NOT NULL,
  `idSettingHutang` int(11) NOT NULL,
  `idJabatan` int(11) NOT NULL,
  `idPegawai` int(11) NOT NULL,
  `nominal` double NOT NULL,
  `jumlahCicil` int(11) NOT NULL,
  `angsuran` double NOT NULL,
  `stdel` int(11) DEFAULT '0',
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hutang_setting_detail`
--

INSERT INTO `hutang_setting_detail` (`idDetailHutang`, `noRefrensi`, `tanggal`, `idSettingHutang`, `idJabatan`, `idPegawai`, `nominal`, `jumlahCicil`, `angsuran`, `stdel`, `cby`, `cdate`, `uby`, `udate`, `dby`, `ddate`) VALUES
(11, 'HT12022101', '2021-02-12', 5, 2, 1, 200000, 2, 100000, 1, 1, '2021-02-12 16:02:20', NULL, NULL, 1, '2021-02-12 16:04:28'),
(12, 'HT12022102', '2021-02-12', 5, 2, 10, 5000000, 10, 500000, 1, 1, '2021-02-12 16:02:39', NULL, NULL, 1, '2021-02-12 16:04:26'),
(13, 'HT12022101', '2021-02-12', 5, 2, 10, 5000000, 10, 500000, 1, 1, '2021-02-12 16:04:36', NULL, NULL, 1, '2021-02-15 04:17:23'),
(14, 'HT12022102', '2021-02-12', 5, 2, 1, 500000, 2, 250000, 0, 1, '2021-02-12 16:04:59', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `identitas`
--

CREATE TABLE `identitas` (
  `npsn` varchar(8) NOT NULL,
  `nmAplikasi` varchar(255) DEFAULT NULL,
  `singkatanAplikasi` varchar(100) DEFAULT NULL,
  `nmSekolah` varchar(100) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `kecamatan` varchar(100) NOT NULL,
  `kabupaten` varchar(100) NOT NULL,
  `propinsi` varchar(100) NOT NULL,
  `nipKepsek` varchar(20) DEFAULT NULL,
  `nmKepsek` varchar(100) DEFAULT NULL,
  `nipKaTU` varchar(20) DEFAULT NULL,
  `nmKaTU` varchar(100) DEFAULT NULL,
  `nipBendahara` varchar(20) DEFAULT NULL,
  `nmBendahara` varchar(100) DEFAULT NULL,
  `noTelp` varchar(15) DEFAULT NULL,
  `logo_kiri` varchar(255) DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `identitas`
--

INSERT INTO `identitas` (`npsn`, `nmAplikasi`, `singkatanAplikasi`, `nmSekolah`, `alamat`, `kecamatan`, `kabupaten`, `propinsi`, `nipKepsek`, `nmKepsek`, `nipKaTU`, `nmKaTU`, `nipBendahara`, `nmBendahara`, `noTelp`, `logo_kiri`, `uby`, `udate`) VALUES
('10700295', 'SIM Pengelolaan Pembayaran Sekolah', 'SPPS-TP', 'Yayasan Al Mubarok PP Hodayatullah Bojonegoro', 'Jl Lisman 18 B Bojonegoro', 'Bojonegoro', 'Bojonegoro', 'Jawa Timur ', '-', 'Abdullah', '-', 'Agus', '-', 'FAHMI', '(0451)-8888-999', 'APA AJA.png', 1, '2021-04-23 09:28:30');

-- --------------------------------------------------------

--
-- Table structure for table `informasi`
--

CREATE TABLE `informasi` (
  `idInformasi` int(11) NOT NULL,
  `judulInformasi` varchar(100) DEFAULT NULL,
  `isiInformasi` text,
  `tanggalInformasi` datetime DEFAULT NULL,
  `publikasiInformasi` int(11) DEFAULT NULL,
  `gambarInformasi` varchar(255) DEFAULT NULL,
  `stdel` int(11) DEFAULT '0',
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `informasi`
--

INSERT INTO `informasi` (`idInformasi`, `judulInformasi`, `isiInformasi`, `tanggalInformasi`, `publikasiInformasi`, `gambarInformasi`, `stdel`, `cby`, `cdate`, `uby`, `udate`, `dby`, `ddate`) VALUES
(20, 'sadasd', 'dsadsad', '2021-01-16 00:53:19', 0, 'download.jpg', 1, 1, '2021-01-16 00:53:19', NULL, NULL, 1, '2021-01-16 02:05:50'),
(21, 'sadsad', 'dsadsad', '2021-01-16 01:01:13', 0, 'download.jpg', 1, 1, '2021-01-16 01:01:13', NULL, NULL, 1, '2021-01-16 15:44:24'),
(22, 'sdsad', 'sdsad', '2021-01-16 01:03:23', 0, 'download.jpg', 1, 1, '2021-01-16 01:03:23', NULL, NULL, 1, '2021-01-16 15:46:07'),
(23, 'sad', 'sdasd', '2021-01-16 01:03:52', 0, 'download.jpg', 1, 1, '2021-01-16 01:03:52', NULL, NULL, 1, '2021-01-16 15:46:10'),
(24, 'sadsa', 'sdads', '2021-01-16 01:05:53', 0, 'c81eecc8cf7ec0e85d6ace26c9fd7e79608ad2de.jpg', 1, 1, '2021-01-16 01:05:53', NULL, NULL, 1, '2021-01-16 15:48:56'),
(25, 'sadsad', 'sadsadsa', '2021-01-16 01:08:08', 0, 'Lambang_Kota_Palu.png', 1, 1, '2021-01-16 01:08:08', NULL, NULL, 1, '2021-01-16 15:50:34'),
(26, 'asds', '<p>dsadsad</p>', '2021-01-16 01:57:53', 1, 'gambar setelah kirim berkas UKT.PNG', 1, 1, '2021-01-16 01:27:58', 1, '2021-01-16 01:57:53', 1, '2021-01-16 15:51:17'),
(27, 'sadsadsad', '<p>sadsad</p>', '2021-01-16 01:57:44', 1, 'Lambang_Kota_Palu.png', 1, 1, '2021-01-16 01:29:40', 1, '2021-01-16 01:57:44', 1, '2021-01-16 15:51:56'),
(28, 'qqqqq', '<p>PROSGGLLL</p>', '2021-01-16 01:46:06', 1, 'c81eecc8cf7ec0e85d6ace26c9fd7e79608ad2de.jpg', 1, 1, '2021-01-16 01:30:56', 1, '2021-01-16 01:46:06', 1, '2021-01-16 16:06:31'),
(29, 'TESSSS', '<p style=\"text-align: center;\">dksadsahkjdhasdh sdjhasjkd askdjhsajdh</p>', '2021-01-16 02:25:13', 1, '3.PNG', 1, 1, '2021-01-16 02:25:13', NULL, NULL, 1, '2021-01-16 16:06:32'),
(30, '1234', '<p>1234</p>', '2021-01-16 15:44:18', 1, '8f.PNG', 1, 1, '2021-01-16 15:44:09', 1, '2021-01-16 15:44:18', 1, '2021-01-16 16:09:14'),
(31, 'asdsadsad', '<p>asdsadasd</p>', '2021-01-16 16:09:43', 0, '8e.PNG', 1, 1, '2021-01-16 16:09:43', NULL, NULL, 1, '2021-01-16 16:42:26'),
(32, '333', '<p>sdasdsad</p>', '2021-01-16 16:16:59', 0, '8b.PNG', 1, 1, '2021-01-16 16:16:59', NULL, NULL, 1, '2021-01-16 16:57:18'),
(33, 'sadsad', '<p>sadsad</p>', '2021-01-16 16:58:00', 0, '6.PNG', 1, 1, '2021-01-16 16:58:00', NULL, NULL, 1, '2021-01-16 17:11:47'),
(34, 'sdsadsad', '<p>asdsadsad</p>', '2021-01-16 17:12:35', 0, '3.PNG', 1, 1, '2021-01-16 17:12:03', 1, '2021-01-16 17:12:35', 1, '2021-01-16 17:12:40'),
(35, 'sadsad', '<p>sssss</p>', '2021-01-16 17:58:36', 1, '1.PNG', 1, 1, '2021-01-16 17:57:22', 1, '2021-01-16 17:58:36', 1, '2021-01-16 17:59:12'),
(36, 'asdsad', '<p>asdsadsad</p>', '2021-01-16 18:01:21', 1, '7.PNG', 1, 1, '2021-01-16 17:59:23', 1, '2021-01-16 18:01:21', 1, '2021-01-17 03:46:40'),
(37, 'ssss', '', '2021-01-16 18:20:59', 0, NULL, 1, 1, '2021-01-16 18:20:59', NULL, NULL, 1, '2021-01-17 03:46:43'),
(38, 'aaaa', '<p>2211ddd</p>', '2021-01-16 18:21:13', 0, NULL, 1, 1, '2021-01-16 18:21:13', NULL, NULL, 1, '2021-01-17 03:46:45'),
(39, 'sdsad', '<p>sadsad</p>', '2021-01-17 03:39:35', 0, NULL, 0, 1, '2021-01-17 03:39:35', NULL, NULL, NULL, NULL),
(40, 'sadsad', '<p>asdsad</p>', '2021-01-17 03:40:16', 1, '8 data.png', 1, 1, '2021-01-17 03:40:16', NULL, NULL, 1, '2021-01-17 03:46:49'),
(41, 'adsad', '<p>asdsad</p>', '2021-01-17 13:17:34', 1, '8 data.png', 0, 1, '2021-01-17 03:41:03', 1, '2021-01-17 13:17:34', NULL, NULL),
(42, 'asdsad', '<p>sssss</p>', '2021-01-17 03:42:25', 1, '8 data.png', 0, 1, '2021-01-17 03:42:25', NULL, NULL, NULL, NULL),
(43, 'dssdddd', '<p>cccccc</p>', '2021-01-17 22:12:26', 1, '10.PNG', 0, 1, '2021-01-17 22:12:19', 1, '2021-01-17 22:12:26', NULL, NULL),
(44, 'ZZZZ', '<p>sdasad</p>', '2021-01-19 01:12:24', 0, '64 data.PNG', 1, 1, '2021-01-19 01:12:10', 1, '2021-01-19 01:12:24', 1, '2021-01-19 01:12:39'),
(45, 'dasdsadsa', '<p>asdasdsadd</p>', '2021-01-20 01:23:23', 1, 'logo3.png', 0, 1, '2021-01-20 01:23:23', NULL, NULL, NULL, NULL),
(46, 'sadsadsa', '<p>Sialhakan lunasi pembayaran sebelum</p>', '2021-04-21 04:22:03', 1, 'fc61b9a88394895a5ac72fbdbb7e4cbc.jpeg', 0, 1, '2021-01-27 02:03:40', 1, '2021-04-21 04:22:03', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `izin_keluar`
--

CREATE TABLE `izin_keluar` (
  `idKeluar` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `idSiswa` int(11) NOT NULL,
  `idTahunAjaran` int(11) NOT NULL,
  `jamKeluar` varchar(25) NOT NULL,
  `jamKembali` varchar(25) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `stdel` int(11) DEFAULT '0',
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `izin_keluar`
--

INSERT INTO `izin_keluar` (`idKeluar`, `tanggal`, `idSiswa`, `idTahunAjaran`, `jamKeluar`, `jamKembali`, `keterangan`, `stdel`, `cby`, `cdate`, `uby`, `udate`, `dby`, `ddate`) VALUES
(1, '2021-02-16', 3, 3, '01:25', '18:45', 'iiiiii', 1, 1, '2021-02-16 01:21:54', NULL, NULL, 1, '2021-02-16 01:48:05'),
(2, '2021-02-16', 1, 3, '08:00', '13:55', 'OKE', 0, 1, '2021-02-16 12:07:14', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `izin_pulang`
--

CREATE TABLE `izin_pulang` (
  `idPulang` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `idSiswa` int(11) NOT NULL,
  `idTahunAjaran` int(11) NOT NULL,
  `penjemput` varchar(50) NOT NULL,
  `waktuIzin` int(11) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `stdel` int(11) DEFAULT '0',
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `izin_pulang`
--

INSERT INTO `izin_pulang` (`idPulang`, `tanggal`, `idSiswa`, `idTahunAjaran`, `penjemput`, `waktuIzin`, `keterangan`, `stdel`, `cby`, `cdate`, `uby`, `udate`, `dby`, `ddate`) VALUES
(1, '2021-02-16', 3, 3, 'AGUS', 1, '', 1, 1, '2021-02-16 01:20:00', NULL, NULL, 1, '2021-02-16 01:46:11'),
(2, '2021-02-16', 3, 3, 'AGUS', 3, '2222', 1, 1, '2021-02-16 01:21:13', NULL, NULL, 1, '2021-02-16 01:46:21'),
(3, '2021-02-16', 3, 3, 'AGUS', 2, 'asdsad', 0, 1, '2021-02-16 03:30:52', NULL, NULL, NULL, NULL),
(4, '2021-02-16', 1, 3, 'AGUS', 5, '2222', 1, 1, '2021-02-16 03:39:03', NULL, NULL, 1, '2021-02-16 03:47:51');

-- --------------------------------------------------------

--
-- Table structure for table `jabatan_pegawai`
--

CREATE TABLE `jabatan_pegawai` (
  `idJabatan` int(11) NOT NULL,
  `kodeJabatan` varchar(100) DEFAULT NULL,
  `namaJabatan` varchar(255) DEFAULT NULL,
  `idUnit` int(11) DEFAULT NULL,
  `stdel` int(11) NOT NULL DEFAULT '0',
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jabatan_pegawai`
--

INSERT INTO `jabatan_pegawai` (`idJabatan`, `kodeJabatan`, `namaJabatan`, `idUnit`, `stdel`, `cby`, `cdate`, `uby`, `udate`, `dby`, `ddate`) VALUES
(1, 'KSSMP	', 'Kepala SMP', 5, 1, 1, '2021-01-17 22:26:44', NULL, NULL, 1, '2021-01-19 15:42:59'),
(2, '123', 'ddddd', 5, 0, 1, '2021-01-17 22:30:47', 1, '2021-01-17 22:34:50', NULL, NULL),
(3, 'sdsadsad', 'sadsadsad', 1, 0, 1, '2021-01-19 00:23:23', 1, '2021-01-19 00:24:48', NULL, NULL),
(6, 'KSSMP	', '111111', 5, 0, 1, '2021-01-21 02:11:15', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jenis_bayar`
--

CREATE TABLE `jenis_bayar` (
  `idJenisBayar` int(10) NOT NULL,
  `idUnit` int(11) DEFAULT NULL,
  `idPosBayar` int(5) DEFAULT NULL,
  `idTahunAjaran` int(5) DEFAULT NULL,
  `tipeBayar` enum('Bulanan','Bebas') DEFAULT 'Bulanan',
  `stdel` int(11) DEFAULT '0',
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis_bayar`
--

INSERT INTO `jenis_bayar` (`idJenisBayar`, `idUnit`, `idPosBayar`, `idTahunAjaran`, `tipeBayar`, `stdel`, `cby`, `cdate`, `uby`, `udate`, `dby`, `ddate`) VALUES
(1, 1, 3, 3, 'Bulanan', 0, 1, '2021-04-09 01:59:38', NULL, NULL, NULL, NULL),
(2, 1, 8, 3, 'Bebas', 0, 1, '2021-04-09 13:30:42', 1, '2021-04-14 13:42:55', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jurnal_umum`
--

CREATE TABLE `jurnal_umum` (
  `id` int(50) NOT NULL,
  `tgl` date DEFAULT NULL,
  `ket` varchar(100) DEFAULT NULL,
  `penerimaan` int(10) DEFAULT '0',
  `pengeluaran` int(10) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jurnal_umum`
--

INSERT INTO `jurnal_umum` (`id`, `tgl`, `ket`, `penerimaan`, `pengeluaran`) VALUES
(1, '2020-01-15', 'transport', 1000000, 100000),
(2, '2020-01-15', 'MAKAN SIANG', 100000, 50000),
(3, '2020-01-15', 'UAS', 20000, 0),
(4, '2020-01-15', 'MIS', 0, 0),
(5, '2020-01-25', 'Transport ke Surabaya', 1, 200000),
(6, '2020-03-06', 'Bos', 14000000, 0),
(8, '2020-03-11', 'bayar fotocopy man', 0, 1000000),
(9, '2020-03-11', 'Saldo Awal', 12000000, 0),
(10, '2020-04-06', 'Coba Aja', 10000, 20000),
(11, '2020-06-18', 'pembelian buku', 0, 250000);

-- --------------------------------------------------------

--
-- Table structure for table `kamar`
--

CREATE TABLE `kamar` (
  `idKamar` int(11) NOT NULL,
  `namaKamar` varchar(255) NOT NULL,
  `stdel` int(11) NOT NULL DEFAULT '0',
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kamar`
--

INSERT INTO `kamar` (`idKamar`, `namaKamar`, `stdel`, `cby`, `cdate`, `uby`, `udate`, `dby`, `ddate`) VALUES
(1, 'CCC', 0, 1, '2021-01-17 21:55:34', 1, '2021-01-17 22:00:10', NULL, NULL),
(2, 'VVVV', 1, 1, '2021-01-17 21:55:34', NULL, NULL, 1, '2021-01-17 21:56:08'),
(3, 'sdadsad', 0, 1, '2021-01-17 22:00:24', NULL, NULL, NULL, NULL),
(4, 'qwerty', 1, 1, '2021-01-17 22:00:24', 1, '2021-01-17 22:00:32', 1, '2021-01-17 22:00:36'),
(5, '333332345678', 1, 1, '2021-01-19 00:03:26', 1, '2021-01-19 00:03:34', 1, '2021-01-19 00:03:51'),
(6, 'sadsasad', 1, 1, '2021-01-19 00:03:26', NULL, NULL, 1, '2021-01-19 00:03:38'),
(7, 'EEEEEE', 1, 1, '2021-01-19 01:52:22', 1, '2021-01-19 01:52:30', 1, '2021-01-19 01:52:40'),
(8, 'DDDD', 1, 1, '2021-01-19 01:52:22', 1, '2021-01-19 01:52:36', 1, '2021-01-19 01:52:51');

-- --------------------------------------------------------

--
-- Table structure for table `kas`
--

CREATE TABLE `kas` (
  `idKas` int(11) NOT NULL,
  `jenis` enum('Masuk','Keluar') NOT NULL,
  `tipe` varchar(100) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `idUnitSekolah` int(11) DEFAULT NULL,
  `SiswaId` varchar(100) DEFAULT NULL,
  `noRefrensi` varchar(100) DEFAULT NULL,
  `idAkunKas` int(11) DEFAULT NULL,
  `idAkunKasTujuan` int(11) DEFAULT NULL,
  `idKodeAkun` int(11) DEFAULT NULL,
  `idTahunAjaran` int(11) DEFAULT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `keterangan_kas` varchar(100) NOT NULL,
  `nominal` varchar(100) DEFAULT NULL,
  `idPajak` int(11) DEFAULT NULL,
  `idUnitPos` int(11) DEFAULT NULL,
  `total` double DEFAULT NULL,
  `stdel` int(11) DEFAULT '0',
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kas`
--

INSERT INTO `kas` (`idKas`, `jenis`, `tipe`, `tanggal`, `idUnitSekolah`, `SiswaId`, `noRefrensi`, `idAkunKas`, `idAkunKasTujuan`, `idKodeAkun`, `idTahunAjaran`, `keterangan`, `keterangan_kas`, `nominal`, `idPajak`, `idUnitPos`, `total`, `stdel`, `cby`, `cdate`, `uby`, `udate`, `dby`, `ddate`) VALUES
(1, 'Masuk', 'Transfer', '2021-04-16', 1, '25', 'JKTahfidz1604210001', 75, 75, NULL, 3, 'Terima Tagihan bebas midtransi', '', NULL, NULL, NULL, 300000, 0, 1, '2021-04-16 01:14:28', NULL, NULL, NULL, NULL),
(2, 'Masuk', 'Transfer', '2021-04-16', 1, '25', 'JKTahfidz1604210002', 75, 75, NULL, 3, 'Terima Tagihan bulan midtrans', '', NULL, NULL, NULL, 100000, 0, 1, '2021-04-16 01:53:36', NULL, NULL, NULL, NULL),
(3, 'Masuk', 'Transfer', '2021-04-16', 1, '25', 'JKTahfidz1604210003', 75, 75, NULL, 3, 'Terima Tagihan bulan midtrans', '', NULL, NULL, NULL, 150000, 0, 1, '2021-04-16 01:56:37', NULL, NULL, NULL, NULL),
(4, 'Masuk', 'Transfer', '2021-04-17', 1, '25', 'JKTahfidz1704210001', 75, 75, NULL, 3, 'Terima Tagihan bulan midtrans', '', NULL, NULL, NULL, 55000, 0, 1, '2021-04-17 03:37:14', NULL, NULL, NULL, NULL),
(5, 'Masuk', 'Transfer', '2021-04-17', 1, '25', 'JKTahfidz1704210002', 75, 75, NULL, 3, 'Terima Tagihan bulan midtrans', '', NULL, NULL, NULL, 55000, 0, 1, '2021-04-17 03:37:55', NULL, NULL, NULL, NULL),
(6, 'Masuk', 'Transfer', '2021-04-17', 1, '25', 'JKTahfidz1704210003', 75, 75, NULL, 3, 'Terima Tagihan bulan midtrans', '', NULL, NULL, NULL, 55000, 0, 1, '2021-04-17 04:27:12', NULL, NULL, NULL, NULL),
(7, 'Masuk', 'Transfer', '2021-04-17', 1, '25', 'JKTahfidz1704210004', 75, 75, NULL, 3, 'Terima Tagihan bulan midtrans', '', NULL, NULL, NULL, 55000, 0, 1, '2021-04-17 04:34:20', NULL, NULL, NULL, NULL),
(8, 'Masuk', 'Transfer', '2021-04-17', 1, '25', 'JKTahfidz1704210005', 75, 75, NULL, 3, 'Terima Tagihan bulan midtrans', '', NULL, NULL, NULL, 55000, 0, 1, '2021-04-17 04:35:57', NULL, NULL, NULL, NULL),
(9, 'Masuk', 'Transfer', '2021-04-17', 1, '25', 'JKTahfidz1704210006', 75, 75, NULL, 3, 'Terima Tagihan bulan midtrans', '', NULL, NULL, NULL, 50000, 0, 1, '2021-04-17 04:36:22', NULL, NULL, NULL, NULL),
(10, 'Masuk', 'Transfer', '2021-04-17', 1, '25', 'JKTahfidz1704210007', 75, 75, NULL, 3, 'Terima Tagihan bulan midtrans', '', NULL, NULL, NULL, 50000, 0, 1, '2021-04-17 04:37:39', NULL, NULL, NULL, NULL),
(11, 'Masuk', 'Transfer', '2021-04-17', 1, '25', 'JKTahfidz1704210008', 75, 75, NULL, 3, 'Terima Tagihan bulan midtrans', '', NULL, NULL, NULL, 50000, 0, 1, '2021-04-17 04:45:03', NULL, NULL, NULL, NULL),
(12, 'Masuk', 'Transfer', '2021-04-17', 1, '25', 'JKTahfidz1704210009', 75, 75, NULL, 3, 'Terima Tagihan bulan midtrans', '', NULL, NULL, NULL, 50000, 0, 1, '2021-04-17 04:59:27', NULL, NULL, NULL, NULL),
(13, 'Masuk', 'Transfer', '2021-04-17', 1, '25', 'JKTahfidz1704210010', 75, 75, NULL, 3, 'Terima Tagihan bulan midtrans', '', NULL, NULL, NULL, 50000, 0, 1, '2021-04-17 05:01:27', NULL, NULL, NULL, NULL),
(14, 'Masuk', 'Transfer', '2021-04-17', 1, '25', 'JKTahfidz1704210011', 75, 75, NULL, 3, 'Terima Tagihan bulan midtrans', '', NULL, NULL, NULL, 50000, 0, 1, '2021-04-17 05:03:43', NULL, NULL, NULL, NULL),
(15, 'Masuk', 'Transfer', '2021-04-17', 1, '25', 'JKTahfidz1704210012', 75, 75, NULL, 3, 'Terima Tagihan bulan midtrans', '', NULL, NULL, NULL, 50000, 0, 1, '2021-04-17 05:07:49', NULL, NULL, NULL, NULL),
(16, 'Masuk', 'Transfer', '2021-04-17', 1, '25', 'JKTahfidz1704210013', 75, 75, NULL, 3, 'Terima Tagihan bulan midtrans', '', NULL, NULL, NULL, 50000, 0, 1, '2021-04-17 05:10:35', NULL, NULL, NULL, NULL),
(17, 'Masuk', 'Transfer', '2021-04-17', 1, '25', 'JKTahfidz1704210014', 75, 75, NULL, 3, 'Terima Tagihan bulan midtrans', '', NULL, NULL, NULL, 50000, 0, 1, '2021-04-17 05:12:17', NULL, NULL, NULL, NULL),
(18, 'Masuk', 'Transfer', '2021-04-17', 1, '25', 'JKTahfidz1704210015', 75, 75, NULL, 3, 'Terima Tagihan bulan midtrans', '', NULL, NULL, NULL, 55000, 0, 1, '2021-04-17 05:15:01', NULL, NULL, NULL, NULL),
(19, 'Masuk', 'Transfer', '2021-04-17', 1, '38', 'JKTahfidz1704210016', 75, 75, NULL, 3, 'Terima Tagihan bulan midtrans', '', NULL, NULL, NULL, 200000, 0, 1, '2021-04-17 15:21:23', NULL, NULL, NULL, NULL),
(20, 'Masuk', 'Transfer', '2021-04-17', 1, '38', 'JKTahfidz1704210017', 75, 75, NULL, 3, 'Terima Tagihan bulan midtrans', '', NULL, NULL, NULL, 200000, 0, 1, '2021-04-17 15:22:58', NULL, NULL, NULL, NULL),
(21, 'Masuk', 'Transfer', '2021-04-17', 1, '38', 'JKTahfidz1704210018', 75, 75, NULL, 3, 'Terima Tagihan bulan midtrans', '', NULL, NULL, NULL, 200000, 0, 1, '2021-04-17 15:28:41', NULL, NULL, NULL, NULL),
(22, 'Masuk', 'Transfer', '2021-04-17', 1, '38', 'JKTahfidz1704210019', 75, 75, NULL, 3, 'Terima Tagihan bebas midtransi', '', NULL, NULL, NULL, 100000, 0, 1, '2021-04-17 15:33:19', NULL, NULL, NULL, NULL),
(23, 'Masuk', 'Transfer', '2021-04-17', 1, '38', 'JKTahfidz1704210020', 75, 75, NULL, 3, 'Terima Tagihan bebas midtransi', '', NULL, NULL, NULL, 100000, 0, 1, '2021-04-17 15:34:57', NULL, NULL, NULL, NULL),
(24, 'Masuk', 'Transfer', '2021-04-17', 1, '38', 'JKTahfidz1704210021', 75, 75, NULL, 3, 'Terima Tagihan bebas midtransi', '', NULL, NULL, NULL, 100000, 0, 1, '2021-04-17 15:40:51', NULL, NULL, NULL, NULL),
(25, 'Masuk', 'Transfer', '2021-04-17', 1, '38', 'JKTahfidz1704210022', 75, 75, NULL, 3, 'Terima Tagihan bulan midtrans', '', NULL, NULL, NULL, 200000, 0, 1, '2021-04-17 15:42:20', NULL, NULL, NULL, NULL),
(26, 'Masuk', 'Transfer', '2021-04-17', 1, '38', 'JKTahfidz1704210023', 75, 75, NULL, 3, 'Terima Tagihan bebas midtransi', '', NULL, NULL, NULL, 100000, 0, 1, '2021-04-17 15:52:39', NULL, NULL, NULL, NULL),
(27, 'Masuk', 'Transfer', '2021-04-17', 1, '38', 'JKTahfidz1704210024', 75, 75, NULL, 3, 'Terima Tagihan bulan midtrans', '', NULL, NULL, NULL, 200000, 0, 1, '2021-04-17 16:10:12', NULL, NULL, NULL, NULL),
(28, 'Masuk', 'Transfer', '2021-04-17', 1, '38', 'JKTahfidz1704210025', 75, 75, NULL, 3, 'Terima Tagihan bulan midtrans', '', NULL, NULL, NULL, 200000, 0, 1, '2021-04-17 16:18:21', NULL, NULL, NULL, NULL),
(29, 'Masuk', 'Transfer', '2021-04-17', 1, '38', 'JKTahfidz1704210026', 75, 75, NULL, 3, 'Terima Tagihan bulan midtrans', '', NULL, NULL, NULL, 200000, 0, 1, '2021-04-17 16:19:15', NULL, NULL, NULL, NULL),
(30, 'Masuk', 'Transfer', '2021-04-17', 1, '38', 'JKTahfidz1704210027', 75, 75, NULL, 3, 'Terima Tagihan bulan midtrans', '', NULL, NULL, NULL, 200000, 0, 1, '2021-04-17 16:26:35', NULL, NULL, NULL, NULL),
(31, 'Masuk', 'Transfer', '2021-04-17', 1, '38', 'JKTahfidz1704210028', 75, 75, NULL, 3, 'Terima Tagihan bulan midtrans', '', NULL, NULL, NULL, 200000, 0, 1, '2021-04-17 16:37:50', NULL, NULL, NULL, NULL),
(32, 'Masuk', 'Transfer', '2021-04-17', 1, '38', 'JKTahfidz1704210029', 75, 75, NULL, 3, 'Terima Tagihan bebas midtransi', '', NULL, NULL, NULL, 100000, 0, 1, '2021-04-17 16:41:57', NULL, NULL, NULL, NULL),
(33, 'Masuk', 'Transfer', '2021-04-17', 1, '38', 'JKTahfidz1704210030', 75, 75, NULL, 3, 'Terima Tagihan bulan midtrans', '', NULL, NULL, NULL, 200000, 0, 1, '2021-04-17 17:03:40', NULL, NULL, NULL, NULL),
(34, 'Masuk', 'Transfer', '2021-04-17', 1, '38', 'JKTahfidz1704210031', 75, 75, NULL, 3, 'Terima Tagihan bulan midtrans', '', NULL, NULL, NULL, 200000, 0, 1, '2021-04-17 17:45:39', NULL, NULL, NULL, NULL),
(35, 'Masuk', 'Transfer', '2021-04-17', 1, '38', 'JKTahfidz1704210032', 75, 75, NULL, 3, 'Terima Tagihan bebas midtransi', '', NULL, NULL, NULL, 100000, 0, 1, '2021-04-17 17:54:49', NULL, NULL, NULL, NULL),
(36, 'Masuk', 'Transfer', '2021-04-17', 1, '38', 'JKTahfidz1704210033', 75, 75, NULL, 3, 'Terima Tagihan bulan midtrans', '', NULL, NULL, NULL, 200000, 0, 1, '2021-04-17 18:30:45', NULL, NULL, NULL, NULL),
(37, 'Masuk', 'Transfer', '2021-04-18', 1, '38', 'JKTahfidz1804210001', 75, 75, NULL, 3, 'Terima Tagihan bulan midtrans', '', NULL, NULL, NULL, 400000, 0, 1, '2021-04-18 11:10:35', NULL, NULL, NULL, NULL),
(38, 'Masuk', 'Transfer', '2021-04-18', 1, '38', 'JKTahfidz1804210002', 75, 75, NULL, 3, 'Terima Tagihan bulan midtrans', '', NULL, NULL, NULL, 400000, 0, 1, '2021-04-18 11:11:13', NULL, NULL, NULL, NULL),
(39, 'Masuk', 'Transfer', '2021-04-18', 1, '38', 'JKTahfidz1804210003', 75, 75, NULL, 3, 'Terima Tagihan bulan midtrans', '', NULL, NULL, NULL, 400000, 0, 1, '2021-04-18 11:17:37', NULL, NULL, NULL, NULL),
(40, 'Masuk', 'Transfer', '2021-04-21', 1, '38', 'JKTahfidz2104210001', 75, 75, NULL, 3, 'Terima Tagihan bulan midtrans', '', NULL, NULL, NULL, 600000, 0, 1, '2021-04-21 11:30:33', NULL, NULL, NULL, NULL),
(41, 'Masuk', 'Transfer', '2021-04-21', 1, '38', 'JKTahfidz2104210002', 75, 75, NULL, 3, 'Terima Tagihan bulan midtrans', '', NULL, NULL, NULL, 600000, 0, 1, '2021-04-21 11:32:43', NULL, NULL, NULL, NULL),
(42, 'Masuk', 'Transfer', '2021-04-21', 1, '38', 'JKTahfidz2104210003', 75, 75, NULL, 3, 'Terima Tagihan bulan midtrans', '', NULL, NULL, NULL, 600000, 0, 1, '2021-04-21 11:36:49', NULL, NULL, NULL, NULL),
(43, 'Masuk', 'Transfer', '2021-04-21', 1, '38', 'JKTahfidz2104210004', 75, 75, NULL, 3, 'Terima Tagihan bulan midtrans', '', NULL, NULL, NULL, 600000, 0, 1, '2021-04-21 11:50:24', NULL, NULL, NULL, NULL),
(44, 'Masuk', 'Transfer', '2021-04-21', 1, '38', 'JKTahfidz2104210005', 75, 75, NULL, 3, 'Terima Tagihan bulan midtrans', '', NULL, NULL, NULL, 600000, 0, 1, '2021-04-21 12:30:12', NULL, NULL, NULL, NULL),
(45, 'Masuk', 'Transfer', '2021-04-21', 1, '38', 'JKTahfidz2104210006', 75, 75, NULL, 3, 'Terima Tagihan bulan midtrans', '', NULL, NULL, NULL, 600000, 0, 1, '2021-04-21 13:55:57', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kas_transaksi`
--

CREATE TABLE `kas_transaksi` (
  `idTransaksiKas` int(11) NOT NULL,
  `idUsers` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `noRefrensi` varchar(100) NOT NULL,
  `idAkunBiaya` int(11) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `nominal` double NOT NULL,
  `idPajak` int(11) NOT NULL,
  `idUnitPos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kas_transaksi`
--

INSERT INTO `kas_transaksi` (`idTransaksiKas`, `idUsers`, `tanggal`, `noRefrensi`, `idAkunBiaya`, `keterangan`, `nominal`, `idPajak`, `idUnitPos`) VALUES
(12, 1, '2021-02-08', 'JKSMP-TMI0802210001  ', 54, '2222', 50000, 2, 0),
(13, 1, '2021-02-08', 'JKTahfidz0802210001  ', 64, '5', 50000, 2, 0),
(14, 1, '2021-02-08', 'JKTahfidz0802210002  ', 64, 'ww', 1000000, 1, 0),
(15, 1, '2021-02-08', 'JKTahfidz0802210003  ', 64, 'uuu', 50000, 2, 0),
(16, 1, '2021-02-08', 'JKTahfidz0802210003  ', 65, '11222', 50000, 2, 0),
(17, 1, '2021-02-08', 'JKTahfidz0802210004  ', 64, 'ATK TINTA', 10000, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `kelas_siswa`
--

CREATE TABLE `kelas_siswa` (
  `idKelas` int(5) NOT NULL,
  `nmKelas` varchar(20) DEFAULT NULL,
  `idUnit` int(11) DEFAULT NULL,
  `stdel` int(11) DEFAULT '0',
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kelas_siswa`
--

INSERT INTO `kelas_siswa` (`idKelas`, `nmKelas`, `idUnit`, `stdel`, `cby`, `cdate`, `uby`, `udate`, `dby`, `ddate`) VALUES
(2, 'XI TKJ', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'X APH', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'X TKJ', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'XI OTKP', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'XI APH', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'XII APH', 2, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'X RPL', 2, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'IX A', 2, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'sdadsad', 1, 1, NULL, NULL, NULL, NULL, 1, '2021-01-17 20:45:58'),
(12, 'sssss', 1, 0, NULL, NULL, 1, '2021-01-19 00:01:18', NULL, NULL),
(13, 'BAAAA', 6, 1, NULL, NULL, 1, '2021-01-17 20:54:39', 1, '2021-01-17 20:55:07'),
(14, '1', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(15, '2', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(16, '3', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(17, '', 0, 1, NULL, NULL, 1, '2021-01-28 19:54:43', 1, '2021-01-17 20:54:55'),
(18, 'AC', 5, 1, 1, '2021-01-17 20:43:47', NULL, NULL, 1, '2021-01-17 20:45:16'),
(19, 'AB', 5, 1, 1, '2021-01-17 20:43:47', NULL, NULL, 1, '2021-01-17 20:45:10'),
(20, 'QEWERER', 6, 1, 1, '2021-01-17 20:55:21', 1, '2021-01-17 20:55:36', 1, '2021-01-17 20:55:46'),
(21, 'ssss', 5, 0, 1, '2021-01-18 23:55:39', NULL, NULL, NULL, NULL),
(22, 'dddd', 5, 0, 1, '2021-01-18 23:55:39', NULL, NULL, NULL, NULL),
(23, 'dsadsd', 5, 0, 1, '2021-01-19 00:00:58', NULL, NULL, NULL, NULL),
(24, 'asdasd', 5, 1, 1, '2021-01-19 00:00:58', NULL, NULL, 1, '2021-01-19 00:01:28'),
(25, 'asdsads', 6, 0, 1, '2021-01-19 01:38:26', 1, '2021-01-19 01:38:34', NULL, NULL),
(26, 'xxxxx', 6, 1, 1, '2021-01-19 01:38:26', 1, '2021-01-19 01:38:43', 1, '2021-01-20 00:24:04');

-- --------------------------------------------------------

--
-- Table structure for table `kwitansi`
--

CREATE TABLE `kwitansi` (
  `id_kwitansi` varchar(30) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `tgl_cetak` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kwitansi`
--

INSERT INTO `kwitansi` (`id_kwitansi`, `id_siswa`, `tgl_cetak`) VALUES
('00000001kwt', 299, '2020-08-18 11:30:43'),
('00000002kwt', 299, '2020-08-18 11:31:09'),
('00000003kwt', 299, '2020-08-18 11:31:53'),
('00000004kwt', 299, '2020-08-19 09:52:29'),
('00000005kwt', 299, '2020-08-19 09:53:23'),
('00000006kwt', 299, '2020-08-19 09:57:27'),
('00000007kwt', 299, '2020-08-19 09:57:48'),
('00000008kwt', 299, '2020-08-19 10:01:16'),
('KWT00000001', 299, '2020-08-19 10:15:32'),
('KWT00000009', 299, '2020-08-19 10:09:41');

-- --------------------------------------------------------

--
-- Table structure for table `log_kasir`
--

CREATE TABLE `log_kasir` (
  `idTransaksi` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `jenisBayar` varchar(50) DEFAULT NULL,
  `idBayar` int(11) DEFAULT NULL,
  `modul` varchar(50) NOT NULL,
  `aksi` varchar(100) NOT NULL,
  `noRefrensi` varchar(50) DEFAULT NULL,
  `nis_nip` varchar(50) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `nominal` double DEFAULT NULL,
  `penulis` varchar(100) NOT NULL,
  `browser` varchar(50) NOT NULL,
  `os` varchar(50) NOT NULL,
  `ip_address` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `log_kasir`
--

INSERT INTO `log_kasir` (`idTransaksi`, `tanggal`, `jenisBayar`, `idBayar`, `modul`, `aksi`, `noRefrensi`, `nis_nip`, `title`, `nominal`, `penulis`, `browser`, `os`, `ip_address`) VALUES
(1, '2021-02-22 22:22:37', 'Bulanan', 73, 'Pembayaran', 'Bayar', NULL, '201706001', 'Bayar-SPP Tahfidz 2020/2021 bulan Juli', 10000, '1', 'Chrome 88.0.4324.182', 'Windows 8.1', '::1'),
(2, '2021-02-22 22:27:17', 'Bebas', 38, 'Pembayaran', 'Bayar', NULL, '201755667', 'Pelunasan Tunggakan SPP - T.A 2019/2020', 50000, '1', 'Chrome 88.0.4324.182', 'Windows 8.1', '::1'),
(3, '2021-02-22 22:27:46', 'Bebas', 38, 'Pembayaran', 'Hapus', NULL, '201755667', 'Hapus Pelunasan Tunggakan SPP - T.A 2019/2020', 50000, '1', 'Chrome 88.0.4324.182', 'Windows 8.1', '::1'),
(4, '2021-02-22 22:39:25', 'Gaji', 27, 'Penggajian', 'Bayar', NULL, '201806001', 'Input Gaji Bulanan Juli 2019/2020', 5100000, '1', 'Chrome 88.0.4324.182', 'Windows 8.1', '::1'),
(5, '2021-02-22 22:43:34', 'Gaji', 27, 'Penggajian', 'Hapus', NULL, '201806001', 'Hapus Gaji Bulan Juli 2019/2020', 5100000, '1', 'Chrome 88.0.4324.182', 'Windows 8.1', '::1'),
(12, '2021-02-23 02:29:06', 'Kas', 64, 'Kas Masuk', 'Simpan Transaksi', 'JMTahfidz2302210003  ', NULL, 'Input DONATUR A', 2000000, '1', 'Chrome 88.0.4324.182', 'Windows 8.1', '::1'),
(13, '2021-02-23 02:31:28', 'Kas', 64, 'Kas Masuk', 'Hapus Transaksi', 'JMTahfidz2302210003  ', NULL, 'Hapus DONATUR A', 2000000, '1', 'Chrome 88.0.4324.182', 'Windows 8.1', '::1'),
(14, '2021-02-23 02:50:08', 'Kas', 65, 'Kas Keluar', 'Simpan Transaksi', 'JKSMP-TMI2302210001  ', NULL, 'Input SPIDOL A', 100000, '1', 'Chrome 88.0.4324.182', 'Windows 8.1', '::1'),
(15, '2021-02-23 11:19:24', 'Kas', 66, 'Kas Masuk', 'Simpan Transaksi', 'JMTahfidz2302210003  ', NULL, 'Input DONATUR OO', 5000000, '1', 'Chrome 88.0.4324.182', 'Windows 8.1', '::1'),
(19, '2021-02-23 17:56:58', 'Bulanan', 145, 'Pembayaran', 'Bayar', 'SPSMP-TMI20178877823022102', '201788778', 'Bayar-SPP SMP 2019/2020 bulan Juli', 120000, '15', 'Chrome 88.0.4324.182', 'Windows 8.1', '::1'),
(20, '2021-02-24 14:19:53', 'Bebas', 38, 'Pembayaran', 'Bayar', '', '201755667', 'Pelunasan Tunggakan SPP - T.A 2019/2020', 90000, '1', 'Chrome 88.0.4324.182', 'Windows 8.1', '::1'),
(21, '2021-04-04 21:33:01', 'Bebas', 39, 'Pembayaran', 'Bayar', '', '201755667', 'Pelunasan DU Santri Baru - T.A 2019/2020', 500000, '1', 'Handheld ', 'Android', '36.84.189.214'),
(22, '2021-04-09 13:31:44', 'Bebas', 1, 'Pembayaran', 'Bayar', '', '201755667', 'Pelunasan SPP Tahfidz - T.A 2019/2020', 100000, '1', 'Chrome 89.0.4389.114', 'Windows 10', '36.74.1.18'),
(23, '2021-04-09 13:34:31', 'Bebas', 1, 'Pembayaran', 'Bayar', '', '201755667', 'Pelunasan SPP Tahfidz - T.A 2019/2020', 50000, '1', 'Chrome 89.0.4389.114', 'Windows 10', '36.79.51.153'),
(24, '2021-04-09 19:14:58', 'Bebas', 1, 'Pembayaran', 'Bayar', '', '201755667', 'Pelunasan SPP Tahfidz - T.A 2019/2020', 50000, '1', 'Chrome 89.0.4389.114', 'Windows 10', '36.80.184.63'),
(25, '2021-04-09 19:40:54', 'Bebas', 1, 'Pembayaran', 'Bayar', '', '201755667', 'Pelunasan SPP Tahfidz - T.A 2019/2020', 200000, '1', 'Chrome 89.0.4389.114', 'Windows 10', '36.80.184.63'),
(26, '2021-04-09 19:43:58', 'Bebas', 1, 'Pembayaran', 'Bayar', '', '201755667', 'Pelunasan SPP Tahfidz - T.A 2019/2020', 125000, '1', 'Chrome 89.0.4389.114', 'Windows 10', '36.80.184.63'),
(27, '2021-04-09 19:44:21', 'Bebas', 1, 'Pembayaran', 'Bayar', '', '201755667', 'Pelunasan SPP Tahfidz - T.A 2019/2020', 100000, '1', 'Chrome 89.0.4389.114', 'Windows 10', '36.80.184.63'),
(28, '2021-04-09 21:59:26', 'Bebas', 1, 'Pembayaran', 'Bayar', '', '201755667', 'Pelunasan SPP Tahfidz - T.A 2019/2020', 100000, '1', 'Chrome 89.0.4389.114', 'Windows 10', '36.80.184.63'),
(29, '2021-04-10 23:52:27', 'Bulanan', 4, 'Pembayaran', 'Bayar', 'SPTahfidz20175566710042105', '201755667', 'Bayar-SPP Tahfidz 2019/2020 bulan Oktober', 55000, '1', 'Chrome 89.0.4389.114', 'Windows 10', '36.73.237.91'),
(30, '2021-04-10 23:55:49', 'Bulanan', 4, 'Pembayaran', 'Bayar', 'SPTahfidz20175566710042105', '201755667', 'Bayar-SPP Tahfidz 2019/2020 bulan Oktober', 55000, '1', 'Chrome 89.0.4389.114', 'Windows 10', '36.74.1.18'),
(31, '2021-04-10 23:56:53', 'Bulanan', 4, 'Pembayaran', 'Bayar', 'SPTahfidz20175566710042105', '201755667', 'Bayar-SPP Tahfidz 2019/2020 bulan Oktober', 55000, '1', 'Chrome 89.0.4389.114', 'Windows 10', '180.247.234.200'),
(32, '2021-04-10 23:59:46', 'Bebas', 1, 'Pembayaran', 'Bayar', '', '201755667', 'Pelunasan SPP Tahfidz - T.A 2019/2020', 100000, '1', 'Chrome 89.0.4389.114', 'Windows 10', '36.81.248.87'),
(33, '2021-04-11 00:00:17', 'Bulanan', 13, 'Pembayaran', 'Bayar', 'SPTahfidz11223311042101', '112233', 'Bayar-SPP Tahfidz 2019/2020 bulan Juli', 400000, '1', 'Chrome 89.0.4389.114', 'Windows 10', '36.74.1.18'),
(34, '2021-04-11 00:06:53', 'Bebas', 2, 'Pembayaran', 'Bayar', '', '112233', 'Pelunasan SPP Tahfidz - T.A 2019/2020', 100000, '1', 'Chrome 89.0.4389.114', 'Windows 10', '180.247.234.200'),
(35, '2021-04-11 00:09:37', 'Bulanan', 13, 'Pembayaran', 'Bayar', 'SPTahfidz11223311042103', '112233', 'Bayar-SPP Tahfidz 2019/2020 bulan Juli', 400000, '1', 'Chrome 89.0.4389.114', 'Windows 10', '36.73.237.91'),
(36, '2021-04-11 00:10:39', 'Bulanan', 13, 'Pembayaran', 'Bayar', 'SPTahfidz11223311042104', '112233', 'Bayar-SPP Tahfidz 2019/2020 bulan Juli', 400000, '1', 'Chrome 89.0.4389.114', 'Windows 10', '36.74.1.18'),
(37, '2021-04-11 08:38:16', 'Bulanan', 19, 'Pembayaran', 'Bayar', 'SPTahfidz11223311042105', '112233', 'Bayar-SPP Tahfidz 2019/2020 bulan Januari', 400000, '1', 'Chrome 89.0.4389.114', 'Windows 10', '36.81.248.87'),
(38, '2021-04-14 13:32:24', 'Bulanan', 19, 'Pembayaran', 'Bayar', 'SPTahfidz11223314042106', '112233', 'Bayar-SPP Tahfidz 2019/2020 bulan Januari', 400000, '1', 'Chrome 89.0.4389.114', 'Windows 10', '180.253.83.137'),
(39, '2021-04-14 13:35:27', 'Bulanan', 14, 'Pembayaran', 'Hapus', 'SPTahfidz11223314042107', '112233', 'Hapus Bayar-SPP Tahfidz 2019/2020 bulan Agustus', 400000, '1', 'Chrome 89.0.4389.114', 'Windows 10', '180.253.83.137'),
(40, '2021-04-14 13:35:31', 'Bulanan', 15, 'Pembayaran', 'Hapus', 'SPTahfidz11223314042107', '112233', 'Hapus Bayar-SPP Tahfidz 2019/2020 bulan September', 400000, '1', 'Chrome 89.0.4389.114', 'Windows 10', '36.74.1.18'),
(41, '2021-04-14 13:35:34', 'Bulanan', 16, 'Pembayaran', 'Hapus', 'SPTahfidz11223314042107', '112233', 'Hapus Bayar-SPP Tahfidz 2019/2020 bulan Oktober', 400000, '1', 'Chrome 89.0.4389.114', 'Windows 10', '125.167.68.235'),
(42, '2021-04-14 13:35:38', 'Bulanan', 17, 'Pembayaran', 'Hapus', 'SPTahfidz11223314042107', '112233', 'Hapus Bayar-SPP Tahfidz 2019/2020 bulan November', 400000, '1', 'Chrome 89.0.4389.114', 'Windows 10', '36.73.237.91'),
(43, '2021-04-14 13:35:43', 'Bulanan', 18, 'Pembayaran', 'Hapus', 'SPTahfidz11223314042107', '112233', 'Hapus Bayar-SPP Tahfidz 2019/2020 bulan Desember', 400000, '1', 'Chrome 89.0.4389.114', 'Windows 10', '125.167.68.235'),
(44, '2021-04-14 13:35:47', 'Bulanan', 20, 'Pembayaran', 'Hapus', 'SPTahfidz11223314042107', '112233', 'Hapus Bayar-SPP Tahfidz 2019/2020 bulan Februari', 400000, '1', 'Chrome 89.0.4389.114', 'Windows 10', '180.247.234.200'),
(45, '2021-04-14 13:38:48', 'Bulanan', 13, 'Pembayaran', 'Bayar', 'SPTahfidz11223314042107', '112233', 'Bayar-SPP Tahfidz 2019/2020 bulan Juli', 400000, '1', 'Chrome 89.0.4389.114', 'Windows 10', '180.253.83.137'),
(46, '2021-04-14 13:39:14', 'Bebas', 2, 'Pembayaran', 'Hapus', '', '112233', 'Hapus Pelunasan SPP Tahfidz - T.A 2019/2020', 100000, '1', 'Chrome 89.0.4389.114', 'Windows 10', '180.247.234.200'),
(47, '2021-04-14 13:39:17', 'Bebas', 2, 'Pembayaran', 'Hapus', '', '112233', 'Hapus Pelunasan SPP Tahfidz - T.A 2019/2020', 100000, '1', 'Chrome 89.0.4389.114', 'Windows 10', '180.247.234.200'),
(48, '2021-04-14 13:40:38', 'Bulanan', 13, 'Pembayaran', 'Bayar', 'SPTahfidz11223314042108', '112233', 'Bayar-SPP Tahfidz 2019/2020 bulan Juli', 400000, '1', 'Chrome 89.0.4389.114', 'Windows 10', '180.247.234.200'),
(49, '2021-04-14 13:40:38', 'Bulanan', 13, 'Pembayaran', 'Bayar', 'SPTahfidz11223314042108', '112233', 'Bayar-SPP Tahfidz 2019/2020 bulan Juli', 400000, '1', 'Chrome 89.0.4389.114', 'Windows 10', '36.73.237.91'),
(50, '2021-04-14 13:40:51', 'Bulanan', 13, 'Pembayaran', 'Bayar', 'SPTahfidz11223314042108', '112233', 'Bayar-SPP Tahfidz 2019/2020 bulan Juli', 400000, '1', 'Chrome 89.0.4389.114', 'Windows 10', '125.167.68.235'),
(51, '2021-04-14 13:46:34', 'Bulanan', 25, 'Pembayaran', 'Bayar', 'SPTahfidz11122233314042101', '111222333', 'Bayar-SPP Tahfidz 2019/2020 bulan Juli', 50000, '1', 'Chrome 89.0.4389.114', 'Windows 10', '180.247.234.200'),
(52, '2021-04-14 13:46:39', 'Bulanan', 26, 'Pembayaran', 'Bayar', 'SPTahfidz11122233314042101', '111222333', 'Bayar-SPP Tahfidz 2019/2020 bulan Agustus', 50000, '1', 'Chrome 89.0.4389.114', 'Windows 10', '36.74.1.18'),
(53, '2021-04-15 10:03:37', 'Bulanan', 13, 'Pembayaran', 'Bayar', 'SPTahfidz11223315042110', '112233', 'Bayar-SPP Tahfidz 2019/2020 bulan Juli', 400000, '1', 'Chrome 89.0.4389.114', 'Windows 7', '36.79.206.61'),
(54, '2021-04-15 10:04:06', 'Bulanan', 16, 'Pembayaran', 'Hapus', 'SPTahfidz11223315042110', '112233', 'Hapus Bayar-SPP Tahfidz 2019/2020 bulan Oktober', 400000, '1', 'Chrome 89.0.4389.114', 'Windows 7', '36.79.206.61'),
(55, '2021-04-15 10:04:10', 'Bulanan', 15, 'Pembayaran', 'Hapus', 'SPTahfidz11223315042110', '112233', 'Hapus Bayar-SPP Tahfidz 2019/2020 bulan September', 400000, '1', 'Chrome 89.0.4389.114', 'Windows 7', '36.79.206.61'),
(56, '2021-04-15 10:04:14', 'Bulanan', 14, 'Pembayaran', 'Hapus', 'SPTahfidz11223315042110', '112233', 'Hapus Bayar-SPP Tahfidz 2019/2020 bulan Agustus', 400000, '1', 'Chrome 89.0.4389.114', 'Windows 7', '36.79.206.61'),
(57, '2021-04-15 10:05:56', 'Bulanan', 13, 'Pembayaran', 'Bayar', 'SPTahfidz11223315042110', '112233', 'Bayar-SPP Tahfidz 2019/2020 bulan Juli', 400000, '1', 'Chrome 89.0.4389.114', 'Windows 7', '36.79.206.61'),
(58, '2021-04-15 10:06:08', 'Bulanan', 13, 'Pembayaran', 'Bayar', 'SPTahfidz11223315042110', '112233', 'Bayar-SPP Tahfidz 2019/2020 bulan Juli', 400000, '1', 'Chrome 89.0.4389.114', 'Windows 7', '36.79.206.61'),
(59, '2021-04-15 10:06:08', 'Bulanan', 13, 'Pembayaran', 'Bayar', 'SPTahfidz11223315042110', '112233', 'Bayar-SPP Tahfidz 2019/2020 bulan Juli', 400000, '1', 'Chrome 89.0.4389.114', 'Windows 7', '36.79.206.61'),
(60, '2021-04-15 10:06:14', 'Bulanan', 14, 'Pembayaran', 'Bayar', 'SPTahfidz11223315042110', '112233', 'Bayar-SPP Tahfidz 2019/2020 bulan Agustus', 400000, '1', 'Chrome 89.0.4389.114', 'Windows 7', '36.79.206.61'),
(61, '2021-04-15 10:06:36', 'Bebas', 2, 'Pembayaran', 'Bayar', '', '112233', 'Pelunasan DU Santri Baru - T.A 2019/2020', 50000, '1', 'Chrome 89.0.4389.114', 'Windows 7', '36.79.206.61'),
(62, '2021-04-17 15:25:20', 'Bulanan', 14, 'Pembayaran', 'Bayar', 'SPTahfidz11122233317042102', '111222333', 'Bayar-SPP Tahfidz 2019/2020 bulan Agustus', 200000, '1', 'Chrome 89.0.4389.128', 'Windows 10', '36.68.221.111'),
(63, '2021-04-18 05:25:16', 'Bulanan', 2, 'Pembayaran', 'Bayar', 'SPTahfidz20175566718042105', '201755667', 'Bayar-SPP Tahfidz 2019/2020 bulan Agustus', 50000, '1', 'Chrome 89.0.4389.128', 'Windows 10', '36.79.48.213'),
(64, '2021-04-21 13:25:25', 'Bulanan', 14, 'Pembayaran', 'Bayar', 'SPTahfidz11122233321042103', '111222333', 'Bayar-SPP Tahfidz 2019/2020 bulan Agustus', 200000, '1', 'Chrome 89.0.4389.114', 'Windows 7', '182.253.90.199'),
(65, '2021-04-21 13:37:31', 'Bulanan', 20, 'Pembayaran', 'Hapus', 'SPTahfidz11122233321042103', '111222333', 'Hapus Bayar-SPP Tahfidz 2019/2020 bulan Februari', 200000, '1', 'Chrome 89.0.4389.114', 'Windows 7', '182.253.90.199'),
(66, '2021-04-21 13:37:39', 'Bulanan', 19, 'Pembayaran', 'Hapus', 'SPTahfidz11122233321042103', '111222333', 'Hapus Bayar-SPP Tahfidz 2019/2020 bulan Januari', 200000, '1', 'Chrome 89.0.4389.114', 'Windows 7', '182.253.90.199'),
(67, '2021-04-21 13:37:56', 'Bulanan', 19, 'Pembayaran', 'Bayar', 'SPTahfidz11122233321042103', '111222333', 'Bayar-SPP Tahfidz 2019/2020 bulan Januari', 200000, '1', 'Chrome 89.0.4389.114', 'Windows 7', '182.253.90.199'),
(68, '2021-04-21 13:38:06', 'Bulanan', 20, 'Pembayaran', 'Bayar', 'SPTahfidz11122233321042103', '111222333', 'Bayar-SPP Tahfidz 2019/2020 bulan Februari', 200000, '1', 'Chrome 89.0.4389.114', 'Windows 7', '182.253.90.199'),
(69, '2021-04-21 13:38:07', 'Bulanan', 20, 'Pembayaran', 'Bayar', 'SPTahfidz11122233321042103', '111222333', 'Bayar-SPP Tahfidz 2019/2020 bulan Februari', 200000, '1', 'Chrome 89.0.4389.114', 'Windows 7', '182.253.90.199'),
(70, '2021-04-21 13:38:20', 'Bulanan', 21, 'Pembayaran', 'Bayar', 'SPTahfidz11122233321042103', '111222333', 'Bayar-SPP Tahfidz 2019/2020 bulan Maret', 200000, '1', 'Chrome 89.0.4389.114', 'Windows 7', '182.253.90.199'),
(71, '2021-04-22 09:57:13', 'Bulanan', 22, 'Pembayaran', 'Bayar', 'SPTahfidz11122233322042103', '111222333', 'Bayar-SPP Tahfidz 2019/2020 bulan April', 200000, '1', 'Chrome 89.0.4389.114', 'Windows 7', '182.253.90.114'),
(72, '2021-04-22 10:00:47', 'Bulanan', 23, 'Pembayaran', 'Bayar', 'SPTahfidz11122233322042103', '111222333', 'Bayar-SPP Tahfidz 2019/2020 bulan Mei', 200000, '1', 'Chrome 89.0.4389.114', 'Windows 7', '182.253.90.114'),
(73, '2021-04-23 09:13:14', 'Bulanan', 23, 'Pembayaran', 'Hapus', 'SPTahfidz11122233323042103', '111222333', 'Hapus Bayar-SPP Tahfidz 2019/2020 bulan Mei', 200000, '1', 'Chrome 89.0.4389.114', 'Windows 7', '::1'),
(74, '2021-04-23 09:13:24', 'Bulanan', 23, 'Pembayaran', 'Hapus', 'SPTahfidz11122233323042103', '111222333', 'Hapus Bayar-SPP Tahfidz 2019/2020 bulan Mei', 200000, '1', 'Chrome 89.0.4389.114', 'Windows 7', '::1'),
(75, '2021-04-23 09:14:41', 'Bulanan', 24, 'Pembayaran', 'Bayar', 'SPTahfidz11122233323042103', '111222333', 'Bayar-SPP Tahfidz 2019/2020 bulan Juni', 200000, '1', 'Chrome 89.0.4389.114', 'Windows 7', '::1'),
(76, '2021-04-23 09:15:08', 'Bebas', 2, 'Pembayaran', 'Hapus', '', '111222333', 'Hapus Pelunasan DU Santri Baru - T.A 2019/2020', 100000, '1', 'Chrome 89.0.4389.114', 'Windows 7', '::1'),
(77, '2021-04-23 09:16:52', 'Bebas', 2, 'Pembayaran', 'Hapus', '', '111222333', 'Hapus Pelunasan DU Santri Baru - T.A 2019/2020', 100000, '1', 'Chrome 89.0.4389.114', 'Windows 7', '::1'),
(78, '2021-04-23 09:16:56', 'Bebas', 2, 'Pembayaran', 'Hapus', '', '111222333', 'Hapus Pelunasan DU Santri Baru - T.A 2019/2020', 100000, '1', 'Chrome 89.0.4389.114', 'Windows 7', '::1'),
(79, '2021-04-23 09:17:00', 'Bebas', 2, 'Pembayaran', 'Hapus', '', '111222333', 'Hapus Pelunasan DU Santri Baru - T.A 2019/2020', 100000, '1', 'Chrome 89.0.4389.114', 'Windows 7', '::1'),
(80, '2021-04-23 09:17:03', 'Bebas', 2, 'Pembayaran', 'Hapus', '', '111222333', 'Hapus Pelunasan DU Santri Baru - T.A 2019/2020', 100000, '1', 'Chrome 89.0.4389.114', 'Windows 7', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `log_transaksi`
--

CREATE TABLE `log_transaksi` (
  `idTransaksi` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `modul` varchar(50) NOT NULL,
  `aksi` varchar(100) NOT NULL,
  `info` varchar(255) NOT NULL,
  `penulis` varchar(100) NOT NULL,
  `browser` varchar(50) NOT NULL,
  `os` varchar(50) NOT NULL,
  `ip_address` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `log_transaksi`
--

INSERT INTO `log_transaksi` (`idTransaksi`, `tanggal`, `modul`, `aksi`, `info`, `penulis`, `browser`, `os`, `ip_address`) VALUES
(1, '2021-04-16 01:14:28', 'Pembayaran', 'Bayar Bebas', 'NIS:201755667;Title:Bayar DU Santri Baru T.A. 2019/2020 nominal 300000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(2, '2021-04-16 01:53:36', 'Pembayaran', 'Bayar Bulanan', 'NIS:201755667;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 100000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(3, '2021-04-16 01:56:37', 'Pembayaran', 'Bayar Bulanan', 'NIS:201755667;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 150000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(4, '2021-04-17 03:37:14', 'Pembayaran', 'Bayar Bulanan', 'NIS:201755667;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 55000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(5, '2021-04-17 03:37:55', 'Pembayaran', 'Bayar Bulanan', 'NIS:201755667;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 55000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(6, '2021-04-17 04:27:12', 'Pembayaran', 'Bayar Bulanan', 'NIS:201755667;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 55000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(7, '2021-04-17 04:34:20', 'Pembayaran', 'Bayar Bulanan', 'NIS:201755667;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 55000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(8, '2021-04-17 04:35:57', 'Pembayaran', 'Bayar Bulanan', 'NIS:201755667;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 55000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(9, '2021-04-17 04:36:22', 'Pembayaran', 'Bayar Bulanan', 'NIS:201755667;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 50000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(10, '2021-04-17 04:37:39', 'Pembayaran', 'Bayar Bulanan', 'NIS:201755667;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 50000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(11, '2021-04-17 04:45:03', 'Pembayaran', 'Bayar Bulanan', 'NIS:201755667;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 50000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(12, '2021-04-17 04:59:27', 'Pembayaran', 'Bayar Bulanan', 'NIS:201755667;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 50000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(13, '2021-04-17 05:01:27', 'Pembayaran', 'Bayar Bulanan', 'NIS:201755667;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 50000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(14, '2021-04-17 05:03:43', 'Pembayaran', 'Bayar Bulanan', 'NIS:201755667;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 50000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(15, '2021-04-17 05:07:49', 'Pembayaran', 'Bayar Bulanan', 'NIS:201755667;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 50000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(16, '2021-04-17 05:10:35', 'Pembayaran', 'Bayar Bulanan', 'NIS:201755667;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 50000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(17, '2021-04-17 05:12:17', 'Pembayaran', 'Bayar Bulanan', 'NIS:201755667;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 50000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(18, '2021-04-17 05:15:01', 'Pembayaran', 'Bayar Bulanan', 'NIS:201755667;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 55000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(19, '2021-04-17 15:21:23', 'Pembayaran', 'Bayar Bulanan', 'NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 200000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(20, '2021-04-17 15:22:58', 'Pembayaran', 'Bayar Bulanan', 'NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 200000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(21, '2021-04-17 15:25:20', 'Pembayaran', 'Bayar Bulanan', 'NIS:111222333;Title:Bayar-SPP Tahfidz 2019/2020 bulan Agustus nominal 200000', '1', 'Chrome 89.0.4389.128', 'Windows 10', '36.68.221.111'),
(22, '0000-00-00 00:00:00', 'Pembayaran', 'Simpan Pembayaran', 'NIS:111222333;Title:Simpan No. Ref: SPTahfidz11122233317042102', '', 'Chrome 89.0.4389.128', 'Windows 10', '36.68.221.111'),
(23, '2021-04-17 15:28:41', 'Pembayaran', 'Bayar Bulanan', 'NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 200000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(24, '2021-04-17 15:33:19', 'Pembayaran', 'Bayar Bebas', 'NIS:111222333;Title:Bayar DU Santri Baru T.A. 2019/2020 nominal 100000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(25, '2021-04-17 15:34:57', 'Pembayaran', 'Bayar Bebas', 'NIS:111222333;Title:Bayar DU Santri Baru T.A. 2019/2020 nominal 100000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(26, '2021-04-17 15:40:51', 'Pembayaran', 'Bayar Bebas', 'NIS:111222333;Title:Bayar DU Santri Baru T.A. 2019/2020 nominal 100000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(27, '2021-04-17 15:42:20', 'Pembayaran', 'Bayar Bulanan', 'NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 200000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(28, '2021-04-17 15:52:39', 'Pembayaran', 'Bayar Bebas', 'NIS:111222333;Title:Bayar DU Santri Baru T.A. 2019/2020 nominal 100000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(29, '2021-04-17 16:10:12', 'Pembayaran', 'Bayar Bulanan', 'NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 200000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(30, '2021-04-17 16:18:21', 'Pembayaran', 'Bayar Bulanan', 'NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 200000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(31, '2021-04-17 16:19:15', 'Pembayaran', 'Bayar Bulanan', 'NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 200000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(32, '2021-04-17 16:26:35', 'Pembayaran', 'Bayar Bulanan', 'NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 200000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(33, '2021-04-17 16:37:50', 'Pembayaran', 'Bayar Bulanan', 'NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 200000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(34, '2021-04-17 16:41:57', 'Pembayaran', 'Bayar Bebas', 'NIS:111222333;Title:Bayar DU Santri Baru T.A. 2019/2020 nominal 100000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(35, '2021-04-17 17:03:40', 'Pembayaran', 'Bayar Bulanan', 'NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 200000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(36, '2021-04-17 17:45:39', 'Pembayaran', 'Bayar Bulanan', 'NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 200000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(37, '2021-04-17 17:54:49', 'Pembayaran', 'Bayar Bebas', 'NIS:111222333;Title:Bayar DU Santri Baru T.A. 2019/2020 nominal 100000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(38, '2021-04-17 18:30:45', 'Pembayaran', 'Bayar Bulanan', 'NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 200000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(39, '2021-04-18 05:25:16', 'Pembayaran', 'Bayar Bulanan', 'NIS:201755667;Title:Bayar-SPP Tahfidz 2019/2020 bulan Agustus nominal 50000', '1', 'Chrome 89.0.4389.128', 'Windows 10', '36.79.48.213'),
(40, '2021-04-18 11:10:35', 'Pembayaran', 'Bayar Bulanan', 'NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 400000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(41, '2021-04-18 11:11:13', 'Pembayaran', 'Bayar Bulanan', 'NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 400000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(42, '2021-04-18 11:17:37', 'Pembayaran', 'Bayar Bulanan', 'NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 400000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(43, '2021-04-21 11:30:33', 'Pembayaran', 'Bayar Bulanan', 'NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 600000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(44, '2021-04-21 11:32:43', 'Pembayaran', 'Bayar Bulanan', 'NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 600000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(45, '2021-04-21 11:36:49', 'Pembayaran', 'Bayar Bulanan', 'NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 600000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(46, '2021-04-21 11:50:24', 'Pembayaran', 'Bayar Bulanan', 'NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 600000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(47, '2021-04-21 12:30:12', 'Pembayaran', 'Bayar Bulanan', 'NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 600000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(48, '2021-04-21 13:25:25', 'Pembayaran', 'Bayar Bulanan', 'NIS:111222333;Title:Bayar-SPP Tahfidz 2019/2020 bulan Agustus nominal 200000', '1', 'Chrome 89.0.4389.114', 'Windows 7', '182.253.90.199'),
(49, '2021-04-21 13:37:31', 'Pembayaran', 'Hapus Bayar Bulanan', 'NIS:111222333;Title:Hapus Bayar-SPP Tahfidz 2019/2020 bulan Februari nominal 200000', '1', 'Chrome 89.0.4389.114', 'Windows 7', '182.253.90.199'),
(50, '2021-04-21 13:37:39', 'Pembayaran', 'Hapus Bayar Bulanan', 'NIS:111222333;Title:Hapus Bayar-SPP Tahfidz 2019/2020 bulan Januari nominal 200000', '1', 'Chrome 89.0.4389.114', 'Windows 7', '182.253.90.199'),
(51, '2021-04-21 13:37:56', 'Pembayaran', 'Bayar Bulanan', 'NIS:111222333;Title:Bayar-SPP Tahfidz 2019/2020 bulan Januari nominal 200000', '1', 'Chrome 89.0.4389.114', 'Windows 7', '182.253.90.199'),
(52, '2021-04-21 13:38:06', 'Pembayaran', 'Bayar Bulanan', 'NIS:111222333;Title:Bayar-SPP Tahfidz 2019/2020 bulan Februari nominal 200000', '1', 'Chrome 89.0.4389.114', 'Windows 7', '182.253.90.199'),
(53, '2021-04-21 13:38:07', 'Pembayaran', 'Bayar Bulanan', 'NIS:111222333;Title:Bayar-SPP Tahfidz 2019/2020 bulan Februari nominal 200000', '1', 'Chrome 89.0.4389.114', 'Windows 7', '182.253.90.199'),
(54, '2021-04-21 13:38:20', 'Pembayaran', 'Bayar Bulanan', 'NIS:111222333;Title:Bayar-SPP Tahfidz 2019/2020 bulan Maret nominal 200000', '1', 'Chrome 89.0.4389.114', 'Windows 7', '182.253.90.199'),
(55, '2021-04-21 13:55:57', 'Pembayaran', 'Bayar Bulanan', 'NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 600000', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(56, '2021-04-22 09:57:13', 'Pembayaran', 'Bayar Bulanan', 'NIS:111222333;Title:Bayar-SPP Tahfidz 2019/2020 bulan April nominal 200000', '1', 'Chrome 89.0.4389.114', 'Windows 7', '182.253.90.114'),
(57, '2021-04-22 10:00:47', 'Pembayaran', 'Bayar Bulanan', 'NIS:111222333;Title:Bayar-SPP Tahfidz 2019/2020 bulan Mei nominal 200000', '1', 'Chrome 89.0.4389.114', 'Windows 7', '182.253.90.114'),
(58, '2021-04-23 09:13:14', 'Pembayaran', 'Hapus Bayar Bulanan', 'NIS:111222333;Title:Hapus Bayar-SPP Tahfidz 2019/2020 bulan Mei nominal 200000', '1', 'Chrome 89.0.4389.114', 'Windows 7', '::1'),
(59, '2021-04-23 09:13:24', 'Pembayaran', 'Hapus Bayar Bulanan', 'NIS:111222333;Title:Hapus Bayar-SPP Tahfidz 2019/2020 bulan Mei nominal 200000', '1', 'Chrome 89.0.4389.114', 'Windows 7', '::1'),
(60, '2021-04-23 09:14:41', 'Pembayaran', 'Bayar Bulanan', 'NIS:111222333;Title:Bayar-SPP Tahfidz 2019/2020 bulan Juni nominal 200000', '1', 'Chrome 89.0.4389.114', 'Windows 7', '::1'),
(61, '2021-04-23 09:15:08', 'Pembayaran', 'Hapus Bayar Bebas', 'NIS:111222333;Title:Hapus Pelunasan DU Santri Baru - T.A 2019/2020 nominal 100000', '1', 'Chrome 89.0.4389.114', 'Windows 7', '::1'),
(62, '2021-04-23 09:16:52', 'Pembayaran', 'Hapus Bayar Bebas', 'NIS:111222333;Title:Hapus Pelunasan DU Santri Baru - T.A 2019/2020 nominal 100000', '1', 'Chrome 89.0.4389.114', 'Windows 7', '::1'),
(63, '2021-04-23 09:16:56', 'Pembayaran', 'Hapus Bayar Bebas', 'NIS:111222333;Title:Hapus Pelunasan DU Santri Baru - T.A 2019/2020 nominal 100000', '1', 'Chrome 89.0.4389.114', 'Windows 7', '::1'),
(64, '2021-04-23 09:17:00', 'Pembayaran', 'Hapus Bayar Bebas', 'NIS:111222333;Title:Hapus Pelunasan DU Santri Baru - T.A 2019/2020 nominal 100000', '1', 'Chrome 89.0.4389.114', 'Windows 7', '::1'),
(65, '2021-04-23 09:17:03', 'Pembayaran', 'Hapus Bayar Bebas', 'NIS:111222333;Title:Hapus Pelunasan DU Santri Baru - T.A 2019/2020 nominal 100000', '1', 'Chrome 89.0.4389.114', 'Windows 7', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `memodb`
--

CREATE TABLE `memodb` (
  `kwnum` varchar(20) NOT NULL,
  `nominal` int(11) NOT NULL,
  `payee` varchar(25) NOT NULL,
  `pic` varchar(25) NOT NULL,
  `tglkw` varchar(20) NOT NULL,
  `ktrg` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `idMenu` int(11) NOT NULL,
  `noMenu` int(11) DEFAULT NULL,
  `namaMenu` varchar(255) DEFAULT NULL,
  `iconMenu` varchar(100) DEFAULT NULL,
  `lokasiFileMenu` varchar(255) DEFAULT NULL,
  `ketMenu` varchar(255) DEFAULT NULL,
  `viewMenu` varchar(100) DEFAULT NULL,
  `level` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`idMenu`, `noMenu`, `namaMenu`, `iconMenu`, `lokasiFileMenu`, `ketMenu`, `viewMenu`, `level`) VALUES
(1, NULL, 'Dashboard', 'fa fa-dashboard', 'admin/home_admin.php', 'Main Menu', 'dashboard', 'Admin'),
(2, NULL, 'Kesantrian', 'fa fa-users', '-', 'Main Menu', '-', 'Admin'),
(3, 2, 'Unit Sekolah', 'fa fa-circle-o', 'admin/master_unit_sekolah.php', 'Sub Menu 1', 'unit sekolah', 'Admin'),
(4, 2, 'Kelas', 'fa fa-circle-o', 'admin/master_kelas.php', 'Sub Menu 1', 'kelas', 'Admin'),
(5, 2, 'Kamar', 'fa fa-circle-o', 'admin/master_kamar.php', 'Sub Menu 1', 'kamar', 'Admin'),
(6, 2, 'Santri', 'fa fa-circle-o', 'admin/master_siswa.php', 'Sub Menu 1', 'santri', 'Admin'),
(7, 2, 'Tahfidz', 'fa fa-circle-o', 'admin/master_tahfidz.php', 'Sub Menu 1', 'tahfidz', 'Admin'),
(8, 2, 'Kesehatan', 'fa fa-circle-o', 'admin/master_kesehatan.php', 'Sub Menu 1', 'kesehatan', 'Admin'),
(9, 2, 'Konseling', 'fa fa-circle-o', '-', 'Sub Menu 1', '-', 'Admin'),
(10, NULL, 'Kepegawaian', 'fa fa-suitcase', '-', 'Main Menu', '-', 'Admin'),
(11, 10, 'Jabatan Pegawai', 'fa fa-circle-o', 'admin/master_jabatan.php', 'Sub Menu 1', 'jabatan pegawai', 'Admin'),
(12, 10, 'Pegawai', 'fa fa-circle-o', 'admin/master_pegawai.php', 'Sub Menu 1', 'pegawai', 'Admin'),
(13, NULL, 'Akademik', 'fa fa-graduation-cap', '-', 'Main Menu', '-', 'Admin'),
(14, 13, 'Tahun Ajaran', 'fa fa-circle-o', 'admin/master_tahun.php', 'Sub Menu 1', 'tahun ajaran', 'Admin'),
(15, 13, 'Pindah Kelas', 'fa fa-circle-o', 'admin/master_kenaikankelas.php', 'Sub Menu 1', 'pindah kelas', 'Admin'),
(16, 13, 'Kelulusan', 'fa fa-circle-o', 'admin/master_kelulusan.php', 'Sub Menu 1', 'kelulusan', 'Admin'),
(17, NULL, 'Keuangan', 'fa fa-money', '-', 'Main Menu', '-', 'Admin'),
(18, 17, 'Pembayaran Santri', 'fa fa-circle-o', 'admin/master_pembayaransiswa.php', 'Sub Menu 1', 'pembayaran santri', 'Admin'),
(19, 17, 'Setting Pembayaran', 'fa fa-circle-o', '-', 'Sub Menu 1', '-', 'Admin'),
(20, 19, 'Akun Biaya', 'fa fa-circle-o', 'admin/master_akunbiaya.php', 'Sub Menu 2', 'akun biaya', 'Admin'),
(21, 19, 'Pos Bayar', 'fa fa-circle-o', 'admin/master_posbayar.php', 'Sub Menu 2', 'pos bayar', 'Admin'),
(22, 19, 'Jenis Bayar', 'fa fa-circle-o', 'admin/master_jenisbayar.php', 'Sub Menu 2', 'jenis bayar', 'Admin'),
(23, 19, 'Pajak', 'fa fa-circle-o', 'admin/master_pajak.php', 'Sub Menu 2', 'pajak', 'Admin'),
(24, 19, 'Unit Pos', 'fa fa-circle-o', 'admin/master_unitpos.php', 'Sub Menu 2', 'unit pos', 'Admin'),
(25, 17, 'Tabungan Santri', 'fa fa-circle-o', 'admin/master_tabungansantri.php', 'Sub Menu 1', 'tabungan santri', 'Admin'),
(26, 17, 'Kas & Bank', 'fa fa-circle-o', '-', 'Sub Menu 1', '-', 'Admin'),
(27, 26, 'Saldo Awal', 'fa fa-circle-o', 'admin/master_saldoawal.php', 'Sub Menu 2', 'saldo awal', 'Admin'),
(28, 26, 'Kas Keluar', 'fa fa-circle-o', 'admin/master_kaskeluar.php', 'Sub Menu 2', 'kas keluar', 'Admin'),
(29, 26, 'Kas Masuk', 'fa fa-circle-o', 'admin/master_kasmasuk.php', 'Sub Menu 2', 'kas masuk', 'Admin'),
(30, 26, 'Transfer Kas', 'fa fa-circle-o', 'admin/master_transferkas.php', 'Sub Menu 2', 'transfer kas', 'Admin'),
(31, 26, 'Rekonsiliasi Bank', 'fa fa-circle-o', 'admin/master_rekonsiliasibank.php', 'Sub Menu 2', 'rekonsiliasi bank', 'Admin'),
(32, 17, 'Penggajian', 'fa fa-circle-o', '-', 'Sub Menu 1', '-', 'Admin'),
(33, 32, 'Setting Gaji', 'fa fa-circle-o', 'admin/master_settinggaji.php', 'Sub Menu 2', 'setting gaji', 'Admin'),
(34, 32, 'Slip Gaji', 'fa fa-circle-o', 'admin/master_slipgaji.php', 'Sub Menu 2', 'slip gaji', 'Admin'),
(35, 17, 'Hutang', 'fa fa-circle-o', '-', 'Sub Menu 1', '-', 'Admin'),
(36, 35, 'Pos Hutang', 'fa fa-circle-o', 'admin/master_poshutang.php', 'Sub Menu 2', 'pos hutang', 'Admin'),
(37, 35, 'Setting Hutang', 'fa fa-circle-o', 'admin/master_settinghutang.php', 'Sub Menu 2', 'setting hutang', 'Admin'),
(38, 35, 'Bayar Hutang', 'fa fa-circle-o', 'admin/master_bayarhutang.php', 'Sub Menu 2', 'bayar hutang', 'Admin'),
(39, 17, 'Kirim Tagihan', 'fa fa-circle-o', 'admin/master_kirimtagihan.php', 'Sub Menu 1', 'kirim tagihan', 'Admin'),
(40, NULL, 'Laporan', 'fa fa-file-text-o', '-', 'Main Menu', '-', 'Admin'),
(41, 40, 'Lap. Pembayaran', 'fa fa-circle-o', '-', 'Sub Menu 1', '-', 'Admin'),
(42, 41, 'Per Kelas', 'fa fa-circle-o', 'admin/master_laporanperkelas.php', 'Sub Menu 2', 'laporan perkelas', 'Admin'),
(43, 41, 'Per Tanggal', 'fa fa-circle-o', 'admin/master_laporanpertanggal.php', 'Sub Menu 2', 'laporan pertanggal', 'Admin'),
(44, 41, 'Tagihan Santri', 'fa fa-circle-o', 'admin/master_laporantagihansiswa.php', 'Sub Menu 2', 'laporan tagihan santri', 'Admin'),
(45, 41, 'Rekap Pembayaran', 'fa fa-circle-o', 'admin/master_laporanrekappembayaran.php', 'Sub Menu 2', 'laporan rekap pembayaran', 'Admin'),
(46, 40, 'Lap. Keuangan', 'fa fa-circle-o', '-', 'Sub Menu 1', '-', 'Admin'),
(47, 46, 'Lap. Jurnal (Kas)', 'fa fa-circle-o', 'admin/master_laporanjurnal.php', 'Sub Menu 2', 'laporan kas tunai', 'Admin'),
(48, 46, 'Lap. Kas Bank', 'fa fa-circle-o', 'admin/master_laporankasbank.php', 'Sub Menu 2', 'laporan kas bank', 'Admin'),
(49, 46, 'Lap. Neraca', 'fa fa-circle-o', 'admin/master_laporanneraca.php', 'Sub Menu 2', 'laporan neraca', 'Admin'),
(50, 40, 'Lap. Tabungan', '	\r\nfa fa-circle-o', 'admin/master_laporantabungan.php', 'Sub Menu 1', 'laporan tabungan', 'Admin'),
(51, NULL, 'Pengaturan', 'fa fa-gear', '-', 'Main Menu', '-', 'Admin'),
(52, 51, 'Identitas Sekolah', 'fa fa-circle-o', 'admin/master_identitassekolah.php', 'Sub Menu 1', 'identitas', 'Admin'),
(53, 51, 'Bulan', 'fa fa-circle-o', 'admin/master_bulan.php', 'Sub Menu 1', 'bulan', 'Admin'),
(54, 51, 'Informasi', 'fa fa-circle-o', 'admin/master_informasi.php', 'Sub Menu 1', 'informasi', 'Admin'),
(55, 51, 'Manajemen Pengguna', 'fa fa-circle-o', 'admin/master_pengguna.php', 'Sub Menu 1', 'pengguna', 'Admin'),
(56, 51, 'Pemeliharaan', 'fa fa-circle-o', 'admin/master_pemeliharaan.php', 'Sub Menu 1', 'pemeliharaan', 'Admin'),
(57, 51, 'Logs Transaksi', 'fa fa-circle-o', 'admin/master_logtransaksi.php', 'Sub Menu 1', 'logs transaksi', 'Admin'),
(58, NULL, 'Dashboard', 'fa fa-dashboard', 'siswa/home_siswa.php', 'Main Menu', 'dashboard', 'Siswa'),
(59, NULL, 'Profil', 'fa fa-user', 'siswa/master_siswa.php', 'Main Menu', 'profil', 'Siswa'),
(60, NULL, 'Pembayaran', 'fa fa-money', 'siswa/master_pembayaran.php', 'Main Menu', 'cek pembayaran', 'Siswa'),
(61, 9, 'Perizinan', 'fa fa-circle-o', 'admin/master_perizinan.php', 'Sub Menu 2', 'perizinan', 'Admin'),
(62, 9, 'Pelanggaran', 'fa fa-circle-o', 'admin/master_pelanggaran.php', 'Sub Menu 2', 'pelanggaran', 'Admin'),
(63, 40, 'Lap. Kesehatan', 'fa fa-circle-o', 'admin/master_laporankesehatan.php', 'Sub Menu 1', 'laporan kesehatan', 'Admin'),
(64, 40, 'Lap. Konseling', 'fa fa-circle-o', '-', 'Sub Menu 1', '-', 'Admin'),
(65, 64, 'Lap. Perizinan', 'fa fa-circle-o', 'admin/master_laporanperizinan.php', 'Sub Menu 2', 'laporan perizinan', 'Admin'),
(66, 64, 'Lap. Pelanggaran', 'fa fa-circle-o', 'admin/master_laporanpelanggaran.php', 'Sub Menu 2', 'laporan pelanggaran', 'Admin'),
(67, 46, 'Lap. Kas Kasir', 'fa fa-circle-o', 'admin/master_laporankaskasir.php', 'Sub Menu 2', 'laporan kas kasir', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `pajak`
--

CREATE TABLE `pajak` (
  `idPajak` int(11) NOT NULL,
  `nmPajak` varchar(50) NOT NULL,
  `besaranPajak` double NOT NULL,
  `stdel` int(11) DEFAULT '0',
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pajak`
--

INSERT INTO `pajak` (`idPajak`, `nmPajak`, `besaranPajak`, `stdel`, `cby`, `cdate`, `uby`, `udate`, `dby`, `ddate`) VALUES
(1, 'AAA', 2.5, 0, 1, '2021-01-28 16:08:28', NULL, NULL, NULL, NULL),
(2, 'www', 1.7, 0, 1, '2021-01-28 16:09:04', NULL, NULL, NULL, NULL),
(3, '22', 10, 1, 1, '2021-01-28 16:09:04', 1, '2021-01-28 16:13:25', 1, '2021-01-28 16:13:29');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `idPegawai` int(11) NOT NULL,
  `nipPegawai` varchar(100) DEFAULT NULL,
  `namaPegawai` varchar(255) NOT NULL,
  `jkPegawai` varchar(50) DEFAULT NULL,
  `tempatLahirPegawai` varchar(255) DEFAULT NULL,
  `tglLahirPegawai` date DEFAULT NULL,
  `pendidikanPegawai` varchar(255) DEFAULT NULL,
  `unitPegawai` int(11) DEFAULT NULL,
  `jabatanPegawai` int(11) DEFAULT NULL,
  `statusKepegawaian` varchar(255) DEFAULT NULL,
  `alamatPegawai` varchar(255) DEFAULT NULL,
  `passwordPegawai` varchar(255) NOT NULL,
  `noHpPegawai` varchar(20) DEFAULT NULL,
  `emailPegawai` varchar(100) DEFAULT NULL,
  `tglMasukPegawai` date DEFAULT NULL,
  `tglKeluarPegawai` date DEFAULT NULL,
  `statusPegawai` enum('Aktif','Tidak Aktif') DEFAULT NULL,
  `fotoPegawai` varchar(255) DEFAULT NULL,
  `stdel` int(11) DEFAULT '0',
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`idPegawai`, `nipPegawai`, `namaPegawai`, `jkPegawai`, `tempatLahirPegawai`, `tglLahirPegawai`, `pendidikanPegawai`, `unitPegawai`, `jabatanPegawai`, `statusKepegawaian`, `alamatPegawai`, `passwordPegawai`, `noHpPegawai`, `emailPegawai`, `tglMasukPegawai`, `tglKeluarPegawai`, `statusPegawai`, `fotoPegawai`, `stdel`, `cby`, `cdate`, `uby`, `udate`, `dby`, `ddate`) VALUES
(15, '201806001', 'Abdullah', NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, 'e10adc3949ba59abbe56e057f20f883e', NULL, NULL, NULL, NULL, 'Aktif', NULL, 0, 1, '2021-02-18 22:51:57', NULL, NULL, NULL, NULL),
(16, '201806002', 'MMM', '', '', '0000-00-00', '', 1, 3, 'Pegawai Tetap', '', 'e10adc3949ba59abbe56e057f20f883e', '', '', '0000-00-00', '0000-00-00', 'Aktif', 'download.jpg', 0, 1, '2021-02-18 22:51:57', 1, '2021-02-18 23:01:56', NULL, NULL),
(17, '201806001', 'Abdullah', NULL, NULL, NULL, NULL, 1, 1, 'Pegawai Tetap', NULL, 'e10adc3949ba59abbe56e057f20f883e', NULL, NULL, NULL, NULL, 'Aktif', NULL, 0, 1, '2021-02-18 23:15:25', NULL, NULL, NULL, NULL),
(18, '201806002', 'Dullah', NULL, NULL, NULL, NULL, 1, 1, 'Pegawai Tidak Tetap', NULL, 'e10adc3949ba59abbe56e057f20f883e', NULL, NULL, NULL, NULL, 'Aktif', NULL, 0, 1, '2021-02-18 23:15:25', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pegawai_gaji`
--

CREATE TABLE `pegawai_gaji` (
  `idGaji` int(11) NOT NULL,
  `idPegawai` int(11) DEFAULT NULL,
  `idAkunGaji` int(11) DEFAULT NULL,
  `gajiPokok` double DEFAULT NULL,
  `gajiLain` double DEFAULT NULL,
  `potonganSimpanan` double DEFAULT NULL,
  `potonganBPJSTK` double DEFAULT NULL,
  `potonganSumbangan` double DEFAULT NULL,
  `potonganKoperasi` double DEFAULT NULL,
  `potonganBPJS` double DEFAULT NULL,
  `potonganPinjaman` double DEFAULT NULL,
  `potonganLain` double DEFAULT NULL,
  `stdel` int(11) DEFAULT '0',
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pegawai_gaji`
--

INSERT INTO `pegawai_gaji` (`idGaji`, `idPegawai`, `idAkunGaji`, `gajiPokok`, `gajiLain`, `potonganSimpanan`, `potonganBPJSTK`, `potonganSumbangan`, `potonganKoperasi`, `potonganBPJS`, `potonganPinjaman`, `potonganLain`, `stdel`, `cby`, `cdate`, `uby`, `udate`, `dby`, `ddate`) VALUES
(2, 12, 63, 5000000, 1000000, 100000, 0, 0, 0, 0, 0, 0, 0, 1, '2021-02-01 11:29:42', 1, '2021-02-02 11:44:02', NULL, NULL),
(3, 13, 63, 5000000, 1000000, 50000, 0, 0, 0, 0, 0, 0, 0, 1, '2021-02-11 22:58:15', NULL, NULL, NULL, NULL),
(4, 15, 63, 5000000, 100000, 0, 0, 0, 0, 0, 0, 0, 0, 1, '2021-02-22 22:39:05', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pegawai_gaji_slip`
--

CREATE TABLE `pegawai_gaji_slip` (
  `idSlipGaji` int(11) NOT NULL,
  `idGaji` int(11) DEFAULT NULL,
  `noRefrensi` varchar(100) NOT NULL,
  `tanggal` date NOT NULL,
  `idPegawai` int(11) NOT NULL,
  `idAkunKas` int(11) NOT NULL,
  `idBulan` int(11) NOT NULL,
  `idTahunAjaran` int(11) NOT NULL,
  `gajiPokok` double DEFAULT NULL,
  `gajiLain` double DEFAULT NULL,
  `potonganSimpanan` double DEFAULT NULL,
  `potonganBPJSTK` double DEFAULT NULL,
  `potonganSumbangan` double DEFAULT NULL,
  `potonganKoperasi` double DEFAULT NULL,
  `potonganBPJS` double DEFAULT NULL,
  `potonganPinjaman` double DEFAULT NULL,
  `potonganLain` double DEFAULT NULL,
  `stdel` int(11) DEFAULT '0',
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pegawai_gaji_slip`
--

INSERT INTO `pegawai_gaji_slip` (`idSlipGaji`, `idGaji`, `noRefrensi`, `tanggal`, `idPegawai`, `idAkunKas`, `idBulan`, `idTahunAjaran`, `gajiPokok`, `gajiLain`, `potonganSimpanan`, `potonganBPJSTK`, `potonganSumbangan`, `potonganKoperasi`, `potonganBPJS`, `potonganPinjaman`, `potonganLain`, `stdel`, `cby`, `cdate`, `uby`, `udate`, `dby`, `ddate`) VALUES
(21, 2, 'GKTahfidz201805022101', '2021-02-05', 12, 15, 7, 3, 5000000, 1000000, 100000, 0, 0, 0, 0, 0, 0, 1, 1, '2021-02-05 23:45:51', NULL, NULL, 1, '2021-02-05 23:48:07'),
(22, 0, 'GKTahfidz123545506022101', '2021-02-06', 13, 15, 7, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, '2021-02-06 13:24:52', NULL, NULL, 1, '2021-02-08 12:57:33'),
(23, 3, 'GKTahfidz123545511022101', '2021-02-11', 13, 15, 7, 3, 5000000, 1000000, 50000, 0, 0, 0, 0, 0, 0, 1, 1, '2021-02-11 22:58:33', NULL, NULL, 1, '2021-02-12 00:58:16'),
(24, 3, 'GKTahfidz123545512022101', '2021-02-12', 13, 15, 8, 3, 5000000, 1000000, 50000, 0, 0, 0, 0, 0, 0, 1, 1, '2021-02-12 00:56:04', NULL, NULL, 1, '2021-02-12 00:57:04'),
(25, 3, 'GKTahfidz123545512022101', '2021-02-12', 13, 15, 8, 3, 5000000, 1000000, 50000, 100000, 0, 0, 0, 0, 0, 1, 1, '2021-02-12 00:57:37', NULL, NULL, 1, '2021-02-15 02:02:50'),
(26, 3, 'GKTahfidz123545514022101', '2021-02-14', 13, 16, 7, 3, 5000000, 1000000, 50000, 0, 0, 0, 0, 0, 0, 1, 1, '2021-02-14 01:17:49', NULL, NULL, 1, '2021-02-15 01:53:21'),
(27, 4, 'GKTahfidz20180600122022101', '2021-02-22', 15, 15, 7, 3, 5000000, 100000, 0, 0, 0, 0, 0, 0, 0, 1, 1, '2021-02-22 22:39:25', NULL, NULL, 1, '2021-02-22 22:43:34'),
(28, 4, 'GKTahfidz20180600122022101', '2021-02-22', 15, 15, 7, 3, 5000000, 100000, 0, 0, 0, 0, 0, 0, 0, 0, 1, '2021-02-22 22:49:21', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pegawai_jabatan`
--

CREATE TABLE `pegawai_jabatan` (
  `idPegawaiJabatan` int(11) NOT NULL,
  `idPegawai` int(11) NOT NULL,
  `jabatanMulai` date NOT NULL,
  `jabatanSelesai` date NOT NULL,
  `jabatanKeterangan` varchar(25) NOT NULL,
  `stdel` int(11) DEFAULT NULL,
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pegawai_jabatan`
--

INSERT INTO `pegawai_jabatan` (`idPegawaiJabatan`, `idPegawai`, `jabatanMulai`, `jabatanSelesai`, `jabatanKeterangan`, `stdel`, `cby`, `cdate`, `uby`, `udate`, `dby`, `ddate`) VALUES
(1, 1, '2021-01-09', '2021-01-23', 'dsdfdsf', 0, 1, '2021-01-20 12:17:23', NULL, NULL, NULL, NULL),
(2, 1, '2021-01-09', '2021-01-15', 'ssss', 1, 1, '2021-01-20 12:17:23', NULL, NULL, 1, '2021-01-25 01:11:48'),
(3, 1, '2021-01-23', '2021-01-30', '4565789', 1, 1, '2021-01-20 12:45:32', NULL, NULL, 1, '2021-01-20 13:36:26'),
(4, 1, '2021-01-30', '2021-01-23', '12', 1, 1, '2021-01-20 13:35:25', NULL, NULL, 1, '2021-01-20 13:36:34'),
(5, 1, '2021-01-23', '2021-01-30', '12345', 0, 1, '2021-01-20 13:35:25', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pegawai_keluarga`
--

CREATE TABLE `pegawai_keluarga` (
  `idKeluarga` int(11) NOT NULL,
  `idPegawai` int(11) NOT NULL,
  `keluargaNama` varchar(100) NOT NULL,
  `keluargaHubungan` varchar(50) NOT NULL,
  `stdel` int(11) DEFAULT NULL,
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pegawai_keluarga`
--

INSERT INTO `pegawai_keluarga` (`idKeluarga`, `idPegawai`, `keluargaNama`, `keluargaHubungan`, `stdel`, `cby`, `cdate`, `uby`, `udate`, `dby`, `ddate`) VALUES
(1, 0, '0', '2', 0, 1, '2021-01-20 11:14:18', NULL, NULL, NULL, NULL),
(2, 0, '0', '3', 0, 1, '2021-01-20 11:14:18', NULL, NULL, NULL, NULL),
(3, 1, '1111', '0', 1, 1, '2021-01-20 11:19:19', NULL, NULL, 1, '2021-01-20 11:21:07'),
(4, 1, '22222', '0', 1, 1, '2021-01-20 11:19:19', NULL, NULL, 1, '2021-01-20 11:21:11'),
(5, 1, 'aaaa', 'Istri', 1, 1, '2021-01-20 11:21:02', NULL, NULL, 1, '2021-01-20 11:21:15'),
(6, 1, 'bbbb', 'Suami', 0, 1, '2021-01-20 11:21:02', NULL, NULL, NULL, NULL),
(7, 1, 'cccc', 'Anak', 1, 1, '2021-01-20 11:21:02', NULL, NULL, 1, '2021-01-20 13:32:34'),
(8, 1, '1111', 'Anak', 1, 1, '2021-01-20 12:44:15', NULL, NULL, 1, '2021-01-20 12:45:53'),
(9, 1, '2222', 'Ibu', 1, 1, '2021-01-20 12:44:15', NULL, NULL, 1, '2021-01-20 12:45:47'),
(10, 1, '111', 'Suami', 1, 1, '2021-01-20 13:35:00', NULL, NULL, 1, '2021-01-20 13:35:05'),
(11, 1, '2222', 'Ayah', 1, 1, '2021-01-20 13:35:00', NULL, NULL, 1, '2021-01-25 01:11:44');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai_mengajar`
--

CREATE TABLE `pegawai_mengajar` (
  `idMengajar` int(1) NOT NULL,
  `idPegawai` int(11) NOT NULL,
  `mengajarMulai` date NOT NULL,
  `mengajarSelesai` date NOT NULL,
  `mengajarMP` varchar(100) NOT NULL,
  `mengajarKeterangan` varchar(255) NOT NULL,
  `stdel` int(11) DEFAULT NULL,
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pegawai_mengajar`
--

INSERT INTO `pegawai_mengajar` (`idMengajar`, `idPegawai`, `mengajarMulai`, `mengajarSelesai`, `mengajarMP`, `mengajarKeterangan`, `stdel`, `cby`, `cdate`, `uby`, `udate`, `dby`, `ddate`) VALUES
(1, 1, '2021-01-15', '2021-01-29', '11', '222', 1, 1, '2021-01-20 13:07:59', NULL, NULL, 1, '2021-01-20 13:13:46'),
(2, 1, '2021-01-08', '2021-01-29', '111', '222', 1, 1, '2021-01-20 13:14:21', NULL, NULL, 1, '2021-01-20 13:16:26'),
(3, 1, '2021-01-11', '2021-01-30', '333', '444', 1, 1, '2021-01-20 13:14:21', NULL, NULL, 1, '2021-01-20 13:33:02'),
(4, 1, '2021-01-21', '2021-01-30', '11', '1111', 1, 1, '2021-01-20 13:33:20', NULL, NULL, 1, '2021-01-20 13:33:24'),
(5, 1, '2021-01-21', '2021-01-23', '22', '222', 0, 1, '2021-01-20 13:33:20', NULL, NULL, NULL, NULL),
(6, 1, '2021-01-23', '2021-01-29', '111111', '111111111111111111111111', 1, 1, '2021-01-20 13:37:04', NULL, NULL, 1, '2021-01-20 13:37:35'),
(7, 1, '2021-01-22', '2021-01-30', '222222', '222222222222222222222222', 1, 1, '2021-01-20 13:37:04', NULL, NULL, 1, '2021-01-20 13:37:40');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai_pendidikan`
--

CREATE TABLE `pegawai_pendidikan` (
  `idPendidikan` int(11) NOT NULL,
  `idPegawai` int(11) NOT NULL,
  `pendidikanMasuk` varchar(20) DEFAULT NULL,
  `pendidikanKeluar` varchar(20) DEFAULT NULL,
  `pendidikanSekolah` varchar(100) DEFAULT NULL,
  `pendidikanLokasi` varchar(100) DEFAULT NULL,
  `stdel` int(11) DEFAULT NULL,
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pegawai_pendidikan`
--

INSERT INTO `pegawai_pendidikan` (`idPendidikan`, `idPegawai`, `pendidikanMasuk`, `pendidikanKeluar`, `pendidikanSekolah`, `pendidikanLokasi`, `stdel`, `cby`, `cdate`, `uby`, `udate`, `dby`, `ddate`) VALUES
(1, 1, '2020', '2020', 'IIA', 'OL', 1, 1, '2021-01-20 09:41:35', NULL, NULL, 1, '2021-01-20 10:09:04'),
(2, 1, '2019', '2025', '222', '222', 1, 1, '2021-01-20 10:22:15', NULL, NULL, 1, '2021-01-20 10:22:31'),
(3, 1, '2000', '1111', '1111', '1111', 1, 1, '2021-01-20 10:22:15', NULL, NULL, 1, '2021-01-20 12:31:37'),
(4, 1, '2024', '2025', '222', '33', 1, 1, '2021-01-20 10:37:43', NULL, NULL, 1, '2021-01-20 12:19:12'),
(5, 1, '2029', '2028', '11', '1', 1, 1, '2021-01-20 12:32:34', NULL, NULL, 1, '2021-01-20 12:45:40'),
(6, 1, '2028', '2025', '22', '2222', 1, 1, '2021-01-20 12:32:34', NULL, NULL, 1, '2021-01-20 12:34:10'),
(7, 1, '2026', '2030', '111', '2222', 1, 1, '2021-01-20 13:17:14', NULL, NULL, 1, '2021-01-25 01:11:55'),
(8, 1, '2026', '2030', '22222', '2222222222', 1, 1, '2021-01-20 13:34:15', NULL, NULL, 1, '2021-01-20 13:34:19'),
(9, 1, '1915', '2024', '11111', '11111111111', 0, 1, '2021-01-20 13:34:15', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pegawai_penghargaan`
--

CREATE TABLE `pegawai_penghargaan` (
  `idPenghargaan` int(11) NOT NULL,
  `idPegawai` int(11) NOT NULL,
  `penghargaanTahun` varchar(25) NOT NULL,
  `penghargaanNama` varchar(255) NOT NULL,
  `stdel` int(11) DEFAULT NULL,
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pegawai_penghargaan`
--

INSERT INTO `pegawai_penghargaan` (`idPenghargaan`, `idPegawai`, `penghargaanTahun`, `penghargaanNama`, `stdel`, `cby`, `cdate`, `uby`, `udate`, `dby`, `ddate`) VALUES
(1, 1, '2021', '3333', 1, 1, '2021-01-20 13:28:26', NULL, NULL, 1, '2021-01-20 13:31:26'),
(2, 1, '1115', 'sss', 1, 1, '2021-01-20 13:28:41', NULL, NULL, 1, '2021-01-20 13:31:33'),
(3, 1, '2021', '', 1, 1, '2021-01-20 13:28:41', NULL, NULL, 1, '2021-01-20 13:38:35'),
(4, 1, '2029', '222', 1, 1, '2021-01-20 13:29:30', NULL, NULL, 1, '2021-01-20 13:38:17'),
(5, 1, '2030', '1111', 1, 1, '2021-01-20 13:38:28', NULL, NULL, 1, '2021-01-20 13:38:32'),
(6, 1, '2029', '34567', 0, 1, '2021-01-20 13:38:28', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pegawai_seminar`
--

CREATE TABLE `pegawai_seminar` (
  `idSeminar` int(11) NOT NULL,
  `idPegawai` int(11) NOT NULL,
  `seminarMulai` date NOT NULL,
  `seminarSelesai` date NOT NULL,
  `seminarPenyelenggara` varchar(100) NOT NULL,
  `seminarLokasi` varchar(100) NOT NULL,
  `stdel` int(11) DEFAULT NULL,
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pegawai_seminar`
--

INSERT INTO `pegawai_seminar` (`idSeminar`, `idPegawai`, `seminarMulai`, `seminarSelesai`, `seminarPenyelenggara`, `seminarLokasi`, `stdel`, `cby`, `cdate`, `uby`, `udate`, `dby`, `ddate`) VALUES
(1, 1, '2021-01-08', '0000-00-00', 'PPP', '33', 1, 1, '2021-01-20 10:53:09', NULL, NULL, 1, '2021-01-20 10:56:41'),
(2, 1, '2021-01-16', '2021-01-21', 'asdsad', 'asdsadsad', 0, 1, '2021-01-20 10:54:35', NULL, NULL, NULL, NULL),
(3, 1, '2021-01-09', '2021-01-29', 'ssss', 'wwww', 1, 1, '2021-01-20 10:54:35', NULL, NULL, 1, '2021-01-20 12:39:38'),
(4, 1, '2021-01-08', '2021-01-23', '11', '22', 1, 1, '2021-01-20 12:40:42', NULL, NULL, 1, '2021-01-25 01:11:58'),
(5, 1, '2021-01-16', '2021-01-26', '222', '333', 1, 1, '2021-01-20 12:40:42', NULL, NULL, 1, '2021-01-20 12:45:43'),
(6, 1, '2021-01-23', '2021-01-30', '12', '1212', 1, 1, '2021-01-20 13:34:43', NULL, NULL, 1, '2021-01-20 13:34:48'),
(7, 1, '2021-01-30', '2021-01-22', '13', '1313', 0, 1, '2021-01-20 13:34:43', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pos_bayar`
--

CREATE TABLE `pos_bayar` (
  `idPosBayar` int(5) NOT NULL,
  `kodeAkun` int(11) DEFAULT NULL,
  `akunPiutang` int(11) DEFAULT NULL,
  `nmPosBayar` varchar(100) DEFAULT NULL,
  `ketPosBayar` varchar(100) DEFAULT NULL,
  `stdel` int(11) DEFAULT '0',
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pos_bayar`
--

INSERT INTO `pos_bayar` (`idPosBayar`, `kodeAkun`, `akunPiutang`, `nmPosBayar`, `ketPosBayar`, `stdel`, `cby`, `cdate`, `uby`, `udate`, `dby`, `ddate`) VALUES
(1, 21, 32, 'SPP SMP', 'SPP SMP', 0, 1, '2021-01-28 19:15:24', NULL, NULL, NULL, NULL),
(2, 36, 33, 'SPP SMA', 'SPP SMA', 1, 1, '2021-01-28 19:15:40', NULL, NULL, 1, '2021-02-02 16:31:50'),
(3, 46, 34, 'SPP Tahfidz', 'SPP Tahfidz', 0, 1, '2021-01-28 19:18:50', NULL, NULL, NULL, NULL),
(4, 22, 32, 'Daftar Ulang smt-1 SMP', 'Daftar Ulang smt-1 SMP', 0, 1, '2021-01-28 19:19:36', NULL, NULL, NULL, NULL),
(5, 37, 33, 'Daftar Ulang smt-1 SMA', 'Daftar Ulang smt-1 SMA', 0, 1, '2021-01-28 19:19:55', NULL, NULL, NULL, NULL),
(6, 23, 32, 'Daftar Ulang smt-2 SMP', 'Daftar Ulang smt-2 SMP', 0, 1, '2021-01-28 19:20:13', NULL, NULL, NULL, NULL),
(7, 26, 32, 'Tunggakan SPP', 'Tunggakan SPP', 0, 1, '2021-01-28 19:20:37', NULL, NULL, NULL, NULL),
(8, 48, 34, 'DU Santri Baru', 'DU Santri Baru', 0, 1, '2021-01-28 19:21:37', NULL, NULL, NULL, NULL),
(9, 49, 34, 'Tunggakan SPP', 'Tunggakan SPP', 0, 1, '2021-01-28 19:21:54', NULL, NULL, NULL, NULL),
(10, 38, 33, 'Daftar Ulang smt-2 SMA', 'Daftar Ulang smt-2 SMA', 0, 1, '2021-01-28 19:22:09', NULL, NULL, NULL, NULL),
(11, 41, 33, 'Tunggakan SPP', 'Tunggakan SPP', 0, 1, '2021-01-28 19:22:28', NULL, NULL, NULL, NULL),
(12, 27, 32, 'Sarana Santri Baru', 'Sarana SPP', 0, 1, '2021-01-28 19:23:03', NULL, NULL, NULL, NULL),
(13, 42, 33, 'Sarana Santri Baru', 'Sarana SPP', 0, 1, '2021-01-28 19:23:23', NULL, NULL, NULL, NULL),
(14, 43, 33, 'Iuran Pengobatan', 'Iuran Pengobatan Rozi', 0, 1, '2021-01-28 19:23:49', NULL, NULL, NULL, NULL),
(15, 28, 32, 'Kitab Santri Baru', 'Kitab SMP', 0, 1, '2021-01-28 19:24:13', NULL, NULL, NULL, NULL),
(16, 44, 33, 'Kitab Santri Baru', 'Kitab SMA', 0, 1, '2021-01-28 19:24:31', NULL, NULL, NULL, NULL),
(17, 22, 32, 'sss', 'sss', 1, 1, '2021-02-02 16:30:48', NULL, NULL, 1, '2021-02-02 16:31:44'),
(18, 36, 33, 'SPP SMA', 'SPP SMA', 0, 1, '2021-02-09 12:49:56', NULL, NULL, NULL, NULL),
(19, 21, 32, 'SPP SMP', 'SPP SMP', 1, 1, '2021-02-14 02:09:30', NULL, NULL, 1, '2021-02-14 02:12:20'),
(20, 46, 34, 'SPP TAHFIDZ', 'BEBAS', 0, 1, '2021-03-26 10:30:36', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ref`
--

CREATE TABLE `ref` (
  `ref_id` int(10) NOT NULL,
  `ref_val` varchar(100) NOT NULL,
  `ref_date` date NOT NULL,
  `ref_stat` int(10) NOT NULL,
  `ref_pay` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `idSiswa` int(10) NOT NULL,
  `nisSiswa` varchar(25) DEFAULT NULL,
  `nisnSiswa` varchar(25) DEFAULT NULL,
  `nmSiswa` varchar(100) DEFAULT NULL,
  `jkSiswa` varchar(15) DEFAULT NULL,
  `tempatLahirSiswa` varchar(100) DEFAULT NULL,
  `tglLahirSiswa` date NOT NULL,
  `agamaSiswa` varchar(15) DEFAULT NULL,
  `alamatSiswa` varchar(255) DEFAULT NULL,
  `fotoSiswa` varchar(255) DEFAULT NULL,
  `unitSiswa` int(11) DEFAULT '0',
  `kelasSiswa` int(11) DEFAULT '0',
  `kamarSiswa` int(11) DEFAULT '0',
  `statusSiswa` enum('Tidak Aktif','Aktif','Tamat','Pindah Pesantren','Drop Out') DEFAULT NULL,
  `nmIbu` varchar(100) DEFAULT NULL,
  `nmAyah` varchar(100) DEFAULT NULL,
  `noHpOrtu` varchar(30) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `saldo` double NOT NULL DEFAULT '0',
  `stdel` int(11) DEFAULT NULL,
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`idSiswa`, `nisSiswa`, `nisnSiswa`, `nmSiswa`, `jkSiswa`, `tempatLahirSiswa`, `tglLahirSiswa`, `agamaSiswa`, `alamatSiswa`, `fotoSiswa`, `unitSiswa`, `kelasSiswa`, `kamarSiswa`, `statusSiswa`, `nmIbu`, `nmAyah`, `noHpOrtu`, `password`, `saldo`, `stdel`, `cby`, `cdate`, `uby`, `udate`, `dby`, `ddate`) VALUES
(24, '201706001', '', 'Sofie Giska Nuraudila', '', '', '0000-00-00', NULL, 'Jalan Klengkeng RT 01 RW 02 Desa Kecamatan Blora Jateng', NULL, 1, 2, 1, 'Aktif', '', 'Abdullah', '08856538084', 'e10adc3949ba59abbe56e057f20f883e', 0, 0, 1, '2021-02-18 22:38:51', 1, '2021-04-23 09:36:47', NULL, NULL),
(26, '201788775', NULL, 'AA', NULL, NULL, '0000-00-00', NULL, 'OK', NULL, 1, 2, 0, 'Aktif', NULL, '', '08777', 'e10adc3949ba59abbe56e057f20f883e', 0, 0, 1, '2021-02-18 22:38:51', NULL, NULL, NULL, NULL),
(27, '201788776', NULL, 'BB', NULL, NULL, '0000-00-00', NULL, 'SIP', NULL, 1, 2, 0, 'Aktif', NULL, '', '02222', 'e10adc3949ba59abbe56e057f20f883e', 0, 0, 1, '2021-02-18 22:38:51', NULL, NULL, NULL, NULL),
(28, '201788777', NULL, 'CC', NULL, NULL, '0000-00-00', NULL, 'APA', NULL, 1, 2, 0, 'Aktif', NULL, '', '011111', 'e10adc3949ba59abbe56e057f20f883e', 0, 0, 1, '2021-02-18 22:38:51', NULL, NULL, NULL, NULL),
(29, '201788778', '', 'DD', '', '', '0000-00-00', NULL, 'SIAPA', 'download.jpg', 5, 22, 0, 'Aktif', '', '', '5555', 'e10adc3949ba59abbe56e057f20f883e', 0, 0, 1, '2021-02-18 22:38:51', 1, '2021-02-19 12:25:54', NULL, NULL),
(30, '1111', '', 'sdasdasd', '', '', '0000-00-00', NULL, '', NULL, 1, 15, 0, 'Aktif', '', '', '222222', 'e10adc3949ba59abbe56e057f20f883e', 0, 0, 1, '2021-02-19 12:08:10', 1, '2021-02-20 01:22:41', NULL, NULL),
(31, 'www', '', 'ddd', '', '', '0000-00-00', NULL, '', NULL, 1, 12, 0, 'Tidak Aktif', '', '', '', 'e10adc3949ba59abbe56e057f20f883e', 0, 0, 1, '2021-02-19 14:05:16', NULL, NULL, NULL, NULL),
(32, '12222', '', '222', '', '', '0000-00-00', NULL, '', NULL, 1, 7, 0, 'Aktif', '', '', '11111', 'e10adc3949ba59abbe56e057f20f883e', 0, 0, 1, '2021-02-19 14:06:49', 1, '2021-02-19 14:14:02', NULL, NULL),
(33, '22222', '', 'sdasdsadsad', '', '', '0000-00-00', NULL, '', NULL, 5, 23, 0, 'Aktif', '', '', '1234567890', 'e10adc3949ba59abbe56e057f20f883e', 0, 0, 1, '2021-02-19 14:14:16', 1, '2021-02-21 22:41:56', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `siswa_kesehatan`
--

CREATE TABLE `siswa_kesehatan` (
  `idKesehatan` int(11) NOT NULL,
  `siswa` int(11) NOT NULL,
  `tahunAjaran` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `nmSakit` varchar(100) NOT NULL,
  `obat` varchar(100) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `stdel` int(11) DEFAULT '0',
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `siswa_kesehatan`
--

INSERT INTO `siswa_kesehatan` (`idKesehatan`, `siswa`, `tahunAjaran`, `tanggal`, `nmSakit`, `obat`, `keterangan`, `stdel`, `cby`, `cdate`, `uby`, `udate`, `dby`, `ddate`) VALUES
(1, 3, 23, '2021-01-23', 'dsfdsf', '223dfdsfdsf', '3d', 1, 1, '2021-01-23 17:51:32', NULL, NULL, 1, '2021-01-23 17:51:41'),
(2, 2, 23, '2021-01-21', '333', 'ddd', '333', 0, 1, '2021-01-23 17:54:39', NULL, NULL, NULL, NULL),
(3, 3, 23, '2021-01-30', '333', '444', '2222', 0, 1, '2021-01-23 18:15:23', NULL, NULL, NULL, NULL),
(4, 3, 23, '2021-01-28', '333', '223dfdsfdsf', '2222', 1, 1, '2021-01-23 18:15:35', NULL, NULL, 1, '2021-01-23 18:16:30'),
(5, 201706004, 4, '2021-01-29', '333', '223dfdsfdsf', '2222', 0, 1, '2021-01-24 14:57:29', NULL, NULL, NULL, NULL),
(6, 3, 4, '2021-01-30', 'dsfdsf', '223dfdsfdsf', 'sdf', 0, 1, '2021-01-24 15:20:09', NULL, NULL, NULL, NULL),
(7, 201706003, 4, '2021-01-30', '333', '3333', '33333', 1, 1, '2021-01-24 15:27:29', NULL, NULL, 1, '2021-01-24 15:37:39'),
(8, 201706003, 4, '2021-01-23', 'Pusing', 'Paramex', 'Harus Istirahat 2 Hari 19 September 2020 sampai dengan 21 September 2020', 0, 1, '2021-01-24 15:38:07', NULL, NULL, NULL, NULL),
(9, 6, 4, '2021-01-30', 'Pusing', 'ddd', '33333', 0, 1, '2021-01-24 16:15:37', NULL, NULL, NULL, NULL),
(10, 38, 3, '2021-04-21', 'Batuk Pilek', 'Amoxilin', 'Sakitnya Ringan', 0, 1, '2021-04-21 04:20:40', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `siswa_konseling`
--

CREATE TABLE `siswa_konseling` (
  `idKonseling` int(11) NOT NULL,
  `siswa` int(11) NOT NULL,
  `tahunAjaran` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `pelanggaran` varchar(100) NOT NULL,
  `tindakan` varchar(100) NOT NULL,
  `poin` varchar(20) NOT NULL,
  `catatan` varchar(255) NOT NULL,
  `stdel` int(11) DEFAULT NULL,
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `siswa_konseling`
--

INSERT INTO `siswa_konseling` (`idKonseling`, `siswa`, `tahunAjaran`, `tanggal`, `pelanggaran`, `tindakan`, `poin`, `catatan`, `stdel`, `cby`, `cdate`, `uby`, `udate`, `dby`, `ddate`) VALUES
(1, 6, 0, '0000-00-00', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 6, 23, '2021-01-29', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 6, 23, '2021-01-30', '23423432', '123', '3', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 6, 23, '2021-01-30', 'fffff', '123', '2', '11', 0, 1, '2021-01-23 18:50:21', NULL, NULL, NULL, NULL),
(5, 6, 23, '2021-01-29', '23423432', '123', '7', 'ok', 0, 1, '2021-01-23 18:55:11', NULL, NULL, NULL, NULL),
(6, 2, 4, '2021-01-02', '111', '123', '5', '11', 1, 1, '2021-01-24 16:14:18', NULL, NULL, 1, '2021-01-24 16:15:08'),
(7, 3, 3, '2021-02-16', '2', '123', '1', '222', 1, 1, '2021-02-16 01:40:22', NULL, NULL, 1, '2021-02-16 01:40:27'),
(8, 3, 3, '2021-02-16', 'ABC', 'OOO', '1', 'APAAJA', 0, 1, '2021-02-16 14:33:07', NULL, NULL, NULL, NULL),
(9, 38, 3, '2021-04-21', 'Merokok', 'Di cukur gundul', '50', 'Sempat menolak ketika di cukur', 0, 1, '2021-04-21 04:25:42', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `siswa_tahfidz`
--

CREATE TABLE `siswa_tahfidz` (
  `idTahfidz` int(11) NOT NULL,
  `siswa` int(11) NOT NULL,
  `tahunAjaran` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlahHafalan` varchar(30) NOT NULL,
  `keteranganHafalan` varchar(100) NOT NULL,
  `murojaah` varchar(100) NOT NULL,
  `murojaahHafalan` varchar(100) NOT NULL,
  `stdel` int(11) DEFAULT '0',
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `siswa_tahfidz`
--

INSERT INTO `siswa_tahfidz` (`idTahfidz`, `siswa`, `tahunAjaran`, `tanggal`, `jumlahHafalan`, `keteranganHafalan`, `murojaah`, `murojaahHafalan`, `stdel`, `cby`, `cdate`, `uby`, `udate`, `dby`, `ddate`) VALUES
(1, 3, 23, '2021-01-23', '2', 'QS. Al-Baqoroh Ayat 25-29', 'Juz 30 (QS. Al-Inshiqoq` s/d QS. Ad-Dhuha)', 'QS. Al-Baqoroh Ayat 17-24', 1, 1, '2021-01-23 16:15:21', NULL, NULL, 1, '2021-01-23 16:25:25'),
(2, 3, 23, '2021-01-23', '2', 'QS. Al-Baqoroh Ayat 25-29', 'Juz 30 (QS. Al-Inshiqoq` s/d QS. Ad-Dhuha)', 'QS. Al-Baqoroh Ayat 17-24', 1, 1, '2021-01-23 16:26:12', NULL, NULL, 1, '2021-01-23 16:27:33'),
(3, 3, 23, '2021-01-23', '1', 'ddd', 'ddd', 'ddd', 1, 1, '2021-01-23 16:27:00', NULL, NULL, 1, '2021-01-23 16:35:25'),
(4, 3, 23, '2021-01-30', '12', 'QS. Al-Baqoroh Ayat 25-29', 'Juz 30 (QS. Al-Inshiqoq` s/d QS. Ad-Dhuha)', 'QS. Al-Baqoroh Ayat 17-24', 0, 1, '2021-01-23 16:35:38', NULL, NULL, NULL, NULL),
(5, 6, 23, '2021-01-23', '1', 'QS. Al-Baqoroh Ayat 25-29', 'Juz 30 (QS. Al-Inshiqoq` s/d QS. Ad-Dhuha)', 'QS. Al-Baqoroh Ayat 17-24', 1, 1, '2021-01-23 18:09:29', NULL, NULL, 1, '2021-01-23 18:11:08'),
(6, 6, 23, '2021-01-23', '3', '1', '34', '2', 1, 1, '2021-01-23 18:10:12', NULL, NULL, 1, '2021-01-23 18:11:32'),
(7, 6, 23, '2021-01-23', '2', 'QS. Al-Baqoroh Ayat 25-29', 'Juz 30 (QS. Al-Inshiqoq` s/d QS. Ad-Dhuha)', 'QS. Al-Baqoroh Ayat 17-24', 1, 1, '2021-01-23 18:11:26', NULL, NULL, 1, '2021-01-23 18:12:53'),
(8, 6, 23, '2021-01-21', '2', '342435', '345345345', '435435345', 1, 1, '2021-01-23 18:12:46', NULL, NULL, 1, '2021-01-23 18:14:22'),
(9, 6, 23, '2021-01-30', '26', 'QS. Al-Baqoroh Ayat 25-29', 'Juz 30 (QS. Al-Inshiqoq` s/d QS. Ad-Dhuha)', 'QS. Al-Baqoroh Ayat 17-24', 1, 1, '2021-01-23 18:13:14', NULL, NULL, 1, '2021-01-23 18:14:27'),
(10, 6, 4, '2021-01-30', '3', 'QS. Al-Baqoroh Ayat 25-29', 'Juz 30 (QS. Al-Inshiqoq` s/d QS. Ad-Dhuha)', 'QS. Al-Baqoroh Ayat 17-24', 0, 1, '2021-01-24 14:05:16', NULL, NULL, NULL, NULL),
(11, 3, 23, '2021-01-30', '2', 'ddd', 'ddd', 'ddd', 0, 1, '2021-01-24 14:30:39', NULL, NULL, NULL, NULL),
(12, 2, 3, '2021-01-23', '22', '4', '66', '55', 0, 1, '2021-01-27 01:44:11', NULL, NULL, NULL, NULL),
(13, 38, 3, '2021-04-21', '20', 'Baru Hafal', '19', '18', 0, 1, '2021-04-21 04:19:46', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tabungan_siswa`
--

CREATE TABLE `tabungan_siswa` (
  `idTabungan` int(11) NOT NULL,
  `siswa` int(11) NOT NULL,
  `tahunAjaran` int(11) NOT NULL,
  `tgl` date NOT NULL,
  `kode` enum('SETORAN','PENARIKAN') NOT NULL,
  `nominal` double NOT NULL,
  `catatan` varchar(100) NOT NULL,
  `stdel` int(11) DEFAULT NULL,
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tabungan_siswa`
--

INSERT INTO `tabungan_siswa` (`idTabungan`, `siswa`, `tahunAjaran`, `tgl`, `kode`, `nominal`, `catatan`, `stdel`, `cby`, `cdate`, `uby`, `udate`, `dby`, `ddate`) VALUES
(1, 201706005, 3, '2021-01-29', 'SETORAN', 10000, 'SIP', 1, 1, '2021-01-25 23:19:44', 1, '2021-01-25 23:43:08', 1, '2021-01-25 23:56:56'),
(2, 201706005, 3, '2021-01-25', 'PENARIKAN', 5000, 'ggg', 0, 1, '2021-01-25 23:53:45', 1, '2021-01-25 23:54:31', NULL, NULL),
(3, 201706005, 3, '2021-01-25', 'PENARIKAN', 3333, '', 1, 1, '2021-01-25 23:54:40', 1, '2021-01-25 23:55:30', 1, '2021-01-25 23:57:00'),
(4, 201706005, 3, '2021-01-25', 'PENARIKAN', 50000, '4', 0, 1, '2021-01-25 23:55:09', NULL, NULL, NULL, NULL),
(5, 201706005, 3, '2021-01-25', 'SETORAN', 100000, 'ABC', 0, 1, '2021-01-25 23:57:13', NULL, NULL, NULL, NULL),
(6, 201706005, 3, '2021-01-26', 'SETORAN', 20000, 'sad', 0, 1, '2021-01-26 00:09:15', NULL, NULL, NULL, NULL),
(7, 3, 3, '2021-02-11', 'SETORAN', 100000, 'SIP', 0, 1, '2021-02-11 08:00:58', NULL, NULL, NULL, NULL),
(8, 3, 3, '2021-02-11', 'PENARIKAN', 5000, '4', 0, 1, '2021-02-11 14:03:19', NULL, NULL, NULL, NULL),
(9, 3, 4, '2021-02-11', 'SETORAN', 100000, 'ABC', 0, 1, '2021-02-11 14:51:08', NULL, NULL, NULL, NULL),
(10, 2, 3, '2021-02-14', 'SETORAN', 100000, '1', 0, 1, '2021-02-14 01:12:48', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tagihan_bebas`
--

CREATE TABLE `tagihan_bebas` (
  `idTagihanBebas` int(50) NOT NULL,
  `idJenisBayar` int(5) DEFAULT NULL,
  `idSiswa` int(10) DEFAULT NULL,
  `idKelas` int(5) DEFAULT NULL,
  `totalTagihan` int(10) DEFAULT NULL,
  `ref` varchar(100) DEFAULT NULL,
  `statusBayar` enum('0','1','2') DEFAULT '0',
  `TglTagihan` datetime DEFAULT NULL,
  `tglUpdate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tagihan_bebas`
--

INSERT INTO `tagihan_bebas` (`idTagihanBebas`, `idJenisBayar`, `idSiswa`, `idKelas`, `totalTagihan`, `ref`, `statusBayar`, `TglTagihan`, `tglUpdate`) VALUES
(1, 2, 25, 2, 300000, 'REF20210416011359-1', '1', '2021-04-16 01:13:07', NULL),
(2, 2, 38, 2, 200000, 'REF20210417153304-1', '1', '2021-04-17 15:16:23', NULL);

--
-- Triggers `tagihan_bebas`
--
DELIMITER $$
CREATE TRIGGER `BeforeInsertTagihanBebas` BEFORE INSERT ON `tagihan_bebas` FOR EACH ROW BEGIN
    IF NEW. TglTagihan = '0000-00-00 00:00:00' THEN
        SET NEW.TglTagihan = CURRENT_TIMESTAMP();
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `BeforeUpdateTagihanBebas` BEFORE UPDATE ON `tagihan_bebas` FOR EACH ROW BEGIN
    IF NEW. TglTagihan = '0000-00-00 00:00:00' THEN
        SET NEW.TglTagihan = CURRENT_TIMESTAMP();
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tagihan_bebas_bayar`
--

CREATE TABLE `tagihan_bebas_bayar` (
  `idTagihanBebasBayar` int(50) NOT NULL,
  `idTagihanBebas` int(50) DEFAULT NULL,
  `noRefrensi` varchar(100) DEFAULT NULL,
  `tglBayar` datetime DEFAULT NULL,
  `tglBayarSementara` datetime DEFAULT NULL,
  `jumlahBayar` int(10) DEFAULT NULL,
  `idAkunKas` int(11) DEFAULT NULL,
  `ketBebas` varchar(100) DEFAULT NULL,
  `statusKas` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tagihan_bebas_bayar`
--

INSERT INTO `tagihan_bebas_bayar` (`idTagihanBebasBayar`, `idTagihanBebas`, `noRefrensi`, `tglBayar`, `tglBayarSementara`, `jumlahBayar`, `idAkunKas`, `ketBebas`, `statusKas`) VALUES
(1, 1, 'SPTahfidz20175566716042105', '2021-04-16 01:14:28', '2021-04-16 01:14:28', 300000, 76, 'transfer bank midtrans', 0),
(2, 2, 'SPTahfidz11122233317042103', '2021-04-17 15:33:19', '2021-04-17 15:33:19', 100000, 76, 'transfer bank midtrans', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tagihan_bulanan`
--

CREATE TABLE `tagihan_bulanan` (
  `idTagihanBulanan` int(50) NOT NULL,
  `idJenisBayar` int(5) DEFAULT NULL,
  `idSiswa` int(10) DEFAULT NULL,
  `idKelas` int(5) DEFAULT NULL,
  `idBulan` varchar(15) DEFAULT NULL,
  `jumlahTagihan` int(10) DEFAULT NULL,
  `TglTagihan` datetime DEFAULT NULL,
  `tglBayar` datetime DEFAULT NULL,
  `tglBayarSementara` datetime DEFAULT NULL,
  `tglUpdate` datetime DEFAULT NULL,
  `statusBayar` enum('0','1','2') DEFAULT '0',
  `inv` text,
  `noRefrensi` varchar(100) DEFAULT NULL,
  `idAkunKas` int(11) DEFAULT NULL,
  `statusKas` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tagihan_bulanan`
--

INSERT INTO `tagihan_bulanan` (`idTagihanBulanan`, `idJenisBayar`, `idSiswa`, `idKelas`, `idBulan`, `jumlahTagihan`, `TglTagihan`, `tglBayar`, `tglBayarSementara`, `tglUpdate`, `statusBayar`, `inv`, `noRefrensi`, `idAkunKas`, `statusKas`) VALUES
(1, 1, 25, 2, '7', 50000, '2021-04-16 01:52:54', '2021-04-17 05:15:01', NULL, NULL, '2', 'INV20210417051442-1', NULL, 75, 0),
(2, 1, 25, 2, '8', 50000, '2021-04-16 01:52:54', '2021-04-18 05:25:16', '2021-04-18 00:00:00', NULL, '2', 'INV20210417051154-1', 'SPTahfidz20175566718042105', 0, 0),
(3, 1, 25, 2, '9', 55000, '2021-04-16 01:52:54', '2021-04-16 01:56:37', NULL, NULL, '0', 'INV20210416015609-1', NULL, 75, 0),
(4, 1, 25, 2, '10', 55000, '2021-04-16 01:52:54', '2021-04-16 01:56:37', NULL, NULL, '0', 'INV20210416015609-1', NULL, 75, 0),
(5, 1, 25, 2, '11', 55000, '2021-04-16 01:52:54', '2021-04-16 01:56:37', NULL, NULL, '2', 'INV20210416015609-1', NULL, 75, 0),
(6, 1, 25, 2, '12', 55000, '2021-04-16 01:52:54', '2021-04-17 03:37:55', NULL, NULL, '2', 'INV20210417033623-1', NULL, 75, 0),
(7, 1, 25, 2, '1', 55000, '2021-04-16 01:52:54', '2021-04-17 04:27:12', NULL, NULL, '2', 'INV20210417042638-1', NULL, 75, 0),
(8, 1, 25, 2, '2', 55000, '2021-04-16 01:52:54', '2021-04-17 04:35:57', NULL, NULL, '2', 'INV20210417043351-1', NULL, 75, 0),
(9, 1, 25, 2, '3', 50000, '2021-04-16 01:52:54', '2021-04-17 04:45:03', NULL, NULL, '2', 'INV20210417043553-1', NULL, 75, 0),
(10, 1, 25, 2, '4', 50000, '2021-04-16 01:52:54', '2021-04-17 04:59:27', NULL, NULL, '2', 'INV20210417045840-1', NULL, 75, 0),
(11, 1, 25, 2, '5', 50000, '2021-04-16 01:52:54', '2021-04-17 05:01:27', NULL, NULL, '2', 'INV20210417050103-1', NULL, 75, 0),
(12, 1, 25, 2, '6', 50000, '2021-04-16 01:52:54', '2021-04-17 05:03:43', NULL, NULL, '2', 'INV20210417050317-1', NULL, 75, 0),
(13, 1, 38, 2, '7', 200000, '2021-04-17 15:16:49', '2021-04-17 17:45:39', NULL, NULL, '2', 'INV20210417151718-1', NULL, 75, 0),
(14, 1, 38, 2, '8', 200000, '2021-04-17 15:16:49', '2021-04-21 13:25:25', '2021-04-21 00:00:00', NULL, '2', NULL, 'SPTahfidz11122233321042103', 0, 0),
(15, 1, 38, 2, '9', 200000, '2021-04-17 15:16:49', '2021-04-17 18:30:45', NULL, NULL, '2', 'INV20210417161805-1', NULL, 75, 0),
(16, 1, 38, 2, '10', 200000, '2021-04-17 15:16:49', '2021-04-18 11:17:37', NULL, NULL, '2', 'INV20210418111004-1', NULL, 75, 0),
(17, 1, 38, 2, '11', 200000, '2021-04-17 15:16:49', '2021-04-18 11:17:37', NULL, NULL, '2', 'INV20210418111004-1', NULL, 75, 0),
(18, 1, 38, 2, '12', 200000, '2021-04-17 15:16:49', '2021-04-21 13:55:57', NULL, NULL, '2', 'INV20210421112950-1', NULL, 75, 0),
(19, 1, 38, 2, '1', 200000, '2021-04-17 15:16:49', '2021-04-21 13:55:57', '2021-04-21 00:00:00', NULL, '2', 'INV20210421112950-1', 'SPTahfidz11122233321042103', 75, 0),
(20, 1, 38, 2, '2', 200000, '2021-04-17 15:16:49', '2021-04-21 13:55:57', '2021-04-21 00:00:00', NULL, '2', 'INV20210421112950-1', 'SPTahfidz11122233321042103', 75, 0),
(21, 1, 38, 2, '3', 200000, '2021-04-17 15:16:49', '2021-04-21 13:38:20', '2021-04-21 00:00:00', NULL, '2', NULL, 'SPTahfidz11122233321042103', 15, 0),
(22, 1, 38, 2, '4', 200000, '2021-04-17 15:16:49', '2021-04-22 09:57:13', '2021-04-22 00:00:00', NULL, '2', NULL, 'SPTahfidz11122233322042103', 15, 0),
(23, 1, 38, 2, '5', 200000, '2021-04-17 15:16:49', '2021-04-22 10:00:47', '2021-04-22 00:00:00', NULL, '2', NULL, 'SPTahfidz11122233322042103', 15, 0),
(24, 1, 38, 2, '6', 200000, '2021-04-17 15:16:49', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0);

--
-- Triggers `tagihan_bulanan`
--
DELIMITER $$
CREATE TRIGGER `BeforeInsertTagihanBulanan` BEFORE INSERT ON `tagihan_bulanan` FOR EACH ROW BEGIN
    IF NEW. TglTagihan = '0000-00-00 00:00:00' THEN
        SET NEW.TglTagihan = CURRENT_TIMESTAMP();
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `BeforeUpdateTagihanBulanan` BEFORE UPDATE ON `tagihan_bulanan` FOR EACH ROW BEGIN
    IF NEW. TglTagihan = '0000-00-00 00:00:00' THEN
        SET NEW.TglTagihan = CURRENT_TIMESTAMP();
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tahun_ajaran`
--

CREATE TABLE `tahun_ajaran` (
  `idTahunAjaran` int(5) NOT NULL,
  `nmTahunAjaran` varchar(9) DEFAULT NULL,
  `status` enum('Aktif','Tidak Aktif') DEFAULT NULL,
  `stdel` int(11) DEFAULT '0',
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tahun_ajaran`
--

INSERT INTO `tahun_ajaran` (`idTahunAjaran`, `nmTahunAjaran`, `status`, `stdel`, `cby`, `cdate`, `uby`, `udate`, `dby`, `ddate`) VALUES
(3, '2019/2020', 'Aktif', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(4, '2020/2021', 'Tidak Aktif', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(5, '2021/2022', 'Tidak Aktif', 0, NULL, NULL, 1, '2021-01-18 21:57:32', NULL, NULL),
(20, '2029/2030', 'Tidak Aktif', 1, 1, '2021-01-19 01:32:11', 1, '2021-01-19 01:32:32', 1, '2021-01-19 01:33:54'),
(21, '2022/2023', 'Tidak Aktif', 1, 1, '2021-01-19 01:32:44', NULL, NULL, 1, '2021-01-19 01:33:52'),
(22, '2046/2047', 'Tidak Aktif', 1, 1, '2021-01-19 01:33:44', NULL, NULL, 1, '2021-01-19 01:33:49'),
(23, '2022/2023', 'Tidak Aktif', 0, 1, '2021-01-20 01:35:17', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_tes`
--

CREATE TABLE `tb_tes` (
  `id` int(10) NOT NULL,
  `con` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_tes`
--

INSERT INTO `tb_tes` (`id`, `con`) VALUES
(1, '.250000>200000.'),
(2, 'tot =250000 sum = 0 pay = 200000 sisa = 50000'),
(3, '.250000>200000.'),
(4, 'tot =250000 sum = 0 pay = 200000 sisa = 50000'),
(5, '.250000>200000.'),
(6, 'tot =250000 sum = 0 pay = 200000 sisa = 50000'),
(7, '.0>50000.'),
(8, '.50000>50000.'),
(9, 'tot =250000 sum = 200000 pay = 50000 sisa = 0'),
(10, '.0>50000.'),
(11, '.250000>250000.'),
(12, 'tot =250000 sum = 0 pay = 250000 sisa = 0'),
(13, '.0>168000.'),
(14, '.0>150000.'),
(15, '.0>100000.'),
(16, '.200000>100000.'),
(17, 'tot =200000 sum = 0 pay = 100000 sisa = 100000'),
(18, '.0>100000.'),
(19, '.0>155000.'),
(20, '.0>160000.'),
(21, 'tot =200000 sum = 100000 pay = 100000 sisa = 0'),
(22, 'tot =250000 sum = 0 pay = 250000 sisa = 0'),
(23, 'tot =200000 sum = 0 pay = 100000 sisa = 100000'),
(24, 'tot =200000 sum = 0 pay = 50000 sisa = 150000'),
(25, 'tot =300000 sum = 0 pay = 300000 sisa = 0'),
(26, 'tot =200000 sum = 0 pay = 100000 sisa = 100000'),
(27, 'tot =200000 sum = 100000 pay = 100000 sisa = 0'),
(28, 'tot =200000 sum = 200000 pay = 100000 sisa = -100000'),
(29, 'tot =200000 sum = 300000 pay = 100000 sisa = -200000'),
(30, 'tot =200000 sum = 400000 pay = 100000 sisa = -300000'),
(31, 'tot =200000 sum = 500000 pay = 100000 sisa = -400000');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` varchar(50) NOT NULL,
  `idSiswa` varchar(50) NOT NULL,
  `tanggal` date NOT NULL,
  `debit` int(10) NOT NULL,
  `kredit` int(10) NOT NULL,
  `keterangan` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_pembayaran`
--

CREATE TABLE `transaksi_pembayaran` (
  `idTransaksiBayar` int(11) NOT NULL,
  `noRefrensi` varchar(100) DEFAULT NULL,
  `idAkunKas` int(11) DEFAULT NULL,
  `idSiswa` int(11) DEFAULT NULL,
  `idTahunAjaran` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi_pembayaran`
--

INSERT INTO `transaksi_pembayaran` (`idTransaksiBayar`, `noRefrensi`, `idAkunKas`, `idSiswa`, `idTahunAjaran`) VALUES
(73, 'SPTahfidz3333314022101', 15, 3, 3),
(74, 'SPSMP-TMI222214022101', 7, 2, 3),
(75, 'SPTahfidz111114022101', 15, 1, 3),
(76, 'SPTahfidz111114022101', 15, 1, 3),
(77, 'SPTahfidz20175566718022101', 15, 25, 4),
(78, 'SPTahfidz20175566718022102', 15, 25, 3),
(79, 'SPTahfidz20175566718022102', 15, 25, 3),
(80, 'SPTahfidz20175566719022103', 15, 25, 3),
(81, 'SPTahfidz20175566719022104', 15, 25, 4),
(82, 'SPSMP-TMI20178877823022101', 7, 29, 3),
(83, 'SPSMP-TMI20178877823022102', 7, 29, 3),
(84, 'SPTahfidz20175566709042105', 15, 25, 3),
(85, 'SPTahfidz20178877710042101', 16, 28, 3),
(86, 'SPTahfidz20175566710042105', 15, 25, 3),
(87, 'SPTahfidz20175566710042105', 15, 25, 3),
(88, 'SPTahfidz20175566710042105', 15, 25, 3),
(89, 'SPTahfidz20175566710042105', 15, 25, 3),
(90, 'SPTahfidz11223311042101', 15, 37, 3),
(91, 'SPTahfidz11223311042102', 15, 37, 3),
(92, 'SPTahfidz11223311042103', 15, 37, 3),
(93, 'SPTahfidz11223311042104', 15, 37, 3),
(94, 'SPTahfidz11223311042105', 15, 37, 3),
(95, 'SPTahfidz11223314042106', 15, 37, 3),
(96, 'SPTahfidz11223314042107', 15, 37, 3),
(97, 'SPTahfidz11223314042107', 15, 37, 3),
(98, 'SPTahfidz11223314042108', 15, 37, 3),
(99, 'SPTahfidz11122233314042101', 15, 38, 3),
(100, 'SPTahfidz11223315042109', 15, 37, 3),
(101, 'SPTahfidz11223315042110', 15, 37, 3),
(102, 'SPTahfidz11122233317042102', 15, 38, 3);

-- --------------------------------------------------------

--
-- Table structure for table `unit_pos`
--

CREATE TABLE `unit_pos` (
  `idUnitPos` int(11) NOT NULL,
  `nmUnitPos` varchar(50) NOT NULL,
  `unitSekolah` int(11) NOT NULL,
  `stdel` int(11) DEFAULT '0',
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `unit_pos`
--

INSERT INTO `unit_pos` (`idUnitPos`, `nmUnitPos`, `unitSekolah`, `stdel`, `cby`, `cdate`, `uby`, `udate`, `dby`, `ddate`) VALUES
(1, '0', 1, 1, 1, '2021-01-28 16:38:23', NULL, NULL, 1, '2021-01-28 16:39:18'),
(2, '122', 6, 0, 1, '2021-01-28 16:38:23', 1, '2021-01-28 16:41:53', NULL, NULL),
(3, 'ABC', 5, 0, 1, '2021-01-28 16:38:50', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `unit_sekolah`
--

CREATE TABLE `unit_sekolah` (
  `idUnit` int(11) NOT NULL,
  `namaUnit` varchar(100) DEFAULT NULL,
  `singkatanUnit` varchar(100) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `stdel` int(11) DEFAULT NULL,
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `unit_sekolah`
--

INSERT INTO `unit_sekolah` (`idUnit`, `namaUnit`, `singkatanUnit`, `status`, `stdel`, `cby`, `cdate`, `uby`, `udate`, `dby`, `ddate`) VALUES
(1, 'Tahfidzul Quran', 'Tahfidz', '1', 0, 1, '2021-01-16 10:37:37', NULL, NULL, NULL, NULL),
(2, 'Madrasah Diniyah', 'Madin', '0', 0, 1, '2021-01-16 10:37:50', 1, '2021-01-20 00:17:46', NULL, NULL),
(3, 'Pondok Putra', 'PONPESPA', '0', 0, 1, '2021-01-16 10:38:19', NULL, NULL, NULL, NULL),
(4, 'Pondok Putri', 'PONPESPI', '0', 0, 1, '2021-01-16 10:38:32', NULL, NULL, NULL, NULL),
(5, 'Sekolah Menengah Pertama', 'SMP-TMI', '1', 0, 1, '2021-01-16 10:38:43', 1, '2021-01-16 10:38:52', NULL, NULL),
(6, 'Sekolah Menengah Atas', 'SMA-TMI', '1', 0, 1, '2021-01-16 10:39:05', 1, '2021-01-16 10:47:07', NULL, NULL),
(7, 'Sekolah Tinggi Agama Islam', 'STAI', '0', 0, 1, '2021-01-16 10:39:22', 1, '2021-01-19 01:44:04', NULL, NULL),
(8, 'sadsad', 'sdasd', '0', 1, 1, '2021-01-16 10:48:01', NULL, NULL, 1, '2021-01-16 10:48:04'),
(9, 'asdsad', 'asdsad', '1', 1, 1, '2021-01-17 17:33:01', 1, '2021-01-17 17:33:07', 1, '2021-01-17 17:33:12'),
(10, 'adsd', 'adsad', '0', 1, 1, '2021-01-17 17:38:39', 1, '2021-01-17 17:39:02', 1, '2021-01-17 17:40:50'),
(11, 'Tahfidzul Quran', 'sadasd', '0', 1, 1, '2021-01-18 13:36:41', NULL, NULL, 1, '2021-01-18 13:37:17'),
(12, 'asdsad', 'asdsadsad', '1', 1, 1, '2021-01-18 13:36:51', 1, '2021-01-18 13:37:07', 1, '2021-01-18 13:37:12'),
(13, 'sadasd', 'asdsadsad', '1', 1, 1, '2021-01-18 23:53:09', NULL, NULL, 1, '2021-01-18 23:53:12'),
(14, 'asdsa', 'asddsad', '0', 1, 0, '2021-01-18 23:57:26', NULL, NULL, 1, '2021-01-18 23:58:48'),
(15, 'asdsa', 'dsadsad', '0', 1, 1, '2021-01-18 23:58:53', 1, '2021-01-18 23:59:02', 1, '2021-01-18 23:59:10'),
(16, 'zzzz', 'zzzz', '0', 1, 1, '2021-01-19 01:42:55', 1, '2021-01-19 01:43:05', 1, '2021-01-19 01:43:09'),
(17, 'xxvvvv', 'wwwwww', '0', 1, 1, '2021-01-19 01:45:45', 1, '2021-01-19 01:46:04', 1, '2021-01-19 01:46:07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `idUsers` int(11) NOT NULL,
  `nama_lengkap` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `email` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `password` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `level` int(11) NOT NULL,
  `unit` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `deskripsi` text COLLATE latin1_general_ci,
  `foto` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `stdel` int(11) DEFAULT '0',
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`idUsers`, `nama_lengkap`, `email`, `password`, `level`, `unit`, `deskripsi`, `foto`, `last_login`, `stdel`, `cby`, `cdate`, `uby`, `udate`, `dby`, `ddate`) VALUES
(1, 'admin', 'admin@gmail.com', '3920cc4f716e625754bb4c1b73bee4aa', 1, '0', 'ADMIN ADMIN', 'download.jpg', '2021-04-23 03:10:09', 0, NULL, NULL, 1, '2021-04-23 09:24:56', NULL, NULL),
(8, 'aa', 'aa@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 2, '0', 'MM', NULL, NULL, 1, 1, '2021-01-17 03:31:02', NULL, NULL, 1, '2021-01-17 04:18:00'),
(9, 'asdsad', '1234@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 6, '1', 'asdsadsad', NULL, NULL, 1, 1, '2021-01-17 03:35:20', NULL, NULL, 1, '2021-01-17 04:18:04'),
(10, 'sadasd', 'a33@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 2, '0', 'sdsad', NULL, NULL, 1, 1, '2021-01-17 03:36:11', NULL, NULL, 1, '2021-01-17 04:17:32'),
(11, 'sadsad', 'asdsadsa@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 5, '1', 'dfsadfsdf', NULL, NULL, 1, 1, '2021-01-17 03:43:35', NULL, NULL, 1, '2021-01-17 03:46:35'),
(12, 'as', 'rr@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 4, '0', '123456', NULL, NULL, 1, 1, '2021-01-17 03:44:48', NULL, NULL, 1, '2021-01-17 03:46:33'),
(14, 'asdsadasd', '123123@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 7, '5', '123456', NULL, NULL, 1, 1, '2021-01-17 03:49:02', NULL, NULL, 1, '2021-01-17 04:18:11'),
(15, 'asdsad', 'uang@gmail.ss', 'e10adc3949ba59abbe56e057f20f883e', 8, '5', 'sadasd', NULL, '2021-02-23 09:42:20', 0, 1, '2021-01-17 03:49:50', 1, '2021-04-23 09:25:47', NULL, NULL),
(17, 'pp', 'pp@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 8, '0', 'pp123456', '3.PNG', NULL, 1, 1, '2021-01-17 03:52:28', 1, '2021-01-17 18:17:10', 1, '2021-01-17 18:26:34'),
(19, '1111', 'ksiswa@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 5, '1', 'sdsadsad', NULL, NULL, 0, 1, '2021-01-25 01:55:40', 1, '2021-04-23 09:25:27', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_hak_akses`
--

CREATE TABLE `users_hak_akses` (
  `idHakAkses` int(11) NOT NULL,
  `IdUsersLevel` int(11) NOT NULL,
  `idMenu` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_hak_akses`
--

INSERT INTO `users_hak_akses` (`idHakAkses`, `IdUsersLevel`, `idMenu`) VALUES
(1, 1, '1'),
(2, 1, '51'),
(3, 1, '52'),
(4, 1, '53'),
(5, 1, '54'),
(6, 1, '55'),
(7, 1, '56'),
(8, 1, '57'),
(9, 1, '17'),
(10, 1, '18'),
(11, 1, '19'),
(12, 1, '20'),
(13, 1, '21'),
(14, 1, '22'),
(18, 1, '2'),
(19, 1, '3'),
(20, 1, '4'),
(21, 1, '5'),
(22, 1, '6'),
(23, 1, '7'),
(24, 1, '8'),
(25, 1, '9'),
(26, 1, '10'),
(27, 1, '11'),
(28, 1, '12'),
(29, 1, '13'),
(30, 1, '14'),
(31, 1, '15'),
(32, 1, '16'),
(33, 1, '23'),
(34, 1, '24'),
(35, 1, '25'),
(36, 1, '26'),
(37, 1, '27'),
(38, 1, '28'),
(39, 1, '29'),
(40, 1, '30'),
(41, 1, '31'),
(42, 1, '32'),
(43, 1, '33'),
(44, 1, '34'),
(45, 1, '35'),
(46, 1, '36'),
(47, 1, '37'),
(48, 1, '38'),
(49, 1, '39'),
(50, 1, '40'),
(51, 1, '41'),
(52, 1, '42'),
(53, 1, '43'),
(54, 1, '44'),
(55, 1, '45'),
(56, 1, '46'),
(57, 1, '47'),
(58, 1, '48'),
(59, 1, '49'),
(60, 1, '50'),
(63, 8, '2'),
(64, 8, '3'),
(65, 8, '4'),
(66, 8, '5'),
(67, 8, '6'),
(68, 8, '8'),
(69, 8, '10'),
(70, 8, '11'),
(71, 8, '12'),
(72, 8, '13'),
(73, 8, '9'),
(74, 8, '7'),
(75, 8, '14'),
(76, 8, '15'),
(77, 8, '16'),
(78, 8, '17'),
(79, 8, '18'),
(80, 8, '19'),
(81, 8, '20'),
(82, 8, '21'),
(83, 8, '22'),
(84, 8, '23'),
(85, 8, '24'),
(86, 8, '25'),
(87, 8, '26'),
(88, 8, '27'),
(89, 8, '28'),
(90, 8, '29'),
(91, 8, '30'),
(92, 8, '31'),
(93, 8, '32'),
(94, 8, '33'),
(95, 8, '34'),
(96, 8, '36'),
(97, 8, '35'),
(98, 8, '37'),
(99, 8, '38'),
(100, 8, '39'),
(101, 8, '40'),
(102, 8, '41'),
(103, 8, '42'),
(104, 8, '43'),
(105, 8, '46'),
(106, 8, '45'),
(107, 8, '44'),
(108, 8, '47'),
(109, 8, '48'),
(110, 8, '49'),
(111, 8, '50'),
(113, 8, '1'),
(115, 1, '61'),
(116, 1, '62'),
(117, 1, '63'),
(118, 1, '64'),
(119, 1, '65'),
(120, 1, '66'),
(121, 8, '51'),
(122, 8, '52'),
(123, 8, '53'),
(124, 8, '54'),
(125, 8, '55'),
(126, 8, '56'),
(127, 8, '57'),
(128, 1, '67'),
(129, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `users_level`
--

CREATE TABLE `users_level` (
  `idUsersLevel` int(11) NOT NULL,
  `namaUsersLevel` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_level`
--

INSERT INTO `users_level` (`idUsersLevel`, `namaUsersLevel`) VALUES
(1, 'ADMIN'),
(2, 'KONSELING'),
(3, 'KESEHATAN'),
(4, 'AKADEMIK'),
(5, 'KESISWAAN'),
(6, 'TATA USAHA'),
(7, 'GURU'),
(8, 'KEUANGAN'),
(9, 'KASIR');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akun_biaya`
--
ALTER TABLE `akun_biaya`
  ADD PRIMARY KEY (`idAkun`);

--
-- Indexes for table `angsurantoko`
--
ALTER TABLE `angsurantoko`
  ADD PRIMARY KEY (`id_angsurantoko`);

--
-- Indexes for table `bulan`
--
ALTER TABLE `bulan`
  ADD PRIMARY KEY (`idBulan`);

--
-- Indexes for table `hutangtoko`
--
ALTER TABLE `hutangtoko`
  ADD PRIMARY KEY (`id_hutangtoko`);

--
-- Indexes for table `hutang_bayar`
--
ALTER TABLE `hutang_bayar`
  ADD PRIMARY KEY (`idBayarHutang`);

--
-- Indexes for table `hutang_pos`
--
ALTER TABLE `hutang_pos`
  ADD PRIMARY KEY (`idPosHutang`);

--
-- Indexes for table `hutang_setting`
--
ALTER TABLE `hutang_setting`
  ADD PRIMARY KEY (`idSettingHutang`);

--
-- Indexes for table `hutang_setting_detail`
--
ALTER TABLE `hutang_setting_detail`
  ADD PRIMARY KEY (`idDetailHutang`);

--
-- Indexes for table `identitas`
--
ALTER TABLE `identitas`
  ADD PRIMARY KEY (`npsn`);

--
-- Indexes for table `informasi`
--
ALTER TABLE `informasi`
  ADD PRIMARY KEY (`idInformasi`);

--
-- Indexes for table `izin_keluar`
--
ALTER TABLE `izin_keluar`
  ADD PRIMARY KEY (`idKeluar`);

--
-- Indexes for table `izin_pulang`
--
ALTER TABLE `izin_pulang`
  ADD PRIMARY KEY (`idPulang`);

--
-- Indexes for table `jabatan_pegawai`
--
ALTER TABLE `jabatan_pegawai`
  ADD PRIMARY KEY (`idJabatan`);

--
-- Indexes for table `jenis_bayar`
--
ALTER TABLE `jenis_bayar`
  ADD PRIMARY KEY (`idJenisBayar`);

--
-- Indexes for table `jurnal_umum`
--
ALTER TABLE `jurnal_umum`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kamar`
--
ALTER TABLE `kamar`
  ADD PRIMARY KEY (`idKamar`);

--
-- Indexes for table `kas`
--
ALTER TABLE `kas`
  ADD PRIMARY KEY (`idKas`);

--
-- Indexes for table `kas_transaksi`
--
ALTER TABLE `kas_transaksi`
  ADD PRIMARY KEY (`idTransaksiKas`);

--
-- Indexes for table `kelas_siswa`
--
ALTER TABLE `kelas_siswa`
  ADD PRIMARY KEY (`idKelas`);

--
-- Indexes for table `kwitansi`
--
ALTER TABLE `kwitansi`
  ADD PRIMARY KEY (`id_kwitansi`);

--
-- Indexes for table `log_kasir`
--
ALTER TABLE `log_kasir`
  ADD PRIMARY KEY (`idTransaksi`);

--
-- Indexes for table `log_transaksi`
--
ALTER TABLE `log_transaksi`
  ADD PRIMARY KEY (`idTransaksi`);

--
-- Indexes for table `memodb`
--
ALTER TABLE `memodb`
  ADD PRIMARY KEY (`kwnum`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`idMenu`);

--
-- Indexes for table `pajak`
--
ALTER TABLE `pajak`
  ADD PRIMARY KEY (`idPajak`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`idPegawai`);

--
-- Indexes for table `pegawai_gaji`
--
ALTER TABLE `pegawai_gaji`
  ADD PRIMARY KEY (`idGaji`);

--
-- Indexes for table `pegawai_gaji_slip`
--
ALTER TABLE `pegawai_gaji_slip`
  ADD PRIMARY KEY (`idSlipGaji`);

--
-- Indexes for table `pegawai_jabatan`
--
ALTER TABLE `pegawai_jabatan`
  ADD PRIMARY KEY (`idPegawaiJabatan`);

--
-- Indexes for table `pegawai_keluarga`
--
ALTER TABLE `pegawai_keluarga`
  ADD PRIMARY KEY (`idKeluarga`);

--
-- Indexes for table `pegawai_mengajar`
--
ALTER TABLE `pegawai_mengajar`
  ADD PRIMARY KEY (`idMengajar`);

--
-- Indexes for table `pegawai_pendidikan`
--
ALTER TABLE `pegawai_pendidikan`
  ADD PRIMARY KEY (`idPendidikan`);

--
-- Indexes for table `pegawai_penghargaan`
--
ALTER TABLE `pegawai_penghargaan`
  ADD PRIMARY KEY (`idPenghargaan`);

--
-- Indexes for table `pegawai_seminar`
--
ALTER TABLE `pegawai_seminar`
  ADD PRIMARY KEY (`idSeminar`);

--
-- Indexes for table `pos_bayar`
--
ALTER TABLE `pos_bayar`
  ADD PRIMARY KEY (`idPosBayar`);

--
-- Indexes for table `ref`
--
ALTER TABLE `ref`
  ADD PRIMARY KEY (`ref_id`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`idSiswa`),
  ADD KEY `fk_status` (`statusSiswa`);

--
-- Indexes for table `siswa_kesehatan`
--
ALTER TABLE `siswa_kesehatan`
  ADD PRIMARY KEY (`idKesehatan`);

--
-- Indexes for table `siswa_konseling`
--
ALTER TABLE `siswa_konseling`
  ADD PRIMARY KEY (`idKonseling`);

--
-- Indexes for table `siswa_tahfidz`
--
ALTER TABLE `siswa_tahfidz`
  ADD PRIMARY KEY (`idTahfidz`);

--
-- Indexes for table `tabungan_siswa`
--
ALTER TABLE `tabungan_siswa`
  ADD PRIMARY KEY (`idTabungan`);

--
-- Indexes for table `tagihan_bebas`
--
ALTER TABLE `tagihan_bebas`
  ADD PRIMARY KEY (`idTagihanBebas`),
  ADD KEY `fk_t_jenis` (`idJenisBayar`),
  ADD KEY `fk_t_siswa` (`idSiswa`),
  ADD KEY `fk_t_kelas` (`idKelas`);

--
-- Indexes for table `tagihan_bebas_bayar`
--
ALTER TABLE `tagihan_bebas_bayar`
  ADD PRIMARY KEY (`idTagihanBebasBayar`),
  ADD KEY `fkbayarbebas` (`idTagihanBebas`);

--
-- Indexes for table `tagihan_bulanan`
--
ALTER TABLE `tagihan_bulanan`
  ADD PRIMARY KEY (`idTagihanBulanan`),
  ADD KEY `fk_t_jenis` (`idJenisBayar`),
  ADD KEY `fk_t_siswa` (`idSiswa`),
  ADD KEY `fk_t_kelas` (`idKelas`),
  ADD KEY `fk_t_bulan` (`idBulan`);

--
-- Indexes for table `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  ADD PRIMARY KEY (`idTahunAjaran`);

--
-- Indexes for table `tb_tes`
--
ALTER TABLE `tb_tes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `transaksi_pembayaran`
--
ALTER TABLE `transaksi_pembayaran`
  ADD PRIMARY KEY (`idTransaksiBayar`);

--
-- Indexes for table `unit_pos`
--
ALTER TABLE `unit_pos`
  ADD PRIMARY KEY (`idUnitPos`);

--
-- Indexes for table `unit_sekolah`
--
ALTER TABLE `unit_sekolah`
  ADD PRIMARY KEY (`idUnit`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUsers`);

--
-- Indexes for table `users_hak_akses`
--
ALTER TABLE `users_hak_akses`
  ADD PRIMARY KEY (`idHakAkses`);

--
-- Indexes for table `users_level`
--
ALTER TABLE `users_level`
  ADD PRIMARY KEY (`idUsersLevel`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agenda`
--
ALTER TABLE `agenda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `akun_biaya`
--
ALTER TABLE `akun_biaya`
  MODIFY `idAkun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `hutang_bayar`
--
ALTER TABLE `hutang_bayar`
  MODIFY `idBayarHutang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `hutang_pos`
--
ALTER TABLE `hutang_pos`
  MODIFY `idPosHutang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `hutang_setting`
--
ALTER TABLE `hutang_setting`
  MODIFY `idSettingHutang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `hutang_setting_detail`
--
ALTER TABLE `hutang_setting_detail`
  MODIFY `idDetailHutang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `informasi`
--
ALTER TABLE `informasi`
  MODIFY `idInformasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `izin_keluar`
--
ALTER TABLE `izin_keluar`
  MODIFY `idKeluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `izin_pulang`
--
ALTER TABLE `izin_pulang`
  MODIFY `idPulang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jabatan_pegawai`
--
ALTER TABLE `jabatan_pegawai`
  MODIFY `idJabatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `jenis_bayar`
--
ALTER TABLE `jenis_bayar`
  MODIFY `idJenisBayar` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jurnal_umum`
--
ALTER TABLE `jurnal_umum`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `kamar`
--
ALTER TABLE `kamar`
  MODIFY `idKamar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `kas`
--
ALTER TABLE `kas`
  MODIFY `idKas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `kas_transaksi`
--
ALTER TABLE `kas_transaksi`
  MODIFY `idTransaksiKas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `kelas_siswa`
--
ALTER TABLE `kelas_siswa`
  MODIFY `idKelas` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `log_kasir`
--
ALTER TABLE `log_kasir`
  MODIFY `idTransaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `log_transaksi`
--
ALTER TABLE `log_transaksi`
  MODIFY `idTransaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `idMenu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `pajak`
--
ALTER TABLE `pajak`
  MODIFY `idPajak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `idPegawai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `pegawai_gaji`
--
ALTER TABLE `pegawai_gaji`
  MODIFY `idGaji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pegawai_gaji_slip`
--
ALTER TABLE `pegawai_gaji_slip`
  MODIFY `idSlipGaji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `pegawai_jabatan`
--
ALTER TABLE `pegawai_jabatan`
  MODIFY `idPegawaiJabatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pegawai_keluarga`
--
ALTER TABLE `pegawai_keluarga`
  MODIFY `idKeluarga` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pegawai_mengajar`
--
ALTER TABLE `pegawai_mengajar`
  MODIFY `idMengajar` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pegawai_pendidikan`
--
ALTER TABLE `pegawai_pendidikan`
  MODIFY `idPendidikan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pegawai_penghargaan`
--
ALTER TABLE `pegawai_penghargaan`
  MODIFY `idPenghargaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pegawai_seminar`
--
ALTER TABLE `pegawai_seminar`
  MODIFY `idSeminar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pos_bayar`
--
ALTER TABLE `pos_bayar`
  MODIFY `idPosBayar` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `ref`
--
ALTER TABLE `ref`
  MODIFY `ref_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `idSiswa` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `siswa_kesehatan`
--
ALTER TABLE `siswa_kesehatan`
  MODIFY `idKesehatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `siswa_konseling`
--
ALTER TABLE `siswa_konseling`
  MODIFY `idKonseling` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `siswa_tahfidz`
--
ALTER TABLE `siswa_tahfidz`
  MODIFY `idTahfidz` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tabungan_siswa`
--
ALTER TABLE `tabungan_siswa`
  MODIFY `idTabungan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tagihan_bebas`
--
ALTER TABLE `tagihan_bebas`
  MODIFY `idTagihanBebas` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tagihan_bebas_bayar`
--
ALTER TABLE `tagihan_bebas_bayar`
  MODIFY `idTagihanBebasBayar` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tagihan_bulanan`
--
ALTER TABLE `tagihan_bulanan`
  MODIFY `idTagihanBulanan` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  MODIFY `idTahunAjaran` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tb_tes`
--
ALTER TABLE `tb_tes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `transaksi_pembayaran`
--
ALTER TABLE `transaksi_pembayaran`
  MODIFY `idTransaksiBayar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `unit_pos`
--
ALTER TABLE `unit_pos`
  MODIFY `idUnitPos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `unit_sekolah`
--
ALTER TABLE `unit_sekolah`
  MODIFY `idUnit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `idUsers` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users_hak_akses`
--
ALTER TABLE `users_hak_akses`
  MODIFY `idHakAkses` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `users_level`
--
ALTER TABLE `users_level`
  MODIFY `idUsersLevel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tagihan_bebas`
--
ALTER TABLE `tagihan_bebas`
  ADD CONSTRAINT `tagihan_bebas_ibfk_2` FOREIGN KEY (`idJenisBayar`) REFERENCES `jenis_bayar` (`idJenisBayar`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tagihan_bebas_ibfk_3` FOREIGN KEY (`idKelas`) REFERENCES `kelas_siswa` (`idKelas`) ON UPDATE CASCADE;

--
-- Constraints for table `tagihan_bebas_bayar`
--
ALTER TABLE `tagihan_bebas_bayar`
  ADD CONSTRAINT `fkbayarbebas` FOREIGN KEY (`idTagihanBebas`) REFERENCES `tagihan_bebas` (`idTagihanBebas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tagihan_bulanan`
--
ALTER TABLE `tagihan_bulanan`
  ADD CONSTRAINT `fk_t_bulan` FOREIGN KEY (`idBulan`) REFERENCES `bulan` (`idBulan`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_t_jenis` FOREIGN KEY (`idJenisBayar`) REFERENCES `jenis_bayar` (`idJenisBayar`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_t_kelas` FOREIGN KEY (`idKelas`) REFERENCES `kelas_siswa` (`idKelas`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
