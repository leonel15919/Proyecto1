<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 mb-1">Desactivar Usuario</h2>
        <p class="text-muted small mb-0">Confirmaci&oacute;n para desactivar un usuario del sistema</p>
    </div>
    <a href="index.php?url=Usuario&type=list" class="btn btn-outline-secondary d-flex align-items-center gap-2">
        <i class="bi bi-arrow-left"></i>
        <span>Volver a Usuarios</span>
    </a>
</div>

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
    <div class="card-body p-4 p-md-5 text-center">
        <i class="bi bi-person-x-fill text-danger" style="font-size: 4rem;"></i>
        <h4 class="fw-bold mt-3">¿Est&aacute; seguro?</h4>
        <p class="text-muted mb-1">Va a desactivar al siguiente usuario:</p>
        <p class="fw-bold fs-5 mb-0"><?= htmlspecialchars($usuario['nombre']) ?></p>
        <p class="text-muted small">
            C.I. <?= htmlspecialchars($usuario['cedula']) ?> &middot; <?= htmlspecialchars($usuario['rol']) ?>
        </p>
        <p class="text-muted small mt-3">
            <i class="bi bi-info-circle me-1"></i>
            El usuario ser&aacute; marcado como inactivo y no aparecer&aacute; en el listado.
            Puede volver a activarlo editando sus datos.
        </p>

        <div class="d-flex justify-content-center gap-3 mt-4 pt-3 border-top">
            <a href="index.php?url=Usuario&type=list" class="btn btn-light px-4 py-2 fw-semibold">Cancelar</a>
            <form action="index.php?url=Usuario&type=delete" method="POST">
                <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
                <input type="hidden" name="rol" value="<?= htmlspecialchars($usuario['rol']) ?>">
                <button type="submit" class="btn btn-danger px-5 py-2 fw-semibold shadow-sm">
                    <i class="bi bi-slash-circle me-2"></i> Confirmar Desactivaci&oacute;n
                </button>
            </form>
        </div>
    </div>
</div>
