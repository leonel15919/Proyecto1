<?php
namespace App\Laboratorios\Controllers;

use App\Laboratorios\Models\MantenimientoModel;

$object = new MantenimientoModel();

if (!isset($_GET['type'])) {
    header("Location: ?url=Mantenimiento&type=list");
    exit;
}

if ($_GET['type'] === 'list') {
    $idLab = isset($_GET['id']) ? (int) $_GET['id'] : null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $tipo = $_POST['tipoAnomalia'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        $idReserva = (int) ($_POST['idReserva'] ?? 1);
        $idTecnico = (int) ($_POST['idTecnico'] ?? 1);
        if ($tipo && $descripcion) {
            $object->create($idReserva, $descripcion, $tipo, $idTecnico);
            header("Location: ?url=Mantenimiento&type=list&success=1" . ($idLab ? "&id=$idLab" : ""));
            exit;
        }
    }

    $anomalias = $idLab ? $object->getAnomaliasByLaboratorio($idLab) : $object->getAllAnomalias();
    $totalMantenimientos = $object->getCount();
    $success = $_GET['success'] ?? 0;

    $pageTitle = "Mantenimiento - Sistema de Laboratorios";
    $activeRoute = "mantenimiento";
    $viewPath = "app/Views/mantenimientoLabs.php";
    include "app/Views/layouts/main.php";
}
