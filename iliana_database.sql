-- phpMyAdmin SQL Dump
-- version 4.6.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 20, 2016 at 06:45 PM
-- Server version: 5.5.52-log
-- PHP Version: 5.6.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iliana_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `addressesili`
--

CREATE TABLE `addressesili` (
  `address_id` int(11) NOT NULL,
  `usr_id` int(11) NOT NULL,
  `address` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `num` int(11) DEFAULT NULL,
  `postcode` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Table structure for table `eventsili`
--

CREATE TABLE `eventsili` (
  `id` int(11) NOT NULL,
  `title` varchar(30) COLLATE utf8_bin NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime DEFAULT NULL,
  `allDay` varchar(30) COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `creator_id` int(11) NOT NULL,
  `cust_id` int(11) NOT NULL,
  `reminder` date DEFAULT NULL,
  `reminder_seen` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Table structure for table `notesili`
--

CREATE TABLE `notesili` (
  `note_id` int(11) NOT NULL,
  `possession_id` int(11) NOT NULL,
  `note` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `phonesili`
--

CREATE TABLE `phonesili` (
  `phone_id` int(11) NOT NULL,
  `number` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `usr_id` int(11) NOT NULL,
  `type` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `phonesili`
--

INSERT INTO `phonesili` (`phone_id`, `number`, `usr_id`, `type`) VALUES
(1, '', 1, 'Σταθερό');

-- --------------------------------------------------------

--
-- Table structure for table `photosili`
--

CREATE TABLE `photosili` (
  `photo_id` int(11) NOT NULL,
  `tnk_id` int(11) NOT NULL,
  `hash` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Table structure for table `possessionili`
--

CREATE TABLE `possessionili` (
  `pos_id` int(11) NOT NULL,
  `tank_id` int(11) NOT NULL,
  `cust_id` int(11) NOT NULL,
  `installation_date` date DEFAULT NULL,
  `certificate_expire_date` date DEFAULT NULL,
  `notification_seen` int(1) NOT NULL,
  `tech_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `tanksili`
--

CREATE TABLE `tanksili` (
  `id` int(11) NOT NULL,
  `model` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `fuel` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `placement` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `manufacturer` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `heating` double NOT NULL,
  `hotwater` double DEFAULT NULL,
  `maximum_input` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `power_supply` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dimensions` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `chimney_in` int(11) DEFAULT NULL,
  `chimney_out` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Table structure for table `usersili`
--

CREATE TABLE `usersili` (
  `user_id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('customer','technician','super') COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(70) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `afm` varchar(9) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hash` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `usersili`
--

INSERT INTO `usersili` (`user_id`, `name`, `surname`, `type`, `username`, `password`, `email`, `afm`, `hash`, `active`) VALUES
(1, 'Admin', 'Admin', 'super', 'admin', '$2y$10$3tQCKHAQXl8pgnQyAKwNc.4clHHmxGl98x1l3TIP8cNUuFg2dM.E2', 'admin@admin.com', NULL, '', 1);
--
-- Indexes for dumped tables
--

--
-- Indexes for table `addressesili`
--
ALTER TABLE `addressesili`
  ADD UNIQUE KEY `address_id` (`address_id`),
  ADD KEY `usr_id` (`usr_id`);

--
-- Indexes for table `eventsili`
--
ALTER TABLE `eventsili`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creator_id` (`creator_id`),
  ADD KEY `cust_id` (`cust_id`);

--
-- Indexes for table `notesili`
--
ALTER TABLE `notesili`
  ADD PRIMARY KEY (`note_id`),
  ADD KEY `possession_id` (`possession_id`);

--
-- Indexes for table `phonesili`
--
ALTER TABLE `phonesili`
  ADD UNIQUE KEY `phone_id` (`phone_id`),
  ADD KEY `user_id` (`usr_id`);

--
-- Indexes for table `photosili`
--
ALTER TABLE `photosili`
  ADD PRIMARY KEY (`photo_id`),
  ADD KEY `tnk_id` (`tnk_id`);

--
-- Indexes for table `possessionili`
--
ALTER TABLE `possessionili`
  ADD PRIMARY KEY (`pos_id`),
  ADD KEY `tank_id` (`tank_id`),
  ADD KEY `cust_id` (`cust_id`);

--
-- Indexes for table `tanksili`
--
ALTER TABLE `tanksili`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `model` (`model`);

--
-- Indexes for table `usersili`
--
ALTER TABLE `usersili`
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `afm` (`afm`),
  ADD KEY `user_id_2` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addressesili`
--
ALTER TABLE `addressesili`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `eventsili`
--
ALTER TABLE `eventsili`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;
--
-- AUTO_INCREMENT for table `notesili`
--
ALTER TABLE `notesili`
  MODIFY `note_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `phonesili`
--
ALTER TABLE `phonesili`
  MODIFY `phone_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;
--
-- AUTO_INCREMENT for table `photosili`
--
ALTER TABLE `photosili`
  MODIFY `photo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT for table `possessionili`
--
ALTER TABLE `possessionili`
  MODIFY `pos_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `tanksili`
--
ALTER TABLE `tanksili`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `usersili`
--
ALTER TABLE `usersili`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `addressesili`
--
ALTER TABLE `addressesili`
  ADD CONSTRAINT `addressesili_ibfk_1` FOREIGN KEY (`usr_id`) REFERENCES `usersili` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `eventsili`
--
ALTER TABLE `eventsili`
  ADD CONSTRAINT `eventsili_ibfk_1` FOREIGN KEY (`creator_id`) REFERENCES `usersili` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `eventsili_ibfk_2` FOREIGN KEY (`cust_id`) REFERENCES `usersili` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notesili`
--
ALTER TABLE `notesili`
  ADD CONSTRAINT `notesili_ibfk_1` FOREIGN KEY (`possession_id`) REFERENCES `possessionili` (`pos_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `phonesili`
--
ALTER TABLE `phonesili`
  ADD CONSTRAINT `phonesili_ibfk_1` FOREIGN KEY (`usr_id`) REFERENCES `usersili` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `photosili`
--
ALTER TABLE `photosili`
  ADD CONSTRAINT `photosili_ibfk_1` FOREIGN KEY (`tnk_id`) REFERENCES `tanksili` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `possessionili`
--
ALTER TABLE `possessionili`
  ADD CONSTRAINT `possessionili_ibfk_1` FOREIGN KEY (`tank_id`) REFERENCES `tanksili` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `possessionili_ibfk_2` FOREIGN KEY (`cust_id`) REFERENCES `usersili` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
