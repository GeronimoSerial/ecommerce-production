<!-- Contenido del carrito de compras -->
<div class="container py-4">
    <!-- Notificaciones -->
    <?php if (session()->has('message')): ?>
        <div class="alert alert-<?= session('message_type') ?> alert-dismissible fade show" role="alert">
            <?= session('message') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">
                <i class="fas fa-shopping-cart"></i> Carrito de Compras
            </h1>

            <?php if (empty($cartItems)): ?>
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle fa-2x mb-3"></i>
                    <h4>Tu carrito está vacío</h4>
                    <p>Agrega algunos productos para comenzar a comprar.</p>
                    <a href="<?= base_url('productos/buscar') ?>" class="btn btn-primary">
                        <i class="fas fa-shopping-bag"></i> Ver Productos
                    </a>
                </div>
            <?php else: ?>
                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white border-bottom">
                                <h5 class="mb-0">
                                    <i class="fas fa-list me-2"></i>Productos en el Carrito
                                </h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0 cart-table">
                                        <thead>
                                            <tr>
                                                <th>Producto</th>
                                                <th class="text-center">Precio</th>
                                                <th class="text-center">Cantidad</th>
                                                <th class="text-center">Subtotal</th>
                                                <th class="text-center">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($cartItems as $item): ?>
                                                <tr data-item-id="<?= $item['id_carrito'] ?>">
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img src="<?= base_url('images/' . $item['url_imagen']) ?>"
                                                                alt="<?= $item['nombre'] ?>" class="cart-item-image me-3">
                                                            <div>
                                                                <h6 class="mb-1"><?= $item['nombre'] ?></h6>
                                                                <small class="text-muted"><?= $item['descripcion'] ?></small>
                                                                <?php if ($item['cantidad'] > $item['stock_disponible']): ?>
                                                                    <div class="text-danger small">
                                                                        <i class="fas fa-exclamation-triangle"></i>
                                                                        Stock insuficiente (<?= $item['stock_disponible'] ?>
                                                                        disponible)
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <span
                                                            class="price fw-bold"><?= format_currency($item['precio_unitario']) ?></span>
                                                    </td>
                                                    <td class="text-center" data-label="Cantidad">
                                                        <div class="d-flex justify-content-center">
                                                            <button class="btn btn-outline-secondary btn-quantity btn-decrease"
                                                                type="button">
                                                                <i class="fas fa-minus"></i>
                                                            </button>
                                                            <input type="number"
                                                                class="form-control mx-2 text-center quantity-input"
                                                                value="<?= $item['cantidad'] ?>" min="1"
                                                                max="<?= $item['stock_disponible'] ?>"
                                                                data-original-value="<?= $item['cantidad'] ?>">
                                                            <button class="btn btn-outline-secondary btn-quantity btn-increase"
                                                                type="button">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="fw-bold item-subtotal"
                                                            data-item-id="<?= $item['id_carrito'] ?>"><?= format_currency($item['cantidad'] * $item['precio_unitario']) ?></span>
                                                    </td>
                                                    <td class="text-center">
                                                        <button class="btn btn-danger btn-sm btn-remove"
                                                            data-item-id="<?= $item['id_carrito'] ?>" title="Eliminar producto">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="<?= base_url('/') ?>" class="btn btn-outline-primary px-4">
                                <i class="fas fa-arrow-left me-2"></i> Seguir Comprando
                            </a>
                            <button class="btn btn-outline-danger" id="btn-clear-cart">
                                <i class="fas fa-trash"></i> Vaciar Carrito
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card sticky-top" style="top: 20px;">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-calculator"></i> Resumen de Compra
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <span class="fw-bold" id="cart-subtotal"><?= format_currency($subtotal) ?></span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="h5 mb-0">Total:</span>
                                    <span class="h5 mb-0 text-primary"
                                        id="cart-total"><?= format_currency($subtotal) ?></span>
                                </div>
                            </div>
                            <?php if ($isLoggedIn): ?>
                                <a href="<?= base_url('checkout') ?>" class="btn btn-success w-100">
                                    <i class="fas fa-credit-card"></i> Finalizar Compra
                                </a>
                            <?php else: ?>
                                <div class="alert alert-warning">
                                    <i class="fas fa-info-circle"></i>
                                    <strong>Inicia sesión</strong> para finalizar tu compra
                                </div>
                                <a href="<?= base_url('login') ?>" class="btn btn-primary w-100">
                                    <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
</div>

<!-- Modal de confirmación para vaciar carrito -->
<div class="modal fade" id="clearCartModal" tabindex="-1">
    <div class="modal-dialog bg-white">
        <div class="modal-content bg-white">
            <div class="modal-header bg-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle text-warning"></i> Confirmar Acción
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body bg-white">
                <p>¿Estás seguro de que quieres vaciar tu carrito de compras?</p>
                <p class="text-muted small">Esta acción no se puede deshacer.</p>
            </div>
            <div class="modal-footer bg-white">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirm-clear-cart">
                    <i class="fas fa-trash"></i> Vaciar Carrito
                </button>
            </div>
        </div>
    </div>
</div>