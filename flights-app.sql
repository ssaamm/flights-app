-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 29, 2015 at 09:12 PM
-- Server version: 5.5.41-0+wheezy1
-- PHP Version: 5.4.39-0+deb7u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `flights-app`
--

-- --------------------------------------------------------

--
-- Table structure for table `airport`
--

CREATE TABLE IF NOT EXISTS `airport` (
  `airport_code` char(3) NOT NULL,
  `city_name` varchar(255) NOT NULL,
  `state_name` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE IF NOT EXISTS `city` (
  `city_name` varchar(255) NOT NULL,
  `state_name` char(2) NOT NULL,
  `population` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `flight`
--

CREATE TABLE IF NOT EXISTS `flight` (
  `airline` char(2) NOT NULL,
  `flight_number` int(11) NOT NULL,
  `source_airport` char(3) NOT NULL,
  `destination_airport` char(3) NOT NULL,
  `departure_time` time NOT NULL,
  `arrival_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE IF NOT EXISTS `state` (
  `state_code` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`state_code`) VALUES
('AK'),
('AL'),
('AR'),
('AZ'),
('CA'),
('CO'),
('CT'),
('DE'),
('FL'),
('GA'),
('HI'),
('IA'),
('ID'),
('IL'),
('IN'),
('KS'),
('KY'),
('LA'),
('MA'),
('MD'),
('ME'),
('MI'),
('MN'),
('MO'),
('MS'),
('MT'),
('NC'),
('ND'),
('NE'),
('NH'),
('NJ'),
('NM'),
('NV'),
('NY'),
('OH'),
('OK'),
('OR'),
('PA'),
('RI'),
('SC'),
('SD'),
('TN'),
('TX'),
('UT'),
('VA'),
('VT'),
('WA'),
('WI'),
('WV'),
('WY');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `airport`
--
ALTER TABLE `airport`
 ADD PRIMARY KEY (`airport_code`), ADD KEY `city_name` (`city_name`,`state_name`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
 ADD PRIMARY KEY (`city_name`,`state_name`), ADD KEY `state_name` (`state_name`);

--
-- Indexes for table `flight`
--
ALTER TABLE `flight`
 ADD PRIMARY KEY (`airline`,`flight_number`), ADD KEY `source_airport` (`source_airport`), ADD KEY `destination_airport` (`destination_airport`);

--
-- Indexes for table `state`
--
ALTER TABLE `state`
 ADD PRIMARY KEY (`state_code`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `airport`
--
ALTER TABLE `airport`
ADD CONSTRAINT `airport_ibfk_1` FOREIGN KEY (`city_name`, `state_name`) REFERENCES `city` (`city_name`, `state_name`);

--
-- Constraints for table `city`
--
ALTER TABLE `city`
ADD CONSTRAINT `city_ibfk_1` FOREIGN KEY (`state_name`) REFERENCES `state` (`state_code`);

--
-- Constraints for table `flight`
--
ALTER TABLE `flight`
ADD CONSTRAINT `flight_ibfk_1` FOREIGN KEY (`source_airport`) REFERENCES `airport` (`airport_code`),
ADD CONSTRAINT `flight_ibfk_2` FOREIGN KEY (`destination_airport`) REFERENCES `airport` (`airport_code`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
