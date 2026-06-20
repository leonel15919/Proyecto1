<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 mb-1">Editar Usuario</h2>
        <p class="text-muted small mb-0">Modifique los datos del usuario seleccionado</p>
    </div>
    <a href="index.php?url=Usuario&type=list" class="btn btn-outline-secondary d-flex align-items-center gap-2">
        <i class="bi bi-arrow-left"></i>
        <span>Volver a Usuarios</span>
    </a>
</div>

<?php if (!empty($successMessage)): ?>
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm d-flex align-items-center gap-3 mb-4" role="alert">
        <i class="bi bi-check-circle-fill text-success fs-4"></i>
        <div>
            <strong class="d-block text-success-emphasis">Operaci&oacute;n Exitosa</strong>
            <span class="small text-muted"><?php echo htmlspecialchars($successMessage); ?></span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (!empty($errorMessage)): ?>
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm d-flex align-items-center gap-3 mb-4" role="alert">
        <i class="bi bi-exclamation-triangle-fill text-danger fs-4"></i>
        <div>
            <strong class="d-block text-danger-emphasis">Error</strong>
            <span class="small text-muted"><?php echo htmlspecialchars($errorMessage); ?></span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4 p-md-5">
        <form action="index.php?url=Usuario&type=edit" method="POST">
            <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
            <input type="hidden" name="rol" value="<?= htmlspecialchars($usuario['rol']) ?>">

            <h5 class="fw-bold mb-4 text-primary border-bottom pb-2">
                <i class="bi bi-pencil-square me-2"></i>
                Editando: <?= htmlspecialchars($usuario['rol']) ?>
            </h5>

            <div class="row g-4 mb-5">
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">C&eacute;dula <span class="text-danger">*</span></label>
                    <input type="text" name="cedula" class="form-control form-control-lg bg-light" value="<?= htmlspecialchars($usuario['cedula']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">Nombre <span class="text-danger">*</span></label>
                    <input type="text" name="nombre" class="form-control form-control-lg bg-light" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>
                </div>

                <?php if ($usuario['rol'] === 'Docente'): ?>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">Apellido</label>
                    <input type="text" name="apellido" class="form-control form-control-lg bg-light" value="<?= htmlspecialchars($usuario['apellido'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">Correo Institucional</label>
                    <input type="email" name="correo" class="form-control form-control-lg bg-light" value="<?= htmlspecialchars($usuario['correo'] ?? '') ?>">
                </div>
                <?php elseif ($usuario['rol'] === 'Tecnico'): ?>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">Direcci&oacute;n / Departamento</label>
                    <input type="text" name="direccion" class="form-control form-control-lg bg-light" value="<?= htmlspecialchars($usuario['direccion'] ?? '') ?>">
                </div>
                <?php elseif ($usuario['rol'] === 'Administrador'): ?>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">Cargo</label>
                    <input type="text" name="cargo" class="form-control form-control-lg bg-light" value="<?= htmlspecialchars($usuario['cargo'] ?? '') ?>">
                </div>
                <?php endif; ?>
            </div>

            <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                <a href="index.php?url=Usuario&type=list" class="btn btn-light px-4 py-2 fw-semibold">Cancelar</a>
                <button type="submit" class="btn btn-warning px-5 py-2 fw-semibold shadow-sm">
                    <i class="bi bi-save me-2"></i> Actualizar Usuario
                </button>
            </div>
        </form>
    </div>
</div>
