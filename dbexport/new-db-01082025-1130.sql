-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 08, 2025 at 04:30 AM
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
('current_date', 's:15:\"20250108_091507\";', 1736302517),
('spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:57:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:10:\"users-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:12:\"users-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:10:\"users-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:12:\"users-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:10:\"roles-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:12:\"roles-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:10:\"roles-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:12:\"roles-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:16:\"permissions-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:18:\"permissions-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:16:\"permissions-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:18:\"permissions-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:12;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:11:\"divisi-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:13;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:13:\"divisi-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:14;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:11:\"divisi-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:15;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:13:\"divisi-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:16;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:14:\"placement-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:17;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:16:\"placement-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:18;a:4:{s:1:\"a\";i:27;s:1:\"b\";s:14:\"placement-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:19;a:4:{s:1:\"a\";i:28;s:1:\"b\";s:16:\"placement-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:20;a:4:{s:1:\"a\";i:29;s:1:\"b\";s:13:\"golongan-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:21;a:4:{s:1:\"a\";i:30;s:1:\"b\";s:15:\"golongan-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:22;a:4:{s:1:\"a\";i:31;s:1:\"b\";s:13:\"golongan-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:23;a:4:{s:1:\"a\";i:32;s:1:\"b\";s:15:\"golongan-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:24;a:4:{s:1:\"a\";i:33;s:1:\"b\";s:12:\"jabatan-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:25;a:4:{s:1:\"a\";i:34;s:1:\"b\";s:14:\"jabatan-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:26;a:4:{s:1:\"a\";i:35;s:1:\"b\";s:12:\"jabatan-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:27;a:4:{s:1:\"a\";i:36;s:1:\"b\";s:14:\"jabatan-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:28;a:4:{s:1:\"a\";i:37;s:1:\"b\";s:12:\"pegawai-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:29;a:4:{s:1:\"a\";i:38;s:1:\"b\";s:14:\"pegawai-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:30;a:4:{s:1:\"a\";i:39;s:1:\"b\";s:12:\"pegawai-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:31;a:4:{s:1:\"a\";i:40;s:1:\"b\";s:14:\"pegawai-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:32;a:4:{s:1:\"a\";i:41;s:1:\"b\";s:8:\"log-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:33;a:4:{s:1:\"a\";i:42;s:1:\"b\";s:10:\"log-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:6:{i:0;i:1;i:1;i:2;i:2;i:7;i:3;i:8;i:4;i:9;i:5;i:11;}}i:34;a:4:{s:1:\"a\";i:43;s:1:\"b\";s:8:\"log-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:35;a:4:{s:1:\"a\";i:44;s:1:\"b\";s:10:\"log-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:36;a:4:{s:1:\"a\";i:45;s:1:\"b\";s:11:\"dayoff-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:8;i:3;i:9;}}i:37;a:4:{s:1:\"a\";i:46;s:1:\"b\";s:13:\"dayoff-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:8;i:2;i:9;}}i:38;a:4:{s:1:\"a\";i:47;s:1:\"b\";s:11:\"dayoff-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:8;i:2;i:9;}}i:39;a:4:{s:1:\"a\";i:48;s:1:\"b\";s:13:\"dayoff-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:40;a:4:{s:1:\"a\";i:49;s:1:\"b\";s:13:\"dayoff-detail\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:8;i:3;i:9;}}i:41;a:4:{s:1:\"a\";i:50;s:1:\"b\";s:14:\"dayoff-confirm\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:42;a:4:{s:1:\"a\";i:51;s:1:\"b\";s:7:\"capture\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:7;i:2;i:9;}}i:43;a:4:{s:1:\"a\";i:53;s:1:\"b\";s:16:\"pegawai-timeline\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:44;a:4:{s:1:\"a\";i:54;s:1:\"b\";s:9:\"dashboard\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:8;}}i:45;a:4:{s:1:\"a\";i:55;s:1:\"b\";s:14:\"dashboard-user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:7;i:2;i:9;i:3;i:11;}}i:46;a:4:{s:1:\"a\";i:56;s:1:\"b\";s:12:\"collect-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:11;i:2;i:12;}}i:47;a:4:{s:1:\"a\";i:57;s:1:\"b\";s:14:\"collect-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:11;}}i:48;a:4:{s:1:\"a\";i:58;s:1:\"b\";s:12:\"collect-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:11;i:2;i:12;}}i:49;a:4:{s:1:\"a\";i:59;s:1:\"b\";s:14:\"collect-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:12;}}i:50;a:4:{s:1:\"a\";i:60;s:1:\"b\";s:15:\"collect-approve\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:12;}}i:51;a:4:{s:1:\"a\";i:61;s:1:\"b\";s:17:\"collect-task-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:12;}}i:52;a:4:{s:1:\"a\";i:62;s:1:\"b\";s:19:\"collect-task-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:12;}}i:53;a:4:{s:1:\"a\";i:63;s:1:\"b\";s:17:\"collect-task-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:12;}}i:54;a:4:{s:1:\"a\";i:64;s:1:\"b\";s:19:\"collect-task-assign\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:12;}}i:55;a:4:{s:1:\"a\";i:65;s:1:\"b\";s:19:\"collect-task-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:12;}}i:56;a:4:{s:1:\"a\";i:66;s:1:\"b\";s:21:\"collect-task-validate\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:12;}}}s:5:\"roles\";a:7:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"Admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:3:\"HRD\";s:1:\"c\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:8;s:1:\"b\";s:10:\"Management\";s:1:\"c\";s:3:\"web\";}i:3;a:3:{s:1:\"a\";i:7;s:1:\"b\";s:8:\"Employee\";s:1:\"c\";s:3:\"web\";}i:4;a:3:{s:1:\"a\";i:9;s:1:\"b\";s:7:\"Teknisi\";s:1:\"c\";s:3:\"web\";}i:5;a:3:{s:1:\"a\";i:11;s:1:\"b\";s:9:\"Collector\";s:1:\"c\";s:3:\"web\";}i:6;a:3:{s:1:\"a\";i:12;s:1:\"b\";s:7:\"Piutang\";s:1:\"c\";s:3:\"web\";}}}', 1736386427);

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
(49, '2024_12_03_164840_add_location_tb_collect', 17),
(50, '2024_12_26_153712_create_collect_tasks_table', 18),
(52, '2025_01_02_105139_add_column_remaining_bill', 19),
(53, '2025_01_02_160958_add_column_validate_by', 20),
(54, '2025_01_03_092951_add_column_assign_date_to_tb_collect', 21),
(55, '2025_01_03_103943_add_deleted_at_column_to_tb_collect_tasks', 22),
(56, '2025_01_03_155321_create_notifications_table', 23),
(57, '2025_01_03_163150_create_notifications_table', 24);

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
(1, 'App\\Models\\User', 1023),
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
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(60, 'collect-approve', 'web', '2024-11-26 16:13:43', '2024-11-26 16:13:43'),
(61, 'collect-task-list', 'web', '2024-12-26 08:54:53', '2024-12-26 08:54:53'),
(62, 'collect-task-create', 'web', '2024-12-26 08:54:53', '2024-12-26 08:54:53'),
(63, 'collect-task-edit', 'web', '2024-12-26 08:54:53', '2024-12-26 08:54:53'),
(64, 'collect-task-assign', 'web', '2024-12-26 08:54:53', '2024-12-26 08:54:53'),
(65, 'collect-task-delete', 'web', '2024-12-27 09:07:54', '2024-12-27 09:07:54'),
(66, 'collect-task-validate', 'web', '2025-01-02 08:46:47', '2025-01-02 08:46:47');

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
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
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
(42, 11),
(55, 11),
(56, 11),
(57, 11),
(58, 11),
(56, 12),
(58, 12),
(59, 12),
(60, 12),
(61, 12),
(62, 12),
(63, 12),
(64, 12),
(65, 12),
(66, 12);

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
('0WuTxHGa1yvGxwrbsegnabTCAjOKXmUNqNa7sKRn', 1031, '114.122.11.45', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiRktQY0VlSW5uWDNicHNHSTY2ak9mNFN2eFlBVXZtTENkU2FlNmJBdyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM0OiJodHRwOi8vaW5kb2RhY2luLm51c2EubmV0LmlkL2xvZ2luIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTAzMTt9', 1736302493),
('Cg1G2k6769OlS1BIsHbN7SzRAV9DuAaQuVMFYU5n', NULL, '114.122.20.227', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiMHZRQWxTWkpoVzh1Ym9iTFVpU085Wm43a3JmclZsQlpPa0xEOFd4ZCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1736306206),
('DAxSHyOz6nzVFN1T6KoDVjVKar94gThstu952xfT', 1, '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiMGdROVZuSXpqRGFWanJEVUxUVnRMSVVsRTRFQmxleHU1SkxxcGRiMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly9pbmRvZGFjaW4ubnVzYS5uZXQuaWQvZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czoxMjoiY3VycmVudF9kYXRlIjtzOjE1OiIyMDI1MDEwOF8wODQ5NTgiO3M6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1736310168),
('mAPp8R24yy3ORwMOYKVtGtrYvyBg093xqLeLrQgU', 1, '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOU11dDhMSWRQWlBTcXZLTW4yRFI0anFZcnBKQ1hvUVRLTXU3ckJjUiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6OTQ6Imh0dHA6Ly9pbmRvZGFjaW4ubnVzYS5uZXQuaWQvZjZmYTQ2NTQ1NWExYTljYWE3OTg1NDg3NjM2MmU3Yzc0YjBmOTM1Zi8zMTQ1MDIwMjUwMTA3XzA3NTYzNi5wbmciO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1736304373),
('tPKBQP5vU6RU0ol4SRB1XGSMJQTJxVK4aism8XVZ', NULL, '192.168.11.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiR3UyVXdBQ1g4NzBJcHFaMlJuOURYdk1mSUUwb2o0ZzdkdTNiNnl6UyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6OTQ6Imh0dHA6Ly9pbmRvZGFjaW4ubnVzYS5uZXQuaWQvZjZmYTQ2NTQ1NWExYTljYWE3OTg1NDg3NjM2MmU3Yzc0YjBmOTM1Zi8zMTQ1MDIwMjUwMTAzXzA4MDIwMC5wbmciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1736299256);

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
(66, '112233', 0, 0, 0, 0, 'Wajah', '2024-11-13 13:54:56', 1, '2024-11-13 13:54:56', NULL, NULL, '11223320241113_135456', '2024-11-12 23:54:56', '2024-11-12 23:54:56'),
(67, '123123', 0, 0, 0, 0, 'Wajah', '2024-11-13 16:14:11', 1, '2024-11-13 16:14:11', '98.6665848', '3.6076307', '12312320241113_161410', '2024-11-13 02:14:11', '2024-11-13 02:14:11'),
(68, '112233', 0, 0, 0, 0, 'Wajah', '2024-11-14 07:45:27', 1, '2024-11-14 07:45:27', '97.9491521', '2.6319443', '11223320241114_074526', '2024-11-13 17:45:27', '2024-11-13 17:45:27'),
(70, '315', 0, 0, 0, 0, 'Wajah', '2024-11-14 15:31:17', 1, '2024-11-14 15:31:17', '102.83983166667', '-4.37809', '31520241114_153116', '2024-11-14 01:31:17', '2024-11-14 01:31:17'),
(71, '112233', 0, 0, 0, 0, 'Wajah', '2024-11-15 08:07:35', 1, '2024-11-15 08:07:35', '97.9489783', '2.6319867', '11223320241115_080734', '2024-11-14 18:07:35', '2024-11-14 18:07:35'),
(73, '31450', 0, 0, 0, 0, 'Wajah', '2024-11-21 08:12:57', 1, '2024-11-21 08:12:57', '98.4803001', '3.62132', '3145020241121_081254', '2024-11-20 18:12:57', '2024-11-20 18:12:57'),
(74, '31450', 0, 0, 0, 0, 'Wajah', '2024-11-22 07:40:14', 1, '2024-11-22 07:40:14', '101.4266918', '0.603567', '3145020241122_074012', '2024-11-21 17:40:14', '2024-11-21 17:40:14'),
(79, '31450', 0, 0, 0, 0, 'Wajah', '2024-11-28 12:32:03', 1, '2024-11-28 12:32:03', '101.8316283', '0.424675', '3145020241128_123202', '2024-11-28 05:32:03', '2024-11-28 05:32:03'),
(83, '31450', 0, 0, 0, 0, 'Wajah', '2024-12-27 08:44:07', 1, '2024-12-27 08:44:07', '101.8317005', '0.424646', '3145020241227_084349', '2024-12-26 18:44:07', '2024-12-26 18:44:07'),
(87, '31450', 0, 0, 0, 0, 'Wajah', '2024-12-28 07:58:11', 1, '2024-12-28 07:58:11', '101.831695', '0.4247233', '3145020241228_075755', '2024-12-27 17:58:11', '2024-12-27 17:58:11'),
(88, '31450', 0, 0, 0, 0, 'Wajah', '2024-12-28 07:58:11', 1, '2024-12-28 07:58:11', '101.831695', '0.4247233', '3145020241228_075755', '2024-12-27 17:58:11', '2024-12-27 17:58:11'),
(89, '31450', 0, 0, 0, 0, 'Wajah', '2024-12-30 08:09:57', 1, '2024-12-30 08:09:57', '101.8315117', '0.42467', '3145020241230_080940', '2024-12-29 18:09:57', '2024-12-29 18:09:57'),
(90, '31450', 0, 0, 0, 0, 'Wajah', '2024-12-31 07:52:46', 1, '2024-12-31 07:52:46', '101.831675', '0.4246867', '3145020241231_075238', '2024-12-30 17:52:46', '2024-12-30 17:52:46'),
(91, '31450', 0, 0, 0, 0, 'Wajah', '2025-01-02 07:44:19', 1, '2025-01-02 07:44:19', '101.8317164', '0.4247133', '3145020250102_074411', '2025-01-01 17:44:19', '2025-01-01 17:44:19'),
(92, '31450', 0, 0, 0, 0, 'Wajah', '2025-01-03 08:02:08', 1, '2025-01-03 08:02:08', '101.8320683', '0.4247033', '3145020250103_080200', '2025-01-02 18:02:08', '2025-01-02 18:02:08'),
(93, '31450', 0, 0, 0, 0, 'Wajah', '2025-01-04 07:57:36', 1, '2025-01-04 07:57:36', '101.831672', '0.4247977', '3145020250104_075728', '2025-01-03 17:57:36', '2025-01-03 17:57:36'),
(94, '31450', 0, 0, 0, 0, 'Wajah', '2025-01-06 07:42:01', 1, '2025-01-06 07:42:01', '101.831615', '0.4247', '3145020250106_074155', '2025-01-05 17:42:01', '2025-01-05 17:42:01'),
(95, '31450', 0, 0, 0, 0, 'Wajah', '2025-01-07 07:56:44', 1, '2025-01-07 07:56:44', '101.8316147', '0.4247314', '3145020250107_075636', '2025-01-06 17:56:44', '2025-01-06 17:56:44');

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
(200, '123123', 0, 0, 0, 0, 'Wajah', '2024-11-13 16:17:46', 1, '2024-11-13 16:17:46', '99.165423363447', '3.3360303965685', '12312320241113_161745', '2024-11-13 02:17:46', '2024-11-13 02:17:46'),
(201, '123123', 0, 0, 0, 0, 'Wajah', '2024-11-13 16:23:12', 1, '2024-11-13 16:23:12', '99.792172461748', '2.9617536159645', '12312320241113_162311', '2024-11-13 02:23:12', '2024-11-13 02:23:12'),
(202, '112233', 0, 0, 0, 0, 'Wajah', '2024-11-13 16:32:00', 1, '2024-11-13 16:32:00', '97.9492047', '2.632071', '11223320241113_163159', '2024-11-13 02:32:00', '2024-11-13 02:32:00'),
(207, '112233', 0, 0, 0, 0, 'Wajah', '2024-11-14 19:02:11', 1, '2024-11-14 19:02:11', '97.9172414', '2.6270318', '11223320241114_190210', '2024-11-14 05:02:11', '2024-11-14 05:02:11'),
(209, '31450', 0, 0, 0, 0, 'Wajah', '2024-11-21 08:13:56', 1, '2024-11-21 08:13:56', '98.4802951', '3.6213185', '3145020241121_081354', '2024-11-20 18:13:56', '2024-11-20 18:13:56'),
(210, '31450', 0, 0, 0, 0, 'Wajah', '2024-11-21 08:15:39', 1, '2024-11-21 08:15:39', '98.480309', '3.621199', '3145020241121_081536', '2024-11-20 18:15:39', '2024-11-20 18:15:39'),
(211, '31450', 0, 0, 0, 0, 'Wajah', '2024-11-22 16:32:17', 1, '2024-11-22 16:32:17', '101.8316983', '0.42462', '3145020241121_081536', '2024-11-22 02:32:17', '2024-11-22 02:32:17'),
(229, '31450', 0, 0, 0, 0, 'Wajah', '2024-12-27 08:45:38', 1, '2024-12-27 08:45:38', '101.8317979', '0.4245923', '3145020241227_084533', '2024-12-26 18:45:38', '2024-12-26 18:45:38'),
(232, '31450', 0, 0, 0, 0, 'Wajah', '2024-12-27 17:20:56', 1, '2024-12-27 17:20:56', '101.8317271', '0.4247419', '3145020241227_172043', '2024-12-27 03:20:56', '2024-12-27 03:20:56'),
(233, '31450', 0, 0, 0, 0, 'Wajah', '2024-12-28 17:15:10', 1, '2024-12-28 17:15:10', '101.8316683', '0.4248', '3145020241228_171502', '2024-12-28 03:15:10', '2024-12-28 03:15:10'),
(234, '31450', 0, 0, 0, 0, 'Wajah', '2024-12-28 17:15:14', 1, '2024-12-28 17:15:14', '101.8316712', '0.4248048', '3145020241228_171502', '2024-12-28 03:15:14', '2024-12-28 03:15:14'),
(235, '31450', 0, 0, 0, 0, 'Wajah', '2024-12-30 08:10:06', 1, '2024-12-30 08:10:06', '101.8315117', '0.42467', '3145020241230_080940', '2024-12-29 18:10:06', '2024-12-29 18:10:06'),
(236, '31450', 0, 0, 0, 0, 'Wajah', '2024-12-30 17:23:50', 1, '2024-12-30 17:23:50', '101.8315995', '0.424702', '3145020241230_172335', '2024-12-30 03:23:50', '2024-12-30 03:23:50'),
(237, '31450', 0, 0, 0, 0, 'Wajah', '2024-12-30 17:23:50', 1, '2024-12-30 17:23:50', '101.8315995', '0.424702', '3145020241230_172335', '2024-12-30 03:23:50', '2024-12-30 03:23:50'),
(238, '31450', 0, 0, 0, 0, 'Wajah', '2024-12-30 17:23:50', 1, '2024-12-30 17:23:50', '101.8315995', '0.424702', '3145020241230_172335', '2024-12-30 03:23:50', '2024-12-30 03:23:50'),
(239, '31450', 0, 0, 0, 0, 'Wajah', '2024-12-31 17:20:12', 1, '2024-12-31 17:20:12', '101.831726', '0.424871', '3145020241231_172006', '2024-12-31 03:20:12', '2024-12-31 03:20:12'),
(240, '31450', 0, 0, 0, 0, 'Wajah', '2025-01-02 17:11:15', 1, '2025-01-02 17:11:15', '101.8316916', '0.4247715', '3145020250102_171112', '2025-01-02 03:11:15', '2025-01-02 03:11:15'),
(241, '31450', 0, 0, 0, 0, 'Wajah', '2025-01-03 08:03:46', 1, '2025-01-03 08:03:46', '101.8319283', '0.4247983', '3145020250103_080341', '2025-01-02 18:03:46', '2025-01-02 18:03:46'),
(242, '31450', 0, 0, 0, 0, 'Wajah', '2025-01-03 17:20:41', 1, '2025-01-03 17:20:41', '101.8316347', '0.4247452', '3145020250103_172038', '2025-01-03 03:20:41', '2025-01-03 03:20:41'),
(243, '31450', 0, 0, 0, 0, 'Wajah', '2025-01-04 07:57:37', 1, '2025-01-04 07:57:37', '101.8316767', '0.4248068', '3145020250104_075728', '2025-01-03 17:57:37', '2025-01-03 17:57:37'),
(244, '31450', 0, 0, 0, 0, 'Wajah', '2025-01-04 17:05:00', 1, '2025-01-04 17:05:00', '101.8316617', '0.4248083', '3145020250104_170459', '2025-01-04 03:05:00', '2025-01-04 03:05:00'),
(245, '31450', 0, 0, 0, 0, 'Wajah', '2025-01-06 17:37:49', 1, '2025-01-06 17:37:49', '101.83162', '0.42476', '3145020250106_173735', '2025-01-06 03:37:49', '2025-01-06 03:37:49');

-- --------------------------------------------------------

--
-- Table structure for table `tb_collect`
--

CREATE TABLE `tb_collect` (
  `id` bigint UNSIGNED NOT NULL,
  `no_sr` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_pegawai` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: blm up, 1: setuju, 2: diajukan, 3: ditolak',
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `have_paid` int DEFAULT NULL COMMENT 'dibayar apa ngga?',
  `payment_type` int DEFAULT NULL COMMENT 'belum, 0 cash, 1 tf, 2 giro/cek',
  `payment_amount` bigint DEFAULT NULL COMMENT 'dibayar berapa?',
  `validate_by` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assign_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_collect`
--

INSERT INTO `tb_collect` (`id`, `no_sr`, `kode_pegawai`, `title`, `keterangan`, `location`, `longitude`, `latitude`, `status`, `notes`, `have_paid`, `payment_type`, `payment_amount`, `validate_by`, `assign_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(10, 'SR-123TEST', '394', 'Absen sore', '<p>Absen sore absen sore absen sore absen sore absen sore absen sore absen sore absen sore absen sore absen sore absen sore absen sore absen sore plg jm 5</p>', 'Kantor Indodacin', '98.6689616', '3.5914793', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-03 09:31:43', '2024-12-03 10:00:45', NULL),
(13, 'SR-123TEST', '394', 'Panin', '<p>Paninnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnjdkfjfjfkgkffkfkfkfkfkfkfkfkfkfkfkfkgkglgoy</p>', 'Panin', '98.6789367', '3.5889016', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-04 03:34:39', '2024-12-04 08:01:37', NULL),
(14, 'SR-123TEST', '394', 'Mandiri', '<p>Mandiri jdjdjdjekekdjdjdjdjdjdjsjslwlsldjdjdjdjejejdjdjdjdjdjdjdjdjdjdjdjdjdjdjejjdjdkekdjdjdjdjdjdjdjdjdjdjdjdhdhdjk</p>', 'Mandiri', '98.6777331', '3.5897003', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-04 03:42:23', '2024-12-04 08:01:30', NULL),
(15, 'SR-123TEST', '394', 'Ocbcc', '<p>Ocbc ejjekslsoeidjjdjdjdododkdjdjfjdjdododjdjdjrorododkdjdjdjdjdjdjdjdjdkdidpeprkfjfjfifofofororkfjdj</p>', 'Ocbcc', '98.6670215', '3.5925446', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-04 04:26:27', '2024-12-04 08:01:24', NULL),
(18, 'SR-123TEST', '394', 'Abccc', '<p>Abc skdjdjdodpdkdndjdiirkfjrjrjfjfbfkfldldkdjdbdndndjdldkdkdndnfjdjfkfofpfodjdjdorprodododkfjdndkdjdj</p>', 'ABC', '98.6772534', '3.5890446', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-04 08:55:24', '2024-12-05 06:14:14', NULL),
(19, 'SR-123TEST', '394', 'Permata danamon bca bri uob bsi', '<p>Permata danamon bca bri uob bsi jakdkjdjdjskskjdjdjdkskkskdkdkkdkdkdkdjjdkdkdokdkddkk</p>', 'Permata danamon bca bri bsi', '98.677266', '3.5890692', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-04 09:01:12', '2024-12-06 09:05:19', NULL),
(20, 'SR-123TEST', '394', 'Ktrrr', '<p>Ktr jsjdkdldbdidpdpdkfjdjdofldpdjfjfjfjfkpeepfkfjforodnfhfjfkfofkfjfkflfodofkfnfbndkdpdpdlldkfjfj</p>', 'Ktr', '98.6689488', '3.5914883', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-04 09:12:33', '2024-12-05 06:14:28', NULL),
(23, 'SR-123TEST', '394', 'Niaga', '<p>Niaga djdjjdkdododjdjdjdjdofodoodjdjsjsjsksosopsoaisjdjdidodoidjdjdkdkdodododododidjkdkdldpdo</p>', 'Niaga', '98.6643816', '3.5915455', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-05 01:47:06', '2024-12-05 06:14:42', NULL),
(26, 'SR-123TEST', '394', 'Uobbb', '<p>Uob sjdndnkdkxbdjdodlsjdjdjdjdjdpdoxjdjdkwkoasojdjdkdkdjdkdkkdkdododkjddkkfpfofjfjkdkxpdo</p>', 'Uobbb', '98.6810388', '3.5849775', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-05 02:21:15', '2024-12-05 06:14:57', NULL),
(33, 'SR-123TEST', '394', 'Mandiri', '<p>Mandiri bdjdklflfkfjfjfkfkfkfkfjfngjgkfkckckclfkfkjvkgkgkgkgkgickvigigigixjrkdkfhfjfjfkfkfkfkfkfkfkfkfkffk</p>', 'Mandiri', '98.6807691', '3.5849105', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-05 03:56:27', '2024-12-05 06:15:14', NULL),
(34, 'SR-123TEST', '394', 'Permata', '<p>Permata fjdldpdkdjfocpclcjfjfofofofjdjdkpspsodkfjfofofkdjjdjdjfjfkfjfkfopfodkdodkfkfjf</p>', 'Permata', '98.6742575', '3.5831522', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-05 04:31:55', '2024-12-05 06:15:25', NULL),
(35, 'SR-123TEST', '394', 'Bcaaa', '<p>Bca djfkkfhdjdujfkdjdkodididijdjdjfjdjkcjdjfogohohogogkgkgzkgdkhdlhdlhdoydkydkgxkydlyd</p>', 'Bcaaa', '98.6687321', '3.5924223', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-05 07:51:01', '2024-12-06 01:06:08', NULL),
(36, 'SR-123TEST', '394', 'Dragon', '<p>Dragon djdkkdosjdjdkflfldmndndjfkfkfkfkflflfjfnfnflflglgkgjfjfkfkfkfkfkfkfkfkfkfjfjfj</p>', 'Dragon', '98.6822216', '3.5905569', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-05 08:48:32', '2024-12-06 01:06:23', NULL),
(38, 'SR-123TEST', '394', 'Bsiii', '<p>Kgskhdlhdludludludludlufljdlhdlhdlhdlhdlydhdkhdohdkhdlhdhlhdlhdlhchclhxohcljflhxlhxlhxlhdluxlufljf</p>', 'Bsiii', '98.6663963', '3.5923027', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-06 08:12:18', '2024-12-06 09:05:31', NULL),
(46, 'SR-123TEST', '493', 'Anter tt', '<p>Anter tt</p>', 'Ismud', '98.6606479', '3.5845168', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-11 18:35:42', '2024-12-11 21:58:12', NULL),
(47, 'SR-123TEST', '493', 'Anter tt dan tagihan', '<p>Anter tt dan tagihan</p>', 'S.parman', '98.6671039', '3.5795895', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-11 18:44:46', '2024-12-11 21:58:23', NULL),
(48, 'SR-123TEST', '493', 'Anter tagihan lunas', '<p>Anter tagihan lunas</p>', 'Komp.multatuli', '98.6801167', '3.5762558', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-11 19:14:21', '2024-12-11 21:58:33', NULL),
(49, 'SR-123TEST', '493', 'Anter tt', '<p>Anter tt</p>', 'Komp multatuli', '98.6809921', '3.5764239', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-11 19:20:05', '2024-12-11 21:58:44', NULL),
(50, 'SR-123TEST', '493', 'Anter tt', '<p>Anter tt</p>', 'Katamso bisnis center', '98.6857345', '3.5749051', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-11 19:32:31', '2024-12-11 21:59:10', NULL),
(51, 'SR-123TEST', '493', 'Anter tt', '<p>Anter tt</p>', 'Taman Polonia 4', '98.6804245', '3.5701055', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-11 19:43:23', '2024-12-11 21:59:16', NULL),
(52, 'SR-123TEST', '394', 'Niaga', '<p>Kgskyskyskhskhzkhskhzkhzkhdkhskhdkydysoyskydkhdoydkydkyskysykhdkysoydkyzkhxuldlhdlud</p>', 'Niaga', '98.6739687', '3.5863198', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-11 19:56:45', '2024-12-11 22:00:21', NULL),
(53, 'SR-123TEST', '493', 'Anter tagihan lunas', '<p>Anter tagihan lunas</p>', 'Komp Sanur Deli tua', '98.6800045', '3.5172515', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-11 21:05:16', '2024-12-11 21:59:26', NULL),
(54, 'SR-123TEST', '493', 'Nagih', '<p>Nagih</p>', 'Katamso', '98.6886016', '3.5523902', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-11 21:22:26', '2024-12-11 21:59:34', NULL),
(55, 'SR-123TEST', '493', 'Naigih..', '<p>Nagih.</p>', 'CBD polonia', '98.6770629', '3.557002', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-11 21:50:28', '2024-12-11 21:59:40', NULL),
(56, 'SR-123TEST', '493', 'Nagih..', '<p>Nagih</p>', 'Katamso GG mantri', '98.6824274', '3.5796569', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-11 22:22:49', '2024-12-11 22:39:30', NULL),
(57, 'SR-123TEST', '493', 'Anter tt dan nagih', '<p>Anter tt dan nagih</p>', 'Pandu', '98.6858878', '3.5828399', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-11 23:09:07', '2024-12-12 00:42:19', NULL),
(58, 'SR-123TEST', '394', 'Mandiri', '<p>Khdkgskgzkgzigdigxigdy8htshxhodgigxohxohdohdohdoudohdohxohxohxohdouxohxohxohxohd</p>', 'Mandiri', '98.6777966', '3.5895656', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-12 00:30:55', '2024-12-12 00:42:32', NULL),
(59, 'SR-123TEST', '394', 'Staaaa', '<p>Uldljfljflysylhdhlhdhlhclhdohdoydoysoydlhdhlhdlhdlhflhcljcljflhxlbcljclhdohxogxohxlhxlydp</p>', 'Staaaa', '98.6673687', '3.5844434', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-12 01:31:21', '2024-12-12 01:39:33', NULL),
(60, 'SR-123TEST', '394', 'Pandu', '<p>xhdlhdludlhdljfljfludldhdlydlhdludlhxudlhxlhdjflhcljfljfpjfulbdkhdkhxhxlhxlhdlhxlhclhclhd</p>', 'Pandu', '98.6843452', '3.5821999', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-12 02:21:18', '2024-12-12 02:22:16', NULL),
(61, 'SR-123TEST', '493', 'Tnda trm', '<p>Tnda trm</p>', 'Simatupang', '98.6158394', '3.5832784', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-12 19:07:20', '2024-12-12 20:54:25', NULL),
(62, 'SR-123TEST', '493', 'Tagihan', '<p>Tagihan</p>', 'Patumbak', '98.7190313', '3.529108', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-12 20:16:39', '2024-12-12 20:54:42', NULL),
(63, 'SR-123TEST', '493', 'Tagihan', '<p>Tagihan blm ada</p>', 'Patumbak', '98.7181329', '3.5321579', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-12 20:26:35', '2024-12-12 20:54:58', NULL),
(64, 'SR-123TEST', '493', 'Tagihan', '<p>Tagihan</p>', 'Pandu', '98.685677', '3.5827259', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-12 20:52:26', '2024-12-12 20:55:09', NULL),
(65, 'SR-123TEST', '493', 'Tnda trm', '<p>Tnda trm</p>', 'Sutomo', '98.6822128', '3.5959017', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-12 21:01:07', '2024-12-12 21:19:59', NULL),
(66, 'SR-123TEST', '493', 'Tagihan', '<p>Tagihan</p>', 'Pandu', '98.6856752', '3.5827278', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-12 23:53:32', '2024-12-13 01:56:59', NULL),
(67, 'SR-123TEST', '493', 'Tagihan', '<p>Bayar</p>', 'Gatsu', '98.665515', '3.5924367', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-13 19:53:25', '2024-12-13 20:01:17', NULL),
(68, 'SR-123TEST', '493', 'TKO GINA jaya', '<p>Cri orderan</p>', 'Pajak sambas', '98.6868789', '3.580478', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-14 00:08:57', '2024-12-14 00:41:21', NULL),
(69, 'SR-123TEST', '493', 'Tagihan', '<p>Transfer</p>', 'Pajak sambas', '98.6872746', '3.5802775', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-14 00:26:29', '2024-12-14 00:41:37', NULL),
(70, 'SR-123TEST', '493', 'TKO serasi', '<p>Cri orderan</p>', 'Pajak sambas', '98.6872746', '3.5802775', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-14 00:27:35', '2024-12-14 00:41:54', NULL),
(71, 'SR-123TEST', '493', 'Tagihan', '<p>Bayar</p>', 'Mt haryono', '98.6852485', '3.5869722', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-14 00:41:58', '2024-12-14 00:42:14', NULL),
(72, 'SR-123TEST', '493', 'TKO koni', '<p>Cri orderan</p>', 'Mt haryono', '98.6854214', '3.5870171', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-14 00:45:45', '2024-12-14 02:56:50', NULL),
(73, 'SR-123TEST', '74', 'Tanda terima', '<p>Tanda terima</p>', 'Jl. Sumatera', '98.6689889', '3.5914759', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-15 17:59:49', '2024-12-15 20:29:31', NULL),
(75, 'SR-123TEST', '74', 'PT multimas nabati asahan', '<p>Tanda terima </p>', 'Jw mariot', '98.6758591', '3.5964436', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-15 19:21:02', '2024-12-15 20:33:00', NULL),
(76, 'SR-123TEST', '493', 'Tanda trm SAHABAT MEWAH', '<p>Tnda trm SAHABAT MEWAH</p>', 'Sinar mas land plaza', '98.672413', '3.583176', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-15 19:34:52', '2024-12-15 21:08:51', NULL),
(77, 'SR-123TEST', '74', 'PT sawit jambi lestari', '<p>Antar sertifikat tera</p>', 'Uniland Asian agri', '98.6825811', '3.5865429', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-15 19:41:47', '2024-12-15 20:41:05', NULL),
(78, 'SR-123TEST', '493', 'Tnda trm PT BANDAR SUMATERA INDONESIA', '<p>Tnda trm BANDAR SUMATERA INDONESIA</p>', 'CIMB niaga plaza', '98.669979', '3.5871683', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-15 19:46:08', '2024-12-15 21:07:56', NULL),
(79, 'SR-123TEST', '74', 'PT sawit permai abadi', '<p>Antar sertifikat tera </p>', 'Komp center point', '98.6819088', '3.5907886', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-15 19:50:30', '2024-12-15 20:42:22', NULL),
(80, 'SR-123TEST', '493', 'Anter surat tera Binti Jaya Baja', '<p>Sertifikat srt tera Binti Jaya Baja</p>', 'Gatsu', '98.6668686', '3.5924312', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-15 19:52:23', '2024-12-15 21:16:31', NULL),
(81, 'SR-123TEST', '74', 'BPK aho bintang terang', '<p>Tanda terima </p>', 'Pusat pasar belakang sambu', '98.6859453', '3.5903468', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-15 20:02:50', '2024-12-15 20:37:11', NULL),
(82, 'SR-123TEST', '74', 'PT parasawita', '<p>Tanda terimaa</p>', 'Jln kalimantan', '98.6906096', '3.5905007', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-15 20:30:10', '2024-12-15 21:17:40', NULL),
(83, 'SR-123TEST', '74', 'PT cipta prima interwood', '<p>Tanda terima hariselas jam 2 s/d4 sore</p>', 'Jln HM Yamin no46', '98.6843374', '3.5956796', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-15 20:39:11', '2024-12-15 21:18:20', NULL),
(84, 'SR-123TEST', '493', 'Tagihan BPK abeng', '<p>Bayar</p>', 'Klumpang', '98.5956271', '3.6688072', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-15 20:44:24', '2024-12-15 21:05:33', NULL),
(85, 'SR-123TEST', '74', 'PT univista utamaa', '<p>Tanda terima ok ya</p>', 'Jln Ghandi 111', '98.6902383', '3.5833497', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-15 20:48:02', '2024-12-15 21:18:51', NULL),
(86, 'SR-123TEST', '74', 'PT Surya mentari indah', '<p>Tanda terima ok ya</p>', 'Jln Ghandi no36/160', '98.6906676', '3.583405', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-15 20:53:00', '2024-12-15 21:19:12', NULL),
(88, 'SR-123TEST', '74', 'Ayen cse', '<p>Antar bon yg SDH lunas</p>', 'Jln Sutrisno 173 b', '98.6999418', '3.5823263', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-15 21:00:27', '2024-12-15 21:04:48', NULL),
(89, 'SR-123TEST', '74', 'PT prima tangki indonesia', '<p>Tanda terima ok ya</p>', 'Jln rencong 1b', '98.7038997', '3.5896239', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-15 21:08:54', '2024-12-15 21:19:32', NULL),
(90, 'SR-123TEST', '394', 'Bagi kalender', '<p>Cemara kysoyskgzkhxlydogskgzoyzoysoysoysoydgggggghhgggmvzkgslysyidyyoydohdoydohdoy</p>', 'Bagi kalender', '98.6810497', '3.6294401', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-16 01:44:33', '2024-12-16 18:18:26', NULL),
(91, 'SR-123TEST', '74', 'PT persadanusa nabati Indonesia', '<p>Tanda terima ok ya</p><p>Sama pak satpam namanya Hendra </p>', 'Komp graha metropolitan blok t7', '98.6473643', '3.6260927', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-16 18:21:51', '2024-12-17 02:06:35', NULL),
(92, 'SR-123TEST', '74', 'PT Garuda mas perkasa', '<p>Antar sertifikat tera </p><p>Satpam namanya Sri rejeki </p>', 'Jln yos Sudarso km 6.5', '98.6684441', '3.6361453', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-16 18:42:49', '2024-12-17 02:12:13', NULL),
(93, 'SR-123TEST', '74', 'PT industri karet deli', '<p>Antar surat tera</p>', 'Jln yos Sudarso km 8.3', '98.6613974', '3.6537653', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-16 19:04:16', '2024-12-17 02:16:22', NULL),
(94, 'SR-123TEST', '74', 'PT Mabar feed indonesi', '<p>Gak bisa di TT </p>', 'Jln rumah potong hewan', '98.6685424', '3.658237', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-16 19:25:49', '2024-12-17 02:16:48', NULL),
(95, 'SR-123TEST', '74', 'PT logistik pendingin Indonesia', '<p>Tanda terima ok </p><p>Yg terima yuda</p>', 'Kayu putih gudang138e', '98.6805845', '3.651509', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-16 19:37:13', '2024-12-17 02:17:09', NULL),
(96, 'SR-123TEST', '493', 'Tnda trm PT indojaya agrinusa', '<p>Ok</p>', 'Tnjg morawa', '98.7563715', '3.5262352', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-16 19:44:27', '2024-12-17 02:17:32', NULL),
(97, 'SR-123TEST', '74', 'PT growth asia', '<p>Tanda terima ok ya</p><p>Kak Nurul</p>', 'Kim 1', '98.6697295', '3.6704279', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-16 19:54:40', '2024-12-17 02:17:53', NULL),
(98, 'SR-123TEST', '74', 'PT Tapteng anugrah sawit', '<p>Tanda terima ok</p>', 'Kim 1', '98.6749554', '3.6730043', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-16 20:08:09', '2024-12-17 02:15:31', NULL),
(99, 'SR-123TEST', '74', 'PT era cipta bina karya', '<p>Pak Nanang gak di tempat</p><p>Gak bisa TT dan ambil po.</p><p>TT kembali di jumat</p>', 'Kim 1', '98.6749513', '3.6730092', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-16 20:10:36', '2024-12-16 21:25:54', NULL),
(100, 'SR-123TEST', '493', 'Tnda trm PT Tirta sari sumber murni', '<p>Ok</p>', 'Karya darma tnjg morawa', '98.8099206', '3.5274016', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-16 20:11:14', '2024-12-17 02:15:03', NULL),
(101, 'SR-123TEST', '493', 'Tagihan CV jaya perkasa abadi', '<p>Ok</p>', 'Industri tnjg morawa', '98.8064166', '3.5284641', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-16 20:22:02', '2024-12-17 02:14:29', NULL),
(102, 'SR-123TEST', '74', 'PT bukit intan abadi', '<p>Tanda terima ok ya</p>', 'Kim1', '98.6894515', '3.6675088', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-16 20:26:30', '2024-12-17 02:16:03', NULL),
(103, 'SR-123TEST', '74', 'PT bukit intan abadi', '<p>Tanda terima ok ya </p>', 'Kim1', '98.6894394', '3.6675095', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-16 20:27:48', '2024-12-17 02:13:49', NULL),
(104, 'SR-123TEST', '74', 'PT toba surimi industri', '<p>Tanda terima ok ya </p>', 'Kim2', '98.6894311', '3.6674846', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-16 20:30:50', '2024-12-17 02:13:32', NULL),
(105, 'SR-123TEST', '493', 'Sertifikat baja agung kharisma utama', '<p>Ok</p>', 'Tnjg morawa', '98.7902195', '3.5217015', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-16 20:35:21', '2024-12-17 02:13:11', NULL),
(106, 'SR-123TEST', '74', 'PT pacific palmindo industri', '<p>Antar sertifikat tera yg terima satpam rifaldi</p>', 'Kim 2', '98.6904396', '3.6701458', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-16 20:36:01', '2024-12-17 02:12:50', NULL),
(107, 'SR-123TEST', '74', 'PT Charoen Pokphand Indonesia', '<p>Tanda terima ok ya</p>', 'Kim 2 Sumbawa ini', '98.6845287', '3.6763562', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-16 20:47:24', '2024-12-17 02:12:32', NULL),
(108, 'SR-123TEST', '493', 'Tnda trm ibu Kim heng', '<p>Ok</p>', 'Irian tnjg morawa', '98.7975675', '3.5216539', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-16 21:00:31', '2024-12-16 21:23:56', NULL),
(109, 'SR-123TEST', '493', 'Tnda trm PT Budi tamora permai', '<p>Ok</p>', 'P. kemerdekaan tnjg morawa', '98.7957953', '3.5228072', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-16 21:13:07', '2024-12-17 02:07:01', NULL),
(110, 'SR-123TEST', '74', 'Irian Marelan', '<p>Tanda terima ok ya</p>', 'Marelan', '98.6560106', '3.6938717', 3, 'dua x input', NULL, NULL, NULL, '0', NULL, '2024-12-16 21:22:05', '2024-12-17 19:11:46', NULL),
(111, 'SR-123TEST', '493', 'Tagihan BPK ferry', '<p>GK byr Krn LG natal.</p>', 'Irian tnjg morawa', '98.7928729', '3.5173585', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-16 21:25:02', '2024-12-16 23:18:03', NULL),
(112, 'SR-123TEST', '74', 'Irian marelan', '<p>Gak bisa TT ya adayg salah</p>', 'Marelan', '98.6557625', '3.6937945', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-16 21:48:06', '2024-12-17 02:10:34', NULL),
(113, 'SR-123TEST', '74', 'BPK johan', '<p>Tanda terima ok ya </p>', 'Titipahlawan marelan', '98.6609928', '3.7113808', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-16 22:05:35', '2024-12-16 23:17:18', NULL),
(114, 'SR-123TEST', '74', 'PT multi persada gatramegah', '<p>Tanda terima ok ya</p><p>SDH di tukarya invoice dan fantur pajaknya</p>', 'Yos Sudarso', '98.6628807', '3.6475346', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-17 00:07:04', '2024-12-17 02:10:53', NULL),
(115, 'SR-123TEST', '493', 'Tnda  trm Tony lim', '<p>Ok</p>', 'Btg kuis', '98.6809143', '3.5826031', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-17 00:51:49', '2024-12-17 02:11:12', NULL),
(116, 'SR-123TEST', '493', 'Tnda trm PT bilah baja makmur abadi', '<p>Ok</p>', 'Kol. Sugiono', '98.6808575', '3.5827171', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-17 01:09:06', '2024-12-17 02:11:30', NULL),
(117, 'SR-123TEST', '493', 'Tnda trm PT sumber rezeki sejahtera', '<p>Ok</p>', 'Nibung raya', '98.6647026', '3.5865977', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-17 01:27:24', '2024-12-17 02:11:50', NULL),
(118, 'SR-123TEST', '493', 'Tnda trm PT karya agung sawita dan sumber tani agung', '<p>Ok</p>', 'Cambrige', '98.6673028', '3.5844925', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-17 18:30:09', '2024-12-17 21:08:54', NULL),
(119, 'SR-123TEST', '493', 'Tnda trm PT semadam', '<p>Ok</p>', 'Nibung raya', '98.6647056', '3.5878014', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-17 18:44:31', '2024-12-17 21:09:23', NULL),
(120, 'SR-123TEST', '74', 'PT Sumatra Timber industri', '<p>Blom di transfer </p><p>Nanti di TF info kasir</p>', 'Jln kol Sugiono 26', '98.6800143', '3.583659', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-17 19:19:46', '2024-12-17 21:10:03', NULL),
(121, 'SR-123TEST', '74', 'PT tani mas resource internasional', '<p>Tanda terima ok ya </p>', 'Jati jactoin', '98.6791754', '3.5968064', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-17 19:35:37', '2024-12-17 21:10:31', NULL),
(122, 'SR-123TEST', '74', 'PT tani mas resource internasional', '<p>Ok</p>', 'Jati jactoin', '98.6900599', '3.5903887', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-17 19:53:14', '2024-12-23 00:22:12', NULL),
(123, 'SR-123TEST', '74', 'PT maroke tetep jaya', '<p>Tanda terima ok ya </p>', 'Jl Thamrin', '98.6900713', '3.5903816', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-17 19:54:17', '2024-12-17 21:11:34', NULL),
(124, 'SR-123TEST', '493', 'Tnda trm lunas PT bugak', '<p>Ok</p>', 'Kiwi', '98.5944767', '3.6005733', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-17 19:56:30', '2024-12-17 21:11:58', NULL),
(125, 'SR-123TEST', '74', 'Inur nadimin', '<p>Tanda terima ok ya </p>', 'Jln ar hakim no 128', '98.7035318', '3.5769472', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-17 20:16:08', '2024-12-17 21:12:18', NULL),
(126, 'SR-123TEST', '493', 'Tnda trm PT olam', '<p>Ok</p>', 'Binjai', '98.5629106', '3.5979502', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-17 20:25:37', '2024-12-17 21:12:41', NULL),
(127, 'SR-123TEST', '74', 'PT cipta chemical Medan oil', '<p>Tanda terima ok ya bang bayu</p>', 'Jl negara no83', '98.7051454', '3.5939602', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-17 20:27:22', '2024-12-17 21:13:07', NULL),
(128, 'SR-123TEST', '74', 'PT Mahato inti sawit', '<p>Tanda terima ok ya kak eka</p>', 'Cemara asri berjaya 88st', '98.7065831', '3.6330933', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-17 20:48:18', '2024-12-17 21:13:23', NULL),
(129, 'SR-123TEST', '493', 'Tnda trm Adnan johan', '<p>Bayar lunas</p>', 'Psr bsr Binjai km 13.8', '98.4980159', '3.6083766', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-17 20:49:11', '2024-12-17 21:13:42', NULL),
(130, 'SR-123TEST', '394', 'Permata', '<p>Ohxlhxlhdlufoydoudupcoudpudludoufouclucoufpufpufpufpufouxoyxohxlhxlhxluflud</p>', 'Permata', '98.6814886', '3.585281', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-17 20:53:50', '2024-12-18 00:13:18', NULL),
(131, 'SR-123TEST', '394', 'Mandiri', '<p>Dhojxljchchkhhdlfdhodlhdhdhodhohxlhdludljflufludlhdohdpudlhdlhdlhdlhxljxlhxljx</p>', 'Mandiri', '98.6807593', '3.5849121', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-17 21:04:13', '2024-12-18 00:13:06', NULL),
(132, 'SR-123TEST', '74', 'PT mahana boston', '<p>Tanda terima ok ya </p>', 'Jl metal minimalisno 3', '98.6916484', '3.6393841', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-17 21:05:43', '2024-12-17 21:14:09', NULL),
(133, 'SR-123TEST', '74', 'Cv trijaya mitra plasindo', '<p>Antar sertifikat tera </p>', 'Jln cemara176', '98.6867818', '3.6295715', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-17 21:15:38', '2024-12-17 23:07:19', NULL),
(134, 'SR-123TEST', '493', 'Tnda trm yg lunas PT serim indo', '<p>Ok</p>', 'Yos Sudarso Binjai utara', '98.4897367', '3.6075648', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-17 21:48:14', '2024-12-17 23:07:48', NULL),
(135, 'SR-123TEST', '493', 'Tagihan BPK apin', '<p>Byr</p>', 'A.yani Binjai kota', '98.4866787', '3.603013', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-17 22:02:24', '2024-12-17 23:32:42', NULL),
(136, 'SR-123TEST', '493', 'Tagihan ibu Acen', '<p>Byr</p>', 'Sudirman Binjai kota', '98.4903092', '3.6087949', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-17 23:36:16', '2024-12-17 23:54:41', NULL),
(137, 'SR-123TEST', '493', 'Tagihan BPK william', '<p>Byr</p>', 'Sudirman Binjai kota', '98.490145', '3.6089328', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-17 23:51:38', '2024-12-17 23:55:01', NULL),
(138, 'SR-123TEST', '74', 'PT sinar Surya pusaka', '<p>Tanda terima ok ya kak sari</p>', 'Bilal prima d 10', '98.6787261', '3.6243518', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-18 00:13:02', '2024-12-18 01:45:09', NULL),
(141, 'SR-123TEST', '493', 'Tagihan BPK athiam', '<p>Byr</p>', 'Sudirman Binjai kota', '98.5885687', '3.61429', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-18 00:50:35', '2024-12-18 01:58:30', NULL),
(142, 'SR-123TEST', '74', 'PT inti bumi alumindotama', '<p>BAYAR CASH RP444.000</p>', 'Cerebon', '98.6836509', '3.5848206', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-18 00:55:18', '2024-12-18 01:45:28', NULL),
(143, 'SR-123TEST', '493', 'Sertifikat CV anugrah cahaya sawita / padat karya', '<p>Ok</p>', 'Jln langsa no 24  binjai', '98.5873932', '3.6117656', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-18 01:05:56', '2024-12-18 01:45:43', NULL),
(144, 'SR-123TEST', '493', 'Tagihan BPK effendy', '<p>Ok</p>', 'Jln Pendawa', '98.6310511', '3.6051591', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-18 01:53:09', '2024-12-18 01:58:18', NULL),
(145, 'SR-123TEST', '493', 'Tnda trm PT propadu', '<p>Ok</p>', 'Gaperta', '98.6689861', '3.5914831', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-18 02:25:05', '2024-12-18 19:50:01', NULL),
(146, 'SR-123TEST', '493', 'Tnda trm PT sumber bumi sawit jd jaya / cinta raja', '<p>Ok</p>', 'Taman Polonia 4 no 38', '98.6958042', '3.5372879', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-18 19:08:53', '2024-12-18 19:50:19', NULL),
(147, 'SR-123TEST', '74', 'BPK asin toko uni teknik', '<p>Tanda terima ok ya sama kak erni</p>', 'Percut komp harmoni', '98.7298564', '3.6755848', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-18 19:21:26', '2024-12-18 19:48:17', NULL),
(148, 'SR-123TEST', '74', 'PT intan sejati andalan', '<p>Tanda terima ok ya </p>', 'Jati juction', '98.6791802', '3.5967988', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-18 20:32:57', '2024-12-19 19:04:37', NULL),
(149, 'SR-123TEST', '493', 'Tnda trm PT singamas', '<p>Ok</p>', 'Komp.tritura', '98.7317927', '3.461376', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-18 20:41:22', '2024-12-19 19:05:00', NULL),
(150, 'SR-123TEST', '74', 'PT ayu bumi sejati', '<p>Tanda terima ok ya </p>', 'Podomoro apartemen', '98.6738202', '3.5932603', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-18 20:55:53', '2024-12-19 19:05:19', NULL),
(151, 'SR-123TEST', '74', 'PT kayung agro lestari', '<p>Tanda terima ok ya </p>', 'Sinarmas land lt7', '98.6724836', '3.5831422', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-18 21:14:48', '2024-12-19 19:05:40', NULL),
(152, 'SR-123TEST', '74', 'PT mentari sawit makmur', '<p>Tanda terima ok ya kak novel</p>', 'Jln s Parman 302', '98.6670383', '3.5795636', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-18 21:24:27', '2024-12-19 19:06:00', NULL),
(153, 'SR-123TEST', '493', 'Tnda trm indofarm', '<p>Ok</p>', 'Patumbak', '98.7120713', '3.5372469', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-18 21:28:22', '2024-12-19 19:06:18', NULL),
(154, 'SR-123TEST', '493', 'Tnda trm ibu jana / semesta teknik', '<p>Ok</p>', 'Pandu', '98.686681', '3.583137', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-18 22:52:31', '2024-12-19 21:10:19', NULL),
(155, 'SR-123TEST', '493', 'Tagihan BPK Erwin / Kings diesel', '<p>Ok</p>', 'Pandu', '98.686064', '3.5828468', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-18 23:02:54', '2024-12-19 21:10:35', NULL),
(156, 'SR-123TEST', '493', 'Tnda trm dan tagihan ibu Indri / macan mesin', '<p>Ok</p>', 'Pandu', '98.6860597', '3.5828803', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-18 23:12:18', '2024-12-19 21:10:55', NULL),
(157, 'SR-123TEST', '493', 'Tnda trm dan tagihan BPK David / victory', '<p>Ok</p>', 'Pandu', '98.6857199', '3.58275', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-18 23:22:19', '2024-12-19 21:11:10', NULL),
(158, 'SR-123TEST', '493', 'Tagihan ibu asiu / Kings diesel', '<p>GK byr. Janji HR Selasa.</p>', 'Pandu', '98.6842143', '3.5821405', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-18 23:31:50', '2024-12-19 21:11:27', NULL),
(159, 'SR-123TEST', '394', 'Mandiri', '<p>Gkslhxxhlxlhlhdodygklxhxkhkhdoydohxkhxhxhkxhohxlhxohxlhxlyxlhxhlhdlhdlhd</p>', 'Mandiri', '98.6741204', '3.5873964', 3, '-', NULL, NULL, NULL, '0', NULL, '2024-12-19 00:19:36', '2025-01-07 09:57:19', NULL),
(160, 'SR-123TEST', '74', 'Kl furniture', '<p>Blom ada</p>', 'Jln Budi kemasyrakatan', '98.6727145', '3.5940223', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-19 01:45:26', '2024-12-19 21:12:23', NULL),
(161, 'SR-123TEST', '493', 'Tnda trm PT sumber jaya indah nusa coy', '<p>Ok</p>', 'Juanda no 36', '98.6748821', '3.5684516', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-19 18:43:22', '2024-12-19 19:07:11', NULL),
(162, 'SR-123TEST', '74', 'Toko fajar BPK Fransiskus Halim', '<p>Tanda terima ok ya </p><p>Tagihan transfer tgl 20/12/24</p><p>Rp 1630.000</p>', 'Yos Sudarso', '98.6692943', '3.6279359', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-19 18:47:47', '2024-12-19 21:12:44', NULL),
(163, 'SR-123TEST', '493', 'Refund PT agro merak sejahtera', '<p>Ok</p>', 'Komp the palace residence', '98.6748838', '3.5685438', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-19 18:49:04', '2024-12-19 19:07:26', NULL),
(164, 'SR-123TEST', '74', 'PT universal Indofood product(unibis)', '<p>Tanda terima ok ya </p>', 'Yos Sudarso', '98.6624677', '3.6450428', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-19 19:10:36', '2024-12-19 21:30:15', NULL),
(165, 'SR-123TEST', '74', 'Mabar feed(BROILER FARM)', '<p>Tanda terima ok ya kak desi</p>', 'Jln RPH', '98.6685444', '3.6582658', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-19 19:21:47', '2024-12-19 21:30:34', NULL),
(166, 'SR-123TEST', '74', 'PT juishin Indonesia', '<p>Antar sertifikat tera </p><p>Yg tanda terima gak bisa ya</p>', 'Kim 2', '98.6957902', '3.6630214', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-19 19:39:48', '2024-12-19 21:30:52', NULL),
(167, 'SR-123TEST', '74', 'PT KDS', '<p>Blom ada</p><p>SDH 8 x di kunjungi</p>', 'Kim 2', '98.6986195', '3.6708138', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-19 19:47:49', '2024-12-19 21:31:20', NULL),
(168, 'SR-123TEST', '74', 'PT agri tanimas selaras', '<p>Tanda terima ok ya </p>', 'Kim 2 komp serbaguna', '98.6986195', '3.6708138', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-19 19:55:52', '2024-12-19 21:31:37', NULL),
(169, 'SR-123TEST', '74', 'PT bukit intan abadi', '<p>Tanda terima ok ya </p>', 'Kim2', '98.6750259', '3.6732983', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-19 20:09:23', '2024-12-19 21:31:50', NULL),
(170, 'SR-123TEST', '74', 'PT Tapteng anugrah sawit', '<p>Tagihan blom ada</p><p>Klo SDH di telpon baru dtg</p>', 'Kim 1', '98.6750259', '3.6732983', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-19 20:11:00', '2024-12-19 21:32:06', NULL),
(171, 'SR-123TEST', '493', 'Tagihan universal gloves', '<p>Ok</p>', 'Patumbak', '98.7193311', '3.5287505', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-19 20:16:37', '2024-12-19 21:32:40', NULL),
(172, 'SR-123TEST', '74', 'PT citradimensi arthali', '<p>Tanda terima ok ya </p>', 'Kim 1', '98.6739951', '3.6697045', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-19 20:29:07', '2024-12-19 21:37:14', NULL),
(173, 'SR-123TEST', '74', 'PT expravet nasuba', '<p>Bayar cash ya Rp 2.553.000 tgl 20/12/24</p>', 'Jln yos Sudarso', '98.663791', '3.6562139', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-19 20:50:03', '2024-12-19 21:37:37', NULL),
(174, 'SR-123TEST', '493', 'Tnda trm PT inocycle', '<p>Ok</p>', 'Talun kenas patumbak', '98.7069733', '3.4191183', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-19 21:18:24', '2024-12-19 21:37:52', NULL),
(175, 'SR-123TEST', '74', 'PT siringo ringo', '<p>Tanda terima ok ya</p>', 'Yos Sudarso', '98.66292', '3.6474773', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-19 21:19:10', '2024-12-19 21:38:08', NULL),
(176, 'SR-123TEST', '74', 'PT musim mas', '<p>Tanda terima ok ya </p>', 'Yos Sudarso', '98.66292', '3.6474773', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-19 21:19:55', '2024-12-19 21:39:40', NULL),
(178, 'SR-123TEST', '493', 'Bon lunas PT era karya Mukti jaya', '<p>Ok</p>', 'Bantam no 2a', '98.6651611', '3.5838521', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-20 18:22:09', '2024-12-20 22:48:50', NULL),
(179, 'SR-123TEST', '493', 'TKO mandiri jaya', '<p>Cri orderan</p>', 'Pelita btg kuis', '98.8016981', '3.6137467', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-20 19:17:32', '2024-12-21 01:58:43', NULL),
(180, 'SR-123TEST', '74', 'PT Sumatra Deli lestari indah', '<p>Tanda terima ok ya </p>', 'Jln letda Sujono no72', '98.7099769', '3.5979304', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-20 19:59:00', '2024-12-20 22:49:16', NULL),
(181, 'SR-123TEST', '74', 'PT usdama damai sejahtera', '<p>Tanda terima ok ya </p>', 'Jln besar Tembung depan (Bgr)', '98.7426346', '3.5966261', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-20 20:24:12', '2024-12-20 22:49:43', NULL),
(182, 'SR-123TEST', '493', 'Tagihan BPK Acong / TKO rezeki', '<p>Ok</p>', 'Niaga btg kuis', '98.8024481', '3.6129886', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-20 20:33:36', '2024-12-21 01:58:59', NULL),
(183, 'SR-123TEST', '493', 'TKO istana kado', '<p>Cri orderan</p>', 'Niaga btg kuis', '98.8023151', '3.6130357', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-20 20:38:12', '2024-12-21 01:59:12', NULL),
(184, 'SR-123TEST', '493', 'TKO fajar electronic', '<p>Cri orderan</p>', 'Niaga btg kuis', '98.802278', '3.6130883', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-20 20:39:33', '2024-12-21 01:58:27', NULL),
(185, 'SR-123TEST', '493', 'TKO istana electric', '<p>Cri orderan</p>', 'Niaga btg kuis', '98.8020935', '3.6130609', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-20 20:42:13', '2024-12-21 01:58:05', NULL),
(186, 'SR-123TEST', '493', 'TKO semangat baru', '<p>Cri orderan</p>', 'Veteran btg kuis', '98.8010345', '3.6132529', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-20 20:49:44', '2024-12-21 01:57:51', NULL),
(187, 'SR-123TEST', '493', 'TKO Surya mas', '<p>Cri orderan</p>', 'Niaga btg kuis', '98.8010344', '3.6132783', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-20 20:51:18', '2024-12-21 01:57:37', NULL),
(188, 'SR-123TEST', '74', 'BPK Aek toko rezeki baru', '<p>Tanda terima ok ya </p><p>SDH transfer sebesar Rp 3.260.000tgl 21/12/24</p>', 'Jln mandala by passs', '98.7110951', '3.5922062', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-20 21:05:36', '2024-12-21 01:57:17', NULL),
(189, 'SR-123TEST', '74', 'Kartini sinar bintang', '<p>Tanda terima ok ya </p>', 'Pukat7 GG indah', '98.7082685', '3.5904397', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-20 21:13:39', '2024-12-20 22:52:02', NULL),
(190, 'SR-123TEST', '394', 'Binje', '<p>Fhldhlhdhdlhdlufludhldulhdhdhkdhlhdhdhlhdlhdljflhfljflufljfljfljdlhxlhxlhxlhxlhxlhxlhhd</p>', 'Binje', '98.4929454', '3.6105074', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-20 21:13:59', '2024-12-21 01:57:03', NULL),
(191, 'SR-123TEST', '74', 'Carina toko carina', '<p>Tagihannya blom ada</p>', 'Mt haryono', '98.6853669', '3.587', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-20 23:23:05', '2024-12-21 01:56:51', NULL),
(192, 'SR-123TEST', '493', 'Tnda trm', '<p>Ok</p>', 'Rotan petisah', '98.6675038', '3.5907722', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-21 01:10:02', '2024-12-21 01:56:34', NULL),
(193, 'SR-123TEST', '493', 'Tnda trm mdn jaya', '<p>Ok</p>', 'Razak baru petisah', '98.6675056', '3.5920444', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-21 01:16:38', '2024-12-21 01:56:18', NULL),
(194, 'SR-123TEST', '493', 'Anter pesanan ibu tini', '<p>Ok</p>', 'Selat pnjg no 10', '98.6846318', '3.5836959', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-21 01:47:47', '2024-12-21 01:56:05', NULL),
(195, 'SR-123TEST', '493', 'Anter psnan ibu tini', '<p>Ok</p>', 'Ke semambu', '98.6646318', '3.5868112', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-21 02:08:52', '2024-12-22 19:43:36', NULL),
(196, 'SR-123TEST', '493', 'Tnda trm PT panca buana plasindo', '<p>Ok</p>', 'Mesjid no 142 binjai', '98.5928596', '3.5933548', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-22 19:31:34', '2024-12-22 23:47:19', NULL),
(197, 'SR-123TEST', '493', 'Tnda trm PT sinar aneka niaga', '<p>Ok</p>', 'Setia ujung no 38', '98.5665621', '3.6117628', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-22 19:55:26', '2024-12-22 23:47:35', NULL),
(198, 'SR-123TEST', '74', 'PT Belawan delichemical industri', '<p>Tanda terima ok ya </p>', 'Jln HM yamin', '98.684507', '3.5957042', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-22 20:16:40', '2024-12-22 23:47:55', NULL),
(199, 'SR-123TEST', '493', 'Tnda trm PT sukanda djaya', '<p>Ok</p>', 'Soekarno Hatta no 80', '98.5198088', '3.6079173', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-22 20:25:49', '2024-12-22 23:48:22', NULL),
(200, 'SR-123TEST', '74', 'BPK aik toko kini', '<p>Tanda terima ok ya </p>', 'Mt haryono', '98.6846794', '3.5868517', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-22 20:27:37', '2024-12-22 20:33:03', NULL),
(201, 'SR-123TEST', '74', 'Reliman anugrah Syahputra lase', '<p>Tanda terima ok ya</p>', 'Jln Bogor 46', '98.6846698', '3.5839414', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-22 20:35:09', '2024-12-22 23:48:40', NULL),
(202, 'SR-123TEST', '74', 'Irwan Medan/Deli jaya plasindo', '<p>Tanda terima ok ya </p>', 'Jln s Parman komp the crown', '98.6675567', '3.5815551', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-22 20:50:28', '2024-12-22 23:48:53', NULL),
(203, 'SR-123TEST', '74', 'Cv sistech engenering', '<p>Tanda terima ok ya </p>', 'Jln danaujempang blok b no82', '98.6583127', '3.6062853', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-22 21:16:00', '2024-12-23 02:23:41', NULL),
(204, 'SR-123TEST', '493', 'Tagihan  ibu athing / cahaya kita', '<p>Lunas</p>', 'Gatsu bharang binjai', '98.4908602', '3.609466', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-22 21:18:12', '2024-12-22 21:32:05', NULL),
(205, 'SR-123TEST', '493', 'Tagihan BPK athiam / sederhana', '<p>Lunas</p>', 'Sudirman Binjai kota', '98.563614', '3.5993797', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-22 21:48:57', '2024-12-22 23:45:24', NULL),
(206, 'SR-123TEST', '493', 'Tagihan BPK effendy', '<p>Lunas</p>', 'Pendawa no 57', '98.5945216', '3.5999724', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-22 23:48:49', '2024-12-23 00:05:34', NULL),
(207, 'SR-123TEST', '493', 'Tnda trm PT olam indo', '<p>Ok</p>', 'Mdn Binjai km 10,5', '98.627767', '3.6045729', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-23 00:05:22', '2024-12-23 02:21:25', NULL),
(208, 'SR-123TEST', '74', 'PT socfin indonesia', '<p>Tanda terima ok ya </p>', 'Jln yos Sudarso', '98.6715893', '3.6185117', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-23 18:22:52', '2024-12-24 00:17:06', NULL),
(209, 'SR-123TEST', '74', 'PT industri pembungkus Indonesia', '<p>Tanda terima ok ya </p>', 'Kim 1', '98.6702651', '3.6633192', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-23 18:43:45', '2024-12-24 00:24:07', NULL),
(210, 'SR-123TEST', '74', 'PT socimas /pak johan', '<p>Dokumen di titipkan ke refsionis</p>', 'Kim 1', '98.6742425', '3.6729212', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-23 18:55:52', '2024-12-24 00:23:50', NULL),
(211, 'SR-123TEST', '74', 'PT nauli sawit', '<p>Ambil bukti potong blom ada.</p>', 'Kim 1', '98.6749578', '3.6730094', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-23 19:05:21', '2024-12-23 23:56:46', NULL),
(212, 'SR-123TEST', '74', 'PT era cipta bina karya', '<p>Tanda terima ok ya </p>', 'Kim 1', '98.6750678', '3.672975', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-23 19:28:22', '2024-12-23 23:56:02', NULL),
(213, 'SR-123TEST', '74', 'PT cahaya alam sejati', '<p>Antar sertifikat tera </p>', 'Kim4', '98.7078832', '3.6817286', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-23 19:53:50', '2024-12-24 00:23:32', NULL),
(214, 'SR-123TEST', '74', 'PT central proteina prima', '<p>Antar sertifikat tera</p>', 'Kim 2', '98.6990045', '3.6678287', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-23 20:04:18', '2024-12-24 00:22:54', NULL),
(215, 'SR-123TEST', '74', 'PT KDS', '<p>Ambil bukti potong pph</p>', 'Kim 2', '98.6986108', '3.6709102', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-23 20:16:17', '2024-12-23 23:56:26', NULL),
(216, 'SR-123TEST', '493', 'Tagihan ibu carina', '<p>Lunas</p>', 'Mt haryono no 34 i', '98.6853185', '3.5870073', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-23 20:33:53', '2024-12-23 23:55:42', NULL),
(217, 'SR-123TEST', '74', 'PT agro jaya perdana', '<p>Antar sertifikat tera </p>', 'Jln yos Sudarso', '98.6792673', '3.71142', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-23 20:44:01', '2024-12-24 00:17:46', NULL),
(218, 'SR-123TEST', '493', 'Tagihan ibu ayen', '<p>Lunas</p>', 'Sutrisno no 173 b', '98.6999411', '3.582331', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-23 20:55:54', '2024-12-23 23:55:02', NULL),
(219, 'SR-123TEST', '74', 'BPK johan toko lima', '<p>Tidak usah TT </p><p>Bawa sekalian timbang yg service dan langsung bayar</p>', 'Marelan titi pahlawan', '98.6610113', '3.7113572', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-23 20:57:46', '2024-12-23 23:54:18', NULL),
(220, 'SR-123TEST', '74', 'Hok lai tokobahagiabersama', '<p>Tanda terima ok ya </p>', 'Marelan titi pahlawan psr 5', '98.6608178', '3.7112037', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-23 21:01:22', '2024-12-23 23:53:41', NULL),
(221, 'SR-123TEST', '493', 'Tagihan ibu asiu / king,s diesel', '<p>Nti blk jam 4</p>', 'Pandu', '98.6841826', '3.5821912', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-23 21:11:26', '2024-12-25 21:33:41', NULL),
(222, 'SR-123TEST', '493', 'Tagihan naga mas  agro mulia', '<p>Uda tlp kak adek</p>', 'S Parman no 302', '98.6672525', '3.5797377', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-23 21:31:05', '2024-12-24 00:52:23', NULL),
(223, 'SR-123TEST', '74', 'PT persada Nusantara nabati Indonesia', '<p>Ibu Marta gak masuk /cuti</p>', 'Graha metropolitan blok t7', '98.6473096', '3.6262423', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-23 21:52:24', '2024-12-24 00:18:08', NULL),
(224, 'SR-123TEST', '74', 'PT sumber kembang jaya', '<p>Tanda terima ok </p>', 'Graha metropolitan no16', '98.6473729', '3.6260755', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-23 21:54:08', '2024-12-24 00:18:27', NULL),
(225, 'SR-123TEST', '394', 'Ocbcc', '<p><br></p>', 'Ocbcc', '98.6670305', '3.5925191', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-23 22:07:13', '2024-12-23 23:52:19', NULL),
(226, 'SR-123TEST', '74', 'BPK asin (toko uni teknik)', '<p>Tanda terima ok ya</p><p>Dan bon yg lunas SDH di kasih</p>', 'Percut sientis komp harmoni', '98.7298719', '3.6755391', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-25 19:02:22', '2024-12-25 21:33:57', NULL),
(227, 'SR-123TEST', '493', 'Anter sertifikat PT Okta palm oil', '<p>Ok</p>', 'Katamso bisnis center', '98.6655377', '3.592303', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-25 19:12:49', '2024-12-25 21:29:36', NULL),
(228, 'SR-123TEST', '493', 'Tnda trm CV Surya engenering', '<p>Ok</p>', 'Gatsu no 150 b / 14', '98.6655823', '3.5922676', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-25 19:16:57', '2024-12-25 21:31:46', NULL),
(229, 'SR-123TEST', '74', 'PT versus engenering', '<p>Tanda terima ok ya </p>', 'Jln cemara', '98.6906569', '3.6295835', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-25 19:28:25', '2024-12-25 21:32:01', NULL),
(230, 'SR-123TEST', '74', 'Toko kl furniture', '<p>Tagihan blom ada</p>', 'Jln Budi kemasyarakatan', '98.6718153', '3.6213544', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-25 19:39:33', '2024-12-25 21:32:15', NULL),
(231, 'SR-123TEST', '74', 'BPK nurman', '<p>Tanda terima ok ya </p>', 'Komp villa makmur indah blok i 20', '98.6677677', '3.6057477', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-25 19:54:02', '2024-12-25 21:30:56', NULL),
(232, 'SR-123TEST', '74', 'PT Supra matra abadi', '<p>Masuk box ya</p>', 'Jln mt haryono(uniland)', '98.6824671', '3.5865928', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-25 20:12:52', '2024-12-25 21:31:10', NULL),
(233, 'SR-123TEST', '74', 'BPK apo Sumatrametalwork', '<p>Tanda terima ok ya </p>', 'Jln Sumatra 35/51', '98.6918265', '3.5896487', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-25 20:48:41', '2024-12-25 21:32:33', NULL),
(234, 'SR-123TEST', '74', 'PT adimuliasari mas', '<p>Tanda terima ok </p>', 'Hotel Adi muliaq', '98.6721367', '3.5847796', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-25 21:05:53', '2024-12-25 21:31:26', NULL),
(235, 'SR-123TEST', '493', 'Tagihan BPK ahuay / mjs', '<p>Lunas</p>', 'Katamso', '98.686164', '3.5829384', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-25 21:14:21', '2024-12-25 21:32:49', NULL),
(236, 'SR-123TEST', '493', 'Tagihan dan tnda trm BPK Erwin / king,s jaya', '<p>Tnda trm Ok klo tagihan GK byr Krn Koko nya Uda pgr jln2.</p>', 'Pandu', '98.685814', '3.5827584', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-25 21:23:51', '2024-12-25 21:33:25', NULL),
(237, 'SR-123TEST', '493', 'Tagihan ibu Indri / istana mesin', '<p>Bsk</p>', 'Pandu', '98.6857467', '3.5827414', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-25 21:38:51', '2024-12-25 21:42:07', NULL),
(238, 'SR-123TEST', '493', 'Tagihan dan tnda trm ibu asiu / king,s diesel', '<p>Ok</p>', 'Pandu', '98.6842', '3.5821869', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-25 21:44:44', '2024-12-26 00:15:05', NULL),
(239, 'SR-123TEST', '493', 'Tnda trm dan sertifikat PT palmaris raya', '<p>Ok</p>', 'A. Rivai no 6', '98.6733789', '3.5779325', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-26 00:36:30', '2024-12-26 02:01:31', NULL),
(240, 'SR-123TEST', '74', 'Fransiskus Halim toko fajar', '<p>Tanda terima ok </p>', 'Jln yos Sudarso', '98.6693167', '3.6279508', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-26 18:42:03', '2024-12-27 01:04:12', NULL),
(241, 'SR-123TEST', '493', 'Tnda trm PT ensem sawita dan para sawita', '<p>Ok</p>', 'Kalimantan no 1 h', '98.6918781', '3.5896343', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-26 18:49:13', '2024-12-26 20:13:53', NULL),
(242, 'SR-123TEST', '493', 'Tnda trm CV Sumatra metal works', '<p>Ok</p>', 'Jln Sumatra simp.jln jambi', '98.6918921', '3.5896462', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-26 18:51:15', '2024-12-26 20:14:17', NULL),
(243, 'SR-123TEST', '74', 'PT inti benua perkasatama', '<p>Antar sertifikat tera </p>', 'Yos Sudarso', '98.6622747', '3.6472131', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-26 18:58:10', '2024-12-26 20:14:37', NULL),
(244, 'SR-123TEST', '493', 'Tnda trm PT prima tangki indo', '<p>Ok</p>', 'Rencong no 1 b', '98.7038896', '3.5897256', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-26 19:11:06', '2024-12-26 20:15:19', NULL),
(245, 'SR-123TEST', '74', 'PT able comoditis Indonesia', '<p>Tanda terima ok </p>', 'Jln kapt Ilyas simpang kantor labuhan', '98.6808368', '3.7269143', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-26 19:29:54', '2024-12-26 20:16:47', NULL),
(246, 'SR-123TEST', '493', 'Bon lunas BPK ahuay / berkah sejahtera', '<p>Ok</p>', 'Sm.raja no 38 e', '98.6986282', '3.5499521', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-26 19:40:02', '2024-12-26 21:21:51', NULL),
(247, 'SR-123TEST', '74', 'PT dehael Nusantara logistik', '<p>Tanda terima ok </p>', 'Lkim3 pemagaran', '98.7011801', '3.6813549', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-26 20:02:23', '2024-12-26 20:17:06', NULL),
(248, 'SR-123TEST', '394', 'Niaga', '<p>Niaga</p>', 'Niaga', '98.6739626', '3.5863879', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-26 20:03:17', '2024-12-26 21:22:07', NULL),
(249, 'SR-123TEST', '74', 'PT KDS', '<p>Antar bon lunas</p>', 'Kim 2 tanah masa', '98.6986619', '3.6708775', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-26 20:08:13', '2024-12-26 20:17:35', NULL),
(250, 'SR-123TEST', '74', 'PT Tapteng anugrah sawit', '<p>Bayar giro permata bank</p><p>Jumlah Rp 19.839.500</p><p>No giro696017</p><p>Potong pph Rp 85 ribu</p>', 'Kim 1', '98.6749596', '3.6730068', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-26 20:46:56', '2024-12-26 20:53:56', NULL),
(251, 'SR-123TEST', '493', 'Tagihan BPK Kim heng / sepakat', '<p>Byr 1,5 jt</p>', 'Irian tnjg morawa', '98.7920014', '3.5169262', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-26 21:10:23', '2024-12-26 21:22:21', NULL),
(252, 'SR-123TEST', '74', 'PT siringo ringo', '<p>Invoice lebih dari 3 harus di titipkan karena kasir 2orang</p>', 'Jln yos Sudarso', '98.6628939', '3.6475839', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-26 21:38:42', '2024-12-27 01:03:38', NULL),
(253, 'SR-123TEST', '493', 'Tagihan BPK along / cahaya', '<p>Lunas</p>', 'Dahlan tnjg morawa', '98.7920771', '3.5459916', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-26 21:40:16', '2024-12-26 21:45:48', NULL),
(254, 'SR-123TEST', '74', 'PT persadanusa nabati Indonesia', '<p>Revisi</p>', 'Graha metropolitan blok t7', '98.6473052', '3.6262305', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-26 22:03:57', '2024-12-27 01:03:22', NULL),
(255, 'SR-123TEST', '74', 'Toko serba ada', '<p>Tagihan blom ada </p><p>Harap si wa dulu bosnya</p>', 'Jln yos Sudarso', '98.6625614', '3.6243839', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-26 22:33:22', '2024-12-27 01:01:17', NULL),
(256, 'SR-123TEST', '493', 'Tnda trm PT Asia raya foundry', '<p>Ok</p>', 'Sei blumai', '98.6804588', '3.5700985', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-26 23:09:59', '2024-12-27 01:03:06', NULL),
(257, 'SR-123TEST', '493', 'Tnda trm PT sumber bumi sawit jd jaya', '<p>Ok</p>', 'Taman Polonia 4 no 38', '98.6871949', '3.5803512', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-26 23:23:48', '2024-12-27 01:02:52', NULL),
(258, 'SR-123TEST', '493', 'Tagihan ibu Fanny / laris jaya', '<p>GK byr. Di srh blk tgl 15 BLN 1.</p>', 'P. Sambas no 28', '98.6873369', '3.5803148', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-26 23:27:52', '2024-12-27 01:01:36', NULL),
(259, 'SR-123TEST', '493', 'Tnda trm ibu zenny / mulia diesel', '<p>Ok</p>', 'Pandu', '98.6865565', '3.5830546', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-26 23:35:47', '2024-12-27 01:01:51', NULL),
(260, 'SR-123TEST', '493', 'Tagihan ibu Indri / istana mesin', '<p>Lunas</p>', 'Pandu', '98.68568', '3.5827128', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-26 23:41:36', '2024-12-27 01:02:03', NULL),
(261, 'SR-123TEST', '493', 'Tagihan BPK awi / harapan baru', '<p>THN dpn HR Sabtu.</p>', 'P. Pasar no 197', '98.6864597', '3.5901708', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-26 23:52:53', '2024-12-27 01:02:20', NULL),
(262, 'SR-123TEST', '74', 'Alai sg', '<p>Bayar cash Rp 54.532.000</p>', 'Jln Yos Sudarso', '98.674236', '3.6097973', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-27 01:54:10', '2024-12-27 01:58:14', NULL);
INSERT INTO `tb_collect` (`id`, `no_sr`, `kode_pegawai`, `title`, `keterangan`, `location`, `longitude`, `latitude`, `status`, `notes`, `have_paid`, `payment_type`, `payment_amount`, `validate_by`, `assign_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(263, 'SR-123TEST', '493', 'Tnda trm inti tera prima yudha', '<p>Ok</p>', 'Waringin no 9', '98.667851', '3.594211', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-27 02:21:47', '2024-12-27 02:23:36', NULL),
(264, 'SR-123TEST', '493', 'Tagihan PT sari tani jaya sumatra', '<p>Lunas</p>', 'CBD polonia blok f no 17', '98.6885215', '3.5544678', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-27 19:37:36', '2024-12-27 19:49:15', NULL),
(265, 'SR-123TEST', '493', 'TKO ingat jaya', '<p>Cri orderan</p>', 'Katamso no 156 f', '98.6884497', '3.554424', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-27 19:38:54', '2024-12-28 00:06:31', NULL),
(266, 'SR-123TEST', '74', 'BPK henry', '<p>Antar bon lunas</p>', 'Jln bakaranbatu14aa', '98.6951594', '3.5857965', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-27 20:25:01', '2024-12-28 00:06:41', NULL),
(267, 'SR-123TEST', '74', 'BPK Aek rezeki baru', '<p>Bayar via transfer ya sebesar Rp 2400.000</p><p><br></p>', 'Jln mandala bypass', '98.7111038', '3.5922174', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-27 21:59:23', '2024-12-28 00:06:54', NULL),
(268, 'SR-123TEST', '74', 'BPK johan', '<p>Bayar cash Rp 600.000</p>', 'Jln Sumatra no35', '98.6917946', '3.5896605', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-27 22:12:52', '2024-12-28 00:07:31', NULL),
(269, 'SR-123TEST', '493', 'Tagihan BPK aho / bintang tetang', '<p>Tagihan blm ada dan orderan jg blm ada.</p>', 'Pusat psar no  519 / 520', '98.5826407', '3.6097246', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-27 23:28:16', '2024-12-28 00:07:43', NULL),
(270, 'SR-123TEST', '493', 'Tagihan BPK effendy', '<p>Lunas</p>', 'Pendawa no 57 binjai', '98.5798536', '3.6023902', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-27 23:56:13', '2024-12-28 00:08:30', NULL),
(271, 'SR-123TEST', '493', 'TKO saudara', '<p>Cri orderan</p>', 'Pembangunan binjai', '98.5798455', '3.6023979', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-27 23:58:48', '2024-12-28 00:09:03', NULL),
(272, 'SR-123TEST', '74', 'Cv fauntain', '<p>Bayar cash Rp 743.700</p>', 'Jln h wuruk', '98.663829', '3.5818059', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-28 00:07:01', '2024-12-28 00:20:59', NULL),
(273, 'SR-123TEST', '493', 'Turbo laundry', '<p>Cri orderan</p>', 'Pembangunan binjai', '98.6528169', '3.607567', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-28 00:28:22', '2024-12-28 00:58:39', NULL),
(274, 'SR-123TEST', '493', 'Tagihan ibu afang / rajawali', '<p>Blm ada</p>', 'Rotan petisah', '98.6675618', '3.590762', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-28 01:43:54', '2024-12-28 02:02:31', NULL),
(275, 'SR-123TEST', '493', 'Tagihan mdn jaya', '<p>Lunas</p>', 'Razak baru petisah', '98.6678297', '3.5926278', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-28 01:55:28', '2024-12-28 02:02:43', NULL),
(276, 'SR-123TEST', '493', 'Tnda trm PT sumber tani agung', '<p>Ok</p>', 'Cambrige', '98.5944661', '3.6006615', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-29 19:08:34', '2024-12-30 01:51:32', NULL),
(277, 'SR-123TEST', '74', 'PT aep grup', '<p>Antar kalender</p>', 'Gd sinar masland lt3', '98.6724961', '3.5832355', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-29 19:21:55', '2024-12-30 01:51:16', NULL),
(278, 'SR-123TEST', '74', 'Cv Surya engenering', '<p>Tanda terima ok y</p>', 'Jln Gatot Subroto', '98.665708', '3.5921772', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-29 19:35:10', '2024-12-29 23:53:33', NULL),
(279, 'SR-123TEST', '493', 'Sertifikat PT olam indo', '<p>Ok</p>', 'Mdn Binjai km 10,5', '98.5222077', '3.607245', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-29 19:35:54', '2024-12-30 01:51:00', NULL),
(280, 'SR-123TEST', '74', 'PT citra sawit mandiri', '<p>Tanda terima ok ya</p>', 'Gd CIMB niaga lt10', '98.6742', '3.5864803', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-29 20:04:50', '2024-12-30 01:50:41', NULL),
(281, 'SR-123TEST', '493', 'Tnda trm yg Uda lunas CV makmur palas', '<p>Ok</p>', 'Mdn Binjai km 18,6', '98.4986408', '3.6083392', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-29 20:50:47', '2024-12-30 01:50:26', NULL),
(282, 'SR-123TEST', '493', 'Tagihan BPK APIN / sinar baru', '<p>Blm ada</p>', 'A. Yani Binjai kota', '98.489788', '3.6075819', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-29 21:00:23', '2024-12-29 23:55:26', NULL),
(283, 'SR-123TEST', '493', 'TKO mulia', '<p>Cri orderan</p>', 'A. Yani no 241 Binjai kota', '98.4901989', '3.608067', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-29 21:09:35', '2024-12-29 23:55:06', NULL),
(284, 'SR-123TEST', '493', 'Tagihan ibu amei / berkah abadi', '<p>Blm ada</p>', 'A. Yani Binjai kota', '98.4895253', '3.6072533', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-29 21:13:09', '2024-12-29 23:54:53', NULL),
(285, 'SR-123TEST', '493', 'Tnda trm CV fanghin', '<p>Ok</p>', 'Sudirman Binjai kota', '98.490843', '3.6094483', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-29 21:35:16', '2024-12-30 01:49:00', NULL),
(286, 'SR-123TEST', '74', 'PT bumi Tamiang sentosa', '<p>Tanda terima ok ya </p>', 'CBD blok bb20/22', '98.6771652', '3.5598985', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-29 21:44:02', '2024-12-30 01:49:20', NULL),
(287, 'SR-123TEST', '493', 'Tagihan BPK athiam / sederhana', '<p>Lunas</p>', 'Sudirman Binjai kota', '98.645541', '3.6051618', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-29 22:29:54', '2024-12-29 23:54:28', NULL),
(288, 'SR-123TEST', '74', 'Kilang padi tunasjaya nur nadimin', '<p>Antar sertifikat tera </p>', 'Jln ar hakim no 128', '98.7035276', '3.5769429', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-29 23:49:03', '2024-12-30 01:49:55', NULL),
(289, 'SR-123TEST', '493', 'TKO laris', '<p>Cri orderan</p>', 'Razak baru no 12 a', '98.6676853', '3.5919242', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-30 01:13:57', '2024-12-30 01:43:33', NULL),
(290, 'SR-123TEST', '493', 'TKO istana kado', '<p>Cri orderan</p>', 'Razak baru petisah', '98.6677855', '3.5919119', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-30 01:15:58', '2024-12-30 01:44:10', NULL),
(291, 'SR-123TEST', '493', 'TKO bahagia', '<p>Cri orderan</p>', 'Razak baru petisah', '98.6679349', '3.5915503', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-30 01:19:04', '2024-12-30 01:43:03', NULL),
(292, 'SR-123TEST', '74', 'PT Kalimantan hamparan sawit', '<p>Tanda terima ok ya </p>', 'Jln Adam Malik 25', '98.6690283', '3.5972707', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-30 01:32:24', '2024-12-30 01:50:10', NULL),
(293, 'SR-123TEST', '74', 'PT semadam', '<p>BAYAR cash Rp 3.108.000</p>', 'Jln Nibung 93', '98.6647198', '3.5878503', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-30 02:14:09', '2024-12-30 02:26:28', NULL),
(294, 'SR-123TEST', '74', 'BPK aho', '<p>Antar sertifikat tera </p>', 'Vila makmur mas I18', '98.6677628', '3.6057601', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-30 19:17:33', '2024-12-30 23:06:56', NULL),
(295, 'SR-123TEST', '74', 'PT socfin Indonesia', '<p>Antar sertifikat tera </p>', 'Jln yos Sudarso', '98.6716119', '3.6186404', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-30 19:26:09', '2024-12-30 23:07:09', NULL),
(296, 'SR-123TEST', '74', 'PT berlian eka sakti tangguh', '<p>Tutup </p><p>Minggu depan baru buka lagi</p>', 'Yos Sudarso', '98.669079', '3.6324935', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-30 19:34:42', '2024-12-30 23:07:30', NULL),
(297, 'SR-123TEST', '493', 'Tnda trm PT naga mas agro mulia', '<p>Ok</p>', 'S. Parman', '98.6670843', '3.5796144', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-30 19:35:00', '2024-12-30 23:07:47', NULL),
(298, 'SR-123TEST', '74', 'PT berlian eka sakti tangguh', '<p>Tutup </p><p>Minggu depan baru buka lagi </p>', 'Yos Sudarso', '98.6693807', '3.6325045', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-30 19:36:39', '2024-12-30 23:08:10', NULL),
(299, 'SR-123TEST', '74', 'PT musim mas', '<p>Antar sertifikat tera </p>', 'Jln Yos Sudarso', '98.662444', '3.6472257', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-30 19:44:54', '2024-12-30 23:08:21', NULL),
(300, 'SR-123TEST', '74', 'PT Mabar feed indonesia', '<p>Tutup</p><p>Minggu depan </p>', 'RPH', '98.6685363', '3.6582655', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-30 19:53:13', '2024-12-30 23:08:38', NULL),
(301, 'SR-123TEST', '493', 'Tnda trm PT rajawli', '<p>Lunas</p>', 'Gemilang', '98.6904179', '3.5669492', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-30 20:12:24', '2024-12-30 23:08:50', NULL),
(302, 'SR-123TEST', '493', 'Tnda trm PT indojaya', '<p>Ok</p>', 'Mdn tnjg morawa', '98.7564563', '3.5262368', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-30 20:47:29', '2024-12-30 23:09:06', NULL),
(303, 'SR-123TEST', '74', 'PT Bgr logistik', '<p>Tanda terima ok </p>', 'Paya pasir titi pahlawan', '98.6724468', '3.7191674', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-30 21:18:56', '2024-12-30 23:09:16', NULL),
(304, 'SR-123TEST', '74', 'BPK johan toko lima jaya', '<p>Tanda terima ok ya </p>', 'Titi pahlawan Marelan', '98.6609381', '3.7113279', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-30 21:36:43', '2024-12-30 23:09:33', NULL),
(305, 'SR-123TEST', '493', 'Tnda trm PT medisafe', '<p>Ok</p>', 'Tambak rejo', '98.786988', '3.5340813', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-30 21:51:45', '2024-12-30 23:09:45', NULL),
(306, 'SR-123TEST', '493', 'Tagihan BPK awi', '<p>Blm ad</p>', 'Dahlan tnjg morawa', '98.7928384', '3.5173656', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-30 22:06:01', '2024-12-30 23:10:20', NULL),
(307, 'SR-123TEST', '493', 'Tagihan BPK ferry', '<p>Blm ada</p>', 'Irian tnjg morawa', '98.7928532', '3.5173301', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-30 22:07:06', '2024-12-30 23:10:38', NULL),
(308, 'SR-123TEST', '493', 'Tagihan BPK iwanto', '<p>Blm ada</p>', 'Dalam tnjg morawa', '98.7909178', '3.5173436', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-30 22:09:54', '2024-12-30 23:10:54', NULL),
(309, 'SR-123TEST', '493', 'Tagihan bilah baja makmur abadi', '<p>Tutup</p>', 'Wajit', '98.6808967', '3.5826447', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-30 23:46:52', '2024-12-30 23:54:03', NULL),
(310, 'SR-123TEST', '74', 'PT era cipta bina karya', '<p>Giro Maybank </p><p>No DE501891</p>', 'Kim 1', '98.6751091', '3.6729526', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-30 23:49:30', '2024-12-30 23:54:19', NULL),
(311, 'SR-123TEST', '74', 'PT era cipta bina karya', '<p>Tanda terima ok </p>', 'Kim 1', '98.6750489', '3.6730201', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-30 23:57:48', '2024-12-31 00:05:26', NULL),
(312, 'SR-123TEST', '74', 'PT socimas', '<p>Ambil dokumen</p>', 'Kim 1', '98.6741503', '3.673317', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-31 00:08:27', '2024-12-31 00:12:22', NULL),
(313, 'SR-123TEST', '74', 'PT intan hevea industri', '<p>Cash Rp 99.900</p>', 'Kim1', '98.6732725', '3.6739938', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-31 00:21:32', '2024-12-31 00:28:28', NULL),
(314, 'SR-123TEST', '74', 'PT indoglove', '<p>Tutup </p><p>Tgl 6 buka</p>', 'Kim 1', '98.6725879', '3.6751', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-31 00:29:47', '2024-12-31 00:36:08', NULL),
(315, 'SR-123TEST', '74', 'PT Chandra kemas indonesia(ipi)', '<p>Antar sertifikat tera </p>', 'Kim1', '98.6701582', '3.6633382', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-31 00:58:21', '2024-12-31 01:56:57', NULL),
(316, 'SR-123TEST', '74', 'Cv tepat teknik', '<p>Tutup </p>', 'Yos Sudarso', '98.6723425', '3.6148366', 1, NULL, NULL, NULL, NULL, '0', NULL, '2024-12-31 01:34:06', '2024-12-31 01:57:10', NULL),
(317, 'SR-123TEST', '493', 'Tnda trm PT phg', '<p>Ok</p>', 'Ismud no 107', '98.6606716', '3.5845042', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-01 18:21:39', '2025-01-02 02:20:45', NULL),
(318, 'SR-123TEST', '74', 'PT intratek', '<p>Masih tutup </p>', 'Jln kepribadian 2', '98.6772173', '3.5889457', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-01 19:56:03', '2025-01-02 02:20:58', NULL),
(319, 'SR-123TEST', '74', 'PT gotong royong jaya', '<p>Tanda terima ok </p>', 'Jln hindu33', '98.6771903', '3.5875908', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-01 20:04:14', '2025-01-02 02:22:02', NULL),
(320, 'SR-123TEST', '74', 'Ud sedehana', '<p>Tanda terima ok </p>', 'Jln kereta api', '98.6814113', '3.586479', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-01 21:11:13', '2025-01-02 02:22:15', NULL),
(321, 'SR-123TEST', '74', 'PT intan sejati andalan', '<p>Tutup </p>', 'Jati juction', '98.6791591', '3.5967725', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-01 21:22:54', '2025-01-02 02:22:28', NULL),
(322, 'SR-123TEST', '493', 'Tnda trm PT sumber bumi sawit jd jaya', '<p>Ok</p>', 'Taman Polonia 4 no 38', '98.6804401', '3.5701408', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-01 21:35:57', '2025-01-02 02:22:42', NULL),
(323, 'SR-123TEST', '74', 'PT buana sawit indah', '<p>Tanda terima tidak  bisa no NPWP salah</p>', 'Jln sei kera 131', '98.6913013', '3.5958992', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-01 21:37:43', '2025-01-02 02:22:54', NULL),
(324, 'SR-123TEST', '493', 'Tagihan BPK amin / mja', '<p>Minggu dpn di tf</p>', 'Komp Sanur no 9 Deli tua', '98.679926', '3.5170064', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-01 22:11:05', '2025-01-02 02:20:31', NULL),
(325, 'SR-123TEST', '493', 'Tnda trm BPK ahuay / mjs', '<p>Ok</p>', 'Katamso GG sepakat no 39', '98.6842032', '3.5433124', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-01 22:29:39', '2025-01-02 02:19:22', NULL),
(326, 'SR-123TEST', '74', 'BPK asin', '<p>Tanda terima ok </p>', 'Komp harmoni sientis Percut', '98.7298571', '3.6755725', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-01 23:36:08', '2025-01-02 02:18:49', NULL),
(327, 'SR-123TEST', '74', 'PT Mahato inti sawit', '<p>Tagihan kasir libur</p><p>Tandai terima ok</p>', 'Cemara asri berjaya', '98.7065791', '3.6330954', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-01 23:57:10', '2025-01-02 02:18:38', NULL),
(328, 'SR-123TEST', '493', 'Tagihan dan tnda trm BPK Erwin / king,s jaya', '<p>Ok</p>', 'Pandu no 67', '98.6858359', '3.5827631', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-02 00:10:31', '2025-01-02 02:18:21', NULL),
(329, 'SR-123TEST', '493', 'Tnda trm BPK David / victory', '<p>Ok</p>', 'Pandu no 10', '98.6858759', '3.5827959', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-02 00:13:54', '2025-01-02 02:18:02', NULL),
(330, 'SR-123TEST', '74', 'PT ocean', '<p>Tanda terima ok </p>', 'Jln cemara', '98.703218', '3.6283939', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-02 00:15:32', '2025-01-02 02:17:48', NULL),
(331, 'SR-123TEST', '74', 'PT saintifik Indonesia', '<p>Tutup </p>', 'Jln karakatau ujung 10a', '98.6810402', '3.6295353', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-02 01:09:38', '2025-01-02 02:17:34', NULL),
(332, 'SR-123TEST', '74', 'PT bangun sempurna lestari', '<p>Tanda terima ok </p>', 'Jln karakatau 10e', '98.6811643', '3.6291794', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-02 01:13:26', '2025-01-02 02:17:15', NULL),
(333, 'SR-123TEST', '74', 'Kl furniture', '<p>Blom ada(tutup)</p>', 'Jln Budi kemasyarakatan', '98.671695', '3.6213304', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-02 01:32:50', '2025-01-02 02:17:00', NULL),
(334, 'SR-123TEST', '493', 'Tnda trm PT ensem sawita', '<p>Ok</p>', 'Kalimantan no 1g', '98.6906089', '3.5905023', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-02 18:50:42', '2025-01-03 01:09:48', NULL),
(335, 'SR-123TEST', '74', 'PT socfin Indonesia', '<p>Tanda terima ok</p>', 'Yos Sudarso', '98.6715431', '3.6186017', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-02 19:03:27', '2025-01-03 01:09:35', NULL),
(336, 'SR-123TEST', '493', 'Tagihan , tnda trm dan sertifikat', '<p>Lunas dan ok</p>', 'Gandhi no 111', '98.6902545', '3.5833352', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-02 19:19:52', '2025-01-03 01:09:22', NULL),
(337, 'SR-123TEST', '74', 'PT universal Indofood product', '<p>Tanda terima ok </p>', 'Yos Sudarso', '98.6625295', '3.6446935', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-02 19:39:51', '2025-01-03 01:09:02', NULL),
(338, 'SR-123TEST', '74', 'PT Mabar feed', '<p>Tanda terima ok </p><p>Klo tagihan blom ada</p>', 'RPH', '98.6684596', '3.658009', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-02 20:02:21', '2025-01-03 01:08:44', NULL),
(339, 'SR-123TEST', '74', 'PT sumber setamurni', '<p>Tanda terima ok </p>', 'Kim 1', '98.6760998', '3.6701935', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-02 20:33:32', '2025-01-03 01:08:26', NULL),
(340, 'SR-123TEST', '493', 'Tagihan CV jaya perkasa abadi', '<p>Blm ada</p>', 'Industri no 60 tnjg morawa', '98.8064334', '3.5284405', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-02 20:42:44', '2025-01-03 01:08:11', NULL),
(341, 'SR-123TEST', '74', 'PT growth asia', '<p>Tanda terima ok </p>', 'Kim1', '98.669723', '3.6704244', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-02 20:47:30', '2025-01-03 01:07:58', NULL),
(342, 'SR-123TEST', '74', 'PT indoglove', '<p>Libur</p>', 'Kim 1', '98.6725091', '3.6751065', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-02 20:53:50', '2025-01-03 01:07:44', NULL),
(343, 'SR-123TEST', '493', 'Toko jakarta', '<p>Cri orderan</p>', 'Irian no 159 tnjg morawa', '98.7932734', '3.5180679', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-02 21:03:59', '2025-01-03 01:07:26', NULL),
(344, 'SR-123TEST', '493', 'Tagihan BPK Kim heng / sepakat', '<p>Lunas</p>', 'Irian no 110  tnjg morawa', '98.7932626', '3.5180627', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-02 21:05:18', '2025-01-03 01:07:13', NULL),
(345, 'SR-123TEST', '493', 'TKO indah mekar jaya / BPK ferry', '<p>Cri orderan</p>', 'Irian no 150 tnjg morawa', '98.792881', '3.5173497', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-02 21:08:19', '2025-01-03 01:06:45', NULL),
(346, 'SR-123TEST', '493', 'Tagihan BPK along / cahaya', '<p>Blm ada</p>', 'Dahlan tnjg no 94 tnjg morawa', '98.7884002', '3.5190837', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-02 21:14:49', '2025-01-03 01:06:34', NULL),
(347, 'SR-123TEST', '74', 'PT global inovasi prima', '<p>Tanda terima ok </p>', 'Jln Yos Sudarso km 13.1 no 3', '98.6716377', '3.6927413', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-02 21:58:52', '2025-01-03 01:06:12', NULL),
(348, 'SR-123TEST', '74', 'PT rajawali perkasa Sakti', '<p>Tanda terima ok </p>', 'Jln ileng komp grand permata hijau', '98.6766342', '3.7134509', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-02 22:08:54', '2025-01-03 01:05:52', NULL),
(349, 'SR-123TEST', '493', 'Tagihan PT bilah baja makmur abadi', '<p>Lunas</p>', 'Cakrawati no 5', '98.6809068', '3.582672', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-02 23:21:11', '2025-01-03 01:05:35', NULL),
(350, 'SR-123TEST', '493', 'Tagihan BPK aik / TKO kini', '<p>Lunas</p>', 'Mt haryono no 51', '98.6846708', '3.5867266', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-02 23:59:09', '2025-01-03 01:01:15', NULL),
(351, 'SR-123TEST', '74', 'PT siringo ringo sarana esa musim mas.multi persada gatramegah p', '<p>Tanda terima ok </p>', 'Yos Sudarso', '98.6629112', '3.6474105', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-03 00:33:03', '2025-01-03 01:00:52', NULL),
(352, 'SR-123TEST', '493', 'Tnda trm PT varem sawit cemerlan', '<p>Ok</p>', 'Griya dom', '98.6517741', '3.6075888', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-03 00:37:01', '2025-01-03 01:00:33', NULL),
(353, 'SR-123TEST', '493', 'Tnda trm PT rapala', '<p>Ok</p>', 'Sei btg hari no 92', '98.6466578', '3.5850553', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-03 00:49:32', '2025-01-03 00:59:30', NULL),
(354, 'SR-123TEST', '74', 'BPK awi', '<p>Tanda terima ok </p><p>Tagihan bayar cash Rp 978.000</p>', 'Rahayu4', '98.65853', '3.6325426', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-03 00:50:39', '2025-01-03 00:59:15', NULL),
(355, 'SR-123TEST', '74', 'Toko perabot serba ada', '<p>Bayar cash rp840.000</p><p>Potong SPSI rp10.000</p>', 'Yos Sudarso', '98.6696968', '3.6298352', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-03 01:16:33', '2025-01-03 01:47:07', NULL),
(356, 'SR-123TEST', '74', 'BPK Fransiskus Halim', '<p>Blom ada</p>', 'Yos Sudarso', '98.6694596', '3.6280092', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-03 01:22:46', '2025-01-03 01:47:19', NULL),
(357, 'SR-123TEST', '74', 'Cv tepat teknik', '<p>Blom ada</p>', 'Yos Sudarso', '98.6709305', '3.6207705', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-03 01:32:26', '2025-01-03 01:47:33', NULL),
(358, 'SR-123TEST', '493', 'Bon lunas BPK Andre / mandiri jaya', '<p>Ok</p>', 'Pelita btg kuis', '98.8010238', '3.6138369', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-03 18:54:20', '2025-01-05 19:21:22', NULL),
(359, 'SR-123TEST', '74', 'PT sari incofood', '<p>Tanda terima ok </p>', 'Jln Cokroaminoto', '98.6922698', '3.5919803', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-03 20:03:00', '2025-01-05 19:23:10', NULL),
(360, 'SR-123TEST', '74', 'PT STTC', '<p>Tanda terima ok </p>', 'Jln Cokroaminoto', '98.6922571', '3.591972', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-03 20:06:33', '2025-01-05 19:23:21', NULL),
(361, 'SR-123TEST', '74', 'PT sari incofood', '<p>Antar sertifikat tera </p>', 'Jln Cokroaminoto', '98.6927645', '3.5920925', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-03 20:11:45', '2025-01-05 19:23:35', NULL),
(362, 'SR-123TEST', '493', 'TK rezeki / BPK acong', '<p>Cri orderan</p>', 'Niaga btg kuis', '98.80245', '3.6130199', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-03 20:12:04', '2025-01-05 19:23:47', NULL),
(363, 'SR-123TEST', '493', 'TK istana kado', '<p>Cri orderan</p>', 'Niaga btg kuis', '98.8023372', '3.6130908', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-03 20:14:24', '2025-01-05 19:24:04', NULL),
(364, 'SR-123TEST', '493', 'TK fajar electronic', '<p>Cri orderan</p>', 'Niaga btg kuis', '98.8023011', '3.6130618', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-03 20:15:41', '2025-01-05 19:24:16', NULL),
(365, 'SR-123TEST', '493', 'TK istana electric', '<p>Cri orderan</p>', 'Niaga btg kuis', '98.8019726', '3.6131143', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-03 20:17:04', '2025-01-05 19:24:32', NULL),
(366, 'SR-123TEST', '493', 'TK semangat baru', '<p>Cri orderan</p>', 'Veteran btg kuis', '98.8007046', '3.6129033', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-03 20:23:31', '2025-01-05 19:24:46', NULL),
(367, 'SR-123TEST', '493', 'TK Surya mas', '<p>Cri orderan</p>', 'Niaga btg kuis', '98.8010306', '3.6133037', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-03 20:30:16', '2025-01-05 19:25:09', NULL),
(368, 'SR-123TEST', '74', 'PT usdama damai sejahtera', '<p>Antar sertifikat tera </p>', 'Jln Tembung depan Bgr', '98.7426297', '3.5966044', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-03 20:36:13', '2025-01-05 19:22:56', NULL),
(369, 'SR-123TEST', '74', 'BPK aek', '<p>Tanda terima </p>', 'Mandala by pass', '98.711073', '3.5922145', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-03 20:53:04', '2025-01-05 19:22:46', NULL),
(370, 'SR-123TEST', '74', 'Kartini sinar bintang', '<p>Antar sertifikat tera </p>', 'Jln pukat7 GG indah', '98.7083111', '3.590519', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-03 21:04:39', '2025-01-05 19:22:36', NULL),
(371, 'SR-123TEST', '493', 'Tagihan BPK aho', '<p>Blm ada</p>', 'P. Psar no 519', '98.6865258', '3.5900714', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-03 22:55:45', '2025-01-05 19:22:24', NULL),
(372, 'SR-123TEST', '394', 'P pasar', '<p>P pasar</p>', 'P pasar', '98.6864811', '3.5901473', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-03 22:58:48', '2025-01-05 19:22:13', NULL),
(373, 'SR-123TEST', '493', 'Tagihan BPK awi', '<p>Lunas</p>', 'P. psar no 197', '98.6844288', '3.5913438', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-03 23:31:24', '2025-01-05 19:21:57', NULL),
(374, 'SR-123TEST', '74', 'Surya perabot', '<p>Tagihan blom jatuh tempo</p><p>Bos gak mau bayar</p>', 'Jln ar hakim', '98.7037242', '3.5797989', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-03 23:36:18', '2025-01-05 19:21:43', NULL),
(375, 'SR-123TEST', '493', 'Tnda trm PT everbright', '<p>Ok</p>', 'Rasak no 7', '98.6663686', '3.5935565', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-05 18:28:19', '2025-01-05 23:08:55', NULL),
(376, 'SR-123TEST', '493', 'Tnda trm PT Agra garlica lestari', '<p>Ok</p>', 'Komp.ruko Merbau mas no 95', '98.6621471', '3.5946215', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-05 18:37:58', '2025-01-05 23:39:09', NULL),
(377, 'SR-123TEST', '493', 'Tnda trm PT  permata hijau indo', '<p>Ok</p>', 'Ismud no 107', '98.6606286', '3.58452', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-05 18:50:39', '2025-01-05 23:39:39', NULL),
(378, 'SR-123TEST', '74', 'PT sinar Bengkulu Selatan', '<p>Tanda terima ok </p>', 'Jln candi Kalasan', '98.6718549', '3.5887568', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-05 19:51:13', '2025-01-05 23:40:43', NULL),
(379, 'SR-123TEST', '493', 'Tnda trm PT Mina prima sejahtera', '<p>Ok</p>', 'Komp.villa malina jln permata indah no 10', '98.6244313', '3.5505219', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-05 19:54:18', '2025-01-05 23:41:03', NULL),
(380, 'SR-123TEST', '74', 'Cv intratek', '<p>Tanda terima ok </p>', 'Jln kepribadian 2', '98.6773261', '3.5889867', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-05 19:58:31', '2025-01-05 23:41:21', NULL),
(381, 'SR-123TEST', '74', 'PT PP London Sumatra Indonesia', '<p>Tanda terima ok </p>', 'Jln a yani', '98.6782171', '3.5886882', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-05 20:07:17', '2025-01-05 23:41:42', NULL),
(382, 'SR-123TEST', '493', 'Tnda trm PT pakan sawit unggul', '<p>Ok</p>', 'Merak no 67', '98.6281152', '3.5847497', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-05 20:23:17', '2025-01-05 23:42:00', NULL),
(383, 'SR-123TEST', '74', 'Alai sg', '<p>Tanda terima ok </p><p>Tagihan blom ada </p>', 'Yos Sudarso', '98.6741961', '3.6098125', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-05 20:53:09', '2025-01-05 21:47:19', NULL),
(384, 'SR-123TEST', '74', 'PT saintifik Indonesia', '<p>Tanda terima ok </p>', 'Jln karakatau simp Cemara', '98.6810991', '3.6294188', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-05 21:21:22', '2025-01-05 23:43:11', NULL),
(385, 'SR-123TEST', '74', 'PT tenera lestari', '<p>Tanda terima ok </p>', 'Jln kalimantan', '98.6906117', '3.590495', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-05 21:56:26', '2025-01-05 23:43:23', NULL),
(386, 'SR-123TEST', '493', 'Tagihan ibu asiu / king,s diesel', '<p>Blm ada</p>', 'Pandu no 98', '98.6842273', '3.582187', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-05 23:31:04', '2025-01-05 23:43:39', NULL),
(387, 'SR-123TEST', '493', 'Tnda trm PT samawa industri bersama', '<p>Ok</p>', 'Katamso dlm no 64 n / 25', '98.6838131', '3.5766049', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-05 23:39:49', '2025-01-05 23:44:01', NULL),
(388, 'SR-123TEST', '493', 'Tnda trm TK sms', '<p>Ok</p>', 'Pandu no 46', '98.6858304', '3.5827978', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-05 23:54:12', '2025-01-06 00:08:02', NULL),
(389, 'SR-123TEST', '493', 'Tnda trm BPK Frans / TK sinar berjaya lestari', '<p>Ok</p>', 'Pandu no 51', '98.6858666', '3.5828058', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-06 00:01:12', '2025-01-06 00:08:12', NULL),
(390, 'SR-123TEST', '74', 'Toko perabot mautain', '<p>Cici gak TT.jatuh tempo tagih langsung </p>', 'Jln ar hakim', '98.7036377', '3.5810521', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-06 00:14:07', '2025-01-06 02:20:59', NULL),
(391, 'SR-123TEST', '74', 'Toko Surya mebel', '<p>Tagihan di transfer rp850.000</p><p>Tgl 6/1/25 via BRI </p>', 'Ar hakim', '98.7037239', '3.579794', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-06 00:34:47', '2025-01-06 02:21:11', NULL),
(392, 'SR-123TEST', '74', 'PT univista utama', '<p>Tanda terima ok </p>', 'Jln Ghandi 111/45', '98.6902969', '3.5833491', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-06 01:04:54', '2025-01-06 01:11:44', NULL),
(393, 'SR-123TEST', '74', 'BPK aik toko kini', '<p>Tanda terima ok </p>', 'Jln mt haryono', '98.6846675', '3.586839', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-06 01:19:05', '2025-01-06 02:21:32', NULL),
(394, 'SR-123TEST', '74', 'PT semadam', '<p>Ambil kekurangan rp500</p>', 'Jln Nibung 93', '98.6646613', '3.5878329', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-06 01:47:13', '2025-01-06 01:51:50', NULL),
(395, 'SR-123TEST', '493', 'Tagihan ibu afang', '<p>Nti sore ditf</p>', 'Rotan no 48 petisah', '98.6675004', '3.5907697', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-06 01:47:47', '2025-01-06 02:21:55', NULL),
(396, 'SR-123TEST', '493', 'Tnda trm mdn jaya', '<p>Ok</p>', 'Razak baru no 5', '98.6674528', '3.5920263', 1, NULL, NULL, NULL, NULL, '0', NULL, '2025-01-06 01:53:15', '2025-01-06 02:22:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_collect_tasks`
--

CREATE TABLE `tb_collect_tasks` (
  `id` bigint UNSIGNED NOT NULL,
  `no_sr` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sr_type` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sr_date` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_name` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_recipient` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_address` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_telp` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_fax` int DEFAULT NULL,
  `shipping_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_bill` double DEFAULT NULL,
  `remaining_bill` double DEFAULT NULL,
  `assign_by` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assign_to` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assign_date` date DEFAULT NULL,
  `bill_status` int NOT NULL DEFAULT '0' COMMENT '0 => belum ditagih,\r\n1 => tagihan berjalan,\r\n2 => tagihan selesai,\r\n3 => tagihan tertunda',
  `validate_by` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_collect_tasks`
--

INSERT INTO `tb_collect_tasks` (`id`, `no_sr`, `sr_type`, `sr_date`, `customer_name`, `customer_recipient`, `customer_address`, `customer_telp`, `customer_fax`, `shipping_address`, `total_bill`, `remaining_bill`, `assign_by`, `assign_to`, `assign_date`, `bill_status`, `validate_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'SR-123TEST', 'TTT', '', 'Archived', 'Archived', 'Archived', '0', 0, 'Archived', 0, 0, '0', '0', '2025-01-01', 0, '0', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_dayoff`
--

CREATE TABLE `tb_dayoff` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_pegawai` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dayoff_for` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_dari` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tgl_hingga` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) DEFAULT '0',
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `validate_by` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
(2831, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-07 03:00:22', '2025-01-07 03:00:22'),
(2832, 1, 'login > create', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-07 03:00:22', '2025-01-07 03:00:22'),
(2833, 1, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-07 03:01:02', '2025-01-07 03:01:02'),
(2834, 1, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-07 03:01:02', '2025-01-07 03:01:02'),
(2835, 1, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-07 03:01:49', '2025-01-07 03:01:49'),
(2836, 1006, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-07 03:01:57', '2025-01-07 03:01:57'),
(2837, 1006, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-07 03:01:57', '2025-01-07 03:01:57'),
(2838, 1006, 'api > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-07 03:06:28', '2025-01-07 03:06:28'),
(2839, 1006, 'check-attendance > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-07 03:06:29', '2025-01-07 03:06:29'),
(2840, 1006, 'store-attendance > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-07 03:06:29', '2025-01-07 03:06:29'),
(2841, 1006, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-07 03:06:41', '2025-01-07 03:06:41'),
(2842, 1, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-07 03:06:54', '2025-01-07 03:06:54'),
(2843, 1, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-07 03:06:54', '2025-01-07 03:06:54'),
(2844, 1, 'logout', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-07 03:40:49', '2025-01-07 03:40:49'),
(2845, 1032, 'login', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-07 03:40:56', '2025-01-07 03:40:56'),
(2846, 1032, 'login > create', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-07 03:40:56', '2025-01-07 03:40:56'),
(2847, 1032, 'logout', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-07 03:50:06', '2025-01-07 03:50:06'),
(2848, 1030, 'login', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-07 03:50:14', '2025-01-07 03:50:14'),
(2849, 1030, 'login > create', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-07 03:50:14', '2025-01-07 03:50:14'),
(2850, 1030, 'logout', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-07 03:53:29', '2025-01-07 03:53:29'),
(2851, 1032, 'login', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-07 03:53:35', '2025-01-07 03:53:35'),
(2852, 1032, 'login > create', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-07 03:53:35', '2025-01-07 03:53:35'),
(2853, 1032, 'logout', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-07 03:54:11', '2025-01-07 03:54:11'),
(2854, 1030, 'login', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-07 03:54:23', '2025-01-07 03:54:23'),
(2855, 1030, 'login > create', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-07 03:54:23', '2025-01-07 03:54:23'),
(2856, 1, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-07 03:54:34', '2025-01-07 03:54:34'),
(2857, 1030, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-07 03:54:42', '2025-01-07 03:54:42'),
(2858, 1030, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-07 03:54:42', '2025-01-07 03:54:42'),
(2859, 1030, 'logout', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-07 04:07:08', '2025-01-07 04:07:08'),
(2860, 1032, 'login', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-07 04:07:14', '2025-01-07 04:07:14'),
(2861, 1032, 'login > create', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-07 04:07:14', '2025-01-07 04:07:14'),
(2862, 1030, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-07 04:07:38', '2025-01-07 04:07:38'),
(2863, 1032, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-07 04:07:45', '2025-01-07 04:07:45'),
(2864, 1032, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-07 04:07:45', '2025-01-07 04:07:45'),
(2865, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-07 09:32:16', '2025-01-07 09:32:16'),
(2866, 1, 'login > create', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-07 09:32:16', '2025-01-07 09:32:16'),
(2867, 1, 'logout', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-07 09:38:36', '2025-01-07 09:38:36'),
(2868, 1032, 'login', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-07 09:38:41', '2025-01-07 09:38:41'),
(2869, 1032, 'login > create', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-07 09:38:41', '2025-01-07 09:38:41'),
(2870, 1032, 'logout', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-07 09:42:20', '2025-01-07 09:42:20'),
(2871, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-07 09:42:36', '2025-01-07 09:42:36'),
(2872, 1, 'login > create', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-07 09:42:36', '2025-01-07 09:42:36'),
(2873, 1, 'users > update', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-07 09:44:19', '2025-01-07 09:44:19'),
(2874, 1, 'users > update', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-07 09:44:29', '2025-01-07 09:44:29'),
(2875, 1, 'users > update', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-07 09:44:38', '2025-01-07 09:44:38'),
(2876, 1, 'logout', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-07 09:44:41', '2025-01-07 09:44:41'),
(2877, 1023, 'login', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-07 09:44:49', '2025-01-07 09:44:49'),
(2878, 1023, 'login > create', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-07 09:44:49', '2025-01-07 09:44:49'),
(2879, 1023, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-07 09:45:21', '2025-01-07 09:45:21'),
(2880, 1023, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-07 09:45:21', '2025-01-07 09:45:21'),
(2881, 1023, 'logout', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-07 10:00:53', '2025-01-07 10:00:53'),
(2882, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-07 10:00:58', '2025-01-07 10:00:58'),
(2883, 1, 'login > create', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-07 10:00:58', '2025-01-07 10:00:58'),
(2884, 1023, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-07 10:02:32', '2025-01-07 10:02:32'),
(2885, 1006, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-07 10:02:40', '2025-01-07 10:02:40'),
(2886, 1006, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-07 10:02:40', '2025-01-07 10:02:40'),
(2887, 1006, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-08 01:08:53', '2025-01-08 01:08:53'),
(2888, 1006, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-08 01:08:53', '2025-01-08 01:08:53'),
(2889, 1006, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-08 01:17:13', '2025-01-08 01:17:13'),
(2890, 1032, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-08 01:17:21', '2025-01-08 01:17:21'),
(2891, 1032, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-08 01:17:21', '2025-01-08 01:17:21'),
(2892, 1032, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-08 01:17:57', '2025-01-08 01:17:57'),
(2893, 1030, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-08 01:18:02', '2025-01-08 01:18:02'),
(2894, 1030, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-08 01:18:02', '2025-01-08 01:18:02'),
(2895, 1030, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-08 01:18:43', '2025-01-08 01:18:43'),
(2896, 1032, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-08 01:18:56', '2025-01-08 01:18:56'),
(2897, 1032, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-08 01:18:56', '2025-01-08 01:18:56'),
(2898, 1032, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-08 01:20:16', '2025-01-08 01:20:16'),
(2899, 1, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-08 01:26:54', '2025-01-08 01:26:54'),
(2900, 1, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-08 01:26:54', '2025-01-08 01:26:54'),
(2901, 1, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-08 01:34:44', '2025-01-08 01:34:44'),
(2902, 1006, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-08 02:13:20', '2025-01-08 02:13:20'),
(2903, 1006, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-08 02:13:20', '2025-01-08 02:13:20'),
(2904, 1006, 'api > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-08 02:13:39', '2025-01-08 02:13:39'),
(2905, 1006, 'check-attendance > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-08 02:13:39', '2025-01-08 02:13:39'),
(2906, 1006, 'store-attendance-out > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-08 02:13:40', '2025-01-08 02:13:40'),
(2907, 1031, 'login', '114.122.11.45', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-08 02:14:12', '2025-01-08 02:14:12'),
(2908, 1031, 'login > create', '114.122.11.45', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-08 02:14:12', '2025-01-08 02:14:12'),
(2909, 1006, 'api > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-08 02:14:32', '2025-01-08 02:14:32'),
(2910, 1006, 'api > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-08 02:15:07', '2025-01-08 02:15:07'),
(2911, 1006, 'check-attendance > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-08 02:15:07', '2025-01-08 02:15:07'),
(2912, 1006, 'store-attendance-out > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-08 02:15:08', '2025-01-08 02:15:08'),
(2913, 1006, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-08 02:16:43', '2025-01-08 02:16:43'),
(2914, 1, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-08 02:16:50', '2025-01-08 02:16:50'),
(2915, 1, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-08 02:16:50', '2025-01-08 02:16:50'),
(2916, 1, 'logout', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-08 02:23:28', '2025-01-08 02:23:28'),
(2917, 1, 'login', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-08 02:23:37', '2025-01-08 02:23:37'),
(2918, 1, 'login > create', '192.168.11.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'Unknown', '2025-01-08 02:23:37', '2025-01-08 02:23:37'),
(2919, 1, 'login', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-08 03:08:32', '2025-01-08 03:08:32'),
(2920, 1, 'login > create', '192.168.11.215', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Unknown', '2025-01-08 03:08:32', '2025-01-08 03:08:32');

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
  `kode_pegawai` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
(231, '28101999', '12012810990001', 'Muhammad Abdi Mayu', 'Abdi', '082265380192', 'Tanjung Morawa', 11, 4, '1999-10-28', NULL, 'labels/28101999/', '2024-09-29 13:57:55', '2024-12-11 06:43:45'),
(232, '112233', '1209312211090001', 'Muhammad Taufik', 'Taufik', '082265380918', 'Medan', 26, 5, '2002-05-16', NULL, NULL, '2024-11-13 06:26:33', '2024-11-13 06:26:33'),
(233, '315', '1209312810990001', 'Oky Sandy Sirait', 'Oky', '081233445678', 'Medan', 26, 5, '2024-11-13', NULL, NULL, '2024-11-13 06:49:35', '2024-11-13 06:49:35'),
(234, '344', '1209312810990001', 'Bernard Samuel Sianturi', 'Bernard', '082265380192', 'Medan', 26, 5, '2024-11-07', NULL, NULL, '2024-11-13 07:54:12', '2024-11-13 07:54:12'),
(235, '123123', '1209312810990001', 'Abdul Khalid Hasibuan', 'Abdul', '085275349929', 'Medan', 25, 5, '2024-11-21', NULL, NULL, '2024-11-13 09:09:43', '2024-11-13 09:09:43'),
(236, '31450', '000000000000000', 'PUPUT JULIANTI', 'PUPUT', '083186786654', 'Pekan Baru', 27, 5, '1996-07-29', NULL, 'labels/31450/', '2024-11-18 03:53:41', '2024-11-22 09:26:33'),
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
(17, 10, '/storage/collectors/674ecfff8add3.png', '2024-12-03 09:31:43', '2024-12-03 09:31:43'),
(20, 13, '/storage/collectors/674fcdcf88e41.png', '2024-12-04 03:34:39', '2024-12-04 03:34:39'),
(21, 14, '/storage/collectors/674fcf9fbf1bd.png', '2024-12-04 03:42:23', '2024-12-04 03:42:23'),
(22, 15, '/storage/collectors/674fd9f325788.png', '2024-12-04 04:26:27', '2024-12-04 04:26:27'),
(25, 18, '/storage/collectors/675018fcc6678.png', '2024-12-04 08:55:24', '2024-12-04 08:55:24'),
(26, 19, '/storage/collectors/67501a58ccf74.png', '2024-12-04 09:01:12', '2024-12-04 09:01:12'),
(27, 20, '/storage/collectors/67501d013d197.png', '2024-12-04 09:12:33', '2024-12-04 09:12:33'),
(30, 23, '/storage/collectors/6751061a47f3b.png', '2024-12-05 01:47:06', '2024-12-05 01:47:06'),
(33, 26, '/storage/collectors/67510e1bb1dcd.png', '2024-12-05 02:21:15', '2024-12-05 02:21:15'),
(40, 33, '/storage/collectors/6751246b8f8c4.png', '2024-12-05 03:56:27', '2024-12-05 03:56:27'),
(41, 34, '/storage/collectors/67512cbb9a410.png', '2024-12-05 04:31:55', '2024-12-05 04:31:55'),
(42, 35, '/storage/collectors/67515b6542ad8.png', '2024-12-05 07:51:01', '2024-12-05 07:51:01'),
(43, 36, '/storage/collectors/675168e0a9dc5.png', '2024-12-05 08:48:32', '2024-12-05 08:48:32'),
(45, 38, '/storage/collectors/6752b1e3043e6.png', '2024-12-06 08:12:19', '2024-12-06 08:12:19'),
(53, 46, '/storage/collectors/675a3dee67707.png', '2024-12-11 18:35:42', '2024-12-11 18:35:42'),
(54, 47, '/storage/collectors/675a400e9dc4b.png', '2024-12-11 18:44:46', '2024-12-11 18:44:46'),
(55, 48, '/storage/collectors/675a46fd23c74.png', '2024-12-11 19:14:21', '2024-12-11 19:14:21'),
(56, 49, '/storage/collectors/675a4855b65a2.png', '2024-12-11 19:20:05', '2024-12-11 19:20:05'),
(57, 50, '/storage/collectors/675a4b3f81862.png', '2024-12-11 19:32:31', '2024-12-11 19:32:31'),
(58, 51, '/storage/collectors/675a4dcbb917c.png', '2024-12-11 19:43:23', '2024-12-11 19:43:23'),
(59, 52, '/storage/collectors/675a50ed2f810.png', '2024-12-11 19:56:45', '2024-12-11 19:56:45'),
(60, 53, '/storage/collectors/675a60fc1f454.png', '2024-12-11 21:05:16', '2024-12-11 21:05:16'),
(61, 54, '/storage/collectors/675a650298c69.png', '2024-12-11 21:22:26', '2024-12-11 21:22:26'),
(62, 55, '/storage/collectors/675a6b940da76.png', '2024-12-11 21:50:28', '2024-12-11 21:50:28'),
(63, 56, '/storage/collectors/675a732941f23.png', '2024-12-11 22:22:49', '2024-12-11 22:22:49'),
(64, 57, '/storage/collectors/675a7e037310b.png', '2024-12-11 23:09:07', '2024-12-11 23:09:07'),
(65, 58, '/storage/collectors/675a912f9283f.png', '2024-12-12 00:30:55', '2024-12-12 00:30:55'),
(66, 59, '/storage/collectors/675a9f5a51ccb.png', '2024-12-12 01:31:22', '2024-12-12 01:31:22'),
(67, 60, '/storage/collectors/675aab0edccc9.png', '2024-12-12 02:21:18', '2024-12-12 02:21:18'),
(68, 61, '/storage/collectors/675b96d8637a1.png', '2024-12-12 19:07:20', '2024-12-12 19:07:20'),
(69, 62, '/storage/collectors/675ba717b5b94.png', '2024-12-12 20:16:39', '2024-12-12 20:16:39'),
(70, 63, '/storage/collectors/675ba96b604a4.png', '2024-12-12 20:26:35', '2024-12-12 20:26:35'),
(71, 64, '/storage/collectors/675baf7aab4cc.png', '2024-12-12 20:52:26', '2024-12-12 20:52:26'),
(72, 65, '/storage/collectors/675bb183d6217.png', '2024-12-12 21:01:07', '2024-12-12 21:01:07'),
(73, 66, '/storage/collectors/675bd9ed0ec0c.png', '2024-12-12 23:53:33', '2024-12-12 23:53:33'),
(74, 67, '/storage/collectors/675cf325e05c9.png', '2024-12-13 19:53:25', '2024-12-13 19:53:25'),
(75, 68, '/storage/collectors/675d2f099ad84.png', '2024-12-14 00:08:57', '2024-12-14 00:08:57'),
(76, 69, '/storage/collectors/675d33255d5c8.png', '2024-12-14 00:26:29', '2024-12-14 00:26:29'),
(77, 70, '/storage/collectors/675d3367316c8.png', '2024-12-14 00:27:35', '2024-12-14 00:27:35'),
(78, 71, '/storage/collectors/675d36c6941dc.png', '2024-12-14 00:41:58', '2024-12-14 00:41:58'),
(79, 72, '/storage/collectors/675d37a960f7d.png', '2024-12-14 00:45:45', '2024-12-14 00:45:45'),
(80, 73, '/storage/collectors/675f7b856d733.png', '2024-12-15 17:59:49', '2024-12-15 17:59:49'),
(82, 75, '/storage/collectors/675f8e8e4ed78.png', '2024-12-15 19:21:02', '2024-12-15 19:21:02'),
(83, 76, '/storage/collectors/675f91cc3e9e5.png', '2024-12-15 19:34:52', '2024-12-15 19:34:52'),
(84, 77, '/storage/collectors/675f936b6fcf6.png', '2024-12-15 19:41:47', '2024-12-15 19:41:47'),
(85, 78, '/storage/collectors/675f94709cfba.png', '2024-12-15 19:46:08', '2024-12-15 19:46:08'),
(86, 79, '/storage/collectors/675f9576dcb7c.png', '2024-12-15 19:50:30', '2024-12-15 19:50:30'),
(87, 80, '/storage/collectors/675f95e8001c3.png', '2024-12-15 19:52:24', '2024-12-15 19:52:24'),
(88, 81, '/storage/collectors/675f985a33a95.png', '2024-12-15 20:02:50', '2024-12-15 20:02:50'),
(89, 82, '/storage/collectors/675f9ec292700.png', '2024-12-15 20:30:10', '2024-12-15 20:30:10'),
(90, 83, '/storage/collectors/675fa0dfa02c8.png', '2024-12-15 20:39:11', '2024-12-15 20:39:11'),
(91, 84, '/storage/collectors/675fa218550b4.png', '2024-12-15 20:44:24', '2024-12-15 20:44:24'),
(92, 85, '/storage/collectors/675fa2f2a95d3.png', '2024-12-15 20:48:02', '2024-12-15 20:48:02'),
(93, 86, '/storage/collectors/675fa41c6a74b.png', '2024-12-15 20:53:00', '2024-12-15 20:53:00'),
(95, 88, '/storage/collectors/675fa5db9572c.png', '2024-12-15 21:00:27', '2024-12-15 21:00:27'),
(96, 89, '/storage/collectors/675fa7d6e8471.png', '2024-12-15 21:08:54', '2024-12-15 21:08:54'),
(97, 90, '/storage/collectors/675fe8724da3b.png', '2024-12-16 01:44:34', '2024-12-16 01:44:34'),
(98, 91, '/storage/collectors/6760d22f7a2c8.png', '2024-12-16 18:21:51', '2024-12-16 18:21:51'),
(99, 92, '/storage/collectors/6760d7196a16f.png', '2024-12-16 18:42:49', '2024-12-16 18:42:49'),
(100, 93, '/storage/collectors/6760dc20cab7a.png', '2024-12-16 19:04:16', '2024-12-16 19:04:16'),
(101, 94, '/storage/collectors/6760e12d4adcc.png', '2024-12-16 19:25:49', '2024-12-16 19:25:49'),
(102, 95, '/storage/collectors/6760e3d9989ef.png', '2024-12-16 19:37:13', '2024-12-16 19:37:13'),
(103, 96, '/storage/collectors/6760e58beb6f5.png', '2024-12-16 19:44:27', '2024-12-16 19:44:27'),
(104, 97, '/storage/collectors/6760e7f05143f.png', '2024-12-16 19:54:40', '2024-12-16 19:54:40'),
(105, 98, '/storage/collectors/6760eb1940132.png', '2024-12-16 20:08:09', '2024-12-16 20:08:09'),
(106, 99, '/storage/collectors/6760ebacd3ea7.png', '2024-12-16 20:10:36', '2024-12-16 20:10:36'),
(107, 100, '/storage/collectors/6760ebd286e7d.png', '2024-12-16 20:11:14', '2024-12-16 20:11:14'),
(108, 101, '/storage/collectors/6760ee5a645d0.png', '2024-12-16 20:22:02', '2024-12-16 20:22:02'),
(109, 102, '/storage/collectors/6760ef6707041.png', '2024-12-16 20:26:31', '2024-12-16 20:26:31'),
(110, 103, '/storage/collectors/6760efb458346.png', '2024-12-16 20:27:48', '2024-12-16 20:27:48'),
(111, 104, '/storage/collectors/6760f06b01aff.png', '2024-12-16 20:30:51', '2024-12-16 20:30:51'),
(112, 105, '/storage/collectors/6760f17953dcb.png', '2024-12-16 20:35:21', '2024-12-16 20:35:21'),
(113, 106, '/storage/collectors/6760f1a192091.png', '2024-12-16 20:36:01', '2024-12-16 20:36:01'),
(114, 107, '/storage/collectors/6760f44ca416f.png', '2024-12-16 20:47:24', '2024-12-16 20:47:24'),
(115, 108, '/storage/collectors/6760f75fe610e.png', '2024-12-16 21:00:31', '2024-12-16 21:00:31'),
(116, 109, '/storage/collectors/6760fa53660fa.png', '2024-12-16 21:13:07', '2024-12-16 21:13:07'),
(117, 110, '/storage/collectors/6760fc6e0374b.png', '2024-12-16 21:22:06', '2024-12-16 21:22:06'),
(118, 111, '/storage/collectors/6760fd1e23c4a.png', '2024-12-16 21:25:02', '2024-12-16 21:25:02'),
(119, 112, '/storage/collectors/67610286a13ab.png', '2024-12-16 21:48:06', '2024-12-16 21:48:06'),
(120, 113, '/storage/collectors/6761069feac2b.png', '2024-12-16 22:05:35', '2024-12-16 22:05:35'),
(121, 114, '/storage/collectors/67612318c73cd.png', '2024-12-17 00:07:04', '2024-12-17 00:07:04'),
(122, 115, '/storage/collectors/67612d95528c6.png', '2024-12-17 00:51:49', '2024-12-17 00:51:49'),
(123, 116, '/storage/collectors/676131a246f26.png', '2024-12-17 01:09:06', '2024-12-17 01:09:06'),
(124, 117, '/storage/collectors/676135ec9bcad.png', '2024-12-17 01:27:24', '2024-12-17 01:27:24'),
(125, 118, '/storage/collectors/676225a1084b7.png', '2024-12-17 18:30:09', '2024-12-17 18:30:09'),
(126, 119, '/storage/collectors/676228ffb8ed2.png', '2024-12-17 18:44:31', '2024-12-17 18:44:31'),
(127, 120, '/storage/collectors/676231426d56f.png', '2024-12-17 19:19:46', '2024-12-17 19:19:46'),
(128, 121, '/storage/collectors/676234f9ab4b8.png', '2024-12-17 19:35:37', '2024-12-17 19:35:37'),
(129, 122, '/storage/collectors/6762391b018ba.png', '2024-12-17 19:53:15', '2024-12-17 19:53:15'),
(130, 123, '/storage/collectors/676239593b1ed.png', '2024-12-17 19:54:17', '2024-12-17 19:54:17'),
(131, 124, '/storage/collectors/676239de97bbc.png', '2024-12-17 19:56:30', '2024-12-17 19:56:30'),
(132, 125, '/storage/collectors/67623e784e8ca.png', '2024-12-17 20:16:08', '2024-12-17 20:16:08'),
(133, 126, '/storage/collectors/676240b207ffc.png', '2024-12-17 20:25:38', '2024-12-17 20:25:38'),
(134, 127, '/storage/collectors/6762411ac8db1.png', '2024-12-17 20:27:22', '2024-12-17 20:27:22'),
(135, 128, '/storage/collectors/67624602f1b88.png', '2024-12-17 20:48:18', '2024-12-17 20:48:18'),
(136, 129, '/storage/collectors/67624637e20c1.png', '2024-12-17 20:49:11', '2024-12-17 20:49:11'),
(137, 130, '/storage/collectors/6762474e41e16.png', '2024-12-17 20:53:50', '2024-12-17 20:53:50'),
(138, 131, '/storage/collectors/676249bd5d0d5.png', '2024-12-17 21:04:13', '2024-12-17 21:04:13'),
(139, 132, '/storage/collectors/67624a1792dc8.png', '2024-12-17 21:05:43', '2024-12-17 21:05:43'),
(140, 133, '/storage/collectors/67624c6a9e1d7.png', '2024-12-17 21:15:38', '2024-12-17 21:15:38'),
(141, 134, '/storage/collectors/6762540e4038c.png', '2024-12-17 21:48:14', '2024-12-17 21:48:14'),
(142, 135, '/storage/collectors/676257611a0e4.png', '2024-12-17 22:02:25', '2024-12-17 22:02:25'),
(143, 136, '/storage/collectors/67626d612696c.png', '2024-12-17 23:36:17', '2024-12-17 23:36:17'),
(144, 137, '/storage/collectors/676270fa8e5f5.png', '2024-12-17 23:51:38', '2024-12-17 23:51:38'),
(145, 138, '/storage/collectors/676275fe548c7.png', '2024-12-18 00:13:02', '2024-12-18 00:13:02'),
(148, 141, '/storage/collectors/67627ecb6f25d.png', '2024-12-18 00:50:35', '2024-12-18 00:50:35'),
(149, 142, '/storage/collectors/67627fe63b324.png', '2024-12-18 00:55:18', '2024-12-18 00:55:18'),
(150, 143, '/storage/collectors/6762826427532.png', '2024-12-18 01:05:56', '2024-12-18 01:05:56'),
(151, 144, '/storage/collectors/67628d7527113.png', '2024-12-18 01:53:09', '2024-12-18 01:53:09'),
(152, 145, '/storage/collectors/676294f1868d2.png', '2024-12-18 02:25:05', '2024-12-18 02:25:05'),
(153, 146, '/storage/collectors/676380365174c.png', '2024-12-18 19:08:54', '2024-12-18 19:08:54'),
(154, 147, '/storage/collectors/676383263e8f2.png', '2024-12-18 19:21:26', '2024-12-18 19:21:26'),
(155, 148, '/storage/collectors/676393ea0bd9a.png', '2024-12-18 20:32:58', '2024-12-18 20:32:58'),
(156, 149, '/storage/collectors/676395e2a827c.png', '2024-12-18 20:41:22', '2024-12-18 20:41:22'),
(157, 150, '/storage/collectors/67639949f007d.png', '2024-12-18 20:55:53', '2024-12-18 20:55:53'),
(158, 151, '/storage/collectors/67639db8876d2.png', '2024-12-18 21:14:48', '2024-12-18 21:14:48'),
(159, 152, '/storage/collectors/67639ffb7170b.png', '2024-12-18 21:24:27', '2024-12-18 21:24:27'),
(160, 153, '/storage/collectors/6763a0e6727aa.png', '2024-12-18 21:28:22', '2024-12-18 21:28:22'),
(161, 154, '/storage/collectors/6763b49f7729e.png', '2024-12-18 22:52:31', '2024-12-18 22:52:31'),
(162, 155, '/storage/collectors/6763b70e81963.png', '2024-12-18 23:02:54', '2024-12-18 23:02:54'),
(163, 156, '/storage/collectors/6763b942dd4b8.png', '2024-12-18 23:12:18', '2024-12-18 23:12:18'),
(164, 157, '/storage/collectors/6763bb9b653e5.png', '2024-12-18 23:22:19', '2024-12-18 23:22:19'),
(165, 158, '/storage/collectors/6763bdd6311bb.png', '2024-12-18 23:31:50', '2024-12-18 23:31:50'),
(166, 159, '/storage/collectors/6763c9087faa6.png', '2024-12-19 00:19:36', '2024-12-19 00:19:36'),
(167, 160, '/storage/collectors/6763dd263bc06.png', '2024-12-19 01:45:26', '2024-12-19 01:45:26'),
(168, 161, '/storage/collectors/6764cbba3bf4f.png', '2024-12-19 18:43:22', '2024-12-19 18:43:22'),
(169, 162, '/storage/collectors/6764ccc3635a7.png', '2024-12-19 18:47:47', '2024-12-19 18:47:47'),
(170, 163, '/storage/collectors/6764cd10bcb44.png', '2024-12-19 18:49:04', '2024-12-19 18:49:04'),
(171, 164, '/storage/collectors/6764d21c7ca1e.png', '2024-12-19 19:10:36', '2024-12-19 19:10:36'),
(172, 165, '/storage/collectors/6764d4bb15fa9.png', '2024-12-19 19:21:47', '2024-12-19 19:21:47'),
(173, 166, '/storage/collectors/6764d8f4c6122.png', '2024-12-19 19:39:48', '2024-12-19 19:39:48'),
(174, 167, '/storage/collectors/6764dad5ce1fb.png', '2024-12-19 19:47:49', '2024-12-19 19:47:49'),
(175, 168, '/storage/collectors/6764dcb82e6ff.png', '2024-12-19 19:55:52', '2024-12-19 19:55:52'),
(176, 169, '/storage/collectors/6764dfe40217d.png', '2024-12-19 20:09:24', '2024-12-19 20:09:24'),
(177, 170, '/storage/collectors/6764e0445cfc3.png', '2024-12-19 20:11:00', '2024-12-19 20:11:00'),
(178, 171, '/storage/collectors/6764e195a746a.png', '2024-12-19 20:16:37', '2024-12-19 20:16:37'),
(179, 172, '/storage/collectors/6764e48398082.png', '2024-12-19 20:29:07', '2024-12-19 20:29:07'),
(180, 173, '/storage/collectors/6764e96b0795d.png', '2024-12-19 20:50:03', '2024-12-19 20:50:03'),
(181, 174, '/storage/collectors/6764f010624ab.png', '2024-12-19 21:18:24', '2024-12-19 21:18:24'),
(182, 175, '/storage/collectors/6764f03e94613.png', '2024-12-19 21:19:10', '2024-12-19 21:19:10'),
(183, 176, '/storage/collectors/6764f06be8926.png', '2024-12-19 21:19:55', '2024-12-19 21:19:55'),
(185, 178, '/storage/collectors/6766184226b6e.png', '2024-12-20 18:22:10', '2024-12-20 18:22:10'),
(186, 179, '/storage/collectors/6766253cd266b.png', '2024-12-20 19:17:32', '2024-12-20 19:17:32'),
(187, 180, '/storage/collectors/67662ef4a5351.png', '2024-12-20 19:59:00', '2024-12-20 19:59:00'),
(188, 181, '/storage/collectors/676634dcb35a7.png', '2024-12-20 20:24:12', '2024-12-20 20:24:12'),
(189, 182, '/storage/collectors/67663710a4f51.png', '2024-12-20 20:33:36', '2024-12-20 20:33:36'),
(190, 183, '/storage/collectors/67663824d6a05.png', '2024-12-20 20:38:12', '2024-12-20 20:38:12'),
(191, 184, '/storage/collectors/676638757c8e2.png', '2024-12-20 20:39:33', '2024-12-20 20:39:33'),
(192, 185, '/storage/collectors/676639152c5e2.png', '2024-12-20 20:42:13', '2024-12-20 20:42:13'),
(193, 186, '/storage/collectors/67663ad833c76.png', '2024-12-20 20:49:44', '2024-12-20 20:49:44'),
(194, 187, '/storage/collectors/67663b368f35f.png', '2024-12-20 20:51:18', '2024-12-20 20:51:18'),
(195, 188, '/storage/collectors/67663e9066903.png', '2024-12-20 21:05:36', '2024-12-20 21:05:36'),
(196, 189, '/storage/collectors/6766407384756.png', '2024-12-20 21:13:39', '2024-12-20 21:13:39'),
(197, 190, '/storage/collectors/676640871f6b9.png', '2024-12-20 21:13:59', '2024-12-20 21:13:59'),
(198, 191, '/storage/collectors/67665eca06096.png', '2024-12-20 23:23:06', '2024-12-20 23:23:06'),
(199, 192, '/storage/collectors/676677da7e6f1.png', '2024-12-21 01:10:02', '2024-12-21 01:10:02'),
(200, 193, '/storage/collectors/676679663b027.png', '2024-12-21 01:16:38', '2024-12-21 01:16:38'),
(201, 194, '/storage/collectors/676680b32fe63.png', '2024-12-21 01:47:47', '2024-12-21 01:47:47'),
(202, 195, '/storage/collectors/676685a474f49.png', '2024-12-21 02:08:52', '2024-12-21 02:08:52'),
(203, 196, '/storage/collectors/6768cb8692663.png', '2024-12-22 19:31:34', '2024-12-22 19:31:34'),
(204, 197, '/storage/collectors/6768d11e28f74.png', '2024-12-22 19:55:26', '2024-12-22 19:55:26'),
(205, 198, '/storage/collectors/6768d618060e4.png', '2024-12-22 20:16:40', '2024-12-22 20:16:40'),
(206, 199, '/storage/collectors/6768d83d36735.png', '2024-12-22 20:25:49', '2024-12-22 20:25:49'),
(207, 200, '/storage/collectors/6768d8a913d40.png', '2024-12-22 20:27:37', '2024-12-22 20:27:37'),
(208, 201, '/storage/collectors/6768da6d45e0c.png', '2024-12-22 20:35:09', '2024-12-22 20:35:09'),
(209, 202, '/storage/collectors/6768de04dbe04.png', '2024-12-22 20:50:28', '2024-12-22 20:50:28'),
(210, 203, '/storage/collectors/6768e400b9de8.png', '2024-12-22 21:16:00', '2024-12-22 21:16:00'),
(211, 204, '/storage/collectors/6768e484651bd.png', '2024-12-22 21:18:12', '2024-12-22 21:18:12'),
(212, 205, '/storage/collectors/6768ebb916a4f.png', '2024-12-22 21:48:57', '2024-12-22 21:48:57'),
(213, 206, '/storage/collectors/676907d190a3a.png', '2024-12-22 23:48:49', '2024-12-22 23:48:49'),
(214, 207, '/storage/collectors/67690bb2acf4d.png', '2024-12-23 00:05:22', '2024-12-23 00:05:22'),
(215, 208, '/storage/collectors/676a0ced26f48.png', '2024-12-23 18:22:53', '2024-12-23 18:22:53'),
(216, 209, '/storage/collectors/676a11d19d5f3.png', '2024-12-23 18:43:45', '2024-12-23 18:43:45'),
(217, 210, '/storage/collectors/676a14a8a227e.png', '2024-12-23 18:55:52', '2024-12-23 18:55:52'),
(218, 211, '/storage/collectors/676a16e1e4713.png', '2024-12-23 19:05:21', '2024-12-23 19:05:21'),
(219, 212, '/storage/collectors/676a1c46f2bad.png', '2024-12-23 19:28:22', '2024-12-23 19:28:22'),
(220, 213, '/storage/collectors/676a223e67d53.png', '2024-12-23 19:53:50', '2024-12-23 19:53:50'),
(221, 214, '/storage/collectors/676a24b24e06f.png', '2024-12-23 20:04:18', '2024-12-23 20:04:18'),
(222, 215, '/storage/collectors/676a27811a354.png', '2024-12-23 20:16:17', '2024-12-23 20:16:17'),
(223, 216, '/storage/collectors/676a2ba13518e.png', '2024-12-23 20:33:53', '2024-12-23 20:33:53'),
(224, 217, '/storage/collectors/676a2e0193bf8.png', '2024-12-23 20:44:01', '2024-12-23 20:44:01'),
(225, 218, '/storage/collectors/676a30ca918e2.png', '2024-12-23 20:55:54', '2024-12-23 20:55:54'),
(226, 219, '/storage/collectors/676a313aa4e77.png', '2024-12-23 20:57:46', '2024-12-23 20:57:46'),
(227, 220, '/storage/collectors/676a321249509.png', '2024-12-23 21:01:22', '2024-12-23 21:01:22'),
(228, 221, '/storage/collectors/676a346ecff8d.png', '2024-12-23 21:11:26', '2024-12-23 21:11:26'),
(229, 222, '/storage/collectors/676a3909bd949.png', '2024-12-23 21:31:05', '2024-12-23 21:31:05'),
(230, 223, '/storage/collectors/676a3e08d0b41.png', '2024-12-23 21:52:24', '2024-12-23 21:52:24'),
(231, 224, '/storage/collectors/676a3e70a6122.png', '2024-12-23 21:54:08', '2024-12-23 21:54:08'),
(232, 225, '/storage/collectors/676a41817905c.png', '2024-12-23 22:07:13', '2024-12-23 22:07:13'),
(233, 226, '/storage/collectors/676cb92e63298.png', '2024-12-25 19:02:22', '2024-12-25 19:02:22'),
(234, 227, '/storage/collectors/676cbba12c215.png', '2024-12-25 19:12:49', '2024-12-25 19:12:49'),
(235, 228, '/storage/collectors/676cbc991bb6b.png', '2024-12-25 19:16:57', '2024-12-25 19:16:57'),
(236, 229, '/storage/collectors/676cbf49bdf59.png', '2024-12-25 19:28:25', '2024-12-25 19:28:25'),
(237, 230, '/storage/collectors/676cc1e5d74b8.png', '2024-12-25 19:39:33', '2024-12-25 19:39:33'),
(238, 231, '/storage/collectors/676cc54a7a7e1.png', '2024-12-25 19:54:02', '2024-12-25 19:54:02'),
(239, 232, '/storage/collectors/676cc9b47c039.png', '2024-12-25 20:12:52', '2024-12-25 20:12:52'),
(240, 233, '/storage/collectors/676cd21969ecc.png', '2024-12-25 20:48:41', '2024-12-25 20:48:41'),
(241, 234, '/storage/collectors/676cd6214bd15.png', '2024-12-25 21:05:53', '2024-12-25 21:05:53'),
(242, 235, '/storage/collectors/676cd81db95d5.png', '2024-12-25 21:14:21', '2024-12-25 21:14:21'),
(243, 236, '/storage/collectors/676cda5809d36.png', '2024-12-25 21:23:52', '2024-12-25 21:23:52'),
(244, 237, '/storage/collectors/676cdddb96cc8.png', '2024-12-25 21:38:51', '2024-12-25 21:38:51'),
(245, 238, '/storage/collectors/676cdf3c41299.png', '2024-12-25 21:44:44', '2024-12-25 21:44:44'),
(246, 239, '/storage/collectors/676d077e53ce6.png', '2024-12-26 00:36:30', '2024-12-26 00:36:30'),
(247, 240, '/storage/collectors/676e05eb9480c.png', '2024-12-26 18:42:03', '2024-12-26 18:42:03'),
(248, 241, '/storage/collectors/676e07994c3b0.png', '2024-12-26 18:49:13', '2024-12-26 18:49:13'),
(249, 242, '/storage/collectors/676e08139dea8.png', '2024-12-26 18:51:15', '2024-12-26 18:51:15'),
(250, 243, '/storage/collectors/676e09b29c5ee.png', '2024-12-26 18:58:10', '2024-12-26 18:58:10'),
(251, 244, '/storage/collectors/676e0cba83183.png', '2024-12-26 19:11:06', '2024-12-26 19:11:06'),
(252, 245, '/storage/collectors/676e112285d8e.png', '2024-12-26 19:29:54', '2024-12-26 19:29:54'),
(253, 246, '/storage/collectors/676e13822098a.png', '2024-12-26 19:40:02', '2024-12-26 19:40:02'),
(254, 247, '/storage/collectors/676e18bf6e819.png', '2024-12-26 20:02:23', '2024-12-26 20:02:23'),
(255, 248, '/storage/collectors/676e18f5ad5b8.png', '2024-12-26 20:03:17', '2024-12-26 20:03:17'),
(256, 249, '/storage/collectors/676e1a1dcb847.png', '2024-12-26 20:08:13', '2024-12-26 20:08:13'),
(257, 250, '/storage/collectors/676e2330e58da.png', '2024-12-26 20:46:56', '2024-12-26 20:46:56'),
(258, 251, '/storage/collectors/676e28af6dade.png', '2024-12-26 21:10:23', '2024-12-26 21:10:23'),
(259, 252, '/storage/collectors/676e2f533e60c.png', '2024-12-26 21:38:43', '2024-12-26 21:38:43'),
(260, 253, '/storage/collectors/676e2fb0b39ec.png', '2024-12-26 21:40:16', '2024-12-26 21:40:16'),
(261, 254, '/storage/collectors/676e353e2ff38.png', '2024-12-26 22:03:58', '2024-12-26 22:03:58'),
(262, 255, '/storage/collectors/676e3c2297f6c.png', '2024-12-26 22:33:22', '2024-12-26 22:33:22'),
(263, 256, '/storage/collectors/676e44b7f3fe5.png', '2024-12-26 23:10:00', '2024-12-26 23:10:00'),
(264, 257, '/storage/collectors/676e47f41c7fe.png', '2024-12-26 23:23:48', '2024-12-26 23:23:48'),
(265, 258, '/storage/collectors/676e48e831a21.png', '2024-12-26 23:27:52', '2024-12-26 23:27:52'),
(266, 259, '/storage/collectors/676e4ac3258ca.png', '2024-12-26 23:35:47', '2024-12-26 23:35:47'),
(267, 260, '/storage/collectors/676e4c20aa18c.png', '2024-12-26 23:41:36', '2024-12-26 23:41:36'),
(268, 261, '/storage/collectors/676e4ec5cd624.png', '2024-12-26 23:52:53', '2024-12-26 23:52:53'),
(269, 262, '/storage/collectors/676e6b32820e2.png', '2024-12-27 01:54:10', '2024-12-27 01:54:10'),
(270, 263, '/storage/collectors/676e71ab90a9f.png', '2024-12-27 02:21:47', '2024-12-27 02:21:47'),
(271, 264, '/storage/collectors/676f64706a13d.png', '2024-12-27 19:37:36', '2024-12-27 19:37:36'),
(272, 265, '/storage/collectors/676f64be29066.png', '2024-12-27 19:38:54', '2024-12-27 19:38:54'),
(273, 266, '/storage/collectors/676f6f8d65967.png', '2024-12-27 20:25:01', '2024-12-27 20:25:01'),
(274, 267, '/storage/collectors/676f85ab13169.png', '2024-12-27 21:59:23', '2024-12-27 21:59:23'),
(275, 268, '/storage/collectors/676f88d495440.png', '2024-12-27 22:12:52', '2024-12-27 22:12:52'),
(276, 269, '/storage/collectors/676f9a805e305.png', '2024-12-27 23:28:16', '2024-12-27 23:28:16'),
(277, 270, '/storage/collectors/676fa10dda184.png', '2024-12-27 23:56:13', '2024-12-27 23:56:13'),
(278, 271, '/storage/collectors/676fa1a8eb5de.png', '2024-12-27 23:58:48', '2024-12-27 23:58:48'),
(279, 272, '/storage/collectors/676fa395385b2.png', '2024-12-28 00:07:01', '2024-12-28 00:07:01'),
(280, 273, '/storage/collectors/676fa89699bd8.png', '2024-12-28 00:28:22', '2024-12-28 00:28:22'),
(281, 274, '/storage/collectors/676fba4ab510b.png', '2024-12-28 01:43:54', '2024-12-28 01:43:54'),
(282, 275, '/storage/collectors/676fbd00707ac.png', '2024-12-28 01:55:28', '2024-12-28 01:55:28'),
(283, 276, '/storage/collectors/677200a24ed08.png', '2024-12-29 19:08:34', '2024-12-29 19:08:34'),
(284, 277, '/storage/collectors/677203c3d6108.png', '2024-12-29 19:21:55', '2024-12-29 19:21:55'),
(285, 278, '/storage/collectors/677206de37a0f.png', '2024-12-29 19:35:10', '2024-12-29 19:35:10'),
(286, 279, '/storage/collectors/6772070ab83cd.png', '2024-12-29 19:35:54', '2024-12-29 19:35:54'),
(287, 280, '/storage/collectors/67720dd2227a9.png', '2024-12-29 20:04:50', '2024-12-29 20:04:50'),
(288, 281, '/storage/collectors/6772189726348.png', '2024-12-29 20:50:47', '2024-12-29 20:50:47'),
(289, 282, '/storage/collectors/67721ad79af65.png', '2024-12-29 21:00:23', '2024-12-29 21:00:23'),
(290, 283, '/storage/collectors/67721cffe0dcf.png', '2024-12-29 21:09:35', '2024-12-29 21:09:35'),
(291, 284, '/storage/collectors/67721dd5baf74.png', '2024-12-29 21:13:09', '2024-12-29 21:13:09'),
(292, 285, '/storage/collectors/67722304e3fc2.png', '2024-12-29 21:35:16', '2024-12-29 21:35:16'),
(293, 286, '/storage/collectors/677225126396e.png', '2024-12-29 21:44:02', '2024-12-29 21:44:02'),
(294, 287, '/storage/collectors/67722fd2af65b.png', '2024-12-29 22:29:54', '2024-12-29 22:29:54'),
(295, 288, '/storage/collectors/6772425fa1fde.png', '2024-12-29 23:49:03', '2024-12-29 23:49:03'),
(296, 289, '/storage/collectors/67725646479ab.png', '2024-12-30 01:13:58', '2024-12-30 01:13:58'),
(297, 290, '/storage/collectors/677256bef2d39.png', '2024-12-30 01:15:58', '2024-12-30 01:15:58'),
(298, 291, '/storage/collectors/677257784473f.png', '2024-12-30 01:19:04', '2024-12-30 01:19:04'),
(299, 292, '/storage/collectors/67725a989dc6f.png', '2024-12-30 01:32:24', '2024-12-30 01:32:24'),
(300, 293, '/storage/collectors/677264615fad1.png', '2024-12-30 02:14:09', '2024-12-30 02:14:09'),
(301, 294, '/storage/collectors/6773543d2f665.png', '2024-12-30 19:17:33', '2024-12-30 19:17:33'),
(302, 295, '/storage/collectors/67735641da610.png', '2024-12-30 19:26:09', '2024-12-30 19:26:09'),
(303, 296, '/storage/collectors/67735842817d1.png', '2024-12-30 19:34:42', '2024-12-30 19:34:42'),
(304, 297, '/storage/collectors/677358542434b.png', '2024-12-30 19:35:00', '2024-12-30 19:35:00'),
(305, 298, '/storage/collectors/677358b7cdcfc.png', '2024-12-30 19:36:39', '2024-12-30 19:36:39'),
(306, 299, '/storage/collectors/67735aa6dd8d0.png', '2024-12-30 19:44:54', '2024-12-30 19:44:54'),
(307, 300, '/storage/collectors/67735c99f32e6.png', '2024-12-30 19:53:13', '2024-12-30 19:53:13'),
(308, 301, '/storage/collectors/6773611810b6a.png', '2024-12-30 20:12:24', '2024-12-30 20:12:24'),
(309, 302, '/storage/collectors/67736951dde75.png', '2024-12-30 20:47:29', '2024-12-30 20:47:29'),
(310, 303, '/storage/collectors/677370b04b79b.png', '2024-12-30 21:18:56', '2024-12-30 21:18:56'),
(311, 304, '/storage/collectors/677374dbcb1e6.png', '2024-12-30 21:36:43', '2024-12-30 21:36:43'),
(312, 305, '/storage/collectors/6773786127b06.png', '2024-12-30 21:51:45', '2024-12-30 21:51:45'),
(313, 306, '/storage/collectors/67737bb934cf7.png', '2024-12-30 22:06:01', '2024-12-30 22:06:01'),
(314, 307, '/storage/collectors/67737bfa8b911.png', '2024-12-30 22:07:06', '2024-12-30 22:07:06'),
(315, 308, '/storage/collectors/67737ca2d6650.png', '2024-12-30 22:09:54', '2024-12-30 22:09:54'),
(316, 309, '/storage/collectors/6773935cc2777.png', '2024-12-30 23:46:52', '2024-12-30 23:46:52'),
(317, 310, '/storage/collectors/677393fa4215f.png', '2024-12-30 23:49:30', '2024-12-30 23:49:30'),
(318, 311, '/storage/collectors/677395eca3f74.png', '2024-12-30 23:57:48', '2024-12-30 23:57:48'),
(319, 312, '/storage/collectors/6773986b88cc0.png', '2024-12-31 00:08:27', '2024-12-31 00:08:27'),
(320, 313, '/storage/collectors/67739b7ca9f13.png', '2024-12-31 00:21:32', '2024-12-31 00:21:32'),
(321, 314, '/storage/collectors/67739d6b6cebf.png', '2024-12-31 00:29:47', '2024-12-31 00:29:47'),
(322, 315, '/storage/collectors/6773a41dc2ac6.png', '2024-12-31 00:58:21', '2024-12-31 00:58:21'),
(323, 316, '/storage/collectors/6773ac7ed6ccc.png', '2024-12-31 01:34:06', '2024-12-31 01:34:06'),
(324, 317, '/storage/collectors/6775ea23410a9.png', '2025-01-01 18:21:39', '2025-01-01 18:21:39'),
(325, 318, '/storage/collectors/677600431dc57.png', '2025-01-01 19:56:03', '2025-01-01 19:56:03'),
(326, 319, '/storage/collectors/6776022f043e6.png', '2025-01-01 20:04:15', '2025-01-01 20:04:15'),
(327, 320, '/storage/collectors/677611e116634.png', '2025-01-01 21:11:13', '2025-01-01 21:11:13'),
(328, 321, '/storage/collectors/6776149ebed17.png', '2025-01-01 21:22:54', '2025-01-01 21:22:54'),
(329, 322, '/storage/collectors/677617ad5e9e1.png', '2025-01-01 21:35:57', '2025-01-01 21:35:57'),
(330, 323, '/storage/collectors/67761817486fa.png', '2025-01-01 21:37:43', '2025-01-01 21:37:43'),
(331, 324, '/storage/collectors/67761fe9a57fb.png', '2025-01-01 22:11:05', '2025-01-01 22:11:05'),
(332, 325, '/storage/collectors/67762443eb80f.png', '2025-01-01 22:29:39', '2025-01-01 22:29:39'),
(333, 326, '/storage/collectors/677633d8b42cb.png', '2025-01-01 23:36:08', '2025-01-01 23:36:08'),
(334, 327, '/storage/collectors/677638c6ea476.png', '2025-01-01 23:57:10', '2025-01-01 23:57:10'),
(335, 328, '/storage/collectors/67763be75ad97.png', '2025-01-02 00:10:31', '2025-01-02 00:10:31'),
(336, 329, '/storage/collectors/67763cb25a551.png', '2025-01-02 00:13:54', '2025-01-02 00:13:54'),
(337, 330, '/storage/collectors/67763d14af1cd.png', '2025-01-02 00:15:32', '2025-01-02 00:15:32'),
(338, 331, '/storage/collectors/677649c29d4d1.png', '2025-01-02 01:09:38', '2025-01-02 01:09:38'),
(339, 332, '/storage/collectors/67764aa6554cc.png', '2025-01-02 01:13:26', '2025-01-02 01:13:26'),
(340, 333, '/storage/collectors/67764f3289493.png', '2025-01-02 01:32:50', '2025-01-02 01:32:50'),
(341, 334, '/storage/collectors/677742723a253.png', '2025-01-02 18:50:42', '2025-01-02 18:50:42'),
(342, 335, '/storage/collectors/6777456f86f6d.png', '2025-01-02 19:03:27', '2025-01-02 19:03:27'),
(343, 336, '/storage/collectors/677749485da9a.png', '2025-01-02 19:19:52', '2025-01-02 19:19:52'),
(344, 337, '/storage/collectors/67774df7b7202.png', '2025-01-02 19:39:51', '2025-01-02 19:39:51'),
(345, 338, '/storage/collectors/6777533dde767.png', '2025-01-02 20:02:21', '2025-01-02 20:02:21'),
(346, 339, '/storage/collectors/67775a8c4860d.png', '2025-01-02 20:33:32', '2025-01-02 20:33:32'),
(347, 340, '/storage/collectors/67775cb45f56b.png', '2025-01-02 20:42:44', '2025-01-02 20:42:44'),
(348, 341, '/storage/collectors/67775dd27e9fa.png', '2025-01-02 20:47:30', '2025-01-02 20:47:30'),
(349, 342, '/storage/collectors/67775f4ef027a.png', '2025-01-02 20:53:50', '2025-01-02 20:53:50'),
(350, 343, '/storage/collectors/677761afa2129.png', '2025-01-02 21:03:59', '2025-01-02 21:03:59'),
(351, 344, '/storage/collectors/677761fe04989.png', '2025-01-02 21:05:18', '2025-01-02 21:05:18'),
(352, 345, '/storage/collectors/677762b3313e4.png', '2025-01-02 21:08:19', '2025-01-02 21:08:19'),
(353, 346, '/storage/collectors/67776439529ff.png', '2025-01-02 21:14:49', '2025-01-02 21:14:49'),
(354, 347, '/storage/collectors/67776e8c77ee4.png', '2025-01-02 21:58:52', '2025-01-02 21:58:52'),
(355, 348, '/storage/collectors/677770e678f62.png', '2025-01-02 22:08:54', '2025-01-02 22:08:54'),
(356, 349, '/storage/collectors/677781d7f16df.png', '2025-01-02 23:21:11', '2025-01-02 23:21:11'),
(357, 350, '/storage/collectors/67778abd20663.png', '2025-01-02 23:59:09', '2025-01-02 23:59:09'),
(358, 351, '/storage/collectors/677792afbe6e9.png', '2025-01-03 00:33:03', '2025-01-03 00:33:03'),
(359, 352, '/storage/collectors/6777939d6d4ca.png', '2025-01-03 00:37:01', '2025-01-03 00:37:01'),
(360, 353, '/storage/collectors/6777968cbe1c8.png', '2025-01-03 00:49:32', '2025-01-03 00:49:32'),
(361, 354, '/storage/collectors/677796cf8c7d6.png', '2025-01-03 00:50:39', '2025-01-03 00:50:39'),
(362, 355, '/storage/collectors/67779ce109b06.png', '2025-01-03 01:16:33', '2025-01-03 01:16:33'),
(363, 356, '/storage/collectors/67779e56ea397.png', '2025-01-03 01:22:46', '2025-01-03 01:22:46'),
(364, 357, '/storage/collectors/6777a09ad878f.png', '2025-01-03 01:32:26', '2025-01-03 01:32:26'),
(365, 358, '/storage/collectors/677894cccc07b.png', '2025-01-03 18:54:20', '2025-01-03 18:54:20'),
(366, 359, '/storage/collectors/6778a4e4bc904.png', '2025-01-03 20:03:00', '2025-01-03 20:03:00'),
(367, 360, '/storage/collectors/6778a5b9780c0.png', '2025-01-03 20:06:33', '2025-01-03 20:06:33'),
(368, 361, '/storage/collectors/6778a6f10d84c.png', '2025-01-03 20:11:45', '2025-01-03 20:11:45'),
(369, 362, '/storage/collectors/6778a704865a3.png', '2025-01-03 20:12:04', '2025-01-03 20:12:04'),
(370, 363, '/storage/collectors/6778a7907c4b2.png', '2025-01-03 20:14:24', '2025-01-03 20:14:24'),
(371, 364, '/storage/collectors/6778a7dd44f09.png', '2025-01-03 20:15:41', '2025-01-03 20:15:41'),
(372, 365, '/storage/collectors/6778a8305cdf0.png', '2025-01-03 20:17:04', '2025-01-03 20:17:04'),
(373, 366, '/storage/collectors/6778a9b333cd7.png', '2025-01-03 20:23:31', '2025-01-03 20:23:31'),
(374, 367, '/storage/collectors/6778ab48c6a34.png', '2025-01-03 20:30:16', '2025-01-03 20:30:16'),
(375, 368, '/storage/collectors/6778acadc3b95.png', '2025-01-03 20:36:13', '2025-01-03 20:36:13'),
(376, 369, '/storage/collectors/6778b0a0788a8.png', '2025-01-03 20:53:04', '2025-01-03 20:53:04'),
(377, 370, '/storage/collectors/6778b357d4472.png', '2025-01-03 21:04:39', '2025-01-03 21:04:39'),
(378, 371, '/storage/collectors/6778cd6202b95.png', '2025-01-03 22:55:46', '2025-01-03 22:55:46'),
(379, 372, '/storage/collectors/6778ce18bb25b.png', '2025-01-03 22:58:48', '2025-01-03 22:58:48'),
(380, 373, '/storage/collectors/6778d5bc5b2ad.png', '2025-01-03 23:31:24', '2025-01-03 23:31:24'),
(381, 374, '/storage/collectors/6778d6e2908c4.png', '2025-01-03 23:36:18', '2025-01-03 23:36:18'),
(382, 375, '/storage/collectors/677b31b3c5fa9.png', '2025-01-05 18:28:19', '2025-01-05 18:28:19'),
(383, 376, '/storage/collectors/677b33f634fd3.png', '2025-01-05 18:37:58', '2025-01-05 18:37:58'),
(384, 377, '/storage/collectors/677b36efd825a.png', '2025-01-05 18:50:39', '2025-01-05 18:50:39'),
(385, 378, '/storage/collectors/677b452153423.png', '2025-01-05 19:51:13', '2025-01-05 19:51:13'),
(386, 379, '/storage/collectors/677b45dabac93.png', '2025-01-05 19:54:18', '2025-01-05 19:54:18'),
(387, 380, '/storage/collectors/677b46d80a664.png', '2025-01-05 19:58:32', '2025-01-05 19:58:32'),
(388, 381, '/storage/collectors/677b48e5582b9.png', '2025-01-05 20:07:17', '2025-01-05 20:07:17'),
(389, 382, '/storage/collectors/677b4ca54d57b.png', '2025-01-05 20:23:17', '2025-01-05 20:23:17'),
(390, 383, '/storage/collectors/677b53a538b02.png', '2025-01-05 20:53:09', '2025-01-05 20:53:09'),
(391, 384, '/storage/collectors/677b5a4292787.png', '2025-01-05 21:21:22', '2025-01-05 21:21:22'),
(392, 385, '/storage/collectors/677b627a6ccd7.png', '2025-01-05 21:56:26', '2025-01-05 21:56:26'),
(393, 386, '/storage/collectors/677b78a8e5d48.png', '2025-01-05 23:31:04', '2025-01-05 23:31:04'),
(394, 387, '/storage/collectors/677b7ab578175.png', '2025-01-05 23:39:49', '2025-01-05 23:39:49'),
(395, 388, '/storage/collectors/677b7e1434b95.png', '2025-01-05 23:54:12', '2025-01-05 23:54:12'),
(396, 389, '/storage/collectors/677b7fb854dd8.png', '2025-01-06 00:01:12', '2025-01-06 00:01:12'),
(397, 390, '/storage/collectors/677b82bf3c5b2.png', '2025-01-06 00:14:07', '2025-01-06 00:14:07'),
(398, 391, '/storage/collectors/677b8797a35d8.png', '2025-01-06 00:34:47', '2025-01-06 00:34:47'),
(399, 392, '/storage/collectors/677b8ea691c0b.png', '2025-01-06 01:04:54', '2025-01-06 01:04:54'),
(400, 393, '/storage/collectors/677b91f999021.png', '2025-01-06 01:19:05', '2025-01-06 01:19:05'),
(401, 394, '/storage/collectors/677b989172a33.png', '2025-01-06 01:47:13', '2025-01-06 01:47:13'),
(402, 395, '/storage/collectors/677b98b329c83.png', '2025-01-06 01:47:47', '2025-01-06 01:47:47'),
(403, 396, '/storage/collectors/677b99fb74a0b.png', '2025-01-06 01:53:15', '2025-01-06 01:53:15');

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
(1, NULL, 'Muhammad Abdi Mayu', 'abdi@darkotech.id', NULL, '$2y$12$8PjfWYlAsiKTobWYA/mJcOzLDiXHh2sKfcabhkJelMx8oSftf8MOq', 'fUcKiMoC5N5lxiTjFUrMGxrnLs4ziWqWckkweznJbZAs37RG1Izvb8Cd1eCL', '2024-10-01 09:55:37', '2024-10-11 03:59:31'),
(1005, NULL, 'HRD', 'hrd@indodacin.com', NULL, '$2y$12$r559G0XgTTGuffzDo25m3Oa58tE/6UYs3ipk.ddfmR0jA/GyJe08y', 'EJL3qG8PHuTNOAO0XP2oBR4lhs3WixTIR6qB6esYEgoZ4jltqT7DyQ5hQlpK', '2024-10-12 02:33:03', '2024-10-12 02:33:03'),
(1006, '28101999', 'Muhammad Abdi Mayu', 'user@indodacin.com', NULL, '$2y$12$mGyAhmMwQcW2OCA2aq/.4OImmLuBATJevl8hHkCJofp7bzc/LuSJ2', 'w4lkVMCPl66UA9tuZ6nmDHYnzCYzoilptHT2Fy63P7mooMUddyveDZNNkyLE', '2024-10-14 06:27:29', '2024-10-14 06:27:29'),
(1020, '112233', 'Muhammad Taufik', 'Taufik112233@indodacin.com', NULL, '$2y$12$G9cSVa/4XV7jzxD5PAuv/O4Re3X1c6n.gZmbkDp16dmqq1ccuBF8W', 'JhM5fTpUZO0NL9yI186Gg5ANDwc5tvcj9UgYsmBEfo3KpmMni4hsXxMX7OZy', '2024-11-13 06:26:34', '2024-11-13 06:26:34'),
(1021, '315', 'Oky Sandy Sirait', 'Oky315@indodacin.com', NULL, '$2y$12$bT4ozWQKBux59/PnMjsoqeeuK0xgCz6rIbGy4PI5Ln.ZlckuYu9ky', 'fvOVCfeo2cY2oZyQ5H0WxO1sez63saG72FPvqUT3pdZeCqke8eyIdTiykh54', '2024-11-13 06:49:35', '2024-11-13 06:49:35'),
(1022, '344', 'Bernard Samuel Sianturi', 'Bernard344@indodacin.com', NULL, '$2y$12$9N4Bb1rtlL6.fCuw.JqHEeJTouO4YzmUHaoFX.u1nnKn76NkR8RdS', 'mnncqIp46ccwJMV58C8Eqb3s74fYtQ2HGzi0v2NDQSD2XwQffAsmJJnF6LOL', '2024-11-13 07:54:12', '2024-11-13 07:54:12'),
(1023, NULL, 'Alfred', 'alfred@indodacin.com', NULL, '$2y$12$S/jd2RUUabKpIZWkxBl.6.a8wOmOnZ5JgrxyQjaQxGQC/fIQ0K7oq', NULL, '2024-11-13 08:27:17', '2025-01-07 09:44:19'),
(1024, '123123', 'Abdul Khalid Hasibuan', 'Abdul123123@indodacin.com', NULL, '$2y$12$5yIUHQsV62okHXnPPddjQeLIhZIMrqOIDk/PbqmFcq81uuCqYXTeW', NULL, '2024-11-13 09:09:43', '2024-11-13 09:09:43'),
(1026, '31450', 'PUPUT JULIANTI', 'PUPUT31450@indodacin.com', NULL, '$2y$12$Zz8Q4Dg9CBBggJz6o6xj0O/pbpeB2G5oxAkZp2sUvV7BvGGiyEZEG', 'WRT5mVclvOSL3ZQDslnz1oRF3RjZ5BXSkGGAyRgYPFXuxq3tPPKaREDnNDkk', '2024-11-18 03:53:42', '2024-11-18 03:53:42'),
(1028, '1105', 'Collector', 'collector1105@indodacin.com', NULL, '$2y$12$PZta6yKJmoXceTT1qwEj9.MS1wXRFQg33LyATG8GIhjOb.6XjOxHK', NULL, '2024-11-29 11:06:48', '2024-11-29 11:06:48'),
(1029, '394', 'KEVIN FRANSETIO', 'kevin394@indodacin.com', NULL, '$2y$12$ucj2xQahpLu8nDPwVBC9y.pgItSaae0wGkh8HIyqiiUOU73.DgxC6', 'Ged7Y6FNtRPKO8jFJFTP0ci5T9NmIAcyvRPNLYGzdj5Bio9JlVGf0zzBTuEj', '2024-11-29 13:56:28', '2024-11-29 13:56:28'),
(1030, '493', 'JOHAN', 'johan493@indodacin.com', NULL, '$2y$12$sNBpupdJQUTF5TflzRmRuOM0MLvDk/wSBO0BaOyBqLn6sQ.FEdKU6', 'YyQbbMD1LHHWdi730w4sI9depoAnXNKaft66iWj1u2FssXcPIdo4LaBxH9kw', '2024-12-11 09:28:25', '2024-12-11 09:28:25'),
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
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

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
-- Indexes for table `tb_collect_tasks`
--
ALTER TABLE `tb_collect_tasks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tb_collect_tasks_no_sr_unique` (`no_sr`),
  ADD KEY `assign_by` (`assign_by`),
  ADD KEY `assign_to` (`assign_to`),
  ADD KEY `no_sr` (`no_sr`),
  ADD KEY `sr_type` (`sr_type`),
  ADD KEY `customer_name` (`customer_name`);

--
-- Indexes for table `tb_dayoff`
--
ALTER TABLE `tb_dayoff`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`kode_pegawai`);

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
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tb_allowance`
--
ALTER TABLE `tb_allowance`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `tb_attendance`
--
ALTER TABLE `tb_attendance`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `tb_attendance_out`
--
ALTER TABLE `tb_attendance_out`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

--
-- AUTO_INCREMENT for table `tb_collect`
--
ALTER TABLE `tb_collect`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=398;

--
-- AUTO_INCREMENT for table `tb_collect_tasks`
--
ALTER TABLE `tb_collect_tasks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `tb_dayoff`
--
ALTER TABLE `tb_dayoff`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2921;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=405;

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
  ADD CONSTRAINT `dayoff_to_pegawai` FOREIGN KEY (`kode_pegawai`) REFERENCES `tb_pegawai` (`kode_pegawai`) ON DELETE CASCADE ON UPDATE CASCADE;

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
