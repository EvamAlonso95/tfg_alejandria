<?php

/**  
 * @var BookUser $book
 */

?>



<div class="col">
	<div class="card h-100">
		<img src="<?= $book->getBook()->getCoverImg() ?>" alt="Imagen del libro" class="card-img-top img-fluid">
		<div class="card-body d-flex flex-column">
			<h6 class="card-title">
				<a href="<?= BASE_URL ?>book?bookId=<?= $book->getBook()->getId() ?>">
					<?= $book->getBook()->getTitle() ?>
				</a>
			</h6>
			<a href="#" class="btn btn-earth mt-auto">Añadir</a>
		</div>
	</div>
</div>