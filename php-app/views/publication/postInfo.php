<?php

/**
 * @var Post $post
 */

try {
	$authorId = Author::createByUserId($_SESSION['identity']->id)->getId();
} catch (Exception $e) {
	$authorId = null;
}
require_once 'views/layout/head.php';
?>
<!-- Contenido principal -->
<main class="container py-4 full-page">
	<div class="container-post">
		<!-- Imagen destacada -->
		<div class="mb-4 col-12">
			<img src="<?= $post->getCoverImg() ?>" class="img-post border" alt="Imagen del post">
		</div>

		<div class="mb-3 ms-3 p-2 d-flex gap-4 align-items-center">
			<h2 class="fw-bold m-0"><?= $post->getTitle() ?></h2>

			<?php if ($post->getAuhtor()->getId() == $authorId): ?>
				<form action="<?= BASE_URL ?>post/delete" method="post" onsubmit="return confirm('¿Estás seguro de eliminar este post?');">
					<input type="hidden" name="post_id" value="<?= $post->getId(); ?>">
					<button type="submit" class="btn btn-delete-style btn-delete-post m">
						<i class="bi bi-trash"></i> Eliminar
					</button>
				</form>
			<?php endif; ?>
		</div>

		<!-- Metadatos -->
		<div class="mb-3 ms-3 p-2">
			<small class="text-muted">
				<a class="custom-link" href="<?= BASE_URL ?>author?authorId=<?= $post->getAuhtor()->getId() ?>">
					<?= $post->getAuhtor()->getName() ?>
				</a> - <?= $post->getCreatedAt() ?>
			</small>
		</div>

		<!-- Contenido del post -->
		<div class="bg-light border rounded p-4">
			<p class="mb-0 p-2"><?= nl2br($post->getContent()) ?></p>
		</div>
</main>



<?php require_once 'views/layout/footer.php';
