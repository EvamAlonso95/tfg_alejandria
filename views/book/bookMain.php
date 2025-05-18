<?php

/**
 * @var Book $book
 * @var Book[] $recommendedBooks
 * @var BookUser|null $bookUser
 */
?>
<?php require_once 'views/layout/head.php'; ?>

<main class="container my-5">

	<!-- Datos del libro -->
	<section class="book-section">
		<div class="row g-4 align-items-start container-book">
			<!-- Portada -->
			<div class="col-md-3 my-2">
				<div class="profile-card p-3 text-center">
					<img src="<?= $book->getCoverImg() ?>" alt="Imagen del libro" class="img-fluid book-image">
				</div>
			</div>

			<!-- Información del libro -->
			<div class="col-md-9">
				<div class="profile-card p-4">
					<div class="profile-data">
						<h2 class="data-value"><?= $book->getTitle() ?></h2>
					</div>

					<!-- Autores -->
					<?php
					$authorLinks = [];
					foreach ($book->getAuthors() as $author) {
						$url = BASE_URL . 'author?authorId=' . $author->getId();
						$authorLinks[] = '<a href="' . $url . '">' . $author->getName() . '</a>';
					}
					?>
					<div class="profile-data">
						<span class="data-name">Autores:</span>
						<span class="data-value"><?= implode(', ', $authorLinks) ?></span>
					</div>

					<!-- Géneros -->
					<?php
					$genreNames = array_map(fn($genre) => $genre->getName(), $book->getGenres());
					?>
					<div class="profile-data">
						<span class="data-name">Géneros:</span>
						<span class="data-value"><?= implode(', ', $genreNames) ?></span>
					</div>

					<!-- Sinopsis -->
					<div class="profile-data">
						<span class="data-name">Descripción:</span>
						<p class="data-value"><?= $book->getSynopsis() ?></p>
					</div>

					<!-- Estado del usuario -->
					<div class="mt-3">
						<?php if (!$bookUser): ?>
							<a href="<?= BASE_URL ?>book/addLibrary?bookId=<?= $book->getId() ?>" class="btn btn-standar">Añadir a la biblioteca</a>
						<?php else:
							$status = $bookUser->getStatus();
						?>
							<select class="form-select form-select-sm mt-2">
								<option value="want to read" <?= $status === 'want to read' ? 'selected' : '' ?>>Quiero leer</option>
								<option value="reading" <?= $status === 'reading' ? 'selected' : '' ?>>Leyendo</option>
								<option value="read" <?= $status === 'read' ? 'selected' : '' ?>>Finalizado</option>
							</select>
							<a href="<?= BASE_URL ?>book/removeLibrary?bookId=<?= $book->getId() ?>" class="btn btn-danger mt-3">Eliminar de la biblioteca</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Libros similares -->
	<div class="mt-5">
		<h5>Libros similares</h5>
		<div class="row gy-3">
			<?php foreach ($recommendedBooks as $recommendedBook): ?>
				<div class="col-sm-6 col-md-4">
					<div class="border p-2 h-100">
						<img src="<?= $recommendedBook->getCoverImg() ?>" alt="Imagen del libro" class="img-fluid" style="width: 100%; height: 150px; object-fit: cover;">
						<h6 class="mt-2 mb-0"><?= $recommendedBook->getTitle() ?></h6>

						<?php
						$authorNames = [];
						foreach ($recommendedBook->getAuthors() as $author) {
							$authorNames[] = $author->getName();
						}
						?>
						<p class="mb-0"><small>Autor/es:</small> <?= implode(', ', $authorNames) ?></p>
						<a href="<?= BASE_URL ?>book/view?bookId=<?= $recommendedBook->getId() ?>" class="btn btn-link p-0">Ver más</a>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>

</main>

<?php require_once 'views/layout/footer.php'; ?>
