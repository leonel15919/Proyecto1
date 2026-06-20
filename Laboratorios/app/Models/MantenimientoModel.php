<?php
namespace App\Laboratorios\Models;

use App\Laboratorios\Config\Connect\ConnectDB;
use PDO;

class MantenimientoModel extends ConnectDB
{
    public function getAnomaliasByLaboratorio($idLab)
    {
        $conex = $this->getConnection();
        $stmt = $conex->prepare("
            SELECT a.*, t.nomTecnico
            FROM tblanomalia a
            LEFT JOIN tbltecnico t ON a.idTecnico = t.idTecnico
            WHERE a.idReserva IN (
                SELECT idReserva FROM tblreserva WHERE idLaboratorio = :idLab
            )
            ORDER BY a.fechaDecteAnomalia DESC
        ");
        $stmt->execute([':idLab' => $idLab]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllAnomalias()
    {
        $conex = $this->getConnection();
        $stmt = $conex->query("
            SELECT a.*, t.nomTecnico, l.nomLaboratorio
            FROM tblanomalia a
            LEFT JOIN tbltecnico t ON a.idTecnico = t.idTecnico
            LEFT JOIN tblreserva r ON a.idReserva = r.idReserva
            LEFT JOIN tbllaboratorio l ON r.idLaboratorio = l.idLaboratorio
            ORDER BY a.fechaDecteAnomalia DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($idReserva, $descripcion, $tipoAnomalia, $idTecnico)
    {
        $conex = $this->getConnection();
        $stmt = $conex->prepare("
            INSERT INTO tblanomalia (idReserva, descripAnomalia, tipoAnomalia, fechaDecteAnomalia, estadoAnomalia, fechaResoAnomalia, idTecnico, idPractica, activo)
            VALUES (:idReserva, :descripcion, :tipo, NOW(), 'pendiente', NOW(), :idTecnico, 1, 1)
        ");
        $stmt->execute([
            ':idReserva' => $idReserva,
            ':descripcion' => $descripcion,
            ':tipo' => $tipoAnomalia,
            ':idTecnico' => $idTecnico,
        ]);
        return $conex->lastInsertId();
    }

    public function getCount()
    {
        $conex = $this->getConnection();
        $stmt = $conex->query("SELECT COUNT(*) AS total FROM tblanomalia");
        return (int) $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
}
