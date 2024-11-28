
-- Server version	5.5.5-10.4.32-MariaDB

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
-- Table structure for table `ciudad`
--

DROP TABLE IF EXISTS `ciudad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ciudad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `comunidad` varchar(150) NOT NULL,
  `pais` varchar(30) NOT NULL,
  `lat_min` decimal(12,9) NOT NULL,
  `lat_max` decimal(12,9) NOT NULL,
  `long_min` decimal(12,9) NOT NULL,
  `long_max` decimal(12,9) NOT NULL,
  `lat` decimal(12,9) NOT NULL,
  `long` decimal(12,9) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `conductor`
--

DROP TABLE IF EXISTS `conductor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `conductor` (
  `id` int(11) NOT NULL,
  `dni` varchar(15) NOT NULL,
  `licencia_taxista` varchar(15) DEFAULT NULL,
  `titular_tarjeta` varchar(30) DEFAULT NULL,
  `iban_tarjeta` varchar(30) DEFAULT NULL,
  `long_espera` decimal(12,9) DEFAULT NULL,
  `lati_espera` decimal(12,9) DEFAULT NULL,
  `estado` enum('libre','ocupado','fuera de servicio') NOT NULL,
  `coche` varchar(12) DEFAULT NULL,
  `horario` int(11) DEFAULT NULL,
  `ubi_espera` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dni` (`dni`),
  UNIQUE KEY `coche` (`coche`),
  KEY `conductor_ibfk_2` (`horario`),
  CONSTRAINT `coche` FOREIGN KEY (`coche`) REFERENCES `vehiculo` (`matricula`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `conductor_ibfk_1` FOREIGN KEY (`id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE,
  CONSTRAINT `conductor_ibfk_2` FOREIGN KEY (`horario`) REFERENCES `horario` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `horario`
--

DROP TABLE IF EXISTS `horario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `horario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `hora_ini1` time NOT NULL,
  `hora_fin1` time NOT NULL,
  `hora_ini2` time DEFAULT NULL,
  `hora_fin2` time DEFAULT NULL,
  `tarifa_dia` decimal(4,2) NOT NULL,
  `tarifa_minuto` decimal(4,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pasajero`
--

DROP TABLE IF EXISTS `pasajero`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pasajero` (
  `id` int(11) NOT NULL,
  `n_tarjeta` varchar(30) DEFAULT NULL,
  `titular_tarjeta` varchar(15) DEFAULT NULL,
  `caducidad_tarjeta` varchar(30) DEFAULT NULL,
  `cvv_tarjeta` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `pasajero_ibfk_1` FOREIGN KEY (`id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rol`
--

DROP TABLE IF EXISTS `rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rol` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(30) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellidos` varchar(30) NOT NULL,
  `contrasena` varchar(100) NOT NULL,
  `ciudad` int(11) DEFAULT NULL,
  `fecha_creacion` date NOT NULL,
  `rol` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `ciudad` (`ciudad`),
  KEY `rol` (`rol`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`ciudad`) REFERENCES `ciudad` (`id`),
  CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`rol`) REFERENCES `rol` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=139 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `vehiculo`
--

DROP TABLE IF EXISTS `vehiculo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehiculo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `matricula` varchar(12) NOT NULL,
  `capacidad` int(11) NOT NULL,
  `fabricante` varchar(30) NOT NULL,
  `modelo` varchar(30) NOT NULL,
  `tipo` enum('comun','van') NOT NULL,
  `imagen` blob DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `matricula` (`matricula`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `viaje`
--

DROP TABLE IF EXISTS `viaje`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `viaje` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_conductor` int(11) DEFAULT NULL,
  `id_pasajero` int(11) DEFAULT NULL,
  `lati_ini` decimal(15,12) DEFAULT NULL,
  `longi_ini` decimal(15,12) DEFAULT NULL,
  `lati_fin` decimal(15,12) DEFAULT NULL,
  `longi_fin` decimal(15,12) DEFAULT NULL,
  `fecha_ini` int(11) DEFAULT NULL,
  `fecha_fin` int(11) DEFAULT NULL,
  `metodo_pago` enum('efectivo','tarjeta') DEFAULT NULL,
  `cancelado` tinyint(1) DEFAULT 0,
  `fecha_cancelacion` int(11) DEFAULT NULL,
  `distancia` decimal(15,2) DEFAULT NULL,
  `duracion_min` int(11) DEFAULT NULL,
  `precio_total` decimal(6,2) DEFAULT NULL,
  `lugar_salida` varchar(1000) NOT NULL,
  `lugar_llegada` varchar(1000) NOT NULL,
  `ciudad` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `viaje_ciudad` (`ciudad`) USING BTREE,
  KEY `viaje_conductor_FK` (`id_conductor`),
  KEY `viaje_pasajero_FK` (`id_pasajero`),
  CONSTRAINT `viaje_ciudad_FK` FOREIGN KEY (`ciudad`) REFERENCES `ciudad` (`id`) ON DELETE CASCADE,
  CONSTRAINT `viaje_conductor_FK` FOREIGN KEY (`id_conductor`) REFERENCES `conductor` (`id`) ON DELETE SET NULL,
  CONSTRAINT `viaje_pasajero_FK` FOREIGN KEY (`id_pasajero`) REFERENCES `pasajero` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping events for database 'taxivult'
--
/*!50106 SET @save_time_zone= @@TIME_ZONE */ ;
/*!50106 DROP EVENT IF EXISTS `actualizarEstadoConductor` */;
DELIMITER ;;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;;
/*!50003 SET character_set_client  = utf8mb4 */ ;;
/*!50003 SET character_set_results = utf8mb4 */ ;;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;;
/*!50003 SET @saved_time_zone      = @@time_zone */ ;;
/*!50003 SET time_zone             = 'SYSTEM' */ ;;
/*!50106 CREATE*/ /*!50117 DEFINER=`root`@`localhost`*/ /*!50106 EVENT `actualizarEstadoConductor` ON SCHEDULE EVERY 6 HOUR STARTS '2024-11-04 02:00:00' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    -- Establecer la variable con la hora actual
    -- Establecer la hora actual completa (hora y minutos)
    SET @hora_actual = TIME(NOW());

    -- Actualizar el estado de los conductores
    UPDATE Conductor c
    JOIN Horario h ON c.horario = h.id
    SET c.estado = CASE
        -- Cambiar a 'libre' si el conductor está dentro de su horario, considerando horas y minutos
        WHEN ((@hora_actual >= TIME(h.hora_ini1) AND @hora_actual <= TIME(h.hora_fin1)) OR
              (@hora_actual >= TIME(h.hora_ini2) AND @hora_actual <= TIME(h.hora_fin2)) OR
              (TIME(h.hora_ini1) > TIME(h.hora_fin1) AND (@hora_actual >= TIME(h.hora_ini1) OR @hora_actual <= TIME(h.hora_fin1))) OR
              (TIME(h.hora_ini2) > TIME(h.hora_fin2) AND (@hora_actual >= TIME(h.hora_ini2) OR @hora_actual <= TIME(h.hora_fin2))))
        THEN 'libre'
        ELSE 'fuera de servicio'
    END
    WHERE h.nombre IN ('diurno', 'nocturno') 
      AND c.estado != 'ocupado';
END */ ;;
/*!50003 SET time_zone             = @saved_time_zone */ ;;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;;
/*!50003 SET character_set_client  = @saved_cs_client */ ;;
/*!50003 SET character_set_results = @saved_cs_results */ ;;
/*!50003 SET collation_connection  = @saved_col_connection */ ;;
/*!50106 DROP EVENT IF EXISTS `actualizarEstadoConductor2` */;;
DELIMITER ;;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;;
/*!50003 SET character_set_client  = utf8mb4 */ ;;
/*!50003 SET character_set_results = utf8mb4 */ ;;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;;
/*!50003 SET @saved_time_zone      = @@time_zone */ ;;
/*!50003 SET time_zone             = 'SYSTEM' */ ;;
/*!50106 CREATE*/ /*!50117 DEFINER=`root`@`localhost`*/ /*!50106 EVENT `actualizarEstadoConductor2` ON SCHEDULE EVERY 12 HOUR STARTS '2024-11-04 04:00:00' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    -- Establecer la variable con la hora actual
    -- Establecer la hora actual completa (hora y minutos)
    SET @hora_actual = TIME(NOW());

    -- Actualizar el estado de los conductores
    UPDATE Conductor c
    JOIN Horario h ON c.horario = h.id
    SET c.estado = CASE
        -- Cambiar a 'libre' si el conductor está dentro de su horario, considerando horas y minutos
        WHEN ((@hora_actual >= TIME(h.hora_ini1) AND @hora_actual <= TIME(h.hora_fin1)) OR
              (@hora_actual >= TIME(h.hora_ini2) AND @hora_actual <= TIME(h.hora_fin2)) OR
              (TIME(h.hora_ini1) > TIME(h.hora_fin1) AND (@hora_actual >= TIME(h.hora_ini1) OR @hora_actual <= TIME(h.hora_fin1))) OR
              (TIME(h.hora_ini2) > TIME(h.hora_fin2) AND (@hora_actual >= TIME(h.hora_ini2) OR @hora_actual <= TIME(h.hora_fin2))))
        THEN 'libre'
        ELSE 'fuera de servicio'
    END
    WHERE h.nombre IN ('diurno', 'nocturno') 
      AND c.estado != 'ocupado';
END */ ;;
/*!50003 SET time_zone             = @saved_time_zone */ ;;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;;
/*!50003 SET character_set_client  = @saved_cs_client */ ;;
/*!50003 SET character_set_results = @saved_cs_results */ ;;
/*!50003 SET collation_connection  = @saved_col_connection */ ;;
DELIMITER ;
/*!50106 SET TIME_ZONE= @save_time_zone */ ;

--
-- Dumping routines for database 'taxivult'
--
/*!50003 DROP PROCEDURE IF EXISTS `actualizar_estado_conductores` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizar_estado_conductores`()
BEGIN

    -- Establecer la variable con la hora actual

    -- Establecer la hora actual completa (hora y minutos)
    SET @hora_actual = TIME(NOW());

    -- Actualizar el estado de los conductores
    UPDATE Conductor c
    JOIN Horario h ON c.horario = h.id
    SET c.estado = CASE
        -- Cambiar a 'libre' si el conductor está dentro de su horario, considerando horas y minutos
        WHEN ((@hora_actual >= TIME(h.hora_ini1) AND @hora_actual <= TIME(h.hora_fin1)) OR
              (@hora_actual >= TIME(h.hora_ini2) AND @hora_actual <= TIME(h.hora_fin2)) OR
              (TIME(h.hora_ini1) > TIME(h.hora_fin1) AND (@hora_actual >= TIME(h.hora_ini1) OR @hora_actual <= TIME(h.hora_fin1))) OR
              (TIME(h.hora_ini2) > TIME(h.hora_fin2) AND (@hora_actual >= TIME(h.hora_ini2) OR @hora_actual <= TIME(h.hora_fin2))))
        THEN 'libre'
        ELSE 'fuera de servicio'
    END
    WHERE h.nombre IN ('diurno', 'nocturno') 
      AND c.estado != 'ocupado';

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `actualizar_estado_conductores_segun_fecha_fin` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizar_estado_conductores_segun_fecha_fin`()
BEGIN

    -- Establece la hora actual en formato epoch y tiempo completo (hora y minutos)

    SET @hora_actual_epoch = UNIX_TIMESTAMP(NOW());

    SET @hora_actual = TIME(NOW());



    -- Actualiza el estado de los conductores cuyos viajes han alcanzado la `fecha_fin`

    UPDATE Conductor c

    JOIN viaje v ON v.id_conductor = c.id

    JOIN Horario h ON c.horario = h.id

    SET c.estado = CASE

        -- Cambiar a 'libre' si el conductor está dentro de su horario

        WHEN ((@hora_actual >= TIME(h.hora_ini1) AND @hora_actual <= TIME(h.hora_fin1)) OR

              (@hora_actual >= TIME(h.hora_ini2) AND @hora_actual <= TIME(h.hora_fin2)) OR

              (TIME(h.hora_ini1) > TIME(h.hora_fin1) AND (@hora_actual >= TIME(h.hora_ini1) OR @hora_actual <= TIME(h.hora_fin1))) OR

              (TIME(h.hora_ini2) > TIME(h.hora_fin2) AND (@hora_actual >= TIME(h.hora_ini2) OR @hora_actual <= TIME(h.hora_fin2))))

        THEN 'libre'

        ELSE 'fuera de servicio'

    END

    WHERE v.fecha_fin <= @hora_actual_epoch

    AND c.estado = 'ocupado'

      AND v.cancelado = 0

     ; 

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

