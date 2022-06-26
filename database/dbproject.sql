-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 26, 2022 at 09:49 AM
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
  `AppointmentStatus` char(10) NOT NULL DEFAULT 'ongoing',
  `CentreID` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`AppointmentID`, `DonorID`, `AppointedDate`, `AppointedSession`, `AppointmentStatus`, `CentreID`) VALUES
(1, 4, '2022-07-08', '11:00:00', 'completed', 1),
(2, 2, '2022-07-09', '15:00:00', 'completed', 8),
(3, 3, '2022-06-30', '09:00:00', 'completed', 7),
(4, 5, '2022-06-28', '10:00:00', 'completed', 1),
(5, 10, '2022-07-08', '09:00:00', 'completed', 1),
(6, 9, '2022-07-08', '11:00:00', 'completed', 1),
(7, 11, '2022-07-14', '12:00:00', 'rejected', 8),
(8, 5, '2022-08-28', '10:00:00', 'completed', 1),
(9, 5, '2022-08-28', '09:00:00', 'completed', 1),
(10, 10, '2022-09-08', '09:00:00', 'completed', 8),
(11, 9, '2022-09-08', '11:00:00', 'ongoing', 8),
(12, 3, '2022-08-30', '09:00:00', 'ongoing', 8);

-- --------------------------------------------------------

--
-- Table structure for table `blood`
--

CREATE TABLE `blood` (
  `BloodID` int(5) NOT NULL,
  `BloodGroup` char(3) NOT NULL,
  `HaemoglobinLevel` double DEFAULT NULL,
  `DonorID` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `blood`
--

INSERT INTO `blood` (`BloodID`, `BloodGroup`, `HaemoglobinLevel`, `DonorID`) VALUES
(1, 'A+', 12.7, 2),
(2, 'A-', 15, 3),
(3, 'B-', 14, 4),
(4, 'A+', 15, 5),
(5, 'A+', 13, 9),
(6, 'A-', 13, 10),
(7, 'A+', 13, 11),
(8, 'B-', NULL, 12);

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
-- Table structure for table `blooddonation`
--

CREATE TABLE `blooddonation` (
  `DonationID` int(5) NOT NULL,
  `BloodID` int(5) NOT NULL,
  `AppointmentID` int(5) NOT NULL,
  `DonationAmount` int(3) NOT NULL,
  `DonationType` char(1) NOT NULL,
  `StaffID` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `blooddonation`
--

INSERT INTO `blooddonation` (`DonationID`, `BloodID`, `AppointmentID`, `DonationAmount`, `DonationType`, `StaffID`) VALUES
(1, 4, 4, 450, 'w', 1),
(2, 1, 2, 450, 'w', 8),
(3, 2, 3, 450, 'w', 7),
(4, 3, 1, 450, 'w', 1),
(5, 5, 6, 350, 'w', 1),
(6, 6, 5, 450, 'w', 1),
(7, 4, 8, 450, 'w', 1),
(8, 4, 9, 450, 'a', 1),
(9, 6, 10, 360, 'w', 8);

-- --------------------------------------------------------

--
-- Table structure for table `bloodstock`
--

CREATE TABLE `bloodstock` (
  `DonationID` int(5) NOT NULL,
  `CentreID` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bloodstock`
--

INSERT INTO `bloodstock` (`DonationID`, `CentreID`) VALUES
(1, 1),
(2, 8),
(3, 7),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 8);

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
-- Table structure for table `donationhistory`
--

CREATE TABLE `donationhistory` (
  `DonorID` int(5) NOT NULL,
  `DonationID` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `donationhistory`
--

INSERT INTO `donationhistory` (`DonorID`, `DonationID`) VALUES
(2, 2),
(3, 3),
(4, 4),
(5, 1),
(5, 7),
(5, 8),
(9, 5),
(10, 6),
(10, 9);

-- --------------------------------------------------------

--
-- Table structure for table `donor`
--

CREATE TABLE `donor` (
  `UserID` int(10) NOT NULL,
  `Weight` double NOT NULL,
  `Age` int(2) NOT NULL,
  `IsWhole` tinyint(1) NOT NULL DEFAULT 1,
  `IsAphresis` tinyint(1) NOT NULL DEFAULT 0,
  `LastDonationDate` date DEFAULT '1900-01-01'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `donor`
--

INSERT INTO `donor` (`UserID`, `Weight`, `Age`, `IsWhole`, `IsAphresis`, `LastDonationDate`) VALUES
(2, 55, 21, 1, 0, '2022-07-09'),
(3, 66, 22, 1, 0, '2022-06-30'),
(4, 58, 44, 1, 0, '2022-07-08'),
(5, 56, 19, 1, 1, '1900-01-01'),
(9, 47, 57, 1, 0, '2022-07-08'),
(10, 56, 31, 1, 1, '2022-09-08'),
(11, 56, 49, 1, 0, '1900-01-01'),
(12, 45, 22, 1, 0, '1900-01-01');

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
  `Gender` char(6) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `UserType` char(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `FirstName`, `LastName`, `Gender`, `Email`, `Password`, `UserType`) VALUES
(1, 'Max', 'Chia', 'Male', '75590@siswa.unimas.my', '$2y$10$by9PuERUFxh5q69MeD0/LOXfGFidmXNQbx8VYszV/XBG6MXXiEpXm', 'staff'),
(2, 'Kha Hau', 'Chong', 'Male', 'khahau@gmail.com', '$2y$10$OKWbC7R8PdKhuQ/k4LmKqufajZ70Hg.XCQJ1Iy7T4RzD9HeVqny36', 'donor'),
(3, 'Brady', 'Chung', 'Male', 'brady@gmail.com', '$2y$10$FbkwmwRndhNJNl7o08s1R.2csMBng7KxONdT5LEFtEgqoukIkFW3q', 'donor'),
(4, 'Muhammad', 'Syahin', 'Male', 'syahin@gmail.com', '$2y$10$ghe1OOtkW3p1tYnB9XTEhOCmn3GyIT0bAGxPElOgtYEcuhABlwcJi', 'donor'),
(5, 'Muthu a/l', 'Suppiah', 'Male', 'muthu@gmail.com', '$2y$10$JuHjU7uVYBXSi90FIiWaF.0W03UDxfJjOHfBywK3i043MbUIO9RPa', 'donor'),
(6, 'Jovian ', 'Jayome', 'Male', '70019@siswa.unimas.my', '$2y$10$iXH9geuz.JaJ8eYAsrzUs.dTkA3PuyUl/aMN2gy7H5EBZRHnDo2Dy', 'staff'),
(7, 'Nurrul', 'Nazwa', 'Female', '76391@siswa.unimas.my', '$2y$10$HH5Ch9lBpSIecI/YKZcrzeozCckNW00MfI66PUPTGLzku.UIBznZm', 'staff'),
(8, 'Jaymax', 'Bravyain', 'Male', '75132@siswa.unimas.my', '$2y$10$3cJ0xzNAsRYvnjGruvmUfecj20GDshtjL9XKbWEDJNkf3oSptPlp6', 'staff'),
(9, 'Siti binti', 'Abdullah', 'Female', 'siti@gmail.com', '$2y$10$4Y4XueJfpmqDtzOJUAJxN.yiPwYZFGWrWZlcAcOP1iwbmHAwP1.eO', 'donor'),
(10, 'Janice', 'Po', 'Female', 'janice@gmail.com', '$2y$10$qR1oGaoegjjz.iTDMM0CCeywz6r9cSv9wvFypr1LFXIAe0jAe0cnm', 'donor'),
(11, 'Lee ', 'Xin', 'Male', 'lee@gmail.com', '$2y$10$BzoThc6mpaPHYdBdJrrUH.FvnSmDKY.GUDWxYIHRDETIbu46oCxji', 'donor'),
(12, 'Sherry', 'Lam', 'Female', 'sherry@gmail.com', '$2y$10$aIyswZd8Wu0fDabW1T5AO.V9ipg/ll/NzVPgzAX0Pl.z0cIbWe4rm', 'donor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`AppointmentID`,`DonorID`),
  ADD KEY `centre-appoitnemnt` (`CentreID`),
  ADD KEY `donor-appointment` (`DonorID`);

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
-- Indexes for table `blooddonation`
--
ALTER TABLE `blooddonation`
  ADD PRIMARY KEY (`DonationID`,`BloodID`),
  ADD KEY `appointment-donation` (`AppointmentID`),
  ADD KEY `blood-donation` (`BloodID`),
  ADD KEY `staff-donation` (`StaffID`);

--
-- Indexes for table `bloodstock`
--
ALTER TABLE `bloodstock`
  ADD PRIMARY KEY (`DonationID`,`CentreID`),
  ADD KEY `centre-stock` (`CentreID`);

--
-- Indexes for table `donationcentre`
--
ALTER TABLE `donationcentre`
  ADD PRIMARY KEY (`CentreID`);

--
-- Indexes for table `donationhistory`
--
ALTER TABLE `donationhistory`
  ADD PRIMARY KEY (`DonorID`,`DonationID`),
  ADD KEY `donation-history` (`DonationID`);

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
  MODIFY `AppointmentID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `blood`
--
ALTER TABLE `blood`
  MODIFY `BloodID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `blooddonation`
--
ALTER TABLE `blooddonation`
  MODIFY `DonationID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `centre-appoitnemnt` FOREIGN KEY (`CentreID`) REFERENCES `donationcentre` (`CentreID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `donor-appointment` FOREIGN KEY (`DonorID`) REFERENCES `donor` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `blood`
--
ALTER TABLE `blood`
  ADD CONSTRAINT `userID` FOREIGN KEY (`DonorID`) REFERENCES `donor` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bloodbankcentre`
--
ALTER TABLE `bloodbankcentre`
  ADD CONSTRAINT `bloodbank-centre` FOREIGN KEY (`CentreID`) REFERENCES `donationcentre` (`CentreID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `blooddonation`
--
ALTER TABLE `blooddonation`
  ADD CONSTRAINT `appointment-donation` FOREIGN KEY (`AppointmentID`) REFERENCES `appointment` (`AppointmentID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `blood-donation` FOREIGN KEY (`BloodID`) REFERENCES `blood` (`BloodID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `staff-donation` FOREIGN KEY (`StaffID`) REFERENCES `staff` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bloodstock`
--
ALTER TABLE `bloodstock`
  ADD CONSTRAINT `centre-stock` FOREIGN KEY (`CentreID`) REFERENCES `donationcentre` (`CentreID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `donation-stock` FOREIGN KEY (`DonationID`) REFERENCES `blooddonation` (`DonationID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `donationhistory`
--
ALTER TABLE `donationhistory`
  ADD CONSTRAINT `donation-history` FOREIGN KEY (`DonationID`) REFERENCES `blooddonation` (`DonationID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `donor-history` FOREIGN KEY (`DonorID`) REFERENCES `donor` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `employ` FOREIGN KEY (`CentreID`) REFERENCES `donationcentre` (`CentreID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `staff-user` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
