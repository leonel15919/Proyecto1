<?php
namespace App\Laboratorios\Controllers;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use App\Laboratorios\Models\TecnicosModel;

$object = new TecnicosModel();

$successMessage = $_SESSION['success_message'] ?? '';
$errorMessage   = $_SESSION['error_message'] ?? '';
unset($_SESSION['success_message'], $_SESSION['error_message']);

$rolActual = $_SESSION['user_rol'] ?? '';
$esAdmin   = ($rolActual === 'Administrador');

if (!isset($_GET['type'])) {
    header("Location: index.php?url=Tecnico&type=list");
    exit;
}

$type = $_GET['type'];

switch ($type) {

    case 'list':
        $tecnicos = $object->getAll();
        $cantidadReponer = [];
        foreach ($tecnicos as $t) {
            $cantidadReponer[$t['idTecnico']] = $object->getCantidadInsumosAReponer($t['idTecnico']);
        }
        $pageTitle   = "Gestión de Técnicos - Sistema de Laboratorios";
        $activeRoute = "tecnico";
        $viewPath    = "app/Views/tecnicos.php";
        break;

    case 'register':
        if (!$esAdmin) {
            $_SESSION['error_message'] = "No tienes permisos para registrar técnicos.";
            header("Location: ?url=Tecnico&type=list");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nuevoId = $object->create($_POST);
            if ($nuevoId !== false) {
                if (!empty($_POST['telefono'])) {
                    $object->addTelefono($nuevoId, $_POST['telefono']);
                }
                $object->asignarInsumos($nuevoId, $_POST['insumos'] ?? []);
                $_SESSION['success_message'] = "Técnico registrado correctamente.";
                header("Location: ?url=Tecnico&type=list");
                exit;
            }
            $errorMessage = "Error al registrar el técnico.";
        }
        $especialidades = $object->getEspecialidades();
        $insumos = $object->getAllInsumos();
        $pageTitle   = "Registrar Técnico - Sistema de Laboratorios";
        $activeRoute = "tecnico";
        $viewPath    = "app/Views/crearTecnico.php";
        break;

    case 'edit':
        if (!$esAdmin) {
            $_SESSION['error_message'] = "No tienes permisos para editar técnicos.";
            header("Location: ?url=Tecnico&type=list");
            exit;
        }
        $id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
        $tecnico = $object->getById($id);
        if (!$tecnico) {
            $_SESSION['error_message'] = "Técnico no encontrado.";
            header("Location: ?url=Tecnico&type=list");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($object->update($id, $_POST)) {
                $object->asignarInsumos($id, $_POST['insumos'] ?? []);
                $_SESSION['success_message'] = "Técnico actualizado correctamente.";
                header("Location: ?url=Tecnico&type=list");
                exit;
            }
            $errorMessage = "Error al actualizar el técnico.";
        }
        $especialidades = $object->getEspecialidades();
        $insumos = $object->getAllInsumos();
        $insumosAsignadosIds = $object->getInsumosAsignadosIds($id);
        $pageTitle   = "Editar Técnico - Sistema de Laboratorios";
        $activeRoute = "tecnico";
        $viewPath    = "app/Views/editarTecnico.php";
        break;

    case 'delete':
        if (!$esAdmin) {
            $_SESSION['error_message'] = "No tienes permisos para eliminar técnicos.";
            header("Location: ?url=Tecnico&type=list");
            exit;
        }
        $id = (int)($_GET['id'] ?? 0);
        $object->delete($id);
        $_SESSION['success_message'] = "Técnico eliminado correctamente.";
        header("Location: ?url=Tecnico&type=list");
        exit;

    case 'detail':
        $id = (int)($_GET['id'] ?? 0);
        $tecnico = $object->getById($id);
        if (!$tecnico) {
            $_SESSION['error_message'] = "Técnico no encontrado.";
            header("Location: ?url=Tecnico&type=list");
            exit;
        }
        $telefonos = $object->getTelefonos($id);
        $insumosAsignados = $object->getInsumosAsignados($id);
        $insumosAReponer = $object->getInsumosAReponer($id);
        $pageTitle   = htmlspecialchars($tecnico['nomTecnico']) . " - Sistema de Laboratorios";
        $activeRoute = "tecnico";
        $viewPath    = "app/Views/detalleTecnico.php";
        break;

    case 'addTelefono':
        if (!$esAdmin) {
            $_SESSION['error_message'] = "No tienes permisos.";
            header("Location: ?url=Tecnico&type=list");
            exit;
        }
        $idTecnico = (int)($_GET['idTecnico'] ?? $_POST['idTecnico'] ?? 0);
        $telefono  = trim($_GET['telefono'] ?? $_POST['telefono'] ?? '');
        if ($idTecnico && $telefono) {
            $object->addTelefono($idTecnico, $telefono);
            $_SESSION['success_message'] = "Teléfono agregado correctamente.";
        } else {
            $_SESSION['error_message'] = "Datos inválidos para agregar teléfono.";
        }
        header("Location: ?url=Tecnico&type=detail&id=" . $idTecnico);
        exit;

    case 'deleteTelefono':
        if (!$esAdmin) {
            $_SESSION['error_message'] = "No tienes permisos.";
            header("Location: ?url=Tecnico&type=list");
            exit;
        }
        $idTelf    = (int)($_GET['idTelf'] ?? 0);
        $idTecnico = (int)($_GET['idTecnico'] ?? 0);
        if ($idTelf) {
            $object->deleteTelefono($idTelf);
            $_SESSION['success_message'] = "Teléfono eliminado correctamente.";
        }
        header("Location: ?url=Tecnico&type=detail&id=" . $idTecnico);
        exit;

    default:
        header("Location: index.php?url=Tecnico&type=list");
        exit;
}

include "app/Views/layouts/main.php";
