<?php require_once './views/layout/head.php' ?>

<main class="container-fluid text-center">


    <section class="hero" id="hero">
        <div class="heroText section-bg-image-block">
            <h1 class="mt-5 p-2 mb-lg-4" data-aos="zoom-in" data-aos-delay="800">
                <?= $quote ?>
            </h1>


        </div>

        <div class="videoWrapper ">
            <img src="./assets/img/books.jpeg " alt="Imagen fondo landing" srcset="" class="custom-video">
        </div>

        <div class="overlay"></div>
    </section>
</main>


<?php require_once './views/layout/footer.php' ?>
<?php /*
    <img src="./assets/img/logo_prueba.png" alt="Logo Alejandría" class="img-fluid mb-4" style="max-width: 300px;">
    <div>
        <p class="fs-4 fst-italic"><?= $quote ?></p>
    </div>

    */ ?>