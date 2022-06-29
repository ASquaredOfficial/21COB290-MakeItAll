-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2022 at 12:46 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `email` varchar(320) NOT NULL,
  `department` varchar(255) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `job_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`email`, `department`, `phone_number`, `job_title`) VALUES
('somebody@gmail.com', 'HR', '071361636263', 'Jojji');

-- --------------------------------------------------------

--
-- Table structure for table `external_info`
--

CREATE TABLE `external_info` (
  `email` int(11) NOT NULL,
  `types` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`types`)),
  `expire` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `faq_id` int(11) NOT NULL,
  `faq_question` varchar(480) NOT NULL,
  `faq_answer` varchar(960) NOT NULL,
  `problem_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`faq_id`, `faq_question`, `faq_answer`, `problem_type`) VALUES
(1, 'Why does my mouse not work', 'Make sure it is plugged in. If it is wireless, check if the USB is inserted and check if the batteries need to be replaced.', 0),
(2, 'Why does my monitor now work', 'You haven\'t turned it on.', 0),
(3, 'Why is Microsoft Word laggy?', 'Close down any un-needed applications you may have running in the background', 1),
(4, 'Why are webpages taking forever to load?', 'Consider using a cabled connection.', 2);

-- --------------------------------------------------------

--
-- Table structure for table `hardware`
--

CREATE TABLE `hardware` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hardware`
--

INSERT INTO `hardware` (`id`, `name`) VALUES
(1, 'Mouse'),
(2, 'Keyboard'),
(3, 'PC'),
(4, 'Monitor'),
(5, 'HP Laptop'),
(6, 'Epson FAX'),
(7, 'Printer'),
(8, 'CD Player'),
(9, 'Lenovo Laptop'),
(10, 'Asus Laptop'),
(11, 'HP Desktop');

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `employee_email` varchar(320) NOT NULL,
  `specialist_email` varchar(320) NOT NULL,
  `description` text NOT NULL,
  `type_id` int(11) NOT NULL,
  `hardware_id` int(11) DEFAULT NULL,
  `software_id` int(11) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `os` varchar(255) NOT NULL,
  `archive` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`archive`)),
  `notes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `Solved_on` datetime NOT NULL,
  `status` enum('Open','Pending','Solved','') NOT NULL DEFAULT 'Open',
  `priority` enum('LOW','MEDIUM','HIGH','-') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`id`, `employee_email`, `specialist_email`, `description`, `type_id`, `hardware_id`, `software_id`, `created_on`, `os`, `archive`, `notes`, `Solved_on`, `status`, `priority`) VALUES
(1, 'user1', 'user2', 'Running really slowly, not responding and often crashing', 1, 9, NULL, '2019-01-15 16:25:00', 'Windows 10', NULL, 'Initial suggestion to re-boot.', '0000-00-00 00:00:00', 'Open', 'LOW'),
(2, 'user1', 'user2', 'Laptop running very slowly', 1, 5, NULL, '2016-10-03 09:00:00', 'Windows 8', NULL, 'Initial suggestion to re-boot. | Oct 3, 9.30am ~ caller phoned back to say rebooting didn’t work. Clara  assigned to problem. | Oct 5, 4.00pm ~ Clara called to say Windows CleanUp used to tidy up  disc space and delete unused temporary files. User can access Windows more easily and speedily.', '2016-10-05 16:00:00', 'Solved', '-'),
(3, 'user1', 'user2', 'Cannot connect to my account', 3, 10, NULL, '2016-10-03 09:15:00', 'Windows 10, Outlook 365', NULL, 'Passed straight to Clara. | Oct 4, 9.00pm ~ Clara called. Anti-virus software checks carried out,  etc. Computer appears to be uninfected, but can’t tell if any data has been stolen. User given an extensive  lecture on the dangers of using the wrong email  server. ', '2016-10-04 09:00:00', 'Solved', '-'),
(4, 'user1', 'user2', 'Tendency to eject CDs early', 1, 8, NULL, '2016-10-04 09:20:00', '-', NULL, 'Passed to Bert | Oct 5, 4.00pm ~ Bert called to add that though the user said the CD  was not strictly necessary he was concerned it could  lead him on a right “song and dance” if  he was ejected too soon. Therefore new CD reader ordered. | Oct 15, 10.05am ~ Bert called to say new CD reader now installed. As  it was a new series CD reader, the problem will not  occur again. ', '2016-10-15 10:05:00', 'Solved', '-'),
(5, 'user1', 'user2', 'Concerned about the strength of the firewall. In particular wants to keep out illegal messages from Mexico.', 3, 2, NULL, '2016-10-04 16:15:00', '-', NULL, 'Passed straight to Clara. | Oct 5, 9.00am ~ Clara called. Passed to Nick as it was a network  problem. | Oct 6, 10.15am ~ Nick called. Stronger firewall researched and costed  and passed to Mr. Trump. Costs are high so probably will never be implemented. ', '2016-10-06 10:15:00', 'Solved', '-'),
(6, 'user1', 'user2', 'Google Drive seems to be performing weirdly, it is unable to allow access to files and they are restricted', 2, 1, 5, '2021-10-14 18:20:00', '-', NULL, 'Passed straight to Bert', '0000-00-00 00:00:00', 'Open', 'MEDIUM'),
(7, 'user1', 'user2', 'Microsoft word will not save work no matter how many times it is pressed or the command is pressed', 2, 11, 1, '2022-01-01 14:27:00', '-', NULL, 'Re-install program | Jan 2 , 10.30am ~ After re-installing, the problem did not resolve therefore it was passed to Clara', '0000-00-00 00:00:00', 'Open', 'MEDIUM'),
(8, 'user1', 'user2', 'Microsoft Teams would not read the webcam or the microphone', 2, 0, 3, '2021-11-25 11:57:00', '-', NULL, 'Passed straight to Daniel', '0000-00-00 00:00:00', 'Open', 'LOW'),
(9, 'user1', 'user2', 'Will not let the department fax any of their documents that are essential to making the company run', 2, 0, 0, '2022-02-12 15:11:00', '-', NULL, 'Passed straight to Bert', '0000-00-00 00:00:00', 'Open', 'HIGH'),
(36, 'user1', 'user2', 'ytguiugyugo ougugo goujgogyo oto7g', 1, 2, 1, '2022-05-03 15:13:31', 'Windows', NULL, 'Passed straight to Adrian User | 7 May 2022, 7:30 pm ~ Found a way to do something | 12 May 2022, 11:40 am ~ dsfasdfsd', '0000-00-00 00:00:00', 'Open', 'HIGH'),
(38, 'user1', 'user2', 'My printer suddenly won\'t connect to my pc and I need to print this soon.', 1, 7, NULL, '2022-05-12 10:28:27', 'Windows', NULL, 'Passed straight to Alice Perry | 12 May 2022, 11:34 am ~ Try this, that... or GIVE UP', '0000-00-00 00:00:00', 'Open', 'HIGH');

-- --------------------------------------------------------

--
-- Table structure for table `problem_type`
--

CREATE TABLE `problem_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `parent_type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `problem_type`
--

INSERT INTO `problem_type` (`id`, `name`, `parent_type`) VALUES
(1, 'Hardware', NULL),
(2, 'Software', NULL),
(3, 'Network', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reseturl`
--

CREATE TABLE `reseturl` (
  `employee_email` varchar(320) NOT NULL,
  `reset_url` varchar(255) NOT NULL,
  `expire` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reseturl`
--

INSERT INTO `reseturl` (`employee_email`, `reset_url`, `expire`) VALUES
('', 'oKdI8amI', '2022-05-05 22:32:43'),
('adrian.abigaba@hotmail.co.uk', 'uCoxEz87', '2022-04-08 03:30:45');

-- --------------------------------------------------------

--
-- Table structure for table `software`
--

CREATE TABLE `software` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `software`
--

INSERT INTO `software` (`id`, `name`) VALUES
(1, 'Microsoft Word'),
(2, 'Google Spreadsheets'),
(3, 'Microsoft Teams'),
(4, 'Zoom'),
(5, 'Google Drive'),
(6, 'Microsoft Excel');

-- --------------------------------------------------------

--
-- Table structure for table `specialist_info`
--

CREATE TABLE `specialist_info` (
  `email` varchar(320) NOT NULL,
  `types` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`types`)),
  `available` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `specialist_info`
--

INSERT INTO `specialist_info` (`email`, `types`, `available`) VALUES
('user2', '[1,2]', 1),
('user6', '[1,3]', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `email` varchar(320) NOT NULL,
  `password` varchar(100) NOT NULL,
  `first_name` varchar(40) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `role` enum('Employee','Specialist','External','Admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`email`, `password`, `first_name`, `last_name`, `role`) VALUES
('alice101@makeitall.com', '$2b$10$jfdRv94RXrYYyU5wQ4tnHubptkm/hT3dnARYQC5.e0tI/uALcz9GS', 'Alice', 'Perry', 'Employee'),
('somebody@gmail.com', 'password', 'Daniel', 'dada', 'Employee'),
('user1', '$2b$10$jfdRv94RXrYYyU5wQ4tnHubptkm/hT3dnARYQC5.e0tI/uALcz9GS', 'Adrian', 'User', 'Employee'),
('user2', '$2b$10$jfdRv94RXrYYyU5wQ4tnHubptkm/hT3dnARYQC5.e0tI/uALcz9GS', 'Adrian', 'Specialist', 'Specialist'),
('user3', '$2b$10$jfdRv94RXrYYyU5wQ4tnHubptkm/hT3dnARYQC5.e0tI/uALcz9GS', 'Adrian', 'Admin', 'Admin'),
('user4', '$2b$10$jfdRv94RXrYYyU5wQ4tnHubptkm/hT3dnARYQC5.e0tI/uALcz9GS', 'Adrian', 'External', 'External'),
('user6', '$2b$10$jfdRv94RXrYYyU5wQ4tnHubptkm/hT3dnARYQC5.e0tI/uALcz9GS', 'Adrianito Sasukawa', 'Specialist2', 'Specialist');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `external_info`
--
ALTER TABLE `external_info`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`faq_id`);

--
-- Indexes for table `hardware`
--
ALTER TABLE `hardware`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `problem_type`
--
ALTER TABLE `problem_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `reseturl`
--
ALTER TABLE `reseturl`
  ADD PRIMARY KEY (`employee_email`);

--
-- Indexes for table `software`
--
ALTER TABLE `software`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `specialist_info`
--
ALTER TABLE `specialist_info`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `problem_type`
--
ALTER TABLE `problem_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `specialist_info`
--
ALTER TABLE `specialist_info`
  ADD CONSTRAINT `specialist_info_ibfk_1` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
