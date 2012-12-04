-- phpMyAdmin SQL Dump
-- version 3.4.5deb1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2012 年 12 月 04 日 20:38
-- 服务器版本: 5.1.66
-- PHP 版本: 5.3.6-13ubuntu3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `zxpt`
--

-- --------------------------------------------------------

--
-- 表的结构 `jx_articlegroups`
--

CREATE TABLE IF NOT EXISTS `jx_articlegroups` (
  `gid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `group_name` char(50) NOT NULL,
  `goup_url` char(50) NOT NULL,
  `group_sumarry` char(200) NOT NULL,
  `groupfather_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`gid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `jx_articles`
--

CREATE TABLE IF NOT EXISTS `jx_articles` (
  `aid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `username` char(30) NOT NULL,
  `title` char(200) NOT NULL,
  `content` text NOT NULL,
  `groupid` int(11) NOT NULL,
  `ctime` int(11) DEFAULT NULL,
  `audit` int(11) NOT NULL DEFAULT '0',
  `audit_id` int(11) NOT NULL DEFAULT '0',
  `viewtimes` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`aid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `jx_pictures`
--

CREATE TABLE IF NOT EXISTS `jx_pictures` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `picname` char(100) NOT NULL,
  `describle` char(200) NOT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `jx_spacearticlegroups`
--

CREATE TABLE IF NOT EXISTS `jx_spacearticlegroups` (
  `space_gid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `space_group_name` char(50) NOT NULL,
  `space_goup_url` char(50) NOT NULL,
  `space_group_sumarry` char(200) NOT NULL,
  `space_groupfather_id` int(11) NOT NULL,
  `space_status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`space_gid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `jx_spacearticles`
--

CREATE TABLE IF NOT EXISTS `jx_spacearticles` (
  `space_aid` int(11) NOT NULL AUTO_INCREMENT,
  `space_uid` int(11) NOT NULL,
  `space_username` char(30) NOT NULL,
  `space_title` char(200) NOT NULL,
  `space_content` text NOT NULL,
  `space_groupid` int(11) NOT NULL,
  `space_ctime` int(11) DEFAULT NULL,
  `space_audit` int(11) NOT NULL DEFAULT '0',
  `space_audit_id` int(11) NOT NULL DEFAULT '0',
  `space_viewtimes` int(11) NOT NULL DEFAULT '0',
  `space_status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`space_aid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
