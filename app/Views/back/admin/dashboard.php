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
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-people text-primary" style="font-size: 2.5rem;"></i>
                        <h3 class="mt-3 mb-1"><?= $stats['totalUsuarios'] ?? 0 ?></h3>
                        <p class="text-muted mb-0">Total Usuarios</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-box-seam text-success" style="font-size: 2.5rem;"></i>
                        <h3 class="mt-3 mb-1"><?= $stats['totalProductos'] ?? 0 ?></h3>
                        <p class="text-muted mb-0">Total Productos</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-exclamation-triangle text-warning" style="font-size: 2.5rem;"></i>
                        <h3 class="mt-3 mb-1"><?= $stats['cantidadBajo'] ?? 0 ?></h3>
                        <p class="text-muted mb-0">Stock Bajo</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-person-plus text-info" style="font-size: 2.5rem;"></i>
                        <h3 class="mt-3 mb-1"><?= $stats['usuariosEsteMes'] ?? 0 ?></h3>
                        <p class="text-muted mb-0">Usuarios Nuevos</p>
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
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <a href="<?= base_url('admin/usuarios') ?>" class="text-decoration-none">
                                    <div class="card border-0 bg-light h-100">
                                        <div class="card-body text-center">
                                            <i class="bi bi-people text-primary" style="font-size: 2rem;"></i>
                                            <h6 class="mt-2 mb-0 text-dark">Gestión de Usuarios</h6>
                                            <small class="text-muted">Administrar usuarios del sistema</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="<?= base_url('admin/inventario') ?>" class="text-decoration-none">
                                    <div class="card border-0 bg-light h-100">
                                        <div class="card-body text-center">
                                            <i class="bi bi-box-seam text-success" style="font-size: 2rem;"></i>
                                            <h6 class="mt-2 mb-0 text-dark">Control de Inventario</h6>
                                            <small class="text-muted">Gestionar productos</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="<?= base_url('admin/reportes') ?>" class="text-decoration-none">
                                    <div class="card border-0 bg-light h-100">
                                        <div class="card-body text-center">
                                            <i class="bi bi-graph-up text-info" style="font-size: 2rem;"></i>
                                            <h6 class="mt-2 mb-0 text-dark">Reportes</h6>
                                            <small class="text-muted">Ver estadísticas y reportes</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="<?= base_url('/') ?>" class="text-decoration-none">
                                    <div class="card border-0 bg-light h-100">
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

        <!-- Actividad Reciente -->
        <div class="row">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-clock-history"></i> Actividad Reciente</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item border-0 px-0">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Panel de administración accedido</h6>
                                    <small class="text-muted">Ahora</small>
                                </div>
                                <p class="mb-1 text-muted">Sesión iniciada correctamente</p>
                            </div>
                            <div class="list-group-item border-0 px-0">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Sistema operativo</h6>
                                    <small class="text-muted">Hace 5 min</small>
                                </div>
                                <p class="mb-1 text-muted">Todos los servicios funcionando correctamente</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="bi bi-gear"></i> Configuración del Sistema</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <small class="text-muted">Versión del Sistema</small>
                                    <div class="fw-bold">v1.0.0</div>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted">Estado de la Base de Datos</small>
                                    <div class="fw-bold text-success">Conectado</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <small class="text-muted">Última Actualización</small>
                                    <div class="fw-bold">Hoy</div>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted">Modo de Operación</small>
                                    <div class="fw-bold text-primary">Producción</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
</div> 