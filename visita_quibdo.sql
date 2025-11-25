-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-11-2025 a las 07:30:58
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
-- Base de datos: `visita_quibdo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre_categoria` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre_categoria`) VALUES
(1, 'Gastronomía'),
(2, 'Artesanías'),
(3, 'Moda'),
(4, 'Servicios'),
(5, 'Belleza'),
(6, 'Tecnología'),
(7, 'viajes en carretera');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `emprendedores`
--

CREATE TABLE `emprendedores` (
  `id` int(11) NOT NULL,
  `nombre_emprendimiento` varchar(100) NOT NULL,
  `categoria` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `ubicacion` varchar(150) NOT NULL,
  `nombre_propietario` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `correo` varchar(120) NOT NULL,
  `contraseña` varchar(100) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `foto_perfil` varchar(255) NOT NULL,
  `horarios` text DEFAULT NULL,
  `servicios` text DEFAULT NULL,
  `servicios_extra` text DEFAULT NULL,
  `rol` enum('admin','emprendedor') NOT NULL DEFAULT 'emprendedor'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `emprendedores`
--

INSERT INTO `emprendedores` (`id`, `nombre_emprendimiento`, `categoria`, `descripcion`, `ubicacion`, `nombre_propietario`, `telefono`, `correo`, `contraseña`, `foto`, `foto_perfil`, `horarios`, `servicios`, `servicios_extra`, `rol`) VALUES
(3, 'Carlos', 'Artesanías', 'Vendemos tazas blancas', 'Niño jesus', 'carlos', '3123456787', 'carlos@gmail.com', '$2y$10$.aiegnjPVT5xsOHxbkgrYufa817qEau5iuuqSL36NWuhVtRDXqg.m', 'fotos/1763915198_OIP.webp', '', 'Lunes a domingos 8am-8pm', 'Atención presencial', 'ninguno', 'emprendedor'),
(4, 'Tazas colombianas', 'Artesanías', 'Vendemos tazas de colombia', 'Niño jesus', 'andres', '3123456788', 'andres@gmail.com', '$2y$10$nw8DmMJkri6AAlPPJkQ2a.tDLu6NaXzQA0z0/8srHORyg3RbTlnty', 'fotos/1763918811_taza_de_colombia-r17a8c10de81d46f4ab052add54627ca0_x7jg9_8byvr_492.jpg', '', 'Lunes a miércoles 7am-7pm', 'Atención presencial', 'ninguno', 'emprendedor'),
(6, 'Rosa', 'Gastronomía', 'Vendo empanadas', 'Barrio bolivar', 'rosa de guadalupe', '3123456786', 'rosa@gmail.com', '$2y$10$dM/Do5qJmX9d7r6CUjizRuu6Ka1KL/St1XR1dBWIn3.rCM9ub0xJ6', 'fotos/1763924915_Colombian-Empanadas.jpg', '', 'Lunes a viernes 6am-12pm', 'Domicilios', 'ninguno', 'emprendedor'),
(7, 'Mario', 'viajes en carretera', 'Servicios de viajes en bus', 'Santa ana', 'mario', '3123456734', 'mario@gmail.com', '$2y$10$7E0Uee3CrptLEMZSqvDg8ua4uP0dux09jnz9X76eFV02YIlxXwHLm', 'fotos/1763936315_2020.02-Colombia-Capa-2.webp', '', 'Todos los días 6am-6pm', 'viajes a domicilios', 'viajes a domicilios', 'emprendedor'),
(10, 'rivera', '', '', '', 'rivera', '', 'rivera@gmail.com', '$2y$10$X2mlR0MfbKOwLxf7Ix3mq.7b1mkzXw5RQ0YcMgiKlL5WFFShje4MO', 'fotos/1764013804_Captura de pantalla 2025-11-24 144828.png', '', NULL, NULL, NULL, 'admin'),
(11, 'Madera', 'Artesanías', 'Madera a domicilio', 'Barrio bolivar', 'Carlos andres', '3123456783', 'carr@gmail.com', '$2y$10$MgO4yYcBYbVDJW0BBRlWA.XXOq.S8OUDX1.praaZJvRTCUT4qb8Gm', '', '', 'Lunes a viernes 6am-6pm', 'Domicilios', '', 'emprendedor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lugares_turisticos`
--

CREATE TABLE `lugares_turisticos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `descripcion` text NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `latitud` decimal(10,8) NOT NULL,
  `longitud` decimal(11,8) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lugares_turisticos`
--

INSERT INTO `lugares_turisticos` (`id`, `nombre`, `descripcion`, `direccion`, `latitud`, `longitud`, `imagen`) VALUES
(2, 'Malecón de Quibdó', 'Uno de los sitios más visitados.\r\nIdeal para caminar, ver el río Atrato, tomar fotos y disfrutar del ambiente de la ciudad.\r\nSuele tener vendedores, música y una vista hermosa al atardecer.', 'Carrera 1-75, Quibdó 270002', 5.69642300, -76.66109600, 'fotos/1764020739_foto-1.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id` int(11) NOT NULL,
  `nombre_servicio` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id`, `nombre_servicio`) VALUES
(3, 'Atención presencial'),
(1, 'Domicilios'),
(4, 'Envíos nacionales'),
(2, 'Pedidos'),
(5, 'viajes a domicilios');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `emprendedores`
--
ALTER TABLE `emprendedores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lugares_turisticos`
--
ALTER TABLE `lugares_turisticos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_servicio` (`nombre_servicio`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `emprendedores`
--
ALTER TABLE `emprendedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `lugares_turisticos`
--
ALTER TABLE `lugares_turisticos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
