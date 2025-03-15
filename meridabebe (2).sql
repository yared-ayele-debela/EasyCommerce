-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2024 at 06:25 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `meridabebe`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `activity` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `activity`, `description`, `created_at`, `updated_at`) VALUES
(1, 4, 'User login', 'user login at 2024-06-09 08:44:53', '2024-06-09 12:44:53', '2024-06-09 12:44:53'),
(2, 4, 'User login', 'user login at 2024-06-09 09:48:39', '2024-06-09 13:48:39', '2024-06-09 13:48:39'),
(3, 4, 'User logout', 'User logout at 2024-06-09 09:49:54', '2024-06-09 13:49:54', '2024-06-09 13:49:54'),
(4, 4, 'User login', 'user login at 2024-06-09 09:50:15', '2024-06-09 13:50:15', '2024-06-09 13:50:15'),
(10, 4, 'User login', 'user login at 2024-06-10 13:34:35', '2024-06-10 17:34:35', '2024-06-10 17:34:35'),
(12, 4, 'User login', 'user login at 2024-06-10 13:42:06', '2024-06-10 17:42:06', '2024-06-10 17:42:06'),
(13, 4, 'User login', 'user login at 2024-06-10 13:44:38', '2024-06-10 17:44:38', '2024-06-10 17:44:38'),
(15, 4, 'User login', 'user login at 2024-06-10 13:46:37', '2024-06-10 17:46:37', '2024-06-10 17:46:37'),
(17, 4, 'User login', 'user login at 2024-06-10 13:50:35', '2024-06-10 17:50:35', '2024-06-10 17:50:35'),
(18, 4, 'User login', 'user login at 2024-06-10 13:56:45', '2024-06-10 17:56:45', '2024-06-10 17:56:45'),
(19, 4, 'User login', 'user login at 2024-06-11 06:16:23', '2024-06-11 10:16:23', '2024-06-11 10:16:23'),
(20, 4, 'User login', 'user login at 2024-06-11 10:57:18', '2024-06-11 14:57:18', '2024-06-11 14:57:18'),
(21, 4, 'User login', 'user login at 2024-06-11 16:25:23', '2024-06-11 20:25:23', '2024-06-11 20:25:23'),
(22, 4, 'User login', 'user login at 2024-06-12 08:37:59', '2024-06-12 12:37:59', '2024-06-12 12:37:59'),
(23, 4, 'Create', 'Create admin user', '2024-06-12 13:20:02', '2024-06-12 13:20:02'),
(24, 4, 'Create', 'Create admin user', '2024-06-12 13:21:59', '2024-06-12 13:21:59'),
(25, 4, 'Create', 'Create admin user', '2024-06-12 13:22:38', '2024-06-12 13:22:38'),
(26, 4, 'User logout', 'User logout at 2024-06-12 09:23:27', '2024-06-12 13:23:27', '2024-06-12 13:23:27'),
(69, 4, 'User login', 'user login at 2024-06-12 09:30:34', '2024-06-12 13:30:34', '2024-06-12 13:30:34'),
(70, 4, 'User logout', 'User logout at 2024-06-12 09:31:07', '2024-06-12 13:31:07', '2024-06-12 13:31:07'),
(77, 4, 'User login', 'user login at 2024-06-12 09:34:57', '2024-06-12 13:34:57', '2024-06-12 13:34:57'),
(78, 4, 'User logout', 'User logout at 2024-06-12 09:35:34', '2024-06-12 13:35:34', '2024-06-12 13:35:34'),
(80, 11, 'User login', 'user login at 2024-06-12 09:37:06', '2024-06-12 13:37:06', '2024-06-12 13:37:06'),
(81, 11, 'User logout', 'User logout at 2024-06-12 09:44:59', '2024-06-12 13:44:59', '2024-06-12 13:44:59'),
(82, 4, 'User login', 'user login at 2024-06-12 09:45:16', '2024-06-12 13:45:16', '2024-06-12 13:45:16'),
(83, 4, 'User logout', 'User logout at 2024-06-12 11:31:45', '2024-06-12 15:31:45', '2024-06-12 15:31:45'),
(84, 4, 'User login', 'user login at 2024-06-12 11:31:51', '2024-06-12 15:31:51', '2024-06-12 15:31:51'),
(85, 4, 'User login', 'user login at 2024-06-13 06:23:22', '2024-06-13 10:23:22', '2024-06-13 10:23:22'),
(86, 11, 'User login', 'user login at 2024-06-13 09:25:18', '2024-06-13 13:25:18', '2024-06-13 13:25:18'),
(87, 11, 'User login', 'user login at 2024-06-13 11:11:48', '2024-06-13 15:11:48', '2024-06-13 15:11:48'),
(88, 4, 'User login', 'user login at 2024-06-14 06:09:49', '2024-06-14 10:09:49', '2024-06-14 10:09:49'),
(89, 4, 'User login', 'user login at 2024-06-15 08:11:30', '2024-06-15 12:11:30', '2024-06-15 12:11:30'),
(90, 4, 'User login', 'user login at 2024-06-15 11:05:48', '2024-06-15 15:05:48', '2024-06-15 15:05:48'),
(91, 4, 'User login', 'user login at 2024-06-17 10:52:45', '2024-06-17 14:52:45', '2024-06-17 14:52:45'),
(92, 4, 'User login', 'user login at 2024-06-18 06:13:55', '2024-06-18 10:13:55', '2024-06-18 10:13:55'),
(93, 4, 'User login', 'user login at 2024-06-18 08:21:01', '2024-06-18 12:21:01', '2024-06-18 12:21:01'),
(94, 7, 'User login', 'user login at 2024-06-18 09:06:29', '2024-06-18 13:06:29', '2024-06-18 13:06:29'),
(95, 4, 'User login', 'user login at 2024-06-19 06:28:33', '2024-06-19 10:28:33', '2024-06-19 10:28:33'),
(96, 4, 'Create', 'Create admin user', '2024-06-19 16:21:33', '2024-06-19 16:21:33'),
(97, 14, 'User login', 'user login at 2024-06-19 12:22:00', '2024-06-19 16:22:00', '2024-06-19 16:22:00'),
(98, 4, 'User login', 'user login at 2024-06-20 06:06:36', '2024-06-20 10:06:36', '2024-06-20 10:06:36'),
(99, 4, 'User login', 'user login at 2024-06-20 06:06:51', '2024-06-20 10:06:51', '2024-06-20 10:06:51'),
(100, 7, 'User login', 'user login at 2024-06-20 09:11:17', '2024-06-20 13:11:17', '2024-06-20 13:11:17'),
(101, 4, 'User login', 'user login at 2024-06-21 06:47:32', '2024-06-21 10:47:32', '2024-06-21 10:47:32'),
(102, 7, 'User login', 'user login at 2024-06-21 07:16:52', '2024-06-21 11:16:52', '2024-06-21 11:16:52'),
(103, 4, 'User logout', 'User logout at 2024-06-21 08:56:00', '2024-06-21 12:56:00', '2024-06-21 12:56:00'),
(104, 4, 'User login', 'user login at 2024-06-21 08:56:07', '2024-06-21 12:56:07', '2024-06-21 12:56:07'),
(105, 4, 'User login', 'user login at 2024-06-21 14:41:01', '2024-06-21 18:41:01', '2024-06-21 18:41:01');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `vendor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `provider_id` mediumtext DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `confirm` enum('Yes','No') NOT NULL DEFAULT 'No',
  `status` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `type`, `vendor_id`, `mobile`, `email`, `provider_id`, `password`, `image`, `confirm`, `status`, `created_at`, `updated_at`) VALUES
(4, 'Admins', 'admin', 1, '0912651113', 'admin@gmail.com', NULL, '$2y$10$i58WGSLneIF/4aoqsUakBOHvQwmEkYLJCPLzawZ5wRCToAPqAPmc.', 'dashboard_1716882354.png', 'No', 1, NULL, '2024-05-28 11:45:54'),
(7, 'vendor', 'vendor', 2, '0912651116', 'vendor@gmail.com', NULL, '$2y$10$SLJD93s2DSluAlk7e7xnTuU0w.qAw.UQQySYmmWKY41HOHgLZfnfa', 'messages-1_1703847845.jpg', 'Yes', 1, '2023-12-07 05:43:11', '2024-01-02 22:43:25'),
(8, 'vendorr', 'Stock Manager', 3, '0912651111', 'vendorr@gmail.com', NULL, '$2y$10$vqlAqTk5g4wQBEtMk9hUi.FV//wPGpHGtCqpXyj0WP6xuKPGfyfEu', 'download_1704202748.jpeg', 'Yes', 1, '2023-12-07 05:43:50', '2024-06-12 13:04:00'),
(9, 'sarah', 'Stock Manager', NULL, '0909090909', 'stockcaper@gmail.com', NULL, '$2y$10$UykMfvn73zD7od3Wijv61eMQOlKbF5wUpEoCCFUBvncZsvu6Dkjhy', '2022-04-23-6263633d39741_1706909226.png', 'No', 1, '2023-12-13 18:47:48', '2024-06-12 13:04:06'),
(10, 'Abel Boyer', 'vendor', 64, '0914651113', 'yaredayele67@gmail.com', NULL, '$2y$10$/ZiWfFXyHl9ORweNLi823.Fj/MB8hRjV4ptP1vP42CFHEfKivnYl6', NULL, 'No', 1, '2024-04-06 20:13:07', '2024-06-10 18:41:52'),
(11, 'Stock Manager', 'Stock Manager', NULL, '0912651144', 'stock@gmail.com', NULL, '$2y$10$i58WGSLneIF/4aoqsUakBOHvQwmEkYLJCPLzawZ5wRCToAPqAPmc.', 'image-voiceover_1718184002.png', 'No', 1, '2024-06-12 13:20:02', '2024-06-12 13:20:26'),
(12, 'Libby Carter', 'vendor', NULL, '0912651115', 'jyreqiwyce@mailinator.com', NULL, '$2y$12$ybYbpHf20Jl06Lk7PZzHFO/og5aAe.2YJv6Vde38.26Gs/umnPJIW', NULL, 'No', NULL, '2024-06-12 13:21:59', '2024-06-12 13:21:59'),
(13, 'Ella Mccarty', 'Stock Manager', NULL, '0912651112', 'tehepa@mailinator.com', NULL, '$2y$12$yXfgL2yVowTOBhc0f4JCyOlEevTZkEi4xLPuflNk07.4VHcM7/KY2', 'audience-for-actors_2x (1)_1718184158.jpg', 'No', 1, '2024-06-12 13:22:38', '2024-06-12 13:22:42'),
(14, 'QA Manager', 'QA Manager', NULL, '0912121212', 'qa@gmail.com', NULL, '$2y$12$T5arlh8687Sxk.v0ptjELuOhjv8g98QiNmS796lPH.ACXarYX0ZNC', 'photo_2024-04-05_06-11-30_1718799693.jpg', 'No', 1, '2024-06-19 16:21:33', '2024-06-19 16:21:37');

-- --------------------------------------------------------

--
-- Table structure for table `admin__user__roles`
--

CREATE TABLE `admin__user__roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin__user__roles`
--

INSERT INTO `admin__user__roles` (`id`, `admin_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 4, 1, '2024-02-17 21:24:55', '2024-02-15 21:24:55'),
(2, 7, 2, NULL, NULL),
(3, 8, 5, NULL, NULL),
(4, 9, 5, NULL, NULL),
(5, 11, 5, NULL, NULL),
(6, 14, 6, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `advertisements`
--

CREATE TABLE `advertisements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(2550) DEFAULT NULL,
  `description` text NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `adv_links` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `advertisements`
--

INSERT INTO `advertisements` (`id`, `title`, `image`, `description`, `is_approved`, `adv_links`, `created_at`, `updated_at`) VALUES
(1, 'Officia quis deserun', '2023-06-13-64885d57240cf_1703149290.png', 'Facilis rerum quis i', 1, 'Illo impedit id lor', '2023-12-06 20:57:50', '2023-12-23 03:51:56');

-- --------------------------------------------------------

--
-- Table structure for table `appsettings`
--

CREATE TABLE `appsettings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `application_title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `phone_no` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `footer_image` varchar(255) DEFAULT NULL,
  `language` varchar(255) DEFAULT NULL,
  `time_zone` varchar(255) DEFAULT NULL,
  `footer_text` text DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `panel_icon` varchar(255) DEFAULT NULL,
  `panel_footer_text` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appsettings`
--

INSERT INTO `appsettings` (`id`, `application_title`, `description`, `address`, `email_address`, `phone_no`, `favicon`, `logo`, `footer_image`, `language`, `time_zone`, `footer_text`, `facebook`, `twitter`, `whatsapp`, `youtube`, `panel_icon`, `panel_footer_text`, `created_at`, `updated_at`) VALUES
(1, 'Ethiopmart', 'A ethiopmart ecommerce website is a platform where multiple sellers can sell their products or services. This type of marketplace is also sometimes called a \"marketplace model\" or \"online marketplace\". Some of the most popular examples of Multi Vendor e', 'Ethiopia,Adama,04', 'yared.debela.ayel@gmail.com', '0912651113', 'logoupdaet_1718701692.png', 'logoupdaet_1718701692.png', 'logoupdaet_1718701692.png', 'Engilsh', 'ETH', 'Multivendor vendor ecommerce website is a platform where multiple sellers can sell their products or services.', 'www.facebook.com', 'www.twitter.co', 'www.whatapp.com', 'www.youtube.com', 'logoupdaet_1718701692.png', '© Copyright Ethiopmart. All Rights Reserved.', '2023-05-18 02:58:04', '2024-06-18 13:08:12');

-- --------------------------------------------------------

--
-- Table structure for table `apps_countries`
--

CREATE TABLE `apps_countries` (
  `id` int(11) NOT NULL,
  `country_code` varchar(2) NOT NULL DEFAULT '',
  `country_name` varchar(100) NOT NULL DEFAULT '',
  `status` int(25) DEFAULT 0,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `apps_countries`
--

INSERT INTO `apps_countries` (`id`, `country_code`, `country_name`, `status`, `updated_at`, `created_at`) VALUES
(2, 'ET', 'Ethiopia', 1, '2023-12-06 12:53:54', '2023-12-06 12:54:12');

-- --------------------------------------------------------

--
-- Table structure for table `assign_stock_product_to_delivery`
--

CREATE TABLE `assign_stock_product_to_delivery` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `delivery_man_id` bigint(20) UNSIGNED NOT NULL,
  `transfer_stock_product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `alt` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id`, `image`, `type`, `link`, `title`, `alt`, `status`, `created_at`, `updated_at`) VALUES
(1, 'new-film-production-concept-bann_1717189882.jpg', 'Slider', 'Et est voluptas dele', 'Ut modi pariatur Nu', 'Elit dolore dolor p', 1, '2023-12-06 20:20:15', '2024-06-01 01:11:22'),
(2, 'online-shopping-banner_82574-339_1717189897.jpg', 'Slider', 'Aut sed omnis ad duc', 'Illum at irure rati', 'Et nisi ut asperiore', 1, '2023-12-06 20:20:31', '2024-06-01 01:11:37'),
(3, '2023-06-13-64885d26757a1_1703098155.png', 'Fix', 'Quod ex aliquam eius', 'jhgh', 'kjj', 1, '2023-12-06 20:47:28', '2023-12-21 04:49:15'),
(4, '2023-06-13-64885cfee404f_1704094872.png', 'Fix', 'Ut consequatur Null', 'Ullamco dolor atque', 'Vitae eos reiciendis', 1, '2023-12-21 04:43:11', '2024-01-01 17:41:12'),
(6, '2023-06-13-64885dd743c93_1704347572.png', 'Fix', 'Soluta quidem nostru', 'Quis debitis pariatu', 'Deleniti quia quidem', 1, '2023-12-27 23:23:17', '2024-01-04 15:52:52'),
(7, '944_generated_1704094723.jpg', 'Fix', 'Voluptatem impedit', 'Deserunt et iste mol', 'Quisquam sint est di', 0, '2023-12-27 23:33:30', '2024-01-30 03:45:37'),
(8, 'new_1704225551.png', 'Fix', 'Expedita est omnis m', 'Quia error consectet', 'Provident qui dolor', 0, '2024-01-03 05:59:11', '2024-01-03 05:59:11'),
(9, '163550169614702d6-PhotoRoom_1701172221_1711558574.jpg', 'Slider', 'Illum sint aliqua', 'Ex vel autem eveniet', 'Numquam illum totam', 1, '2024-01-30 03:43:19', '2024-03-27 20:56:15');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '0',
  `image` varchar(255) DEFAULT NULL,
  `added_by` varchar(255) NOT NULL DEFAULT 'admin',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `description`, `category_id`, `status`, `image`, `added_by`, `created_at`, `updated_at`) VALUES
(2, 'Retarget Them Across The Web', '<p style=\"border-color: rgb(229, 231, 235); --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgb(59 130 246 / 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; margin-bottom: 2rem; line-height: 2; min-width: 100%; max-width: 100%; font-family: &quot;Libre Baskerville&quot;, Georgia, serif; color: rgb(31, 41, 55); font-size: 18px;\">Your brand has customers at each stage in&nbsp;<a href=\"https://www.contentharmony.com/blog/hourglass-sales-funnel/\" style=\"border-color: rgb(229, 231, 235); --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgb(59 130 246 / 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; text-decoration-line: none; background-image: linear-gradient(to top, var(--tw-gradient-stops)); --tw-gradient-from: #1d4ed8 var(--tw-gradient-from-position); --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to); --tw-gradient-to: #1d4ed8 var(--tw-gradient-to-position); background-repeat: repeat-x; transition-property: all; transition-duration: 100ms; transition-timing-function: cubic-bezier(0, 0, 0.2, 1); background-position: 0px 100%; background-size: 2px 2px; padding-bottom: 2px;\">the sales funnel</a>. Some are at the beginning, and just getting familiarized with what you have to offer. Others are at the end, ready to convert and make a purchase from you.</p><p style=\"border-color: rgb(229, 231, 235); --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgb(59 130 246 / 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; margin-bottom: 2rem; line-height: 2; min-width: 100%; max-width: 100%; font-family: &quot;Libre Baskerville&quot;, Georgia, serif; color: rgb(31, 41, 55); font-size: 18px;\">Every step of the way, you have to be there to provide content that will take them one step closer to conversion.</p><p style=\"border-color: rgb(229, 231, 235); --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgb(59 130 246 / 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; margin-bottom: 2rem; line-height: 2; min-width: 100%; max-width: 100%; font-family: &quot;Libre Baskerville&quot;, Georgia, serif; color: rgb(31, 41, 55); font-size: 18px;\">Unlike the people already shopping in your store, readers of your blog may not be quite ready to buy from you. And while the primary goals of content marketing are not to produce a sale immediately, it’s great when it actually happens and it’s certainly worth trying. Since it’s unclear whether they’re ready to purchase or not, it’s going to be up to you to guide them towards a purchase with relevant and valuable content.</p><p style=\"border-color: rgb(229, 231, 235); --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgb(59 130 246 / 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; margin-bottom: 2rem; line-height: 2; min-width: 100%; max-width: 100%; font-family: &quot;Libre Baskerville&quot;, Georgia, serif; color: rgb(31, 41, 55); font-size: 18px;\">There are a few core methods for moving your blog readers towards a purchase:</p><h3 id=\"1-get-them-to-subscribe\" style=\"border-color: rgb(229, 231, 235); --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgb(59 130 246 / 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; font-size: 1.5rem; font-weight: 700; margin-top: 1rem; margin-bottom: 2rem; font-family: &quot;Fira Sans&quot;, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, &quot;Noto Sans&quot;, sans-serif; line-height: 2rem; min-width: 100%; max-width: 100%; --tw-text-opacity: 1; color: rgb(0 0 0 / var(--tw-text-opacity));\">1. Get Them To Subscribe</h3><p style=\"border-color: rgb(229, 231, 235); --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgb(59 130 246 / 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; margin-bottom: 2rem; line-height: 2; min-width: 100%; max-width: 100%; font-family: &quot;Libre Baskerville&quot;, Georgia, serif; color: rgb(31, 41, 55); font-size: 18px;\">Offering to subscribe website visitors to your email list after they read one of your blog posts. Then send them specific content, like shopping guides, comprised of products that are available in your online store.</p><h3 id=\"2-retarget-them-across-the-web\" style=\"border-color: rgb(229, 231, 235); --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgb(59 130 246 / 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; font-size: 1.5rem; font-weight: 700; margin-top: 1rem; margin-bottom: 2rem; font-family: &quot;Fira Sans&quot;, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, &quot;Noto Sans&quot;, sans-serif; line-height: 2rem; min-width: 100%; max-width: 100%; --tw-text-opacity: 1; color: rgb(0 0 0 / var(--tw-text-opacity));\">2. Retarget Them Across The Web</h3><p style=\"border-color: rgb(229, 231, 235); --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgb(59 130 246 / 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; margin-bottom: 2rem; line-height: 2; min-width: 100%; max-width: 100%; font-family: &quot;Libre Baskerville&quot;, Georgia, serif; color: rgb(31, 41, 55); font-size: 18px;\">Remarketing to them via Google ads to purchase a product they read about on your blog. For example, if they clicked on your shopping guide to shoes, you could then ensure that images of these shoes pop up in Google ads as they’re surfing the web.</p><h3 id=\"3-retarget-them-on-facebook-instagram\" style=\"border-color: rgb(229, 231, 235); --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgb(59 130 246 / 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; font-size: 1.5rem; font-weight: 700; margin-top: 1rem; margin-bottom: 2rem; font-family: &quot;Fira Sans&quot;, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, &quot;Noto Sans&quot;, sans-serif; line-height: 2rem; min-width: 100%; max-width: 100%; --tw-text-opacity: 1; color: rgb(0 0 0 / var(--tw-text-opacity));\">3. Retarget Them on Facebook &amp; Instagram</h3><p style=\"border-color: rgb(229, 231, 235); --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgb(59 130 246 / 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; margin-bottom: 2rem; line-height: 2; min-width: 100%; max-width: 100%; font-family: &quot;Libre Baskerville&quot;, Georgia, serif; color: rgb(31, 41, 55); font-size: 18px;\">Retargeting your readers on Facebook with ads. Insert compelling images from your ecommerce store and blog posts into the ads.</p><h3 id=\"4-place-smart-internal-links-within-your-content\" style=\"border-color: rgb(229, 231, 235); --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgb(59 130 246 / 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; font-size: 1.5rem; font-weight: 700; margin-top: 1rem; margin-bottom: 2rem; font-family: &quot;Fira Sans&quot;, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, &quot;Noto Sans&quot;, sans-serif; line-height: 2rem; min-width: 100%; max-width: 100%; --tw-text-opacity: 1; color: rgb(0 0 0 / var(--tw-text-opacity));\">4. Place Smart Internal Links Within Your Content</h3><p style=\"border-color: rgb(229, 231, 235); --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgb(59 130 246 / 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; margin-bottom: 2rem; line-height: 2; min-width: 100%; max-width: 100%; font-family: &quot;Libre Baskerville&quot;, Georgia, serif; color: rgb(31, 41, 55); font-size: 18px;\">Placing links to products within each blog and calls-to-action on the bottom of every blog post. If readers enjoy your blog content, they may want to see what else you have to offer.</p><p style=\"border-color: rgb(229, 231, 235); --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgb(59 130 246 / 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; margin-bottom: 2rem; line-height: 2; min-width: 100%; max-width: 100%; font-family: &quot;Libre Baskerville&quot;, Georgia, serif; color: rgb(31, 41, 55); font-size: 18px;\">The following are some examples of effective blog posts that may persuade readers to purchase from ecommerce stores. You can draw upon these for inspiration in your own online shop and use them to try and convert your own website visitors.</p>', 1, '1', 'photo_11_2024-01-11_08-37-13_1705348850_1706909460.png', 'Admins', '2024-02-03 02:31:00', '2024-05-28 12:18:01'),
(3, 'The Ultimate Guide to Online Shopping: How to Make the Most of Your Ecommerce Experience', '<p>Blog 1: \"The Ultimate Guide to Online Shopping: How to Make the Most of Your Ecommerce Experience\" Welcome to the digital age of shopping! Ecommerce has revolutionized the way we buy and sell goods, providing convenience and accessibility like never before. In this comprehensive guide, we\'ll explore tips and tricks to enhance your online shopping experience and make the most of the vast world of ecommerce. 1. Research Before You Click Before adding items to your cart, take some time to research products, read reviews, and compare prices. This ensures you make informed decisions and get the best value for your money. 2. Take Advantage of Discounts and Promotions Ecommerce platforms frequently offer discounts, promotions, and special deals. Keep an eye out for these opportunities to save money on your purchases. Subscribe to newsletters, follow social media accounts, and use coupon codes during checkout for extra savings. 3. Utilize Filters for a Seamless Shopping Experience Ecommerce websites often have a wide range of products, and finding what you need can be overwhelming. Take advantage of filters to narrow down your search based on price, brand, size, and other criteria. This makes the shopping process efficient and enjoyable. 4. Secure Your Transactions Safety first! Ensure that the ecommerce website you\'re using has secure payment options. Look for \"https://\" in the URL, use trusted payment gateways, and avoid saving sensitive information on public computers. 5. Explore User-Friendly Apps Many ecommerce platforms offer user-friendly mobile apps that make shopping on the go a breeze. Downloading these apps can provide you with exclusive discounts, push notifications for sales, and a seamless shopping experience. Remember, the key to a successful online shopping experience is a combination of research, smart decision-making, and taking advantage of available promotions. Happy shopping! Blog 2: \"Top 5 Must-Have Gadgets for the Modern Home: Your Ultimate Ecommerce Wishlist\" In the fast-paced world of technology, our homes are becoming smarter and more connected than ever. Whether you\'re a tech enthusiast or just looking to upgrade your living space, here\'s a curated list of must-have gadgets available through ecommerce platforms: 1. Smart Home Assistants Bring the future into your home with smart home assistants like Amazon Echo or Google Home. These devices can control your lights, thermostat, and even provide real-time weather updates—all with just a voice command. 2. Robot Vacuum Cleaners Say goodbye to tedious housework with a robot vacuum cleaner. Ecommerce platforms offer a variety of options that can automatically clean your floors, allowing you to spend more time on things you love. 3. Wireless Charging Stations Tired of dealing with tangled cables? Opt for a wireless charging station for your smartphones, smartwatches, and other compatible devices. This sleek and efficient solution is available on many ecommerce sites. 4. Smart Security Systems Enhance the safety of your home with a smart security system. These systems often include cameras, motion detectors, and door/window sensors that you can monitor remotely through a mobile app. Find the perfect one for your needs on your favorite ecommerce platform. 5. Virtual Reality Headsets Immerse yourself in a virtual world with a high-quality VR headset. Whether you\'re into gaming, virtual travel, or educational experiences, ecommerce platforms offer a range of options to suit your preferences. Transform your home into a tech-savvy haven by exploring these gadgets available on ecommerce websites. Embrace the future of convenience and innovation!<br></p>', 5, '0', 'photo_2023-12-28_11-52-51_170481_1706909557.jpg', 'Admins', '2024-02-03 02:32:37', '2024-05-28 12:17:57');

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'News', '1', '2023-12-25 22:12:49', '2023-12-25 22:13:39'),
(3, 'Photography', '1', '2023-12-25 22:14:29', '2023-12-25 22:14:29'),
(5, 'Creative', '1', '2023-12-25 22:14:56', '2023-12-25 22:14:56');

-- --------------------------------------------------------

--
-- Table structure for table `blog_comments`
--

CREATE TABLE `blog_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `blog_id` bigint(20) UNSIGNED NOT NULL,
  `comment` text NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Nikes', 'nike-transparent-nike-free-free (1)_1703074961.png', 1, '2023-01-01 18:00:00', '2023-12-22 07:40:40'),
(2, 'Adidas', 'adidas-new-20225326_1703074544.png', 1, '2023-01-02 19:00:00', '2023-12-20 22:15:44'),
(3, 'Apple', '_1511456315_653_apple-mobile_1703074688.png', 1, '2023-01-03 20:00:00', '2023-12-20 22:18:08'),
(4, 'Samsung', '256_144_2_1703074759.png', 1, '2023-01-04 21:00:00', '2023-12-20 22:19:19'),
(5, 'Sony', 'Untitled_1703074674.jpg', 1, '2023-01-05 22:00:00', '2023-12-20 22:17:54'),
(6, 'Amazon', 'amazon (1)_1703075647.jpg', 1, '2023-01-06 23:00:00', '2023-12-20 22:34:07'),
(7, 'Microsoft', 'images_1703074742.jpg', 1, '2023-01-08 00:00:00', '2023-12-20 22:19:02'),
(8, 'Google', '2048px-Google_G_logo.svg_1703074871.png', 1, '2023-01-09 01:00:00', '2023-12-20 22:21:11'),
(9, 'Puma', 'puma-logo-and-art-free-vector_1703074853.png', 1, '2023-01-10 02:00:00', '2023-12-20 22:20:53'),
(11, 'Coca-Cola', 'Coca-Cola-Logo.wine_1703074799.png', 1, '2023-01-12 04:00:00', '2023-12-20 22:19:59'),
(12, 'Tesla', '1200px-Tesla_T_symbol.svg_1703074811.png', 1, '2023-01-13 05:00:00', '2023-12-20 22:20:11'),
(14, 'Toyota', 'toyouta_1703074827.png', 1, '2023-01-15 07:00:00', '2023-12-20 22:20:27'),
(15, 'McDonald\'s', 'footerlogo_1706909637.jpg', 1, '2023-01-16 08:00:00', '2024-02-03 02:33:57'),
(18, 'other', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `size` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` int(25) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `banner_image` mediumtext DEFAULT NULL,
  `discount` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `group_id`, `parent_id`, `name`, `image`, `banner_image`, `discount`, `description`, `url`, `meta_title`, `meta_description`, `meta_keywords`, `status`, `created_at`, `updated_at`) VALUES
(3, 1, 0, 'Smartphones', '2023-06-13-6488655ea7f52_1703028107.png', 'banner-card1-654756d8c_1MtVI14_1705349865.png', 5, 'Find the best smartphones from top brands.', 'smartphones', 'Best Smartphones - Latest Mobile Phones', 'Browse and buy the latest smartphones online.', 'smartphones, mobile phones, technology', 1, NULL, '2024-01-16 11:17:45'),
(5, 2, 0, 'Men\'s Clothing', '2023-06-13-648820557a5a9_1703028137.png', 'mens-casual-outfits-man-clothing_1706769952.jpg', 21, 'Shop the latest men\'s fashion trends and styles.', 'mens-clothing', 'Men\'s Clothing - Trendy Fashion for Men', 'Explore trendy clothing for men online.', 'mens clothing, fashion, apparel', 1, NULL, '2024-02-01 21:45:52'),
(6, 2, 0, 'Women\'s Clothing', '2023-06-13-64881fc8d29c5_1703028090.png', 'fashion-woman-with-clothes_1203_1707058682.png', 1, 'Discover the latest women\'s fashion and styles.', 'womens-clothing', 'Women\'s Clothing - Fashion for Women', 'Explore trendy clothing for women online.', 'womens clothing, fashion, apparel', 1, NULL, '2024-02-04 19:58:02'),
(7, 1, 0, 'Books', '2023-06-13-64881f86528da_1711554993.png', '2023-06-13-64881f8652a_1705349966.png', 0, 'Dive into the world of books - fiction, non-fiction, and more.', 'books', 'Online Bookstore - Best Reads, Great Deals', 'Explore a vast collection of books online.', 'books, reading, literature', 1, NULL, '2024-03-27 19:56:33'),
(12, 2, 0, 'Furniture', '2023-06-13-6488211a870e0_1703447723.png', '2023-06-13-6488211a870e0_1706769783.png', 20, 'Discover stylish and functional furniture for your home.', 'furniture', 'Furniture Store - Stylish Home Furnishings', 'Explore a wide range of furniture options.', 'furniture, home, decor', 1, NULL, '2024-02-01 21:43:03'),
(15, 2, 0, 'Sports', '2023-06-13-64882013626e6_1703447650.png', '2023-06-13-64882013626e_1706769881.png', 22, 'Find sports equipment and gear for various sports.', 'sports', 'Sports Store - Gear up for Your Game', 'Browse sports equipment and gear online.', 'sports, athletics, gear', 1, NULL, '2024-02-01 21:44:41'),
(17, 1, 0, 'Cameras', '2023-06-13-6488209a179ec_1711555015.png', NULL, 1, 'dasfsdfa', 'camera', NULL, NULL, NULL, 1, '2023-12-20 23:41:47', '2024-03-27 19:56:55'),
(19, 7, 0, 'Beauty', '2023-06-13-64881e123c2dd_1711555054.png', NULL, 2, 'Tempor in dolores an', 'Maxime vel id ipsa', 'Enim rerum repellend', 'Et omnis ipsa aut s', 'Obcaecati quo volupt', 1, '2023-12-25 10:59:27', '2024-03-27 19:57:34'),
(22, 12, 0, 'Home & Furniture', '2023-06-13-6488211a870e0_1711555073.png', 'home_furniture_banner.jpg', 5, 'Enhance your home with our furniture collection', '/home-furniture', 'Home & Furniture - Decorate Your Space', 'Furnish your home with our quality furniture', 'home, furniture, decor', 1, '2024-01-30 05:49:52', '2024-03-27 19:57:53'),
(26, 9, 0, 'Books & Literature', '2023-06-13-64881f86528da_1711554978.png', 'books_banner.jpg', 0, 'Immerse yourself in the world of literature', '/books-literature', 'Books & Literature - Read and Explore', 'Find your next great read with our book collection', 'books, literature, reading', 1, '2024-01-30 05:49:52', '2024-03-27 19:56:18'),
(29, 1, 0, 'Laptops', '2023-06-13-64881b1462dd9_1711554962.png', 'automotive_banner.jpg', 7, 'Upgrade your vehicle with our automotive products', '/automotive', 'Automotive - Drive in Style', 'Enhance your ride with our automotive accessories', 'automotive, car, accessories', 1, '2024-01-30 05:49:52', '2024-03-27 19:56:02');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Adama', '1', '2023-11-25 22:44:07', '2023-11-25 22:44:07'),
(2, 'Addis Ababa', '1', '2023-11-25 22:44:17', '2023-11-25 22:44:17'),
(3, 'Gondar', '1', '2023-11-25 22:44:26', '2023-11-25 22:44:26'),
(4, 'Wellega', '1', '2023-11-25 22:44:35', '2023-11-25 22:44:35'),
(5, 'Bahir Dar', '1', '2023-11-25 22:45:01', '2023-11-25 23:21:46'),
(6, 'Harar', '1', '2023-11-25 22:45:09', '2023-11-25 22:45:09'),
(7, 'Desse', '1', '2023-11-25 22:45:17', '2023-11-25 22:45:17'),
(8, 'Hawassa', '1', '2023-11-25 22:45:25', '2023-11-25 22:45:25'),
(9, 'Mekele', '1', '2023-11-25 22:45:39', '2023-11-25 22:50:05'),
(11, 'Jimma', '1', '2023-11-25 22:47:15', '2023-11-25 22:47:15'),
(12, 'Jijiga', '1', '2023-11-25 22:47:38', '2023-11-25 22:47:38'),
(13, 'Kombolcha', '1', '2023-11-25 22:47:49', '2023-11-25 22:47:49');

-- --------------------------------------------------------

--
-- Table structure for table `cms_pages`
--

CREATE TABLE `cms_pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cms_pages`
--

INSERT INTO `cms_pages` (`id`, `title`, `description`, `url`, `meta_title`, `meta_description`, `meta_keywords`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Privacy Policy', 'Content is Coming soons yared', 'privacy-policy', 'Privacy Policy', 'Privacy Policy of Multivendor Website', 'privacy policy', 1, '2023-05-11 21:20:41', '2023-07-22 08:39:16'),
(7, 'Delivery & Returns', 'Repellendus In enim', 'delivery_and_return', 'Dignissimos eum dolo', 'Vel voluptate molest', 'Ut officiis id anim', 1, '2023-07-22 08:40:33', '2023-07-22 08:40:33'),
(8, 'Shipping Policy', '<ul><li><b>Shipping Policy<o:p></o:p></b></li></ul>\r\n\r\n<p>1. Shipping Methods and Timelines<o:p></o:p></p>\r\n\r\n<p class=\"MsoNormal\">Our multi-vendor platform collaborates with various sellers,\r\neach with their unique shipping methods and timelines. Shipping methods offered\r\ninclude standard, expedited, and express shipping. Please refer to the product\r\npage for specific shipping information provided by each vendor.<o:p></o:p></p>\r\n\r\n<p class=\"MsoNormal\">2. Processing Time<o:p></o:p></p>\r\n\r\n<p class=\"MsoNormal\">Orders typically require 1-3 business days for processing\r\nbefore shipment. However, please note that processing times may vary for\r\nindividual vendors. Customers will receive an email confirmation with tracking\r\ndetails once the order has been shipped.<o:p></o:p></p>\r\n\r\n<p class=\"MsoNormal\">3. Shipping Costs<o:p></o:p></p>\r\n\r\n<p class=\"MsoNormal\">Shipping costs are determined by the individual vendors. The\r\nshipping fees are displayed at checkout and may vary based on the shipping\r\nmethod selected, destination, and weight/size of the item(s) purchased.<o:p></o:p></p>\r\n\r\n<p class=\"MsoNormal\">4. International Shipping<o:p></o:p></p>\r\n\r\n<p class=\"MsoNormal\">We collaborate with vendors worldwide to provide\r\ninternational shipping. Customers are responsible for any customs duties,\r\ntaxes, or import fees that may apply to international orders.<o:p></o:p></p>\r\n\r\n<p class=\"MsoNormal\">5. Order Consolidation<o:p></o:p></p>\r\n\r\n<p class=\"MsoNormal\">Orders containing items from multiple vendors may arrive in\r\nseparate packages and have different delivery dates based on each vendor\'s\r\nlocation and processing time. We aim to consolidate orders where feasible to\r\nminimize shipping costs and reduce environmental impact.<o:p></o:p></p>\r\n\r\n<p class=\"MsoNormal\">6. Shipping Address Accuracy<o:p></o:p></p>\r\n\r\n<p class=\"MsoNormal\">Customers are responsible for providing accurate shipping\r\ninformation. Please double-check the shipping address entered during checkout.\r\nAny additional charges incurred due to incorrect address information will be\r\nthe responsibility of the customer.<o:p></o:p></p>\r\n\r\n<p class=\"MsoNormal\">7. Order Tracking<o:p></o:p></p>\r\n\r\n<p class=\"MsoNormal\">Once orders are processed and shipped, customers will\r\nreceive tracking information via email to monitor the shipment\'s progress. For\r\nany concerns or inquiries regarding tracking, please reach out to the vendor\r\ndirectly or our customer support team for assistance.<o:p></o:p></p>\r\n\r\n<p class=\"MsoNormal\">8. Delays and Exceptions<o:p></o:p></p>\r\n\r\n<p class=\"MsoNormal\">While vendors strive to meet estimated shipping times,\r\nunforeseen circumstances such as weather delays or carrier issues may impact\r\ndelivery schedules.&nbsp;<o:p></o:p></p>', 'shipping_policy', 'Error reiciendis est', 'recusandae', 'Qui ut maxime offici', 1, '2023-07-22 08:40:58', '2023-11-27 22:33:39'),
(9, 'Terms-and-Conditions', 'Qui irure minima min', 'terms_and_conditions', 'Velit cupidatat qui', 'Blanditiis eius expe', 'Minus eius ullamco s', 1, '2023-07-22 08:41:47', '2023-07-27 19:58:41'),
(10, 'Refund_Policy', 'In est pariatur Ut', 'refund_policy', 'Rerum blanditiis iur', 'Saepe commodi volupt', 'Cupidatat velit omni', 1, '2023-07-22 08:42:27', '2023-07-27 19:58:28');

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`id`, `name`, `color`, `status`, `created_at`, `updated_at`) VALUES
(3, 'Blue', '#345ea2', '1', '2023-12-06 18:46:07', '2023-12-06 18:46:07'),
(4, 'Red', '#ff0000', '1', '2023-12-07 19:15:23', '2023-12-07 19:15:23'),
(5, 'Green', '#00ff00', '1', '2023-12-08 20:30:45', '2023-12-08 20:30:45'),
(6, 'Yellow', '#ffff00', '1', '2023-12-09 21:45:12', '2023-12-09 21:45:12'),
(7, 'Purple', '#800080', '1', '2023-12-10 22:55:32', '2023-12-10 22:55:32'),
(8, 'Orange', '#ffa500', '1', '2023-12-11 23:25:11', '2023-12-11 23:25:11'),
(9, 'Pink', '#ff69b4', '1', '2023-12-13 00:40:22', '2023-12-13 00:40:22'),
(10, 'Brown', '#a52a2a', '1', '2023-12-14 01:55:18', '2023-12-14 01:55:18'),
(11, 'White', '#ffffff', '1', '2023-12-15 02:10:29', '2023-12-15 02:10:29'),
(12, 'Black', '#000000', '1', '2023-12-16 03:20:41', '2023-12-16 03:20:41'),
(13, 'Cyan', '#00ffff', '1', '2023-12-17 04:30:55', '2023-12-17 04:30:55');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` bigint(20) UNSIGNED DEFAULT 0,
  `coupon_option` varchar(255) DEFAULT NULL,
  `coupon_code` varchar(255) DEFAULT NULL,
  `categories` text DEFAULT NULL,
  `brands` text DEFAULT NULL,
  `users` text DEFAULT NULL,
  `coupon_type` varchar(255) DEFAULT NULL,
  `amount_type` varchar(255) DEFAULT NULL,
  `amount` double(8,2) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `vendor_id`, `coupon_option`, `coupon_code`, `categories`, `brands`, `users`, `coupon_type`, `amount_type`, `amount`, `expiry_date`, `status`, `created_at`, `updated_at`) VALUES
(3, 1, NULL, '10000100', '7,5,15,23,25,29', '2,3,4,5,8,9,15', 'yared@gmail.com', 'Multiple Times', 'Fixed', 4.00, '1979-12-12', 1, '2024-02-03 02:38:41', '2024-02-03 02:38:41');

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `symbol` varchar(255) NOT NULL,
  `exchange_rate` float NOT NULL,
  `code` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `symbol`, `exchange_rate`, `code`, `created_at`, `updated_at`) VALUES
(1, 'Birr', 'BIRR', 1, 'ETB', '2024-01-21 07:11:06', '2024-02-01 10:31:11'),
(2, 'Dollar', '$', 0.0177933, 'USD', '2024-01-21 07:11:06', '2024-02-01 10:43:01');

-- --------------------------------------------------------

--
-- Table structure for table `custom_order`
--

CREATE TABLE `custom_order` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `order_number` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `user_code` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `delivery_boy_id` varchar(255) DEFAULT NULL,
  `delivery_status` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `custom_order`
--

INSERT INTO `custom_order` (`id`, `customer_name`, `order_number`, `phone_number`, `user_code`, `status`, `delivery_boy_id`, `delivery_status`, `updated_at`, `created_at`) VALUES
(2, 'temesgen', '00006580', '0941832246', '2863', 'approved', '1', 'Pending', '2024-01-19 11:56:02', '2023-12-08 06:13:51'),
(4, 'Pandora Harrington', '00008994', '37', '0432', 'pending', '1', 'Delivered', '2024-02-04 19:00:37', '2024-01-19 17:00:48'),
(5, 'Rebecca Robinson', '00006865', '403', '6032', 'pending', '1', 'Delivered', '2024-02-04 19:07:37', '2024-02-05 00:05:32'),
(6, 'Rebecca Robinson', '00009562', '403', '9851', 'pending', '1', 'Delivered', '2024-02-04 19:07:51', '2024-02-05 00:05:45'),
(7, 'Rebecca Robinson', '00006990', '403', '5796', 'approved', '1', 'Delivered', '2024-02-05 00:08:15', '2024-02-05 00:05:46'),
(8, 'Rebecca Robinson', '00005514', '403', '4017', 'pending', '1', 'Delivered', '2024-02-04 19:07:45', '2024-02-05 00:05:55'),
(9, 'yared', '00004013', '09126511113', '5618', 'pending', NULL, NULL, '2024-02-05 15:10:28', '2024-02-05 15:10:28'),
(10, 'yared', '00002750', '09126511113', '3576', 'pending', NULL, NULL, '2024-02-05 15:10:31', '2024-02-05 15:10:31'),
(11, 'yared', '00007290', '0', '1609', 'pending', NULL, NULL, '2024-02-05 15:40:23', '2024-02-05 15:40:23');

-- --------------------------------------------------------

--
-- Table structure for table `custom_order_products`
--

CREATE TABLE `custom_order_products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `delivery_address` text DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `vendor_code` varchar(255) DEFAULT NULL,
  `delivery_status` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `custom_order_products`
--

INSERT INTO `custom_order_products` (`id`, `product_name`, `quantity`, `description`, `delivery_address`, `order_id`, `vendor_code`, `delivery_status`, `updated_at`, `created_at`) VALUES
(1, 'Cody Ayers', 380, 'Provident eius inve', 'Perspiciatis dolore', 5, '7631', NULL, '2024-02-05 00:05:32', '2024-02-05 00:05:32'),
(2, 'Yuri Woods', 6, 'Recusandae Sequi to', 'Quo sit harum ea vo', 5, '7631', NULL, '2024-02-05 00:05:32', '2024-02-05 00:05:32'),
(3, 'Lev Munoz', 521, 'Aut qui dolorem porr', 'Sit et esse except', 5, '7631', NULL, '2024-02-05 00:05:32', '2024-02-05 00:05:32'),
(4, 'Cody Ayers', 380, 'Provident eius inve', 'Perspiciatis dolore', 6, '4298', NULL, '2024-02-05 00:05:45', '2024-02-05 00:05:45'),
(5, 'Yuri Woods', 6, 'Recusandae Sequi to', 'Quo sit harum ea vo', 6, '4298', NULL, '2024-02-05 00:05:45', '2024-02-05 00:05:45'),
(6, 'Lev Munoz', 521, 'Aut qui dolorem porr', 'Sit et esse except', 6, '4298', NULL, '2024-02-05 00:05:45', '2024-02-05 00:05:45'),
(7, 'Cody Ayers', 380, 'Provident eius inve', 'Perspiciatis dolore', 7, '9118', NULL, '2024-02-05 00:05:46', '2024-02-05 00:05:46'),
(8, 'Yuri Woods', 6, 'Recusandae Sequi to', 'Quo sit harum ea vo', 7, '9118', NULL, '2024-02-05 00:05:46', '2024-02-05 00:05:46'),
(9, 'Lev Munoz', 521, 'Aut qui dolorem porr', 'Sit et esse except', 7, '9118', NULL, '2024-02-05 00:05:46', '2024-02-05 00:05:46'),
(10, 'Cody Ayers', 380, 'Provident eius inve', 'Perspiciatis dolore', 8, '6158', 'New', '2024-02-05 00:25:16', '2024-02-05 00:05:55'),
(11, 'Yuri Woods', 6, 'Recusandae Sequi to', 'Quo sit harum ea vo', 8, '6158', NULL, '2024-02-05 00:05:55', '2024-02-05 00:05:55'),
(12, 'Lev Munoz', 521, 'Aut qui dolorem porr', 'Sit et esse except', 8, '6158', NULL, '2024-02-05 00:05:55', '2024-02-05 00:05:55'),
(13, 'lsadkjfklads', 10, 'aldfkjalskjf', 'aslfjalkjfd', 9, '5544', NULL, '2024-02-05 15:10:28', '2024-02-05 15:10:28'),
(14, 'lsadkjfklads', 10, 'aldfkjalskjf', 'aslfjalkjfd', 10, '1124', NULL, '2024-02-05 15:10:31', '2024-02-05 15:10:31'),
(15, 'lsadkjfklads', 10, 'ih', 'hj', 11, '1351', NULL, '2024-02-05 15:40:23', '2024-02-05 15:40:23');

-- --------------------------------------------------------

--
-- Table structure for table `deliverymen`
--

CREATE TABLE `deliverymen` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `identity_type` varchar(255) NOT NULL,
  `identity_number` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `country` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `delivery_man_image` varchar(255) DEFAULT NULL,
  `identity_image` varchar(255) DEFAULT NULL,
  `driving_license_number` varchar(255) DEFAULT NULL,
  `vehicle_type` varchar(255) DEFAULT NULL,
  `vehicle_capacity` varchar(255) DEFAULT NULL,
  `delivery_zone` varchar(255) DEFAULT NULL,
  `delivery_man_type` varchar(255) DEFAULT NULL,
  `driving_license_image` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deliverymen`
--

INSERT INTO `deliverymen` (`id`, `first_name`, `last_name`, `phone`, `identity_type`, `identity_number`, `address`, `country`, `state`, `city`, `email`, `password`, `delivery_man_image`, `identity_image`, `driving_license_number`, `vehicle_type`, `vehicle_capacity`, `delivery_zone`, `delivery_man_type`, `driving_license_image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'yared', 'ayele', '0912651113', 'passport', '11111111110101', 'Adama', 'Ethiopia', 'Oromia', 'Adama', 'delivery@gmail.com', '$2y$10$i58WGSLneIF/4aoqsUakBOHvQwmEkYLJCPLzawZ5wRCToAPqAPmc.', 'photo_2024-04-05_06-11-30_1716888436.jpg', 'Screenshot 2023-11-09 124230_1699683401.png', '105', NULL, 'Motorcycle', 'Adama,14', 'Employee', 'flash_1700988136.jpg', 'delivering', '2023-11-11 21:16:41', '2024-05-28 13:27:16'),
(2, 'Elizabeth', 'Greer', '+1 (239) 273-3259', 'Possimus eos qui c', '437', 'Molestiae sint volup', 'Ethiopia', 'Benishangul-Gumuz', 'Adama', 'tepyricab@mailinator.com', '$2y$10$u9oZuKaZHzwcivwzGWyCTOiyDRx./2eET5ZB389zzNX.Ig1nqsLiC', 'average-height-in-men-in-india_900_1701983118.jpg', 'online-shopping-spring-on-phone-flower-pink-big-sale-banner-marketing-poster-fashion-vector_1701983118.jpg', '932', NULL, '6', 'Adama,14', 'Freelance', 'online-shopping-on-phone-buy-sell-business-digital-web-banner-application-money-advertising-payment-ecommerce-illustration-search-free-vector_1701983118.jpg', 'delivering', '2023-11-26 22:54:38', '2024-06-13 15:55:24'),
(3, 'betsi', 'Robles', '+1 (528) 335-7304', 'Tempor sapiente nece', '925', 'Eaque minima corpori', 'Ethiopia', 'Somail', 'Adama', 'kopyjoxy@mailinator.com', '$2y$10$oTzOThMa6xOEKv8E0gPkw.zics8cvjammoNqK0lFDRglevtZ4TUyC', 'pexels-photo-5082976_1701983147.png', 'portrait-of-a-handsome-black-man_1701983147.png', '617', NULL, '100', 'Adama,14', 'Contractual', 'online-shopping-on-phone-buy-sell-business-digital-web-banner-application-money-advertising-payment-ecommerce-illustration-search-free-vector_1701983147.jpg', 'available', '2023-11-26 22:57:13', '2023-12-25 18:23:11'),
(5, 'Piper', 'Carver', '+1 (858) 311-9551', 'Debitis corporis per', '918', 'Sit labore a corpor', 'Ethiopia', 'Dire Dawa', 'Adama', 'xawozu@mailinator.com', '$2y$10$efjfAmfJZyHihMqwrWxPvOUh/hd6ndb1C/i8HC8VVVZR9wc9pOFWi', 'patient-care-assistants-blog (1) (3)_1703492551.jpg', 'patient-care-assistants-blog (1)_1703492551.jpg', '897', 'car', 'car', 'Adama,14', 'Employee', 'patient-care-assistants-blog (1) (2)_1703492551.jpg', 'available', '2023-12-25 18:22:31', '2023-12-25 18:22:49'),
(6, 'Allen', 'Reese', '+1 (572) 947-7784', 'Est pariatur Ducimu', '331', 'Facere provident se', 'Ethiopia', 'Amahra', 'Hawassa', 'pyfyzac@mailinator.com', '$2y$12$PgiHEE37.8L508mCkB6Ii.Qy/.ialoslTd5wLRWeZN5vZh/xo173a', '1hEKqNUzJl5c12_1677135172_1716972376.jpg', '7ivIDXvo4n637d_1691040028_1716972376.jpg', '867', 'trucker', 'Iure dolorem delectu', 'Adama,04', 'Contractual', '9-94061_brown-t-shirt-png-image-brown-t-shirt_1673549423_1716972376.png', 'available', '2024-05-29 12:46:16', '2024-05-29 12:46:29'),
(7, 'Neil', 'Hester', '+1 (448) 253-2886', 'Exercitationem excep', '61', 'Commodo ullam volupt', 'Ethiopia', 'Benishangul-Gumuz', 'Mekele', 'zawy@mailinator.com', '$2y$12$LviMI30jPJeTZHS7u2q8Tegi9epEqqWLUtzD.OyKEd4zsMdZx6wau', '1hEKqNUzJl72b1_1677135142_1716973028.jpg', '9-94061_brown-t-shirt-png-image-brown-t-shirt_1673549423_1716973028.png', '590', 'car', 'Accusamus voluptate', 'Adama,14', 'Contractual', NULL, 'available', '2024-05-29 12:57:08', '2024-06-13 15:55:34');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_address`
--

CREATE TABLE `delivery_address` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `pincode` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `latitude` float DEFAULT NULL,
  `longitude` float DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_address`
--

INSERT INTO `delivery_address` (`id`, `user_id`, `name`, `address`, `city`, `state`, `country`, `pincode`, `mobile`, `latitude`, `longitude`, `status`, `created_at`, `updated_at`) VALUES
(2, 4, 'yared', 'Adama14', 'Adama', 'Amahra', 'Ethiopia', 'Velit qui magnam at', '0912651113', NULL, NULL, 1, '2024-02-05 02:48:43', '2024-02-05 04:07:14'),
(4, 4, 'Jaquelyn Newman', 'Placeat enim omnis', 'Adama', 'Tigray', 'Ethiopia', 'Velit qui magnam at', '0909090990', NULL, NULL, 1, '2024-02-05 04:27:39', '2024-02-05 04:27:39');

-- --------------------------------------------------------

--
-- Table structure for table `delivery__boy__roles`
--

CREATE TABLE `delivery__boy__roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `delivery_boy_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery__boy__roles`
--

INSERT INTO `delivery__boy__roles` (`id`, `delivery_boy_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 1, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `delivery__man__types`
--

CREATE TABLE `delivery__man__types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery__man__types`
--

INSERT INTO `delivery__man__types` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Contractual', '1', NULL, '2023-12-23 04:34:55'),
(2, 'Employee', '1', NULL, '2023-11-27 00:43:26'),
(3, 'Freelance', '1\r\n', NULL, '2023-11-27 00:46:45');

-- --------------------------------------------------------

--
-- Table structure for table `delivery__zones`
--

CREATE TABLE `delivery__zones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery__zones`
--

INSERT INTO `delivery__zones` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Adama,04', '1', NULL, '2023-12-19 19:30:25'),
(2, 'Adama,14', '1', NULL, '2024-02-03 02:39:58');

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `min_product` varchar(255) DEFAULT NULL,
  `max_product` varchar(255) DEFAULT NULL,
  `discount_type` varchar(255) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE `email_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`id`, `name`, `email`, `phone`, `address`, `status`, `created_at`, `updated_at`) VALUES
(4, 'EthiopMart', 'ethiopmart@gmail.com', '+1 (952) 357-3106', 'Addis Ababa, merkato', '1', '2023-12-07 14:09:24', '2023-12-22 18:47:09');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `id` bigint(20) NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`id`, `question`, `answer`, `status`, `created_at`, `updated_at`) VALUES
(1, 'How can I become a seller/vendor on the platform?', 'UpdatedAnswer: To become a seller on our platform, you can register as a vendor by filling out the vendor registration form. Once submitted, our team will review your application, and upon approval, you will gain access to your vendor dashboard to manage your products and orders.', '1', NULL, '2023-07-19 07:18:51'),
(2, 'What are the fees and commissions for selling on the platform?', 'Answer: We offer competitive pricing plans for vendors based on their sales volume. Our fees typically include a commission on each successful sale, and we also provide optional subscription packages with added benefits for vendors.', '1', NULL, '2023-07-19 07:08:34'),
(3, 'How are payments processed for orders made from my store?\r\n', 'Answer: When a customer places an order from your store, the payment will be securely processed through our integrated payment gateway. After deducting any applicable fees and commissions, the remaining balance will be transferred to your designated account within the agreed-upon payment cycle.', '1', NULL, '2023-07-19 07:08:37'),
(4, 'How does shipping and order fulfillment work for vendors?', 'Answer: As a vendor, you are responsible for managing the shipping and order fulfillment process for your products. You can set your shipping rates and delivery methods, and the customers will be provided with shipping options during checkout based on the selected products.', '1', NULL, '2023-07-19 07:08:40'),
(5, 'What kind of products can I sell on the platform?', 'Answer: Our platform supports a wide range of products, including physical goods, digital downloads, handmade items, and more. However, certain restricted or prohibited items may not be allowed, and we encourage you to review our vendor guidelines and terms of service.', '1', NULL, '2023-07-19 07:08:43'),
(6, 'How do customer reviews and ratings work for vendors?', 'Answer: Customers can leave reviews and ratings for your products and services based on their shopping experience. Positive reviews can help build trust and credibility for your store, while negative reviews provide opportunities for improvement. Vendors are encouraged to respond to reviews and address customer feedback promptly.', '1', NULL, '2023-07-19 07:08:46'),
(7, 'Is there a customer support system for vendors on the platform?', 'Answer: Yes, we have a dedicated customer support team to assist vendors with any queries or issues they may encounter. You can reach out to our support team through our help center or vendor dashboard for prompt assistance.', '1', NULL, '2023-07-19 07:08:49'),
(8, 'What marketing and promotional tools are available for vendors?', 'Answer: We offer various marketing and promotional features to help vendors increase their visibility and sales. You can run special offers, discounts, and promotions, as well as participate in site-wide sales events and marketing campaigns.', '1', NULL, '2023-08-03 10:03:29');

-- --------------------------------------------------------

--
-- Table structure for table `flash_deals`
--

CREATE TABLE `flash_deals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `start_date` varchar(255) DEFAULT NULL,
  `end_date` varchar(255) DEFAULT NULL,
  `status` bigint(20) UNSIGNED DEFAULT 0,
  `featured` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `background_color` varchar(255) NOT NULL,
  `text_color` varchar(255) NOT NULL,
  `banner` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `flash_deals`
--

INSERT INTO `flash_deals` (`id`, `title`, `start_date`, `end_date`, `status`, `featured`, `background_color`, `text_color`, `banner`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Adrian Stout', '29-01-2024 12:00:00', '14-02-2024 12:00:00', 0, 1, 'Vel repudiandae pari', 'dark', 'photo_2024-02-02_10-29-43_1706859021 (1)_1707091390.jpg', 'adrian-stout-jtkno', '2024-02-05 05:03:10', '2024-05-24 10:43:35');

-- --------------------------------------------------------

--
-- Table structure for table `flash_deal_products`
--

CREATE TABLE `flash_deal_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `flash_deal_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `discount` double NOT NULL DEFAULT 0,
  `discount_type` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Electronics', 'Electronics categorys', 1, '2023-01-15 19:00:00', '2024-02-05 12:35:52'),
(2, 'Clothing', 'Clothing category', 1, '2023-02-20 20:30:00', '2023-12-20 08:13:30'),
(3, 'Books', 'Books category', 1, '2023-03-10 21:45:00', '2023-12-20 08:13:31'),
(4, 'Home & Kitchen', 'Home and Kitchen category', 1, '2023-04-05 16:20:00', '2023-12-20 08:13:51'),
(5, 'Toys', 'Toys category', 1, '2023-05-18 22:55:00', '2023-12-20 08:13:59'),
(6, 'Sports', 'Sports category', 1, '2023-06-23 00:10:00', '2023-12-20 08:14:03'),
(7, 'Beauty', 'Beauty category', 1, '2023-07-30 17:45:00', '2023-12-20 08:14:09'),
(8, 'Furniture', 'Furniture category', 1, '2023-08-14 20:25:00', '2023-12-20 08:14:16'),
(9, 'Food', 'Food category', 1, '2023-09-05 18:20:00', '2023-12-20 08:14:21'),
(12, 'Sample', 'askfjskladf', 1, '2024-01-31 01:49:30', '2024-01-25 01:49:30'),
(13, 'Sample 2', 'sadlkfjaklsjfsa', 1, '2024-01-11 01:49:30', '2024-01-11 01:49:30');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_settings`
--

CREATE TABLE `invoice_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `background_color` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `footer_text` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_settings`
--

INSERT INTO `invoice_settings` (`id`, `name`, `background_color`, `email`, `phone`, `address`, `footer_text`, `status`, `created_at`, `updated_at`) VALUES
(2, 'EthiopMart', '#04a777', 'ethiopmart@gmail.com', '+1 (852) 357-3106', 'Adama, alibira road , 12', 'Invoice was created on a computer and is valid without the signature and seal', '1', '2023-12-08 05:38:22', '2023-12-08 06:04:14');

-- --------------------------------------------------------

--
-- Table structure for table `manager_warehouse`
--

CREATE TABLE `manager_warehouse` (
  `id` int(11) NOT NULL,
  `manager_id` bigint(20) UNSIGNED DEFAULT NULL,
  `warehouse_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manager_warehouse`
--

INSERT INTO `manager_warehouse` (`id`, `manager_id`, `warehouse_id`, `created_at`, `updated_at`) VALUES
(9, 9, 7, '2024-06-12 09:19:17', '2024-06-12 09:19:17'),
(10, 11, 3, '2024-06-12 09:23:16', '2024-06-12 09:23:16');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2024_05_30_055808_create_months_table', 1),
(2, '2024_05_31_091936_create_discounts_table', 2),
(3, '2024_06_04_061254_create_price_plans_table', 3),
(4, '2024_06_04_111205_create_shipping_methods_table', 4),
(5, '2024_06_04_111235_create_shipping_zones_table', 5),
(6, '2024_06_04_111259_create_shipping_method_zone_table', 6),
(7, '2024_06_05_084944_create_shipping_method_prices_table', 7),
(8, '2024_06_06_080140_create_offers_table', 8),
(9, '2024_06_09_083256_create_activity_logs_table', 9),
(10, '2024_06_11_103035_create_withdrawal_requests_table', 10),
(11, '2024_06_15_085957_create_sales_users_table', 11),
(12, '2024_06_17_125741_create_sales_commissions_table', 12),
(13, '2024_06_18_073253_create_sales_main_commissions_table', 13),
(14, '2024_06_20_112407_create_taxes_table', 14),
(15, '2024_06_20_122403_create_withdraw_settings_table', 15);

-- --------------------------------------------------------

--
-- Table structure for table `months`
--

CREATE TABLE `months` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `months`
--

INSERT INTO `months` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'January', '2024-05-30 10:03:47', '2024-05-30 10:03:47'),
(2, 'February', '2024-05-30 10:03:47', '2024-05-30 10:03:47'),
(3, 'March', '2024-05-30 10:03:47', '2024-05-30 10:03:47'),
(4, 'April', '2024-05-30 10:03:47', '2024-05-30 10:03:47'),
(5, 'May', '2024-05-30 10:03:47', '2024-05-30 10:03:47'),
(6, 'June', '2024-05-30 10:03:47', '2024-05-30 10:03:47'),
(7, 'July', '2024-05-30 10:03:47', '2024-05-30 10:03:47'),
(8, 'August', '2024-05-30 10:03:47', '2024-05-30 10:03:47'),
(9, 'September', '2024-05-30 10:03:47', '2024-05-30 10:03:47'),
(10, 'October', '2024-05-30 10:03:47', '2024-05-30 10:03:47'),
(11, 'November', '2024-05-30 10:03:47', '2024-05-30 10:03:47'),
(12, 'December', '2024-05-30 10:03:47', '2024-05-30 10:03:47');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_subscribers`
--

CREATE TABLE `newsletter_subscribers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `newsletter_subscribers`
--

INSERT INTO `newsletter_subscribers` (`id`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'yared@gmail.com', 1, '2023-12-06 20:40:15', '2023-12-06 20:40:15'),
(2, 'admin@gmail.com', 1, '2023-12-13 18:19:13', '2023-12-13 18:19:13');

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `size` varchar(255) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `offer_price` decimal(8,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`id`, `product_id`, `user_id`, `quantity`, `size`, `description`, `offer_price`, `status`, `created_at`, `updated_at`) VALUES
(3, 56, 4, 142, 'Ducimus quo ipsum r', 'Ducimus quo ipsum r', 380.00, 'approved', '2024-06-14 11:53:16', '2024-06-14 12:06:30');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_code` varchar(255) DEFAULT NULL,
  `delivery_boy_id` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `pincode` varchar(255) NOT NULL,
  `latitude` longtext DEFAULT NULL,
  `longitude` longtext DEFAULT NULL,
  `mobile` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `shipping_charges` double(8,2) NOT NULL,
  `tax_charge` float DEFAULT NULL,
  `coupon_code` varchar(255) DEFAULT NULL,
  `coupon_amount` varchar(255) DEFAULT NULL,
  `order_status` varchar(255) DEFAULT NULL,
  `payment_method` varchar(255) NOT NULL,
  `payment_gateway` varchar(255) NOT NULL,
  `grand_total` double(8,2) NOT NULL,
  `payment_currency` varchar(255) DEFAULT NULL,
  `courier_name` varchar(255) DEFAULT NULL,
  `tracking_number` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_code`, `delivery_boy_id`, `name`, `address`, `city`, `state`, `country`, `pincode`, `latitude`, `longitude`, `mobile`, `email`, `shipping_charges`, `tax_charge`, `coupon_code`, `coupon_amount`, `order_status`, `payment_method`, `payment_gateway`, `grand_total`, `payment_currency`, `courier_name`, `tracking_number`, `created_at`, `updated_at`) VALUES
(20, 4, '1192', NULL, 'yared', 'Adama14', 'Adama', 'Amahra', 'Ethiopia', 'Velit qui magnam at', NULL, NULL, '0912651113', 'yared@gmail.com', 1.00, 54.06, NULL, NULL, 'Pending', 'COD', 'COD', 1136.18, NULL, NULL, NULL, '2024-06-07 14:03:40', '2024-06-13 10:43:31'),
(21, 4, '4240', NULL, 'yared', 'Adama14', 'Adama', 'Amahra', 'Ethiopia', 'Velit qui magnam at', NULL, NULL, '0912651113', 'yared@gmail.com', 1.00, -27.68, NULL, NULL, 'New', 'COD', 'COD', 2741.36, NULL, NULL, NULL, '2024-09-07 14:04:59', '2024-06-07 14:04:59'),
(25, 4, '6445', NULL, 'yared', 'Adama14', 'Adama', 'Amahra', 'Ethiopia', 'Velit qui magnam at', NULL, NULL, '0912651113', 'yared@gmail.com', 1.00, 450.72, NULL, NULL, 'New', 'COD', 'COD', 1178.68, NULL, NULL, NULL, '2024-06-17 17:02:06', '2024-06-17 17:02:06'),
(26, 4, '0329', NULL, 'yared', 'Adama14', 'Adama', 'Amahra', 'Ethiopia', 'Velit qui magnam at', NULL, NULL, '0912651113', 'yared@gmail.com', 1.00, 225.36, NULL, NULL, 'New', 'COD', 'COD', 589.84, NULL, NULL, NULL, '2024-06-18 12:21:41', '2024-06-18 12:21:41'),
(27, 4, '8315', NULL, 'yared', 'Adama14', 'Adama', 'Amahra', 'Ethiopia', 'Velit qui magnam at', NULL, NULL, '0912651113', 'yared@gmail.com', 1.00, 225.36, NULL, NULL, 'New', 'COD', 'COD', 589.84, NULL, NULL, NULL, '2024-06-18 12:23:52', '2024-06-18 12:23:52'),
(28, 4, '3418', NULL, 'yared', 'Adama14', 'Adama', 'Amahra', 'Ethiopia', 'Velit qui magnam at', NULL, NULL, '0912651113', 'yared@gmail.com', 1.00, 225.36, NULL, NULL, 'Delivered', 'COD', 'COD', 589.84, NULL, NULL, NULL, '2024-06-18 12:27:07', '2024-06-18 12:27:07'),
(29, 4, '0343', NULL, 'yared', 'Adama14', 'Adama', 'Amahra', 'Ethiopia', 'Velit qui magnam at', NULL, NULL, '0912651113', 'yared@gmail.com', 1.00, 225.36, NULL, NULL, 'New', 'COD', 'COD', 589.84, NULL, NULL, NULL, '2024-06-18 12:28:39', '2024-06-18 12:28:39'),
(30, 4, '4612', NULL, 'yared', 'Adama14', 'Adama', 'Amahra', 'Ethiopia', 'Velit qui magnam at', NULL, NULL, '0912651113', 'yared@gmail.com', 1.00, 225.36, NULL, NULL, 'New', 'COD', 'COD', 589.84, NULL, NULL, NULL, '2024-06-18 12:30:12', '2024-06-18 12:30:12');

-- --------------------------------------------------------

--
-- Table structure for table `orders_logs`
--

CREATE TABLE `orders_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `order_item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_status` varchar(255) NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders_logs`
--

INSERT INTO `orders_logs` (`id`, `order_id`, `order_item_id`, `order_status`, `reason`, `updated_by`, `created_at`, `updated_at`) VALUES
(10, 20, NULL, 'Pending', NULL, NULL, '2024-06-13 10:43:31', '2024-06-13 10:43:31');

-- --------------------------------------------------------

--
-- Table structure for table `orders_products`
--

CREATE TABLE `orders_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `order_product_code` varchar(255) NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_color` varchar(255) NOT NULL,
  `product_size` varchar(255) NOT NULL,
  `product_price` double(8,2) NOT NULL,
  `product_qty` int(11) NOT NULL,
  `item_status` varchar(255) DEFAULT NULL,
  `accepted` varchar(255) DEFAULT NULL,
  `courier_name` varchar(255) DEFAULT NULL,
  `tracking_number` varchar(255) DEFAULT NULL,
  `discount_type` varchar(255) DEFAULT NULL,
  `discounted_price` varchar(255) DEFAULT NULL,
  `specail_discount` varchar(255) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders_products`
--

INSERT INTO `orders_products` (`id`, `order_id`, `user_id`, `vendor_id`, `order_product_code`, `admin_id`, `product_id`, `product_code`, `product_name`, `product_color`, `product_size`, `product_price`, `product_qty`, `item_status`, `accepted`, `courier_name`, `tracking_number`, `discount_type`, `discounted_price`, `specail_discount`, `created_at`, `updated_at`) VALUES
(19, 25, 4, 1, '2446', 4, 58, 'Temporibus cum solut', 'Dolores quo eum temp', 'Black', '32', 363.48, 2, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2024-06-10 12:30:12', '2024-06-17 17:02:06'),
(20, 26, 4, 1, '7700', 4, 58, 'Temporibus cum solut', 'Dolores quo eum temp', 'Black', '32', 363.48, 1, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2024-06-10 12:30:12', '2024-06-18 12:21:41'),
(21, 27, 4, 1, '3235', 4, 58, 'Temporibus cum solut', 'Dolores quo eum temp', 'Black', '32', 363.48, 1, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2024-06-16 12:30:12', '2024-06-18 12:23:52'),
(22, 28, 4, 1, '9086', 4, 58, 'Temporibus cum solut', 'Dolores quo eum temp', 'Black', '32', 363.48, 1, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2024-06-16 12:30:12', '2024-06-18 12:27:07'),
(23, 29, 4, 1, '4428', 4, 58, 'Temporibus cum solut', 'Dolores quo eum temp', 'Black', '32', 363.48, 1, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2024-06-16 12:30:12', '2024-06-18 12:28:39'),
(24, 30, 4, 1, '0220', 4, 58, 'Temporibus cum solut', 'Dolores quo eum temp', 'Black', '32', 363.48, 1, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2024-06-16 12:30:12', '2024-06-18 12:30:12');

-- --------------------------------------------------------

--
-- Table structure for table `order_item_status`
--

CREATE TABLE `order_item_status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` varchar(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_item_status`
--

INSERT INTO `order_item_status` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Pending', '1', NULL, NULL),
(2, 'Processing', '1', NULL, NULL),
(3, 'Picked', '1', NULL, NULL),
(4, 'Delivered', '1', NULL, NULL),
(5, 'Completed', '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_status`
--

CREATE TABLE `order_status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_status`
--

INSERT INTO `order_status` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'New', 1, NULL, NULL),
(2, 'Pending', 1, NULL, NULL),
(3, 'Cancelled', 1, NULL, NULL),
(4, 'Processing', 1, NULL, NULL),
(6, 'Picked', 1, NULL, NULL),
(7, 'Delivered', 1, NULL, NULL),
(8, 'Completed', 1, NULL, NULL),
(9, 'Paid', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('sales@gmail.com', '$2y$12$/qCVG8QdImbHaySit4x4pOWO/AAQd6zk6TUCqzwyBnolzOzzEWVju', '2024-06-15 15:41:26');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `payment_id` varchar(255) NOT NULL,
  `payer_id` varchar(255) NOT NULL,
  `payer_email` varchar(255) NOT NULL,
  `amount` double(10,2) DEFAULT NULL,
  `currency` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `category_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 6, 'view_admins', NULL, '2023-12-27 10:11:48'),
(2, 6, 'create_admin', NULL, NULL),
(3, 4, 'assign_role', NULL, '2023-12-27 10:12:39'),
(4, 5, 'view_permission', NULL, '2023-12-27 10:12:05'),
(5, 4, 'view_role', NULL, '2023-12-27 10:12:25'),
(6, 6, 'view_admin', NULL, NULL),
(7, 19, 'view_delivery_boy', NULL, '2023-12-27 10:12:58'),
(8, 6, 'create_admin', NULL, NULL),
(9, 20, 'view_advertisment', '2023-11-11 21:04:13', '2023-12-27 10:14:32'),
(10, 20, 'create_advertisment', '2023-11-11 21:04:21', '2023-11-11 21:04:21'),
(11, 20, 'edit_advertisment', '2023-11-11 21:04:34', '2023-11-11 21:04:34'),
(12, 20, 'delete_advertisment', '2023-11-11 21:04:46', '2023-11-11 21:04:46'),
(13, 27, 'edit_appsetting', '2023-11-11 21:05:01', '2023-11-11 21:05:01'),
(14, 2, 'view_banners', '2023-11-11 21:05:40', '2023-11-11 21:05:40'),
(15, 2, 'create_banners', '2023-11-11 21:05:48', '2023-12-27 10:11:06'),
(16, 2, 'edit_banners', '2023-11-11 21:05:59', '2023-11-11 21:05:59'),
(17, 2, 'delete_banners', '2023-11-11 21:06:11', '2023-11-11 21:06:11'),
(18, 12, 'view_brand', '2023-11-11 21:06:52', '2023-11-11 21:06:52'),
(19, 12, 'create_brand', '2023-11-11 21:07:01', '2023-11-11 21:07:01'),
(20, 12, 'edit_brand', '2023-11-11 21:07:11', '2023-11-11 21:07:11'),
(21, 12, 'delete_brand', '2023-11-11 21:07:21', '2023-11-11 21:07:21'),
(22, 3, 'view_category', '2023-11-11 21:07:49', '2023-11-11 21:07:49'),
(23, 3, 'create_category', '2023-11-11 21:08:01', '2023-11-11 21:08:01'),
(24, 3, 'edit_category', '2023-11-11 21:08:14', '2023-11-11 21:08:14'),
(25, 3, 'delete_category', '2023-11-11 21:08:33', '2023-11-11 21:08:33'),
(26, 22, 'view_cmspage', '2023-11-11 21:08:54', '2023-11-11 21:08:54'),
(27, 22, 'create_cmspage', '2023-11-11 21:09:04', '2023-11-11 21:09:04'),
(28, 22, 'edit_cmspage', '2023-11-11 21:09:14', '2023-11-11 21:09:14'),
(29, 22, 'delete_cmspage', '2023-11-11 21:09:26', '2023-11-11 21:09:26'),
(30, 15, 'view_coupon', '2023-11-11 21:09:42', '2023-11-11 21:09:42'),
(31, 15, 'delete_coupon', '2023-11-11 21:09:54', '2023-11-11 21:09:54'),
(32, 15, 'create_coupon', '2023-11-11 21:10:08', '2023-11-11 21:10:08'),
(33, 15, 'edit_coupon', '2023-11-11 21:10:18', '2023-11-11 21:10:18'),
(34, 19, 'create_delivery_boy', '2023-11-11 21:11:22', '2023-11-11 21:11:22'),
(35, 19, 'edit_delivery_boy', '2023-11-11 21:11:33', '2023-11-11 21:11:33'),
(36, 19, 'delete_delivery_boy', '2023-11-11 21:11:44', '2023-11-11 21:11:44'),
(37, 14, 'view_filters', '2023-11-11 21:12:09', '2023-11-11 21:12:09'),
(38, 14, 'create_filters', '2023-11-11 21:12:20', '2023-11-11 21:12:20'),
(39, 14, 'view_filters_value', '2023-11-11 21:12:30', '2023-11-11 21:12:30'),
(40, 14, 'create_filters_value', '2023-11-11 21:12:40', '2023-11-11 21:12:40'),
(41, 1, 'view_group', '2023-11-11 21:13:55', '2023-11-11 21:13:55'),
(42, 1, 'create_group', '2023-11-11 21:14:03', '2023-11-11 21:14:03'),
(43, 1, 'edit_group', '2023-11-11 21:14:12', '2023-11-11 21:14:12'),
(44, 1, 'delete_group', '2023-11-11 21:14:20', '2023-11-11 21:14:20'),
(45, 17, 'view_orders', '2023-11-11 21:18:00', '2023-11-11 21:18:00'),
(46, 17, 'view_orders_details', '2023-11-11 21:18:08', '2023-11-11 21:18:08'),
(47, 17, 'update_order_status', '2023-11-11 21:18:25', '2023-11-11 21:18:25'),
(48, 17, 'update_order_item_status', '2023-11-11 21:18:41', '2023-11-11 21:18:41'),
(49, 17, 'view_order_invoice', '2023-11-11 21:19:02', '2023-11-11 21:19:02'),
(50, 18, 'view_return_request', '2023-11-11 21:19:31', '2023-11-11 21:19:31'),
(51, 18, 'edit_return_request', '2023-11-11 21:19:39', '2023-11-11 21:19:39'),
(52, 16, 'view_product', '2023-11-11 21:20:09', '2023-11-11 21:20:09'),
(53, 16, 'delete_product', '2023-11-11 21:20:27', '2023-11-11 21:20:27'),
(54, 16, 'add_product', '2023-11-11 21:20:34', '2023-11-11 21:20:34'),
(55, 16, 'edit_product', '2023-11-11 21:20:48', '2023-11-11 21:20:48'),
(56, 16, 'add_attribute', '2023-11-11 21:21:01', '2023-11-11 21:21:01'),
(57, 16, 'edit_attribute', '2023-11-11 21:21:15', '2023-11-11 21:21:15'),
(58, 16, 'delete_attribute', '2023-11-11 21:21:26', '2023-11-11 21:21:26'),
(59, 16, 'add_image_to_product', '2023-11-11 21:21:34', '2023-11-11 21:21:34'),
(60, 16, 'delete_product_image', '2023-11-11 21:21:44', '2023-11-11 21:21:44'),
(61, 16, 'view_product_rating', '2023-11-11 21:30:07', '2023-11-11 21:30:07'),
(62, 16, 'delete_product_rating', '2023-11-11 21:30:19', '2023-11-11 21:30:19'),
(63, 7, 'view_users', '2023-11-11 21:30:44', '2023-11-11 21:30:44'),
(64, 7, 'create_user', '2023-11-11 21:30:52', '2023-11-11 21:30:52'),
(65, 7, 'edit_user', '2023-11-11 21:31:03', '2023-11-11 21:31:03'),
(66, 7, 'delete_user', '2023-11-11 21:31:13', '2023-11-11 21:31:13'),
(67, 21, 'view_shipping_charge', '2023-11-11 21:31:30', '2023-11-11 21:31:30'),
(68, 21, 'create_shipping_charge', '2023-11-11 21:31:39', '2023-11-11 21:31:39'),
(69, 21, 'edit_shipping_charge', '2023-11-11 21:31:47', '2023-11-11 21:31:47'),
(70, 21, 'delete_shipping_charge', '2023-11-11 21:32:06', '2023-11-11 21:32:06'),
(71, 23, 'view_newsletters', '2023-11-11 21:32:18', '2023-11-11 21:32:18'),
(72, 23, 'delete_newsletter', '2023-11-11 21:32:32', '2023-11-11 21:32:32'),
(73, 6, 'edit_admin', '2023-11-11 21:33:04', '2023-11-11 21:33:04'),
(74, 8, 'view_vendor_detail', '2023-11-11 21:33:25', '2023-11-11 21:33:25'),
(75, 6, 'view_all_admins', '2023-11-11 21:33:35', '2023-11-11 21:33:35'),
(76, 11, 'view_flash_deal', '2023-11-11 21:59:51', '2023-11-11 21:59:51'),
(78, 17, 'assing_delivery_boy_to_order', '2023-11-14 10:03:41', '2023-11-14 10:03:41'),
(79, 34, 'manage_appsetting', '2023-11-16 22:16:21', '2023-11-16 22:16:21'),
(80, 31, 'view warehouse', '2023-11-16 22:16:33', '2023-11-17 00:11:26'),
(81, 31, 'edit_warehouse', '2023-11-17 00:11:53', '2023-11-17 00:11:53'),
(82, 31, 'delete_warehouse', '2023-11-17 00:12:07', '2023-11-17 00:12:07'),
(83, 31, 'create_warehouse', '2023-11-17 00:12:20', '2023-11-17 00:12:20'),
(84, 13, 'view_color', '2023-12-07 08:31:26', '2023-12-07 08:31:26'),
(85, 13, 'add_color', '2023-12-07 08:31:47', '2023-12-07 08:31:47'),
(86, 13, 'edit_color', '2023-12-07 08:31:55', '2023-12-07 08:31:55'),
(87, 13, 'delete_color', '2023-12-07 08:32:06', '2023-12-07 08:32:06'),
(88, 24, 'view_faq', '2023-12-08 07:17:41', '2023-12-08 07:17:41'),
(89, 24, 'add_faq', '2023-12-08 07:17:50', '2023-12-08 07:17:50'),
(90, 24, 'edit_faq', '2023-12-08 07:17:57', '2023-12-08 07:17:57'),
(91, 24, 'delete_faq', '2023-12-08 07:18:06', '2023-12-08 07:18:06'),
(92, 8, 'delete_vendor', '2023-12-18 17:15:33', '2023-12-18 17:15:33'),
(93, 8, 'view_vendor', '2023-12-18 17:15:46', '2023-12-18 17:15:46'),
(94, 14, 'delete_filter', '2023-12-19 21:15:40', '2023-12-19 21:15:40'),
(95, 14, 'delete_filter_value', '2023-12-19 21:19:21', '2023-12-19 21:19:21'),
(96, 14, 'edit_filter_value', '2023-12-19 21:19:33', '2023-12-19 21:19:33'),
(99, 9, 'blogs', '2023-12-27 10:04:52', '2023-12-27 10:04:52'),
(100, 13, 'view_colors', '2023-12-27 10:06:52', '2023-12-27 10:06:52'),
(101, 26, 'view product reports', '2023-12-29 20:22:16', '2023-12-29 20:22:16'),
(102, 26, 'view order reports', '2023-12-29 20:22:37', '2023-12-29 20:22:37'),
(103, 26, 'view order product reports', '2023-12-29 20:23:03', '2023-12-29 20:23:03'),
(104, 26, 'view stock product reports', '2023-12-29 20:23:40', '2023-12-29 20:23:40'),
(105, 26, 'view stock transferred reports', '2023-12-29 20:24:13', '2023-12-29 20:24:13'),
(106, 26, 'view custom order reports', '2023-12-29 20:24:41', '2023-12-29 20:25:51'),
(107, 26, 'view customer reports', '2023-12-29 20:25:06', '2023-12-29 20:25:06'),
(108, 26, 'view vendor reports', '2023-12-29 20:25:32', '2023-12-29 20:25:32'),
(110, 9, 'view blog', '2024-01-12 19:19:41', NULL),
(111, 9, 'add blog', '2024-01-12 19:19:41', NULL),
(112, 9, 'edit blog', '2024-01-12 19:19:41', NULL),
(113, 9, 'delete blog', '2024-01-12 19:19:41', NULL),
(114, 9, 'view blog category', '2024-01-13 01:42:02', '2024-01-13 01:42:02'),
(115, 9, 'add blog category', '2024-01-13 01:42:16', '2024-01-13 01:42:16'),
(116, 9, 'edit blog category', '2024-01-13 01:42:42', '2024-01-13 01:42:42'),
(117, 9, 'delete blog category', '2024-01-13 01:43:05', '2024-01-13 01:43:05'),
(118, 9, 'view blog comment', '2024-01-13 01:46:33', '2024-01-13 01:46:33'),
(119, 9, 'edit blog comment', '2024-01-13 01:46:46', '2024-01-13 01:46:46'),
(120, 9, 'delete blog comment', '2024-01-13 01:47:05', '2024-01-13 01:47:05'),
(128, 19, 'view delivery zone', '2024-01-12 20:55:03', NULL),
(129, 19, 'add delivery zone', '2024-01-12 20:55:03', NULL),
(130, 19, 'edit delivery zone', '2024-01-12 20:55:03', NULL),
(131, 19, 'delete delivery zone', '2024-01-12 20:55:03', NULL),
(132, 19, 'view deliveryman type', '2024-01-12 20:55:03', NULL),
(133, 19, 'add deliveryman type', '2024-01-12 20:55:03', NULL),
(134, 19, 'edit deliveryman type', '2024-01-12 20:55:03', NULL),
(135, 19, 'delete deliveryman type', '2024-01-12 20:55:03', NULL),
(136, 19, 'view vehicle type', '2024-01-12 20:55:03', NULL),
(137, 19, 'add vehicle type', '2024-01-12 20:55:03', NULL),
(138, 19, 'edit vehicle type', '2024-01-12 20:55:03', NULL),
(139, 19, 'delete vehicle type', '2024-01-12 20:55:03', NULL),
(140, 29, 'view state', '2024-01-12 21:38:44', NULL),
(141, 29, 'add state', '2024-01-12 21:38:44', NULL),
(142, 29, 'edit state', '2024-01-12 21:38:44', NULL),
(143, 29, 'delete state', '2024-01-12 21:38:44', NULL),
(144, 30, 'view city', '2024-01-12 21:38:44', NULL),
(145, 30, 'edit city', '2024-01-12 21:38:44', NULL),
(146, 30, 'delete city', '2024-01-12 21:38:44', NULL),
(147, 30, 'add city', '2024-01-12 21:38:44', NULL),
(148, 28, 'view country', '2024-01-12 21:38:44', NULL),
(149, 28, 'edit country', '2024-01-12 21:38:44', NULL),
(150, 28, 'delete country', '2024-01-12 21:38:44', NULL),
(151, 28, 'add country', '2024-01-12 21:38:44', NULL),
(152, 35, 'view email template', '2024-01-12 22:30:18', NULL),
(153, 35, 'add email template', '2024-01-12 22:30:18', NULL),
(154, 35, 'edit email template', '2024-01-12 22:30:18', NULL),
(155, 35, 'delete email template', '2024-01-12 22:30:18', NULL),
(156, 32, 'view custom order', '2024-01-12 22:30:18', NULL),
(157, 32, 'view custom order invoice', '2024-01-12 22:30:18', NULL),
(158, 32, 'edit custom order', '2024-01-12 22:30:18', NULL),
(159, 32, 'delete custom order', '2024-01-12 22:30:18', NULL),
(160, 32, 'view custom order detail', NULL, NULL),
(161, 32, 'assign custom order to deliveryman', NULL, NULL),
(162, 11, 'add_flashdeal', '2024-01-13 03:54:22', '2024-01-13 03:54:22'),
(163, 11, 'edit_flashdeal', '2024-01-13 03:54:49', '2024-01-13 03:54:49'),
(164, 11, 'delete_flashdeal', '2024-01-13 03:55:06', '2024-01-13 03:55:06'),
(165, 36, 'view invoice', '2024-01-13 04:07:31', '2024-01-13 04:07:31'),
(166, 36, 'add invoice', '2024-01-13 04:07:44', '2024-01-13 04:07:44'),
(167, 36, 'edit invoice', '2024-01-13 04:07:55', '2024-01-13 04:07:55'),
(168, 36, 'delete invoice', '2024-01-13 04:08:07', '2024-01-13 04:08:07'),
(169, 37, 'view transfer request', '2024-01-13 10:13:00', '2024-01-13 10:13:00'),
(170, 37, 'approve transfer request', '2024-01-13 10:13:17', '2024-01-13 10:13:17'),
(171, 37, 'delete transfer request', '2024-01-13 10:13:35', '2024-01-13 10:13:35'),
(172, 38, 'view transaction', '2024-01-13 10:20:33', '2024-01-13 10:20:33'),
(173, 38, 'view detail transaction', '2024-01-13 10:20:51', '2024-01-13 10:20:51'),
(174, 38, 'edit transaction', '2024-01-13 10:21:09', '2024-01-13 10:21:09'),
(175, 38, 'delete transaction', '2024-01-13 10:21:25', '2024-01-13 10:21:25'),
(176, 10, 'view stock', '2024-01-13 10:29:27', '2024-01-13 10:29:27'),
(177, 10, 'add stock', '2024-01-13 10:29:46', '2024-01-13 10:29:46'),
(178, 10, 'edit stock', '2024-01-13 10:30:17', '2024-01-13 10:30:17'),
(179, 10, 'delete stock', '2024-01-13 10:30:31', '2024-01-13 10:30:31'),
(180, 25, 'edit product rating', '2024-01-13 10:34:43', '2024-01-13 10:35:15'),
(181, 39, 'view transfer product', '2024-01-13 10:38:30', '2024-01-13 10:38:30'),
(182, 39, 'add transfer product', '2024-01-13 10:38:48', '2024-01-13 10:38:48'),
(183, 39, 'assign transfer product to deliveryman', '2024-01-13 10:39:09', '2024-01-13 10:43:47'),
(184, 39, 'view transfered stock product', '2024-01-13 10:39:25', '2024-01-13 10:45:20'),
(185, 39, 'delete transfer product', '2024-01-13 10:48:00', '2024-01-13 10:48:00'),
(186, 39, 'view transfer product invoice', '2024-01-13 22:47:36', '2024-01-13 22:47:36'),
(187, 16, 'edit_product_image', '2024-01-13 22:52:49', '2024-01-13 22:52:49'),
(188, 5, 'view permission', '2024-01-13 22:54:21', '2024-01-13 22:54:21'),
(189, 5, 'add permission', '2024-01-13 22:54:33', '2024-01-13 22:54:33'),
(190, 5, 'edit permission', '2024-01-13 22:54:52', '2024-01-13 22:54:52'),
(191, 5, 'delete permission', '2024-01-13 22:55:05', '2024-01-13 22:55:05'),
(192, 4, 'view role', '2024-01-13 22:55:24', '2024-01-13 22:55:24'),
(193, 4, 'add role', '2024-01-13 22:55:40', '2024-01-13 22:55:40'),
(194, 4, 'edit role', '2024-01-13 22:55:54', '2024-01-13 22:55:54'),
(195, 4, 'delete role', '2024-01-13 22:56:09', '2024-01-13 22:56:09'),
(196, 5, 'view permission category', '2024-01-13 22:56:51', '2024-01-13 22:56:51'),
(197, 5, 'add permission category', '2024-01-13 22:57:05', '2024-01-13 22:57:05'),
(198, 5, 'edit permission category', '2024-01-13 22:57:19', '2024-01-13 22:57:19'),
(199, 5, 'delete permission category', '2024-01-13 22:57:36', '2024-01-13 22:57:36'),
(200, 4, 'assign role', '2024-01-13 22:59:11', '2024-01-13 22:59:58'),
(201, 32, 'update custom order status', '2024-01-13 23:18:46', '2024-01-13 23:18:46'),
(202, 39, 'view transfer product detail', '2024-01-13 23:25:27', '2024-01-13 23:25:27'),
(203, 39, 'update transfer product status', '2024-01-13 23:27:18', '2024-01-13 23:27:18'),
(204, 23, 'send_newsletters', '2024-01-14 02:48:25', '2024-01-14 02:48:25'),
(205, 23, 'edit_newsletter', '2024-01-14 02:48:59', '2024-01-14 02:48:59'),
(206, 14, 'edit_filter', '2024-01-14 09:11:17', '2024-01-14 09:11:17'),
(207, 6, 'delete_admin', '2024-01-14 11:11:42', '2024-01-14 11:11:42'),
(208, 17, 'view_order_reports', '2024-01-16 07:08:46', '2024-01-16 07:08:46'),
(209, 40, 'add currency', '2024-02-01 09:28:10', '2024-02-01 09:28:10'),
(210, 40, 'edit currency', '2024-02-01 09:28:24', '2024-02-01 09:28:24'),
(211, 40, 'view currency', '2024-02-01 09:28:48', '2024-02-01 09:28:48'),
(212, 40, 'delete currency', '2024-02-01 09:29:04', '2024-02-01 09:29:04'),
(213, 41, 'view payment', '2024-02-08 12:01:04', '2024-02-08 12:01:04'),
(214, 42, 'view activity_log', '2024-06-10 14:49:15', '2024-06-10 14:49:15'),
(215, 42, 'delete activity_log', '2024-06-10 14:49:31', '2024-06-10 14:49:31'),
(216, 8, 'login with vendor', '2024-06-11 10:17:42', '2024-06-11 10:17:42'),
(217, 31, 'assign user to warehouse', '2024-06-12 12:43:44', '2024-06-12 12:43:44'),
(218, 43, 'view sales_person', '2024-06-18 12:32:54', '2024-06-18 12:32:54'),
(219, 43, 'add sales_person', '2024-06-18 12:33:04', '2024-06-18 12:33:04'),
(220, 43, 'edit sales_person', '2024-06-18 12:33:14', '2024-06-18 12:33:14'),
(221, 43, 'delete sales_person', '2024-06-18 12:33:26', '2024-06-18 12:33:26'),
(222, 16, 'update product status', '2024-06-19 16:17:56', '2024-06-19 16:17:56'),
(223, 44, 'view seasonal', '2024-06-20 10:10:24', '2024-06-20 10:10:24'),
(224, 44, 'add seasonal', '2024-06-20 10:10:38', '2024-06-20 10:10:38'),
(225, 45, 'view tax', '2024-06-20 16:02:11', '2024-06-20 16:02:11'),
(226, 45, 'add tax', '2024-06-20 16:02:20', '2024-06-20 16:02:20'),
(227, 45, 'edit tax', '2024-06-20 16:02:28', '2024-06-20 16:02:28'),
(228, 45, 'delete tax', '2024-06-20 16:02:39', '2024-06-20 16:02:39'),
(229, 46, 'view withdrawal request', '2024-06-21 11:03:47', '2024-06-21 11:03:47'),
(230, 46, 'add withdrawal request', '2024-06-21 11:04:08', '2024-06-21 11:04:08'),
(231, 46, 'edit withdrawal request', '2024-06-21 11:04:21', '2024-06-21 11:04:21'),
(232, 46, 'delete withdrawal request', '2024-06-21 11:05:34', '2024-06-21 11:05:34');

-- --------------------------------------------------------

--
-- Table structure for table `permission_categories`
--

CREATE TABLE `permission_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_categories`
--

INSERT INTO `permission_categories` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'group', '1', '2023-12-27 09:41:53', '2023-12-27 09:41:53'),
(2, 'banner', '1', '2023-12-27 09:42:01', '2023-12-27 09:42:01'),
(3, 'category', '1', '2023-12-27 09:42:08', '2023-12-27 09:42:08'),
(4, 'role', '1', '2023-12-27 09:42:16', '2023-12-27 09:42:16'),
(5, 'permission', '1', '2023-12-27 09:42:25', '2023-12-27 09:42:25'),
(6, 'admin', '1', '2023-12-27 09:42:32', '2023-12-27 09:42:32'),
(7, 'customer', '1', '2023-12-27 09:42:39', '2023-12-27 09:42:52'),
(8, 'vendor', '1', '2023-12-27 09:43:00', '2023-12-27 09:43:00'),
(9, 'blogs', '1', '2023-12-27 09:43:11', '2023-12-27 09:43:11'),
(10, 'stock', '1', '2023-12-27 09:43:16', '2023-12-27 09:43:16'),
(11, 'flashdeal', '1', '2023-12-27 09:43:27', '2023-12-27 09:43:27'),
(12, 'brand', '1', '2023-12-27 09:43:38', '2023-12-27 09:43:38'),
(13, 'colors', '1', '2023-12-27 09:43:49', '2023-12-27 09:43:49'),
(14, 'filter', '1', '2023-12-27 09:43:56', '2023-12-27 09:43:56'),
(15, 'coupon', '1', '2023-12-27 09:44:07', '2023-12-27 09:44:07'),
(16, 'product', '1', '2023-12-27 09:44:13', '2023-12-27 09:44:13'),
(17, 'order', '1', '2023-12-27 09:44:30', '2023-12-27 09:44:30'),
(18, 'return request', '1', '2023-12-27 09:44:39', '2023-12-27 09:44:39'),
(19, 'delviery boy', '1', '2023-12-27 09:44:48', '2023-12-27 09:44:48'),
(20, 'advertisement', '1', '2023-12-27 09:45:01', '2023-12-27 09:45:01'),
(21, 'shipping', '1', '2023-12-27 09:45:11', '2023-12-27 09:45:11'),
(22, 'cms pages', '1', '2023-12-27 09:45:22', '2023-12-27 09:45:22'),
(23, 'newsletter subscribers', '1', '2023-12-27 09:45:46', '2023-12-27 09:45:46'),
(24, 'FAQ', '1', '2023-12-27 09:45:54', '2023-12-27 09:45:54'),
(25, 'Product Rating', '1', '2023-12-27 09:46:14', '2023-12-27 09:46:14'),
(26, 'Reports', '1', '2023-12-27 09:46:22', '2023-12-27 09:46:22'),
(27, 'Website setting', '1', '2023-12-27 09:46:44', '2023-12-27 09:46:44'),
(28, 'country', '1', '2023-12-27 09:47:02', '2023-12-27 09:47:02'),
(29, 'state', '1', '2023-12-27 09:47:08', '2023-12-27 09:47:08'),
(30, 'City', '1', '2023-12-27 09:47:18', '2023-12-27 09:47:18'),
(31, 'Warehouse', '1', '2023-12-27 09:47:28', '2023-12-27 09:48:45'),
(32, 'Custom Order', '1', '2023-12-27 09:48:01', '2023-12-27 09:48:01'),
(34, 'appsetting', '1', NULL, NULL),
(35, 'Email Template', '1', '2024-01-13 03:24:13', '2024-01-13 03:24:13'),
(36, 'Invoice', '1', '2024-01-13 04:07:03', '2024-01-13 04:07:03'),
(37, 'transfer request', '1', '2024-01-13 10:12:39', '2024-01-13 10:12:39'),
(38, 'Transaction', '1', '2024-01-13 10:20:20', '2024-01-13 10:20:20'),
(39, 'Transfer Product', '1', '2024-01-13 10:37:57', '2024-01-13 10:37:57'),
(40, 'currency', '1', '2024-02-01 09:27:49', '2024-02-01 09:27:49'),
(41, 'payment', '1', '2024-02-08 12:00:35', '2024-02-08 12:00:35'),
(42, 'activity_log', '1', '2024-06-10 14:48:43', '2024-06-10 14:48:43'),
(43, 'sales', '1', '2024-06-18 12:32:27', '2024-06-18 12:32:27'),
(44, 'seasonal', '1', '2024-06-20 10:10:03', '2024-06-20 10:10:03'),
(45, 'tax', '1', '2024-06-20 16:01:59', '2024-06-20 16:01:59'),
(46, 'withdrawal request', '1', '2024-06-21 11:03:05', '2024-06-21 11:03:30');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `price_plans`
--

CREATE TABLE `price_plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(8,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `duration` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `price_plans`
--

INSERT INTO `price_plans` (`id`, `name`, `description`, `price`, `status`, `duration`, `created_at`, `updated_at`) VALUES
(1, 'Lionel Ray', 'Cum magni et deserun', 900.00, 1, 20, '2024-06-04 13:10:36', '2024-06-04 13:52:27'),
(4, 'Alana Barron', 'Laboris beatae nostr', 392.00, 1, 20, '2024-06-04 13:50:17', '2024-06-04 13:52:28');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` varchar(255) DEFAULT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `subcategory_id` int(11) UNSIGNED DEFAULT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `admin_type` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_color` varchar(255) DEFAULT NULL,
  `product_video` varchar(255) DEFAULT NULL,
  `product_code` varchar(255) NOT NULL,
  `price_type` varchar(255) DEFAULT 'regular',
  `product_price` decimal(10,2) DEFAULT 0.00,
  `is_offer_price` varchar(255) DEFAULT 'no',
  `product_tax` decimal(5,2) DEFAULT NULL,
  `product_discount` decimal(10,2) DEFAULT NULL,
  `discount_start_date` varchar(255) DEFAULT NULL,
  `discount_end_date` varchar(255) DEFAULT NULL,
  `product_weight` int(11) NOT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `camera_mp` varchar(255) DEFAULT NULL,
  `battery_capacity` varchar(255) DEFAULT NULL,
  `storage` varchar(255) DEFAULT NULL,
  `screen_size` varchar(255) DEFAULT NULL,
  `ram` varchar(255) DEFAULT NULL,
  `is_featured` enum('No','Yes') NOT NULL DEFAULT 'No',
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `status_comment` varchar(255) DEFAULT NULL,
  `is_seasonal` tinyint(1) NOT NULL DEFAULT 0,
  `season_end_months` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`season_end_months`)),
  `available_for_delivery` varchar(2) DEFAULT NULL,
  `is_returnable` varchar(2) DEFAULT NULL,
  `returnable_time` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_id`, `group_id`, `category_id`, `subcategory_id`, `brand_id`, `vendor_id`, `admin_id`, `admin_type`, `product_name`, `product_color`, `product_video`, `product_code`, `price_type`, `product_price`, `is_offer_price`, `product_tax`, `product_discount`, `discount_start_date`, `discount_end_date`, `product_weight`, `product_image`, `description`, `camera_mp`, `battery_capacity`, `storage`, `screen_size`, `ram`, `is_featured`, `status`, `status_comment`, `is_seasonal`, `season_end_months`, `available_for_delivery`, `is_returnable`, `returnable_time`, `created_at`, `updated_at`) VALUES
(56, NULL, 7, 19, NULL, 6, 1, 4, 'admin', 'Sed et dolorum culpa', 'Green', NULL, 'Cillum reprehenderit', 'regular', 0.00, 'yes', 10.00, 13.00, NULL, NULL, 7, 'images/GpNkwItjO05U6NzuOGbTomksKWDbbZ2oRtcyjMLb.jpg', 'lkjlkjk', NULL, NULL, NULL, NULL, NULL, 'Yes', 0, 'it not prefect', 1, NULL, '0', '1', '1', '2024-06-14 10:37:54', '2024-06-20 10:16:21'),
(57, NULL, 7, 19, NULL, 3, 1, 4, 'admin', 'T-shirt', 'Green', NULL, 'Cillum', 'regular', 0.00, 'yes', 10.00, 13.00, NULL, NULL, 7, 'images/zW82irNDvZrTXCy2jhxhlWvAkStt2JIEqMpSY940.jpg', 'lkjlkjk', NULL, NULL, NULL, NULL, NULL, 'Yes', 1, NULL, 1, NULL, '0', '1', '3', '2024-06-14 10:38:22', '2024-06-18 13:29:32'),
(58, NULL, 1, 29, NULL, 12, 1, 4, 'admin', 'Dolores quo eum temp', 'Black', NULL, 'Temporibus cum solut', 'regular', 97.00, 'no', 62.00, 61.00, NULL, NULL, 91, 'images/aRKAARWkB3UuLy5GVT3cuF39IWRbAdN2b3uGAljQ.jpg', 'Nulla cupiditate pjar', NULL, NULL, NULL, NULL, NULL, 'Yes', 1, NULL, 1, NULL, '1', '1', '3', '2024-06-14 10:43:43', '2024-06-18 13:29:33'),
(60, NULL, 1, 3, NULL, 12, 1, 4, 'admin', 'Sunt itaque et volu', 'Yellow', NULL, 'Magnam occaecat est ', 'regular', 31.00, 'no', 15.00, 59.00, NULL, NULL, 81, 'images/sGVK2izPAcP99NEJ1Gr3oC8873fPG42gqUi4IFrq.png', 'hi', NULL, NULL, NULL, NULL, NULL, 'Yes', 1, NULL, 1, NULL, '1', '1', '2', '2024-06-18 16:10:22', '2024-06-19 16:08:49');

-- --------------------------------------------------------

--
-- Table structure for table `products_attributes`
--

CREATE TABLE `products_attributes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `warehouse_id` bigint(20) UNSIGNED DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `price` double(8,2) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products_attributes`
--

INSERT INTO `products_attributes` (`id`, `product_id`, `warehouse_id`, `size`, `price`, `stock`, `sku`, `status`, `created_at`, `updated_at`) VALUES
(15, 57, 1, 'small', NULL, 100, 's11', 1, '2024-06-14 10:38:54', '2024-06-14 10:38:54'),
(16, 57, 3, 'large', NULL, 100, 'l111', 1, '2024-06-14 10:39:12', '2024-06-14 10:39:12'),
(17, 56, 6, 'small', NULL, 35, 's22', 1, '2024-06-14 10:39:32', '2024-06-14 10:39:32'),
(18, 58, 1, '32', 932.00, 93, 'b12', 1, '2024-06-17 16:39:34', '2024-06-18 12:30:12');

-- --------------------------------------------------------

--
-- Table structure for table `products_filters`
--

CREATE TABLE `products_filters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cat_ids` bigint(20) UNSIGNED NOT NULL,
  `filter_name` varchar(255) NOT NULL,
  `filter_column` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products_filters`
--

INSERT INTO `products_filters` (`id`, `cat_ids`, `filter_name`, `filter_column`, `status`, `created_at`, `updated_at`) VALUES
(2, 3, 'Ram', 'ram', 1, '2024-06-06 11:47:01', '2024-06-06 11:47:01'),
(3, 3, 'Screen Size', 'screen_size', 1, '2024-06-19 11:14:07', '2024-06-19 11:14:07'),
(4, 3, 'storage', 'storage', 1, '2024-06-19 11:16:26', '2024-06-19 11:16:26'),
(5, 3, 'battery_capacity', 'battery_capacity', 1, '2024-06-19 11:16:48', '2024-06-19 11:16:48'),
(6, 3, 'camera_mp', 'camera_mp', 1, '2024-06-19 11:17:09', '2024-06-19 11:17:09');

-- --------------------------------------------------------

--
-- Table structure for table `products_filters_values`
--

CREATE TABLE `products_filters_values` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `filter_id` bigint(20) UNSIGNED NOT NULL,
  `filter_value` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products_filters_values`
--

INSERT INTO `products_filters_values` (`id`, `filter_id`, `filter_value`, `status`, `created_at`, `updated_at`) VALUES
(2, 2, '8GB', 1, '2024-06-06 11:47:19', '2024-06-06 11:47:19'),
(3, 2, '16GB', 1, '2024-06-06 11:47:26', '2024-06-06 11:47:26'),
(4, 3, '1000x2000', 1, '2024-06-19 11:14:26', '2024-06-19 11:14:26'),
(5, 4, '64GB', 1, '2024-06-19 11:17:27', '2024-06-19 11:17:27'),
(6, 5, '5000', 1, '2024-06-19 11:17:35', '2024-06-19 11:17:35'),
(7, 6, '12', 1, '2024-06-19 11:17:43', '2024-06-19 11:17:43');

-- --------------------------------------------------------

--
-- Table structure for table `products_images`
--

CREATE TABLE `products_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_month`
--

CREATE TABLE `product_month` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `month_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `review` text NOT NULL,
  `rating` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recently_viewed_products`
--

CREATE TABLE `recently_viewed_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `recently_viewed_products`
--

INSERT INTO `recently_viewed_products` (`id`, `product_id`, `session_id`, `created_at`, `updated_at`) VALUES
(16, 57, '67af734a9ab2346e44c4844fdc1ace7f', NULL, NULL),
(17, 56, '67af734a9ab2346e44c4844fdc1ace7f', NULL, NULL),
(18, 58, '67af734a9ab2346e44c4844fdc1ace7f', NULL, NULL),
(19, 56, 'd5dece8ca6b2d53776f441f8cda2f17a', NULL, NULL),
(20, 58, 'd5dece8ca6b2d53776f441f8cda2f17a', NULL, NULL),
(21, 58, 'c901e3e956069402fa8dae0e8a15bd40', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `return_requests`
--

CREATE TABLE `return_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_size` varchar(255) DEFAULT NULL,
  `product_code` varchar(255) NOT NULL,
  `return_reason` varchar(255) NOT NULL,
  `return_status` enum('Pending','Approved','Rejected') NOT NULL,
  `comment` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', NULL, NULL),
(2, 'vendor', NULL, NULL),
(3, 'delivery_man', '2023-11-11 21:17:09', '2023-11-11 21:17:09'),
(5, 'Stock Manager', '2023-12-13 18:48:15', '2024-06-12 13:00:16'),
(6, 'QA Manager', '2024-06-19 16:16:32', '2024-06-19 16:16:32');

-- --------------------------------------------------------

--
-- Table structure for table `role__permissions`
--

CREATE TABLE `role__permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role__permissions`
--

INSERT INTO `role__permissions` (`id`, `role_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, NULL, NULL),
(2, 1, 1, NULL, NULL),
(3, 1, 3, NULL, NULL),
(4, 1, 5, NULL, NULL),
(5, 1, 4, NULL, NULL),
(6, 1, 6, NULL, NULL),
(7, 1, 7, NULL, NULL),
(8, 1, 8, NULL, NULL),
(9, 1, 9, NULL, NULL),
(10, 1, 10, NULL, NULL),
(11, 1, 11, NULL, NULL),
(12, 1, 12, NULL, NULL),
(13, 1, 13, NULL, NULL),
(14, 1, 14, NULL, NULL),
(15, 1, 15, NULL, NULL),
(16, 1, 16, NULL, NULL),
(17, 1, 17, NULL, NULL),
(18, 1, 18, NULL, NULL),
(19, 1, 19, NULL, NULL),
(20, 1, 20, NULL, NULL),
(21, 1, 21, NULL, NULL),
(22, 1, 22, NULL, NULL),
(23, 1, 23, NULL, NULL),
(24, 1, 24, NULL, NULL),
(25, 1, 25, NULL, NULL),
(26, 1, 26, NULL, NULL),
(27, 1, 27, NULL, NULL),
(28, 1, 28, NULL, NULL),
(29, 1, 29, NULL, NULL),
(30, 1, 30, NULL, NULL),
(31, 1, 31, NULL, NULL),
(32, 1, 32, NULL, NULL),
(33, 1, 33, NULL, NULL),
(34, 1, 34, NULL, NULL),
(35, 1, 35, NULL, NULL),
(36, 1, 36, NULL, NULL),
(37, 1, 37, NULL, NULL),
(38, 1, 38, NULL, NULL),
(39, 1, 39, NULL, NULL),
(40, 1, 40, NULL, NULL),
(41, 1, 41, NULL, NULL),
(42, 1, 42, NULL, NULL),
(43, 1, 43, NULL, NULL),
(44, 1, 44, NULL, NULL),
(45, 1, 45, NULL, NULL),
(46, 1, 46, NULL, NULL),
(47, 1, 47, NULL, NULL),
(48, 1, 48, NULL, NULL),
(49, 1, 49, NULL, NULL),
(50, 1, 50, NULL, NULL),
(51, 1, 51, NULL, NULL),
(52, 1, 52, NULL, NULL),
(53, 1, 53, NULL, NULL),
(54, 1, 54, NULL, NULL),
(55, 1, 55, NULL, NULL),
(56, 1, 56, NULL, NULL),
(57, 1, 57, NULL, NULL),
(58, 1, 58, NULL, NULL),
(59, 1, 59, NULL, NULL),
(60, 1, 60, NULL, NULL),
(61, 1, 61, NULL, NULL),
(62, 1, 62, NULL, NULL),
(63, 1, 63, NULL, NULL),
(64, 1, 64, NULL, NULL),
(65, 1, 65, NULL, NULL),
(66, 1, 66, NULL, NULL),
(67, 1, 67, NULL, NULL),
(68, 1, 68, NULL, NULL),
(69, 1, 69, NULL, NULL),
(70, 1, 70, NULL, NULL),
(71, 1, 71, NULL, NULL),
(72, 1, 72, NULL, NULL),
(73, 1, 73, NULL, NULL),
(74, 1, 74, NULL, NULL),
(75, 1, 75, NULL, NULL),
(76, 1, 76, NULL, NULL),
(78, 3, 45, NULL, NULL),
(79, 3, 46, NULL, NULL),
(80, 3, 49, NULL, NULL),
(82, 2, 74, NULL, NULL),
(84, 1, 78, NULL, NULL),
(85, 3, 47, NULL, NULL),
(86, 3, 48, NULL, NULL),
(87, 1, 79, NULL, NULL),
(88, 1, 80, NULL, NULL),
(89, 1, 81, NULL, NULL),
(90, 1, 82, NULL, NULL),
(91, 1, 83, NULL, NULL),
(92, 2, 30, NULL, NULL),
(93, 2, 31, NULL, NULL),
(94, 2, 32, NULL, NULL),
(95, 2, 33, NULL, NULL),
(96, 2, 52, NULL, NULL),
(97, 2, 53, NULL, NULL),
(98, 2, 54, NULL, NULL),
(99, 2, 55, NULL, NULL),
(100, 2, 56, NULL, NULL),
(101, 2, 57, NULL, NULL),
(102, 2, 59, NULL, NULL),
(103, 2, 60, NULL, NULL),
(104, 2, 45, NULL, NULL),
(105, 2, 46, NULL, NULL),
(106, 2, 61, NULL, NULL),
(107, 2, 62, NULL, NULL),
(108, 2, 68, NULL, NULL),
(109, 2, 69, NULL, NULL),
(110, 1, 84, NULL, NULL),
(111, 1, 85, NULL, NULL),
(112, 1, 86, NULL, NULL),
(113, 1, 87, NULL, NULL),
(114, 1, 88, NULL, NULL),
(115, 1, 89, NULL, NULL),
(116, 1, 90, NULL, NULL),
(117, 1, 91, NULL, NULL),
(118, 1, 92, NULL, NULL),
(119, 1, 93, NULL, NULL),
(120, 1, 94, NULL, NULL),
(121, 1, 95, NULL, NULL),
(122, 1, 96, NULL, NULL),
(123, 1, 99, NULL, NULL),
(124, 1, 100, NULL, NULL),
(137, 1, 102, NULL, NULL),
(138, 1, 103, NULL, NULL),
(139, 1, 104, NULL, NULL),
(140, 1, 105, NULL, NULL),
(141, 1, 106, NULL, NULL),
(142, 1, 107, NULL, NULL),
(143, 1, 108, NULL, NULL),
(144, 2, 101, NULL, NULL),
(145, 2, 103, NULL, NULL),
(146, 1, 101, NULL, NULL),
(147, 2, 50, NULL, NULL),
(148, 2, 51, NULL, NULL),
(149, 1, 110, NULL, NULL),
(155, 1, 113, NULL, NULL),
(157, 1, 115, NULL, NULL),
(158, 1, 116, NULL, NULL),
(159, 1, 117, NULL, NULL),
(160, 1, 118, NULL, NULL),
(161, 1, 119, NULL, NULL),
(162, 1, 120, NULL, NULL),
(163, 1, 128, NULL, NULL),
(164, 1, 129, NULL, NULL),
(165, 1, 130, NULL, NULL),
(166, 1, 131, NULL, NULL),
(168, 1, 133, NULL, NULL),
(169, 1, 134, NULL, NULL),
(170, 1, 135, NULL, NULL),
(171, 1, 136, NULL, NULL),
(172, 1, 137, NULL, NULL),
(173, 1, 138, NULL, NULL),
(174, 1, 139, NULL, NULL),
(175, 1, 148, NULL, NULL),
(176, 1, 149, NULL, NULL),
(177, 1, 150, NULL, NULL),
(178, 1, 151, NULL, NULL),
(180, 1, 141, NULL, NULL),
(181, 1, 142, NULL, NULL),
(182, 1, 143, NULL, NULL),
(184, 1, 145, NULL, NULL),
(185, 1, 146, NULL, NULL),
(186, 1, 147, NULL, NULL),
(188, 1, 157, NULL, NULL),
(189, 1, 158, NULL, NULL),
(190, 1, 159, NULL, NULL),
(191, 1, 152, NULL, NULL),
(192, 1, 153, NULL, NULL),
(193, 1, 154, NULL, NULL),
(194, 1, 155, NULL, NULL),
(195, 1, 160, NULL, NULL),
(196, 1, 161, NULL, NULL),
(197, 1, 165, NULL, NULL),
(198, 1, 166, NULL, NULL),
(199, 1, 167, NULL, NULL),
(200, 1, 168, NULL, NULL),
(201, 1, 169, NULL, NULL),
(202, 1, 170, NULL, NULL),
(203, 1, 171, NULL, NULL),
(204, 1, 172, NULL, NULL),
(205, 1, 173, NULL, NULL),
(206, 1, 174, NULL, NULL),
(207, 1, 175, NULL, NULL),
(208, 1, 176, NULL, NULL),
(209, 1, 177, NULL, NULL),
(210, 1, 178, NULL, NULL),
(211, 1, 179, NULL, NULL),
(212, 1, 162, NULL, NULL),
(213, 1, 163, NULL, NULL),
(214, 1, 164, NULL, NULL),
(215, 1, 180, NULL, NULL),
(216, 1, 181, NULL, NULL),
(217, 1, 182, NULL, NULL),
(218, 1, 183, NULL, NULL),
(219, 1, 184, NULL, NULL),
(220, 1, 185, NULL, NULL),
(221, 1, 186, NULL, NULL),
(222, 1, 192, NULL, NULL),
(223, 1, 193, NULL, NULL),
(224, 1, 194, NULL, NULL),
(225, 1, 195, NULL, NULL),
(226, 1, 200, NULL, NULL),
(227, 1, 188, NULL, NULL),
(228, 1, 189, NULL, NULL),
(229, 1, 190, NULL, NULL),
(230, 1, 191, NULL, NULL),
(231, 1, 196, NULL, NULL),
(232, 1, 197, NULL, NULL),
(233, 1, 198, NULL, NULL),
(234, 1, 199, NULL, NULL),
(235, 1, 187, NULL, NULL),
(236, 1, 201, NULL, NULL),
(237, 1, 202, NULL, NULL),
(240, 1, 72, NULL, NULL),
(241, 1, 203, NULL, NULL),
(242, 1, 205, NULL, NULL),
(243, 1, 204, NULL, NULL),
(244, 1, 140, NULL, NULL),
(245, 1, 144, NULL, NULL),
(246, 1, 79, NULL, NULL),
(247, 1, 156, NULL, NULL),
(248, 1, 114, NULL, NULL),
(249, 1, 132, NULL, NULL),
(250, 1, 111, NULL, NULL),
(251, 1, 112, NULL, NULL),
(252, 1, 207, NULL, NULL),
(253, 1, 206, NULL, NULL),
(254, 1, 209, NULL, NULL),
(255, 1, 210, NULL, NULL),
(256, 1, 211, NULL, NULL),
(257, 1, 212, NULL, NULL),
(258, 3, 181, NULL, NULL),
(259, 3, 186, NULL, NULL),
(260, 3, 202, NULL, NULL),
(261, 3, 203, NULL, NULL),
(262, 3, 184, NULL, NULL),
(263, 1, 208, NULL, NULL),
(264, 3, 156, NULL, NULL),
(265, 3, 157, NULL, NULL),
(266, 3, 160, NULL, NULL),
(267, 3, 201, NULL, NULL),
(268, 1, 213, NULL, NULL),
(269, 1, 215, NULL, NULL),
(270, 1, 216, NULL, NULL),
(271, 1, 214, NULL, NULL),
(272, 1, 217, NULL, NULL),
(277, 5, 52, NULL, NULL),
(278, 5, 53, NULL, NULL),
(279, 5, 54, NULL, NULL),
(280, 5, 55, NULL, NULL),
(281, 5, 56, NULL, NULL),
(282, 5, 57, NULL, NULL),
(283, 5, 58, NULL, NULL),
(284, 5, 59, NULL, NULL),
(285, 5, 60, NULL, NULL),
(288, 5, 187, NULL, NULL),
(289, 5, 176, NULL, NULL),
(290, 5, 177, NULL, NULL),
(291, 5, 178, NULL, NULL),
(292, 5, 179, NULL, NULL),
(293, 5, 181, NULL, NULL),
(294, 5, 182, NULL, NULL),
(295, 5, 184, NULL, NULL),
(296, 5, 185, NULL, NULL),
(297, 5, 186, NULL, NULL),
(298, 5, 202, NULL, NULL),
(299, 5, 203, NULL, NULL),
(300, 1, 218, NULL, NULL),
(301, 1, 219, NULL, NULL),
(302, 1, 220, NULL, NULL),
(303, 1, 221, NULL, NULL),
(304, 6, 52, NULL, NULL),
(305, 6, 222, NULL, NULL),
(306, 1, 223, NULL, NULL),
(307, 6, 223, NULL, NULL),
(308, 1, 224, NULL, NULL),
(309, 1, 225, NULL, NULL),
(313, 1, 226, NULL, NULL),
(314, 1, 227, NULL, NULL),
(315, 1, 228, NULL, NULL),
(317, 2, 230, NULL, NULL),
(318, 2, 231, NULL, NULL),
(319, 2, 232, NULL, NULL),
(321, 1, 230, NULL, NULL),
(322, 1, 231, NULL, NULL),
(323, 1, 232, NULL, NULL),
(324, 1, 229, NULL, NULL),
(325, 2, 229, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sales_commissions`
--

CREATE TABLE `sales_commissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `salesperson_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales_commissions`
--

INSERT INTO `sales_commissions` (`id`, `salesperson_id`, `order_id`, `product_id`, `amount`, `created_at`, `updated_at`) VALUES
(1, 4, 25, 58, 7.27, '2024-06-17 17:02:06', '2024-06-17 17:02:06'),
(3, 4, 30, 58, 36.35, '2024-06-18 12:30:12', '2024-06-18 12:30:12');

-- --------------------------------------------------------

--
-- Table structure for table `sales_main_commissions`
--

CREATE TABLE `sales_main_commissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `commission_amount` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales_main_commissions`
--

INSERT INTO `sales_main_commissions` (`id`, `commission_amount`, `created_at`, `updated_at`) VALUES
(2, '10', '2024-06-18 12:18:37', '2024-06-18 12:18:37');

-- --------------------------------------------------------

--
-- Table structure for table `sales_users`
--

CREATE TABLE `sales_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `referral_token` longtext DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales_users`
--

INSERT INTO `sales_users` (`id`, `name`, `image`, `phone`, `address`, `referral_token`, `email`, `email_verified_at`, `password`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(4, 'Myra Norris', 'photos/8aMnlrXPHAnNPrwlmW2VabUYzsJS5sFL1kj0JN3N.jpg', '+1 (104) 922-9085', 'Tenetur culpa quia ', 'tGDGEaoStRQhyOqKz6ye6EQUcwJQxwFkuQsXnWJ2', 'hamiqedum@mailinator.com', NULL, '$2y$12$/5pimWkqom3cKqjgEiDb4.JjzeNsIxzdJMIor6xKESjW67D6BCSP.', '1', NULL, '2024-06-15 16:01:06', '2024-06-18 11:27:14'),
(6, 'Ignatius Landry', '', '+1 (527) 131-725', 'Et sequi reprehender', 'gEkN9hMGXqZ5hXy5tnAJddBByRHW4uS3zdD0L7JD', 'lyhojo@mailinator.com', NULL, '$2y$12$CfZSasZhaT/Z1iHAZPGMJuPt9xeUfqy1ydFShVvUtEj916xFwOLIe', '1', NULL, '2024-06-15 16:07:44', '2024-06-18 11:27:15');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` text NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('TQp9122KEJ1RYThxHgwYcE1K3GA0PoNG7krsCssD', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'YToxMzp7czo2OiJfdG9rZW4iO3M6NDA6InpCYWZyNGpGR3FIdjRISlc5Q2F5N29IMTJpY1RiMG1oMVlFYjlqdTAiO3M6Mjg6InN5c3RlbV9kZWZhdWx0X2N1cnJlbmN5X2luZm8iO086MjE6IkFwcFxNb2RlbHNcQ3VycmVuY2llcyI6MzA6e3M6MTM6IgAqAGNvbm5lY3Rpb24iO3M6NToibXlzcWwiO3M6ODoiACoAdGFibGUiO3M6MTA6ImN1cnJlbmNpZXMiO3M6MTM6IgAqAHByaW1hcnlLZXkiO3M6MjoiaWQiO3M6MTA6IgAqAGtleVR5cGUiO3M6MzoiaW50IjtzOjEyOiJpbmNyZW1lbnRpbmciO2I6MTtzOjc6IgAqAHdpdGgiO2E6MDp7fXM6MTI6IgAqAHdpdGhDb3VudCI7YTowOnt9czoxOToicHJldmVudHNMYXp5TG9hZGluZyI7YjowO3M6MTA6IgAqAHBlclBhZ2UiO2k6MTU7czo2OiJleGlzdHMiO2I6MTtzOjE4OiJ3YXNSZWNlbnRseUNyZWF0ZWQiO2I6MDtzOjI4OiIAKgBlc2NhcGVXaGVuQ2FzdGluZ1RvU3RyaW5nIjtiOjA7czoxMzoiACoAYXR0cmlidXRlcyI7YTo3OntzOjI6ImlkIjtpOjE7czo0OiJuYW1lIjtzOjQ6IkJpcnIiO3M6Njoic3ltYm9sIjtzOjQ6IkJJUlIiO3M6MTM6ImV4Y2hhbmdlX3JhdGUiO2Q6MTtzOjQ6ImNvZGUiO3M6MzoiRVRCIjtzOjEwOiJjcmVhdGVkX2F0IjtzOjE5OiIyMDI0LTAxLTIxIDAyOjExOjA2IjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjE5OiIyMDI0LTAyLTAxIDA1OjMxOjExIjt9czoxMToiACoAb3JpZ2luYWwiO2E6Nzp7czoyOiJpZCI7aToxO3M6NDoibmFtZSI7czo0OiJCaXJyIjtzOjY6InN5bWJvbCI7czo0OiJCSVJSIjtzOjEzOiJleGNoYW5nZV9yYXRlIjtkOjE7czo0OiJjb2RlIjtzOjM6IkVUQiI7czoxMDoiY3JlYXRlZF9hdCI7czoxOToiMjAyNC0wMS0yMSAwMjoxMTowNiI7czoxMDoidXBkYXRlZF9hdCI7czoxOToiMjAyNC0wMi0wMSAwNTozMToxMSI7fXM6MTA6IgAqAGNoYW5nZXMiO2E6MDp7fXM6ODoiACoAY2FzdHMiO2E6MDp7fXM6MTc6IgAqAGNsYXNzQ2FzdENhY2hlIjthOjA6e31zOjIxOiIAKgBhdHRyaWJ1dGVDYXN0Q2FjaGUiO2E6MDp7fXM6ODoiACoAZGF0ZXMiO2E6MDp7fXM6MTM6IgAqAGRhdGVGb3JtYXQiO047czoxMDoiACoAYXBwZW5kcyI7YTowOnt9czoxOToiACoAZGlzcGF0Y2hlc0V2ZW50cyI7YTowOnt9czoxNDoiACoAb2JzZXJ2YWJsZXMiO2E6MDp7fXM6MTI6IgAqAHJlbGF0aW9ucyI7YTowOnt9czoxMDoiACoAdG91Y2hlcyI7YTowOnt9czoxMDoidGltZXN0YW1wcyI7YjoxO3M6OToiACoAaGlkZGVuIjthOjA6e31zOjEwOiIAKgB2aXNpYmxlIjthOjA6e31zOjExOiIAKgBmaWxsYWJsZSI7YTo0OntpOjA7czo0OiJuYW1lIjtpOjE7czo2OiJzeW1ib2wiO2k6MjtzOjEzOiJleGNoYW5nZV9yYXRlIjtpOjM7czo0OiJjb2RlIjt9czoxMDoiACoAZ3VhcmRlZCI7YToxOntpOjA7czoxOiIqIjt9fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM4OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvdHJhY2steW91ci1vcmRlciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC93aXNobGlzdCI7fXM6NToiYWxlcnQiO2E6MDp7fXM6NTI6ImxvZ2luX2FkbWluXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NDtzOjEwOiJzZXNzaW9uX2lkIjtzOjMyOiI2YWUwNzcyZTM1NDY3MzJkZjIzY2RlZDRjYTVhZDM5OCI7czoxMzoiY3VycmVuY3lfY29kZSI7czozOiJFVEIiO3M6MTU6ImN1cnJlbmN5X3N5bWJvbCI7czo0OiJCSVJSIjtzOjIyOiJjdXJyZW5jeV9leGNoYW5nZV9yYXRlIjtkOjE7czo0OiJwYWdlIjtzOjY6Im9yZGVycyI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NDt9', 1716533544),
('rwODejeU4yeywNUiQEXRJoHn7cJbGprgCwwbIwdn', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaEtPZzFHcVQyOTZwdHQ5c1NhQ0hiZTJ5dlRQZGlhZ1VhTmdKcXZwMCI7czoyODoic3lzdGVtX2RlZmF1bHRfY3VycmVuY3lfaW5mbyI7TzoyMToiQXBwXE1vZGVsc1xDdXJyZW5jaWVzIjozMDp7czoxMzoiACoAY29ubmVjdGlvbiI7czo1OiJteXNxbCI7czo4OiIAKgB0YWJsZSI7czoxMDoiY3VycmVuY2llcyI7czoxMzoiACoAcHJpbWFyeUtleSI7czoyOiJpZCI7czoxMDoiACoAa2V5VHlwZSI7czozOiJpbnQiO3M6MTI6ImluY3JlbWVudGluZyI7YjoxO3M6NzoiACoAd2l0aCI7YTowOnt9czoxMjoiACoAd2l0aENvdW50IjthOjA6e31zOjE5OiJwcmV2ZW50c0xhenlMb2FkaW5nIjtiOjA7czoxMDoiACoAcGVyUGFnZSI7aToxNTtzOjY6ImV4aXN0cyI7YjoxO3M6MTg6Indhc1JlY2VudGx5Q3JlYXRlZCI7YjowO3M6Mjg6IgAqAGVzY2FwZVdoZW5DYXN0aW5nVG9TdHJpbmciO2I6MDtzOjEzOiIAKgBhdHRyaWJ1dGVzIjthOjc6e3M6MjoiaWQiO2k6MTtzOjQ6Im5hbWUiO3M6NDoiQmlyciI7czo2OiJzeW1ib2wiO3M6NDoiQklSUiI7czoxMzoiZXhjaGFuZ2VfcmF0ZSI7ZDoxO3M6NDoiY29kZSI7czozOiJFVEIiO3M6MTA6ImNyZWF0ZWRfYXQiO3M6MTk6IjIwMjQtMDEtMjEgMDI6MTE6MDYiO3M6MTA6InVwZGF0ZWRfYXQiO3M6MTk6IjIwMjQtMDItMDEgMDU6MzE6MTEiO31zOjExOiIAKgBvcmlnaW5hbCI7YTo3OntzOjI6ImlkIjtpOjE7czo0OiJuYW1lIjtzOjQ6IkJpcnIiO3M6Njoic3ltYm9sIjtzOjQ6IkJJUlIiO3M6MTM6ImV4Y2hhbmdlX3JhdGUiO2Q6MTtzOjQ6ImNvZGUiO3M6MzoiRVRCIjtzOjEwOiJjcmVhdGVkX2F0IjtzOjE5OiIyMDI0LTAxLTIxIDAyOjExOjA2IjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjE5OiIyMDI0LTAyLTAxIDA1OjMxOjExIjt9czoxMDoiACoAY2hhbmdlcyI7YTowOnt9czo4OiIAKgBjYXN0cyI7YTowOnt9czoxNzoiACoAY2xhc3NDYXN0Q2FjaGUiO2E6MDp7fXM6MjE6IgAqAGF0dHJpYnV0ZUNhc3RDYWNoZSI7YTowOnt9czo4OiIAKgBkYXRlcyI7YTowOnt9czoxMzoiACoAZGF0ZUZvcm1hdCI7TjtzOjEwOiIAKgBhcHBlbmRzIjthOjA6e31zOjE5OiIAKgBkaXNwYXRjaGVzRXZlbnRzIjthOjA6e31zOjE0OiIAKgBvYnNlcnZhYmxlcyI7YTowOnt9czoxMjoiACoAcmVsYXRpb25zIjthOjA6e31zOjEwOiIAKgB0b3VjaGVzIjthOjA6e31zOjEwOiJ0aW1lc3RhbXBzIjtiOjE7czo5OiIAKgBoaWRkZW4iO2E6MDp7fXM6MTA6IgAqAHZpc2libGUiO2E6MDp7fXM6MTE6IgAqAGZpbGxhYmxlIjthOjQ6e2k6MDtzOjQ6Im5hbWUiO2k6MTtzOjY6InN5bWJvbCI7aToyO3M6MTM6ImV4Y2hhbmdlX3JhdGUiO2k6MztzOjQ6ImNvZGUiO31zOjEwOiIAKgBndWFyZGVkIjthOjE6e2k6MDtzOjE6IioiO319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1718123067);

-- --------------------------------------------------------

--
-- Table structure for table `shipping_charges`
--

CREATE TABLE `shipping_charges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `city` varchar(255) NOT NULL,
  `0_500g` double(8,2) NOT NULL,
  `501_1000g` double(8,2) NOT NULL,
  `1001_2000g` double(8,2) NOT NULL,
  `2001_5000g` double(8,2) NOT NULL,
  `above_5000g` double(8,2) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipping_charges`
--

INSERT INTO `shipping_charges` (`id`, `city`, `0_500g`, `501_1000g`, `1001_2000g`, `2001_5000g`, `above_5000g`, `status`, `created_at`, `updated_at`) VALUES
(1, 'harar', 2.00, 4.00, 8.00, 10.00, 12.00, 1, NULL, '2023-07-22 00:02:36'),
(2, 'Oromia', 8.00, 0.00, 0.00, 0.00, 0.00, 1, '2023-04-26 12:00:00', '2023-07-22 00:52:01'),
(3, 'Adama', 1.00, 1.00, 1.00, 10.00, 10.00, 1, '2023-04-26 12:00:00', '2023-04-28 12:00:00'),
(4, 'Amahra', 2.00, 4.00, 8.00, 16.00, 32.00, 1, '2023-04-26 12:00:00', '2023-07-22 00:52:12'),
(5, 'Afar', 0.00, 0.00, 0.00, 0.00, 0.00, 1, '2023-04-26 12:00:00', '2023-07-22 00:55:52'),
(247, 'Tigray', 15.00, 78.00, 73.00, 61.00, 15.00, 1, '2023-07-22 01:37:16', '2023-07-22 01:38:13'),
(248, 'Addis Ababa', 1.00, 2.00, 5.00, 9.00, 20.00, 1, '2023-12-18 17:07:10', '2023-12-18 17:07:16'),
(249, 'Gondar', 6.00, 8.00, 8.00, 9.00, 10.00, 1, '2023-12-18 17:07:49', '2023-12-18 17:10:13'),
(250, 'Jijiga', -1.00, 2.00, 3.00, 8.00, 2.00, 1, '2023-12-18 17:08:09', '2023-12-18 17:10:26'),
(251, 'Bahir Dar', 78.00, 62.00, 18.00, 73.00, 57.00, 1, '2023-12-18 17:08:24', '2023-12-18 17:10:22'),
(252, 'Desse', 70.00, 28.00, 71.00, 6.00, 11.00, 1, '2023-12-18 17:08:41', '2023-12-18 17:10:36'),
(253, 'Hawassa', 18.00, 32.00, 46.00, 35.00, 88.00, 1, '2023-12-18 17:08:54', '2023-12-18 17:10:31'),
(254, 'Mekele', 62.00, 36.00, 82.00, 23.00, 15.00, 1, '2023-12-18 17:09:10', '2023-12-18 17:10:39'),
(255, 'Jimma', 14.00, 6.00, 98.00, 73.00, 89.00, 1, '2023-12-18 17:09:21', '2023-12-18 17:10:45'),
(256, 'Jijiga', 22.00, 100.00, 71.00, 31.00, 49.00, 1, '2023-12-18 17:09:38', '2023-12-18 17:10:49'),
(257, 'Kombolcha', 27.00, 10.00, 72.00, 69.00, 24.00, 1, '2023-12-18 17:09:51', '2023-12-18 17:10:17');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_methods`
--

CREATE TABLE `shipping_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `base_cost` decimal(10,2) NOT NULL,
  `per_kg_rate` decimal(10,2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipping_methods`
--

INSERT INTO `shipping_methods` (`id`, `name`, `description`, `base_cost`, `per_kg_rate`, `status`, `created_at`, `updated_at`) VALUES
(6, 'Express Shipping', 'Delivers in 2-3 business days', 15.00, 1.00, 1, '2024-06-05 11:00:45', '2024-06-09 12:00:10'),
(7, 'Anthony Owens', 'Perspiciatis consec', 68.00, 49.00, 1, '2024-06-05 11:00:45', '2024-06-09 11:56:36'),
(8, 'International Economy', 'Delivers in 10-14 business days', 20.00, 5.00, 1, '2024-06-05 11:00:45', '2024-06-05 11:02:32'),
(11, 'Courier Service', 'Same-day delivery within city', 30.00, 3.00, 1, '2024-06-05 11:00:45', '2024-06-05 11:02:34'),
(12, 'Drone Delivery', 'Fast and secure delivery by drone', 40.00, 5.00, 1, '2024-06-05 11:00:45', '2024-06-05 11:02:35'),
(27, 'Britanney Bell', 'Et et cumque volupta', 16.00, 99.00, 1, '2024-06-05 15:52:56', '2024-06-05 15:53:41'),
(29, 'Amir Morse', 'Quo officia veniam ', 59.00, 33.00, 1, '2024-06-09 11:56:42', '2024-06-09 12:00:08'),
(30, 'Rachel Herrera', 'Mollit voluptatem I', 68.00, 22.00, 1, '2024-06-09 11:57:55', '2024-06-09 11:57:58');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_method_prices`
--

CREATE TABLE `shipping_method_prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shipping_method_id` bigint(20) UNSIGNED NOT NULL,
  `zone_id` bigint(20) UNSIGNED NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipping_method_prices`
--

INSERT INTO `shipping_method_prices` (`id`, `shipping_method_id`, `zone_id`, `price`, `created_at`, `updated_at`) VALUES
(39, 6, 1, 99.00, '2024-06-05 16:06:25', '2024-06-05 16:06:25'),
(40, 6, 2, 99.00, '2024-06-05 16:06:25', '2024-06-05 16:06:25'),
(43, 29, 7, 51.00, '2024-06-09 11:56:42', '2024-06-09 11:56:42'),
(44, 30, 2, 13.00, '2024-06-09 11:57:55', '2024-06-09 11:57:55'),
(45, 30, 5, 74.00, '2024-06-09 11:57:55', '2024-06-09 11:57:55'),
(46, 30, 7, 15.00, '2024-06-09 11:57:55', '2024-06-09 11:57:55');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_method_zone`
--

CREATE TABLE `shipping_method_zone` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shipping_method_id` bigint(20) UNSIGNED NOT NULL,
  `shipping_zone_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipping_method_zone`
--

INSERT INTO `shipping_method_zone` (`id`, `shipping_method_id`, `shipping_zone_id`, `created_at`, `updated_at`) VALUES
(27, 6, 1, NULL, NULL),
(28, 6, 2, NULL, NULL),
(31, 29, 7, NULL, NULL),
(32, 30, 2, NULL, NULL),
(33, 30, 5, NULL, NULL),
(34, 30, 7, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shipping_zones`
--

CREATE TABLE `shipping_zones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `regions` text NOT NULL,
  `status` varchar(2) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipping_zones`
--

INSERT INTO `shipping_zones` (`id`, `name`, `regions`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Arada', '2', '1', '2024-06-04 15:41:32', '2024-06-04 15:46:54'),
(2, '04', '1', '1', '2024-06-04 15:42:12', '2024-06-04 15:48:11'),
(5, 'vendor', '8', '1', '2024-06-04 15:48:23', '2024-06-04 15:48:25'),
(6, 'Yared', '1', '1', '2024-06-04 15:51:07', '2024-06-04 15:51:08'),
(7, 'pissa', '2', '1', '2024-06-05 13:56:28', '2024-06-05 15:06:17');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Oromia', '1', '2023-11-25 23:01:18', '2023-11-25 23:01:18'),
(2, 'Amahra', '1', '2023-11-25 23:01:28', '2023-11-25 23:01:28'),
(3, 'Tigray', '1', '2023-11-25 23:01:36', '2023-11-25 23:01:36'),
(4, 'Somail', '1', '2023-11-25 23:02:55', '2023-11-25 23:02:55'),
(5, 'Afar', '1', '2023-11-25 23:03:03', '2023-11-25 23:05:00'),
(6, 'Gambela', '1', '2023-11-25 23:03:16', '2023-11-25 23:12:20'),
(7, 'Dire Dawa', '1', '2023-11-25 23:03:25', '2023-11-25 23:03:25'),
(8, 'Harari', '1', '2023-11-25 23:03:34', '2023-11-25 23:05:04'),
(9, 'Sidama', '1', '2023-11-25 23:03:44', '2023-11-25 23:05:23'),
(10, 'Benishangul-Gumuz', '1', '2023-11-25 23:03:59', '2023-11-25 23:03:59');

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE `taxes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `taxname` varchar(255) NOT NULL,
  `percentage` decimal(5,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `taxes`
--

INSERT INTO `taxes` (`id`, `taxname`, `percentage`, `status`, `created_at`, `updated_at`) VALUES
(2, 'TOT', 2.00, 1, '2024-06-20 15:38:36', '2024-06-21 13:54:01'),
(4, 'TAX', 15.00, 1, '2024-06-20 15:56:31', '2024-06-20 16:13:17');

-- --------------------------------------------------------

--
-- Table structure for table `transfer_requests`
--

CREATE TABLE `transfer_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from_warehouse_id` bigint(20) UNSIGNED NOT NULL,
  `to_warehouse_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `price` double(8,2) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `notes` text DEFAULT NULL,
  `transfer_date` date NOT NULL,
  `assign_to_deliveryman` varchar(20) NOT NULL DEFAULT '0',
  `delivery_status` varchar(255) DEFAULT NULL,
  `is_final_destination` varchar(255) NOT NULL DEFAULT 'no',
  `shipped_confirmation_number` varchar(20) DEFAULT NULL,
  `delivered_confirmation_number` varchar(20) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transfer_stock_products`
--

CREATE TABLE `transfer_stock_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from_warehouse_id` bigint(20) UNSIGNED NOT NULL,
  `to_warehouse_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `price` double(8,2) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `notes` text DEFAULT NULL,
  `transfer_date` date NOT NULL,
  `assign_to_deliveryman` varchar(20) NOT NULL DEFAULT '0',
  `delivery_status` varchar(255) DEFAULT NULL,
  `is_final_destination` varchar(255) NOT NULL DEFAULT 'no',
  `shipped_confirmation_number` varchar(20) DEFAULT NULL,
  `delivered_confirmation_number` varchar(20) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `provider_id` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `pincode` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `latitude` longtext DEFAULT NULL,
  `longitude` longtext DEFAULT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `provider_id`, `name`, `address`, `city`, `state`, `country`, `pincode`, `mobile`, `email`, `email_verified_at`, `password`, `status`, `latitude`, `longitude`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
(1, NULL, 'customer', 'Adamaa', 'Adama', 'Oromia', 'Ethiopia', '1000', '0912651113', 'customer@gmail.com', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-06 14:45:01', '2024-06-19 16:04:50'),
(4, NULL, 'yared', '14, adama', 'Kombolcha', 'Oromia', 'Ethiopia', '1009', '0912655555', 'yared@gmail.com', NULL, '$2y$10$i58WGSLneIF/4aoqsUakBOHvQwmEkYLJCPLzawZ5wRCToAPqAPmc.', 1, '8.992358', '38.779112', NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-06 14:45:01', '2024-06-12 20:24:04'),
(5, NULL, 'Ella Mccarty', 'Placeat enim omnis', 'Bahir Dar', 'Oromia', 'Ethiopia', 'VELIT QUI MAGNAM AT', '0912651454', 'tehepa@mailinator.com', NULL, '$2y$10$ouM1iyU7afBKrI4flTFICOKO7z/Wek4LnfudaOtA3jdJbsX8lS.0K', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-13 10:51:32', '2024-06-12 20:23:55'),
(6, NULL, 'Reese Joseph', 'Sequi repudiandae si', 'Desse', 'Afar', 'Ethiopia', 'Ad aute voluptatem q', '0912651166', 'lylosy@mailinator.com', NULL, '$2y$10$rNINT5Z0t.H55FPtuWivyOUlZd.6Mi/JrhmNYWfFUZaGBdQ4hq6kK', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-13 10:51:32', '2024-06-12 20:23:06'),
(7, NULL, 'hello', NULL, NULL, NULL, NULL, NULL, NULL, 'hello@gmail.com', NULL, '$2y$12$5y7jwpKXUQ0b6D0l4vwG/u3f0HlyHLcOhCnho.ce/DCFKJxIy85m.', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-13 10:51:32', '2024-06-13 10:51:32'),
(8, NULL, 'Jin Booth', NULL, NULL, NULL, NULL, NULL, NULL, 'were@mailinator.com', NULL, '$2y$12$mYaLMXjSywIi0LzSxYZfROXWPQSS9vpiq2/ap9Ybl57ANVybZSyNK', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-13 10:52:02', '2024-06-13 10:52:02');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle__types`
--

CREATE TABLE `vehicle__types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicle__types`
--

INSERT INTO `vehicle__types` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'car', '1\r\n', NULL, NULL),
(2, 'trucker', '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `pincode` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `confirm` enum('Yes','No') NOT NULL DEFAULT 'No',
  `commission` float DEFAULT 0,
  `status` tinyint(4) DEFAULT NULL,
  `latitude` longtext DEFAULT NULL,
  `longitude` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`id`, `name`, `address`, `city`, `state`, `country`, `pincode`, `mobile`, `email`, `confirm`, `commission`, `status`, `latitude`, `longitude`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'adama', 'adama', 'oromia', 'ethiopia', '444', '0912651113', 'admin@gmail.com', 'Yes', NULL, 1, '8.994102', '38.774638', '2024-05-29 00:19:16', NULL),
(2, 'vendor', ' street,05', 'Adama', 'Oromia', 'Ethiopia', '1101', '0912651110', 'vendor@gmail.com', 'Yes', 2, 1, NULL, NULL, '2024-05-29 00:19:16', '2024-02-03 02:27:38'),
(58, 'Vendor 3', 'Address 3', 'City 3', 'State 3', 'Country 3', '34567', '3456789012', 'vendor3@email.com', '', 12.5, 1, NULL, NULL, '2024-05-29 00:19:16', NULL),
(59, 'Vendor 4', 'Address 4', 'City 4', 'State 4', 'Country 4', '45678', '4567890123', 'vendor4@email.com', '', 13.5, 1, NULL, NULL, '2024-05-29 00:19:16', NULL),
(60, 'Vendor 5', 'Address 5', 'City 5', 'State 5', 'Country 5', '56789', '5678901234', 'vendor5@email.com', '', 14.5, 1, NULL, NULL, '2024-05-29 00:19:16', NULL),
(61, 'Vendor 6', 'Address 6', 'City 6', 'State 6', 'Country 6', '67890', '6789012345', 'vendor6@email.com', '', 15.5, 1, NULL, NULL, '2024-06-21 20:13:06', NULL),
(62, 'Vendor 7', 'Address 7', 'City 7', 'State 7', 'Country 7', '78901', '7890123456', 'vendor7@email.com', '', 16.5, 1, NULL, NULL, '2024-05-29 00:19:16', NULL),
(63, 'Vendor 8', 'Address 8', 'City 8', 'State 8', 'Country 8', '89012', '8901234567', 'vendor8@email.com', '', 17.5, 1, NULL, NULL, '2024-05-21 20:13:06', NULL),
(64, 'Abel Boyer', NULL, NULL, NULL, NULL, NULL, '0914651113', 'yaredayele67@gmail.com', 'No', 0, 1, NULL, NULL, '2024-06-21 20:13:06', '2024-06-10 18:41:52');

-- --------------------------------------------------------

--
-- Table structure for table `vendors_bank_details`
--

CREATE TABLE `vendors_bank_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `account_holder_name` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendors_bank_details`
--

INSERT INTO `vendors_bank_details` (`id`, `vendor_id`, `account_holder_name`, `bank_name`, `account_number`, `created_at`, `updated_at`) VALUES
(1, 2, 'Vendor', 'Awash', '100001101010293', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vendors_business_details`
--

CREATE TABLE `vendors_business_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `shop_name` varchar(255) DEFAULT NULL,
  `shop_image` varchar(255) DEFAULT NULL,
  `shop_address` varchar(255) DEFAULT NULL,
  `shop_city` varchar(255) DEFAULT NULL,
  `shop_state` varchar(255) DEFAULT NULL,
  `shop_country` varchar(255) DEFAULT NULL,
  `shop_pincode` varchar(255) DEFAULT NULL,
  `shop_mobile` varchar(255) DEFAULT NULL,
  `shop_website` varchar(255) DEFAULT NULL,
  `shop_email` varchar(255) DEFAULT NULL,
  `address_proof` varchar(255) DEFAULT NULL,
  `address_proof_image` varchar(255) DEFAULT NULL,
  `business_license_number` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `were_houses`
--

CREATE TABLE `were_houses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `were_houses`
--

INSERT INTO `were_houses` (`id`, `name`, `code`, `address`, `phone`, `email`, `country`, `state`, `status`, `created_at`, `updated_at`) VALUES
(1, 'default', '4404', 'Adama', '0912651113', 'default@gmail.com', 'Ethiopia', 'oromia', '1', '2023-11-16 19:15:29', '2024-06-12 13:35:12'),
(3, 'Bole', '10001', 'Quis sed tempor temp', '+1 (698) 531-9442', 'poletaxodo@mailinator.com', 'Ethiopia', 'oromia', '1', '2023-11-21 00:06:43', '2023-12-23 03:46:11'),
(4, 'Adama', '10010', 'Est debitis blandit', '+1 (202) 819-1141', 'qohoho@mailinator.com', 'Ethiopia', 'amahra', '1', '2023-11-25 02:35:37', '2023-11-25 02:35:37'),
(6, 'kolfe', '11100010', 'Addis Ababa', '0911555692', 'default@gmail.com', 'Ethiopia', 'Oromia', '1', '2023-12-07 22:54:25', NULL),
(7, 'DireWarehouse', '000002', 'Alias assumenda non', '+1 (362) 117-1586', 'dire@mailinator.com', 'Ethiopia', 'oromia', '1', '2024-01-03 07:34:11', '2024-01-03 07:34:16');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdrawal_requests`
--

CREATE TABLE `withdrawal_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `receipt` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `withdrawal_requests`
--

INSERT INTO `withdrawal_requests` (`id`, `vendor_id`, `amount`, `status`, `receipt`, `description`, `created_at`, `updated_at`) VALUES
(2, 7, 12000.00, 'approved', 'receipts/ErJIt6UzQ7OJjvJtKBuklWhxl1q1UXNUPv6XH1HA.jpg', 'klsjdslfjasl', '2024-06-20 13:11:32', '2024-06-21 11:43:47'),
(5, 7, 1.00, 'pending', NULL, NULL, '2024-06-21 13:24:10', '2024-06-21 13:24:10');

-- --------------------------------------------------------

--
-- Table structure for table `withdraw_settings`
--

CREATE TABLE `withdraw_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `amount` varchar(255) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `withdraw_settings`
--

INSERT INTO `withdraw_settings` (`id`, `amount`, `status`, `created_at`, `updated_at`) VALUES
(2, '1000', 1, '2024-06-20 16:50:29', '2024-06-21 13:16:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin__user__roles`
--
ALTER TABLE `admin__user__roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `advertisements`
--
ALTER TABLE `advertisements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appsettings`
--
ALTER TABLE `appsettings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `apps_countries`
--
ALTER TABLE `apps_countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assign_stock_product_to_delivery`
--
ALTER TABLE `assign_stock_product_to_delivery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delivery_man_id` (`delivery_man_id`),
  ADD KEY `transfer_stock_product_id` (`transfer_stock_product_id`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_comments`
--
ALTER TABLE `blog_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_id` (`blog_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_pages`
--
ALTER TABLE `cms_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_order`
--
ALTER TABLE `custom_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_order_products`
--
ALTER TABLE `custom_order_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `deliverymen`
--
ALTER TABLE `deliverymen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_address`
--
ALTER TABLE `delivery_address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `delivery__boy__roles`
--
ALTER TABLE `delivery__boy__roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delivery_boy_id` (`delivery_boy_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `delivery__man__types`
--
ALTER TABLE `delivery__man__types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery__zones`
--
ALTER TABLE `delivery__zones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flash_deals`
--
ALTER TABLE `flash_deals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flash_deal_products`
--
ALTER TABLE `flash_deal_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `flash_deal_id` (`flash_deal_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_settings`
--
ALTER TABLE `invoice_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manager_warehouse`
--
ALTER TABLE `manager_warehouse`
  ADD PRIMARY KEY (`id`),
  ADD KEY `manager_id` (`manager_id`),
  ADD KEY `warehouse_id` (`warehouse_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `months`
--
ALTER TABLE `months`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `offers_product_id_foreign` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders_logs`
--
ALTER TABLE `orders_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `orders_products`
--
ALTER TABLE `orders_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `order_item_status`
--
ALTER TABLE `order_item_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `permission_categories`
--
ALTER TABLE `permission_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `price_plans`
--
ALTER TABLE `price_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `brand_id` (`brand_id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `products_attributes`
--
ALTER TABLE `products_attributes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `warehouse_id` (`warehouse_id`);

--
-- Indexes for table `products_filters`
--
ALTER TABLE `products_filters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cat_ids` (`cat_ids`);

--
-- Indexes for table `products_filters_values`
--
ALTER TABLE `products_filters_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `filter_id` (`filter_id`);

--
-- Indexes for table `products_images`
--
ALTER TABLE `products_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_month`
--
ALTER TABLE `product_month`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_month_product_id_foreign` (`product_id`),
  ADD KEY `product_month_month_id_foreign` (`month_id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `recently_viewed_products`
--
ALTER TABLE `recently_viewed_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `return_requests`
--
ALTER TABLE `return_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role__permissions`
--
ALTER TABLE `role__permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Indexes for table `sales_commissions`
--
ALTER TABLE `sales_commissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_commissions_salesperson_id_foreign` (`salesperson_id`),
  ADD KEY `sales_commissions_order_id_foreign` (`order_id`),
  ADD KEY `sales_commissions_product_id_foreign` (`product_id`);

--
-- Indexes for table `sales_main_commissions`
--
ALTER TABLE `sales_main_commissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_users`
--
ALTER TABLE `sales_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sales_users_email_unique` (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `shipping_charges`
--
ALTER TABLE `shipping_charges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping_methods`
--
ALTER TABLE `shipping_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping_method_prices`
--
ALTER TABLE `shipping_method_prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `zone_id` (`zone_id`),
  ADD KEY `shipping_method_id` (`shipping_method_id`);

--
-- Indexes for table `shipping_method_zone`
--
ALTER TABLE `shipping_method_zone`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shipping_method_zone_shipping_method_id_foreign` (`shipping_method_id`),
  ADD KEY `shipping_method_zone_shipping_zone_id_foreign` (`shipping_zone_id`);

--
-- Indexes for table `shipping_zones`
--
ALTER TABLE `shipping_zones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transfer_requests`
--
ALTER TABLE `transfer_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `from_warehouse_id` (`from_warehouse_id`),
  ADD KEY `to_warehouse_id` (`to_warehouse_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `transfer_stock_products`
--
ALTER TABLE `transfer_stock_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `from_warehouse_id` (`from_warehouse_id`),
  ADD KEY `to_warehouse_id` (`to_warehouse_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle__types`
--
ALTER TABLE `vehicle__types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendors_bank_details`
--
ALTER TABLE `vendors_bank_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `vendors_business_details`
--
ALTER TABLE `vendors_business_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `were_houses`
--
ALTER TABLE `were_houses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `withdrawal_requests`
--
ALTER TABLE `withdrawal_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `withdrawal_requests_vendor_id_foreign` (`vendor_id`);

--
-- Indexes for table `withdraw_settings`
--
ALTER TABLE `withdraw_settings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `admin__user__roles`
--
ALTER TABLE `admin__user__roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `advertisements`
--
ALTER TABLE `advertisements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `appsettings`
--
ALTER TABLE `appsettings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `apps_countries`
--
ALTER TABLE `apps_countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `assign_stock_product_to_delivery`
--
ALTER TABLE `assign_stock_product_to_delivery`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `blog_comments`
--
ALTER TABLE `blog_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `cms_pages`
--
ALTER TABLE `cms_pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `custom_order`
--
ALTER TABLE `custom_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `custom_order_products`
--
ALTER TABLE `custom_order_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `deliverymen`
--
ALTER TABLE `deliverymen`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `delivery_address`
--
ALTER TABLE `delivery_address`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `delivery__boy__roles`
--
ALTER TABLE `delivery__boy__roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `delivery__man__types`
--
ALTER TABLE `delivery__man__types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `delivery__zones`
--
ALTER TABLE `delivery__zones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `flash_deals`
--
ALTER TABLE `flash_deals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `flash_deal_products`
--
ALTER TABLE `flash_deal_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `invoice_settings`
--
ALTER TABLE `invoice_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `manager_warehouse`
--
ALTER TABLE `manager_warehouse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `months`
--
ALTER TABLE `months`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `orders_logs`
--
ALTER TABLE `orders_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `orders_products`
--
ALTER TABLE `orders_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `order_item_status`
--
ALTER TABLE `order_item_status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `order_status`
--
ALTER TABLE `order_status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=233;

--
-- AUTO_INCREMENT for table `permission_categories`
--
ALTER TABLE `permission_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `price_plans`
--
ALTER TABLE `price_plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `products_attributes`
--
ALTER TABLE `products_attributes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `products_filters`
--
ALTER TABLE `products_filters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products_filters_values`
--
ALTER TABLE `products_filters_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products_images`
--
ALTER TABLE `products_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_month`
--
ALTER TABLE `product_month`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recently_viewed_products`
--
ALTER TABLE `recently_viewed_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `return_requests`
--
ALTER TABLE `return_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `role__permissions`
--
ALTER TABLE `role__permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=326;

--
-- AUTO_INCREMENT for table `sales_commissions`
--
ALTER TABLE `sales_commissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sales_main_commissions`
--
ALTER TABLE `sales_main_commissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sales_users`
--
ALTER TABLE `sales_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `shipping_charges`
--
ALTER TABLE `shipping_charges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=258;

--
-- AUTO_INCREMENT for table `shipping_methods`
--
ALTER TABLE `shipping_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `shipping_method_prices`
--
ALTER TABLE `shipping_method_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `shipping_method_zone`
--
ALTER TABLE `shipping_method_zone`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `shipping_zones`
--
ALTER TABLE `shipping_zones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transfer_requests`
--
ALTER TABLE `transfer_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transfer_stock_products`
--
ALTER TABLE `transfer_stock_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `vehicle__types`
--
ALTER TABLE `vehicle__types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `vendors_bank_details`
--
ALTER TABLE `vendors_bank_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `were_houses`
--
ALTER TABLE `were_houses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdrawal_requests`
--
ALTER TABLE `withdrawal_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `withdraw_settings`
--
ALTER TABLE `withdraw_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `admin__user__roles`
--
ALTER TABLE `admin__user__roles`
  ADD CONSTRAINT `admin__user__roles_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `admin__user__roles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `assign_stock_product_to_delivery`
--
ALTER TABLE `assign_stock_product_to_delivery`
  ADD CONSTRAINT `assign_stock_product_to_delivery_ibfk_1` FOREIGN KEY (`delivery_man_id`) REFERENCES `deliverymen` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `assign_stock_product_to_delivery_ibfk_2` FOREIGN KEY (`transfer_stock_product_id`) REFERENCES `transfer_stock_products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `blog_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `blog_comments`
--
ALTER TABLE `blog_comments`
  ADD CONSTRAINT `blog_comments_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `coupons`
--
ALTER TABLE `coupons`
  ADD CONSTRAINT `coupons_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `custom_order_products`
--
ALTER TABLE `custom_order_products`
  ADD CONSTRAINT `custom_order_products_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `custom_order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `delivery_address`
--
ALTER TABLE `delivery_address`
  ADD CONSTRAINT `delivery_address_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `delivery__boy__roles`
--
ALTER TABLE `delivery__boy__roles`
  ADD CONSTRAINT `delivery__boy__roles_ibfk_1` FOREIGN KEY (`delivery_boy_id`) REFERENCES `deliverymen` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `delivery__boy__roles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `discounts`
--
ALTER TABLE `discounts`
  ADD CONSTRAINT `discounts_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `flash_deal_products`
--
ALTER TABLE `flash_deal_products`
  ADD CONSTRAINT `flash_deal_products_ibfk_1` FOREIGN KEY (`flash_deal_id`) REFERENCES `flash_deals` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `flash_deal_products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `manager_warehouse`
--
ALTER TABLE `manager_warehouse`
  ADD CONSTRAINT `manager_warehouse_ibfk_1` FOREIGN KEY (`manager_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `manager_warehouse_ibfk_2` FOREIGN KEY (`warehouse_id`) REFERENCES `were_houses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `offers`
--
ALTER TABLE `offers`
  ADD CONSTRAINT `offers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `offers_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders_logs`
--
ALTER TABLE `orders_logs`
  ADD CONSTRAINT `orders_logs_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders_products`
--
ALTER TABLE `orders_products`
  ADD CONSTRAINT `orders_products_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_products_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_products_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `permission_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_ibfk_3` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_ibfk_4` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products_attributes`
--
ALTER TABLE `products_attributes`
  ADD CONSTRAINT `products_attributes_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_attributes_ibfk_2` FOREIGN KEY (`warehouse_id`) REFERENCES `were_houses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products_filters`
--
ALTER TABLE `products_filters`
  ADD CONSTRAINT `products_filters_ibfk_1` FOREIGN KEY (`cat_ids`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products_filters_values`
--
ALTER TABLE `products_filters_values`
  ADD CONSTRAINT `products_filters_values_ibfk_1` FOREIGN KEY (`filter_id`) REFERENCES `products_filters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products_images`
--
ALTER TABLE `products_images`
  ADD CONSTRAINT `products_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_month`
--
ALTER TABLE `product_month`
  ADD CONSTRAINT `product_month_month_id_foreign` FOREIGN KEY (`month_id`) REFERENCES `months` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_month_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `recently_viewed_products`
--
ALTER TABLE `recently_viewed_products`
  ADD CONSTRAINT `recently_viewed_products_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `return_requests`
--
ALTER TABLE `return_requests`
  ADD CONSTRAINT `return_requests_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `return_requests_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role__permissions`
--
ALTER TABLE `role__permissions`
  ADD CONSTRAINT `role__permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role__permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sales_commissions`
--
ALTER TABLE `sales_commissions`
  ADD CONSTRAINT `sales_commissions_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sales_commissions_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sales_commissions_salesperson_id_foreign` FOREIGN KEY (`salesperson_id`) REFERENCES `sales_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `shipping_method_prices`
--
ALTER TABLE `shipping_method_prices`
  ADD CONSTRAINT `shipping_method_prices_ibfk_1` FOREIGN KEY (`zone_id`) REFERENCES `shipping_zones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `shipping_method_prices_ibfk_2` FOREIGN KEY (`shipping_method_id`) REFERENCES `shipping_methods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `shipping_method_zone`
--
ALTER TABLE `shipping_method_zone`
  ADD CONSTRAINT `shipping_method_zone_shipping_method_id_foreign` FOREIGN KEY (`shipping_method_id`) REFERENCES `shipping_methods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `shipping_method_zone_shipping_zone_id_foreign` FOREIGN KEY (`shipping_zone_id`) REFERENCES `shipping_zones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transfer_requests`
--
ALTER TABLE `transfer_requests`
  ADD CONSTRAINT `transfer_requests_ibfk_1` FOREIGN KEY (`from_warehouse_id`) REFERENCES `were_houses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transfer_requests_ibfk_2` FOREIGN KEY (`to_warehouse_id`) REFERENCES `were_houses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transfer_requests_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transfer_stock_products`
--
ALTER TABLE `transfer_stock_products`
  ADD CONSTRAINT `transfer_stock_products_ibfk_1` FOREIGN KEY (`from_warehouse_id`) REFERENCES `were_houses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transfer_stock_products_ibfk_2` FOREIGN KEY (`to_warehouse_id`) REFERENCES `were_houses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transfer_stock_products_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vendors_bank_details`
--
ALTER TABLE `vendors_bank_details`
  ADD CONSTRAINT `vendors_bank_details_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vendors_business_details`
--
ALTER TABLE `vendors_business_details`
  ADD CONSTRAINT `vendors_business_details_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wishlists_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `withdrawal_requests`
--
ALTER TABLE `withdrawal_requests`
  ADD CONSTRAINT `withdrawal_requests_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
