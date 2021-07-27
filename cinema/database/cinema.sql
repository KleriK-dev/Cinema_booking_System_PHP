-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2021 at 08:55 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cinema`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `booking_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `booked_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `canceledbookings`
--

CREATE TABLE `canceledbookings` (
  `canceled_bookingID` int(11) NOT NULL,
  `c_Email` varchar(128) NOT NULL,
  `movie` varchar(128) NOT NULL,
  `room` varchar(128) NOT NULL,
  `seat` varchar(5) NOT NULL,
  `s_date` date NOT NULL,
  `s_time` time NOT NULL,
  `cancelDate` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `canceledschedules`
--

CREATE TABLE `canceledschedules` (
  `cS_id` int(11) NOT NULL,
  `movieName` varchar(128) NOT NULL,
  `roomName` varchar(128) NOT NULL,
  `startDate` date NOT NULL,
  `startHours` time NOT NULL,
  `cancelDate` datetime NOT NULL DEFAULT current_timestamp(),
  `schedule_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `completed_bookings`
--

CREATE TABLE `completed_bookings` (
  `compB_id` int(11) NOT NULL,
  `userEmail` varchar(128) NOT NULL,
  `movieName` varchar(128) NOT NULL,
  `roomName` varchar(128) NOT NULL,
  `seatName` varchar(5) NOT NULL,
  `startDate` date NOT NULL,
  `startHours` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `completed_schedule`
--

CREATE TABLE `completed_schedule` (
  `compS_id` int(11) NOT NULL,
  `movieName` varchar(128) NOT NULL,
  `roomName` varchar(128) NOT NULL,
  `startDate` date NOT NULL,
  `startHours` time NOT NULL,
  `schedule_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `movie_id` int(11) NOT NULL,
  `movieName` varchar(128) NOT NULL,
  `movieImage` longblob NOT NULL,
  `movieDescription` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `reservedseats`
--

CREATE TABLE `reservedseats` (
  `reservedSeat_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `seatName` varchar(5) NOT NULL,
  `seat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `roomName` varchar(128) NOT NULL,
  `seat_column` int(11) NOT NULL,
  `seat_row` int(11) NOT NULL,
  `roomDescription` mediumtext NOT NULL,
  `room_image` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `schedule_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `startDate` date NOT NULL,
  `startHours` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `seat_id` int(255) NOT NULL,
  `seatName` varchar(5) NOT NULL,
  `seatStatus` varchar(20) NOT NULL DEFAULT 'Not booked',
  `roomName` varchar(128) NOT NULL,
  `startDate` date NOT NULL,
  `startHours` time NOT NULL,
  `movieName` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `userFirstName` varchar(128) NOT NULL,
  `userLastName` varchar(100) NOT NULL,
  `userEmail` varchar(128) NOT NULL,
  `userName` varchar(128) NOT NULL,
  `userPassw` varchar(128) NOT NULL,
  `userPhone` varchar(100) NOT NULL,
  `role` varchar(128) DEFAULT 'Customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `userFirstName`, `userLastName`, `userEmail`, `userName`, `userPassw`, `userPhone`, `role`) VALUES
(2, 'admin', 'admin', 'admin@admin.com', 'user', '$2y$10$t6DUsVZd/4ebszjeSngdL.tTotnXoW/AEqB6MmWyQzg1U09JGuvRG', '11111111111', 'Administrator');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `schedule_id` (`schedule_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `canceledbookings`
--
ALTER TABLE `canceledbookings`
  ADD PRIMARY KEY (`canceled_bookingID`);

--
-- Indexes for table `canceledschedules`
--
ALTER TABLE `canceledschedules`
  ADD PRIMARY KEY (`cS_id`);

--
-- Indexes for table `completed_bookings`
--
ALTER TABLE `completed_bookings`
  ADD PRIMARY KEY (`compB_id`);

--
-- Indexes for table `completed_schedule`
--
ALTER TABLE `completed_schedule`
  ADD PRIMARY KEY (`compS_id`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`movie_id`);

--
-- Indexes for table `reservedseats`
--
ALTER TABLE `reservedseats`
  ADD PRIMARY KEY (`reservedSeat_id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `seat_id` (`seat_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `movie_id` (`movie_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`seat_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `canceledbookings`
--
ALTER TABLE `canceledbookings`
  MODIFY `canceled_bookingID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `canceledschedules`
--
ALTER TABLE `canceledschedules`
  MODIFY `cS_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `completed_bookings`
--
ALTER TABLE `completed_bookings`
  MODIFY `compB_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `completed_schedule`
--
ALTER TABLE `completed_schedule`
  MODIFY `compS_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `movie_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservedseats`
--
ALTER TABLE `reservedseats`
  MODIFY `reservedSeat_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `seat_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`schedule_id`) REFERENCES `schedule` (`schedule_id`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`userID`);

--
-- Constraints for table `reservedseats`
--
ALTER TABLE `reservedseats`
  ADD CONSTRAINT `reservedseats_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`booking_id`);

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`),
  ADD CONSTRAINT `schedule_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
