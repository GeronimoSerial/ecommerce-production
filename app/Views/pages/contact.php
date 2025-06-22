<!-- Sección de Contacto -->
<div class="contact-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="text-center mb-5">
                    <span class="badge bg-danger px-3 py-2 mb-3">CONTACTO</span>
                    <h1 class="display-5 fw-bold mb-3">¿Tienes alguna pregunta?</h1>
                    <p class="lead text-muted">Estamos aquí para ayudarte. Completa el formulario y nos pondremos en
                        contacto contigo lo antes posible.</p>
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

                <div class="card border-0 shadow-lg rounded-4 bg-hero">
                    <div class="card-body p-4 p-md-5">
                        <form action="<?= base_url('contacto/enviar') ?>" method="POST" id="contactForm">
                            <div class="row g-4">
                                <?php if (!$usuario): ?>
                                    <!-- Campos para usuarios no logueados -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nombre" class="form-label fw-bold">Nombre</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-danger text-white border-0">
                                                    <i class="bi bi-person"></i>
                                                </span>
                                                <input type="text" class="form-control" id="nombre" name="nombre" required
                                                    placeholder="Tu nombre" value="<?= old('nombre') ?>">
                                            </div>
                                            <?php if (isset($validation) && $validation->hasError('nombre')): ?>
                                                <div class="text-danger mt-2">
                                                    <?= $validation->getError('nombre') ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email" class="form-label fw-bold">Email</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-danger text-white border-0">
                                                    <i class="bi bi-envelope"></i>
                                                </span>
                                                <input type="email" class="form-control" id="email" name="email" required
                                                    placeholder="tu@email.com" value="<?= old('email') ?>">
                                            </div>
                                            <?php if (isset($validation) && $validation->hasError('email')): ?>
                                                <div class="text-danger mt-2">
                                                    <?= $validation->getError('email') ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <!-- Información del usuario logueado -->
                                    <div class="col-12">
                                        <div class="alert alert-info">
                                            <i class="bi bi-info-circle me-2"></i>
                                            <strong>Enviando como:</strong> <?= $usuario['nombre'] . ' ' . $usuario['apellido'] ?> 
                                            (<?= $usuario['email'] ?>)
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="asunto" class="form-label fw-bold">Asunto</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-danger text-white border-0">
                                                <i class="bi bi-tag"></i>
                                            </span>
                                            <input type="text" class="form-control" id="asunto" name="asunto" required
                                                placeholder="Asunto de tu mensaje" value="<?= old('asunto') ?>">
                                        </div>
                                        <?php if (isset($validation) && $validation->hasError('asunto')): ?>
                                            <div class="text-danger mt-2">
                                                <?= $validation->getError('asunto') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="mensaje" class="form-label fw-bold">Mensaje</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-danger text-white border-0">
                                                <i class="bi bi-chat"></i>
                                            </span>
                                            <textarea class="form-control" id="mensaje" name="mensaje" rows="5" required
                                                placeholder="Escribe tu mensaje aquí..."><?= old('mensaje') ?></textarea>
                                        </div>
                                        <?php if (isset($validation) && $validation->hasError('mensaje')): ?>
                                            <div class="text-danger mt-2">
                                                <?= $validation->getError('mensaje') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-danger w-100 py-3 fw-bold">
                                        ENVIAR MENSAJE
                                        <i class="bi bi-send ms-2"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Información de Contacto -->
                <div class="row g-4 mt-5">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm text-center p-4 h-100">
                            <div class="card-body">
                                <i class="bi bi-geo-alt fs-1 text-danger mb-3"></i>
                                <h4 class="fw-bold">Ubicación</h4>
                                <p class="text-muted mb-0">Calle Ejercicio 99, Corrientes, Argentina</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm text-center p-4 h-100">
                            <div class="card-body">
                                <i class="bi bi-telephone fs-1 text-danger mb-3"></i>
                                <h4 class="fw-bold">Teléfono</h4>
                                <p class="text-muted mb-0">+54 123 456 789</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm text-center p-4 h-100">
                            <div class="card-body">
                                <i class="bi bi-envelope fs-1 text-danger mb-3"></i>
                                <h4 class="fw-bold">Email</h4>
                                <p class="text-muted mb-0">info@fitsyn.com</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información Legal de la Empresa -->
                <div class="card border-0 shadow-lg rounded-4 mt-5">
                    <div class="card-body p-4">
                        <h3 class="fw-bold text-center mb-4">Información Legal</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h5 class="fw-bold"><i class="bi bi-person-badge text-danger me-2"></i>Titular de
                                        la Empresa</h5>
                                     <a href="https://geroserial.com" class="text-muted">Geronimo Serial</a>
                                </div>
                                <div class="mb-3">
                                    <h5 class="fw-bold"><i class="bi bi-building text-danger me-2"></i>Razón Social</h5>
                                    <p class="text-muted">FitSyn S.A.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h5 class="fw-bold"><i class="bi bi-geo-alt text-danger me-2"></i>Domicilio Legal
                                    </h5>
                                    <p class="text-muted">Calle Fitness 88, Corrientes, Argentina</p>
                                </div>
                                <div class="mb-3">
                                    <h5 class="fw-bold"><i class="bi bi-telephone text-danger me-2"></i>Teléfonos
                                        Adicionales</h5>
                                    <p class="text-muted">Oficina Central: +54 379 4123456<br>Atención al Cliente:
                                        0800-123-4567</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-0">
                                    <h5 class="fw-bold"><i class="bi bi-info-circle text-danger me-2"></i>Información
                                        Adicional</h5>
                                    <p class="text-muted mb-0">CUIT: 30-71234567-8<br>Horario de Atención: Lunes a
                                        Viernes de 9:00 a 18:00 hs</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>