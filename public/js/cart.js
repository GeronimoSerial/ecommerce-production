// Script centralizado para lógica de carrito y notificaciones en todas las vistas
// Incluye funciones para agregar productos, gestionar la página del carrito y mostrar notificaciones.
// Compatible con jQuery, Bootstrap 5, y FontAwesome.

var base_url = "/ecommerce/";

// =================================================================================
// SISTEMA DE NOTIFICACIONES (reutilizable en todo el sitio)
// =================================================================================

/**
 * Obtiene el ícono de FontAwesome correspondiente al tipo de notificación.
 * @param {string} type - Tipo de notificación (success, error, etc.)
 * @returns {string} Clase del ícono.
 */
function getIconForType(type) {
    const icons = {
        'success': 'fa-check-circle',
        'error': 'fa-times-circle',
        'warning': 'fa-exclamation-circle',
        'info': 'fa-info-circle'
    };
    return 'fa ' + (icons[type] || 'fa-info-circle');
}

/**
 * Muestra una notificación en pantalla. Reutiliza y actualiza una notificación existente
 * para evitar el apilamiento de mensajes.
 * @param {string} message - Mensaje a mostrar.
 * @param {string} type - Tipo de notificación (success, error, warning, info).
 */
function mostrarNotificacion(message, type = 'info') {
    if ($('#notifications-container').length === 0) {
        $('body').append('<div id="notifications-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999; max-width: 350px;"></div>');
    }

    let alert = $('#notifications-container').find('.alert');

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
        alert.removeClass('alert-success alert-danger alert-warning alert-info')
            .addClass(`alert-${type}`)
            .find('i')
            .removeClass('fa-check-circle fa-times-circle fa-exclamation-circle fa-info-circle')
            .addClass(getIconForType(type).replace('fa ', ''))
            .end()
            .find('.notification-message')
            .text(message);
        alert.removeClass('fade show').addClass('fade show');
    }

    if (alert.data('timeout')) {
        clearTimeout(alert.data('timeout'));
    }

    const timeoutId = setTimeout(() => {
        alert.alert('close');
    }, 5000);

    alert.data('timeout', timeoutId);
}

// =================================================================================
// FUNCIONES GLOBALES DEL CARRITO (para vistas de productos)
// =================================================================================

/**
 * Actualiza el contador de productos en el ícono del carrito en el navbar.
 * @param {number} count - Número de productos en el carrito.
 */
function actualizarContadorCarrito(count) {
    const cartBadge = $('.cart-count-badge');
    if (cartBadge.length) {
        cartBadge.text(count);
        if (count > 0) {
            cartBadge.show().addClass('visible').removeClass('hidden');
        } else {
            cartBadge.hide().addClass('hidden').removeClass('visible');
        }
    }
}

/**
 * Obtiene y valida la cantidad de un producto desde su campo de entrada.
 * @param {number} idProducto - ID del producto.
 * @returns {number|null} La cantidad validada o null si es inválida.
 */
function _obtenerCantidadProducto(idProducto) {
    let input = $(`#cantidad-producto-${idProducto}, #cantidad-producto`).first();
    if (input.length === 0) return null;

    const cantidad = parseInt(input.val());
    const maxCantidad = parseInt(input.attr('max')) || 99;

    if (isNaN(cantidad) || cantidad < 1) {
        mostrarNotificacion("La cantidad debe ser al menos 1.", "error");
        input.val(1);
        return null;
    }
    if (cantidad > maxCantidad) {
        mostrarNotificacion(`La cantidad no puede superar el stock disponible (${maxCantidad}).`, "error");
        input.val(maxCantidad);
        return null;
    }
    return cantidad;
}

/**
 * Agrega un producto al carrito mediante una llamada AJAX.
 * @param {number} idProducto - ID del producto.
 * @param {Event} event - Evento de clic para gestionar el estado del botón.
 */
function agregarAlCarrito(idProducto, event) {
    const cantidad = _obtenerCantidadProducto(idProducto);
    if (cantidad === null) return;

    const btn = $(event.target).closest('button');
    const originalText = btn.html();
    btn.prop('disabled', true).html('<i class="fas fa-hourglass-half me-2"></i>Agregando...');

    $.ajax({
        url: base_url + "cart/add",
        method: "POST",
        data: {
            producto_id: idProducto,
            cantidad: cantidad,
        },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                mostrarNotificacion(response.message, "success");
                actualizarContadorCarrito(response.cartCount);
            } else {
                mostrarNotificacion(response.message, "error");
            }
        },
        error: function () {
            mostrarNotificacion("Error al agregar al carrito.", "error");
        },
        complete: function () {
            btn.prop('disabled', false).html(originalText);
        },
    });
}

/**
 * Agrega un producto al carrito y redirige al checkout.
 * @param {number} idProducto - ID del producto.
 */
function comprarAhora(idProducto) {
    const cantidad = _obtenerCantidadProducto(idProducto);
    if (cantidad === null) return;

    $.ajax({
        url: base_url + "cart/add",
        method: "POST",
        data: {
            producto_id: idProducto,
            cantidad: cantidad,
        },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                window.location.href = base_url + "checkout";
            } else {
                mostrarNotificacion(response.message, "error");
            }
        },
        error: function () {
            mostrarNotificacion("Error al procesar la compra.", "error");
        },
    });
}

/**
 * Cambia la cantidad en el campo de entrada de un producto.
 * @param {number} delta - Cambio a aplicar (+1 o -1).
 * @param {number|null} idProducto - ID del producto.
 */
function cambiarCantidad(delta, idProducto = null) {
    let input = $(`#cantidad-producto-${idProducto}, #cantidad-producto`).first();
    if (input.length === 0) return;
    
    const max = parseInt(input.attr('max')) || 99;
    const currentVal = parseInt(input.val());
    const nuevaCantidad = Math.max(1, Math.min(max, currentVal + delta));
    
    input.val(nuevaCantidad);
}

/**
 * Muestra una notificación para avisar sobre la disponibilidad de un producto.
 * @param {number} idProducto - ID del producto.
 */
function notificarDisponibilidad(idProducto) {
    mostrarNotificacion(
        "Te notificaremos cuando el producto #" + idProducto + " esté disponible.",
        "info"
    );
}

// =================================================================================
// FUNCIONES ESPECÍFICAS DE LA PÁGINA DEL CARRITO (`cart.php`)
// =================================================================================

/**
 * Actualiza la cantidad de un producto en el carrito.
 * @param {number} itemId - ID del item en el carrito.
 * @param {number} quantity - Nueva cantidad.
 * @param {jQuery} input - Elemento input de la cantidad.
 */
function updateQuantity(itemId, quantity, input) {
    const row = input.closest('tr');
    const loader = $('<div class="spinner-border spinner-border-sm text-primary" role="status"><span class="visually-hidden">Cargando...</span></div>');
    row.find('td').css('opacity', '0.7');
    input.after(loader);

    $.ajax({
        url: base_url + 'cart/actualizar_cantidad',
        method: 'POST',
        data: {
            carrito_id: itemId,
            cantidad: quantity
        },
        dataType: 'json',
        success: function (data) {
            if (data.success) {
                input.data('original-value', quantity);
                updateCartSummary();
                mostrarNotificacion('Cantidad actualizada correctamente.', 'success');
            } else {
                mostrarNotificacion(data.message || 'Error al actualizar la cantidad.', 'error');
                input.val(input.data('original-value'));
            }
        },
        error: function () {
            mostrarNotificacion('Error de conexión al actualizar la cantidad.', 'error');
            input.val(input.data('original-value'));
        },
        complete: function () {
            row.find('td').css('opacity', '1');
            loader.remove();
        }
    });
}

/**
 * Elimina un producto del carrito.
 * @param {number} itemId - ID del item en el carrito.
 * @param {jQuery} row - Fila de la tabla del producto.
 */
function removeItem(itemId, row) {
    row.find('td').css('opacity', '0.7');

    $.ajax({
        url: base_url + 'cart/eliminar',
        method: 'POST',
        data: {
            carrito_id: itemId
        },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                row.fadeOut(300, function () {
                    $(this).remove();
                    updateCartSummary();
                    if ($('tbody tr').length === 0) {
                        location.reload();
                    }
                });
                actualizarContadorCarrito(response.cartCount);
                mostrarNotificacion('Producto eliminado del carrito.', 'success');
            } else {
                mostrarNotificacion(response.message || 'Error al eliminar el producto.', 'error');
                row.find('td').css('opacity', '1');
            }
        },
        error: function () {
            mostrarNotificacion('Error de conexión al eliminar el producto.', 'error');
            row.find('td').css('opacity', '1');
        }
    });
}

/**
 * Vacía todos los productos del carrito.
 */
function clearCart() {
    const btn = $('#confirm-clear-cart');
    const originalText = btn.html();
    btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Procesando...');

    $.ajax({
        url: base_url + 'cart/vaciar',
        method: 'POST',
        success: function () {
            location.reload();
        },
        error: function () {
            mostrarNotificacion('Error al vaciar el carrito.', 'error');
            btn.prop('disabled', false).html(originalText);
        }
    });
}

/**
 * Recalcula y actualiza el resumen de la compra (subtotal, impuestos, total).
 */
function updateCartSummary() {
    let subtotal = 0;
    $('tr[data-item-id]').each(function () {
        const row = $(this);
        const quantity = parseInt(row.find('.quantity-input').val());
        const priceText = row.find('td:nth-child(2) .fw-bold').text().trim();
        const price = parseFloat(priceText.replace(/[^0-9,]/g, '').replace(',', '.'));

        if (!isNaN(quantity) && !isNaN(price)) {
            const itemSubtotal = quantity * price;
            subtotal += itemSubtotal;
            row.find('.item-subtotal').text('$' + itemSubtotal.toFixed(2).replace(/\./g, ','));
        }
    });

    const tax = subtotal * 0.21;
    const total = subtotal + tax;
    
    const formatCurrency = (num) => '$' + num.toLocaleString('es-AR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

    $('#cart-subtotal').text(formatCurrency(subtotal));
    $('#cart-tax').text(formatCurrency(tax));
    $('#cart-total').text(formatCurrency(total));
}


/**
 * Inicializa los manejadores de eventos para la página del carrito.
 */
function initCartPage() {
    if ($('.cart-table').length === 0) return;

    let clearCartModal = new bootstrap.Modal(document.getElementById('clearCartModal'));

    $(document).on('change', '.quantity-input', function () {
        const input = $(this);
        const itemId = input.closest('tr').data('item-id');
        let quantity = parseInt(input.val());
        const originalValue = parseInt(input.data('original-value'));
        const max = parseInt(input.attr('max')) || 9999;

        if (isNaN(quantity) || quantity < 1) quantity = 1;
        if (quantity > max) quantity = max;
        input.val(quantity);

        if (quantity !== originalValue) {
            updateQuantity(itemId, quantity, input);
        }
    });

    $(document).on('click', '.btn-increase', function (e) {
        e.preventDefault();
        const input = $(this).siblings('.quantity-input');
        const currentValue = parseInt(input.val());
        input.val(currentValue + 1).trigger('change');
    });

    $(document).on('click', '.btn-decrease', function (e) {
        e.preventDefault();
        const input = $(this).siblings('.quantity-input');
        const currentValue = parseInt(input.val());
        if (currentValue > 1) {
            input.val(currentValue - 1).trigger('change');
        }
    });

    $(document).on('click', '.btn-remove', function (e) {
        e.preventDefault();
        const itemId = $(this).data('item-id');
        const row = $(this).closest('tr');
        if (confirm('¿Estás seguro de que quieres eliminar este producto del carrito?')) {
            removeItem(itemId, row);
        }
    });

    $('#btn-clear-cart').on('click', function (e) {
        e.preventDefault();
        clearCartModal.show();
    });

    $('#confirm-clear-cart').on('click', function (e) {
        e.preventDefault();
        clearCartModal.hide();
        clearCart();
    });
}

// =================================================================================
// INICIALIZACIÓN
// =================================================================================

$(document).ready(function () {
    // Inicializa la lógica específica de la página del carrito.
    initCartPage();

    // Inicializa el contador del carrito en el navbar en todas las páginas.
    const cartBadge = $('.cart-count-badge');
    if (cartBadge.length) {
        const initialCount = parseInt(cartBadge.text().trim());
        actualizarContadorCarrito(isNaN(initialCount) ? 0 : initialCount);
    }
});
