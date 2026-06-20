<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 mb-0">Editar Reserva</h2>
        <p class="text-muted small">Modificar los datos de la reserva</p>
    </div>
    <a href="index.php?url=Reserva&type=list" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Volver
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="index.php?url=Reserva&type=edit&id=<?= $reserva['idReserva'] ?>">
            <input type="hidden" name="idTipoPractica" value="<?= $reserva['idTipoPractica'] ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">Práctica <span class="text-danger">*</span></label>
                    <select name="idSolicitudPractica" id="idSolicitudPractica" class="form-select" required>
                        <option value="">Seleccione la práctica a reservar...</option>
                        <?php foreach ($solicitudes as $s): ?>
                        <?php
                            $obs = $s['observacionSolicitudPractica'] ?? '';
                            $asig = '';
                            if (preg_match('/Asignatura:\s*([^|]+)/', $obs, $m)) $asig = trim($m[1]);
                            $label = '#S-' . str_pad($s['idSolicitudPractica'], 3, '0', STR_PAD_LEFT)
                                   . ' — ' . htmlspecialchars($asig ?: 'Sin asignatura')
                                   . ' (' . htmlspecialchars($s['nombreDocente'] ?? 'Sin docente') . ')';
                            $selected = ((int)$reserva['idSolicitudPractica'] === (int)$s['idSolicitudPractica']) ? 'selected' : '';
                        ?>
                        <option value="<?= $s['idSolicitudPractica'] ?>" data-asignatura="<?= htmlspecialchars($asig) ?>" <?= $selected ?>><?= $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">Nombre de la Práctica <span class="text-muted small">(opcional)</span></label>
                    <input type="text" name="nombreReserva" id="nombreReserva" class="form-control"
                           value="<?= htmlspecialchars($reserva['nombreReserva']) ?>"
                           placeholder="Se autocompleta al seleccionar la práctica">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">Laboratorio</label>
                    <select name="idLaboratorio" class="form-select" required>
                        <option value="">Seleccione...</option>
                        <?php foreach ($laboratorios as $lab): ?>
                        <option value="<?= $lab['idLaboratorio'] ?>" <?= ((int)$reserva['idLaboratorio'] === (int)$lab['idLaboratorio']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($lab['nomLaboratorio']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Fecha</label>
                    <input type="date" name="fechaReserva" class="form-control" required
                           value="<?= htmlspecialchars($reserva['fechaReserva']) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Hora Inicio</label>
                    <input type="time" name="horaInicioReserva" id="horaInicioReserva" class="form-control" required
                           value="<?= htmlspecialchars($reserva['horaInicioReserva']) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Hora Fin</label>
                    <input type="time" name="horaFinReserva" id="horaFinReserva" class="form-control" required
                           value="<?= htmlspecialchars($reserva['horaFinReserva']) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">Estado</label>
                    <select name="estadoReserva" class="form-select">
                        <?php $estados = ['activa' => 'Activa (Ocupado)', 'pendiente' => 'Pendiente', 'aprobada' => 'Aprobada', 'finalizada' => 'Finalizada', 'cancelada' => 'Cancelada']; ?>
                        <?php foreach ($estados as $val => $label): ?>
                        <option value="<?= $val ?>" <?= ($reserva['estadoReserva'] ?? '') === $val ? 'selected' : '' ?>><?= $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">Turno</label>
                    <select name="turnoReserva" class="form-select">
                        <option value="">Sin turno</option>
                        <?php $turnos = ['mañana' => 'Mañana', 'tarde' => 'Tarde', 'noche' => 'Noche']; ?>
                        <?php foreach ($turnos as $val => $label): ?>
                        <option value="<?= $val ?>" <?= ($reserva['turnoReserva'] ?? '') === $val ? 'selected' : '' ?>><?= $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold text-secondary">Objetivo</label>
                    <input type="text" name="objetivoReserva" class="form-control" maxlength="45"
                           value="<?= htmlspecialchars($reserva['objetivoReserva'] ?? '') ?>">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold text-secondary">Descripción</label>
                    <input type="text" name="descripReserva" class="form-control" maxlength="45"
                           value="<?= htmlspecialchars($reserva['descripReserva'] ?? '') ?>">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold text-secondary">Observaciones</label>
                    <input type="text" name="observacionReserva" class="form-control" maxlength="45"
                           value="<?= htmlspecialchars($reserva['observacionReserva'] ?? '') ?>">
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Actualizar Reserva</button>
                <a href="index.php?url=Reserva&type=list" class="btn btn-outline-secondary ms-2">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var inicio = document.getElementById('horaInicioReserva');
    var fin    = document.getElementById('horaFinReserva');
    if (inicio && fin) {
        function syncMin() {
            fin.min = inicio.value || '00:00';
        }
        inicio.addEventListener('change', syncMin);
        inicio.addEventListener('input', syncMin);
        syncMin();
    }

    var selPractica = document.getElementById('idSolicitudPractica');
    var inpNombre   = document.getElementById('nombreReserva');
    if (selPractica && inpNombre) {
        selPractica.addEventListener('change', function () {
            var selected = selPractica.options[selPractica.selectedIndex];
            var asig = selected ? selected.getAttribute('data-asignatura') : '';
            if (asig) {
                inpNombre.value = asig;
            }
        });
    }
});
</script>
