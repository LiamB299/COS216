-- MySQL dump 10.13  Distrib 8.0.23, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: u18015001_gameculture
-- ------------------------------------------------------
-- Server version	8.0.23

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `user_ratings`
--

DROP TABLE IF EXISTS `user_ratings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_ratings` (
  `key` varchar(100) NOT NULL,
  `gametitle` varchar(100) NOT NULL,
  `rating` int DEFAULT NULL,
  `artwork` varchar(200) DEFAULT NULL,
  `metacritic` int DEFAULT NULL,
  PRIMARY KEY (`key`,`gametitle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_ratings`
--

LOCK TABLES `user_ratings` WRITE;
/*!40000 ALTER TABLE `user_ratings` DISABLE KEYS */;
INSERT INTO `user_ratings` VALUES ('09eb949903','Borderlands 2',91,'https://www.giantbomb.com/a/uploads/original/8/82063/2560027-bl2clean.jpg',89),('09eb949903','God of War',93,'https://www.giantbomb.com/a/uploads/original/33/338034/3287019-3786480319-Z7hV9.png',94),('09eb949903','Grand Theft Auto V',88,'https://www.giantbomb.com/a/uploads/original/0/3699/2463980-grand%20theft%20auto%20v.jpg',97),('09eb949903','Half-Life 2',75,'https://www.giantbomb.com/a/uploads/original/0/2787/625502-hl2box.jpg',96),('09eb949903','Left 4 Dead 2',87,'https://www.giantbomb.com/a/uploads/original/8/87790/1970475-box_l4d2.png',89),('09eb949903','Super Mario Odyssey',83,'https://www.giantbomb.com/a/uploads/original/8/82063/2946176-smobox.jpg',97),('09eb949903','The Last of Us Part II',60,'https://www.giantbomb.com/a/uploads/original/5/56742/3139294-the-last-of-us-part-2-official-box-art%20%282%29.jpg',93),('09eb949903','The Legend of Zelda: Breath of the Wild',92,'https://www.giantbomb.com/a/uploads/original/0/3699/2920687-the%20legend%20of%20zelda%20-%20breath%20of%20the%20wild%20v7.jpg',97),('09eb949903','The Witcher 3: Wild Hunt',94,'https://www.giantbomb.com/a/uploads/original/0/3699/2945734-the%20witcher%203%20-%20wild%20hunt.jpg',92),('984de907ee','Borderlands 2',91,'https://www.giantbomb.com/a/uploads/original/8/82063/2560027-bl2clean.jpg',0),('984de907ee','Demon\'s Souls (2020)',75,'https://www.giantbomb.com/a/uploads/original/45/459166/3251336-demon.jpg',92),('984de907ee','Game title',1,'images/logo.png',1),('984de907ee','Half-Life 2: Update',100,'https://www.giantbomb.com/a/uploads/original/13/137364/3145045-alyx_coverart.jpg',96),('984de907ee','Mass Effect: Legendary Edition',92,'https://www.giantbomb.com/a/uploads/original/0/3699/3274526-masseffectlegendaryedition-coverart.jpg',87),('984de907ee','Returnal',86,'https://www.giantbomb.com/a/uploads/original/33/338034/3287017-4290949330-FlDoL.jpg',86),('984de907ee','The Last of Us Part II',86,'https://www.giantbomb.com/a/uploads/original/5/56742/3139294-the-last-of-us-part-2-official-box-art%20%282%29.jpg',93),('984de907ee','The Legend of Zelda: Breath of the Wild',98,'https://www.giantbomb.com/a/uploads/original/0/3699/2920687-the%20legend%20of%20zelda%20-%20breath%20of%20the%20wild%20v7.jpg',97);
/*!40000 ALTER TABLE `user_ratings` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-05-31  1:55:44
