-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 22, 2024 at 08:56 PM
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
-- Database: `xgroups`
--

-- --------------------------------------------------------

--
-- Table structure for table `astro_info`
--

CREATE TABLE `astro_info` (
  `birthID` int(255) NOT NULL,
  `element` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `birth_info`
--

CREATE TABLE `birth_info` (
  `userID` int(255) NOT NULL,
  `sex` char(1) NOT NULL DEFAULT '',
  `month` char(2) NOT NULL DEFAULT '',
  `day` char(2) NOT NULL DEFAULT '',
  `year` varchar(4) NOT NULL DEFAULT '',
  `hour` char(2) NOT NULL DEFAULT '',
  `minute` char(2) NOT NULL DEFAULT '',
  `timezone` varchar(10) NOT NULL DEFAULT '',
  `timezone_txt` varchar(30) NOT NULL,
  `long_deg` char(3) NOT NULL DEFAULT '',
  `long_min` char(2) NOT NULL DEFAULT '',
  `ew` char(2) NOT NULL DEFAULT '',
  `lat_deg` char(2) NOT NULL DEFAULT '',
  `lat_min` char(2) NOT NULL DEFAULT '',
  `ns` char(2) NOT NULL DEFAULT '',
  `comments` mediumtext DEFAULT NULL,
  `entry_date` date NOT NULL DEFAULT '2000-01-01',
  `admin_response` mediumtext DEFAULT NULL,
  `respond_date` date DEFAULT NULL,
  `long_secs` varchar(20) DEFAULT NULL,
  `lat_secs` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `birth_info`
--

INSERT INTO `birth_info` (`userID`, `sex`, `month`, `day`, `year`, `hour`, `minute`, `timezone`, `timezone_txt`, `long_deg`, `long_min`, `ew`, `lat_deg`, `lat_min`, `ns`, `comments`, `entry_date`, `admin_response`, `respond_date`, `long_secs`, `lat_secs`) VALUES
(1, 'm', '9', '7', '1978', '14', '30', '1', 'Europe/Madrid', '3', '42', '-1', '40', '25', '1', NULL, '2021-02-17', NULL, NULL, '13.6440', '0.3900'),
(2, 'f', '5', '7', '1972', '06', '00', '1', 'Europe/Madrid', '1', '26', '1', '38', '55', '1', NULL, '2021-02-17', NULL, NULL, NULL, NULL),
(3, 'f', '11', '29', '1979', '01', '00', '-3', 'America/Sao_Paulo', '46', '37', '-1', '23', '32', '-1', NULL, '2021-02-17', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `userID` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `surname` varchar(50) NOT NULL,
  `sex` varchar(10) NOT NULL,
  `profession` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`userID`, `username`, `email`, `password`, `name`, `surname`, `sex`, `profession`) VALUES
(2, '', '', '', 'Mark', '', '', 'Doctor'),
(3, '', '', '', 'James', '', '', 'Doctor'),
(4, '', '', '', 'Jack', '', '', 'Doctor'),
(5, '', '', '', 'Dirk', '', '', 'Doctor'),
(6, '', '', '', 'Dana', '', '', 'Doctor'),
(7, '', '', '', 'James', '', '', 'Policeman'),
(8, '', '', '', 'Jack', '', '', 'Policeman'),
(9, '', '', '', 'Dirk', '', '', 'Policeman'),
(10, '', '', '', 'Dana', '', '', 'Policeman'),
(11, '', '', '', 'joker', '', '', 'Lawyer'),
(12, '', '', '', 'Mark', '', '', 'Doctor'),
(13, '', '', '', 'Alice', '', '', 'Engineer'),
(14, '', '', '', 'Bob', '', '', 'Lawyer'),
(15, '', '', '', 'Charlie', '', '', 'Doctor'),
(16, '', '', '', 'Diana', '', '', 'Policeman'),
(17, '', '', '', 'Eva', '', '', 'Doctor'),
(18, '', '', '', 'Frank', '', '', 'Engineer'),
(19, '', '', '', 'Grace', '', '', 'Policeman'),
(20, '', '', '', 'Henry', '', '', 'Doctor'),
(21, '', '', '', 'Ivy', '', '', 'Lawyer'),
(22, '', '', '', 'Jack', '', '', 'Engineer'),
(23, '', '', '', 'Kelly', '', '', 'Policeman'),
(24, '', '', '', 'Leo', '', '', 'Doctor'),
(25, '', '', '', 'Mia', '', '', 'Engineer'),
(26, '', '', '', 'Nathan', '', '', 'Policeman'),
(27, '', '', '', 'Olivia', '', '', 'Doctor'),
(28, '', '', '', 'Peter', '', '', 'Engineer'),
(29, '', '', '', 'Quinn', '', '', 'Lawyer'),
(30, '', '', '', 'Rachel', '', '', 'Policeman'),
(31, '', '', '', 'Sam', '', '', 'Doctor'),
(32, '', '', '', 'Tina', '', '', 'Policeman'),
(33, '', '', '', 'Ulysses', '', '', 'Lawyer'),
(34, '', '', '', 'Vicky', '', '', 'Policeman'),
(35, '', '', '', 'Walter', '', '', 'Doctor'),
(36, '', '', '', 'Xena', '', '', 'Engineer'),
(37, '', '', '', 'Yvonne', '', '', 'Lawyer'),
(38, '', '', '', 'Zack', '', '', 'Doctor'),
(39, '', '', '', 'Alex', '', '', 'Engineer'),
(40, '', '', '', 'Bella', '', '', 'Policeman'),
(41, '', '', '', 'Chris', '', '', 'Lawyer'),
(42, '', '', '', 'David', '', '', 'Policeman'),
(43, '', '', '', 'Emma', '', '', 'Doctor'),
(44, '', '', '', 'Felix', '', '', 'Engineer'),
(45, '', '', '', 'Gina', '', '', 'Lawyer'),
(46, '', '', '', 'Hank', '', '', 'Doctor'),
(47, '', '', '', 'Isabel', '', '', 'Policeman'),
(48, '', '', '', 'Jake', '', '', 'Lawyer'),
(49, '', '', '', 'Katie', '', '', 'Engineer'),
(50, '', '', '', 'Liam', '', '', 'Policeman'),
(51, '', 'r@rapuig.com', '$2y$10$kNLT349nLdHs3HaUnOCwqe8zqyBCfFjwsodPbJXSSa4mBNdbyp9Da', NULL, '', '', NULL),
(52, '', 'r@rapuig.com', '$2y$10$E1zzJm7mLaA5PCmuIvu5RuvNti1DU12TLUjJavAtTJJBT1xsbjgiO', NULL, '', '', NULL),
(53, '', 'r@rapuig.com', '$2y$10$K3JW0YUxLQZ69qBFwAggAeHc/YWSQpKWPWlg0GZIGgG6IGtosr.bK', NULL, '', '', NULL),
(54, '', 'r@rapuig.com', '$2y$10$G0g8oY6swC7Tr2n1QkKhWupCpmlWrNjD4v8fmZdsUfkKT7bDj1qS2', NULL, '', '', NULL),
(55, '', 'r@rapuig.com', '$2y$10$Ep4FEgiO9T8TZuBrGPUs6etP2AoEO/F1R8//.PRSjx5RU/wbHbCIW', NULL, '', '', NULL),
(56, '', 'r@rapuig.com', '$2y$10$KH/0RChHTNiVuxM7mg.Mku/bjyxXrl.EUDHKU9pNXiKDD5OMIP2HW', NULL, '', '', NULL),
(57, '', 'r@rapuig.com', '$2y$10$whCbdQa9WZQOb78q0Lf0He01YdxX7/UrZwxmoLOzkA/rRw1AcuZXi', NULL, '', '', NULL),
(58, '', 'r@rapuig.com', '$2y$10$jaHmV71dSHBJ/nZvbwo4WuHesuIRGHn1DBManxhdxUQt/ytNFRG3O', NULL, '', '', NULL),
(59, '', 'r@rapuig.com', '$2y$10$dOiOTTis78vv8OGF5fEfBeJfzJjYsr/jEicjXYSJ5flTn8OgnxgCi', NULL, '', '', NULL),
(60, '', 'r@rapuig.com', '$2y$10$jjFqTKMAMlnvIxJD2luTdukEzsfmHxbiOZnxpwEV02EdoaqwrJOMi', NULL, '', '', NULL),
(61, '', 'r@rapuig.com', '$2y$10$70QAtRkmlxHL8Ua1LsHjE.eolt9p5LYK7DPgGuWg2/lTlUlffufmW', NULL, '', '', NULL),
(64, 'exito5', 'r@rapuig.com', '$2y$10$IvJ8Bsv0MuBJv/Po7zwh9.NqJLh/c9DM9WypCIwjImHv.MSQmFf7S', NULL, '', '', NULL),
(65, 'ray', 'r@rapuig.com', '$2y$10$m.02LlUU106GKC0A/l4kIeDt1yiM/ljNRKiuxfreYzRVwZM9rL3MC', NULL, '', '', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `userID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;