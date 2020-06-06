-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 02, 2019 at 05:37 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(10) UNSIGNED NOT NULL,
  `admin_email` text NOT NULL,
  `admin_number` text NOT NULL,
  `admin_password` text NOT NULL,
  `admin_fname` text NOT NULL,
  `admin_lname` text NOT NULL,
  `time_` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `admin_email`, `admin_number`, `admin_password`, `admin_fname`, `admin_lname`, `time_`) VALUES
(4, 'arjay@gmail.com', '09099054766', 'arjay1234', 'Arjay', 'Diangzon', '2019-02-28 10:10:56'),
(5, 'neil@gmail.com', '09099054766', 'neil1234', 'Neil', 'Celajes', '2019-02-27 06:15:52'),
(6, 'mark@gmail.com', '09905476609', 'mark1234', 'Mark Lawrence', 'Escuyos', '2019-02-27 14:10:55'),
(7, 'nilo@gmail.com', '09900954766', 'nilo1234', 'Nilo Jr', 'Calisbo', '2019-02-27 14:11:38'),
(8, 'gian@gmail.com', '09547660990', 'gian1234', 'Gian Ericson', 'Alipao', '2019-02-27 15:02:07');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `customer_tr_no` text NOT NULL,
  `customer_name` text NOT NULL,
  `customer_email` text NOT NULL,
  `customer_address` text NOT NULL,
  `customer_number` text NOT NULL,
  `mode_of_payment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `customer_tr_no`, `customer_name`, `customer_email`, `customer_address`, `customer_number`, `mode_of_payment`) VALUES
(1, '190000', 'Arjay Diangzon', 'arjaydiangzon@gmail.com', 'Cainta Rizal', '09090954766', 'deliver'),
(2, '190001', 'Arjay Diangzon', 'arjaydiangzon@gmail.com', 'Cainta Rizal', '09090954766', 'deliver'),
(3, '190002', 'Mark Escuyos', 'mark@gmail.com', 'Taytay Rizal', '', 'deliver'),
(4, '190003', 'Nilo Calisbo', 'nilo@gmail.com', 'Pasig City', '', 'deliver'),
(5, '190004', 'Nilo Calisbo', 'nilo@gmail.com', 'Pasig City', '', 'deliver'),
(6, '190005', 'Arjay Diangzon', 'arjaydiangzon@gmail.com', 'Cainta Rizal', '09090954766', 'deliver'),
(7, '190006', 'Neil Celajes', 'neil@gmail.com', 'Binangonan Rizal', '', 'deliver'),
(8, '190007', 'Neil Celajes', 'neil@gmail.com', 'Binangonan Rizal', '', 'deliver'),
(9, '190008', 'Gian Alipao', 'gian@gmail.com', 'Pasig City', '', 'deliver'),
(10, '190009', 'Jerome De Vera', 'Jerome@gmail.com', 'Mandaluyong city', '', 'deliver'),
(11, '190010', 'Jerome De Vera', 'Jerome@gmail.com', 'Mandaluyong city', '', 'deliver');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` text NOT NULL,
  `product_description` text NOT NULL,
  `product_type` text NOT NULL,
  `product_size_number` varchar(20) NOT NULL,
  `product_size` varchar(10) NOT NULL,
  `product_cover` text NOT NULL,
  `product_stocks` varchar(20) NOT NULL,
  `product_price` varchar(20) NOT NULL,
  `time_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `product_description`, `product_type`, `product_size_number`, `product_size`, `product_cover`, `product_stocks`, `product_price`, `time_added`) VALUES
(5, 'Chocolait Chocolate Milk Drink', 'Chocolait Chocolate Milk Drink', 'Milk', '110', 'ml', '5c7675b1da28b3.56510131.jpg', '1000', '15', '2019-02-26 18:15:26'),
(10, 'Pepsi Bottle', 'Pepsi Bottle', 'Softdrinks', '1.5', 'L', '5c6ceb8eed04f5.47645621.png', '1000', '60', '2019-02-20 13:54:22'),
(11, 'Mountain Dew Can', 'Mountain Dew Can', 'Softdrinks', '330', 'ml', '5c6cebaef02f20.05267267.png', '1000', '24', '2019-02-20 13:54:54'),
(12, 'Mug Root Beer', 'Mug Root Beer', 'Beer', '1.5', 'L', '5c6cec79a24ba4.39450275.png', '990', '60', '2019-02-20 13:58:17'),
(13, 'Fruit Soda Juicy Lemon', 'Fruit Soda Juicy Lemon', 'Softdrinks', '1.5', 'L', '5c6cebf38737c2.98157105.png', '1000', '55', '2019-02-20 13:56:03'),
(14, '7 Up Regular Can', '7 Up Regular Can Carbonated Softdrinks', 'Softdrinks', '330', 'ml', '5c6cec391b5926.63160520.png', '1000', '25', '2019-02-27 19:03:42'),
(15, 'Mug Root Beer Can', 'Mug Root Beer Can', 'Beer', '330', 'ml', '5c76a778791919.19081841.png', '1000', '25', '2019-02-27 18:50:05'),
(16, 'Coke Light ', 'Coke Light', 'Softdrinks', '500', 'ml', '5c6ceca4972cb6.22017845.png', '994', '30', '2019-02-20 13:59:00'),
(17, 'Mug Root Beer Bottle', 'Mug Root Beer Bottle', 'Beer', '2', 'L', '5c6cecd6bff2d7.83002573.png', '1000', '80', '2019-02-20 13:59:50'),
(18, 'Sarsi Regular', 'Sarsi Regular', 'Softdrinks', '330', 'ml', '5c6cecf8d8a5b2.20097340.png', '1000', '30', '2019-02-20 14:00:24'),
(19, 'Mountain Dew Citrus', 'Mountain Dew Citrus', 'Softdrinks', '1.5', 'L', '5c6ced19bbee68.14942620.png', '1000', '60', '2019-02-20 14:00:57'),
(21, 'Pepsi Regular', 'Pepsi Regular', 'Softdrinks', '2', 'L', '5c6ced8682a2a0.19174383.png', '1000', '70', '2019-02-20 14:02:46'),
(22, 'RC Cola Biggie Bottle', 'RC Cola Biggie Bottle', 'Softdrinks', '1.5', 'L', '5c6cedace41490.61318862.png', '1000', '55', '2019-02-20 14:03:24'),
(23, 'Smart C Lemon Squeeze Juice', 'Smart C Lemon Squeeze Juice', 'Juice', '350', 'ml', '5c739c8f451ab3.24460921.png', '1000', '20', '2019-02-25 17:43:37'),
(24, 'C2 Green Tea Apple Flavor', 'C2 Green Tea Apple Flavor', 'Juice', '355', 'ml', '5c739cb8795159.58019641.png', '991', '20', '2019-02-27 11:30:19'),
(25, 'Zesto Orange Juice Drink', 'Zesto Orange Juice Drink', 'Juice', '200', 'ml', '5c739cd8b44c68.50433732.png', '1000', '10', '2019-02-25 15:44:24'),
(26, 'Zesto Apple Juice Drink', 'Zesto Apple Juice Drink', 'Juice', '200', 'ml', '5c739cf1d34c26.64169240.png', '1000', '10', '2019-02-25 15:44:49'),
(27, 'Zesto Mango Juice Drink', 'Zesto Mango Juice Drink', 'Juice', '200', 'ml', '5c76789970ece7.69089919.png', '1000', '10', '2019-02-25 15:48:03'),
(28, 'Zesto Grape Juice Drink', 'Zesto Grape Juice Drink', 'Juice', '200', 'ml', '5c739dd145c635.33543707.png', '1000', '10', '2019-02-25 15:48:33'),
(29, 'Minute Maid Fresh Apple Juice Drink', 'Minute Maid Fresh Apple Juice Drink', 'Juice', '200', 'ml', '5c739dea66d8f5.72243651.png', '1000', '10', '2019-02-25 15:48:58'),
(30, 'Smart C+ Calamansi Juice', 'Smart C+ Calamansi Juice', 'Juice', '350', 'ml', '5c739e1805b451.19110152.png', '980', '20', '2019-02-25 15:49:44'),
(31, 'C2 Green Tea Plain', 'C2 Green Tea Plain', 'Juice', '355', 'ml', '5c739e42d0e9e1.00124846.png', '1000', '20', '2019-02-27 11:30:19'),
(32, 'Mogu Mogu Lychee Juice With Nata De Coco', 'Mogu Mogu Lychee Juice With Nata De Coco', 'Juice', '320', 'ml', '5c739e624a74f1.88844508.png', '1000', '35', '2019-02-25 15:50:58'),
(33, 'Del Monte 100% Pineapple Juice Fiber Enriched', 'Del Monte 100% Pineapple Juice Fiber Enriched', 'Juice', '200', 'ml', '5c739e91402754.61268162.png', '1000', '30', '2019-02-25 15:51:45'),
(34, 'Wilkins Distilled Water', 'Wilkins Distilled Water', 'Water', '7', 'L', '5c739eb458af94.25867385.png', '1000', '80', '2019-02-25 15:52:20'),
(35, 'Wilkins Distilled Water', 'Wilkins Distilled Water', 'Water', '5', 'L', '5c739ecbdd0fc8.20200325.png', '1000', '65', '2019-02-25 15:52:43'),
(36, 'Absolute Distilled Water', 'Absolute Distilled Water', 'Water', '6', 'L', '5c7697fc33db90.99714606.png', '969', '75', '2019-02-27 19:03:42'),
(37, 'Summit Natural Drinking Water', 'Summit Natural Drinking Water', 'Water', '500', 'ml', '5c739f19273177.19364604.png', '1000', '12', '2019-02-27 18:21:07'),
(38, 'Nestle Fresh UHT Milk Hi-Calcium', 'Nestle Fresh UHT Milk Hi-Calcium', 'Milk', '1', 'L', '5c739f478be8f5.90409272.png', '1000', '90', '2019-02-25 15:54:47'),
(39, 'Nestle Low Fat Milk Tetra', 'Nestle Low Fat Milk Tetra', 'Milk', '1', 'L', '5c739fd4bb0181.75770518.png', '1000', '90', '2019-02-25 15:57:08'),
(40, 'San Miguel Flavored Beer Apple Can', 'San Miguel Flavored Beer Apple Can', 'Beer', '330', 'ml', '5c73b9d998bcc3.80462088.png', '1000', '38', '2019-02-25 17:48:09'),
(41, 'Red Horse Beer In Can', 'Red Horse Beer In Can', 'Beer', '330', 'ml', '5c73ba0636f323.87188219.png', '1000', '42', '2019-02-25 17:48:54'),
(42, 'San Miguel Beer Light Can', 'San Miguel Beer Light Can', 'Beer', '330', 'ml', '5c73ba25d6d996.53629138.png', '999', '42', '2019-02-25 17:49:25'),
(43, 'Emperador Brandy Light', 'Emperador Brandy Light', 'Beer', '1', 'L', '5c73ba41c05701.73703134.png', '1000', '130', '2019-02-25 17:49:53'),
(44, 'Embassy Whisky', 'Embassy Whisky', 'Beer', '750', 'ml', '5c73ba5d45db87.04931616.png', '1000', '135', '2019-02-25 17:50:21'),
(45, 'Red Horse Beer', 'Red Horse Beer', 'Beer', '1', 'L', '5c73ba774882e6.52680898.png', '1000', '80', '2019-02-25 17:50:47'),
(46, 'RC Cola Biggie Bottle', 'RC Cola Biggie Bottle', 'Softdrinks', '1.5', 'L', '5c73ba9619f2a4.48678805.png', '1000', '55', '2019-02-25 17:51:18'),
(47, 'Mirinda Orange', 'Mirinda Orange', 'Softdrinks', '1.5', 'L', '5c73baafa93221.62890013.png', '1000', '50', '2019-02-25 17:51:43'),
(48, 'Rc Cola', 'Rc Cola', 'Softdrinks', '500', 'ml', '5c73bad40b2a04.79647408.png', '5', '21', '2019-02-25 17:52:20');

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_stocks` text NOT NULL,
  `status` text NOT NULL,
  `date_` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `product_id`, `product_stocks`, `status`, `date_`) VALUES
(2, 2, '1000', '', '2019-02-05 21:12:28'),
(3, 3, '1000', '', '2019-02-05 21:18:23'),
(4, 4, '1000', '', '2019-02-05 21:19:52'),
(5, 5, '1000', 'read', '2019-02-27 19:34:09'),
(6, 6, '1000', '', '2019-02-05 21:24:56'),
(7, 7, '1000', 'read', '2019-02-20 14:06:25'),
(8, 8, '1000', '', '2019-02-05 21:28:19'),
(9, 9, '1000', '', '2019-02-20 13:53:27'),
(10, 10, '1000', '', '2019-02-20 13:54:23'),
(11, 11, '1000', '', '2019-02-20 13:54:55'),
(12, 12, '990', 'read', '2019-02-27 23:04:10'),
(13, 13, '1000', '', '2019-02-20 13:56:03'),
(14, 14, '1000', '', '2019-02-20 13:57:13'),
(15, 15, '1000', 'read', '2019-02-27 23:06:32'),
(16, 16, '994', '', '2019-02-28 11:39:44'),
(17, 17, '1000', '', '2019-02-20 13:59:50'),
(18, 18, '1000', '', '2019-02-20 14:00:25'),
(19, 19, '1000', '', '2019-02-20 14:00:57'),
(20, 20, '1000', '', '2019-02-20 14:01:49'),
(21, 21, '1000', '', '2019-02-20 14:02:46'),
(22, 22, '1000', '', '2019-02-20 14:03:25'),
(23, 23, '1000', '', '2019-02-25 15:43:11'),
(24, 24, '991', '', '2019-02-27 23:43:30'),
(25, 25, '1000', '', '2019-02-25 15:44:24'),
(26, 26, '1000', '', '2019-02-25 15:44:50'),
(28, 28, '1000', '', '2019-02-25 15:48:33'),
(29, 29, '1000', '', '2019-02-25 15:48:58'),
(30, 30, '980', '', '2019-02-27 21:49:01'),
(31, 31, '1000', '', '2019-02-25 15:50:27'),
(32, 32, '1000', '', '2019-02-25 15:50:58'),
(33, 33, '1000', '', '2019-02-25 15:51:45'),
(34, 34, '1000', '', '2019-02-25 15:52:20'),
(35, 34, '1000', '', '2019-02-25 15:52:44'),
(36, 35, '1000', '', '2019-02-25 15:52:44'),
(37, 36, '12', 'read', '2019-02-27 23:13:23'),
(38, 37, '1000', '', '2019-02-25 15:54:01'),
(39, 38, '1000', '', '2019-02-25 15:54:47'),
(40, 39, '1000', '', '2019-02-25 15:57:08'),
(41, 40, '1000', '', '2019-02-25 17:48:09'),
(42, 41, '1000', '', '2019-02-27 21:47:28'),
(43, 42, '999', '', '2019-02-27 21:47:33'),
(44, 43, '1000', '', '2019-02-25 17:49:54'),
(45, 44, '1000', '', '2019-02-25 17:50:21'),
(46, 45, '1000', '', '2019-02-25 17:50:47'),
(47, 22, '1000', '', '2019-02-25 17:51:18'),
(48, 46, '1000', '', '2019-02-25 17:51:18'),
(49, 47, '1000', '', '2019-02-25 17:51:43'),
(50, 48, '5', 'unread', '2019-02-27 21:58:26'),
(51, 27, '1000', '', '2019-02-27 20:11:20'),
(52, 36, '969', '', '2019-02-28 11:39:44'),
(53, 15, '1000', '', '2019-02-27 23:06:32');

-- --------------------------------------------------------

--
-- Table structure for table `temp_cart`
--

CREATE TABLE `temp_cart` (
  `id` int(11) NOT NULL,
  `customer_tr_no` text NOT NULL,
  `customer_name` text NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` text NOT NULL,
  `price` text NOT NULL,
  `cost` text NOT NULL,
  `cash` int(11) NOT NULL,
  `change_` int(11) NOT NULL,
  `mode_of_payment` text NOT NULL,
  `status_of_order` text NOT NULL,
  `status` text NOT NULL,
  `date_` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `temp_cart`
--

INSERT INTO `temp_cart` (`id`, `customer_tr_no`, `customer_name`, `product_id`, `quantity`, `price`, `cost`, `cash`, `change_`, `mode_of_payment`, `status_of_order`, `status`, `date_`) VALUES
(1, '190000', 'Arjay Diangzon', 48, '990', '21', '20790', 100000, 4960, 'deliver', 'Paid', 'read', '2019-02-27 20:30:44'),
(2, '190000', 'Arjay Diangzon', 36, '990', '75', '74250', 100000, 4960, 'deliver', 'Paid', 'read', '2019-02-27 20:30:44'),
(3, '190001', 'Arjay Diangzon', 16, '5', '30', '150', 200, 50, 'deliver', 'Paid', 'read', '2019-02-27 21:28:10'),
(4, '190002', 'Mark Escuyos', 42, '1', '42', '42', 50, 8, 'deliver', 'Paid', 'read', '2019-02-27 21:31:56'),
(5, '190003', 'Nilo Calisbo', 30, '20', '20', '400', 500, 80, 'deliver', 'Paid', 'read', '2019-02-27 21:49:01'),
(6, '190003', 'Nilo Calisbo', 24, '1', '20', '20', 500, 80, 'deliver', 'Paid', 'read', '2019-02-27 21:49:01'),
(7, '190004', 'Nilo Calisbo', 48, '5', '21', '105', 350, 20, 'deliver', 'Paid', 'read', '2019-02-27 21:58:26'),
(8, '190004', 'Nilo Calisbo', 36, '3', '75', '225', 350, 20, 'deliver', 'Paid', 'read', '2019-02-27 21:58:26'),
(9, '190005', 'Arjay Diangzon', 12, '10', '60', '600', 700, 100, 'deliver', 'Paid', 'read', '2019-02-27 23:04:10'),
(10, '190006', 'Neil Celajes', 36, '5', '75', '375', 400, 25, 'deliver', 'Paid', 'read', '2019-02-27 23:08:39'),
(11, '190007', 'Neil Celajes', 36, '1', '75', '75', 100, 25, 'deliver', 'Paid', 'read', '2019-02-27 23:14:16'),
(12, '190008', 'Gian Alipao', 36, '10', '75', '750', 1000, 90, 'deliver', 'Paid', 'read', '2019-02-27 23:43:29'),
(13, '190008', 'Gian Alipao', 24, '8', '20', '160', 1000, 90, 'deliver', 'Paid', 'read', '2019-02-27 23:43:29'),
(14, '190009', 'Jerome De Vera', 16, '1', '30', '30', 1000, 220, 'deliver', 'Paid', 'read', '2019-02-28 11:39:43'),
(15, '190009', 'Jerome De Vera', 36, '10', '75', '750', 1000, 220, 'deliver', 'Paid', 'read', '2019-02-28 11:39:43'),
(16, '190010', 'Jerome De Vera', 36, '1', '75', '75', 0, 0, 'deliver', 'Pending', 'unread', '2019-02-28 11:37:28');

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`id`, `name`) VALUES
(1, 'Water'),
(2, 'Softdrinks'),
(3, 'Milk'),
(4, 'Juice'),
(5, 'Beer'),
(6, 'Wine');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_cart`
--
ALTER TABLE `temp_cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `temp_cart`
--
ALTER TABLE `temp_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
