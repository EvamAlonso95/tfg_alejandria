<main class="full-page p-4">


	<div class="container container-admin">
		<div class="table-responsive">
			<table id="myTable" class="table table-striped table-bordered table-admin">
				<thead>
					<tr>
						<th class="table-header text-center">Id</th>
						<th class="table-header text-center">Correo</th>
						<th class="table-header text-center">Imagen</th>
						<th class="table-header text-center">Rol</th>
						<th class="table-header text-center">Editar</th>
						<th class="table-header text-center btn-delete">Eliminar</th>
					</tr>
				</thead>

			</table>

		</div>

	</div>
</main>
<!-- Modal -->

<div class="modal fade" id="modalUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="exampleModalLabel">Editar rol del usuario</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="form">
					<label for="role">Selecciona el rol</label>
					<select name="role" id="role" class="form-select">
						<option value="1">Author</option>
						<option value="2">Reader</option>
						<option value="3">Admin</option>
					</select>
					<br>
					<div class="modal-footer">
						<input type="hidden" name="idUser" id="idUser">
						<input type="hidden" name="operation" id="operation">
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
		// Inicializar DataTable
		$('#myTable').DataTable({
			language: {
				url: "https://cdn.datatables.net/plug-ins/2.2.2/i18n/es-ES.json"
			},
			ajax: "<?= BASE_URL ?>api/users",
			columns: [{
					data: 'id'
				},
				{
					data: 'email'
				},
				{
					data: 'profile_img',
					render: function(data, type, row) {
						return '<img src="' + data + '" alt="Imagen de perfil" width="50">';
					}
				},
				{
					data: 'role'
				},
				{
					data: null,
					render: function(data, type, row) {
						return '<button class="btn  btn-standar btn-edit" role="button">Editar</button>';
					}
				},
				{
					data: null,
					render: function(data, type, row) {
						return '<button class="btn  btn-delete btn-delete-style" role="button">Eliminar</button>';
					}
				},
				{
					data: 'role_id',
					visible: false
				}
			]

		});

		// Evento para botón Editar
		$('#myTable').on('click', '.btn-edit', function(e) {
			e.preventDefault();

			// Obtener la fila correspondiente
			const table = $('#myTable').DataTable();
			// Obtener los datos de la fila
			const rowData = table.row($(this).closest('tr')).data();


			// Rellenar los campos del modal
			$('#idUser').val(rowData.id);
			$('#role').val(rowData.role_id);

			// Cambiar el texto del botón
			$('#action').val('Actualizar');
			$('#operation').val('edit');

			// Mostrar la imagen actual (opcional)
			$('#uploadImage').html('<img src="' + rowData.profile_img + '" width="100"/>');

			// Mostrar la modal
			const modal = new bootstrap.Modal(document.getElementById('modalUser'));
			modal.show();
		});

		//Evento para botón Eliminar
		$('#myTable').on('click', '.btn-delete', function(e) {
			e.preventDefault();

			// Obtener la fila correspondiente
			const table = $('#myTable').DataTable();
			// Obtener los datos de la fila
			const rowData = table.row($(this).closest('tr')).data();

			// Confirmar eliminación
			if (confirm("¿Estás seguro de que deseas eliminar este usuario?")) {
				$('#spinner').removeClass('d-none');
				$('body').css('overflow', 'hidden');
				$.ajax({
					url: "<?= BASE_URL ?>api/deleteUser",
					type: 'POST',
					data: {
						idUser: rowData.id
					},
					success: function(response) {
						$('#myTable').DataTable().ajax.reload();
						showToast('¡Usuario eliminado correctamente!');
					},
					error: function(xhr, status, error) {
						console.error('Error al eliminar:', error);
						showToast('Ocurrió un error al eliminar. Intenta de nuevo.', false);
					}
				});
			}
		});

		// Enviar formulario por AJAX
		$('#form').on('submit', function(e) {
			e.preventDefault();
			const formData = {
				idUser: $('#idUser').val(),
				// name: $('#name').val(),
				role: $('#role').val()
			};
			console.log('Enviando datos:', formData);
			// Detectar operación
			const isEdit = $('#operation').val() === 'edit';
			// Modificar el valor de la acción según la operación
			const url = isEdit ?
				"<?= BASE_URL ?>api/editUser" :
				"<?= BASE_URL ?>api/saveBook";

			$('#spinner').removeClass('d-none');
			$('body').css('overflow', 'hidden');
			$.ajax({
				url: url,
				type: 'POST',
				data: formData,
				success: function(response) {
					document.activeElement.blur();
					$('#modalUser').modal('hide');
					$('#form')[0].reset();
					$('#uploadImage').html('');
					$('#myTable').DataTable().ajax.reload();
					showToast('¡Usuario actualizado correctamente!');
				},
				error: function(xhr, status, error) {
					console.error('Error al guardar:', error);
					showToast('Ocurrió un error al guardar. Intenta de nuevo.', false);
				},
				complete: function() {
					$('body').css('overflow', 'auto');
					$('#spinner').addClass('d-none');
				}
			});
		});
	});
</script>