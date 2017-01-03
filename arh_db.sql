-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2017 at 12:04 PM
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
  `id` int(11) NOT NULL,
  `item_name` varchar(50) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `created_at` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `auth_assignment`
--

INSERT INTO `auth_assignment` (`id`, `item_name`, `user_id`, `created_at`) VALUES
(1, 'developer', '1', 1),
(2, 'admin', '5', 1482928719);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

CREATE TABLE `auth_item` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `type` int(10) NOT NULL,
  `description` text NOT NULL,
  `rule_name` varchar(50) NOT NULL,
  `data` text NOT NULL,
  `created_at` int(10) NOT NULL,
  `updated_at` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `id` int(11) NOT NULL,
  `parent` varchar(50) NOT NULL,
  `child` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

CREATE TABLE `auth_rule` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `data` text NOT NULL,
  `created_at` int(10) NOT NULL,
  `updated_at` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `contact_no` varchar(50) NOT NULL,
  `status` int(5) NOT NULL,
  `created_at` date NOT NULL,
  `created_by` int(10) NOT NULL,
  `updated_at` date NOT NULL,
  `updated_by` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`id`, `code`, `name`, `address`, `contact_no`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'arh-001', 'Singapore', 'Kallang way singapore', '09087894561', 1, '2017-01-03', 1, '2017-01-03', 1),
(2, 'arh-002', 'Philippines', 'BPI Buendia Center Makati Ave. Makati City', '09957896541', 1, '2017-01-03', 1, '2017-01-03', 1);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category`) VALUES
(1, 'Foods'),
(3, 'Beverages'),
(7, 'Clothes'),
(8, 'Appliances');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `ic` varchar(50) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `race` varchar(50) NOT NULL,
  `carplate` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `hanphone_no` varchar(50) NOT NULL,
  `office_no` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `make` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `tyre_size` varchar(50) NOT NULL,
  `batteries` varchar(50) NOT NULL,
  `belt` varchar(50) NOT NULL,
  `is_blacklist` tinyint(1) NOT NULL,
  `is_member` varchar(10) NOT NULL,
  `points` int(10) NOT NULL,
  `member_expiry` date NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(10) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `ic`, `fullname`, `race`, `carplate`, `address`, `hanphone_no`, `office_no`, `email`, `make`, `model`, `tyre_size`, `batteries`, `belt`, `is_blacklist`, `is_member`, `points`, `member_expiry`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, '', 'Jose Czar Yanga', 'Filipino', 'JCY-028', '148 Sanchez street manggahan commonwealth quezon city', '9515747', '09959575415', 'jcyanga412060@gmail.com', 'red', 'rolls royce', '2 seaters', 'motolite', 'pumbelt', 0, '1', 100, '2017-01-14', 1, '2016-12-14 18:41:00', 1, '2016-12-14 18:41:00', 1),
(4, '', 'mary gracielle samonte', 'Filipino', 'bot-602', '123 bagong barrio caloocan city', '9515747', '09959575415', 'mariagraciasamonte@yahoo.com', 'white', 'ferrari', '6x2x3', 'motolite', 'belt', 0, '0', 1000, '0000-00-00', 1, '2016-12-16 04:18:11', 0, '2016-12-16 04:18:11', 0),
(7, 'phi', 'Jaybee Lamsin', 'filipino', 'DCE-017', 'east avenue medical center', '9515747', '09987894565', 'dice17@yahoo.com', 'Red', 'Mitsubishi GT-X', '2x3x4', 'Motolite', 'Pumbelt', 0, '0', 500, '2017-01-06', 1, '2016-12-27 07:47:10', 1, '2016-12-27 07:47:10', 0);

-- --------------------------------------------------------

--
-- Table structure for table `gst`
--

CREATE TABLE `gst` (
  `id` int(11) NOT NULL,
  `gst` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gst`
--

INSERT INTO `gst` (`id`, `gst`) VALUES
(1, '7%');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `product_id` int(5) NOT NULL,
  `supplier_id` int(5) NOT NULL,
  `quantity` int(50) NOT NULL,
  `cost_price` double NOT NULL,
  `selling_price` double NOT NULL,
  `date_imported` date NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` date NOT NULL,
  `created_by` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `product_id`, `supplier_id`, `quantity`, `cost_price`, `selling_price`, `date_imported`, `status`, `created_at`, `created_by`) VALUES
(1, 3, 4, 10, 1000, 1500, '0000-00-00', 0, '0000-00-00', 0),
(2, 4, 5, 1000, 5000, 7500, '2016-12-22', 1, '2016-12-22', 1),
(3, 5, 5, 10, 5000, 10000, '2016-12-22', 1, '2016-12-22', 1),
(4, 8, 4, 100, 1000, 2000, '2016-12-22', 1, '2016-12-22', 1),
(5, 14, 4, 50, 5000, 6500, '2016-12-22', 1, '2016-12-22', 1),
(6, 7, 4, 10, 5, 7, '2016-12-29', 0, '2016-12-29', 1),
(7, 2000, 4, 150, 1000, 2000, '2016-12-29', 0, '2016-12-29', 1),
(8, 100, 5, 50, 75, 100, '2016-12-29', 0, '2016-12-29', 1),
(9, 150, 5, 100, 120, 150, '2016-12-29', 0, '2016-12-29', 1),
(10, 12, 4, 100, 10, 12, '2016-12-29', 0, '2016-12-29', 1),
(11, 9, 4, 10, 7, 9, '2016-12-29', 0, '2016-12-29', 1),
(12, 7, 4, 10, 6, 7, '2016-12-29', 0, '2016-12-29', 1),
(13, 6, 6, 100, 10, 11, '2016-12-29', 0, '2016-12-29', 1),
(14, 13, 6, 50, 25, 35, '2016-12-29', 0, '2016-12-29', 1),
(15, 13, 6, 40, 400, 500, '2016-12-29', 0, '2016-12-29', 1),
(16, 8, 6, 75, 750, 850, '2016-12-29', 0, '2016-12-29', 1),
(17, 10, 5, 1, 1, 1, '2016-12-29', 0, '2016-12-29', 1),
(18, 2, 5, 2, 2, 2, '2016-12-29', 0, '2016-12-29', 1),
(19, 10, 5, 1, 1, 1, '2016-12-29', 0, '2016-12-29', 1),
(20, 13, 5, 1, 1, 1, '2016-12-29', 0, '2016-12-29', 1),
(21, 16, 4, 123, 213, 123, '2016-12-29', 0, '2016-12-29', 1),
(22, 11, 5, 123, 12, 213, '2016-12-29', 0, '2016-12-29', 1),
(23, 14, 6, 123, 213, 12, '2016-12-29', 0, '2016-12-29', 1),
(24, 5, 6, 12, 12, 21, '2016-12-29', 0, '2016-12-29', 1),
(25, 7, 6, 23, 2323, 2323, '2016-12-29', 0, '2016-12-29', 1);

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
('m170103_072328_create_quotation_subtotal_table', 1483429651);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` int(11) NOT NULL,
  `modules` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `modules`) VALUES
(1, 'Dashboard Module'),
(4, 'Customer Module'),
(5, 'Role Module'),
(6, 'Category Module'),
(8, 'User Module');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `product_code` varchar(50) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `product_image` varchar(50) NOT NULL,
  `unit_of_measure` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `category_id` int(5) NOT NULL,
  `created_at` date NOT NULL,
  `created_by` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `product_code`, `product_name`, `product_image`, `unit_of_measure`, `status`, `category_id`, `created_at`, `created_by`) VALUES
(1, 'prod_001', 'piatos', 'piatos.png', 'grams', 1, 1, '2016-12-21', 1),
(2, 'prod_002', 'nova', 'nova.png', 'grams', 1, 1, '2016-12-21', 1),
(3, 'prod_003', 'san miguel beer', 'smb.png', 'liters', 1, 2, '2016-12-21', 1),
(4, 'prod_004', 'cervesa negra', 'cervesa.png', 'liters', 1, 2, '2016-12-21', 1),
(5, 'prod_005', 'polo shirt', 'polo.png', 'Medium', 1, 3, '2016-12-21', 1),
(6, 'prod_006', 'white shirt', 'shirt.png', 'Small', 1, 3, '2016-12-21', 1),
(7, 'prod-007', 'v-cut', 'default.png', 'grams', 1, 1, '2016-12-21', 1),
(8, 'prod-008', 'black label', 'default.png', 'liters', 1, 3, '2016-12-21', 1),
(9, 'prod-009', 'sando', 'default.png', 'Large', 1, 4, '2016-12-21', 1),
(10, 'prod-010', 'tortillos', 'default.png', 'grams', 1, 1, '2016-12-21', 1),
(11, 'prod-011', 'emperador', 'default.png', 'liters', 1, 3, '2016-12-21', 1),
(12, 'prod-012', 'polo', 'default.png', 'small', 1, 4, '2016-12-21', 1),
(13, 'prod-013', 'mang juan', 'default.png', 'grams', 1, 1, '2016-12-21', 1),
(14, 'prod-014', 'tanduay', 'default.png', 'liters', 1, 3, '2016-12-21', 1),
(15, 'prod-015', 'pantalon', '', 'long', 1, 4, '2016-12-21', 1),
(16, 'prod-016', 'kenny rogers', '', 'medium', 1, 1, '2016-12-21', 1);

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
  `type` varchar(50) NOT NULL,
  `no_of_services` int(10) NOT NULL,
  `no_of_parts` int(10) NOT NULL,
  `grand_total` double NOT NULL,
  `remarks` text NOT NULL,
  `created_at` date NOT NULL,
  `created_by` int(10) NOT NULL,
  `updated_at` date NOT NULL,
  `updated_by` int(10) NOT NULL,
  `delete` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `quotation_subtotal`
--

CREATE TABLE `quotation_subtotal` (
  `id` int(11) NOT NULL,
  `quotation_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `qty` int(10) NOT NULL,
  `price` double NOT NULL,
  `subTotal` double NOT NULL,
  `type` int(5) NOT NULL,
  `created_at` date NOT NULL,
  `created_by` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `role`) VALUES
(1, 'developer'),
(2, 'admin'),
(3, 'staff'),
(4, 'customer');

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
(1, 1, 'Normal General Servicing', 'Servicing for Part 5', 80, 1, '2017-01-03', 1, '2017-01-03', 1),
(2, 1, 'Extreme General Servicing', 'Servicing for Part 6', 110, 1, '2017-01-03', 1, '2017-01-03', 1),
(3, 2, 'Normal General Servicing', 'Servicing for Part 6', 220, 1, '2017-01-03', 1, '2017-01-03', 1),
(5, 2, 'Extreme General Servicing', 'Servicing for Part 6', 120, 1, '2017-01-03', 1, '2017-01-03', 1);

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
(1, 'Contract', 'Service for Contract', 1, '2017-01-03', 1, '2017-01-03', 1),
(2, 'Ad Hoc', ' Service for Ad Hoc', 1, '2017-01-03', 1, '2017-01-03', 1);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `supplier_code` varchar(50) NOT NULL,
  `supplier_name` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `contact_number` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `supplier_code`, `supplier_name`, `address`, `contact_number`) VALUES
(4, 'supp-0001', 'San Miguel Corporation', '123 San Miguel Ave. Ortigas Center Pasig City', 4323556),
(5, 'supp-0002', 'Ace Hardware', '3rd floor Glorietta Mall Makati City', 2147483647),
(6, 'supp-010', 'FirstCom Solutions', '27th floor BPI Buendia Center Makati Ave.', 9514263);

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
(1, 1, 2, 20, 'JC Yanga Jr', 'jcyanga', 'password', '$2y$13$KLYNdyN9n.CXY4uELu9Td.6LJ1BoXrXQY0dmrnb9HUMegb1dPw.YK', '', 'jcyanga28@yahoo.com', '', 'R5BJVsB83hg7xshurVUaXb6qYn4HrFi8', 1, '2016-12-28 20:11:00', '2016-12-28 20:15:00', 0, '2016-12-28 20:20:00', 0, 0),
(3, 2, 2, 20, 'jose czar yanga', 'admin', '', '$2y$13$eFUYWik87rrQA7vk9m10IOFXOf5/ZPGXLxGpFYnvGBfd74eBBClyW', '', 'jcyanga412060@gmail.com', '', '7w_3S8S4z9LY6VZKfCzCVWRSQQJAEdz6', 1, '0000-00-00 00:00:00', '2016-12-28 20:29:32', 1, '0000-00-00 00:00:00', 0, 0),
(4, 3, 2, 20, 'gracielle samonte', 'mariagracia', '', '$2y$13$3G6MliSJcoQG1J.G2n/2n.5x0Aigc6ZNd5nJG7sXO1QcF7JEz.gdS', '', 'mariagracia@yahoo.com', '', 'PgXtxT0pGLD4NgEOMIEYwbQ8HTAf_voC', 1, '0000-00-00 00:00:00', '2016-12-28 20:35:30', 1, '0000-00-00 00:00:00', 0, 0),
(5, 4, 2, 20, 'mark legazpi', 'marklegazpi01', '', '$2y$13$Tyd6/WyBVRoZ3YLxsPUf0eeeJCERw7gBcGrCawVgL/3w3b8GQJUaa', '', 'marklegazpi@yahoo.com', '', '2_rnP_5ykKIpTXAPdJlunIkH6WDhVkDT', 1, '0000-00-00 00:00:00', '2017-01-03 13:24:17', 1, '0000-00-00 00:00:00', 0, 0),
(6, 1, 1, 20, 'test', 'test123', '', '$2y$13$D55YSKtgO6t3v6s5NiUcc.uAGy186y3Qtqns78r4Tn1Co4cXKqhCK', '', 'test@gmail.com', '', 'uVstnHrnUnczsuD2aGNYF5XRTXYy8Bia', 1, '0000-00-00 00:00:00', '2017-01-03 13:25:58', 1, '0000-00-00 00:00:00', 0, 0),
(7, 1, 1, 20, 'test2', 'test2', '', '$2y$13$qWP686cxXBpZXrHPS0llsuyG943lGXo3whayWwHt90axusz8YGhUG', '', 'test2@yahoo.com', '', '9llNGkK9_93euoiJE05jNbN5xNMZN041', 1, '0000-00-00 00:00:00', '2017-01-03 13:49:56', 1, '0000-00-00 00:00:00', 0, 0),
(8, 4, 1, 20, 'test3', 'test3', '', '$2y$13$MTILA1yYuwS1TEDMlapj7u383kyLMtN.Qx1iMRf.n4jpNpoXpo54O', '', 'test3@yahoo.com', '', 'WY-5-AQVNiatTzgmmUvZOTF4MooIqzhv', 1, '0000-00-00 00:00:00', '2017-01-03 13:50:25', 1, '0000-00-00 00:00:00', 0, 0),
(9, 1, 1, 20, 'test4', 'test4', '', '$2y$13$XPONNjHNglINzCGnBy19h.W3kcfR70gnSPnFDwWm6rJ64TQfG5f0e', '', 'test4@ymail.com', '', '863OffnV8tIAnqL0Epr-k__2gjL-AM1w', 1, '0000-00-00 00:00:00', '2017-01-03 13:53:35', 1, '0000-00-00 00:00:00', 0, 0),
(10, 1, 1, 20, 'JB Lamsin', 'asd', '', '$2y$13$y0VLb/6xMKFWmfmhTFzjzODibleIg5mfwX3fdkXw1uXVqnmAFJWlO', '', 'test7@yahoo.com', '', 'EHQOXm0tWm1CsECKVx9DrzU2Nme5vj5g', 1, '0000-00-00 00:00:00', '2017-01-03 14:32:07', 1, '0000-00-00 00:00:00', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_permission`
--

CREATE TABLE `user_permission` (
  `id` int(11) NOT NULL,
  `controller` varchar(50) NOT NULL,
  `action` varchar(50) NOT NULL,
  `role_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_permission`
--

INSERT INTO `user_permission` (`id`, `controller`, `action`, `role_id`) VALUES
(1, 'Modules', 'index', 1),
(2, 'Modules', 'view', 1),
(3, 'Modules', 'create', 1),
(4, 'Modules', 'update', 1),
(5, 'Modules', 'delete', 1),
(6, 'Modules', 'delete-column', 1),
(7, 'Modules', 'export-excel', 1),
(8, 'Modules', 'export-pdf', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
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
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotation`
--
ALTER TABLE `quotation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotation_subtotal`
--
ALTER TABLE `quotation_subtotal`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
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
-- AUTO_INCREMENT for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `auth_item`
--
ALTER TABLE `auth_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `auth_rule`
--
ALTER TABLE `auth_rule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `gst`
--
ALTER TABLE `gst`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `quotation`
--
ALTER TABLE `quotation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `quotation_subtotal`
--
ALTER TABLE `quotation_subtotal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `service_category`
--
ALTER TABLE `service_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `user_permission`
--
ALTER TABLE `user_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;