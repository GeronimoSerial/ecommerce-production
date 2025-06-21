<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="bi bi-chat-dots text-primary me-2"></i>
                    Mis Contactos
                </h1>
                <div>
                    <a href="<?= base_url('contacto') ?>" class="btn btn-primary me-2">
                        <i class="bi bi-plus-circle me-2"></i>Nuevo Contacto
                    </a>
                    <a href="<?= base_url('panel') ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Volver al Panel
                    </a>
                </div>
            </div>

            <!-- Mensajes de éxito/error -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Lista de Contactos -->
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="bi bi-list-ul me-2"></i>
                        Historial de Contactos
                    </h5>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($contactos)): ?>
                        <div class="text-center py-5">
                            <i class="bi bi-inbox text-muted fs-1 d-block mb-3"></i>
                            <h5 class="text-muted">No tienes contactos registrados</h5>
                            <p class="text-muted mb-4">¿Tienes alguna pregunta? ¡No dudes en contactarnos!</p>
                            <a href="<?= base_url('contacto') ?>" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-2"></i>Crear Primer Contacto
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Asunto</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($contactos as $contacto): ?>
                                        <tr>
                                            <td>
                                                <span class="badge bg-secondary">#<?= $contacto['id_contacto'] ?></span>
                                            </td>
                                            <td>
                                                <div class="text-truncate" style="max-width: 300px;" title="<?= $contacto['asunto'] ?>">
                                                    <strong><?= $contacto['asunto'] ?></strong>
                                                </div>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    <?= date('d/m/Y H:i', strtotime($contacto['fecha_envio'])) ?>
                                                </small>
                                            </td>
                                            <td>
                                                <?php if (!$contacto['respondido']): ?>
                                                    <span class="badge bg-warning">
                                                        <i class="bi bi-clock me-1"></i>En espera
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-check-circle me-1"></i>Respondido
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('contacto/detalle/' . $contacto['id_contacto']) ?>" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   title="Ver detalle">
                                                    <i class="bi bi-eye me-1"></i>Ver
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Información Adicional -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title">
                                <i class="bi bi-info-circle text-info me-2"></i>¿Cómo funciona?
                            </h6>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <i class="bi bi-1-circle text-primary me-2"></i>
                                    Envía tu consulta desde la página de contacto
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-2-circle text-primary me-2"></i>
                                    Nuestro equipo la revisará y te responderá
                                </li>
                                <li class="mb-0">
                                    <i class="bi bi-3-circle text-primary me-2"></i>
                                    Podrás ver la respuesta aquí mismo
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title">
                                <i class="bi bi-question-circle text-warning me-2"></i>¿Necesitas Ayuda?
                            </h6>
                            <p class="card-text small">
                                Si tienes alguna pregunta sobre tus contactos o necesitas asistencia, 
                                no dudes en contactarnos.
                            </p>
                            <a href="<?= base_url('contacto') ?>" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-headset me-1"></i>Contactar Soporte
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 