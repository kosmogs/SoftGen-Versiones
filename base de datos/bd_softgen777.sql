-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 13-08-2025 a las 01:30:30
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_softgen777`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL,
  `razon_social` varchar(100) DEFAULT NULL,
  `cli_nit` varchar(20) DEFAULT NULL,
  `id_ubicacion` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `cli_contacto_nombre` varchar(50) DEFAULT NULL,
  `cli_contacto_correo` varchar(50) DEFAULT NULL,
  `cli_contacto_telefono` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `razon_social`, `cli_nit`, `id_ubicacion`, `id_usuario`, `cli_contacto_nombre`, `cli_contacto_correo`, `cli_contacto_telefono`) VALUES
(1, 'Exitos s.a.s', '12344658A', 1, NULL, 'exito', 'exito@gmail.com', '3210584'),
(2, 'Servicio nacional de aprendizaje', '09364839B', 2, NULL, 'sena', 'sena@edu.com', '3298503981'),
(3, 'Innovar aire y energia', '98042662428', 3, NULL, 'innovar', 'ino@gmail.com', '3100800283');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `id_empresa` int(11) NOT NULL,
  `emp_razon_social` varchar(100) DEFAULT NULL,
  `emp_nit` varchar(20) DEFAULT NULL,
  `emp_correo` varchar(50) DEFAULT NULL,
  `emp_telefono` varchar(20) DEFAULT NULL,
  `emp_logo` varchar(255) DEFAULT NULL,
  `id_ubicacion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`id_empresa`, `emp_razon_social`, `emp_nit`, `emp_correo`, `emp_telefono`, `emp_logo`, `id_ubicacion`) VALUES
(1, 'Almacenes exito', '1294759202', 'exito@gmail.com', '312859604', 'loguito', NULL),
(2, 'Servicio nacional de aprendizaje', '1223009684', '30004860292', 'sena@soy.sena.edu.co', 'loguito', NULL),
(3, 'Goyurt', '00034578', 'yurtgo@gmail.com', '3121230494', 'loguito', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo`
--

CREATE TABLE `equipo` (
  `id_equipo` int(11) NOT NULL,
  `equi_tipo_equipo` varchar(50) NOT NULL,
  `equi_marca` varchar(50) NOT NULL,
  `equi_modelo` varchar(50) NOT NULL,
  `equi_cantidad` int(11) NOT NULL COMMENT 'Cambiado a INT',
  `equi_ubicacion` varchar(100) NOT NULL,
  `equi_serie` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `foto_servicio`
--

CREATE TABLE `foto_servicio` (
  `id_foto` int(11) NOT NULL,
  `id_servicio` int(11) NOT NULL,
  `ruta_foto` varchar(255) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inspeccion_general`
--

CREATE TABLE `inspeccion_general` (
  `id_inspeccion_general` int(11) NOT NULL,
  `ig_goteos` tinyint(1) NOT NULL DEFAULT 0,
  `ig_gabinete` tinyint(1) NOT NULL DEFAULT 0,
  `ig_filtro` tinyint(1) NOT NULL DEFAULT 0,
  `ig_drenaje` tinyint(1) NOT NULL DEFAULT 0,
  `ig_serpentin` tinyint(1) NOT NULL DEFAULT 0,
  `ig_refigerante` tinyint(1) NOT NULL DEFAULT 0,
  `ig_vibracion` tinyint(1) NOT NULL DEFAULT 0,
  `ig_amperios` decimal(6,2) DEFAULT NULL,
  `ig_voltaje` decimal(6,2) DEFAULT NULL,
  `ig_tablero_electrico` tinyint(1) NOT NULL DEFAULT 0,
  `ig_aislamiento_gabinete` tinyint(1) NOT NULL DEFAULT 0,
  `ig_flujo_aire` tinyint(1) NOT NULL DEFAULT 0,
  `ig_temp_suministro` decimal(5,2) DEFAULT NULL,
  `ig_temp_retorno` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `id_password_resets` int(11) NOT NULL,
  `usu_correo` varchar(50) NOT NULL,
  `token` char(64) NOT NULL,
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `revision_mecanica`
--

CREATE TABLE `revision_mecanica` (
  `id_revision_mecanica` int(11) NOT NULL,
  `rm_ejes` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=N/A, 1=OK, 2=Regular, 3=Malo',
  `rm_rodamientos` tinyint(4) NOT NULL DEFAULT 0,
  `rm_chumaceras` tinyint(4) NOT NULL DEFAULT 0,
  `rm_poleas` tinyint(4) NOT NULL DEFAULT 0,
  `rm_correas` tinyint(4) NOT NULL DEFAULT 0,
  `rm_ductos` tinyint(4) NOT NULL DEFAULT 0,
  `rm_rejillas` tinyint(4) NOT NULL DEFAULT 0,
  `rm_pintura` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL,
  `rol_nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `rol_nombre`) VALUES
(1, 'Administrador'),
(2, 'Tecnico');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `id_servicio` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_tecnico` int(11) DEFAULT NULL,
  `id_ubicacion` int(11) DEFAULT NULL,
  `id_inspeccion_general` int(11) DEFAULT NULL,
  `id_revision_mecanica` int(11) DEFAULT NULL,
  `ser_tipo_informe` enum('Refrigerante Variable','Expansión Directa','Condensando por Agua','Ventilación Mecánica','Otro') DEFAULT NULL,
  `ser_tipo_servicio` enum('Mantenimiento Preventivo','Mantenimiento Correctivo','Instalación','Revision','Visita','Otro') DEFAULT NULL,
  `ser_observaciones` text DEFAULT NULL,
  `ser_estado` enum('Pendiente','Firmado','Rechazado') NOT NULL DEFAULT 'Pendiente',
  `ser_firma_cliente` varchar(255) DEFAULT NULL,
  `ser_firma_tecnico` varchar(255) DEFAULT NULL,
  `ser_fecha` date NOT NULL,
  `ser_hora_entrada` datetime DEFAULT NULL,
  `ser_hora_salida` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tecnico`
--

CREATE TABLE `tecnico` (
  `id_tecnico` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_empresa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicacion`
--

CREATE TABLE `ubicacion` (
  `id_ubicacion` int(11) NOT NULL,
  `ubi_sitio` varchar(100) NOT NULL,
  `ubi_ciudad` varchar(50) NOT NULL,
  `ubi_departamento` enum('Amazonas','Antioquia','Arauca','Atlántico','Bolívar','Boyacá','Caldas','Caquetá','Casanare','Cauca','Cesar','Chocó','Córdoba','Cundinamarca','Guainía','Guaviare','Huila','La guajira','Magdalena','Meta','Nariño','Norte de Santander','Putumayo','Quindío','Risaralda','San Andrés y Providencia','Santander','Sucre','Tolima','Valle del Cauca','Vaupés','Vichada') NOT NULL,
  `ubi_localidad` varchar(50) DEFAULT NULL,
  `ubi_barrio` varchar(50) DEFAULT NULL,
  `ubi_calle` varchar(100) DEFAULT NULL,
  `ubi_numero` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ubicacion`
--

INSERT INTO `ubicacion` (`id_ubicacion`, `ubi_sitio`, `ubi_ciudad`, `ubi_departamento`, `ubi_localidad`, `ubi_barrio`, `ubi_calle`, `ubi_numero`) VALUES
(1, 'Oficina', 'Bucaramanga', 'Santander', 'pie de cuesta', 'Mira flor', 'cr22 #48', '14'),
(2, 'edificio central', 'Bogota', 'Cundinamarca', 'Bosa', 'San bernardino', 'cr 33', '8'),
(3, 'segundo pieso', 'Cartagena', 'Bolívar', 'playa', 'barrio nuevo', 'cr21 #5', '#68');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `id_rol` int(11) DEFAULT NULL,
  `usu_nombre` varchar(30) NOT NULL,
  `usu_apellido` varchar(30) NOT NULL,
  `usu_doc_identidad` varchar(50) NOT NULL,
  `usu_telefono` varchar(30) NOT NULL,
  `usu_correo` varchar(50) NOT NULL,
  `usu_contrasena` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`),
  ADD KEY `id_ubicacion` (`id_ubicacion`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id_empresa`),
  ADD KEY `id_ubicacion` (`id_ubicacion`);

--
-- Indices de la tabla `equipo`
--
ALTER TABLE `equipo`
  ADD PRIMARY KEY (`id_equipo`);

--
-- Indices de la tabla `foto_servicio`
--
ALTER TABLE `foto_servicio`
  ADD PRIMARY KEY (`id_foto`),
  ADD KEY `id_servicio` (`id_servicio`);

--
-- Indices de la tabla `inspeccion_general`
--
ALTER TABLE `inspeccion_general`
  ADD PRIMARY KEY (`id_inspeccion_general`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id_password_resets`),
  ADD KEY `usu_correo` (`usu_correo`);

--
-- Indices de la tabla `revision_mecanica`
--
ALTER TABLE `revision_mecanica`
  ADD PRIMARY KEY (`id_revision_mecanica`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`id_servicio`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_tecnico` (`id_tecnico`),
  ADD KEY `id_ubicacion` (`id_ubicacion`),
  ADD KEY `id_inspeccion_general` (`id_inspeccion_general`),
  ADD KEY `id_revision_mecanica` (`id_revision_mecanica`);

--
-- Indices de la tabla `tecnico`
--
ALTER TABLE `tecnico`
  ADD PRIMARY KEY (`id_tecnico`),
  ADD KEY `id_empresa` (`id_empresa`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  ADD PRIMARY KEY (`id_ubicacion`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `usu_correo` (`usu_correo`),
  ADD KEY `id_rol` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id_empresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `equipo`
--
ALTER TABLE `equipo`
  MODIFY `id_equipo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `foto_servicio`
--
ALTER TABLE `foto_servicio`
  MODIFY `id_foto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inspeccion_general`
--
ALTER TABLE `inspeccion_general`
  MODIFY `id_inspeccion_general` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id_password_resets` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `revision_mecanica`
--
ALTER TABLE `revision_mecanica`
  MODIFY `id_revision_mecanica` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tecnico`
--
ALTER TABLE `tecnico`
  MODIFY `id_tecnico` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  MODIFY `id_ubicacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `cliente_ibfk_1` FOREIGN KEY (`id_ubicacion`) REFERENCES `ubicacion` (`id_ubicacion`),
  ADD CONSTRAINT `cliente_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD CONSTRAINT `empresa_ibfk_1` FOREIGN KEY (`id_ubicacion`) REFERENCES `ubicacion` (`id_ubicacion`);

--
-- Filtros para la tabla `foto_servicio`
--
ALTER TABLE `foto_servicio`
  ADD CONSTRAINT `foto_servicio_ibfk_1` FOREIGN KEY (`id_servicio`) REFERENCES `servicio` (`id_servicio`);

--
-- Filtros para la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `password_resets_ibfk_1` FOREIGN KEY (`usu_correo`) REFERENCES `usuario` (`usu_correo`);

--
-- Filtros para la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD CONSTRAINT `servicio_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  ADD CONSTRAINT `servicio_ibfk_2` FOREIGN KEY (`id_tecnico`) REFERENCES `tecnico` (`id_tecnico`),
  ADD CONSTRAINT `servicio_ibfk_3` FOREIGN KEY (`id_ubicacion`) REFERENCES `ubicacion` (`id_ubicacion`),
  ADD CONSTRAINT `servicio_ibfk_4` FOREIGN KEY (`id_inspeccion_general`) REFERENCES `inspeccion_general` (`id_inspeccion_general`),
  ADD CONSTRAINT `servicio_ibfk_5` FOREIGN KEY (`id_revision_mecanica`) REFERENCES `revision_mecanica` (`id_revision_mecanica`);

--
-- Filtros para la tabla `tecnico`
--
ALTER TABLE `tecnico`
  ADD CONSTRAINT `tecnico_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`),
  ADD CONSTRAINT `tecnico_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
