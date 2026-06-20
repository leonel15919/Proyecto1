<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 mb-0"><?= htmlspecialchars($laboratorio['nomLaboratorio']) ?></h2>
        <p class="text-muted small">Detalle del laboratorio y sus reservas</p>
    </div>
    <a href="index.php?url=Laboratorio&type=list" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Volver
    </a>
</div>

<?php
$estado = $laboratorio['estadoLaboratorio'] ?? 'desconocido';
$badge = match ($estado) {
    'disponible'   => ['bg-success', 'success', 'bi-check-circle-fill', 'Disponible'],
    'en_uso'       => ['bg-primary', 'primary', 'bi-play-circle-fill', 'En Uso'],
    'mantenimiento'=> ['bg-secondary', 'secondary', 'bi-tools', 'Mantenimiento'],
    default        => ['bg-secondary', 'secondary', 'bi-question-circle', $estado]
};
?>

<div class="row g-4 mb-4">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Información General</h5>
                <table class="table table-borderless mb-0">
                    <tr>
                        <td class="text-muted" style="width:160px">Nombre</td>
                        <td class="fw-semibold"><?= htmlspecialchars($laboratorio['nomLaboratorio']) ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Tipo</td>
                        <td><?= htmlspecialchars(ucfirst($laboratorio['tipoLaboratorio'] ?? '—')) ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Ubicación</td>
                        <td><?= htmlspecialchars($laboratorio['ubicacionLaboratorio'] ?? '—') ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Capacidad</td>
                        <td><?= htmlspecialchars($laboratorio['capacidadLaboratorio'] ?? '—') ?> personas</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Estado</td>
                        <td><span class="badge <?= $badge[0] ?> bg-opacity-10 text-<?= $badge[1] ?> border border-<?= $badge[1] ?> border-opacity-25"><i class="bi <?= $badge[2] ?> me-1"></i><?= $badge[3] ?></span></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex flex-column justify-content-center text-center">
                <?php if ($_SESSION['user_rol'] === 'Administrador'): ?>
                <a href="index.php?url=Laboratorio&type=edit&id=<?= $laboratorio['idLaboratorio'] ?>" class="btn btn-outline-primary mb-2">
                    <i class="bi bi-pencil me-1"></i>Editar
                </a>
                <?php foreach (['disponible', 'en_uso', 'mantenimiento'] as $e):
                    if ($e === $estado) continue; ?>
                <a href="index.php?url=Laboratorio&type=estado&id=<?= $laboratorio['idLaboratorio'] ?>&estado=<?= $e ?>"
                   class="btn btn-outline-<?= $e === 'mantenimiento' ? 'secondary' : ($e === 'en_uso' ? 'primary' : 'success') ?> btn-sm mb-1">
                    <i class="bi bi-arrow-repeat me-1"></i>Marcar como <?= ucfirst(str_replace('_', ' ', $e)) ?>
                </a>
                <?php endforeach; ?>
                <a href="index.php?url=Laboratorio&type=delete&id=<?= $laboratorio['idLaboratorio'] ?>"
                   class="btn btn-outline-danger btn-sm mt-2"
                   onclick="return confirm('¿Eliminar este laboratorio?')">
                    <i class="bi bi-trash me-1"></i>Eliminar
                </a>
                <?php endif; ?>
                <a href="index.php?url=Mantenimiento&type=list&id=<?= $laboratorio['idLaboratorio'] ?>" class="btn btn-outline-warning btn-sm mt-2">
                    <i class="bi bi-tools me-1"></i>Ver Mantenimiento
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0">Reservas del Laboratorio</h5>
        <span class="badge bg-primary"><?= count($reservas) ?> reserva(s)</span>
    </div>
    <div class="table-responsive px-3 pb-3">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Fecha</th>
                    <th>Nombre / Práctica</th>
                    <th>Horario</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($reservas)): ?>
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">Este laboratorio no tiene reservas registradas.</td>
                </tr>
                <?php else: ?>
                <?php foreach ($reservas as $r):
                    $estadoRes = $r['estadoReserva'] ?? 'desconocido';
                    $rBadge = match ($estadoRes) {
                        'activa'     => ['bg-success', 'success'],
                        'pendiente'  => ['bg-warning', 'warning'],
                        'finalizada' => ['bg-secondary', 'secondary'],
                        default      => ['bg-secondary', 'secondary']
                    };
                ?>
                <tr>
                    <td><?= htmlspecialchars($r['fechaReserva']) ?></td>
                    <td class="fw-semibold"><?= htmlspecialchars($r['nombreReserva'] ?? '—') ?></td>
                    <td><?= $r['horaInicioReserva'] ? date('h:i A', strtotime($r['horaInicioReserva'])) : '—' ?> - <?= $r['horaFinReserva'] ? date('h:i A', strtotime($r['horaFinReserva'])) : '—' ?></td>
                    <td><span class="badge <?= $rBadge[0] ?> bg-opacity-10 text-<?= $rBadge[1] ?> border border-<?= $rBadge[1] ?> border-opacity-25"><?= htmlspecialchars(ucfirst($estadoRes)) ?></span></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
