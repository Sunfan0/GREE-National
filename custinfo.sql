-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2016 年 09 月 23 日 13:49
-- 服务器版本: 5.6.21
-- PHP 版本: 5.4.34

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `gree201601`
--

-- --------------------------------------------------------

--
-- 表的结构 `custinfo`
--

CREATE TABLE IF NOT EXISTS `custinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `nickname` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `imgurl` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `inviter` int(11) NOT NULL DEFAULT '0',
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `mobile` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `gotgift` int(11) NOT NULL DEFAULT '0',
  `gottime` datetime DEFAULT NULL,
  `giftid` int(11) NOT NULL DEFAULT '0',
  `giftlevel` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `isgiftused` int(11) NOT NULL DEFAULT '0',
  `usetime` datetime DEFAULT NULL,
  `usesaler` int(11) NOT NULL DEFAULT '0',
  `useinfo` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `createtime` datetime NOT NULL,
  `lastmodifytime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `custinfo`
--

INSERT INTO `custinfo` (`id`, `openid`, `nickname`, `imgurl`, `inviter`, `name`, `mobile`, `gotgift`, `gottime`, `giftid`, `giftlevel`, `isgiftused`, `usetime`, `usesaler`, `useinfo`, `createtime`, `lastmodifytime`) VALUES
(1, 'oFb3-tkVhsABJ5JQNIAPcIr_2LmA', '英子', 'http://wx.qlogo.cn/mmopen/4e8ibp8hIj2ul0XEJKHSvQGAEK7icd81wth5Amc7sYoicXbVDPxC0HabSyINmQ4zrV21WgwNfVkWWYQMXG9RVibG0RpWSXMFGlEa/0', 0, '刘英', '13359190970', 1, '2016-09-29 00:00:00', 1, '500', 0, NULL, 0, '', '2016-09-22 18:18:33', '2016-09-22 18:18:33'),
(2, 'oFb3-tnJR7zTU52cP-37LIYlScrg', '真言', 'http://wx.qlogo.cn/mmopen/4e8ibp8hIj2tiagbicmiazFzeUx6zlPN3Wyg8Aguia38bkoTfsyeZpnzQIKUyReEVcZPIlEQOP2CNoWFnb7DkNRKjFjTLpMzKYZUf/0', 0, '箴言', '13109631185', 1, '2016-09-29 00:00:00', 3, '100', 1, '2016-09-22 18:19:26', 1, '净水机', '2016-09-22 18:19:26', '2016-09-22 18:19:26'),
(3, 'oFb3-tl-h_1Iip_BN8zEhqD1Y-1c', '马鹏飞', 'http://wx.qlogo.cn/mmopen/PiajxSqBRaELsdVyhiaQ2wKP1icFzaOhnByU9HJocYRXNcm7zsaRR93CXcdgrqia3m2sBkmNYgFtINbbAt5hKiaibcvg/0', 0, '鹏飞', '13109631185', 1, '2016-09-29 00:00:00', 53, '50', 1, '2016-09-22 18:19:53', 1, '净水机', '2016-09-22 18:19:53', '2016-09-22 18:19:53'),
(4, 'oFb3-tmpmpwB4LkDCXXQ4_NaNnpI', '吴妈妈', 'http://wx.qlogo.cn/mmopen/SYeWkon6C6KBlXxBFp1zPDkl7FLXdnu9ohkqtM72eVQ4tYXBf26icBOJFe2y4epcvglFFC6rdFlfTKWAUzPGZQpgb6iaJyfHn2/0', 0, '午马', '15903379826', 1, '2016-09-30 00:00:00', 133, '1000', 0, NULL, 0, '', '2016-09-22 18:21:19', '2016-09-22 18:21:19'),
(5, 'oFb3-tizHASV4Sy2BXZ-uXqKB9sY', '好人好梦', 'http://wx.qlogo.cn/mmopen/tHdyLNrQwNJ4hQWIibdY6I7Ge1ib6k4mqnnkp6rhdmsV7dNuRtgOVOrqWg6ArubE5ibE76Da0iaJib17z0dcbyAibKZuib3zrVos8OT/0', 0, 'D马', '15903379826', 1, '2016-09-30 00:00:00', 134, '500', 0, NULL, 0, '', '2016-09-22 18:22:05', '2016-09-22 18:22:05'),
(6, 'oFb3-tkVhsABJ5JQNIAPcIr_2Lml', '英子', 'http://wx.qlogo.cn/mmopen/4e8ibp8hIj2ul0XEJKHSvQGAEK7icd81wth5Amc7sYoicXbVDPxC0HabSyINmQ4zrV21WgwNfVkWWYQMXG9RVibG0RpWSXMFGlEa/0', 0, '刘英', '13359190970', 1, '2016-09-29 00:00:00', -99, '20', 0, NULL, 0, '', '2016-09-22 18:33:07', '2016-09-22 18:33:07');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
