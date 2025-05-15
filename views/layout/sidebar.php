<div class="col-md-3 my-4">

	<!-- Búsqueda -->
	<form action="<?= BASE_URL ?>search">
		<div class="input-group mb-3">
			<span class="input-group-text" id="basic-addon1"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
					<path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
				</svg></span>

			<input type="text" class="form-control" placeholder="Buscar" aria-label="Buscar" name="search" aria-describedby="basic-addon1" required>
		</div>
	</form>
	<!-- Recomendación -->

	<div class="card w-16 mb-3 d-flex align-items-center ">
		<img src="<?= BASE_URL ?>/assets/img/default_cover.jpg" class="card-img-top" alt="Portada Libro recomendado">
		<div class="card-body">

			<a href="<?= BASE_URL ?>recommendedBook" class="btn btn-earth btn-sm">Descubre más lecturas</a>
		</div>
	</div>




	<!-- Lectura actual -->
	<div class="card text-center w-16 mb-3">
		<div class="card-body">
			<h6>Estás leyendo...</h6>
			<img src="<?= BASE_URL ?>/assets/img/actual_reading.jpg" class="card-img-top" alt="Portada Libro recomendado">
		</div>
	</div>

</div>