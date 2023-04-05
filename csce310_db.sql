-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2023 at 12:21 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `csce310_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `appt_time` date NOT NULL,
  `appt_duration` time NOT NULL,
  `appt_id` int(11) NOT NULL,
  `appt_type` text NOT NULL,
  `board_id` int(11) NOT NULL,
  `appt_name` varchar(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appointment_assignments`
--

CREATE TABLE `appointment_assignments` (
  `app_assignment_id` int(11) NOT NULL,
  `usr_id` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `usr_relation` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `board`
--

CREATE TABLE `board` (
  `board_id` int(11) NOT NULL,
  `board_name` varchar(255) NOT NULL,
  `board_admin_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `board_assignments`
--

CREATE TABLE `board_assignments` (
  `assignment_id` int(11) NOT NULL,
  `usr_id` int(11) NOT NULL,
  `board_id` int(11) NOT NULL,
  `access_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `board_item`
--

CREATE TABLE `board_item` (
  `item_id` int(11) NOT NULL,
  `item_timestamp` date NOT NULL,
  `item_posttype` varchar(255) NOT NULL,
  `item_content` varchar(255) NOT NULL,
  `usr_id` int(11) NOT NULL,
  `board_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `usr_id` int(11) NOT NULL,
  `usr_name` varchar(255) NOT NULL,
  `usr_passwd` varchar(255) NOT NULL,
  `board_id` int(11) NOT NULL,
  `profile_desc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`appt_id`),
  ADD UNIQUE KEY `board_id` (`board_id`);

--
-- Indexes for table `appointment_assignments`
--
ALTER TABLE `appointment_assignments`
  ADD PRIMARY KEY (`app_assignment_id`),
  ADD UNIQUE KEY `usr_id` (`usr_id`),
  ADD UNIQUE KEY `appointment_id` (`appointment_id`);

--
-- Indexes for table `board`
--
ALTER TABLE `board`
  ADD PRIMARY KEY (`board_id`),
  ADD UNIQUE KEY `board_admin_id` (`board_admin_id`);

--
-- Indexes for table `board_assignments`
--
ALTER TABLE `board_assignments`
  ADD PRIMARY KEY (`assignment_id`),
  ADD UNIQUE KEY `usr_id` (`usr_id`),
  ADD UNIQUE KEY `board_id` (`board_id`);

--
-- Indexes for table `board_item`
--
ALTER TABLE `board_item`
  ADD PRIMARY KEY (`item_id`),
  ADD UNIQUE KEY `usr_id` (`usr_id`),
  ADD UNIQUE KEY `board_id` (`board_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`usr_id`),
  ADD UNIQUE KEY `board_id` (`board_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_2` FOREIGN KEY (`board_id`) REFERENCES `board` (`board_id`);

--
-- Constraints for table `appointment_assignments`
--
ALTER TABLE `appointment_assignments`
  ADD CONSTRAINT `appointment_assignments_ibfk_1` FOREIGN KEY (`usr_id`) REFERENCES `users` (`usr_id`),
  ADD CONSTRAINT `appointment_assignments_ibfk_2` FOREIGN KEY (`appointment_id`) REFERENCES `appointment` (`appt_id`);

--
-- Constraints for table `board`
--
ALTER TABLE `board`
  ADD CONSTRAINT `board_ibfk_1` FOREIGN KEY (`board_admin_id`) REFERENCES `users` (`usr_id`);

--
-- Constraints for table `board_assignments`
--
ALTER TABLE `board_assignments`
  ADD CONSTRAINT `board_assignments_ibfk_1` FOREIGN KEY (`usr_id`) REFERENCES `users` (`usr_id`),
  ADD CONSTRAINT `board_assignments_ibfk_2` FOREIGN KEY (`board_id`) REFERENCES `board` (`board_id`);

--
-- Constraints for table `board_item`
--
ALTER TABLE `board_item`
  ADD CONSTRAINT `board_item_ibfk_1` FOREIGN KEY (`usr_id`) REFERENCES `users` (`usr_id`),
  ADD CONSTRAINT `board_item_ibfk_2` FOREIGN KEY (`board_id`) REFERENCES `board` (`board_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`board_id`) REFERENCES `board_assignments` (`board_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
