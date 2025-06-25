<?php
$session = session();
$nombre = $session->get('nombre');
$perfil = $session->get('id_rol');
$apellido = $session->get('apellido');
?>



<nav class="navbar navbar-expand-lg navbar-light bg-white py-2 py-lg-3 fixed-top">
    <div class="container">
        <a class="navbar-brand d-flex justify-content-between align-items-center order-lg-0"
            href="<?= base_url('/') ?>">
            <img src="<?= base_url('images/workoutIcon.png') ?>" alt="site icon" class="img-fluid"
                style="max-height: 40px;">
            <span class="fw-bold ms-2">FITSYN</span>
        </a>

        <div class="order-lg-2 nav-btns d-flex align-items-center">
            <button type="button" class="btn position-relative me-2 me-lg-3" onclick="abrirCarrito()">
                <i class="bi bi-cart text-dark"></i>
                <span class="position-absolute top-0 start-100 translate-middle hidden" id="cart-count">0</span>
            </button>
            <button type="button" class="btn position-relative me-2 me-lg-3" onclick="toggleSearch()">
                <i class="bi bi-search text-dark"></i>
            </button>

            <?php if (isset($nombre)): ?>
                <div class="dropdown">
                    <button class="btn btn-outline-dark dropdown-toggle" type="button" id="userDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-1"></i>
                        <?= $nombre ?>     <?= isset($apellido) && $apellido ? ' ' . $apellido : '' ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <?php if ($perfil == 1): ?>
                            <li><a class="dropdown-item" href="<?= base_url('panel') ?>"><i class="bi bi-house me-2"></i>Panel
                                    Admin</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('admin/ventas') ?>">
                                    <i class="bi bi-graph-up me-2"></i>Gestión de Ventas
                                </a></li>
                            <li><a class="dropdown-item" href="<?= base_url('contacto/admin') ?>">
                                    <i class="bi bi-chat-dots me-2"></i>Gestión de Mensajes
                                </a></li>
                            <li><a class="dropdown-item" href="<?= base_url('panel/mis-facturas') ?>">
                                    <i class="bi bi-receipt me-2"></i>Mis Facturas
                                </a></li>
                        <?php else: ?>
                            <li><a class="dropdown-item" href="<?= base_url('panel') ?>">Mi Perfil</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('panel/mis-facturas') ?>">
                                    <i class="bi bi-receipt me-2"></i>Mis Facturas
                                </a></li>
                            <li><a class="dropdown-item" href="<?= base_url('contacto/mis-contactos') ?>">
                                    <i class="bi bi-chat-dots me-2"></i>Mis Mensajes
                                </a></li>
                        <?php endif; ?>
                        <li><a class="dropdown-item" href="<?= base_url('actualizar') ?>"><i
                                    class="bi bi-person me-2"></i>Mis datos personales</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="<?= base_url('logout') ?>">Cerrar Sesión</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <a href="<?= base_url('login') ?>" class="btn btn-outline-dark btn-sm">
                    <i class="fas fa-user me-1"></i>Iniciar Sesión
                </a>
            <?php endif; ?>
        </div>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse order-lg-1" id="navMenu">
            <ul class="navbar-nav mx-auto text-center">
                <li class="nav-item px-2 py-2">
                    <a class="nav-link text-dark" href="<?= base_url('/') ?>">INICIO</a>
                </li>
                <li class="nav-item dropdown px-2 py-2">
                    <a class="nav-link text-dark dropdown-toggle" href="#" id="productosDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        PRODUCTOS
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="productosDropdown">
                        <li><a class="dropdown-item" href="<?= base_url('categoria/proteinas') ?>">
                                <i class="bi bi-capsule me-2 text-danger"></i>Proteínas
                            </a></li>
                        <li><a class="dropdown-item" href="<?= base_url('categoria/creatinas') ?>">
                                <i class="bi bi-lightning me-2 text-danger"></i>Creatinas
                            </a></li>
                        <li><a class="dropdown-item" href="<?= base_url('categoria/colagenos') ?>">
                                <i class="bi bi-heart-pulse me-2 text-danger"></i>Colágenos
                            </a></li>
                        <li><a class="dropdown-item" href="<?= base_url('categoria/accesorios') ?>">
                                <i class="bi bi-gear me-2 text-danger"></i>Accesorios
                            </a></li>

                    </ul>
                </li>
                <li class="nav-item px-2 py-2">
                    <a class="nav-link text-dark" href="<?= base_url('/comercializacion') ?>">COMERCIALIZACIÓN</a>
                </li>
                <li class="nav-item px-2 py-2">
                    <a class="nav-link text-dark" href="<?= base_url('/nosotros') ?>">NOSOTROS</a>
                </li>
                <li class="nav-item px-2 py-2">
                    <a class="nav-link text-dark" href="<?= base_url('/contacto') ?>">CONTACTO</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<?php
// Obtener la URI actual
$request = service('request');
$currentPath = $request->getPath();

// Usar base_url() para asegurar que se incluya la ruta base completa
$buscarBase = base_url('productos/buscar');
?>

<div class="search-overlay" id="searchOverlay" style="display: none;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <form action="<?= $buscarBase ?>" method="GET" class="search-form">
                    <div class="input-group input-group-lg">
                        <input type="text" name="q" value="<?= $_GET['q'] ?? '' ?>" class="form-control"
                            placeholder="Buscar productos, categorías..." autocomplete="off" id="searchInput">
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="toggleSearch()">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </form>


                <div class="search-suggestions mt-3">
                    <h6 class="text-white mb-2">Búsquedas populares:</h6>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="button" onclick="setSearchTerm('whey')"
                            class="badge bg-light text-dark text-decoration-none border-0">Whey Protein</button>
                        <button type="button" onclick="setSearchTerm('creatina')"
                            class="badge bg-light text-dark text-decoration-none border-0">Creatina</button>
                        <button type="button" onclick="setSearchTerm('colageno')"
                            class="badge bg-light text-dark text-decoration-none border-0">Colágeno</button>
                        <button type="button" onclick="setSearchTerm('shaker')"
                            class="badge bg-light text-dark text-decoration-none border-0">Shaker</button>
                        <button type="button" onclick="setSearchTerm('proteina vegana')"
                            class="badge bg-light text-dark text-decoration-none border-0">Proteína Vegana</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>