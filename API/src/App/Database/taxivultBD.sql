CREATE TABLE IF NOT EXISTS `Ciudad` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(30) NOT NULL,
    comunidad VARCHAR(15) NOT NULL,
    pais VARCHAR(30) NOT NULL
);
CREATE TABLE IF NOT EXISTS `Rol` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);
CREATE TABLE IF NOT EXISTS `Usuario` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(30) NOT NULL UNIQUE,
    telefono VARCHAR(15),
    nombre VARCHAR(30) NOT NULL,
    apellidos VARCHAR(30) NOT NULL,
    contrasena VARCHAR(30) NOT NULL,
    ciudad INT,
    fecha_creacion DATE NOT NULL,
    rol INT,
    FOREIGN KEY (ciudad) REFERENCES Ciudad(id),
    FOREIGN KEY (rol) REFERENCES Rol(id)
);
CREATE TABLE IF NOT EXISTS `Horario` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(30) NOT NULL,
    hora_ini1 TIME NOT NULL,
    hora_fin1 TIME NOT NULL,
    hora_ini2 TIME,
    hora_fin2 TIME,
    tarifa_dia DECIMAL(4, 2) NOT NULL,
    tarifa_minuto DECIMAL(4, 2) NOT NULL
);
CREATE TABLE IF NOT EXISTS `Vehiculo` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    matricula VARCHAR(12) NOT NULL UNIQUE,
    capacidad INT NOT NULL,
    fabricante VARCHAR(30) NOT NULL,
    modelo VARCHAR(30) NOT NULL,
    tipo ENUM('comun', 'van') NOT NULL,
    imagen BLOB,
    conductor INT,
    FOREIGN KEY (conductor) REFERENCES Conductor(id)
);
CREATE TABLE IF NOT EXISTS `Conductor` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dni VARCHAR(15) NOT NULL UNIQUE,
    licencia_taxista VARCHAR(15),
    titular_tarjeta VARCHAR(30),
    iban_tarjeta VARCHAR(30),
    long_espera DECIMAL(6, 4),
    lati_espera DECIMAL(9, 6),
    estado ENUM('libre', 'ocupado', 'fuera de servicio') NOT NULL,
    coche VARCHAR(12),
    horario INT,
    FOREIGN KEY (id) REFERENCES Usuario(id),
    -- FOREIGN KEY (coche) REFERENCES Vehiculo(matricula),
    FOREIGN KEY (horario) REFERENCES Horario(id)
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
    `id` int AUTO_INCREMENT,
    `id_conductor` int,
    `id_pasajero` int,
    `lati_ini` decimal(9, 6),
    `longi_ini` decimal(9, 6),
    `lati_fin` decimal(9, 6),
    `longi_fin` decimal(9, 6),
    `fecha_ini` int,
    `fecha_fin` int,
    `metodo_pago` enum('efectivo', 'tarjeta'),
    `cancelado` boolean,
    `fecha_cancelacion` int,
    `distancia` decimal(6, 2),
    `duracion_min` int,
    `precio_total` decimal(6, 2),
    PRIMARY KEY (`id`),
    FOREIGN KEY (`id_pasajero`) REFERENCES `Pasajero`(`id`),
    FOREIGN KEY (`id_conductor`) REFERENCES `Conductor`(`id`)
);
CREATE TABLE IF NOT EXISTS `Ubicacion_fav` (
    `id` int,
    `nombre` varchar(30),
    `longitud` decimal(9, 6),
    `latitud` decimal(9, 6),
    PRIMARY KEY (`id`)
);
CREATE TABLE IF NOT EXISTS `pasajero_ubicacion` (
    `id_ubicacion` int,
    `id_pasajero` int,
    PRIMARY KEY (`id_ubicacion`, `id_pasajero`),
    FOREIGN KEY (`id_pasajero`) REFERENCES `Pasajero`(`id`),
    FOREIGN KEY (`id_ubicacion`) REFERENCES `Ubicacion_fav`(`id`)
);



-- eventos de actualizacion de 

CREATE EVENT actualizarEstadoConductor
ON SCHEDULE EVERY 6 HOUR
STARTS '2024-11-04 02:00:00.000'
ON COMPLETION NOT PRESERVE
ENABLE
DO BEGIN
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
END;

CREATE EVENT actualizarEstadoConductor2
ON SCHEDULE EVERY 12 HOUR
STARTS '2024-11-04 04:00:00.000'
ON COMPLETION NOT PRESERVE
ENABLE
DO BEGIN
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
END;