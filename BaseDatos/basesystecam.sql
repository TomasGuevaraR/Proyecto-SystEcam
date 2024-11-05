-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-11-2024 a las 22:37:37
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
  `cantidad` int(45) DEFAULT NULL,
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
  `id` int(45) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `usuario` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `roles_id` int(45) NOT NULL,
  `estado` enum('activo','suspendido') DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `email`, `pass`, `roles_id`, `estado`) VALUES
(2, 'tomas guevara', 'tomasg', 'tomguer3107@gmail.com', 'tomas1234', 1, 'activo'),
(3, 'adiel guevara', 'adielg', 'adiel@gmail.com', 'adiel3547', 2, 'activo'),
(4, 'marile', 'mari52', 'm@gmail.com', '55478', 1, 'activo'),
(14, 'tomas guevara', 'mari52', 'tomasguevararamos@gmail.com', '12345', 1, 'suspendido'),
(22, 'tomas', 'tomas31', 'tomas31@gmail.com', '12345', 1, 'activo'),
(30, 'jesus a', 'jesusa', 'jesusa@gmail.com', '123452', 2, 'activo'),
(36, 'luis', 'luis1', 'luis1@gmail.com', '12345', 2, 'activo'),
(37, 'ana', 'anam', 'anam@gmail.com', '12345', 2, 'activo'),
(38, 'ferney', 'ferney1', 'ferney1@gmail.com', '12345', 2, 'activo'),
(39, 'mario', 'mario1', 'mario1@gmail.com', '12345', 2, 'activo'),
(40, 'luz', 'luz1', 'luz1@gmail.com', '12345', 2, 'activo'),
(42, 'Esmil Hernandez', 'esmil', 'esmil@gmail.com', '12345', 1, 'activo'),
(43, 'Ana Martinez', 'ana', 'ana@gmail.com', '12345', 2, 'activo'),
(46, 'juan Gonzalez', 'juan1', 'juan@gmail.com', '12345', 1, 'activo'),
(47, 'Luis Gomez5', 'luis55', 'luisg5@gmnail.com', '12345', 2, 'activo'),
(48, 'mario', 'marios', 'mario@gmnail.com', '12345', 2, 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id_venta` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `cantidad` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(45) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(45) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_roles` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE,
  ADD CONSTRAINT `ventas_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
