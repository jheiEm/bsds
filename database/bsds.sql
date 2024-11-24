-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2024 at 12:26 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bsds`
--

-- --------------------------------------------------------

--
-- Table structure for table `client_list`
--

CREATE TABLE `client_list` (
  `id` int(30) NOT NULL,
  `firstname` text NOT NULL,
  `middlename` text DEFAULT NULL,
  `lastname` text NOT NULL,
  `gender` text NOT NULL,
  `contact` text NOT NULL,
  `address` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `image_path` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_added` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client_list`
--

INSERT INTO `client_list` (`id`, `firstname`, `middlename`, `lastname`, `gender`, `contact`, `address`, `email`, `password`, `image_path`, `status`, `delete_flag`, `date_created`, `date_added`) VALUES
(4, 'test', 'test', 'test', 'Male', '09251235545', 'test', 'j@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', NULL, 1, 0, '2023-06-21 21:32:27', NULL),
(5, 'Jeshua', 'Faala', 'Meru', 'Male', '09686699802', 'Lipa City', 'merujeshua14@gmail.co', '26519bf526c74b0afa61f2eb9341f1f3', NULL, 1, 0, '2023-08-18 16:56:04', NULL),
(6, 'Jeshua', 'Faala', 'Meru', 'Male', '09686699802i', 'Lipa', 'merujeshua14@gmail.com', '26519bf526c74b0afa61f2eb9341f1f3', NULL, 1, 0, '2023-08-18 16:59:00', NULL),
(7, 'Rosalia', 'Manalo', 'Vinas', 'Female', '9557834278', 'Purok 1, Kayumangi Lipa City', 'rvinas@gmail.com', '2608d151a651a7340311c465be385189', NULL, 1, 0, '2023-09-05 21:34:22', NULL),
(8, 'jeshua', 'f', 'meru', 'Male', '09686699802', 'lipacuty', 'merujeshua@gmail.com', 'f2fc9c769effa56554ad6da756c9d8b2', NULL, 1, 0, '2024-10-14 15:08:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `codes`
--

CREATE TABLE `codes` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `code` varchar(5) NOT NULL,
  `expire` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `codes`
--

INSERT INTO `codes` (`id`, `email`, `code`, `expire`) VALUES
(0, 'shielasantos14344@gmail.com', '72956', 1686324952),
(0, 'shielasantos14344@gmail.com', '62982', 1686325044),
(0, 'jardzdc@gmail.com', '49749', 1686326199),
(0, 'jardzdc@gmail.com', '95074', 1686327869),
(0, 'shielasantos14344@gmail.com', '14198', 1686659400),
(0, 'shielasantos14344@gmail.com', '78471', 1686660622),
(0, 'shielasantos14344@gmail.com', '60131', 1686661621),
(0, 'shielasantos14344@gmail.com', '90585', 1686661908),
(0, 'shielasantos14344@gmail.com', '84190', 1686666372),
(0, 'alandesagunjr@gmail.com', '81148', 1687151830),
(0, 'alandesagunjr@gmail.com', '20944', 1687151922),
(0, 'merujeshua14@gmail.com', '97022', 1728977879),
(0, 'merujeshua14@gmail.com', '51954', 1728981189);

-- --------------------------------------------------------

--
-- Table structure for table `individual_list`
--

CREATE TABLE `individual_list` (
  `id` int(11) NOT NULL,
  `tracking_code` varchar(50) NOT NULL,
  `mother_fullname` varchar(200) NOT NULL,
  `father_fullname` varchar(200) NOT NULL,
  `firstname` text NOT NULL,
  `middlename` text NOT NULL,
  `lastname` text NOT NULL,
  `gender` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `age` varchar(200) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=pending, 1=Partially Vaccinated, 2= Fully Vaccinated',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `status_client` tinyint(1) NOT NULL,
  `email` varchar(100) NOT NULL,
  `schedule` datetime NOT NULL,
  `schedule_2` datetime NOT NULL,
  `schedule_3` datetime NOT NULL,
  `vaccination_type` varchar(200) NOT NULL,
  `vaccination_name` varchar(200) NOT NULL,
  `remarks` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patient_list`
--

CREATE TABLE `patient_list` (
  `id` int(30) NOT NULL,
  `firstname` text NOT NULL,
  `middlename` text NOT NULL,
  `lastname` text NOT NULL,
  `suffix` varchar(10) NOT NULL,
  `philhealth_no` varchar(200) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `age` varchar(100) NOT NULL,
  `contact` varchar(200) NOT NULL,
  `address` text NOT NULL,
  `bp` varchar(40) NOT NULL,
  `temperature` varchar(40) NOT NULL,
  `rr` varchar(40) NOT NULL,
  `pr` varchar(40) NOT NULL,
  `disease` varchar(100) NOT NULL,
  `complaints` varchar(500) NOT NULL,
  `prescription` varchar(200) NOT NULL,
  `doctor` varchar(200) NOT NULL,
  `remarks` varchar(200) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'Batangas Province Scholarship Disbursement System'),
(6, 'short_name', 'Batangas - SDS'),
(11, 'logo', 'uploads/Batangas_Seal.png'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/gradient_bg.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `email` varchar(200) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `location_id` int(30) DEFAULT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `username`, `password`, `avatar`, `last_login`, `type`, `location_id`, `date_added`, `date_updated`) VALUES
(1, 'Administrator', 'Admin', 'merujeshua14@gmail.com', 'admin', 'f2fc9c769effa56554ad6da756c9d8b2', 'uploads/1624240500_avatar.png', NULL, 1, NULL, '2021-01-20 14:02:37', '2024-10-15 08:07:51'),
(7, 'jm', 'meru', 'jeshuameru27@gmail.com', 'staff', 'f2fc9c769effa56554ad6da756c9d8b2', NULL, NULL, 2, 6, '2024-10-15 08:11:51', NULL),
(8, 'jm', 'meru', 'jeshuameru27@gmail.com', 'staff123', 'f2fc9c769effa56554ad6da756c9d8b2', NULL, NULL, 2, 6, '2024-10-15 08:12:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vaccination_location_list`
--

CREATE TABLE `vaccination_location_list` (
  `id` int(30) NOT NULL,
  `location` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vaccination_location_list`
--

INSERT INTO `vaccination_location_list` (`id`, `location`, `status`, `date_created`) VALUES
(7, 'Lipa City', 1, '2024-10-15 13:48:52'),
(8, 'Batangas City', 1, '2024-10-15 13:49:01'),
(9, 'Tanauan City', 1, '2024-10-15 13:49:20');

-- --------------------------------------------------------

--
-- Table structure for table `vaccine_history_list`
--

CREATE TABLE `vaccine_history_list` (
  `id` int(30) NOT NULL,
  `user_id` int(30) DEFAULT NULL,
  `individual_id` int(30) NOT NULL,
  `vaccine_id` int(30) NOT NULL,
  `location_id` int(30) NOT NULL,
  `vaccination_type` varchar(50) NOT NULL,
  `vaccinated_by` text NOT NULL,
  `remarks` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vaccine_list`
--

CREATE TABLE `vaccine_list` (
  `id` int(30) NOT NULL,
  `name` varchar(250) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vaccine_list`
--

INSERT INTO `vaccine_list` (`id`, `name`, `status`, `date_created`) VALUES
(20, 'Governor Scholarship', 1, '2024-10-15 13:47:49'),
(21, 'Gov Mandanas Scholarship', 1, '2024-10-15 13:48:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client_list`
--
ALTER TABLE `client_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `individual_list`
--
ALTER TABLE `individual_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vaccination_location_list`
--
ALTER TABLE `vaccination_location_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vaccine_history_list`
--
ALTER TABLE `vaccine_history_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `vaccine_id` (`vaccine_id`),
  ADD KEY `location_id` (`location_id`),
  ADD KEY `individual_id` (`individual_id`);

--
-- Indexes for table `vaccine_list`
--
ALTER TABLE `vaccine_list`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `client_list`
--
ALTER TABLE `client_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `individual_list`
--
ALTER TABLE `individual_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `vaccination_location_list`
--
ALTER TABLE `vaccination_location_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `vaccine_history_list`
--
ALTER TABLE `vaccine_history_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `vaccine_list`
--
ALTER TABLE `vaccine_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `vaccine_history_list`
--
ALTER TABLE `vaccine_history_list`
  ADD CONSTRAINT `vaccine_history_list_ibfk_1` FOREIGN KEY (`vaccine_id`) REFERENCES `vaccine_list` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vaccine_history_list_ibfk_3` FOREIGN KEY (`location_id`) REFERENCES `vaccination_location_list` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vaccine_history_list_ibfk_6` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `vaccine_history_list_ibfk_7` FOREIGN KEY (`individual_id`) REFERENCES `individual_list` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
