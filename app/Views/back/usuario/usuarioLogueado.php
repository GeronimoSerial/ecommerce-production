<?php
$nombre = $nombre ?? '';
$perfil = $perfil ?? 2;
?>

<div class="bg-dark text-light min-vh-100" style="padding-top: 76px;">
    <div class="container py-5">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <?php if ($perfil == 1): ?>
                    <div class="card bg-gradient border-0 shadow-lg">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4">
                                <i class="bi bi-shield-check fs-1 text-primary me-3"></i>
                                <div>
                                    <h4 class="card-title mb-0">Panel de Administrador</h4>
                                    <p class="text-muted mb-0">Acceso Total al Sistema</p>
                                </div>
                            </div>
                            <div class="welcome-message">
                                <h2 class="h4 mb-3">¡Bienvenido, <span class="text-primary"><?php echo $nombre; ?></span>!
                                </h2>
                                <p class="card-text">Como administrador, tienes acceso completo a todas las funciones del
                                    sistema:</p>
                                <ul class="list-unstyled">
                                    <li><i class="bi bi-check2-circle text-success me-2"></i>Gestión de usuarios</li>
                                    <li><i class="bi bi-check2-circle text-success me-2"></i>Control de inventario</li>
                                    <li><i class="bi bi-check2-circle text-success me-2"></i>Reportes y estadísticas</li>
                                </ul>
                            </div>
                            <div class="mt-4 text-end">
                                <a href="<?= base_url('admin') ?>" class="btn btn-primary">Panel de Administración</a>
                            </div>
                        </div>
                    </div>
                <?php elseif ($perfil == 2): ?>
                    <div class="card bg-gradient border-0 shadow-lg">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4">
                                <i class="bi bi-person-circle fs-1 text-primary me-3"></i>
                                <div>
                                    <h4 class="card-title mb-0">Mi Perfil</h4>
                                    <p class="text-muted mb-0">Área Personal</p>
                                </div>
                            </div>
                            <div class="welcome-message">
                                <h2 class="h4 mb-3">¡Bienvenido de nuevo, <span
                                        class="text-primary"><?php echo $nombre; ?></span>!</h2>
                                <p class="card-text">Accede a tu área personal y descubre todo lo que tenemos para ti:</p>
                                <div class="row g-4 mt-3">
                                    <div class="col-6">
                                        <div class="p-3 border rounded text-center">
                                            <i class="bi bi-cart3 fs-2 text-primary"></i>
                                            <h5 class="mt-2">Mis Compras</h5>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-3 border rounded text-center">
                                            <i class="bi bi-heart fs-2 text-danger"></i>
                                            <h5 class="mt-2">Favoritos</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="text-end mt-3">
                    <a href="<?= base_url('actualizar') ?>" class="btn btn-outline-primary">Editar mis datos
                        personales</a>
                </div>

                <div class="text-center mt-4">
                    <p class="small text-muted">
                        <i class="bi bi-code-slash me-1"></i>
                        Desarrollado por Geronimo Serial
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>