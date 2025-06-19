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
            <img src="<?= base_url('public/images/workoutIcon.png') ?>" alt="site icon" class="img-fluid"
                style="max-height: 40px;">
            <span class="fw-bold ms-2">FITSYN</span>
        </a>

        <div class="order-lg-2 nav-btns d-flex align-items-center">
            <button type="button" class="btn position-relative me-2 me-lg-3" onclick="abrirCarrito()">
                <i class="bi bi-cart text-dark"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge bg-danger rounded-pill"
                    id="cart-count">0</span>
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
                            <li><a class="dropdown-item" href="<?= base_url('panel') ?>">Panel Admin</a></li>
                        <?php else: ?>
                            <li><a class="dropdown-item" href="<?= base_url('panel') ?>">Mi Perfil</a></li>
                        <?php endif; ?>
                        <li><a class="dropdown-item" href="<?= base_url('actualizar') ?>">Mis datos personales</a></li>
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
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="<?= base_url('productos/buscar') ?>">
                                <i class="bi bi-search me-2 text-primary"></i>Buscar Productos
                            </a></li>
                    </ul>
                </li>
                <li class="nav-item px-2 py-2">
                    <a class="nav-link text-dark" href="<?= base_url('/comercializacion') ?>">COMERCIALIZACIÓN</a>
                </li>
                <li class="nav-item px-2 py-2">
                    <a class="nav-link text-dark" href="<?= base_url('#nosotros') ?>">NOSOTROS</a>
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

// Determinar la URL base según la ruta actual
if (strpos($currentPath, 'productos') !== false) {
    $buscarBase = site_url('buscar');
} else {
    $buscarBase = site_url('productos/buscar');
}
?>

<div class="search-overlay" id="searchOverlay" style="display: none;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <form action="<?= $buscarBase ?>" method="GET" class="search-form">
                    <div class="input-group input-group-lg">
                        <input type="text" name="q" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>"
                            class="form-control" placeholder="Buscar productos, categorías..." autocomplete="off"
                            id="searchInput">
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
                        <a href="<?= $buscarBase . '?q=whey' ?>"
                            class="badge bg-light text-dark text-decoration-none">Whey Protein</a>
                        <a href="<?= $buscarBase . '?q=creatina' ?>"
                            class="badge bg-light text-dark text-decoration-none">Creatina</a>
                        <a href="<?= $buscarBase . '?q=colageno' ?>"
                            class="badge bg-light text-dark text-decoration-none">Colágeno</a>
                        <a href="<?= $buscarBase . '?q=shaker' ?>"
                            class="badge bg-light text-dark text-decoration-none">Shaker</a>
                        <a href="<?= $buscarBase . '?q=proteina+vegana' ?>"
                            class="badge bg-light text-dark text-decoration-none">Proteína Vegana</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    .search-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        background: linear-gradient(135deg, rgba(229, 52, 91, 0.95), rgba(0, 0, 0, 0.9));
        z-index: 1050;
        display: flex;
        align-items: center;
        animation: slideDown 0.3s ease-out;
    }

    .search-form .form-control {
        border: none;
        border-radius: 50px 0 0 50px;
        padding: 1rem 1.5rem;
        font-size: 1.1rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .search-form .btn {
        border-radius: 0;
        padding: 1rem 1.5rem;
        border: none;
    }

    .search-form .btn:last-child {
        border-radius: 0 50px 50px 0;
    }

    .search-suggestions {
        opacity: 0;
        animation: fadeInUp 0.5s ease-out 0.2s forwards;
    }

    @keyframes slideDown {
        from {
            transform: translateY(-100%);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .dropdown-menu {
        border: none;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        border-radius: 0.5rem;
    }

    .dropdown-item {
        padding: 0.75rem 1.5rem;
        transition: all 0.2s ease;
    }

    .dropdown-item:hover {
        background-color: rgba(229, 52, 91, 0.1);
        color: var(--pink);
        transform: translateX(5px);
    }

    .dropdown-item i {
        transition: transform 0.2s ease;
    }

    .dropdown-item:hover i {
        transform: scale(1.2);
    }

    @media (max-width: 768px) {
        .search-overlay {
            padding: 1rem;
        }

        .search-form .form-control {
            font-size: 1rem;
            padding: 0.75rem 1rem;
        }

        .search-suggestions .badge {
            font-size: 0.8rem;
        }
    }
</style>

<script>
    function toggleSearch() {
        const overlay = document.getElementById('searchOverlay');
        const searchInput = document.getElementById('searchInput');

        if (overlay.style.display === 'none') {
            overlay.style.display = 'flex';
            setTimeout(() => {
                searchInput.focus();
            }, 300);
            document.body.style.overflow = 'hidden';
        } else {
            overlay.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    }

    function abrirCarrito() {
        console.log('Abriendo carrito...');
        mostrarNotificacion('Carrito en desarrollo', 'info');
    }

    function mostrarNotificacion(mensaje, tipo) {
        const toast = document.createElement('div');
        toast.className = 'position-fixed top-0 end-0 p-3';
        toast.style.zIndex = '1060';

        const bgClass = tipo === 'success' ? 'bg-success' : tipo === 'info' ? 'bg-info' : 'bg-warning';

        toast.innerHTML = `
        <div class="toast show" role="alert">
            <div class="toast-header ${bgClass} text-white">
                <strong class="me-auto">Notificación</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                ${mensaje}
            </div>
        </div>
    `;
        document.body.appendChild(toast);

        setTimeout(() => {
            if (document.body.contains(toast)) {
                document.body.removeChild(toast);
            }
        }, 3000);
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            const overlay = document.getElementById('searchOverlay');
            if (overlay.style.display !== 'none') {
                toggleSearch();
            }
        }
    });

    function actualizarContadorCarrito(cantidad) {
        const contador = document.getElementById('cart-count');
        contador.textContent = cantidad;

        if (cantidad > 0) {
            contador.style.display = 'block';
        } else {
            contador.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        actualizarContadorCarrito(0);
    });
</script>