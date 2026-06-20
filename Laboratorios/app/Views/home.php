<div class="d-flex justify-content-between align-items-center mb-2">
    <h2 class="h4">Resumen Operativo</h2>
</div>
<div class="mb-4"></div>
<div class="row g-4 mb-4">
    <div class="col-md-3 summary-card">
        <a href="index.php?url=Usuario&type=perfil" class="text-decoration-none">
            <div class="card border-0 shadow-sm border-start border-4 border-info h-100 card-hover-link">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="bg-info bg-opacity-10 text-info p-2 rounded-circle me-3">
                            <i class="bi bi-person-workspace fs-4"></i>
                        </div>
                        <h6 class="text-muted small text-uppercase mb-0">Docentes</h6>
                    </div>
                    <h3 class="mb-1 text-info"><?= $docenteCount ?> Registrados</h3>
                    <p class="mb-0 small text-muted">Personal académico activo</p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3 summary-card">
        <a href="index.php?url=Laboratorio&type=horarios" class="text-decoration-none">
            <div class="card border-0 shadow-sm border-start border-4 border-warning h-100 card-hover-link">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="bg-warning bg-opacity-10 text-warning p-2 rounded-circle me-3">
                            <i class="bi bi-calendar-check fs-4"></i>
                        </div>
                        <h6 class="text-muted small text-uppercase mb-0">Prácticas Hoy</h6>
                    </div>
                    <h3 class="mb-1 text-warning"><?= $reservasHoy ?> Programadas</h3>
                    <p class="mb-0 small text-muted">Reservas de laboratorio para hoy</p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3 summary-card">
        <a href="index.php?url=Insumo&type=alertas" class="text-decoration-none">
            <div class="card border-0 shadow-sm border-start border-4 border-danger h-100 card-hover-link">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="bg-danger bg-opacity-10 text-danger p-2 rounded-circle me-3">
                            <i class="bi bi-box-seam fs-4"></i>
                        </div>
                        <h6 class="text-muted small text-uppercase mb-0">Insumos Críticos</h6>
                    </div>
                    <h3 class="mb-1 text-danger"><?= $insumosCriticos ?> Items</h3>
                    <p class="mb-0 small text-muted">Insumos con stock por debajo del mínimo</p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3 summary-card">
        <a href="index.php?url=Solicitud&type=list" class="text-decoration-none">
            <div class="card border-0 shadow-sm border-start border-4 border-primary h-100 card-hover-link">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-circle me-3">
                            <i class="bi bi-file-earmark-plus fs-4"></i>
                        </div>
                        <h6 class="text-muted small text-uppercase mb-0">Solicitudes Pendientes</h6>
                    </div>
                    <h3 class="mb-1 text-primary"><?= $solicitudesPend ?> Nuevas</h3>
                    <p class="mb-0 small text-muted">Docentes solicitando laboratorios</p>
                </div>
            </div>
        </a>
    </div>
</div>
<div class="row g-4 mb-4">
    <div class="col-md-4 summary-card">
        <a href="index.php?url=Laboratorio&type=list" class="text-decoration-none">
            <div class="card border-0 shadow-sm border-start border-4 border-secondary h-100 card-hover-link">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="bg-secondary bg-opacity-10 text-secondary p-2 rounded-circle me-3">
                            <i class="bi bi-journal-text fs-4"></i>
                        </div>
                        <h6 class="text-muted small text-uppercase mb-0">Laboratorios</h6>
                    </div>
                    <div class="d-flex gap-2 mt-2">
                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1">
                            <i class="bi bi-check-circle me-1"></i><?= $labResumen['disponible'] ?> Disp.
                        </span>
                        <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-2 py-1">
                            <i class="bi bi-clock me-1"></i><?= $labResumen['en_uso'] ?> En uso
                        </span>
                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1">
                            <i class="bi bi-tools me-1"></i><?= $labResumen['mantenimiento'] ?> Mant.
                        </span>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4 summary-card">
        <a href="index.php?url=Usuario&type=list" class="text-decoration-none">
            <div class="card border-0 shadow-sm border-start border-4 border-success h-100 card-hover-link">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="bg-success bg-opacity-10 text-success p-2 rounded-circle me-3">
                            <i class="bi bi-people fs-4"></i>
                        </div>
                        <h6 class="text-muted small text-uppercase mb-0">Usuarios</h6>
                    </div>
                    <h3 class="mb-1 text-success"><?= $totalUsers ?> Registrados</h3>
                    <p class="mb-0 small text-muted">Técnicos, administrativos y docentes</p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4 summary-card">
        <a href="index.php?url=Insumo" class="text-decoration-none">
            <div class="card border-0 shadow-sm border-start border-4 border-dark h-100 card-hover-link">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="bg-dark bg-opacity-10 text-dark p-2 rounded-circle me-3">
                            <i class="bi bi-box-seam fs-4"></i>
                        </div>
                        <h6 class="text-muted small text-uppercase mb-0">Inventario</h6>
                    </div>
                    <h3 class="mb-1 text-dark"><?= $totalInsumos ?> Insumos</h3>
                    <p class="mb-0 small text-muted">Items registrados en almacén</p>
                </div>
            </div>
        </a>
    </div>
</div>
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="card-title mb-0">Próximas Prácticas (Anticipación 15 días)</h5>
            </div>
            <div class="table-responsive px-3">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Fecha</th>
                            <th>Docente</th>
                            <th>Laboratorio</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($proximasClases)): ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">No hay prácticas programadas en los próximos 15 días.</td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($proximasClases as $r): ?>
                        <tr>
                            <td><?= date('d M Y', strtotime($r['fechaReserva'])) ?></td>
                            <td><?= htmlspecialchars($r['nombreDocente'] ?? '—') ?></td>
                            <td><?= htmlspecialchars($r['nomLaboratorio'] ?? '—') ?></td>
                            <td>
                                <?php
                                    $estado = $r['estadoReserva'] ?? 'activa';
                                    $badge = match ($estado) {
                                        'activa'     => 'bg-primary bg-opacity-10 text-primary',
                                        'pendiente'  => 'bg-warning bg-opacity-10 text-warning',
                                        'aprobada'   => 'bg-success bg-opacity-10 text-success',
                                        'finalizada' => 'bg-secondary bg-opacity-10 text-secondary',
                                        'cancelada'  => 'bg-danger bg-opacity-10 text-danger',
                                        default      => 'bg-secondary bg-opacity-10 text-secondary',
                                    };
                                ?>
                                <span class="badge <?= $badge ?>"><?= ucfirst($estado) ?></span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white border-0 text-center py-3">
                <a href="index.php?url=Reserva&type=list" class="text-decoration-none small">Ver todas las reservas</a>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="card-title mb-0 text-danger"><i class="bi bi-exclamation-triangle-fill me-2"></i>Alertas Críticas</h5>
            </div>
            <div class="card-body pt-0">
                <div class="list-group list-group-flush">
                    <?php if (empty($stockBajo)): ?>
                    <div class="list-group-item border-0 px-0">
                        <p class="mb-0 text-muted small text-center py-3">No hay alertas críticas de stock.</p>
                    </div>
                    <?php else: ?>
                    <?php foreach ($stockBajo as $s): ?>
                    <div class="list-group-item border-0 px-0">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <h6 class="mb-1 fw-bold text-dark"><?= htmlspecialchars($s['nomInsumos']) ?></h6>
                            <span class="badge bg-danger">Agotado</span>
                        </div>
                        <p class="mb-1 text-muted small">Stock disponible: <?= htmlspecialchars($s['cantidadDispInsumos'] ?? '0') ?> <?= htmlspecialchars($s['unidadMedidaInsumos'] ?? '') ?>.</p>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
