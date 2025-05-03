<?php

/**
 * @var Book $book
 * @var Author[] $authors
 * @var Genre[] $genres

 */
// var_dump($book);
?>
<main class="py-4">
    <div class="container">
        <div class="row">
            <!-- Portada -->
            <div class="col-md-4 mb-3">
                <img src="<?= $book->getCoverImg() ?>" alt="Imagen del libro" class="img-fluid">
                <!-- Reemplaza el div por <img src="..." class="img-fluid"> si tienes imagen real -->
            </div>

            <!-- Datos del libro -->
            <div class="col-md-8">
                <h2><?= $book->getTitle() ?></h2>
                <?php
                // Autores
                $authorNames = [];
                foreach ($book->getAuthors() as $author) {
                    $authorNames[] = $author->getName();
                }
                ?>

                <p><strong>Autores:</strong> <a href="<?= base_url ?>author?authorId=<?= $author->getId() ?>"> <?= implode(', ', $authorNames) ?></a></p>

                <?php
                // Géneros
                $genreNames = [];
                foreach ($book->getGenres() as $genre) {
                    $genreNames[] = $genre->getName();
                }
                ?>

                <p><strong>Géneros:</strong> <?= implode(', ', $genreNames) ?></p>



                <p><strong>Descripción:</strong></p>
                <p><?= $book->getSynopsis() ?></p>
            </div>
        </div>

        <!-- Libros similares -->
        <div class="mt-5">
            <h5>Libros similares</h5>
            <div class="row gy-3">
                <!-- Libro relacionado -->
                <div class="col-sm-6 col-md-4">
                    <div class="border p-2">
                        <div class="bg-secondary mb-2" style="width: 100%; height: 150px;"></div>
                        <h6 class="mb-0">Título relacionado</h6>
                        <small>Autor</small>
                    </div>
                </div>

                <!-- Duplica este bloque para más libros similares -->
            </div>
        </div>
    </div>
</main>