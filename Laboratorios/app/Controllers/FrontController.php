<?php

namespace App\Laboratorios\Controllers;

class FrontController {

    private $dir;
    private $controller;        
    private $url;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_REQUEST["url"])) {
            $this->url = $_REQUEST["url"];
            $this->dir = 'app/Controllers/'; 
            $this->controller = 'Controller.php';

            $this->getURL();
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            
            $this->url = 'Login';
            $this->dir = 'app/Controllers/';
            $this->controller = 'Controller.php';
            $this->getURL();
        } else {
            
            $fallback = isset($_SESSION['logged_in']) ? 'Home' : 'Login';
            header("Location: ?url=" . $fallback);
            exit;
        }
    }

    private function getURL() {
        $file = $this->dir . $this->url . $this->controller;
        
        if(file_exists($file)) {
            require_once($file);
        } else {
            
            echo "<script>alert('Error 404: El controlador no existe'); location='?url=Login';</script>";
        }
    }
}
