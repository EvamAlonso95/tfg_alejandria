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
			<a href="<?= BASE_URL ?>book?bookId=<?= $book->getId() ?>"><?= $book->getTitle() ?></a>
		</h6>
		<?php foreach ($book->getAuthors() as $author): ?>
			<p class="mb-1">
				<a href="<?= BASE_URL ?>author?authorId=<?= $author->getId() ?>"><?= $author->getName() ?></a>
			</p>
		<?php endforeach; ?>


	</div>
</div>