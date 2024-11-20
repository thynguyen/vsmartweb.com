-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Nov 21, 2024 at 12:04 AM
-- Server version: 5.7.26
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sql_vsmartweb_co`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `log_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `causer_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `properties` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2017_12_11_115853_create_seo_pages_table', 1),
(3, '2017_12_11_120225_create_seo_page_images_table', 1),
(4, '2017_12_26_123638_add_xml_columns_to_seo_pages_table', 1),
(5, '2018_02_12_123638_add_schema_to_seo_pages_table', 1),
(6, '2018_03_08_123638_add_focus_keyword_to_seo_pages_table', 1),
(7, '2019_01_12_150232_create_vsw_config_table', 1),
(8, '2019_01_14_151152_create_vsw_users_table', 1),
(9, '2019_02_12_163932_create_vsw_menus_table', 1),
(10, '2019_02_26_092246_create_vsw_modules_table', 1),
(11, '2019_03_06_154634_create_vsw_widget_table', 1),
(12, '2019_03_11_223125_create_sessions_table', 1),
(13, '2019_04_04_150752_create_vsw_permissions_table', 1),
(14, '2019_04_07_232114_create_cache_table', 1),
(15, '2019_04_15_165055_create_vsw_language_table', 1),
(16, '2019_05_06_220426_create_vsw_translations_table', 1),
(17, '2019_05_16_143356_create_vsw_funcmod_table', 1),
(18, '2019_05_16_152822_create_vsw_modlayout_table', 1),
(19, '2019_08_14_140504_create_vsw_slugs_table', 1),
(20, '2019_08_19_084011_create_vsw_news_table', 1),
(21, '2019_08_21_081423_add_tags_column_to_seo_pages_table', 1),
(22, '2019_08_22_110548_create_vsw_comments_table', 1),
(23, '2019_10_17_170054_create_activity_log_table', 1),
(24, '2020_03_29_004042_create_vsw_license_table', 1),
(25, '2020_03_30_000202_create_vsw_sliders_table', 1),
(26, '2020_04_03_112231_create_vsw_contact_table', 1),
(27, '2020_04_14_002753_create_jobs_table', 1),
(28, '2020_08_20_095027_create_vsw_pages_table', 1),
(29, '2020_12_18_133753_create_vsw_servicepack_table', 1),
(30, '2020_12_28_105844_create_vsw_user_config_table', 1),
(31, '2021_01_11_094414_create_vsw_interface_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seo_pages`
--

CREATE TABLE `seo_pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `object` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `object_id` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `robot_index` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'noindex',
  `robot_follow` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'nofollow',
  `canonical_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_source` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_source` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `change_frequency` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'monthly',
  `priority` double NOT NULL DEFAULT '0.5',
  `schema` longtext COLLATE utf8mb4_unicode_ci,
  `focus_keyword` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seo_page_images`
--

CREATE TABLE `seo_page_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `page_id` int(10) UNSIGNED NOT NULL,
  `src` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `caption` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vsw_comments`
--

CREATE TABLE `vsw_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `item_id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `vote` tinyint(4) DEFAULT NULL,
  `module` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vsw_config`
--

CREATE TABLE `vsw_config` (
  `lang` char(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `config_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `config_value` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vsw_config`
--

INSERT INTO `vsw_config` (`lang`, `module`, `config_name`, `config_value`) VALUES
('sys', 'global', 'admintheme', 'admindefault'),
('sys', 'global', 'extend_footer', NULL),
('sys', 'global', 'extend_head', NULL),
('sys', 'global', 'site_favicon', ''),
('sys', 'global', 'site_latitude', NULL),
('sys', 'global', 'site_logo', ''),
('sys', 'global', 'site_longitude', NULL),
('sys', 'global', 'site_url', ''),
('sys', 'global', 'theme', 'seobin'),
('vi', 'global', 'moddefault', 'Index-Home'),
('vi', 'global', 'site_description', ''),
('vi', 'global', 'site_keywords', NULL),
('vi', 'global', 'sitename', '');

-- --------------------------------------------------------

--
-- Table structure for table `vsw_funcmod`
--

CREATE TABLE `vsw_funcmod` (
  `id` int(10) UNSIGNED NOT NULL,
  `func_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `func_custom_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `in_module` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vsw_language`
--

CREATE TABLE `vsw_language` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locale` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `script` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `native` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `regional` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flag` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `active` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `weight` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vsw_language`
--

INSERT INTO `vsw_language` (`id`, `name`, `locale`, `script`, `native`, `regional`, `flag`, `default`, `active`, `weight`) VALUES
(1, 'Vietnamese', 'vi', 'Latn', 'Tiếng Việt', 'vi_VN', 'vn', 1, 1, 1),
(2, 'English', 'en', 'Latn', 'English', 'en_US', 'us', 0, 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `vsw_license`
--

CREATE TABLE `vsw_license` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `license` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `domain` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'not activated',
  `message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_day` timestamp NULL DEFAULT NULL,
  `expiration_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vsw_modlayout`
--

CREATE TABLE `vsw_modlayout` (
  `id` int(10) UNSIGNED NOT NULL,
  `func_id` int(11) NOT NULL,
  `funcname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `layout` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `theme` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vsw_modules`
--

CREATE TABLE `vsw_modules` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pathmod` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keywords` mediumtext COLLATE utf8mb4_unicode_ci,
  `bgmod` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `groupview` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `theme` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `active` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vsw_permissions`
--

CREATE TABLE `vsw_permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `superadmin` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vsw_permissions`
--

INSERT INTO `vsw_permissions` (`id`, `name`, `superadmin`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 1, '2019-01-08 18:08:43', '2019-01-18 17:06:45'),
(2, 'Admin', 2, '2019-01-08 18:08:43', '2019-01-18 17:06:45'),
(3, 'Landing Page', 0, '2020-10-16 02:16:15', '2020-10-16 02:16:15');

-- --------------------------------------------------------

--
-- Table structure for table `vsw_permissions_roles`
--

CREATE TABLE `vsw_permissions_roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `per_id` int(11) DEFAULT NULL,
  `modules` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `view` tinyint(1) DEFAULT NULL,
  `add` tinyint(1) DEFAULT NULL,
  `delete` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vsw_slugs`
--

CREATE TABLE `vsw_slugs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_id` int(10) UNSIGNED NOT NULL,
  `module` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vsw_translations`
--

CREATE TABLE `vsw_translations` (
  `id` int(10) UNSIGNED NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vsw_users`
--

CREATE TABLE `vsw_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `in_group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `skype` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `youtube` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `answer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '0',
  `last_login` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'vi',
  `online` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vsw_user_config`
--

CREATE TABLE `vsw_user_config` (
  `userid` int(11) NOT NULL,
  `config_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `config_value` text COLLATE utf8mb4_unicode_ci,
  `config_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vsw_versions`
--

CREATE TABLE `vsw_versions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `changelog` text COLLATE utf8mb4_unicode_ci,
  `current` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vsw_vi_contact`
--

CREATE TABLE `vsw_vi_contact` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customerid` int(11) NOT NULL,
  `partid` int(11) DEFAULT NULL,
  `messenger` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `read` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vsw_vi_contact_customer`
--

CREATE TABLE `vsw_vi_contact_customer` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vsw_vi_contact_parts`
--

CREATE TABLE `vsw_vi_contact_parts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vsw_vi_contact_parts_email`
--

CREATE TABLE `vsw_vi_contact_parts_email` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `partid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `sendemail` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vsw_vi_contact_reply`
--

CREATE TABLE `vsw_vi_contact_reply` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `authid` int(11) NOT NULL,
  `contactid` int(11) NOT NULL,
  `messenger` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vsw_vi_interfacepackage`
--

CREATE TABLE `vsw_vi_interfacepackage` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `catid` int(11) NOT NULL,
  `svp_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keyword` text COLLATE utf8mb4_unicode_ci,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vsw_vi_interface_catalogs`
--

CREATE TABLE `vsw_vi_interface_catalogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parentid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keyword` text COLLATE utf8mb4_unicode_ci,
  `lev` int(11) DEFAULT NULL,
  `weight` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vsw_vi_interface_sentiment`
--

CREATE TABLE `vsw_vi_interface_sentiment` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `interfaceid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `sentiment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vsw_vi_menus`
--

CREATE TABLE `vsw_vi_menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `parentid` int(11) DEFAULT NULL,
  `submenu` mediumtext COLLATE utf8mb4_unicode_ci,
  `groupid` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `urltype` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '_self',
  `module` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `route` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `lev` int(11) DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vsw_vi_menus_group`
--

CREATE TABLE `vsw_vi_menus_group` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_items` mediumtext COLLATE utf8mb4_unicode_ci,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vsw_vi_news`
--

CREATE TABLE `vsw_vi_news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keyword` text COLLATE utf8mb4_unicode_ci,
  `active` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `user_id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  `numcat` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vsw_vi_news_catalogs`
--

CREATE TABLE `vsw_vi_news_catalogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parentid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keyword` text COLLATE utf8mb4_unicode_ci,
  `lev` int(11) DEFAULT NULL,
  `weight` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vsw_vi_news_catpost`
--

CREATE TABLE `vsw_vi_news_catpost` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `catid` int(11) NOT NULL,
  `newid` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vsw_vi_news_grouppost`
--

CREATE TABLE `vsw_vi_news_grouppost` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `groupid` int(11) NOT NULL,
  `newid` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vsw_vi_news_groups`
--

CREATE TABLE `vsw_vi_news_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vsw_vi_pages`
--

CREATE TABLE `vsw_vi_pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `groupid` int(11) DEFAULT NULL,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `keyword` text COLLATE utf8mb4_unicode_ci,
  `pagetype` int(11) NOT NULL DEFAULT '1',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `layout` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `userid` int(11) NOT NULL,
  `subdomain` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vsw_vi_pages_content`
--

CREATE TABLE `vsw_vi_pages_content` (
  `id` int(10) UNSIGNED NOT NULL,
  `pageid` int(11) NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vsw_vi_pages_groups`
--

CREATE TABLE `vsw_vi_pages_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keyword` text COLLATE utf8mb4_unicode_ci,
  `weight` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vsw_vi_servicepack`
--

CREATE TABLE `vsw_vi_servicepack` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `listoption` text COLLATE utf8mb4_unicode_ci,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(15,0) NOT NULL DEFAULT '0',
  `price_sale` decimal(15,0) NOT NULL DEFAULT '0',
  `discounts` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `popular` int(11) DEFAULT '0',
  `contact` int(11) DEFAULT '0',
  `weight` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vsw_vi_servicepack_reg`
--

CREATE TABLE `vsw_vi_servicepack_reg` (
  `id` int(10) UNSIGNED NOT NULL,
  `userid` int(11) NOT NULL,
  `svp_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expired_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vsw_vi_servicepack_transaction`
--

CREATE TABLE `vsw_vi_servicepack_transaction` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `userid` int(11) NOT NULL,
  `svp_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(15,0) NOT NULL DEFAULT '0',
  `note` text COLLATE utf8mb4_unicode_ci,
  `transpay_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trans_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trans_ip` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timeout` int(11) DEFAULT '0',
  `readtrans` tinyint(4) NOT NULL DEFAULT '0',
  `expired_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vsw_vi_servicepack_translog`
--

CREATE TABLE `vsw_vi_servicepack_translog` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `transid` int(11) NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `handler` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vsw_vi_sliders`
--

CREATE TABLE `vsw_vi_sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `groupid` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom_class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `weight` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vsw_vi_sliders_group`
--

CREATE TABLE `vsw_vi_sliders_group` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vsw_vi_sliders_temp`
--

CREATE TABLE `vsw_vi_sliders_temp` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sliderid` int(11) NOT NULL,
  `template` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `theme` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vsw_widget`
--

CREATE TABLE `vsw_widget` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `widgetgroup` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `widgetname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `coverwidget` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `theme` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `groupview` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `async` int(11) NOT NULL DEFAULT '1',
  `configwidget` text COLLATE utf8mb4_unicode_ci,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `custom_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom_class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_log_log_name_index` (`log_name`),
  ADD KEY `subject` (`subject_id`,`subject_type`),
  ADD KEY `causer` (`causer_id`,`causer_type`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD UNIQUE KEY `cache_key_unique` (`key`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `seo_pages`
--
ALTER TABLE `seo_pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `seo_pages_path_unique` (`path`),
  ADD KEY `seo_pages_object_index` (`object`),
  ADD KEY `seo_pages_object_id_index` (`object_id`),
  ADD KEY `seo_pages_title_index` (`title`),
  ADD KEY `seo_pages_title_source_index` (`title_source`);

--
-- Indexes for table `seo_page_images`
--
ALTER TABLE `seo_page_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seo_page_images_page_id_foreign` (`page_id`),
  ADD KEY `seo_page_images_src_index` (`src`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD UNIQUE KEY `sessions_id_unique` (`id`);

--
-- Indexes for table `vsw_comments`
--
ALTER TABLE `vsw_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vsw_config`
--
ALTER TABLE `vsw_config`
  ADD UNIQUE KEY `vsw_config_lang_module_config_name_unique` (`lang`,`module`,`config_name`);

--
-- Indexes for table `vsw_funcmod`
--
ALTER TABLE `vsw_funcmod`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vsw_language`
--
ALTER TABLE `vsw_language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vsw_license`
--
ALTER TABLE `vsw_license`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vsw_modlayout`
--
ALTER TABLE `vsw_modlayout`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vsw_modules`
--
ALTER TABLE `vsw_modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vsw_permissions`
--
ALTER TABLE `vsw_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vsw_permissions_roles`
--
ALTER TABLE `vsw_permissions_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vsw_slugs`
--
ALTER TABLE `vsw_slugs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vsw_translations`
--
ALTER TABLE `vsw_translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vsw_users`
--
ALTER TABLE `vsw_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vsw_users_email_unique` (`email`);

--
-- Indexes for table `vsw_user_config`
--
ALTER TABLE `vsw_user_config`
  ADD UNIQUE KEY `vsw_user_config_config_token_unique` (`config_token`);

--
-- Indexes for table `vsw_versions`
--
ALTER TABLE `vsw_versions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vsw_vi_contact`
--
ALTER TABLE `vsw_vi_contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vsw_vi_contact_customer`
--
ALTER TABLE `vsw_vi_contact_customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vsw_vi_contact_parts`
--
ALTER TABLE `vsw_vi_contact_parts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vsw_vi_contact_parts_email`
--
ALTER TABLE `vsw_vi_contact_parts_email`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vsw_vi_contact_reply`
--
ALTER TABLE `vsw_vi_contact_reply`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vsw_vi_interfacepackage`
--
ALTER TABLE `vsw_vi_interfacepackage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vsw_vi_interface_catalogs`
--
ALTER TABLE `vsw_vi_interface_catalogs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vsw_vi_interface_catalogs_parentid_index` (`parentid`);

--
-- Indexes for table `vsw_vi_interface_sentiment`
--
ALTER TABLE `vsw_vi_interface_sentiment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vsw_vi_menus`
--
ALTER TABLE `vsw_vi_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vsw_vi_menus_group`
--
ALTER TABLE `vsw_vi_menus_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vsw_vi_news`
--
ALTER TABLE `vsw_vi_news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vsw_vi_news_catalogs`
--
ALTER TABLE `vsw_vi_news_catalogs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vsw_vi_news_catalogs_parentid_index` (`parentid`);

--
-- Indexes for table `vsw_vi_news_catpost`
--
ALTER TABLE `vsw_vi_news_catpost`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vsw_vi_news_grouppost`
--
ALTER TABLE `vsw_vi_news_grouppost`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vsw_vi_news_groups`
--
ALTER TABLE `vsw_vi_news_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vsw_vi_pages`
--
ALTER TABLE `vsw_vi_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vsw_vi_pages_content`
--
ALTER TABLE `vsw_vi_pages_content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vsw_vi_pages_groups`
--
ALTER TABLE `vsw_vi_pages_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vsw_vi_servicepack`
--
ALTER TABLE `vsw_vi_servicepack`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vsw_vi_servicepack_reg`
--
ALTER TABLE `vsw_vi_servicepack_reg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vsw_vi_servicepack_transaction`
--
ALTER TABLE `vsw_vi_servicepack_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vsw_vi_servicepack_translog`
--
ALTER TABLE `vsw_vi_servicepack_translog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vsw_vi_sliders`
--
ALTER TABLE `vsw_vi_sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vsw_vi_sliders_group`
--
ALTER TABLE `vsw_vi_sliders_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vsw_vi_sliders_temp`
--
ALTER TABLE `vsw_vi_sliders_temp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vsw_widget`
--
ALTER TABLE `vsw_widget`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `seo_pages`
--
ALTER TABLE `seo_pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seo_page_images`
--
ALTER TABLE `seo_page_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vsw_comments`
--
ALTER TABLE `vsw_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vsw_funcmod`
--
ALTER TABLE `vsw_funcmod`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vsw_language`
--
ALTER TABLE `vsw_language`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vsw_license`
--
ALTER TABLE `vsw_license`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vsw_modlayout`
--
ALTER TABLE `vsw_modlayout`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vsw_modules`
--
ALTER TABLE `vsw_modules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vsw_permissions`
--
ALTER TABLE `vsw_permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vsw_permissions_roles`
--
ALTER TABLE `vsw_permissions_roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vsw_slugs`
--
ALTER TABLE `vsw_slugs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vsw_translations`
--
ALTER TABLE `vsw_translations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vsw_users`
--
ALTER TABLE `vsw_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vsw_versions`
--
ALTER TABLE `vsw_versions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vsw_vi_contact`
--
ALTER TABLE `vsw_vi_contact`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vsw_vi_contact_customer`
--
ALTER TABLE `vsw_vi_contact_customer`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vsw_vi_contact_parts`
--
ALTER TABLE `vsw_vi_contact_parts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vsw_vi_contact_parts_email`
--
ALTER TABLE `vsw_vi_contact_parts_email`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vsw_vi_contact_reply`
--
ALTER TABLE `vsw_vi_contact_reply`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vsw_vi_interfacepackage`
--
ALTER TABLE `vsw_vi_interfacepackage`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vsw_vi_interface_catalogs`
--
ALTER TABLE `vsw_vi_interface_catalogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vsw_vi_interface_sentiment`
--
ALTER TABLE `vsw_vi_interface_sentiment`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vsw_vi_menus`
--
ALTER TABLE `vsw_vi_menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vsw_vi_menus_group`
--
ALTER TABLE `vsw_vi_menus_group`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vsw_vi_news`
--
ALTER TABLE `vsw_vi_news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vsw_vi_news_catalogs`
--
ALTER TABLE `vsw_vi_news_catalogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vsw_vi_news_catpost`
--
ALTER TABLE `vsw_vi_news_catpost`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vsw_vi_news_grouppost`
--
ALTER TABLE `vsw_vi_news_grouppost`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vsw_vi_news_groups`
--
ALTER TABLE `vsw_vi_news_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vsw_vi_pages`
--
ALTER TABLE `vsw_vi_pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vsw_vi_pages_content`
--
ALTER TABLE `vsw_vi_pages_content`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vsw_vi_pages_groups`
--
ALTER TABLE `vsw_vi_pages_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vsw_vi_servicepack`
--
ALTER TABLE `vsw_vi_servicepack`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vsw_vi_servicepack_reg`
--
ALTER TABLE `vsw_vi_servicepack_reg`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vsw_vi_servicepack_transaction`
--
ALTER TABLE `vsw_vi_servicepack_transaction`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vsw_vi_servicepack_translog`
--
ALTER TABLE `vsw_vi_servicepack_translog`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vsw_vi_sliders`
--
ALTER TABLE `vsw_vi_sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vsw_vi_sliders_group`
--
ALTER TABLE `vsw_vi_sliders_group`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vsw_vi_sliders_temp`
--
ALTER TABLE `vsw_vi_sliders_temp`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vsw_widget`
--
ALTER TABLE `vsw_widget`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `seo_page_images`
--
ALTER TABLE `seo_page_images`
  ADD CONSTRAINT `seo_page_images_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `seo_pages` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
