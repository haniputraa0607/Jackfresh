-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 06, 2023 at 05:51 PM
-- Server version: 8.0.21
-- PHP Version: 7.3.24-(to be removed in future macOS)

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

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
  `client_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id_client`, `client_code`, `client_name`, `client_type`, `client_address`, `client_phone`, `client_email`, `notes`) VALUES
(4, 'RST-1', 'Resto 12', 'Restaurant', 'Solo asdasd', '081923123', 'resto@gmail.com', 'asd       '),
(5, 'KDI', 'Kedai 21', '', 'e', '09123123123', 'kedai@gmail.com', 'e');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id_product` int NOT NULL,
  `product_code` varchar(45) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `is_active` tinyint NOT NULL DEFAULT '0',
  `product_photo` varchar(450) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `product_visibility` enum('Visible','Hidden') NOT NULL,
  `notes` text CHARACTER SET utf8 COLLATE utf8_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id_product`, `product_code`, `product_name`, `is_active`, `product_photo`, `product_visibility`, `notes`) VALUES
(2, 'SBN-01', 'Sabun', 1, 'assets/img/product/Sabun_Coli.png', 'Visible', 'ya'),
(4, 'SKT-01', 'Sikat Gigi', 1, NULL, 'Visible', 'tes');

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
  `stock` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `product_units`
--

INSERT INTO `product_units` (`id_product_unit`, `id_product`, `id_unit`, `pricecash`, `pricetempo`, `stock`) VALUES
(4, 2, 2, 40000, 50000, 2),
(11, 4, 2, 20000, 30000, 3),
(12, 2, 5, 20000, 30000, 3);

-- --------------------------------------------------------

--
-- Table structure for table `product_unit_conversions`
--

CREATE TABLE `product_unit_conversions` (
  `id_product_unit_conversion` int NOT NULL,
  `id_product_unit_1` int NOT NULL,
  `id_product_unit_2` int NOT NULL,
  `conversion` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `id_purchase` int NOT NULL,
  `id_client` int DEFAULT NULL,
  `purchase_code` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `purchase_date` datetime NOT NULL,
  `payment_type` enum('Cash','Tempo') NOT NULL DEFAULT 'Cash',
  `status` enum('Pending','Process','Finished') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `notes` text CHARACTER SET utf8 COLLATE utf8_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`id_purchase`, `id_client`, `purchase_code`, `purchase_date`, `payment_type`, `status`, `notes`) VALUES
(8, 4, 'TES-2', '2023-01-28 21:07:57', 'Cash', 'Pending', 'te'),
(17, 5, 'TES 2', '2023-01-30 00:00:00', 'Cash', 'Process', 'tes'),
(18, 4, 'PR-0603-0009', '2023-03-08 00:00:00', 'Tempo', 'Finished', 'tes'),
(19, 4, 'PR-0603-0009', '2023-03-15 00:00:00', 'Tempo', 'Finished', 'tes'),
(20, 4, 'PR-0603-0009', '2023-03-07 00:00:00', 'Cash', 'Pending', 'tes');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_product_units`
--

CREATE TABLE `purchase_product_units` (
  `id_purchase_product_unit` int NOT NULL,
  `id_purchase` int NOT NULL,
  `id_product_unit` int NOT NULL,
  `qty` int NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `purchase_product_units`
--

INSERT INTO `purchase_product_units` (`id_purchase_product_unit`, `id_purchase`, `id_product_unit`, `qty`, `status`) VALUES
(53, 8, 4, 6, 0),
(54, 8, 11, 8, 0),
(55, 8, 12, 20, 0),
(56, 17, 4, 9, 0),
(57, 17, 11, 2, 1),
(58, 17, 12, 1, 1),
(62, 18, 4, 1, 1),
(63, 18, 11, 1, 1),
(64, 18, 12, 3, 1),
(69, 19, 4, 4, 1),
(70, 20, 4, 5, 0),
(71, 20, 11, 10, 0);

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
  `payment_type` enum('Cash','Tempo') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'Cash',
  `grand_total` int NOT NULL,
  `status` enum('Pending','Process','Finished') NOT NULL,
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id_transaction`, `id_client`, `id_purchase`, `transaction_code`, `transaction_date`, `payment_type`, `grand_total`, `status`, `notes`) VALUES
(32, 4, NULL, 'TES-1', '2022-12-10 00:00:00', 'Cash', 120000, 'Finished', 'tes'),
(35, 4, NULL, 'TES-4', '2022-12-24 00:00:00', 'Cash', 120000, 'Finished', 'tes'),
(36, 4, NULL, 'TES-5', '2022-12-31 00:00:00', 'Cash', 100000, 'Finished', 'ffe'),
(37, 4, NULL, 'new januari', '2023-01-24 00:00:00', 'Cash', 120000, 'Finished', 'tes'),
(40, 4, NULL, 'TR-0603-0038', '2023-03-07 00:00:00', 'Cash', 120000, 'Finished', 'tes'),
(41, 4, NULL, 'TR-0603-0041', '2023-03-07 00:00:00', 'Tempo', 170000, 'Finished', 'tes'),
(42, 4, NULL, 'PR-0603-0009', '2023-03-08 00:00:00', 'Tempo', 170000, 'Finished', 'tes'),
(43, 4, NULL, 'PR-0603-0009', '2023-03-15 00:00:00', 'Tempo', 200000, 'Finished', 'tes');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_product_units`
--

CREATE TABLE `transaction_product_units` (
  `id_transaction_product_unit` int NOT NULL,
  `id_transaction` int NOT NULL,
  `id_product_unit` int NOT NULL,
  `qty` int NOT NULL,
  `price` int NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `transaction_product_units`
--

INSERT INTO `transaction_product_units` (`id_transaction_product_unit`, `id_transaction`, `id_product_unit`, `qty`, `price`, `status`) VALUES
(10, 32, 11, 2, 40000, 1),
(11, 32, 4, 2, 80000, 1),
(14, 35, 4, 2, 80000, 1),
(15, 35, 11, 2, 40000, 1),
(16, 36, 11, 1, 20000, 1),
(17, 36, 4, 2, 80000, 1),
(18, 37, 4, 2, 80000, 1),
(19, 37, 11, 2, 40000, 1),
(20, 40, 4, 1, 40000, 1),
(21, 40, 11, 1, 20000, 1),
(22, 40, 12, 3, 60000, 1),
(23, 41, 4, 1, 50000, 1),
(24, 41, 12, 3, 90000, 1),
(25, 41, 11, 1, 30000, 1),
(26, 42, 4, 1, 50000, 1),
(27, 42, 11, 1, 30000, 1),
(28, 42, 12, 3, 90000, 1),
(29, 43, 4, 4, 200000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id_unit` int NOT NULL,
  `unit_name` varchar(45) NOT NULL,
  `unit_visibility` enum('Visible','Hidden') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id_unit`, `unit_name`, `unit_visibility`) VALUES
(2, 'Lusin', 'Hidden'),
(5, 'PCS', 'Visible');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(10) NOT NULL,
  `is_admin` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `name`, `username`, `password`, `is_admin`) VALUES
(1, 'Hanif Murtadha Tsaniputra', 'haniputraa', '12345', 1);

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
  MODIFY `id_client` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id_product` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product_units`
--
ALTER TABLE `product_units`
  MODIFY `id_product_unit` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `product_unit_conversions`
--
ALTER TABLE `product_unit_conversions`
  MODIFY `id_product_unit_conversion` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `id_purchase` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `purchase_product_units`
--
ALTER TABLE `purchase_product_units`
  MODIFY `id_purchase_product_unit` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id_transaction` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `transaction_product_units`
--
ALTER TABLE `transaction_product_units`
  MODIFY `id_transaction_product_unit` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id_unit` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
