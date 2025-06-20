// Script centralizado para lógica de carrito y notificaciones en todas las vistas de productos
// Incluye funciones: agregarAlCarrito, comprarAhora, cambiarCantidad, notificarDisponibilidad, mostrarNotificacion, actualizarContadorCarrito
// Compatible con vistas de detalle, categoría y búsqueda
var base_url = "/ecommerce/";

function agregarAlCarrito(idProducto) {
    let input = document.getElementById('cantidad-producto-' + idProducto);
    if (!input) {
        input = document.getElementById('cantidad-producto');
    }
    const cantidad = parseInt(input.value);
    const maxCantidad = parseInt(input.max) || 99;
    
    if (cantidad < 1 || cantidad > maxCantidad) {
        mostrarNotificacion('Cantidad inválida', 'error');
        return;
    }

    // Mostrar loading
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Agregando...';

    $.ajax({
        url: base_url + 'cart/add',
        method: 'POST',
        data: {
            producto_id: idProducto,
            cantidad: cantidad
        },
        success: function(response) {
            if (response.success) {
                mostrarNotificacion(response.message, 'success');
                // Actualizar contador del carrito en el navbar
                actualizarContadorCarrito(response.cartCount);
            } else {
                mostrarNotificacion(response.message, 'error');
            }
        },
        error: function() {
            mostrarNotificacion('Error al agregar al carrito', 'error');
        },
        complete: function() {
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    });
}

function comprarAhora(idProducto) {
    let input = document.getElementById('cantidad-producto-' + idProducto);
    if (!input) {
        input = document.getElementById('cantidad-producto');
    }
    const cantidad = parseInt(input.value);
    const maxCantidad = parseInt(input.max) || 99;
    
    if (cantidad < 1 || cantidad > maxCantidad) {
        mostrarNotificacion('Cantidad inválida', 'error');
        return;
    }

    // Primero agregar al carrito
    $.ajax({
        url: base_url + 'cart/add',
        method: 'POST',
        data: {
            producto_id: idProducto,
            cantidad: cantidad
        },
        success: function(response) {
            if (response.success) {
                // Redirigir al checkout
                window.location.href = base_url + 'checkout';
            } else {
                mostrarNotificacion(response.message, 'error');
            }
        },
        error: function() {
            mostrarNotificacion('Error al procesar la compra', 'error');
        }
    });
}

function cambiarCantidad(delta, idProducto = null, maxCantidad = null) {
    let input;
    if (idProducto) {
        input = document.getElementById('cantidad-producto-' + idProducto);
    } else {
        input = document.getElementById('cantidad-producto');
    }
    if (!input) return;
    const max = maxCantidad !== null ? maxCantidad : parseInt(input.max) || 99;
    const nuevaCantidad = Math.max(1, Math.min(max, parseInt(input.value) + delta));
    input.value = nuevaCantidad;
}

function notificarDisponibilidad(idProducto) {
    mostrarNotificacion('Te notificaremos cuando esté disponible el producto #' + idProducto, 'info');
}

function actualizarContadorCarrito(count) {
    // Buscar y actualizar el contador del carrito en el navbar
    const cartBadge = document.querySelector('.cart-count-badge') || document.getElementById('cart-count');
    if (cartBadge) {
        cartBadge.textContent = count;
        if (count > 0) {
            cartBadge.style.display = 'inline';
            cartBadge.classList.add('visible');
            cartBadge.classList.remove('hidden');
        } else {
            cartBadge.style.display = 'none';
            cartBadge.classList.add('hidden');
            cartBadge.classList.remove('visible');
        }
    }
}

function mostrarNotificacion(mensaje, tipo) {
    const toast = document.createElement('div');
    toast.className = 'position-fixed top-0 end-0 p-3';
    toast.style.zIndex = '1050';

    let bgClass, icon;
    switch (tipo) {
        case 'success':
            bgClass = 'bg-success';
            icon = 'bi-check-circle-fill';
            break;
        case 'error':
            bgClass = 'bg-danger';
            icon = 'bi-exclamation-circle-fill';
            break;
        case 'info':
            bgClass = 'bg-info';
            icon = 'bi-info-circle-fill';
            break;
        default:
            bgClass = 'bg-warning';
            icon = 'bi-exclamation-triangle-fill';
    }

    toast.innerHTML = `
    <div class="toast show" role="alert">
        <div class="toast-header ${bgClass} text-white">
            <i class="bi ${icon} me-2"></i>
            <strong class="me-auto">Notificación</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">
            ${mensaje}
        </div>
    </div>
`;
    document.body.appendChild(toast);

    setTimeout(() => {
        if (document.body.contains(toast)) {
            document.body.removeChild(toast);
        }
    }, 3000);
}

document.addEventListener('DOMContentLoaded', function() {
    // Si existe el badge, inicializar el contador con valor 0 (o cargarlo vía AJAX si se desea)
    const cartBadge = document.querySelector('.cart-count-badge') || document.getElementById('cart-count');
    if (cartBadge) {
        actualizarContadorCarrito(parseInt(cartBadge.textContent) || 0);
    }
});