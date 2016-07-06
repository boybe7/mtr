-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2016 at 11:47 AM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mtr`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `strSplit` (`x` VARCHAR(255), `delim` VARCHAR(12), `pos` INT) RETURNS VARCHAR(255) CHARSET utf8 return replace(substring(substring_index(x, delim, pos), length(substring_index(x, delim, pos - 1)) + 1), delim, '')$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `authens`
--

CREATE TABLE `authens` (
  `id` int(11) NOT NULL,
  `user_group_id` int(11) NOT NULL COMMENT 'กลุ่มผู้ใช้งาน',
  `menu_id` int(11) NOT NULL COMMENT 'เมนู'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `authens`
--

INSERT INTO `authens` (`id`, `user_group_id`, `menu_id`) VALUES
(16, 1, 1),
(17, 1, 3),
(18, 1, 4),
(19, 1, 5),
(20, 1, 6),
(21, 1, 7);

-- --------------------------------------------------------

--
-- Table structure for table `contracts`
--

CREATE TABLE `contracts` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL COMMENT 'ชื่อสัญญา',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT 'สถานะ (0=ปิด,1=เปิด)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contracts`
--

INSERT INTO `contracts` (`id`, `name`, `status`) VALUES
(1, 'PITL - 738/1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `invoice_no` varchar(200) NOT NULL COMMENT 'เลขที่ใบแจ้งชำระเงิน',
  `cost` decimal(10,2) NOT NULL COMMENT 'ค่าธรรมเนียมทดสอบ',
  `bill_no` varchar(200) DEFAULT NULL COMMENT 'เลขที่ใบเสร็จรับเงิน',
  `bill_date` date DEFAULT NULL COMMENT 'วันที่ชำระเงิน',
  `request_id` int(11) NOT NULL,
  `sampling_no` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `invoice_no`, `cost`, `bill_no`, `bill_date`, `request_id`, `sampling_no`) VALUES
(1, '2/2559', '800.00', NULL, NULL, 35, ''),
(2, '3/2559', '200.00', NULL, NULL, 36, ''),
(3, '3/2559', '800.00', NULL, NULL, 37, ''),
(4, '3/2559-1', '400.00', NULL, NULL, 37, 'C-7-2,C-7-3,'),
(5, '4/2559', '600.00', NULL, NULL, 38, ''),
(6, '5/2559', '400.00', NULL, NULL, 48, ''),
(7, '6/2559', '200.00', NULL, NULL, 49, ''),
(8, '7/2559', '0.00', NULL, NULL, 50, '');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL COMMENT 'ชื่อประเภทงาน'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `name`) VALUES
(1, 'ทดสอบประจำของ กมว.'),
(3, 'บริการทดสอบ กปภ.'),
(2, 'บริการภายนอก');

-- --------------------------------------------------------

--
-- Table structure for table `labtypes`
--

CREATE TABLE `labtypes` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL COMMENT 'ชื่อวิธีการทดสอบ',
  `name_report` varchar(500) NOT NULL COMMENT 'ชื่อปรากฎในรายงาน',
  `cost` decimal(10,2) NOT NULL COMMENT 'ราคา',
  `is_chemical_test` int(11) NOT NULL COMMENT 'ทดสอบด้านเคมี\n(0=No, 1=Yes)\n',
  `material_id` int(11) NOT NULL COMMENT 'ชนิดวัสดุ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `labtypes`
--

INSERT INTO `labtypes` (`id`, `name`, `name_report`, `cost`, `is_chemical_test`, `material_id`) VALUES
(2, 'ความถ่วงจำเพาะ', 'SPECIFIC GRAVITY OF FLOAT VALVE', '200.00', 1, 14),
(3, 'Gradation', 'Gradation', '400.00', 0, 16),
(4, 'Absortion', 'Absortion', '100.00', 0, 16),
(5, 'Gradation', 'Gradation', '400.00', 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `labtype_inputs`
--

CREATE TABLE `labtype_inputs` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL COMMENT 'ชื่อ input',
  `col_index` varchar(2) NOT NULL COMMENT 'คอลัมภ์',
  `formula` varchar(200) DEFAULT NULL COMMENT 'สูตรคำนวณ',
  `type` varchar(10) NOT NULL COMMENT 'ประเภท (header,raw)',
  `labtype_id` int(11) NOT NULL COMMENT 'วิธีการทดสอบ',
  `self_header` int(2) NOT NULL,
  `decimal_display` int(2) NOT NULL COMMENT 'ทศนิยม'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `labtype_inputs`
--

INSERT INTO `labtype_inputs` (`id`, `name`, `col_index`, `formula`, `type`, `labtype_id`, `self_header`, `decimal_display`) VALUES
(6, 'A', 'A', '', 'header', 1, 0, 0),
(7, 'B', 'B', '', 'header', 1, 0, 0),
(10, 'Z', 'Z', '', 'raw', 1, 0, 0),
(11, 'SPECIMEN MARK', 'A', '', 'header', 2, 0, 0),
(12, 'SIZE OF AIR VALVE (MM.)', 'D', '', 'header', 2, 0, 0),
(13, 'MEASURE DIAMETER (CM.)', 'E', 'avg($N,$O,$P,$Q,$R)', 'header', 2, 0, 2),
(14, 'AIR VALVE DIAMETER 1 (CM.)', 'N', '', 'raw', 2, 0, 2),
(15, 'AIR VALVE DIAMETER 2 (CM.)', 'O', '', 'raw', 2, 0, 2),
(16, 'AIR VALVE DIAMETER 3 (CM.)', 'P', '', 'raw', 2, 0, 2),
(17, 'AIR VALVE DIAMETER 4 (CM.)', 'Q', '', 'raw', 2, 0, 2),
(18, 'AIR VALVE DIAMETER 5 (CM.)', 'R', '', 'raw', 2, 0, 2),
(19, 'VOLUME (CM^3.)', 'F', '(pi()*pow($E,3))/6', 'header', 2, 1, 2),
(20, 'WEIGHT (GM.)', 'G', '', 'header', 2, 0, 2),
(21, 'SPECIFIC GRAVITY', 'H', '$G/$F', 'header', 2, 1, 2),
(22, 'REMARK', 'I', '', 'header', 2, 0, 0),
(23, 'SPECIMEN MARK', 'A', '', 'header', 3, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL COMMENT 'ชื่อวัสดุ',
  `code` varchar(10) NOT NULL COMMENT 'รหัสวัสดุ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`id`, `name`, `code`) VALUES
(1, 'แท่งคอนกรีตทรงเหลี่ยม', 'CT'),
(2, 'ทราย', 'C'),
(3, 'ทองแดงเจือ', 'M'),
(4, 'พี วี ซี', 'SP'),
(5, 'ยาง', 'R'),
(9, 'เหล็กกล้าไร้สนิม', 'M'),
(10, 'เหล็กหล่อ', 'M'),
(11, 'เหล็กหล่อเหนี่ยว', 'M'),
(12, 'เหล็กเหนียว', 'M'),
(13, 'เหล็กอาบสังกะสี', 'M'),
(14, 'ลูกลอยประตูระบายอากาศ', 'SP'),
(15, 'แท่งคอนกรีตทรงกระบอก', 'CT'),
(16, 'หิน หรือ กรวด', 'C');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL COMMENT 'ชื่อเมนู',
  `url` varchar(200) NOT NULL COMMENT 'url',
  `menu_group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `url`, `menu_group_id`) VALUES
(1, 'สิทธิการเข้าถึงข้อมูล', 'authen/index', 1),
(3, 'เมนู', 'menuTree/index', 1),
(4, 'ชนิดวัสดุ', 'material/index', 2),
(5, 'วิธีการทดสอบ', 'labtype/index', 2),
(6, 'มาตรฐาน', 'standard/index', 2),
(7, 'ลงทะเบียนรับตัวอย่าง', 'request/index', 3);

-- --------------------------------------------------------

--
-- Table structure for table `menu_groups`
--

CREATE TABLE `menu_groups` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu_groups`
--

INSERT INTO `menu_groups` (`id`, `name`) VALUES
(1, 'ผู้ใช้งาน'),
(2, 'ข้อมูลหลัก'),
(3, 'บันทึก'),
(4, 'รายงาน');

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL COMMENT 'ชื่อตำแหน่ง',
  `level` int(11) NOT NULL COMMENT 'ระดับ (1=ระดับปฏิบัติการ, 2=หัวหน้าส่วน,3=ผู้อำนวยการกอง)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` int(11) NOT NULL,
  `request_no` varchar(15) NOT NULL COMMENT 'เลขที่ลำดับการทดสอบ',
  `date` date NOT NULL COMMENT 'วันที่รับตัวอย่าง',
  `vendor_id` int(11) DEFAULT NULL COMMENT 'ผู้ผลิต',
  `owner_id` int(11) NOT NULL COMMENT 'เจ้าของตัวอย่าง',
  `job_id` int(11) NOT NULL,
  `contract_id` int(11) DEFAULT NULL,
  `detail` varchar(500) DEFAULT NULL COMMENT 'เรื่อง/งาน',
  `status` int(11) NOT NULL COMMENT '"1"=>"เปิด","2"=>"ปิด","3"=>"ยกเลิก"',
  `note` varchar(500) NOT NULL COMMENT 'หมายเหตุ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `request_no`, `date`, `vendor_id`, `owner_id`, `job_id`, `contract_id`, `detail`, `status`, `note`) VALUES
(34, '1/2559', '2016-06-15', NULL, 1, 1, NULL, '', 1, ''),
(35, '2/2559', '2016-06-17', NULL, 1, 1, NULL, '', 1, ''),
(37, '3/2559', '2016-06-17', NULL, 1, 3, NULL, '', 1, ''),
(48, '5/2559', '2016-06-30', NULL, 1, 3, NULL, '', 3, '(ยกเลิก ''xxxxx'')'),
(49, '6/2559', '2016-07-01', NULL, 1, 1, NULL, '', 1, ''),
(50, '7/2559', '2016-07-01', NULL, 1, 1, NULL, '', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `request_standards`
--

CREATE TABLE `request_standards` (
  `id` int(11) NOT NULL,
  `material_detail` varchar(200) DEFAULT NULL COMMENT 'รายละเอียดวัสดุ',
  `lot_no` varchar(500) NOT NULL COMMENT 'เลข lot',
  `lot_num` int(11) NOT NULL COMMENT 'จำนวน lot',
  `sampling_num` int(11) NOT NULL COMMENT 'จำนวนตัวอย่าง',
  `cost` decimal(10,2) NOT NULL COMMENT 'ค่าธรรมเนียมทดสอบ',
  `labtype_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `standard_id` int(11) NOT NULL,
  `conclude` varchar(500) DEFAULT NULL COMMENT 'สรุปผลการทดสอบ',
  `note` varchar(400) DEFAULT NULL COMMENT 'หมายเหตุ',
  `sampling_no` varchar(100) DEFAULT NULL COMMENT 'หมายเลขตัวอย่าง'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `request_standards`
--

INSERT INTO `request_standards` (`id`, `material_detail`, `lot_no`, `lot_num`, `sampling_num`, `cost`, `labtype_id`, `request_id`, `standard_id`, `conclude`, `note`, `sampling_no`) VALUES
(28, '', 'lot-200', 1, 2, '400.00', 2, 34, 3, NULL, NULL, 'C1-C2'),
(29, '', 'lot-205,lot-206', 2, 4, '800.00', 2, 35, 3, NULL, NULL, 'C3-C6'),
(31, '', 'lot-1', 1, 2, '400.00', 2, 37, 3, NULL, NULL, 'C7-C8'),
(32, '', 'lot-2', 1, 1, '400.00', 3, 37, 4, NULL, NULL, 'C9'),
(53, '', 'ffff', 1, 2, '400.00', 2, 48, 3, NULL, NULL, 'C10-C11'),
(54, '', 'xs', 1, 1, '200.00', 2, 49, 3, '', NULL, 'C12');

-- --------------------------------------------------------

--
-- Table structure for table `retests`
--

CREATE TABLE `retests` (
  `id` int(11) NOT NULL,
  `lot_no` varchar(200) NOT NULL COMMENT 'เลข lot',
  `sampling_no` varchar(200) NOT NULL COMMENT 'เลขตัวอย่าง',
  `sampling_num` int(11) NOT NULL COMMENT 'จำนวนตัวอย่าง',
  `cost` decimal(10,2) NOT NULL COMMENT 'ค่าธรรมเนียมทดสอบ',
  `invoice_no` varchar(200) DEFAULT NULL COMMENT 'เลขที่ใบแจ้งชำระเงิน',
  `request_standard_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `retests`
--

INSERT INTO `retests` (`id`, `lot_no`, `sampling_no`, `sampling_num`, `cost`, `invoice_no`, `request_standard_id`) VALUES
(1, 'lot-1', 'C7', 2, '400.00', '3/2559-1', 31);

-- --------------------------------------------------------

--
-- Table structure for table `standards`
--

CREATE TABLE `standards` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL COMMENT 'ชื่อมาตรฐาน',
  `description` varchar(400) DEFAULT NULL COMMENT 'คำอธิบาย',
  `material_id` int(11) NOT NULL COMMENT 'ชนิดวัสดุ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `standards`
--

INSERT INTO `standards` (`id`, `name`, `description`, `material_id`) VALUES
(3, 'รายละเอียดที่ 33-016-1 ของ กปน.', 'ขนาด 25-150 mm.', 14),
(4, 'xxxxxxxxxxxx', '', 16);

-- --------------------------------------------------------

--
-- Table structure for table `standard_parameters`
--

CREATE TABLE `standard_parameters` (
  `id` int(11) NOT NULL,
  `value` varchar(200) NOT NULL COMMENT 'ค่ามาตรฐาน',
  `labtype_input_id` int(11) NOT NULL,
  `standard_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `standard_parameters`
--

INSERT INTO `standard_parameters` (`id`, `value`, `labtype_input_id`, `standard_id`) VALUES
(15, '0.75-0.80', 21, 3);

-- --------------------------------------------------------

--
-- Table structure for table `temp_retests`
--

CREATE TABLE `temp_retests` (
  `id` int(11) NOT NULL,
  `lot_no` varchar(200) NOT NULL COMMENT 'เลข lot',
  `sampling_no` varchar(200) NOT NULL COMMENT 'เลขตัวอย่าง',
  `sampling_num` int(11) NOT NULL COMMENT 'จำนวนตัวอย่าง',
  `cost` decimal(10,2) NOT NULL COMMENT 'ค่าธรรมเนียมทดสอบ',
  `request_standard_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `temp_sampling_no`
--

CREATE TABLE `temp_sampling_no` (
  `id` int(11) NOT NULL,
  `sampling_no` varchar(100) NOT NULL,
  `num` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `temp_standard_parameters`
--

CREATE TABLE `temp_standard_parameters` (
  `id` int(11) NOT NULL,
  `value` varchar(200) NOT NULL COMMENT 'ค่ามาตรฐาน',
  `labtype_input_id` int(11) NOT NULL,
  `standard_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `test_results_headers`
--

CREATE TABLE `test_results_headers` (
  `id` int(11) NOT NULL,
  `test_date` date NOT NULL COMMENT 'วันที่ทดสอบ',
  `tester_1` varchar(200) NOT NULL COMMENT 'เจ้าหน้าที่ทดสอบ 1 ',
  `tester_2` varchar(200) DEFAULT NULL COMMENT 'เจ้าหน้าที่ทดสอบ 2',
  `approver` varchar(200) NOT NULL COMMENT 'ผู้ตรวจ',
  `reporter` varchar(200) NOT NULL COMMENT 'ผู้รายงานผล',
  `signer` varchar(200) NOT NULL COMMENT 'ผู้รับรอง',
  `signed_date` date NOT NULL COMMENT 'วันที่รับรอง',
  `comment` varchar(500) DEFAULT NULL COMMENT 'หมายเหตุ',
  `request_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `test_results_headers`
--

INSERT INTO `test_results_headers` (`id`, `test_date`, `tester_1`, `tester_2`, `approver`, `reporter`, `signer`, `signed_date`, `comment`, `request_id`) VALUES
(8, '0000-00-00', '', NULL, '', '', '', '0000-00-00', NULL, 45),
(9, '0000-00-00', '', NULL, '', '', '', '0000-00-00', NULL, 48),
(10, '2016-07-04', 'xxxx', 'zzzz', '', '', '', '2016-07-04', '', 49),
(11, '0000-00-00', '', NULL, '', '', '', '0000-00-00', NULL, 50);

-- --------------------------------------------------------

--
-- Table structure for table `test_results_values`
--

CREATE TABLE `test_results_values` (
  `id` int(11) NOT NULL,
  `value` varchar(300) NOT NULL,
  `sampling_no` varchar(200) NOT NULL COMMENT 'หมายเลขตัวอย่าง',
  `lot_no` varchar(200) NOT NULL COMMENT 'หมายเลข lot',
  `sampling_no_fix` varchar(200) NOT NULL COMMENT 'หมายเลขตัวอย่าง',
  `labtype_input_id` int(11) NOT NULL,
  `request_standard_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `test_results_values`
--

INSERT INTO `test_results_values` (`id`, `value`, `sampling_no`, `lot_no`, `sampling_no_fix`, `labtype_input_id`, `request_standard_id`) VALUES
(97, 'C-1', 'C-1', 'lot-200', 'C-1', 11, 28),
(98, '0', 'C-1', 'lot-200', 'C-1', 12, 28),
(99, '0', 'C-1', 'lot-200', 'C-1', 13, 28),
(100, '0', 'C-1', 'lot-200', 'C-1', 14, 28),
(101, '0', 'C-1', 'lot-200', 'C-1', 15, 28),
(102, '0', 'C-1', 'lot-200', 'C-1', 16, 28),
(103, '0', 'C-1', 'lot-200', 'C-1', 17, 28),
(104, '0', 'C-1', 'lot-200', 'C-1', 18, 28),
(105, '0', 'C-1', 'lot-200', 'C-1', 19, 28),
(106, '0', 'C-1', 'lot-200', 'C-1', 20, 28),
(107, '0', 'C-1', 'lot-200', 'C-1', 21, 28),
(108, 'lot-200', 'C-1', 'lot-200', 'C-1', 22, 28),
(109, 'C-2', 'C-2', 'lot-200', 'C-2', 11, 28),
(110, '0', 'C-2', 'lot-200', 'C-2', 12, 28),
(111, '0', 'C-2', 'lot-200', 'C-2', 13, 28),
(112, '0', 'C-2', 'lot-200', 'C-2', 14, 28),
(113, '0', 'C-2', 'lot-200', 'C-2', 15, 28),
(114, '0', 'C-2', 'lot-200', 'C-2', 16, 28),
(115, '0', 'C-2', 'lot-200', 'C-2', 17, 28),
(116, '0', 'C-2', 'lot-200', 'C-2', 18, 28),
(117, '0', 'C-2', 'lot-200', 'C-2', 19, 28),
(118, '0', 'C-2', 'lot-200', 'C-2', 20, 28),
(119, '0', 'C-2', 'lot-200', 'C-2', 21, 28),
(120, 'lot-200', 'C-2', 'lot-200', 'C-2', 22, 28),
(121, 'C-3', 'C-3', 'lot-205', 'C-3', 11, 29),
(122, '0', 'C-3', 'lot-205', 'C-3', 12, 29),
(123, '10', 'C-3', 'lot-205', 'C-3', 13, 29),
(124, '10', 'C-3', 'lot-205', 'C-3', 14, 29),
(125, '10', 'C-3', 'lot-205', 'C-3', 15, 29),
(126, '10', 'C-3', 'lot-205', 'C-3', 16, 29),
(127, '10', 'C-3', 'lot-205', 'C-3', 17, 29),
(128, '10', 'C-3', 'lot-205', 'C-3', 18, 29),
(129, '0', 'C-3', 'lot-205', 'C-3', 19, 29),
(130, '0', 'C-3', 'lot-205', 'C-3', 20, 29),
(131, '0', 'C-3', 'lot-205', 'C-3', 21, 29),
(132, 'lot-205', 'C-3', 'lot-205', 'C-3', 22, 29),
(133, 'C-4', 'C-4', 'lot-205', 'C-4', 11, 29),
(134, '0', 'C-4', 'lot-205', 'C-4', 12, 29),
(135, '10', 'C-4', 'lot-205', 'C-4', 13, 29),
(136, '10', 'C-4', 'lot-205', 'C-4', 14, 29),
(137, '10', 'C-4', 'lot-205', 'C-4', 15, 29),
(138, '10', 'C-4', 'lot-205', 'C-4', 16, 29),
(139, '10', 'C-4', 'lot-205', 'C-4', 17, 29),
(140, '10', 'C-4', 'lot-205', 'C-4', 18, 29),
(141, '0', 'C-4', 'lot-205', 'C-4', 19, 29),
(142, '0', 'C-4', 'lot-205', 'C-4', 20, 29),
(143, '0', 'C-4', 'lot-205', 'C-4', 21, 29),
(144, 'lot-205', 'C-4', 'lot-205', 'C-4', 22, 29),
(145, 'C-5', 'C-5', 'lot-206', 'C-5', 11, 29),
(146, '0', 'C-5', 'lot-206', 'C-5', 12, 29),
(147, '10', 'C-5', 'lot-206', 'C-5', 13, 29),
(148, '10', 'C-5', 'lot-206', 'C-5', 14, 29),
(149, '10', 'C-5', 'lot-206', 'C-5', 15, 29),
(150, '10', 'C-5', 'lot-206', 'C-5', 16, 29),
(151, '10', 'C-5', 'lot-206', 'C-5', 17, 29),
(152, '10', 'C-5', 'lot-206', 'C-5', 18, 29),
(153, '0', 'C-5', 'lot-206', 'C-5', 19, 29),
(154, '0', 'C-5', 'lot-206', 'C-5', 20, 29),
(155, '0', 'C-5', 'lot-206', 'C-5', 21, 29),
(156, 'lot-206', 'C-5', 'lot-206', 'C-5', 22, 29),
(157, 'C-6', 'C-6', 'lot-206', 'C-6', 11, 29),
(158, '0', 'C-6', 'lot-206', 'C-6', 12, 29),
(159, '10', 'C-6', 'lot-206', 'C-6', 13, 29),
(160, '10', 'C-6', 'lot-206', 'C-6', 14, 29),
(161, '10', 'C-6', 'lot-206', 'C-6', 15, 29),
(162, '10', 'C-6', 'lot-206', 'C-6', 16, 29),
(163, '10', 'C-6', 'lot-206', 'C-6', 17, 29),
(164, '10', 'C-6', 'lot-206', 'C-6', 18, 29),
(165, '0', 'C-6', 'lot-206', 'C-6', 19, 29),
(166, '0', 'C-6', 'lot-206', 'C-6', 20, 29),
(167, '0', 'C-6', 'lot-206', 'C-6', 21, 29),
(168, 'lot-206', 'C-6', 'lot-206', 'C-6', 22, 29),
(181, 'C-7-1', 'C-7-1', 'lot-1', 'C-7', 11, 31),
(182, '0', 'C-7-1', 'lot-1', 'C-7', 12, 31),
(183, '0', 'C-7-1', 'lot-1', 'C-7', 13, 31),
(184, '0', 'C-7-1', 'lot-1', 'C-7', 14, 31),
(185, '0', 'C-7-1', 'lot-1', 'C-7', 15, 31),
(186, '0', 'C-7-1', 'lot-1', 'C-7', 16, 31),
(187, '0', 'C-7-1', 'lot-1', 'C-7', 17, 31),
(188, '0', 'C-7-1', 'lot-1', 'C-7', 18, 31),
(189, '0', 'C-7-1', 'lot-1', 'C-7', 19, 31),
(190, '0', 'C-7-1', 'lot-1', 'C-7', 20, 31),
(191, '0', 'C-7-1', 'lot-1', 'C-7', 21, 31),
(192, 'lot-1', 'C-7-1', 'lot-1', 'C-7', 22, 31),
(193, 'C-8-1', 'C-8-1', 'lot-1', 'C-8', 11, 31),
(194, '0', 'C-8-1', 'lot-1', 'C-8', 12, 31),
(195, '0', 'C-8-1', 'lot-1', 'C-8', 13, 31),
(196, '0', 'C-8-1', 'lot-1', 'C-8', 14, 31),
(197, '0', 'C-8-1', 'lot-1', 'C-8', 15, 31),
(198, '0', 'C-8-1', 'lot-1', 'C-8', 16, 31),
(199, '0', 'C-8-1', 'lot-1', 'C-8', 17, 31),
(200, '0', 'C-8-1', 'lot-1', 'C-8', 18, 31),
(201, '0', 'C-8-1', 'lot-1', 'C-8', 19, 31),
(202, '0', 'C-8-1', 'lot-1', 'C-8', 20, 31),
(203, '0', 'C-8-1', 'lot-1', 'C-8', 21, 31),
(204, 'lot-1', 'C-8-1', 'lot-1', 'C-8', 22, 31),
(205, 'lot-2', 'C9', 'lot-2', 'C-9', 23, 32),
(206, 'C-7-2', 'C-7-2', 'lot-1', 'C-7', 11, 31),
(207, 'C-7-3', 'C-7-3', 'lot-1', 'C-7', 11, 31),
(208, '0', 'C-7-2', 'lot-1', 'C-7', 12, 31),
(209, '0', 'C-7-3', 'lot-1', 'C-7', 12, 31),
(210, '0', 'C-7-2', 'lot-1', 'C-7', 13, 31),
(211, '0', 'C-7-3', 'lot-1', 'C-7', 13, 31),
(212, '0', 'C-7-2', 'lot-1', 'C-7', 14, 31),
(213, '0', 'C-7-3', 'lot-1', 'C-7', 14, 31),
(214, '0', 'C-7-2', 'lot-1', 'C-7', 15, 31),
(215, '0', 'C-7-3', 'lot-1', 'C-7', 15, 31),
(216, '0', 'C-7-2', 'lot-1', 'C-7', 16, 31),
(217, '0', 'C-7-3', 'lot-1', 'C-7', 16, 31),
(218, '0', 'C-7-2', 'lot-1', 'C-7', 17, 31),
(219, '0', 'C-7-3', 'lot-1', 'C-7', 17, 31),
(220, '0', 'C-7-2', 'lot-1', 'C-7', 18, 31),
(221, '0', 'C-7-3', 'lot-1', 'C-7', 18, 31),
(222, '0', 'C-7-2', 'lot-1', 'C-7', 19, 31),
(223, '0', 'C-7-3', 'lot-1', 'C-7', 19, 31),
(224, '0', 'C-7-2', 'lot-1', 'C-7', 20, 31),
(225, '0', 'C-7-3', 'lot-1', 'C-7', 20, 31),
(226, '0', 'C-7-2', 'lot-1', 'C-7', 21, 31),
(227, '0', 'C-7-3', 'lot-1', 'C-7', 21, 31),
(228, 'lot-1', 'C-7-2', 'lot-1', 'C-7', 22, 31),
(229, 'lot-1', 'C-7-3', 'lot-1', 'C-7', 22, 31),
(639, 'C-10', 'C-10', 'ffff', 'C-10', 11, 53),
(640, '0', 'C-10', 'ffff', 'C-10', 12, 53),
(641, '0', 'C-10', 'ffff', 'C-10', 13, 53),
(642, '0', 'C-10', 'ffff', 'C-10', 14, 53),
(643, '0', 'C-10', 'ffff', 'C-10', 15, 53),
(644, '0', 'C-10', 'ffff', 'C-10', 16, 53),
(645, '0', 'C-10', 'ffff', 'C-10', 17, 53),
(646, '0', 'C-10', 'ffff', 'C-10', 18, 53),
(647, '0', 'C-10', 'ffff', 'C-10', 19, 53),
(648, '0', 'C-10', 'ffff', 'C-10', 20, 53),
(649, '0', 'C-10', 'ffff', 'C-10', 21, 53),
(650, 'ffff', 'C-10', 'ffff', 'C-10', 22, 53),
(651, 'C-11', 'C11\r\n', 'ffff', 'C-11', 11, 53),
(652, '0', 'C-11', 'ffff', 'C-11', 12, 53),
(653, '0', 'C-11', 'ffff', 'C-11', 13, 53),
(654, '0', 'C-11', 'ffff', 'C-11', 14, 53),
(655, '0', 'C-11', 'ffff', 'C-11', 15, 53),
(656, '0', 'C-11', 'ffff', 'C-11', 16, 53),
(657, '0', 'C-11', 'ffff', 'C-11', 17, 53),
(658, '0', 'C-11', 'ffff', 'C-11', 18, 53),
(659, '0', 'C-11', 'ffff', 'C-11', 19, 53),
(660, '0', 'C-11', 'ffff', 'C-11', 20, 53),
(661, '0', 'C-11', 'ffff', 'C-11', 21, 53),
(662, 'ffff', 'C-11', 'ffff', 'C-11', 22, 53),
(663, 'C-12', 'C-12', 'xs', 'C-12', 11, 54),
(664, '0', 'C-12', 'xs', 'C-12', 12, 54),
(665, '10', 'C-12', 'xs', 'C-12', 13, 54),
(666, '10', 'C-12', 'xs', 'C-12', 14, 54),
(667, '10', 'C-12', 'xs', 'C-12', 15, 54),
(668, '10', 'C-12', 'xs', 'C-12', 16, 54),
(669, '10', 'C-12', 'xs', 'C-12', 17, 54),
(670, '10', 'C-12', 'xs', 'C-12', 18, 54),
(671, '523.5987755983', 'C-12', 'xs', 'C-12', 19, 54),
(672, '0', 'C-12', 'xs', 'C-12', 20, 54),
(673, '0', 'C-12', 'xs', 'C-12', 21, 54),
(674, 'xs', 'C-12', 'xs', 'C-12', 22, 54);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL COMMENT 'ชื่อเข้าใช้งาน',
  `password` varchar(200) NOT NULL COMMENT 'รหัสผ่าน',
  `name` varchar(200) DEFAULT NULL,
  `user_group_id` int(11) NOT NULL,
  `positions_id_1` int(11) NOT NULL COMMENT 'ตำแหน่ง',
  `positions_id_2` int(11) DEFAULT NULL COMMENT 'ตำแหน่งรักษาการ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `user_group_id`, `positions_id_1`, `positions_id_2`) VALUES
(1, 'admin', '356a192b7913b04c54574d18c28d46e6395428ab', 'it admin', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE `user_groups` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL COMMENT 'ชื่อกลุ่ม'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`id`, `name`) VALUES
(1, 'it');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL COMMENT 'ชื่อเจ้าของตัวอย่าง/ผู้ผลิต',
  `address` varchar(500) DEFAULT NULL COMMENT 'ที่อยู่',
  `type` int(11) NOT NULL COMMENT 'ประเภท (1=เจ้าของตัวอย่าง,2=ผู้ผลิต)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `name`, `address`, `type`) VALUES
(1, 'บริษัท ไทยเรืองอุตสาหกรรม จำกัด ', NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authens`
--
ALTER TABLE `authens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_authens_user_groups_idx` (`user_group_id`),
  ADD KEY `fk_authens_menus1_idx` (`menu_id`);

--
-- Indexes for table `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_invoices_requests1_idx` (`request_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`);

--
-- Indexes for table `labtypes`
--
ALTER TABLE `labtypes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_labtypes_materials1_idx` (`material_id`);

--
-- Indexes for table `labtype_inputs`
--
ALTER TABLE `labtype_inputs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_labtype_inputs_labtypes1_idx` (`labtype_id`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_menus_menu_groups1_idx` (`menu_group_id`);

--
-- Indexes for table `menu_groups`
--
ALTER TABLE `menu_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `request_no_UNIQUE` (`request_no`),
  ADD KEY `fk_requests_vendors1_idx` (`vendor_id`),
  ADD KEY `fk_requests_vendors2_idx` (`owner_id`),
  ADD KEY `fk_requests_jobs1_idx` (`job_id`),
  ADD KEY `fk_requests_contracts1_idx` (`contract_id`);

--
-- Indexes for table `request_standards`
--
ALTER TABLE `request_standards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_request_standards_labtypes1_idx` (`labtype_id`),
  ADD KEY `fk_request_standards_requests1_idx` (`request_id`),
  ADD KEY `fk_request_standards_standards1_idx` (`standard_id`);

--
-- Indexes for table `retests`
--
ALTER TABLE `retests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_retests_request_standards1_idx` (`request_standard_id`);

--
-- Indexes for table `standards`
--
ALTER TABLE `standards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `standard_parameters`
--
ALTER TABLE `standard_parameters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_standard_parameters_labtype_inputs1_idx` (`labtype_input_id`),
  ADD KEY `fk_standard_parameters_standards1_idx` (`standard_id`);

--
-- Indexes for table `temp_retests`
--
ALTER TABLE `temp_retests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_temp_retests_request_standards1_idx` (`request_standard_id`);

--
-- Indexes for table `temp_sampling_no`
--
ALTER TABLE `temp_sampling_no`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_standard_parameters`
--
ALTER TABLE `temp_standard_parameters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_standard_parameters_labtype_inputs1_idx` (`labtype_input_id`),
  ADD KEY `fk_standard_parameters_standards1_idx` (`standard_id`);

--
-- Indexes for table `test_results_headers`
--
ALTER TABLE `test_results_headers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_test_results_headers_requests1_idx` (`request_id`);

--
-- Indexes for table `test_results_values`
--
ALTER TABLE `test_results_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_test_results_values_labtype_inputs1_idx` (`labtype_input_id`),
  ADD KEY `fk_test_results_values_request_standards1_idx` (`request_standard_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`),
  ADD KEY `fk_users_user_groups1_idx` (`user_group_id`),
  ADD KEY `fk_users_positions1_idx` (`positions_id_1`);

--
-- Indexes for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authens`
--
ALTER TABLE `authens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `contracts`
--
ALTER TABLE `contracts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `labtypes`
--
ALTER TABLE `labtypes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `labtype_inputs`
--
ALTER TABLE `labtype_inputs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `menu_groups`
--
ALTER TABLE `menu_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `request_standards`
--
ALTER TABLE `request_standards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
--
-- AUTO_INCREMENT for table `retests`
--
ALTER TABLE `retests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `standards`
--
ALTER TABLE `standards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `standard_parameters`
--
ALTER TABLE `standard_parameters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `temp_retests`
--
ALTER TABLE `temp_retests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `temp_sampling_no`
--
ALTER TABLE `temp_sampling_no`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `temp_standard_parameters`
--
ALTER TABLE `temp_standard_parameters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `test_results_headers`
--
ALTER TABLE `test_results_headers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `test_results_values`
--
ALTER TABLE `test_results_values`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=675;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
