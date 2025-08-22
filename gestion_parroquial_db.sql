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
  `partida_de_nacimiento` varchar(30) UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `parentescos` (
  `id_padre` INT NOT NULL,
  `id_hijo` INT NOT NULL,
  `tipo_parentesco` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id_padre`, `id_hijo`),
  FOREIGN KEY (`id_padre`) REFERENCES `feligreses`(`id`),
  FOREIGN KEY (`id_hijo`) REFERENCES `feligreses`(`id`)
) ENGINE=InnoDB;
--
-- Volcado de datos para la tabla `feligreses`
--

INSERT INTO `feligreses` (`id`, `primer_nombre`, `primer_apellido`, `cedula`) VALUES
(1, 'Ramírez Serrano', 12345678),
(2, 'Carlos Rodríguez', 23456789),
(3, 'María Gómez', 34567890),
(4, 'José Martínez', 45678901),
(5, 'Luisa Fernández', 56789012),
(6, 'Pedro Suárez', 67890123),
(7, 'Andrea Ramírez', 78901234),
(8, 'Miguel Torres', 89012345),
(9, 'Carmen Díaz', 90123456),
(10, 'Luis Romero', 11223344),
(11, 'Paola Mendoza', 22334455),
(12, 'Jorge Silva', 33445566),
(13, 'Claudia Rivaas', 44556677),
(14, 'Santiago Herrera', 55667788),
(15, 'Isabel Moreno', 66778899);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peticiones`
--

CREATE TABLE `peticiones` (
  `id` int(11) NOT NULL,
  `pedido_por_id` int(11) DEFAULT NULL,
  `por_quien_id` int(11) NOT NULL,
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
  ADD CONSTRAINT `chk_tipo_de_intencion_servicio` CHECK (
    (`servicio_id` != 1 AND `tipo_de_intencion_id` IS NULL) OR
    (`servicio_id` = 1 AND `tipo_de_intencion_id` IS NOT NULL)
  );

ALTER TABLE `servicios`
  ADD CONSTRAINT `servicios_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria_de_servicios` (`id`) ON DELETE CASCADE;

--
-- Volcado de datos para la tabla `peticiones`
--

INSERT INTO `peticiones` (`id`, `pedido_por_id`, `por_quien_id`, `servicio_id`, `descripcion`, `fecha_inicio`, `fecha_fin`) VALUES
(1, 4, 8, 4, NULL, '2025-05-02', '2025-05-15'),
(2, 2, 2, 4, NULL, '2025-05-02', '2025-05-15'),
(3, 3, 3, 6, NULL, '2025-05-03', '2025-06-01'),
(4, 4, 4, 7, NULL, '2025-05-04', '2025-05-20'),
(5, 5, 5, 8, NULL, '2025-05-05', '2025-05-06'),
(6, 6, 6, 9, NULL, '2025-05-06', '2025-05-06'),
(8, 8, 2, 4, NULL, '2025-05-08', '2025-05-18'),
(9, 9, 3, 6, NULL, '2025-05-09', '2025-06-10'),
(10, 10, 4, 7, NULL, '2025-05-10', '2025-05-21'),
(11, 11, 5, 8, NULL, '2025-05-11', '2025-05-13'),
(12, 12, 6, 9, NULL, '2025-05-12', '2025-05-12'),
(14, 14, 2, 4, NULL, '2025-05-14', '2025-05-22'),
(15, 15, 3, 6, NULL, '2025-05-15', '2025-06-15'),
(18, 3, 6, 5, NULL, '2025-05-18', '2025-05-18'),
(20, 5, 2, 4, NULL, '2025-05-20', '2025-05-29'),
(21, 6, 3, 6, NULL, '2025-05-21', '2025-06-05'),
(22, 7, 4, 7, NULL, '2025-05-22', '2025-05-28'),
(23, 8, 5, 8, NULL, '2025-05-23', '2025-05-25'),
(24, 9, 6, 9, NULL, '2025-05-24', '2025-05-24'),
(26, 11, 2, 4, NULL, '2025-05-26', '2025-06-03');

-- ------------------------- para intenciones ------------------
INSERT INTO `peticiones` (`id`, `pedido_por_id`, `por_quien_id`, `tipo_de_intencion_id`, `servicio_id`, `descripcion`, `fecha_inicio`, `fecha_fin`) VALUES
(17, 2, 5, 4, 1, NULL, '2025-05-17', '2025-05-19'),
(25, 10, 1, 1, 1, NULL, '2025-05-25', '2025-05-31'),
(27, 1, 7, 2, 1, 'de un familiar', '2025-06-01', '2025-06-01'),
(31, 1, 11, 3, 1, 'El aniversario de mi abuela', '2025-06-15', '2025-06-15'),
(33, 8, 1, 1, 1, 'Por un proyecto terminado', '2025-06-20', '2025-06-20'),
(35, 3, 4, 2, 1, 'Recuperación de una enfermedad', '2025-06-28', '2025-06-28'),
(36, 6, 9, 4, 1, 'Por el alma de mi padre', '2025-07-01', '2025-07-01'),
(37, 9, 2, 1, 1, 'Por el éxito de un nuevo emprendimiento', '2025-07-05', '2025-07-05'),
(38, 11, 7, 3, 1, 'Aniversario de bodas de mis padres', '2025-07-10', '2025-07-10'),
(39, 12, 5, 2, 1, 'Para la comunidad parroquial', '2025-07-12', '2025-07-12');
-- --------------------------------------------------------



COMMIT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
