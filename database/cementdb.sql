-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 01, 2024 at 03:03 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cementdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `a_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`a_id`, `name`, `phone`, `email`, `password`, `image`) VALUES
(1, 'admin', '0785389123', 'admin@gmail.com', 'ecd00aa1acd325ba7575cb0f638b04a5', '2024022714192401160531_MG_5056-Recovered.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `analytic_data`
--

CREATE TABLE `analytic_data` (
  `ad_id` int(11) NOT NULL,
  `r_fk_id` int(11) DEFAULT NULL,
  `metric` varchar(100) DEFAULT NULL,
  `value` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `approve_user`
--

CREATE TABLE `approve_user` (
  `au_id` int(11) NOT NULL,
  `user_fk_id` int(11) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `block_user_account`
--

CREATE TABLE `block_user_account` (
  `bua_id` int(11) NOT NULL,
  `user_fk_id` int(11) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `dates` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `file_storage`
--

CREATE TABLE `file_storage` (
  `fs_id` int(11) NOT NULL,
  `file_name` varchar(100) DEFAULT NULL,
  `file_path` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `file_storage`
--

INSERT INTO `file_storage` (`fs_id`, `file_name`, `file_path`) VALUES
(3, 'test', '202402201235Bikman CV.docx'),
(4, 'Rav4', '202402201243files.rar');

-- --------------------------------------------------------

--
-- Table structure for table `online_users`
--

CREATE TABLE `online_users` (
  `ou_id` int(11) NOT NULL,
  `status` varchar(100) DEFAULT NULL,
  `period` varchar(100) DEFAULT NULL,
  `user_fk_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `online_users`
--

INSERT INTO `online_users` (`ou_id`, `status`, `period`, `user_fk_id`) VALUES
(2, 'OFF', '2024-03-01 15:02:20', 20),
(3, 'OFF', '2024-03-01 15:02:33', 21);

-- --------------------------------------------------------

--
-- Table structure for table `raw_material`
--

CREATE TABLE `raw_material` (
  `rm_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `quantity_stored` int(11) DEFAULT NULL,
  `quantity_consumed` int(11) DEFAULT NULL,
  `unit` varchar(100) DEFAULT NULL,
  `consumed_time` varchar(100) DEFAULT NULL,
  `consumed_descr` text DEFAULT NULL,
  `user_fk_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `raw_material`
--

INSERT INTO `raw_material` (`rm_id`, `name`, `description`, `quantity_stored`, `quantity_consumed`, `unit`, `consumed_time`, `consumed_descr`, `user_fk_id`) VALUES
(16, 'Limestone', 'It is the primary raw material used in cement manufacturing and provides the calcium component necessary for making the cementitious compounds', 4800, 0, 'Kg', '2024-02-29 6:33:48', NULL, NULL),
(17, 'Clay or Shale', 'These materials provide the silica, alumina, and iron oxide needed to form the cement clinker during the kiln phase of cement production', 6200, 857, 'Kg', '2024-03-01 10:04:34', 'consumed', 20),
(19, 'Iron Ore', 'These materials provide the iron oxide component, which contributes to the color and properties of the cement', 7500, 1200, 'Kg', '2024-02-29 11:33:48', 'test', 20),
(20, 'Fly Ash', 'It is a byproduct of coal combustion and is sometimes used as a supplementary cementitious material to improve the properties of cement', 12400, 10012, 'Kg', '2024-02-29 11:33:48', 'consumed', 20),
(24, 'Gypsum', 'It is added to regulate the setting time of cement and prevent flash setting', 23500, 12300, 'Kg', '2024-02-29 10:33:48', 'consumed', 21),
(25, 'Sand or Silica', 'It provides additional silica, which helps control the setting time of cement and influences its strength development', 25000, 0, 'Kg', '2024-02-29 11:33:48', '', 21);

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `r_id` int(11) NOT NULL,
  `rm_fk_id` int(11) DEFAULT NULL,
  `rdate` varchar(50) DEFAULT NULL,
  `user_fk_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `u_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `name`, `phone`, `email`, `password`, `image`) VALUES
(20, 'User1', '0785389000', 'user1@gmail.com', '6ad14ba9986e3615423dfca256d04e3f', '202402191214202301161524EVU0Es7XYAAbNf2.jpg'),
(21, 'User2', '0785389001', 'user2@gmail.com', '6ad14ba9986e3615423dfca256d04e3f', '2024030109102306240850FB_IMG_15248438600858553.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `analytic_data`
--
ALTER TABLE `analytic_data`
  ADD PRIMARY KEY (`ad_id`),
  ADD KEY `r_fk_id` (`r_fk_id`);

--
-- Indexes for table `approve_user`
--
ALTER TABLE `approve_user`
  ADD PRIMARY KEY (`au_id`),
  ADD KEY `user_fk_id` (`user_fk_id`);

--
-- Indexes for table `block_user_account`
--
ALTER TABLE `block_user_account`
  ADD PRIMARY KEY (`bua_id`),
  ADD KEY `user_fk_id` (`user_fk_id`);

--
-- Indexes for table `file_storage`
--
ALTER TABLE `file_storage`
  ADD PRIMARY KEY (`fs_id`);

--
-- Indexes for table `online_users`
--
ALTER TABLE `online_users`
  ADD PRIMARY KEY (`ou_id`),
  ADD KEY `user_fk_id` (`user_fk_id`);

--
-- Indexes for table `raw_material`
--
ALTER TABLE `raw_material`
  ADD PRIMARY KEY (`rm_id`),
  ADD KEY `fk_user` (`user_fk_id`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`r_id`),
  ADD KEY `user_fk_id` (`user_fk_id`),
  ADD KEY `rm_fk_id` (`rm_fk_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `analytic_data`
--
ALTER TABLE `analytic_data`
  MODIFY `ad_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `approve_user`
--
ALTER TABLE `approve_user`
  MODIFY `au_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `block_user_account`
--
ALTER TABLE `block_user_account`
  MODIFY `bua_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `file_storage`
--
ALTER TABLE `file_storage`
  MODIFY `fs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `online_users`
--
ALTER TABLE `online_users`
  MODIFY `ou_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `raw_material`
--
ALTER TABLE `raw_material`
  MODIFY `rm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `analytic_data`
--
ALTER TABLE `analytic_data`
  ADD CONSTRAINT `analytic_data_ibfk_1` FOREIGN KEY (`r_fk_id`) REFERENCES `report` (`r_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `approve_user`
--
ALTER TABLE `approve_user`
  ADD CONSTRAINT `approve_user_ibfk_1` FOREIGN KEY (`user_fk_id`) REFERENCES `users` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `block_user_account`
--
ALTER TABLE `block_user_account`
  ADD CONSTRAINT `block_user_account_ibfk_1` FOREIGN KEY (`user_fk_id`) REFERENCES `users` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `online_users`
--
ALTER TABLE `online_users`
  ADD CONSTRAINT `online_users_ibfk_1` FOREIGN KEY (`user_fk_id`) REFERENCES `users` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `raw_material`
--
ALTER TABLE `raw_material`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_fk_id`) REFERENCES `users` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `report`
--
ALTER TABLE `report`
  ADD CONSTRAINT `report_ibfk_1` FOREIGN KEY (`user_fk_id`) REFERENCES `users` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `report_ibfk_2` FOREIGN KEY (`rm_fk_id`) REFERENCES `raw_material` (`rm_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
