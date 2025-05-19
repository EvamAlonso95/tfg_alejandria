<?php

/**
 * @var Author $author
 * @var Book[] $booksPublished
 */
?>

<?php require_once 'views/layout/head.php'; ?>

<main class="container my-5 full-page">

	<!-- Perfil del autor -->
	<section class="profile-section">
		<div class="row g-4 align-items-start container-profile">
			<!-- Foto -->
			<div class="col-md-3 my-2">
				<div class="profile-card p-3 text-center">
					<img src="<?= $author->getProfileImage() ?>" alt="Foto del autor" class="img-fluid profile-image">
				</div>
			</div>

			<!-- Datos del autor -->
			<div class="col-md-9">
				<div class="profile-card p-4">
					<div class="profile-data">						
						<h2 class="data-value title-author"><?= $author->getName() ?></h2>
					</div>
					<div class="profile-data">
						<span class="data-name">Biografía:</span>
						<span class="data-value"><?= $author->getBiography() ?></span>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Libros del autor -->
	<section class="mt-5 container-similar-books p-4">
		<h5 class="mb-4">Libros del autor</h5>
		<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
			<?php if (!empty($booksPublished)): ?>
				<?php foreach ($booksPublished as $book): ?>
					<?php require 'views/components/bookAuthorCard.php'; ?>
				<?php endforeach; ?>
			<?php else: ?>
				<div class="col-12">
					<p class="text-muted">Este autor aún no tiene libros publicados.</p>
				</div>
			<?php endif; ?>
		</div>
	</section>

</main>

<?php require_once 'views/layout/footer.php'; ?>