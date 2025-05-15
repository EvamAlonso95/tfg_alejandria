<?php

/**
 * @var Post $post
 */
require_once 'views/layout/head.php';
?>
<!-- Contenido principal -->
<main class="container py-4 position-relative">

	<!-- Imagen destacada -->
	<div class="mb-3">
		<img src="<?= $post->getCoverImg() ?>" class="img-fluid border" alt="Imagen del post">
	</div>

	<!-- Título y metadatos -->
	<div class="mb-3">
		<h2><?= $post->getTitle() ?></h2>
		<small class="text-muted"><?= $post->getAuhtor()->getName() ?> - <?= $post->getCreatedAt() ?></small>
	</div>

	<?php if ($post->getAuhtor()->getId() == $_SESSION['identity']->id): ?>
		<form action="<?= BASE_URL ?>post/delete" method="post" onsubmit="return confirm('¿Estás seguro de eliminar este post?');">
			<input type="hidden" name="post_id" value="<?= $post->getId(); ?>">
			<button type="submit" class="btn btn-danger">Eliminar</button>
		</form>
	<?php endif; ?>



	<!-- Contenido del post -->
	<div class="border p-3 bg-light">
		<p><?= $post->getContent() ?></p>
	</div>
</main>
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1100">
	<div id="toastNotification" class="toast bg-success text-white" role="alert" aria-live="assertive" aria-atomic="true">
		<div class="d-flex">
			<div class="toast-body" id="toastBody">
				<!-- Aquí va el mensaje -->
			</div>
			<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Cerrar"></button>
		</div>
	</div>
</div>

<?php require_once 'views/layout/footer.php';
require_once 'views/components/toastDeletePost.php' ?>