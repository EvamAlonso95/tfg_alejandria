<?php

/**
 * @var Book $book
 * @var Book $bookInfo
 * @var Author[] $authors
 * @var Genre[] $genres
 * @var BookUser $bookUser
 * @var BookUser @book
 * 

 */
var_dump($user);
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
                <?php
                // Comprobar si el usuario tiene libros asignados
                $currentStatus = null;
                $userBooks = false;

                // Obtener todos los libros del usuario
                $books = $bookUser->getBooksByUserId($user->getId());

                if ($books && count($books) > 0) {
                    foreach ($books as $bookEntry) {
                        if ($bookEntry->getBook()->getId() === $bookInfo->getId()) {
                            $userBooks = true;
                            $currentStatus = $bookEntry->getStatus();
                            break;
                        }
                    }
                }
                ?>

                <select class="form-select form-select-sm mt-2" onchange="updateBookStatus(this)">
                    <option disabled <?= !$userBooks ? 'selected' : '' ?>>Añadir a tu biblioteca</option>
                    <option value="want to read" <?= $currentStatus === 'want to read' ? 'selected' : '' ?>>Quiero leer</option>
                    <option value="reading" <?= $currentStatus === 'reading' ? 'selected' : '' ?>>Leyendo</option>
                    <option value="read" <?= $currentStatus === 'read' ? 'selected' : '' ?>>Finalizado</option>
                </select>

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