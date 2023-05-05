-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2023 at 10:42 PM
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
  `appt_time` datetime NOT NULL,
  `appt_duration` time NOT NULL,
  `appt_id` int(11) NOT NULL,
  `appt_type` text NOT NULL,
  `board_id` int(11) NOT NULL,
  `appt_name` varchar(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`appt_time`, `appt_duration`, `appt_id`, `appt_type`, `board_id`, `appt_name`) VALUES
('2025-05-05 17:00:00', '01:00:00', 12, 'meeting', 13, 'meeting');

-- --------------------------------------------------------

--
-- Table structure for table `appointment_assignments`
--

CREATE TABLE `appointment_assignments` (
  `app_assignment_id` int(11) NOT NULL,
  `usr_id` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment_assignments`
--

INSERT INTO `appointment_assignments` (`app_assignment_id`, `usr_id`, `appointment_id`) VALUES
(14, 123462, 12);

-- --------------------------------------------------------

--
-- Table structure for table `board`
--

CREATE TABLE `board` (
  `board_id` int(11) NOT NULL,
  `board_name` varchar(255) NOT NULL,
  `board_admin_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `board`
--

INSERT INTO `board` (`board_id`, `board_name`, `board_admin_id`) VALUES
(10, 'test board', 123461),
(11, 'board', 123461),
(13, 'testBoard2', 123462);

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

--
-- Dumping data for table `board_assignments`
--

INSERT INTO `board_assignments` (`assignment_id`, `usr_id`, `board_id`, `access_level`) VALUES
(15, 123461, 10, 0),
(17, 12344, 10, 2),
(18, 123461, 11, 0),
(20, 123462, 13, 0),
(22, 12344, 13, 2);

-- --------------------------------------------------------

--
-- Stand-in structure for view `board_assign_usr`
-- (See below for the actual view)
--
CREATE TABLE `board_assign_usr` (
`usr_id` int(11)
,`board_id` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `board_item`
--

CREATE TABLE `board_item` (
  `item_id` int(11) NOT NULL,
  `item_timestamp` date NOT NULL,
  `item_posttype` int(11) NOT NULL,
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
  `usr_passwd` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`usr_id`, `usr_name`, `usr_passwd`) VALUES
(12344, 'not justin', 'password_also'),
(123461, 'justin', 'password'),
(123462, 'sloan davis', 'password');

-- --------------------------------------------------------

--
-- Structure for view `board_assign_usr`
--
DROP TABLE IF EXISTS `board_assign_usr`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `board_assign_usr`  AS SELECT `board_assignments`.`usr_id` AS `usr_id`, `board_assignments`.`board_id` AS `board_id` FROM `board_assignments``board_assignments`  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`appt_id`),
  ADD KEY `appointment_ibfk_1` (`board_id`);

--
-- Indexes for table `appointment_assignments`
--
ALTER TABLE `appointment_assignments`
  ADD PRIMARY KEY (`app_assignment_id`),
  ADD KEY `appointment_assignments_ibfk_1` (`usr_id`),
  ADD KEY `appointment_assignments_ibfk_2` (`appointment_id`);

--
-- Indexes for table `board`
--
ALTER TABLE `board`
  ADD PRIMARY KEY (`board_id`),
  ADD KEY `board_ibfk_1` (`board_admin_id`);

--
-- Indexes for table `board_assignments`
--
ALTER TABLE `board_assignments`
  ADD PRIMARY KEY (`assignment_id`),
  ADD KEY `board_assignments_ibfk_1` (`usr_id`),
  ADD KEY `board_assignments_ibfk_2` (`board_id`);

--
-- Indexes for table `board_item`
--
ALTER TABLE `board_item`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `board_item_ibfk_1` (`usr_id`),
  ADD KEY `board_item_ibfk_2` (`board_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`usr_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `appt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `appointment_assignments`
--
ALTER TABLE `appointment_assignments`
  MODIFY `app_assignment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `board`
--
ALTER TABLE `board`
  MODIFY `board_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `board_assignments`
--
ALTER TABLE `board_assignments`
  MODIFY `assignment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `board_item`
--
ALTER TABLE `board_item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `usr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123463;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`board_id`) REFERENCES `board` (`board_id`);

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
