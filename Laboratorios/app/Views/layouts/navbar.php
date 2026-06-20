<div class="content-area">
    <nav class="navbar navbar-expand-lg top-navbar px-4 py-3 line-m">
        <div class="container-fluid p-0">
            <button type="button" id="sidebarCollapse" class="btn btn-outline-dark me-4">
                <i class="bi bi-list"></i>
            </button>
            <form class="d-none d-md-flex" role="search" action="index.php" method="GET">
                <input type="hidden" name="url" value="Insumo">
                <input type="hidden" name="type" value="list">
                <div class="input-group" style="width: 350px;">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input class="form-control border-start-0 ps-0" type="search" name="q"
                        placeholder="Buscar insumos..." aria-label="Search" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
                </div>
            </form>
            <div class="ms-auto d-flex align-items-center">
                <div class="me-3 position-relative cursor-pointer">
                    <i class="bi bi-bell fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                        style="font-size: 0.6rem;">
                        2
                    </span>
                </div>
                <div class="dropdown">
                    <button class="btn dropdown-toggle d-flex align-items-center gap-2" type="button"
                        data-bs-toggle="dropdown">
                        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['user_nombre'] ?? 'Admin'); ?>&background=0d6efd&color=fff"
                            class="rounded-circle" width="32">
                        <span><?php echo htmlspecialchars($_SESSION['user_nombre'] ?? 'Direccion'); ?></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="index.php?url=Usuario&type=perfil">Perfil</a></li>
                        <li><a class="dropdown-item" href="#">Ajustes</a></li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-danger" href="index.php?url=Usuario&type=logout">Salir</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div class="container-fluid p-4">
