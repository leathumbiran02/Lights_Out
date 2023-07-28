-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2023 at 05:59 PM
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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int NOT NULL,
  `vendor_id` int NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `long_description` varchar(1000) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image_link` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `vendor_id`, `name`, `long_description`, `price`, `image_link`) VALUES
(1, 1, 'ULTRA LINK 5000MAH POWERBANK Black', 'A slim and stylish portable mini-size charger will ensure that your device is always charged. Designed with a word engraving series - giving your power bank a sophisticated look and feel.Convenient emergency charging on the go for USB devices.Freedom to charge your devices anywhere.5000mAh power capacity ensures super-fast and efficient charging with a 2-amp output. Detachable charge and sync cable for 2 USB devices included.LED lights are installed to indicate when your power bank is charging your device. The perfect companion to ensure your smartphone or tablet has enough charge to power your app usage throughout the day.', '169.00', 'https://www.makro.co.za/sys-master/images/h93/hfa/9442662252574/silo-MIN_374816_EAA_large?quality=432x432'),
(2, 2, 'Xiaomi Power Bank Black', 'The Xiaomi Mi 50W 20000mAh Power Bank is a great way to keep all your mobile devices fully charged. It features a Type-C port for fast charging of your high-power electronic devices, including the latest MacBook Pro, Mi Notebook and Nintendo Switch, making it an effortless solution to your everyday charging needs. The power bank is also able to charge three devices simultaneously with one Type-C port and two USB-A ports.', '1449.00', 'https://www.makro.co.za/sys-master/images/h40/hee/11665036935198/silo-MIN_438135_EAA_large?quality=432x432'),
(3, 3, 'Volkano Powerbank Black VK-9017-BK', 'The Volkano Remus Series is a 30,000mAh Power Bank with a 2-in-1 Fast Charge Cable Included.', '899.00', 'https://www.makro.co.za/sys-master/images/h05/h9c/11665037262878/silo-MIN_452067_EAA_large'),
(4, 1, 'Supafly Power Bank 20000mAh with LCD Display', 'Superfly Power Bank 20000mAh With LCD Display is ideal for use during load-shedding and power outages. It has a dual USB port for simultaneous charging and features a LCD display.', '499.00', 'https://clicks.co.za/medias/?context=bWFzdGVyfHByb2R1Y3QtaW1hZ2VzfDczNDI1fGltYWdlL2pwZWd8aDkyL2g3YS8xMDY4NTQ4MjI3MDc1MHwzYzAzNjMzY2U5NTFhOWNhYmIwMWQyNjYxZjRlOGM4ZDExOTI4ZGY5YzE0NTFkYWJkZTA3MzcyZTVhMWFjNWRk'),
(5, 2, 'RED - E 10000mAh Compact Power Bank RC10', 'Capacity 10 000mAh.\r\nInput Up to 5V 2A.\r\nOutput dual 2A 5V.\r\n2 Outputs for charging 2 devices.\r\nPolymer battery for safety.\r\nLED indicator lights.\r\nNet Weight 197g.\r\n12 months warranty.', '399.00', 'https://www.incredible.co.za/media/catalog/product/cache/9fb3f461bc58409e8e845998d2286ec9/1/0/10113111_inc_68bf.jpg'),
(9, 3, 'DewHot Constant Temperature Gas Geyser 12 L', 'Introducing the 12L DewHot Constant Temperature unit; the battery ignition means that you will always have hot water - even during power outages! This smart geyser adjusts itself to the water flow, meaning that regardless of how many outlets are running simultaneously (up to a maximum of 12L), your water temperature simply won\'t run cold.', '6374.00', 'https://cdn.shopify.com/s/files/1/0885/5388/products/ND12CTDH_540x.jpg?v=1677059881'),
(10, 2, 'Outdoor Solar Light RGB Light 4-Pack', 'These solar lights are mainly used outdoors, such as in the garden, pathway, deck, sidewalk, campsites and swimming pools. It has high-quality lamp beads and provides a wide range of lighting.', '600.00', 'https://www.makro.co.za/sys-master/images/hda/h4f/12196887330846/f9d3e83a-2ec1-4454-86d2-9eb03f2a3314-qpn13_large'),
(11, 2, 'Ryobi 650 W 2-Stroke Petrol Generator', 'Model: RG-950.\r\nSize: 650 W 2-Stroke.\r\nService Guarantee: 2 year guarantee.', '2499.00', 'https://www.makro.co.za/sys-master/images/h6e/h70/10081783775262/silo-MIN_126171_EAA_large?quality=432x432'),
(12, 3, 'Ryobi 2.5 kVA Pull-Start Petrol Generator', 'Model: RG-2700.\r\nSize: 2.5 kVA.\r\nService Guarantee: 2 year guarantee.', '5999.00', 'https://www.makro.co.za/sys-master/images/he9/h1d/10192750673950/silo-MIN_134128_EAA_large?quality=432x432'),
(13, 2, 'Tomu - Portable Single Burner Gas Stove', 'The Tomu - Portable Single Burner Gas Stove is ideal for tabletop cooking, deck parties and camping.\r\nThe butane gas loads instantly and safely with one switch.\r\nWith a delicate furnace body and the smooth surface you can easily clean the stove.', '299.00', 'https://www.makro.co.za/sys-master/images/hcc/hca/12262126157854/013f711e-f19f-4ff1-908c-daf17fc22644-qpn13_large?quality=432x432'),
(14, 2, '2 Plate Stainless Steel Gas Stove', 'Independent flame control adjustment knobs. This enables all the burners to be operated independently from one another. Improved burners. Operates from a remote cylinder with a hose and regulator/fitting. The unit fits directly on a 3kg, 5kg or 7kg Cylinder using a hose and regulator (cylinder, regulator & hose not included). In Case of emergency power outages/home use.', '349.00', 'https://www.makro.co.za/sys-master/images/ha1/hed/11799623335966/02742cf0-8a7b-4863-aa3c-c6aee915e242-qpn14_large'),
(15, 1, 'Pentamark 1900DC Generator', 'Features: AC Circuit Breaker. Fuel Tank Capacity: 5L. 4 Stroke, Reed Valve, Forced. Air-cooled, Single Cylinder. Displacement: 89cc 4Stroke.', '3699.00', 'images/products/Pentamark 1900DC Generator.jpg'),
(22, 1, 'Hot Water Bottle with Knitted Cover 2L (3 Pack)', 'Includes: 3 x Hot Water Bottle with Knitted Cover 2L.', '375.00', 'images/products/Hot Water Bottle with Knitted Cover 2L (3 Pack).jpg'),
(23, 1, 'General Hot Water Bottle With Knitted Heart Sleeve 2L', 'With the help of this stylish and practical hot water bottle with a knitted, heart-themed sleeve, you can stay warm on colder days and nights.', '129.99', 'images/products/General Hot Water Bottle With Knitted Heart Sleeve 2L.jpg'),
(27, 1, 'Trade Professional - TP 8000 4S - 7.5kW 16HP 9.4kVA Petrol Gen Set', 'Specifications: Rated AC Output 7,5kw. Max AC Output : 7,0kw. AC Frequency: 50Hz. Rated Voltage: 220V. Start: Recoil / Electric. Fuel Capacity: 25L Continuous Operation Time: ±7H ( On a full tank). 4 Stroke ( Unleaded fuel). For domestic to site use.', '13919.00', 'images/products/Trade Professional - TP 8000 4S - 7.5kW 16HP 9.4kVA Petrol Gen Set.jpg'),
(28, 1, 'Total - Generator Wheeled Power Gasoline Generator - (6,5 Kw)', 'Specifications: Rated voltage (V): 220-240. Rated frequency (Hz): 50. Maximum power (KW): 6,5. Rated power (kW): 5,0. Rated speed (rpm): 3000. Motor: 4 stroke, OHV. Displacement (ml): 420. Cooling system: Air cooled. Ignition system: TCI. Starting system: Recoil and Electric Copper wire alternator. Fuel tank (L): 25. Dry weight (Kg): 80 With auxiliary handle and wheels.', '14249.00', 'images/products/Total - Generator Wheeled Power Gasoline Generator - (6,5 Kw).jpg'),
(29, 1, 'Home Classix Luxurious Plush Covered Hot Water Bottle 2L- Grey', 'What better way to keep warm on a cold winters day, then to use a good old fashioned hot water bottle. The Home Classix Hot water Bottle is covered in an attractive and soft Luxurious Plush cover. Features: Safety warnings on the inner lip of the lid of the bottle. These Home Classix hot water bottles will keep your warm for hours. Only to be used under Adult supervision.', '77.00', 'images/products/Home Classix Luxurious Plush Covered Hot Water Bottle 2L- Grey.jpg'),
(30, 1, 'Home Classix Luxurious Plush Covered Hot Water Bottle 2L- Cream', 'What better way to keep warm on a cold winters day, then to use a good old fashioned hot water bottle. The Home Classix Hot water Bottle is covered in an attractive and soft Luxurious Plush cover. Features: Safety warnings on the inner lip of the lid of the bottle. These Home Classix hot water bottles will keep your warm for hours. Only to be used under Adult supervision.', '69.00', 'images/products/Home Classix Luxurious Plush Covered Hot Water Bottle 2L- Cream.jpg'),
(31, 1, 'Magneto Rechargeable LED Solar Light', 'Advanced solar panel: The Magneto Rechargeable LED Solar is equipped with an advanced crystalline silicon solar panel that absorbs sunlight more effectively to charge the battery, even in low sunlight! 2 Modes: Complete with 2 lighting modes, the Magneto Rechargeable LED Solar provides up to 2 hours of illumination in Ultra-Bright mode and up to 4 hours of illumination in Power-Saver mode. Charge up: The Magneto Rechargeable LED Solar can charge most mobile phones and is easily recharged with any micro USB charger. Accessories included: The Magneto Rechargeable LED Solar also includes a USB charge cable and lanyard.', '189.00', 'images/products/Magneto Rechargeable LED Solar Light.jpg'),
(32, 1, 'Magneto LED Lantern 1000 lumen - 2.0', 'Magneto LED Lantern - 2,0. The Magneto Rechargeable LED Lantern is a powerful 1000 lumen room-filling light. Its perfect for power cuts and switches on automatically as soon as the power goes off if connected to a plug point. Its great for the outdoors, late-night studying or the workshop. Just charge it up and you get 60 hours of light on a single charge. The built-in discharge and overcharge circuits help prevent battery damage.', '289.00', 'images/products/Magneto LED Lantern 1000 lumen - 2.0.jpg'),
(33, 1, 'Switched 30 LED Emergency Light 150 Lumen', 'Specifications: 30 x 2835 smd led panel - 150 lumen. auto power failure detection. brightness: 3w - 150 lumens. battery: 900mah-1ah, 3,7v. operating time: 3 hours on high mode and 6 hours on low mode. recharge time: 15 hours. lifespan: 20 000 hours. built in overcharge protection.', '99.00', 'images/products/Switched 30 LED Emergency Light 150 Lumen.jpg'),
(34, 1, 'Alva - 12l Gas Water Heater', ' Brought to you by ALVA, a long-standing, expert and trusted South African brand. This product requires professional installation by an LPGSASA approved technician. Failure to do so voids the warranty and is illegal. The 12L model is recommended for a single tap sink, bath or basin. This 12L model is best suited for use in a kitchen/bathroom sinks & for showers.', '3999.00', 'images/products/Alva - 12l Gas Water Heater.jpg'),
(35, 1, 'Totai 5L Gas Water Heater', '5 Litres Of Hot Water Per Minute. Suitable For One Basin. +/- 1,26 kg/hr. Includes Flu Pipe.', '3099.00', 'images/products/Totai 5L Gas Water Heater.jpeg'),
(36, 1, 'Black 4 Plate Gas Stove with Fittings & Gas Cylinder - 5kg', 'Notice: Gas cylinder will not include the gas. Manage power outages or cook off-grid with this 4-burner gas stove. The stainless steel top cover is always sparkling and easy to clean. It takes up only a minimum of kitchen space and is ideal for small spaces. Features: - Thick stainless steel surface. - Manual Ignition. - 4 gas burners.- Adjustable Flame Control Knobs. - Burner Dimensions (L 49cm x W49cm x h 8cm).', '1599.00', 'images/products/Black 4 Plate Gas Stove with Fittings & Gas Cylinder - 5kg.jpg'),
(37, 1, 'UPS 8800mAh with POE Support for Wifi Router Camera during Load Shedding', 'UPS 8800mAh for Wifi Router Camera is perfect for power cuts and switches on automatically as soon as the power goes off if connected to a socket. Keep your devices running with this powerful yet compact, 17W multiple voltage UPS. Perfect to keep internet connected or security when you are hit with outages. With over current & short circuit protection, rest easy knowing your power supply is safe and reliable. The conversion to the UPS when the power goes off is instantaneous.', '508.00', 'images/products/UPS 8800mAh with POE Support for Wifi Router Camera during Load Shedding.jpg'),
(38, 1, 'Surge Protector Plug for Fridge - Beat Loadshedding', 'Low power (under-voltage) will certainly damage any compressors of refrigeration appliances. The fridge safe SF-A009F protects your appliance by disconnecting the power when it goes below unacceptable level. Additionally, there is a 3-minute delay when power returns to normal. This will ensure that the appliance is not switched on-off repeatedly during fluctuations nor is it subjected to a massive surge normally experienced when power returns after power cuts.', '249.00', 'images/products/Surge Protector Plug for Fridge - Beat Loadshedding.jpg'),
(39, 1, 'Load shedding Backup 2600mAh Mini, portable DC UPS for Router Modem', 'Description: -Built-in adapter and allows wide AC voltage range 85Vac-265Vac. -Built-in high capacity lithium batteries, provide long backup time to loads. -Suitable for most digital devices. -Power over Ethernet [POE] can transmit the data and power at the same time to simplify the wire set. -5V USB output can provide charging for mobile phone, PSP, PDA, iPod, MP4, etc. -Intelligent circuit design with over-charging, over-discharging, and short circuit protections.', '523.00', 'images/products/Load shedding Backup 2600mAh Mini, portable DC UPS for Router Modem.jpg'),
(40, 1, 'Redisson Rechargeable Soft Tube Table Lamp for Loadshedding', 'The perfect desk light for use during power outages would be equipped with a rechargeable battery, compact and mini design suitable for any situations.', '149.00', 'images/products/Redisson Rechargeable Soft Tube Table Lamp for Loadshedding.jpg'),
(41, 1, 'Pack of 2 - Load Shedding Power Surge Secure Power Protector', 'When you insert the Surge Secure Power Protector SF-A001 plug into the wall socket / multi-plug or extension cord, please switch off the socket first. This plug protects your exposure through the electrical mains only. It does not protect television aerials or phone lines. Provides Power output to a max of 4000W refer to appliance label close to power cables for appliance wattage specification before using this product.', '529.00', 'images/products/Pack of 2 - Load Shedding Power Surge Secure Power Protector.jpg'),
(42, 1, 'UPS for WiFi Router 8800mah - Loadshedding backup with Lithium Batteries', 'Mini DC UPS an uninterruptible power supply for any 5/9/12V device, provides backup power for WiFi routers and other devices. The UPS will automatically switch to battery power, and your device will stay ON without any interruption. Compatible with fibre, LTE and adsl.', '476.00', 'images/products/UPS for WiFi Router 8800mah - Loadshedding backup with Lithium Batteries.jpg'),
(43, 1, 'Gas Heater Small', 'Gas heater with new technology. Save on electricity bill. Beat load shedding. Built in plate to make coffee or boil water.', '604.00', 'images/products/Gas Heater Small.jpg'),
(44, 1, '600W UPS For Office and Home use', 'Intelligent CPU control. Auto restart while AC is recovering. Boost and buck AVR for voltage stabilization. Cold start function. Off-mode charging.', '1949.00', 'images/products/600W UPS For Office and Home use.jpg'),
(45, 1, 'Rechargeable Table Fan', '2 inch Rechargeable Table Fan. Fan Power: 12 Watt. Battery: 2600MAH. Voltage: AC220V/DC12V. Material: Metal with Metal Blades. Charging Time: 3 Hours. Discharging Time: 3 - 5 Hours. Width: 400mm. Height: 370mm. Please Note Solar Panel Is Sold Separately.', '875.00', 'images/products/Rechargeable Table Fan.jpg'),
(46, 1, 'Load shedding Ellies 1440W Inverter with Trolley Modified Sinewave', 'Whats in the box: 1 x Mains power cord. 1 x Steel movable trolley. 1 x 1440W/ 2400VA Power inverter/UPS. 2 x 12V Deep cycle, maintenance-free batteries. 1 x User manual.', '19999.00', 'images/products/Load shedding Ellies 1440W Inverter with Trolley Modified Sinewave.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `fk_products_vendor1_idx` (`vendor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_vendor1` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`vendor_id`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
