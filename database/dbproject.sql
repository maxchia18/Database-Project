-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2022 at 04:23 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `blood`
--

CREATE TABLE `blood` (
  `BloodID` int(5) NOT NULL,
  `BloodGroup` char(2) NOT NULL,
  `DonorID` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `blood`
--

INSERT INTO `blood` (`BloodID`, `BloodGroup`, `DonorID`) VALUES
(1, 'A+', 2),
(2, 'A-', 3),
(3, 'B+', 4);

-- --------------------------------------------------------

--
-- Table structure for table `donationcentre`
--

CREATE TABLE `donationcentre` (
  `CentreID` int(5) NOT NULL,
  `CentreName` varchar(120) NOT NULL,
  `CentreAddress` varchar(120) NOT NULL,
  `StartTime` time NOT NULL,
  `EndTime` time NOT NULL,
  `TelNo` varchar(15) NOT NULL,
  `CentreType` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `donationcentre`
--

INSERT INTO `donationcentre` (`CentreID`, `CentreName`, `CentreAddress`, `StartTime`, `EndTime`, `TelNo`, `CentreType`) VALUES
(1, 'Pusat Darah Negara', 'Jalan Tun Razak,50400 Kuala Lumpur', '08:00:00', '17:00:00', '01-3448833', 'B'),
(2, 'Hospital Sultanah Aminah', 'Unit Transfusi Perubatan, 80100 Johor Bharu,Johor.', '08:00:00', '17:00:00', '07-3561231', 'B'),
(3, 'Hospital Tuanku Jaafar', 'Unit Transfusi Perubatan,Jalan Rasah,70300 Seremban,Negeri Sembilan', '08:00:00', '17:00:00', '02-3561111', 'B'),
(4, 'UCSI Group Showroom', 'Level 1,Block A,50400 Kuala Lumpur', '10:00:00', '17:00:00', '07-1245159', 'M'),
(5, 'Hospital Queen Elizabeth', 'Unit Transfusi Perubatan,88586 Kota Kinabalu, Sabah', '08:00:00', '17:00:00', '06-3565879', 'B'),
(6, 'AEON MALL Kuching Central', 'Jalan Tun Datuk Patinggi, 93200 Kuching, Sarawak.', '08:00:00', '17:00:00', '03-4442088', 'M'),
(7, 'Lahad Datu Great Eastern Branch Office', 'Ground & 1st Floor MDLD 0819, Jalan Teratal 91100 Lahad Datu, Sabah', '10:00:00', '17:00:00', '03-3565222', 'M'),
(8, 'Hospital Pulau Pinang', 'Unit Transfusi Perubatan,Jalan Residensi,10450 Pulau Pinang.', '08:00:00', '17:00:00', '07-1513411', 'B'),
(9, 'Kluang Great Eastern Branch Office', 'No.22 & 24, Jalan Md Lazim Saim,86000 Kluang, Johor. ', '10:00:00', '17:00:00', '07-3514141', 'M'),
(10, 'Uniciti Alam Residential College, UniMAP', 'Jalan Wang Ulu Arau, Sg. Chuchuh, 01000 Kangar, Perlis.', '08:00:00', '17:00:00', '07-3565088', 'M');

-- --------------------------------------------------------

--
-- Table structure for table `donor`
--

CREATE TABLE `donor` (
  `UserID` int(10) NOT NULL,
  `Weight` double NOT NULL,
  `Age` int(2) NOT NULL,
  `HealthStatus` tinyint(1) NOT NULL DEFAULT 1,
  `IsWhole` tinyint(1) NOT NULL DEFAULT 1,
  `IsAphresis` tinyint(1) NOT NULL DEFAULT 0,
  `LastDonationDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `donor`
--

INSERT INTO `donor` (`UserID`, `Weight`, `Age`, `HealthStatus`, `IsWhole`, `IsAphresis`, `LastDonationDate`) VALUES
(2, 55, 21, 1, 1, 0, NULL),
(3, 65, 22, 1, 1, 0, NULL),
(4, 56, 44, 1, 1, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `UserID` int(5) NOT NULL,
  `CentreID` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`UserID`, `CentreID`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` int(10) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `UserType` char(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `FirstName`, `LastName`, `Email`, `Password`, `UserType`) VALUES
(1, 'Max', 'Chia', '75590@siswa.unimas.my', '$2y$10$by9PuERUFxh5q69MeD0/LOXfGFidmXNQbx8VYszV/XBG6MXXiEpXm', 'staff'),
(2, 'Kha Hau', 'Chong', 'khahau@gmail.com', '$2y$10$OKWbC7R8PdKhuQ/k4LmKqufajZ70Hg.XCQJ1Iy7T4RzD9HeVqny36', 'donor'),
(3, 'Brady', 'Chung', 'brady@gmail.com', '$2y$10$FbkwmwRndhNJNl7o08s1R.2csMBng7KxONdT5LEFtEgqoukIkFW3q', 'donor'),
(4, 'Muhammad', 'Syahin', 'syahin@gmail.com', '$2y$10$ghe1OOtkW3p1tYnB9XTEhOCmn3GyIT0bAGxPElOgtYEcuhABlwcJi', 'donor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blood`
--
ALTER TABLE `blood`
  ADD PRIMARY KEY (`BloodID`,`DonorID`),
  ADD UNIQUE KEY `DonorID` (`DonorID`);

--
-- Indexes for table `donationcentre`
--
ALTER TABLE `donationcentre`
  ADD PRIMARY KEY (`CentreID`);

--
-- Indexes for table `donor`
--
ALTER TABLE `donor`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`UserID`),
  ADD KEY `employ` (`CentreID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blood`
--
ALTER TABLE `blood`
  MODIFY `BloodID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blood`
--
ALTER TABLE `blood`
  ADD CONSTRAINT `userID` FOREIGN KEY (`DonorID`) REFERENCES `donor` (`UserID`);

--
-- Constraints for table `donor`
--
ALTER TABLE `donor`
  ADD CONSTRAINT `donor-user` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `employ` FOREIGN KEY (`CentreID`) REFERENCES `donationcentre` (`CentreID`),
  ADD CONSTRAINT `staff-user` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
