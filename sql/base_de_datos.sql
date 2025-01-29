-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-01-2025 a las 21:06:18
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
-- Base de datos: `bd_registro`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bodegas`
--

CREATE TABLE `bodegas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `bodegas`
--

INSERT INTO `bodegas` (`id`, `nombre`) VALUES
(1, 'Bodega Chile'),
(3, 'Bodega Colombia'),
(2, 'Bodega México'),
(4, 'Bodega Perú');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materiales`
--

CREATE TABLE `materiales` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `materiales`
--

INSERT INTO `materiales` (`id`, `nombre`) VALUES
(3, 'Madera'),
(2, 'Metal'),
(1, 'Plástico'),
(5, 'Textil'),
(4, 'Vidrio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `monedas`
--

CREATE TABLE `monedas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `simbolo` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `monedas`
--

INSERT INTO `monedas` (`id`, `nombre`, `simbolo`) VALUES
(1, 'Peso Chileno', 'CLP'),
(2, 'Peso Mexicano', 'MXN'),
(3, 'Peso Colombiano', 'COP'),
(4, 'Sol Peruano', 'PEN');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `codigo` varchar(15) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `bodega_id` int(11) NOT NULL,
  `sucursal_id` int(11) NOT NULL,
  `moneda_id` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `codigo`, `nombre`, `bodega_id`, `sucursal_id`, `moneda_id`, `precio`, `descripcion`, `fecha_creacion`) VALUES
(1, 'A20L1', 'Agua de mesa', 4, 12, 4, 5.00, 'Agua de mesa purificada\r\nEn presentación de 20 litros', '2025-01-29 16:17:42'),
(7, 'A20L156', 'Atomizador', 2, 5, 2, 124.00, 'asdasdasdasdasdasd', '2025-01-29 19:03:59');

--
-- Disparadores `productos`
--
DELIMITER $$
CREATE TRIGGER `validar_productos_before_insert` BEFORE INSERT ON `productos` FOR EACH ROW BEGIN
    -- Validar columna codigo (debe contener al menos una letra y un número, longitud 5-15)
    IF NEW.codigo NOT REGEXP '^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{5,15}$' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error: Código debe contener letras y números (5-15 caracteres)';
    END IF;
    
    -- Validar columna nombre (mínimo 2, máximo 50 caracteres)
    IF CHAR_LENGTH(NEW.nombre) < 2 OR CHAR_LENGTH(NEW.nombre) > 50 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error: El nombre debe tener entre 2 y 50 caracteres';
    END IF;

    -- Validar columna precio (debe ser mayor a 0)
    IF NEW.precio <= 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error: El precio debe ser mayor a 0';
    END IF;
    
    -- Validar columna descripcion (mínimo 10, máximo 1000 caracteres)
    IF CHAR_LENGTH(NEW.descripcion) < 10 OR CHAR_LENGTH(NEW.descripcion) > 1000 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error: La descripción debe tener entre 10 y 1000 caracteres';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `validar_productos_before_update` BEFORE UPDATE ON `productos` FOR EACH ROW BEGIN
    -- Validar columna codigo (letras y números, entre 5 y 15 caracteres)
    IF NEW.codigo NOT REGEXP '^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{5,15}$' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error: Código debe contener letras y números (5-15 caracteres)';
    END IF;
    
    -- Validar columna nombre (mínimo 2, máximo 50 caracteres)
    IF CHAR_LENGTH(NEW.nombre) < 2 OR CHAR_LENGTH(NEW.nombre) > 50 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error: El nombre debe tener entre 2 y 50 caracteres';
    END IF;

    -- Validar columna precio (debe ser mayor a 0)
    IF NEW.precio <= 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error: El precio debe ser mayor a 0';
    END IF;
    
    -- Validar columna descripcion (mínimo 10, máximo 1000 caracteres)
    IF CHAR_LENGTH(NEW.descripcion) < 10 OR CHAR_LENGTH(NEW.descripcion) > 1000 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error: La descripción debe tener entre 10 y 1000 caracteres';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_material`
--

CREATE TABLE `producto_material` (
  `producto_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `producto_material`
--

INSERT INTO `producto_material` (`producto_id`, `material_id`) VALUES
(1, 1),
(1, 4),
(7, 1),
(7, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursales`
--

CREATE TABLE `sucursales` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `bodega_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `sucursales`
--

INSERT INTO `sucursales` (`id`, `nombre`, `bodega_id`) VALUES
(1, 'Sucursal Santiago', 1),
(2, 'Sucursal Valparaíso', 1),
(3, 'Sucursal Arica', 1),
(4, 'Sucursal Ciudad de México', 2),
(5, 'Sucursal Monterrey', 2),
(6, 'Sucursal Veracruz', 2),
(7, 'Sucursal Cancún', 2),
(8, 'Sucursal Bogotá', 3),
(9, 'Sucursal Medellín', 3),
(10, 'Sucursal Lima', 4),
(11, 'Sucursal Arequipa', 4),
(12, 'Sucursal Piura', 4),
(13, 'Sucursal Trujillo', 4),
(14, 'Sucursal Cajamarca', 4);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bodegas`
--
ALTER TABLE `bodegas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `materiales`
--
ALTER TABLE `materiales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `monedas`
--
ALTER TABLE `monedas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD UNIQUE KEY `simbolo` (`simbolo`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `bodega_id` (`bodega_id`),
  ADD KEY `sucursal_id` (`sucursal_id`),
  ADD KEY `moneda_id` (`moneda_id`);

--
-- Indices de la tabla `producto_material`
--
ALTER TABLE `producto_material`
  ADD PRIMARY KEY (`producto_id`,`material_id`),
  ADD KEY `material_id` (`material_id`);

--
-- Indices de la tabla `sucursales`
--
ALTER TABLE `sucursales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bodega_id` (`bodega_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bodegas`
--
ALTER TABLE `bodegas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `materiales`
--
ALTER TABLE `materiales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `monedas`
--
ALTER TABLE `monedas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `sucursales`
--
ALTER TABLE `sucursales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`bodega_id`) REFERENCES `bodegas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productos_ibfk_3` FOREIGN KEY (`moneda_id`) REFERENCES `monedas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto_material`
--
ALTER TABLE `producto_material`
  ADD CONSTRAINT `producto_material_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `producto_material_ibfk_2` FOREIGN KEY (`material_id`) REFERENCES `materiales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `sucursales`
--
ALTER TABLE `sucursales`
  ADD CONSTRAINT `sucursales_ibfk_1` FOREIGN KEY (`bodega_id`) REFERENCES `bodegas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
