<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">Detalle de Solicitud #S-<?= str_pad($solicitud['idSolicitudPractica'], 3, '0', STR_PAD_LEFT) ?></h2>
    <a href="index.php?url=Solicitud&type=list" class="btn btn-outline-secondary d-flex align-items-center gap-2">
        <i class="bi bi-arrow-left"></i>
        <span>Volver a Solicitudes</span>
    </a>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4 p-md-5">
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <label class="fw-semibold text-secondary small">Código</label>
                <p class="fs-5 fw-bold">#S-<?= str_pad($solicitud['idSolicitudPractica'], 3, '0', STR_PAD_LEFT) ?></p>
            </div>
            <div class="col-md-6 text-md-end">
                <span class="badge fs-6 <?php
                    $estado = $solicitud['estadoSolicitudPractica'] ?? 'pendiente';
                    echo match (strtolower($estado)) {
                        'pendiente' => 'bg-warning bg-opacity-10 text-warning',
                        'aprobada'  => 'bg-success bg-opacity-10 text-success',
                        'rechazada' => 'bg-danger bg-opacity-10 text-danger',
                        default     => 'bg-secondary bg-opacity-10 text-secondary',
                    };
                ?> px-3 py-2"><?= htmlspecialchars(ucfirst($estado)) ?></span>
            </div>
        </div>

        <h5 class="fw-bold mb-3 text-primary border-bottom pb-2">Información General</h5>
        <div class="row g-4 mb-5">
            <div class="col-md-6">
                <label class="fw-semibold text-secondary small">Docente Responsable</label>
                <p class="fs-6"><?= htmlspecialchars(trim($solicitud['nombreDocente'] ?? '') ?: 'Sin asignar') ?></p>
            </div>
            <div class="col-md-6">
                <label class="fw-semibold text-secondary small">Cédula del Docente</label>
                <p class="fs-6"><?= htmlspecialchars($solicitud['cedulaDocente'] ?? 'N/A') ?></p>
            </div>
            <div class="col-md-6">
                <label class="fw-semibold text-secondary small">Registrado por</label>
                <p class="fs-6"><?= htmlspecialchars($solicitud['nomPersonalDireccion'] ?? 'N/A') ?></p>
            </div>
        </div>

        <h5 class="fw-bold mb-3 text-primary border-bottom pb-2">Observación</h5>
        <div class="row g-4 mb-5">
            <div class="col-12">
                <p class="fs-6"><?= nl2br(htmlspecialchars($solicitud['observacionSolicitudPractica'] ?? 'Sin observación')) ?></p>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-3 pt-3 border-top">
            <?php if (($_SESSION['user_rol'] ?? '') === 'Administrador'): ?>
                <a href="index.php?url=Solicitud&type=edit&id=<?= $solicitud['idSolicitudPractica'] ?>" class="btn btn-outline-warning px-4 py-2 fw-semibold"><i class="bi bi-pencil me-2"></i>Editar</a>
            <?php endif; ?>
            <?php if (strtolower($estado) === 'pendiente' && ($_SESSION['user_rol'] ?? '') === 'Administrador'): ?>
                <a href="index.php?url=Solicitud&type=approve&id=<?= $solicitud['idSolicitudPractica'] ?>" class="btn btn-success px-4 py-2 fw-semibold" onclick="return confirm('¿Aprobar esta solicitud?')"><i class="bi bi-check-lg me-2"></i>Aprobar</a>
                <a href="index.php?url=Solicitud&type=reject&id=<?= $solicitud['idSolicitudPractica'] ?>" class="btn btn-danger px-4 py-2 fw-semibold" onclick="return confirm('¿Rechazar esta solicitud?')"><i class="bi bi-x-lg me-2"></i>Rechazar</a>
            <?php endif; ?>
            <a href="index.php?url=Solicitud&type=list" class="btn btn-light px-4 py-2 fw-semibold">Volver</a>
        </div>
    </div>
</div>
