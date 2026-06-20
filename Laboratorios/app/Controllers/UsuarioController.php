<?php
namespace App\Laboratorios\Controllers;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || !isset($_SESSION['user_id'])) {
    header('Location: index.php?url=Login');
    exit;
}

use App\Laboratorios\Models\GestionUsuariosModel;

$model = new GestionUsuariosModel();

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

$type = $_GET['type'] ?? 'list';
$rolActual = $_SESSION['user_rol'] ?? '';
$esAdmin = ($rolActual === 'Administrador');

switch ($type) {

    case 'list':
        $mostrarInactivos = isset($_GET['inactivos']) && $_GET['inactivos'] === '1';
        $usuarios = $model->getAll(!$mostrarInactivos);
        $pageTitle  = $mostrarInactivos ? "Usuarios Inactivos" : "Gestión de Usuarios";
        $activeRoute = "usuario";
        $viewPath   = "app/Views/gestionUsuarios.php";
        break;

    case 'register':
        if (!$esAdmin) {
            $_SESSION['error_message'] = 'Acceso denegado: solo Administradores pueden registrar usuarios.';
            header('Location: index.php?url=Usuario');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'cedula'    => trim($_POST['cedula'] ?? ''),
                'nombre'    => trim($_POST['nombre'] ?? ''),
                'apellido'  => trim($_POST['apellido'] ?? ''),
                'correo'    => trim($_POST['correo'] ?? ''),
                'rol'       => $_POST['rol'] ?? '',
                'direccion' => trim($_POST['direccion'] ?? ''),
                'cargo'     => trim($_POST['cargo'] ?? ''),
                'idPersonalDireccion' => (int) ($_SESSION['user_id'] ?? 10),
            ];
            if ($data['rol'] === '' || $data['cedula'] === '' || $data['nombre'] === '') {
                $errorMessage = 'Los campos Rol, Cédula y Nombre son obligatorios.';
            } elseif ($model->getByCedula($data['cedula'], $data['rol'])) {
                $errorMessage = 'La cédula ingresada ya se encuentra registrada para este tipo de usuario.';
            } else {
                if ($model->create($data)) {
                    $_SESSION['success_message'] = 'Usuario creado exitosamente.';
                    header('Location: index.php?url=Usuario&type=list');
                    exit;
                }
                $errorMessage = 'Error al crear el usuario.';
            }
        }
        $pageTitle  = "Registrar Usuario";
        $activeRoute = "usuario";
        $viewPath   = "app/Views/crearUsuario.php";
        break;

    case 'edit':
        if (!$esAdmin) {
            $_SESSION['error_message'] = 'Acceso denegado: solo Administradores pueden editar usuarios.';
            header('Location: index.php?url=Usuario');
            exit;
        }
        $id  = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
        $rol = $_GET['rol'] ?? $_POST['rol'] ?? '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'cedula'    => trim($_POST['cedula'] ?? ''),
                'nombre'    => trim($_POST['nombre'] ?? ''),
                'apellido'  => trim($_POST['apellido'] ?? ''),
                'correo'    => trim($_POST['correo'] ?? ''),
                'direccion' => trim($_POST['direccion'] ?? ''),
                'cargo'     => trim($_POST['cargo'] ?? ''),
            ];
            if ($model->update($id, $rol, $data)) {
                $_SESSION['success_message'] = 'Usuario actualizado exitosamente.';
                header('Location: index.php?url=Usuario&type=list');
                exit;
            }
        }
        $usuario   = $model->getById($id, $rol);
        $pageTitle  = "Editar Usuario";
        $activeRoute = "usuario";
        $viewPath   = "app/Views/editarUsuario.php";
        break;

    case 'delete':
        if (!$esAdmin) {
            $_SESSION['error_message'] = 'Acceso denegado: solo Administradores pueden desactivar usuarios.';
            header('Location: index.php?url=Usuario');
            exit;
        }
        $id  = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
        $rol = $_GET['rol'] ?? $_POST['rol'] ?? '';
        if ($id <= 0 || $rol === '') {
            header('Location: index.php?url=Usuario&type=list');
            exit;
        }
        if ($model->softDelete($id, $rol)) {
            $_SESSION['success_message'] = 'Usuario desactivado exitosamente.';
        } else {
            $_SESSION['error_message'] = 'Error al desactivar el usuario.';
        }
        header('Location: index.php?url=Usuario&type=list');
        exit;

    case 'perfil':
        $_SESSION['user_ci']        = $_SESSION['user_cedula'] ?? '';
        $_SESSION['user_username']  = strtolower(str_replace(' ', '', $_SESSION['user_nombre'] ?? ''));
        $_SESSION['user_depto']     = $_SESSION['user_depto'] ?? 'Dpto. Académico';
        $_SESSION['user_telefono']  = $_SESSION['user_telefono'] ?? 'No registrado';

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
            $data = [
                'cedula'    => trim($_POST['cedula']    ?? $_SESSION['user_cedula']),
                'nombre'    => trim($_POST['nombre']    ?? $_SESSION['user_nombre']),
                'apellido'  => trim($_POST['apellido']  ?? ''),
                'correo'    => trim($_POST['correo']    ?? ''),
                'direccion' => trim($_POST['direccion'] ?? ''),
                'cargo'     => trim($_POST['cargo']     ?? ''),
            ];
            if ($model->update($_SESSION['user_id'], $_SESSION['user_rol'], $data)) {
                $_SESSION['user_nombre']  = $data['nombre'];
                $_SESSION['user_cedula']  = $data['cedula'];
                $_SESSION['user_correo']  = $data['correo'];
                $_SESSION['user_ci']      = $data['cedula'];
                $_SESSION['success_message'] = 'Datos actualizados correctamente.';
            } else {
                $_SESSION['success_message'] = 'Error al actualizar los datos.';
            }
            header('Location: index.php?url=Usuario&type=perfil');
            exit;
        }
        $pageTitle  = "Perfil de Usuario";
        $activeRoute = "perfil";
        $viewPath   = "app/Views/perfil.php";
        break;

    case 'permisos':
        if (!$esAdmin) {
            $_SESSION['error_message'] = 'Acceso denegado: solo Administradores pueden gestionar permisos.';
            header('Location: index.php?url=Usuario');
            exit;
        }
        $base = include 'app/config/permissions.php';
        $overridePath = 'app/config/permissions_override.json';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nuevosPermisos = [];
            $roles = ['Administrador', 'Tecnico', 'Docente'];
            foreach ($roles as $rol) {
                $nuevosPermisos[$rol] = $_POST['permisos'][$rol] ?? [];
            }
            if (file_put_contents($overridePath, json_encode($nuevosPermisos, JSON_PRETTY_PRINT))) {
                $successMessage = 'Permisos actualizados exitosamente.';
            } else {
                $errorMessage = 'Error al guardar los permisos.';
            }
        }

        $override = [];
        if (file_exists($overridePath)) {
            $override = json_decode(file_get_contents($overridePath), true) ?? [];
        }

        $todasLasRutas = [
            'home'        => 'Inicio',
            'perfil'      => 'Perfil de Usuario',
            'usuario'     => 'Gestión de Usuarios',
            'solicitud'   => 'Solicitudes',
            'laboratorio' => 'Laboratorios',
            'mantenimiento' => 'Mantenimiento',

            'insumo'      => 'Insumos / Inventario',
            'reporte'     => 'Reportes y Analíticas',
            'reserva'     => 'Gestión de Reservas',
        ];
        $roles = ['Administrador', 'Tecnico', 'Docente'];
        $pageTitle  = "Roles y Permisos";
        $activeRoute = "usuario";
        $viewPath   = "app/Views/permisosUsuarios.php";
        break;

    case 'logout':
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        header('Location: index.php?url=Login');
        exit;

    default:
        header('Location: index.php?url=Usuario&type=list');
        exit;
}

include "app/Views/layouts/main.php";
