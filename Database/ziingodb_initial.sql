-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2015 at 01:31 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ziingodb`
--

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE IF NOT EXISTS `agents` (
  `agent_id` int(22) NOT NULL AUTO_INCREMENT,
  `loginname` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `email` varchar(60) NOT NULL,
  `city` varchar(60) NOT NULL,
  `address` text NOT NULL,
  `reg_date` datetime NOT NULL,
  `status` tinyint(4) NOT NULL,
  `membership` tinyint(4) NOT NULL,
  PRIMARY KEY (`agent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `hotel_details`
--

CREATE TABLE IF NOT EXISTS `hotel_details` (
  `id` int(22) NOT NULL AUTO_INCREMENT,
  `agent_id` int(22) DEFAULT NULL,
  `owner_fname` varchar(30) NOT NULL,
  `owner_lname` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL,
  `state` varchar(30) NOT NULL,
  `country` varchar(30) NOT NULL,
  `address` text NOT NULL,
  `primary_phone` varchar(30) NOT NULL,
  `secondary_phone` varchar(30) NOT NULL,
  `hotel_name` varchar(60) NOT NULL,
  `open_time` varchar(20) NOT NULL,
  `closing_time` varchar(20) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `notice` text NOT NULL COMMENT 'special notfication for users , like sunday closed , etc.',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='one agent can have multiple hotels' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `menu_category`
--

CREATE TABLE IF NOT EXISTS `menu_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(60) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `last_update` datetime NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(22) NOT NULL AUTO_INCREMENT,
  `user_id` int(22) NOT NULL,
  `total_amount` float NOT NULL,
  `delivery_charge` float NOT NULL,
  `service_tax` float NOT NULL,
  `order_date` datetime NOT NULL,
  `order_status` tinyint(4) NOT NULL COMMENT '1=in process, 2=delivered , 3=cancelled',
  `pay_status` tinyint(4) NOT NULL COMMENT '0=pending, 1=complete , 2=failed, 3=COD',
  `pay_type` tinyint(4) NOT NULL COMMENT '1=COD, 2=paypal',
  `delivery_status` tinyint(4) NOT NULL COMMENT '0=pending, 1=complete , 2=return/cancel, 3=unable to reach',
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `order_products`
--

CREATE TABLE IF NOT EXISTS `order_products` (
  `order_product_id` int(22) NOT NULL AUTO_INCREMENT,
  `order_id` int(22) DEFAULT NULL,
  `product_id` int(22) NOT NULL,
  `product_cost` float NOT NULL COMMENT 'unit cost, i.e. cost of single item',
  `product_discount` float NOT NULL,
  `pay_amount` float NOT NULL,
  `quantity` int(5) NOT NULL DEFAULT '1',
  `coupon_id` int(11) NOT NULL,
  `hotel_id` int(22) NOT NULL,
  PRIMARY KEY (`order_product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(30) NOT NULL AUTO_INCREMENT,
  `agent_id` int(22) NOT NULL,
  `item_type` tinyint(4) NOT NULL COMMENT '1=hotel items, 2=grocerry items',
  `category_id` int(22) NOT NULL,
  `name` varchar(120) NOT NULL,
  `description` text NOT NULL,
  `imagelink` text NOT NULL,
  `cost` float NOT NULL,
  `delivery_time` int(11) NOT NULL COMMENT '1= 1mins, integer will be counted as minutes',
  `status` tinyint(4) NOT NULL,
  `added_date` datetime NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `uname` varchar(60) NOT NULL,
  `email` varchar(120) NOT NULL,
  `password` varchar(120) NOT NULL,
  `fb_id` varchar(200) NOT NULL,
  `twt_id` varchar(200) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `role` tinyint(4) NOT NULL,
  `reg_date` datetime NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_delivery_addr`
--

CREATE TABLE IF NOT EXISTS `user_delivery_addr` (
  `user_del_addr_id` int(22) NOT NULL AUTO_INCREMENT,
  `user_id` int(22) NOT NULL,
  `city` varchar(60) NOT NULL,
  `state` varchar(60) NOT NULL,
  `country` varchar(60) NOT NULL,
  `landmark` varchar(200) NOT NULL,
  `delivery_addr` text NOT NULL,
  `order_id` int(30) NOT NULL,
  `delivery_time` datetime NOT NULL,
  PRIMARY KEY (`user_del_addr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `tx_status` tinyint(4) NOT NULL,
  PRIMARY KEY (`user_tx_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='only users order transactions' AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
