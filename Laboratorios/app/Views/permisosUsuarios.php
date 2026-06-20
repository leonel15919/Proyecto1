<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 mb-1">Roles y Permisos</h2>
        <p class="text-muted small mb-0">Configure los m&oacute;dulos a los que puede acceder cada rol</p>
    </div>
    <a href="index.php?url=Usuario&type=list" class="btn btn-outline-secondary d-flex align-items-center gap-2">
        <i class="bi bi-arrow-left"></i>
        <span>Volver a Usuarios</span>
    </a>
</div>

<?php if (!empty($successMessage)): ?>
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm d-flex align-items-center gap-3 mb-4" role="alert">
        <i class="bi bi-check-circle-fill text-success fs-4"></i>
        <div>
            <strong class="d-block text-success-emphasis">Operaci&oacute;n Exitosa</strong>
            <span class="small text-muted"><?php echo htmlspecialchars($successMessage); ?></span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (!empty($errorMessage)): ?>
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm d-flex align-items-center gap-3 mb-4" role="alert">
        <i class="bi bi-exclamation-triangle-fill text-danger fs-4"></i>
        <div>
            <strong class="d-block text-danger-emphasis">Error</strong>
            <span class="small text-muted"><?php echo htmlspecialchars($errorMessage); ?></span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<form action="index.php?url=Usuario&type=permisos" method="POST">
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th style="width: 250px;">M&oacute;dulo / Ruta</th>
                    <?php foreach ($roles as $rol): ?>
                    <th class="text-center">
                        <?php
                        $iconos = ['Administrador' => 'bi-shield-check', 'Tecnico' => 'bi-tools', 'Docente' => 'bi-journal-bookmark'];
                        $icono = $iconos[$rol] ?? 'bi-person';
                        ?>
                        <i class="bi <?= $icono ?> me-1"></i>
                        <?= $rol ?>
                    </th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($todasLasRutas as $ruta => $etiqueta):
                    $iconosRuta = [
                        'home'          => 'house-door',
                        'perfil'        => 'person',
                        'usuario'       => 'people',
                        'solicitud'     => 'file-earmark-text',
                        'laboratorio'   => 'journal-text',
                        'mantenimiento' => 'wrench',

                        'insumo'        => 'box-seam',
                        'reporte'       => 'graph-up',
                        'reserva'       => 'calendar-check',
                    ];
                    $iconoRuta = $iconosRuta[$ruta] ?? 'circle';
                ?>
                    <tr>
                        <td>
                            <i class="bi bi-<?= $iconoRuta ?> me-2 text-primary"></i>
                            <?= $etiqueta ?>
                            <br><small class="text-muted"><?= $ruta ?></small>
                        </td>
                        <?php foreach ($roles as $rol): 
                            $baseRoutes = $base[$rol] ?? [];
                            $overrideRoutes = $override[$rol] ?? null;
                            $checked = $overrideRoutes !== null ? in_array($ruta, $overrideRoutes) : in_array($ruta, $baseRoutes);
                            $esBase = in_array($ruta, $baseRoutes);
                        ?>
                        <td class="text-center">
                            <div class="form-check d-flex justify-content-center">
                                <input class="form-check-input" type="checkbox"
                                    name="permisos[<?= $rol ?>][]" value="<?= $ruta ?>"
                                    id="chk_<?= $rol ?>_<?= $ruta ?>"
                                    <?= $checked ? 'checked' : '' ?>
                                    style="width: 20px; height: 20px;">
                            </div>
                            <?php if (!$esBase): ?>
                            <small class="text-muted d-block" style="font-size: 0.65rem;">extra</small>
                            <?php endif; ?>
                        </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
        <p class="text-muted small mb-0">
            <i class="bi bi-info-circle me-1"></i>
            Las rutas marcadas con <small class="text-muted">extra</small> no est&aacute;n en la configuraci&oacute;n base del rol.
            Si desmarca todo para un rol, se usar&aacute;n los valores por defecto.
        </p>
        <button type="submit" class="btn btn-primary px-5 py-2 fw-semibold shadow-sm">
            <i class="bi bi-save me-2"></i> Guardar Permisos
        </button>
    </div>
</form>
