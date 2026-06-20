<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 mb-1">Registrar Nuevo Insumo</h2>
        <p class="text-muted small mb-0">Carga de nuevos materiales, reactivos y equipos al inventario general</p>
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

        <form action="index.php?url=Insumo&type=register" method="POST">
            <h5 class="fw-bold mb-4 text-primary border-bottom pb-2">Información Básica</h5>
            <div class="row g-4 mb-5">
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">Nombre del Material o Reactivo <span class="text-danger">*</span></label>
                    <input type="text" name="nombre" class="form-control form-control-lg bg-light" placeholder="Ej. Ácido Sulfúrico (98%)" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-secondary">Categoría / Clasificación <span class="text-danger">*</span></label>
                    <select name="categoria" class="form-select form-select-lg bg-light" required>
                        <option selected disabled>Seleccione...</option>
                        <option>Reactivos Químicos</option>
                        <option>Material de Vidrio (Vidriería)</option>
                        <option>Material Biológico</option>
                        <option>Equipos e Instrumentos</option>
                        <option>Insumos Desechables (Guantes/Mascarillas)</option>

                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-secondary">Código del Lote / Catálogo</label>
                    <input type="text" name="codigoLote" class="form-control form-control-lg bg-light" placeholder="Ej. LOT-982-Q">
                </div>
            </div>
            
            <h5 class="fw-bold mb-4 text-primary border-bottom pb-2">Medición y Stock Inicial</h5>
            <div class="row g-4 mb-5">
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Cantidad Inicial <span class="text-danger">*</span></label>
                    <input type="number" name="cantidadInicial" class="form-control form-control-lg bg-light" placeholder="0" min="1" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Unidad de Medida <span class="text-danger">*</span></label>
                    <select name="unidadMedida" class="form-select form-select-lg bg-light" required>
                        <option selected disabled>Seleccione...</option>
                        <option>Unidades (Pzas)</option>
                        <option>Mililitros (ml)</option>
                        <option>Litros (L)</option>
                        <option>Gramos (g)</option>
                        <option>Kilogramos (kg)</option>
                        <option>Cajas / Paquetes</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Stock Mínimo Alerta <span class="text-danger">*</span></label>
                    <input type="number" name="stockMinimo" class="form-control form-control-lg bg-light" placeholder="Ej. 10" min="1" required>
                    <div class="form-text small">Disparará una alerta visual si el inventario cae por debajo de este límite.</div>
                </div>
            </div>

            <h5 class="fw-bold mb-4 text-primary border-bottom pb-2">Almacenamiento y Vencimiento</h5>
            <div class="row g-4 mb-5">
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">Ubicación Física (Estantería/Vitrina) <span class="text-danger">*</span></label>
                    <input type="text" name="ubicacion" class="form-control form-control-lg bg-light" placeholder="Ej. Estante B, Fila 3, Lab A-01" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">Fecha de Vencimiento (Si aplica)</label>
                    <input type="date" name="fechaVencimiento" class="form-control form-control-lg bg-light">
                    <div class="form-text small">Indispensable para reactivos químicos y material biológico perecedero.</div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                <a href="index.php?url=Insumo" class="btn btn-light px-4 py-2 fw-semibold">Cancelar</a>
                <button type="submit" class="btn btn-primary px-5 py-2 fw-semibold shadow-sm d-flex justify-content-center align-items-center"><i class="bi bi-box-seam me-2"></i> Registrar e Ingresar a Stock</button>
            </div>
        </form>
    </div>
</div>
