<?php
$productos = $productos ?? [];
$filtros = $filtros ?? [];
$paginacion = $paginacion ?? [];
$baseUrl = $baseUrl ?? base_url('admin/inventario');
$valorTotal = $valorTotal ?? 0;
$totalProductos = $totalProductos ?? 0;
$stockBajo = $stockBajo ?? 0;
$cantActivos = $cantActivos ?? 0
    ?>

<div class="bg-light min-vh-100" style="padding-top: 76px;">
    <div class="container py-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-dark">Control de Inventario</h1>
                        <p class="text-muted mb-0">Administra los productos del sistema</p>
                    </div>
                    <div>
                        <a href="<?= base_url('admin') ?>" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Volver
                        </a>
                        <a href="<?= base_url('admin/inventario/crear') ?>" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Nuevo Producto
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <!-- Tabla de Productos -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-box-seam"></i> Lista de Productos</h5>
                <div>
                    <?= view('templates/filtros', [
                        'filtros' => $filtros,
                        'baseUrl' => $baseUrl
                    ]) ?>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Imagen</th>
                                <th>Nombre</th>
                                <th>Categoría</th>
                                <th>Precio</th>
                                <th>Stock</th>
                                <th>Estado</th>
                                <th>Vendidos</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($productos)): ?>
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <i class="bi bi-inbox text-muted" style="font-size: 2rem;"></i>
                                        <p class="text-muted mt-2 mb-0">No hay productos registrados</p>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($productos as $producto): ?>
                                    <tr>
                                        <td><?= $producto['id_producto'] ?></td>
                                        <td>
                                            <?php if (!empty($producto['url_imagen'])): ?>
                                                <img src="<?= base_url('images/' . $producto['url_imagen']) ?>"
                                                    alt="<?= $producto['nombre'] ?>" class="img-thumbnail"
                                                    style="width: 50px; height: 50px; object-fit: cover;">
                                            <?php else: ?>
                                                <div class="bg-secondary d-flex align-items-center justify-content-center"
                                                    style="width: 50px; height: 50px;">
                                                    <i class="bi bi-image text-muted"></i>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div>
                                                <strong><?= $producto['nombre'] ?></strong>
                                                <br>
                                                <small
                                                    class="text-muted"><?= substr($producto['descripcion'], 0, 50) ?>...</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info"><?= $producto['categoria'] ?? 'Sin categoría' ?></span>
                                        </td>
                                        <td>
                                            <strong class="text-success">$<?= number_format($producto['precio'], 2) ?></strong>
                                        </td>
                                        <td>
                                            <?php if ($producto['cantidad'] <= 5): ?>
                                                <span class="badge bg-danger"><?= $producto['cantidad'] ?></span>
                                            <?php elseif ($producto['cantidad'] <= 10): ?>
                                                <span class="badge bg-warning text-dark"><?= $producto['cantidad'] ?></span>
                                            <?php else: ?>
                                                <span class="badge bg-success"><?= $producto['cantidad'] ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($producto['activo'] == 1): ?>
                                                <span class="badge bg-success">Activo</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Inactivo</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-dark"><?= $producto['cantidad_vendidos'] ?? 0 ?></span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="<?= base_url('admin/inventario/editar/' . $producto['id_producto']) ?>"
                                                    class="btn btn-sm btn-outline-primary" title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="<?= base_url('admin/inventario/eliminar/' . $producto['id_producto']) ?>"
                                                    class="btn btn-sm btn-outline-danger" title="Eliminar"
                                                    onclick="return confirm('¿Estás seguro de que quieres eliminar este producto?')">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Estadísticas Rápidas -->
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-box-seam text-primary" style="font-size: 2rem;"></i>
                        <h4 class="mt-2 mb-0"><?= $totalProductos ?></h4>
                        <p class="text-muted mb-0">Total Productos</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-exclamation-triangle text-warning" style="font-size: 2rem;"></i>
                        <h4 class="mt-2 mb-0">
                            <?= $stockBajo ?>
                        </h4>
                        <p class="text-muted mb-0">Stock Bajo</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-check-circle text-success" style="font-size: 2rem;"></i>
                        <h4 class="mt-2 mb-0">
                            <?= $cantActivos ?>
                        </h4>
                        <p class="text-muted mb-0">Activos</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-currency-dollar text-success" style="font-size: 2rem;"></i>
                        <h4 class="mt-2 mb-0">
                            $<?= number_format($valorTotal, 2) ?>
                        </h4>
                        <p class="text-muted mb-0">Valor Total del Inventario</p>
                        <small class="text-muted">(precio × cantidad de todos los productos)</small>
                    </div>
                </div>
            </div>

        </div>

        <!-- PAGINACIÓN -->
        <div class="mt-3">
            <?= view('templates/paginacion', [
                'paginacion' => $paginacion,
                'filtros' => $filtros,
                'baseUrl' => current_url()
            ]) ?>
        </div>
    </div>
</div>