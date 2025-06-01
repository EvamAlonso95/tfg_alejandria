<?php

/** @var string $authors */
/** @var string $genres */

?>
<main class="full-page p-4">
	<div class="container  container-admin">
		<div class="row">
			<div class="col-2 offset-10">
				<div class="text-center">
					<button type="button" class="btn btn-standar-admin w-100 mt-2" data-bs-toggle="modal" data-bs-target="#modalBook" id="buttonCreate">
						Crear
					</button>
				</div>
			</div>
		</div>
		<div class="table-responsive">
			<table id="myTable" class="table table-striped table-bordered table-admin">
				<thead>
					<tr>
						<th class="table-header text-center">Id</th>
						<th class="table-header text-center">Portada</th>
						<th class="table-header text-center">Título</th>
						<th class="table-header text-center">Sinopsis</th>
						<th class="table-header text-center">Autor</th>
						<th class="table-header text-center">Género</th>
						<th class="table-header text-center">Editar</th>
						<th class="table-header text-center">Eliminar</th>
					</tr>
				</thead>

			</table>

		</div>

	</div>
</main>

<!-- Modal -->

<div class="modal fade" id="modalBook" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="exampleModalLabel"></h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="form">

					<label for="cover">Archivo de portada:</label>
					<input type="file" name="cover" id="cover" accept="image/*" class="form-control">
					<span id="uploadImage"></span>
					<br>
					<label for="title">Título</label>
					<input required type="text" name="title" id="title" class="form-control">
					<br>
					<label for="synopsis">Sinopsis
						<textarea name="synopsis" id="synopsis" class="form-control"></textarea>
						<br>
						<div class="ui-widget">
							<label for="authors">Autores: </label>
							<input required id="authors" size="50">
						</div>

						<div class="ui-widget">
							<label for="genres">Genres: </label>
							<input required id="genres" size="50">
						</div>
						<br>
						<div class="modal-footer">
							<input type="hidden" name="idBook" id="idBook">
							<input type="hidden" name="operation" id="operation" value="create">
							<input type="submit" name="action" id="action" class="btn btn-standar" value="Crear">
						</div>

				</form>
			</div>

		</div>
	</div>
</div>

<?php require_once 'views/components/spinner.php'; ?>

<script>
	const availableAuthors = <?= $authors ?>;
	const availableGenres = <?= $genres ?>;
	$(document).ready(function() {

		$('#myTable').DataTable({
			language: {
				url: "https://cdn.datatables.net/plug-ins/2.2.2/i18n/es-ES.json"
			},
			ajax: "<?= BASE_URL ?>api/books",
			columns: [{
					data: 'id'
				},
				{
					data: 'cover',
					render: function(data) {
						return '<img src="' + data + '" alt="Portada" width="50">';
					}
				},
				{
					data: 'title'
				},
				{
					data: 'synopsis'
				},
				{
					data: 'author'
				},
				{
					data: 'genre'
				},
				{
					data: null,
					render: function() {
						return '<button class="btn btn-standar btn-edit" role="button">Editar</button>';
					}
				},
				{
					data: null,
					render: function() {
						return '<button class="btn btn-delete btn-delete-style" role="button">Eliminar</button>';
					}
				}
			]
		});

		// Evento para Editar libro
		$('#myTable').on('click', '.btn-edit', function(e) {
			e.preventDefault();
			const table = $('#myTable').DataTable();
			const rowData = table.row($(this).closest('tr')).data();
			$('#exampleModalLabel').text('Editar Libro');
			$('#idBook').val(rowData.id);
			$('#title').val(rowData.title);
			$('#synopsis').val(rowData.synopsis);
			$('#authors').val(rowData.author);
			$('#genres').val(rowData.genre);
			$('#uploadImage').html('<img src="' + rowData.cover + '" width="100"/>');
			$('#cover').prop('required', false);
			$('#action').val('Actualizar');
			$('#operation').val('edit');

			const modal = new bootstrap.Modal(document.getElementById('modalBook'));
			modal.show();
		});

		// Evento para Eliminar libro
		$('#myTable').on('click', '.btn-delete', function(e) {
			e.preventDefault();
			const table = $('#myTable').DataTable();
			const rowData = table.row($(this).closest('tr')).data();

			if (confirm("¿Estás seguro de que deseas eliminar este libro?")) {
				$('#spinner').removeClass('d-none');
				$('body').css('overflow', 'hidden');
				$.ajax({
					url: "<?= BASE_URL ?>api/deleteBook",
					type: 'POST',
					data: {
						idBook: rowData.id
					},
					success: function() {
						table.ajax.reload();
						showToast('¡Libro eliminado correctamente!');
					},
					error: function(response) {
						let msg = 'Error al eliminar el libro. ';
						if (response.responseJSON && response.responseJSON.error) {
							msg += response.responseJSON.error;
						}
						showToast(msg, false);
					},
					complete: function() {
						$('body').css('overflow', 'auto');
						$('#spinner').addClass('d-none');
					}
				});
			}
		});

		$('#form').on('keydown', function(e) {
			if (e.key === 'Enter' && e.target.tagName !== 'TEXTAREA') {
				e.preventDefault();
				return false;
			}
		});
		// Enviar formulario por AJAX
		$('#form').on('submit', function(e) {
			e.preventDefault();
			const isEdit = $('#operation').val() === 'edit';
			const url = isEdit ? "<?= BASE_URL ?>api/editBook" : "<?= BASE_URL ?>api/saveBook";
			const formData = new FormData();
			formData.append('idBook', $('#idBook').val());
			formData.append('title', $('#title').val());
			formData.append('synopsis', $('#synopsis').val());
			formData.append('authors', $('#authors').val());
			formData.append('genres', $('#genres').val());
			formData.append('cover', $('#cover')[0].files[0]);
			$('#spinner').removeClass('d-none');
			$('body').css('overflow', 'hidden');
			// TODO añadir un spinner mientras se envia el formulario
			$.ajax({
				url: url,
				type: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				success: function() {
					$('#modalBook').modal('hide');
					$('#myTable').DataTable().ajax.reload();
					showToast('¡Libro guardado correctamente!');
				},
				error: function(response) {
					let msg = 'Error al guardar el libro. ';
					if (response.responseJSON && response.responseJSON.error) {
						msg += response.responseJSON.error;
					}
					showToast(msg, false);
				},
				complete: function() {
					$('body').css('overflow', 'auto');
					$('#spinner').addClass('d-none');
				}
			});

		});

		$('#modalBook').on('hidden.bs.modal', function() {
			$('#form')[0].reset();
			$('#uploadImage').html('');
			$('#action').val('Crear');
			$('#operation').val('create');
			$('#cover').prop('required', true);

		});

		$('#buttonCreate').on('click', function() {
			$('#exampleModalLabel').text('Crear Libro');

		});

		setupAutocomplete("#authors", availableAuthors);
		setupAutocomplete("#genres", availableGenres);
	});

	function split(val) {
		return val.split(/,\s*/);
	}

	function extractLast(term) {
		return split(term).pop();
	}

	// Función para configurar el autocompletado
	function setupAutocomplete(inputSelector, availableItems) {
		$(inputSelector)
			.on("keydown", function(event) {
				if (event.keyCode === $.ui.keyCode.TAB &&
					$(this).autocomplete("instance").menu.active) {
					event.preventDefault();
				}
			})
			.autocomplete({
				minLength: 0,
				source: function(request, response) {
					response($.ui.autocomplete.filter(
						availableItems, extractLast(request.term)));
				},
				focus: function() {
					return false;
				},
				select: function(event, ui) {
					var terms = split(this.value);
					terms.pop();
					terms.push(ui.item.value);
					terms.push("");
					this.value = terms.join(", ");
					return false;
				},
				classes: {
					"ui-autocomplete": "autocomplete-input"
				}
			})

	}
</script>