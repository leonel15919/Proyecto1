<?php
namespace App\Laboratorios\Controllers;

use App\Laboratorios\Models\ReservasModel;
use App\Laboratorios\Models\LaboratoriosModel;
use App\Laboratorios\Models\SolicitudesModel;

$object   = new ReservasModel();
$labModel = new LaboratoriosModel();

$successMessage = $_SESSION['success_message'] ?? '';
$errorMessage   = $_SESSION['error_message'] ?? '';
unset($_SESSION['success_message'], $_SESSION['error_message']);

if (!isset($_GET['type'])) {
    header("Location: index.php?url=Reserva&type=list");
    exit;
}

$type = $_GET['type'];

if ($type === 'list') {
    $filtroEstado = $_GET['estado'] ?? 'todos';
    $reservas  = $object->getAll($filtroEstado);
    $pageTitle = "Reservas - Sistema de Laboratorios";
    $activeRoute = "reserva";
    $viewPath  = "app/Views/reservas.php";
    include "app/Views/layouts/main.php";

} elseif ($type === 'semanal') {
    $filtroEstado = $_GET['estado'] ?? 'todos';
    $fechaInicio  = $_GET['fecha'] ?? date('Y-m-d', strtotime('monday this week'));
    $reservas     = $object->getSemanal($fechaInicio, $filtroEstado);
    $pageTitle    = "Cronograma Semanal - Sistema de Laboratorios";
    $activeRoute  = "cronograma";
    $viewPath     = "app/Views/cronograma.php"; 
    include "app/Views/layouts/main.php";

} elseif ($type === 'register') {
    if ($_SESSION['user_rol'] !== 'Administrador') {
        $_SESSION['error_message'] = "No tienes permisos para crear reservas.";
        header("Location: ?url=Reserva&type=list");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!empty($_POST['horaInicioReserva']) && !empty($_POST['horaFinReserva']) && $_POST['horaFinReserva'] <= $_POST['horaInicioReserva']) {
            $_SESSION['error_message'] = "La hora fin debe ser mayor que la hora de inicio.";
            header("Location: index.php?url=Reserva&type=register");
            exit;
        }
        if (empty($_POST['nombreReserva']) && !empty($_POST['idSolicitudPractica'])) {
            $sol = (new SolicitudesModel())->getById((int)$_POST['idSolicitudPractica']);
            if ($sol && preg_match('/Asignatura:\s*([^|]+)/', $sol['observacionSolicitudPractica'] ?? '', $m)) {
                $_POST['nombreReserva'] = trim($m[1]);
            }
        }
        $object->create($_POST);
        $_SESSION['success_message'] = "Reserva creada correctamente.";
        header("Location: index.php?url=Reserva&type=list");
        exit;
    }

    $laboratorios = $labModel->getAll();
    $solicitudes  = (new SolicitudesModel())->getDisponibles();
    $pageTitle    = "Nueva Reserva - Sistema de Laboratorios";
    $activeRoute  = "reserva";
    $viewPath     = "app/Views/crearReserva.php";
    include "app/Views/layouts/main.php";

} elseif ($type === 'edit') {
    if ($_SESSION['user_rol'] !== 'Administrador') {
        $_SESSION['error_message'] = "No tienes permisos para editar reservas.";
        header("Location: ?url=Reserva&type=list");
        exit;
    }

    $id = $_GET['id'] ?? 0;
    $reserva = $object->getById($id);
    if (!$reserva) {
        $_SESSION['error_message'] = "Reserva no encontrada.";
        header("Location: ?url=Reserva&type=list");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!empty($_POST['horaInicioReserva']) && !empty($_POST['horaFinReserva']) && $_POST['horaFinReserva'] <= $_POST['horaInicioReserva']) {
            $_SESSION['error_message'] = "La hora fin debe ser mayor que la hora de inicio.";
            header("Location: index.php?url=Reserva&type=edit&id=" . (int)$id);
            exit;
        }
        if (empty($_POST['nombreReserva']) && !empty($_POST['idSolicitudPractica'])) {
            $sol = (new SolicitudesModel())->getById((int)$_POST['idSolicitudPractica']);
            if ($sol && preg_match('/Asignatura:\s*([^|]+)/', $sol['observacionSolicitudPractica'] ?? '', $m)) {
                $_POST['nombreReserva'] = trim($m[1]);
            }
        }
        $object->update($id, $_POST);
        $_SESSION['success_message'] = "Reserva actualizada correctamente.";
        header("Location: index.php?url=Reserva&type=list");
        exit;
    }

    $laboratorios = $labModel->getAll();
    $solicitudes  = (new SolicitudesModel())->getDisponibles();
    $pageTitle    = "Editar Reserva - Sistema de Laboratorios";
    $activeRoute  = "reserva";
    $viewPath     = "app/Views/editarReserva.php";
    include "app/Views/layouts/main.php";

} elseif ($type === 'delete') {
    if ($_SESSION['user_rol'] !== 'Administrador') {
        $_SESSION['error_message'] = "No tienes permisos para eliminar reservas.";
        header("Location: ?url=Reserva&type=list");
        exit;
    }

    $id = $_GET['id'] ?? 0;
    $object->delete($id);
    $_SESSION['success_message'] = "Reserva eliminada correctamente.";
    header("Location: ?url=Reserva&type=list");
    exit;

} else {
    header("Location: index.php?url=Reserva&type=list");
}
