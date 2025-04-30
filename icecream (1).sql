-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2025 at 04:06 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `icecream`
--

-- --------------------------------------------------------

--
-- Table structure for table `allowed_pincodes`
--

CREATE TABLE `allowed_pincodes` (
  `id` int(11) NOT NULL,
  `pincode` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `allowed_pincodes`
--

INSERT INTO `allowed_pincodes` (`id`, `pincode`) VALUES
(2, '575001');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `name`, `price`, `image`, `quantity`) VALUES
(13, 1, 1, 'panipuri', 35.00, 'uploads/1742359780_panipuri.jpg', 4),
(17, 1, 7, 'burger', 100.00, 'uploads/1744627088_burger.jpg', 2);

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `created_at`, `phone`) VALUES
(3, 'sachin', 'Vikram@gmail.com', 'hii', '2025-04-16 09:06:10', NULL),
(4, 'sachin', 'Vikram@gmail.com', 'hi', '2025-04-16 09:09:08', '9876543228'),
(5, 'sachin', 'Vikram@gmail.com', 'hi', '2025-04-16 09:11:28', '9876543228');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `customer_name`, `phone`, `address`, `payment_method`, `total_amount`, `created_at`) VALUES
(2, 1, 'Harshendra P', '9449772658', 'Pana house Balpa village and post', 'Cash on Delivery', 1750.00, '2025-04-13 04:56:56'),
(4, 1, 'Harshendra P', '9449772658', 'Pana house Balpa village and post', 'Cash on Delivery', 67.00, '2025-04-13 05:06:26'),
(5, 1, 'Harshendra P', '9449772658', 'Pana house Balpa village and post', 'Cash on Delivery', 67.00, '2025-04-13 05:07:52'),
(6, 1, 'Harshendra P', '9449772658', 'Pana house Balpa village and post', 'Cash on Delivery', 67.00, '2025-04-13 05:14:01'),
(8, 2, 'Vikram', '9626456789', '2nd street thokottu Ullala', 'Cash on Delivery', 415.00, '2025-04-14 10:45:59'),
(9, 2, 'Vikram', '9626456789', '2nd street thokottu Ullala', 'Cash on Delivery', 146.00, '2025-04-14 11:15:21'),
(10, 2, 'Vikram', '9626456789', '2nd street thokottu Ullala', 'Cash on Delivery', 134.00, '2025-04-14 12:04:09'),
(11, 2, 'Vikram', '9626456789', '2nd street thokottu Ullala', 'Cash on Delivery', 246.00, '2025-04-14 16:30:04'),
(12, 2, 'Vikram', '9626456789', '2nd street thokottu Ullala', 'Cash on Delivery', 140.00, '2025-04-14 16:38:59'),
(13, 2, 'Vikram', '9626456789', '2nd street thokottu Ullala', 'Cash on Delivery', 67.00, '2025-04-15 04:27:38'),
(14, 2, 'Vikram', '9626456789', '2nd street thokottu Ullala', 'Cash on Delivery', 278.00, '2025-04-15 04:35:16'),
(15, 2, 'Vikram', '9626456789', '2nd street thokottu Ullala', 'Cash on Delivery', 150.00, '2025-04-15 07:10:47'),
(16, 2, 'Vikram', '9626456789', '2nd street thokottu Ullala', 'Cash on Delivery', 170.00, '2025-04-15 10:49:43'),
(17, 2, 'Vikram', '9626456789', '2nd street thokottu Ullala', 'Cash on Delivery', 227.00, '2025-04-15 16:47:48'),
(18, 2, 'Vikram', '9626456789', '2nd street thokottu Ullala', 'Cash on Delivery', 111.00, '2025-04-15 17:31:36'),
(19, 2, 'Vikram', '9626456789', '2nd street thokottu Ullala', 'Cash on Delivery', 80.00, '2025-04-16 04:32:53'),
(20, 2, 'Vikram', '9626456789', '2nd street thokottu Ullala', 'Cash on Delivery', 80.00, '2025-04-16 06:08:09'),
(21, 2, 'Vikram', '9626456789', '2nd street thokottu Ullala', 'Cash on Delivery', 78.00, '2025-04-16 06:10:10'),
(22, 2, 'Vikram', '9626456789', '2nd street thokottu Ullala', 'Cash on Delivery', 78.00, '2025-04-16 06:16:24'),
(23, 2, 'Vikram', '9626456789', '2nd street thokottu Ullala', 'Cash on Delivery', 157.00, '2025-04-16 07:03:38');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `review` text DEFAULT NULL,
  `rating` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `name`, `image`, `price`, `quantity`, `subtotal`, `status`, `review`, `rating`) VALUES
(7, 6, NULL, 'blueberry', 'uploads/1742490021_blueberry.jpg', 67.00, 1, NULL, 'Delivered', NULL, NULL),
(9, 8, NULL, 'blueberry', 'uploads/1742490021_blueberry.jpg', 67.00, 1, NULL, 'Cancelled', NULL, NULL),
(10, 8, NULL, 'oreo milkshake', 'uploads/1742491393_orea.jpg', 78.00, 1, NULL, 'Cancelled', NULL, NULL),
(11, 8, NULL, 'mango', 'uploads/1742490134_mangoice.jpg', 80.00, 1, NULL, 'Cancelled', NULL, NULL),
(12, 8, NULL, 'burger', 'uploads/1744627088_burger.jpg', 100.00, 1, NULL, 'Cancelled', NULL, NULL),
(13, 8, NULL, 'Masalachat', 'uploads/1744627506_masalachat.jpg', 90.00, 1, NULL, 'Cancelled', NULL, NULL),
(14, 9, NULL, 'mango', 'uploads/1742490134_mangoice.jpg', 80.00, 1, NULL, 'Delivered', 'mango ice cream is so good', NULL),
(15, 9, NULL, 'caramel', 'uploads/1742551313_caramel.jpg', 33.00, 2, NULL, 'Delivered', NULL, NULL),
(16, 10, NULL, 'blueberry', 'uploads/1742490021_blueberry.jpg', 67.00, 2, NULL, 'Pending', NULL, NULL),
(17, 11, NULL, 'caramel', 'uploads/1742551313_caramel.jpg', 33.00, 2, NULL, 'Pending', NULL, NULL),
(18, 11, NULL, 'Masalachat', 'uploads/1744627506_masalachat.jpg', 90.00, 2, NULL, 'Pending', NULL, NULL),
(19, 12, NULL, 'frenchfries', 'uploads/1742359887_frenchfries.jpg', 70.00, 2, 140.00, 'Delivered', NULL, NULL),
(20, 13, NULL, 'blueberry', 'uploads/1742490021_blueberry.jpg', 67.00, 1, 67.00, 'Delivered', NULL, NULL),
(21, 14, NULL, 'burger', 'uploads/1744627088_burger.jpg', 100.00, 2, 200.00, 'Delivered', 'nice one go for it', NULL),
(22, 14, NULL, 'oreo milkshake', 'uploads/1742491393_orea.jpg', 78.00, 1, 78.00, 'Cancelled', NULL, NULL),
(23, 15, NULL, 'mango', 'uploads/1742490134_mangoice.jpg', 80.00, 1, 80.00, 'Delivered', NULL, NULL),
(24, 15, NULL, 'frenchfries', 'uploads/1742359887_frenchfries.jpg', 70.00, 1, 70.00, 'Cancelled', NULL, NULL),
(25, 16, NULL, 'mango', 'uploads/1742490134_mangoice.jpg', 80.00, 1, 80.00, 'Pending', NULL, NULL),
(26, 16, NULL, 'Masalachat', 'uploads/1744627506_masalachat.jpg', 90.00, 1, 90.00, 'Delivered', NULL, NULL),
(27, 17, NULL, 'mango', 'uploads/1742490134_mangoice.jpg', 80.00, 2, 160.00, 'Delivered', 'good one', NULL),
(28, 17, NULL, 'blueberry', 'uploads/1742490021_blueberry.jpg', 67.00, 1, 67.00, 'Delivered', 'nice blueberry', NULL),
(29, 18, NULL, 'oreo milkshake', 'uploads/1742491393_orea.jpg', 78.00, 1, 78.00, 'Cancelled', NULL, NULL),
(30, 18, NULL, 'caramel', 'uploads/1742551313_caramel.jpg', 33.00, 1, 33.00, 'Cancelled', NULL, NULL),
(31, 19, NULL, 'mango', 'uploads/1742490134_mangoice.jpg', 80.00, 1, 80.00, 'Cancelled', NULL, NULL),
(32, 20, NULL, 'mango', 'uploads/1742490134_mangoice.jpg', 80.00, 1, 80.00, 'Pending', NULL, NULL),
(33, 21, NULL, 'oreo milkshake', 'uploads/1742491393_orea.jpg', 78.00, 1, 78.00, 'Delivered', NULL, NULL),
(34, 22, NULL, 'oreo milkshake', 'uploads/1742491393_orea.jpg', 78.00, 1, 78.00, 'Delivered', NULL, NULL),
(35, 23, NULL, 'Masalachat', 'uploads/1744627506_masalachat.jpg', 90.00, 1, 90.00, 'Delivered', NULL, NULL),
(36, 23, NULL, 'blueberry', 'uploads/1742490021_blueberry.jpg', 67.00, 1, 67.00, 'Pending', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` enum('icecream','dessert','milkshake') NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `category`, `image`, `created_at`) VALUES
(2, 'frenchfries', 70.00, 'dessert', 'uploads/1742359887_frenchfries.jpg', '2025-03-19 04:51:27'),
(3, 'blueberry', 67.00, 'icecream', 'uploads/1742490021_blueberry.jpg', '2025-03-20 17:00:21'),
(4, 'mango', 80.00, 'icecream', 'uploads/1742490134_mangoice.jpg', '2025-03-20 17:02:14'),
(5, 'oreo milkshake', 78.00, 'milkshake', 'uploads/1742491393_orea.jpg', '2025-03-20 17:23:13'),
(6, 'caramel', 33.00, 'milkshake', 'uploads/1742551313_caramel.jpg', '2025-03-21 10:01:53'),
(8, 'Masalachat', 90.00, 'dessert', 'uploads/1744627506_masalachat.jpg', '2025-04-14 10:45:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `address`) VALUES
(1, 'Harshendra P', 'harshendrapoojary29355@gmail.com', '$2y$10$8QeXcQBOlZErDesqQZD9uOF4lKkfoKeUAI3/Iz9xzwwHWQevzOGfC', '9449772658', 'Pana house Balpa village and post'),
(2, 'Vikram', 'Vikram@gmail.com', '$2y$10$pWSrVqevwqbA1iO0E4foLeieE81QOQuN558kgHE1UmJEwrl37ppje', '9626456789', '2nd street thokottu Ullala');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `allowed_pincodes`
--
ALTER TABLE `allowed_pincodes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pincode` (`pincode`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `allowed_pincodes`
--
ALTER TABLE `allowed_pincodes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
