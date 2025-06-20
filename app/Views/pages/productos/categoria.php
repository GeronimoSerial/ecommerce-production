<!-- Hero Section -->
<div class="bg-dark text-white py-5 mt-2">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <span class="badge bg-danger text-white px-3 py-2 mb-2"><?= strtoupper($categoria['nombre']) ?></span>
                <h1 class="display-5 fw-bold mb-3">Suplementos de <span
                        class="text-danger"><?= $categoria['nombre'] ?></span></h1>
                <p class="lead">Los mejores productos de <?= strtolower($categoria['nombre']) ?> para potenciar tu
                    rendimiento y alcanzar tus objetivos fitness.</p>
            </div>
            <div class="col-lg-6">
                <img src="<?= safe_banner_url($categoria['nombre']) ?>" alt="<?= $categoria['nombre'] ?> Banner"
                    class="img-fluid rounded-4">
            </div>
        </div>
    </div>
</div>

<!-- Productos Section -->
<section class="py-5 bg-light">
    <div class="container">
        <!-- Contenedor principal con sidebar y productos -->
        <div class="row g-4">
            <!-- Sidebar con filtros -->
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-search me-2"></i>Buscador</h5>
                    </div>
                    <div class="card-body">
                        <?php
                        $stats = [
                            'precioMinimo' => $precioMinimo,
                            'precioMaximo' => $precioMaximo
                        ];
                        echo view('templates/buscador', [
                            'filtros' => $filtros,
                            'stats' => $stats,
                            'baseUrl' => current_url()
                        ]);
                        ?>
                    </div>
                </div>
            </div>

            <!-- Buscador y Productos -->
            <div class="col-lg-9">
                <!-- Header con información y controles -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="mb-1"><?= $categoria['nombre'] ?></h4>
                        <p class="text-muted mb-0">
                            <?php
                            // Calcular productos mostrados en esta página
                            $productosEnPagina = count($productos);
                            $inicioProductos = ($paginacion['paginaActual'] - 1) * $paginacion['productosPorPagina'] + 1;
                            $finProductos = $inicioProductos + $productosEnPagina - 1;
                            ?>
                            <?php if ($productosEnPagina > 0): ?>
                                Mostrando <?= $inicioProductos ?>-<?= $finProductos ?> de <?= $totalProductos ?> productos
                            <?php else: ?>
                                Mostrando 0 de <?= $totalProductos ?> productos
                            <?php endif; ?>
                            <?php if ($paginacion['totalPaginas'] > 1): ?>
                                (Página <?= $paginacion['paginaActual'] ?> de <?= $paginacion['totalPaginas'] ?>)
                            <?php endif; ?>
                        </p>
                    </div>
                    <div class="d-flex gap-2">
                        <?= generate_sort_links($filtros, current_url()) ?>
                    </div>
                </div>

                <?php if (empty($productos)): ?>
                    <!-- Mensaje cuando no hay productos -->
                    <div class="text-center py-5">
                        <i class="bi bi-box-seam fs-1 text-muted mb-3"></i>
                        <h4 class="text-muted">No se encontraron productos</h4>
                        <p class="text-muted">
                            <?php if (!empty($filtros['busqueda']) || !empty($filtros['precioMin']) || !empty($filtros['precioMax'])): ?>
                                Intenta ajustar los filtros de búsqueda.
                            <?php else: ?>
                                Pronto tendremos productos de <?= strtolower($categoria['nombre']) ?> disponibles.
                            <?php endif; ?>
                        </p>
                        <?php if (!empty($filtros['busqueda']) || !empty($filtros['precioMin']) || !empty($filtros['precioMax'])): ?>
                            <a href="<?= current_url() ?>" class="btn btn-primary">Limpiar Filtros</a>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <!-- Grid de Productos -->
                    <div class="row g-3">
                        <?php foreach ($productos as $producto): ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="p-4 bg-white rounded-4 shadow-sm hover-card text-center h-100 d-flex flex-column">
                                    <div class="card-img-wrapper mb-3">
                                        <?= safe_product_image($producto, 'small') ?>
                                    </div>
                                    <div class="mb-3">
                                        <span class="badge bg-primary mb-2"><?= $categoria['nombre'] ?></span>
                                        <h5 class="fw-semibold mb-2"><?= $producto['nombre'] ?></h5>
                                        <p class="text-muted small mb-2"><?= $producto['descripcion'] ?></p>
                                        <p class="text-success fw-bold mb-0">$
                                            <?= number_format($producto['precio'], 0, ',', '.') ?>
                                        </p>
                                        <?php if ($producto['cantidad'] <= 5 && $producto['cantidad'] > 0): ?>
                                            <small class="text-warning">¡Solo quedan <?= $producto['cantidad'] ?> unidades!</small>
                                        <?php elseif ($producto['cantidad'] == 0): ?>
                                            <small class="text-danger">Agotado</small>
                                        <?php endif; ?>
                                    </div>
                                    <div class="mt-auto">
                                        <?php if ($producto['cantidad'] > 0): ?>
                                            <div class="input-group mb-2" style="width: 130px; margin: 0 auto;">
                                                <button class="btn btn-outline-secondary" type="button"
                                                    onclick="cambiarCantidad(-1, <?= $producto['id_producto'] ?>)">
                                                    <i class="bi bi-dash"></i>
                                                </button>
                                                <input type="number" class="form-control text-center"
                                                    id="cantidad-producto-<?= $producto['id_producto'] ?>" value="1" min="1"
                                                    max="<?= $producto['cantidad'] ?>">
                                                <button class="btn btn-outline-secondary" type="button"
                                                    onclick="cambiarCantidad(1, <?= $producto['id_producto'] ?>)">
                                                    <i class="bi bi-plus"></i>
                                                </button>
                                            </div>
                                            <button class="btn btn-primary w-100 mb-2"
                                                onclick="agregarAlCarrito(<?= $producto['id_producto'] ?>)">Agregar al
                                                Carrito</button>
                                            <button class="btn btn-outline-primary w-100 mb-2"
                                                onclick="comprarAhora(<?= $producto['id_producto'] ?>)">Comprar Ahora</button>
                                        <?php else: ?>
                                            <button class="btn btn-secondary w-100 mb-2" disabled>Agotado</button>
                                            <button class="btn btn-outline-primary w-100 mb-2"
                                                onclick="notificarDisponibilidad(<?= $producto['id_producto'] ?>)">Notificar cuando
                                                esté disponible</button>
                                        <?php endif; ?>
                                        <a href="<?= base_url('producto/' . $producto['id_producto']) ?>"
                                            class="text-primary text-decoration-none small">
                                            Ver Detalles
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Paginación -->
                    <?php if ($paginacion['totalPaginas'] > 1): ?>
                        <div class="row mt-5">
                            <div class="col-12">
                                <?= view('templates/paginacion', [
                                    'paginacion' => $paginacion,
                                    'filtros' => $filtros,
                                    'baseUrl' => current_url()
                                ]) ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Beneficios Section -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">¿Por qué elegir nuestras <span
                class="text-danger"><?= $categoria['nombre'] ?></span>?</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="text-center">
                    <i class="bi bi-shield-check fs-1 text-danger mb-3"></i>
                    <h5 class="fw-bold">Calidad Premium</h5>
                    <p class="text-muted">Productos certificados y de la más alta calidad del mercado</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <i class="bi bi-trophy fs-1 text-danger mb-3"></i>
                    <h5 class="fw-bold">Resultados Garantizados</h5>
                    <p class="text-muted">Fórmulas probadas científicamente para maximizar tus resultados</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <i class="bi bi-heart fs-1 text-danger mb-3"></i>
                    <h5 class="fw-bold">Sabor Inigualable</h5>
                    <p class="text-muted">Deliciosos sabores que harán que quieras más</p>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="<?= base_url('public/js/cart.js') ?>"></script>