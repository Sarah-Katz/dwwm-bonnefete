-- MySQL dump 10.13  Distrib 8.0.33, for Win64 (x86_64)
--
-- Host: localhost    Database: bonnefete
-- ------------------------------------------------------
-- Server version	8.0.33

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
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_post` int NOT NULL,
  `ID_user` int NOT NULL,
  `ID_comment` int DEFAULT NULL,
  `message` varchar(200) NOT NULL,
  `timestamp` datetime NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `comment_owner_idx` (`ID_user`),
  KEY `owning_post_idx` (`ID_post`),
  KEY `owning_comment_idx` (`ID_comment`),
  CONSTRAINT `comment_owner` FOREIGN KEY (`ID_user`) REFERENCES `users` (`ID_user`),
  CONSTRAINT `owning_comment` FOREIGN KEY (`ID_comment`) REFERENCES `comments` (`ID`),
  CONSTRAINT `owning_post` FOREIGN KEY (`ID_post`) REFERENCES `posts` (`ID_post`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `likes` (
  `ID_like` int NOT NULL AUTO_INCREMENT,
  `ID_post` int DEFAULT NULL,
  `ID_user` int NOT NULL,
  `ID_comment` int DEFAULT NULL,
  PRIMARY KEY (`ID_like`),
  KEY `like_user_idx` (`ID_user`),
  KEY `like_post_idx` (`ID_post`),
  KEY `like_comment_idx` (`ID_comment`),
  CONSTRAINT `like_comment` FOREIGN KEY (`ID_comment`) REFERENCES `comments` (`ID`),
  CONSTRAINT `like_post` FOREIGN KEY (`ID_post`) REFERENCES `posts` (`ID_post`),
  CONSTRAINT `like_user` FOREIGN KEY (`ID_user`) REFERENCES `users` (`ID_user`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `likes`
--

LOCK TABLES `likes` WRITE;
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
INSERT INTO `likes` VALUES (29,40,9,NULL),(31,40,5,NULL);
/*!40000 ALTER TABLE `likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `ID_post` int NOT NULL AUTO_INCREMENT,
  `ID_user` int NOT NULL,
  `post_date` datetime NOT NULL,
  `message` varchar(200) NOT NULL,
  PRIMARY KEY (`ID_post`),
  KEY `woner_idx` (`ID_user`),
  CONSTRAINT `woner` FOREIGN KEY (`ID_user`) REFERENCES `users` (`ID_user`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (2,2,'2023-06-29 00:00:00','Je s\'appelles Jean-Marc'),(31,2,'2023-06-29 00:00:00','Message pour tester à quoi ça ressemble'),(32,2,'2023-06-29 00:00:00','Message un peu plus long pour tester à quoi ça ressemble'),(34,2,'2023-06-29 00:00:00','Message un peu plus long pour tester à quoi ça ressemble'),(38,5,'2023-07-01 02:32:19','Test de modification du message'),(40,9,'2023-07-01 07:15:38','Tugdual est le meilleur chien !');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `ID_roles` int NOT NULL AUTO_INCREMENT,
  `role_name` varchar(25) NOT NULL,
  PRIMARY KEY (`ID_roles`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'user'),(2,'admin'),(3,'superadmin');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `ID_user` int NOT NULL AUTO_INCREMENT,
  `ID_role` int NOT NULL DEFAULT '1',
  `email` varchar(50) NOT NULL,
  `username` varchar(25) NOT NULL,
  `register_date` datetime NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_active` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID_user`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `role_idx` (`ID_role`),
  CONSTRAINT `role` FOREIGN KEY (`ID_role`) REFERENCES `roles` (`ID_roles`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,2,'test@test.com','TEST','2023-06-27 00:00:00','',1),(2,1,'jean-marc@gmail.com','Jean-marc','2023-06-28 09:33:49','$2y$10$VovjGGdvTQW16JF7Gc0w0O7CoyIWX6PrLwl/sxV.MyEnfZH2frAA6',1),(4,2,'samuel-denomme@hotmail.com','BUNNY','2023-06-30 11:16:55','$2y$10$sbwbrSEJdPsESnwwK11IdOBhbRM6dyDEb6cmUpsrlo9FNrBHnPyvG',1),(5,3,'sarahkatz59@gmail.com','Sarah katz','2023-06-30 03:19:13','$2y$10$Ptj7s0gEYOGCRm0fC13j8uuhnhtot4n9Icg7D9wfr.glQkEy4estS',1),(6,1,'test1@test.com','Utilisateur désactivé','2023-06-30 05:08:04','$2y$10$tleczDPANCVsogYGeI/zRelCIYzRpCQhHUFuxe2HlZ7FZ8Yv.ojd6',0),(9,1,'ulysse.debove@gmail.com','ULYSSE DEBOVE','2023-06-30 06:52:35','$2y$10$T1RC5jEJDBB32qqCtIYWieXItPcGceAA/pmsloJcQ.qpy3Jk0sRbK',1),(10,1,'rfg@gmail.com','Utilisateur désactivé','2023-06-30 06:56:33','$2y$10$g9wySHYYBRmX9HPCYdOdKOzE69phoUg0Kz/nJRB7vm1F3c/31fMp2',0),(11,1,'Herge@gmail.com','Hergé','2023-06-30 06:58:35','$2y$10$lsy06L2nOwmc3ZUb5bAj1Oc0b2jSnkfhFVKfBdUSZj8kLoAOY1YQC',1),(12,1,'antoine-marc@gmail.com','Antoine Marc','2023-06-30 06:59:35','$2y$10$hOhFtQNVtJm49XPa0dDl8.4iJme3sVuLzoARpJz8OOB.0J2c44NoK',1),(13,1,'dfght@scdfg.com','Utilisateur désactivé','2023-06-30 07:01:14','$2y$10$KTpep.zqCeDr4wuODtpRAew5/e2tGe/hiUzyKMOtv7TGn2A8Po8ru',0),(14,1,'sdfeqrtg@oithdfgj.dfgiouhj','Utilisateur désactivé','2023-06-30 07:03:59','$2y$10$Oh0Ql0kUgs3x1tD4.9mpTeC2t9AcfxbGJO/WdUcugSGjW7zLEtzsO',0),(15,1,'xcdaazrety@kJHG.COM','Utilisateur désactivé','2023-06-30 07:04:49','$2y$10$29CYYmN/t9Dw7DbTB3N8e.g5H96zj6vYMsVXdWYdrL4VMH7ZDYIue',0);
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

-- Dump completed on 2023-07-02 17:41:26
