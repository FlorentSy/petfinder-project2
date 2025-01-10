-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 10, 2025 at 07:06 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `petfinder`
--

-- --------------------------------------------------------

--
-- Table structure for table `adopted_pets`
--

DROP TABLE IF EXISTS `adopted_pets`;
CREATE TABLE IF NOT EXISTS `adopted_pets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `pet_id` int NOT NULL,
  `adopt_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `pet_id` (`pet_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `adopted_pets`
--

INSERT INTO `adopted_pets` (`id`, `user_id`, `pet_id`, `adopt_date`) VALUES
(1, 33, 26, '2025-01-01 23:27:34'),
(2, 1, 0, '2025-01-02 00:19:13'),
(5, 34, 35, '2025-01-02 00:58:59'),
(12, 37, 33, '2025-01-09 15:41:17'),
(11, 37, 10, '2025-01-09 15:40:21'),
(10, 1, 52, '2025-01-04 16:43:18');

-- --------------------------------------------------------

--
-- Table structure for table `checkouts`
--

DROP TABLE IF EXISTS `checkouts`;
CREATE TABLE IF NOT EXISTS `checkouts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pet_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `adoption_fee` decimal(10,2) NOT NULL,
  `payment_status` varchar(50) NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `pet_id` (`pet_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `checkouts`
--

INSERT INTO `checkouts` (`id`, `pet_id`, `user_id`, `adoption_fee`, `payment_status`, `created_at`) VALUES
(7, 33, 37, 50.00, 'Completed', '2025-01-09 14:41:17'),
(6, 52, 1, 25.00, 'Completed', '2025-01-04 15:43:18');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

DROP TABLE IF EXISTS `login_attempts`;
CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `attempts` int DEFAULT '0',
  `last_attempt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `login_attempts`
--

INSERT INTO `login_attempts` (`id`, `username`, `attempts`, `last_attempt`) VALUES
(3, 'FF', 5, '2025-01-01 21:33:02'),
(7, 'Flore', 3, '2025-01-08 17:31:11'),
(9, 'Flori', 1, '2025-01-08 17:31:34');

-- --------------------------------------------------------

--
-- Table structure for table `pets`
--

DROP TABLE IF EXISTS `pets`;
CREATE TABLE IF NOT EXISTS `pets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `breed` varchar(255) DEFAULT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `age` int DEFAULT NULL,
  `yes_no` enum('yes','no') DEFAULT NULL,
  `health` text NOT NULL,
  `adoption_fee` decimal(10,2) DEFAULT NULL,
  `description` text,
  `image` varchar(255) NOT NULL,
  `category` enum('dog','cat','others') NOT NULL,
  `available` tinyint(1) DEFAULT '1',
  `adoption_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pets`
--

INSERT INTO `pets` (`id`, `name`, `breed`, `gender`, `age`, `yes_no`, `health`, `adoption_fee`, `description`, `image`, `category`, `available`, `adoption_date`) VALUES
(3, 'Queen', 'Cat', 'female', 2, 'yes', 'Health good, vaccination good', 100.00, NULL, 'uploads/677041b13f625.jpg', 'cat', 1, '0000-00-00 00:00:00'),
(47, 'test3', 'test3', 'female', 3, 'yes', 'f', 0.00, NULL, 'uploads/67794a14855c56.46527904.png', 'cat', 0, '0000-00-00 00:00:00'),
(56, 'test', 'Domestic Short Hair', 'female', 2, 'yes', 'Health good, vaccination good', 25.00, NULL, 'uploads/677fdfbc5f5414.28082264.jpg', 'cat', 1, '0000-00-00 00:00:00'),
(21, 'Asha', 'Husky &amp; Akita Mix', 'female', 5, 'yes', 'Vaccinations up to date, spayed / neutered.', 40.00, NULL, 'uploads/677423b182a59.png', 'dog', 1, '0000-00-00 00:00:00'),
(45, 'testpet', 'testpet', 'female', 2, 'yes', 'f', 0.00, NULL, 'uploads/677949889053e2.07295831.png', 'cat', 0, '0000-00-00 00:00:00'),
(23, 'Huxley', 'Beagle Mix', 'male', 1, 'yes', 'Vaccinations up to date, spayed / neutered.', 25.00, NULL, 'uploads/677454fd9b760.jpg', 'dog', 0, '2025-01-02 00:10:48'),
(25, 'Angelina', 'Australian Cattle Dog / Blue Heeler', 'female', 2, 'yes', 'Health good, vaccination good', 40.00, NULL, 'uploads/67745b8e025149.38194763.jpg', 'dog', 1, '0000-00-00 00:00:00'),
(26, 'Apollo', 'Chow Chow', 'female', 1, 'yes', 'Vaccinations up to date, spayed / neutered.', 0.00, NULL, 'uploads/67745c2e1d8ee7.30607385.jpg', 'dog', 0, '2025-01-01 23:33:21'),
(28, 'Lupin', 'Mini Rex Mix', 'male', 2, 'yes', 'Vaccinations up to date, spayed / neutered.', 25.00, NULL, 'uploads/67745d348b5f51.12576417.jpeg', 'others', 0, '2025-01-02 00:28:16'),
(29, 'Sarabi', 'Mini Rex', 'male', 1, 'yes', 'Health good, vaccination good', 0.00, NULL, 'uploads/67745d5f83f9d7.23909650.jpg', 'others', 1, '0000-00-00 00:00:00'),
(30, 'Toutsie', 'Bunny Rabbit', 'female', 3, 'yes', 'Vaccinations up to date, spayed / neutered.', 50.00, NULL, 'uploads/67745d9c5b9978.52286142.jpg', 'others', 0, '0000-00-00 00:00:00'),
(31, 'Tito', 'Domestic Short Hair', 'male', 1, 'yes', 'Vaccinations up to date, spayed / neutered.', 45.00, NULL, 'uploads/6775d30dce9d79.41970589.jpg', 'cat', 0, '0000-00-00 00:00:00'),
(32, 'Marty', 'Domestic Short Hair', 'male', 2, 'no', 'Health good, vaccination good', 0.00, NULL, 'uploads/6775d342580411.68300607.jpg', 'cat', 1, '0000-00-00 00:00:00'),
(33, 'Brix', 'Domestic Short Hair', 'female', 2, 'yes', 'Vaccinations up to date, spayed / neutered.', 50.00, NULL, 'uploads/6775d370a3e878.39133467.jpg', 'cat', 0, '0000-00-00 00:00:00'),
(34, 'Kensi', 'Domestic Short Hair Mix', 'female', 3, 'yes', 'Vaccinations up to date, spayed / neutered.', 0.00, NULL, 'uploads/6775d3929f39e4.51551743.jpg', 'cat', 1, '0000-00-00 00:00:00'),
(35, 'Astro', 'Domestic Short Hair', 'male', 3, 'yes', 'Vaccinations up to date, spayed / neutered.', 25.00, NULL, 'uploads/6775d3eddba529.68110359.jpg', 'cat', 0, '0000-00-00 00:00:00'),
(36, 'Thimblelina', 'Doberman Pinscher', 'female', 3, 'yes', 'Vaccinations up to date, spayed / neutered.', 50.00, NULL, 'uploads/6775d46317bb60.90404996.jpg', 'dog', 1, '0000-00-00 00:00:00'),
(37, 'Mia', 'Border Collie Mix', 'female', 4, 'yes', 'Health good, vaccination good', 25.00, NULL, 'uploads/6775d493993151.44019552.png', 'dog', 1, '0000-00-00 00:00:00'),
(38, 'Huey', 'English Cocker Spaniel', 'male', 2, 'yes', 'Vaccinations up to date, spayed / neutered.', 75.00, NULL, 'uploads/6775d4dab1afa4.48383194.jpeg', 'dog', 1, '0000-00-00 00:00:00'),
(39, 'Stella', 'Australian Shepherd', 'female', 3, 'yes', 'Health good, vaccination good', 0.00, NULL, 'uploads/6775d5086806b4.10930913.jpg', 'dog', 1, '0000-00-00 00:00:00'),
(40, 'Kayla', 'Rabbit Dwarf', 'female', 1, 'yes', 'Vaccinations up to date, spayed / neutered.', 25.00, NULL, 'uploads/6775d55b521e88.48608378.jpg', 'others', 1, '0000-00-00 00:00:00'),
(41, 'Gigi', 'Mini Lop', 'female', 2, 'yes', 'Health good, vaccination good', 0.00, NULL, 'uploads/6775d58cbb7799.79091383.jpeg', 'others', 1, '0000-00-00 00:00:00'),
(42, 'Blue', 'Parakeet (Other)', 'male', 4, 'yes', 'Health good, vaccination good', 75.00, NULL, 'uploads/6775d5fa7a65c7.42415066.jpg', 'others', 1, '0000-00-00 00:00:00'),
(43, 'Autumn', 'Cockatiel', 'female', 2, 'yes', 'Vaccinations up to date, spayed / neutered.', 50.00, NULL, 'uploads/6775d62e1d6241.91929704.jpg', 'others', 1, '0000-00-00 00:00:00'),
(44, 'Charlie', 'Conure', 'male', 2, 'yes', 'Vaccinations up to date, spayed / neutered.', 0.00, NULL, 'uploads/6775d64a231a90.01994360.jpg', 'others', 1, '0000-00-00 00:00:00'),
(51, 'ttt', 'ttt', 'male', 3, 'yes', 'f', 40.00, NULL, 'uploads/67794e88af93c1.17871442.png', 'cat', 0, '0000-00-00 00:00:00'),
(52, 'Aji', 'Rabbit Dwarf', 'male', 3, 'yes', 'Vaccinations up to date, spayed / neutered.', 25.00, NULL, 'uploads/677956ff02dd16.68225500.jpg', 'others', 0, '0000-00-00 00:00:00'),
(53, 'Tinki', 'Domestic Short Hair', 'female', 3, 'yes', 'Health good, vaccination good', 75.00, NULL, 'uploads/677959dcc59822.97443817.jpg', 'cat', 1, '0000-00-00 00:00:00'),
(54, 'Sandy', 'German Shepherd Dog', 'female', 4, 'yes', 'Vaccinations up to date, spayed / neutered.', 25.00, NULL, 'uploads/677eae66919d70.16651592.jpg', 'dog', 1, '0000-00-00 00:00:00'),
(55, 'Frida', 'Bunny Rabbit', 'female', 1, 'yes', 'Health good, vaccination good', 25.00, NULL, 'uploads/677eb735132917.87756011.jpg', 'others', 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `is_admin` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `username` (`username`(250))
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `username`, `email`, `password`, `created_at`, `is_admin`) VALUES
(1, 'florent', 'florent', 'florent', 'florent@ds.com', '$2y$10$dLJKFFtyIUqct8ljfUO1.ebmEOQut0JHdzNgJ/tliLiN876hzk7Iy', '2024-12-28 19:31:27.087740', 1),
(17, 'ff', 'ff', 'ff', 'ff@gmail.com', '$2y$10$mKJAkXbVntox.lavyqUKhe0SMt2C//HRRFth9lxEI4p/nxvyzL9aO', '2024-12-31 21:24:11.339984', 1),
(22, 'Florent', 'Florent', 'Florent', 'florent@ds.com', '$2y$10$1.D4e3.D6DR9dCkiYtwX7e0/uyM7bb2vUEjVgPcnd4bvdw2XJQOQ6', '2025-01-01 12:04:20.096595', 0),
(36, 'Flori', 'Flori', 'Flori', 'flori@gmail.com', '$2y$10$xDtB4OVXC1cDUtA22b2cjedvOa.YysGKmXAoX.dPNNzqROuSgd2fG', '2025-01-05 12:19:41.244628', 0),
(37, 'FS', 'FS', 'FS', 'fs@gmail.com', '$2y$10$.konbwGNl4GdL9N5BTrU6.R80GdOVYdM4BAl6WUH5dQ/8rBBEXJeG', '2025-01-08 17:31:59.903163', 0),
(34, 'Flor1', 'Flor1', 'Flor1', 'florent@ds.com', '$2y$10$0ys/2rgyJaLvxs3237K6KuAoUtAP6G.q7dzjphMvNHeOjO9v4p/JK', '2025-01-01 23:41:12.655706', 0),
(33, 'Flore', 'Flore', 'Flore', 'Flore@gmail.com', '$2y$10$2xH7Sn.WtTjx5dwJP1TkC..IQK/peFAVOMDUiEgTeltaFFhYjhoyC', '2025-01-01 21:58:06.739269', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
