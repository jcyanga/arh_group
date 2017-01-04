-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2017 at 12:13 PM
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
(1, 'developer', '1', 123456),
(2, 'admin', '2', 1483521785),
(4, 'staff', '3', 1483524639);

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
(1, 'BRANCH-2017-89327', 'FCS-Singapore', 'Kallang way singapore', '09497894561', 1, '2017-01-04', 1, '2017-01-04', 1),
(2, 'BRANCH-2017-25310', 'FCS-Philippines', '27th floor, BPI Buendia Center', '09991234567', 1, '2017-01-04', 1, '2017-01-04', 1);

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
(1, 'body'),
(2, 'doors'),
(3, 'windows'),
(4, 'audio/video devices'),
(5, 'cameras'),
(6, 'charging system'),
(7, 'electrical supply system'),
(8, 'gauges and meters'),
(9, 'ignition electronic system'),
(10, 'lighting and signaling system'),
(11, 'sensors'),
(12, 'starting system');

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
(1, 1, 1, 10, 1000, 1200, '2017-01-04', 0, '2017-01-04', 1),
(2, 4, 1, 100, 500, 700, '2017-01-04', 0, '2017-01-04', 1),
(3, 3, 1, 20, 1500, 1800, '2017-01-04', 0, '2017-01-04', 1),
(4, 2, 1, 10, 900, 1000, '2017-01-04', 0, '2017-01-04', 1);

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
(2, 'quotation module'),
(3, 'invoice module'),
(4, 'stocks module'),
(5, 'service-category module'),
(6, 'services module'),
(7, 'parts-category module'),
(8, 'parts module'),
(9, 'parts-supplier module'),
(10, 'parts-inventory module'),
(11, 'branch module'),
(12, 'Customer Module'),
(13, 'User-Role Module'),
(14, 'Modules List Module'),
(15, 'User-Permission Module'),
(16, 'User Module');

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
(1, 'PARTS-2017-93490', 'bonnet/hood', '4.jpg', 'big', 1, 1, '2017-01-04', 1),
(2, 'PARTS-2017-44268', 'bumper', 'american-express.png', 'medium', 1, 1, '2017-01-04', 1),
(3, 'PARTS-2017-90457', 'cowl screen', 'mastercard.png', 'small', 1, 1, '2017-01-04', 1),
(4, 'PARTS-2017-80694', 'decklid', 'forward_enabled.png', 'medium', 1, 1, '2017-01-04', 1),
(5, 'PARTS-2017-09315', 'fascia', '', 'small', 1, 1, '2017-01-04', 1),
(6, 'PARTS-2017-31812', 'Front Right Outer door handles', 'sprite-skin-flat.png', 'small', 1, 2, '2017-01-04', 1),
(7, 'PARTS-2017-99031', 'Front Left Side Outer door handles', '1.png', 'medium', 1, 2, '2017-01-04', 1),
(8, 'PARTS-2017-86564', 'Rear Right Side Outer door handles', 'picture-2.jpg', 'small', 1, 2, '2017-01-04', 1),
(9, 'PARTS-2017-84942', 'Rear Left Side Outer door handles', 'prod3.jpg', 'big', 1, 2, '2017-01-04', 1),
(10, 'PARTS-2017-28295', 'Front Right Side Inner door handles', 'prod5.jpg', 'small', 1, 2, '2017-01-04', 1),
(11, 'PARTS-2017-93813', 'Glass', 'sort_both.png', 'pieces', 1, 3, '2017-01-04', 1),
(12, 'PARTS-2017-99275', 'Front Right Side Door Glass', 'data.png', 'pieces', 1, 3, '2017-01-04', 1),
(13, 'PARTS-2017-24204', 'Front Left Side Door Glass', 'prod2.jpg', 'pieces', 1, 3, '2017-01-04', 1),
(14, 'PARTS-2017-81929', 'Rear Right Side Door Glass', 'data.png', 'pieces', 1, 3, '2017-01-04', 1),
(15, 'PARTS-2017-85939', 'Rear Left Side Door Glass', '', 'pieces', 1, 3, '2017-01-04', 1),
(16, 'PARTS-2017-59390', 'Antenna assembly ', 'back_disabled.png', 'meters', 1, 4, '2017-01-04', 1),
(17, 'PARTS-2017-25824', 'Radio and media player', 'picture-2.jpg', 'meters', 1, 4, '2017-01-04', 1),
(18, 'PARTS-2017-47125', 'Speaker', 'picture2.jpg', 'pieces', 1, 4, '2017-01-04', 1),
(19, 'PARTS-2017-93699', 'Backup camera', 'sort_asc_disabled.png', 'pieces', 1, 5, '2017-01-04', 1),
(20, 'PARTS-2017-18750', 'Dashcam', 'sort_desc_disabled.png', 'pieces', 1, 5, '2017-01-04', 1),
(21, 'PARTS-2017-70885', 'Alternator', 'sprite-skin-simple.png', 'volts', 1, 6, '2017-01-04', 1),
(22, 'PARTS-2017-32538', 'Battery', 'sprite-skin-simple.png', 'volts', 1, 7, '2017-01-04', 1),
(23, 'PARTS-2017-61216', 'Ammeter', 'sprite-skin-flat.png', 'long', 1, 8, '2017-01-04', 1);

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
(3, 'staff');

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
(1, 1, 'Air Conditioning', 'Maintain a comfortable temperature for you and your vehicle', 150, 1, '2017-01-04', 1, '2017-01-04', 1),
(2, 1, 'Brake-system repair', 'Feel confident in your vehicle''s stopping power with regular brake checks.', 200, 1, '2017-01-04', 1, '2017-01-04', 1),
(3, 1, 'Fluid-exchange services', 'A vehicle''s fluids must be maintained for it to run properly.', 300, 1, '2017-01-04', 1, '2017-01-04', 1),
(4, 1, 'Oil, Lube & Filter', 'Drive smoothly by maintaining your vehicle''s oil.', 299, 1, '2017-01-04', 1, '2017-01-04', 1),
(5, 1, 'Batteries', 'he performance of the engine, alternator, and secondary electrical systems depend on the battery.', 500, 1, '2017-01-04', 1, '2017-01-04', 1),
(6, 1, 'Check-engine light', 'Keep your ignition, fuel, and emission-control systems doing what they should by maintaining your engine diagnostics.', 750, 1, '2017-01-04', 1, '2017-01-04', 1),
(7, 1, 'Heating & Cooling System', 'Maintain a comfortable temperature for you and your vehicle.', 350, 1, '2017-01-04', 1, '2017-01-04', 1),
(8, 1, 'Steering & Suspension', 'Experience a smooth, controlled ride with a properly functioning suspension system.', 150, 1, '2017-01-04', 1, '2017-01-04', 1),
(9, 1, 'Belts & Hoses', 'Avoid breaking down in your vehicle by maintaining its belts and hoses.', 200, 1, '2017-01-04', 1, '2017-01-04', 1),
(10, 1, 'Mufflers & Exhaust', 'Failing an emissions test is usually the fault of either the muffler or the exhaust system.', 450, 1, '2017-01-04', 1, '2017-01-04', 1),
(11, 1, 'Tune-Up', 'Help your vehicle last longer by scheduling regular tune-ups.', 499, 1, '2017-01-04', 1, '2017-01-04', 1),
(12, 2, 'Tire installation', 'Proper installation enables tires to function fully and correctly.', 299, 1, '2017-01-04', 1, '2017-01-04', 1),
(13, 2, 'Wheel Alignment', 'Proper wheel alignment helps you maintain control of your car.', 99, 1, '2017-01-04', 1, '2017-01-04', 1);

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
(1, 'Automotive Services', 'All car-parts services aside tire services', 1, '2017-01-04', 1, '2017-01-04', 1),
(2, 'Tire services', 'all tire services aside car parts services', 1, '2017-01-04', 1, '2017-01-04', 1);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `supplier_code` varchar(50) NOT NULL,
  `supplier_name` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `contact_number` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `supplier_code`, `supplier_name`, `address`, `contact_number`) VALUES
(1, 'SUPPLIERS-2017-73680', ' SM Oil Seal Parts Center', '1044 G. Masangkay Street Manila, 1006 Metro Manila ', '02-2447804'),
(2, 'SUPPLIERS-2017-77059', 'Cabasal Trading', '649 Evangelista Street Manila, Metro Manila', '09097894561'),
(3, 'SUPPLIERS-2017-72327', 'A-1 Auto Supply', 'G/F, Ina Ng Awa Building, 1064 C. M. Recto Avenue Manila, 1000 Metro Manila ', '02-2447353 '),
(4, 'SUPPLIERS-2017-75671', 'Jcsc Enterprises', '944 Gandara Street Manila, Metro Manila ', '09087894561'),
(5, 'SUPPLIERS-2017-48286', 'Autowide Automotive CTR', ' 1114 Arlegui Street Manila, Metro Manila Phone number', '09097894561'),
(6, 'SUPPLIERS-2017-00828', 'Ng, Tin Si Auto Parts and Supplies', '1114 Artegui Street Manila, 1000 Metro Manila', '02-7339197'),
(7, 'SUPPLIERS-2017-54497', 'Joaquin’s Auto Supply', '753 Gandara Street Manila, 1100 Metro Manila ', '02-7337441 '),
(8, 'SUPPLIERS-2017-58915', 'Silicon Electrical Supply', '678 Evangelista Street Manila, Metro Manila', '02-7338341'),
(9, 'SUPPLIERS-2017-94490', ' Commander Auto Supply', '408 C M Recto Avenue Manila, 1000 Metro Manila', '02-2450581'),
(10, 'SUPPLIERS-2017-94168', ' Giap Gue Second Auto Supply', '920 Gandara Street Manila, 1000 Metro Manila', '02-2441895 '),
(11, 'SUPPLIERS-2017-50875', ' Jm Auto Parts & General Merchandise', ' 1053 Pgil Street Manila, Metro Manila Phone number', '09981234567');

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
(1, 1, 2, 20, 'Jose Czar Yanga', 'jcyanga28', 'password', '$2y$13$KLYNdyN9n.CXY4uELu9Td.6LJ1BoXrXQY0dmrnb9HUMegb1dPw.YK', '', 'jcyanga28@yahoo.com', 'user.png', 'R5BJVsB83hg7xshurVUaXb6qYn4HrFi8', 1, '2017-01-04 16:40:00', '2017-01-04 16:40:00', 1, '2017-01-04 16:40:00', 1, 0),
(2, 2, 2, 20, 'administrator', 'admin', '', '$2y$13$98.o8NdkBbhzY1ELvvHVdelGcvB3U2zSTCoFD4N5M/f9JOjBAe3uG', '', 'admin@gmail.com', '', 'viyVZjUz2hjXiClcTalZNwYwGmytOTtU', 1, '0000-00-00 00:00:00', '2017-01-04 18:09:39', 1, '0000-00-00 00:00:00', 0, 0),
(3, 3, 2, 20, 'staffing', 'staff123', '', '$2y$13$cHflrvsu1MhlC7d827xx2uo4v3iz04lz6q2J0lMnSI/6JWTihS49i', '', 'staff123@gmail.com', '', 'D5oLLn5HQ3tEYrQfBM1Li6kB_hgSyBIN', 1, '0000-00-00 00:00:00', '2017-01-04 18:10:39', 1, '0000-00-00 00:00:00', 0, 0);

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
(1, 'Branch', 'index', 1),
(2, 'Branch', 'view', 1),
(3, 'Branch', 'create', 1),
(4, 'Branch', 'update', 1),
(5, 'Branch', 'delete', 1),
(6, 'Branch', 'delete-column', 1),
(7, 'Branch', 'export-excel', 1),
(8, 'Branch', 'export-pdf', 1),
(9, 'Category', 'index', 1),
(10, 'Category', 'view', 1),
(11, 'Category', 'create', 1),
(12, 'Category', 'update', 1),
(13, 'Category', 'delete', 1),
(14, 'Category', 'delete-column', 1),
(15, 'Category', 'export-excel', 1),
(16, 'Category', 'export-pdf', 1),
(17, 'Customer', 'index', 1),
(18, 'Customer', 'view', 1),
(19, 'Customer', 'create', 1),
(20, 'Customer', 'update', 1),
(21, 'Customer', 'delete', 1),
(22, 'Customer', 'delete-column', 1),
(23, 'Customer', 'export-excel', 1),
(24, 'Customer', 'export-pdf', 1),
(25, 'Gst', 'index', 1),
(26, 'Gst', 'view', 1),
(27, 'Gst', 'create', 1),
(28, 'Gst', 'update', 1),
(29, 'Gst', 'delete', 1),
(30, 'Inventory', 'index', 1),
(31, 'Inventory', 'view', 1),
(32, 'Inventory', 'create', 1),
(33, 'Inventory', 'update', 1),
(34, 'Inventory', 'delete', 1),
(35, 'Inventory', 'delete-column', 1),
(36, 'Inventory', 'export-excel', 1),
(37, 'Inventory', 'export-pdf', 1),
(38, 'Modules', 'index', 1),
(39, 'Modules', 'view', 1),
(40, 'Modules', 'create', 1),
(41, 'Modules', 'update', 1),
(42, 'Modules', 'delete', 1),
(43, 'Modules', 'delete-column', 1),
(44, 'Modules', 'export-excel', 1),
(45, 'Modules', 'export-pdf', 1),
(46, 'Product', 'index', 1),
(47, 'Product', 'view', 1),
(48, 'Product', 'create', 1),
(49, 'Product', 'update', 1),
(50, 'Product', 'delete', 1),
(51, 'Product', 'delete-column', 1),
(52, 'Product', 'export-excel', 1),
(53, 'Product', 'export-pdf', 1),
(54, 'Quotation', 'index', 1),
(55, 'Quotation', 'view', 1),
(56, 'Quotation', 'create', 1),
(57, 'Quotation', 'update', 1),
(58, 'Quotation', 'delete', 1),
(59, 'QuotationSubtotal', 'index', 1),
(60, 'QuotationSubtotal', 'view', 1),
(61, 'QuotationSubtotal', 'create', 1),
(62, 'QuotationSubtotal', 'update', 1),
(63, 'QuotationSubtotal', 'delete', 1),
(64, 'Role', 'index', 1),
(65, 'Role', 'view', 1),
(66, 'Role', 'create', 1),
(67, 'Role', 'update', 1),
(68, 'Role', 'delete', 1),
(69, 'Role', 'delete-column', 1),
(70, 'Role', 'export-excel', 1),
(71, 'Role', 'export-pdf', 1),
(72, 'ServiceCategory', 'index', 1),
(73, 'ServiceCategory', 'view', 1),
(74, 'ServiceCategory', 'create', 1),
(75, 'ServiceCategory', 'update', 1),
(76, 'ServiceCategory', 'delete', 1),
(77, 'ServiceCategory', 'delete-column', 1),
(78, 'ServiceCategory', 'export-excel', 1),
(79, 'ServiceCategory', 'export-pdf', 1),
(80, 'Service', 'index', 1),
(81, 'Service', 'view', 1),
(82, 'Service', 'create', 1),
(83, 'Service', 'update', 1),
(84, 'Service', 'delete', 1),
(85, 'Service', 'delete-column', 1),
(86, 'Service', 'export-excel', 1),
(87, 'Service', 'export-pdf', 1),
(88, 'Site', 'index', 1),
(89, 'Site', 'login', 1),
(90, 'Site', 'logout', 1),
(91, 'Stocks', 'index', 1),
(92, 'Stocks', 'create', 1),
(93, 'Supplier', 'index', 1),
(94, 'Supplier', 'view', 1),
(95, 'Supplier', 'create', 1),
(96, 'Supplier', 'update', 1),
(97, 'Supplier', 'delete', 1),
(98, 'Supplier', 'delete-column', 1),
(99, 'Supplier', 'export-excel', 1),
(100, 'Supplier', 'export-pdf', 1),
(101, 'User', 'index', 1),
(102, 'User', 'view', 1),
(103, 'User', 'create', 1),
(104, 'User', 'update', 1),
(105, 'User', 'delete', 1),
(106, 'User', 'delete-column', 1),
(107, 'User', 'export-excel', 1),
(108, 'User', 'export-pdf', 1),
(109, 'UserPermission', 'index', 1),
(110, 'UserPermission', 'view', 1),
(111, 'UserPermission', 'create', 1),
(112, 'UserPermission', 'update', 1),
(113, 'UserPermission', 'delete', 1),
(114, 'UserPermission', 'set-permission', 1),
(115, 'Branch', 'index', 2),
(116, 'Branch', 'view', 2),
(117, 'Branch', 'create', 2),
(118, 'Branch', 'update', 2),
(119, 'Branch', 'delete', 2),
(120, 'Branch', 'delete-column', 2),
(121, 'Branch', 'export-excel', 2),
(122, 'Branch', 'export-pdf', 2),
(123, 'Category', 'index', 2),
(124, 'Category', 'view', 2),
(125, 'Category', 'create', 2),
(126, 'Category', 'update', 2),
(127, 'Category', 'delete', 2),
(128, 'Category', 'delete-column', 2),
(129, 'Category', 'export-excel', 2),
(130, 'Category', 'export-pdf', 2),
(131, 'Customer', 'index', 2),
(132, 'Customer', 'view', 2),
(133, 'Customer', 'create', 2),
(134, 'Customer', 'update', 2),
(135, 'Customer', 'delete', 2),
(136, 'Customer', 'delete-column', 2),
(137, 'Customer', 'export-excel', 2),
(138, 'Customer', 'export-pdf', 2),
(139, 'Gst', 'index', 2),
(140, 'Gst', 'view', 2),
(141, 'Gst', 'create', 2),
(142, 'Gst', 'update', 2),
(143, 'Gst', 'delete', 2),
(144, 'Inventory', 'index', 2),
(145, 'Inventory', 'view', 2),
(146, 'Inventory', 'create', 2),
(147, 'Inventory', 'update', 2),
(148, 'Inventory', 'delete', 2),
(149, 'Inventory', 'delete-column', 2),
(150, 'Inventory', 'export-excel', 2),
(151, 'Inventory', 'export-pdf', 2),
(152, 'Modules', 'index', 2),
(153, 'Modules', 'view', 2),
(154, 'Modules', 'create', 2),
(155, 'Modules', 'update', 2),
(156, 'Modules', 'delete', 2),
(157, 'Modules', 'delete-column', 2),
(158, 'Modules', 'export-excel', 2),
(159, 'Modules', 'export-pdf', 2),
(160, 'Product', 'index', 2),
(161, 'Product', 'view', 2),
(162, 'Product', 'create', 2),
(163, 'Product', 'update', 2),
(164, 'Product', 'delete', 2),
(165, 'Product', 'delete-column', 2),
(166, 'Product', 'export-excel', 2),
(167, 'Product', 'export-pdf', 2),
(168, 'Quotation', 'index', 2),
(169, 'Quotation', 'view', 2),
(170, 'Quotation', 'create', 2),
(171, 'Quotation', 'update', 2),
(172, 'Quotation', 'delete', 2),
(173, 'QuotationSubtotal', 'index', 2),
(174, 'QuotationSubtotal', 'view', 2),
(175, 'QuotationSubtotal', 'create', 2),
(176, 'QuotationSubtotal', 'update', 2),
(177, 'QuotationSubtotal', 'delete', 2),
(178, 'Role', 'index', 2),
(179, 'Role', 'view', 2),
(180, 'Role', 'create', 2),
(181, 'Role', 'update', 2),
(182, 'Role', 'delete', 2),
(183, 'Role', 'delete-column', 2),
(184, 'Role', 'export-excel', 2),
(185, 'Role', 'export-pdf', 2),
(186, 'ServiceCategory', 'index', 2),
(187, 'ServiceCategory', 'view', 2),
(188, 'ServiceCategory', 'create', 2),
(189, 'ServiceCategory', 'update', 2),
(190, 'ServiceCategory', 'delete', 2),
(191, 'ServiceCategory', 'delete-column', 2),
(192, 'ServiceCategory', 'export-excel', 2),
(193, 'ServiceCategory', 'export-pdf', 2),
(194, 'Service', 'index', 2),
(195, 'Service', 'view', 2),
(196, 'Service', 'create', 2),
(197, 'Service', 'update', 2),
(198, 'Service', 'delete', 2),
(199, 'Service', 'delete-column', 2),
(200, 'Service', 'export-excel', 2),
(201, 'Service', 'export-pdf', 2),
(202, 'Site', 'index', 2),
(203, 'Site', 'login', 2),
(204, 'Site', 'logout', 2),
(205, 'Stocks', 'index', 2),
(206, 'Stocks', 'create', 2),
(207, 'Supplier', 'index', 2),
(208, 'Supplier', 'view', 2),
(209, 'Supplier', 'create', 2),
(210, 'Supplier', 'update', 2),
(211, 'Supplier', 'delete', 2),
(212, 'Supplier', 'delete-column', 2),
(213, 'Supplier', 'export-excel', 2),
(214, 'Supplier', 'export-pdf', 2),
(215, 'User', 'index', 2),
(216, 'User', 'view', 2),
(217, 'User', 'create', 2),
(218, 'User', 'update', 2),
(219, 'User', 'delete', 2),
(220, 'User', 'delete-column', 2),
(221, 'User', 'export-excel', 2),
(222, 'User', 'export-pdf', 2),
(223, 'Customer', 'index', 3),
(224, 'Customer', 'view', 3),
(225, 'Customer', 'create', 3),
(226, 'Customer', 'update', 3),
(227, 'Customer', 'delete', 3),
(228, 'Customer', 'delete-column', 3),
(229, 'Customer', 'export-excel', 3),
(230, 'Customer', 'export-pdf', 3),
(231, 'Quotation', 'index', 3),
(232, 'Quotation', 'view', 3),
(233, 'Quotation', 'create', 3),
(234, 'Quotation', 'update', 3),
(235, 'Quotation', 'delete', 3),
(236, 'QuotationSubtotal', 'index', 3),
(237, 'QuotationSubtotal', 'view', 3),
(238, 'QuotationSubtotal', 'create', 3),
(239, 'QuotationSubtotal', 'update', 3),
(240, 'QuotationSubtotal', 'delete', 3);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `service_category`
--
ALTER TABLE `service_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user_permission`
--
ALTER TABLE `user_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=241;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
