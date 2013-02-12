-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 21, 2013 at 05:59 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `zf2_tutorial`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_IN`(IN var1 INT)
BEGIN
    SELECT var1 + 2 AS result;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `userlogin`(IN email1 VARCHAR(255))
BEGIN
   SELECT * from user where email=email1;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE IF NOT EXISTS `album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `artist` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `album`
--

INSERT INTO `album` (`id`, `artist`, `title`, `user_id`) VALUES
(1, 'The  Military  Wives', 'In  My  Dreams', 0),
(2, 'Adele', '21', 0),
(3, 'Bruce  Springsteen', 'Wrecking Ball (Deluxe)', 0),
(4, 'Lana  Del  Rey', 'Born  To  Die', 0),
(9, '', 'sfd', 0),
(6, 'Gaurang Rajvir', 'Gjr Albumq', 0),
(10, 'File upload', 'File upload demo', 0),
(11, 'File upload', 'File upload demo', 0),
(12, 'File upload', 'File upload demo', 0),
(13, 'File upload', 'File upload demo', 0),
(14, 'File upload', 'File upload demo', 0),
(15, 'File upload', 'File upload demo', 0),
(16, 'File upload1', 'File upload demo1', 0),
(17, 'resize demo', 'resize demo', 0),
(18, 'resize demo 13', 'resize demo 12', 0),
(19, 'File upload', 'test', 0),
(20, 'File upload', 'test', 0),
(21, 'File upload', 'test', 0),
(22, 'File upload', 'test', 1),
(23, 'from id gaurang.rajvir1', 'from id gaurang.rajvir1', 2),
(24, 'title12', 'title12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sampletable`
--

CREATE TABLE IF NOT EXISTS `sampletable` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `gender` smallint(6) DEFAULT '2',
  `email` varchar(255) DEFAULT NULL,
  `birth` date DEFAULT NULL,
  `address` text,
  `direction` smallint(6) DEFAULT '1',
  `hobby` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `sampletable`
--

INSERT INTO `sampletable` (`id`, `name`, `gender`, `email`, `birth`, `address`, `direction`, `hobby`) VALUES
(1, 'Gaurang', 3, 'gjr@gjr.com', '2012-12-12', 'Rajkot', 1, '["1","2","3"]'),
(2, 'Rajvir', 3, 'rajvir@rajvir.com', '2012-02-12', 'fdsdfsdfsdfs', 2, '["1"]');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `display_name` varchar(50) DEFAULT NULL,
  `password` varchar(128) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `email`, `display_name`, `password`) VALUES
(1, NULL, 'gaurang.rajvir@clariontechnologies.co.in', NULL, '$2a$14$IJ3CSWGpltVyRk72rNtH7O38Gh1McbZUM2.lo5QM3HiBf7A4qE3be'),
(4, NULL, 'ankit.shah@clariontechnologies.co.in', NULL, '$2y$14$kdrMn/xSX4ropDlhefQfaOkLGo92eQRN1ov5ccwbmCkzUpJ1JwbA.');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE IF NOT EXISTS `user_role` (
  `role_id` varchar(255) NOT NULL,
  `default` tinyint(1) NOT NULL,
  `parent` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_role_linker`
--

CREATE TABLE IF NOT EXISTS `user_role_linker` (
  `user_id` int(11) unsigned NOT NULL,
  `role_id` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
