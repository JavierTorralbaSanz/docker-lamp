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
  `DNI` char(9) NOT NULL,
  `nombre` text NOT NULL,
  `telefono` text NOT NULL,
  `fecha` text NOT NULL,
  `email` text NOT NULL,
  PRIMARY KEY(`DNI`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `videojuegos`(
  `CodigoId` VARCHAR(50) NOT NULL,
  `Titulo` text NOT NULL,
  `Desarrolladora` text NOT NULL,
  `Rating` float DEFAULT 0,
  `Precio` float NOT NULL, 
  PRIMARY KEY (`CodigoId`)
 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--CREATE TABLE `tiene` (
  --  `CodigoId` VARCHAR(50) NOT NULL,
    --`DNIUsuario` CHAR(9) NOT NULL,
    --PRIMARY KEY (`CodigoId`, `DNIUsuario`),
    --FOREIGN KEY (`CodigoId`) REFERENCES videojuegos(`CodigoId`),
    --FOREIGN KEY (`DNIUsuario`) REFERENCES usuarios(`DNI`)  -- Cambiar "usuario" por "usuarios"
--) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `datosLogin` (
  `NombreUsuario` VARCHAR(20) NOT NULL,
  `Contraseña` VARCHAR(30) NOT NULL,
  PRIMARY KEY(`NombreUsuario`)
);

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`dni`, `nombre`) VALUES
  ('12345678A', 'mikel'),
  ('12345678B', 'aitor');

--
-- Índices para tablas volcadas
--

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
