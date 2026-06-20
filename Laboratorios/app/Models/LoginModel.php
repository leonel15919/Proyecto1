<?php

namespace App\Laboratorios\Models;

use App\Laboratorios\Config\Connect\ConnectDB;
use PDO;

class LoginModel extends ConnectDB {
    public function login($cedula, $id) {
        try {
            $conex = $this->getConnection();

            $user = false;

            // Intentar autenticar como Personal de Dirección (Administrador)
            $sql = "SELECT `idPersonalDireccion` AS `id`, `cedulaPersonalDireccion` AS `cedula`,
                           `nomPersonalDireccion` AS `nombre_completo`,
                           'Administrador' AS `rol`
                    FROM `tblpersonaldireccion`
                    WHERE `idPersonalDireccion` = :id AND `cedulaPersonalDireccion` = :cedula AND `activo` = 1";
            $stmt = $conex->prepare($sql);
            $stmt->bindParam(':cedula', $cedula);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user) return $user;

            // Si no es Personal de Dirección, intentar como Docente
            $sql = "SELECT `idDocente` AS `id`, `cedulaDocente` AS `cedula`,
                           CONCAT(`nomDocente`, ' ', `apellidoDocente`) AS `nombre_completo`,
                           'Docente' AS `rol`
                    FROM `tbldocente`
                    WHERE `idDocente` = :id AND `cedulaDocente` = :cedula AND `activo` = 1";
            $stmt = $conex->prepare($sql);
            $stmt->bindParam(':cedula', $cedula);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user) return $user;

            // Si no es Docente, intentar como Técnico
            $sql = "SELECT `idTecnico` AS `id`, `cedulaTecnico` AS `cedula`,
                           `nomTecnico` AS `nombre_completo`,
                           'Tecnico' AS `rol`
                    FROM `tbltecnico`
                    WHERE `idTecnico` = :id AND `cedulaTecnico` = :cedula AND `activo` = 1";
            $stmt = $conex->prepare($sql);
            $stmt->bindParam(':cedula', $cedula);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user) return $user;

            return false;
        } catch (\PDOException $e) {
            die("Error crítico en la autenticación: " . $e->getMessage());
        }
    }
}
