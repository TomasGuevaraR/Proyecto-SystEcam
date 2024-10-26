-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-10-2024 a las 04:32:04
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `basesystecam`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(45) NOT NULL,
  `nombre_producto` varchar(45) DEFAULT NULL,
  `cantidad` int(20) DEFAULT NULL,
  `precio_costo` int(45) DEFAULT NULL,
  `precio_venta` int(45) DEFAULT NULL,
  `laboratorio` varchar(45) DEFAULT NULL,
  `categoria` varchar(45) DEFAULT NULL,
  `cod_invima` varchar(45) DEFAULT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `ubicacion` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre_producto`, `cantidad`, `precio_costo`, `precio_venta`, `laboratorio`, `categoria`, `cod_invima`, `fecha_vencimiento`, `ubicacion`) VALUES
(3, 'Aspirina', 50, 500, 100, 'Bayer', 'Analgésico', 'M365425J', '2024-12-31', 'A1'),
(4, 'acetaminofen', 500, 50, 50, 'bay', 'Analgésico', 'J62541L', '2025-11-24', 'C1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `rol` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `rol`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `email` varchar(45) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `roles_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `email`, `pass`, `roles_id`) VALUES
(1, 'maria guevara', '1063358895', 'mariag1@gmail.com', '12345', 2),
(2, 'tomas guevara', 'tomasg', 'tomguer3107@gmail.com', 'tomas1234', 2),
(3, 'adiel guevara', 'adielg', 'adiel@gmail.com', 'adiel3547', 2),
(4, 'marile', 'mari52', 'm@gmail.com', '55478', 2),
(14, 'tomas guevara', 'mari52', 'tomasguevararamos@gmail.com', '12345', 2),
(22, 'tomas', 'tomas31', 'tomas31@gmail.com', '12345', 1),
(30, 'jesus a', 'jesusa', 'jesusa@gmail.com', '123452', 2),
(36, 'luis', 'luis1', 'luis1@gmail.com', '12345', 2),
(37, 'ana', 'anam', 'anam@gmail.com', '12345', 2),
(38, 'ferney', 'ferney1', 'ferney1@gmail.com', '12345', 2),
(39, 'mario', 'mario1', 'mario1@gmail.com', '12345', 2),
(40, 'luz', 'luz1', 'luz1@gmail.com', '12345', 2),
(42, 'Esmil Hernandez', 'esmil', 'esmil@gmail.com', '12345', 1),
(43, 'Ana Martinez', 'ana', 'ana@gmail.com', '12345', 2),
(44, 'jesus alvarez', 'jesus', 'jesus1@gmail.com', '12345', 2),
(45, 'Andrés Pérez', 'andres1', 'andres1@gmail.com', '12345', 2),
(46, 'juan Gonzalez', 'juan1', 'juan@gmail.com', '12345', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuarios_roles_idx` (`roles_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(45) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_roles` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
