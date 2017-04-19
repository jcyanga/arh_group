-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2017 at 12:07 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `arh_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` varchar(64) NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '3', 1485153378),
('developer', '1', 123456789),
('developer', '2', 123456789),
('staff', '4', 1490583866);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, 'Admin', NULL, NULL, 1484537877, 1484537877),
('customer', 1, 'Customer', NULL, NULL, 1484537877, 1484537877),
('developer', 1, 'Developer', NULL, NULL, 1484537877, 1484537877),
('staff', 1, 'Staff', NULL, NULL, 1484537877, 1484537877);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `contact_no` varchar(50) NOT NULL,
  `status` int(5) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(10) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`id`, `code`, `name`, `address`, `contact_no`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'BRANCH-2017-53076', 'fcs-philippines', '27th floor BPI Buendia Center Makati ave. Makati City', '09959575415', 1, '2017-03-23 15:25:00', 1, '2017-03-23 15:25:00', 1),
(2, 'BRANCH-2017-87623', 'arh group pte ltd', 'blk 8 Marsiling Industrial Estate Road 3#01-14 Singapore 739252', '61002183', 1, '2017-03-23 15:25:00', 1, '2017-03-23 15:25:00', 1),
(3, 'BRANCH-2017-37949', 'arh branch-1', 'blk 10 Marsiling Industrial Estate Road 5#03-23 Singapore 739253 ', '72758034', 1, '2017-03-23 15:52:24', 3, '2017-03-23 15:52:24', 3),
(4, 'BRANCH-2017-87640', 'arh branch-2', 'blk 15 Marsiling Industrial Estate Road 8#05-28 Singapore 847264', '93957124', 1, '2017-03-23 16:00:41', 3, '2017-03-23 16:00:41', 3),
(5, 'BRANCH-2017-17252', 'arh branch-3', 'blk55 Marsiling Industrial Estate Road 8#05-35 Singapore 846864', '83874258', 1, '2017-03-27 12:06:08', 2, '2017-03-27 12:06:08', 2);

-- --------------------------------------------------------

--
-- Table structure for table `car_information`
--

CREATE TABLE `car_information` (
  `id` int(11) NOT NULL,
  `customer_id` int(5) NOT NULL,
  `carplate` varchar(50) NOT NULL,
  `make` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `engine_no` varchar(50) NOT NULL,
  `year_mfg` varchar(10) NOT NULL,
  `chasis` varchar(50) NOT NULL,
  `points` int(10) NOT NULL,
  `type` int(5) NOT NULL,
  `status` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `car_information`
--

INSERT INTO `car_information` (`id`, `customer_id`, `carplate`, `make`, `model`, `engine_no`, `year_mfg`, `chasis`, `points`, `type`, `status`) VALUES
(2, 2, 'DGL773A', 'MITSUBISHI', 'MONTERO SPORTS', '2010DGL02', '2010', '0201DDGL', 120, 1, 1),
(5, 1, 'Q', 'E', 'W', 'T', '2000', 'R', 500, 1, 1),
(6, 3, 'A', 'C', 'B', 'E', '2000', 'D', 199, 1, 1),
(7, 4, 'SGV246', 'HYUNDAI', 'ACCENT', '0201201SPH', '2010', '0201SGV', 120, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(10) NOT NULL,
  `status` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category`, `created_at`, `created_by`, `status`) VALUES
(1, 'body components', '2017-03-14 18:20:00', 1, 1),
(2, 'doors', '2017-03-14 18:20:00', 1, 1),
(3, 'windows', '2017-03-14 18:20:00', 1, 1),
(4, 'audio/video devices', '2017-03-14 18:20:00', 1, 1),
(5, 'cameras', '2017-03-14 18:20:00', 1, 1),
(6, 'charging system', '2017-03-14 18:20:00', 1, 1),
(7, 'electrical supply system', '2017-03-14 18:20:00', 1, 1),
(8, 'gauge and meters', '2017-03-14 18:20:00', 1, 1),
(9, 'lightning and signaling', '2017-03-14 18:20:00', 1, 1),
(10, 'sensors', '2017-03-14 18:20:00', 1, 1),
(11, 'car seat', '2017-03-14 18:20:00', 1, 1),
(12, 'braking system', '2017-03-14 18:20:00', 1, 1),
(13, 'engine component and parts', '2017-03-14 18:20:00', 1, 1),
(14, 'engine cooling system', '2017-03-14 18:20:00', 1, 1),
(15, 'engine oil system', '2017-03-14 18:20:00', 1, 1),
(16, 'exhaust system', '2017-03-14 18:20:00', 1, 1),
(17, 'fuel supply system', '2017-03-14 18:20:00', 1, 1),
(18, 'suspension and steering system', '2017-03-14 18:20:00', 1, 1),
(19, 'transmission system', '2017-03-14 18:20:00', 1, 1),
(20, 'aircondition system', '2017-03-14 18:20:00', 1, 1),
(21, 'bearings', '2017-03-14 18:20:00', 1, 1),
(22, 'hose', '2017-03-14 18:20:00', 1, 1),
(23, 'testing', '2017-03-28 10:29:59', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `role` int(5) NOT NULL,
  `password` varchar(50) NOT NULL,
  `password_hash` varchar(100) NOT NULL,
  `auth_key` varchar(100) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `nric` varchar(50) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `uen_no` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `race_id` int(5) NOT NULL,
  `hanphone_no` varchar(50) NOT NULL,
  `office_no` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `remarks` text NOT NULL,
  `join_date` date NOT NULL,
  `member_expiry` date NOT NULL,
  `is_member` varchar(10) NOT NULL,
  `is_blacklist` tinyint(1) NOT NULL,
  `type` int(5) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(10) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(10) NOT NULL,
  `deleted` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `role`, `password`, `password_hash`, `auth_key`, `fullname`, `nric`, `company_name`, `uen_no`, `address`, `race_id`, `hanphone_no`, `office_no`, `email`, `remarks`, `join_date`, `member_expiry`, `is_member`, `is_blacklist`, `type`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted`) VALUES
(1, 10, '50917432', '$2y$13$pr1ir4z9hCVgQtgFgAc4iOFm/ySzZWvrrkBPGft4qWMWtcGu5EY1y', 'oQMgtycUoaPsHYxjrLlNLKDPhAUjUBuJ', 'JUAN DELA CRUZ', '', 'TESTING', 'S123456TEST', '123 TESTING', 0, '75774125', '09097412365', 'JUANDELACRUZ@YAHOO.COM', 'TEST', '1970-01-01', '1970-01-01', '', 0, 1, 1, '2017-03-28 10:10:19', 3, '2017-03-28 10:10:19', 3, 0),
(2, 10, '19419376', '$2y$13$7TbeZJDrAzDbbxVAxO9OpuDjjwnoekRH7JcOfLENQbZ3BuqQgcr0S', 'h-zuH7nGeFfCa9ekupXXSjFJwsGEtgAF', 'antonio smith', 'S123456', '', '', '23rd Light Condominium SMDC Shaw Blvd. Mandaluyong City', 1, '', '', '', 'Test case only', '2017-03-21', '2018-03-21', '1', 0, 2, 1, '2017-03-27 17:14:16', 2, '2017-03-27 17:14:16', 2, 0),
(3, 10, '35412692', '$2y$13$nbf.7378lyVUK.0yjdsKHec7wFpuz2yVbUP94jUOxKruKPoi0WQUu', '_cyuahh7GtA8ZNrb7jNSlKawNM7YxDXx', '', '', 'testings', 's123', '123 testing', 0, '', '', '', '', '1970-01-01', '1970-01-01', '', 0, 1, 1, '2017-03-28 10:39:34', 3, '2017-03-28 10:39:34', 3, 0),
(4, 10, '80296234', '$2y$13$yp8sD/h5SeRr9Dq0J2YG0O.3UJUIg15TNxhES6hYNDaUBeYST8cSm', 's9x2q8zDPZBHPuOuS--4ODhg1E_F4TqO', 'James Ting', '', 'Nestle Philippines', '20160201PH', 'Nestle Philippines Inc. Cabuyao Laguna', 0, '74785632', '09077412589', 'jamesting@yahoo.com', 'Test case purposes', '1970-01-01', '1970-01-01', '', 0, 1, 1, '2017-03-29 10:22:44', 3, '2017-03-29 10:22:44', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `designated_position`
--

CREATE TABLE `designated_position` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(10) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(10) NOT NULL,
  `status` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `designated_position`
--

INSERT INTO `designated_position` (`id`, `name`, `description`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(1, 'Web Programmer', 'Responsible for creating cms website', '2017-03-20 11:27:12', 2, '2017-03-20 11:27:12', 2, 1),
(2, 'Web Designer', 'Responsible for creating crm system', '2017-03-20 11:27:34', 2, '2017-03-20 11:27:34', 2, 1),
(3, 'Spray Painter cum Beater', 'Responsible for car painting', '2017-03-20 11:28:58', 2, '2017-03-20 11:28:58', 2, 1),
(4, 'Workshop Supervisor', 'Responsible for supervising the services', '2017-03-20 11:29:31', 2, '2017-03-20 11:29:31', 2, 1),
(5, 'Chief Operating Officers', 'Responsible to supervise and manage the whole company', '2017-03-29 13:19:55', 3, '2017-03-29 13:19:55', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `gst`
--

CREATE TABLE `gst` (
  `id` int(11) NOT NULL,
  `gst` varchar(10) NOT NULL,
  `branch_id` int(5) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(10) NOT NULL,
  `status` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gst`
--

INSERT INTO `gst` (`id`, `gst`, `branch_id`, `created_at`, `created_by`, `status`) VALUES
(1, '7', 3, '2017-03-23 15:52:34', 3, 1),
(2, '7', 4, '2017-03-29 13:28:58', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `product_id` int(5) NOT NULL,
  `old_quantity` int(25) NOT NULL,
  `new_quantity` int(25) NOT NULL,
  `qty_purchased` int(25) NOT NULL,
  `type` int(5) NOT NULL,
  `invoice_no` varchar(50) NOT NULL,
  `datetime_imported` datetime NOT NULL,
  `datetime_purchased` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `product_id`, `old_quantity`, `new_quantity`, `qty_purchased`, `type`, `invoice_no`, `datetime_imported`, `datetime_purchased`, `created_at`, `created_by`, `status`) VALUES
(1, 1, 30, 30, 0, 1, '', '2017-03-28 14:52:33', '0000-00-00 00:00:00', '2017-03-28 14:52:33', 3, 1),
(2, 2, 40, 40, 0, 1, '', '2017-03-28 14:53:14', '0000-00-00 00:00:00', '2017-03-28 14:53:14', 3, 1),
(3, 2, 40, 39, 0, 3, '', '2017-03-28 15:02:27', '0000-00-00 00:00:00', '2017-03-28 15:02:27', 3, 1),
(4, 2, 39, 38, 0, 3, '', '2017-03-28 15:02:28', '0000-00-00 00:00:00', '2017-03-28 15:02:28', 3, 1),
(5, 2, 38, 37, 1, 2, 'INV201703001', '0000-00-00 00:00:00', '2017-03-28 00:00:00', '2017-03-28 15:03:08', 3, 1),
(6, 1, 30, 29, 1, 2, 'INV201703005', '0000-00-00 00:00:00', '2017-03-29 00:00:00', '2017-03-29 11:28:26', 3, 1),
(7, 2, 37, 35, 2, 2, 'INV201703005', '0000-00-00 00:00:00', '2017-03-29 00:00:00', '2017-03-29 11:28:27', 3, 1),
(8, 1, 29, 28, 1, 2, 'INV201703006', '0000-00-00 00:00:00', '2017-03-29 00:00:00', '2017-03-29 11:30:47', 3, 1),
(9, 2, 35, 33, 2, 2, 'INV201703006', '0000-00-00 00:00:00', '2017-03-29 00:00:00', '2017-03-29 11:30:47', 3, 1),
(10, 1, 29, 28, 1, 2, 'INV201703006', '0000-00-00 00:00:00', '2017-03-29 00:00:00', '2017-03-29 12:53:59', 3, 1),
(11, 2, 35, 33, 2, 2, 'INV201703006', '0000-00-00 00:00:00', '2017-03-29 00:00:00', '2017-03-29 12:53:59', 3, 1),
(12, 1, 29, 28, 1, 2, 'INV201703006', '0000-00-00 00:00:00', '2017-03-29 00:00:00', '2017-03-29 12:54:21', 3, 1),
(13, 2, 35, 33, 2, 2, 'INV201703006', '0000-00-00 00:00:00', '2017-03-29 00:00:00', '2017-03-29 12:54:22', 3, 1),
(14, 1, 29, 28, 1, 2, 'INV201703005', '0000-00-00 00:00:00', '2017-03-29 00:00:00', '2017-03-29 14:54:44', 3, 1),
(15, 2, 35, 33, 2, 2, 'INV201703005', '0000-00-00 00:00:00', '2017-03-29 00:00:00', '2017-03-29 14:54:44', 3, 1),
(16, 1, 29, 28, 1, 2, 'INV201703005', '0000-00-00 00:00:00', '2017-03-29 00:00:00', '2017-03-29 14:54:51', 3, 1),
(17, 2, 35, 33, 2, 2, 'INV201703005', '0000-00-00 00:00:00', '2017-03-29 00:00:00', '2017-03-29 14:54:51', 3, 1),
(18, 1, 29, 28, 1, 2, 'INV201703005', '0000-00-00 00:00:00', '2017-03-29 00:00:00', '2017-03-29 14:55:49', 3, 1),
(19, 2, 35, 33, 2, 2, 'INV201703005', '0000-00-00 00:00:00', '2017-03-29 00:00:00', '2017-03-29 14:55:49', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id` int(11) NOT NULL,
  `quotation_code` varchar(50) NOT NULL,
  `invoice_no` varchar(50) NOT NULL,
  `user_id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL,
  `date_issue` date NOT NULL,
  `grand_total` double NOT NULL,
  `gst` double NOT NULL,
  `net` double NOT NULL,
  `remarks` text NOT NULL,
  `mileage` varchar(50) NOT NULL,
  `come_in` datetime NOT NULL,
  `come_out` datetime NOT NULL,
  `created_at` date NOT NULL,
  `time_created` time NOT NULL,
  `discount_amount` double NOT NULL,
  `discount_remarks` text NOT NULL,
  `created_by` int(10) NOT NULL,
  `updated_at` date NOT NULL,
  `updated_by` int(10) NOT NULL,
  `delete` int(5) NOT NULL,
  `task` int(5) NOT NULL,
  `paid` int(5) NOT NULL,
  `paid_type` int(5) NOT NULL,
  `status` int(5) NOT NULL,
  `payment_status` varchar(50) NOT NULL,
  `balance_amount` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `quotation_code`, `invoice_no`, `user_id`, `customer_id`, `branch_id`, `date_issue`, `grand_total`, `gst`, `net`, `remarks`, `mileage`, `come_in`, `come_out`, `created_at`, `time_created`, `discount_amount`, `discount_remarks`, `created_by`, `updated_at`, `updated_by`, `delete`, `task`, `paid`, `paid_type`, `status`, `payment_status`, `balance_amount`) VALUES
(1, '0', 'INV201703001', 3, 7, 3, '2017-03-29', 715, 50.05, 666.05, 'TEST CASE PURPOSES', '1000', '2017-03-30 11:03:14', '2017-03-31 11:03:14', '2017-03-29', '11:04:09', 99, 'Summer Discount', 3, '2017-03-29', 3, 0, 0, 0, 0, 0, '', 0.00),
(2, '0', 'INV201703002', 3, 7, 3, '2017-03-29', 540, 37.8, 502.8, 'TEST CASE PURPOSES', '1000', '2017-03-30 11:13:45', '2017-03-31 11:13:45', '2017-03-29', '11:14:32', 75, 'Summer Discount', 3, '2017-03-29', 3, 0, 0, 0, 0, 0, '', 0.00),
(3, '0', 'INV201703003', 3, 7, 4, '2017-03-29', 690, 0, 591, 'TEST CASE PURPOSES', '1000', '2017-03-30 11:22:10', '2017-03-31 11:22:10', '2017-03-29', '11:23:10', 99, 'Summer Discount', 3, '2017-03-29', 3, 0, 0, 0, 0, 0, '', 0.00),
(4, '0', 'INV201703003', 3, 7, 4, '2017-03-29', 690, 0, 591, 'TEST CASE PURPOSES', '1000', '2017-03-30 11:22:10', '2017-03-31 11:22:10', '2017-03-29', '11:23:15', 99, 'Summer Discount', 3, '2017-03-29', 3, 0, 0, 0, 0, 0, '', 0.00),
(5, '0', 'INV201703005', 3, 7, 3, '2017-03-29', 540, 37.8, 478.8, 'TEST CASE PURPOSES', '1000', '2017-03-30 11:27:38', '2017-03-31 11:27:38', '2017-03-29', '11:28:26', 99, 'Summer Discount', 3, '2017-03-29', 3, 0, 0, 0, 0, 0, '', 0.00),
(6, '0', 'INV201703005', 3, 7, 3, '2017-03-29', 540, 37.8, 478.8, 'TEST CASE PURPOSES', '1000', '2017-03-30 11:27:38', '2017-03-31 11:27:38', '2017-03-29', '14:55:49', 0, 'No discount remarks.', 3, '2017-03-29', 3, 0, 0, 0, 0, 0, '', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_detail`
--

CREATE TABLE `invoice_detail` (
  `id` int(11) NOT NULL,
  `invoice_id` int(10) NOT NULL,
  `service_part_id` varchar(150) NOT NULL,
  `quantity` int(10) NOT NULL,
  `selling_price` double NOT NULL,
  `subTotal` double NOT NULL,
  `created_at` date NOT NULL,
  `created_by` int(10) NOT NULL,
  `type` int(5) NOT NULL,
  `task` int(5) NOT NULL,
  `status` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice_detail`
--

INSERT INTO `invoice_detail` (`id`, `invoice_id`, `service_part_id`, `quantity`, `selling_price`, `subTotal`, `created_at`, `created_by`, `type`, `task`, `status`) VALUES
(1, 3, '2', 2, 150, 300, '2017-03-29', 3, 1, 0, 0),
(2, 4, '2', 2, 150, 300, '2017-03-29', 3, 1, 0, 0),
(12, 6, '1', 1, 120, 120, '2017-03-29', 3, 1, 0, 0),
(13, 6, '2', 2, 150, 300, '2017-03-29', 3, 1, 0, 0),
(22, 5, 'Test Service A', 1, 120, 120, '2017-03-29', 3, 0, 1, 0),
(23, 5, 'Test Service B', 1, 199, 199, '2017-03-29', 3, 0, 1, 0),
(24, 5, '1', 1, 120, 120, '2017-03-29', 3, 1, 0, 0),
(25, 5, '2', 2, 150, 300, '2017-03-29', 3, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m130524_201442_init', 1481699090),
('m140506_102106_rbac_init', 1483925225),
('m161213_060531_create_user_table', 1481699091),
('m161214_063225_create_customer_table', 1481699091),
('m161216_080528_create_role_table', 1481875655),
('m161216_081935_create_position_table', 1481876465),
('m161216_102852_create_role_table', 1481884179),
('m161216_114047_create_modules_table', 1481888500),
('m161219_095636_create_category_table', 1482141457),
('m161219_112411_create_supplier_table', 1482146725),
('m161220_034611_create_inventory_table', 1482212421),
('m161220_090021_create_product_table', 1482230755),
('m161221_094318_create_inventory_table', 1482313647),
('m161228_021117_create_user_permission_table', 1482891261),
('m161228_053001_create_auth_rule_table', 1482903624),
('m161228_053238_create_auth_item_child_table', 1482903624),
('m161228_053452_create_auth_item_table', 1482903625),
('m161228_053844_create_auth_assignment_table', 1482903625),
('m161228_054548_create_auth_item_table', 1482904001),
('m161228_060720_create_auth_rule_table', 1482905289),
('m170103_013357_create_service_category_table', 1483407428),
('m170103_020957_create_service_table', 1483409549),
('m170103_040608_create_branch_table', 1483416549),
('m170103_064043_create_gst_table', 1483425696),
('m170103_071512_create_quotation_table', 1483429651),
('m170103_072328_create_quotation_subtotal_table', 1483429651),
('m170106_034508_create_quotation_detail_table', 1483674403),
('m170106_090029_create_quotation_detail_table', 1483693268),
('m170108_035631_create_stock_in_table', 1483848207),
('m170108_133828_create_module_access_table', 1483882809),
('m170109_012416_rbac_init', 1483925300),
('m170109_015349_rbac_init', 1483927743),
('m170110_091618_create_payment_table', 1484040226),
('m170111_050841_create_invoice_table', 1484111555),
('m170111_061422_create_invoice_table', 1484115376),
('m170111_063217_create_invoice_detail_table', 1484116390),
('m170112_053810_create_payment_table', 1484199747),
('m170112_071611_create_product_level_table', 1484205472),
('m170116_033646_create_rbac_init', 1484537877),
('m170124_054358_create_staff_table', 1485236870),
('m170124_065002_create_payroll_table', 1485241990),
('m170126_035125_create_payment_type_table', 1485402836),
('m170126_131458_create_terms_and_conditions_table', 1485436634),
('m170210_034949_create_staff_group_table', 1486698678),
('m170210_052004_add_tables_to_staff_table', 1486704310),
('m170210_054917_add_address_table_to_staff_table', 1486705806),
('m170211_081531_create_race_table', 1486800997),
('m170211_122510_add_mileage_table_to_quotation_table', 1486816007),
('m170211_132053_add_payment_status_column_to_invoice_table', 1487126414),
('m170215_023610_add_gst_and_net_column_to_quotation_table', 1487126415),
('m170215_023956_add_mileage_column_to_quotation_table', 1487126415),
('m170215_073339_add_columns_to_invoice_table', 1487144160),
('m170216_065244_add_interest_column_to_payment_type_table', 1487228052),
('m170216_070756_create_payment_status_table', 1487228927),
('m170218_075614_add_interest_column_to_payment_table', 1487404613),
('m170218_080155_add_payment_status_column_to_payment_table', 1487404959),
('m170218_084658_add_net_column_to_payment_table', 1487407658),
('m170220_043746_add_net_with_gst_column_to_payment_table', 1487565503),
('m170220_104313_add_balance_amount_column_to_invoice_table', 1487587444),
('m170221_033717_add_columns_to_customer_table', 1487648510),
('m170221_114834_add_chasis_column_to_customer_table', 1487677787),
('m170303_034434_add_company_name_and_uen_no_column_to_customer_table', 1488512768),
('m170303_040640_add_type_column_to_customer_table', 1488514049),
('m170306_011632_add_join_date_column_to_customer_table', 1488763043),
('m170306_011822_create_car_information_table', 1488763288),
('m170306_020443_add_user_id_column_to_customer_table', 1488765929),
('m170308_012113_add_cost_price_gst_price_selling_price_columns_to_product_table', 1488936227),
('m170308_021855_add_quantity_column_to_product_table', 1488939584),
('m170308_022305_add_supplier_id_column_to_product_table', 1488939845),
('m170308_024708_add_reorder_level_column_to_product_table', 1488941270),
('m170308_101940_add_come_in_and_come_out_column_to_quotation_table', 1488968580),
('m170308_102008_add_come_in_and_come_out_column_to_invoice_table', 1488968582),
('m170310_031327_add_discount_amount_and_discount_remarks_to_quotation_table', 1489115720),
('m170310_031448_add_discount_amount_and_discount_remarks_to_invoice_table', 1489115721),
('m170314_012823_create_stock_adjustment_table', 1489455976),
('m170314_014433_create_stock_out_table', 1489455977),
('m170320_025146_create_designated_position_table', 1489978644),
('m170329_073113_create_product_notification_recipient_table', 1491200372);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` int(11) NOT NULL,
  `modules` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(10) NOT NULL,
  `status` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `modules`, `created_at`, `created_by`, `status`) VALUES
(1, 'Dashboard Module', '2017-03-14 16:45:00', 1, 1),
(2, 'quotation module', '2017-03-14 16:45:00', 1, 1),
(3, 'invoice module', '2017-03-14 16:45:00', 1, 1),
(4, 'stocks module', '2017-03-14 16:45:00', 1, 1),
(5, 'service-category module', '2017-03-14 16:45:00', 1, 1),
(6, 'services module', '2017-03-14 16:45:00', 1, 1),
(7, 'parts-category module', '2017-03-14 16:45:00', 1, 1),
(8, 'parts module', '2017-03-14 16:45:00', 1, 1),
(9, 'parts-supplier module', '2017-03-14 16:45:00', 1, 1),
(10, 'parts-inventory module', '2017-03-14 16:45:00', 1, 1),
(11, 'branch module', '2017-03-14 16:45:00', 1, 1),
(12, 'Customer Module', '2017-03-14 16:45:00', 1, 1),
(13, 'User-Role Module', '2017-03-14 16:45:00', 1, 1),
(14, 'Modules List Module', '2017-03-14 16:45:00', 1, 1),
(15, 'User-Permission Module', '2017-03-14 16:45:00', 1, 1),
(16, 'User Module', '2017-03-14 16:45:00', 1, 1),
(17, 'set gst module', '2017-03-14 16:45:00', 1, 1),
(18, 'part critical and minimum level module', '2017-03-14 16:45:00', 1, 1),
(19, 'testing module', '2017-03-27 13:04:12', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `module_access`
--

CREATE TABLE `module_access` (
  `id` int(11) NOT NULL,
  `modules_id` varchar(50) NOT NULL,
  `role_id` varchar(50) NOT NULL,
  `created_by` int(10) NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `invoice_id` int(5) NOT NULL,
  `invoice_no` varchar(50) NOT NULL,
  `customer_id` int(5) NOT NULL,
  `net` double NOT NULL,
  `net_with_interest` double NOT NULL,
  `amount` double NOT NULL,
  `payment_method` int(5) NOT NULL,
  `points_earned` int(25) NOT NULL,
  `points_redeem` int(25) NOT NULL,
  `payment_type` varchar(50) NOT NULL,
  `interest` varchar(50) NOT NULL,
  `remarks` text NOT NULL,
  `payment_status` varchar(50) NOT NULL,
  `payment_date` date NOT NULL,
  `payment_time` time NOT NULL,
  `status` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payment_status`
--

CREATE TABLE `payment_status` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(5) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(5) NOT NULL,
  `status` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment_status`
--

INSERT INTO `payment_status` (`id`, `name`, `description`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(1, 'fully paid', 'customer paid the whole amount', '2017-02-16 00:00:00', 2, '2017-02-16 00:00:00', 2, 1),
(2, 'partially paid', 'customer pay half or not the total amount yet', '2017-02-16 00:00:00', 2, '2017-02-16 00:00:00', 2, 1),
(3, 'not paid', 'customer not pay any amount', '2017-02-16 00:00:00', 2, '2017-02-16 00:00:00', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment_type`
--

CREATE TABLE `payment_type` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `interest` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(5) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(5) NOT NULL,
  `status` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment_type`
--

INSERT INTO `payment_type` (`id`, `name`, `description`, `interest`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(1, 'Cash Payment', 'Customer can pay thru cash payment.', '', '2017-01-27 00:00:00', 2, '2017-01-27 00:00:00', 2, 1),
(2, 'Credit Cards Payment', 'Customer can pay thru credit card payment.', '3', '2017-02-16 00:00:00', 2, '2017-02-16 00:00:00', 2, 1),
(3, 'Nets Payment', 'Customer can pay thru nets payment.', '', '2017-01-27 00:00:00', 2, '2017-01-27 00:00:00', 2, 1),
(5, '30 days credit', 'Customer can pay his/her payment within 30 days.', '', '2017-02-16 00:00:00', 2, '2017-02-16 00:00:00', 2, 1),
(6, 'Cheque Payment', 'Customer can pay thru cheque payment.', '0', '2017-03-23 15:53:47', 3, '2017-03-23 15:53:47', 3, 1),
(7, 'Cash on Delivery Payment', 'Customer can pay thru cash on delivery  payment.', '0', '2017-03-23 15:54:16', 3, '2017-03-23 15:54:16', 3, 1),
(8, 'Mastercard Payment', 'Customer can pay thru mastercard payment.', '0', '2017-03-23 15:54:52', 3, '2017-03-23 15:54:52', 3, 1),
(9, 'Amex Payment', 'Customer can pay thru amex payment.', '0', '2017-03-23 15:55:08', 3, '2017-03-23 15:55:08', 3, 1),
(10, 'testint', 'for testing purposes only', '1', '2017-03-29 13:50:07', 3, '2017-03-29 13:50:07', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `payroll`
--

CREATE TABLE `payroll` (
  `id` int(11) NOT NULL,
  `payslip_no` varchar(50) NOT NULL,
  `payslip_cutoff` varchar(150) NOT NULL,
  `date_issue` date NOT NULL,
  `staff_id` int(5) NOT NULL,
  `overtime_hour` varchar(25) NOT NULL,
  `overtime_rate_per_hour` double(10,2) NOT NULL,
  `overtime_pay` double(10,2) NOT NULL,
  `employee_cpf` double(10,2) NOT NULL,
  `employer_cpf` double(10,2) NOT NULL,
  `cash_advance` double(10,2) NOT NULL,
  `other_deductions` double(10,2) NOT NULL,
  `monthly_levy_charge` double(10,2) NOT NULL,
  `remarks` text NOT NULL,
  `prepared_by` varchar(50) NOT NULL,
  `approved_by` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(5) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(5) NOT NULL,
  `status` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payroll`
--

INSERT INTO `payroll` (`id`, `payslip_no`, `payslip_cutoff`, `date_issue`, `staff_id`, `overtime_hour`, `overtime_rate_per_hour`, `overtime_pay`, `employee_cpf`, `employer_cpf`, `cash_advance`, `other_deductions`, `monthly_levy_charge`, `remarks`, `prepared_by`, `approved_by`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(1, 'PS/17/EMP002/2', 'Mar-2017', '2017-03-27', 1, '0', 0.00, 0.00, 825.00, 687.50, 2500.00, 1500.00, 0.00, 'for testing case', 'system developer', 'system developer', '2017-03-27 17:48:09', 2, '2017-03-27 17:48:09', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `supplier_id` int(5) NOT NULL,
  `category_id` int(5) NOT NULL,
  `product_code` varchar(50) NOT NULL,
  `product_name` text NOT NULL,
  `unit_of_measure` varchar(50) NOT NULL,
  `quantity` int(50) NOT NULL,
  `cost_price` double NOT NULL,
  `gst_price` double NOT NULL,
  `selling_price` double NOT NULL,
  `reorder_level` int(10) NOT NULL,
  `product_image` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` date NOT NULL,
  `created_by` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `supplier_id`, `category_id`, `product_code`, `product_name`, `unit_of_measure`, `quantity`, `cost_price`, `gst_price`, `selling_price`, `reorder_level`, `product_image`, `status`, `created_at`, `created_by`) VALUES
(1, 1, 2, 'PARTS-2017-97287', 'qwerty', 'kilo', 10, 99, 7, 120, 10, 'visa.png', 1, '2017-03-28', 3),
(2, 1, 3, 'PARTS-2017-55613', 'windows xp', 'pieces', 33, 120, 7, 150, 10, 'paypal2.png', 1, '2017-03-28', 3);

-- --------------------------------------------------------

--
-- Table structure for table `product_level`
--

CREATE TABLE `product_level` (
  `id` int(11) NOT NULL,
  `minimum_level` int(10) NOT NULL,
  `critical_level` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_level`
--

INSERT INTO `product_level` (`id`, `minimum_level`, `critical_level`) VALUES
(1, 10, 5);

-- --------------------------------------------------------

--
-- Table structure for table `product_notification_recipient`
--

CREATE TABLE `product_notification_recipient` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(10) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(10) NOT NULL,
  `status` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_notification_recipient`
--

INSERT INTO `product_notification_recipient` (`id`, `email`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(1, 'jcyanga28@yahoo.com', '2017-04-03 14:52:38', 3, '2017-04-03 14:52:38', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `quotation`
--

CREATE TABLE `quotation` (
  `id` int(11) NOT NULL,
  `quotation_code` varchar(50) NOT NULL,
  `user_id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL,
  `date_issue` date NOT NULL,
  `grand_total` double NOT NULL,
  `gst` double NOT NULL,
  `net` double NOT NULL,
  `remarks` text NOT NULL,
  `mileage` varchar(50) NOT NULL,
  `come_in` datetime NOT NULL,
  `come_out` datetime NOT NULL,
  `created_at` date NOT NULL,
  `time_created` time NOT NULL,
  `discount_amount` double NOT NULL,
  `discount_remarks` text NOT NULL,
  `created_by` int(10) NOT NULL,
  `updated_at` date NOT NULL,
  `updated_by` int(10) NOT NULL,
  `delete` int(5) NOT NULL,
  `task` int(5) NOT NULL,
  `invoice` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quotation`
--

INSERT INTO `quotation` (`id`, `quotation_code`, `user_id`, `customer_id`, `branch_id`, `date_issue`, `grand_total`, `gst`, `net`, `remarks`, `mileage`, `come_in`, `come_out`, `created_at`, `time_created`, `discount_amount`, `discount_remarks`, `created_by`, `updated_at`, `updated_by`, `delete`, `task`, `invoice`) VALUES
(1, 'JS201703001', 3, 2, 3, '2017-03-28', 519, 36.33, 455.33, 'TEST CASE ONLY', '1000', '2017-03-29 17:07:06', '2017-03-31 17:07:06', '2017-03-28', '17:07:52', 100, 'Summer Discount', 3, '2017-03-28', 3, 0, 0, 0),
(2, 'JS201703002', 3, 2, 2, '2017-03-28', 794, 0, 694, 'TEST CASE ONLY', '1000', '2017-03-29 17:20:49', '2017-03-31 17:20:49', '2017-03-28', '17:22:04', 100, 'Holiday Discount', 3, '2017-03-28', 3, 0, 0, 0),
(3, 'JS201703002', 3, 2, 2, '2017-03-28', 794, 0, 694, 'TEST CASE ONLY', '1000', '2017-03-29 17:20:49', '2017-03-31 17:20:49', '2017-03-28', '17:22:10', 100, 'Holiday Discount', 3, '2017-03-28', 3, 0, 0, 0),
(4, 'JS201703004', 3, 2, 3, '2017-03-28', 819, 57.33, 876.33, 'TEST CASE ONLY', '1000', '2017-03-29 17:23:10', '2017-03-31 17:23:10', '2017-03-28', '17:24:10', 0, 'No discount remarks.', 3, '2017-03-28', 3, 0, 0, 0),
(5, 'JS201703005', 3, 2, 3, '2017-03-28', 1020, 71.4, 1016.4, 'TEST CASE ONLY', '1000', '2017-03-29 17:28:26', '2017-03-31 17:28:27', '2017-03-29', '08:39:45', 75, 'HOLY WEEK DISCOUNT', 3, '2017-03-29', 3, 0, 0, 0),
(6, 'JS201703006', 3, 7, 2, '2017-03-29', 540, 0, 441, 'TEST CASE PURPOSES', '1000', '2017-03-30 10:34:23', '2017-03-31 10:34:23', '2017-03-29', '10:35:08', 99, 'Summer Discount', 3, '2017-03-29', 3, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `quotation_detail`
--

CREATE TABLE `quotation_detail` (
  `id` int(11) NOT NULL,
  `quotation_id` int(10) NOT NULL,
  `service_part_id` varchar(150) NOT NULL,
  `quantity` int(10) NOT NULL,
  `selling_price` double NOT NULL,
  `subTotal` double NOT NULL,
  `created_at` date NOT NULL,
  `created_by` int(10) NOT NULL,
  `type` int(5) NOT NULL,
  `task` int(5) NOT NULL,
  `invoice` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quotation_detail`
--

INSERT INTO `quotation_detail` (`id`, `quotation_id`, `service_part_id`, `quantity`, `selling_price`, `subTotal`, `created_at`, `created_by`, `type`, `task`, `invoice`) VALUES
(1, 1, '1', 1, 120, 120, '2017-03-28', 3, 1, 0, 0),
(2, 1, '2', 2, 150, 300, '2017-03-28', 3, 1, 0, 0),
(3, 1, 'Test Service A', 1, 99, 99, '2017-03-28', 3, 0, 0, 0),
(4, 2, '1', 1, 120, 120, '2017-03-28', 3, 1, 0, 0),
(5, 2, '2', 2, 150, 300, '2017-03-28', 3, 1, 0, 0),
(6, 2, 'Test Service A', 1, 199, 199, '2017-03-28', 3, 0, 0, 0),
(7, 2, 'Test Service B', 1, 175, 175, '2017-03-28', 3, 0, 0, 0),
(8, 3, '1', 1, 120, 120, '2017-03-28', 3, 1, 0, 0),
(9, 3, '2', 2, 150, 300, '2017-03-28', 3, 1, 0, 0),
(10, 3, 'Test Service A', 1, 199, 199, '2017-03-28', 3, 0, 0, 0),
(11, 3, 'Test Service B', 1, 175, 175, '2017-03-28', 3, 0, 0, 0),
(12, 4, '1', 1, 120, 120, '2017-03-28', 3, 1, 0, 0),
(13, 4, '2', 2, 150, 300, '2017-03-28', 3, 1, 0, 0),
(14, 4, 'Test Service A', 1, 199, 199, '2017-03-28', 3, 0, 0, 0),
(15, 4, 'Test Service B', 1, 200, 200, '2017-03-28', 3, 0, 0, 0),
(24, 5, 'Test Service A', 1, 125, 125, '2017-03-29', 3, 0, 0, 0),
(25, 5, 'Test Service B', 1, 175, 175, '2017-03-29', 3, 0, 0, 0),
(26, 5, '1', 1, 120, 120, '2017-03-29', 3, 1, 0, 0),
(27, 5, '2', 2, 150, 300, '2017-03-29', 3, 1, 0, 0),
(28, 5, '2', 2, 150, 300, '2017-03-29', 3, 1, 0, 0),
(29, 6, '1', 1, 120, 120, '2017-03-29', 3, 1, 0, 0),
(30, 6, '2', 2, 150, 300, '2017-03-29', 3, 1, 0, 0),
(31, 6, 'Test Service A', 1, 120, 120, '2017-03-29', 3, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `race`
--

CREATE TABLE `race` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `status` int(5) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(5) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `race`
--

INSERT INTO `race` (`id`, `name`, `description`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Chinese', 'Chinese citizen', 1, '2017-02-11 16:57:00', 2, '2017-02-11 16:57:00', 2),
(2, 'Malays', 'Malaysia citizen', 1, '2017-02-11 16:57:16', 2, '2017-02-11 16:57:16', 2),
(3, 'Indians', 'Indian citizen', 1, '2017-02-11 16:57:30', 2, '2017-02-11 16:57:30', 2),
(5, 'filipino', 'philippine citizen', 1, '2017-03-09 11:15:02', 2, '2017-03-09 11:15:02', 2),
(6, 'Vietnamese', 'Vietnam Citizen', 1, '2017-03-22 15:11:08', 2, '2017-03-22 15:11:08', 2),
(7, 'Iranans', 'For irans citizen', 1, '2017-03-29 14:08:29', 3, '2017-03-29 14:08:29', 3);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(10) NOT NULL,
  `status` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `role`, `created_at`, `created_by`, `status`) VALUES
(1, 'developer', '2017-03-14 16:35:00', 1, 1),
(2, 'admin', '2017-03-14 16:35:00', 1, 1),
(3, 'staff', '2017-03-14 16:35:00', 1, 1),
(4, 'customer', '2017-03-14 16:35:00', 1, 1),
(5, 'testing', '2017-03-27 12:36:37', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `id` int(11) NOT NULL,
  `service_category_id` int(10) NOT NULL,
  `service_name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `default_price` double NOT NULL,
  `status` int(5) NOT NULL,
  `created_at` date NOT NULL,
  `created_by` int(10) NOT NULL,
  `updated_at` date NOT NULL,
  `updated_by` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`id`, `service_category_id`, `service_name`, `description`, `default_price`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 1, 'Oil Change, Lube & Filter', 'Drive smoothly by maintaining your vehicle''s oil.', 100, 1, '2017-01-16', 1, '2017-01-16', 1),
(2, 1, 'Tire Repair', 'Regular tire inspection and timely repair can help keep you driving safely.', 99, 1, '2017-01-16', 1, '2017-01-16', 1),
(3, 1, 'TOW365', 'Towing assistance, 24/7, to your nearest participating Goodyear Tire & Service Network location.', 300, 1, '2017-01-16', 1, '2017-01-16', 1),
(4, 1, 'Wheel Alignment', 'Proper wheel alignment helps your vehicle run safely and efficiently.', 100, 1, '2017-01-16', 1, '2017-01-16', 1),
(5, 2, 'Air Conditioning', 'Maintain a comfortable temperature for you and your vehicle.', 150, 1, '2017-01-16', 1, '2017-01-16', 1),
(6, 2, 'Batteries', 'The performance of the engine, alternator, and secondary electrical systems depend on the battery.', 200, 1, '2017-01-16', 1, '2017-01-16', 1),
(7, 2, 'Belts & Hoses', 'Avoid breaking down in your vehicle by maintaining its belts and hoses.', 135, 1, '2017-01-16', 1, '2017-01-16', 1),
(8, 2, 'Brake Service', 'Feel confident in your vehicle''s stopping power with regular brake checks.', 100, 1, '2017-01-16', 1, '2017-01-16', 1),
(9, 2, 'Check-Engine Light', 'Keep your ignition, fuel, and emission-control systems doing what they should by maintaining your engine diagnostics.', 125, 1, '2017-01-16', 1, '2017-01-16', 1),
(10, 2, 'Drivelines', 'Drivelines are responsible for the speed of your vehicle, so it''s important to keep them in good working order.', 99, 1, '2017-01-16', 1, '2017-01-16', 1),
(11, 3, 'Tire Installation', 'Proper installation enables tires to function fully and correctly.', 110, 1, '2017-01-16', 1, '2017-01-16', 1),
(12, 3, 'Tire Rotation', 'Avoid uneven treadwear and extend a tire''s life by rotating your tires.', 120, 1, '2017-01-16', 1, '2017-01-16', 1),
(13, 3, 'Tire Pressure Monitoring System (TPMS)', 'Maintain fuel efficiency and prolong tire life by getting your tire pressure monitoring system checked regularly.', 200, 1, '2017-01-16', 1, '2017-01-16', 1),
(14, 3, 'Wheel Balance', 'Routinely balance your tires to avoid uneven wear, vibration, and potentially unsafe driving conditions.', 100, 1, '2017-01-16', 1, '2017-01-16', 1),
(15, 4, 'break alignment', 'aligning of break and checking of breaks', 199, 1, '2017-03-02', 2, '2017-03-02', 2);

-- --------------------------------------------------------

--
-- Table structure for table `service_category`
--

CREATE TABLE `service_category` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `status` int(5) NOT NULL,
  `created_at` date NOT NULL,
  `created_by` int(10) NOT NULL,
  `updated_at` date NOT NULL,
  `updated_by` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `service_category`
--

INSERT INTO `service_category` (`id`, `name`, `description`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Popular Auto & Tire Services', 'For Popular Auto & Tire Services', 1, '2017-01-16', 1, '2017-01-16', 1),
(2, 'Additional Auto Services', 'For Additional Auto Services', 1, '2017-01-16', 1, '2017-01-16', 1),
(3, 'Additional Tire Services', 'For Additional Tire Services', 1, '2017-01-16', 1, '2017-01-16', 1),
(4, 'break', 'all about car break repairing', 1, '2017-03-02', 2, '2017-03-02', 2);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `staff_group_id` int(5) NOT NULL,
  `designated_position_id` int(5) NOT NULL,
  `staff_code` varchar(50) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `race_id` int(5) NOT NULL,
  `citizenship` int(5) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact_number` varchar(50) NOT NULL,
  `ic_no` varchar(50) NOT NULL,
  `rate_per_hour` double(10,2) NOT NULL,
  `allowance` double(10,2) NOT NULL,
  `basic` double(10,2) NOT NULL,
  `non_tax_allowance` double(10,2) NOT NULL,
  `levy_supplement` double(10,2) NOT NULL,
  `status` int(5) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(5) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `staff_group_id`, `designated_position_id`, `staff_code`, `fullname`, `address`, `race_id`, `citizenship`, `gender`, `email`, `contact_number`, `ic_no`, `rate_per_hour`, `allowance`, `basic`, `non_tax_allowance`, `levy_supplement`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 1, 2, 'EMP002', 'Alvin Sy', '23rd DMCI Homes Shaw Blvd. Mandaluyong City ', 2, 1, 'Male', 'alvinsy@yahoo.com', '09087896541', '19900305PH', 500.00, 7000.00, 15000.00, 0.00, 0.00, 1, '2017-03-27 14:13:42', 2, '2017-03-27 14:13:42', 2);

-- --------------------------------------------------------

--
-- Table structure for table `staff_group`
--

CREATE TABLE `staff_group` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `status` int(5) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(5) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff_group`
--

INSERT INTO `staff_group` (`id`, `name`, `description`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'IT Department', 'For Technical Employee', 1, '2017-02-10 00:00:00', 2, '2017-02-10 00:00:00', 2),
(2, 'Accounting Department', 'For Accounting Employee', 1, '2017-03-02 00:00:00', 2, '2017-03-02 00:00:00', 2),
(6, 'Sales Department', 'For Product Sales Employee', 1, '2017-03-15 14:52:14', 2, '2017-03-15 14:52:14', 2),
(7, 'QA Tester Department', 'For System Tester Employee', 1, '2017-03-15 16:12:28', 2, '2017-03-15 16:12:28', 2),
(8, 'Workshop', 'For All Services Employee', 1, '2017-03-22 15:11:55', 2, '2017-03-22 15:11:55', 2),
(9, 'testing department', 'for testing department', 1, '2017-03-27 13:22:06', 2, '2017-03-27 13:22:06', 2);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `supplier_code` varchar(50) NOT NULL,
  `supplier_name` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `contact_number` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(10) NOT NULL,
  `status` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `supplier_code`, `supplier_name`, `address`, `contact_number`, `created_at`, `created_by`, `status`) VALUES
(1, 'SUPPLIERS-2017-71143', 'testing', '123 testing', '12345678', '2017-03-28 10:53:46', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `terms_and_conditions`
--

CREATE TABLE `terms_and_conditions` (
  `id` int(11) NOT NULL,
  `descriptions` text NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(5) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(5) NOT NULL,
  `status` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `terms_and_conditions`
--

INSERT INTO `terms_and_conditions` (`id`, `descriptions`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(1, 'I/We hereby authorized the repairs stipulated and any necessary and essential work and supply of materials arising therefrom.', '2017-03-14 00:00:00', 1, '2017-03-14 00:00:00', 1, 1),
(2, 'The vehicle may be driven on the road for testing purposes or otherwise in carrying out such repairs. Any claim for any damage caused to the vehicle during the course of the road test or repair arising from any accident or otherwise is limited to that rectification free of cost.', '2017-03-14 00:00:00', 1, '2017-03-14 00:00:00', 1, 1),
(3, 'The vehicle, Its accessories and contents are at time at my/our risk whatever the cause of any damage thereto ro theft or loss thereof, Any claim for faulty workmanship is limited solely to the rectification free of cost of such faulty works, no claim for loss consequential or otherwise being admissable.', '2017-03-14 00:00:00', 1, '2017-03-14 00:00:00', 1, 1),
(4, 'I/We acknowledge and agree that an express lien favour of Auto Recovery Hub Pte Ltd. shall subsist on the vehicle to secure the cost of works carried out, until full payment therein shall have been received by Auto Recovery Hub Pte Ltd.', '2017-03-14 00:00:00', 1, '2017-03-14 00:00:00', 1, 1),
(5, 'Payment Terms strictly Cash / Nets / Visa or Master Credit Card. All Cheque are not accepted.', '2017-03-14 00:00:00', 1, '2017-03-14 00:00:00', 1, 1),
(6, 'I will paid the full sum of the Job Sheet / Invoice / Cash bill on the collection of my vehicle.', '2017-03-14 00:00:00', 1, '2017-03-14 00:00:00', 1, 1),
(7, 'In the event i default in the above payment(s). I shall be liable to pay all your legal costs incurred by you to recover the outstanding sum(s) from me, on an indemnity basis.', '2017-03-14 00:00:00', 1, '2017-03-14 00:00:00', 1, 1),
(8, 'tests', '2017-03-29 13:59:53', 3, '2017-03-29 13:59:53', 3, 0),
(9, 'The vehicle had received in good and satisfactory.', '2017-03-30 10:00:01', 3, '2017-03-30 10:00:01', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `role_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL,
  `role` int(10) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `password_hash` varchar(100) NOT NULL,
  `password_reset_token` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `photo` varchar(50) NOT NULL,
  `auth_key` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `login` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(10) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(10) NOT NULL,
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `role_id`, `branch_id`, `role`, `fullname`, `username`, `password`, `password_hash`, `password_reset_token`, `email`, `photo`, `auth_key`, `status`, `login`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted`) VALUES
(1, 1, 1, 20, 'Jose Czar L. Yanga', 'jcyanga28', 'password', '$2y$13$KLYNdyN9n.CXY4uELu9Td.6LJ1BoXrXQY0dmrnb9HUMegb1dPw.YK', '', 'jcyanga412060@gmail.com', 'user.png', 'R5BJVsB83hg7xshurVUaXb6qYn4HrFi8', 1, '2017-01-17 19:00:00', '2017-01-17 19:00:00', 1, '2017-01-17 19:00:00', 1, 0),
(2, 1, 1, 20, 'system developer', 'developer', 'password', '$2y$13$mzyT6.9w8SJIbPDMhRFaPOhF6vUwGHYOIu2KHF3W7fX5MxWAzScMu', '', 'DEVELOPER@YAHOO.COM', 'user1-128x128.jpg', '8xp_z8wIbYU0jHs3BqfBtvJipvhHOcgz', 1, '2017-01-17 19:00:00', '2017-01-17 19:00:00', 1, '2017-03-09 11:19:04', 2, 0),
(3, 2, 2, 20, 'ADMINISTRATOR', 'ADMIN', 'password', '$2y$13$a4PjcBwtHqtE9K4PX2TM1O/ctbfuuGlE5/hsnuZsbzvR2wQSKnFEG', '', 'ADMIN@ARHGROUP.COM.SG', 'user8-128x128.jpg', 'CJrYY7GDoeHb-uDJweJWU544GLk74gQZ', 1, '0000-00-00 00:00:00', '2017-01-23 14:36:18', 1, '2017-03-23 15:23:09', 3, 0),
(4, 3, 2, 20, 'carmina ting tan', 'carminatingtan', '123456', '$2y$13$KJsYV/TGCejs.wXUPOvd3eLX4ez1kB0deBFoz3aYMb2Uj1/Jhf2hO', '', 'carminatingtan@arhgroup.com.sg', 'user.png', 'gHzNCh2gTqB8DYcvgqocoWWwwGDj1f-X', 1, '0000-00-00 00:00:00', '2017-03-27 11:04:25', 2, '2017-03-27 11:21:35', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_permission`
--

CREATE TABLE `user_permission` (
  `id` int(11) NOT NULL,
  `controller` varchar(50) NOT NULL,
  `action` varchar(50) NOT NULL,
  `role_id` int(10) NOT NULL,
  `status` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_permission`
--

INSERT INTO `user_permission` (`id`, `controller`, `action`, `role_id`, `status`) VALUES
(61, 'QuotationSubtotal', 'index', 1, 1),
(62, 'QuotationSubtotal', 'view', 1, 1),
(63, 'QuotationSubtotal', 'create', 1, 1),
(64, 'QuotationSubtotal', 'update', 1, 1),
(65, 'QuotationSubtotal', 'delete', 1, 1),
(74, 'ServiceCategory', 'index', 1, 1),
(75, 'ServiceCategory', 'view', 1, 1),
(76, 'ServiceCategory', 'create', 1, 1),
(77, 'ServiceCategory', 'update', 1, 1),
(78, 'ServiceCategory', 'delete', 1, 1),
(79, 'ServiceCategory', 'delete-column', 1, 1),
(80, 'ServiceCategory', 'export-excel', 1, 1),
(81, 'ServiceCategory', 'export-pdf', 1, 1),
(82, 'Service', 'index', 1, 1),
(83, 'Service', 'view', 1, 1),
(84, 'Service', 'create', 1, 1),
(85, 'Service', 'update', 1, 1),
(86, 'Service', 'delete', 1, 1),
(87, 'Service', 'delete-column', 1, 1),
(88, 'Service', 'export-excel', 1, 1),
(89, 'Service', 'export-pdf', 1, 1),
(93, 'Stocks', 'index', 1, 1),
(94, 'Stocks', 'create', 1, 1),
(95, 'Stocks', 'update', 1, 1),
(178, 'QuotationSubtotal', 'index', 2, 1),
(179, 'QuotationSubtotal', 'view', 2, 1),
(180, 'QuotationSubtotal', 'create', 2, 1),
(181, 'QuotationSubtotal', 'update', 2, 1),
(182, 'QuotationSubtotal', 'delete', 2, 1),
(191, 'ServiceCategory', 'index', 2, 1),
(192, 'ServiceCategory', 'view', 2, 1),
(193, 'ServiceCategory', 'create', 2, 1),
(194, 'ServiceCategory', 'update', 2, 1),
(195, 'ServiceCategory', 'delete', 2, 1),
(196, 'ServiceCategory', 'delete-column', 2, 1),
(197, 'ServiceCategory', 'export-excel', 2, 1),
(198, 'ServiceCategory', 'export-pdf', 2, 1),
(199, 'Service', 'index', 2, 1),
(200, 'Service', 'view', 2, 1),
(201, 'Service', 'create', 2, 1),
(202, 'Service', 'update', 2, 1),
(203, 'Service', 'delete', 2, 1),
(204, 'Service', 'delete-column', 2, 1),
(205, 'Service', 'export-excel', 2, 1),
(206, 'Service', 'export-pdf', 2, 1),
(207, 'Site', 'index', 2, 1),
(208, 'Site', 'login', 2, 1),
(209, 'Site', 'logout', 2, 1),
(210, 'Stocks', 'index', 2, 1),
(211, 'Stocks', 'create', 2, 1),
(212, 'Stocks', 'update', 2, 1),
(250, 'UserPermission', 'index', 1, 1),
(251, 'UserPermission', 'view', 1, 1),
(252, 'UserPermission', 'create', 1, 1),
(253, 'UserPermission', 'update', 1, 1),
(254, 'UserPermission', 'delete', 1, 1),
(255, 'UserPermission', 'delete-column', 1, 1),
(256, 'UserPermission', 'set-permission', 1, 1),
(257, 'StockIn', 'index', 1, 1),
(258, 'StockIn', 'view', 1, 1),
(259, 'StockIn', 'create', 1, 1),
(260, 'StockIn', 'update', 1, 1),
(261, 'StockIn', 'delete', 1, 1),
(262, 'QuotationDetail', 'index', 1, 1),
(263, 'QuotationDetail', 'view', 1, 1),
(264, 'QuotationDetail', 'create', 1, 1),
(265, 'QuotationDetail', 'update', 1, 1),
(266, 'QuotationDetail', 'delete', 1, 1),
(275, 'ModuleAccess', 'index', 1, 1),
(276, 'ModuleAccess', 'view', 1, 1),
(277, 'ModuleAccess', 'create', 1, 1),
(278, 'ModuleAccess', 'update', 1, 1),
(279, 'ModuleAccess', 'delete', 1, 1),
(280, 'ModuleAccess', 'index', 2, 1),
(281, 'ModuleAccess', 'view', 2, 1),
(282, 'ModuleAccess', 'create', 2, 1),
(283, 'ModuleAccess', 'update', 2, 1),
(284, 'ModuleAccess', 'delete', 2, 1),
(293, 'QuotationDetail', 'index', 2, 1),
(294, 'QuotationDetail', 'view', 2, 1),
(295, 'QuotationDetail', 'create', 2, 1),
(296, 'QuotationDetail', 'update', 2, 1),
(297, 'QuotationDetail', 'delete', 2, 1),
(298, 'StockIn', 'index', 2, 1),
(299, 'StockIn', 'view', 2, 1),
(300, 'StockIn', 'create', 2, 1),
(301, 'StockIn', 'update', 2, 1),
(302, 'StockIn', 'delete', 2, 1),
(303, 'UserPermission', 'index', 2, 1),
(304, 'UserPermission', 'view', 2, 1),
(305, 'UserPermission', 'create', 2, 1),
(306, 'UserPermission', 'update', 2, 1),
(307, 'UserPermission', 'delete', 2, 1),
(308, 'UserPermission', 'delete-column', 2, 1),
(309, 'UserPermission', 'set-permission', 2, 1),
(310, 'QuotationDetail', 'index', 3, 1),
(311, 'QuotationDetail', 'view', 3, 1),
(312, 'QuotationDetail', 'create', 3, 1),
(313, 'QuotationDetail', 'update', 3, 1),
(314, 'QuotationDetail', 'delete', 3, 1),
(423, 'Site', 'index', 3, 1),
(424, 'Site', 'login', 3, 1),
(425, 'Site', 'logout', 3, 1),
(431, 'Site', 'index', 4, 1),
(432, 'Site', 'login', 4, 1),
(433, 'Site', 'logout', 4, 1),
(589, 'Reports', 'index', 1, 1),
(590, 'Reports', 'monthly-stock-report', 1, 1),
(591, 'Reports', 'print-monthly-stock-report-excel', 1, 1),
(592, 'Reports', 'monthly-sales-report', 1, 1),
(593, 'Reports', 'print-monthly-sales-report-excel', 1, 1),
(594, 'Reports', 'best-selling-product-report', 1, 1),
(595, 'Reports', 'print-best-selling-product-report-excel', 1, 1),
(631, 'Reports', 'index', 2, 1),
(632, 'Reports', 'monthly-stock-report', 2, 1),
(633, 'Reports', 'print-monthly-stock-report-excel', 2, 1),
(634, 'Reports', 'monthly-sales-report', 2, 1),
(635, 'Reports', 'print-monthly-sales-report-excel', 2, 1),
(636, 'Reports', 'best-selling-product-report', 2, 1),
(637, 'Reports', 'print-best-selling-product-report-excel', 2, 1),
(674, 'Stocks', 'index', 3, 1),
(675, 'Stocks', 'create', 3, 1),
(676, 'Stocks', 'update', 3, 1),
(685, 'Invoice', 'index', 3, 1),
(686, 'Invoice', 'view', 3, 1),
(687, 'Invoice', 'create', 3, 1),
(688, 'Invoice', 'preview', 3, 1),
(689, 'Invoice', 'update', 3, 1),
(690, 'Invoice', 'delete', 3, 1),
(691, 'Invoice', 'delete-column', 3, 1),
(692, 'Invoice', 'delete-selected-quotation-detail', 3, 1),
(693, 'Invoice', 'price', 3, 1),
(694, 'Invoice', 'insert-in-list', 3, 1),
(695, 'Invoice', 'payment-method', 3, 1),
(696, 'Invoice', 'save-payment', 3, 1),
(697, 'Invoice', 'insert-in-payment-list', 3, 1),
(698, 'Invoice', 'print-invoice', 3, 1),
(699, 'Invoice', 'print-multiple-invoice', 3, 1),
(700, 'Invoice', 'export-excel', 3, 1),
(701, 'Invoice', 'invoice-export-pdf', 3, 1),
(702, 'Invoice', 'multiple-invoice-export-pdf', 3, 1),
(733, 'Customer', 'index', 3, 1),
(734, 'Customer', 'view', 3, 1),
(735, 'Customer', 'create', 3, 1),
(736, 'Customer', 'update', 3, 1),
(737, 'Customer', 'delete', 3, 1),
(738, 'Customer', 'delete-column', 3, 1),
(739, 'Customer', 'points-redemption-history', 3, 1),
(740, 'Customer', 'export-excel', 3, 1),
(741, 'Customer', 'export-pdf', 3, 1),
(918, 'Site', 'index', 1, 1),
(919, 'Site', 'view', 1, 1),
(920, 'Site', 'login', 1, 1),
(921, 'Site', 'logout', 1, 1),
(922, 'Site', 'auto-complete', 1, 1),
(1491, 'PaymentStatus', 'index', 1, 1),
(1492, 'PaymentStatus', 'view', 1, 1),
(1493, 'PaymentStatus', 'create', 1, 1),
(1494, 'PaymentStatus', 'update', 1, 1),
(1495, 'PaymentStatus', 'delete', 1, 1),
(1496, 'PaymentStatus', 'delete-column', 1, 1),
(1497, 'PaymentStatus', 'export-excel', 1, 1),
(1498, 'PaymentStatus', 'export-pdf', 1, 1),
(1984, 'Quotation', 'index', 3, 1),
(1985, 'Quotation', 'view', 3, 1),
(1986, 'Quotation', 'create', 3, 1),
(1987, 'Quotation', 'preview', 3, 1),
(1988, 'Quotation', 'update', 3, 1),
(1989, 'Quotation', 'delete-column', 3, 1),
(1990, 'Quotation', 'price', 3, 1),
(1991, 'Quotation', 'insert-in-list', 3, 1),
(1992, 'Quotation', 'insert-invoice', 3, 1),
(1993, 'Quotation', 'export-excel', 3, 1),
(2143, 'Inventory', 'index', 2, 1),
(2144, 'Inventory', 'view', 2, 1),
(2145, 'Inventory', 'create', 2, 1),
(2146, 'Inventory', 'update', 2, 1),
(2147, 'Inventory', 'delete', 2, 1),
(2148, 'Inventory', 'delete-column', 2, 1),
(2149, 'Inventory', 'update-qty', 2, 1),
(2150, 'Inventory', 'save-update-parts-qty', 2, 1),
(2151, 'Inventory', 'export-excel', 2, 1),
(2152, 'Inventory', 'export-pdf', 2, 1),
(2153, 'Inventory', 'get-product-information', 2, 1),
(2154, 'Inventory', 'add-quantity', 2, 1),
(2155, 'Inventory', 'deduct-quantity', 2, 1),
(2156, 'Inventory', 'get-product-quantity', 2, 1),
(2157, 'Inventory', 'insert-in-list', 2, 1),
(2199, 'Invoice', 'index', 1, 1),
(2200, 'Invoice', 'view', 1, 1),
(2201, 'Invoice', 'create', 1, 1),
(2202, 'Invoice', 'preview', 1, 1),
(2203, 'Invoice', 'update', 1, 1),
(2204, 'Invoice', 'delete', 1, 1),
(2205, 'Invoice', 'delete-column', 1, 1),
(2206, 'Invoice', 'delete-selected-quotation-detail', 1, 1),
(2207, 'Invoice', 'insert-in-list', 1, 1),
(2208, 'Invoice', 'payment-method', 1, 1),
(2209, 'Invoice', 'insert-in-payment-list', 1, 1),
(2210, 'Invoice', 'export-excel', 1, 1),
(2211, 'Invoice', 'parts-list', 1, 1),
(2212, 'Invoice', 'parts-by-category', 1, 1),
(2213, 'Invoice', 'insert-other-part', 1, 1),
(2214, 'Invoice', 'insert-parts-in-item-list', 1, 1),
(2215, 'Invoice', 'insert-parts-in-list', 1, 1),
(2216, 'Invoice', 'service-list', 1, 1),
(2217, 'Invoice', 'service-by-category', 1, 1),
(2218, 'Invoice', 'insert-other-service', 1, 1),
(2219, 'Invoice', 'insert-service-in-item-list', 1, 1),
(2220, 'Invoice', 'insert-service-in-list', 1, 1),
(2221, 'Invoice', 'get-branch-gst-by-id', 1, 1),
(2222, 'Invoice', 'get-customer-information', 1, 1),
(2223, 'Invoice', 'get-payment-type', 1, 1),
(2224, 'Invoice', 'get-payment-type-and-others', 1, 1),
(2225, 'Invoice', 'save-single-payment', 1, 1),
(2226, 'Invoice', 'print-single-payment', 1, 1),
(2227, 'Invoice', 'save-multiple-payment', 1, 1),
(2228, 'Invoice', 'print-multiple-payment', 1, 1),
(2229, 'Invoice', 'print-invoice', 1, 1),
(2230, 'Invoice', 'print-multiple-invoice', 1, 1),
(2231, 'Invoice', 'print-invoice-not-paid', 1, 1),
(2232, 'Invoice', 'view-by-customer-search', 1, 1),
(2233, 'Invoice', 'view-by-outstanding-payments', 1, 1),
(2234, 'Invoice', 'view-by-pending-services', 1, 1),
(2235, 'Invoice', 'price', 1, 1),
(2236, 'Invoice', 'create-from-quotation', 1, 1),
(2237, 'Invoice', 'index', 2, 1),
(2238, 'Invoice', 'view', 2, 1),
(2239, 'Invoice', 'create', 2, 1),
(2240, 'Invoice', 'preview', 2, 1),
(2241, 'Invoice', 'update', 2, 1),
(2242, 'Invoice', 'delete', 2, 1),
(2243, 'Invoice', 'delete-column', 2, 1),
(2244, 'Invoice', 'delete-selected-quotation-detail', 2, 1),
(2245, 'Invoice', 'insert-in-list', 2, 1),
(2246, 'Invoice', 'payment-method', 2, 1),
(2247, 'Invoice', 'insert-in-payment-list', 2, 1),
(2248, 'Invoice', 'export-excel', 2, 1),
(2249, 'Invoice', 'parts-list', 2, 1),
(2250, 'Invoice', 'parts-by-category', 2, 1),
(2251, 'Invoice', 'insert-other-part', 2, 1),
(2252, 'Invoice', 'insert-parts-in-item-list', 2, 1),
(2253, 'Invoice', 'insert-parts-in-list', 2, 1),
(2254, 'Invoice', 'service-list', 2, 1),
(2255, 'Invoice', 'service-by-category', 2, 1),
(2256, 'Invoice', 'insert-other-service', 2, 1),
(2257, 'Invoice', 'insert-service-in-item-list', 2, 1),
(2258, 'Invoice', 'insert-service-in-list', 2, 1),
(2259, 'Invoice', 'get-branch-gst-by-id', 2, 1),
(2260, 'Invoice', 'get-customer-information', 2, 1),
(2261, 'Invoice', 'get-payment-type', 2, 1),
(2262, 'Invoice', 'get-payment-type-and-others', 2, 1),
(2263, 'Invoice', 'save-single-payment', 2, 1),
(2264, 'Invoice', 'print-single-payment', 2, 1),
(2265, 'Invoice', 'save-multiple-payment', 2, 1),
(2266, 'Invoice', 'print-multiple-payment', 2, 1),
(2267, 'Invoice', 'print-invoice', 2, 1),
(2268, 'Invoice', 'print-multiple-invoice', 2, 1),
(2269, 'Invoice', 'print-invoice-not-paid', 2, 1),
(2270, 'Invoice', 'view-by-customer-search', 2, 1),
(2271, 'Invoice', 'view-by-outstanding-payments', 2, 1),
(2272, 'Invoice', 'view-by-pending-services', 2, 1),
(2273, 'Invoice', 'price', 2, 1),
(2274, 'Invoice', 'create-from-quotation', 2, 1),
(2298, 'Inventory', 'index', 1, 1),
(2299, 'Inventory', 'view', 1, 1),
(2300, 'Inventory', 'create', 1, 1),
(2301, 'Inventory', 'update', 1, 1),
(2302, 'Inventory', 'delete', 1, 1),
(2303, 'Inventory', 'export-excel', 1, 1),
(2304, 'Inventory', 'export-pdf', 1, 1),
(2305, 'Inventory', 'edit-qty', 1, 1),
(2478, 'User', 'index', 1, 1),
(2479, 'User', 'view', 1, 1),
(2480, 'User', 'create', 1, 1),
(2481, 'User', 'new', 1, 1),
(2482, 'User', 'update', 1, 1),
(2483, 'User', 'edit', 1, 1),
(2484, 'User', 'delete', 1, 1),
(2485, 'User', 'delete-column', 1, 1),
(2486, 'User', 'export-excel', 1, 1),
(2487, 'User', 'export-pdf', 1, 1),
(2488, 'User', 'index', 2, 1),
(2489, 'User', 'view', 2, 1),
(2490, 'User', 'create', 2, 1),
(2491, 'User', 'new', 2, 1),
(2492, 'User', 'update', 2, 1),
(2493, 'User', 'edit', 2, 1),
(2494, 'User', 'delete', 2, 1),
(2495, 'User', 'delete-column', 2, 1),
(2496, 'User', 'export-excel', 2, 1),
(2497, 'User', 'export-pdf', 2, 1),
(2498, 'Branch', 'index', 1, 1),
(2499, 'Branch', 'view', 1, 1),
(2500, 'Branch', 'create', 1, 1),
(2501, 'Branch', 'new', 1, 1),
(2502, 'Branch', 'update', 1, 1),
(2503, 'Branch', 'edit', 1, 1),
(2504, 'Branch', 'delete', 1, 1),
(2505, 'Branch', 'delete-column', 1, 1),
(2506, 'Branch', 'export-excel', 1, 1),
(2507, 'Branch', 'export-pdf', 1, 1),
(2508, 'Branch', 'index', 2, 1),
(2509, 'Branch', 'view', 2, 1),
(2510, 'Branch', 'create', 2, 1),
(2511, 'Branch', 'new', 2, 1),
(2512, 'Branch', 'update', 2, 1),
(2513, 'Branch', 'edit', 2, 1),
(2514, 'Branch', 'delete', 2, 1),
(2515, 'Branch', 'delete-column', 2, 1),
(2516, 'Branch', 'export-excel', 2, 1),
(2517, 'Branch', 'export-pdf', 2, 1),
(2518, 'Role', 'index', 1, 1),
(2519, 'Role', 'view', 1, 1),
(2520, 'Role', 'create', 1, 1),
(2521, 'Role', 'new', 1, 1),
(2522, 'Role', 'update', 1, 1),
(2523, 'Role', 'edit', 1, 1),
(2524, 'Role', 'delete', 1, 1),
(2525, 'Role', 'delete-column', 1, 1),
(2526, 'Role', 'export-excel', 1, 1),
(2527, 'Role', 'export-pdf', 1, 1),
(2528, 'Role', 'index', 2, 1),
(2529, 'Role', 'view', 2, 1),
(2530, 'Role', 'create', 2, 1),
(2531, 'Role', 'new', 2, 1),
(2532, 'Role', 'update', 2, 1),
(2533, 'Role', 'edit', 2, 1),
(2534, 'Role', 'delete', 2, 1),
(2535, 'Role', 'delete-column', 2, 1),
(2536, 'Role', 'export-excel', 2, 1),
(2537, 'Role', 'export-pdf', 2, 1),
(2548, 'Modules', 'index', 2, 1),
(2549, 'Modules', 'view', 2, 1),
(2550, 'Modules', 'create', 2, 1),
(2551, 'Modules', 'new', 2, 1),
(2552, 'Modules', 'update', 2, 1),
(2553, 'Modules', 'edit', 2, 1),
(2554, 'Modules', 'delete', 2, 1),
(2555, 'Modules', 'delete-column', 2, 1),
(2556, 'Modules', 'export-excel', 2, 1),
(2557, 'Modules', 'export-pdf', 2, 1),
(2558, 'Modules', 'index', 1, 1),
(2559, 'Modules', 'view', 1, 1),
(2560, 'Modules', 'create', 1, 1),
(2561, 'Modules', 'new', 1, 1),
(2562, 'Modules', 'update', 1, 1),
(2563, 'Modules', 'edit', 1, 1),
(2564, 'Modules', 'delete', 1, 1),
(2565, 'Modules', 'delete-column', 1, 1),
(2566, 'Modules', 'export-excel', 1, 1),
(2567, 'Modules', 'export-pdf', 1, 1),
(2568, 'StaffGroup', 'index', 1, 1),
(2569, 'StaffGroup', 'view', 1, 1),
(2570, 'StaffGroup', 'create', 1, 1),
(2571, 'StaffGroup', 'new', 1, 1),
(2572, 'StaffGroup', 'update', 1, 1),
(2573, 'StaffGroup', 'edit', 1, 1),
(2574, 'StaffGroup', 'delete', 1, 1),
(2575, 'StaffGroup', 'delete-column', 1, 1),
(2576, 'StaffGroup', 'export-excel', 1, 1),
(2577, 'StaffGroup', 'export-pdf', 1, 1),
(2578, 'StaffGroup', 'index', 2, 1),
(2579, 'StaffGroup', 'view', 2, 1),
(2580, 'StaffGroup', 'create', 2, 1),
(2581, 'StaffGroup', 'new', 2, 1),
(2582, 'StaffGroup', 'update', 2, 1),
(2583, 'StaffGroup', 'edit', 2, 1),
(2584, 'StaffGroup', 'delete', 2, 1),
(2585, 'StaffGroup', 'delete-column', 2, 1),
(2586, 'StaffGroup', 'export-excel', 2, 1),
(2587, 'StaffGroup', 'export-pdf', 2, 1),
(2588, 'Staff', 'index', 1, 1),
(2589, 'Staff', 'view', 1, 1),
(2590, 'Staff', 'create', 1, 1),
(2591, 'Staff', 'new', 1, 1),
(2592, 'Staff', 'update', 1, 1),
(2593, 'Staff', 'edit', 1, 1),
(2594, 'Staff', 'delete', 1, 1),
(2595, 'Staff', 'delete-column', 1, 1),
(2596, 'Staff', 'export-excel', 1, 1),
(2597, 'Staff', 'export-pdf', 1, 1),
(2598, 'Staff', 'index', 2, 1),
(2599, 'Staff', 'view', 2, 1),
(2600, 'Staff', 'create', 2, 1),
(2601, 'Staff', 'new', 2, 1),
(2602, 'Staff', 'update', 2, 1),
(2603, 'Staff', 'edit', 2, 1),
(2604, 'Staff', 'delete', 2, 1),
(2605, 'Staff', 'delete-column', 2, 1),
(2606, 'Staff', 'export-excel', 2, 1),
(2607, 'Staff', 'export-pdf', 2, 1),
(2608, 'Payroll', 'index', 1, 1),
(2609, 'Payroll', 'view', 1, 1),
(2610, 'Payroll', 'create', 1, 1),
(2611, 'Payroll', 'new', 1, 1),
(2612, 'Payroll', 'update', 1, 1),
(2613, 'Payroll', 'edit', 1, 1),
(2614, 'Payroll', 'delete', 1, 1),
(2615, 'Payroll', 'delete-column', 1, 1),
(2616, 'Payroll', 'print-local-payslip', 1, 1),
(2617, 'Payroll', 'print-foreign-payslip', 1, 1),
(2618, 'Payroll', 'get-staff-citizenship', 1, 1),
(2658, 'Payroll', 'index', 2, 1),
(2659, 'Payroll', 'view', 2, 1),
(2660, 'Payroll', 'create', 2, 1),
(2661, 'Payroll', 'new', 2, 1),
(2662, 'Payroll', 'update', 2, 1),
(2663, 'Payroll', 'edit', 2, 1),
(2664, 'Payroll', 'delete', 2, 1),
(2665, 'Payroll', 'delete-column', 2, 1),
(2666, 'Payroll', 'print-local-payslip', 2, 1),
(2667, 'Payroll', 'print-foreign-payslip', 2, 1),
(2668, 'Payroll', 'get-staff-citizenship', 2, 1),
(2669, 'Customer', 'index', 1, 1),
(2670, 'Customer', 'view', 1, 1),
(2671, 'Customer', 'create', 1, 1),
(2672, 'Customer', 'new-company', 1, 1),
(2673, 'Customer', 'new-customer', 1, 1),
(2674, 'Customer', 'update', 1, 1),
(2675, 'Customer', 'edit-company', 1, 1),
(2676, 'Customer', 'edit-customer', 1, 1),
(2677, 'Customer', 'delete', 1, 1),
(2678, 'Customer', 'delete-column', 1, 1),
(2679, 'Customer', 'block-customer', 1, 1),
(2680, 'Customer', 'unblock-customer', 1, 1),
(2681, 'Customer', 'points-redemption-history', 1, 1),
(2682, 'Customer', 'insert-item-in-list', 1, 1),
(2683, 'Customer', 'export-excel', 1, 1),
(2684, 'Customer', 'export-pdf', 1, 1),
(2685, 'Customer', 'index', 2, 1),
(2686, 'Customer', 'view', 2, 1),
(2687, 'Customer', 'create', 2, 1),
(2688, 'Customer', 'new-company', 2, 1),
(2689, 'Customer', 'new-customer', 2, 1),
(2690, 'Customer', 'update', 2, 1),
(2691, 'Customer', 'edit-company', 2, 1),
(2692, 'Customer', 'edit-customer', 2, 1),
(2693, 'Customer', 'delete', 2, 1),
(2694, 'Customer', 'delete-column', 2, 1),
(2695, 'Customer', 'block-customer', 2, 1),
(2696, 'Customer', 'unblock-customer', 2, 1),
(2697, 'Customer', 'points-redemption-history', 2, 1),
(2698, 'Customer', 'insert-item-in-list', 2, 1),
(2699, 'Customer', 'export-excel', 2, 1),
(2700, 'Customer', 'export-pdf', 2, 1),
(2701, 'Category', 'index', 1, 1),
(2702, 'Category', 'view', 1, 1),
(2703, 'Category', 'create', 1, 1),
(2704, 'Category', 'new', 1, 1),
(2705, 'Category', 'update', 1, 1),
(2706, 'Category', 'edit', 1, 1),
(2707, 'Category', 'delete', 1, 1),
(2708, 'Category', 'delete-column', 1, 1),
(2709, 'Category', 'export-excel', 1, 1),
(2710, 'Category', 'export-pdf', 1, 1),
(2711, 'Category', 'index', 2, 1),
(2712, 'Category', 'view', 2, 1),
(2713, 'Category', 'create', 2, 1),
(2714, 'Category', 'new', 2, 1),
(2715, 'Category', 'update', 2, 1),
(2716, 'Category', 'edit', 2, 1),
(2717, 'Category', 'delete', 2, 1),
(2718, 'Category', 'delete-column', 2, 1),
(2719, 'Category', 'export-excel', 2, 1),
(2720, 'Category', 'export-pdf', 2, 1),
(2721, 'Supplier', 'index', 1, 1),
(2722, 'Supplier', 'view', 1, 1),
(2723, 'Supplier', 'create', 1, 1),
(2724, 'Supplier', 'new', 1, 1),
(2725, 'Supplier', 'update', 1, 1),
(2726, 'Supplier', 'edit', 1, 1),
(2727, 'Supplier', 'delete', 1, 1),
(2728, 'Supplier', 'delete-column', 1, 1),
(2729, 'Supplier', 'export-excel', 1, 1),
(2730, 'Supplier', 'export-pdf', 1, 1),
(2731, 'Supplier', 'index', 2, 1),
(2732, 'Supplier', 'view', 2, 1),
(2733, 'Supplier', 'create', 2, 1),
(2734, 'Supplier', 'new', 2, 1),
(2735, 'Supplier', 'update', 2, 1),
(2736, 'Supplier', 'edit', 2, 1),
(2737, 'Supplier', 'delete', 2, 1),
(2738, 'Supplier', 'delete-column', 2, 1),
(2739, 'Supplier', 'export-excel', 2, 1),
(2740, 'Supplier', 'export-pdf', 2, 1),
(2769, 'Quotation', 'index', 1, 1),
(2770, 'Quotation', 'view', 1, 1),
(2771, 'Quotation', 'create', 1, 1),
(2772, 'Quotation', 'preview', 1, 1),
(2773, 'Quotation', 'update', 1, 1),
(2774, 'Quotation', 'delete', 1, 1),
(2775, 'Quotation', 'delete-column', 1, 1),
(2776, 'Quotation', 'price', 1, 1),
(2777, 'Quotation', 'insert-in-list', 1, 1),
(2778, 'Quotation', 'insert-invoice', 1, 1),
(2779, 'Quotation', 'create-customer', 1, 1),
(2780, 'Quotation', 'new-company', 1, 1),
(2781, 'Quotation', 'new-customer', 1, 1),
(2782, 'Quotation', 'create-quotation', 1, 1),
(2783, 'Quotation', 'export-excel', 1, 1),
(2784, 'Quotation', 'parts-list', 1, 1),
(2785, 'Quotation', 'parts-by-category', 1, 1),
(2786, 'Quotation', 'insert-other-part', 1, 1),
(2787, 'Quotation', 'insert-parts-in-item-list', 1, 1),
(2788, 'Quotation', 'insert-parts-in-list', 1, 1),
(2789, 'Quotation', 'service-list', 1, 1),
(2790, 'Quotation', 'service-by-category', 1, 1),
(2791, 'Quotation', 'insert-other-service', 1, 1),
(2792, 'Quotation', 'insert-service-in-item-list', 1, 1),
(2793, 'Quotation', 'insert-service-in-list', 1, 1),
(2794, 'Quotation', 'get-branch-gst-by-id', 1, 1),
(2795, 'Quotation', 'get-customer-information', 1, 1),
(2796, 'Quotation', 'index', 2, 1),
(2797, 'Quotation', 'view', 2, 1),
(2798, 'Quotation', 'create', 2, 1),
(2799, 'Quotation', 'preview', 2, 1),
(2800, 'Quotation', 'update', 2, 1),
(2801, 'Quotation', 'delete', 2, 1),
(2802, 'Quotation', 'delete-column', 2, 1),
(2803, 'Quotation', 'price', 2, 1),
(2804, 'Quotation', 'insert-in-list', 2, 1),
(2805, 'Quotation', 'insert-invoice', 2, 1),
(2806, 'Quotation', 'create-customer', 2, 1),
(2807, 'Quotation', 'new-company', 2, 1),
(2808, 'Quotation', 'new-customer', 2, 1),
(2809, 'Quotation', 'create-quotation', 2, 1),
(2810, 'Quotation', 'export-excel', 2, 1),
(2811, 'Quotation', 'parts-list', 2, 1),
(2812, 'Quotation', 'parts-by-category', 2, 1),
(2813, 'Quotation', 'insert-other-part', 2, 1),
(2814, 'Quotation', 'insert-parts-in-item-list', 2, 1),
(2815, 'Quotation', 'insert-parts-in-list', 2, 1),
(2816, 'Quotation', 'service-list', 2, 1),
(2817, 'Quotation', 'service-by-category', 2, 1),
(2818, 'Quotation', 'insert-other-service', 2, 1),
(2819, 'Quotation', 'insert-service-in-item-list', 2, 1),
(2820, 'Quotation', 'insert-service-in-list', 2, 1),
(2821, 'Quotation', 'get-branch-gst-by-id', 2, 1),
(2822, 'Quotation', 'get-customer-information', 2, 1),
(2823, 'DesignatedPosition', 'index', 1, 1),
(2824, 'DesignatedPosition', 'view', 1, 1),
(2825, 'DesignatedPosition', 'create', 1, 1),
(2826, 'DesignatedPosition', 'new', 1, 1),
(2827, 'DesignatedPosition', 'update', 1, 1),
(2828, 'DesignatedPosition', 'edit', 1, 1),
(2829, 'DesignatedPosition', 'delete', 1, 1),
(2830, 'DesignatedPosition', 'delete-column', 1, 1),
(2831, 'DesignatedPosition', 'export-excel', 1, 1),
(2832, 'DesignatedPosition', 'export-pdf', 1, 1),
(2833, 'DesignatedPosition', 'index', 2, 1),
(2834, 'DesignatedPosition', 'view', 2, 1),
(2835, 'DesignatedPosition', 'create', 2, 1),
(2836, 'DesignatedPosition', 'new', 2, 1),
(2837, 'DesignatedPosition', 'update', 2, 1),
(2838, 'DesignatedPosition', 'edit', 2, 1),
(2839, 'DesignatedPosition', 'delete', 2, 1),
(2840, 'DesignatedPosition', 'delete-column', 2, 1),
(2841, 'DesignatedPosition', 'export-excel', 2, 1),
(2842, 'DesignatedPosition', 'export-pdf', 2, 1),
(2843, 'Gst', 'index', 1, 1),
(2844, 'Gst', 'view', 1, 1),
(2845, 'Gst', 'create', 1, 1),
(2846, 'Gst', 'new', 1, 1),
(2847, 'Gst', 'update', 1, 1),
(2848, 'Gst', 'delete', 1, 1),
(2849, 'Gst', 'delete-column', 1, 1),
(2850, 'Gst', 'index', 2, 1),
(2851, 'Gst', 'view', 2, 1),
(2852, 'Gst', 'create', 2, 1),
(2853, 'Gst', 'new', 2, 1),
(2854, 'Gst', 'update', 2, 1),
(2855, 'Gst', 'delete', 2, 1),
(2856, 'Gst', 'delete-column', 2, 1),
(2857, 'ProductLevel', 'index', 1, 1),
(2858, 'ProductLevel', 'view', 1, 1),
(2859, 'ProductLevel', 'create', 1, 1),
(2860, 'ProductLevel', 'update', 1, 1),
(2861, 'ProductLevel', 'edit', 1, 1),
(2862, 'ProductLevel', 'delete', 1, 1),
(2863, 'ProductLevel', 'index', 2, 1),
(2864, 'ProductLevel', 'view', 2, 1),
(2865, 'ProductLevel', 'create', 2, 1),
(2866, 'ProductLevel', 'update', 2, 1),
(2867, 'ProductLevel', 'edit', 2, 1),
(2868, 'ProductLevel', 'delete', 2, 1),
(2869, 'PaymentType', 'index', 1, 1),
(2870, 'PaymentType', 'view', 1, 1),
(2871, 'PaymentType', 'create', 1, 1),
(2872, 'PaymentType', 'new', 1, 1),
(2873, 'PaymentType', 'update', 1, 1),
(2874, 'PaymentType', 'edit', 1, 1),
(2875, 'PaymentType', 'delete', 1, 1),
(2876, 'PaymentType', 'delete-column', 1, 1),
(2877, 'PaymentType', 'export-excel', 1, 1),
(2878, 'PaymentType', 'export-pdf', 1, 1),
(2879, 'PaymentType', 'index', 2, 1),
(2880, 'PaymentType', 'view', 2, 1),
(2881, 'PaymentType', 'create', 2, 1),
(2882, 'PaymentType', 'new', 2, 1),
(2883, 'PaymentType', 'update', 2, 1),
(2884, 'PaymentType', 'edit', 2, 1),
(2885, 'PaymentType', 'delete', 2, 1),
(2886, 'PaymentType', 'delete-column', 2, 1),
(2887, 'PaymentType', 'export-excel', 2, 1),
(2888, 'PaymentType', 'export-pdf', 2, 1),
(2889, 'TermsAndConditions', 'index', 1, 1),
(2890, 'TermsAndConditions', 'view', 1, 1),
(2891, 'TermsAndConditions', 'create', 1, 1),
(2892, 'TermsAndConditions', 'new', 1, 1),
(2893, 'TermsAndConditions', 'update', 1, 1),
(2894, 'TermsAndConditions', 'edit', 1, 1),
(2895, 'TermsAndConditions', 'delete', 1, 1),
(2896, 'TermsAndConditions', 'delete-column', 1, 1),
(2897, 'TermsAndConditions', 'export-excel', 1, 1),
(2898, 'TermsAndConditions', 'export-pdf', 1, 1),
(2899, 'TermsAndConditions', 'index', 2, 1),
(2900, 'TermsAndConditions', 'view', 2, 1),
(2901, 'TermsAndConditions', 'create', 2, 1),
(2902, 'TermsAndConditions', 'new', 2, 1),
(2903, 'TermsAndConditions', 'update', 2, 1),
(2904, 'TermsAndConditions', 'edit', 2, 1),
(2905, 'TermsAndConditions', 'delete', 2, 1),
(2906, 'TermsAndConditions', 'delete-column', 2, 1),
(2907, 'TermsAndConditions', 'export-excel', 2, 1),
(2908, 'TermsAndConditions', 'export-pdf', 2, 1),
(2917, 'Race', 'index', 1, 1),
(2918, 'Race', 'view', 1, 1),
(2919, 'Race', 'create', 1, 1),
(2920, 'Race', 'new', 1, 1),
(2921, 'Race', 'update', 1, 1),
(2922, 'Race', 'edit', 1, 1),
(2923, 'Race', 'delete', 1, 1),
(2924, 'Race', 'delete-column', 1, 1),
(2925, 'Race', 'export-excel', 1, 1),
(2926, 'Race', 'export-pdf', 1, 1),
(2927, 'Race', 'index', 2, 1),
(2928, 'Race', 'view', 2, 1),
(2929, 'Race', 'create', 2, 1),
(2930, 'Race', 'new', 2, 1),
(2931, 'Race', 'update', 2, 1),
(2932, 'Race', 'edit', 2, 1),
(2933, 'Race', 'delete', 2, 1),
(2934, 'Race', 'delete-column', 2, 1),
(2935, 'Race', 'export-excel', 2, 1),
(2936, 'Race', 'export-pdf', 2, 1),
(2937, 'Product', 'index', 1, 1),
(2938, 'Product', 'view', 1, 1),
(2939, 'Product', 'create', 1, 1),
(2940, 'Product', 'update', 1, 1),
(2941, 'Product', 'delete', 1, 1),
(2942, 'Product', 'delete-column', 1, 1),
(2943, 'Product', 'export-excel', 1, 1),
(2944, 'Product', 'export-pdf', 1, 1),
(2945, 'Product', 'edit-qty', 1, 1),
(2946, 'Product', 'update-stocks-quantity', 1, 1),
(2947, 'Product', 'get-product-information', 1, 1),
(2948, 'Product', 'update-stock-quantity', 1, 1),
(2949, 'Product', 'index', 2, 1),
(2950, 'Product', 'view', 2, 1),
(2951, 'Product', 'create', 2, 1),
(2952, 'Product', 'update', 2, 1),
(2953, 'Product', 'delete', 2, 1),
(2954, 'Product', 'delete-column', 2, 1),
(2955, 'Product', 'export-excel', 2, 1),
(2956, 'Product', 'export-pdf', 2, 1),
(2957, 'Product', 'edit-qty', 2, 1),
(2958, 'Product', 'update-stocks-quantity', 2, 1),
(2959, 'Product', 'get-product-information', 2, 1),
(2960, 'Product', 'update-stock-quantity', 2, 1),
(2971, 'PaymentStatus', 'index', 2, 1),
(2972, 'PaymentStatus', 'view', 2, 1),
(2973, 'PaymentStatus', 'create', 2, 1),
(2974, 'PaymentStatus', 'update', 2, 1),
(2975, 'PaymentStatus', 'delete', 2, 1),
(2976, 'PaymentStatus', 'delete-column', 2, 1),
(2977, 'PaymentStatus', 'export-excel', 2, 1),
(2978, 'PaymentStatus', 'export-pdf', 2, 1),
(2979, 'ProductNotificationRecipient', 'index', 1, 1),
(2980, 'ProductNotificationRecipient', 'view', 1, 1),
(2981, 'ProductNotificationRecipient', 'create', 1, 1),
(2982, 'ProductNotificationRecipient', 'new', 1, 1),
(2983, 'ProductNotificationRecipient', 'update', 1, 1),
(2984, 'ProductNotificationRecipient', 'edit', 1, 1),
(2985, 'ProductNotificationRecipient', 'delete', 1, 1),
(2986, 'ProductNotificationRecipient', 'delete-column', 1, 1),
(2987, 'ProductNotificationRecipient', 'export-excel', 1, 1),
(2988, 'ProductNotificationRecipient', 'export-pdf', 1, 1),
(2989, 'ProductNotificationRecipient', 'index', 2, 1),
(2990, 'ProductNotificationRecipient', 'view', 2, 1),
(2991, 'ProductNotificationRecipient', 'create', 2, 1),
(2992, 'ProductNotificationRecipient', 'new', 2, 1),
(2993, 'ProductNotificationRecipient', 'update', 2, 1),
(2994, 'ProductNotificationRecipient', 'edit', 2, 1),
(2995, 'ProductNotificationRecipient', 'delete', 2, 1),
(2996, 'ProductNotificationRecipient', 'delete-column', 2, 1),
(2997, 'ProductNotificationRecipient', 'export-excel', 2, 1),
(2998, 'ProductNotificationRecipient', 'export-pdf', 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`);

--
-- Indexes for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `type` (`type`),
  ADD KEY `rule_name` (`rule_name`);

--
-- Indexes for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indexes for table `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `car_information`
--
ALTER TABLE `car_information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designated_position`
--
ALTER TABLE `designated_position`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gst`
--
ALTER TABLE `gst`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_detail`
--
ALTER TABLE `invoice_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `module_access`
--
ALTER TABLE `module_access`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_status`
--
ALTER TABLE `payment_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_type`
--
ALTER TABLE `payment_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payroll`
--
ALTER TABLE `payroll`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_level`
--
ALTER TABLE `product_level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_notification_recipient`
--
ALTER TABLE `product_notification_recipient`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotation`
--
ALTER TABLE `quotation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotation_detail`
--
ALTER TABLE `quotation_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `race`
--
ALTER TABLE `race`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_category`
--
ALTER TABLE `service_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_group`
--
ALTER TABLE `staff_group`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `terms_and_conditions`
--
ALTER TABLE `terms_and_conditions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_permission`
--
ALTER TABLE `user_permission`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `car_information`
--
ALTER TABLE `car_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `designated_position`
--
ALTER TABLE `designated_position`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `gst`
--
ALTER TABLE `gst`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `invoice_detail`
--
ALTER TABLE `invoice_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `module_access`
--
ALTER TABLE `module_access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `payment_status`
--
ALTER TABLE `payment_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `payment_type`
--
ALTER TABLE `payment_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `payroll`
--
ALTER TABLE `payroll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `product_level`
--
ALTER TABLE `product_level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `product_notification_recipient`
--
ALTER TABLE `product_notification_recipient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `quotation`
--
ALTER TABLE `quotation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `quotation_detail`
--
ALTER TABLE `quotation_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `race`
--
ALTER TABLE `race`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `service_category`
--
ALTER TABLE `service_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `staff_group`
--
ALTER TABLE `staff_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `terms_and_conditions`
--
ALTER TABLE `terms_and_conditions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user_permission`
--
ALTER TABLE `user_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2999;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`);

--
-- Constraints for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`);

--
-- Constraints for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
