-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: mysql
-- Tiempo de generación: 19-10-2025 a las 22:30:53
-- Versión del servidor: 8.0.43
-- Versión de PHP: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `encuesta_satisfaccion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codigos_regalo`
--

CREATE TABLE `codigos_regalo` (
  `id` int NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `nombre_regalo` varchar(255) NOT NULL,
  `descripcion` text,
  `cantidad_total` int DEFAULT '1',
  `usos_realizados` int DEFAULT '0',
  `usado` tinyint(1) DEFAULT '0',
  `fecha_creacion` datetime DEFAULT CURRENT_TIMESTAMP,
  `fecha_ultimo_uso` datetime DEFAULT NULL,
  `fecha_ultima_visualizacion` datetime DEFAULT NULL,
  `activo` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `codigos_regalo`
--

INSERT INTO `codigos_regalo` (`id`, `codigo`, `nombre_regalo`, `descripcion`, `cantidad_total`, `usos_realizados`, `usado`, `fecha_creacion`, `fecha_ultimo_uso`, `fecha_ultima_visualizacion`, `activo`) VALUES
(1, 'JFDGE', 'Masaje Relajante', '', 1, 1, 1, '2025-10-19 12:56:44', '2025-10-19 12:57:12', '2025-10-19 15:38:55', 1),
(2, 'ERICK', 'asdja', 'jnkdsadk', 1, 0, 0, '2025-10-19 13:17:22', NULL, '2025-10-19 16:28:51', 1),
(3, 'PATY', 'Masaje Relajante', 'De parte de su pareja', 1, 0, 0, '2025-10-19 13:46:03', NULL, '2025-10-19 14:31:54', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `codigos_regalo`
--
ALTER TABLE `codigos_regalo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `idx_codigo` (`codigo`),
  ADD KEY `idx_usado` (`usado`),
  ADD KEY `idx_activo` (`activo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `codigos_regalo`
--
ALTER TABLE `codigos_regalo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
