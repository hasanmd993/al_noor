-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 01, 2026 at 01:09 PM
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
-- Database: `al_noor`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `featured_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` json DEFAULT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Al Noor Properties BD',
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `views` int NOT NULL DEFAULT '0',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `title`, `excerpt`, `content`, `featured_image`, `category`, `tags`, `author`, `is_published`, `views`, `published_at`, `created_at`, `updated_at`) VALUES
(1, 'Why Real Estate in Gulshan & Banani Continues to Outperform Capital Markets in 2026', 'An in-depth market analysis on luxury housing demand, infrastructure appreciation, and capital yield in Dhaka’s most coveted diplomatic enclaves.', '<p>Dhaka’s luxury real estate sector has demonstrated resilient capital appreciation despite global economic fluctuations. Prime districts such as Gulshan 2, Banani, and Dhanmondi have consistently yielded 12-16% annual property value gains.</p><p>High-net-worth buyers prioritize earthquake safety (BNBC 2020), green building ratings, reliable power redundancy, and trusted track records of handover delivery.</p>', 'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=1000&q=80', 'Market Insights', '[\"Real Estate\", \"Gulshan\", \"Investment\", \"Dhaka\"]', 'Engr. Tariqul Islam', 1, 1, '2026-09-28 02:32:59', '2026-10-01 02:32:59', '2026-10-01 02:34:04'),
(2, 'The Evolution of Biophilic Architecture & Green Building in Bangladesh', 'How integrating vertical gardens, cross-ventilation, and rainwater harvesting is transforming living wellness across modern Dhaka apartments.', '<p>Biophilic design is not merely an aesthetic trend; it is essential to long-term health and sustainability. Al-Noor Properties integrates cascading terrace greenery and thermal acoustic glass to lower energy consumption by up to 35%.</p>', 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1000&q=80', 'Architecture & Design', '[\"Green Architecture\", \"Sustainability\", \"Living Wellness\"]', 'Ar. Sabrina Chowdhury', 1, 0, '2026-09-23 02:32:59', '2026-10-01 02:32:59', '2026-10-01 02:32:59'),
(3, 'Landowner Joint Venture Guide: Maximizing Returns & Securing Your Heritage', 'Key legal, architectural, and financial considerations every Dhaka landowner should evaluate before entering a joint development agreement.', '<p>Joint venture partnerships represent the gold standard for landowners seeking to unlock exponential financial value without dealing with construction hassles. Learn about ratio splits, signing bonuses, and structural warranties.</p>', 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=1000&q=80', 'Landowner Guide', '[\"Landowners\", \"Joint Venture\", \"Legal Guide\"]', 'Adv. Mahfuzur Rahman', 1, 0, '2026-09-17 02:32:59', '2026-10-01 02:32:59', '2026-10-01 02:32:59');

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
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Signature Residential', 'Ultra-luxury high-rise condominiums, sky-suites & boutique duplex residences tailored for Dhaka’s elite.', 1, '2026-10-01 02:32:58', '2026-10-01 02:32:58'),
(2, 'Commercial Landmark', 'Grade-A corporate headquarters, smart offices, and premium retail hubs in Dhaka’s central business districts.', 1, '2026-10-01 02:32:58', '2026-10-01 02:32:58'),
(3, 'Sky Penthouses & Duplexes', 'Exclusive top-tier multi-level penthouses with private rooftop pools, double-height ceilings, and panoramic city views.', 1, '2026-10-01 02:32:58', '2026-10-01 02:32:58'),
(4, 'Luxury Villa Estates', 'Gated community luxury villas and garden residences crafted with private green lawns and serene exclusivity.', 1, '2026-10-01 02:32:58', '2026-10-01 02:32:58');

-- --------------------------------------------------------

--
-- Table structure for table `construction_updates`
--

CREATE TABLE `construction_updates` (
  `id` bigint UNSIGNED NOT NULL,
  `property_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `milestone` enum('land_acquired','design_approved','foundation','structure','brickwork','plumbing_electrical','finishing','handover') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `progress_percentage` int DEFAULT NULL,
  `photos` json DEFAULT NULL,
  `update_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `construction_updates`
--

INSERT INTO `construction_updates` (`id`, `property_id`, `title`, `description`, `milestone`, `progress_percentage`, `photos`, `update_date`, `created_at`, `updated_at`) VALUES
(1, 1, 'Structural Superstructure Reaches Level 12', 'Reinforced concrete casting completed for the 12th residential floor slab. High-strength post-tensioning tendons tensioned and grouted.', 'structure', 42, '[\"https://images.unsplash.com/photo-1541888946425-d0fbb180c5f5?auto=format&fit=crop&w=800&q=80\"]', '2026-09-15', '2026-10-01 02:32:59', '2026-10-01 02:32:59'),
(2, 1, 'Basement 3-Level Substructure & Retaining Walls Finished', 'Tri-level deep basement excavation, secant pile walls, and basement waterproofing membranes completed with zero water ingress test passed.', 'foundation', 25, '[\"https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&fit=crop&w=800&q=80\"]', '2026-05-20', '2026-10-01 02:32:59', '2026-10-01 02:32:59'),
(3, 2, 'Curtain Glass Glazing & Terraces Landscaping in Progress', 'Façade double-glazed glass installation completed up to 10th floor. Planter box waterproofing and soil integration ongoing.', 'finishing', 58, '[\"https://images.unsplash.com/photo-1541888946425-d0fbb180c5f5?auto=format&fit=crop&w=800&q=80\"]', '2026-09-01', '2026-10-01 02:32:59', '2026-10-01 02:32:59'),
(4, 3, 'Internal Finishing, Tile Fixing and Painting in Progress', 'Plaster work completed for all levels. Floor tile laying and sanitary piping pressure tests are currently progressing rapidly.', 'finishing', 74, '[\"https://images.unsplash.com/photo-1541888946425-d0fbb180c5f5?auto=format&fit=crop&w=800&q=80\"]', '2026-09-20', '2026-10-01 02:32:59', '2026-10-01 02:32:59'),
(5, 4, 'Soil Investigation & Piling Rig Mobilization', 'Rotary drilling piling rigs successfully positioned on site following comprehensive soil strata chemical and density analysis.', 'foundation', 12, '[\"https://images.unsplash.com/photo-1590381105924-c72589b9ef3f?auto=format&fit=crop&w=800&q=80\"]', '2026-08-10', '2026-10-01 02:32:59', '2026-10-01 02:32:59'),
(6, 5, 'Project Successfully Completed & Handover In Progress', 'RAJUK Occupancy Certificate issued. 90% of proud owners have received their keys.', 'handover', 100, '[\"https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=800&q=80\"]', '2026-06-01', '2026-10-01 02:32:59', '2026-10-01 02:32:59'),
(7, 6, 'Deep Substructure Excavation & Diaphragm Wall in Progress', 'Hydromill diaphragm walling completed to 28m depth for 4-level deep basement construction.', 'foundation', 30, '[\"https://images.unsplash.com/photo-1541888946425-d0fbb180c5f5?auto=format&fit=crop&w=800&q=80\"]', '2026-09-10', '2026-10-01 02:32:59', '2026-10-01 02:32:59');

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
-- Table structure for table `gallery_items`
--

CREATE TABLE `gallery_items` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('image','video') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'image',
  `video_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inquiries`
--

CREATE TABLE `inquiries` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `property_interest` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `source` enum('contact_form','property_inquiry','landowner','brochure_download') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'contact_form',
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Dhaka',
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`, `city`, `latitude`, `longitude`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Gulshan 2', 'Dhaka', 23.7925000, 90.4152000, 1, '2026-10-01 02:32:58', '2026-10-01 02:32:58'),
(2, 'Banani', 'Dhaka', 23.7937000, 90.4066000, 1, '2026-10-01 02:32:58', '2026-10-01 02:32:58'),
(3, 'Dhanmondi', 'Dhaka', 23.7461000, 90.3742000, 1, '2026-10-01 02:32:58', '2026-10-01 02:32:58'),
(4, 'Bashundhara R/A', 'Dhaka', 23.8191000, 90.4357000, 1, '2026-10-01 02:32:58', '2026-10-01 02:32:58'),
(5, 'Uttara', 'Dhaka', 23.8759000, 90.3795000, 1, '2026-10-01 02:32:58', '2026-10-01 02:32:58'),
(6, 'Purbachal', 'Dhaka', 23.8340000, 90.5120000, 1, '2026-10-01 02:32:58', '2026-10-01 02:32:58');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collection_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversions_disk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` bigint UNSIGNED NOT NULL,
  `manipulations` json NOT NULL,
  `custom_properties` json NOT NULL,
  `generated_conversions` json NOT NULL,
  `responsive_images` json NOT NULL,
  `order_column` int UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(4, '2026_10_01_000001_create_property_tables', 1),
(5, '2026_10_01_000002_create_content_tables', 1),
(6, '2026_10_01_073426_create_personal_access_tokens_table', 1),
(7, '2026_10_01_114506_create_media_table', 2);

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
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'admin-token', '6903fe0706b225c41a882084054e8f0e3fa11efbc3da4fc382411892a1b05f85', '[\"*\"]', NULL, NULL, '2026-10-01 02:49:26', '2026-10-01 02:49:26'),
(2, 'App\\Models\\User', 1, 'admin-token', '0b4c13398f3d65ee90d173f06bdfc666c8410cb227fb525e4ec77f3ff148db3e', '[\"*\"]', NULL, NULL, '2026-10-01 02:49:51', '2026-10-01 02:49:51');

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `location_id` bigint UNSIGNED DEFAULT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('upcoming','ongoing','completed','handed_over') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ongoing',
  `type` enum('residential','commercial','mixed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'residential',
  `land_area` decimal(10,2) DEFAULT NULL,
  `land_unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'katha',
  `total_floors` int DEFAULT NULL,
  `apartments_per_floor` int DEFAULT NULL,
  `total_units` int DEFAULT NULL,
  `price_from` decimal(15,2) DEFAULT NULL,
  `price_to` decimal(15,2) DEFAULT NULL,
  `price_label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `progress_percentage` int NOT NULL DEFAULT '0',
  `launch_date` date DEFAULT NULL,
  `expected_completion` date DEFAULT NULL,
  `handover_date` date DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_special_offer` tinyint(1) NOT NULL DEFAULT '0',
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `featured_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brochure_pdf` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amenities` json DEFAULT NULL,
  `nearby_landmarks` json DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`id`, `name`, `short_description`, `description`, `location_id`, `category_id`, `address`, `status`, `type`, `land_area`, `land_unit`, `total_floors`, `apartments_per_floor`, `total_units`, `price_from`, `price_to`, `price_label`, `progress_percentage`, `launch_date`, `expected_completion`, `handover_date`, `is_featured`, `is_special_offer`, `is_published`, `featured_image`, `video_url`, `brochure_pdf`, `amenities`, `nearby_landmarks`, `latitude`, `longitude`, `sort_order`, `published_at`, `created_at`, `updated_at`) VALUES
(1, 'Al-Noor Crown Palace', 'A Testament to Regal Living in Diplomatic Gulshan-2 with Heated Infinity Pool & Panoramic Skyline Vistas.', 'Al-Noor Crown Palace represents the zenith of architectural luxury in Dhaka’s most coveted residential quadrant. Designed for discerning families who demand peerless privacy, uncompromised safety, and expansive spatial grandeur. Featuring triple-height double-glazed thermal façades, Japanese Mitsubishi VRF climate conditioning, Italian Statuario marble lobby, and a temperature-controlled infinity sky pool overlooking Gulshan Lake.', 1, 1, 'Plot 14, Road 84, Gulshan-2 Diplomatic Zone, Dhaka', 'ongoing', 'residential', 18.00, 'katha', 18, 2, 32, 48500000.00, 125000000.00, 'Starting from BDT 4.85 Crore', 42, '2025-01-15', '2027-12-31', '2027-12-31', 1, 0, 1, 'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=1400&q=85', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', '#', '[\"Rooftop Infinity Sky Pool\", \"Private Wellness Spa & Sauna\", \"Technogym Equipped Fitness Centre\", \"Children’s Indoor Creative Playground\", \"Executive Banquet & Event Lounge\", \"EV Fast Charging Bays (x4)\", \"3-Tier Biometric Security & CCTV\", \"100% Full Generator Power Backup\", \"Landscaped Zen Terrace Gardens\", \"Double Glazed Acoustic Glass Windows\"]', '[{\"name\": \"American Club & Diplomatic Zone\", \"distance\": \"2 mins\"}, {\"name\": \"Gulshan Club\", \"distance\": \"4 mins\"}, {\"name\": \"United Hospital\", \"distance\": \"5 mins\"}, {\"name\": \"Unimart & Chef\'s Table Gulshan\", \"distance\": \"3 mins\"}, {\"name\": \"International School Dhaka (ISD)\", \"distance\": \"12 mins\"}]', 23.7960000, 90.4180000, 1, '2026-10-01 02:32:58', '2026-10-01 02:32:58', '2026-10-01 02:32:58'),
(2, 'Al-Noor Lakefront Mirage', 'Uninterrupted Water Horizons in Banani Road 11 with Expansive Cantilevered Sky Gardens.', 'Al-Noor Lakefront Mirage combines the soothing tranquility of Banani Lake with ultra-contemporary urban minimalism. Every residence is meticulously positioned to offer unobstructed water horizons, generous 8-foot cantilevered landscaped balconies, and soundproof acoustic glass windows. The building features an elevated waterfront boardwalk, private clubhouse, and heated therapeutic plunge pool.', 2, 1, 'Road 11, Block E, Banani Lake Promenade, Dhaka', 'ongoing', 'residential', 14.50, 'katha', 15, 2, 26, 39500000.00, 86000000.00, 'Starting from BDT 3.95 Crore', 58, '2025-03-01', '2027-08-30', '2027-08-30', 1, 1, 1, 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1400&q=85', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', '#', '[\"Waterfront Plunge Pool\", \"Private Residents Clubhouse\", \"Sky Deck Meditation Corner\", \"Smart Car Parking Guidance System\", \"Billiard & Card Room\", \"24/7 Security & CCTV\", \"Automated Smart Home Pre-wiring\"]', '[{\"name\": \"Banani Road 11 Fine Dining District\", \"distance\": \"1 min\"}, {\"name\": \"Banani Club\", \"distance\": \"3 mins\"}, {\"name\": \"Sheraton Dhaka Banani\", \"distance\": \"4 mins\"}, {\"name\": \"Kemal Ataturk Avenue\", \"distance\": \"3 mins\"}]', 23.7942000, 90.4078000, 2, '2026-10-01 02:32:58', '2026-10-01 02:32:59', '2026-10-01 02:32:59'),
(3, 'Al-Noor Grand Vista', 'Iconic Heritage Meets Modern Prestige in Dhanmondi Road 27 with Expansive Family Suites.', 'Al-Noor Grand Vista is Dhanmondi’s crown jewel for refined families seeking spacious layouts, lush green surroundings, and close proximity to premier schools and hospitals. Featuring large family living spaces, dedicated servant quarters with separate entry, landscaped terrace corridors, and a rooftop astronomical observation deck.', 3, 1, 'Road 27 (Old) / 16 (New), Dhanmondi R/A, Dhaka', 'ongoing', 'residential', 12.00, 'katha', 14, 2, 24, 36000000.00, 74000000.00, 'Starting from BDT 3.60 Crore', 74, '2024-06-15', '2026-11-30', '2026-11-30', 1, 0, 1, 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1400&q=85', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', '#', '[\"Community Gathering Hall\", \"Rooftop Walking & Jogging Track\", \"Children’s Library & Study Corner\", \"Solar Power Subsidized System\", \"CCTV 24/7 Security Protection\"]', '[{\"name\": \"Dhanmondi Lake Walkway\", \"distance\": \"2 mins\"}, {\"name\": \"Ibn Sina Hospital\", \"distance\": \"3 mins\"}, {\"name\": \"Mastermind School & Scholastica\", \"distance\": \"4 mins\"}, {\"name\": \"Rapa Plaza & Shimanto Square\", \"distance\": \"5 mins\"}]', 23.7530000, 90.3765000, 3, '2026-10-01 02:32:58', '2026-10-01 02:32:59', '2026-10-01 02:32:59'),
(4, 'Al-Noor Zenith Tower', 'Futuristic Elegance in Prime Bashundhara Block I with Curved Glass Terraces & Smart Home Systems.', 'Al-Noor Zenith Tower brings architectural panache to Bashundhara R/A. Crafted with aerodynamic curved cantilevered balconies, triple-height grand atrium, rooftop observatory deck, and fiber-optic smart building backbone for seamless ultra-fast automation.', 4, 1, 'Plot 88, Road 14, Block I, Bashundhara R/A, Dhaka', 'upcoming', 'residential', 15.00, 'katha', 16, 3, 45, 28500000.00, 62000000.00, 'Starting from BDT 2.85 Crore', 12, '2025-12-01', '2028-03-31', '2028-03-31', 1, 0, 1, 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=1400&q=85', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', '#', '[\"Gymnasium & Aerobics Studio\", \"Executive Meeting Boardroom\", \"Children\'s Game Zone & Daycare\", \"Rooftop BBQ Pavilion\", \"Automated Number Plate Recognition (ANPR) Parking\"]', '[{\"name\": \"Evercare Hospital Dhaka\", \"distance\": \"5 mins\"}, {\"name\": \"North South University (NSU)\", \"distance\": \"4 mins\"}, {\"name\": \"Independent University Bangladesh (IUB)\", \"distance\": \"4 mins\"}, {\"name\": \"Jamuna Future Park\", \"distance\": \"8 mins\"}]', 23.8210000, 90.4375000, 4, '2026-10-01 02:32:58', '2026-10-01 02:32:59', '2026-10-01 02:32:59'),
(5, 'Al-Noor Imperial Heights', 'Ready to Move In Luxury Residences in Uttara Sector 4 next to Dhaka Metro Rail Station.', 'Al-Noor Imperial Heights is an impeccably crafted ready-to-move architectural statement in Uttara Sector 4, just 3 minutes away from the Metro Rail station. Completed with highest-grade materials, lush landscaping, fully operational elevators, and standby generators. Only 2 signature units remaining for immediate handover.', 5, 1, 'Sector 4, Road 18, Uttara Model Town, Dhaka', 'completed', 'residential', 10.00, 'katha', 12, 2, 22, 27500000.00, 45000000.00, 'Starting from BDT 2.75 Crore (Ready)', 100, '2023-01-10', '2026-06-01', '2026-06-01', 1, 0, 1, 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=1400&q=85', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', '#', '[\"Equipped Rooftop Gym\", \"CCTV 24/7 Security Guarding\", \"Standby Generator 100% Load\", \"Landscaped Rooftop Terrace\", \"Driver Lounge & Waiting Room\"]', '[{\"name\": \"Uttara Center Metro Rail Station\", \"distance\": \"3 mins\"}, {\"name\": \"Hazrat Shahjalal International Airport\", \"distance\": \"8 mins\"}, {\"name\": \"Uttara Club\", \"distance\": \"5 mins\"}]', 23.8745000, 90.3812000, 5, '2026-10-01 02:32:58', '2026-10-01 02:32:59', '2026-10-01 02:32:59'),
(6, 'Al-Noor Prime Nexus', 'Grade-A Corporate Headquarters in Gulshan 1 Avenue with LEED Platinum Certified Infrastructure.', 'Al-Noor Prime Nexus is Dhaka’s upcoming landmark commercial skyscraper. Designed for multinational corporations, fintech giants, and diplomatic consulates. Features LEED Platinum certified sustainable architectural envelope, smart destination-dispatch elevator banks, 4 basement parking levels, and high-security access lobbies.', 1, 2, 'Gulshan Avenue, Gulshan 1/2 Hub, Dhaka', 'ongoing', 'commercial', 22.00, 'katha', 22, 2, 40, 65000000.00, 280000000.00, 'Starting from BDT 6.50 Crore', 30, '2025-05-01', '2028-06-30', '2028-06-30', 1, 0, 1, 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1400&q=85', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', '#', '[\"Corporate Sky Lounge & Bistro\", \"Helipad on 22nd Rooftop Deck\", \"120-Seat Conference Auditorium\", \"Destination-Controlled High Speed Lifts\", \"Central BMS & Automated Energy Optimization\"]', '[{\"name\": \"Gulshan 1 Circle\", \"distance\": \"2 mins\"}, {\"name\": \"Westin Dhaka\", \"distance\": \"3 mins\"}, {\"name\": \"Hatirjheel Expressway Entry\", \"distance\": \"4 mins\"}]', 23.7850000, 90.4160000, 6, '2026-10-01 02:32:58', '2026-10-01 02:32:59', '2026-10-01 02:32:59');

-- --------------------------------------------------------

--
-- Table structure for table `property_images`
--

CREATE TABLE `property_images` (
  `id` bigint UNSIGNED NOT NULL,
  `property_id` bigint UNSIGNED NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `caption` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('exterior','interior','floorplan','construction','amenity') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'exterior',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `property_images`
--

INSERT INTO `property_images` (`id`, `property_id`, `image_path`, `caption`, `type`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=1400&q=85', 'Exterior Architectural Rendering - Evening View', 'exterior', 1, '2026-10-01 02:32:59', '2026-10-01 02:32:59'),
(2, 1, 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1400&q=85', 'Grand Double-Height Living Room with Skyline Views', 'interior', 2, '2026-10-01 02:32:59', '2026-10-01 02:32:59'),
(3, 1, 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=1400&q=85', 'Bespoke Italian Kitchen & Breakfast Bar', 'interior', 3, '2026-10-01 02:32:59', '2026-10-01 02:32:59'),
(4, 1, 'https://images.unsplash.com/photo-1600565193348-f74bd3c7ccdf?auto=format&fit=crop&w=1400&q=85', 'Master Bedroom Suite with Private Balcony', 'interior', 4, '2026-10-01 02:32:59', '2026-10-01 02:32:59'),
(5, 1, 'https://images.unsplash.com/photo-1576013551627-0cc20b96c2a7?auto=format&fit=crop&w=1400&q=85', 'Rooftop Infinity Edge Pool & Sun Deck', 'amenity', 5, '2026-10-01 02:32:59', '2026-10-01 02:32:59'),
(6, 2, 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1400&q=85', 'Lakefront Exterior Elevation', 'exterior', 1, '2026-10-01 02:32:59', '2026-10-01 02:32:59'),
(7, 2, 'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=1400&q=85', 'Open Concept Waterfront Dining & Living', 'interior', 2, '2026-10-01 02:32:59', '2026-10-01 02:32:59'),
(8, 2, 'https://images.unsplash.com/photo-1600585152220-90363fe7e115?auto=format&fit=crop&w=1400&q=85', 'Master Bedroom Overlooking Lake', 'interior', 3, '2026-10-01 02:32:59', '2026-10-01 02:32:59'),
(9, 3, 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1400&q=85', 'Front Perspective of Al-Noor Grand Vista', 'exterior', 1, '2026-10-01 02:32:59', '2026-10-01 02:32:59'),
(10, 3, 'https://images.unsplash.com/photo-1600573472550-8090b5e0745e?auto=format&fit=crop&w=1400&q=85', 'Luxury Living Space with Handcrafted Hardwood Trim', 'interior', 2, '2026-10-01 02:32:59', '2026-10-01 02:32:59'),
(11, 4, 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=1400&q=85', 'Al-Noor Zenith Tower Exterior Design', 'exterior', 1, '2026-10-01 02:32:59', '2026-10-01 02:32:59'),
(12, 5, 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=1400&q=85', 'Completed Front Façade - Imperial Heights', 'exterior', 1, '2026-10-01 02:32:59', '2026-10-01 02:32:59'),
(13, 5, 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1400&q=85', 'Finished Interior Living Room Ready for Move-In', 'interior', 2, '2026-10-01 02:32:59', '2026-10-01 02:32:59'),
(14, 6, 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1400&q=85', 'Prime Nexus Commercial Skyscraper Rendering', 'exterior', 1, '2026-10-01 02:32:59', '2026-10-01 02:32:59');

-- --------------------------------------------------------

--
-- Table structure for table `property_units`
--

CREATE TABLE `property_units` (
  `id` bigint UNSIGNED NOT NULL,
  `property_id` bigint UNSIGNED NOT NULL,
  `unit_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size_sqft` decimal(10,2) NOT NULL,
  `bedrooms` int NOT NULL,
  `bathrooms` int NOT NULL,
  `balconies` int NOT NULL DEFAULT '0',
  `parking_spaces` int NOT NULL DEFAULT '0',
  `floor_plan_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(15,2) DEFAULT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `property_units`
--

INSERT INTO `property_units` (`id`, `property_id`, `unit_type`, `size_sqft`, `bedrooms`, `bathrooms`, `balconies`, `parking_spaces`, `floor_plan_image`, `price`, `is_available`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'Royal Suite (Type A)', 3850.00, 4, 5, 4, 3, 'https://images.unsplash.com/photo-1600585154526-990dced4db0d?auto=format&fit=crop&w=1000&q=80', 58000000.00, 1, 1, '2026-10-01 02:32:59', '2026-10-01 02:32:59'),
(2, 1, 'Imperial Suite (Type B)', 2950.00, 3, 4, 3, 2, 'https://images.unsplash.com/photo-1600585154526-990dced4db0d?auto=format&fit=crop&w=1000&q=80', 48500000.00, 1, 2, '2026-10-01 02:32:59', '2026-10-01 02:32:59'),
(3, 1, 'Crown Sky Penthouse', 5800.00, 5, 6, 5, 4, 'https://images.unsplash.com/photo-1600585154526-990dced4db0d?auto=format&fit=crop&w=1000&q=80', 125000000.00, 1, 3, '2026-10-01 02:32:59', '2026-10-01 02:32:59'),
(4, 2, 'Lakeview Grande (Type A)', 3450.00, 4, 4, 4, 2, 'https://images.unsplash.com/photo-1600585154526-990dced4db0d?auto=format&fit=crop&w=1000&q=80', 52000000.00, 1, 1, '2026-10-01 02:32:59', '2026-10-01 02:32:59'),
(5, 2, 'Lakeview Elite (Type B)', 2600.00, 3, 3, 3, 2, 'https://images.unsplash.com/photo-1600585154526-990dced4db0d?auto=format&fit=crop&w=1000&q=80', 39500000.00, 1, 2, '2026-10-01 02:32:59', '2026-10-01 02:32:59'),
(6, 3, 'Vista Signature (Type A)', 3200.00, 4, 4, 3, 2, 'https://images.unsplash.com/photo-1600585154526-990dced4db0d?auto=format&fit=crop&w=1000&q=80', 48000000.00, 1, 1, '2026-10-01 02:32:59', '2026-10-01 02:32:59'),
(7, 3, 'Vista Classic (Type B)', 2450.00, 3, 3, 3, 2, 'https://images.unsplash.com/photo-1600585154526-990dced4db0d?auto=format&fit=crop&w=1000&q=80', 36000000.00, 1, 2, '2026-10-01 02:32:59', '2026-10-01 02:32:59'),
(8, 4, 'Zenith Luxe (Type A)', 2450.00, 3, 3, 3, 2, 'https://images.unsplash.com/photo-1600585154526-990dced4db0d?auto=format&fit=crop&w=1000&q=80', 32000000.00, 1, 1, '2026-10-01 02:32:59', '2026-10-01 02:32:59'),
(9, 5, 'Imperial Ready Suite', 2450.00, 3, 3, 3, 2, 'https://images.unsplash.com/photo-1600585154526-990dced4db0d?auto=format&fit=crop&w=1000&q=80', 31000000.00, 1, 1, '2026-10-01 02:32:59', '2026-10-01 02:32:59'),
(10, 6, 'Full Floor Corporate Suite', 7500.00, 0, 6, 2, 6, 'https://images.unsplash.com/photo-1600585154526-990dced4db0d?auto=format&fit=crop&w=1000&q=80', 165000000.00, 1, 1, '2026-10-01 02:32:59', '2026-10-01 02:32:59');

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
('1agHET4qvYoxn9cSIQVMIckam4eYMLVN0Qk4RPsW', NULL, '127.0.0.1', '', 'eyJfdG9rZW4iOiIwWWlHTkU2d2ZjNEVoVDlScXZGQmU3SmQ5RXRtT3ZybGJDTE43NEtxIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pblwvbG9naW4iLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1790844199),
('a8zmDWC8DqT06c67wDAH1n9LHWYIqH2gEMLdjkBV', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiI4SzlWaWV4RWpNOVJtbWZhWHJwbnhvc0hnOFBSQjBkbjY0YVpMMXRDIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hZG1pblwvc2V0dGluZ3MiLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwidXJsIjpbXSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjEsInBhc3N3b3JkX2hhc2hfd2ViIjoiMDRkMjVmNTU5YTIwYzBlYTc4MGY4NWVkMWM4YzBiYjMxYmMyZDIyYjY3NjE1NThkMmY4ZmNiMjA1NDZlNTc5NiIsInRhYmxlcyI6eyI2OThlZmNiZDIyMjM2NjMzMjM1YzE3ZmRiYmUyZDJkZV9jb2x1bW5zIjpbeyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImZlYXR1cmVkX2ltYWdlIiwibGFiZWwiOiJDb3ZlciIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJ0aXRsZSIsImxhYmVsIjoiVGl0bGUiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiY2F0ZWdvcnkiLCJsYWJlbCI6IkNhdGVnb3J5IiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImF1dGhvcl9uYW1lIiwibGFiZWwiOiJBdXRob3IiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjp0cnVlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOmZhbHNlfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiaXNfcHVibGlzaGVkIiwibGFiZWwiOiJQdWJsaXNoZWQiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiaXNfZmVhdHVyZWQiLCJsYWJlbCI6IkZlYXR1cmVkIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InB1Ymxpc2hlZF9hdCIsImxhYmVsIjoiUHVibGlzaGVkIGF0IiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH1dLCJkZGMxZDA4ZWJlZmE2NTIyOTAzYWIxZjM3YzNjYjhhY19jb2x1bW5zIjpbeyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6Im5hbWUiLCJsYWJlbCI6IkNhdGVnb3J5IE5hbWUiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiZGVzY3JpcHRpb24iLCJsYWJlbCI6IkRlc2NyaXB0aW9uIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImlzX2FjdGl2ZSIsImxhYmVsIjoiQWN0aXZlIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH1dfX0=', 1790845500),
('CaoHD42N5zGg85FpXobSNAyBNfSQfBfM7RWpSMyl', NULL, '127.0.0.1', '', 'eyJfdG9rZW4iOiJmR3kydEZqMWNvZEk5cXFZZDJZaHFCaTZSeXpUVE5jZGxTdnZEZ0hQIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pblwvZGFzaGJvYXJkIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1790844576),
('cTqPWVKMul1KjlVnwEcVONcS4WDb6VkUOyxkan60', NULL, '127.0.0.1', '', 'eyJfdG9rZW4iOiJxNzhkRlVOVnpRaHJoSDFkUHBjeUo5WnVWdU9Ga0hUVGNjYXd4UHJ5IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pblwvbG9naW4iLCJyb3V0ZSI6ImZpbGFtZW50LmFkbWluLmF1dGgubG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1790843632),
('DKqaLPhr5ZXuszWBprgPxSs2lgkdW65klQinBNrV', NULL, '127.0.0.1', '', 'eyJfdG9rZW4iOiJTRWFYdkVsR3lXRWpIOG8xNFRBTjREY3lzRzVLRFNoc1hGU0ZDajd2IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pblwvZGFzaGJvYXJkIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1790844705),
('Dx1dKC9BjoS5fP9ChK0I1TgeqRsZW71Di3ESQ3aj', NULL, '127.0.0.1', '', 'eyJfdG9rZW4iOiJKZ29LSGpHU2lmdFpaTWswcW5PSnNiRk81QzR1NWVNSUdTNmowb0NFIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1790856199),
('DYIUzWXqQTWVFEFHazvvWNk7L6KvLwsjYg47Q37D', NULL, '127.0.0.1', '', 'eyJfdG9rZW4iOiJVanU2a0NJZFJ4ZUU4RzE3anE0U3BHV2dQbjd1akdyQlJpcTVtMHdDIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pblwvbG9naW4iLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1790844825),
('eK6ABT3qu3ZEiUOWk5vR9pFq8NS7lnq3VC4ginKh', NULL, '127.0.0.1', '', 'eyJfdG9rZW4iOiJWM25oNU82Rml1Y2NWN0I0czlVd3B2QXlnbmptbldJSDdTVWxkN2NaIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pblwvZGFzaGJvYXJkIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1790844199),
('ETzxUgVF9mrP3nK5aYF2AHrP4c6Pe1TEXF8Vnoy6', NULL, '127.0.0.1', '', 'eyJfdG9rZW4iOiJxZElZZ0tyNGtUU2V2ZXFzMFU1QzZ4Y3RFNm92Wm9PQkpYT242RHZpIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1790844704),
('jrqAO5Fqo9N9he1PSYzgF7A4LgJKIOnzEcWWHAhP', NULL, '127.0.0.1', '', 'eyJfdG9rZW4iOiJjb1F4UnV6c3l1d3Y1cDNmMlZLQXBHZzVZeWhpa0ltWGFGMUppdkZDIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1790844824),
('Ks0rBQbqqNup3KE57gBzKznNKUE9sY7jUPH92YhL', NULL, '127.0.0.1', '', 'eyJfdG9rZW4iOiJBaXE3bDZtc1ZUcG5GcWtRWTBYeVl4Z1RsOFhGTHhlSTNDZFJNNGtuIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pblwvZGFzaGJvYXJkIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1790844825),
('Ldzhutc2JfpBcasC7ZpeCyexHxScPNak9BdKcbXX', NULL, '127.0.0.1', '', 'eyJfdG9rZW4iOiJkYTAzU01uWTlJRmZNUXpXeW9XWDV6NW1wc0FvQ0diVHR1M25Xd2lBIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pblwvbG9naW4iLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1790844705),
('NICsukWhZ6Q52oiMgIioYm5RTunZAI3ilNSBxk6H', NULL, '127.0.0.1', '', 'eyJfdG9rZW4iOiJQTkNnYlZ1NEQyOVJEbkRFaDlieHZ0dEhNWVd3b2M2REU3Q1pOQ3hyIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pblwvbG9naW4iLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1790844575),
('nkwUGaYEuARD7TaJih0GnEkCwc4MNro3clLBdhFq', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJyajVEUlFPMURvNFB0WlBQNGxTQndHN3BXdksxN0ZSdkRiQ3g4SThlIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1790856249),
('Oe5ri1s9poYt4LRrrfQg0MXrALvzMzfZZpEcWIpo', NULL, '127.0.0.1', '', 'eyJfdG9rZW4iOiJITzZJM0F1TWVmc0dZWlhnbUZiZTZRdzRtczhaUGRwTzdUcTdtMU5BIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1790844575),
('PM7lmwXwMlWN5y5nznPeCHOJA7MCKpnFg3XnKchY', NULL, '127.0.0.1', '', 'eyJfdG9rZW4iOiJHaUVmM0VzUW1SUmpSUkxPajBOaHhYdmJ3Z0RQcUdqQTdlMEtsWmVhIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1790844198),
('QOuatI6NuZoplCrYnIGmMkqUx2HkClHpUzorav5S', NULL, '127.0.0.1', '', 'eyJfdG9rZW4iOiJaOWNrbkhrb1JZcUJQU0VNOXNNN0NwQnh3Zkx6cWVuelc4UFRTSXdsIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1790856214),
('RwO9sGIV6EYp0U65WqNH97c2cVqYrX6LwDBMMyVe', NULL, '127.0.0.1', '', 'eyJfdG9rZW4iOiI2b2lONzVVWjZ4bWl1R0tCMFhWdnlZM1FMZHRUV1ZVTG1sY1lLT0ZaIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1790856231),
('tq4mWrm46dFyN9bGa5drrrJMkaXSA4n3KW3N5wH8', NULL, '127.0.0.1', '', 'eyJfdG9rZW4iOiI3anJTQmtleHlLMGtsOTlVTkNBTzBOMUZMVEFyT0ZROFdFb3B5VmFJIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1790843631),
('v0RmovfeciXjm5NUbc0pVkdd3DFcepWEN2la8QnW', NULL, '127.0.0.1', '', 'eyJfdG9rZW4iOiJWUGc5dGliVXFpWDBkT2h3TlR1dVZjbW03dVJLclFTNmdLQjBRRnI0IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pblwvbG9naW4iLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1790844416),
('YnRpj4yYBtx7Xl2hUWJgMJOS9AZKiuyCtYGdkybm', NULL, '127.0.0.1', '', 'eyJfdG9rZW4iOiJSWWRZbGNPOVpiS2JYbGJwaGgyMlFNb0UyOXgwN1c1SkVmYTJOM0t5IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pblwvbG9naW4iLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1790844469);

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'Al-Noor Properties BD', 'general', '2026-10-01 02:33:00', '2026-10-01 02:33:00'),
(2, 'tagline', 'Crafting Architectural Landmarks & Dhaka’s Finest Living Spaces', 'general', '2026-10-01 02:33:00', '2026-10-01 02:33:00'),
(3, 'phone_primary', '+880 1894-916600', 'contact', '2026-10-01 02:33:00', '2026-10-01 02:33:00'),
(4, 'phone_hotline', '16688', 'contact', '2026-10-01 02:33:00', '2026-10-01 02:33:00'),
(5, 'email_primary', 'info@alnoorpropertiesbd.com', 'contact', '2026-10-01 02:33:00', '2026-10-01 02:33:00'),
(6, 'email_sales', 'sales@alnoorpropertiesbd.com', 'contact', '2026-10-01 02:33:00', '2026-10-01 02:33:00'),
(7, 'corporate_address', 'Al-Noor Tower, Level 12-14, Plot 88, Road 11, Block D, Banani, Dhaka-1213, Bangladesh', 'contact', '2026-10-01 02:33:00', '2026-10-01 02:33:00'),
(8, 'stat_completed_sqft', '3.5 Million+ Sq. Ft. Delivered', 'stats', '2026-10-01 02:33:00', '2026-10-01 02:33:00'),
(9, 'stat_happy_families', '1,200+ Discerning Families', 'stats', '2026-10-01 02:33:00', '2026-10-01 02:33:00'),
(10, 'stat_on_time_ratio', '99.4% On-Time Handover Record', 'stats', '2026-10-01 02:33:00', '2026-10-01 02:33:00'),
(11, 'stat_years_experience', '25+ Years of Trust & Legacy', 'stats', '2026-10-01 02:33:00', '2026-10-01 02:33:00'),
(12, 'whatsapp_number', '+8801894916600', 'social', '2026-10-01 02:33:00', '2026-10-01 02:33:00'),
(13, 'facebook_url', 'https://facebook.com/alnoorpropertiesbd', 'social', '2026-10-01 02:33:00', '2026-10-01 02:33:00'),
(14, 'linkedin_url', 'https://linkedin.com/company/alnoorpropertiesbd', 'social', '2026-10-01 02:33:00', '2026-10-01 02:33:00'),
(15, 'youtube_url', 'https://youtube.com/@alnoorpropertiesbd', 'social', '2026-10-01 02:33:00', '2026-10-01 02:33:00'),
(16, 'instagram_url', 'https://instagram.com/alnoorpropertiesbd', 'social', '2026-10-01 02:33:00', '2026-10-01 02:33:00');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cta_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cta_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `title`, `subtitle`, `image`, `cta_text`, `cta_link`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Architectural Landmarks Redefining Dhaka’s Skyline', 'Pioneering ultra-luxury residences, sky duplexes and bespoke commercial estates with uncompromising craftsmanship.', 'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=1920&q=90', 'Explore Signature Projects', '/properties', 1, 1, '2026-10-01 02:32:59', '2026-10-01 02:32:59'),
(2, 'Banani Lakefront Horizons: Tranquility Reimagined', 'Unobstructed water vistas, cantilevered sky gardens, and double-height infinity living in Dhaka’s premier neighborhood.', 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1920&q=90', 'View Lakefront Mirage', '/properties/al-noor-lakefront-mirage', 2, 1, '2026-10-01 02:32:59', '2026-10-01 02:32:59'),
(3, 'Empowering Landowners Through High-Yield Joint Ventures', 'Unlock maximum property valuation, world-class architectural design, and guaranteed on-time handover with Al-Noor.', 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1920&q=90', 'Partner With Us', '/landowners', 3, 1, '2026-10-01 02:32:59', '2026-10-01 02:32:59');

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

CREATE TABLE `team_members` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `social_links` json DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `team_members`
--

INSERT INTO `team_members` (`id`, `name`, `designation`, `photo`, `bio`, `social_links`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Al-Haj Noor Mohammed', 'Founder & Chairman of the Board', 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=600&q=80', 'A visionary pioneer with over 30 years of excellence in infrastructure, construction, and nation-building initiatives across Bangladesh.', NULL, 1, 1, '2026-10-01 02:33:00', '2026-10-01 02:33:00'),
(2, 'Engr. Kazi Shamsul Alam', 'Managing Director & CEO', 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=600&q=80', 'BUET Civil Engineering alumnus with 22+ years leading mega real estate developments, high-rise structural engineering, and corporate excellence.', NULL, 1, 2, '2026-10-01 02:33:00', '2026-10-01 02:33:00'),
(3, 'Ar. Sabrina Chowdhury', 'Chief Architectural Officer', 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=600&q=80', 'Master of Architecture from National University of Singapore (NUS), specializing in sustainable luxury condominiums and biophilic building envelopes.', NULL, 1, 3, '2026-10-01 02:33:00', '2026-10-01 02:33:00'),
(4, 'Rashidul Karim, CFA', 'Chief Financial Officer', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=600&q=80', 'Expert in capital structuring, project financing, and landowner joint-venture wealth optimization models.', NULL, 1, 4, '2026-10-01 02:33:00', '2026-10-01 02:33:00');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint UNSIGNED NOT NULL,
  `client_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_designation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quote` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` int NOT NULL DEFAULT '5',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `client_name`, `client_photo`, `client_designation`, `quote`, `project_name`, `rating`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Barrister Anisul Haque & Dr. Farzana Haque', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=200&q=80', 'Homeowners, Al-Noor Crown Palace', 'Al-Noor Properties delivers what few developers in Bangladesh can: meticulous attention to structural integrity, transparent milestone tracking, and aesthetic grace that rivals world-class luxury residences in Singapore or Dubai.', 'Al-Noor Crown Palace, Gulshan', 5, 1, 1, '2026-10-01 02:33:00', '2026-10-01 02:33:00'),
(2, 'Syed Nazmul Hasan', 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=200&q=80', 'Landowner Partner, Banani Road 11', 'Entrusting our ancestral land to Al-Noor was the finest decision our family made. Their joint-venture terms were exceptionally fair, legal due-diligence was seamless, and construction progress has been ahead of schedule.', 'Al-Noor Lakefront Mirage', 5, 1, 2, '2026-10-01 02:33:00', '2026-10-01 02:33:00'),
(3, 'Rubaba Dowla', 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=200&q=80', 'Executive Director, Global Tech Holdings', 'From the expansive ceiling heights to the silent acoustic glass and prompt customer support, living at an Al-Noor property is an absolute joy. A truly world-class developer in Dhaka.', 'Al-Noor Grand Vista, Dhanmondi', 5, 1, 3, '2026-10-01 02:33:00', '2026-10-01 02:33:00');

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
(1, 'Al-Noor Executive Admin', 'admin@alnoorbd.com', '2026-10-01 02:32:58', '$2y$12$SXE3uob..WwcL7xf8ZghoehbcBQ.EOUheAtazlxCs45Eio7Qd6eFi', NULL, '2026-10-01 02:32:58', '2026-10-01 02:32:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `construction_updates`
--
ALTER TABLE `construction_updates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `construction_updates_property_id_foreign` (`property_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indexes for table `gallery_items`
--
ALTER TABLE `gallery_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `media_uuid_unique` (`uuid`),
  ADD KEY `media_model_type_model_id_index` (`model_type`,`model_id`),
  ADD KEY `media_order_column_index` (`order_column`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
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
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `properties_location_id_foreign` (`location_id`),
  ADD KEY `properties_category_id_foreign` (`category_id`);

--
-- Indexes for table `property_images`
--
ALTER TABLE `property_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_images_property_id_foreign` (`property_id`);

--
-- Indexes for table `property_units`
--
ALTER TABLE `property_units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_units_property_id_foreign` (`property_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `site_settings_key_unique` (`key`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
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
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `construction_updates`
--
ALTER TABLE `construction_updates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gallery_items`
--
ALTER TABLE `gallery_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inquiries`
--
ALTER TABLE `inquiries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `property_images`
--
ALTER TABLE `property_images`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `property_units`
--
ALTER TABLE `property_units`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `team_members`
--
ALTER TABLE `team_members`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `construction_updates`
--
ALTER TABLE `construction_updates`
  ADD CONSTRAINT `construction_updates_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `properties`
--
ALTER TABLE `properties`
  ADD CONSTRAINT `properties_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `properties_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `property_images`
--
ALTER TABLE `property_images`
  ADD CONSTRAINT `property_images_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `property_units`
--
ALTER TABLE `property_units`
  ADD CONSTRAINT `property_units_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
