<div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h4 mb-0">Nueva Solicitud de Práctica</h2>
                    <a href="index.php?url=Solicitud&type=list" class="btn btn-outline-secondary d-flex align-items-center gap-2">
                        <i class="bi bi-arrow-left"></i>
                        <span>Volver a Solicitudes</span>
                    </a>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <form action="index.php?url=Solicitud&type=create" method="POST">
                            <p class="text-muted small mb-4">Registrado por: <span class="fw-bold text-primary"><?php echo htmlspecialchars($_SESSION['user_nombre'] ?? 'Usuario'); ?></span></p>
                            <h5 class="fw-bold mb-4 text-primary border-bottom pb-2">Información General</h5>
                            <div class="row g-4 mb-5">
                                <div class="col-md-12">
                                    <label class="form-label fw-semibold text-secondary">Docente Responsable <span class="text-danger">*</span></label>
                                    <select name="idDocente" class="form-select form-select-lg bg-light" required>
                                        <option value="" selected disabled>Seleccione el docente que dictará la práctica...</option>
                                        <?php foreach ($docentes as $doc): ?>
                                            <option value="<?= $doc['idDocente'] ?>"><?= htmlspecialchars($doc['nombre']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-secondary">Asignatura / Práctica <span class="text-danger">*</span></label>
                                    <input type="text" name="asignatura" class="form-control form-control-lg bg-light" placeholder="Ej. Titulación Ácido-Base" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold text-secondary">Sección <span class="text-danger">*</span></label>
                                    <input type="text" name="seccion" class="form-control form-control-lg bg-light" placeholder="Ej. 2101" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold text-secondary">Estudiantes Totales</label>
                                    <input type="number" name="estudiantes" class="form-control form-control-lg bg-light" placeholder="0" min="1" required>
                                </div>
                            </div>
                            
                            <h5 class="fw-bold mb-4 text-primary border-bottom pb-2">Requerimientos Técnicos y Materiales</h5>
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-secondary">Seleccionar Insumos / Reactivos</label>
                                <div class="row g-2 mb-3">
                                    <div class="col-md-7">
                                        <select id="selectInsumo" class="form-select bg-light">
                                            <option value="" selected disabled>Elija un insumo...</option>
                                            <?php foreach ($insumosDisponibles as $i): ?>
                                                <option value="<?= htmlspecialchars($i['nomInsumos']) ?>" data-stock="<?= $i['cantidadDispInsumos'] ?>" data-unidad="<?= htmlspecialchars($i['unidadMedidaInsumos']) ?>">
                                                    <?= htmlspecialchars($i['nomInsumos']) ?> (Disp: <?= $i['cantidadDispInsumos'] ?> <?= htmlspecialchars($i['unidadMedidaInsumos']) ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <input type="number" id="cantidadInsumo" class="form-control bg-light" placeholder="Cant." min="1">
                                            <span class="input-group-text small" id="unidadLabel">—</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" id="btnAgregarInsumo" class="btn btn-outline-primary w-100">
                                            <i class="bi bi-plus-circle me-1"></i>Añadir
                                        </button>
                                    </div>
                                </div>

                                <div class="table-responsive mb-2">
                                    <table class="table table-sm table-bordered bg-white" id="tablaInsumosSeleccionados" style="display: none;">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Insumo</th>
                                                <th style="width: 100px;">Cantidad</th>
                                                <th style="width: 50px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>

                                <textarea name="insumos" id="insumosFinal" class="form-control bg-light" rows="3" placeholder="Resumen de insumos seleccionados..." readonly></textarea>
                                <div class="form-text mt-2"><i class="bi bi-info-circle text-primary me-1"></i>Los insumos añadidos aparecerán en la lista superior y se resumirán aquí automáticamente.</div>
                            </div>

                            <h5 class="fw-bold mb-4 text-primary border-bottom pb-2">Observaciones</h5>
                            <div class="mb-5">
                                <label class="form-label fw-semibold text-secondary">Notas adicionales</label>
                                <textarea name="observacion" class="form-control bg-light" rows="3" placeholder="Cualquier información adicional que consideres relevante..."></textarea>
                                <div class="form-text mt-2"><i class="bi bi-info-circle text-primary me-1"></i>La fecha, hora y laboratorio se definirán en la reserva una vez aprobada la solicitud.</div>
                            </div>
                            
                            <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                                <a href="index.php?url=Solicitud&type=list" class="btn btn-light px-4 py-2 fw-semibold">Cancelar</a>
                                <button type="submit" class="btn btn-primary px-5 py-2 fw-semibold shadow-sm d-flex justify-content-center align-items-center"><i class="bi bi-send-fill me-2"></i> Enviar Solicitud</button>
                            </div>
                        </form>
                    </div>
                </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectInsumo = document.getElementById('selectInsumo');
    const cantidadInsumo = document.getElementById('cantidadInsumo');
    const unidadLabel = document.getElementById('unidadLabel');
    const btnAgregar = document.getElementById('btnAgregarInsumo');
    const tablaInsumos = document.getElementById('tablaInsumosSeleccionados');
    const tbody = tablaInsumos.querySelector('tbody');
    const textareaFinal = document.getElementById('insumosFinal');

    let listaInsumos = [];

    selectInsumo.addEventListener('change', function() {
        const selected = selectInsumo.options[selectInsumo.selectedIndex];
        unidadLabel.textContent = selected.dataset.unidad || '—';
        cantidadInsumo.max = selected.dataset.stock;
    });

    btnAgregar.addEventListener('click', function() {
        const nombre = selectInsumo.value;
        const cant = cantidadInsumo.value;
        const unidad = unidadLabel.textContent;

        if (!nombre || !cant || cant <= 0) {
            alert('Por favor seleccione un insumo y una cantidad válida.');
            return;
        }

        listaInsumos.push({ nombre, cant, unidad });
        actualizarUI();
        
        selectInsumo.value = '';
        cantidadInsumo.value = '';
        unidadLabel.textContent = '—';
    });

    function actualizarUI() {
        tbody.innerHTML = '';
        if (listaInsumos.length > 0) {
            tablaInsumos.style.display = 'table';
            let textResumen = [];
            listaInsumos.forEach((item, index) => {
                textResumen.push(`${item.cant} ${item.unidad} de ${item.nombre}`);
                const tr = document.createElement('tr');
                tr.innerHTML = `<td>${item.nombre}</td><td>${item.cant} ${item.unidad}</td><td class="text-center"><button type="button" class="btn btn-link text-danger p-0" onclick="removerInsumo(${index})"><i class="bi bi-trash"></i></button></td>`;
                tbody.appendChild(tr);
            });
            textareaFinal.value = textResumen.join(', ');
        } else {
            tablaInsumos.style.display = 'none';
            textareaFinal.value = '';
        }
    }

    window.removerInsumo = function(index) {
        listaInsumos.splice(index, 1);
        actualizarUI();
    };
});
</script>