<?php

/**
 * @var Book $book
 * @var Book[] $recommendedBook
 * @var BookUser $bookUser
 * 
 */
// var_dump($user);
// var_dump($book);
// var_dump($recommendedBooks);

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
				/** @var string[] $authorLinks */
				$authorLinks = [];
				foreach ($book->getAuthors() as $author) {
					// Escapamos el nombre para evitar XSS
					$url  = BASE_URL . 'author?authorId=' . $author->getId();

					$authorLinks[] = '<a href="' . $url . '">' . $author->getName() . '</a>';
				}
				?>
				<p>
					<strong>Autores:</strong>
					<?= implode(', ', $authorLinks) ?>
				</p>
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
				<?php if (!$bookUser): ?>
					<a href="<?= BASE_URL ?>book/addLibrary?bookId=<?= $book->getId() ?>" class="btn btn-standar">Añadir a la biblioteca</a>
				<?php else:
					$status = $bookUser->getStatus()
				?>

					<select class="form-select form-select-sm mt-2">
						<option value="want to read" <?= $status === 'want to read' ? 'selected' : '' ?>>Quiero leer</option>
						<option value="reading" <?= $status === 'reading' ? 'selected' : '' ?>>Leyendo</option>
						<option value="read" <?= $status === 'read' ? 'selected' : '' ?>>Finalizado</option>
					</select>
					<a href="<?= BASE_URL ?>book/removeLibrary?bookId=<?= $book->getId() ?>" class="btn btn-danger mt-5">Eliminar de la biblioteca</a>
				<?php endif; ?>



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

							<p><small>Autor/es:</small> <a href="<?= BASE_URL ?>author?authorId=<?= $author->getId() ?>"> <?= implode(', ', $authorNames) ?></a></p>
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