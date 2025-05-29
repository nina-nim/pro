-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 29 mai 2025 à 12:11
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gad`
--

-- --------------------------------------------------------

--
-- Structure de la table `merchant_accounts`
--

DROP TABLE IF EXISTS `merchant_accounts`;
CREATE TABLE IF NOT EXISTS `merchant_accounts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `payment_method` varchar(50) NOT NULL,
  `account_number` varchar(100) NOT NULL,
  `account_name` varchar(100) NOT NULL,
  `balance` decimal(15,2) DEFAULT '0.00',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `merchant_accounts`
--

INSERT INTO `merchant_accounts` (`id`, `payment_method`, `account_number`, `account_name`, `balance`, `is_active`, `created_at`) VALUES
(1, 'dmoney', '+253-77-09-06-95', 'HUILE SHOP D-MONEY', 0.00, 1, '2025-05-29 10:53:41'),
(2, 'waafi', '+253-77-09-06-95', 'HUILE SHOP WAAFI', 0.00, 1, '2025-05-29 10:53:41'),
(3, 'cacpay', 'CAC-123456789', 'HUILE SHOP CAC', 0.00, 1, '2025-05-29 10:53:41'),
(4, 'sabapay', 'SP-HUILESHOP-001', 'HUILE SHOP SABAPAY', 0.00, 1, '2025-05-29 10:53:41'),
(5, 'card', 'STRIPE-ACC-001', 'HUILE SHOP STRIPE', 0.00, 1, '2025-05-29 10:53:41');

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `order_cost` decimal(6,2) NOT NULL,
  `order_status` varchar(100) NOT NULL DEFAULT 'on_hold',
  `user_id` int NOT NULL,
  `user_phone` int NOT NULL,
  `user_city` varchar(255) NOT NULL,
  `user_address` varchar(255) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `payment_status` enum('unpaid','paid','refunded') DEFAULT 'unpaid',
  PRIMARY KEY (`order_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`order_id`, `order_cost`, `order_status`, `user_id`, `user_phone`, `user_city`, `user_address`, `order_date`, `payment_status`) VALUES
(2, 9999.99, 'not paid', 1, 7777777, 'djibouti', 'pk12,balbala', '2025-02-06 21:47:43', 'unpaid'),
(3, 9999.99, 'not paid', 1, 7777777, 'djibouti', 'pk12,balbala', '2025-02-06 21:48:10', 'unpaid'),
(4, 9999.99, 'on hold', 1, 7777777, 'djibouti', 'pk12,balbala', '2025-02-06 21:49:46', 'unpaid'),
(5, 9999.99, 'on hold', 1, 7777777, 'djibouti', 'pk12,balbala', '2025-02-06 21:50:24', 'unpaid'),
(6, 9999.99, 'on hold', 1, 7777777, 'djibouti', 'pk12,balbala', '2025-02-07 08:14:57', 'unpaid'),
(7, 9999.99, 'delivered', 1, 7777777, 'djibouti', 'pk12,balbala', '2025-02-07 08:42:19', 'unpaid'),
(8, 9999.99, 'on hold', 1, 7777777, 'djibouti', 'pk12,balbala', '2025-02-07 10:14:55', 'unpaid'),
(9, 9999.99, 'on hold', 1, 7777777, 'djibouti', 'pk12,balbala', '2025-02-08 14:37:55', 'unpaid'),
(10, 9999.99, 'not paid', 6, 7777777, 'djibouti', 'pk12,balbala', '2025-04-29 18:43:58', 'unpaid'),
(11, 9999.99, 'not paid', 6, 7777777, 'djibouti', 'pk12,balbala', '2025-04-29 18:44:15', 'unpaid'),
(12, 9999.99, 'not paid', 6, 7777777, 'djibouti', 'pk12,balbala', '2025-05-01 16:52:37', 'unpaid'),
(13, 9999.99, 'not paid', 7, 77090695, 'djibouti', 'pk12,balbala', '2025-05-29 08:43:09', 'unpaid'),
(14, 9999.99, 'not paid', 7, 77090695, 'djibouti', 'pk12,balbala', '2025-05-29 10:25:48', 'unpaid');

-- --------------------------------------------------------

--
-- Structure de la table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `item_id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_price` int NOT NULL,
  `product_quantity` int NOT NULL,
  `user_id` int NOT NULL,
  `order_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`item_id`),
  KEY `product_id` (`product_id`(250)),
  KEY `user_id` (`user_id`),
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `order_items`
--

INSERT INTO `order_items` (`item_id`, `order_id`, `product_id`, `product_name`, `product_image`, `product_price`, `product_quantity`, `user_id`, `order_date`) VALUES
(1, 5, '3', 'Liba Oil 20L', 'liba.png', 6000, 5, 1, '2025-02-06 21:50:24'),
(2, 5, '1', 'Liba Oil 3L', 'liba.png', 5000, 5, 1, '2025-02-06 21:50:24'),
(3, 6, '1', 'Liba Oil 3L', 'liba.png', 5000, 5, 1, '2025-02-07 08:14:57'),
(4, 7, '1', 'Liba Oil 3L', 'liba.png', 5000, 5, 1, '2025-02-07 08:42:19'),
(5, 8, '1', 'Liba Oil 3L', 'liba.png', 5000, 5, 1, '2025-02-07 10:14:55'),
(6, 9, '1', 'Liba Oil 3L', 'liba.png', 5000, 5, 1, '2025-02-08 14:37:55'),
(7, 10, '2', 'Liba Oil 5L', 'liba.png', 8500, 5, 6, '2025-04-29 18:43:58'),
(8, 11, '2', 'Liba Oil 5L', 'liba.png', 8500, 5, 6, '2025-04-29 18:44:15'),
(9, 11, '3', 'Liba Oil 20L', 'liba.png', 6000, 5, 6, '2025-04-29 18:44:15'),
(10, 12, '1', 'Liba Oil 3L', 'liba.png', 5000, 5, 6, '2025-05-01 16:52:37'),
(11, 13, '1', 'Liba Oil 3L', 'liba.png', 5000, 5, 7, '2025-05-29 08:43:09'),
(12, 14, '2', 'Liba Oil 5L', 'liba.png', 8500, 5, 7, '2025-05-29 10:25:48');

-- --------------------------------------------------------

--
-- Structure de la table `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `user_id` int NOT NULL,
  `payment_method` enum('dmoney','waafi','cacpay','sabapay','card') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('pending','completed','failed','cancelled') DEFAULT 'pending',
  `transaction_reference` varchar(100) DEFAULT NULL,
  `payment_details` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `product_name` varchar(100) NOT NULL,
  `product_description` varchar(10000) DEFAULT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_price` decimal(6,2) NOT NULL,
  `volume` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_description`, `product_image`, `product_price`, `volume`) VALUES
(1, 'Liba Oil 3L', 'Liba Refined Palm Oil is a fortified cooking oil known for its purity, superior quality, and compliance with international standards. Manufactured under strict procedures, it ensures a light texture, excellent high-temperature stability, and long shelf life. Its advanced refining process results in an oil that is odor-free, impurity-free, and rich in essential nutrients. Liba is the ideal choice for healthy and flavorful cooking, meeting the needs of both professionals and demanding consumers.', 'liba.png', 5000.00, NULL),
(2, 'Liba Oil 5L', 'Liba Refined Palm Oil is a fortified cooking oil known for its purity, superior quality, and compliance with international standards. Manufactured under strict procedures, it ensures a light texture, excellent high-temperature stability, and long shelf life. Its advanced refining process results in an oil that is odor-free, impurity-free, and rich in essential nutrients. Liba is the ideal choice for healthy and flavorful cooking, meeting the needs of both professionals and demanding consumers.', 'liba.png', 8500.00, NULL),
(3, 'Liba Oil 20L', 'Liba Refined Palm Oil is a fortified cooking oil known for its purity, superior quality, and compliance with international standards. Manufactured under strict procedures, it ensures a light texture, excellent high-temperature stability, and long shelf life. Its advanced refining process results in an oil that is odor-free, impurity-free, and rich in essential nutrients. Liba is the ideal choice for healthy and flavorful cooking, meeting the needs of both professionals and demanding consumers.', 'liba.png', 6000.00, NULL),
(4, 'Liba Oil 25L', 'Liba Refined Palm Oil is a fortified cooking oil known for its purity, superior quality, and compliance with international standards. Manufactured under strict procedures, it ensures a light texture, excellent high-temperature stability, and long shelf life. Its advanced refining process results in an oil that is odor-free, impurity-free, and rich in essential nutrients. Liba is the ideal choice for healthy and flavorful cooking, meeting the needs of both professionals and demanding consumers.', 'liba.png', 7500.00, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `UX_Constraint` (`user_email`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_password`) VALUES
(1, 'neima ali', 'neimaali0128@gmail.com', '5abb483f1b9976d7a80bfa35f2a0c316'),
(4, 'oubh', 'hass@gmail.com', '25d55ad283aa400af464c76d713c07ad'),
(6, 'neima ali', 'neimaali550@gmail.com', '25d55ad283aa400af464c76d713c07ad'),
(7, 'Maray Anne', 'anne@gmail.com', '3d35c71621575b29300ebeb0fa198b09');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
