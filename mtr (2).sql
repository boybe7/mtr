-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2016 at 01:21 PM
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
  `request_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(2, 'ความถ่วงจำเพาะ', 'SPECIFIC GRAVITY OF FLOAT VALVE', '200.00', 0, 14),
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
  `labtype_id` int(11) NOT NULL COMMENT 'วิธีการทดสอบ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `labtype_inputs`
--

INSERT INTO `labtype_inputs` (`id`, `name`, `col_index`, `formula`, `type`, `labtype_id`) VALUES
(6, 'A', 'A', '', 'header', 1),
(7, 'B', 'B', '', 'header', 1),
(10, 'Z', 'Z', '', 'raw', 1),
(11, 'SPECIMEN MARK', 'A', '', 'header', 2),
(12, 'SIZE OF AIR VALVE (MM.)', 'D', '', 'header', 2),
(13, 'MEASURE DIAMETER (CM.)', 'E', 'avg($N,$O,$P,$Q,$R)', 'header', 2),
(14, 'AIR VALVE DIAMETER 1 (CM.)', 'N', '', 'raw', 2),
(15, 'AIR VALVE DIAMETER 2 (CM.)', 'O', '', 'raw', 2),
(16, 'AIR VALVE DIAMETER 3 (CM.)', 'P', '', 'raw', 2),
(17, 'AIR VALVE DIAMETER 4 (CM.)', 'Q', '', 'raw', 2),
(18, 'AIR VALVE DIAMETER 5 (CM.)', 'R', '', 'raw', 2),
(19, 'VOLUME (CM^3.)', 'F', '(pi()*pow($E,3))/6', 'header', 2),
(20, 'WEIGHT (GM.)', 'G', '', 'header', 2),
(21, 'SPECIFIC GRAVITY', 'H', 'G/F', 'header', 2),
(22, 'REMARK', 'I', '', 'header', 2);

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
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `request_no`, `date`, `vendor_id`, `owner_id`, `job_id`, `contract_id`, `detail`, `status`) VALUES
(1, '1/2559', '2016-05-25', NULL, 1, 1, 1, NULL, 0);

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
  `note` varchar(400) DEFAULT NULL COMMENT 'หมายเหตุ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `request_standards`
--

INSERT INTO `request_standards` (`id`, `material_detail`, `lot_no`, `lot_num`, `sampling_num`, `cost`, `labtype_id`, `request_id`, `standard_id`, `conclude`, `note`) VALUES
(1, 'xxxxxxx', 'lot1,lot2', 2, 6, '500.00', 2, 1, 3, NULL, NULL),
(2, 'xxxxxxx', 'lot1,lot2', 2, 6, '500.00', 3, 1, 4, NULL, NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `request_standards`
--
ALTER TABLE `request_standards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `retests`
--
ALTER TABLE `retests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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
-- AUTO_INCREMENT for table `temp_standard_parameters`
--
ALTER TABLE `temp_standard_parameters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `test_results_headers`
--
ALTER TABLE `test_results_headers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `test_results_values`
--
ALTER TABLE `test_results_values`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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
