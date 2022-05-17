-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql_cs:3306
-- Generation Time: May 17, 2022 at 07:02 PM
-- Server version: 8.0.28
-- PHP Version: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `database`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint UNSIGNED NOT NULL,
  `pid` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `n_guests` int UNSIGNED NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `currency_id` bigint UNSIGNED DEFAULT NULL,
  `tax_id` bigint UNSIGNED DEFAULT NULL,
  `room_id` int UNSIGNED NOT NULL,
  `date_check_in` timestamp NOT NULL,
  `date_check_out` timestamp NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `pid`, `n_guests`, `price`, `currency_id`, `tax_id`, `room_id`, `date_check_in`, `date_check_out`, `created_at`, `updated_at`, `deleted_at`) VALUES
(22, 'f92d7784-d5b4-11ec-b68d-0fcb6da08202', 1, '150.00', 1, 1, 1, '2022-05-22 00:00:00', '2022-05-29 00:00:00', '2022-05-17 07:42:56', '2022-05-17 07:42:58', NULL),
(23, '2ad81dd6-d5b8-11ec-976c-871b8a555d8b', 1, '110.00', 1, 1, 2, '2022-05-22 00:00:00', '2022-05-29 00:00:00', '2022-05-17 08:05:51', '2022-05-17 08:05:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` bigint UNSIGNED NOT NULL,
  `icon` varchar(50) NOT NULL,
  `html` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `iso_code` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `icon`, `html`, `iso_code`) VALUES
(1, 'icon-eur', '&euro;', 'EUR'),
(2, 'icon-dollar', '$', 'USD'),
(3, 'icon-gbp', '&pound;', 'GBP'),
(4, 'icon-dollar', '$', 'MXN');

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guests`
--

CREATE TABLE `guests` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `dni` varchar(9) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_1` int NOT NULL,
  `int_call_code_1` int DEFAULT NULL,
  `phone_2` int DEFAULT NULL,
  `int_call_code_2` int DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `city` text,
  `postal_code` int DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `guests`
--

INSERT INTO `guests` (`id`, `name`, `surname`, `dni`, `email`, `phone_1`, `int_call_code_1`, `phone_2`, `int_call_code_2`, `country`, `city`, `postal_code`, `birthday`, `created_at`, `updated_at`, `deleted_at`) VALUES
(10, 'Javier', 'Jiménez', '12345678A', 'javierjive@protonmail.com', 123456789, 34, NULL, NULL, NULL, NULL, NULL, NULL, '2022-05-17 07:43:13', '2022-05-17 07:43:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `guests_bookings`
--

CREATE TABLE `guests_bookings` (
  `id` bigint UNSIGNED NOT NULL,
  `guest_id` bigint UNSIGNED NOT NULL,
  `booking_id` bigint UNSIGNED NOT NULL,
  `room_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `guests_bookings`
--

INSERT INTO `guests_bookings` (`id`, `guest_id`, `booking_id`, `room_id`) VALUES
(7, 10, 22, 1),
(8, 10, 23, 2);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint UNSIGNED NOT NULL,
  `type` int NOT NULL,
  `number` int UNSIGNED NOT NULL,
  `name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `currency_id` bigint UNSIGNED NOT NULL,
  `tax_id` bigint UNSIGNED NOT NULL,
  `availability` set('0','1') NOT NULL DEFAULT '0',
  `details` text,
  `observations` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `type`, `number`, `name`, `price`, `currency_id`, `tax_id`, `availability`, `details`, `observations`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 101, 'Granada', '20.00', 1, 1, '1', 'Lorem Ipsum details Granada', 'Lorem Ipsum observations Granada', '2022-05-07 16:40:01', '2022-05-07 16:40:01', NULL),
(2, 1, 102, 'Málaga', '20.00', 1, 1, '1', 'Lorem Ipsum details Málaga', 'Lorem Ipsum observations Málaga', '2022-05-17 06:50:24', '2022-05-17 06:50:24', NULL),
(3, 1, 103, 'Cádiz', '20.00', 1, 1, '1', 'Lorem ipsum details Cádiz', 'Lorem ipsum observations Cádiz', '2022-05-17 18:34:21', '2022-05-17 18:34:21', NULL),
(4, 1, 104, 'Huelva', '20.00', 1, 1, '1', 'Lorem ipsum details Huelva', 'Lorem ipsum observations Huelva', '2022-05-17 18:36:29', '2022-05-17 18:36:29', NULL),
(5, 1, 105, 'Sevilla', '20.00', 1, 1, '1', 'Lorem ipsum details Sevilla', 'Lorem ipsum observations Sevilla', '2022-05-17 18:36:29', '2022-05-17 18:36:29', NULL),
(6, 1, 106, 'Córdoba', '20.00', 1, 1, '1', 'Lorem ipsum details Córdoba', 'Lorem ipsum observations Córdoba', '2022-05-17 18:38:28', '2022-05-17 18:38:28', NULL),
(7, 1, 107, 'Jaén', '20.00', 1, 1, '1', 'Lorem ipsum details Jaén', 'Lorem ipsum observations Jaén', '2022-05-17 18:38:28', '2022-05-17 18:38:28', NULL),
(8, 1, 108, 'Almería', '20.00', 1, 1, '1', 'Lorem ipsum details Almería', 'Lorem ipsum observations Almería', '2022-05-17 18:39:27', '2022-05-17 18:39:27', NULL),
(11, 1, 119, 'Cáceres', '20.00', 1, 1, '1', 'Lorem ipsum details Cáceres', 'Lorem ipsum observations Cáceres', '2022-05-17 18:41:13', '2022-05-17 18:41:13', NULL),
(12, 1, 110, 'Badajoz', '20.00', 1, 1, '1', 'Lorem ipsum details Badajoz', 'Lorem ipsum observations Badajoz', '2022-05-17 18:41:13', '2022-05-17 18:41:13', NULL),
(13, 2, 111, 'Murcia', '30.00', 1, 1, '1', 'Lorem ipsum details Murcia', 'Lorem ipsum details Murcia', '2022-05-17 18:43:08', '2022-05-17 18:43:08', NULL),
(14, 2, 112, 'Valencia', '30.00', 1, 1, '1', 'Lorem ipsum details Valencia', 'Lorem ipsum observations Valencia', '2022-05-17 18:43:08', '2022-05-17 18:43:08', NULL),
(15, 2, 113, 'Toledo', '30.00', 1, 1, '1', 'Lorem ipsum details Toledo', 'Lorem ipsum observations Toledo', '2022-05-17 18:44:43', '2022-05-17 18:44:43', NULL),
(16, 2, 114, 'Madrid', '30.00', 1, 1, '1', 'Lorem ipsum details Madrid', 'Lorem ipsum observations Madrid', '2022-05-17 18:44:43', '2022-05-17 18:44:43', NULL),
(17, 2, 115, 'Burgos', '30.00', 1, 1, '1', 'Lorem ipsum details Burgos', 'Lorem ipsum obervations Burgos', '2022-05-17 18:45:37', '2022-05-17 18:45:37', NULL),
(18, 3, 116, 'Salamanca', '40.00', 1, 1, '1', 'Lorem ipsum details Salamanca', 'Lorem ipsum observations Salamanca', '2022-05-17 18:48:20', '2022-05-17 18:48:20', NULL),
(19, 3, 117, 'Santander', '40.00', 1, 1, '1', 'Lorem ipsum details Santander', 'Lorem ipsum observations Santander', '2022-05-17 18:48:20', '2022-05-17 18:48:20', NULL),
(20, 3, 118, 'Zaragoza', '40.00', 1, 1, '1', 'Lorem ipsum details Zaragoza', 'Lorem ipsum observations Zaragoza', '2022-05-17 18:52:34', '2022-05-17 18:52:34', NULL),
(21, 4, 119, 'Fuerteventura', '50.00', 1, 2, '1', 'Lorem ipsum details Fuerteventura', 'Lorem ipsum details Fuerteventura', '2022-05-17 18:52:34', '2022-05-17 18:52:34', NULL),
(22, 4, 120, 'Lanzarote', '50.00', 1, 2, '1', 'Lorem ipsum details Lanzarote', 'Lorem ipsum observations Lanzarote', '2022-05-17 18:53:36', '2022-05-17 18:53:36', NULL),
(23, 4, 121, 'Las palmas', '50.00', 1, 2, '1', 'Lorem ipsum details Las palmas', 'Lorem ipsum observations Las palmas', '2022-05-17 18:54:58', '2022-05-17 18:54:58', NULL),
(24, 4, 122, 'La Gomera', '50.00', 1, 2, '1', 'Lorem ipsum details La Gomera', 'Lorem ipsum observations La Gomera', '2022-05-17 18:54:58', '2022-05-17 18:54:58', NULL),
(25, 4, 123, 'El Hierro', '50.00', 1, 2, '1', 'Lorem ipsum details El Hierro', 'Lorem ipsum obervations El Hierro', '2022-05-17 18:56:34', '2022-05-17 18:56:34', NULL),
(26, 4, 124, 'La Palma', '50.00', 1, 2, '1', 'Lorem ipsum details La Palma', 'Lorem ipsum observations La Palma', '2022-05-17 18:56:34', '2022-05-17 18:56:34', NULL),
(27, 3, 125, 'La Alhambra', '40.00', 1, 1, '1', 'Lorem ipsum details La Alhambra', 'Lorem ipsum observations La Alhambra', '2022-05-17 18:58:42', '2022-05-17 18:58:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE `taxes` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(25) NOT NULL,
  `tax_percent` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `taxes`
--

INSERT INTO `taxes` (`id`, `name`, `tax_percent`) VALUES
(1, 'iva', 21),
(2, 'igic', 7);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`) VALUES
(1, 'javierjive@protonmail.com', '[]', '$2y$13$xIrXPymtykk7JI0ocYJLS.IEPBMWIcAqIAb/OeNa/wBruAYiITZiy');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guest_id` (`currency_id`,`tax_id`,`room_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `FK_7A853C35B2A824D8` (`tax_id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `guests`
--
ALTER TABLE `guests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guests_bookings`
--
ALTER TABLE `guests_bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guest_id` (`guest_id`,`booking_id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `currencies_id` (`currency_id`,`tax_id`),
  ADD KEY `taxes_id` (`tax_id`);

--
-- Indexes for table `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `guests`
--
ALTER TABLE `guests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `guests_bookings`
--
ALTER TABLE `guests_bookings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `FK_7A853C3538248176` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  ADD CONSTRAINT `FK_7A853C35B2A824D8` FOREIGN KEY (`tax_id`) REFERENCES `taxes` (`id`);

--
-- Constraints for table `guests_bookings`
--
ALTER TABLE `guests_bookings`
  ADD CONSTRAINT `guests_bookings_ibfk_1` FOREIGN KEY (`guest_id`) REFERENCES `guests` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `guests_bookings_ibfk_2` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `guests_bookings_ibfk_3` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`tax_id`) REFERENCES `taxes` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `rooms_ibfk_2` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
