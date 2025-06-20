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
                                                            <img src="<?= base_url('public/images/' . $item['url_imagen']) ?>"
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
                                                            class="fw-bold"><?= format_currency($item['precio_unitario']) ?></span>
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
                                                        <span class="fw-bold item-subtotal">
                                                            <?= format_currency($item['cantidad'] * $item['precio_unitario']) ?>
                                                        </span>
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
                            <a href="<?= base_url('productos') ?>" class="btn btn-outline-primary px-4">
                                <i class="fas fa-arrow-left me-2"></i> Seguir Comprando
                            </a>
                            <button class="btn btn-outline-danger" id="btn-clear-cart">
                                <i class="fas fa-trash"></i> Vaciar Carrito
                            </button>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="cart-summary">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-white border-bottom">
                                    <h5 class="mb-0">
                                        <i class="fas fa-receipt me-2"></i>Resumen de la compra
                                    </h5>
                                    <span class="fw-bold" id="cart-subtotal"><?= format_currency($subtotal) ?></span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Impuestos (21%):</span>
                                    <span class="fw-bold"
                                        id="cart-tax"><?= format_currency(calculate_tax($subtotal)) ?></span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="h5 mb-0">Total:</span>
                                    <span class="h5 mb-0 text-primary"
                                        id="cart-total"><?= format_currency(calculate_total($subtotal)) ?></span>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle text-warning"></i> Confirmar Acción
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que quieres vaciar tu carrito de compras?</p>
                <p class="text-muted small">Esta acción no se puede deshacer.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirm-clear-cart">
                    <i class="fas fa-trash"></i> Vaciar Carrito
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Inicializar el modal de Bootstrap
    let clearCartModal = new bootstrap.Modal(document.getElementById('clearCartModal'));

    // Función para manejar eventos delegados
    function setupCartEventHandlers() {
        // Actualizar cantidad (usando delegación de eventos)
        $(document).off('change', '.quantity-input').on('change', '.quantity-input', function () {
            const input = $(this);
            const itemId = input.closest('tr').data('item-id');
            let quantity = parseInt(input.val());
            const originalValue = parseInt(input.data('original-value') || quantity);
            const max = parseInt(input.attr('max')) || 9999;

            // Validar cantidad
            if (isNaN(quantity) || quantity < 1) {
                quantity = 1;
                input.val(1);
            } else if (quantity > max) {
                quantity = max;
                input.val(max);
            }

            if (quantity === originalValue) return;

            updateQuantity(itemId, quantity, input);
        });

        // Botones de incremento/decremento (usando delegación de eventos)
        $(document).off('click', '.btn-increase').on('click', '.btn-increase', function (e) {
            e.preventDefault();
            const input = $(this).siblings('.quantity-input');
            const max = parseInt(input.attr('max')) || 9999;
            const newValue = Math.min(max, parseInt(input.val()) + 1);
            input.val(newValue).trigger('change');
        });

        $(document).off('click', '.btn-decrease').on('click', '.btn-decrease', function (e) {
            e.preventDefault();
            const input = $(this).siblings('.quantity-input');
            const newValue = Math.max(1, parseInt(input.val()) - 1);
            input.val(newValue).trigger('change');
        });

        // Eliminar producto (usando delegación de eventos)
        $(document).off('click', '.btn-remove').on('click', '.btn-remove', function (e) {
            e.preventDefault();
            const itemId = $(this).data('item-id');
            const row = $(this).closest('tr');

            if (confirm('¿Estás seguro de que quieres eliminar este producto del carrito?')) {
                removeItem(itemId, row);
            }
        });
    }

    // Inicializar manejadores de eventos
    $(document).ready(function () {
        setupCartEventHandlers();

        // Vaciar carrito
        $('#btn-clear-cart').on('click', function (e) {
            e.preventDefault();
            clearCartModal.show();
        });

        $('#confirm-clear-cart').on('click', function (e) {
            e.preventDefault();
            clearCartModal.hide();
            clearCart();
        });
    });

    function updateQuantity(itemId, quantity, input) {
        // Mostrar indicador de carga
        const row = input.closest('tr');
        const loader = $('<div class="spinner-border spinner-border-sm text-primary" role="status"><span class="visually-hidden">Cargando...</span></div>');
        row.find('td').css('opacity', '0.7');
        input.after(loader);

        $.ajax({
            url: '<?= base_url('cart/actualizar_cantidad') ?>',
            method: 'POST',
            data: {
                carrito_id: itemId,
                cantidad: quantity
            },
            success: function (response) {
                try {
                    // Asegurarse de que la respuesta sea un objeto JSON
                    const data = typeof response === 'string' ? JSON.parse(response) : response;

                    if (data.success) {
                        // Actualizar subtotal del item
                        const price = parseFloat(row.find('td:nth-child(2) .fw-bold').text().replace(/[^0-9.,]/g, '').replace(',', '.'));
                        const subtotal = price * quantity;
                        // Guardar el valor numérico en un atributo data para facilitar los cálculos
                        const formattedSubtotal = '$' + subtotal.toFixed(2).replace(/\./g, ',');
                        row.find('.item-subtotal')
                            .text(formattedSubtotal)
                            .data('raw-value', subtotal);

                        // Actualizar resumen
                        updateCartSummary();

                        // Actualizar valor original
                        input.data('original-value', quantity);

                        showNotification('Cantidad actualizada correctamente', 'success');
                    } else {
                        showNotification(data.message || 'Error al actualizar la cantidad', 'error');
                        input.val(input.data('original-value'));
                    }
                } catch (e) {
                    console.error('Error al procesar la respuesta:', e);
                    showNotification('Error al procesar la respuesta del servidor', 'error');
                    input.val(input.data('original-value'));
                }
            },
            complete: function () {
                // Ocultar indicador de carga
                row.find('td').css('opacity', '1');
                loader.remove();
            },
            error: function () {
                showNotification('Error al actualizar la cantidad', 'error');
                input.val(input.data('original-value'));
            }
        });
    }

    function removeItem(itemId, row) {
        // Mostrar indicador de carga
        const loader = $('<div class="spinner-border spinner-border-sm text-primary" role="status"><span class="visually-hidden">Cargando...</span></div>');
        row.find('td').css('opacity', '0.7');
        row.find('.btn-remove').prop('disabled', true).append(loader);

        $.ajax({
            url: '<?= base_url('cart/eliminar') ?>',
            method: 'POST',
            data: {
                carrito_id: itemId
            },
            success: function (response) {
                if (response.success) {
                    row.fadeOut(300, function () {
                        $(this).remove();
                        updateCartSummary();

                        // Si no quedan items, recargar la página
                        if ($('tbody tr').length === 0) {
                            location.reload();
                        }
                    });

                    // Actualizar contador del navbar
                    updateNavbarCartCount(response.cartCount);

                    showNotification('Producto eliminado del carrito', 'success');
                } else {
                    showNotification(response.message, 'error');
                }
            },
            error: function () {
                showNotification('Error al eliminar el producto', 'error');
            }
        });
    }

    function clearCart() {
        // Mostrar indicador de carga
        const btn = $('#confirm-clear-cart');
        const originalText = btn.html();
        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Procesando...');

        $.ajax({
            url: '<?= base_url('cart/vaciar') ?>',
            method: 'POST',
            success: function () {
                location.reload();
            },
            error: function () {
                showNotification('Error al vaciar el carrito', 'error');
            }
        });
    }

    function updateCartSummary() {
        // Recalcular subtotal
        let subtotal = 0;
        $('.item-subtotal').each(function () {
            // Usar el valor numérico almacenado en data-raw-value si está disponible
            const rawValue = $(this).data('raw-value');
            const itemSubtotal = typeof rawValue !== 'undefined' ?
                parseFloat(rawValue) :
                parseFloat($(this).text().replace(/[^0-9.,]/g, '').replace(',', '.')) || 0;
            subtotal += itemSubtotal;
        });

        const tax = subtotal * 0.21;
        const total = subtotal + tax;

        // Formatear números con separador de miles y decimales
        const formatNumber = (num) => {
            return num.toFixed(2).replace(/\./g, ',');
        };

        $('#cart-subtotal').text('$' + formatNumber(subtotal));
        $('#cart-tax').text('$' + formatNumber(tax));
        $('#cart-total').text('$' + formatNumber(total));
    }

    function updateNavbarCartCount(count) {
        // Actualizar el contador en el navbar si existe
        const cartBadge = $('.cart-count-badge');
        if (cartBadge.length) {
            cartBadge.text(count);
            if (count === 0) {
                cartBadge.hide();
            } else {
                cartBadge.show();
            }
        }
    }

    function getIconForType(type) {
        const icons = {
            'success': 'fa-check-circle',
            'error': 'fa-times-circle',
            'warning': 'fa-exclamation-circle',
            'info': 'fa-info-circle'
        };
        return 'fa ' + (icons[type] || 'fa-info-circle');
    }

    function showNotification(message, type = 'info') {
        // Crear notificación si no existe el sistema de notificaciones
        if (typeof showAlert !== 'function') {
            // Crear contenedor de notificaciones si no existe
            if ($('#notifications-container').length === 0) {
                $('body').append('<div id="notifications-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999; max-width: 350px;"></div>');
            }

            // Buscar notificación existente
            let alert = $('#notifications-container').find('.alert');

            // Si no existe una notificación, crea una nueva
            if (alert.length === 0) {
                alert = $(`
                    <div class="alert alert-${type} alert-dismissible fade show" role="alert" style="transition: all 0.3s ease;">
                        <i class="${getIconForType(type)} me-2"></i>
                        <span class="notification-message">${message}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `);
                $('#notifications-container').append(alert);
            } else {
                // Actualizar notificación existente
                alert.removeClass('alert-success alert-danger alert-warning alert-info')
                    .addClass(`alert-${type}`)
                    .find('i')
                    .removeClass('fa-check-circle fa-times-circle fa-exclamation-circle fa-info-circle')
                    .addClass(getIconForType(type).replace('fa ', ''))
                    .end()
                    .find('.notification-message')
                    .text(message);

                // Reiniciar la animación
                alert.removeClass('fade show').addClass('fade show');
            }

            // Limpiar timeout anterior si existe
            if (alert.data('timeout')) {
                clearTimeout(alert.data('timeout'));
            }

            // Auto-ocultar después de 5 segundos
            const timeoutId = setTimeout(() => {
                alert.alert('close');
            }, 5000);

            // Guardar el ID del timeout
            alert.data('timeout', timeoutId);
        } else {
            showAlert(message, type);
        }
    }
</script>