<div class="login-container py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="login-box">
                    <h2 class="text-center mb-4">CREAR CUENTA</h2>
                    <p class="text-center mb-4">¡Únete a nuestra comunidad fitness y comienza tu transformación!</p>
                    
                    <form method="post" action="<?php echo base_url('/enviar-form') ?>"
                        class="login-form row g-3 needs-validation" novalidate>
                        <?= csrf_field(); ?>

                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01" class="form-label">NOMBRE</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input name="nombre" type="text" class="form-control" id="validationCustom01"
                                    placeholder="Juan" required>
                            </div>


                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationCustom02" class="form-label">APELLIDO</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input name="apellido" type="text" class="form-control" id="validationCustom02"
                                    placeholder="Pérez" required>
                            </div>



                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationCustomUsername" class="form-label">NOMBRE DE USUARIO</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-at"></i></span>
                                <input name="usuario" type="text" class="form-control" id="validationCustomUsername"
                                    required>
                            </div>



                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationCustom03" class="form-label">CORREO ELECTRÓNICO</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input name="email" type="email" class="form-control" id="validationCustom03" required>
                            </div>


                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationCustom04" class="form-label">PROVINCIA</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                <select name="provincia" class="form-select" id="validationCustom04" required>
                                    <option selected disabled value="">Elija...</option>
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
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationCustom05" class="form-label">CONTRASEÑA</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input name="pass" type="password" class="form-control" id="validationCustom05"
                                    required>
                            </div>



                        </div>

                        <div class="col-12 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                                <label class="form-check-label" for="invalidCheck">
                                    Acepto los términos y condiciones
                                </label>
                            </div>
                        </div>

                        <div class="col-12">
                            <button class="btn btn-primary w-100 mb-3" type="submit">REGISTRARSE</button>
                            <div class="text-center links-container">
                                <a href="<?= base_url('/login') ?>">¿Ya tienes una cuenta? ¡Inicia sesión aquí!</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>