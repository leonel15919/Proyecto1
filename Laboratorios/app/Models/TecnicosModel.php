<?php
namespace App\Laboratorios\Models;

use App\Laboratorios\Config\Connect\ConnectDB;
use PDO;

class TecnicosModel extends ConnectDB
{
    public function getAll()
    {
        try {
            $conex = $this->getConnection();
            $sql = "SELECT t.*, e.nombreEspecialidad
                    FROM tbltecnico t
                    LEFT JOIN tblespecialidad e ON t.idEspecialidad = e.idEspecialidad
                    WHERE t.activo = 1
                    ORDER BY t.nomTecnico ASC";
            $stmt = $conex->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            die("Error en TecnicosModel::getAll: " . $e->getMessage());
        }
    }

    public function getById($id)
    {
        try {
            $conex = $this->getConnection();
            $sql = "SELECT t.*, e.nombreEspecialidad
                    FROM tbltecnico t
                    LEFT JOIN tblespecialidad e ON t.idEspecialidad = e.idEspecialidad
                    WHERE t.idTecnico = :id";
            $stmt = $conex->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            die("Error en TecnicosModel::getById: " . $e->getMessage());
        }
    }

    public function create($data)
    {
        try {
            $conex = $this->getConnection();
            $sql = "INSERT INTO tbltecnico (cedulaTecnico, nomTecnico, direccionTecnico, idEspecialidad, activo)
                    VALUES (:cedula, :nombre, :direccion, :idEspecialidad, 1)";
            $stmt = $conex->prepare($sql);
            $stmt->bindValue(':cedula', $data['cedulaTecnico']);
            $stmt->bindValue(':nombre', $data['nomTecnico']);
            $stmt->bindValue(':direccion', $data['direccionTecnico'] ?? '');
            $stmt->bindValue(':idEspecialidad', $data['idEspecialidad'], PDO::PARAM_INT);
            $stmt->execute();
            return $conex->lastInsertId();
        } catch (\PDOException $e) {
            die("Error en TecnicosModel::create: " . $e->getMessage());
        }
    }

    public function update($id, $data)
    {
        try {
            $conex = $this->getConnection();
            $sql = "UPDATE tbltecnico
                    SET cedulaTecnico = :cedula,
                        nomTecnico = :nombre,
                        direccionTecnico = :direccion,
                        idEspecialidad = :idEspecialidad
                    WHERE idTecnico = :id";
            $stmt = $conex->prepare($sql);
            $stmt->bindValue(':cedula', $data['cedulaTecnico']);
            $stmt->bindValue(':nombre', $data['nomTecnico']);
            $stmt->bindValue(':direccion', $data['direccionTecnico'] ?? '');
            $stmt->bindValue(':idEspecialidad', $data['idEspecialidad'], PDO::PARAM_INT);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            die("Error en TecnicosModel::update: " . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $conex = $this->getConnection();
            $sql = "UPDATE tbltecnico SET activo = 0 WHERE idTecnico = :id";
            $stmt = $conex->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            die("Error en TecnicosModel::delete: " . $e->getMessage());
        }
    }

    public function getTelefonos($idTecnico)
    {
        try {
            $conex = $this->getConnection();
            $sql = "SELECT * FROM tbltelftecnico WHERE idTecnico = :idTecnico ORDER BY idTelfTecnico";
            $stmt = $conex->prepare($sql);
            $stmt->bindParam(':idTecnico', $idTecnico, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            die("Error en TecnicosModel::getTelefonos: " . $e->getMessage());
        }
    }

    public function addTelefono($idTecnico, $telefono)
    {
        try {
            $conex = $this->getConnection();
            $sql = "INSERT INTO tbltelftecnico (idTecnico, telfTecnico) VALUES (:idTecnico, :telefono)";
            $stmt = $conex->prepare($sql);
            $stmt->bindValue(':idTecnico', $idTecnico, PDO::PARAM_INT);
            $stmt->bindValue(':telefono', $telefono);
            return $stmt->execute();
        } catch (\PDOException $e) {
            die("Error en TecnicosModel::addTelefono: " . $e->getMessage());
        }
    }

    public function deleteTelefono($idTelf)
    {
        try {
            $conex = $this->getConnection();
            $sql = "DELETE FROM tbltelftecnico WHERE idTelfTecnico = :id";
            $stmt = $conex->prepare($sql);
            $stmt->bindParam(':id', $idTelf, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            die("Error en TecnicosModel::deleteTelefono: " . $e->getMessage());
        }
    }

    public function getEspecialidades()
    {
        try {
            $conex = $this->getConnection();
            $sql = "SELECT * FROM tblespecialidad WHERE activo = 1 ORDER BY nombreEspecialidad";
            $stmt = $conex->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            die("Error en TecnicosModel::getEspecialidades: " . $e->getMessage());
        }
    }

    public function getInsumosAReponer($idTecnico)
    {
        try {
            $conex = $this->getConnection();
            $sql = "SELECT i.*, ti.idTecnico
                    FROM tbltecnicoinsumos ti
                    INNER JOIN tblinsumos i ON ti.idInsumos = i.idInsumos
                    WHERE ti.idTecnico = :idTecnico
                      AND i.activo = 1
                      AND CAST(i.cantidadDispInsumos AS DECIMAL) <= CAST(i.cantidadMinInsumos AS DECIMAL)
                    ORDER BY i.nomInsumos ASC";
            $stmt = $conex->prepare($sql);
            $stmt->bindParam(':idTecnico', $idTecnico, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            die("Error en TecnicosModel::getInsumosAReponer: " . $e->getMessage());
        }
    }

    public function getCantidadInsumosAReponer($idTecnico)
    {
        try {
            $conex = $this->getConnection();
            $sql = "SELECT COUNT(*) AS total
                    FROM tbltecnicoinsumos ti
                    INNER JOIN tblinsumos i ON ti.idInsumos = i.idInsumos
                    WHERE ti.idTecnico = :idTecnico
                      AND i.activo = 1
                      AND CAST(i.cantidadDispInsumos AS DECIMAL) <= CAST(i.cantidadMinInsumos AS DECIMAL)";
            $stmt = $conex->prepare($sql);
            $stmt->bindParam(':idTecnico', $idTecnico, PDO::PARAM_INT);
            $stmt->execute();
            return (int) $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (\PDOException $e) {
            die("Error en TecnicosModel::getCantidadInsumosAReponer: " . $e->getMessage());
        }
    }

    public function getAllInsumos()
    {
        try {
            $conex = $this->getConnection();
            $sql = "SELECT * FROM tblinsumos WHERE activo = 1 ORDER BY nomInsumos ASC";
            $stmt = $conex->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            die("Error en TecnicosModel::getAllInsumos: " . $e->getMessage());
        }
    }

    public function getInsumosAsignadosIds($idTecnico)
    {
        try {
            $conex = $this->getConnection();
            $sql = "SELECT idInsumos FROM tbltecnicoinsumos WHERE idTecnico = :idTecnico";
            $stmt = $conex->prepare($sql);
            $stmt->bindParam(':idTecnico', $idTecnico, PDO::PARAM_INT);
            $stmt->execute();
            return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'idInsumos');
        } catch (\PDOException $e) {
            die("Error en TecnicosModel::getInsumosAsignadosIds: " . $e->getMessage());
        }
    }

    public function asignarInsumos($idTecnico, array $idsInsumos)
    {
        try {
            $conex = $this->getConnection();
            $conex->beginTransaction();

            $stmtDel = $conex->prepare("DELETE FROM tbltecnicoinsumos WHERE idTecnico = :idTecnico");
            $stmtDel->execute([':idTecnico' => $idTecnico]);

            if (!empty($idsInsumos)) {
                $stmtIns = $conex->prepare("INSERT INTO tbltecnicoinsumos (idTecnico, idInsumos) VALUES (:idTecnico, :idInsumos)");
                foreach ($idsInsumos as $idInsumo) {
                    $idInsumo = (int) $idInsumo;
                    if ($idInsumo > 0) {
                        $stmtIns->execute([':idTecnico' => $idTecnico, ':idInsumos' => $idInsumo]);
                    }
                }
            }

            $conex->commit();
            return true;
        } catch (\PDOException $e) {
            $conex->rollBack();
            die("Error en TecnicosModel::asignarInsumos: " . $e->getMessage());
        }
    }

    public function getInsumosAsignados($idTecnico)
    {
        try {
            $conex = $this->getConnection();
            $sql = "SELECT i.*, ti.idTecnico
                    FROM tbltecnicoinsumos ti
                    INNER JOIN tblinsumos i ON ti.idInsumos = i.idInsumos
                    WHERE ti.idTecnico = :idTecnico AND i.activo = 1
                    ORDER BY i.nomInsumos ASC";
            $stmt = $conex->prepare($sql);
            $stmt->bindParam(':idTecnico', $idTecnico, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            die("Error en TecnicosModel::getInsumosAsignados: " . $e->getMessage());
        }
    }
}
