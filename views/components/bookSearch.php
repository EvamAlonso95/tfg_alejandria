<?php

/**  
 * @var Book $book
 */

// var_dump($book);
?>
<div class="col-12 d-flex border p-2">
    <div class="me-3 container-img">
        <!-- imagen -->
        <img src="<?= $book->getCoverImg() ?>" alt="Imagen del libro" class="img-fluid">
    </div>
    <div>
        <h6>
            <a href="<?= base_url ?>book?bookId=<?= $book->getId() ?>"><?= $book->getTitle() ?></a>
        </h6>
        <?php foreach ($book->getAuthors() as $author): ?>
            <p class="mb-1">
                <a href="<?= base_url ?>author?authorId=<?= $author->getId() ?>"><?= $author->getName() ?></a>
            </p>
        <?php endforeach; ?>

        <a href="<?= base_url ?>search/saveBookUser?bookId=<?= $book->getId() ?>&userId=<?= $user->getId() ?>" class="btn btn-outline-primary btn-sm">Añadir</a>
    </div>
</div>