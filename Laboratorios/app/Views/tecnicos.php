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
        <h2 class="h4 mb-0">Gestión de Técnicos</h2>
        <p class="text-muted small">Administración del personal técnico y sus especialidades</p>
    </div>
    <?php if ($esAdmin): ?>
    <a href="index.php?url=Tecnico&type=register" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Nuevo Técnico
    </a>
    <?php endif; ?>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Listado de Técnicos</h5>
        <span class="badge bg-primary"><?= count($tecnicos) ?> técnico(s)</span>
    </div>
    <div class="table-responsive p-3">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Especialidad</th>
                    <th>Insumos por Reponer</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($tecnicos)): ?>
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">No hay técnicos registrados.</td>
                </tr>
                <?php else: ?>
                <?php foreach ($tecnicos as $t): ?>
                <?php $cantPorReponer = $cantidadReponer[$t['idTecnico']] ?? 0; ?>
                <tr>
                    <td><?= htmlspecialchars($t['cedulaTecnico']) ?></td>
                    <td class="fw-semibold"><?= htmlspecialchars($t['nomTecnico']) ?></td>
                    <td>
                        <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25">
                            <i class="bi bi-tools me-1"></i><?= htmlspecialchars($t['nombreEspecialidad'] ?? 'Sin asignar') ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($cantPorReponer > 0): ?>
                        <a href="index.php?url=Tecnico&type=detail&id=<?= $t['idTecnico'] ?>" class="text-decoration-none">
                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25">
                                <i class="bi bi-exclamation-triangle me-1"></i><?= $cantPorReponer ?> insumo(s)
                            </span>
                        </a>
                        <?php else: ?>
                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">
                            <i class="bi bi-check-circle me-1"></i>Al día
                        </span>
                        <?php endif; ?>
                    </td>
                    <td class="text-end">
                        <div class="d-flex gap-1 justify-content-end">
                            <a href="index.php?url=Tecnico&type=detail&id=<?= $t['idTecnico'] ?>" class="btn btn-sm btn-light border" title="Ver Detalles"><i class="bi bi-eye"></i></a>
                            <?php if ($esAdmin): ?>
                            <a href="index.php?url=Tecnico&type=edit&id=<?= $t['idTecnico'] ?>" class="btn btn-sm btn-light border" title="Editar"><i class="bi bi-pencil"></i></a>
                            <a href="index.php?url=Tecnico&type=delete&id=<?= $t['idTecnico'] ?>" class="btn btn-sm btn-light border text-danger" title="Eliminar" onclick="return confirm('¿Eliminar este técnico?')"><i class="bi bi-trash"></i></a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
