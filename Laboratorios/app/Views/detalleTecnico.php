<?php if ($successMessage): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-2"></i><?= htmlspecialchars($successMessage) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>
<?php if ($errorMessage): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-triangle me-2"></i><?= htmlspecialchars($errorMessage) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 mb-0"><?= htmlspecialchars($tecnico['nomTecnico']) ?></h2>
        <p class="text-muted small">Detalle del técnico de laboratorio</p>
    </div>
    <a href="index.php?url=Tecnico&type=list" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Volver
    </a>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Información General</h5>
                <table class="table table-borderless mb-0">
                    <tr>
                        <td class="text-muted" style="width:160px">Cédula</td>
                        <td class="fw-semibold"><?= htmlspecialchars($tecnico['cedulaTecnico']) ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Nombre</td>
                        <td class="fw-semibold"><?= htmlspecialchars($tecnico['nomTecnico']) ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Dirección</td>
                        <td><?= htmlspecialchars($tecnico['direccionTecnico'] ?? '—') ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Especialidad</td>
                        <td>
                            <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25">
                                <i class="bi bi-tools me-1"></i><?= htmlspecialchars($tecnico['nombreEspecialidad'] ?? 'Sin asignar') ?>
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex flex-column justify-content-center text-center">
                <?php if ($esAdmin): ?>
                <a href="index.php?url=Tecnico&type=edit&id=<?= $tecnico['idTecnico'] ?>" class="btn btn-outline-primary mb-2">
                    <i class="bi bi-pencil me-1"></i>Editar
                </a>
                <a href="index.php?url=Tecnico&type=delete&id=<?= $tecnico['idTecnico'] ?>"
                   class="btn btn-outline-danger btn-sm"
                   onclick="return confirm('¿Eliminar este técnico?')">
                    <i class="bi bi-trash me-1"></i>Eliminar
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0">Teléfonos de Contacto</h5>
        <?php if ($esAdmin): ?>
        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalAgregarTelefono">
            <i class="bi bi-plus-lg me-1"></i>Agregar Teléfono
        </button>
        <?php endif; ?>
    </div>
    <div class="table-responsive px-3 pb-3">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Teléfono</th>
                    <?php if ($esAdmin): ?>
                    <th class="text-end">Acción</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($telefonos)): ?>
                <tr>
                    <td colspan="<?= $esAdmin ? 3 : 2 ?>" class="text-center text-muted py-4">Este técnico no tiene teléfonos registrados.</td>
                </tr>
                <?php else: ?>
                <?php foreach ($telefonos as $i => $telf): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td class="fw-semibold"><?= htmlspecialchars($telf['telfTecnico']) ?></td>
                    <?php if ($esAdmin): ?>
                    <td class="text-end">
                        <a href="index.php?url=Tecnico&type=deleteTelefono&idTelf=<?= $telf['idTelfTecnico'] ?>&idTecnico=<?= $tecnico['idTecnico'] ?>"
                           class="btn btn-sm btn-light border text-danger"
                           title="Eliminar"
                           onclick="return confirm('¿Eliminar este teléfono?')">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="card border-0 shadow-sm mt-4">
    <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0">Insumos Asignados</h5>
        <span class="badge bg-<?= count($insumosAReponer) > 0 ? 'danger' : 'success' ?>">
            <?= count($insumosAReponer) ?> por reponer
        </span>
    </div>
    <div class="table-responsive px-3 pb-3">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Insumo</th>
                    <th>Categoría</th>
                    <th>Stock Disponible</th>
                    <th>Stock Mínimo</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($insumosAsignados)): ?>
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        <i class="bi bi-info-circle text-info me-2"></i>No tiene insumos asignados.
                    </td>
                </tr>
                <?php else: ?>
                <?php foreach ($insumosAsignados as $ins):
                    $disp = (int)($ins['cantidadDispInsumos'] ?? 0);
                    $min  = (int)($ins['cantidadMinInsumos'] ?? 0);
                    $repuesto = max(0, $min - $disp);
                    $necesitaReponer = $disp <= $min;
                ?>
                <tr class="<?= $necesitaReponer ? 'table-warning' : '' ?>">
                    <td class="fw-semibold"><?= htmlspecialchars($ins['nomInsumos']) ?></td>
                    <td><?= htmlspecialchars($ins['categoriaInsumos'] ?? '—') ?></td>
                    <td><?= $disp ?> <?= htmlspecialchars($ins['unidadMedidaInsumos'] ?? 'unid') ?></td>
                    <td><?= $min ?> <?= htmlspecialchars($ins['unidadMedidaInsumos'] ?? 'unid') ?></td>
                    <td>
                        <?php if ($necesitaReponer): ?>
                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25" title="Faltan <?= $repuesto ?> para el stock mínimo">
                            <i class="bi bi-exclamation-triangle me-1"></i>Reponer (<?= $repuesto ?>)
                        </span>
                        <?php else: ?>
                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">
                            <i class="bi bi-check-circle me-1"></i>Stock OK
                        </span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php if ($esAdmin): ?>
<div class="modal fade" id="modalAgregarTelefono" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form method="POST" action="index.php?url=Tecnico&type=addTelefono">
                <input type="hidden" name="idTecnico" value="<?= $tecnico['idTecnico'] ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Teléfono</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label fw-semibold text-secondary">Número de Teléfono</label>
                    <input type="text" name="telefono" class="form-control" required placeholder="Ej: 0412-1234567">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-save me-1"></i>Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>
