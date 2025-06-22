<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="bi bi-chat-dots text-primary me-2"></i>
                    Mi Mensaje #<?= $contacto['id_contacto'] ?>
                </h1>
                <a href="<?= base_url('contacto/mis-contactos') ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Volver a Mis Contactos
                </a>
            </div>

            <div class="row">
                <!-- Información del Contacto -->
                <div class="col-md-8">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">
                                <i class="bi bi-info-circle me-2"></i>
                                Mi Mensaje
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-muted">Asunto:</label>
                                        <p class="mb-0"><?= $contacto['asunto'] ?></p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-muted">Mi mensaje:</label>
                                        <div class="border rounded p-3 bg-light">
                                            <?= nl2br(htmlspecialchars($contacto['mensaje'])) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-muted">Fecha de envío:</label>
                                        <p class="mb-0"><?= date('d/m/Y H:i:s', strtotime($contacto['fecha_envio'])) ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-muted">Estado:</label>
                                        <div>
                                            <?php if (!$contacto['respondido']): ?>
                                                <span class="badge bg-warning">
                                                    <i class="bi bi-clock me-1"></i>En espera de respuesta
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-success">
                                                    <i class="bi bi-check-circle me-1"></i>Respondido
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Respuesta del Administrador -->
                    <?php if ($contacto['respondido']): ?>
                        <div class="card shadow-sm">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">
                                    <i class="bi bi-reply me-2"></i>
                                    Respuesta del Equipo de Soporte
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-muted">Respondido por:</label>
                                            <p class="mb-0"><?= $contacto['nombre_admin'] ?? 'Equipo de Soporte' ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-muted">Fecha de respuesta:</label>
                                            <p class="mb-0"><?= date('d/m/Y H:i:s', strtotime($contacto['fecha_respuesta'])) ?></p>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-muted">Respuesta:</label>
                                            <div class="border rounded p-3 bg-success bg-opacity-10">
                                                <?= nl2br(htmlspecialchars($contacto['respuesta'])) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- Mensaje de espera -->
                        <div class="card shadow-sm">
                            <div class="card-header bg-warning text-white">
                                <h5 class="mb-0">
                                    <i class="bi bi-clock me-2"></i>
                                    Mensaje en Proceso
                                </h5>
                            </div>
                            <div class="card-body text-center">
                                <i class="bi bi-hourglass-split text-warning" style="font-size: 3rem;"></i>
                                <h5 class="mt-3">Tu mensaje está siendo revisado</h5>
                                <p class="text-muted">
                                    Nuestro equipo de soporte revisará tu consulta y te responderá lo antes posible. 
                                    Normalmente respondemos en un plazo de 24-48 horas.
                                </p>
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>
                                    <strong>Consejo:</strong> Mientras esperas, puedes revisar nuestras 
                                    <a href="<?= base_url('/') ?>" class="alert-link">preguntas frecuentes</a> 
                                    o explorar nuestros productos.
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Panel lateral -->
                <div class="col-md-4">
                    <!-- Información del Mensaje -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">
                                <i class="bi bi-info-circle me-2"></i>
                                Información del Mensaje
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">ID del mensaje:</label>
                                <p class="mb-0">#<?= $contacto['id_contacto'] ?></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Tipo de mensaje:</label>
                                <p class="mb-0">
                                    <span class="badge bg-primary">Consulta de Usuario</span>
                                </p>
                            </div>
                            <div class="mb-0">
                                <label class="form-label fw-bold text-muted">Enviado desde:</label>
                                <p class="mb-0"><?= $contacto['email'] ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Acciones Rápidas -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">
                                <i class="bi bi-lightning me-2"></i>
                                Acciones Rápidas
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="<?= base_url('contacto') ?>" class="btn btn-outline-primary">
                                    <i class="bi bi-plus-circle me-2"></i>Nuevo Mensaje
                                </a>
                                <a href="<?= base_url('contacto/mis-contactos') ?>" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>Ver Todos Mis Mensajes
                                </a>
                                <a href="<?= base_url('panel') ?>" class="btn btn-outline-info">
                                    <i class="bi bi-house me-2"></i>Ir al Panel
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Información de Soporte -->
                    <div class="card shadow-sm mt-4">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-headset me-2"></i>
                                ¿Necesitas Ayuda?
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="small text-muted mb-2">
                                Si tienes alguna pregunta adicional o necesitas asistencia urgente:
                            </p>
                            <ul class="list-unstyled small">
                                <li><i class="bi bi-telephone text-success me-2"></i>+54 123 456 789</li>
                                <li><i class="bi bi-envelope text-primary me-2"></i>soporte@fitsyn.com</li>
                                <li><i class="bi bi-clock text-warning me-2"></i>Lun-Vie 9:00-18:00</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 