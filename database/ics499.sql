-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2017 at 11:28 PM
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
(1, 'First Test', '../uploads/76afface4080c9c8e905619aca932875.jpg', 'This is a description for our first sale. It does not contain any useful information so I don\'t know why you are still reading this.', '13:00-15:00-2017/12/12,13:00-15:00-2017/12/13'),
(3, '2nd sale', '../uploads/62e50867dfe9e8f696edf5f6f19e8d88.png', 'This is a second sale for our db', '13:00-15:00-2017/12/12'),
(4, '3rd Sale', 'https://dummyimage.com/200x200/333/fff.png&text=No', 'We have some baby clothes along with some old vhs tapes.', '10:00-17:00-2017/12/30'),
(5, '5 Sale', '../uploads/4d9b2b7e3e93f4e972e19797f71879c9.jpg', 'Some sample text to fill space', '10:00-15:00-2017/12/05'),
(6, '6th sale', '../uploads/784d5ed8494895965d9d7f851ce9d952.jpg', 'Some text for the 6th sale', '10:00-15:00-2017/12/05');

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
(1, 3);

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
(1, 2),
(3, 1),
(4, 3),
(5, 4),
(6, 5);

-- --------------------------------------------------------

--
-- Table structure for table `garage_sales_places`
--

CREATE TABLE `garage_sales_places` (
  `garage_sale_fk_id` int(22) NOT NULL,
  `place_fk_id` int(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `garage_sales_places`
--

INSERT INTO `garage_sales_places` (`garage_sale_fk_id`, `place_fk_id`) VALUES
(1, 6),
(3, 12),
(4, 16),
(5, 17),
(6, 18);

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
(1, 1),
(1, 3),
(1, 4),
(1, 5),
(1, 6);

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
  `image_url` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `is_sold` tinyint(1) NOT NULL COMMENT '1 if item is sold, else 0',
  `keywords` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `price`, `description`, `image_url`, `is_sold`, `keywords`) VALUES
(3, 120, 'The lightning-fast AMD Ryzen 7 processor is the superior choice. With AMD SenseMI technology, Ryzen processors use true machine intelligence to accelerate performance. All Ryzen 7 processors feature 8 cores with 16 threads for the most ambitious competitors, helping you game and stream at the same time with performance to spare.', '../uploads/63f6901cec179ba232a67ff5532f88b9.jpg', 0, 'electronic,all'),
(4, 50, 'wd hard drive disk', '../uploads/0bda54c1816b41b9c72f4d32bf14ba8a.jpg', 0, 'electronic, all'),
(5, 50, 'speakers that make sound', '../uploads/239435d356f1ac51f516cfe90849d8ce.jpg', 0, 'media, all');

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
(1, '(651)-681-0684'),
(2, '(651)-303-9242'),
(3, '(651)-472-3486'),
(4, '(651)-472-3486'),
(5, '(651)-303-9243');

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
(12, '2016', 'Zircon Ln', 'Eagan', 'MN', '55122', 'US', '44.8053538', '-93.2095611'),
(16, '2018', 'Zircon Ln', 'Eagan', 'MN', '55122', 'US', '44.8055751', '-93.2097063'),
(17, '2090', 'Diffley Rd', 'Eagan', 'MN', '55122', 'US', '44.8044357', '-93.2142744'),
(18, '10750', 'McCool Dr E', 'Burnsville', 'MN', '55337', 'US', '44.8094301', '-93.228979');

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
(3, 'dd0517tz', '$2y$10$WaTGBmAXOjJ/3tc4S//Wu.I7bswVXvgyX5Z40/xih.wWcfgHi89GC', 'yeshewa', 'berhane', 'dd0517tz@metrostate.edu'),
(4, 'Jumperv3', '$2y$10$0eCKASDIqDdi6LX/Q8RhfO5sMITRD6QO1aHlZCgNTS9NO8WgYq3v2', 'gary', 'webb', '4gwebb@gmail.com');

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
  MODIFY `gsale_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoice_id` int(22) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `phones`
--
ALTER TABLE `phones`
  MODIFY `phone_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `places`
--
ALTER TABLE `places`
  MODIFY `place_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `garage_sales_items`
--
ALTER TABLE `garage_sales_items`
  ADD CONSTRAINT `garage_sales_items_ibfk_1` FOREIGN KEY (`gsale_fk_id`) REFERENCES `garage_sales` (`gsale_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `garage_sales_items_ibfk_2` FOREIGN KEY (`item_fk_id`) REFERENCES `items` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `garage_sales_phones`
--
ALTER TABLE `garage_sales_phones`
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
