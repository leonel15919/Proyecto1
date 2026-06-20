<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 mb-1">Gesti&oacute;n de Usuarios</h2>
        <p class="text-muted small mb-0">Administración de docentes, técnicos y roles de la plataforma</p>
    </div>
    <a href="index.php?url=Usuario&type=register" class="btn btn-primary d-flex align-items-center gap-2">
        <i class="bi bi-plus-lg"></i>
        <span>Registrar Nuevo Usuario</span>
    </a>
</div>

<?php if (!empty($successMessage)): ?>
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm d-flex align-items-center gap-3 mb-4" role="alert" style="border-left: 5px solid #198754 !important; border-radius: 8px;">
        <i class="bi bi-check-circle-fill text-success fs-4"></i>
        <div>
            <strong class="d-block text-success-emphasis">Operaci&oacute;n Exitosa</strong>
            <span class="small text-muted"><?php echo htmlspecialchars($successMessage); ?></span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
        <h5 class="card-title fw-bold mb-0">
            <?php if (isset($_GET['inactivos']) && $_GET['inactivos'] === '1'): ?>
                Usuarios Inactivos
                <a href="index.php?url=Usuario&type=list" class="badge bg-secondary bg-opacity-10 text-secondary text-decoration-none ms-2 small fw-normal">
                    <i class="bi bi-people me-1"></i>Ver activos
                </a>
            <?php else: ?>
                Listado de Usuarios Registrados
                <a href="index.php?url=Usuario&type=list&inactivos=1" class="badge bg-secondary bg-opacity-10 text-secondary text-decoration-none ms-2 small fw-normal">
                    <i class="bi bi-person-slash me-1"></i>Ver inactivos
                </a>
            <?php endif; ?>
        </h5>
        <form action="index.php?url=Usuario&type=list" method="GET" class="d-flex gap-2" style="max-width: 300px;">
            <input type="hidden" name="url" value="Usuario">
            <input type="hidden" name="type" value="list">
            <div class="input-group">
                <span class="input-group-text bg-light border-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" name="q" class="form-control bg-light border-0 small" placeholder="Buscar usuario..." value="<?php echo htmlspecialchars($_GET['q'] ?? ''); ?>">
            </div>
        </form>
    </div>
    <div class="table-responsive px-3 pb-3">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nombre Completo</th>
                    <th>Usuario / Correo</th>
                    <th>Rol / Departamento</th>
                    <th>C&eacute;dula</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($usuarios) && is_array($usuarios)): ?>
                    <?php foreach ($usuarios as $user): 
                        $palabras = explode(' ', $user['nombre_completo']);
                        $iniciales = strtoupper(substr($palabras[0], 0, 1) . (isset($palabras[1]) ? substr($palabras[1], 0, 1) : ''));
                        
                        $avatarColor = 'bg-primary text-primary';
                        $rolIcon = 'bi-journal-bookmark text-primary';
                        
                        if ($user['rol'] === 'Tecnico') {
                            $avatarColor = 'bg-success text-success';
                            $rolIcon = 'bi-tools text-success';
                        } elseif ($user['rol'] === 'Administrador') {
                            $avatarColor = 'bg-warning text-warning';
                            $rolIcon = 'bi-shield-check text-warning';
                        }
                    ?>
                        <?php $esInactivo = isset($_GET['inactivos']) && $_GET['inactivos'] === '1'; ?>
                        <tr class="<?= $esInactivo ? 'opacity-50' : '' ?>">
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="<?= $avatarColor ?> bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center fw-bold me-3" style="width: 40px; height: 40px;">
                                        <?= $iniciales ?>
                                    </div>
                                    <div>
                                        <span class="d-block fw-semibold text-dark"><?= htmlspecialchars($user['nombre_completo']) ?></span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="d-block text-dark fw-medium"><?= htmlspecialchars($user['usuario']) ?></span>
                                <span class="text-muted small"><?= htmlspecialchars($user['correo']) ?></span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border me-1">
                                    <i class="bi <?= $rolIcon ?> me-1"></i><?= htmlspecialchars($user['rol']) ?>
                                </span>
                                <span class="d-block text-muted small mt-1"><?= htmlspecialchars($user['departamento']) ?></span>
                            </td>
                            <td>
                                <span class="text-muted small"><?= htmlspecialchars($user['cedula']) ?></span>
                            </td>
                            <td class="text-end">
                                <a href="index.php?url=Usuario&type=edit&id=<?= $user['id'] ?>&rol=<?= $user['rol'] ?>" class="btn btn-sm btn-outline-primary" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <?php if (!$esInactivo): ?>
                                <a href="index.php?url=Usuario&type=delete&id=<?= $user['id'] ?>&rol=<?= $user['rol'] ?>" class="btn btn-sm btn-outline-danger" title="Desactivar" onclick="return confirm('¿Desactivar a <?= htmlspecialchars($user['nombre_completo'], ENT_QUOTES) ?>? Se marcará como inactivo y no aparecerá en el listado.');">
                                    <i class="bi bi-slash-circle"></i>
                                </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            <i class="bi bi-people me-2"></i> No hay personal registrado en la base de datos.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
