-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-11-2024 a las 19:03:26
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
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `id_detalle` int(11) NOT NULL,
  `id_venta` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_venta`
--

INSERT INTO `detalle_venta` (`id_detalle`, `id_venta`, `id_producto`, `cantidad`, `precio`, `subtotal`) VALUES
(1, 16, 3, 8, 100.00, 800.00),
(2, 16, 4, 8, 50.00, 400.00),
(3, 17, 3, 5, 100.00, 500.00),
(4, 17, 4, 7, 50.00, 350.00),
(5, 18, 3, 8, 100.00, 800.00),
(6, 18, 4, 9, 50.00, 450.00),
(7, 19, 3, 1, 100.00, 100.00),
(8, 19, 4, 1, 50.00, 50.00),
(9, 20, NULL, 5, NULL, 500.00),
(10, 20, NULL, 1, NULL, 50.00),
(11, 21, NULL, 1, NULL, 100.00),
(12, 22, NULL, 1, NULL, 100.00),
(13, 22, NULL, 1, NULL, 50.00),
(14, 23, NULL, 1, NULL, 50.00),
(15, 23, NULL, 1, NULL, 100.00),
(16, 24, 3, 1, 100.00, 100.00),
(17, 24, 4, 1, 50.00, 50.00),
(18, 25, 3, 1, 100.00, 100.00),
(19, 26, 3, 40, 100.00, 4000.00),
(20, 26, 4, 20, 50.00, 1000.00),
(21, 27, 3, 2, 100.00, 200.00),
(22, 27, 4, 3, 50.00, 150.00),
(23, 28, 3, 3, 100.00, 300.00),
(24, 28, 4, 2, 50.00, 100.00),
(25, 29, 3, 1, 100.00, 100.00),
(26, 29, 4, 2, 50.00, 100.00),
(31, NULL, 3, 1, NULL, 100.00),
(32, NULL, 4, 1, NULL, 50.00),
(33, NULL, 3, 1, NULL, 100.00),
(34, 33, 3, 1, NULL, 100.00),
(35, 34, 3, 10, NULL, 1000.00),
(36, 34, 4, 10, NULL, 500.00),
(37, 35, 3, 20, NULL, 2000.00),
(38, 35, 4, 50, NULL, 2500.00),
(39, 36, 3, 2, NULL, 200.00),
(40, 36, 4, 5, 0.00, 250.00),
(41, 37, 3, 7, NULL, 700.00),
(42, 37, 4, 3, NULL, 150.00),
(43, 38, 4, 9, NULL, 450.00),
(44, 38, 3, 1, NULL, 100.00),
(45, 39, 3, 7, 100.00, 700.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_reportes`
--

CREATE TABLE `historial_reportes` (
  `id_reporte` int(11) NOT NULL,
  `id_usuario` int(45) DEFAULT NULL,
  `tipo_reporte` varchar(255) DEFAULT 'venta',
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `nombre_usuario` varchar(255) DEFAULT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial_reportes`
--

INSERT INTO `historial_reportes` (`id_reporte`, `id_usuario`, `tipo_reporte`, `fecha_creacion`, `nombre_usuario`, `fecha_inicio`, `fecha_fin`) VALUES
(1, NULL, 'venta', '2024-11-29 20:21:45', NULL, '2024-11-24', '2024-11-29'),
(2, NULL, 'venta', '2024-11-29 21:16:00', NULL, '2024-11-24', '2024-11-29'),
(3, NULL, 'venta', '2024-11-29 21:28:52', NULL, '2024-11-24', '2024-11-29'),
(4, NULL, 'venta', '2024-11-29 21:39:04', NULL, '2024-11-24', '2024-11-29'),
(5, NULL, 'venta', '2024-11-29 22:07:06', NULL, '2024-11-24', '2024-11-29'),
(6, NULL, 'venta', '2024-11-29 22:24:11', NULL, '2024-11-24', '2024-11-29'),
(7, 22, 'venta', '2024-11-29 22:28:54', '0', '2024-11-24', '2024-11-29'),
(8, 22, 'venta', '2024-11-29 22:30:11', '0', '2024-11-01', '2024-11-29'),
(9, 22, 'venta', '2024-11-29 22:38:07', '', '2024-11-14', '2024-11-29'),
(10, 22, 'venta', '2024-11-29 22:38:54', '', '2024-11-19', '2024-11-29'),
(11, 22, 'venta', '2024-11-29 22:51:36', '', '2024-11-19', '2024-11-29'),
(12, 22, 'venta', '2024-11-29 22:52:04', '', '2024-11-19', '2024-11-29'),
(13, 22, 'venta', '2024-11-29 22:52:26', '0', '2024-11-19', '2024-11-29'),
(14, 22, 'venta', '2024-11-29 23:00:21', 'tomas', '2024-11-19', '2024-11-29'),
(15, 22, 'venta', '2024-11-30 00:28:22', 'tomas', '2024-11-26', '2024-11-29'),
(16, 22, 'venta', '2024-11-30 12:40:33', 'tomas', '2024-11-01', '2024-11-30');

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
(3, 'Aspirina', 0, 500, 100, 'Bayer', 'Analgésico', 'M365425J', '2024-12-31', 'A1'),
(4, 'acetaminofen', 421, 50, 50, 'bay', 'Analgésico', 'J62541L', '2025-11-24', 'C1');

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
(30, 'jesus a', 'jesusa', 'jesusa@gmail.com', '123452', 2, 'suspendido'),
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
  `id_usuario` int(11) NOT NULL,
  `fecha_venta` datetime NOT NULL,
  `cantidad` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id_venta`, `id_usuario`, `fecha_venta`, `cantidad`, `total`) VALUES
(2, 22, '2024-11-07 20:11:42', 9, 900.00),
(3, 22, '2024-11-07 20:27:27', 2, 200.00),
(4, 22, '2024-11-07 20:56:26', 1, 50.00),
(5, 22, '2024-11-07 21:24:07', 1, 100.00),
(6, 22, '2024-11-07 21:24:07', 5, 250.00),
(7, 22, '2024-11-08 07:26:31', 60, 6000.00),
(8, 22, '2024-11-08 20:38:52', 5, 500.00),
(10, 22, '2024-11-08 20:42:53', 60, 6000.00),
(12, 22, '2024-11-20 19:39:51', 10, 1000.00),
(16, 22, '2024-11-20 23:09:17', 0, 0.00),
(17, 22, '2024-11-20 23:17:40', 0, 0.00),
(18, 22, '2024-11-20 23:24:44', 7, 1250.00),
(19, 22, '2024-11-20 23:36:22', 0, 150.00),
(20, 22, '2024-11-20 23:46:53', 0, 550.00),
(21, 22, '2024-11-20 23:58:25', 0, 100.00),
(22, 22, '2024-11-21 00:15:16', 0, 150.00),
(23, 22, '2024-11-21 00:22:44', 0, 150.00),
(24, 22, '2024-11-21 00:23:45', 0, 150.00),
(25, 22, '2024-11-21 00:34:20', 0, 100.00),
(26, 22, '2024-11-21 00:47:06', 0, 5000.00),
(27, 2, '2024-11-21 07:06:42', 0, 350.00),
(28, 22, '2024-11-21 12:31:23', 0, 400.00),
(29, 22, '2024-11-21 12:35:47', 0, 200.00),
(33, 22, '2024-11-22 07:41:13', 0, 100.00),
(34, 22, '2024-11-22 07:42:43', 0, 1500.00),
(35, 22, '2024-11-22 07:44:05', 0, 4500.00),
(36, 22, '2024-11-22 20:12:47', 0, 450.00),
(37, 22, '2024-11-28 21:03:43', 0, 850.00),
(38, 22, '2024-11-28 21:23:00', 0, 550.00),
(39, 22, '2024-11-28 22:06:44', 0, 700.00);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_venta` (`id_venta`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `historial_reportes`
--
ALTER TABLE `historial_reportes`
  ADD PRIMARY KEY (`id_reporte`),
  ADD KEY `id_usuario` (`id_usuario`);

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
  ADD KEY `id_usuario` (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `historial_reportes`
--
ALTER TABLE `historial_reportes`
  MODIFY `id_reporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `detalle_venta_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id_venta`),
  ADD CONSTRAINT `detalle_venta_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `historial_reportes`
--
ALTER TABLE `historial_reportes`
  ADD CONSTRAINT `fk_historial_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_roles` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
