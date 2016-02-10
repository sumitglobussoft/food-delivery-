-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 10, 2016 at 08:43 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ziingo_new_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `addtocart`
--

CREATE TABLE IF NOT EXISTS `addtocart` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `product_id` int(20) NOT NULL,
  `user_id` int(20) NOT NULL,
  `quantity` int(40) NOT NULL,
  `hotel_id` int(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=243 ;

--
-- Dumping data for table `addtocart`
--

INSERT INTO `addtocart` (`id`, `product_id`, `user_id`, `quantity`, `hotel_id`) VALUES
(5, 5, 4, 2, 6),
(6, 6, 5, 1, 3),
(7, 3, 1, 5, 4),
(12, 3, 1, 6, 4),
(13, 3, 1, 6, 4),
(16, 15, 6, 1, 5),
(17, 15, 6, 1, 5),
(18, 15, 6, 1, 5),
(19, 5, 6, 2, 7),
(55, 10, 15, 1, 1),
(72, 1, 12, 1, 1),
(73, 7, 12, 1, 4),
(91, 9, 15, 1, 4),
(95, 16, 15, 1, 2),
(98, 37, 24, 12, 22),
(99, 17, 15, 1, 1),
(100, 1, 15, 1, 1),
(101, 4, 15, 1, 2),
(121, 5, 24, 1, 2),
(135, 6, 24, 1, 2),
(136, 37, 40, 1, 22),
(137, 38, 40, 1, 22),
(138, 4, 24, 1, 2),
(139, 5, 24, 1, 2),
(140, 6, 24, 1, 2),
(141, 4, 24, 1, 2),
(142, 5, 24, 1, 2),
(143, 6, 24, 1, 2),
(144, 4, 24, 1, 2),
(145, 5, 24, 1, 2),
(146, 6, 24, 1, 2),
(147, 4, 24, 1, 2),
(148, 5, 24, 1, 2),
(149, 6, 24, 1, 2),
(150, 4, 24, 1, 2),
(151, 5, 24, 1, 2),
(152, 6, 24, 1, 2),
(153, 4, 24, 1, 2),
(154, 5, 24, 1, 2),
(155, 6, 24, 1, 2),
(156, 4, 24, 1, 2),
(157, 5, 24, 1, 2),
(158, 6, 24, 1, 2),
(159, 4, 24, 1, 2),
(160, 5, 24, 1, 2),
(161, 6, 24, 1, 2),
(162, 4, 24, 1, 2),
(163, 5, 24, 1, 2),
(164, 6, 24, 1, 2),
(165, 4, 24, 1, 2),
(166, 5, 24, 1, 2),
(167, 6, 24, 1, 2),
(168, 4, 24, 1, 2),
(169, 5, 24, 1, 2),
(170, 6, 24, 1, 2),
(171, 4, 24, 1, 2),
(172, 5, 24, 1, 2),
(173, 6, 24, 1, 2),
(174, 4, 24, 1, 2),
(175, 5, 24, 1, 2),
(176, 6, 24, 1, 2),
(177, 4, 24, 1, 2),
(178, 5, 24, 1, 2),
(179, 6, 24, 1, 2),
(180, 4, 24, 1, 2),
(181, 5, 24, 1, 2),
(182, 6, 24, 1, 2),
(183, 4, 24, 1, 2),
(184, 5, 24, 1, 2),
(185, 6, 24, 1, 2),
(186, 4, 24, 1, 2),
(187, 5, 24, 1, 2),
(188, 6, 24, 1, 2),
(189, 4, 24, 1, 2),
(190, 5, 24, 1, 2),
(191, 6, 24, 1, 2),
(192, 4, 24, 1, 2),
(193, 5, 24, 1, 2),
(194, 6, 24, 1, 2),
(195, 4, 24, 1, 2),
(196, 5, 24, 1, 2),
(197, 6, 24, 1, 2),
(198, 4, 24, 1, 2),
(199, 5, 24, 1, 2),
(200, 6, 24, 1, 2),
(201, 4, 24, 1, 2),
(202, 5, 24, 1, 2),
(203, 6, 24, 1, 2),
(204, 4, 24, 1, 2),
(205, 5, 24, 1, 2),
(206, 6, 24, 1, 2),
(207, 4, 24, 1, 2),
(208, 5, 24, 1, 2),
(209, 6, 24, 1, 2),
(210, 4, 24, 1, 2),
(211, 5, 24, 1, 2),
(212, 6, 24, 1, 2),
(213, 4, 24, 1, 2),
(214, 5, 24, 1, 2),
(215, 6, 24, 1, 2),
(216, 4, 24, 1, 2),
(217, 5, 24, 1, 2),
(218, 6, 24, 1, 2),
(219, 4, 24, 1, 2),
(220, 5, 24, 1, 2),
(221, 6, 24, 1, 2),
(222, 4, 24, 1, 2),
(223, 5, 24, 1, 2),
(224, 6, 24, 1, 2),
(225, 4, 24, 1, 2),
(226, 5, 24, 1, 2),
(227, 6, 24, 1, 2),
(228, 4, 24, 1, 2),
(229, 5, 24, 1, 2),
(230, 6, 24, 1, 2),
(231, 4, 24, 1, 2),
(232, 5, 24, 1, 2),
(233, 6, 24, 1, 2),
(234, 4, 24, 1, 2),
(235, 5, 24, 1, 2),
(236, 6, 24, 1, 2),
(237, 4, 24, 1, 2),
(238, 5, 24, 1, 2),
(239, 6, 24, 1, 2),
(240, 4, 24, 1, 2),
(241, 5, 24, 1, 2),
(242, 6, 24, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE IF NOT EXISTS `agents` (
  `agent_id` int(22) NOT NULL AUTO_INCREMENT,
  `loginname` varchar(30) NOT NULL,
  `first_name` varchar(11) NOT NULL,
  `last_name` text NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(60) NOT NULL,
  `city` varchar(60) NOT NULL,
  `address` text NOT NULL,
  `reg_date` datetime NOT NULL,
  `role` int(4) DEFAULT '0' COMMENT '(0=guest,1=user,2=admin)',
  `agent_status` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1=Active, 2=Inactiv',
  `membership` tinyint(4) NOT NULL COMMENT '1=On, 2=Off ',
  PRIMARY KEY (`agent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `agents`
--

INSERT INTO `agents` (`agent_id`, `loginname`, `first_name`, `last_name`, `password`, `email`, `city`, `address`, `reg_date`, `role`, `agent_status`, `membership`) VALUES
(1, 'priya', '', '', '5c85f09c984285b0a1152e699cac68b7c9e8e957', 'priya@globussoft.com', 'hyderabad', 'hyderabad,India', '0000-00-00 00:00:00', 0, 1, 0),
(2, 'sibani mishra', '', '', '97ce5207f9ec54f6652d197dba8238b6', 'sibanimishra@globussoft.com', 'Bhubaneswar', 'Bhubaneswar,odisha,india', '2015-12-29 00:00:00', 0, 1, 1),
(3, 'nargis parween', '', '', '70b7efbc69f58f682a0014b53d70f929', 'nargisparween@globussoft.com', 'Bokaro', 'Bokaro,Jharkhand,India', '2015-12-07 00:00:00', 0, 1, 1),
(5, 'Vivek', '', '', '061a01a98f80f415b1431236b62bb10b', 'vivekkumar@globussoft.com', 'Mumbai', 'Mumbai,Maharastra,India', '0000-00-00 00:00:00', 0, 1, 1),
(6, 'anuradha', 'Anuradha', 'Anu', 'f09a4ddc62a6a6c15fc213f17e91d09c', 'anuradhak@globussoft.com', 'Bhilai', 'Bhilai,Chatisgarh,India', '0000-00-00 00:00:00', 0, 0, 1),
(7, 'kamala', '', '', '906e6c8f85fb1ecb6daeb5a1ba63ff58f1d7aaaf', 'kamala@gmail.com', 'hyderabad', 'kukatpally', '2016-01-14 14:14:08', 1, 0, 1),
(8, 'ziingo', '', '', '63e59f8b96ea2b8bcda7ebe4e575c52444d149f4', 'foodapp@globussoft.com', 'bhilai', 'chatiisgarh', '2016-01-19 06:35:21', 1, 1, 0),
(9, 'priya', 'priyanka', 'varanasi', '63e59f8b96ea2b8bcda7ebe4e575c52444d149f4', 'priyanka@yahoo.com', 'hyderabad', '', '2016-02-05 10:53:34', 1, 1, 0),
(10, 'Priya', 'priyanka', 'varanasi', '67a74306b06d0c01624fe0d0249a570f4d093747', 'priyankavaranasi@yahoo.com', 'hyderabad', 'kukatpally', '2016-02-06 08:21:37', 1, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_guys`
--

CREATE TABLE IF NOT EXISTS `delivery_guys` (
  `del_guy_id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `login_name` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `city` varchar(20) NOT NULL,
  `state` varchar(20) NOT NULL,
  `country` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `reg_date` datetime NOT NULL,
  `phone` varchar(20) NOT NULL,
  PRIMARY KEY (`del_guy_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `delivery_guys`
--

INSERT INTO `delivery_guys` (`del_guy_id`, `firstname`, `lastname`, `login_name`, `email`, `password`, `city`, `state`, `country`, `address`, `status`, `reg_date`, `phone`) VALUES
(1, 'Salman', ' Khan', 'salman', ' Khan@google.com', 'khan', 'mumbai', 'Maharashtra', 'India', 'XXXXXXXXXXXXXXXXX', 1, '2016-02-06 00:00:00', '963258741'),
(2, 'Sharukh', 'Khan', 'Sharukh ', 'Sharukh@yahoo.com', 'cb3057bd7dd0ee44e214dd4feb5189', 'Mumbai', 'Maharahstra', 'India', 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx', 1, '2016-02-09 07:14:09', '74125896356');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_status_log`
--

CREATE TABLE IF NOT EXISTS `delivery_status_log` (
  `status_id` int(30) NOT NULL AUTO_INCREMENT,
  `order_id` int(22) NOT NULL,
  `delivery_guy_id` int(22) NOT NULL,
  `status_type` tinyint(4) NOT NULL COMMENT '1=pickup done, 2=in transit, 3=delivered',
  `time` varchar(30) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `delivery_status_log`
--

INSERT INTO `delivery_status_log` (`status_id`, `order_id`, `delivery_guy_id`, `status_type`, `time`) VALUES
(1, 1, 2, 1, '30');

-- --------------------------------------------------------

--
-- Table structure for table `famous_cuisines`
--

CREATE TABLE IF NOT EXISTS `famous_cuisines` (
  `cuisine_id` int(11) NOT NULL AUTO_INCREMENT,
  `Cuisine_name` varchar(100) NOT NULL,
  `cuisine_status` tinyint(2) NOT NULL,
  PRIMARY KEY (`cuisine_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `famous_cuisines`
--

INSERT INTO `famous_cuisines` (`cuisine_id`, `Cuisine_name`, `cuisine_status`) VALUES
(1, ' Mexican cuisine', 1),
(2, 'Lebanese cuisine', 1),
(3, 'Greek cuisine', 1),
(4, ' Spanish cuisine', 1),
(5, 'Japanese cuisine', 1);

-- --------------------------------------------------------

--
-- Table structure for table `hotel_cuisines`
--

CREATE TABLE IF NOT EXISTS `hotel_cuisines` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT,
  `cuisine_id` int(11) NOT NULL,
  `hotel_id` int(11) NOT NULL,
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `hotel_cuisines`
--

INSERT INTO `hotel_cuisines` (`c_id`, `cuisine_id`, `hotel_id`) VALUES
(1, 2, 36),
(2, 4, 36),
(3, 2, 39),
(4, 4, 39),
(5, 2, 40),
(6, 1, 41);

-- --------------------------------------------------------

--
-- Table structure for table `hotel_details`
--

CREATE TABLE IF NOT EXISTS `hotel_details` (
  `id` int(22) NOT NULL AUTO_INCREMENT,
  `agent_id` int(22) DEFAULT NULL,
  `hotel_location` int(11) NOT NULL,
  `address` text NOT NULL,
  `primary_phone` varchar(30) NOT NULL,
  `secondary_phone` varchar(30) NOT NULL,
  `hotel_name` varchar(60) NOT NULL,
  `hotel_image` varchar(400) NOT NULL,
  `open_time` varchar(20) NOT NULL,
  `closing_time` varchar(20) NOT NULL,
  `hotel_status` tinyint(4) NOT NULL COMMENT '1=Active, 2=Inactive',
  `notice` text NOT NULL COMMENT 'special notfication for users , like sunday closed , etc.',
  `minorder` int(50) NOT NULL,
  `deliverycharge` int(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='one agent can have multiple hotels' AUTO_INCREMENT=42 ;

--
-- Dumping data for table `hotel_details`
--

INSERT INTO `hotel_details` (`id`, `agent_id`, `hotel_location`, `address`, `primary_phone`, `secondary_phone`, `hotel_name`, `hotel_image`, `open_time`, `closing_time`, `hotel_status`, `notice`, `minorder`, `deliverycharge`) VALUES
(1, 1, 9, 'AndhraPradesh,India', '7418529635', '99999999', 'Hotel FishLand', 'http://api.ziingo.globusapps.com/assets/hotel_images/fishlandhotel.jpg', '9', '10', 1, 'hotel will be closed on every sunday', 500, 50),
(2, 2, 8, 'Bhilai,Chatisgarh,India', '1234567889', '9854123657', 'Chanakya Restrurent', 'http://api.ziingo.globusapps.com/assets/hotel_images/metbkk_bkg_nahm_restaurant.jpg', '12pm', '2 am', 1, 'weekly satday and sunday holiday', 500, 200),
(3, 2, 9, 'Raipur,Chatisgarh,India', '785412365', '896521452', 'Surya Restrurent', 'http://api.ziingo.globusapps.com/assets/hotel_images/restrurent1.jpg', '8 am', '10 pm', 1, 'weekly  sunday off', 600, 100),
(4, 4, 4, 'Angul,Odisha,India', '1452145214', '78452123', 'Kohinur Restrurent', 'http://api.ziingo.globusapps.com/assets/hotel_images/images.jpg', '8 am', '10 pm', 1, 'weekly  wednesday off', 2000, 50),
(5, 8, 10, 'Bilashpur,India', '78451236523', '45124521463', 'King''s palace', 'http://api.ziingo.globusapps.com/assets/hotel_images/images2.jpg', '11 am', '12am', 1, 'No holiday', 1000, 999),
(6, 3, 8, 'sambalpur,India', '784512653', '784521652', 'Royal Enfield', 'http://api.ziingo.globusapps.com/assets/hotel_images/images2.jpg', '11 am', '12am', 1, 'No holiday', 500, 70),
(7, 2, 6, 'AP,India', '12345678', '12345678', 'Bhagirathi Inn', 'http://api.ziingo.globusapps.com/assets/hotel_images/restrurent526.jpg', '12 pm', '1 am', 1, 'all day working day', 1000, 80),
(8, 2, 7, 'AP,India', '4512365', '85296374', 'President Restrurent', 'http://api.ziingo.globusapps.com/assets/hotel_images/hotel.jpg', '12 pm', '1 am', 1, 'all day working day', 1000, 50),
(9, 4, 8, 'MP,India', '412563123', '789456212', 'Royal Restrurent', 'http://api.ziingo.globusapps.com/assets/hotel_images/image.jpg', '12 pm', '1 am', 1, 'sunday off', 1000, 400),
(10, 4, 2, 'Madhubani,India', '451245214', '1245214521', '3Q Restrurent', 'http://api.ziingo.globusapps.com/assets/hotel_images/images1234.jpg', '12 pm', '1 am', 1, 'sunday off', 700, 200),
(11, 1, 9, 'AP,India', '1343243445', '4354546575', 'Bajrangisuryahotel', 'http://api.ziingo.globusapps.com/assets/hotel_images/images5678.jpg', '6 pm', '12am', 1, 'every sunday working day', 300, 400),
(12, 8, 31, '', '7418529635', '7894561236', 'Taj Hotel', 'http://ziingo.globusapps.com/themes/agent/skin/hotelimages/8/12/images1.jpg', '10', '10', 1, '', 0, 0),
(13, 8, 26, '', '741563289', '985632414', 'Oberoi', 'http://ziingo.globusapps.com/themes/agent/skin/hotelimages/8/13/images.jpg', '10', '10', 1, '', 0, 0),
(14, 8, 25, '', '741569823', '589632147', 'Ambrossia', 'http://ziingo.globusapps.com/themes/agent/skin/hotelimages/8/14/images2.jpg', '10', '10', 1, '', 0, 0),
(15, 8, 28, '', '7419632581', '4569871236', 'Sanman Hotel', 'http://ziingo.globusapps.com/themes/agent/skin/hotelimages/8/15/images3.jpg', '10', '10', 1, '', 0, 0),
(16, 8, 22, '', '7418562369', '7539415365', 'Crystal palace', 'http://ziingo.globusapps.com/themes/agent/skin/hotelimages/8/16/images4.jpg', '10', '10', 1, '', 0, 0),
(17, 8, 28, '', '7413698523', '9876543214', 'Mysore Palace', 'http://ziingo.globusapps.com/themes/agent/skin/hotelimages/8/17/images5.jpg', '10', '10', 1, '', 0, 0),
(18, 8, 29, '', '7418529636', '3258964712', 'Hotel Maharaj', 'http://ziingo.globusapps.com/themes/agent/skin/hotelimages/8/18/images7.jpg', '10', '10', 1, '', 0, 0),
(19, 8, 25, '', '74125896325', '589632147', 'Kolkata Rolls', 'http://ziingo.globusapps.com/themes/agent/skin/hotelimages/8/19/images8.jpg', '10', '10', 1, '', 0, 0),
(20, 8, 24, '', '7412589636', '7412589636', 'CItyLights Restaurant', 'http://ziingo.globusapps.com/themes/agent/skin/hotelimages/8/20/images9.jpg', '10', '10', 1, '', 0, 0),
(21, 8, 22, '', '7412589635', '741256398', 'AvakaiBiryani Inn', 'http://ziingo.globusapps.com/themes/agent/skin/hotelimages/8/21/images10.jpg', '10', '10', 1, '', 0, 0),
(22, 8, 21, '', '7418526932', '9874563214', 'Hyderabadi Dhaba', 'http://ziingo.globusapps.com/themes/agent/skin/hotelimages/8/22/images6.jpg', '10', '10', 1, '', 0, 0),
(23, 8, 8, 'ringraod, Jntuk, kukatpally,', '741256398', '741256398', 'Sudae Hotel', '', '10', '10', 1, 'sunday holiday', 100, 100),
(24, 8, 26, 'Near Gardens opposite road ,Mysore', '741256398', '741256398', 'Taj Banajara', 'http://localhost.ziingo.com/themes/agent/skin/hotelimages/8/24/images4.jpg', '10', '10', 1, 'sunday holiday', 100, 100),
(25, 8, 30, 'near allepay canal road, allepey', '741256398', '741256398', 'Kerala Kitchen', 'http://localhost.ziingo.com/themes/agent/skin/hotelimages/8/25/images9.jpg', '10', '10', 1, 'sunday also working...', 100, 100),
(26, 8, 31, 'xxxxxxxxxxxxxxxxxxxxx', '741256398', '741256398', 'cochin Port Hotel', 'http://localhost.ziingo.com/themes/agent/skin/hotelimages/8/26/images6.jpg', '10', '10', 1, 'dsadasdasdasdasdasd', 100, 100),
(40, 8, 43, 'xxxxxxxxxxx', '741256398', '741256398', 'hotel allepy', '', '10', '10', 1, 'gfsgfgfgdgdfgdfg', 100, 100),
(41, 8, 44, 'opposite to mysore gardens , main raod, mysore', '213654789321', '1478523696', 'Mysore Gardens Restaurant', 'http://localhost.ziingo.com/themes/agent/skin/hotelimages/8/41/images4.jpg', '11', '11', 1, 'wednesday spls', 500, 50);

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE IF NOT EXISTS `location` (
  `location_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `location_type` tinyint(1) NOT NULL COMMENT '0:country,1:state,2:city,3:location',
  `parent_id` int(11) NOT NULL COMMENT 'parent location_id',
  `location_status` tinyint(1) NOT NULL COMMENT '0:Inactive,1:Active',
  PRIMARY KEY (`location_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=45 ;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`location_id`, `name`, `location_type`, `parent_id`, `location_status`) VALUES
(1, 'india', 0, 0, 1),
(2, 'China', 0, 0, 1),
(3, 'pakistan', 0, 0, 1),
(4, 'andhra Pradesh', 1, 1, 1),
(5, 'Hyderabad', 2, 4, 1),
(6, 'TamilNadu', 1, 1, 0),
(7, 'Chennai', 2, 6, 0),
(8, 'Kukatpally', 3, 5, 1),
(9, 'Marina Beach', 3, 7, 1),
(10, 'bangladesh', 0, 0, 0),
(11, 'Indonesia', 0, 0, 1),
(12, 'Visakhpatanm', 2, 4, 1),
(13, 'Coimbatore', 2, 6, 1),
(14, 'Karnataka', 1, 1, 1),
(15, 'Kerala', 1, 1, 1),
(16, 'Bangalore', 2, 14, 1),
(17, 'Mysore', 2, 14, 1),
(18, 'Allepey', 2, 15, 1),
(19, 'KodaiKanal', 2, 15, 1),
(20, 'Banjara hills', 3, 5, 1),
(21, 'Gajuwaka', 3, 12, 1),
(22, 'Rishi konda Beach', 3, 12, 1),
(23, 'Tnagar', 3, 7, 1),
(24, 'Ooty', 3, 13, 0),
(25, 'Anna nagar', 3, 13, 0),
(26, 'Electronic city', 3, 16, 1),
(27, 'White field', 3, 16, 1),
(28, 'palace Road', 3, 17, 1),
(29, 'Shivaji nagar', 3, 17, 1),
(30, 'tenmala', 3, 18, 1),
(31, 'cochin', 3, 18, 1),
(32, 'Canada', 0, 0, 1),
(33, 'Islamabad', 1, 3, 1),
(34, 'Sindh', 1, 0, 1),
(35, 'Tirupathi', 2, 4, 1),
(36, 'Tirumala', 3, 35, 1),
(41, 'kk road', 3, 19, 1),
(42, 'Canal Road', 3, 19, 1),
(43, 'allepy center', 3, 18, 1),
(44, 'Rose Gardens Street', 3, 17, 1);

-- --------------------------------------------------------

--
-- Table structure for table `menu_category`
--

CREATE TABLE IF NOT EXISTS `menu_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(60) NOT NULL,
  `cat_desc` text NOT NULL,
  `cat_status` tinyint(4) NOT NULL COMMENT '1=Active, 2=Inactive',
  `last_update` datetime NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `menu_category`
--

INSERT INTO `menu_category` (`category_id`, `cat_name`, `cat_desc`, `cat_status`, `last_update`) VALUES
(1, 'Drinks', '', 1, '0000-00-00 00:00:00'),
(2, 'starters', '', 1, '0000-00-00 00:00:00'),
(3, 'Snacks', '', 1, '0000-00-00 00:00:00'),
(4, 'Lunch', '', 1, '2015-12-29 00:00:00'),
(5, 'Dinner', '', 1, '2015-12-29 00:00:00'),
(6, 'Chinese', '', 1, '2015-12-21 00:00:00'),
(7, 'Thai', '', 1, '2015-12-15 00:00:00'),
(8, 'Italian', '', 1, '2015-12-20 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(22) NOT NULL AUTO_INCREMENT,
  `user_id` int(22) NOT NULL,
  `total_amount` float NOT NULL,
  `order_from_hotel` int(11) NOT NULL,
  `order_date` datetime NOT NULL,
  `order_status` tinyint(4) NOT NULL COMMENT '1=in process, 2=delivered , 3=cancelled',
  `pay_status` tinyint(4) NOT NULL COMMENT '0=pending, 1=complete , 2=failed, 3=COD',
  `pay_type` tinyint(4) NOT NULL COMMENT '1=COD, 2=paypal',
  `delivery_status` tinyint(4) NOT NULL COMMENT '0=pending, 1=complete , 2=return/cancel, 3=unable to reach',
  `delivery_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '(1=delivery to address, 2=pickup)',
  `user_message` varchar(500) NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=185 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `total_amount`, `order_from_hotel`, `order_date`, `order_status`, `pay_status`, `pay_type`, `delivery_status`, `delivery_type`, `user_message`) VALUES
(1, 9, 100, 0, '2016-01-06 06:22:54', 1, 1, 1, 0, 0, ''),
(33, 9, 100, 0, '2016-01-06 06:24:30', 1, 1, 1, 0, 0, ''),
(34, 9, 100, 0, '2016-01-06 06:25:07', 1, 1, 1, 0, 0, ''),
(35, 9, 100, 0, '2016-01-06 06:27:58', 1, 1, 1, 0, 0, ''),
(36, 5, 500, 0, '2016-01-06 06:29:18', 1, 1, 1, 0, 0, ''),
(37, 5, 500, 0, '2016-01-06 06:44:58', 1, 1, 1, 0, 0, ''),
(39, 2, 500, 0, '2016-01-06 06:50:23', 1, 1, 1, 0, 0, ''),
(40, 5, 500, 0, '2016-01-06 13:21:23', 1, 1, 1, 0, 0, ''),
(41, 9, 500, 0, '2016-01-06 13:21:50', 1, 1, 1, 0, 0, ''),
(42, 9, 500, 0, '2016-01-06 13:25:40', 1, 1, 1, 0, 0, ''),
(43, 9, 500, 0, '2016-01-06 13:25:55', 1, 1, 1, 0, 0, ''),
(44, 9, 500, 0, '2016-01-06 13:28:30', 1, 1, 1, 0, 0, ''),
(45, 9, 500, 0, '2016-01-06 13:28:32', 1, 1, 1, 0, 0, ''),
(46, 4, 500, 0, '2016-01-06 13:28:41', 1, 1, 1, 0, 0, ''),
(47, 4, 500, 0, '2016-01-06 13:30:53', 1, 1, 1, 0, 0, ''),
(48, 4, 500, 0, '2016-01-06 13:31:04', 1, 1, 1, 0, 0, ''),
(49, 10, 500, 0, '2016-01-06 13:32:53', 1, 1, 1, 0, 0, ''),
(50, 10, 500, 0, '2016-01-06 13:33:35', 1, 1, 1, 0, 0, ''),
(51, 10, 500, 0, '2016-01-06 13:38:27', 1, 1, 1, 0, 0, ''),
(52, 10, 500, 0, '2016-01-06 13:38:54', 1, 1, 1, 0, 0, ''),
(53, 10, 500, 0, '2016-01-06 13:38:56', 1, 1, 1, 0, 0, ''),
(54, 10, 500, 0, '2016-01-06 13:39:24', 1, 1, 1, 0, 0, ''),
(55, 10, 500, 0, '2016-01-06 13:39:26', 1, 1, 1, 0, 0, ''),
(56, 10, 500, 0, '2016-01-06 13:41:01', 1, 1, 1, 0, 0, ''),
(57, 10, 500, 0, '2016-01-06 13:42:13', 1, 1, 1, 0, 0, ''),
(58, 5, 100, 0, '2016-01-07 07:53:45', 1, 1, 1, 0, 0, ''),
(59, 5, 100, 0, '2016-01-07 07:54:10', 1, 1, 1, 0, 0, ''),
(60, 4, 50, 0, '2016-01-07 07:55:38', 1, 1, 1, 0, 0, ''),
(61, 11, 50, 0, '2016-01-07 08:21:48', 1, 1, 1, 0, 0, ''),
(63, 4, 100, 0, '2016-01-07 11:40:58', 0, 0, 0, 0, 0, ''),
(64, 4, 100, 0, '2016-01-07 11:50:38', 0, 0, 0, 0, 0, ''),
(65, 15, 1250, 0, '2016-01-07 13:20:32', 0, 0, 0, 0, 0, ''),
(66, 6, 440, 0, '2016-01-07 13:34:43', 0, 0, 0, 0, 0, ''),
(67, 6, 440, 0, '2016-01-07 13:34:46', 0, 0, 0, 0, 0, ''),
(68, 6, 170, 0, '2016-01-07 13:36:06', 0, 0, 0, 0, 0, ''),
(69, 4, 100, 0, '2016-01-07 13:36:23', 0, 0, 0, 0, 0, ''),
(70, 6, 170, 0, '2016-01-07 13:36:36', 0, 0, 0, 0, 0, ''),
(71, 6, 170, 0, '2016-01-07 13:36:36', 0, 0, 0, 0, 0, ''),
(72, 6, 170, 0, '2016-01-07 13:36:36', 0, 0, 0, 0, 0, ''),
(73, 6, 170, 0, '2016-01-07 13:36:36', 0, 0, 0, 0, 0, ''),
(74, 6, 170, 0, '2016-01-07 13:36:37', 0, 0, 0, 0, 0, ''),
(75, 6, 170, 0, '2016-01-07 13:36:37', 0, 0, 0, 0, 0, ''),
(76, 15, 170, 0, '2016-01-07 13:52:31', 0, 0, 0, 0, 0, ''),
(77, 15, 170, 0, '2016-01-07 13:52:31', 0, 0, 0, 0, 0, ''),
(78, 15, 170, 0, '2016-01-07 13:52:48', 0, 0, 0, 0, 0, ''),
(79, 15, 500, 0, '2016-01-07 13:55:58', 0, 0, 0, 0, 0, ''),
(80, 15, 650, 0, '2016-01-07 13:56:04', 0, 0, 0, 0, 0, ''),
(81, 15, 290, 0, '2016-01-07 13:57:18', 0, 0, 0, 0, 0, ''),
(82, 15, 650, 0, '2016-01-07 14:05:41', 0, 0, 0, 0, 0, ''),
(83, 4, 100, 0, '2016-01-07 14:06:25', 0, 0, 0, 0, 0, ''),
(84, 4, 100, 0, '2016-01-07 14:06:30', 0, 0, 0, 0, 0, ''),
(85, 15, 440, 0, '2016-01-07 14:17:11', 0, 0, 0, 0, 0, ''),
(86, 15, 250, 0, '2016-01-07 14:38:41', 0, 0, 0, 0, 0, ''),
(87, 15, 380, 0, '2016-01-07 14:45:33', 0, 0, 0, 0, 0, ''),
(88, 15, 500, 0, '2016-01-08 05:12:34', 0, 0, 0, 0, 0, ''),
(89, 15, 80, 0, '2016-01-08 05:48:20', 0, 0, 0, 0, 0, ''),
(90, 15, 350, 0, '2016-01-08 06:12:08', 0, 0, 0, 0, 0, ''),
(91, 15, 320, 0, '2016-01-08 06:24:48', 0, 0, 0, 0, 0, ''),
(92, 15, 320, 0, '2016-01-08 06:41:21', 0, 0, 0, 0, 0, ''),
(93, 15, 400, 0, '2016-01-08 06:57:47', 0, 0, 0, 0, 0, ''),
(94, 15, 500, 0, '2016-01-08 07:30:38', 0, 0, 0, 0, 0, ''),
(95, 15, 500, 0, '2016-01-08 07:54:01', 0, 0, 0, 0, 0, ''),
(96, 15, 170, 0, '2016-01-08 07:57:06', 0, 0, 0, 0, 0, ''),
(97, 15, 250, 0, '2016-01-08 08:18:32', 0, 0, 0, 0, 0, ''),
(98, 15, 110, 0, '2016-01-08 08:36:19', 0, 0, 0, 0, 0, ''),
(99, 15, 850, 0, '2016-01-08 09:58:53', 0, 0, 0, 0, 0, ''),
(100, 15, 850, 0, '2016-01-08 09:59:06', 0, 0, 0, 0, 0, ''),
(101, 15, 150, 0, '2016-01-08 09:59:32', 0, 0, 0, 0, 0, ''),
(102, 15, 290, 0, '2016-01-08 10:04:13', 0, 0, 0, 0, 0, ''),
(103, 15, 160, 0, '2016-01-08 10:26:42', 0, 0, 0, 0, 0, ''),
(104, 15, 170, 0, '2016-01-08 10:46:44', 0, 0, 0, 0, 0, ''),
(105, 15, 230, 0, '2016-01-08 11:04:39', 0, 0, 0, 0, 0, ''),
(106, 15, 110, 0, '2016-01-08 11:05:11', 0, 0, 0, 0, 0, ''),
(107, 15, 100, 0, '2016-01-08 11:09:36', 0, 0, 0, 0, 0, ''),
(108, 15, 100, 0, '2016-01-08 11:26:32', 0, 0, 0, 0, 0, ''),
(109, 15, 110, 0, '2016-01-08 11:44:18', 0, 0, 0, 0, 0, ''),
(110, 15, 500, 0, '2016-01-08 12:18:40', 0, 0, 0, 0, 0, ''),
(111, 15, 320, 0, '2016-01-08 13:11:19', 0, 0, 0, 0, 0, ''),
(112, 15, 450, 0, '2016-01-08 13:13:01', 0, 0, 0, 0, 0, ''),
(113, 15, 250, 0, '2016-01-09 05:25:57', 0, 0, 0, 0, 0, ''),
(114, 15, 400, 0, '2016-01-09 06:04:04', 0, 0, 0, 0, 0, ''),
(115, 15, 300, 0, '2016-01-09 06:21:15', 0, 0, 0, 0, 0, ''),
(116, 15, 100, 0, '2016-01-09 06:33:21', 0, 0, 0, 0, 0, ''),
(117, 15, 1250, 0, '2016-01-09 06:38:25', 0, 0, 0, 0, 0, ''),
(118, 15, 150, 0, '2016-01-09 06:42:40', 0, 0, 0, 0, 0, ''),
(119, 15, 200, 0, '2016-01-09 06:48:15', 0, 0, 0, 0, 0, ''),
(120, 15, 60, 0, '2016-01-09 06:49:08', 0, 0, 0, 0, 0, ''),
(121, 15, 250, 0, '2016-01-09 06:52:17', 0, 0, 0, 0, 0, ''),
(122, 15, 260, 0, '2016-01-09 08:55:35', 0, 0, 0, 0, 0, ''),
(123, 15, 250, 0, '2016-01-09 09:06:17', 0, 0, 0, 0, 0, ''),
(124, 15, 350, 0, '2016-01-09 09:06:38', 0, 0, 0, 0, 0, ''),
(125, 15, 800, 0, '2016-01-09 09:29:47', 0, 0, 0, 0, 0, ''),
(126, 15, 500, 0, '2016-01-11 04:54:00', 0, 0, 0, 0, 0, ''),
(127, 15, 500, 0, '2016-01-11 04:54:00', 0, 0, 0, 0, 0, ''),
(128, 10, 400, 0, '2016-01-11 06:12:42', 0, 0, 0, 0, 0, ''),
(129, 15, 1250, 0, '2016-01-11 06:45:01', 0, 0, 0, 0, 0, ''),
(130, 15, 1250, 0, '2016-01-11 06:45:26', 0, 0, 0, 0, 0, ''),
(131, 15, 1250, 0, '2016-01-11 06:45:41', 0, 0, 0, 0, 0, ''),
(132, 15, 150, 0, '2016-01-11 07:11:03', 0, 0, 0, 0, 0, ''),
(133, 15, 90, 0, '2016-01-11 07:17:12', 0, 0, 0, 0, 0, ''),
(134, 15, 230, 0, '2016-01-11 07:20:58', 0, 0, 0, 0, 0, ''),
(135, 15, 100, 0, '2016-01-11 08:17:38', 0, 0, 0, 0, 0, ''),
(136, 15, 250, 0, '2016-01-11 08:22:57', 0, 0, 0, 0, 0, ''),
(137, 15, 160, 0, '2016-01-11 10:17:06', 0, 0, 0, 0, 0, ''),
(138, 15, 380, 0, '2016-01-11 10:22:03', 0, 0, 0, 0, 0, ''),
(139, 15, 550, 0, '2016-01-11 10:25:06', 0, 0, 0, 0, 0, ''),
(140, 15, 550, 0, '2016-01-11 10:27:32', 0, 0, 0, 0, 0, ''),
(141, 15, 150, 0, '2016-01-11 12:24:07', 0, 0, 0, 0, 0, ''),
(142, 15, 80, 0, '2016-01-11 13:28:20', 0, 0, 0, 0, 0, ''),
(143, 15, 850, 0, '2016-01-11 14:23:53', 0, 0, 0, 0, 0, ''),
(144, 15, 150, 0, '2016-01-11 14:25:38', 0, 0, 0, 0, 0, ''),
(145, 15, 110, 0, '2016-01-11 14:28:53', 0, 0, 0, 0, 0, ''),
(146, 24, 0, 0, '2016-02-04 13:15:00', 0, 0, 0, 0, 1, 'first order in ZIINGO'),
(147, 24, 0, 0, '2016-02-04 13:17:11', 0, 0, 0, 0, 1, 'first order in ZIINGO'),
(148, 24, 0, 0, '2016-02-04 13:18:21', 0, 0, 0, 0, 2, 'no message'),
(149, 24, 0, 0, '2016-02-04 13:19:46', 0, 0, 0, 0, 1, 'dasfdsfdsfdsfds'),
(150, 24, 0, 0, '2016-02-04 13:21:03', 0, 0, 0, 0, 1, 'dasfdsfdsfdsfds'),
(151, 24, 0, 0, '2016-02-04 13:22:41', 0, 0, 0, 0, 2, 'asdasdasdasd'),
(152, 24, 0, 0, '2016-02-04 13:23:30', 0, 0, 0, 0, 1, 'fdafdsfdsf'),
(153, 24, 0, 0, '2016-02-04 13:25:30', 0, 0, 0, 0, 1, 'fdafdsfdsf'),
(154, 24, 0, 0, '2016-02-04 13:26:09', 0, 0, 0, 0, 2, 'dfsdsfdsfsdf'),
(155, 24, 0, 0, '2016-02-04 13:26:31', 0, 0, 0, 0, 2, 'dfsdsfdsfsdf'),
(156, 24, 0, 0, '2016-02-04 13:27:32', 0, 0, 0, 0, 2, 'fgdfgdfgdfg'),
(157, 24, 0, 0, '2016-02-04 13:28:56', 0, 0, 0, 0, 1, 'fsdfdsfdsf'),
(158, 24, 0, 0, '2016-02-04 13:29:12', 0, 0, 0, 0, 1, 'fsdfdsfdsf'),
(159, 24, 0, 0, '2016-02-04 13:29:30', 0, 0, 0, 0, 1, 'fsdfdsfdsf'),
(160, 24, 0, 0, '2016-02-04 13:29:57', 0, 0, 0, 0, 1, 'fsdfdsfdsf'),
(161, 24, 0, 0, '2016-02-04 13:30:17', 0, 0, 0, 0, 1, 'fsdfdsfdsf'),
(162, 24, 0, 0, '2016-02-04 13:30:29', 0, 0, 0, 0, 1, 'fsdfdsfdsf'),
(163, 24, 0, 0, '2016-02-04 13:30:59', 0, 0, 0, 0, 1, 'fsdfdsfdsf'),
(164, 24, 0, 0, '2016-02-04 13:32:51', 0, 0, 0, 0, 1, 'fsdfdsfdsf'),
(165, 24, 0, 0, '2016-02-04 13:32:54', 0, 0, 0, 0, 1, 'fsdfdsfdsf'),
(166, 24, 0, 0, '2016-02-04 13:33:22', 0, 0, 0, 0, 1, 'fsdfdsfdsf'),
(167, 24, 0, 0, '2016-02-04 13:33:37', 0, 0, 0, 0, 1, 'fsdfdsfdsf'),
(168, 24, 0, 0, '2016-02-04 13:34:58', 0, 0, 0, 0, 1, 'fsdfdsfdsf'),
(169, 24, 0, 0, '2016-02-04 13:36:13', 0, 0, 0, 0, 1, 'fsdfdsfdsf'),
(170, 24, 0, 0, '2016-02-04 13:36:59', 0, 0, 0, 0, 1, 'fsdfdsfdsf'),
(171, 24, 0, 0, '2016-02-04 13:37:17', 0, 0, 0, 0, 1, 'fsdfdsfdsf'),
(172, 24, 0, 0, '2016-02-04 14:50:00', 0, 0, 0, 0, 1, 'fsdfdsfdsf'),
(173, 24, 0, 0, '2016-02-04 14:50:31', 0, 0, 0, 0, 1, 'fsdfdsfdsf'),
(174, 24, 0, 0, '2016-02-04 14:50:49', 0, 0, 0, 0, 1, 'fsdfdsfdsf'),
(175, 24, 0, 0, '2016-02-04 14:53:30', 0, 0, 0, 0, 1, 'fsdfdsfdsf'),
(176, 24, 0, 0, '2016-02-04 14:54:35', 0, 0, 0, 0, 1, 'fsdfdsfdsf'),
(177, 24, 0, 0, '2016-02-04 14:55:07', 0, 0, 0, 0, 1, 'fsdfdsfdsf'),
(178, 24, 0, 0, '2016-02-04 14:55:27', 0, 0, 0, 0, 1, 'fsdfdsfdsf'),
(179, 24, 350, 0, '2016-02-04 14:57:49', 0, 0, 0, 0, 1, 'fsdfdsfdsf'),
(180, 24, 350, 0, '2016-02-04 15:05:36', 0, 0, 0, 0, 2, 'gdfgdfgdfgdfgdfgdfgdfg'),
(181, 24, 350, 0, '2016-02-04 15:08:55', 0, 0, 0, 0, 2, 'dsadasdasdasdasdasd'),
(182, 24, 350, 0, '2016-02-04 15:11:56', 0, 0, 0, 0, 2, 'dasdasdasdas'),
(183, 24, 350, 0, '2016-02-04 15:19:30', 0, 0, 0, 0, 2, 'dasdasasdasdas'),
(184, 24, 350, 0, '2016-02-05 06:50:28', 0, 0, 0, 0, 2, 'this is new order');

-- --------------------------------------------------------

--
-- Table structure for table `order_products`
--

CREATE TABLE IF NOT EXISTS `order_products` (
  `order_product_id` int(22) NOT NULL AUTO_INCREMENT,
  `order_id` int(22) DEFAULT NULL,
  `ordered_cart_id` int(22) NOT NULL,
  `product_cost` float NOT NULL COMMENT 'unit cost, i.e. cost of single item',
  `product_discount` float NOT NULL,
  `pay_amount` float NOT NULL,
  `quantity` int(5) NOT NULL DEFAULT '1',
  `coupon_id` int(11) NOT NULL,
  `hotel_id` int(22) NOT NULL,
  PRIMARY KEY (`order_product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=143 ;

--
-- Dumping data for table `order_products`
--

INSERT INTO `order_products` (`order_product_id`, `order_id`, `ordered_cart_id`, `product_cost`, `product_discount`, `pay_amount`, `quantity`, `coupon_id`, `hotel_id`) VALUES
(2, 33, 1, 0, 0, 0, 1, 0, 1),
(3, 34, 1, 0, 0, 0, 1, 0, 1),
(4, 35, 1, 0, 0, 0, 1, 0, 1),
(5, 36, 2, 0, 0, 0, 1, 0, 4),
(6, 37, 2, 0, 0, 0, 1, 0, 4),
(7, 39, 2, 0, 0, 0, 1, 0, 1),
(8, 40, 2, 0, 0, 0, 1, 0, 4),
(9, 41, 2, 0, 0, 0, 1, 0, 4),
(10, 42, 2, 0, 0, 0, 1, 0, 4),
(11, 43, 2, 0, 0, 0, 1, 0, 4),
(12, 44, 2, 0, 0, 0, 1, 0, 4),
(13, 45, 2, 0, 0, 0, 1, 0, 4),
(14, 46, 2, 0, 0, 0, 1, 0, 4),
(15, 47, 2, 0, 0, 0, 1, 0, 4),
(16, 48, 2, 0, 0, 0, 1, 0, 4),
(17, 49, 6, 0, 0, 0, 1, 0, 5),
(18, 50, 6, 0, 0, 0, 1, 0, 5),
(19, 51, 6, 0, 0, 0, 1, 0, 5),
(20, 52, 6, 0, 0, 0, 1, 0, 5),
(21, 53, 6, 0, 0, 0, 1, 0, 5),
(22, 54, 6, 0, 0, 0, 1, 0, 5),
(23, 55, 6, 0, 0, 0, 1, 0, 5),
(24, 56, 6, 0, 0, 0, 1, 0, 5),
(25, 57, 6, 0, 0, 0, 1, 0, 5),
(26, 58, 7, 0, 0, 0, 1, 0, 5),
(27, 59, 7, 0, 0, 0, 1, 0, 5),
(28, 60, 5, 0, 0, 0, 1, 0, 4),
(29, 61, 1, 0, 0, 0, 1, 0, 2),
(30, 63, 4, 0, 0, 0, 1, 0, 4),
(31, 64, 4, 0, 0, 0, 1, 0, 4),
(32, 65, 1, 0, 0, 0, 3, 0, 1),
(33, 66, 17, 0, 0, 0, 4, 0, 2),
(34, 67, 17, 0, 0, 0, 4, 0, 2),
(35, 68, 9, 0, 0, 0, 2, 0, 1),
(36, 69, 4, 0, 0, 0, 1, 0, 4),
(37, 70, 9, 0, 0, 0, 2, 0, 1),
(38, 71, 9, 0, 0, 0, 2, 0, 1),
(39, 72, 9, 0, 0, 0, 2, 0, 1),
(40, 73, 9, 0, 0, 0, 2, 0, 1),
(41, 74, 9, 0, 0, 0, 2, 0, 1),
(42, 75, 9, 0, 0, 0, 2, 0, 1),
(43, 76, 9, 0, 0, 0, 2, 0, 4),
(44, 77, 9, 0, 0, 0, 2, 0, 4),
(45, 78, 9, 0, 0, 0, 2, 0, 4),
(46, 79, 5, 0, 0, 0, 2, 0, 2),
(47, 80, 5, 0, 0, 0, 3, 0, 2),
(48, 81, 7, 0, 0, 0, 3, 0, 4),
(49, 82, 4, 0, 0, 0, 4, 0, 1),
(50, 83, 4, 0, 0, 0, 1, 0, 4),
(51, 84, 4, 0, 0, 0, 1, 0, 4),
(52, 85, 17, 0, 0, 0, 4, 0, 2),
(53, 86, 6, 0, 0, 0, 3, 0, 3),
(54, 87, 17, 0, 0, 0, 3, 0, 2),
(55, 88, 2, 0, 0, 0, 3, 0, 1),
(56, 89, 12, 0, 0, 0, 3, 0, 1),
(57, 90, 4, 0, 0, 0, 2, 0, 1),
(58, 91, 16, 0, 0, 0, 2, 0, 2),
(59, 92, 16, 0, 0, 0, 2, 0, 2),
(60, 93, 6, 0, 0, 0, 4, 0, 2),
(61, 94, 5, 0, 0, 0, 3, 0, 1),
(62, 95, 4, 0, 0, 0, 3, 0, 1),
(63, 96, 9, 0, 0, 0, 2, 0, 4),
(64, 97, 18, 0, 0, 0, 1, 0, 2),
(65, 98, 9, 0, 0, 0, 1, 0, 1),
(66, 99, 1, 0, 0, 0, 2, 0, 1),
(67, 100, 1, 0, 0, 0, 2, 0, 1),
(68, 101, 18, 0, 0, 0, 1, 0, 3),
(69, 102, 9, 0, 0, 0, 4, 0, 1),
(70, 103, 17, 0, 0, 0, 1, 0, 3),
(71, 104, 9, 0, 0, 0, 2, 0, 1),
(72, 105, 10, 0, 0, 0, 3, 0, 1),
(73, 106, 8, 0, 0, 0, 1, 0, 1),
(74, 107, 6, 0, 0, 0, 1, 0, 1),
(75, 108, 6, 0, 0, 0, 1, 0, 1),
(76, 109, 16, 0, 0, 0, 1, 0, 1),
(77, 110, 2, 0, 0, 0, 2, 0, 2),
(78, 111, 17, 0, 0, 0, 2, 0, 2),
(79, 112, 18, 0, 0, 0, 7, 0, 3),
(80, 113, 6, 0, 0, 0, 3, 0, 3),
(81, 114, 6, 0, 0, 0, 4, 0, 2),
(82, 115, 6, 0, 0, 0, 4, 0, 3),
(83, 116, 18, 0, 0, 0, 1, 0, 1),
(84, 117, 1, 0, 0, 0, 3, 0, 1),
(85, 118, 18, 0, 0, 0, 1, 0, 3),
(86, 119, 2, 0, 0, 0, 1, 0, 1),
(87, 120, 12, 0, 0, 0, 1, 0, 1),
(88, 121, 18, 0, 0, 0, 1, 0, 2),
(89, 122, 17, 0, 0, 0, 1, 0, 2),
(90, 123, 2, 0, 0, 0, 1, 0, 3),
(91, 124, 2, 0, 0, 0, 1, 0, 2),
(92, 125, 5, 0, 0, 0, 5, 0, 1),
(93, 126, 5, 0, 0, 0, 3, 0, 1),
(94, 127, 5, 0, 0, 0, 3, 0, 1),
(95, 128, 3, 0, 0, 0, 1, 0, 5),
(96, 129, 1, 0, 0, 0, 3, 0, 1),
(97, 130, 1, 0, 0, 0, 3, 0, 1),
(98, 131, 1, 0, 0, 0, 3, 0, 1),
(99, 132, 6, 0, 0, 0, 1, 0, 3),
(100, 133, 12, 0, 0, 0, 1, 0, 7),
(101, 134, 9, 0, 0, 0, 3, 0, 4),
(102, 135, 18, 0, 0, 0, 1, 0, 1),
(103, 136, 2, 0, 0, 0, 1, 0, 3),
(104, 137, 17, 0, 0, 0, 1, 0, 3),
(105, 138, 17, 0, 0, 0, 3, 0, 2),
(106, 139, 6, 0, 0, 0, 7, 0, 2),
(107, 140, 2, 0, 0, 0, 3, 0, 3),
(108, 141, 6, 0, 0, 0, 1, 0, 3),
(109, 142, 11, 0, 0, 0, 3, 0, 4),
(110, 143, 1, 0, 0, 0, 2, 0, 1),
(111, 144, 18, 0, 0, 0, 1, 0, 3),
(112, 145, 9, 0, 0, 0, 1, 0, 4),
(113, 175, 213, 150, 0, 150, 1, 0, 2),
(114, 175, 214, 150, 0, 150, 1, 0, 2),
(115, 175, 215, 50, 0, 50, 1, 0, 2),
(116, 176, 216, 150, 0, 150, 1, 0, 2),
(117, 176, 217, 150, 0, 150, 1, 0, 2),
(118, 176, 218, 50, 0, 50, 1, 0, 2),
(119, 177, 219, 150, 0, 150, 1, 0, 2),
(120, 177, 220, 150, 0, 150, 1, 0, 2),
(121, 177, 221, 50, 0, 50, 1, 0, 2),
(122, 178, 222, 150, 0, 150, 1, 0, 2),
(123, 178, 223, 150, 0, 150, 1, 0, 2),
(124, 178, 224, 50, 0, 50, 1, 0, 2),
(125, 179, 225, 150, 0, 150, 1, 0, 2),
(126, 179, 226, 150, 0, 150, 1, 0, 2),
(127, 179, 227, 50, 0, 50, 1, 0, 2),
(128, 180, 228, 150, 0, 150, 1, 0, 2),
(129, 180, 229, 150, 0, 150, 1, 0, 2),
(130, 180, 230, 50, 0, 50, 1, 0, 2),
(131, 181, 231, 150, 0, 150, 1, 0, 2),
(132, 181, 232, 150, 0, 150, 1, 0, 2),
(133, 181, 233, 50, 0, 50, 1, 0, 2),
(134, 182, 234, 150, 0, 150, 1, 0, 2),
(135, 182, 235, 150, 0, 150, 1, 0, 2),
(136, 182, 236, 50, 0, 50, 1, 0, 2),
(137, 183, 237, 150, 0, 150, 1, 0, 2),
(138, 183, 238, 150, 0, 150, 1, 0, 2),
(139, 183, 239, 50, 0, 50, 1, 0, 2),
(140, 184, 240, 150, 0, 150, 1, 0, 2),
(141, 184, 241, 150, 0, 150, 1, 0, 2),
(142, 184, 242, 50, 0, 50, 1, 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(30) NOT NULL AUTO_INCREMENT,
  `agent_id` int(22) NOT NULL,
  `hotel_id` int(11) NOT NULL,
  `item_type` tinyint(4) NOT NULL COMMENT '1=hotel items, 2=grocerry items',
  `prod_type` tinyint(4) NOT NULL COMMENT '(1=category,2=cuisine)',
  `category_id` int(22) NOT NULL,
  `cuisine_id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `prod_desc` text NOT NULL,
  `imagelink` text NOT NULL,
  `cost` float NOT NULL,
  `product_discount` int(11) NOT NULL,
  `product_discount_type` tinyint(14) NOT NULL COMMENT '(1=%,2=amount)',
  `delivery_time` int(11) NOT NULL COMMENT '1= 1mins, integer will be counted as minutes',
  `prod_status` tinyint(4) NOT NULL COMMENT '1=Available. 2=Unavialable',
  `added_date` datetime NOT NULL,
  `servicetax` int(50) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `agent_id`, `hotel_id`, `item_type`, `prod_type`, `category_id`, `cuisine_id`, `name`, `prod_desc`, `imagelink`, `cost`, `product_discount`, `product_discount_type`, `delivery_time`, `prod_status`, `added_date`, `servicetax`) VALUES
(2, 1, 1, 1, 0, 1, 0, 'Veg Manchuria', 'All you need is love. But a little Manchurian now  will be awesome. ', 'http://api.ziingo.globusapps.com/assets/productimages/Veg Manchuria.jpg",', 150, 0, 0, 0, 1, '0000-00-00 00:00:00', 20),
(3, 1, 1, 1, 0, 3, 0, 'PaniPuri', 'After Couple of Panipuri with us, one can forgive anybody, even their ex too.', 'http://api.ziingo.globusapps.com/assets/productimages/PaniPuri.jpg', 150, 0, 0, 0, 1, '0000-00-00 00:00:00', 5),
(4, 1, 2, 0, 0, 2, 0, 'Chilli Panner', 'There is no love sincerer than the love of Chilli Paneer.', 'http://api.ziingo.globusapps.com/assets/productimages/Chilli Panner.jpg', 150, 0, 0, 0, 1, '0000-00-00 00:00:00', 13),
(5, 1, 2, 1, 0, 2, 0, 'Spring Rolls', 'If anything is good for pounding humility into you permanently, it''s the spring rolls.', 'http://api.ziingo.globusapps.com/assets/productimages/springroll.jpg', 150, 0, 0, 0, 1, '0000-00-00 00:00:00', 20),
(6, 2, 2, 1, 0, 1, 0, 'Brain Hemorrhage', 'Give Your Brain a Relaxing time with our Brain Hemorrhage.', 'http://api.ziingo.globusapps.com/assets/productimages/juice.jpg', 50, 0, 0, 15, 1, '2015-12-08 00:00:00', 30),
(7, 4, 4, 1, 0, 4, 0, 'gobi 65', 'Missing your home, come let''s share the feeling with our awesome gobi 65. ', 'http://api.ziingo.globusapps.com/assets/productimages/gobichilly.jpg', 80, 0, 0, 30, 1, '2015-12-23 00:00:00', 8),
(8, 3, 5, 1, 0, 6, 0, 'Dumplings', 'Give Yourself a reason to smile by tasting our Dumplings. ', 'http://api.ziingo.globusapps.com/assets/productimages/dumplings.jpg', 60, 0, 0, 30, 1, '2015-12-16 00:00:00', 5),
(9, 2, 4, 1, 0, 3, 0, 'Masala Pav', 'The easiest way of adding spice to your life is by taking our masala pav.', 'http://api.ziingo.globusapps.com/assets/productimages/masalapav.jpg', 60, 0, 0, 30, 1, '2015-12-16 00:00:00', 10),
(10, 2, 7, 1, 0, 5, 0, 'Chapati', 'Missing your home, come let''s share the feeling with our awesome chapati. ', 'http://api.ziingo.globusapps.com/assets/productimages/chapati.jpg', 60, 0, 0, 30, 1, '2015-12-16 00:00:00', 5),
(11, 4, 10, 1, 0, 4, 0, 'steam rice', 'Increase the hotness quotient of yourself by getting our Steam Rice.', 'http://api.ziingo.globusapps.com/assets/productimages/steamrice.jpg', 10, 0, 0, 10, 1, '2015-12-23 00:00:00', 5),
(12, 1, 11, 1, 0, 5, 0, 'Biryani', ' If your Girlfriend Chooses our Biryani over shopping then marry her.', '/assets/productimages/12/index18.jpg', 10, 0, 2, 10, 1, '2015-12-23 00:00:00', 20),
(13, 1, 11, 1, 0, 5, 0, 'Thali', 'Thali: Redefine the meaning of delicious by tasting our Thali.', 'http://api.ziingo.globusapps.com/assets/productimages/thali.jpg', 10, 0, 0, 10, 1, '2015-12-23 00:00:00', 5),
(14, 1, 1, 1, 0, 5, 0, 'Thali', 'Thali: Redefine the meaning of delicious by tasting our Thali.', 'http://api.ziingo.globusapps.com/assets/productimages/thali.jpg', 10, 0, 0, 10, 1, '2015-12-23 00:00:00', 5),
(16, 1, 1, 1, 0, 2, 0, 'Spring roll', 'If anything is good for pounding humility into you permanently, it''s the spring rolls.', 'http://api.ziingo.globusapps.com/assets/productimages/springroll.jpg', 60, 0, 0, 30, 1, '2015-12-23 00:00:00', 7),
(17, 1, 1, 1, 0, 1, 0, 'health drink', 'Who said just beer is awesome? Come and taste our Health Drink and redefine Awesomeness.', 'http://api.ziingo.globusapps.com/assets/productimages/juice.jpg', 60, 0, 0, 30, 1, '2015-12-23 00:00:00', 10),
(18, 2, 3, 1, 0, 1, 0, 'Soft Drink', 'Who said just beer is awesome? Come and taste our Soft Drink and redefine Awesomeness.', 'http://api.ziingo.globusapps.com/assets/softdrink.jpg', 50, 0, 0, 15, 1, '2015-12-21 00:00:00', 20),
(19, 8, 12, 1, 0, 3, 0, 'Kheer', 'sweety Kheer', 'http://ziingo.globusapps.com/themes/agent/skin/productimages/19/images21.jpg', 100, 0, 0, 0, 1, '0000-00-00 00:00:00', 0),
(20, 8, 12, 1, 0, 4, 0, 'South Indian thali', 'Tasty Thali', 'http://ziingo.globusapps.com/themes/agent/skin/productimages/20/index20.jpg', 100, 0, 0, 0, 1, '0000-00-00 00:00:00', 0),
(21, 8, 13, 1, 0, 2, 0, 'IndianSamosa', 'Hot and Spicy', 'http://ziingo.globusapps.com/themes/agent/skin/productimages/21/index7.jpg', 150, 0, 0, 0, 1, '0000-00-00 00:00:00', 0),
(22, 8, 14, 1, 0, 3, 0, 'NagpurSamosa', 'Famous Samosa', 'http://ziingo.globusapps.com/themes/agent/skin/productimages/22/index7.jpg', 200, 0, 0, 0, 1, '0000-00-00 00:00:00', 0),
(23, 8, 13, 1, 0, 6, 0, 'Chinese Noodles', 'Long and Non sticky Noodles', 'http://ziingo.globusapps.com/themes/agent/skin/productimages/23/index12.jpg', 200, 0, 0, 0, 1, '0000-00-00 00:00:00', 0),
(24, 8, 14, 1, 0, 8, 0, 'Italian Grilled Chicken', 'Outside peppery and inside softy italian chicken', 'http://localhost.ziingo.com/themes/agent/skin/productimages/24/index13.jpg', 150, 0, 0, 0, 0, '0000-00-00 00:00:00', 0),
(25, 8, 15, 1, 0, 7, 0, 'Thai Fish', 'Soupy and Spicy hot fish', 'http://ziingo.globusapps.com/themes/agent/skin/productimages/25/index11.jpg', 200, 0, 0, 0, 1, '0000-00-00 00:00:00', 0),
(26, 8, 15, 1, 0, 3, 0, 'Desi Gulab jamun', 'sugary and juicy jamun', 'http://ziingo.globusapps.com/themes/agent/skin/productimages/26/index15.jpg', 100, 0, 0, 0, 1, '0000-00-00 00:00:00', 0),
(27, 8, 16, 1, 0, 5, 0, 'indian Matka pulav', 'Hot and spicy pulav in 5mins', 'http://ziingo.globusapps.com/themes/agent/skin/productimages/27/index18.jpg', 200, 0, 0, 0, 1, '0000-00-00 00:00:00', 0),
(28, 8, 16, 1, 0, 1, 0, 'Elachi Chai', 'Tasy Elachi Lavange chai', 'http://ziingo.globusapps.com/themes/agent/skin/productimages/28/index22.jpg', 20, 0, 0, 0, 1, '0000-00-00 00:00:00', 0),
(29, 8, 17, 1, 0, 4, 0, 'Mushroom Veg Biryani', 'Healthy Grilled Mushrooms', 'http://ziingo.globusapps.com/themes/agent/skin/productimages/29/index6.jpg', 100, 0, 0, 0, 1, '0000-00-00 00:00:00', 0),
(30, 8, 17, 1, 0, 2, 0, 'Fruit salad', 'Tuty Fruity and honey salads', 'http://ziingo.globusapps.com/themes/agent/skin/productimages/30/index17.jpg', 150, 0, 0, 0, 1, '0000-00-00 00:00:00', 0),
(31, 8, 18, 1, 0, 4, 0, 'Butter Naans', 'Cheese and Buttery Naans', 'http://ziingo.globusapps.com/themes/agent/skin/productimages/31/index2.jpg', 100, 0, 0, 0, 1, '0000-00-00 00:00:00', 0),
(32, 8, 19, 1, 0, 3, 0, 'Fish rools', 'Soft and crispy Fish Rolls', 'http://ziingo.globusapps.com/themes/agent/skin/productimages/32/index14.jpg', 100, 0, 0, 0, 1, '0000-00-00 00:00:00', 0),
(33, 8, 20, 1, 0, 6, 0, 'Chinnese Noodles', 'plain and medium spicey noodles', 'http://ziingo.globusapps.com/themes/agent/skin/productimages/33/index12.jpg', 100, 0, 0, 0, 1, '0000-00-00 00:00:00', 0),
(34, 8, 20, 1, 0, 4, 0, 'plain mixed Biryani', 'palin non veg mixed biryani', 'http://ziingo.globusapps.com/themes/agent/skin/productimages/34/index1.jpg', 100, 0, 0, 0, 1, '0000-00-00 00:00:00', 0),
(35, 8, 21, 1, 0, 5, 0, 'panner Butter Masala', 'Tasty Veg panner Curry', 'http://ziingo.globusapps.com/themes/agent/skin/productimages/35/index.jpg', 100, 0, 0, 0, 1, '0000-00-00 00:00:00', 0),
(36, 8, 21, 1, 0, 2, 0, 'Pav baji', 'Hot and Spicy Vada Pav', 'http://ziingo.globusapps.com/themes/agent/skin/productimages/36/index9.jpg', 100, 0, 0, 0, 1, '0000-00-00 00:00:00', 0),
(37, 8, 22, 1, 0, 7, 0, 'Chicken Kababs', 'Crispy Chicken Kababs', 'http://ziingo.globusapps.com/themes/agent/skin/productimages/37/index5.jpg', 100, 0, 0, 0, 1, '0000-00-00 00:00:00', 0),
(38, 8, 22, 1, 0, 4, 0, 'Hyderabadi Dum Biryani', 'Finger Licking Tasty Hyderabadi dum Biryani', 'http://ziingo.globusapps.com/themes/agent/skin/productimages/38/index16.jpg', 100, 0, 0, 0, 1, '0000-00-00 00:00:00', 0),
(39, 0, 3, 0, 0, 0, 0, 'Aloo Parata', 'A very and Tasty paratas ..', '/assets/productimages/39/index2.jpg', 100, 10, 2, 30, 1, '0000-00-00 00:00:00', 10),
(40, 0, 4, 0, 0, 0, 0, 'Chowmien', 'Bachelors Favourite', '/assets/productimages/40/index12.jpg', 70, 0, 2, 30, 1, '0000-00-00 00:00:00', 10),
(41, 0, 4, 0, 0, 0, 0, 'Thali', 'Complete veg Thali', '/assets/productimages/41/index20.jpg', 100, 10, 2, 30, 1, '0000-00-00 00:00:00', 0),
(42, 8, 41, 0, 1, 4, 0, 'Palak panneer', 'very tasty and healthy palak panner ready to serve you and your family', '/assets/productimages/42/Palak-Paneer-Curry.jpg', 100, 10, 1, 30, 1, '0000-00-00 00:00:00', 0),
(43, 8, 41, 0, 1, 4, 0, 'Palak panneer', 'mixed palak and panner curry ready to serve', '/assets/productimages/43/Palak-Paneer-Curry.jpg', 100, 10, 1, 30, 1, '0000-00-00 00:00:00', 20),
(44, 8, 41, 1, 2, 0, 1, 'Samosa', 'hot and spicy samosa', '', 25, 0, 0, 20, 1, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `usermeta`
--

CREATE TABLE IF NOT EXISTS `usermeta` (
  `umeta_id` int(22) NOT NULL AUTO_INCREMENT,
  `user_id` int(22) NOT NULL,
  `first_name` varchar(60) NOT NULL,
  `last_name` varchar(60) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `city` varchar(20) NOT NULL,
  `state` varchar(20) NOT NULL,
  `country` varchar(20) NOT NULL,
  `address` text NOT NULL,
  PRIMARY KEY (`umeta_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `usermeta`
--

INSERT INTO `usermeta` (`umeta_id`, `user_id`, `first_name`, `last_name`, `phone`, `city`, `state`, `country`, `address`) VALUES
(1, 1, 'varanasi', 'priyanka', '9845152212', 'Visakhapatnam', 'Andhrapradesh', 'India', 'csdhcish'),
(2, 0, '', '', '', '', '', '', ''),
(3, 2, '', '', '', '', '', '', ''),
(4, 3, '', '', '', '', '', '', ''),
(5, 4, 'lakshmi', '', '', '', '', '', ''),
(6, 5, '', '', '', '', '', '', ''),
(7, 6, 'anu', 'kaurav', '45596', 'dggv', 'dhhb', 'gjb', 'dyjk'),
(8, 7, 'Amresh', 'Thakur', '9632587412', 'Bhopal', 'MadhyaPradesh', 'India', 'XXXXXXXXXXX'),
(9, 8, '', '', '', '', '', '', ''),
(10, 0, '', '', '', '', '', '', ''),
(11, 0, '', '', '', '', '', '', ''),
(12, 9, '', '', '', '', '', '', ''),
(13, 10, '', '', '', '', '', '', ''),
(14, 11, '', '', '', '', '', '', ''),
(15, 12, '', '', '', '', '', '', ''),
(16, 13, '', '', '', '', '', '', ''),
(17, 14, '', '', '', '', '', '', ''),
(18, 15, 'asd', 'asd', '4542', 'asdasd', 'asda', 'sd', 'asd'),
(19, 16, '', '', '', '', '', '', ''),
(20, 17, '', '', '', '', '', '', ''),
(21, 18, '', '', '', '', '', '', ''),
(22, 19, '', '', '', '', '', '', ''),
(23, 22, '', '', '', '', '', '', ''),
(24, 25, '', '', '', '', '', '', ''),
(25, 26, '', '', '', '', '', '', ''),
(26, 28, '', '', '', '', '', '', ''),
(27, 29, '', '', '', '', '', '', ''),
(28, 30, '', '', '', '', '', '', ''),
(29, 31, '', '', '', '', '', '', ''),
(30, 32, '', '', '', '', '', '', ''),
(31, 33, 'Ram', 'Kumar', '7412589632', 'Thirunavelli', 'TamilNadu', 'India', 'xxxxxxxxxxxxxxxxxx');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `uname` varchar(60) NOT NULL,
  `email` varchar(120) NOT NULL,
  `password` varchar(120) DEFAULT NULL,
  `fb_id` varchar(200) NOT NULL,
  `twt_id` varchar(200) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `role` tinyint(4) NOT NULL,
  `reg_date` datetime NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `uname`, `email`, `password`, `fb_id`, `twt_id`, `status`, `role`, `reg_date`) VALUES
(3, 'nargisparween', 'nargis@globussoft.com', NULL, '', '5555555555555', 1, 1, '2015-12-07 10:10:40'),
(4, 'priyanka', 'priyankav@globussoft.com', 'e9bc77de5fb5a8b8395dc3c0b908346e', '', '', 1, 1, '2015-12-07 11:47:22'),
(8, 'priyanka', 'priyankav@gmail,com', '8c1596b81fd34fc20b3817d1d3a111e4', '', '', 1, 1, '2015-12-08 13:27:21'),
(9, 'priyanka', 'priyankav@globussotf.com', '8c1596b81fd34fc20b3817d1d3a111e4', '', '', 1, 1, '2015-12-10 13:30:15'),
(13, 'priyanka', 'sasi@globussoft.com', '8c1596b81fd34fc20b3817d1d3a111e4', '', '', 1, 1, '2015-12-12 06:52:08'),
(14, 'faizi', 'faizisharafat@globussoft.com', '92f696563b929aad44b829e41eccf932', '', '', 0, 1, '2015-12-12 06:56:56'),
(16, 'halo', 'halo@gmail.com', '57f842286171094855e51fc3a541c1e2', '', '', 1, 1, '2016-01-14 10:12:35'),
(17, 'iPhone', 'iphone@gmail.com', '912ec803b2ce49e4a541068d495ab570', '', '', 1, 1, '2016-01-14 10:21:56'),
(20, 'kamala', 'kamala@globussoft.com', '906e6c8f85fb1ecb6daeb5a1ba63ff58f1d7aaaf', '', '', 1, 2, '2016-01-14 13:53:14'),
(21, 'globussoft', 'globus@globussoft.com', '6035dc34d4acd0048977170eba5b87089887c281', '', '', 1, 2, '2016-01-14 14:25:55'),
(22, 'Man', 'man@gmail.com', '912ec803b2ce49e4a541068d495ab570', '', '', 1, 1, '2016-01-15 14:28:07'),
(23, 'priya', 'priya@gmail.com', 'bbf2852373efeb85e1d05047480375a1dc0ec45a', '', '', 1, 1, '2016-01-16 17:57:00'),
(24, 'globus', 'ziingo@globussoft.com', '63e59f8b96ea2b8bcda7ebe4e575c52444d149f4', '', '', 1, 2, '2016-01-19 05:54:35'),
(25, 'great', 'great@gmail.com', 'acaa16770db76c1ffb9cee51c3cabfcf', '', '', 1, 1, '2016-01-19 10:04:09'),
(31, 'mac', 'mac@gmail.com', 'ee99de87efdb231cbd1a80139a88cfc3', '', '', 1, 1, '2016-01-20 10:00:21'),
(32, 'Goodman', 'goodman@gmail.com', '4d7bc926f4494e8d40fdefcdacd8a018', '', '', 1, 1, '2016-01-20 11:29:25'),
(33, 'Ram', 'Ramkumar@globussoft.com', NULL, '', '', 0, 1, '0000-00-00 00:00:00'),
(35, 'madhuri', 'madhuri@gmail.com', '15908a3cd1b606050a8a1b07a19ac2f171441cbc', '', '', 1, 1, '2016-02-02 08:32:06'),
(36, 'swathi', 'swathi@gmail.com', '63e59f8b96ea2b8bcda7ebe4e575c52444d149f4', '', '', 1, 1, '2016-02-02 08:42:39'),
(37, 'kalyani', 'kalyani@gmail.com', '63e59f8b96ea2b8bcda7ebe4e575c52444d149f4', '', '', 1, 1, '2016-02-02 09:02:53'),
(38, 'geetha', 'geetha@gmail.com', '63e59f8b96ea2b8bcda7ebe4e575c52444d149f4', '', '', 0, 1, '2016-02-02 09:04:25'),
(39, 'sowji', 'sowjanya@globussoft.com', '63e59f8b96ea2b8bcda7ebe4e575c52444d149f4', '', '', 1, 1, '2016-02-02 09:07:41'),
(40, 'puja', 'puja@glb.com', '63e59f8b96ea2b8bcda7ebe4e575c52444d149f4', '', '', 1, 1, '2016-02-02 09:11:23');

-- --------------------------------------------------------

--
-- Table structure for table `user_delivery_addr`
--

CREATE TABLE IF NOT EXISTS `user_delivery_addr` (
  `user_del_addr_id` int(22) NOT NULL AUTO_INCREMENT,
  `ordered_user_id` int(22) NOT NULL,
  `first_name` varchar(11) NOT NULL,
  `last_name` varchar(11) NOT NULL,
  `city` varchar(60) NOT NULL,
  `Contact_address` varchar(250) NOT NULL,
  `Contact_email` varchar(11) NOT NULL,
  `Contact_no` varchar(20) NOT NULL,
  `delivery_addr` text NOT NULL,
  `order_id` int(30) NOT NULL,
  `delivery_time` int(11) NOT NULL COMMENT 'time  will be consider as minutes',
  PRIMARY KEY (`user_del_addr_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `user_delivery_addr`
--

INSERT INTO `user_delivery_addr` (`user_del_addr_id`, `ordered_user_id`, `first_name`, `last_name`, `city`, `Contact_address`, `Contact_email`, `Contact_no`, `delivery_addr`, `order_id`, `delivery_time`) VALUES
(1, 4, '', '', 'telangana', '', '', '', 'bhimavaram', 6, 2015),
(2, 9, '', '', 'hyderabad', '', '', '', 'palakol', 11, 2015),
(3, 0, 'varanasi', 'priyanka', 'hyderabad', 'xxxxxxxxxxxxxxxxxxxxxxxxxxxx', 'priyankav@g', '7412589632', '{"house-no\\/name":"203","localityaddress":"padmavathiresidency","nearby":"flyover bridge"}', 178, 0),
(4, 0, 'varanasi', 'priyanka', 'hyderabad', 'xxxxxxxxxxxxxxxxxxxxxxxxxxxx', 'priyankav@g', '7412589632', '{"house-no\\/name":"203","localityaddress":"padmavathiresidency","nearby":"flyover bridge"}', 178, 0),
(5, 0, 'varanasi', 'priyanka', 'hyderabad', 'xxxxxxxxxxxxxxxxxxxxxxxxxxxx', 'priyankav@g', '7412589632', '{"house-no\\/name":"203","localityaddress":"padmavathiresidency","nearby":"flyover bridge"}', 179, 0),
(6, 0, 'varanasi', 'priyanka', 'hyderabad', 'xxxxxxxxxxxxxxxxxxxxxxxxxxxx', 'priyankav@g', '7412589632', '{"house-no\\/name":"203","localityaddress":"padmavathiresidency","nearby":"flyover bridge"}', 180, 0),
(7, 0, 'varanasi', 'priyanka', 'hyderabad', 'xxxxxxxxxxxxxxxxxxxxxxxxxxxx', 'priyankav@g', '7412589632', '{"house-no\\/name":"203","localityaddress":"padmavathiresidency","nearby":"flyover bridge"}', 181, 0),
(8, 0, 'varanasi', 'priyanka', 'hyderabad', 'xxxxxxxxxxxxxxxxxxxxxxxxxxxx', 'priyankav@g', '7412589632', '{"house-no\\/name":"203","localityaddress":"padmavathiresidency","nearby":"flyover bridge"}', 182, 0),
(9, 0, 'varanasi', 'priyanka', 'hyderabad', 'xxxxxxxxxxxxxxxxxxxxxxxxxxxx', 'priyankav@g', '7412589632', '{"house-no\\/name":"203","localityaddress":"padmavathiresidency","nearby":"flyover bridge"}', 183, 0),
(10, 0, 'varanasi', 'priyanka', 'hyderabad', 'xxxxxxxxxxxxxxxxxxxxxxxxxxxx', 'priyankav@g', '7412589632', '{"house-no\\/name":"203","localityaddress":"padmavathiresidency","nearby":"flyover bridge"}', 184, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_transactions`
--

CREATE TABLE IF NOT EXISTS `user_transactions` (
  `user_tx_id` int(30) NOT NULL AUTO_INCREMENT,
  `user_id` int(22) NOT NULL,
  `order_id` int(22) NOT NULL,
  `tx_type` tinyint(4) NOT NULL COMMENT '1=COD, 2=paypal',
  `tx_amount` float NOT NULL,
  `tx_code` varchar(30) NOT NULL,
  `tx_date` datetime NOT NULL,
  `tx_status` tinyint(4) NOT NULL COMMENT '(1=success,2=pending,3=failed,4=cancel)',
  PRIMARY KEY (`user_tx_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='only users order transactions' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user_transactions`
--

INSERT INTO `user_transactions` (`user_tx_id`, `user_id`, `order_id`, `tx_type`, `tx_amount`, `tx_code`, `tx_date`, `tx_status`) VALUES
(1, 9, 1, 2, 200, '741852236cdde585', '2015-12-09 00:00:00', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
orders