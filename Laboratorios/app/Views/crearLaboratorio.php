<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 mb-0">Nuevo Laboratorio</h2>
        <p class="text-muted small">Registrar un nuevo espacio de laboratorio</p>
    </div>
    <a href="index.php?url=Laboratorio&type=list" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Volver
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="index.php?url=Laboratorio&type=register">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">Nombre del Laboratorio</label>
                    <input type="text" name="nomLaboratorio" class="form-control" required placeholder="Ej: Laboratorio A">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">Tipo</label>
                    <select name="tipoLaboratorio" class="form-select" required>
                        <option value="computacion">Computación</option>
                        <option value="fisica">Física</option>
                        <option value="quimica">Química</option>
                        <option value="biologia">Biología</option>
                        <option value="multiproposito">Multipropósito</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Capacidad (personas)</label>
                    <input type="number" name="capacidadLaboratorio" class="form-control" required min="1" placeholder="Ej: 30">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Ubicación</label>
                    <input type="text" name="ubicacionLaboratorio" class="form-control" required placeholder="Ej: Edificio A, Piso 2">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Estado Inicial</label>
                    <select name="estadoLaboratorio" class="form-select">
                        <option value="disponible">Disponible</option>
                        <option value="en_uso">En Uso</option>
                        <option value="mantenimiento">Mantenimiento</option>
                    </select>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Guardar Laboratorio</button>
                <a href="index.php?url=Laboratorio&type=list" class="btn btn-outline-secondary ms-2">Cancelar</a>
            </div>
        </form>
    </div>
</div>
