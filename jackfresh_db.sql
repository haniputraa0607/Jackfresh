-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 28, 2023 at 04:53 PM
-- Server version: 8.0.21
-- PHP Version: 7.3.24-(to be removed in future macOS)

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jackfresh_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id_client` int NOT NULL,
  `client_code` varchar(45) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `client_type` enum('Restaurant','Hotel','Personal') NOT NULL,
  `client_address` text,
  `client_phone` varchar(40) NOT NULL,
  `client_email` varchar(255) DEFAULT NULL,
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id_client`, `client_code`, `client_name`, `client_type`, `client_address`, `client_phone`, `client_email`, `notes`) VALUES
(4, 'RST-1', 'Resto 12', 'Restaurant', 'Solo asdasd', '081923123', 'resto@gmail.com', 'asd       '),
(5, 'KDI', 'Kedai 21', 'Restaurant', 'e', '09123123123', 'kedai@gmail.com', 'e'),
(6, '003', 'Soto Sore', 'Restaurant', 'dfsdf sdfsdf s', '081081081081', 'soto@gmail.com', 'aa'),
(7, '004', 'Hotel Surya', 'Hotel', 'asd asdasda', '091039024359', '', 'asasd'),
(8, '005', 'Star Hotel', 'Hotel', 'dfsd sdfs d', '01382340923', '', 'sd fsd');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id_product` int NOT NULL,
  `product_code` varchar(45) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `is_active` tinyint NOT NULL DEFAULT '0',
  `product_photo` varchar(450) DEFAULT NULL,
  `product_visibility` enum('Visible','Hidden') NOT NULL,
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id_product`, `product_code`, `product_name`, `is_active`, `product_photo`, `product_visibility`, `notes`) VALUES
(2, 'SBN-01', 'Sabun', 1, 'assets/img/product/Sabun_Coli.png', 'Visible', 'ya'),
(4, 'SKT-01', 'Sikat Gigi', 1, NULL, 'Visible', 'tes'),
(8, 'SLD-01', 'Selada', 1, NULL, 'Visible', ''),
(9, 'KBS-01', 'Kobis', 1, NULL, 'Visible', 'kubis putih'),
(10, 'CB-1', 'Cabe Merah', 1, NULL, 'Visible', ''),
(11, 'TLR-01', 'Telur Ayam', 1, NULL, 'Visible', ''),
(12, 'TLR-02', 'Telur Bebek', 1, NULL, 'Visible', ''),
(13, 'BR-01', 'Brokoli', 1, NULL, 'Visible', ''),
(14, 'KT-01', 'Kentang', 1, NULL, 'Visible', '');

-- --------------------------------------------------------

--
-- Table structure for table `product_units`
--

CREATE TABLE `product_units` (
  `id_product_unit` int NOT NULL,
  `id_product` int NOT NULL,
  `id_unit` int NOT NULL,
  `pricecash` int NOT NULL,
  `pricetempo` int NOT NULL,
  `stock` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_units`
--

INSERT INTO `product_units` (`id_product_unit`, `id_product`, `id_unit`, `pricecash`, `pricetempo`, `stock`) VALUES
(4, 2, 2, 40000, 50000, 0),
(11, 4, 2, 20000, 30000, 3),
(12, 2, 5, 20000, 30000, 4),
(13, 8, 6, 4000, 6000, 0),
(14, 9, 6, 6000, 7500, 8),
(15, 10, 6, 45000, 55000, 5),
(16, 11, 6, 27000, 33000, 6),
(17, 13, 6, 9000, 11000, 1),
(18, 14, 6, 7000, 9000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_unit_conversions`
--

CREATE TABLE `product_unit_conversions` (
  `id_product_unit_conversion` int NOT NULL,
  `id_product_unit_1` int NOT NULL,
  `id_product_unit_2` int NOT NULL,
  `conversion` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `id_purchase` int NOT NULL,
  `id_client` int DEFAULT NULL,
  `purchase_code` varchar(40) NOT NULL,
  `purchase_date` datetime NOT NULL,
  `payment_type` enum('Cash','Tempo') NOT NULL DEFAULT 'Cash',
  `status` enum('Pending','Process','Finished') NOT NULL,
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`id_purchase`, `id_client`, `purchase_code`, `purchase_date`, `payment_type`, `status`, `notes`) VALUES
(8, 4, 'TES-2', '2023-01-28 00:00:00', 'Cash', 'Finished', 'te'),
(17, 5, 'TES 2', '2023-01-30 00:00:00', 'Cash', 'Finished', 'tes'),
(18, 4, 'PR-0603-0009', '2023-03-08 00:00:00', 'Tempo', 'Finished', 'tes'),
(19, 4, 'PR-0603-0009', '2023-03-15 00:00:00', 'Tempo', 'Finished', 'tes'),
(20, 4, 'PR-0603-0009', '2023-03-07 00:00:00', 'Cash', 'Finished', 'tes'),
(22, 6, 'PR-2403-0009', '2023-03-24 00:00:00', 'Cash', 'Finished', 'aaa'),
(23, 7, 'PR-2403-0009', '2023-03-24 00:00:00', 'Tempo', 'Finished', 'sasa'),
(24, 8, 'PR-2403-0009', '2023-03-24 00:00:00', 'Tempo', 'Finished', 'sd'),
(25, 5, 'PR-2403-0009', '2023-03-25 00:00:00', 'Cash', 'Finished', 'sss'),
(26, 4, 'PR-2403-0009', '2023-03-25 00:00:00', 'Tempo', 'Finished', 'sdfsd'),
(27, 6, 'PR-2403-0009', '2023-03-25 00:00:00', 'Cash', 'Finished', 'asa'),
(28, 8, 'PR-2403-0009', '2023-03-25 00:00:00', 'Tempo', 'Finished', 'aaa'),
(29, 7, 'PR-2403-0009', '2023-03-26 00:00:00', 'Tempo', 'Finished', 'ghg'),
(30, 5, 'PR-2403-0009', '2023-03-26 00:00:00', 'Cash', 'Finished', 'ffff'),
(31, 4, 'PR-2403-0009', '2023-03-26 00:00:00', 'Cash', 'Finished', 'ggg'),
(32, 4, 'PR-1404-0009', '2023-04-14 00:00:00', 'Cash', 'Pending', 'tes'),
(33, 4, 'PR-1404-0009', '2023-04-14 00:00:00', 'Cash', 'Finished', 'tes');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_product_units`
--

CREATE TABLE `purchase_product_units` (
  `id_purchase_product_unit` int NOT NULL,
  `id_purchase` int NOT NULL,
  `id_product_unit` int NOT NULL,
  `qty` float NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `purchase_product_units`
--

INSERT INTO `purchase_product_units` (`id_purchase_product_unit`, `id_purchase`, `id_product_unit`, `qty`, `status`) VALUES
(62, 18, 4, 1, 1),
(63, 18, 11, 1, 1),
(64, 18, 12, 3, 1),
(69, 19, 4, 4, 1),
(72, 20, 4, 5, 1),
(73, 20, 11, 5, 1),
(76, 17, 4, 9, 1),
(77, 17, 12, 1, 1),
(78, 17, 11, 2, 1),
(79, 8, 4, 6, 1),
(80, 8, 11, 1, 1),
(98, 22, 13, 5, 1),
(99, 22, 18, 3, 1),
(100, 23, 12, 20, 1),
(101, 23, 14, 6, 1),
(102, 23, 16, 5, 1),
(103, 24, 11, 3, 1),
(104, 24, 15, 4, 1),
(105, 24, 14, 6, 1),
(106, 25, 14, 3, 1),
(107, 25, 16, 5, 1),
(108, 25, 17, 4, 1),
(109, 26, 14, 7, 1),
(110, 26, 13, 8, 1),
(111, 26, 15, 3, 1),
(137, 28, 12, 15, 1),
(138, 28, 16, 5, 1),
(139, 28, 17, 7, 1),
(140, 28, 14, 3, 1),
(141, 27, 13, 3, 1),
(142, 27, 15, 7, 1),
(143, 27, 18, 5, 1),
(152, 29, 11, 5, 1),
(153, 29, 18, 4, 1),
(154, 29, 16, 7, 1),
(155, 29, 14, 5, 1),
(156, 30, 13, 6, 1),
(157, 30, 14, 6, 1),
(158, 30, 16, 2, 1),
(159, 30, 17, 2, 1),
(160, 31, 15, 5, 1),
(161, 31, 14, 6, 1),
(162, 32, 4, 5, 0),
(163, 32, 11, 8, 0),
(164, 32, 13, 6, 0),
(165, 33, 13, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id_transaction` int NOT NULL,
  `id_client` int DEFAULT NULL,
  `id_purchase` int DEFAULT NULL,
  `transaction_code` varchar(40) NOT NULL,
  `transaction_date` datetime NOT NULL,
  `payment_type` enum('Cash','Tempo') NOT NULL DEFAULT 'Cash',
  `grand_total` int NOT NULL,
  `status` enum('Pending','Process','Finished') NOT NULL,
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id_transaction`, `id_client`, `id_purchase`, `transaction_code`, `transaction_date`, `payment_type`, `grand_total`, `status`, `notes`) VALUES
(40, 4, NULL, 'TR-0603-0038', '2023-03-07 02:14:36', 'Cash', 120000, 'Finished', 'tes'),
(41, 4, NULL, 'TR-0603-0041', '2023-03-07 00:00:00', 'Tempo', 170000, 'Finished', 'tes'),
(42, 4, NULL, 'PR-0603-0009', '2023-03-08 00:00:00', 'Tempo', 170000, 'Finished', 'tes'),
(43, 4, NULL, 'PR-0603-0009', '2023-03-15 00:00:00', 'Tempo', 200000, 'Finished', 'tes'),
(44, 4, NULL, 'PR-0603-0009', '2023-03-07 00:00:00', 'Cash', 300000, 'Finished', 'tes'),
(47, 6, NULL, 'PR-2403-0009', '2023-03-24 00:00:00', 'Cash', 41000, 'Finished', 'aaa'),
(48, 7, NULL, 'PR-2403-0009', '2023-03-24 00:00:00', 'Tempo', 810000, 'Finished', 'sasa'),
(49, 8, NULL, 'PR-2403-0009', '2023-03-24 00:00:00', 'Tempo', 355000, 'Finished', 'sd'),
(50, 5, NULL, 'PR-2403-0009', '2023-03-25 00:00:00', 'Cash', 189000, 'Finished', 'sss'),
(51, 4, NULL, 'PR-2403-0009', '2023-03-25 00:00:00', 'Tempo', 265500, 'Finished', 'sdfsd'),
(52, 8, NULL, 'PR-2403-0009', '2023-03-25 00:00:00', 'Tempo', 714500, 'Finished', 'aaa'),
(53, 6, NULL, 'PR-2403-0009', '2023-03-25 00:00:00', 'Cash', 362000, 'Finished', 'asa'),
(54, 7, NULL, 'PR-2403-0009', '2023-03-26 00:00:00', 'Tempo', 454500, 'Finished', 'ghg'),
(55, 5, NULL, 'PR-2403-0009', '2023-03-26 00:00:00', 'Cash', 132000, 'Finished', 'ffff'),
(56, 4, NULL, 'PR-2403-0009', '2023-03-26 00:00:00', 'Cash', 261000, 'Finished', 'ggg'),
(57, 4, NULL, 'PR-1404-0009', '2023-04-14 00:00:00', 'Cash', 4000, 'Finished', 'tes'),
(60, 8, NULL, 'TR-1404-0058', '2023-04-14 00:00:00', 'Cash', 20000, 'Finished', '1');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_product_units`
--

CREATE TABLE `transaction_product_units` (
  `id_transaction_product_unit` int NOT NULL,
  `id_transaction` int NOT NULL,
  `id_product_unit` int NOT NULL,
  `qty` float NOT NULL,
  `price` int NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `transaction_product_units`
--

INSERT INTO `transaction_product_units` (`id_transaction_product_unit`, `id_transaction`, `id_product_unit`, `qty`, `price`, `status`) VALUES
(20, 40, 4, 1, 40000, 1),
(21, 40, 11, 1, 20000, 1),
(22, 40, 12, 3, 60000, 1),
(23, 41, 4, 1, 50000, 1),
(24, 41, 12, 3, 90000, 1),
(25, 41, 11, 1, 30000, 1),
(26, 42, 4, 1, 50000, 1),
(27, 42, 11, 1, 30000, 1),
(28, 42, 12, 3, 90000, 1),
(29, 43, 4, 4, 200000, 1),
(30, 44, 4, 5, 200000, 1),
(31, 44, 11, 5, 100000, 1),
(37, 47, 13, 5, 20000, 1),
(38, 47, 18, 3, 21000, 1),
(39, 48, 12, 20, 600000, 1),
(40, 48, 14, 6, 45000, 1),
(41, 48, 16, 5, 165000, 1),
(42, 49, 11, 3, 90000, 1),
(43, 49, 15, 4, 220000, 1),
(44, 49, 14, 6, 45000, 1),
(45, 50, 14, 3, 18000, 1),
(46, 50, 16, 5, 135000, 1),
(47, 50, 17, 4, 36000, 1),
(48, 51, 14, 7, 52500, 1),
(49, 51, 13, 8, 48000, 1),
(50, 51, 15, 3, 165000, 1),
(51, 52, 12, 15, 450000, 1),
(52, 52, 16, 5, 165000, 1),
(53, 52, 17, 7, 77000, 1),
(54, 52, 14, 3, 22500, 1),
(55, 53, 13, 3, 12000, 1),
(56, 53, 15, 7, 315000, 1),
(57, 53, 18, 5, 35000, 1),
(58, 54, 11, 5, 150000, 1),
(59, 54, 18, 4, 36000, 1),
(60, 54, 16, 7, 231000, 1),
(61, 54, 14, 5, 37500, 1),
(62, 55, 13, 6, 24000, 1),
(63, 55, 14, 6, 36000, 1),
(64, 55, 16, 2, 54000, 1),
(65, 55, 17, 2, 18000, 1),
(66, 56, 15, 5, 225000, 1),
(67, 56, 14, 6, 36000, 1),
(68, 57, 13, 1, 4000, 1),
(69, 60, 12, 1, 20000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id_unit` int NOT NULL,
  `unit_name` varchar(45) NOT NULL,
  `unit_visibility` enum('Visible','Hidden') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id_unit`, `unit_name`, `unit_visibility`) VALUES
(2, 'Lusin', 'Hidden'),
(5, 'PCS', 'Visible'),
(6, 'Kg', 'Visible');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(10) NOT NULL,
  `is_admin` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `name`, `username`, `password`, `is_admin`) VALUES
(1, 'Hanif Murtadha Tsaniputra', 'haniputraa', '12345', 1),
(2, 'Vigar Zagallo', 'vigar', '1234', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id_client`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id_product`);

--
-- Indexes for table `product_units`
--
ALTER TABLE `product_units`
  ADD PRIMARY KEY (`id_product_unit`),
  ADD KEY `fk_product` (`id_product`),
  ADD KEY `fk_unit` (`id_unit`);

--
-- Indexes for table `product_unit_conversions`
--
ALTER TABLE `product_unit_conversions`
  ADD PRIMARY KEY (`id_product_unit_conversion`),
  ADD KEY `fk_product_unit_conversion_1` (`id_product_unit_1`),
  ADD KEY `fk_product_unit_conversion_2` (`id_product_unit_2`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`id_purchase`),
  ADD KEY `fk_purchase_client` (`id_client`);

--
-- Indexes for table `purchase_product_units`
--
ALTER TABLE `purchase_product_units`
  ADD PRIMARY KEY (`id_purchase_product_unit`),
  ADD KEY `fk_product_unit` (`id_product_unit`),
  ADD KEY `fk_purchase` (`id_purchase`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id_transaction`),
  ADD KEY `fk_transaction_client` (`id_client`),
  ADD KEY `fk_transaction_purchase` (`id_purchase`);

--
-- Indexes for table `transaction_product_units`
--
ALTER TABLE `transaction_product_units`
  ADD PRIMARY KEY (`id_transaction_product_unit`),
  ADD KEY `fk_transaction` (`id_transaction`),
  ADD KEY `fk_transaction_product` (`id_product_unit`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id_unit`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id_client` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id_product` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `product_units`
--
ALTER TABLE `product_units`
  MODIFY `id_product_unit` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `product_unit_conversions`
--
ALTER TABLE `product_unit_conversions`
  MODIFY `id_product_unit_conversion` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `id_purchase` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `purchase_product_units`
--
ALTER TABLE `purchase_product_units`
  MODIFY `id_purchase_product_unit` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id_transaction` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `transaction_product_units`
--
ALTER TABLE `transaction_product_units`
  MODIFY `id_transaction_product_unit` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id_unit` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product_units`
--
ALTER TABLE `product_units`
  ADD CONSTRAINT `fk_product` FOREIGN KEY (`id_product`) REFERENCES `products` (`id_product`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_unit` FOREIGN KEY (`id_unit`) REFERENCES `units` (`id_unit`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_unit_conversions`
--
ALTER TABLE `product_unit_conversions`
  ADD CONSTRAINT `fk_product_unit_conversion_1` FOREIGN KEY (`id_product_unit_1`) REFERENCES `product_units` (`id_product_unit`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_unit_conversion_2` FOREIGN KEY (`id_product_unit_2`) REFERENCES `product_units` (`id_product_unit`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase`
--
ALTER TABLE `purchase`
  ADD CONSTRAINT `fk_purchase_client` FOREIGN KEY (`id_client`) REFERENCES `clients` (`id_client`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase_product_units`
--
ALTER TABLE `purchase_product_units`
  ADD CONSTRAINT `fk_product_unit` FOREIGN KEY (`id_product_unit`) REFERENCES `product_units` (`id_product_unit`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_purchase` FOREIGN KEY (`id_purchase`) REFERENCES `purchase` (`id_purchase`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `fk_transaction_client` FOREIGN KEY (`id_client`) REFERENCES `clients` (`id_client`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_transaction_purchase` FOREIGN KEY (`id_purchase`) REFERENCES `purchase` (`id_purchase`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaction_product_units`
--
ALTER TABLE `transaction_product_units`
  ADD CONSTRAINT `fk_transaction` FOREIGN KEY (`id_transaction`) REFERENCES `transactions` (`id_transaction`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_transaction_product` FOREIGN KEY (`id_product_unit`) REFERENCES `product_units` (`id_product_unit`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
