-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 11, 2017 at 11:43 AM
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
('admin', '2', 1483941731),
('developer', '1', 123456789),
('staff', '3', 1483941758);

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
('admin', 1, 'Admin', NULL, NULL, 1483927743, 1483927743),
('developer', 1, 'Developer', NULL, NULL, 1483927743, 1483927743),
('staff', 1, 'Staff', NULL, NULL, 1483927743, 1483927743);

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
(1, 'BRANCH-2017-32021', 'FCS-Singapore', '158 Kallang Way, #03-05, Performance Building, Kal', '+65 6848 4984', 1, '2017-01-08', 1, '2017-01-08', 1),
(2, 'BRANCH-2017-79961', 'FCS-Philippines', '27th floor, BPI Buendia Center, Makati Ave. Makati', '09959575415', 1, '2017-01-10', 1, '2017-01-10', 1);

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
  `remarks` text NOT NULL,
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

INSERT INTO `customer` (`id`, `ic`, `fullname`, `race`, `carplate`, `address`, `hanphone_no`, `office_no`, `email`, `make`, `model`, `remarks`, `is_blacklist`, `is_member`, `points`, `member_expiry`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, '', 'Jose Czar Yanga', 'Filipino', 'JCY-028', '148 Sanchez street manggahan commonwealth quezon city', '9515747', '09959575415', 'jcyanga412060@gmail.com', 'red', 'rolls royce', '', 0, '1', 100, '2017-01-14', 1, '2016-12-14 18:41:00', 1, '2016-12-14 18:41:00', 1),
(4, '', 'mary gracielle samonte', 'Filipino', 'bot-602', '123 bagong barrio caloocan city', '9515747', '09959575415', 'mariagraciasamonte@yahoo.com', 'white', 'ferrari', '', 0, '0', 1000, '0000-00-00', 1, '2016-12-16 04:18:11', 0, '2016-12-16 04:18:11', 0),
(7, 'phi', 'Jaybee Lamsin', 'filipino', 'DCE-017', 'east avenue medical center', '9515747', '09987894565', 'dice17@yahoo.com', 'Red', 'Mitsubishi GT-X', '', 0, '1', 500, '2017-01-06', 1, '2017-01-09 11:01:02', 1, '2017-01-09 11:01:02', 0),
(8, 'ronald20', 'ronald patawaran', 'filipino', 'RND-010', '27th floor bpi buendia center makati city', '09297894561', '9515664', 'ronaldbente@yahoo.com', 'blue', 'Hyundai Accent', '', 0, '1', 10000, '2017-01-11', 1, '2017-01-09 10:56:26', 1, '2017-01-09 10:56:26', 0),
(9, 'jack_lim', 'jack lim', 'Filipino-Chinese', 'JCK-024', 'Blk 1 Lot 2 Mount Carmel Subdivision North Fairview, Quezon City', '9515242', '09087894563', 'jacklim@gmail.com', 'Red', 'Lamborgini', 'Manager of HSBC.', 0, '1', 1000, '2017-01-20', 1, '2017-01-11 05:10:37', 1, '2017-01-11 05:10:37', 0);

-- --------------------------------------------------------

--
-- Table structure for table `gst`
--

CREATE TABLE `gst` (
  `id` int(11) NOT NULL,
  `gst` varchar(10) NOT NULL,
  `branch_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gst`
--

INSERT INTO `gst` (`id`, `gst`, `branch_id`) VALUES
(1, '1.12', 1),
(2, '1.12', 2);

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
(2, 4, 1, 10, 500, 700, '2017-01-04', 0, '2017-01-04', 1),
(3, 3, 1, 0, 1500, 1800, '2017-01-04', 0, '2017-01-04', 1),
(4, 2, 1, 10, 900, 1000, '2017-01-04', 0, '2017-01-04', 1),
(5, 19, 11, 14, 150, 170, '2017-01-08', 0, '2017-01-08', 1),
(6, 11, 6, 30, 250, 275, '2017-01-08', 0, '2017-01-08', 1),
(7, 3, 9, 12, 100, 250, '2017-01-08', 0, '2017-01-08', 1),
(8, 19, 9, 11, 175, 200, '2017-01-08', 0, '2017-01-08', 1),
(9, 16, 11, 7, 99, 110, '2017-01-09', 0, '2017-01-09', 1),
(10, 11, 11, 30, 75, 100, '2017-01-09', 0, '2017-01-09', 1),
(11, 18, 11, 7, 100, 125, '2017-01-09', 0, '2017-01-09', 1);

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
  `remarks` text NOT NULL,
  `created_at` date NOT NULL,
  `created_by` int(10) NOT NULL,
  `updated_at` date NOT NULL,
  `updated_by` int(10) NOT NULL,
  `delete` int(5) NOT NULL,
  `task` int(5) NOT NULL,
  `paid` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `quotation_code`, `invoice_no`, `user_id`, `customer_id`, `branch_id`, `date_issue`, `grand_total`, `remarks`, `created_at`, `created_by`, `updated_at`, `updated_by`, `delete`, `task`, `paid`) VALUES
(1, 'QUO-2017-806431', 'OR-2017-73007', 2, 1, 2, '2017-01-11', 1008, 'god bless us.', '2017-01-11', 1, '2017-01-11', 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_detail`
--

CREATE TABLE `invoice_detail` (
  `id` int(11) NOT NULL,
  `invoice_id` int(10) NOT NULL,
  `service_part_id` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `selling_price` double NOT NULL,
  `subTotal` double NOT NULL,
  `created_at` date NOT NULL,
  `created_by` int(10) NOT NULL,
  `type` int(5) NOT NULL,
  `task` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice_detail`
--

INSERT INTO `invoice_detail` (`id`, `invoice_id`, `service_part_id`, `quantity`, `selling_price`, `subTotal`, `created_at`, `created_by`, `type`, `task`) VALUES
(1, 1, 1, 1, 150, 150, '2017-01-11', 1, 0, 1),
(2, 1, 2, 1, 200, 200, '2017-01-11', 1, 0, 0),
(3, 1, 11, 2, 275, 550, '2017-01-11', 1, 1, 0);

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
('m170111_063217_create_invoice_detail_table', 1484116390);

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
  `quotation_id` int(5) NOT NULL,
  `invoice_id` int(5) NOT NULL,
  `payment_date` date NOT NULL,
  `payment_time` time NOT NULL,
  `amount` double NOT NULL,
  `type` int(5) NOT NULL,
  `status` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `grand_total` double NOT NULL,
  `remarks` text NOT NULL,
  `created_at` date NOT NULL,
  `created_by` int(10) NOT NULL,
  `updated_at` date NOT NULL,
  `updated_by` int(10) NOT NULL,
  `delete` int(5) NOT NULL,
  `task` int(5) NOT NULL,
  `paid` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quotation`
--

INSERT INTO `quotation` (`id`, `quotation_code`, `user_id`, `customer_id`, `branch_id`, `date_issue`, `grand_total`, `remarks`, `created_at`, `created_by`, `updated_at`, `updated_by`, `delete`, `task`, `paid`) VALUES
(1, 'QUO-2017-806431', 2, 1, 2, '2017-01-11', 1008, 'god bless us.', '2017-01-11', 1, '2017-01-11', 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `quotation_detail`
--

CREATE TABLE `quotation_detail` (
  `id` int(11) NOT NULL,
  `quotation_id` int(10) NOT NULL,
  `service_part_id` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `selling_price` double NOT NULL,
  `subTotal` double NOT NULL,
  `created_at` date NOT NULL,
  `created_by` int(10) NOT NULL,
  `type` int(5) NOT NULL,
  `task` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quotation_detail`
--

INSERT INTO `quotation_detail` (`id`, `quotation_id`, `service_part_id`, `quantity`, `selling_price`, `subTotal`, `created_at`, `created_by`, `type`, `task`) VALUES
(1, 1, 1, 1, 150, 150, '2017-01-11', 1, 0, 1),
(2, 1, 2, 1, 200, 200, '2017-01-11', 1, 0, 0),
(3, 1, 11, 2, 275, 550, '2017-01-11', 1, 1, 0);

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
-- Table structure for table `stock_in`
--

CREATE TABLE `stock_in` (
  `id` int(11) NOT NULL,
  `product_id` int(5) NOT NULL,
  `supplier_id` int(5) NOT NULL,
  `quantity` int(50) NOT NULL,
  `cost_price` double NOT NULL,
  `selling_price` double NOT NULL,
  `date_imported` date NOT NULL,
  `time_imported` time NOT NULL,
  `created_at` date NOT NULL,
  `created_by` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stock_in`
--

INSERT INTO `stock_in` (`id`, `product_id`, `supplier_id`, `quantity`, `cost_price`, `selling_price`, `date_imported`, `time_imported`, `created_at`, `created_by`) VALUES
(1, 19, 11, 10, 150, 170, '2017-01-08', '00:00:00', '0000-00-00', 1),
(2, 11, 6, 25, 250, 275, '2017-01-08', '08:14:51', '2017-01-08', 1),
(3, 3, 9, 5, 100, 250, '2017-01-08', '09:17:55', '2017-01-08', 1),
(4, 19, 9, 7, 175, 200, '2017-01-08', '09:17:55', '2017-01-08', 1),
(5, 10, 9, 10, 150, 175, '2017-01-08', '09:17:55', '2017-01-08', 1),
(7, 1, 1, 22, 1000, 1200, '2017-01-08', '09:55:56', '2017-01-08', 1),
(8, 4, 1, 28, 500, 700, '2017-01-08', '09:55:56', '2017-01-08', 1),
(9, 3, 1, 42, 1500, 1800, '2017-01-08', '09:55:56', '2017-01-08', 1),
(10, 2, 1, 36, 900, 1000, '2017-01-08', '09:55:56', '2017-01-08', 1),
(11, 19, 11, 12, 150, 170, '2017-01-08', '09:55:56', '2017-01-08', 1),
(12, 11, 6, 28, 250, 275, '2017-01-08', '09:55:57', '2017-01-08', 1),
(13, 3, 9, 7, 100, 250, '2017-01-08', '09:55:57', '2017-01-08', 1),
(14, 19, 9, 10, 175, 200, '2017-01-08', '09:55:57', '2017-01-08', 1),
(15, 16, 11, 5, 99, 110, '2017-01-09', '12:09:37', '2017-01-09', 1),
(16, 11, 11, 7, 75, 100, '2017-01-09', '12:09:37', '2017-01-09', 1),
(17, 18, 11, 9, 100, 125, '2017-01-09', '12:09:37', '2017-01-09', 1),
(19, 1, 1, 23, 1000, 1200, '2017-01-09', '13:47:14', '2017-01-09', 1),
(20, 4, 1, 30, 500, 700, '2017-01-09', '13:47:14', '2017-01-09', 1),
(21, 3, 1, 42, 1500, 1800, '2017-01-09', '13:47:14', '2017-01-09', 1),
(22, 2, 1, 27, 900, 1000, '2017-01-09', '13:47:14', '2017-01-09', 1),
(23, 19, 11, 14, 150, 170, '2017-01-09', '13:47:15', '2017-01-09', 1),
(24, 11, 6, 32, 250, 275, '2017-01-09', '13:47:15', '2017-01-09', 1),
(25, 3, 9, 12, 100, 250, '2017-01-09', '13:47:15', '2017-01-09', 1),
(26, 19, 9, 11, 175, 200, '2017-01-09', '13:47:15', '2017-01-09', 1),
(27, 16, 11, 7, 99, 110, '2017-01-09', '13:47:15', '2017-01-09', 1),
(28, 11, 11, 10, 75, 100, '2017-01-09', '13:47:15', '2017-01-09', 1),
(29, 1, 1, 23, 1000, 1200, '2017-01-09', '13:50:22', '2017-01-09', 1),
(30, 4, 1, 30, 500, 700, '2017-01-09', '13:50:23', '2017-01-09', 1),
(31, 3, 1, 42, 1500, 1800, '2017-01-09', '13:50:23', '2017-01-09', 1),
(32, 2, 1, 27, 900, 1000, '2017-01-09', '13:50:23', '2017-01-09', 1),
(33, 19, 11, 14, 150, 170, '2017-01-09', '13:50:23', '2017-01-09', 1),
(34, 11, 6, 32, 250, 275, '2017-01-09', '13:50:23', '2017-01-09', 1),
(35, 3, 9, 12, 100, 250, '2017-01-09', '13:50:23', '2017-01-09', 1),
(36, 19, 9, 11, 175, 200, '2017-01-09', '13:50:23', '2017-01-09', 1),
(37, 16, 11, 7, 99, 110, '2017-01-09', '13:50:24', '2017-01-09', 1),
(38, 11, 11, 10, 75, 100, '2017-01-09', '13:50:24', '2017-01-09', 1),
(39, 1, 1, 23, 1000, 1200, '2017-01-09', '13:50:25', '2017-01-09', 1),
(40, 4, 1, 30, 500, 700, '2017-01-09', '13:50:25', '2017-01-09', 1),
(41, 3, 1, 42, 1500, 1800, '2017-01-09', '13:50:25', '2017-01-09', 1),
(42, 2, 1, 27, 900, 1000, '2017-01-09', '13:50:25', '2017-01-09', 1),
(43, 19, 11, 14, 150, 170, '2017-01-09', '13:50:25', '2017-01-09', 1),
(44, 11, 6, 32, 250, 275, '2017-01-09', '13:50:26', '2017-01-09', 1),
(45, 3, 9, 12, 100, 250, '2017-01-09', '13:50:26', '2017-01-09', 1),
(46, 19, 9, 11, 175, 200, '2017-01-09', '13:50:26', '2017-01-09', 1),
(47, 16, 11, 7, 99, 110, '2017-01-09', '13:50:26', '2017-01-09', 1),
(48, 11, 11, 10, 75, 100, '2017-01-09', '13:50:26', '2017-01-09', 1),
(49, 1, 1, 23, 1000, 1200, '2017-01-09', '13:50:43', '2017-01-09', 1),
(50, 4, 1, 30, 500, 700, '2017-01-09', '13:50:43', '2017-01-09', 1),
(51, 3, 1, 42, 1500, 1800, '2017-01-09', '13:50:43', '2017-01-09', 1),
(52, 2, 1, 27, 900, 1000, '2017-01-09', '13:50:43', '2017-01-09', 1),
(53, 19, 11, 14, 150, 170, '2017-01-09', '13:50:44', '2017-01-09', 1),
(54, 11, 6, 32, 250, 275, '2017-01-09', '13:50:44', '2017-01-09', 1),
(55, 3, 9, 12, 100, 250, '2017-01-09', '13:50:44', '2017-01-09', 1),
(56, 19, 9, 11, 175, 200, '2017-01-09', '13:50:44', '2017-01-09', 1),
(57, 16, 11, 7, 99, 110, '2017-01-09', '13:50:45', '2017-01-09', 1),
(58, 11, 11, 10, 75, 100, '2017-01-09', '13:50:45', '2017-01-09', 1);

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
(1, 1, 2, 20, 'Jose Czar L Yanga', 'jcyanga28', 'password', '$2y$13$KLYNdyN9n.CXY4uELu9Td.6LJ1BoXrXQY0dmrnb9HUMegb1dPw.YK', '', 'jcyanga412060@gmail.com', 'user.png', 'R5BJVsB83hg7xshurVUaXb6qYn4HrFi8', 1, '2017-01-09 10:25:00', '2017-01-09 10:25:00', 1, '2017-01-09 10:25:00', 1, 0),
(2, 2, 2, 20, 'administrator', 'admin02', '', '$2y$13$CFVuI8rWieiEpY8l/UE6iufRW5E5iuQG5FFnq.zrHQJEHEzpQ9sDG', '', 'admin02@gmail.com', '', 'zV4R0IdpVy3NPDaGp6HabuE5eroU3i1c', 1, '0000-00-00 00:00:00', '2017-01-09 14:02:11', 1, '0000-00-00 00:00:00', 0, 0),
(3, 3, 2, 20, 'mystaff', 'mystaff02', '', '$2y$13$Nrdp18n8eoOOEMwf97e5Bu4dc1w/I1g2vgkhNAl77m60jruC/m7W.', '', 'mystaff02@gmail.com', '', 'JEp_A3vFmIAsvBoBeUctw4VOHfJpwLGP', 1, '0000-00-00 00:00:00', '2017-01-09 14:02:38', 1, '0000-00-00 00:00:00', 0, 0);

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
(61, 'QuotationSubtotal', 'index', 1),
(62, 'QuotationSubtotal', 'view', 1),
(63, 'QuotationSubtotal', 'create', 1),
(64, 'QuotationSubtotal', 'update', 1),
(65, 'QuotationSubtotal', 'delete', 1),
(66, 'Role', 'index', 1),
(67, 'Role', 'view', 1),
(68, 'Role', 'create', 1),
(69, 'Role', 'update', 1),
(70, 'Role', 'delete', 1),
(71, 'Role', 'delete-column', 1),
(72, 'Role', 'export-excel', 1),
(73, 'Role', 'export-pdf', 1),
(74, 'ServiceCategory', 'index', 1),
(75, 'ServiceCategory', 'view', 1),
(76, 'ServiceCategory', 'create', 1),
(77, 'ServiceCategory', 'update', 1),
(78, 'ServiceCategory', 'delete', 1),
(79, 'ServiceCategory', 'delete-column', 1),
(80, 'ServiceCategory', 'export-excel', 1),
(81, 'ServiceCategory', 'export-pdf', 1),
(82, 'Service', 'index', 1),
(83, 'Service', 'view', 1),
(84, 'Service', 'create', 1),
(85, 'Service', 'update', 1),
(86, 'Service', 'delete', 1),
(87, 'Service', 'delete-column', 1),
(88, 'Service', 'export-excel', 1),
(89, 'Service', 'export-pdf', 1),
(90, 'Site', 'index', 1),
(91, 'Site', 'login', 1),
(92, 'Site', 'logout', 1),
(93, 'Stocks', 'index', 1),
(94, 'Stocks', 'create', 1),
(95, 'Stocks', 'update', 1),
(96, 'Supplier', 'index', 1),
(97, 'Supplier', 'view', 1),
(98, 'Supplier', 'create', 1),
(99, 'Supplier', 'update', 1),
(100, 'Supplier', 'delete', 1),
(101, 'Supplier', 'delete-column', 1),
(102, 'Supplier', 'export-excel', 1),
(103, 'Supplier', 'export-pdf', 1),
(104, 'User', 'index', 1),
(105, 'User', 'view', 1),
(106, 'User', 'create', 1),
(107, 'User', 'update', 1),
(108, 'User', 'delete', 1),
(109, 'User', 'delete-column', 1),
(110, 'User', 'export-excel', 1),
(111, 'User', 'export-pdf', 1),
(118, 'Branch', 'index', 2),
(119, 'Branch', 'view', 2),
(120, 'Branch', 'create', 2),
(121, 'Branch', 'update', 2),
(122, 'Branch', 'delete', 2),
(123, 'Branch', 'delete-column', 2),
(124, 'Branch', 'export-excel', 2),
(125, 'Branch', 'export-pdf', 2),
(126, 'Category', 'index', 2),
(127, 'Category', 'view', 2),
(128, 'Category', 'create', 2),
(129, 'Category', 'update', 2),
(130, 'Category', 'delete', 2),
(131, 'Category', 'delete-column', 2),
(132, 'Category', 'export-excel', 2),
(133, 'Category', 'export-pdf', 2),
(134, 'Customer', 'index', 2),
(135, 'Customer', 'view', 2),
(136, 'Customer', 'create', 2),
(137, 'Customer', 'update', 2),
(138, 'Customer', 'delete', 2),
(139, 'Customer', 'delete-column', 2),
(140, 'Customer', 'export-excel', 2),
(141, 'Customer', 'export-pdf', 2),
(147, 'Inventory', 'index', 2),
(148, 'Inventory', 'view', 2),
(149, 'Inventory', 'create', 2),
(150, 'Inventory', 'update', 2),
(151, 'Inventory', 'delete', 2),
(152, 'Inventory', 'delete-column', 2),
(153, 'Inventory', 'export-excel', 2),
(154, 'Inventory', 'export-pdf', 2),
(155, 'Modules', 'index', 2),
(156, 'Modules', 'view', 2),
(157, 'Modules', 'create', 2),
(158, 'Modules', 'update', 2),
(159, 'Modules', 'delete', 2),
(160, 'Modules', 'delete-column', 2),
(161, 'Modules', 'export-excel', 2),
(162, 'Modules', 'export-pdf', 2),
(163, 'Product', 'index', 2),
(164, 'Product', 'view', 2),
(165, 'Product', 'create', 2),
(166, 'Product', 'update', 2),
(167, 'Product', 'delete', 2),
(168, 'Product', 'delete-column', 2),
(169, 'Product', 'export-excel', 2),
(170, 'Product', 'export-pdf', 2),
(178, 'QuotationSubtotal', 'index', 2),
(179, 'QuotationSubtotal', 'view', 2),
(180, 'QuotationSubtotal', 'create', 2),
(181, 'QuotationSubtotal', 'update', 2),
(182, 'QuotationSubtotal', 'delete', 2),
(183, 'Role', 'index', 2),
(184, 'Role', 'view', 2),
(185, 'Role', 'create', 2),
(186, 'Role', 'update', 2),
(187, 'Role', 'delete', 2),
(188, 'Role', 'delete-column', 2),
(189, 'Role', 'export-excel', 2),
(190, 'Role', 'export-pdf', 2),
(191, 'ServiceCategory', 'index', 2),
(192, 'ServiceCategory', 'view', 2),
(193, 'ServiceCategory', 'create', 2),
(194, 'ServiceCategory', 'update', 2),
(195, 'ServiceCategory', 'delete', 2),
(196, 'ServiceCategory', 'delete-column', 2),
(197, 'ServiceCategory', 'export-excel', 2),
(198, 'ServiceCategory', 'export-pdf', 2),
(199, 'Service', 'index', 2),
(200, 'Service', 'view', 2),
(201, 'Service', 'create', 2),
(202, 'Service', 'update', 2),
(203, 'Service', 'delete', 2),
(204, 'Service', 'delete-column', 2),
(205, 'Service', 'export-excel', 2),
(206, 'Service', 'export-pdf', 2),
(207, 'Site', 'index', 2),
(208, 'Site', 'login', 2),
(209, 'Site', 'logout', 2),
(210, 'Stocks', 'index', 2),
(211, 'Stocks', 'create', 2),
(212, 'Stocks', 'update', 2),
(213, 'Supplier', 'index', 2),
(214, 'Supplier', 'view', 2),
(215, 'Supplier', 'create', 2),
(216, 'Supplier', 'update', 2),
(217, 'Supplier', 'delete', 2),
(218, 'Supplier', 'delete-column', 2),
(219, 'Supplier', 'export-excel', 2),
(220, 'Supplier', 'export-pdf', 2),
(221, 'User', 'index', 2),
(222, 'User', 'view', 2),
(223, 'User', 'create', 2),
(224, 'User', 'update', 2),
(225, 'User', 'delete', 2),
(226, 'User', 'delete-column', 2),
(227, 'User', 'export-excel', 2),
(228, 'User', 'export-pdf', 2),
(242, 'Customer', 'index', 3),
(243, 'Customer', 'view', 3),
(244, 'Customer', 'create', 3),
(245, 'Customer', 'update', 3),
(246, 'Customer', 'delete', 3),
(247, 'Customer', 'delete-column', 3),
(248, 'Customer', 'export-excel', 3),
(249, 'Customer', 'export-pdf', 3),
(250, 'UserPermission', 'index', 1),
(251, 'UserPermission', 'view', 1),
(252, 'UserPermission', 'create', 1),
(253, 'UserPermission', 'update', 1),
(254, 'UserPermission', 'delete', 1),
(255, 'UserPermission', 'delete-column', 1),
(256, 'UserPermission', 'set-permission', 1),
(257, 'StockIn', 'index', 1),
(258, 'StockIn', 'view', 1),
(259, 'StockIn', 'create', 1),
(260, 'StockIn', 'update', 1),
(261, 'StockIn', 'delete', 1),
(262, 'QuotationDetail', 'index', 1),
(263, 'QuotationDetail', 'view', 1),
(264, 'QuotationDetail', 'create', 1),
(265, 'QuotationDetail', 'update', 1),
(266, 'QuotationDetail', 'delete', 1),
(275, 'ModuleAccess', 'index', 1),
(276, 'ModuleAccess', 'view', 1),
(277, 'ModuleAccess', 'create', 1),
(278, 'ModuleAccess', 'update', 1),
(279, 'ModuleAccess', 'delete', 1),
(280, 'ModuleAccess', 'index', 2),
(281, 'ModuleAccess', 'view', 2),
(282, 'ModuleAccess', 'create', 2),
(283, 'ModuleAccess', 'update', 2),
(284, 'ModuleAccess', 'delete', 2),
(293, 'QuotationDetail', 'index', 2),
(294, 'QuotationDetail', 'view', 2),
(295, 'QuotationDetail', 'create', 2),
(296, 'QuotationDetail', 'update', 2),
(297, 'QuotationDetail', 'delete', 2),
(298, 'StockIn', 'index', 2),
(299, 'StockIn', 'view', 2),
(300, 'StockIn', 'create', 2),
(301, 'StockIn', 'update', 2),
(302, 'StockIn', 'delete', 2),
(303, 'UserPermission', 'index', 2),
(304, 'UserPermission', 'view', 2),
(305, 'UserPermission', 'create', 2),
(306, 'UserPermission', 'update', 2),
(307, 'UserPermission', 'delete', 2),
(308, 'UserPermission', 'delete-column', 2),
(309, 'UserPermission', 'set-permission', 2),
(310, 'QuotationDetail', 'index', 3),
(311, 'QuotationDetail', 'view', 3),
(312, 'QuotationDetail', 'create', 3),
(313, 'QuotationDetail', 'update', 3),
(314, 'QuotationDetail', 'delete', 3),
(315, 'Quotation', 'index', 3),
(316, 'Quotation', 'view', 3),
(317, 'Quotation', 'create', 3),
(318, 'Quotation', 'preview', 3),
(319, 'Quotation', 'update', 3),
(320, 'Quotation', 'delete', 3),
(321, 'Quotation', 'price', 3),
(322, 'Quotation', 'insert-in-list', 3),
(323, 'Gst', 'index', 1),
(324, 'Gst', 'view', 1),
(325, 'Gst', 'create', 1),
(326, 'Gst', 'update', 1),
(327, 'Gst', 'delete', 1),
(328, 'Gst', 'delete-column', 1),
(339, 'Gst', 'index', 2),
(340, 'Gst', 'view', 2),
(341, 'Gst', 'create', 2),
(342, 'Gst', 'update', 2),
(343, 'Gst', 'delete', 2),
(344, 'Gst', 'delete-column', 2),
(345, 'Quotation', 'index', 2),
(346, 'Quotation', 'view', 2),
(347, 'Quotation', 'create', 2),
(348, 'Quotation', 'preview', 2),
(349, 'Quotation', 'update', 2),
(350, 'Quotation', 'delete', 2),
(351, 'Quotation', 'delete-column', 2),
(352, 'Quotation', 'delete-selected-quotation-detail', 2),
(353, 'Quotation', 'price', 2),
(354, 'Quotation', 'insert-in-list', 2),
(355, 'Invoice', 'index', 1),
(356, 'Invoice', 'view', 1),
(357, 'Invoice', 'create', 1),
(358, 'Invoice', 'update', 1),
(359, 'Invoice', 'delete', 1),
(360, 'Invoice', 'preview-and-payment', 1),
(361, 'Quotation', 'index', 1),
(362, 'Quotation', 'view', 1),
(363, 'Quotation', 'create', 1),
(364, 'Quotation', 'preview', 1),
(365, 'Quotation', 'update', 1),
(366, 'Quotation', 'delete', 1),
(367, 'Quotation', 'delete-column', 1),
(368, 'Quotation', 'delete-selected-quotation-detail', 1),
(369, 'Quotation', 'price', 1),
(370, 'Quotation', 'insert-in-list', 1),
(371, 'Quotation', 'insert-invoice', 1);

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
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `type` (`type`);

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
-- Indexes for table `quotation_detail`
--
ALTER TABLE `quotation_detail`
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
-- Indexes for table `stock_in`
--
ALTER TABLE `stock_in`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `gst`
--
ALTER TABLE `gst`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `invoice_detail`
--
ALTER TABLE `invoice_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
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
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `quotation`
--
ALTER TABLE `quotation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `quotation_detail`
--
ALTER TABLE `quotation_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
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
-- AUTO_INCREMENT for table `stock_in`
--
ALTER TABLE `stock_in`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=372;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
