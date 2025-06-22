<?php
/**
 * Product Card Component
 * 
 * @param array $producto Product data array
 * @param array $categoria Category data array (optional)
 */
$productoModel = model('ProductoModel');
$idCategoria = $producto['id_categoria'];
$categoriaNombre = $productoModel->getNombreCategoria($idCategoria);

$imageUrl = getSafeImageUrl($producto['url_imagen'] ?? '');
?>
<div class="col-md-6 col-lg-4">
    <div class="p-4 bg-white rounded-4 shadow-sm hover-card text-center h-100 d-flex flex-column">
        <div class="card-img-wrapper mb-3">
            <img src="<?= base_url('images/' . ($producto['url_imagen'] ?? 'default-product.jpg')) ?>"
                alt="<?= htmlspecialchars($producto['nombre'] ?? 'Producto') ?>"
                class="product-img mx-auto"
                onerror="this.src='<?= base_url('images/default-product.webp') ?>'">
        </div>
        <div class="mb-3">
            <span class="badge bg-primary mb-2">
                <?= esc($categoriaNombre) ?>
            </span>
            <h5 class="fw-semibold mb-2"><?= esc($producto['nombre']) ?></h5>
            <p class="text-muted small mb-2"><?= esc($producto['descripcion']) ?></p>
            <p class="text-success fw-bold mb-0">$<?= number_format($producto['precio'], 0, ',', '.') ?></p>
            <?php if ($producto['cantidad'] <= 5 && $producto['cantidad'] > 0): ?>
                <small class="text-warning">¡Solo quedan <?= $producto['cantidad'] ?> unidades!</small>
            <?php elseif ($producto['cantidad'] == 0): ?>
                <small class="text-danger">Agotado</small>
            <?php endif; ?>
        </div>
        <div class="mt-auto">
            <?php if ($producto['cantidad'] > 0): ?>
                <div class="input-group mb-2" style="width: 200px; margin: 0 auto;">
                    <button class="btn btn-outline-secondary" type="button" style="width: 40px;"
                        onclick="cambiarCantidad(-1, <?= $producto['id_producto'] ?>)">
                        <i class="bi bi-dash"></i>
                    </button>
                    <input type="number" class="form-control text-center" style="width: 40px;"
                        id="cantidad-producto-<?= $producto['id_producto'] ?>" value="1" min="1"
                        max="<?= $producto['cantidad'] ?>">
                    <button class="btn btn-outline-secondary" type="button" style="width: 40px;"
                        onclick="cambiarCantidad(1, <?= $producto['id_producto'] ?>)">
                        <i class="bi bi-plus"></i>
                    </button>
                </div>
                <button class="btn btn-primary w-100 mb-2"
                    onclick="agregarAlCarrito(<?= $producto['id_producto'] ?>, event)">Agregar al Carrito</button>
                <button class="btn btn-outline-primary w-100 mb-2"
                    onclick="comprarAhora(<?= $producto['id_producto'] ?>)">Comprar Ahora</button>
            <?php else: ?>
                <button class="btn btn-secondary w-100 mb-2" disabled>Agotado</button>
                <button class="btn btn-outline-primary w-100 mb-2"
                    onclick="notificarDisponibilidad(<?= $producto['id_producto'] ?>)">Notificar cuando esté
                    disponible</button>
            <?php endif; ?>
            <a href="<?= base_url('producto/' . $producto['id_producto']) ?>"
                class="text-primary text-decoration-none small">
                Ver Detalles
            </a>
        </div>
    </div>
</div>