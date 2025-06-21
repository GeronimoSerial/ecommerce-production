<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">
                <i class="fas fa-credit-card"></i> Finalizar Compra
            </h1>

            <div class="row">
                <div class="col-lg-8">
                    <!-- Información del Cliente -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-user"></i> Información del Cliente
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Nombre:</strong> <?= session()->get('nombre') ?>
                                        <?= session()->get('apellido') ?>
                                    </p>
                                    <p><strong>Email:</strong> <?= session()->get('usuario_email') ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>ID de Usuario:</strong> #<?= $usuarioId ?></p>
                                    <p><strong>Fecha:</strong> <?= date('d/m/Y H:i') ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detalle de Productos -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-shopping-bag"></i> Detalle de Productos
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Producto</th>
                                            <th class="text-center">Precio Unitario</th>
                                            <th class="text-center">Cantidad</th>
                                            <th class="text-center">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($cartItems as $item): ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="<?= base_url('public/images/' . $item['url_imagen']) ?>"
                                                            alt="<?= $item['nombre'] ?>" class="img-thumbnail me-3"
                                                            style="width: 50px; height: 50px; object-fit: cover;">
                                                        <div>
                                                            <h6 class="mb-1"><?= $item['nombre'] ?></h6>
                                                            <small class="text-muted"><?= $item['descripcion'] ?></small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <span
                                                        class="fw-bold"><?= format_currency($item['precio_unitario']) ?></span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-primary"><?= $item['cantidad'] ?></span>
                                                </td>
                                                <td class="text-center">
                                                    <span
                                                        class="fw-bold"><?= format_currency($item['cantidad'] * $item['precio_unitario']) ?></span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Información de Pago -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-lock"></i> Información de Pago
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                <strong>Nota:</strong> No ingrese datos reales. Este es un sistema de pago simulado.
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="card_number" class="form-label">Número de Tarjeta</label>
                                        <input type="text" class="form-control" id="card_number"
                                            placeholder="1234 5678 9012 3456" maxlength="19">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="expiry" class="form-label">Vencimiento</label>
                                        <input type="text" class="form-control" id="expiry" placeholder="MM/AA"
                                            maxlength="5">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="cvv" class="form-label">CVV</label>
                                        <input type="text" class="form-control" id="cvv" placeholder="123"
                                            maxlength="4">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="cardholder" class="form-label">Nombre del Titular</label>
                                <input type="text" class="form-control" id="cardholder"
                                    placeholder="Nombre como aparece en la tarjeta">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Resumen de Compra -->
                    <div class="card sticky-top" style="top: 100px;">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-calculator"></i> Resumen de Compra
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span class="fw-bold"><?= format_currency($subtotal) ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Impuestos (21%):</span>
                                <span class="fw-bold"><?= format_currency($tax) ?></span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="h5 mb-0">Total:</span>
                                <span class="h5 mb-0 text-primary"><?= format_currency($total) ?></span>
                            </div>

                            <button class="btn btn-success w-100 mb-3" id="btn-confirm-purchase">
                                <i class="fas fa-check"></i> Confirmar Compra
                            </button>

                            <a href="<?= base_url('cart') ?>" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-arrow-left"></i> Volver al Carrito
                            </a>
                        </div>

                        <!-- Información Adicional -->
                        <div class="card mt-3">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <i class="fas fa-info-circle"></i> Información Importante
                                </h6>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled small">
                                    <li class="mb-2">
                                        <i class="fas fa-shield-alt text-success"></i>
                                        Pago seguro y encriptado
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-truck text-info"></i>
                                        Envío gratuito en compras superiores a $50
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-undo text-warning"></i>
                                        Devoluciones gratuitas hasta 30 días
                                    </li>
                                    <li>
                                        <i class="fas fa-headset text-primary"></i>
                                        Soporte 24/7 disponible
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación de compra -->
<div class="modal fade" id="confirmPurchaseModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-light text-dark">
            <div class="modal-header bg-light border-bottom">
                <h5 class="modal-title">
                    <i class="fas fa-check-circle text-success"></i> Confirmar Compra
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body bg-white">
                <p>¿Estás seguro de que quieres confirmar esta compra?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Total a pagar:</strong> <?= format_currency($total) ?>
                </div>
                <p class="text-muted small">
                    Al confirmar, se procesará el pago y se descontará el stock de los productos.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="btn-process-purchase">
                    <i class="fas fa-check"></i> Confirmar y Procesar
                </button>
            </div>
        </div>
    </div>
</div>


<script>
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
                url: '<?= base_url('checkout/confirm') ?>',
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
                            <p class="text-muted">Recibirás un email de confirmación pronto.</p>
                        </div>
                        <div class="modal-footer bg-light border-top">
                            <a href="<?= base_url() ?>" class="btn btn-primary">
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
</script>