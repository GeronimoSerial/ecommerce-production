<!-- Hero Section -->
<div class="bg-dark text-white py-5 mt-2">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <span class="badge bg-primary text-white px-3 py-2 mb-2">BÚSQUEDA</span>
                <h1 class="display-5 fw-bold mb-3">Resultados de <span class="text-primary">Búsqueda</span></h1>
                <p class="lead">Encuentra los mejores suplementos que se adapten a tus necesidades.</p>
            </div>
            <div class="col-lg-6">
                <img src="<?= base_url('public/images/banners/gym_wallpaper.webp') ?>" alt="Búsqueda Banner"
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
                        <h5 class="mb-0"><i class="bi bi-funnel me-2"></i>Filtros</h5>
                    </div>
                    <div class="card-body">
                        <?php
                        $stats = [
                            'precioMinimo' => $precioMinimo,
                            'precioMaximo' => $precioMaximo
                        ];
                        echo generate_filter_form($filtros, $categorias, $stats, current_url());
                        ?>
                    </div>
                </div>
            </div>

            <!-- Buscador y Productos -->
            <div class="col-lg-9">
                <!-- Header con información y controles -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="mb-1">Resultados de búsqueda</h4>
                        <p class="text-muted mb-0">
                            <?php
                            // Calcular productos mostrados en esta página
                            $productosEnPagina = count($productos);
                            $inicioProductos = ($paginacion['paginaActual'] - 1) * $paginacion['productosPorPagina'] + 1;
                            $finProductos = $inicioProductos + $productosEnPagina - 1;
                            ?>
                            <?php if (!empty($busqueda)): ?>
                                Búsqueda: "<strong><?= htmlspecialchars($busqueda) ?></strong>" -
                            <?php endif; ?>
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
                        <i class="bi bi-search fs-1 text-muted mb-3"></i>
                        <h4 class="text-muted">No se encontraron productos</h4>
                        <p class="text-muted">
                            <?php if (!empty($busqueda)): ?>
                                No encontramos productos que coincidan con
                                "<strong><?= htmlspecialchars($busqueda) ?></strong>".
                            <?php endif; ?>
                            Intenta ajustar los filtros de búsqueda.
                        </p>
                        <a href="<?= base_url('buscar') ?>" class="btn btn-primary">Nueva Búsqueda</a>
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
                                        <span class="badge bg-primary mb-2">
                                            <?php
                                            // Obtener nombre de categoría
                                            $categoriaNombre = 'Producto';
                                            foreach ($categorias as $cat) {
                                                if ($cat['id_categoria'] == $producto['id_categoria']) {
                                                    $categoriaNombre = $cat['nombre'];
                                                    break;
                                                }
                                            }
                                            echo $categoriaNombre;
                                            ?>
                                        </span>
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
                                                <button class="btn btn-outline-secondary" type="button" onclick="cambiarCantidad(-1, <?= $producto['id_producto'] ?>)">
                                                    <i class="bi bi-dash"></i>
                                                </button>
                                                <input type="number" class="form-control text-center" id="cantidad-producto-<?= $producto['id_producto'] ?>" value="1" min="1" max="<?= $producto['cantidad'] ?>">
                                                <button class="btn btn-outline-secondary" type="button" onclick="cambiarCantidad(1, <?= $producto['id_producto'] ?>)">
                                                    <i class="bi bi-plus"></i>
                                                </button>
                                            </div>
                                            <button class="btn btn-primary w-100 mb-2" onclick="agregarAlCarrito(<?= $producto['id_producto'] ?>)">Agregar al Carrito</button>
                                            <button class="btn btn-outline-primary w-100 mb-2" onclick="comprarAhora(<?= $producto['id_producto'] ?>)">Comprar Ahora</button>
                                        <?php else: ?>
                                            <button class="btn btn-secondary w-100 mb-2" disabled>Agotado</button>
                                            <button class="btn btn-outline-primary w-100 mb-2" onclick="notificarDisponibilidad(<?= $producto['id_producto'] ?>)">Notificar cuando esté disponible</button>
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
                                <?= generate_pagination($paginacion, $filtros, current_url()) ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<script src="<?= base_url('public/js/cart.js') ?>"></script>