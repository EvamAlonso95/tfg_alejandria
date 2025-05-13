<?php

/**
 * @var Book $book
 * @var Book $bookInfo
 * @var Author[] $authors
 * @var Genre[] $genres

 */
// var_dump($book);
// var_dump($bookInfo);
// var_dump($recommendedBooks);

?>
<main class="py-4">
    <div class="container">
        <div class="row">
            <!-- Portada -->
            <div class="col-md-4 mb-3">
                <img src="<?= $bookInfo->getCoverImg() ?>" alt="Imagen del libro" class="img-fluid">
                <!-- Reemplaza el div por <img src="..." class="img-fluid"> si tienes imagen real -->
            </div>

            <!-- Datos del libro -->
            <div class="col-md-8">
                <h2><?= $bookInfo->getTitle() ?></h2>
                <?php
                // Autores
                $authorNames = [];
                foreach ($bookInfo->getAuthors() as $author) {
                    $authorNames[] = $author->getName();
                }
                ?>

                <p><strong>Autores:</strong> <a href="<?= base_url ?>author?authorId=<?= $author->getId() ?>"> <?= implode(', ', $authorNames) ?></a></p>

                <?php
                // Géneros
                $genreNames = [];
                foreach ($bookInfo->getGenres() as $genre) {
                    $genreNames[] = $genre->getName();
                }
                ?>

                <p><strong>Géneros:</strong> <?= implode(', ', $genreNames) ?></p>



                <p><strong>Descripción:</strong></p>
                <p><?= $bookInfo->getSynopsis() ?></p>
            </div>
        </div>

        <!-- Libros similares -->
        <div class="mt-5">
            <h5>Libros similares</h5>
            <?php foreach ($recommendedBooks as $recommendedBook): ?>
                <div class="row gy-3">
                    <!-- Libro relacionado -->
                    <div class="col-sm-6 col-md-4">
                        <div class="border p-2">
                            <img src="<?= $recommendedBook->getCoverImg() ?>" alt="Imagen del libro" class="img-fluid style=" width: 100%; height: 150px;">

                            <h6 class="mb-0"><?= $recommendedBook->getTitle() ?></h6>
                            <?php
                            // Autores
                            $authorNames = [];
                            foreach ($recommendedBook->getAuthors() as $author) {
                                $authorNames[] = $author->getName();
                            }
                            ?>

                            <p><small>Autor/es:</small> <a href="<?= base_url ?>author?authorId=<?= $author->getId() ?>"> <?= implode(', ', $authorNames) ?></a></p>
                        </div>
                    </div>
                <?php
            endforeach;
                ?>

                <!-- Duplica este bloque para más libros similares -->
                </div>
        </div>
    </div>
</main>