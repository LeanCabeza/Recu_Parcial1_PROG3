-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-11-2021 a las 19:16:13
-- Versión del servidor: 10.4.18-MariaDB
-- Versión de PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pizzeria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `mailUsuario` varchar(50) NOT NULL,
  `numeroPedido` varchar(50) NOT NULL,
  `fecha` date NOT NULL,
  `sabor` varchar(50) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `cantidad` varchar(50) NOT NULL,
  `foto` varchar(256) NOT NULL,
  `estado` varchar(255) NOT NULL,
  `precio` double NOT NULL DEFAULT 100
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `mailUsuario`, `numeroPedido`, `fecha`, `sabor`, `tipo`, `cantidad`, `foto`, `estado`, `precio`) VALUES
(52, 'leandro_cabeza@gmail.com', 'Pedido619e63c601366', '2021-11-24', 'Cheddar', 'piedra', '1', 'piedra-Cheddar-leandro_cabeza-2021-11-24.jpg', 'ACTIVO', 90),
(53, 'leandro_cabeza@gmail.com', 'Pedido619e6423610d0', '2021-11-24', 'Cheddar', 'piedra', '1', 'piedra-Cheddar-leandro_cabeza-2021-11-24.jpg', 'ACTIVO', 100),
(54, 'leandro_cabeza@gmail.com', 'Pedido619e643a1422b', '2021-11-24', 'Napolitana', 'piedra', '1', 'piedra-Napolitana-leandro_cabeza-2021-11-24.jpg', 'ACTIVO', 100),
(55, 'leandro_cabeza@gmail.com', 'Pedido619e7d339d32e', '2021-11-24', 'Cheddar', 'piedra', '1', 'piedra-Cheddar-leandro_cabeza-2021-11-24.jpg', 'ACTIVO', 90);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
