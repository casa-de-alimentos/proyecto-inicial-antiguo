-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 01-04-2021 a las 02:05:14
-- Versión del servidor: 5.7.33-0ubuntu0.18.04.1
-- Versión de PHP: 7.3.27-1+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `casa_alimentacion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `assistance_ben`
--

CREATE TABLE `assistance_ben` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `peso` float DEFAULT NULL,
  `talla` float DEFAULT NULL,
  `beneficiary_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `assistance_emp`
--

CREATE TABLE `assistance_emp` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `employee_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `beneficiarys`
--

CREATE TABLE `beneficiarys` (
  `id` int(11) NOT NULL,
  `cedula` bigint(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `apellido` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sexo` set('M','F') COLLATE utf8_unicode_ci NOT NULL,
  `nacimiento` date NOT NULL,
  `peso` float NOT NULL,
  `talla` float NOT NULL,
  `nacionalidad` set('V','E') COLLATE utf8_unicode_ci NOT NULL,
  `serial_patria` bigint(20) NOT NULL,
  `codigo_patria` bigint(20) NOT NULL,
  `direccion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `comunidad` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parroquia` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cantidad_de_hijos` tinyint(4) NOT NULL DEFAULT '0',
  `telef_local` bigint(20) DEFAULT NULL,
  `telef_celular` bigint(20) NOT NULL,
  `estudiante` set('Si','No') COLLATE utf8_unicode_ci NOT NULL,
  `grado_instruccion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `desea_estudiar` set('Si','No') COLLATE utf8_unicode_ci NOT NULL,
  `que_desea_estudiar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `habilidad_posee` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `inscrito_CNE` set('Si','No') COLLATE utf8_unicode_ci NOT NULL,
  `ejerce_voto` set('Si','No') COLLATE utf8_unicode_ci NOT NULL,
  `centro_electoral` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `enfermedad` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `discapacidad` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `codigo_carnet_discapacidad` bigint(20) DEFAULT NULL,
  `embarazada` set('Si','No') COLLATE utf8_unicode_ci NOT NULL,
  `fecha_embarazo` date DEFAULT NULL,
  `fecha_parto` date DEFAULT NULL,
  `bono_eventuales` tinyint(1) NOT NULL DEFAULT '0',
  `bono_lactancia` tinyint(1) NOT NULL DEFAULT '0',
  `bono_parto` int(11) NOT NULL DEFAULT '0',
  `bono_jose_gregoreo` tinyint(1) NOT NULL DEFAULT '0',
  `bono_hogares` tinyint(1) NOT NULL DEFAULT '0',
  `pencionado` set('Si','No') COLLATE utf8_unicode_ci NOT NULL,
  `pencionado_por` set('Amor mayor','Iviss') COLLATE utf8_unicode_ci DEFAULT NULL,
  `orga_social_politica` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seguimiento` tinyint(1) DEFAULT '0',
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bienes`
--

CREATE TABLE `bienes` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `cedula` bigint(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `apellido` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sexo` set('M','F') COLLATE utf8_unicode_ci NOT NULL,
  `nacimiento` date NOT NULL,
  `nacionalidad` set('V','E') COLLATE utf8_unicode_ci NOT NULL,
  `serial_patria` bigint(20) NOT NULL,
  `codigo_patria` bigint(20) NOT NULL,
  `direccion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `comunidad` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parroquia` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cantidad_de_hijos` tinyint(4) NOT NULL,
  `telef_local` bigint(20) DEFAULT NULL,
  `telef_celular` bigint(20) NOT NULL,
  `estudiante` set('Si','No') COLLATE utf8_unicode_ci NOT NULL,
  `grado_instruccion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `desea_estudiar` set('Si','No') COLLATE utf8_unicode_ci NOT NULL,
  `que_desea_estudiar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `habilidad_posee` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `inscrito_CNE` set('Si','No') COLLATE utf8_unicode_ci NOT NULL,
  `ejerce_voto` set('Si','No') COLLATE utf8_unicode_ci NOT NULL,
  `centro_electoral` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `enfermedad` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `discapacidad` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `codigo_carnet_discapacidad` bigint(20) DEFAULT NULL,
  `embarazada` set('Si','No') COLLATE utf8_unicode_ci NOT NULL,
  `fecha_embarazo` date DEFAULT NULL,
  `fecha_parto` date DEFAULT NULL,
  `bono_eventuales` tinyint(1) NOT NULL DEFAULT '0',
  `bono_lactancia` tinyint(1) NOT NULL DEFAULT '0',
  `bono_parto` tinyint(1) NOT NULL DEFAULT '0',
  `bono_jose_gregoreo` tinyint(1) NOT NULL DEFAULT '0',
  `bono_hogares` tinyint(1) NOT NULL DEFAULT '0',
  `pencionado` set('Si','No') COLLATE utf8_unicode_ci NOT NULL,
  `pencionado_por` set('Amor mayor','Iviss') COLLATE utf8_unicode_ci DEFAULT NULL,
  `orga_social_politica` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `stock` int(11) NOT NULL,
  `medida` set('Kg','Lts') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `storage`
--

CREATE TABLE `storage` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `action` set('added','removed') COLLATE utf8_unicode_ci NOT NULL,
  `stock` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` longtext COLLATE utf8_unicode_ci NOT NULL,
  `super_user` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `password`, `super_user`) VALUES
(1, 'admin', 'Administrador', '$2y$10$yzDsu7v/DeZqDwaZB8tzeOtMpLUwySrEc5UVc1IHWxfJOPI7kTmFS', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `assistance_ben`
--
ALTER TABLE `assistance_ben`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `assistance_emp`
--
ALTER TABLE `assistance_emp`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `beneficiarys`
--
ALTER TABLE `beneficiarys`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `bienes`
--
ALTER TABLE `bienes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `storage`
--
ALTER TABLE `storage`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `assistance_ben`
--
ALTER TABLE `assistance_ben`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `assistance_emp`
--
ALTER TABLE `assistance_emp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `beneficiarys`
--
ALTER TABLE `beneficiarys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `bienes`
--
ALTER TABLE `bienes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `storage`
--
ALTER TABLE `storage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
