CREATE DATABASE IF NOT EXISTS mywebsite_db;
USE mywebsite_db;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------
-- Table structure for table `categories`
-- --------------------------------------------------------

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `categories` (`id`, `name`, `parent_id`) VALUES
(1, 'Home Decor', NULL),
(2, 'Kir / Yarn', NULL),
(3, 'Kids Toy', NULL),
(4, 'Other', NULL),
(5, 'Wall Art', 1),
(6, 'Baskets', 1),
(7, 'Zenbaba Set', 4);

-- --------------------------------------------------------
-- Table structure for table `orders`
-- --------------------------------------------------------

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_id` varchar(50) DEFAULT NULL,
  `tracking_id` varchar(50) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `payment_method` varchar(20) DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `orders` VALUES
(33,'ORD1769498016','TRK542777',0.00,13,'CBE','2026-01-28','Pending','2026-01-27 07:13:36',NULL,'0967',''),
(40,'ORD1769501462','TRK586867',10.00,2,'cash','2026-01-28','Pending','2026-01-27 08:11:02',NULL,'',''),
(41,'ORD1769501512','TRK573397',10.00,13,'Abyssinia','2026-01-28','Delivered','2026-01-27 08:11:52',NULL,'12',''),
(42,'ORD1769503018','TRK435980',15.00,13,'cash','2026-01-29','Pending','2026-01-27 08:36:58',NULL,'',''),
(43,'ORD1769506941','TRK251250',25.00,13,'cash','2026-01-28','Pending','2026-01-27 09:42:21',NULL,'',''),
(44,'ORD1769507046','TRK964924',10.00,13,'cash','2026-01-28','Pending','2026-01-27 09:44:06',NULL,'',''),
(45,'ORD1769507194','TRK282915',4.00,13,'cash','2026-01-29','Pending','2026-01-27 09:46:34',NULL,'',''),
(46,'ORD1769507349','TRK105587',4.00,13,'cash','2026-01-28','Pending','2026-01-27 09:49:09',NULL,'',''),
(47,'ORD1769507452','TRK504127',4.00,2,'cash','2026-01-28','Pending','2026-01-27 09:50:52',NULL,'',''),
(48,'ORD1769508075','TRK161999',20.00,2,'CBE Bank','2026-01-28','Pending','2026-01-27 10:01:15',NULL,NULL,''),
(49,'ORD1769508246','TRK997869',4.00,2,'CBE Bank','2026-01-28','Pending','2026-01-27 10:04:06',NULL,'67',''),
(50,'ORD1769512395','TRK509082',14.00,13,'Cash on Delivery','2026-01-28','Pending','2026-01-27 11:13:15',NULL,'',''),
(51,'ORD1769512836','TRK712040',4.00,2,'Cash on Delivery','2026-01-28','Delivered','2026-01-27 11:20:36',NULL,'',''),
(52,'ORD1769515100','TRK396984',4.00,2,'Cash on Delivery','2026-01-28','Pending','2026-01-27 11:58:20',NULL,'','');

-- --------------------------------------------------------
-- Table structure for table `order_items`
-- --------------------------------------------------------

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` varchar(50) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `order_items` VALUES
(1,'1',3,1),
(2,'2',5,1),
(3,'3',4,1),
(4,'4',5,1),
(5,'5',5,1),
(6,'6',4,1);

-- --------------------------------------------------------
-- Table structure for table `products`
-- --------------------------------------------------------

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `products` VALUES
(3,'Kir Yarn','Handmade Kir Yarn',2.00,'kir.jpg',2,'2026-01-25 09:34:48'),
(4,'Kids Toy','Handmade kids toy',4.00,'kids.jpg',3,'2026-01-25 09:34:48'),
(5,'flower holder',NULL,5.00,'1769349174_flower_holder.jpg',1,'2026-01-25 13:52:54'),
(7,'mesob',NULL,20.00,'1769349911_mesob.jpg',4,'2026-01-25 14:05:11'),
(8,'sefed2',NULL,10.00,'1769351313_sefed 2.jpg',4,'2026-01-25 14:28:33'),
(9,'Wall art',NULL,4.00,'wo.jpg',5,'2026-01-25 20:30:45'),
(10,'flower holder large',NULL,7.00,'zenbaba.jpg',1,'2026-01-25 20:33:31'),
(11,'Agelgl',NULL,9.00,'agelgl.jpg',4,'2026-01-27 11:54:57'),
(12,'Fruit_holder small',NULL,5.00,'fruit_holder.jpg',1,'2026-01-27 11:55:30'),
(13,'Mesbo-zenbaba',NULL,25.00,'mesob 2.jpg',4,'2026-01-27 11:56:12');

-- --------------------------------------------------------
-- Table structure for table `users`
-- --------------------------------------------------------

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` VALUES
(2,'Admin','admin@yourdomain.com',NULL,'$2y$10$xuflhotrr28Kf3Mc.Wbyd.YWe.BfvPt6pi94jAZdjgR4F./k36hZG','admin','2026-01-25 15:36:53'),
(3,'bez k','bezawitkaye@gmail.com',NULL,'$2y$10$9L31Blw5H7wUiZ/BOqAwo.9s8NsmEgyYE5UetWthkG7vO4Zqyslqu','user','2026-01-25 17:59:24'),
(13,'bez','beza@gmail.com','0967','$2y$10$k3rXHlGuzGYD2pI9Fr5LzuecLQ6hGjla.EIw9xwPJ/F8Qcd./5loi','user','2026-01-27 07:13:08');

-- --------------------------------------------------------
-- Indexes & AUTO_INCREMENT
-- --------------------------------------------------------

ALTER TABLE `categories` ADD PRIMARY KEY (`id`);
ALTER TABLE `orders` ADD PRIMARY KEY (`id`);
ALTER TABLE `order_items` ADD PRIMARY KEY (`id`);
ALTER TABLE `products` ADD PRIMARY KEY (`id`);
ALTER TABLE `users` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `categories` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
ALTER TABLE `orders` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
ALTER TABLE `order_items` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
ALTER TABLE `products` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
ALTER TABLE `users` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
