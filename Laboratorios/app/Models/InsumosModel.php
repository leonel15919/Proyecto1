<?php

namespace App\Laboratorios\Models;

use App\Laboratorios\Config\Connect\ConnectDB;
use PDO;

class InsumosModel extends ConnectDB {
    public function getAll() {
        try {
            $conex = $this->getConnection();
            $sql = "SELECT * FROM `tblinsumos` WHERE `activo` = 1 ORDER BY `nomInsumos` ASC";
            $response = $conex->prepare($sql);
            $response->execute();
            return $response->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            die("Error en InsumosModel::getAll: " . $e->getMessage());
        }
    }

    public function getById($id) {
        try {
            $conex = $this->getConnection();
            $sql = "SELECT * FROM `tblinsumos` WHERE `idInsumos` = :id";
            $stmt = $conex->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            die("Error en InsumosModel::getById: " . $e->getMessage());
        }
    }

    public function create($data) {
        try {
            $conex = $this->getConnection();
            $sql = "INSERT INTO `tblinsumos` 
                    (`nomInsumos`, `descripInsumos`, `categoriaInsumos`, `cantidadStock`, `cantidadDispInsumos`, `cantidadMinInsumos`, `unidadMedidaInsumos`, `activo`) 
                    VALUES 
                    (:nombre, :descripcion, :categoria, :stock, :disponible, :stockMin, :unidad, 1)";
            $stmt = $conex->prepare($sql);
            $stmt->bindValue(':nombre', $data['nomInsumos']);
            $stmt->bindValue(':descripcion', $data['descripInsumos'] ?? '');
            $stmt->bindValue(':categoria', $data['categoriaInsumos'] ?? '');
            $stmt->bindValue(':stock', $data['cantidadStock'] ?? '0');
            $stmt->bindValue(':disponible', $data['cantidadDispInsumos'] ?? $data['cantidadStock'] ?? '0');
            $stmt->bindValue(':stockMin', $data['cantidadMinInsumos'] ?? '0');
            $stmt->bindValue(':unidad', $data['unidadMedidaInsumos'] ?? '');
            return $stmt->execute();
        } catch (\PDOException $e) {
            die("Error en InsumosModel::create: " . $e->getMessage());
        }
    }

    public function update($id, $data) {
        try {
            $conex = $this->getConnection();
            $sql = "UPDATE `tblinsumos` SET 
                        `nomInsumos` = :nombre,
                        `descripInsumos` = :descripcion,
                        `categoriaInsumos` = :categoria,
                        `cantidadStock` = :stock,
                        `cantidadDispInsumos` = :disponible,
                        `cantidadMinInsumos` = :stockMin,
                        `unidadMedidaInsumos` = :unidad
                    WHERE `idInsumos` = :id";
            $stmt = $conex->prepare($sql);
            $stmt->bindValue(':nombre', $data['nomInsumos']);
            $stmt->bindValue(':descripcion', $data['descripInsumos'] ?? '');
            $stmt->bindValue(':categoria', $data['categoriaInsumos'] ?? '');
            $stmt->bindValue(':stock', $data['cantidadStock'] ?? '0');
            $stmt->bindValue(':disponible', $data['cantidadDispInsumos'] ?? '0');
            $stmt->bindValue(':stockMin', $data['cantidadMinInsumos'] ?? '0');
            $stmt->bindValue(':unidad', $data['unidadMedidaInsumos'] ?? '');
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            die("Error en InsumosModel::update: " . $e->getMessage());
        }
    }

    public function delete($id) {
        try {
            $conex = $this->getConnection();
            $sql = "DELETE FROM `tblinsumos` WHERE `idInsumos` = :id";
            $stmt = $conex->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            die("Error en InsumosModel::delete: " . $e->getMessage());
        }
    }

    public function getCriticalStock() {
        try {
            $conex = $this->getConnection();
            $sql = "SELECT * FROM `tblinsumos` 
                    WHERE CAST(`cantidadDispInsumos` AS DECIMAL) <= CAST(`cantidadMinInsumos` AS DECIMAL) 
                    ORDER BY CAST(`cantidadDispInsumos` AS DECIMAL) ASC";
            $response = $conex->prepare($sql);
            $response->execute();
            return $response->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            die("Error en InsumosModel::getCriticalStock: " . $e->getMessage());
        }
    }
}
