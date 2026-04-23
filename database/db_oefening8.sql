-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2026 at 11:37 PM
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
-- Database: `db_oefening8`
--

-- --------------------------------------------------------

--
-- Table structure for table `wenslijst`
--

CREATE TABLE `wenslijst` (
  `id` int(11) NOT NULL,
  `prijs` decimal(13,2) NOT NULL,
  `omschrijving` text NOT NULL,
  `winkel` varchar(500) NOT NULL,
  `webadres` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wenslijst`
--

INSERT INTO `wenslijst` (`id`, `prijs`, `omschrijving`, `winkel`, `webadres`) VALUES
(16, 459.00, 'Steamdeck', 'Valve', ''),
(17, 900.00, 'Steamdeck referbusid', 'Valve', ''),
(18, 1111.00, 'Steamdeck', 'Valve', ''),
(19, 1200.00, 'Steamdeck OLED', 'valve', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wenslijst`
--
ALTER TABLE `wenslijst`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wenslijst`
--
ALTER TABLE `wenslijst`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
