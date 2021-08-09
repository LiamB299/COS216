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
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` char(13) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `surname` varchar(30) DEFAULT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(150) NOT NULL,
  `API_Key` varchar(100) NOT NULL,
  `secret` char(10) NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('4','JohnHenry','Faul','Faul@gmail.com','51d9426f9cf9a88598effe18fa16bc34d47ac1fa26a4fff33b1e196657cac14cf4bb5198e218ea369fc24dce7077d31866bc2c9e285cd443449bf4889df74ff1','7d44d82811','1fb48287eb'),('3','John','Biccard','JB@gmail.com','51d9426f9cf9a88598effe18fa16bc34d47ac1fa26a4fff33b1e196657cac14cf4bb5198e218ea369fc24dce7077d31866bc2c9e285cd443449bf4889df74ff1','e5c8fd90fb','b9af1f3a08'),('2','Liam','Burgess','LiamBurgess299@gmail.com','51d9426f9cf9a88598effe18fa16bc34d47ac1fa26a4fff33b1e196657cac14cf4bb5198e218ea369fc24dce7077d31866bc2c9e285cd443449bf4889df74ff1','984de907ee','a5df833332'),('5','Nathan','Mey','Mey@gmail.com','51d9426f9cf9a88598effe18fa16bc34d47ac1fa26a4fff33b1e196657cac14cf4bb5198e218ea369fc24dce7077d31866bc2c9e285cd443449bf4889df74ff1','04078d9d20','5831989d98'),('6','Tristan','vanSchalkwyk','tvs@gmail.com','51d9426f9cf9a88598effe18fa16bc34d47ac1fa26a4fff33b1e196657cac14cf4bb5198e218ea369fc24dce7077d31866bc2c9e285cd443449bf4889df74ff1','8c08dc219a','a20ab0c404'),('0','unlogged','unlogged','unlogged','unlogged','0000000000','unlogged');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
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
