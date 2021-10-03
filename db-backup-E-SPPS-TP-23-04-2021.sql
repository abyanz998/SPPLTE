
/*---------------------------------------------------------------
  SQL DB BACKUP 23.04.2021 09:26 
  HOST: localhost
  DATABASE: spplte
  TABLES: *
  ---------------------------------------------------------------*/

/*---------------------------------------------------------------
  TABLE: `agenda`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `agenda`;
CREATE TABLE `agenda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `ddate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
INSERT INTO `agenda` VALUES   ('7','  123','#008000','2020-12-29 00:00:00','2020-12-30 00:00:00','1','1','2021-01-17 16:14:36','1','2021-01-17 16:44:08','1','2021-01-17 16:44:13');
INSERT INTO `agenda` VALUES ('8','COBA AGENDA','#40E0D0','2021-01-11 00:00:00','2021-01-12 00:00:00','0','1','2021-01-17 16:44:41','1','2021-01-20 09:07:43',NULL,NULL);
INSERT INTO `agenda` VALUES ('9','dsadsad','#008000','2021-01-04 00:00:00','2021-01-05 00:00:00','1','1','2021-01-17 16:45:40','1','2021-01-17 16:47:53','1','2021-01-17 16:47:57');
INSERT INTO `agenda` VALUES ('10','12344','#0071c5','2021-01-06 00:00:00','2021-01-07 00:00:00','1','1','2021-01-18 23:47:00','1','2021-01-18 23:47:41','1','2021-01-18 23:47:47');
INSERT INTO `agenda` VALUES ('11','APA AJA','#FF0000','2021-02-08 00:00:00','2021-02-09 00:00:00','1','1','2021-02-08 01:52:33','1','2021-02-08 01:53:41','1','2021-02-08 01:53:51');
INSERT INTO `agenda` VALUES ('12','fdfsdfdsf','#40E0D0','2021-02-06 00:00:00','2021-02-10 00:00:00','1','1','2021-02-08 01:53:59','1','2021-02-08 01:54:13','1','2021-02-11 22:34:39');

/*---------------------------------------------------------------
  TABLE: `akun_biaya`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `akun_biaya`;
CREATE TABLE `akun_biaya` (
  `idAkun` int(11) NOT NULL AUTO_INCREMENT,
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
  `ddate` datetime DEFAULT NULL,
  PRIMARY KEY (`idAkun`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4;
INSERT INTO `akun_biaya` VALUES   ('1',NULL,'1-10000','AKTIVA','Akun Utama','#','0',NULL,NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('2','1','1-10100','Aktiva','Sub Menu 1','#','5',NULL,NULL,'1','1','2021-01-28 01:15:24','1','2021-01-28 01:16:19','1','2021-01-28 01:16:23');
INSERT INTO `akun_biaya` VALUES ('4','1','1-10100','Aktiva SMP TMI','Sub Menu 1','#','5',NULL,NULL,'0','1','2021-01-28 01:17:16','1','2021-02-14 00:31:57',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('5','1','1-10200','Aktiva SMA TMI','Sub Menu 1','#','6',NULL,NULL,'0','1','2021-01-28 01:17:27','1','2021-02-14 00:32:28',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('6','1','1-10300','Aktiva Tahfidz','Sub Menu 1','#','1',NULL,NULL,'0','1','2021-01-28 01:17:33','1','2021-02-14 00:32:51',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('7','4','1-10101','Kas Tunai SMP TMI','Sub Menu 2','Keuangan','5','0','0','0','1','2021-01-28 01:25:02','1','2021-02-14 00:32:07',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('8','4','1-10102','Kas Bank  SMP TMI','Sub Menu 2','Keuangan','5','0','0','0','1','2021-01-28 01:26:46','1','2021-02-14 00:32:13',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('10',NULL,'2-20000','PASIVA','Akun Utama','#','0',NULL,NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('11','4','1-10103','ffff','Sub Menu 2','Keuangan','1','0','0','1','1','2021-01-28 01:51:07',NULL,NULL,'1','2021-01-28 01:51:11');
INSERT INTO `akun_biaya` VALUES ('12','7','1-10101.1','sss1111','Sub Menu 3','Pembayaran','6',NULL,NULL,'1','1','2021-01-28 01:54:57','1','2021-01-28 02:02:46','1','2021-01-28 02:02:57');
INSERT INTO `akun_biaya` VALUES ('13','5','1-10201','Kas Tunai SMA TMI','Sub Menu 2','Keuangan','6','0','0','0','1','2021-01-28 02:04:24','1','2021-02-14 00:32:35',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('14','5','1-10202','Kas Bank SMA TMI','Sub Menu 2','Keuangan','6','0','0','0','1','2021-01-28 02:04:32','1','2021-02-14 00:32:40',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('15','6','1-10301','Kas Tunai Tahfidz','Sub Menu 2','Keuangan','1','0','0','0','1','2021-01-28 02:04:54','1','2021-02-14 00:33:00',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('16','6','1-10302','Kas Bank Tahfidz','Sub Menu 2','Keuangan','1','0','0','0','1','2021-01-28 02:05:06','1','2021-02-14 00:33:11',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('17',NULL,'3-30000','MODAL','Akun Utama','#','0',NULL,NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('18',NULL,'4-40000','PENDAPATAN','Akun Utama','#','0',NULL,NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('19',NULL,'5-50000','BEBAN','Akun Utama','#','0',NULL,NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('20','18','4-40100','Pendapatan SMP TMI','Sub Menu 1','#','5',NULL,NULL,'0','1','2021-01-28 02:06:50','1','2021-02-14 00:38:19',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('21','20','4-40101','SPP SMP TMI','Sub Menu 2','Pembayaran','5','0','0','0','1','2021-01-28 02:07:23','1','2021-02-14 00:38:26',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('22','20','4-40102','DU Smt-1 SMP TMI','Sub Menu 2','Pembayaran','5','0','0','0','1','2021-01-28 02:07:50','1','2021-02-14 00:38:33',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('23','20','4-40103','DU Smt-2 SMP TMI','Sub Menu 2','Pembayaran','5','0','0','0','1','2021-01-28 02:08:03','1','2021-02-14 00:38:39',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('24','20','4-40104','ZIS donatur SMP TMI','Sub Menu 2','Keuangan','5','0','0','0','1','2021-01-28 02:08:22','1','2021-02-14 00:38:47',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('25','20','4-40105','Dana BOS Daerah SMP TMI','Sub Menu 2','Keuangan','5','0','0','0','1','2021-01-28 02:08:38','1','2021-02-14 00:38:58',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('26','20','4-40106','Tunggakan TA lalu SMP TMI','Sub Menu 2','Pembayaran','5','0','0','0','1','2021-01-28 02:08:51','1','2021-02-14 00:39:11',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('27','20','4-40107','Sarana Santri Baru SMP TMI','Sub Menu 2','Pembayaran','5','0','0','0','1','2021-01-28 02:09:07','1','2021-02-14 00:39:21',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('28','20','4-40108','Kitab Santri Baru SMP TMI','Sub Menu 2','Pembayaran','5','0','0','0','1','2021-01-28 02:09:51','1','2021-02-14 00:39:27',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('29','1','1-10400','Piutang SMP TMI','Sub Menu 1','#','5',NULL,NULL,'0','1','2021-01-28 02:13:36','1','2021-02-14 00:37:01',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('30','1','1-10500','Piutang SMA TMI','Sub Menu 1','#','6',NULL,NULL,'0','1','2021-01-28 02:13:50','1','2021-02-14 00:37:42',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('31','1','1-10600','Piutang Tahfidz','Sub Menu 1','#','1',NULL,NULL,'0','1','2021-01-28 02:14:03','1','2021-02-14 00:35:30',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('32','29','1-10401','Piutang Siswa SMP TMI','Sub Menu 2','Keuangan','5','0','0','0','1','2021-01-28 02:14:24','1','2021-02-14 00:36:49',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('33','30','1-10501','Piutang Siswa SMA TMI','Sub Menu 2','Keuangan','6','0','0','0','1','2021-01-28 02:14:33','1','2021-02-14 00:37:53',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('34','31','1-10601','Piutang Siswa Tahfidz','Sub Menu 2','Keuangan','1','0','0','0','1','2021-01-28 02:14:44','1','2021-02-14 00:33:25',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('35','18','4-40200','Pendapatan SMA TMI','Sub Menu 1','#','6',NULL,NULL,'0','1','2021-01-28 19:11:04','1','2021-02-14 00:39:53',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('36','35','4-40201','SPP SMA TMI','Sub Menu 2','Pembayaran','6','0','0','0','1','2021-01-28 19:11:50','1','2021-02-14 00:39:45',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('37','35','4-40202','DU Smt-1 SMA TMI','Sub Menu 2','Pembayaran','6','0','0','0','1','2021-01-28 19:12:08','1','2021-02-14 00:40:03',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('38','35','4-40203','DU Smt-2 SMA TMI','Sub Menu 2','Pembayaran','6','0','0','0','1','2021-01-28 19:12:20','1','2021-02-14 00:40:11',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('39','35','4-40204','ZIS donatur SMA TMI','Sub Menu 2','Keuangan','6','0','0','0','1','2021-01-28 19:12:47','1','2021-02-14 00:40:17',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('40','35','4-40205','Dana BOS Daerah SMA TMI','Sub Menu 2','Keuangan','6','0','0','0','1','2021-01-28 19:13:08','1','2021-02-14 00:40:26',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('41','35','4-40206','Tunggakan TA lalu SMA TMI','Sub Menu 2','Pembayaran','6','0','0','0','1','2021-01-28 19:13:27','1','2021-02-14 00:40:36',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('42','35','4-40207','Sarana Santri Baru SMA TMI','Sub Menu 2','Pembayaran','6','0','0','0','1','2021-01-28 19:13:43','1','2021-02-14 00:40:45',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('43','35','4-40208','IURAN PENGOBATAN SMA TMI','Sub Menu 2','Pembayaran','6','0','0','0','1','2021-01-28 19:14:02','1','2021-02-14 00:40:59',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('44','35','4-40209','Kitab Santri Baru SMA TMI','Sub Menu 2','Pembayaran','6','0','0','0','1','2021-01-28 19:14:20','1','2021-02-14 00:41:08',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('45','18','4-40300','Pendapatan Tahfidz','Sub Menu 1','#','1',NULL,NULL,'0','1','2021-01-28 19:16:05','1','2021-02-14 00:41:35',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('46','45','4-40301','SPP Tahfidz','Sub Menu 2','Pembayaran','1','0','0','0','1','2021-01-28 19:16:44','1','2021-02-14 00:33:43',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('47','45','4-40302','ZIS donatur Tahfidz','Sub Menu 2','Keuangan','1','0','0','0','1','2021-01-28 19:16:59','1','2021-02-14 00:34:45',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('48','45','4-40303','Daftar Ulang Santri Baru Tahfidz','Sub Menu 2','Pembayaran','1','0','0','0','1','2021-01-28 19:17:14','1','2021-02-14 00:34:56',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('49','45','4-40304','Tunggakan TA lalu Tahfidz','Sub Menu 2','Pembayaran','1','0','0','0','1','2021-01-28 19:17:29','1','2021-02-14 00:35:05',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('50','1','1-10700','Kas Bank','Sub Menu 1','#','5',NULL,NULL,'1','1','2021-01-30 23:10:21',NULL,NULL,'1','2021-01-30 23:12:22');
INSERT INTO `akun_biaya` VALUES ('51','50','1-10701','222','Sub Menu 2','Pembayaran','5','0','0','1','1','2021-01-30 23:10:36',NULL,NULL,'1','2021-01-30 23:12:16');
INSERT INTO `akun_biaya` VALUES ('52','19','5-50100','Pengeluaran SMP TMI','Sub Menu 1','#','5',NULL,NULL,'0','1','2021-02-01 10:14:35','1','2021-02-14 00:41:56',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('53','52','5-50101','Biaya Gaji SMP TMI','Sub Menu 2','Keuangan','5','0','0','0','1','2021-02-01 10:15:00','1','2021-02-14 00:42:05',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('54','52','5-50102','Biaya ATK SMP TMI','Sub Menu 2','Keuangan','5','0','0','0','1','2021-02-01 10:15:15','1','2021-02-14 00:42:11',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('55','52','5-50103','Biaya Perawatan Elektronik SMP TMI','Sub Menu 2','Keuangan','5','0','0','0','1','2021-02-01 10:15:32','1','2021-02-14 00:42:19',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('56','52','5-50104','Biaya Perjalanan Dinas SMP TMI','Sub Menu 2','Keuangan','5','0','0','0','1','2021-02-01 10:15:47','1','2021-02-14 00:42:35',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('57','19','5-50200','Pengeluaran SMA TMI','Sub Menu 1','#','6',NULL,NULL,'0','1','2021-02-01 10:16:04','1','2021-02-14 00:42:45',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('58','57','5-50201','Biaya Gaji SMA TMI','Sub Menu 2','Keuangan','6','0','0','0','1','2021-02-01 10:16:24','1','2021-02-14 00:42:55',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('59','57','5-50202','Biaya ATK SMA TMI','Sub Menu 2','Keuangan','6','0','0','0','1','2021-02-01 10:16:39','1','2021-02-14 00:43:07',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('60','57','5-50203','Biaya Perawatan Elektronik SMA TMI','Sub Menu 2','Keuangan','6','0','0','0','1','2021-02-01 10:16:53','1','2021-02-14 00:43:18',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('61','57','5-50204','Biaya Perjalanan Dinas SMA TMI','Sub Menu 2','Keuangan','6','0','0','0','1','2021-02-01 10:17:08','1','2021-02-14 00:43:25',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('62','19','5-50300','Pengeluaran Tahfidz','Sub Menu 1','#','1',NULL,NULL,'0','1','2021-02-01 10:17:23','1','2021-02-14 00:34:30',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('63','62','5-50301','Biaya Gaji Tahfidz','Sub Menu 2','Keuangan','1','0','0','0','1','2021-02-01 10:17:40','1','2021-02-14 00:34:23',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('64','62','5-50302','Biaya ATK Tahfidz','Sub Menu 2','Keuangan','1','0','0','0','1','2021-02-01 10:17:53','1','2021-02-14 00:34:11',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('65','62','5-50303','Biaya Perawatan Elektronik Tahfidz','Sub Menu 2','Keuangan','1','0','0','0','1','2021-02-01 10:18:07','1','2021-02-14 00:34:03',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('66','62','5-50304','Biaya Perjalanan Dinas Tahfidz','Sub Menu 2','Keuangan','1','0','0','0','1','2021-02-01 10:18:20','1','2021-02-14 00:33:52',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('67','10','2-20100','Hutang SMP TMI','Sub Menu 1','#','5',NULL,NULL,'0','1','2021-02-01 21:21:42','1','2021-02-14 00:37:13',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('68','67','2-20101','Hutang Pegawai SMP TMI','Sub Menu 2','Keuangan','5','0','0','0','1','2021-02-01 21:21:58','1','2021-02-14 00:37:23',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('69','17','3-30100','Modal Tahfidz','Sub Menu 1','#','1',NULL,NULL,'0','1','2021-02-14 03:20:31',NULL,NULL,NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('70','69','3-30101','Modal Tahfidz','Sub Menu 2','Keuangan','1','0','0','0','1','2021-02-14 03:20:53','1','2021-02-15 03:43:36',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('71','17','3-30200','Modal SMP TMI','Sub Menu 1','#','5',NULL,NULL,'0','1','2021-02-15 03:43:56',NULL,NULL,NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('72','17','3-30300','Modal SMA TMI','Sub Menu 1','#','6',NULL,NULL,'0','1','2021-02-15 03:44:10',NULL,NULL,NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('73','71','3-30201','Modal SMP TMI','Sub Menu 2','Keuangan','5','0','0','0','1','2021-02-15 03:44:34',NULL,NULL,NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('74','72','3-30301','Modal SMA TMI','Sub Menu 2','Keuangan','6','0','0','0','1','2021-02-15 03:44:51',NULL,NULL,NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('75','1','1-10700','Akun Bank ','Sub Menu 1','#','1',NULL,NULL,'0','1','2021-04-09 03:22:57','1','2021-04-10 11:58:40',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('76','1','1-10800','Akun Tunai','Sub Menu 1','#','1',NULL,NULL,'0','1','2021-04-09 22:01:45','1','2021-04-10 11:58:51',NULL,NULL);
INSERT INTO `akun_biaya` VALUES ('77','1','1-10900','Akun Bank','Sub Menu 1','#','5',NULL,NULL,'0','1','2021-04-10 12:02:23','1','2021-04-10 12:04:24',NULL,NULL);

/*---------------------------------------------------------------
  TABLE: `angsurantoko`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `angsurantoko`;
CREATE TABLE `angsurantoko` (
  `id_angsurantoko` varchar(10) NOT NULL,
  `id_hutangtoko` varchar(10) NOT NULL,
  `tanggal` date NOT NULL,
  `angsuran` int(11) NOT NULL,
  PRIMARY KEY (`id_angsurantoko`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO `angsurantoko` VALUES   ('AP001','HT001','2019-11-05','2000');
INSERT INTO `angsurantoko` VALUES ('AP002','HT001','2020-01-16','3000');
INSERT INTO `angsurantoko` VALUES ('AP003','HT001','2020-01-25','3');
INSERT INTO `angsurantoko` VALUES ('AP004','HT002','2020-01-25','600000');
INSERT INTO `angsurantoko` VALUES ('AP005','HT003','2020-01-26','120000');
INSERT INTO `angsurantoko` VALUES ('AP006','HT001','2020-01-26','440000');
INSERT INTO `angsurantoko` VALUES ('AP007','HT003','2020-01-27','100000');
INSERT INTO `angsurantoko` VALUES ('AP008','HT001','2020-02-18','20000');
INSERT INTO `angsurantoko` VALUES ('AP009','HT004','2020-02-18','200000');
INSERT INTO `angsurantoko` VALUES ('AP010','HT005','2020-02-23','100000');
INSERT INTO `angsurantoko` VALUES ('AP011','HT003','2020-03-09','0');
INSERT INTO `angsurantoko` VALUES ('AP012','HT007','2020-03-11','100000');
INSERT INTO `angsurantoko` VALUES ('AP013','HT008','2020-03-11','250000000');
INSERT INTO `angsurantoko` VALUES ('AP014','HT008','2020-03-11','250000000');
INSERT INTO `angsurantoko` VALUES ('AP015','HT009','2020-04-28','50000');
INSERT INTO `angsurantoko` VALUES ('AP016','HT001','2020-06-10','0');

/*---------------------------------------------------------------
  TABLE: `bulan`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `bulan`;
CREATE TABLE `bulan` (
  `idBulan` varchar(15) NOT NULL DEFAULT '0',
  `nmBulan` varchar(25) DEFAULT NULL,
  `urutan` int(2) DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  PRIMARY KEY (`idBulan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO `bulan` VALUES   ('1','Januari','7',NULL,NULL);
INSERT INTO `bulan` VALUES ('10','Oktober','4',NULL,NULL);
INSERT INTO `bulan` VALUES ('11','November','5',NULL,NULL);
INSERT INTO `bulan` VALUES ('12','Desember','6',NULL,NULL);
INSERT INTO `bulan` VALUES ('2','Februari','8',NULL,NULL);
INSERT INTO `bulan` VALUES ('3','Maret','9',NULL,NULL);
INSERT INTO `bulan` VALUES ('4','April','10',NULL,NULL);
INSERT INTO `bulan` VALUES ('5','Mei','11',NULL,NULL);
INSERT INTO `bulan` VALUES ('6','Juni','12',NULL,NULL);
INSERT INTO `bulan` VALUES ('7','Juli','1','1','2021-01-25 01:38:48');
INSERT INTO `bulan` VALUES ('8','Agustus','2','1','2021-01-19 01:06:50');
INSERT INTO `bulan` VALUES ('9','September','3',NULL,NULL);

/*---------------------------------------------------------------
  TABLE: `hutang_bayar`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `hutang_bayar`;
CREATE TABLE `hutang_bayar` (
  `idBayarHutang` int(11) NOT NULL AUTO_INCREMENT,
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
  `ddate` datetime DEFAULT NULL,
  PRIMARY KEY (`idBayarHutang`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4;
INSERT INTO `hutang_bayar` VALUES   ('60','13',NULL,NULL,'Cicilan 1','500000','Belum Lunas','1','1','2021-02-12 16:04:36','1','2021-02-15 04:16:04','1','2021-02-15 04:17:23');
INSERT INTO `hutang_bayar` VALUES ('61','13',NULL,NULL,'Cicilan 2','500000','Belum Lunas','1','1','2021-02-12 16:04:36','1','2021-02-15 04:14:59','1','2021-02-15 04:17:23');
INSERT INTO `hutang_bayar` VALUES ('62','13',NULL,NULL,'Cicilan 3','500000','Belum Lunas','1','1','2021-02-12 16:04:36','1','2021-02-15 04:14:56','1','2021-02-15 04:17:23');
INSERT INTO `hutang_bayar` VALUES ('63','13',NULL,NULL,'Cicilan 4','500000','Belum Lunas','1','1','2021-02-12 16:04:36','1','2021-02-15 01:54:16','1','2021-02-15 04:17:23');
INSERT INTO `hutang_bayar` VALUES ('64','13',NULL,NULL,'Cicilan 5','500000','Belum Lunas','1','1','2021-02-12 16:04:36',NULL,NULL,'1','2021-02-15 04:17:23');
INSERT INTO `hutang_bayar` VALUES ('65','13',NULL,NULL,'Cicilan 6','500000','Belum Lunas','1','1','2021-02-12 16:04:36',NULL,NULL,'1','2021-02-15 04:17:23');
INSERT INTO `hutang_bayar` VALUES ('66','13',NULL,NULL,'Cicilan 7','500000','Belum Lunas','1','1','2021-02-12 16:04:36',NULL,NULL,'1','2021-02-15 04:17:23');
INSERT INTO `hutang_bayar` VALUES ('67','13',NULL,NULL,'Cicilan 8','500000','Belum Lunas','1','1','2021-02-12 16:04:36',NULL,NULL,'1','2021-02-15 04:17:23');
INSERT INTO `hutang_bayar` VALUES ('68','13',NULL,NULL,'Cicilan 9','500000','Belum Lunas','1','1','2021-02-12 16:04:36',NULL,NULL,'1','2021-02-15 04:17:23');
INSERT INTO `hutang_bayar` VALUES ('69','13',NULL,NULL,'Cicilan 10','500000','Belum Lunas','1','1','2021-02-12 16:04:36',NULL,NULL,'1','2021-02-15 04:17:23');
INSERT INTO `hutang_bayar` VALUES ('70','14',NULL,NULL,'Cicilan 1','250000','Belum Lunas','0','1','2021-02-12 16:04:59','1','2021-02-15 04:16:56',NULL,NULL);
INSERT INTO `hutang_bayar` VALUES ('71','14',NULL,NULL,'Cicilan 2','250000','Belum Lunas','0','1','2021-02-12 16:04:59',NULL,NULL,NULL,NULL);

/*---------------------------------------------------------------
  TABLE: `hutang_pos`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `hutang_pos`;
CREATE TABLE `hutang_pos` (
  `idPosHutang` int(11) NOT NULL AUTO_INCREMENT,
  `idAkunHutang` int(11) NOT NULL,
  `namaPosHutang` varchar(100) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `stdel` int(11) DEFAULT '0',
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL,
  PRIMARY KEY (`idPosHutang`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
INSERT INTO `hutang_pos` VALUES   ('1','68','111','11222','1','1','2021-02-01 21:24:13','1','2021-02-01 21:32:47','1','2021-02-01 21:34:53');
INSERT INTO `hutang_pos` VALUES ('2','68','ok','ok','1','1','2021-02-01 21:35:05',NULL,NULL,'1','2021-02-02 16:09:20');
INSERT INTO `hutang_pos` VALUES ('3','68','OK','OK','0','1','2021-02-02 16:18:09',NULL,NULL,NULL,NULL);
INSERT INTO `hutang_pos` VALUES ('4','68','AA','222','0','1','2021-02-14 01:25:35',NULL,NULL,NULL,NULL);

/*---------------------------------------------------------------
  TABLE: `hutang_setting`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `hutang_setting`;
CREATE TABLE `hutang_setting` (
  `idSettingHutang` int(11) NOT NULL AUTO_INCREMENT,
  `idUnit` int(11) NOT NULL,
  `idPosHutang` int(11) NOT NULL,
  `idTahunAjaran` int(11) NOT NULL,
  `stdel` int(11) DEFAULT '0',
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL,
  PRIMARY KEY (`idSettingHutang`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
INSERT INTO `hutang_setting` VALUES   ('5','5','3','3','0','1','2021-02-12 16:02:09',NULL,NULL,NULL,NULL);

/*---------------------------------------------------------------
  TABLE: `hutang_setting_detail`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `hutang_setting_detail`;
CREATE TABLE `hutang_setting_detail` (
  `idDetailHutang` int(11) NOT NULL AUTO_INCREMENT,
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
  `ddate` datetime DEFAULT NULL,
  PRIMARY KEY (`idDetailHutang`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;
INSERT INTO `hutang_setting_detail` VALUES   ('11','HT12022101','2021-02-12','5','2','1','200000','2','100000','1','1','2021-02-12 16:02:20',NULL,NULL,'1','2021-02-12 16:04:28');
INSERT INTO `hutang_setting_detail` VALUES ('12','HT12022102','2021-02-12','5','2','10','5000000','10','500000','1','1','2021-02-12 16:02:39',NULL,NULL,'1','2021-02-12 16:04:26');
INSERT INTO `hutang_setting_detail` VALUES ('13','HT12022101','2021-02-12','5','2','10','5000000','10','500000','1','1','2021-02-12 16:04:36',NULL,NULL,'1','2021-02-15 04:17:23');
INSERT INTO `hutang_setting_detail` VALUES ('14','HT12022102','2021-02-12','5','2','1','500000','2','250000','0','1','2021-02-12 16:04:59',NULL,NULL,NULL,NULL);

/*---------------------------------------------------------------
  TABLE: `hutangtoko`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `hutangtoko`;
CREATE TABLE `hutangtoko` (
  `id_hutangtoko` varchar(10) NOT NULL,
  `hutangke` varchar(50) NOT NULL,
  `tanggal` date NOT NULL,
  `ket` varchar(100) NOT NULL,
  `nominal` int(11) NOT NULL,
  `sisa` int(11) NOT NULL,
  PRIMARY KEY (`id_hutangtoko`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

/*---------------------------------------------------------------
  TABLE: `identitas`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `identitas`;
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
  `udate` datetime DEFAULT NULL,
  PRIMARY KEY (`npsn`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO `identitas` VALUES   ('10700295','E-Pesantren | SIM Pengelolaan Pembayaran Sekolah','E-SPPS-TP','PONDOK PESANTREN ROUDLATUL QURAN','Jl. Angker No.111','AA','Surabaya','Jawa Timur ','-','Jojon.Spd.','-','ANISA ANJARSARI ','-','SHOLIHATUL FAHMI','(0451)-8888-999','APA AJA.png','1','2021-02-17 01:02:36');

/*---------------------------------------------------------------
  TABLE: `informasi`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `informasi`;
CREATE TABLE `informasi` (
  `idInformasi` int(11) NOT NULL AUTO_INCREMENT,
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
  `ddate` datetime DEFAULT NULL,
  PRIMARY KEY (`idInformasi`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;
INSERT INTO `informasi` VALUES   ('20','sadasd','dsadsad','2021-01-16 00:53:19','0','download.jpg','1','1','2021-01-16 00:53:19',NULL,NULL,'1','2021-01-16 02:05:50');
INSERT INTO `informasi` VALUES ('21','sadsad','dsadsad','2021-01-16 01:01:13','0','download.jpg','1','1','2021-01-16 01:01:13',NULL,NULL,'1','2021-01-16 15:44:24');
INSERT INTO `informasi` VALUES ('22','sdsad','sdsad','2021-01-16 01:03:23','0','download.jpg','1','1','2021-01-16 01:03:23',NULL,NULL,'1','2021-01-16 15:46:07');
INSERT INTO `informasi` VALUES ('23','sad','sdasd','2021-01-16 01:03:52','0','download.jpg','1','1','2021-01-16 01:03:52',NULL,NULL,'1','2021-01-16 15:46:10');
INSERT INTO `informasi` VALUES ('24','sadsa','sdads','2021-01-16 01:05:53','0','c81eecc8cf7ec0e85d6ace26c9fd7e79608ad2de.jpg','1','1','2021-01-16 01:05:53',NULL,NULL,'1','2021-01-16 15:48:56');
INSERT INTO `informasi` VALUES ('25','sadsad','sadsadsa','2021-01-16 01:08:08','0','Lambang_Kota_Palu.png','1','1','2021-01-16 01:08:08',NULL,NULL,'1','2021-01-16 15:50:34');
INSERT INTO `informasi` VALUES ('26','asds','<p>dsadsad</p>','2021-01-16 01:57:53','1','gambar setelah kirim berkas UKT.PNG','1','1','2021-01-16 01:27:58','1','2021-01-16 01:57:53','1','2021-01-16 15:51:17');
INSERT INTO `informasi` VALUES ('27','sadsadsad','<p>sadsad</p>','2021-01-16 01:57:44','1','Lambang_Kota_Palu.png','1','1','2021-01-16 01:29:40','1','2021-01-16 01:57:44','1','2021-01-16 15:51:56');
INSERT INTO `informasi` VALUES ('28','qqqqq','<p>PROSGGLLL</p>','2021-01-16 01:46:06','1','c81eecc8cf7ec0e85d6ace26c9fd7e79608ad2de.jpg','1','1','2021-01-16 01:30:56','1','2021-01-16 01:46:06','1','2021-01-16 16:06:31');
INSERT INTO `informasi` VALUES ('29','TESSSS','<p style=\"text-align: center;\">dksadsahkjdhasdh sdjhasjkd askdjhsajdh</p>','2021-01-16 02:25:13','1','3.PNG','1','1','2021-01-16 02:25:13',NULL,NULL,'1','2021-01-16 16:06:32');
INSERT INTO `informasi` VALUES ('30','1234','<p>1234</p>','2021-01-16 15:44:18','1','8f.PNG','1','1','2021-01-16 15:44:09','1','2021-01-16 15:44:18','1','2021-01-16 16:09:14');
INSERT INTO `informasi` VALUES ('31','asdsadsad','<p>asdsadasd</p>','2021-01-16 16:09:43','0','8e.PNG','1','1','2021-01-16 16:09:43',NULL,NULL,'1','2021-01-16 16:42:26');
INSERT INTO `informasi` VALUES ('32','333','<p>sdasdsad</p>','2021-01-16 16:16:59','0','8b.PNG','1','1','2021-01-16 16:16:59',NULL,NULL,'1','2021-01-16 16:57:18');
INSERT INTO `informasi` VALUES ('33','sadsad','<p>sadsad</p>','2021-01-16 16:58:00','0','6.PNG','1','1','2021-01-16 16:58:00',NULL,NULL,'1','2021-01-16 17:11:47');
INSERT INTO `informasi` VALUES ('34','sdsadsad','<p>asdsadsad</p>','2021-01-16 17:12:35','0','3.PNG','1','1','2021-01-16 17:12:03','1','2021-01-16 17:12:35','1','2021-01-16 17:12:40');
INSERT INTO `informasi` VALUES ('35','sadsad','<p>sssss</p>','2021-01-16 17:58:36','1','1.PNG','1','1','2021-01-16 17:57:22','1','2021-01-16 17:58:36','1','2021-01-16 17:59:12');
INSERT INTO `informasi` VALUES ('36','asdsad','<p>asdsadsad</p>','2021-01-16 18:01:21','1','7.PNG','1','1','2021-01-16 17:59:23','1','2021-01-16 18:01:21','1','2021-01-17 03:46:40');
INSERT INTO `informasi` VALUES ('37','ssss','','2021-01-16 18:20:59','0',NULL,'1','1','2021-01-16 18:20:59',NULL,NULL,'1','2021-01-17 03:46:43');
INSERT INTO `informasi` VALUES ('38','aaaa','<p>2211ddd</p>','2021-01-16 18:21:13','0',NULL,'1','1','2021-01-16 18:21:13',NULL,NULL,'1','2021-01-17 03:46:45');
INSERT INTO `informasi` VALUES ('39','sdsad','<p>sadsad</p>','2021-01-17 03:39:35','0',NULL,'0','1','2021-01-17 03:39:35',NULL,NULL,NULL,NULL);
INSERT INTO `informasi` VALUES ('40','sadsad','<p>asdsad</p>','2021-01-17 03:40:16','1','8 data.png','1','1','2021-01-17 03:40:16',NULL,NULL,'1','2021-01-17 03:46:49');
INSERT INTO `informasi` VALUES ('41','adsad','<p>asdsad</p>','2021-01-17 13:17:34','1','8 data.png','0','1','2021-01-17 03:41:03','1','2021-01-17 13:17:34',NULL,NULL);
INSERT INTO `informasi` VALUES ('42','asdsad','<p>sssss</p>','2021-01-17 03:42:25','1','8 data.png','0','1','2021-01-17 03:42:25',NULL,NULL,NULL,NULL);
INSERT INTO `informasi` VALUES ('43','dssdddd','<p>cccccc</p>','2021-01-17 22:12:26','1','10.PNG','0','1','2021-01-17 22:12:19','1','2021-01-17 22:12:26',NULL,NULL);
INSERT INTO `informasi` VALUES ('44','ZZZZ','<p>sdasad</p>','2021-01-19 01:12:24','0','64 data.PNG','1','1','2021-01-19 01:12:10','1','2021-01-19 01:12:24','1','2021-01-19 01:12:39');
INSERT INTO `informasi` VALUES ('45','dasdsadsa','<p>asdasdsadd</p>','2021-01-20 01:23:23','1','logo3.png','0','1','2021-01-20 01:23:23',NULL,NULL,NULL,NULL);
INSERT INTO `informasi` VALUES ('46','sadsadsa','<p>Sialhakan lunasi pembayaran sebelum</p>','2021-04-21 04:22:03','1','fc61b9a88394895a5ac72fbdbb7e4cbc.jpeg','0','1','2021-01-27 02:03:40','1','2021-04-21 04:22:03',NULL,NULL);

/*---------------------------------------------------------------
  TABLE: `izin_keluar`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `izin_keluar`;
CREATE TABLE `izin_keluar` (
  `idKeluar` int(11) NOT NULL AUTO_INCREMENT,
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
  `ddate` datetime DEFAULT NULL,
  PRIMARY KEY (`idKeluar`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
INSERT INTO `izin_keluar` VALUES   ('1','2021-02-16','3','3','01:25','18:45','iiiiii','1','1','2021-02-16 01:21:54',NULL,NULL,'1','2021-02-16 01:48:05');
INSERT INTO `izin_keluar` VALUES ('2','2021-02-16','1','3','08:00','13:55','OKE','0','1','2021-02-16 12:07:14',NULL,NULL,NULL,NULL);

/*---------------------------------------------------------------
  TABLE: `izin_pulang`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `izin_pulang`;
CREATE TABLE `izin_pulang` (
  `idPulang` int(11) NOT NULL AUTO_INCREMENT,
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
  `ddate` datetime DEFAULT NULL,
  PRIMARY KEY (`idPulang`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
INSERT INTO `izin_pulang` VALUES   ('1','2021-02-16','3','3','AGUS','1','','1','1','2021-02-16 01:20:00',NULL,NULL,'1','2021-02-16 01:46:11');
INSERT INTO `izin_pulang` VALUES ('2','2021-02-16','3','3','AGUS','3','2222','1','1','2021-02-16 01:21:13',NULL,NULL,'1','2021-02-16 01:46:21');
INSERT INTO `izin_pulang` VALUES ('3','2021-02-16','3','3','AGUS','2','asdsad','0','1','2021-02-16 03:30:52',NULL,NULL,NULL,NULL);
INSERT INTO `izin_pulang` VALUES ('4','2021-02-16','1','3','AGUS','5','2222','1','1','2021-02-16 03:39:03',NULL,NULL,'1','2021-02-16 03:47:51');

/*---------------------------------------------------------------
  TABLE: `jabatan_pegawai`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `jabatan_pegawai`;
CREATE TABLE `jabatan_pegawai` (
  `idJabatan` int(11) NOT NULL AUTO_INCREMENT,
  `kodeJabatan` varchar(100) DEFAULT NULL,
  `namaJabatan` varchar(255) DEFAULT NULL,
  `idUnit` int(11) DEFAULT NULL,
  `stdel` int(11) NOT NULL DEFAULT '0',
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL,
  PRIMARY KEY (`idJabatan`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
INSERT INTO `jabatan_pegawai` VALUES   ('1','KSSMP	','Kepala SMP','5','1','1','2021-01-17 22:26:44',NULL,NULL,'1','2021-01-19 15:42:59');
INSERT INTO `jabatan_pegawai` VALUES ('2','123','ddddd','5','0','1','2021-01-17 22:30:47','1','2021-01-17 22:34:50',NULL,NULL);
INSERT INTO `jabatan_pegawai` VALUES ('3','sdsadsad','sadsadsad','1','0','1','2021-01-19 00:23:23','1','2021-01-19 00:24:48',NULL,NULL);
INSERT INTO `jabatan_pegawai` VALUES ('6','KSSMP	','111111','5','0','1','2021-01-21 02:11:15',NULL,NULL,NULL,NULL);

/*---------------------------------------------------------------
  TABLE: `jenis_bayar`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `jenis_bayar`;
CREATE TABLE `jenis_bayar` (
  `idJenisBayar` int(10) NOT NULL AUTO_INCREMENT,
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
  `ddate` datetime DEFAULT NULL,
  PRIMARY KEY (`idJenisBayar`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
INSERT INTO `jenis_bayar` VALUES   ('1','1','3','3','Bulanan','0','1','2021-04-09 01:59:38',NULL,NULL,NULL,NULL);
INSERT INTO `jenis_bayar` VALUES ('2','1','8','3','Bebas','0','1','2021-04-09 13:30:42','1','2021-04-14 13:42:55',NULL,NULL);

/*---------------------------------------------------------------
  TABLE: `jurnal_umum`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `jurnal_umum`;
CREATE TABLE `jurnal_umum` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `tgl` date DEFAULT NULL,
  `ket` varchar(100) DEFAULT NULL,
  `penerimaan` int(10) DEFAULT '0',
  `pengeluaran` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
INSERT INTO `jurnal_umum` VALUES   ('1','2020-01-15','transport','1000000','100000');
INSERT INTO `jurnal_umum` VALUES ('2','2020-01-15','MAKAN SIANG','100000','50000');
INSERT INTO `jurnal_umum` VALUES ('3','2020-01-15','UAS','20000','0');
INSERT INTO `jurnal_umum` VALUES ('4','2020-01-15','MIS','0','0');
INSERT INTO `jurnal_umum` VALUES ('5','2020-01-25','Transport ke Surabaya','1','200000');
INSERT INTO `jurnal_umum` VALUES ('6','2020-03-06','Bos','14000000','0');
INSERT INTO `jurnal_umum` VALUES ('8','2020-03-11','bayar fotocopy man','0','1000000');
INSERT INTO `jurnal_umum` VALUES ('9','2020-03-11','Saldo Awal','12000000','0');
INSERT INTO `jurnal_umum` VALUES ('10','2020-04-06','Coba Aja','10000','20000');
INSERT INTO `jurnal_umum` VALUES ('11','2020-06-18','pembelian buku','0','250000');

/*---------------------------------------------------------------
  TABLE: `kamar`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `kamar`;
CREATE TABLE `kamar` (
  `idKamar` int(11) NOT NULL AUTO_INCREMENT,
  `namaKamar` varchar(255) NOT NULL,
  `stdel` int(11) NOT NULL DEFAULT '0',
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL,
  PRIMARY KEY (`idKamar`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
INSERT INTO `kamar` VALUES   ('1','CCC','0','1','2021-01-17 21:55:34','1','2021-01-17 22:00:10',NULL,NULL);
INSERT INTO `kamar` VALUES ('2','VVVV','1','1','2021-01-17 21:55:34',NULL,NULL,'1','2021-01-17 21:56:08');
INSERT INTO `kamar` VALUES ('3','sdadsad','0','1','2021-01-17 22:00:24',NULL,NULL,NULL,NULL);
INSERT INTO `kamar` VALUES ('4','qwerty','1','1','2021-01-17 22:00:24','1','2021-01-17 22:00:32','1','2021-01-17 22:00:36');
INSERT INTO `kamar` VALUES ('5','333332345678','1','1','2021-01-19 00:03:26','1','2021-01-19 00:03:34','1','2021-01-19 00:03:51');
INSERT INTO `kamar` VALUES ('6','sadsasad','1','1','2021-01-19 00:03:26',NULL,NULL,'1','2021-01-19 00:03:38');
INSERT INTO `kamar` VALUES ('7','EEEEEE','1','1','2021-01-19 01:52:22','1','2021-01-19 01:52:30','1','2021-01-19 01:52:40');
INSERT INTO `kamar` VALUES ('8','DDDD','1','1','2021-01-19 01:52:22','1','2021-01-19 01:52:36','1','2021-01-19 01:52:51');

/*---------------------------------------------------------------
  TABLE: `kas`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `kas`;
CREATE TABLE `kas` (
  `idKas` int(11) NOT NULL AUTO_INCREMENT,
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
  `ddate` datetime DEFAULT NULL,
  PRIMARY KEY (`idKas`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;
INSERT INTO `kas` VALUES   ('1','Masuk','Transfer','2021-04-16','1','25','JKTahfidz1604210001','75','75',NULL,'3','Terima Tagihan bebas midtransi','',NULL,NULL,NULL,'300000','0','1','2021-04-16 01:14:28',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('2','Masuk','Transfer','2021-04-16','1','25','JKTahfidz1604210002','75','75',NULL,'3','Terima Tagihan bulan midtrans','',NULL,NULL,NULL,'100000','0','1','2021-04-16 01:53:36',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('3','Masuk','Transfer','2021-04-16','1','25','JKTahfidz1604210003','75','75',NULL,'3','Terima Tagihan bulan midtrans','',NULL,NULL,NULL,'150000','0','1','2021-04-16 01:56:37',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('4','Masuk','Transfer','2021-04-17','1','25','JKTahfidz1704210001','75','75',NULL,'3','Terima Tagihan bulan midtrans','',NULL,NULL,NULL,'55000','0','1','2021-04-17 03:37:14',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('5','Masuk','Transfer','2021-04-17','1','25','JKTahfidz1704210002','75','75',NULL,'3','Terima Tagihan bulan midtrans','',NULL,NULL,NULL,'55000','0','1','2021-04-17 03:37:55',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('6','Masuk','Transfer','2021-04-17','1','25','JKTahfidz1704210003','75','75',NULL,'3','Terima Tagihan bulan midtrans','',NULL,NULL,NULL,'55000','0','1','2021-04-17 04:27:12',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('7','Masuk','Transfer','2021-04-17','1','25','JKTahfidz1704210004','75','75',NULL,'3','Terima Tagihan bulan midtrans','',NULL,NULL,NULL,'55000','0','1','2021-04-17 04:34:20',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('8','Masuk','Transfer','2021-04-17','1','25','JKTahfidz1704210005','75','75',NULL,'3','Terima Tagihan bulan midtrans','',NULL,NULL,NULL,'55000','0','1','2021-04-17 04:35:57',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('9','Masuk','Transfer','2021-04-17','1','25','JKTahfidz1704210006','75','75',NULL,'3','Terima Tagihan bulan midtrans','',NULL,NULL,NULL,'50000','0','1','2021-04-17 04:36:22',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('10','Masuk','Transfer','2021-04-17','1','25','JKTahfidz1704210007','75','75',NULL,'3','Terima Tagihan bulan midtrans','',NULL,NULL,NULL,'50000','0','1','2021-04-17 04:37:39',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('11','Masuk','Transfer','2021-04-17','1','25','JKTahfidz1704210008','75','75',NULL,'3','Terima Tagihan bulan midtrans','',NULL,NULL,NULL,'50000','0','1','2021-04-17 04:45:03',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('12','Masuk','Transfer','2021-04-17','1','25','JKTahfidz1704210009','75','75',NULL,'3','Terima Tagihan bulan midtrans','',NULL,NULL,NULL,'50000','0','1','2021-04-17 04:59:27',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('13','Masuk','Transfer','2021-04-17','1','25','JKTahfidz1704210010','75','75',NULL,'3','Terima Tagihan bulan midtrans','',NULL,NULL,NULL,'50000','0','1','2021-04-17 05:01:27',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('14','Masuk','Transfer','2021-04-17','1','25','JKTahfidz1704210011','75','75',NULL,'3','Terima Tagihan bulan midtrans','',NULL,NULL,NULL,'50000','0','1','2021-04-17 05:03:43',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('15','Masuk','Transfer','2021-04-17','1','25','JKTahfidz1704210012','75','75',NULL,'3','Terima Tagihan bulan midtrans','',NULL,NULL,NULL,'50000','0','1','2021-04-17 05:07:49',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('16','Masuk','Transfer','2021-04-17','1','25','JKTahfidz1704210013','75','75',NULL,'3','Terima Tagihan bulan midtrans','',NULL,NULL,NULL,'50000','0','1','2021-04-17 05:10:35',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('17','Masuk','Transfer','2021-04-17','1','25','JKTahfidz1704210014','75','75',NULL,'3','Terima Tagihan bulan midtrans','',NULL,NULL,NULL,'50000','0','1','2021-04-17 05:12:17',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('18','Masuk','Transfer','2021-04-17','1','25','JKTahfidz1704210015','75','75',NULL,'3','Terima Tagihan bulan midtrans','',NULL,NULL,NULL,'55000','0','1','2021-04-17 05:15:01',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('19','Masuk','Transfer','2021-04-17','1','38','JKTahfidz1704210016','75','75',NULL,'3','Terima Tagihan bulan midtrans','',NULL,NULL,NULL,'200000','0','1','2021-04-17 15:21:23',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('20','Masuk','Transfer','2021-04-17','1','38','JKTahfidz1704210017','75','75',NULL,'3','Terima Tagihan bulan midtrans','',NULL,NULL,NULL,'200000','0','1','2021-04-17 15:22:58',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('21','Masuk','Transfer','2021-04-17','1','38','JKTahfidz1704210018','75','75',NULL,'3','Terima Tagihan bulan midtrans','',NULL,NULL,NULL,'200000','0','1','2021-04-17 15:28:41',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('22','Masuk','Transfer','2021-04-17','1','38','JKTahfidz1704210019','75','75',NULL,'3','Terima Tagihan bebas midtransi','',NULL,NULL,NULL,'100000','0','1','2021-04-17 15:33:19',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('23','Masuk','Transfer','2021-04-17','1','38','JKTahfidz1704210020','75','75',NULL,'3','Terima Tagihan bebas midtransi','',NULL,NULL,NULL,'100000','0','1','2021-04-17 15:34:57',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('24','Masuk','Transfer','2021-04-17','1','38','JKTahfidz1704210021','75','75',NULL,'3','Terima Tagihan bebas midtransi','',NULL,NULL,NULL,'100000','0','1','2021-04-17 15:40:51',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('25','Masuk','Transfer','2021-04-17','1','38','JKTahfidz1704210022','75','75',NULL,'3','Terima Tagihan bulan midtrans','',NULL,NULL,NULL,'200000','0','1','2021-04-17 15:42:20',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('26','Masuk','Transfer','2021-04-17','1','38','JKTahfidz1704210023','75','75',NULL,'3','Terima Tagihan bebas midtransi','',NULL,NULL,NULL,'100000','0','1','2021-04-17 15:52:39',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('27','Masuk','Transfer','2021-04-17','1','38','JKTahfidz1704210024','75','75',NULL,'3','Terima Tagihan bulan midtrans','',NULL,NULL,NULL,'200000','0','1','2021-04-17 16:10:12',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('28','Masuk','Transfer','2021-04-17','1','38','JKTahfidz1704210025','75','75',NULL,'3','Terima Tagihan bulan midtrans','',NULL,NULL,NULL,'200000','0','1','2021-04-17 16:18:21',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('29','Masuk','Transfer','2021-04-17','1','38','JKTahfidz1704210026','75','75',NULL,'3','Terima Tagihan bulan midtrans','',NULL,NULL,NULL,'200000','0','1','2021-04-17 16:19:15',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('30','Masuk','Transfer','2021-04-17','1','38','JKTahfidz1704210027','75','75',NULL,'3','Terima Tagihan bulan midtrans','',NULL,NULL,NULL,'200000','0','1','2021-04-17 16:26:35',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('31','Masuk','Transfer','2021-04-17','1','38','JKTahfidz1704210028','75','75',NULL,'3','Terima Tagihan bulan midtrans','',NULL,NULL,NULL,'200000','0','1','2021-04-17 16:37:50',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('32','Masuk','Transfer','2021-04-17','1','38','JKTahfidz1704210029','75','75',NULL,'3','Terima Tagihan bebas midtransi','',NULL,NULL,NULL,'100000','0','1','2021-04-17 16:41:57',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('33','Masuk','Transfer','2021-04-17','1','38','JKTahfidz1704210030','75','75',NULL,'3','Terima Tagihan bulan midtrans','',NULL,NULL,NULL,'200000','0','1','2021-04-17 17:03:40',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('34','Masuk','Transfer','2021-04-17','1','38','JKTahfidz1704210031','75','75',NULL,'3','Terima Tagihan bulan midtrans','',NULL,NULL,NULL,'200000','0','1','2021-04-17 17:45:39',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('35','Masuk','Transfer','2021-04-17','1','38','JKTahfidz1704210032','75','75',NULL,'3','Terima Tagihan bebas midtransi','',NULL,NULL,NULL,'100000','0','1','2021-04-17 17:54:49',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('36','Masuk','Transfer','2021-04-17','1','38','JKTahfidz1704210033','75','75',NULL,'3','Terima Tagihan bulan midtrans','',NULL,NULL,NULL,'200000','0','1','2021-04-17 18:30:45',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('37','Masuk','Transfer','2021-04-18','1','38','JKTahfidz1804210001','75','75',NULL,'3','Terima Tagihan bulan midtrans','',NULL,NULL,NULL,'400000','0','1','2021-04-18 11:10:35',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('38','Masuk','Transfer','2021-04-18','1','38','JKTahfidz1804210002','75','75',NULL,'3','Terima Tagihan bulan midtrans','',NULL,NULL,NULL,'400000','0','1','2021-04-18 11:11:13',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('39','Masuk','Transfer','2021-04-18','1','38','JKTahfidz1804210003','75','75',NULL,'3','Terima Tagihan bulan midtrans','',NULL,NULL,NULL,'400000','0','1','2021-04-18 11:17:37',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('40','Masuk','Transfer','2021-04-21','1','38','JKTahfidz2104210001','75','75',NULL,'3','Terima Tagihan bulan midtrans','',NULL,NULL,NULL,'600000','0','1','2021-04-21 11:30:33',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('41','Masuk','Transfer','2021-04-21','1','38','JKTahfidz2104210002','75','75',NULL,'3','Terima Tagihan bulan midtrans','',NULL,NULL,NULL,'600000','0','1','2021-04-21 11:32:43',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('42','Masuk','Transfer','2021-04-21','1','38','JKTahfidz2104210003','75','75',NULL,'3','Terima Tagihan bulan midtrans','',NULL,NULL,NULL,'600000','0','1','2021-04-21 11:36:49',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('43','Masuk','Transfer','2021-04-21','1','38','JKTahfidz2104210004','75','75',NULL,'3','Terima Tagihan bulan midtrans','',NULL,NULL,NULL,'600000','0','1','2021-04-21 11:50:24',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('44','Masuk','Transfer','2021-04-21','1','38','JKTahfidz2104210005','75','75',NULL,'3','Terima Tagihan bulan midtrans','',NULL,NULL,NULL,'600000','0','1','2021-04-21 12:30:12',NULL,NULL,NULL,NULL);
INSERT INTO `kas` VALUES ('45','Masuk','Transfer','2021-04-21','1','38','JKTahfidz2104210006','75','75',NULL,'3','Terima Tagihan bulan midtrans','',NULL,NULL,NULL,'600000','0','1','2021-04-21 13:55:57',NULL,NULL,NULL,NULL);

/*---------------------------------------------------------------
  TABLE: `kas_transaksi`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `kas_transaksi`;
CREATE TABLE `kas_transaksi` (
  `idTransaksiKas` int(11) NOT NULL AUTO_INCREMENT,
  `idUsers` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `noRefrensi` varchar(100) NOT NULL,
  `idAkunBiaya` int(11) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `nominal` double NOT NULL,
  `idPajak` int(11) NOT NULL,
  `idUnitPos` int(11) NOT NULL,
  PRIMARY KEY (`idTransaksiKas`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;
INSERT INTO `kas_transaksi` VALUES   ('12','1','2021-02-08','JKSMP-TMI0802210001  ','54','2222','50000','2','0');
INSERT INTO `kas_transaksi` VALUES ('13','1','2021-02-08','JKTahfidz0802210001  ','64','5','50000','2','0');
INSERT INTO `kas_transaksi` VALUES ('14','1','2021-02-08','JKTahfidz0802210002  ','64','ww','1000000','1','0');
INSERT INTO `kas_transaksi` VALUES ('15','1','2021-02-08','JKTahfidz0802210003  ','64','uuu','50000','2','0');
INSERT INTO `kas_transaksi` VALUES ('16','1','2021-02-08','JKTahfidz0802210003  ','65','11222','50000','2','0');
INSERT INTO `kas_transaksi` VALUES ('17','1','2021-02-08','JKTahfidz0802210004  ','64','ATK TINTA','10000','1','0');

/*---------------------------------------------------------------
  TABLE: `kelas_siswa`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `kelas_siswa`;
CREATE TABLE `kelas_siswa` (
  `idKelas` int(5) NOT NULL AUTO_INCREMENT,
  `nmKelas` varchar(20) DEFAULT NULL,
  `idUnit` int(11) DEFAULT NULL,
  `stdel` int(11) DEFAULT '0',
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL,
  PRIMARY KEY (`idKelas`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;
INSERT INTO `kelas_siswa` VALUES   ('2','XI TKJ','1','0',NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `kelas_siswa` VALUES ('3','X APH','1','0',NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `kelas_siswa` VALUES ('4','X TKJ','1','0',NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `kelas_siswa` VALUES ('6','XI OTKP','1','0',NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `kelas_siswa` VALUES ('7','XI APH','1','0',NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `kelas_siswa` VALUES ('8','XII APH','2','0',NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `kelas_siswa` VALUES ('9','X RPL','2','0',NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `kelas_siswa` VALUES ('10','IX A','2','0',NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `kelas_siswa` VALUES ('11','sdadsad','1','1',NULL,NULL,NULL,NULL,'1','2021-01-17 20:45:58');
INSERT INTO `kelas_siswa` VALUES ('12','sssss','1','0',NULL,NULL,'1','2021-01-19 00:01:18',NULL,NULL);
INSERT INTO `kelas_siswa` VALUES ('13','BAAAA','6','1',NULL,NULL,'1','2021-01-17 20:54:39','1','2021-01-17 20:55:07');
INSERT INTO `kelas_siswa` VALUES ('14','1','1','0',NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `kelas_siswa` VALUES ('15','2','1','0',NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `kelas_siswa` VALUES ('16','3','1','0',NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `kelas_siswa` VALUES ('17','','0','1',NULL,NULL,'1','2021-01-28 19:54:43','1','2021-01-17 20:54:55');
INSERT INTO `kelas_siswa` VALUES ('18','AC','5','1','1','2021-01-17 20:43:47',NULL,NULL,'1','2021-01-17 20:45:16');
INSERT INTO `kelas_siswa` VALUES ('19','AB','5','1','1','2021-01-17 20:43:47',NULL,NULL,'1','2021-01-17 20:45:10');
INSERT INTO `kelas_siswa` VALUES ('20','QEWERER','6','1','1','2021-01-17 20:55:21','1','2021-01-17 20:55:36','1','2021-01-17 20:55:46');
INSERT INTO `kelas_siswa` VALUES ('21','ssss','5','0','1','2021-01-18 23:55:39',NULL,NULL,NULL,NULL);
INSERT INTO `kelas_siswa` VALUES ('22','dddd','5','0','1','2021-01-18 23:55:39',NULL,NULL,NULL,NULL);
INSERT INTO `kelas_siswa` VALUES ('23','dsadsd','5','0','1','2021-01-19 00:00:58',NULL,NULL,NULL,NULL);
INSERT INTO `kelas_siswa` VALUES ('24','asdasd','5','1','1','2021-01-19 00:00:58',NULL,NULL,'1','2021-01-19 00:01:28');
INSERT INTO `kelas_siswa` VALUES ('25','asdsads','6','0','1','2021-01-19 01:38:26','1','2021-01-19 01:38:34',NULL,NULL);
INSERT INTO `kelas_siswa` VALUES ('26','xxxxx','6','1','1','2021-01-19 01:38:26','1','2021-01-19 01:38:43','1','2021-01-20 00:24:04');

/*---------------------------------------------------------------
  TABLE: `kwitansi`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `kwitansi`;
CREATE TABLE `kwitansi` (
  `id_kwitansi` varchar(30) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `tgl_cetak` datetime NOT NULL,
  PRIMARY KEY (`id_kwitansi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO `kwitansi` VALUES   ('00000001kwt','299','2020-08-18 11:30:43');
INSERT INTO `kwitansi` VALUES ('00000002kwt','299','2020-08-18 11:31:09');
INSERT INTO `kwitansi` VALUES ('00000003kwt','299','2020-08-18 11:31:53');
INSERT INTO `kwitansi` VALUES ('00000004kwt','299','2020-08-19 09:52:29');
INSERT INTO `kwitansi` VALUES ('00000005kwt','299','2020-08-19 09:53:23');
INSERT INTO `kwitansi` VALUES ('00000006kwt','299','2020-08-19 09:57:27');
INSERT INTO `kwitansi` VALUES ('00000007kwt','299','2020-08-19 09:57:48');
INSERT INTO `kwitansi` VALUES ('00000008kwt','299','2020-08-19 10:01:16');
INSERT INTO `kwitansi` VALUES ('KWT00000001','299','2020-08-19 10:15:32');
INSERT INTO `kwitansi` VALUES ('KWT00000009','299','2020-08-19 10:09:41');

/*---------------------------------------------------------------
  TABLE: `log_kasir`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `log_kasir`;
CREATE TABLE `log_kasir` (
  `idTransaksi` int(11) NOT NULL AUTO_INCREMENT,
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
  `ip_address` varchar(40) NOT NULL,
  PRIMARY KEY (`idTransaksi`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4;
INSERT INTO `log_kasir` VALUES   ('1','2021-02-22 22:22:37','Bulanan','73','Pembayaran','Bayar',NULL,'201706001','Bayar-SPP Tahfidz 2020/2021 bulan Juli','10000','1','Chrome 88.0.4324.182','Windows 8.1','::1');
INSERT INTO `log_kasir` VALUES ('2','2021-02-22 22:27:17','Bebas','38','Pembayaran','Bayar',NULL,'201755667','Pelunasan Tunggakan SPP - T.A 2019/2020','50000','1','Chrome 88.0.4324.182','Windows 8.1','::1');
INSERT INTO `log_kasir` VALUES ('3','2021-02-22 22:27:46','Bebas','38','Pembayaran','Hapus',NULL,'201755667','Hapus Pelunasan Tunggakan SPP - T.A 2019/2020','50000','1','Chrome 88.0.4324.182','Windows 8.1','::1');
INSERT INTO `log_kasir` VALUES ('4','2021-02-22 22:39:25','Gaji','27','Penggajian','Bayar',NULL,'201806001','Input Gaji Bulanan Juli 2019/2020','5100000','1','Chrome 88.0.4324.182','Windows 8.1','::1');
INSERT INTO `log_kasir` VALUES ('5','2021-02-22 22:43:34','Gaji','27','Penggajian','Hapus',NULL,'201806001','Hapus Gaji Bulan Juli 2019/2020','5100000','1','Chrome 88.0.4324.182','Windows 8.1','::1');
INSERT INTO `log_kasir` VALUES ('12','2021-02-23 02:29:06','Kas','64','Kas Masuk','Simpan Transaksi','JMTahfidz2302210003  ',NULL,'Input DONATUR A','2000000','1','Chrome 88.0.4324.182','Windows 8.1','::1');
INSERT INTO `log_kasir` VALUES ('13','2021-02-23 02:31:28','Kas','64','Kas Masuk','Hapus Transaksi','JMTahfidz2302210003  ',NULL,'Hapus DONATUR A','2000000','1','Chrome 88.0.4324.182','Windows 8.1','::1');
INSERT INTO `log_kasir` VALUES ('14','2021-02-23 02:50:08','Kas','65','Kas Keluar','Simpan Transaksi','JKSMP-TMI2302210001  ',NULL,'Input SPIDOL A','100000','1','Chrome 88.0.4324.182','Windows 8.1','::1');
INSERT INTO `log_kasir` VALUES ('15','2021-02-23 11:19:24','Kas','66','Kas Masuk','Simpan Transaksi','JMTahfidz2302210003  ',NULL,'Input DONATUR OO','5000000','1','Chrome 88.0.4324.182','Windows 8.1','::1');
INSERT INTO `log_kasir` VALUES ('19','2021-02-23 17:56:58','Bulanan','145','Pembayaran','Bayar','SPSMP-TMI20178877823022102','201788778','Bayar-SPP SMP 2019/2020 bulan Juli','120000','15','Chrome 88.0.4324.182','Windows 8.1','::1');
INSERT INTO `log_kasir` VALUES ('20','2021-02-24 14:19:53','Bebas','38','Pembayaran','Bayar','','201755667','Pelunasan Tunggakan SPP - T.A 2019/2020','90000','1','Chrome 88.0.4324.182','Windows 8.1','::1');
INSERT INTO `log_kasir` VALUES ('21','2021-04-04 21:33:01','Bebas','39','Pembayaran','Bayar','','201755667','Pelunasan DU Santri Baru - T.A 2019/2020','500000','1','Handheld ','Android','36.84.189.214');
INSERT INTO `log_kasir` VALUES ('22','2021-04-09 13:31:44','Bebas','1','Pembayaran','Bayar','','201755667','Pelunasan SPP Tahfidz - T.A 2019/2020','100000','1','Chrome 89.0.4389.114','Windows 10','36.74.1.18');
INSERT INTO `log_kasir` VALUES ('23','2021-04-09 13:34:31','Bebas','1','Pembayaran','Bayar','','201755667','Pelunasan SPP Tahfidz - T.A 2019/2020','50000','1','Chrome 89.0.4389.114','Windows 10','36.79.51.153');
INSERT INTO `log_kasir` VALUES ('24','2021-04-09 19:14:58','Bebas','1','Pembayaran','Bayar','','201755667','Pelunasan SPP Tahfidz - T.A 2019/2020','50000','1','Chrome 89.0.4389.114','Windows 10','36.80.184.63');
INSERT INTO `log_kasir` VALUES ('25','2021-04-09 19:40:54','Bebas','1','Pembayaran','Bayar','','201755667','Pelunasan SPP Tahfidz - T.A 2019/2020','200000','1','Chrome 89.0.4389.114','Windows 10','36.80.184.63');
INSERT INTO `log_kasir` VALUES ('26','2021-04-09 19:43:58','Bebas','1','Pembayaran','Bayar','','201755667','Pelunasan SPP Tahfidz - T.A 2019/2020','125000','1','Chrome 89.0.4389.114','Windows 10','36.80.184.63');
INSERT INTO `log_kasir` VALUES ('27','2021-04-09 19:44:21','Bebas','1','Pembayaran','Bayar','','201755667','Pelunasan SPP Tahfidz - T.A 2019/2020','100000','1','Chrome 89.0.4389.114','Windows 10','36.80.184.63');
INSERT INTO `log_kasir` VALUES ('28','2021-04-09 21:59:26','Bebas','1','Pembayaran','Bayar','','201755667','Pelunasan SPP Tahfidz - T.A 2019/2020','100000','1','Chrome 89.0.4389.114','Windows 10','36.80.184.63');
INSERT INTO `log_kasir` VALUES ('29','2021-04-10 23:52:27','Bulanan','4','Pembayaran','Bayar','SPTahfidz20175566710042105','201755667','Bayar-SPP Tahfidz 2019/2020 bulan Oktober','55000','1','Chrome 89.0.4389.114','Windows 10','36.73.237.91');
INSERT INTO `log_kasir` VALUES ('30','2021-04-10 23:55:49','Bulanan','4','Pembayaran','Bayar','SPTahfidz20175566710042105','201755667','Bayar-SPP Tahfidz 2019/2020 bulan Oktober','55000','1','Chrome 89.0.4389.114','Windows 10','36.74.1.18');
INSERT INTO `log_kasir` VALUES ('31','2021-04-10 23:56:53','Bulanan','4','Pembayaran','Bayar','SPTahfidz20175566710042105','201755667','Bayar-SPP Tahfidz 2019/2020 bulan Oktober','55000','1','Chrome 89.0.4389.114','Windows 10','180.247.234.200');
INSERT INTO `log_kasir` VALUES ('32','2021-04-10 23:59:46','Bebas','1','Pembayaran','Bayar','','201755667','Pelunasan SPP Tahfidz - T.A 2019/2020','100000','1','Chrome 89.0.4389.114','Windows 10','36.81.248.87');
INSERT INTO `log_kasir` VALUES ('33','2021-04-11 00:00:17','Bulanan','13','Pembayaran','Bayar','SPTahfidz11223311042101','112233','Bayar-SPP Tahfidz 2019/2020 bulan Juli','400000','1','Chrome 89.0.4389.114','Windows 10','36.74.1.18');
INSERT INTO `log_kasir` VALUES ('34','2021-04-11 00:06:53','Bebas','2','Pembayaran','Bayar','','112233','Pelunasan SPP Tahfidz - T.A 2019/2020','100000','1','Chrome 89.0.4389.114','Windows 10','180.247.234.200');
INSERT INTO `log_kasir` VALUES ('35','2021-04-11 00:09:37','Bulanan','13','Pembayaran','Bayar','SPTahfidz11223311042103','112233','Bayar-SPP Tahfidz 2019/2020 bulan Juli','400000','1','Chrome 89.0.4389.114','Windows 10','36.73.237.91');
INSERT INTO `log_kasir` VALUES ('36','2021-04-11 00:10:39','Bulanan','13','Pembayaran','Bayar','SPTahfidz11223311042104','112233','Bayar-SPP Tahfidz 2019/2020 bulan Juli','400000','1','Chrome 89.0.4389.114','Windows 10','36.74.1.18');
INSERT INTO `log_kasir` VALUES ('37','2021-04-11 08:38:16','Bulanan','19','Pembayaran','Bayar','SPTahfidz11223311042105','112233','Bayar-SPP Tahfidz 2019/2020 bulan Januari','400000','1','Chrome 89.0.4389.114','Windows 10','36.81.248.87');
INSERT INTO `log_kasir` VALUES ('38','2021-04-14 13:32:24','Bulanan','19','Pembayaran','Bayar','SPTahfidz11223314042106','112233','Bayar-SPP Tahfidz 2019/2020 bulan Januari','400000','1','Chrome 89.0.4389.114','Windows 10','180.253.83.137');
INSERT INTO `log_kasir` VALUES ('39','2021-04-14 13:35:27','Bulanan','14','Pembayaran','Hapus','SPTahfidz11223314042107','112233','Hapus Bayar-SPP Tahfidz 2019/2020 bulan Agustus','400000','1','Chrome 89.0.4389.114','Windows 10','180.253.83.137');
INSERT INTO `log_kasir` VALUES ('40','2021-04-14 13:35:31','Bulanan','15','Pembayaran','Hapus','SPTahfidz11223314042107','112233','Hapus Bayar-SPP Tahfidz 2019/2020 bulan September','400000','1','Chrome 89.0.4389.114','Windows 10','36.74.1.18');
INSERT INTO `log_kasir` VALUES ('41','2021-04-14 13:35:34','Bulanan','16','Pembayaran','Hapus','SPTahfidz11223314042107','112233','Hapus Bayar-SPP Tahfidz 2019/2020 bulan Oktober','400000','1','Chrome 89.0.4389.114','Windows 10','125.167.68.235');
INSERT INTO `log_kasir` VALUES ('42','2021-04-14 13:35:38','Bulanan','17','Pembayaran','Hapus','SPTahfidz11223314042107','112233','Hapus Bayar-SPP Tahfidz 2019/2020 bulan November','400000','1','Chrome 89.0.4389.114','Windows 10','36.73.237.91');
INSERT INTO `log_kasir` VALUES ('43','2021-04-14 13:35:43','Bulanan','18','Pembayaran','Hapus','SPTahfidz11223314042107','112233','Hapus Bayar-SPP Tahfidz 2019/2020 bulan Desember','400000','1','Chrome 89.0.4389.114','Windows 10','125.167.68.235');
INSERT INTO `log_kasir` VALUES ('44','2021-04-14 13:35:47','Bulanan','20','Pembayaran','Hapus','SPTahfidz11223314042107','112233','Hapus Bayar-SPP Tahfidz 2019/2020 bulan Februari','400000','1','Chrome 89.0.4389.114','Windows 10','180.247.234.200');
INSERT INTO `log_kasir` VALUES ('45','2021-04-14 13:38:48','Bulanan','13','Pembayaran','Bayar','SPTahfidz11223314042107','112233','Bayar-SPP Tahfidz 2019/2020 bulan Juli','400000','1','Chrome 89.0.4389.114','Windows 10','180.253.83.137');
INSERT INTO `log_kasir` VALUES ('46','2021-04-14 13:39:14','Bebas','2','Pembayaran','Hapus','','112233','Hapus Pelunasan SPP Tahfidz - T.A 2019/2020','100000','1','Chrome 89.0.4389.114','Windows 10','180.247.234.200');
INSERT INTO `log_kasir` VALUES ('47','2021-04-14 13:39:17','Bebas','2','Pembayaran','Hapus','','112233','Hapus Pelunasan SPP Tahfidz - T.A 2019/2020','100000','1','Chrome 89.0.4389.114','Windows 10','180.247.234.200');
INSERT INTO `log_kasir` VALUES ('48','2021-04-14 13:40:38','Bulanan','13','Pembayaran','Bayar','SPTahfidz11223314042108','112233','Bayar-SPP Tahfidz 2019/2020 bulan Juli','400000','1','Chrome 89.0.4389.114','Windows 10','180.247.234.200');
INSERT INTO `log_kasir` VALUES ('49','2021-04-14 13:40:38','Bulanan','13','Pembayaran','Bayar','SPTahfidz11223314042108','112233','Bayar-SPP Tahfidz 2019/2020 bulan Juli','400000','1','Chrome 89.0.4389.114','Windows 10','36.73.237.91');
INSERT INTO `log_kasir` VALUES ('50','2021-04-14 13:40:51','Bulanan','13','Pembayaran','Bayar','SPTahfidz11223314042108','112233','Bayar-SPP Tahfidz 2019/2020 bulan Juli','400000','1','Chrome 89.0.4389.114','Windows 10','125.167.68.235');
INSERT INTO `log_kasir` VALUES ('51','2021-04-14 13:46:34','Bulanan','25','Pembayaran','Bayar','SPTahfidz11122233314042101','111222333','Bayar-SPP Tahfidz 2019/2020 bulan Juli','50000','1','Chrome 89.0.4389.114','Windows 10','180.247.234.200');
INSERT INTO `log_kasir` VALUES ('52','2021-04-14 13:46:39','Bulanan','26','Pembayaran','Bayar','SPTahfidz11122233314042101','111222333','Bayar-SPP Tahfidz 2019/2020 bulan Agustus','50000','1','Chrome 89.0.4389.114','Windows 10','36.74.1.18');
INSERT INTO `log_kasir` VALUES ('53','2021-04-15 10:03:37','Bulanan','13','Pembayaran','Bayar','SPTahfidz11223315042110','112233','Bayar-SPP Tahfidz 2019/2020 bulan Juli','400000','1','Chrome 89.0.4389.114','Windows 7','36.79.206.61');
INSERT INTO `log_kasir` VALUES ('54','2021-04-15 10:04:06','Bulanan','16','Pembayaran','Hapus','SPTahfidz11223315042110','112233','Hapus Bayar-SPP Tahfidz 2019/2020 bulan Oktober','400000','1','Chrome 89.0.4389.114','Windows 7','36.79.206.61');
INSERT INTO `log_kasir` VALUES ('55','2021-04-15 10:04:10','Bulanan','15','Pembayaran','Hapus','SPTahfidz11223315042110','112233','Hapus Bayar-SPP Tahfidz 2019/2020 bulan September','400000','1','Chrome 89.0.4389.114','Windows 7','36.79.206.61');
INSERT INTO `log_kasir` VALUES ('56','2021-04-15 10:04:14','Bulanan','14','Pembayaran','Hapus','SPTahfidz11223315042110','112233','Hapus Bayar-SPP Tahfidz 2019/2020 bulan Agustus','400000','1','Chrome 89.0.4389.114','Windows 7','36.79.206.61');
INSERT INTO `log_kasir` VALUES ('57','2021-04-15 10:05:56','Bulanan','13','Pembayaran','Bayar','SPTahfidz11223315042110','112233','Bayar-SPP Tahfidz 2019/2020 bulan Juli','400000','1','Chrome 89.0.4389.114','Windows 7','36.79.206.61');
INSERT INTO `log_kasir` VALUES ('58','2021-04-15 10:06:08','Bulanan','13','Pembayaran','Bayar','SPTahfidz11223315042110','112233','Bayar-SPP Tahfidz 2019/2020 bulan Juli','400000','1','Chrome 89.0.4389.114','Windows 7','36.79.206.61');
INSERT INTO `log_kasir` VALUES ('59','2021-04-15 10:06:08','Bulanan','13','Pembayaran','Bayar','SPTahfidz11223315042110','112233','Bayar-SPP Tahfidz 2019/2020 bulan Juli','400000','1','Chrome 89.0.4389.114','Windows 7','36.79.206.61');
INSERT INTO `log_kasir` VALUES ('60','2021-04-15 10:06:14','Bulanan','14','Pembayaran','Bayar','SPTahfidz11223315042110','112233','Bayar-SPP Tahfidz 2019/2020 bulan Agustus','400000','1','Chrome 89.0.4389.114','Windows 7','36.79.206.61');
INSERT INTO `log_kasir` VALUES ('61','2021-04-15 10:06:36','Bebas','2','Pembayaran','Bayar','','112233','Pelunasan DU Santri Baru - T.A 2019/2020','50000','1','Chrome 89.0.4389.114','Windows 7','36.79.206.61');
INSERT INTO `log_kasir` VALUES ('62','2021-04-17 15:25:20','Bulanan','14','Pembayaran','Bayar','SPTahfidz11122233317042102','111222333','Bayar-SPP Tahfidz 2019/2020 bulan Agustus','200000','1','Chrome 89.0.4389.128','Windows 10','36.68.221.111');
INSERT INTO `log_kasir` VALUES ('63','2021-04-18 05:25:16','Bulanan','2','Pembayaran','Bayar','SPTahfidz20175566718042105','201755667','Bayar-SPP Tahfidz 2019/2020 bulan Agustus','50000','1','Chrome 89.0.4389.128','Windows 10','36.79.48.213');
INSERT INTO `log_kasir` VALUES ('64','2021-04-21 13:25:25','Bulanan','14','Pembayaran','Bayar','SPTahfidz11122233321042103','111222333','Bayar-SPP Tahfidz 2019/2020 bulan Agustus','200000','1','Chrome 89.0.4389.114','Windows 7','182.253.90.199');
INSERT INTO `log_kasir` VALUES ('65','2021-04-21 13:37:31','Bulanan','20','Pembayaran','Hapus','SPTahfidz11122233321042103','111222333','Hapus Bayar-SPP Tahfidz 2019/2020 bulan Februari','200000','1','Chrome 89.0.4389.114','Windows 7','182.253.90.199');
INSERT INTO `log_kasir` VALUES ('66','2021-04-21 13:37:39','Bulanan','19','Pembayaran','Hapus','SPTahfidz11122233321042103','111222333','Hapus Bayar-SPP Tahfidz 2019/2020 bulan Januari','200000','1','Chrome 89.0.4389.114','Windows 7','182.253.90.199');
INSERT INTO `log_kasir` VALUES ('67','2021-04-21 13:37:56','Bulanan','19','Pembayaran','Bayar','SPTahfidz11122233321042103','111222333','Bayar-SPP Tahfidz 2019/2020 bulan Januari','200000','1','Chrome 89.0.4389.114','Windows 7','182.253.90.199');
INSERT INTO `log_kasir` VALUES ('68','2021-04-21 13:38:06','Bulanan','20','Pembayaran','Bayar','SPTahfidz11122233321042103','111222333','Bayar-SPP Tahfidz 2019/2020 bulan Februari','200000','1','Chrome 89.0.4389.114','Windows 7','182.253.90.199');
INSERT INTO `log_kasir` VALUES ('69','2021-04-21 13:38:07','Bulanan','20','Pembayaran','Bayar','SPTahfidz11122233321042103','111222333','Bayar-SPP Tahfidz 2019/2020 bulan Februari','200000','1','Chrome 89.0.4389.114','Windows 7','182.253.90.199');
INSERT INTO `log_kasir` VALUES ('70','2021-04-21 13:38:20','Bulanan','21','Pembayaran','Bayar','SPTahfidz11122233321042103','111222333','Bayar-SPP Tahfidz 2019/2020 bulan Maret','200000','1','Chrome 89.0.4389.114','Windows 7','182.253.90.199');
INSERT INTO `log_kasir` VALUES ('71','2021-04-22 09:57:13','Bulanan','22','Pembayaran','Bayar','SPTahfidz11122233322042103','111222333','Bayar-SPP Tahfidz 2019/2020 bulan April','200000','1','Chrome 89.0.4389.114','Windows 7','182.253.90.114');
INSERT INTO `log_kasir` VALUES ('72','2021-04-22 10:00:47','Bulanan','23','Pembayaran','Bayar','SPTahfidz11122233322042103','111222333','Bayar-SPP Tahfidz 2019/2020 bulan Mei','200000','1','Chrome 89.0.4389.114','Windows 7','182.253.90.114');
INSERT INTO `log_kasir` VALUES ('73','2021-04-23 09:13:14','Bulanan','23','Pembayaran','Hapus','SPTahfidz11122233323042103','111222333','Hapus Bayar-SPP Tahfidz 2019/2020 bulan Mei','200000','1','Chrome 89.0.4389.114','Windows 7','::1');
INSERT INTO `log_kasir` VALUES ('74','2021-04-23 09:13:24','Bulanan','23','Pembayaran','Hapus','SPTahfidz11122233323042103','111222333','Hapus Bayar-SPP Tahfidz 2019/2020 bulan Mei','200000','1','Chrome 89.0.4389.114','Windows 7','::1');
INSERT INTO `log_kasir` VALUES ('75','2021-04-23 09:14:41','Bulanan','24','Pembayaran','Bayar','SPTahfidz11122233323042103','111222333','Bayar-SPP Tahfidz 2019/2020 bulan Juni','200000','1','Chrome 89.0.4389.114','Windows 7','::1');
INSERT INTO `log_kasir` VALUES ('76','2021-04-23 09:15:08','Bebas','2','Pembayaran','Hapus','','111222333','Hapus Pelunasan DU Santri Baru - T.A 2019/2020','100000','1','Chrome 89.0.4389.114','Windows 7','::1');
INSERT INTO `log_kasir` VALUES ('77','2021-04-23 09:16:52','Bebas','2','Pembayaran','Hapus','','111222333','Hapus Pelunasan DU Santri Baru - T.A 2019/2020','100000','1','Chrome 89.0.4389.114','Windows 7','::1');
INSERT INTO `log_kasir` VALUES ('78','2021-04-23 09:16:56','Bebas','2','Pembayaran','Hapus','','111222333','Hapus Pelunasan DU Santri Baru - T.A 2019/2020','100000','1','Chrome 89.0.4389.114','Windows 7','::1');
INSERT INTO `log_kasir` VALUES ('79','2021-04-23 09:17:00','Bebas','2','Pembayaran','Hapus','','111222333','Hapus Pelunasan DU Santri Baru - T.A 2019/2020','100000','1','Chrome 89.0.4389.114','Windows 7','::1');
INSERT INTO `log_kasir` VALUES ('80','2021-04-23 09:17:03','Bebas','2','Pembayaran','Hapus','','111222333','Hapus Pelunasan DU Santri Baru - T.A 2019/2020','100000','1','Chrome 89.0.4389.114','Windows 7','::1');

/*---------------------------------------------------------------
  TABLE: `log_transaksi`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `log_transaksi`;
CREATE TABLE `log_transaksi` (
  `idTransaksi` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` datetime NOT NULL,
  `modul` varchar(50) NOT NULL,
  `aksi` varchar(100) NOT NULL,
  `info` varchar(255) NOT NULL,
  `penulis` varchar(100) NOT NULL,
  `browser` varchar(50) NOT NULL,
  `os` varchar(50) NOT NULL,
  `ip_address` varchar(40) NOT NULL,
  PRIMARY KEY (`idTransaksi`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4;
INSERT INTO `log_transaksi` VALUES   ('1','2021-04-16 01:14:28','Pembayaran','Bayar Bebas','NIS:201755667;Title:Bayar DU Santri Baru T.A. 2019/2020 nominal 300000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('2','2021-04-16 01:53:36','Pembayaran','Bayar Bulanan','NIS:201755667;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 100000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('3','2021-04-16 01:56:37','Pembayaran','Bayar Bulanan','NIS:201755667;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 150000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('4','2021-04-17 03:37:14','Pembayaran','Bayar Bulanan','NIS:201755667;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 55000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('5','2021-04-17 03:37:55','Pembayaran','Bayar Bulanan','NIS:201755667;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 55000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('6','2021-04-17 04:27:12','Pembayaran','Bayar Bulanan','NIS:201755667;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 55000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('7','2021-04-17 04:34:20','Pembayaran','Bayar Bulanan','NIS:201755667;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 55000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('8','2021-04-17 04:35:57','Pembayaran','Bayar Bulanan','NIS:201755667;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 55000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('9','2021-04-17 04:36:22','Pembayaran','Bayar Bulanan','NIS:201755667;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 50000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('10','2021-04-17 04:37:39','Pembayaran','Bayar Bulanan','NIS:201755667;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 50000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('11','2021-04-17 04:45:03','Pembayaran','Bayar Bulanan','NIS:201755667;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 50000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('12','2021-04-17 04:59:27','Pembayaran','Bayar Bulanan','NIS:201755667;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 50000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('13','2021-04-17 05:01:27','Pembayaran','Bayar Bulanan','NIS:201755667;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 50000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('14','2021-04-17 05:03:43','Pembayaran','Bayar Bulanan','NIS:201755667;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 50000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('15','2021-04-17 05:07:49','Pembayaran','Bayar Bulanan','NIS:201755667;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 50000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('16','2021-04-17 05:10:35','Pembayaran','Bayar Bulanan','NIS:201755667;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 50000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('17','2021-04-17 05:12:17','Pembayaran','Bayar Bulanan','NIS:201755667;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 50000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('18','2021-04-17 05:15:01','Pembayaran','Bayar Bulanan','NIS:201755667;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 55000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('19','2021-04-17 15:21:23','Pembayaran','Bayar Bulanan','NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 200000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('20','2021-04-17 15:22:58','Pembayaran','Bayar Bulanan','NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 200000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('21','2021-04-17 15:25:20','Pembayaran','Bayar Bulanan','NIS:111222333;Title:Bayar-SPP Tahfidz 2019/2020 bulan Agustus nominal 200000','1','Chrome 89.0.4389.128','Windows 10','36.68.221.111');
INSERT INTO `log_transaksi` VALUES ('22','0000-00-00 00:00:00','Pembayaran','Simpan Pembayaran','NIS:111222333;Title:Simpan No. Ref: SPTahfidz11122233317042102','','Chrome 89.0.4389.128','Windows 10','36.68.221.111');
INSERT INTO `log_transaksi` VALUES ('23','2021-04-17 15:28:41','Pembayaran','Bayar Bulanan','NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 200000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('24','2021-04-17 15:33:19','Pembayaran','Bayar Bebas','NIS:111222333;Title:Bayar DU Santri Baru T.A. 2019/2020 nominal 100000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('25','2021-04-17 15:34:57','Pembayaran','Bayar Bebas','NIS:111222333;Title:Bayar DU Santri Baru T.A. 2019/2020 nominal 100000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('26','2021-04-17 15:40:51','Pembayaran','Bayar Bebas','NIS:111222333;Title:Bayar DU Santri Baru T.A. 2019/2020 nominal 100000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('27','2021-04-17 15:42:20','Pembayaran','Bayar Bulanan','NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 200000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('28','2021-04-17 15:52:39','Pembayaran','Bayar Bebas','NIS:111222333;Title:Bayar DU Santri Baru T.A. 2019/2020 nominal 100000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('29','2021-04-17 16:10:12','Pembayaran','Bayar Bulanan','NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 200000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('30','2021-04-17 16:18:21','Pembayaran','Bayar Bulanan','NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 200000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('31','2021-04-17 16:19:15','Pembayaran','Bayar Bulanan','NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 200000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('32','2021-04-17 16:26:35','Pembayaran','Bayar Bulanan','NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 200000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('33','2021-04-17 16:37:50','Pembayaran','Bayar Bulanan','NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 200000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('34','2021-04-17 16:41:57','Pembayaran','Bayar Bebas','NIS:111222333;Title:Bayar DU Santri Baru T.A. 2019/2020 nominal 100000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('35','2021-04-17 17:03:40','Pembayaran','Bayar Bulanan','NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 200000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('36','2021-04-17 17:45:39','Pembayaran','Bayar Bulanan','NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 200000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('37','2021-04-17 17:54:49','Pembayaran','Bayar Bebas','NIS:111222333;Title:Bayar DU Santri Baru T.A. 2019/2020 nominal 100000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('38','2021-04-17 18:30:45','Pembayaran','Bayar Bulanan','NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 200000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('39','2021-04-18 05:25:16','Pembayaran','Bayar Bulanan','NIS:201755667;Title:Bayar-SPP Tahfidz 2019/2020 bulan Agustus nominal 50000','1','Chrome 89.0.4389.128','Windows 10','36.79.48.213');
INSERT INTO `log_transaksi` VALUES ('40','2021-04-18 11:10:35','Pembayaran','Bayar Bulanan','NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 400000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('41','2021-04-18 11:11:13','Pembayaran','Bayar Bulanan','NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 400000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('42','2021-04-18 11:17:37','Pembayaran','Bayar Bulanan','NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 400000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('43','2021-04-21 11:30:33','Pembayaran','Bayar Bulanan','NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 600000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('44','2021-04-21 11:32:43','Pembayaran','Bayar Bulanan','NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 600000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('45','2021-04-21 11:36:49','Pembayaran','Bayar Bulanan','NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 600000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('46','2021-04-21 11:50:24','Pembayaran','Bayar Bulanan','NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 600000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('47','2021-04-21 12:30:12','Pembayaran','Bayar Bulanan','NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 600000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('48','2021-04-21 13:25:25','Pembayaran','Bayar Bulanan','NIS:111222333;Title:Bayar-SPP Tahfidz 2019/2020 bulan Agustus nominal 200000','1','Chrome 89.0.4389.114','Windows 7','182.253.90.199');
INSERT INTO `log_transaksi` VALUES ('49','2021-04-21 13:37:31','Pembayaran','Hapus Bayar Bulanan','NIS:111222333;Title:Hapus Bayar-SPP Tahfidz 2019/2020 bulan Februari nominal 200000','1','Chrome 89.0.4389.114','Windows 7','182.253.90.199');
INSERT INTO `log_transaksi` VALUES ('50','2021-04-21 13:37:39','Pembayaran','Hapus Bayar Bulanan','NIS:111222333;Title:Hapus Bayar-SPP Tahfidz 2019/2020 bulan Januari nominal 200000','1','Chrome 89.0.4389.114','Windows 7','182.253.90.199');
INSERT INTO `log_transaksi` VALUES ('51','2021-04-21 13:37:56','Pembayaran','Bayar Bulanan','NIS:111222333;Title:Bayar-SPP Tahfidz 2019/2020 bulan Januari nominal 200000','1','Chrome 89.0.4389.114','Windows 7','182.253.90.199');
INSERT INTO `log_transaksi` VALUES ('52','2021-04-21 13:38:06','Pembayaran','Bayar Bulanan','NIS:111222333;Title:Bayar-SPP Tahfidz 2019/2020 bulan Februari nominal 200000','1','Chrome 89.0.4389.114','Windows 7','182.253.90.199');
INSERT INTO `log_transaksi` VALUES ('53','2021-04-21 13:38:07','Pembayaran','Bayar Bulanan','NIS:111222333;Title:Bayar-SPP Tahfidz 2019/2020 bulan Februari nominal 200000','1','Chrome 89.0.4389.114','Windows 7','182.253.90.199');
INSERT INTO `log_transaksi` VALUES ('54','2021-04-21 13:38:20','Pembayaran','Bayar Bulanan','NIS:111222333;Title:Bayar-SPP Tahfidz 2019/2020 bulan Maret nominal 200000','1','Chrome 89.0.4389.114','Windows 7','182.253.90.199');
INSERT INTO `log_transaksi` VALUES ('55','2021-04-21 13:55:57','Pembayaran','Bayar Bulanan','NIS:111222333;Title:Bayar SPP Tahfidz T.A. 2019/2020 nominal 600000','Midtrans','Midtrans','Midtrans','Midtrans');
INSERT INTO `log_transaksi` VALUES ('56','2021-04-22 09:57:13','Pembayaran','Bayar Bulanan','NIS:111222333;Title:Bayar-SPP Tahfidz 2019/2020 bulan April nominal 200000','1','Chrome 89.0.4389.114','Windows 7','182.253.90.114');
INSERT INTO `log_transaksi` VALUES ('57','2021-04-22 10:00:47','Pembayaran','Bayar Bulanan','NIS:111222333;Title:Bayar-SPP Tahfidz 2019/2020 bulan Mei nominal 200000','1','Chrome 89.0.4389.114','Windows 7','182.253.90.114');
INSERT INTO `log_transaksi` VALUES ('58','2021-04-23 09:13:14','Pembayaran','Hapus Bayar Bulanan','NIS:111222333;Title:Hapus Bayar-SPP Tahfidz 2019/2020 bulan Mei nominal 200000','1','Chrome 89.0.4389.114','Windows 7','::1');
INSERT INTO `log_transaksi` VALUES ('59','2021-04-23 09:13:24','Pembayaran','Hapus Bayar Bulanan','NIS:111222333;Title:Hapus Bayar-SPP Tahfidz 2019/2020 bulan Mei nominal 200000','1','Chrome 89.0.4389.114','Windows 7','::1');
INSERT INTO `log_transaksi` VALUES ('60','2021-04-23 09:14:41','Pembayaran','Bayar Bulanan','NIS:111222333;Title:Bayar-SPP Tahfidz 2019/2020 bulan Juni nominal 200000','1','Chrome 89.0.4389.114','Windows 7','::1');
INSERT INTO `log_transaksi` VALUES ('61','2021-04-23 09:15:08','Pembayaran','Hapus Bayar Bebas','NIS:111222333;Title:Hapus Pelunasan DU Santri Baru - T.A 2019/2020 nominal 100000','1','Chrome 89.0.4389.114','Windows 7','::1');
INSERT INTO `log_transaksi` VALUES ('62','2021-04-23 09:16:52','Pembayaran','Hapus Bayar Bebas','NIS:111222333;Title:Hapus Pelunasan DU Santri Baru - T.A 2019/2020 nominal 100000','1','Chrome 89.0.4389.114','Windows 7','::1');
INSERT INTO `log_transaksi` VALUES ('63','2021-04-23 09:16:56','Pembayaran','Hapus Bayar Bebas','NIS:111222333;Title:Hapus Pelunasan DU Santri Baru - T.A 2019/2020 nominal 100000','1','Chrome 89.0.4389.114','Windows 7','::1');
INSERT INTO `log_transaksi` VALUES ('64','2021-04-23 09:17:00','Pembayaran','Hapus Bayar Bebas','NIS:111222333;Title:Hapus Pelunasan DU Santri Baru - T.A 2019/2020 nominal 100000','1','Chrome 89.0.4389.114','Windows 7','::1');
INSERT INTO `log_transaksi` VALUES ('65','2021-04-23 09:17:03','Pembayaran','Hapus Bayar Bebas','NIS:111222333;Title:Hapus Pelunasan DU Santri Baru - T.A 2019/2020 nominal 100000','1','Chrome 89.0.4389.114','Windows 7','::1');

/*---------------------------------------------------------------
  TABLE: `memodb`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `memodb`;
CREATE TABLE `memodb` (
  `kwnum` varchar(20) NOT NULL,
  `nominal` int(11) NOT NULL,
  `payee` varchar(25) NOT NULL,
  `pic` varchar(25) NOT NULL,
  `tglkw` varchar(20) NOT NULL,
  `ktrg` text NOT NULL,
  PRIMARY KEY (`kwnum`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO `memodb` VALUES   ('001/KHS-KWT/X/19','120000','Rivani vhan','dfsdf','11 Oktober 2019','dfss');

/*---------------------------------------------------------------
  TABLE: `menu`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `idMenu` int(11) NOT NULL AUTO_INCREMENT,
  `noMenu` int(11) DEFAULT NULL,
  `namaMenu` varchar(255) DEFAULT NULL,
  `iconMenu` varchar(100) DEFAULT NULL,
  `lokasiFileMenu` varchar(255) DEFAULT NULL,
  `ketMenu` varchar(255) DEFAULT NULL,
  `viewMenu` varchar(100) DEFAULT NULL,
  `level` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`idMenu`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=latin1;
INSERT INTO `menu` VALUES   ('1',NULL,'Dashboard','fa fa-dashboard','admin/home_admin.php','Main Menu','dashboard','Admin');
INSERT INTO `menu` VALUES ('2',NULL,'Kesantrian','fa fa-users','-','Main Menu','-','Admin');
INSERT INTO `menu` VALUES ('3','2','Unit Sekolah','fa fa-circle-o','admin/master_unit_sekolah.php','Sub Menu 1','unit sekolah','Admin');
INSERT INTO `menu` VALUES ('4','2','Kelas','fa fa-circle-o','admin/master_kelas.php','Sub Menu 1','kelas','Admin');
INSERT INTO `menu` VALUES ('5','2','Kamar','fa fa-circle-o','admin/master_kamar.php','Sub Menu 1','kamar','Admin');
INSERT INTO `menu` VALUES ('6','2','Santri','fa fa-circle-o','admin/master_siswa.php','Sub Menu 1','santri','Admin');
INSERT INTO `menu` VALUES ('7','2','Tahfidz','fa fa-circle-o','admin/master_tahfidz.php','Sub Menu 1','tahfidz','Admin');
INSERT INTO `menu` VALUES ('8','2','Kesehatan','fa fa-circle-o','admin/master_kesehatan.php','Sub Menu 1','kesehatan','Admin');
INSERT INTO `menu` VALUES ('9','2','Konseling','fa fa-circle-o','-','Sub Menu 1','-','Admin');
INSERT INTO `menu` VALUES ('10',NULL,'Kepegawaian','fa fa-suitcase','-','Main Menu','-','Admin');
INSERT INTO `menu` VALUES ('11','10','Jabatan Pegawai','fa fa-circle-o','admin/master_jabatan.php','Sub Menu 1','jabatan pegawai','Admin');
INSERT INTO `menu` VALUES ('12','10','Pegawai','fa fa-circle-o','admin/master_pegawai.php','Sub Menu 1','pegawai','Admin');
INSERT INTO `menu` VALUES ('13',NULL,'Akademik','fa fa-graduation-cap','-','Main Menu','-','Admin');
INSERT INTO `menu` VALUES ('14','13','Tahun Ajaran','fa fa-circle-o','admin/master_tahun.php','Sub Menu 1','tahun ajaran','Admin');
INSERT INTO `menu` VALUES ('15','13','Pindah Kelas','fa fa-circle-o','admin/master_kenaikankelas.php','Sub Menu 1','pindah kelas','Admin');
INSERT INTO `menu` VALUES ('16','13','Kelulusan','fa fa-circle-o','admin/master_kelulusan.php','Sub Menu 1','kelulusan','Admin');
INSERT INTO `menu` VALUES ('17',NULL,'Keuangan','fa fa-money','-','Main Menu','-','Admin');
INSERT INTO `menu` VALUES ('18','17','Pembayaran Santri','fa fa-circle-o','admin/master_pembayaransiswa.php','Sub Menu 1','pembayaran santri','Admin');
INSERT INTO `menu` VALUES ('19','17','Setting Pembayaran','fa fa-circle-o','-','Sub Menu 1','-','Admin');
INSERT INTO `menu` VALUES ('20','19','Akun Biaya','fa fa-circle-o','admin/master_akunbiaya.php','Sub Menu 2','akun biaya','Admin');
INSERT INTO `menu` VALUES ('21','19','Pos Bayar','fa fa-circle-o','admin/master_posbayar.php','Sub Menu 2','pos bayar','Admin');
INSERT INTO `menu` VALUES ('22','19','Jenis Bayar','fa fa-circle-o','admin/master_jenisbayar.php','Sub Menu 2','jenis bayar','Admin');
INSERT INTO `menu` VALUES ('23','19','Pajak','fa fa-circle-o','admin/master_pajak.php','Sub Menu 2','pajak','Admin');
INSERT INTO `menu` VALUES ('24','19','Unit Pos','fa fa-circle-o','admin/master_unitpos.php','Sub Menu 2','unit pos','Admin');
INSERT INTO `menu` VALUES ('25','17','Tabungan Santri','fa fa-circle-o','admin/master_tabungansantri.php','Sub Menu 1','tabungan santri','Admin');
INSERT INTO `menu` VALUES ('26','17','Kas & Bank','fa fa-circle-o','-','Sub Menu 1','-','Admin');
INSERT INTO `menu` VALUES ('27','26','Saldo Awal','fa fa-circle-o','admin/master_saldoawal.php','Sub Menu 2','saldo awal','Admin');
INSERT INTO `menu` VALUES ('28','26','Kas Keluar','fa fa-circle-o','admin/master_kaskeluar.php','Sub Menu 2','kas keluar','Admin');
INSERT INTO `menu` VALUES ('29','26','Kas Masuk','fa fa-circle-o','admin/master_kasmasuk.php','Sub Menu 2','kas masuk','Admin');
INSERT INTO `menu` VALUES ('30','26','Transfer Kas','fa fa-circle-o','admin/master_transferkas.php','Sub Menu 2','transfer kas','Admin');
INSERT INTO `menu` VALUES ('31','26','Rekonsiliasi Bank','fa fa-circle-o','admin/master_rekonsiliasibank.php','Sub Menu 2','rekonsiliasi bank','Admin');
INSERT INTO `menu` VALUES ('32','17','Penggajian','fa fa-circle-o','-','Sub Menu 1','-','Admin');
INSERT INTO `menu` VALUES ('33','32','Setting Gaji','fa fa-circle-o','admin/master_settinggaji.php','Sub Menu 2','setting gaji','Admin');
INSERT INTO `menu` VALUES ('34','32','Slip Gaji','fa fa-circle-o','admin/master_slipgaji.php','Sub Menu 2','slip gaji','Admin');
INSERT INTO `menu` VALUES ('35','17','Hutang','fa fa-circle-o','-','Sub Menu 1','-','Admin');
INSERT INTO `menu` VALUES ('36','35','Pos Hutang','fa fa-circle-o','admin/master_poshutang.php','Sub Menu 2','pos hutang','Admin');
INSERT INTO `menu` VALUES ('37','35','Setting Hutang','fa fa-circle-o','admin/master_settinghutang.php','Sub Menu 2','setting hutang','Admin');
INSERT INTO `menu` VALUES ('38','35','Bayar Hutang','fa fa-circle-o','admin/master_bayarhutang.php','Sub Menu 2','bayar hutang','Admin');
INSERT INTO `menu` VALUES ('39','17','Kirim Tagihan','fa fa-circle-o','admin/master_kirimtagihan.php','Sub Menu 1','kirim tagihan','Admin');
INSERT INTO `menu` VALUES ('40',NULL,'Laporan','fa fa-file-text-o','-','Main Menu','-','Admin');
INSERT INTO `menu` VALUES ('41','40','Lap. Pembayaran','fa fa-circle-o','-','Sub Menu 1','-','Admin');
INSERT INTO `menu` VALUES ('42','41','Per Kelas','fa fa-circle-o','admin/master_laporanperkelas.php','Sub Menu 2','laporan perkelas','Admin');
INSERT INTO `menu` VALUES ('43','41','Per Tanggal','fa fa-circle-o','admin/master_laporanpertanggal.php','Sub Menu 2','laporan pertanggal','Admin');
INSERT INTO `menu` VALUES ('44','41','Tagihan Santri','fa fa-circle-o','admin/master_laporantagihansiswa.php','Sub Menu 2','laporan tagihan santri','Admin');
INSERT INTO `menu` VALUES ('45','41','Rekap Pembayaran','fa fa-circle-o','admin/master_laporanrekappembayaran.php','Sub Menu 2','laporan rekap pembayaran','Admin');
INSERT INTO `menu` VALUES ('46','40','Lap. Keuangan','fa fa-circle-o','-','Sub Menu 1','-','Admin');
INSERT INTO `menu` VALUES ('47','46','Lap. Jurnal (Kas)','fa fa-circle-o','admin/master_laporanjurnal.php','Sub Menu 2','laporan kas tunai','Admin');
INSERT INTO `menu` VALUES ('48','46','Lap. Kas Bank','fa fa-circle-o','admin/master_laporankasbank.php','Sub Menu 2','laporan kas bank','Admin');
INSERT INTO `menu` VALUES ('49','46','Lap. Neraca','fa fa-circle-o','admin/master_laporanneraca.php','Sub Menu 2','laporan neraca','Admin');
INSERT INTO `menu` VALUES ('50','40','Lap. Tabungan','	\r\nfa fa-circle-o','admin/master_laporantabungan.php','Sub Menu 1','laporan tabungan','Admin');
INSERT INTO `menu` VALUES ('51',NULL,'Pengaturan','fa fa-gear','-','Main Menu','-','Admin');
INSERT INTO `menu` VALUES ('52','51','Identitas Sekolah','fa fa-circle-o','admin/master_identitassekolah.php','Sub Menu 1','identitas','Admin');
INSERT INTO `menu` VALUES ('53','51','Bulan','fa fa-circle-o','admin/master_bulan.php','Sub Menu 1','bulan','Admin');
INSERT INTO `menu` VALUES ('54','51','Informasi','fa fa-circle-o','admin/master_informasi.php','Sub Menu 1','informasi','Admin');
INSERT INTO `menu` VALUES ('55','51','Manajemen Pengguna','fa fa-circle-o','admin/master_pengguna.php','Sub Menu 1','pengguna','Admin');
INSERT INTO `menu` VALUES ('56','51','Pemeliharaan','fa fa-circle-o','admin/master_pemeliharaan.php','Sub Menu 1','pemeliharaan','Admin');
INSERT INTO `menu` VALUES ('57','51','Logs Transaksi','fa fa-circle-o','admin/master_logtransaksi.php','Sub Menu 1','logs transaksi','Admin');
INSERT INTO `menu` VALUES ('58',NULL,'Dashboard','fa fa-dashboard','siswa/home_siswa.php','Main Menu','dashboard','Siswa');
INSERT INTO `menu` VALUES ('59',NULL,'Profil','fa fa-user','siswa/master_siswa.php','Main Menu','profil','Siswa');
INSERT INTO `menu` VALUES ('60',NULL,'Pembayaran','fa fa-money','siswa/master_pembayaran.php','Main Menu','cek pembayaran','Siswa');
INSERT INTO `menu` VALUES ('61','9','Perizinan','fa fa-circle-o','admin/master_perizinan.php','Sub Menu 2','perizinan','Admin');
INSERT INTO `menu` VALUES ('62','9','Pelanggaran','fa fa-circle-o','admin/master_pelanggaran.php','Sub Menu 2','pelanggaran','Admin');
INSERT INTO `menu` VALUES ('63','40','Lap. Kesehatan','fa fa-circle-o','admin/master_laporankesehatan.php','Sub Menu 1','laporan kesehatan','Admin');
INSERT INTO `menu` VALUES ('64','40','Lap. Konseling','fa fa-circle-o','-','Sub Menu 1','-','Admin');
INSERT INTO `menu` VALUES ('65','64','Lap. Perizinan','fa fa-circle-o','admin/master_laporanperizinan.php','Sub Menu 2','laporan perizinan','Admin');
INSERT INTO `menu` VALUES ('66','64','Lap. Pelanggaran','fa fa-circle-o','admin/master_laporanpelanggaran.php','Sub Menu 2','laporan pelanggaran','Admin');
INSERT INTO `menu` VALUES ('67','46','Lap. Kas Kasir','fa fa-circle-o','admin/master_laporankaskasir.php','Sub Menu 2','laporan kas kasir','Admin');

/*---------------------------------------------------------------
  TABLE: `pajak`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `pajak`;
CREATE TABLE `pajak` (
  `idPajak` int(11) NOT NULL AUTO_INCREMENT,
  `nmPajak` varchar(50) NOT NULL,
  `besaranPajak` double NOT NULL,
  `stdel` int(11) DEFAULT '0',
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL,
  PRIMARY KEY (`idPajak`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
INSERT INTO `pajak` VALUES   ('1','AAA','2.5','0','1','2021-01-28 16:08:28',NULL,NULL,NULL,NULL);
INSERT INTO `pajak` VALUES ('2','www','1.7','0','1','2021-01-28 16:09:04',NULL,NULL,NULL,NULL);
INSERT INTO `pajak` VALUES ('3','22','10','1','1','2021-01-28 16:09:04','1','2021-01-28 16:13:25','1','2021-01-28 16:13:29');

/*---------------------------------------------------------------
  TABLE: `pegawai`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `pegawai`;
CREATE TABLE `pegawai` (
  `idPegawai` int(11) NOT NULL AUTO_INCREMENT,
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
  `ddate` datetime DEFAULT NULL,
  PRIMARY KEY (`idPegawai`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;
INSERT INTO `pegawai` VALUES   ('15','201806001','Abdullah',NULL,NULL,NULL,NULL,'1','1',NULL,NULL,'e10adc3949ba59abbe56e057f20f883e',NULL,NULL,NULL,NULL,'Aktif',NULL,'0','1','2021-02-18 22:51:57',NULL,NULL,NULL,NULL);
INSERT INTO `pegawai` VALUES ('16','201806002','MMM','','','0000-00-00','','1','3','Pegawai Tetap','','e10adc3949ba59abbe56e057f20f883e','','','0000-00-00','0000-00-00','Aktif','download.jpg','0','1','2021-02-18 22:51:57','1','2021-02-18 23:01:56',NULL,NULL);
INSERT INTO `pegawai` VALUES ('17','201806001','Abdullah',NULL,NULL,NULL,NULL,'1','1','Pegawai Tetap',NULL,'e10adc3949ba59abbe56e057f20f883e',NULL,NULL,NULL,NULL,'Aktif',NULL,'0','1','2021-02-18 23:15:25',NULL,NULL,NULL,NULL);
INSERT INTO `pegawai` VALUES ('18','201806002','Dullah',NULL,NULL,NULL,NULL,'1','1','Pegawai Tidak Tetap',NULL,'e10adc3949ba59abbe56e057f20f883e',NULL,NULL,NULL,NULL,'Aktif',NULL,'0','1','2021-02-18 23:15:25',NULL,NULL,NULL,NULL);

/*---------------------------------------------------------------
  TABLE: `pegawai_gaji`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `pegawai_gaji`;
CREATE TABLE `pegawai_gaji` (
  `idGaji` int(11) NOT NULL AUTO_INCREMENT,
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
  `ddate` datetime DEFAULT NULL,
  PRIMARY KEY (`idGaji`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
INSERT INTO `pegawai_gaji` VALUES   ('2','12','63','5000000','1000000','100000','0','0','0','0','0','0','0','1','2021-02-01 11:29:42','1','2021-02-02 11:44:02',NULL,NULL);
INSERT INTO `pegawai_gaji` VALUES ('3','13','63','5000000','1000000','50000','0','0','0','0','0','0','0','1','2021-02-11 22:58:15',NULL,NULL,NULL,NULL);
INSERT INTO `pegawai_gaji` VALUES ('4','15','63','5000000','100000','0','0','0','0','0','0','0','0','1','2021-02-22 22:39:05',NULL,NULL,NULL,NULL);

/*---------------------------------------------------------------
  TABLE: `pegawai_gaji_slip`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `pegawai_gaji_slip`;
CREATE TABLE `pegawai_gaji_slip` (
  `idSlipGaji` int(11) NOT NULL AUTO_INCREMENT,
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
  `ddate` datetime DEFAULT NULL,
  PRIMARY KEY (`idSlipGaji`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4;
INSERT INTO `pegawai_gaji_slip` VALUES   ('21','2','GKTahfidz201805022101','2021-02-05','12','15','7','3','5000000','1000000','100000','0','0','0','0','0','0','1','1','2021-02-05 23:45:51',NULL,NULL,'1','2021-02-05 23:48:07');
INSERT INTO `pegawai_gaji_slip` VALUES ('22','0','GKTahfidz123545506022101','2021-02-06','13','15','7','5','0','0','0','0','0','0','0','0','0','1','1','2021-02-06 13:24:52',NULL,NULL,'1','2021-02-08 12:57:33');
INSERT INTO `pegawai_gaji_slip` VALUES ('23','3','GKTahfidz123545511022101','2021-02-11','13','15','7','3','5000000','1000000','50000','0','0','0','0','0','0','1','1','2021-02-11 22:58:33',NULL,NULL,'1','2021-02-12 00:58:16');
INSERT INTO `pegawai_gaji_slip` VALUES ('24','3','GKTahfidz123545512022101','2021-02-12','13','15','8','3','5000000','1000000','50000','0','0','0','0','0','0','1','1','2021-02-12 00:56:04',NULL,NULL,'1','2021-02-12 00:57:04');
INSERT INTO `pegawai_gaji_slip` VALUES ('25','3','GKTahfidz123545512022101','2021-02-12','13','15','8','3','5000000','1000000','50000','100000','0','0','0','0','0','1','1','2021-02-12 00:57:37',NULL,NULL,'1','2021-02-15 02:02:50');
INSERT INTO `pegawai_gaji_slip` VALUES ('26','3','GKTahfidz123545514022101','2021-02-14','13','16','7','3','5000000','1000000','50000','0','0','0','0','0','0','1','1','2021-02-14 01:17:49',NULL,NULL,'1','2021-02-15 01:53:21');
INSERT INTO `pegawai_gaji_slip` VALUES ('27','4','GKTahfidz20180600122022101','2021-02-22','15','15','7','3','5000000','100000','0','0','0','0','0','0','0','1','1','2021-02-22 22:39:25',NULL,NULL,'1','2021-02-22 22:43:34');
INSERT INTO `pegawai_gaji_slip` VALUES ('28','4','GKTahfidz20180600122022101','2021-02-22','15','15','7','3','5000000','100000','0','0','0','0','0','0','0','0','1','2021-02-22 22:49:21',NULL,NULL,NULL,NULL);

/*---------------------------------------------------------------
  TABLE: `pegawai_jabatan`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `pegawai_jabatan`;
CREATE TABLE `pegawai_jabatan` (
  `idPegawaiJabatan` int(11) NOT NULL AUTO_INCREMENT,
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
  `ddate` datetime DEFAULT NULL,
  PRIMARY KEY (`idPegawaiJabatan`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
INSERT INTO `pegawai_jabatan` VALUES   ('1','1','2021-01-09','2021-01-23','dsdfdsf','0','1','2021-01-20 12:17:23',NULL,NULL,NULL,NULL);
INSERT INTO `pegawai_jabatan` VALUES ('2','1','2021-01-09','2021-01-15','ssss','1','1','2021-01-20 12:17:23',NULL,NULL,'1','2021-01-25 01:11:48');
INSERT INTO `pegawai_jabatan` VALUES ('3','1','2021-01-23','2021-01-30','4565789','1','1','2021-01-20 12:45:32',NULL,NULL,'1','2021-01-20 13:36:26');
INSERT INTO `pegawai_jabatan` VALUES ('4','1','2021-01-30','2021-01-23','12','1','1','2021-01-20 13:35:25',NULL,NULL,'1','2021-01-20 13:36:34');
INSERT INTO `pegawai_jabatan` VALUES ('5','1','2021-01-23','2021-01-30','12345','0','1','2021-01-20 13:35:25',NULL,NULL,NULL,NULL);

/*---------------------------------------------------------------
  TABLE: `pegawai_keluarga`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `pegawai_keluarga`;
CREATE TABLE `pegawai_keluarga` (
  `idKeluarga` int(11) NOT NULL AUTO_INCREMENT,
  `idPegawai` int(11) NOT NULL,
  `keluargaNama` varchar(100) NOT NULL,
  `keluargaHubungan` varchar(50) NOT NULL,
  `stdel` int(11) DEFAULT NULL,
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL,
  PRIMARY KEY (`idKeluarga`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;
INSERT INTO `pegawai_keluarga` VALUES   ('1','0','0','2','0','1','2021-01-20 11:14:18',NULL,NULL,NULL,NULL);
INSERT INTO `pegawai_keluarga` VALUES ('2','0','0','3','0','1','2021-01-20 11:14:18',NULL,NULL,NULL,NULL);
INSERT INTO `pegawai_keluarga` VALUES ('3','1','1111','0','1','1','2021-01-20 11:19:19',NULL,NULL,'1','2021-01-20 11:21:07');
INSERT INTO `pegawai_keluarga` VALUES ('4','1','22222','0','1','1','2021-01-20 11:19:19',NULL,NULL,'1','2021-01-20 11:21:11');
INSERT INTO `pegawai_keluarga` VALUES ('5','1','aaaa','Istri','1','1','2021-01-20 11:21:02',NULL,NULL,'1','2021-01-20 11:21:15');
INSERT INTO `pegawai_keluarga` VALUES ('6','1','bbbb','Suami','0','1','2021-01-20 11:21:02',NULL,NULL,NULL,NULL);
INSERT INTO `pegawai_keluarga` VALUES ('7','1','cccc','Anak','1','1','2021-01-20 11:21:02',NULL,NULL,'1','2021-01-20 13:32:34');
INSERT INTO `pegawai_keluarga` VALUES ('8','1','1111','Anak','1','1','2021-01-20 12:44:15',NULL,NULL,'1','2021-01-20 12:45:53');
INSERT INTO `pegawai_keluarga` VALUES ('9','1','2222','Ibu','1','1','2021-01-20 12:44:15',NULL,NULL,'1','2021-01-20 12:45:47');
INSERT INTO `pegawai_keluarga` VALUES ('10','1','111','Suami','1','1','2021-01-20 13:35:00',NULL,NULL,'1','2021-01-20 13:35:05');
INSERT INTO `pegawai_keluarga` VALUES ('11','1','2222','Ayah','1','1','2021-01-20 13:35:00',NULL,NULL,'1','2021-01-25 01:11:44');

/*---------------------------------------------------------------
  TABLE: `pegawai_mengajar`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `pegawai_mengajar`;
CREATE TABLE `pegawai_mengajar` (
  `idMengajar` int(1) NOT NULL AUTO_INCREMENT,
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
  `ddate` datetime DEFAULT NULL,
  PRIMARY KEY (`idMengajar`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
INSERT INTO `pegawai_mengajar` VALUES   ('1','1','2021-01-15','2021-01-29','11','222','1','1','2021-01-20 13:07:59',NULL,NULL,'1','2021-01-20 13:13:46');
INSERT INTO `pegawai_mengajar` VALUES ('2','1','2021-01-08','2021-01-29','111','222','1','1','2021-01-20 13:14:21',NULL,NULL,'1','2021-01-20 13:16:26');
INSERT INTO `pegawai_mengajar` VALUES ('3','1','2021-01-11','2021-01-30','333','444','1','1','2021-01-20 13:14:21',NULL,NULL,'1','2021-01-20 13:33:02');
INSERT INTO `pegawai_mengajar` VALUES ('4','1','2021-01-21','2021-01-30','11','1111','1','1','2021-01-20 13:33:20',NULL,NULL,'1','2021-01-20 13:33:24');
INSERT INTO `pegawai_mengajar` VALUES ('5','1','2021-01-21','2021-01-23','22','222','0','1','2021-01-20 13:33:20',NULL,NULL,NULL,NULL);
INSERT INTO `pegawai_mengajar` VALUES ('6','1','2021-01-23','2021-01-29','111111','111111111111111111111111','1','1','2021-01-20 13:37:04',NULL,NULL,'1','2021-01-20 13:37:35');
INSERT INTO `pegawai_mengajar` VALUES ('7','1','2021-01-22','2021-01-30','222222','222222222222222222222222','1','1','2021-01-20 13:37:04',NULL,NULL,'1','2021-01-20 13:37:40');

/*---------------------------------------------------------------
  TABLE: `pegawai_pendidikan`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `pegawai_pendidikan`;
CREATE TABLE `pegawai_pendidikan` (
  `idPendidikan` int(11) NOT NULL AUTO_INCREMENT,
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
  `ddate` datetime DEFAULT NULL,
  PRIMARY KEY (`idPendidikan`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
INSERT INTO `pegawai_pendidikan` VALUES   ('1','1','2020','2020','IIA','OL','1','1','2021-01-20 09:41:35',NULL,NULL,'1','2021-01-20 10:09:04');
INSERT INTO `pegawai_pendidikan` VALUES ('2','1','2019','2025','222','222','1','1','2021-01-20 10:22:15',NULL,NULL,'1','2021-01-20 10:22:31');
INSERT INTO `pegawai_pendidikan` VALUES ('3','1','2000','1111','1111','1111','1','1','2021-01-20 10:22:15',NULL,NULL,'1','2021-01-20 12:31:37');
INSERT INTO `pegawai_pendidikan` VALUES ('4','1','2024','2025','222','33','1','1','2021-01-20 10:37:43',NULL,NULL,'1','2021-01-20 12:19:12');
INSERT INTO `pegawai_pendidikan` VALUES ('5','1','2029','2028','11','1','1','1','2021-01-20 12:32:34',NULL,NULL,'1','2021-01-20 12:45:40');
INSERT INTO `pegawai_pendidikan` VALUES ('6','1','2028','2025','22','2222','1','1','2021-01-20 12:32:34',NULL,NULL,'1','2021-01-20 12:34:10');
INSERT INTO `pegawai_pendidikan` VALUES ('7','1','2026','2030','111','2222','1','1','2021-01-20 13:17:14',NULL,NULL,'1','2021-01-25 01:11:55');
INSERT INTO `pegawai_pendidikan` VALUES ('8','1','2026','2030','22222','2222222222','1','1','2021-01-20 13:34:15',NULL,NULL,'1','2021-01-20 13:34:19');
INSERT INTO `pegawai_pendidikan` VALUES ('9','1','1915','2024','11111','11111111111','0','1','2021-01-20 13:34:15',NULL,NULL,NULL,NULL);

/*---------------------------------------------------------------
  TABLE: `pegawai_penghargaan`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `pegawai_penghargaan`;
CREATE TABLE `pegawai_penghargaan` (
  `idPenghargaan` int(11) NOT NULL AUTO_INCREMENT,
  `idPegawai` int(11) NOT NULL,
  `penghargaanTahun` varchar(25) NOT NULL,
  `penghargaanNama` varchar(255) NOT NULL,
  `stdel` int(11) DEFAULT NULL,
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL,
  PRIMARY KEY (`idPenghargaan`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
INSERT INTO `pegawai_penghargaan` VALUES   ('1','1','2021','3333','1','1','2021-01-20 13:28:26',NULL,NULL,'1','2021-01-20 13:31:26');
INSERT INTO `pegawai_penghargaan` VALUES ('2','1','1115','sss','1','1','2021-01-20 13:28:41',NULL,NULL,'1','2021-01-20 13:31:33');
INSERT INTO `pegawai_penghargaan` VALUES ('3','1','2021','','1','1','2021-01-20 13:28:41',NULL,NULL,'1','2021-01-20 13:38:35');
INSERT INTO `pegawai_penghargaan` VALUES ('4','1','2029','222','1','1','2021-01-20 13:29:30',NULL,NULL,'1','2021-01-20 13:38:17');
INSERT INTO `pegawai_penghargaan` VALUES ('5','1','2030','1111','1','1','2021-01-20 13:38:28',NULL,NULL,'1','2021-01-20 13:38:32');
INSERT INTO `pegawai_penghargaan` VALUES ('6','1','2029','34567','0','1','2021-01-20 13:38:28',NULL,NULL,NULL,NULL);

/*---------------------------------------------------------------
  TABLE: `pegawai_seminar`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `pegawai_seminar`;
CREATE TABLE `pegawai_seminar` (
  `idSeminar` int(11) NOT NULL AUTO_INCREMENT,
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
  `ddate` datetime DEFAULT NULL,
  PRIMARY KEY (`idSeminar`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
INSERT INTO `pegawai_seminar` VALUES   ('1','1','2021-01-08','0000-00-00','PPP','33','1','1','2021-01-20 10:53:09',NULL,NULL,'1','2021-01-20 10:56:41');
INSERT INTO `pegawai_seminar` VALUES ('2','1','2021-01-16','2021-01-21','asdsad','asdsadsad','0','1','2021-01-20 10:54:35',NULL,NULL,NULL,NULL);
INSERT INTO `pegawai_seminar` VALUES ('3','1','2021-01-09','2021-01-29','ssss','wwww','1','1','2021-01-20 10:54:35',NULL,NULL,'1','2021-01-20 12:39:38');
INSERT INTO `pegawai_seminar` VALUES ('4','1','2021-01-08','2021-01-23','11','22','1','1','2021-01-20 12:40:42',NULL,NULL,'1','2021-01-25 01:11:58');
INSERT INTO `pegawai_seminar` VALUES ('5','1','2021-01-16','2021-01-26','222','333','1','1','2021-01-20 12:40:42',NULL,NULL,'1','2021-01-20 12:45:43');
INSERT INTO `pegawai_seminar` VALUES ('6','1','2021-01-23','2021-01-30','12','1212','1','1','2021-01-20 13:34:43',NULL,NULL,'1','2021-01-20 13:34:48');
INSERT INTO `pegawai_seminar` VALUES ('7','1','2021-01-30','2021-01-22','13','1313','0','1','2021-01-20 13:34:43',NULL,NULL,NULL,NULL);

/*---------------------------------------------------------------
  TABLE: `pos_bayar`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `pos_bayar`;
CREATE TABLE `pos_bayar` (
  `idPosBayar` int(5) NOT NULL AUTO_INCREMENT,
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
  `ddate` datetime DEFAULT NULL,
  PRIMARY KEY (`idPosBayar`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
INSERT INTO `pos_bayar` VALUES   ('1','21','32','SPP SMP','SPP SMP','0','1','2021-01-28 19:15:24',NULL,NULL,NULL,NULL);
INSERT INTO `pos_bayar` VALUES ('2','36','33','SPP SMA','SPP SMA','1','1','2021-01-28 19:15:40',NULL,NULL,'1','2021-02-02 16:31:50');
INSERT INTO `pos_bayar` VALUES ('3','46','34','SPP Tahfidz','SPP Tahfidz','0','1','2021-01-28 19:18:50',NULL,NULL,NULL,NULL);
INSERT INTO `pos_bayar` VALUES ('4','22','32','Daftar Ulang smt-1 SMP','Daftar Ulang smt-1 SMP','0','1','2021-01-28 19:19:36',NULL,NULL,NULL,NULL);
INSERT INTO `pos_bayar` VALUES ('5','37','33','Daftar Ulang smt-1 SMA','Daftar Ulang smt-1 SMA','0','1','2021-01-28 19:19:55',NULL,NULL,NULL,NULL);
INSERT INTO `pos_bayar` VALUES ('6','23','32','Daftar Ulang smt-2 SMP','Daftar Ulang smt-2 SMP','0','1','2021-01-28 19:20:13',NULL,NULL,NULL,NULL);
INSERT INTO `pos_bayar` VALUES ('7','26','32','Tunggakan SPP','Tunggakan SPP','0','1','2021-01-28 19:20:37',NULL,NULL,NULL,NULL);
INSERT INTO `pos_bayar` VALUES ('8','48','34','DU Santri Baru','DU Santri Baru','0','1','2021-01-28 19:21:37',NULL,NULL,NULL,NULL);
INSERT INTO `pos_bayar` VALUES ('9','49','34','Tunggakan SPP','Tunggakan SPP','0','1','2021-01-28 19:21:54',NULL,NULL,NULL,NULL);
INSERT INTO `pos_bayar` VALUES ('10','38','33','Daftar Ulang smt-2 SMA','Daftar Ulang smt-2 SMA','0','1','2021-01-28 19:22:09',NULL,NULL,NULL,NULL);
INSERT INTO `pos_bayar` VALUES ('11','41','33','Tunggakan SPP','Tunggakan SPP','0','1','2021-01-28 19:22:28',NULL,NULL,NULL,NULL);
INSERT INTO `pos_bayar` VALUES ('12','27','32','Sarana Santri Baru','Sarana SPP','0','1','2021-01-28 19:23:03',NULL,NULL,NULL,NULL);
INSERT INTO `pos_bayar` VALUES ('13','42','33','Sarana Santri Baru','Sarana SPP','0','1','2021-01-28 19:23:23',NULL,NULL,NULL,NULL);
INSERT INTO `pos_bayar` VALUES ('14','43','33','Iuran Pengobatan','Iuran Pengobatan Rozi','0','1','2021-01-28 19:23:49',NULL,NULL,NULL,NULL);
INSERT INTO `pos_bayar` VALUES ('15','28','32','Kitab Santri Baru','Kitab SMP','0','1','2021-01-28 19:24:13',NULL,NULL,NULL,NULL);
INSERT INTO `pos_bayar` VALUES ('16','44','33','Kitab Santri Baru','Kitab SMA','0','1','2021-01-28 19:24:31',NULL,NULL,NULL,NULL);
INSERT INTO `pos_bayar` VALUES ('17','22','32','sss','sss','1','1','2021-02-02 16:30:48',NULL,NULL,'1','2021-02-02 16:31:44');
INSERT INTO `pos_bayar` VALUES ('18','36','33','SPP SMA','SPP SMA','0','1','2021-02-09 12:49:56',NULL,NULL,NULL,NULL);
INSERT INTO `pos_bayar` VALUES ('19','21','32','SPP SMP','SPP SMP','1','1','2021-02-14 02:09:30',NULL,NULL,'1','2021-02-14 02:12:20');
INSERT INTO `pos_bayar` VALUES ('20','46','34','SPP TAHFIDZ','BEBAS','0','1','2021-03-26 10:30:36',NULL,NULL,NULL,NULL);

/*---------------------------------------------------------------
  TABLE: `ref`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `ref`;
CREATE TABLE `ref` (
  `ref_id` int(10) NOT NULL AUTO_INCREMENT,
  `ref_val` varchar(100) NOT NULL,
  `ref_date` date NOT NULL,
  `ref_stat` int(10) NOT NULL,
  `ref_pay` varchar(100) NOT NULL,
  PRIMARY KEY (`ref_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*---------------------------------------------------------------
  TABLE: `siswa`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `siswa`;
CREATE TABLE `siswa` (
  `idSiswa` int(10) NOT NULL AUTO_INCREMENT,
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
  `ddate` datetime DEFAULT NULL,
  PRIMARY KEY (`idSiswa`),
  KEY `fk_status` (`statusSiswa`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;
INSERT INTO `siswa` VALUES   ('24','201706001','','Sofie Giska Nuraudila','','','0000-00-00',NULL,'Jalan Klengkeng RT 01 RW 02 Desa Kecamatan Blora Jateng',NULL,'1','2','1','Aktif','','Abdullah','082194273124','e10adc3949ba59abbe56e057f20f883e','0','0','1','2021-02-18 22:38:51','1','2021-02-19 12:13:07',NULL,NULL);
INSERT INTO `siswa` VALUES ('26','201788775',NULL,'AA',NULL,NULL,'0000-00-00',NULL,'OK',NULL,'1','2','0','Aktif',NULL,'','08777','e10adc3949ba59abbe56e057f20f883e','0','0','1','2021-02-18 22:38:51',NULL,NULL,NULL,NULL);
INSERT INTO `siswa` VALUES ('27','201788776',NULL,'BB',NULL,NULL,'0000-00-00',NULL,'SIP',NULL,'1','2','0','Aktif',NULL,'','02222','e10adc3949ba59abbe56e057f20f883e','0','0','1','2021-02-18 22:38:51',NULL,NULL,NULL,NULL);
INSERT INTO `siswa` VALUES ('28','201788777',NULL,'CC',NULL,NULL,'0000-00-00',NULL,'APA',NULL,'1','2','0','Aktif',NULL,'','011111','e10adc3949ba59abbe56e057f20f883e','0','0','1','2021-02-18 22:38:51',NULL,NULL,NULL,NULL);
INSERT INTO `siswa` VALUES ('29','201788778','','DD','','','0000-00-00',NULL,'SIAPA','download.jpg','5','22','0','Aktif','','','5555','e10adc3949ba59abbe56e057f20f883e','0','0','1','2021-02-18 22:38:51','1','2021-02-19 12:25:54',NULL,NULL);
INSERT INTO `siswa` VALUES ('30','1111','','sdasdasd','','','0000-00-00',NULL,'',NULL,'1','15','0','Aktif','','','222222','e10adc3949ba59abbe56e057f20f883e','0','0','1','2021-02-19 12:08:10','1','2021-02-20 01:22:41',NULL,NULL);
INSERT INTO `siswa` VALUES ('31','www','','ddd','','','0000-00-00',NULL,'',NULL,'1','12','0','Tidak Aktif','','','','e10adc3949ba59abbe56e057f20f883e','0','0','1','2021-02-19 14:05:16',NULL,NULL,NULL,NULL);
INSERT INTO `siswa` VALUES ('32','12222','','222','','','0000-00-00',NULL,'',NULL,'1','7','0','Aktif','','','11111','e10adc3949ba59abbe56e057f20f883e','0','0','1','2021-02-19 14:06:49','1','2021-02-19 14:14:02',NULL,NULL);
INSERT INTO `siswa` VALUES ('33','22222','','sdasdsadsad','','','0000-00-00',NULL,'',NULL,'5','23','0','Aktif','','','1234567890','e10adc3949ba59abbe56e057f20f883e','0','0','1','2021-02-19 14:14:16','1','2021-02-21 22:41:56',NULL,NULL);

/*---------------------------------------------------------------
  TABLE: `siswa_kesehatan`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `siswa_kesehatan`;
CREATE TABLE `siswa_kesehatan` (
  `idKesehatan` int(11) NOT NULL AUTO_INCREMENT,
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
  `ddate` datetime DEFAULT NULL,
  PRIMARY KEY (`idKesehatan`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;
INSERT INTO `siswa_kesehatan` VALUES   ('1','3','23','2021-01-23','dsfdsf','223dfdsfdsf','3d','1','1','2021-01-23 17:51:32',NULL,NULL,'1','2021-01-23 17:51:41');
INSERT INTO `siswa_kesehatan` VALUES ('2','2','23','2021-01-21','333','ddd','333','0','1','2021-01-23 17:54:39',NULL,NULL,NULL,NULL);
INSERT INTO `siswa_kesehatan` VALUES ('3','3','23','2021-01-30','333','444','2222','0','1','2021-01-23 18:15:23',NULL,NULL,NULL,NULL);
INSERT INTO `siswa_kesehatan` VALUES ('4','3','23','2021-01-28','333','223dfdsfdsf','2222','1','1','2021-01-23 18:15:35',NULL,NULL,'1','2021-01-23 18:16:30');
INSERT INTO `siswa_kesehatan` VALUES ('5','201706004','4','2021-01-29','333','223dfdsfdsf','2222','0','1','2021-01-24 14:57:29',NULL,NULL,NULL,NULL);
INSERT INTO `siswa_kesehatan` VALUES ('6','3','4','2021-01-30','dsfdsf','223dfdsfdsf','sdf','0','1','2021-01-24 15:20:09',NULL,NULL,NULL,NULL);
INSERT INTO `siswa_kesehatan` VALUES ('7','201706003','4','2021-01-30','333','3333','33333','1','1','2021-01-24 15:27:29',NULL,NULL,'1','2021-01-24 15:37:39');
INSERT INTO `siswa_kesehatan` VALUES ('8','201706003','4','2021-01-23','Pusing','Paramex','Harus Istirahat 2 Hari 19 September 2020 sampai dengan 21 September 2020','0','1','2021-01-24 15:38:07',NULL,NULL,NULL,NULL);
INSERT INTO `siswa_kesehatan` VALUES ('9','6','4','2021-01-30','Pusing','ddd','33333','0','1','2021-01-24 16:15:37',NULL,NULL,NULL,NULL);
INSERT INTO `siswa_kesehatan` VALUES ('10','38','3','2021-04-21','Batuk Pilek','Amoxilin','Sakitnya Ringan','0','1','2021-04-21 04:20:40',NULL,NULL,NULL,NULL);

/*---------------------------------------------------------------
  TABLE: `siswa_konseling`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `siswa_konseling`;
CREATE TABLE `siswa_konseling` (
  `idKonseling` int(11) NOT NULL AUTO_INCREMENT,
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
  `ddate` datetime DEFAULT NULL,
  PRIMARY KEY (`idKonseling`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
INSERT INTO `siswa_konseling` VALUES   ('1','6','0','0000-00-00','','','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `siswa_konseling` VALUES ('2','6','23','2021-01-29','','','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `siswa_konseling` VALUES ('3','6','23','2021-01-30','23423432','123','3','',NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `siswa_konseling` VALUES ('4','6','23','2021-01-30','fffff','123','2','11','0','1','2021-01-23 18:50:21',NULL,NULL,NULL,NULL);
INSERT INTO `siswa_konseling` VALUES ('5','6','23','2021-01-29','23423432','123','7','ok','0','1','2021-01-23 18:55:11',NULL,NULL,NULL,NULL);
INSERT INTO `siswa_konseling` VALUES ('6','2','4','2021-01-02','111','123','5','11','1','1','2021-01-24 16:14:18',NULL,NULL,'1','2021-01-24 16:15:08');
INSERT INTO `siswa_konseling` VALUES ('7','3','3','2021-02-16','2','123','1','222','1','1','2021-02-16 01:40:22',NULL,NULL,'1','2021-02-16 01:40:27');
INSERT INTO `siswa_konseling` VALUES ('8','3','3','2021-02-16','ABC','OOO','1','APAAJA','0','1','2021-02-16 14:33:07',NULL,NULL,NULL,NULL);
INSERT INTO `siswa_konseling` VALUES ('9','38','3','2021-04-21','Merokok','Di cukur gundul','50','Sempat menolak ketika di cukur','0','1','2021-04-21 04:25:42',NULL,NULL,NULL,NULL);

/*---------------------------------------------------------------
  TABLE: `siswa_tahfidz`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `siswa_tahfidz`;
CREATE TABLE `siswa_tahfidz` (
  `idTahfidz` int(11) NOT NULL AUTO_INCREMENT,
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
  `ddate` datetime DEFAULT NULL,
  PRIMARY KEY (`idTahfidz`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;
INSERT INTO `siswa_tahfidz` VALUES   ('1','3','23','2021-01-23','2','QS. Al-Baqoroh Ayat 25-29','Juz 30 (QS. Al-Inshiqoq` s/d QS. Ad-Dhuha)','QS. Al-Baqoroh Ayat 17-24','1','1','2021-01-23 16:15:21',NULL,NULL,'1','2021-01-23 16:25:25');
INSERT INTO `siswa_tahfidz` VALUES ('2','3','23','2021-01-23','2','QS. Al-Baqoroh Ayat 25-29','Juz 30 (QS. Al-Inshiqoq` s/d QS. Ad-Dhuha)','QS. Al-Baqoroh Ayat 17-24','1','1','2021-01-23 16:26:12',NULL,NULL,'1','2021-01-23 16:27:33');
INSERT INTO `siswa_tahfidz` VALUES ('3','3','23','2021-01-23','1','ddd','ddd','ddd','1','1','2021-01-23 16:27:00',NULL,NULL,'1','2021-01-23 16:35:25');
INSERT INTO `siswa_tahfidz` VALUES ('4','3','23','2021-01-30','12','QS. Al-Baqoroh Ayat 25-29','Juz 30 (QS. Al-Inshiqoq` s/d QS. Ad-Dhuha)','QS. Al-Baqoroh Ayat 17-24','0','1','2021-01-23 16:35:38',NULL,NULL,NULL,NULL);
INSERT INTO `siswa_tahfidz` VALUES ('5','6','23','2021-01-23','1','QS. Al-Baqoroh Ayat 25-29','Juz 30 (QS. Al-Inshiqoq` s/d QS. Ad-Dhuha)','QS. Al-Baqoroh Ayat 17-24','1','1','2021-01-23 18:09:29',NULL,NULL,'1','2021-01-23 18:11:08');
INSERT INTO `siswa_tahfidz` VALUES ('6','6','23','2021-01-23','3','1','34','2','1','1','2021-01-23 18:10:12',NULL,NULL,'1','2021-01-23 18:11:32');
INSERT INTO `siswa_tahfidz` VALUES ('7','6','23','2021-01-23','2','QS. Al-Baqoroh Ayat 25-29','Juz 30 (QS. Al-Inshiqoq` s/d QS. Ad-Dhuha)','QS. Al-Baqoroh Ayat 17-24','1','1','2021-01-23 18:11:26',NULL,NULL,'1','2021-01-23 18:12:53');
INSERT INTO `siswa_tahfidz` VALUES ('8','6','23','2021-01-21','2','342435','345345345','435435345','1','1','2021-01-23 18:12:46',NULL,NULL,'1','2021-01-23 18:14:22');
INSERT INTO `siswa_tahfidz` VALUES ('9','6','23','2021-01-30','26','QS. Al-Baqoroh Ayat 25-29','Juz 30 (QS. Al-Inshiqoq` s/d QS. Ad-Dhuha)','QS. Al-Baqoroh Ayat 17-24','1','1','2021-01-23 18:13:14',NULL,NULL,'1','2021-01-23 18:14:27');
INSERT INTO `siswa_tahfidz` VALUES ('10','6','4','2021-01-30','3','QS. Al-Baqoroh Ayat 25-29','Juz 30 (QS. Al-Inshiqoq` s/d QS. Ad-Dhuha)','QS. Al-Baqoroh Ayat 17-24','0','1','2021-01-24 14:05:16',NULL,NULL,NULL,NULL);
INSERT INTO `siswa_tahfidz` VALUES ('11','3','23','2021-01-30','2','ddd','ddd','ddd','0','1','2021-01-24 14:30:39',NULL,NULL,NULL,NULL);
INSERT INTO `siswa_tahfidz` VALUES ('12','2','3','2021-01-23','22','4','66','55','0','1','2021-01-27 01:44:11',NULL,NULL,NULL,NULL);
INSERT INTO `siswa_tahfidz` VALUES ('13','38','3','2021-04-21','20','Baru Hafal','19','18','0','1','2021-04-21 04:19:46',NULL,NULL,NULL,NULL);

/*---------------------------------------------------------------
  TABLE: `tabungan_siswa`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `tabungan_siswa`;
CREATE TABLE `tabungan_siswa` (
  `idTabungan` int(11) NOT NULL AUTO_INCREMENT,
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
  `ddate` datetime DEFAULT NULL,
  PRIMARY KEY (`idTabungan`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;
INSERT INTO `tabungan_siswa` VALUES   ('1','201706005','3','2021-01-29','SETORAN','10000','SIP','1','1','2021-01-25 23:19:44','1','2021-01-25 23:43:08','1','2021-01-25 23:56:56');
INSERT INTO `tabungan_siswa` VALUES ('2','201706005','3','2021-01-25','PENARIKAN','5000','ggg','0','1','2021-01-25 23:53:45','1','2021-01-25 23:54:31',NULL,NULL);
INSERT INTO `tabungan_siswa` VALUES ('3','201706005','3','2021-01-25','PENARIKAN','3333','','1','1','2021-01-25 23:54:40','1','2021-01-25 23:55:30','1','2021-01-25 23:57:00');
INSERT INTO `tabungan_siswa` VALUES ('4','201706005','3','2021-01-25','PENARIKAN','50000','4','0','1','2021-01-25 23:55:09',NULL,NULL,NULL,NULL);
INSERT INTO `tabungan_siswa` VALUES ('5','201706005','3','2021-01-25','SETORAN','100000','ABC','0','1','2021-01-25 23:57:13',NULL,NULL,NULL,NULL);
INSERT INTO `tabungan_siswa` VALUES ('6','201706005','3','2021-01-26','SETORAN','20000','sad','0','1','2021-01-26 00:09:15',NULL,NULL,NULL,NULL);
INSERT INTO `tabungan_siswa` VALUES ('7','3','3','2021-02-11','SETORAN','100000','SIP','0','1','2021-02-11 08:00:58',NULL,NULL,NULL,NULL);
INSERT INTO `tabungan_siswa` VALUES ('8','3','3','2021-02-11','PENARIKAN','5000','4','0','1','2021-02-11 14:03:19',NULL,NULL,NULL,NULL);
INSERT INTO `tabungan_siswa` VALUES ('9','3','4','2021-02-11','SETORAN','100000','ABC','0','1','2021-02-11 14:51:08',NULL,NULL,NULL,NULL);
INSERT INTO `tabungan_siswa` VALUES ('10','2','3','2021-02-14','SETORAN','100000','1','0','1','2021-02-14 01:12:48',NULL,NULL,NULL,NULL);

/*---------------------------------------------------------------
  TABLE: `tagihan_bebas`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `tagihan_bebas`;
CREATE TABLE `tagihan_bebas` (
  `idTagihanBebas` int(50) NOT NULL AUTO_INCREMENT,
  `idJenisBayar` int(5) DEFAULT NULL,
  `idSiswa` int(10) DEFAULT NULL,
  `idKelas` int(5) DEFAULT NULL,
  `totalTagihan` int(10) DEFAULT NULL,
  `ref` varchar(100) DEFAULT NULL,
  `statusBayar` enum('0','1','2') DEFAULT '0',
  `TglTagihan` datetime DEFAULT NULL,
  `tglUpdate` datetime DEFAULT NULL,
  PRIMARY KEY (`idTagihanBebas`),
  KEY `fk_t_jenis` (`idJenisBayar`),
  KEY `fk_t_siswa` (`idSiswa`),
  KEY `fk_t_kelas` (`idKelas`),
  CONSTRAINT `tagihan_bebas_ibfk_2` FOREIGN KEY (`idJenisBayar`) REFERENCES `jenis_bayar` (`idJenisBayar`) ON UPDATE CASCADE,
  CONSTRAINT `tagihan_bebas_ibfk_3` FOREIGN KEY (`idKelas`) REFERENCES `kelas_siswa` (`idKelas`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
INSERT INTO `tagihan_bebas` VALUES   ('1','2','25','2','300000','REF20210416011359-1','1','2021-04-16 01:13:07',NULL);
INSERT INTO `tagihan_bebas` VALUES ('2','2','38','2','200000','REF20210417153304-1','1','2021-04-17 15:16:23',NULL);

/*---------------------------------------------------------------
  TABLE: `tagihan_bebas_bayar`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `tagihan_bebas_bayar`;
CREATE TABLE `tagihan_bebas_bayar` (
  `idTagihanBebasBayar` int(50) NOT NULL AUTO_INCREMENT,
  `idTagihanBebas` int(50) DEFAULT NULL,
  `noRefrensi` varchar(100) DEFAULT NULL,
  `tglBayar` datetime DEFAULT NULL,
  `tglBayarSementara` datetime DEFAULT NULL,
  `jumlahBayar` int(10) DEFAULT NULL,
  `idAkunKas` int(11) DEFAULT NULL,
  `ketBebas` varchar(100) DEFAULT NULL,
  `statusKas` int(11) DEFAULT '0',
  PRIMARY KEY (`idTagihanBebasBayar`),
  KEY `fkbayarbebas` (`idTagihanBebas`),
  CONSTRAINT `fkbayarbebas` FOREIGN KEY (`idTagihanBebas`) REFERENCES `tagihan_bebas` (`idTagihanBebas`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
INSERT INTO `tagihan_bebas_bayar` VALUES   ('1','1','SPTahfidz20175566716042105','2021-04-16 01:14:28','2021-04-16 01:14:28','300000','76','transfer bank midtrans','0');
INSERT INTO `tagihan_bebas_bayar` VALUES ('2','2','SPTahfidz11122233317042103','2021-04-17 15:33:19','2021-04-17 15:33:19','100000','76','transfer bank midtrans','0');

/*---------------------------------------------------------------
  TABLE: `tagihan_bulanan`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `tagihan_bulanan`;
CREATE TABLE `tagihan_bulanan` (
  `idTagihanBulanan` int(50) NOT NULL AUTO_INCREMENT,
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
  `statusKas` int(11) DEFAULT '0',
  PRIMARY KEY (`idTagihanBulanan`),
  KEY `fk_t_jenis` (`idJenisBayar`),
  KEY `fk_t_siswa` (`idSiswa`),
  KEY `fk_t_kelas` (`idKelas`),
  KEY `fk_t_bulan` (`idBulan`),
  CONSTRAINT `fk_t_bulan` FOREIGN KEY (`idBulan`) REFERENCES `bulan` (`idBulan`) ON UPDATE CASCADE,
  CONSTRAINT `fk_t_jenis` FOREIGN KEY (`idJenisBayar`) REFERENCES `jenis_bayar` (`idJenisBayar`) ON UPDATE CASCADE,
  CONSTRAINT `fk_t_kelas` FOREIGN KEY (`idKelas`) REFERENCES `kelas_siswa` (`idKelas`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
INSERT INTO `tagihan_bulanan` VALUES   ('1','1','25','2','7','50000','2021-04-16 01:52:54','2021-04-17 05:15:01',NULL,NULL,'2','INV20210417051442-1',NULL,'75','0');
INSERT INTO `tagihan_bulanan` VALUES ('2','1','25','2','8','50000','2021-04-16 01:52:54','2021-04-18 05:25:16','2021-04-18 00:00:00',NULL,'2','INV20210417051154-1','SPTahfidz20175566718042105','0','0');
INSERT INTO `tagihan_bulanan` VALUES ('3','1','25','2','9','55000','2021-04-16 01:52:54','2021-04-16 01:56:37',NULL,NULL,'0','INV20210416015609-1',NULL,'75','0');
INSERT INTO `tagihan_bulanan` VALUES ('4','1','25','2','10','55000','2021-04-16 01:52:54','2021-04-16 01:56:37',NULL,NULL,'0','INV20210416015609-1',NULL,'75','0');
INSERT INTO `tagihan_bulanan` VALUES ('5','1','25','2','11','55000','2021-04-16 01:52:54','2021-04-16 01:56:37',NULL,NULL,'2','INV20210416015609-1',NULL,'75','0');
INSERT INTO `tagihan_bulanan` VALUES ('6','1','25','2','12','55000','2021-04-16 01:52:54','2021-04-17 03:37:55',NULL,NULL,'2','INV20210417033623-1',NULL,'75','0');
INSERT INTO `tagihan_bulanan` VALUES ('7','1','25','2','1','55000','2021-04-16 01:52:54','2021-04-17 04:27:12',NULL,NULL,'2','INV20210417042638-1',NULL,'75','0');
INSERT INTO `tagihan_bulanan` VALUES ('8','1','25','2','2','55000','2021-04-16 01:52:54','2021-04-17 04:35:57',NULL,NULL,'2','INV20210417043351-1',NULL,'75','0');
INSERT INTO `tagihan_bulanan` VALUES ('9','1','25','2','3','50000','2021-04-16 01:52:54','2021-04-17 04:45:03',NULL,NULL,'2','INV20210417043553-1',NULL,'75','0');
INSERT INTO `tagihan_bulanan` VALUES ('10','1','25','2','4','50000','2021-04-16 01:52:54','2021-04-17 04:59:27',NULL,NULL,'2','INV20210417045840-1',NULL,'75','0');
INSERT INTO `tagihan_bulanan` VALUES ('11','1','25','2','5','50000','2021-04-16 01:52:54','2021-04-17 05:01:27',NULL,NULL,'2','INV20210417050103-1',NULL,'75','0');
INSERT INTO `tagihan_bulanan` VALUES ('12','1','25','2','6','50000','2021-04-16 01:52:54','2021-04-17 05:03:43',NULL,NULL,'2','INV20210417050317-1',NULL,'75','0');
INSERT INTO `tagihan_bulanan` VALUES ('13','1','38','2','7','200000','2021-04-17 15:16:49','2021-04-17 17:45:39',NULL,NULL,'2','INV20210417151718-1',NULL,'75','0');
INSERT INTO `tagihan_bulanan` VALUES ('14','1','38','2','8','200000','2021-04-17 15:16:49','2021-04-21 13:25:25','2021-04-21 00:00:00',NULL,'2',NULL,'SPTahfidz11122233321042103','0','0');
INSERT INTO `tagihan_bulanan` VALUES ('15','1','38','2','9','200000','2021-04-17 15:16:49','2021-04-17 18:30:45',NULL,NULL,'2','INV20210417161805-1',NULL,'75','0');
INSERT INTO `tagihan_bulanan` VALUES ('16','1','38','2','10','200000','2021-04-17 15:16:49','2021-04-18 11:17:37',NULL,NULL,'2','INV20210418111004-1',NULL,'75','0');
INSERT INTO `tagihan_bulanan` VALUES ('17','1','38','2','11','200000','2021-04-17 15:16:49','2021-04-18 11:17:37',NULL,NULL,'2','INV20210418111004-1',NULL,'75','0');
INSERT INTO `tagihan_bulanan` VALUES ('18','1','38','2','12','200000','2021-04-17 15:16:49','2021-04-21 13:55:57',NULL,NULL,'2','INV20210421112950-1',NULL,'75','0');
INSERT INTO `tagihan_bulanan` VALUES ('19','1','38','2','1','200000','2021-04-17 15:16:49','2021-04-21 13:55:57','2021-04-21 00:00:00',NULL,'2','INV20210421112950-1','SPTahfidz11122233321042103','75','0');
INSERT INTO `tagihan_bulanan` VALUES ('20','1','38','2','2','200000','2021-04-17 15:16:49','2021-04-21 13:55:57','2021-04-21 00:00:00',NULL,'2','INV20210421112950-1','SPTahfidz11122233321042103','75','0');
INSERT INTO `tagihan_bulanan` VALUES ('21','1','38','2','3','200000','2021-04-17 15:16:49','2021-04-21 13:38:20','2021-04-21 00:00:00',NULL,'2',NULL,'SPTahfidz11122233321042103','15','0');
INSERT INTO `tagihan_bulanan` VALUES ('22','1','38','2','4','200000','2021-04-17 15:16:49','2021-04-22 09:57:13','2021-04-22 00:00:00',NULL,'2',NULL,'SPTahfidz11122233322042103','15','0');
INSERT INTO `tagihan_bulanan` VALUES ('23','1','38','2','5','200000','2021-04-17 15:16:49','2021-04-22 10:00:47','2021-04-22 00:00:00',NULL,'2',NULL,'SPTahfidz11122233322042103','15','0');
INSERT INTO `tagihan_bulanan` VALUES ('24','1','38','2','6','200000','2021-04-17 15:16:49',NULL,NULL,NULL,'0',NULL,NULL,NULL,'0');

/*---------------------------------------------------------------
  TABLE: `tahun_ajaran`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `tahun_ajaran`;
CREATE TABLE `tahun_ajaran` (
  `idTahunAjaran` int(5) NOT NULL AUTO_INCREMENT,
  `nmTahunAjaran` varchar(9) DEFAULT NULL,
  `status` enum('Aktif','Tidak Aktif') DEFAULT NULL,
  `stdel` int(11) DEFAULT '0',
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL,
  PRIMARY KEY (`idTahunAjaran`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
INSERT INTO `tahun_ajaran` VALUES   ('3','2019/2020','Aktif','0',NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `tahun_ajaran` VALUES ('4','2020/2021','Tidak Aktif','0',NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `tahun_ajaran` VALUES ('5','2021/2022','Tidak Aktif','0',NULL,NULL,'1','2021-01-18 21:57:32',NULL,NULL);
INSERT INTO `tahun_ajaran` VALUES ('20','2029/2030','Tidak Aktif','1','1','2021-01-19 01:32:11','1','2021-01-19 01:32:32','1','2021-01-19 01:33:54');
INSERT INTO `tahun_ajaran` VALUES ('21','2022/2023','Tidak Aktif','1','1','2021-01-19 01:32:44',NULL,NULL,'1','2021-01-19 01:33:52');
INSERT INTO `tahun_ajaran` VALUES ('22','2046/2047','Tidak Aktif','1','1','2021-01-19 01:33:44',NULL,NULL,'1','2021-01-19 01:33:49');
INSERT INTO `tahun_ajaran` VALUES ('23','2022/2023','Tidak Aktif','0','1','2021-01-20 01:35:17',NULL,NULL,NULL,NULL);

/*---------------------------------------------------------------
  TABLE: `tb_tes`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `tb_tes`;
CREATE TABLE `tb_tes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `con` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;
INSERT INTO `tb_tes` VALUES   ('1','.250000>200000.');
INSERT INTO `tb_tes` VALUES ('2','tot =250000 sum = 0 pay = 200000 sisa = 50000');
INSERT INTO `tb_tes` VALUES ('3','.250000>200000.');
INSERT INTO `tb_tes` VALUES ('4','tot =250000 sum = 0 pay = 200000 sisa = 50000');
INSERT INTO `tb_tes` VALUES ('5','.250000>200000.');
INSERT INTO `tb_tes` VALUES ('6','tot =250000 sum = 0 pay = 200000 sisa = 50000');
INSERT INTO `tb_tes` VALUES ('7','.0>50000.');
INSERT INTO `tb_tes` VALUES ('8','.50000>50000.');
INSERT INTO `tb_tes` VALUES ('9','tot =250000 sum = 200000 pay = 50000 sisa = 0');
INSERT INTO `tb_tes` VALUES ('10','.0>50000.');
INSERT INTO `tb_tes` VALUES ('11','.250000>250000.');
INSERT INTO `tb_tes` VALUES ('12','tot =250000 sum = 0 pay = 250000 sisa = 0');
INSERT INTO `tb_tes` VALUES ('13','.0>168000.');
INSERT INTO `tb_tes` VALUES ('14','.0>150000.');
INSERT INTO `tb_tes` VALUES ('15','.0>100000.');
INSERT INTO `tb_tes` VALUES ('16','.200000>100000.');
INSERT INTO `tb_tes` VALUES ('17','tot =200000 sum = 0 pay = 100000 sisa = 100000');
INSERT INTO `tb_tes` VALUES ('18','.0>100000.');
INSERT INTO `tb_tes` VALUES ('19','.0>155000.');
INSERT INTO `tb_tes` VALUES ('20','.0>160000.');
INSERT INTO `tb_tes` VALUES ('21','tot =200000 sum = 100000 pay = 100000 sisa = 0');
INSERT INTO `tb_tes` VALUES ('22','tot =250000 sum = 0 pay = 250000 sisa = 0');
INSERT INTO `tb_tes` VALUES ('23','tot =200000 sum = 0 pay = 100000 sisa = 100000');
INSERT INTO `tb_tes` VALUES ('24','tot =200000 sum = 0 pay = 50000 sisa = 150000');
INSERT INTO `tb_tes` VALUES ('25','tot =300000 sum = 0 pay = 300000 sisa = 0');
INSERT INTO `tb_tes` VALUES ('26','tot =200000 sum = 0 pay = 100000 sisa = 100000');
INSERT INTO `tb_tes` VALUES ('27','tot =200000 sum = 100000 pay = 100000 sisa = 0');
INSERT INTO `tb_tes` VALUES ('28','tot =200000 sum = 200000 pay = 100000 sisa = -100000');
INSERT INTO `tb_tes` VALUES ('29','tot =200000 sum = 300000 pay = 100000 sisa = -200000');
INSERT INTO `tb_tes` VALUES ('30','tot =200000 sum = 400000 pay = 100000 sisa = -300000');
INSERT INTO `tb_tes` VALUES ('31','tot =200000 sum = 500000 pay = 100000 sisa = -400000');

/*---------------------------------------------------------------
  TABLE: `transaksi`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `transaksi`;
CREATE TABLE `transaksi` (
  `id_transaksi` varchar(50) NOT NULL,
  `idSiswa` varchar(50) NOT NULL,
  `tanggal` date NOT NULL,
  `debit` int(10) NOT NULL,
  `kredit` int(10) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  PRIMARY KEY (`id_transaksi`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*---------------------------------------------------------------
  TABLE: `transaksi_pembayaran`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `transaksi_pembayaran`;
CREATE TABLE `transaksi_pembayaran` (
  `idTransaksiBayar` int(11) NOT NULL AUTO_INCREMENT,
  `noRefrensi` varchar(100) DEFAULT NULL,
  `idAkunKas` int(11) DEFAULT NULL,
  `idSiswa` int(11) DEFAULT NULL,
  `idTahunAjaran` int(11) DEFAULT NULL,
  PRIMARY KEY (`idTransaksiBayar`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8mb4;
INSERT INTO `transaksi_pembayaran` VALUES   ('73','SPTahfidz3333314022101','15','3','3');
INSERT INTO `transaksi_pembayaran` VALUES ('74','SPSMP-TMI222214022101','7','2','3');
INSERT INTO `transaksi_pembayaran` VALUES ('75','SPTahfidz111114022101','15','1','3');
INSERT INTO `transaksi_pembayaran` VALUES ('76','SPTahfidz111114022101','15','1','3');
INSERT INTO `transaksi_pembayaran` VALUES ('77','SPTahfidz20175566718022101','15','25','4');
INSERT INTO `transaksi_pembayaran` VALUES ('78','SPTahfidz20175566718022102','15','25','3');
INSERT INTO `transaksi_pembayaran` VALUES ('79','SPTahfidz20175566718022102','15','25','3');
INSERT INTO `transaksi_pembayaran` VALUES ('80','SPTahfidz20175566719022103','15','25','3');
INSERT INTO `transaksi_pembayaran` VALUES ('81','SPTahfidz20175566719022104','15','25','4');
INSERT INTO `transaksi_pembayaran` VALUES ('82','SPSMP-TMI20178877823022101','7','29','3');
INSERT INTO `transaksi_pembayaran` VALUES ('83','SPSMP-TMI20178877823022102','7','29','3');
INSERT INTO `transaksi_pembayaran` VALUES ('84','SPTahfidz20175566709042105','15','25','3');
INSERT INTO `transaksi_pembayaran` VALUES ('85','SPTahfidz20178877710042101','16','28','3');
INSERT INTO `transaksi_pembayaran` VALUES ('86','SPTahfidz20175566710042105','15','25','3');
INSERT INTO `transaksi_pembayaran` VALUES ('87','SPTahfidz20175566710042105','15','25','3');
INSERT INTO `transaksi_pembayaran` VALUES ('88','SPTahfidz20175566710042105','15','25','3');
INSERT INTO `transaksi_pembayaran` VALUES ('89','SPTahfidz20175566710042105','15','25','3');
INSERT INTO `transaksi_pembayaran` VALUES ('90','SPTahfidz11223311042101','15','37','3');
INSERT INTO `transaksi_pembayaran` VALUES ('91','SPTahfidz11223311042102','15','37','3');
INSERT INTO `transaksi_pembayaran` VALUES ('92','SPTahfidz11223311042103','15','37','3');
INSERT INTO `transaksi_pembayaran` VALUES ('93','SPTahfidz11223311042104','15','37','3');
INSERT INTO `transaksi_pembayaran` VALUES ('94','SPTahfidz11223311042105','15','37','3');
INSERT INTO `transaksi_pembayaran` VALUES ('95','SPTahfidz11223314042106','15','37','3');
INSERT INTO `transaksi_pembayaran` VALUES ('96','SPTahfidz11223314042107','15','37','3');
INSERT INTO `transaksi_pembayaran` VALUES ('97','SPTahfidz11223314042107','15','37','3');
INSERT INTO `transaksi_pembayaran` VALUES ('98','SPTahfidz11223314042108','15','37','3');
INSERT INTO `transaksi_pembayaran` VALUES ('99','SPTahfidz11122233314042101','15','38','3');
INSERT INTO `transaksi_pembayaran` VALUES ('100','SPTahfidz11223315042109','15','37','3');
INSERT INTO `transaksi_pembayaran` VALUES ('101','SPTahfidz11223315042110','15','37','3');
INSERT INTO `transaksi_pembayaran` VALUES ('102','SPTahfidz11122233317042102','15','38','3');

/*---------------------------------------------------------------
  TABLE: `unit_pos`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `unit_pos`;
CREATE TABLE `unit_pos` (
  `idUnitPos` int(11) NOT NULL AUTO_INCREMENT,
  `nmUnitPos` varchar(50) NOT NULL,
  `unitSekolah` int(11) NOT NULL,
  `stdel` int(11) DEFAULT '0',
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL,
  PRIMARY KEY (`idUnitPos`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
INSERT INTO `unit_pos` VALUES   ('1','0','1','1','1','2021-01-28 16:38:23',NULL,NULL,'1','2021-01-28 16:39:18');
INSERT INTO `unit_pos` VALUES ('2','122','6','0','1','2021-01-28 16:38:23','1','2021-01-28 16:41:53',NULL,NULL);
INSERT INTO `unit_pos` VALUES ('3','ABC','5','0','1','2021-01-28 16:38:50',NULL,NULL,NULL,NULL);

/*---------------------------------------------------------------
  TABLE: `unit_sekolah`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `unit_sekolah`;
CREATE TABLE `unit_sekolah` (
  `idUnit` int(11) NOT NULL AUTO_INCREMENT,
  `namaUnit` varchar(100) DEFAULT NULL,
  `singkatanUnit` varchar(100) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `stdel` int(11) DEFAULT NULL,
  `cby` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `udate` datetime DEFAULT NULL,
  `dby` int(11) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL,
  PRIMARY KEY (`idUnit`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
INSERT INTO `unit_sekolah` VALUES   ('1','Tahfidzul Quran','Tahfidz','1','0','1','2021-01-16 10:37:37',NULL,NULL,NULL,NULL);
INSERT INTO `unit_sekolah` VALUES ('2','Madrasah Diniyah','Madin','0','0','1','2021-01-16 10:37:50','1','2021-01-20 00:17:46',NULL,NULL);
INSERT INTO `unit_sekolah` VALUES ('3','Pondok Putra','PONPESPA','0','0','1','2021-01-16 10:38:19',NULL,NULL,NULL,NULL);
INSERT INTO `unit_sekolah` VALUES ('4','Pondok Putri','PONPESPI','0','0','1','2021-01-16 10:38:32',NULL,NULL,NULL,NULL);
INSERT INTO `unit_sekolah` VALUES ('5','Sekolah Menengah Pertama','SMP-TMI','1','0','1','2021-01-16 10:38:43','1','2021-01-16 10:38:52',NULL,NULL);
INSERT INTO `unit_sekolah` VALUES ('6','Sekolah Menengah Atas','SMA-TMI','1','0','1','2021-01-16 10:39:05','1','2021-01-16 10:47:07',NULL,NULL);
INSERT INTO `unit_sekolah` VALUES ('7','Sekolah Tinggi Agama Islam','STAI','0','0','1','2021-01-16 10:39:22','1','2021-01-19 01:44:04',NULL,NULL);
INSERT INTO `unit_sekolah` VALUES ('8','sadsad','sdasd','0','1','1','2021-01-16 10:48:01',NULL,NULL,'1','2021-01-16 10:48:04');
INSERT INTO `unit_sekolah` VALUES ('9','asdsad','asdsad','1','1','1','2021-01-17 17:33:01','1','2021-01-17 17:33:07','1','2021-01-17 17:33:12');
INSERT INTO `unit_sekolah` VALUES ('10','adsd','adsad','0','1','1','2021-01-17 17:38:39','1','2021-01-17 17:39:02','1','2021-01-17 17:40:50');
INSERT INTO `unit_sekolah` VALUES ('11','Tahfidzul Quran','sadasd','0','1','1','2021-01-18 13:36:41',NULL,NULL,'1','2021-01-18 13:37:17');
INSERT INTO `unit_sekolah` VALUES ('12','asdsad','asdsadsad','1','1','1','2021-01-18 13:36:51','1','2021-01-18 13:37:07','1','2021-01-18 13:37:12');
INSERT INTO `unit_sekolah` VALUES ('13','sadasd','asdsadsad','1','1','1','2021-01-18 23:53:09',NULL,NULL,'1','2021-01-18 23:53:12');
INSERT INTO `unit_sekolah` VALUES ('14','asdsa','asddsad','0','1','0','2021-01-18 23:57:26',NULL,NULL,'1','2021-01-18 23:58:48');
INSERT INTO `unit_sekolah` VALUES ('15','asdsa','dsadsad','0','1','1','2021-01-18 23:58:53','1','2021-01-18 23:59:02','1','2021-01-18 23:59:10');
INSERT INTO `unit_sekolah` VALUES ('16','zzzz','zzzz','0','1','1','2021-01-19 01:42:55','1','2021-01-19 01:43:05','1','2021-01-19 01:43:09');
INSERT INTO `unit_sekolah` VALUES ('17','xxvvvv','wwwwww','0','1','1','2021-01-19 01:45:45','1','2021-01-19 01:46:04','1','2021-01-19 01:46:07');

/*---------------------------------------------------------------
  TABLE: `users`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `idUsers` int(11) NOT NULL AUTO_INCREMENT,
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
  `ddate` datetime DEFAULT NULL,
  PRIMARY KEY (`idUsers`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
INSERT INTO `users` VALUES   ('1','admin','admin@gmail.com','3920cc4f716e625754bb4c1b73bee4aa','1','0','ADMIN ADMIN','download.jpg','2021-04-23 09:09:07','0',NULL,NULL,'1','2021-04-23 09:24:56',NULL,NULL);
INSERT INTO `users` VALUES ('8','aa','aa@gmail.com','e10adc3949ba59abbe56e057f20f883e','2','0','MM',NULL,NULL,'1','1','2021-01-17 03:31:02',NULL,NULL,'1','2021-01-17 04:18:00');
INSERT INTO `users` VALUES ('9','asdsad','1234@gmail.com','e10adc3949ba59abbe56e057f20f883e','6','1','asdsadsad',NULL,NULL,'1','1','2021-01-17 03:35:20',NULL,NULL,'1','2021-01-17 04:18:04');
INSERT INTO `users` VALUES ('10','sadasd','a33@gmail.com','e10adc3949ba59abbe56e057f20f883e','2','0','sdsad',NULL,NULL,'1','1','2021-01-17 03:36:11',NULL,NULL,'1','2021-01-17 04:17:32');
INSERT INTO `users` VALUES ('11','sadsad','asdsadsa@gmail.com','e10adc3949ba59abbe56e057f20f883e','5','1','dfsadfsdf',NULL,NULL,'1','1','2021-01-17 03:43:35',NULL,NULL,'1','2021-01-17 03:46:35');
INSERT INTO `users` VALUES ('12','as','rr@gmail.com','e10adc3949ba59abbe56e057f20f883e','4','0','123456',NULL,NULL,'1','1','2021-01-17 03:44:48',NULL,NULL,'1','2021-01-17 03:46:33');
INSERT INTO `users` VALUES ('13','sadsad','theivhan@gmail.comsadsad','e10adc3949ba59abbe56e057f20f883e','7','5','sadasd',NULL,NULL,'1','1','2021-01-17 03:47:15',NULL,NULL,'1','2021-01-17 04:18:07');
INSERT INTO `users` VALUES ('14','asdsadasd','123123@gmail.com','e10adc3949ba59abbe56e057f20f883e','7','5','123456',NULL,NULL,'1','1','2021-01-17 03:49:02',NULL,NULL,'1','2021-01-17 04:18:11');
INSERT INTO `users` VALUES ('15','asdsad','uang@gmail.ss','e10adc3949ba59abbe56e057f20f883e','8','5','sadasd',NULL,'2021-02-23 16:42:20','0','1','2021-01-17 03:49:50','1','2021-04-23 09:25:47',NULL,NULL);
INSERT INTO `users` VALUES ('16','sadsad','theivhan@gmail.11','e10adc3949ba59abbe56e057f20f883e','7','1','sadasd',NULL,NULL,'1','1','2021-01-17 03:51:22',NULL,NULL,'1','2021-01-17 03:58:37');
INSERT INTO `users` VALUES ('17','pp','pp@gmail.com','e10adc3949ba59abbe56e057f20f883e','8','0','pp123456','3.PNG',NULL,'1','1','2021-01-17 03:52:28','1','2021-01-17 18:17:10','1','2021-01-17 18:26:34');
INSERT INTO `users` VALUES ('18','asdasd','11@gmail.com','e10adc3949ba59abbe56e057f20f883e','7','1','aaa',NULL,NULL,'1','1','2021-01-17 18:12:45',NULL,NULL,'1','2021-01-17 18:26:21');
INSERT INTO `users` VALUES ('19','1111','ksiswa@gmail.com','e10adc3949ba59abbe56e057f20f883e','5','1','sdsadsad',NULL,NULL,'0','1','2021-01-25 01:55:40','1','2021-04-23 09:25:27',NULL,NULL);

/*---------------------------------------------------------------
  TABLE: `users_hak_akses`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `users_hak_akses`;
CREATE TABLE `users_hak_akses` (
  `idHakAkses` int(11) NOT NULL AUTO_INCREMENT,
  `IdUsersLevel` int(11) NOT NULL,
  `idMenu` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`idHakAkses`)
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=latin1;
INSERT INTO `users_hak_akses` VALUES   ('1','1','1');
INSERT INTO `users_hak_akses` VALUES ('2','1','51');
INSERT INTO `users_hak_akses` VALUES ('3','1','52');
INSERT INTO `users_hak_akses` VALUES ('4','1','53');
INSERT INTO `users_hak_akses` VALUES ('5','1','54');
INSERT INTO `users_hak_akses` VALUES ('6','1','55');
INSERT INTO `users_hak_akses` VALUES ('7','1','56');
INSERT INTO `users_hak_akses` VALUES ('8','1','57');
INSERT INTO `users_hak_akses` VALUES ('9','1','17');
INSERT INTO `users_hak_akses` VALUES ('10','1','18');
INSERT INTO `users_hak_akses` VALUES ('11','1','19');
INSERT INTO `users_hak_akses` VALUES ('12','1','20');
INSERT INTO `users_hak_akses` VALUES ('13','1','21');
INSERT INTO `users_hak_akses` VALUES ('14','1','22');
INSERT INTO `users_hak_akses` VALUES ('18','1','2');
INSERT INTO `users_hak_akses` VALUES ('19','1','3');
INSERT INTO `users_hak_akses` VALUES ('20','1','4');
INSERT INTO `users_hak_akses` VALUES ('21','1','5');
INSERT INTO `users_hak_akses` VALUES ('22','1','6');
INSERT INTO `users_hak_akses` VALUES ('23','1','7');
INSERT INTO `users_hak_akses` VALUES ('24','1','8');
INSERT INTO `users_hak_akses` VALUES ('25','1','9');
INSERT INTO `users_hak_akses` VALUES ('26','1','10');
INSERT INTO `users_hak_akses` VALUES ('27','1','11');
INSERT INTO `users_hak_akses` VALUES ('28','1','12');
INSERT INTO `users_hak_akses` VALUES ('29','1','13');
INSERT INTO `users_hak_akses` VALUES ('30','1','14');
INSERT INTO `users_hak_akses` VALUES ('31','1','15');
INSERT INTO `users_hak_akses` VALUES ('32','1','16');
INSERT INTO `users_hak_akses` VALUES ('33','1','23');
INSERT INTO `users_hak_akses` VALUES ('34','1','24');
INSERT INTO `users_hak_akses` VALUES ('35','1','25');
INSERT INTO `users_hak_akses` VALUES ('36','1','26');
INSERT INTO `users_hak_akses` VALUES ('37','1','27');
INSERT INTO `users_hak_akses` VALUES ('38','1','28');
INSERT INTO `users_hak_akses` VALUES ('39','1','29');
INSERT INTO `users_hak_akses` VALUES ('40','1','30');
INSERT INTO `users_hak_akses` VALUES ('41','1','31');
INSERT INTO `users_hak_akses` VALUES ('42','1','32');
INSERT INTO `users_hak_akses` VALUES ('43','1','33');
INSERT INTO `users_hak_akses` VALUES ('44','1','34');
INSERT INTO `users_hak_akses` VALUES ('45','1','35');
INSERT INTO `users_hak_akses` VALUES ('46','1','36');
INSERT INTO `users_hak_akses` VALUES ('47','1','37');
INSERT INTO `users_hak_akses` VALUES ('48','1','38');
INSERT INTO `users_hak_akses` VALUES ('49','1','39');
INSERT INTO `users_hak_akses` VALUES ('50','1','40');
INSERT INTO `users_hak_akses` VALUES ('51','1','41');
INSERT INTO `users_hak_akses` VALUES ('52','1','42');
INSERT INTO `users_hak_akses` VALUES ('53','1','43');
INSERT INTO `users_hak_akses` VALUES ('54','1','44');
INSERT INTO `users_hak_akses` VALUES ('55','1','45');
INSERT INTO `users_hak_akses` VALUES ('56','1','46');
INSERT INTO `users_hak_akses` VALUES ('57','1','47');
INSERT INTO `users_hak_akses` VALUES ('58','1','48');
INSERT INTO `users_hak_akses` VALUES ('59','1','49');
INSERT INTO `users_hak_akses` VALUES ('60','1','50');
INSERT INTO `users_hak_akses` VALUES ('63','8','2');
INSERT INTO `users_hak_akses` VALUES ('64','8','3');
INSERT INTO `users_hak_akses` VALUES ('65','8','4');
INSERT INTO `users_hak_akses` VALUES ('66','8','5');
INSERT INTO `users_hak_akses` VALUES ('67','8','6');
INSERT INTO `users_hak_akses` VALUES ('68','8','8');
INSERT INTO `users_hak_akses` VALUES ('69','8','10');
INSERT INTO `users_hak_akses` VALUES ('70','8','11');
INSERT INTO `users_hak_akses` VALUES ('71','8','12');
INSERT INTO `users_hak_akses` VALUES ('72','8','13');
INSERT INTO `users_hak_akses` VALUES ('73','8','9');
INSERT INTO `users_hak_akses` VALUES ('74','8','7');
INSERT INTO `users_hak_akses` VALUES ('75','8','14');
INSERT INTO `users_hak_akses` VALUES ('76','8','15');
INSERT INTO `users_hak_akses` VALUES ('77','8','16');
INSERT INTO `users_hak_akses` VALUES ('78','8','17');
INSERT INTO `users_hak_akses` VALUES ('79','8','18');
INSERT INTO `users_hak_akses` VALUES ('80','8','19');
INSERT INTO `users_hak_akses` VALUES ('81','8','20');
INSERT INTO `users_hak_akses` VALUES ('82','8','21');
INSERT INTO `users_hak_akses` VALUES ('83','8','22');
INSERT INTO `users_hak_akses` VALUES ('84','8','23');
INSERT INTO `users_hak_akses` VALUES ('85','8','24');
INSERT INTO `users_hak_akses` VALUES ('86','8','25');
INSERT INTO `users_hak_akses` VALUES ('87','8','26');
INSERT INTO `users_hak_akses` VALUES ('88','8','27');
INSERT INTO `users_hak_akses` VALUES ('89','8','28');
INSERT INTO `users_hak_akses` VALUES ('90','8','29');
INSERT INTO `users_hak_akses` VALUES ('91','8','30');
INSERT INTO `users_hak_akses` VALUES ('92','8','31');
INSERT INTO `users_hak_akses` VALUES ('93','8','32');
INSERT INTO `users_hak_akses` VALUES ('94','8','33');
INSERT INTO `users_hak_akses` VALUES ('95','8','34');
INSERT INTO `users_hak_akses` VALUES ('96','8','36');
INSERT INTO `users_hak_akses` VALUES ('97','8','35');
INSERT INTO `users_hak_akses` VALUES ('98','8','37');
INSERT INTO `users_hak_akses` VALUES ('99','8','38');
INSERT INTO `users_hak_akses` VALUES ('100','8','39');
INSERT INTO `users_hak_akses` VALUES ('101','8','40');
INSERT INTO `users_hak_akses` VALUES ('102','8','41');
INSERT INTO `users_hak_akses` VALUES ('103','8','42');
INSERT INTO `users_hak_akses` VALUES ('104','8','43');
INSERT INTO `users_hak_akses` VALUES ('105','8','46');
INSERT INTO `users_hak_akses` VALUES ('106','8','45');
INSERT INTO `users_hak_akses` VALUES ('107','8','44');
INSERT INTO `users_hak_akses` VALUES ('108','8','47');
INSERT INTO `users_hak_akses` VALUES ('109','8','48');
INSERT INTO `users_hak_akses` VALUES ('110','8','49');
INSERT INTO `users_hak_akses` VALUES ('111','8','50');
INSERT INTO `users_hak_akses` VALUES ('113','8','1');
INSERT INTO `users_hak_akses` VALUES ('115','1','61');
INSERT INTO `users_hak_akses` VALUES ('116','1','62');
INSERT INTO `users_hak_akses` VALUES ('117','1','63');
INSERT INTO `users_hak_akses` VALUES ('118','1','64');
INSERT INTO `users_hak_akses` VALUES ('119','1','65');
INSERT INTO `users_hak_akses` VALUES ('120','1','66');
INSERT INTO `users_hak_akses` VALUES ('121','8','51');
INSERT INTO `users_hak_akses` VALUES ('122','8','52');
INSERT INTO `users_hak_akses` VALUES ('123','8','53');
INSERT INTO `users_hak_akses` VALUES ('124','8','54');
INSERT INTO `users_hak_akses` VALUES ('125','8','55');
INSERT INTO `users_hak_akses` VALUES ('126','8','56');
INSERT INTO `users_hak_akses` VALUES ('127','8','57');
INSERT INTO `users_hak_akses` VALUES ('128','1','67');
INSERT INTO `users_hak_akses` VALUES ('129','0','');

/*---------------------------------------------------------------
  TABLE: `users_level`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `users_level`;
CREATE TABLE `users_level` (
  `idUsersLevel` int(11) NOT NULL AUTO_INCREMENT,
  `namaUsersLevel` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idUsersLevel`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
INSERT INTO `users_level` VALUES   ('1','ADMIN');
INSERT INTO `users_level` VALUES ('2','KONSELING');
INSERT INTO `users_level` VALUES ('3','KESEHATAN');
INSERT INTO `users_level` VALUES ('4','AKADEMIK');
INSERT INTO `users_level` VALUES ('5','KESISWAAN');
INSERT INTO `users_level` VALUES ('6','TATA USAHA');
INSERT INTO `users_level` VALUES ('7','GURU');
INSERT INTO `users_level` VALUES ('8','KEUANGAN');
INSERT INTO `users_level` VALUES ('9','KASIR');
