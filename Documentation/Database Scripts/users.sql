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
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(250) DEFAULT NULL,
  `last_name` varchar(250) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `password`) VALUES
(1, 'Leigh', 'Johnson', 'leigh@gmail.com', '$2y$10$VcdG97NSTXZQPyUsXaDuF.weTXxcn6X0a0w4CKOXHRjvP08aSF71q'),
(29, 'Baviska', 'Reddy', 'baviskareddy@gmail.com', '$2y$10$H6PIeOYFyxV89moz9q2Ip.ZAvdcjTDR/i5MenslpsMm4qedLYFOX6'),
(30, 'Dylan', 'Smith', 'dylansmith@gmail.com', '$2y$10$fL.G4ds5JRbNtLP7NoYf.O.MbwwnRvWfT51N/uHfXdC2zJqMbP8S2'),
(31, 'Kim', 'Williams', 'kimwilliams@gmail.com', '$2y$10$PQG9Gs0gZ8HfIqI7tSnd9.GAq8kqWvr0LAZtVAynptPuQ6gyd98i2'),
(33, 'Zack', 'Coetzee', 'zackcoetzee@gmail.com', '$2y$10$7Sa1xm4jLCZrnc1B1h8eeuX2mYqPEzL9s.VDeDGKq5/4eNu0jMwLm'),
(36, 'Liveshnee', 'Thumbiran', 'liveshnee@gmail.com', '$2y$10$G9uPCQk51eltvz520vw6Xe0nypUZoISsVosblyZPdKih6Pf.ISWQa'),
(52, 'Lea', 'Thumbiran', 'leathumbiran@gmail.com', '$2y$10$frtmIUQO1rldzPbpSfrXB.5//FQ0GD53yMQrgJJZi3Gg.T7Pn0Da6'),
(53, 'Ahmed', 'Samy', 'ahmednsamyqaz@gmail.com', '$2y$10$uRmd3sh0DX68JsC4zz99ne4mJYeMAttji1DsOMFppHvTkeGJwhvQG');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
