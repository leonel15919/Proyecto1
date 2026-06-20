<?php
namespace App\Laboratorios\Models;

use App\Laboratorios\Config\Connect\ConnectDB;
use PDO;

class ReservasModel extends ConnectDB
{
    public function getAll($estado = null)
    {
        $conex = $this->getConnection();
        $sql = "
            SELECT r.*, l.nomLaboratorio,
                   (SELECT CONCAT(nomDocente, ' ', apellidoDocente)
                    FROM tbldocente
                    WHERE idSolicitudPractica = r.idSolicitudPractica
                    LIMIT 1) AS nombreDocente
            FROM tblreserva r
            LEFT JOIN tbllaboratorio l ON r.idLaboratorio = l.idLaboratorio
            WHERE r.activo = 1";

        $params = [];
        if (!empty($estado) && $estado !== 'todos') {
            $sql .= " AND r.estadoReserva = :estado";
            $params[':estado'] = $estado;
        }

        $sql .= " ORDER BY r.fechaReserva DESC, r.horaInicioReserva";

        $stmt = $conex->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $conex = $this->getConnection();
        $stmt = $conex->prepare("
            SELECT r.*, l.nomLaboratorio
            FROM tblreserva r
            LEFT JOIN tbllaboratorio l ON r.idLaboratorio = l.idLaboratorio
            WHERE r.idReserva = :id AND r.activo = 1
        ");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function verificarConflicto(string $fecha, string $horaInicio, string $horaFin, int $idLaboratorio, ?int $excluirId = null): bool
    {
        $conex = $this->getConnection();
        $sql = "SELECT COUNT(*) FROM tblreserva
                WHERE fechaReserva = :fecha
                  AND idLaboratorio = :idLaboratorio
                  AND activo = 1
                  AND horaInicioReserva < :horaFin
                  AND horaFinReserva > :horaInicio";
        $params = [
            ':fecha'         => $fecha,
            ':idLaboratorio' => $idLaboratorio,
            ':horaInicio'    => $horaInicio,
            ':horaFin'       => $horaFin,
        ];
        if ($excluirId !== null) {
            $sql .= " AND idReserva != :excluirId";
            $params[':excluirId'] = $excluirId;
        }
        $stmt = $conex->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

    public function create($data)
    {
        try {
            $fecha      = $data['fechaReserva'];
            $horaInicio = $data['horaInicioReserva'];
            $horaFin    = $data['horaFinReserva'];
            $idLab      = (int) ($data['idLaboratorio'] ?? 0);

            // 1. Validar consistencia horaria (Inicio debe ser menor a Fin)
            if (strtotime($horaInicio) >= strtotime($horaFin)) {
                $_SESSION['error_message'] = "La hora de inicio debe ser anterior a la hora de finalización.";
                header("Location: index.php?url=Reserva&type=register");
                exit;
            }

            // 2. Verificar si hay choque de horario en el mismo laboratorio y fecha
            if ($this->verificarConflicto($fecha, $horaInicio, $horaFin, $idLab)) {
                $_SESSION['error_message'] = "Ya existe una reserva en ese laboratorio para la misma fecha y hora.";
                header("Location: index.php?url=Reserva&type=register");
                exit;
            }

            $conex = $this->getConnection();
            $stmt = $conex->prepare("
                INSERT INTO tblreserva
                    (objetivoReserva, horaInicioReserva, horaFinReserva, nombreReserva,
                     fechaReserva, descripReserva, turnoReserva, estadoReserva,
                     observacionReserva, idLaboratorio, idSolicitudPractica, idTipoPractica,
                     activo)
                VALUES
                    (:objetivo, :horaInicio, :horaFin, :nombre,
                     :fecha, :descrip, :turno, :estado,
                     :observacion, :idLaboratorio, :idSolicitud, :idTipo,
                     1)
            ");
            $stmt->execute([
                ':objetivo'      => $data['objetivoReserva'] ?? '',
                ':horaInicio'    => $horaInicio,
                ':horaFin'       => $horaFin,
                ':nombre'        => $data['nombreReserva'],
                ':fecha'         => $fecha,
                ':descrip'       => $data['descripReserva'] ?? '',
                ':turno'         => $data['turnoReserva'] ?? '',
                ':estado'        => $data['estadoReserva'] ?? 'aprobada',
                ':observacion'   => $data['observacionReserva'] ?? '',
                ':idLaboratorio' => $idLab,
                ':idSolicitud'   => (int) ($data['idSolicitudPractica'] ?? 0),
                ':idTipo'        => (int) ($data['idTipoPractica'] ?? 0),
            ]);
            return $conex->lastInsertId();
        } catch (\PDOException $e) {
            $_SESSION['error_message'] = "Error al crear la reserva: " . $e->getMessage();
            header("Location: index.php?url=Reserva&type=list");
            exit;
        }
    }

    public function update($id, $data)
    {
        try {
            $fecha      = $data['fechaReserva'];
            $horaInicio = $data['horaInicioReserva'];
            $horaFin    = $data['horaFinReserva'];
            $idLab      = (int) ($data['idLaboratorio'] ?? 0);

            // 1. Validar consistencia horaria
            if (strtotime($horaInicio) >= strtotime($horaFin)) {
                $_SESSION['error_message'] = "La hora de inicio debe ser anterior a la hora de finalización.";
                header("Location: index.php?url=Reserva&type=edit&id=" . (int)$id);
                exit;
            }

            // 2. Verificar conflicto excluyendo la reserva actual que se está editando
            if ($this->verificarConflicto($fecha, $horaInicio, $horaFin, $idLab, (int) $id)) {
                $_SESSION['error_message'] = "Ya existe otra reserva en ese laboratorio para la misma fecha y hora.";
                header("Location: index.php?url=Reserva&type=edit&id=" . (int)$id);
                exit;
            }

            $conex = $this->getConnection();
            $stmt = $conex->prepare("
                UPDATE tblreserva SET
                    objetivoReserva     = :objetivo,
                    horaInicioReserva   = :horaInicio,
                    horaFinReserva      = :horaFin,
                    nombreReserva       = :nombre,
                    fechaReserva        = :fecha,
                    descripReserva      = :descrip,
                    turnoReserva        = :turno,
                    estadoReserva       = :estado,
                    observacionReserva  = :observacion,
                    idLaboratorio       = :idLaboratorio,
                    idSolicitudPractica = :idSolicitud,
                    idTipoPractica      = :idTipo
                WHERE idReserva = :id
            ");
            $stmt->execute([
                ':objetivo'      => $data['objetivoReserva'] ?? '',
                ':horaInicio'    => $horaInicio,
                ':horaFin'       => $horaFin,
                ':nombre'        => $data['nombreReserva'],
                ':fecha'         => $fecha,
                ':descrip'       => $data['descripReserva'] ?? '',
                ':turno'         => $data['turnoReserva'] ?? '',
                ':estado'        => $data['estadoReserva'] ?? 'aprobada',
                ':observacion'   => $data['observacionReserva'] ?? '',
                ':idLaboratorio' => $idLab,
                ':idSolicitud'   => (int) ($data['idSolicitudPractica'] ?? 0),
                ':idTipo'        => (int) ($data['idTipoPractica'] ?? 0),
                ':id'            => (int) $id,
            ]);
            return $stmt->rowCount();
        } catch (\PDOException $e) {
            $_SESSION['error_message'] = "Error al actualizar la reserva: " . $e->getMessage();
            header("Location: index.php?url=Reserva&type=list");
            exit;
        }
    }

    public function delete($id)
    {
        try {
            $conex = $this->getConnection();
            $stmt = $conex->prepare("UPDATE tblreserva SET activo = 0 WHERE idReserva = :id");
            $stmt->execute([':id' => (int) $id]);
            return $stmt->rowCount();
        } catch (\PDOException $e) {
            $_SESSION['error_message'] = "Error al eliminar la reserva: " . $e->getMessage();
            header("Location: index.php?url=Reserva&type=list");
            exit;
        }
    }

    public function getProximas(int $dias = 15): array
    {
        $conex = $this->getConnection();
        $stmt = $conex->prepare("
            SELECT r.*, l.nomLaboratorio,
                   (SELECT CONCAT(nomDocente, ' ', apellidoDocente)
                    FROM tbldocente
                    WHERE idSolicitudPractica = r.idSolicitudPractica
                    LIMIT 1) AS nombreDocente
            FROM tblreserva r
            LEFT JOIN tbllaboratorio l ON r.idLaboratorio = l.idLaboratorio
            WHERE r.activo = 1 AND r.fechaReserva BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL :dias DAY)
            ORDER BY r.fechaReserva ASC, r.horaInicioReserva ASC
        ");
        $stmt->bindValue(':dias', $dias, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSemanal($fechaInicio, $estado = null): array
    {
        $conex = $this->getConnection();
        $sql = "
            SELECT r.*, l.nomLaboratorio,
                   (SELECT CONCAT(nomDocente, ' ', apellidoDocente)
                    FROM tbldocente
                    WHERE idSolicitudPractica = r.idSolicitudPractica
                    LIMIT 1) AS nombreDocente
            FROM tblreserva r
            LEFT JOIN tbllaboratorio l ON r.idLaboratorio = l.idLaboratorio
            WHERE r.activo = 1 AND r.fechaReserva BETWEEN :inicio AND DATE_ADD(:inicio, INTERVAL 6 DAY)";

        $params = [':inicio' => $fechaInicio];

        if (!empty($estado) && $estado !== 'todos') {
            $sql .= " AND r.estadoReserva = :estado";
            $params[':estado'] = $estado;
        }

        $sql .= " ORDER BY r.fechaReserva ASC, r.horaInicioReserva ASC";

        $stmt = $conex->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getHoyCount(): int
    {
        $conex = $this->getConnection();
        $stmt = $conex->query("SELECT COUNT(*) FROM tblreserva WHERE fechaReserva = CURDATE() AND activo = 1");
        return (int) $stmt->fetchColumn();
    }
}
