<!-- Estilos personalizados -->
Link rel="stylesheet" href="<?= base_url('css/registro.css') ?>">

<div class="login-container py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="login-box">
                    <div class="row g-0">
                        <!-- Columna Izquierda - Información Personal -->
                        <div class="col-md-6">
                            <div class="p-4">
                                <h3 class="fw-bold mb-4 text-primary">Información Personal</h3>
                                <?php $validation = \Config\Services::validation(); ?>
                                <form method="post" action="<?= base_url('registro') ?>"
                                    class="needs-validation login-form" novalidate id="registrationForm">
                                    <?= csrf_field(); ?>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-outline">
                                                <label class="form-label" for="validationCustom01">Nombre</label>
                                                <input name="nombre" type="text" placeholder="Juan"
                                                    class="form-control <?= $validation->hasError('nombre') ? 'is-invalid' : '' ?>"
                                                    id="validationCustom01" required
                                                    pattern="^[A-Za-zÁáÉéÍíÓóÚúÑñ\s]{2,50}$"
                                                    title="El nombre debe contener solo letras y espacios, mínimo 2 caracteres">
                                                <?php if ($validation->hasError('nombre')): ?>
                                                    <div class="invalid-feedback">
                                                        <?= $validation->getError('nombre'); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-outline">
                                                <label class="form-label" for="validationCustom02">Apellido</label>
                                                <input name="apellido" type="text"
                                                    class="form-control <?= $validation->hasError('apellido') ? 'is-invalid' : '' ?>"
                                                    id="validationCustom02" placeholder="Perez" required>
                                                <?php if ($validation->hasError('apellido')): ?>
                                                    <div class="invalid-feedback">
                                                        <?= $validation->getError('apellido'); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="form-outline">
                                            <label class="form-label" for="validationCustomDNI">DNI (sin puntos)</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                                <input name="dni" type="text" placeholder="12345678"
                                                    class="form-control <?= $validation->hasError('dni') ? 'is-invalid' : '' ?>"
                                                    id="validationCustomUsername" required pattern="^[0-9]{7,8}$"
                                                    title="Ingrese un DNI válido (7-8 números sin puntos)"
                                                    maxlength="8">
                                                <?php if ($validation->hasError('dni')): ?>
                                                    <div class="invalid-feedback">
                                                        <?= $validation->getError('dni'); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="form-outline">
                                            <label class="form-label" for="validationCustomPhone">Teléfono</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                <input name="telefono" type="tel"
                                                    class="form-control <?= $validation->hasError('telefono') ? 'is-invalid' : '' ?>"
                                                    id="validationCustomPhone" required pattern="^[0-9]{10}$"
                                                    title="Ingrese un número de teléfono válido (10 dígitos)"
                                                    placeholder="1123456789">
                                                <?php if ($validation->hasError('telefono')): ?>
                                                    <div class="invalid-feedback">
                                                        <?= $validation->getError('telefono'); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="form-outline">
                                            <label class="form-label" for="validationCustom03">Email</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                <input name="email" type="email"
                                                    class="form-control <?= $validation->getError('email') ? 'is-invalid' : '' ?>"
                                                    id="validationCustom03" required
                                                    pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                                                    placeholder="ejemplo@correo.com">
                                                <?php if ($validation->getError('email')): ?>
                                                    <div class="invalid-feedback">
                                                        <?= esc($validation->getError('email')); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="form-outline">
                                            <label class="form-label" for="validationCustom05">Contraseña</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                                <input name="password" type="password"
                                                    class="form-control <?= $validation->hasError('password') ? 'is-invalid' : '' ?>"
                                                    id="password" required minlength="6"
                                                    title="La contraseña debe tener al menos 6 caracteres">
                                                <button class="btn btn-outline-secondary" type="button"
                                                    id="togglePassword">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <div class="invalid-feedback">
                                                    La contraseña debe tener al menos 6 caracteres
                                                </div>
                                            </div>
                                            <div class="progress mt-2" style="height: 5px;">
                                                <div class="progress-bar bg-primary" role="progressbar"
                                                    style="width: 0%"></div>
                                            </div>
                                            <small class="form-text text-muted">
                                                La contraseña debe tener al menos 8 caracteres, incluir mayúsculas,
                                                minúsculas, números y caracteres especiales.
                                            </small>
                                        </div>
                                    </div>
                            </div>
                        </div>

                        <!-- Columna Derecha - Información de Domicilio -->
                        <div class="col-md-6">
                            <div class="p-4 position-relative"
                                style="background-color: rgba(229, 52, 90, 0.04); border-left: 2px solid var(--pink);">
                                <div class="mb-4">
                                    <h3 class="fw-bold text-dark d-flex align-items-center">
                                        <i class="fas fa-home text-primary me-2"></i>
                                        Información de Domicilio
                                    </h3>
                                    <p class="text-muted small">Complete los datos de envío</p>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-8">
                                        <div class="form-outline">
                                            <label class="form-label" for="validationCustom08">
                                                <i class="fas fa-road me-1 text-primary"
                                                    style="background-color: #212529"></i>
                                                Calle
                                            </label>
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text bg-white text-primary border-end-0">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                </span>
                                                <input name="calle" type="text"
                                                    class="form-control border-start-0 <?= $validation->hasError('calle') ? 'is-invalid' : '' ?>"
                                                    id="validationCustom08" required
                                                    style="border-radius: 0 8px 8px 0;">
                                                <?php if ($validation->hasError('calle')): ?>
                                                    <div class="invalid-feedback">
                                                        <?= $validation->getError('calle'); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-outline">
                                            <label class="form-label" for="validationCustom09">Número</label>
                                            <input name="numero" type="text"
                                                class="form-control <?= $validation->hasError('numero') ? 'is-invalid' : '' ?>"
                                                id="validationCustom09" required>
                                            <?php if ($validation->hasError('numero')): ?>
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('numero'); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-5">
                                        <div class="form-outline">
                                            <label class="form-label" for="validationCustom10">
                                                <i class="fas fa-mail-bulk me-1 text-primary"></i>
                                                Código Postal
                                            </label>
                                            <input name="codigo_postal" type="text"
                                                class="form-control form-control-lg <?= $validation->hasError('codigo_postal') ? 'is-invalid' : '' ?>"
                                                id="validationCustom10" required placeholder="1234">
                                            <?php if ($validation->hasError('codigo_postal')): ?>
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('codigo_postal'); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="form-outline">
                                            <label class="form-label" for="validationCustom11">
                                                <i class="fas fa-city me-1 text-primary"></i>
                                                Localidad
                                            </label>
                                            <input name="localidad" type="text"
                                                class="form-control form-control-lg <?= $validation->getError('localidad') ? 'is-invalid' : '' ?>"
                                                id="validationCustom11" required>
                                            <?php if ($validation->getError('localidad')): ?>
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('localidad'); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label" for="validationCustom04">
                                            <i class="fas fa-map me-1 text-primary"></i>
                                            Provincia
                                        </label>
                                        <select name="provincia"
                                            class="form-select form-select-lg <?= $validation->getError('provincia') ? 'is-invalid' : '' ?>"
                                            id="validationCustom04" required>
                                            <option selected disabled value="">Seleccionar provincia...</option>
                                            <option value="Buenos Aires">Buenos Aires</option>
                                            <option value="Catamarca">Catamarca</option>
                                            <option value="Chaco">Chaco</option>
                                            <option value="Chubut">Chubut</option>
                                            <option value="Córdoba">Córdoba</option>
                                            <option value="Corrientes">Corrientes</option>
                                            <option value="Entre Ríos">Entre Ríos</option>
                                            <option value="Formosa">Formosa</option>
                                            <option value="Jujuy">Jujuy</option>
                                            <option value="La Pampa">La Pampa</option>
                                            <option value="La Rioja">La Rioja</option>
                                            <option value="Mendoza">Mendoza</option>
                                            <option value="Misiones">Misiones</option>
                                            <option value="Neuquén">Neuquén</option>
                                            <option value="Río Negro">Río Negro</option>
                                            <option value="Salta">Salta</option>
                                            <option value="San Juan">San Juan</option>
                                            <option value="San Luis">San Luis</option>
                                            <option value="Santa Cruz">Santa Cruz</option>
                                            <option value="Santa Fe">Santa Fe</option>
                                            <option value="Santiago del Estero">Santiago del Estero</option>
                                            <option value="Tierra del Fuego">Tierra del Fuego</option>
                                            <option value="Tucumán">Tucumán</option>
                                        </select>
                                        <?php if ($validation->getError('provincia')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('provincia'); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-outline">
                                            <label class="form-label" for="validationCustom12">
                                                <i class="fas fa-globe-americas me-1 text-primary"></i>
                                                País
                                            </label>
                                            <input name="pais" type="text" class="form-control form-control-lg"
                                                id="validationCustom12" value="Argentina" required readonly
                                                style="background-color: rgba(229, 52, 91, 0.05);">
                                        </div>
                                    </div>
                                </div>

                                <div class="alert alert-light border-start border-primary border-4 mt-4 mb-3"
                                    role="alert">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-info-circle text-primary me-2"></i>
                                        <small>Esta dirección será utilizada para los envíos de tus compras</small>
                                    </div>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="invalidCheck" required>
                                    <label class="form-check-label" for="invalidCheck">
                                        Acepto los términos y condiciones
                                    </label>
                                </div>

                                <button type="submit" class="btn btn-primary w-100">
                                    REGISTRARSE
                                </button>

                                <div class="links-container text-center mt-3">
                                    <a href="<?= base_url('/login') ?>">¿Ya tienes una cuenta? ¡Inicia sesión aquí!</a>
                                </div>
                                </form>
                                <!-- Notificación de éxito -->
                                <?php if (session()->getFlashdata('success')): ?>
                                    <div class="success-notification alert alert-success alert-dismissible fade show"
                                        role="alert">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-check-circle me-2"></i>
                                            <strong>¡Registro exitoso!</strong>
                                        </div>
                                        <p class="mb-0 mt-2"><?= session()->getFlashdata('success') ?></p>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        <div class="countdown">
                                            <div class="countdown-bar"></div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('js/registro.js') ?>"></script>