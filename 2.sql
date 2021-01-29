-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.7.29 - MySQL Community Server (GPL)
-- Операционная система:         Win64
-- HeidiSQL Версия:              11.1.0.6116
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Дамп структуры базы данных test_samson
CREATE DATABASE IF NOT EXISTS `test_samson` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `test_samson`;

-- Дамп структуры для таблица test_samson.a_category
CREATE TABLE IF NOT EXISTS `a_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `код` varchar(50) NOT NULL,
  `название` varchar(50) NOT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `код` (`код`),
  CONSTRAINT `parent_id` FOREIGN KEY (`parent_id`) REFERENCES `a_category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `код_a_product.код` FOREIGN KEY (`код`) REFERENCES `a_product` (`код`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COMMENT='для хранения рубрик';

-- Дамп данных таблицы test_samson.a_category: ~6 rows (приблизительно)
/*!40000 ALTER TABLE `a_category` DISABLE KEYS */;
INSERT INTO `a_category` (`id`, `код`, `название`, `parent_id`) VALUES
	(37, '201', 'Бумага', NULL),
	(38, '202', 'Бумага', NULL),
	(39, '302', 'Принтеры', NULL),
	(40, '302', 'МФУ', NULL),
	(41, '305', 'Принтеры', NULL),
	(42, '305', 'МФУ', NULL);
/*!40000 ALTER TABLE `a_category` ENABLE KEYS */;

-- Дамп структуры для таблица test_samson.a_price
CREATE TABLE IF NOT EXISTS `a_price` (
  `товар` varchar(50) NOT NULL,
  `тип цены` varchar(50) NOT NULL,
  `цена` double(10,2) unsigned DEFAULT NULL,
  KEY `товар` (`товар`),
  CONSTRAINT `товар_a_product.название` FOREIGN KEY (`товар`) REFERENCES `a_product` (`название`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='для хранения цен на товары';

-- Дамп данных таблицы test_samson.a_price: ~8 rows (приблизительно)
/*!40000 ALTER TABLE `a_price` DISABLE KEYS */;
INSERT INTO `a_price` (`товар`, `тип цены`, `цена`) VALUES
	('Бумага А4', 'Базовая', 11.50),
	('Бумага А4', 'Москва', 12.50),
	('Бумага А3', 'Базовая', 18.50),
	('Бумага А3', 'Москва', 22.50),
	('Принтер Canon', 'Базовая', 3010.00),
	('Принтер Canon', 'Москва', 3500.00),
	('Принтер HP', 'Базовая', 3310.00),
	('Принтер HP', 'Москва', 2999.00);
/*!40000 ALTER TABLE `a_price` ENABLE KEYS */;

-- Дамп структуры для таблица test_samson.a_product
CREATE TABLE IF NOT EXISTS `a_product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `код` varchar(50) NOT NULL,
  `название` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `код` (`код`),
  KEY `название` (`название`)
) ENGINE=InnoDB AUTO_INCREMENT=521 DEFAULT CHARSET=utf8 COMMENT='для хранения товаров';

-- Дамп данных таблицы test_samson.a_product: ~4 rows (приблизительно)
/*!40000 ALTER TABLE `a_product` DISABLE KEYS */;
INSERT INTO `a_product` (`id`, `код`, `название`) VALUES
	(517, '201', 'Бумага А4'),
	(518, '202', 'Бумага А3'),
	(519, '302', 'Принтер Canon'),
	(520, '305', 'Принтер HP');
/*!40000 ALTER TABLE `a_product` ENABLE KEYS */;

-- Дамп структуры для таблица test_samson.a_property
CREATE TABLE IF NOT EXISTS `a_property` (
  `товар` varchar(50) NOT NULL,
  `свойство` varchar(50) NOT NULL,
  `значение свойства` varchar(256) NOT NULL,
  KEY `товар` (`товар`),
  CONSTRAINT `товар_название` FOREIGN KEY (`товар`) REFERENCES `a_product` (`название`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='для хранения свойства товаров';

-- Дамп данных таблицы test_samson.a_property: ~9 rows (приблизительно)
/*!40000 ALTER TABLE `a_property` DISABLE KEYS */;
INSERT INTO `a_property` (`товар`, `свойство`, `значение свойства`) VALUES
	('Бумага А4', 'Плотность', '100'),
	('Бумага А4', 'Белизна ЕдИзм=%', '100'),
	('Бумага А3', 'Плотность', '90'),
	('Бумага А3', 'Белизна ЕдИзм=%', '90'),
	('Принтер Canon', 'Тип', 'Лазерный'),
	('Принтер Canon', 'Формат', 'A4'),
	('Принтер Canon', 'Формат', 'A3'),
	('Принтер HP', 'Тип', 'Лазерный'),
	('Принтер HP', 'Формат', 'A3');
/*!40000 ALTER TABLE `a_property` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
