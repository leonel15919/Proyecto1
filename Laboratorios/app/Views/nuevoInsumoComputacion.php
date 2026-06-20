<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 mb-1">Registrar Insumo de Cómputo</h2>
        <p class="text-muted small mb-0">Agregar equipos tecnológicos, periféricos, cables y accesorios al inventario</p>
    </div>
    <a href="index.php?url=Insumo" class="btn btn-outline-secondary d-flex align-items-center gap-2">
        <i class="bi bi-arrow-left"></i>
        <span>Volver a Inventario</span>
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4 p-md-5">
<?php if ($errorMessage): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-triangle me-2"></i> <?= htmlspecialchars($errorMessage) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

        <form action="index.php?url=Insumo&type=register_computacion" method="POST">
            <h5 class="fw-bold mb-4 text-primary border-bottom pb-2">Información del Equipo</h5>
            <div class="row g-4 mb-5">
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">Nombre del Equipo / Insumo <span class="text-danger">*</span></label>
                    <input type="text" name="nombre" class="form-control form-control-lg bg-light" placeholder="Ej. Teclado USB HP" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-secondary">Marca <span class="text-danger">*</span></label>
                    <input type="text" name="marca" class="form-control form-control-lg bg-light" placeholder="Ej. HP, Dell, Logitech" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-secondary">Modelo</label>
                    <input type="text" name="modelo" class="form-control form-control-lg bg-light" placeholder="Ej. SK-2025">
                </div>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">No. de Serie</label>
                    <input type="text" name="serial" class="form-control form-control-lg bg-light" placeholder="Ej. SN-ABC-12345">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Categoría</label>
                    <input type="text" class="form-control form-control-lg bg-light" value="Equipos de Cómputo e Insumos Tecnológicos" disabled>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Cantidad <span class="text-danger">*</span></label>
                    <input type="number" name="cantidad" class="form-control form-control-lg bg-light" placeholder="0" min="1" required>
                </div>
            </div>

            <h5 class="fw-bold mb-4 text-primary border-bottom pb-2">Stock</h5>
            <div class="row g-4 mb-5">
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">Unidad de Medida</label>
                    <input type="text" class="form-control form-control-lg bg-light" value="Unidades (Pzas)" disabled>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">Stock Mínimo para Alerta <span class="text-danger">*</span></label>
                    <input type="number" name="stockMinimo" class="form-control form-control-lg bg-light" placeholder="Ej. 2" min="1" required>
                    <div class="form-text small">Disparará una alerta visual si el inventario cae por debajo de este límite.</div>
                </div>
            </div>

            <h5 class="fw-bold mb-4 text-primary border-bottom pb-2">Almacenamiento y Vencimiento</h5>
            <div class="row g-4 mb-5">
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">Ubicación Física <span class="text-danger">*</span></label>
                    <input type="text" name="ubicacion" class="form-control form-control-lg bg-light" placeholder="Ej. Lab C-2, Estación 5" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">Fecha de Vencimiento (Si aplica)</label>
                    <input type="date" name="fechaVencimiento" class="form-control form-control-lg bg-light">
                    <div class="form-text small">Aplica para equipos con baterías, pilas o componentes perecederos.</div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                <a href="index.php?url=Insumo" class="btn btn-light px-4 py-2 fw-semibold">Cancelar</a>
                <button type="submit" class="btn btn-primary px-5 py-2 fw-semibold shadow-sm d-flex justify-content-center align-items-center">
                    <i class="bi bi-pc-display me-2"></i> Registrar Equipo
                </button>
            </div>
        </form>
    </div>
</div>