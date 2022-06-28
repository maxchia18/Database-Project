-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 28, 2022 at 09:07 AM
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
(1, 5, '2022-06-28', '08:00:00', 'completed', 1),
(2, 9, '2022-06-28', '10:00:00', 'completed', 8),
(3, 6, '2022-06-28', '12:00:00', 'rejected', 8),
(4, 5, '2022-08-28', '10:00:00', 'cancelled', 1),
(5, 7, '2022-07-05', '10:00:00', 'completed', 1);

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
(2, 'A+', 15, 5),
(3, 'B+', 18, 6),
(4, 'A-', 13, 7),
(5, 'O+', NULL, 8),
(6, 'A-', 15, 9);

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
(1, 2, 1, 390, 'w', 1),
(2, 6, 2, 350, 'w', 10),
(3, 4, 5, 450, 'w', 1);

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
(3, 1);

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
(5, 1),
(7, 3),
(9, 2);

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
(5, 56, 22, 1, 0, '2022-06-28'),
(6, 0, 19, 1, 0, '1900-01-01'),
(7, 60, 57, 1, 0, '2022-07-05'),
(8, 60.3, 49, 1, 0, '1900-01-01'),
(9, 45, 31, 1, 0, '2022-06-28');

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
(6, 'AEON Mall Kuching Central', '2022-06-26', '2022-07-03'),
(7, 'Great Eastern', '2022-07-03', '2022-07-10'),
(9, 'Great Eastern', '2022-07-10', '2022-07-17'),
(10, 'UniMAP', '2022-07-17', '2022-07-24');

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
(2, 2),
(10, 8),
(3, 9),
(4, 10);

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
(2, 'Jovian', 'Jayome', 'Male', '70019@siswa.unimas.my', '$2y$10$ZP5oZIQpxxUjnvOLepBhvegnphuCvQgV2dpxRRynGYkVD/Ytfv5WS', 'staff'),
(3, 'Nurrul ', 'Nazwa', 'Female', '76391@siswa.unimas.my', '$2y$10$/1TeIOlH.QUjL8jxGASWVOZBCbrW7EgzlyrQhgQ5o0D97SeJaocQ2', 'staff'),
(4, 'Jaymax', 'Bravyain', 'Male', '75132@siswa.unimas.my', '$2y$10$bpfd.fpnrLZ/IwkyOT8V2u.I1JDIJcy/vFsK10.GbsHy612OwPi5S', 'staff'),
(5, 'Ming', 'Lee', 'Male', 'lee@gmail.com', '$2y$10$BHExZATonkW0rh6A8tEwF.U0zqNuJVKScFzZxnfdaOGzWITo34wZC', 'donor'),
(6, 'Muthu a/l', 'Supp', 'Male', 'muthu@gmail.com', '$2y$10$inxydUfWnKcGsanGvD.ZReUcuhEBvfSA0wEB6s/qSavM0ighIb8aa', 'donor'),
(7, 'Siti binti', 'Abdullah', 'Female', 'siti@gmail.com', '$2y$10$dTq7FNaH10rG25LSMxk.ZuBMt7Jmpb9gcm34E6LPi8VU5qcKgEd4S', 'donor'),
(8, 'Xin', 'Lee', 'Male', 'xinlee@gmail.com', '$2y$10$SUZFutmMEgnVqPaIzxVuZetqP1soW3R4PiH1jdX9/V.D1lTKhcFr6', 'donor'),
(9, 'Janice', 'Po', 'Male', 'janice@gmail.com', '$2y$10$erom7BHWHd9iJf59CcHv4.vm.To.05bwvoICMjk6weBQkdI.1jiPG', 'donor'),
(10, 'Sherry', 'Lam', 'Female', '75355@siswa.unimas.my', '$2y$10$MmcGOhwlRFzLeqIq5HzmzuC2HWcnA3iXYlD7qZGpUVrOTpu8DQd.S', 'staff');

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
  MODIFY `AppointmentID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `blood`
--
ALTER TABLE `blood`
  MODIFY `BloodID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `blooddonation`
--
ALTER TABLE `blooddonation`
  MODIFY `DonationID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
  ADD CONSTRAINT `staff-donation` FOREIGN KEY (`StaffID`) REFERENCES `staff` (`UserID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
