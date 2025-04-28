<?php
$session = session();
$nombre = $session->get('nombre');
$perfil = $session->get('perfil_id');
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
            <button type="button" class="btn position-relative me-2 me-lg-3">
                <i class="bi bi-cart text-dark"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge bg-danger rounded-pill">0</span>
            </button>
            <button type="button" class="btn position-relative me-2 me-lg-3">
                <i class="bi bi-search text-dark"></i>
            </button>

            <?php if (isset($nombre)): ?>
                <div class="dropdown">
                    <button class="btn btn-outline-dark dropdown-toggle" type="button" id="userDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-1"></i>
                        <?= $nombre ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <?php if ($perfil == 1): ?>
                            <li><a class="dropdown-item" href="<?= base_url('panel') ?>">Panel Admin</a></li>
                        <?php else: ?>
                            <li><a class="dropdown-item" href="<?= base_url('panel') ?>">Mi Perfil</a></li>
                        <?php endif; ?>
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
                <li class="nav-item px-2 py-2">
                    <a class="nav-link text-dark" href="<?= base_url('#productos') ?>">PRODUCTOS</a>
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