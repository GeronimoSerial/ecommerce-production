<?php
// Función local para manejar banners de categorías
if (!function_exists('getBannerUrl')) {
    function getBannerUrl($categoryName) {
        $bannerMap = [
            'proteinas' => 'protein_wallpaper.webp',
            'creatinas' => 'gym_wallpaper.webp',
            'colagenos' => 'header-background.webp',
            'accesorios' => 'gym_wallpaper.webp'
        ];

        $categoryKey = strtolower($categoryName);
        $bannerImage = $bannerMap[$categoryKey] ?? 'header-background.webp';

        return base_url('images/banners/' . $bannerImage);
    }
}

$bannerUrl = getBannerUrl($categoria['nombre']);
?>

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
                <img src="<?= $bannerUrl ?>" alt="<?= $categoria['nombre'] ?> Banner"
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
                        <?= view('templates/filtros', [
                            'filtros' => $filtros,
                            'baseUrl' => current_url()
                        ]) ?>
                    </div>
                </div>

                <?php if (empty($productos)): ?>
                    <!-- Mensaje cuando no hay productos -->
                    <div class="text-center py-5">
                        <i class="bi bi-box-seam fs-1 text-muted mb-3"></i>
                        <h4 class="text-muted">No se encontraron productos</h4>
                        <p class="text-muted">
                            <?php if (!empty($filtros['q']) || !empty($filtros['precioMin']) || !empty($filtros['precioMax'])): ?>
                                Intenta ajustar los filtros de búsqueda.
                            <?php else: ?>
                                Pronto tendremos productos de <?= strtolower($categoria['nombre']) ?> disponibles.
                            <?php endif; ?>
                        </p>
                        <?php if (!empty($filtros['q']) || !empty($filtros['precioMin']) || !empty($filtros['precioMax'])): ?>
                            <a href="<?= current_url() ?>" class="btn btn-primary">Limpiar Filtros</a>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <!-- Grid de Productos -->
                    <div class="row g-3">
                        <?php foreach ($productos as $producto): ?>
                            <?= view('templates/producto_card', ['producto' => $producto, 'categoria' => $categoria]) ?>
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
