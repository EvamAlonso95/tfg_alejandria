<?php require_once 'views/layout/head.php'; ?>
<main class="full-page p-4">
    <div class="bg-light pt-5 pb-5 min-vh-100">
        <div class="container text-center">
            <h1 class="display-4 font-weight-bold mb-4">Uso de Cookies</h1>
            <p class="lead text-secondary">
                Utilizamos cookies para mejorar tu experiencia en nuestro sitio web. Las cookies nos ayudan a personalizar el contenido, proporcionar funciones de redes sociales y analizar el tráfico.
            </p>
            <p class="text-muted">
                Al continuar navegando, aceptas el uso de cookies. Puedes configurar o rechazar su uso en cualquier momento desde la configuración de tu navegador.
            </p>
            <p class="text-muted">
                Para más información sobre cómo usamos las cookies, puedes consultar nuestra política completa.
            </p>
            <a href="<?= BASE_URL . 'landing/privacyPolicy' ?>" class="btn btn-standar mt-4">Leer política de privacidad</a>
        </div>
    </div>
</main>
<?php require_once 'views/layout/footer.php'; ?>
