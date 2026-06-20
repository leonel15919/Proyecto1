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
        <h2 class="h4 mb-0">Gestión de Reservas</h2>
        <p class="text-muted small">Administración de las reservas de laboratorios</p>
    </div>
    <?php if ($_SESSION['user_rol'] === 'Administrador'): ?>
    <a href="index.php?url=Reserva&type=register" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Nueva Reserva
    </a>
    <?php endif; ?>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Todas las Reservas</h5>
        <?php $filtroActual = $_GET['estado'] ?? 'todos'; ?>
        <div class="btn-group">
            <a href="index.php?url=Reserva&type=list&estado=todos" class="btn btn-outline-secondary btn-sm <?= ($filtroActual === 'todos') ? 'active' : '' ?>">Todas</a>
            <a href="index.php?url=Reserva&type=list&estado=activa" class="btn btn-outline-primary btn-sm <?= ($filtroActual === 'activa') ? 'active' : '' ?>">Ocupado</a>
            <a href="index.php?url=Reserva&type=list&estado=pendiente" class="btn btn-outline-warning btn-sm <?= ($filtroActual === 'pendiente') ? 'active' : '' ?>">Pendiente</a>
            <a href="index.php?url=Reserva&type=list&estado=aprobada" class="btn btn-outline-success btn-sm <?= ($filtroActual === 'aprobada') ? 'active' : '' ?>">Aprobada</a>
            <a href="index.php?url=Reserva&type=list&estado=finalizada" class="btn btn-outline-secondary btn-sm <?= ($filtroActual === 'finalizada') ? 'active' : '' ?>">Finalizada</a>
            <a href="index.php?url=Reserva&type=list&estado=cancelada" class="btn btn-outline-danger btn-sm <?= ($filtroActual === 'cancelada') ? 'active' : '' ?>">Cancelada</a>
        </div>
    </div>
    <div class="table-responsive p-3">
        <table class="table table-hover align-middle mb-0" data-filter="estado">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Práctica</th>
                    <th>Laboratorio</th>
                    <th>Docente</th>
                    <th>Fecha</th>
                    <th>Horario</th>
                    <th>Estado</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($reservas)): ?>
                <tr data-filter-empty="true">
                    <td colspan="8" class="text-center text-muted py-4">No hay reservas registradas.</td>
                </tr>
                <?php else: ?>
                <?php foreach ($reservas as $r):
                    $estado = $r['estadoReserva'] ?? 'activa';
                    $badge = match ($estado) {
                        'activa'     => ['bg-primary', 'primary', 'Ocupado'],
                        'pendiente'  => ['bg-warning', 'warning', 'Pendiente'],
                        'aprobada'   => ['bg-success', 'success', 'Aprobada'],
                        'finalizada' => ['bg-secondary', 'secondary', 'Finalizada'],
                        'cancelada'  => ['bg-danger', 'danger', 'Cancelada'],
                        default      => ['bg-secondary', 'secondary', ucfirst($estado)],
                    };
                ?>
                <tr data-estado="<?= $estado ?>">
                    <td class="text-muted fw-bold">#R-<?= str_pad($r['idReserva'], 3, '0', STR_PAD_LEFT) ?></td>
                    <td class="fw-semibold"><?= htmlspecialchars($r['nombreReserva'] ?? '—') ?></td>
                    <td><span class="badge bg-light text-dark border"><i class="bi bi-geo-alt me-1"></i><?= htmlspecialchars($r['nomLaboratorio'] ?? '—') ?></span></td>
                    <td><?= htmlspecialchars($r['nombreDocente'] ?? '—') ?></td>
                    <td><?= htmlspecialchars($r['fechaReserva'] ?? '—') ?></td>
                    <td><?= $r['horaInicioReserva'] ? date('h:i A', strtotime($r['horaInicioReserva'])) : '—' ?> - <?= $r['horaFinReserva'] ? date('h:i A', strtotime($r['horaFinReserva'])) : '—' ?></td>
                    <td><span class="badge <?= $badge[0] ?> bg-opacity-10 text-<?= $badge[1] ?> border border-<?= $badge[1] ?> border-opacity-25<?= ($estado === 'pendiente') ? ' badge-pulse' : '' ?>"><?= $badge[2] ?></span></td>
                    <td class="text-end">
                        <div class="d-flex gap-1 justify-content-end">
                            <a href="index.php?url=Reserva&type=edit&id=<?= $r['idReserva'] ?>" class="btn btn-sm btn-light border" title="Editar"><i class="bi bi-pencil"></i></a>
                            <a href="index.php?url=Reserva&type=delete&id=<?= $r['idReserva'] ?>" class="btn btn-sm btn-light border text-danger" title="Eliminar" onclick="return confirm('¿Eliminar esta reserva?')"><i class="bi bi-trash"></i></a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
