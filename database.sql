-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 30, 2021 at 09:11 AM
-- Server version: 8.0.25
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `antrian_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `file`
--

CREATE TABLE `file` (
  `id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `mime` varchar(255) DEFAULT NULL,
  `dir` varchar(255) DEFAULT NULL,
  `table` varchar(255) DEFAULT NULL,
  `table_id` int DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `file`
--

INSERT INTO `file` (`id`, `name`, `mime`, `dir`, `table`, `table_id`, `status`, `created_at`, `updated_at`) VALUES
(1, '6950c16c9bcc6995f376b297f163175956965.png', 'image/png', 'webfile/6950c16c9bcc6995f376b297f163175956965.png', 'user', 1, NULL, NULL, '2021-09-25 21:00:28'),
(2, '', '', '', 'user', 23, 'ENABLE', '2021-09-26 22:26:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `locket`
--

CREATE TABLE `locket` (
  `id` int NOT NULL,
  `code` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `json_service` json DEFAULT NULL,
  `status` enum('ENABLE','DISABLE') CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `locket`
--

INSERT INTO `locket` (`id`, `code`, `name`, `description`, `json_service`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(23, 'A', 'LOKET 1', 'Loket untuk melayani Customer Service dan Teller ', '[{\"id\": \"23\", \"name\": \"CUSTOMER SERVICE\"}, {\"id\": \"24\", \"name\": \"TELLER\"}]', 'ENABLE', NULL, 1, '2021-09-27 15:12:39', NULL),
(24, 'B', 'LOKET 2', 'Loket untuk melayani Customer Service', '[{\"id\": \"23\", \"name\": \"CUSTOMER SERVICE\"}]', 'ENABLE', NULL, 1, '2021-09-27 15:10:35', NULL),
(25, 'C', 'LOKET 3', 'Loket untuk melayani Teller', '[{\"id\": \"24\", \"name\": \"TELLER\"}]', 'ENABLE', NULL, 1, '2021-09-27 15:10:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id` int NOT NULL,
  `activity` text,
  `user_id` int NOT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`id`, `activity`, `user_id`, `date`) VALUES
(1, 'melakukan login', 1, '2021-09-29 19:51:56'),
(2, 'memanggil nomor antrian A001', 1, '2021-09-29 19:51:46'),
(3, 'membatalkan nomor antrian ', 1, '2021-09-29 19:52:00'),
(4, 'memanggil nomor antrian A010', 1, '2021-09-29 19:52:03'),
(5, 'memanggil nomor antrian A009', 1, '2021-09-29 19:52:21'),
(6, 'memanggil nomor antrian A008', 1, '2021-09-29 19:53:11'),
(7, 'memanggil nomor antrian A011', 1, '2021-09-29 19:54:21'),
(8, 'memanggil nomor antrian A011', 1, '2021-09-29 19:54:29'),
(9, 'membatalkan nomor antrian ', 1, '2021-09-29 19:54:36'),
(10, 'melakukan login', 1, '2021-09-30 16:09:35');

-- --------------------------------------------------------

--
-- Table structure for table `queue`
--

CREATE TABLE `queue` (
  `id` int NOT NULL,
  `number` varchar(20) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `date_call` datetime DEFAULT NULL,
  `date_finish` datetime DEFAULT NULL,
  `locket_id` int DEFAULT NULL,
  `service_id` int DEFAULT NULL,
  `status` enum('pending','call','finish','reject') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'pending',
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `queue`
--

INSERT INTO `queue` (`id`, `number`, `date`, `date_call`, `date_finish`, `locket_id`, `service_id`, `status`, `user_id`) VALUES
(1, 'A001', '2021-09-26 20:49:21', NULL, NULL, 23, 24, 'pending', NULL),
(2, 'A002', '2021-09-26 20:49:48', NULL, NULL, 23, 24, 'pending', NULL),
(3, 'A003', '2021-09-26 20:49:49', NULL, NULL, 23, 24, 'pending', NULL),
(4, 'A004', '2021-09-26 20:49:50', NULL, NULL, 23, 24, 'pending', NULL),
(5, 'B001', '2021-09-26 20:49:55', NULL, NULL, 24, 23, 'pending', NULL),
(6, 'B002', '2021-09-26 20:49:55', NULL, NULL, 24, 23, 'pending', NULL),
(7, 'B003', '2021-09-26 20:49:55', NULL, NULL, 24, 23, 'pending', NULL),
(8, 'A001', '2021-09-27 15:22:55', '2021-09-27 17:25:59', '2021-09-29 19:51:19', 23, 23, 'finish', 1),
(9, 'A001', '2021-09-27 15:22:55', '2021-09-27 16:33:00', '2021-09-27 16:55:59', 23, 23, 'finish', 1),
(10, 'A003', '2021-09-27 15:22:55', '2021-09-27 16:34:47', '2021-09-27 16:55:59', 23, 23, 'finish', 1),
(11, 'A004', '2021-09-27 15:22:56', '2021-09-27 16:55:59', '2021-09-27 16:56:43', 23, 23, 'finish', 1),
(12, 'A005', '2021-09-27 15:22:56', '2021-09-27 16:56:43', '2021-09-27 16:58:39', 23, 23, 'finish', 1),
(13, 'A006', '2021-09-27 15:22:56', '2021-09-27 16:58:58', '2021-09-27 16:59:01', 23, 23, 'finish', 1),
(14, 'A007', '2021-09-27 15:22:56', '2021-09-27 16:59:01', '2021-09-27 16:59:28', 23, 23, 'reject', 1),
(15, 'A008', '2021-09-27 15:22:56', '2021-09-27 17:01:12', '2021-09-27 17:01:20', 23, 23, 'finish', 1),
(16, 'A009', '2021-09-27 15:22:56', '2021-09-27 17:01:20', '2021-09-27 17:01:28', 23, 23, 'reject', 1),
(17, 'A010', '2021-09-27 15:22:56', '2021-09-27 17:03:21', '2021-09-27 17:24:45', 23, 23, 'finish', 1),
(18, 'A011', '2021-09-27 15:22:57', '2021-09-27 17:24:45', '2021-09-27 17:24:56', 23, 23, 'finish', 1),
(19, 'B001', '2021-09-27 15:23:00', '2021-09-27 17:15:08', '2021-09-27 17:17:07', 24, 23, 'finish', 1),
(20, 'B002', '2021-09-27 15:23:00', '2021-09-27 17:03:35', '2021-09-27 17:05:52', 24, 23, 'finish', 1),
(21, 'B003', '2021-09-27 15:23:00', '2021-09-27 17:08:02', '2021-09-27 17:15:08', 24, 23, 'finish', 1),
(22, 'B004', '2021-09-27 15:23:00', '2021-09-27 17:17:07', '2021-09-27 17:18:35', 24, 23, 'finish', 1),
(23, 'B005', '2021-09-27 15:23:00', '2021-09-27 17:18:35', '2021-09-27 17:19:23', 24, 23, 'reject', 1),
(24, 'B006', '2021-09-27 15:23:00', '2021-09-27 17:19:59', '2021-09-27 17:20:04', 24, 23, 'reject', 1),
(25, 'B007', '2021-09-27 15:23:01', '2021-09-27 17:20:15', '2021-09-27 17:20:45', 24, 23, 'finish', 1),
(26, 'B008', '2021-09-27 15:23:01', '2021-09-27 17:20:45', '2021-09-27 17:20:55', 24, 23, 'reject', 1),
(27, 'B009', '2021-09-27 15:23:01', '2021-09-27 17:21:33', '2021-09-27 17:21:44', 24, 23, 'reject', 1),
(28, 'B010', '2021-09-27 15:23:01', '2021-09-27 17:06:29', '2021-09-27 17:08:02', 24, 23, 'finish', 1),
(29, 'B011', '2021-09-27 15:23:01', '2021-09-27 17:05:52', '2021-09-27 17:06:29', 24, 23, 'finish', 1),
(30, 'C001', '2021-09-27 15:23:04', '2021-09-27 17:26:49', '2021-09-27 17:26:59', 25, 24, 'finish', 1),
(31, 'C002', '2021-09-27 15:23:05', '2021-09-27 17:26:59', '2021-09-27 17:27:28', 25, 24, 'finish', 1),
(32, 'C003', '2021-09-27 15:23:05', '2021-09-27 17:27:28', '2021-09-27 17:36:20', 25, 24, 'finish', 1),
(33, 'C004', '2021-09-27 15:23:05', '2021-09-27 17:36:20', '2021-09-27 17:36:21', 25, 24, 'finish', 1),
(34, 'C005', '2021-09-27 15:23:05', '2021-09-27 17:36:21', '2021-09-27 17:36:22', 25, 24, 'finish', 1),
(35, 'C006', '2021-09-27 15:23:05', '2021-09-27 17:36:22', '2021-09-27 17:36:23', 25, 24, 'finish', 1),
(36, 'C007', '2021-09-27 15:23:05', '2021-09-27 17:36:23', '2021-09-27 17:36:24', 25, 24, 'finish', 1),
(37, 'C008', '2021-09-27 15:23:05', '2021-09-27 17:36:24', '2021-09-27 17:36:24', 25, 24, 'finish', 1),
(38, 'C009', '2021-09-27 15:23:06', '2021-09-27 17:36:24', '2021-09-27 17:36:25', 25, 24, 'finish', 1),
(39, 'C010', '2021-09-27 15:23:06', '2021-09-27 17:36:25', '2021-09-27 17:36:25', 25, 24, 'finish', 1),
(40, 'C011', '2021-09-27 15:23:06', '2021-09-27 17:36:25', '2021-09-27 17:36:26', 25, 24, 'finish', 1),
(41, 'C012', '2021-09-27 15:23:06', '2021-09-27 17:36:26', '2021-09-27 17:36:26', 25, 24, 'finish', 1),
(42, 'C013', '2021-09-27 15:23:06', '2021-09-27 17:36:27', '2021-09-27 17:36:31', 25, 24, 'finish', 1),
(43, 'C014', '2021-09-27 15:23:06', '2021-09-27 17:36:31', '2021-09-27 17:36:31', 25, 24, 'finish', 1),
(44, 'C015', '2021-09-27 15:23:06', '2021-09-27 17:36:31', '2021-09-27 17:36:32', 25, 24, 'finish', 1),
(45, 'C016', '2021-09-27 15:23:07', '2021-09-27 17:36:32', '2021-09-27 17:37:52', 25, 24, 'finish', 1),
(46, 'C017', '2021-09-27 17:36:55', '2021-09-27 17:37:52', NULL, 25, 24, 'call', 1),
(47, 'C018', '2021-09-27 17:37:32', NULL, NULL, 25, 24, 'pending', NULL),
(48, 'C019', '2021-09-27 17:37:33', NULL, NULL, 25, 24, 'pending', NULL),
(49, 'C020', '2021-09-27 17:37:33', NULL, NULL, 25, 24, 'pending', NULL),
(50, 'C021', '2021-09-27 17:37:34', NULL, NULL, 25, 24, 'pending', NULL),
(51, 'C022', '2021-09-27 17:37:34', NULL, NULL, 25, 24, 'pending', NULL),
(52, 'C023', '2021-09-27 17:37:34', NULL, NULL, 25, 24, 'pending', NULL),
(53, 'C024', '2021-09-27 17:37:34', NULL, NULL, 25, 24, 'pending', NULL),
(54, 'B001', '2021-09-29 19:32:12', NULL, NULL, 24, 23, 'pending', NULL),
(55, 'B002', '2021-09-29 19:32:33', NULL, NULL, 24, 23, 'pending', NULL),
(56, 'A001', '2021-09-29 19:32:39', NULL, NULL, 23, 23, 'pending', NULL),
(57, 'B003', '2021-09-29 19:33:04', NULL, NULL, 24, 23, 'pending', NULL),
(58, 'B004', '2021-09-29 19:38:34', NULL, NULL, 24, 23, 'pending', NULL),
(59, 'C001', '2021-09-29 19:40:54', NULL, NULL, 25, 24, 'pending', NULL),
(60, 'C002', '2021-09-29 19:41:28', NULL, NULL, 25, 24, 'pending', NULL),
(61, 'A002', '2021-09-29 19:42:22', NULL, NULL, 23, 23, 'pending', NULL),
(62, 'A003', '2021-09-29 19:42:23', NULL, NULL, 23, 23, 'pending', NULL),
(63, 'A004', '2021-09-29 19:42:26', NULL, NULL, 23, 23, 'pending', NULL),
(64, 'A005', '2021-09-29 19:42:29', NULL, NULL, 23, 23, 'pending', NULL),
(65, 'A006', '2021-09-29 19:42:30', NULL, NULL, 23, 23, 'pending', NULL),
(66, 'A007', '2021-09-29 19:43:15', NULL, NULL, 23, 23, 'pending', NULL),
(67, 'A008', '2021-09-29 19:43:19', '2021-09-29 19:53:11', '2021-09-29 19:54:21', 23, 23, 'finish', 1),
(68, 'A009', '2021-09-29 19:43:20', '2021-09-29 19:52:21', '2021-09-29 19:53:11', 23, 23, 'finish', 1),
(69, 'C003', '2021-09-29 19:44:22', NULL, NULL, 25, 24, 'pending', NULL),
(70, 'A010', '2021-09-29 19:44:25', '2021-09-29 19:52:03', '2021-09-29 19:52:21', 23, 23, 'finish', 1),
(71, 'A001', '2021-09-29 19:44:30', '2021-09-29 19:51:19', '2021-09-29 19:52:00', 23, 24, 'reject', 1),
(72, 'C004', '2021-09-29 19:45:00', NULL, NULL, 25, 24, 'pending', NULL),
(73, 'B005', '2021-09-29 19:45:03', NULL, NULL, 24, 23, 'pending', NULL),
(74, 'A011', '2021-09-29 19:54:06', '2021-09-29 19:54:29', '2021-09-29 19:54:36', 23, 23, 'reject', 1);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int NOT NULL,
  `role` varchar(50) DEFAULT NULL,
  `status` enum('ENABLE','DISABLE') CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `role`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(18, 'CS', 'ENABLE', '2018-10-24 10:29:54', NULL, '2021-09-25 21:11:12', NULL),
(22, 'Admin', 'ENABLE', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `id` int NOT NULL,
  `code` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` enum('ENABLE','DISABLE') CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`id`, `code`, `name`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(23, 'A', 'CUSTOMER SERVICE', 'ENABLE', NULL, 1, '2021-09-26 22:53:49', NULL),
(24, 'B', 'TELLER', 'ENABLE', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role_id` int DEFAULT NULL,
  `role_slug` varchar(255) DEFAULT NULL,
  `role_name` varchar(255) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT '0',
  `wrong` int DEFAULT NULL,
  `active` datetime DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `is_email` int DEFAULT '0',
  `last_email` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `name`, `email`, `password`, `role_id`, `role_slug`, `role_name`, `desc`, `status`, `wrong`, `active`, `token`, `is_email`, `last_email`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Super Admin', 'admin@gmail.com', '0192023a7bbd73250516f069df18b500', 22, NULL, NULL, 'Super Admin', '0', 3, '2021-09-20 08:53:16', '', 0, '2020-09-18 17:24:42', '2018-02-23 16:09:49', '2021-09-26 22:27:50'),
(23, 'cs1', 'Amelia', 'cs.antrian1@antrianonline.com', '0192023a7bbd73250516f069df18b500', 18, NULL, NULL, 'Customer Service 1', '0', NULL, NULL, NULL, 0, NULL, '2021-09-26 22:26:49', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `locket`
--
ALTER TABLE `locket`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `queue`
--
ALTER TABLE `queue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `file`
--
ALTER TABLE `file`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `locket`
--
ALTER TABLE `locket`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `queue`
--
ALTER TABLE `queue`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
