-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:4306
-- Generation Time: Jan 19, 2025 at 09:24 AM
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
-- Database: `excel_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `marksheets`
--

CREATE TABLE `marksheets` (
  `roll` int(5) NOT NULL,
  `name` varchar(25) NOT NULL,
  `English` int(25) NOT NULL,
  `Hindi` int(11) NOT NULL,
  `Maths` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `marksheets`
--

INSERT INTO `marksheets` (`roll`, `name`, `English`, `Hindi`, `Maths`) VALUES
(101, 'Ramesh Yadav', 50, 70, 90),
(102, 'Mukesh Sharma', 60, 90, 80),
(101, 'Ramesh Yadav', 50, 70, 90),
(102, 'Mukesh Sharma', 60, 90, 80);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
