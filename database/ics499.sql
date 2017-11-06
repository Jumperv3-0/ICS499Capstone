-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2017 at 06:44 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

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
  `sale_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `image_url` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(1500) COLLATE utf8_unicode_ci NOT NULL,
  `dates` varchar(128) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `garage_sales`
--

INSERT INTO `garage_sales` (`gsale_id`, `sale_name`, `image_url`, `description`, `dates`) VALUES
(1, 'First Test', 'first_sale.png', 'This is our first test of a garage sale. It is not a real one but a fake one. Why are you still reading this text its pointless. Did you want some useful information lol, look elsewhere.', '10:00-15:00-11/4/2017,10:00-15:30-11/5/2017'),
(3, '2nd sale', '../uploads/62e50867dfe9e8f696edf5f6f19e8d88.png', 'This is a second sale for our db', '13:00-15:00-2017-11-06,');

-- --------------------------------------------------------

--
-- Table structure for table `garage_sales_items`
--

CREATE TABLE `garage_sales_items` (
  `gsale_fk_id` int(22) NOT NULL,
  `item_fk_id` int(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `garage_sales_items`
--

INSERT INTO `garage_sales_items` (`gsale_fk_id`, `item_fk_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `garage_sales_phones`
--

CREATE TABLE `garage_sales_phones` (
  `garage_sale_fk_id` int(22) NOT NULL,
  `phone_fk_id` int(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `garage_sales_phones`
--

INSERT INTO `garage_sales_phones` (`garage_sale_fk_id`, `phone_fk_id`) VALUES
(1, 1),
(1, 1),
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `garage_sales_places`
--

CREATE TABLE `garage_sales_places` (
  `garage_sale_fk_id` int(22) NOT NULL,
  `place_fk_id` int(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `garage_sales_users`
--

CREATE TABLE `garage_sales_users` (
  `user_fk_id` int(22) NOT NULL,
  `garage_sales_fk_id` int(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `garage_sales_users`
--

INSERT INTO `garage_sales_users` (`user_fk_id`, `garage_sales_fk_id`) VALUES
(1, 1);

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
-- Table structure for table `looking`
--

CREATE TABLE `looking` (
  `user_fk_id` int(22) NOT NULL COMMENT 'user that is looking for an item',
  `item_fk_id` int(22) NOT NULL COMMENT 'item that matches users parameters'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_saver`
--

CREATE TABLE `password_saver` (
  `session_id` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'date and time of login attempt',
  `user_fk_id` int(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `password_saver`
--

INSERT INTO `password_saver` (`session_id`, `time_stamp`, `user_fk_id`) VALUES
('ac77ce5c25df91ea9b2b32bfe085f568cd5475c99ab280238f3c91c44f32e8b5', '2017-11-04 09:02:40', 1);

-- --------------------------------------------------------

--
-- Table structure for table `phones`
--

CREATE TABLE `phones` (
  `phone_id` int(22) NOT NULL,
  `phone_number` varchar(16) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `phones`
--

INSERT INTO `phones` (`phone_id`, `phone_number`) VALUES
(1, '(651)-681-0684');

-- --------------------------------------------------------

--
-- Table structure for table `places`
--

CREATE TABLE `places` (
  `place_id` int(22) NOT NULL,
  `street_number` varchar(22) COLLATE utf8_unicode_ci NOT NULL,
  `route` varchar(95) COLLATE utf8_unicode_ci NOT NULL,
  `locality` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  `administrative_area_level_1` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `postal_code` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `lat` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `lng` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `places`
--

INSERT INTO `places` (`place_id`, `street_number`, `route`, `locality`, `administrative_area_level_1`, `postal_code`, `country`, `lat`, `lng`) VALUES
(6, '2016', 'Burnsville Center', 'Burnsville', 'MN', '55306', 'US', '44.7426029', '-93.2889313'),
(12, '2016', 'Zircon Ln', 'Eagan', 'MN', '55122', 'US', '44.8053538', '-93.2095611');

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
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `fname`, `lname`, `email`) VALUES
(1, 'id4766wa', '$2y$10$3Sk7watLoZ.KPxZIf3kwUOyVA/MUy4f8M9vq7k5ciSppgFI3ETJmO', 'gary', 'webb', 'id4766wa@metrostate.edu'),
(2, 'yn0619nj', '$2y$10$dvRizOKMZ9o0PjkX7qODIOSWr2CiKDgPRnXFImeritw8oE3cJslua', 'david', 'gruenberg', 'yn0619nj@metrostate.edu'),
(3, 'dd0517tz', '$2y$10$WaTGBmAXOjJ/3tc4S//Wu.I7bswVXvgyX5Z40/xih.wWcfgHi89GC', 'yeshewa', 'berhane', 'dd0517tz@metrostate.edu');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `garage_sales`
--
ALTER TABLE `garage_sales`
  ADD PRIMARY KEY (`gsale_id`);

--
-- Indexes for table `garage_sales_items`
--
ALTER TABLE `garage_sales_items`
  ADD KEY `garage_sales_items_ibfk_1` (`gsale_fk_id`),
  ADD KEY `garage_sales_items_ibfk_2` (`item_fk_id`);

--
-- Indexes for table `garage_sales_phones`
--
ALTER TABLE `garage_sales_phones`
  ADD KEY `phone_fk_id` (`phone_fk_id`),
  ADD KEY `garage_sale_fk_id` (`garage_sale_fk_id`);

--
-- Indexes for table `garage_sales_places`
--
ALTER TABLE `garage_sales_places`
  ADD UNIQUE KEY `garage_sale_fk_id` (`garage_sale_fk_id`),
  ADD KEY `place_fk_id` (`place_fk_id`);

--
-- Indexes for table `garage_sales_users`
--
ALTER TABLE `garage_sales_users`
  ADD KEY `garage_sales_users_ibfk_1` (`garage_sales_fk_id`),
  ADD KEY `user_fk_id` (`user_fk_id`);

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
-- Indexes for table `looking`
--
ALTER TABLE `looking`
  ADD KEY `looking_ibfk_1` (`user_fk_id`),
  ADD KEY `looking_ibfk_2` (`item_fk_id`);

--
-- Indexes for table `password_saver`
--
ALTER TABLE `password_saver`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `login_attempts_ibfk_1` (`user_fk_id`);

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
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `garage_sales`
--
ALTER TABLE `garage_sales`
  MODIFY `gsale_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
-- AUTO_INCREMENT for table `places`
--
ALTER TABLE `places`
  MODIFY `place_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `garage_sales_items`
--
ALTER TABLE `garage_sales_items`
  ADD CONSTRAINT `garage_sales_items_ibfk_1` FOREIGN KEY (`gsale_fk_id`) REFERENCES `garage_sales` (`gsale_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `garage_sales_items_ibfk_2` FOREIGN KEY (`item_fk_id`) REFERENCES `items` (`item_id`) ON UPDATE CASCADE;

--
-- Constraints for table `garage_sales_phones`
--
ALTER TABLE `garage_sales_phones`
  ADD CONSTRAINT `garage_sales_phones_ibfk_1` FOREIGN KEY (`phone_fk_id`) REFERENCES `phones` (`phone_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `garage_sales_phones_ibfk_2` FOREIGN KEY (`garage_sale_fk_id`) REFERENCES `garage_sales` (`gsale_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `garage_sales_places`
--
ALTER TABLE `garage_sales_places`
  ADD CONSTRAINT `garage_sales_places_ibfk_1` FOREIGN KEY (`garage_sale_fk_id`) REFERENCES `garage_sales` (`gsale_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `garage_sales_places_ibfk_2` FOREIGN KEY (`place_fk_id`) REFERENCES `places` (`place_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `garage_sales_users`
--
ALTER TABLE `garage_sales_users`
  ADD CONSTRAINT `garage_sales_users_ibfk_1` FOREIGN KEY (`garage_sales_fk_id`) REFERENCES `garage_sales` (`gsale_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `garage_sales_users_ibfk_2` FOREIGN KEY (`user_fk_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
