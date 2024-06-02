-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2024 at 01:04 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `grading_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(191) DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `name`, `email`, `role`, `password`, `created_at`) VALUES
(1, 'admin', 'admins', 'admin@gmail.com', 'Admin', '$2y$10$UaPqmhIkpy8ICg8rbcLgkeDJ4HEwIU6LaCu40zU7sTZ97d9jIH90y', '2024-05-18'),
(12, 'rose', 'user', 'cyfyqisefu', 'Teacher', '$2y$10$ytTUTsC62u9iRQ0dH0tFNeH9PVlO3HS/WvyzdS28qtnmwlz4M5OTG', '2024-06-02'),
(13, 'yow', 'rotalawyh', 'qybihym', 'Teacher', '$2y$10$CaR2eOO14U8eH7rsqCDRTuM6gpyrm.ICefXByjw.YLLZI/tEbkA7y', '2024-06-03');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `academic_year` varchar(255) NOT NULL,
  `subjects` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`subjects`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `name`, `academic_year`, `subjects`, `created_at`) VALUES
(51, 'STEM A1 guide', '2024-2025', '[{\"semester\":1,\"subjects\":[{\"subject_id\":\"9\",\"teacher_id\":null},{\"subject_id\":\"3\",\"teacher_id\":null},{\"subject_id\":\"10\",\"teacher_id\":\"12\"},{\"subject_id\":\"12\",\"teacher_id\":\"13\"}]},{\"semester\":2,\"subjects\":[{\"subject_id\":\"13\",\"teacher_id\":null},{\"subject_id\":\"14\",\"teacher_id\":null},{\"subject_id\":\"15\",\"teacher_id\":\"12\"},{\"subject_id\":\"18\",\"teacher_id\":null},{\"subject_id\":\"17\",\"teacher_id\":null}]}]', '2024-06-02 16:34:54'),
(53, 'STEM B2 guide', '2024-2025', '[{\"semester\":1,\"subjects\":[{\"subject_id\":\"10\",\"teacher_id\":\"12\"}]},{\"semester\":2,\"subjects\":[{\"subject_id\":\"13\",\"teacher_id\":null}]}]', '2024-06-02 18:44:07');

-- --------------------------------------------------------

--
-- Table structure for table `class_record`
--

CREATE TABLE `class_record` (
  `id` int(111) NOT NULL,
  `name` varchar(191) NOT NULL,
  `class_id` int(11) NOT NULL,
  `adviser` varchar(191) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class_record`
--

INSERT INTO `class_record` (`id`, `name`, `class_id`, `adviser`, `created_at`) VALUES
(21, 'STEM A1', 51, '', '2024-06-02 20:47:29'),
(22, 'STEM B2', 53, '', '2024-06-02 21:55:39');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `record_id` int(11) NOT NULL,
  `grades` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`grades`)),
  `gen_avg_first` varchar(191) DEFAULT NULL,
  `gen_avg_second` varchar(191) DEFAULT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `student_id`, `record_id`, `grades`, `gen_avg_first`, `gen_avg_second`, `created_at`) VALUES
(52, 16, 21, '{\"semester1\":[{\"subject_id\":\"9\",\"quarter_1_grade\":\"74\",\"quarter_2_grade\":\"2\",\"final_grade\":\"38.00\"},{\"subject_id\":\"3\",\"quarter_1_grade\":\"88\",\"quarter_2_grade\":\"30\",\"final_grade\":\"59.00\"},{\"subject_id\":\"10\",\"quarter_1_grade\":\"87\",\"quarter_2_grade\":\"87\",\"final_grade\":\"87.00\"},{\"subject_id\":\"12\",\"quarter_1_grade\":\"23\",\"quarter_2_grade\":\"37\",\"final_grade\":\"30.50\"}],\"semester2\":[{\"subject_id\":\"13\",\"quarter_1_grade\":\"88\",\"quarter_2_grade\":\"43\",\"final_grade\":\"65.50\"},{\"subject_id\":\"14\",\"quarter_1_grade\":\"23\",\"quarter_2_grade\":\"81\",\"final_grade\":\"52.00\"},{\"subject_id\":\"15\",\"quarter_1_grade\":\"59\",\"quarter_2_grade\":\"83\",\"final_grade\":\"71.00\"},{\"subject_id\":\"18\",\"quarter_1_grade\":\"97\",\"quarter_2_grade\":\"44\",\"final_grade\":\"70.50\"},{\"subject_id\":\"17\",\"quarter_1_grade\":\"76\",\"quarter_2_grade\":\"10\",\"final_grade\":\"43.00\"}]}', '53.63', '60.40', '2024-06-03'),
(53, 17, 21, '{\"semester1\":[{\"subject_id\":\"9\",\"quarter_1_grade\":\"\",\"quarter_2_grade\":\"\"},{\"subject_id\":\"3\",\"quarter_1_grade\":\"\",\"quarter_2_grade\":\"\"},{\"subject_id\":\"10\",\"quarter_1_grade\":\"67\",\"quarter_2_grade\":\"54\"},{\"subject_id\":\"12\",\"quarter_1_grade\":\"24\",\"quarter_2_grade\":\"37\"}],\"semester2\":[{\"subject_id\":\"13\",\"quarter_1_grade\":\"\",\"quarter_2_grade\":\"\"},{\"subject_id\":\"14\",\"quarter_1_grade\":\"\",\"quarter_2_grade\":\"\"},{\"subject_id\":\"15\",\"quarter_1_grade\":\"\",\"quarter_2_grade\":\"\"},{\"subject_id\":\"18\",\"quarter_1_grade\":\"\",\"quarter_2_grade\":\"\"},{\"subject_id\":\"17\",\"quarter_1_grade\":\"\",\"quarter_2_grade\":\"\"}]}', '', '', '2024-06-03');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `age` varchar(191) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `lrn` varchar(191) DEFAULT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `age`, `gender`, `lrn`, `created_at`) VALUES
(16, 'Aaron Glover', '1998-12-20', 'f', '90', '2024-06-02'),
(17, 'Nevada Martin', '1999-11-10', 'f', '100', '2024-06-02'),
(18, 'Darryl Patel', '2020-04-20', 'f', '68', '2024-06-03');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `subject_code` varchar(191) DEFAULT NULL,
  `subject_type` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `subject_code`, `subject_type`, `created_at`) VALUES
(3, 'Personal Development', '', 1, '2024-05-31 19:35:24'),
(9, 'Pagbasa at Pagsusuri ng Ibat Ibang Teskto Tungo sa Pananaliksik', '', 1, '2024-05-31 19:35:24'),
(10, 'Physical Education and Health 3', '', 1, '2024-05-31 19:35:24'),
(11, 'Practical Research 2', '', 2, '2024-05-31 19:35:24'),
(12, 'Filipino sa Piling Larangan', '', 2, '2024-05-31 19:35:24'),
(13, 'English for Academic and Professional Purposes', '', 1, '2024-05-31 19:35:24'),
(14, 'Contemporary Philippine Arts from the Regions', '', 1, '2024-05-31 19:35:24'),
(15, 'Physical Education and Health 4', '', 1, '2024-05-31 19:35:24'),
(16, 'Empowerment Technologies', '', 2, '2024-05-31 19:35:24'),
(17, 'Entrepreneurship', '', 1, '2024-05-31 19:35:24'),
(18, 'General Physics 2', '', 2, '2024-05-31 19:35:24'),
(19, 'General Chemistry 2', 'Chloe Osborn', 2, '2024-05-31 19:35:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class_record`
--
ALTER TABLE `class_record`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id_foreign` (`class_id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id_foreign` (`student_id`),
  ADD KEY `record_id_foreign` (`record_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `class_record`
--
ALTER TABLE `class_record`
  MODIFY `id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `class_record`
--
ALTER TABLE `class_record`
  ADD CONSTRAINT `class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `record_id_foreign` FOREIGN KEY (`record_id`) REFERENCES `class_record` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
