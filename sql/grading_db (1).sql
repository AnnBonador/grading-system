-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2024 at 07:08 PM
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
(1, 'admin', 'admin', 'xufajo@mail', 'Admin', '$2y$10$UQL7aVLsrcNuysp5DAC4.uvzuli0yPOcARQ8IMN1FekXx1QSMw1UK', '2024-05-18'),
(2, 'rose', 'Rose Ann Bonador', 'roseannbonador5@gmail.com', 'Teacher', '$2y$10$eCveYlddHgnstjveBU/L2ec3DCeSaYJcqWdhHofUNP6.q3QlA0thq', '2024-05-18');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `academic_year` varchar(255) NOT NULL,
  `subjects` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`subjects`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `name`, `academic_year`, `subjects`) VALUES
(35, 'STEM 12A1', '2023-2024', '[{\"semester\":1,\"subjects\":[{\"subject_id\":\"9\",\"teacher_id\":\"2\"},{\"subject_id\":\"13\",\"teacher_id\":null},{\"subject_id\":\"13\",\"teacher_id\":null}]},{\"semester\":2,\"subjects\":[{\"subject_id\":\"13\",\"teacher_id\":null},{\"subject_id\":\"3\",\"teacher_id\":\"2\"}]}]'),
(36, 'STEM 12A2', '2023-2024', '[{\"semester\":1,\"subjects\":[{\"subject_id\":\"3\",\"teacher_id\":\"2\"}]},{\"semester\":2,\"subjects\":[{\"subject_id\":\"3\",\"teacher_id\":\"2\"}]}]'),
(37, 'STEM 12B1', '2023-2024', '[{\"semester\":1,\"subjects\":[{\"subject_id\":\"9\",\"teacher_id\":null},{\"subject_id\":\"3\",\"teacher_id\":null},{\"subject_id\":\"10\",\"teacher_id\":null},{\"subject_id\":\"13\",\"teacher_id\":null},{\"subject_id\":\"11\",\"teacher_id\":null}]},{\"semester\":2,\"subjects\":[{\"subject_id\":\"14\",\"teacher_id\":null},{\"subject_id\":\"15\",\"teacher_id\":null},{\"subject_id\":\"16\",\"teacher_id\":null},{\"subject_id\":\"17\",\"teacher_id\":null},{\"subject_id\":\"18\",\"teacher_id\":null},{\"subject_id\":\"19\",\"teacher_id\":null}]}]');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `grades` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`grades`)),
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `student_id`, `class_id`, `grades`, `created_at`) VALUES
(2, 9, 37, '{\"semester1\":[{\"subject_name\":\"Pagbasa at Pagsusuri ng Ibat Ibang Teskto Tungo sa Pananaliksik\",\"quarter_1_grade\":\"90\",\"quarter_2_grade\":\"82\"},{\"subject_name\":\"Personal Development\",\"quarter_1_grade\":\"95\",\"quarter_2_grade\":\"87\"},{\"subject_name\":\"Physical Education and Health 3\",\"quarter_1_grade\":\"96\",\"quarter_2_grade\":\"98\"},{\"subject_name\":\"English for Academic and Professional Purposes\",\"quarter_1_grade\":\"95\",\"quarter_2_grade\":\"94\"},{\"subject_name\":\"Practical Research 2\",\"quarter_1_grade\":\"82\",\"quarter_2_grade\":\"90\"}],\"semester2\":[{\"subject_name\":\"Contemporary Philippine Arts from the Regions\",\"quarter_1_grade\":\"98\",\"quarter_2_grade\":\"95\"},{\"subject_name\":\"Physical Education and Health 4\",\"quarter_1_grade\":\"88\",\"quarter_2_grade\":\"90\"},{\"subject_name\":\"Empowerment Technologies\",\"quarter_1_grade\":\"85\",\"quarter_2_grade\":\"87\"},{\"subject_name\":\"Entrepreneurship\",\"quarter_1_grade\":\"90\",\"quarter_2_grade\":\"91\"},{\"subject_name\":\"General Physics 2\",\"quarter_1_grade\":\"92\",\"quarter_2_grade\":\"94\"},{\"subject_name\":\"General Chemistry 2\",\"quarter_1_grade\":\"90\",\"quarter_2_grade\":\"88\"}]}', '2024-05-30');

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
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `age`, `gender`, `lrn`, `status`, `created_at`) VALUES
(5, 'Maya Sawyer', '1974-12-21', 'm', '01293847474', 0, '2024-05-21'),
(8, 'sdd', '2011-11-07', 'f', '01293111747', 0, '2024-05-21'),
(9, 'Adena Miranda', '1990-11-25', 'f', '2323234333', 0, '2024-05-21'),
(10, 'Jelani Santos', '1985-11-15', 'f', '1443434343', 0, '2024-05-27');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `subject_code` varchar(191) DEFAULT NULL,
  `subject_type` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `subject_code`, `subject_type`, `status`) VALUES
(3, 'Personal Development', '', 1, 0),
(9, 'Pagbasa at Pagsusuri ng Ibat Ibang Teskto Tungo sa Pananaliksik', '', 1, 0),
(10, 'Physical Education and Health 3', '', 1, 0),
(11, 'Practical Research 2', '', 2, 0),
(12, 'Filipino sa Piling Larangan', '', 2, 0),
(13, 'English for Academic and Professional Purposes', '', 2, 0),
(14, 'Contemporary Philippine Arts from the Regions', '', 1, 0),
(15, 'Physical Education and Health 4', '', 1, 0),
(16, 'Empowerment Technologies', '', 2, 0),
(17, 'Entrepreneurship', '', 1, 0),
(18, 'General Physics 2', '', 2, 0),
(19, 'General Chemistry 2', 'Chloe Osborn', 2, 0);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
