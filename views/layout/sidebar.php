<div class="col-md-4">
	<div class="sticky-sidebar my-4 d-none d-sm-block">
		<div class="container p-0">
			<!-- Búsqueda -->
			<form action="<?= BASE_URL ?>search">
				<div class="input-group mb-3">
					<span class="input-group-text" id="basic-addon1">
						<!-- Icono lupa -->
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
							class="bi bi-search" viewBox="0 0 16 16">
							<path
								d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
						</svg>
					</span>
					<input type="text" class="form-control" placeholder="Buscar" name="search" required>
				</div>
			</form>

			<!-- Recomendación -->
			<div class="card mb-3 recommendation-card">
				<img src="<?= BASE_URL ?>/assets/img/booksNews.png" class="card-img-top" alt="Libro recomendado">
				<div class="card-body text-center">
					<a href="<?= BASE_URL ?>recommendedBook" class="btn btn-standar btn-sm">Descubre más lecturas</a>
				</div>
			</div>

		

		</div>
	</div>
</div>