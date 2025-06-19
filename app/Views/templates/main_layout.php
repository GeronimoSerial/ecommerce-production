<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url('public/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/css/admin.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/css/notifications.css') ?>">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('public/js/notifications.js') ?>" defer></script>
    <title>FitSyn - <?php echo ($title); ?></title>
</head>

<body>
    <!-- Mensajes Flash Globales -->
    <div class="notification-container">
        <?php if (session()->getFlashData('msg')): ?>
            <div class="custom-alert alert-success">
                <div class="alert-header">
                    <strong>¡Éxito!</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
                <div class="alert-body">
                    <?= session()->getFlashData('msg') ?>
                </div>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashData('error')): ?>
            <div class="custom-alert alert-danger">
                <div class="alert-header">
                    <strong>¡Error!</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
                <div class="alert-body">
                    <?= session()->getFlashData('error') ?>
                </div>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashData('debug')): ?>
            <div class="custom-alert alert-info">
                <div class="alert-header">
                    <strong>Información</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
                <div class="alert-body">
                    <?= session()->getFlashData('debug') ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <header>
        <?= view('front/navbar_view') ?>
    </header>

    <main>
        <?= $content ?? '' ?>
    </main>

    <footer>
        <?= view('front/footer_view') ?>
    </footer>

    <!-- Scripts -->
    <script src="<?= base_url('public/js/script.js') ?>"></script>
    <script src="<?= base_url('public/js/navbar.js') ?>"></script>
</body>

</html>