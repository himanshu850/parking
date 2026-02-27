-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2019 at 03:59 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `parking`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `ID` int(10) NOT NULL,
  `useri` int(10) NOT NULL,
  `usern` varchar(255) NOT NULL,
  `slot` int(10) NOT NULL,
  `start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`ID`, `useri`, `usern`, `slot`, `start`) VALUES
(1, 26, 'himanshu', 1, '2019-11-26 09:34:43'),
(6, 31, 'omondi', 2, '2019-11-28 13:00:52');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `Day` text NOT NULL,
  `Department` enum('Lecturer','Student','staff') NOT NULL,
  `Message` longtext NOT NULL,
  `Submitted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `Day`, `Department`, `Message`, `Submitted_at`) VALUES
(1, 'Monday', 'Student', 'It was nice parking in SBS the new system is so efficient', '2019-11-27 18:19:14'),
(2, 'Tuesday', 'staff', 'There are no enough parking spaces ', '2019-11-27 18:19:14'),
(3, 'Monday', 'Lecturer', 'The new sytem seems so ok', '2019-11-27 18:19:14');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `LocationID` int(10) NOT NULL,
  `Status` enum('Full','Available') NOT NULL,
  `LocationName` enum('Phase1','SBS','Library','Hima') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`LocationID`, `Status`, `LocationName`) VALUES
(1, 'Available', 'Phase1'),
(2, 'Available', 'Library'),
(3, 'Available', 'Hima'),
(4, 'Available', 'SBS');

-- --------------------------------------------------------

--
-- Table structure for table `parking_slot`
--

CREATE TABLE `parking_slot` (
  `SlotID` int(100) NOT NULL,
  `LocationID` int(10) NOT NULL,
  `Status` enum('Free','Booked','Reserved') NOT NULL DEFAULT 'Free'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parking_slot`
--

INSERT INTO `parking_slot` (`SlotID`, `LocationID`, `Status`) VALUES
(1, 1, 'Free'),
(2, 1, 'Free'),
(3, 1, 'Free'),
(4, 1, 'Free'),
(5, 1, 'Free'),
(9, 4, 'Free'),
(10, 4, 'Free'),
(11, 4, 'Free'),
(12, 4, 'Free');

-- --------------------------------------------------------

--
-- Table structure for table `sticker`
--

CREATE TABLE `sticker` (
  `StickerID` int(11) NOT NULL,
  `sMode` enum('fullTime','Evening') NOT NULL,
  `userNo` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `Address` int(255) NOT NULL,
  `vehicleNo` varchar(20) NOT NULL,
  `vehicleColor` varchar(255) NOT NULL,
  `vehicleModel` varchar(255) NOT NULL,
  `Department` enum('Lecturer','Student','staff') NOT NULL,
  `Validity` date NOT NULL,
  `Disabled` enum('Yes','No') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sticker`
--

INSERT INTO `sticker` (`StickerID`, `sMode`, `userNo`, `name`, `Address`, `vehicleNo`, `vehicleColor`, `vehicleModel`, `Department`, `Validity`, `Disabled`) VALUES
(8, 'fullTime', 26, 'himanshu', 714587635, 'kbl 14', 'Yellow', 'Toyota', 'Student', '2019-11-29', 'No'),
(12, 'Evening', 31, 'omondi', 12345, 'KCG 1143', 'Grey', 'BMW', 'Lecturer', '2019-11-09', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('Admin','Guard','parkinguser') DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `username`, `email`, `role`, `password`, `created_at`, `updated_at`) VALUES
(6, 'linet', 'linet@gmail.com', 'parkinguser', '81dc9bdb52d04dc20036dbd8313ed055', '2019-11-18 19:40:32', '2019-11-18 19:40:32'),
(7, 'kenton', 'kenton@gmail.com', 'Guard', '81dc9bdb52d04dc20036dbd8313ed055', '2019-11-18 19:44:13', '2019-11-18 19:44:13'),
(9, 'ken', 'admin@admin.com', 'Admin', '81dc9bdb52d04dc20036dbd8313ed055', '2019-11-18 19:51:15', '2019-11-18 19:51:15'),
(26, 'himanshu', 'himanshu@gmail.com', 'parkinguser', '81dc9bdb52d04dc20036dbd8313ed055', '2019-11-25 08:59:08', '2019-11-25 08:59:08'),
(27, 'yvonne', '123@gmail.com', 'parkinguser', '81dc9bdb52d04dc20036dbd8313ed055', '2019-11-25 09:00:34', '2019-11-25 09:00:34'),
(28, '119453', '1234@gmail.com', 'parkinguser', '81dc9bdb52d04dc20036dbd8313ed055', '2019-11-25 09:36:33', '2019-11-25 09:36:33'),
(29, 'Walter', 'walter@strathmore.edu', 'parkinguser', '81dc9bdb52d04dc20036dbd8313ed055', '2019-11-26 09:13:42', '2019-11-26 09:13:42'),
(31, 'omondi', 'kelvin@strathmore.edu', 'parkinguser', '81dc9bdb52d04dc20036dbd8313ed055', '2019-11-28 12:59:49', '2019-11-28 12:59:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `slot` (`slot`),
  ADD UNIQUE KEY `useri` (`useri`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`LocationID`);

--
-- Indexes for table `parking_slot`
--
ALTER TABLE `parking_slot`
  ADD PRIMARY KEY (`SlotID`);

--
-- Indexes for table `sticker`
--
ALTER TABLE `sticker`
  ADD PRIMARY KEY (`StickerID`),
  ADD KEY `userNo` (`userNo`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `LocationID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `parking_slot`
--
ALTER TABLE `parking_slot`
  MODIFY `SlotID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `sticker`
--
ALTER TABLE `sticker`
  MODIFY `StickerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`useri`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`slot`) REFERENCES `parking_slot` (`SlotID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sticker`
--
ALTER TABLE `sticker`
  ADD CONSTRAINT `sticker_ibfk_1` FOREIGN KEY (`userNo`) REFERENCES `users` (`userID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
