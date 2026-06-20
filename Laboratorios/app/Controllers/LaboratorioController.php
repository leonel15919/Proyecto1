<?php
namespace App\Laboratorios\Controllers;

use App\Laboratorios\Models\LaboratoriosModel;

$object = new LaboratoriosModel();

$successMessage = $_SESSION['success_message'] ?? '';
$errorMessage   = $_SESSION['error_message'] ?? '';
unset($_SESSION['success_message'], $_SESSION['error_message']);

if (!isset($_GET['type'])) {
    header("Location: index.php?url=Laboratorio&type=list");
    exit;
}

$type = $_GET['type'];

if ($type === 'list') {
    $laboratorios = $object->getAll();
    $resumen      = $object->getResumen();
    $pageTitle    = "Laboratorios - Sistema de Laboratorios";
    $activeRoute  = "laboratorio";
    $viewPath     = "app/Views/laboratorios.php";
    include "app/Views/layouts/main.php";

} elseif ($type === 'register') {
    if ($_SESSION['user_rol'] !== 'Administrador') {
        $_SESSION['error_message'] = "No tienes permisos para crear laboratorios.";
        header("Location: ?url=Laboratorio&type=list");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $object->create($_POST);
        $_SESSION['success_message'] = "Laboratorio creado correctamente.";
        header("Location: ?url=Laboratorio&type=list");
        exit;
    }

    $pageTitle   = "Nuevo Laboratorio - Sistema de Laboratorios";
    $activeRoute = "laboratorio";
    $viewPath    = "app/Views/crearLaboratorio.php";
    include "app/Views/layouts/main.php";

} elseif ($type === 'edit') {
    if ($_SESSION['user_rol'] !== 'Administrador') {
        $_SESSION['error_message'] = "No tienes permisos para editar laboratorios.";
        header("Location: ?url=Laboratorio&type=list");
        exit;
    }

    $id = $_GET['id'] ?? 0;
    $laboratorio = $object->getById($id);
    if (!$laboratorio) {
        $_SESSION['error_message'] = "Laboratorio no encontrado.";
        header("Location: ?url=Laboratorio&type=list");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $object->update($id, $_POST);
        $_SESSION['success_message'] = "Laboratorio actualizado correctamente.";
        header("Location: ?url=Laboratorio&type=list");
        exit;
    }

    $pageTitle   = "Editar Laboratorio - Sistema de Laboratorios";
    $activeRoute = "laboratorio";
    $viewPath    = "app/Views/editarLaboratorio.php";
    include "app/Views/layouts/main.php";

} elseif ($type === 'delete') {
    if ($_SESSION['user_rol'] !== 'Administrador') {
        $_SESSION['error_message'] = "No tienes permisos para eliminar laboratorios.";
        header("Location: ?url=Laboratorio&type=list");
        exit;
    }

    $id = $_GET['id'] ?? 0;
    $object->delete($id);
    $_SESSION['success_message'] = "Laboratorio eliminado correctamente.";
    header("Location: ?url=Laboratorio&type=list");
    exit;

} elseif ($type === 'estado') {
    if ($_SESSION['user_rol'] !== 'Administrador') {
        $_SESSION['error_message'] = "No tienes permisos para cambiar el estado.";
        header("Location: ?url=Laboratorio&type=list");
        exit;
    }

    $id     = $_GET['id'] ?? 0;
    $estado = $_GET['estado'] ?? '';
    $validos = ['disponible', 'en_uso', 'mantenimiento'];
    if (!in_array($estado, $validos)) {
        $_SESSION['error_message'] = "Estado no válido.";
        header("Location: ?url=Laboratorio&type=list");
        exit;
    }

    $object->updateEstado($id, $estado);
    $_SESSION['success_message'] = "Estado del laboratorio actualizado a «" . ucfirst(str_replace('_', ' ', $estado)) . "».";
    header("Location: ?url=Laboratorio&type=list");
    exit;

} elseif ($type === 'detail') {
    $id = $_GET['id'] ?? 0;
    $laboratorio = $object->getById($id);
    if (!$laboratorio) {
        $_SESSION['error_message'] = "Laboratorio no encontrado.";
        header("Location: ?url=Laboratorio&type=list");
        exit;
    }

    $reservas = $object->getReservasByLaboratorio($id);

    $pageTitle   = htmlspecialchars($laboratorio['nomLaboratorio']) . " - Sistema de Laboratorios";
    $activeRoute = "laboratorio";
    $viewPath    = "app/Views/detalleLaboratorio.php";
    include "app/Views/layouts/main.php";

} elseif ($type === 'horarios') {
    $hoy = new \DateTime();
    $semanaParam = $_GET['semana'] ?? '';
    if ($semanaParam && preg_match('/^\d{4}-\d{2}-\d{2}$/', $semanaParam)) {
        $lunes = new \DateTime($semanaParam);
    } else {
        $lunes = new \DateTime($hoy->format('Y-m-d'));
        $diaSemana = (int) $lunes->format('N');
        if ($diaSemana !== 1) {
            $lunes->modify('last monday');
        }
    }

    $lunesStr = $lunes->format('Y-m-d');
    $domingo  = (clone $lunes)->modify('+6 days');
    $domingoStr = $domingo->format('Y-m-d');

    $reservas      = $object->getCronogramaSemana($lunesStr);
    $laboratorios  = $object->getAll();

    $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
    $fechasSemana = [];
    for ($i = 0; $i < 7; $i++) {
        $fechasSemana[$diasSemana[$i]] = (clone $lunes)->modify("+$i days")->format('Y-m-d');
    }

    $semanaAnterior = (clone $lunes)->modify('-7 days')->format('Y-m-d');
    $semanaSiguiente = (clone $lunes)->modify('+7 days')->format('Y-m-d');

    $pageTitle   = "Cronograma Semanal - Sistema de Laboratorios";
    $activeRoute = "horarios";
    $viewPath    = "app/Views/horarios.php";
    include "app/Views/layouts/main.php";

} else {
    header("Location: index.php?url=Laboratorio&type=list");
}
