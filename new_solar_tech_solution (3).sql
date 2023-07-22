-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 22, 2023 at 12:21 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `new_solar_tech_solution`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `address_id` int(11) NOT NULL,
  `adress_vilage` varchar(150) NOT NULL,
  `address_province` int(11) NOT NULL,
  `address_district` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`address_id`, `adress_vilage`, `address_province`, `address_district`) VALUES
(1, 'Larham', 2, 1),
(2, 'Dewan Begi', 1, 3),
(3, 'لړم', 2, 1),
(4, 'لړم', 2, 1),
(5, 'لړم', 2, 1),
(6, 'لړم', 2, 1),
(7, 'لړم', 2, 1),
(8, 'لړم', 2, 1),
(9, 'لړم', 2, 1),
(10, 'لړم', 2, 1),
(11, 'لړم', 2, 1),
(12, 'لړم', 2, 1),
(13, 'لړم', 2, 1),
(14, 'لړم', 2, 1),
(15, 'لړم', 2, 1),
(16, 'لړم', 2, 1),
(17, 'لړم', 2, 1),
(18, 'laram', 2, 1),
(19, 'laram', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `bill_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bill`
--

INSERT INTO `bill` (`bill_number`) VALUES
(1);

-- --------------------------------------------------------

--
-- Table structure for table `bill_details`
--

CREATE TABLE `bill_details` (
  `bill_details_id` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL,
  `person_name` int(11) NOT NULL,
  `goods_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `buy_date` date NOT NULL,
  `currency_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `categ_id` int(11) NOT NULL,
  `categ_name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`categ_id`, `categ_name`) VALUES
(1, 'Solar'),
(2, 'Battery'),
(3, 'Hybrid');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `comp_id` int(11) NOT NULL,
  `comp_name` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`comp_id`, `comp_name`) VALUES
(1, 'Sonic'),
(2, 'Fusion'),
(3, 'Solartech');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `count_id` int(11) NOT NULL,
  `count_name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`count_id`, `count_name`) VALUES
(1, 'China'),
(2, 'India');

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `currency_id` int(11) NOT NULL,
  `currency_name` varchar(150) NOT NULL,
  `currency_symbol` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`currency_id`, `currency_name`, `currency_symbol`) VALUES
(1, 'Afghani', '؋'),
(2, 'Doller', '$'),
(3, 'یورو', '#');

-- --------------------------------------------------------

--
-- Table structure for table `customers_bys_goods`
--

CREATE TABLE `customers_bys_goods` (
  `currency_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `buy_date` date NOT NULL,
  `categ_id` int(11) NOT NULL,
  `comp_id` int(11) NOT NULL,
  `count_id` int(11) NOT NULL,
  `unit_amount` int(11) NOT NULL,
  `bill_number` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers_bys_goods`
--

INSERT INTO `customers_bys_goods` (`currency_id`, `person_id`, `seller_id`, `price`, `quantity`, `buy_date`, `categ_id`, `comp_id`, `count_id`, `unit_amount`, `bill_number`, `unit_id`) VALUES
(1, 1, 2, 1200, 2, '2023-07-16', 2, 2, 1, 70, 1, 3),
(1, 16, 2, 1300, 5, '2023-07-04', 1, 3, 2, 150, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `district`
--

CREATE TABLE `district` (
  `district_id` int(11) NOT NULL,
  `district_name` varchar(150) NOT NULL,
  `province_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `district`
--

INSERT INTO `district` (`district_id`, `district_name`, `province_id`) VALUES
(1, 'Sayed Abad', 2),
(2, 'Chak', 2),
(3, 'Paghman', 1);

-- --------------------------------------------------------

--
-- Table structure for table `firm`
--

CREATE TABLE `firm` (
  `firm_id` int(11) NOT NULL,
  `firm_name` varchar(150) NOT NULL,
  `address_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `firm`
--

INSERT INTO `firm` (`firm_id`, `firm_name`, `address_id`) VALUES
(1, 'Afghan Solar', 2);

-- --------------------------------------------------------

--
-- Table structure for table `goods`
--

CREATE TABLE `goods` (
  `goods_id` int(11) NOT NULL,
  `goods_name` varchar(150) NOT NULL,
  `goods_description` varchar(500) NOT NULL,
  `categ_id` int(11) NOT NULL,
  `comp_id` int(11) NOT NULL,
  `count_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `entry_date` date NOT NULL,
  `image` varchar(140) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `firm_id` int(11) NOT NULL,
  `goods_qunatity` int(11) NOT NULL,
  `goods_price` int(11) NOT NULL,
  `unit_amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `goods`
--

INSERT INTO `goods` (`goods_id`, `goods_name`, `goods_description`, `categ_id`, `comp_id`, `count_id`, `unit_id`, `entry_date`, `image`, `currency_id`, `firm_id`, `goods_qunatity`, `goods_price`, `unit_amount`) VALUES
(3, '150 watt solar', '150 watt solar', 1, 2, 1, 1, '2023-07-04', 'yuuygugjhgj', 1, 1, 12, 120, 120),
(4, '150 Amp', 'yug', 2, 2, 1, 2, '2023-07-19', 'jkjknkj', 2, 1, 20, 300, 300),
(6, 'سولر ۱۵۰ ', '۱۵۰ وټ سولر آبی', 1, 1, 1, 1, '2022-09-13', 'uploads/1690012714142171861364bb8c2a59ac2Screenshot_20230226_165653_Gallery.jpg', 1, 0, 12, 1200, 150),
(7, 'Hybrid 600', 'Hybrid 600 indian', 3, 3, 2, 1, '2023-07-16', 'sfsfsdf', 2, 1, 15, 3000, 600);

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

CREATE TABLE `loan` (
  `loan_id` int(11) NOT NULL,
  `bill_number` int(11) NOT NULL,
  `total_loan` int(11) NOT NULL,
  `paid_loan` int(11) NOT NULL,
  `total_paid` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `mobile_numbers`
--

CREATE TABLE `mobile_numbers` (
  `mobile_id` int(11) NOT NULL,
  `mobile_numbers` varchar(15) NOT NULL,
  `person_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mobile_numbers`
--

INSERT INTO `mobile_numbers` (`mobile_id`, `mobile_numbers`, `person_id`) VALUES
(1, '5555', 5),
(2, '098787', 5),
(3, '0987676', 5),
(4, '5555', 6),
(5, '098787', 6),
(6, '0987676', 6),
(7, '5555', 7),
(8, '098787', 7),
(9, '0987676', 7),
(10, '5555', 8),
(11, '098787', 8),
(12, '0987676', 8),
(13, '5555', 9),
(14, '098787', 9),
(15, '0987676', 9),
(16, '5555', 10),
(17, '098787', 10),
(18, '0987676', 10),
(19, '5555', 11),
(20, '098787', 11),
(21, '0987676', 11),
(22, '5555', 12),
(23, '098787', 12),
(24, '0987676', 12),
(25, '5555', 13),
(26, '098787', 13),
(27, '0987676', 13),
(28, '5555', 14),
(29, '098787', 14),
(30, '0987676', 14),
(31, '5555', 15),
(32, '098787', 15),
(33, '0987676', 15),
(34, '0774157887', 16),
(35, '0774157887', 16),
(36, '0774157887', 16),
(37, '0774157887', 17),
(38, '0774157887', 17),
(39, '0774157887', 17);

-- --------------------------------------------------------

--
-- Table structure for table `ourloan`
--

CREATE TABLE `ourloan` (
  `ourloan_id` int(11) NOT NULL,
  `loan_amount` int(11) NOT NULL,
  `loan_paid` int(11) NOT NULL,
  `firm_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `person_id` int(11) NOT NULL,
  `person_name` varchar(150) NOT NULL,
  `person_f_name` varchar(120) NOT NULL,
  `person_fathe_name` varchar(150) NOT NULL,
  `person_address` int(11) NOT NULL,
  `created_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`person_id`, `person_name`, `person_f_name`, `person_fathe_name`, `person_address`, `created_date`) VALUES
(1, 'Ali Agha', 'Agha', 'Sayed Agha', 2, '2023-07-04'),
(2, 'Shareef', 'Mohib', 'Saleem', 1, NULL),
(3, 'Imran khan', 'Zafar', 'email.com', 5, '0000-00-00'),
(4, 'Imran khan', 'Zafar', 'email.com', 6, '0000-00-00'),
(5, 'Imran khan', 'Zafar', 'email.com', 7, '0000-00-00'),
(6, 'Imran khan', 'Zafar', 'email.com', 8, '0000-00-00'),
(7, 'Imran khan', 'Zafar', 'email.com', 9, '0000-00-00'),
(8, 'Imran khan', 'Zafar', 'email.com', 10, '0000-00-00'),
(9, 'Imran khan', 'Zafar', 'email.com', 11, '0000-00-00'),
(10, 'Imran khan', 'Zafar', 'email.com', 12, '0000-00-00'),
(11, 'Imran khan', 'Zafar', 'email.com', 13, '0000-00-00'),
(12, 'Imran khan', 'Zafar', 'email.com', 14, '0000-00-00'),
(13, 'Imran khan', 'Zafar', 'email.com', 15, '0000-00-00'),
(14, 'Imran khan', 'Zafar', 'email.com', 16, '0000-00-00'),
(15, 'Imran khan', 'Zafar', 'email.com', 17, '0000-00-00'),
(16, 'Ahmad', 'KHan', 'daf', 18, '0000-00-00'),
(17, 'Ahmad', 'KHan', 'daf', 19, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `province`
--

CREATE TABLE `province` (
  `province_id` int(11) NOT NULL,
  `province_name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `province`
--

INSERT INTO `province` (`province_id`, `province_name`) VALUES
(1, 'Kabul'),
(2, 'Wardak');

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `unit_id` int(11) NOT NULL,
  `unit_name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`unit_id`, `unit_name`) VALUES
(1, 'Kwatt'),
(2, 'Volt'),
(3, 'ffff');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  `name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `user_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `name`, `last_name`, `user_id`, `email`, `user_type`) VALUES
('admin', 'admin', 'Ahmad', 'Amiri', 1, 'ahmad@gmail.com', 1),
('seller', 'admin', 'Ali', 'Saleemi', 2, 'ali@gmail.com', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `type_id` int(11) NOT NULL,
  `type_flag` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`type_id`, `type_flag`) VALUES
(1, 'Admin'),
(2, 'Seller');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`address_id`),
  ADD KEY `address_province` (`address_province`),
  ADD KEY `address_district` (`address_district`);

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`bill_number`);

--
-- Indexes for table `bill_details`
--
ALTER TABLE `bill_details`
  ADD PRIMARY KEY (`bill_details_id`),
  ADD KEY `bill_id` (`bill_id`),
  ADD KEY `currency_id` (`currency_id`),
  ADD KEY `goods_id` (`goods_id`),
  ADD KEY `person_name` (`person_name`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`categ_id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`comp_id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`count_id`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`currency_id`);

--
-- Indexes for table `customers_bys_goods`
--
ALTER TABLE `customers_bys_goods`
  ADD KEY `currency_id` (`currency_id`),
  ADD KEY `person_id` (`person_id`),
  ADD KEY `seller_id` (`seller_id`),
  ADD KEY `categ_id` (`categ_id`),
  ADD KEY `comp_id` (`comp_id`),
  ADD KEY `count_id` (`count_id`),
  ADD KEY `bill_number` (`bill_number`),
  ADD KEY `unit_id` (`unit_id`);

--
-- Indexes for table `district`
--
ALTER TABLE `district`
  ADD PRIMARY KEY (`district_id`),
  ADD KEY `province_id` (`province_id`);

--
-- Indexes for table `firm`
--
ALTER TABLE `firm`
  ADD PRIMARY KEY (`firm_id`),
  ADD KEY `address_id` (`address_id`);

--
-- Indexes for table `goods`
--
ALTER TABLE `goods`
  ADD PRIMARY KEY (`goods_id`),
  ADD KEY `categ_id` (`categ_id`),
  ADD KEY `comp_id` (`comp_id`),
  ADD KEY `count_id` (`count_id`),
  ADD KEY `unit_id` (`unit_id`),
  ADD KEY `currency_id` (`currency_id`),
  ADD KEY `firm_id` (`firm_id`);

--
-- Indexes for table `loan`
--
ALTER TABLE `loan`
  ADD PRIMARY KEY (`loan_id`),
  ADD KEY `bill_number` (`bill_number`);

--
-- Indexes for table `mobile_numbers`
--
ALTER TABLE `mobile_numbers`
  ADD PRIMARY KEY (`mobile_id`),
  ADD KEY `person_id` (`person_id`);

--
-- Indexes for table `ourloan`
--
ALTER TABLE `ourloan`
  ADD PRIMARY KEY (`ourloan_id`),
  ADD KEY `firm_id` (`firm_id`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`person_id`),
  ADD KEY `person_address` (`person_address`);

--
-- Indexes for table `province`
--
ALTER TABLE `province`
  ADD PRIMARY KEY (`province_id`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`unit_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_type` (`user_type`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `bill`
--
ALTER TABLE `bill`
  MODIFY `bill_number` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bill_details`
--
ALTER TABLE `bill_details`
  MODIFY `bill_details_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `categ_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `comp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `count_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `currency_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `district`
--
ALTER TABLE `district`
  MODIFY `district_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `firm`
--
ALTER TABLE `firm`
  MODIFY `firm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `goods`
--
ALTER TABLE `goods`
  MODIFY `goods_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `loan`
--
ALTER TABLE `loan`
  MODIFY `loan_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mobile_numbers`
--
ALTER TABLE `mobile_numbers`
  MODIFY `mobile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `ourloan`
--
ALTER TABLE `ourloan`
  MODIFY `ourloan_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `person_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `province`
--
ALTER TABLE `province`
  MODIFY `province_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `unit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_ibfk_1` FOREIGN KEY (`address_province`) REFERENCES `province` (`province_id`),
  ADD CONSTRAINT `address_ibfk_2` FOREIGN KEY (`address_district`) REFERENCES `district` (`district_id`);

--
-- Constraints for table `bill_details`
--
ALTER TABLE `bill_details`
  ADD CONSTRAINT `bill_details_ibfk_1` FOREIGN KEY (`bill_id`) REFERENCES `bill` (`bill_number`),
  ADD CONSTRAINT `bill_details_ibfk_2` FOREIGN KEY (`currency_id`) REFERENCES `currency` (`currency_id`),
  ADD CONSTRAINT `bill_details_ibfk_3` FOREIGN KEY (`goods_id`) REFERENCES `goods` (`goods_id`),
  ADD CONSTRAINT `bill_details_ibfk_4` FOREIGN KEY (`person_name`) REFERENCES `person` (`person_id`);

--
-- Constraints for table `customers_bys_goods`
--
ALTER TABLE `customers_bys_goods`
  ADD CONSTRAINT `customers_bys_goods_ibfk_10` FOREIGN KEY (`count_id`) REFERENCES `country` (`count_id`),
  ADD CONSTRAINT `customers_bys_goods_ibfk_11` FOREIGN KEY (`bill_number`) REFERENCES `bill` (`bill_number`),
  ADD CONSTRAINT `customers_bys_goods_ibfk_12` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`unit_id`),
  ADD CONSTRAINT `customers_bys_goods_ibfk_2` FOREIGN KEY (`currency_id`) REFERENCES `currency` (`currency_id`),
  ADD CONSTRAINT `customers_bys_goods_ibfk_3` FOREIGN KEY (`person_id`) REFERENCES `person` (`person_id`),
  ADD CONSTRAINT `customers_bys_goods_ibfk_5` FOREIGN KEY (`seller_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `customers_bys_goods_ibfk_6` FOREIGN KEY (`seller_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `customers_bys_goods_ibfk_7` FOREIGN KEY (`seller_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `customers_bys_goods_ibfk_8` FOREIGN KEY (`categ_id`) REFERENCES `category` (`categ_id`),
  ADD CONSTRAINT `customers_bys_goods_ibfk_9` FOREIGN KEY (`comp_id`) REFERENCES `company` (`comp_id`);

--
-- Constraints for table `district`
--
ALTER TABLE `district`
  ADD CONSTRAINT `district_ibfk_1` FOREIGN KEY (`province_id`) REFERENCES `province` (`province_id`);

--
-- Constraints for table `firm`
--
ALTER TABLE `firm`
  ADD CONSTRAINT `firm_ibfk_1` FOREIGN KEY (`address_id`) REFERENCES `address` (`address_id`);

--
-- Constraints for table `goods`
--
ALTER TABLE `goods`
  ADD CONSTRAINT `goods_ibfk_1` FOREIGN KEY (`categ_id`) REFERENCES `category` (`categ_id`),
  ADD CONSTRAINT `goods_ibfk_2` FOREIGN KEY (`comp_id`) REFERENCES `company` (`comp_id`),
  ADD CONSTRAINT `goods_ibfk_3` FOREIGN KEY (`count_id`) REFERENCES `country` (`count_id`),
  ADD CONSTRAINT `goods_ibfk_4` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`unit_id`),
  ADD CONSTRAINT `goods_ibfk_5` FOREIGN KEY (`currency_id`) REFERENCES `currency` (`currency_id`),
  ADD CONSTRAINT `goods_ibfk_6` FOREIGN KEY (`firm_id`) REFERENCES `firm` (`firm_id`);

--
-- Constraints for table `loan`
--
ALTER TABLE `loan`
  ADD CONSTRAINT `loan_ibfk_1` FOREIGN KEY (`bill_number`) REFERENCES `bill` (`bill_number`);

--
-- Constraints for table `mobile_numbers`
--
ALTER TABLE `mobile_numbers`
  ADD CONSTRAINT `mobile_numbers_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `person` (`person_id`);

--
-- Constraints for table `ourloan`
--
ALTER TABLE `ourloan`
  ADD CONSTRAINT `ourloan_ibfk_1` FOREIGN KEY (`firm_id`) REFERENCES `firm` (`firm_id`);

--
-- Constraints for table `person`
--
ALTER TABLE `person`
  ADD CONSTRAINT `person_ibfk_1` FOREIGN KEY (`person_address`) REFERENCES `address` (`address_id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`user_type`) REFERENCES `user_type` (`type_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
