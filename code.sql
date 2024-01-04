-- phpMyAdmin SQL Dump
-- version 5.3.0-dev+20220709.4e08d2933b
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2024 at 05:57 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `code`
--

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `name`) VALUES
('65916ff76ad42', 'Amritsar'),
('659170076048c', 'Jalandhar'),
('65917012bfdfb', 'Ludhiana'),
('6591702263283', 'Pathankot'),
('6591709952cb4', 'Barnala'),
('659170aa56a86', 'Bathinda'),
('659170c19ae28', 'Faridkot'),
('659170da36eda', 'Fatehgarh Sahib'),
('659170febfd37', 'Firozpur'),
('6591710f723e3', 'Fazilka'),
('65917121e4326', 'Gurdaspur'),
('659171317e8cb', 'Hoshiapur'),
('65917144285b8', 'Kapurthala'),
('6591715d70045', 'Malerkotla '),
('6591716a0b936', 'Mansa'),
('65917174ee871', 'Moga'),
('65917188c216d', 'Sri Muktsar Sahib'),
('6591719b58050', 'Patiala'),
('659171adcdfb9', 'Rupnagar'),
('659171bed6792', 'SAS Nagar'),
('659171d335e05', 'SBS Nagar'),
('659171df3fb53', 'Sangrur'),
('659171f04260c', 'Tarn Taran');

-- --------------------------------------------------------

--
-- Table structure for table `fps`
--

CREATE TABLE `fps` (
  `district` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `id` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `demand` varchar(100) NOT NULL,
  `longitude` varchar(100) NOT NULL,
  `latitude` varchar(100) NOT NULL,
  `uniqueid` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fps`
--

INSERT INTO `fps` (`district`, `name`, `id`, `type`, `demand`, `longitude`, `latitude`, `uniqueid`) VALUES
('Amritsar', 'FPS1', '111', 'motorable', '30', '78.5', '34.5', 'FPS_6591728512a'),
('Amritsar', 'FPS2', '121', 'motorable', '30', '78.5', '34.5', 'FPS_6591728f311'),
('Amritsar', 'a', '104900100029.00', 'Motarable', '70', '31.6960642', '74.8213991', 'FPS_65918388ec2'),
('Amritsar', 'a', '104900400001.00', 'Motarable', '70', '31.6743213', '74.8377673', 'FPS_65918388ed7'),
('Amritsar', 'a', '104900600009.00', 'Motarable', '70', '31.6562698', '74.8273698', 'FPS_65918388eee'),
('Amritsar', 'a', '104900600030.00', 'Motarable', '70', '31.6971421', '74.8165842', 'FPS_65918388f29'),
('Amritsar', 'a', '104900600040.00', 'Motarable', '70', '31.7939604', '75.061873', 'FPS_65918388f3c'),
('Barnala', 'a', '104900600042.00', 'Motarable', '70', '30.503885', '75.645671', 'FPS_65918389013'),
('Barnala', 'a', '104900600043.00', 'Motarable', '70', '30.484784', '75.6480254', 'FPS_65918389027'),
('Barnala', 'a', '104900900024.00', 'Motarable', '70', '30.3685732', '75.540993', 'FPS_65918389035'),
('Barnala', 'a', '105400660002.00', 'Motarable', '70', '30.3773217', '75.5591404', 'FPS_65918389052'),
('Barnala', 'a', '105400660003.00', 'Motarable', '70', '30.3776617', '75.5442665', 'FPS_6591838905d'),
('Barnala', 'a', '105400660004.00', 'Motarable', '70', '30.3817134', '75.5495741', 'FPS_65918389067'),
('Barnala', 'a', '105400660005.00', 'Motarable', '70', '30.3841292', '75.5500683', 'FPS_65918389073'),
('Barnala', 'a', '105400660006.00', 'Motarable', '70', '30.3878532', '75.5536538', 'FPS_65918389093'),
('Barnala', 'a', '105400660007.00', 'Motarable', '70', '30.3699419', '75.5390871', 'FPS_6591838909e'),
('Bathinda', 'a', '105400660008.00', 'Motarable', '70', '30.2117102', '74.9467538', 'FPS_659183890a6'),
('Bathinda', 'a', '105400660009.00', 'Motarable', '70', '30.1902925', '74.9306622', 'FPS_659183890b3'),
('Bathinda', 'a', '105400660010.00', 'Motarable', '70', '30.1891729', '74.9423529', 'FPS_659183890c8'),
('Bathinda', 'a', '104600100002.00', 'Motarable', '70', '30.2058975', '74.9343154', 'FPS_659183890d9'),
('Bathinda', 'a', '104600100003.00', 'Motarable', '70', '30.2164317', '74.9481915', 'FPS_659183890e3'),
('Bathinda', 'a', '104600100004.00', 'Motarable', '70', '30.233544', '74.9489464', 'FPS_659183890ef'),
('Bathinda', 'a', '104600100005.00', 'Motarable', '70', '30.198012', '74.935295', 'FPS_65918389106'),
('Bathinda', 'a', '104600100006.00', 'Motarable', '70', '30.2027762', '74.9413445', 'FPS_65918389113'),
('Faridkot', 'a', '104600100007.00', 'Motarable', '70', '30.677', '74.746', 'FPS_6591838911d'),
('Faridkot', 'a', '104600100008.00', 'Motarable', '70', '30.764', '74.515', 'FPS_65918389126'),
('Faridkot', 'a', '104600100009.00', 'Motarable', '70', '30.715', '74.544', 'FPS_65918389134'),
('Faridkot', 'a', '104500100154.00', 'Motarable', '70', '30.744', '74.541', 'FPS_65918389144'),
('Faridkot', 'a', '104500300047.00', 'Motarable', '70', '30.6538', '74.87004', 'FPS_65918389158'),
('Faridkot', 'a', '104500300048.00', 'Motarable', '70', '30.464598', '74.931722', 'FPS_65918389165'),
('Faridkot', 'a', '104500300049.00', 'Motarable', '70', '30.7070631', '74.8006474', 'FPS_65918389171');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `uid` varchar(100) NOT NULL,
  `verified` varchar(10) NOT NULL DEFAULT '0',
  `role` varchar(255) NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`username`, `password`, `uid`, `verified`, `role`) VALUES
('admin@sdg', 'admin', 'aqswdecf45', '1', 'admin'),
('akshay@taxibazaar.in', '11', '658473c823921', '1', 'amritsar'),
('PunjabUser', 'PunjabUser@123', 'ads46d', '1', 'admin'),
('anmol@taxibazaar.in', '123456', '658556a9d53b1', '1', 'Bathinda');

-- --------------------------------------------------------

--
-- Table structure for table `optimiseddata`
--

CREATE TABLE `optimiseddata` (
  `from_district` varchar(150) NOT NULL,
  `from_id` varchar(150) NOT NULL,
  `from_name` varchar(150) NOT NULL,
  `to_district` varchar(150) NOT NULL,
  `to_id` varchar(150) NOT NULL,
  `to_name` varchar(150) NOT NULL,
  `approve` varchar(100) NOT NULL,
  `new_id` varchar(100) NOT NULL,
  `reviewed` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `optimiseddata`
--

INSERT INTO `optimiseddata` (`from_district`, `from_id`, `from_name`, `to_district`, `to_id`, `to_name`, `approve`, `new_id`, `reviewed`) VALUES
('Bathinda', 'WH10', 'WH10', 'Bathinda', '105400660009', 'a', '', '', 'yes'),
('Bathinda', 'WH10', 'WH10', 'Bathinda', '105400660010', 'a', 'yes', 'WH11', 'yes'),
('Bathinda', 'WH11', 'WH11', 'Bathinda', '104600100002', 'a', '', '', ''),
('Bathinda', 'WH13', 'WH13', 'Faridkot', '104500300047', 'a', '', '', ''),
('Bathinda', 'WH13', 'WH13', 'Bathinda', '104600100003', 'a', '', '', ''),
('Bathinda', 'WH13', 'WH13', 'Bathinda', '104600100004', 'a', '', '', ''),
('Bathinda', 'WH13', 'WH13', 'Bathinda', '104600100005', 'a', '', '', ''),
('Bathinda', 'WH13', 'WH13', 'Bathinda', '105400660008', 'a', '', '', ''),
('Bathinda', 'WH14', 'WH14', 'Faridkot', '104600100009', 'a', '', '', ''),
('Bathinda', 'WH15', 'WH15', 'Faridkot', '104600100007', 'a', '', '', ''),
('Amritsar', 'WH1', 'WH1', 'Amritsar', '104900600040', 'a', 'no', 'WH1', 'yes'),
('Amritsar', 'WH3', 'WH3', 'Faridkot', '104500300048', 'a', '', '', ''),
('Amritsar', 'WH3', 'WH3', 'Amritsar', '104900600030', 'a', '', '', ''),
('Amritsar', 'WH4', 'WH4', 'Faridkot', '104500100154', 'a', '', '', ''),
('Amritsar', 'WH4', 'WH4', 'Faridkot', '104600100008', 'a', '', '', ''),
('Amritsar', 'WH4', 'WH4', 'Amritsar', '104900100029', 'a', '', '', ''),
('Amritsar', 'WH4', 'WH4', 'Amritsar', '104900400001', 'a', '', '', ''),
('Amritsar', 'WH4', 'WH4', 'Amritsar', '104900600009', 'a', '', '', ''),
('Amritsar', 'WH4', 'WH4', 'Amritsar', '111', 'FPS1', '', '', ''),
('Amritsar', 'WH4', 'WH4', 'Amritsar', '121', 'FPS2', '', '', ''),
('Barnala', 'WH6', 'WH6', 'Barnala', '104900600042', 'a', '', '', ''),
('Barnala', 'WH6', 'WH6', 'Barnala', '104900900024', 'a', '', '', ''),
('Barnala', 'WH6', 'WH6', 'Barnala', '105400660002', 'a', '', '', ''),
('Barnala', 'WH6', 'WH6', 'Barnala', '105400660004', 'a', '', '', ''),
('Barnala', 'WH7', 'WH7', 'Faridkot', '104500300049', 'a', '', '', ''),
('Barnala', 'WH7', 'WH7', 'Barnala', '104900600043', 'a', '', '', ''),
('Barnala', 'WH7', 'WH7', 'Barnala', '105400660005', 'a', '', '', ''),
('Barnala', 'WH7', 'WH7', 'Barnala', '105400660006', 'a', '', '', ''),
('Barnala', 'WH9', 'WH9', 'Barnala', '105400660003', 'a', '', '', ''),
('Barnala', 'WH9', 'WH9', 'Barnala', '105400660007', 'a', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `timer`
--

CREATE TABLE `timer` (
  `deadline_date` varchar(255) NOT NULL,
  `deadline_time` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `timer`
--

INSERT INTO `timer` (`deadline_date`, `deadline_time`) VALUES
('2024-01-13', '05:00');

-- --------------------------------------------------------

--
-- Table structure for table `warehouse`
--

CREATE TABLE `warehouse` (
  `district` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `id` varchar(100) NOT NULL,
  `warehousetype` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `latitude` varchar(100) NOT NULL,
  `longitude` varchar(100) NOT NULL,
  `storage` varchar(100) NOT NULL,
  `uniqueid` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `warehouse`
--

INSERT INTO `warehouse` (`district`, `name`, `id`, `warehousetype`, `type`, `latitude`, `longitude`, `storage`, `uniqueid`) VALUES
('Amritsar', 'WH1', 'WH1', 'SWC', 'SWC', '34.6', '54.6', '10000', 'WH_659183073589'),
('Amritsar', 'WH2', 'WH2', 'SWC', 'SWC', '34.6', '54.6', '10000', 'WH_6591830736ab'),
('Amritsar', 'WH3', 'WH3', 'SWC', 'SWC', '34.6', '54.6', '10000', 'WH_6591830739c0'),
('Amritsar', 'WH4', 'WH4', 'SWC', 'SWC', '34.6', '54.6', '10000', 'WH_659183073b11'),
('Amritsar', 'WH5', 'WH5', 'SWC', 'SWC', '34.6', '54.6', '10000', 'WH_659183073beb'),
('Barnala', 'WH6', 'WH6', 'SWC', 'SWC', '34.6', '54.6', '10000', 'WH_659183073d8d'),
('Barnala', 'WH7', 'WH7', 'SWC', 'SWC', '34.6', '54.6', '10000', 'WH_659183073f27'),
('Barnala', 'WH8', 'WH8', 'SWC', 'SWC', '34.6', '54.6', '10000', 'WH_65918307407e'),
('Barnala', 'WH9', 'WH9', 'SWC', 'SWC', '34.6', '54.6', '10000', 'WH_659183074281'),
('Bathinda', 'WH10', 'WH10', 'SWC', 'SWC', '34.6', '54.6', '10000', 'WH_6591830743e7'),
('Bathinda', 'WH11', 'WH11', 'SWC', 'SWC', '34.6', '54.6', '10000', 'WH_659183074522'),
('Bathinda', 'WH12', 'WH12', 'SWC', 'SWC', '34.6', '54.6', '10000', 'WH_65918307463d'),
('Bathinda', 'WH13', 'WH13', 'SWC', 'SWC', '34.6', '54.6', '10000', 'WH_65918307474f'),
('Bathinda', 'WH14', 'WH14', 'SWC', 'SWC', '34.6', '54.6', '10000', 'WH_6591830748ad'),
('Bathinda', 'WH15', 'WH15', 'SWC', 'SWC', '34.6', '54.6', '10000', 'WH_659183074a94');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



