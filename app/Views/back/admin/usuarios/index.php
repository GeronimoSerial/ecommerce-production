<?php
$usuarios = $usuarios ?? [];
?>

<div class="bg-light min-vh-100" style="padding-top: 76px;">
    <div class="container py-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-dark">Gestión de Usuarios</h1>
                        <p class="text-muted mb-0">Administra los usuarios del sistema</p>
                    </div>
                    <div>
                        <a href="<?= base_url('admin') ?>" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Volver
                        </a>
                        <a href="<?= base_url('admin/usuarios/crear') ?>" class="btn btn-primary">
                            <i class="bi bi-person-plus"></i> Nuevo Usuario
                        </a>
                    </div>
                </div>
            </div>
        </div>



        <!-- Tabla de Usuarios -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-people"></i> Lista de Usuarios</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($usuarios)): ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="bi bi-inbox text-muted" style="font-size: 2rem;"></i>
                                        <p class="text-muted mt-2 mb-0">No hay usuarios registrados</p>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($usuarios as $usuario): ?>
                                    <tr>
                                        <td><?= $usuario['id_usuario'] ?? 'N/A' ?></td>
                                        <td><?= $usuario['nombre'] ?? 'N/A' ?></td>
                                        <td><?= $usuario['apellido'] ?? 'N/A' ?></td>
                                        <td><?= $usuario['email'] ?? 'N/A' ?></td>
                                        <td>
                                            <?php
                                            $id_rol = $usuario['id_rol'] ?? 2;
                                            if ($id_rol == 1): ?>
                                                <span class="badge bg-danger">Administrador</span>
                                            <?php elseif ($id_rol == 2): ?>
                                                <span class="badge bg-primary">Usuario</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Desconocido</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php
                                            $activo = $usuario['activo'] ?? 1;
                                            if ($activo == 1): ?>
                                                <span class="badge bg-success">Activo</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Inactivo</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <?php
                                                $usuario_id = $usuario['id_usuario'] ?? 0;
                                                if ($usuario_id > 0):
                                                    ?>
                                                    <a href="<?= base_url('admin/usuarios/editar/' . $usuario_id) ?>"
                                                        class="btn btn-sm btn-outline-primary" title="Editar">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <a href="<?= base_url('admin/usuarios/eliminar/' . $usuario_id) ?>"
                                                        class="btn btn-sm btn-outline-danger" title="Eliminar"
                                                        onclick="return confirm('¿Estás seguro de que quieres eliminar este usuario?')">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted">No disponible</span>
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

        <!-- Estadísticas Rápidas -->
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-people text-primary" style="font-size: 2rem;"></i>
                        <h4 class="mt-2 mb-0"><?= count($usuarios) ?></h4>
                        <p class="text-muted mb-0">Total Usuarios</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-shield-check text-danger" style="font-size: 2rem;"></i>
                        <h4 class="mt-2 mb-0">
                            <?= count(array_filter($usuarios, function ($u) {
                                $id_rol = $u['id_rol'] ?? 2;
                                return $id_rol == 1;
                            })) ?>
                        </h4>
                        <p class="text-muted mb-0">Administradores</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-person text-primary" style="font-size: 2rem;"></i>
                        <h4 class="mt-2 mb-0">
                            <?= count(array_filter($usuarios, function ($u) {
                                $id_rol = $u['id_rol'] ?? 2;
                                return $id_rol == 2;
                            })) ?>
                        </h4>
                        <p class="text-muted mb-0">Usuarios</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-check-circle text-success" style="font-size: 2rem;"></i>
                        <h4 class="mt-2 mb-0">
                            <?= count(array_filter($usuarios, function ($u) {
                                $activo = $u['activo'] ?? 1;
                                return $activo == 1;
                            })) ?>
                        </h4>
                        <p class="text-muted mb-0">Activos</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>