<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url('public/css/style.css') ?>">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>FitSyn - <?php echo($title);?></title>
</head>
<body>
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
</body>
</html>
