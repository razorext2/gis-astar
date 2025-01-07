-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 07, 2025 at 02:05 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `faceid`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('439ade@indodacin.com|192.168.11.235', 'i:1;', 1735891177),
('439ade@indodacin.com|192.168.11.235:timer', 'i:1735891177;', 1735891177),
('current_date', 's:15:\"20250107_075636\";', 1736211406),
('piutang@acc-fin.indodacin.com|192.168.11.226', 'i:2;', 1735187366),
('piutang@acc-fin.indodacin.com|192.168.11.226:timer', 'i:1735187366;', 1735187366),
('spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:51:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:10:\"users-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:12:\"users-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:10:\"users-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:12:\"users-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:10:\"roles-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:12:\"roles-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:10:\"roles-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:12:\"roles-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:16:\"permissions-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:18:\"permissions-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:16:\"permissions-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:18:\"permissions-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:12;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:11:\"divisi-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:13;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:13:\"divisi-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:14;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:11:\"divisi-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:15;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:13:\"divisi-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:16;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:14:\"placement-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:17;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:16:\"placement-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:18;a:4:{s:1:\"a\";i:27;s:1:\"b\";s:14:\"placement-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:19;a:4:{s:1:\"a\";i:28;s:1:\"b\";s:16:\"placement-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:20;a:4:{s:1:\"a\";i:29;s:1:\"b\";s:13:\"golongan-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:21;a:4:{s:1:\"a\";i:30;s:1:\"b\";s:15:\"golongan-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:22;a:4:{s:1:\"a\";i:31;s:1:\"b\";s:13:\"golongan-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:23;a:4:{s:1:\"a\";i:32;s:1:\"b\";s:15:\"golongan-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:24;a:4:{s:1:\"a\";i:33;s:1:\"b\";s:12:\"jabatan-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:25;a:4:{s:1:\"a\";i:34;s:1:\"b\";s:14:\"jabatan-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:26;a:4:{s:1:\"a\";i:35;s:1:\"b\";s:12:\"jabatan-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:27;a:4:{s:1:\"a\";i:36;s:1:\"b\";s:14:\"jabatan-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:28;a:4:{s:1:\"a\";i:37;s:1:\"b\";s:12:\"pegawai-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:29;a:4:{s:1:\"a\";i:38;s:1:\"b\";s:14:\"pegawai-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:30;a:4:{s:1:\"a\";i:39;s:1:\"b\";s:12:\"pegawai-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:31;a:4:{s:1:\"a\";i:40;s:1:\"b\";s:14:\"pegawai-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:32;a:4:{s:1:\"a\";i:41;s:1:\"b\";s:8:\"log-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:33;a:4:{s:1:\"a\";i:42;s:1:\"b\";s:10:\"log-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:7;i:3;i:8;i:4;i:9;i:5;i:10;i:6;i:11;}}i:34;a:4:{s:1:\"a\";i:43;s:1:\"b\";s:8:\"log-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:35;a:4:{s:1:\"a\";i:44;s:1:\"b\";s:10:\"log-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:36;a:4:{s:1:\"a\";i:45;s:1:\"b\";s:11:\"dayoff-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:1;i:1;i:2;i:2;i:8;i:3;i:9;i:4;i:10;}}i:37;a:4:{s:1:\"a\";i:46;s:1:\"b\";s:13:\"dayoff-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:8;i:2;i:9;i:3;i:10;}}i:38;a:4:{s:1:\"a\";i:47;s:1:\"b\";s:11:\"dayoff-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:8;i:2;i:9;i:3;i:10;}}i:39;a:4:{s:1:\"a\";i:48;s:1:\"b\";s:13:\"dayoff-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:40;a:4:{s:1:\"a\";i:49;s:1:\"b\";s:13:\"dayoff-detail\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:1;i:1;i:2;i:2;i:8;i:3;i:9;i:4;i:10;}}i:41;a:4:{s:1:\"a\";i:50;s:1:\"b\";s:14:\"dayoff-confirm\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:42;a:4:{s:1:\"a\";i:51;s:1:\"b\";s:7:\"capture\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:7;i:2;i:9;i:3;i:10;}}i:43;a:4:{s:1:\"a\";i:53;s:1:\"b\";s:16:\"pegawai-timeline\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:44;a:4:{s:1:\"a\";i:54;s:1:\"b\";s:9:\"dashboard\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:45;a:4:{s:1:\"a\";i:55;s:1:\"b\";s:14:\"dashboard-user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:1;i:1;i:7;i:2;i:9;i:3;i:10;i:4;i:11;}}i:46;a:4:{s:1:\"a\";i:56;s:1:\"b\";s:12:\"collect-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:11;i:2;i:12;}}i:47;a:4:{s:1:\"a\";i:57;s:1:\"b\";s:14:\"collect-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:11;}}i:48;a:4:{s:1:\"a\";i:58;s:1:\"b\";s:12:\"collect-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:11;i:2;i:12;}}i:49;a:4:{s:1:\"a\";i:59;s:1:\"b\";s:14:\"collect-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:50;a:4:{s:1:\"a\";i:60;s:1:\"b\";s:15:\"collect-approve\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:12;}}}s:5:\"roles\";a:8:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"Admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:3:\"HRD\";s:1:\"c\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:8;s:1:\"b\";s:10:\"Management\";s:1:\"c\";s:3:\"web\";}i:3;a:3:{s:1:\"a\";i:7;s:1:\"b\";s:8:\"Employee\";s:1:\"c\";s:3:\"web\";}i:4;a:3:{s:1:\"a\";i:9;s:1:\"b\";s:7:\"Teknisi\";s:1:\"c\";s:3:\"web\";}i:5;a:3:{s:1:\"a\";i:10;s:1:\"b\";s:6:\"Driver\";s:1:\"c\";s:3:\"web\";}i:6;a:3:{s:1:\"a\";i:11;s:1:\"b\";s:9:\"Collector\";s:1:\"c\";s:3:\"web\";}i:7;a:3:{s:1:\"a\";i:12;s:1:\"b\";s:7:\"Piutang\";s:1:\"c\";s:3:\"web\";}}}', 1736231934);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(13, '2024_10_01_153336_create_tbllog_table', 6),
(23, '0001_01_01_000000_create_users_table', 7),
(24, '0001_01_01_000001_create_cache_table', 7),
(25, '0001_01_01_000002_create_jobs_table', 7),
(26, '2024_08_30_022504_create_tb_pegawai_table', 7),
(27, '2024_09_02_111823_create_tb_attendance_table', 7),
(28, '2024_09_02_112424_create_tb_attendance_out_table', 7),
(29, '2024_09_02_145341_create_tb_jabatan_table', 7),
(30, '2024_09_09_105914_create_personal_access_tokens_table', 7),
(31, '2024_09_20_164511_create_tb_division_table', 7),
(32, '2024_09_20_164525_create_tb_placement_table', 7),
(33, '2024_09_30_131459_create_tb_log_table', 7),
(34, '2024_10_01_150019_create_tbllog_table', 7),
(35, '2024_10_03_144245_create_tb_golongan_table', 8),
(36, '2024_10_04_101514_create_tb_jadwal_table', 9),
(38, '2024_10_05_111906_create_roles_and_permissions_tables', 10),
(39, '2024_10_05_115006_create_permission_tables', 11),
(40, '2024_10_05_133509_create_permission_tables', 12),
(41, '2024_10_11_090452_create_permission_tables', 13),
(42, '2024_10_14_134628_create_tb_dayoff_table', 14),
(43, '2024_11_01_154937_create_tb_salary_table', 15),
(44, '2024_11_01_164222_create_tb_allowance_table', 15),
(45, '2024_11_01_164555_create_tb_dedcution_table', 15),
(46, '2024_11_01_164647_create_tb_overtime_table', 15),
(47, '2024_11_19_100219_create_tb_collect_table', 16),
(48, '2024_11_19_100355_create_tb_photo_collect_table', 16),
(49, '2024_12_03_164840_add_location_tb_collect', 17);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 1005),
(7, 'App\\Models\\User', 1006),
(7, 'App\\Models\\User', 1020),
(7, 'App\\Models\\User', 1021),
(7, 'App\\Models\\User', 1022),
(8, 'App\\Models\\User', 1023),
(7, 'App\\Models\\User', 1024),
(7, 'App\\Models\\User', 1026),
(11, 'App\\Models\\User', 1028),
(11, 'App\\Models\\User', 1029),
(11, 'App\\Models\\User', 1030),
(11, 'App\\Models\\User', 1031),
(12, 'App\\Models\\User', 1032),
(12, 'App\\Models\\User', 1033);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'users-list', 'web', '2024-10-11 03:21:32', '2024-10-11 03:21:32'),
(2, 'users-create', 'web', '2024-10-11 03:21:32', '2024-10-11 03:21:32'),
(3, 'users-edit', 'web', '2024-10-11 03:21:32', '2024-10-11 03:21:32'),
(4, 'users-delete', 'web', '2024-10-11 03:21:32', '2024-10-11 03:21:32'),
(5, 'roles-list', 'web', '2024-10-10 20:21:32', '2024-10-10 20:21:32'),
(6, 'roles-create', 'web', '2024-10-10 20:21:32', '2024-10-10 20:21:32'),
(7, 'roles-edit', 'web', '2024-10-10 20:21:32', '2024-10-10 20:21:32'),
(8, 'roles-delete', 'web', '2024-10-10 20:21:32', '2024-10-10 20:21:32'),
(9, 'permissions-list', 'web', '2024-10-10 20:21:32', '2024-10-10 20:21:32'),
(10, 'permissions-create', 'web', '2024-10-10 20:21:32', '2024-10-10 20:21:32'),
(11, 'permissions-edit', 'web', '2024-10-10 20:21:32', '2024-10-10 20:21:32'),
(12, 'permissions-delete', 'web', '2024-10-10 20:21:32', '2024-10-10 20:21:32'),
(21, 'divisi-list', 'web', '2024-10-12 03:23:20', '2024-10-12 03:23:20'),
(22, 'divisi-create', 'web', '2024-10-12 03:23:20', '2024-10-12 03:23:20'),
(23, 'divisi-edit', 'web', '2024-10-12 03:23:20', '2024-10-12 03:23:20'),
(24, 'divisi-delete', 'web', '2024-10-12 03:23:20', '2024-10-12 03:23:20'),
(25, 'placement-list', 'web', '2024-10-12 03:23:20', '2024-10-12 03:23:20'),
(26, 'placement-create', 'web', '2024-10-12 03:23:20', '2024-10-12 03:23:20'),
(27, 'placement-edit', 'web', '2024-10-12 03:23:20', '2024-10-12 03:23:20'),
(28, 'placement-delete', 'web', '2024-10-12 03:23:20', '2024-10-12 03:23:20'),
(29, 'golongan-list', 'web', '2024-10-12 03:23:20', '2024-10-12 03:23:20'),
(30, 'golongan-create', 'web', '2024-10-12 03:23:20', '2024-10-12 03:23:20'),
(31, 'golongan-edit', 'web', '2024-10-12 03:23:20', '2024-10-12 03:23:20'),
(32, 'golongan-delete', 'web', '2024-10-12 03:23:20', '2024-10-12 03:23:20'),
(33, 'jabatan-list', 'web', '2024-10-12 03:24:38', '2024-10-12 03:24:38'),
(34, 'jabatan-create', 'web', '2024-10-12 03:24:38', '2024-10-12 03:24:38'),
(35, 'jabatan-edit', 'web', '2024-10-12 03:24:38', '2024-10-12 03:24:38'),
(36, 'jabatan-delete', 'web', '2024-10-12 03:24:38', '2024-10-12 03:24:38'),
(37, 'pegawai-list', 'web', '2024-10-12 03:24:38', '2024-10-12 03:24:38'),
(38, 'pegawai-create', 'web', '2024-10-12 03:24:38', '2024-10-12 03:24:38'),
(39, 'pegawai-edit', 'web', '2024-10-12 03:24:38', '2024-10-12 03:24:38'),
(40, 'pegawai-delete', 'web', '2024-10-12 03:24:38', '2024-10-12 03:24:38'),
(41, 'log-list', 'web', '2024-10-12 03:25:02', '2024-10-12 03:25:02'),
(42, 'log-create', 'web', '2024-10-12 03:25:02', '2024-10-12 03:25:02'),
(43, 'log-edit', 'web', '2024-10-12 03:25:02', '2024-10-12 03:25:02'),
(44, 'log-delete', 'web', '2024-10-12 03:25:02', '2024-10-12 03:25:02'),
(45, 'dayoff-list', 'web', '2024-10-14 07:15:09', '2024-10-14 07:15:09'),
(46, 'dayoff-create', 'web', '2024-10-14 07:15:09', '2024-10-14 07:15:09'),
(47, 'dayoff-edit', 'web', '2024-10-14 07:15:09', '2024-10-14 07:15:09'),
(48, 'dayoff-delete', 'web', '2024-10-14 07:15:09', '2024-10-14 07:15:09'),
(49, 'dayoff-detail', 'web', '2024-10-17 04:49:24', '2024-10-17 04:49:24'),
(50, 'dayoff-confirm', 'web', '2024-10-22 04:26:10', '2024-10-22 04:30:02'),
(51, 'capture', 'web', '2024-10-24 07:11:12', '2024-10-24 07:11:12'),
(53, 'pegawai-timeline', 'web', '2024-10-26 08:57:07', '2024-10-26 08:57:07'),
(54, 'dashboard', 'web', '2024-10-31 02:46:41', '2024-10-31 02:46:41'),
(55, 'dashboard-user', 'web', '2024-10-31 02:47:59', '2024-11-12 01:22:43'),
(56, 'collect-list', 'web', '2024-11-26 16:13:43', '2024-11-26 16:13:43'),
(57, 'collect-create', 'web', '2024-11-26 16:13:43', '2024-11-26 16:13:43'),
(58, 'collect-edit', 'web', '2024-11-26 16:13:43', '2024-11-26 16:13:43'),
(59, 'collect-delete', 'web', '2024-11-26 16:13:43', '2024-11-26 16:13:43'),
(60, 'collect-approve', 'web', '2024-11-26 16:13:43', '2024-11-26 16:13:43');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', '2024-10-11 03:25:37', '2024-10-11 03:25:37'),
(2, 'HRD', 'web', '2024-10-11 03:25:37', '2024-10-11 03:25:37'),
(7, 'Employee', 'web', '2024-10-14 06:26:09', '2024-10-14 06:26:09'),
(8, 'Management', 'web', '2024-10-17 09:28:29', '2024-10-17 09:28:29'),
(9, 'Teknisi', 'web', '2024-11-08 06:34:23', '2024-11-08 06:34:23'),
(10, 'Driver', 'web', '2024-11-08 06:34:39', '2024-11-08 06:34:39'),
(11, 'Collector', 'web', '2024-11-08 06:34:58', '2024-11-08 06:34:58'),
(12, 'Piutang', 'web', '2024-12-16 01:11:26', '2024-12-16 01:11:26');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(21, 2),
(22, 2),
(23, 2),
(25, 2),
(26, 2),
(27, 2),
(29, 2),
(30, 2),
(31, 2),
(33, 2),
(34, 2),
(35, 2),
(37, 2),
(38, 2),
(39, 2),
(42, 2),
(45, 2),
(49, 2),
(50, 2),
(53, 2),
(54, 2),
(42, 7),
(51, 7),
(55, 7),
(21, 8),
(22, 8),
(23, 8),
(24, 8),
(25, 8),
(26, 8),
(27, 8),
(28, 8),
(29, 8),
(30, 8),
(31, 8),
(32, 8),
(33, 8),
(34, 8),
(35, 8),
(36, 8),
(37, 8),
(38, 8),
(39, 8),
(40, 8),
(42, 8),
(45, 8),
(46, 8),
(47, 8),
(48, 8),
(49, 8),
(54, 8),
(42, 9),
(45, 9),
(46, 9),
(47, 9),
(49, 9),
(51, 9),
(55, 9),
(42, 10),
(45, 10),
(46, 10),
(47, 10),
(49, 10),
(51, 10),
(55, 10),
(42, 11),
(55, 11),
(56, 11),
(57, 11),
(58, 11),
(56, 12),
(58, 12),
(60, 12);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('B7sAPx7Enli4wR7Kpf3RAYV5G10461AKxHp7mSRq', 1026, '140.213.147.44', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.26.1-gn', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiZ2cyaW1TazlLcHhScDE1VFo0R1U3YVN6VFNpRDlNT0h3YVVkejZWcCI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTAyNjtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo5NDoiaHR0cDovL2luZG9kYWNpbi5udXNhLm5ldC5pZC9mNmZhNDY1NDU1YTFhOWNhYTc5ODU0ODc2MzYyZTdjNzRiMGY5MzVmLzMxNDUwMjAyNTAxMDdfMDc1NjM2LnBuZyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MTI6ImN1cnJlbnRfZGF0ZSI7czoxNToiMjAyNTAxMDdfMDc1NjM2Ijt9', 1736211416),
('bDbBGfmCEDWxsiGJhMNyFLrJZCHuasPTUP47RP4U', 1031, '114.122.4.238', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiU0lBS3N1WWF4cGptQ1V1eVVqcUFWdTVXV1pvSlZwd0dlUXlNRnFxViI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQ2OiJodHRwOi8vaW5kb2RhY2luLm51c2EubmV0LmlkL2Rhc2hib2FyZC9jb2xsZWN0Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTAzMTt9', 1736154027),
('kzYR2ljJsRUi7RQ2lWEpv0HCBJV6xbe4UJojXcgB', 1030, '114.122.20.251', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRG9jY0xXN3NmUjRyeDVTQ25qaXdVQmRjZGxVOVVJN2FzOW9wOFY4USI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTAzMDtzOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1MzoiaHR0cDovL2luZG9kYWNpbi5udXNhLm5ldC5pZC9kYXNoYm9hcmQvY29sbGVjdC9jcmVhdGUiO319', 1736215411),
('L0IVqgsA82BglpAZFs5Z4vMrDC6NesdPQgr2fCWG', 1026, '203.78.119.49', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.26.1-gn', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiaGw3dUF1WFZ2NVR1NHhtc0l1WlFQVkE5azV3NTUyNkdRN3hUYkgxSCI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTAyNjtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozODoiaHR0cDovL2luZG9kYWNpbi5udXNhLm5ldC5pZC9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjEyOiJjdXJyZW50X2RhdGUiO3M6MTU6IjIwMjUwMTA2XzE3Mzc1MSI7fQ==', 1736159908),
('LcitMYkJQBvgfC97FbidjZm8tXVni27UFMJq6yCh', 1030, '114.122.20.227', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicG0zb3BIMUU3TklQQVVhaFNsZ0hwY1JGS0hMWHFNcG5RSlBSdGxCciI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTAzMDtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0NjoiaHR0cDovL2luZG9kYWNpbi5udXNhLm5ldC5pZC9kYXNoYm9hcmQvY29sbGVjdCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1736155111),
('qms1pFWxmZ6JWZ2IDyIszkP3KT1ysD6zslL5t6X6', 1032, '192.168.11.235', 'Mozilla/5.0 (Windows NT 6.1; rv:107.0) Gecko/20100101 Firefox/107.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoialFuUEFZbElLZjdWNWxKdWUzWFlobnVIbHRLdjEwall6bEJqa3FISiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDY6Imh0dHA6Ly9pbmRvZGFjaW4ubnVzYS5uZXQuaWQvZGFzaGJvYXJkL2NvbGxlY3QiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxMDMyO30=', 1736157428),
('SDmgoomwUPJk7yIgFHQKCntO8wM7U32dy96k6fOI', 1, '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiT0xCTjE5S1ZEeG92QVcxb042d1NGZ0U5aDh1TnR1dGpUZkh5NzBWZCI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0NjoiaHR0cDovL2luZG9kYWNpbi5udXNhLm5ldC5pZC9kYXNoYm9hcmQvY29sbGVjdCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1736215455),
('YrerzYOvqVLFnC3EBoT0HC6I7LPOXB1Ng0srqZ6c', 1033, '192.168.11.226', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoid1JPTmkxdm91cVJoc0I1RG1pWldwMVpkYTJUNjBhTDgyWkEwcjB5RCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly9pbmRvZGFjaW4ubnVzYS5uZXQuaWQvZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTAzMzt9', 1736153517);

-- --------------------------------------------------------

--
-- Table structure for table `tb_allowance`
--

CREATE TABLE `tb_allowance` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_pegawai` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `allowance_name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `allowance_type` float DEFAULT NULL COMMENT 'persen atau terbilang\r\n(5%) atau 5000',
  `allowance_fee` bigint DEFAULT NULL COMMENT 'kalau persen, dikalikan dengan gaji. kalau terbilang ya langsung sebut berapa',
  `allowance_period` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_allowance`
--

INSERT INTO `tb_allowance` (`id`, `kode_pegawai`, `allowance_name`, `allowance_type`, `allowance_fee`, `allowance_period`, `created_at`, `updated_at`) VALUES
(1, '28101999', 'Premi Keahlian', 500000, 500000, '2024-10-01', '2024-11-02 02:02:45', '2024-11-07 04:50:31'),
(2, '28101999', 'Tunjangan Jabatan', 300000, 300000, '2024-10-01', '2024-11-02 02:09:06', '2024-11-07 04:50:08'),
(3, '28101999', 'Tunjangan Masa Kerja', 15, 600000, '2024-10-01', '2024-11-06 02:38:36', '2024-11-07 09:34:39');

-- --------------------------------------------------------

--
-- Table structure for table `tb_attendance`
--

CREATE TABLE `tb_attendance` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_pegawai` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `upl` tinyint DEFAULT NULL,
  `upl68` tinyint DEFAULT NULL,
  `uplm68` tinyint DEFAULT NULL,
  `upljam` tinyint DEFAULT NULL,
  `jenis` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `waktuori` datetime DEFAULT NULL,
  `status` tinyint DEFAULT NULL,
  `jam_masuk` datetime NOT NULL,
  `longitude` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `latitude` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `photoURL` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_attendance`
--

INSERT INTO `tb_attendance` (`id`, `kode_pegawai`, `upl`, `upl68`, `uplm68`, `upljam`, `jenis`, `waktuori`, `status`, `jam_masuk`, `longitude`, `latitude`, `photoURL`, `created_at`, `updated_at`) VALUES
(66, '112233', 0, 0, 0, 0, 'Wajah', '2024-11-13 13:54:56', 1, '2024-11-13 13:54:56', NULL, NULL, '11223320241113_135456', '2024-11-13 06:54:56', '2024-11-13 06:54:56'),
(67, '123123', 0, 0, 0, 0, 'Wajah', '2024-11-13 16:14:11', 1, '2024-11-13 16:14:11', '98.6665848', '3.6076307', '12312320241113_161410', '2024-11-13 09:14:11', '2024-11-13 09:14:11'),
(68, '112233', 0, 0, 0, 0, 'Wajah', '2024-11-14 07:45:27', 1, '2024-11-14 07:45:27', '97.9491521', '2.6319443', '11223320241114_074526', '2024-11-14 00:45:27', '2024-11-14 00:45:27'),
(70, '315', 0, 0, 0, 0, 'Wajah', '2024-11-14 15:31:17', 1, '2024-11-14 15:31:17', '102.83983166667', '-4.37809', '31520241114_153116', '2024-11-14 08:31:17', '2024-11-14 08:31:17'),
(71, '112233', 0, 0, 0, 0, 'Wajah', '2024-11-15 08:07:35', 1, '2024-11-15 08:07:35', '97.9489783', '2.6319867', '11223320241115_080734', '2024-11-15 01:07:35', '2024-11-15 01:07:35'),
(73, '31450', 0, 0, 0, 0, 'Wajah', '2024-11-21 08:12:57', 1, '2024-11-21 08:12:57', '98.4803001', '3.62132', '3145020241121_081254', '2024-11-21 01:12:57', '2024-11-21 01:12:57'),
(74, '31450', 0, 0, 0, 0, 'Wajah', '2024-11-22 07:40:14', 1, '2024-11-22 07:40:14', '101.4266918', '0.603567', '3145020241122_074012', '2024-11-22 00:40:14', '2024-11-22 00:40:14'),
(79, '31450', 0, 0, 0, 0, 'Wajah', '2024-11-28 12:32:03', 1, '2024-11-28 12:32:03', '101.8316283', '0.424675', '3145020241128_123202', '2024-11-28 12:32:03', '2024-11-28 12:32:03'),
(83, '31450', 0, 0, 0, 0, 'Wajah', '2024-12-27 08:44:07', 1, '2024-12-27 08:44:07', '101.8317005', '0.424646', '3145020241227_084349', '2024-12-27 01:44:07', '2024-12-27 01:44:07'),
(87, '31450', 0, 0, 0, 0, 'Wajah', '2024-12-28 07:58:11', 1, '2024-12-28 07:58:11', '101.831695', '0.4247233', '3145020241228_075755', '2024-12-28 00:58:11', '2024-12-28 00:58:11'),
(88, '31450', 0, 0, 0, 0, 'Wajah', '2024-12-28 07:58:11', 1, '2024-12-28 07:58:11', '101.831695', '0.4247233', '3145020241228_075755', '2024-12-28 00:58:11', '2024-12-28 00:58:11'),
(89, '31450', 0, 0, 0, 0, 'Wajah', '2024-12-30 08:09:57', 1, '2024-12-30 08:09:57', '101.8315117', '0.42467', '3145020241230_080940', '2024-12-30 01:09:57', '2024-12-30 01:09:57'),
(90, '31450', 0, 0, 0, 0, 'Wajah', '2024-12-31 07:52:46', 1, '2024-12-31 07:52:46', '101.831675', '0.4246867', '3145020241231_075238', '2024-12-31 00:52:46', '2024-12-31 00:52:46'),
(91, '31450', 0, 0, 0, 0, 'Wajah', '2025-01-02 07:44:19', 1, '2025-01-02 07:44:19', '101.8317164', '0.4247133', '3145020250102_074411', '2025-01-02 00:44:19', '2025-01-02 00:44:19'),
(92, '31450', 0, 0, 0, 0, 'Wajah', '2025-01-03 08:02:08', 1, '2025-01-03 08:02:08', '101.8320683', '0.4247033', '3145020250103_080200', '2025-01-03 01:02:08', '2025-01-03 01:02:08'),
(93, '31450', 0, 0, 0, 0, 'Wajah', '2025-01-04 07:57:36', 1, '2025-01-04 07:57:36', '101.831672', '0.4247977', '3145020250104_075728', '2025-01-04 00:57:36', '2025-01-04 00:57:36'),
(94, '31450', 0, 0, 0, 0, 'Wajah', '2025-01-06 07:42:01', 1, '2025-01-06 07:42:01', '101.831615', '0.4247', '3145020250106_074155', '2025-01-06 00:42:01', '2025-01-06 00:42:01'),
(95, '31450', 0, 0, 0, 0, 'Wajah', '2025-01-07 07:56:44', 1, '2025-01-07 07:56:44', '101.8316147', '0.4247314', '3145020250107_075636', '2025-01-07 00:56:44', '2025-01-07 00:56:44');

-- --------------------------------------------------------

--
-- Table structure for table `tb_attendance_out`
--

CREATE TABLE `tb_attendance_out` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_pegawai` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `upl` tinyint DEFAULT NULL,
  `upl68` tinyint DEFAULT NULL,
  `uplm68` tinyint DEFAULT NULL,
  `upljam` tinyint DEFAULT NULL,
  `jenis` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `waktuori` datetime DEFAULT NULL,
  `status` tinyint DEFAULT NULL,
  `jam_keluar` datetime NOT NULL,
  `longitude` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `latitude` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `photoURL` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_attendance_out`
--

INSERT INTO `tb_attendance_out` (`id`, `kode_pegawai`, `upl`, `upl68`, `uplm68`, `upljam`, `jenis`, `waktuori`, `status`, `jam_keluar`, `longitude`, `latitude`, `photoURL`, `created_at`, `updated_at`) VALUES
(200, '123123', 0, 0, 0, 0, 'Wajah', '2024-11-13 16:17:46', 1, '2024-11-13 16:17:46', '99.165423363447', '3.3360303965685', '12312320241113_161745', '2024-11-13 09:17:46', '2024-11-13 09:17:46'),
(201, '123123', 0, 0, 0, 0, 'Wajah', '2024-11-13 16:23:12', 1, '2024-11-13 16:23:12', '99.792172461748', '2.9617536159645', '12312320241113_162311', '2024-11-13 09:23:12', '2024-11-13 09:23:12'),
(202, '112233', 0, 0, 0, 0, 'Wajah', '2024-11-13 16:32:00', 1, '2024-11-13 16:32:00', '97.9492047', '2.632071', '11223320241113_163159', '2024-11-13 09:32:00', '2024-11-13 09:32:00'),
(207, '112233', 0, 0, 0, 0, 'Wajah', '2024-11-14 19:02:11', 1, '2024-11-14 19:02:11', '97.9172414', '2.6270318', '11223320241114_190210', '2024-11-14 12:02:11', '2024-11-14 12:02:11'),
(209, '31450', 0, 0, 0, 0, 'Wajah', '2024-11-21 08:13:56', 1, '2024-11-21 08:13:56', '98.4802951', '3.6213185', '3145020241121_081354', '2024-11-21 01:13:56', '2024-11-21 01:13:56'),
(210, '31450', 0, 0, 0, 0, 'Wajah', '2024-11-21 08:15:39', 1, '2024-11-21 08:15:39', '98.480309', '3.621199', '3145020241121_081536', '2024-11-21 01:15:39', '2024-11-21 01:15:39'),
(211, '31450', 0, 0, 0, 0, 'Wajah', '2024-11-22 16:32:17', 1, '2024-11-22 16:32:17', '101.8316983', '0.42462', '3145020241121_081536', '2024-11-22 09:32:17', '2024-11-22 09:32:17'),
(229, '31450', 0, 0, 0, 0, 'Wajah', '2024-12-27 08:45:38', 1, '2024-12-27 08:45:38', '101.8317979', '0.4245923', '3145020241227_084533', '2024-12-27 01:45:38', '2024-12-27 01:45:38'),
(232, '31450', 0, 0, 0, 0, 'Wajah', '2024-12-27 17:20:56', 1, '2024-12-27 17:20:56', '101.8317271', '0.4247419', '3145020241227_172043', '2024-12-27 10:20:56', '2024-12-27 10:20:56'),
(233, '31450', 0, 0, 0, 0, 'Wajah', '2024-12-28 17:15:10', 1, '2024-12-28 17:15:10', '101.8316683', '0.4248', '3145020241228_171502', '2024-12-28 10:15:10', '2024-12-28 10:15:10'),
(234, '31450', 0, 0, 0, 0, 'Wajah', '2024-12-28 17:15:14', 1, '2024-12-28 17:15:14', '101.8316712', '0.4248048', '3145020241228_171502', '2024-12-28 10:15:14', '2024-12-28 10:15:14'),
(235, '31450', 0, 0, 0, 0, 'Wajah', '2024-12-30 08:10:06', 1, '2024-12-30 08:10:06', '101.8315117', '0.42467', '3145020241230_080940', '2024-12-30 01:10:06', '2024-12-30 01:10:06'),
(236, '31450', 0, 0, 0, 0, 'Wajah', '2024-12-30 17:23:50', 1, '2024-12-30 17:23:50', '101.8315995', '0.424702', '3145020241230_172335', '2024-12-30 10:23:50', '2024-12-30 10:23:50'),
(237, '31450', 0, 0, 0, 0, 'Wajah', '2024-12-30 17:23:50', 1, '2024-12-30 17:23:50', '101.8315995', '0.424702', '3145020241230_172335', '2024-12-30 10:23:50', '2024-12-30 10:23:50'),
(238, '31450', 0, 0, 0, 0, 'Wajah', '2024-12-30 17:23:50', 1, '2024-12-30 17:23:50', '101.8315995', '0.424702', '3145020241230_172335', '2024-12-30 10:23:50', '2024-12-30 10:23:50'),
(239, '31450', 0, 0, 0, 0, 'Wajah', '2024-12-31 17:20:12', 1, '2024-12-31 17:20:12', '101.831726', '0.424871', '3145020241231_172006', '2024-12-31 10:20:12', '2024-12-31 10:20:12'),
(240, '31450', 0, 0, 0, 0, 'Wajah', '2025-01-02 17:11:15', 1, '2025-01-02 17:11:15', '101.8316916', '0.4247715', '3145020250102_171112', '2025-01-02 10:11:15', '2025-01-02 10:11:15'),
(241, '31450', 0, 0, 0, 0, 'Wajah', '2025-01-03 08:03:46', 1, '2025-01-03 08:03:46', '101.8319283', '0.4247983', '3145020250103_080341', '2025-01-03 01:03:46', '2025-01-03 01:03:46'),
(242, '31450', 0, 0, 0, 0, 'Wajah', '2025-01-03 17:20:41', 1, '2025-01-03 17:20:41', '101.8316347', '0.4247452', '3145020250103_172038', '2025-01-03 10:20:41', '2025-01-03 10:20:41'),
(243, '31450', 0, 0, 0, 0, 'Wajah', '2025-01-04 07:57:37', 1, '2025-01-04 07:57:37', '101.8316767', '0.4248068', '3145020250104_075728', '2025-01-04 00:57:37', '2025-01-04 00:57:37'),
(244, '31450', 0, 0, 0, 0, 'Wajah', '2025-01-04 17:05:00', 1, '2025-01-04 17:05:00', '101.8316617', '0.4248083', '3145020250104_170459', '2025-01-04 10:05:00', '2025-01-04 10:05:00'),
(245, '31450', 0, 0, 0, 0, 'Wajah', '2025-01-06 17:37:49', 1, '2025-01-06 17:37:49', '101.83162', '0.42476', '3145020250106_173735', '2025-01-06 10:37:49', '2025-01-06 10:37:49');

-- --------------------------------------------------------

--
-- Table structure for table `tb_collect`
--

CREATE TABLE `tb_collect` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_pegawai` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `location` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_collect`
--

INSERT INTO `tb_collect` (`id`, `kode_pegawai`, `title`, `keterangan`, `location`, `longitude`, `latitude`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(10, '394', 'Absen sore', '<p>Absen sore absen sore absen sore absen sore absen sore absen sore absen sore absen sore absen sore absen sore absen sore absen sore absen sore plg jm 5</p>', 'Kantor Indodacin', '98.6689616', '3.5914793', 1, NULL, '2024-12-03 16:31:43', '2024-12-03 17:00:45'),
(13, '394', 'Panin', '<p>Paninnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnjdkfjfjfkgkffkfkfkfkfkfkfkfkfkfkfkfkgkglgoy</p>', 'Panin', '98.6789367', '3.5889016', 1, NULL, '2024-12-04 10:34:39', '2024-12-04 15:01:37'),
(14, '394', 'Mandiri', '<p>Mandiri jdjdjdjekekdjdjdjdjdjdjsjslwlsldjdjdjdjejejdjdjdjdjdjdjdjdjdjdjdjdjdjdjejjdjdkekdjdjdjdjdjdjdjdjdjdjdjdhdhdjk</p>', 'Mandiri', '98.6777331', '3.5897003', 1, NULL, '2024-12-04 10:42:23', '2024-12-04 15:01:30'),
(15, '394', 'Ocbcc', '<p>Ocbc ejjekslsoeidjjdjdjdododkdjdjfjdjdododjdjdjrorododkdjdjdjdjdjdjdjdjdkdidpeprkfjfjfifofofororkfjdj</p>', 'Ocbcc', '98.6670215', '3.5925446', 1, NULL, '2024-12-04 11:26:27', '2024-12-04 15:01:24'),
(18, '394', 'Abccc', '<p>Abc skdjdjdodpdkdndjdiirkfjrjrjfjfbfkfldldkdjdbdndndjdldkdkdndnfjdjfkfofpfodjdjdorprodododkfjdndkdjdj</p>', 'ABC', '98.6772534', '3.5890446', 1, NULL, '2024-12-04 15:55:24', '2024-12-05 13:14:14'),
(19, '394', 'Permata danamon bca bri uob bsi', '<p>Permata danamon bca bri uob bsi jakdkjdjdjskskjdjdjdkskkskdkdkkdkdkdkdjjdkdkdokdkddkk</p>', 'Permata danamon bca bri bsi', '98.677266', '3.5890692', 1, NULL, '2024-12-04 16:01:12', '2024-12-06 16:05:19'),
(20, '394', 'Ktrrr', '<p>Ktr jsjdkdldbdidpdpdkfjdjdofldpdjfjfjfjfkpeepfkfjforodnfhfjfkfofkfjfkflfodofkfnfbndkdpdpdlldkfjfj</p>', 'Ktr', '98.6689488', '3.5914883', 1, NULL, '2024-12-04 16:12:33', '2024-12-05 13:14:28'),
(23, '394', 'Niaga', '<p>Niaga djdjjdkdododjdjdjdjdofodoodjdjsjsjsksosopsoaisjdjdidodoidjdjdkdkdodododododidjkdkdldpdo</p>', 'Niaga', '98.6643816', '3.5915455', 1, NULL, '2024-12-05 08:47:06', '2024-12-05 13:14:42'),
(26, '394', 'Uobbb', '<p>Uob sjdndnkdkxbdjdodlsjdjdjdjdjdpdoxjdjdkwkoasojdjdkdkdjdkdkkdkdododkjddkkfpfofjfjkdkxpdo</p>', 'Uobbb', '98.6810388', '3.5849775', 1, NULL, '2024-12-05 09:21:15', '2024-12-05 13:14:57'),
(33, '394', 'Mandiri', '<p>Mandiri bdjdklflfkfjfjfkfkfkfkfjfngjgkfkckckclfkfkjvkgkgkgkgkgickvigigigixjrkdkfhfjfjfkfkfkfkfkfkfkfkfkffk</p>', 'Mandiri', '98.6807691', '3.5849105', 1, NULL, '2024-12-05 10:56:27', '2024-12-05 13:15:14'),
(34, '394', 'Permata', '<p>Permata fjdldpdkdjfocpclcjfjfofofofjdjdkpspsodkfjfofofkdjjdjdjfjfkfjfkfopfodkdodkfkfjf</p>', 'Permata', '98.6742575', '3.5831522', 1, NULL, '2024-12-05 11:31:55', '2024-12-05 13:15:25'),
(35, '394', 'Bcaaa', '<p>Bca djfkkfhdjdujfkdjdkodididijdjdjfjdjkcjdjfogohohogogkgkgzkgdkhdlhdlhdoydkydkgxkydlyd</p>', 'Bcaaa', '98.6687321', '3.5924223', 1, NULL, '2024-12-05 14:51:01', '2024-12-06 08:06:08'),
(36, '394', 'Dragon', '<p>Dragon djdkkdosjdjdkflfldmndndjfkfkfkfkflflfjfnfnflflglgkgjfjfkfkfkfkfkfkfkfkfkfjfjfj</p>', 'Dragon', '98.6822216', '3.5905569', 1, NULL, '2024-12-05 15:48:32', '2024-12-06 08:06:23'),
(38, '394', 'Bsiii', '<p>Kgskhdlhdludludludludlufljdlhdlhdlhdlhdlydhdkhdohdkhdlhdhlhdlhdlhchclhxohcljflhxlhxlhxlhdluxlufljf</p>', 'Bsiii', '98.6663963', '3.5923027', 1, NULL, '2024-12-06 15:12:18', '2024-12-06 16:05:31'),
(46, '493', 'Anter tt', '<p>Anter tt</p>', 'Ismud', '98.6606479', '3.5845168', 1, NULL, '2024-12-12 01:35:42', '2024-12-12 04:58:12'),
(47, '493', 'Anter tt dan tagihan', '<p>Anter tt dan tagihan</p>', 'S.parman', '98.6671039', '3.5795895', 1, NULL, '2024-12-12 01:44:46', '2024-12-12 04:58:23'),
(48, '493', 'Anter tagihan lunas', '<p>Anter tagihan lunas</p>', 'Komp.multatuli', '98.6801167', '3.5762558', 1, NULL, '2024-12-12 02:14:21', '2024-12-12 04:58:33'),
(49, '493', 'Anter tt', '<p>Anter tt</p>', 'Komp multatuli', '98.6809921', '3.5764239', 1, NULL, '2024-12-12 02:20:05', '2024-12-12 04:58:44'),
(50, '493', 'Anter tt', '<p>Anter tt</p>', 'Katamso bisnis center', '98.6857345', '3.5749051', 1, NULL, '2024-12-12 02:32:31', '2024-12-12 04:59:10'),
(51, '493', 'Anter tt', '<p>Anter tt</p>', 'Taman Polonia 4', '98.6804245', '3.5701055', 1, NULL, '2024-12-12 02:43:23', '2024-12-12 04:59:16'),
(52, '394', 'Niaga', '<p>Kgskyskyskhskhzkhskhzkhzkhdkhskhdkydysoyskydkhdoydkydkyskysykhdkysoydkyzkhxuldlhdlud</p>', 'Niaga', '98.6739687', '3.5863198', 1, NULL, '2024-12-12 02:56:45', '2024-12-12 05:00:21'),
(53, '493', 'Anter tagihan lunas', '<p>Anter tagihan lunas</p>', 'Komp Sanur Deli tua', '98.6800045', '3.5172515', 1, NULL, '2024-12-12 04:05:16', '2024-12-12 04:59:26'),
(54, '493', 'Nagih', '<p>Nagih</p>', 'Katamso', '98.6886016', '3.5523902', 1, NULL, '2024-12-12 04:22:26', '2024-12-12 04:59:34'),
(55, '493', 'Naigih..', '<p>Nagih.</p>', 'CBD polonia', '98.6770629', '3.557002', 1, NULL, '2024-12-12 04:50:28', '2024-12-12 04:59:40'),
(56, '493', 'Nagih..', '<p>Nagih</p>', 'Katamso GG mantri', '98.6824274', '3.5796569', 1, NULL, '2024-12-12 05:22:49', '2024-12-12 05:39:30'),
(57, '493', 'Anter tt dan nagih', '<p>Anter tt dan nagih</p>', 'Pandu', '98.6858878', '3.5828399', 1, NULL, '2024-12-12 06:09:07', '2024-12-12 07:42:19'),
(58, '394', 'Mandiri', '<p>Khdkgskgzkgzigdigxigdy8htshxhodgigxohxohdohdohdoudohdohxohxohxohdouxohxohxohxohd</p>', 'Mandiri', '98.6777966', '3.5895656', 1, NULL, '2024-12-12 07:30:55', '2024-12-12 07:42:32'),
(59, '394', 'Staaaa', '<p>Uldljfljflysylhdhlhdhlhclhdohdoydoysoydlhdhlhdlhdlhflhcljcljflhxlbcljclhdohxogxohxlhxlydp</p>', 'Staaaa', '98.6673687', '3.5844434', 1, NULL, '2024-12-12 08:31:21', '2024-12-12 08:39:33'),
(60, '394', 'Pandu', '<p>xhdlhdludlhdljfljfludldhdlydlhdludlhxudlhxlhdjflhcljfljfpjfulbdkhdkhxhxlhxlhdlhxlhclhclhd</p>', 'Pandu', '98.6843452', '3.5821999', 1, NULL, '2024-12-12 09:21:18', '2024-12-12 09:22:16'),
(61, '493', 'Tnda trm', '<p>Tnda trm</p>', 'Simatupang', '98.6158394', '3.5832784', 1, NULL, '2024-12-13 02:07:20', '2024-12-13 03:54:25'),
(62, '493', 'Tagihan', '<p>Tagihan</p>', 'Patumbak', '98.7190313', '3.529108', 1, NULL, '2024-12-13 03:16:39', '2024-12-13 03:54:42'),
(63, '493', 'Tagihan', '<p>Tagihan blm ada</p>', 'Patumbak', '98.7181329', '3.5321579', 1, NULL, '2024-12-13 03:26:35', '2024-12-13 03:54:58'),
(64, '493', 'Tagihan', '<p>Tagihan</p>', 'Pandu', '98.685677', '3.5827259', 1, NULL, '2024-12-13 03:52:26', '2024-12-13 03:55:09'),
(65, '493', 'Tnda trm', '<p>Tnda trm</p>', 'Sutomo', '98.6822128', '3.5959017', 1, NULL, '2024-12-13 04:01:07', '2024-12-13 04:19:59'),
(66, '493', 'Tagihan', '<p>Tagihan</p>', 'Pandu', '98.6856752', '3.5827278', 1, NULL, '2024-12-13 06:53:32', '2024-12-13 08:56:59'),
(67, '493', 'Tagihan', '<p>Bayar</p>', 'Gatsu', '98.665515', '3.5924367', 1, NULL, '2024-12-14 02:53:25', '2024-12-14 03:01:17'),
(68, '493', 'TKO GINA jaya', '<p>Cri orderan</p>', 'Pajak sambas', '98.6868789', '3.580478', 1, NULL, '2024-12-14 07:08:57', '2024-12-14 07:41:21'),
(69, '493', 'Tagihan', '<p>Transfer</p>', 'Pajak sambas', '98.6872746', '3.5802775', 1, NULL, '2024-12-14 07:26:29', '2024-12-14 07:41:37'),
(70, '493', 'TKO serasi', '<p>Cri orderan</p>', 'Pajak sambas', '98.6872746', '3.5802775', 1, NULL, '2024-12-14 07:27:35', '2024-12-14 07:41:54'),
(71, '493', 'Tagihan', '<p>Bayar</p>', 'Mt haryono', '98.6852485', '3.5869722', 1, NULL, '2024-12-14 07:41:58', '2024-12-14 07:42:14'),
(72, '493', 'TKO koni', '<p>Cri orderan</p>', 'Mt haryono', '98.6854214', '3.5870171', 1, NULL, '2024-12-14 07:45:45', '2024-12-14 09:56:50'),
(73, '74', 'Tanda terima', '<p>Tanda terima</p>', 'Jl. Sumatera', '98.6689889', '3.5914759', 1, NULL, '2024-12-16 00:59:49', '2024-12-16 03:29:31'),
(75, '74', 'PT multimas nabati asahan', '<p>Tanda terima </p>', 'Jw mariot', '98.6758591', '3.5964436', 1, NULL, '2024-12-16 02:21:02', '2024-12-16 03:33:00'),
(76, '493', 'Tanda trm SAHABAT MEWAH', '<p>Tnda trm SAHABAT MEWAH</p>', 'Sinar mas land plaza', '98.672413', '3.583176', 1, NULL, '2024-12-16 02:34:52', '2024-12-16 04:08:51'),
(77, '74', 'PT sawit jambi lestari', '<p>Antar sertifikat tera</p>', 'Uniland Asian agri', '98.6825811', '3.5865429', 1, NULL, '2024-12-16 02:41:47', '2024-12-16 03:41:05'),
(78, '493', 'Tnda trm PT BANDAR SUMATERA INDONESIA', '<p>Tnda trm BANDAR SUMATERA INDONESIA</p>', 'CIMB niaga plaza', '98.669979', '3.5871683', 1, NULL, '2024-12-16 02:46:08', '2024-12-16 04:07:56'),
(79, '74', 'PT sawit permai abadi', '<p>Antar sertifikat tera </p>', 'Komp center point', '98.6819088', '3.5907886', 1, NULL, '2024-12-16 02:50:30', '2024-12-16 03:42:22'),
(80, '493', 'Anter surat tera Binti Jaya Baja', '<p>Sertifikat srt tera Binti Jaya Baja</p>', 'Gatsu', '98.6668686', '3.5924312', 1, NULL, '2024-12-16 02:52:23', '2024-12-16 04:16:31'),
(81, '74', 'BPK aho bintang terang', '<p>Tanda terima </p>', 'Pusat pasar belakang sambu', '98.6859453', '3.5903468', 1, NULL, '2024-12-16 03:02:50', '2024-12-16 03:37:11'),
(82, '74', 'PT parasawita', '<p>Tanda terimaa</p>', 'Jln kalimantan', '98.6906096', '3.5905007', 1, NULL, '2024-12-16 03:30:10', '2024-12-16 04:17:40'),
(83, '74', 'PT cipta prima interwood', '<p>Tanda terima hariselas jam 2 s/d4 sore</p>', 'Jln HM Yamin no46', '98.6843374', '3.5956796', 1, NULL, '2024-12-16 03:39:11', '2024-12-16 04:18:20'),
(84, '493', 'Tagihan BPK abeng', '<p>Bayar</p>', 'Klumpang', '98.5956271', '3.6688072', 1, NULL, '2024-12-16 03:44:24', '2024-12-16 04:05:33'),
(85, '74', 'PT univista utamaa', '<p>Tanda terima ok ya</p>', 'Jln Ghandi 111', '98.6902383', '3.5833497', 1, NULL, '2024-12-16 03:48:02', '2024-12-16 04:18:51'),
(86, '74', 'PT Surya mentari indah', '<p>Tanda terima ok ya</p>', 'Jln Ghandi no36/160', '98.6906676', '3.583405', 1, NULL, '2024-12-16 03:53:00', '2024-12-16 04:19:12'),
(88, '74', 'Ayen cse', '<p>Antar bon yg SDH lunas</p>', 'Jln Sutrisno 173 b', '98.6999418', '3.5823263', 1, NULL, '2024-12-16 04:00:27', '2024-12-16 04:04:48'),
(89, '74', 'PT prima tangki indonesia', '<p>Tanda terima ok ya</p>', 'Jln rencong 1b', '98.7038997', '3.5896239', 1, NULL, '2024-12-16 04:08:54', '2024-12-16 04:19:32'),
(90, '394', 'Bagi kalender', '<p>Cemara kysoyskgzkhxlydogskgzoyzoysoysoysoydgggggghhgggmvzkgslysyidyyoydohdoydohdoy</p>', 'Bagi kalender', '98.6810497', '3.6294401', 1, NULL, '2024-12-16 08:44:33', '2024-12-17 01:18:26'),
(91, '74', 'PT persadanusa nabati Indonesia', '<p>Tanda terima ok ya</p><p>Sama pak satpam namanya Hendra </p>', 'Komp graha metropolitan blok t7', '98.6473643', '3.6260927', 1, NULL, '2024-12-17 01:21:51', '2024-12-17 09:06:35'),
(92, '74', 'PT Garuda mas perkasa', '<p>Antar sertifikat tera </p><p>Satpam namanya Sri rejeki </p>', 'Jln yos Sudarso km 6.5', '98.6684441', '3.6361453', 1, NULL, '2024-12-17 01:42:49', '2024-12-17 09:12:13'),
(93, '74', 'PT industri karet deli', '<p>Antar surat tera</p>', 'Jln yos Sudarso km 8.3', '98.6613974', '3.6537653', 1, NULL, '2024-12-17 02:04:16', '2024-12-17 09:16:22'),
(94, '74', 'PT Mabar feed indonesi', '<p>Gak bisa di TT </p>', 'Jln rumah potong hewan', '98.6685424', '3.658237', 1, NULL, '2024-12-17 02:25:49', '2024-12-17 09:16:48'),
(95, '74', 'PT logistik pendingin Indonesia', '<p>Tanda terima ok </p><p>Yg terima yuda</p>', 'Kayu putih gudang138e', '98.6805845', '3.651509', 1, NULL, '2024-12-17 02:37:13', '2024-12-17 09:17:09'),
(96, '493', 'Tnda trm PT indojaya agrinusa', '<p>Ok</p>', 'Tnjg morawa', '98.7563715', '3.5262352', 1, NULL, '2024-12-17 02:44:27', '2024-12-17 09:17:32'),
(97, '74', 'PT growth asia', '<p>Tanda terima ok ya</p><p>Kak Nurul</p>', 'Kim 1', '98.6697295', '3.6704279', 1, NULL, '2024-12-17 02:54:40', '2024-12-17 09:17:53'),
(98, '74', 'PT Tapteng anugrah sawit', '<p>Tanda terima ok</p>', 'Kim 1', '98.6749554', '3.6730043', 1, NULL, '2024-12-17 03:08:09', '2024-12-17 09:15:31'),
(99, '74', 'PT era cipta bina karya', '<p>Pak Nanang gak di tempat</p><p>Gak bisa TT dan ambil po.</p><p>TT kembali di jumat</p>', 'Kim 1', '98.6749513', '3.6730092', 1, NULL, '2024-12-17 03:10:36', '2024-12-17 04:25:54'),
(100, '493', 'Tnda trm PT Tirta sari sumber murni', '<p>Ok</p>', 'Karya darma tnjg morawa', '98.8099206', '3.5274016', 1, NULL, '2024-12-17 03:11:14', '2024-12-17 09:15:03'),
(101, '493', 'Tagihan CV jaya perkasa abadi', '<p>Ok</p>', 'Industri tnjg morawa', '98.8064166', '3.5284641', 1, NULL, '2024-12-17 03:22:02', '2024-12-17 09:14:29'),
(102, '74', 'PT bukit intan abadi', '<p>Tanda terima ok ya</p>', 'Kim1', '98.6894515', '3.6675088', 1, NULL, '2024-12-17 03:26:30', '2024-12-17 09:16:03'),
(103, '74', 'PT bukit intan abadi', '<p>Tanda terima ok ya </p>', 'Kim1', '98.6894394', '3.6675095', 1, NULL, '2024-12-17 03:27:48', '2024-12-17 09:13:49'),
(104, '74', 'PT toba surimi industri', '<p>Tanda terima ok ya </p>', 'Kim2', '98.6894311', '3.6674846', 1, NULL, '2024-12-17 03:30:50', '2024-12-17 09:13:32'),
(105, '493', 'Sertifikat baja agung kharisma utama', '<p>Ok</p>', 'Tnjg morawa', '98.7902195', '3.5217015', 1, NULL, '2024-12-17 03:35:21', '2024-12-17 09:13:11'),
(106, '74', 'PT pacific palmindo industri', '<p>Antar sertifikat tera yg terima satpam rifaldi</p>', 'Kim 2', '98.6904396', '3.6701458', 1, NULL, '2024-12-17 03:36:01', '2024-12-17 09:12:50'),
(107, '74', 'PT Charoen Pokphand Indonesia', '<p>Tanda terima ok ya</p>', 'Kim 2 Sumbawa ini', '98.6845287', '3.6763562', 1, NULL, '2024-12-17 03:47:24', '2024-12-17 09:12:32'),
(108, '493', 'Tnda trm ibu Kim heng', '<p>Ok</p>', 'Irian tnjg morawa', '98.7975675', '3.5216539', 1, NULL, '2024-12-17 04:00:31', '2024-12-17 04:23:56'),
(109, '493', 'Tnda trm PT Budi tamora permai', '<p>Ok</p>', 'P. kemerdekaan tnjg morawa', '98.7957953', '3.5228072', 1, NULL, '2024-12-17 04:13:07', '2024-12-17 09:07:01'),
(110, '74', 'Irian Marelan', '<p>Tanda terima ok ya</p>', 'Marelan', '98.6560106', '3.6938717', 2, 'dua x input', '2024-12-17 04:22:05', '2024-12-18 02:11:46'),
(111, '493', 'Tagihan BPK ferry', '<p>GK byr Krn LG natal.</p>', 'Irian tnjg morawa', '98.7928729', '3.5173585', 1, NULL, '2024-12-17 04:25:02', '2024-12-17 06:18:03'),
(112, '74', 'Irian marelan', '<p>Gak bisa TT ya adayg salah</p>', 'Marelan', '98.6557625', '3.6937945', 1, NULL, '2024-12-17 04:48:06', '2024-12-17 09:10:34'),
(113, '74', 'BPK johan', '<p>Tanda terima ok ya </p>', 'Titipahlawan marelan', '98.6609928', '3.7113808', 1, NULL, '2024-12-17 05:05:35', '2024-12-17 06:17:18'),
(114, '74', 'PT multi persada gatramegah', '<p>Tanda terima ok ya</p><p>SDH di tukarya invoice dan fantur pajaknya</p>', 'Yos Sudarso', '98.6628807', '3.6475346', 1, NULL, '2024-12-17 07:07:04', '2024-12-17 09:10:53'),
(115, '493', 'Tnda  trm Tony lim', '<p>Ok</p>', 'Btg kuis', '98.6809143', '3.5826031', 1, NULL, '2024-12-17 07:51:49', '2024-12-17 09:11:12'),
(116, '493', 'Tnda trm PT bilah baja makmur abadi', '<p>Ok</p>', 'Kol. Sugiono', '98.6808575', '3.5827171', 1, NULL, '2024-12-17 08:09:06', '2024-12-17 09:11:30'),
(117, '493', 'Tnda trm PT sumber rezeki sejahtera', '<p>Ok</p>', 'Nibung raya', '98.6647026', '3.5865977', 1, NULL, '2024-12-17 08:27:24', '2024-12-17 09:11:50'),
(118, '493', 'Tnda trm PT karya agung sawita dan sumber tani agung', '<p>Ok</p>', 'Cambrige', '98.6673028', '3.5844925', 1, NULL, '2024-12-18 01:30:09', '2024-12-18 04:08:54'),
(119, '493', 'Tnda trm PT semadam', '<p>Ok</p>', 'Nibung raya', '98.6647056', '3.5878014', 1, NULL, '2024-12-18 01:44:31', '2024-12-18 04:09:23'),
(120, '74', 'PT Sumatra Timber industri', '<p>Blom di transfer </p><p>Nanti di TF info kasir</p>', 'Jln kol Sugiono 26', '98.6800143', '3.583659', 1, NULL, '2024-12-18 02:19:46', '2024-12-18 04:10:03'),
(121, '74', 'PT tani mas resource internasional', '<p>Tanda terima ok ya </p>', 'Jati jactoin', '98.6791754', '3.5968064', 1, NULL, '2024-12-18 02:35:37', '2024-12-18 04:10:31'),
(122, '74', 'PT tani mas resource internasional', '<p>Ok</p>', 'Jati jactoin', '98.6900599', '3.5903887', 1, NULL, '2024-12-18 02:53:14', '2024-12-23 07:22:12'),
(123, '74', 'PT maroke tetep jaya', '<p>Tanda terima ok ya </p>', 'Jl Thamrin', '98.6900713', '3.5903816', 1, NULL, '2024-12-18 02:54:17', '2024-12-18 04:11:34'),
(124, '493', 'Tnda trm lunas PT bugak', '<p>Ok</p>', 'Kiwi', '98.5944767', '3.6005733', 1, NULL, '2024-12-18 02:56:30', '2024-12-18 04:11:58'),
(125, '74', 'Inur nadimin', '<p>Tanda terima ok ya </p>', 'Jln ar hakim no 128', '98.7035318', '3.5769472', 1, NULL, '2024-12-18 03:16:08', '2024-12-18 04:12:18'),
(126, '493', 'Tnda trm PT olam', '<p>Ok</p>', 'Binjai', '98.5629106', '3.5979502', 1, NULL, '2024-12-18 03:25:37', '2024-12-18 04:12:41'),
(127, '74', 'PT cipta chemical Medan oil', '<p>Tanda terima ok ya bang bayu</p>', 'Jl negara no83', '98.7051454', '3.5939602', 1, NULL, '2024-12-18 03:27:22', '2024-12-18 04:13:07'),
(128, '74', 'PT Mahato inti sawit', '<p>Tanda terima ok ya kak eka</p>', 'Cemara asri berjaya 88st', '98.7065831', '3.6330933', 1, NULL, '2024-12-18 03:48:18', '2024-12-18 04:13:23'),
(129, '493', 'Tnda trm Adnan johan', '<p>Bayar lunas</p>', 'Psr bsr Binjai km 13.8', '98.4980159', '3.6083766', 1, NULL, '2024-12-18 03:49:11', '2024-12-18 04:13:42'),
(130, '394', 'Permata', '<p>Ohxlhxlhdlufoydoudupcoudpudludoufouclucoufpufpufpufpufouxoyxohxlhxlhxluflud</p>', 'Permata', '98.6814886', '3.585281', 1, NULL, '2024-12-18 03:53:50', '2024-12-18 07:13:18'),
(131, '394', 'Mandiri', '<p>Dhojxljchchkhhdlfdhodlhdhdhodhohxlhdludljflufludlhdohdpudlhdlhdlhdlhxljxlhxljx</p>', 'Mandiri', '98.6807593', '3.5849121', 1, NULL, '2024-12-18 04:04:13', '2024-12-18 07:13:06'),
(132, '74', 'PT mahana boston', '<p>Tanda terima ok ya </p>', 'Jl metal minimalisno 3', '98.6916484', '3.6393841', 1, NULL, '2024-12-18 04:05:43', '2024-12-18 04:14:09'),
(133, '74', 'Cv trijaya mitra plasindo', '<p>Antar sertifikat tera </p>', 'Jln cemara176', '98.6867818', '3.6295715', 1, NULL, '2024-12-18 04:15:38', '2024-12-18 06:07:19'),
(134, '493', 'Tnda trm yg lunas PT serim indo', '<p>Ok</p>', 'Yos Sudarso Binjai utara', '98.4897367', '3.6075648', 1, NULL, '2024-12-18 04:48:14', '2024-12-18 06:07:48'),
(135, '493', 'Tagihan BPK apin', '<p>Byr</p>', 'A.yani Binjai kota', '98.4866787', '3.603013', 1, NULL, '2024-12-18 05:02:24', '2024-12-18 06:32:42'),
(136, '493', 'Tagihan ibu Acen', '<p>Byr</p>', 'Sudirman Binjai kota', '98.4903092', '3.6087949', 1, NULL, '2024-12-18 06:36:16', '2024-12-18 06:54:41'),
(137, '493', 'Tagihan BPK william', '<p>Byr</p>', 'Sudirman Binjai kota', '98.490145', '3.6089328', 1, NULL, '2024-12-18 06:51:38', '2024-12-18 06:55:01'),
(138, '74', 'PT sinar Surya pusaka', '<p>Tanda terima ok ya kak sari</p>', 'Bilal prima d 10', '98.6787261', '3.6243518', 1, NULL, '2024-12-18 07:13:02', '2024-12-18 08:45:09'),
(141, '493', 'Tagihan BPK athiam', '<p>Byr</p>', 'Sudirman Binjai kota', '98.5885687', '3.61429', 1, NULL, '2024-12-18 07:50:35', '2024-12-18 08:58:30'),
(142, '74', 'PT inti bumi alumindotama', '<p>BAYAR CASH RP444.000</p>', 'Cerebon', '98.6836509', '3.5848206', 1, NULL, '2024-12-18 07:55:18', '2024-12-18 08:45:28'),
(143, '493', 'Sertifikat CV anugrah cahaya sawita / padat karya', '<p>Ok</p>', 'Jln langsa no 24  binjai', '98.5873932', '3.6117656', 1, NULL, '2024-12-18 08:05:56', '2024-12-18 08:45:43'),
(144, '493', 'Tagihan BPK effendy', '<p>Ok</p>', 'Jln Pendawa', '98.6310511', '3.6051591', 1, NULL, '2024-12-18 08:53:09', '2024-12-18 08:58:18'),
(145, '493', 'Tnda trm PT propadu', '<p>Ok</p>', 'Gaperta', '98.6689861', '3.5914831', 1, NULL, '2024-12-18 09:25:05', '2024-12-19 02:50:01'),
(146, '493', 'Tnda trm PT sumber bumi sawit jd jaya / cinta raja', '<p>Ok</p>', 'Taman Polonia 4 no 38', '98.6958042', '3.5372879', 1, NULL, '2024-12-19 02:08:53', '2024-12-19 02:50:19'),
(147, '74', 'BPK asin toko uni teknik', '<p>Tanda terima ok ya sama kak erni</p>', 'Percut komp harmoni', '98.7298564', '3.6755848', 1, NULL, '2024-12-19 02:21:26', '2024-12-19 02:48:17'),
(148, '74', 'PT intan sejati andalan', '<p>Tanda terima ok ya </p>', 'Jati juction', '98.6791802', '3.5967988', 1, NULL, '2024-12-19 03:32:57', '2024-12-20 02:04:37'),
(149, '493', 'Tnda trm PT singamas', '<p>Ok</p>', 'Komp.tritura', '98.7317927', '3.461376', 1, NULL, '2024-12-19 03:41:22', '2024-12-20 02:05:00'),
(150, '74', 'PT ayu bumi sejati', '<p>Tanda terima ok ya </p>', 'Podomoro apartemen', '98.6738202', '3.5932603', 1, NULL, '2024-12-19 03:55:53', '2024-12-20 02:05:19'),
(151, '74', 'PT kayung agro lestari', '<p>Tanda terima ok ya </p>', 'Sinarmas land lt7', '98.6724836', '3.5831422', 1, NULL, '2024-12-19 04:14:48', '2024-12-20 02:05:40'),
(152, '74', 'PT mentari sawit makmur', '<p>Tanda terima ok ya kak novel</p>', 'Jln s Parman 302', '98.6670383', '3.5795636', 1, NULL, '2024-12-19 04:24:27', '2024-12-20 02:06:00'),
(153, '493', 'Tnda trm indofarm', '<p>Ok</p>', 'Patumbak', '98.7120713', '3.5372469', 1, NULL, '2024-12-19 04:28:22', '2024-12-20 02:06:18'),
(154, '493', 'Tnda trm ibu jana / semesta teknik', '<p>Ok</p>', 'Pandu', '98.686681', '3.583137', 1, NULL, '2024-12-19 05:52:31', '2024-12-20 04:10:19'),
(155, '493', 'Tagihan BPK Erwin / Kings diesel', '<p>Ok</p>', 'Pandu', '98.686064', '3.5828468', 1, NULL, '2024-12-19 06:02:54', '2024-12-20 04:10:35'),
(156, '493', 'Tnda trm dan tagihan ibu Indri / macan mesin', '<p>Ok</p>', 'Pandu', '98.6860597', '3.5828803', 1, NULL, '2024-12-19 06:12:18', '2024-12-20 04:10:55'),
(157, '493', 'Tnda trm dan tagihan BPK David / victory', '<p>Ok</p>', 'Pandu', '98.6857199', '3.58275', 1, NULL, '2024-12-19 06:22:19', '2024-12-20 04:11:10'),
(158, '493', 'Tagihan ibu asiu / Kings diesel', '<p>GK byr. Janji HR Selasa.</p>', 'Pandu', '98.6842143', '3.5821405', 1, NULL, '2024-12-19 06:31:50', '2024-12-20 04:11:27'),
(159, '394', 'Mandiri', '<p>Gkslhxxhlxlhlhdodygklxhxkhkhdoydohxkhxhxhkxhohxlhxohxlhxlyxlhxhlhdlhdlhd</p>', 'Mandiri', '98.6741204', '3.5873964', 2, 'keterangan gak jelas', '2024-12-19 07:19:36', '2024-12-20 04:12:06'),
(160, '74', 'Kl furniture', '<p>Blom ada</p>', 'Jln Budi kemasyrakatan', '98.6727145', '3.5940223', 1, NULL, '2024-12-19 08:45:26', '2024-12-20 04:12:23'),
(161, '493', 'Tnda trm PT sumber jaya indah nusa coy', '<p>Ok</p>', 'Juanda no 36', '98.6748821', '3.5684516', 1, NULL, '2024-12-20 01:43:22', '2024-12-20 02:07:11'),
(162, '74', 'Toko fajar BPK Fransiskus Halim', '<p>Tanda terima ok ya </p><p>Tagihan transfer tgl 20/12/24</p><p>Rp 1630.000</p>', 'Yos Sudarso', '98.6692943', '3.6279359', 1, NULL, '2024-12-20 01:47:47', '2024-12-20 04:12:44'),
(163, '493', 'Refund PT agro merak sejahtera', '<p>Ok</p>', 'Komp the palace residence', '98.6748838', '3.5685438', 1, NULL, '2024-12-20 01:49:04', '2024-12-20 02:07:26'),
(164, '74', 'PT universal Indofood product(unibis)', '<p>Tanda terima ok ya </p>', 'Yos Sudarso', '98.6624677', '3.6450428', 1, NULL, '2024-12-20 02:10:36', '2024-12-20 04:30:15'),
(165, '74', 'Mabar feed(BROILER FARM)', '<p>Tanda terima ok ya kak desi</p>', 'Jln RPH', '98.6685444', '3.6582658', 1, NULL, '2024-12-20 02:21:47', '2024-12-20 04:30:34'),
(166, '74', 'PT juishin Indonesia', '<p>Antar sertifikat tera </p><p>Yg tanda terima gak bisa ya</p>', 'Kim 2', '98.6957902', '3.6630214', 1, NULL, '2024-12-20 02:39:48', '2024-12-20 04:30:52'),
(167, '74', 'PT KDS', '<p>Blom ada</p><p>SDH 8 x di kunjungi</p>', 'Kim 2', '98.6986195', '3.6708138', 1, NULL, '2024-12-20 02:47:49', '2024-12-20 04:31:20'),
(168, '74', 'PT agri tanimas selaras', '<p>Tanda terima ok ya </p>', 'Kim 2 komp serbaguna', '98.6986195', '3.6708138', 1, NULL, '2024-12-20 02:55:52', '2024-12-20 04:31:37'),
(169, '74', 'PT bukit intan abadi', '<p>Tanda terima ok ya </p>', 'Kim2', '98.6750259', '3.6732983', 1, NULL, '2024-12-20 03:09:23', '2024-12-20 04:31:50'),
(170, '74', 'PT Tapteng anugrah sawit', '<p>Tagihan blom ada</p><p>Klo SDH di telpon baru dtg</p>', 'Kim 1', '98.6750259', '3.6732983', 1, NULL, '2024-12-20 03:11:00', '2024-12-20 04:32:06'),
(171, '493', 'Tagihan universal gloves', '<p>Ok</p>', 'Patumbak', '98.7193311', '3.5287505', 1, NULL, '2024-12-20 03:16:37', '2024-12-20 04:32:40'),
(172, '74', 'PT citradimensi arthali', '<p>Tanda terima ok ya </p>', 'Kim 1', '98.6739951', '3.6697045', 1, NULL, '2024-12-20 03:29:07', '2024-12-20 04:37:14'),
(173, '74', 'PT expravet nasuba', '<p>Bayar cash ya Rp 2.553.000 tgl 20/12/24</p>', 'Jln yos Sudarso', '98.663791', '3.6562139', 1, NULL, '2024-12-20 03:50:03', '2024-12-20 04:37:37'),
(174, '493', 'Tnda trm PT inocycle', '<p>Ok</p>', 'Talun kenas patumbak', '98.7069733', '3.4191183', 1, NULL, '2024-12-20 04:18:24', '2024-12-20 04:37:52'),
(175, '74', 'PT siringo ringo', '<p>Tanda terima ok ya</p>', 'Yos Sudarso', '98.66292', '3.6474773', 1, NULL, '2024-12-20 04:19:10', '2024-12-20 04:38:08'),
(176, '74', 'PT musim mas', '<p>Tanda terima ok ya </p>', 'Yos Sudarso', '98.66292', '3.6474773', 1, NULL, '2024-12-20 04:19:55', '2024-12-20 04:39:40'),
(178, '493', 'Bon lunas PT era karya Mukti jaya', '<p>Ok</p>', 'Bantam no 2a', '98.6651611', '3.5838521', 1, NULL, '2024-12-21 01:22:09', '2024-12-21 05:48:50'),
(179, '493', 'TKO mandiri jaya', '<p>Cri orderan</p>', 'Pelita btg kuis', '98.8016981', '3.6137467', 1, NULL, '2024-12-21 02:17:32', '2024-12-21 08:58:43'),
(180, '74', 'PT Sumatra Deli lestari indah', '<p>Tanda terima ok ya </p>', 'Jln letda Sujono no72', '98.7099769', '3.5979304', 1, NULL, '2024-12-21 02:59:00', '2024-12-21 05:49:16'),
(181, '74', 'PT usdama damai sejahtera', '<p>Tanda terima ok ya </p>', 'Jln besar Tembung depan (Bgr)', '98.7426346', '3.5966261', 1, NULL, '2024-12-21 03:24:12', '2024-12-21 05:49:43'),
(182, '493', 'Tagihan BPK Acong / TKO rezeki', '<p>Ok</p>', 'Niaga btg kuis', '98.8024481', '3.6129886', 1, NULL, '2024-12-21 03:33:36', '2024-12-21 08:58:59'),
(183, '493', 'TKO istana kado', '<p>Cri orderan</p>', 'Niaga btg kuis', '98.8023151', '3.6130357', 1, NULL, '2024-12-21 03:38:12', '2024-12-21 08:59:12'),
(184, '493', 'TKO fajar electronic', '<p>Cri orderan</p>', 'Niaga btg kuis', '98.802278', '3.6130883', 1, NULL, '2024-12-21 03:39:33', '2024-12-21 08:58:27'),
(185, '493', 'TKO istana electric', '<p>Cri orderan</p>', 'Niaga btg kuis', '98.8020935', '3.6130609', 1, NULL, '2024-12-21 03:42:13', '2024-12-21 08:58:05'),
(186, '493', 'TKO semangat baru', '<p>Cri orderan</p>', 'Veteran btg kuis', '98.8010345', '3.6132529', 1, NULL, '2024-12-21 03:49:44', '2024-12-21 08:57:51'),
(187, '493', 'TKO Surya mas', '<p>Cri orderan</p>', 'Niaga btg kuis', '98.8010344', '3.6132783', 1, NULL, '2024-12-21 03:51:18', '2024-12-21 08:57:37'),
(188, '74', 'BPK Aek toko rezeki baru', '<p>Tanda terima ok ya </p><p>SDH transfer sebesar Rp 3.260.000tgl 21/12/24</p>', 'Jln mandala by passs', '98.7110951', '3.5922062', 1, NULL, '2024-12-21 04:05:36', '2024-12-21 08:57:17'),
(189, '74', 'Kartini sinar bintang', '<p>Tanda terima ok ya </p>', 'Pukat7 GG indah', '98.7082685', '3.5904397', 1, NULL, '2024-12-21 04:13:39', '2024-12-21 05:52:02'),
(190, '394', 'Binje', '<p>Fhldhlhdhdlhdlufludhldulhdhdhkdhlhdhdhlhdlhdljflhfljflufljfljfljdlhxlhxlhxlhxlhxlhxlhhd</p>', 'Binje', '98.4929454', '3.6105074', 1, NULL, '2024-12-21 04:13:59', '2024-12-21 08:57:03'),
(191, '74', 'Carina toko carina', '<p>Tagihannya blom ada</p>', 'Mt haryono', '98.6853669', '3.587', 1, NULL, '2024-12-21 06:23:05', '2024-12-21 08:56:51'),
(192, '493', 'Tnda trm', '<p>Ok</p>', 'Rotan petisah', '98.6675038', '3.5907722', 1, NULL, '2024-12-21 08:10:02', '2024-12-21 08:56:34'),
(193, '493', 'Tnda trm mdn jaya', '<p>Ok</p>', 'Razak baru petisah', '98.6675056', '3.5920444', 1, NULL, '2024-12-21 08:16:38', '2024-12-21 08:56:18'),
(194, '493', 'Anter pesanan ibu tini', '<p>Ok</p>', 'Selat pnjg no 10', '98.6846318', '3.5836959', 1, NULL, '2024-12-21 08:47:47', '2024-12-21 08:56:05'),
(195, '493', 'Anter psnan ibu tini', '<p>Ok</p>', 'Ke semambu', '98.6646318', '3.5868112', 1, NULL, '2024-12-21 09:08:52', '2024-12-23 02:43:36'),
(196, '493', 'Tnda trm PT panca buana plasindo', '<p>Ok</p>', 'Mesjid no 142 binjai', '98.5928596', '3.5933548', 1, NULL, '2024-12-23 02:31:34', '2024-12-23 06:47:19'),
(197, '493', 'Tnda trm PT sinar aneka niaga', '<p>Ok</p>', 'Setia ujung no 38', '98.5665621', '3.6117628', 1, NULL, '2024-12-23 02:55:26', '2024-12-23 06:47:35'),
(198, '74', 'PT Belawan delichemical industri', '<p>Tanda terima ok ya </p>', 'Jln HM yamin', '98.684507', '3.5957042', 1, NULL, '2024-12-23 03:16:40', '2024-12-23 06:47:55'),
(199, '493', 'Tnda trm PT sukanda djaya', '<p>Ok</p>', 'Soekarno Hatta no 80', '98.5198088', '3.6079173', 1, NULL, '2024-12-23 03:25:49', '2024-12-23 06:48:22'),
(200, '74', 'BPK aik toko kini', '<p>Tanda terima ok ya </p>', 'Mt haryono', '98.6846794', '3.5868517', 1, NULL, '2024-12-23 03:27:37', '2024-12-23 03:33:03'),
(201, '74', 'Reliman anugrah Syahputra lase', '<p>Tanda terima ok ya</p>', 'Jln Bogor 46', '98.6846698', '3.5839414', 1, NULL, '2024-12-23 03:35:09', '2024-12-23 06:48:40'),
(202, '74', 'Irwan Medan/Deli jaya plasindo', '<p>Tanda terima ok ya </p>', 'Jln s Parman komp the crown', '98.6675567', '3.5815551', 1, NULL, '2024-12-23 03:50:28', '2024-12-23 06:48:53'),
(203, '74', 'Cv sistech engenering', '<p>Tanda terima ok ya </p>', 'Jln danaujempang blok b no82', '98.6583127', '3.6062853', 1, NULL, '2024-12-23 04:16:00', '2024-12-23 09:23:41'),
(204, '493', 'Tagihan  ibu athing / cahaya kita', '<p>Lunas</p>', 'Gatsu bharang binjai', '98.4908602', '3.609466', 1, NULL, '2024-12-23 04:18:12', '2024-12-23 04:32:05'),
(205, '493', 'Tagihan BPK athiam / sederhana', '<p>Lunas</p>', 'Sudirman Binjai kota', '98.563614', '3.5993797', 1, NULL, '2024-12-23 04:48:57', '2024-12-23 06:45:24'),
(206, '493', 'Tagihan BPK effendy', '<p>Lunas</p>', 'Pendawa no 57', '98.5945216', '3.5999724', 1, NULL, '2024-12-23 06:48:49', '2024-12-23 07:05:34'),
(207, '493', 'Tnda trm PT olam indo', '<p>Ok</p>', 'Mdn Binjai km 10,5', '98.627767', '3.6045729', 1, NULL, '2024-12-23 07:05:22', '2024-12-23 09:21:25'),
(208, '74', 'PT socfin indonesia', '<p>Tanda terima ok ya </p>', 'Jln yos Sudarso', '98.6715893', '3.6185117', 1, NULL, '2024-12-24 01:22:52', '2024-12-24 07:17:06'),
(209, '74', 'PT industri pembungkus Indonesia', '<p>Tanda terima ok ya </p>', 'Kim 1', '98.6702651', '3.6633192', 1, NULL, '2024-12-24 01:43:45', '2024-12-24 07:24:07'),
(210, '74', 'PT socimas /pak johan', '<p>Dokumen di titipkan ke refsionis</p>', 'Kim 1', '98.6742425', '3.6729212', 1, NULL, '2024-12-24 01:55:52', '2024-12-24 07:23:50'),
(211, '74', 'PT nauli sawit', '<p>Ambil bukti potong blom ada.</p>', 'Kim 1', '98.6749578', '3.6730094', 1, NULL, '2024-12-24 02:05:21', '2024-12-24 06:56:46'),
(212, '74', 'PT era cipta bina karya', '<p>Tanda terima ok ya </p>', 'Kim 1', '98.6750678', '3.672975', 1, NULL, '2024-12-24 02:28:22', '2024-12-24 06:56:02'),
(213, '74', 'PT cahaya alam sejati', '<p>Antar sertifikat tera </p>', 'Kim4', '98.7078832', '3.6817286', 1, NULL, '2024-12-24 02:53:50', '2024-12-24 07:23:32'),
(214, '74', 'PT central proteina prima', '<p>Antar sertifikat tera</p>', 'Kim 2', '98.6990045', '3.6678287', 1, NULL, '2024-12-24 03:04:18', '2024-12-24 07:22:54'),
(215, '74', 'PT KDS', '<p>Ambil bukti potong pph</p>', 'Kim 2', '98.6986108', '3.6709102', 1, NULL, '2024-12-24 03:16:17', '2024-12-24 06:56:26'),
(216, '493', 'Tagihan ibu carina', '<p>Lunas</p>', 'Mt haryono no 34 i', '98.6853185', '3.5870073', 1, NULL, '2024-12-24 03:33:53', '2024-12-24 06:55:42'),
(217, '74', 'PT agro jaya perdana', '<p>Antar sertifikat tera </p>', 'Jln yos Sudarso', '98.6792673', '3.71142', 1, NULL, '2024-12-24 03:44:01', '2024-12-24 07:17:46'),
(218, '493', 'Tagihan ibu ayen', '<p>Lunas</p>', 'Sutrisno no 173 b', '98.6999411', '3.582331', 1, NULL, '2024-12-24 03:55:54', '2024-12-24 06:55:02'),
(219, '74', 'BPK johan toko lima', '<p>Tidak usah TT </p><p>Bawa sekalian timbang yg service dan langsung bayar</p>', 'Marelan titi pahlawan', '98.6610113', '3.7113572', 1, NULL, '2024-12-24 03:57:46', '2024-12-24 06:54:18'),
(220, '74', 'Hok lai tokobahagiabersama', '<p>Tanda terima ok ya </p>', 'Marelan titi pahlawan psr 5', '98.6608178', '3.7112037', 1, NULL, '2024-12-24 04:01:22', '2024-12-24 06:53:41'),
(221, '493', 'Tagihan ibu asiu / king,s diesel', '<p>Nti blk jam 4</p>', 'Pandu', '98.6841826', '3.5821912', 1, NULL, '2024-12-24 04:11:26', '2024-12-26 04:33:41'),
(222, '493', 'Tagihan naga mas  agro mulia', '<p>Uda tlp kak adek</p>', 'S Parman no 302', '98.6672525', '3.5797377', 1, NULL, '2024-12-24 04:31:05', '2024-12-24 07:52:23'),
(223, '74', 'PT persada Nusantara nabati Indonesia', '<p>Ibu Marta gak masuk /cuti</p>', 'Graha metropolitan blok t7', '98.6473096', '3.6262423', 1, NULL, '2024-12-24 04:52:24', '2024-12-24 07:18:08'),
(224, '74', 'PT sumber kembang jaya', '<p>Tanda terima ok </p>', 'Graha metropolitan no16', '98.6473729', '3.6260755', 1, NULL, '2024-12-24 04:54:08', '2024-12-24 07:18:27'),
(225, '394', 'Ocbcc', '<p><br></p>', 'Ocbcc', '98.6670305', '3.5925191', 1, NULL, '2024-12-24 05:07:13', '2024-12-24 06:52:19'),
(226, '74', 'BPK asin (toko uni teknik)', '<p>Tanda terima ok ya</p><p>Dan bon yg lunas SDH di kasih</p>', 'Percut sientis komp harmoni', '98.7298719', '3.6755391', 1, NULL, '2024-12-26 02:02:22', '2024-12-26 04:33:57'),
(227, '493', 'Anter sertifikat PT Okta palm oil', '<p>Ok</p>', 'Katamso bisnis center', '98.6655377', '3.592303', 1, NULL, '2024-12-26 02:12:49', '2024-12-26 04:29:36'),
(228, '493', 'Tnda trm CV Surya engenering', '<p>Ok</p>', 'Gatsu no 150 b / 14', '98.6655823', '3.5922676', 1, NULL, '2024-12-26 02:16:57', '2024-12-26 04:31:46'),
(229, '74', 'PT versus engenering', '<p>Tanda terima ok ya </p>', 'Jln cemara', '98.6906569', '3.6295835', 1, NULL, '2024-12-26 02:28:25', '2024-12-26 04:32:01'),
(230, '74', 'Toko kl furniture', '<p>Tagihan blom ada</p>', 'Jln Budi kemasyarakatan', '98.6718153', '3.6213544', 1, NULL, '2024-12-26 02:39:33', '2024-12-26 04:32:15'),
(231, '74', 'BPK nurman', '<p>Tanda terima ok ya </p>', 'Komp villa makmur indah blok i 20', '98.6677677', '3.6057477', 1, NULL, '2024-12-26 02:54:02', '2024-12-26 04:30:56'),
(232, '74', 'PT Supra matra abadi', '<p>Masuk box ya</p>', 'Jln mt haryono(uniland)', '98.6824671', '3.5865928', 1, NULL, '2024-12-26 03:12:52', '2024-12-26 04:31:10'),
(233, '74', 'BPK apo Sumatrametalwork', '<p>Tanda terima ok ya </p>', 'Jln Sumatra 35/51', '98.6918265', '3.5896487', 1, NULL, '2024-12-26 03:48:41', '2024-12-26 04:32:33'),
(234, '74', 'PT adimuliasari mas', '<p>Tanda terima ok </p>', 'Hotel Adi muliaq', '98.6721367', '3.5847796', 1, NULL, '2024-12-26 04:05:53', '2024-12-26 04:31:26'),
(235, '493', 'Tagihan BPK ahuay / mjs', '<p>Lunas</p>', 'Katamso', '98.686164', '3.5829384', 1, NULL, '2024-12-26 04:14:21', '2024-12-26 04:32:49'),
(236, '493', 'Tagihan dan tnda trm BPK Erwin / king,s jaya', '<p>Tnda trm Ok klo tagihan GK byr Krn Koko nya Uda pgr jln2.</p>', 'Pandu', '98.685814', '3.5827584', 1, NULL, '2024-12-26 04:23:51', '2024-12-26 04:33:25'),
(237, '493', 'Tagihan ibu Indri / istana mesin', '<p>Bsk</p>', 'Pandu', '98.6857467', '3.5827414', 1, NULL, '2024-12-26 04:38:51', '2024-12-26 04:42:07'),
(238, '493', 'Tagihan dan tnda trm ibu asiu / king,s diesel', '<p>Ok</p>', 'Pandu', '98.6842', '3.5821869', 1, NULL, '2024-12-26 04:44:44', '2024-12-26 07:15:05'),
(239, '493', 'Tnda trm dan sertifikat PT palmaris raya', '<p>Ok</p>', 'A. Rivai no 6', '98.6733789', '3.5779325', 1, NULL, '2024-12-26 07:36:30', '2024-12-26 09:01:31'),
(240, '74', 'Fransiskus Halim toko fajar', '<p>Tanda terima ok </p>', 'Jln yos Sudarso', '98.6693167', '3.6279508', 1, NULL, '2024-12-27 01:42:03', '2024-12-27 08:04:12'),
(241, '493', 'Tnda trm PT ensem sawita dan para sawita', '<p>Ok</p>', 'Kalimantan no 1 h', '98.6918781', '3.5896343', 1, NULL, '2024-12-27 01:49:13', '2024-12-27 03:13:53'),
(242, '493', 'Tnda trm CV Sumatra metal works', '<p>Ok</p>', 'Jln Sumatra simp.jln jambi', '98.6918921', '3.5896462', 1, NULL, '2024-12-27 01:51:15', '2024-12-27 03:14:17'),
(243, '74', 'PT inti benua perkasatama', '<p>Antar sertifikat tera </p>', 'Yos Sudarso', '98.6622747', '3.6472131', 1, NULL, '2024-12-27 01:58:10', '2024-12-27 03:14:37'),
(244, '493', 'Tnda trm PT prima tangki indo', '<p>Ok</p>', 'Rencong no 1 b', '98.7038896', '3.5897256', 1, NULL, '2024-12-27 02:11:06', '2024-12-27 03:15:19'),
(245, '74', 'PT able comoditis Indonesia', '<p>Tanda terima ok </p>', 'Jln kapt Ilyas simpang kantor labuhan', '98.6808368', '3.7269143', 1, NULL, '2024-12-27 02:29:54', '2024-12-27 03:16:47'),
(246, '493', 'Bon lunas BPK ahuay / berkah sejahtera', '<p>Ok</p>', 'Sm.raja no 38 e', '98.6986282', '3.5499521', 1, NULL, '2024-12-27 02:40:02', '2024-12-27 04:21:51'),
(247, '74', 'PT dehael Nusantara logistik', '<p>Tanda terima ok </p>', 'Lkim3 pemagaran', '98.7011801', '3.6813549', 1, NULL, '2024-12-27 03:02:23', '2024-12-27 03:17:06'),
(248, '394', 'Niaga', '<p>Niaga</p>', 'Niaga', '98.6739626', '3.5863879', 1, NULL, '2024-12-27 03:03:17', '2024-12-27 04:22:07'),
(249, '74', 'PT KDS', '<p>Antar bon lunas</p>', 'Kim 2 tanah masa', '98.6986619', '3.6708775', 1, NULL, '2024-12-27 03:08:13', '2024-12-27 03:17:35'),
(250, '74', 'PT Tapteng anugrah sawit', '<p>Bayar giro permata bank</p><p>Jumlah Rp 19.839.500</p><p>No giro696017</p><p>Potong pph Rp 85 ribu</p>', 'Kim 1', '98.6749596', '3.6730068', 1, NULL, '2024-12-27 03:46:56', '2024-12-27 03:53:56'),
(251, '493', 'Tagihan BPK Kim heng / sepakat', '<p>Byr 1,5 jt</p>', 'Irian tnjg morawa', '98.7920014', '3.5169262', 1, NULL, '2024-12-27 04:10:23', '2024-12-27 04:22:21'),
(252, '74', 'PT siringo ringo', '<p>Invoice lebih dari 3 harus di titipkan karena kasir 2orang</p>', 'Jln yos Sudarso', '98.6628939', '3.6475839', 1, NULL, '2024-12-27 04:38:42', '2024-12-27 08:03:38'),
(253, '493', 'Tagihan BPK along / cahaya', '<p>Lunas</p>', 'Dahlan tnjg morawa', '98.7920771', '3.5459916', 1, NULL, '2024-12-27 04:40:16', '2024-12-27 04:45:48'),
(254, '74', 'PT persadanusa nabati Indonesia', '<p>Revisi</p>', 'Graha metropolitan blok t7', '98.6473052', '3.6262305', 1, NULL, '2024-12-27 05:03:57', '2024-12-27 08:03:22'),
(255, '74', 'Toko serba ada', '<p>Tagihan blom ada </p><p>Harap si wa dulu bosnya</p>', 'Jln yos Sudarso', '98.6625614', '3.6243839', 1, NULL, '2024-12-27 05:33:22', '2024-12-27 08:01:17'),
(256, '493', 'Tnda trm PT Asia raya foundry', '<p>Ok</p>', 'Sei blumai', '98.6804588', '3.5700985', 1, NULL, '2024-12-27 06:09:59', '2024-12-27 08:03:06'),
(257, '493', 'Tnda trm PT sumber bumi sawit jd jaya', '<p>Ok</p>', 'Taman Polonia 4 no 38', '98.6871949', '3.5803512', 1, NULL, '2024-12-27 06:23:48', '2024-12-27 08:02:52'),
(258, '493', 'Tagihan ibu Fanny / laris jaya', '<p>GK byr. Di srh blk tgl 15 BLN 1.</p>', 'P. Sambas no 28', '98.6873369', '3.5803148', 1, NULL, '2024-12-27 06:27:52', '2024-12-27 08:01:36'),
(259, '493', 'Tnda trm ibu zenny / mulia diesel', '<p>Ok</p>', 'Pandu', '98.6865565', '3.5830546', 1, NULL, '2024-12-27 06:35:47', '2024-12-27 08:01:51'),
(260, '493', 'Tagihan ibu Indri / istana mesin', '<p>Lunas</p>', 'Pandu', '98.68568', '3.5827128', 1, NULL, '2024-12-27 06:41:36', '2024-12-27 08:02:03'),
(261, '493', 'Tagihan BPK awi / harapan baru', '<p>THN dpn HR Sabtu.</p>', 'P. Pasar no 197', '98.6864597', '3.5901708', 1, NULL, '2024-12-27 06:52:53', '2024-12-27 08:02:20'),
(262, '74', 'Alai sg', '<p>Bayar cash Rp 54.532.000</p>', 'Jln Yos Sudarso', '98.674236', '3.6097973', 1, NULL, '2024-12-27 08:54:10', '2024-12-27 08:58:14'),
(263, '493', 'Tnda trm inti tera prima yudha', '<p>Ok</p>', 'Waringin no 9', '98.667851', '3.594211', 1, NULL, '2024-12-27 09:21:47', '2024-12-27 09:23:36'),
(264, '493', 'Tagihan PT sari tani jaya sumatra', '<p>Lunas</p>', 'CBD polonia blok f no 17', '98.6885215', '3.5544678', 1, NULL, '2024-12-28 02:37:36', '2024-12-28 02:49:15'),
(265, '493', 'TKO ingat jaya', '<p>Cri orderan</p>', 'Katamso no 156 f', '98.6884497', '3.554424', 1, NULL, '2024-12-28 02:38:54', '2024-12-28 07:06:31'),
(266, '74', 'BPK henry', '<p>Antar bon lunas</p>', 'Jln bakaranbatu14aa', '98.6951594', '3.5857965', 1, NULL, '2024-12-28 03:25:01', '2024-12-28 07:06:41'),
(267, '74', 'BPK Aek rezeki baru', '<p>Bayar via transfer ya sebesar Rp 2400.000</p><p><br></p>', 'Jln mandala bypass', '98.7111038', '3.5922174', 1, NULL, '2024-12-28 04:59:23', '2024-12-28 07:06:54'),
(268, '74', 'BPK johan', '<p>Bayar cash Rp 600.000</p>', 'Jln Sumatra no35', '98.6917946', '3.5896605', 1, NULL, '2024-12-28 05:12:52', '2024-12-28 07:07:31'),
(269, '493', 'Tagihan BPK aho / bintang tetang', '<p>Tagihan blm ada dan orderan jg blm ada.</p>', 'Pusat psar no  519 / 520', '98.5826407', '3.6097246', 1, NULL, '2024-12-28 06:28:16', '2024-12-28 07:07:43'),
(270, '493', 'Tagihan BPK effendy', '<p>Lunas</p>', 'Pendawa no 57 binjai', '98.5798536', '3.6023902', 1, NULL, '2024-12-28 06:56:13', '2024-12-28 07:08:30'),
(271, '493', 'TKO saudara', '<p>Cri orderan</p>', 'Pembangunan binjai', '98.5798455', '3.6023979', 1, NULL, '2024-12-28 06:58:48', '2024-12-28 07:09:03'),
(272, '74', 'Cv fauntain', '<p>Bayar cash Rp 743.700</p>', 'Jln h wuruk', '98.663829', '3.5818059', 1, NULL, '2024-12-28 07:07:01', '2024-12-28 07:20:59'),
(273, '493', 'Turbo laundry', '<p>Cri orderan</p>', 'Pembangunan binjai', '98.6528169', '3.607567', 1, NULL, '2024-12-28 07:28:22', '2024-12-28 07:58:39'),
(274, '493', 'Tagihan ibu afang / rajawali', '<p>Blm ada</p>', 'Rotan petisah', '98.6675618', '3.590762', 1, NULL, '2024-12-28 08:43:54', '2024-12-28 09:02:31'),
(275, '493', 'Tagihan mdn jaya', '<p>Lunas</p>', 'Razak baru petisah', '98.6678297', '3.5926278', 1, NULL, '2024-12-28 08:55:28', '2024-12-28 09:02:43'),
(276, '493', 'Tnda trm PT sumber tani agung', '<p>Ok</p>', 'Cambrige', '98.5944661', '3.6006615', 1, NULL, '2024-12-30 02:08:34', '2024-12-30 08:51:32'),
(277, '74', 'PT aep grup', '<p>Antar kalender</p>', 'Gd sinar masland lt3', '98.6724961', '3.5832355', 1, NULL, '2024-12-30 02:21:55', '2024-12-30 08:51:16'),
(278, '74', 'Cv Surya engenering', '<p>Tanda terima ok y</p>', 'Jln Gatot Subroto', '98.665708', '3.5921772', 1, NULL, '2024-12-30 02:35:10', '2024-12-30 06:53:33'),
(279, '493', 'Sertifikat PT olam indo', '<p>Ok</p>', 'Mdn Binjai km 10,5', '98.5222077', '3.607245', 1, NULL, '2024-12-30 02:35:54', '2024-12-30 08:51:00'),
(280, '74', 'PT citra sawit mandiri', '<p>Tanda terima ok ya</p>', 'Gd CIMB niaga lt10', '98.6742', '3.5864803', 1, NULL, '2024-12-30 03:04:50', '2024-12-30 08:50:41'),
(281, '493', 'Tnda trm yg Uda lunas CV makmur palas', '<p>Ok</p>', 'Mdn Binjai km 18,6', '98.4986408', '3.6083392', 1, NULL, '2024-12-30 03:50:47', '2024-12-30 08:50:26'),
(282, '493', 'Tagihan BPK APIN / sinar baru', '<p>Blm ada</p>', 'A. Yani Binjai kota', '98.489788', '3.6075819', 1, NULL, '2024-12-30 04:00:23', '2024-12-30 06:55:26'),
(283, '493', 'TKO mulia', '<p>Cri orderan</p>', 'A. Yani no 241 Binjai kota', '98.4901989', '3.608067', 1, NULL, '2024-12-30 04:09:35', '2024-12-30 06:55:06'),
(284, '493', 'Tagihan ibu amei / berkah abadi', '<p>Blm ada</p>', 'A. Yani Binjai kota', '98.4895253', '3.6072533', 1, NULL, '2024-12-30 04:13:09', '2024-12-30 06:54:53'),
(285, '493', 'Tnda trm CV fanghin', '<p>Ok</p>', 'Sudirman Binjai kota', '98.490843', '3.6094483', 1, NULL, '2024-12-30 04:35:16', '2024-12-30 08:49:00'),
(286, '74', 'PT bumi Tamiang sentosa', '<p>Tanda terima ok ya </p>', 'CBD blok bb20/22', '98.6771652', '3.5598985', 1, NULL, '2024-12-30 04:44:02', '2024-12-30 08:49:20'),
(287, '493', 'Tagihan BPK athiam / sederhana', '<p>Lunas</p>', 'Sudirman Binjai kota', '98.645541', '3.6051618', 1, NULL, '2024-12-30 05:29:54', '2024-12-30 06:54:28'),
(288, '74', 'Kilang padi tunasjaya nur nadimin', '<p>Antar sertifikat tera </p>', 'Jln ar hakim no 128', '98.7035276', '3.5769429', 1, NULL, '2024-12-30 06:49:03', '2024-12-30 08:49:55'),
(289, '493', 'TKO laris', '<p>Cri orderan</p>', 'Razak baru no 12 a', '98.6676853', '3.5919242', 1, NULL, '2024-12-30 08:13:57', '2024-12-30 08:43:33'),
(290, '493', 'TKO istana kado', '<p>Cri orderan</p>', 'Razak baru petisah', '98.6677855', '3.5919119', 1, NULL, '2024-12-30 08:15:58', '2024-12-30 08:44:10'),
(291, '493', 'TKO bahagia', '<p>Cri orderan</p>', 'Razak baru petisah', '98.6679349', '3.5915503', 1, NULL, '2024-12-30 08:19:04', '2024-12-30 08:43:03'),
(292, '74', 'PT Kalimantan hamparan sawit', '<p>Tanda terima ok ya </p>', 'Jln Adam Malik 25', '98.6690283', '3.5972707', 1, NULL, '2024-12-30 08:32:24', '2024-12-30 08:50:10'),
(293, '74', 'PT semadam', '<p>BAYAR cash Rp 3.108.000</p>', 'Jln Nibung 93', '98.6647198', '3.5878503', 1, NULL, '2024-12-30 09:14:09', '2024-12-30 09:26:28'),
(294, '74', 'BPK aho', '<p>Antar sertifikat tera </p>', 'Vila makmur mas I18', '98.6677628', '3.6057601', 1, NULL, '2024-12-31 02:17:33', '2024-12-31 06:06:56'),
(295, '74', 'PT socfin Indonesia', '<p>Antar sertifikat tera </p>', 'Jln yos Sudarso', '98.6716119', '3.6186404', 1, NULL, '2024-12-31 02:26:09', '2024-12-31 06:07:09'),
(296, '74', 'PT berlian eka sakti tangguh', '<p>Tutup </p><p>Minggu depan baru buka lagi</p>', 'Yos Sudarso', '98.669079', '3.6324935', 1, NULL, '2024-12-31 02:34:42', '2024-12-31 06:07:30'),
(297, '493', 'Tnda trm PT naga mas agro mulia', '<p>Ok</p>', 'S. Parman', '98.6670843', '3.5796144', 1, NULL, '2024-12-31 02:35:00', '2024-12-31 06:07:47'),
(298, '74', 'PT berlian eka sakti tangguh', '<p>Tutup </p><p>Minggu depan baru buka lagi </p>', 'Yos Sudarso', '98.6693807', '3.6325045', 1, NULL, '2024-12-31 02:36:39', '2024-12-31 06:08:10'),
(299, '74', 'PT musim mas', '<p>Antar sertifikat tera </p>', 'Jln Yos Sudarso', '98.662444', '3.6472257', 1, NULL, '2024-12-31 02:44:54', '2024-12-31 06:08:21'),
(300, '74', 'PT Mabar feed indonesia', '<p>Tutup</p><p>Minggu depan </p>', 'RPH', '98.6685363', '3.6582655', 1, NULL, '2024-12-31 02:53:13', '2024-12-31 06:08:38'),
(301, '493', 'Tnda trm PT rajawli', '<p>Lunas</p>', 'Gemilang', '98.6904179', '3.5669492', 1, NULL, '2024-12-31 03:12:24', '2024-12-31 06:08:50'),
(302, '493', 'Tnda trm PT indojaya', '<p>Ok</p>', 'Mdn tnjg morawa', '98.7564563', '3.5262368', 1, NULL, '2024-12-31 03:47:29', '2024-12-31 06:09:06'),
(303, '74', 'PT Bgr logistik', '<p>Tanda terima ok </p>', 'Paya pasir titi pahlawan', '98.6724468', '3.7191674', 1, NULL, '2024-12-31 04:18:56', '2024-12-31 06:09:16'),
(304, '74', 'BPK johan toko lima jaya', '<p>Tanda terima ok ya </p>', 'Titi pahlawan Marelan', '98.6609381', '3.7113279', 1, NULL, '2024-12-31 04:36:43', '2024-12-31 06:09:33'),
(305, '493', 'Tnda trm PT medisafe', '<p>Ok</p>', 'Tambak rejo', '98.786988', '3.5340813', 1, NULL, '2024-12-31 04:51:45', '2024-12-31 06:09:45'),
(306, '493', 'Tagihan BPK awi', '<p>Blm ad</p>', 'Dahlan tnjg morawa', '98.7928384', '3.5173656', 1, NULL, '2024-12-31 05:06:01', '2024-12-31 06:10:20'),
(307, '493', 'Tagihan BPK ferry', '<p>Blm ada</p>', 'Irian tnjg morawa', '98.7928532', '3.5173301', 1, NULL, '2024-12-31 05:07:06', '2024-12-31 06:10:38'),
(308, '493', 'Tagihan BPK iwanto', '<p>Blm ada</p>', 'Dalam tnjg morawa', '98.7909178', '3.5173436', 1, NULL, '2024-12-31 05:09:54', '2024-12-31 06:10:54'),
(309, '493', 'Tagihan bilah baja makmur abadi', '<p>Tutup</p>', 'Wajit', '98.6808967', '3.5826447', 1, NULL, '2024-12-31 06:46:52', '2024-12-31 06:54:03'),
(310, '74', 'PT era cipta bina karya', '<p>Giro Maybank </p><p>No DE501891</p>', 'Kim 1', '98.6751091', '3.6729526', 1, NULL, '2024-12-31 06:49:30', '2024-12-31 06:54:19'),
(311, '74', 'PT era cipta bina karya', '<p>Tanda terima ok </p>', 'Kim 1', '98.6750489', '3.6730201', 1, NULL, '2024-12-31 06:57:48', '2024-12-31 07:05:26'),
(312, '74', 'PT socimas', '<p>Ambil dokumen</p>', 'Kim 1', '98.6741503', '3.673317', 1, NULL, '2024-12-31 07:08:27', '2024-12-31 07:12:22'),
(313, '74', 'PT intan hevea industri', '<p>Cash Rp 99.900</p>', 'Kim1', '98.6732725', '3.6739938', 1, NULL, '2024-12-31 07:21:32', '2024-12-31 07:28:28'),
(314, '74', 'PT indoglove', '<p>Tutup </p><p>Tgl 6 buka</p>', 'Kim 1', '98.6725879', '3.6751', 1, NULL, '2024-12-31 07:29:47', '2024-12-31 07:36:08'),
(315, '74', 'PT Chandra kemas indonesia(ipi)', '<p>Antar sertifikat tera </p>', 'Kim1', '98.6701582', '3.6633382', 1, NULL, '2024-12-31 07:58:21', '2024-12-31 08:56:57'),
(316, '74', 'Cv tepat teknik', '<p>Tutup </p>', 'Yos Sudarso', '98.6723425', '3.6148366', 1, NULL, '2024-12-31 08:34:06', '2024-12-31 08:57:10'),
(317, '493', 'Tnda trm PT phg', '<p>Ok</p>', 'Ismud no 107', '98.6606716', '3.5845042', 1, NULL, '2025-01-02 01:21:39', '2025-01-02 09:20:45'),
(318, '74', 'PT intratek', '<p>Masih tutup </p>', 'Jln kepribadian 2', '98.6772173', '3.5889457', 1, NULL, '2025-01-02 02:56:03', '2025-01-02 09:20:58'),
(319, '74', 'PT gotong royong jaya', '<p>Tanda terima ok </p>', 'Jln hindu33', '98.6771903', '3.5875908', 1, NULL, '2025-01-02 03:04:14', '2025-01-02 09:22:02'),
(320, '74', 'Ud sedehana', '<p>Tanda terima ok </p>', 'Jln kereta api', '98.6814113', '3.586479', 1, NULL, '2025-01-02 04:11:13', '2025-01-02 09:22:15'),
(321, '74', 'PT intan sejati andalan', '<p>Tutup </p>', 'Jati juction', '98.6791591', '3.5967725', 1, NULL, '2025-01-02 04:22:54', '2025-01-02 09:22:28'),
(322, '493', 'Tnda trm PT sumber bumi sawit jd jaya', '<p>Ok</p>', 'Taman Polonia 4 no 38', '98.6804401', '3.5701408', 1, NULL, '2025-01-02 04:35:57', '2025-01-02 09:22:42'),
(323, '74', 'PT buana sawit indah', '<p>Tanda terima tidak  bisa no NPWP salah</p>', 'Jln sei kera 131', '98.6913013', '3.5958992', 1, NULL, '2025-01-02 04:37:43', '2025-01-02 09:22:54'),
(324, '493', 'Tagihan BPK amin / mja', '<p>Minggu dpn di tf</p>', 'Komp Sanur no 9 Deli tua', '98.679926', '3.5170064', 1, NULL, '2025-01-02 05:11:05', '2025-01-02 09:20:31'),
(325, '493', 'Tnda trm BPK ahuay / mjs', '<p>Ok</p>', 'Katamso GG sepakat no 39', '98.6842032', '3.5433124', 1, NULL, '2025-01-02 05:29:39', '2025-01-02 09:19:22'),
(326, '74', 'BPK asin', '<p>Tanda terima ok </p>', 'Komp harmoni sientis Percut', '98.7298571', '3.6755725', 1, NULL, '2025-01-02 06:36:08', '2025-01-02 09:18:49'),
(327, '74', 'PT Mahato inti sawit', '<p>Tagihan kasir libur</p><p>Tandai terima ok</p>', 'Cemara asri berjaya', '98.7065791', '3.6330954', 1, NULL, '2025-01-02 06:57:10', '2025-01-02 09:18:38'),
(328, '493', 'Tagihan dan tnda trm BPK Erwin / king,s jaya', '<p>Ok</p>', 'Pandu no 67', '98.6858359', '3.5827631', 1, NULL, '2025-01-02 07:10:31', '2025-01-02 09:18:21'),
(329, '493', 'Tnda trm BPK David / victory', '<p>Ok</p>', 'Pandu no 10', '98.6858759', '3.5827959', 1, NULL, '2025-01-02 07:13:54', '2025-01-02 09:18:02'),
(330, '74', 'PT ocean', '<p>Tanda terima ok </p>', 'Jln cemara', '98.703218', '3.6283939', 1, NULL, '2025-01-02 07:15:32', '2025-01-02 09:17:48'),
(331, '74', 'PT saintifik Indonesia', '<p>Tutup </p>', 'Jln karakatau ujung 10a', '98.6810402', '3.6295353', 1, NULL, '2025-01-02 08:09:38', '2025-01-02 09:17:34');
INSERT INTO `tb_collect` (`id`, `kode_pegawai`, `title`, `keterangan`, `location`, `longitude`, `latitude`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(332, '74', 'PT bangun sempurna lestari', '<p>Tanda terima ok </p>', 'Jln karakatau 10e', '98.6811643', '3.6291794', 1, NULL, '2025-01-02 08:13:26', '2025-01-02 09:17:15'),
(333, '74', 'Kl furniture', '<p>Blom ada(tutup)</p>', 'Jln Budi kemasyarakatan', '98.671695', '3.6213304', 1, NULL, '2025-01-02 08:32:50', '2025-01-02 09:17:00'),
(334, '493', 'Tnda trm PT ensem sawita', '<p>Ok</p>', 'Kalimantan no 1g', '98.6906089', '3.5905023', 1, NULL, '2025-01-03 01:50:42', '2025-01-03 08:09:48'),
(335, '74', 'PT socfin Indonesia', '<p>Tanda terima ok</p>', 'Yos Sudarso', '98.6715431', '3.6186017', 1, NULL, '2025-01-03 02:03:27', '2025-01-03 08:09:35'),
(336, '493', 'Tagihan , tnda trm dan sertifikat', '<p>Lunas dan ok</p>', 'Gandhi no 111', '98.6902545', '3.5833352', 1, NULL, '2025-01-03 02:19:52', '2025-01-03 08:09:22'),
(337, '74', 'PT universal Indofood product', '<p>Tanda terima ok </p>', 'Yos Sudarso', '98.6625295', '3.6446935', 1, NULL, '2025-01-03 02:39:51', '2025-01-03 08:09:02'),
(338, '74', 'PT Mabar feed', '<p>Tanda terima ok </p><p>Klo tagihan blom ada</p>', 'RPH', '98.6684596', '3.658009', 1, NULL, '2025-01-03 03:02:21', '2025-01-03 08:08:44'),
(339, '74', 'PT sumber setamurni', '<p>Tanda terima ok </p>', 'Kim 1', '98.6760998', '3.6701935', 1, NULL, '2025-01-03 03:33:32', '2025-01-03 08:08:26'),
(340, '493', 'Tagihan CV jaya perkasa abadi', '<p>Blm ada</p>', 'Industri no 60 tnjg morawa', '98.8064334', '3.5284405', 1, NULL, '2025-01-03 03:42:44', '2025-01-03 08:08:11'),
(341, '74', 'PT growth asia', '<p>Tanda terima ok </p>', 'Kim1', '98.669723', '3.6704244', 1, NULL, '2025-01-03 03:47:30', '2025-01-03 08:07:58'),
(342, '74', 'PT indoglove', '<p>Libur</p>', 'Kim 1', '98.6725091', '3.6751065', 1, NULL, '2025-01-03 03:53:50', '2025-01-03 08:07:44'),
(343, '493', 'Toko jakarta', '<p>Cri orderan</p>', 'Irian no 159 tnjg morawa', '98.7932734', '3.5180679', 1, NULL, '2025-01-03 04:03:59', '2025-01-03 08:07:26'),
(344, '493', 'Tagihan BPK Kim heng / sepakat', '<p>Lunas</p>', 'Irian no 110  tnjg morawa', '98.7932626', '3.5180627', 1, NULL, '2025-01-03 04:05:18', '2025-01-03 08:07:13'),
(345, '493', 'TKO indah mekar jaya / BPK ferry', '<p>Cri orderan</p>', 'Irian no 150 tnjg morawa', '98.792881', '3.5173497', 1, NULL, '2025-01-03 04:08:19', '2025-01-03 08:06:45'),
(346, '493', 'Tagihan BPK along / cahaya', '<p>Blm ada</p>', 'Dahlan tnjg no 94 tnjg morawa', '98.7884002', '3.5190837', 1, NULL, '2025-01-03 04:14:49', '2025-01-03 08:06:34'),
(347, '74', 'PT global inovasi prima', '<p>Tanda terima ok </p>', 'Jln Yos Sudarso km 13.1 no 3', '98.6716377', '3.6927413', 1, NULL, '2025-01-03 04:58:52', '2025-01-03 08:06:12'),
(348, '74', 'PT rajawali perkasa Sakti', '<p>Tanda terima ok </p>', 'Jln ileng komp grand permata hijau', '98.6766342', '3.7134509', 1, NULL, '2025-01-03 05:08:54', '2025-01-03 08:05:52'),
(349, '493', 'Tagihan PT bilah baja makmur abadi', '<p>Lunas</p>', 'Cakrawati no 5', '98.6809068', '3.582672', 1, NULL, '2025-01-03 06:21:11', '2025-01-03 08:05:35'),
(350, '493', 'Tagihan BPK aik / TKO kini', '<p>Lunas</p>', 'Mt haryono no 51', '98.6846708', '3.5867266', 1, NULL, '2025-01-03 06:59:09', '2025-01-03 08:01:15'),
(351, '74', 'PT siringo ringo sarana esa musim mas.multi persada gatramegah p', '<p>Tanda terima ok </p>', 'Yos Sudarso', '98.6629112', '3.6474105', 1, NULL, '2025-01-03 07:33:03', '2025-01-03 08:00:52'),
(352, '493', 'Tnda trm PT varem sawit cemerlan', '<p>Ok</p>', 'Griya dom', '98.6517741', '3.6075888', 1, NULL, '2025-01-03 07:37:01', '2025-01-03 08:00:33'),
(353, '493', 'Tnda trm PT rapala', '<p>Ok</p>', 'Sei btg hari no 92', '98.6466578', '3.5850553', 1, NULL, '2025-01-03 07:49:32', '2025-01-03 07:59:30'),
(354, '74', 'BPK awi', '<p>Tanda terima ok </p><p>Tagihan bayar cash Rp 978.000</p>', 'Rahayu4', '98.65853', '3.6325426', 1, NULL, '2025-01-03 07:50:39', '2025-01-03 07:59:15'),
(355, '74', 'Toko perabot serba ada', '<p>Bayar cash rp840.000</p><p>Potong SPSI rp10.000</p>', 'Yos Sudarso', '98.6696968', '3.6298352', 1, NULL, '2025-01-03 08:16:33', '2025-01-03 08:47:07'),
(356, '74', 'BPK Fransiskus Halim', '<p>Blom ada</p>', 'Yos Sudarso', '98.6694596', '3.6280092', 1, NULL, '2025-01-03 08:22:46', '2025-01-03 08:47:19'),
(357, '74', 'Cv tepat teknik', '<p>Blom ada</p>', 'Yos Sudarso', '98.6709305', '3.6207705', 1, NULL, '2025-01-03 08:32:26', '2025-01-03 08:47:33'),
(358, '493', 'Bon lunas BPK Andre / mandiri jaya', '<p>Ok</p>', 'Pelita btg kuis', '98.8010238', '3.6138369', 1, NULL, '2025-01-04 01:54:20', '2025-01-06 02:21:22'),
(359, '74', 'PT sari incofood', '<p>Tanda terima ok </p>', 'Jln Cokroaminoto', '98.6922698', '3.5919803', 1, NULL, '2025-01-04 03:03:00', '2025-01-06 02:23:10'),
(360, '74', 'PT STTC', '<p>Tanda terima ok </p>', 'Jln Cokroaminoto', '98.6922571', '3.591972', 1, NULL, '2025-01-04 03:06:33', '2025-01-06 02:23:21'),
(361, '74', 'PT sari incofood', '<p>Antar sertifikat tera </p>', 'Jln Cokroaminoto', '98.6927645', '3.5920925', 1, NULL, '2025-01-04 03:11:45', '2025-01-06 02:23:35'),
(362, '493', 'TK rezeki / BPK acong', '<p>Cri orderan</p>', 'Niaga btg kuis', '98.80245', '3.6130199', 1, NULL, '2025-01-04 03:12:04', '2025-01-06 02:23:47'),
(363, '493', 'TK istana kado', '<p>Cri orderan</p>', 'Niaga btg kuis', '98.8023372', '3.6130908', 1, NULL, '2025-01-04 03:14:24', '2025-01-06 02:24:04'),
(364, '493', 'TK fajar electronic', '<p>Cri orderan</p>', 'Niaga btg kuis', '98.8023011', '3.6130618', 1, NULL, '2025-01-04 03:15:41', '2025-01-06 02:24:16'),
(365, '493', 'TK istana electric', '<p>Cri orderan</p>', 'Niaga btg kuis', '98.8019726', '3.6131143', 1, NULL, '2025-01-04 03:17:04', '2025-01-06 02:24:32'),
(366, '493', 'TK semangat baru', '<p>Cri orderan</p>', 'Veteran btg kuis', '98.8007046', '3.6129033', 1, NULL, '2025-01-04 03:23:31', '2025-01-06 02:24:46'),
(367, '493', 'TK Surya mas', '<p>Cri orderan</p>', 'Niaga btg kuis', '98.8010306', '3.6133037', 1, NULL, '2025-01-04 03:30:16', '2025-01-06 02:25:09'),
(368, '74', 'PT usdama damai sejahtera', '<p>Antar sertifikat tera </p>', 'Jln Tembung depan Bgr', '98.7426297', '3.5966044', 1, NULL, '2025-01-04 03:36:13', '2025-01-06 02:22:56'),
(369, '74', 'BPK aek', '<p>Tanda terima </p>', 'Mandala by pass', '98.711073', '3.5922145', 1, NULL, '2025-01-04 03:53:04', '2025-01-06 02:22:46'),
(370, '74', 'Kartini sinar bintang', '<p>Antar sertifikat tera </p>', 'Jln pukat7 GG indah', '98.7083111', '3.590519', 1, NULL, '2025-01-04 04:04:39', '2025-01-06 02:22:36'),
(371, '493', 'Tagihan BPK aho', '<p>Blm ada</p>', 'P. Psar no 519', '98.6865258', '3.5900714', 1, NULL, '2025-01-04 05:55:45', '2025-01-06 02:22:24'),
(372, '394', 'P pasar', '<p>P pasar</p>', 'P pasar', '98.6864811', '3.5901473', 1, NULL, '2025-01-04 05:58:48', '2025-01-06 02:22:13'),
(373, '493', 'Tagihan BPK awi', '<p>Lunas</p>', 'P. psar no 197', '98.6844288', '3.5913438', 1, NULL, '2025-01-04 06:31:24', '2025-01-06 02:21:57'),
(374, '74', 'Surya perabot', '<p>Tagihan blom jatuh tempo</p><p>Bos gak mau bayar</p>', 'Jln ar hakim', '98.7037242', '3.5797989', 1, NULL, '2025-01-04 06:36:18', '2025-01-06 02:21:43'),
(375, '493', 'Tnda trm PT everbright', '<p>Ok</p>', 'Rasak no 7', '98.6663686', '3.5935565', 1, NULL, '2025-01-06 01:28:19', '2025-01-06 06:08:55'),
(376, '493', 'Tnda trm PT Agra garlica lestari', '<p>Ok</p>', 'Komp.ruko Merbau mas no 95', '98.6621471', '3.5946215', 1, NULL, '2025-01-06 01:37:58', '2025-01-06 06:39:09'),
(377, '493', 'Tnda trm PT  permata hijau indo', '<p>Ok</p>', 'Ismud no 107', '98.6606286', '3.58452', 1, NULL, '2025-01-06 01:50:39', '2025-01-06 06:39:39'),
(378, '74', 'PT sinar Bengkulu Selatan', '<p>Tanda terima ok </p>', 'Jln candi Kalasan', '98.6718549', '3.5887568', 1, NULL, '2025-01-06 02:51:13', '2025-01-06 06:40:43'),
(379, '493', 'Tnda trm PT Mina prima sejahtera', '<p>Ok</p>', 'Komp.villa malina jln permata indah no 10', '98.6244313', '3.5505219', 1, NULL, '2025-01-06 02:54:18', '2025-01-06 06:41:03'),
(380, '74', 'Cv intratek', '<p>Tanda terima ok </p>', 'Jln kepribadian 2', '98.6773261', '3.5889867', 1, NULL, '2025-01-06 02:58:31', '2025-01-06 06:41:21'),
(381, '74', 'PT PP London Sumatra Indonesia', '<p>Tanda terima ok </p>', 'Jln a yani', '98.6782171', '3.5886882', 1, NULL, '2025-01-06 03:07:17', '2025-01-06 06:41:42'),
(382, '493', 'Tnda trm PT pakan sawit unggul', '<p>Ok</p>', 'Merak no 67', '98.6281152', '3.5847497', 1, NULL, '2025-01-06 03:23:17', '2025-01-06 06:42:00'),
(383, '74', 'Alai sg', '<p>Tanda terima ok </p><p>Tagihan blom ada </p>', 'Yos Sudarso', '98.6741961', '3.6098125', 1, NULL, '2025-01-06 03:53:09', '2025-01-06 04:47:19'),
(384, '74', 'PT saintifik Indonesia', '<p>Tanda terima ok </p>', 'Jln karakatau simp Cemara', '98.6810991', '3.6294188', 1, NULL, '2025-01-06 04:21:22', '2025-01-06 06:43:11'),
(385, '74', 'PT tenera lestari', '<p>Tanda terima ok </p>', 'Jln kalimantan', '98.6906117', '3.590495', 1, NULL, '2025-01-06 04:56:26', '2025-01-06 06:43:23'),
(386, '493', 'Tagihan ibu asiu / king,s diesel', '<p>Blm ada</p>', 'Pandu no 98', '98.6842273', '3.582187', 1, NULL, '2025-01-06 06:31:04', '2025-01-06 06:43:39'),
(387, '493', 'Tnda trm PT samawa industri bersama', '<p>Ok</p>', 'Katamso dlm no 64 n / 25', '98.6838131', '3.5766049', 1, NULL, '2025-01-06 06:39:49', '2025-01-06 06:44:01'),
(388, '493', 'Tnda trm TK sms', '<p>Ok</p>', 'Pandu no 46', '98.6858304', '3.5827978', 1, NULL, '2025-01-06 06:54:12', '2025-01-06 07:08:02'),
(389, '493', 'Tnda trm BPK Frans / TK sinar berjaya lestari', '<p>Ok</p>', 'Pandu no 51', '98.6858666', '3.5828058', 1, NULL, '2025-01-06 07:01:12', '2025-01-06 07:08:12'),
(390, '74', 'Toko perabot mautain', '<p>Cici gak TT.jatuh tempo tagih langsung </p>', 'Jln ar hakim', '98.7036377', '3.5810521', 1, NULL, '2025-01-06 07:14:07', '2025-01-06 09:20:59'),
(391, '74', 'Toko Surya mebel', '<p>Tagihan di transfer rp850.000</p><p>Tgl 6/1/25 via BRI </p>', 'Ar hakim', '98.7037239', '3.579794', 1, NULL, '2025-01-06 07:34:47', '2025-01-06 09:21:11'),
(392, '74', 'PT univista utama', '<p>Tanda terima ok </p>', 'Jln Ghandi 111/45', '98.6902969', '3.5833491', 1, NULL, '2025-01-06 08:04:54', '2025-01-06 08:11:44'),
(393, '74', 'BPK aik toko kini', '<p>Tanda terima ok </p>', 'Jln mt haryono', '98.6846675', '3.586839', 1, NULL, '2025-01-06 08:19:05', '2025-01-06 09:21:32'),
(394, '74', 'PT semadam', '<p>Ambil kekurangan rp500</p>', 'Jln Nibung 93', '98.6646613', '3.5878329', 1, NULL, '2025-01-06 08:47:13', '2025-01-06 08:51:50'),
(395, '493', 'Tagihan ibu afang', '<p>Nti sore ditf</p>', 'Rotan no 48 petisah', '98.6675004', '3.5907697', 1, NULL, '2025-01-06 08:47:47', '2025-01-06 09:21:55'),
(396, '493', 'Tnda trm mdn jaya', '<p>Ok</p>', 'Razak baru no 5', '98.6674528', '3.5920263', 1, NULL, '2025-01-06 08:53:15', '2025-01-06 09:22:05');

-- --------------------------------------------------------

--
-- Table structure for table `tb_dayoff`
--

CREATE TABLE `tb_dayoff` (
  `id` bigint UNSIGNED NOT NULL,
  `id_user` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dayoff_for` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_dari` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tgl_hingga` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_deduction`
--

CREATE TABLE `tb_deduction` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_pegawai` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deduction_name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deduction_type` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deduction_fee` bigint DEFAULT NULL,
  `deduction_period` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_deduction`
--

INSERT INTO `tb_deduction` (`id`, `kode_pegawai`, `deduction_name`, `deduction_type`, `deduction_fee`, `deduction_period`, `created_at`, `updated_at`) VALUES
(1, '28101999', 'BPJS Kesehatan', '3.7', 148000, '2024-10-01', '2024-11-01 03:02:32', '2024-11-07 04:52:40'),
(2, '28101999', 'BPJS Ketenagakerjaan', '4', 160000, '2024-10-01', '2024-11-01 03:05:42', '2024-11-07 04:52:51'),
(4, '28101999', 'Absen 2xc', '98000', 98000, '11/01/2024', '2024-11-07 04:53:26', '2024-11-07 07:40:13');

-- --------------------------------------------------------

--
-- Table structure for table `tb_division`
--

CREATE TABLE `tb_division` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_divisi` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_divisi` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_division`
--

INSERT INTO `tb_division` (`id`, `kode_divisi`, `nama_divisi`, `created_at`, `updated_at`) VALUES
(7, '1001', 'Marketing', '2024-09-29 20:25:09', '2024-09-29 20:25:09'),
(8, '2001', 'Finance', '2024-09-29 20:25:16', '2024-09-29 20:25:16'),
(9, '3001', 'Admin', '2024-09-29 20:25:29', '2024-09-29 20:25:29'),
(10, '4001', 'Technician', '2024-09-29 20:25:40', '2024-09-29 20:25:40'),
(11, '5001', 'IT Support', '2024-09-26 20:25:50', '2024-10-08 07:24:57'),
(96513, 'ST01', 'Staff Operasional', '2024-11-29 11:05:41', '2024-11-29 11:05:41');

-- --------------------------------------------------------

--
-- Table structure for table `tb_golongan`
--

CREATE TABLE `tb_golongan` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_golongan` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alias` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_golongan`
--

INSERT INTO `tb_golongan` (`id`, `nama_golongan`, `alias`, `created_at`, `updated_at`) VALUES
(4, 'Karyawan Tetap', 'Kartap', '2024-10-04 03:22:16', '2024-10-04 03:22:16'),
(5, 'Harian Lepas', 'Harlep', '2024-10-04 03:39:33', '2024-10-04 03:39:33'),
(6, 'Piket', 'Piket', '2024-10-04 03:44:35', '2024-10-04 03:44:35');

-- --------------------------------------------------------

--
-- Table structure for table `tb_jabatan`
--

CREATE TABLE `tb_jabatan` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_jabatan` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `divisi` bigint UNSIGNED NOT NULL,
  `penempatan` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_jabatan`
--

INSERT INTO `tb_jabatan` (`id`, `nama_jabatan`, `divisi`, `penempatan`, `created_at`, `updated_at`) VALUES
(11, 'Developer', 11, 5, '2024-09-29 20:26:23', '2024-12-11 09:13:33'),
(12, 'Service', 9, 5, '2024-09-29 21:56:58', '2024-09-29 21:57:37'),
(13, 'Telemarketing', 9, 5, '2024-09-29 21:57:09', '2024-09-29 21:57:42'),
(14, 'Kasir', 8, 5, '2024-09-29 21:57:55', '2024-10-09 04:00:00'),
(15, 'Piutang', 8, 5, '2024-09-29 21:58:05', '2024-09-29 21:58:05'),
(24, 'Hardware Support', 11, 5, '2024-10-14 03:18:45', '2024-10-14 03:18:45'),
(25, 'Teknisi Office', 10, 5, '2024-10-24 02:47:04', '2024-10-24 02:47:04'),
(26, 'Teknisi Rute', 10, 5, '2024-11-13 06:09:44', '2024-11-13 06:09:44'),
(27, 'Karyawan PKU', 8, 10, '2024-11-22 09:26:03', '2024-11-22 09:26:03'),
(28, 'Kolektor', 96513, 5, '2024-11-29 11:06:05', '2024-11-29 11:06:05');

-- --------------------------------------------------------

--
-- Table structure for table `tb_jadwal`
--

CREATE TABLE `tb_jadwal` (
  `id` bigint UNSIGNED NOT NULL,
  `id_golongan` bigint UNSIGNED DEFAULT NULL,
  `hari` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jam_masuk` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jam_keluar` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `break_start` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `break_end` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_jadwal`
--

INSERT INTO `tb_jadwal` (`id`, `id_golongan`, `hari`, `jam_masuk`, `jam_keluar`, `break_start`, `break_end`, `created_at`, `updated_at`) VALUES
(1, 4, 'Senin', '08:00', '17:00', NULL, NULL, '2024-10-04 03:22:16', '2024-10-04 04:33:36'),
(2, 4, 'Selasa', '08:00', '17:00', NULL, NULL, '2024-10-04 03:22:16', '2024-10-04 04:33:37'),
(3, 4, 'Rabu', '08:00', '17:00', NULL, NULL, '2024-10-04 03:22:16', '2024-10-04 04:33:37'),
(4, 4, 'Kamis', '08:00', '17:00', NULL, NULL, '2024-10-04 03:22:16', '2024-10-04 04:33:37'),
(5, 4, 'Jumat', '08:00', '16:30', NULL, NULL, '2024-10-04 03:22:16', '2024-10-04 04:33:52'),
(6, 4, 'Sabtu', '08:00', '14:00', NULL, NULL, '2024-10-04 03:22:16', '2024-10-04 04:33:52'),
(7, 5, 'Senin', '08:00', '17:00', NULL, NULL, '2024-10-04 03:39:33', '2024-10-04 04:34:19'),
(8, 5, 'Selasa', '08:00', '17:00', NULL, NULL, '2024-10-04 03:39:33', '2024-10-04 04:34:19'),
(9, 5, 'Rabu', '08:00', '17:00', NULL, NULL, '2024-10-04 03:39:33', '2024-10-04 04:34:19'),
(10, 5, 'Kamis', '08:00', '17:00', NULL, NULL, '2024-10-04 03:39:33', '2024-10-04 04:34:19'),
(11, 5, 'Jumat', '08:00', '17:00', NULL, NULL, '2024-10-04 03:39:33', '2024-10-04 04:34:19'),
(12, 5, 'Sabtu', '08:00', '17:00', NULL, NULL, '2024-10-04 03:39:33', '2024-10-04 04:34:19'),
(13, 6, 'Senin', '00:00', '00:00', NULL, NULL, '2024-10-04 03:44:35', '2024-11-13 06:55:31'),
(14, 6, 'Selasa', '00:00', '00:00', NULL, NULL, '2024-10-04 03:44:35', '2024-11-13 06:55:31'),
(15, 6, 'Rabu', '00:00', '00:00', NULL, NULL, '2024-10-04 03:44:35', '2024-11-13 06:55:31'),
(16, 6, 'Kamis', '00:00', '00:00', NULL, NULL, '2024-10-04 03:44:35', '2024-11-13 06:55:31'),
(17, 6, 'Jumat', '00:00', '00:00', NULL, NULL, '2024-10-04 03:44:35', '2024-11-13 06:55:31'),
(18, 6, 'Sabtu', '00:00', '00:00', NULL, NULL, '2024-10-04 03:44:35', '2024-11-13 06:55:31');

-- --------------------------------------------------------

--
-- Table structure for table `tb_log`
--

CREATE TABLE `tb_log` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `user_action` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_location` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_log`
--

INSERT INTO `tb_log` (`id`, `user_id`, `user_action`, `ip_address`, `user_agent`, `user_location`, `created_at`, `updated_at`) VALUES
(1691, 1, 'login', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 06:09:21', '2024-11-13 06:09:21'),
(1692, 1, 'login > create', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 06:09:21', '2024-11-13 06:09:21'),
(1693, 1, 'jabatan > create', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 06:09:44', '2024-11-13 06:09:44'),
(1694, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 06:11:56', '2024-11-13 06:11:56'),
(1695, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 06:11:56', '2024-11-13 06:11:56'),
(1696, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 06:25:31', '2024-11-13 06:25:31'),
(1697, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 06:25:31', '2024-11-13 06:25:31'),
(1698, 1, 'pegawai > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 06:26:34', '2024-11-13 06:26:34'),
(1699, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 06:29:48', '2024-11-13 06:29:48'),
(1700, 1020, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 06:29:57', '2024-11-13 06:29:57'),
(1701, 1020, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 06:29:57', '2024-11-13 06:29:57'),
(1702, 1020, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 06:29:57', '2024-11-13 06:29:57'),
(1703, 1020, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 06:29:57', '2024-11-13 06:29:57'),
(1704, 1020, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 06:30:34', '2024-11-13 06:30:34'),
(1705, 1020, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 06:30:42', '2024-11-13 06:30:42'),
(1706, 1020, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 06:30:42', '2024-11-13 06:30:42'),
(1707, 1020, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 06:31:41', '2024-11-13 06:31:41'),
(1708, 1005, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 06:31:56', '2024-11-13 06:31:56'),
(1709, 1005, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 06:31:56', '2024-11-13 06:31:56'),
(1710, 1005, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 06:33:14', '2024-11-13 06:33:14'),
(1711, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 06:33:19', '2024-11-13 06:33:19'),
(1712, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 06:33:19', '2024-11-13 06:33:19'),
(1713, 1, 'roles > update', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 06:34:13', '2024-11-13 06:34:13'),
(1714, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 06:34:17', '2024-11-13 06:34:17'),
(1715, 1005, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 06:34:27', '2024-11-13 06:34:27'),
(1716, 1005, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 06:34:27', '2024-11-13 06:34:27'),
(1717, 1005, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 06:38:06', '2024-11-13 06:38:06'),
(1718, 1006, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 06:38:25', '2024-11-13 06:38:25'),
(1719, 1006, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 06:38:25', '2024-11-13 06:38:25'),
(1720, 1006, 'login', '114.10.81.84', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Mobile Safari/537.36 OPR/85.0.0.0', 'Unknown', '2024-11-13 06:41:11', '2024-11-13 06:41:11'),
(1721, 1006, 'login > create', '114.10.81.84', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Mobile Safari/537.36 OPR/85.0.0.0', 'Unknown', '2024-11-13 06:41:11', '2024-11-13 06:41:11'),
(1722, 1020, 'login', '114.122.10.26', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-13 06:47:55', '2024-11-13 06:47:55'),
(1723, 1020, 'login > create', '114.122.10.26', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-13 06:47:55', '2024-11-13 06:47:55'),
(1724, 1006, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 06:48:49', '2024-11-13 06:48:49'),
(1725, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 06:48:54', '2024-11-13 06:48:54'),
(1726, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 06:48:54', '2024-11-13 06:48:54'),
(1727, 1, 'pegawai > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 06:49:35', '2024-11-13 06:49:35'),
(1728, 1020, 'login > create', '114.122.10.26', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-13 06:49:53', '2024-11-13 06:49:53'),
(1729, 1020, 'login > create', '114.122.10.26', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-13 06:49:57', '2024-11-13 06:49:57'),
(1730, 1020, 'login > create', '114.122.10.26', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-13 06:50:11', '2024-11-13 06:50:11'),
(1731, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 06:52:45', '2024-11-13 06:52:45'),
(1732, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 06:53:26', '2024-11-13 06:53:26'),
(1733, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 06:53:26', '2024-11-13 06:53:26'),
(1734, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 06:53:56', '2024-11-13 06:53:56'),
(1735, 1020, 'profile > update', '114.122.10.26', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-13 06:53:58', '2024-11-13 06:53:58'),
(1736, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 06:54:01', '2024-11-13 06:54:01'),
(1737, 1021, 'login', '182.3.104.226', 'Mozilla/5.0 (Android 12; Mobile; rv:132.0) Gecko/132.0 Firefox/132.0', 'Unknown', '2024-11-13 06:54:13', '2024-11-13 06:54:13'),
(1738, 1021, 'login > create', '182.3.104.226', 'Mozilla/5.0 (Android 12; Mobile; rv:132.0) Gecko/132.0 Firefox/132.0', 'Unknown', '2024-11-13 06:54:13', '2024-11-13 06:54:13'),
(1739, 1020, 'api > create', '114.122.10.26', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-13 06:54:56', '2024-11-13 06:54:56'),
(1740, 1020, 'check-attendance > create', '114.122.10.26', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-13 06:54:56', '2024-11-13 06:54:56'),
(1741, 1020, 'store-attendance > create', '114.122.10.26', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-13 06:54:56', '2024-11-13 06:54:56'),
(1742, 1021, 'login > create', '182.3.104.226', 'Mozilla/5.0 (Android 12; Mobile; rv:132.0) Gecko/132.0 Firefox/132.0', 'Unknown', '2024-11-13 06:54:59', '2024-11-13 06:54:59'),
(1743, 1, 'golongan > update', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 06:55:31', '2024-11-13 06:55:31'),
(1744, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 07:01:02', '2024-11-13 07:01:02'),
(1745, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 07:01:07', '2024-11-13 07:01:07'),
(1746, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 07:01:07', '2024-11-13 07:01:07'),
(1747, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 07:01:25', '2024-11-13 07:01:25'),
(1748, 1006, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 07:01:31', '2024-11-13 07:01:31'),
(1749, 1006, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 07:01:31', '2024-11-13 07:01:31'),
(1750, 1006, 'upload-image > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 07:04:00', '2024-11-13 07:04:00'),
(1751, 1006, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 07:08:05', '2024-11-13 07:08:05'),
(1752, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 07:11:35', '2024-11-13 07:11:35'),
(1753, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 07:11:35', '2024-11-13 07:11:35'),
(1754, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 07:11:41', '2024-11-13 07:11:41'),
(1755, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 07:12:47', '2024-11-13 07:12:47'),
(1756, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 07:12:47', '2024-11-13 07:12:47'),
(1757, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 07:14:05', '2024-11-13 07:14:05'),
(1758, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 07:16:04', '2024-11-13 07:16:04'),
(1759, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 07:16:04', '2024-11-13 07:16:04'),
(1760, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 07:16:18', '2024-11-13 07:16:18'),
(1761, 1006, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 07:16:25', '2024-11-13 07:16:25'),
(1762, 1006, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 07:16:25', '2024-11-13 07:16:25'),
(1763, 1006, 'api > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 07:16:45', '2024-11-13 07:16:45'),
(1764, 1006, 'check-attendance > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 07:16:45', '2024-11-13 07:16:45'),
(1765, 1006, 'store-attendance-out > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 07:16:46', '2024-11-13 07:16:46'),
(1766, 1006, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 07:17:52', '2024-11-13 07:17:52'),
(1767, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 07:17:58', '2024-11-13 07:17:58'),
(1768, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 07:17:58', '2024-11-13 07:17:58'),
(1769, 1, 'roles > update', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 07:18:24', '2024-11-13 07:18:24'),
(1770, 1, 'pegawai > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 07:54:12', '2024-11-13 07:54:12'),
(1771, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 08:01:22', '2024-11-13 08:01:22'),
(1772, 1006, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 08:01:27', '2024-11-13 08:01:27'),
(1773, 1006, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 08:01:27', '2024-11-13 08:01:27'),
(1774, 1006, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 08:01:38', '2024-11-13 08:01:38'),
(1775, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 08:01:43', '2024-11-13 08:01:43'),
(1776, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 08:01:43', '2024-11-13 08:01:43'),
(1777, 1, 'roles > update', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 08:02:06', '2024-11-13 08:02:06'),
(1778, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 08:13:03', '2024-11-13 08:13:03'),
(1779, 1006, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 08:13:10', '2024-11-13 08:13:10'),
(1780, 1006, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 08:13:10', '2024-11-13 08:13:10'),
(1781, 1006, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 08:15:13', '2024-11-13 08:15:13'),
(1782, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 08:15:18', '2024-11-13 08:15:18'),
(1783, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 08:15:18', '2024-11-13 08:15:18'),
(1784, 1020, 'login', '114.122.10.26', 'Mozilla/5.0 (Linux;  14; 2311DRK48G Build/UP1A.230905.011; ) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/130.0.6723.86  Safari/537.36', 'Unknown', '2024-11-13 08:18:00', '2024-11-13 08:18:00'),
(1785, 1020, 'login > create', '114.122.10.26', 'Mozilla/5.0 (Linux;  14; 2311DRK48G Build/UP1A.230905.011; ) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/130.0.6723.86  Safari/537.36', 'Unknown', '2024-11-13 08:18:00', '2024-11-13 08:18:00'),
(1786, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 08:19:58', '2024-11-13 08:19:58'),
(1787, 1006, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 08:20:07', '2024-11-13 08:20:07'),
(1788, 1006, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 08:20:07', '2024-11-13 08:20:07'),
(1789, 1006, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 08:25:59', '2024-11-13 08:25:59'),
(1790, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 08:26:05', '2024-11-13 08:26:05'),
(1791, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 08:26:05', '2024-11-13 08:26:05'),
(1792, 1, 'users > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 08:27:17', '2024-11-13 08:27:17'),
(1793, 1006, 'login', '114.122.23.35', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_6_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.6 Mobile/15E148 Safari/604.1', 'Unknown', '2024-11-13 08:29:43', '2024-11-13 08:29:43'),
(1794, 1006, 'login > create', '114.122.23.35', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_6_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.6 Mobile/15E148 Safari/604.1', 'Unknown', '2024-11-13 08:29:43', '2024-11-13 08:29:43'),
(1795, 1006, 'login', '114.122.23.35', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/130.0.6723.90 Mobile/15E148 Safari/604.1', 'Unknown', '2024-11-13 08:33:13', '2024-11-13 08:33:13'),
(1796, 1006, 'login > create', '114.122.23.35', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/130.0.6723.90 Mobile/15E148 Safari/604.1', 'Unknown', '2024-11-13 08:33:13', '2024-11-13 08:33:13'),
(1797, 1006, 'api > create', '114.122.23.35', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/130.0.6723.90 Mobile/15E148 Safari/604.1', 'Unknown', '2024-11-13 08:34:43', '2024-11-13 08:34:43'),
(1798, 1006, 'check-attendance > create', '114.122.23.35', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/130.0.6723.90 Mobile/15E148 Safari/604.1', 'Unknown', '2024-11-13 08:34:44', '2024-11-13 08:34:44'),
(1799, 1006, 'store-attendance-out > create', '114.122.23.35', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/130.0.6723.90 Mobile/15E148 Safari/604.1', 'Unknown', '2024-11-13 08:34:44', '2024-11-13 08:34:44'),
(1800, 1006, 'api > create', '114.122.23.35', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/130.0.6723.90 Mobile/15E148 Safari/604.1', 'Unknown', '2024-11-13 08:34:59', '2024-11-13 08:34:59'),
(1801, 1006, 'check-attendance > create', '114.122.23.35', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/130.0.6723.90 Mobile/15E148 Safari/604.1', 'Unknown', '2024-11-13 08:34:59', '2024-11-13 08:34:59'),
(1802, 1006, 'store-attendance-out > create', '114.122.23.35', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/130.0.6723.90 Mobile/15E148 Safari/604.1', 'Unknown', '2024-11-13 08:35:00', '2024-11-13 08:35:00'),
(1803, 1006, 'api > create', '114.122.23.35', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/130.0.6723.90 Mobile/15E148 Safari/604.1', 'Unknown', '2024-11-13 08:35:15', '2024-11-13 08:35:15'),
(1804, 1006, 'check-attendance > create', '114.122.23.35', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/130.0.6723.90 Mobile/15E148 Safari/604.1', 'Unknown', '2024-11-13 08:35:15', '2024-11-13 08:35:15'),
(1805, 1006, 'store-attendance-out > create', '114.122.23.35', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/130.0.6723.90 Mobile/15E148 Safari/604.1', 'Unknown', '2024-11-13 08:35:16', '2024-11-13 08:35:16'),
(1806, 1006, 'api > create', '114.122.23.35', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/130.0.6723.90 Mobile/15E148 Safari/604.1', 'Unknown', '2024-11-13 08:36:22', '2024-11-13 08:36:22'),
(1807, 1006, 'check-attendance > create', '114.122.23.35', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/130.0.6723.90 Mobile/15E148 Safari/604.1', 'Unknown', '2024-11-13 08:36:23', '2024-11-13 08:36:23'),
(1808, 1006, 'store-attendance-out > create', '114.122.23.35', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/130.0.6723.90 Mobile/15E148 Safari/604.1', 'Unknown', '2024-11-13 08:36:23', '2024-11-13 08:36:23'),
(1809, 1022, 'login', '114.5.144.107', 'Mozilla/5.0 (Linux;  11; CPH2239 Build/RP1A.200720.011; ) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/130.0.6723.107  Safari/537.36', 'Unknown', '2024-11-13 08:41:22', '2024-11-13 08:41:22'),
(1810, 1022, 'login > create', '114.5.144.107', 'Mozilla/5.0 (Linux;  11; CPH2239 Build/RP1A.200720.011; ) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/130.0.6723.107  Safari/537.36', 'Unknown', '2024-11-13 08:41:22', '2024-11-13 08:41:22'),
(1811, 1006, 'login', '114.10.81.200', 'Mozilla/5.0 (Linux;  14; V2144 Build/UP1A.231005.007; ) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/130.0.6723.107  Safari/537.36', 'Unknown', '2024-11-13 08:42:22', '2024-11-13 08:42:22'),
(1812, 1006, 'login > create', '114.10.81.200', 'Mozilla/5.0 (Linux;  14; V2144 Build/UP1A.231005.007; ) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/130.0.6723.107  Safari/537.36', 'Unknown', '2024-11-13 08:42:22', '2024-11-13 08:42:22'),
(1813, 1006, 'api > create', '114.10.81.200', 'Mozilla/5.0 (Linux;  14; V2144 Build/UP1A.231005.007; ) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/130.0.6723.107  Safari/537.36', 'Unknown', '2024-11-13 08:43:02', '2024-11-13 08:43:02'),
(1814, 1006, 'check-attendance > create', '114.10.81.200', 'Mozilla/5.0 (Linux;  14; V2144 Build/UP1A.231005.007; ) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/130.0.6723.107  Safari/537.36', 'Unknown', '2024-11-13 08:43:02', '2024-11-13 08:43:02'),
(1815, 1006, 'store-attendance-out > create', '114.10.81.200', 'Mozilla/5.0 (Linux;  14; V2144 Build/UP1A.231005.007; ) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/130.0.6723.107  Safari/537.36', 'Unknown', '2024-11-13 08:43:02', '2024-11-13 08:43:02'),
(1816, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 08:46:18', '2024-11-13 08:46:18'),
(1817, 1006, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 08:46:26', '2024-11-13 08:46:26'),
(1818, 1006, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 08:46:26', '2024-11-13 08:46:26'),
(1819, 1006, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 08:46:42', '2024-11-13 08:46:42'),
(1820, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 08:46:47', '2024-11-13 08:46:47'),
(1821, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 08:46:47', '2024-11-13 08:46:47'),
(1822, 1, 'pegawai > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 09:09:43', '2024-11-13 09:09:43'),
(1823, 1024, 'login', '182.253.242.119', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-13 09:12:25', '2024-11-13 09:12:25'),
(1824, 1024, 'login > create', '182.253.242.119', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-13 09:12:25', '2024-11-13 09:12:25'),
(1825, 1024, 'api > create', '182.253.242.119', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-13 09:14:10', '2024-11-13 09:14:10'),
(1826, 1024, 'check-attendance > create', '182.253.242.119', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-13 09:14:10', '2024-11-13 09:14:10'),
(1827, 1024, 'store-attendance > create', '182.253.242.119', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-13 09:14:11', '2024-11-13 09:14:11'),
(1828, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 09:17:18', '2024-11-13 09:17:18'),
(1829, 1006, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 09:17:25', '2024-11-13 09:17:25'),
(1830, 1006, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 09:17:25', '2024-11-13 09:17:25'),
(1831, 1024, 'api > create', '182.253.242.119', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-13 09:17:45', '2024-11-13 09:17:45'),
(1832, 1024, 'check-attendance > create', '182.253.242.119', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-13 09:17:45', '2024-11-13 09:17:45'),
(1833, 1024, 'store-attendance-out > create', '182.253.242.119', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-13 09:17:46', '2024-11-13 09:17:46'),
(1834, 1006, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 09:18:53', '2024-11-13 09:18:53'),
(1835, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 09:18:59', '2024-11-13 09:18:59'),
(1836, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-13 09:18:59', '2024-11-13 09:18:59'),
(1837, 1024, 'api > create', '182.253.242.119', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-13 09:23:11', '2024-11-13 09:23:11'),
(1838, 1024, 'check-attendance > create', '182.253.242.119', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-13 09:23:12', '2024-11-13 09:23:12'),
(1839, 1024, 'store-attendance-out > create', '182.253.242.119', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-13 09:23:12', '2024-11-13 09:23:12'),
(1840, 1020, 'api > create', '114.122.10.26', 'Mozilla/5.0 (Linux;  14; 2311DRK48G Build/UP1A.230905.011; ) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/130.0.6723.86  Safari/537.36', 'Unknown', '2024-11-13 09:31:59', '2024-11-13 09:31:59'),
(1841, 1020, 'check-attendance > create', '114.122.10.26', 'Mozilla/5.0 (Linux;  14; 2311DRK48G Build/UP1A.230905.011; ) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/130.0.6723.86  Safari/537.36', 'Unknown', '2024-11-13 09:31:59', '2024-11-13 09:31:59'),
(1842, 1020, 'store-attendance-out > create', '114.122.10.26', 'Mozilla/5.0 (Linux;  14; 2311DRK48G Build/UP1A.230905.011; ) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/130.0.6723.86  Safari/537.36', 'Unknown', '2024-11-13 09:32:00', '2024-11-13 09:32:00'),
(1843, 1006, 'api > create', '114.10.81.200', 'Mozilla/5.0 (Linux;  14; V2144 Build/UP1A.231005.007; ) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/130.0.6723.107  Safari/537.36', 'Unknown', '2024-11-13 09:36:37', '2024-11-13 09:36:37'),
(1844, 1006, 'check-attendance > create', '114.10.81.200', 'Mozilla/5.0 (Linux;  14; V2144 Build/UP1A.231005.007; ) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/130.0.6723.107  Safari/537.36', 'Unknown', '2024-11-13 09:36:37', '2024-11-13 09:36:37'),
(1845, 1006, 'store-attendance-out > create', '114.10.81.200', 'Mozilla/5.0 (Linux;  14; V2144 Build/UP1A.231005.007; ) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/130.0.6723.107  Safari/537.36', 'Unknown', '2024-11-13 09:36:38', '2024-11-13 09:36:38'),
(1846, 1006, 'api > create', '114.10.81.200', 'Mozilla/5.0 (Linux;  14; V2144 Build/UP1A.231005.007; ) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/130.0.6723.107  Safari/537.36', 'Unknown', '2024-11-13 09:58:09', '2024-11-13 09:58:09'),
(1847, 1006, 'check-attendance > create', '114.10.81.200', 'Mozilla/5.0 (Linux;  14; V2144 Build/UP1A.231005.007; ) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/130.0.6723.107  Safari/537.36', 'Unknown', '2024-11-13 09:58:10', '2024-11-13 09:58:10'),
(1848, 1006, 'store-attendance-out > create', '114.10.81.200', 'Mozilla/5.0 (Linux;  14; V2144 Build/UP1A.231005.007; ) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/130.0.6723.107  Safari/537.36', 'Unknown', '2024-11-13 09:58:10', '2024-11-13 09:58:10'),
(1849, 1020, 'login', '114.122.10.26', 'Mozilla/5.0 (Linux;  14; 2311DRK48G Build/UP1A.230905.011; ) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/130.0.6723.86  Safari/537.36', 'Unknown', '2024-11-14 00:43:59', '2024-11-14 00:43:59'),
(1850, 1020, 'login > create', '114.122.10.26', 'Mozilla/5.0 (Linux;  14; 2311DRK48G Build/UP1A.230905.011; ) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/130.0.6723.86  Safari/537.36', 'Unknown', '2024-11-14 00:43:59', '2024-11-14 00:43:59'),
(1851, 1020, 'api > create', '114.122.10.26', 'Mozilla/5.0 (Linux;  14; 2311DRK48G Build/UP1A.230905.011; ) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/130.0.6723.86  Safari/537.36', 'Unknown', '2024-11-14 00:45:26', '2024-11-14 00:45:26'),
(1852, 1020, 'check-attendance > create', '114.122.10.26', 'Mozilla/5.0 (Linux;  14; 2311DRK48G Build/UP1A.230905.011; ) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/130.0.6723.86  Safari/537.36', 'Unknown', '2024-11-14 00:45:27', '2024-11-14 00:45:27'),
(1853, 1020, 'store-attendance > create', '114.122.10.26', 'Mozilla/5.0 (Linux;  14; 2311DRK48G Build/UP1A.230905.011; ) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/130.0.6723.86  Safari/537.36', 'Unknown', '2024-11-14 00:45:27', '2024-11-14 00:45:27'),
(1854, 1006, 'login', '202.162.195.146', 'Mozilla/5.0 (iPhone; CPU iPhone OS 15_8_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.6.6 Mobile/15E148 Safari/604.1', 'Unknown', '2024-11-14 01:10:03', '2024-11-14 01:10:03'),
(1855, 1006, 'login > create', '202.162.195.146', 'Mozilla/5.0 (iPhone; CPU iPhone OS 15_8_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.6.6 Mobile/15E148 Safari/604.1', 'Unknown', '2024-11-14 01:10:03', '2024-11-14 01:10:03'),
(1856, 1006, 'api > create', '202.162.195.146', 'Mozilla/5.0 (iPhone; CPU iPhone OS 15_8_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.6.6 Mobile/15E148 Safari/604.1', 'Unknown', '2024-11-14 01:13:49', '2024-11-14 01:13:49'),
(1857, 1006, 'check-attendance > create', '202.162.195.146', 'Mozilla/5.0 (iPhone; CPU iPhone OS 15_8_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.6.6 Mobile/15E148 Safari/604.1', 'Unknown', '2024-11-14 01:13:50', '2024-11-14 01:13:50'),
(1858, 1006, 'store-attendance > create', '202.162.195.146', 'Mozilla/5.0 (iPhone; CPU iPhone OS 15_8_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.6.6 Mobile/15E148 Safari/604.1', 'Unknown', '2024-11-14 01:13:50', '2024-11-14 01:13:50'),
(1859, 1006, 'api > create', '202.162.195.146', 'Mozilla/5.0 (iPhone; CPU iPhone OS 15_8_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.6.6 Mobile/15E148 Safari/604.1', 'Unknown', '2024-11-14 01:15:53', '2024-11-14 01:15:53'),
(1860, 1006, 'check-attendance > create', '202.162.195.146', 'Mozilla/5.0 (iPhone; CPU iPhone OS 15_8_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.6.6 Mobile/15E148 Safari/604.1', 'Unknown', '2024-11-14 01:15:54', '2024-11-14 01:15:54'),
(1861, 1006, 'store-attendance-out > create', '202.162.195.146', 'Mozilla/5.0 (iPhone; CPU iPhone OS 15_8_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.6.6 Mobile/15E148 Safari/604.1', 'Unknown', '2024-11-14 01:15:55', '2024-11-14 01:15:55'),
(1862, 1006, 'login', '114.5.144.206', 'Mozilla/5.0 (Linux;  14; V2144 Build/UP1A.231005.007; ) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/130.0.6723.107  Safari/537.36', 'Unknown', '2024-11-14 01:17:24', '2024-11-14 01:17:24'),
(1863, 1006, 'login > create', '114.5.144.206', 'Mozilla/5.0 (Linux;  14; V2144 Build/UP1A.231005.007; ) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/130.0.6723.107  Safari/537.36', 'Unknown', '2024-11-14 01:17:24', '2024-11-14 01:17:24'),
(1864, 1006, 'login', '114.5.144.206', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Mobile Safari/537.36 OPR/85.0.0.0', 'Unknown', '2024-11-14 01:18:01', '2024-11-14 01:18:01'),
(1865, 1006, 'login > create', '114.5.144.206', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Mobile Safari/537.36 OPR/85.0.0.0', 'Unknown', '2024-11-14 01:18:01', '2024-11-14 01:18:01'),
(1866, 1006, 'login', '202.162.195.146', 'Mozilla/5.0 (iPhone; CPU iPhone OS 15_8_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.8 Mobile/15E148 Safari/604.1 OPT/5.1.1', 'Unknown', '2024-11-14 01:18:58', '2024-11-14 01:18:58'),
(1867, 1006, 'login > create', '202.162.195.146', 'Mozilla/5.0 (iPhone; CPU iPhone OS 15_8_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.8 Mobile/15E148 Safari/604.1 OPT/5.1.1', 'Unknown', '2024-11-14 01:18:58', '2024-11-14 01:18:58'),
(1868, 1006, 'api > create', '114.5.144.206', 'Mozilla/5.0 (Linux;  14; V2144 Build/UP1A.231005.007; ) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/130.0.6723.107  Safari/537.36', 'Unknown', '2024-11-14 01:32:24', '2024-11-14 01:32:24'),
(1869, 1006, 'check-attendance > create', '114.5.144.206', 'Mozilla/5.0 (Linux;  14; V2144 Build/UP1A.231005.007; ) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/130.0.6723.107  Safari/537.36', 'Unknown', '2024-11-14 01:32:25', '2024-11-14 01:32:25'),
(1870, 1006, 'store-attendance-out > create', '114.5.144.206', 'Mozilla/5.0 (Linux;  14; V2144 Build/UP1A.231005.007; ) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/130.0.6723.107  Safari/537.36', 'Unknown', '2024-11-14 01:32:25', '2024-11-14 01:32:25'),
(1871, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-14 01:33:06', '2024-11-14 01:33:06'),
(1872, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-14 01:33:06', '2024-11-14 01:33:06'),
(1873, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-14 03:22:02', '2024-11-14 03:22:02'),
(1874, 1006, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-14 03:22:21', '2024-11-14 03:22:21'),
(1875, 1006, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-14 03:22:21', '2024-11-14 03:22:21'),
(1876, 1006, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-14 03:22:27', '2024-11-14 03:22:27'),
(1877, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-14 03:23:35', '2024-11-14 03:23:35'),
(1878, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-14 03:23:35', '2024-11-14 03:23:35'),
(1879, 1, 'users > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-14 03:23:57', '2024-11-14 03:23:57'),
(1880, 1021, 'login', '182.3.103.212', 'Mozilla/5.0 (Linux; U; Android 12; in-id; RMX3630 Build/SP1A.210812.016) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.88 Mobile Safari/537.36 HeyTapBrowser/45.11.4.1', 'Unknown', '2024-11-14 08:28:57', '2024-11-14 08:28:57'),
(1881, 1021, 'login > create', '182.3.103.212', 'Mozilla/5.0 (Linux; U; Android 12; in-id; RMX3630 Build/SP1A.210812.016) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.88 Mobile Safari/537.36 HeyTapBrowser/45.11.4.1', 'Unknown', '2024-11-14 08:28:57', '2024-11-14 08:28:57'),
(1882, 1021, 'api > create', '182.3.103.212', 'Mozilla/5.0 (Linux; U; Android 12; in-id; RMX3630 Build/SP1A.210812.016) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.88 Mobile Safari/537.36 HeyTapBrowser/45.11.4.1', 'Unknown', '2024-11-14 08:31:16', '2024-11-14 08:31:16'),
(1883, 1021, 'check-attendance > create', '182.3.103.212', 'Mozilla/5.0 (Linux; U; Android 12; in-id; RMX3630 Build/SP1A.210812.016) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.88 Mobile Safari/537.36 HeyTapBrowser/45.11.4.1', 'Unknown', '2024-11-14 08:31:16', '2024-11-14 08:31:16'),
(1884, 1021, 'store-attendance > create', '182.3.103.212', 'Mozilla/5.0 (Linux; U; Android 12; in-id; RMX3630 Build/SP1A.210812.016) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.88 Mobile Safari/537.36 HeyTapBrowser/45.11.4.1', 'Unknown', '2024-11-14 08:31:17', '2024-11-14 08:31:17'),
(1885, 1, 'login', '114.5.144.131', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-14 08:44:17', '2024-11-14 08:44:17'),
(1886, 1, 'login > create', '114.5.144.131', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-14 08:44:17', '2024-11-14 08:44:17'),
(1887, 1020, 'login', '114.122.10.26', 'Mozilla/5.0 (Linux;  14; 2311DRK48G Build/UP1A.230905.011; ) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/130.0.6723.86  Safari/537.36', 'Unknown', '2024-11-14 12:01:33', '2024-11-14 12:01:33'),
(1888, 1020, 'login', '114.122.10.26', 'Mozilla/5.0 (Linux;  14; 2311DRK48G Build/UP1A.230905.011; ) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/130.0.6723.86  Safari/537.36', 'Unknown', '2024-11-14 12:01:34', '2024-11-14 12:01:34'),
(1889, 1020, 'api > create', '114.122.10.26', 'Mozilla/5.0 (Linux;  14; 2311DRK48G Build/UP1A.230905.011; ) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/130.0.6723.86  Safari/537.36', 'Unknown', '2024-11-14 12:02:10', '2024-11-14 12:02:10'),
(1890, 1020, 'check-attendance > create', '114.122.10.26', 'Mozilla/5.0 (Linux;  14; 2311DRK48G Build/UP1A.230905.011; ) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/130.0.6723.86  Safari/537.36', 'Unknown', '2024-11-14 12:02:10', '2024-11-14 12:02:10'),
(1891, 1020, 'store-attendance-out > create', '114.122.10.26', 'Mozilla/5.0 (Linux;  14; 2311DRK48G Build/UP1A.230905.011; ) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/130.0.6723.86  Safari/537.36', 'Unknown', '2024-11-14 12:02:11', '2024-11-14 12:02:11'),
(1892, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-15 01:01:15', '2024-11-15 01:01:15'),
(1893, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-15 01:01:15', '2024-11-15 01:01:15'),
(1894, 1020, 'login', '114.122.10.26', 'Mozilla/5.0 (Linux;  14; 2311DRK48G Build/UP1A.230905.011; ) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/130.0.6723.86  Safari/537.36', 'Unknown', '2024-11-15 01:06:56', '2024-11-15 01:06:56'),
(1895, 1020, 'login', '114.122.10.26', 'Mozilla/5.0 (Linux;  14; 2311DRK48G Build/UP1A.230905.011; ) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/130.0.6723.86  Safari/537.36', 'Unknown', '2024-11-15 01:06:57', '2024-11-15 01:06:57'),
(1896, 1020, 'api > create', '114.122.10.26', 'Mozilla/5.0 (Linux;  14; 2311DRK48G Build/UP1A.230905.011; ) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/130.0.6723.86  Safari/537.36', 'Unknown', '2024-11-15 01:07:34', '2024-11-15 01:07:34'),
(1897, 1020, 'check-attendance > create', '114.122.10.26', 'Mozilla/5.0 (Linux;  14; 2311DRK48G Build/UP1A.230905.011; ) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/130.0.6723.86  Safari/537.36', 'Unknown', '2024-11-15 01:07:34', '2024-11-15 01:07:34'),
(1898, 1020, 'store-attendance > create', '114.122.10.26', 'Mozilla/5.0 (Linux;  14; 2311DRK48G Build/UP1A.230905.011; ) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/130.0.6723.86  Safari/537.36', 'Unknown', '2024-11-15 01:07:35', '2024-11-15 01:07:35'),
(1899, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-15 01:20:00', '2024-11-15 01:20:00'),
(1900, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-15 03:19:54', '2024-11-15 03:19:54'),
(1901, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-15 03:19:54', '2024-11-15 03:19:54'),
(1902, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-15 03:57:50', '2024-11-15 03:57:50'),
(1903, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36 Edg/130.0.0.0', 'Unknown', '2024-11-15 04:00:43', '2024-11-15 04:00:43'),
(1904, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36 Edg/130.0.0.0', 'Unknown', '2024-11-15 04:00:43', '2024-11-15 04:00:43'),
(1905, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36 Edg/130.0.0.0', 'Unknown', '2024-11-15 04:00:47', '2024-11-15 04:00:47'),
(1906, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-15 07:41:33', '2024-11-15 07:41:33'),
(1907, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Unknown', '2024-11-15 07:41:33', '2024-11-15 07:41:33');
INSERT INTO `tb_log` (`id`, `user_id`, `user_action`, `ip_address`, `user_agent`, `user_location`, `created_at`, `updated_at`) VALUES
(1908, 1, 'login', '103.154.148.104', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Mobile Safari/537.36 OPR/85.0.0.0', 'Unknown', '2024-11-15 17:36:58', '2024-11-15 17:36:58'),
(1909, 1, 'login > create', '103.154.148.104', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Mobile Safari/537.36 OPR/85.0.0.0', 'Unknown', '2024-11-15 17:36:58', '2024-11-15 17:36:58'),
(1910, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-16 01:12:19', '2024-11-16 01:12:19'),
(1911, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-16 01:12:19', '2024-11-16 01:12:19'),
(1912, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-16 05:43:52', '2024-11-16 05:43:52'),
(1913, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-16 05:43:52', '2024-11-16 05:43:52'),
(1914, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-16 09:37:05', '2024-11-16 09:37:05'),
(1915, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-16 09:37:05', '2024-11-16 09:37:05'),
(1916, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 01:05:43', '2024-11-18 01:05:43'),
(1917, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 01:05:43', '2024-11-18 01:05:43'),
(1918, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 03:43:49', '2024-11-18 03:43:49'),
(1919, 1005, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 03:43:57', '2024-11-18 03:43:57'),
(1920, 1005, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 03:43:57', '2024-11-18 03:43:57'),
(1921, 1005, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 03:52:17', '2024-11-18 03:52:17'),
(1922, 1005, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 03:52:17', '2024-11-18 03:52:17'),
(1923, 1005, 'pegawai > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 03:53:42', '2024-11-18 03:53:42'),
(1924, 1005, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 03:56:33', '2024-11-18 03:56:33'),
(1925, 1026, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 03:56:43', '2024-11-18 03:56:43'),
(1926, 1026, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 03:56:43', '2024-11-18 03:56:43'),
(1927, 1026, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 04:00:11', '2024-11-18 04:00:11'),
(1928, 1006, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 04:00:17', '2024-11-18 04:00:17'),
(1929, 1006, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 04:00:17', '2024-11-18 04:00:17'),
(1930, 1006, 'check-attendance > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 04:00:35', '2024-11-18 04:00:35'),
(1931, 1006, 'store-attendance > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 04:00:36', '2024-11-18 04:00:36'),
(1932, 1006, 'api > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 04:04:23', '2024-11-18 04:04:23'),
(1933, 1006, 'check-attendance > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 04:04:24', '2024-11-18 04:04:24'),
(1934, 1006, 'store-attendance-out > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 04:04:25', '2024-11-18 04:04:25'),
(1935, 1005, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 04:05:30', '2024-11-18 04:05:30'),
(1936, 1005, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 04:06:41', '2024-11-18 04:06:41'),
(1937, 1005, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 04:06:41', '2024-11-18 04:06:41'),
(1938, 1006, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 04:11:14', '2024-11-18 04:11:14'),
(1939, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 04:11:33', '2024-11-18 04:11:33'),
(1940, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 04:11:33', '2024-11-18 04:11:33'),
(1941, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 04:13:32', '2024-11-18 04:13:32'),
(1945, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 04:14:08', '2024-11-18 04:14:08'),
(1946, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 04:14:08', '2024-11-18 04:14:08'),
(1947, 1, 'users > update', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 04:14:28', '2024-11-18 04:14:28'),
(1948, 1, 'roles > update', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 04:14:58', '2024-11-18 04:14:58'),
(1949, 1, 'roles > update', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 04:15:11', '2024-11-18 04:15:11'),
(1950, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 04:15:33', '2024-11-18 04:15:33'),
(1956, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 04:19:15', '2024-11-18 04:19:15'),
(1957, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 04:19:15', '2024-11-18 04:19:15'),
(1958, 1, 'users > delete', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 04:19:33', '2024-11-18 04:19:33'),
(1959, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 04:35:14', '2024-11-18 04:35:14'),
(1960, 1006, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 04:35:23', '2024-11-18 04:35:23'),
(1961, 1006, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 04:35:23', '2024-11-18 04:35:23'),
(1962, 1006, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 04:37:23', '2024-11-18 04:37:23'),
(1963, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 04:37:50', '2024-11-18 04:37:50'),
(1964, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 04:37:50', '2024-11-18 04:37:50'),
(1965, 1, 'pegawai > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 04:39:26', '2024-11-18 04:39:26'),
(1966, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 04:39:36', '2024-11-18 04:39:36'),
(1974, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 04:51:21', '2024-11-18 04:51:21'),
(1975, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 04:51:21', '2024-11-18 04:51:21'),
(1976, 1005, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 08:09:13', '2024-11-18 08:09:13'),
(1977, 1005, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 08:26:47', '2024-11-18 08:26:47'),
(1978, 1005, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-18 08:26:47', '2024-11-18 08:26:47'),
(1979, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-19 02:52:04', '2024-11-19 02:52:04'),
(1980, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-19 02:52:04', '2024-11-19 02:52:04'),
(1981, 1020, 'login', '2404:c0:1c30::5b3:71a', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-20 02:34:24', '2024-11-20 02:34:24'),
(1982, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-20 07:35:20', '2024-11-20 07:35:20'),
(1983, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-20 07:35:20', '2024-11-20 07:35:20'),
(1984, 1026, 'login', '103.179.248.228', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-21 01:06:01', '2024-11-21 01:06:01'),
(1985, 1026, 'login > create', '103.179.248.228', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-21 01:06:01', '2024-11-21 01:06:01'),
(1986, 1026, 'api > create', '103.179.248.228', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-21 01:12:54', '2024-11-21 01:12:54'),
(1987, 1026, 'check-attendance > create', '103.179.248.228', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-21 01:12:57', '2024-11-21 01:12:57'),
(1988, 1026, 'store-attendance > create', '103.179.248.228', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-21 01:12:57', '2024-11-21 01:12:57'),
(1989, 1026, 'api > create', '103.179.248.228', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-21 01:13:54', '2024-11-21 01:13:54'),
(1990, 1026, 'check-attendance > create', '103.179.248.228', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-21 01:13:56', '2024-11-21 01:13:56'),
(1991, 1026, 'store-attendance-out > create', '103.179.248.228', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-21 01:13:56', '2024-11-21 01:13:56'),
(1992, 1026, 'api > create', '103.179.248.228', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-21 01:15:36', '2024-11-21 01:15:36'),
(1993, 1026, 'check-attendance > create', '103.179.248.228', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-21 01:15:39', '2024-11-21 01:15:39'),
(1994, 1026, 'store-attendance-out > create', '103.179.248.228', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-21 01:15:39', '2024-11-21 01:15:39'),
(1995, 1005, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-11-21 01:54:01', '2024-11-21 01:54:01'),
(1996, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-21 03:12:46', '2024-11-21 03:12:46'),
(1997, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-21 03:12:46', '2024-11-21 03:12:46'),
(1998, 1026, 'login', '114.125.58.236', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-22 00:37:48', '2024-11-22 00:37:48'),
(1999, 1026, 'api > create', '114.125.58.236', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-22 00:40:12', '2024-11-22 00:40:12'),
(2000, 1026, 'check-attendance > create', '114.125.58.236', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-22 00:40:14', '2024-11-22 00:40:14'),
(2001, 1026, 'store-attendance > create', '114.125.58.236', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-22 00:40:14', '2024-11-22 00:40:14'),
(2002, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-22 07:42:02', '2024-11-22 07:42:02'),
(2003, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-22 07:42:02', '2024-11-22 07:42:02'),
(2004, 1005, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-11-22 07:48:13', '2024-11-22 07:48:13'),
(2005, 1005, 'pegawai > update', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-11-22 08:11:52', '2024-11-22 08:11:52'),
(2006, 1, 'placement > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-22 09:22:55', '2024-11-22 09:22:55'),
(2007, 1, 'placement > update', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-22 09:23:53', '2024-11-22 09:23:53'),
(2008, 1, 'placement > update', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-22 09:24:27', '2024-11-22 09:24:27'),
(2009, 1, 'jabatan > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-22 09:26:03', '2024-11-22 09:26:03'),
(2010, 1, 'pegawai > update', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-22 09:26:33', '2024-11-22 09:26:33'),
(2011, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-22 09:27:59', '2024-11-22 09:27:59'),
(2012, 1026, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-22 09:28:04', '2024-11-22 09:28:04'),
(2013, 1026, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-22 09:28:04', '2024-11-22 09:28:04'),
(2014, 1026, 'login', '114.125.22.50', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-22 09:29:45', '2024-11-22 09:29:45'),
(2015, 1026, 'check-attendance > create', '114.125.22.50', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-22 09:32:13', '2024-11-22 09:32:13'),
(2016, 1026, 'store-attendance-out > create', '114.125.22.50', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-22 09:32:17', '2024-11-22 09:32:17'),
(2017, 1026, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-22 09:33:16', '2024-11-22 09:33:16'),
(2018, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-22 09:33:22', '2024-11-22 09:33:22'),
(2019, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-22 09:33:22', '2024-11-22 09:33:22'),
(2020, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-22 09:46:19', '2024-11-22 09:46:19'),
(2021, 1006, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-22 09:46:24', '2024-11-22 09:46:24'),
(2022, 1006, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-22 09:46:24', '2024-11-22 09:46:24'),
(2023, 1006, 'api > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-22 09:46:57', '2024-11-22 09:46:57'),
(2024, 1006, 'check-attendance > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-22 09:46:57', '2024-11-22 09:46:57'),
(2025, 1006, 'store-attendance > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-22 09:46:57', '2024-11-22 09:46:57'),
(2026, 1006, 'api > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-22 09:52:37', '2024-11-22 09:52:37'),
(2027, 1006, 'check-attendance > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-22 09:52:38', '2024-11-22 09:52:38'),
(2028, 1006, 'store-attendance-out > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-22 09:52:39', '2024-11-22 09:52:39'),
(2029, 1006, 'api > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-22 09:56:02', '2024-11-22 09:56:02'),
(2030, 1006, 'check-attendance > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-22 09:56:02', '2024-11-22 09:56:02'),
(2031, 1006, 'store-attendance-out > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-22 09:56:04', '2024-11-22 09:56:04'),
(2032, 1026, 'login', '110.137.85.52', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-23 00:43:09', '2024-11-23 00:43:09'),
(2033, 1026, 'login > create', '110.137.85.52', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-23 00:43:09', '2024-11-23 00:43:09'),
(2034, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-23 01:04:48', '2024-11-23 01:04:48'),
(2035, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-23 01:04:48', '2024-11-23 01:04:48'),
(2036, 1005, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-11-23 01:39:18', '2024-11-23 01:39:18'),
(2037, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-23 01:55:33', '2024-11-23 01:55:33'),
(2038, 1006, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-23 01:55:39', '2024-11-23 01:55:39'),
(2039, 1006, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-23 01:55:39', '2024-11-23 01:55:39'),
(2040, 1006, 'api > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-23 01:55:55', '2024-11-23 01:55:55'),
(2041, 1006, 'check-attendance > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-23 01:55:56', '2024-11-23 01:55:56'),
(2042, 1006, 'store-attendance > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-23 01:55:56', '2024-11-23 01:55:56'),
(2043, 1006, 'api > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-23 01:56:17', '2024-11-23 01:56:17'),
(2044, 1006, 'check-attendance > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-23 01:56:18', '2024-11-23 01:56:18'),
(2045, 1006, 'store-attendance-out > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-23 01:56:18', '2024-11-23 01:56:18'),
(2046, 1006, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-23 02:02:00', '2024-11-23 02:02:00'),
(2047, 1006, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-23 03:45:00', '2024-11-23 03:45:00'),
(2048, 1006, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-23 03:45:00', '2024-11-23 03:45:00'),
(2049, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-23 06:29:41', '2024-11-23 06:29:41'),
(2050, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-23 06:29:41', '2024-11-23 06:29:41'),
(2051, 1005, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-11-23 06:30:59', '2024-11-23 06:30:59'),
(2052, 1020, 'login', '2404:c0:1c30::5d3:82cb', 'Mozilla/5.0 (Linux;  14; 2311DRK48G Build/UP1A.230905.011; ) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/131.0.6778.39  Safari/537.36', 'Unknown', '2024-11-23 08:16:19', '2024-11-23 08:16:19'),
(2053, 1020, 'login', '2404:c0:1c30::5d3:82cb', 'Mozilla/5.0 (Linux;  14; 2311DRK48G Build/UP1A.230905.011; ) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/131.0.6778.39  Safari/537.36', 'Unknown', '2024-11-23 08:16:20', '2024-11-23 08:16:20'),
(2054, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-25 01:54:41', '2024-11-25 01:54:41'),
(2055, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-25 01:54:41', '2024-11-25 01:54:41'),
(2056, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-26 15:56:19', '2024-11-26 15:56:19'),
(2057, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-26 15:56:19', '2024-11-26 15:56:19'),
(2058, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-26 16:08:34', '2024-11-26 16:08:34'),
(2059, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-26 16:12:23', '2024-11-26 16:12:23'),
(2060, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-26 16:12:23', '2024-11-26 16:12:23'),
(2061, 1, 'permissions > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-26 16:13:43', '2024-11-26 16:13:43'),
(2062, 1, 'roles > update', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-26 16:14:00', '2024-11-26 16:14:00'),
(2063, 1, 'roles > delete', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-26 16:15:27', '2024-11-26 16:15:27'),
(2064, 1, 'api > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-26 16:31:59', '2024-11-26 16:31:59'),
(2065, 1, 'check-attendance > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-26 16:31:59', '2024-11-26 16:31:59'),
(2066, 1, 'store-attendance > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-26 16:31:59', '2024-11-26 16:31:59'),
(2067, 1, 'api > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-26 16:35:18', '2024-11-26 16:35:18'),
(2068, 1, 'check-attendance > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-26 16:35:18', '2024-11-26 16:35:18'),
(2069, 1, 'store-attendance-out > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-26 16:35:18', '2024-11-26 16:35:18'),
(2070, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-28 09:22:15', '2024-11-28 09:22:15'),
(2071, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-28 09:22:15', '2024-11-28 09:22:15'),
(2072, 1, 'api > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-28 09:25:43', '2024-11-28 09:25:43'),
(2073, 1, 'check-attendance > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-28 09:25:43', '2024-11-28 09:25:43'),
(2074, 1, 'store-attendance > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-28 09:25:44', '2024-11-28 09:25:44'),
(2075, 1, 'api > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-28 09:28:08', '2024-11-28 09:28:08'),
(2076, 1, 'check-attendance > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-28 09:28:08', '2024-11-28 09:28:08'),
(2077, 1, 'store-attendance-out > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-28 09:28:08', '2024-11-28 09:28:08'),
(2078, 1, 'api > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-28 09:31:13', '2024-11-28 09:31:13'),
(2079, 1, 'check-attendance > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-28 09:31:13', '2024-11-28 09:31:13'),
(2080, 1, 'store-attendance-out > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-28 09:31:14', '2024-11-28 09:31:14'),
(2081, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-28 09:32:16', '2024-11-28 09:32:16'),
(2082, 1006, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-28 09:32:20', '2024-11-28 09:32:20'),
(2083, 1006, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-28 09:32:20', '2024-11-28 09:32:20'),
(2084, 1006, 'api > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-28 09:32:39', '2024-11-28 09:32:39'),
(2085, 1006, 'check-attendance > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-28 09:32:40', '2024-11-28 09:32:40'),
(2086, 1006, 'store-attendance-out > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-28 09:32:40', '2024-11-28 09:32:40'),
(2087, 1006, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-28 09:32:44', '2024-11-28 09:32:44'),
(2088, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-28 09:32:48', '2024-11-28 09:32:48'),
(2089, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-28 09:32:48', '2024-11-28 09:32:48'),
(2090, 1, 'upload-image > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-28 09:33:53', '2024-11-28 09:33:53'),
(2091, 1, 'upload-image > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-28 09:34:00', '2024-11-28 09:34:00'),
(2092, 1, 'upload-image > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-28 09:34:05', '2024-11-28 09:34:05'),
(2093, 1, 'dayoff > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-28 09:34:07', '2024-11-28 09:34:07'),
(2094, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-28 09:46:08', '2024-11-28 09:46:08'),
(2095, 1005, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-11-28 10:06:10', '2024-11-28 10:06:10'),
(2096, 1005, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-11-28 10:06:10', '2024-11-28 10:06:10'),
(2097, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-28 10:26:33', '2024-11-28 10:26:33'),
(2098, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-28 10:26:33', '2024-11-28 10:26:33'),
(2099, 1, 'users > delete', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-28 10:26:47', '2024-11-28 10:26:47'),
(2100, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-28 10:26:56', '2024-11-28 10:26:56'),
(2101, 1026, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-28 10:27:00', '2024-11-28 10:27:00'),
(2102, 1026, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-28 10:27:00', '2024-11-28 10:27:00'),
(2103, 1026, 'login', '114.125.43.9', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-28 10:33:52', '2024-11-28 10:33:52'),
(2104, 1026, 'login > create', '114.125.43.9', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-28 10:33:52', '2024-11-28 10:33:52'),
(2105, 1026, 'api > create', '114.125.43.217', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-28 12:32:02', '2024-11-28 12:32:02'),
(2106, 1026, 'check-attendance > create', '114.125.43.217', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-28 12:32:03', '2024-11-28 12:32:03'),
(2107, 1026, 'store-attendance > create', '114.125.43.217', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-11-28 12:32:03', '2024-11-28 12:32:03'),
(2108, 1026, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-28 13:23:16', '2024-11-28 13:23:16'),
(2109, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-28 13:23:20', '2024-11-28 13:23:20'),
(2110, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-28 13:23:20', '2024-11-28 13:23:20'),
(2111, 1, 'dayoff > update', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-28 13:34:07', '2024-11-28 13:34:07'),
(2112, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-28 16:26:10', '2024-11-28 16:26:10'),
(2113, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-28 16:26:10', '2024-11-28 16:26:10'),
(2114, 1005, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-11-28 16:37:45', '2024-11-28 16:37:45'),
(2115, 1005, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-11-28 16:37:45', '2024-11-28 16:37:45'),
(2116, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 11:02:15', '2024-11-29 11:02:15'),
(2117, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 11:02:15', '2024-11-29 11:02:15'),
(2118, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 11:04:03', '2024-11-29 11:04:03'),
(2119, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 11:04:23', '2024-11-29 11:04:23'),
(2120, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 11:04:23', '2024-11-29 11:04:23'),
(2121, 1, 'division > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 11:05:41', '2024-11-29 11:05:41'),
(2122, 1, 'division > update', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 11:05:54', '2024-11-29 11:05:54'),
(2123, 1, 'jabatan > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 11:06:05', '2024-11-29 11:06:05'),
(2124, 1, 'pegawai > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 11:06:48', '2024-11-29 11:06:48'),
(2125, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 11:07:02', '2024-11-29 11:07:02'),
(2126, 1028, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 11:07:06', '2024-11-29 11:07:06'),
(2127, 1028, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 11:07:06', '2024-11-29 11:07:06'),
(2128, 1028, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 11:07:13', '2024-11-29 11:07:13'),
(2129, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 11:07:17', '2024-11-29 11:07:17'),
(2130, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 11:07:17', '2024-11-29 11:07:17'),
(2131, 1, 'roles > update', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 11:07:44', '2024-11-29 11:07:44'),
(2132, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 11:07:46', '2024-11-29 11:07:46'),
(2133, 1028, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 11:07:52', '2024-11-29 11:07:52'),
(2134, 1028, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 11:07:52', '2024-11-29 11:07:52'),
(2135, 1028, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 13:34:01', '2024-11-29 13:34:01'),
(2136, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 13:55:20', '2024-11-29 13:55:20'),
(2137, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 13:55:20', '2024-11-29 13:55:20'),
(2138, 1, 'pegawai > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 13:56:28', '2024-11-29 13:56:28'),
(2139, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 13:56:46', '2024-11-29 13:56:46'),
(2140, 1029, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 13:56:49', '2024-11-29 13:56:49'),
(2141, 1029, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 13:56:49', '2024-11-29 13:56:49'),
(2142, 1029, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 13:57:19', '2024-11-29 13:57:19'),
(2143, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 13:57:25', '2024-11-29 13:57:25'),
(2144, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 13:57:25', '2024-11-29 13:57:25'),
(2145, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 13:58:58', '2024-11-29 13:58:58'),
(2146, 1029, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 13:59:03', '2024-11-29 13:59:03'),
(2147, 1029, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 13:59:03', '2024-11-29 13:59:03'),
(2148, 1029, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 14:09:47', '2024-11-29 14:09:47'),
(2149, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 14:09:52', '2024-11-29 14:09:52'),
(2150, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 14:09:52', '2024-11-29 14:09:52');
INSERT INTO `tb_log` (`id`, `user_id`, `user_action`, `ip_address`, `user_agent`, `user_location`, `created_at`, `updated_at`) VALUES
(2151, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 14:12:41', '2024-11-29 14:12:41'),
(2152, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 14:16:44', '2024-11-29 14:16:44'),
(2153, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 14:16:44', '2024-11-29 14:16:44'),
(2154, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 14:18:24', '2024-11-29 14:18:24'),
(2155, 1029, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 15:23:30', '2024-11-29 15:23:30'),
(2156, 1029, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 15:23:30', '2024-11-29 15:23:30'),
(2157, 1029, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 15:23:36', '2024-11-29 15:23:36'),
(2158, 1006, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 15:35:14', '2024-11-29 15:35:14'),
(2159, 1006, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 15:35:14', '2024-11-29 15:35:14'),
(2160, 1006, 'api > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 15:40:55', '2024-11-29 15:40:55'),
(2161, 1006, 'check-attendance > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 15:40:55', '2024-11-29 15:40:55'),
(2162, 1006, 'store-attendance-out > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 15:40:55', '2024-11-29 15:40:55'),
(2163, 1006, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 15:41:01', '2024-11-29 15:41:01'),
(2164, 1028, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 15:41:13', '2024-11-29 15:41:13'),
(2165, 1028, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 15:41:13', '2024-11-29 15:41:13'),
(2166, 1028, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 15:49:48', '2024-11-29 15:49:48'),
(2167, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 15:49:53', '2024-11-29 15:49:53'),
(2168, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 15:49:53', '2024-11-29 15:49:53'),
(2169, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 16:08:28', '2024-11-29 16:08:28'),
(2170, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 16:12:10', '2024-11-29 16:12:10'),
(2171, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-29 16:12:10', '2024-11-29 16:12:10'),
(2172, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-30 08:41:31', '2024-11-30 08:41:31'),
(2173, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-30 08:41:31', '2024-11-30 08:41:31'),
(2174, 1, 'dayoff > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-30 08:47:36', '2024-11-30 08:47:36'),
(2175, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-30 10:28:47', '2024-11-30 10:28:47'),
(2176, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-30 10:28:47', '2024-11-30 10:28:47'),
(2177, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-30 16:52:30', '2024-11-30 16:52:30'),
(2178, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-11-30 16:52:30', '2024-11-30 16:52:30'),
(2179, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-02 08:03:39', '2024-12-02 08:03:39'),
(2180, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-02 08:03:39', '2024-12-02 08:03:39'),
(2181, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-02 08:33:23', '2024-12-02 08:33:23'),
(2182, 1006, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-02 08:33:43', '2024-12-02 08:33:43'),
(2183, 1006, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-02 08:33:43', '2024-12-02 08:33:43'),
(2184, 1006, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-02 08:33:50', '2024-12-02 08:33:50'),
(2185, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-02 08:53:01', '2024-12-02 08:53:01'),
(2186, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-02 08:53:01', '2024-12-02 08:53:01'),
(2187, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-02 08:53:44', '2024-12-02 08:53:44'),
(2188, 1028, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-02 08:53:50', '2024-12-02 08:53:50'),
(2189, 1028, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-02 08:53:50', '2024-12-02 08:53:50'),
(2190, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-02 14:34:13', '2024-12-02 14:34:13'),
(2191, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-02 14:34:13', '2024-12-02 14:34:13'),
(2192, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-02 14:44:43', '2024-12-02 14:44:43'),
(2193, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-02 14:44:43', '2024-12-02 14:44:43'),
(2194, 1029, 'login', '140.213.36.144', 'Mozilla/5.0 (Linux; Android 11; SM-A507FN) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.141 Mobile Safari/537.36', 'Unknown', '2024-12-02 15:00:30', '2024-12-02 15:00:30'),
(2195, 1029, 'login > create', '140.213.36.144', 'Mozilla/5.0 (Linux; Android 11; SM-A507FN) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.141 Mobile Safari/537.36', 'Unknown', '2024-12-02 15:00:30', '2024-12-02 15:00:30'),
(2196, 1, 'login', '114.5.144.38', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36 OPR/86.0.0.0', 'Unknown', '2024-12-02 15:52:07', '2024-12-02 15:52:07'),
(2197, 1, 'login > create', '114.5.144.38', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36 OPR/86.0.0.0', 'Unknown', '2024-12-02 15:52:07', '2024-12-02 15:52:07'),
(2198, 1, 'logout', '114.5.144.38', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36 OPR/86.0.0.0', 'Unknown', '2024-12-02 15:52:25', '2024-12-02 15:52:25'),
(2199, 1029, 'login', '114.5.144.38', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36 OPR/86.0.0.0', 'Unknown', '2024-12-02 15:52:46', '2024-12-02 15:52:46'),
(2200, 1029, 'login > create', '114.5.144.38', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36 OPR/86.0.0.0', 'Unknown', '2024-12-02 15:52:46', '2024-12-02 15:52:46'),
(2201, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-02 15:53:06', '2024-12-02 15:53:06'),
(2202, 1029, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-02 15:53:14', '2024-12-02 15:53:14'),
(2203, 1029, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-02 15:53:14', '2024-12-02 15:53:14'),
(2204, 1029, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-02 16:27:08', '2024-12-02 16:27:08'),
(2205, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-02 16:27:12', '2024-12-02 16:27:12'),
(2206, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-02 16:27:12', '2024-12-02 16:27:12'),
(2207, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-03 08:10:47', '2024-12-03 08:10:47'),
(2208, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-03 08:10:47', '2024-12-03 08:10:47'),
(2209, 1029, 'login', '140.213.32.54', 'Mozilla/5.0 (Linux; Android 11; SM-A507FN) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.141 Mobile Safari/537.36', 'Unknown', '2024-12-03 16:18:00', '2024-12-03 16:18:00'),
(2210, 1029, 'login > create', '140.213.32.54', 'Mozilla/5.0 (Linux; Android 11; SM-A507FN) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.141 Mobile Safari/537.36', 'Unknown', '2024-12-03 16:18:00', '2024-12-03 16:18:00'),
(2211, 1029, 'login', '114.10.85.119', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36 OPR/86.0.0.0', 'Unknown', '2024-12-03 16:19:22', '2024-12-03 16:19:22'),
(2212, 1029, 'login > create', '114.10.85.119', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36 OPR/86.0.0.0', 'Unknown', '2024-12-03 16:19:22', '2024-12-03 16:19:22'),
(2213, 1029, 'login', '114.122.12.38', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_6_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.6 Mobile/15E148 Safari/604.1', 'Unknown', '2024-12-03 16:21:18', '2024-12-03 16:21:18'),
(2214, 1029, 'login > create', '114.122.12.38', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_6_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.6 Mobile/15E148 Safari/604.1', 'Unknown', '2024-12-03 16:21:18', '2024-12-03 16:21:18'),
(2215, 1029, 'login', '77.111.246.20', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Mobile Safari/537.36 OPR/84.0.0.0', 'Unknown', '2024-12-03 16:26:02', '2024-12-03 16:26:02'),
(2216, 1029, 'login > create', '77.111.246.20', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Mobile Safari/537.36 OPR/84.0.0.0', 'Unknown', '2024-12-03 16:26:02', '2024-12-03 16:26:02'),
(2217, 1029, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-03 16:29:28', '2024-12-03 16:29:28'),
(2218, 1029, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-03 16:29:28', '2024-12-03 16:29:28'),
(2219, 1029, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-03 16:34:17', '2024-12-03 16:34:17'),
(2220, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-03 16:34:23', '2024-12-03 16:34:23'),
(2221, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-03 16:34:23', '2024-12-03 16:34:23'),
(2222, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-03 17:01:25', '2024-12-03 17:01:25'),
(2223, 1028, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-03 17:01:34', '2024-12-03 17:01:34'),
(2224, 1028, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-03 17:01:34', '2024-12-03 17:01:34'),
(2225, 1028, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-03 17:04:02', '2024-12-03 17:04:02'),
(2226, 1028, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-04 08:01:11', '2024-12-04 08:01:11'),
(2227, 1028, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-04 08:01:11', '2024-12-04 08:01:11'),
(2228, 1028, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-04 08:11:43', '2024-12-04 08:11:43'),
(2229, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-04 08:11:47', '2024-12-04 08:11:47'),
(2230, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-04 08:11:47', '2024-12-04 08:11:47'),
(2231, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-04 08:14:56', '2024-12-04 08:14:56'),
(2232, 1028, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-04 08:19:33', '2024-12-04 08:19:33'),
(2233, 1028, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-04 08:19:34', '2024-12-04 08:19:34'),
(2234, 1028, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-04 08:21:13', '2024-12-04 08:21:13'),
(2235, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-04 08:21:19', '2024-12-04 08:21:19'),
(2236, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-04 08:21:19', '2024-12-04 08:21:19'),
(2237, 1029, 'login', '140.213.17.92', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Mobile Safari/537.36 OPR/84.0.0.0', 'Unknown', '2024-12-04 10:32:27', '2024-12-04 10:32:27'),
(2238, 1029, 'login > create', '140.213.17.92', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Mobile Safari/537.36 OPR/84.0.0.0', 'Unknown', '2024-12-04 10:32:27', '2024-12-04 10:32:27'),
(2239, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-04 11:37:33', '2024-12-04 11:37:33'),
(2240, 1028, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-04 11:37:40', '2024-12-04 11:37:40'),
(2241, 1028, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-04 11:37:40', '2024-12-04 11:37:40'),
(2242, 1028, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-04 13:52:05', '2024-12-04 13:52:05'),
(2243, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-04 13:52:09', '2024-12-04 13:52:09'),
(2244, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-04 13:52:09', '2024-12-04 13:52:09'),
(2245, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-04 14:54:13', '2024-12-04 14:54:13'),
(2246, 1028, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-04 14:58:17', '2024-12-04 14:58:17'),
(2247, 1028, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-04 14:58:17', '2024-12-04 14:58:17'),
(2248, 1028, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-04 15:00:25', '2024-12-04 15:00:25'),
(2249, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-04 15:00:30', '2024-12-04 15:00:30'),
(2250, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-04 15:00:30', '2024-12-04 15:00:30'),
(2251, 1029, 'login', '140.213.36.146', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Mobile Safari/537.36 OPR/84.0.0.0', 'Unknown', '2024-12-04 15:54:08', '2024-12-04 15:54:08'),
(2252, 1029, 'login > create', '140.213.36.146', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Mobile Safari/537.36 OPR/84.0.0.0', 'Unknown', '2024-12-04 15:54:08', '2024-12-04 15:54:08'),
(2253, 1029, 'login', '112.215.230.133', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Mobile Safari/537.36 OPR/84.0.0.0', 'Unknown', '2024-12-05 08:45:28', '2024-12-05 08:45:28'),
(2254, 1029, 'login > create', '112.215.230.133', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Mobile Safari/537.36 OPR/84.0.0.0', 'Unknown', '2024-12-05 08:45:28', '2024-12-05 08:45:28'),
(2255, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-05 09:32:21', '2024-12-05 09:32:21'),
(2256, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-05 09:32:21', '2024-12-05 09:32:21'),
(2257, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-05 09:43:47', '2024-12-05 09:43:47'),
(2258, 1028, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-05 09:43:55', '2024-12-05 09:43:55'),
(2259, 1028, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-05 09:43:55', '2024-12-05 09:43:55'),
(2260, 1028, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-05 09:44:53', '2024-12-05 09:44:53'),
(2261, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-05 09:44:57', '2024-12-05 09:44:57'),
(2262, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-05 09:44:57', '2024-12-05 09:44:57'),
(2263, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-05 09:45:43', '2024-12-05 09:45:43'),
(2264, 1028, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-05 09:45:51', '2024-12-05 09:45:51'),
(2265, 1028, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-05 09:45:51', '2024-12-05 09:45:51'),
(2266, 1028, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-05 09:46:17', '2024-12-05 09:46:17'),
(2267, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-05 09:46:22', '2024-12-05 09:46:22'),
(2268, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-05 09:46:22', '2024-12-05 09:46:22'),
(2269, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-05 09:58:52', '2024-12-05 09:58:52'),
(2270, 1028, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-05 09:59:02', '2024-12-05 09:59:02'),
(2271, 1028, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-05 09:59:02', '2024-12-05 09:59:02'),
(2272, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-05 13:01:47', '2024-12-05 13:01:47'),
(2273, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-05 13:01:47', '2024-12-05 13:01:47'),
(2274, 1029, 'login', '140.213.17.194', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Mobile Safari/537.36 OPR/84.0.0.0', 'Unknown', '2024-12-05 14:50:16', '2024-12-05 14:50:16'),
(2275, 1029, 'login > create', '140.213.17.194', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Mobile Safari/537.36 OPR/84.0.0.0', 'Unknown', '2024-12-05 14:50:16', '2024-12-05 14:50:16'),
(2276, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-06 08:05:58', '2024-12-06 08:05:58'),
(2277, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-06 08:05:58', '2024-12-06 08:05:58'),
(2278, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-06 11:05:41', '2024-12-06 11:05:41'),
(2279, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-06 11:55:44', '2024-12-06 11:55:44'),
(2280, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-06 11:55:44', '2024-12-06 11:55:44'),
(2281, 1029, 'login', '140.213.34.231', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Mobile Safari/537.36 OPR/84.0.0.0', 'Unknown', '2024-12-06 14:08:07', '2024-12-06 14:08:07'),
(2282, 1029, 'login > create', '140.213.34.231', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Mobile Safari/537.36 OPR/84.0.0.0', 'Unknown', '2024-12-06 14:08:07', '2024-12-06 14:08:07'),
(2283, 1, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-06 16:05:40', '2024-12-06 16:05:40'),
(2284, 1028, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-06 16:05:46', '2024-12-06 16:05:46'),
(2285, 1028, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-06 16:05:46', '2024-12-06 16:05:46'),
(2286, 1028, 'logout', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-06 16:06:04', '2024-12-06 16:06:04'),
(2287, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-06 16:06:10', '2024-12-06 16:06:10'),
(2288, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-06 16:06:10', '2024-12-06 16:06:10'),
(2289, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-07 08:05:00', '2024-12-07 08:05:00'),
(2290, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-07 08:05:00', '2024-12-07 08:05:00'),
(2291, 1, 'login', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-07 10:18:08', '2024-12-07 10:18:08'),
(2292, 1, 'login > create', '202.162.195.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-07 10:18:08', '2024-12-07 10:18:08'),
(2293, 1, 'login', '192.168.11.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 04:33:12', '2024-12-11 04:33:12'),
(2294, 1, 'login > create', '192.168.11.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 04:33:12', '2024-12-11 04:33:12'),
(2295, 1, 'login', '192.168.11.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 05:01:01', '2024-12-11 05:01:01'),
(2296, 1, 'login > create', '192.168.11.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 05:01:01', '2024-12-11 05:01:01'),
(2297, 1, 'login', '192.168.11.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 06:22:30', '2024-12-11 06:22:30'),
(2298, 1, 'login > create', '192.168.11.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 06:22:30', '2024-12-11 06:22:30'),
(2299, 1, 'login', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 06:44:29', '2024-12-11 06:44:29'),
(2300, 1, 'login > create', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 06:44:29', '2024-12-11 06:44:29'),
(2301, 1, 'jabatan > create', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 06:46:39', '2024-12-11 06:46:39'),
(2302, 1, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:31:47', '2024-12-11 08:31:47'),
(2303, 1028, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:34:44', '2024-12-11 08:34:44'),
(2304, 1028, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:34:44', '2024-12-11 08:34:44'),
(2305, 1028, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:35:54', '2024-12-11 08:35:54'),
(2306, 1028, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:36:13', '2024-12-11 08:36:13'),
(2307, 1028, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:36:13', '2024-12-11 08:36:13'),
(2308, 1028, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:37:29', '2024-12-11 08:37:29'),
(2309, 1006, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:37:37', '2024-12-11 08:37:37'),
(2310, 1006, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:37:37', '2024-12-11 08:37:37'),
(2311, 1006, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:37:46', '2024-12-11 08:37:46'),
(2312, 1029, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:38:05', '2024-12-11 08:38:05'),
(2313, 1029, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:38:05', '2024-12-11 08:38:05'),
(2314, 1029, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:39:06', '2024-12-11 08:39:06'),
(2315, 1, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:39:13', '2024-12-11 08:39:13'),
(2316, 1, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:39:13', '2024-12-11 08:39:13'),
(2317, 1, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:41:26', '2024-12-11 08:41:26'),
(2318, 1006, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:41:33', '2024-12-11 08:41:33'),
(2319, 1006, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:41:33', '2024-12-11 08:41:33'),
(2320, 1006, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:47:18', '2024-12-11 08:47:18'),
(2321, 1, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:47:28', '2024-12-11 08:47:28'),
(2322, 1, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:47:29', '2024-12-11 08:47:29'),
(2323, 1, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:47:40', '2024-12-11 08:47:40'),
(2324, 1, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:48:10', '2024-12-11 08:48:10'),
(2325, 1, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:48:12', '2024-12-11 08:48:12'),
(2326, 1, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:48:34', '2024-12-11 08:48:34'),
(2327, 1, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:48:41', '2024-12-11 08:48:41'),
(2328, 1, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:48:42', '2024-12-11 08:48:42'),
(2329, 1, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:48:58', '2024-12-11 08:48:58'),
(2330, 1, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:49:03', '2024-12-11 08:49:03'),
(2331, 1, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:49:08', '2024-12-11 08:49:08'),
(2332, 1, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:49:08', '2024-12-11 08:49:08'),
(2333, 1, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:50:10', '2024-12-11 08:50:10'),
(2334, 1, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:50:17', '2024-12-11 08:50:17'),
(2335, 1, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:50:17', '2024-12-11 08:50:17'),
(2336, 1, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:50:44', '2024-12-11 08:50:44'),
(2337, 1, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:50:49', '2024-12-11 08:50:49'),
(2338, 1, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:50:49', '2024-12-11 08:50:49'),
(2339, 1, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:51:10', '2024-12-11 08:51:10'),
(2340, 1, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:51:15', '2024-12-11 08:51:15'),
(2341, 1, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:51:15', '2024-12-11 08:51:15'),
(2342, 1, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:52:19', '2024-12-11 08:52:19'),
(2343, 1, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:52:23', '2024-12-11 08:52:23'),
(2344, 1, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 08:52:23', '2024-12-11 08:52:23'),
(2345, 1, 'dayoff > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 09:11:11', '2024-12-11 09:11:11'),
(2346, 1, 'dayoff > delete', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 09:11:22', '2024-12-11 09:11:22'),
(2347, 1, 'dayoff > update', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 09:13:06', '2024-12-11 09:13:06'),
(2348, 1, 'dayoff > update', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 09:13:13', '2024-12-11 09:13:13'),
(2349, 1, 'jabatan > update', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 09:13:33', '2024-12-11 09:13:33'),
(2350, 1, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 09:14:01', '2024-12-11 09:14:01'),
(2351, 1029, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 09:14:08', '2024-12-11 09:14:08'),
(2352, 1029, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 09:14:08', '2024-12-11 09:14:08'),
(2353, 1029, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 09:15:43', '2024-12-11 09:15:43'),
(2354, 1, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 09:27:34', '2024-12-11 09:27:34'),
(2355, 1, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 09:27:34', '2024-12-11 09:27:34'),
(2356, 1, 'pegawai > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 09:28:25', '2024-12-11 09:28:25'),
(2357, 1, 'pegawai > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 09:29:14', '2024-12-11 09:29:14'),
(2358, 1, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 09:29:58', '2024-12-11 09:29:58'),
(2359, 1031, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 09:30:05', '2024-12-11 09:30:05'),
(2360, 1031, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 09:30:05', '2024-12-11 09:30:05'),
(2361, 1031, 'login', '114.10.84.151', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36 OPR/86.0.0.0', 'Unknown', '2024-12-11 09:31:16', '2024-12-11 09:31:16'),
(2362, 1031, 'login > create', '114.10.84.151', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36 OPR/86.0.0.0', 'Unknown', '2024-12-11 09:31:16', '2024-12-11 09:31:16'),
(2363, 1031, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 09:32:03', '2024-12-11 09:32:03'),
(2364, 1031, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 09:32:31', '2024-12-11 09:32:31'),
(2365, 1031, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 09:32:31', '2024-12-11 09:32:31'),
(2366, 1031, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36 OPR/115.0.0.0', 'Unknown', '2024-12-11 09:33:39', '2024-12-11 09:33:39'),
(2367, 1031, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36 OPR/115.0.0.0', 'Unknown', '2024-12-11 09:33:39', '2024-12-11 09:33:39'),
(2368, 1031, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 09:36:39', '2024-12-11 09:36:39'),
(2369, 1, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 09:59:26', '2024-12-11 09:59:26'),
(2370, 1, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 09:59:26', '2024-12-11 09:59:26'),
(2371, 1, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 09:59:54', '2024-12-11 09:59:54'),
(2372, 1006, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 10:00:01', '2024-12-11 10:00:01'),
(2373, 1006, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-11 10:00:01', '2024-12-11 10:00:01'),
(2374, 1031, 'logout', '114.10.84.243', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36 OPR/86.0.0.0', 'Unknown', '2024-12-11 11:31:27', '2024-12-11 11:31:27'),
(2375, 1, 'login', '114.10.84.243', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36 OPR/86.0.0.0', 'Unknown', '2024-12-11 11:31:43', '2024-12-11 11:31:43'),
(2376, 1, 'login > create', '114.10.84.243', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36 OPR/86.0.0.0', 'Unknown', '2024-12-11 11:31:43', '2024-12-11 11:31:43'),
(2377, 1030, 'login', '114.122.10.158', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-12 01:11:00', '2024-12-12 01:11:00'),
(2378, 1030, 'login > create', '114.122.10.158', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-12 01:11:00', '2024-12-12 01:11:00'),
(2379, 1, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-12 01:31:51', '2024-12-12 01:31:51'),
(2380, 1, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-12 01:31:51', '2024-12-12 01:31:51'),
(2381, 1, 'api > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-12 01:57:13', '2024-12-12 01:57:13');
INSERT INTO `tb_log` (`id`, `user_id`, `user_action`, `ip_address`, `user_agent`, `user_location`, `created_at`, `updated_at`) VALUES
(2382, 1, 'check-attendance > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-12 01:57:13', '2024-12-12 01:57:13'),
(2383, 1, 'store-attendance > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-12 01:57:13', '2024-12-12 01:57:13'),
(2384, 1, 'api > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-12 01:57:47', '2024-12-12 01:57:47'),
(2385, 1, 'check-attendance > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-12 01:57:48', '2024-12-12 01:57:48'),
(2386, 1, 'store-attendance-out > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-12 01:57:48', '2024-12-12 01:57:48'),
(2387, 1, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-12 02:04:30', '2024-12-12 02:04:30'),
(2388, 1006, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-12 02:04:37', '2024-12-12 02:04:37'),
(2389, 1006, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-12 02:04:37', '2024-12-12 02:04:37'),
(2390, 1006, 'api > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-12 02:08:17', '2024-12-12 02:08:17'),
(2391, 1006, 'api > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-12 02:09:29', '2024-12-12 02:09:29'),
(2392, 1006, 'api > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-12 02:09:57', '2024-12-12 02:09:57'),
(2393, 1006, 'api > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-12 02:10:26', '2024-12-12 02:10:26'),
(2394, 1006, 'check-attendance > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-12 02:10:27', '2024-12-12 02:10:27'),
(2395, 1006, 'api > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-12 02:11:03', '2024-12-12 02:11:03'),
(2396, 1006, 'check-attendance > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-12 02:11:03', '2024-12-12 02:11:03'),
(2397, 1006, 'store-attendance-out > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-12 02:11:03', '2024-12-12 02:11:03'),
(2398, 1006, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-12 02:11:13', '2024-12-12 02:11:13'),
(2399, 1006, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-12 02:12:26', '2024-12-12 02:12:26'),
(2400, 1006, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-12 02:12:26', '2024-12-12 02:12:26'),
(2401, 1006, 'api > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-12 02:12:55', '2024-12-12 02:12:55'),
(2402, 1006, 'check-attendance > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-12 02:12:55', '2024-12-12 02:12:55'),
(2403, 1006, 'store-attendance-out > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-12 02:12:56', '2024-12-12 02:12:56'),
(2404, 1006, 'api > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-12 02:18:50', '2024-12-12 02:18:50'),
(2405, 1006, 'check-attendance > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-12 02:18:51', '2024-12-12 02:18:51'),
(2406, 1006, 'store-attendance-out > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-12 02:18:52', '2024-12-12 02:18:52'),
(2407, 1, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-12 02:19:46', '2024-12-12 02:19:46'),
(2408, 1, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-12 02:19:46', '2024-12-12 02:19:46'),
(2409, 1029, 'login', '140.213.17.94', 'Mozilla/5.0 (Linux; Android 11; SM-A507FN) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.141 Mobile Safari/537.36', 'Unknown', '2024-12-12 02:52:21', '2024-12-12 02:52:21'),
(2410, 1029, 'login > create', '140.213.17.94', 'Mozilla/5.0 (Linux; Android 11; SM-A507FN) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.141 Mobile Safari/537.36', 'Unknown', '2024-12-12 02:52:21', '2024-12-12 02:52:21'),
(2411, 1029, 'login', '140.213.17.94', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Mobile Safari/537.36 OPR/84.0.0.0', 'Unknown', '2024-12-12 02:55:47', '2024-12-12 02:55:47'),
(2412, 1029, 'generated::myemr0Sx0vHhyd70 > create', '140.213.17.94', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Mobile Safari/537.36 OPR/84.0.0.0', 'Unknown', '2024-12-12 02:55:47', '2024-12-12 02:55:47'),
(2413, 1029, 'generated::myemr0Sx0vHhyd70 > create', '140.213.17.94', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Mobile Safari/537.36 OPR/84.0.0.0', 'Unknown', '2024-12-12 02:55:55', '2024-12-12 02:55:55'),
(2414, 1006, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-12 04:30:50', '2024-12-12 04:30:50'),
(2415, 1006, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-12 04:30:50', '2024-12-12 04:30:50'),
(2416, 1006, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-12 04:31:08', '2024-12-12 04:31:08'),
(2417, 1, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-12 04:31:15', '2024-12-12 04:31:15'),
(2418, 1, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-12 04:31:15', '2024-12-12 04:31:15'),
(2419, 1029, 'login', '112.215.230.182', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Mobile Safari/537.36 OPR/84.0.0.0', 'Unknown', '2024-12-12 07:29:57', '2024-12-12 07:29:57'),
(2420, 1029, 'login > create', '112.215.230.182', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Mobile Safari/537.36 OPR/84.0.0.0', 'Unknown', '2024-12-12 07:29:57', '2024-12-12 07:29:57'),
(2421, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-12 07:41:09', '2024-12-12 07:41:09'),
(2422, 1, 'login > create', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-12 07:41:09', '2024-12-12 07:41:09'),
(2423, 1030, 'login', '114.122.11.161', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-12 09:31:54', '2024-12-12 09:31:54'),
(2424, 1, 'logout', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-12 10:06:40', '2024-12-12 10:06:40'),
(2425, 1030, 'login', '114.122.7.255', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-12 16:59:16', '2024-12-12 16:59:16'),
(2426, 1, 'login', '114.10.85.51', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36 OPR/86.0.0.0', 'Unknown', '2024-12-13 00:14:37', '2024-12-13 00:14:37'),
(2427, 1, 'generated::ZaWUeMmamQFkt8Oa > create', '114.10.85.51', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36 OPR/86.0.0.0', 'Unknown', '2024-12-13 00:14:37', '2024-12-13 00:14:37'),
(2428, 1030, 'login', '114.122.7.255', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-13 00:58:18', '2024-12-13 00:58:18'),
(2429, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-13 01:03:52', '2024-12-13 01:03:52'),
(2430, 1, 'generated::ZaWUeMmamQFkt8Oa > create', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-13 01:03:52', '2024-12-13 01:03:52'),
(2431, 1, 'dayoff > delete', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-13 01:04:08', '2024-12-13 01:04:08'),
(2432, 1, 'dayoff > delete', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-13 01:04:12', '2024-12-13 01:04:12'),
(2433, 1, 'placement > delete', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-13 01:04:27', '2024-12-13 01:04:27'),
(2434, 1030, 'login', '114.122.8.48', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-13 06:52:36', '2024-12-13 06:52:36'),
(2435, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-13 09:24:36', '2024-12-13 09:24:36'),
(2436, 1, 'generated::ZaWUeMmamQFkt8Oa > create', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-13 09:24:36', '2024-12-13 09:24:36'),
(2437, 1030, 'login', '114.122.9.32', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-14 00:52:55', '2024-12-14 00:52:55'),
(2438, 1, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-14 01:16:33', '2024-12-14 01:16:33'),
(2439, 1, 'generated::ZaWUeMmamQFkt8Oa > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-14 01:16:33', '2024-12-14 01:16:33'),
(2440, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-14 01:23:11', '2024-12-14 01:23:11'),
(2441, 1, 'generated::ZaWUeMmamQFkt8Oa > create', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-14 01:23:11', '2024-12-14 01:23:11'),
(2442, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-14 01:24:19', '2024-12-14 01:24:19'),
(2443, 1030, 'login', '114.122.9.32', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-14 07:07:37', '2024-12-14 07:07:37'),
(2444, 1031, 'login', '114.122.5.36', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-16 00:58:12', '2024-12-16 00:58:12'),
(2445, 1031, 'generated::ZaWUeMmamQFkt8Oa > create', '114.122.5.36', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-16 00:58:12', '2024-12-16 00:58:12'),
(2446, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 01:08:28', '2024-12-16 01:08:28'),
(2447, 1, 'roles > create', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 01:11:26', '2024-12-16 01:11:26'),
(2448, 1, 'pegawai > create', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 01:12:09', '2024-12-16 01:12:09'),
(2449, 1, 'logout', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 01:12:20', '2024-12-16 01:12:20'),
(2450, 1032, 'login', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 01:12:31', '2024-12-16 01:12:31'),
(2451, 1032, 'generated::ZaWUeMmamQFkt8Oa > create', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 01:12:31', '2024-12-16 01:12:31'),
(2452, 1032, 'logout', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 01:15:28', '2024-12-16 01:15:28'),
(2453, 1031, 'login', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 01:15:36', '2024-12-16 01:15:36'),
(2454, 1031, 'generated::ZaWUeMmamQFkt8Oa > create', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 01:15:36', '2024-12-16 01:15:36'),
(2455, 1031, 'logout', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 01:15:55', '2024-12-16 01:15:55'),
(2456, 1032, 'login', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 01:16:04', '2024-12-16 01:16:04'),
(2457, 1032, 'generated::ZaWUeMmamQFkt8Oa > create', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 01:16:04', '2024-12-16 01:16:04'),
(2458, 1030, 'login', '114.122.8.104', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-16 01:17:28', '2024-12-16 01:17:28'),
(2459, 1, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 01:17:49', '2024-12-16 01:17:49'),
(2460, 1, 'generated::ZaWUeMmamQFkt8Oa > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 01:17:49', '2024-12-16 01:17:49'),
(2461, 1, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 01:18:17', '2024-12-16 01:18:17'),
(2462, 1032, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 01:18:24', '2024-12-16 01:18:24'),
(2463, 1032, 'generated::ZaWUeMmamQFkt8Oa > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 01:18:24', '2024-12-16 01:18:24'),
(2464, 1032, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 01:22:47', '2024-12-16 01:22:47'),
(2465, 1032, 'logout', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 01:23:01', '2024-12-16 01:23:01'),
(2466, 1, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 01:23:17', '2024-12-16 01:23:17'),
(2467, 1, 'generated::ZaWUeMmamQFkt8Oa > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 01:23:17', '2024-12-16 01:23:17'),
(2468, 1, 'roles > update', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 01:24:42', '2024-12-16 01:24:42'),
(2469, 1, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 01:26:49', '2024-12-16 01:26:49'),
(2470, 1, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 01:27:08', '2024-12-16 01:27:08'),
(2471, 1, 'generated::ZaWUeMmamQFkt8Oa > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 01:27:08', '2024-12-16 01:27:08'),
(2472, 1, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 01:28:25', '2024-12-16 01:28:25'),
(2473, 1028, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 01:28:29', '2024-12-16 01:28:29'),
(2474, 1028, 'generated::ZaWUeMmamQFkt8Oa > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 01:28:29', '2024-12-16 01:28:29'),
(2475, 1028, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 01:29:10', '2024-12-16 01:29:10'),
(2476, 1, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 01:29:18', '2024-12-16 01:29:18'),
(2477, 1, 'generated::ZaWUeMmamQFkt8Oa > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 01:29:18', '2024-12-16 01:29:18'),
(2478, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 01:32:48', '2024-12-16 01:32:48'),
(2479, 1, 'generated::ZaWUeMmamQFkt8Oa > create', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 01:32:48', '2024-12-16 01:32:48'),
(2480, 1032, 'login', '192.168.11.235', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 03:20:20', '2024-12-16 03:20:20'),
(2481, 1032, 'generated::ZaWUeMmamQFkt8Oa > create', '192.168.11.235', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 03:20:20', '2024-12-16 03:20:20'),
(2482, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 03:21:55', '2024-12-16 03:21:55'),
(2483, 1, 'generated::ZaWUeMmamQFkt8Oa > create', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 03:21:55', '2024-12-16 03:21:55'),
(2484, 1, 'pegawai > create', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 03:26:12', '2024-12-16 03:26:12'),
(2485, 1, 'logout', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 03:26:18', '2024-12-16 03:26:18'),
(2486, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 03:26:40', '2024-12-16 03:26:40'),
(2487, 1, 'generated::ZaWUeMmamQFkt8Oa > create', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 03:26:40', '2024-12-16 03:26:40'),
(2488, 1, 'users > update', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 03:27:00', '2024-12-16 03:27:00'),
(2489, 1, 'pegawai > update', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 03:27:20', '2024-12-16 03:27:20'),
(2490, 1, 'logout', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 03:27:27', '2024-12-16 03:27:27'),
(2491, 1033, 'login', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 03:27:41', '2024-12-16 03:27:41'),
(2492, 1033, 'generated::ZaWUeMmamQFkt8Oa > create', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 03:27:41', '2024-12-16 03:27:41'),
(2493, 1033, 'login', '192.168.11.226', 'Mozilla/5.0 (Windows NT 6.1; rv:109.0) Gecko/20100101 Firefox/115.0', 'Unknown', '2024-12-16 03:31:40', '2024-12-16 03:31:40'),
(2494, 1033, 'generated::ZaWUeMmamQFkt8Oa > create', '192.168.11.226', 'Mozilla/5.0 (Windows NT 6.1; rv:109.0) Gecko/20100101 Firefox/115.0', 'Unknown', '2024-12-16 03:31:40', '2024-12-16 03:31:40'),
(2495, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 03:34:37', '2024-12-16 03:34:37'),
(2496, 1, 'generated::ZaWUeMmamQFkt8Oa > create', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 03:34:37', '2024-12-16 03:34:37'),
(2497, 1028, 'login', '114.5.144.238', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36 OPR/86.0.0.0', 'Unknown', '2024-12-16 03:55:41', '2024-12-16 03:55:41'),
(2498, 1028, 'generated::ZaWUeMmamQFkt8Oa > create', '114.5.144.238', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36 OPR/86.0.0.0', 'Unknown', '2024-12-16 03:55:41', '2024-12-16 03:55:41'),
(2499, 1028, 'logout', '114.5.144.238', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36 OPR/86.0.0.0', 'Unknown', '2024-12-16 03:56:42', '2024-12-16 03:56:42'),
(2500, 1, 'login', '114.5.144.238', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36 OPR/86.0.0.0', 'Unknown', '2024-12-16 03:56:48', '2024-12-16 03:56:48'),
(2501, 1, 'generated::ZaWUeMmamQFkt8Oa > create', '114.5.144.238', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36 OPR/86.0.0.0', 'Unknown', '2024-12-16 03:56:48', '2024-12-16 03:56:48'),
(2502, 1033, 'login', '192.168.11.226', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 04:03:57', '2024-12-16 04:03:57'),
(2503, 1033, 'generated::ZaWUeMmamQFkt8Oa > create', '192.168.11.226', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 04:03:57', '2024-12-16 04:03:57'),
(2504, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 06:49:56', '2024-12-16 06:49:56'),
(2505, 1, 'generated::ZaWUeMmamQFkt8Oa > create', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 06:49:56', '2024-12-16 06:49:56'),
(2506, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 06:50:15', '2024-12-16 06:50:15'),
(2507, 1, 'generated::ZaWUeMmamQFkt8Oa > create', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 06:50:15', '2024-12-16 06:50:15'),
(2508, 1029, 'login', '112.215.230.26', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Mobile Safari/537.36 OPR/84.0.0.0', 'Unknown', '2024-12-16 08:42:51', '2024-12-16 08:42:51'),
(2509, 1029, 'generated::ZaWUeMmamQFkt8Oa > create', '112.215.230.26', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Mobile Safari/537.36 OPR/84.0.0.0', 'Unknown', '2024-12-16 08:42:51', '2024-12-16 08:42:51'),
(2510, 1029, 'generated::ZaWUeMmamQFkt8Oa > create', '112.215.230.26', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Mobile Safari/537.36 OPR/84.0.0.0', 'Unknown', '2024-12-16 08:42:59', '2024-12-16 08:42:59'),
(2511, 1033, 'login', '192.168.11.226', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 09:54:45', '2024-12-16 09:54:45'),
(2512, 1033, 'generated::ZaWUeMmamQFkt8Oa > create', '192.168.11.226', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-12-16 09:54:45', '2024-12-16 09:54:45'),
(2513, 1031, 'login', '114.122.23.92', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-17 00:53:39', '2024-12-17 00:53:39'),
(2514, 1031, 'generated::ZaWUeMmamQFkt8Oa > create', '114.122.23.92', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-17 00:53:39', '2024-12-17 00:53:39'),
(2515, 1030, 'login', '114.122.8.124', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-17 01:04:27', '2024-12-17 01:04:27'),
(2516, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-17 01:18:01', '2024-12-17 01:18:01'),
(2517, 1, 'generated::ZaWUeMmamQFkt8Oa > create', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-17 01:18:01', '2024-12-17 01:18:01'),
(2518, 1032, 'login', '192.168.11.235', 'Mozilla/5.0 (Windows NT 6.1; rv:107.0) Gecko/20100101 Firefox/107.0', 'Unknown', '2024-12-17 02:23:47', '2024-12-17 02:23:47'),
(2519, 1032, 'generated::ZaWUeMmamQFkt8Oa > create', '192.168.11.235', 'Mozilla/5.0 (Windows NT 6.1; rv:107.0) Gecko/20100101 Firefox/107.0', 'Unknown', '2024-12-17 02:23:47', '2024-12-17 02:23:47'),
(2520, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-17 05:08:55', '2024-12-17 05:08:55'),
(2521, 1, 'generated::ZaWUeMmamQFkt8Oa > create', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-17 05:08:55', '2024-12-17 05:08:55'),
(2522, 1, 'logout', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-17 06:37:02', '2024-12-17 06:37:02'),
(2523, 1028, 'login', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-17 06:37:18', '2024-12-17 06:37:18'),
(2524, 1028, 'generated::ZaWUeMmamQFkt8Oa > create', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-17 06:37:18', '2024-12-17 06:37:18'),
(2525, 1028, 'logout', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-17 06:37:25', '2024-12-17 06:37:25'),
(2526, 1031, 'login', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-17 06:37:31', '2024-12-17 06:37:31'),
(2527, 1031, 'generated::ZaWUeMmamQFkt8Oa > create', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-17 06:37:31', '2024-12-17 06:37:31'),
(2528, 1031, 'logout', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-17 06:37:46', '2024-12-17 06:37:46'),
(2529, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-17 06:37:53', '2024-12-17 06:37:53'),
(2530, 1, 'generated::ZaWUeMmamQFkt8Oa > create', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-17 06:37:53', '2024-12-17 06:37:53'),
(2531, 1, 'logout', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-17 06:43:33', '2024-12-17 06:43:33'),
(2532, 1031, 'login', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-17 06:43:39', '2024-12-17 06:43:39'),
(2533, 1031, 'generated::1CDIxWC3i5Ligyqn > create', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-17 06:43:39', '2024-12-17 06:43:39'),
(2534, 1031, 'logout', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-17 06:43:55', '2024-12-17 06:43:55'),
(2535, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-17 06:44:00', '2024-12-17 06:44:00'),
(2536, 1, 'generated::1CDIxWC3i5Ligyqn > create', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-17 06:44:00', '2024-12-17 06:44:00'),
(2537, 1032, 'login', '192.168.11.235', 'Mozilla/5.0 (Windows NT 6.1; rv:107.0) Gecko/20100101 Firefox/107.0', 'Unknown', '2024-12-17 09:03:28', '2024-12-17 09:03:28'),
(2538, 1032, 'generated::1CDIxWC3i5Ligyqn > create', '192.168.11.235', 'Mozilla/5.0 (Windows NT 6.1; rv:107.0) Gecko/20100101 Firefox/107.0', 'Unknown', '2024-12-17 09:03:28', '2024-12-17 09:03:28'),
(2539, 1032, 'generated::1CDIxWC3i5Ligyqn > create', '192.168.11.235', 'Mozilla/5.0 (Windows NT 6.1; rv:107.0) Gecko/20100101 Firefox/107.0', 'Unknown', '2024-12-17 09:03:32', '2024-12-17 09:03:32'),
(2540, 1033, 'login', '192.168.11.226', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-12-17 09:05:28', '2024-12-17 09:05:28'),
(2541, 1033, 'generated::1CDIxWC3i5Ligyqn > create', '192.168.11.226', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-12-17 09:05:28', '2024-12-17 09:05:28'),
(2542, 1032, 'profile > update', '192.168.11.235', 'Mozilla/5.0 (Windows NT 6.1; rv:107.0) Gecko/20100101 Firefox/107.0', 'Unknown', '2024-12-17 09:16:20', '2024-12-17 09:16:20'),
(2543, 1031, 'login', '114.122.4.212', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-18 00:56:53', '2024-12-18 00:56:53'),
(2544, 1031, 'generated::1CDIxWC3i5Ligyqn > create', '114.122.4.212', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-18 00:56:53', '2024-12-18 00:56:53'),
(2545, 1031, 'generated::1CDIxWC3i5Ligyqn > create', '114.122.4.212', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-18 00:57:02', '2024-12-18 00:57:02'),
(2546, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-18 01:16:26', '2024-12-18 01:16:26'),
(2547, 1, 'generated::1CDIxWC3i5Ligyqn > create', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-18 01:16:26', '2024-12-18 01:16:26'),
(2548, 1030, 'login', '114.122.20.121', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-18 01:21:13', '2024-12-18 01:21:13'),
(2549, 1032, 'login', '192.168.11.235', 'Mozilla/5.0 (Windows NT 6.1; rv:107.0) Gecko/20100101 Firefox/107.0', 'Unknown', '2024-12-18 02:10:56', '2024-12-18 02:10:56'),
(2550, 1032, 'generated::KAtKunNodGeftXyr > create', '192.168.11.235', 'Mozilla/5.0 (Windows NT 6.1; rv:107.0) Gecko/20100101 Firefox/107.0', 'Unknown', '2024-12-18 02:10:56', '2024-12-18 02:10:56'),
(2551, 1029, 'login', '112.215.230.42', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Mobile Safari/537.36 OPR/84.0.0.0', 'Unknown', '2024-12-18 03:53:10', '2024-12-18 03:53:10'),
(2552, 1029, 'generated::KAtKunNodGeftXyr > create', '112.215.230.42', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Mobile Safari/537.36 OPR/84.0.0.0', 'Unknown', '2024-12-18 03:53:10', '2024-12-18 03:53:10'),
(2553, 1033, 'login', '192.168.11.226', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-12-18 04:06:17', '2024-12-18 04:06:17'),
(2554, 1033, 'generated::KAtKunNodGeftXyr > create', '192.168.11.226', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-12-18 04:06:17', '2024-12-18 04:06:17'),
(2555, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-18 04:29:21', '2024-12-18 04:29:21'),
(2556, 1, 'generated::KAtKunNodGeftXyr > create', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-18 04:29:21', '2024-12-18 04:29:21'),
(2557, 1031, 'login', '114.122.4.216', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-18 07:09:41', '2024-12-18 07:09:41'),
(2558, 1031, 'generated::KAtKunNodGeftXyr > create', '114.122.4.216', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-18 07:09:41', '2024-12-18 07:09:41'),
(2559, 1031, 'generated::KAtKunNodGeftXyr > create', '114.122.4.216', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-18 07:09:51', '2024-12-18 07:09:51'),
(2560, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-18 07:12:53', '2024-12-18 07:12:53'),
(2561, 1, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-18 07:15:58', '2024-12-18 07:15:58'),
(2562, 1, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-18 07:15:58', '2024-12-18 07:15:58'),
(2563, 1033, 'login', '192.168.11.226', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-12-18 08:44:46', '2024-12-18 08:44:46'),
(2564, 1033, 'login > create', '192.168.11.226', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-12-18 08:44:46', '2024-12-18 08:44:46'),
(2565, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-19 00:59:38', '2024-12-19 00:59:38'),
(2566, 1031, 'login', '114.122.12.73', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-19 01:18:39', '2024-12-19 01:18:39'),
(2567, 1031, 'login > create', '114.122.12.73', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-19 01:18:39', '2024-12-19 01:18:39'),
(2568, 1031, 'login > create', '114.122.12.73', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-19 01:18:47', '2024-12-19 01:18:47'),
(2569, 1030, 'login', '114.122.8.104', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-19 01:19:12', '2024-12-19 01:19:12'),
(2570, 1030, 'login', '114.122.8.124', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-19 01:19:13', '2024-12-19 01:19:13'),
(2571, 1032, 'login', '192.168.11.235', 'Mozilla/5.0 (Windows NT 6.1; rv:107.0) Gecko/20100101 Firefox/107.0', 'Unknown', '2024-12-19 02:47:28', '2024-12-19 02:47:28'),
(2572, 1032, 'login > create', '192.168.11.235', 'Mozilla/5.0 (Windows NT 6.1; rv:107.0) Gecko/20100101 Firefox/107.0', 'Unknown', '2024-12-19 02:47:28', '2024-12-19 02:47:28'),
(2573, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-19 04:40:46', '2024-12-19 04:40:46'),
(2574, 1029, 'login', '140.213.34.5', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Mobile Safari/537.36 OPR/84.0.0.0', 'Unknown', '2024-12-19 07:18:08', '2024-12-19 07:18:08'),
(2575, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-19 07:29:05', '2024-12-19 07:29:05'),
(2576, 1031, 'login', '114.122.12.172', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-19 08:44:08', '2024-12-19 08:44:08'),
(2577, 1031, 'login > create', '114.122.12.172', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-19 08:44:08', '2024-12-19 08:44:08'),
(2578, 1031, 'login > create', '114.122.12.172', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-19 08:44:13', '2024-12-19 08:44:13'),
(2579, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-20 01:02:56', '2024-12-20 01:02:56'),
(2580, 1031, 'login', '114.122.12.127', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-20 01:09:37', '2024-12-20 01:09:37'),
(2581, 1031, 'login > create', '114.122.12.127', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-20 01:09:37', '2024-12-20 01:09:37'),
(2582, 1031, 'login > create', '114.122.12.127', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-20 01:09:40', '2024-12-20 01:09:40'),
(2583, 1030, 'login', '114.122.9.56', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-20 01:13:50', '2024-12-20 01:13:50'),
(2584, 1033, 'login', '192.168.11.226', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-12-20 02:03:54', '2024-12-20 02:03:54'),
(2585, 1033, 'login > create', '192.168.11.226', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-12-20 02:03:54', '2024-12-20 02:03:54'),
(2586, 1032, 'login', '192.168.11.235', 'Mozilla/5.0 (Windows NT 6.1; rv:107.0) Gecko/20100101 Firefox/107.0', 'Unknown', '2024-12-20 04:06:46', '2024-12-20 04:06:46'),
(2587, 1032, 'login > create', '192.168.11.235', 'Mozilla/5.0 (Windows NT 6.1; rv:107.0) Gecko/20100101 Firefox/107.0', 'Unknown', '2024-12-20 04:06:46', '2024-12-20 04:06:46'),
(2588, 1, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-20 07:28:47', '2024-12-20 07:28:47'),
(2589, 1, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-20 07:28:47', '2024-12-20 07:28:47'),
(2590, 1030, 'login', '114.122.8.44', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-21 00:56:01', '2024-12-21 00:56:01'),
(2591, 1030, 'login', '114.122.8.124', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-21 00:56:03', '2024-12-21 00:56:03'),
(2592, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-21 01:11:53', '2024-12-21 01:11:53'),
(2593, 1031, 'login', '114.122.22.249', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-21 02:57:29', '2024-12-21 02:57:29'),
(2594, 1031, 'login > create', '114.122.22.249', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-21 02:57:29', '2024-12-21 02:57:29'),
(2595, 1031, 'login > create', '114.122.22.249', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-21 02:57:33', '2024-12-21 02:57:33'),
(2596, 1029, 'login', '112.215.149.49', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Mobile Safari/537.36 OPR/84.0.0.0', 'Unknown', '2024-12-21 04:13:13', '2024-12-21 04:13:13'),
(2597, 1033, 'login', '192.168.11.226', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-12-21 05:48:09', '2024-12-21 05:48:09'),
(2598, 1033, 'login > create', '192.168.11.226', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-12-21 05:48:09', '2024-12-21 05:48:09'),
(2599, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-21 07:27:35', '2024-12-21 07:27:35'),
(2600, 1030, 'login', '114.122.7.255', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-21 08:08:33', '2024-12-21 08:08:33'),
(2601, 1032, 'login', '192.168.11.235', 'Mozilla/5.0 (Windows NT 6.1; rv:109.0) Gecko/20100101 Firefox/115.0', 'Unknown', '2024-12-21 08:55:38', '2024-12-21 08:55:38'),
(2602, 1032, 'login > create', '192.168.11.235', 'Mozilla/5.0 (Windows NT 6.1; rv:109.0) Gecko/20100101 Firefox/115.0', 'Unknown', '2024-12-21 08:55:38', '2024-12-21 08:55:38'),
(2603, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-23 01:04:24', '2024-12-23 01:04:24'),
(2604, 1030, 'login', '114.122.7.255', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-23 01:12:00', '2024-12-23 01:12:00'),
(2605, 1, 'logout', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-23 01:46:29', '2024-12-23 01:46:29'),
(2606, 1030, 'login', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-23 01:46:40', '2024-12-23 01:46:40'),
(2607, 1030, 'login > create', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-23 01:46:40', '2024-12-23 01:46:40');
INSERT INTO `tb_log` (`id`, `user_id`, `user_action`, `ip_address`, `user_agent`, `user_location`, `created_at`, `updated_at`) VALUES
(2608, 1030, 'logout', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-23 01:46:58', '2024-12-23 01:46:58'),
(2609, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-23 01:47:06', '2024-12-23 01:47:06'),
(2610, 1, 'login > create', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-23 01:47:06', '2024-12-23 01:47:06'),
(2611, 1032, 'login', '192.168.11.235', 'Mozilla/5.0 (Windows NT 6.1; rv:107.0) Gecko/20100101 Firefox/107.0', 'Unknown', '2024-12-23 02:43:03', '2024-12-23 02:43:03'),
(2612, 1032, 'login > create', '192.168.11.235', 'Mozilla/5.0 (Windows NT 6.1; rv:107.0) Gecko/20100101 Firefox/107.0', 'Unknown', '2024-12-23 02:43:03', '2024-12-23 02:43:03'),
(2613, 1031, 'login', '114.122.12.81', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-23 02:54:26', '2024-12-23 02:54:26'),
(2614, 1031, 'login > create', '114.122.12.81', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-23 02:54:26', '2024-12-23 02:54:26'),
(2615, 1031, 'login > create', '114.122.12.81', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-23 02:54:31', '2024-12-23 02:54:31'),
(2616, 1, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-23 02:56:41', '2024-12-23 02:56:41'),
(2617, 1, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-23 02:56:41', '2024-12-23 02:56:41'),
(2618, 1033, 'login', '192.168.11.226', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-12-23 06:46:22', '2024-12-23 06:46:22'),
(2619, 1033, 'login > create', '192.168.11.226', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-12-23 06:46:22', '2024-12-23 06:46:22'),
(2620, 1030, 'login', '114.122.7.255', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-24 01:06:00', '2024-12-24 01:06:00'),
(2621, 1030, 'login > create', '114.122.7.255', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-24 01:06:00', '2024-12-24 01:06:00'),
(2622, 1030, 'login > create', '114.122.7.255', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-24 01:06:08', '2024-12-24 01:06:08'),
(2623, 1030, 'logout', '114.122.7.255', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-24 01:06:27', '2024-12-24 01:06:27'),
(2624, 1030, 'login', '114.122.7.255', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-24 01:06:33', '2024-12-24 01:06:33'),
(2625, 1030, 'login > create', '114.122.7.255', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-24 01:06:33', '2024-12-24 01:06:33'),
(2626, 1030, 'logout', '114.122.7.255', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-24 01:07:37', '2024-12-24 01:07:37'),
(2627, 1030, 'login', '114.122.7.255', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-24 01:07:53', '2024-12-24 01:07:53'),
(2628, 1030, 'login > create', '114.122.7.255', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-24 01:07:53', '2024-12-24 01:07:53'),
(2629, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-24 01:13:33', '2024-12-24 01:13:33'),
(2630, 1, 'login > create', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-24 01:13:33', '2024-12-24 01:13:33'),
(2631, 1031, 'login', '114.122.9.190', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-24 01:20:45', '2024-12-24 01:20:45'),
(2632, 1031, 'login > create', '114.122.9.190', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-24 01:20:45', '2024-12-24 01:20:45'),
(2633, 1031, 'login > create', '114.122.9.190', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-24 01:20:49', '2024-12-24 01:20:49'),
(2634, 1030, 'login', '114.122.7.255', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-24 03:33:54', '2024-12-24 03:33:54'),
(2635, 1029, 'login', '140.213.36.249', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Mobile Safari/537.36 OPR/84.0.0.0', 'Unknown', '2024-12-24 05:05:41', '2024-12-24 05:05:41'),
(2636, 1032, 'login', '192.168.11.235', 'Mozilla/5.0 (Windows NT 6.1; rv:107.0) Gecko/20100101 Firefox/107.0', 'Unknown', '2024-12-24 06:51:47', '2024-12-24 06:51:47'),
(2637, 1032, 'login > create', '192.168.11.235', 'Mozilla/5.0 (Windows NT 6.1; rv:107.0) Gecko/20100101 Firefox/107.0', 'Unknown', '2024-12-24 06:51:47', '2024-12-24 06:51:47'),
(2638, 1033, 'login', '192.168.11.226', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-12-24 07:15:13', '2024-12-24 07:15:13'),
(2639, 1033, 'login > create', '192.168.11.226', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-12-24 07:15:13', '2024-12-24 07:15:13'),
(2640, 1033, 'login', '192.168.11.226', 'Mozilla/5.0 (Windows NT 6.1; rv:109.0) Gecko/20100101 Firefox/115.0', 'Unknown', '2024-12-24 07:21:47', '2024-12-24 07:21:47'),
(2641, 1033, 'login > create', '192.168.11.226', 'Mozilla/5.0 (Windows NT 6.1; rv:109.0) Gecko/20100101 Firefox/115.0', 'Unknown', '2024-12-24 07:21:47', '2024-12-24 07:21:47'),
(2642, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-24 07:22:18', '2024-12-24 07:22:18'),
(2643, 1, 'login > create', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-24 07:22:18', '2024-12-24 07:22:18'),
(2644, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-26 00:57:55', '2024-12-26 00:57:55'),
(2645, 1030, 'login', '114.122.7.255', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-26 01:09:40', '2024-12-26 01:09:40'),
(2646, 1031, 'login', '114.122.22.3', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-26 01:35:05', '2024-12-26 01:35:05'),
(2647, 1031, 'login > create', '114.122.22.3', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-26 01:35:05', '2024-12-26 01:35:05'),
(2648, 1031, 'login > create', '114.122.22.3', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-26 01:35:10', '2024-12-26 01:35:10'),
(2649, 1033, 'login', '192.168.11.226', 'Mozilla/5.0 (Windows NT 6.1; rv:109.0) Gecko/20100101 Firefox/115.0', 'Unknown', '2024-12-26 04:28:54', '2024-12-26 04:28:54'),
(2650, 1033, 'login > create', '192.168.11.226', 'Mozilla/5.0 (Windows NT 6.1; rv:109.0) Gecko/20100101 Firefox/115.0', 'Unknown', '2024-12-26 04:28:54', '2024-12-26 04:28:54'),
(2651, 1032, 'login', '192.168.11.235', 'Mozilla/5.0 (Windows NT 6.1; rv:107.0) Gecko/20100101 Firefox/107.0', 'Unknown', '2024-12-26 04:31:21', '2024-12-26 04:31:21'),
(2652, 1032, 'login > create', '192.168.11.235', 'Mozilla/5.0 (Windows NT 6.1; rv:107.0) Gecko/20100101 Firefox/107.0', 'Unknown', '2024-12-26 04:31:21', '2024-12-26 04:31:21'),
(2653, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-26 06:07:13', '2024-12-26 06:07:13'),
(2654, 1030, 'login', '114.122.7.255', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-26 07:36:31', '2024-12-26 07:36:31'),
(2655, 1, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-26 08:26:51', '2024-12-26 08:26:51'),
(2656, 1, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-26 08:26:51', '2024-12-26 08:26:51'),
(2657, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-26 08:29:36', '2024-12-26 08:29:36'),
(2658, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-27 00:58:03', '2024-12-27 00:58:03'),
(2659, 1030, 'login', '114.122.7.255', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-27 01:24:27', '2024-12-27 01:24:27'),
(2660, 1, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-27 01:28:01', '2024-12-27 01:28:01'),
(2661, 1, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-27 01:28:01', '2024-12-27 01:28:01'),
(2662, 1026, 'login', '112.215.245.55', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-27 01:35:52', '2024-12-27 01:35:52'),
(2663, 1026, 'login > create', '112.215.245.55', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-27 01:35:52', '2024-12-27 01:35:52'),
(2664, 1031, 'login', '114.122.21.200', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-27 01:40:10', '2024-12-27 01:40:10'),
(2665, 1031, 'login > create', '114.122.21.200', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-27 01:40:10', '2024-12-27 01:40:10'),
(2666, 1031, 'login > create', '114.122.21.200', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-27 01:40:13', '2024-12-27 01:40:13'),
(2667, 1026, 'api > create', '112.215.245.55', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-27 01:43:49', '2024-12-27 01:43:49'),
(2668, 1026, 'api > create', '112.215.245.55', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-27 01:43:49', '2024-12-27 01:43:49'),
(2669, 1026, 'api > create', '112.215.245.55', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-27 01:43:49', '2024-12-27 01:43:49'),
(2670, 1026, 'check-attendance > create', '112.215.245.55', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-27 01:43:50', '2024-12-27 01:43:50'),
(2671, 1026, 'check-attendance > create', '112.215.245.55', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-27 01:44:07', '2024-12-27 01:44:07'),
(2672, 1026, 'check-attendance > create', '112.215.245.55', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-27 01:44:07', '2024-12-27 01:44:07'),
(2673, 1026, 'store-attendance > create', '112.215.245.55', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-27 01:44:07', '2024-12-27 01:44:07'),
(2674, 1026, 'store-attendance > create', '112.215.245.55', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-27 01:44:14', '2024-12-27 01:44:14'),
(2675, 1026, 'store-attendance > create', '112.215.245.55', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-27 01:44:15', '2024-12-27 01:44:15'),
(2676, 1026, 'api > create', '112.215.245.55', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-27 01:45:33', '2024-12-27 01:45:33'),
(2677, 1026, 'check-attendance > create', '112.215.245.55', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-27 01:45:34', '2024-12-27 01:45:34'),
(2678, 1026, 'api > create', '112.215.245.55', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-27 01:45:35', '2024-12-27 01:45:35'),
(2679, 1026, 'store-attendance-out > create', '112.215.245.55', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-27 01:45:38', '2024-12-27 01:45:38'),
(2680, 1026, 'check-attendance > create', '112.215.245.55', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-27 01:45:39', '2024-12-27 01:45:39'),
(2681, 1026, 'store-attendance-out > create', '112.215.245.55', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-27 01:45:41', '2024-12-27 01:45:41'),
(2682, 1005, 'login', '192.168.11.167', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-12-27 01:56:14', '2024-12-27 01:56:14'),
(2683, 1005, 'login > create', '192.168.11.167', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-12-27 01:56:14', '2024-12-27 01:56:14'),
(2684, 1, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-27 02:04:02', '2024-12-27 02:04:02'),
(2685, 1006, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-27 02:04:08', '2024-12-27 02:04:08'),
(2686, 1006, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-27 02:04:08', '2024-12-27 02:04:08'),
(2687, 1006, 'api > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-27 02:04:42', '2024-12-27 02:04:42'),
(2688, 1006, 'check-attendance > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-27 02:04:43', '2024-12-27 02:04:43'),
(2689, 1006, 'store-attendance > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-27 02:04:43', '2024-12-27 02:04:43'),
(2690, 1006, 'api > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-27 02:05:25', '2024-12-27 02:05:25'),
(2691, 1006, 'check-attendance > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-27 02:05:25', '2024-12-27 02:05:25'),
(2692, 1006, 'store-attendance-out > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-27 02:05:25', '2024-12-27 02:05:25'),
(2693, 1006, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-27 02:06:42', '2024-12-27 02:06:42'),
(2694, 1029, 'login', '140.213.36.2', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Mobile Safari/537.36 OPR/84.0.0.0', 'Unknown', '2024-12-27 03:02:35', '2024-12-27 03:02:35'),
(2695, 1033, 'login', '192.168.11.226', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-12-27 03:12:59', '2024-12-27 03:12:59'),
(2696, 1033, 'login > create', '192.168.11.226', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-12-27 03:12:59', '2024-12-27 03:12:59'),
(2697, 1032, 'login', '192.168.11.235', 'Mozilla/5.0 (Windows NT 6.1; rv:107.0) Gecko/20100101 Firefox/107.0', 'Unknown', '2024-12-27 04:20:09', '2024-12-27 04:20:09'),
(2698, 1032, 'login > create', '192.168.11.235', 'Mozilla/5.0 (Windows NT 6.1; rv:107.0) Gecko/20100101 Firefox/107.0', 'Unknown', '2024-12-27 04:20:09', '2024-12-27 04:20:09'),
(2699, 1032, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-27 07:09:23', '2024-12-27 07:09:23'),
(2700, 1032, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2024-12-27 07:09:23', '2024-12-27 07:09:23'),
(2701, 1032, 'login', '192.168.11.235', 'Mozilla/5.0 (Windows NT 6.1; rv:107.0) Gecko/20100101 Firefox/107.0', 'Unknown', '2024-12-27 07:13:46', '2024-12-27 07:13:46'),
(2702, 1032, 'login > create', '192.168.11.235', 'Mozilla/5.0 (Windows NT 6.1; rv:107.0) Gecko/20100101 Firefox/107.0', 'Unknown', '2024-12-27 07:13:46', '2024-12-27 07:13:46'),
(2703, 1032, 'login > create', '192.168.11.235', 'Mozilla/5.0 (Windows NT 6.1; rv:107.0) Gecko/20100101 Firefox/107.0', 'Unknown', '2024-12-27 07:13:59', '2024-12-27 07:13:59'),
(2704, 1031, 'login', '114.122.21.220', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-27 07:53:27', '2024-12-27 07:53:27'),
(2705, 1031, 'login > create', '114.122.21.220', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-27 07:53:27', '2024-12-27 07:53:27'),
(2706, 1031, 'login > create', '114.122.21.220', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-27 07:53:34', '2024-12-27 07:53:34'),
(2707, 1030, 'login', '114.122.7.255', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-27 09:21:48', '2024-12-27 09:21:48'),
(2708, 1026, 'login', '112.215.239.4', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-27 10:18:15', '2024-12-27 10:18:15'),
(2709, 1026, 'api > create', '112.215.239.4', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-27 10:20:28', '2024-12-27 10:20:28'),
(2710, 1026, 'check-attendance > create', '112.215.239.4', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-27 10:20:43', '2024-12-27 10:20:43'),
(2711, 1026, 'api > create', '112.215.239.4', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-27 10:20:43', '2024-12-27 10:20:43'),
(2712, 1026, 'store-attendance-out > create', '112.215.239.4', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-27 10:20:56', '2024-12-27 10:20:56'),
(2713, 1026, 'check-attendance > create', '112.215.239.4', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-27 10:20:56', '2024-12-27 10:20:56'),
(2714, 1026, 'login', '112.215.174.234', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-28 00:55:13', '2024-12-28 00:55:13'),
(2715, 1026, 'api > create', '112.215.174.234', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-28 00:57:55', '2024-12-28 00:57:55'),
(2716, 1026, 'api > create', '112.215.174.234', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-28 00:57:55', '2024-12-28 00:57:55'),
(2717, 1026, 'check-attendance > create', '112.215.174.234', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-28 00:58:02', '2024-12-28 00:58:02'),
(2718, 1026, 'check-attendance > create', '112.215.174.234', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-28 00:58:02', '2024-12-28 00:58:02'),
(2719, 1026, 'store-attendance > create', '112.215.174.234', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-28 00:58:11', '2024-12-28 00:58:11'),
(2720, 1026, 'store-attendance > create', '112.215.174.234', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-28 00:58:11', '2024-12-28 00:58:11'),
(2721, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-28 01:02:02', '2024-12-28 01:02:02'),
(2722, 1, 'login > create', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-28 01:02:02', '2024-12-28 01:02:02'),
(2723, 1033, 'login', '192.168.11.226', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-12-28 01:45:47', '2024-12-28 01:45:47'),
(2724, 1033, 'login > create', '192.168.11.226', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-12-28 01:45:47', '2024-12-28 01:45:47'),
(2725, 1030, 'login', '114.122.7.255', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-28 02:17:55', '2024-12-28 02:17:55'),
(2726, 1031, 'login', '114.122.14.170', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-28 03:21:28', '2024-12-28 03:21:28'),
(2727, 1031, 'login > create', '114.122.14.170', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-28 03:21:28', '2024-12-28 03:21:28'),
(2728, 1031, 'login > create', '114.122.14.170', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-28 03:21:29', '2024-12-28 03:21:29'),
(2729, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-28 03:44:33', '2024-12-28 03:44:33'),
(2730, 1, 'login > create', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-28 03:44:33', '2024-12-28 03:44:33'),
(2731, 1030, 'login', '114.122.7.255', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-28 06:28:17', '2024-12-28 06:28:17'),
(2732, 1032, 'login', '192.168.11.235', 'Mozilla/5.0 (Windows NT 6.1; rv:109.0) Gecko/20100101 Firefox/115.0', 'Unknown', '2024-12-28 06:49:00', '2024-12-28 06:49:00'),
(2733, 1032, 'login > create', '192.168.11.235', 'Mozilla/5.0 (Windows NT 6.1; rv:109.0) Gecko/20100101 Firefox/115.0', 'Unknown', '2024-12-28 06:49:00', '2024-12-28 06:49:00'),
(2734, 1026, 'login', '140.213.149.238', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-28 10:11:37', '2024-12-28 10:11:37'),
(2735, 1026, 'api > create', '140.213.149.238', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-28 10:14:51', '2024-12-28 10:14:51'),
(2736, 1026, 'check-attendance > create', '140.213.149.238', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-28 10:15:01', '2024-12-28 10:15:01'),
(2737, 1026, 'api > create', '140.213.149.238', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-28 10:15:02', '2024-12-28 10:15:02'),
(2738, 1026, 'check-attendance > create', '140.213.149.238', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-28 10:15:10', '2024-12-28 10:15:10'),
(2739, 1026, 'store-attendance-out > create', '140.213.149.238', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-28 10:15:10', '2024-12-28 10:15:10'),
(2740, 1026, 'store-attendance-out > create', '140.213.149.238', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-28 10:15:14', '2024-12-28 10:15:14'),
(2741, 1030, 'login', '114.122.7.255', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-28 13:21:29', '2024-12-28 13:21:29'),
(2742, 1030, 'login', '114.122.7.255', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-30 01:02:50', '2024-12-30 01:02:50'),
(2743, 1026, 'login', '140.213.158.254', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-30 01:06:47', '2024-12-30 01:06:47'),
(2744, 1026, 'api > create', '140.213.158.254', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-30 01:09:40', '2024-12-30 01:09:40'),
(2745, 1026, 'check-attendance > create', '140.213.158.254', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-30 01:09:49', '2024-12-30 01:09:49'),
(2746, 1026, 'api > create', '140.213.158.254', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-30 01:09:49', '2024-12-30 01:09:49'),
(2747, 1026, 'store-attendance > create', '140.213.158.254', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-30 01:09:57', '2024-12-30 01:09:57'),
(2748, 1026, 'check-attendance > create', '140.213.158.254', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-30 01:09:57', '2024-12-30 01:09:57'),
(2749, 1026, 'store-attendance-out > create', '140.213.158.254', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-30 01:10:06', '2024-12-30 01:10:06'),
(2750, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-30 02:00:54', '2024-12-30 02:00:54'),
(2751, 1, 'login > create', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-30 02:00:54', '2024-12-30 02:00:54'),
(2752, 1031, 'login', '114.122.15.16', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-30 02:13:12', '2024-12-30 02:13:12'),
(2753, 1031, 'login > create', '114.122.15.16', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-30 02:13:12', '2024-12-30 02:13:12'),
(2754, 1031, 'login > create', '114.122.15.16', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-30 02:13:20', '2024-12-30 02:13:20'),
(2755, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-30 06:05:12', '2024-12-30 06:05:12'),
(2756, 1032, 'login', '192.168.11.235', 'Mozilla/5.0 (Windows NT 6.1; rv:107.0) Gecko/20100101 Firefox/107.0', 'Unknown', '2024-12-30 06:53:09', '2024-12-30 06:53:09'),
(2757, 1032, 'login > create', '192.168.11.235', 'Mozilla/5.0 (Windows NT 6.1; rv:107.0) Gecko/20100101 Firefox/107.0', 'Unknown', '2024-12-30 06:53:09', '2024-12-30 06:53:09'),
(2758, 1005, 'login', '192.168.11.167', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-12-30 07:01:26', '2024-12-30 07:01:26'),
(2759, 1005, 'login > create', '192.168.11.167', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-12-30 07:01:26', '2024-12-30 07:01:26'),
(2760, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-30 08:45:55', '2024-12-30 08:45:55'),
(2761, 1033, 'login', '192.168.11.226', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-12-30 08:48:34', '2024-12-30 08:48:34'),
(2762, 1033, 'login > create', '192.168.11.226', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2024-12-30 08:48:34', '2024-12-30 08:48:34'),
(2763, 1026, 'login', '112.215.175.66', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-30 10:16:25', '2024-12-30 10:16:25'),
(2764, 1026, 'login', '112.215.175.66', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-30 10:19:45', '2024-12-30 10:19:45'),
(2765, 1026, 'login > create', '112.215.175.66', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-30 10:19:45', '2024-12-30 10:19:45'),
(2766, 1026, 'api > create', '112.215.175.66', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-30 10:23:35', '2024-12-30 10:23:35'),
(2767, 1026, 'api > create', '112.215.175.66', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-30 10:23:35', '2024-12-30 10:23:35'),
(2768, 1026, 'api > create', '112.215.175.66', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-30 10:23:35', '2024-12-30 10:23:35'),
(2769, 1026, 'check-attendance > create', '112.215.175.66', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-30 10:23:49', '2024-12-30 10:23:49'),
(2770, 1026, 'check-attendance > create', '112.215.175.66', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-30 10:23:49', '2024-12-30 10:23:49'),
(2771, 1026, 'check-attendance > create', '112.215.175.66', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-30 10:23:49', '2024-12-30 10:23:49'),
(2772, 1026, 'store-attendance-out > create', '112.215.175.66', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-30 10:23:50', '2024-12-30 10:23:50'),
(2773, 1026, 'store-attendance-out > create', '112.215.175.66', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-30 10:23:50', '2024-12-30 10:23:50'),
(2774, 1026, 'store-attendance-out > create', '112.215.175.66', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-30 10:23:50', '2024-12-30 10:23:50'),
(2775, 1026, 'login', '112.215.245.209', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-31 00:49:31', '2024-12-31 00:49:31'),
(2776, 1026, 'login', '112.215.245.209', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-31 00:50:59', '2024-12-31 00:50:59'),
(2777, 1026, 'api > create', '112.215.245.209', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-31 00:52:38', '2024-12-31 00:52:38'),
(2778, 1026, 'check-attendance > create', '112.215.245.209', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-31 00:52:39', '2024-12-31 00:52:39'),
(2779, 1026, 'store-attendance > create', '112.215.245.209', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-31 00:52:46', '2024-12-31 00:52:46'),
(2780, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-31 01:10:37', '2024-12-31 01:10:37'),
(2781, 1031, 'login', '114.122.20.219', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-31 02:16:08', '2024-12-31 02:16:08'),
(2782, 1031, 'login > create', '114.122.20.219', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-31 02:16:08', '2024-12-31 02:16:08'),
(2783, 1031, 'login > create', '114.122.20.219', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-31 02:16:20', '2024-12-31 02:16:20'),
(2784, 1030, 'login', '114.122.7.255', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-31 02:32:15', '2024-12-31 02:32:15'),
(2785, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2024-12-31 04:51:53', '2024-12-31 04:51:53'),
(2786, 1032, 'login', '192.168.11.235', 'Mozilla/5.0 (Windows NT 6.1; rv:107.0) Gecko/20100101 Firefox/107.0', 'Unknown', '2024-12-31 05:57:07', '2024-12-31 05:57:07'),
(2787, 1032, 'login > create', '192.168.11.235', 'Mozilla/5.0 (Windows NT 6.1; rv:107.0) Gecko/20100101 Firefox/107.0', 'Unknown', '2024-12-31 05:57:07', '2024-12-31 05:57:07'),
(2788, 1026, 'login', '112.215.245.43', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-31 10:18:35', '2024-12-31 10:18:35'),
(2789, 1026, 'login', '112.215.245.43', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-31 10:18:35', '2024-12-31 10:18:35'),
(2790, 1026, 'api > create', '112.215.245.43', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-31 10:20:06', '2024-12-31 10:20:06'),
(2791, 1026, 'check-attendance > create', '112.215.245.43', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-31 10:20:10', '2024-12-31 10:20:10'),
(2792, 1026, 'store-attendance-out > create', '112.215.245.43', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2024-12-31 10:20:12', '2024-12-31 10:20:12'),
(2793, 1030, 'login', '114.122.7.255', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-01 12:39:48', '2025-01-01 12:39:48'),
(2794, 1026, 'login', '140.213.148.104', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2025-01-02 00:42:33', '2025-01-02 00:42:33'),
(2795, 1026, 'api > create', '140.213.148.104', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2025-01-02 00:44:11', '2025-01-02 00:44:11'),
(2796, 1026, 'check-attendance > create', '140.213.148.104', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2025-01-02 00:44:15', '2025-01-02 00:44:15'),
(2797, 1026, 'store-attendance > create', '140.213.148.104', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2025-01-02 00:44:19', '2025-01-02 00:44:19'),
(2798, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-02 01:11:16', '2025-01-02 01:11:16'),
(2799, 1030, 'login', '114.122.7.255', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-02 01:18:55', '2025-01-02 01:18:55'),
(2800, 1031, 'login', '114.122.4.56', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-02 02:54:15', '2025-01-02 02:54:15'),
(2801, 1031, 'login > create', '114.122.4.56', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-02 02:54:15', '2025-01-02 02:54:15'),
(2802, 1031, 'login > create', '114.122.4.56', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-02 02:54:27', '2025-01-02 02:54:27'),
(2803, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-02 03:28:28', '2025-01-02 03:28:28'),
(2804, 1026, 'login', '140.213.159.217', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2025-01-02 03:56:17', '2025-01-02 03:56:17'),
(2805, 1030, 'login', '114.122.7.255', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-02 04:35:58', '2025-01-02 04:35:58'),
(2806, 1032, 'login', '192.168.8.114', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-02 09:16:37', '2025-01-02 09:16:37'),
(2807, 1032, 'login > create', '192.168.8.114', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-02 09:16:37', '2025-01-02 09:16:37'),
(2808, 1026, 'login', '112.215.245.59', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-02 10:09:58', '2025-01-02 10:09:58'),
(2809, 1026, 'api > create', '112.215.245.59', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-02 10:11:12', '2025-01-02 10:11:12'),
(2810, 1026, 'check-attendance > create', '112.215.245.59', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-02 10:11:12', '2025-01-02 10:11:12'),
(2811, 1026, 'store-attendance-out > create', '112.215.245.59', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-02 10:11:15', '2025-01-02 10:11:15'),
(2812, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-03 00:57:12', '2025-01-03 00:57:12'),
(2813, 1026, 'login', '112.215.200.31', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2025-01-03 00:59:37', '2025-01-03 00:59:37'),
(2814, 1026, 'login', '112.215.200.31', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2025-01-03 00:59:37', '2025-01-03 00:59:37'),
(2815, 1026, 'api > create', '112.215.200.31', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2025-01-03 01:02:00', '2025-01-03 01:02:00'),
(2816, 1026, 'check-attendance > create', '112.215.200.31', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2025-01-03 01:02:04', '2025-01-03 01:02:04'),
(2817, 1026, 'store-attendance > create', '112.215.200.31', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2025-01-03 01:02:08', '2025-01-03 01:02:08'),
(2818, 1026, 'api > create', '112.215.200.31', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2025-01-03 01:03:41', '2025-01-03 01:03:41'),
(2819, 1026, 'check-attendance > create', '112.215.200.31', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2025-01-03 01:03:44', '2025-01-03 01:03:44'),
(2820, 1026, 'store-attendance-out > create', '112.215.200.31', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2025-01-03 01:03:47', '2025-01-03 01:03:47'),
(2821, 1030, 'login', '114.122.7.255', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-03 01:47:03', '2025-01-03 01:47:03'),
(2822, 1031, 'login', '114.122.6.52', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-03 01:59:24', '2025-01-03 01:59:24'),
(2823, 1031, 'login > create', '114.122.6.52', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-03 01:59:24', '2025-01-03 01:59:24'),
(2824, 1031, 'login > create', '114.122.6.52', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-03 01:59:31', '2025-01-03 01:59:31'),
(2825, 1030, 'login', '114.122.7.255', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-03 06:21:13', '2025-01-03 06:21:13'),
(2826, 1032, 'login', '192.168.11.235', 'Mozilla/5.0 (Windows NT 6.1; rv:107.0) Gecko/20100101 Firefox/107.0', 'Unknown', '2025-01-03 07:58:46', '2025-01-03 07:58:46'),
(2827, 1032, 'login > create', '192.168.11.235', 'Mozilla/5.0 (Windows NT 6.1; rv:107.0) Gecko/20100101 Firefox/107.0', 'Unknown', '2025-01-03 07:58:46', '2025-01-03 07:58:46');
INSERT INTO `tb_log` (`id`, `user_id`, `user_action`, `ip_address`, `user_agent`, `user_location`, `created_at`, `updated_at`) VALUES
(2828, 1026, 'login', '112.215.200.135', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2025-01-03 10:18:03', '2025-01-03 10:18:03'),
(2829, 1026, 'login', '112.215.200.135', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-03 10:19:05', '2025-01-03 10:19:05'),
(2830, 1026, 'api > create', '112.215.200.135', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-03 10:20:38', '2025-01-03 10:20:38'),
(2831, 1026, 'check-attendance > create', '112.215.200.135', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-03 10:20:38', '2025-01-03 10:20:38'),
(2832, 1026, 'store-attendance-out > create', '112.215.200.135', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-03 10:20:41', '2025-01-03 10:20:41'),
(2833, 1026, 'login', '112.215.175.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.25.0-gn', 'Unknown', '2025-01-03 15:03:33', '2025-01-03 15:03:33'),
(2834, 1026, 'login', '112.215.200.186', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-04 00:55:54', '2025-01-04 00:55:54'),
(2835, 1026, 'api > create', '112.215.200.186', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-04 00:57:28', '2025-01-04 00:57:28'),
(2836, 1026, 'check-attendance > create', '112.215.200.186', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-04 00:57:29', '2025-01-04 00:57:29'),
(2837, 1026, 'store-attendance > create', '112.215.200.186', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-04 00:57:36', '2025-01-04 00:57:36'),
(2838, 1026, 'api > create', '112.215.200.186', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-04 00:57:37', '2025-01-04 00:57:37'),
(2839, 1026, 'check-attendance > create', '112.215.200.186', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-04 00:57:37', '2025-01-04 00:57:37'),
(2840, 1026, 'store-attendance-out > create', '112.215.200.186', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-04 00:57:37', '2025-01-04 00:57:37'),
(2841, 1030, 'login', '114.122.7.255', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-04 01:52:51', '2025-01-04 01:52:51'),
(2842, 1031, 'login', '114.122.21.231', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-04 03:00:50', '2025-01-04 03:00:50'),
(2843, 1031, 'login > create', '114.122.21.231', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-04 03:00:50', '2025-01-04 03:00:50'),
(2844, 1031, 'login > create', '114.122.21.231', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-04 03:01:11', '2025-01-04 03:01:11'),
(2845, 1030, 'login', '114.122.21.241', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-04 05:55:47', '2025-01-04 05:55:47'),
(2846, 1029, 'login', '140.213.34.173', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Mobile Safari/537.36 OPR/84.0.0.0', 'Unknown', '2025-01-04 05:57:30', '2025-01-04 05:57:30'),
(2847, 1026, 'login', '112.215.245.80', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-04 10:03:32', '2025-01-04 10:03:32'),
(2848, 1026, 'api > create', '112.215.245.80', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-04 10:04:59', '2025-01-04 10:04:59'),
(2849, 1026, 'check-attendance > create', '112.215.245.80', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-04 10:05:00', '2025-01-04 10:05:00'),
(2850, 1026, 'store-attendance-out > create', '112.215.245.80', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-04 10:05:00', '2025-01-04 10:05:00'),
(2851, 1026, 'login', '36.69.118.51', 'Mozilla/5.0 (Linux; Android 10; M2006C3MG) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/123.0.6312.118 Mobile Safari/537.36', 'Unknown', '2025-01-05 06:37:32', '2025-01-05 06:37:32'),
(2852, 1026, 'login', '140.213.146.130', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.26.1-gn', 'Unknown', '2025-01-06 00:40:25', '2025-01-06 00:40:25'),
(2853, 1026, 'api > create', '140.213.146.130', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.26.1-gn', 'Unknown', '2025-01-06 00:41:55', '2025-01-06 00:41:55'),
(2854, 1026, 'check-attendance > create', '140.213.146.130', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.26.1-gn', 'Unknown', '2025-01-06 00:41:57', '2025-01-06 00:41:57'),
(2855, 1026, 'store-attendance > create', '140.213.146.130', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.26.1-gn', 'Unknown', '2025-01-06 00:42:01', '2025-01-06 00:42:01'),
(2856, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-06 01:04:39', '2025-01-06 01:04:39'),
(2857, 1030, 'login', '114.122.23.15', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-06 01:19:49', '2025-01-06 01:19:49'),
(2858, 1032, 'login', '192.168.11.235', 'Mozilla/5.0 (Windows NT 6.1; rv:107.0) Gecko/20100101 Firefox/107.0', 'Unknown', '2025-01-06 02:20:54', '2025-01-06 02:20:54'),
(2859, 1032, 'login > create', '192.168.11.235', 'Mozilla/5.0 (Windows NT 6.1; rv:107.0) Gecko/20100101 Firefox/107.0', 'Unknown', '2025-01-06 02:20:54', '2025-01-06 02:20:54'),
(2860, 1031, 'login', '114.122.4.198', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-06 02:43:05', '2025-01-06 02:43:05'),
(2861, 1031, 'login > create', '114.122.4.198', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-06 02:43:05', '2025-01-06 02:43:05'),
(2862, 1031, 'login > create', '114.122.4.198', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-06 02:43:09', '2025-01-06 02:43:09'),
(2863, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-06 03:05:48', '2025-01-06 03:05:48'),
(2864, 1030, 'login', '114.122.20.251', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-06 05:57:31', '2025-01-06 05:57:31'),
(2865, 1033, 'login', '192.168.11.226', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2025-01-06 06:06:59', '2025-01-06 06:06:59'),
(2866, 1033, 'login > create', '192.168.11.226', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Unknown', '2025-01-06 06:06:59', '2025-01-06 06:06:59'),
(2867, 1026, 'login', '203.78.119.49', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.26.1-gn', 'Unknown', '2025-01-06 10:33:01', '2025-01-06 10:33:01'),
(2868, 1026, 'api > create', '203.78.119.49', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.26.1-gn', 'Unknown', '2025-01-06 10:36:01', '2025-01-06 10:36:01'),
(2869, 1026, 'check-attendance > create', '203.78.119.49', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.26.1-gn', 'Unknown', '2025-01-06 10:36:14', '2025-01-06 10:36:14'),
(2870, 1026, 'api > create', '203.78.119.49', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.26.1-gn', 'Unknown', '2025-01-06 10:37:35', '2025-01-06 10:37:35'),
(2871, 1026, 'check-attendance > create', '203.78.119.49', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.26.1-gn', 'Unknown', '2025-01-06 10:37:42', '2025-01-06 10:37:42'),
(2872, 1026, 'store-attendance-out > create', '203.78.119.49', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.26.1-gn', 'Unknown', '2025-01-06 10:37:49', '2025-01-06 10:37:49'),
(2873, 1026, 'api > create', '203.78.119.49', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.26.1-gn', 'Unknown', '2025-01-06 10:37:51', '2025-01-06 10:37:51'),
(2874, 1026, 'check-attendance > create', '203.78.119.49', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.26.1-gn', 'Unknown', '2025-01-06 10:37:58', '2025-01-06 10:37:58'),
(2875, 1026, 'login', '140.213.147.44', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.26.1-gn', 'Unknown', '2025-01-07 00:55:16', '2025-01-07 00:55:16'),
(2876, 1026, 'api > create', '140.213.147.44', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.26.1-gn', 'Unknown', '2025-01-07 00:56:36', '2025-01-07 00:56:36'),
(2877, 1026, 'check-attendance > create', '140.213.147.44', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.26.1-gn', 'Unknown', '2025-01-07 00:56:40', '2025-01-07 00:56:40'),
(2878, 1026, 'store-attendance > create', '140.213.147.44', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.6312.118 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.26.1-gn', 'Unknown', '2025-01-07 00:56:44', '2025-01-07 00:56:44'),
(2879, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-07 01:48:45', '2025-01-07 01:48:45'),
(2880, 1030, 'login', '114.122.20.23', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-07 02:02:44', '2025-01-07 02:02:44');

-- --------------------------------------------------------

--
-- Table structure for table `tb_overtime`
--

CREATE TABLE `tb_overtime` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_pegawai` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fee` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_pegawai`
--

CREATE TABLE `tb_pegawai` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_pegawai` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik_pegawai` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nick_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_telp` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan` bigint UNSIGNED DEFAULT NULL,
  `golongan` bigint UNSIGNED DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `salary_id` bigint UNSIGNED DEFAULT NULL,
  `storage` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_pegawai`
--

INSERT INTO `tb_pegawai` (`id`, `kode_pegawai`, `nik_pegawai`, `full_name`, `nick_name`, `no_telp`, `alamat`, `jabatan`, `golongan`, `tgl_lahir`, `salary_id`, `storage`, `created_at`, `updated_at`) VALUES
(231, '28101999', '12012810990001', 'Muhammad Abdi Mayu', 'Abdi', '082265380192', 'Tanjung Morawa', 11, 4, '1999-10-28', 1, 'labels\\28101999\\', '2024-09-29 13:57:55', '2024-12-11 06:43:45'),
(232, '112233', '1209312211090001', 'Muhammad Taufik', 'Taufik', '082265380918', 'Medan', 26, 5, '2002-05-16', NULL, NULL, '2024-11-13 06:26:33', '2024-11-13 06:26:33'),
(233, '315', '1209312810990001', 'Oky Sandy Sirait', 'Oky', '081233445678', 'Medan', 26, 5, '2024-11-13', NULL, NULL, '2024-11-13 06:49:35', '2024-11-13 06:49:35'),
(234, '344', '1209312810990001', 'Bernard Samuel Sianturi', 'Bernard', '082265380192', 'Medan', 26, 5, '2024-11-07', NULL, NULL, '2024-11-13 07:54:12', '2024-11-13 07:54:12'),
(235, '123123', '1209312810990001', 'Abdul Khalid Hasibuan', 'Abdul', '085275349929', 'Medan', 25, 5, '2024-11-21', NULL, NULL, '2024-11-13 09:09:43', '2024-11-13 09:09:43'),
(236, '31450', '000000000000000', 'PUPUT JULIANTI', 'PUPUT', '083186786654', 'Pekan Baru', 27, 5, '1996-07-29', NULL, 'labels\\31450\\', '2024-11-18 03:53:41', '2024-11-22 09:26:33'),
(237, '1105', '1209312810990001', 'Collector', 'Collector', '082265380918', 'Medan', 28, 6, '1999-10-28', NULL, NULL, '2024-11-29 11:06:48', '2024-11-29 11:06:48'),
(238, '394', '000000000', 'KEVIN FRANSETIO', 'Kevin', '6283803432393', 'Medan', 28, 5, '2024-11-29', NULL, NULL, '2024-11-29 13:56:27', '2024-11-29 13:56:27'),
(239, '493', '00000000000000', 'JOHAN', 'JOHAN', '082360712555', 'Medan', 28, 5, '2024-12-12', NULL, NULL, '2024-12-11 09:28:25', '2024-12-11 09:28:25'),
(240, '74', '0000000000', 'TRI AJI SISWOYO NASUTION', 'AJI', '081396896000', 'Medan', 28, 5, '2024-12-13', NULL, NULL, '2024-12-11 09:29:14', '2024-12-11 09:29:14'),
(241, '439', '0000000000', 'RISNA ADE NINGSIH', 'ADE', '085100058598', 'Medan', 15, 5, '2024-12-16', NULL, NULL, '2024-12-16 01:12:09', '2024-12-16 01:12:09'),
(242, '437', '0000000', 'MARCELINA SIANTURI', 'MARCELINA', '082369814718', 'Medan', 15, 5, '2024-12-16', NULL, NULL, '2024-12-16 03:26:12', '2024-12-16 03:27:20');

-- --------------------------------------------------------

--
-- Table structure for table `tb_photo_collect`
--

CREATE TABLE `tb_photo_collect` (
  `id` bigint UNSIGNED NOT NULL,
  `id_collect` bigint UNSIGNED DEFAULT NULL,
  `photourl` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_photo_collect`
--

INSERT INTO `tb_photo_collect` (`id`, `id_collect`, `photourl`, `created_at`, `updated_at`) VALUES
(17, 10, '/storage/collectors/674ecfff8add3.png', '2024-12-03 16:31:43', '2024-12-03 16:31:43'),
(20, 13, '/storage/collectors/674fcdcf88e41.png', '2024-12-04 10:34:39', '2024-12-04 10:34:39'),
(21, 14, '/storage/collectors/674fcf9fbf1bd.png', '2024-12-04 10:42:23', '2024-12-04 10:42:23'),
(22, 15, '/storage/collectors/674fd9f325788.png', '2024-12-04 11:26:27', '2024-12-04 11:26:27'),
(25, 18, '/storage/collectors/675018fcc6678.png', '2024-12-04 15:55:24', '2024-12-04 15:55:24'),
(26, 19, '/storage/collectors/67501a58ccf74.png', '2024-12-04 16:01:12', '2024-12-04 16:01:12'),
(27, 20, '/storage/collectors/67501d013d197.png', '2024-12-04 16:12:33', '2024-12-04 16:12:33'),
(30, 23, '/storage/collectors/6751061a47f3b.png', '2024-12-05 08:47:06', '2024-12-05 08:47:06'),
(33, 26, '/storage/collectors/67510e1bb1dcd.png', '2024-12-05 09:21:15', '2024-12-05 09:21:15'),
(40, 33, '/storage/collectors/6751246b8f8c4.png', '2024-12-05 10:56:27', '2024-12-05 10:56:27'),
(41, 34, '/storage/collectors/67512cbb9a410.png', '2024-12-05 11:31:55', '2024-12-05 11:31:55'),
(42, 35, '/storage/collectors/67515b6542ad8.png', '2024-12-05 14:51:01', '2024-12-05 14:51:01'),
(43, 36, '/storage/collectors/675168e0a9dc5.png', '2024-12-05 15:48:32', '2024-12-05 15:48:32'),
(45, 38, '/storage/collectors/6752b1e3043e6.png', '2024-12-06 15:12:19', '2024-12-06 15:12:19'),
(53, 46, '/storage/collectors/675a3dee67707.png', '2024-12-12 01:35:42', '2024-12-12 01:35:42'),
(54, 47, '/storage/collectors/675a400e9dc4b.png', '2024-12-12 01:44:46', '2024-12-12 01:44:46'),
(55, 48, '/storage/collectors/675a46fd23c74.png', '2024-12-12 02:14:21', '2024-12-12 02:14:21'),
(56, 49, '/storage/collectors/675a4855b65a2.png', '2024-12-12 02:20:05', '2024-12-12 02:20:05'),
(57, 50, '/storage/collectors/675a4b3f81862.png', '2024-12-12 02:32:31', '2024-12-12 02:32:31'),
(58, 51, '/storage/collectors/675a4dcbb917c.png', '2024-12-12 02:43:23', '2024-12-12 02:43:23'),
(59, 52, '/storage/collectors/675a50ed2f810.png', '2024-12-12 02:56:45', '2024-12-12 02:56:45'),
(60, 53, '/storage/collectors/675a60fc1f454.png', '2024-12-12 04:05:16', '2024-12-12 04:05:16'),
(61, 54, '/storage/collectors/675a650298c69.png', '2024-12-12 04:22:26', '2024-12-12 04:22:26'),
(62, 55, '/storage/collectors/675a6b940da76.png', '2024-12-12 04:50:28', '2024-12-12 04:50:28'),
(63, 56, '/storage/collectors/675a732941f23.png', '2024-12-12 05:22:49', '2024-12-12 05:22:49'),
(64, 57, '/storage/collectors/675a7e037310b.png', '2024-12-12 06:09:07', '2024-12-12 06:09:07'),
(65, 58, '/storage/collectors/675a912f9283f.png', '2024-12-12 07:30:55', '2024-12-12 07:30:55'),
(66, 59, '/storage/collectors/675a9f5a51ccb.png', '2024-12-12 08:31:22', '2024-12-12 08:31:22'),
(67, 60, '/storage/collectors/675aab0edccc9.png', '2024-12-12 09:21:18', '2024-12-12 09:21:18'),
(68, 61, '/storage/collectors/675b96d8637a1.png', '2024-12-13 02:07:20', '2024-12-13 02:07:20'),
(69, 62, '/storage/collectors/675ba717b5b94.png', '2024-12-13 03:16:39', '2024-12-13 03:16:39'),
(70, 63, '/storage/collectors/675ba96b604a4.png', '2024-12-13 03:26:35', '2024-12-13 03:26:35'),
(71, 64, '/storage/collectors/675baf7aab4cc.png', '2024-12-13 03:52:26', '2024-12-13 03:52:26'),
(72, 65, '/storage/collectors/675bb183d6217.png', '2024-12-13 04:01:07', '2024-12-13 04:01:07'),
(73, 66, '/storage/collectors/675bd9ed0ec0c.png', '2024-12-13 06:53:33', '2024-12-13 06:53:33'),
(74, 67, '/storage/collectors/675cf325e05c9.png', '2024-12-14 02:53:25', '2024-12-14 02:53:25'),
(75, 68, '/storage/collectors/675d2f099ad84.png', '2024-12-14 07:08:57', '2024-12-14 07:08:57'),
(76, 69, '/storage/collectors/675d33255d5c8.png', '2024-12-14 07:26:29', '2024-12-14 07:26:29'),
(77, 70, '/storage/collectors/675d3367316c8.png', '2024-12-14 07:27:35', '2024-12-14 07:27:35'),
(78, 71, '/storage/collectors/675d36c6941dc.png', '2024-12-14 07:41:58', '2024-12-14 07:41:58'),
(79, 72, '/storage/collectors/675d37a960f7d.png', '2024-12-14 07:45:45', '2024-12-14 07:45:45'),
(80, 73, '/storage/collectors/675f7b856d733.png', '2024-12-16 00:59:49', '2024-12-16 00:59:49'),
(82, 75, '/storage/collectors/675f8e8e4ed78.png', '2024-12-16 02:21:02', '2024-12-16 02:21:02'),
(83, 76, '/storage/collectors/675f91cc3e9e5.png', '2024-12-16 02:34:52', '2024-12-16 02:34:52'),
(84, 77, '/storage/collectors/675f936b6fcf6.png', '2024-12-16 02:41:47', '2024-12-16 02:41:47'),
(85, 78, '/storage/collectors/675f94709cfba.png', '2024-12-16 02:46:08', '2024-12-16 02:46:08'),
(86, 79, '/storage/collectors/675f9576dcb7c.png', '2024-12-16 02:50:30', '2024-12-16 02:50:30'),
(87, 80, '/storage/collectors/675f95e8001c3.png', '2024-12-16 02:52:24', '2024-12-16 02:52:24'),
(88, 81, '/storage/collectors/675f985a33a95.png', '2024-12-16 03:02:50', '2024-12-16 03:02:50'),
(89, 82, '/storage/collectors/675f9ec292700.png', '2024-12-16 03:30:10', '2024-12-16 03:30:10'),
(90, 83, '/storage/collectors/675fa0dfa02c8.png', '2024-12-16 03:39:11', '2024-12-16 03:39:11'),
(91, 84, '/storage/collectors/675fa218550b4.png', '2024-12-16 03:44:24', '2024-12-16 03:44:24'),
(92, 85, '/storage/collectors/675fa2f2a95d3.png', '2024-12-16 03:48:02', '2024-12-16 03:48:02'),
(93, 86, '/storage/collectors/675fa41c6a74b.png', '2024-12-16 03:53:00', '2024-12-16 03:53:00'),
(95, 88, '/storage/collectors/675fa5db9572c.png', '2024-12-16 04:00:27', '2024-12-16 04:00:27'),
(96, 89, '/storage/collectors/675fa7d6e8471.png', '2024-12-16 04:08:54', '2024-12-16 04:08:54'),
(97, 90, '/storage/collectors/675fe8724da3b.png', '2024-12-16 08:44:34', '2024-12-16 08:44:34'),
(98, 91, '/storage/collectors/6760d22f7a2c8.png', '2024-12-17 01:21:51', '2024-12-17 01:21:51'),
(99, 92, '/storage/collectors/6760d7196a16f.png', '2024-12-17 01:42:49', '2024-12-17 01:42:49'),
(100, 93, '/storage/collectors/6760dc20cab7a.png', '2024-12-17 02:04:16', '2024-12-17 02:04:16'),
(101, 94, '/storage/collectors/6760e12d4adcc.png', '2024-12-17 02:25:49', '2024-12-17 02:25:49'),
(102, 95, '/storage/collectors/6760e3d9989ef.png', '2024-12-17 02:37:13', '2024-12-17 02:37:13'),
(103, 96, '/storage/collectors/6760e58beb6f5.png', '2024-12-17 02:44:27', '2024-12-17 02:44:27'),
(104, 97, '/storage/collectors/6760e7f05143f.png', '2024-12-17 02:54:40', '2024-12-17 02:54:40'),
(105, 98, '/storage/collectors/6760eb1940132.png', '2024-12-17 03:08:09', '2024-12-17 03:08:09'),
(106, 99, '/storage/collectors/6760ebacd3ea7.png', '2024-12-17 03:10:36', '2024-12-17 03:10:36'),
(107, 100, '/storage/collectors/6760ebd286e7d.png', '2024-12-17 03:11:14', '2024-12-17 03:11:14'),
(108, 101, '/storage/collectors/6760ee5a645d0.png', '2024-12-17 03:22:02', '2024-12-17 03:22:02'),
(109, 102, '/storage/collectors/6760ef6707041.png', '2024-12-17 03:26:31', '2024-12-17 03:26:31'),
(110, 103, '/storage/collectors/6760efb458346.png', '2024-12-17 03:27:48', '2024-12-17 03:27:48'),
(111, 104, '/storage/collectors/6760f06b01aff.png', '2024-12-17 03:30:51', '2024-12-17 03:30:51'),
(112, 105, '/storage/collectors/6760f17953dcb.png', '2024-12-17 03:35:21', '2024-12-17 03:35:21'),
(113, 106, '/storage/collectors/6760f1a192091.png', '2024-12-17 03:36:01', '2024-12-17 03:36:01'),
(114, 107, '/storage/collectors/6760f44ca416f.png', '2024-12-17 03:47:24', '2024-12-17 03:47:24'),
(115, 108, '/storage/collectors/6760f75fe610e.png', '2024-12-17 04:00:31', '2024-12-17 04:00:31'),
(116, 109, '/storage/collectors/6760fa53660fa.png', '2024-12-17 04:13:07', '2024-12-17 04:13:07'),
(117, 110, '/storage/collectors/6760fc6e0374b.png', '2024-12-17 04:22:06', '2024-12-17 04:22:06'),
(118, 111, '/storage/collectors/6760fd1e23c4a.png', '2024-12-17 04:25:02', '2024-12-17 04:25:02'),
(119, 112, '/storage/collectors/67610286a13ab.png', '2024-12-17 04:48:06', '2024-12-17 04:48:06'),
(120, 113, '/storage/collectors/6761069feac2b.png', '2024-12-17 05:05:35', '2024-12-17 05:05:35'),
(121, 114, '/storage/collectors/67612318c73cd.png', '2024-12-17 07:07:04', '2024-12-17 07:07:04'),
(122, 115, '/storage/collectors/67612d95528c6.png', '2024-12-17 07:51:49', '2024-12-17 07:51:49'),
(123, 116, '/storage/collectors/676131a246f26.png', '2024-12-17 08:09:06', '2024-12-17 08:09:06'),
(124, 117, '/storage/collectors/676135ec9bcad.png', '2024-12-17 08:27:24', '2024-12-17 08:27:24'),
(125, 118, '/storage/collectors/676225a1084b7.png', '2024-12-18 01:30:09', '2024-12-18 01:30:09'),
(126, 119, '/storage/collectors/676228ffb8ed2.png', '2024-12-18 01:44:31', '2024-12-18 01:44:31'),
(127, 120, '/storage/collectors/676231426d56f.png', '2024-12-18 02:19:46', '2024-12-18 02:19:46'),
(128, 121, '/storage/collectors/676234f9ab4b8.png', '2024-12-18 02:35:37', '2024-12-18 02:35:37'),
(129, 122, '/storage/collectors/6762391b018ba.png', '2024-12-18 02:53:15', '2024-12-18 02:53:15'),
(130, 123, '/storage/collectors/676239593b1ed.png', '2024-12-18 02:54:17', '2024-12-18 02:54:17'),
(131, 124, '/storage/collectors/676239de97bbc.png', '2024-12-18 02:56:30', '2024-12-18 02:56:30'),
(132, 125, '/storage/collectors/67623e784e8ca.png', '2024-12-18 03:16:08', '2024-12-18 03:16:08'),
(133, 126, '/storage/collectors/676240b207ffc.png', '2024-12-18 03:25:38', '2024-12-18 03:25:38'),
(134, 127, '/storage/collectors/6762411ac8db1.png', '2024-12-18 03:27:22', '2024-12-18 03:27:22'),
(135, 128, '/storage/collectors/67624602f1b88.png', '2024-12-18 03:48:18', '2024-12-18 03:48:18'),
(136, 129, '/storage/collectors/67624637e20c1.png', '2024-12-18 03:49:11', '2024-12-18 03:49:11'),
(137, 130, '/storage/collectors/6762474e41e16.png', '2024-12-18 03:53:50', '2024-12-18 03:53:50'),
(138, 131, '/storage/collectors/676249bd5d0d5.png', '2024-12-18 04:04:13', '2024-12-18 04:04:13'),
(139, 132, '/storage/collectors/67624a1792dc8.png', '2024-12-18 04:05:43', '2024-12-18 04:05:43'),
(140, 133, '/storage/collectors/67624c6a9e1d7.png', '2024-12-18 04:15:38', '2024-12-18 04:15:38'),
(141, 134, '/storage/collectors/6762540e4038c.png', '2024-12-18 04:48:14', '2024-12-18 04:48:14'),
(142, 135, '/storage/collectors/676257611a0e4.png', '2024-12-18 05:02:25', '2024-12-18 05:02:25'),
(143, 136, '/storage/collectors/67626d612696c.png', '2024-12-18 06:36:17', '2024-12-18 06:36:17'),
(144, 137, '/storage/collectors/676270fa8e5f5.png', '2024-12-18 06:51:38', '2024-12-18 06:51:38'),
(145, 138, '/storage/collectors/676275fe548c7.png', '2024-12-18 07:13:02', '2024-12-18 07:13:02'),
(148, 141, '/storage/collectors/67627ecb6f25d.png', '2024-12-18 07:50:35', '2024-12-18 07:50:35'),
(149, 142, '/storage/collectors/67627fe63b324.png', '2024-12-18 07:55:18', '2024-12-18 07:55:18'),
(150, 143, '/storage/collectors/6762826427532.png', '2024-12-18 08:05:56', '2024-12-18 08:05:56'),
(151, 144, '/storage/collectors/67628d7527113.png', '2024-12-18 08:53:09', '2024-12-18 08:53:09'),
(152, 145, '/storage/collectors/676294f1868d2.png', '2024-12-18 09:25:05', '2024-12-18 09:25:05'),
(153, 146, '/storage/collectors/676380365174c.png', '2024-12-19 02:08:54', '2024-12-19 02:08:54'),
(154, 147, '/storage/collectors/676383263e8f2.png', '2024-12-19 02:21:26', '2024-12-19 02:21:26'),
(155, 148, '/storage/collectors/676393ea0bd9a.png', '2024-12-19 03:32:58', '2024-12-19 03:32:58'),
(156, 149, '/storage/collectors/676395e2a827c.png', '2024-12-19 03:41:22', '2024-12-19 03:41:22'),
(157, 150, '/storage/collectors/67639949f007d.png', '2024-12-19 03:55:53', '2024-12-19 03:55:53'),
(158, 151, '/storage/collectors/67639db8876d2.png', '2024-12-19 04:14:48', '2024-12-19 04:14:48'),
(159, 152, '/storage/collectors/67639ffb7170b.png', '2024-12-19 04:24:27', '2024-12-19 04:24:27'),
(160, 153, '/storage/collectors/6763a0e6727aa.png', '2024-12-19 04:28:22', '2024-12-19 04:28:22'),
(161, 154, '/storage/collectors/6763b49f7729e.png', '2024-12-19 05:52:31', '2024-12-19 05:52:31'),
(162, 155, '/storage/collectors/6763b70e81963.png', '2024-12-19 06:02:54', '2024-12-19 06:02:54'),
(163, 156, '/storage/collectors/6763b942dd4b8.png', '2024-12-19 06:12:18', '2024-12-19 06:12:18'),
(164, 157, '/storage/collectors/6763bb9b653e5.png', '2024-12-19 06:22:19', '2024-12-19 06:22:19'),
(165, 158, '/storage/collectors/6763bdd6311bb.png', '2024-12-19 06:31:50', '2024-12-19 06:31:50'),
(166, 159, '/storage/collectors/6763c9087faa6.png', '2024-12-19 07:19:36', '2024-12-19 07:19:36'),
(167, 160, '/storage/collectors/6763dd263bc06.png', '2024-12-19 08:45:26', '2024-12-19 08:45:26'),
(168, 161, '/storage/collectors/6764cbba3bf4f.png', '2024-12-20 01:43:22', '2024-12-20 01:43:22'),
(169, 162, '/storage/collectors/6764ccc3635a7.png', '2024-12-20 01:47:47', '2024-12-20 01:47:47'),
(170, 163, '/storage/collectors/6764cd10bcb44.png', '2024-12-20 01:49:04', '2024-12-20 01:49:04'),
(171, 164, '/storage/collectors/6764d21c7ca1e.png', '2024-12-20 02:10:36', '2024-12-20 02:10:36'),
(172, 165, '/storage/collectors/6764d4bb15fa9.png', '2024-12-20 02:21:47', '2024-12-20 02:21:47'),
(173, 166, '/storage/collectors/6764d8f4c6122.png', '2024-12-20 02:39:48', '2024-12-20 02:39:48'),
(174, 167, '/storage/collectors/6764dad5ce1fb.png', '2024-12-20 02:47:49', '2024-12-20 02:47:49'),
(175, 168, '/storage/collectors/6764dcb82e6ff.png', '2024-12-20 02:55:52', '2024-12-20 02:55:52'),
(176, 169, '/storage/collectors/6764dfe40217d.png', '2024-12-20 03:09:24', '2024-12-20 03:09:24'),
(177, 170, '/storage/collectors/6764e0445cfc3.png', '2024-12-20 03:11:00', '2024-12-20 03:11:00'),
(178, 171, '/storage/collectors/6764e195a746a.png', '2024-12-20 03:16:37', '2024-12-20 03:16:37'),
(179, 172, '/storage/collectors/6764e48398082.png', '2024-12-20 03:29:07', '2024-12-20 03:29:07'),
(180, 173, '/storage/collectors/6764e96b0795d.png', '2024-12-20 03:50:03', '2024-12-20 03:50:03'),
(181, 174, '/storage/collectors/6764f010624ab.png', '2024-12-20 04:18:24', '2024-12-20 04:18:24'),
(182, 175, '/storage/collectors/6764f03e94613.png', '2024-12-20 04:19:10', '2024-12-20 04:19:10'),
(183, 176, '/storage/collectors/6764f06be8926.png', '2024-12-20 04:19:55', '2024-12-20 04:19:55'),
(185, 178, '/storage/collectors/6766184226b6e.png', '2024-12-21 01:22:10', '2024-12-21 01:22:10'),
(186, 179, '/storage/collectors/6766253cd266b.png', '2024-12-21 02:17:32', '2024-12-21 02:17:32'),
(187, 180, '/storage/collectors/67662ef4a5351.png', '2024-12-21 02:59:00', '2024-12-21 02:59:00'),
(188, 181, '/storage/collectors/676634dcb35a7.png', '2024-12-21 03:24:12', '2024-12-21 03:24:12'),
(189, 182, '/storage/collectors/67663710a4f51.png', '2024-12-21 03:33:36', '2024-12-21 03:33:36'),
(190, 183, '/storage/collectors/67663824d6a05.png', '2024-12-21 03:38:12', '2024-12-21 03:38:12'),
(191, 184, '/storage/collectors/676638757c8e2.png', '2024-12-21 03:39:33', '2024-12-21 03:39:33'),
(192, 185, '/storage/collectors/676639152c5e2.png', '2024-12-21 03:42:13', '2024-12-21 03:42:13'),
(193, 186, '/storage/collectors/67663ad833c76.png', '2024-12-21 03:49:44', '2024-12-21 03:49:44'),
(194, 187, '/storage/collectors/67663b368f35f.png', '2024-12-21 03:51:18', '2024-12-21 03:51:18'),
(195, 188, '/storage/collectors/67663e9066903.png', '2024-12-21 04:05:36', '2024-12-21 04:05:36'),
(196, 189, '/storage/collectors/6766407384756.png', '2024-12-21 04:13:39', '2024-12-21 04:13:39'),
(197, 190, '/storage/collectors/676640871f6b9.png', '2024-12-21 04:13:59', '2024-12-21 04:13:59'),
(198, 191, '/storage/collectors/67665eca06096.png', '2024-12-21 06:23:06', '2024-12-21 06:23:06'),
(199, 192, '/storage/collectors/676677da7e6f1.png', '2024-12-21 08:10:02', '2024-12-21 08:10:02'),
(200, 193, '/storage/collectors/676679663b027.png', '2024-12-21 08:16:38', '2024-12-21 08:16:38'),
(201, 194, '/storage/collectors/676680b32fe63.png', '2024-12-21 08:47:47', '2024-12-21 08:47:47'),
(202, 195, '/storage/collectors/676685a474f49.png', '2024-12-21 09:08:52', '2024-12-21 09:08:52'),
(203, 196, '/storage/collectors/6768cb8692663.png', '2024-12-23 02:31:34', '2024-12-23 02:31:34'),
(204, 197, '/storage/collectors/6768d11e28f74.png', '2024-12-23 02:55:26', '2024-12-23 02:55:26'),
(205, 198, '/storage/collectors/6768d618060e4.png', '2024-12-23 03:16:40', '2024-12-23 03:16:40'),
(206, 199, '/storage/collectors/6768d83d36735.png', '2024-12-23 03:25:49', '2024-12-23 03:25:49'),
(207, 200, '/storage/collectors/6768d8a913d40.png', '2024-12-23 03:27:37', '2024-12-23 03:27:37'),
(208, 201, '/storage/collectors/6768da6d45e0c.png', '2024-12-23 03:35:09', '2024-12-23 03:35:09'),
(209, 202, '/storage/collectors/6768de04dbe04.png', '2024-12-23 03:50:28', '2024-12-23 03:50:28'),
(210, 203, '/storage/collectors/6768e400b9de8.png', '2024-12-23 04:16:00', '2024-12-23 04:16:00'),
(211, 204, '/storage/collectors/6768e484651bd.png', '2024-12-23 04:18:12', '2024-12-23 04:18:12'),
(212, 205, '/storage/collectors/6768ebb916a4f.png', '2024-12-23 04:48:57', '2024-12-23 04:48:57'),
(213, 206, '/storage/collectors/676907d190a3a.png', '2024-12-23 06:48:49', '2024-12-23 06:48:49'),
(214, 207, '/storage/collectors/67690bb2acf4d.png', '2024-12-23 07:05:22', '2024-12-23 07:05:22'),
(215, 208, '/storage/collectors/676a0ced26f48.png', '2024-12-24 01:22:53', '2024-12-24 01:22:53'),
(216, 209, '/storage/collectors/676a11d19d5f3.png', '2024-12-24 01:43:45', '2024-12-24 01:43:45'),
(217, 210, '/storage/collectors/676a14a8a227e.png', '2024-12-24 01:55:52', '2024-12-24 01:55:52'),
(218, 211, '/storage/collectors/676a16e1e4713.png', '2024-12-24 02:05:21', '2024-12-24 02:05:21'),
(219, 212, '/storage/collectors/676a1c46f2bad.png', '2024-12-24 02:28:22', '2024-12-24 02:28:22'),
(220, 213, '/storage/collectors/676a223e67d53.png', '2024-12-24 02:53:50', '2024-12-24 02:53:50'),
(221, 214, '/storage/collectors/676a24b24e06f.png', '2024-12-24 03:04:18', '2024-12-24 03:04:18'),
(222, 215, '/storage/collectors/676a27811a354.png', '2024-12-24 03:16:17', '2024-12-24 03:16:17'),
(223, 216, '/storage/collectors/676a2ba13518e.png', '2024-12-24 03:33:53', '2024-12-24 03:33:53'),
(224, 217, '/storage/collectors/676a2e0193bf8.png', '2024-12-24 03:44:01', '2024-12-24 03:44:01'),
(225, 218, '/storage/collectors/676a30ca918e2.png', '2024-12-24 03:55:54', '2024-12-24 03:55:54'),
(226, 219, '/storage/collectors/676a313aa4e77.png', '2024-12-24 03:57:46', '2024-12-24 03:57:46'),
(227, 220, '/storage/collectors/676a321249509.png', '2024-12-24 04:01:22', '2024-12-24 04:01:22'),
(228, 221, '/storage/collectors/676a346ecff8d.png', '2024-12-24 04:11:26', '2024-12-24 04:11:26'),
(229, 222, '/storage/collectors/676a3909bd949.png', '2024-12-24 04:31:05', '2024-12-24 04:31:05'),
(230, 223, '/storage/collectors/676a3e08d0b41.png', '2024-12-24 04:52:24', '2024-12-24 04:52:24'),
(231, 224, '/storage/collectors/676a3e70a6122.png', '2024-12-24 04:54:08', '2024-12-24 04:54:08'),
(232, 225, '/storage/collectors/676a41817905c.png', '2024-12-24 05:07:13', '2024-12-24 05:07:13'),
(233, 226, '/storage/collectors/676cb92e63298.png', '2024-12-26 02:02:22', '2024-12-26 02:02:22'),
(234, 227, '/storage/collectors/676cbba12c215.png', '2024-12-26 02:12:49', '2024-12-26 02:12:49'),
(235, 228, '/storage/collectors/676cbc991bb6b.png', '2024-12-26 02:16:57', '2024-12-26 02:16:57'),
(236, 229, '/storage/collectors/676cbf49bdf59.png', '2024-12-26 02:28:25', '2024-12-26 02:28:25'),
(237, 230, '/storage/collectors/676cc1e5d74b8.png', '2024-12-26 02:39:33', '2024-12-26 02:39:33'),
(238, 231, '/storage/collectors/676cc54a7a7e1.png', '2024-12-26 02:54:02', '2024-12-26 02:54:02'),
(239, 232, '/storage/collectors/676cc9b47c039.png', '2024-12-26 03:12:52', '2024-12-26 03:12:52'),
(240, 233, '/storage/collectors/676cd21969ecc.png', '2024-12-26 03:48:41', '2024-12-26 03:48:41'),
(241, 234, '/storage/collectors/676cd6214bd15.png', '2024-12-26 04:05:53', '2024-12-26 04:05:53'),
(242, 235, '/storage/collectors/676cd81db95d5.png', '2024-12-26 04:14:21', '2024-12-26 04:14:21'),
(243, 236, '/storage/collectors/676cda5809d36.png', '2024-12-26 04:23:52', '2024-12-26 04:23:52'),
(244, 237, '/storage/collectors/676cdddb96cc8.png', '2024-12-26 04:38:51', '2024-12-26 04:38:51'),
(245, 238, '/storage/collectors/676cdf3c41299.png', '2024-12-26 04:44:44', '2024-12-26 04:44:44'),
(246, 239, '/storage/collectors/676d077e53ce6.png', '2024-12-26 07:36:30', '2024-12-26 07:36:30'),
(247, 240, '/storage/collectors/676e05eb9480c.png', '2024-12-27 01:42:03', '2024-12-27 01:42:03'),
(248, 241, '/storage/collectors/676e07994c3b0.png', '2024-12-27 01:49:13', '2024-12-27 01:49:13'),
(249, 242, '/storage/collectors/676e08139dea8.png', '2024-12-27 01:51:15', '2024-12-27 01:51:15'),
(250, 243, '/storage/collectors/676e09b29c5ee.png', '2024-12-27 01:58:10', '2024-12-27 01:58:10'),
(251, 244, '/storage/collectors/676e0cba83183.png', '2024-12-27 02:11:06', '2024-12-27 02:11:06'),
(252, 245, '/storage/collectors/676e112285d8e.png', '2024-12-27 02:29:54', '2024-12-27 02:29:54'),
(253, 246, '/storage/collectors/676e13822098a.png', '2024-12-27 02:40:02', '2024-12-27 02:40:02'),
(254, 247, '/storage/collectors/676e18bf6e819.png', '2024-12-27 03:02:23', '2024-12-27 03:02:23'),
(255, 248, '/storage/collectors/676e18f5ad5b8.png', '2024-12-27 03:03:17', '2024-12-27 03:03:17'),
(256, 249, '/storage/collectors/676e1a1dcb847.png', '2024-12-27 03:08:13', '2024-12-27 03:08:13'),
(257, 250, '/storage/collectors/676e2330e58da.png', '2024-12-27 03:46:56', '2024-12-27 03:46:56'),
(258, 251, '/storage/collectors/676e28af6dade.png', '2024-12-27 04:10:23', '2024-12-27 04:10:23'),
(259, 252, '/storage/collectors/676e2f533e60c.png', '2024-12-27 04:38:43', '2024-12-27 04:38:43'),
(260, 253, '/storage/collectors/676e2fb0b39ec.png', '2024-12-27 04:40:16', '2024-12-27 04:40:16'),
(261, 254, '/storage/collectors/676e353e2ff38.png', '2024-12-27 05:03:58', '2024-12-27 05:03:58'),
(262, 255, '/storage/collectors/676e3c2297f6c.png', '2024-12-27 05:33:22', '2024-12-27 05:33:22'),
(263, 256, '/storage/collectors/676e44b7f3fe5.png', '2024-12-27 06:10:00', '2024-12-27 06:10:00'),
(264, 257, '/storage/collectors/676e47f41c7fe.png', '2024-12-27 06:23:48', '2024-12-27 06:23:48'),
(265, 258, '/storage/collectors/676e48e831a21.png', '2024-12-27 06:27:52', '2024-12-27 06:27:52'),
(266, 259, '/storage/collectors/676e4ac3258ca.png', '2024-12-27 06:35:47', '2024-12-27 06:35:47'),
(267, 260, '/storage/collectors/676e4c20aa18c.png', '2024-12-27 06:41:36', '2024-12-27 06:41:36'),
(268, 261, '/storage/collectors/676e4ec5cd624.png', '2024-12-27 06:52:53', '2024-12-27 06:52:53'),
(269, 262, '/storage/collectors/676e6b32820e2.png', '2024-12-27 08:54:10', '2024-12-27 08:54:10'),
(270, 263, '/storage/collectors/676e71ab90a9f.png', '2024-12-27 09:21:47', '2024-12-27 09:21:47'),
(271, 264, '/storage/collectors/676f64706a13d.png', '2024-12-28 02:37:36', '2024-12-28 02:37:36'),
(272, 265, '/storage/collectors/676f64be29066.png', '2024-12-28 02:38:54', '2024-12-28 02:38:54'),
(273, 266, '/storage/collectors/676f6f8d65967.png', '2024-12-28 03:25:01', '2024-12-28 03:25:01'),
(274, 267, '/storage/collectors/676f85ab13169.png', '2024-12-28 04:59:23', '2024-12-28 04:59:23'),
(275, 268, '/storage/collectors/676f88d495440.png', '2024-12-28 05:12:52', '2024-12-28 05:12:52'),
(276, 269, '/storage/collectors/676f9a805e305.png', '2024-12-28 06:28:16', '2024-12-28 06:28:16'),
(277, 270, '/storage/collectors/676fa10dda184.png', '2024-12-28 06:56:13', '2024-12-28 06:56:13'),
(278, 271, '/storage/collectors/676fa1a8eb5de.png', '2024-12-28 06:58:48', '2024-12-28 06:58:48'),
(279, 272, '/storage/collectors/676fa395385b2.png', '2024-12-28 07:07:01', '2024-12-28 07:07:01'),
(280, 273, '/storage/collectors/676fa89699bd8.png', '2024-12-28 07:28:22', '2024-12-28 07:28:22'),
(281, 274, '/storage/collectors/676fba4ab510b.png', '2024-12-28 08:43:54', '2024-12-28 08:43:54'),
(282, 275, '/storage/collectors/676fbd00707ac.png', '2024-12-28 08:55:28', '2024-12-28 08:55:28'),
(283, 276, '/storage/collectors/677200a24ed08.png', '2024-12-30 02:08:34', '2024-12-30 02:08:34'),
(284, 277, '/storage/collectors/677203c3d6108.png', '2024-12-30 02:21:55', '2024-12-30 02:21:55'),
(285, 278, '/storage/collectors/677206de37a0f.png', '2024-12-30 02:35:10', '2024-12-30 02:35:10'),
(286, 279, '/storage/collectors/6772070ab83cd.png', '2024-12-30 02:35:54', '2024-12-30 02:35:54'),
(287, 280, '/storage/collectors/67720dd2227a9.png', '2024-12-30 03:04:50', '2024-12-30 03:04:50'),
(288, 281, '/storage/collectors/6772189726348.png', '2024-12-30 03:50:47', '2024-12-30 03:50:47'),
(289, 282, '/storage/collectors/67721ad79af65.png', '2024-12-30 04:00:23', '2024-12-30 04:00:23'),
(290, 283, '/storage/collectors/67721cffe0dcf.png', '2024-12-30 04:09:35', '2024-12-30 04:09:35'),
(291, 284, '/storage/collectors/67721dd5baf74.png', '2024-12-30 04:13:09', '2024-12-30 04:13:09'),
(292, 285, '/storage/collectors/67722304e3fc2.png', '2024-12-30 04:35:16', '2024-12-30 04:35:16'),
(293, 286, '/storage/collectors/677225126396e.png', '2024-12-30 04:44:02', '2024-12-30 04:44:02'),
(294, 287, '/storage/collectors/67722fd2af65b.png', '2024-12-30 05:29:54', '2024-12-30 05:29:54'),
(295, 288, '/storage/collectors/6772425fa1fde.png', '2024-12-30 06:49:03', '2024-12-30 06:49:03'),
(296, 289, '/storage/collectors/67725646479ab.png', '2024-12-30 08:13:58', '2024-12-30 08:13:58'),
(297, 290, '/storage/collectors/677256bef2d39.png', '2024-12-30 08:15:58', '2024-12-30 08:15:58'),
(298, 291, '/storage/collectors/677257784473f.png', '2024-12-30 08:19:04', '2024-12-30 08:19:04'),
(299, 292, '/storage/collectors/67725a989dc6f.png', '2024-12-30 08:32:24', '2024-12-30 08:32:24'),
(300, 293, '/storage/collectors/677264615fad1.png', '2024-12-30 09:14:09', '2024-12-30 09:14:09'),
(301, 294, '/storage/collectors/6773543d2f665.png', '2024-12-31 02:17:33', '2024-12-31 02:17:33'),
(302, 295, '/storage/collectors/67735641da610.png', '2024-12-31 02:26:09', '2024-12-31 02:26:09'),
(303, 296, '/storage/collectors/67735842817d1.png', '2024-12-31 02:34:42', '2024-12-31 02:34:42'),
(304, 297, '/storage/collectors/677358542434b.png', '2024-12-31 02:35:00', '2024-12-31 02:35:00'),
(305, 298, '/storage/collectors/677358b7cdcfc.png', '2024-12-31 02:36:39', '2024-12-31 02:36:39'),
(306, 299, '/storage/collectors/67735aa6dd8d0.png', '2024-12-31 02:44:54', '2024-12-31 02:44:54'),
(307, 300, '/storage/collectors/67735c99f32e6.png', '2024-12-31 02:53:13', '2024-12-31 02:53:13'),
(308, 301, '/storage/collectors/6773611810b6a.png', '2024-12-31 03:12:24', '2024-12-31 03:12:24'),
(309, 302, '/storage/collectors/67736951dde75.png', '2024-12-31 03:47:29', '2024-12-31 03:47:29'),
(310, 303, '/storage/collectors/677370b04b79b.png', '2024-12-31 04:18:56', '2024-12-31 04:18:56'),
(311, 304, '/storage/collectors/677374dbcb1e6.png', '2024-12-31 04:36:43', '2024-12-31 04:36:43'),
(312, 305, '/storage/collectors/6773786127b06.png', '2024-12-31 04:51:45', '2024-12-31 04:51:45'),
(313, 306, '/storage/collectors/67737bb934cf7.png', '2024-12-31 05:06:01', '2024-12-31 05:06:01'),
(314, 307, '/storage/collectors/67737bfa8b911.png', '2024-12-31 05:07:06', '2024-12-31 05:07:06'),
(315, 308, '/storage/collectors/67737ca2d6650.png', '2024-12-31 05:09:54', '2024-12-31 05:09:54'),
(316, 309, '/storage/collectors/6773935cc2777.png', '2024-12-31 06:46:52', '2024-12-31 06:46:52'),
(317, 310, '/storage/collectors/677393fa4215f.png', '2024-12-31 06:49:30', '2024-12-31 06:49:30'),
(318, 311, '/storage/collectors/677395eca3f74.png', '2024-12-31 06:57:48', '2024-12-31 06:57:48'),
(319, 312, '/storage/collectors/6773986b88cc0.png', '2024-12-31 07:08:27', '2024-12-31 07:08:27'),
(320, 313, '/storage/collectors/67739b7ca9f13.png', '2024-12-31 07:21:32', '2024-12-31 07:21:32'),
(321, 314, '/storage/collectors/67739d6b6cebf.png', '2024-12-31 07:29:47', '2024-12-31 07:29:47'),
(322, 315, '/storage/collectors/6773a41dc2ac6.png', '2024-12-31 07:58:21', '2024-12-31 07:58:21'),
(323, 316, '/storage/collectors/6773ac7ed6ccc.png', '2024-12-31 08:34:06', '2024-12-31 08:34:06'),
(324, 317, '/storage/collectors/6775ea23410a9.png', '2025-01-02 01:21:39', '2025-01-02 01:21:39'),
(325, 318, '/storage/collectors/677600431dc57.png', '2025-01-02 02:56:03', '2025-01-02 02:56:03'),
(326, 319, '/storage/collectors/6776022f043e6.png', '2025-01-02 03:04:15', '2025-01-02 03:04:15'),
(327, 320, '/storage/collectors/677611e116634.png', '2025-01-02 04:11:13', '2025-01-02 04:11:13'),
(328, 321, '/storage/collectors/6776149ebed17.png', '2025-01-02 04:22:54', '2025-01-02 04:22:54'),
(329, 322, '/storage/collectors/677617ad5e9e1.png', '2025-01-02 04:35:57', '2025-01-02 04:35:57'),
(330, 323, '/storage/collectors/67761817486fa.png', '2025-01-02 04:37:43', '2025-01-02 04:37:43'),
(331, 324, '/storage/collectors/67761fe9a57fb.png', '2025-01-02 05:11:05', '2025-01-02 05:11:05'),
(332, 325, '/storage/collectors/67762443eb80f.png', '2025-01-02 05:29:39', '2025-01-02 05:29:39'),
(333, 326, '/storage/collectors/677633d8b42cb.png', '2025-01-02 06:36:08', '2025-01-02 06:36:08'),
(334, 327, '/storage/collectors/677638c6ea476.png', '2025-01-02 06:57:10', '2025-01-02 06:57:10'),
(335, 328, '/storage/collectors/67763be75ad97.png', '2025-01-02 07:10:31', '2025-01-02 07:10:31'),
(336, 329, '/storage/collectors/67763cb25a551.png', '2025-01-02 07:13:54', '2025-01-02 07:13:54'),
(337, 330, '/storage/collectors/67763d14af1cd.png', '2025-01-02 07:15:32', '2025-01-02 07:15:32'),
(338, 331, '/storage/collectors/677649c29d4d1.png', '2025-01-02 08:09:38', '2025-01-02 08:09:38'),
(339, 332, '/storage/collectors/67764aa6554cc.png', '2025-01-02 08:13:26', '2025-01-02 08:13:26'),
(340, 333, '/storage/collectors/67764f3289493.png', '2025-01-02 08:32:50', '2025-01-02 08:32:50'),
(341, 334, '/storage/collectors/677742723a253.png', '2025-01-03 01:50:42', '2025-01-03 01:50:42'),
(342, 335, '/storage/collectors/6777456f86f6d.png', '2025-01-03 02:03:27', '2025-01-03 02:03:27'),
(343, 336, '/storage/collectors/677749485da9a.png', '2025-01-03 02:19:52', '2025-01-03 02:19:52'),
(344, 337, '/storage/collectors/67774df7b7202.png', '2025-01-03 02:39:51', '2025-01-03 02:39:51'),
(345, 338, '/storage/collectors/6777533dde767.png', '2025-01-03 03:02:21', '2025-01-03 03:02:21'),
(346, 339, '/storage/collectors/67775a8c4860d.png', '2025-01-03 03:33:32', '2025-01-03 03:33:32'),
(347, 340, '/storage/collectors/67775cb45f56b.png', '2025-01-03 03:42:44', '2025-01-03 03:42:44'),
(348, 341, '/storage/collectors/67775dd27e9fa.png', '2025-01-03 03:47:30', '2025-01-03 03:47:30'),
(349, 342, '/storage/collectors/67775f4ef027a.png', '2025-01-03 03:53:50', '2025-01-03 03:53:50'),
(350, 343, '/storage/collectors/677761afa2129.png', '2025-01-03 04:03:59', '2025-01-03 04:03:59'),
(351, 344, '/storage/collectors/677761fe04989.png', '2025-01-03 04:05:18', '2025-01-03 04:05:18'),
(352, 345, '/storage/collectors/677762b3313e4.png', '2025-01-03 04:08:19', '2025-01-03 04:08:19'),
(353, 346, '/storage/collectors/67776439529ff.png', '2025-01-03 04:14:49', '2025-01-03 04:14:49'),
(354, 347, '/storage/collectors/67776e8c77ee4.png', '2025-01-03 04:58:52', '2025-01-03 04:58:52'),
(355, 348, '/storage/collectors/677770e678f62.png', '2025-01-03 05:08:54', '2025-01-03 05:08:54'),
(356, 349, '/storage/collectors/677781d7f16df.png', '2025-01-03 06:21:11', '2025-01-03 06:21:11'),
(357, 350, '/storage/collectors/67778abd20663.png', '2025-01-03 06:59:09', '2025-01-03 06:59:09'),
(358, 351, '/storage/collectors/677792afbe6e9.png', '2025-01-03 07:33:03', '2025-01-03 07:33:03'),
(359, 352, '/storage/collectors/6777939d6d4ca.png', '2025-01-03 07:37:01', '2025-01-03 07:37:01'),
(360, 353, '/storage/collectors/6777968cbe1c8.png', '2025-01-03 07:49:32', '2025-01-03 07:49:32'),
(361, 354, '/storage/collectors/677796cf8c7d6.png', '2025-01-03 07:50:39', '2025-01-03 07:50:39'),
(362, 355, '/storage/collectors/67779ce109b06.png', '2025-01-03 08:16:33', '2025-01-03 08:16:33'),
(363, 356, '/storage/collectors/67779e56ea397.png', '2025-01-03 08:22:46', '2025-01-03 08:22:46'),
(364, 357, '/storage/collectors/6777a09ad878f.png', '2025-01-03 08:32:26', '2025-01-03 08:32:26'),
(365, 358, '/storage/collectors/677894cccc07b.png', '2025-01-04 01:54:20', '2025-01-04 01:54:20'),
(366, 359, '/storage/collectors/6778a4e4bc904.png', '2025-01-04 03:03:00', '2025-01-04 03:03:00'),
(367, 360, '/storage/collectors/6778a5b9780c0.png', '2025-01-04 03:06:33', '2025-01-04 03:06:33'),
(368, 361, '/storage/collectors/6778a6f10d84c.png', '2025-01-04 03:11:45', '2025-01-04 03:11:45'),
(369, 362, '/storage/collectors/6778a704865a3.png', '2025-01-04 03:12:04', '2025-01-04 03:12:04'),
(370, 363, '/storage/collectors/6778a7907c4b2.png', '2025-01-04 03:14:24', '2025-01-04 03:14:24'),
(371, 364, '/storage/collectors/6778a7dd44f09.png', '2025-01-04 03:15:41', '2025-01-04 03:15:41'),
(372, 365, '/storage/collectors/6778a8305cdf0.png', '2025-01-04 03:17:04', '2025-01-04 03:17:04'),
(373, 366, '/storage/collectors/6778a9b333cd7.png', '2025-01-04 03:23:31', '2025-01-04 03:23:31'),
(374, 367, '/storage/collectors/6778ab48c6a34.png', '2025-01-04 03:30:16', '2025-01-04 03:30:16'),
(375, 368, '/storage/collectors/6778acadc3b95.png', '2025-01-04 03:36:13', '2025-01-04 03:36:13'),
(376, 369, '/storage/collectors/6778b0a0788a8.png', '2025-01-04 03:53:04', '2025-01-04 03:53:04'),
(377, 370, '/storage/collectors/6778b357d4472.png', '2025-01-04 04:04:39', '2025-01-04 04:04:39'),
(378, 371, '/storage/collectors/6778cd6202b95.png', '2025-01-04 05:55:46', '2025-01-04 05:55:46'),
(379, 372, '/storage/collectors/6778ce18bb25b.png', '2025-01-04 05:58:48', '2025-01-04 05:58:48'),
(380, 373, '/storage/collectors/6778d5bc5b2ad.png', '2025-01-04 06:31:24', '2025-01-04 06:31:24'),
(381, 374, '/storage/collectors/6778d6e2908c4.png', '2025-01-04 06:36:18', '2025-01-04 06:36:18'),
(382, 375, '/storage/collectors/677b31b3c5fa9.png', '2025-01-06 01:28:19', '2025-01-06 01:28:19'),
(383, 376, '/storage/collectors/677b33f634fd3.png', '2025-01-06 01:37:58', '2025-01-06 01:37:58'),
(384, 377, '/storage/collectors/677b36efd825a.png', '2025-01-06 01:50:39', '2025-01-06 01:50:39'),
(385, 378, '/storage/collectors/677b452153423.png', '2025-01-06 02:51:13', '2025-01-06 02:51:13'),
(386, 379, '/storage/collectors/677b45dabac93.png', '2025-01-06 02:54:18', '2025-01-06 02:54:18'),
(387, 380, '/storage/collectors/677b46d80a664.png', '2025-01-06 02:58:32', '2025-01-06 02:58:32'),
(388, 381, '/storage/collectors/677b48e5582b9.png', '2025-01-06 03:07:17', '2025-01-06 03:07:17'),
(389, 382, '/storage/collectors/677b4ca54d57b.png', '2025-01-06 03:23:17', '2025-01-06 03:23:17'),
(390, 383, '/storage/collectors/677b53a538b02.png', '2025-01-06 03:53:09', '2025-01-06 03:53:09'),
(391, 384, '/storage/collectors/677b5a4292787.png', '2025-01-06 04:21:22', '2025-01-06 04:21:22'),
(392, 385, '/storage/collectors/677b627a6ccd7.png', '2025-01-06 04:56:26', '2025-01-06 04:56:26'),
(393, 386, '/storage/collectors/677b78a8e5d48.png', '2025-01-06 06:31:04', '2025-01-06 06:31:04'),
(394, 387, '/storage/collectors/677b7ab578175.png', '2025-01-06 06:39:49', '2025-01-06 06:39:49'),
(395, 388, '/storage/collectors/677b7e1434b95.png', '2025-01-06 06:54:12', '2025-01-06 06:54:12'),
(396, 389, '/storage/collectors/677b7fb854dd8.png', '2025-01-06 07:01:12', '2025-01-06 07:01:12'),
(397, 390, '/storage/collectors/677b82bf3c5b2.png', '2025-01-06 07:14:07', '2025-01-06 07:14:07'),
(398, 391, '/storage/collectors/677b8797a35d8.png', '2025-01-06 07:34:47', '2025-01-06 07:34:47'),
(399, 392, '/storage/collectors/677b8ea691c0b.png', '2025-01-06 08:04:54', '2025-01-06 08:04:54'),
(400, 393, '/storage/collectors/677b91f999021.png', '2025-01-06 08:19:05', '2025-01-06 08:19:05'),
(401, 394, '/storage/collectors/677b989172a33.png', '2025-01-06 08:47:13', '2025-01-06 08:47:13'),
(402, 395, '/storage/collectors/677b98b329c83.png', '2025-01-06 08:47:47', '2025-01-06 08:47:47'),
(403, 396, '/storage/collectors/677b99fb74a0b.png', '2025-01-06 08:53:15', '2025-01-06 08:53:15');

-- --------------------------------------------------------

--
-- Table structure for table `tb_placement`
--

CREATE TABLE `tb_placement` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_penempatan` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `penempatan` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `radius` int DEFAULT NULL,
  `restrict_app` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_placement`
--

INSERT INTO `tb_placement` (`id`, `kode_penempatan`, `penempatan`, `alamat`, `longitude`, `latitude`, `radius`, `restrict_app`, `created_at`, `updated_at`) VALUES
(5, 'MDN01', 'Kantor Pusat', 'Jl. Glugur No 18D', '98.66902828216554', '3.591516090416829', 99999999, 't', '2024-09-29 20:26:07', '2024-10-03 08:16:13'),
(7, 'MDN03', 'Cabang Tembung', 'Jl. Gambir Ps. VIII No.88, Tembung', '3.40576171875', '1.142502403706165', 0, 't', '2024-09-29 21:32:41', '2024-10-04 04:49:08'),
(8, 'MDN04', 'Cabang Titi Kuning', 'Jl. Brig Jend. Zein Hamid No.KM 7.6, Titi Kuning', '98.6690390110016', '3.5914732593566807', 150, 'y', '2024-09-29 21:33:19', '2024-10-04 04:49:15'),
(10, 'PKU001', 'Cabang PKU', 'Jl. Hangtuah SP IV', '101.831765', '0.424643', 50, 't', '2024-11-22 09:22:55', '2024-11-22 09:23:53');

-- --------------------------------------------------------

--
-- Table structure for table `tb_salary`
--

CREATE TABLE `tb_salary` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_pegawai` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payroll_type` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salary_fee` double DEFAULT NULL,
  `period` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_salary`
--

INSERT INTO `tb_salary` (`id`, `kode_pegawai`, `payroll_type`, `salary_fee`, `period`, `created_at`, `updated_at`) VALUES
(1, '28101999', 'monthly', 4000000, '2024-11-01', '2024-11-01 09:51:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_pegawai` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `kode_pegawai`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Muhammad Abdi Mayu', 'abdi@darkotech.id', NULL, '$2y$12$8PjfWYlAsiKTobWYA/mJcOzLDiXHh2sKfcabhkJelMx8oSftf8MOq', '7nK6OEYmT6YJdQiGxjDngGSkHwvqvD86Qc1grjOnjhTYdqwsCY8FRaiu74VK', '2024-10-01 09:55:37', '2024-10-11 03:59:31'),
(1005, NULL, 'HRD', 'hrd@indodacin.com', NULL, '$2y$12$r559G0XgTTGuffzDo25m3Oa58tE/6UYs3ipk.ddfmR0jA/GyJe08y', 'EJL3qG8PHuTNOAO0XP2oBR4lhs3WixTIR6qB6esYEgoZ4jltqT7DyQ5hQlpK', '2024-10-12 02:33:03', '2024-10-12 02:33:03'),
(1006, '28101999', 'Muhammad Abdi Mayu', 'user@indodacin.com', NULL, '$2y$12$mGyAhmMwQcW2OCA2aq/.4OImmLuBATJevl8hHkCJofp7bzc/LuSJ2', '9ocgVn7k1wYA41en9RdjYDZMViglpHHWa741ejTX6UsuFsYyRaWOQ89SKoKA', '2024-10-14 06:27:29', '2024-10-14 06:27:29'),
(1020, '112233', 'Muhammad Taufik', 'Taufik112233@indodacin.com', NULL, '$2y$12$G9cSVa/4XV7jzxD5PAuv/O4Re3X1c6n.gZmbkDp16dmqq1ccuBF8W', 'JhM5fTpUZO0NL9yI186Gg5ANDwc5tvcj9UgYsmBEfo3KpmMni4hsXxMX7OZy', '2024-11-13 06:26:34', '2024-11-13 06:26:34'),
(1021, '315', 'Oky Sandy Sirait', 'Oky315@indodacin.com', NULL, '$2y$12$bT4ozWQKBux59/PnMjsoqeeuK0xgCz6rIbGy4PI5Ln.ZlckuYu9ky', 'fvOVCfeo2cY2oZyQ5H0WxO1sez63saG72FPvqUT3pdZeCqke8eyIdTiykh54', '2024-11-13 06:49:35', '2024-11-13 06:49:35'),
(1022, '344', 'Bernard Samuel Sianturi', 'Bernard344@indodacin.com', NULL, '$2y$12$9N4Bb1rtlL6.fCuw.JqHEeJTouO4YzmUHaoFX.u1nnKn76NkR8RdS', 'mnncqIp46ccwJMV58C8Eqb3s74fYtQ2HGzi0v2NDQSD2XwQffAsmJJnF6LOL', '2024-11-13 07:54:12', '2024-11-13 07:54:12'),
(1023, NULL, 'Alfred', 'alfred@indodacin.com', NULL, '$2y$12$n6m6t7//WBdsDLbtfA6R0On4O/NauwYM1mUIgdnIf/Wdl5umrkWtK', NULL, '2024-11-13 08:27:17', '2024-11-13 08:27:17'),
(1024, '123123', 'Abdul Khalid Hasibuan', 'Abdul123123@indodacin.com', NULL, '$2y$12$5yIUHQsV62okHXnPPddjQeLIhZIMrqOIDk/PbqmFcq81uuCqYXTeW', NULL, '2024-11-13 09:09:43', '2024-11-13 09:09:43'),
(1026, '31450', 'PUPUT JULIANTI', 'PUPUT31450@indodacin.com', NULL, '$2y$12$Zz8Q4Dg9CBBggJz6o6xj0O/pbpeB2G5oxAkZp2sUvV7BvGGiyEZEG', 'WRT5mVclvOSL3ZQDslnz1oRF3RjZ5BXSkGGAyRgYPFXuxq3tPPKaREDnNDkk', '2024-11-18 03:53:42', '2024-11-18 03:53:42'),
(1028, '1105', 'Collector', 'collector1105@indodacin.com', NULL, '$2y$12$PZta6yKJmoXceTT1qwEj9.MS1wXRFQg33LyATG8GIhjOb.6XjOxHK', NULL, '2024-11-29 11:06:48', '2024-11-29 11:06:48'),
(1029, '394', 'KEVIN FRANSETIO', 'kevin394@indodacin.com', NULL, '$2y$12$ucj2xQahpLu8nDPwVBC9y.pgItSaae0wGkh8HIyqiiUOU73.DgxC6', 'Ged7Y6FNtRPKO8jFJFTP0ci5T9NmIAcyvRPNLYGzdj5Bio9JlVGf0zzBTuEj', '2024-11-29 13:56:28', '2024-11-29 13:56:28'),
(1030, '493', 'JOHAN', 'johan493@indodacin.com', NULL, '$2y$12$sNBpupdJQUTF5TflzRmRuOM0MLvDk/wSBO0BaOyBqLn6sQ.FEdKU6', 'H3i21uYf7cOZfPLBwsuaJUDjDWAUySzrslJWjgBfOPAEuepAOLg1Dh7StkLy', '2024-12-11 09:28:25', '2024-12-11 09:28:25'),
(1031, '74', 'TRI AJI SISWOYO NASUTION', 'aji74@indodacin.com', NULL, '$2y$12$aRBZpFUA6xW7XxhvFtt7QusV7cXldlbHaOjcjPpsDFpCYFyf62yMO', '9HPaAsLpUiqoFLDxAhxdB1F7V5fUr4v6pPGHSNlae4kSfUs8DY077iALlxYC', '2024-12-11 09:29:14', '2024-12-11 09:29:14'),
(1032, '439', 'TRISNA ADE NINGSIH', 'ade439@indodacin.com', NULL, '$2y$12$DZ8ZuVTq1MNV5Aj9oloocOZwaonJ6uewL4tM51m2J5ydaJ.3a6XQ2', NULL, '2024-12-16 01:12:09', '2024-12-17 09:16:20'),
(1033, '437', 'MARCELINA SIANTURI', 'marcelina437@indodacin.com', NULL, '$2y$12$/zLm/CS59/ro7F27dYUD5uOOO5ZXKktk4viHYXfgvacAtmVz6Wqwu', 'YIDMCjimw0hDBjueUxSkBWHGjKN0KdSqdCwE1bwN0SaMkEywHQlbEW50NflE', '2024-12-16 03:26:12', '2024-12-16 03:27:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

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
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

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
-- Indexes for table `tb_allowance`
--
ALTER TABLE `tb_allowance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `allowance_to_pegawai` (`kode_pegawai`);

--
-- Indexes for table `tb_attendance`
--
ALTER TABLE `tb_attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kode_pegawai` (`kode_pegawai`);

--
-- Indexes for table `tb_attendance_out`
--
ALTER TABLE `tb_attendance_out`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kode_pegawai` (`kode_pegawai`),
  ADD KEY `kode_pegawai_2` (`kode_pegawai`),
  ADD KEY `kode_pegawai_3` (`kode_pegawai`),
  ADD KEY `kode_pegawai_4` (`kode_pegawai`);

--
-- Indexes for table `tb_collect`
--
ALTER TABLE `tb_collect`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_dayoff`
--
ALTER TABLE `tb_dayoff`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `tb_deduction`
--
ALTER TABLE `tb_deduction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kode_pegawai` (`kode_pegawai`);

--
-- Indexes for table `tb_division`
--
ALTER TABLE `tb_division`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_golongan`
--
ALTER TABLE `tb_golongan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_jabatan`
--
ALTER TABLE `tb_jabatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penempatan` (`penempatan`),
  ADD KEY `divisi` (`divisi`);

--
-- Indexes for table `tb_jadwal`
--
ALTER TABLE `tb_jadwal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_golongan` (`id_golongan`);

--
-- Indexes for table `tb_log`
--
ALTER TABLE `tb_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tb_overtime`
--
ALTER TABLE `tb_overtime`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kode_pegawai` (`kode_pegawai`);

--
-- Indexes for table `tb_pegawai`
--
ALTER TABLE `tb_pegawai`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_pegawai` (`kode_pegawai`),
  ADD UNIQUE KEY `salary_id_2` (`salary_id`),
  ADD KEY `salary_id` (`salary_id`),
  ADD KEY `golongan` (`golongan`),
  ADD KEY `jabatan` (`jabatan`);

--
-- Indexes for table `tb_photo_collect`
--
ALTER TABLE `tb_photo_collect`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_photo_collect_id_collect_foreign` (`id_collect`);

--
-- Indexes for table `tb_placement`
--
ALTER TABLE `tb_placement`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tb_placement_kode_penempatan_unique` (`kode_penempatan`);

--
-- Indexes for table `tb_salary`
--
ALTER TABLE `tb_salary`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_pegawai` (`kode_pegawai`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `user_to_pegawai` (`kode_pegawai`);

--
-- AUTO_INCREMENT for dumped tables
--

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
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tb_allowance`
--
ALTER TABLE `tb_allowance`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `tb_attendance`
--
ALTER TABLE `tb_attendance`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `tb_attendance_out`
--
ALTER TABLE `tb_attendance_out`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=246;

--
-- AUTO_INCREMENT for table `tb_collect`
--
ALTER TABLE `tb_collect`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=397;

--
-- AUTO_INCREMENT for table `tb_dayoff`
--
ALTER TABLE `tb_dayoff`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tb_deduction`
--
ALTER TABLE `tb_deduction`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_division`
--
ALTER TABLE `tb_division`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96514;

--
-- AUTO_INCREMENT for table `tb_golongan`
--
ALTER TABLE `tb_golongan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tb_jabatan`
--
ALTER TABLE `tb_jabatan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tb_jadwal`
--
ALTER TABLE `tb_jadwal`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `tb_log`
--
ALTER TABLE `tb_log`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2881;

--
-- AUTO_INCREMENT for table `tb_overtime`
--
ALTER TABLE `tb_overtime`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_pegawai`
--
ALTER TABLE `tb_pegawai`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10000000015;

--
-- AUTO_INCREMENT for table `tb_photo_collect`
--
ALTER TABLE `tb_photo_collect`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=404;

--
-- AUTO_INCREMENT for table `tb_placement`
--
ALTER TABLE `tb_placement`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tb_salary`
--
ALTER TABLE `tb_salary`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1034;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `model_to_user` FOREIGN KEY (`model_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tb_allowance`
--
ALTER TABLE `tb_allowance`
  ADD CONSTRAINT `allowance_to_pegawai` FOREIGN KEY (`kode_pegawai`) REFERENCES `tb_pegawai` (`kode_pegawai`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_attendance`
--
ALTER TABLE `tb_attendance`
  ADD CONSTRAINT `in_to_pegawai` FOREIGN KEY (`kode_pegawai`) REFERENCES `tb_pegawai` (`kode_pegawai`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_attendance_out`
--
ALTER TABLE `tb_attendance_out`
  ADD CONSTRAINT `out_to_pegawai` FOREIGN KEY (`kode_pegawai`) REFERENCES `tb_pegawai` (`kode_pegawai`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_dayoff`
--
ALTER TABLE `tb_dayoff`
  ADD CONSTRAINT `dayoff_to_pegawai` FOREIGN KEY (`id_user`) REFERENCES `tb_pegawai` (`kode_pegawai`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_deduction`
--
ALTER TABLE `tb_deduction`
  ADD CONSTRAINT `deduction_to_pegawai` FOREIGN KEY (`kode_pegawai`) REFERENCES `tb_pegawai` (`kode_pegawai`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_jabatan`
--
ALTER TABLE `tb_jabatan`
  ADD CONSTRAINT `jabatan_to_divisi` FOREIGN KEY (`divisi`) REFERENCES `tb_division` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jabatan_to_placement` FOREIGN KEY (`penempatan`) REFERENCES `tb_placement` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_jadwal`
--
ALTER TABLE `tb_jadwal`
  ADD CONSTRAINT `jadwal_to_golongan` FOREIGN KEY (`id_golongan`) REFERENCES `tb_golongan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_log`
--
ALTER TABLE `tb_log`
  ADD CONSTRAINT `log_to_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_overtime`
--
ALTER TABLE `tb_overtime`
  ADD CONSTRAINT `overtime_to_pegawai` FOREIGN KEY (`kode_pegawai`) REFERENCES `tb_pegawai` (`kode_pegawai`) ON DELETE CASCADE ON UPDATE SET NULL;

--
-- Constraints for table `tb_pegawai`
--
ALTER TABLE `tb_pegawai`
  ADD CONSTRAINT `pegawai_to_golongan` FOREIGN KEY (`golongan`) REFERENCES `tb_golongan` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `pegawai_to_jabatan` FOREIGN KEY (`jabatan`) REFERENCES `tb_jabatan` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `pegawai_to_salary` FOREIGN KEY (`salary_id`) REFERENCES `tb_salary` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `tb_photo_collect`
--
ALTER TABLE `tb_photo_collect`
  ADD CONSTRAINT `tb_photo_collect_id_collect_foreign` FOREIGN KEY (`id_collect`) REFERENCES `tb_collect` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tb_salary`
--
ALTER TABLE `tb_salary`
  ADD CONSTRAINT `salary_to_pegawai` FOREIGN KEY (`kode_pegawai`) REFERENCES `tb_pegawai` (`kode_pegawai`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `user_to_pegawai` FOREIGN KEY (`kode_pegawai`) REFERENCES `tb_pegawai` (`kode_pegawai`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
