<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="h4 mb-0">Cronograma Semanal</h2>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <a href="?url=Laboratorio&type=horarios&semana=<?= $semanaAnterior ?>" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-chevron-left"></i> Semana Anterior
    </a>
    <span class="fw-semibold">
        Semana del <?= date('d/m/Y', strtotime($lunesStr)) ?> al <?= date('d/m/Y', strtotime($domingoStr)) ?>
    </span>
    <div>
        <a href="?url=Laboratorio&type=horarios" class="btn btn-outline-primary btn-sm me-1">
            <i class="bi bi-calendar-week"></i> Esta Semana
        </a>
        <a href="?url=Laboratorio&type=horarios&semana=<?= $semanaSiguiente ?>" class="btn btn-outline-secondary btn-sm">
            Semana Siguiente <i class="bi bi-chevron-right"></i>
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body py-2">
        <div class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label small fw-semibold text-muted mb-1">Filtrar por Laboratorio</label>
                <select id="filtroLaboratorio" class="form-select form-select-sm">
                    <option value="">Todos los laboratorios</option>
                    <?php foreach ($laboratorios as $lab): ?>
                    <option value="<?= htmlspecialchars($lab['nomLaboratorio']) ?>"><?= htmlspecialchars($lab['nomLaboratorio']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold text-muted mb-1">Filtrar por Estado</label>
                <div class="btn-group btn-group-sm w-100" data-filter-group="estado">
                    <button class="btn btn-outline-secondary filter-btn active" data-filter-value="all">Todas</button>
                    <button class="btn btn-outline-primary filter-btn" data-filter-value="activa">Ocupado</button>
                    <button class="btn btn-outline-success filter-btn" data-filter-value="aprobada">Aprobada</button>
                    <button class="btn btn-outline-warning filter-btn" data-filter-value="pendiente">Pendiente</button>
                    <button class="btn btn-outline-secondary filter-btn" data-filter-value="finalizada">Finalizada</button>
                    <button class="btn btn-outline-danger filter-btn" data-filter-value="cancelada">Cancelada</button>
                </div>
            </div>
            <div class="col-md-2 d-flex justify-content-end">
                <button id="limpiarFiltros" class="btn btn-sm btn-outline-secondary w-100">
                    <i class="bi bi-x-circle me-1"></i>Limpiar
                </button>
            </div>
        </div>
    </div>
</div>

<?php
$franjas = [
    ['label' => '06:00 AM<br>08:00 AM', 'inicio' => '06:00', 'fin' => '08:00'],
    ['label' => '08:00 AM<br>10:00 AM', 'inicio' => '08:00', 'fin' => '10:00'],
    ['label' => '10:00 AM<br>12:00 PM', 'inicio' => '10:00', 'fin' => '12:00'],
    ['label' => '01:00 PM<br>03:00 PM', 'inicio' => '13:00', 'fin' => '15:00'],
    ['label' => '03:00 PM<br>05:00 PM', 'inicio' => '15:00', 'fin' => '17:00'],
    ['label' => '05:00 PM<br>07:00 PM', 'inicio' => '17:00', 'fin' => '19:00'],
];

$estadoBadge = [
    'activa'     => ['bg-primary', 'primary', 'Ocupado'],
    'pendiente'  => ['bg-warning', 'warning', 'Pendiente'],
    'aprobada'   => ['bg-success', 'success', 'Aprobada'],
    'finalizada' => ['bg-secondary', 'secondary', 'Finalizada'],
    'cancelada'  => ['bg-danger', 'danger', 'Cancelada'],
];

function tiempoEnSlot(string $horaInicio, string $horaFin, string $slotInicio, string $slotFin): bool
{
    $inicio = strtotime($horaInicio);
    $fin    = strtotime($horaFin);
    $sIni   = strtotime($slotInicio);
    $sFin   = strtotime($slotFin);
    if ($inicio === false || $fin === false) return false;
    return $inicio < $sFin && $fin > $sIni;
}
?>

<div class="card border-0 shadow-sm overflow-hidden text-center mb-4">
    <div class="table-responsive">
        <table id="tablaCronograma" class="table table-bordered mb-0 align-middle">
            <thead class="table-primary text-white border-primary">
                <tr>
                    <th style="width: 100px;">Hora</th>
                    <?php foreach ($diasSemana as $dia): ?>
                    <th><?= $dia ?><br><small><?= date('d/m', strtotime($fechasSemana[$dia])) ?></small></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($franjas as $franja): ?>
                <tr>
                    <td class="fw-bold bg-light text-primary"><?= $franja['label'] ?></td>
                    <?php foreach ($diasSemana as $dia):
                        $fechaDia = $fechasSemana[$dia];
                        $reservasEnCelda = array_filter($reservas, function($r) use ($fechaDia, $franja) {
                            return $r['fechaReserva'] === $fechaDia
                                && tiempoEnSlot(
                                    $r['horaInicioReserva'] ?? '',
                                    $r['horaFinReserva'] ?? '',
                                    $franja['inicio'],
                                    $franja['fin']
                                );
                        });
                    ?>
                    <td>
                        <span class="text-muted small placeholder-vacio" style="display:<?= empty($reservasEnCelda) ? '' : 'none' ?>">—</span>
                        <?php foreach ($reservasEnCelda as $r):
                            $estado = $r['estadoReserva'] ?? 'desconocido';
                            $bg = $estadoBadge[$estado] ?? ['bg-secondary', 'secondary', ucfirst($estado)];
                        ?>
                        <a href="index.php?url=Reserva&type=edit&id=<?= $r['idReserva'] ?>" class="text-decoration-none">
                        <div class="p-2 bg-<?= $bg[1] ?> bg-opacity-10 text-<?= $bg[1] ?> border border-<?= $bg[1] ?> rounded-3 shadow-sm mb-1 cronograma-card"
                             data-laboratorio="<?= htmlspecialchars($r['nomLaboratorio'] ?? '') ?>"
                             data-estado="<?= $estado ?>">
                            <span class="small d-block fw-bold border-bottom border-<?= $bg[1] ?> mb-1"><?= htmlspecialchars($r['nombreReserva'] ?? 'Sin nombre') ?></span>
                            <span class="small d-block"><i class="bi bi-person me-1"></i><?= htmlspecialchars($r['nombreDocente'] ?? '—') ?></span>
                            <span class="small d-block"><i class="bi bi-geo-alt me-1"></i><?= htmlspecialchars($r['nomLaboratorio'] ?? '—') ?></span>
                            <span class="badge <?= $bg[0] ?> mt-1"><?= $bg[2] ?></span>
                        </div>
                        </a>
                        <?php endforeach; ?>
                    </td>
                    <?php endforeach; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center">
    <div class="small text-muted">
        <i class="bi bi-info-circle me-1"></i>
        Mostrando <span id="conteoReservas"><?= count($reservas) ?></span> reserva(s) en la semana
    </div>

</div>

<script>
(function() {
    const filtroLab = document.getElementById('filtroLaboratorio');
    const estadoBtns = document.querySelectorAll('[data-filter-group="estado"] .filter-btn');
    const limpiarBtn = document.getElementById('limpiarFiltros');
    const cards = document.querySelectorAll('#tablaCronograma .cronograma-card');
    const conteo = document.getElementById('conteoReservas');

    function applyFilters() {
        const labSel = filtroLab.value;
        const estSel = document.querySelector('[data-filter-group="estado"] .filter-btn.active');
        const estVal = estSel ? estSel.dataset.filterValue : 'all';

        let visible = 0;
        cards.forEach(function(card) {
            const coincideLab = labSel === '' || card.dataset.laboratorio === labSel;
            const coincideEst = estVal === 'all' || card.dataset.estado === estVal;
            card.style.display = coincideLab && coincideEst ? '' : 'none';
            if (coincideLab && coincideEst) visible++;
        });

        const celdas = document.querySelectorAll('#tablaCronograma tbody td');
        celdas.forEach(function(td) {
            const hijosVisibles = Array.from(td.querySelectorAll('.cronograma-card')).filter(function(c) {
                return c.style.display !== 'none';
            });
            const ph = td.querySelector('.placeholder-vacio');
            if (ph) ph.style.display = hijosVisibles.length === 0 ? '' : 'none';
        });

        conteo.textContent = visible;
    }

    filtroLab.addEventListener('change', applyFilters);

    estadoBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            estadoBtns.forEach(function(b) { b.classList.remove('active'); });
            btn.classList.add('active');
            applyFilters();
        });
    });

    limpiarBtn.addEventListener('click', function() {
        filtroLab.value = '';
        estadoBtns.forEach(function(b) { b.classList.remove('active'); });
        document.querySelector('[data-filter-group="estado"] .filter-btn[data-filter-value="all"]')?.classList.add('active');
        applyFilters();
    });
})();
</script>
