<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">Generador de Reportes Especializados</h2>
    <a href="index.php?url=Reporte&type=main" class="btn btn-outline-secondary d-flex align-items-center gap-2">
        <i class="bi bi-arrow-left"></i>
        <span>Volver a Estadísticas</span>
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-5">
                <form action="index.php?url=Reporte&type=generate" method="POST">
                    <h5 class="fw-bold mb-4 text-primary border-bottom pb-2">Seleccione Criterios</h5>

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary">Tipo de Reporte <span class="text-danger">*</span></label>
                        <select name="tipo" class="form-select form-select-lg bg-light" required>
                            <option value="" <?= $tipoSeleccionado === '' ? 'selected' : '' ?> disabled>Seleccione...</option>
                            <option value="ocupacion" <?= $tipoSeleccionado === 'ocupacion' ? 'selected' : '' ?>>Ocupación General de Espacios</option>
                            <option value="insumos" <?= $tipoSeleccionado === 'insumos' ? 'selected' : '' ?>>Reporte de Entradas/Salidas de Insumos</option>
                            <option value="docente" <?= $tipoSeleccionado === 'docente' ? 'selected' : '' ?>>Historial de Prácticas por Docente</option>
                            <option value="mantenimiento" <?= $tipoSeleccionado === 'mantenimiento' ? 'selected' : '' ?>>Reporte Técnico de Mantenimiento</option>
                            <option value="conflictos" <?= $tipoSeleccionado === 'conflictos' ? 'selected' : '' ?>>Reporte de Horarios en Conflicto y Soluciones</option>
                        </select>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">Fecha Inicial</label>
                            <input type="date" name="fechaInicio" class="form-control form-control-lg bg-light" value="<?= htmlspecialchars($_POST['fechaInicio'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">Fecha Final</label>
                            <input type="date" name="fechaFin" class="form-control form-control-lg bg-light" value="<?= htmlspecialchars($_POST['fechaFin'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary">Filtrado Avanzado (Opcional)</label>
                        <div class="input-group">
                            <select name="filtroCampo" class="form-select bg-light" style="max-width: 150px;">
                                <option value="Docente" <?= ($_POST['filtroCampo'] ?? '') === 'Docente' ? 'selected' : '' ?>>Docente</option>
                                <option value="Laboratorio" <?= ($_POST['filtroCampo'] ?? '') === 'Laboratorio' ? 'selected' : '' ?>>Laboratorio</option>
                            </select>
                            <input type="text" name="filtroValor" class="form-control bg-light" placeholder="Ej. Ricardo Silva" value="<?= htmlspecialchars($_POST['filtroValor'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="border-top pt-4">
                        <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm d-flex justify-content-center align-items-center gap-2">
                            <i class="bi bi-search fs-5"></i> Generar Reporte
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?php if ($_SERVER['REQUEST_METHOD'] === 'POST' || $tipoSeleccionado): ?>
<div class="row g-4 mt-4">
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                <h5 class="card-title fw-bold mb-0">
                    Resultados
                    <span class="badge bg-secondary ms-2"><?= count($resultados) ?> registros</span>
                </h5>
            </div>
            <div class="table-responsive p-3">
                <?php if (empty($resultados)): ?>
                <p class="text-muted text-center py-4 mb-0">
                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                    No se encontraron resultados para los criterios seleccionados.
                </p>
                <?php else: ?>
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <?php foreach (array_keys($resultados[0]) as $col): ?>
                            <th><?= htmlspecialchars($col) ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultados as $row): ?>
                        <tr>
                            <?php foreach ($row as $val): ?>
                            <td class="small"><?= htmlspecialchars($val ?? '—') ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>