-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 24, 2023 at 05:11 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotelmanagementsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `Booking_no` int(11) NOT NULL,
  `Guest_name` varchar(255) NOT NULL,
  `Hid` int(11) DEFAULT NULL,
  `Rid` int(11) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`Booking_no`, `Guest_name`, `Hid`, `Rid`, `start_date`, `end_date`) VALUES
(401, 'Varun Singh', 5, 201, '2023-09-01', '2023-09-04'),
(404, 'Anuj Yadav', 1, 206, '2023-12-01', '2023-12-04'),
(405, 'Anuj Yadav', 1, 204, '2023-08-01', '2023-08-04'),
(407, 'Rishav Chanda', 4, 210, '2023-08-07', '2023-08-10'),
(408, 'Arkadipta Paul', 2, 205, '2023-12-17', '2023-12-19'),
(411, 'Pushpal Mukherjee', 1, 206, '2023-10-10', '2023-10-17');

-- --------------------------------------------------------

--
-- Table structure for table `hotel`
--

CREATE TABLE `hotel` (
  `Hid` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `City` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hotel`
--

INSERT INTO `hotel` (`Hid`, `Name`, `City`) VALUES
(1, 'Hyatt Regency', 'Kolkata'),
(2, 'Southern Plaza Hotel', 'Kolkata'),
(3, 'St. Marks Hotel', 'Bengaluru'),
(4, 'Sterlings Mac Hotel', 'Bengaluru'),
(5, 'Grand Hotel', 'Mumbai'),
(6, 'Taj Hotel', 'Mumbai');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `Rid` int(11) NOT NULL,
  `Hid` int(11) DEFAULT NULL,
  `Tariff` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`Rid`, `Hid`, `Tariff`) VALUES
(200, 1, 11000.00),
(201, 6, 12000.00),
(202, 5, 11000.00),
(203, 4, 14000.00),
(204, 3, 5000.00),
(205, 2, 4000.00),
(206, 1, 9000.00),
(207, 1, 10000.00),
(208, 4, 7000.00),
(209, 5, 10000.00),
(210, 6, 9500.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`Booking_no`),
  ADD KEY `Hid` (`Hid`),
  ADD KEY `Rid` (`Rid`);

--
-- Indexes for table `hotel`
--
ALTER TABLE `hotel`
  ADD PRIMARY KEY (`Hid`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`Rid`),
  ADD KEY `Hid` (`Hid`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`Hid`) REFERENCES `hotel` (`Hid`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`Rid`) REFERENCES `room` (`Rid`);

--
-- Constraints for table `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `room_ibfk_1` FOREIGN KEY (`Hid`) REFERENCES `hotel` (`Hid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
