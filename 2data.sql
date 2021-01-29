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

-- Дамп структуры для таблица test_samson.a_ price
CREATE TABLE IF NOT EXISTS `a_ price` (
  `товар` varchar(50) NOT NULL,
  `тип цены` varchar(50) NOT NULL,
  `цена` double(10,2) unsigned DEFAULT NULL,
  KEY `товар` (`товар`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='для хранения цен на товары';

-- Дамп данных таблицы test_samson.a_ price: ~8 rows (приблизительно)
/*!40000 ALTER TABLE `a_ price` DISABLE KEYS */;
INSERT INTO `a_ price` (`товар`, `тип цены`, `цена`) VALUES
	('Бумага А4', 'Базовая', 11.50),
	('Бумага А4', 'Москва', 12.50),
	('Бумага А3', 'Базовая', 18.50),
	('Бумага А3', 'Москва', 22.50),
	('Принтер Canon', 'Базовая', 3010.00),
	('Принтер Canon', 'Москва', 3500.00),
	('Принтер HP', 'Базовая', 3310.00),
	('Принтер HP', 'Москва', 2999.00);
/*!40000 ALTER TABLE `a_ price` ENABLE KEYS */;

-- Дамп структуры для таблица test_samson.a_category
CREATE TABLE IF NOT EXISTS `a_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `код` varchar(50) NOT NULL,
  `название` varchar(50) NOT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `product_id` int(10) unsigned DEFAULT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `код` (`код`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `product_id` FOREIGN KEY (`product_id`) REFERENCES `a_product` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=157 DEFAULT CHARSET=utf8 COMMENT='для хранения рубрик';

-- Дамп данных таблицы test_samson.a_category: ~4 rows (приблизительно)
/*!40000 ALTER TABLE `a_category` DISABLE KEYS */;
INSERT INTO `a_category` (`id`, `код`, `название`, `parent_id`, `product_id`) VALUES
	(153, '201', 'Бумага', 0, NULL),
	(154, '202', 'Бумага', 0, NULL),
	(155, '302', 'Принтеры', 0, NULL),
	(156, '305', 'Принтеры', 0, NULL);
/*!40000 ALTER TABLE `a_category` ENABLE KEYS */;

-- Дамп структуры для таблица test_samson.a_product
CREATE TABLE IF NOT EXISTS `a_product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `код` varchar(50) NOT NULL,
  `название` varchar(50) NOT NULL,
  `a_property_товар` varchar(50) DEFAULT NULL,
  `a_price_товар` varchar(50) DEFAULT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `a_property_товар` (`a_property_товар`),
  KEY `a_price_товар` (`a_price_товар`),
  KEY `код` (`код`),
  CONSTRAINT `a_price_товар` FOREIGN KEY (`a_price_товар`) REFERENCES `a_ price` (`товар`),
  CONSTRAINT `a_property_товар` FOREIGN KEY (`a_property_товар`) REFERENCES `a_property` (`товар`)
) ENGINE=InnoDB AUTO_INCREMENT=147 DEFAULT CHARSET=utf8 COMMENT='для хранения товаров';

-- Дамп данных таблицы test_samson.a_product: ~5 rows (приблизительно)
/*!40000 ALTER TABLE `a_product` DISABLE KEYS */;
INSERT INTO `a_product` (`id`, `код`, `название`, `a_property_товар`, `a_price_товар`) VALUES
	(143, '201', 'Бумага А4', NULL, NULL),
	(144, '202', 'Бумага А3', NULL, NULL),
	(145, '302', 'Принтер Canon', NULL, NULL),
	(146, '305', 'Принтер HP', NULL, NULL);
/*!40000 ALTER TABLE `a_product` ENABLE KEYS */;

-- Дамп структуры для таблица test_samson.a_property
CREATE TABLE IF NOT EXISTS `a_property` (
  `товар` varchar(50) NOT NULL,
  `свойство` varchar(50) NOT NULL,
  `значение свойста` varchar(256) NOT NULL,
  KEY `Индекс 1` (`товар`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='для хранения свойства товаров';

-- Дамп данных таблицы test_samson.a_property: ~16 rows (приблизительно)
/*!40000 ALTER TABLE `a_property` DISABLE KEYS */;
INSERT INTO `a_property` (`товар`, `свойство`, `значение свойста`) VALUES
	('Бумага А4', 'Плотность', '100'),
	('Бумага А4', 'Белизна ЕдИзм=%', '150'),
	('Бумага А4', 'Формат', ''),
	('Бумага А4', 'Тип', ''),
	('Бумага А3', 'Плотность', '90'),
	('Бумага А3', 'Белизна ЕдИзм=%', '100'),
	('Бумага А3', 'Формат', ''),
	('Бумага А3', 'Тип', ''),
	('Принтер Canon', 'Плотность', '90'),
	('Принтер Canon', 'Белизна ЕдИзм=%', '100'),
	('Принтер Canon', 'Формат', 'A4'),
	('Принтер Canon', 'Тип', 'Лазерный'),
	('Принтер HP', 'Плотность', '90'),
	('Принтер HP', 'Белизна ЕдИзм=%', '100'),
	('Принтер HP', 'Формат', 'A3'),
	('Принтер HP', 'Тип', 'Лазерный');
/*!40000 ALTER TABLE `a_property` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
