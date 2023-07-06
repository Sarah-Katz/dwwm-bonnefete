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
  `ID_post` int DEFAULT NULL,
  `ID_user` int DEFAULT NULL,
  `ID_comment` int DEFAULT NULL,
  `message` varchar(200) NOT NULL,
  `timestamp` datetime NOT NULL,
  `url_image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `comment_owner_idx` (`ID_user`),
  KEY `owning_post_idx` (`ID_post`),
  KEY `owning_comment_idx` (`ID_comment`),
  CONSTRAINT `comment_owner` FOREIGN KEY (`ID_user`) REFERENCES `users` (`ID_user`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `owning_comment` FOREIGN KEY (`ID_comment`) REFERENCES `comments` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `owning_post` FOREIGN KEY (`ID_post`) REFERENCES `posts` (`ID_post`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,40,5,NULL,'Test commentaires nesté modifé','2023-07-03 11:12:33',NULL),(3,40,9,1,'test 3','2023-07-03 01:41:49',NULL),(4,40,5,1,'test','2023-07-03 01:55:41',NULL),(5,40,5,1,'defrgvhb','2023-07-03 01:56:59',NULL),(6,40,5,1,'ghfdd','2023-07-03 01:57:34',NULL),(7,40,5,1,'dfgh','2023-07-03 01:57:47',NULL),(10,40,5,NULL,'modifié','2023-07-03 02:31:08',NULL),(11,40,5,NULL,'ppppp','2023-07-03 02:34:07',NULL),(12,38,5,NULL,'Test de comm','2023-07-03 02:36:28',NULL),(16,2,5,NULL,'gvnhhbjuiko','2023-07-03 02:57:55',NULL),(17,2,5,NULL,'nb, n,gbnb','2023-07-03 03:01:11',NULL),(18,2,5,NULL,'hjyuguu_hhyhg','2023-07-03 03:01:35',NULL),(19,31,5,NULL,'dfxcgvhb','2023-07-03 03:01:57',NULL),(20,31,5,NULL,'cvgfgbgn,','2023-07-03 03:03:58',NULL),(21,2,5,NULL,'dfcvgbghvn','2023-07-03 03:04:11',NULL),(22,2,5,NULL,'mlihjkrgghrmjl','2023-07-03 03:04:15',NULL),(23,32,5,NULL,'Envois','2023-07-03 03:04:32',NULL),(24,40,5,NULL,'Le meilleur commentaire du monde','2023-07-03 03:04:45',NULL);
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
  `ID_user` int DEFAULT NULL,
  `ID_comment` int DEFAULT NULL,
  PRIMARY KEY (`ID_like`),
  KEY `like_user_idx` (`ID_user`),
  KEY `like_post_idx` (`ID_post`),
  KEY `like_comment_idx` (`ID_comment`),
  CONSTRAINT `like_comment` FOREIGN KEY (`ID_comment`) REFERENCES `comments` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `like_post` FOREIGN KEY (`ID_post`) REFERENCES `posts` (`ID_post`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `like_user` FOREIGN KEY (`ID_user`) REFERENCES `users` (`ID_user`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `likes`
--

LOCK TABLES `likes` WRITE;
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
INSERT INTO `likes` VALUES (29,40,9,NULL),(59,NULL,9,1),(79,40,5,NULL);
/*!40000 ALTER TABLE `likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `logs` (
  `ID_log` int NOT NULL AUTO_INCREMENT,
  `type` varchar(45) NOT NULL,
  `ID_user` int DEFAULT NULL,
  `ID_post` int DEFAULT NULL,
  `ID_comment` int DEFAULT NULL,
  `ID_admin` int DEFAULT NULL,
  `timestamp` datetime NOT NULL,
  PRIMARY KEY (`ID_log`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs`
--

LOCK TABLES `logs` WRITE;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
INSERT INTO `logs` VALUES (18,'commentCreate',5,NULL,28,NULL,'2023-07-06 11:25:29'),(20,'userLogout',5,NULL,NULL,NULL,'2023-07-06 11:29:42'),(21,'userLogin',5,NULL,NULL,NULL,'2023-07-06 11:29:48'),(22,'commentCreate',5,NULL,29,NULL,'2023-07-06 11:30:27'),(25,'commentDeleteAdmin',NULL,NULL,15,5,'2023-07-06 11:33:48'),(26,'commentDeleteAdmin',NULL,NULL,14,5,'2023-07-06 11:33:54'),(27,'postUpdate',5,38,NULL,NULL,'2023-07-06 11:34:50'),(28,'commentUpdateAdmin',NULL,NULL,10,NULL,'2023-07-06 11:36:19'),(29,'commentUpdateAdmin',NULL,NULL,10,5,'2023-07-06 11:36:46');
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `ID_post` int NOT NULL AUTO_INCREMENT,
  `ID_user` int DEFAULT NULL,
  `post_date` datetime NOT NULL,
  `message` varchar(200) NOT NULL,
  `url_image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID_post`),
  KEY `woner_idx` (`ID_user`),
  CONSTRAINT `woner` FOREIGN KEY (`ID_user`) REFERENCES `users` (`ID_user`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (2,2,'2023-06-29 00:00:00','Je s\'appelles Jean-Marc',NULL),(31,2,'2023-06-29 00:00:00','Message pour tester à quoi ça ressemble',NULL),(32,2,'2023-06-29 00:00:00','Message un peu plus long pour tester à quoi ça ressemble',NULL),(38,5,'2023-07-01 02:32:19','Test de modification du message 22',''),(40,9,'2023-07-01 07:15:38','Tugdual est le meilleur chien !',NULL),(45,9,'2023-07-04 11:43:48','La photo de david','img/userUploads/64a423d6046a3.jpg'),(50,9,'2023-07-04 03:40:04','Test d\'image de modification d\'image 2','img/userUploads/64a4238b44913.jpg');
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
  `is_active` tinyint NOT NULL DEFAULT '0',
  `activation_key` varchar(255) NOT NULL,
  PRIMARY KEY (`ID_user`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `role_idx` (`ID_role`),
  CONSTRAINT `role` FOREIGN KEY (`ID_role`) REFERENCES `roles` (`ID_roles`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,2,'test@test.com','TEST','2023-06-27 00:00:00','',1,''),(2,1,'jean-marc@gmail.com','Jean-marc','2023-06-28 09:33:49','$2y$10$VovjGGdvTQW16JF7Gc0w0O7CoyIWX6PrLwl/sxV.MyEnfZH2frAA6',1,''),(5,3,'sarahkatz59@gmail.com','Sarah katz','2023-06-30 03:19:13','$2y$10$Ptj7s0gEYOGCRm0fC13j8uuhnhtot4n9Icg7D9wfr.glQkEy4estS',1,''),(6,1,'test1@test.com','Utilisateur désactivé','2023-06-30 05:08:04','$2y$10$tleczDPANCVsogYGeI/zRelCIYzRpCQhHUFuxe2HlZ7FZ8Yv.ojd6',0,''),(9,1,'ulysse.debove@gmail.com','ULYSSE DEBOVE','2023-06-30 06:52:35','$2y$10$T1RC5jEJDBB32qqCtIYWieXItPcGceAA/pmsloJcQ.qpy3Jk0sRbK',1,''),(10,1,'rfg@gmail.com','Utilisateur désactivé','2023-06-30 06:56:33','$2y$10$g9wySHYYBRmX9HPCYdOdKOzE69phoUg0Kz/nJRB7vm1F3c/31fMp2',0,''),(11,1,'Herge@gmail.com','Hergé','2023-06-30 06:58:35','$2y$10$lsy06L2nOwmc3ZUb5bAj1Oc0b2jSnkfhFVKfBdUSZj8kLoAOY1YQC',1,''),(12,1,'antoine-marc@gmail.com','Antoine Marc','2023-06-30 06:59:35','$2y$10$hOhFtQNVtJm49XPa0dDl8.4iJme3sVuLzoARpJz8OOB.0J2c44NoK',1,''),(13,1,'dfght@scdfg.com','Utilisateur désactivé','2023-06-30 07:01:14','$2y$10$KTpep.zqCeDr4wuODtpRAew5/e2tGe/hiUzyKMOtv7TGn2A8Po8ru',0,''),(14,1,'sdfeqrtg@oithdfgj.dfgiouhj','Utilisateur désactivé','2023-06-30 07:03:59','$2y$10$Oh0Ql0kUgs3x1tD4.9mpTeC2t9AcfxbGJO/WdUcugSGjW7zLEtzsO',0,''),(15,1,'xcdaazrety@kJHG.COM','Utilisateur désactivé','2023-06-30 07:04:49','$2y$10$29CYYmN/t9Dw7DbTB3N8e.g5H96zj6vYMsVXdWYdrL4VMH7ZDYIue',0,''),(16,1,'cvbgh@dfxvbdfg.fr','JUJUJU','2023-07-04 09:11:09','$2y$10$tgxO85Bb8Z8DtYTyqeKhcOc4c45iVT8z8YSjGZQZhEcrSwK4PJZp6',1,''),(20,1,'nofus59@gmail.com','mhioersg','2023-07-06 01:22:06','$2y$10$QAUsCfvObBOMg6.2Hi6VIOGDRQo65AYPPTLWlq2BLkV4.b8bSpGkG',1,'$2y$10$ZaLrtd.La3KycnqnYyDTj.QPPWRk6t3xiLXzg9kA6Tqy/7z/cxlYi'),(22,1,'samuel-denomme@hotmail.com','SAM GUEULE FORT','2023-07-06 01:33:49','$2y$10$lBXFx8lJSkG8kbfZe0bHz.5p.CgSRdyAm8oBjvQDedYSKwM9wingK',0,'$2y$10$/x9XP/3NFQ2peBFg59YCOOQWo9CAwaU64qMY83ogckYN4WXV6jBq.');
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

-- Dump completed on 2023-07-06 23:38:55
