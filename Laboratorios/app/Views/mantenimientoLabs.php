<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 mb-1">Mantenimiento de Laboratorios</h2>
        <p class="text-muted small mb-0">Gestión de reparaciones, limpieza y calibración de equipos</p>
    </div>
    <?php if ($idLab): ?>
    <a href="?url=Mantenimiento&type=list" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Ver Todos
    </a>
    <?php endif; ?>
</div>

<?php if ($idLab): ?>
<div class="alert alert-info d-flex align-items-center gap-2 py-2" role="alert">
    <i class="bi bi-funnel"></i>
    <span>Mostrando mantenimientos del laboratorio seleccionado.</span>
    <a href="?url=Laboratorio&type=detail&id=<?= $idLab ?>" class="alert-link ms-auto">Ver detalle del laboratorio</a>
</div>
<?php endif; ?>

<?php if ($success): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-2"></i>Reporte de mantenimiento emitido correctamente.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

                <div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
        <h5 class="card-title fw-bold mb-0">Órdenes de Mantenimiento Activas</h5>
        <div class="btn-group" data-filter-group="estado">
            <button class="btn btn-outline-secondary btn-sm filter-btn active" data-filter-group="estado" data-filter-value="all">Todas</button>
            <button class="btn btn-outline-warning btn-sm filter-btn" data-filter-group="estado" data-filter-value="pendiente">Pendientes</button>
            <button class="btn btn-outline-info btn-sm filter-btn" data-filter-group="estado" data-filter-value="en_progreso">En Progreso</button>
            <button class="btn btn-outline-success btn-sm filter-btn" data-filter-group="estado" data-filter-value="resuelto">Resueltas</button>
        </div>
    </div>
    <div class="table-responsive px-3 pb-3">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Orden N°</th>
                    <th>Laboratorio</th>
                    <th>Tipo de Trabajo</th>
                    <th>Responsable Técnico</th>
                    <th>Fecha Reporte</th>
                    <th>Estado</th>
                    <th class="text-end">Acción</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($anomalias)): ?>
                <tr data-filter-empty="true">
                    <td colspan="7" class="text-center text-muted py-4">No hay órdenes de mantenimiento registradas.</td>
                </tr>
            <?php else: ?>
            <?php foreach ($anomalias as $a):
                $estadoAnom = $a['estadoAnomalia'] ?? 'desconocido';
                $badge = match ($estadoAnom) {
                    'pendiente' => ['bg-warning', 'warning', 'bi-clock', 'Pendiente'],
                    'en_progreso' => ['bg-info', 'info', 'bi-arrow-repeat', 'En Progreso'],
                    'resuelto' => ['bg-success', 'success', 'bi-check2-circle', 'Resuelto'],
                    default => ['bg-secondary', 'secondary', 'bi-question-circle', $estadoAnom]
                };
            ?>
                <tr data-estado="<?= $estadoAnom ?>">
                    <td class="text-muted fw-bold">#A-<?= str_pad($a['idAnomalia'], 3, '0', STR_PAD_LEFT) ?></td>
                    <td><span class="badge bg-light text-dark border"><i class="bi bi-geo-alt me-1"></i><?= htmlspecialchars($a['nomLaboratorio'] ?? '—') ?></span></td>
                    <td><span class="d-block fw-semibold text-dark"><?= htmlspecialchars(ucfirst($a['tipoAnomalia'] ?? $a['descripAnomalia'])) ?></span></td>
                    <td>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-tools text-muted fs-5 me-2"></i>
                            <span class="small fw-semibold"><?= htmlspecialchars($a['nomTecnico'] ?? '—') ?></span>
                        </div>
                    </td>
                    <td><span class="d-block text-dark"><i class="bi bi-calendar me-1 text-primary"></i> <?= htmlspecialchars($a['fechaDecteAnomalia']) ?></span></td>
                    <td><span class="badge <?= $badge[0] ?> bg-opacity-10 text-<?= $badge[1] ?> border border-<?= $badge[1] ?> border-opacity-25 px-2 py-1"><i class="bi <?= $badge[2] ?> me-1"></i><?= $badge[3] ?></span></td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-primary" title="Ver Detalles"><i class="bi bi-eye"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="card-title fw-bold mb-0">Solicitar Asistencia Técnica Rápida</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="index.php?url=Mantenimiento&type=list">
                    <input type="hidden" name="idReserva" value="1">
                    <input type="hidden" name="idTecnico" value="1">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">Afectación en:</label>
                        <select name="tipoAnomalia" class="form-select bg-light" required>
                            <option value="equipo">Equipos de Computación</option>
                            <option value="clima">Aires Acondicionados</option>
                            <option value="electricidad">Iluminación y Eléctrica</option>
                            <option value="infraestructura">Tuberías y Extractores</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">Descripción de la Falla</label>
                        <textarea name="descripcion" class="form-control bg-light" rows="3" placeholder="Detalle lo que ocurre..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-warning w-100 fw-bold"><i class="bi bi-cone-striped me-2"></i>Emitir Reporte Inmediato</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100 bg-light text-center border-dashed">
            <div class="card-body p-5 d-flex flex-column justify-content-center">
                <div class="bg-secondary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                    <i class="bi bi-bar-chart fs-1 text-secondary"></i>
                </div>
                <h4 class="text-dark fw-bold"><?= $totalMantenimientos ?> Mantenimientos Realizados</h4>
                <p class="text-muted small">Durante el presente semestre, el tiempo promedio de respuesta es de 48 horas tras reportarse la falla.</p>
                <a href="index.php?url=Reporte&type=generate&tipo=mantenimiento" class="btn btn-outline-secondary mt-3 align-self-center"><i class="bi bi-file-earmark-text me-2"></i>Ver Reporte Completo de Reparaciones</a>
            </div>
        </div>
    </div>
</div>