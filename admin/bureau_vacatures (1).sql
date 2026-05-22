-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 22 mei 2026 om 12:56
-- Serverversie: 10.4.32-MariaDB
-- PHP-versie: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bureau_vacatures`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bureau_activity_log`
--

CREATE TABLE `bureau_activity_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `action` varchar(50) NOT NULL,
  `entity_type` varchar(50) NOT NULL,
  `entity_id` int(11) DEFAULT NULL,
  `entity_name` varchar(255) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `bureau_activity_log`
--

INSERT INTO `bureau_activity_log` (`id`, `user_id`, `username`, `action`, `entity_type`, `entity_id`, `entity_name`, `details`, `ip_address`, `created_at`) VALUES
(1, 2, 'test123', 'update', 'vacature', 14, 'Taliban', NULL, '10.52.21.28', '2025-12-11 12:21:20'),
(2, 2, 'test123', 'create', 'vacature', 15, '1', NULL, '10.52.21.28', '2025-12-11 12:21:51'),
(3, 1, 'admin', 'delete', 'vacature', 15, '1', NULL, '10.52.21.28', '2025-12-11 12:22:14'),
(4, 2, 'test123', 'update', 'vacature', 14, 'Taliban', NULL, '10.52.21.28', '2025-12-11 12:23:44'),
(5, 2, 'test123', 'logout', 'system', 2, 'test123', NULL, '10.52.21.28', '2025-12-11 12:31:56'),
(6, 1, 'admin', 'delete', 'vacature', 14, 'Taliban', NULL, '10.52.21.28', '2025-12-11 12:58:48'),
(7, 1, 'admin', 'delete', 'vacature', 13, 'The hub', NULL, '10.52.21.28', '2025-12-11 12:58:52'),
(8, 1, 'admin', 'delete', 'sollicitatie', 2, '123 - Social media guru', NULL, '10.52.21.28', '2025-12-11 12:59:00'),
(9, 1, 'admin', 'update', 'user', 3, 'marijntje', NULL, '10.52.21.28', '2025-12-11 12:59:05'),
(10, 1, 'admin', 'update', 'user', 3, 'marijntje', NULL, '10.52.21.28', '2025-12-11 12:59:14'),
(11, 1, 'admin', 'delete', 'user', 3, 'marijntje', NULL, '10.52.21.28', '2025-12-11 12:59:23'),
(12, 1, 'admin', 'delete', 'user', 2, 'test123', NULL, '10.52.21.28', '2025-12-11 12:59:25'),
(13, 1, 'admin', 'view', 'sollicitatie', 3, 'jan - Social media guru', NULL, '10.52.21.28', '2025-12-11 13:03:38'),
(14, 1, 'admin', 'delete', 'sollicitatie', 4, 'jan - Front-end Developer', NULL, '10.52.21.28', '2025-12-11 13:04:04'),
(15, 1, 'admin', 'delete', 'sollicitatie', 3, 'jan - Social media guru', NULL, '10.52.21.28', '2025-12-11 13:04:05'),
(16, 1, 'admin', 'update', 'sollicitatie', 5, 'test - Geaccepteerd', NULL, '10.52.21.28', '2025-12-11 13:09:04'),
(17, 1, 'admin', 'update', 'sollicitatie', 5, 'test - Afgewezen', NULL, '10.52.21.28', '2025-12-11 13:10:15'),
(18, 1, 'admin', 'update', 'sollicitatie', 6, 'qwe - Afgewezen', NULL, '10.52.21.28', '2025-12-11 13:11:03'),
(19, 1, 'admin', 'update', 'sollicitatie', 6, 'qwe - Geaccepteerd', NULL, '10.52.21.28', '2025-12-11 13:11:08'),
(20, 1, 'admin', 'update', 'sollicitatie', 5, 'test - Terug naar In Behandeling', NULL, '10.52.21.28', '2025-12-11 13:11:15'),
(21, 1, 'admin', 'view', 'sollicitatie', 5, 'test - Hoofdredacteur', NULL, '10.52.21.28', '2025-12-11 13:11:37'),
(22, 1, 'admin', 'update', 'sollicitatie', 7, 'gsdg - Geaccepteerd', NULL, '10.52.21.28', '2025-12-11 13:13:31'),
(23, 1, 'admin', 'update', 'sollicitatie', 6, 'qwe - Afgewezen', NULL, '10.52.21.28', '2025-12-11 13:13:37'),
(24, 1, 'admin', 'update', 'sollicitatie', 6, 'qwe - Geaccepteerd', NULL, '10.52.21.28', '2025-12-11 13:14:08'),
(25, 1, 'admin', 'view', 'sollicitatie', 7, 'gsdg - Projectmanager', NULL, '10.52.21.28', '2025-12-11 13:14:09'),
(26, 1, 'admin', 'update', 'sollicitatie', 7, 'gsdg - Terug naar In Behandeling', NULL, '10.52.21.28', '2025-12-11 13:14:30'),
(27, 1, 'admin', 'update', 'sollicitatie', 7, 'gsdg - Geaccepteerd', NULL, '10.52.21.28', '2025-12-11 13:14:45'),
(28, 1, 'admin', 'update', 'sollicitatie', 5, 'test - Geaccepteerd', NULL, '10.52.21.28', '2025-12-11 13:14:48'),
(29, 1, 'admin', 'update', 'sollicitatie', 7, 'gsdg - Afgewezen', NULL, '10.52.21.28', '2025-12-11 13:21:44'),
(30, 1, 'admin', 'update', 'sollicitatie', 6, 'qwe - Terug naar In Behandeling', NULL, '10.52.21.28', '2025-12-11 13:21:48'),
(31, 1, 'admin', 'view', 'sollicitatie', 8, '1231231231312312312312312313 - Hoofdredacteur', NULL, '10.52.21.28', '2025-12-11 13:34:08'),
(32, 1, 'admin', 'view', 'sollicitatie', 8, '1231231231312312312312312313 - Hoofdredacteur', NULL, '10.52.21.28', '2025-12-11 13:36:33'),
(33, 1, 'admin', 'delete', 'sollicitatie', 8, '1231231231312312312312312313 - Hoofdredacteur', NULL, '10.52.21.28', '2025-12-11 13:36:41'),
(34, 1, 'admin', 'update', 'sollicitatie', 7, 'gsdg - Geaccepteerd', NULL, '10.52.21.28', '2025-12-11 13:36:55'),
(35, 1, 'admin', 'update', 'sollicitatie', 6, 'qwe - Geaccepteerd', NULL, '10.52.21.28', '2025-12-11 13:36:59'),
(36, 1, 'admin', 'update', 'sollicitatie', 7, 'gsdg - Terug naar In Behandeling', NULL, '10.52.21.28', '2025-12-11 13:37:01'),
(37, 1, 'admin', 'update', 'sollicitatie', 6, 'qwe - Terug naar In Behandeling', NULL, '10.52.21.28', '2025-12-11 13:37:04'),
(38, 1, 'admin', 'update', 'sollicitatie', 5, 'test - Terug naar In Behandeling', NULL, '10.52.21.28', '2025-12-11 13:37:05'),
(39, 1, 'admin', 'logout', 'system', 1, 'admin', NULL, '10.52.21.28', '2025-12-11 13:37:19'),
(40, 1, 'admin', 'login', 'system', 1, 'admin', NULL, '10.52.21.28', '2025-12-11 13:53:01'),
(41, 1, 'admin', 'login', 'system', 1, 'admin', NULL, '77.63.8.98', '2025-12-11 15:29:44'),
(42, 1, 'admin', 'create', 'user', 4, 'test-leraar', NULL, '77.63.8.98', '2025-12-11 15:31:34'),
(43, 1, 'admin', 'logout', 'system', 1, 'admin', NULL, '77.63.8.98', '2025-12-11 15:31:43'),
(44, 4, 'test-leraar', 'login', 'system', 4, 'test-leraar', NULL, '77.63.8.98', '2025-12-11 15:32:04'),
(45, 4, 'test-leraar', 'view', 'sollicitatie', 7, 'gsdg - Projectmanager', NULL, '77.63.8.98', '2025-12-11 15:32:11'),
(46, 4, 'test-leraar', 'update', 'sollicitatie', 7, 'gsdg - Geaccepteerd', NULL, '77.63.8.98', '2025-12-11 15:33:29'),
(47, 4, 'test-leraar', 'update', 'sollicitatie', 6, 'qwe - Afgewezen', NULL, '77.63.8.98', '2025-12-11 15:33:34'),
(48, 4, 'test-leraar', 'logout', 'system', 4, 'test-leraar', NULL, '77.63.8.98', '2025-12-11 15:33:40'),
(49, 1, 'admin', 'login', 'system', 1, 'admin', NULL, '77.63.8.98', '2025-12-11 15:33:48'),
(50, 1, 'admin', 'delete', 'user', 4, 'test-leraar', NULL, '77.63.8.98', '2025-12-11 15:34:56'),
(51, 1, 'admin', 'logout', 'system', 1, 'admin', NULL, '77.63.8.98', '2025-12-11 15:35:08'),
(52, 1, 'admin', 'login', 'system', 1, 'admin', NULL, '77.169.202.206', '2025-12-13 21:23:50'),
(53, 1, 'admin', 'logout', 'system', 1, 'admin', NULL, '77.169.202.206', '2025-12-13 21:24:33'),
(54, 1, 'admin', 'login', 'system', 1, 'admin', NULL, '10.55.30.5', '2026-01-05 08:27:44'),
(55, 1, 'admin', 'update', 'vacature', 2, 'Back-end Developer', NULL, '10.55.30.5', '2026-01-05 08:43:55'),
(56, 1, 'admin', 'update', 'vacature', 2, 'Back-end Developer', NULL, '10.55.30.5', '2026-01-05 08:46:02'),
(57, 1, 'admin', 'update', 'vacature', 1, 'Front-end Developer', NULL, '10.55.30.5', '2026-01-05 08:46:22'),
(58, 1, 'admin', 'login', 'system', 1, 'admin', NULL, '10.55.30.5', '2026-01-05 09:27:18'),
(59, 1, 'admin', 'login', 'system', 1, 'admin', NULL, '81.206.54.214', '2026-01-05 16:00:32'),
(60, 1, 'admin', 'login', 'system', 1, 'admin', NULL, '10.55.30.5', '2026-01-12 10:25:48'),
(61, 1, 'admin', 'login', 'system', 1, 'admin', NULL, '10.55.30.5', '2026-01-12 13:27:40'),
(62, 1, 'admin', 'login', 'system', 1, 'admin', NULL, '104.28.217.140', '2026-01-15 10:07:56'),
(63, 1, 'admin', 'delete', 'sollicitatie', 7, 'gsdg - Projectmanager', NULL, '104.28.217.140', '2026-01-15 10:08:10'),
(64, 1, 'admin', 'delete', 'sollicitatie', 6, 'qwe - Hoofdredacteur', NULL, '104.28.217.140', '2026-01-15 10:08:14'),
(65, 1, 'admin', 'delete', 'sollicitatie', 5, 'test - Hoofdredacteur', NULL, '104.28.217.140', '2026-01-15 10:08:16'),
(66, 1, 'admin', 'login', 'system', 1, 'admin', NULL, '10.52.6.112', '2026-01-15 10:08:39'),
(67, 1, 'admin', 'view', 'sollicitatie', 11, 'duzyano - Front-end Developer', NULL, '10.52.6.112', '2026-01-15 10:09:10'),
(68, 1, 'admin', 'view', 'sollicitatie', 11, 'duzyano - Front-end Developer', NULL, '10.52.6.112', '2026-01-15 10:10:22'),
(69, 1, 'admin', 'login', 'system', 1, 'admin', NULL, '10.52.8.110', '2026-01-15 10:20:01'),
(70, 1, 'admin', 'view', 'sollicitatie', 11, 'duzyano - Front-end Developer', NULL, '10.52.8.110', '2026-01-15 10:21:34'),
(71, 1, 'admin', 'view', 'sollicitatie', 10, 'Sam Berghoef - Back-end Developer', NULL, '10.52.8.110', '2026-01-15 10:21:47'),
(72, 1, 'admin', 'view', 'sollicitatie', 9, 'MylÃ¨ne Zijlstra - Back-end Developer', NULL, '10.52.8.110', '2026-01-15 10:21:58'),
(73, 1, 'admin', 'view', 'sollicitatie', 10, 'Sam Berghoef - Back-end Developer', NULL, '10.52.8.110', '2026-01-15 10:22:08'),
(74, 1, 'admin', 'view', 'sollicitatie', 11, 'duzyano - Front-end Developer', NULL, '10.52.8.110', '2026-01-15 10:22:11'),
(75, 1, 'admin', 'view', 'sollicitatie', 9, 'MylÃ¨ne Zijlstra - Back-end Developer', NULL, '10.52.8.110', '2026-01-15 10:22:15'),
(76, 1, 'admin', 'view', 'sollicitatie', 11, 'duzyano - Front-end Developer', NULL, '10.52.8.110', '2026-01-15 10:23:29'),
(77, 1, 'admin', 'view', 'sollicitatie', 10, 'Sam Berghoef - Back-end Developer', NULL, '10.52.8.110', '2026-01-15 10:24:13'),
(78, 1, 'admin', 'logout', 'system', 1, 'admin', NULL, '10.52.8.110', '2026-01-15 10:33:42'),
(79, 1, 'admin', 'login', 'system', 1, 'admin', NULL, '104.28.217.138', '2026-01-15 12:13:44'),
(80, 1, 'admin', 'login', 'system', 1, 'admin', NULL, '104.28.217.140', '2026-01-15 13:30:45'),
(81, 1, 'admin', 'view', 'sollicitatie', 14, 'Jelle Romijn - Back-end Developer', NULL, '104.28.217.140', '2026-01-15 13:35:26'),
(82, 1, 'admin', 'view', 'sollicitatie', 12, 'Sebastiaan Kuper - Front-end Developer', NULL, '104.28.217.140', '2026-01-15 13:38:46'),
(83, 1, 'admin', 'view', 'sollicitatie', 9, 'MylÃ¨ne Zijlstra - Back-end Developer', NULL, '104.28.217.140', '2026-01-15 13:40:02'),
(84, 1, 'admin', 'login', 'system', 1, 'admin', NULL, '104.28.249.137', '2026-01-16 11:46:43'),
(85, 1, 'admin', 'view', 'sollicitatie', 27, 'bas spies - Front-end Developer', NULL, '104.28.249.137', '2026-01-16 11:47:15'),
(86, 1, 'admin', 'view', 'sollicitatie', 23, 'Lianne Meiresonne - Front-end Developer', NULL, '104.28.249.137', '2026-01-16 11:47:55'),
(87, 1, 'admin', 'login', 'system', 1, 'admin', NULL, '10.52.6.112', '2026-01-16 11:50:19'),
(88, 1, 'admin', 'view', 'sollicitatie', 27, 'bas spies - Front-end Developer', NULL, '10.52.6.112', '2026-01-16 11:50:40'),
(89, 1, 'admin', 'view', 'sollicitatie', 26, 'David Mateman - Front-end Developer', NULL, '10.52.6.112', '2026-01-16 11:51:46'),
(90, 1, 'admin', 'update', 'sollicitatie', 27, 'bas spies - Afgewezen', NULL, '10.52.6.112', '2026-01-16 11:53:00'),
(91, 1, 'admin', 'view', 'sollicitatie', 26, 'David Mateman - Front-end Developer', NULL, '10.52.6.112', '2026-01-16 11:53:15'),
(92, 1, 'admin', 'update', 'sollicitatie', 26, 'David Mateman - Geaccepteerd', NULL, '10.52.6.112', '2026-01-16 11:53:22'),
(93, 1, 'admin', 'view', 'sollicitatie', 25, 'Mitchell Lijffijt - Front-end Developer', NULL, '10.52.6.112', '2026-01-16 11:53:28'),
(94, 1, 'admin', 'update', 'sollicitatie', 25, 'Mitchell Lijffijt - Afgewezen', NULL, '10.52.6.112', '2026-01-16 11:54:01'),
(95, 1, 'admin', 'view', 'sollicitatie', 24, 'Nielan den Haan - Front-end Developer', NULL, '10.52.6.112', '2026-01-16 11:54:07'),
(96, 1, 'admin', 'update', 'sollicitatie', 24, 'Nielan den Haan - Geaccepteerd', NULL, '10.52.6.112', '2026-01-16 11:54:45'),
(97, 1, 'admin', 'view', 'sollicitatie', 23, 'Lianne Meiresonne - Front-end Developer', NULL, '10.52.6.112', '2026-01-16 11:54:53'),
(98, 1, 'admin', 'update', 'sollicitatie', 23, 'Lianne Meiresonne - Geaccepteerd', NULL, '10.52.6.112', '2026-01-16 11:55:17'),
(99, 1, 'admin', 'view', 'sollicitatie', 22, 'Noa van Mil - Front-end Developer', NULL, '10.52.6.112', '2026-01-16 11:55:21'),
(100, 1, 'admin', 'view', 'sollicitatie', 22, 'Noa van Mil - Front-end Developer', NULL, '10.52.6.112', '2026-01-16 11:56:02'),
(101, 1, 'admin', 'update', 'sollicitatie', 22, 'Noa van Mil - Afgewezen', NULL, '10.52.6.112', '2026-01-16 11:56:12'),
(102, 1, 'admin', 'view', 'sollicitatie', 21, 'Ridouan Rashid - Back-end Developer', NULL, '10.52.6.112', '2026-01-16 11:56:15'),
(103, 1, 'admin', 'update', 'sollicitatie', 21, 'Ridouan Rashid - Geaccepteerd', NULL, '10.52.6.112', '2026-01-16 11:56:42'),
(104, 1, 'admin', 'view', 'sollicitatie', 20, 'Tom Tiedemann - Back-end Developer', NULL, '10.52.6.112', '2026-01-16 11:56:46'),
(105, 1, 'admin', 'update', 'sollicitatie', 20, 'Tom Tiedemann - Geaccepteerd', NULL, '10.52.6.112', '2026-01-16 11:57:10'),
(106, 1, 'admin', 'view', 'sollicitatie', 19, 'Levi Sastro - Front-end designer', NULL, '10.52.6.112', '2026-01-16 11:57:15'),
(107, 1, 'admin', 'update', 'sollicitatie', 19, 'Levi Sastro - Geaccepteerd', NULL, '10.52.6.112', '2026-01-16 11:58:01'),
(108, 1, 'admin', 'view', 'sollicitatie', 18, 'Nielan den Haan - Front-end Developer', NULL, '10.52.6.112', '2026-01-16 11:58:05'),
(109, 1, 'admin', 'update', 'sollicitatie', 18, 'Nielan den Haan - Geaccepteerd', NULL, '10.52.6.112', '2026-01-16 11:58:34'),
(110, 1, 'admin', 'view', 'sollicitatie', 17, 'Malek Alrajawy - Back-end Developer', NULL, '10.52.6.112', '2026-01-16 11:58:41'),
(111, 1, 'admin', 'update', 'sollicitatie', 17, 'Malek Alrajawy - Geaccepteerd', NULL, '10.52.6.112', '2026-01-16 11:59:09'),
(112, 1, 'admin', 'view', 'sollicitatie', 16, 'ShenÃ© Banga - Front-end Developer', NULL, '10.52.6.112', '2026-01-16 11:59:18'),
(113, 1, 'admin', 'view', 'sollicitatie', 16, 'ShenÃ© Banga - Front-end Developer', NULL, '10.52.6.112', '2026-01-16 12:00:02'),
(114, 1, 'admin', 'update', 'sollicitatie', 16, 'ShenÃ© Banga - Geaccepteerd', NULL, '10.52.6.112', '2026-01-16 12:00:11'),
(115, 1, 'admin', 'view', 'sollicitatie', 15, 'Mahmoud - Front-end Developer', NULL, '10.52.6.112', '2026-01-16 12:00:16'),
(116, 1, 'admin', 'update', 'sollicitatie', 15, 'Mahmoud - Geaccepteerd', NULL, '10.52.6.112', '2026-01-16 12:00:53'),
(117, 1, 'admin', 'view', 'sollicitatie', 14, 'Jelle Romijn - Back-end Developer', NULL, '10.52.6.112', '2026-01-16 12:01:01'),
(118, 1, 'admin', 'update', 'sollicitatie', 14, 'Jelle Romijn - Geaccepteerd', NULL, '10.52.6.112', '2026-01-16 12:01:36'),
(119, 1, 'admin', 'view', 'sollicitatie', 13, 'Sam Berghoef - Back-end Developer', NULL, '10.52.6.112', '2026-01-16 12:01:43'),
(120, 1, 'admin', 'update', 'sollicitatie', 13, 'Sam Berghoef - Geaccepteerd', NULL, '10.52.6.112', '2026-01-16 12:02:10'),
(121, 1, 'admin', 'view', 'sollicitatie', 12, 'Sebastiaan Kuper - Front-end Developer', NULL, '10.52.6.112', '2026-01-16 12:02:13'),
(122, 1, 'admin', 'update', 'sollicitatie', 12, 'Sebastiaan Kuper - Afgewezen', NULL, '10.52.6.112', '2026-01-16 12:02:44'),
(123, 1, 'admin', 'view', 'sollicitatie', 11, 'duzyano - Front-end Developer', NULL, '10.52.6.112', '2026-01-16 12:02:50'),
(124, 1, 'admin', 'update', 'sollicitatie', 11, 'duzyano - Geaccepteerd', NULL, '10.52.6.112', '2026-01-16 12:03:26'),
(125, 1, 'admin', 'view', 'sollicitatie', 10, 'Sam Berghoef - Back-end Developer', NULL, '10.52.6.112', '2026-01-16 12:03:31'),
(126, 1, 'admin', 'update', 'sollicitatie', 10, 'Sam Berghoef - Geaccepteerd', NULL, '10.52.6.112', '2026-01-16 12:03:58'),
(127, 1, 'admin', 'view', 'sollicitatie', 9, 'MylÃ¨ne Zijlstra - Back-end Developer', NULL, '10.52.6.112', '2026-01-16 12:04:01'),
(128, 1, 'admin', 'update', 'sollicitatie', 9, 'MylÃ¨ne Zijlstra - Geaccepteerd', NULL, '10.52.6.112', '2026-01-16 12:04:17'),
(129, 1, 'admin', 'view', 'sollicitatie', 9, 'MylÃ¨ne Zijlstra - Back-end Developer', NULL, '10.52.6.112', '2026-01-16 12:04:20'),
(130, 1, 'admin', 'view', 'sollicitatie', 27, 'bas spies - Front-end Developer', NULL, '10.52.6.112', '2026-01-16 12:04:52'),
(131, 1, 'admin', 'update', 'sollicitatie', 28, 'Mark Petrenko - Afgewezen', NULL, '10.52.6.112', '2026-01-16 12:07:45'),
(132, 1, 'admin', 'view', 'sollicitatie', 24, 'Nielan den Haan - Front-end Developer', NULL, '10.52.6.112', '2026-01-16 12:26:52'),
(133, 1, 'admin', 'login', 'system', 1, 'admin', NULL, '10.52.6.112', '2026-01-16 13:12:06'),
(134, 1, 'admin', 'view', 'sollicitatie', 29, 'Rachael Schaap - Front-end Developer', NULL, '10.52.6.112', '2026-01-16 13:12:17'),
(135, 1, 'admin', 'update', 'sollicitatie', 29, 'Rachael Schaap - Geaccepteerd', NULL, '10.52.6.112', '2026-01-16 13:12:50'),
(136, 1, 'admin', 'delete', 'sollicitatie', 28, 'Mark Petrenko - Front-end Developer', NULL, '10.52.6.112', '2026-01-16 13:12:57'),
(137, 1, 'admin', 'view', 'sollicitatie', 27, 'bas spies - Front-end Developer', NULL, '10.52.6.112', '2026-01-16 13:26:53'),
(138, 1, 'admin', 'view', 'sollicitatie', 25, 'Mitchell Lijffijt - Front-end Developer', NULL, '10.52.6.112', '2026-01-16 13:27:29'),
(139, 1, 'admin', 'view', 'sollicitatie', 26, 'David Mateman - Front-end Developer', NULL, '10.52.6.112', '2026-01-16 13:27:55'),
(140, 1, 'admin', 'view', 'sollicitatie', 22, 'Noa van Mil - Front-end Developer', NULL, '10.52.6.112', '2026-01-16 13:28:02'),
(141, 1, 'admin', 'view', 'sollicitatie', 12, 'Sebastiaan Kuper - Front-end Developer', NULL, '10.52.6.112', '2026-01-16 13:28:23'),
(142, 1, 'admin', 'view', 'sollicitatie', 27, 'bas spies - Front-end Developer', NULL, '10.52.6.112', '2026-01-16 13:30:07'),
(143, 1, 'admin', 'view', 'sollicitatie', 25, 'Mitchell Lijffijt - Front-end Developer', NULL, '10.52.6.112', '2026-01-16 13:32:33'),
(144, 1, 'admin', 'view', 'sollicitatie', 22, 'Noa van Mil - Front-end Developer', NULL, '10.52.6.112', '2026-01-16 13:34:27'),
(145, 1, 'admin', 'view', 'sollicitatie', 12, 'Sebastiaan Kuper - Front-end Developer', NULL, '10.52.6.112', '2026-01-16 13:37:22'),
(146, 1, 'admin', 'login', 'system', 1, 'admin', NULL, '104.28.249.137', '2026-01-16 14:05:49'),
(147, 1, 'admin', 'view', 'sollicitatie', 29, 'Rachael Schaap - Front-end Developer', NULL, '104.28.249.137', '2026-01-16 14:06:07'),
(148, 1, 'admin', 'view', 'sollicitatie', 12, 'Sebastiaan Kuper - Front-end Developer', NULL, '104.28.249.137', '2026-01-16 14:06:25'),
(149, 1, 'admin', 'login', 'system', 1, 'admin', NULL, '104.28.249.138', '2026-01-19 07:14:29'),
(150, 1, 'admin', 'view', 'sollicitatie', 27, 'bas spies - Front-end Developer', NULL, '104.28.249.138', '2026-01-19 07:24:42'),
(151, 1, 'admin', 'view', 'sollicitatie', 25, 'Mitchell Lijffijt - Front-end Developer', NULL, '104.28.249.138', '2026-01-19 07:25:17'),
(152, 1, 'admin', 'view', 'sollicitatie', 22, 'Noa van Mil - Front-end Developer', NULL, '104.28.249.138', '2026-01-19 07:26:00'),
(153, 1, 'admin', 'login', 'system', 1, 'admin', NULL, '104.28.217.138', '2026-01-19 08:50:53'),
(154, 1, 'admin', 'view', 'sollicitatie', 31, 'Noa van Mil - Front-end designer', NULL, '104.28.217.138', '2026-01-19 08:52:33'),
(155, 1, 'admin', 'login', 'system', 1, 'admin', NULL, '104.28.249.140', '2026-01-19 09:24:41'),
(156, 1, 'admin', 'login', 'system', 1, 'admin', NULL, '104.28.249.137', '2026-01-19 12:18:50'),
(157, 1, 'admin', 'view', 'sollicitatie', 33, 'bas spies - Front-end Developer', NULL, '104.28.249.137', '2026-01-19 12:18:55'),
(158, 1, 'admin', 'view', 'sollicitatie', 32, 'Mitchell Lijffijt - Front-end Developer', NULL, '104.28.249.137', '2026-01-19 12:19:22'),
(159, 1, 'admin', 'view', 'sollicitatie', 31, 'Noa van Mil - Front-end designer', NULL, '104.28.249.137', '2026-01-19 12:19:41'),
(160, 1, 'admin', 'view', 'sollicitatie', 30, 'Lars Mudde - Front-end Developer', NULL, '104.28.249.137', '2026-01-19 12:19:52'),
(161, 1, 'admin', 'login', 'system', 1, 'admin', NULL, '10.55.30.226', '2026-01-19 14:48:01'),
(162, 1, 'admin', 'login', 'system', 1, 'admin', NULL, '10.52.6.112', '2026-01-20 11:07:07'),
(163, 1, 'admin', 'view', 'sollicitatie', 27, 'bas spies - Front-end Developer', NULL, '10.52.6.112', '2026-01-20 11:07:19'),
(164, 1, 'admin', 'view', 'sollicitatie', 33, 'bas spies - Front-end Developer', NULL, '10.52.6.112', '2026-01-20 11:07:52'),
(165, 1, 'admin', 'update', 'sollicitatie', 33, 'bas spies - Geaccepteerd', NULL, '10.52.6.112', '2026-01-20 11:08:46'),
(166, 1, 'admin', 'view', 'sollicitatie', 35, 'Mohammad Kassem - Front-end Developer', NULL, '10.52.6.112', '2026-01-20 11:08:51'),
(167, 1, 'admin', 'update', 'sollicitatie', 35, 'Mohammad Kassem - Afgewezen', NULL, '10.52.6.112', '2026-01-20 11:09:51'),
(168, 1, 'admin', 'view', 'sollicitatie', 31, 'Noa van Mil - Front-end designer', NULL, '10.52.6.112', '2026-01-20 11:10:00'),
(169, 1, 'admin', 'update', 'sollicitatie', 31, 'Noa van Mil - Geaccepteerd', NULL, '10.52.6.112', '2026-01-20 11:10:18'),
(170, 1, 'admin', 'view', 'sollicitatie', 34, 'Walid Salhi - Front-end Developer', NULL, '10.52.6.112', '2026-01-20 11:10:25'),
(171, 1, 'admin', 'update', 'sollicitatie', 34, 'Walid Salhi - Afgewezen', NULL, '10.52.6.112', '2026-01-20 11:11:03'),
(172, 1, 'admin', 'view', 'sollicitatie', 32, 'Mitchell Lijffijt - Front-end Developer', NULL, '10.52.6.112', '2026-01-20 11:11:08'),
(173, 1, 'admin', 'update', 'sollicitatie', 32, 'Mitchell Lijffijt - Afgewezen', NULL, '10.52.6.112', '2026-01-20 11:12:29'),
(174, 1, 'admin', 'view', 'sollicitatie', 30, 'Lars Mudde - Front-end Developer', NULL, '10.52.6.112', '2026-01-20 11:12:35'),
(175, 1, 'admin', 'update', 'sollicitatie', 30, 'Lars Mudde - Afgewezen', NULL, '10.52.6.112', '2026-01-20 11:13:34'),
(176, 1, 'admin', 'view', 'sollicitatie', 34, 'Walid Salhi - Front-end Developer', NULL, '10.52.6.112', '2026-01-20 11:18:27'),
(177, 1, 'admin', 'view', 'sollicitatie', 30, 'Lars Mudde - Front-end Developer', NULL, '10.52.6.112', '2026-01-20 11:27:47'),
(178, 1, 'admin', 'view', 'sollicitatie', 30, 'Lars Mudde - Front-end Developer', NULL, '10.52.6.112', '2026-01-20 11:28:57'),
(179, 1, 'admin', 'view', 'sollicitatie', 32, 'Mitchell Lijffijt - Front-end Developer', NULL, '10.52.6.112', '2026-01-20 11:30:44'),
(180, 1, 'admin', 'update', 'sollicitatie', 32, 'Mitchell Lijffijt - Geaccepteerd', NULL, '10.52.6.112', '2026-01-20 11:31:13'),
(181, 1, 'admin', 'view', 'sollicitatie', 34, 'Walid Salhi - Front-end Developer', NULL, '10.52.6.112', '2026-01-20 11:31:18'),
(182, 1, 'admin', 'view', 'sollicitatie', 35, 'Mohammad Kassem - Front-end Developer', NULL, '10.52.6.112', '2026-01-20 11:32:43'),
(183, 1, 'admin', 'login', 'system', 1, 'admin', NULL, '104.28.217.140', '2026-01-20 12:29:18'),
(184, 1, 'admin', 'view', 'sollicitatie', 34, 'Walid Salhi - Front-end Developer', NULL, '104.28.217.140', '2026-01-20 12:30:08'),
(185, 1, 'admin', 'view', 'sollicitatie', 35, 'Mohammad Kassem - Front-end Developer', NULL, '104.28.217.140', '2026-01-20 12:30:16'),
(186, 1, 'admin', 'view', 'sollicitatie', 35, 'Mohammad Kassem - Front-end Developer', NULL, '104.28.217.140', '2026-01-20 12:30:20'),
(187, 1, 'admin', 'login', 'system', 1, 'admin', NULL, '10.52.6.112', '2026-01-22 09:03:25'),
(188, 1, 'admin', 'view', 'sollicitatie', 14, 'Jelle Romijn - Back-end Developer', NULL, '10.52.6.112', '2026-01-22 09:04:07'),
(189, 1, 'admin', 'view', 'sollicitatie', 16, 'ShenÃ© Banga - Front-end Developer', NULL, '10.52.6.112', '2026-01-22 09:31:07'),
(190, 1, 'admin', 'view', 'sollicitatie', 36, 'Walid Salhi - Front-end Developer', NULL, '10.52.6.112', '2026-01-22 09:41:34'),
(191, 1, 'admin', 'view', 'sollicitatie', 20, 'Tom Tiedemann - Back-end Developer', NULL, '10.52.6.112', '2026-01-22 09:53:07'),
(192, 1, 'admin', 'view', 'sollicitatie', 24, 'Nielan den Haan - Front-end Developer', NULL, '10.52.6.112', '2026-01-22 10:10:51'),
(193, 1, 'admin', 'login', 'system', 1, 'admin', NULL, '10.52.8.110', '2026-01-22 10:15:49'),
(194, 1, 'admin', 'login', 'system', 1, 'admin', NULL, '10.52.8.249', '2026-01-22 10:15:57'),
(195, 1, 'admin', 'view', 'sollicitatie', 21, 'Ridouan Rashid - Back-end Developer', NULL, '10.52.6.112', '2026-01-22 10:16:26'),
(196, 1, 'admin', 'update', 'vacature', 11, 'Hoofdredacteur', NULL, '10.52.8.110', '2026-01-22 10:17:36'),
(197, 1, 'admin', 'update', 'vacature', 11, 'Hoofdredacteur', NULL, '10.52.8.110', '2026-01-22 10:19:14'),
(198, 1, 'admin', 'view', 'sollicitatie', 37, 'Mohammad Kassem - Front-end Developer', NULL, '10.52.8.110', '2026-01-22 10:21:29'),
(199, 1, 'admin', 'view', 'sollicitatie', 35, 'Mohammad Kassem - Front-end Developer', NULL, '10.52.8.110', '2026-01-22 10:22:19'),
(200, 1, 'admin', 'update', 'vacature', 10, 'Projectmanager', NULL, '10.52.8.110', '2026-01-22 10:24:15'),
(201, 1, 'admin', 'view', 'sollicitatie', 23, 'Lianne Meiresonne - Front-end Developer', NULL, '10.52.6.112', '2026-01-22 10:28:15'),
(202, 1, 'admin', 'login', 'system', 1, 'admin', NULL, '10.52.6.112', '2026-01-22 10:46:02'),
(203, 1, 'admin', 'view', 'sollicitatie', 29, 'Rachael Schaap - Front-end Developer', NULL, '10.52.6.112', '2026-01-22 10:46:29'),
(204, 1, 'admin', 'login', 'system', 1, 'admin', NULL, '10.52.6.112', '2026-01-22 11:30:42'),
(205, 1, 'admin', 'update', 'sollicitatie', 36, 'Walid Salhi - Geaccepteerd', NULL, '10.52.6.112', '2026-01-22 11:31:01'),
(206, 1, 'admin', 'update', 'sollicitatie', 37, 'Mohammad Kassem - Geaccepteerd', NULL, '10.52.6.112', '2026-01-22 11:31:04'),
(207, 1, 'admin', 'view', 'sollicitatie', 33, 'bas spies - Front-end Developer', NULL, '10.52.6.112', '2026-01-22 11:31:23'),
(208, 1, 'admin', 'login', 'system', 1, 'admin', NULL, '10.52.6.112', '2026-01-22 12:05:16'),
(209, 1, 'admin', 'view', 'sollicitatie', 37, 'Mohammad Kassem - Front-end Developer', NULL, '10.52.6.112', '2026-01-22 12:05:23'),
(210, 1, 'admin', 'login', 'system', 1, 'admin', NULL, '178.84.102.43', '2026-01-30 08:28:57'),
(211, 1, 'admin', 'logout', 'system', 1, 'admin', NULL, '178.84.102.43', '2026-01-30 08:34:49'),
(212, 1, 'admin', 'login', 'system', 1, 'admin', NULL, '::1', '2026-05-22 09:36:42'),
(213, 1, 'admin', 'update', 'sollicitatie', 41, 'Julia - Geaccepteerd', NULL, '::1', '2026-05-22 09:42:06'),
(214, 1, 'admin', 'view', 'sollicitatie', 35, 'Mohammad Kassem - Front-end Developer', NULL, '::1', '2026-05-22 09:49:22'),
(215, 1, 'admin', 'view', 'sollicitatie', 41, 'Julia - Back-end Developer', NULL, '::1', '2026-05-22 09:49:27'),
(216, 1, 'admin', 'update', 'sollicitatie', 41, 'Julia - Terug naar In Behandeling', NULL, '::1', '2026-05-22 09:49:40'),
(217, 1, 'admin', 'view', 'sollicitatie', 41, 'Julia - Back-end Developer', NULL, '::1', '2026-05-22 09:49:40'),
(218, 1, 'admin', 'update', 'sollicitatie', 41, 'Julia - Afgewezen', NULL, '::1', '2026-05-22 09:51:30'),
(219, 1, 'admin', 'view', 'sollicitatie', 41, 'Julia - Back-end Developer', NULL, '::1', '2026-05-22 09:51:32'),
(220, 1, 'admin', 'view', 'sollicitatie', 42, 'Julia Brouwer - Back-end Developer', NULL, '::1', '2026-05-22 09:54:21'),
(221, 1, 'admin', 'update', 'sollicitatie', 42, 'Julia Brouwer - Geaccepteerd', NULL, '::1', '2026-05-22 09:55:00'),
(222, 1, 'admin', 'view', 'sollicitatie', 42, 'Julia Brouwer - Back-end Developer', NULL, '::1', '2026-05-22 09:55:02'),
(223, 1, 'admin', 'view', 'sollicitatie', 42, 'Julia Brouwer - Back-end Developer', NULL, '::1', '2026-05-22 10:04:45'),
(224, 1, 'admin', 'update', 'sollicitatie', 42, 'Julia Brouwer - Terug naar In Behandeling', NULL, '::1', '2026-05-22 10:04:52'),
(225, 1, 'admin', 'view', 'sollicitatie', 42, 'Julia Brouwer - Back-end Developer', NULL, '::1', '2026-05-22 10:04:52'),
(226, 1, 'admin', 'update', 'sollicitatie', 42, 'Julia Brouwer - Geaccepteerd', NULL, '::1', '2026-05-22 10:04:56'),
(227, 1, 'admin', 'view', 'sollicitatie', 42, 'Julia Brouwer - Back-end Developer', NULL, '::1', '2026-05-22 10:04:58'),
(228, 1, 'admin', 'update', 'sollicitatie', 42, 'Julia Brouwer - Terug naar In Behandeling', NULL, '::1', '2026-05-22 10:05:04'),
(229, 1, 'admin', 'view', 'sollicitatie', 42, 'Julia Brouwer - Back-end Developer', NULL, '::1', '2026-05-22 10:05:04'),
(230, 1, 'admin', 'view', 'sollicitatie', 42, 'Julia Brouwer - Back-end Developer', NULL, '::1', '2026-05-22 10:06:43'),
(231, 1, 'admin', 'update', 'sollicitatie', 42, 'Julia Brouwer - Geaccepteerd', NULL, '::1', '2026-05-22 10:06:46'),
(232, 1, 'admin', 'view', 'sollicitatie', 42, 'Julia Brouwer - Back-end Developer', NULL, '::1', '2026-05-22 10:06:48');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bureau_admin`
--

CREATE TABLE `bureau_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `bureau_admin`
--

INSERT INTO `bureau_admin` (`id`, `username`, `password`, `admin`) VALUES
(1, 'admin', '$2y$12$6eUf.tiql1kC1XEJXY/aTu6dnHXVUqBaZ374Xa.MYAKIzyxEqc5Nu', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bureau_login_attempts`
--

CREATE TABLE `bureau_login_attempts` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `attempt_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `success` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `bureau_login_attempts`
--

INSERT INTO `bureau_login_attempts` (`id`, `ip_address`, `username`, `attempt_time`, `success`) VALUES
(40, '10.52.6.112', 'admin', '2026-01-22 09:03:25', 1),
(41, '10.52.8.110', 'admin-1', '2026-01-22 10:15:16', 0),
(42, '10.52.8.110', 'admin', '2026-01-22 10:15:49', 1),
(43, '10.52.8.249', 'admin-1', '2026-01-22 10:15:50', 0),
(44, '10.52.8.249', 'admin', '2026-01-22 10:15:57', 1),
(45, '10.52.6.112', 'admin', '2026-01-22 10:46:02', 1),
(46, '10.52.6.112', 'admin', '2026-01-22 11:30:42', 1),
(47, '10.52.6.112', 'admin', '2026-01-22 12:05:16', 1),
(48, '178.84.102.43', 'admin-01', '2026-01-30 08:28:34', 0),
(49, '178.84.102.43', 'admin', '2026-01-30 08:28:57', 1),
(50, '::1', 'test@test.nl', '2026-05-22 09:34:23', 0),
(51, '::1', 'test@test.nl', '2026-05-22 09:34:26', 0),
(52, '::1', 'admin', '2026-05-22 09:36:42', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bureau_sollicitaties`
--

CREATE TABLE `bureau_sollicitaties` (
  `id` int(11) NOT NULL,
  `datum` timestamp NOT NULL DEFAULT current_timestamp(),
  `naam` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `vacature` varchar(255) NOT NULL,
  `descriptie` text DEFAULT NULL,
  `status` enum('pending','accepted','rejected') DEFAULT 'pending',
  `bestand_pad` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `bureau_sollicitaties`
--

INSERT INTO `bureau_sollicitaties` (`id`, `datum`, `naam`, `email`, `vacature`, `descriptie`, `status`, `bestand_pad`) VALUES
(9, '2026-01-14 14:01:43', 'MylÃ¨ne Zijlstra', '240381@student.glu.nl', 'Back-end Developer', 'Werken bij Bureau voelt als een goede kans om echt ervaring op te doen in plaats van alleen een verplichte stage af te vinken. Hoewel Bureau vanuit de opleiding verplicht is, zie ik dit als een plek waar je daadwerkelijk meedraait en verantwoordelijkheid krijgt. Dat maakt het interessanter dan een andere stageplek, omdat er hier ruimte is om te leren door te doen en niet alleen toe te kijken.\r\nDe opleiding biedt een sterke theoretische basis, maar mist soms de praktische kant van hoe het er in het werkveld echt aan toe gaat. Samenwerken binnen een team, omgaan met deadlines en feedback krijgen van mensen buiten school zijn dingen die vooral in de praktijk geleerd worden. Bij Bureau is er de mogelijkheid om dat allemaal van dichtbij mee te maken.\r\nNa deze periode is het doel om zelfstandiger te kunnen werken, sterker te zijn in communicatie en meer vertrouwen te hebben in eigen vaardigheden. Verwacht van u en het team bij Bureau wordt begeleiding, eerlijke feedback en ruimte om fouten te maken, terwijl van mijn kant inzet, motivatie en een leergierige houding mogen worden verwacht.', 'accepted', 'assets/uploads/6967a1c7dd030_cv.pdf'),
(10, '2026-01-15 09:55:17', 'Sam Berghoef', 'berghoefsam79@gmail.com', 'Back-end Developer', '', 'accepted', 'assets/uploads/6968b985dcc6e_samCV.pdf'),
(11, '2026-01-15 10:07:41', 'duzyano', '240856@student.glu.nl', 'Front-end Developer', '', 'accepted', 'assets/uploads/6968bc6dc5ac9_cvvoorbureau.pdf'),
(12, '2026-01-15 10:55:56', 'Sebastiaan Kuper', '240198@student.glu.nl', 'Front-end Developer', '', 'rejected', 'assets/uploads/6968c7bcb6a79_CV_Sebastiaan_Kuper.pdf'),
(13, '2026-01-15 12:12:31', 'Sam Berghoef', 'berghoefsam79@gmail.com', 'Back-end Developer', 'Dit is mijn solicitatie, ik kon niet mijn cv en solicitatie in 1 keer sturen.', 'accepted', 'assets/uploads/6968d9af0e5ef_SollicitatieBureau.docx'),
(14, '2026-01-15 13:34:20', 'Jelle Romijn', 'jelletijmen@gmail.com', 'Back-end Developer', 'Ik wil graag bij het bureau werken omdat het mij een interessant bedrijf lijkt waar ik veel kan leren. Ik wil leren hoe ik goed kan samenwerken met collegaâ€™s en hoe het is om aan echte opdrachten voor klanten te werken. Zo kan ik meer ervaring opdoen in de praktijk. Daarnaast wil ik beter leren omgaan met klantcontact en duidelijk communiceren. Mijn doel is om na mijn tijd bij het bureau beter te kunnen samenwerken en zekerder te zijn in mijn werk. Jullie kunnen van mij een gemotiveerde, hardwerkende en ook gezellige collega verwachten die altijd zijn best doet.', 'accepted', 'assets/uploads/6968ecdc20a14_cv.docx'),
(15, '2026-01-15 17:38:24', 'Mahmoud', '240407@student.glu.nl', 'Front-end Developer', 'Gedreven junior developer met een sterke focus op JavaScript en websites ontwikkling. Ik werk doelgericht aan het verbeteren van mijn technische vaardigheden en hecht veel waarde aan duidelijke communicatie en samenwerking binnen een team. Ik zoek een professionele omgeving waarin ik kan groeien, verantwoordelijkheid kan nemen en kan bijdragen aan kwalitatieve, toekomstbestendige oplossingen', 'accepted', 'assets/uploads/696926105bfdd_C.V.pdf'),
(16, '2026-01-15 18:08:34', 'ShenÃ© Banga', 'shenebanga@gmail.com', 'Front-end Developer', 'Motivatiebrief\r\n\r\nIk zou graag bij Bureau willen werken, omdat ik mij verder wil ontwikkelen binnen software development in een professionele en uitdagende werkomgeving. Bureau spreekt mij aan omdat er wordt gewerkt aan grotere projecten voor echte klanten. Dit sluit goed aan bij mijn ambitie om mijn kennis van onder andere HTML, CSS en Javascript verder te verdiepen.\r\n\r\nBij mijn opleiding leer ik de basis van software development, maar ik mis soms de ervaring met echte opdrachtgevers. Bij Bureau hoop ik te leren hoe het is om voor een klant te werken aan een realistische project, waarbij rekening wordt gehouden met wensen van de klant. \r\n\r\nNa mijn tijd bij Bureau wil ik beter zijn in samenwerken binnen een team en sterker worden in klantgericht werken. Daarnaast wil ik mijn programmeervaardigheden verder ontwikkelen. \r\n\r\nVan Bureau verwacht ik begeleiding, en de mogelijkheid om te leren. Van mij mogen jullie een leergierige en verantwoordelijke werker verwachten die openstaat voor feedback en zich volledig inzet om bij te dragen aan het team en de projecten.\r\n\r\nMet vriendelijke groet,\r\nShenÃ© Banga', 'accepted', 'assets/uploads/69692d227fd3a_HetBureau-CV_ShenBanga.docx'),
(17, '2026-01-15 22:45:48', 'Malek Alrajawy', 'abdulmalekalrajawy30@gmail.com', 'Back-end Developer', 'Geen opmerkingen.', 'accepted', 'assets/uploads/69696e1c4801c_SollicitatievoorbereidingMalekAlrajawy.pdf'),
(18, '2026-01-15 23:40:24', 'Nielan den Haan', 'nielandenhaan@gmail.com', 'Front-end Developer', '', 'accepted', 'assets/uploads/69697ae80b60b_CV.pdf'),
(19, '2026-01-16 08:01:38', 'Levi Sastro', 'le.sastro@outlook.com', 'Front-end designer', 'Ik stuur deze vacature om bij het bureau nog meer te kunnen leren en nog om te kijken wat ik wil doen later of het nou front-end designer of project manager wordt', 'accepted', 'assets/uploads/6969f0620a63a_CV.pdf'),
(20, '2026-01-16 08:22:40', 'Tom Tiedemann', '240066@student.glu.nl', 'Back-end Developer', 'Ik wil graag bij Bureau werken omdat ik daar praktijkervaring kan opdoen die verder gaat dan wat ik op mijn opleiding leer. Tijdens mijn opleiding leer ik veel over programmeren, verschillende technieken en samenwerken, maar de echte connectie met de klant en werken in een bedrijfssfeer is moeilijk aan te leren zonder echte opdrachten. Bij Bureau verwacht ik te kunnen meemaken hoe het er in een echt bedrijf aan toe gaat en hoe je goed kunt samenwerken in een team. Wat ik zoek bij Bureau is een stukje begeleiding in hoe ik goed kan beginnen en mijzelf kan blijven verbeteren. Van mij mogen jullie verwachten dat ik gemotiveerd ben, inzet toon, wil leren en altijd mijn best doe.', 'accepted', 'assets/uploads/6969f550e3be5_CVTomTiedemann.pdf'),
(21, '2026-01-16 08:27:21', 'Ridouan Rashid', 'ridouanrashid@gmail.com', 'Back-end Developer', 'Ik ben gemotiveerd om te werken bij het bureau omdat het me een goede kans geeft om mijn skills uit te breiden doormiddel van werken met echte klanten. Ik zie werken bij het bureau als een goede kans om echte ervaring op te doen in. In het bureau krijg ik te maken met opdrachten die niet worden voorbereid door docenten en daar kijk ik voorwal naar uit. Na mijn tijd bij het bureau wil ik vooral beter zijn in werken met klanten en offertes maken. Ik verwacht een leuke werk sfeer en leuke projecten, en van mij kun je een leuke collega verwachten', 'accepted', 'assets/uploads/6969f669a39e9_CV.pdf'),
(22, '2026-01-16 08:35:23', 'Noa van Mil', '240461@student.glu.nl', 'Front-end Developer', 'ik heb veel kennis van html, php, css en javascript. Ik ben altijd bereid om meer te leren en ik hou van een goede uitdaging.', 'rejected', 'assets/uploads/6969f84bdce67_CVNoa1.pdf'),
(23, '2026-01-16 08:37:16', 'Lianne Meiresonne', '240060@student.glu.nl', 'Front-end Developer', 'Ik zou graag bij Bureau willen werken omdat de werksfeer me aanspreekt en ik het \r\ngevoel heb dat ik hier veel kan leren, zoals samenwerken en klantcontact. Wat ik vooral \r\nzoek is meer praktijkervaring, iets wat je in lessen minder krijgt. Ook het samenwerken \r\nin een echt team lijkt me leuk omdat ik dat graag doe. Ik wil beter leren omgaan met \r\nklanten, zelfstandiger en netter werken en sterker worden in het samenwerken met \r\nmensen van verschillende opleidingen. Van jullie verwacht ik een goede werksfeer en \r\ngemotiveerde collegaâ€™s. Van mij mogen jullie inzet, een positieve werkhouding en een \r\nopen houding om te blijven leren verwachten.', 'accepted', 'assets/uploads/6969f8bc3bb78_CVLianneMeiresonne.pdf'),
(24, '2026-01-16 08:47:36', 'Nielan den Haan', 'nielandenhaan@gmail.com', 'Front-end Developer', 'Ik wil bij het schoolbureau werken omdat ik daar aan echte projecten kan werken, zelfstandiger leer werken en mijn programmeer en samenwerkingsvaardigheden verder kan ontwikkelen.', 'accepted', 'assets/uploads/6969fb282ced4_CV.pdf'),
(25, '2026-01-16 08:49:00', 'Mitchell Lijffijt', '240913@student.glu.nl', 'Front-end Developer', 'Ik wil graag als front-end developer bij het bureau werken omdat ik het leuk vind om creatief bezig te zijn met techniek. Tijdens mijn opleiding Creative Software Development heb ik ontdekt dat ik het bouwen van gebruiksvriendelijke en mooie websites en applicaties erg interessant vind.', 'rejected', 'assets/uploads/6969fb7c6c3da_CV.docx'),
(26, '2026-01-16 09:44:21', 'David Mateman', 'd.mateman18@gmail.com', 'Front-end Developer', 'Ik wil bij het Bureau werken omdat jullie niet alleen uitvoeren wat een klant vraagt, maar meedenken over wat er echt nodig is. Die mentaliteit zoek ik. Ik kan inderdaad ergens anders werken, maar ik wil leren op een niveau waar meerdere opleidingen samenwerken. Bij bureau worden projecten serieus genomen en dat is kwaliteit belangrijker dan sneller of gemak. Dat vind ik intessanter dan op een plek te werken waar het alleen om productie draait. \r\nWat ik hier zoek wat mijn opleiding niet geeft, is echte praktijkverantwoordelijkheid. Op school leer ik de basis en theorie, maar ik leer dan niet hoe keuzes impact hebben op een klant. Ik wil meemaken hoe beslissingen worden gemaakt onder druk, met deadlines en echte verwachtingen.\r\nNa mijn tijd bij Bureau wil ik beter zijn in zelfstandig werken, kritisch meedenken en onder druk met deadlines kunnen werken. Ik wil niet alleen technisch beter worden, maar ook met klanten en samenwerking. Van jullie verwacht ik eerlijke feedback, hoge standaarden en ruimte om te leren door te doen. Van mij mogen jullie inzet, verantwoordelijkheid en de wil om beter te worden verwacthen, ook als dat betekent dat ik uit mijn comfortzone moet.', 'accepted', 'assets/uploads/696a08758b46d_Davidmateman1.pdf'),
(27, '2026-01-16 10:42:44', 'bas spies', '240806@student.glu.nl', 'Front-end Developer', 'ik ben gemotiveerd en heb veel interesse in frontend te gaan werken. ik werk nauwkeurig en ben goed in team werk.', 'rejected', 'assets/uploads/696a16247b176_sollicitatiebureau.docx'),
(29, '2026-01-16 13:00:48', 'Rachael Schaap', '240761@student.glu.nl', 'Front-end Developer', '', 'accepted', 'assets/uploads/696a368091498_CVsollicitatie.pdf'),
(30, '2026-01-16 15:17:49', 'Lars Mudde', '240753@student.glu.nl', 'Front-end Developer', '', 'rejected', 'assets/uploads/696a569d3bdea_LarsMuddecv.pdf'),
(31, '2026-01-16 20:36:37', 'Noa van Mil', '240461@student.glu.nl', 'Front-end designer', 'Ik wil graag bij het Bureau werken vanwege de creatieve mogelijkheden, de leuke werksfeer en de ruimte voor ontwikkeling. Ik zoek hier vooral de kans om beter samen te werken met andere opleidingen, zoals met een echte designer, omdat dit iets is wat je op de opleiding zelf minder leert. Op die manier wil ik ook meer praktijkervaring opdoen.\r\n\r\nNa mijn tijd bij Bureau wil ik beter zijn in het samenwerken binnen een echt team en zelfverzekerd kunnen communiceren met echte klanten en hun wensen. Ik verwacht van jullie de kans om meer te leren en dit te kunnen doen in een goede en fijne werksfeer. Van mij kunnen jullie een goede en nette werkhouding verwachten en een positieve, open houding om nieuwe dingen te leren.', 'accepted', 'assets/uploads/696aa15556a2a_CVNoa1.pdf'),
(32, '2026-01-19 10:25:06', 'Mitchell Lijffijt', '240913@student.glu.nl', 'Front-end Developer', 'Ik heb veel interesse in deze functie omdat ik mij verder wil ontwikkelen als front-end developer. Ik werk graag aan creatieve projecten en vind het belangrijk om samen te werken aan gebruiksvriendelijke oplossingen.', 'accepted', 'assets/uploads/696e068217118_CV3.docx'),
(33, '2026-01-19 10:42:13', 'bas spies', '240806@student.glu.nl', 'Front-end Developer', 'Ik ben een enthousiaste student die zich graag wil ontwikkelen als front-end developer. Ik combineer creativiteit met een goede werkmentaliteit, leer snel en werk gestructureerd. Ik sta open voor feedback en wil blijven groeien binnen dit vakgebied.', 'accepted', 'assets/uploads/696e0a856e3a0_CV.pdf'),
(34, '2026-01-20 08:05:22', 'Walid Salhi', '240787@student.glu.nl', 'Front-end Developer', 'Sorry dat ik het te laat heb ingeleverd.', 'rejected', 'assets/uploads/696f3742b4160_CV.docx'),
(35, '2026-01-20 10:00:10', 'Mohammad Kassem', '240990@student.glu.nl', 'Front-end Developer', '', 'rejected', 'assets/uploads/696f522a837dd_Mohammed-Kassem-20-01-2026CV-Bureau.pdf'),
(36, '2026-01-22 09:04:40', 'Walid Salhi', '240787@student.glu.nl', 'Front-end Developer', 'ik kon niet 2 bestanden sturen dus ik stuur nu de motivatie brief', 'accepted', 'assets/uploads/6971e82841be2_moticatie.docx'),
(37, '2026-01-22 10:18:38', 'Mohammad Kassem', '240990@student.glu.nl', 'Front-end Developer', 'Motivatie\r\n\r\nHierbij solliciteer ik naar de functie van Front-end Developer. Deze functie spreekt mij aan omdat ik plezier haal uit het creÃ«ren van applicaties en het bedenken van oplossingen voor bestaande problemen. Het liefst maak ik websites die er zo goed en verzorgd mogelijk uitzien. Dit komt mede doordat ik enigszins perfectionistisch ben, wat goed van pas kan komen bij opdrachten voor echte klanten.\r\n\r\nDaarnaast heb ik ervaring met het bouwen van responsive websites en het toepassen van basisprincipes van SEO. Ik werk hierbij zo efficiÃ«nt mogelijk en maak daarom graag gebruik van CSS-frameworks zoals Bootstrap en Tailwind. Met JavaScript heb ik iets minder ervaring, maar het is voor mij een belangrijk doel om mij hierin verder te ontwikkelen.\r\n\r\nAf en toe maak ik gebruik van AI als hulpmiddel, bijvoorbeeld om oplossingen te controleren of nieuwe ideeÃ«n op te doen. Tot slot sta ik altijd open om nieuwe technieken te leren en mezelf verder te verbeteren binnen het vakgebied.', 'accepted', 'assets/uploads/6971f97ecac2d_Mohammed-Kassem-20-01-2026CV-Bureau.pdf'),
(38, '2026-01-26 10:19:19', 'Bilal', 'bilal127g14@gmail.com', 'Back-end Developer', '', 'pending', 'assets/uploads/69773fa770e51_CV.pdf'),
(39, '2026-01-31 16:59:09', 'Sultan Avdi', '240504@student.glu.nl', 'Back-end Developer', 'Ik mocht het gesprek later doen vanwege mijn blessure', 'pending', 'assets/uploads/697e34dd45c29_cvbureu.docx'),
(40, '2026-02-09 09:51:31', 'Hannah Tjin A Soe', 'hannahtjin@gmail.com', 'Conceptor en innovator', 'hoi, ik zou graag voor deze vacature willen solliciteren', 'pending', 'assets/uploads/6989ae2326616_HannahTjinASoe-CV.pdf'),
(41, '2026-05-22 09:41:37', 'Julia', '230062@student.glu.nl', 'Back-end Developer', 'testing', 'rejected', 'assets/uploads/6a1024d146b1c_CV_JB_2026_LESS_NOISE.pdf'),
(42, '2026-05-22 09:54:13', 'Julia Brouwer', 'julia.brouwervanoudshoorn@gmail.com', 'Back-end Developer', 'test 2', 'accepted', 'assets/uploads/6a1027c5d5946_CV_JB_2026_LESS_NOISE.pdf');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bureau_vacatures`
--

CREATE TABLE `bureau_vacatures` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `location` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `requirements` text NOT NULL,
  `salary` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `bureau_vacatures`
--

INSERT INTO `bureau_vacatures` (`id`, `title`, `location`, `type`, `description`, `requirements`, `salary`, `image`) VALUES
(1, 'Front-end Developer', 'Utrecht', 'Full-time', 'Bij Het Bureau zijn we op zoek naar creatieve front-end wizards! Kan jij maken wat een designer wil?\r\n\r\nBinnen Het Bureau helpen we niet alleen klanten, maar ook elkaar. Samen leren en elkaar helpen is waardevol!\r\n\r\nYou\'re the wizard\r\nWij zijn op zoek naar een code wizard! Iemand die mooie designs kan omzetten in websites.\r\n\r\nBen jij iemand die liever programmeert aan de voorkant van websites? Lees dan vooral verder!', 'Basiskennis van HTML, CSS en Javascript.\r\n\r\nKennis van PHP, MySQL is een prï¿½.\r\n\r\nGevoel voor design en techniek. Omzetten van een design in een technisch wonder!\r\n\r\nAffiniteit voor nieuwe front-end technieken. Denk hierbij aan het gebruik van animaties en GitHub.\r\n\r\nJe kunt goed samenwerken met andere mensen!\r\n\r\nEen eigen portfolio waarin wij je skills kunnen zien!', 'Naast een leuke en gezellige werkplek bieden wij: Ondersteuning en begeleiding, doorgroeimogelijkheden, creatieve sessies, 55 vakantiedagen, flexibele werktijden', '/assets/img/jobs/frontend-developer.webp'),
(2, 'Back-end Developer', 'Utrecht', 'Full-time', 'Bij Het Bureau zijn we op zoek naar de technische masters! Kan jij een technische oplossing verzinnen voor klanten?\r\n\r\nBinnen Het Bureau helpen we niet alleen klanten, maar ook elkaar. Samen leren en elkaar helpen is waardevol!\r\n\r\nYou\'re the master\r\nWij zijn op zoek naar een code masters! Iemand die de mooiste en beste systemen kan automatiseren of zelf bedenken.\r\n\r\nBen jij iemand die liever programmeert en bedenkt hoe een online systeem gaat werken? Lees dan vooral verder!', 'Basiskennis van HTML, CSS, Javascript, GitHub, PHP en MySQL.\r\n\r\nKennis van Django en Symfony is een prï¿½.\r\n\r\nOplossingsgericht denken. Niet denken in problemen maar in oplossingen!\r\n\r\nAffiniteit met nieuwe back-end technieken. Denk hierbij aan OOP, Resque, API-first methode.\r\n\r\nJe kunt goed samenwerken met andere mensen!\r\n\r\nEen eigen portfolio waarin wij je skills kunnen zien!', 'Naast een leuke en gezellige werkplek bieden wij: Ondersteuning en begeleiding, doorgroeimogelijkheden, creatieve sessies, 55 vakantiedagen, flexibele werktijden', '/assets/img/jobs/backend-developer.webp'),
(3, 'Web audiovisueel', 'Utrecht', 'Full-time', 'Bij Het Bureau zijn we op zoek naar de regisseur van de film \"HET BUREAU\"!\nKan jij klanten helpen met het visualiseren van hun idee?\n\nBinnen Het Bureau helpen we niet alleen klanten, maar ook elkaar. Samen leren en elkaar helpen is waardevol!\n\nYou\'re the director\nWij zijn op zoek naar een filmregisseur en editor! Iemand die de beste video, foto of geluid kan maken voor een website of social media.\n\nBen jij iemand die alles ziet door een camera? Lees dan vooral verder!', 'Basiskennis van video-editing, foto-editing, animaties maken.\n\nKan werken met Adobe Creative Cloud pakket!\n\nAffiniteit met muziek, films en social media.\n\nJe kunt goed samenwerken met andere mensen!\n\nEen eigen portfolio waarin wij je skills kunnen zien!', 'Naast een leuke en gezellige werkplek bieden wij: Ondersteuning en begeleiding, doorgroeimogelijkheden, creatieve sessies, 55 vakantiedagen, flexibele werktijden', '/assets/img/jobs/web-audiovisueel.webp'),
(4, 'Grafisch ontwerper', 'Utrecht', 'Full-time', 'Bij Het Bureau zijn we op zoek de nieuwe Rembrandt!\nBen jij goed op met het visualiseren op een digitaal canvas?\n\nBinnen Het Bureau helpen we niet alleen klanten, maar ook elkaar. Samen leren en elkaar helpen is waardevol!\n\nYou\'re the artist\nWij zijn op zoek naar een kunstenaar! Iemand die de mooiste posters, visitekaartjes, huisstijlen of logo\'s maakt.\n\nBen jij iemand die alles kan tekenen of digitaal kan maken? Lees dan vooral verder!', 'Basiskennis van foto-editing, tekenen, out of the box-denken.\n\nKan werken met Adobe Creative Cloud-pakket!\n\nAffiniteit met design en kunst.\n\nJe kan goed samenwerken met andere mensen!\n\nEen eigen portfolio waarin wij je skills kunnen zien!', 'Naast een leuke en gezellige werkplek bieden wij: Ondersteuning en begeleiding, doorgroeimogelijkheden, creatieve sessies, 55 vakantiedagen, flexibele werktijden', '/assets/img/jobs/grafisch-ontwerper.webp'),
(5, 'Video specialist', 'Utrecht', 'Full-time', 'Bij Het Bureau zijn we op zoek naar de nieuwe Peter Jackson!\nKan jij klanten helpen met het visualiseren van hun idee?\n\nBinnen Het Bureau helpen we niet alleen klanten, maar ook elkaar. Samen leren en elkaar helpen is waardevol!\n\nYou\'re the video frame freak\nWij zijn op zoek naar een filmregisseur en editor! Iemand die de beste video, foto of geluid kan maken voor een website of social media.\n\nBen jij iemand die alles ziet door een camera? Lees dan vooral verder!', 'Je laat camera\'s doen waarvoor ze gemaakt zijn\n\nJe hebt kennis van premiere pro\n\nJe bent communicatief sterk en kunt zelfstandig en pro-actief aan de slag\n\nJe kunt goed samenwerken met andere mensen!\n\nKennis van live streaming is fijn', 'Naast een leuke en gezellige werkplek bieden wij: Ondersteuning en begeleiding, doorgroeimogelijkheden, creatieve sessies, 55 vakantiedagen, flexibele werktijden', '/assets/img/jobs/Video-specialist.webp'),
(6, 'Audio Engineer', 'Utrecht', 'Full-time', 'Bij Het Bureau zijn we opzoek naar de nieuwe Bram Krikke voor de BUREAU audio afdeling!!\nKan jij het Bureau of klanten helpen met hun digitale stem?\n\nBinnen Het Bureau helpen we niet alleen klanten, maar ook elkaar. Samen leren en elkaar helpen is waardevol!\n\nYou\'re the #wav-wave\nWij zijn op zoek naar een audio engineer! Iemand die het beste geluid kan vinden of de juiste podcast kan maken.\n\nBen jij iemand met een goed gevoel voor geluid? Lees dan vooral verder!', 'Jij hebt kennis van stemmen en gesprekken opnemen\n\nJij hebt liefde voor sound design\n\nJij kunt audio editen tot een gewenste voice-over en podcast\n\nJe kunt goed samenwerken met andere mensen!\n\nJij weet de juiste sound, de gewenste sfeer te creeeren met geluid', 'Naast een leuke en gezellige werkplek bieden wij: Ondersteuning en begeleiding, doorgroeimogelijkheden, creatieve sessies, 55 vakantiedagen, flexibele werktijden', '/assets/img/jobs/audio-engineer.webp\r\n'),
(7, 'Front-end designer', 'Utrecht', 'Full-time', 'Bij Het Bureau zijn we op zoek de nieuwe Mark Zuckerberg!\nBen jij goed met het bedenken van een goede interface?\n\nBinnen Het Bureau helpen we niet alleen klanten, maar ook elkaar. Samen leren en elkaar helpen is waardevol!\n\nYou\'re the astronaut\nWij zijn op zoek naar een astronaut van User Interface design! Iemand die de mooiste en nieuwste interfaces en designs maakt voor websites.\n\nBen jij iemand die creatieve nieuwe ideeën heeft voor websites en interfaces?', 'Basiskennis van User Interface, User Experience, Mobile Design en HTML/CSS.\n\nKennis van Design Thinking is een pré.\n\nKan werken met Adobe Creative Cloud-pakket!\n\nAffiniteit voor digitaal organiseren en usergericht denken.\n\nJe kunt goed samenwerken met andere mensen!\n\nEen eigen portfolio waarin wij je skills kunnen zien!\n\nErvaring met CMS Wordpress (plugins, migreren, thema\'s maken/aanpassen, content editing en handleidingen maken)', 'Naast een leuke en gezellige werkplek bieden wij: Ondersteuning en begeleiding, doorgroeimogelijkheden, creatieve sessies, 55 vakantiedagen, flexibele werktijden', '/assets/img/jobs/frontend-designer.webp'),
(8, 'Conceptor en innovator', 'Utrecht', 'Full-time', 'Bij Het Bureau zijn we op zoek de nieuwe Steve Jobs!\nBen jij goed met het bedenken van een nieuw product of dienst voor klanten?\n\nBinnen Het Bureau helpen we niet alleen klanten, maar ook elkaar. Samen leren en elkaar helpen is waardevol!\n\nYou\'re the innovator\nWij zijn op zoek naar een innovatie expert! Iemand die de nieuwste en meest creatieve ideeën kan verzinnen en visualiseren.\n\nBen jij iemand die leuke en nieuwe concepten kan bedenken en visualiseren?', 'Basiskennis van Out-of-the-box Thinking, styling en moodboards maken.\n\nKan werken met Adobe Creative Cloud-pakket!\n\nAffiniteit met nieuwe gadgets en ontwikkelingen.\n\nJe kunt goed samenwerken met andere mensen!\n\nEen eigen portfolio waarin wij je skills kunnen zien!', 'Naast een leuke en gezellige werkplek bieden wij: Ondersteuning en begeleiding, doorgroeimogelijkheden, creatieve sessies, 55 vakantiedagen, flexibele werktijden', '/assets/img/jobs/conceptor-innovator.webp'),
(9, 'E-commerce specialist', 'Utrecht', 'Full-time', 'Bij Het Bureau zijn we op zoek de uitvinder van de nieuwe Bol.com!\nBen jij degene die verstand heeft van online handelen?\n\nBinnen Het Bureau helpen we niet alleen klanten, maar ook elkaar. Samen leren en elkaar helpen is waardevol!\n\nYou\'re the specialist\nWij zijn op zoek naar een e-commerce expert! Iemand die alle ins en outs weet op gebied van online handelen (e-commerce).\n\nBen jij iemand die de best verkopende webshop kan opzetten en bouwen?', 'Basiskennis van WooCommerce, betaalprocessen en SEO.\n\nKennis van SEA, dropshipping, Magento en Prestashop is een pré.\n\nKan werken met Adobe Creative Cloud pakket!\n\nWil leren wat marketing, doelgroepen, user stories en persona\'s zijn.\n\nJe kunt goed samenwerken met andere mensen!\n\nEen eigen portfolio waarin wij je skills kunnen zien!', 'Naast een leuke en gezellige werkplek bieden wij: Ondersteuning en begeleiding, doorgroeimogelijkheden, creatieve sessies, 55 vakantiedagen, flexibele werktijden', '/assets/img/jobs/ecommerce-specialist.jpg'),
(10, 'Projectmanager', 'Utrecht', 'Full-time', 'Bij Het Bureau zijn we op zoek een manager voor een zootje ongeregeld!\r\nBen jij degene die van structuur en afspraken houdt?\r\n\r\nBinnen Het Bureau helpen we niet alleen klanten, maar ook elkaar. Samen leren en elkaar helpen is waardevol!\r\n\r\nYou\'re the manager\r\nWij zijn op zoek naar een manager voor leuke online projecten! Iemand die altijd alle touwtjes in handen wil hebben en graag zaken zelf goed organiseert.\r\n\r\nBen jij iemand die gestructureerd kan werken op basis van afspraken en overleg?', 'Basiskennis van projectmanagement software en kennis van programmeren in HTML/CSS/Javascript/PHP/MySQL.\r\n\r\nKan werken met Adobe Creative Cloud-pakket!\r\n\r\nWil leren wat het betekent om een goede manager te worden.\r\n\r\nJe kunt goed samenwerken met andere mensen!\r\n\r\nEen eigen portfolio waarin wij je skills kunnen zien!', 'Naast een leuke en gezellige werkplek bieden wij: Ondersteuning en begeleiding, doorgroeimogelijkheden, creatieve sessies, 55 vakantiedagen, flexibele werktijden', '/assets/img/jobs/project-manager.webp'),
(11, 'Hoofdredacteur', 'Utrecht', 'Full-time', 'Bij Het Bureau zijn we op zoek naar de perfectionist die goed kan organiseren!\r\nBen jij degene die veel verantwoordelijkheid heeft?\r\n\r\nBinnen Het Bureau helpen we niet alleen klanten, maar ook elkaar. Samen leren en elkaar helpen is waardevol!\r\n\r\nYou\'re the editor\r\nWij zijn op zoek naar een perfectionist! Iemand die werk van andere controlleert en kijkt of dit getoond mag worden, aan een klant of online.\r\n\r\nBen jij iemand die kritisch is en beslissingen kan maken?', 'Basiskennis van projectmanagement software en kennis van programmeren in HTML/CSS/Javascript/PHP/MySQL.\r\n\r\nKan werken met Adobe Creative Cloud-pakket!\r\n\r\nJe wilt leren wat het betekent om een goede redacteur te worden.\r\n\r\nJe kunt goed samenwerken met andere mensen!\r\n\r\nEen eigen portfolio waarin wij je skills kunnen zien!', 'Naast een leuke en gezellige werkplek bieden wij: Ondersteuning en begeleiding, doorgroeimogelijkheden, creatieve sessies, 55 vakantiedagen, flexibele werktijden', '/assets/img/jobs/docent.webp'),
(12, 'Social media guru', 'Utrecht', 'Full-time', 'Bij Het Bureau zijn we op zoek naar een social media guru!\r\nBen jij degene die alles afweet van social media?\r\n\r\nBinnen Het Bureau helpen we niet alleen klanten, maar ook elkaar. Samen leren en elkaar helpen is waardevol!\r\n\r\nYou\'re the #HASHTAGKINGORQUEEN\r\nWij zijn op zoek naar een specialist in communicatie en social media! Iemand die van social media ï¿½lles afweet en daar zelf aan bijdraagt.\r\n\r\nBen jij iemand die leuke en snappy comebacks heeft op een leuke social media post?', 'Basiskennis van Twitter, Facebook, Instagram, TikTok, Youtube.\r\n\r\nKennis van Google Ads en SEO is een prï¿½.\r\n\r\nKan werken met Adobe Creative Cloud-pakket!\r\n\r\nWil leren hoe je het beste online kan verkopen en reclame maken.\r\n\r\nJe kunt goed samenwerken met andere mensen!\r\n\r\nEen eigen portfolio waarin wij je skills kunnen zien!', 'Naast een leuke en gezellige werkplek bieden wij: Ondersteuning en begeleiding, doorgroeimogelijkheden, creatieve sessies, 55 vakantiedagen, flexibele werktijden', '/assets/img/jobs/socialmedia-guru.webp');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `bureau_activity_log`
--
ALTER TABLE `bureau_activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `entity_type` (`entity_type`),
  ADD KEY `created_at` (`created_at`);

--
-- Indexen voor tabel `bureau_admin`
--
ALTER TABLE `bureau_admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexen voor tabel `bureau_login_attempts`
--
ALTER TABLE `bureau_login_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ip_address` (`ip_address`),
  ADD KEY `attempt_time` (`attempt_time`);

--
-- Indexen voor tabel `bureau_sollicitaties`
--
ALTER TABLE `bureau_sollicitaties`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `bureau_vacatures`
--
ALTER TABLE `bureau_vacatures`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `bureau_activity_log`
--
ALTER TABLE `bureau_activity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=233;

--
-- AUTO_INCREMENT voor een tabel `bureau_admin`
--
ALTER TABLE `bureau_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `bureau_login_attempts`
--
ALTER TABLE `bureau_login_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT voor een tabel `bureau_sollicitaties`
--
ALTER TABLE `bureau_sollicitaties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT voor een tabel `bureau_vacatures`
--
ALTER TABLE `bureau_vacatures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
