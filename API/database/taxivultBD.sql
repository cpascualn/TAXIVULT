CREATE TABLE IF NOT EXISTS  `Ciudad` (
  `id` int,
  `nombre` varchar(30),
  `comunidad` varchar(15),
  `pais` varchar(30),
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `Rol` (
  `id` int,
  `nombre` varchar(50),
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `Usuario` (
  `id` int,
  `email` varchar(30),
  `telefono` varchar(15),
  `nombre` varchar(30),
  `apellidos` varchar(30),
  `contrasena` varchar(30),
  `ciudad` int,
  `fecha_creacion` int,
  `rol` int,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`ciudad`) REFERENCES `Ciudad`(`id`),
  FOREIGN KEY (`rol`) REFERENCES `Rol`(`id`)
);

CREATE TABLE IF NOT EXISTS `Horario` (
  `id` int,
  `nombre` varchar(30),
  `hora_ini1` time,
  `hora_fin1` time,
  `hora_ini2` time,
  `hora_fin2` time,
  `tarifa_ini` decimal(4,2),
  `tarifa_minuto` decimal(4,2),
  PRIMARY KEY (`id`)
);


CREATE TABLE IF NOT EXISTS `Vehiculo` (
  `id` int,
  `matricula` varchar(12) unique,
  `capacidad` int,
  `fabricante` varchar(30),
  `modelo` varchar(30),
  `tipo` enum('comun','van'),
  `imagen` MEDIUMBLOB,
  `conductor` int,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `Conductor` (
  `id` int,
  `dni` varchar(15),
  `licencia_taxista` varchar(15),
  `titular_tarjeta` varchar(50),
  `iban_tarjeta` varchar(30),
  `long_espera` decimal(9,6),
  `lati_espera` decimal(9,6),
  `estado` enum('libre','ocupado','fuera de servicio'),
  `coche` varchar(12),
  `horario` int,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id`) REFERENCES `Usuario`(`id`),
  FOREIGN KEY (`coche`) REFERENCES `Vehiculo`(`matricula`),
  FOREIGN KEY (`horario`) REFERENCES `Horario`(`id`)
);

CREATE TABLE IF NOT EXISTS `Pasajero` (
  `id` int,
  `n_tarjeta` varchar(30),
  `titular_tarjeta` varchar(15),
  `caducidad_tarjeta` varchar(30),
  `cvv_tarjeta` varchar(30),
 PRIMARY KEY (`id`),
  FOREIGN KEY (`id`) REFERENCES `Usuario`(`id`)
);

CREATE TABLE IF NOT EXISTS `Bloqueado_conductor` (
  `id_conductor` int,
  `id_pasajero` int,
  PRIMARY KEY (`id_conductor`, `id_pasajero`),
  FOREIGN KEY (`id_pasajero`) REFERENCES `Pasajero`(`id`),
  FOREIGN KEY (`id_conductor`) REFERENCES `Conductor`(`id`)
);


CREATE TABLE IF NOT EXISTS `Viaje` (
  `id` int,
  `id_conductor` int,
  `id_pasajero` int,
  `lati_ini` decimal(9,6),
  `longi_ini` decimal(9,6),
  `lati_fin` decimal(9,6),
  `longi_fin` decimal(9,6),
  `fecha_ini` int,
  `fecha_fin` int,
  `metodo_pago` enum('efectivo','tarjeta'),
  `cancelado` boolean,
  `fecha_cancelacion` int,
  `distancia` decimal(6,2),
  `duracion_min` int,
  `precio_total` decimal(6,2),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id_pasajero`) REFERENCES `Pasajero`(`id`),
  FOREIGN KEY (`id_conductor`) REFERENCES `Conductor`(`id`)
);

CREATE TABLE IF NOT EXISTS `Ubicacion_fav` (
  `id` int,
  `nombre` varchar(30),
  `longitud` decimal(9,6),
  `latitud` decimal(9,6),
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `pasajero_ubicacion` (
  `id_ubicacion` int,
  `id_pasajero` int,
  PRIMARY KEY (`id_ubicacion`, `id_pasajero`),
  FOREIGN KEY (`id_pasajero`) REFERENCES `Pasajero`(`id`),
  FOREIGN KEY (`id_ubicacion`) REFERENCES `Ubicacion_fav`(`id`)
);

