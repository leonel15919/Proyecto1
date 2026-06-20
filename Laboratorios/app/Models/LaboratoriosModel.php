<?php
namespace App\Laboratorios\Models;

use App\Laboratorios\Config\Connect\ConnectDB;
use PDO;

class LaboratoriosModel extends ConnectDB
{
    public function getAll()
    {
        $conex = $this->getConnection();
        $stmt = $conex->query("SELECT * FROM tbllaboratorio WHERE activo = 1 ORDER BY nomLaboratorio");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getResumen()
    {
        $conex = $this->getConnection();
        $stmt = $conex->query("
            SELECT
                SUM(CASE WHEN estadoLaboratorio = 'disponible' THEN 1 ELSE 0 END) AS disponible,
                SUM(CASE WHEN estadoLaboratorio = 'en_uso' THEN 1 ELSE 0 END) AS en_uso,
                SUM(CASE WHEN estadoLaboratorio = 'mantenimiento' THEN 1 ELSE 0 END) AS mantenimiento
            FROM tbllaboratorio
        ");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return [
            'disponible' => (int) ($row['disponible'] ?? 0),
            'en_uso' => (int) ($row['en_uso'] ?? 0),
            'mantenimiento' => (int) ($row['mantenimiento'] ?? 0),
        ];
    }

    public function getById($id)
    {
        $conex = $this->getConnection();
        $stmt = $conex->prepare("SELECT * FROM tbllaboratorio WHERE idLaboratorio = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $conex = $this->getConnection();
        $stmt = $conex->prepare("
            INSERT INTO tbllaboratorio (tipoLaboratorio, capacidadLaboratorio, estadoLaboratorio, ubicacionLaboratorio, nomLaboratorio, activo)
            VALUES (:tipo, :capacidad, :estado, :ubicacion, :nombre, 1)
        ");
        $stmt->execute([
            ':tipo'      => $data['tipoLaboratorio'],
            ':capacidad' => $data['capacidadLaboratorio'],
            ':estado'    => $data['estadoLaboratorio'] ?? 'disponible',
            ':ubicacion' => $data['ubicacionLaboratorio'],
            ':nombre'    => $data['nomLaboratorio'],
        ]);
        return $conex->lastInsertId();
    }

    public function update($id, $data)
    {
        $conex = $this->getConnection();
        $stmt = $conex->prepare("
            UPDATE tbllaboratorio
            SET tipoLaboratorio     = :tipo,
                capacidadLaboratorio = :capacidad,
                estadoLaboratorio    = :estado,
                ubicacionLaboratorio = :ubicacion,
                nomLaboratorio       = :nombre
            WHERE idLaboratorio = :id
        ");
        $stmt->execute([
            ':tipo'      => $data['tipoLaboratorio'],
            ':capacidad' => $data['capacidadLaboratorio'],
            ':estado'    => $data['estadoLaboratorio'],
            ':ubicacion' => $data['ubicacionLaboratorio'],
            ':nombre'    => $data['nomLaboratorio'],
            ':id'        => $id,
        ]);
        return $stmt->rowCount();
    }

    public function delete($id)
    {
        $conex = $this->getConnection();
        $stmt = $conex->prepare("DELETE FROM tbllaboratorio WHERE idLaboratorio = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount();
    }

    public function updateEstado($id, $estado)
    {
        $conex = $this->getConnection();
        $stmt = $conex->prepare("UPDATE tbllaboratorio SET estadoLaboratorio = :estado WHERE idLaboratorio = :id");
        $stmt->execute([':estado' => $estado, ':id' => $id]);
        return $stmt->rowCount();
    }

    public function getReservasByLaboratorio($idLab)
    {
        $conex = $this->getConnection();
        $stmt = $conex->prepare("
            SELECT r.*, sp.horaInicioSolicitudPractica, sp.horaFinSolicitudPractica
            FROM tblreserva r
            LEFT JOIN tblsolicitudpractica sp ON r.idSolicitudPractica = sp.idSolicitudPractica
            WHERE r.idLaboratorio = :idLab
            ORDER BY r.fechaReserva DESC
        ");
        $stmt->execute([':idLab' => $idLab]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCronogramaSemana(string $lunes): array
    {
        $conex = $this->getConnection();
        $domingo = date('Y-m-d', strtotime($lunes . ' +6 days'));
        $stmt = $conex->prepare("
            SELECT r.*, l.nomLaboratorio, l.ubicacionLaboratorio,
                   (SELECT CONCAT(nomDocente, ' ', apellidoDocente)
                    FROM tbldocente
                    WHERE idSolicitudPractica = r.idSolicitudPractica
                    LIMIT 1) AS nombreDocente
            FROM tblreserva r
            LEFT JOIN tbllaboratorio l ON r.idLaboratorio = l.idLaboratorio
            WHERE r.fechaReserva BETWEEN :lunes AND :domingo
            ORDER BY r.fechaReserva, r.horaInicioReserva
        ");
        $stmt->execute([':lunes' => $lunes, ':domingo' => $domingo]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
