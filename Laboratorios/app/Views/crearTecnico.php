<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 mb-0">Nuevo Técnico</h2>
        <p class="text-muted small">Registrar un nuevo técnico de laboratorio</p>
    </div>
    <a href="index.php?url=Tecnico&type=list" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Volver
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="index.php?url=Tecnico&type=register" id="formTecnico">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">Cédula</label>
                    <input type="text" name="cedulaTecnico" class="form-control" required placeholder="Ej: V-12345678">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">Nombre Completo</label>
                    <input type="text" name="nomTecnico" class="form-control" required placeholder="Ej: Carlos Mendoza">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">Dirección / Ubicación</label>
                    <input type="text" name="direccionTecnico" class="form-control" placeholder="Ej: Lab de Informática">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">Especialidad</label>
                    <select name="idEspecialidad" class="form-select" required>
                        <option value="">Seleccione una especialidad...</option>
                        <?php foreach ($especialidades as $e): ?>
                        <option value="<?= $e['idEspecialidad'] ?>"><?= htmlspecialchars($e['nombreEspecialidad']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">Teléfono</label>
                    <input type="text" name="telefono" class="form-control" placeholder="Ej: 0412-1234567">
                </div>
            </div>
    </div>
</div>

<div class="card border-0 shadow-sm mt-4">
    <div class="card-header bg-white py-3 border-0">
        <h5 class="fw-bold mb-0">Insumos Asignados</h5>
    </div>
    <div class="card-body">
        <?php if (empty($insumos)): ?>
        <p class="text-muted mb-0">No hay insumos disponibles.</p>
        <?php else: ?>
        <div class="row g-2">
            <?php foreach ($insumos as $ins): ?>
            <div class="col-md-4 col-lg-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="insumos[]"
                           value="<?= $ins['idInsumos'] ?>" id="ins_<?= $ins['idInsumos'] ?>">
                    <label class="form-check-label" for="ins_<?= $ins['idInsumos'] ?>">
                        <?= htmlspecialchars($ins['nomInsumos']) ?>
                        <small class="text-muted d-block">Stock: <?= htmlspecialchars($ins['cantidadDispInsumos'] ?? '0') ?> <?= htmlspecialchars($ins['unidadMedidaInsumos'] ?? 'unid') ?></small>
                    </label>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Guardar Técnico</button>
    <a href="index.php?url=Tecnico&type=list" class="btn btn-outline-secondary ms-2">Cancelar</a>
</div>

</form>
