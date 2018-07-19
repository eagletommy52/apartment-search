-- phpMyAdmin SQL Dump
-- version 4.4.15.7
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2018 at 02:35 PM
-- Server version: 5.6.37
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `LoftyHts`
--

-- --------------------------------------------------------

--
-- Table structure for table `apartments`
--

CREATE TABLE IF NOT EXISTS `apartments` (
  `IDapt` int(6) NOT NULL,
  `apt` varchar(5) NOT NULL,
  `floor` int(2) NOT NULL,
  `bdrms` int(2) NOT NULL,
  `isPets` int(4) NOT NULL,
  `baths` float NOT NULL,
  `rent` int(6) NOT NULL,
  `sqft` int(5) NOT NULL,
  `isAvail` tinyint(1) NOT NULL,
  `bldgID` int(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `apartments`
--

INSERT INTO `apartments` (`IDapt`, `apt`, `floor`, `bdrms`, `isPets`, `baths`, `rent`, `sqft`, `isAvail`, `bldgID`) VALUES
(1, '3C', 3, 2, 0, 1, 1900, 900, 1, 4),
(2, '5D', 5, 2, 0, 1.5, 2100, 1100, 1, 2),
(3, '7A', 7, 1, 0, 1, 1700, 560, 0, 4),
(4, '2B', 2, 0, 0, 1, 1500, 585, 1, 1),
(5, '4E', 4, 1, 0, 1, 2100, 875, 0, 3),
(6, '8K', 8, 3, 0, 2, 3600, 1000, 0, 2),
(7, '3F', 3, 0, 0, 1, 1300, 475, 1, 4),
(8, '3A', 3, 3, 0, 1.5, 2900, 1285, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `buildings`
--

CREATE TABLE IF NOT EXISTS `buildings` (
  `IDbldg` int(3) NOT NULL,
  `bldgName` varchar(50) NOT NULL,
  `floors` int(2) NOT NULL,
  `isPets` tinyint(1) NOT NULL,
  `isGym` tinyint(1) NOT NULL,
  `isDoorman` tinyint(1) NOT NULL,
  `isParking` int(1) NOT NULL,
  `bldgDesc` varchar(2500) NOT NULL,
  `hoodID` int(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `buildings`
--

INSERT INTO `buildings` (`IDbldg`, `bldgName`, `floors`, `isPets`, `isGym`, `isDoorman`, `isParking`, `bldgDesc`, `hoodID`) VALUES
(1, 'Glenview Manor', 24, 0, 0, 1, 1, 'Glenview is great', 3),
(2, 'Evergreen Estates', 11, 1, 1, 1, 0, 'Evergreen has everything', 2),
(3, 'Soho Lofts', 13, 0, 1, 1, 1, 'Soho is so cool', 3),
(4, 'Breezy Corners', 6, 1, 0, 0, 0, 'Breezy is breathtaking', 1),
(5, 'Handl View', 5, 0, 0, 1, 1, 'This is a building in a place.', 3);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `IDmbr` int(5) NOT NULL,
  `firstName` varchar(25) NOT NULL,
  `lastName` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `user` varchar(15) NOT NULL,
  `pswd` varchar(15) NOT NULL,
  `joinTime` timestamp NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`IDmbr`, `firstName`, `lastName`, `email`, `user`, `pswd`, `joinTime`) VALUES
(1, 'Jeff', 'Patton', 'jtpatton92@gmail.com', 'jtpat', 'hlkjd', '2018-03-27 18:21:54');

-- --------------------------------------------------------

--
-- Table structure for table `neighborhoods`
--

CREATE TABLE IF NOT EXISTS `neighborhoods` (
  `IDhood` int(2) NOT NULL,
  `hoodName` varchar(100) NOT NULL,
  `hoodDesc` varchar(250) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `neighborhoods`
--

INSERT INTO `neighborhoods` (`IDhood`, `hoodName`, `hoodDesc`) VALUES
(1, 'Chelsea', 'Chelsea is located between Greenwich Village and Midtown.'),
(2, 'Chinatown', 'New York City has one of the world''s largest Chinatowns.'),
(3, 'Soho', 'Soho means South of Houston. It is known as an artsy area.'),
(4, 'Tribeca', 'Tribeca means Triangle between Broadway and Canal.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apartments`
--
ALTER TABLE `apartments`
  ADD PRIMARY KEY (`IDapt`);

--
-- Indexes for table `buildings`
--
ALTER TABLE `buildings`
  ADD PRIMARY KEY (`IDbldg`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`IDmbr`);

--
-- Indexes for table `neighborhoods`
--
ALTER TABLE `neighborhoods`
  ADD PRIMARY KEY (`IDhood`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `apartments`
--
ALTER TABLE `apartments`
  MODIFY `IDapt` int(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `buildings`
--
ALTER TABLE `buildings`
  MODIFY `IDbldg` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `IDmbr` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `neighborhoods`
--
ALTER TABLE `neighborhoods`
  MODIFY `IDhood` int(2) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
