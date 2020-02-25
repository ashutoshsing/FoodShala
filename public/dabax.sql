-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2020 at 10:39 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dabax`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `first_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `username` varchar(30) DEFAULT NULL,
  `address` varchar(30) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `preference` varchar(30) DEFAULT NULL,
  `password` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`first_name`, `last_name`, `username`, `address`, `email`, `preference`, `password`) VALUES
('A', 'A', 'A', 'AAAA', 'a@A', 'Non-Vegetarian', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `menu_title` varchar(30) NOT NULL,
  `menu_restaurant` varchar(30) DEFAULT NULL,
  `menu_price` int(5) DEFAULT NULL,
  `menu_type` varchar(30) DEFAULT NULL,
  `menu_image` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`menu_title`, `menu_restaurant`, `menu_price`, `menu_type`, `menu_image`) VALUES
('dosa', 'ashu', 100, 'Vegetarian', 'Dosa.jfif'),
('KADHAI CHICKEN', 'ashu', 300, 'Non-Vegetarian', 'Kadhai Chicken.jfif');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_name` varchar(20) DEFAULT NULL,
  `order_price` int(3) DEFAULT NULL,
  `order_rest` varchar(20) DEFAULT NULL,
  `order_customer` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_name`, `order_price`, `order_rest`, `order_customer`) VALUES
('idli', 20, 'ashu', 'ashussri'),

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
  `rest_name` varchar(20) DEFAULT NULL,
  `rest_email` varchar(20) DEFAULT NULL,
  `rest_addr` varchar(20) DEFAULT NULL,
  `rest_pass` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `restaurants`
--

INSERT INTO `restaurants` (`rest_name`, `rest_email`, `rest_addr`, `rest_pass`) VALUES
('ashu', 'ashu@123', 'swdwd', '11'),
('Ashu', 'abcd@xyz', 'dsC', '11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`menu_title`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
