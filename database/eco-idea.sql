-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2018 at 10:55 AM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eco-idea`
--

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `id` int(11) NOT NULL,
  `device_type_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `device_unique_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_implemented` date NOT NULL,
  `status` smallint(6) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `devices`
--

INSERT INTO `devices` (`id`, `device_type_id`, `user_id`, `device_unique_id`, `date_implemented`, `status`, `description`, `image`) VALUES
(6, 1, 1, 'DEV001', '2018-02-26', 0, '', 'arduino_board_5a93ca0856f267_13254688.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `device_config_records`
--

CREATE TABLE `device_config_records` (
  `id` int(11) NOT NULL,
  `device_id` int(11) DEFAULT NULL,
  `attribute` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `device_config_records`
--

INSERT INTO `device_config_records` (`id`, `device_id`, `attribute`, `value`) VALUES
(5, 6, 'automatic_mode_enable', '1'),
(6, 6, 'send_data_to_server_interval', '5'),
(7, 6, 'send_state_to_server_interval', '5'),
(8, 6, 'get_command_from_server_interval', '5');

-- --------------------------------------------------------

--
-- Table structure for table `device_receive_records`
--

CREATE TABLE `device_receive_records` (
  `id` int(11) NOT NULL,
  `device_id` int(11) DEFAULT NULL,
  `temperature` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `moisture` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `light` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `received_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `device_receive_records`
--

INSERT INTO `device_receive_records` (`id`, `device_id`, `temperature`, `moisture`, `light`, `received_datetime`) VALUES
(8, 6, '10', '20', '30', '2018-02-26 10:12:50'),
(9, 6, '10', '20', '30', '2018-02-26 10:30:33'),
(10, 6, '15', '20', '30', '2018-02-26 10:30:35'),
(11, 6, '15', '21', '30', '2018-02-26 10:30:37');

-- --------------------------------------------------------

--
-- Table structure for table `device_types`
--

CREATE TABLE `device_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `device_types`
--

INSERT INTO `device_types` (`id`, `name`, `description`) VALUES
(1, 'Smart Farm', 'Giải pháp nông nghiệp thông minh');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `is_admin`) VALUES
('1', 'Administrator', 1),
('2', 'Customer', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_created` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pwd_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pwd_reset_token_creation_date` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `full_name`, `password`, `date_created`, `status`, `pwd_reset_token`, `pwd_reset_token_creation_date`) VALUES
(1, 'phamtheanhphu@gmail.com', 'Phu Pham', '$2y$10$BzuBpFvOdh/BWXRUPoX3y.vOGGM9g.7EH1MJ087YgEXX/wR9.b3IO', '2018-02-22 11:34:16', '1', NULL, NULL),
(6, 'test@gmail.com', 'Test 1', '$2y$10$oxvuWL5HJP4GPhOLEX8STeHn5crxEOi.An2T2QaI43vgrotneUpMK', '2018-02-26 03:49:39', '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_group_maps`
--

CREATE TABLE `user_group_maps` (
  `user_id` int(11) NOT NULL,
  `group_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_group_maps`
--

INSERT INTO `user_group_maps` (`user_id`, `group_id`) VALUES
(1, '1'),
(6, '2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_11074E9A4FFA550E` (`device_type_id`),
  ADD KEY `IDX_11074E9AA76ED395` (`user_id`);

--
-- Indexes for table `device_config_records`
--
ALTER TABLE `device_config_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_4FCC6B4694A4C7D4` (`device_id`);

--
-- Indexes for table `device_receive_records`
--
ALTER TABLE `device_receive_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8469642094A4C7D4` (`device_id`);

--
-- Indexes for table `device_types`
--
ALTER TABLE `device_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_9FB569575E237E06` (`name`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_group_maps`
--
ALTER TABLE `user_group_maps`
  ADD PRIMARY KEY (`user_id`,`group_id`),
  ADD KEY `IDX_C9139539A76ED395` (`user_id`),
  ADD KEY `IDX_C9139539FE54D947` (`group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `device_config_records`
--
ALTER TABLE `device_config_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `device_receive_records`
--
ALTER TABLE `device_receive_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `device_types`
--
ALTER TABLE `device_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `devices`
--
ALTER TABLE `devices`
  ADD CONSTRAINT `FK_11074E9A4FFA550E` FOREIGN KEY (`device_type_id`) REFERENCES `device_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_11074E9AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `device_config_records`
--
ALTER TABLE `device_config_records`
  ADD CONSTRAINT `FK_4FCC6B4694A4C7D4` FOREIGN KEY (`device_id`) REFERENCES `devices` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `device_receive_records`
--
ALTER TABLE `device_receive_records`
  ADD CONSTRAINT `FK_8469642094A4C7D4` FOREIGN KEY (`device_id`) REFERENCES `devices` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_group_maps`
--
ALTER TABLE `user_group_maps`
  ADD CONSTRAINT `FK_C9139539A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_C9139539FE54D947` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
