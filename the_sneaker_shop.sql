-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 23, 2025 at 05:04 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `the_sneaker_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `baners`
--

CREATE TABLE `baners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `baners`
--

INSERT INTO `baners` (`id`, `name`, `image`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(3, 'Banner 1', '2025-03-07-67c9e2050b60f.webp', 1, 1, '2025-01-20 03:44:27', '2025-03-06 17:57:36'),
(4, 'Banner 2', '2025-03-07-67c9e3561cb75.webp', 1, 1, '2025-01-20 03:44:39', '2025-03-06 18:03:05'),
(5, 'Banner 3', '2025-03-07-67c9e372617da.webp', 1, 1, '2025-01-20 03:44:48', '2025-03-06 18:03:32');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `image`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(5, 'Vans', '2025-01-24-67939427b6c4b.png', 1, 1, '2024-11-09 00:03:41', '2025-02-28 06:36:08'),
(6, 'Nike', '2025-01-24-6793943b4e998.png', 1, 1, '2025-01-24 06:23:07', '2025-02-28 06:37:43'),
(7, 'Adidas', '2025-03-01-67c30a1c48535.png', 1, 1, '2025-01-24 06:23:47', '2025-03-01 13:22:36'),
(8, 'PUMA', '2025-01-24-679394da9845f.png', 1, 1, '2025-01-24 06:25:46', '2025-02-28 06:37:51'),
(9, 'New Balance', '2025-01-24-679395166b1e2.png', 1, 1, '2025-01-24 06:26:46', '2025-02-20 13:42:35'),
(10, 'The North Face', '2025-01-24-6793953bec5b8.png', 1, 1, '2025-01-24 06:27:23', '2025-02-28 06:47:50'),
(11, 'Converse', '2025-01-24-679395542d53f.png', 1, 1, '2025-01-24 06:27:48', '2025-01-24 06:27:48'),
(12, 'Columbia', '2025-01-24-67939566a56c8.png', 1, 1, '2025-01-24 06:28:06', '2025-01-24 06:28:06'),
(13, 'Umbro', '2025-01-24-6793957080080.png', 1, 1, '2025-01-24 06:28:16', '2025-02-28 06:47:50'),
(14, 'Reebok', '2025-01-24-6793958009af7.png', 1, 1, '2025-01-24 06:28:32', '2025-01-24 06:28:32'),
(15, 'Under Armour', '2025-01-24-679395a384ed5.png', 1, 1, '2025-01-24 06:29:07', '2025-01-24 06:29:07'),
(16, 'Sketchers', '2025-01-24-679395bdacca3.png', 1, 1, '2025-01-24 06:29:33', '2025-01-31 13:01:48'),
(17, 'GUCCI', '2025-01-24-679395d200037.png', 1, 1, '2025-01-24 06:29:54', '2025-02-27 09:53:37'),
(18, 'Louis Vuitton', '2025-01-24-6793960bb6e55.png', 1, 1, '2025-01-24 06:30:51', '2025-02-27 09:51:46');

-- --------------------------------------------------------

--
-- Table structure for table `business_settings`
--

CREATE TABLE `business_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(191) DEFAULT NULL,
  `value` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `business_settings`
--

INSERT INTO `business_settings` (`id`, `type`, `value`, `created_at`, `updated_at`) VALUES
(1, 'language', '[{\"id\":\"1\",\"name\":\"english\",\"direction\":\"ltr\",\"code\":\"en\",\"status\":1,\"default\":true},{\"id\":2,\"name\":\"Khmer\",\"direction\":\"ltr\",\"code\":\"kh\",\"status\":1,\"default\":false}]', NULL, '2025-03-30 08:10:44'),
(2, 'pnc_language', '[\"en\",\"kh\"]', NULL, NULL),
(3, 'company_name', 'THE SNEAKER STORE', '2024-01-30 21:37:49', '2024-11-28 06:13:51'),
(4, 'phone', '+855 10 679 106', '2024-01-30 21:37:49', '2024-08-06 02:18:14'),
(5, 'email', 'thesneaker@gmail.com', '2024-01-30 21:37:49', '2024-11-09 06:06:26'),
(6, 'company_address', 'Siem Reap, Cambodia', '2024-01-30 21:37:49', '2024-08-24 03:19:58'),
(7, 'copy_right_text', '© Copyright 2024 by The Sneaker Store', '2024-01-30 21:37:49', '2024-11-09 06:06:26'),
(14, 'timezone', 'Asia/Ho_Chi_Minh', '2024-01-30 21:37:49', '2024-01-30 21:37:49'),
(15, 'currency', 'USD', '2024-01-30 21:37:49', '2024-01-30 21:37:49'),
(16, 'social_media', '[{\"title\":\"Facebook\",\"link\":\"https:\\/\\/facebook.com\",\"icon\":\"2025-03-30-67e8f07ab2983.png\",\"status\":1}]', '2024-01-30 21:37:49', '2025-03-30 07:19:22'),
(17, 'web_header_logo', '2025-03-30-67e8e5b252933.png', '2024-02-05 21:06:10', '2025-03-30 06:33:22'),
(19, 'fav_icon', '2025-03-29-67e7e7b01e186.png', '2024-02-05 21:06:10', '2025-03-29 12:29:36'),
(20, 'link_google_map', NULL, '2024-02-05 21:34:36', '2024-08-24 03:19:58'),
(23, 'company_description', '<span data-metadata=\"<!--(figmeta)eyJmaWxlS2V5IjoiTUppTWdaNnF3VGl2TnBmMER2Y2QzdiIsInBhc3RlSUQiOjIwNDU4MTY1MjUsImRhdGFUeXBlIjoic2NlbmUifQo=(/figmeta)-->\"></span><br>', '2024-02-05 23:32:52', '2024-08-24 03:19:58'),
(45, 'payment', '[{\"title\":\"VISA\",\"icon\":\"2025-03-30-67e8f07ab310a.png\",\"status\":1}]', '2024-08-10 07:16:11', '2025-03-30 07:19:22'),
(46, 'contact', '[{\"title\":\"069 78 66 77\",\"link\":null,\"icon\":\"2025-03-30-67e8f07ab2169.png\",\"status\":1},{\"title\":\"069 78 66 77\",\"link\":null,\"icon\":\"2025-03-30-67e8f26a6fb7a.png\",\"status\":0}]', '2024-08-11 06:14:51', '2025-03-30 07:27:38'),
(49, 'slider_title', NULL, '2024-12-08 08:43:54', '2024-12-08 08:43:54'),
(50, 'slider_description', NULL, '2024-12-08 08:43:54', '2024-12-08 08:43:54'),
(56, 'image_names', NULL, '2025-03-28 08:51:55', '2025-03-29 08:37:12');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `first_name` varchar(191) DEFAULT NULL,
  `last_name` varchar(191) DEFAULT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `password` varchar(191) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `google_uid` text DEFAULT NULL,
  `provider` text DEFAULT NULL,
  `is_verify` int(11) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `locale` varchar(64) DEFAULT NULL,
  `timezone` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `image`, `first_name`, `last_name`, `gender`, `phone`, `email`, `password`, `status`, `remember_token`, `google_uid`, `provider`, `is_verify`, `deleted_at`, `created_at`, `updated_at`, `email_verified_at`, `locale`, `timezone`) VALUES
(7, 'KURIZERK', '1744358962.jpg', NULL, NULL, 'male', '85510679106', 'kurizerk@gmail.com', '$2y$10$1k5B.xpei4G4d3tw75.C/uHMLrxMLwzr865EuvnJfH6A0h/YMDAGu', 1, NULL, NULL, 'phone', 1, NULL, '2025-04-06 10:27:39', '2025-04-19 13:39:21', NULL, NULL, NULL),
(18, 'Sros Thai', NULL, NULL, NULL, NULL, '85581991009', NULL, '$2y$10$T2dh96pBMZuhBu2Pt094uO/1bBlLZX2b/Y5yH4gIZ45b/6EOkDIs6', 1, NULL, NULL, 'phone', 1, NULL, '2025-04-11 08:18:31', '2025-04-11 08:18:37', NULL, NULL, NULL),
(19, 'Ing China', 'https://lh3.googleusercontent.com/a/ACg8ocIYg50UAGmA_PdvxDqOoLODcz9fOUJMwuhrSREUAdmSbneiFw=s96-', NULL, NULL, NULL, '85598168168', 'ingchina2004@gmail.com', NULL, 1, NULL, 'HwPqmvKvuSNQ5qVFaI7nu29DRlG3', 'google', 1, NULL, '2025-04-11 08:19:51', '2025-04-11 09:22:38', NULL, NULL, NULL),
(20, 'Chan Darong', NULL, NULL, NULL, NULL, '855888296818', NULL, '$2y$10$X.OE7Uh4/Hy92hSf93PLoemkTQ2t1pJFIHFpKi.YtzAB0yryFz3e6', 1, NULL, NULL, 'phone', 1, NULL, '2025-04-19 08:29:24', '2025-04-19 08:29:44', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(191) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_12_15_232210_create_business_settings_table', 1),
(6, '2022_12_17_083144_create_permission_tables', 1),
(7, '2022_12_19_054410_create_products_table', 1),
(8, '2023_08_25_092523_create_translations_table', 1),
(9, '2023_08_26_035115_add_some_column_to_users_table', 1),
(10, '2023_08_28_112457_create_categories_table', 1),
(11, '2023_08_29_144037_add_columns_to_products_table', 1),
(12, '2023_08_30_140724_add_column_user_id_to_users_table', 1),
(13, '2024_01_31_132916_create_menus_table', 2),
(14, '2024_01_31_144511_create_sliders_table', 3),
(19, '2024_02_01_085241_create_rooms_table', 5),
(21, '2024_02_01_130123_create_galleries_table', 6),
(24, '2024_02_01_143446_create_home_stay_amenities_table', 7),
(25, '2024_02_01_091400_create_home_stay_galleries_table', 8),
(27, '2024_02_02_155704_create_rate_plans_table', 9),
(28, '2024_02_04_163121_create_services_table', 10),
(29, '2024_02_04_164435_create_service_galleries_table', 10),
(30, '2024_02_01_103934_create_blog_categories_table', 11),
(31, '2024_02_01_162910_create_blog_tags_table', 11),
(32, '2024_02_03_133205_create_facilities_table', 11),
(33, '2024_02_05_105401_create_blogs_table', 11),
(34, '2024_02_05_153903_create_menu_explores_table', 12),
(35, '2024_02_06_085552_create_customers_table', 13),
(39, '2024_02_06_160452_create_comments_table', 14),
(41, '2024_02_07_104601_add_columns_menu_url_to_menus_table', 15),
(42, '2024_02_07_104719_add_columns_menu_url_to_menu_explores_table', 15),
(43, '2024_02_07_102508_create_extra_services_table', 16),
(44, '2024_02_05_134456_create_facilities_table', 17),
(45, '2024_02_08_105218_create_room_dates_table', 17),
(46, '2024_02_09_091120_add_column_price_table', 17),
(47, '2024_02_10_093614_create_transactions_table', 17),
(48, '2024_02_10_143338_add_column_type_to_room_dates_table', 17),
(49, '2024_02_12_141641_edit_columns_in_room_dates_table', 17),
(50, '2024_02_12_153516_add_column_number_to_rooms_table', 17),
(51, '2024_02_13_090938_add_amenities_to_rooms_table', 17),
(52, '2024_02_13_120006_add_more_column_to_rooms_table', 17),
(53, '2024_02_13_144521_add_soft_delete_to_transactions_table', 17),
(54, '2024_02_13_162125_add_start_date_and_end_date_to_transactions_table', 17),
(55, '2024_02_14_100126_add_column_admin_id_to_table_comment', 18),
(56, '2024_02_14_103157_create_contact_us_table', 18),
(57, '2024_02_16_091636_add_column_to_table_rooms', 18),
(58, '2024_02_17_165149_add_fiels_to_customer_table', 19),
(59, '2024_02_19_135224_add_columns_to_transactions_table', 19),
(60, '2024_02_20_092033_add_customer_id_to_transactions_table', 19),
(61, '2024_02_24_110033_create_notifications_table', 20),
(62, '2024_02_24_160816_add_is_send_date_to_notifications_table', 21),
(63, '2024_02_24_170747_add_blog_id_to_comments_table', 22),
(64, '2024_02_25_194629_change_columns_in_sliders_table', 22),
(65, '2024_03_27_084453_create_pages_table', 22),
(66, '2024_03_27_084704_create_section_titles_table', 22),
(67, '2024_04_01_101605_add_column_des_to_table_galleries', 23),
(68, '2024_04_01_101845_add_column_status_to_table_comments', 23),
(69, '2024_05_08_145345_add_3_column_to_table_room', 24),
(70, '2024_05_09_085247_add_column_type_to_slider', 25),
(72, '2024_08_07_152808_add_thumbnail_to_facilities_table', 26),
(73, '2024_08_08_090757_add_some_column_to_rooms_table', 27),
(74, '2024_08_08_113008_create_staycations_table', 28),
(75, '2024_08_08_115418_add_amenities_to_staycations_table', 29),
(76, '2024_08_08_130239_add_some_column_to_staycations_table', 30),
(77, '2024_08_08_162324_create_highlights_table', 31),
(78, '2024_08_12_122704_add_price_to_rooms_table', 32),
(79, '2024_08_14_094310_add_icon_to_highlights_table', 33),
(80, '2024_08_19_105334_add_category_id_to_galleries_table', 34),
(81, '2024_08_20_101051_create_gallery_categories_table', 35),
(89, '2024_11_09_200925_add_some_to_products_table', 39),
(96, '2024_11_13_163719_add_images_to_products_table', 46),
(99, '2024_11_29_115432_create_customers_table', 49),
(104, '2025_01_05_155550_create_transactions_table', 54),
(105, '2025_01_08_102407_add_status_to_transactions_table', 55),
(106, '2025_01_08_103548_add_payment_method_to_transactions_table', 56),
(107, '2025_01_08_105405_add_delivery_to_transactions_table', 57),
(110, '2025_01_19_140346_create_shoessliders_table', 58),
(112, '2016_06_01_000001_create_oauth_auth_codes_table', 59),
(113, '2016_06_01_000002_create_oauth_access_tokens_table', 59),
(114, '2016_06_01_000003_create_oauth_refresh_tokens_table', 59),
(115, '2016_06_01_000004_create_oauth_clients_table', 59),
(116, '2016_06_01_000005_create_oauth_personal_access_clients_table', 59),
(117, '2024_07_29_113819_create_jobs_table', 59),
(118, '2024_11_09_133037_create_brands_table', 59),
(119, '2024_11_09_134511_create_products_table', 59),
(120, '2024_11_10_152744_add_some_column_to_promotions_table', 59),
(121, '2024_11_10_195031_add_column_product_to_products_table', 59),
(122, '2024_11_10_213047_create_promotion_product_table', 59),
(123, '2024_11_11_145306_add_status_to_products_table', 59),
(124, '2024_11_11_190735_add_column_to_promotions_table', 59),
(125, '2024_11_11_192232_create_promotion_brand_table', 59),
(126, '2024_11_23_195453_create_product_galleries_table', 59),
(127, '2024_11_28_101613_add_column_rating_to_products_table', 59),
(128, '2024_11_29_115928_create_customers_table', 59),
(129, '2024_11_30_101039_add_column_count_product_sale_to_products_table', 59),
(130, '2024_12_08_120612_add_status_columns_to_products_table', 59),
(131, '2025_01_05_115754_create_promotion_galleries_table', 59),
(132, '2025_01_08_110011_create_orders_table', 59),
(133, '2025_01_08_110032_create_order_details_table', 59),
(134, '2025_01_19_143358_create_shoes_sliders_table', 59),
(135, '2025_01_24_134656_add_api_token_to_customers_table', 60),
(140, '2025_03_21_200203_add_column_invoice_ref_to_order_details_table', 62),
(143, '2025_04_01_193238_add_name_to_customers_table', 64),
(147, '2025_02_13_201734_add_gender_to_users_table', 65),
(148, '2025_03_18_203744_add_some_column_to_customers_table', 65),
(149, '2025_04_01_193124_add_name_to_customers_table', 66),
(150, '2025_04_06_171758_add_is_verify_to_customers_table', 66),
(151, '2025_04_08_114333_add_address_to_orders_table', 66),
(152, '2025_04_11_115401_add_order_type_to_orders_table', 66),
(153, '2025_04_11_142931_add_uid_to_customers_table', 67),
(154, '2025_04_12_112136_add_final_total_to_orders_table', 68);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(1, 'App\\Models\\User', 2),
(7, 'App\\Models\\User', 3),
(7, 'App\\Models\\User', 4),
(7, 'App\\Models\\User', 5),
(7, 'App\\Models\\User', 6),
(7, 'App\\Models\\User', 7),
(7, 'App\\Models\\User', 8),
(7, 'App\\Models\\User', 9),
(7, 'App\\Models\\User', 10),
(7, 'App\\Models\\User', 11),
(7, 'App\\Models\\User', 12),
(7, 'App\\Models\\User', 13),
(7, 'App\\Models\\User', 14),
(7, 'App\\Models\\User', 15),
(7, 'App\\Models\\User', 16),
(7, 'App\\Models\\User', 17);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('35eaf74e3d13e412c3ad25f2458552143bfe856821336bc18a4682659e682143f02dc776b2c74903', 19, 1, 'google_login', '[]', 0, '2025-04-19 13:40:03', '2025-04-19 13:40:03', '2026-04-19 20:40:03'),
('67eccddb57a704845be2bdf345abb26bbff35ce654b9bc73bce813026cc8bbeb8548a65197fd0700', 12, 1, 'customer-token', '[]', 0, '2025-04-11 07:44:50', '2025-04-11 07:44:50', '2026-04-11 14:44:50'),
('9bb2c098907f19d77a7a038ad1d41a43574e7e3dadc1aff86b397e5092c7017fee099741c4769316', 16, 1, 'PhoneLogin', '[]', 0, '2025-04-11 08:14:30', '2025-04-11 08:14:30', '2026-04-11 15:14:30'),
('9c30b72652200af4ee613246a912efed26bb9641d8e15b51a4b6cdcb46e906173620620622ea91fd', 11, 1, 'CustomerAccessToken', '[]', 0, '2025-04-11 07:44:06', '2025-04-11 07:44:06', '2026-04-11 14:44:06'),
('a794c00403b7496f073bcd42712c402c6f987da8d2a6ba4be41313f863b56b424fc7b3a19bc25709', 6, 1, 'PhoneLogin', '[]', 0, '2025-04-06 10:26:34', '2025-04-06 10:26:34', '2026-04-06 17:26:34'),
('ae6bbdba08fe230ab1e576a762ae4c6afff4c0dab0d34a657a0d860a28951ab8f9e71b4da6733d99', 7, 1, 'PhoneLogin', '[]', 0, '2025-04-23 02:31:02', '2025-04-23 02:31:02', '2026-04-23 09:31:02'),
('af2a7358977c88c39265a00237561d2a1e18028d7f74a189f1a2daa2477aab2e765f9dc70764caeb', 18, 1, 'PhoneLogin', '[]', 0, '2025-04-11 08:18:37', '2025-04-11 08:18:37', '2026-04-11 15:18:37'),
('d494607839f43bbddfd47687990b478ccfc6b891dc0c9ac10ab89fccd946b5241c6ed09b5f23eb6a', 17, 1, 'PhoneLogin', '[]', 0, '2025-04-11 08:17:18', '2025-04-11 08:17:18', '2026-04-11 15:17:18'),
('f63f45071560de569704257cfb4cd9418652c00926a52c072f74e1c9e0a11a5f201b7a08b2013e49', 20, 1, 'PhoneLogin', '[]', 0, '2025-04-19 08:29:44', '2025-04-19 08:29:44', '2026-04-19 15:29:44');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `secret` varchar(100) DEFAULT NULL,
  `provider` varchar(191) DEFAULT NULL,
  `redirect` text NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'JwC55H6Ge8JNpt19sWazJykFdnSngcCFAExAqE39', NULL, 'http://localhost', 1, 0, 0, '2025-03-21 13:16:56', '2025-03-21 13:16:56'),
(2, NULL, 'Laravel Password Grant Client', 'EpyhQ1cdpjSt08t0Z5S2BFbFBzdLJOZIhRy3l0j1', 'users', 'http://localhost', 0, 1, 0, '2025-03-21 13:16:56', '2025-03-21 13:16:56');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-03-21 13:16:56', '2025-03-21 13:16:56');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `onboards`
--

CREATE TABLE `onboards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) NOT NULL,
  `image` varchar(191) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `onboards`
--

INSERT INTO `onboards` (`id`, `title`, `image`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Logo Onboard', '2024-08-24-66c9673f531b8.png', 1, '2024-08-24 04:52:32', '2024-12-13 13:43:23');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_ref` varchar(191) DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `order_amount` decimal(10,2) DEFAULT NULL,
  `discount_amount` decimal(10,2) DEFAULT NULL,
  `order_type` enum('pickup','delivery') DEFAULT NULL,
  `delivery_type` varchar(191) DEFAULT NULL,
  `delivery_fee` decimal(10,2) DEFAULT NULL,
  `order_status` enum('pending','confirmed','packaging','out_for_delivery','delivered','failed_to_deliver','cancelled') DEFAULT 'pending',
  `payment_method` enum('pay_at_store','cash_on_delivery','aba','wing','acleda') DEFAULT NULL,
  `address` longtext DEFAULT NULL,
  `payment_status` enum('unpaid','paid') DEFAULT NULL,
  `final_total` decimal(10,2) DEFAULT NULL,
  `pay_slip` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `product_details` varchar(191) DEFAULT NULL,
  `product_qty` int(11) DEFAULT NULL,
  `product_size` varchar(191) DEFAULT NULL,
  `product_price` decimal(10,2) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `discount_type` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `guard_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'user.view', 'web', NULL, NULL),
(2, 'user.create', 'web', NULL, NULL),
(3, 'user.edit', 'web', NULL, NULL),
(4, 'user.delete', 'web', NULL, NULL),
(5, 'customer.view', 'web', '2024-02-19 19:43:33', '2024-02-19 19:43:33'),
(6, 'blog.view', 'web', '2024-02-19 19:43:33', '2024-02-19 19:43:33'),
(7, 'gallery.view', 'web', '2024-02-19 19:43:33', '2024-02-19 19:43:33'),
(8, 'service.view', 'web', '2024-02-19 19:43:33', '2024-02-19 19:43:33'),
(9, 'slider.view', 'web', '2024-02-19 19:43:33', '2024-02-19 19:43:33'),
(10, 'facility.view', 'web', '2024-02-19 19:43:33', '2024-02-19 19:43:33'),
(11, 'menu.view', 'web', '2024-02-19 19:43:33', '2024-02-19 19:43:33'),
(12, 'menu.explore.view', 'web', '2024-02-19 20:06:20', '2024-02-19 20:06:20'),
(13, 'room.view', 'web', '2024-02-19 23:54:46', '2024-02-19 23:54:46'),
(14, 'banner.view', 'web', '2024-11-09 14:31:56', '2024-11-09 14:31:56'),
(15, 'onboard.view', 'web', '2024-11-09 14:31:56', '2024-11-09 14:31:56'),
(16, 'promotion.view', 'web', '2024-11-09 14:31:56', '2024-11-09 14:31:56'),
(17, 'setting.view', 'web', '2025-04-18 08:05:39', '2025-04-18 08:05:39');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'accessToken', 'ded913a11dabfae17aaa5b2c654e6e3e90ccae96c1b5797f13e25e9a0ffe61c5', '[\"*\"]', NULL, '2024-08-24 06:41:02', '2024-08-24 06:41:02'),
(2, 'App\\Models\\User', 1, 'accessToken', '5a4c152bb71078eada120deb082eb8b89fa08bb53f6c3abbe272e4f3cf35ee60', '[\"*\"]', NULL, '2024-08-24 06:41:35', '2024-08-24 06:41:35'),
(3, 'App\\Models\\User', 1, 'accessToken', '81d7fffddcd80eeefb651a9ef4bdbbb06b3d645349ce1f1fc30bf1b45f97027d', '[\"*\"]', NULL, '2024-08-24 06:41:58', '2024-08-24 06:41:58'),
(4, 'App\\Models\\User', 1, 'accessToken', 'fe0bc1ce6e0cea612edccd80d8f6807b175cf3a321f59f0d4356a111952a521c', '[\"*\"]', NULL, '2024-08-24 06:42:26', '2024-08-24 06:42:26'),
(5, 'App\\Models\\User', 1, 'accessToken', 'd7b9ad74d0b2358afc9979a67dee70e33b2c401cd67959e62fc97428b70c5ae2', '[\"*\"]', NULL, '2024-08-24 06:42:36', '2024-08-24 06:42:36'),
(6, 'App\\Models\\User', 1, 'accessToken', 'd7e222b421e4a83872fcb4d3681200400a0b2a86b36a673c57caa856aff554c4', '[\"*\"]', NULL, '2024-08-24 06:51:58', '2024-08-24 06:51:58'),
(7, 'App\\Models\\User', 1, 'accessToken', 'a8c9246bcd4c9162f60eb40c33f481323ec3ee083f54aed179822ec6b73d49ad', '[\"*\"]', NULL, '2024-08-24 06:53:59', '2024-08-24 06:53:59'),
(8, 'App\\Models\\User', 1, 'accessToken', '99a71e0b2321735e2ea31554d98352134b41a6ba756ff95959332d7059771b9b', '[\"*\"]', NULL, '2024-08-24 06:59:40', '2024-08-24 06:59:40'),
(9, 'App\\Models\\User', 1, 'accessToken', 'c1a491022679aec7cd3014078dc032830d477df3a2422e23c6bca1052d951ae3', '[\"*\"]', NULL, '2024-08-24 07:04:25', '2024-08-24 07:04:25'),
(10, 'App\\Models\\User', 1, 'accessToken', 'a1cc4dd14688642372396b806bac660a345f276c3f0ed8e43e9b2bd309c41018', '[\"*\"]', NULL, '2024-08-24 07:06:40', '2024-08-24 07:06:40'),
(11, 'App\\Models\\User', 1, 'accessToken', '8855315bae44b03c8dcaf1697448ae17cfd34a0d8a7edb76d3b166d6b5194315', '[\"*\"]', NULL, '2024-08-24 07:11:21', '2024-08-24 07:11:21'),
(12, 'App\\Models\\User', 1, 'Personal Access Token', '224de9f42f66a7187a5dcce69699821264617068daa7235efcac06403bc4de73', '[\"*\"]', NULL, '2024-08-24 07:12:57', '2024-08-24 07:12:57'),
(13, 'App\\Models\\User', 1, 'accessToken', '05e7c57000062e68dc2608305cf5c191e8dab65a6698102021aaa8a9cd8af1c5', '[\"*\"]', NULL, '2024-08-24 07:13:45', '2024-08-24 07:13:45'),
(14, 'App\\Models\\User', 1, 'accessToken', '279bb3a5bc47086b3d23c06ed5e2db998fdd4114b05877b1b0d489875ae7c2f9', '[\"*\"]', NULL, '2024-08-24 07:23:13', '2024-08-24 07:23:13'),
(15, 'App\\Models\\User', 1, 'accessToken', '51ef63c0f8dccbd1d2a4024a9efeba56ceb966fbb0dacf886047ab0ef02d0b39', '[\"*\"]', NULL, '2024-08-24 07:23:29', '2024-08-24 07:23:29');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `description` varchar(191) DEFAULT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `product_info` longtext DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `rating` varchar(191) DEFAULT NULL,
  `count_product_sale` varchar(191) DEFAULT '0',
  `new_arrival` tinyint(1) NOT NULL DEFAULT 0,
  `recommended` tinyint(1) NOT NULL DEFAULT 0,
  `popular` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `brand_id`, `created_by`, `deleted_at`, `created_at`, `updated_at`, `product_info`, `status`, `rating`, `count_product_sale`, `new_arrival`, `recommended`, `popular`) VALUES
(1, 'Air Jordan 1 Retro High Off-White Chicago', 'Sneaker Shoes', 5, 1, '2025-01-24 08:19:20', '2024-11-24 20:20:10', '2025-01-24 08:19:20', '[{\"product_size\":\"41\",\"product_price\":\"4500.00\",\"product_qty\":\"5\"},{\"product_size\":\"42\",\"product_price\":\"4700.00\",\"product_qty\":\"8\"}]', 1, '5', '0', 0, 1, 0),
(2, 'Nike Dunk SB Low Bucks', 'Sneaker Shoes', 5, 1, '2025-01-24 08:19:18', '2024-11-24 20:25:30', '2025-01-24 08:19:18', '[{\"product_size\":\"42\",\"product_price\":\"400.00\",\"product_qty\":\"10\"},{\"product_size\":\"43\",\"product_price\":\"450.00\",\"product_qty\":\"6\"}]', 1, '4', '0', 0, 1, 1),
(10, 'Yeezy Boost 700 V1 Wave Runner', 'Adidas', 5, 1, '2025-01-24 08:19:13', '2024-11-27 20:35:10', '2025-01-24 08:19:13', '[{\"product_size\":\"43\",\"product_price\":\"550.00\",\"product_qty\":\"8\"},{\"product_size\":\"44\",\"product_price\":\"560.00\",\"product_qty\":\"9\"},{\"product_size\":\"45\",\"product_price\":\"570.00\",\"product_qty\":\"10\"}]', 1, '3', '0', 0, 0, 0),
(11, 'Vans', 'Vans Old Skool', 5, 1, '2025-01-24 08:19:11', '2024-12-07 22:15:35', '2025-01-24 08:19:11', '[{\"product_size\":\"41\",\"product_price\":\"100.00\",\"product_qty\":\"8\"},{\"product_size\":\"43\",\"product_price\":\"100.00\",\"product_qty\":\"5\"},{\"product_size\":\"44\",\"product_price\":\"120.00\",\"product_qty\":\"5\"}]', 1, '4', '0', 1, 0, 1),
(12, 'Nike Air Force 1 \'07', 'The radiance lives on in the Nike Air Force 1 ’07, the b-ball OG that puts a fresh spin on what you know best: durably stitched overlays.', 6, 1, NULL, '2025-01-24 08:33:42', '2025-04-23 02:57:55', '[{\"product_size\":\"41\",\"product_price\":\"115.00\",\"product_qty\":\"5\"},{\"product_size\":\"42\",\"product_price\":\"120.00\",\"product_qty\":\"0\"}]', 1, '5', '59', 0, 1, 0),
(13, 'Nike Air Max Dn x Isamaya Ffrench', 'Designed in collaboration with renowned makeup artist Isamaya Ffrench', 6, 1, NULL, '2025-01-24 08:40:20', '2025-01-24 08:42:14', '[{\"product_size\":\"39\",\"product_price\":\"170.00\",\"product_qty\":\"5\"},{\"product_size\":\"38\",\"product_price\":\"170.00\",\"product_qty\":\"10\"}]', 1, '4', '0', 1, 1, 0),
(14, 'Nike Air Max Plus OG', 'Hot damn! Better than gold and more sensory stimulating than grandma\'s raspberry pie.', 6, 1, NULL, '2025-01-24 08:44:27', '2025-01-24 08:44:27', '[{\"product_size\":\"40\",\"product_price\":\"180.00\",\"product_qty\":\"10\"},{\"product_size\":\"41\",\"product_price\":\"180.00\",\"product_qty\":\"5\"},{\"product_size\":\"39\",\"product_price\":\"180.00\",\"product_qty\":\"5\"}]', 1, '5', '0', 1, 1, 0),
(15, 'Nike Blazer Mid \'77 Vintage', 'In the ‘70s, Nike was the new shoe on the block. So new in fact, we were still breaking into the basketball scene and testing prototypes on the feet of our local team.', 6, 1, NULL, '2025-01-24 08:46:48', '2025-01-24 08:46:48', '[{\"product_size\":\"40\",\"product_price\":\"105.00\",\"product_qty\":\"20\"}]', 1, '5', '0', 1, 1, 1),
(16, 'Nike Blazer Low Pro Club', 'Sleek, simple and never basic. A leather and suede upper softens with wear while remaining durable. Mesh accents add varsity flair.', 6, 1, NULL, '2025-01-24 08:49:39', '2025-01-24 08:49:39', '[{\"product_size\":\"38\",\"product_price\":\"100.00\",\"product_qty\":\"10\"},{\"product_size\":\"39\",\"product_price\":\"100.00\",\"product_qty\":\"10\"},{\"product_size\":\"40\",\"product_price\":\"100.00\",\"product_qty\":\"5\"}]', 1, '5', '0', 1, 1, 1),
(17, 'Air Jordan 1 Low', 'Inspired by the original that debuted in 1985, the Air Jordan 1 Low offers a clean, classic look that\'s familiar yet always fresh.', 6, 1, '2025-01-24 08:53:05', '2025-01-24 08:52:04', '2025-01-24 08:53:05', '[{\"product_size\":\"40\",\"product_price\":\"115.00\",\"product_qty\":\"20\"}]', 1, '5', '0', 1, 1, 1),
(18, 'Nike Dunk Low Retro', 'You can always count on a classic. The Dunk Low pairs its iconic color blocking with premium materials and plush padding for game-changing comfort that lasts.', 6, 1, NULL, '2025-01-24 08:54:24', '2025-03-27 18:09:31', '[{\"product_size\":\"40\",\"product_price\":\"100.00\",\"product_qty\":\"11\"}]', 1, '5', '9', 1, 1, 1),
(20, 'Nike Dunk High Next Nature', 'Taking design cues from leather jackets and bags, the Dunk High combines bold color blocking and plush padding for game-changing comfort that lasts.', 6, 1, NULL, '2025-01-24 08:57:01', '2025-01-24 08:57:01', '[{\"product_size\":\"38\",\"product_price\":\"130.00\",\"product_qty\":\"10\"}]', 1, '5', '0', 1, 1, 1),
(21, 'Nike Air Force 1 \'07 LV8', 'Comfortable, durable and timeless. The classic ‘80s construction pairs with bold details for style that tracks whether you’re on court or on the go.', 6, 1, NULL, '2025-01-24 08:59:14', '2025-03-27 16:35:27', '[{\"product_size\":\"41\",\"product_price\":\"120.00\",\"product_qty\":\"10\"},{\"product_size\":\"42\",\"product_price\":\"130.00\",\"product_qty\":\"10\"}]', 1, '5', '20', 1, 1, 1),
(22, 'Nike Zoom Vomero 5 SE', 'A combination of breathable and durable materials stands ready for the rigors of your day, while Zoom Air cushioning delivers a smooth ride.', 6, 1, NULL, '2025-01-24 09:02:37', '2025-01-24 09:02:37', '[{\"product_size\":\"41\",\"product_price\":\"160.00\",\"product_qty\":\"10\"},{\"product_size\":\"40\",\"product_price\":\"160.00\",\"product_qty\":\"10\"}]', 1, '4', '0', 0, 1, 0),
(23, 'Nike Cortez Vintage Suede', 'Now with a wider toe area and firmer side panels, you can comfortably wear them day in and day out. Plus, reengineered materials help prevent warping or creasing.', 6, 1, NULL, '2025-01-24 09:04:57', '2025-01-24 09:04:57', '[{\"product_size\":\"38\",\"product_price\":\"100.00\",\"product_qty\":\"30\"}]', 1, '5', '0', 1, 1, 0),
(24, 'PUMA x LAMELO BALL MB.04 Scooby-Doo', 'Zoinks! LaMelo Ball’s signature shoe, the MB.04, gets a groovy redesign based off of everyone’s favorite cartoon car: The Mystery', 8, 1, NULL, '2025-01-24 09:12:58', '2025-01-24 09:12:58', '[{\"product_size\":\"41\",\"product_price\":\"135.00\",\"product_qty\":\"30\"}]', 1, '5', '0', 1, 1, 1),
(25, 'Speedcat OG', 'An icon of racing culture, the PUMA Speedcat has been synonymous with speed, precision, and unparalleled performance for over 25', 8, 1, NULL, '2025-01-24 09:14:15', '2025-01-24 09:14:15', '[{\"product_size\":\"39\",\"product_price\":\"100.00\",\"product_qty\":\"20\"}]', 1, '5', '0', 1, 1, 0),
(26, 'Amplifier', 'Introducing the Amplifier. In the Amplifier Sneakers, you can enjoy performance-worthy design with every step of day-to-day life.', 8, 1, NULL, '2025-01-24 09:15:24', '2025-04-23 02:05:36', '[{\"product_size\":\"40\",\"product_price\":\"70.00\",\"product_qty\":\"10\"}]', 1, '4', '4', 1, 1, 0),
(27, 'Rebound V6', 'Inspired by basketball, the Rebound Low is back to change the game. V6 offers a low-cut silhouette for daily wear on and off the court.', 8, 1, NULL, '2025-01-24 09:16:54', '2025-04-09 08:04:37', '[{\"product_size\":\"40\",\"product_price\":\"70.00\",\"product_qty\":\"23\"},{\"product_size\":\"42\",\"product_price\":\"80.00\",\"product_qty\":\"12\"}]', 1, '5', '15', 1, 1, 0),
(28, 'Viz Runner Repeat', 'Viz Runner\'s stable cushioning will take care of all your running needs.', 8, 1, NULL, '2025-01-24 09:18:12', '2025-01-24 09:18:12', '[{\"product_size\":\"39\",\"product_price\":\"70.00\",\"product_qty\":\"10\"},{\"product_size\":\"38\",\"product_price\":\"70.00\",\"product_qty\":\"10\"}]', 1, '4', '0', 1, 1, 0),
(29, 'PUMA x LAMELO BALL MB.04 Heem', 'Melo is HEEM. LaMelo Ball’s signature shoe, the MB.04, gets a neon redesign inspired by the energy he brings on the court.', 8, 1, NULL, '2025-01-24 09:19:25', '2025-01-24 09:19:25', '[{\"product_size\":\"40\",\"product_price\":\"125.00\",\"product_qty\":\"25\"}]', 1, '5', '0', 1, 1, 0),
(30, 'Scuderia Ferrari Suede XL Hero', 'Rev up your style with PUMA and Scuderia Ferrari\'s latest collaboration.', 8, 1, NULL, '2025-01-24 09:21:26', '2025-01-24 09:21:26', '[{\"product_size\":\"38\",\"product_price\":\"90.00\",\"product_qty\":\"20\"},{\"product_size\":\"39\",\"product_price\":\"90.00\",\"product_qty\":\"20\"},{\"product_size\":\"40\",\"product_price\":\"90.00\",\"product_qty\":\"10\"},{\"product_size\":\"41\",\"product_price\":\"90.00\",\"product_qty\":\"5\"}]', 1, '5', '0', 1, 1, 1),
(31, 'Darter Pro', 'PROFOAM delivers an instant, responsive ride and the engineered mesh upper keeps you cool at high speeds.', 8, 1, NULL, '2025-01-24 09:25:01', '2025-01-24 09:25:01', '[{\"product_size\":\"40\",\"product_price\":\"80.00\",\"product_qty\":\"5\"},{\"product_size\":\"37\",\"product_price\":\"80.00\",\"product_qty\":\"10\"}]', 1, '5', '0', 1, 1, 1),
(32, 'Neutron', 'The all new Neutron brings a fresh design language to our Viz Tech assortment, featuring advanced support and increased foam coverage for all day comfort.', 8, 1, NULL, '2025-01-24 09:26:17', '2025-04-23 02:57:55', '[{\"product_size\":\"39\",\"product_price\":\"80.00\",\"product_qty\":\"8\"}]', 1, '5', '52', 1, 1, 1),
(33, 'Rebound V6', 'V6 offers a low-cut silhouette for daily wear on and off the court, a soft, tumbled leather look on the upper, and colourblocked PUMA branding for impact.', 8, 1, NULL, '2025-01-24 09:27:54', '2025-01-24 09:27:54', '[{\"product_size\":\"39\",\"product_price\":\"70.00\",\"product_qty\":\"10\"},{\"product_size\":\"38\",\"product_price\":\"70.00\",\"product_qty\":\"10\"},{\"product_size\":\"37\",\"product_price\":\"70.00\",\"product_qty\":\"5\"}]', 1, '5', '0', 1, 1, 1),
(34, 'Chuck 70 Glow-In-The-Dark Giraffe Print', 'Roaring with a retro animal print, this Chuck 70 demands to be spotted, anywhere under the sun.', 11, 1, NULL, '2025-01-31 04:30:28', '2025-01-31 04:30:28', '[{\"product_size\":\"38\",\"product_price\":\"95.00\",\"product_qty\":\"30\"}]', 1, '4', '0', 0, 0, 0),
(35, 'Chuck Taylor All Star CX EXP2', 'Explore concrete jungles and urban playgrounds in these iconic high-tops made to keep up.', 11, 1, NULL, '2025-01-31 04:32:47', '2025-01-31 04:32:47', '[{\"product_size\":\"39\",\"product_price\":\"85.00\",\"product_qty\":\"20\"}]', 1, '4', '0', 1, 0, 0),
(36, 'Chuck 70 Canvas', 'The Chuck 70 offers a blank canvas for you to tell your own stories—through style or activity.', 11, 1, NULL, '2025-01-31 04:34:55', '2025-01-31 04:34:55', '[{\"product_size\":\"37\",\"product_price\":\"90.00\",\"product_qty\":\"30\"}]', 1, '3', '0', 1, 0, 0),
(37, 'Chuck 70 Lunar New Year', 'Shed your old look and level up in these premium, Year of the Snake Chucks—Keywords: mysterious, intelligent, charming.', 11, 1, NULL, '2025-01-31 04:37:27', '2025-01-31 04:37:27', '[{\"product_size\":\"40\",\"product_price\":\"105.00\",\"product_qty\":\"20\"},{\"product_size\":\"38\",\"product_price\":\"105.00\",\"product_qty\":\"20\"}]', 1, '4', '0', 1, 0, 0),
(38, 'Chuck 70 Canvas', 'The Chuck 70 offers a blank canvas for you to tell your own stories—through style or activity.', 11, 1, NULL, '2025-01-31 04:39:56', '2025-01-31 04:39:56', '[{\"product_size\":\"38\",\"product_price\":\"85.00\",\"product_qty\":\"30\"}]', 1, '4', '0', 1, 0, 0),
(39, 'CONS x Bobby Dekeyzer One Star Academy Pro', 'the Converse CONS x Bobby Dekeyzer One Star Academy Pro is a timeless take on tradition.', 11, 1, NULL, '2025-01-31 04:42:04', '2025-01-31 04:42:04', '[{\"product_size\":\"39\",\"product_price\":\"90.00\",\"product_qty\":\"40\"}]', 1, '4', '0', 1, 0, 0),
(40, 'CONS AS-1 Pro', 'Only from CONS, a cupsole skate shoe as visionary as its namesake—Alexis Sablone.', 11, 1, NULL, '2025-01-31 04:44:22', '2025-01-31 04:44:22', '[{\"product_size\":\"38\",\"product_price\":\"85.00\",\"product_qty\":\"20\"}]', 1, '4', '0', 1, 0, 0),
(41, 'Pro Blaze Classic Leather & Suede', 'Meet retro sport style with an elevated twist. AKA this Pro Blaze Classic.', 11, 1, NULL, '2025-01-31 04:45:55', '2025-01-31 04:45:55', '[{\"product_size\":\"37\",\"product_price\":\"85.00\",\"product_qty\":\"25\"}]', 1, '4', '0', 1, 0, 0),
(42, 'CONS Fastbreak Pro Leather & Nylon', 'The \'83 hardwood icon recalibrated by CONS for your skateboard', 11, 1, NULL, '2025-01-31 04:47:17', '2025-01-31 04:47:17', '[{\"product_size\":\"40\",\"product_price\":\"80.00\",\"product_qty\":\"30\"}]', 1, '4', '0', 1, 0, 0),
(43, 'Chuck Taylor All Star Malden Street', 'Dress like you shred in mid-top Chucks with skate-inspired materials and details.', 11, 1, NULL, '2025-01-31 04:48:47', '2025-02-28 02:40:38', '[{\"product_size\":\"39\",\"product_price\":\"70.00\",\"product_qty\":\"40\"}]', 1, '4', '0', 1, 0, 0),
(44, 'demo', 'demo', 6, 1, '2025-02-14 17:06:54', '2025-02-14 16:04:33', '2025-02-14 17:06:54', '[{\"product_size\":null,\"product_price\":\"0.00\",\"product_qty\":null}]', 1, '1', '0', 0, 0, 0),
(45, 'heh', 'rh', 9, 1, '2025-02-14 17:06:50', '2025-02-14 16:08:06', '2025-02-14 17:06:50', '[{\"product_size\":null,\"product_price\":\"0.00\",\"product_qty\":null}]', 1, '4', '0', 0, 0, 0),
(46, 'g', 's', 6, 1, '2025-02-14 17:08:45', '2025-02-14 17:08:35', '2025-02-14 17:08:45', '[{\"product_size\":null,\"product_price\":\"0.00\",\"product_qty\":null}]', 1, '3', '0', 0, 0, 0),
(51, 'a', 'a', 5, 1, '2025-03-01 17:14:26', '2025-03-01 12:33:05', '2025-03-01 17:14:26', '[{\"product_size\":\"11\",\"product_price\":\"22.00\",\"product_qty\":\"33\"}]', 1, '2', '0', 1, 1, 0),
(52, 'a', 'aa', 5, 1, '2025-03-01 17:14:18', '2025-03-01 12:55:09', '2025-03-01 17:14:18', '[{\"product_size\":\"66\",\"product_price\":\"55.00\",\"product_qty\":\"44\"}]', 1, '2', '0', 1, 0, 1),
(53, 'a1', 'a1', 7, 1, '2025-03-01 17:14:16', '2025-03-01 12:56:40', '2025-03-01 17:14:16', '[{\"product_size\":\"56\",\"product_price\":\"43.00\",\"product_qty\":\"46\"}]', 1, '2', '0', 1, 1, 0),
(54, 'a2', 'a2', 6, 1, '2025-03-01 17:14:13', '2025-03-01 12:59:31', '2025-03-01 17:14:13', '[{\"product_size\":\"45\",\"product_price\":\"34.00\",\"product_qty\":\"224\"}]', 1, '3', '0', 1, 1, 0),
(56, 'he', 'hr', 6, 1, '2025-03-01 17:14:09', '2025-03-01 13:17:42', '2025-03-01 17:14:09', '[{\"product_size\":\"23\",\"product_price\":\"454.00\",\"product_qty\":\"23\"}]', 1, '4', '0', 1, 1, 0),
(57, 'fdg', 'dfg', 8, 1, '2025-03-01 17:14:02', '2025-03-01 13:24:46', '2025-03-01 17:14:02', '[{\"product_size\":\"32\",\"product_price\":\"435.00\",\"product_qty\":\"23\"}]', 1, '5', '0', 1, 0, 1),
(58, 'Adidas', 'haha', 7, 1, '2025-03-02 09:32:50', '2025-03-01 14:52:29', '2025-03-02 09:32:50', '[{\"product_size\":\"44\",\"product_price\":\"444.00\",\"product_qty\":\"4\"}]', 1, '4', '0', 0, 1, 0),
(59, 'ggg', 'gg', 6, 1, '2025-03-02 09:33:18', '2025-03-01 17:59:36', '2025-03-02 09:33:18', '[{\"product_size\":\"4\",\"product_price\":\"44.00\",\"product_qty\":\"43\"}]', 1, '5', '0', 0, 1, 0),
(60, 'aa', 'aa', 6, 1, '2025-03-02 09:31:27', '2025-03-02 08:48:14', '2025-03-02 09:31:27', '[{\"product_size\":\"32\",\"product_price\":\"342.00\",\"product_qty\":\"22\"}]', 1, '4', '0', 0, 0, 1),
(61, 'a1', 'aaa', 6, 1, '2025-03-02 09:31:19', '2025-03-02 09:29:06', '2025-03-02 09:31:19', '[{\"product_size\":\"342\",\"product_price\":\"44.00\",\"product_qty\":\"3\"}]', 1, '3', '0', 1, 0, 0),
(62, 'a', 'aa', 6, 1, '2025-03-04 06:31:33', '2025-03-02 09:32:13', '2025-03-04 06:31:33', '[{\"product_size\":\"45\",\"product_price\":\"21.00\",\"product_qty\":\"34\"}]', 1, '5', '0', 0, 0, 1),
(63, 'a', '1', 9, 1, '2025-03-04 06:33:30', '2025-03-04 06:33:02', '2025-03-04 06:33:30', '[{\"product_size\":\"2\",\"product_price\":\"23.00\",\"product_qty\":\"23\"}]', 1, '1', '0', 1, 0, 1),
(64, 'a', 'a1', 7, 1, '2025-03-04 16:53:26', '2025-03-04 06:48:11', '2025-03-04 16:53:26', '[{\"product_size\":\"23\",\"product_price\":\"212.00\",\"product_qty\":\"22\"}]', 1, '3', '0', 1, 0, 0),
(70, 'aa', 'aa1', 7, 1, '2025-03-04 16:53:29', '2025-03-04 07:37:48', '2025-03-04 16:53:29', '[{\"product_size\":\"1\",\"product_price\":\"1.00\",\"product_qty\":\"1\"},{\"product_size\":\"21\",\"product_price\":\"2.00\",\"product_qty\":\"2\"}]', 1, '4', '0', 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_galleries`
--

CREATE TABLE `product_galleries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `images` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `product_galleries`
--

INSERT INTO `product_galleries` (`id`, `product_id`, `images`, `created_at`, `updated_at`) VALUES
(1, 1, '[\"2024-11-25-6743ece1a145f.png\",\"2024-11-25-6743ece6179f8.png\"]', '2024-11-24 20:20:10', '2024-11-24 20:20:10'),
(2, 2, '[\"2024-11-25-6743ee200a8ae.png\",\"2024-11-25-6743ee253fafb.png\"]', '2024-11-24 20:25:30', '2024-11-27 20:35:52'),
(3, 10, '[\"2024-11-28-6747e4e150a46.png\",\"2024-11-28-6747e4e891b98.png\",\"2024-11-28-674823e4a89c3.png\"]', '2024-11-27 20:35:10', '2024-11-28 01:03:53'),
(4, 11, '[\"2024-12-08-67552d6ecc95d.png\",\"2024-12-08-67552d6eccc13.png\",\"2024-12-08-67552d6ecce9a.png\"]', '2024-12-07 22:15:35', '2025-01-05 00:29:53'),
(5, 12, '[\"2025-01-24-6793b2d258935.png\"]', '2025-01-24 08:33:42', '2025-04-11 17:07:42'),
(6, 13, '[\"2025-01-24-6793b46025f35.png\"]', '2025-01-24 08:40:20', '2025-01-24 08:40:20'),
(7, 14, '[\"2025-01-24-6793b55639754.png\"]', '2025-01-24 08:44:27', '2025-01-24 08:44:27'),
(8, 15, '[\"2025-01-24-6793b5c112021.png\",\"2025-01-24-6793b5e37f539.png\"]', '2025-01-24 08:46:48', '2025-01-24 08:46:48'),
(9, 16, '[\"2025-01-24-6793b68b04f66.png\",\"2025-01-24-6793b68d64ad6.png\"]', '2025-01-24 08:49:39', '2025-01-24 08:49:39'),
(10, 17, '[]', '2025-01-24 08:52:04', '2025-01-24 08:52:15'),
(11, 18, '[\"2025-01-24-6793b7aa5824a.png\",\"2025-01-24-6793b7ac12a95.png\"]', '2025-01-24 08:54:24', '2025-01-24 08:54:24'),
(12, 20, '[\"2025-01-24-6793b82bca381.png\"]', '2025-01-24 08:57:01', '2025-01-24 08:57:01'),
(13, 21, '[\"2025-01-24-6793b8c93f54d.png\",\"2025-01-24-6793b8cb10022.png\",\"2025-01-24-6793b8ccc2d77.png\"]', '2025-01-24 08:59:14', '2025-01-24 08:59:14'),
(14, 22, '[\"2025-01-24-6793b9903698b.png\",\"2025-01-24-6793b9925a98b.png\",\"2025-01-24-6793b9944f144.png\",\"2025-01-24-6793b99640f25.png\"]', '2025-01-24 09:02:37', '2025-01-24 09:02:37'),
(15, 23, '[\"2025-01-24-6793ba2346dda.png\",\"2025-01-24-6793ba258565a.png\"]', '2025-01-24 09:04:57', '2025-01-24 09:04:57'),
(16, 24, '[\"2025-01-24-6793bc05dcad7.png\"]', '2025-01-24 09:12:58', '2025-01-24 09:12:58'),
(17, 25, '[\"2025-01-24-6793bc528ef5a.png\"]', '2025-01-24 09:14:15', '2025-01-24 09:14:15'),
(18, 26, '[\"2025-01-24-6793bc98541d2.png\"]', '2025-01-24 09:15:24', '2025-01-24 09:15:24'),
(19, 27, '[\"2025-01-24-6793bcf3015e6.png\"]', '2025-01-24 09:16:54', '2025-04-10 07:09:18'),
(20, 28, '[\"2025-01-24-6793bd39c4450.png\"]', '2025-01-24 09:18:12', '2025-01-24 09:18:12'),
(21, 29, '[\"2025-01-24-6793bd86506e4.png\"]', '2025-01-24 09:19:25', '2025-01-24 09:19:25'),
(22, 30, '[\"2025-01-24-6793bdfde9a65.png\"]', '2025-01-24 09:21:26', '2025-01-24 09:21:26'),
(23, 31, '[\"2025-01-24-6793bebaa49c0.png\",\"2025-01-24-6793bebc79c54.png\"]', '2025-01-24 09:25:01', '2025-01-24 09:25:01'),
(24, 32, '[\"2025-01-24-6793bf25c71ce.png\"]', '2025-01-24 09:26:17', '2025-01-24 09:26:17'),
(25, 33, '[\"2025-01-24-6793bf8572250.png\"]', '2025-01-24 09:27:54', '2025-01-24 09:27:54'),
(26, 34, '[\"2025-01-31-679cb44fdc294.png\"]', '2025-01-31 04:30:28', '2025-01-31 04:30:28'),
(27, 35, '[\"2025-01-31-679cb4da41856.png\"]', '2025-01-31 04:32:47', '2025-01-31 04:32:47'),
(28, 36, '[\"2025-01-31-679cb55bedf52.png\"]', '2025-01-31 04:34:55', '2025-01-31 04:34:55'),
(29, 37, '[\"2025-01-31-679cb5ed93eff.png\"]', '2025-01-31 04:37:27', '2025-01-31 04:37:27'),
(30, 38, '[\"2025-01-31-679cb68831d56.png\"]', '2025-01-31 04:39:56', '2025-01-31 04:39:56'),
(31, 39, '[\"2025-01-31-679cb70881de8.png\"]', '2025-01-31 04:42:04', '2025-01-31 04:42:04'),
(32, 40, '[\"2025-01-31-679cb791add4e.png\"]', '2025-01-31 04:44:22', '2025-01-31 04:44:22'),
(33, 41, '[\"2025-01-31-679cb7ef44dc4.png\"]', '2025-01-31 04:45:55', '2025-01-31 04:45:55'),
(34, 42, '[\"2025-01-31-679cb84087315.png\"]', '2025-01-31 04:47:17', '2025-01-31 04:47:17'),
(35, 43, '[\"2025-01-31-679cb89c0f6fc.png\"]', '2025-01-31 04:48:47', '2025-02-17 17:12:21'),
(36, 44, '[\"2025-02-14-67af698333082.png\"]', '2025-02-14 16:04:33', '2025-02-14 16:04:33'),
(37, 45, '[\"2025-02-14-67af6a5ab4383.png\"]', '2025-02-14 16:08:06', '2025-02-14 16:08:06'),
(38, 46, '[\"2025-02-15-67af788e67f59.png\"]', '2025-02-14 17:08:35', '2025-02-14 17:08:35'),
(39, 51, '[\"2025-03-01-67c2fe7d29d02.png\"]', '2025-03-01 12:33:05', '2025-03-01 12:33:05'),
(40, 52, '[\"2025-03-01-67c303997385b.png\"]', '2025-03-01 12:55:09', '2025-03-01 12:55:09'),
(41, 53, '[\"2025-03-01-67c304049cdb0.png\"]', '2025-03-01 12:56:40', '2025-03-01 12:56:40'),
(42, 54, '[\"2025-03-01-67c304afe8f37.png\"]', '2025-03-01 12:59:31', '2025-03-01 12:59:31'),
(43, 56, '[\"2025-03-01-67c308ce00250.png\",\"2025-03-01-67c308d537e8e.png\"]', '2025-03-01 13:17:43', '2025-03-01 13:17:43'),
(44, 57, '[\"2025-03-01-67c30a9a7baf1.png\",\"2025-03-01-67c30a9a7bd24.png\"]', '2025-03-01 13:24:46', '2025-03-01 13:24:46'),
(45, 58, '[\"2025-03-02-67c34a3be7899.png\"]', '2025-03-01 14:52:29', '2025-03-01 17:58:35'),
(46, 59, '[\"2025-03-02-67c42454b495c.png\"]', '2025-03-01 17:59:36', '2025-03-02 09:26:49'),
(47, 60, '[\"2025-03-02-67c4241d2be6d.png\",\"2025-03-02-67c4241d2c0a7.png\"]', '2025-03-02 08:48:14', '2025-03-02 09:26:03'),
(48, 61, '[]', '2025-03-02 09:29:06', '2025-03-02 09:30:30'),
(49, 62, '[\"2025-03-04-67c69bbf7580d.png\",\"2025-03-04-67c69bbf7627b.png\"]', '2025-03-02 09:32:13', '2025-03-04 06:20:52'),
(50, 63, '[\"2025-03-04-67c69e9d42937.png\",\"2025-03-04-67c69e9d42b8c.png\",\"2025-03-04-67c69e9d42dcb.png\",\"2025-03-04-67c69e9d42fe7.png\"]', '2025-03-04 06:33:02', '2025-03-04 06:33:03'),
(51, 64, '[\"2025-03-04-67c6a22373528.png\"]', '2025-03-04 06:48:11', '2025-03-04 06:48:11'),
(52, 70, '[\"2025-03-04-67c6bd6bb947b.png\",\"2025-03-04-67c6bd9fe8bc2.png\",\"2025-03-04-67c6bd9fe8df4.png\",\"2025-03-04-67c6be496124c.png\",\"2025-03-04-67c6be496143f.png\"]', '2025-03-04 07:37:49', '2025-03-04 08:57:29');

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) NOT NULL,
  `banner` varchar(191) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `description` varchar(191) DEFAULT NULL,
  `discount_type` enum('percent','amount') DEFAULT NULL,
  `percent` varchar(191) DEFAULT NULL,
  `amount` decimal(11,2) DEFAULT 0.00,
  `promotion_type` enum('brand','product') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`id`, `title`, `banner`, `status`, `created_at`, `updated_at`, `start_date`, `end_date`, `description`, `discount_type`, `percent`, `amount`, `promotion_type`) VALUES
(7, 'Chinese New Year', NULL, 1, '2025-01-26 05:27:56', '2025-01-26 05:27:56', '2025-01-26', '2025-01-31', 'promotion for Chinese New Year', 'amount', NULL, 30.00, 'product'),
(8, 'demo', NULL, 1, '2025-04-12 13:41:30', '2025-04-12 14:41:50', '2025-04-12', '2025-04-23', 'demo', 'percent', '20', NULL, 'brand');

-- --------------------------------------------------------

--
-- Table structure for table `promotion_brand`
--

CREATE TABLE `promotion_brand` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `promotion_id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `promotion_brand`
--

INSERT INTO `promotion_brand` (`id`, `promotion_id`, `brand_id`, `created_at`, `updated_at`) VALUES
(1, 8, 5, NULL, NULL),
(2, 8, 6, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `promotion_galleries`
--

CREATE TABLE `promotion_galleries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `promotion_id` bigint(20) UNSIGNED NOT NULL,
  `images` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `promotion_galleries`
--

INSERT INTO `promotion_galleries` (`id`, `promotion_id`, `images`, `created_at`, `updated_at`) VALUES
(1, 7, '[\"2025-01-26-6795c7d6e81f8.png\",\"2025-01-26-6795c7d6e866a.png\"]', '2025-01-26 05:27:56', '2025-01-26 05:27:56'),
(2, 8, '[\"2025-04-12-67fa6d826a289.webp\"]', '2025-04-12 13:41:30', '2025-04-12 13:41:30');

-- --------------------------------------------------------

--
-- Table structure for table `promotion_product`
--

CREATE TABLE `promotion_product` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `promotion_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `promotion_product`
--

INSERT INTO `promotion_product` (`id`, `promotion_id`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 7, 1, NULL, NULL),
(2, 7, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `guard_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', NULL, NULL),
(7, 'Employee', 'web', '2024-02-19 23:54:46', '2024-11-09 14:31:45');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 7),
(2, 1),
(3, 1),
(4, 1),
(14, 7),
(15, 7),
(16, 7);

-- --------------------------------------------------------

--
-- Table structure for table `shoessliders`
--

CREATE TABLE `shoessliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) NOT NULL,
  `image` varchar(191) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `shoes_sliders`
--

CREATE TABLE `shoes_sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) NOT NULL,
  `image` varchar(191) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `shoes_sliders`
--

INSERT INTO `shoes_sliders` (`id`, `title`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Shoes Slider 1', '2025-03-27-67e520ca62147.webp', 1, '2025-01-20 03:46:26', '2025-01-20 03:46:26'),
(2, 'Shoes Slider 2', '2025-03-27-67e520deb79ff.webp', 1, '2025-01-20 03:46:52', '2025-01-20 03:46:52'),
(3, 'Shoes Slider 3', '2025-03-27-67e520fe3b08d.webp', 1, '2025-01-20 03:47:17', '2025-01-20 03:47:17');

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE `translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `translationable_type` varchar(191) DEFAULT NULL,
  `translationable_id` bigint(20) UNSIGNED DEFAULT NULL,
  `locale` varchar(191) DEFAULT NULL,
  `key` varchar(191) DEFAULT NULL,
  `value` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `translations`
--

INSERT INTO `translations` (`id`, `translationable_type`, `translationable_id`, `locale`, `key`, `value`, `created_at`, `updated_at`) VALUES
(2, 'App\\Models\\Slider', 3, 'kh', 'name', 'PHOUM CHAUFEA RESORT', NULL, NULL),
(3, 'App\\Models\\Slider', 3, 'kh', 'short_des', 'Experience the best of Cambodia,  both past and present', NULL, NULL),
(4, 'App\\Models\\HomeStayAmenity', 3, 'kh', 'value', '[]', NULL, NULL),
(5, 'App\\Models\\HomeStayAmenity', 3, 'kh', 'title', 'Special Package', NULL, NULL),
(9, 'App\\Models\\HomeStayAmenity', 4, 'kh', 'value', '[]', NULL, NULL),
(27, 'App\\Models\\Room', 14, 'kh', 'checkin', '[]', NULL, NULL),
(28, 'App\\Models\\Room', 14, 'kh', 'checkout', '[]', NULL, NULL),
(29, 'App\\Models\\Room', 15, 'kh', 'checkin', '[]', NULL, NULL),
(30, 'App\\Models\\Room', 15, 'kh', 'checkout', '[]', NULL, NULL),
(31, 'App\\Models\\Room', 16, 'kh', 'checkin', '[]', NULL, NULL),
(32, 'App\\Models\\Room', 16, 'kh', 'checkout', '[]', NULL, NULL),
(33, 'App\\Models\\Room', 17, 'kh', 'checkin', '[]', NULL, NULL),
(34, 'App\\Models\\Room', 17, 'kh', 'checkout', '[]', NULL, NULL),
(35, 'App\\Models\\Room', 18, 'kh', 'checkin', '[]', NULL, NULL),
(36, 'App\\Models\\Room', 18, 'kh', 'checkout', '[]', NULL, NULL),
(39, 'App\\Models\\HomeStayAmenity', 4, 'kh', 'title', 'Amenity', NULL, NULL),
(42, 'App\\Models\\Room', 3, 'kh', 'checkin', '[{\"title\":\"Check-in 9:00 AM-Anytime\"},{\"title\":\"Early check-in subject to availability\"}]', NULL, NULL),
(43, 'App\\Models\\Room', 3, 'kh', 'checkout', '[{\"title\":\"Check-out before noon\"},{\"title\":\"Express check-out\"}]', NULL, NULL),
(44, 'App\\Models\\RatePlan', 1, 'kh', 'title', 'Rate Plan Single Stay', NULL, NULL),
(45, 'App\\Models\\RatePlan', 1, 'kh', 'description', 'Rate Plan Single Stay', NULL, NULL),
(49, 'App\\Models\\Room', 3, 'kh', 'title', 'Chaufea Villa', NULL, NULL),
(50, 'App\\Models\\Room', 3, 'kh', 'special_note', 'Morem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vulputate libero et velit int erdum, ac aliquet odio mattis. Class aptent taciti sociosqu ad litora torquent per conubia  nostra, per inceptos himenaeos. Curabitur tempus urna at turpis condimentum lobortis.  Ut commodo efficitur neque.', NULL, NULL),
(51, 'App\\Models\\Room', 3, 'kh', 'description', '<p class=\"MsoNormal\"><span style=\"background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Chaufea Villa</span><span style=\"background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">&nbsp;or Lok Mchas Villa</span><span style=\"background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">, a luxurious two-story retreat nestled in the heart of Phoum Chaufea. This exquisite villa boasts six private bedrooms, two maid bedrooms, and nine bathrooms, providing ample space for relaxation and comfort. With two fully equipped kitchens, an executive meeting room, a library, and a meditation room, Chaufea Villa offers the perfect blend of convenience and sophistication.&nbsp;</span><span style=\"background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">The generous terrace of Chaufea Villa offers breathtaking panoramic views of the surrounding landscape, allowing guests to immerse themselves in the beauty of Phoum Chaufea. Whether you are hosting a private function or seeking a romantic getaway, Chaufea Villa is the ideal choice for those looking for a luxurious and elegant retreat.&nbsp;</span><span style=\"background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">With its Khmer-inspired design and modern amenities, Chaufea Villa is the perfect setting for a luxury wedding celebration or a romantic escape. Indulge in the opulence of this magnificent villa and create unforgettable memories in the serene surroundings of Phoum Chaufea.</span><br><br><span style=\"background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Experience the epitome of luxury at Chaufea Villa, where every detail is designed to exceed your expectations. Book your stay today and discover the beauty and elegance of this exceptional retreat.</span></p><p><span style=\"font-weight: bolder;\"><span style=\"font-family: &quot;Times New Roman&quot;;\">FEATURES</span></span></p><p><span style=\"font-family: &quot;Times New Roman&quot;;\">Outdoor fans&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span><span style=\"font-size: 0.875rem; font-family: &quot;Times New Roman&quot;;\">Work/writing desk</span></p><p><span style=\"font-family: &quot;Times New Roman&quot;;\">Kitchenette with full refrigerators&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span><span style=\"font-size: 0.875rem; font-family: &quot;Times New Roman&quot;;\">Indoor rain showers</span></p><p><span style=\"font-family: &quot;Times New Roman&quot;;\">Fully stocked mini bars&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span><span style=\"font-size: 0.875rem; font-family: &quot;Times New Roman&quot;;\">Iron/Ironing board (on request)</span></p><p><span style=\"font-family: &quot;Times New Roman&quot;;\">Exclusive outdoor bathrooms&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</span><span style=\"font-size: 0.875rem; font-family: &quot;Times New Roman&quot;;\">Dinning area</span></p><p><span style=\"font-family: &quot;Times New Roman&quot;;\">Daily Mineral water&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span><span style=\"font-size: 0.875rem; font-family: &quot;Times New Roman&quot;;\">Cooking utensils</span></p><p><span style=\"font-family: &quot;Times New Roman&quot;;\">High Speed Internet Wifi&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span><span style=\"font-size: 0.875rem; font-family: &quot;Times New Roman&quot;;\">Terrace</span></p><p><span style=\"font-family: &quot;Times New Roman&quot;;\">6 55\" Smart TVs&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span><span style=\"font-size: 0.875rem; font-family: &quot;Times New Roman&quot;;\">Living room/sitting area</span></p><p><span style=\"font-family: &quot;Times New Roman&quot;;\">Walking closeth&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</span><span style=\"font-size: 0.875rem; font-family: &quot;Times New Roman&quot;;\">Coffe/tea making facilities</span></p>', NULL, NULL),
(56, 'App\\Models\\Blog', 1, 'kh', 'title', 'The best restaurant in  siem reap only Phoum Chaufea resort', NULL, NULL),
(371, 'App\\Models\\Brand', 4, 'kh', 'name', 'Louis Vuitton', NULL, NULL),
(372, 'App\\Models\\Brand', 5, 'kh', 'name', 'Reebok', NULL, NULL),
(373, 'App\\Models\\Product', 1, 'kh', 'name', 'Adidas Samba', NULL, NULL),
(374, 'App\\Models\\Product', 1, 'kh', 'description', 'The Adidas Samba, born in 1950 as a soccer shoe, is now a global style icon loved for its versatility and timeless design.', NULL, NULL),
(375, 'App\\Models\\Product', 2, 'kh', 'name', 'Converse', NULL, NULL),
(376, 'App\\Models\\Product', 2, 'kh', 'description', 'Converse, founded in 1908, is an iconic footwear brand known for its timeless Chuck Taylor All Star sneakers.', NULL, NULL),
(377, 'App\\Models\\Brand', 15, 'kh', 'name', 'sonic', NULL, NULL),
(378, 'App\\Models\\Product', 43, 'kh', 'name', 'Chuck Taylor All Star Malden Street', NULL, NULL),
(379, 'App\\Models\\Product', 43, 'kh', 'description', 'Dress like you shred in mid-top Chucks with skate-inspired materials and details.', NULL, NULL),
(380, 'App\\Models\\BusinessSetting', 3, 'en', 'company_name', 'THE SNEAKER STORE', NULL, NULL),
(381, 'App\\Models\\BusinessSetting', 3, 'kh', 'company_name', 'THE SNEAKER STORE', NULL, NULL),
(382, 'App\\Models\\BusinessSetting', 7, 'en', 'copy_right_text', '© Copyright 2024 by The Sneaker Store', NULL, NULL),
(383, 'App\\Models\\BusinessSetting', 7, 'kh', 'copy_right_text', '© Copyright 2024 by The Sneaker Store', NULL, NULL),
(384, 'App\\Models\\BusinessSetting', 6, 'en', 'company_address', 'Siem Reap, Cambodia', NULL, NULL),
(385, 'App\\Models\\BusinessSetting', 6, 'kh', 'company_address', 'Siem Reap, Cambodia', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `email` varchar(191) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `first_name` varchar(191) NOT NULL,
  `last_name` varchar(191) NOT NULL,
  `gender` enum('male','female') DEFAULT 'male',
  `phone` varchar(191) DEFAULT NULL,
  `telegram` varchar(191) DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `user_id` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `first_name`, `last_name`, `gender`, `phone`, `telegram`, `image`, `deleted_at`, `user_id`) VALUES
(1, 'superadmin', 'admin@gmail.com', NULL, '$2y$10$78nrUBLUIqOO0lWLNWCCde1Njlk4Vdq90Bh6SaevJFCIDJr0xGe5K', 'DOcv2GElVejdBOJPcHjOamMB1tes1RMGSuO2wN54dbSQFJtipFBUJUMmQi9s', '2023-09-07 03:11:02', '2025-03-30 08:51:49', 'Admin', 'Super', 'male', '010679106', '010679106', '2025-03-30-67e906230eaf7.webp', NULL, NULL),
(2, 'smith08', 'jonhsmith123@gmail.com', NULL, '$2y$10$ImOK/eWOnQQo/lvs4pY6Ruf3kWitZkYxMeiwgxwMbR7CtRtyRg0k.', NULL, '2024-02-05 00:28:03', '2025-02-16 08:55:55', 'Jonh', 'Smith', 'male', '0957878709', '0957878709', NULL, '2025-02-16 08:55:55', NULL),
(3, 'testing@gmail.com', 'testing@gmail.com', NULL, '$2y$10$3pqP3Us2mVcWsdgfY8l1..WTkIhMpDhmOHMjpe1GOsuAi6NpJmmI2', NULL, '2024-02-20 01:59:20', '2025-01-30 13:21:17', 'user', 'test', 'male', '0877777888', '0877767767', '2025-01-05-677aa530a6721.png', NULL, NULL),
(4, 'Demo1', 'demo1@gmail.com', NULL, '$2y$10$NwNNquGVHlo4Jmj/xaDSg.R7yFQczwm3/6lZBRnqb65tLtuOuYJfy', NULL, '2025-02-13 12:19:00', '2025-02-16 10:05:23', 'Demo', '1', 'male', '123456', '123', NULL, '2025-02-16 10:05:23', NULL),
(5, 'Demo2', 'demo2@gmail.com', NULL, '$2y$10$1vtoHTcshptHBXhDL97vDOWiIbTnXN2Yg80TFvehNRz5v195pQi/a', NULL, '2025-02-13 12:19:36', '2025-02-17 14:02:12', 'Demo', '2', 'male', '345678', '345678', '2025-02-17-67b3416300d6f.png', NULL, NULL),
(6, NULL, 'demo3@gmail.com', NULL, '$2y$10$5F1/.D6t8QeQIO/sV/Pt5uLehXrxxhFMAYDH9U5akrvFpBmWby3hu', NULL, '2025-02-13 13:32:00', '2025-02-17 17:20:58', 'demo', '3', 'male', '123456', '234567', NULL, '2025-02-17 17:20:58', NULL),
(7, NULL, 'demo4@gmail.com', NULL, '$2y$10$TBuUpQXKUz6IcHKs8rf4NetiJ1E9EwfpvvFgP9IspUy4Nq7TG9bc.', NULL, '2025-02-13 13:35:07', '2025-02-17 17:17:53', 'demo', '4', 'male', '345678', '234567', NULL, '2025-02-17 17:17:53', NULL),
(8, NULL, 'demo5@gmail.com', NULL, '$2y$10$Hbcn.JfZHBL7V3YDyvLGG.RDzdX.KlP7Uo4x5xmE0eMttsJV83xh.', NULL, '2025-02-16 16:25:21', '2025-02-16 16:25:21', 'demo', '5', 'male', '22143', '2343242', NULL, NULL, NULL),
(9, NULL, 'demo6@gmail.com', NULL, '$2y$10$SFlZ9jo60.4cQ7p/hv.q0uuTJdl83WfawGyRo5cjt57g6S/eGKn2a', NULL, '2025-02-16 16:39:16', '2025-02-16 16:39:16', 'Demo', '6', 'male', '096 493 0590', '1234567', NULL, NULL, NULL),
(10, NULL, 'china@gmail.com', NULL, '$2y$10$kU7skQhePnMPMmwZwfuBpuxN1JBug.nQ1vvsQxfYTNJCdxX4ljC2e', NULL, '2025-02-16 16:49:56', '2025-02-16 16:49:56', 'China', 'Ing', 'male', '012 345 678', '012 345 678', '2025-02-16-67b21731695a5.png', NULL, NULL),
(11, NULL, 'demo7@gmail.com', NULL, '$2y$10$0CoLcL1LqBpH.aveMNrmxOASpHsbSspExI7S3rk20KCmVo28wY4Wu', NULL, '2025-02-16 16:52:28', '2025-02-16 16:52:28', 'Demo', '7', 'male', '23532', '324', '2025-02-16-67b217c86ab2d.png', NULL, NULL),
(12, NULL, 'demo8@gmail.com', NULL, '$2y$10$FNuUAWoDxZhwoRWXzWMtremjz4PnOSCzXQK85fRjDhxujV5wNv.lG', NULL, '2025-02-16 16:56:10', '2025-02-17 17:20:48', 'Demo', '8', 'male', '096 493 0590', '345678', '2025-02-17-67b33ee48209f.png', '2025-02-17 17:20:48', NULL),
(13, NULL, 'demo9@gmail.com', NULL, '$2y$10$8rWUI5M0SC/x39D0IXRTguKbmXQCxgDppA6zW0JWlVQtNZJR4VGvW', NULL, '2025-02-16 17:02:06', '2025-02-16 17:02:06', 'demo', '9', 'male', '6436543', '365466', '2025-02-17-67b21a0752275.png', NULL, NULL),
(14, NULL, 'demo10@gmail.com', NULL, '$2y$10$9weQKSerzv/VfqdSLBJ8zeZVtAgoz0FSaGiIF5nNeS6c7e4Eb2gy2', NULL, '2025-02-16 17:11:07', '2025-02-17 12:39:15', 'Demo', '11', 'male', '345678', '1234567', '2025-02-17-67b2291fda145.png', NULL, NULL),
(15, NULL, 'zoro@gmail.com', NULL, '$2y$10$ODzFYqvoXfs6UibscCLsde4WbzkfNesxjSeRqrto6hN9X3elCePA6', NULL, '2025-02-17 16:52:10', '2025-02-17 16:52:10', 'Zo', 'Ro', 'male', '73264', '83468', '2025-02-17-67b36938b022b.png', NULL, NULL),
(16, NULL, 'demo111@gmail.com', NULL, '$2y$10$UjTphgzhDOxOaRnDb7RFHunan.xu8AxXzibkfKFRLFNyVPafWul4u', NULL, '2025-02-28 14:39:37', '2025-02-28 14:39:37', 'Demo', '111', 'male', '0123456789', '0123456789', '2025-02-28-67c1caa772f4d.png', NULL, NULL),
(17, NULL, 'goku@gmail.com', NULL, '$2y$10$bfHIP4WcZiC82EqPoMkAN.UY4LfC9BDGb3PSuNR.ReLLpR33BdXVy', NULL, '2025-02-28 14:40:28', '2025-02-28 14:40:28', 'dg', 'wte', 'male', '23453', '235', '2025-02-28-67c1cacc3539b.png', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `baners`
--
ALTER TABLE `baners`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `business_settings`
--
ALTER TABLE `business_settings`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`) USING BTREE;

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `jobs_queue_index` (`queue`) USING BTREE;

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`) USING BTREE,
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`) USING BTREE;

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`) USING BTREE,
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`) USING BTREE;

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`) USING BTREE;

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`) USING BTREE;

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `oauth_clients_user_id_index` (`user_id`) USING BTREE;

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`) USING BTREE;

--
-- Indexes for table `onboards`
--
ALTER TABLE `onboards`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `orders_customer_id_foreign` (`customer_id`) USING BTREE;

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `order_details_order_id_foreign` (`order_id`) USING BTREE,
  ADD KEY `order_details_product_id_foreign` (`product_id`) USING BTREE,
  ADD KEY `order_details_brand_id_foreign` (`brand_id`) USING BTREE;

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`) USING BTREE;

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`) USING BTREE;

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`) USING BTREE,
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`) USING BTREE;

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `product_galleries`
--
ALTER TABLE `product_galleries`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `promotion_brand`
--
ALTER TABLE `promotion_brand`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `promotion_brand_promotion_id_foreign` (`promotion_id`) USING BTREE,
  ADD KEY `promotion_brand_brand_id_foreign` (`brand_id`) USING BTREE;

--
-- Indexes for table `promotion_galleries`
--
ALTER TABLE `promotion_galleries`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `promotion_product`
--
ALTER TABLE `promotion_product`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `promotion_product_promotion_id_foreign` (`promotion_id`) USING BTREE,
  ADD KEY `promotion_product_product_id_foreign` (`product_id`) USING BTREE;

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`) USING BTREE;

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`) USING BTREE,
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`) USING BTREE;

--
-- Indexes for table `shoessliders`
--
ALTER TABLE `shoessliders`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `shoes_sliders`
--
ALTER TABLE `shoes_sliders`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `baners`
--
ALTER TABLE `baners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `business_settings`
--
ALTER TABLE `business_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `onboards`
--
ALTER TABLE `onboards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `product_galleries`
--
ALTER TABLE `product_galleries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `promotion_brand`
--
ALTER TABLE `promotion_brand`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `promotion_galleries`
--
ALTER TABLE `promotion_galleries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `promotion_product`
--
ALTER TABLE `promotion_product`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `shoessliders`
--
ALTER TABLE `shoessliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shoes_sliders`
--
ALTER TABLE `shoes_sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `translations`
--
ALTER TABLE `translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=386;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `promotion_brand`
--
ALTER TABLE `promotion_brand`
  ADD CONSTRAINT `promotion_brand_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `promotion_brand_promotion_id_foreign` FOREIGN KEY (`promotion_id`) REFERENCES `promotions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `promotion_product`
--
ALTER TABLE `promotion_product`
  ADD CONSTRAINT `promotion_product_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `promotion_product_promotion_id_foreign` FOREIGN KEY (`promotion_id`) REFERENCES `promotions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
