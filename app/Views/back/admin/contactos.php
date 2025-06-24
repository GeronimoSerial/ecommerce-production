<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="bi bi-chat-dots text-primary me-2"></i>
                    Gestión de Contactos
                </h1>
                <a href="<?= base_url('admin') ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Volver
                </a>
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

            <!-- Estadísticas -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="mb-0"><?= $estadisticas['total'] ?></h4>
                                    <p class="mb-0">Total Contactos</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="bi bi-chat-dots fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="mb-0"><?= $estadisticas['no_leidos'] ?></h4>
                                    <p class="mb-0">Nuevos mensajes</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="bi bi-envelope fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="mb-0"><?= $estadisticas['no_respondidos'] ?></h4>
                                    <p class="mb-0">Sin Responder</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="bi bi-question-circle fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="mb-0"><?= $estadisticas['hoy'] ?></h4>
                                    <p class="mb-0">Hoy</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="bi bi-calendar-day fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de Contactos -->
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="bi bi-list-ul me-2"></i>
                        Lista de Contactos
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Usuario</th>
                                    <th>Asunto</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($contactos)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <i class="bi bi-inbox text-muted fs-1 d-block mb-2"></i>
                                            <p class="text-muted mb-0">No hay contactos registrados</p>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($contactos as $contacto): ?>
                                        <tr class="<?= !$contacto['leido'] ? 'table-warning' : '' ?>">
                                            <td>
                                                <span class="badge bg-secondary">#<?= $contacto['id_contacto'] ?></span>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong><?= $contacto['nombre'] ?></strong>
                                                    <br>
                                                    <small class="text-muted">
                                                        <?= $contacto['email'] ?>
                                                        <?php if ($contacto['id_usuario']): ?>
                                                            <span class="badge bg-info ms-1">Registrado</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-secondary ms-1">Anónimo</span>
                                                        <?php endif; ?>
                                                    </small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-truncate" style="max-width: 200px;"
                                                    title="<?= $contacto['asunto'] ?>">
                                                    <?= $contacto['asunto'] ?>
                                                </div>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    <?= date('d/m/Y H:i', strtotime($contacto['fecha_envio'])) ?>
                                                </small>
                                            </td>
                                            <td>
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
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= base_url('contacto/detalle/' . $contacto['id_contacto']) ?>"
                                                        class="btn btn-sm btn-outline-primary" title="Ver detalle">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <!--  -->
                                                    <?php if (!$contacto['respondido']): ?>
                                                        <button type="button"
                                                            class="btn btn-sm btn-outline-success responder-contacto"
                                                            data-id="<?= $contacto['id_contacto'] ?>"
                                                            data-asunto="<?= $contacto['asunto'] ?>" title="Responder">
                                                            <i class="bi bi-reply"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para responder contacto -->
<div class="modal fade" id="responderModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-reply text-primary me-2"></i>
                    Responder Contacto
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formResponder" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Asunto del contacto:</label>
                        <p class="text-muted" id="asuntoContacto"></p>
                    </div>
                    <div class="mb-3">
                        <label for="respuesta" class="form-label fw-bold">Tu respuesta:</label>
                        <textarea class="form-control" id="respuesta" name="respuesta" rows="6"
                            placeholder="Escribe tu respuesta aquí..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send me-2"></i>Enviar Respuesta
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?= base_url('js/contactos.js') ?>" defer></script>