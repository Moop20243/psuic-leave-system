-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 12, 2026 at 08:50 AM
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
(2, 'Personal Leave'),
(13, 'Emergency Leave');

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
(11, '142-255', 'Responsive Web Design', 'DR. Jittrapol Intasirisawat'),
(13, '142-357', 'Backend Web Programming', 'ASSOC. PROF. Dr. Athitaya Nitchot'),
(14, '142-144', 'Principles of Layout and Idea Generation', 'Dr.Pailin Thawornwijit'),
(15, '142-111', 'Basic Product Dedign and Branding', 'Dr.Pailin Thawornwijit');

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
(32, '6611610020', 'Sick leave', '142-111', '2026-03-11', '2026-03-12', 'I have a slight fever.', '0630898475', '1773173480_6611610020.jpg', 'Approved', '2026-03-10 20:11:20'),
(33, '6611610007', 'Emergency Leave', '142-111', '2026-03-12', '2026-03-12', 'ตื่นสาย', '0820894460', '', 'Not Approved', '2026-03-11 07:45:23');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `fullname`, `email`, `role`, `advisor_id`, `created_at`, `profile_picture`) VALUES
(1, 'admin', '1234', 'Super Admin', 'admin@psu.ac.th', 'admin', NULL, '2026-01-19 05:38:21', NULL),
(18, 'tanatepanrat', '1234', 'ASST. PROF. Dr. Tanate panrat', 'tanatepanrat@gmail.com', 'lecturer', NULL, '2026-03-10 15:42:14', 'Profile_Tanate.png'),
(20, 'dimitrije', '1234', 'Dimitrije Curcic', 'dimi3.psuic@gmail.com', 'lecturer', NULL, '2026-03-10 15:52:24', 'Profile_Dimitrije.png'),
(22, 'pailin', '1234', 'Dr.Pailin Thawornwijit', 'pailin.t@psu.ac.th', 'lecturer', NULL, '2026-03-10 15:55:32', 'Profile_Pailin.png'),
(23, 'jittrapol', '1234', 'DR. Jittrapol Intasirisawat', 'jittrapol.i@psu.ac.th', 'lecturer', NULL, '2026-03-10 15:57:49', 'Profile_Jittrapol.png'),
(24, '6611610020', '12345', 'Naphat Thongaon', 'Naphat.tho@psu.ac.th', 'student', 'hambalee', '2026-03-10 16:50:23', 'Profile_Naphat.jpg'),
(25, '6611610008', '1234', 'Taksapon Yodpijit', 'Tanksapon.yod@psu.ac.th', 'student', 'athitaya', '2026-03-10 16:53:26', 'Profile_Taksapon.png'),
(26, 'athitaya', '1234', 'ASSOC. PROF. Dr. Athitaya Nitchot', 'athitaya.n@psu.ac.th', 'lecturer', NULL, '2026-03-10 16:59:23', 'Profile_Athitaya.png'),
(27, 'hambalee', '1234', 'ASST. PROF. Dr. Hambalee Jehma', 'hambalee.j@psu.ac.th', 'lecturer', NULL, '2026-03-10 17:00:51', 'Proflie_Hambalee.png'),
(28, 'kiattisak', '1234', 'Kiattisak Tanasanborisut', 'kiattisak.t@psu.ac.th', 'lecturer', NULL, '2026-03-10 17:03:05', 'Profile_Kiattisak.png'),
(29, '6611610017', '1234', 'Suteerapat Yoksap', 'Suteereapat.yok@psu.ac.th', 'student', 'kiattisak', '2026-03-10 17:12:00', 'Profile_Sutee.jpg'),
(30, '6611610003', '1234', 'Chuhada Hemman', 'Chuhada.hem@psu.ac.th', 'student', 'tanatepanrat', '2026-03-10 17:15:12', 'Profile_Chuda.jpg'),
(32, '6611610007', '1234', 'Tonboon Jusapalo', 'tonboon.j@psu.ac.th', 'student', 'hambalee', '2026-03-11 07:41:43', 'Profile_Tonboon.jpg');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `leave_requests`
--
ALTER TABLE `leave_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
