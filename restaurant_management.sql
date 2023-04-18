-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2023 at 05:33 AM
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

INSERT INTO `inventories` (`id`, `product_name`, `available_units`, `unit_cost`, `total_cost`, `measurement_unit`, `last_added`, `created_at`, `updated_at`) VALUES
(2, 'Mutton', 151, 746.894, 112781, 'kg', '2023-04-12 03:24:47', '2023-04-07 12:01:16', '2023-04-12 03:24:47'),
(3, 'খাসি', 20, 1100, 22000, 'kg', '2023-04-07 12:05:11', '2023-04-07 12:05:11', '2023-04-07 12:05:11'),
(4, 'Chicken', 15, 216, 3240, 'kg', '2023-04-10 01:14:07', '2023-04-08 00:09:40', '2023-04-10 01:14:07'),
(5, 'Basmati Rice', 12.25, 148, 1813, 'kg', '2023-04-08 01:55:02', '2023-04-08 01:55:02', '2023-04-12 03:25:42'),
(6, 'Soyabean Oil', 8, 160, 1280, 'ltr', '2023-04-08 01:56:27', '2023-04-08 01:56:27', '2023-04-08 01:56:27'),
(7, 'Potato', 125, 22, 2750, 'kg', '2023-04-08 02:22:00', '2023-04-08 02:22:00', '2023-04-08 02:22:00');

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `table_id`, `recipe_id`, `quantity`, `user_id`, `created_at`, `updated_at`) VALUES
(133, 2, 1, 1, 7, '2023-04-15 05:20:15', '2023-04-15 05:20:15'),
(136, 6, 7, 1, 7, '2023-04-15 05:20:34', '2023-04-15 05:20:34'),
(137, 6, 1, 1, 7, '2023-04-15 05:20:35', '2023-04-15 05:20:35'),
(143, 1, 1, 3, 9, '2023-04-15 05:40:32', '2023-04-15 05:40:32'),
(144, 1, 7, 1, 9, '2023-04-15 05:40:34', '2023-04-15 05:40:34'),
(145, 1, 8, 3, 9, '2023-04-15 05:40:36', '2023-04-15 05:40:36'),
(146, 1, 9, 2, 9, '2023-04-15 05:40:38', '2023-04-15 05:40:38'),
(147, 1, 10, 4, 9, '2023-04-15 05:40:40', '2023-04-15 05:40:40'),
(148, 1, 2, 1, 9, '2023-04-15 05:40:41', '2023-04-15 05:40:41'),
(149, 1, 11, 1, 9, '2023-04-15 05:40:43', '2023-04-15 05:40:43'),
(150, 1, 4, 1, 9, '2023-04-15 05:40:44', '2023-04-15 05:40:44'),
(151, 1, 5, 1, 9, '2023-04-15 05:40:46', '2023-04-15 05:40:46'),
(152, 1, 6, 1, 9, '2023-04-15 05:40:47', '2023-04-15 05:40:47'),
(154, 4, 4, 1, 9, '2023-04-15 05:54:26', '2023-04-15 05:54:26'),
(155, 4, 11, 1, 9, '2023-04-15 05:54:27', '2023-04-15 05:54:27'),
(156, 4, 2, 1, 9, '2023-04-15 05:54:28', '2023-04-15 05:54:28'),
(163, 5, 7, 1, 7, '2023-04-15 07:49:07', '2023-04-15 07:49:07');

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
  `VAT` float DEFAULT 0,
  `on_menu` tinyint(1) DEFAULT 1,
  `is_available` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`id`, `recipe_name`, `description`, `image`, `status`, `category`, `price`, `VAT`, `on_menu`, `is_available`, `created_at`, `updated_at`) VALUES
(1, 'Biryani 1:3', NULL, 'default.png', 1, 'Biryani', 300, 15, 1, 1, '2023-04-09 11:34:15', '2023-04-17 10:50:18'),
(2, 'Fried Rice 1:3', NULL, 'default.png', 1, 'Chinese', 250, 15, 1, 1, '2023-04-09 12:22:54', '2023-04-16 12:24:36'),
(4, 'Beef Burger', NULL, 'default.png', 1, 'Apatizer', 145, NULL, 1, 1, '2023-04-10 02:16:11', '2023-04-16 12:15:56'),
(5, 'Cheese Slice', NULL, 'default.png', 1, 'Add One', 60, NULL, 1, 1, '2023-04-10 02:16:51', '2023-04-16 12:20:51'),
(6, 'Beef Patty', NULL, 'default.png', 1, 'Add One', 80, 3, 1, 1, '2023-04-10 02:17:45', '2023-04-16 12:26:42'),
(7, 'Chicken Biryani', NULL, 'default.png', 1, 'Biryani', 180, NULL, 1, 1, '2023-04-14 00:49:18', '2023-04-16 12:26:27'),
(8, 'Beef Tehari', NULL, 'default.png', 1, 'Biryani', 150, NULL, 1, 1, '2023-04-14 00:49:46', '2023-04-16 12:26:44'),
(9, 'Kacchi Full', NULL, 'default.png', 1, 'Biryani', 500, NULL, 1, 1, '2023-04-14 00:50:35', '2023-04-16 12:26:46'),
(10, 'Kacchi Half', NULL, 'default.png', 1, 'Biryani', 250, NULL, 1, 1, '2023-04-14 00:50:51', '2023-04-16 12:26:47'),
(11, 'Chinese Vegetable', NULL, 'default.png', 1, 'Chinese', 120, NULL, 1, 1, '2023-04-14 00:51:13', '2023-04-16 12:26:49');

-- --------------------------------------------------------

--
-- Table structure for table `recipe_inventory`
--

CREATE TABLE `recipe_inventory` (
  `id` bigint(20) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `inventory_id` int(11) NOT NULL,
  `amount` float NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) NOT NULL,
  `recipe_id` bigint(20) NOT NULL,
  `price` float NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(1, 1, 9, 'occupied', '2023-04-15 07:55:24', '2023-04-13 10:20:43'),
(2, 2, 7, 'occupied', '2023-04-15 05:20:15', '2023-04-13 10:22:25'),
(3, 3, 9, 'free', '2023-04-15 07:51:13', '2023-04-13 10:22:32'),
(4, 4, 9, 'occupied', '2023-04-15 05:54:27', '2023-04-13 10:22:46'),
(5, 5, 7, 'occupied', '2023-04-15 07:49:07', '2023-04-13 10:22:50'),
(6, 6, 7, 'occupied', '2023-04-15 05:20:34', '2023-04-13 10:22:56'),
(7, 7, 7, 'free', '2023-04-15 07:51:55', '2023-04-15 07:51:55'),
(8, 8, 9, 'free', '2023-04-15 07:53:06', '2023-04-15 07:52:09'),
(9, 9, 9, 'free', '2023-04-15 07:52:13', '2023-04-15 07:52:13'),
(10, 10, 7, 'free', '2023-04-15 07:52:18', '2023-04-15 07:52:18'),
(11, 11, 7, 'free', '2023-04-15 07:52:23', '2023-04-15 07:52:23'),
(12, 12, 9, 'free', '2023-04-15 07:52:27', '2023-04-15 07:52:27');

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
(1, 'Galib', 'reserved@admin.com', '01766555213', 'manager', 1, 'default.png', '2023-04-04 17:26:21', '$2a$12$WHO6aHJNXbyxXcduCFAyKOBtW3AIb4ZQjUFs.9v4WyIoFVskZbGCK', NULL, NULL, NULL),
(7, 'Galib Jaman', NULL, '01747371076', 'staff', 1, 'default.png', NULL, '$2y$10$Z35m2w.iYepzB0L0Kd5MNO6QwrFEs9/sfKK.DCd9NfnjDDrKDb4OW', NULL, '2023-04-13 11:07:06', '2023-04-13 11:07:06'),
(8, 'Rafi Hasan', NULL, '01766555212', 'kitchen_staff', 1, 'default.png', NULL, '$2y$10$M/mnrWyuCqDWSrhfVnsRcuNBfIU8/qmF674ozfGS8Q.nWaqCB7oIe', NULL, '2023-04-13 11:42:34', '2023-04-15 04:12:28'),
(9, 'Abdur Rahman', 'abdr01@gmail.com', '01766555211', 'staff', 1, 'default.png', NULL, '$2y$10$KFHkrSeNjfBX..XMncmSqevmm2sLADVjl2Trl4fWnBjtjJQ74AUQa', NULL, '2023-04-13 11:47:08', '2023-04-13 11:47:08');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventories`
--
ALTER TABLE `inventories`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `recipe_inventory`
--
ALTER TABLE `recipe_inventory`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
