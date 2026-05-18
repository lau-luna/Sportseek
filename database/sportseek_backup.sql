

-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: lautaro-luna-lautaroluna906-b4ca.h.aivencloud.com    Database: sportseek
-- ------------------------------------------------------
-- Server version	8.0.30

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
SET @MYSQLDUMP_TEMP_LOG_BIN = @@SESSION.SQL_LOG_BIN;


--
-- GTID state at the beginning of the backup 
--



--
-- Table structure for table `Carritos`
--

DROP TABLE IF EXISTS `Carritos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Carritos` (
  `ID_Carrito` int NOT NULL AUTO_INCREMENT,
  `Fecha_Creacion_Carrito` datetime NOT NULL,
  `Usuarios_ID_Usuario` int NOT NULL,
  PRIMARY KEY (`ID_Carrito`,`Usuarios_ID_Usuario`),
  KEY `fk_Carritos_Usuarios1_idx` (`Usuarios_ID_Usuario`),
  CONSTRAINT `fk_Carritos_Usuarios1` FOREIGN KEY (`Usuarios_ID_Usuario`) REFERENCES `Usuarios` (`ID_Usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Carritos`
--

LOCK TABLES `Carritos` WRITE;
/*!40000 ALTER TABLE `Carritos` DISABLE KEYS */;
INSERT INTO `Carritos` VALUES (1,'2024-08-18 21:57:44',38),(43,'2024-08-25 14:24:30',45),(47,'2024-08-28 15:49:42',36);
/*!40000 ALTER TABLE `Carritos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Carritos_Productos`
--

DROP TABLE IF EXISTS `Carritos_Productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Carritos_Productos` (
  `Carritos_ID_Carrito` int NOT NULL,
  `Productos_ID_Producto` int NOT NULL,
  `Cantidad_Productos` int NOT NULL,
  PRIMARY KEY (`Carritos_ID_Carrito`,`Productos_ID_Producto`),
  KEY `fk_Carritos_Productos_Productos1_idx` (`Productos_ID_Producto`),
  CONSTRAINT `fk_Carritos_Productos_Carritos1` FOREIGN KEY (`Carritos_ID_Carrito`) REFERENCES `Carritos` (`ID_Carrito`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_Carritos_Productos_Productos1` FOREIGN KEY (`Productos_ID_Producto`) REFERENCES `Productos` (`ID_Producto`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Carritos_Productos`
--

LOCK TABLES `Carritos_Productos` WRITE;
/*!40000 ALTER TABLE `Carritos_Productos` DISABLE KEYS */;
/*!40000 ALTER TABLE `Carritos_Productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Categorias`
--

DROP TABLE IF EXISTS `Categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Categorias` (
  `ID_Categoria` int NOT NULL AUTO_INCREMENT,
  `Nombre_Categoria` varchar(64) NOT NULL,
  `Descripcion_Categoria` varchar(1000) NOT NULL,
  PRIMARY KEY (`ID_Categoria`),
  FULLTEXT KEY `Fulltext` (`Nombre_Categoria`,`Descripcion_Categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Categorias`
--

LOCK TABLES `Categorias` WRITE;
/*!40000 ALTER TABLE `Categorias` DISABLE KEYS */;
INSERT INTO `Categorias` VALUES (10,'Alpinismo','Equipamiento esencial para enfrentar los desafíos de las montañas. Desde piolets y crampones hasta ropa técnica y seguridad.'),(11,'Ciclismo','Productos para ciclismo, incluyendo bicicletas, cascos y accesorios.'),(12,'Caza y Pesca','Equipos y accesorios para caza y pesca, incluyendo cañas y trampas.'),(13,'Fútbol','Equipos y accesorios específicos para el fútbol, incluyendo pelotas, botas, y protecciones.'),(14,'Baloncesto','Artículos para el baloncesto, como pelotas, aros, y ropa deportiva especializada.'),(15,'Tenis','Equipos y accesorios para tenis, incluyendo raquetas, pelotas, y ropa adecuada.'),(16,'Rugby','Equipos y accesorios para rugby, como pelotas, protectores y ropa específica para el deporte.'),(17,'Voley','Artículos para vóley, incluyendo pelotas, redes y ropa deportiva para la práctica del deporte.'),(18,'Accesorios','Artículos personales deportivos, como botellas o mochilas.');
/*!40000 ALTER TABLE `Categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Estados_Facturas`
--

DROP TABLE IF EXISTS `Estados_Facturas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Estados_Facturas` (
  `ID_Estados_Factura` int NOT NULL AUTO_INCREMENT,
  `Estado_Factura` varchar(15) NOT NULL,
  PRIMARY KEY (`ID_Estados_Factura`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Estados_Facturas`
--

LOCK TABLES `Estados_Facturas` WRITE;
/*!40000 ALTER TABLE `Estados_Facturas` DISABLE KEYS */;
INSERT INTO `Estados_Facturas` VALUES (1,'Pagado'),(2,'No pagado'),(3,'Cancelado');
/*!40000 ALTER TABLE `Estados_Facturas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Estados_Pedidos`
--

DROP TABLE IF EXISTS `Estados_Pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Estados_Pedidos` (
  `ID_Estado_Pedido` int NOT NULL AUTO_INCREMENT,
  `Estado_Pedido` varchar(25) NOT NULL,
  PRIMARY KEY (`ID_Estado_Pedido`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Estados_Pedidos`
--

LOCK TABLES `Estados_Pedidos` WRITE;
/*!40000 ALTER TABLE `Estados_Pedidos` DISABLE KEYS */;
INSERT INTO `Estados_Pedidos` VALUES (1,'Pendiente'),(2,'Entregado'),(3,'Cancelado');
/*!40000 ALTER TABLE `Estados_Pedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Facturas`
--

DROP TABLE IF EXISTS `Facturas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Facturas` (
  `ID_Factura` int NOT NULL AUTO_INCREMENT,
  `Fecha_Emision_Factura` datetime NOT NULL,
  `Total_Factura` float NOT NULL,
  `IVA_Factura` float NOT NULL,
  `Estados_Facturas_ID_Estados_Factura` int NOT NULL,
  `Usuarios_ID_Usuario` int NOT NULL,
  `Metodos_Pago_ID_Metodo_Pago` int DEFAULT NULL,
  `ID_Pedido` int NOT NULL,
  `ID_Usuario` int NOT NULL,
  `Nombre_Usuario` varchar(100) NOT NULL,
  `Apellidos_Usuario` varchar(100) NOT NULL,
  `DNI_Usuario` varchar(20) NOT NULL,
  `Email_Usuario` varchar(255) NOT NULL,
  `Direccion_Usuario` varchar(255) NOT NULL,
  `Telefono_Usuario` varchar(25) NOT NULL,
  `Localidad_Usuario` varchar(255) NOT NULL,
  `Provincia_Usuario` varchar(255) NOT NULL,
  `Metodo_Pago` varchar(45) NOT NULL,
  PRIMARY KEY (`ID_Factura`,`Estados_Facturas_ID_Estados_Factura`,`Usuarios_ID_Usuario`),
  KEY `fk_Facturas_Estados_Facturas1_idx` (`Estados_Facturas_ID_Estados_Factura`),
  KEY `fk_Facturas_Usuarios1_idx` (`Usuarios_ID_Usuario`),
  KEY `fk_Facturas_Metodos_Pago1_idx` (`Metodos_Pago_ID_Metodo_Pago`),
  CONSTRAINT `fk_Facturas_Estados_Facturas1` FOREIGN KEY (`Estados_Facturas_ID_Estados_Factura`) REFERENCES `Estados_Facturas` (`ID_Estados_Factura`),
  CONSTRAINT `fk_Facturas_Usuarios1` FOREIGN KEY (`Usuarios_ID_Usuario`) REFERENCES `Usuarios` (`ID_Usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Facturas`
--

LOCK TABLES `Facturas` WRITE;
/*!40000 ALTER TABLE `Facturas` DISABLE KEYS */;
INSERT INTO `Facturas` VALUES (43,'2024-08-20 20:26:29',199218,34575,1,30,2,50,30,'Lautaro Eduardo Eber','Luna','46848650','lautaroluna906@gmail.com','Sarmiento 182','3385597358','Laboulaye','Córdoba','Transferencia Bancaria'),(44,'2024-08-21 12:58:46',165769,28769.8,1,30,1,51,30,'Lautaro Eduardo Eber','Luna','46848650','lautaroluna906@gmail.com','Sarmiento 182','3385597358','Laboulaye','Córdoba','Tarjeta'),(45,'2024-08-21 16:05:23',200.04,41.999,1,30,1,56,30,'Lautaro Eduardo Eber','Luna','46848650','lautaroluna906@gmail.com','Sarmiento 182','3385597358','Laboulaye','Córdoba','Tarjeta'),(46,'2024-08-21 16:05:52',0,0,1,30,2,57,30,'Lautaro Eduardo Eber','Luna','46848650','lautaroluna906@gmail.com','Sarmiento 182','3385597358','Laboulaye','Córdoba','Transferencia Bancaria'),(47,'2024-08-21 16:11:11',42350,7350,1,36,1,58,36,'Lucio','Gómez Molina','78415113','luciogomezmolina@gmail.com','No se xd','79985135','Laboulaye','Córdoba','Tarjeta'),(48,'2024-08-21 16:11:22',120999,20999.8,1,30,2,59,30,'Lautaro Eduardo Eber','Luna','46848650','lautaroluna906@gmail.com','Sarmiento 182','3385597358','Laboulaye','Córdoba','Transferencia Bancaria'),(49,'2024-08-21 22:03:09',302499,52499.8,1,30,2,60,30,'Jefe de Ventas','Sportseek','4871231','admin@sportseek.com','Independencia 590','338551542','Laboulaye','Córdoba','Transferencia Bancaria'),(50,'2024-08-22 07:51:41',59089.1,10255.1,1,30,1,61,30,'Jefe de Ventas','Sportseek','4871231','admin@sportseek.com','Independencia 590','338551542','Laboulaye','Córdoba','Tarjeta'),(51,'2024-08-22 09:49:28',665494,115499,1,43,2,62,43,'Leon','Oviedo','46600394','oviedoleon@gmail.com','Siais 123','25187841231','Laboulaye','Córdoba','Transferencia Bancaria'),(52,'2024-08-22 14:33:20',120999,20999.8,1,30,2,63,30,'Jefe de Ventas','Sportseek','4871231','admin@sportseek.com','Independencia 590','338551542','Laboulaye','Córdoba','Transferencia Bancaria'),(53,'2024-08-22 14:41:32',604998,105000,1,30,1,64,30,'Jefe de Ventas','Sportseek','4871231','admin@sportseek.com','Independencia 590','338551542','Laboulaye','Córdoba','Tarjeta'),(54,'2024-08-22 14:59:39',665495,115499,1,30,2,65,30,'Jefe de Ventas','Sportseek','4871231','admin@sportseek.com','Independencia 590','338551542','Laboulaye','Córdoba','Transferencia Bancaria'),(55,'2024-08-22 15:09:36',258938,44939.6,1,39,1,66,39,'Enzo','Loza','46768672','enzzolozza@gmail.com','Madrid 31','54 9 3385 52-4965','Laboulaye','Córdoba','Tarjeta'),(56,'2024-08-25 14:36:07',72711.3,12619.3,1,39,3,67,39,'Enzo','Loza','46768672','enzzolozza@gmail.com','Madrid 31','54 9 3385 52-4965','Laboulaye','Córdoba','Efectivo en puntos de pago'),(57,'2024-08-26 14:13:00',10888.8,1889.79,1,36,1,68,36,'Lucio','Gómez Molina','78415113','luciogomezmolina@gmail.com','No se xd','79985135','Laboulaye','Córdoba','Tarjeta'),(58,'2024-08-28 15:48:58',94380,16380,1,36,1,69,36,'Lucio','Gómez Molina','78415113','luciogomezmolina@gmail.com','No se xd','79985135','Laboulaye','Córdoba','Tarjeta'),(59,'2024-08-28 16:12:15',133100,23100,1,30,2,70,30,'Jefe de Ventas','Sportseek','4871231','admin@sportseek.com','Independencia 590','338551542','Laboulaye','Córdoba','Transferencia Bancaria'),(60,'2024-08-28 16:59:50',137940,23940,1,30,1,71,30,'Jefe de Ventas','Sportseek','4871231','admin@sportseek.com','Independencia 590','338551542','Laboulaye','Córdoba','Tarjeta'),(61,'2024-08-28 17:07:21',338788,58797.9,1,30,2,72,30,'Jefe de Ventas','Sportseek','4871231','admin@sportseek.com','Independencia 590','338551542','Laboulaye','Córdoba','Transferencia Bancaria'),(62,'2024-08-28 17:10:02',362999,62999.8,1,30,2,73,30,'Jefe de Ventas','Sportseek','4871231','admin@sportseek.com','Independencia 590','338551542','Laboulaye','Córdoba','Transferencia Bancaria'),(63,'2024-08-28 17:11:44',245711,42644.1,1,30,1,74,30,'Jefe de Ventas','Sportseek','4871231','admin@sportseek.com','Independencia 590','338551542','Laboulaye','Córdoba','Tarjeta'),(64,'2024-08-28 17:55:15',94380,16380,1,30,1,75,30,'Jefe de Ventas','Sportseek','4871231','admin@sportseek.com','Independencia 590','338551542','Laboulaye','Córdoba','Tarjeta'),(65,'2024-08-29 16:35:59',94380,16380,1,30,2,76,30,'Jefe de Ventas','Sportseek','4871231','admin@sportseek.com','Independencia 590','338551542','Laboulaye','Córdoba','Transferencia Bancaria'),(66,'2024-09-03 19:30:09',94380,16380,1,30,1,77,30,'Jefe de Ventas','Sportseek','4871231','admin@sportseek.com','Independencia 590','338551542','Laboulaye','Córdoba','Tarjeta'),(67,'2024-09-04 15:15:15',94380,16380,1,39,1,78,39,'Enzo','Loza','46768672','enzzolozza@gmail.com','Madrid 31','54 9 3385 52-4965','Laboulaye','Córdoba','Tarjeta'),(68,'2024-09-06 09:44:56',137940,23940,1,30,2,79,30,'Jefe de Ventas','Sportseek','4871231','admin@sportseek.com','Independencia 590','338551542','Laboulaye','Córdoba','Transferencia Bancaria'),(69,'2024-09-11 13:14:49',362999,62999.8,1,30,1,80,30,'Jefe de Ventas','Sportseek','4871231','admin@sportseek.com','Independencia 590','338551542','Laboulaye','Córdoba','Tarjeta'),(70,'2024-10-28 10:07:43',66550,11550,1,30,2,81,30,'Jefe de Ventas','Sportseek','4871231','admin@sportseek.com','Independencia 590','338551542','Laboulaye','Córdoba','Transferencia Bancaria'),(71,'2024-10-28 10:09:38',133099,23099.8,1,30,2,82,30,'Jefe de Ventas','Sportseek','4871231','admin@sportseek.com','Independencia 590','338551542','Laboulaye','Córdoba','Transferencia Bancaria'),(72,'2024-10-28 10:25:44',193599,33599.8,1,30,2,83,30,'Jefe de Ventas','Sportseek','4871231','admin@sportseek.com','Independencia 590','338551542','Laboulaye','Córdoba','Transferencia Bancaria'),(73,'2024-10-28 10:37:52',47095.6,8173.62,1,30,1,84,30,'Jefe de Ventas','Sportseek','4871231','admin@sportseek.com','Independencia 590','338551542','Laboulaye','Córdoba','Tarjeta');
/*!40000 ALTER TABLE `Facturas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Facturas_Pedidos_Productos`
--

DROP TABLE IF EXISTS `Facturas_Pedidos_Productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Facturas_Pedidos_Productos` (
  `Facturas_ID_Factura` int NOT NULL,
  `Pedidos_ID_Pedido` int NOT NULL,
  `Productos_ID_Productos` int NOT NULL,
  `ID_Producto` int NOT NULL,
  `Cantidad_Productos` int NOT NULL,
  `Precio_Producto` float NOT NULL,
  `Nombre_Producto` varchar(255) NOT NULL,
  PRIMARY KEY (`Facturas_ID_Factura`,`Pedidos_ID_Pedido`,`Productos_ID_Productos`),
  KEY `fk_Estados_Productos_Productos1_idx` (`Productos_ID_Productos`),
  KEY `fk_Estados_Productos_Pedidos_idx` (`Pedidos_ID_Pedido`),
  CONSTRAINT `fk_Estados_Prodcutos_Productos` FOREIGN KEY (`Productos_ID_Productos`) REFERENCES `Productos` (`ID_Producto`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_Estados_Productos_Facturas1` FOREIGN KEY (`Facturas_ID_Factura`) REFERENCES `Facturas` (`ID_Factura`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_Estados_Productos_Pedidos` FOREIGN KEY (`Pedidos_ID_Pedido`) REFERENCES `Pedidos` (`ID_Pedido`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Facturas_Pedidos_Productos`
--

LOCK TABLES `Facturas_Pedidos_Productos` WRITE;
/*!40000 ALTER TABLE `Facturas_Pedidos_Productos` DISABLE KEYS */;
INSERT INTO `Facturas_Pedidos_Productos` VALUES (43,50,66,66,1,38922,'Pelota de Basquet Wilson Mvp Tamaño Nro 7 Basketball Balón Baloncesto'),(43,50,67,67,1,39721,'Balón Baloncesto Wilson Drv Basketball Nba N°7'),(43,50,70,70,2,43000,'Pelota de Basquet Wilson Los Angeles Lakers Nba Tributo Tamaño #7 '),(44,51,65,65,1,102999,'Adidas Unisex Ownthegame 2.0'),(44,51,73,73,2,17000,'Pelota Voley Cuero Sintetico Beach Volley Balon Mayorista'),(45,56,79,79,2,99999,'Boca Juniors Camiseta Titular 24/25'),(47,58,78,78,1,35000,'Red De Voley 9.40 X 1.00 Mts Exahome'),(48,59,79,79,1,99999,'Boca Juniors Camiseta Titular 24/25'),(49,60,43,43,1,249999,'Bicicleta de Ruta 700 KRBO XRD'),(50,61,16,16,1,9912,'Pelota de fútbol de Boca Juniors'),(50,61,66,66,1,38922,'Pelota de Basquet Wilson Mvp Tamaño Nro 7 Basketball Balón Baloncesto'),(51,62,86,86,5,109999,'Bayern Munich Camiseta Titular 24/25'),(52,63,79,79,1,99999,'Boca Juniors Camiseta Titular 24/25'),(53,64,43,43,2,249999,'Bicicleta de Ruta 700 KRBO XRD'),(54,65,21,21,1,69999,'Camiseta Retro de Alemania 1990'),(54,65,91,91,3,159999,'Pelota Adidas Argentum Pro AFA23'),(55,66,92,92,3,55000,'Chaco For Ever Tercer Camiseta 2024'),(55,66,101,101,1,8999,'Straps para Agarre Fuerte'),(55,66,102,102,1,39999,'Reloj Deportivo Digital LED SANDA 742'),(56,67,103,103,1,59999,'Chaleco con Carga 20kg Regulable'),(57,68,101,101,1,8999,'Straps para Agarre Fuerte'),(58,69,116,116,1,78000,'Argentina Voley Camiseta Suplente 2024'),(59,70,92,92,2,55000,'Chaco For Ever Tercer Camiseta 2024'),(60,71,117,117,1,114000,'Camiseta Argentina Pumas Seven Rugby Home Fan Le Coq Sportif'),(61,72,35,35,10,27999,'Kit de Boyas'),(62,73,56,56,1,299999,'Crampones de Alpinismo 12 Puntas'),(63,74,44,44,3,19999,'Casco de Ciclismo Briko Shire'),(63,74,52,52,3,47690,'Sixzero Nexo Adulto 16x19'),(64,75,116,116,1,78000,'Argentina Voley Camiseta Suplente 2024'),(65,76,116,116,1,78000,'Argentina Voley Camiseta Suplente 2024'),(66,77,116,116,1,78000,'Argentina Voley Camiseta Suplente 2024'),(67,78,116,116,1,78000,'Argentina Voley Camiseta Suplente 2024'),(68,79,117,117,1,114000,'Camiseta Argentina Pumas Seven Rugby Home Fan Le Coq Sportif'),(69,80,56,56,1,299999,'Crampones de Alpinismo 12 Puntas'),(70,81,92,92,1,55000,'Chaco For Ever Tercer Camiseta 2024'),(71,82,85,85,1,109999,'Inter Camiseta Titular 24/25'),(72,83,91,91,1,159999,'Pelota Adidas Argentum Pro AFA23'),(73,84,66,66,1,38922,'Pelota de Basquet Wilson Mvp Tamaño Nro 7 Basketball Balón Baloncesto');
/*!40000 ALTER TABLE `Facturas_Pedidos_Productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Localidades`
--

DROP TABLE IF EXISTS `Localidades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Localidades` (
  `ID_Localidades` int NOT NULL AUTO_INCREMENT,
  `Nombre_Localidad` varchar(30) NOT NULL,
  `Provincias_ID_Provincia` int NOT NULL,
  PRIMARY KEY (`ID_Localidades`,`Provincias_ID_Provincia`),
  KEY `fk_Localidades_Provincias1_idx` (`Provincias_ID_Provincia`),
  CONSTRAINT `fk_Localidades_Provincias1` FOREIGN KEY (`Provincias_ID_Provincia`) REFERENCES `Provincias` (`ID_Provincia`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Localidades`
--

LOCK TABLES `Localidades` WRITE;
/*!40000 ALTER TABLE `Localidades` DISABLE KEYS */;
INSERT INTO `Localidades` VALUES (1,'Córdoba',5),(2,'Río Cuarto',5),(3,'Villa María',5),(4,'Villa Carlos Paz',5),(5,'San Francisco',5),(6,'Bell Ville',5),(7,'La Falda',5),(8,'Cosquín',5),(9,'Morteros',5),(10,'Arroyito',5),(11,'Alta Gracia',5),(12,'Rio Segundo',5),(13,'Santa María de Punilla',5),(14,'Los Cordobeses',5),(15,'Cruz del Eje',5),(16,'La Calera',5),(17,'Despeñaderos',5),(18,'General Cabrera',5),(19,'Laboulaye',5),(20,'Villa General Belgrano',5),(21,'Alcira Gigena',5),(22,'Capilla del Monte',5),(23,'Colonia Caroya',5),(24,'Colonia Tirolesa',5),(25,'Las Varillas',5),(26,'Monte Maíz',5),(27,'San Pedro',5),(28,'Tanti',5),(29,'Villa del Rosario',5),(30,'Santa Rosa de Río Primero',5),(31,'Salsipuedes',5),(32,'El Carpio',5),(33,'Colonia Vignaud',5),(34,'Villa de Soto',5),(35,'La Palestina',5),(36,'Las Peñas',5),(37,'Pascanas',5),(38,'Santa Eufemia',5),(39,'General Deheza',5),(40,'Sicilia',5),(41,'El Tío',5),(42,'Camilo Aldao',5),(43,'Guatimozín',5),(44,'Las Perdices',5),(45,'Tío Pujio',5),(46,'General Baldissera',5),(47,'Chazón',5),(48,'Las Higueras',5),(49,'Los Molinos',5),(50,'San Marcos Sierras',5),(51,'El Paso',9),(52,'Niggacity',15),(53,'sss',5),(54,'si',9);
/*!40000 ALTER TABLE `Localidades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Metodos_Pago`
--

DROP TABLE IF EXISTS `Metodos_Pago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Metodos_Pago` (
  `ID_Metodo_Pago` int NOT NULL AUTO_INCREMENT,
  `Metodo_Pago` varchar(30) NOT NULL,
  PRIMARY KEY (`ID_Metodo_Pago`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Metodos_Pago`
--

LOCK TABLES `Metodos_Pago` WRITE;
/*!40000 ALTER TABLE `Metodos_Pago` DISABLE KEYS */;
INSERT INTO `Metodos_Pago` VALUES (1,'Tarjeta'),(2,'Transferencia Bancaria'),(3,'Efectivo en puntos de pago');
/*!40000 ALTER TABLE `Metodos_Pago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Pedidos`
--

DROP TABLE IF EXISTS `Pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Pedidos` (
  `ID_Pedido` int NOT NULL AUTO_INCREMENT,
  `Usuarios_ID_Usuario` int NOT NULL,
  `Estados_Pedidos_ID_Estado_Pedido` int NOT NULL,
  `Fecha_Pedido` datetime NOT NULL,
  `ID_Usuario` int NOT NULL,
  `Nombre_Usuario` varchar(100) NOT NULL,
  `Apellidos_Usuario` varchar(100) NOT NULL,
  `DNI_Usuario` varchar(20) NOT NULL,
  `Email_Usuario` varchar(255) NOT NULL,
  `Direccion_Usuario` varchar(255) NOT NULL,
  `Telefono_Usuario` varchar(25) NOT NULL,
  `Localidad_Usuario` varchar(255) NOT NULL,
  `Provincia_Usuario` varchar(255) NOT NULL,
  PRIMARY KEY (`ID_Pedido`,`Usuarios_ID_Usuario`,`Estados_Pedidos_ID_Estado_Pedido`),
  KEY `fk_Pedidos_Usuarios1_idx` (`Usuarios_ID_Usuario`),
  KEY `fk_Pedidos_Estados_Pedidos1_idx` (`Estados_Pedidos_ID_Estado_Pedido`),
  CONSTRAINT `fk_Pedidos_Estados_Pedidos1` FOREIGN KEY (`Estados_Pedidos_ID_Estado_Pedido`) REFERENCES `Estados_Pedidos` (`ID_Estado_Pedido`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_Pedidos_Usuarios1` FOREIGN KEY (`Usuarios_ID_Usuario`) REFERENCES `Usuarios` (`ID_Usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Pedidos`
--

LOCK TABLES `Pedidos` WRITE;
/*!40000 ALTER TABLE `Pedidos` DISABLE KEYS */;
INSERT INTO `Pedidos` VALUES (50,30,3,'2024-08-20 20:26:29',30,'Lautaro Eduardo Eber','Luna','46848650','lautaroluna906@gmail.com','Sarmiento 182','3385597358','Laboulaye','Córdoba'),(51,30,1,'2024-08-21 12:58:46',30,'Lautaro Eduardo Eber','Luna','46848650','lautaroluna906@gmail.com','Sarmiento 182','3385597358','Laboulaye','Córdoba'),(52,30,1,'2024-08-21 15:58:23',30,'Lautaro Eduardo Eber','Luna','46848650','lautaroluna906@gmail.com','Sarmiento 182','3385597358','Laboulaye','Córdoba'),(53,30,1,'2024-08-21 15:58:38',30,'Lautaro Eduardo Eber','Luna','46848650','lautaroluna906@gmail.com','Sarmiento 182','3385597358','Laboulaye','Córdoba'),(54,30,1,'2024-08-21 16:01:05',30,'Lautaro Eduardo Eber','Luna','46848650','lautaroluna906@gmail.com','Sarmiento 182','3385597358','Laboulaye','Córdoba'),(55,30,1,'2024-08-21 16:01:07',30,'Lautaro Eduardo Eber','Luna','46848650','lautaroluna906@gmail.com','Sarmiento 182','3385597358','Laboulaye','Córdoba'),(56,30,1,'2024-08-21 16:05:23',30,'Lautaro Eduardo Eber','Luna','46848650','lautaroluna906@gmail.com','Sarmiento 182','3385597358','Laboulaye','Córdoba'),(57,30,1,'2024-08-21 16:05:52',30,'Lautaro Eduardo Eber','Luna','46848650','lautaroluna906@gmail.com','Sarmiento 182','3385597358','Laboulaye','Córdoba'),(58,36,2,'2024-08-21 16:11:11',36,'Lucio','Gómez Molina','78415113','luciogomezmolina@gmail.com','No se xd','79985135','Laboulaye','Córdoba'),(59,30,1,'2024-08-21 16:11:22',30,'Lautaro Eduardo Eber','Luna','46848650','lautaroluna906@gmail.com','Sarmiento 182','3385597358','Laboulaye','Córdoba'),(60,30,1,'2024-08-21 22:03:09',30,'Jefe de Ventas','Sportseek','4871231','admin@sportseek.com','Independencia 590','338551542','Laboulaye','Córdoba'),(61,30,2,'2024-08-22 07:51:41',30,'Jefe de Ventas','Sportseek','4871231','admin@sportseek.com','Independencia 590','338551542','Laboulaye','Córdoba'),(62,43,2,'2024-08-22 09:49:28',43,'Leon','Oviedo','46600394','oviedoleon@gmail.com','Siais 123','25187841231','Laboulaye','Córdoba'),(63,30,1,'2024-08-22 14:33:20',30,'Jefe de Ventas','Sportseek','4871231','admin@sportseek.com','Independencia 590','338551542','Laboulaye','Córdoba'),(64,30,1,'2024-08-22 14:41:32',30,'Jefe de Ventas','Sportseek','4871231','admin@sportseek.com','Independencia 590','338551542','Laboulaye','Córdoba'),(65,30,1,'2024-08-22 14:59:39',30,'Jefe de Ventas','Sportseek','4871231','admin@sportseek.com','Independencia 590','338551542','Laboulaye','Córdoba'),(66,39,1,'2024-08-22 15:09:36',39,'Enzo','Loza','46768672','enzzolozza@gmail.com','Madrid 31','54 9 3385 52-4965','Laboulaye','Córdoba'),(67,39,1,'2024-08-25 14:36:07',39,'Enzo','Loza','46768672','enzzolozza@gmail.com','Madrid 31','54 9 3385 52-4965','Laboulaye','Córdoba'),(68,36,1,'2024-08-26 14:13:00',36,'Lucio','Gómez Molina','78415113','luciogomezmolina@gmail.com','No se xd','79985135','Laboulaye','Córdoba'),(69,36,2,'2024-08-28 15:48:58',36,'Lucio','Gómez Molina','78415113','luciogomezmolina@gmail.com','No se xd','79985135','Laboulaye','Córdoba'),(70,30,1,'2024-08-28 16:12:15',30,'Jefe de Ventas','Sportseek','4871231','admin@sportseek.com','Independencia 590','338551542','Laboulaye','Córdoba'),(71,30,1,'2024-08-28 16:59:50',30,'Jefe de Ventas','Sportseek','4871231','admin@sportseek.com','Independencia 590','338551542','Laboulaye','Córdoba'),(72,30,1,'2024-08-28 17:07:21',30,'Jefe de Ventas','Sportseek','4871231','admin@sportseek.com','Independencia 590','338551542','Laboulaye','Córdoba'),(73,30,1,'2024-08-28 17:10:02',30,'Jefe de Ventas','Sportseek','4871231','admin@sportseek.com','Independencia 590','338551542','Laboulaye','Córdoba'),(74,30,1,'2024-08-28 17:11:44',30,'Jefe de Ventas','Sportseek','4871231','admin@sportseek.com','Independencia 590','338551542','Laboulaye','Córdoba'),(75,30,1,'2024-08-28 17:55:15',30,'Jefe de Ventas','Sportseek','4871231','admin@sportseek.com','Independencia 590','338551542','Laboulaye','Córdoba'),(76,30,1,'2024-08-29 16:35:59',30,'Jefe de Ventas','Sportseek','4871231','admin@sportseek.com','Independencia 590','338551542','Laboulaye','Córdoba'),(77,30,1,'2024-09-03 19:30:09',30,'Jefe de Ventas','Sportseek','4871231','admin@sportseek.com','Independencia 590','338551542','Laboulaye','Córdoba'),(78,39,1,'2024-09-04 15:15:15',39,'Enzo','Loza','46768672','enzzolozza@gmail.com','Madrid 31','54 9 3385 52-4965','Laboulaye','Córdoba'),(79,30,1,'2024-09-06 09:44:56',30,'Jefe de Ventas','Sportseek','4871231','admin@sportseek.com','Independencia 590','338551542','Laboulaye','Córdoba'),(80,30,1,'2024-09-11 13:14:49',30,'Jefe de Ventas','Sportseek','4871231','admin@sportseek.com','Independencia 590','338551542','Laboulaye','Córdoba'),(81,30,1,'2024-10-28 10:07:43',30,'Jefe de Ventas','Sportseek','4871231','admin@sportseek.com','Independencia 590','338551542','Laboulaye','Córdoba'),(82,30,1,'2024-10-28 10:09:38',30,'Jefe de Ventas','Sportseek','4871231','admin@sportseek.com','Independencia 590','338551542','Laboulaye','Córdoba'),(83,30,1,'2024-10-28 10:25:44',30,'Jefe de Ventas','Sportseek','4871231','admin@sportseek.com','Independencia 590','338551542','Laboulaye','Córdoba'),(84,30,1,'2024-10-28 10:37:52',30,'Jefe de Ventas','Sportseek','4871231','admin@sportseek.com','Independencia 590','338551542','Laboulaye','Córdoba');
/*!40000 ALTER TABLE `Pedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Pedidos_Productos`
--

DROP TABLE IF EXISTS `Pedidos_Productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Pedidos_Productos` (
  `Pedidos_ID_Pedido` int NOT NULL,
  `Productos_ID_Productos` int NOT NULL,
  `Cantidad_Productos` int NOT NULL,
  PRIMARY KEY (`Pedidos_ID_Pedido`,`Productos_ID_Productos`),
  KEY `fk_Pedidos_Productos_Pedidos1_idx` (`Pedidos_ID_Pedido`),
  KEY `fk_Pedidos_Productos_Productos1_idx` (`Productos_ID_Productos`),
  CONSTRAINT `fk_Pedidos_Productos_Pedidos1` FOREIGN KEY (`Pedidos_ID_Pedido`) REFERENCES `Pedidos` (`ID_Pedido`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_Pedidos_Productos_Productos1` FOREIGN KEY (`Productos_ID_Productos`) REFERENCES `Productos` (`ID_Producto`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Pedidos_Productos`
--

LOCK TABLES `Pedidos_Productos` WRITE;
/*!40000 ALTER TABLE `Pedidos_Productos` DISABLE KEYS */;
/*!40000 ALTER TABLE `Pedidos_Productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Productos`
--

DROP TABLE IF EXISTS `Productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Productos` (
  `ID_Producto` int NOT NULL AUTO_INCREMENT,
  `Nombre_Producto` varchar(255) NOT NULL,
  `Precio_Producto` float NOT NULL,
  `Descripcion_Producto` text NOT NULL,
  `Tiene_Stock_Producto` tinyint NOT NULL,
  `Imagen_Producto` varchar(255) DEFAULT NULL,
  `Especificaciones_Producto` text,
  `Categorias_ID_Categoria` int DEFAULT NULL,
  PRIMARY KEY (`ID_Producto`),
  KEY `fk_Productos_Categorias1_idx` (`Categorias_ID_Categoria`),
  FULLTEXT KEY `Nombre_Producto` (`Nombre_Producto`,`Descripcion_Producto`,`Especificaciones_Producto`),
  FULLTEXT KEY `Nombre_Producto_2` (`Nombre_Producto`,`Descripcion_Producto`,`Especificaciones_Producto`),
  FULLTEXT KEY `Nombre_Producto_FullText` (`Nombre_Producto`),
  FULLTEXT KEY `Productos_FullText` (`Nombre_Producto`,`Descripcion_Producto`,`Especificaciones_Producto`),
  FULLTEXT KEY `Productos_FullText_Search` (`Nombre_Producto`,`Descripcion_Producto`,`Especificaciones_Producto`),
  CONSTRAINT `fk_Productos_Categorias` FOREIGN KEY (`Categorias_ID_Categoria`) REFERENCES `Categorias` (`ID_Categoria`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Productos`
--

LOCK TABLES `Productos` WRITE;
/*!40000 ALTER TABLE `Productos` DISABLE KEYS */;
INSERT INTO `Productos` VALUES (15,'Pelota de fútbol de River Plate',10999,'Pelota oficial con el diseño distintivo del Club Atlético River Plate, ideal para entrenamientos y partidos, con un acabado duradero y excelente control.',1,'1724070816_pelota_futbolRiver.jpg','Pelota oficial con diseño del Club Atlético River Plate, tamaño 5, fabricada con cubierta de PU para durabilidad y mejor control. Cuenta con una cámara de aire butílica para una excelente retención del aire. Ideal para entrenamientos y partidos en césped natural o sintético, con un diámetro de aproximadamente 22 cm y un peso de 420-450 gramos.',13),(16,'Pelota de fútbol de Boca Juniors',9912,'Pelota oficial con el diseño distintivo del Club Atlético Boca Juniors, ideal para entrenamientos y partidos, con un acabado duradero y excelente control.',1,'1724071300_pelota_futbolBoca.jpg','Pelota oficial con diseño del Club Atlético Boca Juniors, tamaño 5, fabricada con cubierta de PU para durabilidad y mejor control. Cuenta con una cámara de aire butílica para una excelente retención del aire. Ideal para entrenamientos y partidos en césped natural o sintético, con un diámetro de aproximadamente 22 cm y un peso de 420-450 gramos',13),(17,'Botines Penalty Lider XX Campo',15999,'Botines de fútbol en gris oscuro con detalles celestes, combinando durabilidad y confort. Suela con excelente tracción para césped natural y sintético, con un diseño moderno y elegante',1,'1724071740_botines_futbolCeleste.jpg','Botines de fútbol en gris oscuro con detalles celestes, fabricados con materiales sintéticos de alta durabilidad. Suela con tacos distribuidos para una tracción óptima en césped natural y sintético. Tamaño estándar disponible en número 43. Cierre de cordones para un ajuste seguro, con un peso aproximado de 250 gramos por botín.',13),(18,'Pelota de fútbol de Manchester City',10999,'Pelota oficial con el diseño distintivo del Manchester City, ideal para entrenamientos y partidos, con un acabado duradero y excelente control.',0,'1724072028_pelota_futbolCity.jpg','Pelota oficial con diseño del Club Atlético Manchester City, tamaño 5, fabricada con cubierta de PU para durabilidad y mejor control. Cuenta con una cámara de aire butílica para una excelente retención del aire. Ideal para entrenamientos y partidos en césped natural o sintético, con un diámetro de aproximadamente 22 cm y un peso de 420-450 gramos.',13),(19,'Pelota de fútbol DRB Flash N5',13499,'Pelota de fútbol N5 básica en color rojo y blanco de la marca DRB, ideal para entrenamientos y juegos recreativos. ',1,'1724072244_pelota_futbolNormal.jpg','Fabricada con cubierta de PVC resistente y una cámara de aire para mantener la forma. Tamaño 5, con un diámetro de aproximadamente 22 cm y un peso de 410-430 gramos. Diseño sencillo y funcional para una buena visibilidad y rendimiento en el campo.',13),(20,'Botines Under Armour Magnetico Select 3.0 FG',18999,'Botines de fútbol color rosa fuerte de la marca Under Armour, combinando durabilidad y confort. Suela con excelente tracción para césped natural y sintético, con un diseño moderno y elegante.',1,'1724072474_botines_futbolRosa.jpg','Botines de fútbol color rosa fuerte, fabricados con materiales sintéticos de alta durabilidad. Suela con tacos distribuidos para una tracción óptima en césped natural y sintético. Tamaño estándar disponible en número 43. Cierre de cordones para un ajuste seguro, con un peso aproximado de 250 gramos por botín.	',13),(21,'Camiseta Retro de Alemania 1990',69999,'Camiseta clásica de fútbol de Alemania de 1990, con el diseño icónico de la época. Fabricada en material transpirable, presenta los colores nacionales y el escudo en el pecho, representando el estilo retro del equipo.',1,'1724072746_camiseta_Alemania1990.jpg','Camiseta de poliéster transpirable en blanco con detalles en negro, rojo y amarillo. Incluye el escudo de la selección alemana en el pecho, disponible en tamaño L. Corte ajustado, con diseño retro representativo del año 1990.',13),(22,'Camiseta de River Suplente 2018/2019',91218,'Camiseta morada con detalles en blanco, inspirada en el diseño suplente de la temporada 2018/2019. Con el escudo de River Plate y un estilo moderno, es perfecta para mostrar tu apoyo al equipo.',1,'1724073446_camiseta_RiverSuplente2018.jpg','Camiseta de poliéster transpirable en morado con detalles en blanco. Incluye el escudo de River Plate en el pecho. Disponible en tamaño L, con un corte moderno y ajuste cómodo, representando el diseño suplente de la temporada 2018/2019.',13),(23,'Camiseta Titular Boca Juniors 2018/2019',69999,'Camiseta oficial titular de Boca Juniors para la temporada 2018/2019. Con el clásico color azul y franja amarilla, refleja el orgullo xeneize con un diseño elegante y moderno, ideal tanto para hinchas como para jugadores.',1,'1724088570_camiseta_futbolBoca.jpg','Camiseta de poliéster transpirable en color azul con la clásica franja amarilla en el pecho. Incluye el escudo de Boca Juniors bordado en el lado izquierdo del pecho y el logo del patrocinador en el frente. Disponible en talla L, con un corte cómodo y moderno. Representa la temporada 2018/2019.',13),(24,'Canilleras de Futbol Negras',14999,'Canilleras negras diseñadas para proteger las espinillas durante el juego, combinando comodidad y seguridad. Su diseño ergonómico se ajusta perfectamente a la pierna, proporcionando una excelente absorción de impactos.',1,'1724089206_canillerasfutbol_Negro.jpg','Canilleras fabricadas con plástico resistente y acolchado interior de espuma para mayor comodidad y absorción de impactos. Pesan aproximadamente 200 gramos por par, con una altura de 20 cm y un ancho de 8 cm (tamaño M), con correas elásticas ajustables para un ajuste seguro. Ideales para proteger las espinillas en partidos y entrenamientos.',13),(25,'Canilleras de Futbol San Lorenzo Niños',6999,'Canilleras oficiales de San Lorenzo con escudo del club, diseñadas para brindar protección y comodidad. Con correas ajustables y acolchado interior, son perfectas para partidos y entrenamientos.',1,'1724089707_canillerafutbol_SanLorenzo.jpg','Canilleras oficiales de San Lorenzo para niños, diseñadas para ofrecer protección y comodidad en el campo de juego. Fabricadas con plástico resistente y acolchado interior de espuma, presentan el escudo del club en la parte frontal. Pesan aproximadamente 200 gramos por par, con una altura de 12 cm y un ancho de 5 cm (tamaño S). Cuentan con correas elásticas ajustables para un ajuste seguro y ergonómico. Ideales para entrenamientos y partidos, brindando protección efectiva en cada jugada.',13),(26,'Medias Largas para Futbol',4999,'Medias largas de fútbol en color negro, diseñadas para brindar comodidad y sujeción durante el juego. Fabricadas con material elástico y transpirable, ideales para entrenamientos y partidos.',1,'1724090324_mediasfutbol_Negra.png','Medias largas de fútbol fabricadas con una mezcla de materiales elásticos y transpirables, proporcionando ajuste cómodo y soporte adecuado. En color negro, con una altura que cubre hasta la rodilla. Disponible en talla M. Ideales para entrenamientos y partidos, manteniendo los pies secos y cómodos durante el juego.',13),(27,'Short de Futbol Negro',5999,'Short de fútbol en color negro, diseñado para ofrecer comodidad y libertad de movimiento en el campo. Fabricado con material ligero y transpirable, ideal para entrenamientos y partidos.',1,'1724090698_shortfutbol_Negro.jpg','Short de fútbol en color negro, hecho de material ligero y transpirable que garantiza comodidad y ventilación. Disponible en talla M, con cintura elástica y cordón ajustable. Ideal para entrenamientos y partidos, proporcionando libertad de movimiento y durabilidad.',13),(28,'Caña de Pescar Negra 1.80m',24999,'Caña de pescar de color negra, diseñada para ofrecer precisión y durabilidad en cada lanzamiento. Fabricada con materiales resistentes y ligeros, es ideal para una variedad de técnicas de pesca, proporcionando un rendimiento confiable en el agua.',1,'1724091881_cañapesca_Negra.png','Caña de pescar en color negro, fabricada con material de fibra de carbono para ligereza y resistencia. Longitud de 1.80 metros, con acción rápida y capacidad de carga de hasta 10-20 lb. Equipado con anillas de guía de acero inoxidable y mango ergonómico para un agarre cómodo. Ideal para pesca en agua dulce y salada.',12),(29,'Caña de Pesca Caster Karp Hunter 3.90m',109999,'Caña de pescar de color negra, diseñada para ofrecer precisión y durabilidad en cada lanzamiento. Fabricada con materiales resistentes y ligeros, es ideal para una variedad de técnicas de pesca, proporcionando un rendimiento confiable en el agua.',1,'1724332450_1724093362_cañapescar_´Potente.jpg','Caña de pescar en color negro, peso aproximado de 160g, fabricada con material de fibra de carbono para ligereza y resistencia. Con acción rápida y capacidad de carga de hasta 20 y 50 kg. Equipado con anillas de guía de acero inoxidable y mango ergonómico para un agarre cómodo. Ideal para pesca en agua dulce y salada.',12),(30,'Pelota De Rugby Nº 5 Gilbert Modelo Uar',76000,'Experimenta el rugby con la Pelota Gilbert Nº 5, oficial de la Unión Argentina de Rugby (UAR). Diseñada para máximo rendimiento y durabilidad, ofrece un agarre superior para un control preciso. Ideal para entrenamientos y partidos, es la elección perfecta para jugadores de todos los niveles.\r\n\r\n\r\n\r\n\r\n\r\n\r\n',1,'1724093219_images.jpeg','Superficie de goma de alta calidad para mejor agarre y control. Pelota réplica oficial de la UAR.',16),(31,'Pelota De Rugby N° 3 Gilbert Mod G-tr3000',46000,'La pelota esencial para completar tus entrenamientos\r\n\r\nCon tecnología de agarre TRI\r\n\r\nSuperficie de goma duradera para mejorar el manejo de los jugadores y desarrollar con precisión las habilidades esenciales.',1,'1724093746_pelota-rugby-gilbert-tr300.jpg','La Pelota de Rugby Nº 3 Gilbert G-TR3000 es ideal para categorías juveniles, diseñada tanto para entrenamiento como para juego recreativo. Fabricada con una superficie de caucho sintético, ofrece gran durabilidad y un agarre superior gracias a su textura granulada. Con costura a mano para mayor resistencia y una cámara interna de látex de alta calidad que asegura una excelente retención del aire, esta pelota combina rendimiento y longevidad, perfecta para jóvenes jugadores que buscan mejorar sus habilidades en el rugby.',16),(32,'Kit de 1000 Anzuelos',24999,'Kit de anzuelos variado, ideal para diferentes técnicas de pesca. Incluye anzuelos de varios tamaños, fabricados en acero inoxidable de alta calidad para mayor durabilidad y resistencia a la corrosión.',1,'1724093921_anzuelospesca_Kit.jpg','Kit de anzuelos con variedad de tamaños (desde #6 hasta #12), fabricados en acero inoxidable de alta calidad. Incluye aproximadamente 1000 anzuelos en total, presentados en una caja de plástico resistente con compartimentos para organización. Cada anzuelo cuenta con una punta afilada para una mejor penetración y resistencia a la corrosión, adecuado para diferentes tipos de pesca.',12),(33,'Pelota De Rugby Nº 4 Striker',48028,'Eleva tu juego con la Pelota de Rugby Nº 4 Striker, diseñada para jóvenes jugadores que buscan mejorar sus habilidades. Confeccionada con materiales duraderos, esta pelota ofrece una combinación ideal de resistencia y rendimiento. Su tamaño Nº 4 es perfecto para categorías menores, mientras que su textura asegura un agarre firme, permitiendo un control preciso en cada jugada. Ideal para entrenamientos y partidos recreativos, la Pelota Striker es una excelente elección para desarrollar técnica y confianza en el campo.',1,'1724094085_pelota-de-rugby-striker-cosida-n-4.jpg','La Pelota de Rugby Nº 4 Striker, ideal para categorías menores, está hecha de caucho sintético duradero y cuenta con una superficie texturizada para un agarre superior. Cosida a mano y con cámara interna de látex para una óptima retención del aire, es perfecta para entrenamientos y juegos recreativos, ofreciendo rendimiento y resistencia.',16),(34,'Protector Bucal Gilbert Anatomic Senior Saborizado ',6000,'El Protector Bucal Gilbert Anatomic Senior Saborizado es la elección ideal para los deportistas adultos que buscan protección y comodidad durante la práctica de deportes de contacto. Este innovador protector bucal, diseñado específicamente para rugby, hockey, fútbol, básquet, handball y artes marciales, se adapta perfectamente a la forma de la boca gracias a su capacidad de moldearse al calor. Fabricado en silicona de alta calidad, garantiza una experiencia de uso cómoda y segura. Además, su saborizado añade un toque agradable, haciendo que su uso sea más placentero. Viene en un práctico blister con estuche para un almacenamiento seguro y fácil transporte. Con la marca Gilbert, reconocida por su compromiso con la calidad, este protector bucal es un accesorio esencial para cualquier atleta que desee maximizar su rendimiento sin comprometer su seguridad. ¡Prepárate para dar lo mejor de ti en cada partido!',1,'1724094606_Protector Bucal Gilbert Anatomic Senior Saborizado.webp','El Protector Bucal Gilbert Anatomic Senior ofrece una protección avanzada y un ajuste preciso, diseñado para adultos y adolescentes. Con una forma anatómica para un confort óptimo, este protector cuenta con un atractivo sabor a frambuesa que mejora la experiencia de uso. Su diseño en color negro combina estilo y funcionalidad, proporcionando seguridad y comodidad durante el juego o el entrenamiento. Ideal para quienes buscan proteger sus dientes sin sacrificar el confort.',16),(35,'Kit de Boyas',27999,'Kit de boyas de pesca que incluye una variedad de tipos y tamaños. Fabricadas en materiales flotantes de alta visibilidad, ideales para detectar picaduras con precisión.',1,'1724095065_pescaboyas_Kit (1).png','El kit contiene aproximadamente +10 boyas, cada una con un diseño duradero y un peso adecuado para distintos tipos de pesca. Viene en una caja de plástico con compartimentos para un almacenamiento organizado y fácil acceso',12),(36,'Botines Rugby Gilbert Sidestep X15 8 Tapones ',131990,'BOTINES GILBERT SIDESTEP X15 LO 8ST\r\n\r\n¿Estás buscando las botas de rugby de 8 tacos nuevas con la mejor relación calidad-precio del mercado?\r\n\r\nBienvenido al Sidestep X15. Nuestro botín más popular durante varias temporadas, el Sidestep ahora le da la bienvenida al X15 a su legado. Una bota naturalmente ancha, la Sidestep X15 combina una potencia impresionante con un rendimiento máximo.\r\n\r\nCon la estabilidad y la tracción que te brindan estas botas, te sorprenderá lo livianas que son. Perfectas para los 5 delanteros delanteros o las bestias de la fila trasera, estamos seguros de que esta es una de las botas de rugby con la mejor relación calidad-precio que encontrarás.\r\n',1,'1724095084_botines rugby.webp','Los Botines Rugby Gilbert Sidestep X15 están diseñados con 8 tapones intercambiables para un agarre superior y estabilidad. Su estructura ligera y material duradero garantizan confort y resistencia en el campo. Ideal para jugadores que buscan rendimiento y tracción en diversas superficies.\r\n\r\n\r\n\r\n\r\n\r\n\r\n',16),(37,'Lineas de Pesca x3',6999,'Combo de tres lineas de Pesca',1,'1724095670_pescalineas_Kit.png','Línea de pesca de fluorocarbono con un diámetro de 0.30 mm y capacidad de carga de 6-8 kg. Longitud de 150 metros por carrete, con alta resistencia a la abrasión y baja visibilidad en el agua. Ideal para pesca en agua dulce y salada, proporcionando una combinación óptima de fuerza y flexibilidad. Viene en una bobina de plástico para un almacenamiento fácil y ordenado.',12),(38,'Botines Rugby Gilbert Cage Pro Pace 6 Stud Aluminio Original',242250,'Los Botines Rugby Gilbert Sidestep X15 están diseñados para ofrecer un rendimiento superior en el campo. Equipados con 8 tapones intercambiables, proporcionan un agarre excepcional y estabilidad en diversas superficies. Su estructura ligera y duradera, fabricada con capellada de PVC y poliuretano, junto con un forro de poliéster y poliuretano, asegura un ajuste cómodo y un soporte óptimo para el pie. La suela de poliuretano añade resistencia y tracción. Disponibles en varios colores, estos botines importados de la marca Gilbert son ideales para jugadores que buscan una combinación de confort, durabilidad y rendimiento en cada partido.\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n',1,'1724096276_botines rugby 2.webp','ESPECIFICACIONES\r\n- Presentamos el botín de rugby Cage Pace Pro, la cúspide del calzado de alto rendimiento desarrollada exclusivamente para jugadores de rugby.\r\n- Diseñados pensando en los jugadores de rugby, el botines de rugby Cage Pace Pro establecen un nuevo estándar de excelencia en la cancha.\r\n- Diseñado pensando en la excelencia, este el botín combina tecnología de vanguardia y una artesanía inigualable para brindar la mejor experiencia de juego.\r\n- Su construcción superior garantiza estabilidad durante los movimientos rápidos, permitiéndote sobresalir en cada situación de juego.',16),(39,'Kit de 275 Señuelos',35999,'Kit de señuelos variado, ideal para atraer diferentes tipos de peces. Incluye una selección de señuelos de diversos tamaños, colores y estilos, diseñados para imitar movimientos y colores naturales de presas.',1,'1724332329_1724096169_pescaseñuelos_Kit.jpg','Kit que incluye aproximadamente 275 señuelos de distintos tamaños, colores y estilos. Fabricados con materiales duraderos para imitar movimientos y colores naturales. Viene en una caja de plástico con compartimentos para almacenamiento ordenado y fácil acceso. Ideal para diversas técnicas y condiciones de pesca.',12),(40,'Tubo Pelota Pelotitas Tenis Dunlop X 3 Unidades Atp',16673,'Las pelotas de tenis Dunlop ATP Extra Duty, en formato pack de 3 unidades, son ideales para entrenamiento en canchas rápidas y lentas. Con un diámetro de 6.6 cm y un color amarillo distintivo, vienen en un práctico tubo de envase. Perfectas para jugadores que buscan calidad y durabilidad en cada sesión.',1,'1724096589_pelota de tenis.webp','\r\nLas pelotas están fabricadas en caucho y fieltro, presentadas en un tubo presurizado cerrado herméticamente que contiene 3 pelotas. Cada pelota cuenta con un núcleo central y un tejido de fieltro de alta resistencia, recubierta en caucho con fieltro de alta duración, resistente al agua. Ideal para un rendimiento duradero y confiable.',15),(41,'Motor electrico para Bote',349999,'Motor eléctrico compacto y eficiente, diseñado para ofrecer potencia silenciosa y control preciso en embarcaciones.',1,'1724096557_pescamotor_Electrico.jpg','Motor eléctrico con 55 libras de empuje, adecuado para botes pequeños y medianos. Incluye una batería recargable de 12V con duración extendida. Ofrece control de velocidad variable y un sistema de montaje ajustable para adaptarse a diferentes tipos de embarcaciones. Fabricado con materiales resistentes al agua y a la corrosión, ideal para navegación en agua dulce y salada.',12),(42,'Bicicleta de Montaña Rodada 26 Adulto Mercurio',199999,'Ideal para terrenos accidentados, con cuadro resistente, suspensión delantera y frenos de disco, ofreciendo control y seguridad en cada aventura.',1,'1724137540_bicicletamotaña_Negra.jpg','Cuenta con un cuadro de acero reforzado y suspensión delantera de 100 mm, perfecta para terrenos difíciles. Equipada con 21 velocidades Shimano, frenos de disco mecánico delantero y trasero, y llantas todo terreno de 26\" x 2.25\" con doble pared, ofrece excelente control y seguridad. Su manubrio de aluminio (680 mm), sillín ergonómico ajustable y pedales antideslizantes garantizan comodidad y estabilidad. Con un peso de 14.5 kg, está disponible en color azul.',11),(43,'Bicicleta de Ruta 700 KRBO XRD',249999,'Diseñada para la velocidad y el rendimiento en carretera, con un cuadro ligero, 14 velocidades y frenos de precisión, ideal para ciclistas que buscan eficiencia y comodidad en largas distancias.',1,'1724137954_bicicletaruta_Negra.jpg','Cuenta con un cuadro de aluminio ultraligero y horquilla de carbono para máxima agilidad. Ofrece 16 velocidades con cambios Shimano Claris, frenos de caliper de aluminio y llantas de alta presión 700 x 25C. Su manillar drop bar de 420 mm y sillín deportivo ajustable proporcionan una postura aerodinámica. Con transmisión 50/34T, pedales clipless y un peso de solo 9.2 kg, es perfecta para ciclistas de carretera que buscan eficiencia. Disponible gris oscuro.',11),(44,'Casco de Ciclismo Briko Shire',19999,'Ligero y aerodinámico, este casco ofrece máxima protección con su estructura de EPS y carcasa de ABS. Ventilación óptima con múltiples orificios y ajuste preciso mediante sistema de dial, garantiza comodidad y seguridad en cada ruta.',1,'1724138364_cascocliclismo_Amarillo.jpg','Fabricado con carcasa de ABS y núcleo de EPS, este casco combina protección y ligereza (250 g). Cuenta con 20 orificios de ventilación para una óptima circulación de aire y un sistema de ajuste con dial regulable para un ajuste preciso. La hebilla de ajuste rápido facilita su colocación. Disponible en tamaño M y color negro con amarillo. Cumple con las certificaciones CE y CPSC.',11),(45,'Casco Bicicleta para Niño Dragón Color Celeste ',17999,'Diseñado para pequeños ciclistas, este casco color celeste combina seguridad y diversión con su diseño de dragón. Con estructura de EPS y carcasa de ABS, ofrece protección confiable y un ajuste seguro con sistema de dial.',1,'1724138858_cascociclismo_Niño (1).png','Este casco para niños presenta una carcasa de ABS y núcleo de EPS para una protección segura. Viene con un sistema de ajuste regulable mediante dial, garantizando un ajuste preciso. Dispone de 15 orificios de ventilación para mantener la cabeza fresca y una hebilla de liberación rápida para facilidad de uso. El casco pesa 220 g y está disponible en color celeste con un diseño divertido de dragón. Cumple con las certificaciones CE y CPSC para una seguridad adicional.',11),(46,'Luz Delantera para Bicicleta',12999,'Esta luz delantera ofrece visibilidad superior en condiciones de poca luz. Resistente al agua e impactos, incluye modos ajustables (alta, baja y parpadeante) y se monta fácilmente en el manillar. Recargable por USB.',1,'1724139282_luzciclismo_Delantera.jpg','LED de 300 lúmenes con modos alta, baja y parpadeante. Resistente al agua e impactos, se monta fácilmente en el manillar. Recargable por USB con una duración de batería de hasta 6 horas y un tiempo de carga de 2 horas. Pesa 150 g y está disponible en negro.',11),(47,'Kit Rodilleras y Coderas Ciclismo',69999,'Protege tus articulaciones con este kit esencial para ciclistas. Incluye rodilleras y coderas con una estructura ergonómica y acolchada, diseñadas para absorber impactos y ofrecer máxima comodidad.',1,'1724139610_rodilleracoderaciclismo_Kit.jpg','Fabricado en nylon y espuma EVA acolchada, este kit ofrece protección ergonómica y transpirable con almohadillas reforzadas para absorber impactos. Incluye correas de velcro ajustables para un ajuste personalizado en talla M. Resistente al desgaste y disponible en negro, el kit pesa 300 g en total.',11),(48,'Maillot de Ciclismo para Hombre',49999,'Diseñado para ofrecer comodidad y rendimiento en cada ruta, este maillot de ciclismo cuenta con una tela ligera y transpirable que regula la temperatura y absorbe la humedad.',1,'1724139952_maillotciclismo_Hombre.jpg','Fabricado en poliéster ligero y transpirable, este maillot ofrece un corte aerodinámico y elástico para una comodidad óptima. Cuenta con una cremallera frontal completa, tres bolsillos traseros y detalles reflectantes para mayor visibilidad. Las mangas raglán aseguran libertad de movimiento. Disponible en tallas L, y en colores negro, rojo, azul y verde. Peso: 200 g.',11),(49,'2 Llantas de Bicicleta para Repuesto',29999,'Estas llantas de repuesto están diseñadas para ofrecer un rendimiento duradero y confiable en todo tipo de terrenos.',1,'1724140337_llantasciclismo_Repuesto.jpg','Llantas para bicicletas de montaña (26\") y carretera (700C), fabricadas en caucho butílico de alta resistencia. Ancho de 2.25\" para MTB y 25 mm para carretera. Compatibles con válvulas Schrader (MTB) y Presta (carretera). Pesan 500 g (MTB) y 300 g (carretera), con resistencia a pinchazos y mayor durabilidad. Disponibles en color negro.',11),(50,'Raqueta Tenis Wilson River Plate 103 279 Gr Cuerd Funda Anti',108758,'Wilson y River Plate se unen en una colaboración para celebrar la pasión que une todos los deportes. La raqueta RIVER PLATE 103 es una raqueta fusionada de grafito y aluminio, ideal para aquellos fanáticos de River que se estén iniciando en el Tenis. Les dará un empuje extra para disfrutar de practicar y mejorar en este hermoso deporte.\r\n\r\n',1,'1724180622_raqueta1.webp','El modelo WR075710H River Plate 103 cuenta con un aro de 103 cm² y un peso sin encordar de 279 g. Su longitud es de 27\" (68.58 cm) y presenta un equilibrio de 33.5 cm (2 pts HL). El patrón de encordado es 16x19, y su sección es de 23 mm con diseño U Beam de 2 – 3\".\r\n\r\n',15),(51,'Raqueta De Tenis Annezi Team 88 Titanium',50000,'La raqueta Annezi Team 88 Titanium es ideal para jugadores intermedios que desean mejorar su rendimiento. Con un balance de 33 cm y un peso de 285 g, ofrece un equilibrio entre potencia y control. Fabricada en grafito fusionado, es duradera y tiene un tamaño de cabeza de 102 pulgadas, facilitando un área de golpeo amplia. Su patrón de encordado 16x19 permite precisión y efectos en los golpes. Incluye una funda para protección.',1,'1724180778_raqueta2.webp','La raqueta Annezi Team 88, de la línea Avanzados, es ideal para jugadores de tenis. Con un tamaño de cabeza de 102 pulgadas y un largo de 27 pulgadas, ofrece un equilibrio perfecto con un balance de 33 cm. Fabricada en grafito fusionado, pesa 285 g y cuenta con un patrón de encordado de 16 x 19. El grip es de tamaño 4 3/8, y su color es amarillo.',15),(52,'Sixzero Nexo Adulto 16x19',47690,'Con la Raqueta Nexo de SixZero, sacá tu máximo rendimiento en entrenamientos y partidos. Esta raqueta de gama media-alta es perfecta para aquellos jugadores aficionados que deseen comenzar a entrenar mas duro. Fabricada con una alaeación de grafito y aluminio, la raqueta teien un peso ideal para este tipo de jugadores. El producto viene encordado, e incluye una funda con cierre y correa regulable, ideal para guardar y transportar tu raqueta a todos lados.',1,'1724180934_raqueta3.webp','La raqueta Sixzero Nexo de la línea Adulto es perfecta para tenis, con un tamaño de cabeza de 677 cm² y un largo de 68.8 cm. Fabricada en aleación de grafito y aluminio, pesa 290 g y presenta un patrón de encordado de 16 x 19. Su color es amarillo, blanco y verde.',15),(53,'Piolet de Alpinismo para Hielo',299999,'Ideal para escaladores y alpinistas, este piolet combina resistencia y precisión.',1,'1724141005_alpinismopiolet_Hielo.jpg','Piolet de aleación de aluminio y acero con hoja afilada para una penetración eficiente en hielo. Mango ergonómico para un agarre cómodo y seguro. Longitud total de 60 cm, peso de 700 g. Incluye protector de hoja y correa de muñeca ajustable. Ideal para escalada en hielo.',10),(54,'Gorra De Visera Para Sol Mujer Hombre Golf Tenis Protección',51309,'Gorra De Visera Para Hombre Golf Tenis Protección Libre Playa Gorra Deportiva\r\nDescripción:\r\n\r\nHecho de material algodón de alta calidad, que es muy transpirable, duradero y ligero.\r\nSe utiliza para proteger contra las quemaduras solares y los rayos, una gran gorra de verano para exteriores.\r\nLa correa adhesiva ajustable en la parte posterior del sombrero hace que se la mayoría de las personas, tanto adultos como niños.\r\nModa y práctica, fácil de combinar con tus diferentes atuendos\r\nfina artesanía., no tiene puntos de salto y múltiples líneas.\r\n',1,'1724181277_gorratenis.webp','La gorra deportiva está confeccionada en algodón, ofreciendo comodidad y transpirabilidad. Su borde tiene una longitud de 8 cm y la circunferencia de la tapa es ajustable, con un rango de 55 cm para un ajuste personalizado.\r\n\r\nEl paquete incluye: 1 gorra deportiva.',15),(55,'Piolet de Alpinismo para Montaña',399999,'Perfecto para alpinistas y escaladores, este piolet de montaña está diseñado para ofrecer durabilidad y rendimiento en terrenos mixtos. Su hoja de acero resistente y el mango ergonómico aseguran un agarre seguro y una eficacia superior en terrenos de roca y nieve. Ideal para ascensos técnicos y descensos controlados.',1,'1724141255_alpinismopiolet_Montaña.jpg','Piolet con hoja de acero inoxidable y mango de aleación de aluminio. Longitud total de 65 cm y peso de 750 g. Incluye protector de hoja y correa de muñeca ajustable. Diseñado para escalada en roca y nieve, con un diseño equilibrado para un uso versátil y efectivo.',10),(56,'Crampones de Alpinismo 12 Puntas',299999,'Diseñados para proporcionar una tracción segura en superficies de hielo y nieve, estos crampones de color azul ofrecen un ajuste perfecto y estabilidad en cada paso.',1,'1724141497_alpinismocrampon_Azul.jpg','Crampones de acero inoxidable con 12 puntas afiladas. Tamaño ajustable para botas de talla 36 a 46. Sistema de fijación de correas y cierres de liberación rápida. Peso de 800 g (par). Incluye bolsa de transporte. Ideal para escalada en hielo.',10),(57,'Crampones Antideslizantes 21 Dientes Acero',59999,'Perfectos para ofrecer estabilidad en superficies resbaladizas, estos crampones antideslizantes proporcionan una tracción segura en hielo y nieve. Aseguran un ajuste firme sobre diferentes tipos de calzado.',1,'1724141826_alpinismocrampon_Antideslizante.jpg','Tamaño ajustable para adaptarse a la mayoría de botas de montaña (tallas 36 a 46). Sistema de ajuste con correas elásticas para un ajuste rápido y seguro. Peso de 400 g (par). Incluye bolsa de almacenamiento. Ideal para caminatas en condiciones resbaladizas y trekking ligero.',10),(58,'Arnés para Escalada y Alpinismo Ajustable',119000,'Diseñado para ofrecer comodidad y seguridad en tus actividades al aire libre, este arnés ajustable se adapta a diferentes tamaños y tipos de cuerpo. Con su estructura robusta y acolchada, proporciona un ajuste seguro y una distribución uniforme del peso, ideal para escalada y alpinismo.',1,'1724142223_alpinismoarnes_Ajustable.jpg','Arnés ajustable con correas de nylon acolchadas y hebillas de liberación rápida. Tamaño ajustable para cinturas de 70 a 110 cm y muslos de 50 a 75 cm. Equipado con 4 bucles para material y un anillo de seguridad en la parte trasera. Peso de 500 g. Incluye bolsa de transporte. Ideal para escalada en roca, alpinismo y uso general en montañismo.',10),(59,'Mosquetón Automatico Con Doble Traba para Arnés',14999,'Este mosquetón automático con doble traba ofrece una seguridad superior en tus actividades de escalada y alpinismo. Diseñado para evitar aperturas accidentales, su mecanismo de bloqueo automático asegura un cierre firme y confiable. Ideal para asegurar cuerdas, anclajes y equipos.',1,'1724142801_alpinismomosqueton_Doble (1).png','Mosquetón de aluminio de alta resistencia con mecanismo automático de doble traba. Capacidad de carga de 25 kN. Tamaño compacto y ligero, con peso de 80 g. Incluye una apertura de 20 mm y un diseño ergonómico para un manejo fácil. Cumple con normas internacionales de seguridad (CE y UIAA). Ideal para escalada, alpinismo y montañismo.',10),(61,'Zapatillas De Baloncesto Trend High Top [u]',162114,'La marca BTOP presenta su modelo de zapato deportivo, diseñado sin género y dirigido a adultos. Este calzado cuenta con un ajuste de cordones y un estilo deportivo, ideal para la práctica de tenis y otros deportes similares. Su construcción incluye materiales exteriores de tela, interiores de malla y una suela de caucho, sin utilizar materiales reciclados. Es una opción destacada para quienes buscan comodidad y funcionalidad en sus actividades deportivas.',1,'1724182981_zapatillasbasket.webp','Las características generales del calzado genérico modelo \"generic\" versión Grid incluyen una marca genérica y están diseñadas para hombres adultos con un ancho estándar. Este calzado no utiliza materiales reciclados y presenta un diseño geométrico en la tela. El ajuste es con cordones y la caña es corta. Es recomendado para el uso en basketball y cuenta con tecnologías de calzado como IMEVA, SoftFoam y SoftFoam+. Los materiales incluyen tejido en el exterior, tela en el interior, plástico en la suela, espuma en las plantillas y goma EVA junto con poliuretano en la mediasuela.',14),(62,'Cuerda Soga 11mm X 20mts Homologada',39999,'Esta cuerda de rescate de 11 mm de diámetro y 20 metros de longitud está diseñada para ofrecer una alta resistencia y fiabilidad en situaciones críticas.',1,'1724143144_alpinismosoga (1).png','Cuerda de rescate de 11 mm de diámetro y 20 metros de longitud. Fabricada en nylon de alta resistencia, con resistencia a la abrasión y estiramiento mínimo. Capacidad de carga de 30 kN. Homologada según normas internacionales (CE y UIAA). Peso de 2.5 kg. Ideal para rescates, escalada técnica y alpinismo.',10),(63,'Air Jordan 6 Aqua',359999,'Las Air Jordan 6 Aqua son unas zapatillas unisex que combinan estilo y rendimiento con el icónico diseño de Jordan. Con un atractivo colorido y un diseño moderno, estas zapatillas destacan tanto en el campo de juego como en la moda urbana. La combinación de materiales de alta calidad y tecnología avanzada garantiza comodidad y soporte durante todo el día, mientras que el diseño audaz asegura que tu estilo sea siempre el centro de atención.',1,'1724183363_air jordan 6 aqua.webp','Las Air Jordan 6 Aqua son zapatillas unisex con un diseño moderno en color Aqua. Confeccionadas en cuero y sintético, ofrecen comodidad con su interior de malla y una suela de caucho duradero. La mediasuela cuenta con espuma y una unidad Air-Sole en el talón para amortiguación. Tienen ajuste de cordones, caña media y son ideales para uso diario, moda urbana y deportes ligeros. Destacan por sus detalles distintivos y el logotipo Jumpman.',14),(64,'Guantes de Alpinismo y Montañas',49500,'Diseñados para ofrecer protección y agarre en condiciones extremas, estos guantes de alpinismo combinan aislamiento térmico con resistencia al agua.',1,'1724143449_alpinismoguantes.jpg','Guantes de alpinismo con exterior de nylon resistente al agua y forro de aislamiento térmico. Palma y dedos reforzados con material antideslizante para mejor agarre. Ajuste de muñeca con correa elástica y cierre de velcro. Tamaño disponible: L. Peso de 300 g (par). Incluyen inserciones de material de refuerzo en áreas críticas y son ideales para escalada en hielo y alpinismo.',10),(65,'Adidas Unisex Ownthegame 2.0',103000,'Zapatillas Adidas Ownthegame 2.0 Lightmotion Mid\r\nDomina cualquier duela\r\nEntrega el 101% de tu actitud en cada práctica y partido de básquetbol con las adidas OwnTheGame 2.0 Lightmotion. Ideales para cualquier terreno, ya sea la clásica duela o las retas en el cemento.',1,'1724183628_Adidas Unisex Ownthegame 2.0.png','Este calzado para baloncesto, diseñado por adidas, tiene una construcción de mallas y materiales sintéticos. Esto les brindan una mayor durabilidad y resistencia. Podrás ajustarlos sencillamente en tus pies, gracias a sus agujetas y lengüeta. Cuentan con la tecnología Lighmotion en la suela que está hecha de goma. Esto te brindarán pisadas extra suaves, brincos altos y una gran tracción, sin importar la superficie.',14),(66,'Pelota de Basquet Wilson Mvp Tamaño Nro 7 Basketball Balón Baloncesto',38922,'MVP de la NCAA está fabricada con goma de alta calidad, lo que proporciona horas de juego. El compuesto de goma de primera calidad ofrece una excelente durabilidad y los canales superanchos permiten un mayor agarre. Funda para todas las superficies para un mejor agarre.',1,'1724183785_Pelota de Basquet Wilson Mvp Tamaño Nro 7 Basketball Balón Baloncesto.webp','La pelota de baloncesto Wilson MVP All Surface Cover 7, utilizada en la NCAA, está fabricada con goma de alta calidad para una durabilidad excepcional y horas de juego continuo. Su compuesto de goma superior proporciona una resistencia prolongada y los canales superanchos mejoran el agarre en todas las superficies. La carcasa de primera calidad asegura una excelente retención del aire y resistencia al desgaste. Las características principales incluyen composición en caucho, tamaño oficial número 7, una circunferencia aproximada de 75 cm y un peso aproximado de 550 g.',14),(67,'Balón Baloncesto Wilson Drv Basketball Nba N°7',39999,'La Pelota de Baloncesto Wilson NBA N°7 es ideal para jugadores serios que buscan calidad en canchas interiores y exteriores. Con una circunferencia de 75 cm, este balón tamaño 7 ofrece durabilidad y un tacto suave gracias a su construcción en cuero de alta calidad. La cámara de butilo asegura una retención de aire superior y un rebote consistente. Con un diseño elegante en gris y el logotipo de la NBA, combina un aspecto profesional con un rendimiento superior, perfecto para mejorar tu técnica o disfrutar de juegos recreativos.',1,'1724184062_Balón Baloncesto Wilson Drv Basketball Nba N°7.webp','La pelota de baloncesto Wilson NBA DRV 6, tamaño 7, está diseñada para canchas interiores y exteriores. De color gris, está fabricada en goma con una cámara de butilo para una retención de aire superior. Con un peso de 570 g y una circunferencia de 28.5 cm, es ideal para entrenamiento y recreación. La pelota no viene inflada.',14),(68,'Zapatilla Topper Vr Speed 2',49999,'Ideal para corredores y deportistas, esta zapatilla ofrece una combinación de ligereza y soporte. Con una suela de alta tracción y una plantilla acolchada, proporciona comodidad y estabilidad en cada paso.',1,'1724144005_calzado1 (1).png','Zapatilla con parte superior de malla transpirable y refuerzos sintéticos. Suela de goma de alta tracción para mejor agarre en diversas superficies. Plantilla acolchada y entresuela de EVA para amortiguación. Cierre con cordones para ajuste personalizado. Peso de 250 g (por zapato, tamaño 42). Disponible en talla 42. Ideal para entrenamiento y carreras en superficies duras.',NULL),(69,'Zapatillas Escolar Blanco/negro Talle 39',35500,'Ideal para corredores y deportistas, esta zapatilla ofrece una combinación de ligereza y soporte. Con una suela de alta tracción y una plantilla acolchada, proporciona comodidad y estabilidad en cada paso.',1,'1724144448_calzado2 (1).png','Zapatilla con parte superior de malla transpirable y refuerzos sintéticos. Suela de goma de alta tracción para mejor agarre en diversas superficies. Plantilla acolchada y entresuela de EVA para amortiguación. Cierre con cordones para ajuste personalizado. Peso de 250 g (por zapato, tamaño 39). Disponible en talla 39. Ideal para entrenamiento y carreras en superficies duras.',NULL),(70,'Pelota de Basquet Wilson Los Angeles Lakers Nba Tributo Tamaño #7 ',43000,'Mantente leal con el baloncesto Wilson NBA Team Tribute. La portada presenta un patrón alterno de los colores primarios y secundarios de su equipo en sus paneles de superficie con el logotipo del equipo exhibido de manera destacada en la portada. La cubierta Performance está diseñada para enfrentarse a cualquier cancha que elijas, construida con un agarre duradero para superficies rugosas.\r\n\r\nTamaño N7, recomendado para adultos y jugadores de 12 años en adelante.\r\nPeso: 510 - 567 gramos\r\nCircunferencia: 29,5 pulgadas (75 cm)\r\nComposición: Caucho (PU) muy duradero y resistente a la deformación.',1,'1724184896_wilson violeta-negro.webp','La pelota de baloncesto Wilson NBA TEAM TRIBUTE LAKERS, modelo Los Angeles Lakers, tamaño 7, es adecuada para canchas interiores y exteriores. Presenta un diseño en negro, violeta y amarillo, fabricada en goma con una cámara de butilo para una óptima retención de aire. Con un peso de 580 g, una circunferencia de 29.5 cm y 8 paneles, es ideal para entrenamiento. La pelota no viene inflada.',14),(71,'Zapatillas Topper Fast Azul Dusty',60000,'Ideal para corredores y deportistas, esta zapatilla ofrece una combinación de ligereza y soporte. Con una suela de alta tracción y una plantilla acolchada, proporciona comodidad y estabilidad en cada paso.',0,'1724144711_calzado3 (1).png','Zapatilla con parte superior de malla transpirable y refuerzos sintéticos. Suela de goma de alta tracción para mejor agarre en diversas superficies. Plantilla acolchada y entresuela de EVA para amortiguación. Cierre con cordones para ajuste personalizado. Peso de 250 g (por zapato, tamaño 37). Disponible en talla 37. Ideal para entrenamiento y carreras en superficies duras.',NULL),(72,'Zapatillas Topper Kham Con Suela De Goma',64000,'Ideal para corredores y deportistas, esta zapatilla ofrece una combinación de ligereza y soporte. Con una suela de alta tracción y una plantilla acolchada, proporciona comodidad y estabilidad en cada paso.',1,'1724144949_calzado4 (1).png','Zapatilla con parte superior de malla transpirable y refuerzos sintéticos. Suela de goma de alta tracción para mejor agarre en diversas superficies. Plantilla acolchada y entresuela de EVA para amortiguación. Cierre con cordones para ajuste personalizado. Peso de 250 g (por zapato, tamaño 36). Disponible en talla 36. Ideal para entrenamiento y carreras en superficies duras.',NULL),(73,'Pelota Voley Cuero Sintetico Beach Volley Balon Mayorista',17000,'Descubre la Pelota de Voley Kadur Touch, ideal para tus partidos de beach volley. Esta pelota de vóley termo sellada está fabricada con cuero sintético de alta calidad, lo que garantiza durabilidad y un excelente rendimiento en cada juego. Su costura pegada y termo sellada asegura una mayor resistencia y un uso prolongado. Diseñada para superficies de arena, césped sintético y parqué, esta pelota es versátil y perfecta para cualquier entorno. Con un tamaño 5 y un peso aproximado entre 260 y 290 gramos, ofrece un manejo óptimo y un control excepcional. La cámara de látex proporciona una excelente retención de aire. Marca Kadur, producto nacional de confianza. ¡Lleva tu juego al siguiente nivel con la Pelota de Voley Kadur Touch!',1,'1724186855_Pelota Voley Cuero Sintetico Beach Volley Balon Mayorista.webp','La pelota de voleibol Kadur Beach Voley está diseñada para jugar en playa y destaca por su material de cuero sintético y costura pegada. Su color blanco, amarillo y azul la hace llamativa y fácil de ver. Con un tamaño 5 y un peso de 260 g, ofrece una excelente experiencia de juego. La cámara de látex asegura una buena retención de aire.',17),(74,'Pelota Voley Wilson Graffiti Peace Pvc',40000,'La \'Pelota Voley Wilson Graffiti Peace PVC Entrenamiento\' es ideal para los entusiastas del voleibol. Con un diseño moderno en blanco y violeta y fabricada en PVC duradero, ofrece una larga vida útil. Esta pelota, recomendada para entrenamiento, destaca por su costura a máquina que asegura un rebote consistente y una forma perfecta. Con una circunferencia de 66 cm y tamaño 5, es adecuada para jugadores de todas las edades y todo tipo de canchas. La cámara de butilo mantiene la presión del aire, garantizando un juego fluido. La marca Wilson respalda su calidad y desempeño.',1,'1724261322_Pelota Voley Wilson Graffiti Peace Pvc.webp','La pelota de voleibol Wilson GRAFFITI PEACE destaca por sus características superiores. Está fabricada en PVC y cuenta con una superficie sintética, ideal para entrenamiento. Su diseño en blanco y violeta no solo es estético, sino que también mejora la visibilidad durante el juego. La pelota tiene una circunferencia de 66 cm, un tamaño 5 y un peso de 175 g. Su costura a máquina garantiza un rendimiento consistente, mientras que la cámara de butilo mantiene la presión del aire para un juego fluido.\r\n\r\n\r\n\r\n\r\n',17),(75,'Balón Wilson De Volleyball Castaway',39900,'La pelota de voleibol Wilson Balón de Volleyball Castaway es ideal para entrenamiento, con un diseño en blanco y una construcción de cuero artificial. Su costura a máquina garantiza durabilidad y un rendimiento consistente. La pelota tiene una circunferencia de 66 cm y es del tamaño 5, con una cámara de butilo que mantiene la presión del aire. Ya inflada, está lista para usarse de inmediato. Su peso es de 0 kg.',1,'1724261705_wilsoon.webp','\r\nLa pelota de voleibol Wilson Balón de Volleyball Castaway está diseñada para entrenamiento y presenta un color blanco atractivo. Fabricada con cuero artificial y cosida a máquina, ofrece durabilidad y un rendimiento fiable. Con una circunferencia de 66 cm y tamaño 5, es adecuada para prácticas de voleibol. Su cámara de butilo mantiene la presión del aire de manera eficiente. La pelota ya está inflada y lista para usar. Su peso es de 0 kg.',17),(76,'Zapatillas Basquet Finders Accurate Origi Voley Handball Nba',80000,'\r\nDiseño clásico que proporciona ligereza, sujeción confiable a través del piso de óptimo grip y el estabilizador trasero y una caña media alta, cómoda y firme. Plantilla anatómica de gran confort',1,'1724262097_zapatillas voley.webp','La zapatilla Finders BODY GUARD, diseñada para adultos, es adecuada para jugar al vóley. Tiene un ancho estándar y no utiliza materiales reciclados. Su diseño incluye cordones para un ajuste seguro. Las especificaciones incluyen un exterior y un interior de tela, y una suela de caucho.',17),(77,'Rodilleras De Voley Nassau Acolchonadas Cover ',15000,'Las rodilleras de voley Nassau Cover ofrecen una protección superior y una comodidad excepcional, ideales para deportes jugados en interiores. Con un diseño acolchado, estas rodilleras están diseñadas para amortiguar y proteger tus rodillas durante los movimientos intensos y caídas que son comunes en el voleibol. Su ajuste ergonómico asegura que se mantengan en su lugar mientras te mueves, permitiéndote concentrarte en el juego sin distracciones.',1,'1724262613_RODILLERAS VOLEY.webp','La rodillera deportiva Nassau Cover, en talle S, está fabricada en lycra con una composición de 50% poliéster, 22% poliuretano y 28% elástico. Tiene un espesor de 10 mm y es respirable, aunque no es articulada ni cuenta con correas ajustables o protección rígida externa. Es apta para lavarropas.',17),(78,'Red De Voley 9.40 X 1.00 Mts Exahome',35000,'\r\nLa red de vóley presenta las siguientes características: mide 9.40 x 1 metro y cuenta con una malla de 15 x 15 cm. Está fabricada con hilo de polietileno de 2.5 mm y tiene protección UV para mayor durabilidad. El color de la red es negro y dispone de una banda superior de lona vinílica blanca. No incluye sogas de sujeción.',1,'1724262805_RED DE VOLEY.webp','La red de vóley mide 9.40 x 1 metro, tiene una malla de 15 x 15 cm y está hecha de hilo de polietileno de 2.5 mm con protección UV. El color de la red es negro, con una banda superior de lona vinílica blanca. No incluye sogas de sujeción.',17),(79,'Boca Juniors Camiseta Titular 24/25',99999,'La nueva camiseta oficial irradia la pasión boquense y la conexión con el barrio. Inspirada en el tren cuyo recorrido bordea La Bombonera. Boca, una pasión que se lleva desde la cuna.Esta nueva camiseta titular de Boca Juniors adidas une la pasión y el barrio con diferentes tonos que resaltan sus colores, el azul y oro. Un diseño innovador para un equipo en constante evolución, inspirado en el icónico tren que bordea La Bombonera. Su tejido ligero, los modernos paneles de mesh y la tecnología de absorción AEROREADY se combinan para mantener cómodos a los hinchas del club.',1,'1724264494_bocajuniors.png','•Corte clásico\r\n•Cuello en V acanalado\r\n•Tejido piqué 100 % poliéster reciclado\r\n•Tecnología de absorción AEROREADY\r\n•Paneles de mesh bajo los brazos',13),(80,'River Plate Tercer Camiseta 24/25',99999,'Esta camiseta está inspirada en el famoso equipo de “La Máquina” de los años 40, y toma su color tanto de las fotografías analógicas de la época como también de la locomotora que está ubicada en el Museo River para homenajear a dicha legendaria formación riverplatense.\r\nCreada para envolver a los hinchas del equipo en comodidad, esta camiseta incorpora tecnología de absorción AEROREADY y un escudo tejido premium.',1,'1724264684_riverplate.png','•Ajuste clásico.\r\n•Cuello redondo acanalado.\r\n•Tejido entrelazado 100% poliéster reciclado.\r\n•AEROREADY.\r\n•Paneles de malla bajo los brazos.\r\n•Puños acanalados.\r\n•Escudo de River Plate tejido.\r\n•\"1901\" en la parte posterior del cuello.',13),(85,'Inter Camiseta Titular 24/25',109999,'Al igual que otras camisetas de la colección Stadium, este modelo combina detalles de diseño que imitan los del equipo con un tejido que capilariza el sudor para ofrecer un look pensado para jugar e inspirado en tu equipo favorito.',1,'1724265449_inter.png','Color mostrado: Lyon Blue/Negro/Lyon Blue/Blanco\r\nModelo: FN8787-440',13),(86,'Bayern Munich Camiseta Titular 24/25',109999,'El clásico diseño a rayas de la primera equipación con un toque inesperado. Esta camiseta de fútbol adidas del FC Bayern presenta un diseño con tres tonos de rojo y pequeños detalles adiamantados que le confieren el sello inconfundible del equipo germano. Diseñada para que animes con comodidad y orgullo a tus jugadores favoritos, presenta un tejido transpirable AEROREADY que mantiene la piel seca y luce el escudo del club bordado. Este producto se ha fabricado con un 100% de materiales reciclados. Utilizando materiales reciclados, reducimos los residuos, nuestra dependencia de los recursos finitos y la huella que generan los productos que fabricamos.',1,'1724286997_bayern.jpg.png','Marca: adidas\r\nPaís de origen: Camboya\r\nHierro frío si es necesario\r\nNo secar en secadora\r\nLavado a máquina en agua fría\r\nLavar el rives separadmente o con colores similares\r\nAEROREADY\r\nCorte ceñido\r\nLogotipo bordado\r\nCuello de pico de canalé\r\nJersey Color Style: Home\r\nCon licencia oficial',13),(87,'Argentina Camiseta Titular 24/25',99999,'Vestite como un campeón! La camiseta titular de Argentina. A lo largo de la historia del fútbol, la Albiceleste ha representado un juego y compromiso incomparables. Diseñada para hinchas, ofrece comodidad en todo momento gracias a su tejido suave con tecnología de absorción AEROREADY. La insignia de campeón del Mundo y la tercera estrella sobre el escudo confirman una victoria memorable.\r\nHecho con materiales reciclados, este producto representa solo una de nuestras soluciones para ayudar a acabar con los residuos plásticos.',1,'1724287543_argentina.png','Género: Hombre\r\nMaterial Principal: Poliéster\r\nTipo De Camiseta: Titular\r\nDisciplina: Fútbol\r\nVersión De la Camiseta: Aficionado\r\nClubes: AFA\r\nEs Para Arquero: No\r\nColores: Celeste\r\nTipo De Ocasión: Partido\r\nTipo de Equipo: Selección\r\nModelo: IP8400',13),(88,'Argentina Camiseta Titular 2024 “HOMENAJE ATENAS 2004”',60000,'Tecnología N E O D R Y que transporta la humedad al exterior de la prenda manteniendo tu piel seca y fresca.\r\n100% Poliester.',1,'1724287980_argentinabasquet.png','Peso: 0.5 kg\r\nDimensiones:	40 × 30 × 8 cm\r\nTalle:	\r\nXS, S, M, L, XL, 2XL, 3XL, 4XL, 5XL',14),(89,'Boca Juniors Camiseta Basquet Titular 23/24',60000,'Esta nueva camiseta titular de básquet de Boca Juniors adidas une la pasión y el barrio con diferentes tonos que logran un efecto visual y una prominente franja central que resaltan sus colores, el azul y oro. Un diseño innovador para un equipo en constante evolución. Hecho con materiales 100% reciclados, este producto representa solo una de nuestras soluciones para acabar con los residuos plásticos.',1,'1724288173_bocabasquet.png','Instrucciones de lavado\r\nNo usar blanqueador\r\nNo utillizar secadora\r\nNo lavar en seco.\r\nPlanchar a temperatura baja.\r\nLavar a máquina en temperatura fría.\r\n\r\nInformación adicional sobre el cuidado\r\nNo usar suavizante\r\nRetirar inmediatamente\r\nLavar y planchar al revés',14),(90,'Argentina Voley Camiseta Titular 2024',67000,'\r\n\r\nVóley\r\nCamiseta Titular Masculina Selección Argentina de Voley\r\n$67.000 *precio sugerido\r\nCamiseta Titular masculina del seleccionado Argentino de Voley (FeVA)\r\nLa nueva camiseta titular mantiene las bandas verticales con colores característicos de nuestro país, pero jugando con líneas y con una forma que respete la fisionomía característica de los jugadores de vóleibol.\r\nLas camisetas están confeccionadas con poliéster más elastano, brindando mayor confort, suavidad y flexibilidad.',1,'1724289552_argentinavoley.png','Logo Le Coq Sportif aplicado en transfer. Bandera argentina aplicada de forma termoadherida.',17),(91,'Pelota Adidas Argentum Pro AFA23',159999,'Usada en la liga más importante del país, esta pelota tiene una construcción termosellada sin costuras y cuenta con el sello FIFA Quality Pro, por lo que siempre estará a la altura de una gran ocasión. Exterior 70 % poliuretano, 20 % poliéster reciclado, 10 % viscosa',1,'1724289820_argentum.png','Una pelota de primera calidad para partidos inspirada que celebra los inicios del Fútbol en Argentina.',13),(92,'Chaco For Ever Tercer Camiseta 2024',55000,'Indumentaria que utiliza en el campeonato Nacional B , año 2024, marca COACH\r\nPunto de Venta Oficial Coach. Local con mas de 10 años de experiencia en el rubro, sito en Barranqueras Chaco.',1,'1724290433_chacoforever.png','Marca: Coach\r\nEquipo: Chaco For Ever\r\nTipo de camiseta: Tercera\r\nTipo de ocasión: Partido\r\nVersión de la camiseta: Auténtica\r\nTemporada: 2024\r\nEs para arquero: No\r\nEdad: Adultos\r\nGénero: Hombre\r\nNúmero de la camiseta: no\r\nEdición especial de la camiseta: no',13),(93,'Botella Deportiva Munich Sports 500ml',15000,'Capacidad: 500 ML.\r\nAcero Inoxidable con doble capa térmica: conserva la temperatura por más tiempo.\r\nExterior: Pintura siliconada de calidad.\r\nAgarre ergonómico y antideslizante.\r\nTapa resistente con rosca.\r\nBotella libre de BPA.\r\nIncluye gancho para colgar en mochila, cepillo para el lavado del mismo.',1,'1724344511_12369_medium-removebg-preview (1).png','',18),(97,'RP Mochila Deportiva Pro Black',139999,'Mochila deportiva Royal Padel Pro Negra y roja\r\n\r\nParte de nuestra nueva colección PERFORMANCE LINE, nuestras nuevas mochilas son de alta calidad y duraderas para soportar las condiciones y el uso más exigente.',1,'1724345374_loool.png','Capacidad para hasta 2 palas.\r\nDispone de un compartimento térmico trasero (tecnología Royal Tech) para proteger tus raquetas de las altas temperaturas.\r\nCompartimento principal con cremallera de resina reforzada.\r\nCarcasa de cuero PU de alto rendimiento\r\nCompartimentos múltiples\r\nCompartimentos laterales. Uno con bolsillo distribuidor para accesorios, móvil, cartera, llaves, tarjeta del club…\r\nMedidas: 58 x 34 x 28 cm\r\n\r\nCapacidad: 42 L',18),(99,'Muñequeras Deportivas Swoosh',11999,'Muñequeras deportivas elásticas que ofrecen soporte y absorben el sudor, combinando comodidad y estilo para tus entrenamientos.',1,'1724347010_accesorio_Muñequeras.png','Muñequeras deportivas de 50 gramos cada una, con medidas de 8 cm de ancho y 15 cm de largo. Ajustables gracias a su diseño elástico, se adaptan cómodamente a la mayoría de tamaños de muñeca. Disponible en tamaño M y en color negro. Lavables a máquina para fácil mantenimiento.',18),(100,'Manchester City Camiseta Titular 2024',120000,'La Camiseta Manchester City Puma Titular 2024 Hombre te ayudará a dar lo mejor de vos en todos tus partidos. El 0161 se lo puede ver escrito por la ciudad, impreso en remeras y tatuado en la piel de muchos. Es un distintivo, un emblema, una señal de lo que significa ser de Manchester City, aunque uno no sea de la ciudad o del equipo. Esta temporada, incorporamos el 0161 en el tejido del equipo deportivo local 24/25 e invitamos a los fanáticos del fútbol de todo el mundo a lucirlo. Si es Sky Blue, es 0161. Manchester City te llama.',1,'1724347670_PU775075-01-1 (1).png','Disciplina: Fútbol\r\n\r\nAdecuado para: Competencia\r\n\r\nMaterial: Poliéster\r\n\r\nEstilo de indumentaria: Con Logo\r\n\r\nComposición: Exterior: 100% poliéster / Acanalado: 97% poliéster / 3% elastano\r\n\r\nCuello: Redondo\r\n\r\nManga: Corta\r\n\r\nCalce: Regular\r\n\r\nLiga: Europa\r\n\r\nEquipo / Atleta: Manchester City\r\n\r\nDefinición de tecnología: tecnología de alto rendimiento diseñada para absorber la humedad del cuerpo y evitar el sudor durante el ejercicio\r\n\r\nGarantía: Contra defecto de fabricación\r\n\r\nOrigen: Importado\r\n\r\nMarca: Puma\r\n\r\n',13),(101,'Straps para Agarre Fuerte',8999,'Straps ajustables para un soporte personalizado. Hechas de material elástico, absorben el sudor y ofrecen comodidad y seguridad en cualquier actividad.',1,'1724347817_accesorio_Straps.png','Straps ajustables, pesando 60 gramos cada una. Miden 10 cm de ancho y 18 cm de largo, con velcro para un ajuste seguro. Fabricadas en material elástico, ofrecen soporte, absorben el sudor y se adaptan a la mayoría de tamaños de muñeca.',18),(102,'Reloj Deportivo Digital LED SANDA 742',39999,'Reloj deportivo con GPS, monitor de frecuencia cardíaca y seguimiento de actividad. Resistente al agua, con pantalla táctil y batería de larga duración, ideal para cualquier entrenamiento.',1,'1724348327_accesorio_RelojDeportivo.png','Reloj deportivo con GPS integrado, monitor de frecuencia cardíaca, y seguimiento de actividad diaria. Pantalla táctil de 1.3 pulgadas, resistente al agua hasta 50 metros, y batería con hasta 10 días de duración. Compatible con aplicaciones de fitness y notificaciones inteligentes.',18),(103,'Chaleco con Carga 20kg Regulable',59999,'Chaleco con carga de 20 kg ajustable, con compartimentos removibles para personalizar el peso. Hecho de material duradero y transpirable, ideal para entrenamientos de fuerza y resistencia.',1,'1724348980_accesorio_ChalecoPesado.png','Chaleco con carga de 20 kg ajustable, con compartimentos removibles de 1 kg cada uno. Hecho de material de nylon resistente y transpirable, con correas ajustables para un ajuste personalizado. Tamaño único, se adapta a diferentes tipos de cuerpo. Ideal para entrenamiento de fuerza y resistencia.',18),(113,'Manchester United Camiseta Titular 23/24',100000,'Old Trafford es la casa del Manchester United. Los seguidores locales adoran este estadio e incluso los rivales no pueden evitar admirarlo. Para esta temporada 23/24, el uniforme de local del club apuesta por una estética llamativa y atemporal, con bloques de color rojo en los costados y un sutil estampado en degradé sobre la parte frontal y la espalda. Esta camiseta de fútbol adidas presenta el escudo del club bordado y un tejido transpirable AEROREADY que mantiene la piel seca. Este producto está hecho con materiales 100 % reciclados. Utilizando materiales reciclados disminuimos los residuos, nuestra dependencia de los recursos finitos y la huella que generan los productos que fabricamos.',1,'1724607824_manchester.png','Ajuste ceñido\r\nCuello redondo\r\n100 % poliéster (reciclado)\r\nAEROREADY\r\nPaneles laterales de malla\r\nEscudo bordado del Manchester United\r\nColor del artículo: Mufc Red\r\nNúmero de artículo: IU1397',13),(114,'Xiaomi Smart Band Mi Band 8 1.62',65000,'Con 10 años de trayectoria, Xiaomi se posiciona como uno de los líderes indiscutidos en el mercado de los smartwatches. Sus productos se destacan por la calidad, el diseño sencillo y muy buenas prestaciones. La Mi Band tiene todo lo necesario para acompañarte en tu rutina.',1,'1724608230_reloj.png','Versión del smartwatch: 8\r\nMemoria interna de 7GB y RAM de 6KB.\r\nResiste hasta 50m bajo el agua.\r\nConectividad por Bluetooth.\r\nBatería de 16 días de duración y carga rápida.\r\nCon pantalla AMOLED de 192pxx490px.',18),(115,'Camiseta Argentina Voley Le Coq Sportif Mujer Suplente',74000,'Camiseta oficial Argentina Voley 2024.',1,'1724609117_voleyF.png','Marca: Le Coq Sportif\r\nModelo: Suplente \r\nEdad: Adultos\r\nGénero: Mujer\r\n',17),(116,'Argentina Voley Camiseta Suplente 2024',78000,'Camiseta oficial Argentina Voley 2024.',1,'1724609200_voleyM.png','Marca: Le Coq Sportif\r\nModelo: Suplente\r\nEdad: Adultos\r\nGénero: Hombre\r\n',17),(117,'Camiseta Argentina Pumas Seven Rugby Home Fan Le Coq Sportif',114000,'Camiseta oficial Argentina Rugby Seven para los Juegos Olimpicos París 2024.',1,'1724609885_rugby.png','Marca: Le Coq Sportif\r\nModelo: Pumas Seven Home Fan 2024\r\nEdad: Adultos\r\nGénero: Hombre',16);
/*!40000 ALTER TABLE `Productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Provincias`
--

DROP TABLE IF EXISTS `Provincias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Provincias` (
  `ID_Provincia` int NOT NULL AUTO_INCREMENT,
  `Nombre_Provincia` varchar(25) NOT NULL,
  PRIMARY KEY (`ID_Provincia`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Provincias`
--

LOCK TABLES `Provincias` WRITE;
/*!40000 ALTER TABLE `Provincias` DISABLE KEYS */;
INSERT INTO `Provincias` VALUES (1,'Buenos Aires'),(2,'Catamarca'),(3,'Chaco'),(4,'Chubut'),(5,'Córdoba'),(6,'Corrientes'),(7,'Entre Ríos'),(8,'Formosa'),(9,'Jujuy'),(10,'La Pampa'),(11,'La Rioja'),(12,'Mendoza'),(13,'Misiones'),(14,'Neuquén'),(15,'Río Negro'),(16,'Salta'),(17,'San Juan'),(18,'San Luis'),(19,'Santa Cruz'),(20,'Santa Fe'),(21,'Santiago del Estero'),(22,'Tierra del Fuego'),(23,'Tucumán');
/*!40000 ALTER TABLE `Provincias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Tipos_de_Usuario`
--

DROP TABLE IF EXISTS `Tipos_de_Usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Tipos_de_Usuario` (
  `ID_Tipos_de_Usuario` int NOT NULL AUTO_INCREMENT,
  `Tipo_de_Usuario` varchar(25) NOT NULL,
  PRIMARY KEY (`ID_Tipos_de_Usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Tipos_de_Usuario`
--

LOCK TABLES `Tipos_de_Usuario` WRITE;
/*!40000 ALTER TABLE `Tipos_de_Usuario` DISABLE KEYS */;
INSERT INTO `Tipos_de_Usuario` VALUES (1,'Administrador'),(2,'Cliente');
/*!40000 ALTER TABLE `Tipos_de_Usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Usuarios`
--

DROP TABLE IF EXISTS `Usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Usuarios` (
  `ID_Usuario` int NOT NULL AUTO_INCREMENT,
  `Username_Usuario` varchar(100) NOT NULL,
  `Nombre_Usuario` varchar(100) DEFAULT NULL,
  `Apellidos_Usuario` varchar(150) DEFAULT NULL,
  `DNI_Usuario` varchar(20) NOT NULL,
  `Email_Usuario` varchar(150) NOT NULL,
  `Contrasenia_Usuario` varchar(255) NOT NULL,
  `Direccion_Usuario` varchar(255) NOT NULL,
  `Telefono_Usuario` varchar(25) NOT NULL,
  `Tipos_de_Usuario_ID_Tipos_de_Usuario` int NOT NULL,
  `Localidades_ID_Localidades` int NOT NULL,
  PRIMARY KEY (`ID_Usuario`,`Tipos_de_Usuario_ID_Tipos_de_Usuario`,`Localidades_ID_Localidades`),
  UNIQUE KEY `Email_Usuario_UNIQUE` (`Email_Usuario`),
  KEY `fk_Usuarios_Tipos_de_Usuario_idx` (`Tipos_de_Usuario_ID_Tipos_de_Usuario`),
  KEY `fk_Usuarios_Localidades1_idx` (`Localidades_ID_Localidades`),
  CONSTRAINT `fk_Usuarios_Localidades1` FOREIGN KEY (`Localidades_ID_Localidades`) REFERENCES `Localidades` (`ID_Localidades`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_Usuarios_Tipos_de_Usuario` FOREIGN KEY (`Tipos_de_Usuario_ID_Tipos_de_Usuario`) REFERENCES `Tipos_de_Usuario` (`ID_Tipos_de_Usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Usuarios`
--

LOCK TABLES `Usuarios` WRITE;
/*!40000 ALTER TABLE `Usuarios` DISABLE KEYS */;
INSERT INTO `Usuarios` VALUES (30,'admin','Jefe de Ventas','Sportseek','4871231','admin@sportseek.com','1234','Independencia 590','338551542',1,19),(36,'z_g0mez','Lucio','Gómez Molina','78415113','luciogomezmolina@gmail.com','1234','laboulaye','79985135',2,19),(38,'EnzoCarranza','Enzo','Carranza','45456471','enzotomascarranzabonavia@gmail.com','1234','Orlandini 3423857485','848948451',2,52),(39,'EnzoLolza','Enzo','Loza','46768672','enzzolozza@gmail.com','1234','Madrid 31','54 9 3385 52-4965',2,19),(40,'Si','sas','sos','sis','si@gmail.com','','ses','sus',2,53),(41,'ovileo','leon','oviedo','46600394','oviedomaximilianoleon@gmail.com','','florencia227','3385464735',2,19),(42,'oovileo','leon','Luna','2342545234','asdasdasd@gmail.com','','Sarmiento 182','03385597358',2,19),(43,'ovileo','Leon','Oviedo','46600394','oviedoleon@gmail.com','Maxiloco','Siais 123','25187841231',2,19),(44,'z_g0mez','Lucio','Gómez Molina','78415113','asdsadas@gmail.com','1322353246456wqer','No se xd','79985135',2,19),(45,'prueba','prueba','prueba','1234','prueba@gmail.com','1234','si','1234',2,54);
/*!40000 ALTER TABLE `Usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-10-28 18:06:21
