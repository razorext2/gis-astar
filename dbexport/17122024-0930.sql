-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 17, 2024 at 02:30 AM
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
('collect1105@indodacin.com|192.168.11.20', 'i:1;', 1734312480),
('collect1105@indodacin.com|192.168.11.20:timer', 'i:1734312480;', 1734312480),
('piutang@acc-fin.indodacin.com|192.168.11.226', 'i:1;', 1734321835),
('piutang@acc-fin.indodacin.com|192.168.11.226:timer', 'i:1734321835;', 1734321835),
('spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:51:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:10:\"users-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:12:\"users-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:10:\"users-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:12:\"users-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:10:\"roles-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:12:\"roles-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:10:\"roles-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:12:\"roles-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:16:\"permissions-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:18:\"permissions-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:16:\"permissions-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:18:\"permissions-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:12;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:11:\"divisi-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:13;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:13:\"divisi-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:14;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:11:\"divisi-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:15;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:13:\"divisi-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:16;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:14:\"placement-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:17;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:16:\"placement-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:18;a:4:{s:1:\"a\";i:27;s:1:\"b\";s:14:\"placement-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:19;a:4:{s:1:\"a\";i:28;s:1:\"b\";s:16:\"placement-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:20;a:4:{s:1:\"a\";i:29;s:1:\"b\";s:13:\"golongan-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:21;a:4:{s:1:\"a\";i:30;s:1:\"b\";s:15:\"golongan-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:22;a:4:{s:1:\"a\";i:31;s:1:\"b\";s:13:\"golongan-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:23;a:4:{s:1:\"a\";i:32;s:1:\"b\";s:15:\"golongan-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:24;a:4:{s:1:\"a\";i:33;s:1:\"b\";s:12:\"jabatan-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:25;a:4:{s:1:\"a\";i:34;s:1:\"b\";s:14:\"jabatan-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:26;a:4:{s:1:\"a\";i:35;s:1:\"b\";s:12:\"jabatan-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:27;a:4:{s:1:\"a\";i:36;s:1:\"b\";s:14:\"jabatan-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:28;a:4:{s:1:\"a\";i:37;s:1:\"b\";s:12:\"pegawai-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:29;a:4:{s:1:\"a\";i:38;s:1:\"b\";s:14:\"pegawai-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:30;a:4:{s:1:\"a\";i:39;s:1:\"b\";s:12:\"pegawai-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:31;a:4:{s:1:\"a\";i:40;s:1:\"b\";s:14:\"pegawai-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:32;a:4:{s:1:\"a\";i:41;s:1:\"b\";s:8:\"log-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:33;a:4:{s:1:\"a\";i:42;s:1:\"b\";s:10:\"log-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:7;i:3;i:8;i:4;i:9;i:5;i:10;i:6;i:11;}}i:34;a:4:{s:1:\"a\";i:43;s:1:\"b\";s:8:\"log-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:35;a:4:{s:1:\"a\";i:44;s:1:\"b\";s:10:\"log-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:36;a:4:{s:1:\"a\";i:45;s:1:\"b\";s:11:\"dayoff-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:1;i:1;i:2;i:2;i:8;i:3;i:9;i:4;i:10;}}i:37;a:4:{s:1:\"a\";i:46;s:1:\"b\";s:13:\"dayoff-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:8;i:2;i:9;i:3;i:10;}}i:38;a:4:{s:1:\"a\";i:47;s:1:\"b\";s:11:\"dayoff-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:8;i:2;i:9;i:3;i:10;}}i:39;a:4:{s:1:\"a\";i:48;s:1:\"b\";s:13:\"dayoff-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:40;a:4:{s:1:\"a\";i:49;s:1:\"b\";s:13:\"dayoff-detail\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:1;i:1;i:2;i:2;i:8;i:3;i:9;i:4;i:10;}}i:41;a:4:{s:1:\"a\";i:50;s:1:\"b\";s:14:\"dayoff-confirm\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:42;a:4:{s:1:\"a\";i:51;s:1:\"b\";s:7:\"capture\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:7;i:2;i:9;i:3;i:10;}}i:43;a:4:{s:1:\"a\";i:53;s:1:\"b\";s:16:\"pegawai-timeline\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:44;a:4:{s:1:\"a\";i:54;s:1:\"b\";s:9:\"dashboard\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:45;a:4:{s:1:\"a\";i:55;s:1:\"b\";s:14:\"dashboard-user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:1;i:1;i:7;i:2;i:9;i:3;i:10;i:4;i:11;}}i:46;a:4:{s:1:\"a\";i:56;s:1:\"b\";s:12:\"collect-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:11;i:2;i:12;}}i:47;a:4:{s:1:\"a\";i:57;s:1:\"b\";s:14:\"collect-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:11;}}i:48;a:4:{s:1:\"a\";i:58;s:1:\"b\";s:12:\"collect-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:11;i:2;i:12;}}i:49;a:4:{s:1:\"a\";i:59;s:1:\"b\";s:14:\"collect-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:50;a:4:{s:1:\"a\";i:60;s:1:\"b\";s:15:\"collect-approve\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:12;}}}s:5:\"roles\";a:8:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"Admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:3:\"HRD\";s:1:\"c\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:8;s:1:\"b\";s:10:\"Management\";s:1:\"c\";s:3:\"web\";}i:3;a:3:{s:1:\"a\";i:7;s:1:\"b\";s:8:\"Employee\";s:1:\"c\";s:3:\"web\";}i:4;a:3:{s:1:\"a\";i:9;s:1:\"b\";s:7:\"Teknisi\";s:1:\"c\";s:3:\"web\";}i:5;a:3:{s:1:\"a\";i:10;s:1:\"b\";s:6:\"Driver\";s:1:\"c\";s:3:\"web\";}i:6;a:3:{s:1:\"a\";i:11;s:1:\"b\";s:9:\"Collector\";s:1:\"c\";s:3:\"web\";}i:7;a:3:{s:1:\"a\";i:12;s:1:\"b\";s:7:\"Piutang\";s:1:\"c\";s:3:\"web\";}}}', 1734485188);

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
('czokjAXEneL8uco6dV1JuLFplLQP5bNHnZX1CxgU', NULL, '114.122.23.92', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSHc4cndqQmZhMW5hYWJFNmdCWWtGWGhNdm8yaTNGQWwxdklKR1g0NyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly9pbmRvZGFjaW4ubnVzYS5uZXQuaWQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1734396758),
('fv0r6Zg6z8KJXQfzlj7QV3glRDmFJN0xYW7MMAhN', 1030, '114.122.8.124', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiT215UnVNenp6eTB1akJhVnY0dnNXdFNJazJwZ21Lb2tzU3ZLRW05TSI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTAzMDtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0NjoiaHR0cDovL2luZG9kYWNpbi5udXNhLm5ldC5pZC9kYXNoYm9hcmQvcHJvZmlsZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1734397499),
('GRmRJGJ4mvk0lmWGOAZglLAbICVwhUcGBUn7dRIw', 1031, '114.122.23.92', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiRklzRzFhT1BubGhYcXNQZHowMFlGdkwzUlZORkt3N3FuTHg4RVdtTyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDY6Imh0dHA6Ly9pbmRvZGFjaW4ubnVzYS5uZXQuaWQvZGFzaGJvYXJkL2NvbGxlY3QiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjM6InVybCI7YTowOnt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTAzMTt9', 1734402352),
('jsLdFzNWs9NCzyDbQkIVOudUM9nK8p90Ytln1fMJ', NULL, '114.122.23.92', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidE5ESXhFaVNZNG1IWTlucFpvN3lWd2ZlRGlrNTVMUFFxR2g3SjVGbCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly9pbmRvZGFjaW4ubnVzYS5uZXQuaWQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1734396757),
('PMVaaP8TMlIutyxjXbNIz3I1F1ri6oU1syfkLYej', NULL, '114.122.23.92', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSThCZTZXS2RjYzg0MUpPc3NlcVNjSVlWUmVSY2FweVFoNmRLVzB3TiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0NjoiaHR0cDovL2luZG9kYWNpbi5udXNhLm5ldC5pZC9kYXNoYm9hcmQvY29sbGVjdCI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQ2OiJodHRwOi8vaW5kb2RhY2luLm51c2EubmV0LmlkL2Rhc2hib2FyZC9jb2xsZWN0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1734396757),
('Q9n706roPdqO0aBfKVH7MgIg164tw3m7iFRQ4zXu', 1, '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNjJYb3R0TXczRVpNcUE1V1ZpS3lMR3Y2Y1B4ak4zNVJsVmNxUmhOQiI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQ2OiJodHRwOi8vaW5kb2RhY2luLm51c2EubmV0LmlkL2Rhc2hib2FyZC9jb2xsZWN0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1734402594),
('rQqB7f2UXDn0JFuRcadGXQhWNLPxQUjHGbI7eE5H', 1032, '192.168.11.235', 'Mozilla/5.0 (Windows NT 6.1; rv:107.0) Gecko/20100101 Firefox/107.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidzBxNDE4N3NIQnZ5YVdPSE9semFGRzk0MFlIeU91UWtQdDJ5QVN4TiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDY6Imh0dHA6Ly9pbmRvZGFjaW4ubnVzYS5uZXQuaWQvZGFzaGJvYXJkL2NvbGxlY3QiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxMDMyO30=', 1734402260);

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
(82, '28101999', 0, 0, 0, 0, 'Wajah', '2024-12-12 08:57:13', 1, '2024-12-12 08:57:13', NULL, NULL, '2810199920241212_085713', '2024-12-12 01:57:13', '2024-12-12 01:57:13');

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
(223, '28101999', 0, 0, 0, 0, 'Wajah', '2024-12-12 08:57:48', 1, '2024-12-12 08:57:48', NULL, NULL, '2810199920241212_085747', '2024-12-12 01:57:48', '2024-12-12 01:57:48'),
(224, '28101999', 0, 0, 0, 0, 'Wajah', '2024-12-12 09:11:03', 1, '2024-12-12 09:11:03', '98.6717587', '3.5935856', '2810199920241212_091103', '2024-12-12 02:11:03', '2024-12-12 02:11:03'),
(225, '28101999', 0, 0, 0, 0, 'Wajah', '2024-12-12 09:11:30', 1, '2024-12-12 09:11:30', NULL, NULL, '2810199920241212_091130', '2024-12-12 02:11:30', '2024-12-12 02:11:30'),
(226, '28101999', 0, 0, 0, 0, 'Wajah', '2024-12-12 09:12:06', 1, '2024-12-12 09:12:06', NULL, NULL, '2810199920241212_091205', '2024-12-12 02:12:06', '2024-12-12 02:12:06'),
(227, '28101999', 0, 0, 0, 0, 'Wajah', '2024-12-12 09:12:56', 1, '2024-12-12 09:12:56', '98.6717587', '3.5935856', '2810199920241212_091255', '2024-12-12 02:12:56', '2024-12-12 02:12:56'),
(228, '28101999', 0, 0, 0, 0, 'Wajah', '2024-12-12 09:18:52', 1, '2024-12-12 09:18:52', '98.6717587', '3.5935856', '2810199920241212_091850', '2024-12-12 02:18:52', '2024-12-12 02:18:52');

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
(91, '74', 'PT persadanusa nabati Indonesia', '<p>Tanda terima ok ya</p><p>Sama pak satpam namanya Hendra </p>', 'Komp graha metropolitan blok t7', '98.6473643', '3.6260927', 0, NULL, '2024-12-17 01:21:51', '2024-12-17 01:21:51'),
(92, '74', 'PT Garuda mas perkasa', '<p>Antar sertifikat tera </p><p>Satpam namanya Sri rejeki </p>', 'Jln yos Sudarso km 6.5', '98.6684441', '3.6361453', 0, NULL, '2024-12-17 01:42:49', '2024-12-17 01:42:49'),
(93, '74', 'PT industri karet deli', '<p>Antar surat tera</p>', 'Jln yos Sudarso km 8.3', '98.6613974', '3.6537653', 0, NULL, '2024-12-17 02:04:16', '2024-12-17 02:04:16'),
(94, '74', 'PT Mabar feed indonesi', '<p>Gak bisa di TT </p>', 'Jln rumah potong hewan', '98.6685424', '3.658237', 0, NULL, '2024-12-17 02:25:49', '2024-12-17 02:25:49');

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
(28, 'Collector', 96513, 5, '2024-11-29 11:06:05', '2024-11-29 11:06:05');

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
(2519, 1032, 'generated::ZaWUeMmamQFkt8Oa > create', '192.168.11.235', 'Mozilla/5.0 (Windows NT 6.1; rv:107.0) Gecko/20100101 Firefox/107.0', 'Unknown', '2024-12-17 02:23:47', '2024-12-17 02:23:47');

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
(101, 94, '/storage/collectors/6760e12d4adcc.png', '2024-12-17 02:25:49', '2024-12-17 02:25:49');

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
(1, NULL, 'Muhammad Abdi Mayu', 'abdi@darkotech.id', NULL, '$2y$12$8PjfWYlAsiKTobWYA/mJcOzLDiXHh2sKfcabhkJelMx8oSftf8MOq', 'gOZm7JD23cqQo00fc0f1ajq6OqDIMZWwfs2ZpXJ8PFJIWVKuFdR5eBV1Gbgq', '2024-10-01 09:55:37', '2024-10-11 03:59:31'),
(1005, NULL, 'HRD', 'hrd@indodacin.com', NULL, '$2y$12$r559G0XgTTGuffzDo25m3Oa58tE/6UYs3ipk.ddfmR0jA/GyJe08y', 'EJL3qG8PHuTNOAO0XP2oBR4lhs3WixTIR6qB6esYEgoZ4jltqT7DyQ5hQlpK', '2024-10-12 02:33:03', '2024-10-12 02:33:03'),
(1006, '28101999', 'Muhammad Abdi Mayu', 'user@indodacin.com', NULL, '$2y$12$mGyAhmMwQcW2OCA2aq/.4OImmLuBATJevl8hHkCJofp7bzc/LuSJ2', 'GeqeDimDZ0sOYLPneAnj4Q5A00TpoRigV1dIu48MX7ysR78c8sn0xkMS6hRJ', '2024-10-14 06:27:29', '2024-10-14 06:27:29'),
(1020, '112233', 'Muhammad Taufik', 'Taufik112233@indodacin.com', NULL, '$2y$12$G9cSVa/4XV7jzxD5PAuv/O4Re3X1c6n.gZmbkDp16dmqq1ccuBF8W', 'JhM5fTpUZO0NL9yI186Gg5ANDwc5tvcj9UgYsmBEfo3KpmMni4hsXxMX7OZy', '2024-11-13 06:26:34', '2024-11-13 06:26:34'),
(1021, '315', 'Oky Sandy Sirait', 'Oky315@indodacin.com', NULL, '$2y$12$bT4ozWQKBux59/PnMjsoqeeuK0xgCz6rIbGy4PI5Ln.ZlckuYu9ky', 'fvOVCfeo2cY2oZyQ5H0WxO1sez63saG72FPvqUT3pdZeCqke8eyIdTiykh54', '2024-11-13 06:49:35', '2024-11-13 06:49:35'),
(1022, '344', 'Bernard Samuel Sianturi', 'Bernard344@indodacin.com', NULL, '$2y$12$9N4Bb1rtlL6.fCuw.JqHEeJTouO4YzmUHaoFX.u1nnKn76NkR8RdS', 'mnncqIp46ccwJMV58C8Eqb3s74fYtQ2HGzi0v2NDQSD2XwQffAsmJJnF6LOL', '2024-11-13 07:54:12', '2024-11-13 07:54:12'),
(1023, NULL, 'Alfred', 'alfred@indodacin.com', NULL, '$2y$12$n6m6t7//WBdsDLbtfA6R0On4O/NauwYM1mUIgdnIf/Wdl5umrkWtK', NULL, '2024-11-13 08:27:17', '2024-11-13 08:27:17'),
(1024, '123123', 'Abdul Khalid Hasibuan', 'Abdul123123@indodacin.com', NULL, '$2y$12$5yIUHQsV62okHXnPPddjQeLIhZIMrqOIDk/PbqmFcq81uuCqYXTeW', NULL, '2024-11-13 09:09:43', '2024-11-13 09:09:43'),
(1026, '31450', 'PUPUT JULIANTI', 'PUPUT31450@indodacin.com', NULL, '$2y$12$Zz8Q4Dg9CBBggJz6o6xj0O/pbpeB2G5oxAkZp2sUvV7BvGGiyEZEG', 'WRT5mVclvOSL3ZQDslnz1oRF3RjZ5BXSkGGAyRgYPFXuxq3tPPKaREDnNDkk', '2024-11-18 03:53:42', '2024-11-18 03:53:42'),
(1028, '1105', 'Collector', 'collector1105@indodacin.com', NULL, '$2y$12$PZta6yKJmoXceTT1qwEj9.MS1wXRFQg33LyATG8GIhjOb.6XjOxHK', NULL, '2024-11-29 11:06:48', '2024-11-29 11:06:48'),
(1029, '394', 'KEVIN FRANSETIO', 'kevin394@indodacin.com', NULL, '$2y$12$ucj2xQahpLu8nDPwVBC9y.pgItSaae0wGkh8HIyqiiUOU73.DgxC6', NULL, '2024-11-29 13:56:28', '2024-11-29 13:56:28'),
(1030, '493', 'JOHAN', 'johan493@indodacin.com', NULL, '$2y$12$sNBpupdJQUTF5TflzRmRuOM0MLvDk/wSBO0BaOyBqLn6sQ.FEdKU6', 'mcb6Gkgti3JCERCXkuEI7X6C438usccI2jgQCOkk7RNkQ1iiuZJZ4mC7Ahgx', '2024-12-11 09:28:25', '2024-12-11 09:28:25'),
(1031, '74', 'TRI AJI SISWOYO NASUTION', 'aji74@indodacin.com', NULL, '$2y$12$aRBZpFUA6xW7XxhvFtt7QusV7cXldlbHaOjcjPpsDFpCYFyf62yMO', 'PnnKwPu3vf5UeiwuDmnpHYMgsUrT8P1PyWPXxeBIUAda9k1rXoE3pBL6MLrf', '2024-12-11 09:29:14', '2024-12-11 09:29:14'),
(1032, '439', 'RISNA ADE NINGSIH', 'ade439@indodacin.com', NULL, '$2y$12$DZ8ZuVTq1MNV5Aj9oloocOZwaonJ6uewL4tM51m2J5ydaJ.3a6XQ2', NULL, '2024-12-16 01:12:09', '2024-12-16 01:12:09'),
(1033, '437', 'MARCELINA SIANTURI', 'marcelina437@indodacin.com', NULL, '$2y$12$/zLm/CS59/ro7F27dYUD5uOOO5ZXKktk4viHYXfgvacAtmVz6Wqwu', NULL, '2024-12-16 03:26:12', '2024-12-16 03:27:00');

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `tb_attendance_out`
--
ALTER TABLE `tb_attendance_out`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=229;

--
-- AUTO_INCREMENT for table `tb_collect`
--
ALTER TABLE `tb_collect`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2520;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

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
