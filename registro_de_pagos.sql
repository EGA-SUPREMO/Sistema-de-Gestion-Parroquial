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


CREATE DATABASE registro_de_pagos;
USE registro_de_pagos;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `registro de pagos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `id_admin` int(11) NOT NULL,
  `nombre_usuario` varchar(30) NOT NULL,
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
  `nombre` varchar(100) DEFAULT NULL,
  `cedula` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `feligreses`
--

INSERT INTO `feligreses` (`id`, `nombre`, `cedula`) VALUES
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
-- Estructura de tabla para la tabla `metodos_pago`
--

CREATE TABLE `metodos_pago` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `metodos_pago`
--

INSERT INTO `metodos_pago` (`id`, `nombre`) VALUES
(1, 'Pago móvil'),
(2, 'Efectivo'),
(3, 'Punto de venta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` int(11) NOT NULL,
  `peticion_id` int(11) DEFAULT NULL,
  `feligres_id` int(11) DEFAULT NULL,
  `metodo_pago_id` int(11) DEFAULT NULL,
  `monto_usd` decimal(10,2) DEFAULT NULL,
  `referencia_pago` varchar(100) DEFAULT NULL,
  `fecha_pago` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id`, `peticion_id`, `feligres_id`, `metodo_pago_id`, `monto_usd`, `referencia_pago`, `fecha_pago`) VALUES
(2, 2, 7, 1, 620.00, '121232323', '2025-06-19'),
(3, 14, 13, 1, 150.00, '032832323', '2025-06-25'),
(4, 26, 9, 1, 2323.00, '45454545', '2025-06-25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peticiones`
--

CREATE TABLE `peticiones` (
  `id` int(11) NOT NULL,
  `feligres_id` int(11) DEFAULT NULL,
  `servicio_id` int(11) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `peticiones`
--

INSERT INTO `peticiones` (`id`, `feligres_id`, `servicio_id`, `descripcion`, `fecha_registro`, `fecha_inicio`, `fecha_fin`) VALUES
(2, 2, 2, 'Bautizo de hijo', '2025-05-02', '2025-05-15', '2025-05-15'),
(3, 3, 3, 'Matrimonio de pareja', '2025-05-03', '2025-06-01', '2025-06-01'),
(4, 4, 4, 'Expediente matrimonial para boda', '2025-05-04', '2025-05-20', '2025-05-25'),
(5, 5, 5, 'Exequias para familiar', '2025-05-05', '2025-05-06', '2025-05-06'),
(6, 6, 6, 'Solicitud de partida de bautismo', '2025-05-06', '2025-05-06', '2025-05-06'),
(8, 8, 2, 'Bautizo de sobrino', '2025-05-08', '2025-05-18', '2025-05-18'),
(9, 9, 3, 'Preparación para matrimonio', '2025-05-09', '2025-06-10', '2025-06-10'),
(10, 10, 4, 'Documentación previa al matrimonio', '2025-05-10', '2025-05-21', '2025-05-26'),
(11, 11, 5, 'Misa funeral', '2025-05-11', '2025-05-13', '2025-05-13'),
(12, 12, 6, 'Solicitud de constancia', '2025-05-12', '2025-05-12', '2025-05-12'),
(14, 14, 2, 'Bautizo de niña', '2025-05-14', '2025-05-22', '2025-05-22'),
(15, 15, 3, 'Matrimonio civil-religioso', '2025-05-15', '2025-06-15', '2025-06-15'),
(17, 2, 5, 'Oración por difunto', '2025-05-17', '2025-05-19', '2025-05-19'),
(18, 3, 6, 'Certificación de confirmación', '2025-05-18', '2025-05-18', '2025-05-18'),
(20, 5, 2, 'Bautizo en familia', '2025-05-20', '2025-05-29', '2025-05-29'),
(21, 6, 3, 'Celebración matrimonial', '2025-05-21', '2025-06-05', '2025-06-05'),
(22, 7, 4, 'Exp. Matrimonial para boda civil', '2025-05-22', '2025-05-28', '2025-05-30'),
(23, 8, 5, 'Funeral de tía', '2025-05-23', '2025-05-25', '2025-05-25'),
(24, 9, 6, 'Documento parroquial requerido', '2025-05-24', '2025-05-24', '2025-05-24'),
(25, 10, 1, 'Misa por intención personal', '2025-05-25', '2025-05-31', '2025-05-31'),
(26, 11, 2, 'Bautizo múltiple', '2025-05-26', '2025-06-03', '2025-06-03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL
-- `monto_usd` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Misa', 'Celebración eucarística ofrecida por diferentes intenciones.'),
(2, 'Bautizos', 'Sacramento de iniciación cristiana para niños o adultos.'),
(3, 'Matrimonio', 'Celebración del sacramento del matrimonio católico.'),
(4, 'Exp. Matrimonial', 'Expediente matrimonial: proceso previo a la boda que incluye entrevistas, presentación de documentos y comprobación de libertad para casarse.'),
(5, 'Exequias', 'Ritos funerarios: misa y oraciones ofrecidas por un difunto.'),
(6, 'Documentos Parroquiales', 'Tramitación de constancias, partidas o certificados emitidos por la parroquia.');

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cedula` (`cedula`);

--
-- Indices de la tabla `metodos_pago`
--
ALTER TABLE `metodos_pago`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peticion_id` (`peticion_id`),
  ADD KEY `feligres_id` (`feligres_id`),
  ADD KEY `metodo_pago_id` (`metodo_pago_id`);

--
-- Indices de la tabla `peticiones`
--
ALTER TABLE `peticiones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `feligres_id` (`feligres_id`),
  ADD KEY `servicio_id` (`servicio_id`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
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
-- AUTO_INCREMENT de la tabla `metodos_pago`
--
ALTER TABLE `metodos_pago`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `peticiones`
--
ALTER TABLE `peticiones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`peticion_id`) REFERENCES `peticiones` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pagos_ibfk_2` FOREIGN KEY (`feligres_id`) REFERENCES `feligreses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pagos_ibfk_3` FOREIGN KEY (`metodo_pago_id`) REFERENCES `metodos_pago` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `peticiones`
--
ALTER TABLE `peticiones`
  ADD CONSTRAINT `peticiones_ibfk_1` FOREIGN KEY (`feligres_id`) REFERENCES `feligreses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `peticiones_ibfk_2` FOREIGN KEY (`servicio_id`) REFERENCES `servicios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT chk_fechas_peticion CHECK (fecha_inicio <= fecha_fin);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
