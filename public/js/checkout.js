
    $(document).ready(function () {
        // Formatear número de tarjeta
        $('#card_number').on('input', function () {
            let value = $(this).val().replace(/\D/g, '');
            value = value.replace(/(\d{4})(?=\d)/g, '$1 ');
            $(this).val(value);
        });

        // Formatear fecha de vencimiento
        $('#expiry').on('input', function () {
            let value = $(this).val().replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.substring(0, 2) + '/' + value.substring(2, 4);
            }
            $(this).val(value);
        });

        // Solo números para CVV
        $('#cvv').on('input', function () {
            $(this).val($(this).val().replace(/\D/g, ''));
        });

        // Confirmar compra
        $('#btn-confirm-purchase').on('click', function () {
            // Validaciones básicas
            const cardNumber = $('#card_number').val().replace(/\s/g, '');
            const expiry = $('#expiry').val();
            const cvv = $('#cvv').val();
            const cardholder = $('#cardholder').val();

            if (!cardNumber || cardNumber.length < 13) {
                alert('Por favor, ingresa un número de tarjeta válido');
                return;
            }

            if (!expiry || expiry.length < 5) {
                alert('Por favor, ingresa la fecha de vencimiento');
                return;
            }

            if (!cvv || cvv.length < 3) {
                alert('Por favor, ingresa el código CVV');
                return;
            }

            if (!cardholder.trim()) {
                alert('Por favor, ingresa el nombre del titular');
                return;
            }

            $('#confirmPurchaseModal').modal('show');
        });

        // Procesar compra
        $('#btn-process-purchase').on('click', function () {
            const btn = $(this);
            const originalText = btn.html();

            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Procesando...');

            $.ajax({
                url: urlCheckoutConfirm,
                method: 'POST',
                success: function (response) {
                    // Simular procesamiento
                    setTimeout(function () {
                        $('#confirmPurchaseModal').modal('hide');
                        showSuccessMessage();
                    }, 2000);
                },
                error: function () {
                    btn.prop('disabled', false).html(originalText);
                    alert('Error al procesar la compra. Por favor, intenta nuevamente.');
                }
            });
        });

        function showSuccessMessage() {
            // Crear modal de éxito
            const successModal = $(`
            <div class="modal fade" id="successModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content bg-light text-dark">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title">
                                <i class="fas fa-check-circle"></i> ¡Compra Exitosa!
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body text-center bg-white">
                            <i class="fas fa-check-circle text-success fa-3x mb-3"></i>
                            <h4>¡Gracias por tu compra!</h4>
                            <p>Tu pedido ha sido procesado correctamente.</p>
                            <div class="alert alert-info">
                                <i class="fas fa-file-invoice"></i>
                                <strong>Factura generada:</strong> Se ha creado tu factura virtual con todos los detalles.
                            </div>
                            <p class="text-muted">Puedes acceder a tu factura desde tu cuenta de usuario.</p>
                        </div>
                        <div class="modal-footer bg-light border-top">
                            <a href="${urlFacturas}" class="btn btn-primary">
                                <i class="fas fa-file-invoice"></i> Ver Mis Facturas
                            </a>
                            <a href="${urlHome}" class="btn btn-outline-secondary">
                                <i class="fas fa-home"></i> Volver al Inicio
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        `);

            $('body').append(successModal);
            $('#successModal').modal('show');

            $('#successModal').on('hidden.bs.modal', function () {
                window.location.href = '<?= base_url() ?>';
            });
        }
    });
