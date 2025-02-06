-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2024 at 10:41 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `team6_maternaltracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int(11) NOT NULL,
  `appointment_name` varchar(100) NOT NULL,
  `appointment_time` datetime NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `status` enum('Scheduled','Completed','Cancelled') DEFAULT 'Scheduled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`appointment_id`, `appointment_name`, `appointment_time`, `patient_id`, `status`) VALUES
(1, 'Ultrasound Appointment', '2024-12-16 02:40:00', 2, 'Scheduled');

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `doctor_id` int(11) NOT NULL,
  `doctorName` varchar(30) NOT NULL,
  `contact` int(10) NOT NULL,
  `email_adress` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`doctor_id`, `doctorName`, `contact`, `email_adress`) VALUES
(1, 'Tonny Twesigye', 755645430, 'tonnytwesigye@exness.com'),
(2, 'Daniel P-Specialist', 755555530, 'danielbps@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `healthrecords`
--

CREATE TABLE `healthrecords` (
  `record_id` int(11) NOT NULL,
  `visit_date` date NOT NULL,
  `blood_pressure` varchar(20) NOT NULL,
  `weight` decimal(5,2) NOT NULL,
  `haemoglobin` decimal(5,2) NOT NULL,
  `complications` text DEFAULT NULL,
  `patient_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `healthrecords`
--

INSERT INTO `healthrecords` (`record_id`, `visit_date`, `blood_pressure`, `weight`, `haemoglobin`, `complications`, `patient_id`) VALUES
(1, '2024-12-16', '118', '56.00', '5.50', 'fatigue', 1),
(2, '2024-12-16', '118', '56.00', '5.50', 'fatigue', 1),
(3, '2024-12-16', '118', '56.00', '5.50', 'fatigue', 1),
(4, '2024-12-16', '118', '56.00', '5.50', 'fatigue', 1),
(5, '2024-12-16', '118', '56.00', '5.50', 'fatigue', 1),
(6, '2024-12-09', '120', '76.00', '7.20', 'Pangs, contractions\r\n', 1),
(7, '2024-12-12', '330', '76.00', '4.70', 'NAUSIA', 1),
(8, '2024-12-19', '330', '76.00', '4.70', 'nausia', 4);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `notification_type` varchar(50) NOT NULL,
  `recipient_email` varchar(100) NOT NULL,
  `subject` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `appointment_id` int(11) DEFAULT NULL,
  `status` enum('Pending','Sent','Failed') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `notification_type`, `recipient_email`, `subject`, `message`, `patient_id`, `doctor_id`, `appointment_id`, `status`) VALUES
(1, 'alert', 'jojo@gmail.com', 'Pangs', 'I\'m having pangs', 1, NULL, NULL, 'Pending'),
(2, 'reminder', 'jojo@gmail.com', 'Tummyache and vomiting', 'appointment!', 2, NULL, NULL, 'Pending'),
(3, 'alert', 'jojo@gmail.com', 'Tummyache and vomiting', 'I need to see you, doctor!!!', 2, 2, NULL, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `patient_id` int(11) NOT NULL,
  `patient_name` varchar(100) NOT NULL,
  `patient_contact` varchar(15) NOT NULL,
  `patient_email` varchar(100) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `medical_history` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`patient_id`, `patient_name`, `patient_contact`, `patient_email`, `age`, `address`, `medical_history`) VALUES
(1, 'Daniella', '0774554383', 'boy@gmail.com', 25, 'Kihumuro', 'first time pregnant'),
(2, 'Jovita', '0776775643', 'jojo@gmail.com', 23, 'Kihumuro LF01', 'testing testing'),
(3, 'Reby', '0776457753', 'reb@gmail.com', 27, 'Kihumuro', 'first test'),
(4, 'AIne', '0774667890', 'aine@gmail.com', 22, 'Ladies hall', 'Second time');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `first_name`, `last_name`, `created_at`, `updated_at`) VALUES
(1, 'jojo', '$2y$10$gmVhL/0x.BgvVso48XF4u.tYDbDqrDViSVstlf9NRGBvWhSrIBjA.', 'jojo@gmail.com', 'Natukunda', 'Jovita', '2024-12-16 08:27:01', '2024-12-16 08:27:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`doctor_id`);

--
-- Indexes for table `healthrecords`
--
ALTER TABLE `healthrecords`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `appointment_id` (`appointment_id`),
  ADD KEY `fk_doctor_id` (`doctor_id`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`patient_id`),
  ADD UNIQUE KEY `patient_email` (`patient_email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `doctor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `healthrecords`
--
ALTER TABLE `healthrecords`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`);

--
-- Constraints for table `healthrecords`
--
ALTER TABLE `healthrecords`
  ADD CONSTRAINT `healthrecords_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_doctor_id` FOREIGN KEY (`doctor_id`) REFERENCES `doctor` (`doctor_id`),
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`),
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`appointment_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
