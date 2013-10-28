-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 04, 2011 at 01:52 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `reservation`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `telp` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id`, `name`, `telp`, `address`, `description`) VALUES
(1, 'wirarama', '089xxxxxx', 'jalan pulau xxx', '<p>orangnya agak kurang waras</p>');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE IF NOT EXISTS `reservation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room` int(11) NOT NULL,
  `client` int(11) NOT NULL,
  `price` varchar(50) NOT NULL,
  `price_total` varchar(100) NOT NULL,
  `datefrom` date NOT NULL,
  `dateto` date NOT NULL,
  `unixfrom` varchar(20) NOT NULL,
  `unixto` varchar(20) NOT NULL,
  `amount` tinyint(4) NOT NULL,
  `description` text NOT NULL,
  `status` enum('booked','reserved') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`id`, `room`, `client`, `price`, `price_total`, `datefrom`, `dateto`, `unixfrom`, `unixto`, `amount`, `description`, `status`) VALUES
(4, 1, 1, '1000000', '11000000', '2011-01-19', '2011-01-29', '1295362800', '1296312650', 11, '<p>test</p>', 'reserved'),
(5, 3, 1, '500000', '1000000', '2011-01-27', '2011-01-28', '1296057600', '1296229850', 2, '<p>test</p>', 'booked');

-- --------------------------------------------------------

--
-- Table structure for table `reservation_valueadd`
--

CREATE TABLE IF NOT EXISTS `reservation_valueadd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reservation` int(11) NOT NULL,
  `valueadd` int(11) NOT NULL,
  `price` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `reservation_valueadd`
--

INSERT INTO `reservation_valueadd` (`id`, `reservation`, `valueadd`, `price`) VALUES
(1, 5, 1, '10000'),
(2, 5, 2, '15000'),
(3, 5, 3, '500000'),
(5, 5, 7, '30000'),
(6, 5, 14, '22000');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE IF NOT EXISTS `room` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `room_category` int(11) NOT NULL,
  `price` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`id`, `name`, `room_category`, `price`, `description`, `status`) VALUES
(1, 'Ruang Kelas 1A', 1, '1000000', '<p>Berada dekat pantai</p>', 'active'),
(2, 'Ruang Kelas 1B', 1, '1000000', '<p>Berada dekat pantai pemandangan bagus. AC sedikit bermasalah.</p>', 'active'),
(3, 'Ruang Kelas 2A', 2, '500000', '', 'active'),
(4, 'Ruang Kelas 2B', 2, '500000', '', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `room_category`
--

CREATE TABLE IF NOT EXISTS `room_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `room_category`
--

INSERT INTO `room_category` (`id`, `name`) VALUES
(1, 'kelas1'),
(2, 'kelas2'),
(3, 'VIP');

-- --------------------------------------------------------

--
-- Table structure for table `valueadd`
--

CREATE TABLE IF NOT EXISTS `valueadd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `valueadd_category` int(11) NOT NULL,
  `price` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `valueadd`
--

INSERT INTO `valueadd` (`id`, `name`, `valueadd_category`, `price`, `description`, `date`) VALUES
(4, 'continental breakfast', 1, '24000', '<p>toast with butter and jam, fruit salad, orange juice with or tea</p>', '2011-02-06 12:59:35'),
(5, 'english breakfast', 1, '35000', '<p>two eggs any style (choose from fried, boiled, peach or scrambled). Toast with butter and jam, bacon, fried tomato and baked beans Fruit salad, orange juice with tea or coffee.</p>', '2011-02-06 13:03:44'),
(6, 'american breakfast', 1, '30000', '<p>two eggs any style (choose from fried, boiled, peach or scrambled). \r\nToast with butter and jam, fried saucage, Fruit \r\nsalad, orange juice with tea or coffee.</p>', '2011-02-06 13:04:53'),
(7, 'indonesian breakfast', 1, '30000', '<p>choose between fried rice or fried noodle serve with fruit salad, orange juice, tea or coffee</p>', '2011-02-06 13:06:58'),
(8, 'omelette', 1, '25000', '<p>pan sautted eggs with cheese, ham, tomato, onion, avocado and mushroom serve with toast</p>', '2011-02-06 13:08:18'),
(9, 'balangan omellete', 1, '30000', '<p>pan sautted eggs with potato, bacon, garlic, onion, tomato, cheese serve with tomato bruschetta.</p>', '2011-02-06 13:12:12'),
(10, 'scrambled eggs', 1, '28000', '<p>with cheese, ham, tomato, and onion served with toast.</p>', '2011-02-06 13:13:22'),
(11, 'plain eggs on toast', 1, '15000', '<p>choose of scrambled, fried, poached or boiled.</p>', '2011-02-06 13:14:27'),
(12, 'bean on toast', 1, '15000', '', '2011-02-06 13:14:52'),
(13, 'bean on cheese on toast', 1, '18000', '', '2011-02-06 13:15:22'),
(14, 'cerealand cornflakes', 1, '22000', '<p>served with fresh cold milk and sliced banana</p>', '2011-02-06 13:16:29'),
(15, 'avocado omellete', 1, '28000', '<p>bayam, anion, avocado, salsa with bacon</p>', '2011-02-06 13:17:41'),
(16, 'denver omellete', 1, '30000', '<p>mozrela cheese, grilled ham, onion</p>', '2011-02-06 13:18:42'),
(17, 'cap cay chicken or seafood', 2, '28000', '<p>chinese vegetable soup choice of seafood or chicken.</p>', '2011-02-06 13:20:31'),
(18, 'avocado shrimp cocktail', 2, '25000', '', '2011-02-06 13:21:16'),
(19, 'spring rolls', 2, '20000', '', '2011-02-06 13:21:35'),
(20, 'calamari ring with mayonaise', 2, '25000', '', '2011-02-06 13:23:02'),
(21, 'guacamole', 2, '16000', '', '2011-02-06 13:23:26'),
(22, 'garlic bread cheese', 2, '28000', '', '2011-02-06 13:23:54'),
(23, 'bruschetta', 2, '20000', '', '2011-02-06 13:24:28'),
(24, 'zuppa di tomato', 2, '15000', '<p>a heat warning tomato soup</p>', '2011-02-06 13:25:20'),
(25, 'minestrone soup', 2, '20000', '<p>mixed vegetable soup with fussily pasta.</p>', '2011-02-06 13:26:14'),
(26, 'chicken soup', 2, '20000', '<p>chicken cubes in flaty cream chicken brots</p>', '2011-02-06 13:27:01'),
(27, 'salad', 3, '25000', '<p>fresh salad of apple, cellery, black olives, cashew nuts topped of sauce mayonaise</p>', '2011-02-06 13:29:29'),
(28, 'nicoise salad', 3, '18000', '<p>fresh salad mixed of green beans, onion, green pepper, tomato with vinegraitte sauce.</p>', '2011-02-06 13:30:52'),
(29, 'gado gado', 3, '25000', '<p>vegetable of carrot, colyflower, cucumber, potato, longbeans, eggs, tempe serve with peanuts.</p>', '2011-02-06 13:32:19'),
(30, 'tuna salad', 3, '35000', '<p>lettuce, tuna, avocado, tomato, green pepper, black olive, rhode island sauce.</p>', '2011-02-06 13:33:54'),
(31, 'insalata primavera', 3, '30000', '<p>spinach, lettuce, shrimp, mushroom, black oliver, egg, with vinaigrette dressing.</p>', '2011-02-06 13:35:42'),
(32, 'caesar salad with chicken', 3, '32000', '<p>lettuce, srilled, onion, parmesan cheese.</p>', '2011-02-06 13:37:03'),
(33, 'greek pasta salad', 3, '35000', '<p>lettuce, onion, tomato, black olive, cucumber, fussili pasta.</p>', '2011-02-06 13:38:14');

-- --------------------------------------------------------

--
-- Table structure for table `valueadd_category`
--

CREATE TABLE IF NOT EXISTS `valueadd_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `valueadd_category`
--

INSERT INTO `valueadd_category` (`id`, `name`) VALUES
(1, 'breakfast'),
(2, 'soup and appetizer'),
(3, 'salad');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
