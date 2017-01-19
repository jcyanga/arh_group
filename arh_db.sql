-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 18, 2017 at 12:47 PM
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
('admin', '3', 1484709852),
('developer', '1', 123456789),
('developer', '2', 123456789),
('staff', '4', 1484710535);

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
  `address` varchar(100) NOT NULL,
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
(1, 'BRANCH-2017-55778', 'developer-branch', '27th Floor BPI Buendia Center, Makati Ave. Makati City', '09959575415', 1, '2017-01-17', 1, '2017-01-17', 1),
(2, 'BRANCH-2017-87720', 'fcs-philippines', '27th floor, BPI Buendia Center, Makati Ave. Makati City', '9515785', 1, '2017-01-18', 1, '2017-01-18', 1),
(3, 'BRANCH-2017-23944', 'fcs-singapore', '158 Kallang Way, #03-05, Performance Building, Kallang 349245, Singapore City', '+65 6848 4984', 1, '2017-01-18', 1, '2017-01-18', 1);

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
(1, 'body components'),
(2, 'doors'),
(3, 'windows'),
(4, 'audio/video devices'),
(5, 'cameras'),
(6, 'charging system'),
(7, 'electrical supply system'),
(8, 'gauge and meters'),
(9, 'lightning and signaling'),
(10, 'sensors'),
(11, 'car seat'),
(12, 'braking system'),
(13, 'engine component and parts'),
(14, 'engine cooling system'),
(15, 'engine oil system'),
(16, 'exhaust system'),
(17, 'fuel supply system'),
(18, 'suspension and steering system'),
(19, 'transmission system'),
(20, 'aircondition system'),
(21, 'bearings'),
(22, 'hose');

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
(1, 'tony_lim', 'tony lim', 'chinese', 'AXU-765', '1st-4th floor altas bldg. pascal st. sta. cruz, binondo manila', '09091234567', '9557898', 'tonylim@gmai.com', 'Black', 'Hyundai SantaFe', 'President of Tony Software Inc.', 0, '1', 995, '2017-01-25', 1, '2017-01-18 11:51:57', 2, '2017-01-18 11:51:57', 0),
(2, 'michael_angelo', 'michael angelo', 'Filipino-American', 'UVX-210', 'Blk 1. Lot 7. Gumamela Street. Don Jose Subd. Fairview Quezon City', '09287894561', '4272558', 'michael_angelo@yahoo.com.ph', 'Silver', 'Mazda3', 'Software Engineer at Emerson', 0, '0', 970, '2017-01-25', 1, '2017-01-18 12:30:49', 2, '2017-01-18 12:30:49', 0),
(3, 'ericka_lee', 'ericka lee', 'Japanese', 'ICA-725', '24th floor High-Rise Sun Condominium, Welcome Rotonda Manila City.', '09254561230', '9954515', 'ericka@yahoo.com.ph', 'Red', 'Toyota Rav4', 'HR. Manager at JP Chase and Morgan.', 0, '1', 1000, '2017-01-25', 1, '2017-01-18 12:36:39', 2, '2017-01-18 12:36:39', 0);

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
(1, '1.12', 2),
(2, '1.12', 3);

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
(1, 1, 1, 20, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(2, 2, 1, 14, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(3, 3, 1, 15, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(4, 4, 1, 15, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(5, 5, 1, 14, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(6, 6, 1, 15, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(7, 7, 1, 14, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(8, 8, 1, 13, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(9, 10, 1, 14, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(10, 11, 1, 13, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(11, 12, 1, 14, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(12, 13, 1, 15, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(13, 14, 1, 15, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(14, 15, 1, 15, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(15, 16, 1, 15, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(16, 17, 1, 15, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(17, 18, 1, 15, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(18, 19, 1, 15, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(19, 20, 1, 15, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(20, 21, 1, 15, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(21, 22, 1, 15, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(22, 23, 1, 14, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(23, 24, 1, 15, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(24, 25, 1, 15, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(25, 26, 1, 15, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(26, 27, 1, 15, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(27, 28, 1, 15, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(28, 29, 2, 15, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(29, 30, 2, 15, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(30, 31, 2, 15, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(31, 32, 2, 15, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(32, 33, 2, 15, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(33, 34, 2, 15, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(34, 35, 2, 15, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(35, 36, 2, 15, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(36, 37, 2, 15, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(37, 38, 2, 15, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(38, 39, 2, 15, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(39, 40, 2, 15, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(40, 41, 2, 15, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(41, 42, 2, 15, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(42, 43, 2, 15, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(43, 44, 2, 15, 99, 100, '2017-01-16', 0, '2017-01-16', 1),
(44, 1, 2, 12, 100, 105, '2017-01-16', 0, '2017-01-16', 1);

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
  `paid` int(5) NOT NULL,
  `paid_type` int(5) NOT NULL,
  `status` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `quotation_code`, `invoice_no`, `user_id`, `customer_id`, `branch_id`, `date_issue`, `grand_total`, `remarks`, `created_at`, `created_by`, `updated_at`, `updated_by`, `delete`, `task`, `paid`, `paid_type`, `status`) VALUES
(1, 'QUO-2017-868093', 'INVOICE-2017-72449-1', 4, 2, 2, '2017-01-19', 487.2, 'keep safe.', '2017-01-18', 2, '2017-01-18', 2, 0, 0, 1, 2, 1),
(2, '0', 'INVOICE-2017-86634-2', 4, 1, 3, '2017-01-19', 893.76, 'god bless us and keep faith.', '2017-01-18', 2, '2017-01-18', 2, 0, 0, 1, 1, 1);

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
  `task` int(5) NOT NULL,
  `status` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice_detail`
--

INSERT INTO `invoice_detail` (`id`, `invoice_id`, `service_part_id`, `quantity`, `selling_price`, `subTotal`, `created_at`, `created_by`, `type`, `task`, `status`) VALUES
(1, 1, 3, 1, 300, 300, '2017-01-18', 2, 0, 1, 1),
(2, 1, 7, 1, 135, 135, '2017-01-18', 2, 0, 1, 0),
(16, 2, 2, 2, 99, 198, '2017-01-18', 2, 0, 1, 1),
(17, 2, 6, 1, 200, 200, '2017-01-18', 2, 0, 0, 0),
(18, 2, 10, 2, 100, 200, '2017-01-18', 2, 1, 0, 0),
(19, 2, 9, 1, 100, 100, '2017-01-18', 2, 1, 0, 0),
(20, 2, 2, 1, 100, 100, '2017-01-18', 2, 1, 0, 0);

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
('m170116_033646_create_rbac_init', 1484537877);

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
(16, 'User Module'),
(17, 'set gst module'),
(18, 'part critical and minimum level module');

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
  `amount` double NOT NULL,
  `discount` double NOT NULL,
  `payment_method` int(5) NOT NULL,
  `payment_type` varchar(50) NOT NULL,
  `points_earned` int(5) NOT NULL,
  `points_redeem` int(5) NOT NULL,
  `remarks` text NOT NULL,
  `payment_date` date NOT NULL,
  `payment_time` time NOT NULL,
  `status` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `invoice_id`, `invoice_no`, `customer_id`, `amount`, `discount`, `payment_method`, `payment_type`, `points_earned`, `points_redeem`, `remarks`, `payment_date`, `payment_time`, `status`) VALUES
(1, 2, 'INVOICE-2017-86634-2', 1, 900, 90, 1, 'Cash Payment', 5, 40, 'pay via cash payment.', '2017-01-18', '19:06:32', 1),
(2, 1, 'INVOICE-2017-72449-1-0', 2, 300, 30, 2, 'Cash Payment', 10, 20, 'pay via cash payment.', '2017-01-18', '19:08:53', 1),
(3, 1, 'INVOICE-2017-72449-1-1', 2, 200, 20, 2, 'Cheque', 10, 10, 'pay via cheque payment.', '2017-01-18', '19:08:53', 1);

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
(1, 'PARTS-2017-71044', 'bonnet/hood ', 'picture.jpg', 'pieces', 1, 1, '2017-01-16', 1),
(2, 'PARTS-2017-90165', 'bumper', 'picture.jpg', 'pieces', 1, 1, '2017-01-16', 1),
(3, 'PARTS-2017-93472', 'Front Right Outer door handles', 'picture.jpg', 'pieces', 1, 2, '2017-01-16', 1),
(4, 'PARTS-2017-53931', 'Front Left Side Outer door handle', 'picture.jpg', 'pieces', 1, 2, '2017-01-16', 1),
(5, 'PARTS-2017-04741', 'Front Right Side Door Glass', 'picture.jpg', 'pieces', 1, 3, '2017-01-16', 1),
(6, 'PARTS-2017-00095', 'Front Left Side Door Glass', 'picture.jpg', 'pieces', 1, 3, '2017-01-16', 1),
(7, 'PARTS-2017-75879', 'Antenna assembly', 'picture.jpg', 'pieces', 1, 4, '2017-01-16', 1),
(8, 'PARTS-2017-42521', 'Radio and media player', 'picture.jpg', 'pieces', 1, 4, '2017-01-16', 1),
(9, 'PARTS-2017-58248', 'Backup camera', 'picture.jpg', 'pieces', 1, 5, '2017-01-16', 1),
(10, 'PARTS-2017-56251', 'Dashcam', 'picture.jpg', 'pieces', 1, 5, '2017-01-16', 1),
(11, 'PARTS-2017-48587', 'Alternator bearing', 'picture.jpg', 'pieces', 1, 6, '2017-01-16', 1),
(12, 'PARTS-2017-06121', 'Alternator bracket', 'picture.jpg', 'pieces', 1, 6, '2017-01-16', 1),
(13, 'PARTS-2017-26259', 'Battery', 'picture.jpg', 'pieces', 1, 7, '2017-01-16', 1),
(14, 'PARTS-2017-10365', 'Voltage regulator', 'picture.jpg', 'pieces', 1, 7, '2017-01-16', 1),
(15, 'PARTS-2017-02077', 'Ammeter', 'picture.jpg', 'pieces', 1, 8, '2017-01-16', 1),
(16, 'PARTS-2017-05426', 'Clinometer', 'picture.jpg', 'pieces', 1, 8, '2017-01-16', 1),
(17, 'PARTS-2017-58978', 'Engine bay lighting', 'picture.jpg', 'pieces', 1, 9, '2017-01-16', 1),
(18, 'PARTS-2017-79066', 'Halogen', 'picture.jpg', 'pieces', 1, 9, '2017-01-16', 1),
(19, 'PARTS-2017-07104', 'Airbag sensors', 'picture.jpg', 'pieces', 1, 10, '2017-01-16', 1),
(20, 'PARTS-2017-71693', 'Automatic transmission speed sensor', 'picture.jpg', 'pieces', 1, 10, '2017-01-16', 1),
(21, 'PARTS-2017-71602', 'Bench seat', 'picture.jpg', 'pieces', 1, 11, '2017-01-16', 1),
(22, 'PARTS-2017-08683', 'Bucket seat', 'picture.jpg', 'pieces', 1, 11, '2017-01-16', 1),
(23, 'PARTS-2017-13998', 'Anti-lock braking system', 'picture.jpg', 'pieces', 1, 12, '2017-01-16', 1),
(24, 'PARTS-2017-36669', 'Adjusting mechanism', 'picture.jpg', 'pieces', 1, 12, '2017-01-16', 1),
(25, 'PARTS-2017-70124', 'Accessory belt', 'picture.jpg', 'pieces', 1, 13, '2017-01-16', 1),
(26, 'PARTS-2017-16328', 'Air duct', 'picture.jpg', 'pieces', 1, 13, '2017-01-16', 1),
(27, 'PARTS-2017-54973', 'Coolant hose', 'picture.jpg', 'pieces', 1, 14, '2017-01-16', 1),
(28, 'PARTS-2017-82373', 'Cooling fan', 'picture.jpg', 'pieces', 1, 14, '2017-01-16', 1),
(29, 'PARTS-2017-72842', 'Oil filter', 'picture.jpg', 'pieces', 1, 15, '2017-01-16', 1),
(30, 'PARTS-2017-79776', 'Oil gasket', 'picture.jpg', 'pieces', 1, 15, '2017-01-16', 1),
(31, 'PARTS-2017-89418', 'Catalytic converter', 'picture.jpg', 'pieces', 1, 16, '2017-01-16', 1),
(32, 'PARTS-2017-49172', 'xhaust clamp and bracket', 'picture.jpg', 'pieces', 1, 16, '2017-01-16', 1),
(33, 'PARTS-2017-96868', 'Air filter', 'picture.jpg', 'pieces', 1, 17, '2017-01-16', 1),
(34, 'PARTS-2017-77547', 'Choke cable', 'picture.jpg', 'pieces', 1, 17, '2017-01-16', 1),
(35, 'PARTS-2017-10267', 'Beam axle', 'picture.jpg', 'pieces', 1, 18, '2017-01-16', 1),
(36, 'PARTS-2017-45492', 'Control arm', 'picture.jpg', 'pieces', 1, 18, '2017-01-16', 1),
(37, 'PARTS-2017-65443', 'Axle shaft', 'picture.jpg', 'pieces', 1, 19, '2017-01-16', 1),
(38, 'PARTS-2017-38052', 'Bell housing', 'picture.jpg', 'pieces', 1, 19, '2017-01-16', 1),
(39, 'PARTS-2017-36638', 'A/C Clutch', 'picture.jpg', 'pieces', 1, 20, '2017-01-16', 1),
(40, 'PARTS-2017-05926', 'A/C Compressor', 'picture.jpg', 'pieces', 1, 20, '2017-01-16', 1),
(41, 'PARTS-2017-23604', 'Grooved ball bearing', 'picture.jpg', 'pieces', 1, 21, '2017-01-16', 1),
(42, 'PARTS-2017-74772', 'Needle bearing', 'picture.jpg', 'pieces', 1, 21, '2017-01-16', 1),
(43, 'PARTS-2017-50657', 'Fuel vapour hose', 'picture.jpg', 'pieces', 1, 22, '2017-01-16', 1),
(44, 'PARTS-2017-81711', 'Washer hose', 'picture.jpg', 'pieces', 1, 22, '2017-01-16', 1);

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
  `invoice` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quotation`
--

INSERT INTO `quotation` (`id`, `quotation_code`, `user_id`, `customer_id`, `branch_id`, `date_issue`, `grand_total`, `remarks`, `created_at`, `created_by`, `updated_at`, `updated_by`, `delete`, `task`, `invoice`) VALUES
(1, 'QUO-2017-413791', 4, 3, 2, '2017-01-19', 336, 'god bless us.', '2017-01-18', 2, '2017-01-18', 2, 0, 0, 1),
(2, 'QUO-2017-512132', 4, 2, 3, '2017-01-19', 728, 'god bless us.', '2017-01-18', 2, '2017-01-18', 2, 0, 0, 1),
(3, 'QUO-2017-868093', 4, 2, 2, '2017-01-19', 487.2, 'keep safe.', '2017-01-18', 2, '2017-01-18', 2, 0, 0, 1);

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
  `task` int(5) NOT NULL,
  `invoice` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quotation_detail`
--

INSERT INTO `quotation_detail` (`id`, `quotation_id`, `service_part_id`, `quantity`, `selling_price`, `subTotal`, `created_at`, `created_by`, `type`, `task`, `invoice`) VALUES
(20, 2, 5, 1, 150, 150, '2017-01-18', 2, 0, 1, 1),
(21, 2, 13, 1, 200, 200, '2017-01-18', 2, 0, 1, 1),
(22, 2, 8, 2, 100, 200, '2017-01-18', 2, 1, 0, 1),
(23, 2, 11, 1, 100, 100, '2017-01-18', 2, 1, 0, 1),
(24, 1, 13, 1, 200, 200, '2017-01-18', 2, 0, 0, 1),
(25, 1, 5, 1, 100, 100, '2017-01-18', 2, 1, 0, 1),
(26, 3, 3, 1, 300, 300, '2017-01-18', 2, 0, 1, 1),
(27, 3, 7, 1, 135, 135, '2017-01-18', 2, 0, 1, 1);

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
(14, 3, 'Wheel Balance', 'Routinely balance your tires to avoid uneven wear, vibration, and potentially unsafe driving conditions.', 100, 1, '2017-01-16', 1, '2017-01-16', 1);

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
(3, 'Additional Tire Services', 'For Additional Tire Services', 1, '2017-01-16', 1, '2017-01-16', 1);

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
(1, 1, 1, 10, 99, 100, '2017-01-16', '12:54:35', '2017-01-16', 1),
(2, 2, 1, 10, 99, 100, '2017-01-16', '12:54:35', '2017-01-16', 1),
(3, 3, 1, 10, 99, 100, '2017-01-16', '12:54:35', '2017-01-16', 1),
(4, 4, 1, 10, 99, 100, '2017-01-16', '12:54:35', '2017-01-16', 1),
(5, 5, 1, 10, 99, 100, '2017-01-16', '12:54:35', '2017-01-16', 1),
(6, 6, 1, 10, 99, 100, '2017-01-16', '12:54:35', '2017-01-16', 1),
(7, 7, 1, 10, 99, 100, '2017-01-16', '12:54:35', '2017-01-16', 1),
(8, 8, 1, 10, 99, 100, '2017-01-16', '12:54:36', '2017-01-16', 1),
(9, 10, 1, 10, 99, 100, '2017-01-16', '12:54:36', '2017-01-16', 1),
(10, 11, 1, 10, 99, 100, '2017-01-16', '12:54:36', '2017-01-16', 1),
(11, 12, 1, 10, 99, 100, '2017-01-16', '12:54:36', '2017-01-16', 1),
(12, 13, 1, 10, 99, 100, '2017-01-16', '12:54:36', '2017-01-16', 1),
(13, 14, 1, 10, 99, 100, '2017-01-16', '12:54:36', '2017-01-16', 1),
(14, 15, 1, 10, 99, 100, '2017-01-16', '12:54:36', '2017-01-16', 1),
(15, 16, 1, 10, 99, 100, '2017-01-16', '12:54:36', '2017-01-16', 1),
(16, 17, 1, 10, 99, 100, '2017-01-16', '12:54:36', '2017-01-16', 1),
(17, 18, 1, 10, 99, 100, '2017-01-16', '12:54:36', '2017-01-16', 1),
(18, 19, 1, 10, 99, 100, '2017-01-16', '12:54:36', '2017-01-16', 1),
(19, 20, 1, 10, 99, 100, '2017-01-16', '12:54:36', '2017-01-16', 1),
(20, 21, 1, 10, 99, 100, '2017-01-16', '12:54:37', '2017-01-16', 1),
(21, 22, 1, 10, 99, 100, '2017-01-16', '12:54:37', '2017-01-16', 1),
(22, 23, 1, 10, 99, 100, '2017-01-16', '12:54:37', '2017-01-16', 1),
(23, 24, 1, 10, 99, 100, '2017-01-16', '12:54:37', '2017-01-16', 1),
(24, 25, 1, 10, 99, 100, '2017-01-16', '12:54:37', '2017-01-16', 1),
(25, 26, 1, 10, 99, 100, '2017-01-16', '12:54:37', '2017-01-16', 1),
(26, 27, 1, 10, 99, 100, '2017-01-16', '12:54:37', '2017-01-16', 1),
(27, 28, 1, 10, 99, 100, '2017-01-16', '12:54:37', '2017-01-16', 1),
(28, 29, 2, 10, 99, 100, '2017-01-16', '13:00:11', '2017-01-16', 1),
(29, 30, 2, 10, 99, 100, '2017-01-16', '13:00:11', '2017-01-16', 1),
(30, 31, 2, 10, 99, 100, '2017-01-16', '13:00:11', '2017-01-16', 1),
(31, 32, 2, 10, 99, 100, '2017-01-16', '13:00:11', '2017-01-16', 1),
(32, 33, 2, 10, 99, 100, '2017-01-16', '13:00:11', '2017-01-16', 1),
(33, 34, 2, 10, 99, 100, '2017-01-16', '13:00:11', '2017-01-16', 1),
(34, 35, 2, 10, 99, 100, '2017-01-16', '13:00:11', '2017-01-16', 1),
(35, 36, 2, 10, 99, 100, '2017-01-16', '13:00:11', '2017-01-16', 1),
(36, 37, 2, 10, 99, 100, '2017-01-16', '13:00:11', '2017-01-16', 1),
(37, 38, 2, 10, 99, 100, '2017-01-16', '13:00:11', '2017-01-16', 1),
(38, 39, 2, 10, 99, 100, '2017-01-16', '13:00:12', '2017-01-16', 1),
(39, 40, 2, 10, 99, 100, '2017-01-16', '13:00:12', '2017-01-16', 1),
(40, 41, 2, 10, 99, 100, '2017-01-16', '13:00:12', '2017-01-16', 1),
(41, 42, 2, 10, 99, 100, '2017-01-16', '13:00:12', '2017-01-16', 1),
(42, 43, 2, 10, 99, 100, '2017-01-16', '13:00:12', '2017-01-16', 1),
(43, 44, 2, 10, 99, 100, '2017-01-16', '13:00:12', '2017-01-16', 1),
(44, 2, 1, 15, 99, 100, '2017-01-16', '14:09:39', '2017-01-16', 1),
(45, 1, 1, 15, 99, 100, '2017-01-16', '14:12:08', '2017-01-16', 1),
(46, 3, 1, 15, 99, 100, '2017-01-16', '14:12:08', '2017-01-16', 1),
(47, 1, 2, 10, 100, 105, '2017-01-16', '14:12:48', '2017-01-16', 1),
(48, 1, 2, 13, 100, 105, '2017-01-16', '14:13:10', '2017-01-16', 1),
(49, 1, 2, 15, 100, 105, '2017-01-16', '14:13:36', '2017-01-16', 1),
(50, 1, 1, 15, 99, 100, '2017-01-16', '14:39:40', '2017-01-16', 1),
(51, 4, 1, 15, 99, 100, '2017-01-16', '14:39:40', '2017-01-16', 1),
(52, 5, 1, 15, 99, 100, '2017-01-16', '14:39:40', '2017-01-16', 1),
(53, 6, 1, 15, 99, 100, '2017-01-16', '14:39:40', '2017-01-16', 1),
(54, 7, 1, 15, 99, 100, '2017-01-16', '14:39:40', '2017-01-16', 1),
(55, 8, 1, 15, 99, 100, '2017-01-16', '14:39:40', '2017-01-16', 1),
(56, 10, 1, 15, 99, 100, '2017-01-16', '14:39:40', '2017-01-16', 1),
(57, 11, 1, 15, 99, 100, '2017-01-16', '14:39:40', '2017-01-16', 1),
(58, 12, 1, 15, 99, 100, '2017-01-16', '14:40:03', '2017-01-16', 1),
(59, 13, 1, 15, 99, 100, '2017-01-16', '14:40:03', '2017-01-16', 1),
(60, 14, 1, 15, 99, 100, '2017-01-16', '14:40:03', '2017-01-16', 1),
(61, 15, 1, 15, 99, 100, '2017-01-16', '14:40:03', '2017-01-16', 1),
(62, 16, 1, 15, 99, 100, '2017-01-16', '14:40:03', '2017-01-16', 1),
(63, 17, 1, 15, 99, 100, '2017-01-16', '14:40:03', '2017-01-16', 1),
(64, 18, 1, 15, 99, 100, '2017-01-16', '14:40:03', '2017-01-16', 1),
(65, 19, 1, 15, 99, 100, '2017-01-16', '14:40:03', '2017-01-16', 1),
(66, 20, 1, 15, 99, 100, '2017-01-16', '14:40:03', '2017-01-16', 1),
(67, 21, 1, 15, 99, 100, '2017-01-16', '14:40:04', '2017-01-16', 1),
(68, 22, 1, 15, 99, 100, '2017-01-16', '14:40:19', '2017-01-16', 1),
(69, 23, 1, 15, 99, 100, '2017-01-16', '14:40:19', '2017-01-16', 1),
(70, 24, 1, 15, 99, 100, '2017-01-16', '14:40:19', '2017-01-16', 1),
(71, 25, 1, 15, 99, 100, '2017-01-16', '14:40:19', '2017-01-16', 1),
(72, 26, 1, 15, 99, 100, '2017-01-16', '14:40:19', '2017-01-16', 1),
(73, 27, 1, 15, 99, 100, '2017-01-16', '14:40:20', '2017-01-16', 1),
(74, 28, 1, 15, 99, 100, '2017-01-16', '14:40:20', '2017-01-16', 1),
(75, 29, 2, 15, 99, 100, '2017-01-16', '14:40:20', '2017-01-16', 1),
(76, 30, 2, 15, 99, 100, '2017-01-16', '14:40:20', '2017-01-16', 1),
(77, 31, 2, 15, 99, 100, '2017-01-16', '14:40:20', '2017-01-16', 1),
(78, 32, 2, 15, 99, 100, '2017-01-16', '14:40:35', '2017-01-16', 1),
(79, 33, 2, 15, 99, 100, '2017-01-16', '14:40:35', '2017-01-16', 1),
(80, 34, 2, 15, 99, 100, '2017-01-16', '14:40:36', '2017-01-16', 1),
(81, 35, 2, 15, 99, 100, '2017-01-16', '14:40:36', '2017-01-16', 1),
(82, 36, 2, 15, 99, 100, '2017-01-16', '14:40:36', '2017-01-16', 1),
(83, 37, 2, 15, 99, 100, '2017-01-16', '14:40:36', '2017-01-16', 1),
(84, 38, 2, 15, 99, 100, '2017-01-16', '14:40:36', '2017-01-16', 1),
(85, 39, 2, 15, 99, 100, '2017-01-16', '14:40:36', '2017-01-16', 1),
(86, 40, 2, 15, 99, 100, '2017-01-16', '14:40:36', '2017-01-16', 1),
(87, 41, 2, 15, 99, 100, '2017-01-16', '14:40:36', '2017-01-16', 1),
(88, 42, 2, 15, 99, 100, '2017-01-16', '14:40:48', '2017-01-16', 1),
(89, 43, 2, 15, 99, 100, '2017-01-16', '14:40:49', '2017-01-16', 1),
(90, 44, 2, 15, 99, 100, '2017-01-16', '14:40:49', '2017-01-16', 1),
(92, 1, 1, 20, 99, 100, '2017-01-18', '14:57:22', '2017-01-18', 2),
(93, 2, 1, 15, 99, 100, '2017-01-18', '14:57:22', '2017-01-18', 2),
(94, 3, 1, 15, 99, 100, '2017-01-18', '14:57:22', '2017-01-18', 2),
(95, 4, 1, 15, 99, 100, '2017-01-18', '14:57:22', '2017-01-18', 2),
(96, 5, 1, 15, 99, 100, '2017-01-18', '14:57:22', '2017-01-18', 2),
(97, 6, 1, 15, 99, 100, '2017-01-18', '14:57:22', '2017-01-18', 2),
(98, 7, 1, 15, 99, 100, '2017-01-18', '14:57:22', '2017-01-18', 2),
(99, 8, 1, 15, 99, 100, '2017-01-18', '14:57:22', '2017-01-18', 2),
(100, 10, 1, 15, 99, 100, '2017-01-18', '14:57:22', '2017-01-18', 2),
(101, 11, 1, 15, 99, 100, '2017-01-18', '14:57:22', '2017-01-18', 2);

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
(1, 'SUPPLIERS-2017-17645', 'SM Oil Seal Parts Center', '1044 G. Masangkay Street Manila, 1006 Metro Manila', '02-2447804'),
(2, 'SUPPLIERS-2017-40846', 'Cabasal Trading', '649 Evangelista Street Manila, Metro Manila', '02-2447353');

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
(2, 1, 1, 20, 'developer', 'developer', 'password', '$2y$13$KLYNdyN9n.CXY4uELu9Td.6LJ1BoXrXQY0dmrnb9HUMegb1dPw.YK', '', 'developer@yahoo.com', 'user.png', 'R5BJVsB83hg7xshurVUaXb6qYn4HrFi8', 1, '2017-01-17 19:00:00', '2017-01-17 19:00:00', 1, '2017-01-17 19:00:00', 1, 0),
(3, 2, 2, 20, 'administrator', 'admin', '', '$2y$13$zvzcAB5xJ9zzbZMCITRla.Jm4O/uVC1MlEsna8no5vg2pL9cHfFia', '', 'admin@fcs.com.ph', '', 'GaGsWm5FvDSQbfZxLgeYOw5TLbuMhUo1', 1, '0000-00-00 00:00:00', '2017-01-18 11:24:12', 2, '0000-00-00 00:00:00', 0, 0),
(4, 3, 2, 20, 'mystaff', 'staff', '', '$2y$13$85BwH9D2aHynPNYQK9rRM.GEPQ0IKzBjPwZJPQv9zzs/WGOHnky6a', '', 'mystaff@fcs.com.ph', '', 'Z9l0E4yRXgdryGhmE4cb_MwzDE15QjqU', 1, '0000-00-00 00:00:00', '2017-01-18 11:35:35', 2, '0000-00-00 00:00:00', 0, 0);

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
(414, 'Inventory', 'index', 1),
(415, 'Inventory', 'view', 1),
(416, 'Inventory', 'create', 1),
(417, 'Inventory', 'update', 1),
(418, 'Inventory', 'delete', 1),
(419, 'Inventory', 'delete-column', 1),
(420, 'Inventory', 'export-excel', 1),
(421, 'Inventory', 'export-pdf', 1),
(422, 'Inventory', 'insert-in-inventory', 1),
(423, 'Site', 'index', 3),
(424, 'Site', 'login', 3),
(425, 'Site', 'logout', 3),
(426, 'ProductLevel', 'index', 1),
(427, 'ProductLevel', 'view', 1),
(428, 'ProductLevel', 'create', 1),
(429, 'ProductLevel', 'update', 1),
(430, 'ProductLevel', 'delete', 1),
(431, 'Site', 'index', 4),
(432, 'Site', 'login', 4),
(433, 'Site', 'logout', 4),
(470, 'ProductLevel', 'index', 2),
(471, 'ProductLevel', 'view', 2),
(472, 'ProductLevel', 'create', 2),
(473, 'ProductLevel', 'update', 2),
(474, 'ProductLevel', 'delete', 2),
(487, 'Reports', 'index', 1),
(488, 'Reports', 'month-stock-report', 1),
(489, 'Quotation', 'index', 1),
(490, 'Quotation', 'view', 1),
(491, 'Quotation', 'create', 1),
(492, 'Quotation', 'preview', 1),
(493, 'Quotation', 'update', 1),
(494, 'Quotation', 'delete', 1),
(495, 'Quotation', 'delete-column', 1),
(496, 'Quotation', 'price', 1),
(497, 'Quotation', 'insert-in-list', 1),
(498, 'Quotation', 'insert-invoice', 1),
(499, 'Quotation', 'export-excel', 1),
(500, 'Quotation', 'export-pdf', 1),
(529, 'Quotation', 'index', 2),
(530, 'Quotation', 'view', 2),
(531, 'Quotation', 'create', 2),
(532, 'Quotation', 'preview', 2),
(533, 'Quotation', 'update', 2),
(534, 'Quotation', 'delete', 2),
(535, 'Quotation', 'delete-column', 2),
(536, 'Quotation', 'price', 2),
(537, 'Quotation', 'insert-in-list', 2),
(538, 'Quotation', 'insert-invoice', 2),
(539, 'Quotation', 'export-excel', 2),
(540, 'Quotation', 'export-pdf', 2),
(556, 'Invoice', 'index', 1),
(557, 'Invoice', 'view', 1),
(558, 'Invoice', 'create', 1),
(559, 'Invoice', 'preview', 1),
(560, 'Invoice', 'update', 1),
(561, 'Invoice', 'delete', 1),
(562, 'Invoice', 'delete-column', 1),
(563, 'Invoice', 'delete-selected-quotation-detail', 1),
(564, 'Invoice', 'price', 1),
(565, 'Invoice', 'insert-in-list', 1),
(566, 'Invoice', 'payment-method', 1),
(567, 'Invoice', 'save-payment', 1),
(568, 'Invoice', 'insert-in-payment-list', 1),
(569, 'Invoice', 'print-invoice', 1),
(570, 'Invoice', 'print-multiple-invoice', 1),
(571, 'Invoice', 'export-excel', 1),
(572, 'Invoice', 'index', 2),
(573, 'Invoice', 'view', 2),
(574, 'Invoice', 'create', 2),
(575, 'Invoice', 'preview', 2),
(576, 'Invoice', 'update', 2),
(577, 'Invoice', 'delete', 2),
(578, 'Invoice', 'delete-column', 2),
(579, 'Invoice', 'delete-selected-quotation-detail', 2),
(580, 'Invoice', 'price', 2),
(581, 'Invoice', 'insert-in-list', 2),
(582, 'Invoice', 'payment-method', 2),
(583, 'Invoice', 'save-payment', 2),
(584, 'Invoice', 'insert-in-payment-list', 2),
(585, 'Invoice', 'print-invoice', 2),
(586, 'Invoice', 'print-multiple-invoice', 2),
(587, 'Invoice', 'export-excel', 2),
(588, 'Invoice', 'index', 3);

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
-- Indexes for table `product_level`
--
ALTER TABLE `product_level`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
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
-- AUTO_INCREMENT for table `gst`
--
ALTER TABLE `gst`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `invoice_detail`
--
ALTER TABLE `invoice_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `product_level`
--
ALTER TABLE `product_level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `quotation`
--
ALTER TABLE `quotation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `quotation_detail`
--
ALTER TABLE `quotation_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `service_category`
--
ALTER TABLE `service_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `stock_in`
--
ALTER TABLE `stock_in`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;
--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user_permission`
--
ALTER TABLE `user_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=589;
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
