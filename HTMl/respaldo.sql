-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: seven7
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `carrito_de_compras`
--

DROP TABLE IF EXISTS `carrito_de_compras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `carrito_de_compras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `producto_id` (`producto_id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `carrito_de_compras_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`),
  CONSTRAINT `carrito_de_compras_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`ID_USUARIO`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carrito_de_compras`
--

LOCK TABLES `carrito_de_compras` WRITE;
/*!40000 ALTER TABLE `carrito_de_compras` DISABLE KEYS */;
/*!40000 ALTER TABLE `carrito_de_compras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comprobante`
--

DROP TABLE IF EXISTS `comprobante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comprobante` (
  `ID_COMPROBANTE` int(11) NOT NULL AUTO_INCREMENT,
  `FECHA` date NOT NULL,
  `TOTAL` decimal(8,2) NOT NULL,
  `Usuario_ID` int(11) NOT NULL,
  `Productos_ID` int(11) NOT NULL,
  `estado` varchar(45) NOT NULL DEFAULT 'pendiente',
  PRIMARY KEY (`ID_COMPROBANTE`),
  KEY `Usuario_ID` (`Usuario_ID`),
  KEY `Productos_ID` (`Productos_ID`),
  CONSTRAINT `comprobante_ibfk_1` FOREIGN KEY (`Usuario_ID`) REFERENCES `usuario` (`ID_USUARIO`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comprobante`
--

LOCK TABLES `comprobante` WRITE;
/*!40000 ALTER TABLE `comprobante` DISABLE KEYS */;
INSERT INTO `comprobante` VALUES (3,'2024-06-27',100.00,17,0,'realizada'),(4,'2024-06-27',100.00,17,0,'realizada'),(5,'2024-06-27',100.00,17,0,'pendiente'),(6,'2024-06-27',55.00,14,0,'realizada'),(7,'2024-06-27',110.00,14,0,'realizada'),(8,'2024-06-29',120.00,19,0,'realizada'),(9,'2024-06-29',5.00,19,0,'pendiente'),(10,'2024-07-11',100.00,14,0,'pendiente'),(11,'2024-07-19',100.00,21,0,'pendiente'),(12,'2024-07-20',30.00,14,0,'pendiente');
/*!40000 ALTER TABLE `comprobante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comprobante_producto`
--

DROP TABLE IF EXISTS `comprobante_producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comprobante_producto` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Comprobante_ID` int(11) NOT NULL,
  `Producto_ID` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `Precio` decimal(10,2) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Comprobante_ID` (`Comprobante_ID`),
  KEY `Producto_ID` (`Producto_ID`),
  CONSTRAINT `comprobante_producto_ibfk_1` FOREIGN KEY (`Comprobante_ID`) REFERENCES `comprobante` (`ID_COMPROBANTE`) ON DELETE CASCADE,
  CONSTRAINT `comprobante_producto_ibfk_2` FOREIGN KEY (`Producto_ID`) REFERENCES `productos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comprobante_producto`
--

LOCK TABLES `comprobante_producto` WRITE;
/*!40000 ALTER TABLE `comprobante_producto` DISABLE KEYS */;
INSERT INTO `comprobante_producto` VALUES (11,10,7,2,50.00),(12,11,7,2,50.00),(13,12,12,2,15.00);
/*!40000 ALTER TABLE `comprobante_producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historial_compras`
--

DROP TABLE IF EXISTS `historial_compras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `historial_compras` (
  `ID_HISTORIAL` int(11) NOT NULL AUTO_INCREMENT,
  `FECHA` date NOT NULL,
  `TOTAL` decimal(8,2) NOT NULL,
  `Usuario_ID` int(11) NOT NULL,
  `Comprobante_ID` int(11) NOT NULL,
  PRIMARY KEY (`ID_HISTORIAL`),
  KEY `Usuario_ID` (`Usuario_ID`),
  KEY `Comprobante_ID` (`Comprobante_ID`),
  CONSTRAINT `historial_compras_ibfk_1` FOREIGN KEY (`Usuario_ID`) REFERENCES `usuario` (`ID_USUARIO`),
  CONSTRAINT `historial_compras_ibfk_2` FOREIGN KEY (`Comprobante_ID`) REFERENCES `comprobante` (`ID_COMPROBANTE`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historial_compras`
--

LOCK TABLES `historial_compras` WRITE;
/*!40000 ALTER TABLE `historial_compras` DISABLE KEYS */;
INSERT INTO `historial_compras` VALUES (1,'2024-06-27',100.00,17,4),(2,'2024-06-27',100.00,17,5),(3,'2024-06-27',55.00,14,6),(4,'2024-06-27',110.00,14,7),(5,'2024-06-29',120.00,19,8),(6,'2024-06-29',5.00,19,9),(7,'2024-07-11',100.00,14,10),(8,'2024-07-19',100.00,21,11),(9,'2024-07-20',30.00,14,12);
/*!40000 ALTER TABLE `historial_compras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `preguntas_seguridad`
--

DROP TABLE IF EXISTS `preguntas_seguridad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `preguntas_seguridad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pregunta` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `preguntas_seguridad`
--

LOCK TABLES `preguntas_seguridad` WRITE;
/*!40000 ALTER TABLE `preguntas_seguridad` DISABLE KEYS */;
INSERT INTO `preguntas_seguridad` VALUES (1,'¿Cuál es el nombre de tu primera mascota?'),(2,'¿Cuál es el nombre de la ciudad donde naciste?'),(3,'¿Cuál es tu comida favorita?');
/*!40000 ALTER TABLE `preguntas_seguridad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `cantidad` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (7,'Blazer','Chaqueta formal de traje',50.00,'blazer.png',5),(8,'Blusa Negra','Blusa negra de vestir, elegante y versátil.',60.00,'blusa.png',10),(12,'Falda Negra','Falda negra corta, elegante y moderna.',15.00,'falda negra.png',9);
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `ID_USUARIO` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(45) NOT NULL,
  `APELLIDO` varchar(45) NOT NULL,
  `EMAIL` varchar(45) NOT NULL,
  `DIRECCION` varchar(45) NOT NULL,
  `CONTRASENA` varchar(300) NOT NULL,
  `pregunta_id` int(11) NOT NULL,
  `respuesta` varchar(255) NOT NULL,
  `fecha_registro` date NOT NULL,
  PRIMARY KEY (`ID_USUARIO`),
  KEY `pregunt_id` (`pregunta_id`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`pregunta_id`) REFERENCES `preguntas_seguridad` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (14,'Jose','cedeno','josedcv290604@gmail.com','Barrio los olivos avenida 67','$2y$10$v8nYvcjIPcYMVFbo9qyeCumiKu9F9X.OopMBYYQejqVbQvUbSeN3W',1,'12','2024-06-22'),(17,'jose','david','j@gmail.com','fadsfads','$2y$10$7x2wzBLfBPhBmXhs7x3sVev4jjsPsXS/u8v2ND4TYax6Mz1nIaV4m',1,'sno','2024-06-27'),(18,'Jose','asd','h@gmail.com','Barrio los olivos av','$2y$10$N5cu8/hkGYsxIEzreSChf.OCJVoTk2LJRXLiiwMf2JlJNMXZbb4sm',1,'12','2024-06-27'),(19,'Angelica','Urdaneta','angy@gmail.com','amparo','$2y$10$1IR9l/HYEV6pHZfc9QHgpuREWuJbQtlgoHNwmbPor50ZEb3AcZfRq',3,'parrila','2024-06-29'),(20,'agelica','urdaneta','angelica@gmail.com','amparo','$2y$10$d7HUpwNYpQ8iK6aaYniFoub6.j.dK4nFZV0BNY7v9hB/9gg4zHGCy',1,'123','2024-07-08'),(21,'luis','Chacin','jj@gmail.com','Los olivos','$2y$10$2ny9HtNfQ6vrndOSGBaLGuUZj05CyxgLp3AKbITy99GV5MM.SfI1C',2,'No','2024-07-19');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-07-20 23:35:48
