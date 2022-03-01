-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-12-2021 a las 18:10:57
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda_de_ofertas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carro`
--

CREATE TABLE `carro` (
  `id_carro` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `fecha_carro` datetime NOT NULL,
  `estado_carro` int(11) NOT NULL,
  `monto_carro` float DEFAULT NULL,
  `offercrips_carro` float NOT NULL,
  `formapago_carro` int(11) DEFAULT NULL,
  `formaenvio_carro` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `carro`
--

INSERT INTO `carro` (`id_carro`, `id_usuario`, `fecha_carro`, `estado_carro`, `monto_carro`, `offercrips_carro`, `formapago_carro`, `formaenvio_carro`) VALUES
(16, 1, '2021-12-30 18:10:24', 1, 32000, 6400, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carro_estados`
--

CREATE TABLE `carro_estados` (
  `id_estado_carro` int(11) NOT NULL,
  `nombre_estado_carro` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `carro_estados`
--

INSERT INTO `carro_estados` (`id_estado_carro`, `nombre_estado_carro`) VALUES
(1, 'EN CURSO'),
(2, 'CONFIRMADO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_pedido`
--

CREATE TABLE `estado_pedido` (
  `id_estado` int(11) NOT NULL,
  `nombre_estado` varchar(300) NOT NULL,
  `descripcion_estado` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estado_pedido`
--

INSERT INTO `estado_pedido` (`id_estado`, `nombre_estado`, `descripcion_estado`) VALUES
(1, 'CONFIRMADO', 'El pedido ha sido confirmado por el cliente'),
(2, 'ENTREGADO', 'El pedido ha sido entregado al cliente'),
(3, 'CANCELADO', 'El pedido ha sido cancelado por el cliente'),
(4, 'PENDIENTE', 'El pedido está pendiente de pago');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forma_envio`
--

CREATE TABLE `forma_envio` (
  `id_formaenvio` int(11) NOT NULL,
  `nombre_formaenvio` varchar(300) NOT NULL,
  `descripcion_formaenvio` varchar(300) NOT NULL,
  `activo_formaenvio` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `forma_envio`
--

INSERT INTO `forma_envio` (`id_formaenvio`, `nombre_formaenvio`, `descripcion_formaenvio`, `activo_formaenvio`) VALUES
(1, 'Sucursal', 'Retiro en sucursal - Horario: Lunes a Viernes, 10:00 hs. a 20:00 hs.', b'1'),
(2, 'Domicilio', 'Entrega a domicilio', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forma_pago`
--

CREATE TABLE `forma_pago` (
  `id_formapago` int(11) NOT NULL,
  `nombre_formapago` varchar(300) NOT NULL,
  `descripcion_formapago` varchar(300) NOT NULL,
  `activo_formapago` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `forma_pago`
--

INSERT INTO `forma_pago` (`id_formapago`, `nombre_formapago`, `descripcion_formapago`, `activo_formapago`) VALUES
(1, 'Contado', 'Aboná tu compra en efectivo', b'1'),
(2, 'Offercrips', 'Aboná tu compra con Offercrips', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `item_carro`
--

CREATE TABLE `item_carro` (
  `id_item` int(11) NOT NULL,
  `id_carro` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `precio_unitario` float NOT NULL,
  `valor_offercrips` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `total_item` float NOT NULL,
  `total_offercrips_item` float NOT NULL,
  `suma_offercrips` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `item_pedido`
--

CREATE TABLE `item_pedido` (
  `id_pedido` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `precio_unitario_item` float NOT NULL,
  `valor_offercrips` float NOT NULL,
  `cantidad_item` int(11) NOT NULL,
  `precio_total_item` float NOT NULL,
  `total_offercrips_item` float NOT NULL,
  `suma_offercrips` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `item_pedido`
--

INSERT INTO `item_pedido` (`id_pedido`, `id_item`, `id_producto`, `precio_unitario_item`, `valor_offercrips`, `cantidad_item`, `precio_total_item`, `total_offercrips_item`, `suma_offercrips`) VALUES
(1, 1, 4, 28000, 5600, 2, 56000, 11200, 2800),
(2, 1, 1, 25000, 5000, 1, 25000, 5000, 1500),
(3, 1, 4, 28000, 5600, 2, 56000, 11200, 2800),
(3, 2, 1, 25000, 5000, 1, 25000, 5000, 1500),
(4, 1, 1, 25000, 5000, 1, 25000, 5000, 1500),
(4, 2, 2, 32000, 6400, 1, 32000, 6400, 1600),
(5, 1, 1, 25000, 5000, 1, 25000, 5000, 1500);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `id_pedido` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_pedido` datetime NOT NULL,
  `estado_pedido` int(11) NOT NULL,
  `monto_pedido` float NOT NULL,
  `offercrips_pedido` float NOT NULL,
  `formapago_pedido` int(11) NOT NULL,
  `formaenvio_pedido` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`id_pedido`, `id_usuario`, `fecha_pedido`, `estado_pedido`, `monto_pedido`, `offercrips_pedido`, `formapago_pedido`, `formaenvio_pedido`) VALUES
(1, 1, '2021-12-30 16:22:13', 4, 56000, 11200, 1, 1),
(2, 1, '2021-12-30 16:24:41', 1, 25000, 5000, 2, 2),
(3, 2, '2021-12-30 16:28:54', 4, 81000, 16200, 1, 2),
(4, 2, '2021-12-30 17:32:32', 1, 57000, 11400, 2, 2),
(5, 1, '2021-12-30 17:35:35', 1, 25000, 5000, 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(300) NOT NULL,
  `apellido_usuario` varchar(300) NOT NULL,
  `email_usuario` varchar(500) NOT NULL,
  `contrasenia_usuario` varchar(300) NOT NULL,
  `domicilio_usuario` varchar(300) NOT NULL,
  `telefono_usuario` varchar(300) NOT NULL,
  `fechaalta_usuario` datetime NOT NULL,
  `ultimologin_usuario` datetime NOT NULL,
  `offercrips` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre_usuario`, `apellido_usuario`, `email_usuario`, `contrasenia_usuario`, `domicilio_usuario`, `telefono_usuario`, `fechaalta_usuario`, `ultimologin_usuario`, `offercrips`) VALUES
(1, 'Cosme', 'Fulanito', 'cosmefulanito@gmail.com', '$2y$10$V..Zy8AS6Bp8MbOwDgnsX..fqwHIjg8GammJSBS1WYmUsRvuNo0j2', 'Laprida 5214', '0800-55-245', '2021-12-30 16:19:34', '2021-12-30 17:34:21', 5800),
(2, 'Juan Bautista', 'Sabadú', 'juanbautista@gmail.com', '$2y$10$1MlCtJNCJJLyB9rp9e2Qp.hhtm6B2Be/Y1IJXATNvCxs3YohFNxYe', 'Colón 100', '0800-999-522', '2021-12-30 16:28:07', '2021-12-30 17:31:05', 6000);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carro`
--
ALTER TABLE `carro`
  ADD PRIMARY KEY (`id_carro`),
  ADD UNIQUE KEY `id_usuario` (`id_usuario`),
  ADD KEY `FK_CARRO_ENVIO` (`formaenvio_carro`),
  ADD KEY `FK_CARRO_PAGO` (`formapago_carro`),
  ADD KEY `FK_CARRO_ESTADO` (`estado_carro`);

--
-- Indices de la tabla `carro_estados`
--
ALTER TABLE `carro_estados`
  ADD PRIMARY KEY (`id_estado_carro`);

--
-- Indices de la tabla `estado_pedido`
--
ALTER TABLE `estado_pedido`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `forma_envio`
--
ALTER TABLE `forma_envio`
  ADD PRIMARY KEY (`id_formaenvio`);

--
-- Indices de la tabla `forma_pago`
--
ALTER TABLE `forma_pago`
  ADD PRIMARY KEY (`id_formapago`);

--
-- Indices de la tabla `item_carro`
--
ALTER TABLE `item_carro`
  ADD PRIMARY KEY (`id_item`,`id_carro`),
  ADD KEY `id_carro` (`id_carro`);

--
-- Indices de la tabla `item_pedido`
--
ALTER TABLE `item_pedido`
  ADD PRIMARY KEY (`id_pedido`,`id_item`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `FK_PEDIDO_USUARIO` (`id_usuario`),
  ADD KEY `FK_PEDIDO_ESTADO` (`estado_pedido`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carro`
--
ALTER TABLE `carro`
  MODIFY `id_carro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `carro_estados`
--
ALTER TABLE `carro_estados`
  MODIFY `id_estado_carro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `estado_pedido`
--
ALTER TABLE `estado_pedido`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `forma_envio`
--
ALTER TABLE `forma_envio`
  MODIFY `id_formaenvio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `forma_pago`
--
ALTER TABLE `forma_pago`
  MODIFY `id_formapago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carro`
--
ALTER TABLE `carro`
  ADD CONSTRAINT `FK_CARRO_ENVIO` FOREIGN KEY (`formaenvio_carro`) REFERENCES `forma_envio` (`id_formaenvio`),
  ADD CONSTRAINT `FK_CARRO_ESTADO` FOREIGN KEY (`estado_carro`) REFERENCES `carro_estados` (`id_estado_carro`),
  ADD CONSTRAINT `FK_CARRO_PAGO` FOREIGN KEY (`formapago_carro`) REFERENCES `forma_pago` (`id_formapago`),
  ADD CONSTRAINT `FK_USUARIO_CARRO` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `item_carro`
--
ALTER TABLE `item_carro`
  ADD CONSTRAINT `FK_ITEM_CARRO` FOREIGN KEY (`id_carro`) REFERENCES `carro` (`id_carro`);

--
-- Filtros para la tabla `item_pedido`
--
ALTER TABLE `item_pedido`
  ADD CONSTRAINT `FK_ITEM_PEDIDO` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`);

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `FK_PEDIDO_ESTADO` FOREIGN KEY (`estado_pedido`) REFERENCES `estado_pedido` (`id_estado`),
  ADD CONSTRAINT `FK_PEDIDO_USUARIO` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
