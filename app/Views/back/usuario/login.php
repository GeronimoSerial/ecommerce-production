<div class="login-container py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-box">
                    <h2 class="text-center mb-4">INICIA SESIÓN</h2>
                    <p class="text-center mb-4">¡Bienvenido de nuevo! Accede a tu cuenta para continuar tu viaje fitness
                    </p>

                    <form method="post" action="<?= base_url('login') ?>" class="login-form">
                        <div class="mb-4">
                            <label for="exampleInputEmail1" class="form-label">CORREO ELECTRÓNICO</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input name="email" type="email" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder="tu@email.com" required>
                            </div>
                            <div id="emailHelp" class="form-text">Nunca compartiremos tu dirección de correo electrónico
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="exampleInputPassword1" class="form-label">CONTRASEÑA</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input name="password" type="password" class="form-control" id="exampleInputPassword1"
                                    placeholder="********" required>
                            </div>
                        </div>

                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="remember">
                            <label class="form-check-label" for="exampleCheck1">Mantener sesión iniciada</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-3">INGRESAR</button>

                        <div class="text-center links-container">
                            <!-- <a href="<?= base_url('recuperar') ?>" class="d-block mb-2">¿Has olvidado tu contraseña?</a> -->
                            <a href="<?= base_url('registro') ?>" class="d-block">¿Aún no tienes cuenta? ¡Regístrate
                                ahora!</a>
                        </div>
                    </form>

                    <!-- Datos de prueba -->
                    <div class="card border-info mt-4">
                        <div class="card-header bg-info text-white">Datos de prueba</div>
                        <div class="card-body">
                            <p class="mb-2"><strong>Admin</strong>: usuarioadmin@demo.com | <strong>Contraseña</strong>:
                                Contrasen10!</p>
                            <p class="mb-0"><strong>Usuario</strong>: usuariocliente@demo.com |
                                <strong>Contraseña</strong>: Contrasen10!
                            </p>
                        </div>
                    </div>
                    <!-- Fin card -->
                </div>
            </div>
        </div>
    </div>
</div>