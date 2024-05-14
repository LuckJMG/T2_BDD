-- MySQL dump 10.13  Distrib 8.0.35, for Linux (x86_64)
--
-- Host: localhost    Database: Tarea2
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
-- Table structure for table `Calificacion`
--

DROP TABLE IF EXISTS `Calificacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Calificacion` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `numero_habitacion` int unsigned NOT NULL,
  `fecha_checkout` date NOT NULL,
  `calificacion` tinyint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `numero_habitacion` (`numero_habitacion`),
  CONSTRAINT `Calificacion_ibfk_1` FOREIGN KEY (`numero_habitacion`) REFERENCES `Habitacion` (`numero`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Calificacion`
--

LOCK TABLES `Calificacion` WRITE;
/*!40000 ALTER TABLE `Calificacion` DISABLE KEYS */;
INSERT INTO `Calificacion` VALUES (1,1,'2024-05-19',2),(2,1,'2024-06-20',2),(3,2,'2024-05-08',5);
/*!40000 ALTER TABLE `Calificacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `CalificacionHabitacion`
--

DROP TABLE IF EXISTS `CalificacionHabitacion`;
/*!50001 DROP VIEW IF EXISTS `CalificacionHabitacion`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `CalificacionHabitacion` AS SELECT 
 1 AS `numero`,
 1 AS `tipo`,
 1 AS `fecha_checkout`,
 1 AS `calificacion`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `Cliente`
--

DROP TABLE IF EXISTS `Cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Cliente` (
  `rut` int unsigned NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  PRIMARY KEY (`rut`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Cliente`
--

LOCK TABLES `Cliente` WRITE;
/*!40000 ALTER TABLE `Cliente` DISABLE KEYS */;
INSERT INTO `Cliente` VALUES (1,'1','1'),(11020918,'Andres','Aguila'),(11111111,'Base','Datos'),(12341234,'Lucas','Mosquera'),(13134500,'Harvey','Baird'),(13180281,'Joaquin','Dominguez'),(14091554,'Alexis','Mellis'),(16390401,'Zimba','Scar'),(16514892,'Arkan','Nakra'),(16545744,'Otis','Gaete'),(20800974,'Puchito','Puchito'),(21465108,'Martin','Aseg'),(27514117,'Chester','Prit'),(28040463,'Jorge','Aceval'),(28758718,'Milo','Mosquera'),(28772172,'Lucas','Mosquera');
/*!40000 ALTER TABLE `Cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Habitacion`
--

DROP TABLE IF EXISTS `Habitacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Habitacion` (
  `numero` int unsigned NOT NULL,
  `tipo` varchar(30) NOT NULL,
  PRIMARY KEY (`numero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Habitacion`
--

LOCK TABLES `Habitacion` WRITE;
/*!40000 ALTER TABLE `Habitacion` DISABLE KEYS */;
INSERT INTO `Habitacion` VALUES (1,'Double'),(2,'King'),(3,'Single'),(4,'Double'),(5,'King'),(6,'Single'),(7,'Double'),(8,'King'),(9,'Single'),(10,'Double'),(11,'King'),(12,'Single'),(13,'Double'),(14,'King'),(15,'Single'),(16,'Double'),(17,'King'),(18,'Single'),(19,'Double'),(20,'King'),(21,'Single'),(22,'Double'),(23,'King'),(24,'Single'),(25,'Double'),(26,'King'),(27,'Single'),(28,'Double'),(29,'King'),(30,'Single'),(31,'Double'),(32,'King'),(33,'Single'),(34,'Double'),(35,'King'),(36,'Single'),(37,'Double'),(38,'King'),(39,'Single'),(40,'Double'),(41,'King'),(42,'Single'),(43,'Double'),(44,'King'),(45,'Single'),(46,'Double'),(47,'King'),(48,'Single'),(49,'Double'),(50,'King'),(51,'Single'),(52,'Double'),(53,'King'),(54,'Single'),(55,'Double'),(56,'King'),(57,'Single'),(58,'Double'),(59,'King'),(60,'Single'),(61,'Double'),(62,'King'),(63,'Single'),(64,'Double'),(65,'King'),(66,'Single'),(67,'Double'),(68,'King'),(69,'Single'),(70,'Double'),(71,'King'),(72,'Single'),(73,'Double'),(74,'King'),(75,'Single'),(76,'Double'),(77,'King'),(78,'Single'),(79,'Double'),(80,'King'),(81,'Single'),(82,'Double'),(83,'King'),(84,'Single'),(85,'Double'),(86,'King'),(87,'Single'),(88,'Double'),(89,'King'),(90,'Single'),(91,'Double'),(92,'King'),(93,'Single'),(94,'Double'),(95,'King'),(96,'Single'),(97,'Double'),(98,'King'),(99,'Single'),(100,'Double');
/*!40000 ALTER TABLE `Habitacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ReservaHabitacion`
--

DROP TABLE IF EXISTS `ReservaHabitacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ReservaHabitacion` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `rut_cliente` int unsigned NOT NULL,
  `numero_habitacion` int unsigned NOT NULL,
  `fecha_checkin` date NOT NULL,
  `fecha_checkout` date NOT NULL,
  `calificacion` tinyint DEFAULT NULL,
  `valor_total` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rut_cliente` (`rut_cliente`),
  KEY `numero_habitacion` (`numero_habitacion`),
  CONSTRAINT `ReservaHabitacion_ibfk_1` FOREIGN KEY (`rut_cliente`) REFERENCES `Cliente` (`rut`) ON DELETE CASCADE,
  CONSTRAINT `ReservaHabitacion_ibfk_2` FOREIGN KEY (`numero_habitacion`) REFERENCES `Habitacion` (`numero`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ReservaHabitacion`
--

LOCK TABLES `ReservaHabitacion` WRITE;
/*!40000 ALTER TABLE `ReservaHabitacion` DISABLE KEYS */;
INSERT INTO `ReservaHabitacion` VALUES (2,13134500,1,'2024-05-13','2024-05-19',NULL,NULL),(3,27514117,1,'2024-05-21','2024-05-23',NULL,NULL),(4,11020918,2,'2024-05-16','2024-05-29',NULL,53000),(5,14091554,3,'2024-05-22','2024-05-31',NULL,NULL),(6,13180281,10,'2024-05-17','2024-05-24',NULL,NULL),(7,28772172,13,'2024-05-22','2024-05-31',NULL,NULL),(8,20800974,69,'2024-06-04','2024-06-21',NULL,NULL),(9,28040463,100,'2024-05-21','2024-05-30',NULL,NULL),(10,16514892,69,'2024-05-16','2024-05-26',NULL,NULL),(11,28758718,12,'2024-05-16','2024-05-31',NULL,NULL),(12,16545744,85,'2024-05-16','2024-05-23',NULL,NULL),(13,16545744,57,'2024-05-14','2024-05-16',NULL,NULL),(14,16390401,24,'2024-05-25','2024-05-30',NULL,NULL),(16,21465108,5,'2024-05-15','2024-05-31',NULL,NULL);
/*!40000 ALTER TABLE `ReservaHabitacion` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `delete_reserva` BEFORE DELETE ON `ReservaHabitacion` FOR EACH ROW BEGIN
	INSERT INTO Calificacion (numero_habitacion, fecha_checkout, calificacion)
	VALUES (OLD.numero_habitacion, OLD.fecha_checkout, OLD.calificacion);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `ReservaTour`
--

DROP TABLE IF EXISTS `ReservaTour`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ReservaTour` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `id_reserva_habitacion` int unsigned NOT NULL,
  `id_tour` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_reserva_habitacion` (`id_reserva_habitacion`),
  KEY `id_tour` (`id_tour`),
  CONSTRAINT `ReservaTour_ibfk_1` FOREIGN KEY (`id_reserva_habitacion`) REFERENCES `ReservaHabitacion` (`id`),
  CONSTRAINT `ReservaTour_ibfk_2` FOREIGN KEY (`id_tour`) REFERENCES `Tour` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ReservaTour`
--

LOCK TABLES `ReservaTour` WRITE;
/*!40000 ALTER TABLE `ReservaTour` DISABLE KEYS */;
INSERT INTO `ReservaTour` VALUES (1,2,1),(2,3,1),(3,5,3),(4,7,4),(5,8,5),(6,12,5),(7,10,1),(8,14,1);
/*!40000 ALTER TABLE `ReservaTour` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Tour`
--

DROP TABLE IF EXISTS `Tour`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Tour` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `lugar` varchar(100) DEFAULT NULL,
  `transporte` varchar(30) DEFAULT NULL,
  `valor` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Tour`
--

LOCK TABLES `Tour` WRITE;
/*!40000 ALTER TABLE `Tour` DISABLE KEYS */;
INSERT INTO `Tour` VALUES (1,'1990-08-13','Puerto Montt','Caballo',2),(2,'3000-01-18','Puerto Varas','Nave Espacial',200000),(3,'2024-02-20','Frutillar','Frutimovil',10000),(4,'2025-10-30','Hornopiren','Canoa',40000),(5,'2030-12-24','Antartica','Trineo',696969);
/*!40000 ALTER TABLE `Tour` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `CalificacionHabitacion`
--

/*!50001 DROP VIEW IF EXISTS `CalificacionHabitacion`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `CalificacionHabitacion` AS select `Habitacion`.`numero` AS `numero`,`Habitacion`.`tipo` AS `tipo`,`Calificacion`.`fecha_checkout` AS `fecha_checkout`,`Calificacion`.`calificacion` AS `calificacion` from (`Calificacion` join `Habitacion` on((`Calificacion`.`numero_habitacion` = `Habitacion`.`numero`))) order by `Habitacion`.`numero` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-13 21:33:18
