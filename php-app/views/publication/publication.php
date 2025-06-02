<?php
require_once 'views/layout/head.php'; ?>


<!-- Main content -->
<main class="container my-5 full-page">
	<div class="row">
		<!-- Historial de publicaciones -->
		<div class="col-md-8 mb-4 order-2 order-md-1">
			<h5 class="title-post">Tus publicaciones</h5>
			<?php require_once 'views/components/publicationLayout.php'; ?>
		</div>

		<!-- Formulario de publicación sticky -->

		<div class="col-md-4 mb-4 order-1 order-md-2">
			<div class="sticky-form">
				<h5 class="title-post">Nuevo post</h5>
				<form action="<?= BASE_URL ?>post/save" method="post" enctype="multipart/form-data">
					<div class="border p-3 bg-light h-100">
						<!-- Imagen -->
						<div class="mb-3">
							<input type="file" required class="form-control" accept="image/*" name="cover_img" id="cover_img">
							<small class="text-muted ms-1">Sube una imagen para tu post</small>
						</div>
						<!-- Título -->
						<div class="mb-3">
							<input type="text" class="form-control" placeholder="Título" name="title" required>
						</div>
						<!-- Texto -->
						<div class="mb-3">
							<textarea class="form-control" rows="4" placeholder="Texto" name="content"></textarea>
						</div>
						<!-- Botón -->
						<div class="d-grid">
							<button type="submit" class="btn btn-standar">Publicar</button>
						</div>
					</div>
				</form>
			</div>
		</div>

	</div>
	<!-- TODO REVISAR EL BOTON Y EL SCRIPT -->
	<button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>
</main>
<script>
	const toastData = <?= json_encode($toastData) ?>;
</script>
<?php
require_once 'views/components/scrollUp.php';

require_once 'views/layout/footer.php';
