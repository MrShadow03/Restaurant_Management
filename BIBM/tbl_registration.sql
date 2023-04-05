-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 04, 2023 at 05:06 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_evaluation`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_registration`
--

CREATE TABLE IF NOT EXISTS `tbl_registration` (
  `reg_id` tinyint(11) NOT NULL AUTO_INCREMENT,
  `co_wo_id` int(11) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `organization` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `address` varchar(250) NOT NULL,
  PRIMARY KEY (`reg_id`),
  KEY `reg_id` (`reg_id`),
  KEY `reg_id_2` (`reg_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `tbl_registration`
--

INSERT INTO `tbl_registration` (`reg_id`, `co_wo_id`, `phone`, `name`, `organization`, `email`, `designation`, `address`) VALUES
(1, 546, '01714730070', 'Md. Nasir Uddin', 'BIBM', 'nasir@gmail.com', 'CSSA', 'Mirpur-2, Dhaka.'),
(2, 547, '01714730071', 'Md. Alim', 'BIBM', 'alim@bibm.org.bd', 'CO', 'Mirpur-2, Dhaka.'),
(3, 547, '01714770070', 'Hamid', 'BIBM', 'hamid@gmail.com', 'Operator', 'Hamid Bank'),
(4, 547, '01714730077', 'Saad', 'Home', 'saad@gmail.com', 'CEO', 'Aamra'),
(5, 537, '01723730070', 'Kabir', 'Sonali', 'kabir@sonali.com', 'AVP', 'Khilkhet, Dhaka'),
(6, 537, '01714733344', 'Motin', 'Sonali', 'motin@sonali.com', 'VP', 'Gazipur Sadar, Gazipur'),
(7, 537, '01914744450', 'Shamim', 'Janata', 'shamim@janata.com', 'SAVP', 'Savar, Dhaka'),
(8, 537, '01777876788', 'Humayun', 'Sonali', 'mayun@sonali.com', 'Manager', 'Uttara, Dhaka'),
(9, 537, '01714730056', 'Rahman', 'Janata', 'rahman@janata.com', 'Manager', 'Gazipur Sadar, Gazipur'),
(10, 537, '01713450070', 'Tarannum', 'Agrani', 'num@agrani.com', 'Executive', 'Mirpur-2, Dhaka.');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
