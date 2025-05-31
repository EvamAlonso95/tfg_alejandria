<?php

/**
 * @var Book $book
 * @var Book[] $recommendedBooks
 * @var BookUser|null $bookUser
 */
?>
<?php require_once 'views/layout/head.php'; ?>

<main class="container my-5 full-page">

	<!-- Datos del libro -->
	<section class="book-section">
		<div class="row g-4 align-items-center container-book">
			<!-- Portada -->
			<div class="col-md-3 my-2">
				<div class="book-card p-3 text-center">
					<img src="<?= $book->getCoverImg() ?>" alt="Imagen del libro" class="img-fluid book-image">
				</div>
			</div>

			<!-- Información del libro -->
			<div class="col-md-9">
				<div class="book-card p-4">
					<div class="book-data">
						<h2 class="data-value"><?= $book->getTitle() ?></h2>
					</div>

					<!-- Autores -->
					<?php
					$authorLinks = [];
					foreach ($book->getAuthors() as $author) {
						$url = BASE_URL . 'author?authorId=' . $author->getId();
						$authorLinks[] = '<a class="custom-link" href="' . $url . '">' . $author->getName() . '</a>';
					}
					?>
					<div class="book-data">
						<span class="data-name">Autores:</span>
						<span class="data-value"><?= implode(', ', $authorLinks) ?></span>
					</div>

					<!-- Géneros -->
					<?php
					$genreNames = array_map(fn($genre) => $genre->getName(), $book->getGenres());
					?>
					<div class="book-data">
						<span class="data-name">Géneros:</span>
						<span class="data-value"><?= implode(', ', $genreNames) ?></span>
					</div>

					<!-- Sinopsis -->
					<div class="book-data">
						<span class="data-name">Descripción:</span>
						<p class="data-value"><?= $book->getSynopsis() ?></p>
					</div>

					<!-- Estado del usuario -->
					<div class="mt-3">
						<?php if (!$bookUser): ?>
							<a href="<?= BASE_URL ?>book/addLibrary?bookId=<?= $book->getId() ?>" class="btn btn-standar w-100">Añadir a la biblioteca</a>
						<?php else:
							$status = $bookUser->getStatus();
						?>
							<div class="row g-2 align-items-stretch">
								<!-- Formulario para cambiar estado -->
								<div class="col-12 col-md-6">
									<form method="POST" action="<?= BASE_URL ?>book/updateBookStatus">
										<div class="row g-2 align-items-stretch">
											<div class="col-12 col-md-6">
												<select name="status" class="form-select w-100 h-100">
													<option value="want to read" <?= $status === 'want to read' ? 'selected' : '' ?>>Quiero leer</option>
													<option value="reading" <?= $status === 'reading' ? 'selected' : '' ?>>Leyendo</option>
													<option value="read" <?= $status === 'read' ? 'selected' : '' ?>>Finalizado</option>
												</select>
											</div>
											<div class="col-12 col-md-6">
												<input type="hidden" name="bookId" value="<?= $book->getId() ?>">
												<input type="submit" class="btn btn-standar w-100 h-100" value="Guardar Estado">
											</div>
										</div>
									</form>
								</div>

								<!-- Botón de eliminar -->
								<div class="col-12 col-md-6">
									<a href="<?= BASE_URL ?>book/removeLibrary?bookId=<?= $book->getId() ?>" class="btn btn-delete-style w-100 h-100 d-flex align-items-center justify-content-center">Eliminar de la biblioteca</a>
								</div>
							</div>

					</div>
				<?php endif; ?>
				</div>

			</div>
		</div>
		</div>
	</section>

	<!-- Libros similares -->
	<?php require_once 'views/book/similarBooks.php' ?>

</main>

<script>
	const toastData = <?= json_encode($toastData) ?>;
</script>
<?php require_once 'views/layout/footer.php'; ?>