<?php

/**
 * @var Book $book
 * @var BookUser $bookUser
 */
?>
<div class="book-card d-flex flex-column  mb-3">
	<div class="me-3 container-img">
		<img src="<?= $book->getCoverImg() ?>" alt="Imagen del libro" class="book-cover img-fluid">
	</div>
	<h6>
		<a href="<?= BASE_URL ?>book?bookId=<?= $book->getId() ?>"><?= $book->getTitle() ?></a>
	</h6>
	<?php foreach ($book->getAuthors() as $author): ?>
		<p class="mb-1">
			<a href="<?= BASE_URL ?>author?authorId=<?= $author->getId() ?>"><?= $author->getName() ?></a>
		</p>
	<?php endforeach; ?>
	
	</div>

</div>