-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: May 21, 2024 at 02:20 PM
-- Server version: 5.7.39
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `travel`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment_travel`
--

CREATE TABLE `comment_travel` (
  `comment_id` int(11) NOT NULL,
  `t_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `comment_text` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `travel_category`
--

CREATE TABLE `travel_category` (
  `c_id` int(11) NOT NULL,
  `category_name` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `travel_category`
--

INSERT INTO `travel_category` (`c_id`, `category_name`, `date`) VALUES
(27, 'ทะเล', '2024-05-16 10:55:42'),
(29, 'ภูเขา', '2024-05-15 05:36:40'),
(33, 'แม่น้ำ', '2024-05-15 05:36:50'),
(41, 'อุทยานแห่งชาติ', '2024-05-16 10:55:51'),
(45, 'ทะเลสาบ', '2024-05-15 05:37:00');

-- --------------------------------------------------------

--
-- Table structure for table `travel_location`
--

CREATE TABLE `travel_location` (
  `_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `travel_name` text NOT NULL,
  `details_travel` text NOT NULL,
  `location_travel` text NOT NULL,
  `travel_view` int(255) NOT NULL DEFAULT '0',
  `travel_like` int(255) DEFAULT NULL,
  `travel_comment` int(255) DEFAULT NULL,
  `category` text NOT NULL,
  `image_travel` json NOT NULL,
  `status_allow` int(11) NOT NULL DEFAULT '0',
  `previnces` text NOT NULL,
  `regions` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_follow`
--

CREATE TABLE `user_follow` (
  `f_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `t_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_travel`
--

CREATE TABLE `user_travel` (
  `_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `sex` varchar(10) NOT NULL,
  `tel` varchar(10) NOT NULL,
  `image_avatar` text,
  `admin_check` varchar(10) NOT NULL DEFAULT 'User'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_travel`
--

INSERT INTO `user_travel` (`_id`, `username`, `fullname`, `password`, `address`, `sex`, `tel`, `image_avatar`, `admin_check`) VALUES
(981, 'supperadmin', 'supperadmin', 'b1ea1953b39a492db2395edef1dfbf43', '', '', '', '../uploads/avatar/GettyImages-1484700259-e1701910168429.webp', 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment_travel`
--
ALTER TABLE `comment_travel`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `travel_category`
--
ALTER TABLE `travel_category`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `travel_location`
--
ALTER TABLE `travel_location`
  ADD PRIMARY KEY (`_id`),
  ADD KEY `user_id` (`u_id`);

--
-- Indexes for table `user_follow`
--
ALTER TABLE `user_follow`
  ADD PRIMARY KEY (`f_id`);

--
-- Indexes for table `user_travel`
--
ALTER TABLE `user_travel`
  ADD PRIMARY KEY (`_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment_travel`
--
ALTER TABLE `comment_travel`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `travel_category`
--
ALTER TABLE `travel_category`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `travel_location`
--
ALTER TABLE `travel_location`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `user_follow`
--
ALTER TABLE `user_follow`
  MODIFY `f_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `user_travel`
--
ALTER TABLE `user_travel`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=982;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
