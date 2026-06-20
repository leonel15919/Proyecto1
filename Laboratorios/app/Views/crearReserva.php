<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 mb-0">Nueva Reserva</h2>
        <p class="text-muted small">Registrar una nueva reserva de laboratorio</p>
    </div>
    <a href="index.php?url=Reserva&type=list" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Volver
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="index.php?url=Reserva&type=register">
            <input type="hidden" name="idTipoPractica" value="1">
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
                        ?>
                        <option value="<?= $s['idSolicitudPractica'] ?>" data-asignatura="<?= htmlspecialchars($asig) ?>"><?= $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">Nombre de la Práctica <span class="text-muted small">(opcional)</span></label>
                    <input type="text" name="nombreReserva" id="nombreReserva" class="form-control" placeholder="Se autocompleta al seleccionar la práctica">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">Laboratorio</label>
                    <select name="idLaboratorio" class="form-select" required>
                        <option value="">Seleccione...</option>
                        <?php foreach ($laboratorios as $lab): ?>
                        <option value="<?= $lab['idLaboratorio'] ?>"><?= htmlspecialchars($lab['nomLaboratorio']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Fecha</label>
                    <input type="date" name="fechaReserva" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Hora Inicio</label>
                    <input type="time" name="horaInicioReserva" id="horaInicioReserva" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Hora Fin</label>
                    <input type="time" name="horaFinReserva" id="horaFinReserva" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">Estado</label>
                    <select name="estadoReserva" class="form-select">
                        <option value="activa">Activa (Ocupado)</option>
                        <option value="pendiente">Pendiente</option>
                        <option value="aprobada">Aprobada</option>
                        <option value="finalizada">Finalizada</option>
                        <option value="cancelada">Cancelada</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">Turno</label>
                    <select name="turnoReserva" class="form-select">
                        <option value="">Sin turno</option>
                        <option value="mañana">Mañana</option>
                        <option value="tarde">Tarde</option>
                        <option value="noche">Noche</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold text-secondary">Objetivo</label>
                    <input type="text" name="objetivoReserva" class="form-control" placeholder="Objetivo de la práctica" maxlength="45">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold text-secondary">Descripción</label>
                    <input type="text" name="descripReserva" class="form-control" placeholder="Descripción breve" maxlength="45">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold text-secondary">Observaciones</label>
                    <input type="text" name="observacionReserva" class="form-control" placeholder="Observaciones adicionales" maxlength="45">
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Guardar Reserva</button>
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
