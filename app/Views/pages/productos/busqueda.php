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
                <img src="<?= base_url('public/images/banners/gym_wallpaper.webp') ?>" 
                     alt="Búsqueda Banner" 
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
                                No encontramos productos que coincidan con "<strong><?= htmlspecialchars($busqueda) ?></strong>".
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
                                        <p class="text-success fw-bold mb-0">$ <?= number_format($producto['precio'], 0, ',', '.') ?></p>
                                        <?php if ($producto['cantidad'] <= 5 && $producto['cantidad'] > 0): ?>
                                            <small class="text-warning">¡Solo quedan <?= $producto['cantidad'] ?> unidades!</small>
                                        <?php elseif ($producto['cantidad'] == 0): ?>
                                            <small class="text-danger">Agotado</small>
                                        <?php endif; ?>
                                    </div>
                                    <div class="mt-auto">
                                        <?php if ($producto['cantidad'] > 0): ?>
                                            <button class="btn btn-primary w-100 mb-2" 
                                                    onclick="agregarAlCarrito(<?= $producto['id_producto'] ?>)">
                                                Agregar al Carrito
                                            </button>
                                        <?php else: ?>
                                            <button class="btn btn-secondary w-100 mb-2" disabled>
                                                Agotado
                                            </button>
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

<script>
function agregarAlCarrito(productoId) {
    // Implementar lógica del carrito
    console.log('Agregando producto al carrito:', productoId);
    
    // Mostrar notificación
    const toast = document.createElement('div');
    toast.className = 'position-fixed top-0 end-0 p-3';
    toast.style.zIndex = '1050';
    toast.innerHTML = `
        <div class="toast show" role="alert">
            <div class="toast-header">
                <strong class="me-auto">Carrito</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                Producto agregado al carrito exitosamente
            </div>
        </div>
    `;
    document.body.appendChild(toast);
    
    // Remover la notificación después de 3 segundos
    setTimeout(() => {
        document.body.removeChild(toast);
    }, 3000);
}
</script> 