-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2024 at 07:18 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
