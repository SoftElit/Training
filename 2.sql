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
  `цена` double(10,2) unsigned zerofill DEFAULT NULL,
  KEY `товар` (`товар`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='для хранения цен на товары';

-- Дамп данных таблицы test_samson.a_ price: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `a_ price` DISABLE KEYS */;
/*!40000 ALTER TABLE `a_ price` ENABLE KEYS */;

-- Дамп структуры для таблица test_samson.a_category
CREATE TABLE IF NOT EXISTS `a_category` (
  `ид` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `код` varchar(50) NOT NULL,
  `название` varchar(50) NOT NULL,
  `a_product_id` int(10) unsigned NOT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  UNIQUE KEY `id` (`ид`),
  KEY `a_product_id` (`a_product_id`),
  KEY `parent_category_id` (`parent_id`),
  CONSTRAINT `a_product_id` FOREIGN KEY (`a_product_id`) REFERENCES `a_product` (`id`),
  CONSTRAINT `parent_category_id` FOREIGN KEY (`parent_id`) REFERENCES `a_category` (`ид`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='для хранения рубрик';

-- Дамп данных таблицы test_samson.a_category: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `a_category` DISABLE KEYS */;
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
  CONSTRAINT `a_price_товар` FOREIGN KEY (`a_price_товар`) REFERENCES `a_ price` (`товар`),
  CONSTRAINT `a_property_товар` FOREIGN KEY (`a_property_товар`) REFERENCES `a_property` (`товар`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='для хранения товаров';

-- Дамп данных таблицы test_samson.a_product: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `a_product` DISABLE KEYS */;
/*!40000 ALTER TABLE `a_product` ENABLE KEYS */;

-- Дамп структуры для таблица test_samson.a_property
CREATE TABLE IF NOT EXISTS `a_property` (
  `товар` varchar(50) NOT NULL,
  `значение свойства` varchar(256) NOT NULL,
  KEY `Индекс 1` (`товар`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='для хранения свойства товаров';

-- Дамп данных таблицы test_samson.a_property: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `a_property` DISABLE KEYS */;
/*!40000 ALTER TABLE `a_property` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
