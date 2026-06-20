<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Sistema de Laboratorios</title>
    <link href="asset/css/bootstrap.min.css" rel="stylesheet">
    <link href="asset/css/bootstrap-icons.min.css" rel="stylesheet">
    <link href="asset/css/style.css" rel="stylesheet">
    <style>
        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #025abb 0%, #036ee3 100%);
            padding: 20px;
        }
        .login-card {
            max-width: 420px;
            width: 100%;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
            border: none;
            overflow: hidden;
            transition: transform 0.3s;
        }
        .login-card:hover {
            transform: translateY(-5px);
        }
        .login-logo {
            text-align: center;
            padding: 40px 30px 20px;
        }
        .login-logo img {
            width: 90px;
            height: auto;
            margin-bottom: 15px;
        }
        .form-control-lg {
            font-size: 1rem;
            border-radius: 10px;
        }
        .btn-login {
            background-color: #025abb;
            border: none;
            color: #fff;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            transition: background-color 0.2s;
        }
        .btn-login:hover {
            background-color: #01438d;
            color: #fff;
        }
        .input-group-text {
            border-radius: 10px 0 0 10px;
            background-color: #f8faff;
            color: #666;
            border-right: none;
        }
        .form-control {
            border-radius: 0 10px 10px 0;
            border-left: none;
        }
        .input-group:focus-within .input-group-text,
        .input-group:focus-within .form-control {
            border-color: #025abb;
            box-shadow: none;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card p-4">
            <div class="login-logo">
                <img src="asset/img/1.jpg" alt="Logo UPTAEB" class="img-fluid rounded-circle shadow-sm">
                <h4 class="fw-bold text-dark mt-3">Sistema de Laboratorios</h4>
                <p class="text-muted small">UPTAEB - Dirección de Formación</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger d-flex align-items-center gap-2 mx-3 mb-0 py-2 small" role="alert">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form action="index.php?route=login" method="POST" class="px-3 pb-4">
                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary">C&eacute;dula de Identidad</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                        <input type="text" name="cedula" class="form-control form-control-lg bg-light" placeholder="V-12345678" required autofocus>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary">ID de Personal</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                        <input type="number" name="id" class="form-control form-control-lg bg-light" placeholder="Ej: 10" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-login w-100 shadow-sm d-flex justify-content-center align-items-center gap-2">
                    <span>Ingresar al Sistema</span>
                    <i class="bi bi-arrow-right-short fs-5"></i>
                </button>
            </form>
        </div>
    </div>
    <script src="asset/js/bootstrap.bundle.min.js"></script>
</body>
</html>
