<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicia sesión</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url ?>/assets/css/landing_styles.css">
</head>

<body class=" d-flex flex-column align-items-center min-vh-100">
    <header class=" shadow-sm py-3 mb-4 w-100">
        <div class="container-fluid d-flex align-items-center ps-3 gap-2">
            <a href="<?= base_url ?>" class="d-flex align-items-center text-decoration-none">
                <img src="<?= base_url ?>/assets/img/logo_prueba.png" alt="Logo de Alejandría" style="height: 40px;">
                <span class="h5 mb-0 text-dark fw-bold ms-2">Alejandría</span>
            </a>
        </div>
    </header>



    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm p-4">
                    <h2 class="mb-4 text-center">Inicia sesión</h2>
                    <form method="post" action="<?= base_url ?>index">
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Tu correo" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                        </div>
                    </form>
                    <div class="mt-3 text-center">
                        <span>¿No tienes cuenta? <a href="<?= base_url ?>user/register">Regístrate</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>