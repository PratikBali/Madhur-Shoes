-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 17, 2025 at 01:09 PM
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
-- Table structure for table `customer_details`
--

CREATE TABLE `customer_details` (
  `id` int(11) NOT NULL,
  `product_bill_no` varchar(255) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `grand_total` varchar(255) NOT NULL,
  `sale_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `main_shoes`
--

CREATE TABLE `main_shoes` (
  `id` int(11) NOT NULL,
  `product_id` varchar(200) NOT NULL,
  `bar_code_no` varchar(13) DEFAULT NULL,
  `product_seller_email_id` varchar(200) DEFAULT NULL,
  `side` varchar(500) DEFAULT NULL,
  `up` varchar(500) DEFAULT NULL,
  `bottom` varchar(500) DEFAULT NULL,
  `back` varchar(500) DEFAULT NULL,
  `category` varchar(200) NOT NULL,
  `male_category` varchar(255) DEFAULT NULL,
  `female_category` varchar(255) DEFAULT NULL,
  `child_male_category` varchar(255) DEFAULT NULL,
  `child_female_category` varchar(255) DEFAULT NULL,
  `other_category` varchar(255) DEFAULT NULL,
  `artical_no` varchar(255) NOT NULL,
  `brand_name` varchar(500) NOT NULL,
  `product_color` varchar(500) NOT NULL,
  `quantity` varchar(500) NOT NULL,
  `product_size` varchar(255) NOT NULL,
  `original_price` int(200) NOT NULL,
  `sell_price` int(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `main_shoes_original`
--

CREATE TABLE `main_shoes_original` (
  `id` int(11) NOT NULL,
  `product_id` varchar(200) NOT NULL,
  `bar_code_no` varchar(255) NOT NULL,
  `product_seller_email_id` varchar(200) NOT NULL,
  `side` varchar(500) NOT NULL,
  `up` varchar(500) NOT NULL,
  `bottom` varchar(500) NOT NULL,
  `back` varchar(500) NOT NULL,
  `category` varchar(200) NOT NULL,
  `male_category` varchar(255) DEFAULT NULL,
  `female_category` varchar(255) DEFAULT NULL,
  `child_male_category` varchar(255) DEFAULT NULL,
  `child_female_category` varchar(255) DEFAULT NULL,
  `other_category` varchar(255) DEFAULT NULL,
  `artical_no` varchar(255) NOT NULL,
  `brand_name` varchar(500) NOT NULL,
  `product_color` varchar(500) NOT NULL,
  `quantity` varchar(500) NOT NULL,
  `product_size` varchar(255) NOT NULL,
  `original_price` int(200) NOT NULL,
  `sell_price` int(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `product_id` varchar(255) NOT NULL,
  `product_bill_no` varchar(200) NOT NULL,
  `bar_code_no` varchar(255) NOT NULL,
  `artical_no` varchar(255) NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `category` varchar(200) NOT NULL,
  `male_category` varchar(255) DEFAULT NULL,
  `female_category` varchar(255) DEFAULT NULL,
  `child_male_category` varchar(255) DEFAULT NULL,
  `child_female_category` varchar(255) DEFAULT NULL,
  `other_category` varchar(255) DEFAULT NULL,
  `product_color` varchar(255) NOT NULL,
  `product_size` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `aval_quantity` varchar(255) NOT NULL,
  `original_price` int(200) NOT NULL,
  `discount` int(200) NOT NULL,
  `sell_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indexes for table `customer_details`
--
ALTER TABLE `customer_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `main_shoes`
--
ALTER TABLE `main_shoes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bar_code_no` (`bar_code_no`);

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
-- AUTO_INCREMENT for table `customer_details`
--
ALTER TABLE `customer_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `main_shoes`
--
ALTER TABLE `main_shoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `main_shoes_original`
--
ALTER TABLE `main_shoes_original`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
