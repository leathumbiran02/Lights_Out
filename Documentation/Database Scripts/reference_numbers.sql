-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 06, 2023 at 08:27 PM
-- Server version: 10.5.20-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id20840950_lights_out`
--

-- --------------------------------------------------------

--
-- Table structure for table `reference_numbers`
--

CREATE TABLE `reference_numbers` (
  `reference_number` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `reference_numbers`
--

INSERT INTO `reference_numbers` (`reference_number`, `user_id`) VALUES
('LIGHTSOUT1279', 52),
('LIGHTSOUT2557', 52),
('LIGHTSOUT2625', 52),
('LIGHTSOUT2667', 52),
('LIGHTSOUT3878', 52),
('LIGHTSOUT4335', 52),
('LIGHTSOUT5376', 52),
('LIGHTSOUT6760', 52),
('LIGHTSOUT7099', 52),
('LIGHTSOUT7808', 52),
('LIGHTSOUT7853', 52),
('LIGHTSOUT8648', 52);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reference_numbers`
--
ALTER TABLE `reference_numbers`
  ADD UNIQUE KEY `reference_number_UNIQUE` (`reference_number`),
  ADD KEY `fk_reference_numbers_users1_idx` (`user_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reference_numbers`
--
ALTER TABLE `reference_numbers`
  ADD CONSTRAINT `fk_reference_numbers_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
