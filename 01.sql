-- MySQL dump 10.13  Distrib 5.6.23, for Win64 (x86_64)
--
-- Host: localhost    Database: greenb_printer
-- ------------------------------------------------------
-- Server version	5.5.8-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `album`
--

DROP TABLE IF EXISTS `album`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `album` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `is_use_third_party` varchar(20) DEFAULT NULL,
  `thrird_party_id` varchar(50) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `description` text,
  `display_mode` int(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_idx` (`id`),
  KEY `thrird_party_id_idx` (`thrird_party_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `album`
--

LOCK TABLES `album` WRITE;
/*!40000 ALTER TABLE `album` DISABLE KEYS */;
INSERT INTO `album` VALUES (6,'imgur','Sx8Jd','Greenbee Fruits','Fruits Store',0,'2015-07-30 15:07:31','2015-07-30 15:07:31'),(7,NULL,NULL,'Local','Local',0,'2015-07-30 16:07:02','2015-07-30 16:07:02');
/*!40000 ALTER TABLE `album` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fruit_nutrition`
--

DROP TABLE IF EXISTS `fruit_nutrition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fruit_nutrition` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `fruit_id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `value` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fruit_nutrition`
--

LOCK TABLES `fruit_nutrition` WRITE;
/*!40000 ALTER TABLE `fruit_nutrition` DISABLE KEYS */;
INSERT INTO `fruit_nutrition` VALUES (1,1,'Kcal','63'),(2,1,'Chất sơ','0'),(3,1,'VA','1'),(4,1,'VB','1'),(5,1,'VB1','1'),(6,1,'VB2','1'),(7,1,'VC','1'),(8,1,'VE','1'),(9,1,'Ca','1'),(10,1,'Ka','1');
/*!40000 ALTER TABLE `fruit_nutrition` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fruits`
--

DROP TABLE IF EXISTS `fruits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fruits` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `image_name` varchar(120) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fruits`
--

LOCK TABLES `fruits` WRITE;
/*!40000 ALTER TABLE `fruits` DISABLE KEYS */;
INSERT INTO `fruits` VALUES (1,'Cam','orange.png',NULL,NULL);
/*!40000 ALTER TABLE `fruits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `image`
--

DROP TABLE IF EXISTS `image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `image` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `album_id` int(10) NOT NULL,
  `title` varchar(50) NOT NULL,
  `filename` varchar(128) NOT NULL,
  `path` varchar(128) NOT NULL,
  `mime_type` varchar(50) DEFAULT NULL,
  `display_mode` int(1) NOT NULL DEFAULT '1',
  `signature` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_idx` (`id`),
  KEY `signature_idx` (`signature`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `image`
--

LOCK TABLES `image` WRITE;
/*!40000 ALTER TABLE `image` DISABLE KEYS */;
INSERT INTO `image` VALUES (1,6,'fruit','1123231.jpg','http://i.imgur.com/3IV60YF.jpg','image/jpeg',1,'6fab91f2fac2bc9363c6c66f316c9a3a','2015-07-30 16:07:32','2015-07-30 16:07:32'),(2,6,'fruit','1123231.jpg','http://i.imgur.com/odYrtjY.jpg','image/jpeg',1,'6fab91f2fac2bc9363c6c66f316c9a3a','2015-07-30 16:07:22','2015-07-30 16:07:22'),(3,7,'fruit','1123231.jpg','http://localhost/greenbapi/upload/images/1123231.jpg','image/jpeg',1,'6fab91f2fac2bc9363c6c66f316c9a3a','2015-07-30 16:07:30','2015-07-30 16:07:30'),(4,7,'fruit','1123231.jpg','http://192.168.1.16/greenbapi/upload/images/1123231.jpg','image/jpeg',1,'6fab91f2fac2bc9363c6c66f316c9a3a','2015-07-30 16:07:01','2015-07-30 16:07:01'),(5,7,'fruit','sample.jpg','http://192.168.1.16/greenbapi/upload/images/sample.jpg','image/jpeg',1,'6fab91f2fac2bc9363c6c66f316c9a3a','2015-07-30 16:07:09','2015-07-30 16:07:09');
/*!40000 ALTER TABLE `image` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-09-10 16:40:38
