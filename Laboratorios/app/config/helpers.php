<?php






function getPermisos($rol = null) {
    if ($rol === null) {
        $rol = $_SESSION['user_rol'] ?? '';
    }

    if (empty($rol)) {
        return [];
    }

    
    
    $basePath = __DIR__ . '/permissions.php';
    $base = file_exists($basePath) ? include $basePath : [];
    
    $permisos = is_array($base) ? $base : [];
    $overridePath = __DIR__ . '/permissions_override.json';
    
    if (file_exists($overridePath)) {
        $json = file_get_contents($overridePath);
        $override = json_decode($json, true);
        if (is_array($override)) {
            foreach ($override as $roleName => $routes) {
                if (is_array($routes)) {
                    $permisos[$roleName] = $routes;
                }
            }
        }
    }
    return $permisos[$rol] ?? [];
}







function rutaPermitida($ruta) {
    return in_array($ruta, getPermisos());
}