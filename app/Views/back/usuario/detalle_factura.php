<?php
$factura = $factura ?? [];
$detalles = $detalles ?? [];
$usuario = $usuario ?? [];
?>

<div class="bg-light min-vh-100" style="padding-top: 76px;">
    <div class="container py-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-dark">
                            <i class="bi bi-receipt text-primary"></i> Factura #<?= $factura['id_factura'] ?>
                        </h1>
                        <p class="text-muted mb-0">Detalle completo de tu compra</p>
                    </div>
                    <div>
                        <a href="<?= base_url('panel/mis-facturas') ?>" class="btn btn-outline-secondary me-2">
                            <i class="bi bi-arrow-left"></i> Volver a Facturas
                        </a>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Información del Cliente -->
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0">
                            <i class="bi bi-person-circle"></i> Información del Cliente
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Nombre:</strong> <?= $usuario['nombre'] ?? 'N/A' ?>
                                    <?= $usuario['apellido'] ?? '' ?></p>
                                <p><strong>Email:</strong> <?= $usuario['email'] ?? 'N/A' ?></p>
                                <p><strong>Teléfono:</strong> <?= $usuario['telefono'] ?? 'N/A' ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>DNI:</strong> <?= $usuario['dni'] ?? 'N/A' ?></p>
                                <p><strong>Fecha de Factura:</strong>
                                    <?= date('d/m/Y H:i', strtotime($factura['fecha_factura'])) ?></p>
                                <p><strong>Número de Factura:</strong> #<?= $factura['id_factura'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detalle de Productos -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0">
                            <i class="bi bi-cart3"></i> Detalle de Productos
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
                                    <?php foreach ($detalles as $detalle): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="<?= base_url('images/' . $detalle['url_imagen']) ?>"
                                                        alt="<?= $detalle['nombre'] ?>" class="img-thumbnail me-3"
                                                        style="width: 50px; height: 50px; object-fit: cover;">
                                                    <div>
                                                        <h6 class="mb-1"><?= $detalle['nombre'] ?></h6>
                                                        <small class="text-muted"><?= $detalle['descripcion'] ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    class="fw-bold"><?= format_currency($detalle['subtotal'] / $detalle['cantidad']) ?></span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-primary"><?= $detalle['cantidad'] ?></span>
                                            </td>
                                            <td class="text-center">
                                                <span class="fw-bold"><?= format_currency($detalle['subtotal']) ?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Resumen de Factura -->
                <div class="card border-0 shadow-sm sticky-top" style="top: 100px;">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0">
                            <i class="bi bi-calculator"></i> Resumen de Factura
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php
                        $subtotal = array_sum(array_column($detalles, 'subtotal'));
                        $total = $factura['importe_total'];
                        ?>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span class="fw-bold"><?= format_currency($subtotal) ?></span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="h5 mb-0">Total:</span>
                            <span class="h5 mb-0 text-primary"><?= format_currency($total) ?></span>
                        </div>

                        <div class="alert alert-success">
                            <i class="bi bi-check-circle"></i>
                            <strong>Estado:</strong> Pagada
                        </div>
                    </div>

                    <!-- Información Adicional -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="bi bi-info-circle"></i> Información Importante
                            </h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled small">
                                <li class="mb-2">
                                    <i class="bi bi-shield-check text-success"></i>
                                    Compra segura y verificada
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-eye text-info"></i>
                                    Factura virtual disponible
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-truck text-warning"></i>
                                    Envío en proceso
                                </li>
                                <li>
                                    <i class="bi bi-headset text-primary"></i>
                                    Soporte disponible 24/7
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {

        .btn,
        .navbar,
        .footer {
            display: none !important;
        }

        .card {
            border: 1px solid #ddd !important;
            box-shadow: none !important;
        }
    }
</style>