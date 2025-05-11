<?php

/**
 *  @var Book $book
 * @var BookUser $bookUser
 */
?>
<div class="book-card d-flex flex-column  mb-3">
    <div class="me-3 container-img">
        <img src="<?= $book->getCoverImg() ?>" alt="Imagen del libro" class="book-cover img-fluid">
    </div>
    <h6>
        <a href="<?= base_url ?>book?bookId=<?= $book->getId() ?>"><?= $book->getTitle() ?></a>
    </h6>
    <?php foreach ($book->getAuthors() as $author): ?>
        <p class="mb-1">
            <a href="<?= base_url ?>author?authorId=<?= $author->getId() ?>"><?= $author->getName() ?></a>
        </p>
    <?php endforeach; ?>
    <!-- Dropdown para estado de lectura -->
    <div class="dropdown mt-2">
        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php if ($bookUser->getStatus() == 'want to read'): ?>
                Quiero leer
            <?php elseif ($bookUser->getStatus() == 'reading'): ?>
                Leyendo
            <?php elseif ($bookUser->getStatus() == 'read'): ?>
                Finalizado
            <?php endif; ?>
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?= base_url ?>user/changeBookStatus?bookId=<?= $book->getId() ?>&userId=<?= $user->getId() ?>&status=reading">Leyendo</a></li>
            <li><a class="dropdown-item" href="<?= base_url ?>user/changeBookStatus?bookId=<?= $book->getId() ?>&userId=<?= $user->getId() ?>&status='want to read'">Quiero leer</a></li>
            <li><a class="dropdown-item" href="<?= base_url ?>user/changeBookStatus?bookId=<?= $book->getId() ?>&userId=<?= $user->getId() ?>&status=read">Finalizado</a></li>
        </ul>
    </div>

</div>