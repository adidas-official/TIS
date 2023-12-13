-- MySQL dump 10.13  Distrib 8.0.35, for Linux (x86_64)
--
-- Host: localhost    Database: cezar
-- ------------------------------------------------------
-- Server version	8.0.35-0ubuntu0.22.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `faktura`
--

DROP TABLE IF EXISTS `faktura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `faktura` (
  `id_fak` int NOT NULL AUTO_INCREMENT,
  `zakaznik_id` int NOT NULL,
  `cena_fak` int NOT NULL,
  `datum` int NOT NULL,
  PRIMARY KEY (`id_fak`),
  KEY `zakaznik_id` (`zakaznik_id`),
  CONSTRAINT `faktura_ibfk_1` FOREIGN KEY (`zakaznik_id`) REFERENCES `zakaznik` (`id_zak`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2023024 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faktura`
--

LOCK TABLES `faktura` WRITE;
/*!40000 ALTER TABLE `faktura` DISABLE KEYS */;
INSERT INTO `faktura` VALUES (2023005,1,712,1701291668),(2023009,1,3390,1701296519),(2023010,6,1976,1701462359),(2023011,3,12566,1701533690),(2023012,2,440,1701535520),(2023013,3,702,1701596406),(2023014,2,1785,1701597305),(2023020,8,253,1701621653),(2023021,8,1197,1701622128),(2023023,7,1536,1701893862);
/*!40000 ALTER TABLE `faktura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faktura_zbozi`
--

DROP TABLE IF EXISTS `faktura_zbozi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `faktura_zbozi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `faktura_id` int NOT NULL,
  `zbozi_id` int NOT NULL,
  `pocet` smallint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `faktura_id` (`faktura_id`),
  KEY `zbozi_id` (`zbozi_id`),
  CONSTRAINT `faktura_zbozi_ibfk_1` FOREIGN KEY (`faktura_id`) REFERENCES `faktura` (`id_fak`) ON DELETE CASCADE,
  CONSTRAINT `faktura_zbozi_ibfk_2` FOREIGN KEY (`zbozi_id`) REFERENCES `zbozi` (`id_zbozi`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faktura_zbozi`
--

LOCK TABLES `faktura_zbozi` WRITE;
/*!40000 ALTER TABLE `faktura_zbozi` DISABLE KEYS */;
INSERT INTO `faktura_zbozi` VALUES (35,2023005,2,4),(36,2023005,3,4),(37,2023005,6,12),(38,2023009,3,30),(39,2023009,4,15),(40,2023009,6,40),(41,2023012,2,5),(42,2023012,3,5),(45,2023010,5,9),(46,2023010,7,8),(47,2023010,8,5),(48,2023011,4,7),(49,2023011,7,12),(50,2023011,8,90),(51,2023013,5,18),(68,2023020,4,2),(69,2023020,5,3),(73,2023021,1,5),(74,2023021,4,4),(75,2023021,6,5),(76,2023021,7,1),(78,2023023,7,1),(79,2023023,8,7),(80,2023023,20,2),(81,2023023,21,1),(82,2023014,1,4),(83,2023014,7,9),(84,2023014,22,1);
/*!40000 ALTER TABLE `faktura_zbozi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role` int NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,0,'adminboss','$2y$10$eHkZziLiDdVVEbeT/5tA3OSt7xq6gu0WhuUKka3v39msFi.Rlhn3m'),(3,0,'blue','$2y$10$/fb/jeUaBD3dUcL6Q/Y6tOwoM7SVPIlE7OhVN5igYnfM.Zrjf75Uu');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zakaznik`
--

DROP TABLE IF EXISTS `zakaznik`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `zakaznik` (
  `id_zak` int NOT NULL,
  `jmeno` varchar(32) NOT NULL,
  `email` varchar(64) NOT NULL,
  PRIMARY KEY (`id_zak`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zakaznik`
--

LOCK TABLES `zakaznik` WRITE;
/*!40000 ALTER TABLE `zakaznik` DISABLE KEYS */;
INSERT INTO `zakaznik` VALUES (1,'Milan Toman','m.toman@gmail.com'),(2,'Prusa','prusa@gmail.com'),(3,'Bohumil','bohumil@seznam.cz'),(5,'Lucka','lucka@gmail.com'),(6,'Alfa','alaf@gmail.com'),(7,'Beta','beta@gmail.com'),(8,'Martin','martin@gmail.com');
/*!40000 ALTER TABLE `zakaznik` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zbozi`
--

DROP TABLE IF EXISTS `zbozi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `zbozi` (
  `id_zbozi` int NOT NULL AUTO_INCREMENT,
  `nazev` varchar(32) NOT NULL,
  `cena` int NOT NULL,
  PRIMARY KEY (`id_zbozi`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zbozi`
--

LOCK TABLES `zbozi` WRITE;
/*!40000 ALTER TABLE `zbozi` DISABLE KEYS */;
INSERT INTO `zbozi` VALUES (1,'Savo 1L',129),(2,'Pasta na zuby',49),(3,'kartacek na zuby',39),(4,'Jar 1L',68),(5,'Houbicky 10ks',39),(6,'Bref power active',30),(7,'Ariel 5kg',130),(8,'Head&amp;Shoulders',117),(17,'Katrin Uterky 100ks',199),(19,'Bref Jarni svezest 20ml',29),(20,'Sul posypova 20 kg',199),(21,'hrablo na snih 40cm',189),(22,'Bonux 20 davek 1.5 kg',99),(23,'Bonux 3v1 Polar 20 davek',120),(24,'Glade spray Citrus 300ml',52),(25,'Glade Spray Berry wine 300ml',79);
/*!40000 ALTER TABLE `zbozi` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-12-13 16:41:41
