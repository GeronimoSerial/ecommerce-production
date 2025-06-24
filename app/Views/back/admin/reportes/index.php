<?php
$stats = $stats ?? [];
$productosPorCategoria = $productosPorCategoria ?? [];
?>

<div class="bg-light min-vh-100" style="padding-top: 76px;">
    <div class="container py-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-dark">Reportes y Estadísticas</h1>
                        <p class="text-muted mb-0">Análisis detallado del sistema</p>
                    </div>
                    <div>
                        <a href="<?= base_url('admin') ?>" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estadísticas Generales -->
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
                        <i class="bi bi-exclamation-triangle text-danger" style="font-size: 2.5rem;"></i>
                        <h3 class="mt-3 mb-1"><?= $stats['sinStock'] ?></h3>
                        <p class="text-muted mb-0">Sin Stock</p>
                    </div>
                </div>
            </div>


            <!-- Gráficos y Análisis -->
            <div class="row">
                <!-- Productos por Categoría -->
                <div class="col-md-6 mt-3 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="bi bi-pie-chart"></i> Productos por Categoría</h5>
                        </div>
                        <div class="card-body">
                            <?php if (empty($productosPorCategoria)): ?>
                                <div class="text-center py-4">
                                    <i class="bi bi-inbox text-muted" style="font-size: 2rem;"></i>
                                    <p class="text-muted mt-2 mb-0">No hay datos disponibles</p>
                                </div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Categoría</th>
                                                <th>Tipos de Producto </th>
                                                <th>Porcentaje</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $totalProductos = array_sum(array_column($productosPorCategoria, 'total'));
                                            foreach ($productosPorCategoria as $categoria):
                                                $porcentaje = $totalProductos > 0 ? round(($categoria['total'] / $totalProductos) * 100, 1) : 0;
                                                ?>
                                                <tr>
                                                    <td><?= $categoria['categoria'] ?></td>
                                                    <td>
                                                        <span class=" badge bg-primary"><?= $categoria['total'] ?></span>
                                                    </td>
                                                    <td>
                                                        <div class="progress" style="height: 20px;">
                                                            <div class="progress-bar bg-primary"
                                                                style="width: <?= $porcentaje ?>%">
                                                                <?= $porcentaje ?>%
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- </div> -->
                <!-- Información Adicional -->
                <!-- <div class="row"> -->

                <div class="col-md-6 mt-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0"><i class="bi bi-exclamation-triangle"></i> Alertas del Sistema</h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <?php if (($stats['cantidadBajo'] || $stats['sinStock'] ?? 0) > 0): ?>
                                    <div class="list-group-item border-0 px-0">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1 text-danger">Sin Stock</h6>
                                            <small class="text-muted">ATENCIÓN</small>
                                        </div>
                                        <p class="mb-1 text-muted"><?= $stats['sinStock'] ?> productos sin stock </p>
                                    </div>
                                    <div class="list-group-item border-0 px-0">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1 text-warning">Stock Bajo</h6>
                                            <small class="text-muted">Crítico</small>
                                        </div>
                                        <p class="mb-1 text-muted"><?= $stats['cantidadBajo'] ?> productos con stock bajo
                                        </p>
                                    </div>
                                <?php else: ?>
                                    <div class="list-group-item border-0 px-0">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1 text-success">Sin Alertas</h6>
                                            <small class="text-muted">Normal</small>
                                        </div>
                                        <p class="mb-1 text-muted">Todos los productos tienen stock suficiente</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>