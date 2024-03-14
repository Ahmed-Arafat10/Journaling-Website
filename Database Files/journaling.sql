-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2022 at 12:40 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `journaling`
--

-- --------------------------------------------------------

--
-- Table structure for table `answer_of_questions`
--

CREATE TABLE `answer_of_questions` (
  `ID` int(11) NOT NULL,
  `Date_ID` int(11) NOT NULL,
  `QuestionID` int(11) NOT NULL,
  `Answer` mediumtext NOT NULL,
  `User_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `answer_of_questions`
--

INSERT INTO `answer_of_questions` (`ID`, `Date_ID`, `QuestionID`, `Answer`, `User_ID`) VALUES
(25, 2, 6, 'Great', 2);

-- --------------------------------------------------------

--
-- Table structure for table `date`
--

CREATE TABLE `date` (
  `ID` int(11) NOT NULL,
  `Date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `date`
--

INSERT INTO `date` (`ID`, `Date`) VALUES
(1, '2022-01-02'),
(2, '2022-01-03'),
(3, '2022-01-04'),
(4, '2022-01-08'),
(5, '2022-01-09'),
(6, '2022-01-10');

-- --------------------------------------------------------

--
-- Table structure for table `diary`
--

CREATE TABLE `diary` (
  `ID` int(11) NOT NULL,
  `Date_ID` int(11) NOT NULL,
  `Diary` longtext NOT NULL,
  `User_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `diary`
--

INSERT INTO `diary` (`ID`, `Date_ID`, `Diary`, `User_ID`) VALUES
(3, 2, 'day # in Diary updated', 0),
(5, 2, 'dddd', 0),
(6, 1, 'dasd', 0),
(7, 4, 'dfdsfd dfdkjfdskjf ifdfokdg\r\nfgdfgdfgdfgdgdfg', 0),
(9, 5, 'hello', 2),
(10, 6, 'sdsaasdas', 2);

-- --------------------------------------------------------

--
-- Table structure for table `predefined-questions`
--

CREATE TABLE `predefined-questions` (
  `ID` int(11) NOT NULL,
  `Question` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `predefined-questions`
--

INSERT INTO `predefined-questions` (`ID`, `Question`) VALUES
(6, 'What is the thing that mark today?'),
(7, 'What you have acheived today?'),
(8, 'What you have learned today?'),
(9, 'What is the thing you are regret about?'),
(10, 'What is worst thing today?'),
(11, 'What is your feeling along day ?'),
(12, 'What ideas came to your mind?');

-- --------------------------------------------------------

--
-- Table structure for table `to-do-list`
--

CREATE TABLE `to-do-list` (
  `ID` int(11) NOT NULL,
  `Date_ID` int(11) NOT NULL,
  `Note` varchar(2000) NOT NULL,
  `Is_Done` bit(2) NOT NULL,
  `User_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `to-do-list`
--

INSERT INTO `to-do-list` (`ID`, `Date_ID`, `Note`, `Is_Done`, `User_ID`) VALUES
(1, 1, 'Hello World', b'01', 0),
(3, 2, 'day #2 UPDATED', b'00', 0),
(7, 2, 'dfs', b'00', 0),
(8, 4, 'xyz', b'00', 0),
(9, 4, 'hello', b'00', 0),
(10, 4, 'test', b'01', 0),
(12, 5, 'Working On IA Project', b'01', 0),
(13, 5, 'Working On IA Project', b'01', 2),
(14, 6, 'Hello World', b'00', 2),
(15, 6, 'Working On IA Project', b'00', 1),
(16, 6, 'sss', b'00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID`, `Name`, `Password`, `Email`) VALUES
(1, 'ging', '123', 'ahmedmoyousry.bis@gmail.com'),
(2, 'ahmed', '123', 'ahmedmoyousry.bis@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answer_of_questions`
--
ALTER TABLE `answer_of_questions`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `date`
--
ALTER TABLE `date`
  ADD PRIMARY KEY (`ID`) USING BTREE;

--
-- Indexes for table `diary`
--
ALTER TABLE `diary`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `predefined-questions`
--
ALTER TABLE `predefined-questions`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `to-do-list`
--
ALTER TABLE `to-do-list`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answer_of_questions`
--
ALTER TABLE `answer_of_questions`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `date`
--
ALTER TABLE `date`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `diary`
--
ALTER TABLE `diary`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `predefined-questions`
--
ALTER TABLE `predefined-questions`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `to-do-list`
--
ALTER TABLE `to-do-list`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
