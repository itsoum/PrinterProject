-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Φιλοξενητής: localhost
-- Χρόνος δημιουργίας: 27 Ιουλ 2015 στις 17:57:24
-- Έκδοση διακομιστή: 5.6.25
-- Έκδοση PHP: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `Fw.To` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `Fw.To`;

--
-- Βάση δεδομένων: `Fw.To`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `AutoDebit`
--

CREATE TABLE IF NOT EXISTS `AutoDebit` (
  `IdUser` int(5) NOT NULL,
  `timestamp` DATETIME DEFAULT NULL,
  `PrintedPages` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `ManualDebit`
--

CREATE TABLE IF NOT EXISTS `ManualDebit` (
  `IdUser` int(5) NOT NULL,
  `timestamp` DATETIME DEFAULT NULL,
  `PrintedPages` int(5) NOT NULL,
  `ColorPages` int(5) NOT NULL,
  `Size` varchar(2) NOT NULL,
  `DescriptionOfJobs` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
  `Id` int(5) NOT NULL,
  `Password` int(5) NOT NULL,
  `Owner` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `Users`
--
/*ALTER TABLE `Users`
  ADD PRIMARY KEY (`Id`);*/

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



/* Everything below that line was added by Chrs */


CREATE TABLE `Jobs` (
  `job_id` int(11) NOT NULL AUTO_INCREMENT,
  `dep_id` varchar(255) DEFAULT NULL,
  `no_copies` bigint(20) DEFAULT NULL,
  `doc_name` varchar(255) DEFAULT NULL,
  `doc_type` varchar(255) DEFAULT NULL,
  `job_status` varchar(255) DEFAULT NULL,
  `timestamp` DATETIME DEFAULT NULL,
  PRIMARY KEY (`job_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
