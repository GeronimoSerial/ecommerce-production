<!-- app/Views/errors/custom_404.php -->

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Página no encontrada</title>
    <style>
        body {

            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }

        .error-container {
            max-width: 600px;
            margin: auto;
            height: 70vh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .error-code {
            font-size: 120px;
            font-weight: bold;
            color: #dc3545;
            margin: 0;
        }

        .error-message {
            font-size: 24px;
            margin: 20px 0;
        }

        .error-description {
            font-size: 18px;
            margin-bottom: 30px;
            color: #6c757d;
        }

        .home-link {
            display: inline-block;
            padding: 12px 24px;
            background-color: #007bff;
            color: #fff;
            border-radius: 6px;
            text-decoration: none;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        .home-link:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <div class="error-container">
        <h1 class="error-code">404</h1>
        <h2 class="error-message">Página no encontrada</h2>
        <p class="error-description">Lo sentimos, pero la página que estás buscando no existe</p>
        <a href="<?= base_url() ?>" class="home-link">Volver al inicio</a>
    </div>

</body>

</html>