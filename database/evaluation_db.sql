-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2025 at 01:10 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `evaluation_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_list`
--

CREATE TABLE `academic_list` (
  `id` int(30) NOT NULL,
  `year` text NOT NULL,
  `semester` int(30) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '0=Pending,1=Start,2=Closed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `academic_list`
--

INSERT INTO `academic_list` (`id`, `year`, `semester`, `is_default`, `status`) VALUES
(1, '2019-2020', 1, 0, 0),
(2, '2019-2020', 2, 0, 0),
(3, '2020-2021', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `class_list`
--

CREATE TABLE `class_list` (
  `id` int(30) NOT NULL,
  `curriculum` text NOT NULL,
  `level` text NOT NULL,
  `section` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class_list`
--

INSERT INTO `class_list` (`id`, `curriculum`, `level`, `section`) VALUES
(1, 'BSIT', '1', 'A'),
(2, 'BSIT', '1', 'B'),
(3, 'BSIT', '1', 'C');

-- --------------------------------------------------------

--
-- Table structure for table `criteria_list`
--

CREATE TABLE `criteria_list` (
  `id` int(30) NOT NULL,
  `criteria` text NOT NULL,
  `order_by` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `criteria_list`
--

INSERT INTO `criteria_list` (`id`, `criteria`, `order_by`) VALUES
(1, 'Criteria 101', 0),
(2, 'Criteria 102', 1);

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_answers`
--

CREATE TABLE `evaluation_answers` (
  `evaluation_id` int(30) NOT NULL,
  `question_id` int(30) NOT NULL,
  `rate` int(20) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `faculty_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `evaluation_answers`
--

INSERT INTO `evaluation_answers` (`evaluation_id`, `question_id`, `rate`, `comments`, `faculty_id`) VALUES
(43, 1, 5, 'hahaha', 3),
(43, 3, 5, 'hahaha', 3),
(43, 6, 5, 'hahaha', 3),
(43, 7, 5, 'hahaha', 3),
(44, 1, 1, 'bad teacher', 3),
(44, 3, 2, 'bad teacher', 3),
(44, 6, 1, 'bad teacher', 3),
(44, 7, 2, 'bad teacher', 3),
(45, 1, 1, 'poor teaching', 2),
(45, 3, 1, 'poor teaching', 2),
(45, 6, 1, 'poor teaching', 2),
(45, 7, 1, 'poor teaching', 2),
(46, 1, 4, 'good teacher', 4),
(46, 3, 4, 'good teacher', 4),
(46, 6, 4, 'good teacher', 4),
(46, 7, 4, 'good teacher', 4),
(47, 1, 5, 'amazing teaching skill', 4),
(47, 3, 5, 'amazing teaching skill', 4),
(47, 6, 5, 'amazing teaching skill', 4),
(47, 7, 5, 'amazing teaching skill', 4);

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_list`
--

CREATE TABLE `evaluation_list` (
  `evaluation_id` int(30) NOT NULL,
  `academic_id` int(30) NOT NULL,
  `class_id` int(30) NOT NULL,
  `student_id` int(30) NOT NULL,
  `subject_id` int(30) NOT NULL,
  `faculty_id` int(30) NOT NULL,
  `restriction_id` int(30) NOT NULL,
  `date_taken` datetime NOT NULL DEFAULT current_timestamp(),
  `comments` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `evaluation_list`
--

INSERT INTO `evaluation_list` (`evaluation_id`, `academic_id`, `class_id`, `student_id`, `subject_id`, `faculty_id`, `restriction_id`, `date_taken`, `comments`) VALUES
(7, 3, 1, 5, 2, 2, 12, '2025-01-24 14:51:39', NULL),
(8, 3, 1, 6, 2, 2, 12, '2025-01-24 15:04:41', NULL),
(9, 3, 1, 6, 3, 2, 11, '2025-01-24 15:08:25', NULL),
(10, 3, 1, 7, 2, 2, 12, '2025-01-24 15:16:14', NULL),
(11, 3, 1, 7, 3, 2, 11, '2025-01-24 15:24:53', NULL),
(12, 3, 1, 8, 2, 2, 12, '2025-01-24 15:43:58', NULL),
(13, 3, 1, 8, 2, 2, 12, '2025-01-24 15:45:02', NULL),
(14, 3, 1, 9, 2, 2, 12, '2025-01-24 17:53:17', NULL),
(15, 3, 1, 9, 3, 2, 11, '2025-01-24 18:15:38', NULL),
(16, 3, 1, 7, 2, 3, 13, '2025-01-24 19:09:22', NULL),
(17, 3, 1, 7, 3, 3, 14, '2025-01-24 19:09:30', NULL),
(18, 3, 1, 10, 1, 3, 14, '2025-01-24 19:22:59', NULL),
(19, 3, 1, 10, 2, 3, 15, '2025-01-24 19:25:05', NULL),
(20, 3, 1, 10, 3, 3, 16, '2025-01-24 19:39:56', NULL),
(21, 3, 1, 11, 1, 3, 14, '2025-01-24 19:59:29', NULL),
(22, 3, 1, 11, 2, 3, 15, '2025-01-24 20:04:59', NULL),
(23, 3, 1, 11, 3, 3, 16, '2025-01-24 20:05:53', NULL),
(24, 3, 1, 12, 1, 3, 14, '2025-01-27 14:57:08', NULL),
(25, 3, 1, 12, 2, 3, 15, '2025-01-27 16:37:05', NULL),
(26, 3, 1, 12, 3, 3, 16, '2025-01-27 16:37:33', NULL),
(27, 3, 1, 13, 1, 3, 14, '2025-01-27 16:41:36', NULL),
(28, 3, 1, 14, 1, 3, 14, '2025-01-27 16:57:44', NULL),
(29, 3, 1, 14, 2, 3, 15, '2025-01-27 16:58:07', NULL),
(30, 3, 1, 14, 3, 3, 16, '2025-01-27 16:58:22', NULL),
(31, 3, 1, 14, 2, 2, 17, '2025-01-27 17:02:49', NULL),
(32, 3, 1, 14, 3, 2, 18, '2025-01-27 17:03:01', NULL),
(33, 3, 1, 16, 1, 3, 14, '2025-01-27 17:40:43', NULL),
(34, 3, 1, 16, 1, 3, 14, '2025-01-27 17:43:06', NULL),
(35, 3, 1, 16, 1, 3, 14, '2025-01-27 17:43:22', NULL),
(36, 3, 1, 16, 1, 3, 14, '2025-01-27 17:43:39', NULL),
(37, 3, 1, 16, 1, 3, 15, '2025-01-27 17:44:16', NULL),
(38, 3, 1, 15, 1, 3, 14, '2025-01-27 17:44:54', NULL),
(39, 3, 1, 15, 1, 3, 15, '2025-01-27 17:45:18', NULL),
(40, 3, 1, 15, 1, 3, 16, '2025-01-27 17:45:28', NULL),
(41, 3, 1, 15, 2, 2, 17, '2025-01-27 17:45:42', NULL),
(42, 3, 1, 15, 3, 2, 18, '2025-01-27 17:45:52', NULL),
(43, 3, 1, 17, 1, 3, 14, '2025-01-27 18:19:48', NULL),
(44, 3, 1, 17, 1, 3, 15, '2025-01-27 18:20:21', NULL),
(45, 3, 1, 17, 2, 2, 17, '2025-01-27 18:30:44', NULL),
(46, 3, 1, 17, 2, 4, 19, '2025-01-27 20:00:18', NULL),
(47, 3, 1, 17, 3, 4, 20, '2025-01-27 20:01:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `faculty_list`
--

CREATE TABLE `faculty_list` (
  `id` int(30) NOT NULL,
  `school_id` varchar(100) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `avatar` text NOT NULL DEFAULT 'no-image-available.png',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty_list`
--

INSERT INTO `faculty_list` (`id`, `school_id`, `firstname`, `lastname`, `email`, `password`, `avatar`, `date_created`) VALUES
(3, '2021-1233', 'christian', 'delapos', 'chan@faculty.com', '81dc9bdb52d04dc20036dbd8313ed055', '1737716820_Screenshot (5).png', '2025-01-24 19:07:43'),
(4, '1231233', 'Daven', 'agbas', 'agbas@faculty.com', '81dc9bdb52d04dc20036dbd8313ed055', '1737979080_1607135820_avatar.jpg', '2025-01-27 19:58:51');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `restriction_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `academic_id` int(11) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `question_list`
--

CREATE TABLE `question_list` (
  `id` int(30) NOT NULL,
  `academic_id` int(30) NOT NULL,
  `question` text NOT NULL,
  `order_by` int(30) NOT NULL,
  `criteria_id` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `question_list`
--

INSERT INTO `question_list` (`id`, `academic_id`, `question`, `order_by`, `criteria_id`) VALUES
(1, 3, 'Sample Question', 0, 1),
(3, 3, 'Test', 2, 2),
(5, 0, 'Question 101', 0, 1),
(6, 3, 'Sample 101', 4, 1),
(7, 3, 'Teacher always discusses lesson?', 5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `restriction_list`
--

CREATE TABLE `restriction_list` (
  `id` int(30) NOT NULL,
  `academic_id` int(30) NOT NULL,
  `faculty_id` int(30) NOT NULL,
  `class_id` int(30) NOT NULL,
  `subject_id` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restriction_list`
--

INSERT INTO `restriction_list` (`id`, `academic_id`, `faculty_id`, `class_id`, `subject_id`) VALUES
(14, 3, 3, 1, 1),
(15, 3, 3, 1, 1),
(16, 3, 3, 1, 1),
(19, 3, 4, 1, 2),
(20, 3, 4, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `student_list`
--

CREATE TABLE `student_list` (
  `id` int(30) NOT NULL,
  `school_id` varchar(100) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `class_id` int(30) NOT NULL,
  `avatar` text NOT NULL DEFAULT 'no-image-available.png',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_list`
--

INSERT INTO `student_list` (`id`, `school_id`, `firstname`, `lastname`, `email`, `password`, `class_id`, `avatar`, `date_created`) VALUES
(15, '2021-1569', 'Christian', 'delapos', 'christian@gmail.com', '25d55ad283aa400af464c76d713c07ad', 1, '1737970620_52d232a4-624f-40b3-a945-950a3f16c084.jpg', '2025-01-27 17:37:32'),
(16, '2021-1234', 'Ryan james', 'Baya', 'baya@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 1, '1737970680_465396497_947229560616738_8571752720393981192_n.jpg', '2025-01-27 17:38:50'),
(17, '1231233', 'Daven', 'agbas', 'agbas@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 1, '1737972840_1607156880_avatar.jpg', '2025-01-27 18:14:36');

-- --------------------------------------------------------

--
-- Table structure for table `subject_list`
--

CREATE TABLE `subject_list` (
  `id` int(30) NOT NULL,
  `code` varchar(50) NOT NULL,
  `subject` text NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject_list`
--

INSERT INTO `subject_list` (`id`, `code`, `subject`, `description`) VALUES
(1, '101', 'Sample Subject', 'Test 101'),
(2, 'ENG-101', 'English', 'English'),
(3, 'M-101', 'Math 101', 'Math - Advance Algebra ');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `cover_img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `name`, `email`, `contact`, `address`, `cover_img`) VALUES
(1, 'Teacheval Plus', 'info@sample.comm', '+6948 8542 623', '2102  Caldwell Road, Rochester, New York, 14608', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `avatar` text NOT NULL DEFAULT 'no-image-available.png',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `avatar`, `date_created`) VALUES
(1, 'Administrator', 'Dean', 'admin@admin.com', '0192023a7bbd73250516f069df18b500', '1737970740_1607134320_avatar.jpg', '2020-11-26 10:57:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_list`
--
ALTER TABLE `academic_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class_list`
--
ALTER TABLE `class_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `criteria_list`
--
ALTER TABLE `criteria_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `evaluation_answers`
--
ALTER TABLE `evaluation_answers`
  ADD PRIMARY KEY (`evaluation_id`,`question_id`);

--
-- Indexes for table `evaluation_list`
--
ALTER TABLE `evaluation_list`
  ADD PRIMARY KEY (`evaluation_id`);

--
-- Indexes for table `faculty_list`
--
ALTER TABLE `faculty_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`);

--
-- Indexes for table `question_list`
--
ALTER TABLE `question_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restriction_list`
--
ALTER TABLE `restriction_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_list`
--
ALTER TABLE `student_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject_list`
--
ALTER TABLE `subject_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_list`
--
ALTER TABLE `academic_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `class_list`
--
ALTER TABLE `class_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `criteria_list`
--
ALTER TABLE `criteria_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `evaluation_list`
--
ALTER TABLE `evaluation_list`
  MODIFY `evaluation_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `faculty_list`
--
ALTER TABLE `faculty_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `question_list`
--
ALTER TABLE `question_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `restriction_list`
--
ALTER TABLE `restriction_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `student_list`
--
ALTER TABLE `student_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `subject_list`
--
ALTER TABLE `subject_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
