<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="bi bi-chat-dots text-primary me-2"></i>
                    Detalle del Contacto #<?= $contacto['id_contacto'] ?>
                </h1>
                <a href="<?= base_url('contacto/admin') ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Volver a Contactos
                </a>
            </div>

            <div class="row">
                <!-- Información del Contacto -->
                <div class="col-md-8">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">
                                <i class="bi bi-info-circle me-2"></i>
                                Información del Contacto
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-muted">Nombre:</label>
                                        <p class="mb-0"><?= $contacto['nombre'] ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-muted">Email:</label>
                                        <p class="mb-0"><?= $contacto['email'] ?></p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-muted">Asunto:</label>
                                        <p class="mb-0"><?= $contacto['asunto'] ?></p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-muted">Mensaje:</label>
                                        <div class="border rounded p-3 bg-light">
                                            <?= nl2br(htmlspecialchars($contacto['mensaje'])) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-muted">Fecha de envío:</label>
                                        <p class="mb-0"><?= date('d/m/Y H:i:s', strtotime($contacto['fecha_envio'])) ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-muted">Estado:</label>
                                        <div>
                                            <?php if (!$contacto['leido']): ?>
                                                <span class="badge bg-warning">
                                                    <i class="bi bi-envelope me-1"></i>Nuevo mensaje
                                                </span>
                                            <?php elseif (!$contacto['respondido']): ?>
                                                <span class="badge bg-danger">
                                                    <i class="bi bi-question-circle me-1"></i>Sin responder
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
                                    Respuesta del Administrador
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-muted">Respondido por:</label>
                                            <p class="mb-0"><?= $contacto['nombre_admin'] ?? 'Administrador' ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-muted">Fecha de respuesta:</label>
                                            <p class="mb-0">
                                                <?= date('d/m/Y H:i:s', strtotime($contacto['fecha_respuesta'])) ?>
                                            </p>
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
                        <!-- Formulario para responder -->
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">
                                    <i class="bi bi-reply me-2"></i>
                                    Responder Contacto
                                </h5>
                            </div>
                            <div class="card-body">
                                <form action="<?= base_url('contacto/responder/' . $contacto['id_contacto']) ?>"
                                    method="POST">
                                    <div class="mb-3">
                                        <label for="respuesta" class="form-label fw-bold">Tu respuesta:</label>
                                        <textarea class="form-control" id="respuesta" name="respuesta" rows="6"
                                            placeholder="Escribe tu respuesta aquí..." required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-send me-2"></i>Enviar Respuesta
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Panel lateral -->
                <div class="col-md-4">
                    <!-- Información del Usuario -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">
                                <i class="bi bi-person me-2"></i>
                                Información del Usuario
                            </h5>
                        </div>
                        <div class="card-body">
                            <?php if ($contacto['id_usuario']): ?>
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-muted">Tipo de usuario:</label>
                                    <p class="mb-0">
                                        <span class="badge bg-info">Usuario Registrado</span>
                                    </p>
                                </div>
                                <?php if ($contacto['nombre_usuario']): ?>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-muted">Nombre completo:</label>
                                        <p class="mb-0"><?= $contacto['nombre_usuario'] ?></p>
                                    </div>
                                <?php endif; ?>
                                <?php if ($contacto['email_usuario']): ?>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-muted">Email registrado:</label>
                                        <p class="mb-0"><?= $contacto['email_usuario'] ?></p>
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-muted">Tipo de usuario:</label>
                                    <p class="mb-0">
                                        <span class="badge bg-secondary">Usuario Anónimo</span>
                                    </p>
                                </div>
                                <p class="text-muted small">
                                    Este contacto fue enviado por un usuario no registrado en el sistema.
                                </p>
                            <?php endif; ?>
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
                                <a href="mailto:<?= $contacto['email'] ?>?subject=Re: <?= $contacto['asunto'] ?>"
                                    class="btn btn-outline-primary">
                                    <i class="bi bi-envelope me-2"></i>Enviar Email
                                </a>

                                <a href="<?= base_url('contacto/admin') ?>" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>Volver a Lista
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Marcar como leído
        document.querySelectorAll('.marcar-leido').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.dataset.id;

                fetch(`<?= base_url('contacto/marcar-leido/') ?>${id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.remove();
                            location.reload();
                        } else {
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error al marcar como leído');
                    });
            });
        });
    });
</script> -->