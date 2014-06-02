-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 20. Mai 2014 um 17:14
-- Server Version: 5.5.32
-- PHP-Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `apxcore003`
--
CREATE DATABASE IF NOT EXISTS `apxcore003` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `apxcore003`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `langitem`
--

CREATE TABLE IF NOT EXISTS `langitem` (
  `lait_lang` varchar(10) NOT NULL,
  `lait_code` varchar(45) NOT NULL,
  `lait_text` text NOT NULL,
  PRIMARY KEY (`lait_lang`,`lait_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `langitem`
--

INSERT INTO `langitem` (`lait_lang`, `lait_code`, `lait_text`) VALUES
('EN', 'ACP_NAVBAR_NEW', 'New'),
('EN', 'ACP_NAVBAR_NEW_BLOGENTRY', 'Blogeintrag'),
('EN', 'ACP_NAVBAR_NEW_GALLERY', 'Gallery'),
('EN', 'ACP_NAVBAR_NEW_IMAGE', 'Artwork'),
('EN', 'ACP_NAVBAR_NEW_PAGE', 'Seite'),
('EN', 'ACP_NAVBAR_SETTINGS', 'Settings'),
('EN', 'ACP_NAVBAR_STYLE', 'Style'),
('EN', 'ACP_SIDEBAR_BLOG', 'Blog'),
('EN', 'ACP_SIDEBAR_GALLERY', 'Gallery'),
('EN', 'ACP_SIDEBAR_PAGES', 'Pages'),
('EN', 'ERR_404', '<b>404 Error:</b> Page could not be found: {0}'),
('EN', 'ERR_ACP_404', '<b>Error:</b> The requested Page could not be found!'),
('EN', 'ERR_ACP_F_NOT_FOUND', '<b>Error:</b> Page-File not found: {0}'),
('EN', 'ERR_CC_NOT_FOUND', '<b>Error:</b> Classfile exists, but class was not found: {0}'),
('EN', 'ERR_CF_NOT_FOUND', '<b>Error:</b> Classfile not found: {0}'),
('EN', 'ERR_CONSTANT_NOT_DEFINED', '<b>Error:</b> Constant ''{0}'' is not defined.'),
('EN', 'ERR_DB_PDO_EX', '<b>Error:</b> Database-Exception:<br/>{all}'),
('EN', 'ERR_DEFAULT', '<b>Unknown Error:</b><br>Data: {all}'),
('EN', 'ERR_MENUAREA_NOT_FOUND', '<b>Error:</b> Menuarea #{0} is not defined.'),
('EN', 'ERR_MISSING_PARAMETER', '<b>Error:</b> Smarty-Function ''{0}'' is missing parameter ''{1}'''),
('EN', 'ERR_MODULE_WRONG_TYPE', '<b>Internal Error:</b> Expected Moduleobject of type ''{0}'', received ''{1}''.'),
('EN', 'ERR_NO_LANG', '<b>Error:</b> No Language chosen.'),
('EN', 'ERR_NO_MENU_FOUND', '<b>Error:</b> No Menu was found for MenuArea #{0}'),
('EN', 'ERR_NO_WIDGETCOLLECTION_FOUND', '<b>Error:</b> No WidgetCollection was found for WidgetArea #{0}'),
('EN', 'ERR_PAGE_NOT_LOADED', '<b>Internal Error:</b> Page is not loaded yet.'),
('EN', 'ERR_PAGE_NOT_SUPPORTED', '<b>Error:</b> PageType ''{0}'' is not supported by Style ''{1}''.'),
('EN', 'ERR_PROPERTY_NOT_FOUND', '<b>Internal Error:</b> Property ''{2}'' of {0}-Object #''{1}'' wasn''t loaded or doesn''t exist.'),
('EN', 'ERR_SITE_NOT_LOADED', '<b>Internal Error:</b> Site is not loaded yet.'),
('EN', 'ERR_SN_NOT_RECEIVED', '<b>Error:</b> Did not receive a statename.'),
('EN', 'ERR_STYLE_LOADING_FAILED', '<b>Internal Error:</b> Failed loading Style-Object of Site #{0}'),
('EN', 'ERR_STYLE_NOT_LOADED', '<b>Internal Error:</b> Style is not loaded yet.'),
('EN', 'ERR_SYSTEM_PROPERTY_NOT_FOUND', '<b>Error:</b> SystemProperty ''{0}'' could not be found!'),
('EN', 'ERR_VAR_WRONG_TYPE', '<b>Internal Error:</b> The type of ''{0}'' should be ''{1}'', but is ''{2}''.'),
('EN', 'ERR_WIDGETAREA_NOT_FOUND', '<b>Error:</b> Widgetarea #{0} is not defined.'),
('EN', 'ERR_WIDGET_NOT_FOUND', '<b>Error:</b> Widget #{0} could not be found.');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `language`
--

CREATE TABLE IF NOT EXISTS `language` (
  `lang_shortcut` varchar(10) NOT NULL,
  `lang_title` varchar(45) NOT NULL,
  PRIMARY KEY (`lang_shortcut`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `language`
--

INSERT INTO `language` (`lang_shortcut`, `lang_title`) VALUES
('EN', 'English');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `menu_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menu_areanr` int(11) NOT NULL,
  `menu_automatic` tinyint(1) NOT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `menu`
--

INSERT INTO `menu` (`menu_id`, `menu_areanr`, `menu_automatic`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `menuitem`
--

CREATE TABLE IF NOT EXISTS `menuitem` (
  `meit_itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `meit_menu` int(10) unsigned NOT NULL,
  `meit_order` int(11) NOT NULL,
  `meit_submenu` int(10) unsigned DEFAULT NULL,
  `meit_ajaxlink` tinyint(1) NOT NULL,
  `meit_title` varchar(45) NOT NULL,
  `meit_url` varchar(1024) NOT NULL,
  PRIMARY KEY (`meit_itemid`),
  KEY `fk_MenuItem_Menu2_idx` (`meit_submenu`),
  KEY `fk_MenuItem_Menu1` (`meit_menu`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `page`
--

CREATE TABLE IF NOT EXISTS `page` (
  `p_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `p_order` int(11) NOT NULL,
  `p_admintitle` varchar(255) NOT NULL,
  `p_displaytitle` varchar(255) NOT NULL,
  `p_parent` int(10) unsigned DEFAULT NULL,
  `p_type` int(10) unsigned NOT NULL,
  PRIMARY KEY (`p_id`),
  KEY `fk_Page_PageType1_idx` (`p_type`),
  KEY `fk_Page_Page1_idx` (`p_parent`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `page`
--

INSERT INTO `page` (`p_id`, `p_order`, `p_admintitle`, `p_displaytitle`, `p_parent`, `p_type`) VALUES
(1, 1, 'Start', 'Start', NULL, 1),
(2, 2, 'About', 'About', NULL, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pageproperty`
--

CREATE TABLE IF NOT EXISTS `pageproperty` (
  `pp_page` int(10) unsigned NOT NULL,
  `pp_key` varchar(45) NOT NULL,
  `pp_value` text,
  `pp_cssAvailable` tinyint(1) NOT NULL,
  PRIMARY KEY (`pp_page`,`pp_key`),
  KEY `fk_PageProperty_Page1_idx` (`pp_page`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `pageproperty`
--

INSERT INTO `pageproperty` (`pp_page`, `pp_key`, `pp_value`, `pp_cssAvailable`) VALUES
(1, 'html', '<p>\n<h1>Willkommen im Portfolio!</h1>\nBlablablablabla blibliblobloblu Schwabbeldiewabbeldiewuh!\n</p>', 0),
(1, 'smarty', '1', 0),
(2, 'html', '<p><h1>Über diese Seite</h1>\nWidget-Test:<br>\n{apx_widget widgetid="2"}<br><br>\nUm diese Seite mit einem Bild zu beschreiben:<br>\n<img src="http://i.imgur.com/6FUzuNZ.gif" alt="UAAH">\n</p>', 0),
(2, 'smarty', '1', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pagetype`
--

CREATE TABLE IF NOT EXISTS `pagetype` (
  `pt_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pt_configname` varchar(45) NOT NULL,
  `pt_title` varchar(255) NOT NULL,
  `pt_description` text NOT NULL,
  PRIMARY KEY (`pt_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `pagetype`
--

INSERT INTO `pagetype` (`pt_id`, `pt_configname`, `pt_title`, `pt_description`) VALUES
(1, 'custompage', 'CustomPage', 'Custom Content');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `state`
--

CREATE TABLE IF NOT EXISTS `state` (
  `sta_slug` varchar(500) NOT NULL,
  `sta_title` varchar(255) NOT NULL,
  `sta_extra` text NOT NULL,
  `sta_page` int(10) unsigned NOT NULL,
  PRIMARY KEY (`sta_slug`),
  KEY `fk_State_Page1_idx` (`sta_page`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `state`
--

INSERT INTO `state` (`sta_slug`, `sta_title`, `sta_extra`, `sta_page`) VALUES
('about', 'About', '', 2),
('start', 'Start', '', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `styleobject`
--

CREATE TABLE IF NOT EXISTS `styleobject` (
  `so_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `so_theme` int(10) unsigned NOT NULL,
  `so_name` varchar(200) NOT NULL,
  PRIMARY KEY (`so_id`),
  KEY `fk_StyleObject_StyleTheme1_idx` (`so_theme`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `styleobject`
--

INSERT INTO `styleobject` (`so_id`, `so_theme`, `so_name`) VALUES
(1, 1, 'NoStyle_1');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `styleproperty`
--

CREATE TABLE IF NOT EXISTS `styleproperty` (
  `stp_object` int(10) unsigned NOT NULL,
  `stp_key` varchar(45) NOT NULL,
  `stp_value` text NOT NULL,
  `stp_cssAvailable` tinyint(1) NOT NULL,
  PRIMARY KEY (`stp_object`,`stp_key`),
  KEY `fk_StyleProperty_StyleObject1_idx` (`stp_object`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `styleproperty`
--

INSERT INTO `styleproperty` (`stp_object`, `stp_key`, `stp_value`, `stp_cssAvailable`) VALUES
(1, 'body', '<div id="wrapper">\n<header>{apx_styleproperty key="headtext"}</header>\n<nav>{apx_menu areaid="1" onerror="htmlcomment"}</nav>\n<section id="content">{apx_page}</section>\n<footer>\n{apx_widgetcollection areaid="1" onerror="htmlcomment"}\n<br>\n{apx_styleproperty key="footertext"}\n</footer>\n</div>', 0),
(1, 'footertext', 'Artphox (c), 2014', 0),
(1, 'head', '', 0),
(1, 'headtext', 'Simons Portfolio', 0),
(1, 'timestamp', '1397391615', 0),
(1, 'useSmarty', '1', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `styletheme`
--

CREATE TABLE IF NOT EXISTS `styletheme` (
  `st_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `st_title` varchar(255) NOT NULL,
  `st_description` text NOT NULL,
  `st_classname` varchar(45) NOT NULL,
  PRIMARY KEY (`st_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `styletheme`
--

INSERT INTO `styletheme` (`st_id`, `st_title`, `st_description`, `st_classname`) VALUES
(1, 'NoStyle', 'Custom HTML- and CSS-Code', 'NoStyle');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `systemproperty`
--

CREATE TABLE IF NOT EXISTS `systemproperty` (
  `sp_key` varchar(45) NOT NULL,
  `sp_value` text,
  PRIMARY KEY (`sp_key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `systemproperty`
--

INSERT INTO `systemproperty` (`sp_key`, `sp_value`) VALUES
('Adaption', '1'),
('CurrentStyle', '1'),
('DefaultPage', '1'),
('Language', 'EN'),
('SiteTitle', 'Simons Portfolio');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `widgetcollection`
--

CREATE TABLE IF NOT EXISTS `widgetcollection` (
  `wc_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wc_areanr` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`wc_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `widgetcollection`
--

INSERT INTO `widgetcollection` (`wc_id`, `wc_areanr`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `widgetcollectionitem`
--

CREATE TABLE IF NOT EXISTS `widgetcollectionitem` (
  `wci_itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wci_collection` int(10) unsigned NOT NULL,
  `wci_order` int(11) NOT NULL,
  `wci_widgetid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`wci_itemid`),
  KEY `fk_WidgetCollectionItem_WidgetObject1_idx` (`wci_widgetid`),
  KEY `fk_WidgetCollectionItem_WidgetCollection1` (`wci_collection`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `widgetcollectionitem`
--

INSERT INTO `widgetcollectionitem` (`wci_itemid`, `wci_collection`, `wci_order`, `wci_widgetid`) VALUES
(1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `widgetobject`
--

CREATE TABLE IF NOT EXISTS `widgetobject` (
  `wop_objectid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wop_type` int(10) unsigned NOT NULL,
  PRIMARY KEY (`wop_objectid`),
  KEY `fk_WidgetObject_WidgetType1_idx` (`wop_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `widgetobject`
--

INSERT INTO `widgetobject` (`wop_objectid`, `wop_type`) VALUES
(1, 1),
(2, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `widgetobjectproperty`
--

CREATE TABLE IF NOT EXISTS `widgetobjectproperty` (
  `wop_object` int(10) unsigned NOT NULL,
  `wop_key` varchar(45) NOT NULL,
  `wop_value` text,
  `wop_cssAvailable` tinyint(1) NOT NULL,
  PRIMARY KEY (`wop_object`,`wop_key`),
  KEY `fk_WidgetObjectProperty_WidgetObject1_idx` (`wop_object`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `widgettype`
--

CREATE TABLE IF NOT EXISTS `widgettype` (
  `wt_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wt_classname` varchar(45) NOT NULL,
  `wt_title` varchar(255) NOT NULL,
  `wt_description` text NOT NULL,
  `wt_css` text NOT NULL,
  PRIMARY KEY (`wt_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `widgettype`
--

INSERT INTO `widgettype` (`wt_id`, `wt_classname`, `wt_title`, `wt_description`, `wt_css`) VALUES
(1, 'RandomTextWidget', 'Random Text Widget', 'Shows a random sentence.', '');

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `langitem`
--
ALTER TABLE `langitem`
  ADD CONSTRAINT `fk_LangItem_Language1` FOREIGN KEY (`lait_lang`) REFERENCES `language` (`lang_shortcut`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `menuitem`
--
ALTER TABLE `menuitem`
  ADD CONSTRAINT `fk_MenuItem_Menu1` FOREIGN KEY (`meit_menu`) REFERENCES `menu` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_MenuItem_Menu2` FOREIGN KEY (`meit_submenu`) REFERENCES `menu` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `page`
--
ALTER TABLE `page`
  ADD CONSTRAINT `fk_Page_Page1` FOREIGN KEY (`p_parent`) REFERENCES `page` (`p_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Page_PageType1` FOREIGN KEY (`p_type`) REFERENCES `pagetype` (`pt_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `pageproperty`
--
ALTER TABLE `pageproperty`
  ADD CONSTRAINT `fk_PageProperty_Page1` FOREIGN KEY (`pp_page`) REFERENCES `page` (`p_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `state`
--
ALTER TABLE `state`
  ADD CONSTRAINT `fk_State_Page1` FOREIGN KEY (`sta_page`) REFERENCES `page` (`p_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `styleobject`
--
ALTER TABLE `styleobject`
  ADD CONSTRAINT `fk_StyleObject_StyleTheme1` FOREIGN KEY (`so_theme`) REFERENCES `styletheme` (`st_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `styleproperty`
--
ALTER TABLE `styleproperty`
  ADD CONSTRAINT `fk_StyleProperty_StyleObject1` FOREIGN KEY (`stp_object`) REFERENCES `styleobject` (`so_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `widgetcollectionitem`
--
ALTER TABLE `widgetcollectionitem`
  ADD CONSTRAINT `fk_WidgetCollectionItem_WidgetCollection1` FOREIGN KEY (`wci_collection`) REFERENCES `widgetcollection` (`wc_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_WidgetCollectionItem_WidgetObject1` FOREIGN KEY (`wci_widgetid`) REFERENCES `widgetobject` (`wop_objectid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `widgetobject`
--
ALTER TABLE `widgetobject`
  ADD CONSTRAINT `fk_WidgetObject_WidgetType1` FOREIGN KEY (`wop_type`) REFERENCES `widgettype` (`wt_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `widgetobjectproperty`
--
ALTER TABLE `widgetobjectproperty`
  ADD CONSTRAINT `fk_WidgetObjectProperty_WidgetObject1` FOREIGN KEY (`wop_object`) REFERENCES `widgetobject` (`wop_objectid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
