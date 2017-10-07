-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2017 at 10:25 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ics499`
--

-- --------------------------------------------------------

--
-- Table structure for table `garage_sales`
--

CREATE TABLE `garage_sales` (
  `gsale_id` int(22) NOT NULL,
  `image_url` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(1500) COLLATE utf8_unicode_ci NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `places_fk_id` int(22) NOT NULL,
  `user_fk_id` int(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `garage_sales_items`
--

CREATE TABLE `garage_sales_items` (
  `gsale_fk_id` int(22) NOT NULL,
  `item_fk_id` int(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(22) NOT NULL,
  `price` float NOT NULL,
  `description` varchar(1500) COLLATE utf8_unicode_ci NOT NULL,
  `image_url` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `is_sold` tinyint(1) NOT NULL,
  `keywords` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `attempt_id` int(3) NOT NULL,
  `attempt_success` tinyint(1) NOT NULL,
  `session_id` varchar(128) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `looking`
--

CREATE TABLE `looking` (
  `user_fk_id` int(22) NOT NULL,
  `item_fk_id` int(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `places`
--

CREATE TABLE `places` (
  `place_id` int(22) NOT NULL,
  `address` varchar(95) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  `zip_code` int(11) NOT NULL,
  `country` varchar(3) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(22) NOT NULL,
  `username` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `fname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `phone_number` int(12) NOT NULL,
  `places_fk_id` int(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `garage_sales`
--
ALTER TABLE `garage_sales`
  ADD PRIMARY KEY (`gsale_id`),
  ADD KEY `user_fk_id` (`user_fk_id`),
  ADD KEY `garage_sales_ibfk_1` (`places_fk_id`);

--
-- Indexes for table `garage_sales_items`
--
ALTER TABLE `garage_sales_items`
  ADD KEY `garage_sales_items_ibfk_1` (`gsale_fk_id`),
  ADD KEY `garage_sales_items_ibfk_2` (`item_fk_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`attempt_id`);

--
-- Indexes for table `looking`
--
ALTER TABLE `looking`
  ADD KEY `looking_ibfk_1` (`user_fk_id`),
  ADD KEY `looking_ibfk_2` (`item_fk_id`);

--
-- Indexes for table `places`
--
ALTER TABLE `places`
  ADD PRIMARY KEY (`place_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `places_fk_id` (`places_fk_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `garage_sales`
--
ALTER TABLE `garage_sales`
  MODIFY `gsale_id` int(22) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(22) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `attempt_id` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `places`
--
ALTER TABLE `places`
  MODIFY `place_id` int(22) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(22) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `garage_sales`
--
ALTER TABLE `garage_sales`
  ADD CONSTRAINT `garage_sales_ibfk_1` FOREIGN KEY (`places_fk_id`) REFERENCES `places` (`place_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `garage_sales_ibfk_2` FOREIGN KEY (`user_fk_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `garage_sales_items`
--
ALTER TABLE `garage_sales_items`
  ADD CONSTRAINT `garage_sales_items_ibfk_1` FOREIGN KEY (`gsale_fk_id`) REFERENCES `garage_sales` (`gsale_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `garage_sales_items_ibfk_2` FOREIGN KEY (`item_fk_id`) REFERENCES `items` (`item_id`) ON UPDATE CASCADE;

--
-- Constraints for table `looking`
--
ALTER TABLE `looking`
  ADD CONSTRAINT `looking_ibfk_1` FOREIGN KEY (`user_fk_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `looking_ibfk_2` FOREIGN KEY (`item_fk_id`) REFERENCES `items` (`item_id`) ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`places_fk_id`) REFERENCES `places` (`place_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
