-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-06-2025 a las 19:50:28
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- CREATE USER 'test'@'localhost' IDENTIFIED BY '1234';
-- GRANT ALL PRIVILEGES ON *.* TO 'test'@'localhost' WITH GRANT OPTION;
-- FLUSH PRIVILEGES;


CREATE DATABASE gestion_parroquial_db;
USE gestion_parroquial_db;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gestion parroquial`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `id_admin` int(11) NOT NULL,
  `nombre_usuario` varchar(30) UNIQUE NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`id_admin`, `nombre_usuario`, `password`) VALUES
(1, 'admin', '$2y$10$IppRaChWUZrkHweK4.S0guzkgupP.jg8caavQlIM4kG77lEceYnDS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `feligreses`
--

CREATE TABLE `feligreses` (
  `id` int(11) NOT NULL,
  `primer_nombre` VARCHAR(50) NOT NULL,
  `segundo_nombre` VARCHAR(50),
  `primer_apellido` VARCHAR(50) NOT NULL,
  `segundo_apellido` VARCHAR(50),
  `fecha_nacimiento` DATE DEFAULT NULL,
  `cedula` int(10) UNSIGNED UNIQUE,
  `partida_de_nacimiento` varchar(30) UNIQUE DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `parentescos` (
  `id_padre` INT NOT NULL,
  `id_hijo` INT NOT NULL
  PRIMARY KEY (`id_padre`, `id_hijo`),
  FOREIGN KEY (`id_padre`) REFERENCES `feligreses`(`id`),
  FOREIGN KEY (`id_hijo`) REFERENCES `feligreses`(`id`)
) ENGINE=InnoDB;
--
-- Volcado de datos para la tabla `feligreses`
--

---

INSERT INTO `feligreses` (`id`, `primer_nombre`, `segundo_nombre`, `primer_apellido`, `segundo_apellido`, `fecha_nacimiento`, `cedula`) VALUES
(1, 'Maria', 'Josefa', 'Garcia', 'Perez', '1980-03-15', 12345678),
(2, 'Juan', 'Carlos', 'Rodriguez', 'Lopez', '1975-11-20', 98765432),
(3, 'Ana', NULL, 'Martinez', 'Sanchez', '1992-07-01', 11223344),
(4, 'Pedro', 'Antonio', 'Fernandez', NULL, '1968-01-25', 22334455),
(5, 'Sofia', 'Isabel', 'Gomez', 'Diaz', '2005-09-10', 33445566),
(6, 'Luis', 'Alberto', 'Ramirez', 'Vargas', '1999-04-30', 44556677),
(7, 'Elena', NULL, 'Morales', 'Reyes', '2010-06-05', 55667788),
(8, 'Carlos', 'Andres', 'Acosta', 'Soto', '1972-12-12', 66778899);

INSERT INTO `feligreses` (`id`, `primer_nombre`, `segundo_nombre`, `primer_apellido`, `segundo_apellido`, `fecha_nacimiento`, `cedula`) VALUES
(9, 'Ricardo', 'Daniel', 'Silva', 'Castro', '1985-02-28', 77889900),
(10, 'Julia', 'Marina', 'Ortega', 'Guerrero', '1995-12-03', 88990011),
(11, 'Pablo', NULL, 'Gimenez', 'Molina', '2001-08-14', 99001122),
(12, 'Patricia', 'Andrea', 'Herrera', 'Fuentes', '1979-05-22', 10112233),
(13, 'Jorge', 'Sebastian', 'Perez', NULL, '1965-09-07', 20223344),
(14, 'Isabel', 'Lucia', 'Ramos', 'Navarro', '2008-01-19', 30334455),
(15, 'Andres', NULL, 'Diaz', 'Soto', '1990-03-25', 40445566),
(16, 'Laura', 'Sofia', 'Vega', 'Muñoz', '1982-10-10', 50556677);

---
## Dummy Data for `parentescos`

INSERT INTO `parentescos` (`id_padre`, `id_hijo`) VALUES
(1, 5),
(2, 5),
(4, 3),
(8, 6),
(1, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peticiones`
--

CREATE TABLE `peticiones` (
  `id` int(11) NOT NULL,
  `pedido_por_id` int(11) DEFAULT NULL,
  `por_quien_id` int(11) DEFAULT NULL,
  `realizado_por_id` int(11) NOT NULL,
  `tipo_de_intencion_id` int(11) DEFAULT NULL,
  `servicio_id` int(11) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_inicio` DATETIME NOT NULL,
  `fecha_fin` DATETIME NOT NULL,
  `creado_en` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `actualizado_en` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE tipo_de_intencion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT NOT NULL
);

INSERT INTO tipo_de_intencion (nombre, descripcion) VALUES
('Acción de Gracias', 'Intención ofrecida para agradecer a Dios por favores recibidos, bendiciones, logros o acontecimientos especiales.'),
('Salud', 'Intención dirigida a pedir por la recuperación o el bienestar físico, mental o espiritual de una persona.'),
('Aniversario', 'Intención ofrecida para conmemorar un aniversario de matrimonio, ordenación, fallecimiento u otro acontecimiento importante.'),
('Difunto', 'Intención dedicada al eterno descanso del alma de una persona fallecida.')
;

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `categoria_de_servicios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id`, `nombre`, `id_categoria`, `descripcion`) VALUES
(1, 'Intención de Misa Comunitaria', 1, 'Celebración eucarísticacon una intención específica solicitada por un fiel (por un difunto, por la salud, etc.).'),
(2, 'Fe de Bautizo', 2, 'Constancia de fe de bautizo.'),
(3, 'Comunion', 2, 'Constancia de matrimonio.'),
(4, 'Confirmacion', 2, 'Constancia de confirmación.'),
(5, 'Matrimonio', 2, 'Constancia de matrimonio.');

INSERT INTO `categoria_de_servicios` (`id`, `nombre`) VALUES
(1, 'Misa'),
(2, 'Documentos');


CREATE TABLE `santos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `sacerdotes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `vivo` BOOLEAN NOT NULL DEFAULT TRUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `constancia_bautizo` (
  `id` INT(11) NOT NULL,
  `fecha_bautizo` DATE NOT NULL,
  `feligres_bautizado_id` INT(11) NOT NULL,
  `padre_id` INT(11) NOT NULL,
  `madre_id` INT(11) NOT NULL,
  `padrino_id` INT(11) NOT NULL,
  `madrina_id` INT(11) NOT NULL,
  `observaciones` TEXT DEFAULT NULL,
  `municipio` VARCHAR(100) NOT NULL,
  `ministro_id` INT(11) NOT NULL,
  `ministro_certifica_id` INT(11) NOT NULL,
  `registro_civil` VARCHAR(100),
  `numero_libro` INT(10) NOT NULL,
  `numero_pagina` INT(10) NOT NULL,
  `numero_marginal` INT(10) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`feligres_bautizado_id`) REFERENCES `feligreses`(`id`),
  FOREIGN KEY (`padre_id`) REFERENCES `feligreses`(`id`),
  FOREIGN KEY (`madre_id`) REFERENCES `feligreses`(`id`),
  FOREIGN KEY (`padrino_id`) REFERENCES `feligreses`(`id`),
  FOREIGN KEY (`madrina_id`) REFERENCES `feligreses`(`id`)
  FOREIGN KEY (`ministro_id`) REFERENCES `sacerdotes`(`id`)
  FOREIGN KEY (`ministro_certifica_id`) REFERENCES `sacerdotes`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `constancia_comunion` (
  `id` INT(11) NOT NULL,
  `feligres_id` INT(11) NOT NULL,
  `fecha_comunion` DATE NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`feligres_id`) REFERENCES `feligreses`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `constancia_confirmacion` (
  `id` INT(11) NOT NULL,
  `fecha_confirmacion` DATE NOT NULL,
  `feligres_confirmado_id` INT(11) NOT NULL,
  `padre_id` INT(11) NOT NULL,
  `madre_id` INT(11) NOT NULL,
  `padrino_id` INT(11) NOT NULL,
  `madrina_id` INT(11) NOT NULL,
  `numero_libro` VARCHAR(20) NOT NULL,
  `numero_pagina` VARCHAR(20) NOT NULL,
  `numero_marginal` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`feligres_confirmado_id`) REFERENCES `feligreses`(`id`),
  FOREIGN KEY (`padre_id`) REFERENCES `feligreses`(`id`),
  FOREIGN KEY (`madre_id`) REFERENCES `feligreses`(`id`),
  FOREIGN KEY (`padrino_id`) REFERENCES `feligreses`(`id`),
  FOREIGN KEY (`madrina_id`) REFERENCES `feligreses`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `constancia_matrimonio` (
  `id` INT(11) NOT NULL,
  `contrayente_1_id` INT(11) NOT NULL,
  `contrayente_2_id` INT(11) NOT NULL,
  `fecha_matrimonio` DATE NOT NULL,
  `natural_de_contrayente_1` VARCHAR(100),
  `natural_de_contrayente_2` VARCHAR(100),
  `testigo_1_id` INT(11) NOT NULL,
  `testigo_2_id` INT(11) NOT NULL,
  `sacerdote_id` INT(11) NOT NULL,
  `numero_libro` VARCHAR(20) NOT NULL,
  `numero_pagina` VARCHAR(20) NOT NULL,
  `numero_marginal` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`contrayente_1_id`) REFERENCES `feligreses`(`id`),
  FOREIGN KEY (`contrayente_2_id`) REFERENCES `feligreses`(`id`),
  FOREIGN KEY (`testigo_1_id`) REFERENCES `feligreses`(`id`),
  FOREIGN KEY (`testigo_2_id`) REFERENCES `feligreses`(`id`),
  FOREIGN KEY (`sacerdote_id`) REFERENCES `sacerdotes`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indices de la tabla `feligreses`
--
ALTER TABLE `feligreses`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `peticiones`
--
ALTER TABLE `peticiones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_por_id` (`pedido_por_id`),
  ADD KEY `por_quien_id` (`por_quien_id`),
  ADD KEY `realizado_por_id` (`realizado_por_id`),
  ADD KEY `tipo_de_intencion_id` (`tipo_de_intencion_id`),
  ADD KEY `servicio_id` (`servicio_id`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categoria` (`id_categoria`);

ALTER TABLE `categoria_de_servicios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `feligreses`
--
ALTER TABLE `feligreses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `peticiones`
--
ALTER TABLE `peticiones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `categoria_de_servicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

ALTER TABLE `tipo_de_intencion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- Restricciones para tablas volcadas
--


ALTER TABLE `feligreses`
ADD CONSTRAINT `chk_cedula_partida_nacimiento` CHECK (
    `cedula` IS NOT NULL OR `partida_de_nacimiento` IS NOT NULL
);
--
-- Filtros para la tabla `peticiones`
--
ALTER TABLE `peticiones`
  ADD CONSTRAINT `peticiones_ibfk_1` FOREIGN KEY (`pedido_por_id`) REFERENCES `feligreses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `peticiones_ibfk_2` FOREIGN KEY (`por_quien_id`) REFERENCES `feligreses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `peticiones_ibfk_3` FOREIGN KEY (`servicio_id`) REFERENCES `servicios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `peticiones_ibfk_4` FOREIGN KEY (`tipo_de_intencion_id`) REFERENCES `tipo_de_intencion` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `peticiones_ibfk_5` FOREIGN KEY (`realizado_por_id`) REFERENCES `administrador` (`id_admin`) ON DELETE CASCADE,
  ADD CONSTRAINT chk_fechas_peticion CHECK (fecha_inicio <= fecha_fin),
  ADD CONSTRAINT `chk_intencion_y_participantes` CHECK (
      (`tipo_de_intencion_id` IS NOT NULL AND `por_quien_id` IS NOT NULL)
      OR
      (`tipo_de_intencion_id` IS NULL AND `pedido_por_id` IS NOT NULL AND `por_quien_id` IS NULL)
  )
  ADD CONSTRAINT `chk_tipo_de_intencion_servicio` CHECK (
    (`servicio_id` != 1 AND `tipo_de_intencion_id` IS NULL) OR
    (`servicio_id` = 1 AND `tipo_de_intencion_id` IS NOT NULL)
  );

ALTER TABLE `servicios`
  ADD CONSTRAINT `servicios_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria_de_servicios` (`id`) ON DELETE CASCADE;

--
-- Volcado de datos para la tabla `peticiones`
--

-- Inserts para peticiones donde hay tipo_de_intencion (servicio_id = 1)
-- Se asume que existen IDs válidos en feligreses (ej. 1-20), administrador (ej. 1-3) y tipo_de_intencion (ej. 1-5).
INSERT INTO `peticiones` (`id`, `pedido_por_id`, `por_quien_id`, `realizado_por_id`, `tipo_de_intencion_id`, `servicio_id`, `descripcion`, `fecha_inicio`, `fecha_fin`) VALUES
(1, 1, 2, 1, 1, 1, NULL, '2024-07-15 10:00:00', '2024-07-15 11:00:00'),
(2, 3, 1, 2, 2, 1, NULL, '2024-08-01 18:00:00', '2024-08-01 19:00:00'),
(3, 4, 5, 1, 3, 1, NULL, '2024-09-05 09:30:00', '2024-09-05 10:30:00'),
(4, 6, 7, 3, 1, 1, NULL, '2024-10-10 12:00:00', '2024-10-10 13:00:00'),
(5, 8, 9, 2, 4, 1, NULL, '2024-11-20 17:00:00', '2024-11-20 18:00:00'),
(6, 10, 1, 1, 2, 1, NULL, '2024-12-25 10:00:00', '2024-12-25 11:00:00'),
(7, 2, 3, 3, 5, 1, NULL, '2025-01-07 08:00:00', '2025-01-07 09:00:00'),
(8, 5, 4, 2, 3, 1, NULL, '2025-02-14 11:00:00', '2025-02-14 12:00:00'),
(9, 7, 8, 1, 1, 1, NULL, '2025-03-22 16:00:00', '2025-03-22 17:00:00'),
(10, 9, 10, 3, 4, 1, NULL, '2025-04-30 09:00:00', '2025-04-30 10:00:00');

-- Inserts para peticiones sin tipo_de_intencion (servicio_id != 1)
-- Se asume que existen IDs válidos en feligreses (ej. 1-20) y administrador (ej. 1-3).
INSERT INTO `peticiones` (`id`, `pedido_por_id`, `por_quien_id`, `realizado_por_id`, `tipo_de_intencion_id`, `servicio_id`, `descripcion`, `fecha_inicio`, `fecha_fin`) VALUES
(11, 11, 12, 1, NULL, 2, NULL, '2024-07-20 14:00:00', '2024-07-20 15:00:00'),
(12, 13, 14, 1, NULL, 3, NULL, '2024-08-10 09:00:00', '2024-08-10 10:00:00'),
(13, 15, 16, 1, NULL, 4, NULL, '2024-09-18 11:00:00', '2024-09-18 12:00:00'),
(14, 17, 18, 1, NULL, 5, NULL, '2024-10-25 15:00:00', '2024-10-25 16:00:00'),
(15, 19, 20, 1, NULL, 2, NULL, '2024-11-03 10:00:00', '2024-11-03 11:00:00'),
(16, 1, 2, 1, NULL, 3, NULL, '2024-12-08 13:00:00', '2024-12-08 14:00:00'),
(17, 3, 4, 1, NULL, 4, NULL, '2025-01-19 16:00:00', '2025-01-19 17:00:00'),
(18, 5, 6, 1, NULL, 5, NULL, '2025-02-28 09:00:00', '2025-02-28 10:00:00'),
(19, 7, 8, 1, NULL, 2, NULL, '2025-03-05 14:00:00', '2025-03-05 15:00:00'),
(20, 9, 10, 1, NULL, 3, NULL, '2025-04-12 11:00:00', '2025-04-12 12:00:00');


COMMIT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
