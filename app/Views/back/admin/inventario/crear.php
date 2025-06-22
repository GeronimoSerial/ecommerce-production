<?php
$categorias = $categorias ?? [];
$validation = $validation ?? \Config\Services::validation();
?>

<div class="bg-light min-vh-100" style="padding-top: 76px;">
    <div class="container py-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-dark">Crear Nuevo Producto</h1>
                        <p class="text-muted mb-0">Agrega un nuevo producto al inventario</p>
                    </div>
                    <div>
                        <a href="<?= base_url('admin/inventario') ?>" class="btn btn-secondary">
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
                        <h5 class="mb-0"><i class="bi bi-box-seam"></i> Información del Producto</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('admin/inventario/crear') ?>" method="post">
                            <?= csrf_field() ?>

                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre del Producto *</label>
                                <input type="text"
                                    class="form-control <?= ($validation->hasError('nombre')) ? 'is-invalid' : '' ?>"
                                    id="nombre" name="nombre" value="<?= old('nombre') ?>" required>
                                <?php if ($validation->hasError('nombre')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('nombre') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción *</label>
                                <textarea
                                    class="form-control <?= ($validation->hasError('descripcion')) ? 'is-invalid' : '' ?>"
                                    id="descripcion" name="descripcion" rows="4"
                                    required><?= old('descripcion') ?></textarea>
                                <?php if ($validation->hasError('descripcion')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('descripcion') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="precio" class="form-label">Precio *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number"
                                            class="form-control <?= ($validation->hasError('precio')) ? 'is-invalid' : '' ?>"
                                            id="precio" name="precio" value="<?= old('precio') ?>" step="0.01" min="0"
                                            required>
                                        <?php if ($validation->hasError('precio')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('precio') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="cantidad" class="form-label">Cantidad en Stock *</label>
                                    <input type="number"
                                        class="form-control <?= ($validation->hasError('cantidad')) ? 'is-invalid' : '' ?>"
                                        id="cantidad" name="cantidad" value="<?= old('cantidad') ?>" min="0" required>
                                    <?php if ($validation->hasError('cantidad')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('cantidad') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="id_categoria" class="form-label">Categoría *</label>
                                <select
                                    class="form-select <?= ($validation->hasError('id_categoria')) ? 'is-invalid' : '' ?>"
                                    id="id_categoria" name="id_categoria" required>
                                    <option value="">Selecciona una categoría</option>
                                    <?php foreach ($categorias as $categoria): ?>
                                        <option value="<?= $categoria['id_categoria'] ?>"
                                            <?= (old('id_categoria') == $categoria['id_categoria']) ? 'selected' : '' ?>>
                                            <?= $categoria['nombre'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if ($validation->hasError('id_categoria')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('id_categoria') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-4">
                                <label for="imagen" class="form-label">URL de la Imagen</label>
                                <input type="url" class="form-control" id="imagen" name="imagen"
                                    value="<?= old('imagen') ?>" placeholder="https://ejemplo.com/imagen.jpg">
                                <div class="form-text text-muted">Deja en blanco para usar imagen por defecto</div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="<?= base_url('admin/inventario') ?>" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> Crear Producto
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>