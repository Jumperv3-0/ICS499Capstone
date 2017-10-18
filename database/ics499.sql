-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 18, 2017 at 08:01 AM
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

DROP TABLE IF EXISTS `garage_sales`;
CREATE TABLE `garage_sales` (
  `gsale_id` int(22) NOT NULL,
  `sale_name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `image_url` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(1500) COLLATE utf8_unicode_ci NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `places_fk_id` int(22) NOT NULL,
  `user_fk_id` int(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `garage_sales`
--

INSERT INTO `garage_sales` (`gsale_id`, `sale_name`, `image_url`, `description`, `start_date`, `end_date`, `places_fk_id`, `user_fk_id`) VALUES
(1, 'First Sale', 'first_sale.png', 'This is our first sale where we would want to sell stuff at.', '2017-10-19 05:12:13', '2017-10-21 14:36:00', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `garage_sales_items`
--

DROP TABLE IF EXISTS `garage_sales_items`;
CREATE TABLE `garage_sales_items` (
  `gsale_fk_id` int(22) NOT NULL,
  `item_fk_id` int(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

DROP TABLE IF EXISTS `invoice`;
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

DROP TABLE IF EXISTS `items`;
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

DROP TABLE IF EXISTS `login_attempts`;
CREATE TABLE `login_attempts` (
  `attempt_id` int(3) NOT NULL,
  `attempt_success` tinyint(1) NOT NULL COMMENT '1 if login was success, else 0',
  `session_id` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'date and time of login attempt',
  `user_fk_id` int(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `login_attempts`
--

INSERT INTO `login_attempts` (`attempt_id`, `attempt_success`, `session_id`, `time_stamp`, `user_fk_id`) VALUES
(1, 1, '33a5d0d9a82786b1ae15591ea35bfe26c39254e9b2faaae42b6fb7ad4aba0ede', '2017-10-17 23:35:32', 1);

-- --------------------------------------------------------

--
-- Table structure for table `looking`
--

DROP TABLE IF EXISTS `looking`;
CREATE TABLE `looking` (
  `user_fk_id` int(22) NOT NULL COMMENT 'user that is looking for an item',
  `item_fk_id` int(22) NOT NULL COMMENT 'item that matches users parameters'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `phones`
--

DROP TABLE IF EXISTS `phones`;
CREATE TABLE `phones` (
  `phone_id` int(22) NOT NULL,
  `phone_number` varchar(16) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `phones`
--

INSERT INTO `phones` (`phone_id`, `phone_number`) VALUES
(1, '651-793-1300');

-- --------------------------------------------------------

--
-- Table structure for table `places`
--

DROP TABLE IF EXISTS `places`;
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

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(22) NOT NULL,
  `username` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `fname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `fname`, `lname`, `email`) VALUES
(1, 'id4766wa', '$2y$10$3Sk7watLoZ.KPxZIf3kwUOyVA/MUy4f8M9vq7k5ciSppgFI3ETJmO', 'gary', 'webb', 'id4766wa@metrostate.edu'),
(2, 'yn0619nj', '$2y$10$dvRizOKMZ9o0PjkX7qODIOSWr2CiKDgPRnXFImeritw8oE3cJslua', 'david', 'gruenberg', 'yn0619nj@metrostate.edu'),
(3, 'dd0517tz', '$2y$10$WaTGBmAXOjJ/3tc4S//Wu.I7bswVXvgyX5Z40/xih.wWcfgHi89GC', 'yeshewa', 'berhane', 'dd0517tz@metrostate.edu'),
(4, 'Jumperv3', '$2y$10$6TJJd59Fv3CyYo.secbNMu4/cow88wHvRDgn/bAPOnByW2SoD2./i', 'gary', 'webb', 'id4766wa@metrostate.edu');

-- --------------------------------------------------------

--
-- Table structure for table `users_phones`
--

DROP TABLE IF EXISTS `users_phones`;
CREATE TABLE `users_phones` (
  `users_fk_id` int(22) NOT NULL,
  `phones_fk_id` int(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users_phones`
--

INSERT INTO `users_phones` (`users_fk_id`, `phones_fk_id`) VALUES
(1, 1),
(2, 1),
(3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users_places`
--

DROP TABLE IF EXISTS `users_places`;
CREATE TABLE `users_places` (
  `user_fk_id` int(22) NOT NULL,
  `places_fk_id` int(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users_places`
--

INSERT INTO `users_places` (`user_fk_id`, `places_fk_id`) VALUES
(1, 1),
(3, 2),
(2, 1);

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
  ADD PRIMARY KEY (`attempt_id`),
  ADD KEY `login_attempts_ibfk_1` (`user_fk_id`);

--
-- Indexes for table `looking`
--
ALTER TABLE `looking`
  ADD KEY `looking_ibfk_1` (`user_fk_id`),
  ADD KEY `looking_ibfk_2` (`item_fk_id`);

--
-- Indexes for table `phones`
--
ALTER TABLE `phones`
  ADD PRIMARY KEY (`phone_id`);

--
-- Indexes for table `places`
--
ALTER TABLE `places`
  ADD PRIMARY KEY (`place_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `users_phones`
--
ALTER TABLE `users_phones`
  ADD KEY `users_phones_ibfk_1` (`users_fk_id`),
  ADD KEY `phones_fk_id` (`phones_fk_id`);

--
-- Indexes for table `users_places`
--
ALTER TABLE `users_places`
  ADD KEY `user_fk_id` (`user_fk_id`),
  ADD KEY `places_fk_id` (`places_fk_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `garage_sales`
--
ALTER TABLE `garage_sales`
  MODIFY `gsale_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
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
  MODIFY `attempt_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `phones`
--
ALTER TABLE `phones`
  MODIFY `phone_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `places`
--
ALTER TABLE `places`
  MODIFY `place_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
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
-- Constraints for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD CONSTRAINT `login_attempts_ibfk_1` FOREIGN KEY (`user_fk_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `looking`
--
ALTER TABLE `looking`
  ADD CONSTRAINT `looking_ibfk_1` FOREIGN KEY (`user_fk_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `looking_ibfk_2` FOREIGN KEY (`item_fk_id`) REFERENCES `items` (`item_id`) ON UPDATE CASCADE;

--
-- Constraints for table `users_phones`
--
ALTER TABLE `users_phones`
  ADD CONSTRAINT `users_phones_ibfk_1` FOREIGN KEY (`users_fk_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_phones_ibfk_2` FOREIGN KEY (`phones_fk_id`) REFERENCES `phones` (`phone_id`);

--
-- Constraints for table `users_places`
--
ALTER TABLE `users_places`
  ADD CONSTRAINT `users_places_ibfk_1` FOREIGN KEY (`user_fk_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `users_places_ibfk_2` FOREIGN KEY (`places_fk_id`) REFERENCES `places` (`place_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
