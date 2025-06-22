<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= csrf_meta() ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/notifications.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/navbar_styles.css') ?>">
    <script src="<?= base_url('js/notifications.js') ?>" defer></script>
    <title>FitSyn - <?php echo ($title); ?></title>
</head>

<body>
    <?= view('templates/notifications') ?>

    <header>
        <?= view('templates/navbar_view') ?>
    </header>

    <main>
        <?= $content ?? '' ?>
    </main>

    <footer>
        <?= view('templates/footer_view') ?>
    </footer>


    <!-- Scripts -->

    <script src="<?= base_url('js/navbar.js') ?>"></script>
    <script src="<?= base_url('js/script.js') ?>"></script>
    <script src="<?= base_url('js/cart.js') ?>"></script>
</body>

</html>