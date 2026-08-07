-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 25, 2026 at 12:49 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `xskul_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `ekskul`
--

CREATE TABLE `ekskul` (
  `id` int UNSIGNED NOT NULL,
  `pembina_id` int UNSIGNED NOT NULL,
  `nama` varchar(150) NOT NULL,
  `deskripsi` text,
  `kategori` enum('Olahraga','Seni & Musik','Teknologi','Karakter','Lainnya') NOT NULL DEFAULT 'Lainnya',
  `ikon_emoji` varchar(10) DEFAULT NULL,
  `hari_latihan` varchar(50) NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `kuota_max` smallint UNSIGNED NOT NULL DEFAULT '40',
  `status_pendaftaran` enum('Terbuka','Tutup','Penuh') NOT NULL DEFAULT 'Terbuka',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ekskul`
--

INSERT INTO `ekskul` (`id`, `pembina_id`, `nama`, `deskripsi`, `kategori`, `ikon_emoji`, `hari_latihan`, `jam_mulai`, `jam_selesai`, `kuota_max`, `status_pendaftaran`, `created_at`, `updated_at`) VALUES
(1, 1, 'Klub Programming', 'Belajar pengembangan web, aplikasi mobile, dan logika algoritma menggunakan teknologi modern.', 'Teknologi', '💻', 'Rabu', '15:00:00', '17:00:00', 40, 'Terbuka', '2026-05-14 00:45:50', '2026-05-14 00:45:50'),
(2, 2, 'Tari Tradisional', 'Melestarikan budaya bangsa melalui seni tari daerah dari seluruh Nusantara.', 'Seni & Musik', '💃', 'Selasa', '14:30:00', '16:30:00', 30, 'Terbuka', '2026-05-14 00:45:50', '2026-05-14 00:45:50'),
(3, 3, 'Basket', 'Pengembangan bakat olahraga bola basket, teknik dasar, dan kerjasama tim untuk kompetisi.', 'Olahraga', '🏀', 'Jumat', '15:30:00', '17:30:00', 50, 'Penuh', '2026-05-14 00:45:50', '2026-05-14 00:45:50'),
(4, 4, 'Pramuka', 'Pembentukan karakter, kedisiplinan, kepemimpinan, dan keterampilan kepanduan tingkat lanjut.', 'Karakter', '🏕️', 'Sabtu', '08:00:00', '11:00:00', 100, 'Terbuka', '2026-05-14 00:45:50', '2026-05-14 00:45:50'),
(5, 1, 'E-Sport', 'Manajemen tim game kompetitif dan strategi dalam industri e-sport yang berkembang.', 'Teknologi', '🎮', 'Kamis', '15:00:00', '17:00:00', 20, 'Tutup', '2026-05-14 00:45:50', '2026-05-14 00:45:50');

-- --------------------------------------------------------

--
-- Table structure for table `pembina`
--

CREATE TABLE `pembina` (
  `id` int UNSIGNED NOT NULL,
  `nip` varchar(30) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL COMMENT 'bcrypt hash',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pembina`
--

INSERT INTO `pembina` (`id`, `nip`, `nama`, `no_hp`, `password`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '198203102005011002', 'Bpk. Arif Rahman', '081234567890', '$2y$10$YJUquNWtXpeyx6.ALwOMxOIK.HxgcWzxGiqnX7HPsrsIelRFPhUXG', 1, '2026-05-14 00:45:50', '2026-05-14 00:45:50'),
(2, '198504122010012005', 'Ibu Siti Aminah', '082345678901', '$2y$10$/aa7H6624EFIunGEGKBN9Okqnox61hyHDFoYbZyH3Xakyvkd.X1oK', 1, '2026-05-14 00:45:50', '2026-05-14 00:45:50'),
(3, '197811202003121001', 'Bpk. Budi Santoso', '083456789012', '$2y$10$TQ5GEAfG8YayX0d8mdUN4OfmY0HwpGwIJy41XW9lG7H18kAMH9PSq', 1, '2026-05-14 00:45:50', '2026-05-14 00:45:50'),
(4, '199008152015032003', 'Ibu Ratna Sari', '084567890123', '$2y$10$Z2Kn13cN8BYKf3bwumri2On5jKuk2KIOX3MqCLXzJzhhcSb/AU.zy', 1, '2026-05-14 00:45:50', '2026-05-14 00:45:50');

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `id` int UNSIGNED NOT NULL,
  `siswa_id` int UNSIGNED NOT NULL,
  `ekskul_id` int UNSIGNED NOT NULL,
  `status` enum('pending','aktif','ditolak','keluar') NOT NULL DEFAULT 'pending',
  `tanggal_daftar` date NOT NULL,
  `tanggal_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `catatan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pendaftaran`
--

INSERT INTO `pendaftaran` (`id`, `siswa_id`, `ekskul_id`, `status`, `tanggal_daftar`, `tanggal_update`, `catatan`) VALUES
(1, 1, 1, 'aktif', '2026-05-01', '2026-05-14 00:45:50', NULL),
(2, 2, 1, 'aktif', '2026-05-02', '2026-05-14 00:45:50', NULL),
(3, 3, 1, 'aktif', '2026-05-03', '2026-05-14 00:45:50', NULL),
(4, 4, 2, 'aktif', '2026-05-04', '2026-05-14 00:45:50', NULL),
(5, 5, 3, 'pending', '2026-05-10', '2026-05-14 00:45:50', NULL),
(6, 1, 4, 'pending', '2026-05-14', '2026-05-14 00:53:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `presensi`
--

CREATE TABLE `presensi` (
  `id` int UNSIGNED NOT NULL,
  `sesi_id` int UNSIGNED NOT NULL,
  `siswa_id` int UNSIGNED NOT NULL,
  `status` enum('H','I','S','A') NOT NULL DEFAULT 'A',
  `keterangan` varchar(255) DEFAULT NULL,
  `dicatat_oleh` int UNSIGNED NOT NULL COMMENT 'pembina_id',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `presensi`
--

INSERT INTO `presensi` (`id`, `sesi_id`, `siswa_id`, `status`, `keterangan`, `dicatat_oleh`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'S', '', 1, '2026-05-14 00:47:06', '2026-05-14 00:49:31'),
(2, 1, 2, 'I', 'Ada acara keluarga pak', 1, '2026-05-14 00:47:06', '2026-05-14 00:47:06'),
(3, 1, 3, 'A', '', 1, '2026-05-14 00:47:06', '2026-05-14 00:47:06'),
(7, 2, 1, 'I', '', 1, '2026-05-18 00:48:31', '2026-05-18 00:48:31'),
(8, 2, 2, 'H', '', 1, '2026-05-18 00:48:31', '2026-05-18 00:48:31'),
(9, 2, 3, 'S', '', 1, '2026-05-18 00:48:31', '2026-05-18 00:48:31');

-- --------------------------------------------------------

--
-- Table structure for table `sesi_latihan`
--

CREATE TABLE `sesi_latihan` (
  `id` int UNSIGNED NOT NULL,
  `ekskul_id` int UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `pertemuan_ke` smallint UNSIGNED NOT NULL,
  `materi` varchar(255) DEFAULT NULL,
  `catatan` text,
  `dibuat_oleh` int UNSIGNED NOT NULL COMMENT 'pembina_id',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sesi_latihan`
--

INSERT INTO `sesi_latihan` (`id`, `ekskul_id`, `tanggal`, `pertemuan_ke`, `materi`, `catatan`, `dibuat_oleh`, `created_at`) VALUES
(1, 1, '2026-05-14', 1, 'Buat Struktur HTML Dasar', 'Nggak ush overextend untuk tambahin semantic atau apapun yang tidak berkaitan dengan materi', 1, '2026-05-14 00:31:28'),
(2, 1, '2026-05-18', 2, 'Belajar Membuat Projek Sederhana', '', 1, '2026-05-18 00:48:07');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id` int UNSIGNED NOT NULL,
  `nis` varchar(20) NOT NULL,
  `nisn` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kelas` varchar(20) NOT NULL COMMENT 'Contoh: XII RPL 1',
  `password` varchar(255) NOT NULL COMMENT 'bcrypt hash',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id`, `nis`, `nisn`, `nama`, `kelas`, `password`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '1029384756', '0012345678', 'Dimas Saputra', 'X - RPL 1', '$2y$10$KXoGpddKQP90X/NX/PjGBe2iQU6bFnXQ71SQ9wmWTQRgIqLSCF.q6', 1, '2026-05-14 00:45:50', '2026-05-14 00:45:50'),
(2, '1029384788', '0023456789', 'Bunga Novita', 'XI - TKJ 2', '$2y$10$mIRi2tUVxYC17zEnKgZaYOUy8fu.TPzqw3lYj36ntghnxfiXs9eUi', 1, '2026-05-14 00:45:50', '2026-05-14 00:45:50'),
(3, '1029384700', '0034567890', 'Aditya Wijaya', 'X - MIPA 3', '$2y$10$8zisREdKlClBQ.bBVHFVx.sBqv1qO8Z665io03Z5ewp0lq4FJFssq', 1, '2026-05-14 00:45:50', '2026-05-14 00:45:50'),
(4, '1029384722', '0045678901', 'Citra Lestari', 'XII - IPS 1', '$2y$10$j6pt1uZG6MulEE3p4ksurOyx4f8lBcT0nWiZOlRG6CdoIKIuNJzRq', 1, '2026-05-14 00:45:50', '2026-05-14 00:45:50'),
(5, '1029384744', '0056789012', 'Fajar Ramadhan', 'XI - RPL 2', '$2y$10$2wEdX46h8ZnBrA5wkckSaOqg.dp9H/yPc6AMydp7xcSWx8hogYhqC', 1, '2026-05-14 00:45:50', '2026-05-14 00:45:50');

-- --------------------------------------------------------

--
-- Table structure for table `super_admin`
--

CREATE TABLE `super_admin` (
  `id` int UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL COMMENT 'bcrypt hash',
  `nama` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `super_admin`
--

INSERT INTO `super_admin` (`id`, `username`, `password`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', '$2y$10$s1QOfD164vD3MvHDwWbON.TAsHwl68RHlqqI4FoJG4M8ECDUsvBOK', 'Super Administrator', '2026-05-12 23:59:17', '2026-05-12 23:59:17');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_jumlah_member`
-- (See below for the actual view)
--
CREATE TABLE `v_jumlah_member` (
`ekskul` varchar(150)
,`ekskul_id` int unsigned
,`total_anggota` bigint
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_kehadiran_siswa`
-- (See below for the actual view)
--
CREATE TABLE `v_kehadiran_siswa` (
`alpa` decimal(23,0)
,`ekskul` varchar(150)
,`ekskul_id` int unsigned
,`hadir` decimal(23,0)
,`izin` decimal(23,0)
,`nama_siswa` varchar(100)
,`persen_hadir` decimal(28,1)
,`sakit` decimal(23,0)
,`siswa_id` int unsigned
,`total_sesi` bigint
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_pending_approval`
-- (See below for the actual view)
--
CREATE TABLE `v_pending_approval` (
`ekskul` varchar(150)
,`ekskul_id` int unsigned
,`kelas` varchar(20)
,`nama_siswa` varchar(100)
,`nis` varchar(20)
,`pendaftaran_id` int unsigned
,`siswa_id` int unsigned
,`tanggal_daftar` date
);

-- --------------------------------------------------------

--
-- Structure for view `v_jumlah_member`
--
DROP TABLE IF EXISTS `v_jumlah_member`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_jumlah_member`  AS SELECT `e`.`id` AS `ekskul_id`, `e`.`nama` AS `ekskul`, count(`p`.`id`) AS `total_anggota` FROM (`ekskul` `e` left join `pendaftaran` `p` on(((`p`.`ekskul_id` = `e`.`id`) and (`p`.`status` = 'aktif')))) GROUP BY `e`.`id`, `e`.`nama``nama`  ;

-- --------------------------------------------------------

--
-- Structure for view `v_kehadiran_siswa`
--
DROP TABLE IF EXISTS `v_kehadiran_siswa`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_kehadiran_siswa`  AS SELECT `pr`.`siswa_id` AS `siswa_id`, `s`.`nama` AS `nama_siswa`, `sl`.`ekskul_id` AS `ekskul_id`, `e`.`nama` AS `ekskul`, count(`pr`.`id`) AS `total_sesi`, sum((`pr`.`status` = 'H')) AS `hadir`, sum((`pr`.`status` = 'I')) AS `izin`, sum((`pr`.`status` = 'S')) AS `sakit`, sum((`pr`.`status` = 'A')) AS `alpa`, round(((sum((`pr`.`status` = 'H')) / count(`pr`.`id`)) * 100),1) AS `persen_hadir` FROM (((`presensi` `pr` join `sesi_latihan` `sl` on((`sl`.`id` = `pr`.`sesi_id`))) join `ekskul` `e` on((`e`.`id` = `sl`.`ekskul_id`))) join `siswa` `s` on((`s`.`id` = `pr`.`siswa_id`))) GROUP BY `pr`.`siswa_id`, `s`.`nama`, `sl`.`ekskul_id`, `e`.`nama``nama`  ;

-- --------------------------------------------------------

--
-- Structure for view `v_pending_approval`
--
DROP TABLE IF EXISTS `v_pending_approval`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_pending_approval`  AS SELECT `p`.`id` AS `pendaftaran_id`, `p`.`ekskul_id` AS `ekskul_id`, `e`.`nama` AS `ekskul`, `p`.`siswa_id` AS `siswa_id`, `s`.`nama` AS `nama_siswa`, `s`.`nis` AS `nis`, `s`.`kelas` AS `kelas`, `p`.`tanggal_daftar` AS `tanggal_daftar` FROM ((`pendaftaran` `p` join `ekskul` `e` on((`e`.`id` = `p`.`ekskul_id`))) join `siswa` `s` on((`s`.`id` = `p`.`siswa_id`))) WHERE (`p`.`status` = 'pending') ORDER BY `p`.`tanggal_daftar` ASC  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ekskul`
--
ALTER TABLE `ekskul`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ekskul_pembina` (`pembina_id`);

--
-- Indexes for table `pembina`
--
ALTER TABLE `pembina`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nip` (`nip`);

--
-- Indexes for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_pendaftaran` (`siswa_id`,`ekskul_id`),
  ADD KEY `fk_pendaftaran_ekskul` (`ekskul_id`);

--
-- Indexes for table `presensi`
--
ALTER TABLE `presensi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_presensi` (`sesi_id`,`siswa_id`),
  ADD KEY `fk_presensi_siswa` (`siswa_id`),
  ADD KEY `fk_presensi_pembina` (`dicatat_oleh`);

--
-- Indexes for table `sesi_latihan`
--
ALTER TABLE `sesi_latihan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_sesi` (`ekskul_id`,`tanggal`),
  ADD KEY `fk_sesi_pembina` (`dibuat_oleh`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nis` (`nis`),
  ADD UNIQUE KEY `nisn` (`nisn`);

--
-- Indexes for table `super_admin`
--
ALTER TABLE `super_admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ekskul`
--
ALTER TABLE `ekskul`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pembina`
--
ALTER TABLE `pembina`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `presensi`
--
ALTER TABLE `presensi`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sesi_latihan`
--
ALTER TABLE `sesi_latihan`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `super_admin`
--
ALTER TABLE `super_admin`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ekskul`
--
ALTER TABLE `ekskul`
  ADD CONSTRAINT `fk_ekskul_pembina` FOREIGN KEY (`pembina_id`) REFERENCES `pembina` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD CONSTRAINT `fk_pendaftaran_ekskul` FOREIGN KEY (`ekskul_id`) REFERENCES `ekskul` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pendaftaran_siswa` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `presensi`
--
ALTER TABLE `presensi`
  ADD CONSTRAINT `fk_presensi_pembina` FOREIGN KEY (`dicatat_oleh`) REFERENCES `pembina` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_presensi_sesi` FOREIGN KEY (`sesi_id`) REFERENCES `sesi_latihan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_presensi_siswa` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sesi_latihan`
--
ALTER TABLE `sesi_latihan`
  ADD CONSTRAINT `fk_sesi_ekskul` FOREIGN KEY (`ekskul_id`) REFERENCES `ekskul` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sesi_pembina` FOREIGN KEY (`dibuat_oleh`) REFERENCES `pembina` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
