-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2022 at 02:16 PM
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
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `AppointmentID` int(5) NOT NULL,
  `DonorID` int(5) NOT NULL,
  `AppointedDate` date NOT NULL,
  `AppointedSession` time NOT NULL,
  `IsCompleted` tinyint(1) NOT NULL DEFAULT 0,
  `CentreID` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`AppointmentID`, `DonorID`, `AppointedDate`, `AppointedSession`, `IsCompleted`, `CentreID`) VALUES
(1, 4, '2022-07-08', '11:00:00', 0, 1),
(2, 2, '2022-07-09', '15:00:00', 0, 8),
(3, 3, '2022-06-30', '09:00:00', 0, 7),
(4, 5, '2022-06-28', '10:00:00', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `blood`
--

CREATE TABLE `blood` (
  `BloodID` int(5) NOT NULL,
  `BloodGroup` char(2) NOT NULL,
  `HaemoglobinLevel` double DEFAULT NULL,
  `DonorID` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `blood`
--

INSERT INTO `blood` (`BloodID`, `BloodGroup`, `HaemoglobinLevel`, `DonorID`) VALUES
(1, 'A+', NULL, 2),
(2, 'A-', NULL, 3),
(3, 'B+', NULL, 4),
(4, 'B-', NULL, 5),
(5, 'A+', NULL, 6),
(6, 'A-', NULL, 7),
(7, 'B+', NULL, 8);

-- --------------------------------------------------------

--
-- Table structure for table `bloodbankcentre`
--

CREATE TABLE `bloodbankcentre` (
  `CentreID` int(5) NOT NULL,
  `TelFax` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bloodbankcentre`
--

INSERT INTO `bloodbankcentre` (`CentreID`, `TelFax`) VALUES
(1, '03-2698 0328'),
(2, '07-356 5088'),
(3, '06-763 2900'),
(5, '088-257 256'),
(8, '04-200 2155');

-- --------------------------------------------------------

--
-- Table structure for table `donationcentre`
--

CREATE TABLE `donationcentre` (
  `CentreID` int(5) NOT NULL,
  `CentreName` varchar(120) NOT NULL,
  `CentreAddress` varchar(120) NOT NULL,
  `TelNo` varchar(15) NOT NULL,
  `CentreType` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `donationcentre`
--

INSERT INTO `donationcentre` (`CentreID`, `CentreName`, `CentreAddress`, `TelNo`, `CentreType`) VALUES
(1, 'Pusat Darah Negara', 'Jalan Tun Razak,50400 Kuala Lumpur', '01-3448833', 'B'),
(2, 'Hospital Sultanah Aminah', 'Unit Transfusi Perubatan, 80100 Johor Bharu,Johor.', '07-3561231', 'B'),
(3, 'Hospital Tuanku Jaafar', 'Unit Transfusi Perubatan,Jalan Rasah,70300 Seremban,Negeri Sembilan', '02-3561111', 'B'),
(4, 'UCSI Group Showroom', 'Level 1,Block A,50400 Kuala Lumpur', '07-1245159', 'M'),
(5, 'Hospital Queen Elizabeth', 'Unit Transfusi Perubatan,88586 Kota Kinabalu, Sabah', '06-3565879', 'B'),
(6, 'AEON MALL Kuching Central', 'Jalan Tun Datuk Patinggi, 93200 Kuching, Sarawak.', '03-4442088', 'M'),
(7, 'Lahad Datu Great Eastern Branch Office', 'Ground & 1st Floor MDLD 0819, Jalan Teratal 91100 Lahad Datu, Sabah', '03-3565222', 'M'),
(8, 'Hospital Pulau Pinang', 'Unit Transfusi Perubatan,Jalan Residensi,10450 Pulau Pinang.', '07-1513411', 'B'),
(9, 'Kluang Great Eastern Branch Office', 'No.22 & 24, Jalan Md Lazim Saim,86000 Kluang, Johor. ', '07-3514141', 'M'),
(10, 'Uniciti Alam Residential College, UniMAP', 'Jalan Wang Ulu Arau, Sg. Chuchuh, 01000 Kangar, Perlis.', '07-3565088', 'M');

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
(4, 56, 44, 1, 1, 0, NULL),
(5, 58.9, 19, 1, 1, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mobilecentre`
--

CREATE TABLE `mobilecentre` (
  `CentreID` int(5) NOT NULL,
  `OrganizerName` varchar(50) NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mobilecentre`
--

INSERT INTO `mobilecentre` (`CentreID`, `OrganizerName`, `StartDate`, `EndDate`) VALUES
(4, 'UCSI', '2022-06-19', '2022-06-26'),
(6, 'AEON Mall Kuching Central', '2022-06-19', '2022-06-26'),
(7, 'Great Eastern', '2022-06-26', '2022-07-03'),
(9, 'Great Eastern', '2022-07-03', '2022-07-10'),
(10, 'UniMAP', '2022-07-10', '2022-07-17');

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
(1, 1),
(6, 6),
(7, 7),
(8, 8);

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
(4, 'Muhammad', 'Syahin', 'syahin@gmail.com', '$2y$10$ghe1OOtkW3p1tYnB9XTEhOCmn3GyIT0bAGxPElOgtYEcuhABlwcJi', 'donor'),
(5, 'Muthu a/l', 'Suppiah', 'muthu@gmail.com', '$2y$10$JuHjU7uVYBXSi90FIiWaF.0W03UDxfJjOHfBywK3i043MbUIO9RPa', 'donor'),
(6, 'Jovian ', 'Jayome', '70019@siswa.unimas.my', '$2y$10$iXH9geuz.JaJ8eYAsrzUs.dTkA3PuyUl/aMN2gy7H5EBZRHnDo2Dy', 'staff'),
(7, 'Nurrul', 'Nazwa', '76391@siswa.unimas.my', '$2y$10$HH5Ch9lBpSIecI/YKZcrzeozCckNW00MfI66PUPTGLzku.UIBznZm', 'staff'),
(8, 'Jaymax', 'Bravyain', '75132@siswa.unimas.my', '$2y$10$3cJ0xzNAsRYvnjGruvmUfecj20GDshtjL9XKbWEDJNkf3oSptPlp6', 'staff');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`AppointmentID`,`DonorID`),
  ADD KEY `donor-appointment` (`DonorID`),
  ADD KEY `centre-appoitnemnt` (`CentreID`);

--
-- Indexes for table `blood`
--
ALTER TABLE `blood`
  ADD PRIMARY KEY (`BloodID`,`DonorID`),
  ADD UNIQUE KEY `DonorID` (`DonorID`);

--
-- Indexes for table `bloodbankcentre`
--
ALTER TABLE `bloodbankcentre`
  ADD PRIMARY KEY (`CentreID`);

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
-- Indexes for table `mobilecentre`
--
ALTER TABLE `mobilecentre`
  ADD PRIMARY KEY (`CentreID`);

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
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `AppointmentID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `blood`
--
ALTER TABLE `blood`
  MODIFY `BloodID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `centre-appoitnemnt` FOREIGN KEY (`CentreID`) REFERENCES `donationcentre` (`CentreID`),
  ADD CONSTRAINT `donor-appointment` FOREIGN KEY (`DonorID`) REFERENCES `donor` (`UserID`);

--
-- Constraints for table `blood`
--
ALTER TABLE `blood`
  ADD CONSTRAINT `userID` FOREIGN KEY (`DonorID`) REFERENCES `donor` (`UserID`);

--
-- Constraints for table `bloodbankcentre`
--
ALTER TABLE `bloodbankcentre`
  ADD CONSTRAINT `bloodbank-centre` FOREIGN KEY (`CentreID`) REFERENCES `donationcentre` (`CentreID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `donor`
--
ALTER TABLE `donor`
  ADD CONSTRAINT `donor-user` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mobilecentre`
--
ALTER TABLE `mobilecentre`
  ADD CONSTRAINT `mobile-centre` FOREIGN KEY (`CentreID`) REFERENCES `donationcentre` (`CentreID`) ON DELETE CASCADE ON UPDATE CASCADE;

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
