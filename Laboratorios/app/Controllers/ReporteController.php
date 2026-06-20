<?php
namespace App\Laboratorios\Controllers;

use App\Laboratorios\Models\ReportesModel;

$object = new ReportesModel();

if (isset($_GET['type'])) {
    $type = $_GET['type'];

    if ($type === 'main') {
        $usoLaboratorios = $object->getUsoLaboratorios();
        $stockResumen    = $object->getStockResumen();
        $pageTitle       = "Reportes - Sistema de Laboratorios";
        $activeRoute     = "reporte";
        $viewPath        = "app/Views/reportes.php";
        include "app/Views/layouts/main.php";

    } elseif ($type === 'generate') {
        $resultados = [];
        $tipoSeleccionado = $_GET['tipo'] ?? '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tipoSeleccionado = $_POST['tipo'] ?? '';
            $fechaInicio      = $_POST['fechaInicio'] ?? '';
            $fechaFin         = $_POST['fechaFin'] ?? '';
            $filtroCampo      = $_POST['filtroCampo'] ?? '';
            $filtroValor      = $_POST['filtroValor'] ?? '';
        } else {
            $fechaInicio = $_GET['fechaInicio'] ?? '';
            $fechaFin    = $_GET['fechaFin'] ?? '';
            $filtroCampo = $_GET['filtroCampo'] ?? '';
            $filtroValor = $_GET['filtroValor'] ?? '';
        }

        if ($tipoSeleccionado) {
            $resultados = $object->getReporte($tipoSeleccionado, $fechaInicio, $fechaFin, $filtroCampo, $filtroValor);
        }

        $pageTitle   = "Generación de Reportes - Sistema de Laboratorios";
        $activeRoute = "reporte";
        $viewPath    = "app/Views/generacionReportes.php";
        include "app/Views/layouts/main.php";
    }
} else {
    header("Location: index.php?url=Reporte&type=main");
}
