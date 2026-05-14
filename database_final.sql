-- ============================================================================
-- PFE MARKETPLACE DATABASE EXPORT
-- Generated for phpMyAdmin / MySQL
-- ============================================================================

-- 1. Create and Select Database
CREATE DATABASE IF NOT EXISTS `marketplace_pfe`;
USE `marketplace_pfe`;

-- 2. Drop existing tables to prevent "Table already exists" errors
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `order_items`;
DROP TABLE IF EXISTS `orders`;
DROP TABLE IF EXISTS `products`;
DROP TABLE IF EXISTS `categories`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `password_reset_tokens`;
DROP TABLE IF EXISTS `sessions`;
DROP TABLE IF EXISTS `migrations`;
SET FOREIGN_KEY_CHECKS = 1;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- ----------------------------------------------------------------------------
-- DATABASE CHARSET SETTINGS
-- ----------------------------------------------------------------------------
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- ----------------------------------------------------------------------------
-- TABLE: users
-- ----------------------------------------------------------------------------
CREATE TABLE `users` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `email_verified_at` TIMESTAMP NULL DEFAULT NULL,
    `password` VARCHAR(255) NOT NULL,
    `role` ENUM('buyer', 'seller') NOT NULL DEFAULT 'buyer',
    `phone` VARCHAR(20) DEFAULT NULL,
    `address` TEXT DEFAULT NULL,
    `city` VARCHAR(100) DEFAULT NULL,
    `postal_code` VARCHAR(20) DEFAULT NULL,
    `country` VARCHAR(100) DEFAULT NULL,
    `remember_token` VARCHAR(100) DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `users_email_unique` (`email`),
    KEY `users_role_index` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- TABLE: categories
-- ----------------------------------------------------------------------------
CREATE TABLE `categories` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT '1',
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- TABLE: products
-- ----------------------------------------------------------------------------
CREATE TABLE `products` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `seller_id` BIGINT UNSIGNED NOT NULL,
    `category_id` BIGINT UNSIGNED NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `price` DECIMAL(10,2) NOT NULL,
    `stock` INT UNSIGNED NOT NULL DEFAULT '0',
    `image_path` VARCHAR(255) DEFAULT NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT '1',
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `products_seller_id_index` (`seller_id`),
    KEY `products_category_id_index` (`category_id`),
    KEY `products_is_active_index` (`is_active`),
    CONSTRAINT `products_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- TABLE: orders
-- ----------------------------------------------------------------------------
CREATE TABLE `orders` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `buyer_id` BIGINT UNSIGNED NOT NULL,
    `total_amount` DECIMAL(10,2) NOT NULL,
    `status` ENUM('pending', 'accepted', 'rejected', 'partially_accepted') NOT NULL DEFAULT 'pending',
    `shipping_address` VARCHAR(255) NOT NULL,
    `shipping_city` VARCHAR(100) NOT NULL,
    `shipping_postal_code` VARCHAR(20) NOT NULL,
    `shipping_country` VARCHAR(100) NOT NULL,
    `payment_method` VARCHAR(100) NOT NULL,
    `ordered_at` TIMESTAMP NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `orders_buyer_id_index` (`buyer_id`),
    KEY `orders_status_index` (`status`),
    CONSTRAINT `orders_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- TABLE: order_items
-- ----------------------------------------------------------------------------
CREATE TABLE `order_items` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `order_id` BIGINT UNSIGNED NOT NULL,
    `product_id` BIGINT UNSIGNED NOT NULL,
    `seller_id` BIGINT UNSIGNED NOT NULL,
    `quantity` INT UNSIGNED NOT NULL,
    `unit_price` DECIMAL(10,2) NOT NULL,
    `status` ENUM('pending', 'accepted', 'rejected') NOT NULL DEFAULT 'pending',
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `order_items_order_id_index` (`order_id`),
    KEY `order_items_product_id_index` (`product_id`),
    KEY `order_items_seller_id_index` (`seller_id`),
    KEY `order_items_status_index` (`status`),
    CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
    CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
    CONSTRAINT `order_items_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- SAMPLE DATA (INSERT STATEMENTS)
-- ----------------------------------------------------------------------------

-- 1. Insert Users (Password: 'password' hashed)
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `city`, `country`, `created_at`, `updated_at`) VALUES
(1, 'John Seller', 'seller@example.com', '$2y$12$fS1nL9V9/lX8D1G4W5n/8O2z.O/8G8/O.8G8/O.8G8/O.8G8/O.8G', 'seller', 'Casablanca', 'Morocco', NOW(), NOW()),
(2, 'Alice Buyer', 'buyer@example.com', '$2y$12$fS1nL9V9/lX8D1G4W5n/8O2z.O/8G8/O.8G8/O.8G8/O.8G8/O.8G', 'buyer', 'Rabat', 'Morocco', NOW(), NOW());

-- 2. Insert Categories
INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Electronics', 'electronics', 'Gadgets, phones, and laptops', NOW(), NOW()),
(2, 'Clothing', 'clothing', 'Fashion and apparel', NOW(), NOW());

-- 3. Insert Products
INSERT INTO `products` (`id`, `seller_id`, `category_id`, `name`, `description`, `price`, `stock`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Smartphone X', 'Latest high-end smartphone', 799.99, 10, NOW(), NOW()),
(2, 1, 1, 'Laptop Pro', 'Professional workstation', 1299.00, 5, NOW(), NOW()),
(3, 1, 2, 'Organic T-Shirt', '100% cotton eco-friendly t-shirt', 25.00, 50, NOW(), NOW());

-- 4. Insert an Order
INSERT INTO `orders` (`id`, `buyer_id`, `total_amount`, `status`, `shipping_address`, `shipping_city`, `shipping_postal_code`, `shipping_country`, `payment_method`, `ordered_at`, `created_at`, `updated_at`) VALUES
(1, 2, 824.99, 'pending', '123 Main St', 'Rabat', '10000', 'Morocco', 'cash_on_delivery', NOW(), NOW(), NOW());

-- 5. Insert Order Items
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `seller_id`, `quantity`, `unit_price`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, 799.99, 'pending', NOW(), NOW()),
(2, 1, 3, 1, 1, 25.00, 'pending', NOW(), NOW());

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
