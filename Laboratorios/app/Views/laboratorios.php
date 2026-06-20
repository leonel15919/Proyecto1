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
        <h2 class="h4 mb-0">Resumen de Laboratorios</h2>
        <p class="text-muted small">Visualización y gestión de los espacios de laboratorio disponibles para prácticas académicas</p>
    </div>
    <?php if ($_SESSION['user_rol'] === 'Administrador'): ?>
    <a href="index.php?url=Laboratorio&type=register" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Nuevo Laboratorio
    </a>
    <?php endif; ?>
</div>

<div class="row g-4 mb-4 summary-cards">
    <div class="col-md-4 summary-card">
        <div class="card border-0 shadow-sm border-start border-4 border-success h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-success bg-opacity-10 text-success p-2 rounded-circle me-3">
                        <i class="bi bi-check-circle fs-4"></i>
                    </div>
                    <h6 class="text-muted small text-uppercase mb-0">Disponibles</h6>
                </div>
                <h3 class="mb-0 text-success"><?= $resumen['disponible'] ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-4 summary-card">
        <div class="card border-0 shadow-sm border-start border-4 border-primary h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-circle me-3">
                        <i class="bi bi-play-circle fs-4"></i>
                    </div>
                    <h6 class="text-muted small text-uppercase mb-0">En Uso</h6>
                </div>
                <h3 class="mb-0 text-primary"><?= $resumen['en_uso'] ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-4 summary-card">
        <div class="card border-0 shadow-sm border-start border-4 border-secondary h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-secondary bg-opacity-10 text-secondary p-2 rounded-circle me-3">
                        <i class="bi bi-tools fs-4"></i>
                    </div>
                    <h6 class="text-muted small text-uppercase mb-0">En Mantenimiento</h6>
                </div>
                <h3 class="mb-0 text-secondary"><?= $resumen['mantenimiento'] ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Todos los Laboratorios</h5>
        <div class="btn-group" data-filter-group="estado">
            <button class="btn btn-outline-secondary btn-sm filter-btn active" data-filter-group="estado" data-filter-value="all">Todos</button>
            <button class="btn btn-outline-success btn-sm filter-btn" data-filter-group="estado" data-filter-value="disponible">Disponibles</button>
            <button class="btn btn-outline-primary btn-sm filter-btn" data-filter-group="estado" data-filter-value="en_uso">En Uso</button>
            <button class="btn btn-outline-secondary btn-sm filter-btn" data-filter-group="estado" data-filter-value="mantenimiento">Mantenimiento</button>
        </div>
    </div>
    <div class="table-responsive p-3">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Laboratorio</th>
                    <th>Ubicación</th>
                    <th>Capacidad</th>
                    <th>Estado</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($laboratorios)): ?>
                <tr data-filter-empty="true">
                    <td colspan="5" class="text-center text-muted py-4">No hay laboratorios registrados.</td>
                </tr>
                <?php else: ?>
                <?php foreach ($laboratorios as $lab):
                    $estado = $lab['estadoLaboratorio'] ?? 'desconocido';
                    $badge = match ($estado) {
                        'disponible' => ['bg-success', 'success', 'bi-check-circle-fill'],
                        'en_uso' => ['bg-primary', 'primary', 'bi-play-circle-fill'],
                        'mantenimiento' => ['bg-secondary', 'secondary', 'bi-tools'],
                        default => ['bg-secondary', 'secondary', 'bi-question-circle']
                    };
                ?>
                <tr data-estado="<?= $estado ?>">
                    <td class="fw-semibold"><?= htmlspecialchars($lab['nomLaboratorio']) ?></td>
                    <td><?= htmlspecialchars($lab['ubicacionLaboratorio'] ?? '—') ?></td>
                    <td><?= htmlspecialchars($lab['capacidadLaboratorio'] ?? '—') ?> Personas</td>
                    <td><span class="badge <?= $badge[0] ?> bg-opacity-10 text-<?= $badge[1] ?> border border-<?= $badge[1] ?> border-opacity-25"><i class="bi <?= $badge[2] ?> me-1"></i><?= htmlspecialchars(ucfirst(str_replace('_', ' ', $estado))) ?></span></td>
                    <td class="text-end">
                        <div class="d-flex gap-1 justify-content-end">
                            <a href="index.php?url=Laboratorio&type=detail&id=<?= $lab['idLaboratorio'] ?>" class="btn btn-sm btn-light border" title="Ver Detalles"><i class="bi bi-eye"></i></a>
                            <?php if ($_SESSION['user_rol'] === 'Administrador'): ?>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light border dropdown-toggle" data-bs-toggle="dropdown" title="Cambiar Estado"><i class="bi bi-arrow-repeat"></i></button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <?php foreach (['disponible', 'en_uso', 'mantenimiento'] as $e):
                                        if ($e === $estado) continue; ?>
                                    <li><a class="dropdown-item small" href="index.php?url=Laboratorio&type=estado&id=<?= $lab['idLaboratorio'] ?>&estado=<?= $e ?>"><?= ucfirst(str_replace('_', ' ', $e)) ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <a href="index.php?url=Laboratorio&type=edit&id=<?= $lab['idLaboratorio'] ?>" class="btn btn-sm btn-light border" title="Editar"><i class="bi bi-pencil"></i></a>
                            <a href="index.php?url=Laboratorio&type=delete&id=<?= $lab['idLaboratorio'] ?>" class="btn btn-sm btn-light border text-danger" title="Eliminar" onclick="return confirm('¿Eliminar este laboratorio?')"><i class="bi bi-trash"></i></a>
                            <?php endif; ?>
                            <a href="index.php?url=Mantenimiento&type=list&id=<?= $lab['idLaboratorio'] ?>" class="btn btn-sm btn-light border" title="Mantenimiento"><i class="bi bi-tools"></i></a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
