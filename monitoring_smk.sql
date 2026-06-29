-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 29, 2026 at 08:46 AM
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
-- Database: `monitoring_smk`
--

-- --------------------------------------------------------

--
-- Table structure for table `aktivitas_log`
--

CREATE TABLE `aktivitas_log` (
  `id_log` bigint UNSIGNED NOT NULL,
  `id_pengguna_fk` bigint UNSIGNED DEFAULT NULL,
  `tipe_aktivitas` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi_aktivitas` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tabel_terdampak` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_record_terdampak` bigint UNSIGNED DEFAULT NULL,
  `nilai_lama` json DEFAULT NULL,
  `nilai_baru` json DEFAULT NULL,
  `ip_address` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_aktivitas` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('sukses','gagal') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sukses'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_penilaian_kompetensi`
--

CREATE TABLE `detail_penilaian_kompetensi` (
  `id_detail` bigint UNSIGNED NOT NULL,
  `id_penilaian_kompetensi_fk` bigint UNSIGNED NOT NULL,
  `id_kompetensi_fk` bigint UNSIGNED NOT NULL,
  `nilai` int NOT NULL DEFAULT '0',
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `industri`
--

CREATE TABLE `industri` (
  `id_industri` bigint UNSIGNED NOT NULL,
  `nama_industri` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_industri` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat_lengkap` text COLLATE utf8mb4_unicode_ci,
  `kota` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `propinsi` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_telp` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_industri` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_kontak_person` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan_kontak` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp_kontak` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kapasitas_siswa` int NOT NULL DEFAULT '0',
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `status` enum('aktif','non_aktif','archived') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `industri`
--

INSERT INTO `industri` (`id_industri`, `nama_industri`, `jenis_industri`, `alamat_lengkap`, `kota`, `propinsi`, `no_telp`, `email_industri`, `nama_kontak_person`, `jabatan_kontak`, `no_hp_kontak`, `kapasitas_siswa`, `latitude`, `longitude`, `status`, `catatan`, `created_at`, `updated_at`) VALUES
(1, 'PT ABC Electronics', 'Software Development', 'Jl. Genteng Kali No. 10', 'Surabaya', 'Jawa Timur', '0315551234', 'info@abcelectronics.co.id', 'Budi Utomo', 'HRD Manager', '08123456789', 5, -6.20000000, 106.81666600, 'aktif', NULL, '2026-06-29 00:32:11', '2026-06-29 00:32:11'),
(2, 'PT Strapa Hidekata', 'IT', 'Maguwoharjo, Depok, Sleman Regency, Special Region of Yogyakarta, 55282, Indonesia', 'SLEMAN', NULL, NULL, NULL, 'Oga Itari', NULL, '085868144268', 2, -7.78179200, 110.43789600, 'aktif', NULL, '2026-06-29 00:52:40', '2026-06-29 00:52:40');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kehadiran`
--

CREATE TABLE `kehadiran` (
  `id_kehadiran` bigint UNSIGNED NOT NULL,
  `id_penugasan_fk` bigint UNSIGNED NOT NULL,
  `id_siswa_fk` bigint UNSIGNED NOT NULL,
  `tgl_absen` date NOT NULL,
  `status_kehadiran` enum('hadir','alpa','izin','sakit','cuti') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'hadir',
  `waktu_checkin` time DEFAULT NULL,
  `waktu_checkout` time DEFAULT NULL,
  `jam_kerja_real` decimal(5,2) DEFAULT NULL,
  `lokasi_checkin` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bukti_foto_checkin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bukti_foto_checkout` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan_izin` text COLLATE utf8mb4_unicode_ci,
  `id_pengguna_input` bigint UNSIGNED DEFAULT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kehadiran`
--

INSERT INTO `kehadiran` (`id_kehadiran`, `id_penugasan_fk`, `id_siswa_fk`, `tgl_absen`, `status_kehadiran`, `waktu_checkin`, `waktu_checkout`, `jam_kerja_real`, `lokasi_checkin`, `bukti_foto_checkin`, `bukti_foto_checkout`, `keterangan_izin`, `id_pengguna_input`, `catatan`, `created_at`, `updated_at`) VALUES
(1, 2, 3, '2024-07-01', 'hadir', '07:48:12', '17:03:45', NULL, 'PT ABC Electronics HQ', 'demo_bukti.jpg', NULL, NULL, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:34:16'),
(2, 2, 3, '2024-07-02', 'hadir', '07:48:12', '17:03:45', NULL, 'PT ABC Electronics HQ', 'demo_bukti.jpg', NULL, NULL, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:34:16'),
(3, 2, 3, '2024-07-03', 'hadir', '07:48:12', '17:03:45', NULL, 'PT ABC Electronics HQ', 'demo_bukti.jpg', NULL, NULL, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:34:16'),
(4, 2, 3, '2024-07-04', 'hadir', '07:48:12', '17:03:45', NULL, 'PT ABC Electronics HQ', 'demo_bukti.jpg', NULL, NULL, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:34:16'),
(5, 2, 3, '2024-07-05', 'hadir', '07:48:12', '17:03:45', NULL, 'PT ABC Electronics HQ', 'demo_bukti.jpg', NULL, NULL, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:34:16'),
(6, 2, 3, '2024-07-06', 'hadir', '07:48:12', '17:03:45', NULL, 'PT ABC Electronics HQ', 'demo_bukti.jpg', NULL, NULL, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:34:16'),
(7, 2, 3, '2024-07-08', 'hadir', '07:48:12', '17:03:45', NULL, 'PT ABC Electronics HQ', 'demo_bukti.jpg', NULL, NULL, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:34:16'),
(8, 2, 3, '2024-07-09', 'hadir', '07:48:12', '17:03:45', NULL, 'PT ABC Electronics HQ', 'demo_bukti.jpg', NULL, NULL, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:34:16'),
(9, 2, 3, '2024-07-10', 'hadir', '07:48:12', '17:03:45', NULL, 'PT ABC Electronics HQ', 'demo_bukti.jpg', NULL, NULL, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:34:16'),
(10, 2, 3, '2024-07-11', 'hadir', '07:48:12', '17:03:45', NULL, 'PT ABC Electronics HQ', 'demo_bukti.jpg', NULL, NULL, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:34:16'),
(11, 2, 3, '2024-07-12', 'hadir', '07:48:12', '17:03:45', NULL, 'PT ABC Electronics HQ', 'demo_bukti.jpg', NULL, NULL, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:34:16'),
(12, 2, 3, '2024-07-13', 'hadir', '07:48:12', '17:03:45', NULL, 'PT ABC Electronics HQ', 'demo_bukti.jpg', NULL, NULL, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:34:16'),
(13, 2, 3, '2024-07-15', 'hadir', '07:48:12', '17:03:45', NULL, 'PT ABC Electronics HQ', 'demo_bukti.jpg', NULL, NULL, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:34:16'),
(14, 2, 3, '2024-07-16', 'hadir', '07:48:12', '17:03:45', NULL, 'PT ABC Electronics HQ', 'demo_bukti.jpg', NULL, NULL, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:34:16'),
(15, 2, 3, '2024-07-17', 'hadir', '07:48:12', '17:03:45', NULL, 'PT ABC Electronics HQ', 'demo_bukti.jpg', NULL, NULL, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:34:16'),
(16, 2, 3, '2024-07-18', 'hadir', '07:48:12', '17:03:45', NULL, 'PT ABC Electronics HQ', 'demo_bukti.jpg', NULL, NULL, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:34:16'),
(17, 2, 3, '2024-07-19', 'hadir', '07:48:12', '17:03:45', NULL, 'PT ABC Electronics HQ', 'demo_bukti.jpg', NULL, NULL, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:34:16'),
(18, 2, 3, '2024-07-20', 'hadir', '07:48:12', '17:03:45', NULL, 'PT ABC Electronics HQ', 'demo_bukti.jpg', NULL, NULL, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:34:16'),
(19, 2, 3, '2024-07-22', 'hadir', '07:48:12', '17:03:45', NULL, 'PT ABC Electronics HQ', 'demo_bukti.jpg', NULL, NULL, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:34:16'),
(20, 2, 3, '2024-07-23', 'hadir', '07:48:12', '17:03:45', NULL, 'PT ABC Electronics HQ', 'demo_bukti.jpg', NULL, NULL, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:34:16'),
(21, 2, 3, '2024-07-24', 'hadir', '07:48:12', '17:03:45', NULL, 'PT ABC Electronics HQ', 'demo_bukti.jpg', NULL, NULL, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:34:16'),
(22, 2, 3, '2024-07-25', 'hadir', '07:48:12', '17:03:45', NULL, 'PT ABC Electronics HQ', 'demo_bukti.jpg', NULL, NULL, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:34:16'),
(23, 2, 3, '2024-07-26', 'hadir', '07:48:12', '17:03:45', NULL, 'PT ABC Electronics HQ', 'demo_bukti.jpg', NULL, NULL, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:34:16'),
(24, 2, 3, '2024-07-27', 'hadir', '07:48:12', '17:03:45', NULL, 'PT ABC Electronics HQ', 'demo_bukti.jpg', NULL, NULL, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:34:16'),
(25, 2, 3, '2024-07-29', 'hadir', '07:48:12', '17:03:45', NULL, 'PT ABC Electronics HQ', 'demo_bukti.jpg', NULL, NULL, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:34:16'),
(26, 2, 3, '2024-07-30', 'hadir', '07:48:12', '17:03:45', NULL, 'PT ABC Electronics HQ', 'demo_bukti.jpg', NULL, NULL, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:34:16');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` bigint UNSIGNED NOT NULL,
  `nama_kelas` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jurusan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun_ajaran` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2025/2026',
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `nama_kelas`, `jurusan`, `tahun_ajaran`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'XII', 'RPL', '2025/2026', 'Kelas Migrasi Otomatis XII RPL', '2026-06-29 00:32:12', '2026-06-29 00:32:12'),
(2, 'XII', 'TKJ', '2025/2026', 'Kelas Migrasi Otomatis XII TKJ', '2026-06-29 00:32:12', '2026-06-29 00:32:12'),
(3, 'XII', 'RPL', '2024/2025', 'Kelas RPL angkatan tahun ajaran lalu 2024/2025', '2026-06-29 00:32:12', '2026-06-29 00:36:19'),
(4, 'XII', 'TKJ', '2024/2025', 'Kelas TKJ angkatan tahun ajaran lalu 2024/2025', '2026-06-29 00:32:12', '2026-06-29 00:36:11'),
(5, 'XII - RPL (2024)', 'RPL', '2025/2026', 'Kelas Migrasi Otomatis XII - RPL (2024) RPL', '2026-06-29 01:01:07', '2026-06-29 01:01:07'),
(6, 'XII - TKJ (2024)', 'TKJ', '2025/2026', 'Kelas Migrasi Otomatis XII - TKJ (2024) TKJ', '2026-06-29 01:01:07', '2026-06-29 01:01:07');

-- --------------------------------------------------------

--
-- Table structure for table `kompetensi_jurusan`
--

CREATE TABLE `kompetensi_jurusan` (
  `id_kompetensi` bigint UNSIGNED NOT NULL,
  `jurusan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_aspek` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi_aspek` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kompetensi_jurusan`
--

INSERT INTO `kompetensi_jurusan` (`id_kompetensi`, `jurusan`, `nama_aspek`, `deskripsi_aspek`, `created_at`, `updated_at`) VALUES
(1, 'RPL', 'Pemrograman Web & Mobile', 'Aspek penilaian pembuatan web dan mobile.', '2026-06-29 00:32:12', '2026-06-29 00:32:12'),
(2, 'RPL', 'Basis Data & SQL', 'Aspek penilaian perancangan dan manajemen database.', '2026-06-29 00:32:12', '2026-06-29 00:32:12'),
(3, 'TKJ', 'Jaringan Komputer & K3', 'Aspek instalasi jaringan dan kepatuhan K3.', '2026-06-29 00:32:12', '2026-06-29 00:32:12'),
(4, 'TKJ', 'Administrasi Server', 'Aspek konfigurasi dan kelola server.', '2026-06-29 00:32:12', '2026-06-29 00:32:12'),
(5, 'Kimia', 'Analisis Laboratorium & Kimia Dasar', 'Aspek kepatuhan prosedur lab dan analisis bahan.', '2026-06-29 00:32:12', '2026-06-29 00:32:12'),
(6, 'Kimia', 'Alat Industri Kimia', 'Aspek operasional alat industri kimia.', '2026-06-29 00:32:12', '2026-06-29 00:32:12');

-- --------------------------------------------------------

--
-- Table structure for table `konfigurasi_sistem`
--

CREATE TABLE `konfigurasi_sistem` (
  `id_konfigurasi` bigint UNSIGNED NOT NULL,
  `nama_konfigurasi` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai_konfigurasi` text COLLATE utf8mb4_unicode_ci,
  `tipe_data` enum('string','integer','decimal','boolean','json') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'string',
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kunjungan_industri`
--

CREATE TABLE `kunjungan_industri` (
  `id_kunjungan` bigint UNSIGNED NOT NULL,
  `id_pembimbing_fk` bigint UNSIGNED NOT NULL,
  `id_industri_fk` bigint UNSIGNED NOT NULL,
  `tgl_kunjungan` date NOT NULL,
  `catatan_monitoring` text COLLATE utf8mb4_unicode_ci,
  `foto_kunjungan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `laporan_harian`
--

CREATE TABLE `laporan_harian` (
  `id_laporan` bigint UNSIGNED NOT NULL,
  `id_penugasan_fk` bigint UNSIGNED NOT NULL,
  `id_siswa_fk` bigint UNSIGNED NOT NULL,
  `tgl_laporan` date NOT NULL,
  `jam_mulai_kerja` time DEFAULT NULL,
  `jam_selesai_kerja` time DEFAULT NULL,
  `jam_kerja_total` decimal(5,2) DEFAULT NULL,
  `aktivitas_pekerjaan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `hasil_pekerjaan` text COLLATE utf8mb4_unicode_ci,
  `skill_dipraktikkan` text COLLATE utf8mb4_unicode_ci,
  `kendala_hambatan` text COLLATE utf8mb4_unicode_ci,
  `pembelajaran_didapat` text COLLATE utf8mb4_unicode_ci,
  `file_lampiran` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('draft','submitted','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `feedback_pembimbing` text COLLATE utf8mb4_unicode_ci,
  `nilai_dudi` int DEFAULT NULL,
  `nilai_guru` int DEFAULT NULL,
  `id_pembimbing_review` bigint UNSIGNED DEFAULT NULL,
  `tgl_review` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `laporan_harian`
--

INSERT INTO `laporan_harian` (`id_laporan`, `id_penugasan_fk`, `id_siswa_fk`, `tgl_laporan`, `jam_mulai_kerja`, `jam_selesai_kerja`, `jam_kerja_total`, `aktivitas_pekerjaan`, `hasil_pekerjaan`, `skill_dipraktikkan`, `kendala_hambatan`, `pembelajaran_didapat`, `file_lampiran`, `status`, `feedback_pembimbing`, `nilai_dudi`, `nilai_guru`, `id_pembimbing_review`, `tgl_review`, `created_at`, `updated_at`) VALUES
(1, 2, 3, '2024-07-01', '08:00:00', '17:00:00', NULL, 'Pekerjaan harian pengembangan modul 1: Analisis kebutuhan, pembuatan REST API, penulisan script unit test.', 'Modul fungsional berjalan, terdokumentasi dengan baik di Git.', 'Laravel PHP, Bootstrap 5, MySQL', NULL, NULL, NULL, 'approved', NULL, 91, 82, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:35:45'),
(2, 2, 3, '2024-07-02', '08:00:00', '17:00:00', NULL, 'Pekerjaan harian pengembangan modul 2: Analisis kebutuhan, pembuatan REST API, penulisan script unit test.', 'Modul fungsional berjalan, terdokumentasi dengan baik di Git.', 'Laravel PHP, Bootstrap 5, MySQL', NULL, NULL, NULL, 'approved', NULL, 95, 84, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:35:45'),
(3, 2, 3, '2024-07-03', '08:00:00', '17:00:00', NULL, 'Pekerjaan harian pengembangan modul 3: Analisis kebutuhan, pembuatan REST API, penulisan script unit test.', 'Modul fungsional berjalan, terdokumentasi dengan baik di Git.', 'Laravel PHP, Bootstrap 5, MySQL', NULL, NULL, NULL, 'approved', NULL, 90, 89, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:35:45'),
(4, 2, 3, '2024-07-04', '08:00:00', '17:00:00', NULL, 'Pekerjaan harian pengembangan modul 4: Analisis kebutuhan, pembuatan REST API, penulisan script unit test.', 'Modul fungsional berjalan, terdokumentasi dengan baik di Git.', 'Laravel PHP, Bootstrap 5, MySQL', NULL, NULL, NULL, 'approved', NULL, 91, 91, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:35:45'),
(5, 2, 3, '2024-07-05', '08:00:00', '17:00:00', NULL, 'Pekerjaan harian pengembangan modul 5: Analisis kebutuhan, pembuatan REST API, penulisan script unit test.', 'Modul fungsional berjalan, terdokumentasi dengan baik di Git.', 'Laravel PHP, Bootstrap 5, MySQL', NULL, NULL, NULL, 'approved', NULL, 88, 84, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:35:45'),
(6, 2, 3, '2024-07-06', '08:00:00', '17:00:00', NULL, 'Pekerjaan harian pengembangan modul 6: Analisis kebutuhan, pembuatan REST API, penulisan script unit test.', 'Modul fungsional berjalan, terdokumentasi dengan baik di Git.', 'Laravel PHP, Bootstrap 5, MySQL', NULL, NULL, NULL, 'approved', NULL, 92, 88, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:35:45'),
(7, 2, 3, '2024-07-08', '08:00:00', '17:00:00', NULL, 'Pekerjaan harian pengembangan modul 8: Analisis kebutuhan, pembuatan REST API, penulisan script unit test.', 'Modul fungsional berjalan, terdokumentasi dengan baik di Git.', 'Laravel PHP, Bootstrap 5, MySQL', NULL, NULL, NULL, 'approved', NULL, 91, 91, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:35:45'),
(8, 2, 3, '2024-07-09', '08:00:00', '17:00:00', NULL, 'Pekerjaan harian pengembangan modul 9: Analisis kebutuhan, pembuatan REST API, penulisan script unit test.', 'Modul fungsional berjalan, terdokumentasi dengan baik di Git.', 'Laravel PHP, Bootstrap 5, MySQL', NULL, NULL, NULL, 'approved', NULL, 90, 87, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:35:45'),
(9, 2, 3, '2024-07-10', '08:00:00', '17:00:00', NULL, 'Pekerjaan harian pengembangan modul 10: Analisis kebutuhan, pembuatan REST API, penulisan script unit test.', 'Modul fungsional berjalan, terdokumentasi dengan baik di Git.', 'Laravel PHP, Bootstrap 5, MySQL', NULL, NULL, NULL, 'approved', NULL, 93, 86, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:35:45'),
(10, 2, 3, '2024-07-11', '08:00:00', '17:00:00', NULL, 'Pekerjaan harian pengembangan modul 11: Analisis kebutuhan, pembuatan REST API, penulisan script unit test.', 'Modul fungsional berjalan, terdokumentasi dengan baik di Git.', 'Laravel PHP, Bootstrap 5, MySQL', NULL, NULL, NULL, 'approved', NULL, 97, 90, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:35:45'),
(11, 2, 3, '2024-07-12', '08:00:00', '17:00:00', NULL, 'Pekerjaan harian pengembangan modul 12: Analisis kebutuhan, pembuatan REST API, penulisan script unit test.', 'Modul fungsional berjalan, terdokumentasi dengan baik di Git.', 'Laravel PHP, Bootstrap 5, MySQL', NULL, NULL, NULL, 'approved', NULL, 91, 90, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:35:45'),
(12, 2, 3, '2024-07-13', '08:00:00', '17:00:00', NULL, 'Pekerjaan harian pengembangan modul 13: Analisis kebutuhan, pembuatan REST API, penulisan script unit test.', 'Modul fungsional berjalan, terdokumentasi dengan baik di Git.', 'Laravel PHP, Bootstrap 5, MySQL', NULL, NULL, NULL, 'approved', NULL, 86, 92, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:35:45'),
(13, 2, 3, '2024-07-15', '08:00:00', '17:00:00', NULL, 'Pekerjaan harian pengembangan modul 15: Analisis kebutuhan, pembuatan REST API, penulisan script unit test.', 'Modul fungsional berjalan, terdokumentasi dengan baik di Git.', 'Laravel PHP, Bootstrap 5, MySQL', NULL, NULL, NULL, 'approved', NULL, 96, 84, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:35:45'),
(14, 2, 3, '2024-07-16', '08:00:00', '17:00:00', NULL, 'Pekerjaan harian pengembangan modul 16: Analisis kebutuhan, pembuatan REST API, penulisan script unit test.', 'Modul fungsional berjalan, terdokumentasi dengan baik di Git.', 'Laravel PHP, Bootstrap 5, MySQL', NULL, NULL, NULL, 'approved', NULL, 91, 89, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:35:45'),
(15, 2, 3, '2024-07-17', '08:00:00', '17:00:00', NULL, 'Pekerjaan harian pengembangan modul 17: Analisis kebutuhan, pembuatan REST API, penulisan script unit test.', 'Modul fungsional berjalan, terdokumentasi dengan baik di Git.', 'Laravel PHP, Bootstrap 5, MySQL', NULL, NULL, NULL, 'approved', NULL, 93, 84, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:35:45'),
(16, 2, 3, '2024-07-18', '08:00:00', '17:00:00', NULL, 'Pekerjaan harian pengembangan modul 18: Analisis kebutuhan, pembuatan REST API, penulisan script unit test.', 'Modul fungsional berjalan, terdokumentasi dengan baik di Git.', 'Laravel PHP, Bootstrap 5, MySQL', NULL, NULL, NULL, 'approved', NULL, 91, 86, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:35:45'),
(17, 2, 3, '2024-07-19', '08:00:00', '17:00:00', NULL, 'Pekerjaan harian pengembangan modul 19: Analisis kebutuhan, pembuatan REST API, penulisan script unit test.', 'Modul fungsional berjalan, terdokumentasi dengan baik di Git.', 'Laravel PHP, Bootstrap 5, MySQL', NULL, NULL, NULL, 'approved', NULL, 85, 86, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:35:45'),
(18, 2, 3, '2024-07-20', '08:00:00', '17:00:00', NULL, 'Pekerjaan harian pengembangan modul 20: Analisis kebutuhan, pembuatan REST API, penulisan script unit test.', 'Modul fungsional berjalan, terdokumentasi dengan baik di Git.', 'Laravel PHP, Bootstrap 5, MySQL', NULL, NULL, NULL, 'approved', NULL, 86, 84, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:35:45'),
(19, 2, 3, '2024-07-22', '08:00:00', '17:00:00', NULL, 'Pekerjaan harian pengembangan modul 22: Analisis kebutuhan, pembuatan REST API, penulisan script unit test.', 'Modul fungsional berjalan, terdokumentasi dengan baik di Git.', 'Laravel PHP, Bootstrap 5, MySQL', NULL, NULL, NULL, 'approved', NULL, 94, 86, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:35:45'),
(20, 2, 3, '2024-07-23', '08:00:00', '17:00:00', NULL, 'Pekerjaan harian pengembangan modul 23: Analisis kebutuhan, pembuatan REST API, penulisan script unit test.', 'Modul fungsional berjalan, terdokumentasi dengan baik di Git.', 'Laravel PHP, Bootstrap 5, MySQL', NULL, NULL, NULL, 'approved', NULL, 95, 88, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:35:45'),
(21, 2, 3, '2024-07-24', '08:00:00', '17:00:00', NULL, 'Pekerjaan harian pengembangan modul 24: Analisis kebutuhan, pembuatan REST API, penulisan script unit test.', 'Modul fungsional berjalan, terdokumentasi dengan baik di Git.', 'Laravel PHP, Bootstrap 5, MySQL', NULL, NULL, NULL, 'approved', NULL, 97, 86, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:35:45'),
(22, 2, 3, '2024-07-25', '08:00:00', '17:00:00', NULL, 'Pekerjaan harian pengembangan modul 25: Analisis kebutuhan, pembuatan REST API, penulisan script unit test.', 'Modul fungsional berjalan, terdokumentasi dengan baik di Git.', 'Laravel PHP, Bootstrap 5, MySQL', NULL, NULL, NULL, 'approved', NULL, 91, 92, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:35:45'),
(23, 2, 3, '2024-07-26', '08:00:00', '17:00:00', NULL, 'Pekerjaan harian pengembangan modul 26: Analisis kebutuhan, pembuatan REST API, penulisan script unit test.', 'Modul fungsional berjalan, terdokumentasi dengan baik di Git.', 'Laravel PHP, Bootstrap 5, MySQL', NULL, NULL, NULL, 'approved', NULL, 90, 90, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:35:45'),
(24, 2, 3, '2024-07-27', '08:00:00', '17:00:00', NULL, 'Pekerjaan harian pengembangan modul 27: Analisis kebutuhan, pembuatan REST API, penulisan script unit test.', 'Modul fungsional berjalan, terdokumentasi dengan baik di Git.', 'Laravel PHP, Bootstrap 5, MySQL', NULL, NULL, NULL, 'approved', NULL, 90, 91, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:35:45'),
(25, 2, 3, '2024-07-29', '08:00:00', '17:00:00', NULL, 'Pekerjaan harian pengembangan modul 29: Analisis kebutuhan, pembuatan REST API, penulisan script unit test.', 'Modul fungsional berjalan, terdokumentasi dengan baik di Git.', 'Laravel PHP, Bootstrap 5, MySQL', NULL, NULL, NULL, 'approved', NULL, 90, 94, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:35:45'),
(26, 2, 3, '2024-07-30', '08:00:00', '17:00:00', NULL, 'Pekerjaan harian pengembangan modul 30: Analisis kebutuhan, pembuatan REST API, penulisan script unit test.', 'Modul fungsional berjalan, terdokumentasi dengan baik di Git.', 'Laravel PHP, Bootstrap 5, MySQL', NULL, NULL, NULL, 'approved', NULL, 96, 88, NULL, NULL, '2026-06-29 01:34:16', '2026-06-29 01:35:45');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_06_29_000001_create_siswa_table', 1),
(5, '2026_06_29_000002_create_industri_table', 1),
(6, '2026_06_29_000003_create_penugasan_table', 1),
(7, '2026_06_29_000004_create_kehadiran_table', 1),
(8, '2026_06_29_000005_create_laporan_harian_table', 1),
(9, '2026_06_29_000006_create_penilaian_sikap_table', 1),
(10, '2026_06_29_000007_create_kompetensi_jurusan_table', 1),
(11, '2026_06_29_000008_create_penilaian_kompetensi_table', 1),
(12, '2026_06_29_000009_create_detail_penilaian_kompetensi_table', 1),
(13, '2026_06_29_000010_create_nilai_akhir_table', 1),
(14, '2026_06_29_000011_create_kunjungan_industri_table', 1),
(15, '2026_06_29_000012_create_notifikasi_table', 1),
(16, '2026_06_29_000013_create_aktivitas_log_table', 1),
(17, '2026_06_29_000014_create_konfigurasi_sistem_table', 1),
(18, '2026_06_29_023617_create_permission_tables', 1),
(19, '2026_06_29_070513_add_nilai_to_laporan_harian_table', 1),
(20, '2026_06_29_071600_create_kelas_table', 1),
(21, '2026_06_29_071700_add_tahun_ajaran_to_kelas_table', 1),
(22, '2026_06_29_072100_modify_kelas_column_in_siswa_table', 1),
(23, '2026_06_29_075800_add_id_industri_fk_to_users_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 3),
(4, 'App\\Models\\User', 4),
(5, 'App\\Models\\User', 5),
(5, 'App\\Models\\User', 6),
(5, 'App\\Models\\User', 7),
(5, 'App\\Models\\User', 8),
(4, 'App\\Models\\User', 9);

-- --------------------------------------------------------

--
-- Table structure for table `nilai_akhir`
--

CREATE TABLE `nilai_akhir` (
  `id_nilai_akhir` bigint UNSIGNED NOT NULL,
  `id_penugasan_fk` bigint UNSIGNED NOT NULL,
  `id_siswa_fk` bigint UNSIGNED NOT NULL,
  `periode_pkl` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_hari_pkl` int NOT NULL DEFAULT '0',
  `total_hari_hadir` int NOT NULL DEFAULT '0',
  `nilai_kehadiran` decimal(5,2) NOT NULL DEFAULT '0.00',
  `nilai_sikap_bobot` decimal(5,2) NOT NULL DEFAULT '0.00',
  `nilai_kompetensi_bobot` decimal(5,2) NOT NULL DEFAULT '0.00',
  `nilai_akhir_pkl` decimal(5,2) NOT NULL DEFAULT '0.00',
  `grade` enum('A','B','C','D','E') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_kelulusan` enum('lulus','remedial','tidak_lulus') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'tidak_lulus',
  `catatan_kelulusan` text COLLATE utf8mb4_unicode_ci,
  `id_yang_finalisasi` bigint UNSIGNED DEFAULT NULL,
  `tgl_finalisasi` timestamp NULL DEFAULT NULL,
  `tgl_cetak` timestamp NULL DEFAULT NULL,
  `no_sertifikat` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nilai_akhir`
--

INSERT INTO `nilai_akhir` (`id_nilai_akhir`, `id_penugasan_fk`, `id_siswa_fk`, `periode_pkl`, `total_hari_pkl`, `total_hari_hadir`, `nilai_kehadiran`, `nilai_sikap_bobot`, `nilai_kompetensi_bobot`, `nilai_akhir_pkl`, `grade`, `status_kelulusan`, `catatan_kelulusan`, `id_yang_finalisasi`, `tgl_finalisasi`, `tgl_cetak`, `no_sertifikat`, `catatan`, `created_at`, `updated_at`) VALUES
(1, 2, 3, NULL, 26, 26, 100.00, 87.77, 91.54, 92.10, 'A', 'lulus', NULL, 2, '2024-09-30 17:00:00', NULL, 'CERT-2024-RPL-088', 'Siswa menyelesaikan tugas tepat waktu dengan inisiatif dan kemandirian yang sangat baik.', '2026-06-29 01:34:16', '2026-06-29 01:35:45');

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id_notifikasi` bigint UNSIGNED NOT NULL,
  `id_pengguna_tujuan_fk` bigint UNSIGNED NOT NULL,
  `judul_notifikasi` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pesan_notifikasi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe_notifikasi` enum('info','warning','error','success') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'info',
  `kategori` enum('absen','laporan','nilai','sistem','umum') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'umum',
  `id_referensi` bigint UNSIGNED DEFAULT NULL,
  `tipe_referensi` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_dibaca` tinyint(1) NOT NULL DEFAULT '0',
  `tgl_dibaca` timestamp NULL DEFAULT NULL,
  `tgl_notifikasi` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penilaian_kompetensi`
--

CREATE TABLE `penilaian_kompetensi` (
  `id_penilaian_kompetensi` bigint UNSIGNED NOT NULL,
  `id_penugasan_fk` bigint UNSIGNED NOT NULL,
  `id_siswa_fk` bigint UNSIGNED NOT NULL,
  `id_industri_penilai_fk` bigint UNSIGNED NOT NULL,
  `nilai_rata_rata_kompetensi` decimal(5,2) NOT NULL DEFAULT '0.00',
  `catatan_umum` text COLLATE utf8mb4_unicode_ci,
  `rekomendasi_industri` text COLLATE utf8mb4_unicode_ci,
  `status` enum('draft','submitted','finalized') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `tgl_penilaian` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penilaian_sikap`
--

CREATE TABLE `penilaian_sikap` (
  `id_penilaian_sikap` bigint UNSIGNED NOT NULL,
  `id_penugasan_fk` bigint UNSIGNED NOT NULL,
  `id_siswa_fk` bigint UNSIGNED NOT NULL,
  `id_pembimbing_fk` bigint UNSIGNED NOT NULL,
  `nilai_kedisiplinan` int NOT NULL DEFAULT '0',
  `nilai_kerjasama` int NOT NULL DEFAULT '0',
  `nilai_tanggung_jawab` int NOT NULL DEFAULT '0',
  `nilai_inisiatif` int NOT NULL DEFAULT '0',
  `nilai_rata_rata_sikap` decimal(5,2) NOT NULL DEFAULT '0.00',
  `catatan_kedisiplinan` text COLLATE utf8mb4_unicode_ci,
  `catatan_kerjasama` text COLLATE utf8mb4_unicode_ci,
  `catatan_tanggung_jawab` text COLLATE utf8mb4_unicode_ci,
  `catatan_inisiatif` text COLLATE utf8mb4_unicode_ci,
  `catatan_umum` text COLLATE utf8mb4_unicode_ci,
  `status` enum('draft','submitted','finalized') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `tgl_penilaian` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penugasan`
--

CREATE TABLE `penugasan` (
  `id_penugasan` bigint UNSIGNED NOT NULL,
  `id_siswa_fk` bigint UNSIGNED NOT NULL,
  `id_industri_fk` bigint UNSIGNED NOT NULL,
  `id_pembimbing_fk` bigint UNSIGNED NOT NULL,
  `id_pengguna_industri_fk` bigint UNSIGNED DEFAULT NULL,
  `tgl_mulai_pkl` date DEFAULT NULL,
  `tgl_selesai_pkl` date DEFAULT NULL,
  `durasi_hari` int DEFAULT NULL,
  `lokasi_kerja` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `divisi_departemen` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pembimbing_industri` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('aktif','selesai','batal','on_leave') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penugasan`
--

INSERT INTO `penugasan` (`id_penugasan`, `id_siswa_fk`, `id_industri_fk`, `id_pembimbing_fk`, `id_pengguna_industri_fk`, `tgl_mulai_pkl`, `tgl_selesai_pkl`, `durasi_hari`, `lokasi_kerja`, `divisi_departemen`, `pembimbing_industri`, `status`, `catatan`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 4, '2026-06-29', '2026-09-29', 90, 'Main Office Surabaya', 'IT Support & Development', 'Budi Utomo', 'aktif', NULL, '2026-06-29 00:32:12', '2026-06-29 00:32:12'),
(2, 3, 1, 2, NULL, '2024-07-01', '2024-10-01', 90, NULL, NULL, NULL, 'selesai', 'Siswa telah menyelesaikan kegiatan PKL angkatan lalu dengan baik.', '2026-06-29 00:32:12', '2026-06-29 00:32:12'),
(3, 4, 1, 2, NULL, '2024-07-01', '2024-10-01', 90, NULL, NULL, NULL, 'selesai', 'Siswa telah menyelesaikan kegiatan PKL angkatan lalu dengan baik.', '2026-06-29 00:32:12', '2026-06-29 00:32:12'),
(4, 2, 2, 2, 9, '2026-07-01', '2026-08-31', 62, 'WFH', NULL, 'Pak ganto', 'aktif', NULL, '2026-06-29 01:05:12', '2026-06-29 01:05:12');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2026-06-29 00:32:10', '2026-06-29 00:32:10'),
(2, 'pembimbing', 'web', '2026-06-29 00:32:10', '2026-06-29 00:32:10'),
(3, 'koordinator', 'web', '2026-06-29 00:32:10', '2026-06-29 00:32:10'),
(4, 'industri', 'web', '2026-06-29 00:32:10', '2026-06-29 00:32:10'),
(5, 'siswa', 'web', '2026-06-29 00:32:10', '2026-06-29 00:32:10');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('0sGNvyJNbGHHPAhjASBjiCORwVW4Imjl7HdiXeOc', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0', 'eyJfdG9rZW4iOiIxWW1obTFuck9iWDBaOHk5TmU3azdoRGJCWW45am9TQVBNTVVpaGIxIiwidXJsIjpbXSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pblwvZGFzaGJvYXJkIiwicm91dGUiOiJhZG1pbi5kYXNoYm9hcmQifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MX0=', 1782722684),
('mLaSXUq43DcluOBRr0pYmPuwEVfv3REiNMaJQlv7', 7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJESG1Ha1pHTHJad0FiRlc4NGJYTnVUMU5CU0YyTUtRb0lQTFNWMkdYIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2luZHVzdHJpXC9kYXNoYm9hcmQ/c2lzd2FfaWQ9MiIsInJvdXRlIjoiaW5kdXN0cmkuZGFzaGJvYXJkIn0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjo3fQ==', 1782722658);

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` bigint UNSIGNED NOT NULL,
  `id_kelas_fk` bigint UNSIGNED DEFAULT NULL,
  `nisn` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nis` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelas` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jurusan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `nama_orang_tua` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp_orang_tua` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_pengguna_fk` bigint UNSIGNED DEFAULT NULL,
  `status` enum('aktif','selesai','dropout') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `id_kelas_fk`, `nisn`, `nis`, `nama_lengkap`, `kelas`, `jurusan`, `no_hp`, `email`, `alamat`, `nama_orang_tua`, `no_hp_orang_tua`, `id_pengguna_fk`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '0051234567', '12345', 'Ahmad Maulana', 'XII', 'RPL', '082233445566', 'siswa@smkadvance.sch.id', 'Jl. Dharmahusada Indah No. 50, Surabaya', 'Slamet Maulana', '081122334455', 5, 'aktif', '2026-06-29 00:32:12', '2026-06-29 01:01:07'),
(2, 2, '0067654321', '12346', 'Dewi Lestari', 'XII', 'TKJ', '087788990011', 'dewi@smkadvance.sch.id', 'Jl. Gubeng Kertajaya No. 12, Surabaya', 'Hendro Lestari', '087788889999', 6, 'aktif', '2026-06-29 00:32:12', '2026-06-29 01:01:07'),
(3, 5, '0041112223', '2425001', 'Budi Santoso', 'XII - RPL (2024)', 'RPL', '081222333444', 'budi.alumni@smkadvance.sch.id', 'Jl. Kenanga No. 12, Solo', 'Bapak Joko Santoso', '081222333555', 7, 'selesai', '2026-06-29 00:32:12', '2026-06-29 01:01:07'),
(4, 6, '0049998887', '2425002', 'Citra Lestari', 'XII - TKJ (2024)', 'TKJ', '087888999000', 'citra.alumni@smkadvance.sch.id', 'Jl. Mawar No. 45, Solo', 'Bapak Hartono', '087888999111', 8, 'selesai', '2026-06-29 00:32:12', '2026-06-29 01:01:07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('aktif','non_aktif','suspended') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `id_industri_fk` bigint UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `status`, `catatan`, `id_industri_fk`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Sekolah', 'admin', 'admin@smkadvance.sch.id', NULL, '$2y$12$zwgiBJOvV3/bmEN8JFITBuva4XuwkwaDFx0B5E9rCcfYvGAODzV/C', 'aktif', 'Akun admin utama sistem monitoring PKL.', NULL, NULL, '2026-06-29 00:32:10', '2026-06-29 00:32:10'),
(2, 'Ibu Siti Nurhaliza, S.Pd.', 'pembimbing', 'pembimbing@smkadvance.sch.id', NULL, '$2y$12$qS/b8xci4Yp2om4pRsKzn.uLp0INcCl6gYvkw5DvOLA56a32TmyVG', 'aktif', 'Guru Pembimbing Jurusan RPL.', NULL, NULL, '2026-06-29 00:32:11', '2026-06-29 00:32:11'),
(3, 'Bapak Bambang Riyanto, M.T.', 'koordinator', 'koordinator@smkadvance.sch.id', NULL, '$2y$12$tf0.SKlstYp22LarhNcNxeCkqiiGd.F2sr86/4puX15jwvvXzOU2W', 'aktif', 'Koordinator PKL Sekolah.', NULL, NULL, '2026-06-29 00:32:11', '2026-06-29 00:32:11'),
(4, 'PT ABC Electronics (Budi)', 'industri', 'industri@smkadvance.sch.id', NULL, '$2y$12$CSUrS0srSSI5iEkU5GLwDux.lKZf3IArEb0azanXC0IqST1wvMpqa', 'aktif', 'Akun Mitra Industri DU-DI.', 1, NULL, '2026-06-29 00:32:11', '2026-06-29 01:01:07'),
(5, 'Ahmad Maulana', '0051234567', 'siswa@smkadvance.sch.id', NULL, '$2y$12$tHXpkg47jH47CMtEKz1hdOciKotUg6poxXS32hg6a9puPkXbn1duG', 'aktif', 'Akun login siswa Ahmad.', NULL, NULL, '2026-06-29 00:32:11', '2026-06-29 00:32:11'),
(6, 'Dewi Lestari', '0067654321', 'dewi@smkadvance.sch.id', NULL, '$2y$12$/9rLQePjR1k1DYKPms7kl.WXucQYO7LBaWO8xMx0s2TiRl2ZsfB7u', 'aktif', 'Akun login siswa Dewi.', NULL, NULL, '2026-06-29 00:32:12', '2026-06-29 00:32:12'),
(7, 'Budi Santoso (Alumni)', '0041112223', 'budi.alumni@smkadvance.sch.id', NULL, '$2y$12$uQGW07Q/DX6iutFnV/BevOtrjuLzHLMX1x/XSuz9xnmB6pnI3Kjye', 'aktif', NULL, NULL, NULL, '2026-06-29 00:32:12', '2026-06-29 01:35:45'),
(8, 'Citra Lestari (Alumni)', '0049998887', 'citra.alumni@smkadvance.sch.id', NULL, '$2y$12$eVNPdpn1YrMtpctVMSmtgen5uZaDGVxRGCejusFdxYaY..eCqDSnG', 'aktif', NULL, NULL, NULL, '2026-06-29 00:32:12', '2026-06-29 01:35:45'),
(9, 'Suparno', 'suparno', 'suparno@gmail.com', NULL, '$2y$12$sYwOR6sWEbWByxMWlmpZfOGxXRHgW1N7qFKvEPQ6AfL1M1LZjHZeG', 'aktif', NULL, 2, NULL, '2026-06-29 01:02:14', '2026-06-29 01:02:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aktivitas_log`
--
ALTER TABLE `aktivitas_log`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `aktivitas_log_id_pengguna_fk_foreign` (`id_pengguna_fk`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `detail_penilaian_kompetensi`
--
ALTER TABLE `detail_penilaian_kompetensi`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `detail_penilaian_kompetensi_id_penilaian_kompetensi_fk_foreign` (`id_penilaian_kompetensi_fk`),
  ADD KEY `detail_penilaian_kompetensi_id_kompetensi_fk_foreign` (`id_kompetensi_fk`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indexes for table `industri`
--
ALTER TABLE `industri`
  ADD PRIMARY KEY (`id_industri`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kehadiran`
--
ALTER TABLE `kehadiran`
  ADD PRIMARY KEY (`id_kehadiran`),
  ADD KEY `kehadiran_id_penugasan_fk_foreign` (`id_penugasan_fk`),
  ADD KEY `kehadiran_id_siswa_fk_foreign` (`id_siswa_fk`),
  ADD KEY `kehadiran_id_pengguna_input_foreign` (`id_pengguna_input`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indexes for table `kompetensi_jurusan`
--
ALTER TABLE `kompetensi_jurusan`
  ADD PRIMARY KEY (`id_kompetensi`),
  ADD KEY `kompetensi_jurusan_jurusan_index` (`jurusan`);

--
-- Indexes for table `konfigurasi_sistem`
--
ALTER TABLE `konfigurasi_sistem`
  ADD PRIMARY KEY (`id_konfigurasi`),
  ADD UNIQUE KEY `konfigurasi_sistem_nama_konfigurasi_unique` (`nama_konfigurasi`);

--
-- Indexes for table `kunjungan_industri`
--
ALTER TABLE `kunjungan_industri`
  ADD PRIMARY KEY (`id_kunjungan`),
  ADD KEY `kunjungan_industri_id_pembimbing_fk_foreign` (`id_pembimbing_fk`),
  ADD KEY `kunjungan_industri_id_industri_fk_foreign` (`id_industri_fk`);

--
-- Indexes for table `laporan_harian`
--
ALTER TABLE `laporan_harian`
  ADD PRIMARY KEY (`id_laporan`),
  ADD KEY `laporan_harian_id_penugasan_fk_foreign` (`id_penugasan_fk`),
  ADD KEY `laporan_harian_id_siswa_fk_foreign` (`id_siswa_fk`),
  ADD KEY `laporan_harian_id_pembimbing_review_foreign` (`id_pembimbing_review`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `nilai_akhir`
--
ALTER TABLE `nilai_akhir`
  ADD PRIMARY KEY (`id_nilai_akhir`),
  ADD UNIQUE KEY `nilai_akhir_no_sertifikat_unique` (`no_sertifikat`),
  ADD KEY `nilai_akhir_id_penugasan_fk_foreign` (`id_penugasan_fk`),
  ADD KEY `nilai_akhir_id_siswa_fk_foreign` (`id_siswa_fk`),
  ADD KEY `nilai_akhir_id_yang_finalisasi_foreign` (`id_yang_finalisasi`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id_notifikasi`),
  ADD KEY `notifikasi_id_pengguna_tujuan_fk_foreign` (`id_pengguna_tujuan_fk`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `penilaian_kompetensi`
--
ALTER TABLE `penilaian_kompetensi`
  ADD PRIMARY KEY (`id_penilaian_kompetensi`),
  ADD KEY `penilaian_kompetensi_id_penugasan_fk_foreign` (`id_penugasan_fk`),
  ADD KEY `penilaian_kompetensi_id_siswa_fk_foreign` (`id_siswa_fk`),
  ADD KEY `penilaian_kompetensi_id_industri_penilai_fk_foreign` (`id_industri_penilai_fk`);

--
-- Indexes for table `penilaian_sikap`
--
ALTER TABLE `penilaian_sikap`
  ADD PRIMARY KEY (`id_penilaian_sikap`),
  ADD KEY `penilaian_sikap_id_penugasan_fk_foreign` (`id_penugasan_fk`),
  ADD KEY `penilaian_sikap_id_siswa_fk_foreign` (`id_siswa_fk`),
  ADD KEY `penilaian_sikap_id_pembimbing_fk_foreign` (`id_pembimbing_fk`);

--
-- Indexes for table `penugasan`
--
ALTER TABLE `penugasan`
  ADD PRIMARY KEY (`id_penugasan`),
  ADD KEY `penugasan_id_siswa_fk_foreign` (`id_siswa_fk`),
  ADD KEY `penugasan_id_industri_fk_foreign` (`id_industri_fk`),
  ADD KEY `penugasan_id_pembimbing_fk_foreign` (`id_pembimbing_fk`),
  ADD KEY `penugasan_id_pengguna_industri_fk_foreign` (`id_pengguna_industri_fk`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD UNIQUE KEY `siswa_nisn_unique` (`nisn`),
  ADD UNIQUE KEY `siswa_nis_unique` (`nis`),
  ADD KEY `siswa_id_pengguna_fk_foreign` (`id_pengguna_fk`),
  ADD KEY `siswa_id_kelas_fk_foreign` (`id_kelas_fk`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_id_industri_fk_foreign` (`id_industri_fk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aktivitas_log`
--
ALTER TABLE `aktivitas_log`
  MODIFY `id_log` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detail_penilaian_kompetensi`
--
ALTER TABLE `detail_penilaian_kompetensi`
  MODIFY `id_detail` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `industri`
--
ALTER TABLE `industri`
  MODIFY `id_industri` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kehadiran`
--
ALTER TABLE `kehadiran`
  MODIFY `id_kehadiran` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kompetensi_jurusan`
--
ALTER TABLE `kompetensi_jurusan`
  MODIFY `id_kompetensi` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `konfigurasi_sistem`
--
ALTER TABLE `konfigurasi_sistem`
  MODIFY `id_konfigurasi` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kunjungan_industri`
--
ALTER TABLE `kunjungan_industri`
  MODIFY `id_kunjungan` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `laporan_harian`
--
ALTER TABLE `laporan_harian`
  MODIFY `id_laporan` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `nilai_akhir`
--
ALTER TABLE `nilai_akhir`
  MODIFY `id_nilai_akhir` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id_notifikasi` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penilaian_kompetensi`
--
ALTER TABLE `penilaian_kompetensi`
  MODIFY `id_penilaian_kompetensi` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penilaian_sikap`
--
ALTER TABLE `penilaian_sikap`
  MODIFY `id_penilaian_sikap` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penugasan`
--
ALTER TABLE `penugasan`
  MODIFY `id_penugasan` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aktivitas_log`
--
ALTER TABLE `aktivitas_log`
  ADD CONSTRAINT `aktivitas_log_id_pengguna_fk_foreign` FOREIGN KEY (`id_pengguna_fk`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `detail_penilaian_kompetensi`
--
ALTER TABLE `detail_penilaian_kompetensi`
  ADD CONSTRAINT `detail_penilaian_kompetensi_id_kompetensi_fk_foreign` FOREIGN KEY (`id_kompetensi_fk`) REFERENCES `kompetensi_jurusan` (`id_kompetensi`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_penilaian_kompetensi_id_penilaian_kompetensi_fk_foreign` FOREIGN KEY (`id_penilaian_kompetensi_fk`) REFERENCES `penilaian_kompetensi` (`id_penilaian_kompetensi`) ON DELETE CASCADE;

--
-- Constraints for table `kehadiran`
--
ALTER TABLE `kehadiran`
  ADD CONSTRAINT `kehadiran_id_pengguna_input_foreign` FOREIGN KEY (`id_pengguna_input`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `kehadiran_id_penugasan_fk_foreign` FOREIGN KEY (`id_penugasan_fk`) REFERENCES `penugasan` (`id_penugasan`) ON DELETE CASCADE,
  ADD CONSTRAINT `kehadiran_id_siswa_fk_foreign` FOREIGN KEY (`id_siswa_fk`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE;

--
-- Constraints for table `kunjungan_industri`
--
ALTER TABLE `kunjungan_industri`
  ADD CONSTRAINT `kunjungan_industri_id_industri_fk_foreign` FOREIGN KEY (`id_industri_fk`) REFERENCES `industri` (`id_industri`) ON DELETE CASCADE,
  ADD CONSTRAINT `kunjungan_industri_id_pembimbing_fk_foreign` FOREIGN KEY (`id_pembimbing_fk`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `laporan_harian`
--
ALTER TABLE `laporan_harian`
  ADD CONSTRAINT `laporan_harian_id_pembimbing_review_foreign` FOREIGN KEY (`id_pembimbing_review`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `laporan_harian_id_penugasan_fk_foreign` FOREIGN KEY (`id_penugasan_fk`) REFERENCES `penugasan` (`id_penugasan`) ON DELETE CASCADE,
  ADD CONSTRAINT `laporan_harian_id_siswa_fk_foreign` FOREIGN KEY (`id_siswa_fk`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `nilai_akhir`
--
ALTER TABLE `nilai_akhir`
  ADD CONSTRAINT `nilai_akhir_id_penugasan_fk_foreign` FOREIGN KEY (`id_penugasan_fk`) REFERENCES `penugasan` (`id_penugasan`) ON DELETE CASCADE,
  ADD CONSTRAINT `nilai_akhir_id_siswa_fk_foreign` FOREIGN KEY (`id_siswa_fk`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE,
  ADD CONSTRAINT `nilai_akhir_id_yang_finalisasi_foreign` FOREIGN KEY (`id_yang_finalisasi`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `notifikasi_id_pengguna_tujuan_fk_foreign` FOREIGN KEY (`id_pengguna_tujuan_fk`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `penilaian_kompetensi`
--
ALTER TABLE `penilaian_kompetensi`
  ADD CONSTRAINT `penilaian_kompetensi_id_industri_penilai_fk_foreign` FOREIGN KEY (`id_industri_penilai_fk`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `penilaian_kompetensi_id_penugasan_fk_foreign` FOREIGN KEY (`id_penugasan_fk`) REFERENCES `penugasan` (`id_penugasan`) ON DELETE CASCADE,
  ADD CONSTRAINT `penilaian_kompetensi_id_siswa_fk_foreign` FOREIGN KEY (`id_siswa_fk`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE;

--
-- Constraints for table `penilaian_sikap`
--
ALTER TABLE `penilaian_sikap`
  ADD CONSTRAINT `penilaian_sikap_id_pembimbing_fk_foreign` FOREIGN KEY (`id_pembimbing_fk`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `penilaian_sikap_id_penugasan_fk_foreign` FOREIGN KEY (`id_penugasan_fk`) REFERENCES `penugasan` (`id_penugasan`) ON DELETE CASCADE,
  ADD CONSTRAINT `penilaian_sikap_id_siswa_fk_foreign` FOREIGN KEY (`id_siswa_fk`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE;

--
-- Constraints for table `penugasan`
--
ALTER TABLE `penugasan`
  ADD CONSTRAINT `penugasan_id_industri_fk_foreign` FOREIGN KEY (`id_industri_fk`) REFERENCES `industri` (`id_industri`) ON DELETE CASCADE,
  ADD CONSTRAINT `penugasan_id_pembimbing_fk_foreign` FOREIGN KEY (`id_pembimbing_fk`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `penugasan_id_pengguna_industri_fk_foreign` FOREIGN KEY (`id_pengguna_industri_fk`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `penugasan_id_siswa_fk_foreign` FOREIGN KEY (`id_siswa_fk`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_id_kelas_fk_foreign` FOREIGN KEY (`id_kelas_fk`) REFERENCES `kelas` (`id_kelas`) ON DELETE SET NULL,
  ADD CONSTRAINT `siswa_id_pengguna_fk_foreign` FOREIGN KEY (`id_pengguna_fk`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_id_industri_fk_foreign` FOREIGN KEY (`id_industri_fk`) REFERENCES `industri` (`id_industri`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
