-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 06, 2026 at 07:46 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpustakaan_laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_anggota` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `pekerjaan` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_daftar` date NOT NULL,
  `status` enum('Aktif','Nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id`, `kode_anggota`, `nama`, `email`, `telepon`, `alamat`, `tanggal_lahir`, `jenis_kelamin`, `pekerjaan`, `tanggal_daftar`, `status`, `created_at`, `updated_at`) VALUES
(2, 'AGT-002', 'Siti Nurhaliza', 'siti.nur@email.com', '081234567891', 'Jl. Sudirman No. 25, Bandung', '1998-08-20', 'Perempuan', 'Pegawai Swasta', '2024-01-15', 'Aktif', '2026-06-28 19:39:37', '2026-06-28 19:39:37'),
(4, 'AGT-004', 'Dewi Lestari', 'dewi.lestari@email.com', '081234567893', 'Jl. Ahmad Yani No. 30, Yogyakarta', '2000-12-05', 'Perempuan', 'Mahasiswa', '2024-02-10', 'Aktif', '2026-06-28 19:39:37', '2026-06-28 19:39:37'),
(5, 'AGT-005', 'Rizky Febian', 'rizky.feb@email.com', '081234567894', 'Jl. Diponegoro No. 15, Semarang', '1997-07-18', 'Laki-laki', 'Wiraswasta', '2023-12-15', 'Nonaktif', '2026-06-28 19:39:37', '2026-06-28 19:39:37'),
(6, 'AGT-TEST-001', 'John Doe Testing', 'john.test@example.com', '081234567890', 'Jl. Testing No. 1, Jakarta', '1995-05-15', 'Laki-laki', 'mahasiswa', '2026-07-04', 'Aktif', '2026-07-03 21:19:07', '2026-07-03 21:19:07');

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_buku` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` enum('Programming','Database','Web Design','Networking','Data Science') COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_id` bigint UNSIGNED DEFAULT NULL,
  `pengarang` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `penerbit` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `negara_penerbit` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kota_penerbit` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahun_terbit` year NOT NULL,
  `isbn` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `harga` decimal(10,2) NOT NULL,
  `stok` int NOT NULL DEFAULT '0',
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `bahasa` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Indonesia',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id`, `kode_buku`, `judul`, `kategori`, `kategori_id`, `pengarang`, `penerbit`, `negara_penerbit`, `kota_penerbit`, `tahun_terbit`, `isbn`, `harga`, `stok`, `deskripsi`, `bahasa`, `created_at`, `updated_at`) VALUES
(1, 'BK-001', 'Laravel 12 untuk Pemula', 'Programming', 1, 'John Doe', 'Tech Publisher', NULL, NULL, '2024', '978-602-1234-56-1', 150000.00, 19, 'Buku panduan lengkap Laravel 12 dari dasar hingga mahir', 'Indonesia', '2026-06-28 19:39:37', '2026-07-06 10:57:34'),
(2, 'BK-002', 'MySQL Advanced Techniques', 'Database', 2, 'Jane Smith', 'Data Press', NULL, NULL, '2023', '978-602-1234-56-2', 175000.00, 14, 'Teknik advanced untuk optimasi MySQL database', 'Inggris', '2026-06-28 19:39:37', '2026-07-06 02:34:14'),
(3, 'BK-003', 'Modern Web Design', 'Web Design', 3, 'Ahmad Yani', 'Creative Media', NULL, NULL, '2024', '978-602-1234-56-3', 120000.00, 25, 'Prinsip dan praktik desain web modern', 'Indonesia', '2026-06-28 19:39:37', '2026-06-28 19:39:37'),
(4, 'BK-004', 'Network Security Fundamentals', 'Networking', 4, 'Robert Johnson', 'Security Press', NULL, NULL, '2023', '978-602-1234-56-4', 200000.00, 10, 'Dasar-dasar keamanan jaringan komputer', 'Inggris', '2026-06-28 19:39:37', '2026-06-28 19:39:37'),
(5, 'BK-005', 'Data Science dengan Python', 'Data Science', 5, 'Siti Nurhaliza', 'Analytics Publisher', NULL, NULL, '2024', '978-602-1234-56-5', 180000.00, 17, 'Panduan praktis data science menggunakan Python', 'Indonesia', '2026-06-28 19:39:37', '2026-07-06 10:22:38'),
(6, 'BK-006', 'PHP 8 Programming', 'Programming', 1, 'Budi Raharjo', 'Code House', NULL, NULL, '2023', '978-602-1234-56-6', 130000.00, 0, 'Fitur-fitur terbaru PHP 8', 'Indonesia', '2026-06-28 19:39:37', '2026-06-28 19:39:37'),
(7, 'BK-007', 'PostgreSQL Administration', 'Database', 2, 'David Wilson', 'Database Pro', NULL, NULL, '2024', '978-602-1234-56-7', 195000.00, 12, 'Administrasi dan optimasi PostgreSQL', 'Inggris', '2026-06-28 19:39:37', '2026-06-28 19:39:37'),
(8, 'BK-008', 'React & Next.js Development', 'Programming', 1, 'Sarah Anderson', 'Frontend Press', NULL, NULL, '2024', '978-602-1234-56-8', 165000.00, 22, 'Membangun aplikasi modern dengan React dan Next.js', 'Inggris', '2026-06-28 19:39:37', '2026-06-28 19:39:37'),
(21, 'BK-PROG-451', 'Three Ways to Survive in a Ruined World', 'Data Science', 5, 'tls123', 'Dokja\'s Company', NULL, NULL, '2007', '4951', 76000.00, 9, 'Three Ways to Survive a Ruined World dalam cerita populer Omniscient Reader\'s Viewpoint (ORV). Buku fiktif ini berjumlah 3.149 bab dan menjadi satu-satunya panduan bagi karakter utama, Kim Dokja, untuk selamat dari kiamat.', 'Indonesia', '2026-07-06 10:18:15', '2026-07-06 10:58:35');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
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
-- Table structure for table `kategoris`
--

CREATE TABLE `kategoris` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategoris`
--

INSERT INTO `kategoris` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'Programming', '2026-07-06 11:29:03', '2026-07-06 11:29:03'),
(2, 'Database', '2026-07-06 11:29:03', '2026-07-06 11:29:03'),
(3, 'Web Design', '2026-07-06 11:29:03', '2026-07-06 11:29:03'),
(4, 'Networking', '2026-07-06 11:29:03', '2026-07-06 11:29:03'),
(5, 'Data Science', '2026-07-06 11:29:03', '2026-07-06 11:29:03');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_backup`
--

CREATE TABLE `kategori_backup` (
  `id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `nama_kategori` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warna` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori_backup`
--

INSERT INTO `kategori_backup` (`id`, `nama_kategori`, `deskripsi`, `icon`, `warna`, `created_at`, `updated_at`) VALUES
(1, 'Programming', 'Buku pemrograman dan coding', 'code-slash', 'primary', '2026-06-28 21:56:44', '2026-06-28 21:56:44'),
(2, 'Database', 'Buku tentang database', 'database', 'success', '2026-06-28 21:56:44', '2026-06-28 21:56:44'),
(3, 'Web Design', 'Buku desain website', 'palette', 'info', '2026-06-28 21:56:44', '2026-06-28 21:56:44'),
(4, 'Networking', 'Buku jaringan komputer', 'wifi', 'warning', '2026-06-28 21:56:44', '2026-06-28 21:56:44'),
(5, 'Data Science', 'Buku data science dan AI', 'graph-up', 'danger', '2026-06-28 21:56:44', '2026-06-28 21:56:44');

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
(4, '2026_06_28_114045_create_buku_table', 1),
(5, '2026_06_28_115524_create_anggota_table', 1),
(6, '2026_06_29_023804_add_penerbit_detail_to_buku_table', 1),
(7, '2026_06_29_044016_create_kategori_table', 2),
(8, '2026_07_06_064849_create_transaksis_table', 3),
(9, '2026_07_07_000001_create_kategoris_table', 4),
(10, '2026_07_07_000002_add_kategori_id_to_buku_table', 4),
(11, '2026_07_07_000010_drop_kategori_table', 5),
(12, '2026_07_07_000011_rename_transaksis_to_transaksi', 5);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_transaksi` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anggota_id` bigint UNSIGNED NOT NULL,
  `buku_id` bigint UNSIGNED NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `tanggal_dikembalikan` date DEFAULT NULL,
  `status` enum('Dipinjam','Dikembalikan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Dipinjam',
  `denda` int NOT NULL DEFAULT '0',
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `kode_transaksi`, `anggota_id`, `buku_id`, `tanggal_pinjam`, `tanggal_kembali`, `tanggal_dikembalikan`, `status`, `denda`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'TRX-001', 4, 5, '2026-07-06', '2026-07-13', NULL, 'Dipinjam', 0, NULL, '2026-07-06 02:25:37', '2026-07-06 02:25:37'),
(3, 'TRX-003', 6, 2, '2026-07-06', '2026-07-13', NULL, 'Dipinjam', 0, NULL, '2026-07-06 02:34:14', '2026-07-06 02:34:14'),
(6, 'TRX-006', 6, 21, '2026-04-06', '2026-07-07', NULL, 'Dipinjam', 0, NULL, '2026-07-06 10:23:27', '2026-07-06 10:59:32'),
(8, 'TRX-008', 4, 1, '2026-06-03', '2026-06-10', NULL, 'Dipinjam', 0, NULL, '2026-07-06 10:35:51', '2026-07-06 10:35:51'),
(9, 'TRX-009', 6, 21, '2026-07-06', '2026-07-13', '2026-07-06', 'Dikembalikan', 0, NULL, '2026-07-06 10:57:20', '2026-07-06 10:58:35');

-- --------------------------------------------------------

--
-- Table structure for table `transaksis_backup`
--

CREATE TABLE `transaksis_backup` (
  `id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `kode_transaksi` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anggota_id` bigint UNSIGNED NOT NULL,
  `buku_id` bigint UNSIGNED NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `tanggal_dikembalikan` date DEFAULT NULL,
  `status` enum('Dipinjam','Dikembalikan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Dipinjam',
  `denda` int NOT NULL DEFAULT '0',
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksis_backup`
--

INSERT INTO `transaksis_backup` (`id`, `kode_transaksi`, `anggota_id`, `buku_id`, `tanggal_pinjam`, `tanggal_kembali`, `tanggal_dikembalikan`, `status`, `denda`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'TRX-001', 4, 5, '2026-07-06', '2026-07-13', NULL, 'Dipinjam', 0, NULL, '2026-07-06 02:25:37', '2026-07-06 02:25:37'),
(3, 'TRX-003', 6, 2, '2026-07-06', '2026-07-13', NULL, 'Dipinjam', 0, NULL, '2026-07-06 02:34:14', '2026-07-06 02:34:14'),
(6, 'TRX-006', 6, 21, '2026-04-06', '2026-07-07', NULL, 'Dipinjam', 0, NULL, '2026-07-06 10:23:27', '2026-07-06 10:59:32'),
(8, 'TRX-008', 4, 1, '2026-06-03', '2026-06-10', NULL, 'Dipinjam', 0, NULL, '2026-07-06 10:35:51', '2026-07-06 10:35:51'),
(9, 'TRX-009', 6, 21, '2026-07-06', '2026-07-13', '2026-07-06', 'Dikembalikan', 0, NULL, '2026-07-06 10:57:20', '2026-07-06 10:58:35');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Perpustakaan', 'admin@perpustakaan.com', NULL, '$2y$12$Pc79v2wf6/kTUXBXsNi.Nele6FpU6DBd/2GgMxcTwfnIjnzUCzYB2', 'LT13LbeUCMmxXw6SRFwSGDygsYsEuFe39DzO2shgdhxhFhSAatR2l6ybwo80', '2026-07-05 08:28:56', '2026-07-05 08:28:56'),
(2, '037_Nurul Afni Khasifa', 'nrlafni582@gmail.com', NULL, '$2y$12$m/z/ezEfQ7IvSJ9KgDu9peEH8V58t9p.9qg.vAuGyiBLeSvcwbUt6', 'RNeP6HG5hTkFdMKsChELff4822E8hHbZqBIcxspLrBd9Ml04jNTv2zK3nmEa', '2026-07-06 10:14:16', '2026-07-06 10:14:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `anggota_kode_anggota_unique` (`kode_anggota`),
  ADD UNIQUE KEY `anggota_email_unique` (`email`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `buku_kode_buku_unique` (`kode_buku`),
  ADD KEY `buku_kategori_id_foreign` (`kategori_id`);

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
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `kategoris`
--
ALTER TABLE `kategoris`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kategoris_nama_unique` (`nama`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transaksis_kode_transaksi_unique` (`kode_transaksi`),
  ADD KEY `transaksis_anggota_id_foreign` (`anggota_id`),
  ADD KEY `transaksis_buku_id_foreign` (`buku_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategoris`
--
ALTER TABLE `kategoris`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `buku_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategoris` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksis_anggota_id_foreign` FOREIGN KEY (`anggota_id`) REFERENCES `anggota` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaksis_buku_id_foreign` FOREIGN KEY (`buku_id`) REFERENCES `buku` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
