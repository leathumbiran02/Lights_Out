-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2023 at 06:21 PM
-- Server version: 8.0.28
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lights_out`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog_post`
--

CREATE TABLE `blog_post` (
  `blog_id` int NOT NULL,
  `vendor_id` int NOT NULL,
  `title` varchar(250) DEFAULT NULL,
  `blog_url` varchar(500) DEFAULT NULL,
  `image_link` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `blog_post`
--

INSERT INTO `blog_post` (`blog_id`, `vendor_id`, `title`, `blog_url`, `image_link`) VALUES
(1, 1, 'Load Shedding: What to Expect & How to Prepare ', 'https://alumo.co.za/articles/load-shedding-what-to-expect-how-to-prepare', 'images/blogs/alumo.png'),
(2, 1, 'Surviving load shedding during winter', 'https://blog.rawson.co.za/surviving-load-shedding-during-winter', 'images/blogs/rawson.png'),
(4, 1, 'How to loadshedding proof your home (and stay entertained)', 'https://blog.seeff.com/loadshedding-proof-your-home', 'images/blogs/seeff.png'),
(5, 1, 'Everything You Need To Survive Loadshedding', 'https://www.mhcworld.co.za/blogs/news/everything-you-need-to-survive-loadshedding', 'images/blogs/mhc.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog_post`
--
ALTER TABLE `blog_post`
  ADD PRIMARY KEY (`blog_id`),
  ADD KEY `fk_blog_post_vendor1_idx` (`vendor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog_post`
--
ALTER TABLE `blog_post`
  MODIFY `blog_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog_post`
--
ALTER TABLE `blog_post`
  ADD CONSTRAINT `fk_blog_post_vendor1` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`vendor_id`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
