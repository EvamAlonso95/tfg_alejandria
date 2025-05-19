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
							<input type="file" class="form-control" name="cover_img" id="cover_img">
							<small class="text-muted ms-1">Sube una imagen para tu post (opcional)</small>
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




<script>
	// Get the button:
	let mybutton = document.getElementById("myBtn");

	// When the user scrolls down 20px from the top of the document, show the button
	window.onscroll = function() {
		scrollFunction()
	};

	function scrollFunction() {
		if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
			mybutton.style.display = "block";
		} else {
			mybutton.style.display = "none";
		}
	}

	// When the user clicks on the button, scroll to the top of the document
	function topFunction() {
		document.body.scrollTop = 0; // For Safari
		document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
	}
</script>

<?php
require_once 'views/layout/footer.php';
require_once 'views/components/toastDeletePost.php';
