<?php require_once './views/layout/head.php' ?>

<main class="">
    <!-- TODO Arreglar la animación -->
    <?php require_once 'views/components/landingAnimation.php' ?>

    <div class="container full-page d-flex justify-content-center">

        <section class="quote mt-auto mb-auto" id="quote">
            <div class="quote-text section-bg-image-block">
                <h3 class="p-2" data-aos="zoom-in" data-aos-delay="800">
                    <?= $quote ?>
                </h3>


            </div>


        </section>
    </div>
    <div class="cookie-banner" id="cookieBanner">
        <div class="cookie-text">
            ¡Hola, lector!
            Usamos cookies para que tu experiencia sea tan fluida como un buen capítulo. ¿Te parece bien? <svg xmlns="http://www.w3.org/2000/svg" height="15" width="15" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                <path fill="#3d405b" d="M247.2 17c-22.1-3.1-44.6 .9-64.4 11.4l-74 39.5C89.1 78.4 73.2 94.9 63.4 115L26.7 190.6c-9.8 20.1-13 42.9-9.1 64.9l14.5 82.8c3.9 22.1 14.6 42.3 30.7 57.9l60.3 58.4c16.1 15.6 36.6 25.6 58.7 28.7l83 11.7c22.1 3.1 44.6-.9 64.4-11.4l74-39.5c19.7-10.5 35.6-27 45.4-47.2l36.7-75.5c9.8-20.1 13-42.9 9.1-64.9l-14.6-82.8c-3.9-22.1-14.6-42.3-30.7-57.9L388.9 57.5c-16.1-15.6-36.6-25.6-58.7-28.7L247.2 17zM208 144a32 32 0 1 1 0 64 32 32 0 1 1 0-64zM144 336a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm224-64a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
            </svg>
            <a href="<?=BASE_URL . 'landing/cookies'?>" class="custom-link">Leer más</a>.
        </div>
        <button class="btn btn-standar col-12 col-md-2" id="acceptCookies">Aceptar</button>
    </div>
</main>

<script>
    document.getElementById('acceptCookies').addEventListener('click', function() {
        document.getElementById('cookieBanner').classList.add('hide');
    });
</script>
<?php require_once './views/layout/footer.php' ?>