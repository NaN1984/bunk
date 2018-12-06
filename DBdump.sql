# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.6.42)
# Database: bank
# Generation Time: 2018-12-06 15:47:17 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table customer
# ------------------------------------------------------------

DROP TABLE IF EXISTS `customer`;

CREATE TABLE `customer` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `inn` varchar(50) NOT NULL DEFAULT '',
  `first_name` varchar(50) NOT NULL DEFAULT '',
  `last_name` varchar(50) NOT NULL DEFAULT '',
  `gender` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0- Other, 1 - Male, 2 - Femail',
  `date_birth` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;

INSERT INTO `customer` (`id`, `inn`, `first_name`, `last_name`, `gender`, `date_birth`)
VALUES
	(1,'12367890','Валентин','Орищенко',1,'1984-06-24'),
	(2,'56783457','Іван','Смольний',1,'1990-01-10'),
	(3,'74922750','Ірина','Гриб',2,'1970-02-01'),
	(4,'21348149','Сергій','Тертишний',1,'2000-03-02');

/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table customer_account
# ------------------------------------------------------------

DROP TABLE IF EXISTS `customer_account`;

CREATE TABLE `customer_account` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) unsigned NOT NULL,
  `number` int(11) unsigned NOT NULL,
  `amount` decimal(11,3) NOT NULL DEFAULT '0.000',
  `date_create` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `customer_account_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `customer_account` WRITE;
/*!40000 ALTER TABLE `customer_account` DISABLE KEYS */;

INSERT INTO `customer_account` (`id`, `customer_id`, `number`, `amount`, `date_create`)
VALUES
	(1,1,1100067891,1000.000,'2018-10-01'),
	(2,2,1100067892,100.000,'2018-10-06'),
	(3,3,1100067893,500.000,'2018-11-17'),
	(4,4,1100067894,10000.000,'2018-10-30'),
	(5,2,1100067895,90000.000,'2018-10-31');

/*!40000 ALTER TABLE `customer_account` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table customer_deposit
# ------------------------------------------------------------

DROP TABLE IF EXISTS `customer_deposit`;

CREATE TABLE `customer_deposit` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_account_id` int(11) unsigned NOT NULL,
  `percent` float(11,2) unsigned NOT NULL,
  `initial_amount` decimal(11,3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_account_id` (`customer_account_id`),
  CONSTRAINT `customer_deposit_ibfk_1` FOREIGN KEY (`customer_account_id`) REFERENCES `customer_account` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `customer_deposit` WRITE;
/*!40000 ALTER TABLE `customer_deposit` DISABLE KEYS */;

INSERT INTO `customer_deposit` (`id`, `customer_account_id`, `percent`, `initial_amount`)
VALUES
	(1,1,25.00,1000.000),
	(2,2,18.00,100.000),
	(3,3,45.50,500.000),
	(4,4,13.80,10000.000),
	(5,5,50.00,90000.000);

/*!40000 ALTER TABLE `customer_deposit` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table customer_deposit_operation
# ------------------------------------------------------------

DROP TABLE IF EXISTS `customer_deposit_operation`;

CREATE TABLE `customer_deposit_operation` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_deposit_id` int(11) unsigned NOT NULL,
  `account_amount` decimal(11,3) NOT NULL,
  `amount` decimal(11,3) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL,
  `date_create` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_deposit_id` (`customer_deposit_id`),
  CONSTRAINT `customer_deposit_operation_ibfk_1` FOREIGN KEY (`customer_deposit_id`) REFERENCES `customer_deposit` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
