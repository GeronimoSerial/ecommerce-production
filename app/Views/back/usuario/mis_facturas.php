<?php
$facturas = $facturas ?? [];
?>

<div class="bg-light min-vh-100" style="padding-top: 76px;">
    <div class="container py-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-dark">
                            <i class="bi bi-receipt text-primary"></i> Mis Facturas
                        </h1>
                        <p class="text-muted mb-0">Historial de todas tus compras</p>
                    </div>
                    <div>
                        <a href="<?= base_url('panel') ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Volver al Panel
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Facturas -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0">
                    <i class="bi bi-list-ul"></i> Lista de Facturas
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Número</th>
                                <th>Fecha</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($facturas)): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                                        <h5 class="text-muted mt-3">No tienes facturas aún</h5>
                                        <p class="text-muted">Realiza tu primera compra para ver aquí tus facturas</p>
                                        <a href="<?= base_url() ?>" class="btn btn-primary">
                                            <i class="bi bi-cart-plus"></i> Ir a Comprar
                                        </a>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($facturas as $factura): ?>
                                    <tr>
                                        <td>
                                            <strong>#<?= $factura['id_factura'] ?></strong>
                                        </td>
                                        <td>
                                            <i class="bi bi-calendar3 text-muted me-1"></i>
                                            <?= date('d/m/Y H:i', strtotime($factura['fecha_factura'])) ?>
                                        </td>
                                        <td class="text-center">
                                            <span class="fw-bold text-success">
                                                <?= format_currency($factura['importe_total']) ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle me-1"></i>Pagada
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?= base_url('panel/factura/' . $factura['id_factura']) ?>" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i> Ver Detalle
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Información Adicional -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title">
                            <i class="bi bi-info-circle text-info"></i> Información Importante
                        </h6>
                        <ul class="list-unstyled small">
                            <li class="mb-2">
                                <i class="bi bi-check2 text-success me-2"></i>
                                Todas tus facturas están disponibles aquí
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-eye text-primary me-2"></i>
                                Puedes ver tus facturas virtuales en cualquier momento
                            </li>
                            <li>
                                <i class="bi bi-clock text-info me-2"></i>
                                Historial completo de todas tus compras
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title">
                            <i class="bi bi-question-circle text-warning"></i> ¿Necesitas Ayuda?
                        </h6>
                        <p class="card-text small">
                            Si tienes alguna pregunta sobre tus facturas o necesitas asistencia, 
                            no dudes en contactarnos.
                        </p>
                        <a href="<?= base_url('contacto') ?>" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-headset"></i> Contactar Soporte
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-effect:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}
</style> 