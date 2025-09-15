-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-09-2025 a las 01:14:12
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
-- Base de datos: `donappetit`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codigo_verificacion`
--

CREATE TABLE `codigo_verificacion` (
  `id_cod` int(11) NOT NULL COMMENT 'identificador del codigo. auto incremento.',
  `id_usuario` int(11) NOT NULL COMMENT 'referencia al id_usuario de la tabla usuario',
  `fecha_expiracion` datetime NOT NULL COMMENT 'fecha de expiración\r\n',
  `activo` varchar(1) NOT NULL COMMENT 'hace referencia a si el código sigue activo o no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones`
--

CREATE TABLE `direcciones` (
  `id_direccion` int(11) NOT NULL COMMENT 'Este será la clave primaria de la tabla.',
  `id_usuario_direcc` int(11) NOT NULL COMMENT 'hace referencia al id_usuario de la tabla usuario',
  `nom_calle` varchar(50) NOT NULL COMMENT 'nombre de la calle donde se ubica ',
  `num_calle` int(11) NOT NULL COMMENT 'Para el número de la casa o edificio'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `donacion`
--

CREATE TABLE `donacion` (
  `id_donacion` int(11) NOT NULL COMMENT 'Identificador de la donación. Auto Incremento.',
  `id_producto` int(11) NOT NULL COMMENT 'referencia al producto.',
  `cantidad_donado` int(11) NOT NULL COMMENT 'cantidad del producto donado\r\n',
  `fecha_publicacion` datetime NOT NULL COMMENT 'fecha y hora de la publicación.',
  `estado` varchar(50) NOT NULL COMMENT 'estado la donación. "DISPONIBLE", "ENTREGADO".\r\n'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `donante`
--

CREATE TABLE `donante` (
  `id_usu_donante` int(11) NOT NULL COMMENT 'referencia al id_usuario de la tabla usuario.',
  `nom_comercial` varchar(255) NOT NULL COMMENT 'Nombre comercial del Supermercado.\r\n',
  `CUIT` varchar(20) NOT NULL COMMENT 'Clave Única de Identificación Tributaria. '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadistica`
--

CREATE TABLE `estadistica` (
  `id_estadistica` int(11) NOT NULL COMMENT 'identificador de la estadística. auto incremento.',
  `id_donacion` int(11) NOT NULL COMMENT 'referencia a la donacion',
  `total_donado` int(11) NOT NULL COMMENT 'total donado',
  `frecuencia_mensual` int(11) NOT NULL COMMENT 'frecuencia de donación mensual.',
  `frecuencia_anual` int(11) NOT NULL COMMENT 'frecuencia de donación anual.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL COMMENT 'Identificador del producto. Auto Incremento.',
  `nom_producto` varchar(255) NOT NULL COMMENT 'Nombre del producto.',
  `unidad` varchar(50) NOT NULL COMMENT 'Tipo de unidad (ej. "kg", "litros", "unidades").'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_donante`
--

CREATE TABLE `productos_donante` (
  `id_producto_donante` int(11) NOT NULL COMMENT 'Identificador de la relación. Auto Incremento.',
  `id_producto` int(11) NOT NULL COMMENT 'referencia al producto',
  `id_donante` int(11) NOT NULL COMMENT 'referencia al donante',
  `fecha` date NOT NULL COMMENT 'fecha de la donación.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `receptor`
--

CREATE TABLE `receptor` (
  `id_usu_receptor` int(11) NOT NULL COMMENT 'Referencia al id_usuario de la tabla usuario',
  `num_renacom` varchar(50) NOT NULL COMMENT 'Numero RENACOM',
  `nom_institucion` varchar(255) NOT NULL COMMENT 'Nombre la institucion comunitaria.',
  `responsable` varchar(50) NOT NULL COMMENT 'Persona encargada de la institucion'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock_donaciones`
--

CREATE TABLE `stock_donaciones` (
  `id_Stock_donaciones` int(11) NOT NULL COMMENT 'identificador del stock. auto incremento',
  `id_usuario_donante` int(11) NOT NULL COMMENT 'Referencia al id_usuario_donante de la tabla donante.',
  `cantidad` int(11) NOT NULL COMMENT 'cantidad del producto.',
  `fecha_venc` date NOT NULL COMMENT 'fecha de vencimiento'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock_productos_donacion`
--

CREATE TABLE `stock_productos_donacion` (
  `id_stock_productos_donaciones` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL COMMENT 'referencia al producto.',
  `Stock__Donaciones` int(11) NOT NULL COMMENT 'Referencia a la tabla donaciones'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL COMMENT 'Identificador único. Auto Incremento.',
  `Nombre` varchar(255) NOT NULL COMMENT 'Nombre completo.',
  `Email` varchar(255) NOT NULL COMMENT 'Único. Para inicio de sesión.',
  `Contraseña` varchar(255) NOT NULL COMMENT 'Contraseña encriptada.',
  `rol` varchar(50) NOT NULL COMMENT 'para identificar si el usuario es donante o receptor.',
  `telefono` varchar(50) NOT NULL COMMENT 'Teléfono del usuario.',
  `Latitud` decimal(10,8) NOT NULL COMMENT 'Latitud de la ubicación, en formato GPS para mostrar un punto en el mapa.',
  `Longitud` decimal(11,8) NOT NULL COMMENT 'ubicación, en formato GPS para mostrar un punto en el mapa.',
  `activo` varchar(1) NOT NULL COMMENT 'me especifica si mi usario permanece activo o no en su cuenta.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `codigo_verificacion`
--
ALTER TABLE `codigo_verificacion`
  ADD PRIMARY KEY (`id_cod`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD PRIMARY KEY (`id_direccion`),
  ADD KEY `id_usuario_direcc` (`id_usuario_direcc`);

--
-- Indices de la tabla `donacion`
--
ALTER TABLE `donacion`
  ADD PRIMARY KEY (`id_donacion`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `donante`
--
ALTER TABLE `donante`
  ADD PRIMARY KEY (`id_usu_donante`);

--
-- Indices de la tabla `estadistica`
--
ALTER TABLE `estadistica`
  ADD PRIMARY KEY (`id_estadistica`),
  ADD KEY `id_donacion` (`id_donacion`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `productos_donante`
--
ALTER TABLE `productos_donante`
  ADD PRIMARY KEY (`id_producto_donante`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_donante` (`id_donante`);

--
-- Indices de la tabla `receptor`
--
ALTER TABLE `receptor`
  ADD PRIMARY KEY (`id_usu_receptor`);

--
-- Indices de la tabla `stock_donaciones`
--
ALTER TABLE `stock_donaciones`
  ADD PRIMARY KEY (`id_Stock_donaciones`),
  ADD KEY `id_usuario_donante` (`id_usuario_donante`);

--
-- Indices de la tabla `stock_productos_donacion`
--
ALTER TABLE `stock_productos_donacion`
  ADD PRIMARY KEY (`id_stock_productos_donaciones`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `Stock__Donaciones` (`Stock__Donaciones`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `codigo_verificacion`
--
ALTER TABLE `codigo_verificacion`
  ADD CONSTRAINT `codigo_verificacion_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD CONSTRAINT `direcciones_ibfk_1` FOREIGN KEY (`id_usuario_direcc`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `donacion`
--
ALTER TABLE `donacion`
  ADD CONSTRAINT `donacion_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `donante`
--
ALTER TABLE `donante`
  ADD CONSTRAINT `donante_ibfk_1` FOREIGN KEY (`id_usu_donante`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `estadistica`
--
ALTER TABLE `estadistica`
  ADD CONSTRAINT `estadistica_ibfk_1` FOREIGN KEY (`id_donacion`) REFERENCES `donacion` (`id_donacion`);

--
-- Filtros para la tabla `productos_donante`
--
ALTER TABLE `productos_donante`
  ADD CONSTRAINT `productos_donante_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`),
  ADD CONSTRAINT `productos_donante_ibfk_2` FOREIGN KEY (`id_donante`) REFERENCES `donante` (`id_usu_donante`);

--
-- Filtros para la tabla `receptor`
--
ALTER TABLE `receptor`
  ADD CONSTRAINT `receptor_ibfk_1` FOREIGN KEY (`id_usu_receptor`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `receptor_ibfk_2` FOREIGN KEY (`id_usu_receptor`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `stock_donaciones`
--
ALTER TABLE `stock_donaciones`
  ADD CONSTRAINT `stock_donaciones_ibfk_1` FOREIGN KEY (`id_usuario_donante`) REFERENCES `donante` (`id_usu_donante`);

--
-- Filtros para la tabla `stock_productos_donacion`
--
ALTER TABLE `stock_productos_donacion`
  ADD CONSTRAINT `stock_productos_donacion_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`),
  ADD CONSTRAINT `stock_productos_donacion_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`),
  ADD CONSTRAINT `stock_productos_donacion_ibfk_3` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`),
  ADD CONSTRAINT `stock_productos_donacion_ibfk_4` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`),
  ADD CONSTRAINT `stock_productos_donacion_ibfk_5` FOREIGN KEY (`Stock__Donaciones`) REFERENCES `stock_donaciones` (`id_Stock_donaciones`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
