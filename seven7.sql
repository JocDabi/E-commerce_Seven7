-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-06-2024 a las 22:07:49
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `seven7`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito_de_compras`
--

CREATE TABLE `carrito_de_compras` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprobante`
--

CREATE TABLE `comprobante` (
  `ID_COMPROBANTE` int(11) NOT NULL,
  `FECHA` date NOT NULL,
  `TOTAL` decimal(8,2) NOT NULL,
  `Usuario_ID` int(11) NOT NULL,
  `Productos_ID` int(11) NOT NULL,
  `estado` varchar(45) NOT NULL DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comprobante`
--

INSERT INTO `comprobante` (`ID_COMPROBANTE`, `FECHA`, `TOTAL`, `Usuario_ID`, `Productos_ID`, `estado`) VALUES
(3, '2024-06-27', 100.00, 17, 0, 'realizada'),
(4, '2024-06-27', 100.00, 17, 0, 'realizada'),
(5, '2024-06-27', 100.00, 17, 0, 'pendiente'),
(6, '2024-06-27', 55.00, 14, 0, 'realizada'),
(7, '2024-06-27', 110.00, 14, 0, 'realizada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprobante_producto`
--

CREATE TABLE `comprobante_producto` (
  `ID` int(11) NOT NULL,
  `Comprobante_ID` int(11) NOT NULL,
  `Producto_ID` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `Precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comprobante_producto`
--

INSERT INTO `comprobante_producto` (`ID`, `Comprobante_ID`, `Producto_ID`, `Cantidad`, `Precio`) VALUES
(1, 3, 1, 2, 50.00),
(2, 4, 1, 2, 50.00),
(3, 5, 1, 2, 50.00),
(4, 6, 1, 1, 50.00),
(5, 6, 4, 1, 5.00),
(6, 7, 1, 2, 50.00),
(7, 7, 4, 2, 5.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_compras`
--

CREATE TABLE `historial_compras` (
  `ID_HISTORIAL` int(11) NOT NULL,
  `FECHA` date NOT NULL,
  `TOTAL` decimal(8,2) NOT NULL,
  `Usuario_ID` int(11) NOT NULL,
  `Comprobante_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial_compras`
--

INSERT INTO `historial_compras` (`ID_HISTORIAL`, `FECHA`, `TOTAL`, `Usuario_ID`, `Comprobante_ID`) VALUES
(1, '2024-06-27', 100.00, 17, 4),
(2, '2024-06-27', 100.00, 17, 5),
(3, '2024-06-27', 55.00, 14, 6),
(4, '2024-06-27', 110.00, 14, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas_seguridad`
--

CREATE TABLE `preguntas_seguridad` (
  `id` int(11) NOT NULL,
  `pregunta` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `preguntas_seguridad`
--

INSERT INTO `preguntas_seguridad` (`id`, `pregunta`) VALUES
(1, '¿Cuál es el nombre de tu primera mascota?'),
(2, '¿Cuál es el nombre de la ciudad donde naciste?'),
(3, '¿Cuál es tu comida favorita?');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `cantidad` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `imagen`, `cantidad`) VALUES
(1, 'bluza', 'rosada', 50.00, 'blazer.png', 5),
(4, 'Tacones Rosado', 'Tacones', 5.00, 'zapato rosa.png', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `ID_USUARIO` int(11) NOT NULL,
  `NOMBRE` varchar(45) NOT NULL,
  `APELLIDO` varchar(45) NOT NULL,
  `EMAIL` varchar(45) NOT NULL,
  `DIRECCION` varchar(45) NOT NULL,
  `CONTRASENA` varchar(300) NOT NULL,
  `pregunta_id` int(11) NOT NULL,
  `respuesta` varchar(255) NOT NULL,
  `fecha_registro` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`ID_USUARIO`, `NOMBRE`, `APELLIDO`, `EMAIL`, `DIRECCION`, `CONTRASENA`, `pregunta_id`, `respuesta`, `fecha_registro`) VALUES
(14, 'Jose', 'cedeno', 'josedcv290604@gmail.com', 'Barrio los olivos avenida 67', '$2y$10$v8nYvcjIPcYMVFbo9qyeCumiKu9F9X.OopMBYYQejqVbQvUbSeN3W', 1, '12', '2024-06-22'),
(17, 'jose', 'david', 'j@gmail.com', 'fadsfads', '$2y$10$7x2wzBLfBPhBmXhs7x3sVev4jjsPsXS/u8v2ND4TYax6Mz1nIaV4m', 1, 'sno', '2024-06-27'),
(18, 'Jose', 'asd', 'h@gmail.com', 'Barrio los olivos av', '$2y$10$N5cu8/hkGYsxIEzreSChf.OCJVoTk2LJRXLiiwMf2JlJNMXZbb4sm', 1, '12', '2024-06-27');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito_de_compras`
--
ALTER TABLE `carrito_de_compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producto_id` (`producto_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `comprobante`
--
ALTER TABLE `comprobante`
  ADD PRIMARY KEY (`ID_COMPROBANTE`),
  ADD KEY `Usuario_ID` (`Usuario_ID`),
  ADD KEY `Productos_ID` (`Productos_ID`);

--
-- Indices de la tabla `comprobante_producto`
--
ALTER TABLE `comprobante_producto`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Comprobante_ID` (`Comprobante_ID`),
  ADD KEY `Producto_ID` (`Producto_ID`);

--
-- Indices de la tabla `historial_compras`
--
ALTER TABLE `historial_compras`
  ADD PRIMARY KEY (`ID_HISTORIAL`),
  ADD KEY `Usuario_ID` (`Usuario_ID`),
  ADD KEY `Comprobante_ID` (`Comprobante_ID`);

--
-- Indices de la tabla `preguntas_seguridad`
--
ALTER TABLE `preguntas_seguridad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`ID_USUARIO`),
  ADD KEY `pregunt_id` (`pregunta_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito_de_compras`
--
ALTER TABLE `carrito_de_compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `comprobante`
--
ALTER TABLE `comprobante`
  MODIFY `ID_COMPROBANTE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `comprobante_producto`
--
ALTER TABLE `comprobante_producto`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `historial_compras`
--
ALTER TABLE `historial_compras`
  MODIFY `ID_HISTORIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `preguntas_seguridad`
--
ALTER TABLE `preguntas_seguridad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `ID_USUARIO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito_de_compras`
--
ALTER TABLE `carrito_de_compras`
  ADD CONSTRAINT `carrito_de_compras_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `carrito_de_compras_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`ID_USUARIO`);

--
-- Filtros para la tabla `comprobante`
--
ALTER TABLE `comprobante`
  ADD CONSTRAINT `comprobante_ibfk_1` FOREIGN KEY (`Usuario_ID`) REFERENCES `usuario` (`ID_USUARIO`);

--
-- Filtros para la tabla `comprobante_producto`
--
ALTER TABLE `comprobante_producto`
  ADD CONSTRAINT `comprobante_producto_ibfk_1` FOREIGN KEY (`Comprobante_ID`) REFERENCES `comprobante` (`ID_COMPROBANTE`) ON DELETE CASCADE,
  ADD CONSTRAINT `comprobante_producto_ibfk_2` FOREIGN KEY (`Producto_ID`) REFERENCES `productos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `historial_compras`
--
ALTER TABLE `historial_compras`
  ADD CONSTRAINT `historial_compras_ibfk_1` FOREIGN KEY (`Usuario_ID`) REFERENCES `usuario` (`ID_USUARIO`),
  ADD CONSTRAINT `historial_compras_ibfk_2` FOREIGN KEY (`Comprobante_ID`) REFERENCES `comprobante` (`ID_COMPROBANTE`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`pregunta_id`) REFERENCES `preguntas_seguridad` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
