<?php require_once 'views/layout/head.php'; ?>
<div class="bg-light text-center pt-5" style="height: 100vh;">
	<div class="container">
		<h1 class="display-1 pt-5 font-weight-bold">404</h1>
		<h1 class="display-4 pt-1 pb-3">Página no encotrada</h1>
		<h3 class="font-weight-light text-secondary">La página que estás buscando pudo haber sido <strong>borrada</strong></h3>
		<a href="<?= BASE_URL . 'dashboard' ?>" class="btn btn-standar mt-3 pt-3 pb-3 pr-4 pl-4">Volver a la página principal</a>
	</div>
</div>
<?php require_once 'views/layout/footer.php'; ?>