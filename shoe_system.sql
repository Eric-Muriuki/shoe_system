-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2025 at 09:23 AM
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
-- Database: `shoe_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `icon_class` varchar(50) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `icon_class`) VALUES
(1, 'Mens', 'fas fa-male'),
(2, 'Womens', 'fas fa-female'),
(3, 'Kids', 'fas fa-child'),
(4, 'Mens', 'fas fa-male'),
(5, 'Womens', 'fas fa-female'),
(6, 'Kids', 'fas fa-child'),
(7, 'Mens', 'fas fa-male'),
(8, 'Womens', 'fas fa-female'),
(9, 'Kids', 'fas fa-child');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `password`, `is_admin`, `created_at`) VALUES
(1, 'hope nyambura', 'defhopeee@gmail.com', '$2y$10$giy71eqF1egcFg8yFis8PuGT3zqNbPDgAEIlU2S1vrMGlaD32JAkq', 0, '2025-02-22 06:46:43'),
(2, 'Eric Muriuki', 'ericmuriuki@gmail.com', '$2y$10$jTohw/wR8F1SpuwXKa1iw.pevTRayBe718FSiBdpjddQS94wvvDOW', 1, '2025-02-22 06:55:02'),
(3, 'Nicole Masila', 'nicole@gmail.com', '$2y$10$1fVQiW57BOoL2R9UnttqU.gcQhRFQ1P/UQhZdFEvLVgo.sM94f2LO', 0, '2025-02-22 14:26:40'),
(4, 'Felix Mumo', 'felixmumo@gmail.com', '$2y$10$iRKsY5p23DCJZO9MFEa/0eiKhSyDGe8D4fszEJxqhi96dhFXYsxN2', 0, '2025-02-24 08:01:57');

-- --------------------------------------------------------

--
-- Table structure for table `media_links`
--

CREATE TABLE `media_links` (
  `id` int(11) NOT NULL,
  `platform` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL,
  `icon_class` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_settings`
--

CREATE TABLE `notification_settings` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `email_notifications` tinyint(1) DEFAULT 1,
  `sms_notifications` tinyint(1) DEFAULT 0,
  `push_notifications` tinyint(1) DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notification_settings`
--

INSERT INTO `notification_settings` (`id`, `customer_id`, `email_notifications`, `sms_notifications`, `push_notifications`, `updated_at`) VALUES
(1, 2, 1, 1, 1, '2025-02-22 08:55:53'),
(2, 1, 1, 1, 1, '2025-02-23 16:38:59');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total` decimal(10,2) NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `shipping_name` varchar(255) DEFAULT NULL,
  `shipping_address` text DEFAULT NULL,
  `shipping_phone` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `order_date`, `total`, `status`, `shipping_name`, `shipping_address`, `shipping_phone`) VALUES
(1, 1, '2025-02-22 21:56:12', 2000.00, 'Pending', 'Hope', 'ruiru', '0712345678'),
(2, 1, '2025-02-22 21:57:04', 2000.00, 'Pending', 'Hope', 'ruiru', '0712345678'),
(3, 1, '2025-02-22 22:06:16', 2000.00, 'Delivered', 'Hope', 'ruiru', '0712345678'),
(4, 1, '2025-02-22 22:19:07', 6000.00, 'Cancelled', 'Hope', 'ruiru', '0712345678'),
(5, 1, '2025-02-23 06:11:14', 1000.00, 'Pending', 'Hope', 'ruiru', '0712345678'),
(6, 1, '2025-02-23 12:06:53', 2000.00, 'Pending', 'Hope', 'ruiru', '0712345678'),
(7, 2, '2025-02-24 05:42:15', 1200.00, 'Pending', 'Hope', 'ruiru', '0712345678');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `order_detail_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `shoe_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_detail_id`, `order_id`, `shoe_id`, `quantity`, `price`) VALUES
(1, 1, 1, 1, 2000.00),
(2, 2, 1, 1, 2000.00),
(3, 3, 1, 1, 2000.00),
(4, 4, 1, 3, 2000.00),
(5, 5, 2, 1, 1000.00),
(6, 6, 1, 1, 2000.00),
(7, 7, 14, 1, 1200.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `shoe_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_history`
--

CREATE TABLE `password_history` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `old_password` varchar(255) NOT NULL,
  `changed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `payment_method` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_status` varchar(50) DEFAULT 'Pending',
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `order_id`, `payment_method`, `amount`, `payment_status`, `payment_date`) VALUES
(4, NULL, 'card', 99.99, 'Completed', '2025-02-22 08:32:53'),
(5, NULL, 'paypal', 99.99, 'Completed', '2025-02-22 08:34:12'),
(6, NULL, 'mpesa', 99.99, 'Completed', '2025-02-22 08:34:24'),
(7, NULL, 'card', 99.99, 'Completed', '2025-02-22 08:40:56'),
(8, NULL, 'paypal', 99.99, 'Completed', '2025-02-22 23:57:47'),
(9, NULL, 'mpesa', 99.99, 'Completed', '2025-02-23 00:14:58'),
(10, NULL, 'paypal', 99.99, 'Completed', '2025-02-23 00:16:54');

-- --------------------------------------------------------

--
-- Table structure for table `quick_links`
--

CREATE TABLE `quick_links` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `rating` tinyint(4) NOT NULL,
  `review_text` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shoes`
--

CREATE TABLE `shoes` (
  `shoe_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `size` varchar(50) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `availability` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `colors` varchar(255) DEFAULT 'Unknown',
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shoes`
--

INSERT INTO `shoes` (`shoe_id`, `name`, `description`, `price`, `size`, `color`, `availability`, `image`, `quantity`, `created_at`, `colors`, `category`) VALUES
(1, 'Airforce', 'Airforce shoe combines lightweight comfort, sleek design, and advanced cushioning for all-day agility and style.', 2000.00, '39', 'Black,White', 'In Stock', '/shoe_system/airforce.jpg', 7, '2025-02-22 15:06:42', 'Unknown', 'Men'),
(2, 'Heels', 'Strut in style with our elegantly crafted heels that seamlessly blend contemporary design with all-day comfort.', 1000.00, '38,39,40', 'Blue,Brown,Yello', 'In Stock', '/shoe_system/heels.jpg', 10, '2025-02-22 15:39:03', 'Unknown', 'Women'),
(3, 'Christian Dior', 'Experience luxury and sophistication with our exclusive Christian Dior shoes, crafted for elegance and timeless style.', 2000.00, '40', 'Black', 'In Stock', '/shoe_system/christian dior.jpg', 6, '2025-02-22 22:19:09', 'Unknown', 'Women'),
(4, 'Clarks', 'Step into comfort and durability with Clarks shoes, designed for timeless style and all-day support.', 1200.00, '38,39,40,41', 'White,Brown,Black', 'In Stock', '/shoe_system/clarks.jpg', 10, '2025-02-22 22:20:38', 'Unknown', 'Men'),
(5, 'Closed sandals', 'Experience the perfect blend of breathability and protection with closed sandal shoes, designed for style and comfort in every step.', 300.00, '37,38,39,40', 'Red,Blue,Brown', 'In Stock', '/shoe_system/closed sandals.jpg', 30, '2025-02-22 22:23:13', 'Unknown', 'Women'),
(6, 'jordan 4\'s', 'Jordan 4\'s combine iconic design with superior comfort and performance, making them a must-have for sneaker enthusiasts.', 2000.00, '38,39,40,41', 'Blue,Black,Red', 'In Stock', '/shoe_system/jordan 4\'s.jpg', 15, '2025-02-22 22:25:00', 'Unknown', 'Men'),
(7, 'Loafers', 'Loafer shoes offer a perfect blend of elegance and comfort, ideal for both casual and formal wear.', 1000.00, '38,39,40', 'Black', 'In Stock', '/shoe_system/loafers.jpg', 12, '2025-02-22 22:26:48', 'Unknown', 'Men'),
(8, 'Open kids sandals', 'Open kids\' sandals provide breathable comfort and stylish durability, perfect for little feet on the move.', 200.00, '5,6,7,8,9,10', 'Pink,Brown', 'In Stock', '/shoe_system/open kids sandals.jpg', 17, '2025-02-22 22:29:16', 'Unknown', 'Kids'),
(9, 'Open sandals', 'Open sandals offer a perfect blend of breathability, comfort, and style for any casual outing.', 150.00, '38,39,40,41', 'Black,Green', 'Out of Stock', '/shoe_system/open sandals.jpg', 0, '2025-02-22 22:34:50', 'Unknown', 'Men'),
(10, 'Sambas', 'Samba shoes combine classic design with durable comfort, perfect for both casual wear and sports-inspired style.', 1400.00, '37,38,39,40', 'Brown,White,Black', 'In Stock', '/shoe_system/sambas.jpg', 20, '2025-02-22 22:36:23', 'Unknown', 'Men'),
(11, 'Sharpshooters', 'Sharpshooters shoes deliver precision, agility, and style, designed for ultimate performance and confidence.', 1300.00, '38,39,40,41', 'Brown,Black', 'In Stock', '/shoe_system/sharpshooters.jpg', 22, '2025-02-22 22:38:08', 'Unknown', 'Men'),
(12, 'UGG', 'UGG shoes offer unmatched comfort and warmth with their signature plush lining and stylish, versatile designs.', 350.00, '35,36,37,38,39', 'Red,Blue,Brown', 'In Stock', '/shoe_system/ugg.jpg', 14, '2025-02-22 22:39:20', 'Unknown', 'Kids'),
(14, 'Vans', 'Vans shoes deliver iconic skate-inspired style with durable construction, superior grip, and all-day comfort.', 1200.00, '8,9,10', 'White,Black', 'In Stock', '/shoe_system/vans.jpg', 28, '2025-02-22 22:41:29', 'Unknown', 'Kids');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `media_links`
--
ALTER TABLE `media_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_settings`
--
ALTER TABLE `notification_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_detail_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `shoe_id` (`shoe_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `shoe_id` (`shoe_id`);

--
-- Indexes for table `password_history`
--
ALTER TABLE `password_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `quick_links`
--
ALTER TABLE `quick_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `shoes`
--
ALTER TABLE `shoes`
  ADD PRIMARY KEY (`shoe_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `media_links`
--
ALTER TABLE `media_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_settings`
--
ALTER TABLE `notification_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `password_history`
--
ALTER TABLE `password_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `quick_links`
--
ALTER TABLE `quick_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shoes`
--
ALTER TABLE `shoes`
  MODIFY `shoe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notification_settings`
--
ALTER TABLE `notification_settings`
  ADD CONSTRAINT `notification_settings_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`shoe_id`) REFERENCES `shoes` (`shoe_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`shoe_id`) REFERENCES `shoes` (`shoe_id`) ON DELETE CASCADE;

--
-- Constraints for table `password_history`
--
ALTER TABLE `password_history`
  ADD CONSTRAINT `password_history_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `shoes` (`shoe_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
