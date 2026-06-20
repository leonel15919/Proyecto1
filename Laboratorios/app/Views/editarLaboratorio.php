<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 mb-0">Editar Laboratorio</h2>
        <p class="text-muted small">Modificar los datos del laboratorio</p>
    </div>
    <a href="index.php?url=Laboratorio&type=list" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Volver
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="index.php?url=Laboratorio&type=edit&id=<?= $laboratorio['idLaboratorio'] ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">Nombre del Laboratorio</label>
                    <input type="text" name="nomLaboratorio" class="form-control" required
                           value="<?= htmlspecialchars($laboratorio['nomLaboratorio']) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">Tipo</label>
                    <select name="tipoLaboratorio" class="form-select" required>
                        <?php $tipos = ['computacion' => 'Computación', 'fisica' => 'Física', 'quimica' => 'Química', 'biologia' => 'Biología', 'multiproposito' => 'Multipropósito']; ?>
                        <?php foreach ($tipos as $val => $label): ?>
                        <option value="<?= $val ?>" <?= ($laboratorio['tipoLaboratorio'] ?? '') === $val ? 'selected' : '' ?>><?= $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Capacidad (personas)</label>
                    <input type="number" name="capacidadLaboratorio" class="form-control" required min="1"
                           value="<?= htmlspecialchars($laboratorio['capacidadLaboratorio']) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Ubicación</label>
                    <input type="text" name="ubicacionLaboratorio" class="form-control" required
                           value="<?= htmlspecialchars($laboratorio['ubicacionLaboratorio']) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Estado</label>
                    <select name="estadoLaboratorio" class="form-select">
                        <?php $estados = ['disponible' => 'Disponible', 'en_uso' => 'En Uso', 'mantenimiento' => 'Mantenimiento']; ?>
                        <?php foreach ($estados as $val => $label): ?>
                        <option value="<?= $val ?>" <?= ($laboratorio['estadoLaboratorio'] ?? '') === $val ? 'selected' : '' ?>><?= $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Actualizar Laboratorio</button>
                <a href="index.php?url=Laboratorio&type=list" class="btn btn-outline-secondary ms-2">Cancelar</a>
            </div>
        </form>
    </div>
</div>
