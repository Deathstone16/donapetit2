-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-10-2025 a las 02:22:52
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
-- Estructura de tabla para la tabla `cargar_productos`
--

CREATE TABLE `cargar_productos` (
  `id_carga` int(11) NOT NULL,
  `id_productos` int(11) NOT NULL COMMENT 'hace referencia a la tabla productos.',
  `id_unidades` int(11) NOT NULL COMMENT 'hace referencia a la tabla unidades.',
  `id_categorias` int(11) NOT NULL COMMENT 'hace referencia a la tabla categorias.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL COMMENT 'especifica el nombre de la categoria.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `id_productos` int(11) NOT NULL COMMENT 'referencia al producto.',
  `cantidad_donado` int(11) NOT NULL COMMENT 'cantidad del producto donado\r\n',
  `create_at` datetime NOT NULL,
  `id_retiros` int(11) NOT NULL COMMENT 'hace referencia a la tabla retiros  para saber si la donacion fue realizada.\r\n',
  `update_at` datetime NOT NULL
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
-- Estructura de tabla para la tabla `imagenes_productos.`
--

CREATE TABLE `imagenes_productos.` (
  `id_imagenes` int(11) NOT NULL,
  `id_productos` int(11) NOT NULL COMMENT 'hace referencia la tabla producto',
  `url` varchar(2083) NOT NULL,
  `create_at` datetime NOT NULL,
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_productos` int(11) NOT NULL COMMENT 'Identificador del producto. Auto Incremento.',
  `create_at` datetime NOT NULL COMMENT 'registro de tiempo almacenar la fecha y hora exactas en que se creó una fila o registro específico. ',
  `update_at` datetime NOT NULL COMMENT 'registro de tiempo para almacenar la fecha y hora exactas de la última vez que se modificó una fila o registro.',
  `comentario` varchar(255) NOT NULL COMMENT 'información adicional(marca o empaque).'
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
-- Estructura de tabla para la tabla `retiros`
--

CREATE TABLE `retiros` (
  `id_retiro` int(11) NOT NULL,
  `fecha_programada` datetime NOT NULL COMMENT 'fecha estimada de retiro de productos',
  `fecha_retiro` datetime NOT NULL COMMENT 'fecha real en la que fueron retirados los productos',
  `estado` tinyint(1) NOT NULL COMMENT 'para saber si los productos fueron entregados.',
  `id_direcciones` int(11) NOT NULL COMMENT 'para saber en que direccion retirar el producto',
  `detalles` varchar(255) NOT NULL COMMENT 'informacion adicional sobre el retiro.',
  `create_at` datetime NOT NULL,
  `delete_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `id_solicitud` int(11) NOT NULL,
  `id_donante` int(11) NOT NULL COMMENT 'hace referencia a la organizacion donante.',
  `id_productos` int(11) NOT NULL COMMENT 'hace referencia a la tabla prodcutos para conocer detalles.',
  `cantidad_solicitada` int(11) NOT NULL COMMENT 'cantidad de productos solicitados.',
  `create_at` datetime NOT NULL COMMENT 'para saber la fecha y hora en que se realizo la solicitud.',
  `estado` tinyint(1) NOT NULL COMMENT 'para saber si la solicitud fue confirmada o no.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock_productos`
--

CREATE TABLE `stock_productos` (
  `id_stock` int(11) NOT NULL,
  `id_donante` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL COMMENT 'cantidad de productos en stock.',
  `id_producto` int(11) NOT NULL,
  `create_at` datetime NOT NULL,
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock_productos_donacion`
--

CREATE TABLE `stock_productos_donacion` (
  `id_stock_productos_donaciones` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL COMMENT 'referencia al producto.',
  `stock_productos` int(11) NOT NULL COMMENT 'Referencia a la tabla stock productos'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades`
--

CREATE TABLE `unidades` (
  `id_unidad` int(11) NOT NULL,
  `nombre_unidad` varchar(50) NOT NULL COMMENT 'por ejemplo(kilogramo, gramos, litros,etc).',
  `abreviatura` int(10) NOT NULL COMMENT 'por ejemplo(kg,lts,g,etc).',
  `estado` tinyint(1) NOT NULL COMMENT 'control de estado para saber si esta activo o inactivo.'
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
-- Indices de la tabla `cargar_productos`
--
ALTER TABLE `cargar_productos`
  ADD PRIMARY KEY (`id_carga`),
  ADD KEY `FK_unidadCargada` (`id_unidades`),
  ADD KEY `FK_productoCarga` (`id_productos`),
  ADD KEY `FK_categoriaCarga` (`id_categorias`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

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
  ADD KEY `id_producto` (`id_productos`);

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
-- Indices de la tabla `imagenes_productos.`
--
ALTER TABLE `imagenes_productos.`
  ADD PRIMARY KEY (`id_imagenes`),
  ADD KEY `FK_productoImagen` (`id_productos`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_productos`);

--
-- Indices de la tabla `receptor`
--
ALTER TABLE `receptor`
  ADD PRIMARY KEY (`id_usu_receptor`);

--
-- Indices de la tabla `retiros`
--
ALTER TABLE `retiros`
  ADD PRIMARY KEY (`id_retiro`),
  ADD KEY `FK_direccionRetiro` (`id_direcciones`);

--
-- Indices de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD PRIMARY KEY (`id_solicitud`),
  ADD KEY `FK_donanteSolicitud` (`id_donante`),
  ADD KEY `FK_productoSolicitud` (`id_productos`);

--
-- Indices de la tabla `stock_productos`
--
ALTER TABLE `stock_productos`
  ADD PRIMARY KEY (`id_stock`),
  ADD KEY `FK_STOCKproducto` (`id_producto`),
  ADD KEY `FK_STOCKdonante` (`id_donante`);

--
-- Indices de la tabla `stock_productos_donacion`
--
ALTER TABLE `stock_productos_donacion`
  ADD PRIMARY KEY (`id_stock_productos_donaciones`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `Stock__Donaciones` (`stock_productos`);

--
-- Indices de la tabla `unidades`
--
ALTER TABLE `unidades`
  ADD PRIMARY KEY (`id_unidad`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `unidades`
--
ALTER TABLE `unidades`
  MODIFY `id_unidad` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cargar_productos`
--
ALTER TABLE `cargar_productos`
  ADD CONSTRAINT `FK_categoriaCarga` FOREIGN KEY (`id_categorias`) REFERENCES `categorias` (`id_categoria`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_productoCarga` FOREIGN KEY (`id_productos`) REFERENCES `productos` (`id_productos`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_unidadCargada` FOREIGN KEY (`id_unidades`) REFERENCES `unidades` (`id_unidad`) ON UPDATE CASCADE;

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
  ADD CONSTRAINT `donacion_ibfk_1` FOREIGN KEY (`id_productos`) REFERENCES `productos` (`id_productos`);

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
-- Filtros para la tabla `imagenes_productos.`
--
ALTER TABLE `imagenes_productos.`
  ADD CONSTRAINT `FK_productoImagen` FOREIGN KEY (`id_productos`) REFERENCES `imagenes_productos.` (`id_imagenes`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `receptor`
--
ALTER TABLE `receptor`
  ADD CONSTRAINT `receptor_ibfk_1` FOREIGN KEY (`id_usu_receptor`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `receptor_ibfk_2` FOREIGN KEY (`id_usu_receptor`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `retiros`
--
ALTER TABLE `retiros`
  ADD CONSTRAINT `FK_direccionRetiro` FOREIGN KEY (`id_direcciones`) REFERENCES `direcciones` (`id_direccion`);

--
-- Filtros para la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD CONSTRAINT `FK_donanteSolicitud` FOREIGN KEY (`id_donante`) REFERENCES `donante` (`id_usu_donante`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_productoSolicitud` FOREIGN KEY (`id_productos`) REFERENCES `productos` (`id_productos`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `stock_productos`
--
ALTER TABLE `stock_productos`
  ADD CONSTRAINT `FK_STOCKdonante` FOREIGN KEY (`id_donante`) REFERENCES `donante` (`id_usu_donante`),
  ADD CONSTRAINT `FK_STOCKproducto` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_productos`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `stock_productos_donacion`
--
ALTER TABLE `stock_productos_donacion`
  ADD CONSTRAINT `stock_productos_donacion_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_productos`),
  ADD CONSTRAINT `stock_productos_donacion_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_productos`),
  ADD CONSTRAINT `stock_productos_donacion_ibfk_3` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_productos`),
  ADD CONSTRAINT `stock_productos_donacion_ibfk_4` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_productos`),
  ADD CONSTRAINT `stock_productos_donacion_ibfk_5` FOREIGN KEY (`stock_productos`) REFERENCES `stock_donaciones` (`id_Stock_donaciones`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
