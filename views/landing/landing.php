<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a Alejandría</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/landingStyles.css">
</head>

<body>

    <!-- Header / Navbar simple -->
    <header class=" shadow-sm py-3 mb-4">
        <div class="container d-flex justify-content-end">
            <a href="<?= base_url ?>user/register" class="btn btn-outline-primary me-2">Regístrate</a>
            <a href="<?= base_url ?>user/login" class="btn btn-primary">Inicia sesión</a>
        </div>
    </header>

    <!-- Contenido principal -->
    <main class="container text-center">

        <img src="./assets/img/logo_prueba.png" alt="Logo Alejandría" class="img-fluid mb-4" style="max-width: 300px;">
        <div>
            <p class="fs-4 fst-italic">"Frase literaria random"</p>
        </div>
    </main>



    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>