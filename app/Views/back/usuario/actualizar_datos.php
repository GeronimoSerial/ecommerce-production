<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Mis datos personales y domicilio</h5>
                </div>
                <div class="card-body">
                    <h2 class="mb-4 text-center">Actualizar mis datos personales y domicilio</h2>
                    <p class="text-muted text-center mb-4">Todos los campos son obligatorios salvo teléfono.</p>
                    <form method="post" action="<?= base_url('actualizar') ?>"
                        onsubmit="this.nombre.value=this.nombre.value.trim();this.apellido.value=this.apellido.value.trim();this.email.value=this.email.value.trim();this.calle.value=this.calle.value.trim();this.numero.value=this.numero.value.trim();this.codigo_postal.value=this.codigo_postal.value.trim();this.localidad.value=this.localidad.value.trim();this.provincia.value=this.provincia.value.trim();this.pais.value=this.pais.value.trim();">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre"
                                    value="<?= esc($nombre) ?>" required autofocus>
                            </div>
                            <div class="col-md-6">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="apellido" name="apellido"
                                    value="<?= esc($apellido) ?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div clas="col-md-6">
                                <label for="dni" class="form-label">DNI</label>
                                <input type="text" class="form-control" id="dni" name="dni" value="<?= esc($dni) ?>"
                                    required>

                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label for="password" class="form-label">Contraseña </label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Dejar en blanco si no desea cambiarla
                                    ">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="<?= esc($email) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono"
                                    value="<?= esc($telefono) ?>">
                            </div>
                        </div>
                        <hr>
                        <h6 class="mb-3">Domicilio</h6>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="calle" class="form-label">Calle</label>
                                <input type="text" class="form-control" id="calle" name="calle"
                                    value="<?= esc($calle) ?>" required>
                            </div>
                            <div class="col-md-3">
                                <label for="numero" class="form-label">Número</label>
                                <input type="text" class="form-control" id="numero" name="numero"
                                    value="<?= esc($numero) ?>" required>
                            </div>
                            <div class="col-md-3">
                                <label for="codigo_postal" class="form-label">Código Postal</label>
                                <input type="text" class="form-control" id="codigo_postal" name="codigo_postal"
                                    value="<?= esc($codigo_postal) ?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="localidad" class="form-label">Localidad</label>
                                <input type="text" class="form-control" id="localidad" name="localidad"
                                    value="<?= esc($localidad) ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="provincia" class="form-label">Provincia</label>
                                <input type="text" class="form-control" id="provincia" name="provincia"
                                    value="<?= esc($provincia) ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="pais" class="form-label">País</label>
                                <input type="text" class="form-control" id="pais" name="pais" value="<?= esc($pais) ?>"
                                    required>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-success">Guardar cambios</button>
                        </div>
                    </form>
                    <hr class="my-4">
                    <div class="text-start mt-3">
                        <a href="<?= base_url('panel') ?>" class="btn btn-secondary">Volver al panel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>