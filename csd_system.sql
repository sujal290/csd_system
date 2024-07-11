-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 11, 2024 at 11:07 PM
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
-- Database: `csd_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `chemicals`
--

CREATE TABLE `chemicals` (
  `cas_no` varchar(50) NOT NULL,
  `chemical_name` varchar(255) NOT NULL,
  `common_name` varchar(255) DEFAULT NULL,
  `grade` varchar(255) DEFAULT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `unit` varchar(50) NOT NULL,
  `remark` text DEFAULT NULL,
  `is_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `username` varchar(15) NOT NULL,
  `desig_id` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chemicals`
--

INSERT INTO `chemicals` (`cas_no`, `chemical_name`, `common_name`, `grade`, `quantity`, `unit`, `remark`, `is_created`, `is_updated`, `username`, `desig_id`) VALUES
('11', 'aaaaaaaa', 'sfdaf', 'XR', 59.00, 'ml', 'sdfa', '2024-07-09 15:43:09', '2024-07-09 15:43:09', 'john', 1),
('22', 'dsaf', 'asd', 'XR', 454.00, 'ml', 'dsa', '2024-07-09 15:43:33', '2024-07-09 15:43:33', 'john', 1),
('33', 'sdfasdf', 'dfs', 'LR', 44.00, 'L', 'dsfsa', '2024-07-09 15:43:52', '2024-07-09 15:43:52', 'john', 1),
('55', 'asdf', 'sad', 'LR', 89.00, 'ml', 'dsf', '2024-07-09 15:44:15', '2024-07-09 15:44:15', 'john', 1),
('66', 'dsfa', 'sdaf', 'AR', 99.00, 'ml', 'adsf', '2024-07-09 15:44:32', '2024-07-09 15:44:32', 'john', 1),
('77', 'asdf', 'sdaf', 'XR', 78.00, 'kg', 'dfsa', '2024-07-09 15:44:48', '2024-07-09 15:44:48', 'john', 1),
('8778', 'sdaf', 'dsfad', 'XR', 569.00, 'kg', 'sadfsd', '2024-07-09 15:01:26', '2024-07-09 15:01:26', 'john', 1),
('88', 'asfd', 'asdf', 'HPLC', 89.00, 'kg', 'asdf', '2024-07-09 15:45:08', '2024-07-09 15:45:08', 'john', 1),
('9696', 'sdaf', 'aasd', 'ads', 59.00, 'kg', 'sad', '2024-07-09 15:01:02', '2024-07-09 15:01:02', 'john', 1),
('99', 'adsf', 'adsf', 'HPLC', 89.00, 'kg', 'nice', '2024-07-09 15:45:25', '2024-07-09 15:45:25', 'john', 1),
('99999', 'bbbbbb', 'bbbbbbb', 'XR', 89.00, 'gm', 'gooood', '2024-07-09 12:33:40', '2024-07-09 14:46:35', 'john', 1);

-- --------------------------------------------------------

--
-- Table structure for table `id_desig`
--

CREATE TABLE `id_desig` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `desig_fullname` varchar(255) NOT NULL,
  `cadre_id` int(11) NOT NULL,
  `is_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_deleted` enum('YES','NO') NOT NULL DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `id_desig`
--

INSERT INTO `id_desig` (`id`, `name`, `desig_fullname`, `cadre_id`, `is_created`, `is_deleted`) VALUES
(1, 'Manager', 'Manager', 1, '2024-07-09 11:13:44', 'NO'),
(2, 'Engineer', 'Senior Engineer', 2, '2024-07-09 11:13:44', 'NO'),
(3, 'Technician', 'Lead Technician', 3, '2024-07-09 11:13:44', 'NO'),
(4, 'Analyst', 'Senior Analyst', 4, '2024-07-09 11:13:44', 'NO');

-- --------------------------------------------------------

--
-- Table structure for table `id_emp`
--

CREATE TABLE `id_emp` (
  `id` int(6) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(50) NOT NULL,
  `last_name` varchar(80) NOT NULL,
  `gen` varchar(20) NOT NULL,
  `dob` date NOT NULL,
  `mobile_no` varchar(10) NOT NULL,
  `email_id` varchar(100) NOT NULL,
  `cadre_id` tinyint(4) NOT NULL,
  `desig_id` int(5) NOT NULL,
  `internal_desig_id` int(4) NOT NULL,
  `group_id` int(5) NOT NULL,
  `user_type` char(9) NOT NULL,
  `telephone_no` varchar(11) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 1,
  `is_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_deleted` enum('YES','NO') NOT NULL DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `id_emp`
--

INSERT INTO `id_emp` (`id`, `first_name`, `middle_name`, `last_name`, `gen`, `dob`, `mobile_no`, `email_id`, `cadre_id`, `desig_id`, `internal_desig_id`, `group_id`, `user_type`, `telephone_no`, `username`, `password`, `status`, `is_created`, `is_deleted`) VALUES
(2, 'admin', 'Mary', 'Johnson', 'Female', '1992-05-15', '9876543211', 'jane.johnson@example.com', 2, 2, 2, 2, 'admin', '1234567891', 'jane', 'admin123', 1, '2024-07-09 11:13:44', 'NO'),
(1, 'user', 'Doe', 'Smith', 'Male', '1990-01-01', '9876543210', 'john.doe@example.com', 1, 1, 1, 1, 'user', '1234567890', 'john', 'user123', 1, '2024-07-09 11:13:44', 'NO');

-- --------------------------------------------------------

--
-- Table structure for table `id_group`
--

CREATE TABLE `id_group` (
  `group_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `gh_id` int(11) NOT NULL,
  `gd_id` int(11) NOT NULL,
  `va1_id` int(11) NOT NULL,
  `va2_id` int(11) NOT NULL,
  `is_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_deleted` enum('YES','NO') NOT NULL DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `id_group`
--

INSERT INTO `id_group` (`group_id`, `name`, `fullname`, `gh_id`, `gd_id`, `va1_id`, `va2_id`, `is_created`, `is_deleted`) VALUES
(1, 'Group A', 'Group A Fullname', 101, 201, 301, 401, '2024-07-09 11:13:44', 'NO'),
(2, 'Group B', 'Group B Fullname', 102, 202, 302, 402, '2024-07-09 11:13:44', 'NO');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `itemId` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int(11) DEFAULT 0,
  `date_&_time_added` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`itemId`, `name`, `category`, `description`, `price`, `stock_quantity`, `date_&_time_added`) VALUES
(12, 'Apple', 'fruit', 'good', 7.00, 20, '2024-06-25 18:12:17'),
(13, 'Apple', 'fruit', 'good', 7.00, 20, '2024-06-25 18:12:25'),
(14, 'Apple', 'fruit', 'good', 7.00, 20, '2024-06-25 18:12:30'),
(15, 'Apple', 'fruit', 'good', 7.00, 20, '2024-06-25 18:12:34'),
(16, 'Apple', 'fruit', 'good', 7.00, 20, '2024-06-25 18:12:36'),
(17, 'Apple', 'fruit', 'good', 7.00, 20, '2024-06-25 18:12:39'),
(18, 'Apple', 'fruit', 'good', 7.00, 20, '2024-06-25 18:12:43'),
(19, 'hello', 'vegetable', 'nice one', 7.00, 70, '2024-06-25 18:16:06'),
(20, 'grapes', 'fruit hai shayad', 'hello', 50.00, 150, '2024-06-25 18:17:08'),
(21, 'grapes1', 'fruit hai shayad', 'please', 5000.00, 150, '2024-06-25 18:18:19'),
(25, 'banana', 'i dont know', 'good', 100.00, 50, '2024-06-25 22:25:59'),
(26, 'banana', 'i dont know', 'good', 100.00, 50, '2024-06-25 22:28:42'),
(27, 'banana', 'i dont know', 'good', 100.00, 50, '2024-06-25 22:28:53'),
(28, 'good', 'good', 'good', 99.00, 100, '2024-06-25 22:30:10'),
(29, 'good', 'good', 'good', 99.00, 100, '2024-06-25 22:30:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chemicals`
--
ALTER TABLE `chemicals`
  ADD PRIMARY KEY (`cas_no`),
  ADD KEY `fk_chemicals_id_emp` (`username`,`desig_id`);

--
-- Indexes for table `id_desig`
--
ALTER TABLE `id_desig`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `id_emp`
--
ALTER TABLE `id_emp`
  ADD PRIMARY KEY (`username`,`desig_id`),
  ADD KEY `fk_id_emp_id_desig` (`desig_id`),
  ADD KEY `fk_id_emp_group_id` (`group_id`);

--
-- Indexes for table `id_group`
--
ALTER TABLE `id_group`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`itemId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `itemId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chemicals`
--
ALTER TABLE `chemicals`
  ADD CONSTRAINT `fk_chemicals_id_emp` FOREIGN KEY (`username`,`desig_id`) REFERENCES `id_emp` (`username`, `desig_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `id_emp`
--
ALTER TABLE `id_emp`
  ADD CONSTRAINT `fk_id_emp_group_id` FOREIGN KEY (`group_id`) REFERENCES `id_group` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_emp_id_desig` FOREIGN KEY (`desig_id`) REFERENCES `id_desig` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
