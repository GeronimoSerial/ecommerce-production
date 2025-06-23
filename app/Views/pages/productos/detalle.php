<?php
$productImageUrl = getSafeImageUrl($producto['url_imagen'] ?? '');
?>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="py-3 mt-5">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-decoration-none">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('categoria/' . strtolower($categoria['nombre'])) ?>"
                    class="text-decoration-none"><?= $categoria['nombre'] ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $producto['nombre'] ?></li>
        </ol>
    </div>
</nav>

<!-- Detalle del Producto -->
<section class="py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Imagen del Producto -->
            <div class="col-lg-6">
                <div class="product-image-container">
                    <img src="<?= base_url('images/' . ($producto['url_imagen'] ?? 'default-product.jpg')) ?>"
                        alt="<?= htmlspecialchars($producto['nombre'] ?? 'Producto') ?>"
                        class="img-fluid rounded-4 shadow-sm"
                        onerror="this.src='<?= base_url('images/default-product.webp') ?>'">

                    <!-- Badge de cantidad -->
                    <?php if ($producto['cantidad'] <= 5 && $producto['cantidad'] > 0): ?>
                        <div class="position-absolute top-0 start-0 m-3">
                            <span class="badge bg-warning text-dark">¡Solo quedan <?= $producto['cantidad'] ?>!</span>
                        </div>
                    <?php elseif ($producto['cantidad'] == 0): ?>
                        <div class="position-absolute top-0 start-0 m-3">
                            <span class="badge bg-danger">Agotado</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Información del Producto -->
            <div class="col-lg-6">
                <div class="product-info">
                    <!-- Categoría y Nombre -->
                    <span class="badge bg-primary mb-2"><?= $categoria['nombre'] ?></span>
                    <h1 class="fw-bold mb-3"><?= $producto['nombre'] ?></h1>

                    <!-- Precio -->
                    <div class="mb-4">
                        <span class="display-6 fw-bold text-success">$
                            <?= number_format($producto['precio'], 0, ',', '.') ?></span>
                        <?php if ($producto['cantidad'] > 0): ?>
                            <small class="text-muted d-block">Envío gratis en compras superiores a $50.000</small>
                        <?php endif; ?>
                    </div>

                    <!-- Descripción -->
                    <div class="mb-4">
                        <h5 class="fw-semibold mb-2">Descripción</h5>
                        <p class="text-muted"><?= $producto['descripcion'] ?></p>
                    </div>

                    <!-- cantidad -->
                    <div class="mb-4">
                        <h5 class="fw-semibold mb-2">Disponibilidad</h5>
                        <?php if ($producto['cantidad'] > 0): ?>
                            <p class="text-success mb-0">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                En cantidad (<?= $producto['cantidad'] ?> unidades disponibles)
                            </p>
                        <?php else: ?>
                            <p class="text-danger mb-0">
                                <i class="bi bi-x-circle-fill me-2"></i>
                                Agotado
                            </p>
                        <?php endif; ?>
                    </div>

                    <!-- Cantidad a agregar -->
                    <?php if ($producto['cantidad'] > 0): ?>
                        <div class="mb-4">
                            <h5 class="fw-semibold mb-2">Cantidad</h5>
                            <div class="input-group" style="width: 180px;">
                                <button class="btn btn-outline-secondary" style="width: 40px;" type="button"
                                    onclick="cambiarCantidad(-1)">
                                    <i class="bi bi-dash"></i>
                                </button>
                                <input type="number" class="form-control text-center" id="cantidad-producto" value="1"
                                    min="1" max="<?= $producto['cantidad'] ?>">
                                <button class="btn btn-outline-secondary" style="width: 40px;" type="button"
                                    onclick="cambiarCantidad(1)">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Acciones -->
                    <div class="d-grid gap-3">
                        <?php if ($producto['cantidad'] > 0): ?>
                            <button class="btn btn-primary btn-lg"
                                onclick="agregarAlCarrito(<?= $producto['id_producto'] ?>, event)">
                                <i class="bi bi-cart-plus me-2"></i>
                                Agregar al Carrito
                            </button>
                            <button class="btn btn-outline-primary" onclick="comprarAhora(<?= $producto['id_producto'] ?>)">
                                <i class="bi bi-lightning-fill me-2"></i>
                                Comprar Ahora
                            </button>
                        <?php else: ?>
                            <button class="btn btn-secondary btn-lg" disabled>
                                <i class="bi bi-x-circle me-2"></i>
                                Producto Agotado
                            </button>
                            <button class="btn btn-outline-primary"
                                onclick="notificarDisponibilidad(<?= $producto['id_producto'] ?>)">
                                <i class="bi bi-bell me-2"></i>
                                Notificar cuando esté disponible
                            </button>
                        <?php endif; ?>
                    </div>

                    <!-- Información adicional -->
                    <div class="mt-4 pt-4 border-top">
                        <div class="row text-center">
                            <div class="col-4">
                                <i class="bi bi-truck fs-4 text-primary mb-2"></i>
                                <p class="small mb-0">Envío Gratis</p>
                            </div>
                            <div class="col-4">
                                <i class="bi bi-shield-check fs-4 text-primary mb-2"></i>
                                <p class="small mb-0">Garantía</p>
                            </div>
                            <div class="col-4">
                                <i class="bi bi-arrow-clockwise fs-4 text-primary mb-2"></i>
                                <p class="small mb-0">Devolución</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Características del Producto -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="fw-bold text-center mb-5">Características del Producto</h2>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="text-center">
                    <i class="bi bi-award fs-1 text-danger mb-3"></i>
                    <h5 class="fw-bold">Calidad Premium</h5>
                    <p class="text-muted small">Producto de la más alta calidad certificado</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="text-center">
                    <i class="bi bi-heart-pulse fs-1 text-danger mb-3"></i>
                    <h5 class="fw-bold">Saludable</h5>
                    <p class="text-muted small">Formulado para tu bienestar y rendimiento</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="text-center">
                    <i class="bi bi-star fs-1 text-danger mb-3"></i>
                    <h5 class="fw-bold">Sabor Excepcional</h5>
                    <p class="text-muted small">Delicioso sabor que te encantará</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="text-center">
                    <i class="bi bi-lightning fs-1 text-danger mb-3"></i>
                    <h5 class="fw-bold">Resultados Rápidos</h5>
                    <p class="text-muted small">Efectos visibles en poco tiempo</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Productos Relacionados -->
<?php if (!empty($productosRelacionados)): ?>
    <section class="py-5">
        <div class="container">
            <h2 class="fw-bold text-center mb-5">Productos Relacionados</h2>
            <div class="row g-4">
                <?php foreach ($productosRelacionados as $relacionado): ?>
                    <?php $relacionadoImageUrl = getSafeImageUrl($relacionado['url_imagen'] ?? ''); ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="p-4 bg-white rounded-4 shadow-sm hover-card text-center h-100 d-flex flex-column">
                            <div class="card-img-wrapper mb-3">
                                <img src="<?= base_url('images/' . ($relacionado['url_imagen'] ?? 'default-product.jpg')) ?>"
                                    alt="<?= htmlspecialchars($relacionado['nombre'] ?? 'Producto') ?>"
                                    class="product-img mx-auto"
                                    onerror="this.src='<?= base_url('images/default-product.webp') ?>'">
                            </div>
                            <div class="mb-3">
                                <span class="badge bg-primary mb-2"><?= $categoria['nombre'] ?></span>
                                <h5 class="fw-semibold mb-2"><?= $relacionado['nombre'] ?></h5>
                                <p class="text-muted small mb-2"><?= $relacionado['descripcion'] ?></p>
                                <p class="text-success fw-bold mb-0">$ <?= number_format($relacionado['precio'], 0, ',', '.') ?>
                                </p>
                            </div>
                            <div class="mt-auto">
                                <a href="<?= base_url('producto/' . $relacionado['id_producto']) ?>"
                                    class="btn btn-outline-primary w-100 mb-2">
                                    Ver Detalles
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>