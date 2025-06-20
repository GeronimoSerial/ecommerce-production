document.addEventListener('DOMContentLoaded', function() {
    console.log('Notifications script loaded');
    
    // Función para remover notificaciones
    function setupNotificationRemoval(notification) {
        console.log('Setting up notification removal for:', notification);
        
        // Configurar el botón de cierre
        const closeBtn = notification.querySelector('.btn-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                console.log('Close button clicked, removing notification');
                notification.remove();
            });
        }

        // Auto-remover después de 3 segundos (o 5 para notificaciones de éxito)
        const isSuccessNotification = notification.classList.contains('success-notification');
        const timeout = isSuccessNotification ? 5000 : 3000;
        
        console.log('Auto-removing notification in', timeout, 'ms');
        
        setTimeout(() => {
            if (notification && notification.parentNode) {
                console.log('Auto-removing notification');
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
    console.log('Found', notifications.length, 'notifications to setup');
    notifications.forEach(setupNotificationRemoval);
});
