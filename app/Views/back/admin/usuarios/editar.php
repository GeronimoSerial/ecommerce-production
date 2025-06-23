<?php
$usuario = $usuario ?? [];
$validation = $validation ?? \Config\Services::validation();
?>

<div class="bg-light min-vh-100" style="padding-top: 76px;">
    <div class="container py-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-dark">Editar Usuario</h1>
                        <p class="text-muted mb-0">Modifica la información del usuario</p>
                    </div>
                    <div>
                        <a href="<?= base_url('admin/usuarios') ?>" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <!-- Formulario -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-person-gear"></i> Información del Usuario</h5>
                    </div>
                    <div class="card-body">
                        <?php
                        $usuario_id = $usuario['id_usuario'] ?? 0;
                        ?>
                        <form action="<?= base_url('admin/usuarios/editar/' . $usuario_id) ?>" method="post">
                            <?= csrf_field() ?>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nombre" class="form-label">Nombre </label>
                                    <input type="text"
                                        class="form-control <?= ($validation->hasError('nombre')) ? 'is-invalid' : '' ?>"
                                        id="nombre" name="nombre" value="<?= old('nombre', $usuario['nombre'] ?? '') ?>"
                                        disabled>
                                    <?php if ($validation->hasError('nombre')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('nombre') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="apellido" class="form-label">Apellido </label>
                                    <input type="text"
                                        class="form-control <?= ($validation->hasError('apellido')) ? 'is-invalid' : '' ?>"
                                        id="apellido" name="apellido"
                                        value="<?= old('apellido', $usuario['apellido'] ?? '') ?>" disabled>
                                    <?php if ($validation->hasError('apellido')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('apellido') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email </label>
                                <input type="email"
                                    class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : '' ?>"
                                    id="email" name="email" value="<?= old('email', $usuario['email'] ?? '') ?>"
                                    disabled>
                                <?php if ($validation->hasError('email')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('email') ?>
                                    </div>
                                <?php endif; ?>
                            </div>


                            <div class="mb-4">
                                <label for="id_rol" class="form-label">Rol *</label>
                                <select class="form-select <?= ($validation->hasError('id_rol')) ? 'is-invalid' : '' ?>"
                                    id="id_rol" name="id_rol" required>
                                    <option value="">Selecciona un rol</option>
                                    <?php
                                    $current_rol = old('id_rol', $usuario['id_rol'] ?? 2);
                                    ?>
                                    <option value="1" <?= ($current_rol == '1') ? 'selected' : '' ?>>Administrador</option>
                                    <option value="2" <?= ($current_rol == '2') ? 'selected' : '' ?>>Usuario</option>
                                </select>
                                <?php if ($validation->hasError('id_rol')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('id_rol') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-4">
                                <label for="activo" class="form-label">Estado *</label>
                                <select class="form-select <?= ($validation->hasError('activo')) ? 'is-invalid' : '' ?>"
                                    id="activo" name="activo" required>
                                    <option value="">Selecciona el estado</option>
                                    <?php
                                    $current_activo = old('activo', $usuario['activo'] ?? 1);
                                    ?>
                                    <option value="1" <?= ($current_activo == '1') ? 'selected' : '' ?>>Activo</option>
                                    <option value="0" <?= ($current_activo == '0') ? 'selected' : '' ?>>Inactivo</option>
                                </select>
                                <?php if ($validation->hasError('activo')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('activo') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="<?= base_url('admin/usuarios') ?>" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> Actualizar Usuario
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>