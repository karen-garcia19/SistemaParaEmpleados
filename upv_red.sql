-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-09-2022 a las 17:16:55
-- Versión del servidor: 10.4.20-MariaDB
-- Versión de PHP: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `upv_red`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `Id_cita` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `Telefono` bigint(30) NOT NULL,
  `Description` varchar(50) NOT NULL,
  `Fechas` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`Id_cita`, `title`, `Telefono`, `Description`, `Fechas`) VALUES
(1, 'carl', 8342666114, 'soy carlos', '2022-04-13'),
(2, 'karla', 8325268952, 'No funciona router', '2022-03-29'),
(3, 'karla', 8888888888, 'No funciona el switch', '2022-04-19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE `departamentos` (
  `ID_departamento` int(11) NOT NULL,
  `Nombre_departamento` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`ID_departamento`, `Nombre_departamento`) VALUES
(1, 'Direccion general'),
(2, 'Direccion'),
(3, 'Recursos Humanos'),
(4, 'Administracion'),
(5, 'Comercial'),
(7, 'Produccion'),
(8, 'legal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documento`
--

CREATE TABLE `documento` (
  `ID_documento` int(11) NOT NULL,
  `Nombre` varchar(30) NOT NULL,
  `Directorio` varchar(150) NOT NULL,
  `ID_departamento` int(11) NOT NULL,
  `Estado` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `documento`
--

INSERT INTO `documento` (`ID_documento`, `Nombre`, `Directorio`, `ID_departamento`, `Estado`) VALUES
(33, 'peticion_administracion.pdf', 'archivos/peticion_administracion.pdf', 4, '1'),
(34, 'peticion1.pdf', 'archivos/peticion1.pdf', 4, '2'),
(35, 'peticion_comercial.pdf', 'archivos/peticion_comercial.pdf', 5, '2'),
(36, 'peticion_legal.pdf', 'archivos/peticion_legal.pdf', 8, '1'),
(37, 'peticion2.pdf', 'archivos/peticion2.pdf', 8, '2'),
(38, 'peticion_produccion.pdf', 'archivos/peticion_produccion.pdf', 7, '2'),
(39, 'peticion2.pdf', 'archivos/peticion2.pdf', 7, '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `ID_empleado` int(11) NOT NULL,
  `ID_departamento` int(11) NOT NULL,
  `Nombre_empleado` varchar(30) NOT NULL,
  `Apellido_empleado` varchar(30) NOT NULL,
  `Correo` varchar(40) NOT NULL,
  `Usuario` varchar(30) NOT NULL,
  `pass` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`ID_empleado`, `ID_departamento`, `Nombre_empleado`, `Apellido_empleado`, `Correo`, `Usuario`, `pass`) VALUES
(4, 2, 'Marco Alejandro', 'Hernández Castellanos', 'MAHernandezC@upred.com', 'DMarco', 'd2'),
(6, 2, 'karen', 'cortez', '1930468@upv.edu.mx', 'root', '123'),
(9, 5, 'José Carlos', 'Mar Rangel', 'JCMarR@upred.com', 'CJose', 'c1'),
(10, 5, 'Cristal Elizabeth', 'Toscano Hernández', 'CEToscanoH@upred.com', 'CCristal', 'c2'),
(12, 8, 'laura', 'cortez', '1930468@upv.edu.mx', 'root', '123');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `id_evento` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `fecha` date NOT NULL,
  `Descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`id_evento`, `title`, `fecha`, `Descripcion`) VALUES
(0, 'jesus', '2022-03-28', 'cumple años'),
(0, 'laura', '2022-03-30', 'Evento'),
(0, 'Dario', '2022-04-05', 'evento 2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `ID_inventario` int(11) NOT NULL,
  `Nombre` varchar(30) NOT NULL,
  `Stock` int(11) NOT NULL,
  `Descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `Id` int(11) NOT NULL,
  `Nombre_empresa` varchar(255) NOT NULL,
  `Producto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`Id`, `Nombre_empresa`, `Producto`) VALUES
(1, 'mySQL', ':3c'),
(3, 'mySQL', 'adawd');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`Id_cita`);

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`ID_departamento`);

--
-- Indices de la tabla `documento`
--
ALTER TABLE `documento`
  ADD PRIMARY KEY (`ID_documento`),
  ADD KEY `ID_departamento` (`ID_departamento`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`ID_empleado`),
  ADD KEY `dept` (`ID_departamento`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`ID_inventario`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `Id_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `ID_departamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `documento`
--
ALTER TABLE `documento`
  MODIFY `ID_documento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `ID_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `ID_inventario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `documento`
--
ALTER TABLE `documento`
  ADD CONSTRAINT `documento_ibfk_1` FOREIGN KEY (`ID_departamento`) REFERENCES `departamentos` (`ID_departamento`);

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `dept` FOREIGN KEY (`ID_departamento`) REFERENCES `departamentos` (`ID_departamento`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
