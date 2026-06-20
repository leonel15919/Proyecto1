<?php

namespace App\Laboratorios\Models;

use App\Laboratorios\Config\Connect\ConnectDB;
use PDO;

class ReportesModel extends ConnectDB {
    public function getUsoLaboratorios() {
        $conex = $this->getConnection();
        $sql = "SELECT l.idLaboratorio, l.nomLaboratorio,
                       COUNT(r.idReserva) AS total_reservas
                FROM tbllaboratorio l
                LEFT JOIN tblreserva r ON l.idLaboratorio = r.idLaboratorio
                GROUP BY l.idLaboratorio, l.nomLaboratorio
                ORDER BY total_reservas DESC";
        $stmt = $conex->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $max = $rows ? max(array_column($rows, 'total_reservas')) : 0;
        foreach ($rows as &$row) {
            $row['porcentaje'] = $max > 0 ? round(($row['total_reservas'] / $max) * 100) : 0;
        }
        return $rows;
    }

    public function getStockResumen() {
        $model = new InsumosModel();
        $insumos = $model->getAll();

        $optimo = 0; $critico = 0; $agotado = 0;
        foreach ($insumos as $insumo) {
            $disp = (float)($insumo['cantidadDispInsumos'] ?? 0);
            $min = (float)($insumo['cantidadMinInsumos'] ?? 0);
            if ($disp <= 0) { $agotado++; }
            elseif ($disp <= $min) { $critico++; }
            else { $optimo++; }
        }
        return [
            'optimo' => $optimo, 'critico' => $critico,
            'agotado' => $agotado, 'total' => $optimo + $critico + $agotado,
        ];
    }

    public function getReporte($tipo, $fechaInicio = '', $fechaFin = '', $filtroCampo = '', $filtroValor = '') {
        $conex = $this->getConnection();
        $params = [];

        switch ($tipo) {
            case 'ocupacion':
                $sql = "SELECT r.idReserva, r.nombreReserva AS practica, r.fechaReserva,
                               r.horaInicioReserva, r.horaFinReserva, r.estadoReserva,
                               l.nomLaboratorio AS laboratorio
                        FROM tblreserva r
                        JOIN tbllaboratorio l ON r.idLaboratorio = l.idLaboratorio
                        WHERE 1=1";
                if ($fechaInicio) { $sql .= " AND r.fechaReserva >= :fi"; $params[':fi'] = $fechaInicio; }
                if ($fechaFin)    { $sql .= " AND r.fechaReserva <= :ff"; $params[':ff'] = $fechaFin; }
                if ($filtroCampo === 'Laboratorio' && $filtroValor) {
                    $sql .= " AND l.nomLaboratorio LIKE :fv"; $params[':fv'] = "%$filtroValor%";
                }
                $sql .= " ORDER BY r.fechaReserva DESC LIMIT 50";
                break;

            case 'insumos':
                $sql = "SELECT i.nomInsumos AS insumo, i.cantidadDispInsumos AS disponible,
                               i.cantidadMinInsumos AS minimo, i.unidadMedidaInsumos AS unidad,
                               i.categoriaInsumos AS categoria
                        FROM tblinsumos i
                        WHERE 1=1";
                if ($filtroCampo === 'Laboratorio' && $filtroValor) {
                    $sql .= " AND i.categoriaInsumos LIKE :fv"; $params[':fv'] = "%$filtroValor%";
                }
                $sql .= " ORDER BY i.nomInsumos LIMIT 50";
                break;

            case 'docente':
                $sql = "SELECT r.nombreReserva AS practica, r.fechaReserva,
                               r.horaInicioReserva, r.horaFinReserva, r.estadoReserva,
                               l.nomLaboratorio AS laboratorio,
                               (SELECT CONCAT(nomDocente, ' ', apellidoDocente)
                                FROM tbldocente
                                WHERE idSolicitudPractica = r.idSolicitudPractica
                                LIMIT 1) AS docente
                        FROM tblreserva r
                        JOIN tbllaboratorio l ON r.idLaboratorio = l.idLaboratorio
                        WHERE 1=1";
                if ($fechaInicio) { $sql .= " AND r.fechaReserva >= :fi"; $params[':fi'] = $fechaInicio; }
                if ($fechaFin)    { $sql .= " AND r.fechaReserva <= :ff"; $params[':ff'] = $fechaFin; }
                if ($filtroCampo === 'Docente' && $filtroValor) {
                    $sql .= " AND EXISTS (SELECT 1 FROM tbldocente d WHERE d.idSolicitudPractica = r.idSolicitudPractica
                              AND CONCAT(d.nomDocente, ' ', d.apellidoDocente) LIKE :fv)";
                    $params[':fv'] = "%$filtroValor%";
                }
                $sql .= " ORDER BY r.fechaReserva DESC LIMIT 50";
                break;

            case 'mantenimiento':
                $sql = "SELECT a.idAnomalia AS codigo, a.tipoAnomalia AS tipo,
                               a.descripAnomalia AS descripcion, a.fechaDecteAnomalia AS fecha,
                               a.estadoAnomalia AS estado,
                               l.nomLaboratorio AS laboratorio
                        FROM tblanomalia a
                        LEFT JOIN tblreserva r ON a.idReserva = r.idReserva
                        LEFT JOIN tbllaboratorio l ON r.idLaboratorio = l.idLaboratorio
                        WHERE 1=1";
                if ($fechaInicio) { $sql .= " AND a.fechaDecteAnomalia >= :fi"; $params[':fi'] = $fechaInicio; }
                if ($fechaFin)    { $sql .= " AND a.fechaDecteAnomalia <= :ff"; $params[':ff'] = $fechaFin; }
                if ($filtroCampo === 'Laboratorio' && $filtroValor) {
                    $sql .= " AND l.nomLaboratorio LIKE :fv"; $params[':fv'] = "%$filtroValor%";
                }
                $sql .= " ORDER BY a.fechaDecteAnomalia DESC LIMIT 50";
                break;

            case 'conflictos':
                $sql = "SELECT r1.nombreReserva AS practica, r1.fechaReserva,
                               r1.horaInicioReserva, r1.horaFinReserva,
                               l.nomLaboratorio AS laboratorio,
                               CONCAT(r1.horaInicioReserva, '-', r1.horaFinReserva) AS conflicto_con
                        FROM tblreserva r1
                        JOIN tbllaboratorio l ON r1.idLaboratorio = l.idLaboratorio
                        JOIN tblreserva r2 ON r1.idLaboratorio = r2.idLaboratorio
                            AND r1.fechaReserva = r2.fechaReserva
                            AND r1.idReserva < r2.idReserva
                            AND r1.horaInicioReserva < r2.horaFinReserva
                            AND r1.horaFinReserva > r2.horaInicioReserva
                        WHERE 1=1";
                if ($fechaInicio) { $sql .= " AND r1.fechaReserva >= :fi"; $params[':fi'] = $fechaInicio; }
                if ($fechaFin)    { $sql .= " AND r1.fechaReserva <= :ff"; $params[':ff'] = $fechaFin; }
                $sql .= " ORDER BY r1.fechaReserva, r1.horaInicioReserva LIMIT 50";
                break;

            default:
                return [];
        }

        $stmt = $conex->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Convert all time columns to 12h format
        $timeColumns = ['horaInicioReserva', 'horaFinReserva', 'horaInicioSolicitudPractica', 'horaFinSolicitudPractica'];
        foreach ($rows as &$row) {
            foreach ($timeColumns as $col) {
                if (isset($row[$col]) && $row[$col]) {
                    $ts = strtotime($row[$col]);
                    if ($ts !== false) {
                        $row[$col] = date('h:i A', $ts);
                    }
                }
            }
        }

        return $rows;
    }

    private function getAllInsumos() {
        $model = new InsumosModel();
        return $model->getAll();
    }
}
