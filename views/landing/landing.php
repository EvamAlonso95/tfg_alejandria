<?php require_once './views/layout/head.php' ?>

<main class="cont-background ">
    <!-- TODO Arreglar la animación -->
    <?php require_once 'views/components/landingAnimation.php'?>

    <div class="container full-page d-flex justify-content-center">

        <section class="quote mt-auto mb-auto" id="quote">
            <div class="quote-text section-bg-image-block">
                <h3 class="p-2" data-aos="zoom-in" data-aos-delay="800">
                    <?= $quote ?>
                </h3>


            </div>


        </section>
    </div>
</main>


<?php require_once './views/layout/footer.php' ?>
