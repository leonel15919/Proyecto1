<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">Gestión de Solicitudes</h2>
    <?php if (in_array($_SESSION['user_rol'] ?? '', ['Tecnico', 'Administrador'])): ?>
    <a href="index.php?url=Solicitud&type=new" class="btn btn-primary d-flex align-items-center gap-2">
        <i class="bi bi-plus-lg"></i>
        <span>Nueva Práctica</span>
    </a>
    <?php endif; ?>
</div>

<?php if (!empty($successMessage)): ?>
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        <?php echo htmlspecialchars($successMessage); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (!empty($errorMessage)): ?>
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <?php echo htmlspecialchars($errorMessage); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Solicitudes Entrantes y Pendientes</h5>
        <?php $filtroActual = $_GET['estado'] ?? 'todos'; ?>
        <div class="btn-group">
            <a href="index.php?url=Solicitud&type=list&estado=todos" class="btn btn-outline-secondary btn-sm <?= ($filtroActual === 'todos') ? 'active' : '' ?>">Todas</a>
            <a href="index.php?url=Solicitud&type=list&estado=pendiente" class="btn btn-outline-warning btn-sm <?= ($filtroActual === 'pendiente') ? 'active' : '' ?>">Pendientes</a>
            <a href="index.php?url=Solicitud&type=list&estado=aprobada" class="btn btn-outline-success btn-sm <?= ($filtroActual === 'aprobada') ? 'active' : '' ?>">Aprobadas</a>
            <a href="index.php?url=Solicitud&type=list&estado=rechazada" class="btn btn-outline-danger btn-sm <?= ($filtroActual === 'rechazada') ? 'active' : '' ?>">Rechazadas</a>
        </div>
    </div>
    <div class="table-responsive px-3 pb-3">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Cód.</th>
                    <th>Docente</th>
                    <th>Práctica / Asignatura</th>
                    <th>Detalle</th>
                    <th>Estado</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($solicitudes)): ?>
                    <?php foreach ($solicitudes as $s): ?>
                    <?php
                        $estado = $s['estadoSolicitudPractica'] ?? 'pendiente';
                        $badgeClass = match (strtolower($estado)) {
                            'pendiente'       => 'bg-warning bg-opacity-10 text-warning',
                            'aprobada'        => 'bg-success bg-opacity-10 text-success',
                            'rechazada'       => 'bg-danger bg-opacity-10 text-danger',
                            'en verificación' => 'bg-info bg-opacity-10 text-info',
                            default           => 'bg-secondary bg-opacity-10 text-secondary',
                        };
                        $nombreDocente = trim($s['nombreDocente'] ?? '');
                        $obs = $s['observacionSolicitudPractica'] ?? '';
                        $asignatura = '';
                        if (preg_match('/Asignatura:\s*([^|]+)/', $obs, $m)) {
                            $asignatura = trim($m[1]);
                        } elseif (preg_match('/Asignatura:\s*([^,]+)/', $obs, $m)) {
                            $asignatura = trim($m[1]);
                        }
                    ?>
                    <tr data-estado="<?= $estado ?>">
                        <td class="text-muted fw-bold">#S-<?= str_pad($s['idSolicitudPractica'], 3, '0', STR_PAD_LEFT) ?></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex justify-content-center align-items-center me-2" style="width: 35px; height: 35px;">
                                    <i class="bi bi-person"></i>
                                </div>
                                <div>
                                    <span class="d-block fw-bold"><?= htmlspecialchars($nombreDocente ?: 'Sin asignar') ?></span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="d-block"><?= htmlspecialchars($asignatura ?: '—') ?></span>
                        </td>
                        <td>
                            <span class="small text-muted"><?= htmlspecialchars(mb_substr($obs, 0, 80)) ?><?= mb_strlen($obs) > 80 ? '...' : '' ?></span>
                        </td>
                        <td><span class="badge <?= $badgeClass ?>"><?= htmlspecialchars(ucfirst($estado)) ?></span></td>
                        <td class="text-end">
                            <?php if (strtolower($estado) === 'pendiente' && ($_SESSION['user_rol'] ?? '') === 'Administrador'): ?>
                                <a href="index.php?url=Solicitud&type=approve&id=<?= $s['idSolicitudPractica'] ?>" class="btn btn-sm btn-outline-success me-1" onclick="return confirm('¿Aprobar esta solicitud?')" title="Aprobar"><i class="bi bi-check-lg"></i></a>
                                <a href="index.php?url=Solicitud&type=reject&id=<?= $s['idSolicitudPractica'] ?>" class="btn btn-sm btn-outline-danger me-1" onclick="return confirm('¿Rechazar esta solicitud?')" title="Rechazar"><i class="bi bi-x-lg"></i></a>
                            <?php elseif (strtolower($estado) === 'aprobada'): ?>
                                <button class="btn btn-sm btn-outline-success me-1" disabled title="Ya aprobada"><i class="bi bi-check-all"></i></button>
                                <button class="btn btn-sm btn-outline-secondary me-1" disabled title="Rechazar no disponible"><i class="bi bi-x-lg"></i></button>
                            <?php elseif (strtolower($estado) === 'rechazada'): ?>
                                <button class="btn btn-sm btn-outline-secondary me-1" disabled title="Aprobar no disponible"><i class="bi bi-check-lg"></i></button>
                                <button class="btn btn-sm btn-outline-danger me-1" disabled title="Ya rechazada"><i class="bi bi-x-circle"></i></button>
                            <?php else: ?>
                                <button class="btn btn-sm btn-outline-secondary me-1" disabled title="No disponible"><i class="bi bi-check-lg"></i></button>
                                <button class="btn btn-sm btn-outline-secondary me-1" disabled title="No disponible"><i class="bi bi-x-lg"></i></button>
                            <?php endif; ?>
                            <?php if (($_SESSION['user_rol'] ?? '') === 'Administrador'): ?>
                            <a href="index.php?url=Solicitud&type=edit&id=<?= $s['idSolicitudPractica'] ?>" class="btn btn-sm btn-outline-warning" title="Editar"><i class="bi bi-pencil"></i></a>
                            <?php endif; ?>
                            <a href="index.php?url=Solicitud&type=detail&id=<?= $s['idSolicitudPractica'] ?>" class="btn btn-sm btn-outline-primary" title="Ver Detalles"><i class="bi bi-eye"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr data-filter-empty="true">
                        <td colspan="6" class="text-center text-muted py-4">No hay solicitudes registradas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
