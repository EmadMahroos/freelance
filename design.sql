-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 24, 2024 at 11:47 PM
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
-- Database: `design`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `client_id` int(11) NOT NULL,
  `client_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `reg_status` tinyint(4) NOT NULL DEFAULT 0,
  `last_activity` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL DEFAULT 'img.jpg',
  `online_status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`client_id`, `client_name`, `address`, `email`, `phone_number`, `password`, `start_date`, `reg_status`, `last_activity`, `logo`, `online_status`) VALUES
(8, 'emad mahroos', '4 ibrahim salem branched from El-dosctor st in twabk in faysel st in giza', 'emadibrahim224@gmail.com', '01145103528', '601f1889667efaebb33b8c12572835da3f027f78', '2020-10-14', 1, '2024-07-25 00:45:35', '78110_IMG_20200418_121934_20200423181509929.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `adding_date` datetime NOT NULL DEFAULT current_timestamp(),
  `comment_owner` int(11) NOT NULL,
  `comment_job` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `comment`, `adding_date`, `comment_owner`, `comment_job`) VALUES
(65, 'ttt', '2020-11-08 13:42:01', 8, 23),
(66, 'vvv', '2020-11-08 15:53:13', 8, 23),
(67, 'ggggggggg\n', '2020-11-08 16:00:58', 8, 23);

-- --------------------------------------------------------

--
-- Table structure for table `contacting`
--

CREATE TABLE `contacting` (
  `contact_id` int(11) NOT NULL,
  `sms` text NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `adding_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `contacting`
--

INSERT INTO `contacting` (`contact_id`, `sms`, `name`, `email`, `adding_date`) VALUES
(4, 'tttttttttttttttttttttttttt', 'aly essam', 'aly@gmail.com', '2020-10-13 23:23:52'),
(5, 'hhhhhhhhhhhhhhhhhhhhhhhhhh', 'aly', 'aly@gmail.com', '2020-10-13 23:36:40'),
(6, 'hhhhhhhhhhhhh', 'omar', 'omar@gmail.com', '2020-10-13 23:37:21'),
(7, 'ttttttttttttttttttt', 'omar hamed', 'omar@gmail.com', '2020-10-13 23:37:52');

-- --------------------------------------------------------

--
-- Table structure for table `finished_jobs`
--

CREATE TABLE `finished_jobs` (
  `job_id` int(11) NOT NULL,
  `job_name` varchar(255) NOT NULL,
  `job_link` varchar(255) NOT NULL,
  `jobs_screenshoots` varchar(255) NOT NULL,
  `ending_date` date NOT NULL,
  `job_owner` int(11) NOT NULL,
  `description` text NOT NULL,
  `feedback` text NOT NULL,
  `owner_name` varchar(255) NOT NULL,
  `owner_email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `finished_jobs`
--

INSERT INTO `finished_jobs` (`job_id`, `job_name`, `job_link`, `jobs_screenshoots`, `ending_date`, `job_owner`, `description`, `feedback`, `owner_name`, `owner_email`) VALUES
(23, 'عماد الدين ابراهيم', 'aaaaaaaaaaaaaaaaaaaa', '75086_IMG-20190606-WA0002.jpg,35095_thumbdata-60_15.3096576.jpg,15698_IMG_20190710_030737.jpg', '2020-11-02', 8, 'web  descripttion web  descripttion web  descripttion web  descripttion web  descripttion web  descripttion web  descripttion web  descripttion web  descripttion web  descripttion web  descripttion web  descripttion web  descripttion web  descripttion ', '', 'emad ibrahim', 'emadibrahim224@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `job_id` int(11) NOT NULL,
  `job_name` varchar(255) NOT NULL,
  `job_description` varchar(255) NOT NULL,
  `job_owner` int(11) NOT NULL,
  `adding_date` date NOT NULL,
  `status` tinyint(4) NOT NULL,
  `budget` tinyint(4) NOT NULL DEFAULT 0,
  `photos` varchar(255) NOT NULL,
  `finish` tinyint(4) NOT NULL DEFAULT 0,
  `progress` int(11) NOT NULL DEFAULT 0,
  `feedback` text NOT NULL,
  `owner_name` varchar(255) NOT NULL,
  `owner_email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`job_id`, `job_name`, `job_description`, `job_owner`, `adding_date`, `status`, `budget`, `photos`, `finish`, `progress`, `feedback`, `owner_name`, `owner_email`) VALUES
(23, 'عماد الدين ابراهيم', 'عباره عن موقع تجاره يسمح  لي بيع منتجات متنوعه مثل ادوات الحلاقه وقطع غيار السيارات عباره عن موقع تجاره يسمح  لي بيع منتجات متنوعه مثل ادوات الحلاقه وقطع غيار السيارات', 8, '2020-10-20', 1, 1, '98581_jpg,47058_png,63480_thumbdata-60_15.3096576.jpg', 1, 0, 'changing a file', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `msg_id` int(11) NOT NULL,
  `msg` varchar(255) NOT NULL,
  `sender` int(11) NOT NULL,
  `reciever` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notificationss`
--

CREATE TABLE `notificationss` (
  `notification_id` int(11) NOT NULL,
  `notification_description` text NOT NULL,
  `sender` int(11) NOT NULL,
  `reciever` int(11) NOT NULL,
  `reciever_email` varchar(255) NOT NULL,
  `sender_name` varchar(255) NOT NULL,
  `seen` int(11) NOT NULL DEFAULT 0,
  `job_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sms_notifications`
--

CREATE TABLE `sms_notifications` (
  `notification_id` int(11) NOT NULL,
  `notification_description` text NOT NULL,
  `sender` int(11) NOT NULL,
  `reciever` int(11) NOT NULL,
  `reciever_email` varchar(255) NOT NULL,
  `sender_name` varchar(255) NOT NULL,
  `seen` int(11) NOT NULL DEFAULT 0,
  `time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`client_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `comments_ibfk_1` (`comment_owner`),
  ADD KEY `comments_ibfk_2` (`comment_job`);

--
-- Indexes for table `contacting`
--
ALTER TABLE `contacting`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `finished_jobs`
--
ALTER TABLE `finished_jobs`
  ADD PRIMARY KEY (`job_id`),
  ADD KEY `job_owner` (`job_owner`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`job_id`),
  ADD KEY `job_owner` (`job_owner`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`msg_id`),
  ADD KEY `reciever` (`reciever`),
  ADD KEY `sender` (`sender`);

--
-- Indexes for table `notificationss`
--
ALTER TABLE `notificationss`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `reciever_email` (`reciever_email`),
  ADD KEY `job_id` (`job_id`),
  ADD KEY `comment_id` (`comment_id`);

--
-- Indexes for table `sms_notifications`
--
ALTER TABLE `sms_notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `reciever` (`reciever`),
  ADD KEY `sender` (`sender`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `contacting`
--
ALTER TABLE `contacting`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT for table `notificationss`
--
ALTER TABLE `notificationss`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `sms_notifications`
--
ALTER TABLE `sms_notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`comment_owner`) REFERENCES `clients` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`comment_job`) REFERENCES `finished_jobs` (`job_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `finished_jobs`
--
ALTER TABLE `finished_jobs`
  ADD CONSTRAINT `finished_jobs_ibfk_1` FOREIGN KEY (`job_owner`) REFERENCES `clients` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `finished_jobs_ibfk_2` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`job_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `jobs_ibfk_1` FOREIGN KEY (`job_owner`) REFERENCES `clients` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`reciever`) REFERENCES `clients` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`sender`) REFERENCES `clients` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notificationss`
--
ALTER TABLE `notificationss`
  ADD CONSTRAINT `notificationss_ibfk_1` FOREIGN KEY (`reciever_email`) REFERENCES `clients` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notificationss_ibfk_2` FOREIGN KEY (`job_id`) REFERENCES `finished_jobs` (`job_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notificationss_ibfk_3` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`comment_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sms_notifications`
--
ALTER TABLE `sms_notifications`
  ADD CONSTRAINT `sms_notifications_ibfk_1` FOREIGN KEY (`reciever`) REFERENCES `clients` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sms_notifications_ibfk_2` FOREIGN KEY (`sender`) REFERENCES `clients` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
