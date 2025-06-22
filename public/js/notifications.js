document.addEventListener('DOMContentLoaded', function() {
    // Función para remover notificaciones
    function setupNotificationRemoval(notification) {
        // Configurar el botón de cierre
        const closeBtn = notification.querySelector('.btn-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                notification.remove();
            });
        }

        // Auto-remover después de 3 segundos (o 5 para notificaciones de éxito)
        const isSuccessNotification = notification.classList.contains('success-notification');
        const timeout = isSuccessNotification ? 5000 : 3000;
        
        setTimeout(() => {
            if (notification && notification.parentNode) {
                // Agregar clase para la animación de salida
                notification.style.opacity = '0';
                notification.style.transform = 'translateY(-20px)';
                notification.style.transition = 'opacity 0.5s, transform 0.5s';
                
                // Remover el elemento después de la animación
                setTimeout(() => {
                    if (notification && notification.parentNode) {
                        notification.remove();
                    }
                }, 500);
            }
        }, timeout);
    }

    // Configurar todas las notificaciones existentes
    const notifications = document.querySelectorAll('.custom-alert, .success-notification');
    notifications.forEach(setupNotificationRemoval);
});

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
    success: "fa-check-circle",
    error: "fa-times-circle",
    warning: "fa-exclamation-circle",
    info: "fa-info-circle",
  };
  return "fa " + (icons[type] || "fa-info-circle");
}

/**
 * Muestra una notificación en pantalla. Reutiliza y actualiza una notificación existente
 * para evitar el apilamiento de mensajes.
 * @param {string} message - Mensaje a mostrar.
 * @param {string} type - Tipo de notificación (success, error, warning, info).
 */
function mostrarNotificacion(message, type = "info") {
  if ($("#notifications-container").length === 0) {
    $("body").append(
      '<div id="notifications-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999; max-width: 350px;"></div>'
    );
  }

  let alert = $("#notifications-container").find(".alert");

  if (alert.length === 0) {
    alert = $(`
            <div class="alert alert-${type} alert-dismissible fade show" role="alert" style="transition: all 0.3s ease;">
                <i class="${getIconForType(type)} me-2"></i>
                <span class="notification-message">${message}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `);
    $("#notifications-container").append(alert);
  } else {
    alert
      .removeClass("alert-success alert-danger alert-warning alert-info")
      .addClass(`alert-${type}`)
      .find("i")
      .removeClass(
        "fa-check-circle fa-times-circle fa-exclamation-circle fa-info-circle"
      )
      .addClass(getIconForType(type).replace("fa ", ""))
      .end()
      .find(".notification-message")
      .text(message);
    alert.removeClass("fade show").addClass("fade show");
  }

  if (alert.data("timeout")) {
    clearTimeout(alert.data("timeout"));
  }

  const timeoutId = setTimeout(() => {
    alert.alert("close");
  }, 5000);

  alert.data("timeout", timeoutId);
}
