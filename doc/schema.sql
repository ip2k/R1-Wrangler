-- phpMyAdmin SQL Dump
-- version 2.11.9.4
-- http://www.phpmyadmin.net
--
-- Host: 
-- Generation Time: Mar 17, 2011 at 04:29 AM
-- Server version: 5.0.77
-- PHP Version: 5.2.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `iptwokco_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `host`
--

CREATE TABLE IF NOT EXISTS `host` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `hostID` tinytext NOT NULL,
  `hostName` tinytext NOT NULL,
  `hostType` tinyint(1) NOT NULL,
  `volumeID` tinytext NOT NULL,
  `cdp_server_id` int(3) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  FULLTEXT KEY `hostName` (`hostName`),
  FULLTEXT KEY `volumeID` (`volumeID`),
  FULLTEXT KEY `hostID` (`hostID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `host`
--


-- --------------------------------------------------------

--
-- Table structure for table `host_log`
--

CREATE TABLE IF NOT EXISTS `host_log` (
  `id` bigint(10) unsigned NOT NULL auto_increment,
  `host_id` tinytext NOT NULL,
  `poll_id` int(10) unsigned NOT NULL,
  `isEnabled` tinyint(1) unsigned NOT NULL,
  `isControlPanelModuleEnabled` tinyint(1) unsigned NOT NULL,
  `quota` bigint(3) NOT NULL,
  `diskUsage` bigint(3) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `poll_id` (`poll_id`,`quota`,`diskUsage`),
  FULLTEXT KEY `host_id` (`host_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `host_log`
--


-- --------------------------------------------------------

--
-- Table structure for table `host_log_poll`
--

CREATE TABLE IF NOT EXISTS `host_log_poll` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `poll_run_datetime` int(3) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `poll_run_datetime` (`poll_run_datetime`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `server` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `cdp_hostname` tinytext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `host_log_poll`
--

