
    document.addEventListener('DOMContentLoaded', function () {
        // Función para validar el formulario
        const form = document.getElementById('registrationForm');
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });

        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        if (togglePassword && password) {
            togglePassword.addEventListener('click', function () {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                this.querySelector('i').className = `fas fa-${type === 'password' ? 'eye' : 'eye-slash'}`;
            });

            // Password strength meter
            const strengthMeter = document.querySelector('.progress-bar');
            if (strengthMeter) {
                password.addEventListener('input', function () {
                    const value = password.value;
                    let strength = 0;

                    // Criterios de fortaleza (solo informativo, no bloqueante)
                    if (value.length >= 6) strength += 20;
                    if (value.length >= 8) strength += 20;
                    if (value.match(/[A-Z]/)) strength += 20;
                    if (value.match(/[a-z]/)) strength += 20;
                    if (value.match(/[0-9]/)) strength += 10;
                    if (value.match(/[^A-Za-z0-9]/)) strength += 10;

                    // Actualizar el indicador visual
                    strengthMeter.style.width = Math.min(100, strength) + '%';

                    // Cambiar el color según la fortaleza
                    if (strength <= 40) {
                        strengthMeter.className = 'progress-bar bg-danger';
                    } else if (strength <= 80) {
                        strengthMeter.className = 'progress-bar bg-warning';
                    } else {
                        strengthMeter.className = 'progress-bar bg-success';
                    }
                });
            }
        }

        // Formatear automáticamente el número de teléfono
        const telefono = document.getElementById('validationCustomPhone');
        telefono.addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 10) value = value.slice(0, 10);
            e.target.value = value;
        });

        // Formatear automáticamente el DNI
        const dni = document.getElementById('validationCustomUsername');
        dni.addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 8) value = value.slice(0, 8);
            e.target.value = value;
        });

        // Redirigir después de la notificación de éxito
        const successNotification = document.querySelector('.success-notification');
        if (successNotification) {
            setTimeout(() => {
                window.location.href = "<?= base_url('login') ?>";
            }, 5000); // 5 segundos para que coincida con la animación del contador
        }
    });

    // Cerrar manualmente la notificación
    document.addEventListener('click', function (e) {
        if (e.target.closest('.alert-dismissible .btn-close')) {
            e.preventDefault();
            const notification = e.target.closest('.success-notification');
            if (notification) {
                notification.style.animation = 'slideOut 0.3s ease-out forwards';
                setTimeout(() => {
                    notification.remove();
                    window.location.href = "<?= base_url('login') ?>";
                }, 300);
            }
        }
    });

    // Animación de salida
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
    `;
    document.head.appendChild(style);