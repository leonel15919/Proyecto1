-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-06-2026 a las 22:26:43
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `laboratoriosdb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `laboratoriosdb`;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `tblanomalia`;
DROP TABLE IF EXISTS `tblunidadcurricularsecciondocente`;
DROP TABLE IF EXISTS `tblunidadcurricularpnf`;
DROP TABLE IF EXISTS `tbltelftecnico`;
DROP TABLE IF EXISTS `tbltelfdocente`;
DROP TABLE IF EXISTS `tbltecnicoinsumos`;
DROP TABLE IF EXISTS `tbltecnico`;
DROP TABLE IF EXISTS `tblsolicitudpractica`;
DROP TABLE IF EXISTS `tblseccion`;
DROP TABLE IF EXISTS `tblreserva`;
DROP TABLE IF EXISTS `tblpnf`;
DROP TABLE IF EXISTS `tblpersonaldireccion`;
DROP TABLE IF EXISTS `tbllaboratorio`;
DROP TABLE IF EXISTS `tblinsumosreserva`;
DROP TABLE IF EXISTS `tblinsumos`;
DROP TABLE IF EXISTS `tblespecialidad`;
DROP TABLE IF EXISTS `tbldocente`;
DROP TABLE IF EXISTS `tbltipopractica`;
DROP TABLE IF EXISTS `tblunidadcurricular`;
SET FOREIGN_KEY_CHECKS = 1;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblanomalia`
--

CREATE TABLE `tblanomalia` (
  `idAnomalia` int(11) NOT NULL,
  `idPractica` int(11) NOT NULL,
  `descripAnomalia` varchar(45) NOT NULL,
  `fechaDecteAnomalia` date NOT NULL,
  `estadoAnomalia` varchar(45) NOT NULL,
  `fechaResoAnomalia` date NOT NULL,
  `tipoAnomalia` varchar(45) NOT NULL,
  `idTecnico` int(11) NOT NULL,
  `idReserva` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbldocente`
--

CREATE TABLE `tbldocente` (
  `idDocente` int(11) NOT NULL,
  `cedulaDocente` varchar(12) NOT NULL,
  `nomDocente` varchar(45) NOT NULL,
  `apellidoDocente` varchar(45) NOT NULL,
  `correoInstitucionalDocente` varchar(45) NOT NULL,
  `idSolicitudPractica` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblinsumos`
--

CREATE TABLE `tblinsumos` (
  `idInsumos` int(11) NOT NULL,
  `cantidadStock` varchar(45) NOT NULL,
  `nomInsumos` varchar(45) NOT NULL,
  `descripInsumos` varchar(45) NOT NULL,
  `categoriaInsumos` varchar(45) NOT NULL,
  `cantidadDispInsumos` varchar(45) NOT NULL,
  `cantidadMinInsumos` varchar(45) NOT NULL,
  `unidadMedidaInsumos` varchar(45) NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblinsumosreserva`
--

CREATE TABLE `tblinsumosreserva` (
  `idReserva` int(11) NOT NULL,
  `idInsumos` int(11) NOT NULL,
  `cantidadRequeridaInsumos` varchar(45) NOT NULL,
  `estadoInsumos` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbllaboratorio`
--

CREATE TABLE `tbllaboratorio` (
  `idLaboratorio` int(11) NOT NULL,
  `tipoLaboratorio` varchar(45) NOT NULL,
  `capacidadLaboratorio` varchar(45) NOT NULL,
  `estadoLaboratorio` varchar(45) NOT NULL,
  `ubicacionLaboratorio` varchar(45) NOT NULL,
  `nomLaboratorio` varchar(45) NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblpersonaldireccion`
--

CREATE TABLE `tblpersonaldireccion` (
  `idPersonalDireccion` int(11) NOT NULL,
  `nomPersonalDireccion` varchar(45) NOT NULL,
  `cargoPersonalDireccion` varchar(45) NOT NULL,
  `cedulaPersonalDireccion` varchar(12) NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblpnf`
--

CREATE TABLE `tblpnf` (
  `idPNF` int(11) NOT NULL,
  `nombrePNF` varchar(45) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `descripPNF` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblreserva`
--

CREATE TABLE `tblreserva` (
  `idReserva` int(11) NOT NULL,
  `objetivoReserva` varchar(45) NOT NULL,
  `horaInicioReserva` time NOT NULL,
  `horaFinReserva` time NOT NULL,
  `nombreReserva` varchar(45) NOT NULL,
  `fechaReserva` date NOT NULL,
  `descripReserva` varchar(45) NOT NULL,
  `turnoReserva` varchar(45) NOT NULL,
  `estadoReserva` varchar(45) NOT NULL,
  `observacionReserva` varchar(45) NOT NULL,
  `idLaboratorio` int(11) NOT NULL,
  `idSolicitudPractica` int(11) NOT NULL,
  `idTipoPractica` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblseccion`
--

CREATE TABLE `tblseccion` (
  `idSeccion` int(11) NOT NULL,
  `cantidadSeccion` varchar(45) NOT NULL,
  `turnoSeccion` varchar(45) NOT NULL,
  `trayectoSeccion` varchar(45) NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblsolicitudpractica`
--

CREATE TABLE `tblsolicitudpractica` (
  `idSolicitudPractica` int(11) NOT NULL,
  `observacionSolicitudPractica` varchar(255) NOT NULL,
  `fechaInicioSolicitudPractica` date NOT NULL,
  `fechaFinSolicitudPractica` date NOT NULL,
  `horaInicioSolicitudPractica` time NOT NULL,
  `horaFinSolicitudPractica` time NOT NULL,
  `estadoSolicitudPractica` varchar(45) NOT NULL,
  `idPersonalDireccion` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblespecialidad`
--

CREATE TABLE `tblespecialidad` (
  `idEspecialidad` int(11) NOT NULL,
  `nombreEspecialidad` varchar(45) NOT NULL,
  `descripEspecialidad` varchar(45) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbltecnico`
--

CREATE TABLE `tbltecnico` (
  `idTecnico` int(11) NOT NULL,
  `cedulaTecnico` varchar(12) NOT NULL,
  `nomTecnico` varchar(45) NOT NULL,
  `direccionTecnico` varchar(45) NOT NULL,
  `idEspecialidad` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbltecnicoinsumos`
--

CREATE TABLE `tbltecnicoinsumos` (
  `idTecnico` int(11) NOT NULL,
  `idInsumos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbltelfdocente`
--

CREATE TABLE `tbltelfdocente` (
  `idTelfDocente` int(11) NOT NULL,
  `idDocente` int(11) NOT NULL,
  `telfDocente` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbltelftecnico`
--

CREATE TABLE `tbltelftecnico` (
  `idTelfTecnico` int(11) NOT NULL,
  `idTecnico` int(11) NOT NULL,
  `telfTecnico` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbltipopractica`
--

CREATE TABLE `tbltipopractica` (
  `idTipoPractica` int(11) NOT NULL,
  `nombreTipoPractica` varchar(45) NOT NULL,
  `tipoPractica` varchar(45) NOT NULL,
  `objetivoTipoPractica` varchar(45) NOT NULL,
  `subcategoriaTipoPractica` varchar(45) NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblunidadcurricular`
--

CREATE TABLE `tblunidadcurricular` (
  `idUnidadCurricular` int(11) NOT NULL,
  `nombreUnidadCurricular` varchar(45) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `descripUnidadCurricular` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblunidadcurricularpnf`
--

CREATE TABLE `tblunidadcurricularpnf` (
  `idUnidadCurricular` int(11) NOT NULL,
  `idPNF` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblunidadcurricularsecciondocente`
--

CREATE TABLE `tblunidadcurricularsecciondocente` (
  `idUnidadCurricular` int(11) NOT NULL,
  `idDocente` int(11) NOT NULL,
  `idSeccion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tblanomalia`
--
ALTER TABLE `tblanomalia`
  ADD PRIMARY KEY (`idAnomalia`),
  ADD KEY `idx_Tecnico_Anomalia` (`idTecnico`),
  ADD KEY `idx_Reserva_Anomalia` (`idReserva`);

--
-- Indices de la tabla `tbldocente`
--
ALTER TABLE `tbldocente`
  ADD PRIMARY KEY (`idDocente`),
  ADD UNIQUE KEY `uq_cedulaDocente` (`cedulaDocente`),
  ADD KEY `idx_SolicitudPractica_Docente` (`idSolicitudPractica`);

--
-- Indices de la tabla `tblinsumos`
--
ALTER TABLE `tblinsumos`
  ADD PRIMARY KEY (`idInsumos`);

--
-- Indices de la tabla `tblinsumosreserva`
--
ALTER TABLE `tblinsumosreserva`
  ADD PRIMARY KEY (`idReserva`,`idInsumos`),
  ADD KEY `idx_Insumos_InsumosReserva` (`idInsumos`);

--
-- Indices de la tabla `tbllaboratorio`
--
ALTER TABLE `tbllaboratorio`
  ADD PRIMARY KEY (`idLaboratorio`);

--
-- Indices de la tabla `tblpersonaldireccion`
--
ALTER TABLE `tblpersonaldireccion`
  ADD PRIMARY KEY (`idPersonalDireccion`),
  ADD UNIQUE KEY `uq_cedulaPersonalDireccion` (`cedulaPersonalDireccion`);

--
-- Indices de la tabla `tblpnf`
--
ALTER TABLE `tblpnf`
  ADD PRIMARY KEY (`idPNF`);

--
-- Indices de la tabla `tblreserva`
--
ALTER TABLE `tblreserva`
  ADD PRIMARY KEY (`idReserva`),
  ADD KEY `idx_Laboratorio_Reserva` (`idLaboratorio`),
  ADD KEY `idx_SolicitudPractica_Reserva` (`idSolicitudPractica`),
  ADD KEY `idx_TipoPractica_Reserva` (`idTipoPractica`);

--
-- Indices de la tabla `tblseccion`
--
ALTER TABLE `tblseccion`
  ADD PRIMARY KEY (`idSeccion`);

--
-- Indices de la tabla `tblsolicitudpractica`
--
ALTER TABLE `tblsolicitudpractica`
  ADD PRIMARY KEY (`idSolicitudPractica`),
  ADD KEY `idx_PersonalDireccion` (`idPersonalDireccion`);

--
-- Indices de la tabla `tbltecnico`
--
ALTER TABLE `tbltecnico`
  ADD PRIMARY KEY (`idTecnico`),
  ADD UNIQUE KEY `uq_cedulaTecnico` (`cedulaTecnico`),
  ADD KEY `idx_Especialidad_Tecnico` (`idEspecialidad`);

--
-- Indices de la tabla `tblespecialidad`
--
ALTER TABLE `tblespecialidad`
  ADD PRIMARY KEY (`idEspecialidad`),
  ADD UNIQUE KEY `uq_nombreEspecialidad` (`nombreEspecialidad`);

--
-- Indices de la tabla `tbltecnicoinsumos`
--
ALTER TABLE `tbltecnicoinsumos`
  ADD PRIMARY KEY (`idTecnico`,`idInsumos`),
  ADD KEY `idx_Insumos_TecnicoInsumos` (`idInsumos`);

--
-- Indices de la tabla `tbltelfdocente`
--
ALTER TABLE `tbltelfdocente`
  ADD PRIMARY KEY (`idTelfDocente`),
  ADD KEY `idx_Docente_TelfDocente` (`idDocente`);

--
-- Indices de la tabla `tbltelftecnico`
--
ALTER TABLE `tbltelftecnico`
  ADD PRIMARY KEY (`idTelfTecnico`),
  ADD KEY `idx_Tecnico_TelfTecnico` (`idTecnico`);

--
-- Indices de la tabla `tbltipopractica`
--
ALTER TABLE `tbltipopractica`
  ADD PRIMARY KEY (`idTipoPractica`);

--
-- Indices de la tabla `tblunidadcurricular`
--
ALTER TABLE `tblunidadcurricular`
  ADD PRIMARY KEY (`idUnidadCurricular`);

--
-- Indices de la tabla `tblunidadcurricularpnf`
--
ALTER TABLE `tblunidadcurricularpnf`
  ADD PRIMARY KEY (`idUnidadCurricular`,`idPNF`),
  ADD KEY `idx_PNF` (`idPNF`);

--
-- Indices de la tabla `tblunidadcurricularsecciondocente`
--
ALTER TABLE `tblunidadcurricularsecciondocente`
  ADD PRIMARY KEY (`idUnidadCurricular`,`idDocente`,`idSeccion`),
  ADD KEY `idx_Docente_UCurrSD` (`idDocente`),
  ADD KEY `idx_Seccion_UCurrSD` (`idSeccion`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tblanomalia`
--
ALTER TABLE `tblanomalia`
  MODIFY `idAnomalia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbldocente`
--
ALTER TABLE `tbldocente`
  MODIFY `idDocente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tblinsumos`
--
ALTER TABLE `tblinsumos`
  MODIFY `idInsumos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbllaboratorio`
--
ALTER TABLE `tbllaboratorio`
  MODIFY `idLaboratorio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tblpersonaldireccion`
--
ALTER TABLE `tblpersonaldireccion`
  MODIFY `idPersonalDireccion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tblpnf`
--
ALTER TABLE `tblpnf`
  MODIFY `idPNF` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tblreserva`
--
ALTER TABLE `tblreserva`
  MODIFY `idReserva` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tblseccion`
--
ALTER TABLE `tblseccion`
  MODIFY `idSeccion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tblsolicitudpractica`
--
ALTER TABLE `tblsolicitudpractica`
  MODIFY `idSolicitudPractica` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbltecnico`
--
ALTER TABLE `tbltecnico`
  MODIFY `idTecnico` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tblespecialidad`
--
ALTER TABLE `tblespecialidad`
  MODIFY `idEspecialidad` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbltelfdocente`
--
ALTER TABLE `tbltelfdocente`
  MODIFY `idTelfDocente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbltelftecnico`
--
ALTER TABLE `tbltelftecnico`
  MODIFY `idTelfTecnico` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbltipopractica`
--
ALTER TABLE `tbltipopractica`
  MODIFY `idTipoPractica` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tblunidadcurricular`
--
ALTER TABLE `tblunidadcurricular`
  MODIFY `idUnidadCurricular` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tblanomalia`
--
ALTER TABLE `tblanomalia`
  ADD CONSTRAINT `fk_Anomalia_Reserva` FOREIGN KEY (`idReserva`) REFERENCES `tblreserva` (`idReserva`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Anomalia_Tecnico` FOREIGN KEY (`idTecnico`) REFERENCES `tbltecnico` (`idTecnico`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbldocente`
--
ALTER TABLE `tbldocente`
  ADD CONSTRAINT `fk_Docente_SolicitudPractica` FOREIGN KEY (`idSolicitudPractica`) REFERENCES `tblsolicitudpractica` (`idSolicitudPractica`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tblinsumosreserva`
--
ALTER TABLE `tblinsumosreserva`
  ADD CONSTRAINT `fk_InsumosReserva_Insumos` FOREIGN KEY (`idInsumos`) REFERENCES `tblinsumos` (`idInsumos`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_InsumosReserva_Reserva` FOREIGN KEY (`idReserva`) REFERENCES `tblreserva` (`idReserva`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tblreserva`
--
ALTER TABLE `tblreserva`
  ADD CONSTRAINT `fk_Reserva_Laboratorio` FOREIGN KEY (`idLaboratorio`) REFERENCES `tbllaboratorio` (`idLaboratorio`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Reserva_SolicitudPractica` FOREIGN KEY (`idSolicitudPractica`) REFERENCES `tblsolicitudpractica` (`idSolicitudPractica`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Reserva_TipoPractica` FOREIGN KEY (`idTipoPractica`) REFERENCES `tbltipopractica` (`idTipoPractica`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tblsolicitudpractica`
--
ALTER TABLE `tblsolicitudpractica`
  ADD CONSTRAINT `fk_SolicitudPractica_PersonalDireccion` FOREIGN KEY (`idPersonalDireccion`) REFERENCES `tblpersonaldireccion` (`idPersonalDireccion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbltecnico`
--
ALTER TABLE `tbltecnico`
  ADD CONSTRAINT `fk_Tecnico_Especialidad` FOREIGN KEY (`idEspecialidad`) REFERENCES `tblespecialidad` (`idEspecialidad`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbltecnicoinsumos`
--
ALTER TABLE `tbltecnicoinsumos`
  ADD CONSTRAINT `fk_TecnicoInsumos_Insumos` FOREIGN KEY (`idInsumos`) REFERENCES `tblinsumos` (`idInsumos`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_TecnicoInsumos_Tecnico` FOREIGN KEY (`idTecnico`) REFERENCES `tbltecnico` (`idTecnico`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbltelfdocente`
--
ALTER TABLE `tbltelfdocente`
  ADD CONSTRAINT `fk_TelfDocente_Docente` FOREIGN KEY (`idDocente`) REFERENCES `tbldocente` (`idDocente`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbltelftecnico`
--
ALTER TABLE `tbltelftecnico`
  ADD CONSTRAINT `fk_TelfTecnico_Tecnico` FOREIGN KEY (`idTecnico`) REFERENCES `tbltecnico` (`idTecnico`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tblunidadcurricularpnf`
--
ALTER TABLE `tblunidadcurricularpnf`
  ADD CONSTRAINT `fk_UCurrPNF_PNF` FOREIGN KEY (`idPNF`) REFERENCES `tblpnf` (`idPNF`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_UCurrPNF_UCurricular` FOREIGN KEY (`idUnidadCurricular`) REFERENCES `tblunidadcurricular` (`idUnidadCurricular`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tblunidadcurricularsecciondocente`
--
ALTER TABLE `tblunidadcurricularsecciondocente`
  ADD CONSTRAINT `fk_UCurrSD_Docente` FOREIGN KEY (`idDocente`) REFERENCES `tbldocente` (`idDocente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_UCurrSD_Seccion` FOREIGN KEY (`idSeccion`) REFERENCES `tblseccion` (`idSeccion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_UCurrSD_UCurricular` FOREIGN KEY (`idUnidadCurricular`) REFERENCES `tblunidadcurricular` (`idUnidadCurricular`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
