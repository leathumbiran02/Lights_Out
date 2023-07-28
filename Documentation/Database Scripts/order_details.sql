-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 06, 2023 at 08:26 PM
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
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `order_details_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_name` varchar(250) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_details_id`, `order_id`, `product_name`, `quantity`, `price`) VALUES
(113, 79, 'General Hot Water Bottle With Knitted Heart Sleeve 2L', 1, 129.99),
(114, 80, '2 Plate Stainless Steel Gas Stove', 1, 349.00),
(115, 80, 'ULTRA LINK 5000MAH POWERBANK Black', 5, 169.00),
(116, 80, 'Ryobi 2.5 kVA Pull-Start Petrol Generator', 1, 5999.00),
(118, 82, 'Xiaomi Power Bank Black', 1, 1449.00),
(119, 82, 'General Hot Water Bottle With Knitted Heart Sleeve 2L', 1, 129.99),
(120, 82, 'Rubber Hot Water Bottle - RED', 1, 99.00),
(121, 83, 'General Hot Water Bottle With Knitted Heart Sleeve 2L', 1, 129.99),
(122, 83, 'Tomu - Portable Single Burner Gas Stove', 1, 299.00),
(123, 84, 'General Hot Water Bottle With Knitted Heart Sleeve 2L', 1, 129.99),
(124, 84, 'Rubber Hot Water Bottle - RED', 3, 99.00),
(125, 84, 'DewHot Constant Temperature Gas Geyser 12 L', 1, 6374.00),
(126, 85, 'ULTRA LINK 5000MAH POWERBANK Black', 1, 169.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_details_id`),
  ADD KEY `fk_order_details_orders1_idx` (`order_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `fk_order_details_orders1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
