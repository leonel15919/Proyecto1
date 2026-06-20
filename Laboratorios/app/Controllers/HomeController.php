<?php
namespace App\Laboratorios\Controllers;

use App\Laboratorios\Models\InsumosModel;
use App\Laboratorios\Models\GestionUsuariosModel;
use App\Laboratorios\Models\SolicitudesModel;
use App\Laboratorios\Models\ReservasModel;
use App\Laboratorios\Models\LaboratoriosModel;

$insumoModel      = new InsumosModel();
$userModel        = new GestionUsuariosModel();
$solicitudModel   = new SolicitudesModel();
$reservaModel     = new ReservasModel();
$laboratorioModel = new LaboratoriosModel();

$insumos          = $insumoModel->getAll();
$docenteCount     = $userModel->getDocenteCount();
$solicitudesPend  = $solicitudModel->getPendientesCount();
$reservasHoy      = $reservaModel->getHoyCount();
$proximasClases   = $reservaModel->getProximas(15);

$labResumen   = $laboratorioModel->getResumen();
$totalUsers   = count($userModel->getAll());
$totalInsumos = count($insumos);

$insumosCriticos = 0;
$stockBajo = [];

foreach ($insumos as $insumo) {
    $disp = (float)($insumo['cantidadDispInsumos'] ?? 0);
    $min  = (float)($insumo['cantidadMinInsumos'] ?? 0);
    if ($disp <= $min) {
        $insumosCriticos++;
    }
    if ($disp <= 0) {
        $stockBajo[] = $insumo;
    }
}

$pageTitle   = "Inicio - Dirección de Formación";
$activeRoute = "home";
$viewPath    = "app/Views/home.php";
include "app/Views/layouts/main.php";
