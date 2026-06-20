<?php

namespace App\Laboratorios\Models;

use App\Laboratorios\Config\Connect\ConnectDB;
use PDO;

class GestionUsuariosModel extends ConnectDB {
    public function getAll($soloActivos = true) {
        try {
            $conex = $this->getConnection();
            $cond = $soloActivos ? '1' : '0';

            $sql = "
                SELECT 
                    `idTecnico` AS `id`,
                    `cedulaTecnico` AS `cedula`,
                    `nomTecnico` AS `nombre_completo`,
                    LOWER(REPLACE(`nomTecnico`, ' ', '')) AS `usuario`,
                    CONCAT(LOWER(REPLACE(`nomTecnico`, ' ', '')), '@uptaeb.edu.ve') AS `correo`,
                    'Tecnico' AS `rol`,
                    `direccionTecnico` AS `departamento`
                FROM `tbltecnico`
                WHERE `activo` = $cond
                
                UNION ALL
                
                SELECT 
                    `idPersonalDireccion` AS `id`,
                    `cedulaPersonalDireccion` AS `cedula`,
                    `nomPersonalDireccion` AS `nombre_completo`,
                    LOWER(REPLACE(`nomPersonalDireccion`, ' ', '')) AS `usuario`,
                    CONCAT(LOWER(REPLACE(`nomPersonalDireccion`, ' ', '')), '@uptaeb.edu.ve') AS `correo`,
                    'Administrador' AS `rol`,
                    `cargoPersonalDireccion` AS `departamento`
                FROM `tblpersonaldireccion`
                WHERE `activo` = $cond
                
                UNION ALL
                
                SELECT 
                    `idDocente` AS `id`,
                    `cedulaDocente` AS `cedula`,
                    CONCAT(`nomDocente`, ' ', `apellidoDocente`) AS `nombre_completo`,
                    LOWER(REPLACE(`nomDocente`, ' ', '')) AS `usuario`,
                    `correoInstitucionalDocente` AS `correo`,
                    'Docente' AS `rol`,
                    '' AS `departamento`
                FROM `tbldocente`
                WHERE `activo` = $cond
                
                ORDER BY `nombre_completo` ASC
            ";

            $response = $conex->prepare($sql);
            $response->execute();

            return $response->fetchAll(PDO::FETCH_ASSOC);
        } catch(\PDOException $e) {
            die("Error crítico en GestionUsuariosModel::getAll: " . $e->getMessage());
        }
    }

    public function create($data) {
        try {
            $conex = $this->getConnection();
            $rol = $data['rol'];

            if ($rol === 'Docente') {
                $sqlSolicitud = "INSERT INTO `tblsolicitudpractica`
                                    (`observacionSolicitudPractica`, `fechaInicioSolicitudPractica`, `fechaFinSolicitudPractica`,
                                     `horaInicioSolicitudPractica`, `horaFinSolicitudPractica`, `estadoSolicitudPractica`,
                                     `idPersonalDireccion`, `activo`)
                                VALUES
                                    ('Generada automáticamente para docente', CURDATE(), CURDATE(),
                                     '08:00:00', '10:00:00', 'generada',
                                     :idPersonal, 1)";
                $stmtS = $conex->prepare($sqlSolicitud);
                $stmtS->bindValue(':idPersonal', $data['idPersonalDireccion'] ?? 10, PDO::PARAM_INT);
                $stmtS->execute();
                $nuevoIdSolicitud = $conex->lastInsertId();

                $sql = "INSERT INTO `tbldocente` (`cedulaDocente`, `nomDocente`, `apellidoDocente`, `correoInstitucionalDocente`, `idSolicitudPractica`, `activo`) 
                        VALUES (:cedula, :nombre, :apellido, :correo, :idSolicitud, 1)";
                $stmt = $conex->prepare($sql);
                $stmt->bindValue(':cedula', $data['cedula']);
                $stmt->bindValue(':nombre', $data['nombre']);
                $stmt->bindValue(':apellido', $data['apellido']);
                $stmt->bindValue(':correo', $data['correo']);
                $stmt->bindValue(':idSolicitud', $nuevoIdSolicitud, PDO::PARAM_INT);
            } elseif ($rol === 'Tecnico') {
                $sql = "INSERT INTO `tbltecnico` (`cedulaTecnico`, `nomTecnico`, `direccionTecnico`, `idEspecialidad`, `activo`) 
                        VALUES (:cedula, :nombre, :direccion, 7, 1)";
                $stmt = $conex->prepare($sql);
                $stmt->bindValue(':cedula', $data['cedula']);
                $stmt->bindValue(':nombre', $data['nombre']);
                $stmt->bindValue(':direccion', $data['direccion'] ?? '');
            } else {
                $sql = "INSERT INTO `tblpersonaldireccion` (`cedulaPersonalDireccion`, `nomPersonalDireccion`, `cargoPersonalDireccion`, `activo`) 
                        VALUES (:cedula, :nombre, :cargo, 1)";
                $stmt = $conex->prepare($sql);
                $stmt->bindValue(':cedula', $data['cedula']);
                $stmt->bindValue(':nombre', $data['nombre']);
                $stmt->bindValue(':cargo', $data['cargo'] ?? '');
            }

            return $stmt->execute();
        } catch(\PDOException $e) {
            error_log("Error en GestionUsuariosModel::create: " . $e->getMessage());
            return false;
        }
    }

    public function getByCedula($cedula, $rol) {
        try {
            $conex = $this->getConnection();
            if ($rol === 'Docente') {
                $sql = "SELECT `idDocente` FROM `tbldocente` WHERE `cedulaDocente` = :cedula";
            } elseif ($rol === 'Tecnico') {
                $sql = "SELECT `idTecnico` FROM `tbltecnico` WHERE `cedulaTecnico` = :cedula";
            } else {
                $sql = "SELECT `idPersonalDireccion` FROM `tblpersonaldireccion` WHERE `cedulaPersonalDireccion` = :cedula";
            }
            $stmt = $conex->prepare($sql);
            $stmt->execute([':cedula' => $cedula]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(\PDOException $e) {
            return false;
        }
    }

    public function update($id, $rol, $data) {
        try {
            $conex = $this->getConnection();

            if ($rol === 'Docente') {
                $sql = "UPDATE `tbldocente` SET 
                            `cedulaDocente` = :cedula,
                            `nomDocente` = :nombre,
                            `apellidoDocente` = :apellido,
                            `correoInstitucionalDocente` = :correo
                        WHERE `idDocente` = :id";
                $stmt = $conex->prepare($sql);
                $stmt->bindValue(':cedula', $data['cedula']);
                $stmt->bindValue(':nombre', $data['nombre']);
                $stmt->bindValue(':apellido', $data['apellido']);
                $stmt->bindValue(':correo', $data['correo']);
                $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            } elseif ($rol === 'Tecnico') {
                $sql = "UPDATE `tbltecnico` SET 
                            `cedulaTecnico` = :cedula,
                            `nomTecnico` = :nombre,
                            `direccionTecnico` = :direccion,
                            `idEspecialidad` = 7
                        WHERE `idTecnico` = :id";
                $stmt = $conex->prepare($sql);
                $stmt->bindValue(':cedula', $data['cedula']);
                $stmt->bindValue(':nombre', $data['nombre']);
                $stmt->bindValue(':direccion', $data['direccion'] ?? '');
                $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            } else {
                $sql = "UPDATE `tblpersonaldireccion` SET 
                            `cedulaPersonalDireccion` = :cedula,
                            `nomPersonalDireccion` = :nombre,
                            `cargoPersonalDireccion` = :cargo
                        WHERE `idPersonalDireccion` = :id";
                $stmt = $conex->prepare($sql);
                $stmt->bindValue(':cedula', $data['cedula']);
                $stmt->bindValue(':nombre', $data['nombre']);
                $stmt->bindValue(':cargo', $data['cargo'] ?? '');
                $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            }

            return $stmt->execute();
        } catch(\PDOException $e) {
            die("Error al actualizar usuario: " . $e->getMessage());
        }
    }

    public function softDelete($id, $rol) {
        try {
            $conex = $this->getConnection();

            if ($rol === 'Docente') {
                $sql = "UPDATE `tbldocente` SET `activo` = 0 WHERE `idDocente` = :id";
            } elseif ($rol === 'Tecnico') {
                $sql = "UPDATE `tbltecnico` SET `activo` = 0 WHERE `idTecnico` = :id";
            } else {
                $sql = "UPDATE `tblpersonaldireccion` SET `activo` = 0 WHERE `idPersonalDireccion` = :id";
            }

            $stmt = $conex->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch(\PDOException $e) {
            die("Error al desactivar usuario: " . $e->getMessage());
        }
    }

    public function getById($id, $rol) {
        try {
            $conex = $this->getConnection();

            if ($rol === 'Docente') {
                $sql = "SELECT `idDocente` AS `id`, `cedulaDocente` AS `cedula`, `nomDocente` AS `nombre`, `apellidoDocente` AS `apellido`, `correoInstitucionalDocente` AS `correo`, 'Docente' AS `rol`
                        FROM `tbldocente` WHERE `idDocente` = :id";
            } elseif ($rol === 'Tecnico') {
                $sql = "SELECT `idTecnico` AS `id`, `cedulaTecnico` AS `cedula`, `nomTecnico` AS `nombre`, '' AS `apellido`, '' AS `correo`, 'Tecnico' AS `rol`, `direccionTecnico` AS `direccion`
                        FROM `tbltecnico` WHERE `idTecnico` = :id";
            } else {
                $sql = "SELECT `idPersonalDireccion` AS `id`, `cedulaPersonalDireccion` AS `cedula`, `nomPersonalDireccion` AS `nombre`, '' AS `apellido`, '' AS `correo`, 'Administrador' AS `rol`, `cargoPersonalDireccion` AS `cargo`
                        FROM `tblpersonaldireccion` WHERE `idPersonalDireccion` = :id";
            }

            $stmt = $conex->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(\PDOException $e) {
            die("Error al obtener usuario: " . $e->getMessage());
        }
    }

    public function getDocentes() {
        try {
            $conex = $this->getConnection();
            $sql = "SELECT idDocente, CONCAT(nomDocente, ' ', apellidoDocente) as nombre, idSolicitudPractica FROM tbldocente WHERE activo = 1 ORDER BY nomDocente ASC";
            $stmt = $conex->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(\PDOException $e) {
            return [];
        }
    }

    public function getDocenteCount() {
        try {
            $conex = $this->getConnection();
            $sql = "SELECT COUNT(*) as total FROM tbldocente WHERE activo = 1";
            $stmt = $conex->prepare($sql);
            $stmt->execute();
            return (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
        } catch(\PDOException $e) {
            return 0;
        }
    }
}
