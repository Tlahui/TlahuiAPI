# ************************************************************
# Sequel Pro SQL dump
# Version 4499
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.42)
# Database: tlahui
# Generation Time: 2015-12-06 15:14:47 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table invoiceRequest
# ------------------------------------------------------------

DROP TABLE IF EXISTS `invoiceRequest`;

CREATE TABLE `invoiceRequest` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idPurchase` int(11) unsigned NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `address` varchar(255) DEFAULT NULL,
  `rfc` varchar(13) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table product
# ------------------------------------------------------------

DROP TABLE IF EXISTS `product`;

CREATE TABLE `product` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL DEFAULT '',
  `precio` float NOT NULL,
  `qty` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;

INSERT INTO `product` (`id`, `nombre`, `precio`, `qty`)
VALUES
	(1,'Blusa',891.9,1000),
	(2,'Saco',67.9,0),
	(3,'Camisa',1245.9,0);

/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table productImage
# ------------------------------------------------------------

DROP TABLE IF EXISTS `productImage`;

CREATE TABLE `productImage` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idProduct` int(11) unsigned NOT NULL,
  `url` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table productLike
# ------------------------------------------------------------

DROP TABLE IF EXISTS `productLike`;

CREATE TABLE `productLike` (
  `id` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idProduct` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;



# Dump of table productPurchase
# ------------------------------------------------------------

DROP TABLE IF EXISTS `productPurchase`;

CREATE TABLE `productPurchase` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idProduct` int(11) unsigned NOT NULL,
  `idPurchase` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table purchase
# ------------------------------------------------------------

DROP TABLE IF EXISTS `purchase`;

CREATE TABLE `purchase` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `paymentProcessed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `reference` varchar(255) NOT NULL DEFAULT '',
  `total` float unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `correoElectronico` varchar(200) NOT NULL DEFAULT '',
  `usuario` varchar(11) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `nombre` varchar(100) NOT NULL,
  `fechaNacimiento` varchar(20) NOT NULL DEFAULT '',
  `direccion` varchar(16) NOT NULL DEFAULT '',
  `telefono` varchar(200) NOT NULL DEFAULT '',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4;

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;

INSERT INTO `user` (`id`, `correoElectronico`, `usuario`, `password`, `nombre`, `fechaNacimiento`, `direccion`, `telefono`, `type`)
VALUES
	(1,'roberto@novelo.com','novelo','password','Roberto Novelo','2015/12/11','Av. Patria','55522299907',0),
	(2,'correo@servidor','usuario','password','Roberto','10/10/1980','domicilio conoci','0449512233',0),
	(3,'correo@servidor','usuario','password','Roberto','10/10/1980','domicilio conoci','0449512233',0),
	(4,'correo@servidor','usuario','password','Roberto','10/10/1980','domicilio conoci','0449512233',0),
	(5,'correo@servidor','usuario','password','Roberto','10/10/1980','domicilio conoci','0449512233',0),
	(6,'correo@servidor','usuario','password','Roberto','10/10/1980','domicilio conoci','0449512233',0),
	(7,'correo@servidor','usuario','password','Roberto','10/10/1980','domicilio conoci','0449512233',0),
	(8,'correo@servidor','usuario','password','Roberto','10/10/1980','domicilio conoci','0449512233',0),
	(9,'correo@servidor','usuario','password','Roberto','10/10/1980','domicilio conoci','0449512233',0),
	(10,'correo@servidor','usuario','password','Roberto','10/10/1980','domicilio conoci','0449512233',0),
	(11,'correo@servidor','usuario','password','Roberto','10/10/1980','domicilio conoci','0449512233',0),
	(12,'correo@servidor','usuario','password','Roberto','10/10/1980','domicilio conoci','0449512233',0),
	(13,'correo@servidor','usuario','password','Roberto','10/10/1980','domicilio conoci','0449512233',0),
	(14,'correo@servidor2','usuario2','password','Roberto','10/10/1980','domicilio conoci','0449512233',0),
	(15,'correo@servidor3','usuario3','password','Roberto','10/10/1980','domicilio conoci','0449512233',0),
	(16,'correo@servidor4','usuario4','password','Roberto','10/10/1980','domicilio conoci','0449512233',0),
	(17,'correo@servidor5','usuario5','password','Roberto','10/10/1980','domicilio conoci','0449512233',0),
	(18,'novvsss','novss','password','Roberto','10/10/1980','domicili','0449512233',0),
	(19,'novvssskjhdsk','novsssjdhkj','passsword','Roberto','10/10/1980','domicili','0449512233',0),
	(20,'hash1@n.com','novelohash1','$2y$10$9O/7K7BAq','Roberto','10/10/1980','domicili','0449512233',0),
	(21,'hash@n.com','novelohash','$2y$10$TjPTFH/eP','Roberto','10/10/1980','domicili','0449512233',0),
	(22,'phone@n.com','novelophone','$2y$10$dFHiJZ5mD','Roberto','10/10/1980','domicili','1231231231',0),
	(23,'phone1@n.com','novelophone','$2y$10$Twuq/SBiz','Roberto','10/10/1980','domicili','(123)1231231',0),
	(24,'dassste@n.com','novelsssoda','$2y$10$hAHV97tk4','Roberto','1980/10/10','domicili','1231231231',0),
	(26,'correo@uag.mx','chiunti','$2y$10$ezx3vhaiw/I4Xu26I9fyzOfEsX//WEmrtH4ydYp5FJMtdRcW/uC2e','chiunti','1970/11/06','domicili','1234567890',0),
	(27,'date@n.com','novelodate','$2y$10$c59GeZl8rrQOOT6zo4iADesq9nqq7zKdCHWs166HkrlVEStL0g59.','Roberto','1980-10-10','domicili','1231231231',0);

/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
