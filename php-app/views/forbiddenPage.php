<?php require_once 'views/layout/head.php'; ?>
<main class="full-page p-4">
<div class="bg-light text-center p-5">
	<div class="container">
		<h1 class="display-1 pt-5 font-weight-bold">403</h1>
		<h1 class="display-4 pt-1 pb-3">Forbbiden Page</h1>
		<h3 class="font-weight-light text-secondary">No tienes permisos para acceder a la página</h3>
		<a href="<?= BASE_URL . 'dashboard' ?>" class="btn btn-standar mt-3 pt-3 pb-3 pr-4 pl-4">Volver a la página principal</a>
	</div>
</div>
</main>
<?php require_once 'views/layout/footer.php'; ?>