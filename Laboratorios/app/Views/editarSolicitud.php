<?php
$obs = $solicitud['observacionSolicitudPractica'] ?? '';
$asignatura  = '';
$seccion     = '';
$estudiantes = '';
$insumos     = '';
$notas       = '';
if (preg_match('/Asignatura:\s*([^|]+)/', $obs, $m)) $asignatura = trim($m[1]);
if (preg_match('/Sección:\s*([^|]+)/', $obs, $m)) $seccion = trim($m[1]);
if (preg_match('/Estudiantes:\s*(\d+)/', $obs, $m)) $estudiantes = $m[1];

$obsBody = $obs;
if (($pos = strpos($obs, "\n---\n")) !== false) {
    $notas = trim(substr($obs, $pos + 5));
    $obsBody = trim(substr($obs, 0, $pos));
}

$partes = explode(' | ', $obsBody);
foreach ($partes as $parte) {
    if (str_starts_with($parte, 'Insumos:') || str_starts_with($parte, 'Insumos/Reactivos:')) {
        $insumos = trim(substr($parte, strpos($parte, ':') + 1));
    }
}

if ($asignatura === '' && preg_match('/Asignatura:\s*([^,]+)/', $obs, $m)) $asignatura = trim($m[1]);
if ($seccion === '' && preg_match('/Sección:\s*([^,]+)/', $obs, $m)) $seccion = trim($m[1]);
if ($estudiantes === '' && preg_match('/Estudiantes:\s*(\d+)/', $obs, $m)) $estudiantes = $m[1];
if ($insumos === '' && preg_match('/Insumos\/Reactivos:\s*(.+)/s', $obs, $m)) $insumos = trim($m[1]);
if ($insumos === '' && preg_match('/Insumos:\s*(.+)/s', $obs, $m)) $insumos = trim($m[1]);
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">Editar Solicitud #S-<?= str_pad($solicitud['idSolicitudPractica'], 3, '0', STR_PAD_LEFT) ?></h2>
    <a href="index.php?url=Solicitud&type=list" class="btn btn-outline-secondary d-flex align-items-center gap-2">
        <i class="bi bi-arrow-left"></i>
        <span>Volver a Solicitudes</span>
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4 p-md-5">
        <form action="index.php?url=Solicitud&type=update&id=<?= $solicitud['idSolicitudPractica'] ?>" method="POST">
            <p class="text-muted small mb-4">
                Editado por: <span class="fw-bold text-primary"><?= htmlspecialchars($_SESSION['user_nombre'] ?? 'Usuario') ?></span>
                &middot; Estado actual: <span class="badge bg-info bg-opacity-10 text-info"><?= ucfirst($solicitud['estadoSolicitudPractica'] ?? 'pendiente') ?></span>
            </p>

            <h5 class="fw-bold mb-4 text-primary border-bottom pb-2">Información General</h5>
            <div class="row g-4 mb-5">
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">Asignatura / Práctica</label>
                    <input type="text" name="asignatura" class="form-control form-control-lg bg-light" value="<?= htmlspecialchars($asignatura) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-secondary">Sección</label>
                    <input type="text" name="seccion" class="form-control form-control-lg bg-light" value="<?= htmlspecialchars($seccion) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-secondary">Estudiantes</label>
                    <input type="number" name="estudiantes" class="form-control form-control-lg bg-light" value="<?= htmlspecialchars($estudiantes) ?>" min="1">
                </div>
            </div>

            <h5 class="fw-bold mb-4 text-primary border-bottom pb-2">Requerimientos Técnicos y Materiales</h5>
            <div class="mb-4">
                <label class="form-label fw-semibold text-secondary">Insumos y Reactivos</label>
                <textarea name="insumos" class="form-control bg-light" rows="4"><?= htmlspecialchars($insumos) ?></textarea>
            </div>

            <h5 class="fw-bold mb-4 text-primary border-bottom pb-2">Observaciones</h5>
            <div class="mb-5">
                <label class="form-label fw-semibold text-secondary">Notas adicionales</label>
                <textarea name="observacion" class="form-control bg-light" rows="3"><?= htmlspecialchars($notas) ?></textarea>
                <div class="form-text mt-2"><i class="bi bi-info-circle text-primary me-1"></i>La fecha, hora y laboratorio se definirán en la reserva una vez aprobada la solicitud.</div>
            </div>

            <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                <a href="index.php?url=Solicitud&type=list" class="btn btn-light px-4 py-2 fw-semibold">Cancelar</a>
                <button type="submit" class="btn btn-primary px-5 py-2 fw-semibold shadow-sm d-flex justify-content-center align-items-center"><i class="bi bi-save me-2"></i> Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>
