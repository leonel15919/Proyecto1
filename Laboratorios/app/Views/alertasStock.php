<div class="row mb-4">
    <div class="col">
        <h1 class="h3 mb-0 text-gray-800">Alertas de Stock</h1>
        <p class="text-muted">Insumos que han alcanzado o superado el nivel mínimo de inventario configurado.</p>
    </div>
</div>

<div class="card shadow mb-4 border-start border-danger border-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center bg-white">
        <h6 class="m-0 fw-bold text-danger"><i class="bi bi-exclamation-triangle-fill me-2"></i>Insumos en Estado Crítico</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Insumo</th>
                        <th>Categoría</th>
                        <th class="text-center">Stock Disponible</th>
                        <th class="text-center">Stock Mínimo</th>
                        <th>Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($insumosCriticos)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-check-circle fs-1 d-block mb-2 text-success"></i>
                                Todos los insumos se encuentran por encima del nivel crítico.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($insumosCriticos as $insumo): ?>
                            <?php 
                                $disp = (float)$insumo['cantidadDispInsumos'];
                                $min = (float)$insumo['cantidadMinInsumos'];
                                $isAgotado = $disp <= 0;
                            ?>
                            <tr class="<?php echo $isAgotado ? 'table-danger-subtle' : ''; ?>">
                                <td>
                                    <div class="fw-bold"><?php echo htmlspecialchars($insumo['nomInsumos']); ?></div>
                                    <small class="text-muted text-uppercase"><?php echo htmlspecialchars($insumo['unidadMedidaInsumos']); ?></small>
                                </td>
                                <td><?php echo htmlspecialchars($insumo['categoriaInsumos']); ?></td>
                                <td class="text-center fw-bold <?php echo $isAgotado ? 'text-danger' : 'text-warning'; ?>"><?php echo $disp; ?></td>
                                <td class="text-center"><?php echo $min; ?></td>
                                <td>
                                    <span class="badge <?php echo $isAgotado ? 'bg-danger' : 'bg-warning text-dark'; ?>">
                                        <?php echo $isAgotado ? 'AGOTADO' : 'BAJO STOCK'; ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="index.php?url=Insumo" class="btn btn-sm btn-primary">
                                        <i class="bi bi-box-arrow-in-right"></i> Ver Inventario
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>