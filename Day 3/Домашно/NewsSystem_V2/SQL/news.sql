-- phpMyAdmin SQL Dump
-- version 4.0.6deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Време на генериране: 25 юни 2014 в 20:09
-- Версия на сървъра: 5.5.37-0ubuntu0.13.10.1
-- Версия на PHP: 5.5.3-1ubuntu2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- БД: `news`
--

-- --------------------------------------------------------

--
-- Структура на таблица `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `user_id` int(12) NOT NULL,
  `title` varchar(50) NOT NULL,
  `cat` int(12) NOT NULL,
  `content` text NOT NULL,
  `photo` varchar(50) NOT NULL,
  `time` int(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Схема на данните от таблица `news`
--

INSERT INTO `news` (`id`, `user_id`, `title`, `cat`, `content`, `photo`, `time`) VALUES
(1, 1, 'Победих 2048!', 0, 'Това е новината, с която не мога да опиша радостта си!!!', '204235035153a97f1e67a9c.png', 1403617054),
(2, 3, 'Лорем ипсум тест', 0, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus iaculis nisl est, a egestas turpis semper sed. Quisque erat leo, consequat non eros sit amet, condimentum rhoncus ipsum. Sed nec luctus odio. Curabitur aliquet diam ut luctus accumsan. Duis non augue id mauris vulputate viverra sed ut ipsum. Donec ac scelerisque dolor, vitae auctor lacus. Praesent odio eros, eleifend nec lacinia quis, semper sit amet dolor. Vestibulum tortor ligula, laoreet id elit ac, volutpat ullamcorper sem. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Maecenas venenatis vel lectus in adipiscing. Donec in accumsan enim, ut accumsan nisi. Donec ullamcorper suscipit sapien, et pulvinar urna.', '169515966553a9bd882e3dd.jpg', 1403633032),
(3, 4, '<b>hacker</b>', 0, '<b>hacker</b>', '30959563953a9be54a50eb.jpg', 1403633236),
(4, 5, 'PHP Masters', 3, 'Пишем яки системи!!!', '199901789753ab1e33a0129.jpeg', 1403723315);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
