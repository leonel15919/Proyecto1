<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 mb-1">Registrar Nuevo Usuario</h2>
        <p class="text-muted small mb-0">Ingrese los datos del nuevo docente, técnico o administrador</p>
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
        <form action="index.php?url=Usuario&type=register" method="POST">
            <h5 class="fw-bold mb-4 text-primary border-bottom pb-2">Datos del Usuario</h5>
            <div class="row g-4 mb-5">
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Rol <span class="text-danger">*</span></label>
                    <select name="rol" class="form-select form-select-lg bg-light" required>
                        <option value="">Seleccione...</option>
                        <option value="Docente">Coordinador</option>
                        <option value="Administrador">Administrador</option>
                    </select>
                    <div class="form-text small">Seleccione el tipo de usuario a registrar.</div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">C&eacute;dula <span class="text-danger">*</span></label>
                    <input type="text" name="cedula" class="form-control form-control-lg bg-light" placeholder="V-12345678" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Nombre(s) <span class="text-danger">*</span></label>
                    <input type="text" name="nombre" class="form-control form-control-lg bg-light" placeholder="Nombre(s)" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">Apellido(s)</label>
                    <input type="text" name="apellido" class="form-control form-control-lg bg-light" placeholder="Apellido(s)">
                    <div class="form-text small">Obligatorio para Docente. Dejar vac&iacute;o para otros roles.</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">Correo Institucional</label>
                    <input type="email" name="correo" class="form-control form-control-lg bg-light" placeholder="correo@uptaeb.edu.ve">
                    <div class="form-text small">Obligatorio para Docente. Dejar vac&iacute;o para otros roles.</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">Direcci&oacute;n / Departamento</label>
                    <input type="text" name="direccion" class="form-control form-control-lg bg-light" placeholder="Ej. Laboratorio de Inform&aacute;tica">
                    <div class="form-text small">Solo para Técnico (dirección del técnico).</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">Cargo</label>
                    <input type="text" name="cargo" class="form-control form-control-lg bg-light" placeholder="Ej. Director de Formaci&oacute;n">
                    <div class="form-text small">Solo para Administrador (cargo en Direcci&oacute;n).</div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                <a href="index.php?url=Usuario&type=list" class="btn btn-light px-4 py-2 fw-semibold">Cancelar</a>
                <button type="submit" class="btn btn-primary px-5 py-2 fw-semibold shadow-sm">
                    <i class="bi bi-save me-2"></i> Guardar Usuario
                </button>
            </div>
        </form>
    </div>
</div>
