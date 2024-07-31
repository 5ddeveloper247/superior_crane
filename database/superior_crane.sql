-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2024 at 08:24 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `superior_crane`
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
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `job_type` smallint(5) DEFAULT NULL COMMENT '1=>logistic, 2=>crane',
  `client_name` varchar(255) NOT NULL,
  `job_time` time NOT NULL,
  `date` date NOT NULL,
  `address` text NOT NULL,
  `equipment_to_be_used` varchar(255) NOT NULL,
  `rigger_assigned` varchar(50) NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `notes` text DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `scci` tinyint(1) DEFAULT 0 COMMENT '0=>other, 1=>SCCI',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0 for problem, 1 for good to go, 2 for draft',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `job_type`, `client_name`, `job_time`, `date`, `address`, `equipment_to_be_used`, `rigger_assigned`, `supplier_name`, `notes`, `start_time`, `end_time`, `scci`, `status`, `created_at`, `updated_at`, `created_by`) VALUES
(1, NULL, 'John Doe', '14:30:00', '2024-07-18', '123 Main St, Springfield, IL', 'Crane Model X', '1', 'ABC Equipment Supplies', 'Urgent job, please prioritize.', NULL, NULL, 1, 3, '2024-07-19 06:02:04', '2024-07-20 08:05:17', 2),
(2, 1, 'John Doe', '14:30:00', '2024-01-19', '123 Main St, Springfield, IL', 'Crane Model X', '1', 'ABC Equipment Supplies1', 'Urgent job, please prioritize.', NULL, NULL, 1, 1, '2024-07-19 06:03:03', '2024-07-19 06:03:03', 2),
(3, NULL, 'Hamza', '14:30:00', '2023-07-18', '123 Main St, Springfield, IL', 'Crane Model X', '1', 'ABC Equipment Supplies', 'Urgent job, please prioritize.', NULL, NULL, 1, 1, '2024-07-19 06:10:22', '2024-07-19 06:10:22', 2),
(4, NULL, 'Ali', '14:30:00', '2024-07-18', '123 Main St, Springfield, IL', 'Crane Model X', '1', 'ABC Equipment Supplies', 'Urgent job, please prioritize.', NULL, NULL, 1, 1, '2024-07-19 06:10:25', '2024-07-19 06:10:25', 2),
(5, NULL, 'zaid', '14:30:00', '2024-07-18', '123 Main St, Springfield, IL', 'Crane Model X', '1', 'ABC Equipment Supplies', 'Urgent job, please prioritize.', NULL, NULL, 1, 1, '2024-07-20 07:58:04', '2024-07-20 08:06:06', 2),
(6, 1, 'John Doe', '14:30:00', '2024-07-18', '123 Main St, Springfield, IL', 'Crane Model X', '1', 'ABC Equipment Supplies', 'Urgent job, please prioritize.', '2024-07-18 15:30:20', '2024-07-18 17:30:20', 1, 1, '2024-07-31 01:23:11', '2024-07-31 01:23:11', 2),
(7, 1, 'John Doe', '14:30:00', '2024-07-18', '123 Main St, Springfield, IL', 'Crane Model X', '1', 'ABC Equipment Supplies', 'Urgent job, please prioritize.', '2024-07-18 15:30:20', '2024-07-18 17:30:20', 1, 1, '2024-07-31 01:24:36', '2024-07-31 01:24:36', 2);

-- --------------------------------------------------------

--
-- Table structure for table `job_images`
--

CREATE TABLE `job_images` (
  `id` int(11) NOT NULL,
  `job_id` int(11) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pay_duty_form`
--

CREATE TABLE `pay_duty_form` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `location` text NOT NULL,
  `start_time` time NOT NULL,
  `finish_time` time NOT NULL,
  `total_hours` varchar(100) NOT NULL,
  `officer` varchar(100) NOT NULL,
  `officer_name` varchar(100) NOT NULL,
  `division` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `signature` longtext DEFAULT NULL,
  `site_pic` longtext DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pay_duty_form`
--

INSERT INTO `pay_duty_form` (`id`, `user_id`, `date`, `location`, `start_time`, `finish_time`, `total_hours`, `officer`, `officer_name`, `division`, `email`, `signature`, `site_pic`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, '2024-07-18', 'Headquarters1', '08:00:00', '16:00:00', '8', 'Officer1231', 'John Doe1', 'Operations1', 'johndoe1@example.com', 'John Doe Signature', NULL, 1, '2024-07-20 01:23:07', '2024-07-27 07:15:53'),
(2, 1, '2024-07-18', 'Headquarters', '08:00:00', '16:00:00', '8', 'Officer123', 'John Doe', 'Operations', 'johndoe@example.com', 'John Doe Signature', NULL, 1, '2024-07-20 01:23:28', '2024-07-20 01:23:28'),
(3, 1, '2024-07-18', 'Headquarters', '08:00:00', '16:00:00', '8', 'Officer123', 'John Doe', 'Operations', 'johndoe@example.com', 'John Doe Signature', NULL, 1, '2024-07-20 01:23:36', '2024-07-20 01:23:36'),
(4, 1, '2024-07-18', 'Headquarters', '08:00:00', '16:00:00', '8', 'Officer123', 'John Doe', 'Operations', 'johndoe@example.com', NULL, NULL, 1, '2024-07-27 07:14:06', '2024-07-27 07:14:06');

-- --------------------------------------------------------

--
-- Table structure for table `pay_duty_images`
--

CREATE TABLE `pay_duty_images` (
  `id` int(11) NOT NULL,
  `pay_duty_id` int(11) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Table structure for table `rigger_tickets`
--

CREATE TABLE `rigger_tickets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `specifications_remarks` text DEFAULT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `location` text DEFAULT NULL,
  `po_number` varchar(20) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `leave_yard` text DEFAULT NULL,
  `start_job` varchar(255) DEFAULT NULL,
  `finish_job` varchar(255) DEFAULT NULL,
  `arrival_yard` varchar(255) DEFAULT NULL,
  `lunch` varchar(255) DEFAULT NULL,
  `travel_time` varchar(255) DEFAULT NULL,
  `crane_time` varchar(255) DEFAULT NULL,
  `total_hours` varchar(255) DEFAULT NULL,
  `crane_number` varchar(255) DEFAULT NULL,
  `rating` varchar(255) DEFAULT NULL,
  `boom_length` varchar(255) DEFAULT NULL,
  `operator` varchar(100) DEFAULT NULL,
  `other_equipment` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `signature` longtext DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rigger_tickets`
--

INSERT INTO `rigger_tickets` (`id`, `user_id`, `specifications_remarks`, `customer_name`, `location`, `po_number`, `date`, `leave_yard`, `start_job`, `finish_job`, `arrival_yard`, `lunch`, `travel_time`, `crane_time`, `total_hours`, `crane_number`, `rating`, `boom_length`, `operator`, `other_equipment`, `email`, `notes`, `signature`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'Additional specifications and remarks for the job.', 'John Doe', '1234 Crane St, Lift City', 'PO123456', '2024-07-18', '07:00 AM', '08:00 AM', '05:00 PM', '06:00 PM', '12:00 PM - 01:00 PM', '1 hour', '8 hours', '9 hours', 'CR1234', '5 stars', '60 feet', 'Jane Smith', 'Hook, Chains', 'john.doe@example.com', 'Job went smoothly with no issues.', 'John Doe\'s Signature', 1, '2024-07-20 00:05:55', '2024-07-20 00:05:55'),
(2, 1, 'Additional specifications and remarks for the job.', 'John Doe', '1234 Crane St, Lift City', 'PO123456', '2024-07-18', 'asasas', '08:00 AM', '05:00 PM', '06:00 PM', '12:00 PM - 01:00 PM', '1 hour', '8 hours', '9 hours', 'CR1234', '5 stars', '60 feet', 'Jane Smith', 'Hook, Chains', 'john.doe@example.com', 'Job went smoothly with no issues.', 'John Doe\'s Signature', 1, '2024-07-20 00:06:17', '2024-07-20 00:06:17'),
(3, 1, 'Additional specifications and remarks for the job.', 'John Doe', '1234 Crane St, Lift City', 'PO123456', '2024-07-18', '07:00 AM', '08:00 AM', '05:00 PM', '06:00 PM', '12:00 PM - 01:00 PM', '1 hour', '8 hours', '9 hours', 'CR1234', '5 stars', '60 feet', 'Jane Smith', 'Hook, Chains', 'john.doe@example.com', 'Job went smoothly with no issues.', 'John Doe\'s Signature', 1, '2024-07-20 00:06:36', '2024-07-20 00:06:36'),
(4, 1, '123Additional specifications and remarks for the job.', 'John Doe', '1234 Crane St, Lift City', 'PO123456', '2024-07-18', '07:00 AM', '08:00 AM', '05:00 PM', '06:00 PM', '12:00 PM - 01:00 PM', '1 hour', '8 hours', '9 hours', 'CR1234', '5 stars', '60 feet', 'Jane Smith', 'Hook, Chains', 'john.doe@example.com', 'Job went smoothly with no issues.', 'John Doe\'s Signature', 1, '2024-07-20 08:03:52', '2024-07-20 08:03:52'),
(5, 1, 'Additional specifications and remarks for the job.', 'John Doe', '1234 Crane St, Lift City', 'PO123456', '2024-07-18', '07:00 AM', '08:00 AM', '05:00 PM', '06:00 PM', '12:00 PM - 01:00 PM', '1 hour', '8 hours', '9 hours', 'CR1234', '5 stars', '60 feet', 'Jane Smith', 'Hook, Chains', 'john.doe@example.com', 'Job went smoothly with no issues.', 'John Doe\'s Signature', 1, '2024-07-27 02:15:40', '2024-07-27 02:15:40'),
(6, 1, 'Additional specifications and remarks for the job.', 'John Doe', '1234 Crane St, Lift City', 'PO123456', '2024-07-18', '07:00 AM', '08:00 AM', '05:00 PM', '06:00 PM', '12:00 PM - 01:00 PM', '1 hour', '8 hours', '9 hours', 'CR1234', '5 stars', '60 feet', 'Jane Smith', 'Hook, Chains', 'john.doe@example.com', 'Job went smoothly with no issues.', NULL, 1, '2024-07-27 02:46:33', '2024-07-27 02:46:33'),
(7, 1, 'Additional specifications and remarks for the job.123123123', 'John Doe123123', '1234 Crane St, Lift City213', 'PO123456', '2024-07-18', '07:00 AM', '08:00 AM', '05:00 PM', '06:00 PM', '12:00 PM - 01:00 PM', '1 hour', '8 hours', '9 hours', 'CR1234', '5 stars', '60 feet', 'Jane Smith', 'Hook, Chains', 'john.doe@example.com', 'Job went smoothly with no issues.', NULL, 1, '2024-07-27 02:48:11', '2024-07-27 02:48:11');

-- --------------------------------------------------------

--
-- Table structure for table `rigger_ticket_images`
--

CREATE TABLE `rigger_ticket_images` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role_name` text DEFAULT NULL,
  `enable` smallint(5) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `enable`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 1, '2024-07-27 04:40:34', '2024-07-27 04:40:34'),
(2, 'Manager', 1, '2024-07-27 04:40:34', '2024-07-27 04:40:34'),
(3, 'Rigger', 1, '2024-07-27 04:40:34', '2024-07-27 04:40:34'),
(4, 'Transporter', 1, '2024-07-27 04:40:34', '2024-07-27 04:40:34'),
(5, 'Rigger & Transporter', 1, '2024-07-27 04:40:34', '2024-07-27 04:40:34');

-- --------------------------------------------------------

--
-- Table structure for table `transportation_tickets`
--

CREATE TABLE `transportation_tickets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `pickup_address` text DEFAULT NULL,
  `delivery_address` text DEFAULT NULL,
  `time_in` time DEFAULT NULL,
  `time_out` time DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `job_number` varchar(50) DEFAULT NULL,
  `job_special_instructions` text DEFAULT NULL,
  `po_number` varchar(50) DEFAULT NULL,
  `po_special_instructions` text DEFAULT NULL,
  `site_contact_name` varchar(100) DEFAULT NULL,
  `site_contact_name_special_instructions` text DEFAULT NULL,
  `site_contact_number` varchar(20) DEFAULT NULL,
  `site_contact_number_special_instructions` text DEFAULT NULL,
  `shipper_name` varchar(100) DEFAULT NULL,
  `shipper_signature` longtext DEFAULT NULL,
  `shipper_signature_date` date DEFAULT NULL,
  `shipper_time_in` time DEFAULT NULL,
  `shipper_time_out` time DEFAULT NULL,
  `pickup_driver_name` varchar(100) DEFAULT NULL,
  `pickup_driver_signature` longtext DEFAULT NULL,
  `pickup_driver_signature_date` date DEFAULT NULL,
  `pickup_driver_time_in` time DEFAULT NULL,
  `pickup_driver_time_out` time DEFAULT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `customer_email` varchar(100) DEFAULT NULL,
  `customer_signature` longtext DEFAULT NULL,
  `customer_signature_date` date DEFAULT NULL,
  `customer_time_in` time DEFAULT NULL,
  `customer_time_out` time DEFAULT NULL,
  `status` smallint(5) DEFAULT NULL,
  `site_pic` longtext DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transportation_tickets`
--

INSERT INTO `transportation_tickets` (`id`, `user_id`, `pickup_address`, `delivery_address`, `time_in`, `time_out`, `notes`, `job_number`, `job_special_instructions`, `po_number`, `po_special_instructions`, `site_contact_name`, `site_contact_name_special_instructions`, `site_contact_number`, `site_contact_number_special_instructions`, `shipper_name`, `shipper_signature`, `shipper_signature_date`, `shipper_time_in`, `shipper_time_out`, `pickup_driver_name`, `pickup_driver_signature`, `pickup_driver_signature_date`, `pickup_driver_time_in`, `pickup_driver_time_out`, `customer_name`, `customer_email`, `customer_signature`, `customer_signature_date`, `customer_time_in`, `customer_time_out`, `status`, `site_pic`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, '123 Pickup St', '456 Delivery Ave', '08:00:00', '17:00:00', 'Handle with care', 'JN123456', 'Deliver by noon', 'PO789012', 'Include all items', 'John Doe', 'Ask for John', '1234567890', 'Call ahead', 'Jane Smith', 'Jane\'s Signature', '2024-07-18', '08:30:00', '09:00:00', 'Mike Johnson', 'Mike\'s Signature', '2024-07-18', '08:00:00', '08:30:00', 'Alice Brown', 'alice.brown@example.com', 'Alice\'s Signature', '2024-07-18', '16:30:00', '17:00:00', 1, NULL, 1, '2024-07-20 07:18:13', '2024-07-27 08:22:11'),
(2, 1, '123 Pickup St', '456 Delivery Ave', '08:00:00', '17:00:00', 'Handle with care', 'JN123456', 'Deliver by noon', 'PO789012', 'Include all items', 'John Doe', 'Ask for John', '1234567890', 'Call ahead', 'Jane Smith', NULL, '2024-07-18', '08:30:00', '09:00:00', 'Mike Johnson', NULL, '2024-07-18', '08:00:00', '08:30:00', 'Alice Brown', 'alice.brown@example.com', NULL, '2024-07-18', '16:30:00', '17:00:00', 1, NULL, 1, '2024-07-27 08:11:34', '2024-07-27 08:11:34'),
(3, 1, '123 Pickup St', '456 Delivery Ave', '08:00:00', '17:00:00', 'Handle with care', 'JN123456', 'Deliver by noon', 'PO789012', 'Include all items', 'John Doe', 'Ask for John', '1234567890', 'Call ahead', 'Jane Smith', NULL, '2024-07-18', '08:30:00', '09:00:00', 'Mike Johnson', NULL, '2024-07-18', '08:00:00', '08:30:00', 'Alice Brown', 'alice.brown@example.com', NULL, '2024-07-18', '16:30:00', '17:00:00', 1, NULL, 1, '2024-07-27 08:11:55', '2024-07-27 08:11:55'),
(4, 1, '123 Pickup St', '456 Delivery Ave', '08:00:00', '17:00:00', 'Handle with care', 'JN123456', 'Deliver by noon', 'PO789012', 'Include all items', 'John Doe', 'Ask for John', '1234567890', 'Call ahead', 'Jane Smith', NULL, '2024-07-18', '08:30:00', '09:00:00', 'Mike Johnson', NULL, '2024-07-18', '08:00:00', '08:30:00', 'Alice Brown', 'alice.brown@example.com', NULL, '2024-07-18', '16:30:00', '17:00:00', 1, NULL, 1, '2024-07-27 08:12:31', '2024-07-27 08:12:31'),
(5, 1, '123 Pickup St', '456 Delivery Ave', '08:00:00', '17:00:00', 'Handle with care', 'JN123456', 'Deliver by noon', 'PO789012', 'Include all items', 'John Doe', 'Ask for John', '1234567890', 'Call ahead', 'Jane Smith', NULL, '2024-07-18', '08:30:00', '09:00:00', 'Mike Johnson', NULL, '2024-07-18', '08:00:00', '08:30:00', 'Alice Brown', 'alice.brown@example.com', NULL, '2024-07-18', '16:30:00', '17:00:00', 1, NULL, 1, '2024-07-27 08:13:51', '2024-07-27 08:13:51'),
(6, 1, '123 Pickup St', '456 Delivery Ave', '08:00:00', '17:00:00', 'Handle with care', 'JN123456', 'Deliver by noon', 'PO789012', 'Include all items', 'John Doe', 'Ask for John', '1234567890', 'Call ahead', 'Jane Smith', NULL, '2024-07-18', '08:30:00', '09:00:00', 'Mike Johnson', NULL, '2024-07-18', '08:00:00', '08:30:00', 'Alice Brown', 'alice.brown@example.com', NULL, '2024-07-18', '16:30:00', '17:00:00', 1, NULL, 1, '2024-07-27 08:14:01', '2024-07-27 08:14:01');

-- --------------------------------------------------------

--
-- Table structure for table `transportation_ticket_images`
--

CREATE TABLE `transportation_ticket_images` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` smallint(5) DEFAULT NULL COMMENT '0=>Superadmin,\r\n1=>Admin,\r\n2=>Manager,\r\n3=>Rigger\r\n4=>Transporter,\r\n5=>Rigger&Transporter Both',
  `otp` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role_id`, `otp`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'zaid', 'zaidkhurshid525@gmail.com', NULL, '$2y$12$xZlTE7Zg/KXTwYZfIbWd2eAtAmVX9zT8C8neLqf/SL..0y75x/giW', 4, NULL, NULL, '2024-07-19 03:33:47', '2024-07-20 08:01:35'),
(2, 'zaid', 'zaid1@gmail.com', NULL, '$2y$12$EqijPC6x.IGThJYeIhM4T.617YIX.jJ0PGFAU/GhgmHXbcOcArRdG', 4, NULL, NULL, '2024-07-19 03:39:46', '2024-07-19 03:39:46'),
(3, 'zaid', 'zaid2@gmail.com', NULL, '$2y$12$Lr5v297hOf/t6Dn1X2L1f.AS7qF5rlZQrXhpLKjPkvPKykAejQWYy', 4, NULL, NULL, '2024-07-19 03:40:22', '2024-07-19 03:40:22'),
(4, 'abcd', 'zaid2565@gmail.com', NULL, '$2y$12$kpS2U.AyPhy0MWPmhiIYBOReyqi0rutfCaaUQhxWuWNKASPmhgONa', 4, NULL, NULL, '2024-07-20 07:56:33', '2024-07-20 07:56:33'),
(5, 'zaid', 'zaid@gmail.com', NULL, '$2y$12$cA8LS.EXmTrm8w5MdUytuOq7O.KgGChCrSm8nhDEUWLZahk7D5wau', 4, NULL, NULL, '2024-07-26 01:38:55', '2024-07-26 01:38:55'),
(6, 'JohnPie', 'johnpie@example.com', NULL, '$2y$12$xL1iqmM7KvUd2i.O3km0puwoFzHSm7BBwVz53vIiMX0Dl.KAvmwbC', 3, NULL, NULL, '2024-07-26 02:47:02', '2024-07-26 02:47:02'),
(7, 'JohnPie', 'hamza@5dsolutions.ae', NULL, '$2y$12$snHGmYoFvIRpCdGkUmkYheqkKQ212W90i3C5ADVICgYLQj68F.HSS', 3, '10817', NULL, '2024-07-26 02:55:23', '2024-07-31 00:07:09');

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
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_images`
--
ALTER TABLE `job_images`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `pay_duty_form`
--
ALTER TABLE `pay_duty_form`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pay_duty_images`
--
ALTER TABLE `pay_duty_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `rigger_tickets`
--
ALTER TABLE `rigger_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rigger_ticket_images`
--
ALTER TABLE `rigger_ticket_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transportation_tickets`
--
ALTER TABLE `transportation_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transportation_ticket_images`
--
ALTER TABLE `transportation_ticket_images`
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
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `job_images`
--
ALTER TABLE `job_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pay_duty_form`
--
ALTER TABLE `pay_duty_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pay_duty_images`
--
ALTER TABLE `pay_duty_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rigger_tickets`
--
ALTER TABLE `rigger_tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `rigger_ticket_images`
--
ALTER TABLE `rigger_ticket_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transportation_tickets`
--
ALTER TABLE `transportation_tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transportation_ticket_images`
--
ALTER TABLE `transportation_ticket_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
