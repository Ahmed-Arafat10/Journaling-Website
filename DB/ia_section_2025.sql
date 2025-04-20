-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2025 at 06:01 PM
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
-- Database: `ia_section_2025`
--

-- --------------------------------------------------------

--
-- Table structure for table `to-do-list`
--

CREATE TABLE `to-do-list` (
  `id` int(11) NOT NULL,
  `note` varchar(2000) NOT NULL,
  `is_done` tinyint(1) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `to-do-list`
--

INSERT INTO `to-do-list` (`id`, `note`, `is_done`, `user_id`, `date`) VALUES
(1, 'test', 0, 2, '2025-04-18 09:47:08'),
(3, 'HELLO BIS', 1, 3, '2025-04-20 12:18:11'),
(4, 'helloooooo', 0, 3, '2025-04-20 12:21:13'),
(5, 'finish IA Section Video', 0, 2, '2025-04-19 12:45:06'),
(6, 'Finish your BIS lectures', 0, 3, '2025-04-20 14:26:42'),
(7, 'xyz', 1, 3, '2025-04-20 14:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`) VALUES
(2, 'Ahmed Yousry', 'ahmed@gmail.com', '$2y$10$j9D6hZQq8DLWeVgBuhvuuePn6fAai/cPNQ74qn.jBqVwF6pXQIQe2'),
(3, 'ahmed arafat', 'arafat@gmail.com', '$2y$10$8Bqosg0CovKOCX2ztEjH2OvF.ZIwX/DGCLx.AGnyNR1U1ggf4fbBq'),
(4, 'drop database ia_section_2025', 'ssd@gmail.com', '$2y$10$jp6F6IyPbZr4q9J9yD8YU.5ylbcNLg/t4g2LAa9gfT1OpvrmamsL.'),
(5, 'Yousef', 'sdfs@gmail.com', '$2y$10$M52tjsjUPCoScxPveIvWxuOj0vR3KBW9Q9EJxnp4QdGqQZdbpU2SG'),
(6, 'ahmed', 'ahmed123@gmail.com', '$2y$10$1/Ssul8ya4W/7UeOtWabte1CD/5VTMJnuGLop6afIOCGmUpCWm85.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `to-do-list`
--
ALTER TABLE `to-do-list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `to-do-list`
--
ALTER TABLE `to-do-list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `to-do-list`
--
ALTER TABLE `to-do-list`
  ADD CONSTRAINT `to-do-list_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
