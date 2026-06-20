<?php
namespace App\Laboratorios\Controllers;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use App\Laboratorios\Models\LoginModel;

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cedula = trim($_POST['cedula'] ?? '');
    $id = trim($_POST['id'] ?? '');
    
    error_log("Intento de inicio de sesión: Cédula = '{$cedula}', ID = '{$id}'");


    if ($cedula === '' || $id === '') {
        $error = 'Por favor ingrese su cédula e ID de personal.';
    } else {
        $model = new LoginModel();
        $user = $model->login($cedula, $id);
        if ($user) {
    
            error_log("Inicio de sesión exitoso para el usuario: " . print_r($user, true));


            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nombre'] = $user['nombre_completo'];
            $_SESSION['user_cedula'] = $user['cedula'];
            $_SESSION['user_rol'] = $user['rol'];
            header('Location: index.php?url=Home');
            exit;
        } else {

            error_log("Inicio de sesión fallido para Cédula = '{$cedula}', ID = '{$id}'");


            $error = 'Cédula y/o ID de personal no coinciden con nuestros registros.';
        }
    }
}

include 'app/Views/login.php';
