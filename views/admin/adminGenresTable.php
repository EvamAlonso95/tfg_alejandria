<div class="container">
	<div class="row">
		<div class="col-2 offset-10">
			<div class="text-center">
				<button type="button" class="btn btn-earth w-100" data-bs-toggle="modal" data-bs-target="#modalGenre" id="buttonCreate">
					Crear
				</button>
			</div>
		</div>
	</div>
	<div class="table-responsive">
		<table id="myTable" class="table table-striped table-bordered table-admin">
			<thead>
				<tr>
					<th class="table-header">Id</th>
					<th class="table-header">Nombre</th>
					<th class="table-header">Editar</th>
					<th class="table-header">Eliminar</th>
				</tr>
			</thead>

		</table>

	</div>

</div>

<!-- Modal -->

<div class="modal fade" id="modalGenre" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="exampleModalLabel"></h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="form">

					<label for="genreName">Nombre</label>
					<input required type="text" name="genreName" id="genreName" class="form-control">
					<br>

					<div class="modal-footer">
						<input type="hidden" name="idGenre" id="idGenre">
						<input type="hidden" name="operation" id="operation" value="create">
						<input type="submit" name="action" id="action" class="btn btn-earth" value="Crear">
					</div>

				</form>
			</div>

		</div>
	</div>
</div>
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1100">
	<div id="toastNotification" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
		<div class="d-flex">
			<div class="toast-body" id="toastBody">
			</div>
			<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Cerrar"></button>
		</div>
	</div>
</div>


<script>
	$(document).ready(function() {

		$('#myTable').DataTable({
			language: {
				url: "https://cdn.datatables.net/plug-ins/2.2.2/i18n/es-ES.json"
			},
			ajax: "<?= BASE_URL ?>api/genres",
			columns: [{
					data: 'id'
				},
				{
					data: 'genreName'
				},
				{
					data: null,
					render: function() {
						return '<button class="btn btn-warning btn-edit" role="button">Editar</button>';
					}
				},
				{
					data: null,
					render: function() {
						return '<button class="btn btn-outline-danger btn-delete" role="button">Eliminar</button>';
					}
				},
			]


		});

		// Evento para Editar libro
		$('#myTable').on('click', '.btn-edit', function(e) {
			e.preventDefault();
			const table = $('#myTable').DataTable();
			const rowData = table.row($(this).closest('tr')).data();
			$('#exampleModalLabel').text('Editar Género');
			$('#idGenre').val(rowData.id);
			$('#genreName').val(rowData.genreName);
			$('#action').val('Actualizar');
			$('#operation').val('edit');

			const modal = new bootstrap.Modal(document.getElementById('modalGenre'));
			modal.show();
		});

		// Evento para Eliminar libro
		$('#myTable').on('click', '.btn-delete', function(e) {
			e.preventDefault();
			const table = $('#myTable').DataTable();
			const rowData = table.row($(this).closest('tr')).data();

			if (confirm("¿Estás seguro de que deseas eliminar este género?")) {
				$.ajax({
					url: "<?= BASE_URL ?>api/deleteGenre",
					type: 'POST',
					data: {
						idGenre: rowData.id
					},
					success: function() {
						table.ajax.reload();
						showToast('¡Género eliminado correctamente!');
					},
					error: function(response) {
						let msg = 'Error al eliminar el género. ';
						if (response.responseJSON && response.responseJSON.error) {
							msg += response.responseJSON.error;
						}
						showToast(msg, false);
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
			const url = isEdit ? "<?= BASE_URL ?>api/editGenre" : "<?= BASE_URL ?>api/saveGenre";
			const formData = new FormData();
			formData.append('idGenre', $('#idGenre').val());
			formData.append('genreName', $('#genreName').val());

			// TODO añadir un spinner mientras se envia el formulario
			$.ajax({
				url: url,
				type: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				success: function(response) {
					$('#modalBook').modal('hide');
					$('#myTable').DataTable().ajax.reload();
					showToast('¡Género guardado correctamente!');
				},
				error: function(response) {
					let msg = 'Error al guardar el género. ';
					if (response.responseJSON && response.responseJSON.error) {
						msg += response.responseJSON.error;
					}
					showToast(msg, false);
				}
			});

		});

		$('#modalGenre').on('hidden.bs.modal', function() {
			$('#form')[0].reset();
			$('#uploadImage').html('');
			$('#action').val('Crear');
			$('#operation').val('create');
		});

		$('#buttonCreate').on('click', function() {
			$('#exampleModalLabel').text('Crear Género');

		});



		// Toast reusable
		function showToast(message, isSuccess = true) {
			const toastEl = $('#toastNotification');
			const toastBody = $('#toastBody');

			toastBody.html(message);
			toastEl.removeClass('bg-success bg-danger').addClass(isSuccess ? 'bg-success' : 'bg-danger');
			new bootstrap.Toast(toastEl).show();
		}



	});
</script>