<?php

/**
 *  @var Book $book
 */
?>
<div class="book-card">
    <img src="<?= $book->getCoverImg() ?>" alt="Imagen del libro" class="book-cover img-fluid">
    <h6>
        <a href="<?= base_url ?>book?bookId=<?= $book->getId() ?>"><?= $book->getTitle() ?></a>
    </h6>
    <p><?= $book->getSynopsis() ?></p>
</div>