-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 26, 2025 at 04:02 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce-project`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`) VALUES
(1, 'admin@gmail.com', 'admin1234');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `product_id`, `customer_id`, `quantity`) VALUES
(220, 16, 2, 1),
(221, 10, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `cat_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `cat_name`) VALUES
(3, 'Fragrances'),
(4, 'Haircream'),
(5, 'SkinCare');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `phonenumber` bigint(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `name`, `email`, `password`, `address`, `phonenumber`) VALUES
(1, 'user', 'user1@gmail.com', 'b5b73fae0d87d8b4e2573105f8fbe7bc', 'kalanki', 9810102344),
(2, 'ram', 'ram@gmail.com', 'ed218e06b885297d0750b65be5e4041e', 'kalimati', 9810101010),
(3, 'riyaz', 'riyaz@gmail.com', 'e3a7103d06d9f9da43c7323e744f4fac', 'kirtipur', 9810256789),
(4, 'user2', 'user2@gmail.com', 'b2adfbf49b5a8facf2ac499630ea96bd', 'kalanki', 9810256789),
(5, 'sita', 'sita@gmail.com', '83c953da3ddc23bd64f46d77fc2c26fd', 'kalimati', 9810256780),
(6, 'Rohit', 'rohit@gmail.com', 'e28717452238a837686548dcdc63e62f', 'thankot', 9810256780),
(7, 'zen malik', 'zen@gmail.com', '3527913b2dfa81bb715a28f7756f5786', 'thamel', 9810101011),
(8, 'Krish', 'krish@gmail.com', 'f673d9991a246dbce15d315e7716bc1f', 'thamel', 9810102340),
(9, 'Sadip', 'sadip@gmail.com', 'eb9b0d52d782f1927eebe2813b5a7f12', 'sakhu', 9810256799),
(10, 'Abin', 'abin@gmail.com', '010cda7042c79dfd028d45a00365c3b4', 'makalbari', 9810256700);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'pending',
  `order_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `product_id`, `product_name`, `quantity`, `total`, `status`, `order_date`) VALUES
(13, 2, 12, 'Karseel', 1, 3000.00, 'pending', '2025-05-14 19:23:47'),
(37, 2, 12, 'Karseel', 1, 3390.00, 'pending', '2025-05-17 16:15:54'),
(38, 1, 12, 'Karseel', 1, 3390.00, 'pending', '2025-05-17 16:16:47'),
(40, 3, 12, 'Karseel', 1, 3390.00, 'pending', '2025-05-17 16:17:54'),
(41, 4, 12, 'Karseel', 1, 3390.00, 'pending', '2025-05-17 16:21:19'),
(42, 7, 12, 'Karseel', 1, 3390.00, 'pending', '2025-05-17 16:22:11'),
(43, 8, 12, 'Karseel', 1, 3390.00, 'pending', '2025-05-17 16:24:06'),
(44, 5, 12, 'Karseel', 1, 3390.00, 'pending', '2025-05-17 16:26:13'),
(45, 6, 12, 'Karseel', 1, 3390.00, 'pending', '2025-05-17 16:26:58'),
(46, 9, 12, 'Karseel', 1, 3390.00, 'pending', '2025-05-17 16:27:41'),
(47, 10, 12, 'Karseel', 1, 3390.00, 'pending', '2025-05-17 16:28:22'),
(48, 10, 12, 'Karseel', 1, 3390.00, 'pending', '2025-05-17 16:30:08'),
(50, 1, 12, 'Karseel', 1, 3390.00, 'pending', '2025-05-17 16:40:30'),
(59, 7, 5, 'Engage', 1, 1130.00, 'pending', '2025-05-19 08:01:18'),
(64, 7, 5, 'Engage', 1, 1130.00, 'pending', '2025-06-26 10:43:34'),
(65, 1, 5, 'Engage', 1, 1130.00, 'pending', '2025-06-26 10:44:37'),
(66, 2, 5, 'Engage', 1, 1130.00, 'pending', '2025-06-26 10:45:44'),
(67, 10, 5, 'Engage', 1, 1130.00, 'pending', '2025-06-26 10:46:22'),
(68, 5, 5, 'Engage', 1, 1130.00, 'pending', '2025-06-26 10:47:25'),
(69, 9, 5, 'Engage', 2, 2260.00, 'pending', '2025-06-26 10:48:01'),
(70, 8, 5, 'Engage', 1, 1130.00, 'pending', '2025-06-26 10:48:40'),
(71, 3, 5, 'Engage', 1, 1130.00, 'pending', '2025-06-26 10:49:33'),
(72, 4, 5, 'Engage', 1, 1130.00, 'pending', '2025-06-26 10:50:31'),
(73, 6, 5, 'Engage', 1, 1130.00, 'pending', '2025-06-26 10:51:59'),
(74, 1, 6, 'Bella Vita', 1, 3390.00, 'pending', '2025-06-26 18:52:04');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `brand` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `category_id` int(11) NOT NULL,
  `quantity` int(100) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(100) NOT NULL,
  `purchase_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `brand`, `price`, `category_id`, `quantity`, `description`, `image`, `purchase_count`) VALUES
(5, 'Engage', 1000, 3, 7, 'Engage Yin Perfume for Men Long Lasting Smell', 'Engage.jpg', 10),
(6, 'Bella Vita', 3000, 3, 18, 'Bella Vita Luxury Date Perfume', 'bella-vita.avif', 1),
(7, 'Biotin Conditioner', 3000, 4, 0, 'Hairfall Rescue Conditioner ', 'hair_shampoo.png', 1),
(8, 'Bare Anatomy', 550, 4, 0, 'Bare Anatomy Adenogrow Technology Anti Hairfall Shampoo ', 'Bare anatomy_hair.avif', 0),
(9, 'Garnier', 505, 5, 8, 'GARNlER Men AcnoFight Anti Pimple Face Wash ', 'garnier.avif', 1),
(10, 'Ponds', 371, 5, 5, 'Pond', 'ponds.avif', 1),
(11, 'CeraVe', 3000, 5, 4, 'Cera Ve Daily Moisturizing Lotion ', 'Cerame.png', 1),
(12, 'Karseel', 3000, 4, 8, 'Karseell Organic Hair-Loss Prevention Moroccan Oil Men Scalp', 'Karseel.avif', 10),
(13, 'Axe', 3000, 3, 17, 'Axe Signature Dark Temptation Body Deodorant', 'Axe.avif', 1),
(14, 'Cetaphil', 3000, 5, 5, 'Cetaphil Face Wash Gentle Skin Cleanser Classic ', 'cetaphil.png', 2),
(15, 'Himalaya', 3000, 5, 8, 'Himalaya Men Power Glow Licorice Face Wash ', 'himalaya.avif', 1),
(16, 'Versace', 3000, 3, 4, 'Versace Eros Eau De Toilette For Men ', 'Versace.jpg', 2),
(23, 'Denver', 188, 3, 10, 'Denver Yin Perfume for Men Long Lasting Smell', 'Denver.avif', 0);

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
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `fk_product_id` (`product_id`),
  ADD KEY `fk_id` (`customer_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_customer` (`customer_id`),
  ADD KEY `fk_product` (`product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=222;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`),
  ADD CONSTRAINT `fk_id` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`),
  ADD CONSTRAINT `fk_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_customer` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`),
  ADD CONSTRAINT `fk_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
