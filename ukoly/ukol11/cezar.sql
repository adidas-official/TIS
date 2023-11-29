-- MySQL dump 10.13  Distrib 8.0.35, for Linux (x86_64)
--
-- Host: localhost    Database: cezar
-- ------------------------------------------------------
-- Server version	8.0.35

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
  `zakaznik_id` smallint NOT NULL,
  `cena` int NOT NULL,
  `datum` int NOT NULL,
  PRIMARY KEY (`id_fak`),
  KEY `zakaznik_id` (`zakaznik_id`),
  CONSTRAINT `faktura_ibfk_1` FOREIGN KEY (`zakaznik_id`) REFERENCES `zakaznik` (`id_zak`)
) ENGINE=InnoDB AUTO_INCREMENT=2023004 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faktura`
--

LOCK TABLES `faktura` WRITE;
/*!40000 ALTER TABLE `faktura` DISABLE KEYS */;
INSERT INTO `faktura` VALUES (2023001,2,140,1700766766),(2023002,1,230,1700766890),(2023003,1,159,1701108883);
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
  `zbozi_id` smallint NOT NULL,
  `pocet` smallint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `faktura_id` (`faktura_id`),
  KEY `zbozi_id` (`zbozi_id`),
  CONSTRAINT `faktura_zbozi_ibfk_1` FOREIGN KEY (`faktura_id`) REFERENCES `faktura` (`id_fak`),
  CONSTRAINT `faktura_zbozi_ibfk_2` FOREIGN KEY (`zbozi_id`) REFERENCES `zbozi` (`id_zbozi`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faktura_zbozi`
--

LOCK TABLES `faktura_zbozi` WRITE;
/*!40000 ALTER TABLE `faktura_zbozi` DISABLE KEYS */;
INSERT INTO `faktura_zbozi` VALUES (1,2023001,2,12),(2,2023001,3,5),(3,2023001,1,10),(4,2023002,2,1),(5,2023002,3,4);
/*!40000 ALTER TABLE `faktura_zbozi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zakaznik`
--

DROP TABLE IF EXISTS `zakaznik`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `zakaznik` (
  `id_zak` smallint NOT NULL AUTO_INCREMENT,
  `jmeno` varchar(32) NOT NULL,
  `email` varchar(64) NOT NULL,
  PRIMARY KEY (`id_zak`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zakaznik`
--

LOCK TABLES `zakaznik` WRITE;
/*!40000 ALTER TABLE `zakaznik` DISABLE KEYS */;
INSERT INTO `zakaznik` VALUES (1,'Toman','toman@seznam.cz'),(2,'Prusa','prusa@gmail.com'),(3,'Bohumil','bohumil@gmail.com'),(4,'Zde','a@a.a'),(5,'Lucka','lucka@gmail.com'),(6,'Alfa','alaf@gmail.com'),(7,'Beta','beta@gmail.com'),(8,'Martin','martin@seznam.cz');
/*!40000 ALTER TABLE `zakaznik` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zbozi`
--

DROP TABLE IF EXISTS `zbozi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `zbozi` (
  `id_zbozi` smallint NOT NULL AUTO_INCREMENT,
  `nazev` varchar(32) NOT NULL,
  `cena` int NOT NULL,
  PRIMARY KEY (`id_zbozi`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zbozi`
--

LOCK TABLES `zbozi` WRITE;
/*!40000 ALTER TABLE `zbozi` DISABLE KEYS */;
INSERT INTO `zbozi` VALUES (1,'savo 1L',129),(2,'zubni pasta',49),(3,'kartacek na zuby',39),(4,'Jar 1L',68),(5,'Houbicky 10ks',39),(6,'Bref power active',35),(7,'Ariel 5kg',130);
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

-- Dump completed on 2023-11-28 15:11:47