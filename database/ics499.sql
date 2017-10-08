-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 08, 2017 at 10:03 AM
-- Server version: 5.7.10-log
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoice_id` int(22) NOT NULL,
  `price` float NOT NULL,
  `description` varchar(1500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'optional description of item sold',
  `time_sold` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'date of the transaction',
  `sold_by` int(22) NOT NULL COMMENT 'Who sold the item',
  `gsale_fk_id` int(22) NOT NULL COMMENT 'garage sale the transaction took place at',
  `user_fk_id` int(22) NOT NULL COMMENT 'Person who owned the item that gets the money from sale'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(22) NOT NULL,
  `price` float NOT NULL,
  `description` varchar(1500) COLLATE utf8_unicode_ci NOT NULL,
  `image_url` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `is_sold` tinyint(1) NOT NULL COMMENT '1 if item is sold, else 0',
  `keywords` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `price`, `description`, `image_url`, `is_sold`, `keywords`) VALUES
(1, 54.88, 'This Acoustic Audio by Goldwood 2.1 speaker system Features a contemporary design, Bluetooth, Blue LED subwoofer and satellite lights and is a stylish addition to any home. This 3-piece system includes one powered subwoofer and two satellite speakers as well as instructions needed to \"plug and play\". use it for your personal computer or laptop, DVD player, TV, gaming system, MP3 player or other devices with RCA audio outputs (3.5mm to RCA cable included). the powered subwoofer Features a side-firing woofer and utilizes a digitally tuned wooden enclosure for increased bass response. The full-range satellite speakers feature magnetic shielding for use near Televisions and computer monitors.', '../img/51mg+MauKYL._SL1000_.jpg', 0, 'audio, music'),
(2, 44.99, 'WD hard drives deliver solid performance and reliability while providing you with all the space you need to hold an enormous amount of photos, videos and files. These drives are designed for use as primary drives in desktops PCs, notebooks and external enclosures, and for certain industrial applications.', '../img/415198_622456_01_front_zoom.jpg', 0, 'electronic(other), gaming');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `attempt_id` int(3) NOT NULL,
  `attempt_success` tinyint(1) NOT NULL COMMENT '1 if login was success, else 0',
  `session_id` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'date and time of login attempt'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `looking`
--

CREATE TABLE `looking` (
  `user_fk_id` int(22) NOT NULL COMMENT 'user that is looking for an item',
  `item_fk_id` int(22) NOT NULL COMMENT 'item that matches users parameters'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `places`
--

CREATE TABLE `places` (
  `place_id` int(22) NOT NULL,
  `address` varchar(95) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `zip_code` int(11) NOT NULL,
  `country` varchar(3) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `places`
--

INSERT INTO `places` (`place_id`, `address`, `city`, `state`, `zip_code`, `country`) VALUES
(1, 'Saint Paul Campus 700 7th Street East', 'Saint Paul', 'MN', 55106, 'US'),
(2, 'Midway Center 1450 Energy Park Drive', 'Saint Paul', 'MN', 55108, 'US');

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
  `phone_number` bigint(12) NOT NULL,
  `places_fk_id` int(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `fname`, `lname`, `email`, `phone_number`, `places_fk_id`) VALUES
(1, 'id4766wa', '$2y$10$3Sk7watLoZ.KPxZIf3kwUOyVA/MUy4f8M9vq7k5ciSppgFI3ETJmO', 'gary', 'webb', 'id4766wa@metrostate.edu', 6517931300, 1),
(2, 'yn0619nj', '$2y$10$dvRizOKMZ9o0PjkX7qODIOSWr2CiKDgPRnXFImeritw8oE3cJslua', 'david', 'gruenberg', 'yn0619nj@metrostate.edu', 6517931300, 2),
(3, 'dd0517tz', '$2y$10$WaTGBmAXOjJ/3tc4S//Wu.I7bswVXvgyX5Z40/xih.wWcfgHi89GC', 'yeshewa', 'berhane', 'dd0517tz@metrostate.edu', 6517931300, 1);

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
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoice_id`),
  ADD KEY `gsale_fk_id` (`gsale_fk_id`),
  ADD KEY `user_fk_id` (`user_fk_id`),
  ADD KEY `sold_by` (`sold_by`);

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
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoice_id` int(22) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `attempt_id` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `places`
--
ALTER TABLE `places`
  MODIFY `place_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
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
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`gsale_fk_id`) REFERENCES `garage_sales` (`gsale_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `invoice_ibfk_2` FOREIGN KEY (`user_fk_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `invoice_ibfk_3` FOREIGN KEY (`sold_by`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
