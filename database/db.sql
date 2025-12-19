-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 18, 2025 at 07:58 PM
-- Server version: 8.0.44
-- PHP Version: 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lll`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_id` bigint UNSIGNED DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(1, 1, 'login', 'App\\Models\\User', 1, 'Admin logged in', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 10:41:14', '2025-12-18 10:41:14'),
(2, 1, 'post', NULL, NULL, 'Accessed route: ', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 10:41:14', '2025-12-18 10:41:14'),
(3, 1, 'updated', 'App\\Models\\User', 3, 'Student status changed to: active', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 10:43:14', '2025-12-18 10:43:14'),
(4, 1, 'put', NULL, NULL, 'Accessed route: admin.student-enroll.toggle-status', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 10:43:14', '2025-12-18 10:43:14'),
(5, 1, 'post', NULL, NULL, 'Accessed route: admin.notifications.mark-all-read', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 10:43:25', '2025-12-18 10:43:25'),
(6, 2, 'post', NULL, NULL, 'Accessed route: ', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 11:02:46', '2025-12-18 11:02:46'),
(7, 1, 'login', 'App\\Models\\User', 1, 'Admin logged in', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 11:04:16', '2025-12-18 11:04:16'),
(8, 1, 'post', NULL, NULL, 'Accessed route: ', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 11:04:16', '2025-12-18 11:04:16'),
(9, 2, 'post', NULL, NULL, 'Accessed route: ', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 11:06:33', '2025-12-18 11:06:33'),
(10, 2, 'updated', 'App\\Models\\User', 2, 'Profile updated', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 11:12:33', '2025-12-18 11:12:33'),
(11, 2, 'put', NULL, NULL, 'Accessed route: trainer.profile.update', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 11:12:33', '2025-12-18 11:12:33'),
(12, 2, 'post', NULL, NULL, 'Accessed route: trainer.batches.store', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 11:44:08', '2025-12-18 11:44:08'),
(13, 2, 'post', NULL, NULL, 'Accessed route: trainer.batches.store', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 11:44:45', '2025-12-18 11:44:45'),
(14, 2, 'post', NULL, NULL, 'Accessed route: trainer.batches.store', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 11:45:09', '2025-12-18 11:45:09'),
(15, 2, 'created', 'App\\Models\\Batch', 1, 'Batch created: ssss', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 11:45:57', '2025-12-18 11:45:57'),
(16, 2, 'post', NULL, NULL, 'Accessed route: trainer.batches.store', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 11:45:57', '2025-12-18 11:45:57'),
(17, 2, 'post', NULL, NULL, 'Accessed route: trainer.live-classes.store', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 11:54:36', '2025-12-18 11:54:36'),
(18, 2, 'created', 'App\\Models\\LiveClass', 1, 'Live class created: sadfas', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 11:55:15', '2025-12-18 11:55:15'),
(19, 2, 'post', NULL, NULL, 'Accessed route: trainer.live-classes.store', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 11:55:15', '2025-12-18 11:55:15'),
(20, 2, 'put', NULL, NULL, 'Accessed route: trainer.profile.update', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 12:10:12', '2025-12-18 12:10:12'),
(21, 14, 'deleted', 'App\\Models\\Video', 11, 'Amanda Trainer created a new course', '192.168.1.81', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(22, 3, 'updated', 'App\\Models\\Course', 16, 'Student User updated course information', '192.168.1.119', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(23, 17, 'downloaded', 'App\\Models\\Video', 14, 'Charlie Scholar viewed dashboard', '192.168.1.129', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(24, 7, 'created', 'App\\Models\\Course', 7, 'Mike Coach uploaded a video', '192.168.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(25, 6, 'completed', 'App\\Models\\Video', 4, 'Sarah Instructor enrolled in a course', '192.168.1.57', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(26, 20, 'downloaded', 'App\\Models\\Video', 11, 'Frank Novice completed a lesson', '192.168.1.90', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(27, 12, 'viewed', 'App\\Models\\Course', 13, 'Jennifer Educator downloaded certificate', '192.168.1.38', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(28, 11, 'updated', 'App\\Models\\Video', 15, 'Robert Tutor updated profile', '192.168.1.142', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(29, 23, 'updated', 'App\\Models\\Video', 9, 'Ivy Cadet created a batch', '192.168.1.35', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(30, 9, 'updated', 'App\\Models\\Course', 8, 'David Mentor scheduled a live class', '192.168.1.220', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(31, 8, 'deleted', 'App\\Models\\Course', 2, 'Emily Teacher answered a query', '192.168.1.31', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(32, 5, 'downloaded', 'App\\Models\\Course', 8, 'John Trainer updated settings', '192.168.1.145', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(33, 22, 'enrolled', 'App\\Models\\Video', 11, 'Henry Trainee viewed reports', '192.168.1.161', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(34, 2, 'deleted', 'App\\Models\\Video', 8, 'Trainer test User exported data', '192.168.1.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(35, 28, 'updated', 'App\\Models\\Course', 11, 'Noah Graduate performed system backup', '192.168.1.241', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(36, 12, 'deleted', 'App\\Models\\Course', 2, 'Jennifer Educator created a new course', '192.168.1.165', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(37, 8, 'enrolled', 'App\\Models\\Course', 29, 'Emily Teacher updated course information', '192.168.1.126', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(38, 25, 'viewed', 'App\\Models\\Video', 24, 'Kate Sophomore viewed dashboard', '192.168.1.188', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(39, 6, 'enrolled', 'App\\Models\\Video', 26, 'Sarah Instructor uploaded a video', '192.168.1.197', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(40, 13, 'viewed', 'App\\Models\\Video', 26, 'Michael Facilitator enrolled in a course', '192.168.1.171', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(41, 29, 'downloaded', 'App\\Models\\Course', 9, 'Olivia Postgrad completed a lesson', '192.168.1.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(42, 2, 'downloaded', 'App\\Models\\Video', 29, 'Trainer test User downloaded certificate', '192.168.1.232', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(43, 14, 'created', 'App\\Models\\Video', 10, 'Amanda Trainer updated profile', '192.168.1.191', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(44, 19, 'downloaded', 'App\\Models\\Course', 14, 'Eve Apprentice created a batch', '192.168.1.249', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(45, 25, 'viewed', 'App\\Models\\Video', 26, 'Kate Sophomore scheduled a live class', '192.168.1.175', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(46, 13, 'downloaded', 'App\\Models\\Video', 2, 'Michael Facilitator answered a query', '192.168.1.175', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(47, 17, 'completed', 'App\\Models\\Course', 3, 'Charlie Scholar updated settings', '192.168.1.162', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(48, 27, 'deleted', 'App\\Models\\Video', 3, 'Mia Senior viewed reports', '192.168.1.180', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(49, 3, 'completed', 'App\\Models\\Video', 15, 'Student User exported data', '192.168.1.157', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(50, 25, 'deleted', 'App\\Models\\Video', 21, 'Kate Sophomore performed system backup', '192.168.1.194', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(51, 2, 'created', 'App\\Models\\Playlist', 31, 'Playlist created: sadas', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 12:19:24', '2025-12-18 12:19:24'),
(52, 2, 'post', NULL, NULL, 'Accessed route: trainer.videos.playlist.store', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 12:19:24', '2025-12-18 12:19:24'),
(53, 2, 'created', 'App\\Models\\Playlist', 32, 'Playlist created: dsdsd', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 12:21:37', '2025-12-18 12:21:37'),
(54, 2, 'post', NULL, NULL, 'Accessed route: trainer.videos.playlist.store', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 12:21:37', '2025-12-18 12:21:37'),
(55, 2, 'created', 'App\\Models\\Playlist', 33, 'Playlist created: sss', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 12:23:06', '2025-12-18 12:23:06'),
(56, 2, 'post', NULL, NULL, 'Accessed route: trainer.videos.playlist.store', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 12:23:06', '2025-12-18 12:23:06'),
(57, 2, 'post', NULL, NULL, 'Accessed route: trainer.videos.store', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 12:23:20', '2025-12-18 12:23:20'),
(58, 2, 'post', NULL, NULL, 'Accessed route: trainer.videos.store', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 12:24:18', '2025-12-18 12:24:18'),
(59, 2, 'post', NULL, NULL, 'Accessed route: trainer.videos.store', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 12:24:26', '2025-12-18 12:24:26'),
(60, 2, 'post', NULL, NULL, 'Accessed route: trainer.videos.store', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 12:24:32', '2025-12-18 12:24:32'),
(61, 2, 'created', 'App\\Models\\Video', 31, 'Video uploaded: werqwer', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 12:25:37', '2025-12-18 12:25:37'),
(62, 2, 'post', NULL, NULL, 'Accessed route: trainer.videos.store', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 12:25:37', '2025-12-18 12:25:37'),
(63, 2, 'updated', 'App\\Models\\LiveClass', 19, 'Live class updated: Hands-on Practice - Mobile App Development', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 12:32:47', '2025-12-18 12:32:47'),
(64, 2, 'put', NULL, NULL, 'Accessed route: trainer.live-classes.update', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 12:32:47', '2025-12-18 12:32:47'),
(65, 2, 'created', 'App\\Models\\Quiz', 31, 'Quiz created: Whgat is php', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 12:34:41', '2025-12-18 12:34:41'),
(66, 2, 'post', NULL, NULL, 'Accessed route: trainer.quizzes.store', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 12:34:41', '2025-12-18 12:34:41'),
(67, 2, 'post', NULL, NULL, 'Accessed route: trainer.quizzes.add-question', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 12:35:09', '2025-12-18 12:35:09'),
(68, 2, 'deleted', NULL, NULL, 'Quiz deleted: Whgat is php', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 12:44:15', '2025-12-18 12:44:15'),
(69, 2, 'delete', NULL, NULL, 'Accessed route: trainer.quizzes.destroy', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 12:44:15', '2025-12-18 12:44:15'),
(70, 2, 'updated', 'App\\Models\\LiveClass', 19, 'Live class ended: Hands-on Practice - Mobile App Development', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 12:55:21', '2025-12-18 12:55:21'),
(71, 2, 'post', NULL, NULL, 'Accessed route: trainer.live-classes.end', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 12:55:21', '2025-12-18 12:55:21'),
(72, 2, 'put', NULL, NULL, 'Accessed route: trainer.profile.update', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 12:59:53', '2025-12-18 12:59:53'),
(73, 2, 'put', NULL, NULL, 'Accessed route: trainer.profile.update', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 13:00:06', '2025-12-18 13:00:06'),
(74, 2, 'updated', 'App\\Models\\User', 2, 'Profile updated', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 13:00:47', '2025-12-18 13:00:47'),
(75, 2, 'put', NULL, NULL, 'Accessed route: trainer.profile.update', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 13:00:47', '2025-12-18 13:00:47'),
(76, 2, 'updated', 'App\\Models\\Batch', 20, 'Batch updated: Evening Batch - Web Development Fundamentals', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 13:09:01', '2025-12-18 13:09:01'),
(77, 2, 'put', NULL, NULL, 'Accessed route: trainer.batches.update', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 13:09:01', '2025-12-18 13:09:01'),
(78, 2, 'post', NULL, NULL, 'Accessed route: trainer.notifications.mark-all-read', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 13:10:59', '2025-12-18 13:10:59'),
(79, 2, 'updated', 'App\\Models\\User', 2, 'Profile updated', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 13:11:23', '2025-12-18 13:11:23'),
(80, 2, 'put', NULL, NULL, 'Accessed route: trainer.profile.update', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 13:11:23', '2025-12-18 13:11:23'),
(81, 3, 'post', NULL, NULL, 'Accessed route: ', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 13:14:43', '2025-12-18 13:14:43'),
(82, 3, 'post', NULL, NULL, 'Accessed route: ', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 13:25:35', '2025-12-18 13:25:35'),
(83, 3, 'post', NULL, NULL, 'Accessed route: ', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 13:26:02', '2025-12-18 13:26:02'),
(84, 3, 'post', NULL, NULL, 'Accessed route: ', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 13:26:18', '2025-12-18 13:26:18'),
(85, 3, 'post', NULL, NULL, 'Accessed route: ', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 13:28:25', '2025-12-18 13:28:25'),
(86, 3, 'put', NULL, NULL, 'Accessed route: student.profile.update', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 13:29:00', '2025-12-18 13:29:00'),
(87, 3, 'put', NULL, NULL, 'Accessed route: student.profile.update', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 13:29:30', '2025-12-18 13:29:30'),
(88, 3, 'put', NULL, NULL, 'Accessed route: student.profile.update', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 13:29:42', '2025-12-18 13:29:42'),
(89, 3, 'put', NULL, NULL, 'Accessed route: student.profile.update', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:06:37', '2025-12-18 14:06:37'),
(90, 3, 'post', NULL, NULL, 'Accessed route: student.notifications.mark-all-read', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:19:40', '2025-12-18 14:19:40'),
(91, 1, 'login', 'App\\Models\\User', 1, 'Admin logged in', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:20:37', '2025-12-18 14:20:37'),
(92, 1, 'post', NULL, NULL, 'Accessed route: ', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:20:37', '2025-12-18 14:20:37'),
(93, 1, 'updated', NULL, NULL, 'Website settings updated', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:21:03', '2025-12-18 14:21:03'),
(94, 1, 'put', NULL, NULL, 'Accessed route: admin.settings.update', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:21:03', '2025-12-18 14:21:03'),
(95, 1, 'updated', 'App\\Models\\CommunityQuery', 20, 'Query replied: Database connection issue', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:21:24', '2025-12-18 14:21:24'),
(96, 1, 'post', NULL, NULL, 'Accessed route: admin.community-queries.reply', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:21:24', '2025-12-18 14:21:24'),
(97, 1, 'updated', 'App\\Models\\CommunityQuery', 20, 'Query closed: Database connection issue', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:21:29', '2025-12-18 14:21:29'),
(98, 1, 'post', NULL, NULL, 'Accessed route: admin.community-queries.close', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:21:29', '2025-12-18 14:21:29'),
(99, 1, 'updated', 'App\\Models\\CommunityQuery', 27, 'Trainer assigned to query: Performance improvement', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:24:17', '2025-12-18 14:24:17'),
(100, 1, 'post', NULL, NULL, 'Accessed route: admin.community-queries.assign', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:24:17', '2025-12-18 14:24:17'),
(101, 1, 'updated', 'App\\Models\\CommunityQuery', 17, 'Trainer assigned to query: How to install dependencies?', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:24:30', '2025-12-18 14:24:30'),
(102, 1, 'post', NULL, NULL, 'Accessed route: admin.community-queries.assign', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:24:30', '2025-12-18 14:24:30'),
(103, 1, 'created', 'App\\Models\\Course', 31, 'Trainer Lisa Guide assigned to course: SEO Course', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:26:46', '2025-12-18 14:26:46'),
(104, 1, 'post', NULL, NULL, 'Accessed route: admin.assign-course.assign-trainer', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:26:46', '2025-12-18 14:26:46'),
(105, 1, 'created', 'App\\Models\\Course', 31, 'Trainer David Mentor assigned to course: SEO Course', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:26:48', '2025-12-18 14:26:48'),
(106, 1, 'post', NULL, NULL, 'Accessed route: admin.assign-course.assign-trainer', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:26:48', '2025-12-18 14:26:48'),
(107, 1, 'created', 'App\\Models\\Course', 31, 'Trainer Jennifer Educator assigned to course: SEO Course', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:26:50', '2025-12-18 14:26:50'),
(108, 1, 'post', NULL, NULL, 'Accessed route: admin.assign-course.assign-trainer', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:26:50', '2025-12-18 14:26:50'),
(109, 1, 'deleted', 'App\\Models\\Course', 31, 'Trainer Michael Facilitator removed from course: SEO Course', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:26:57', '2025-12-18 14:26:57'),
(110, 1, 'post', NULL, NULL, 'Accessed route: admin.assign-course.remove-trainer', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:26:57', '2025-12-18 14:26:57'),
(111, 1, 'deleted', 'App\\Models\\Course', 31, 'Trainer Emily Teacher removed from course: SEO Course', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:27:01', '2025-12-18 14:27:01'),
(112, 1, 'post', NULL, NULL, 'Accessed route: admin.assign-course.remove-trainer', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:27:01', '2025-12-18 14:27:01'),
(113, 1, 'deleted', 'App\\Models\\Course', 31, 'Trainer Amanda Trainer removed from course: SEO Course', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:27:05', '2025-12-18 14:27:05'),
(114, 1, 'post', NULL, NULL, 'Accessed route: admin.assign-course.remove-trainer', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:27:05', '2025-12-18 14:27:05'),
(115, 1, 'deleted', 'App\\Models\\Course', 30, 'Trainer Emily Teacher removed from course: Animation Course', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:27:10', '2025-12-18 14:27:10'),
(116, 1, 'post', NULL, NULL, 'Accessed route: admin.assign-course.remove-trainer', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:27:10', '2025-12-18 14:27:10'),
(117, 1, 'created', 'App\\Models\\Course', 31, 'Trainer Trainer test User assigned to course: SEO Course', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:27:17', '2025-12-18 14:27:17'),
(118, 1, 'post', NULL, NULL, 'Accessed route: admin.assign-course.assign-trainer', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:27:17', '2025-12-18 14:27:17'),
(119, 1, 'created', 'App\\Models\\Course', 31, 'Trainer Mike Coach assigned to course: SEO Course', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:27:20', '2025-12-18 14:27:20'),
(120, 1, 'post', NULL, NULL, 'Accessed route: admin.assign-course.assign-trainer', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:27:20', '2025-12-18 14:27:20'),
(121, 1, 'created', 'App\\Models\\Course', 31, 'Trainer John Trainer assigned to course: SEO Course', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:27:22', '2025-12-18 14:27:22'),
(122, 1, 'post', NULL, NULL, 'Accessed route: admin.assign-course.assign-trainer', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:27:22', '2025-12-18 14:27:22'),
(123, 1, 'created', 'App\\Models\\Course', 31, 'Trainer Sarah Instructor assigned to course: SEO Course', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:27:24', '2025-12-18 14:27:24'),
(124, 1, 'post', NULL, NULL, 'Accessed route: admin.assign-course.assign-trainer', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:27:24', '2025-12-18 14:27:24'),
(125, 1, 'deleted', 'App\\Models\\Course', 31, 'Trainer Sarah Instructor removed from course: SEO Course', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:27:28', '2025-12-18 14:27:28'),
(126, 1, 'post', NULL, NULL, 'Accessed route: admin.assign-course.remove-trainer', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:27:28', '2025-12-18 14:27:28'),
(127, 1, 'deleted', 'App\\Models\\Course', 31, 'Trainer Jennifer Educator removed from course: SEO Course', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:27:41', '2025-12-18 14:27:41'),
(128, 1, 'post', NULL, NULL, 'Accessed route: admin.assign-course.remove-trainer', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:27:41', '2025-12-18 14:27:41'),
(129, 1, 'created', 'App\\Models\\Course', 30, 'Trainer John Trainer assigned to course: Animation Course', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:28:01', '2025-12-18 14:28:01'),
(130, 1, 'post', NULL, NULL, 'Accessed route: admin.assign-course.assign-trainer', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:28:01', '2025-12-18 14:28:01');

-- --------------------------------------------------------

--
-- Table structure for table `admin_notifications`
--

CREATE TABLE `admin_notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_notifications`
--

INSERT INTO `admin_notifications` (`id`, `user_id`, `type`, `title`, `message`, `link`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 19, 'success', 'New Enrollment', 'A new student has enrolled in a course.', '/admin/dashboard', 1, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(2, 11, 'error', 'Course Completed', 'A student has completed their course successfully.', '/admin/dashboard', 1, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(3, 15, 'success', 'Payment Received', 'Payment has been received for a course enrollment.', '/admin/dashboard', 0, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(4, 22, 'info', 'System Update', 'System has been updated to the latest version.', '/admin/dashboard', 0, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(5, 12, 'success', 'Maintenance Scheduled', 'Scheduled maintenance will occur tonight.', '/admin/dashboard', 0, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(6, 25, 'warning', 'New Query Posted', 'A new community query has been posted.', '/admin/dashboard', 0, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(7, 13, 'error', 'Certificate Issued', 'A certificate has been issued to a student.', '/admin/dashboard', 1, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(8, 26, 'success', 'Live Class Starting', 'A live class is starting in 10 minutes.', '/admin/dashboard', 0, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(9, 5, 'info', 'Batch Full', 'A batch has reached maximum capacity.', '/admin/dashboard', 1, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(10, 23, 'info', 'New Trainer Joined', 'A new trainer has joined the platform.', '/admin/dashboard', 0, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(11, 3, 'warning', 'Student Registered', 'A new student has registered on the platform.', '/admin/dashboard', 1, '2025-12-18 12:17:19', '2025-12-18 14:19:40'),
(12, 2, 'error', 'Report Generated', 'Monthly report has been generated.', '/admin/dashboard', 1, '2025-12-18 12:17:19', '2025-12-18 13:10:59'),
(13, 5, 'error', 'Backup Completed', 'System backup has been completed successfully.', '/admin/dashboard', 1, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(14, 9, 'warning', 'Security Alert', 'Unusual activity detected in the system.', '/admin/dashboard', 1, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(15, 1, 'info', 'Feature Update', 'New features have been added to the platform.', '/admin/dashboard', 1, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(16, 3, 'success', 'New Enrollment', 'A new student has enrolled in a course.', '/admin/dashboard', 1, '2025-12-18 12:17:42', '2025-12-18 14:19:40'),
(17, 3, 'warning', 'Course Completed', 'A student has completed their course successfully.', '/admin/dashboard', 1, '2025-12-18 12:17:42', '2025-12-18 14:19:40'),
(18, 1, 'warning', 'Payment Received', 'Payment has been received for a course enrollment.', '/admin/dashboard', 1, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(19, 16, 'info', 'System Update', 'System has been updated to the latest version.', '/admin/dashboard', 1, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(20, 10, 'warning', 'Maintenance Scheduled', 'Scheduled maintenance will occur tonight.', '/admin/dashboard', 0, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(21, 28, 'info', 'New Query Posted', 'A new community query has been posted.', '/admin/dashboard', 0, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(22, 13, 'warning', 'Certificate Issued', 'A certificate has been issued to a student.', '/admin/dashboard', 0, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(23, 9, 'warning', 'Live Class Starting', 'A live class is starting in 10 minutes.', '/admin/dashboard', 1, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(24, 10, 'error', 'Batch Full', 'A batch has reached maximum capacity.', '/admin/dashboard', 0, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(25, 20, 'error', 'New Trainer Joined', 'A new trainer has joined the platform.', '/admin/dashboard', 1, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(26, 8, 'success', 'Student Registered', 'A new student has registered on the platform.', '/admin/dashboard', 1, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(27, 3, 'warning', 'Report Generated', 'Monthly report has been generated.', '/admin/dashboard', 1, '2025-12-18 12:17:42', '2025-12-18 14:19:40'),
(28, 11, 'info', 'Backup Completed', 'System backup has been completed successfully.', '/admin/dashboard', 0, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(29, 23, 'success', 'Security Alert', 'Unusual activity detected in the system.', '/admin/dashboard', 0, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(30, 14, 'warning', 'Feature Update', 'New features have been added to the platform.', '/admin/dashboard', 0, '2025-12-18 12:17:42', '2025-12-18 12:17:42');

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `live_class_id` bigint UNSIGNED NOT NULL,
  `status` enum('present','absent','late') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'absent',
  `marked_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `student_id`, `live_class_id`, `status`, `marked_at`, `created_at`, `updated_at`) VALUES
(1, 26, 13, 'present', '2025-12-31 14:31:00', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(2, 29, 11, 'late', '2025-11-26 09:35:00', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(3, 19, 16, 'late', '2026-01-07 12:49:00', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(4, 15, 3, 'absent', NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(5, 3, 3, 'present', '2025-12-29 10:15:00', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(6, 20, 11, 'late', '2025-11-26 09:19:00', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(7, 28, 2, 'present', '2025-11-28 10:50:00', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(8, 3, 5, 'present', '2025-12-20 13:57:00', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(9, 17, 11, 'absent', NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(10, 27, 14, 'absent', NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(11, 15, 15, 'late', '2025-12-18 13:47:00', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(12, 15, 4, 'late', '2025-12-29 13:09:00', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(13, 19, 8, 'late', '2025-12-29 13:13:00', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(14, 22, 9, 'absent', NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(15, 29, 12, 'absent', NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(16, 27, 11, 'late', '2025-11-26 09:20:00', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(17, 26, 28, 'present', '2025-12-25 13:58:00', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(18, 26, 18, 'absent', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(19, 25, 5, 'late', '2025-12-20 13:38:00', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(20, 3, 31, 'late', '2025-12-02 11:59:00', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(21, 20, 28, 'late', '2025-12-25 13:50:00', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(22, 21, 18, 'present', '2026-01-10 12:20:00', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(23, 28, 28, 'late', '2025-12-25 14:01:00', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(24, 17, 16, 'late', '2026-01-07 12:45:00', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(25, 28, 12, 'absent', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(26, 27, 3, 'absent', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(27, 20, 2, 'absent', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(28, 20, 20, 'present', '2025-12-25 18:50:00', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(29, 19, 16, 'late', '2026-01-07 12:37:00', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(30, 26, 19, 'present', '2025-12-24 09:55:00', '2025-12-18 12:17:42', '2025-12-18 12:17:42');

-- --------------------------------------------------------

--
-- Table structure for table `batches`
--

CREATE TABLE `batches` (
  `id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `class_time` time DEFAULT NULL,
  `max_students` int NOT NULL DEFAULT '30',
  `status` enum('active','completed','upcoming') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'upcoming',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `batches`
--

INSERT INTO `batches` (`id`, `course_id`, `name`, `description`, `thumbnail`, `start_date`, `end_date`, `class_time`, `max_students`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'ssss', 'ssss', 'uploads/batches/1766078157_Screenshot 2025-10-29 at 4.30.30 PM.png', NULL, NULL, NULL, 30, 'active', '2025-12-18 11:45:57', '2025-12-18 11:45:57'),
(2, 1, 'Morning Batch - App Devlopermnt', 'This batch covers all aspects of App Devlopermnt in detail.', NULL, '2025-12-18', '2025-12-18', '10:00:00', 36, 'upcoming', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(3, 2, 'Evening Batch - Web Development Fundamentals', 'This batch covers all aspects of Web Development Fundamentals in detail.', NULL, '2025-11-18', '2026-02-16', '10:00:00', 34, 'active', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(4, 3, 'Weekend Batch - Advanced JavaScript', 'This batch covers all aspects of Advanced JavaScript in detail.', NULL, '2025-12-03', '2026-03-03', '10:00:00', 48, 'active', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(5, 4, 'Fast Track Batch - React.js Complete Guide', 'This batch covers all aspects of React.js Complete Guide in detail.', NULL, '2025-12-08', '2026-03-08', '10:00:00', 31, 'completed', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(6, 5, 'Regular Batch - Node.js Backend Development', 'This batch covers all aspects of Node.js Backend Development in detail.', NULL, '2025-12-13', '2026-03-13', '10:00:00', 41, 'upcoming', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(7, 6, 'Intensive Batch - Full Stack Development', 'This batch covers all aspects of Full Stack Development in detail.', NULL, '2025-12-18', '2026-03-18', '10:00:00', 50, 'completed', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(8, 7, 'Part-time Batch - Python Programming', 'This batch covers all aspects of Python Programming in detail.', NULL, '2025-11-28', '2026-02-26', '10:00:00', 34, 'upcoming', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(9, 8, 'Full-time Batch - Data Science with Python', 'This batch covers all aspects of Data Science with Python in detail.', NULL, '2025-12-10', '2026-03-10', '10:00:00', 36, 'active', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(10, 9, 'Online Batch - Mobile App Development', 'This batch covers all aspects of Mobile App Development in detail.', NULL, '2025-12-06', '2026-03-06', '10:00:00', 37, 'upcoming', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(11, 10, 'Offline Batch - UI/UX Design', 'This batch covers all aspects of UI/UX Design in detail.', NULL, '2025-11-23', '2026-02-21', '10:00:00', 41, 'upcoming', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(12, 11, 'Hybrid Batch - Digital Marketing', 'This batch covers all aspects of Digital Marketing in detail.', NULL, '2025-11-30', '2026-02-28', '10:00:00', 28, 'completed', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(13, 12, 'Beginner Batch - Graphic Design', 'This batch covers all aspects of Graphic Design in detail.', NULL, '2025-12-11', '2026-03-11', '10:00:00', 48, 'active', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(14, 1, 'Weekend Batch - App Devlopermnt', 'Weekend batch for working professionals.', NULL, '2025-12-25', '2025-12-18', '14:00:00', 30, 'upcoming', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(15, 2, 'Weekend Batch - Web Development Fundamentals', 'Weekend batch for working professionals.', NULL, '2025-11-25', '2026-02-16', '14:00:00', 30, 'upcoming', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(16, 3, 'Weekend Batch - Advanced JavaScript', 'Weekend batch for working professionals.', NULL, '2025-12-10', '2026-03-03', '14:00:00', 30, 'upcoming', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(17, 4, 'Weekend Batch - React.js Complete Guide', 'Weekend batch for working professionals.', NULL, '2025-12-15', '2026-03-08', '14:00:00', 30, 'upcoming', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(18, 5, 'Weekend Batch - Node.js Backend Development', 'Weekend batch for working professionals.', NULL, '2025-12-20', '2026-03-13', '14:00:00', 30, 'upcoming', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(19, 1, 'Morning Batch - App Devlopermnt', 'This batch covers all aspects of App Devlopermnt in detail.', NULL, '2025-12-18', '2025-12-18', '10:00:00', 20, 'completed', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(20, 2, 'Evening Batch - Web Development Fundamentals', 'This batch covers all aspects of Web Development Fundamentals in detail.', NULL, '2025-11-18', '2026-02-16', NULL, 28, 'active', '2025-12-18 12:17:42', '2025-12-18 13:09:01'),
(21, 3, 'Weekend Batch - Advanced JavaScript', 'This batch covers all aspects of Advanced JavaScript in detail.', NULL, '2025-12-03', '2026-03-03', '14:00:00', 40, 'completed', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(22, 4, 'Fast Track Batch - React.js Complete Guide', 'This batch covers all aspects of React.js Complete Guide in detail.', NULL, '2025-12-08', '2026-03-08', '16:00:00', 39, 'active', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(23, 5, 'Regular Batch - Node.js Backend Development', 'This batch covers all aspects of Node.js Backend Development in detail.', NULL, '2025-12-13', '2026-03-13', '18:00:00', 29, 'active', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(24, 6, 'Intensive Batch - Full Stack Development', 'This batch covers all aspects of Full Stack Development in detail.', NULL, '2025-12-18', '2026-03-18', '20:00:00', 23, 'active', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(25, 7, 'Part-time Batch - Python Programming', 'This batch covers all aspects of Python Programming in detail.', NULL, '2025-11-28', '2026-02-26', '22:00:00', 47, 'upcoming', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(26, 8, 'Full-time Batch - Data Science with Python', 'This batch covers all aspects of Data Science with Python in detail.', NULL, '2025-12-10', '2026-03-10', '00:00:00', 36, 'upcoming', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(27, 9, 'Online Batch - Mobile App Development', 'This batch covers all aspects of Mobile App Development in detail.', NULL, '2025-12-06', '2026-03-06', '10:00:00', 33, 'active', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(28, 10, 'Offline Batch - UI/UX Design', 'This batch covers all aspects of UI/UX Design in detail.', NULL, '2025-11-23', '2026-02-21', '12:00:00', 43, 'active', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(29, 11, 'Hybrid Batch - Digital Marketing', 'This batch covers all aspects of Digital Marketing in detail.', NULL, '2025-11-30', '2026-02-28', '14:00:00', 34, 'completed', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(30, 12, 'Beginner Batch - Graphic Design', 'This batch covers all aspects of Graphic Design in detail.', NULL, '2025-12-11', '2026-03-11', '16:00:00', 31, 'upcoming', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(31, 13, 'Advanced Batch - Content Writing', 'This batch covers all aspects of Content Writing in detail.', NULL, '2025-12-04', '2026-03-04', '18:00:00', 30, 'upcoming', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(32, 14, 'Professional Batch - Video Editing', 'This batch covers all aspects of Video Editing in detail.', NULL, '2025-11-26', '2026-02-24', '20:00:00', 29, 'active', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(33, 15, 'Master Batch - Animation Course', 'This batch covers all aspects of Animation Course in detail.', NULL, '2025-12-09', '2026-03-09', '22:00:00', 24, 'upcoming', '2025-12-18 12:17:42', '2025-12-18 12:17:42');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `certificate_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `issued_at` date NOT NULL,
  `certificate_file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `certificates`
--

INSERT INTO `certificates` (`id`, `student_id`, `course_id`, `certificate_number`, `issued_at`, `certificate_file`, `created_at`, `updated_at`) VALUES
(1, 21, 6, 'CERT-N68LUSX0-2025', '2025-09-02', NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(2, 21, 12, 'CERT-YZDFE875-2025', '2025-12-14', NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(3, 28, 11, 'CERT-PDNVQLLF-2025', '2025-12-12', NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(4, 16, 7, 'CERT-PZAJ46JF-2025', '2025-12-09', NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(5, 25, 6, 'CERT-OVUUA0OB-2025', '2025-08-20', NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(6, 15, 15, 'CERT-HZEFCH7J-2025', '2025-10-17', NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(7, 23, 15, 'CERT-WRKHFQDT-2025', '2025-07-21', NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(8, 25, 1, 'CERT-Y4TFRT5M-2025', '2025-10-14', NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(9, 15, 4, 'CERT-PDRD9RQ2-2025', '2025-08-16', NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(10, 29, 9, 'CERT-ZZ9SRVKH-2025', '2025-11-20', NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(11, 27, 4, 'CERT-3HIEMPGX-2025', '2025-10-31', NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(12, 21, 5, 'CERT-LAMY880N-2025', '2025-12-12', NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(13, 17, 18, 'CERT-TSI70T1K-2025', '2025-10-03', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(14, 21, 20, 'CERT-Q9WW7EYE-2025', '2025-09-15', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(15, 28, 18, 'CERT-C04JYEKW-2025', '2025-10-03', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(16, 25, 19, 'CERT-HBBL3XBJ-2025', '2025-08-12', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(17, 17, 28, 'CERT-IWLGM2ER-2025', '2025-07-24', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(18, 29, 30, 'CERT-EALSHQDK-2025', '2025-06-24', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(19, 26, 21, 'CERT-TMNMIVCF-2025', '2025-10-08', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(20, 17, 29, 'CERT-LB5FEJPC-2025', '2025-12-04', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(21, 21, 27, 'CERT-IKUX0ZO4-2025', '2025-08-25', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(22, 15, 2, 'CERT-MVZ1GL11-2025', '2025-10-15', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(23, 19, 20, 'CERT-WGXKKTII-2025', '2025-06-28', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(24, 20, 2, 'CERT-FKKMCJ7X-2025', '2025-08-23', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(25, 27, 29, 'CERT-DCW8KSDS-2025', '2025-09-28', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(26, 3, 18, 'CERT-CBKAVIRE-2025', '2025-11-07', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(27, 26, 8, 'CERT-Y6LDVUSV-2025', '2025-12-16', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42');

-- --------------------------------------------------------

--
-- Table structure for table `community_queries`
--

CREATE TABLE `community_queries` (
  `id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED DEFAULT NULL,
  `assigned_trainer_id` bigint UNSIGNED DEFAULT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `question` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('open','assigned','resolved','closed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `community_queries`
--

INSERT INTO `community_queries` (`id`, `student_id`, `course_id`, `assigned_trainer_id`, `subject`, `question`, `answer`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 2, 'sadfasd', 'asdf', 'okiji', 'resolved', NULL, '2025-12-18 00:32:39'),
(2, 3, 16, 13, 'How to install dependencies?', 'Can someone explain how this works? Related to SEO Course', 'Here is the solution to your question. The best approach would be to...', 'resolved', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(3, 27, 15, 6, 'Understanding async/await', 'I am getting an error when trying to... Related to Animation Course', 'Here is the solution to your question. The best approach would be to...', 'closed', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(4, 25, 1, 10, 'React hooks explanation', 'What is the best way to implement... Related to App Devlopermnt', 'Here is the solution to your question. The best approach would be to...', 'resolved', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(5, 29, 9, NULL, 'Database connection issue', 'Has anyone faced this issue before? Related to Mobile App Development', NULL, 'open', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(6, 29, 8, 5, 'API authentication problem', 'I need help with understanding... Related to Data Science with Python', 'Here is the solution to your question. The best approach would be to...', 'closed', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(7, 15, 3, NULL, 'Deployment error', 'Can you provide an example of... Related to Advanced JavaScript', NULL, 'open', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(8, 29, 15, 9, 'Code optimization question', 'What are the alternatives to... Related to Animation Course', NULL, 'assigned', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(9, 16, 4, 2, 'Best practices for state management', 'How do I optimize this code? Related to React.js Complete Guide', NULL, 'assigned', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(10, 25, 10, 10, 'Error handling strategies', 'Is there a better approach for... Related to UI/UX Design', NULL, 'assigned', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(11, 19, 1, 10, 'Testing approach', 'What are the common pitfalls in... Related to App Devlopermnt', 'Here is the solution to your question. The best approach would be to...', 'closed', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(12, 17, 12, 5, 'Performance improvement', 'Can someone explain how this works? Related to Graphic Design', NULL, 'assigned', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(13, 24, 9, 2, 'Security concerns', 'I am getting an error when trying to... Related to Mobile App Development', 'Here is the solution to your question. The best approach would be to...', 'closed', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(14, 21, 11, 6, 'Code review request', 'What is the best way to implement... Related to Digital Marketing', 'Here is the solution to your question. The best approach would be to...', 'resolved', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(15, 15, 16, NULL, 'Project structure advice', 'Has anyone faced this issue before? Related to SEO Course', NULL, 'open', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(16, 29, 3, 2, 'Career guidance needed', 'I need help with understanding... Related to Advanced JavaScript', NULL, 'assigned', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(17, 25, 2, 8, 'How to install dependencies?', 'Can someone explain how this works? Related to Web Development Fundamentals', NULL, 'assigned', '2025-12-18 12:17:42', '2025-12-18 14:24:30'),
(18, 17, 10, 9, 'Understanding async/await', 'I am getting an error when trying to... Related to UI/UX Design', NULL, 'assigned', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(19, 25, 26, 2, 'React hooks explanation', 'What is the best way to implement... Related to Digital Marketing', 'Here is the solution to your question. The best approach would be to...', 'resolved', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(20, 21, 2, 2, 'Database connection issue', 'Has anyone faced this issue before? Related to Web Development Fundamentals', 'sss', 'closed', '2025-12-18 12:17:42', '2025-12-18 14:21:29'),
(21, 29, 15, 12, 'API authentication problem', 'I need help with understanding... Related to Animation Course', 'Here is the solution to your question. The best approach would be to...', 'closed', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(22, 22, 15, 5, 'Deployment error', 'Can you provide an example of... Related to Animation Course', 'Here is the solution to your question. The best approach would be to...', 'closed', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(23, 19, 2, 12, 'Code optimization question', 'What are the alternatives to... Related to Web Development Fundamentals', 'Here is the solution to your question. The best approach would be to...', 'closed', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(24, 19, 30, 10, 'Best practices for state management', 'How do I optimize this code? Related to Animation Course', NULL, 'assigned', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(25, 28, 6, 9, 'Error handling strategies', 'Is there a better approach for... Related to Full Stack Development', 'Here is the solution to your question. The best approach would be to...', 'closed', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(26, 17, 6, 13, 'Testing approach', 'What are the common pitfalls in... Related to Full Stack Development', NULL, 'assigned', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(27, 19, 10, 13, 'Performance improvement', 'Can someone explain how this works? Related to UI/UX Design', NULL, 'assigned', '2025-12-18 12:17:42', '2025-12-18 14:24:17'),
(28, 27, 15, 12, 'Security concerns', 'I am getting an error when trying to... Related to Animation Course', NULL, 'assigned', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(29, 26, 9, 12, 'Code review request', 'What is the best way to implement... Related to Mobile App Development', NULL, 'assigned', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(30, 22, 13, 13, 'Project structure advice', 'Has anyone faced this issue before? Related to Content Writing', 'Here is the solution to your question. The best approach would be to...', 'closed', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(31, 27, 20, 7, 'Career guidance needed', 'I need help with understanding... Related to Node.js Backend Development', NULL, 'assigned', '2025-12-18 12:17:42', '2025-12-18 12:17:42');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `thumbnail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','completed','draft') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `duration_days` int DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `description`, `thumbnail`, `status`, `start_date`, `end_date`, `duration_days`, `price`, `created_at`, `updated_at`) VALUES
(1, 'App Devlopermnt', 'sadf', 'asdf', 'draft', '2025-12-18', '2025-12-18', 333, 100.00, '2025-12-18 05:45:36', NULL),
(2, 'Web Development Fundamentals', 'Learn the basics of web development including HTML, CSS, and JavaScript.', NULL, 'active', '2025-11-18', '2026-02-16', 90, 299.99, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(3, 'Advanced JavaScript', 'Master advanced JavaScript concepts including ES6+, async/await, and design patterns.', NULL, 'active', '2025-12-03', '2026-03-03', 90, 399.99, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(4, 'React.js Complete Guide', 'Build modern web applications with React.js, hooks, and Redux.', NULL, 'active', '2025-12-08', '2026-03-08', 90, 449.99, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(5, 'Node.js Backend Development', 'Create scalable backend applications using Node.js and Express.', NULL, 'active', '2025-12-13', '2026-03-13', 90, 499.99, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(6, 'Full Stack Development', 'Complete full-stack development course covering frontend and backend.', NULL, 'active', '2025-12-18', '2026-03-18', 90, 799.99, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(7, 'Python Programming', 'Learn Python from scratch to advanced level with real-world projects.', NULL, 'active', '2025-11-28', '2026-02-26', 90, 349.99, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(8, 'Data Science with Python', 'Master data science using Python, pandas, numpy, and machine learning.', NULL, 'active', '2025-12-10', '2026-03-10', 90, 599.99, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(9, 'Mobile App Development', 'Build mobile applications for iOS and Android using React Native.', NULL, 'active', '2025-12-06', '2026-03-06', 90, 549.99, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(10, 'UI/UX Design', 'Learn user interface and user experience design principles and tools.', NULL, 'active', '2025-11-23', '2026-02-21', 90, 399.99, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(11, 'Digital Marketing', 'Comprehensive digital marketing course covering SEO, SEM, and social media.', NULL, 'active', '2025-11-30', '2026-02-28', 90, 299.99, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(12, 'Graphic Design', 'Master graphic design using Adobe Photoshop, Illustrator, and InDesign.', NULL, 'active', '2025-12-11', '2026-03-11', 90, 349.99, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(13, 'Content Writing', 'Learn professional content writing, copywriting, and content strategy.', NULL, 'active', '2025-12-04', '2026-03-04', 90, 249.99, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(14, 'Video Editing', 'Master video editing using Adobe Premiere Pro and After Effects.', NULL, 'active', '2025-11-26', '2026-02-24', 90, 399.99, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(15, 'Animation Course', 'Learn 2D and 3D animation techniques and tools.', NULL, 'active', '2025-12-09', '2026-03-09', 90, 499.99, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(16, 'SEO Course', 'Complete SEO course covering on-page, off-page, and technical SEO.', NULL, 'draft', '2025-12-28', '2026-03-28', 90, 199.99, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(17, 'Web Development Fundamentals', 'Learn the basics of web development including HTML, CSS, and JavaScript.', NULL, 'active', '2025-11-18', '2026-02-16', 90, 299.99, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(18, 'Advanced JavaScript', 'Master advanced JavaScript concepts including ES6+, async/await, and design patterns.', NULL, 'active', '2025-12-03', '2026-03-03', 90, 399.99, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(19, 'React.js Complete Guide', 'Build modern web applications with React.js, hooks, and Redux.', NULL, 'active', '2025-12-08', '2026-03-08', 90, 449.99, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(20, 'Node.js Backend Development', 'Create scalable backend applications using Node.js and Express.', NULL, 'active', '2025-12-13', '2026-03-13', 90, 499.99, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(21, 'Full Stack Development', 'Complete full-stack development course covering frontend and backend.', NULL, 'active', '2025-12-18', '2026-03-18', 90, 799.99, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(22, 'Python Programming', 'Learn Python from scratch to advanced level with real-world projects.', NULL, 'active', '2025-11-28', '2026-02-26', 90, 349.99, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(23, 'Data Science with Python', 'Master data science using Python, pandas, numpy, and machine learning.', NULL, 'active', '2025-12-10', '2026-03-10', 90, 599.99, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(24, 'Mobile App Development', 'Build mobile applications for iOS and Android using React Native.', NULL, 'active', '2025-12-06', '2026-03-06', 90, 549.99, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(25, 'UI/UX Design', 'Learn user interface and user experience design principles and tools.', NULL, 'active', '2025-11-23', '2026-02-21', 90, 399.99, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(26, 'Digital Marketing', 'Comprehensive digital marketing course covering SEO, SEM, and social media.', NULL, 'active', '2025-11-30', '2026-02-28', 90, 299.99, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(27, 'Graphic Design', 'Master graphic design using Adobe Photoshop, Illustrator, and InDesign.', NULL, 'active', '2025-12-11', '2026-03-11', 90, 349.99, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(28, 'Content Writing', 'Learn professional content writing, copywriting, and content strategy.', NULL, 'active', '2025-12-04', '2026-03-04', 90, 249.99, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(29, 'Video Editing', 'Master video editing using Adobe Premiere Pro and After Effects.', NULL, 'active', '2025-11-26', '2026-02-24', 90, 399.99, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(30, 'Animation Course', 'Learn 2D and 3D animation techniques and tools.', NULL, 'active', '2025-12-09', '2026-03-09', 90, 499.99, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(31, 'SEO Course', 'Complete SEO course covering on-page, off-page, and technical SEO.', NULL, 'draft', '2025-12-28', '2026-03-28', 90, 199.99, '2025-12-18 12:17:42', '2025-12-18 12:17:42');

-- --------------------------------------------------------

--
-- Table structure for table `course_trainer`
--

CREATE TABLE `course_trainer` (
  `id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `trainer_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_trainer`
--

INSERT INTO `course_trainer` (`id`, `course_id`, `trainer_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, NULL, NULL),
(2, 1, 2, NULL, NULL),
(3, 1, 2, NULL, NULL),
(4, 1, 7, NULL, NULL),
(5, 1, 9, NULL, NULL),
(6, 2, 9, NULL, NULL),
(7, 3, 2, NULL, NULL),
(8, 3, 10, NULL, NULL),
(9, 3, 14, NULL, NULL),
(10, 4, 8, NULL, NULL),
(11, 4, 13, NULL, NULL),
(12, 5, 7, NULL, NULL),
(13, 5, 11, NULL, NULL),
(14, 5, 12, NULL, NULL),
(15, 6, 8, NULL, NULL),
(16, 7, 9, NULL, NULL),
(17, 7, 11, NULL, NULL),
(18, 7, 13, NULL, NULL),
(19, 8, 2, NULL, NULL),
(20, 8, 13, NULL, NULL),
(21, 8, 14, NULL, NULL),
(22, 9, 5, NULL, NULL),
(23, 9, 7, NULL, NULL),
(24, 9, 9, NULL, NULL),
(25, 10, 12, NULL, NULL),
(26, 11, 7, NULL, NULL),
(27, 11, 8, NULL, NULL),
(28, 11, 13, NULL, NULL),
(29, 12, 6, NULL, NULL),
(30, 12, 8, NULL, NULL),
(31, 13, 11, NULL, NULL),
(32, 13, 13, NULL, NULL),
(33, 14, 8, NULL, NULL),
(34, 14, 9, NULL, NULL),
(35, 14, 13, NULL, NULL),
(36, 15, 2, NULL, NULL),
(37, 15, 12, NULL, NULL),
(38, 16, 5, NULL, NULL),
(39, 16, 8, NULL, NULL),
(40, 1, 6, NULL, NULL),
(41, 1, 12, NULL, NULL),
(42, 1, 13, NULL, NULL),
(43, 2, 2, NULL, NULL),
(44, 3, 5, NULL, NULL),
(45, 3, 6, NULL, NULL),
(46, 3, 10, NULL, NULL),
(47, 4, 6, NULL, NULL),
(48, 4, 13, NULL, NULL),
(49, 5, 5, NULL, NULL),
(50, 5, 13, NULL, NULL),
(51, 6, 11, NULL, NULL),
(52, 6, 12, NULL, NULL),
(53, 6, 14, NULL, NULL),
(54, 7, 6, NULL, NULL),
(55, 7, 10, NULL, NULL),
(56, 7, 13, NULL, NULL),
(57, 8, 6, NULL, NULL),
(58, 8, 11, NULL, NULL),
(59, 9, 10, NULL, NULL),
(60, 9, 12, NULL, NULL),
(61, 10, 7, NULL, NULL),
(62, 10, 8, NULL, NULL),
(63, 11, 11, NULL, NULL),
(64, 12, 5, NULL, NULL),
(65, 12, 8, NULL, NULL),
(66, 13, 5, NULL, NULL),
(67, 13, 6, NULL, NULL),
(68, 13, 9, NULL, NULL),
(69, 14, 11, NULL, NULL),
(70, 15, 9, NULL, NULL),
(71, 15, 10, NULL, NULL),
(72, 16, 8, NULL, NULL),
(73, 16, 12, NULL, NULL),
(74, 16, 13, NULL, NULL),
(75, 17, 11, NULL, NULL),
(76, 17, 14, NULL, NULL),
(77, 18, 10, NULL, NULL),
(78, 18, 11, NULL, NULL),
(79, 19, 9, NULL, NULL),
(80, 19, 11, NULL, NULL),
(81, 20, 9, NULL, NULL),
(82, 21, 9, NULL, NULL),
(83, 21, 10, NULL, NULL),
(84, 21, 14, NULL, NULL),
(85, 22, 5, NULL, NULL),
(86, 23, 2, NULL, NULL),
(87, 23, 7, NULL, NULL),
(88, 23, 14, NULL, NULL),
(89, 24, 13, NULL, NULL),
(90, 25, 2, NULL, NULL),
(91, 25, 5, NULL, NULL),
(92, 25, 6, NULL, NULL),
(93, 26, 13, NULL, NULL),
(94, 27, 12, NULL, NULL),
(95, 27, 13, NULL, NULL),
(96, 28, 6, NULL, NULL),
(97, 28, 8, NULL, NULL),
(98, 28, 9, NULL, NULL),
(99, 29, 10, NULL, NULL),
(100, 29, 14, NULL, NULL),
(101, 30, 6, NULL, NULL),
(106, 31, 10, NULL, NULL),
(107, 31, 9, NULL, NULL),
(109, 31, 2, NULL, NULL),
(110, 31, 7, NULL, NULL),
(111, 31, 5, NULL, NULL),
(113, 30, 5, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `batch_id` bigint UNSIGNED DEFAULT NULL,
  `status` enum('enrolled','completed','dropped') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'enrolled',
  `enrolled_at` date NOT NULL,
  `completed_at` date DEFAULT NULL,
  `progress_percentage` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`id`, `student_id`, `course_id`, `batch_id`, `status`, `enrolled_at`, `completed_at`, `progress_percentage`, `created_at`, `updated_at`) VALUES
(1, 3, 15, NULL, 'completed', '2025-11-05', '2025-12-09', 100, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(2, 22, 6, 7, 'dropped', '2025-11-06', NULL, 46, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(3, 27, 15, NULL, 'enrolled', '2025-12-02', NULL, 79, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(4, 17, 6, 7, 'completed', '2025-11-03', '2025-11-20', 100, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(5, 16, 7, 8, 'completed', '2025-10-16', '2025-11-22', 100, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(6, 3, 6, 7, 'enrolled', '2025-12-03', NULL, 91, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(7, 19, 9, 10, 'completed', '2025-10-28', '2025-12-11', 100, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(8, 28, 12, 13, 'dropped', '2025-10-31', NULL, 71, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(9, 28, 12, 13, 'dropped', '2025-10-12', NULL, 11, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(10, 24, 2, 3, 'dropped', '2025-12-02', NULL, 7, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(11, 15, 9, 10, 'dropped', '2025-11-18', NULL, 89, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(12, 19, 4, 5, 'completed', '2025-10-10', '2025-12-06', 100, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(13, 21, 16, NULL, 'completed', '2025-12-03', '2025-12-04', 100, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(14, 22, 6, 7, 'dropped', '2025-11-06', NULL, 20, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(15, 26, 9, 10, 'completed', '2025-11-15', '2025-11-24', 100, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(16, 23, 20, NULL, 'dropped', '2025-09-19', NULL, 9, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(17, 25, 31, NULL, 'dropped', '2025-10-15', NULL, 64, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(18, 19, 2, 3, 'completed', '2025-10-25', '2025-12-16', 100, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(19, 18, 22, NULL, 'enrolled', '2025-10-30', NULL, 85, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(20, 19, 13, 31, 'enrolled', '2025-10-12', NULL, 86, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(21, 17, 24, NULL, 'enrolled', '2025-10-12', NULL, 39, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(22, 17, 29, NULL, 'dropped', '2025-12-03', NULL, 37, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(23, 25, 9, 10, 'enrolled', '2025-10-16', NULL, 46, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(24, 16, 19, NULL, 'completed', '2025-09-23', '2025-11-29', 100, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(25, 23, 15, 33, 'completed', '2025-11-23', '2025-11-25', 100, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(26, 17, 6, 7, 'completed', '2025-11-01', '2025-11-27', 100, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(27, 21, 18, NULL, 'completed', '2025-10-06', '2025-11-26', 100, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(28, 23, 9, 10, 'enrolled', '2025-11-14', NULL, 71, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(29, 15, 14, 32, 'enrolled', '2025-10-27', NULL, 12, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(30, 18, 26, NULL, 'dropped', '2025-09-25', NULL, 72, '2025-12-18 12:17:42', '2025-12-18 12:17:42');

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
-- Table structure for table `hiring_applications`
--

CREATE TABLE `hiring_applications` (
  `id` bigint UNSIGNED NOT NULL,
  `trainer_id` bigint UNSIGNED NOT NULL,
  `position` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover_letter` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `resume` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','approved','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `admin_notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hiring_applications`
--

INSERT INTO `hiring_applications` (`id`, `trainer_id`, `position`, `cover_letter`, `resume`, `status`, `admin_notes`, `created_at`, `updated_at`) VALUES
(1, 5, 'Senior Web Developer', 'With over 5 years of teaching experience, I believe I am the right candidate...', 'resumes/resume_5.pdf', 'pending', NULL, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(2, 7, 'Full Stack Developer', 'Having worked in the industry for many years, I can bring real-world experience...', 'resumes/resume_7.pdf', 'pending', NULL, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(3, 7, 'React.js Instructor', 'I am excited to apply for this position. I have extensive experience in...', 'resumes/resume_7.pdf', 'approved', 'Excellent candidate with strong qualifications.', '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(4, 12, 'Node.js Trainer', 'Having worked in the industry for many years, I can bring real-world experience...', 'resumes/resume_12.pdf', 'approved', 'Excellent candidate with strong qualifications.', '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(5, 10, 'Python Programming Teacher', 'I am dedicated to helping students achieve their learning goals...', 'resumes/resume_10.pdf', 'pending', NULL, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(6, 14, 'Data Science Mentor', 'Having worked in the industry for many years, I can bring real-world experience...', 'resumes/resume_14.pdf', 'approved', 'Excellent candidate with strong qualifications.', '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(7, 13, 'UI/UX Design Instructor', 'I am excited to apply for this position. I have extensive experience in...', 'resumes/resume_13.pdf', 'approved', 'Excellent candidate with strong qualifications.', '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(8, 13, 'Mobile App Development Trainer', 'I am dedicated to helping students achieve their learning goals...', 'resumes/resume_13.pdf', 'approved', 'Excellent candidate with strong qualifications.', '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(9, 5, 'Digital Marketing Expert', 'I am passionate about education and have a strong background in...', 'resumes/resume_5.pdf', 'rejected', 'Does not meet the requirements.', '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(10, 5, 'Graphic Design Teacher', 'I am passionate about education and have a strong background in...', 'resumes/resume_5.pdf', 'approved', 'Excellent candidate with strong qualifications.', '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(11, 6, 'Content Writing Instructor', 'I am excited to apply for this position. I have extensive experience in...', 'resumes/resume_6.pdf', 'approved', 'Excellent candidate with strong qualifications.', '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(12, 14, 'Video Editing Trainer', 'With over 5 years of teaching experience, I believe I am the right candidate...', 'resumes/resume_14.pdf', 'rejected', 'Does not meet the requirements.', '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(13, 14, 'SEO Specialist', 'With over 5 years of teaching experience, I believe I am the right candidate...', 'resumes/resume_14.pdf', 'rejected', 'Does not meet the requirements.', '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(14, 7, 'DevOps Engineer', 'I am passionate about education and have a strong background in...', 'resumes/resume_7.pdf', 'approved', 'Excellent candidate with strong qualifications.', '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(15, 14, 'Cloud Computing Expert', 'Having worked in the industry for many years, I can bring real-world experience...', 'resumes/resume_14.pdf', 'approved', 'Excellent candidate with strong qualifications.', '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(16, 9, 'Senior Web Developer', 'Having worked in the industry for many years, I can bring real-world experience...', 'resumes/resume_9.pdf', 'pending', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(17, 6, 'Full Stack Developer', 'With over 5 years of teaching experience, I believe I am the right candidate...', 'resumes/resume_6.pdf', 'pending', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(18, 10, 'React.js Instructor', 'I am passionate about education and have a strong background in...', 'resumes/resume_10.pdf', 'pending', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(19, 6, 'Node.js Trainer', 'With over 5 years of teaching experience, I believe I am the right candidate...', 'resumes/resume_6.pdf', 'rejected', 'Does not meet the requirements.', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(20, 6, 'Python Programming Teacher', 'I am excited to apply for this position. I have extensive experience in...', 'resumes/resume_6.pdf', 'pending', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(21, 11, 'Data Science Mentor', 'I am excited to apply for this position. I have extensive experience in...', 'resumes/resume_11.pdf', 'rejected', 'Does not meet the requirements.', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(22, 13, 'UI/UX Design Instructor', 'I am passionate about education and have a strong background in...', 'resumes/resume_13.pdf', 'approved', 'Excellent candidate with strong qualifications.', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(23, 11, 'Mobile App Development Trainer', 'Having worked in the industry for many years, I can bring real-world experience...', 'resumes/resume_11.pdf', 'approved', 'Excellent candidate with strong qualifications.', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(24, 14, 'Digital Marketing Expert', 'I am excited to apply for this position. I have extensive experience in...', 'resumes/resume_14.pdf', 'approved', 'Excellent candidate with strong qualifications.', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(25, 8, 'Graphic Design Teacher', 'I am excited to apply for this position. I have extensive experience in...', 'resumes/resume_8.pdf', 'rejected', 'Does not meet the requirements.', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(26, 7, 'Content Writing Instructor', 'Having worked in the industry for many years, I can bring real-world experience...', 'resumes/resume_7.pdf', 'rejected', 'Does not meet the requirements.', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(27, 2, 'Video Editing Trainer', 'Having worked in the industry for many years, I can bring real-world experience...', 'resumes/resume_2.pdf', 'pending', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(28, 14, 'SEO Specialist', 'I am dedicated to helping students achieve their learning goals...', 'resumes/resume_14.pdf', 'approved', 'Excellent candidate with strong qualifications.', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(29, 5, 'DevOps Engineer', 'Having worked in the industry for many years, I can bring real-world experience...', 'resumes/resume_5.pdf', 'rejected', 'Does not meet the requirements.', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(30, 14, 'Cloud Computing Expert', 'I am dedicated to helping students achieve their learning goals...', 'resumes/resume_14.pdf', 'pending', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `job_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `job_location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `salary_range` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `job_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs_old`
--

CREATE TABLE `jobs_old` (
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
-- Table structure for table `live_classes`
--

CREATE TABLE `live_classes` (
  `id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED DEFAULT NULL,
  `batch_id` bigint UNSIGNED DEFAULT NULL,
  `trainer_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `scheduled_at` datetime NOT NULL,
  `started_at` datetime DEFAULT NULL,
  `ended_at` datetime DEFAULT NULL,
  `meeting_link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration` int DEFAULT NULL,
  `status` enum('scheduled','live','completed','cancelled') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'scheduled',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `live_classes`
--

INSERT INTO `live_classes` (`id`, `course_id`, `batch_id`, `trainer_id`, `title`, `description`, `scheduled_at`, `started_at`, `ended_at`, `meeting_link`, `thumbnail`, `duration`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 2, 'sadfas', 'sadfasd', '2025-12-31 22:22:00', NULL, NULL, 'https://www.skillwaala.com/', 'uploads/live-classes/1766078715_Screenshot 2025-11-10 at 8.30.29 PM.png', 44, 'scheduled', '2025-12-18 11:55:15', '2025-12-18 11:55:15'),
(2, 16, NULL, 6, 'Introduction Session - SEO Course', 'Join us for an interactive live class on Introduction Session', '2025-11-28 10:47:00', NULL, NULL, 'https://meet.google.com/nFSBxiTmhy', NULL, 115, 'scheduled', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(3, 6, 7, 2, 'Core Concepts Overview - Full Stack Development', 'Join us for an interactive live class on Core Concepts Overview', '2025-12-29 10:09:00', '2025-12-29 10:14:00', '2025-12-29 12:09:00', 'https://meet.google.com/9OrnFDAvm8', NULL, 153, 'completed', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(4, 2, 3, 12, 'Hands-on Practice - Web Development Fundamentals', 'Join us for an interactive live class on Hands-on Practice', '2025-12-29 12:57:00', '2025-12-29 13:02:00', '2025-12-29 14:57:00', 'https://meet.google.com/CxWur30cNh', NULL, 162, 'completed', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(5, 11, 12, 5, 'Q&A Session - Digital Marketing', 'Join us for an interactive live class on Q&A Session', '2025-12-20 13:33:00', NULL, NULL, 'https://meet.google.com/wymzFyvJDV', NULL, 72, 'live', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(6, 2, 3, 2, 'Project Discussion - Web Development Fundamentals', 'Join us for an interactive live class on Project Discussion', '2026-01-17 09:14:00', NULL, NULL, 'https://meet.google.com/SXi1DUitvA', NULL, 91, 'scheduled', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(7, 11, 12, 10, 'Advanced Topics - Digital Marketing', 'Join us for an interactive live class on Advanced Topics', '2025-12-16 10:05:00', NULL, NULL, 'https://meet.google.com/Lfi84iVi2n', NULL, 94, 'live', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(8, 1, 1, 12, 'Review and Recap - App Devlopermnt', 'Join us for an interactive live class on Review and Recap', '2025-12-29 12:58:00', NULL, NULL, 'https://meet.google.com/VdqzK91j0g', NULL, 112, 'scheduled', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(9, 3, 4, 13, 'Final Assessment - Advanced JavaScript', 'Join us for an interactive live class on Final Assessment', '2025-12-08 16:11:00', NULL, NULL, 'https://meet.google.com/kuPtaTzp6V', NULL, 93, 'live', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(10, 6, 7, 12, 'Guest Lecture - Full Stack Development', 'Join us for an interactive live class on Guest Lecture', '2025-12-19 12:32:00', '2025-12-19 12:37:00', '2025-12-19 14:32:00', 'https://meet.google.com/LYQgF1tYAC', NULL, 142, 'completed', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(11, 12, 13, 13, 'Workshop Session - Graphic Design', 'Join us for an interactive live class on Workshop Session', '2025-11-26 09:13:00', '2025-11-26 09:18:00', '2025-11-26 11:13:00', 'https://meet.google.com/2il67z8hXu', NULL, 151, 'completed', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(12, 1, 1, 9, 'Group Activity - App Devlopermnt', 'Join us for an interactive live class on Group Activity', '2026-01-13 15:31:00', '2026-01-13 15:36:00', '2026-01-13 17:31:00', 'https://meet.google.com/AwtnpUYZaq', NULL, 149, 'completed', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(13, 10, 11, 14, 'Case Study Analysis - UI/UX Design', 'Join us for an interactive live class on Case Study Analysis', '2025-12-31 14:01:00', NULL, NULL, 'https://meet.google.com/R9FBAUiFJi', NULL, 131, 'live', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(14, 2, 3, 2, 'Industry Insights - Web Development Fundamentals', 'Join us for an interactive live class on Industry Insights', '2025-11-22 15:01:00', '2025-11-22 15:06:00', '2025-11-22 17:01:00', 'https://meet.google.com/fbrQGER8XD', NULL, 96, 'completed', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(15, 2, 3, 10, 'Career Guidance - Web Development Fundamentals', 'Join us for an interactive live class on Career Guidance', '2025-12-18 13:43:00', NULL, NULL, 'https://meet.google.com/Ze4I4LaIXX', NULL, 66, 'live', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(16, 4, 5, 13, 'Mock Interview - React.js Complete Guide', 'Join us for an interactive live class on Mock Interview', '2026-01-07 12:33:00', '2026-01-07 12:38:00', '2026-01-07 14:33:00', 'https://meet.google.com/49qzVIeT6f', NULL, 131, 'completed', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(17, 2, 3, 11, 'Introduction Session - Web Development Fundamentals', 'Join us for an interactive live class on Introduction Session', '2026-01-13 18:40:00', '2026-01-13 18:45:00', '2026-01-13 20:40:00', 'https://meet.google.com/NHq3TJGPQq', NULL, 157, 'completed', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(18, 27, NULL, 11, 'Core Concepts Overview - Graphic Design', 'Join us for an interactive live class on Core Concepts Overview', '2026-01-10 11:57:00', NULL, NULL, 'https://meet.google.com/ZPNoZMjy4L', NULL, 155, 'live', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(19, 3, 9, 2, 'Hands-on Practice - Mobile App Development', 'Join us for an interactive live class on Hands-on Practice', '2025-12-24 09:53:00', NULL, '2025-12-18 18:25:21', 'https://meet.google.com/34c4lyHRmY', NULL, 95, 'completed', '2025-12-18 12:17:42', '2025-12-18 12:55:21'),
(20, 19, NULL, 7, 'Q&A Session - React.js Complete Guide', 'Join us for an interactive live class on Q&A Session', '2025-12-25 18:26:00', NULL, NULL, 'https://meet.google.com/tNpRahEmLr', NULL, 128, 'scheduled', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(21, 13, 31, 11, 'Project Discussion - Content Writing', 'Join us for an interactive live class on Project Discussion', '2025-11-18 18:35:00', NULL, NULL, 'https://meet.google.com/lhzegl3mC9', NULL, 150, 'scheduled', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(22, 14, 32, 14, 'Advanced Topics - Video Editing', 'Join us for an interactive live class on Advanced Topics', '2026-01-09 12:29:00', NULL, NULL, 'https://meet.google.com/KvkNcAaf9x', NULL, 164, 'live', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(23, 24, NULL, 8, 'Review and Recap - Mobile App Development', 'Join us for an interactive live class on Review and Recap', '2025-12-08 11:08:00', '2025-12-08 11:13:00', '2025-12-08 13:08:00', 'https://meet.google.com/iH2bb7uEQa', NULL, 74, 'completed', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(24, 29, NULL, 2, 'Final Assessment - Video Editing', 'Join us for an interactive live class on Final Assessment', '2025-12-16 10:06:00', NULL, NULL, 'https://meet.google.com/N5QEo36nsf', NULL, 130, 'live', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(25, 24, NULL, 8, 'Guest Lecture - Mobile App Development', 'Join us for an interactive live class on Guest Lecture', '2025-12-30 14:06:00', '2025-12-30 14:11:00', '2025-12-30 16:06:00', 'https://meet.google.com/72g6Cbo6gj', NULL, 162, 'completed', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(26, 2, 3, 7, 'Workshop Session - Web Development Fundamentals', 'Join us for an interactive live class on Workshop Session', '2025-12-26 12:33:00', NULL, NULL, 'https://meet.google.com/6HtMrP4Nqy', NULL, 105, 'live', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(27, 23, NULL, 11, 'Group Activity - Data Science with Python', 'Join us for an interactive live class on Group Activity', '2025-11-19 18:42:00', NULL, NULL, 'https://meet.google.com/n8V3DwAkMZ', NULL, 124, 'live', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(28, 11, 12, 10, 'Case Study Analysis - Digital Marketing', 'Join us for an interactive live class on Case Study Analysis', '2025-12-25 13:32:00', '2025-12-25 13:37:00', '2025-12-25 15:32:00', 'https://meet.google.com/m9F2oIKUGs', NULL, 74, 'completed', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(29, 30, NULL, 8, 'Industry Insights - Animation Course', 'Join us for an interactive live class on Industry Insights', '2025-11-19 17:44:00', NULL, NULL, 'https://meet.google.com/UXWYp90atZ', NULL, 100, 'live', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(30, 18, NULL, 9, 'Career Guidance - Advanced JavaScript', 'Join us for an interactive live class on Career Guidance', '2025-12-12 09:51:00', NULL, NULL, 'https://meet.google.com/RybsSULxN9', NULL, 101, 'scheduled', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(31, 9, 10, 11, 'Mock Interview - Mobile App Development', 'Join us for an interactive live class on Mock Interview', '2025-12-02 11:40:00', NULL, NULL, 'https://meet.google.com/I4zMQ7LnWD', NULL, 138, 'scheduled', '2025-12-18 12:17:42', '2025-12-18 12:17:42');

-- --------------------------------------------------------

--
-- Table structure for table `login_history`
--

CREATE TABLE `login_history` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `logged_in_at` timestamp NOT NULL,
  `logged_out_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `login_history`
--

INSERT INTO `login_history` (`id`, `user_id`, `ip_address`, `user_agent`, `logged_in_at`, `logged_out_at`, `created_at`, `updated_at`) VALUES
(1, 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 10:41:02', NULL, '2025-12-18 10:41:02', '2025-12-18 10:41:02'),
(2, 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 10:41:14', NULL, '2025-12-18 10:41:14', '2025-12-18 10:41:14'),
(3, 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 11:04:16', NULL, '2025-12-18 11:04:16', '2025-12-18 11:04:16'),
(4, 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 11:04:16', NULL, '2025-12-18 11:04:16', '2025-12-18 11:04:16'),
(5, 9, '172.16.1.50', 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_0 like Mac OS X) AppleWebKit/605.1.15', '2025-11-19 04:51:18', NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(6, 3, '172.16.0.10', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36', '2025-11-22 14:14:18', '2025-11-22 21:14:18', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(7, 20, '172.16.0.10', 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_0 like Mac OS X) AppleWebKit/605.1.15', '2025-12-02 11:22:18', NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(8, 20, '192.168.2.10', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36', '2025-11-24 01:19:18', '2025-11-24 04:19:18', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(9, 18, '192.168.0.25', 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_0 like Mac OS X) AppleWebKit/605.1.15', '2025-12-13 07:12:18', NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(10, 22, '192.168.1.102', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-11-20 06:09:18', NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(11, 28, '192.168.1.101', 'Mozilla/5.0 (Android 10; Mobile) AppleWebKit/537.36', '2025-12-13 20:56:18', '2025-12-13 22:56:18', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(12, 7, '172.16.1.50', 'Mozilla/5.0 (Android 10; Mobile) AppleWebKit/537.36', '2025-11-17 14:44:18', NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(13, 3, '10.0.0.50', 'Mozilla/5.0 (Android 10; Mobile) AppleWebKit/537.36', '2025-12-16 04:25:18', '2025-12-16 09:25:18', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(14, 9, '192.168.1.102', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36', '2025-11-20 15:47:18', '2025-11-20 22:47:18', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(15, 10, '192.168.2.10', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36', '2025-12-07 19:23:18', NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(16, 1, '172.16.1.50', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36', '2025-11-23 19:11:18', NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(17, 28, '172.16.0.10', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36', '2025-12-08 04:40:18', NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(18, 23, '192.168.1.102', 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_0 like Mac OS X) AppleWebKit/605.1.15', '2025-12-07 18:48:18', '2025-12-08 02:48:18', '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(19, 20, '10.0.0.50', 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_0 like Mac OS X) AppleWebKit/605.1.15', '2025-12-17 11:21:18', NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(20, 16, '192.168.1.101', 'Mozilla/5.0 (Android 10; Mobile) AppleWebKit/537.36', '2025-11-28 05:54:42', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(21, 19, '172.16.0.10', 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_0 like Mac OS X) AppleWebKit/605.1.15', '2025-11-26 13:48:42', '2025-11-26 19:48:42', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(22, 10, '192.168.2.10', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36', '2025-12-08 03:53:42', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(23, 2, '192.168.1.102', 'Mozilla/5.0 (Android 10; Mobile) AppleWebKit/537.36', '2025-12-03 00:54:42', '2025-12-03 06:54:42', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(24, 21, '10.0.1.100', 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_0 like Mac OS X) AppleWebKit/605.1.15', '2025-12-09 15:55:42', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(25, 29, '172.16.0.10', 'Mozilla/5.0 (Android 10; Mobile) AppleWebKit/537.36', '2025-11-21 09:42:42', '2025-11-21 11:42:42', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(26, 11, '10.0.0.50', 'Mozilla/5.0 (Android 10; Mobile) AppleWebKit/537.36', '2025-12-16 00:23:42', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(27, 13, '192.168.0.25', 'Mozilla/5.0 (Android 10; Mobile) AppleWebKit/537.36', '2025-11-23 12:56:42', '2025-11-23 20:56:42', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(28, 27, '10.0.1.100', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36', '2025-11-19 01:35:42', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(29, 21, '10.0.1.100', 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_0 like Mac OS X) AppleWebKit/605.1.15', '2025-11-21 02:48:42', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(30, 16, '192.168.1.100', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-11-23 06:39:42', '2025-11-23 08:39:42', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(31, 29, '192.168.1.100', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36', '2025-11-26 13:17:42', '2025-11-26 14:17:42', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(32, 10, '10.0.1.100', 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_0 like Mac OS X) AppleWebKit/605.1.15', '2025-11-29 07:32:42', '2025-11-29 11:32:42', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(33, 9, '192.168.1.100', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36', '2025-12-12 07:06:42', '2025-12-12 12:06:42', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(34, 1, '172.16.0.10', 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_0 like Mac OS X) AppleWebKit/605.1.15', '2025-11-23 21:28:42', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(35, 3, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 13:14:43', NULL, '2025-12-18 13:14:43', '2025-12-18 13:14:43'),
(36, 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:20:37', NULL, '2025-12-18 14:20:37', '2025-12-18 14:20:37'),
(37, 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', '2025-12-18 14:20:37', NULL, '2025-12-18 14:20:37', '2025-12-18 14:20:37');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu_permissions`
--

CREATE TABLE `menu_permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `menu_id` bigint UNSIGNED NOT NULL,
  `permission_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_12_16_094307_add_guard_and_status_to_users_table', 1),
(5, '2025_12_16_094307_create_roles_table', 1),
(6, '2025_12_16_094308_create_permissions_table', 1),
(7, '2025_12_16_094308_create_role_user_table', 1),
(8, '2025_12_16_094309_create_permission_role_table', 1),
(9, '2025_12_16_094310_create_menu_permissions_table', 1),
(10, '2025_12_16_094310_create_menus_table', 1),
(11, '2025_12_16_101330_create_activity_logs_table', 2),
(12, '2025_12_16_101330_create_settings_table', 2),
(13, '2025_12_18_045104_create_courses_table', 3),
(14, '2025_12_18_045107_create_batches_table', 3),
(15, '2025_12_18_045109_create_enrollments_table', 3),
(16, '2025_12_18_045112_create_videos_table', 3),
(17, '2025_12_18_045114_create_certificates_table', 3),
(18, '2025_12_18_045115_create_course_trainer_table', 3),
(19, '2025_12_18_045117_create_live_classes_table', 3),
(20, '2025_12_18_045119_create_attendances_table', 3),
(21, '2025_12_18_045120_create_community_queries_table', 3),
(22, '2025_12_18_045122_create_hiring_applications_table', 3),
(23, '2025_12_18_051859_create_jobs_table', 4),
(24, '2025_12_18_054754_create_activity_logs_table', 5),
(25, '2025_12_18_054755_create_login_history_table', 6),
(26, '2025_12_18_054755_create_notifications_table', 7),
(27, '2025_12_18_162614_add_thumbnail_and_duration_to_live_classes_table', 8),
(28, '2025_12_18_164130_add_batch_id_and_status_to_videos_table', 9),
(29, '2025_12_18_170256_create_quizzes_table', 10),
(30, '2025_12_18_170256_create_quiz_questions_table', 11),
(31, '2025_12_18_170256_create_satsangs_table', 12),
(32, '2025_12_18_164704_add_description_and_thumbnail_to_batches_table', 13),
(33, '2025_12_18_173821_create_playlists_table', 14),
(34, '2025_12_18_173821_create_playlist_video_table', 15),
(35, '2025_12_18_174047_add_views_and_scheduled_at_to_videos_table', 16),
(36, '2025_12_18_181026_create_quiz_attempts_table', 17),
(37, '2025_12_18_181026_add_views_to_quizzes_table', 18);

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `playlists`
--

CREATE TABLE `playlists` (
  `id` bigint UNSIGNED NOT NULL,
  `trainer_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `playlists`
--

INSERT INTO `playlists` (`id`, `trainer_id`, `title`, `description`, `created_at`, `updated_at`) VALUES
(1, 10, 'Web Development Basics', 'Step-by-step tutorials and examples.', '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(2, 14, 'Advanced JavaScript', 'A comprehensive playlist covering all the basics.', '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(3, 5, 'React Complete Course', 'Step-by-step tutorials and examples.', '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(4, 2, 'Node.js Backend Series', 'A comprehensive playlist covering all the basics.', '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(5, 10, 'Full Stack Projects', 'Learn advanced concepts and techniques.', '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(6, 12, 'Python Programming', 'Complete course from beginner to advanced.', '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(7, 2, 'Data Science Fundamentals', 'Real-world projects and case studies.', '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(8, 14, 'Mobile App Development', 'A comprehensive playlist covering all the basics.', '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(9, 11, 'UI/UX Design Principles', 'Step-by-step tutorials and examples.', '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(10, 13, 'Digital Marketing Strategies', 'A comprehensive playlist covering all the basics.', '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(11, 11, 'Graphic Design Mastery', 'A comprehensive playlist covering all the basics.', '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(12, 5, 'Content Writing Guide', 'Learn advanced concepts and techniques.', '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(13, 8, 'Video Editing Tutorials', 'A comprehensive playlist covering all the basics.', '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(14, 12, 'Animation Techniques', 'Step-by-step tutorials and examples.', '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(15, 5, 'SEO Best Practices', 'Real-world projects and case studies.', '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(16, 8, 'Web Development Basics', 'Learn advanced concepts and techniques.', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(17, 8, 'Advanced JavaScript', 'Real-world projects and case studies.', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(18, 2, 'React Complete Course', 'Step-by-step tutorials and examples.', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(19, 13, 'Node.js Backend Series', 'Real-world projects and case studies.', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(20, 14, 'Full Stack Projects', 'A comprehensive playlist covering all the basics.', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(21, 11, 'Python Programming', 'Learn advanced concepts and techniques.', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(22, 6, 'Data Science Fundamentals', 'Real-world projects and case studies.', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(23, 6, 'Mobile App Development', 'Complete course from beginner to advanced.', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(24, 14, 'UI/UX Design Principles', 'Learn advanced concepts and techniques.', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(25, 11, 'Digital Marketing Strategies', 'Complete course from beginner to advanced.', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(26, 7, 'Graphic Design Mastery', 'Real-world projects and case studies.', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(27, 9, 'Content Writing Guide', 'Real-world projects and case studies.', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(28, 10, 'Video Editing Tutorials', 'Complete course from beginner to advanced.', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(29, 7, 'Animation Techniques', 'Complete course from beginner to advanced.', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(30, 14, 'SEO Best Practices', 'Learn advanced concepts and techniques.', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(31, 2, 'sadas', 'asdad', '2025-12-18 12:19:24', '2025-12-18 12:19:24'),
(32, 2, 'dsdsd', 'sdsds', '2025-12-18 12:21:37', '2025-12-18 12:21:37'),
(33, 2, 'sss', 'sss', '2025-12-18 12:23:06', '2025-12-18 12:23:06');

-- --------------------------------------------------------

--
-- Table structure for table `playlist_video`
--

CREATE TABLE `playlist_video` (
  `id` bigint UNSIGNED NOT NULL,
  `playlist_id` bigint UNSIGNED NOT NULL,
  `video_id` bigint UNSIGNED NOT NULL,
  `order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` bigint UNSIGNED NOT NULL,
  `trainer_id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `quiz_type` enum('practice','assessment','exam') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'practice',
  `status` enum('draft','published','archived') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `time_limit` int DEFAULT NULL,
  `total_questions` int NOT NULL DEFAULT '0',
  `views` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`id`, `trainer_id`, `course_id`, `title`, `description`, `quiz_type`, `status`, `time_limit`, `total_questions`, `views`, `created_at`, `updated_at`) VALUES
(1, 12, 11, 'Quiz 1 - Digital Marketing', 'Test your knowledge of Digital Marketing with this comprehensive quiz.', 'practice', 'archived', 18, 16, 0, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(2, 10, 6, 'Quiz 2 - Full Stack Development', 'Test your knowledge of Full Stack Development with this comprehensive quiz.', 'exam', 'published', 59, 11, 0, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(3, 11, 13, 'Quiz 3 - Content Writing', 'Test your knowledge of Content Writing with this comprehensive quiz.', 'assessment', 'draft', 85, 7, 0, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(4, 5, 3, 'Quiz 4 - Advanced JavaScript', 'Test your knowledge of Advanced JavaScript with this comprehensive quiz.', 'practice', 'published', 26, 10, 0, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(5, 11, 11, 'Quiz 5 - Digital Marketing', 'Test your knowledge of Digital Marketing with this comprehensive quiz.', 'practice', 'draft', 71, 7, 0, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(6, 10, 1, 'Quiz 6 - App Devlopermnt', 'Test your knowledge of App Devlopermnt with this comprehensive quiz.', 'exam', 'archived', 35, 8, 0, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(7, 14, 6, 'Quiz 7 - Full Stack Development', 'Test your knowledge of Full Stack Development with this comprehensive quiz.', 'practice', 'draft', 41, 13, 0, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(8, 2, 10, 'Quiz 8 - UI/UX Design', 'Test your knowledge of UI/UX Design with this comprehensive quiz.', 'assessment', 'draft', 58, 17, 1, '2025-12-18 12:17:19', '2025-12-18 12:43:35'),
(9, 8, 5, 'Quiz 9 - Node.js Backend Development', 'Test your knowledge of Node.js Backend Development with this comprehensive quiz.', 'assessment', 'published', 67, 14, 0, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(10, 11, 12, 'Quiz 10 - Graphic Design', 'Test your knowledge of Graphic Design with this comprehensive quiz.', 'exam', 'archived', 58, 5, 0, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(11, 9, 15, 'Quiz 11 - Animation Course', 'Test your knowledge of Animation Course with this comprehensive quiz.', 'practice', 'draft', 24, 9, 0, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(12, 12, 6, 'Quiz 12 - Full Stack Development', 'Test your knowledge of Full Stack Development with this comprehensive quiz.', 'exam', 'draft', 82, 11, 0, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(13, 6, 1, 'Quiz 13 - App Devlopermnt', 'Test your knowledge of App Devlopermnt with this comprehensive quiz.', 'exam', 'archived', 54, 8, 0, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(14, 11, 14, 'Quiz 14 - Video Editing', 'Test your knowledge of Video Editing with this comprehensive quiz.', 'exam', 'archived', 114, 16, 0, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(15, 13, 16, 'Quiz 15 - SEO Course', 'Test your knowledge of SEO Course with this comprehensive quiz.', 'exam', 'archived', 34, 9, 0, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(16, 6, 16, 'Quiz 1 - SEO Course', 'Test your knowledge of SEO Course with this comprehensive quiz.', 'practice', 'published', 114, 18, 0, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(17, 6, 29, 'Quiz 2 - Video Editing', 'Test your knowledge of Video Editing with this comprehensive quiz.', 'practice', 'published', 57, 19, 0, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(18, 11, 30, 'Quiz 3 - Animation Course', 'Test your knowledge of Animation Course with this comprehensive quiz.', 'assessment', 'archived', 93, 7, 0, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(19, 11, 16, 'Quiz 4 - SEO Course', 'Test your knowledge of SEO Course with this comprehensive quiz.', 'exam', 'archived', 29, 9, 0, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(20, 5, 23, 'Quiz 5 - Data Science with Python', 'Test your knowledge of Data Science with Python with this comprehensive quiz.', 'practice', 'archived', 81, 15, 0, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(21, 2, 29, 'Quiz 6 - Video Editing', 'Test your knowledge of Video Editing with this comprehensive quiz.', 'assessment', 'draft', 57, 15, 0, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(22, 13, 20, 'Quiz 7 - Node.js Backend Development', 'Test your knowledge of Node.js Backend Development with this comprehensive quiz.', 'exam', 'archived', 118, 7, 0, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(23, 9, 30, 'Quiz 8 - Animation Course', 'Test your knowledge of Animation Course with this comprehensive quiz.', 'exam', 'draft', 31, 11, 0, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(24, 13, 20, 'Quiz 9 - Node.js Backend Development', 'Test your knowledge of Node.js Backend Development with this comprehensive quiz.', 'assessment', 'published', 117, 11, 0, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(25, 11, 11, 'Quiz 10 - Digital Marketing', 'Test your knowledge of Digital Marketing with this comprehensive quiz.', 'practice', 'archived', 65, 19, 0, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(26, 11, 21, 'Quiz 11 - Full Stack Development', 'Test your knowledge of Full Stack Development with this comprehensive quiz.', 'assessment', 'published', 15, 20, 0, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(27, 14, 9, 'Quiz 12 - Mobile App Development', 'Test your knowledge of Mobile App Development with this comprehensive quiz.', 'practice', 'archived', 68, 17, 0, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(28, 9, 14, 'Quiz 13 - Video Editing', 'Test your knowledge of Video Editing with this comprehensive quiz.', 'assessment', 'draft', 89, 11, 0, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(29, 9, 31, 'Quiz 14 - SEO Course', 'Test your knowledge of SEO Course with this comprehensive quiz.', 'exam', 'archived', 39, 10, 0, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(30, 5, 19, 'Quiz 15 - React.js Complete Guide', 'Test your knowledge of React.js Complete Guide with this comprehensive quiz.', 'exam', 'archived', 24, 13, 0, '2025-12-18 12:17:42', '2025-12-18 12:17:42');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_attempts`
--

CREATE TABLE `quiz_attempts` (
  `id` bigint UNSIGNED NOT NULL,
  `quiz_id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `score` int NOT NULL DEFAULT '0',
  `total_points` int NOT NULL DEFAULT '0',
  `percentage` decimal(5,2) NOT NULL DEFAULT '0.00',
  `answers` json NOT NULL,
  `started_at` datetime NOT NULL,
  `completed_at` datetime DEFAULT NULL,
  `status` enum('in_progress','completed','abandoned') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'in_progress',
  `time_taken` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quiz_attempts`
--

INSERT INTO `quiz_attempts` (`id`, `quiz_id`, `student_id`, `score`, `total_points`, `percentage`, `answers`, `started_at`, `completed_at`, `status`, `time_taken`, `created_at`, `updated_at`) VALUES
(1, 4, 27, 15, 26, 57.69, '{\"14\": 3, \"15\": 1, \"16\": 2, \"17\": 0, \"60\": 0, \"61\": 1, \"62\": 1, \"63\": 2}', '2025-12-07 17:12:06', NULL, 'abandoned', NULL, '2025-12-18 12:42:06', '2025-12-18 12:42:06'),
(3, 27, 20, 0, 0, 0.00, '[]', '2025-12-18 10:12:06', '2025-12-18 11:08:06', 'completed', 3360, '2025-12-18 12:42:06', '2025-12-18 12:42:06'),
(4, 2, 25, 7, 25, 28.00, '{\"5\": 1, \"6\": 2, \"7\": 2, \"8\": 2, \"9\": 0, \"52\": 2, \"53\": 2, \"54\": 2}', '2025-11-22 14:12:06', '2025-11-22 14:31:06', 'completed', 1140, '2025-12-18 12:42:06', '2025-12-18 12:42:06'),
(5, 21, 25, 0, 0, 0.00, '[]', '2025-12-09 22:12:06', NULL, 'in_progress', NULL, '2025-12-18 12:42:06', '2025-12-18 12:42:06'),
(6, 5, 22, 2, 13, 15.38, '{\"18\": 0, \"19\": 0, \"20\": 2, \"21\": 1, \"64\": 2, \"65\": 1, \"66\": 1}', '2025-11-17 19:12:06', '2025-11-17 19:23:06', 'completed', 660, '2025-12-18 12:42:06', '2025-12-18 12:42:06'),
(7, 12, 28, 5, 15, 33.33, '{\"45\": 2, \"46\": 1, \"47\": 1, \"48\": 3, \"94\": 1, \"95\": 2, \"96\": 2}', '2025-12-04 21:12:06', NULL, 'in_progress', NULL, '2025-12-18 12:42:06', '2025-12-18 12:42:06'),
(8, 12, 22, 5, 15, 33.33, '{\"45\": 1, \"46\": 2, \"47\": 0, \"48\": 3, \"94\": 1, \"95\": 1, \"96\": 1}', '2025-12-08 23:12:06', '2025-12-08 23:28:06', 'completed', 960, '2025-12-18 12:42:06', '2025-12-18 12:42:06'),
(9, 30, 22, 0, 0, 0.00, '[]', '2025-11-20 00:12:06', '2025-11-20 00:30:06', 'completed', 1080, '2025-12-18 12:42:06', '2025-12-18 12:42:06'),
(10, 16, 24, 0, 0, 0.00, '[]', '2025-12-12 17:12:06', NULL, 'in_progress', NULL, '2025-12-18 12:42:06', '2025-12-18 12:42:06'),
(11, 1, 27, 5, 13, 38.46, '{\"1\": 2, \"2\": 2, \"3\": 2, \"4\": 0, \"49\": 1, \"50\": 0, \"51\": 3}', '2025-11-23 02:12:06', NULL, 'abandoned', NULL, '2025-12-18 12:42:06', '2025-12-18 12:42:06'),
(12, 22, 17, 0, 0, 0.00, '[]', '2025-11-22 12:12:06', NULL, 'in_progress', NULL, '2025-12-18 12:42:06', '2025-12-18 12:42:06'),
(13, 20, 15, 0, 0, 0.00, '[]', '2025-11-29 17:12:06', '2025-11-29 17:57:06', 'completed', 2700, '2025-12-18 12:42:06', '2025-12-18 12:42:06'),
(14, 28, 21, 0, 0, 0.00, '[]', '2025-11-20 22:12:06', NULL, 'abandoned', NULL, '2025-12-18 12:42:06', '2025-12-18 12:42:06'),
(15, 25, 26, 0, 0, 0.00, '[]', '2025-12-03 15:12:06', '2025-12-03 15:48:06', 'completed', 2160, '2025-12-18 12:42:06', '2025-12-18 12:42:06');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_questions`
--

CREATE TABLE `quiz_questions` (
  `id` bigint UNSIGNED NOT NULL,
  `quiz_id` bigint UNSIGNED NOT NULL,
  `question` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` json NOT NULL,
  `correct_answer_index` int NOT NULL,
  `points` int NOT NULL DEFAULT '1',
  `order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quiz_questions`
--

INSERT INTO `quiz_questions` (`id`, `quiz_id`, `question`, `options`, `correct_answer_index`, `points`, `order`, `created_at`, `updated_at`) VALUES
(1, 1, 'What is the time complexity of this algorithm?', '[\"Option A\", \"Option B\", \"Option C\", \"Option D\"]', 0, 2, 1, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(2, 1, 'Which statement is true?', '[\"True\", \"False\", \"Maybe\", \"Not sure\"]', 1, 1, 2, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(3, 1, 'What does this function return?', '[\"Method 1\", \"Method 2\", \"Method 3\", \"Method 4\"]', 3, 3, 3, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(4, 1, 'Which approach is more efficient?', '[\"Approach A\", \"Approach B\", \"Approach C\", \"Approach D\"]', 0, 1, 4, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(5, 2, 'What is the main purpose of this concept?', '[\"Approach A\", \"Approach B\", \"Approach C\", \"Approach D\"]', 1, 2, 1, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(6, 2, 'Which of the following is correct?', '[\"O(n)\", \"O(log n)\", \"O(n²)\", \"O(1)\"]', 0, 5, 2, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(7, 2, 'What would be the output of this code?', '[\"Approach A\", \"Approach B\", \"Approach C\", \"Approach D\"]', 3, 1, 3, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(8, 2, 'Which method is best for this scenario?', '[\"Method 1\", \"Method 2\", \"Method 3\", \"Method 4\"]', 3, 4, 4, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(9, 2, 'What is the time complexity of this algorithm?', '[\"Option A\", \"Option B\", \"Option C\", \"Option D\"]', 3, 3, 5, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(10, 3, 'What would be the output of this code?', '[\"True\", \"False\", \"Maybe\", \"Not sure\"]', 0, 2, 1, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(11, 3, 'Which method is best for this scenario?', '[\"True\", \"False\", \"Maybe\", \"Not sure\"]', 3, 3, 2, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(12, 3, 'What is the time complexity of this algorithm?', '[\"Method 1\", \"Method 2\", \"Method 3\", \"Method 4\"]', 0, 4, 3, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(13, 3, 'Which statement is true?', '[\"Approach A\", \"Approach B\", \"Approach C\", \"Approach D\"]', 0, 1, 4, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(14, 4, 'What does this function return?', '[\"Approach A\", \"Approach B\", \"Approach C\", \"Approach D\"]', 2, 4, 1, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(15, 4, 'Which approach is more efficient?', '[\"True\", \"False\", \"Maybe\", \"Not sure\"]', 3, 2, 2, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(16, 4, 'What is the correct syntax?', '[\"Method 1\", \"Method 2\", \"Method 3\", \"Method 4\"]', 2, 5, 3, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(17, 4, 'Which option is the best practice?', '[\"Method 1\", \"Method 2\", \"Method 3\", \"Method 4\"]', 1, 3, 4, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(18, 5, 'What is the main purpose of this concept?', '[\"O(n)\", \"O(log n)\", \"O(n²)\", \"O(1)\"]', 3, 1, 1, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(19, 5, 'Which of the following is correct?', '[\"Option A\", \"Option B\", \"Option C\", \"Option D\"]', 3, 1, 2, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(20, 5, 'What would be the output of this code?', '[\"Approach A\", \"Approach B\", \"Approach C\", \"Approach D\"]', 1, 4, 3, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(21, 5, 'Which method is best for this scenario?', '[\"Option A\", \"Option B\", \"Option C\", \"Option D\"]', 3, 1, 4, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(22, 6, 'What is the correct syntax?', '[\"True\", \"False\", \"Maybe\", \"Not sure\"]', 3, 5, 1, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(23, 6, 'Which option is the best practice?', '[\"Approach A\", \"Approach B\", \"Approach C\", \"Approach D\"]', 3, 1, 2, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(24, 6, 'What is the main purpose of this concept?', '[\"True\", \"False\", \"Maybe\", \"Not sure\"]', 3, 3, 3, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(25, 7, 'Which of the following is correct?', '[\"O(n)\", \"O(log n)\", \"O(n²)\", \"O(1)\"]', 2, 5, 1, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(26, 7, 'What would be the output of this code?', '[\"Option A\", \"Option B\", \"Option C\", \"Option D\"]', 2, 4, 2, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(27, 7, 'Which method is best for this scenario?', '[\"Approach A\", \"Approach B\", \"Approach C\", \"Approach D\"]', 2, 3, 3, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(28, 8, 'What would be the output of this code?', '[\"Method 1\", \"Method 2\", \"Method 3\", \"Method 4\"]', 3, 5, 1, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(29, 8, 'Which method is best for this scenario?', '[\"O(n)\", \"O(log n)\", \"O(n²)\", \"O(1)\"]', 1, 1, 2, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(30, 8, 'What is the time complexity of this algorithm?', '[\"Method 1\", \"Method 2\", \"Method 3\", \"Method 4\"]', 1, 3, 3, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(31, 8, 'Which statement is true?', '[\"Method 1\", \"Method 2\", \"Method 3\", \"Method 4\"]', 3, 1, 4, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(32, 9, 'What does this function return?', '[\"Option A\", \"Option B\", \"Option C\", \"Option D\"]', 2, 5, 1, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(33, 9, 'Which approach is more efficient?', '[\"Approach A\", \"Approach B\", \"Approach C\", \"Approach D\"]', 0, 2, 2, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(34, 9, 'What is the correct syntax?', '[\"True\", \"False\", \"Maybe\", \"Not sure\"]', 3, 1, 3, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(35, 9, 'Which option is the best practice?', '[\"Approach A\", \"Approach B\", \"Approach C\", \"Approach D\"]', 0, 5, 4, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(36, 10, 'What is the main purpose of this concept?', '[\"Approach A\", \"Approach B\", \"Approach C\", \"Approach D\"]', 1, 1, 1, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(37, 10, 'Which of the following is correct?', '[\"Approach A\", \"Approach B\", \"Approach C\", \"Approach D\"]', 1, 1, 2, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(38, 10, 'What would be the output of this code?', '[\"True\", \"False\", \"Maybe\", \"Not sure\"]', 0, 1, 3, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(39, 10, 'Which method is best for this scenario?', '[\"O(n)\", \"O(log n)\", \"O(n²)\", \"O(1)\"]', 2, 3, 4, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(40, 10, 'What is the time complexity of this algorithm?', '[\"Approach A\", \"Approach B\", \"Approach C\", \"Approach D\"]', 3, 5, 5, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(41, 11, 'What is the time complexity of this algorithm?', '[\"Approach A\", \"Approach B\", \"Approach C\", \"Approach D\"]', 2, 1, 1, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(42, 11, 'Which statement is true?', '[\"Approach A\", \"Approach B\", \"Approach C\", \"Approach D\"]', 0, 5, 2, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(43, 11, 'What does this function return?', '[\"Option A\", \"Option B\", \"Option C\", \"Option D\"]', 1, 5, 3, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(44, 11, 'Which approach is more efficient?', '[\"Approach A\", \"Approach B\", \"Approach C\", \"Approach D\"]', 2, 2, 4, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(45, 12, 'What is the correct syntax?', '[\"O(n)\", \"O(log n)\", \"O(n²)\", \"O(1)\"]', 3, 1, 1, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(46, 12, 'Which option is the best practice?', '[\"O(n)\", \"O(log n)\", \"O(n²)\", \"O(1)\"]', 1, 4, 2, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(47, 12, 'What is the main purpose of this concept?', '[\"Option A\", \"Option B\", \"Option C\", \"Option D\"]', 2, 2, 3, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(48, 12, 'Which of the following is correct?', '[\"Approach A\", \"Approach B\", \"Approach C\", \"Approach D\"]', 3, 1, 4, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(49, 1, 'Which method is best for this scenario?', '[\"Approach A\", \"Approach B\", \"Approach C\", \"Approach D\"]', 2, 2, 1, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(50, 1, 'What is the time complexity of this algorithm?', '[\"Method 1\", \"Method 2\", \"Method 3\", \"Method 4\"]', 0, 3, 2, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(51, 1, 'Which statement is true?', '[\"True\", \"False\", \"Maybe\", \"Not sure\"]', 3, 1, 3, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(52, 2, 'What does this function return?', '[\"Approach A\", \"Approach B\", \"Approach C\", \"Approach D\"]', 2, 5, 1, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(53, 2, 'Which approach is more efficient?', '[\"Option A\", \"Option B\", \"Option C\", \"Option D\"]', 0, 1, 2, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(54, 2, 'What is the correct syntax?', '[\"Approach A\", \"Approach B\", \"Approach C\", \"Approach D\"]', 1, 4, 3, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(55, 3, 'Which statement is true?', '[\"Approach A\", \"Approach B\", \"Approach C\", \"Approach D\"]', 1, 2, 1, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(56, 3, 'What does this function return?', '[\"O(n)\", \"O(log n)\", \"O(n²)\", \"O(1)\"]', 1, 2, 2, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(57, 3, 'Which approach is more efficient?', '[\"Method 1\", \"Method 2\", \"Method 3\", \"Method 4\"]', 3, 4, 3, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(58, 3, 'What is the correct syntax?', '[\"Approach A\", \"Approach B\", \"Approach C\", \"Approach D\"]', 3, 2, 4, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(59, 3, 'Which option is the best practice?', '[\"Approach A\", \"Approach B\", \"Approach C\", \"Approach D\"]', 2, 1, 5, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(60, 4, 'What does this function return?', '[\"Method 1\", \"Method 2\", \"Method 3\", \"Method 4\"]', 0, 5, 1, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(61, 4, 'Which approach is more efficient?', '[\"Option A\", \"Option B\", \"Option C\", \"Option D\"]', 0, 1, 2, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(62, 4, 'What is the correct syntax?', '[\"Method 1\", \"Method 2\", \"Method 3\", \"Method 4\"]', 1, 5, 3, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(63, 4, 'Which option is the best practice?', '[\"Option A\", \"Option B\", \"Option C\", \"Option D\"]', 1, 1, 4, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(64, 5, 'Which statement is true?', '[\"Option A\", \"Option B\", \"Option C\", \"Option D\"]', 3, 2, 1, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(65, 5, 'What does this function return?', '[\"Method 1\", \"Method 2\", \"Method 3\", \"Method 4\"]', 1, 2, 2, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(66, 5, 'Which approach is more efficient?', '[\"Method 1\", \"Method 2\", \"Method 3\", \"Method 4\"]', 0, 2, 3, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(67, 6, 'What is the main purpose of this concept?', '[\"Method 1\", \"Method 2\", \"Method 3\", \"Method 4\"]', 3, 5, 1, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(68, 6, 'Which of the following is correct?', '[\"Approach A\", \"Approach B\", \"Approach C\", \"Approach D\"]', 3, 3, 2, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(69, 6, 'What would be the output of this code?', '[\"Method 1\", \"Method 2\", \"Method 3\", \"Method 4\"]', 2, 2, 3, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(70, 6, 'Which method is best for this scenario?', '[\"Approach A\", \"Approach B\", \"Approach C\", \"Approach D\"]', 0, 1, 4, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(71, 6, 'What is the time complexity of this algorithm?', '[\"Method 1\", \"Method 2\", \"Method 3\", \"Method 4\"]', 0, 5, 5, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(72, 7, 'Which statement is true?', '[\"True\", \"False\", \"Maybe\", \"Not sure\"]', 1, 3, 1, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(73, 7, 'What does this function return?', '[\"Approach A\", \"Approach B\", \"Approach C\", \"Approach D\"]', 2, 2, 2, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(74, 7, 'Which approach is more efficient?', '[\"O(n)\", \"O(log n)\", \"O(n²)\", \"O(1)\"]', 2, 3, 3, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(75, 7, 'What is the correct syntax?', '[\"True\", \"False\", \"Maybe\", \"Not sure\"]', 3, 2, 4, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(76, 7, 'Which option is the best practice?', '[\"True\", \"False\", \"Maybe\", \"Not sure\"]', 1, 1, 5, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(77, 8, 'What would be the output of this code?', '[\"O(n)\", \"O(log n)\", \"O(n²)\", \"O(1)\"]', 3, 5, 1, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(78, 8, 'Which method is best for this scenario?', '[\"Option A\", \"Option B\", \"Option C\", \"Option D\"]', 1, 3, 2, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(79, 8, 'What is the time complexity of this algorithm?', '[\"Option A\", \"Option B\", \"Option C\", \"Option D\"]', 3, 4, 3, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(80, 8, 'Which statement is true?', '[\"Method 1\", \"Method 2\", \"Method 3\", \"Method 4\"]', 0, 5, 4, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(81, 9, 'Which statement is true?', '[\"O(n)\", \"O(log n)\", \"O(n²)\", \"O(1)\"]', 1, 4, 1, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(82, 9, 'What does this function return?', '[\"Method 1\", \"Method 2\", \"Method 3\", \"Method 4\"]', 3, 2, 2, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(83, 9, 'Which approach is more efficient?', '[\"Option A\", \"Option B\", \"Option C\", \"Option D\"]', 3, 4, 3, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(84, 9, 'What is the correct syntax?', '[\"Option A\", \"Option B\", \"Option C\", \"Option D\"]', 3, 3, 4, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(85, 9, 'Which option is the best practice?', '[\"Approach A\", \"Approach B\", \"Approach C\", \"Approach D\"]', 0, 4, 5, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(86, 10, 'What is the main purpose of this concept?', '[\"Method 1\", \"Method 2\", \"Method 3\", \"Method 4\"]', 1, 2, 1, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(87, 10, 'Which of the following is correct?', '[\"True\", \"False\", \"Maybe\", \"Not sure\"]', 1, 1, 2, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(88, 10, 'What would be the output of this code?', '[\"True\", \"False\", \"Maybe\", \"Not sure\"]', 0, 3, 3, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(89, 11, 'Which statement is true?', '[\"Approach A\", \"Approach B\", \"Approach C\", \"Approach D\"]', 3, 2, 1, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(90, 11, 'What does this function return?', '[\"Option A\", \"Option B\", \"Option C\", \"Option D\"]', 0, 4, 2, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(91, 11, 'Which approach is more efficient?', '[\"O(n)\", \"O(log n)\", \"O(n²)\", \"O(1)\"]', 0, 5, 3, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(92, 11, 'What is the correct syntax?', '[\"True\", \"False\", \"Maybe\", \"Not sure\"]', 0, 4, 4, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(93, 11, 'Which option is the best practice?', '[\"Method 1\", \"Method 2\", \"Method 3\", \"Method 4\"]', 2, 4, 5, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(94, 12, 'What does this function return?', '[\"Approach A\", \"Approach B\", \"Approach C\", \"Approach D\"]', 2, 1, 1, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(95, 12, 'Which approach is more efficient?', '[\"Approach A\", \"Approach B\", \"Approach C\", \"Approach D\"]', 3, 2, 2, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(96, 12, 'What is the correct syntax?', '[\"Option A\", \"Option B\", \"Option C\", \"Option D\"]', 1, 4, 3, '2025-12-18 12:17:42', '2025-12-18 12:17:42');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `satsangs`
--

CREATE TABLE `satsangs` (
  `id` bigint UNSIGNED NOT NULL,
  `trainer_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `visibility` enum('private','unlisted','public') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'private',
  `scheduled_at` datetime NOT NULL,
  `time` time NOT NULL,
  `timezone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'UTC +05:30 (India)',
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `create_playlist` tinyint(1) NOT NULL DEFAULT '0',
  `status` enum('scheduled','live','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'scheduled',
  `meeting_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `satsangs`
--

INSERT INTO `satsangs` (`id`, `trainer_id`, `title`, `description`, `visibility`, `scheduled_at`, `time`, `timezone`, `thumbnail`, `create_playlist`, `status`, `meeting_link`, `created_at`, `updated_at`) VALUES
(1, 12, 'Career Guidance Session', 'Join us for an insightful session on Career Guidance Session', 'private', '2025-12-19 14:28:00', '14:28:00', 'UTC -05:00 (EST)', NULL, 1, 'cancelled', NULL, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(2, 9, 'Industry Insights Discussion', 'Join us for an insightful session on Industry Insights Discussion', 'private', '2026-01-07 16:29:00', '16:29:00', 'UTC -05:00 (EST)', NULL, 1, 'cancelled', NULL, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(3, 10, 'Career Path Planning', 'Join us for an insightful session on Career Path Planning', 'private', '2025-12-17 13:44:00', '13:44:00', 'UTC +00:00 (GMT)', NULL, 1, 'completed', 'https://meet.google.com/rnfMRiFkev', '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(4, 9, 'Professional Development Talk', 'Join us for an insightful session on Professional Development Talk', 'unlisted', '2025-12-11 15:36:00', '15:36:00', 'UTC -05:00 (EST)', NULL, 0, 'cancelled', NULL, '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(5, 12, 'Career Opportunities in Tech', 'Join us for an insightful session on Career Opportunities in Tech', 'private', '2025-12-19 15:15:00', '15:15:00', 'UTC +01:00 (CET)', NULL, 1, 'scheduled', 'https://meet.google.com/qNhaYECXXh', '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(6, 8, 'Interview Preparation Tips', 'Join us for an insightful session on Interview Preparation Tips', 'unlisted', '2025-12-29 14:25:00', '14:25:00', 'UTC +05:30 (India)', NULL, 1, 'scheduled', 'https://meet.google.com/3zWVqnYdQB', '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(7, 9, 'Resume Building Workshop', 'Join us for an insightful session on Resume Building Workshop', 'private', '2026-01-16 20:13:00', '20:13:00', 'UTC +00:00 (GMT)', NULL, 0, 'live', 'https://meet.google.com/cplHosZSUv', '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(8, 10, 'Networking Strategies', 'Join us for an insightful session on Networking Strategies', 'public', '2025-12-26 12:40:00', '12:40:00', 'UTC -05:00 (EST)', NULL, 1, 'completed', 'https://meet.google.com/t9J8fnYG7V', '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(9, 13, 'Salary Negotiation Guide', 'Join us for an insightful session on Salary Negotiation Guide', 'private', '2025-12-10 20:24:00', '20:24:00', 'UTC -05:00 (EST)', NULL, 0, 'scheduled', 'https://meet.google.com/2lVIVUXaj9', '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(10, 10, 'Career Transition Advice', 'Join us for an insightful session on Career Transition Advice', 'public', '2025-12-10 15:33:00', '15:33:00', 'UTC +05:30 (India)', NULL, 0, 'completed', 'https://meet.google.com/Y91HYdcn3q', '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(11, 12, 'Freelancing Opportunities', 'Join us for an insightful session on Freelancing Opportunities', 'public', '2026-01-04 13:52:00', '13:52:00', 'UTC -05:00 (EST)', NULL, 0, 'completed', 'https://meet.google.com/trIoOvd3nG', '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(12, 5, 'Entrepreneurship Journey', 'Join us for an insightful session on Entrepreneurship Journey', 'unlisted', '2026-01-10 13:36:00', '13:36:00', 'UTC +05:30 (India)', NULL, 1, 'live', 'https://meet.google.com/Ff0Mk4ZrNq', '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(13, 7, 'Work-Life Balance', 'Join us for an insightful session on Work-Life Balance', 'public', '2026-01-07 19:58:00', '19:58:00', 'UTC +01:00 (CET)', NULL, 0, 'completed', 'https://meet.google.com/8lSEPo6SEg', '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(14, 2, 'Skill Development Roadmap', 'Join us for an insightful session on Skill Development Roadmap', 'unlisted', '2026-01-02 16:07:00', '16:07:00', 'UTC +00:00 (GMT)', NULL, 1, 'scheduled', 'https://meet.google.com/4ZDsA8pNax', '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(15, 6, 'Future of Technology', 'Join us for an insightful session on Future of Technology', 'public', '2026-01-05 13:09:00', '13:09:00', 'UTC +01:00 (CET)', NULL, 1, 'scheduled', 'https://meet.google.com/E0jT0TXmJV', '2025-12-18 12:17:19', '2025-12-18 12:17:19'),
(16, 8, 'Career Guidance Session', 'Join us for an insightful session on Career Guidance Session', 'unlisted', '2025-12-05 17:18:00', '17:18:00', 'UTC +00:00 (GMT)', NULL, 0, 'live', 'https://meet.google.com/XILRAj6u4U', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(17, 6, 'Industry Insights Discussion', 'Join us for an insightful session on Industry Insights Discussion', 'public', '2025-12-05 17:21:00', '17:21:00', 'UTC +00:00 (GMT)', NULL, 1, 'cancelled', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(18, 12, 'Career Path Planning', 'Join us for an insightful session on Career Path Planning', 'unlisted', '2025-12-23 13:41:00', '13:41:00', 'UTC +00:00 (GMT)', NULL, 1, 'scheduled', 'https://meet.google.com/O7GssUfTu1', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(19, 14, 'Professional Development Talk', 'Join us for an insightful session on Professional Development Talk', 'public', '2025-12-23 10:33:00', '10:33:00', 'UTC +00:00 (GMT)', NULL, 0, 'cancelled', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(20, 9, 'Career Opportunities in Tech', 'Join us for an insightful session on Career Opportunities in Tech', 'public', '2026-01-02 10:43:00', '10:43:00', 'UTC +00:00 (GMT)', NULL, 0, 'live', 'https://meet.google.com/kPFlnE3VrW', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(21, 9, 'Interview Preparation Tips', 'Join us for an insightful session on Interview Preparation Tips', 'private', '2026-01-09 15:27:00', '15:27:00', 'UTC +05:30 (India)', NULL, 1, 'cancelled', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(22, 10, 'Resume Building Workshop', 'Join us for an insightful session on Resume Building Workshop', 'public', '2026-01-13 10:49:00', '10:49:00', 'UTC +01:00 (CET)', NULL, 0, 'scheduled', 'https://meet.google.com/G8r64hq8Oy', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(23, 6, 'Networking Strategies', 'Join us for an insightful session on Networking Strategies', 'private', '2026-01-08 14:24:00', '14:24:00', 'UTC +05:30 (India)', NULL, 1, 'scheduled', 'https://meet.google.com/4kC5HUSuPk', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(24, 14, 'Salary Negotiation Guide', 'Join us for an insightful session on Salary Negotiation Guide', 'private', '2026-01-04 10:49:00', '10:49:00', 'UTC +05:30 (India)', NULL, 1, 'live', 'https://meet.google.com/8cJE7OmNpm', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(25, 13, 'Career Transition Advice', 'Join us for an insightful session on Career Transition Advice', 'private', '2026-01-08 14:02:00', '14:02:00', 'UTC +00:00 (GMT)', NULL, 1, 'completed', 'https://meet.google.com/o8oWsnxaOx', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(26, 7, 'Freelancing Opportunities', 'Join us for an insightful session on Freelancing Opportunities', 'private', '2025-12-05 15:02:00', '15:02:00', 'UTC +05:30 (India)', NULL, 0, 'completed', 'https://meet.google.com/sor63AbVeZ', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(27, 2, 'Entrepreneurship Journey', 'Join us for an insightful session on Entrepreneurship Journey', 'public', '2025-12-04 13:50:00', '13:50:00', 'UTC +05:30 (India)', NULL, 1, 'cancelled', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(28, 8, 'Work-Life Balance', 'Join us for an insightful session on Work-Life Balance', 'private', '2025-12-30 12:46:00', '12:46:00', 'UTC +00:00 (GMT)', NULL, 1, 'cancelled', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(29, 7, 'Skill Development Roadmap', 'Join us for an insightful session on Skill Development Roadmap', 'unlisted', '2026-01-16 19:01:00', '19:01:00', 'UTC -05:00 (EST)', NULL, 1, 'completed', 'https://meet.google.com/80MXEgVBFN', '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(30, 10, 'Future of Technology', 'Join us for an insightful session on Future of Technology', 'private', '2025-12-24 10:15:00', '10:15:00', 'UTC +00:00 (GMT)', NULL, 0, 'scheduled', 'https://meet.google.com/E4i38qvbLB', '2025-12-18 12:17:42', '2025-12-18 12:17:42');

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
('xkjC15mVhtpShGdeIlYcSW3xM6Lr4RwORSyqENCo', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:146.0) Gecko/20100101 Firefox/146.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNllxQUNBNlZJdDhmOWVJMlkzT0JXUklQV2FnY21qaWtIMkdLNzhGdSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwNC9hZG1pbi9sb2dpbiI7czo1OiJyb3V0ZSI7czoxMToiYWRtaW4ubG9naW4iO319', 1766087896);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `key` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `created_at`, `updated_at`, `key`, `value`) VALUES
(1, NULL, '2025-12-18 14:21:03', 'site_name', 'asdf'),
(2, NULL, '2025-12-18 14:21:03', 'site_email', 'asdf@info.com'),
(3, NULL, '2025-12-18 14:21:03', 'site_phone', 'asdf'),
(4, NULL, '2025-12-18 14:21:03', 'site_address', 'asdfasd'),
(5, NULL, '2025-12-18 14:21:03', 'facebook_url', 'https://getbootstrap.com/'),
(6, NULL, '2025-12-18 14:21:03', 'twitter_url', 'https://getbootstrap.com/'),
(7, NULL, '2025-12-18 14:21:03', 'linkedin_url', 'https://getbootstrap.com/');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','trainer','student') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'student',
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `status`, `phone`, `address`, `email_verified_at`, `password`, `avatar`, `remember_token`, `created_at`, `updated_at`, `last_login_at`) VALUES
(1, 'Admin User', 'admin@lms.com', 'admin', 'active', '+1234567890', '123 Admin Street, City', NULL, '$2y$12$xJGzzvoqXDHI2hn3MSRYjOq3.FKCXdoQvXECoITZUi4AlaaPft1pW', NULL, 'ymjz9DMAYokO0S3BSqkeCGJhMnOgj3vLJetp7ZmXxClTzppVnj3eoy53IX9k', '2025-12-17 23:39:12', '2025-12-18 14:28:16', '2025-12-18 14:28:16'),
(2, 'Trainer test User', 'trainer@lms.com', 'trainer', 'active', '7456745567456746', 'ssss', NULL, '$2y$12$w8an9cUKy5au6Yt1G0Bj.eRglyQ0zSwdUZDRZH0svc1jLnB32WNIS', 'uploads/avatars/1766082647_Screenshot 2025-11-07 at 5.14.24 PM.png', 'UjlsX4gxck49jbxc2jfm6RQbfDSAcYgTn1y3JCBzIQ98Ht5izRvTLVgNRK8d', '2025-12-17 23:39:13', '2025-12-18 13:12:56', '2025-12-18 13:12:56'),
(3, 'Student User', 'student@lms.com', 'student', 'active', NULL, NULL, NULL, '$2y$12$VzJi1vWSZwBXjAWIiKZeiuKbQerxfC4lf9wf1t4r7BVcEuYQWAki6', NULL, 'blR84izeMCGncryzWiEZdAeInx6kgoMqhGFI6sn2ceEFSh6pRr6KJHJCvKAk', '2025-12-17 23:39:13', '2025-12-18 14:20:09', '2025-12-18 14:20:09'),
(5, 'John Trainer', 'trainer1@lms.com', 'trainer', 'active', '+1234567890', '1 Trainer Avenue, City', NULL, '$2y$12$rKIfGbalYz.t/DdL2Sx01OkIY1jIVKbsvw9tZ.aZvfViZ1Ott1.te', NULL, NULL, '2025-12-18 12:17:14', '2025-12-18 12:17:37', NULL),
(6, 'Sarah Instructor', 'trainer2@lms.com', 'trainer', 'active', '+1234567891', '2 Trainer Avenue, City', NULL, '$2y$12$Q2ff2JizWfLR8rufHXEIte9e7Sm5IhPF99MFzyxrhucsTWqD/6hGS', NULL, NULL, '2025-12-18 12:17:14', '2025-12-18 12:17:37', NULL),
(7, 'Mike Coach', 'trainer3@lms.com', 'trainer', 'active', '+1234567892', '3 Trainer Avenue, City', NULL, '$2y$12$nvSYPO3WyEagDedWikQQr.2jCIeJ6yBNW7OYS63eekLzaJiatkvU6', NULL, NULL, '2025-12-18 12:17:14', '2025-12-18 12:17:38', NULL),
(8, 'Emily Teacher', 'trainer4@lms.com', 'trainer', 'active', '+1234567893', '4 Trainer Avenue, City', NULL, '$2y$12$tJlwNucm/0ksR/m7z0E1Eez1oUup6G3Sg5ERPV321uYlxK3CPxUQy', NULL, NULL, '2025-12-18 12:17:15', '2025-12-18 12:17:38', NULL),
(9, 'David Mentor', 'trainer5@lms.com', 'trainer', 'active', '+1234567894', '5 Trainer Avenue, City', NULL, '$2y$12$3m3IcE0ijzf2FuAguhg1Qu4iGihwdlsr5c3MmmGA4arJfWvOM2Q7e', NULL, NULL, '2025-12-18 12:17:15', '2025-12-18 12:17:38', NULL),
(10, 'Lisa Guide', 'trainer6@lms.com', 'trainer', 'active', '+1234567895', '6 Trainer Avenue, City', NULL, '$2y$12$Nc50QVqIf6BnPGMm3Vl.AOmXhxSc4aavM0vsTWSgkhaXsuDTaxZ0K', NULL, NULL, '2025-12-18 12:17:15', '2025-12-18 12:17:38', NULL),
(11, 'Robert Tutor', 'trainer7@lms.com', 'trainer', 'active', '+1234567896', '7 Trainer Avenue, City', NULL, '$2y$12$CvJiHh1QscszYpA3NvwvTuz6QL9/1KihaARNRKGGCnPIv4DWoSU1K', NULL, NULL, '2025-12-18 12:17:15', '2025-12-18 12:17:38', NULL),
(12, 'Jennifer Educator', 'trainer8@lms.com', 'trainer', 'active', '+1234567897', '8 Trainer Avenue, City', NULL, '$2y$12$qREDeDf9oDSSdjvvlxAu1eCmTzDgoIGngJAs6Ets/y2bmPht/I5Ii', NULL, NULL, '2025-12-18 12:17:15', '2025-12-18 12:17:39', NULL),
(13, 'Michael Facilitator', 'trainer9@lms.com', 'trainer', 'inactive', '+1234567898', '9 Trainer Avenue, City', NULL, '$2y$12$qAWqc7MHWPXuof4kecrj0u/OprZBg.hyO9ZgyY.7rJGyDboBNTcIe', NULL, NULL, '2025-12-18 12:17:16', '2025-12-18 12:17:39', NULL),
(14, 'Amanda Trainer', 'trainer10@lms.com', 'trainer', 'inactive', '+1234567899', '10 Trainer Avenue, City', NULL, '$2y$12$oyppzL27ubeauE7QMxhiz.AFZXh1/dIJN9KIleCtFMpiyNeUXnzqy', NULL, NULL, '2025-12-18 12:17:16', '2025-12-18 12:17:39', NULL),
(15, 'Alice Student', 'student1@lms.com', 'student', 'active', '+1987654320', '1 Student Road, City', NULL, '$2y$12$x42cNIO0gk8WqEUSxSoIdeenwK6EinljhBvcfzGvXGESQa0N59M8i', NULL, NULL, '2025-12-18 12:17:16', '2025-12-18 12:17:39', NULL),
(16, 'Bob Learner', 'student2@lms.com', 'student', 'active', '+1987654321', '2 Student Road, City', NULL, '$2y$12$CKLrDwmIg06U28zxUN7TseqCrSgNOSDnK4rm7z32kPUz1.0PkjQwu', NULL, NULL, '2025-12-18 12:17:16', '2025-12-18 12:17:39', NULL),
(17, 'Charlie Scholar', 'student3@lms.com', 'student', 'active', '+1987654322', '3 Student Road, City', NULL, '$2y$12$aET2308ooQL52joCg4GGse64jMUU.1jcAsntIjMjtBbd0dLd5cJUa', NULL, NULL, '2025-12-18 12:17:16', '2025-12-18 12:17:39', NULL),
(18, 'Diana Pupil', 'student4@lms.com', 'student', 'active', '+1987654323', '4 Student Road, City', NULL, '$2y$12$1yV4whfgwcaAw/S8Xl1jgORwmIfBUX8Qs8u600TnL/PzfDnP/Oc8.', NULL, NULL, '2025-12-18 12:17:16', '2025-12-18 12:17:40', NULL),
(19, 'Eve Apprentice', 'student5@lms.com', 'student', 'active', '+1987654324', '5 Student Road, City', NULL, '$2y$12$X0o92EtQv.XpgVVP.sRnTukXAH5Ia.s7YgVWc0ynSmk4suct.g7eS', NULL, NULL, '2025-12-18 12:17:17', '2025-12-18 12:17:40', NULL),
(20, 'Frank Novice', 'student6@lms.com', 'student', 'active', '+1987654325', '6 Student Road, City', NULL, '$2y$12$bfXej4JqSlKnuXyjB7TlBO/16It6upGPy7OrBfojwECB32QGxsdKm', NULL, NULL, '2025-12-18 12:17:17', '2025-12-18 12:17:40', NULL),
(21, 'Grace Beginner', 'student7@lms.com', 'student', 'active', '+1987654326', '7 Student Road, City', NULL, '$2y$12$e3HgZ2CPpE3ldHhEKe46IOJyVBFb11Y2GzWN1XeX7F9BTOy90sPRy', NULL, NULL, '2025-12-18 12:17:17', '2025-12-18 12:17:40', NULL),
(22, 'Henry Trainee', 'student8@lms.com', 'student', 'active', '+1987654327', '8 Student Road, City', NULL, '$2y$12$Y8ZcBgeKDA0iSoYmaOWdGesXfk96fjTXpApDxniuCB/94M2riVyX.', NULL, NULL, '2025-12-18 12:17:17', '2025-12-18 12:17:40', NULL),
(23, 'Ivy Cadet', 'student9@lms.com', 'student', 'active', '+1987654328', '9 Student Road, City', NULL, '$2y$12$zwo17TQ/rLLgBK4CqucC1OzeV1WFOogv2rPJeYA.23xKTCRBTD6ii', NULL, NULL, '2025-12-18 12:17:17', '2025-12-18 12:17:40', NULL),
(24, 'Jack Freshman', 'student10@lms.com', 'student', 'active', '+1987654329', '10 Student Road, City', NULL, '$2y$12$fHqouJTu7mqwE8q0M7Z7f.lNEzR1yeUD18c6VvB4lSysNS0i7xVXe', NULL, NULL, '2025-12-18 12:17:17', '2025-12-18 12:17:41', NULL),
(25, 'Kate Sophomore', 'student11@lms.com', 'student', 'active', '+19876543210', '11 Student Road, City', NULL, '$2y$12$ase0c.zt92st.OZJypuScOc5GvP6LRC/Wyo543ZTzuUaLDxbCt59a', NULL, NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:41', NULL),
(26, 'Liam Junior', 'student12@lms.com', 'student', 'active', '+19876543211', '12 Student Road, City', NULL, '$2y$12$lfIjqF/bIv5EUy6L/fB2WO9hixrYhMSe7V0AHH/IpNltYCfHXvBMi', NULL, NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:41', NULL),
(27, 'Mia Senior', 'student13@lms.com', 'student', 'inactive', '+19876543212', '13 Student Road, City', NULL, '$2y$12$UP1ndJ1qe4Lvk.RYdLmu1.sVWPYK7CSjPXNd79K5YUtOOPjEpVBie', NULL, NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:41', NULL),
(28, 'Noah Graduate', 'student14@lms.com', 'student', 'inactive', '+19876543213', '14 Student Road, City', NULL, '$2y$12$XEGolEvDBp4sf1zB8j95dOsqbe47p0kDRqSVxZMq.xRGY3mai0y2i', NULL, NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:41', NULL),
(29, 'Olivia Postgrad', 'student15@lms.com', 'student', 'inactive', '+19876543214', '15 Student Road, City', NULL, '$2y$12$Mg1A15lrSLQz64hkMqVoUORhVDNpPkJU6QF2LDs4q1LNdxIdvmghe', NULL, NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED DEFAULT NULL,
  `batch_id` bigint UNSIGNED DEFAULT NULL,
  `trainer_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `video_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration_minutes` int DEFAULT NULL,
  `views` int NOT NULL DEFAULT '0',
  `order` int NOT NULL DEFAULT '0',
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `scheduled_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`id`, `course_id`, `batch_id`, `trainer_id`, `title`, `description`, `video_url`, `thumbnail`, `duration_minutes`, `views`, `order`, `status`, `scheduled_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 7, 'HTML Basics and Structure - App Devlopermnt', 'Learn HTML Basics and Structure in this comprehensive video tutorial.', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 112, 4876, 0, 'inactive', NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(2, 2, 3, 7, 'CSS Styling Fundamentals - Web Development Fundamentals', 'Learn CSS Styling Fundamentals in this comprehensive video tutorial.', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 48, 4513, 0, 'active', NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(3, 3, 4, 10, 'JavaScript Variables and Functions - Advanced JavaScript', 'Learn JavaScript Variables and Functions in this comprehensive video tutorial.', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 67, 4572, 0, 'inactive', NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(4, 4, 5, 10, 'React Components and Props - React.js Complete Guide', 'Learn React Components and Props in this comprehensive video tutorial.', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 67, 1205, 0, 'inactive', NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(5, 5, 6, 9, 'State Management in React - Node.js Backend Development', 'Learn State Management in React in this comprehensive video tutorial.', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 72, 1671, 0, 'active', NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(6, 6, 7, 8, 'Node.js Server Setup - Full Stack Development', 'Learn Node.js Server Setup in this comprehensive video tutorial.', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 103, 2496, 0, 'inactive', NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(7, 7, 8, 14, 'Database Design and SQL - Python Programming', 'Learn Database Design and SQL in this comprehensive video tutorial.', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 97, 4778, 0, 'inactive', NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(8, 8, 9, 11, 'API Development with Express - Data Science with Python', 'Learn API Development with Express in this comprehensive video tutorial.', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 66, 938, 0, 'active', NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(9, 9, 10, 9, 'Authentication and Security - Mobile App Development', 'Learn Authentication and Security in this comprehensive video tutorial.', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 53, 4943, 0, 'inactive', NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(10, 10, 11, 9, 'Deployment Strategies - UI/UX Design', 'Learn Deployment Strategies in this comprehensive video tutorial.', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 48, 4884, 0, 'active', NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(11, 11, 12, 12, 'Testing and Debugging - Digital Marketing', 'Learn Testing and Debugging in this comprehensive video tutorial.', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 54, 4649, 0, 'active', NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(12, 12, 13, 12, 'Performance Optimization - Graphic Design', 'Learn Performance Optimization in this comprehensive video tutorial.', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 80, 993, 0, 'inactive', NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(13, 6, 7, 7, 'Advanced Topic 1 - Full Stack Development', 'Advanced concepts and techniques for Full Stack Development', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 88, 803, 10, 'active', NULL, '2025-12-18 12:17:18', '2025-12-18 14:19:59'),
(14, 10, 11, 7, 'Advanced Topic 2 - UI/UX Design', 'Advanced concepts and techniques for UI/UX Design', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 88, 1162, 11, 'active', NULL, '2025-12-18 12:17:18', '2025-12-18 12:17:18'),
(15, 6, 7, 7, 'Advanced Topic 3 - Full Stack Development', 'Advanced concepts and techniques for Full Stack Development', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 63, 1262, 12, 'active', NULL, '2025-12-18 12:17:18', '2025-12-18 13:35:50'),
(16, 30, NULL, 7, 'Introduction to Web Development - Animation Course', 'Learn Introduction to Web Development in this comprehensive video tutorial.', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 60, 2887, 0, 'active', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(17, 17, NULL, 8, 'HTML Basics and Structure - Web Development Fundamentals', 'Learn HTML Basics and Structure in this comprehensive video tutorial.', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 85, 3288, 1, 'inactive', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(18, 21, NULL, 6, 'CSS Styling Fundamentals - Full Stack Development', 'Learn CSS Styling Fundamentals in this comprehensive video tutorial.', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 118, 1881, 2, 'active', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(19, 23, NULL, 10, 'JavaScript Variables and Functions - Data Science with Python', 'Learn JavaScript Variables and Functions in this comprehensive video tutorial.', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 81, 1669, 3, 'active', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(20, 5, 6, 5, 'React Components and Props - Node.js Backend Development', 'Learn React Components and Props in this comprehensive video tutorial.', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 67, 3405, 4, 'active', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(21, 1, 1, 13, 'State Management in React - App Devlopermnt', 'Learn State Management in React in this comprehensive video tutorial.', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 47, 4277, 5, 'inactive', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(22, 2, 3, 11, 'Node.js Server Setup - Web Development Fundamentals', 'Learn Node.js Server Setup in this comprehensive video tutorial.', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 38, 2807, 6, 'active', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(23, 1, 1, 6, 'Database Design and SQL - App Devlopermnt', 'Learn Database Design and SQL in this comprehensive video tutorial.', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 98, 2992, 7, 'active', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(24, 19, NULL, 11, 'API Development with Express - React.js Complete Guide', 'Learn API Development with Express in this comprehensive video tutorial.', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 108, 2379, 8, 'active', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(25, 17, NULL, 9, 'Authentication and Security - Web Development Fundamentals', 'Learn Authentication and Security in this comprehensive video tutorial.', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 50, 3488, 9, 'active', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(26, 19, NULL, 6, 'Deployment Strategies - React.js Complete Guide', 'Learn Deployment Strategies in this comprehensive video tutorial.', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 75, 2821, 10, 'active', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(27, 23, NULL, 10, 'Testing and Debugging - Data Science with Python', 'Learn Testing and Debugging in this comprehensive video tutorial.', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 107, 3060, 11, 'active', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(28, 5, 6, 6, 'Performance Optimization - Node.js Backend Development', 'Learn Performance Optimization in this comprehensive video tutorial.', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 104, 4401, 12, 'inactive', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(29, 12, 13, 6, 'Best Practices and Patterns - Graphic Design', 'Learn Best Practices and Patterns in this comprehensive video tutorial.', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 116, 2389, 13, 'active', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(30, 10, 11, 11, 'Project Walkthrough - UI/UX Design', 'Learn Project Walkthrough in this comprehensive video tutorial.', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 83, 3525, 14, 'inactive', NULL, '2025-12-18 12:17:42', '2025-12-18 12:17:42'),
(31, NULL, NULL, 2, 'werqwer', 'qwerqwe', 'https://www.skillwaala.com/', 'uploads/videos/thumbnails/1766080537_Screenshot 2025-11-07 at 5.10.22 PM.png', 8, 1, 0, 'inactive', '2025-12-31 07:07:00', '2025-12-18 12:25:37', '2025-12-18 13:11:40');

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
-- Indexes for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendances_student_id_foreign` (`student_id`),
  ADD KEY `attendances_live_class_id_foreign` (`live_class_id`);

--
-- Indexes for table `batches`
--
ALTER TABLE `batches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `batches_course_id_foreign` (`course_id`);

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
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `certificates_certificate_number_unique` (`certificate_number`),
  ADD KEY `certificates_student_id_foreign` (`student_id`),
  ADD KEY `certificates_course_id_foreign` (`course_id`);

--
-- Indexes for table `community_queries`
--
ALTER TABLE `community_queries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `community_queries_student_id_foreign` (`student_id`),
  ADD KEY `community_queries_course_id_foreign` (`course_id`),
  ADD KEY `community_queries_assigned_trainer_id_foreign` (`assigned_trainer_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_trainer`
--
ALTER TABLE `course_trainer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_trainer_course_id_foreign` (`course_id`),
  ADD KEY `course_trainer_trainer_id_foreign` (`trainer_id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `enrollments_student_id_foreign` (`student_id`),
  ADD KEY `enrollments_course_id_foreign` (`course_id`),
  ADD KEY `enrollments_batch_id_foreign` (`batch_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `hiring_applications`
--
ALTER TABLE `hiring_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hiring_applications_trainer_id_foreign` (`trainer_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs_old`
--
ALTER TABLE `jobs_old`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `live_classes`
--
ALTER TABLE `live_classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `live_classes_course_id_foreign` (`course_id`),
  ADD KEY `live_classes_batch_id_foreign` (`batch_id`),
  ADD KEY `live_classes_trainer_id_foreign` (`trainer_id`);

--
-- Indexes for table `login_history`
--
ALTER TABLE `login_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `login_history_user_id_foreign` (`user_id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_permissions`
--
ALTER TABLE `menu_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menu_permissions_menu_id_permission_id_unique` (`menu_id`,`permission_id`);

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
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `playlists`
--
ALTER TABLE `playlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `playlists_trainer_id_foreign` (`trainer_id`);

--
-- Indexes for table `playlist_video`
--
ALTER TABLE `playlist_video`
  ADD PRIMARY KEY (`id`),
  ADD KEY `playlist_video_playlist_id_foreign` (`playlist_id`),
  ADD KEY `playlist_video_video_id_foreign` (`video_id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quizzes_trainer_id_foreign` (`trainer_id`),
  ADD KEY `quizzes_course_id_foreign` (`course_id`);

--
-- Indexes for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_attempts_quiz_id_foreign` (`quiz_id`),
  ADD KEY `quiz_attempts_student_id_foreign` (`student_id`);

--
-- Indexes for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_questions_quiz_id_foreign` (`quiz_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `satsangs`
--
ALTER TABLE `satsangs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `satsangs_trainer_id_foreign` (`trainer_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `videos_course_id_foreign` (`course_id`),
  ADD KEY `videos_trainer_id_foreign` (`trainer_id`),
  ADD KEY `videos_batch_id_foreign` (`batch_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `batches`
--
ALTER TABLE `batches`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `community_queries`
--
ALTER TABLE `community_queries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `course_trainer`
--
ALTER TABLE `course_trainer`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hiring_applications`
--
ALTER TABLE `hiring_applications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs_old`
--
ALTER TABLE `jobs_old`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `live_classes`
--
ALTER TABLE `live_classes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `login_history`
--
ALTER TABLE `login_history`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu_permissions`
--
ALTER TABLE `menu_permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `playlists`
--
ALTER TABLE `playlists`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `playlist_video`
--
ALTER TABLE `playlist_video`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `satsangs`
--
ALTER TABLE `satsangs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD CONSTRAINT `admin_notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_live_class_id_foreign` FOREIGN KEY (`live_class_id`) REFERENCES `live_classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendances_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `batches`
--
ALTER TABLE `batches`
  ADD CONSTRAINT `batches_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `certificates`
--
ALTER TABLE `certificates`
  ADD CONSTRAINT `certificates_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `certificates_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `community_queries`
--
ALTER TABLE `community_queries`
  ADD CONSTRAINT `community_queries_assigned_trainer_id_foreign` FOREIGN KEY (`assigned_trainer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `community_queries_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `community_queries_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `course_trainer`
--
ALTER TABLE `course_trainer`
  ADD CONSTRAINT `course_trainer_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_trainer_trainer_id_foreign` FOREIGN KEY (`trainer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_batch_id_foreign` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `enrollments_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollments_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hiring_applications`
--
ALTER TABLE `hiring_applications`
  ADD CONSTRAINT `hiring_applications_trainer_id_foreign` FOREIGN KEY (`trainer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `live_classes`
--
ALTER TABLE `live_classes`
  ADD CONSTRAINT `live_classes_batch_id_foreign` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `live_classes_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `live_classes_trainer_id_foreign` FOREIGN KEY (`trainer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `login_history`
--
ALTER TABLE `login_history`
  ADD CONSTRAINT `login_history_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `playlists`
--
ALTER TABLE `playlists`
  ADD CONSTRAINT `playlists_trainer_id_foreign` FOREIGN KEY (`trainer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `playlist_video`
--
ALTER TABLE `playlist_video`
  ADD CONSTRAINT `playlist_video_playlist_id_foreign` FOREIGN KEY (`playlist_id`) REFERENCES `playlists` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `playlist_video_video_id_foreign` FOREIGN KEY (`video_id`) REFERENCES `videos` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `quizzes_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `quizzes_trainer_id_foreign` FOREIGN KEY (`trainer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  ADD CONSTRAINT `quiz_attempts_quiz_id_foreign` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quiz_attempts_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD CONSTRAINT `quiz_questions_quiz_id_foreign` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `satsangs`
--
ALTER TABLE `satsangs`
  ADD CONSTRAINT `satsangs_trainer_id_foreign` FOREIGN KEY (`trainer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `videos_batch_id_foreign` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `videos_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `videos_trainer_id_foreign` FOREIGN KEY (`trainer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
