-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 17, 2023 at 11:40 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurant_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `business_information`
--

CREATE TABLE `business_information` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone_number` varchar(30) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `business_information`
--

INSERT INTO `business_information` (`id`, `name`, `phone_number`, `email`, `address`, `created_at`, `updated_at`) VALUES
(1, 'Richa Restaurant', '01766555213', 'pepplo25@gamil.com', '68 Street, Barishal', '2023-04-28 16:17:34', '2023-06-28 14:56:16');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventories`
--

CREATE TABLE `inventories` (
  `id` bigint(20) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `available_units` float DEFAULT 0,
  `warning_unit` float DEFAULT 1,
  `unit_cost` float DEFAULT NULL,
  `total_cost` float DEFAULT NULL,
  `measurement_unit` varchar(10) DEFAULT NULL,
  `last_added` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inventories`
--

INSERT INTO `inventories` (`id`, `product_name`, `available_units`, `warning_unit`, `unit_cost`, `total_cost`, `measurement_unit`, `last_added`, `created_at`, `updated_at`) VALUES
(4, 'Chicken', 19, 10, 196.989, 3742.8, 'kg', '2023-07-17 20:54:41', '2023-04-08 00:09:40', '2023-07-17 20:54:41'),
(5, 'বাসমতি চাল', 38.75, 1, 254.453, 14313, 'kg', '2023-06-27 11:06:46', '2023-04-08 01:55:02', '2023-07-17 21:34:13'),
(6, 'Soyabean Oil', 5.9, 1, 160, 1280, 'ltr', '2023-04-08 01:56:27', '2023-04-08 01:56:27', '2023-06-23 13:27:47'),
(7, 'Potato', 106.6, 1, 22, 2750, 'kg', '2023-04-08 02:22:00', '2023-04-08 02:22:00', '2023-07-17 21:34:13'),
(8, 'Mutton', 24.25, 1, 1000, 50000, 'kg', '2023-06-27 11:00:54', '2023-06-27 11:00:54', '2023-07-17 21:34:13'),
(9, 'Water 1L', 890, 20, 15, 15000, 'pcs', '2023-06-27 11:02:38', '2023-06-27 11:02:38', '2023-07-05 14:55:38'),
(10, 'চিনিগুঁড়া চাল', 86.4, 1, 140, 14000, 'kg', '2023-06-27 11:04:50', '2023-06-27 11:04:50', '2023-07-17 21:33:58'),
(12, 'Mustard Oil', 20, 5, 290, 5800, 'ltr', '2023-07-05 14:24:15', '2023-07-05 14:24:15', '2023-07-05 14:24:15'),
(14, 'Water 0.5L', 5, 10, 10, 50, 'pcs', '2023-07-17 21:27:12', '2023-07-17 21:27:12', '2023-07-17 21:27:12');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_reports`
--

CREATE TABLE `inventory_reports` (
  `id` bigint(20) NOT NULL,
  `inventory_id` bigint(20) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `recipe_name` varchar(255) DEFAULT NULL,
  `quantity` float NOT NULL,
  `cost` float DEFAULT NULL,
  `measurement_unit` varchar(10) DEFAULT NULL,
  `activity` varchar(255) DEFAULT NULL,
  `done_manually` varchar(255) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inventory_reports`
--

INSERT INTO `inventory_reports` (`id`, `inventory_id`, `product_name`, `recipe_name`, `quantity`, `cost`, `measurement_unit`, `activity`, `done_manually`, `created_at`, `updated_at`) VALUES
(43, 10, 'চিনিগুঁড়া চাল', 'Kacchi - Chinigura', 0.6, 84, 'kg', 'subtracted', '0', '2023-07-17 21:33:58', '2023-07-17 21:33:58'),
(44, 8, 'Mutton', 'Kacchi - Chinigura', 0.45, 450, 'kg', 'subtracted', '0', '2023-07-17 21:33:58', '2023-07-17 21:33:58'),
(45, 7, 'Potato', 'Kacchi - Chinigura', 0.3, 6.6, 'kg', 'subtracted', '0', '2023-07-17 21:33:58', '2023-07-17 21:33:58'),
(46, 5, 'বাসমতি চাল', 'Kacchi - Basmati', 0.5, 127.227, 'kg', 'added', '0', '2023-07-17 21:34:13', '2023-07-17 21:34:13'),
(47, 8, 'Mutton', 'Kacchi - Basmati', 0.2, 200, 'kg', 'added', '0', '2023-07-17 21:34:13', '2023-07-17 21:34:13'),
(48, 7, 'Potato', 'Kacchi - Basmati', 0.4, 8.8, 'kg', 'added', '0', '2023-07-17 21:34:13', '2023-07-17 21:34:13');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) NOT NULL,
  `invoice_number` varchar(30) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `customer_name` varchar(50) DEFAULT NULL,
  `customer_contact` varchar(20) DEFAULT NULL,
  `table_number` bigint(20) DEFAULT NULL,
  `total` bigint(20) DEFAULT 0,
  `paid` int(11) NOT NULL,
  `discount` int(4) DEFAULT 0,
  `creator_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `invoice_number`, `username`, `customer_name`, `customer_contact`, `table_number`, `total`, `paid`, `discount`, `creator_name`, `created_at`, `updated_at`) VALUES
(22, '866496194247', 'Galib Jaman', 'Rafi Hassan', '01751664541', 7, 3151, 3000, 15, 'Galib', '2023-04-24 12:30:01', '2023-04-24 12:30:01'),
(23, '915418640222', 'Galib Jaman', 'Guest', 'N/A', 6, 2331, 2500, 15, 'Galib', '2023-04-24 12:59:44', '2023-04-24 12:59:44'),
(24, '358792854654', 'Galib Jaman', 'Abid Hasan', '01752332322', 6, 660, 600, 15, 'Galib', '2023-04-24 13:21:52', '2023-04-24 13:21:52'),
(25, '299478151752', 'Galib Jaman', 'Anjumanara', 'N/A', 3, 430, 500, 70, 'Galib', '2023-04-24 13:36:21', '2023-04-24 13:36:21'),
(26, '363970802556', 'Galib Jaman', 'Jashim', '01751664541', 1, 1960, 2000, 15, 'Galib', '2023-04-25 03:59:26', '2023-04-25 03:59:26'),
(27, '820266204260', 'Galib Jaman', 'Guest', 'N/A', 3, 978, 1000, 10, 'Galib', '2023-04-25 05:58:41', '2023-04-25 05:58:41'),
(28, '724614252555', 'Galib Jaman', 'Guest', 'N/A', 11, 199, 0, 0, 'Galib', '2023-04-25 08:52:06', '2023-04-25 08:52:06'),
(29, '746987971666', 'Galib Jaman', 'Guest', 'N/A', 3, 600, 0, 0, 'Galib', '2023-04-25 08:54:53', '2023-04-25 08:54:53'),
(30, '991936501351', 'Galib Jaman', 'Guest', 'N/A', 1, 2210, 0, 0, 'Galib', '2023-04-25 08:57:15', '2023-04-25 08:57:15'),
(31, '260535012774', 'Galib Jaman', 'Guest', 'N/A', 1, 660, 700, 0, 'Galib', '2023-04-25 09:00:38', '2023-04-25 09:00:38'),
(32, '433751110160', 'Galib Jaman', 'Guest', 'N/A', 1, 660, 1200, 0, 'Galib', '2023-04-25 09:01:41', '2023-04-25 09:01:41'),
(33, '533817162970', 'Galib Jaman', 'Guest', 'N/A', 1, 300, 400, 0, 'Galib', '2023-04-25 09:05:27', '2023-04-25 09:05:27'),
(34, '118336970826', 'Galib Jaman', 'Guest', 'N/A', 1, 300, 300, 0, 'Galib', '2023-04-25 09:08:08', '2023-04-25 09:08:08'),
(35, '995291011838', 'Galib Jaman', 'Abdur Rahman', '01751664541', 1, 360, 23, 15, 'Galib', '2023-04-25 09:19:03', '2023-04-25 09:19:03'),
(36, '616454029018', 'Galib Jaman', 'Guest', 'N/A', 1, 300, 500, 0, 'Galib', '2023-04-25 09:28:06', '2023-04-25 09:28:06'),
(37, '526490505530', 'Galib Jaman', 'Guest', 'N/A', 1, 780, 1000, 0, 'Galib', '2023-04-25 09:47:58', '2023-04-25 09:47:58'),
(38, '556597901126', 'Galib Jaman', 'Abdur Rahman', '01751664541', 1, 780, 100, 10, 'Galib', '2023-04-25 09:51:11', '2023-04-25 09:51:11'),
(39, '999394156458', 'Galib Jaman', 'Guest', 'N/A', 1, 600, 600, 0, 'Galib', '2023-04-25 09:56:58', '2023-04-25 09:56:58'),
(40, '671666261236', 'Galib Jaman', 'Guest', 'N/A', 1, 600, 600, 0, 'Galib', '2023-04-25 09:58:41', '2023-04-25 09:58:41'),
(41, '882590283519', 'Galib Jaman', 'Guest', 'N/A', 1, 480, 500, 0, 'Galib', '2023-04-25 09:59:15', '2023-04-25 09:59:15'),
(42, '818776594759', 'Galib Jaman', 'Guest', 'N/A', 1, 840, 1000, 0, 'Galib', '2023-04-25 12:48:22', '2023-04-25 12:48:22'),
(43, '938556700559', 'Galib Jaman', 'Guest', 'N/A', 3, 960, 1000, 10, 'Galib', '2023-04-25 12:49:12', '2023-04-25 12:49:12'),
(44, '686975995840', 'Galib Jaman', 'Guest', 'N/A', 3, 180, 200, 0, 'Galib', '2023-04-25 12:50:40', '2023-04-25 12:50:40'),
(45, '322153392697', 'Galib Jaman', 'Guest', 'N/A', 1, 180, 200, 0, 'Galib', '2023-04-25 12:50:50', '2023-04-25 12:50:50'),
(46, '309986958597', 'Galib Jaman', 'Guest', 'N/A', 1, 360, 500, 5, 'Galib', '2023-04-25 13:58:44', '2023-04-25 13:58:44'),
(47, '495558952336', 'Galib Jaman', 'Guest', 'N/A', 3, 180, 200, 0, 'Galib', '2023-04-25 14:02:39', '2023-04-25 14:02:39'),
(48, '342217352153', 'Galib Jaman', 'Jashim', '01751664541', 3, 660, 1000, 5, 'Galib', '2023-04-25 14:04:38', '2023-04-25 14:04:38'),
(49, '566257896938', 'Galib Jaman', 'Abdul Aziz', '01799666213', 3, 3100, 3000, 15, 'Galib', '2023-04-25 15:38:31', '2023-04-25 15:38:31'),
(50, '143064451750', 'Galib Jaman', 'Guest', 'N/A', 1, 457, 420, 11, 'Galib', '2023-04-25 15:40:58', '2023-04-25 15:40:58'),
(51, '179858886170', 'Galib Jaman', 'Guest', 'N/A', 3, 1195, 1000, 25, 'Galib', '2023-04-25 15:42:39', '2023-04-25 15:42:39'),
(52, '785797501816', 'Galib Jaman', 'Galib', '01799666213', 11, 600, 520, 15, 'Galib', '2023-04-26 08:10:12', '2023-04-26 08:10:12'),
(53, '977276877462', 'Galib Jaman', 'Guest', 'N/A', 1, 480, 360, 25, 'Galib', '2023-04-26 11:33:02', '2023-04-26 11:33:02'),
(54, '253465479328', 'Galib Jaman', 'Guest', 'N/A', 3, 660, 600, 10, 'Galib', '2023-04-26 13:06:40', '2023-04-26 13:06:40'),
(55, '319332385236', 'Galib Jaman', 'Guest', 'N/A', 12, 445, 400, 10, 'Galib', '2023-04-26 13:10:48', '2023-04-26 13:10:48'),
(58, '332740336454', 'Galib Jaman', 'Guest', 'N/A', 3, 549, 500, 10, 'Galib', '2023-04-28 11:09:11', '2023-04-28 11:09:11'),
(59, '586872259987', 'Galib Jaman', 'Andrew Tate', 'N/A', 3, 3615, 3100, 15, 'Galib Jaman', '2023-04-28 19:32:55', '2023-04-28 19:32:55'),
(60, '813410373455', 'Galib Jaman', 'Guest', 'N/A', 3, 815, 800, 2, 'Galib Jaman', '2023-05-31 13:06:00', '2023-05-31 13:06:00'),
(61, '569446715416', 'Galib Jaman', 'Guest', 'N/A', 3, 324, 300, 10, 'Galib Jaman', '2023-06-27 10:02:26', '2023-06-27 10:02:26'),
(62, '613217998772', 'Galib Jaman', 'Guest', 'N/A', 3, 2080, 2080, 0, 'Galib Jaman', '2023-06-28 19:07:01', '2023-06-28 19:07:01');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) NOT NULL,
  `table_id` bigint(20) NOT NULL,
  `recipe_id` bigint(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `status` varchar(15) DEFAULT 'cooking',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `table_id`, `recipe_id`, `quantity`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(495, 3, 27, 2, 7, 'cooking', '2023-07-08 15:26:51', '2023-07-08 15:36:31'),
(496, 7, 27, 1, 7, 'cooking', '2023-07-08 16:10:21', '2023-07-08 16:10:21'),
(497, 5, 27, 1, 7, 'cooking', '2023-07-08 16:11:44', '2023-07-08 16:11:44');

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
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` bigint(20) NOT NULL,
  `recipe_id` bigint(20) NOT NULL,
  `quantity` float NOT NULL,
  `date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `recipe_id`, `quantity`, `date`, `created_at`, `updated_at`) VALUES
(66, 27, 3, '2023-07-19', '2023-07-17 20:44:15', '2023-07-17 20:44:15'),
(67, 27, 1, '2023-07-18', '2023-07-17 21:25:17', '2023-07-17 21:34:13'),
(69, 28, 3, '2023-07-18', '2023-07-17 21:33:58', '2023-07-17 21:33:58');

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `id` bigint(20) NOT NULL,
  `recipe_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'default.png',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `category` varchar(255) DEFAULT NULL,
  `price` int(11) NOT NULL,
  `production_cost` float DEFAULT NULL,
  `VAT` float DEFAULT 0,
  `discount` int(11) DEFAULT 0,
  `on_menu` tinyint(1) DEFAULT 1,
  `is_available` tinyint(1) DEFAULT 1,
  `parent_id` bigint(20) DEFAULT 0,
  `quantity_multiplier` int(3) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`id`, `recipe_name`, `description`, `image`, `status`, `category`, `price`, `production_cost`, `VAT`, `discount`, `on_menu`, `is_available`, `parent_id`, `quantity_multiplier`, `created_at`, `updated_at`) VALUES
(27, 'Kacchi - Basmati', NULL, 'default.png', 1, 'Biryani', 270, 168, NULL, NULL, 1, 1, 0, 1, '2023-06-27 11:17:23', '2023-07-17 21:20:53'),
(28, 'Kacchi - Chinigura', NULL, 'default.png', 1, 'Biryani', 250, 180, 0, NULL, 1, 1, 0, 1, '2023-06-27 11:18:18', '2023-06-27 11:18:18'),
(29, 'Water 1L', NULL, 'default.png', 1, 'Water', 20, 15, 0, NULL, 1, 1, 0, 1, '2023-06-27 11:18:56', '2023-06-27 11:18:56'),
(30, 'Water 0.5L', NULL, 'default.png', 1, 'Water', 15, 10, 0, NULL, 1, 1, 0, 1, '2023-06-27 11:19:30', '2023-06-27 11:19:30');

-- --------------------------------------------------------

--
-- Table structure for table `recipe_inventory`
--

CREATE TABLE `recipe_inventory` (
  `id` bigint(20) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `inventory_id` int(11) NOT NULL,
  `quantity` float NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `recipe_inventory`
--

INSERT INTO `recipe_inventory` (`id`, `recipe_id`, `inventory_id`, `quantity`, `updated_at`, `created_at`) VALUES
(10, 25, 2, 0.1, '2023-06-19 09:53:23', '2023-06-19 09:53:23'),
(11, 25, 6, 0.5, '2023-06-19 09:53:23', '2023-06-19 09:53:23'),
(13, 6, 2, 0.08, '2023-06-19 10:09:32', '2023-06-19 10:09:32'),
(14, 6, 6, 0.1, '2023-06-19 10:09:32', '2023-06-19 10:09:32'),
(18, 24, 5, 0.25, '2023-06-21 07:30:29', '2023-06-21 07:30:29'),
(19, 24, 7, 0.1, '2023-06-21 07:30:29', '2023-06-21 07:30:29'),
(20, 24, 2, 0.1, '2023-06-21 07:30:29', '2023-06-21 07:30:29'),
(21, 26, 2, 0.25, '2023-06-23 11:24:58', '2023-06-23 11:24:58'),
(22, 26, 6, 0.1, '2023-06-23 11:24:58', '2023-06-23 11:24:58'),
(23, 26, 5, 0.25, '2023-06-23 11:24:58', '2023-06-23 11:24:58'),
(27, 28, 10, 0.2, '2023-06-27 11:18:18', '2023-06-27 11:18:18'),
(28, 28, 8, 0.15, '2023-06-27 11:18:18', '2023-06-27 11:18:18'),
(29, 28, 7, 0.1, '2023-06-27 11:18:18', '2023-06-27 11:18:18'),
(33, 29, 9, 1, '2023-06-27 11:18:56', '2023-06-27 11:18:56'),
(34, 30, 11, 1, '2023-06-27 11:19:30', '2023-06-27 11:19:30'),
(38, 27, 5, 0.25, '2023-07-17 21:20:53', '2023-07-17 21:20:53'),
(39, 27, 8, 0.1, '2023-07-17 21:20:53', '2023-07-17 21:20:53'),
(40, 27, 7, 0.2, '2023-07-17 21:20:53', '2023-07-17 21:20:53');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) NOT NULL,
  `invoice_id` bigint(20) NOT NULL,
  `recipe_id` bigint(20) NOT NULL,
  `recipe_name` varchar(255) DEFAULT NULL,
  `price` float NOT NULL,
  `discount` int(4) DEFAULT 0,
  `quantity` int(10) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `table_number` int(11) DEFAULT NULL,
  `production_cost` float DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `invoice_id`, `recipe_id`, `recipe_name`, `price`, `discount`, `quantity`, `username`, `table_number`, `production_cost`, `updated_at`, `created_at`) VALUES
(66, 22, 1, 'Biryani 1:3', 300, 0, 1, 'Galib Jaman', 7, 220, '2023-04-24 12:30:01', '2023-04-24 12:30:01'),
(67, 22, 7, 'Chicken Biryani', 180, 0, 3, 'Galib Jaman', 7, 160, '2023-04-24 12:30:01', '2023-04-24 12:30:01'),
(68, 22, 8, 'Beef Tehari', 180, 0, 1, 'Galib Jaman', 7, 140, '2023-04-24 12:30:01', '2023-04-24 12:30:01'),
(69, 22, 9, 'Kacchi Full', 500, 0, 2, 'Galib Jaman', 7, 400, '2023-04-24 12:30:01', '2023-04-24 12:30:01'),
(70, 22, 10, 'Kacchi Half', 250, 0, 1, 'Galib Jaman', 7, 200, '2023-04-24 12:30:01', '2023-04-24 12:30:01'),
(71, 22, 2, 'Fried Rice 1:3', 250, 0, 1, 'Galib Jaman', 7, 200, '2023-04-24 12:30:01', '2023-04-24 12:30:01'),
(72, 22, 11, 'Chinese Vegetable', 120, 0, 2, 'Galib Jaman', 7, 80, '2023-04-24 12:30:01', '2023-04-24 12:30:01'),
(73, 22, 4, 'Beef Burger', 145, 0, 1, 'Galib Jaman', 7, 108, '2023-04-24 12:30:01', '2023-04-24 12:30:01'),
(74, 22, 12, 'French Fries 1:2', 54, 10, 2, 'Galib Jaman', 7, 45, '2023-04-24 12:30:01', '2023-04-24 12:30:01'),
(75, 22, 5, 'Cheese Slice', 60, 0, 1, 'Galib Jaman', 7, 40, '2023-04-24 12:30:01', '2023-04-24 12:30:01'),
(76, 22, 6, 'Beef Patty', 80, 2, 1, 'Galib Jaman', 7, 65, '2023-04-24 12:30:01', '2023-04-24 12:30:01'),
(77, 23, 7, 'Chicken Biryani', 180, 0, 2, 'Galib Jaman', 6, 160, '2023-04-24 12:59:44', '2023-04-24 12:59:44'),
(79, 23, 6, 'Beef Patty', 80, 2, 2, 'Galib Jaman', 6, 65, '2023-04-24 12:59:44', '2023-04-24 12:59:44'),
(80, 23, 12, 'French Fries 1:2', 60, 10, 1, 'Galib Jaman', 6, 45, '2023-04-24 12:59:44', '2023-04-24 12:59:44'),
(81, 23, 4, 'Beef Burger', 145, 0, 2, 'Galib Jaman', 6, 108, '2023-04-24 12:59:44', '2023-04-24 12:59:44'),
(82, 23, 8, 'Beef Tehari', 180, 0, 2, 'Galib Jaman', 6, 140, '2023-04-24 12:59:44', '2023-04-24 12:59:44'),
(83, 23, 1, 'Biryani 1:3', 300, 0, 1, 'Galib Jaman', 6, 220, '2023-04-24 12:59:44', '2023-04-24 12:59:44'),
(84, 23, 5, 'Cheese Slice', 60, 0, 1, 'Galib Jaman', 6, 40, '2023-04-24 12:59:44', '2023-04-24 12:59:44'),
(85, 24, 1, 'Biryani 1:3', 300, 0, 1, 'Galib Jaman', 6, 220, '2023-04-24 13:21:52', '2023-04-24 13:21:52'),
(86, 24, 7, 'Chicken Biryani', 180, 0, 2, 'Galib Jaman', 6, 160, '2023-04-24 13:21:52', '2023-04-24 13:21:52'),
(87, 25, 8, 'Beef Tehari', 180, 0, 1, 'Galib Jaman', 3, 140, '2023-04-24 13:36:21', '2023-04-24 13:36:21'),
(88, 25, 10, 'Kacchi Half', 250, 0, 1, 'Galib Jaman', 3, 200, '2023-04-24 13:36:21', '2023-04-24 13:36:21'),
(89, 26, 1, 'Biryani 1:3', 300, 0, 1, 'Galib Jaman', 1, 220, '2023-04-25 03:59:26', '2023-04-25 03:59:26'),
(90, 26, 7, 'Chicken Biryani', 180, 0, 2, 'Galib Jaman', 1, 160, '2023-04-25 03:59:26', '2023-04-25 03:59:26'),
(91, 26, 8, 'Beef Tehari', 180, 0, 1, 'Galib Jaman', 1, 140, '2023-04-25 03:59:26', '2023-04-25 03:59:26'),
(92, 26, 9, 'Kacchi Full', 500, 0, 2, 'Galib Jaman', 1, 400, '2023-04-25 03:59:26', '2023-04-25 03:59:26'),
(93, 26, 11, 'Chinese Vegetable', 120, 0, 1, 'Galib Jaman', 1, 80, '2023-04-25 03:59:26', '2023-04-25 03:59:26'),
(94, 27, 5, 'Cheese Slice', 60, 0, 2, 'Galib Jaman', 3, 40, '2023-04-25 05:58:41', '2023-04-25 05:58:41'),
(95, 27, 6, 'Beef Patty', 80, 2, 1, 'Galib Jaman', 3, 65, '2023-04-25 05:58:41', '2023-04-25 05:58:41'),
(96, 27, 1, 'Biryani 1:3', 300, 0, 2, 'Galib Jaman', 3, 220, '2023-04-25 05:58:41', '2023-04-25 05:58:41'),
(97, 27, 7, 'Chicken Biryani', 180, 0, 1, 'Galib Jaman', 3, 160, '2023-04-25 05:58:41', '2023-04-25 05:58:41'),
(98, 28, 4, 'Beef Burger', 145, 0, 1, 'Galib Jaman', 11, 108, '2023-04-25 08:52:06', '2023-04-25 08:52:06'),
(99, 28, 12, 'French Fries 1:2', 60, 10, 1, 'Galib Jaman', 11, 45, '2023-04-25 08:52:06', '2023-04-25 08:52:06'),
(100, 29, 1, 'Biryani 1:3', 300, 0, 2, 'Galib Jaman', 3, 220, '2023-04-25 08:54:53', '2023-04-25 08:54:53'),
(101, 30, 1, 'Biryani 1:3', 300, 0, 2, 'Galib Jaman', 1, 220, '2023-04-25 08:57:15', '2023-04-25 08:57:15'),
(102, 30, 7, 'Chicken Biryani', 180, 0, 1, 'Galib Jaman', 1, 160, '2023-04-25 08:57:15', '2023-04-25 08:57:15'),
(103, 30, 8, 'Beef Tehari', 180, 0, 1, 'Galib Jaman', 1, 140, '2023-04-25 08:57:15', '2023-04-25 08:57:15'),
(104, 30, 10, 'Kacchi Half', 250, 0, 1, 'Galib Jaman', 1, 200, '2023-04-25 08:57:15', '2023-04-25 08:57:15'),
(105, 30, 9, 'Kacchi Full', 500, 0, 1, 'Galib Jaman', 1, 400, '2023-04-25 08:57:15', '2023-04-25 08:57:15'),
(106, 30, 2, 'Fried Rice 1:3', 250, 0, 2, 'Galib Jaman', 1, 200, '2023-04-24 08:57:15', '2023-04-24 08:57:15'),
(107, 31, 1, 'Biryani 1:3', 300, 0, 1, 'Galib Jaman', 1, 220, '2023-04-25 09:00:38', '2023-04-25 09:00:38'),
(108, 31, 7, 'Chicken Biryani', 180, 0, 2, 'Galib Jaman', 1, 160, '2023-04-25 09:00:38', '2023-04-25 09:00:38'),
(109, 32, 7, 'Chicken Biryani', 180, 0, 2, 'Galib Jaman', 1, 160, '2023-04-25 09:01:41', '2023-04-25 09:01:41'),
(110, 32, 1, 'Biryani 1:3', 300, 0, 1, 'Galib Jaman', 1, 220, '2023-04-25 09:01:41', '2023-04-25 09:01:41'),
(111, 33, 1, 'Biryani 1:3', 300, 0, 1, 'Galib Jaman', 1, 220, '2023-04-25 09:05:27', '2023-04-25 09:05:27'),
(112, 34, 1, 'Biryani 1:3', 300, 0, 1, 'Galib Jaman', 1, 220, '2023-04-25 09:08:08', '2023-04-25 09:08:08'),
(113, 35, 7, 'Chicken Biryani', 180, 0, 2, 'Galib Jaman', 1, 160, '2023-04-25 09:19:03', '2023-04-25 09:19:03'),
(114, 36, 1, 'Biryani 1:3', 300, 0, 1, 'Galib Jaman', 1, 220, '2023-04-25 09:28:06', '2023-04-25 09:28:06'),
(115, 37, 1, 'Biryani 1:3', 300, 0, 2, 'Galib Jaman', 1, 220, '2023-04-25 09:47:58', '2023-04-25 09:47:58'),
(116, 37, 7, 'Chicken Biryani', 180, 0, 1, 'Galib Jaman', 1, 160, '2023-04-25 09:47:58', '2023-04-25 09:47:58'),
(117, 38, 1, 'Biryani 1:3', 300, 0, 2, 'Galib Jaman', 1, 220, '2023-04-25 09:51:11', '2023-04-25 09:51:11'),
(118, 38, 7, 'Chicken Biryani', 180, 0, 1, 'Galib Jaman', 1, 160, '2023-04-25 09:51:11', '2023-04-25 09:51:11'),
(119, 39, 1, 'Biryani 1:3', 300, 0, 2, 'Galib Jaman', 1, 220, '2023-04-25 09:56:58', '2023-04-25 09:56:58'),
(120, 40, 1, 'Biryani 1:3', 300, 0, 2, 'Galib Jaman', 1, 220, '2023-04-25 09:58:41', '2023-04-25 09:58:41'),
(121, 41, 1, 'Biryani 1:3', 300, 0, 1, 'Galib Jaman', 1, 220, '2023-04-25 09:59:15', '2023-04-25 09:59:15'),
(122, 41, 7, 'Chicken Biryani', 180, 0, 1, 'Galib Jaman', 1, 160, '2023-04-25 09:59:15', '2023-04-25 09:59:15'),
(123, 42, 1, 'Biryani 1:3', 300, 0, 1, 'Galib Jaman', 1, 220, '2023-04-25 12:48:22', '2023-04-25 12:48:22'),
(124, 42, 7, 'Chicken Biryani', 180, 0, 2, 'Galib Jaman', 1, 160, '2023-04-25 12:48:22', '2023-04-25 12:48:22'),
(125, 42, 8, 'Beef Tehari', 180, 0, 1, 'Galib Jaman', 1, 140, '2023-04-25 12:48:22', '2023-04-25 12:48:22'),
(126, 43, 7, 'Chicken Biryani', 180, 0, 1, 'Galib Jaman', 3, 160, '2023-04-25 12:49:12', '2023-04-25 12:49:12'),
(127, 43, 1, 'Biryani 1:3', 300, 0, 2, 'Galib Jaman', 3, 220, '2023-04-25 12:49:12', '2023-04-25 12:49:12'),
(128, 43, 8, 'Beef Tehari', 180, 0, 1, 'Galib Jaman', 3, 140, '2023-04-25 12:49:12', '2023-04-25 12:49:12'),
(129, 44, 7, 'Chicken Biryani', 180, 0, 1, 'Galib Jaman', 3, 160, '2023-04-25 12:50:40', '2023-04-25 12:50:40'),
(130, 45, 7, 'Chicken Biryani', 180, 0, 1, 'Galib Jaman', 1, 160, '2023-04-25 12:50:50', '2023-04-25 12:50:50'),
(131, 46, 7, 'Chicken Biryani', 180, 0, 2, 'Galib Jaman', 1, 160, '2023-04-25 13:58:44', '2023-04-25 13:58:44'),
(132, 47, 8, 'Beef Tehari', 180, 0, 1, 'Galib Jaman', 3, 140, '2023-04-25 14:02:39', '2023-04-25 14:02:39'),
(133, 48, 1, 'Biryani 1:3', 300, 0, 1, 'Galib Jaman', 3, 220, '2023-04-25 14:04:38', '2023-04-25 14:04:38'),
(134, 48, 7, 'Chicken Biryani', 180, 0, 2, 'Galib Jaman', 3, 160, '2023-04-25 14:04:38', '2023-04-25 14:04:38'),
(135, 49, 6, 'Beef Patty', 80, 2, 2, 'Galib Jaman', 3, 65, '2023-04-25 15:38:31', '2023-04-25 15:38:31'),
(136, 49, 5, 'Cheese Slice', 60, 0, 1, 'Galib Jaman', 3, 40, '2023-04-25 15:38:31', '2023-04-25 15:38:31'),
(137, 49, 12, 'French Fries 1:2', 60, 10, 2, 'Galib Jaman', 3, 45, '2023-04-25 15:38:31', '2023-04-25 15:38:31'),
(138, 49, 4, 'Beef Burger', 145, 0, 1, 'Galib Jaman', 3, 108, '2023-04-25 15:38:31', '2023-04-25 15:38:31'),
(139, 49, 11, 'Chinese Vegetable', 120, 0, 2, 'Galib Jaman', 3, 80, '2023-04-25 15:38:31', '2023-04-25 15:38:31'),
(140, 49, 2, 'Fried Rice 1:3', 250, 0, 1, 'Galib Jaman', 3, 200, '2023-04-24 15:38:31', '2023-04-24 15:38:31'),
(141, 49, 10, 'Kacchi Half', 250, 0, 2, 'Galib Jaman', 3, 200, '2023-04-25 15:38:31', '2023-04-25 15:38:31'),
(142, 49, 9, 'Kacchi Full', 500, 0, 1, 'Galib Jaman', 3, 400, '2023-04-25 15:38:31', '2023-04-25 15:38:31'),
(143, 49, 8, 'Beef Tehari', 180, 0, 2, 'Galib Jaman', 3, 140, '2023-04-25 15:38:31', '2023-04-25 15:38:31'),
(144, 49, 7, 'Chicken Biryani', 180, 0, 1, 'Galib Jaman', 3, 160, '2023-04-25 15:38:31', '2023-04-25 15:38:31'),
(145, 49, 1, 'Biryani 1:3', 300, 0, 2, 'Galib Jaman', 3, 220, '2023-04-25 15:38:31', '2023-04-25 15:38:31'),
(146, 50, 1, 'Biryani 1:3', 300, 0, 1, 'Galib Jaman', 1, 220, '2023-04-25 15:40:58', '2023-04-25 15:40:58'),
(147, 50, 6, 'Beef Patty', 80, 2, 2, 'Galib Jaman', 1, 65, '2023-04-25 15:40:58', '2023-04-25 15:40:58'),
(148, 51, 7, 'Chicken Biryani', 180, 0, 2, 'Galib Jaman', 3, 160, '2023-04-25 15:42:39', '2023-04-25 15:42:39'),
(149, 51, 1, 'Biryani 1:3', 300, 0, 2, 'Galib Jaman', 3, 220, '2023-04-25 15:42:39', '2023-04-25 15:42:39'),
(150, 51, 6, 'Beef Patty', 80, 2, 3, 'Galib Jaman', 3, 65, '2023-04-25 15:42:39', '2023-04-25 15:42:39'),
(151, 52, 1, 'Biryani 1:3', 300, 0, 2, 'Galib Jaman', 11, 220, '2023-04-26 08:10:12', '2023-04-26 08:10:12'),
(152, 53, 1, 'Biryani 1:3', 300, 0, 1, 'Galib Jaman', 1, 220, '2023-04-26 11:33:02', '2023-04-26 11:33:02'),
(153, 53, 8, 'Beef Tehari', 180, 0, 1, 'Galib Jaman', 1, 140, '2023-04-26 11:33:02', '2023-04-26 11:33:02'),
(154, 54, 1, 'Biryani 1:3', 300, 0, 1, 'Galib Jaman', 3, 220, '2023-04-26 13:06:40', '2023-04-26 13:06:40'),
(155, 54, 7, 'Chicken Biryani', 180, 0, 2, 'Galib Jaman', 3, 160, '2023-04-26 13:06:40', '2023-04-26 13:06:40'),
(156, 55, 5, 'Cheese Slice', 60, 0, 2, 'Galib Jaman', 12, 40, '2023-04-26 13:10:48', '2023-04-26 13:10:48'),
(157, 55, 4, 'Beef Burger', 145, 0, 1, 'Galib Jaman', 12, 108, '2023-04-26 13:10:48', '2023-04-26 13:10:48'),
(158, 55, 8, 'Beef Tehari', 180, 0, 1, 'Galib Jaman', 12, 140, '2023-04-26 13:10:48', '2023-04-26 13:10:48'),
(169, 58, 6, 'Beef Patty', 80, 2, 2, 'Galib Jaman', 3, 65, '2023-04-28 11:09:11', '2023-04-28 11:09:11'),
(170, 58, 12, 'French Fries 1:2', 60, 15, 2, 'Galib Jaman', 3, 45, '2023-04-28 11:09:11', '2023-04-28 11:09:11'),
(171, 58, 4, 'Beef Burger', 145, 0, 2, 'Galib Jaman', 3, 108, '2023-04-28 11:09:11', '2023-04-28 11:09:11'),
(172, 59, 1, 'Biryani 1:3', 300, 0, 1, 'Galib Jaman', 3, 220, '2023-04-28 19:32:55', '2023-04-28 19:32:55'),
(173, 59, 7, 'Chicken Biryani', 180, 0, 2, 'Galib Jaman', 3, 160, '2023-04-28 19:32:55', '2023-04-28 19:32:55'),
(174, 59, 8, 'Beef Tehari', 180, 0, 3, 'Galib Jaman', 3, 140, '2023-04-28 19:32:55', '2023-04-28 19:32:55'),
(175, 59, 9, 'Kacchi Full', 500, 0, 2, 'Galib Jaman', 3, 400, '2023-04-28 19:32:55', '2023-04-28 19:32:55'),
(176, 59, 10, 'Kacchi Half', 250, 0, 1, 'Galib Jaman', 3, 200, '2023-04-28 19:32:55', '2023-04-28 19:32:55'),
(177, 59, 2, 'Fried Rice 1:3', 250, 0, 2, 'Galib Jaman', 3, 200, '2023-04-28 19:32:55', '2023-04-28 19:32:55'),
(178, 59, 11, 'Chinese Vegetable', 120, 0, 2, 'Galib Jaman', 3, 80, '2023-04-28 19:32:55', '2023-04-28 19:32:55'),
(179, 59, 4, 'Beef Burger', 145, 0, 1, 'Galib Jaman', 3, 108, '2023-04-28 19:32:55', '2023-04-28 19:32:55'),
(180, 59, 12, 'French Fries 1:2', 60, 15, 2, 'Galib Jaman', 3, 45, '2023-04-28 19:32:55', '2023-04-28 19:32:55'),
(181, 59, 5, 'Cheese Slice', 60, 0, 1, 'Galib Jaman', 3, 40, '2023-04-28 19:32:55', '2023-04-28 19:32:55'),
(182, 59, 6, 'Beef Patty', 80, 2, 1, 'Galib Jaman', 3, 65, '2023-04-28 19:32:55', '2023-04-28 19:32:55'),
(183, 59, 15, 'Water 1L', 20, 0, 2, 'Galib Jaman', 3, 16, '2023-04-28 19:32:55', '2023-04-28 19:32:55'),
(184, 60, 2, 'Fried Rice 1:3', 250, 0, 1, 'Galib Jaman', 3, 200, '2023-05-31 13:06:00', '2023-05-31 13:06:00'),
(185, 60, 11, 'Chinese Vegetable', 120, 0, 2, 'Galib Jaman', 3, 80, '2023-05-31 13:06:00', '2023-05-31 13:06:00'),
(186, 60, 12, 'French Fries 1:2', 60, 15, 2, 'Galib Jaman', 3, 45, '2023-05-31 13:06:00', '2023-05-31 13:06:00'),
(187, 60, 4, 'Beef Burger', 145, 0, 1, 'Galib Jaman', 3, 108, '2023-05-31 13:06:00', '2023-05-31 13:06:00'),
(188, 60, 6, 'Beef Patty', 80, 2, 1, 'Galib Jaman', 3, 65, '2023-05-31 13:06:00', '2023-05-31 13:06:00'),
(189, 61, 24, 'Khichuri', 180, 10, 2, 'Galib Jaman', 3, 114, '2023-06-27 10:02:26', '2023-06-27 10:02:26'),
(190, 62, 27, 'Kacchi - Basmati', 270, 0, 3, 'Galib Jaman', 3, 203, '2023-06-28 19:07:01', '2023-06-28 19:07:01'),
(191, 62, 28, 'Kacchi - Chinigura', 250, 0, 5, 'Galib Jaman', 3, 180, '2023-06-28 19:07:01', '2023-06-28 19:07:01'),
(192, 62, 29, 'Water 1L', 20, 0, 1, 'Galib Jaman', 3, 15, '2023-06-28 19:07:01', '2023-06-28 19:07:01');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) NOT NULL,
  `setting_name` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `setting_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'sidebar_status', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `id` bigint(20) NOT NULL,
  `table_number` int(11) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `status` varchar(15) DEFAULT 'free',
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`id`, `table_number`, `user_id`, `status`, `updated_at`, `created_at`) VALUES
(1, 1, 9, 'free', '2023-04-26 11:33:02', '2023-04-13 10:20:43'),
(2, 2, 9, 'free', '2023-04-23 04:58:47', '2023-04-13 10:22:25'),
(3, 3, 7, 'occupied', '2023-07-08 15:26:52', '2023-04-13 10:22:32'),
(4, 4, 9, 'free', '2023-04-18 23:19:55', '2023-04-13 10:22:46'),
(5, 5, 7, 'occupied', '2023-07-08 16:11:44', '2023-04-13 10:22:50'),
(6, 6, 7, 'free', '2023-04-24 13:21:52', '2023-04-13 10:22:56'),
(7, 7, 7, 'occupied', '2023-07-08 16:10:22', '2023-04-15 07:51:55'),
(8, 8, 9, 'free', '2023-04-15 07:53:06', '2023-04-15 07:52:09'),
(9, 9, 9, 'free', '2023-04-15 07:52:13', '2023-04-15 07:52:13'),
(10, 10, 7, 'free', '2023-04-19 05:19:30', '2023-04-15 07:52:18'),
(14, 11, 7, 'free', '2023-04-26 08:10:12', '2023-04-26 07:43:28'),
(15, 12, 7, 'free', '2023-04-26 13:10:48', '2023-04-26 13:09:31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'default.png',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone_number`, `role`, `status`, `image`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Galib Jaman', 'reserved@admin.com', '01766555213', 'manager', 1, 'default.png', '2023-04-04 17:26:21', '$2y$10$wDNx0cHo6q3e011480inF.y6DNJscbG/6s4jJebY4CiwT6URo38ie', NULL, NULL, '2023-04-28 19:28:18'),
(7, 'Galib Jaman', NULL, '01747371076', 'staff', 1, 'default.png', NULL, '$2y$10$Z35m2w.iYepzB0L0Kd5MNO6QwrFEs9/sfKK.DCd9NfnjDDrKDb4OW', NULL, '2023-04-13 11:07:06', '2023-04-13 11:07:06'),
(8, 'Rafi Hasan', NULL, '01766555212', 'kitchen_staff', 1, 'default.png', NULL, '$2y$10$M/mnrWyuCqDWSrhfVnsRcuNBfIU8/qmF674ozfGS8Q.nWaqCB7oIe', NULL, '2023-04-13 11:42:34', '2023-04-15 04:12:28'),
(9, 'Abdur Rahman', 'abdr01@gmail.com', '01766555211', 'staff', 1, 'default.png', NULL, '$2y$10$KFHkrSeNjfBX..XMncmSqevmm2sLADVjl2Trl4fWnBjtjJQ74AUQa', NULL, '2023-04-13 11:47:08', '2023-04-23 07:57:07');

-- --------------------------------------------------------

--
-- Table structure for table `wastes`
--

CREATE TABLE `wastes` (
  `id` bigint(20) NOT NULL,
  `recipe_name` varchar(255) NOT NULL,
  `recipe_id` bigint(20) DEFAULT NULL,
  `production_cost` float NOT NULL,
  `amount` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wastes`
--

INSERT INTO `wastes` (`id`, `recipe_name`, `recipe_id`, `production_cost`, `amount`, `created_at`, `updated_at`) VALUES
(1, 'Khichuri', 24, 114, 8, '2023-06-23 14:39:50', '2023-06-23 14:39:50'),
(2, 'Khichuri', 24, 114, 5, '2023-06-23 14:49:35', '2023-06-23 14:49:35'),
(3, 'Kacchi', 26, 240, 10, '2023-06-23 14:49:35', '2023-06-23 14:49:35'),
(4, 'Kacchi - Basmati', 27, 203, 30, '2023-06-27 18:00:05', '2023-06-27 18:00:05'),
(5, 'Kacchi - Basmati', 27, 203, 30, '2023-06-27 18:00:05', '2023-06-27 18:00:05'),
(6, 'Kacchi - Chinigura', 28, 180, 30, '2023-06-27 18:00:05', '2023-06-27 18:00:05'),
(7, 'Kacchi - Chinigura', 28, 180, 30, '2023-06-27 18:00:05', '2023-06-27 18:00:05'),
(8, 'Water 1L', 29, 15, 50, '2023-06-27 18:00:05', '2023-06-27 18:00:05'),
(9, 'Water 1L', 29, 15, 50, '2023-06-27 18:00:05', '2023-06-27 18:00:05'),
(10, 'Water 0.5L', 30, 10, 50, '2023-06-27 18:00:05', '2023-06-27 18:00:05'),
(11, 'Water 0.5L', 30, 10, 50, '2023-06-27 18:00:05', '2023-06-27 18:00:05'),
(12, 'Kacchi - Basmati', 27, 203, 30, '2023-06-28 18:00:01', '2023-06-28 18:00:01'),
(13, 'Kacchi - Basmati', 27, 203, 30, '2023-06-28 18:00:01', '2023-06-28 18:00:01'),
(14, 'Kacchi - Chinigura', 28, 180, 30, '2023-06-28 18:00:01', '2023-06-28 18:00:01'),
(15, 'Kacchi - Chinigura', 28, 180, 30, '2023-06-28 18:00:01', '2023-06-28 18:00:01'),
(16, 'Water 1L', 29, 15, 50, '2023-06-28 18:00:01', '2023-06-28 18:00:01'),
(17, 'Water 1L', 29, 15, 50, '2023-06-28 18:00:01', '2023-06-28 18:00:01'),
(18, 'Water 0.5L', 30, 10, 50, '2023-06-28 18:00:01', '2023-06-28 18:00:01'),
(19, 'Water 0.5L', 30, 10, 50, '2023-06-28 18:00:01', '2023-06-28 18:00:01'),
(20, 'Kacchi - Basmati', 27, 203, 7, '2023-06-29 18:00:18', '2023-06-29 18:00:18'),
(21, 'Kacchi - Chinigura', 28, 180, 0, '2023-06-29 18:00:18', '2023-06-29 18:00:18'),
(22, 'Water 1L', 29, 15, 9, '2023-06-29 18:00:18', '2023-06-29 18:00:18'),
(23, 'Kacchi - Chinigura', 28, 180, 0, '2023-06-29 18:00:18', '2023-06-29 18:00:18'),
(24, 'Water 1L', 29, 15, 9, '2023-06-29 18:00:18', '2023-06-29 18:00:18'),
(25, 'Kacchi - Basmati', 27, 203, 8, '2023-07-06 08:42:27', '2023-07-06 08:42:27'),
(26, 'Kacchi - Basmati', 27, 203, 8, '2023-07-06 08:42:27', '2023-07-06 08:42:27'),
(27, 'Kacchi - Basmati', 27, 203, 8, '2023-07-06 08:42:27', '2023-07-06 08:42:27'),
(28, 'Kacchi - Basmati', 27, 203, 8, '2023-07-06 08:42:27', '2023-07-06 08:42:27'),
(29, 'Kacchi - Basmati', 27, 203, 8, '2023-07-06 08:42:27', '2023-07-06 08:42:27'),
(30, 'Kacchi - Basmati', 27, 203, 8, '2023-07-06 08:42:27', '2023-07-06 08:42:27'),
(31, 'Kacchi - Basmati', 27, 203, 8, '2023-07-06 08:42:27', '2023-07-06 08:42:27'),
(32, 'Kacchi - Basmati', 27, 203, 8, '2023-07-06 08:42:27', '2023-07-06 08:42:27'),
(33, 'Kacchi - Basmati', 27, 203, 8, '2023-07-06 08:42:27', '2023-07-06 08:42:27'),
(34, 'Kacchi - Basmati', 27, 203, 3, '2023-07-08 18:00:26', '2023-07-08 18:00:26'),
(35, 'Kacchi - Basmati', 27, 203, 3, '2023-07-08 18:00:26', '2023-07-08 18:00:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `business_information`
--
ALTER TABLE `business_information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `inventories`
--
ALTER TABLE `inventories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_reports`
--
ALTER TABLE `inventory_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_number` (`invoice_number`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recipe_inventory`
--
ALTER TABLE `recipe_inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wastes`
--
ALTER TABLE `wastes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `business_information`
--
ALTER TABLE `business_information`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventories`
--
ALTER TABLE `inventories`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `inventory_reports`
--
ALTER TABLE `inventory_reports`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=498;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `recipe_inventory`
--
ALTER TABLE `recipe_inventory`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=193;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `wastes`
--
ALTER TABLE `wastes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
