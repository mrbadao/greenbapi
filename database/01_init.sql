-- MySQL dump 10.13  Distrib 5.6.23, for Win64 (x86_64)
--
-- Host: localhost    Database: greenb_cms
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
-- Current Database: `greenb_cms`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `greenb_cms` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `greenb_cms`;

--
-- Table structure for table `cashier`
--

DROP TABLE IF EXISTS `cashier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cashier` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `loginid` varchar(60) NOT NULL,
  `password` varchar(64) NOT NULL,
  `display_name` varchar(250) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `loginid_key` (`loginid`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cashier`
--

LOCK TABLES `cashier` WRITE;
/*!40000 ALTER TABLE `cashier` DISABLE KEYS */;
INSERT INTO `cashier` VALUES (1,'cashier01','e10adc3949ba59abbe56e057f20f883e','HieuNC','0902852296','hieunc18@gmail.com','hieunc18@gmail.com','2015-07-31 14:07:38','2015-07-31 14:07:38',1),(2,'cashier02','e10adc3949ba59abbe56e057f20f883e','HieuNC','0902852296','hieunc18@gmail.com','hieunc18@gmail.com','2015-07-31 14:07:41','2015-07-31 14:07:42',1),(3,'cashier03','e10adc3949ba59abbe56e057f20f883e','HieuNC','0902852296','hieunc18@gmail.com','hieunc18@gmail.com','2015-07-31 14:07:42','2015-07-31 14:07:47',1),(4,'cashier04','e10adc3949ba59abbe56e057f20f883e','HieuNC','0902852296','hieunc18@gmail.com','hieunc18@gmail.com','2015-07-31 14:07:44','2015-07-31 14:07:51',0),(5,'cashier09','508df4cb2f4d8f80519256258cfb975f','Developer','0909213213',NULL,NULL,'2015-08-04 16:08:12','2015-08-04 16:08:12',1),(6,'cashier','508df4cb2f4d8f80519256258cfb975f','hieu','01697515475',NULL,NULL,'2015-08-04 17:08:56','2015-08-04 17:08:56',1),(7,'cashiertest','508df4cb2f4d8f80519256258cfb975f','TestCashier','0773500757',NULL,NULL,'2015-08-04 17:08:04','2015-08-04 17:08:04',1),(8,'hieunc','508df4cb2f4d8f80519256258cfb975f','Hi?u Nguy?n','0929028027','ggghh','hieunc@gmail.com','2015-08-04 17:08:21','2015-08-04 17:08:21',0);
/*!40000 ALTER TABLE `cashier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `masterusers`
--

DROP TABLE IF EXISTS `masterusers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `masterusers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(128) NOT NULL,
  `password` varchar(64) NOT NULL,
  `name` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `loginid_idx` (`email`,`password`),
  KEY `is_active_idx` (`is_active`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `masterusers`
--

LOCK TABLES `masterusers` WRITE;
/*!40000 ALTER TABLE `masterusers` DISABLE KEYS */;
INSERT INTO `masterusers` VALUES (1,'admin@localhost.com','234567','Administrator',1,NULL,NULL);
/*!40000 ALTER TABLE `masterusers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tokens`
--

DROP TABLE IF EXISTS `tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tokens` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL,
  `token` varchar(40) NOT NULL,
  `last_access_ip` varchar(64) DEFAULT NULL,
  `expired` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_access` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_uid` (`uid`),
  KEY `idx_token` (`token`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tokens`
--

LOCK TABLES `tokens` WRITE;
/*!40000 ALTER TABLE `tokens` DISABLE KEYS */;
INSERT INTO `tokens` VALUES (1,1,'d9c7064077f573eb5a4d5de8eb7cdb77','127.0.0.1','2015-07-31 11:07:10','2015-07-31 16:07:10','2015-07-29 15:07:30'),(44,1,'84fb5e5c3d7d06ec157c014ba8e484be','192.168.1.99','2015-08-04 12:08:56','2015-08-04 17:08:56','2015-08-04 12:08:14'),(45,1,'e2947501ed382d9fabe88b970024d752','192.168.1.16','2015-08-04 11:08:12','2015-08-04 16:08:12','2015-08-04 16:08:12');
/*!40000 ALTER TABLE `tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Current Database: `greenb_printer`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `greenb_printer` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `greenb_printer`;

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
) ENGINE=InnoDB AUTO_INCREMENT=340 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fruit_nutrition`
--

LOCK TABLES `fruit_nutrition` WRITE;
/*!40000 ALTER TABLE `fruit_nutrition` DISABLE KEYS */;
INSERT INTO `fruit_nutrition` VALUES (1,1,'Kcal','63'),(2,1,'Chất sơ','0'),(3,1,'VA','0'),(4,1,'VB','1'),(5,1,'VB1','0'),(6,1,'VB2','0'),(7,1,'VC','1'),(8,1,'VE','0'),(9,1,'Ca','1'),(10,1,'Ka','0'),(11,2,'Kcal','63'),(12,2,'Chất sơ','0'),(13,2,'VA','0'),(14,2,'VB','0'),(15,2,'VB1','0'),(16,2,'VB2','0'),(17,2,'VC','0'),(18,2,'VE','1'),(19,2,'Ca','0'),(20,2,'Ka','0'),(21,3,'Kcal','52'),(22,3,'Chất sơ','1'),(23,3,'VA','0'),(24,3,'VB','0'),(25,3,'VB1','0'),(26,3,'VB2','0'),(27,3,'VC','1'),(28,3,'VE','0'),(29,3,'Ca','1'),(30,3,'Ka','0'),(31,4,'Kcal','35'),(32,4,'Chất sơ','0'),(33,4,'VA','0'),(34,4,'VB','0'),(35,4,'VB1','1'),(36,4,'VB2','0'),(37,4,'VC','0'),(38,4,'VE','0'),(39,4,'Ca','0'),(40,4,'Ka','0'),(41,5,'Kcal','160'),(42,5,'Chất sơ','0'),(43,5,'VA','0'),(44,5,'VB','0'),(45,5,'VB1','0'),(46,5,'VB2','0'),(47,5,'VC','0'),(48,5,'VE','0'),(49,5,'Ca','0'),(50,5,'Ka','0'),(51,6,'Kcal','69'),(52,6,'Chất sơ','0'),(53,6,'VA','0'),(54,6,'VB','1'),(55,6,'VB1','0'),(56,6,'VB2','0'),(57,6,'VC','0'),(58,6,'VE','1'),(59,6,'Ca','0'),(60,6,'Ka','0'),(61,7,'Kcal','57'),(62,7,'Chất sơ','1'),(63,7,'VA','0'),(64,7,'VB','0'),(65,7,'VB1','0'),(66,7,'VB2','0'),(67,7,'VC','0'),(68,7,'VE','0'),(69,7,'Ca','0'),(70,7,'Ka','0'),(71,8,'Kcal','80'),(72,8,'Chất sơ','0'),(73,8,'VA','0'),(74,8,'VB','0'),(75,8,'VB1','0'),(76,8,'VB2','0'),(77,8,'VC','0'),(78,8,'VE','0'),(79,8,'Ca','0'),(80,8,'Ka','1'),(81,9,'Kcal','31'),(82,9,'Chất sơ','0'),(83,9,'VA','0'),(84,9,'VB','0'),(85,9,'VB1','0'),(86,9,'VB2','0'),(87,9,'VC','1'),(88,9,'VE','1'),(89,9,'Ca','1'),(90,9,'Ka','0'),(91,10,'Kcal','30'),(92,10,'Chất sơ','0'),(93,10,'VA','1'),(94,10,'VB','0'),(95,10,'VB1','0'),(96,10,'VB2','0'),(97,10,'VC','0'),(98,10,'VE','0'),(99,10,'Ca','0'),(100,10,'Ka','0'),(101,11,'Kcal','39'),(102,11,'Chất sơ','0'),(103,11,'VA','0'),(104,11,'VB','0'),(105,11,'VB1','0'),(106,11,'VB2','0'),(107,11,'VC','0'),(108,11,'VE','1'),(109,11,'Ca','0'),(110,11,'Ka','0'),(111,12,'Kcal','34'),(112,12,'Chất sơ','1'),(113,12,'VA','1'),(114,12,'VB','0'),(115,12,'VB1','0'),(116,12,'VB2','0'),(117,12,'VC','0'),(118,12,'VE','0'),(119,12,'Ca','1'),(120,12,'Ka','1'),(121,13,'Kcal','35'),(122,13,'Chất sơ','0'),(123,13,'VA','1'),(124,13,'VB','0'),(125,13,'VB1','0'),(126,13,'VB2','0'),(127,13,'VC','0'),(128,13,'VE','0'),(129,13,'Ca','1'),(130,13,'Ka','0'),(131,14,'Kcal','60'),(132,14,'Chất sơ','1'),(133,14,'VA','0'),(134,14,'VB','0'),(135,14,'VB1','0'),(136,14,'VB2','1'),(137,14,'VC','1'),(138,14,'VE','0'),(139,14,'Ca','0'),(140,14,'Ka','1'),(141,15,'Kcal','61'),(142,15,'Chất sơ','0'),(143,15,'VA','0'),(144,15,'VB','0'),(145,15,'VB1','0'),(146,15,'VB2','0'),(147,15,'VC','1'),(148,15,'VE','1'),(149,15,'Ca','1'),(150,15,'Ka','1'),(151,16,'Kcal','32'),(152,16,'Chất sơ','0'),(153,16,'VA','0'),(154,16,'VB','0'),(155,16,'VB1','0'),(156,16,'VB2','0'),(157,16,'VC','1'),(158,16,'VE','0'),(159,16,'Ca','0'),(160,16,'Ka','0'),(161,17,'Kcal','34'),(162,17,'Chất sơ','0'),(163,17,'VA','0'),(164,17,'VB','0'),(165,17,'VB1','0'),(166,17,'VB2','1'),(167,17,'VC','1'),(168,17,'VE','1'),(169,17,'Ca','1'),(170,17,'Ka','0'),(171,18,'Kcal','43'),(172,18,'Chất sơ','0'),(173,18,'VA','0'),(174,18,'VB','0'),(175,18,'VB1','0'),(176,18,'VB2','0'),(177,18,'VC','0'),(178,18,'VE','0'),(179,18,'Ca','0'),(180,18,'Ka','0'),(181,19,'Kcal','83'),(182,19,'VA','0'),(183,19,'VB','0'),(184,19,'VB1','0'),(185,19,'VB2','0'),(186,19,'VC','0'),(187,19,'VE','0'),(188,19,'Ca','0'),(189,19,'Ka','0'),(190,20,'Kcal','14'),(191,20,'Chất sơ','0'),(192,20,'VA','1'),(193,20,'VB','0'),(194,20,'VB1','0'),(195,20,'VB2','0'),(196,20,'VC','0'),(197,20,'VE','1'),(198,20,'Ca','0'),(199,20,'Ka','1'),(200,21,'Kcal','57'),(201,21,'Chất sơ','1'),(202,21,'VA','0'),(203,21,'VB','0'),(204,21,'VB1','0'),(205,21,'VB2','0'),(206,21,'VC','0'),(207,21,'VE','0'),(208,21,'Ca','0'),(209,21,'Ka','1'),(210,22,'Kcal','57'),(211,22,'Chất sơ','0'),(212,22,'VA','0'),(213,22,'VB','0'),(214,22,'VB1','0'),(215,22,'VB2','0'),(216,22,'VC','1'),(217,22,'VE','1'),(218,22,'Ca','0'),(219,22,'Ka','0'),(220,23,'Kcal','43'),(221,23,'Chất sơ','0'),(222,23,'VA','1'),(223,23,'VB','0'),(224,23,'VB1','0'),(225,23,'VB2','1'),(226,23,'VC','0'),(227,23,'VE','1'),(228,23,'Ca','1'),(229,23,'Ka','0'),(230,24,'Kcal','50'),(231,24,'Chất sơ','1'),(232,24,'VA','0'),(233,24,'VB','0'),(234,24,'VB1','0'),(235,24,'VB2','0'),(236,24,'VC','1'),(237,24,'VE','0'),(238,24,'Ca','0'),(239,24,'Ka','0'),(240,25,'Kcal','60'),(241,25,'Chất sơ','0'),(242,25,'VA','0'),(243,25,'VB','0'),(244,25,'VB1','0'),(245,25,'VB2','0'),(246,25,'VC','0'),(247,25,'VE','1'),(248,25,'Ca','0'),(249,25,'Ka','0'),(250,26,'Kcal','52'),(251,26,'Chất sơ','1'),(252,26,'VA','0'),(253,26,'VB','0'),(254,26,'VB1','0'),(255,26,'VB2','0'),(256,26,'VC','0'),(257,26,'VE','0'),(258,26,'Ca','0'),(259,26,'Ka','0'),(260,27,'Kcal','32'),(261,27,'Chất sơ','0'),(262,27,'VA','0'),(263,27,'VB','0'),(264,27,'VB1','1'),(265,27,'VB2','0'),(266,27,'VC','1'),(267,27,'VE','0'),(268,27,'Ca','1'),(269,27,'Ka','0'),(270,28,'Kcal','16'),(271,28,'Chất sơ','0'),(272,28,'VA','0'),(273,28,'VB','0'),(274,28,'VB1','0'),(275,28,'VB2','0'),(276,28,'VC','1'),(277,28,'VE','0'),(278,28,'Ca','1'),(279,28,'Ka','0'),(280,29,'Kcal','36'),(281,29,'Chất sơ','1'),(282,29,'VA','1'),(283,29,'VB','0'),(284,29,'VB1','0'),(285,29,'VB2','0'),(286,29,'VC','1'),(287,29,'VE','0'),(288,29,'Ca','1'),(289,29,'Ka','0'),(290,30,'Kcal','13'),(291,30,'Chất sơ','1'),(292,30,'VA','1'),(293,30,'VB','0'),(294,30,'VB1','0'),(295,30,'VB2','0'),(296,30,'VC','0'),(297,30,'VE','0'),(298,30,'Ca','0'),(299,30,'Ka','0'),(300,31,'Kcal','23'),(301,31,'Chất sơ','0'),(302,31,'VA','1'),(303,31,'VB','0'),(304,31,'VB1','0'),(305,31,'VB2','0'),(306,31,'VC','0'),(307,31,'VE','0'),(308,31,'Ca','1'),(309,31,'Ka','1'),(310,32,'Kcal','43'),(311,32,'Chất sơ','0'),(312,32,'VA','1'),(313,32,'VB','0'),(314,32,'VB1','0'),(315,32,'VB2','0'),(316,32,'VC','1'),(317,32,'VE','0'),(318,32,'Ca','0'),(319,32,'Ka','0'),(320,33,'Kcal','12'),(321,33,'Chất sơ','0'),(322,33,'VA','0'),(323,33,'VB','0'),(324,33,'VB1','0'),(325,33,'VB2','0'),(326,33,'VC','1'),(327,33,'VE','0'),(328,33,'Ca','1'),(329,33,'Ka','0'),(330,34,'Kcal','80'),(331,34,'Chất sơ','0'),(332,34,'VA','0'),(333,34,'VB','0'),(334,34,'VB1','0'),(335,34,'VB2','0'),(336,34,'VC','1'),(337,34,'VE','0'),(338,34,'Ca','0'),(339,34,'Ka','1');
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
  `image_name` varchar(120) NOT NULL DEFAULT 'no image',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fruits`
--

LOCK TABLES `fruits` WRITE;
/*!40000 ALTER TABLE `fruits` DISABLE KEYS */;
INSERT INTO `fruits` VALUES (1,'Cam','no image','2015-09-11 10:46:05','2015-09-11 10:46:05'),(2,'Táo đỏ','no image','2015-09-11 10:46:05','2015-09-11 10:46:05'),(3,'Táo xanh ','no image','2015-09-11 10:46:05','2015-09-11 10:46:05'),(4,'Dứa','no image','2015-09-11 10:46:05','2015-09-11 10:46:05'),(5,'Bơ ','no image','2015-09-11 10:46:05','2015-09-11 10:46:05'),(6,'Nho xanh ','no image','2015-09-11 10:46:05','2015-09-11 10:46:05'),(7,'Nho đen ','no image','2015-09-11 10:46:05','2015-09-11 10:46:05'),(8,'Chuối ','no image','2015-09-11 10:46:05','2015-09-11 10:46:05'),(9,'Chanh vàng','no image','2015-09-11 10:46:05','2015-09-11 10:46:05'),(10,'Dưa hấu ','no image','2015-09-11 10:46:05','2015-09-11 10:46:05'),(11,'Đào ','no image','2015-09-11 10:46:05','2015-09-11 10:46:05'),(12,'Cà rốt','no image','2015-09-11 10:46:05','2015-09-11 10:46:05'),(13,'Nghệ','no image','2015-09-11 10:46:05','2015-09-11 10:46:05'),(14,'Kiwi vàng','no image','2015-09-11 10:46:05','2015-09-11 10:46:05'),(15,'Kiwi xanh','no image','2015-09-11 10:46:05','2015-09-11 10:46:05'),(16,'Dâu tây','no image','2015-09-11 10:46:05','2015-09-11 10:46:05'),(17,'Súp lơ xanh ','no image','2015-09-11 10:46:05','2015-09-11 10:46:05'),(18,'củ cải đỏ','no image','2015-09-11 10:46:05','2015-09-11 10:46:05'),(19,'lựu ','no image','2015-09-11 10:46:05','2015-09-11 10:46:05'),(20,'Cà chua','no image','2015-09-11 10:46:05','2015-09-11 10:46:05'),(21,'Lê','no image','2015-09-11 10:46:05','2015-09-11 10:46:05'),(22,'Việt quất','no image','2015-09-11 10:46:05','2015-09-11 10:46:05'),(23,'Kale ','no image','2015-09-11 10:46:05','2015-09-11 10:46:05'),(24,'Thanh long ','no image','2015-09-11 10:46:05','2015-09-11 10:46:05'),(25,'Xoài ','no image','2015-09-11 10:46:05','2015-09-11 10:46:05'),(26,'Rasberry ','no image','2015-09-11 10:46:05','2015-09-11 10:46:05'),(27,'bưởi','no image','2015-09-11 10:46:05','2015-09-11 10:46:05'),(28,'cần tây ','no image','2015-09-11 10:46:05','2015-09-11 10:46:05'),(29,'ngò tây','no image','2015-09-11 10:46:05','2015-09-11 10:46:05'),(30,'bí đao ','no image','2015-09-11 10:46:05','2015-09-11 10:46:05'),(31,'rau chân vịt ','no image','2015-09-11 10:46:05','2015-09-11 10:46:05'),(32,'đu đủ','no image','2015-09-11 10:46:05','2015-09-11 10:46:05'),(33,'dưa leo','no image','2015-09-11 10:46:05','2015-09-11 10:46:05'),(34,'gừng','no image','2015-09-11 10:46:05','2015-09-11 10:46:05');
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

-- Dump completed on 2015-09-11 16:16:24
