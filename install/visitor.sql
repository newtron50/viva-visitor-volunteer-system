-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 28, 2018 at 05:56 PM
-- Server version: 5.6.35-1+deb.sury.org~xenial+0.1
-- PHP Version: 5.6.31-6+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `visitor`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`user_id`, `name`, `username`, `password`, `admin_level`) VALUES
(1, 'admin', 'admin', '$2y$10$FTNduWjwAO6CRk81B9lZ6eVlbZM.qzsoaFmG4HYM0.pmhpVGKjzIO', 9);

-- --------------------------------------------------------

--
-- Table structure for table `admin_levels`
--

CREATE TABLE `admin_levels` (
  `admin_lvl_name` varchar(20) NOT NULL,
  `level` int(1) NOT NULL,
  `explaination` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_levels`
--

INSERT INTO `admin_levels` (`admin_lvl_name`, `level`, `explaination`) VALUES
('User', 0, NULL),
('Desk', 4, NULL),
('Data Entry', 5, NULL),
('Coordinator', 6, NULL),
('Asst. Admin', 7, NULL),
('Administrator', 8, NULL),
('Super Admin', 9, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `barcodes`
--

CREATE TABLE `barcodes` (
  `barcode` int(50) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `login_record`
--

CREATE TABLE `login_record` (
  `rec` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` varchar(15) NOT NULL,
  `ip_addr` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `log_req`
--

CREATE TABLE `log_req` (
  `rec` int(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `login` date NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `people`
--

CREATE TABLE `people` (
  `record_num` int(12) NOT NULL,
  `user_id` int(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `phone` varchar(12) DEFAULT NULL,
  `other_phone` varchar(12) DEFAULT NULL,
  `cell` varchar(12) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `family_grp` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `record_log`
--

CREATE TABLE `record_log` (
  `record_num` int(50) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `type` varchar(5) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `reason` varchar(150) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `barcode_assign` varchar(50) NOT NULL,
  `code_out` datetime DEFAULT NULL,
  `code_in` datetime DEFAULT NULL,
  `vol_class` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `school` varchar(50) NOT NULL,
  `school_short_name` varchar(50) NOT NULL,
  `site` varchar(50) NOT NULL,
  `location` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `site_phone` varchar(50) NOT NULL,
  `site_email` varchar(50) NOT NULL,
  `site_contact` varchar(50) NOT NULL,
  `site_url` varchar(50) NOT NULL,
  `site_webpage_url` varchar(50) NOT NULL,
  `sta_location` varchar(75) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `target_hrs`
--

CREATE TABLE `target_hrs` (
  `grp_num` int(5) NOT NULL,
  `target_grp` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `volunteer_classes`
--

CREATE TABLE `volunteer_classes` (
  `id` int(11) NOT NULL,
  `v_class_name` varchar(60) NOT NULL,
  `level` int(11) DEFAULT NULL,
  `level_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `volunteer_classes`
--

INSERT INTO `volunteer_classes` (`id`, `v_class_name`, `level`, `level_name`) VALUES
(0, 'Visitor', NULL, ''),
(1, 'Volunteer', 15, '');

-- --------------------------------------------------------

--
-- Table structure for table `volunteer_subjects`
--

CREATE TABLE `volunteer_subjects` (
  `sub_index` int(3) NOT NULL,
  `v_sub_name` varchar(120) NOT NULL,
  `v_sub_class` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vol_log`
--

CREATE TABLE `vol_log` (
  `record` int(10) NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `vol_date` varchar(30) NOT NULL,
  `vol_time_ttl` time NOT NULL,
  `vol_class` varchar(30) NOT NULL,
  `vol_subject` varchar(50) NOT NULL,
  `entered_by` varchar(50) NOT NULL,
  `entry_date` varchar(30) NOT NULL,
  `family_grp` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `admin_levels`
--
ALTER TABLE `admin_levels`
  ADD PRIMARY KEY (`level`);

--
-- Indexes for table `login_record`
--
ALTER TABLE `login_record`
  ADD PRIMARY KEY (`rec`);

--
-- Indexes for table `log_req`
--
ALTER TABLE `log_req`
  ADD PRIMARY KEY (`rec`);

--
-- Indexes for table `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`record_num`);

--
-- Indexes for table `record_log`
--
ALTER TABLE `record_log`
  ADD PRIMARY KEY (`record_num`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `volunteer_classes`
--
ALTER TABLE `volunteer_classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `volunteer_subjects`
--
ALTER TABLE `volunteer_subjects`
  ADD PRIMARY KEY (`sub_index`);

--
-- Indexes for table `vol_log`
--
ALTER TABLE `vol_log`
  ADD PRIMARY KEY (`record`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `login_record`
--
ALTER TABLE `login_record`
  MODIFY `rec` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `log_req`
--
ALTER TABLE `log_req`
  MODIFY `rec` int(100) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `people`
--
ALTER TABLE `people`
  MODIFY `record_num` int(12) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `record_log`
--
ALTER TABLE `record_log`
  MODIFY `record_num` int(50) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `volunteer_classes`
--
ALTER TABLE `volunteer_classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `volunteer_subjects`
--
ALTER TABLE `volunteer_subjects`
  MODIFY `sub_index` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `vol_log`
--
ALTER TABLE `vol_log`
  MODIFY `record` int(10) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
