-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2024 at 07:33 AM
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
  `username` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `role` varchar(255) NOT NULL,
  `password` varchar(191) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `name`, `email`, `role`, `password`, `created_at`) VALUES
(1, 'admin', 'admin', 'admin@gmail.com', 'Admin', '$2y$10$UQL7aVLsrcNuysp5DAC4.uvzuli0yPOcARQ8IMN1FekXx1QSMw1UK', '2024-05-18');

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
(34, 10, 12, '{\"semester1\":[{\"subject_id\":\"9\",\"quarter_1_grade\":\"88\",\"quarter_2_grade\":\"75\",\"final_grade\":\"81.50\"},{\"subject_id\":\"3\",\"quarter_1_grade\":\"38\",\"quarter_2_grade\":\"69\",\"final_grade\":\"53.50\"},{\"subject_id\":\"10\",\"quarter_1_grade\":\"33\",\"quarter_2_grade\":\"90\",\"final_grade\":\"61.50\"},{\"subject_id\":\"13\",\"quarter_1_grade\":\"51\",\"quarter_2_grade\":\"91\",\"final_grade\":\"71.00\"},{\"subject_id\":\"11\",\"quarter_1_grade\":\"41\",\"quarter_2_grade\":\"61\",\"final_grade\":\"51.00\"}],\"semester2\":[{\"subject_id\":\"14\",\"quarter_1_grade\":\"31\",\"quarter_2_grade\":\"8\",\"final_grade\":\"19.50\"},{\"subject_id\":\"15\",\"quarter_1_grade\":\"34\",\"quarter_2_grade\":\"89\",\"final_grade\":\"61.50\"},{\"subject_id\":\"16\",\"quarter_1_grade\":\"44\",\"quarter_2_grade\":\"74\",\"final_grade\":\"59.00\"},{\"subject_id\":\"17\",\"quarter_1_grade\":\"74\",\"quarter_2_grade\":\"21\",\"final_grade\":\"47.50\"},{\"subject_id\":\"18\",\"quarter_1_grade\":\"22\",\"quarter_2_grade\":\"79\",\"final_grade\":\"50.50\"},{\"subject_id\":\"19\",\"quarter_1_grade\":\"90\",\"quarter_2_grade\":\"98\",\"final_grade\":\"94.00\"}]}', '63.70', '55.33', '2024-06-02'),
(35, 8, 13, '{\"semester1\":[{\"subject_id\":\"9\",\"quarter_1_grade\":\"90\",\"quarter_2_grade\":\"98\",\"final_grade\":\"94.00\"},{\"subject_id\":\"3\",\"quarter_1_grade\":\"90\",\"quarter_2_grade\":\"25\",\"final_grade\":\"57.50\"},{\"subject_id\":\"10\",\"quarter_1_grade\":\"22\",\"quarter_2_grade\":\"17\",\"final_grade\":\"19.50\"},{\"subject_id\":\"13\",\"quarter_1_grade\":\"99\",\"quarter_2_grade\":\"71\",\"final_grade\":\"85.00\"},{\"subject_id\":\"11\",\"quarter_1_grade\":\"22\",\"quarter_2_grade\":\"81\",\"final_grade\":\"51.50\"}],\"semester2\":[{\"subject_id\":\"14\",\"quarter_1_grade\":\"60\",\"quarter_2_grade\":\"100\",\"final_grade\":\"80.00\"},{\"subject_id\":\"15\",\"quarter_1_grade\":\"3\",\"quarter_2_grade\":\"22\",\"final_grade\":\"12.50\"},{\"subject_id\":\"16\",\"quarter_1_grade\":\"8\",\"quarter_2_grade\":\"13\",\"final_grade\":\"10.50\"},{\"subject_id\":\"17\",\"quarter_1_grade\":\"61\",\"quarter_2_grade\":\"37\",\"final_grade\":\"49.00\"},{\"subject_id\":\"18\",\"quarter_1_grade\":\"93\",\"quarter_2_grade\":\"93\",\"final_grade\":\"93.00\"},{\"subject_id\":\"19\",\"quarter_1_grade\":\"2\",\"quarter_2_grade\":\"13\",\"final_grade\":\"7.50\"}]}', '61.50', '42.08', '2024-06-02'),
(36, 5, 14, '{\"semester1\":[{\"subject_id\":\"3\",\"quarter_1_grade\":\"95\",\"quarter_2_grade\":\"55\",\"final_grade\":\"75.00\"},{\"subject_id\":\"12\",\"quarter_1_grade\":\"91\",\"quarter_2_grade\":\"79\",\"final_grade\":\"85.00\"},{\"subject_id\":\"18\",\"quarter_1_grade\":\"34\",\"quarter_2_grade\":\"41\",\"final_grade\":\"37.50\"}],\"semester2\":[{\"subject_id\":\"10\",\"quarter_1_grade\":\"23\",\"quarter_2_grade\":\"67\",\"final_grade\":\"45.00\"},{\"subject_id\":\"17\",\"quarter_1_grade\":\"51\",\"quarter_2_grade\":\"69\",\"final_grade\":\"60.00\"}]}', '65.83', '52.50', '2024-06-02'),
(37, 12, 15, '{\"semester1\":[{\"subject_id\":\"10\",\"quarter_1_grade\":\"29\",\"quarter_2_grade\":\"4\",\"final_grade\":\"16.50\"},{\"subject_id\":\"17\",\"quarter_1_grade\":\"59\",\"quarter_2_grade\":\"61\",\"final_grade\":\"60.00\"},{\"subject_id\":\"11\",\"quarter_1_grade\":\"41\",\"quarter_2_grade\":\"71\",\"final_grade\":\"56.00\"}],\"semester2\":[{\"subject_id\":\"3\",\"quarter_1_grade\":\"39\",\"quarter_2_grade\":\"33\",\"final_grade\":\"36.00\"},{\"subject_id\":\"9\",\"quarter_1_grade\":\"44\",\"quarter_2_grade\":\"27\",\"final_grade\":\"35.50\"}]}', '44.17', '35.75', '2024-06-02');

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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `class_record`
--
ALTER TABLE `class_record`
  MODIFY `id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
