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

        // Auto-remover después de 3 segundos
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
        }, 3000);
    }

    // Configurar todas las notificaciones existentes
    document.querySelectorAll('.custom-alert').forEach(setupNotificationRemoval);
});
