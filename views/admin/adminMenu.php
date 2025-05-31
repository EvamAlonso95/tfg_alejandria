<div class="container my-4 d-flex justify-content-center">
	<div class="btn-group" role="group" aria-label="Basic example">
		<a href="<?= BASE_URL ?>admin" class="btn btn-standar btn-lg <?= str_contains($_SERVER['QUERY_STRING'], 'index') ? 'active' : '' ?>">Usuarios</a>
		<a href="<?= BASE_URL ?>admin/books" class="btn btn-standar btn-lg <?= str_contains($_SERVER['QUERY_STRING'], 'books') ? 'active' : '' ?>">Libros</a>
		<a href="<?= BASE_URL ?>admin/authors" class="btn btn-standar btn-lg  <?= str_contains($_SERVER['QUERY_STRING'], 'authors') ? 'active' : '' ?>">Autores</a>
		<a href="<?= BASE_URL ?>admin/genres" class="btn btn-standar btn-lg <?= str_contains($_SERVER['QUERY_STRING'], 'genres') ? 'active' : '' ?>">Géneros</a>
	</div>
</div>