<?php
namespace App\Laboratorios\Controllers;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use App\Laboratorios\Models\InsumosModel;

$insumoModel  = new InsumosModel();

$successMessage = '';
$errorMessage = '';
if (isset($_SESSION['success_message'])) {
    $successMessage = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}
if (isset($_SESSION['error_message'])) {
    $errorMessage = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}

$rolActual = $_SESSION['user_rol'] ?? '';
$esAdmin = ($rolActual === 'Administrador');

$type = $_GET['type'] ?? 'list';

switch ($type) {

    case 'list':
        if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
            $insumoModel->delete((int)$_GET['id']);
            $_SESSION['success_message'] = 'Insumo eliminado correctamente.';
            header('Location: index.php?url=Insumo');
            exit;
        }
        $insumos = $insumoModel->getAll();
        $buscar  = trim($_GET['q'] ?? '');
        if ($buscar !== '') {
            $insumos = array_filter($insumos, function($i) use ($buscar) {
                $buscarLower = mb_strtolower($buscar);
                return mb_strpos(mb_strtolower($i['nomInsumos'] ?? ''), $buscarLower) !== false
                    || mb_strpos(mb_strtolower($i['categoriaInsumos'] ?? ''), $buscarLower) !== false
                    || mb_strpos(mb_strtolower($i['descripInsumos'] ?? ''), $buscarLower) !== false;
            });
        }
        $pageTitle   = "Inventario General - Sistema de Laboratorios";
        $activeRoute = "insumo";
        $viewPath    = "app/Views/inventarioGeneral.php";
        break;

    case 'register':
        if (!$esAdmin) {
            $_SESSION['error_message'] = 'Acceso denegado: solo Administradores pueden registrar insumos.';
            header('Location: index.php?url=Insumo');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cantidadInicial = max(0, (int)($_POST['cantidadInicial'] ?? '0'));
            $stockMinimo     = max(0, (int)($_POST['stockMinimo'] ?? '0'));
            $codLote   = trim($_POST['codigoLote'] ?? '');
            $ubicacion = trim($_POST['ubicacion'] ?? '');
            $fechaVenc = trim($_POST['fechaVencimiento'] ?? '');
            $descParts = array_filter([$codLote, $ubicacion, $fechaVenc ? "Vence: $fechaVenc" : '']);
            $data = [
                'nomInsumos'             => $_POST['nombre']     ?? '',
                'descripInsumos'         => implode(' | ', $descParts),
                'categoriaInsumos'       => $_POST['categoria']   ?? '',
                'cantidadStock'          => $cantidadInicial,
                'cantidadDispInsumos'    => $cantidadInicial,
                'cantidadMinInsumos'     => $stockMinimo,
                'unidadMedidaInsumos'    => $_POST['unidadMedida'] ?? '',
            ];
            $nuevoId = $insumoModel->create($data);
            if ($nuevoId !== false) {
                $_SESSION['success_message'] = 'Insumo registrado correctamente.';
                header('Location: index.php?url=Insumo');
                exit;
            }
            $errorMessage = 'Error al registrar el insumo.';
        }
        $pageTitle   = "Registrar Nuevo Insumo";
        $activeRoute = "insumo";
        $viewPath    = "app/Views/nuevoInsumo.php";
        break;

    case 'edit':
        if (!$esAdmin) {
            $_SESSION['error_message'] = 'Acceso denegado: solo Administradores pueden editar insumos.';
            header('Location: index.php?url=Insumo');
            exit;
        }
        $id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoria = $_POST['categoria'] ?? '';
            $ubicacion = trim($_POST['ubicacion'] ?? '');
            $fechaVenc = trim($_POST['fechaVencimiento'] ?? '');
            if ($categoria === 'Equipos de Cómputo e Insumos Tecnológicos') {
                $marca   = trim($_POST['marca'] ?? '');
                $modelo  = trim($_POST['modelo'] ?? '');
                $serial  = trim($_POST['serial'] ?? '');
                $descParts = array_filter([$marca, $modelo, $serial, $ubicacion, $fechaVenc ? "Vence: $fechaVenc" : '']);
            } else {
                $codLote = trim($_POST['codigoLote'] ?? '');
                $descParts = array_filter([$codLote, $ubicacion, $fechaVenc ? "Vence: $fechaVenc" : '']);
            }
            $data = [
                'nomInsumos'             => $_POST['nombre']            ?? '',
                'descripInsumos'         => implode(' | ', $descParts),
                'categoriaInsumos'       => $_POST['categoria']          ?? '',
                'cantidadStock'          => max(0, (int)($_POST['cantidadStock'] ?? '0')),
                'cantidadDispInsumos'    => max(0, (int)($_POST['cantidadDispInsumos'] ?? '0')),
                'cantidadMinInsumos'     => max(0, (int)($_POST['stockMinimo'] ?? '0')),
                'unidadMedidaInsumos'    => $_POST['unidadMedida']       ?? '',
            ];
            if ($insumoModel->update($id, $data)) {
                $_SESSION['success_message'] = 'Insumo actualizado correctamente.';
                header('Location: index.php?url=Insumo');
                exit;
            }
            $errorMessage = 'Error al actualizar el insumo.';
        }
        $insumo      = $insumoModel->getById($id);
        $esComputacion = ($insumo['categoriaInsumos'] ?? '') === 'Equipos de Cómputo e Insumos Tecnológicos';
        $descripParts = [];
        if (!empty($insumo['descripInsumos'])) {
            $parts = explode(' | ', $insumo['descripInsumos']);
            if ($esComputacion) {
                $descripParts = $parts;
            } else {
                $descripParts[0] = $parts[0] ?? '';
                $descripParts[1] = $parts[1] ?? '';
                $descripParts[2] = $parts[2] ?? '';
            }
        }
        $pageTitle   = "Editar Insumo";
        $activeRoute = "insumo";
        $viewPath    = "app/Views/editarInsumo.php";
        break;

    case 'alertas':
        $insumosCriticos = $insumoModel->getCriticalStock();
        $pageTitle       = "Alertas de Stock - Sistema de Laboratorios";
        $activeRoute     = "insumo";
        $viewPath        = "app/Views/alertasStock.php";
        break;

        case 'register_computacion':
        if (!$esAdmin) {
            $_SESSION['error_message'] = 'Acceso denegado: solo Administradores pueden registrar insumos.';
            header('Location: index.php?url=Insumo');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $marca   = trim($_POST['marca'] ?? '');
            $modelo  = trim($_POST['modelo'] ?? '');
            $serial  = trim($_POST['serial'] ?? '');
            $ubic    = trim($_POST['ubicacion'] ?? '');
            $fechaVenc = trim($_POST['fechaVencimiento'] ?? '');
            $descParts = array_filter([$marca, $modelo, $serial, $ubic, $fechaVenc ? "Vence: $fechaVenc" : '']);
            $data = [
                'nomInsumos'          => $_POST['nombre'] ?? '',
                'descripInsumos'      => implode(' | ', $descParts),
                'categoriaInsumos'    => 'Equipos de Cómputo e Insumos Tecnológicos',
                'cantidadStock'       => max(0, (int)($_POST['cantidad'] ?? '0')),
                'cantidadDispInsumos' => max(0, (int)($_POST['cantidad'] ?? '0')),
                'cantidadMinInsumos'  => max(0, (int)($_POST['stockMinimo'] ?? '0')),
                'unidadMedidaInsumos' => 'Unidades (Pzas)',
            ];
            $nuevoId = $insumoModel->create($data);
            if ($nuevoId !== false) {
                $_SESSION['success_message'] = 'Insumo de cómputo registrado correctamente.';
                header('Location: index.php?url=Insumo');
                exit;
            }
            $errorMessage = 'Error al registrar el insumo de cómputo.';
        }
        $pageTitle   = "Registrar Insumo de Cómputo";
        $activeRoute = "insumo";
        $viewPath    = "app/Views/nuevoInsumoComputacion.php";
        break;

    default:
        header('Location: index.php?url=Insumo&type=list');
        exit;
}

include "app/Views/layouts/main.php";
