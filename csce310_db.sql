-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2023 at 11:00 PM
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
('2023-05-02 00:00:00', '23:08:38', 2, 'Meeting', 1, 'helle');

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
(2, 123456, 2);

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
(1, 'board2', 123456);

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
(1, 123456, 1, 0),
(2, 123455, 1, 1);

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

--
-- Dumping data for table `board_item`
--

INSERT INTO `board_item` (`item_id`, `item_timestamp`, `item_posttype`, `item_content`, `usr_id`, `board_id`) VALUES
(52, '2023-05-04', 1, '1', 123456, 1),
(53, '2023-05-04', 0, '1', 123456, 1),
(58, '2023-05-04', 2, 'can i add?', 123455, 1),
(59, '2023-05-04', 2, 'justins comment', 123455, 1),
(60, '2023-05-04', 2, 'well', 123455, 1);

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
(123455, 'justin', 'password'),
(123456, 'hello', 'hello');

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
  MODIFY `appt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `appointment_assignments`
--
ALTER TABLE `appointment_assignments`
  MODIFY `app_assignment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `board`
--
ALTER TABLE `board`
  MODIFY `board_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `board_assignments`
--
ALTER TABLE `board_assignments`
  MODIFY `assignment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `board_item`
--
ALTER TABLE `board_item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `usr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123457;

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

CREATE VIEW board_assign_usr AS
SELECT usr_id, board_id
FROM board_assignments;
