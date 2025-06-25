<?php
$ventas = $ventas ?? [];
?>

<div class="bg-light min-vh-100" style="padding-top: 76px;">
    <div class="container py-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-dark">
                            <i class="bi bi-graph-up text-success"></i> Gestión de Ventas
                        </h1>
                        <p class="text-muted mb-0">Control y seguimiento de todas las ventas del sistema</p>
                    </div>
                    <div>
                        <a href="<?= base_url('admin') ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estadísticas Rápidas -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-receipt text-primary fs-1"></i>
                        <h4 class="mt-2"><?= count($ventas) ?></h4>
                        <p class="text-muted mb-0">Total de Ventas</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-currency-dollar text-success fs-1"></i>
                        <h4 class="mt-2"><?= format_currency(array_sum(array_column($ventas, 'importe_total'))) ?></h4>
                        <p class="text-muted mb-0">Ingresos Totales</p>
                    </div>
                </div>
            </div>
            <!-- <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-people text-info fs-1"></i>
                        <h4 class="mt-2"><?= count(array_unique(array_column($ventas, 'id_usuario'))) ?></h4>
                        <p class="text-muted mb-0">Clientes Únicos</p>
                    </div>
                </div>
            </div> -->
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-graph-up text-primary fs-1"></i>
                        <h4 class="mt-2 ">
                            <?= $stats['totalVentas'] > 0 ? format_currency(round(($stats['ingresosTotales'] / $stats['totalVentas']), 2)) : 0 ?>
                        </h4>
                        <p class="text-muted mb-0">Promedio por Venta</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Ventas -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0">
                <i class="bi bi-list-ul"></i> Lista de Ventas
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Número</th>
                            <th>Cliente</th>
                            <th>Email</th>
                            <th>Fecha</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($ventas)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                                    <h5 class="text-muted mt-3">No hay ventas registradas</h5>
                                    <p class="text-muted">Las ventas aparecerán aquí cuando los clientes realicen
                                        compras
                                    </p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($ventas as $venta): ?>
                                <tr>
                                    <td>
                                        <strong>#<?= $venta['id_factura'] ?></strong>
                                    </td>
                                    <td>
                                        <div>
                                            <strong><?= $venta['nombre'] ?>         <?= $venta['apellido'] ?></strong>
                                            <br>
                                            <small class="text-muted">ID: <?= $venta['id_usuario'] ?></small>
                                        </div>
                                    </td>
                                    <td>
                                        <i class="bi bi-envelope text-muted me-1"></i>
                                        <?= $venta['email'] ?>
                                    </td>
                                    <td>
                                        <i class="bi bi-calendar3 text-muted me-1"></i>
                                        <?= date('d/m/Y H:i', strtotime($venta['fecha_factura'])) ?>
                                    </td>
                                    <td class="text-center">
                                        <span class="fw-bold text-success">
                                            <?= format_currency($venta['importe_total']) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i>Completada
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('admin/venta/' . $venta['id_factura']) ?>"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i> Ver Detalle
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Información Adicional -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="bi bi-info-circle text-info"></i> Información de Ventas
                    </h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2">
                            <i class="bi bi-check2 text-success me-2"></i>
                            Todas las ventas están registradas automáticamente
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-graph-up text-primary me-2"></i>
                            Estadísticas en tiempo real
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-eye text-info me-2"></i>
                            Ver facturas virtuales disponibles
                        </li>
                        <li>
                            <i class="bi bi-shield-check text-success me-2"></i>
                            Sistema seguro y confiable
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="bi bi-gear text-warning"></i> Acciones Disponibles
                    </h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2">
                            <i class="bi bi-eye text-primary me-2"></i>
                            Ver detalles completos de cada venta
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-eye text-info me-2"></i>
                            Ver facturas virtuales individuales
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-file-earmark-text text-success me-2"></i>
                            Generar reportes de ventas
                        </li>
                        <li>
                            <i class="bi bi-graph-up text-warning me-2"></i>
                            Analizar tendencias de ventas
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
</div>