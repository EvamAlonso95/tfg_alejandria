<?php

/**  
 * @var Book $book
 */
?>


<div class="col-lg-12 d-flex p-2 container-results">
	<div class=" col-lg-12 col-sm-12 me-3 container-img container-img-results">
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