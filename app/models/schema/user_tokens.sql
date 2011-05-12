-- phpMyAdmin SQL Dump
-- version 3.3.10
-- http://www.phpmyadmin.net
--
-- Host: mysql.prolegic.com
-- Generation Time: Apr 09, 2011 at 09:43 AM
-- Server version: 5.1.53
-- PHP Version: 5.2.15

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `Your Database!`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_tokens`
--

CREATE TABLE IF NOT EXISTS `user_tokens` (
  `id` INT(20) NOT NULL AUTO_INCREMENT,
  `token` CHAR(32) NOT NULL,
  `expiration` TIMESTAMP DEFAULT NULL,
  `refresh` CHAR(32) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;
