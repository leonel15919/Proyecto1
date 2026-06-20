-- =============================================
-- SEED COMPLETO - Sistema de Laboratorios
-- =============================================
-- Ejecutar en phpMyAdmin (base de datos: laboratoriosdb)
-- Orden de inserción respetando FK constraints
-- =============================================

USE `laboratoriosdb`;

-- 1. PERSONAL DIRECCION (login: cédula + ID)
INSERT INTO `tblpersonaldireccion` (`idPersonalDireccion`, `nomPersonalDireccion`, `cargoPersonalDireccion`, `cedulaPersonalDireccion`, `activo`)
VALUES (10, 'Admin Principal', 'Dirección de Recursos para la Formación', 'V-11223344', 1);

-- 2. ESPECIALIDADES
INSERT INTO `tblespecialidad` (`idEspecialidad`, `nombreEspecialidad`, `descripEspecialidad`, `activo`) VALUES
(1, 'Equipos de Cómputo', 'Mantenimiento de equipos de cómputo', 1),
(2, 'Redes y Conectividad', 'Instalación y mantenimiento de redes', 1),
(3, 'Electricidad', 'Instalaciones y reparaciones eléctricas', 1),
(4, 'Electrónica', 'Reparación de electrónicos e instrumentos', 1),
(5, 'Refrigeración', 'Mantenimiento de refrigeración', 1),
(6, 'Instrumentación de Laboratorio', 'Calibración de instrumentos de laboratorio', 1),
(7, 'General', 'Mantenimiento general', 1);

-- 3. TECNICO
INSERT INTO `tbltecnico` (`idTecnico`, `cedulaTecnico`, `nomTecnico`, `direccionTecnico`, `idEspecialidad`, `activo`)
VALUES (1, 'V-87654321', 'Carlos Mendoza', 'Laboratorio de Informática e Instrumentación', 1, 1);

-- 4. TIPO PRACTICA
INSERT INTO `tbltipopractica` (`idTipoPractica`, `nombreTipoPractica`, `tipoPractica`, `objetivoTipoPractica`, `subcategoriaTipoPractica`, `activo`)
VALUES (1, 'Práctica General', 'Laboratorio', 'Desarrollar habilidades prácticas', 'General', 1);

-- 5. LABORATORIOS
INSERT INTO `tbllaboratorio` (`idLaboratorio`, `tipoLaboratorio`, `capacidadLaboratorio`, `estadoLaboratorio`, `ubicacionLaboratorio`, `nomLaboratorio`, `activo`)
VALUES 
(1, 'Informática', '30', 'Disponible', 'Edificio A - Planta Baja', 'Lab de Informática 1', 1),
(2, 'Química', '20', 'Disponible', 'Edificio B - Piso 1', 'Lab de Química', 1),
(3, 'Física', '25', 'Disponible', 'Edificio A - Piso 2', 'Lab de Física', 1);

-- 6. PNF
INSERT INTO `tblpnf` (`idPNF`, `nombrePNF`, `activo`, `descripPNF`)
VALUES 
(1, 'PNF en Informática', 1, 'Programa Nacional de Formación en Informática'),
(2, 'PNF en Química', 1, 'Programa Nacional de Formación en Química');

-- 7. UNIDADES CURRICULARES
INSERT INTO `tblunidadcurricular` (`idUnidadCurricular`, `nombreUnidadCurricular`, `activo`, `descripUnidadCurricular`)
VALUES 
(1, 'Programación I', 1, 'Fundamentos de programación'),
(2, 'Química General', 1, 'Química básica'),
(3, 'Física I', 1, 'Mecánica clásica');

-- 8. SECCIONES
INSERT INTO `tblseccion` (`idSeccion`, `cantidadSeccion`, `turnoSeccion`, `trayectoSeccion`, `activo`)
VALUES 
(1, '30', 'mañana', 'I', 1),
(2, '25', 'tarde', 'II', 1),
(3, '20', 'noche', 'III', 1);

-- 9. INSUMOS
INSERT INTO `tblinsumos` (`idInsumos`, `cantidadStock`, `nomInsumos`, `descripInsumos`, `categoriaInsumos`, `cantidadDispInsumos`, `cantidadMinInsumos`, `unidadMedidaInsumos`, `activo`)
VALUES 
(1, '50', 'Computadoras', 'Equipos de escritorio', 'Equipos', '45', '5', 'unidad', 1),
(2, '100', 'Tubos de ensayo', 'Vidrio 20ml', 'Material', '90', '10', 'unidad', 1),
(3, '10', 'Multímetros', 'Digital', 'Instrumentos', '1', '2', 'unidad', 1);

-- 10. SOLICITUDES DE PRACTICA
INSERT INTO `tblsolicitudpractica` (`idSolicitudPractica`, `observacionSolicitudPractica`, `fechaInicioSolicitudPractica`, `fechaFinSolicitudPractica`, `horaInicioSolicitudPractica`, `horaFinSolicitudPractica`, `estadoSolicitudPractica`, `idPersonalDireccion`, `activo`)
VALUES 
(1, 'Solicitud por defecto - Sin docente asignado', CURDATE(), CURDATE(), '08:00:00', '10:00:00', 'aprobada', 10, 1),
(2, 'Práctica de programación', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 7 DAY), '08:00:00', '12:00:00', 'aprobada', 10, 1),
(3, 'Práctica de química general', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 7 DAY), '13:00:00', '17:00:00', 'aprobada', 10, 1);

-- 11. DOCENTES
INSERT INTO `tbldocente` (`idDocente`, `cedulaDocente`, `nomDocente`, `apellidoDocente`, `correoInstitucionalDocente`, `idSolicitudPractica`, `activo`)
VALUES 
(1, 'V-12345678', 'Pedro', 'Pérez', 'pperez@uptaeb.edu.ve', 2, 1),
(2, 'V-23456789', 'María', 'González', 'mgonzalez@uptaeb.edu.ve', 3, 1);

-- 12. RESERVAS
INSERT INTO `tblreserva` (`idReserva`, `objetivoReserva`, `horaInicioReserva`, `horaFinReserva`, `nombreReserva`, `fechaReserva`, `descripReserva`, `turnoReserva`, `estadoReserva`, `observacionReserva`, `idLaboratorio`, `idSolicitudPractica`, `idTipoPractica`, `activo`)
VALUES 
(1, 'Realizar práctica de programación', '08:00:00', '10:00:00', 'Práctica de Programación I', CURDATE(), 'Laboratorio de informática', 'mañana', 'aprobada', '', 1, 2, 1, 1),
(2, 'Práctica de química general', '13:00:00', '15:00:00', 'Práctica de Química', DATE_ADD(CURDATE(), INTERVAL 1 DAY), 'Experimentos con ácidos', 'tarde', 'en espera', '', 2, 3, 1, 1);

-- 13. INSUMOS ASIGNADOS A TECNICOS
INSERT INTO `tbltecnicoinsumos` (`idTecnico`, `idInsumos`)
VALUES 
(1, 1),
(1, 2),
(1, 3);

-- 14. ANOMALIAS (mantenimiento)
INSERT INTO `tblanomalia` (`idAnomalia`, `idPractica`, `descripAnomalia`, `fechaDecteAnomalia`, `estadoAnomalia`, `fechaResoAnomalia`, `tipoAnomalia`, `idTecnico`, `idReserva`, `activo`)
VALUES 
(1, 0, 'CPU no enciende en equipo 5', CURDATE(), 'pendiente', CURDATE(), 'equipo', 1, 1, 1);

-- 15. INSUMOS DE RESERVA
INSERT INTO `tblinsumosreserva` (`idReserva`, `idInsumos`, `cantidadRequeridaInsumos`, `estadoInsumos`)
VALUES 
(2, 2, '30', 'disponible');

-- 16. TELEFONOS DOCENTES
INSERT INTO `tbltelfdocente` (`idTelfDocente`, `idDocente`, `telfDocente`)
VALUES 
(1, 1, '0412-1112233'),
(2, 2, '0414-4455667');

-- 17. TELEFONOS TECNICOS
INSERT INTO `tbltelftecnico` (`idTelfTecnico`, `idTecnico`, `telfTecnico`)
VALUES 
(1, 1, '0426-9988776');

-- 18. PNF - UNIDAD CURRICULAR
INSERT INTO `tblunidadcurricularpnf` (`idUnidadCurricular`, `idPNF`)
VALUES 
(1, 1),
(2, 2),
(3, 1);

-- 19. UNIDAD CURRICULAR - SECCION - DOCENTE
INSERT INTO `tblunidadcurricularsecciondocente` (`idUnidadCurricular`, `idDocente`, `idSeccion`)
VALUES 
(1, 1, 1),
(2, 2, 2);
