<main class="full-page p-4">
	<div class="container  container-admin">
		<div class="row">
			<div class="col-2 offset-10">
				<div class="text-center">
					<button type="button" class="btn btn-standar-admin w-100 mt-2" data-bs-toggle="modal" data-bs-target="#modalAuthor" id="buttonCreate">
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
						<th class="table-header text-center">Nombre</th>
						<th class="table-header text-center">Biografía</th>
						<th class="table-header text-center">Imagen perfil</th>
						<th class="table-header text-center">Editar</th>
						<th class="table-header text-center">Eliminar</th>
					</tr>
				</thead>

			</table>

		</div>

	</div>
</main>

<!-- Modal -->

<div class="modal fade" id="modalAuthor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="exampleModalLabel"></h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="form">

					<label for="authorName">Nombre</label>
					<input required type="text" name="authorName" id="authorName" class="form-control">
					<br>
					<label for="biography">Biografía: </label>
					<textarea name="biography" id="biography" class="form-control"></textarea>
					<br>
					<label for="profileImage">Imagen perfil:</label>
					<input type="file" name="profileImage" id="profileImage" accept="image/*" class="form-control">
					<span id="uploadImage"></span>
					<br>
					<div class="modal-footer">
						<input type="hidden" name="idAuthor" id="idAuthor">
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
	$(document).ready(function() {

		$('#myTable').DataTable({
			language: {
				url: "https://cdn.datatables.net/plug-ins/2.2.2/i18n/es-ES.json"
			},
			ajax: "<?= BASE_URL ?>api/authors",
			columns: [{
					data: 'id'
				},
				{
					data: 'authorName'
				},
				{
					data: 'biography'
				},
				{
					data: 'profileImage',
					render: function(data) {
						return '<img src="' + data + '" alt="Imagen perfil del autor" width="50">';
					}
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
				},
			]


		});

		// Evento para Editar libro
		$('#myTable').on('click', '.btn-edit', function(e) {
			e.preventDefault();
			const table = $('#myTable').DataTable();
			const rowData = table.row($(this).closest('tr')).data();
			$('#exampleModalLabel').text('Editar Autor');
			$('#idAuthor').val(rowData.id);
			$('#authorName').val(rowData.authorName);
			$('#biography').val(rowData.biography);
			$('#uploadImage').html('<img src="' + rowData.profileImage + '" width="100"/>');

			$('#action').val('Actualizar');
			$('#operation').val('edit');

			const modal = new bootstrap.Modal(document.getElementById('modalAuthor'));
			modal.show();
		});

		// Evento para Eliminar autor
		$('#myTable').on('click', '.btn-delete', function(e) {
			e.preventDefault();
			const table = $('#myTable').DataTable();
			const rowData = table.row($(this).closest('tr')).data();

			if (confirm("¿Estás seguro de que deseas eliminar este autor?")) {
				$('#spinner').removeClass('d-none');
				$('body').css('overflow', 'hidden');
				$.ajax({
					url: "<?= BASE_URL ?>api/deleteAuthor",
					type: 'POST',
					data: {
						idAuthor: rowData.id
					},
					success: function() {
						table.ajax.reload();
						$('body').css('overflow', 'hidden');
						$('#spinner').addClass('d-none');
						showToast('¡Autor eliminado correctamente!');
					},
					error: function(response) {
						let msg = 'Error al eliminar el autor. ';
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
			const url = isEdit ? "<?= BASE_URL ?>api/editAuthor" : "<?= BASE_URL ?>api/saveAuthor";
			const formData = new FormData();
			formData.append('idAuthor', $('#idAuthor').val());
			formData.append('authorName', $('#authorName').val());
			formData.append('biography', $('#biography').val());
			formData.append('profileImage', $('#profileImage')[0].files[0]);
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
					$('#modalAuthor').modal('hide');
					$('#myTable').DataTable().ajax.reload();
					showToast('¡Autor guardado correctamente!');
				},
				error: function(response) {
					let msg = 'Error al guardar el autor. ';
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

		$('#modalAuthor').on('hidden.bs.modal', function() {
			$('#form')[0].reset();
			$('#uploadImage').html('');
			$('#action').val('Crear');
			$('#operation').val('create');
		});

		$('#buttonCreate').on('click', function() {
			$('#exampleModalLabel').text('Crear Autor');

		});

	});
</script>