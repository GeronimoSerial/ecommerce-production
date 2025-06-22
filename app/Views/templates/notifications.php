<!-- Mensajes Flash Globales -->
<div class="notification-container">
    <?php if (session()->getFlashData('msg')): ?>
        <div class="custom-alert alert-success">
            <div class="alert-header">
                <strong>¡Éxito!</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div class="alert-body">
                <?= session()->getFlashData('msg') ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashData('success')): ?>
        <div class="custom-alert alert-success">
            <div class="alert-header">
                <strong>¡Éxito!</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div class="alert-body">
                <?= session()->getFlashData('success') ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashData('error')): ?>
        <div class="custom-alert alert-danger">
            <div class="alert-header">
                <strong>¡Error!</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div class="alert-body">
                <?= session()->getFlashData('error') ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashData('info')): ?>
        <div class="custom-alert alert-info">
            <div class="alert-header">
                <strong>Información</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div class="alert-body">
                <?= session()->getFlashData('info') ?>
            </div>
        </div>
    <?php endif; ?>
</div>