-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-06-2024 a las 20:29:22
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
-- Estructura de tabla para la tabla `carrito_compras`
--

CREATE TABLE `carrito_compras` (
  `ID_CARRITO` int(11) NOT NULL,
  `FECHA` date NOT NULL,
  `CANTIDAD` int(11) NOT NULL,
  `PRECIO_TOTAL` decimal(8,2) NOT NULL,
  `Usuario_ID` int(11) NOT NULL,
  `Productos_ID` int(11) NOT NULL
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
  `Productos_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `ID_PRODUCTO` int(11) NOT NULL,
  `NOMBRE` varchar(45) NOT NULL,
  `DESCRIPCION` varchar(45) DEFAULT NULL,
  `STOCK` decimal(8,2) NOT NULL,
  `PRECIO` decimal(8,2) NOT NULL,
  `CATEGORIA` varchar(45) NOT NULL,
  `DESCUENTO` decimal(5,2) DEFAULT NULL,
  `Comprobante_ID` int(11) NOT NULL,
  `Carrito_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `respuesta` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito_compras`
--
ALTER TABLE `carrito_compras`
  ADD PRIMARY KEY (`ID_CARRITO`),
  ADD KEY `Usuario_ID` (`Usuario_ID`),
  ADD KEY `Productos_ID` (`Productos_ID`);

--
-- Indices de la tabla `comprobante`
--
ALTER TABLE `comprobante`
  ADD PRIMARY KEY (`ID_COMPROBANTE`),
  ADD KEY `Usuario_ID` (`Usuario_ID`),
  ADD KEY `Productos_ID` (`Productos_ID`);

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
  ADD PRIMARY KEY (`ID_PRODUCTO`),
  ADD KEY `Comprobante_ID` (`Comprobante_ID`),
  ADD KEY `Carrito_ID` (`Carrito_ID`);

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
-- AUTO_INCREMENT de la tabla `carrito_compras`
--
ALTER TABLE `carrito_compras`
  MODIFY `ID_CARRITO` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comprobante`
--
ALTER TABLE `comprobante`
  MODIFY `ID_COMPROBANTE` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historial_compras`
--
ALTER TABLE `historial_compras`
  MODIFY `ID_HISTORIAL` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `preguntas_seguridad`
--
ALTER TABLE `preguntas_seguridad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `ID_PRODUCTO` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `ID_USUARIO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito_compras`
--
ALTER TABLE `carrito_compras`
  ADD CONSTRAINT `carrito_compras_ibfk_1` FOREIGN KEY (`Usuario_ID`) REFERENCES `usuario` (`ID_USUARIO`),
  ADD CONSTRAINT `carrito_compras_ibfk_2` FOREIGN KEY (`Productos_ID`) REFERENCES `productos` (`ID_PRODUCTO`);

--
-- Filtros para la tabla `comprobante`
--
ALTER TABLE `comprobante`
  ADD CONSTRAINT `comprobante_ibfk_1` FOREIGN KEY (`Usuario_ID`) REFERENCES `usuario` (`ID_USUARIO`),
  ADD CONSTRAINT `comprobante_ibfk_2` FOREIGN KEY (`Productos_ID`) REFERENCES `productos` (`ID_PRODUCTO`);

--
-- Filtros para la tabla `historial_compras`
--
ALTER TABLE `historial_compras`
  ADD CONSTRAINT `historial_compras_ibfk_1` FOREIGN KEY (`Usuario_ID`) REFERENCES `usuario` (`ID_USUARIO`),
  ADD CONSTRAINT `historial_compras_ibfk_2` FOREIGN KEY (`Comprobante_ID`) REFERENCES `comprobante` (`ID_COMPROBANTE`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`Comprobante_ID`) REFERENCES `comprobante` (`ID_COMPROBANTE`),
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`Carrito_ID`) REFERENCES `carrito_compras` (`ID_CARRITO`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`pregunta_id`) REFERENCES `preguntas_seguridad` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
