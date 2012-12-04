-- phpMyAdmin SQL Dump
-- version 3.4.5deb1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2012 年 12 月 04 日 23:03
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
-- 表的结构 `zx_admin`
--

CREATE TABLE IF NOT EXISTS `zx_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` char(20) NOT NULL,
  `password` char(200) NOT NULL,
  `truenaem` char(20) NOT NULL,
  `department` char(200) NOT NULL,
  `phone` char(20) NOT NULL,
  `email` char(100) NOT NULL,
  `power` int(11) NOT NULL,
  `ctime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cuid` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `zx_articles`
--

CREATE TABLE IF NOT EXISTS `zx_articles` (
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
-- 表的结构 `zx_article_groups`
--

CREATE TABLE IF NOT EXISTS `zx_article_groups` (
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
-- 表的结构 `zx_cert_file_type`
--

CREATE TABLE IF NOT EXISTS `zx_cert_file_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` char(50) NOT NULL,
  `cuid` int(11) NOT NULL,
  `ctime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `zx_code`
--

CREATE TABLE IF NOT EXISTS `zx_code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zx_code` char(20) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `zx_industry_type`
--

CREATE TABLE IF NOT EXISTS `zx_industry_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `industry_name` char(100) NOT NULL,
  `cuid` int(11) NOT NULL,
  `ctime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `zx_medium_cert_base`
--

CREATE TABLE IF NOT EXISTS `zx_medium_cert_base` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `com_name` char(200) NOT NULL,
  `com_nature` char(200) NOT NULL,
  `type` char(20) NOT NULL,
  `industry_id` int(11) NOT NULL,
  `zipcode` int(11) NOT NULL,
  `place` char(200) NOT NULL,
  `cert_begin` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cert_end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `audit` int(11) NOT NULL DEFAULT '0',
  `audit_id` int(11) NOT NULL DEFAULT '0',
  `cuid` int(11) NOT NULL,
  `ctime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `zx_medium_cert_content`
--

CREATE TABLE IF NOT EXISTS `zx_medium_cert_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `title` char(200) NOT NULL,
  `content` text NOT NULL,
  `audit` int(11) NOT NULL DEFAULT '0',
  `audit_id` int(11) NOT NULL DEFAULT '0',
  `cuid` int(11) NOT NULL,
  `ctime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `zx_medium_cert_file`
--

CREATE TABLE IF NOT EXISTS `zx_medium_cert_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `file_type_id` int(11) NOT NULL,
  `file_name` char(50) NOT NULL,
  `audit` int(11) NOT NULL DEFAULT '0',
  `audit_id` int(11) NOT NULL DEFAULT '0',
  `cuid` int(11) NOT NULL,
  `ctime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `zx_pictures`
--

CREATE TABLE IF NOT EXISTS `zx_pictures` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `picname` char(100) NOT NULL,
  `describle` char(200) NOT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `zx_space_articles`
--

CREATE TABLE IF NOT EXISTS `zx_space_articles` (
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

-- --------------------------------------------------------

--
-- 表的结构 `zx_space_article_groups`
--

CREATE TABLE IF NOT EXISTS `zx_space_article_groups` (
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
-- 表的结构 `zx_talent_cert_base`
--

CREATE TABLE IF NOT EXISTS `zx_talent_cert_base` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cert_name` char(20) NOT NULL,
  `sex` int(11) NOT NULL DEFAULT '0',
  `nation` char(20) NOT NULL,
  `personid` char(20) NOT NULL,
  `birth_place` char(200) NOT NULL,
  `live_place` char(200) NOT NULL,
  `cert_begin` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cert_end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `audit` int(11) NOT NULL DEFAULT '0',
  `audit_id` int(11) NOT NULL DEFAULT '0',
  `cuid` int(11) NOT NULL,
  `ctime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `zx_talent_cert_content`
--

CREATE TABLE IF NOT EXISTS `zx_talent_cert_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `title` char(200) NOT NULL,
  `content` text NOT NULL,
  `audit` int(11) NOT NULL DEFAULT '0',
  `audit_id` int(11) NOT NULL DEFAULT '0',
  `cuid` int(11) NOT NULL,
  `ctime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `zx_talent_cert_file`
--

CREATE TABLE IF NOT EXISTS `zx_talent_cert_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `file_type_id` int(11) NOT NULL,
  `file_name` char(50) NOT NULL,
  `audit` int(11) NOT NULL DEFAULT '0',
  `audit_id` int(11) NOT NULL DEFAULT '0',
  `cuid` int(11) NOT NULL,
  `ctime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `zx_topic_cert_base`
--

CREATE TABLE IF NOT EXISTS `zx_topic_cert_base` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `com_name` char(200) NOT NULL,
  `com_nature` char(200) NOT NULL,
  `type` char(20) NOT NULL,
  `industry_id` int(11) NOT NULL,
  `zipcode` int(11) NOT NULL,
  `place` char(200) NOT NULL,
  `cert_begin` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cert_end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `audit` int(11) NOT NULL DEFAULT '0',
  `audit_id` int(11) NOT NULL DEFAULT '0',
  `cuid` int(11) NOT NULL,
  `ctime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `zx_topic_cert_content`
--

CREATE TABLE IF NOT EXISTS `zx_topic_cert_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `title` char(200) NOT NULL,
  `content` text NOT NULL,
  `audit` int(11) NOT NULL DEFAULT '0',
  `audit_id` int(11) NOT NULL DEFAULT '0',
  `cuid` int(11) NOT NULL,
  `ctime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `zx_topic_cert_file`
--

CREATE TABLE IF NOT EXISTS `zx_topic_cert_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `file_type_id` int(11) NOT NULL,
  `file_name` char(50) NOT NULL,
  `audit` int(11) NOT NULL DEFAULT '0',
  `audit_id` int(11) NOT NULL DEFAULT '0',
  `cuid` int(11) NOT NULL,
  `ctime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `zx_user_base`
--

CREATE TABLE IF NOT EXISTS `zx_user_base` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zx_code` char(20) NOT NULL,
  `sq_code` char(20) NOT NULL,
  `username` char(20) NOT NULL,
  `password` char(200) NOT NULL,
  `truename` char(20) NOT NULL,
  `position` char(200) NOT NULL,
  `phone` char(20) NOT NULL,
  `email` char(100) NOT NULL,
  `space_id` int(11) NOT NULL,
  `audit` int(11) NOT NULL DEFAULT '0',
  `audit_id` int(11) NOT NULL DEFAULT '0',
  `cuid` int(11) NOT NULL,
  `ctime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
