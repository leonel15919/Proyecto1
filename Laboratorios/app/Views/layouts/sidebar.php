<div class="d-flex">
    <nav id="sidebar" class="flex-column">
        <div class="logo_UPTAEB p-4 fs-4 fw-bold border-bottom border-secondary mb-3">
            <img src="asset/img/1.jpg" alt="">
        </div>
        <ul class="nav flex-column mb-auto">
            <li class="nav-item">
                <a href="index.php?url=Home" class="nav-link <?php echo ($activeRoute === 'home') ? 'active' : ''; ?>">
                    <i class="bi bi-house-door"></i> Inicio
                </a>
            </li>

            <?php if (rutaPermitida('usuario')): ?>
            <li class="nav-item">
                <div class="accordion sidebar-accordion" id="accordionUsuarios">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingUsuarios">
                            <button class="accordion-button <?php echo (in_array($activeRoute, ['usuario', 'perfil'])) ? '' : 'collapsed'; ?>" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseUsuarios" aria-expanded="<?php echo (in_array($activeRoute, ['usuario', 'perfil'])) ? 'true' : 'false'; ?>" aria-controls="collapseUsuarios">
                                <i class="bi bi-people me-2"></i> Usuarios
                            </button>
                        </h2>
                        <div id="collapseUsuarios" class="accordion-collapse collapse <?php echo (in_array($activeRoute, ['usuario', 'perfil'])) ? 'show' : ''; ?>" aria-labelledby="headingUsuarios"
                            data-bs-parent="#accordionUsuarios">
                            <div class="accordion-body p-0">
                                <a href="index.php?url=Usuario&type=list" class="nav-link py-2 ps-5 small <?php echo ($activeRoute === 'usuario') ? 'active' : ''; ?>">Gestión de Usuarios</a>
                                <a href="index.php?url=Usuario&type=permisos" class="nav-link py-2 ps-5 small <?php echo ($activeRoute === 'usuario' && ($_GET['type'] ?? '') === 'permisos') ? 'active' : ''; ?>">Roles y Permisos</a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <?php endif; ?>

            <?php if (rutaPermitida('tecnico')): ?>
            <li class="nav-item">
                <div class="accordion sidebar-accordion" id="accordionTecnicos">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTecnicos">
                            <button class="accordion-button <?php echo ($activeRoute === 'tecnico') ? '' : 'collapsed'; ?>" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTecnicos" aria-expanded="<?php echo ($activeRoute === 'tecnico') ? 'true' : 'false'; ?>" aria-controls="collapseTecnicos">
                                <i class="bi bi-person-gear me-2"></i> Técnicos
                            </button>
                        </h2>
                        <div id="collapseTecnicos" class="accordion-collapse collapse <?php echo ($activeRoute === 'tecnico') ? 'show' : ''; ?>" aria-labelledby="headingTecnicos"
                            data-bs-parent="#accordionTecnicos">
                            <div class="accordion-body p-0">
                                <a href="index.php?url=Tecnico&type=list" class="nav-link py-2 ps-5 small <?php echo ($activeRoute === 'tecnico') ? 'active' : ''; ?>">Gestión de Técnicos</a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <?php endif; ?>

            <?php if (rutaPermitida('solicitud')): ?>
            <li class="nav-item">
                <div class="accordion sidebar-accordion" id="accordionSolicitudes">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingSolicitudes">
                            <button class="accordion-button <?php echo ($activeRoute === 'solicitud') ? '' : 'collapsed'; ?>" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseSolicitudes" aria-expanded="<?php echo ($activeRoute === 'solicitud') ? 'true' : 'false'; ?>" aria-controls="collapseSolicitudes">
                                <i class="bi bi-file-earmark-text me-2"></i> Solicitudes
                            </button>
                        </h2>
                        <div id="collapseSolicitudes" class="accordion-collapse collapse <?php echo ($activeRoute === 'solicitud') ? 'show' : ''; ?>" aria-labelledby="headingSolicitudes"
                            data-bs-parent="#accordionSolicitudes">
                            <div class="accordion-body p-0">
                                <a href="index.php?url=Solicitud&type=list" class="nav-link py-2 ps-5 small <?php echo ($activeRoute === 'solicitud' && ($_GET['type'] ?? '') === 'list') ? 'active' : ''; ?>">Ver Solicitudes</a>
                                <?php if (in_array($_SESSION['user_rol'] ?? '', ['Tecnico', 'Administrador'])): ?>
                                <a href="index.php?url=Solicitud&type=new" class="nav-link py-2 ps-5 small <?php echo ($activeRoute === 'solicitud' && ($_GET['type'] ?? '') === 'new') ? 'active' : ''; ?>">Nueva Práctica</a>
                                <?php endif; ?>
                                <a href="index.php?url=Solicitud&type=history" class="nav-link py-2 ps-5 small <?php echo ($activeRoute === 'solicitud' && ($_GET['type'] ?? '') === 'history') ? 'active' : ''; ?>">Historial de Solicitudes</a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <?php endif; ?>

            <?php if (rutaPermitida('laboratorio') || rutaPermitida('mantenimiento')): ?>
            <li class="nav-item">
                <div class="accordion sidebar-accordion" id="accordionLaboratorios">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingLaboratorios">
                            <button class="accordion-button <?php echo (in_array($activeRoute, ['laboratorio', 'mantenimiento', 'horarios', 'reserva'])) ? '' : 'collapsed'; ?>" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseLaboratorios" aria-expanded="<?php echo (in_array($activeRoute, ['laboratorio', 'mantenimiento', 'horarios', 'reserva'])) ? 'true' : 'false'; ?>" aria-controls="collapseLaboratorios">
                                <i class="bi bi-journal-text me-2"></i> Laboratorios
                            </button>
                        </h2>
                        <div id="collapseLaboratorios" class="accordion-collapse collapse <?php echo (in_array($activeRoute, ['laboratorio', 'mantenimiento', 'horarios', 'reserva'])) ? 'show' : ''; ?>" aria-labelledby="headingLaboratorios"
                            data-bs-parent="#accordionLaboratorios">
                            <div class="accordion-body p-0">
                                <?php if (rutaPermitida('laboratorio')): ?>
                                <a href="index.php?url=Laboratorio&type=list" class="nav-link py-2 ps-5 small <?php echo ($activeRoute === 'laboratorio') ? 'active' : ''; ?>">Resumen de Espacios</a>
                                <?php endif; ?>
                                <?php if (rutaPermitida('reserva')): ?>
                                <a href="index.php?url=Reserva&type=list" class="nav-link py-2 ps-5 small <?php echo ($activeRoute === 'reserva') ? 'active' : ''; ?>">Gestión de Reservas</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <?php endif; ?>

            <?php if (rutaPermitida('insumo') || rutaPermitida('reporte')): ?>
            <li class="nav-item">
                <div class="accordion sidebar-accordion" id="accordionInsumos">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingInsumos">
                            <button class="accordion-button <?php echo (in_array($activeRoute, ['insumo', 'reporte'])) ? '' : 'collapsed'; ?>" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseInsumos" aria-expanded="<?php echo (in_array($activeRoute, ['insumo', 'reporte'])) ? 'true' : 'false'; ?>" aria-controls="collapseInsumos">
                                <i class="bi bi-box-seam me-2"></i> Insumos
                            </button>
                        </h2>
                        <div id="collapseInsumos" class="accordion-collapse collapse <?php echo (in_array($activeRoute, ['insumo', 'reporte'])) ? 'show' : ''; ?>" aria-labelledby="headingInsumos"
                            data-bs-parent="#accordionInsumos">
                            <div class="accordion-body p-0">
                                <?php if (rutaPermitida('insumo')): ?>
                                <a href="index.php?url=Insumo" class="nav-link py-2 ps-5 small <?php echo ($activeRoute === 'insumo' && ($_GET['type'] ?? 'list') === 'list') ? 'active' : ''; ?>">Inventario General</a>
                                <a href="index.php?url=Insumo&type=alertas" class="nav-link py-2 ps-5 small <?php echo ($activeRoute === 'insumo' && ($_GET['type'] ?? '') === 'alertas') ? 'active' : ''; ?>">Alertas de Stock</a>
                                <?php endif; ?>
                                <hr class="my-1 mx-3">
                                <span class="d-block ps-5 py-1 small text-muted fw-semibold">Reportes</span>
                                <?php if (rutaPermitida('reporte')): ?>
                                <a href="index.php?url=Reporte&type=generate" class="nav-link py-2 ps-5 small <?php echo ($activeRoute === 'reporte' && ($_GET['type'] ?? '') === 'generate') ? 'active' : ''; ?>"><i class="bi bi-file-earmark-bar-graph me-1"></i> Generación de Reportes</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <?php endif; ?>

            <?php if (rutaPermitida('horarios') || rutaPermitida('laboratorio')): ?>
            <li class="nav-item">
                <div class="accordion sidebar-accordion" id="accordionHorarios">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingHorarios">
                            <button class="accordion-button <?php echo ($activeRoute === 'horarios') ? '' : 'collapsed'; ?>" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseHorarios" aria-expanded="<?php echo ($activeRoute === 'horarios') ? 'true' : 'false'; ?>" aria-controls="collapseHorarios">
                                <i class="bi bi-calendar3 me-2"></i> Horarios
                            </button>
                        </h2>
                        <div id="collapseHorarios" class="accordion-collapse collapse <?php echo ($activeRoute === 'horarios') ? 'show' : ''; ?>" aria-labelledby="headingHorarios"
                            data-bs-parent="#accordionHorarios">
                            <div class="accordion-body p-0">
                                <a href="index.php?url=Laboratorio&type=horarios" class="nav-link py-2 ps-5 small <?php echo ($activeRoute === 'horarios') ? 'active' : ''; ?>">Cronogramas Semanales</a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <?php endif; ?>

        </ul>
        <button class="btn btn-outline-danger p-0 ms-3 mt-3">
            <a href="index.php?url=Usuario&type=logout" class="nav-link">
                <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
            </a>
        </button>
    </nav>
