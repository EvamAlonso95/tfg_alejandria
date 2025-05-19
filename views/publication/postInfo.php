<?php

/**
 * @var Post $post
 */
require_once 'views/layout/head.php';
?>
<!-- Contenido principal -->
<main class="container py-4">
	<div class="container-post">
		<!-- Imagen destacada -->
		<div class="mb-4 col-12">
			<img src="<?= $post->getCoverImg() ?>" class="img-post border" alt="Imagen del post">
		</div>

		<!-- Título y metadatos -->
		<div class="mb-3 p-2">
			<h2 class="fw-bold"><?= $post->getTitle() ?></h2>
			<!-- TODO - Enlace al perfil del autor -->
			<small class="text-muted p-2"><a href="<?= BASE_URL ?>author?authorId=<?= $post->getAuhtor()->getId() ?>"><?= $post->getAuhtor()->getName() ?></a> - <?= $post->getCreatedAt() ?></small>
		</div>

		<!-- Botón eliminar (si es el autor) -->
		<?php if ($post->getAuhtor()->getId() == $_SESSION['identity']->id): ?>
			<form action="<?= BASE_URL ?>post/delete" method="post" onsubmit="return confirm('¿Estás seguro de eliminar este post?');" class="mb-4">
				<input type="hidden" name="post_id" value="<?= $post->getId(); ?>">
				<button type="submit" class="btn btn-danger btn-sm">
					<i class="bi bi-trash"></i> Eliminar
				</button>
			</form>
		<?php endif; ?>

		<!-- Contenido del post -->
		<div class="bg-light border rounded p-4">
			<p class="mb-0 p-2"><?= nl2br($post->getContent()) ?></p>
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

</div>


<?php require_once 'views/layout/footer.php';
require_once 'views/components/toastDeletePost.php' ?>