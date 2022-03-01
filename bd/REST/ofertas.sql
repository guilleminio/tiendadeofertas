-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-12-2021 a las 16:01:31
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
-- Base de datos: `ofertas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oferta`
--

CREATE TABLE `oferta` (
  `id_oferta` int(11) NOT NULL,
  `nombre_oferta` varchar(300) NOT NULL,
  `descripcion_oferta` varchar(500) NOT NULL,
  `imagen_oferta` varchar(500) NOT NULL,
  `monto_oferta` float NOT NULL,
  `descuento_oferta` int(11) NOT NULL,
  `producto_oferta` int(11) NOT NULL,
  `marca_oferta` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `oferta`
--

INSERT INTO `oferta` (`id_oferta`, `nombre_oferta`, `descripcion_oferta`, `imagen_oferta`, `monto_oferta`, `descuento_oferta`, `producto_oferta`, `marca_oferta`) VALUES
(1, 'HACÉ RUGIR TUS PIES', 'Safari en tus pies!', 'http://localhost/INTERFACES_PROGRAMACION_VISUAL/TP_FINAL/TIENDA_DE_OFERTAS/REST/imagenes/nike/oferta_1.jpg', 25000, 30, 1, 'NIKE'),
(2, 'VUELA AL ESTILO DE JORDAN', 'SALTÁ MÁS ALTO QUE NUNCA', 'http://localhost/INTERFACES_PROGRAMACION_VISUAL/TP_FINAL/TIENDA_DE_OFERTAS/REST/imagenes/nike/oferta_2.jpg', 32000, 25, 2, 'NIKE'),
(3, 'CUIDEMOS EL MEDIO AMBIENTE', 'Cuidá el medio ambiente con estas zapatillas recicladas', 'http://localhost/INTERFACES_PROGRAMACION_VISUAL/TP_FINAL/TIENDA_DE_OFERTAS/REST/imagenes/nike/oferta_3.jpg', 0, 15, 3, 'NIKE'),
(4, 'FÚTBOL EN VERANO', 'Camiseta del Barça', 'http://localhost/INTERFACES_PROGRAMACION_VISUAL/TP_FINAL/TIENDA_DE_OFERTAS/REST/imagenes/nike/oferta_4.jpg', 28000, 25, 4, 'NIKE'),
(5, 'ALENTEMOS A LA SELECCIÓN!', 'Ponete los colores de la selección!', 'http://localhost/INTERFACES_PROGRAMACION_VISUAL/TP_FINAL/TIENDA_DE_OFERTAS/REST/imagenes/nike/oferta_5.jpg', 30000, 40, 5, 'NIKE'),
(6, 'MANTENETE EN FORMA', 'Continuá entrenando durante el verano', 'http://localhost/INTERFACES_PROGRAMACION_VISUAL/TP_FINAL/TIENDA_DE_OFERTAS/REST/imagenes/nike/oferta_6.jpg', 22000, 25, 6, 'NIKE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `nombre_producto` varchar(300) NOT NULL,
  `descripcion_producto` varchar(800) NOT NULL,
  `codigo_producto` varchar(50) NOT NULL,
  `precio_contado_producto` float NOT NULL,
  `stock_producto` int(11) NOT NULL,
  `imagen_producto` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `nombre_producto`, `descripcion_producto`, `codigo_producto`, `precio_contado_producto`, `stock_producto`, `imagen_producto`) VALUES
(1, 'AIR FORCE 1 COCONUT', 'Canaliza tu animal interno con el Nike Air Force 1 Premium, el calzado original del básquetbol renueva un estilo que conoces bien: cuero firme, colores limpios y la cantidad perfecta de luz para hacerte brillar. Con revestimientos de estampado animal y el logotipo de Swoosh liso este AF1 es un safari para los pies.', 'DJ6192100', 25000, 10, 'http://localhost/INTERFACES_PROGRAMACION_VISUAL/TP_FINAL/TIENDA_DE_OFERTAS/REST/imagenes/nike/zapatillas/AIR_FORCE_1_07_PRM_COCONUT/1.jpg'),
(2, 'Air Jordan 5 Retro\r\n', 'Lanzado originalmente en 2009, esta combinación de colores ardientes finalmente está regresando. El look ve el diseño singular del Air Jordan 5 bañado en un tono atrevido de University Red. La gamuza premium le da al estilo una sensación de lujo, mientras que los gráficos cosidos y la marca inspirada en el legado recuerdan los días de gloria de la silueta en la cancha.', 'DD0587600', 32000, 5, 'http://localhost/INTERFACES_PROGRAMACION_VISUAL/TP_FINAL/TIENDA_DE_OFERTAS/REST/imagenes\\nike/zapatillas/AIR_JORDAN_5/1.jpg'),
(3, 'NIKE SPACE HIPPIE 04', 'Space Hippie es una historia de residuos reciclados. Desde la parte superior hasta la suela, el Space Hippie 04 está confeccionado con al menos 25% de su peso en material reciclado. No solo es el estilo más ligero dentro de la colección, sino que también tiene la huella de carbono más baja. La parte superior \"Space Waste Yarn\" incluye alrededor de un 75% de contenido reciclado por peso, y está confeccionada con botellas de plástico, playeras y trozos de hilo reciclados. La entresuela suave de espuma Crater combina Nike Grind con una mezcla de espumas para brindar estabilidad y una estética única.', 'CZ6398010', 35000, 15, 'http://localhost/INTERFACES_PROGRAMACION_VISUAL/TP_FINAL/TIENDA_DE_OFERTAS/REST/imagenes/nike/zapatillas/SPACE_HIPPIE_04/1.jpg'),
(4, 'CAMISETA BARCELONA FC STADIUM HOME 2021/2022', 'Color 	Bicolor\r\nDisciplina 	Fútbol\r\nModelo 	Cuello redondo\r\nClub 	Barcelona\r\nGénero 	Hombre\r\nCalce 	Regular Fit\r\nMaterial 	Poliéster\r\nTemporada 	Atemporal', 'CV7891-428', 28000, 20, 'http://localhost/INTERFACES_PROGRAMACION_VISUAL/TP_FINAL/TIENDA_DE_OFERTAS/REST/imagenes/nike/indumentaria/BARCELONA/1.jpg'),
(5, 'PANTALÓN BÁSQUET SELECCIÓN ARGENTINA', 'Marca 	Nike\r\nColor 	Negro\r\nCierres bolsillos delanteros 	No\r\nImpermeable 	No\r\nBolsillos 	3\r\nDisciplina 	Básquet\r\nCalce 	Slim Fit\r\nClub 	Argentina\r\nGénero 	Mujer\r\nMaterial 	Algodón\r\nTemporada 	Atemporal\r\nTipo de producto 	Pantalones\r\nOrigen 	Importado', 'CD5066-010', 30000, 40, 'http://localhost/INTERFACES_PROGRAMACION_VISUAL/TP_FINAL/TIENDA_DE_OFERTAS/REST/imagenes/nike/indumentaria/PANTALON_NIKE_ARGENTINA_2020/1.jpg'),
(6, 'PANTALON NIKE DRI FIT STRIKE', 'Marca 	Nike\r\nColor 	Gris\r\nCierres bolsillos delanteros 	Yes\r\nImpermeable 	No\r\nBolsillos 	2\r\nDisciplina 	Fútbol\r\nCalce 	Slim Fit\r\nClub 	-\r\nGénero 	Hombre\r\nMaterial 	Poliéster\r\nTemporada 	Atemporal\r\nTipo de producto 	Pantalones\r\nOrigen 	Importado', 'CW5862-019_0', 22000, 15, 'http://localhost/INTERFACES_PROGRAMACION_VISUAL/TP_FINAL/TIENDA_DE_OFERTAS/REST/imagenes/nike/indumentaria/PANTALON_NIKE_DRI_FIT_STRIKE/1.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `oferta`
--
ALTER TABLE `oferta`
  ADD PRIMARY KEY (`id_oferta`),
  ADD KEY `FK_OFERTA_PRODUCTO` (`producto_oferta`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `oferta`
--
ALTER TABLE `oferta`
  MODIFY `id_oferta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `oferta`
--
ALTER TABLE `oferta`
  ADD CONSTRAINT `FK_OFERTA_PRODUCTO` FOREIGN KEY (`producto_oferta`) REFERENCES `producto` (`id_producto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
