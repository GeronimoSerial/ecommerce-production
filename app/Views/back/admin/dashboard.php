<?php
$nombre = $nombre ?? '';
$stats = $stats ?? [];
?>

<div class="bg-light min-vh-100" style="padding-top: 76px;">
    <div class="container py-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-dark">Panel de Administración</h1>
                        <p class="text-muted mb-0">Bienvenido, <?= $nombre ?></p>
                    </div>
                    <div>
                        <span class="badge bg-primary fs-6">Administrador</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estadísticas Principales -->
        <div class="mb-6">

            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="bi bi-people text-primary" style="font-size: 2.5rem;"></i>
                            <h3 class="mt-3 mb-1"><?= $stats['totalUsuarios'] ?? 0 ?></h3>
                            <p class="text-muted mb-0"> Usuarios</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="bi bi-box-seam text-success" style="font-size: 2.5rem;"></i>
                            <h3 class="mt-3 mb-1"><?= $stats['totalProductos'] ?? 0 ?></h3>
                            <p class="text-muted mb-0"> Productos</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="bi bi-receipt text-warning" style="font-size: 2.5rem;"></i>
                            <h3 class="mt-3 mb-1"><?= $stats['totalVentas'] ?? 0 ?></h3>
                            <p class="text-muted mb-0"> Ventas</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="bi bi-exclamation-triangle text-warning" style="font-size: 2.5rem;"></i>
                            <h3 class="mt-3 mb-1"><?= $stats['cantidadBajo'] ?? 0 ?></h3>
                            <p class="text-muted mb-0">Productos con Stock Bajo</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Accesos Rápidos -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="bi bi-lightning"></i> Accesos Rápidos</h5>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <a href="<?= base_url('admin/usuarios') ?>" class="text-decoration-none">
                                        <div class="card border-0 bg-light h-100">
                                            <div class="card-body text-center accesos">
                                                <i class="bi bi-people text-primary" style="font-size: 2rem;"></i>
                                                <h6 class="mt-2 mb-0 text-dark">Gestión de Usuarios</h6>
                                                <small class="text-muted">Administrar usuarios del sistema</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="<?= base_url('admin/inventario') ?>" class="text-decoration-none">
                                        <div class="card border-0 bg-light h-100 accesos">
                                            <div class="card-body text-center">
                                                <i class="bi bi-box-seam text-success" style="font-size: 2rem;"></i>
                                                <h6 class="mt-2 mb-0 text-dark">Control de Inventario</h6>
                                                <small class="text-muted">Gestionar productos</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="<?= base_url('admin/ventas') ?>" class="text-decoration-none">
                                        <div class="card border-0 bg-light h-100 accesos">
                                            <div class="card-body text-center">
                                                <i class="bi bi-graph-up text-warning" style="font-size: 2rem;"></i>
                                                <h6 class="mt-2 mb-0 text-dark">Gestión de Ventas</h6>
                                                <small class="text-muted">Ver todas las ventas</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="<?= base_url('contacto/admin') ?>" class="text-decoration-none">
                                        <div class="card border-0 bg-light h-100 accesos">
                                            <div class="card-body text-center">
                                                <i class="bi bi-chat-dots text-info" style="font-size: 2rem;"></i>
                                                <h6 class="mt-2 mb-0 text-dark">Gestión de Contactos</h6>
                                                <small class="text-muted">Gestionar mensajes de usuarios</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="<?= base_url('/') ?>" class="text-decoration-none">
                                        <div class="card border-0 bg-light h-100 accesos">
                                            <div class="card-body text-center">
                                                <i class="bi bi-house text-warning" style="font-size: 2rem;"></i>
                                                <h6 class="mt-2 mb-0 text-dark">Ir al Sitio</h6>
                                                <small class="text-muted">Ver sitio web público</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Estadísticas de Contactos -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="bi bi-chat-dots"></i> Estadísticas de Contactos</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <i class="bi bi-envelope text-warning" style="font-size: 2rem;"></i>
                                        <h4 class="mt-2 mb-1"><?= $stats['contactosNoLeidos'] ?? 0 ?></h4>
                                        <p class="text-muted mb-0">Nuevos mensajes</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <i class="bi bi-question-circle text-danger" style="font-size: 2rem;"></i>
                                        <h4 class="mt-2 mb-1"><?= $stats['contactosNoRespondidos'] ?? 0 ?></h4>
                                        <p class="text-muted mb-0">Sin Responder</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <i class="bi bi-calendar-day text-success" style="font-size: 2rem;"></i>
                                        <h4 class="mt-2 mb-1"><?= $stats['contactosHoy'] ?? 0 ?></h4>
                                        <p class="text-muted mb-0">Contactos Hoy</p>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <a href="<?= base_url('contacto/admin') ?>" class="btn btn-info">
                                    <i class="bi bi-arrow-right me-2"></i>Gestionar Mensajes
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




            <style>
                .accesos:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3) !important;
                }
            </style>