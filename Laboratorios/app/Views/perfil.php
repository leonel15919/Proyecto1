<?php
$successMessage = '';
if (isset($_SESSION['success_message'])) {
    $successMessage = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}
?>

<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-1">Perfil de Usuario</h2>
            <p class="text-muted small mb-0">Gestiona tu información de cuenta institucional</p>
        </div>
        <a href="index.php?url=Home" class="btn btn-outline-secondary d-flex align-items-center gap-2">
            <i class="bi bi-arrow-left"></i>
            <span>Volver al Inicio</span>
        </a>
    </div>

    <?php if (!empty($successMessage)): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm d-flex align-items-center gap-3 mb-4" role="alert" style="border-left: 5px solid #198754 !important; border-radius: 8px;">
            <i class="bi bi-check-circle-fill text-success fs-4"></i>
            <div>
                <strong class="d-block text-success-emphasis">Operación Exitosa</strong>
                <span class="small text-muted"><?php echo htmlspecialchars($successMessage); ?></span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <div class="col-lg-4 col-xl-3">
            <div class="card border-0 shadow-sm text-center p-4 h-100 position-relative overflow-hidden" style="border-radius: 16px !important;">
                <div class="position-absolute top-0 start-0 w-100" style="height: 100px; background: linear-gradient(135deg, #025abb 0%, #036ee3 100%); z-index: 1;"></div>
                
                <div class="position-relative mb-3 mt-4" style="z-index: 2;">
                    <div class="d-inline-block position-relative">
                        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['user_nombre']); ?>&background=ffffff&color=025abb&size=120&bold=true" 
                             class="rounded-circle shadow-sm border border-4 border-white img-thumbnail" 
                             alt="Avatar" style="width: 120px; height: 120px; object-fit: cover;">
                        <span class="position-absolute bottom-0 end-0 bg-success border border-3 border-white rounded-circle" 
                              style="width: 20px; height: 20px;" title="Online"></span>
                    </div>
                </div>

                <div class="mb-4">
                    <h5 class="fw-bold text-dark mb-1"><?php echo htmlspecialchars($_SESSION['user_nombre']); ?></h5>
                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-1.5 rounded-pill mb-2 small fw-semibold">
                        <i class="bi bi-shield-check me-1"></i><?php echo htmlspecialchars($_SESSION['user_rol']); ?>
                    </span>
                    <p class="text-muted small mb-0"><i class="bi bi-building me-1"></i><?php echo htmlspecialchars($_SESSION['user_depto']); ?></p>
                </div>

                <hr class="text-muted opacity-25">

                <div class="row g-2 my-2 text-start">
                    <div class="col-6">
                        <div class="p-3 bg-light rounded-3 text-center border border-light">
                            <span class="d-block fw-bold text-dark fs-5">42</span>
                            <span class="text-muted small" style="font-size: 0.75rem;">Prácticas</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 bg-light rounded-3 text-center border border-light">
                            <span class="d-block fw-bold text-dark fs-5">18</span>
                            <span class="text-muted small" style="font-size: 0.75rem;">Solicitudes</span>
                        </div>
                    </div>
                </div>

                <hr class="text-muted opacity-25">

                <div class="text-start mt-3">
                    <p class="mb-2 text-dark small"><i class="bi bi-person me-2 text-primary"></i><strong>Usuario:</strong> <?php echo htmlspecialchars($_SESSION['user_username']); ?></p>
                    <p class="mb-2 text-dark small"><i class="bi bi-card-text me-2 text-primary"></i><strong>C.I.:</strong> <?php echo htmlspecialchars($_SESSION['user_ci']); ?></p>
                    <p class="mb-0 text-dark small"><i class="bi bi-clock me-2 text-primary"></i><strong>Último Acceso:</strong> <?php echo htmlspecialchars($_SESSION['ultimo_acceso'] ?? 'No registrado'); ?></p>
                </div>
            </div>
        </div>

        <div class="col-lg-8 col-xl-9">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px !important; overflow: hidden;">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold text-dark mb-0"><i class="bi bi-person-fill me-2 text-primary"></i>Información Personal</h5>
                </div>
                
                <div class="card-body p-4">
                    <p class="text-muted small mb-4">Datos personales y de contacto institucional registrados en el sistema de gestión de laboratorios.</p>

                    <form action="index.php?url=Usuario&type=perfil" method="POST">
                        <input type="hidden" name="update_profile" value="1">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label text-dark small fw-medium">Nombre Completo</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-muted"></i></span>
                                    <input type="text" class="form-control border-start-0" id="nombre" name="nombre" 
                                           value="<?php echo htmlspecialchars($_SESSION['user_nombre']); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="correo" class="form-label text-dark small fw-medium">Correo Electrónico Institucional</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-muted"></i></span>
                                    <input type="email" class="form-control border-start-0" id="correo" name="correo" 
                                           value="<?php echo htmlspecialchars($_SESSION['user_correo']); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="telefono" class="form-label text-dark small fw-medium">Teléfono / Celular</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-telephone text-muted"></i></span>
                                    <input type="text" class="form-control border-start-0" id="telefono" name="telefono" 
                                           value="<?php echo htmlspecialchars($_SESSION['user_telefono']); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="ci" class="form-label text-dark small fw-medium">Cédula de Identidad (C.I.)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-card-text text-muted"></i></span>
                                    <input type="text" class="form-control border-start-0" id="ci" name="ci" 
                                           value="<?php echo htmlspecialchars($_SESSION['user_ci']); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-dark small fw-medium">Nombre de Usuario</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-shield-lock text-muted"></i></span>
                                    <input type="text" class="form-control border-start-0" 
                                           value="<?php echo htmlspecialchars($_SESSION['user_username']); ?>" readonly style="background-color: #f8f9fa;">
                                </div>
                                <span class="text-muted" style="font-size: 0.75rem;">El nombre de usuario institucional no puede ser modificado.</span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-dark small fw-medium">Departamento Académico</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-building text-muted"></i></span>
                                    <input type="text" class="form-control border-start-0" 
                                           value="<?php echo htmlspecialchars($_SESSION['user_depto']); ?>" readonly style="background-color: #f8f9fa;">
                                </div>
                                <span class="text-muted" style="font-size: 0.75rem;">Para cambiar de departamento, contacta al administrador de red.</span>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 text-end border-top border-light">
                            <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-2" style="background-color: #025abb; border-color: #025abb;">
                                <i class="bi bi-save"></i>
                                <span>Guardar Cambios</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
