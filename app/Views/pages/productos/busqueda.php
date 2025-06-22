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
                <img src="<?= base_url('images/banners/gym_wallpaper.webp') ?>" alt="Búsqueda Banner"
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
                    <div class="card-header bg-primary text-white ">
                        <h5 class="mb-0"><i class="bi bi-search me-2"></i>Buscador</h5>
                    </div>
                    <div class="card-body">
                        <?php
                        echo view('templates/buscador', [
                            'filtros' => $filtros,
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
                        <?= view('templates/filtros', [
                            'filtros' => $filtros,
                            'baseUrl' => current_url()
                        ]) ?>
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
                            Intenta ajustar tu búsqueda.
                        </p>
                        <a href="<?= base_url('buscar') ?>" class="btn btn-primary">Nueva Búsqueda</a>
                    </div>
                <?php else: ?>
                    <!-- Grid de Productos -->
                    <div class="row g-3">
                        <?php foreach ($productos as $producto): ?>
                            <?= view('templates/producto_card', ['producto' => $producto]) ?>
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
