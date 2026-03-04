-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2026 at 09:13 AM
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
-- Database: `psuic_leave_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `absence_types`
--

CREATE TABLE `absence_types` (
  `id` int(11) NOT NULL,
  `type_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absence_types`
--

INSERT INTO `absence_types` (`id`, `type_name`) VALUES
(1, 'Sick leave'),
(2, 'Personal Leave');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `course_code` varchar(20) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `lecturer_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_code`, `course_name`, `lecturer_name`) VALUES
(8, '142-000', 'Test Course 2 Update', 'Dr. Lionel Messi'),
(9, '122-333', 'Data Science', 'Dr. Lionel Messi');

-- --------------------------------------------------------

--
-- Table structure for table `leave_requests`
--

CREATE TABLE `leave_requests` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `leave_type` varchar(50) NOT NULL,
  `course` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `reason` text NOT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leave_requests`
--

INSERT INTO `leave_requests` (`id`, `student_id`, `leave_type`, `course`, `start_date`, `end_date`, `reason`, `contact_number`, `file_path`, `status`, `created_at`) VALUES
(28, '6611610020', 'Sick leave', '122-333', '2026-03-04', '2026-03-04', 'sick', '0630520529', '1772564717_6611610020.jpg', 'Approved', '2026-03-03 19:05:17'),
(29, '6611610020', 'Sick leave', '122-333', '2026-03-04', '2026-03-04', 'sick', '0630520529', '', 'Pending Advisor', '2026-03-03 20:41:56'),
(30, '6611610020', 'Personal Leave', '122-333', '2026-03-04', '2026-03-04', 'sick', '0630520529', '', 'Pending Advisor', '2026-03-03 20:45:30');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role` enum('admin','lecturer','student') NOT NULL,
  `advisor_id` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `fullname`, `email`, `role`, `advisor_id`, `created_at`) VALUES
(1, 'admin', '1234', 'Super Admin', 'admin@psu.ac.th', 'admin', NULL, '2026-01-19 05:38:21'),
(4, 'lec01', '1234', 'Dr. Lionel Messi', 'lionel.m@psu.ac.th', 'lecturer', NULL, '2026-01-19 05:38:21'),
(13, '6611610008', '1234', 'Takspon Yodpijit', 'Tankspon@psu.ac.th', 'student', 'lec01', '2026-03-03 15:58:26'),
(15, 'lec07', '1234', 'Dr.Cristiano Ronaldo', 'Cristiano@psu.ac.th', 'lecturer', NULL, '2026-03-03 16:04:19'),
(16, '6611610020', '1234', 'Naphat Thongaon', 'Naphat@psu.ac.th', 'student', 'lec07', '2026-03-03 16:07:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absence_types`
--
ALTER TABLE `absence_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_requests`
--
ALTER TABLE `leave_requests`
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
-- AUTO_INCREMENT for table `absence_types`
--
ALTER TABLE `absence_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `leave_requests`
--
ALTER TABLE `leave_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
