-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2024 at 12:59 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `catering`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `full_name` varchar(200) NOT NULL,
  `email_id` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `phone_number` varchar(200) NOT NULL,
  `current_address` varchar(200) NOT NULL,
  `profile_image` varchar(200) NOT NULL,
  `account_create_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `reset_token` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `full_name`, `email_id`, `password`, `phone_number`, `current_address`, `profile_image`, `account_create_date`, `reset_token`, `updated_at`) VALUES
(1, 'Akash shivasharan shinde', 'akashsshinde0707@gmail.com', '$2y$10$NyYiBT3.iz0gxYB0wAhd6eqVz/3PI05mOE2Egd/YmIaCU1mAASCoq', '8329400225', 'Yashwantnagar, akluj', '../profile_image/1728043430_akash.png', '2024-10-07 04:50:04', '446cb9dda006fb02021d33b03067ee45', '2024-10-07 04:50:04');

-- --------------------------------------------------------

--
-- Table structure for table `color`
--

CREATE TABLE `color` (
  `id` int(11) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `color_name` varchar(200) NOT NULL,
  `quantity` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `credit_card`
--

CREATE TABLE `credit_card` (
  `id` int(11) NOT NULL,
  `product_seller_email_id` varchar(200) NOT NULL,
  `category` varchar(200) NOT NULL,
  `full_name` varchar(200) NOT NULL,
  `email_id` varchar(200) NOT NULL,
  `phone_number` varchar(200) NOT NULL,
  `card_type` varchar(200) NOT NULL,
  `card_number` varchar(200) NOT NULL,
  `card_holder` varchar(200) NOT NULL,
  `card_expires` varchar(200) NOT NULL,
  `card_cvc` varchar(200) NOT NULL,
  `side` varchar(200) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `product_price` varchar(200) NOT NULL,
  `product_color` varchar(200) NOT NULL,
  `size` int(200) NOT NULL,
  `delivery_charge` varchar(200) NOT NULL,
  `total_amount` varchar(200) NOT NULL,
  `address` varchar(200) NOT NULL,
  `city` varchar(200) NOT NULL,
  `country` varchar(200) NOT NULL,
  `zip` varchar(200) NOT NULL,
  `status` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `credit_card`
--

INSERT INTO `credit_card` (`id`, `product_seller_email_id`, `category`, `full_name`, `email_id`, `phone_number`, `card_type`, `card_number`, `card_holder`, `card_expires`, `card_cvc`, `side`, `product_name`, `product_price`, `product_color`, `size`, `delivery_charge`, `total_amount`, `address`, `city`, `country`, `zip`, `status`, `created_at`, `updated_at`) VALUES
(8, 'akashsshinde0707@gmail.com', 'male', 'Akash shivasharan shinde', 'shinde.akash9798@gmail.com\n', '8329400225', 'master_card', '63345455', '54455', '54', '554', 'shoes/3side.png', 'Nike Pegasus Custom Trail-Running Shoes 3', '15000', 'orange', 0, '100', '15100', 'Yashwantnagar,Akluj', 'Akluj', 'India', '413118', 'In Process', '2024-08-26 07:41:42', '2024-09-26 09:37:36'),
(9, 'akashsshinde0707@gmail.com', 'male', 'Akash shivasharan shinde', 'shinde.akash9798@gmail.com\n', '8329400225', 'rupay', '3444448225', 'r a shinde', '0727', '1907', 'shoes/5side.png', 'Nike Pegasus Custom Trail-Running Shoes', '25000', 'white', 9, '100', '25100', 'Yashwantnagar,Akluj', 'Akluj', 'India', '413118', 'Paid', '2024-08-29 08:40:34', '2024-09-26 09:37:44'),
(10, 'akashsshinde0707@gmail.com', 'male', 'Akash shivasharan shinde', 'shinde.akash9798@gmail.com\n', '8329400225', 'rupay', '11', 'aa', '1', '1', 'shoes/4side.png', 'Nike Pegasus Custom Trail-Running Shoes', '20000', 'green frost', 9, '100', '20100', 'Yashwantnagar,Akluj', 'Akluj', 'India', '413118', 'Refunded', '2024-08-29 10:03:25', '2024-09-26 09:37:47'),
(11, 'akashsshinde0707@gmail.com', 'male', 'Akash shivasharan shinde', 'shinde.akash9798@gmail.com\n', '8329400225', 'rupay', '55', 'aa', '22', '2', 'shoes/4side.png', 'Nike Pegasus Custom Trail-Running Shoes', '20000', 'green frost', 9, '100', '20100', 'Yashwantnagar,Akluj', 'Akluj', 'India', '413118', 'Canceled', '2024-09-26 10:05:58', '2024-09-26 09:37:49'),
(18, 'akashsshinde1907@gmail.com', 'male', 'Akash shivasharan shinde', 'shinde.akash9798@gmail.com\r\n', '8329400225', 'rupay', '55', 'aa', '22', '2', 'shoes/4side.png', 'Nike Pegasus Custom Trail-Running Shoes', '20000', 'green frost', 9, '100', '20100', 'Yashwantnagar,Akluj', 'Akluj', 'India', '413118', 'Canceled', '2024-09-20 10:05:58', '2024-09-26 09:37:53'),
(19, 'akashsshinde1907@gmail.com', 'female', 'Akash shivasharan shinde', 'akashsshinde0707@gmail.com', '8329400225', 'rupay', '5555555555', 'rutiii', '19/04', '007', 'shoes/2side.png', 'Nike Pegasus Custom Trail-Running Shoes', '1000', 'vintage green', 7, '50', '1050', 'Yashwantnagar,Akluj', 'Akluj', 'India', '413118', '', '2024-09-26 08:10:06', '2024-09-26 09:54:57'),
(20, 'akashsshinde1907@gmail.com', 'female', 'Akki shinde', 'shinde.akash9798@gmail.com', '8329400225', 'rupay', '19040707', 'rutiii', '19/04', '007', 'shoes/2side.png', 'Nike Pegasus Custom Trail-Running Shoes', '1000', 'vintage green', 7, '50', '1050', 'Yashwantnagar,Akluj', 'Akluj', 'India', '413118', '', '2024-09-26 08:22:05', '2024-09-26 09:55:00'),
(21, 'akashsshinde1907@gmail.com', 'female', 'Akki shinde', 'shinde.akash9798@gmail.com', '8329400225', 'rupay', '222', 'www', '11/11', '111', 'shoes/2side.png', 'Nike Pegasus Custom Trail-Running Shoes', '1000', 'vintage green', 7, '50', '1050', 'Yashwantnagar,Akluj', 'Akluj', 'India', '413118', '', '2024-09-26 08:28:56', '2024-09-26 09:55:02'),
(22, 'akashsshinde1907@gmail.com', 'female', 'Akki shinde', 'shinde.akash9798@gmail.com', '8329400225', 'rupay', '11', 'aa', '11/1', '11', 'shoes/2side.png', 'Nike Pegasus Custom Trail-Running Shoes', '1000', 'vintage green', 7, '50', '1050', 'Yashwantnagar,Akluj', 'Akluj', 'India', '413118', '', '2024-09-26 08:31:13', '2024-09-26 09:55:04'),
(23, 'akashsshinde0707@gmail.com', '', 'Akki shinde', 'shinde.akash9798@gmail.com', '8329400225', 'rupay', '75456', 'sfff', '45/45', '553', 'shoes/3side.png', 'Nike Pegasus Custom Trail-Running Shoes', '15000', 'orange', 9, '300', '15300', 'Yashwantnagar,Akluj', 'Akluj', 'India', '413118', '', '2024-09-26 12:20:42', NULL),
(24, 'akashsshinde0707@gmail.com', 'male', 'Akki shinde', 'shinde.akash9798@gmail.com', '8329400225', 'rupay', '1904200007071999', 'rutuja shinde', '07/28', '007', 'shoes/3side.png', 'Nike Pegasus Custom Trail-Running Shoes', '15000', 'orange', 9, '300', '15300', 'Yashwantnagar,Akluj', 'Akluj', 'India', '413118', '', '2024-09-26 12:29:46', NULL),
(25, 'akashsshinde0707@gmail.com', 'male', 'Akki shinde', 'shinde.akash9798@gmail.com', '8329400225', 'rupay', '22', 'aa', '11/12', '222', 'shoes/3side.png', 'Nike Pegasus Custom Trail-Running Shoes', '15000', 'orange', 9, '300', '15300', 'Yashwantnagar,Akluj', 'Akluj', 'India', '413118', '', '2024-09-26 12:32:04', NULL),
(26, 'akashsshinde0707@gmail.com', 'female', 'Akki shinde', 'shinde.akash9798@gmail.com', '8329400225', 'rupay', '1231', 'asd', '12/34', '123', 'shoes/6side2.png', 'Nike Pegasus Custom Trail-Running Shoes', '35000', 'Taupe Grey', 10, '800', '35800', 'Yashwantnagar,Akluj', 'Akluj', 'India', '413118', '', '2024-10-01 07:27:45', NULL),
(27, 'akashsshinde0707@gmail.com', 'male', 'Akki shinde', 'shinde.akash9798@gmail.com', '8329400225', 'rupay', '32236744', 'ffgf', '22/22', '222', 'shoes/3side.png', 'Nike Pegasus Custom Trail-Running Shoes', '15000', 'orange', 10, '300', '15300', 'Yashwantnagar,Akluj', 'Akluj', 'India', '413118', '', '2024-11-25 05:04:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `main_shoes`
--

CREATE TABLE `main_shoes` (
  `id` int(11) NOT NULL,
  `product_id` varchar(200) NOT NULL,
  `product_seller_email_id` varchar(200) NOT NULL,
  `product_seller_name` varchar(200) NOT NULL,
  `side` varchar(500) NOT NULL,
  `up` varchar(500) NOT NULL,
  `bottom` varchar(500) NOT NULL,
  `back` varchar(500) NOT NULL,
  `category` varchar(200) NOT NULL,
  `product_name` varchar(500) NOT NULL,
  `delivery_charge` varchar(500) NOT NULL,
  `product_color` varchar(500) NOT NULL,
  `product_price` varchar(500) NOT NULL,
  `quantity` varchar(500) NOT NULL,
  `size_1` int(200) NOT NULL,
  `size_1_original_price` int(200) NOT NULL,
  `size_1_price` int(200) NOT NULL,
  `size_2` int(200) NOT NULL,
  `size_2_original_price` int(200) NOT NULL,
  `size_2_price` int(200) NOT NULL,
  `size_3` int(200) NOT NULL,
  `size_3_original_price` int(200) NOT NULL,
  `size_3_price` int(200) NOT NULL,
  `size_4` int(200) NOT NULL,
  `size_4_original_price` int(200) NOT NULL,
  `size_4_price` int(200) NOT NULL,
  `size_5` int(200) NOT NULL,
  `size_5_original_price` int(200) NOT NULL,
  `size_5_price` int(200) NOT NULL,
  `size_6` int(200) NOT NULL,
  `size_6_original_price` int(200) NOT NULL,
  `size_6_price` int(200) NOT NULL,
  `size_7` int(200) NOT NULL,
  `size_7_original_price` int(200) NOT NULL,
  `size_7_price` int(200) NOT NULL,
  `size_8` int(200) NOT NULL,
  `size_8_original_price` int(200) NOT NULL,
  `size_8_price` int(200) NOT NULL,
  `size_9` int(200) NOT NULL,
  `size_9_original_price` int(200) NOT NULL,
  `size_9_price` int(200) NOT NULL,
  `size_10` int(200) NOT NULL,
  `size_10_original_price` int(200) NOT NULL,
  `size_10_price` int(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `main_shoes`
--

INSERT INTO `main_shoes` (`id`, `product_id`, `product_seller_email_id`, `product_seller_name`, `side`, `up`, `bottom`, `back`, `category`, `product_name`, `delivery_charge`, `product_color`, `product_price`, `quantity`, `size_1`, `size_1_original_price`, `size_1_price`, `size_2`, `size_2_original_price`, `size_2_price`, `size_3`, `size_3_original_price`, `size_3_price`, `size_4`, `size_4_original_price`, `size_4_price`, `size_5`, `size_5_original_price`, `size_5_price`, `size_6`, `size_6_original_price`, `size_6_price`, `size_7`, `size_7_original_price`, `size_7_price`, `size_8`, `size_8_original_price`, `size_8_price`, `size_9`, `size_9_original_price`, `size_9_price`, `size_10`, `size_10_original_price`, `size_10_price`, `created_at`, `updated_at`) VALUES
(1, 'pid01', 'akashsshinde0707@gmail.com', '', 'shoes/1side.png', 'shoes/1up.png', 'shoes/1bottom.png', 'shoes/1back.png', 'male', 'Nike Pegasus Custom Trail-Running Shoes', '100', 'black', '5000', '44', 1, 100, 150, 2, 200, 250, 3, 300, 350, 4, 400, 450, 5, 500, 560, 6, 600, 650, 5, 700, 750, 8, 800, 850, 0, 900, 950, 10, 1000, 1100, '2024-09-05 09:38:31', '2024-12-03 11:28:30'),
(2, 'pid02', 'akashsshinde0707@gmail.com', '', 'shoes/2side.png', 'shoes/2up.png', 'shoes/2bottom.png', 'shoes/2back.png', 'male', 'Nike Pegasus Custom Trail-Running Shoes', '50', 'vintage green', '1000', '50', 1, 100, 150, 2, 200, 250, 2, 300, 350, 4, 400, 450, 5, 500, 550, 6, 600, 650, 6, 700, 750, 5, 800, 850, 9, 900, 950, 10, 1000, 1100, '2024-09-05 09:38:31', '2024-12-03 05:54:54'),
(3, 'pid03', 'akashsshinde0707@gmail.com', '', 'shoes/3side.png', 'shoes/3up.png', 'shoes/3bottom.png', 'shoes/3back.png', 'male', 'Nike Pegasus Custom Trail-Running Shoes', '300', 'orange', '15000', '53', 1, 100, 150, 2, 200, 250, 2, 300, 350, 3, 400, 450, 5, 500, 550, 6, 600, 650, 7, 700, 750, 8, 800, 850, 9, 900, 950, 10, 1000, 1100, '2024-09-05 09:38:31', '2024-12-03 05:56:00'),
(4, 'pid04', 'akashsshinde0707@gmail.com', '', 'shoes/5side.png', 'shoes/5up.png', 'shoes/5bottom.png', 'shoes/5back.png', 'female', 'Nike Pegasus Custom Trail-Running Shoes', '400', 'white', '20000', '50', 1, 100, 150, 1, 200, 250, 3, 300, 350, 2, 400, 450, 5, 500, 550, 6, 600, 650, 6, 700, 750, 7, 800, 850, 9, 900, 950, 10, 1000, 1100, '2024-09-05 09:38:31', '2024-12-03 05:57:10'),
(5, 'pid05', 'akashsshinde0707@gmail.com', '', 'shoes/4side.png', 'shoes/4up.png', 'shoes/4bottom.png', 'shoes/4back.png', 'female', 'Nike Pegasus Custom Trail-Running Shoes', '500', 'green frost', '25000', '51', 1, 100, 150, 2, 200, 250, 1, 300, 350, 4, 400, 450, 5, 500, 550, 6, 600, 650, 7, 700, 750, 8, 800, 850, 7, 900, 950, 10, 1000, 1100, '2024-09-05 09:38:31', '2024-12-03 06:02:45'),
(38, 'pid06', 'akashsshinde0707@gmail.com', '', 'shoes/6side2.png', 'shoes/6up2.png', 'shoes/6bottom2.png', 'shoes/6back2.png', 'female', 'Nike Pegasus Custom Trail-Running Shoes', '800', 'Taupe Grey', '35000', '54', 1, 100, 150, 2, 200, 250, 3, 300, 350, 4, 400, 450, 5, 500, 550, 5, 600, 650, 7, 700, 750, 8, 800, 850, 9, 900, 950, 10, 1000, 1100, '2024-09-05 09:38:31', '2024-12-03 06:03:59'),
(40, 'PID07', 'akashsshinde0707@gmail.com', '', 'shoes/6side2.png', 'shoes/6up2.png', 'shoes/6bottom2.png', 'shoes/6back2.png', 'male', 'aa', '', 'red', '12121', '51', 1, 100, 150, 2, 200, 250, 2, 300, 350, 4, 400, 450, 5, 500, 550, 6, 600, 650, 5, 700, 750, 8, 800, 850, 8, 900, 950, 10, 1000, 1100, '2024-11-25 07:08:39', '2024-12-03 11:44:43'),
(41, 'PID08', '', '', 'shoes/5side.png', 'shoes/5up.png', 'shoes/5bottom.png', 'shoes/5back.png', 'female', 'rr', '', 'red', '', '19', 2, 100, 150, 2, 200, 250, 2, 300, 350, 1, 400, 450, 2, 500, 550, 2, 600, 650, 2, 700, 750, 2, 800, 850, 2, 900, 950, 2, 1000, 1050, '2024-12-02 10:58:22', '2024-12-03 11:56:29'),
(42, 'PID09', '', '', 'shoes/1side.png', 'shoes/1up.png', 'shoes/1bottom.png', 'shoes/1back.png', 'other', 'ww', '', 'blue', '', '10', 1, 2, 2, 1, 2, 2, 1, 2, 2, 1, 2, 2, 1, 2, 2, 1, 2, 2, 1, 2, 2, 1, 2, 2, 1, 2, 2, 1, 2, 2, '2024-12-02 11:41:27', '2024-12-03 11:45:30');

-- --------------------------------------------------------

--
-- Table structure for table `main_shoes_original`
--

CREATE TABLE `main_shoes_original` (
  `id` int(11) NOT NULL,
  `product_id` varchar(200) NOT NULL,
  `product_seller_email_id` varchar(200) NOT NULL,
  `product_seller_name` varchar(200) NOT NULL,
  `side` varchar(500) NOT NULL,
  `up` varchar(500) NOT NULL,
  `bottom` varchar(500) NOT NULL,
  `back` varchar(500) NOT NULL,
  `category` varchar(200) NOT NULL,
  `product_name` varchar(500) NOT NULL,
  `delivery_charge` varchar(500) NOT NULL,
  `product_color` varchar(500) NOT NULL,
  `product_price` varchar(500) NOT NULL,
  `quantity` varchar(500) NOT NULL,
  `size_1` int(200) NOT NULL,
  `size_1_price` int(200) NOT NULL,
  `size_2` int(200) NOT NULL,
  `size_2_price` int(200) NOT NULL,
  `size_3` int(200) NOT NULL,
  `size_3_price` int(200) NOT NULL,
  `size_4` int(200) NOT NULL,
  `size_4_price` int(200) NOT NULL,
  `size_5` int(200) NOT NULL,
  `size_5_price` int(200) NOT NULL,
  `size_6` int(200) NOT NULL,
  `size_6_price` int(200) NOT NULL,
  `size_7` int(200) NOT NULL,
  `size_7_price` int(200) NOT NULL,
  `size_8` int(200) NOT NULL,
  `size_8_price` int(200) NOT NULL,
  `size_9` int(200) NOT NULL,
  `size_9_price` int(200) NOT NULL,
  `size_10` int(200) NOT NULL,
  `size_10_price` int(200) NOT NULL,
  `size_1_original_price` int(200) NOT NULL,
  `size_2_original_price` int(200) NOT NULL,
  `size_3_original_price` int(200) NOT NULL,
  `size_4_original_price` int(200) NOT NULL,
  `size_5_original_price` int(200) NOT NULL,
  `size_6_original_price` int(200) NOT NULL,
  `size_7_original_price` int(200) NOT NULL,
  `size_8_original_price` int(200) NOT NULL,
  `size_9_original_price` int(200) NOT NULL,
  `size_10_original_price` int(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `main_shoes_original`
--

INSERT INTO `main_shoes_original` (`id`, `product_id`, `product_seller_email_id`, `product_seller_name`, `side`, `up`, `bottom`, `back`, `category`, `product_name`, `delivery_charge`, `product_color`, `product_price`, `quantity`, `size_1`, `size_1_price`, `size_2`, `size_2_price`, `size_3`, `size_3_price`, `size_4`, `size_4_price`, `size_5`, `size_5_price`, `size_6`, `size_6_price`, `size_7`, `size_7_price`, `size_8`, `size_8_price`, `size_9`, `size_9_price`, `size_10`, `size_10_price`, `size_1_original_price`, `size_2_original_price`, `size_3_original_price`, `size_4_original_price`, `size_5_original_price`, `size_6_original_price`, `size_7_original_price`, `size_8_original_price`, `size_9_original_price`, `size_10_original_price`, `created_at`, `updated_at`) VALUES
(1, 'pid01', 'akashsshinde0707@gmail.com', '', 'shoes/1side.png', 'shoes/1up.png', 'shoes/1bottom.png', 'shoes/1back.png', 'male', 'Nike Pegasus Custom Trail-Running Shoes', '100', 'black', '5000', '5', 1, 150, 2, 250, 3, 350, 4, 450, 5, 550, 6, 650, 5, 750, 8, 850, 9, 950, 10, 1100, 100, 200, 300, 400, 500, 600, 700, 800, 900, 1000, '2024-09-05 09:38:31', '2024-12-02 06:07:19'),
(2, 'pid02', 'akashsshinde0707@gmail.com', '', 'shoes/2side.png', 'shoes/2up.png', 'shoes/2bottom.png', 'shoes/2back.png', 'male', 'Nike Pegasus Custom Trail-Running Shoes', '50', 'vintage green', '1000', '5', 1, 150, 2, 250, 2, 350, 4, 450, 5, 550, 6, 650, 6, 750, 5, 850, 9, 950, 10, 1100, 100, 200, 300, 400, 500, 600, 700, 800, 900, 1000, '2024-09-05 09:38:31', '2024-12-02 06:07:19'),
(3, 'pid03', 'akashsshinde0707@gmail.com', '', 'shoes/3side.png', 'shoes/3up.png', 'shoes/3bottom.png', 'shoes/3back.png', 'male', 'Nike Pegasus Custom Trail-Running Shoes', '300', 'orange', '15000', '18', 1, 150, 2, 250, 2, 350, 3, 450, 5, 550, 6, 650, 7, 750, 8, 850, 9, 950, 10, 1100, 100, 200, 300, 400, 500, 600, 700, 800, 900, 1000, '2024-09-05 09:38:31', '2024-12-02 06:07:19'),
(4, 'pid04', 'akashsshinde0707@gmail.com', '', 'shoes/5side.png', 'shoes/5up.png', 'shoes/5bottom.png', 'shoes/5back.png', 'female', 'Nike Pegasus Custom Trail-Running Shoes', '400', 'white', '20000', '11', 1, 150, 1, 250, 3, 350, 3, 450, 5, 550, 6, 650, 6, 750, 7, 850, 9, 950, 10, 1100, 100, 200, 300, 400, 500, 600, 700, 800, 900, 1000, '2024-09-05 09:38:31', '2024-12-02 06:07:19'),
(5, 'pid05', 'akashsshinde0707@gmail.com', '', 'shoes/4side.png', 'shoes/4up.png', 'shoes/4bottom.png', 'shoes/4back.png', 'female', 'Nike Pegasus Custom Trail-Running Shoes', '500', 'green frost', '25000', '21', 1, 150, 2, 250, 1, 350, 4, 450, 5, 550, 6, 650, 7, 750, 8, 850, 7, 950, 10, 1100, 100, 200, 300, 400, 500, 600, 700, 800, 900, 1000, '2024-09-05 09:38:31', '2024-12-02 06:07:19'),
(38, 'pid06', 'akashsshinde0707@gmail.com', '', 'shoes/6side2.png', 'shoes/6up2.png', 'shoes/6bottom2.png', 'shoes/6back2.png', 'female', 'Nike Pegasus Custom Trail-Running Shoes', '800', 'Taupe Grey', '35000', '29', 1, 150, 2, 250, 3, 350, 4, 450, 5, 550, 5, 650, 7, 750, 8, 850, 9, 950, 10, 1100, 100, 200, 300, 400, 500, 600, 700, 800, 900, 1000, '2024-09-05 09:38:31', '2024-12-02 06:07:19'),
(40, 'PID07', 'akashsshinde0707@gmail.com', '', 'shoes/ncp_logo1-removebg-preview (1).png', 'shoes/ncp_logo1-removebg-preview (1).png', 'shoes/ncp_logo1-removebg-preview (1).png', '', 'male', 'aa', '', 'red', '12121', '6', 1, 150, 2, 250, 2, 350, 4, 450, 5, 550, 6, 650, 7, 750, 8, 850, 8, 950, 10, 1100, 100, 200, 300, 400, 500, 600, 700, 800, 900, 1000, '2024-11-25 07:08:39', '2024-12-02 06:07:19'),
(41, 'PID08', '', '', 'shoes/india-temples-map.jpg', 'shoes/india-temples-map.jpg', 'shoes/india-temples-map.jpg', 'shoes/india-temples-map.jpg', 'female', 'rr', '', 'red', '', '20', 2, 150, 2, 250, 2, 350, 2, 450, 2, 550, 2, 650, 2, 750, 2, 850, 2, 950, 2, 1050, 100, 200, 300, 400, 500, 600, 700, 800, 900, 1000, '2024-12-02 10:58:22', NULL),
(42, 'PID09', '', '', 'shoes/india-temples-map.jpg', 'shoes/india-temples-map.jpg', 'shoes/india-temples-map.jpg', 'shoes/india-temples-map.jpg', 'other', 'ww', '', 'blue', '', '10', 1, 2, 1, 2, 1, 2, 1, 2, 1, 2, 1, 2, 1, 2, 1, 2, 1, 2, 1, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, '2024-12-02 11:41:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_info`
--

CREATE TABLE `personal_info` (
  `id` int(11) NOT NULL,
  `product_seller_email_id` varchar(200) NOT NULL,
  `account_no` varchar(200) NOT NULL,
  `account_holder_name` varchar(200) NOT NULL,
  `bank_name` varchar(200) NOT NULL,
  `mobile_no` varchar(200) NOT NULL,
  `info_added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `info_updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personal_info`
--

INSERT INTO `personal_info` (`id`, `product_seller_email_id`, `account_no`, `account_holder_name`, `bank_name`, `mobile_no`, `info_added_at`, `info_updated_at`) VALUES
(7, 'akashsshinde0707@gmail.com', '012346789012345', 'akash shivasharan shinde', 'Bank Of India', '8329400225', '2024-09-20 07:05:24', '2024-09-20 07:05:45');

-- --------------------------------------------------------

--
-- Table structure for table `personal_info_all_backup`
--

CREATE TABLE `personal_info_all_backup` (
  `id` int(11) NOT NULL,
  `product_seller_email_id` varchar(200) NOT NULL,
  `account_no` varchar(200) NOT NULL,
  `account_holder_name` varchar(200) NOT NULL,
  `bank_name` varchar(200) NOT NULL,
  `mobile_no` varchar(200) NOT NULL,
  `info_added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personal_info_all_backup`
--

INSERT INTO `personal_info_all_backup` (`id`, `product_seller_email_id`, `account_no`, `account_holder_name`, `bank_name`, `mobile_no`, `info_added_at`) VALUES
(4, 'akashsshinde0707@gmail.com', '12346789012345', 'akash shivasharan shinde', 'Bank Of India', '8329400225', '2024-09-20 07:05:24'),
(5, 'akashsshinde0707@gmail.com', '012346789012345', 'akash shivasharan shinde', 'Bank Of India', '8329400225', '2024-09-20 07:05:45'),
(6, 'akashsshinde0707@gmail.com', '012346789012345', 'akash shivasharan shinde', 'Bank Of India', '8329400225', '2024-10-03 06:31:49');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `side` varchar(200) NOT NULL,
  `product_price` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `side`, `product_price`) VALUES
(1, 'Nike Pegasus Custom Trail-Running Shoes 1', 'shoes/1side.png', '4000'),
(2, 'Nike Pegasus Custom Trail-Running Shoes 2', 'shoes/2side.png', '6000'),
(3, 'Nike Pegasus Custom Trail-Running Shoes 3', 'shoes/3side.png', '8000'),
(4, 'Nike Pegasus Custom Trail-Running Shoes 4', 'shoes/4side.png', '10000'),
(5, 'Nike Pegasus Custom Trail-Running Shoes 5', 'shoes/5side.png', '12000');

-- --------------------------------------------------------

--
-- Table structure for table `product_sales`
--

CREATE TABLE `product_sales` (
  `id` int(11) NOT NULL,
  `product_id` varchar(200) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `category` varchar(200) NOT NULL,
  `color` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `original_price` int(200) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount` int(200) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `sell_price` decimal(10,2) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_sales`
--

INSERT INTO `product_sales` (`id`, `product_id`, `product_name`, `category`, `color`, `size`, `quantity`, `original_price`, `price`, `discount`, `total_price`, `sell_price`, `customer_name`, `phone_number`, `created_at`) VALUES
(27, 'pid01', 'Nike Pegasus Custom Trail-Running Shoes', 'male', 'black', 'size_7', 1, 0, 700.00, 0, 700.00, 700.00, 'shanku', '777', '2024-11-29 12:20:20'),
(28, 'pid02', 'Nike Pegasus Custom Trail-Running Shoes', 'male', 'vintage green', 'size_8', 2, 0, 800.00, 0, 1600.00, 1600.00, 'akash s shinde', '8329400225', '2024-11-29 12:22:17'),
(29, 'pid03', 'Nike Pegasus Custom Trail-Running Shoes', 'male', 'orange', 'size_4', 1, 0, 400.00, 0, 400.00, 400.00, 'xzc', '2222', '2024-12-02 04:32:35'),
(30, 'pid04', 'Nike Pegasus Custom Trail-Running Shoes', 'female', 'white', 'size_4', 1, 400, 450.00, 0, 450.00, 430.00, 'harsh magar', '1234567890', '2024-12-02 08:33:19'),
(31, 'pid01', 'Nike Pegasus Custom Trail-Running Shoes', 'male', 'black', 'size_9', 1, 900, 950.00, 2, 950.00, 931.00, 'shankar tormal', '2345443322', '2024-12-02 10:54:39'),
(32, 'PID07', 'aa', 'male', 'red', 'size_7', 2, 700, 750.00, 10, 1500.00, 1350.00, 'vinod shinde', '1234567890', '2024-12-03 11:38:31'),
(33, 'PID08', 'rr', 'female', 'red', 'size_4', 1, 400, 450.00, 10, 450.00, 405.00, 'shanku', '1232553423', '2024-12-03 11:56:29');

-- --------------------------------------------------------

--
-- Table structure for table `selled_product`
--

CREATE TABLE `selled_product` (
  `id` int(11) NOT NULL,
  `product_id` varchar(200) NOT NULL,
  `category` varchar(200) NOT NULL,
  `customer_name` varchar(200) NOT NULL,
  `phone_number` varchar(200) NOT NULL,
  `Product_name` varchar(200) NOT NULL,
  `product_color` varchar(200) NOT NULL,
  `size` int(200) NOT NULL,
  `quantity` int(200) NOT NULL,
  `Product_price` int(200) NOT NULL,
  `sell_product_price` int(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(200) NOT NULL,
  `email_id` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `phone_number` varchar(200) NOT NULL,
  `current_address` varchar(200) NOT NULL,
  `account_create_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `reset_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email_id`, `password`, `phone_number`, `current_address`, `account_create_date`, `reset_token`) VALUES
(1, 'Akki shinde', 'shinde.akash9798@gmail.com', '$2y$10$NyYiBT3.iz0gxYB0wAhd6eqVz/3PI05mOE2Egd/YmIaCU1mAASCoq', '8329400225', 'Yashwantnagar, akluj', '2024-07-29 06:58:26', '446cb9dda006fb02021d33b03067ee45');

-- --------------------------------------------------------

--
-- Table structure for table `women_shoes`
--

CREATE TABLE `women_shoes` (
  `id` int(11) NOT NULL,
  `side` varchar(2000) NOT NULL,
  `up` varchar(2000) NOT NULL,
  `bottom` varchar(2000) NOT NULL,
  `back` varchar(2000) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `product_price` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `women_shoes`
--

INSERT INTO `women_shoes` (`id`, `side`, `up`, `bottom`, `back`, `product_name`, `product_price`) VALUES
(1, 'shoes/1side.png', 'shoes/1up.png', 'shoes/1bottom.png', 'shoes/1back.png', 'Women Nike Pegasus Custom Trail-Running Shoes 1', '5000'),
(2, 'shoes/2side.png', 'shoes/2up.png', 'shoes/2bottom.png', 'shoes/2back.png', 'Women Nike Pegasus Custom Trail-Running Shoes 2', '1000'),
(3, 'shoes/5side.png', 'shoes/5up.png', 'shoes/5bottom.png', 'shoes/5back.png', 'Women Nike Pegasus Custom Trail-Running Shoes 3', '15000'),
(4, 'shoes/4side.png', 'shoes/4up.png', 'shoes/4bottom.png', 'shoes/4back.png', 'Women Nike Pegasus Custom Trail-Running Shoes 4', '20000'),
(5, 'shoes/3side.png', 'shoes/3up.png', 'shoes/3bottom.png', 'shoes/3back.png\n', 'Women Nike Pegasus Custom Trail-Running Shoes 5', '25000');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `color`
--
ALTER TABLE `color`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `credit_card`
--
ALTER TABLE `credit_card`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `main_shoes`
--
ALTER TABLE `main_shoes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `main_shoes_original`
--
ALTER TABLE `main_shoes_original`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_info`
--
ALTER TABLE `personal_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_info_all_backup`
--
ALTER TABLE `personal_info_all_backup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_sales`
--
ALTER TABLE `product_sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `selled_product`
--
ALTER TABLE `selled_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `women_shoes`
--
ALTER TABLE `women_shoes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `color`
--
ALTER TABLE `color`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `credit_card`
--
ALTER TABLE `credit_card`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `main_shoes`
--
ALTER TABLE `main_shoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `main_shoes_original`
--
ALTER TABLE `main_shoes_original`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `personal_info`
--
ALTER TABLE `personal_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `personal_info_all_backup`
--
ALTER TABLE `personal_info_all_backup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `product_sales`
--
ALTER TABLE `product_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `selled_product`
--
ALTER TABLE `selled_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `women_shoes`
--
ALTER TABLE `women_shoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
