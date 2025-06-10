-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-06-2025 a las 14:35:53
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
-- Base de datos: `rapiexpress`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `cedula` varchar(100) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `estado` enum('activo','inactivo') DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `cedula`, `nombre`, `apellido`, `email`, `telefono`, `direccion`, `fecha_registro`, `estado`) VALUES
(13, '00000007', 'loco', 'juans', 'loco@gmail.com', '0234342', 'tuko', '2025-05-31 01:47:46', 'inactivo'),
(14, '1181039599', 'Jean Carlos', 'Leal Guedez', 'jeancleal030220.04@gmail.com', '04268092177', 'Carrera 18\r\nSanta Eduvigis', '2025-06-01 14:14:13', 'inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `couriers`
--

CREATE TABLE `couriers` (
  `id_courier` int(11) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion` varchar(150) NOT NULL,
  `tipo` enum('Propio','Asociado') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `couriers`
--

INSERT INTO `couriers` (`id_courier`, `codigo`, `nombre`, `direccion`, `tipo`) VALUES
(2, 'RE00002', 'Courier Express 24H', 'Calle Real, Local 4, Cabudare', 'Asociado'),
(4, 'RE00004', 'FastCourier Lara', 'Av. Libertador, Torre A', 'Propio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paquetes`
--

CREATE TABLE `paquetes` (
  `id_paquete` int(11) NOT NULL,
  `tracking_tienda` varchar(100) NOT NULL,
  `nuevo_tracking` varchar(100) NOT NULL,
  `id_tienda` int(11) DEFAULT NULL,
  `id_courier` int(11) NOT NULL,
  `categoria` enum('4x4','C-Costo') NOT NULL,
  `peso_libra` decimal(10,2) NOT NULL,
  `peso_kilogramo` decimal(10,2) NOT NULL,
  `cantidad_piezas` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_cliente_receptor` int(11) NOT NULL,
  `nombre_receptor` varchar(100) NOT NULL,
  `apellido_receptor` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `sede` enum('ven','usa','ecuador') NOT NULL,
  `estado` enum('entrada','consolidado','carga','traslado','entregado','fallido') NOT NULL DEFAULT 'entrada',
  `fecha_registro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiendas`
--

CREATE TABLE `tiendas` (
  `id_tienda` int(11) NOT NULL,
  `tracking` varchar(100) NOT NULL,
  `nombre_tienda` varchar(255) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tiendas`
--

INSERT INTO `tiendas` (`id_tienda`, `tracking`, `nombre_tienda`, `fecha_registro`) VALUES
(5, 'TRK-0046', 'Moda Express', '2025-05-19 15:48:14'),
(6, 'TRK-005', 'Supermercado La Estrella', '2025-05-19 15:48:14'),
(7, 'kl', '23', '2025-05-19 15:58:47'),
(8, 'ssas', 'ssss', '2025-05-19 16:22:49'),
(9, 'sad', 'assddd', '2025-05-19 16:39:50'),
(10, 'TRK-0038', '23', '2025-05-19 16:43:44'),
(11, 'SSSSS', 'ssss', '2025-05-19 17:40:22'),
(12, 'P`P`L', '000000000', '2025-05-19 21:03:39'),
(13, 'klkllññ', 'Electro Hogarjkkj', '2025-05-30 07:33:31'),
(14, 'ñlk,ñ', 'Tienda Centralioo', '2025-05-30 07:57:52'),
(15, 'ssasjk', 'Tienda Centri6', '2025-05-31 01:04:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `documento` varchar(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `sucursal` enum('sucursal_usa','sucursal_ec','sucursal_ven') NOT NULL,
  `password` varchar(255) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `cargo` enum('encargado_bodega','jefe_logística','jefe_operaciones') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `documento`, `username`, `nombres`, `apellidos`, `telefono`, `email`, `sucursal`, `password`, `fecha_registro`, `cargo`) VALUES
(20, '31152335', 'yankocompany', 'Jean Carlos', 'Leal Guedez', '+584268092177', 'jeancleal03022004@gmail.com', 'sucursal_ven', '$2y$10$ppYEjDUQzf.eDCSV.8hyFuiKFk9xP4SbdsI3xIjQ7sz/k4YKMSuIq', '2025-06-01 15:20:49', 'encargado_bodega'),
(23, '8989', 'yankocompkany', 'Jean Carlos', 'Leal Guedez', '04268092177', 'jeanclkkkeal03022004@gmail.com', 'sucursal_ven', '$2y$10$0hlU6wRKVZzx1QHIfHM80.Zse8UqpRSKughC5ZjbNec3K9HZfCAjq', '2025-06-05 05:08:37', 'encargado_bodega');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `couriers`
--
ALTER TABLE `couriers`
  ADD PRIMARY KEY (`id_courier`),
  ADD UNIQUE KEY `codigo` (`codigo`);

--
-- Indices de la tabla `paquetes`
--
ALTER TABLE `paquetes`
  ADD PRIMARY KEY (`id_paquete`),
  ADD UNIQUE KEY `nuevo_tracking` (`nuevo_tracking`),
  ADD KEY `id_tienda` (`id_tienda`),
  ADD KEY `id_courier` (`id_courier`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indices de la tabla `tiendas`
--
ALTER TABLE `tiendas`
  ADD PRIMARY KEY (`id_tienda`),
  ADD UNIQUE KEY `tracking` (`tracking`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `couriers`
--
ALTER TABLE `couriers`
  MODIFY `id_courier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `paquetes`
--
ALTER TABLE `paquetes`
  MODIFY `id_paquete` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tiendas`
--
ALTER TABLE `tiendas`
  MODIFY `id_tienda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `paquetes`
--
ALTER TABLE `paquetes`
  ADD CONSTRAINT `paquetes_ibfk_1` FOREIGN KEY (`id_tienda`) REFERENCES `tiendas` (`id_tienda`) ON DELETE SET NULL,
  ADD CONSTRAINT `paquetes_ibfk_2` FOREIGN KEY (`id_courier`) REFERENCES `couriers` (`id_courier`),
  ADD CONSTRAINT `paquetes_ibfk_3` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
