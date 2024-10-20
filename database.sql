-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 16-09-2020 a las 16:37:17
-- Versión del servidor: 10.5.5-MariaDB-1:10.5.5+maria~focal
-- Versión de PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `database`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `dni` char(10) NOT NULL,
  `nombre` text NOT NULL,
  `telefono` text NOT NULL,
  `fecha` text NOT NULL,
  `email` text NOT NULL,
  `username` varchar(50) NOT NULL,
  `contraseña` text NOT NULL,
  PRIMARY KEY(`username`),
  UNIQUE(`DNI`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `videojuegos`(
  `id` INT AUTO_INCREMENT NOT NULL,
  `titulo` text NOT NULL,
  `desarrolladora` text NOT NULL,
  `rating` float DEFAULT 0,
  `precio` float NOT NULL,
  `genero` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`dni`, `nombre`, `telefono`, `fecha`, `email`, `username`, `contraseña`) VALUES
  ('12345678-A', 'mikel', '123456789', '2000-01-01', 'mikel@gmail.com', 'a', 'a'),
  ('12345678-B', 'aitor', '222444666', '2000-06-01', 'ait@outlook.com', 'b', 'b');

INSERT INTO `videojuegos` (`id`, `titulo`, `desarrolladora`, `rating`, `precio`,`genero`) VALUES
(1, 'The Legend of Zelda: Breath of the Wild', 'Nintendo', 9.7, 59.99, 'Aventura'),
(2, 'God of War', 'Santa Monica Studio', 9.8, 39.99, 'Acción'),
(3, 'Red Dead Redemption 2', 'Rockstar Games', 9.5, 49.99, 'Acción/Aventura'),
(4, 'Minecraft', 'Mojang', 9.3, 26.95, 'Sandbox'),
(5, 'The Witcher 3: Wild Hunt', 'CD Projekt Red', 9.6, 29.99, 'RPG'),
(6, 'Fortnite', 'Epic Games', 8.9, 0.00, 'Battle Royale'),
(7, 'Among Us', 'InnerSloth', 8.2, 4.99, 'Multijugador'),
(8, 'Cyberpunk 2077', 'CD Projekt Red', 7.5, 59.99, 'RPG/Ciencia ficción'),
(9, 'Animal Crossing: New Horizons', 'Nintendo', 9.0, 59.99, 'Simulación'),
(10, 'Overwatch', 'Blizzard Entertainment', 8.8, 19.99, 'Shooter'),
(11, 'Halo Infinite', '343 Industries', 8.5, 59.99, 'Shooter en primera persona');
--
-- Índices para tablas volcadas
--

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
