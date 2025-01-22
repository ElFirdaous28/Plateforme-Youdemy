-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 22, 2025 at 10:14 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `youdemy_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(4, 'Cyber Security'),
(2, 'Data Science'),
(5, 'Digital Marketing'),
(3, 'Graphic Design'),
(23, 'new cat edited'),
(1, 'Web Development');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `content_type` enum('video','document') NOT NULL,
  `category_id` int DEFAULT NULL,
  `teacher_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `title`, `description`, `content_type`, `category_id`, `teacher_id`, `created_at`, `updated_at`) VALUES
(33, 'Nam ex magna vel edited', 'Veritatis nesciunt ', 'document', 3, 6, '2025-01-19 21:09:24', '2025-01-20 09:16:30'),
(34, 'Ad obcaecati blandit edited', 'Adipisicing amet nu', 'document', 3, 6, '2025-01-19 23:40:07', '2025-01-20 08:34:05'),
(71, 'Adipisci aliquam quo', 'Tempora nisi volupta', 'video', 23, 6, '2025-01-20 11:23:46', '2025-01-20 11:23:46'),
(72, 'Adipisci aliquam quo', 'Tempora nisi volupta', 'video', 23, 6, '2025-01-20 11:24:00', '2025-01-20 11:24:00'),
(73, 'Adipisci aliquam quo', 'Tempora nisi volupta', 'video', 23, 6, '2025-01-20 11:24:46', '2025-01-20 11:24:46'),
(75, 'New Cours', 'In est ipsum ad mo', 'document', 5, 6, '2025-01-20 23:06:20', '2025-01-20 23:06:20'),
(76, 'New course2', 'Dolor ut similique i', 'video', 2, 6, '2025-01-20 23:21:19', '2025-01-20 23:21:19'),
(77, 'new title', 'des', 'video', 4, 8, '2025-01-21 02:35:29', '2025-01-21 02:35:29'),
(108, 'Introduction to PHP', 'Learn the basics of PHP programming.', 'video', 1, 8, '2025-01-21 08:29:32', '2025-01-21 08:29:32'),
(109, 'Advanced JavaScript', 'Master the advanced concepts of JavaScript.', 'video', 2, 8, '2025-01-21 08:29:32', '2025-01-21 08:29:32'),
(110, 'HTML & CSS for Beginners', 'A beginner-friendly guide to web design.', 'document', 1, 8, '2025-01-21 08:29:32', '2025-01-21 08:29:32'),
(111, 'Building RESTful APIs', 'Create efficient APIs with Node.js.', 'video', 3, 8, '2025-01-21 08:29:32', '2025-01-21 08:29:32');

-- --------------------------------------------------------

--
-- Table structure for table `course_tags`
--

CREATE TABLE `course_tags` (
  `course_id` int NOT NULL,
  `tag_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `course_tags`
--

INSERT INTO `course_tags` (`course_id`, `tag_id`) VALUES
(34, 1),
(75, 1),
(75, 2),
(34, 3),
(34, 4),
(33, 5),
(34, 9),
(34, 10);

-- --------------------------------------------------------

--
-- Table structure for table `document_content`
--

CREATE TABLE `document_content` (
  `id_content` int NOT NULL,
  `course_id` int DEFAULT NULL,
  `document_url` varchar(255) DEFAULT NULL,
  `pages_number` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `document_content`
--

INSERT INTO `document_content` (`id_content`, `course_id`, `document_url`, `pages_number`) VALUES
(5, 33, NULL, NULL),
(6, 34, NULL, NULL),
(17, 75, '/assets/uploads/documentcourses/test2.pdf', 1);

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `enrollment_id` int NOT NULL,
  `student_id` int NOT NULL,
  `course_id` int NOT NULL,
  `enrollment_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `progress` tinyint UNSIGNED DEFAULT '0',
  `status` enum('requested','enrolled','completed') DEFAULT 'requested',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`enrollment_id`, `student_id`, `course_id`, `enrollment_date`, `progress`, `status`, `updated_at`) VALUES
(1, 7, 33, '2025-01-20 14:29:34', 0, 'enrolled', '2025-01-21 01:42:32'),
(2, 7, 34, '2025-01-20 13:53:06', 0, 'enrolled', '2025-01-20 20:52:14'),
(3, 7, 75, '2025-01-20 23:06:45', 0, 'enrolled', '2025-01-20 23:07:42'),
(4, 7, 76, '2025-01-20 23:21:50', 0, 'enrolled', '2025-01-21 21:05:34'),
(5, 8, 34, '2025-01-21 01:30:22', 0, 'enrolled', '2025-01-21 01:30:22'),
(6, 7, 77, '2025-01-21 12:32:41', 0, 'requested', '2025-01-21 12:32:41');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `tag_id` int NOT NULL,
  `tag_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`tag_id`, `tag_name`) VALUES
(10, 'artificialintelligence'),
(9, 'cloudcomputing'),
(13, 'cybersecurity'),
(5, 'dataanalysis'),
(15, 'digitalmarketing'),
(12, 'gamedevelopment'),
(3, 'javascript'),
(6, 'machinelearning'),
(8, 'marketing'),
(11, 'mobiledevelopment'),
(2, 'php'),
(14, 'programminglanguages'),
(4, 'python'),
(7, 'uxdesign'),
(1, 'webdevelopment');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `role` enum('teacher','student','admin') NOT NULL,
  `status` enum('active','inactive','suspended') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `password`, `created_at`, `updated_at`, `role`, `status`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$IBQU780H6ZznoxYDRMDjeeLkPj1h/tleTxwnuuOGQxdzQBy5Ch5sq', '2025-01-15 15:56:15', '2025-01-21 01:36:35', 'admin', 'active'),
(4, 'Zephr Lawrence', 'libexaguva@mailinator.com', '$2y$10$vVNqjjoO5jtGalmRcgWB3uBDlEu35ipSLn.Pee/wS8IhKXaYInrQy', '2025-01-16 06:05:35', '2025-01-17 09:48:01', 'teacher', 'suspended'),
(5, 'Hannah Lester', 'qiladizybo@mailinator.com', '$2y$10$fK.521nVpLklZL7YRMNAeuBOPCfX1aa5BkON0Wsy9DvKKtpmDR4Iq', '2025-01-16 06:05:56', '2025-01-16 21:47:56', 'teacher', 'active'),
(6, 'teacher1', 'teacher@gmail.com', '$2y$10$PzoNIXestmaX7QfB8sB66.xZlur54rItlohFDTxM00gl8M8UUoQ1S', '2025-01-16 23:53:30', '2025-01-16 23:53:30', 'teacher', 'active'),
(7, 'student', 'student@gamil.com', '$2y$10$LXdVTj9UlDnIlMvi/jwrQON4GwZwDmzFd.2U16tN/r8p19vIAwVnK', '2025-01-20 13:48:43', '2025-01-20 13:48:43', 'student', 'active'),
(8, 'Craig Howell', 'zagunywy@mailinator.com', '$2y$10$RlXb0Y9P1628JzOSfULGl.2MhfUll0eUo0pFOAbxmQHtlFj4ISdWu', '2025-01-20 23:57:18', '2025-01-20 23:57:18', 'teacher', 'inactive'),
(9, 'Adena Malone', 'zywirolave@mailinator.com', '$2y$10$LqZgtJkzdOMhOIxBcbTcr.GvmUQUZtHIzO2jSJ5YjtdBL9fqqhv8a', '2025-01-20 23:57:49', '2025-01-20 23:57:49', 'student', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `video_content`
--

CREATE TABLE `video_content` (
  `id_content` int NOT NULL,
  `course_id` int DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `duration` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `video_content`
--

INSERT INTO `video_content` (`id_content`, `course_id`, `video_url`, `duration`) VALUES
(9, 76, '/assets/uploads/videocourses/7164232-hd_1920_1080_30fps.mp4', '00:00:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `course_tags`
--
ALTER TABLE `course_tags`
  ADD PRIMARY KEY (`course_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indexes for table `document_content`
--
ALTER TABLE `document_content`
  ADD PRIMARY KEY (`id_content`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`enrollment_id`),
  ADD UNIQUE KEY `unique_enrollment` (`student_id`,`course_id`),
  ADD KEY `fk_course` (`course_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tag_id`),
  ADD UNIQUE KEY `tag_name` (`tag_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `video_content`
--
ALTER TABLE `video_content`
  ADD PRIMARY KEY (`id_content`),
  ADD KEY `course_id` (`course_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `document_content`
--
ALTER TABLE `document_content`
  MODIFY `id_content` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `enrollment_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `tag_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `video_content`
--
ALTER TABLE `video_content`
  MODIFY `id_content` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`),
  ADD CONSTRAINT `courses_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `course_tags`
--
ALTER TABLE `course_tags`
  ADD CONSTRAINT `course_tags_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`tag_id`) ON DELETE CASCADE;

--
-- Constraints for table `document_content`
--
ALTER TABLE `document_content`
  ADD CONSTRAINT `document_content_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE;

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `fk_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_student` FOREIGN KEY (`student_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `video_content`
--
ALTER TABLE `video_content`
  ADD CONSTRAINT `video_content_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;