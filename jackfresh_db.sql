-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 18, 2022 at 03:39 PM
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
  `client_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id_client`, `client_code`, `client_name`, `client_type`, `client_address`, `client_phone`, `client_email`, `notes`) VALUES
(1, 'HTL-01', 'Hotel Buana', 'Hotel', 'Solo', '0819231123', 'buana@gmail.com', 'tes'),
(2, 'RST-01', 'Resto Mantap', 'Restaurant', 'Sukoharjo', '089231232', 'mantap@gmail.com', 'tes2');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id_product` int NOT NULL,
  `product_code` varchar(45) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `is_active` tinyint NOT NULL DEFAULT '0',
  `product_photo` varchar(450) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `product_visibility` enum('Visible','Hidden') NOT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id_product`, `product_code`, `product_name`, `is_active`, `product_photo`, `product_visibility`, `notes`) VALUES
(1, 'SMP-1', 'Shampo', 1, NULL, 'Visible', 'tes'),
(2, 'SBN-1', 'Sabun', 1, NULL, 'Visible', 'tes'),
(4, 'SKT-01', 'Sikat Gigi', 1, NULL, 'Visible', 'tes');

-- --------------------------------------------------------

--
-- Table structure for table `product_units`
--

CREATE TABLE `product_units` (
  `id_product_unit` int NOT NULL,
  `id_product` int NOT NULL,
  `id_unit` int NOT NULL,
  `qty` int NOT NULL,
  `price` int NOT NULL,
  `stock` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_units`
--

INSERT INTO `product_units` (`id_product_unit`, `id_product`, `id_unit`, `qty`, `price`, `stock`) VALUES
(1, 1, 2, 5, 30000, 40),
(2, 1, 1, 40, 5000, 20),
(3, 2, 1, 40, 6000, 10);

-- --------------------------------------------------------

--
-- Table structure for table `product_unit_conversions`
--

CREATE TABLE `product_unit_conversions` (
  `id_product_unit_conversion` int NOT NULL,
  `id_product_unit_1` int NOT NULL,
  `id_product_unit_2` int NOT NULL,
  `conversion` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `id_purchase` int NOT NULL,
  `id_client` int DEFAULT NULL,
  `purchase_code` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `purchase_date` datetime NOT NULL,
  `status` enum('Pending','Process','Finished') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`id_purchase`, `id_client`, `purchase_code`, `purchase_date`, `status`, `notes`) VALUES
(1, 2, 'PUR-1', '2022-09-25 00:00:00', 'Pending', 'tes'),
(2, NULL, 'PUR-2', '2022-09-25 00:00:00', 'Pending', 'tes');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `purchase_product_units`
--

INSERT INTO `purchase_product_units` (`id_purchase_product_unit`, `id_purchase`, `id_product_unit`, `qty`, `status`) VALUES
(1, 1, 2, 2, 0),
(2, 1, 1, 3, 0),
(3, 2, 2, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id_transaction` int NOT NULL,
  `id_client` int DEFAULT NULL,
  `id_invoice` int DEFAULT NULL,
  `transaction_code` varchar(40) NOT NULL,
  `transaction_date` datetime NOT NULL,
  `grand_total` int NOT NULL,
  `status` enum('Pending','Process','Finished') NOT NULL,
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id_transaction`, `id_client`, `id_invoice`, `transaction_code`, `transaction_date`, `grand_total`, `status`, `notes`) VALUES
(1, 2, NULL, 'TRAN-1', '2022-09-25 00:00:00', 50000, 'Pending', 'tes'),
(2, 2, 1, 'TRAN-2', '2022-09-25 00:00:00', 50000, 'Pending', 'tes');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaction_product_units`
--

INSERT INTO `transaction_product_units` (`id_transaction_product_unit`, `id_transaction`, `id_product_unit`, `qty`, `price`, `status`) VALUES
(1, 2, 2, 2, 40000, 0),
(2, 2, 1, 3, 40000, 0),
(3, 1, 1, 2, 20000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id_unit` int NOT NULL,
  `unit_name` varchar(45) NOT NULL,
  `unit_visibility` enum('Visible','Hidden') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id_unit`, `unit_name`, `unit_visibility`) VALUES
(1, 'PCS', 'Visible'),
(2, 'Lusin', 'Hidden');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(10) NOT NULL,
  `is_admin` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  ADD PRIMARY KEY (`id_purchase`);

--
-- Indexes for table `purchase_product_units`
--
ALTER TABLE `purchase_product_units`
  ADD PRIMARY KEY (`id_purchase_product_unit`),
  ADD KEY `fk_purchase` (`id_purchase`),
  ADD KEY `fk_product_unit` (`id_product_unit`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id_transaction`);

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
  MODIFY `id_client` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id_product` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product_units`
--
ALTER TABLE `product_units`
  MODIFY `id_product_unit` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_unit_conversions`
--
ALTER TABLE `product_unit_conversions`
  MODIFY `id_product_unit_conversion` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `id_purchase` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `purchase_product_units`
--
ALTER TABLE `purchase_product_units`
  MODIFY `id_purchase_product_unit` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id_transaction` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaction_product_units`
--
ALTER TABLE `transaction_product_units`
  MODIFY `id_transaction_product_unit` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id_unit` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  ADD CONSTRAINT `fk_unit` FOREIGN KEY (`id_unit`) REFERENCES `units` (`id_unit`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `product_unit_conversions`
--
ALTER TABLE `product_unit_conversions`
  ADD CONSTRAINT `fk_product_unit_conversion_1` FOREIGN KEY (`id_product_unit_1`) REFERENCES `product_units` (`id_product_unit`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_unit_conversion_2` FOREIGN KEY (`id_product_unit_2`) REFERENCES `product_units` (`id_product_unit`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase_product_units`
--
ALTER TABLE `purchase_product_units`
  ADD CONSTRAINT `fk_product_unit` FOREIGN KEY (`id_product_unit`) REFERENCES `product_units` (`id_product_unit`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_purchase` FOREIGN KEY (`id_purchase`) REFERENCES `purchase` (`id_purchase`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `transaction_product_units`
--
ALTER TABLE `transaction_product_units`
  ADD CONSTRAINT `fk_transaction` FOREIGN KEY (`id_transaction`) REFERENCES `transactions` (`id_transaction`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_transaction_product` FOREIGN KEY (`id_product_unit`) REFERENCES `product_units` (`id_product_unit`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
