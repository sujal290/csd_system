-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 23, 2024 at 11:45 AM
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
-- Database: `file_management`
--

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
(101, 'Ritik', '', 'Vashist', 'Male', '2001-09-01', '9911330906', 'ritikvashist0109@gmail.com', 101, 1011, 101, 101, 'admin', '130', 'ritik', 'd34a01b589627e7c5ac3a90cad06b2a7', 1, '2022-07-10 05:29:01', 'NO'),
(102, 'Rishabh', '', 'Vashist', 'Male', '2022-07-11', '9911330906', 'rsgv0212@gmail.com', 101, 101, 101, 101, 'user', '', 'rishabh', 'c64e8e7b05a6d831605cfe23dd617deb', 1, '2022-07-10 06:09:23', 'NO'),
(103, 'Kshitij Dwivedi', '', '', 'Male', '2022-07-18', '8383917575', 'test@gmail.com', 101, 1011, 101, 102, 'user', '', 'kshitij', '517d7a57bd7e6c167fab9cb519ce5849', 1, '2022-07-18 04:37:24', 'NO'),
(104, 'testing code', '', '', 'Male', '2022-07-18', '8383917575', 'test@gmail.com', 0, 1011, 101, 102, 'user', '', 'test', '12', 1, '2022-07-19 02:06:12', 'NO'),
(105, 'test ad', '', '', 'Male', '2022-07-12', '5587545', '', 0, 1011, 0, 103, 'user', '', 'testad', 'bf58f1fbf92896ef64cf6265a5889c42', 1, '2022-07-25 23:42:59', 'NO'),
(106, 'test gh', '', '', '', '0000-00-00', '', '', 0, 1011, 0, 103, 'user', '', 'testgh', 'c3e4bfdc7e40ac65a58068e88018c93f', 1, '2022-07-25 23:44:42', 'NO'),
(107, 'director', '', '', '', '0000-00-00', '', '', 0, 1011, 0, 104, 'user', '', 'director', '3d4e992d8d8a7d848724aa26ed7f4176', 1, '2022-07-26 01:12:27', 'NO'),
(108, 'TEST', '', 'Vashist', 'Male', '2001-09-01', '9911330906', 'ritikvashist0109@gmail.com', 101, 1011, 101, 101, 'user', '130', 'testkd', 'b6519cc4217f22ea078ebbbed345537c', 1, '2022-07-09 23:59:01', 'NO');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `id_emp`
--
ALTER TABLE `id_emp`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `id_emp`
--
ALTER TABLE `id_emp`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
