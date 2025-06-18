<?php if (!empty(session()->getFlashdata('fail'))): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
<?php endif; ?>
<?php if (!empty(session()->getFlashdata('success'))): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
<?php endif; ?>

<div class="login-container py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="card card-registration-2 overflow-hidden">
                    <div class="row g-0">
                        <!-- Columna Izquierda - Información Personal -->
                        <div class="col-lg-6 bg-light">
                            <div class="p-4">
                                <h3 class="fw-bold mb-4" style="color: var(--pink);">Información Personal</h3>

                                <?php $validation = \Config\Services::validation(); ?>
                                <form method="post" action="<?= base_url('registro') ?>" class="needs-validation"
                                    novalidate>
                                    <?= csrf_field(); ?>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-outline">
                                                <label class="form-label" for="validationCustom01">Nombre</label>
                                                <input name="nombre" type="text" placeHolder="Juan"
                                                    class="form-control <?= $validation->hasError('nombre') ? 'is-invalid' : '' ?>"
                                                    id="validationCustom01" required>
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
                                            <label class="form-label" for="validationCustomDNI">DNI (sin
                                                puntos)</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                                <input name="dni" type="text" placeholder="12345678"
                                                    class="form-control <?= $validation->hasError('dni') ? 'is-invalid' : '' ?>"
                                                    id="validationCustomUsername" required>
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
                                            <label class="form-label" for="validationCustomPhone">Telefono</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                <input name="telefono" type="text"
                                                    class="form-control <?= $validation->hasError('telefono') ? 'is-invalid' : '' ?>"
                                                    id="validationCustomPhone" required>
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
                                                    id="validationCustom03" required>
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
                                                    id="validationCustom05" required>
                                                <?php if ($validation->hasError('password')): ?>
                                                    <div class="invalid-feedback">
                                                        <?= esc($validation->getError('password')); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>

                    <!-- Columna Derecha - Información de Domicilio -->
                    <div class="col-lg-6 bg-dark text-white">
                        <div class="p-4">
                            <h3 class="fw-bold mb-4">Información de Domicilio</h3>

                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <div class="form-outline">
                                        <label class="form-label text-white" for="validationCustom08">Calle</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white text-danger"><i
                                                    class="fas fa-map-marker-alt"></i></span>
                                            <input name="calle" type="text"
                                                class="form-control <?= $validation->hasError('calle') ? 'is-invalid' : '' ?>"
                                                id="validationCustom08" required>
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
                                        <label class="form-label text-white" for="validationCustom09">Número</label>
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
                                        <label class="form-label text-white" for="validationCustom10">C.P.</label>
                                        <input name="codigo_postal" type="text"
                                            class="form-control <?= $validation->hasError('codigo_postal') ? 'is-invalid' : '' ?>"
                                            id="validationCustom10" required>
                                        <?php if ($validation->hasError('codigo_postal')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('codigo_postal'); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-outline">
                                        <label class="form-label text-white" for="validationCustom11">Localidad</label>
                                        <input name="localidad" type="text"
                                            class="form-control <?= $validation->getError('localidad') ? 'is-invalid' : '' ?>"
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
                                    <label class="form-label text-white" for="validationCustom04">Provincia</label>
                                    <select name="provincia"
                                        class="form-select <?= $validation->getError('provincia') ? 'is-invalid' : '' ?>"
                                        id="validationCustom04" required>
                                        <option selected disabled value="">Seleccionar...</option>
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
                                        <label class="form-label text-white" for="validationCustom12">País</label>
                                        <input name="pais" type="text" class="form-control" id="validationCustom12"
                                            value="Argentina" required readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="invalidCheck" required>
                                <label class="form-check-label text-white" for="invalidCheck">
                                    Acepto los términos y condiciones
                                </label>
                            </div>

                            <button type="submit" class="btn btn-light w-100">
                                REGISTRARSE
                            </button>

                            <div class="text-center mt-3">
                                <a href="<?= base_url('/login') ?>" class="text-white">¿Ya tienes una cuenta?
                                    ¡Inicia sesión aquí!</a>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>