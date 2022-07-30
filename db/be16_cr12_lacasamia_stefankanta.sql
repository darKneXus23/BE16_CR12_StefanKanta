-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 30, 2022 at 10:43 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `be16_cr12_lacasamia_stefankanta`
--
CREATE DATABASE IF NOT EXISTS `be16_cr12_lacasamia_stefankanta` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `be16_cr12_lacasamia_stefankanta`;

-- --------------------------------------------------------

--
-- Table structure for table `property`
--

CREATE TABLE `property` (
  `id` int(6) NOT NULL,
  `title` varchar(100) NOT NULL,
  `image` varchar(50) DEFAULT 'default.png',
  `size` int(15) DEFAULT NULL,
  `rooms` int(2) DEFAULT NULL,
  `city` varchar(10) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `latitude` float(9,6) DEFAULT NULL,
  `longitude` float(9,6) DEFAULT NULL,
  `price` int(12) DEFAULT NULL,
  `reduction` int(1) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `property`
--

INSERT INTO `property` (`id`, `title`, `image`, `size`, `rooms`, `city`, `address`, `latitude`, `longitude`, `price`, `reduction`, `description`) VALUES
(1, 'Comfortable penthouse', 'default.png', 405, 10, 'Vienna', 'Spiegelgasse 10', 48.134102, 16.134100, 7000000, 1, 'Planning penthouse includes 4 bedrooms, office, laundry room and storage, two kitchens, 4 toilets, 3 bathrooms, two rooms that can be used at the discretion of the client, and three terraces.  Penthouse can be divided into 2 independent parts (the cost will be EUR 0.8 million and EUR 6.2 million).'),
(6, 'noreduction', 'noreduction.jpg', 100, 4, 'Vienna', 'dafaf', 48.165703, 16.348103, 230000, 0, 'test description'),
(7, 'reduced', 'reduction.jpg', 100, 4, 'Vienna', 'Spiegelgasse 10', 48.153713, 16.290136, 230000, 1, 'create test description3'),
(8, 'Office Building', '62e4ec41ea9a3.png', 1000, 20, 'Vienna', 'Herrengasse 6', 48.209064, 16.365957, 100000000, 1, 'Ministry of Inner Affairs for sale');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `property`
--
ALTER TABLE `property`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `property`
--
ALTER TABLE `property`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
