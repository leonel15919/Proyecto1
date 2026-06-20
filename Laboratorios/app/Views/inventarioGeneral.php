<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 mb-0">Inventario General de Laboratorios</h2>
        <p class="text-muted small">Catálogo de materiales, equipos y reactivos disponibles para prácticas académicas</p>
    </div>
    <a href="index.php?url=Insumo&type=register" class="btn btn-primary shadow-sm"><i class="bi bi-plus-lg me-2"></i>Registrar Insumo</a>
    <a href="index.php?url=Insumo&type=register_computacion" class="btn btn-primary shadow-sm"><i class="bi bi-plus-lg me-2"></i>Registrar Insumo de Cómputo</a>

</div>

<?php if ($successMessage): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-2"></i> <?= htmlspecialchars($successMessage) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="table-responsive p-3">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Cód.</th>
                    <th>Nombre del Artículo</th>
                    <th>Categoría</th>
                    <th>Cant. Disponible</th>
                    <th>Unidad</th>
                    <th>Ubicación Física</th>
                    <th>Vencimiento</th>
                    <th class="text-end">Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($insumos)): ?>
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                        No hay insumos registrados. <a href="index.php?url=Insumo&type=register">Registrar el primero</a>
                    </td>
                </tr>
                <?php else: ?>
                <?php foreach ($insumos as $insumo): ?>
                <tr>
                    <td class="text-muted fw-bold">INS-<?= str_pad($insumo['idInsumos'], 3, '0', STR_PAD_LEFT) ?></td>
                    <td class="fw-semibold text-dark"><?= htmlspecialchars($insumo['nomInsumos']) ?></td>
                    <td>
                        <?php
                        $badgeClass = match ($insumo['categoriaInsumos'] ?? '') {
                            'Reactivos Químicos' => 'bg-danger',
                            'Material de Vidrio (Vidriería)', 'Vidriería' => 'bg-primary',
                            'Equipos e Instrumentos', 'Equipos' => 'bg-secondary',
                            'Insumos Desechables (Guantes/Mascarillas)', 'Bioseguridad' => 'bg-info',
                            'Equipos de Cómputo e Insumos Tecnológicos' => 'bg-dark',
                            default => 'bg-secondary'
                        };
                        ?>
                        <span class="badge <?= $badgeClass ?> bg-opacity-10 text-<?= str_replace('bg-', '', $badgeClass) ?> border border-<?= str_replace('bg-', '', $badgeClass) ?> border-opacity-25">
                            <?= htmlspecialchars($insumo['categoriaInsumos'] ?? 'Sin categoría') ?>
                        </span>
                    </td>
                    <td class="fw-bold <?= ((float)($insumo['cantidadDispInsumos'] ?? 0) <= (float)($insumo['cantidadMinInsumos'] ?? 0)) ? 'text-warning' : 'text-success' ?> fs-5">
                        <?= htmlspecialchars($insumo['cantidadDispInsumos'] ?? '0') ?>
                    </td>
                    <td class="text-muted"><?= htmlspecialchars($insumo['unidadMedidaInsumos'] ?? '—') ?></td>
                    <?php
                    $parts = explode(' | ', $insumo['descripInsumos'] ?? '');
                    $ubicacion = $parts[1] ?? '—';
                    $vencimiento = !empty($parts[2]) ? str_replace('Vence: ', '', $parts[2]) : '—';
                    ?>
                    <td class="text-muted small"><?= htmlspecialchars($ubicacion) ?></td>
                    <td class="text-muted small"><?= htmlspecialchars($vencimiento) ?></td>
                    <td class="text-end">
                        <a href="index.php?url=Insumo&type=edit&id=<?= $insumo['idInsumos'] ?>" class="btn btn-sm btn-light border"><i class="bi bi-pencil"></i></a>
                        <a href="index.php?url=Insumo&type=list&action=delete&id=<?= $insumo['idInsumos'] ?>" class="btn btn-sm btn-light border text-danger" onclick="return confirm('¿Eliminar este insumo?')"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>