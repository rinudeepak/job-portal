-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2026 at 02:10 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `job_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `candidate_id` int(11) NOT NULL,
  `resume_skills` text NOT NULL,
  `repositories` int(11) NOT NULL,
  `commits` int(11) NOT NULL,
  `languages` text NOT NULL,
  `tech_score` int(11) DEFAULT NULL,
  `tech_comment` text NOT NULL,
  `hr_score` int(11) DEFAULT NULL,
  `hr_comment` text NOT NULL,
  `skill_score` int(11) NOT NULL,
  `status` varchar(150) NOT NULL,
  `applied_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `job_id`, `candidate_id`, `resume_skills`, `repositories`, `commits`, `languages`, `tech_score`, `tech_comment`, `hr_score`, `hr_comment`, `skill_score`, `status`, `applied_at`) VALUES
(28, 11, 6, 'java', 2, 10, 'CSS,PHP,JavaScript,Hack', NULL, '', NULL, '', 0, 'Applied', '2026-01-05 02:25:58'),
(29, 9, 6, 'php', 2, 10, 'CSS,PHP,JavaScript,Hack', 8, 'kkk', 8, 'Motivated candidate with a clear understanding of career goals.', 0, 'Selected', '2026-01-05 02:26:06'),
(36, 6, 6, 'php,jquery,mysql', 2, 10, 'CSS,PHP,JavaScript,Hack', NULL, '', NULL, '', 51, 'Shortlisted', '2026-01-05 17:00:40'),
(40, 11, 4, 'java', 5, 30, 'HTML,TypeScript,JavaScript,CSS,SCSS,PHP', NULL, '', NULL, '', 63, 'Shortlisted', '2026-01-05 17:09:55'),
(41, 9, 4, 'php', 5, 30, 'HTML,TypeScript,JavaScript,CSS,SCSS,PHP', 4, 'Struggles with core concepts and was unable to explain implementation clearly.', NULL, '', 63, 'Rejected', '2026-01-05 17:10:07'),
(42, 11, 7, '', 5, 104, 'JavaScript,EJS,CSS,HTML,Vue,PHP,Blade,TypeScript,C#,Dart,C++,CMake,Swift,C,Dockerfile,Shell,Kotlin,Objective-C', NULL, '', NULL, '', 60, 'Shortlisted', '2026-01-05 17:12:49'),
(43, 9, 7, '', 5, 104, 'JavaScript,EJS,CSS,HTML,Vue,PHP,Blade,TypeScript,C#,Dart,C++,CMake,Swift,C,Dockerfile,Shell,Kotlin,Objective-C', 8, 'Able to explain solutions clearly and handle edge cases confidently.', 6, 'Soft skills are average; can improve with guidance.', 60, 'Selected', '2026-01-05 17:13:03'),
(44, 8, 7, '', 5, 104, 'JavaScript,EJS,CSS,HTML,Vue,PHP,Blade,TypeScript,C#,Dart,C++,CMake,Swift,C,Dockerfile,Shell,Kotlin,Objective-C', NULL, '', NULL, '', 60, 'Shortlisted', '2026-01-05 17:13:25'),
(45, 2, 7, '', 5, 104, 'JavaScript,EJS,CSS,HTML,Vue,PHP,Blade,TypeScript,C#,Dart,C++,CMake,Swift,C,Dockerfile,Shell,Kotlin,Objective-C', NULL, '', NULL, '', 60, 'Shortlisted', '2026-01-05 17:13:40');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `recruiter_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `skills` varchar(150) NOT NULL,
  `experience` int(11) NOT NULL,
  `location` varchar(150) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `recruiter_id`, `title`, `description`, `skills`, `experience`, `location`, `created_at`) VALUES
(2, 2, 'PHP Developer', 'xcxc', 'php', 8, 'Kochi', '2026-01-01 02:15:05'),
(6, 2, 'Software Developer', 'aaaaaaaaaaaa', 'PHP, jQuery, MySQL ', 3, 'Bangalore', '2026-01-01 01:58:18'),
(7, 2, 'Software Developer Intern', 'XXZ', 'html, javascript, PHP, jQuery', 1, 'Bangalore', '2026-01-01 02:04:25'),
(8, 2, 'Automation Engineer', 'zxcxzcx', 'html, css', 7, 'Kochi', '2026-01-01 02:29:37'),
(9, 2, 'Testing Engineer', 'cxcxzc', 'php,css', 1, 'ernakulam', '2026-01-01 02:30:25'),
(11, 8, 'Java Developer', 'aaaaaa', 'java', 3, 'Kerala', '2026-01-03 16:50:27');

-- --------------------------------------------------------

--
-- Table structure for table `resumes`
--

CREATE TABLE `resumes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `file_path` varchar(250) NOT NULL,
  `uploaded_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resumes`
--

INSERT INTO `resumes` (`id`, `user_id`, `file_path`, `uploaded_at`) VALUES
(1, 6, 'uploads/resumes/1767210260_6.pdf', '2026-01-01 01:14:20'),
(2, 4, 'uploads/resumes/1767298182_4.pdf', '2026-01-02 01:39:42');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `skill_name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `user_id`, `skill_name`) VALUES
(1, 6, 'PHP'),
(3, 6, 'MySQL'),
(6, 6, 'WordPress'),
(18, 6, 'jQuery'),
(19, 3, 'java'),
(20, 4, 'C++'),
(21, 6, 'java');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `role` enum('candidate','recruiter','','') NOT NULL,
  `company_name` varchar(250) NOT NULL,
  `github_username` varchar(250) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `company_name`, `github_username`, `created_at`) VALUES
(1, 'abc', 'abc@gmail.com', '12345', 'candidate', '', 'InsiderJanggo', '2025-12-30 20:24:28'),
(2, 'Rinu', 'rinugeorgep@gmail.com', '123', 'recruiter', 'ABC company', '', '0000-00-00 00:00:00'),
(3, 'arun', 'arun@gmail.com', '147', 'candidate', '', '', '0000-00-00 00:00:00'),
(4, 'gopi', 'gopi@gmail.com', '258', 'candidate', '', 'keerti1924', '2025-12-31 23:58:32'),
(5, 'rohith', 'rohith@gmail.com', '369', 'candidate', '', '', '2026-01-01 00:00:02'),
(6, 'xx', 'test@gmail.com', '258', 'candidate', '', 'rinudeepak', '2026-01-01 00:17:57'),
(7, 'Athira', 'athira@gmail.com', 'wwwww', 'candidate', '', 'younisyousaf', '2026-01-03 11:54:55'),
(8, 'Manohar', 'manohar@gmail.com', '789', 'recruiter', 'Xz Company', '', '2026-01-03 16:47:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resumes`
--
ALTER TABLE `resumes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
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
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `resumes`
--
ALTER TABLE `resumes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
