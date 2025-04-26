<?php

/** @var User[] $users */

?>
<div class="container">
    <div class="row">
        <div class="col-2 offset-10">
            <div class="text-center">
                <!-- TODO: solo visible si estamos en el panel de administración de libros -->
                <!-- Boton -->
                <button type="button" class="btn btn-earth w-100" data-bs-toggle="modal" data-bs-target="#modalUSer" id="buttonCreate">
                    Crear</button>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table id="myTable" class="table table-striped table-bordered table-admin">
            <thead>
                <tr>
                    <th class="table-header">Id</th>
                    <!-- <th>Nombre</th> -->
                    <th class="table-header">Correo</th>
                    <!-- <th>Biografía</th> -->
                    <th class="table-header">Imagen</th>
                    <th class="table-header">Rol</th>
                    <th class="table-header">Editar</th>
                    <th class="table-header">Eliminar</th>
                </tr>
            </thead>

        </table>

    </div>

</div>

<!-- Modal -->

<div class="modal fade" id="modalUSer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Editar rol del usuario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form">


                    <!-- <label for="name">Introduce el nombre</label>
                    <input type="text" name="name" id="name" class="form-control">
                    <br> -->
                    <!--<label for="email">Introduce el correo</label>
                    <input type="email" name="email" id="email" class="form-control" readonly>
                    <br>
                    <label for="biography">Introduce la biografía</label>
                    <textarea name="biography" id="biography" class="form-control" readonly></textarea>
                    <br>
                     <label for="image">Selecciona una imagen</label>
                    <input type="file" name="image" id="image" class="form-control">
                    <span id="uploadImage"></span> 
                    <br> -->
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
        // Inicializar DataTable
        $('#myTable').DataTable({
            language: {
                url: "https://cdn.datatables.net/plug-ins/2.2.2/i18n/es-ES.json"
            },
            ajax: "<?= base_url ?>api/users",
            columns: [{
                    data: 'id'
                },
                // {
                //     data: 'name'
                // },
                {
                    data: 'email'
                },
                // {
                //     data: 'biography'
                // },
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
                        return '<button class="btn btn-warning btn-edit" role="button">Editar</button>';
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return '<button class="btn btn-outline-danger" role="button">Eliminar</button>';
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
            // $('#name').val(rowData.name);
            // $('#email').val(rowData.email);
            // $('#biography').val(rowData.biography);
            $('#role').val(rowData.role_id);

            // Cambiar el texto del botón
            $('#action').val('Actualizar');
            $('#operation').val('edit');

            // Mostrar la imagen actual (opcional)
            $('#uploadImage').html('<img src="' + rowData.profile_img + '" width="100"/>');

            // Mostrar la modal
            const modal = new bootstrap.Modal(document.getElementById('modalUSer'));
            modal.show();
        });

        // Enviar formulario por AJAX
        $('#form').on('submit', function(e) {
            e.preventDefault();

            // Recolectar datos
            // const formData = new FormData(this); // Para incluir la imagen si se selecciona
            // const idUser = $('#idUser').val();
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
                "<?= base_url ?>api/editUser" :
                "<?= base_url ?>api/save";

                console.log(isEdit ? "<?= base_url ?>api/editUser" : "<?= base_url ?>api/save");



            $.ajax({
                url: url,
                type: 'POST',
                data: formData, // ❗ NO FormData, simple objeto
                success: function(response) {
                    document.activeElement.blur();
                    $('#modalUSer').modal('hide');
                    $('#form')[0].reset();
                    $('#uploadImage').html('');
                    $('#myTable').DataTable().ajax.reload();
                    showToast('¡Usuario actualizado correctamente!');
                },
                error: function(xhr, status, error) {
                    console.error('Error al guardar:', error);
                    showToast('Ocurrió un error al guardar. Intenta de nuevo.', false);
                }
            });

            // $.ajax({
            //     url: url,
            //     type: 'POST',
            //     data: formData,
            //     processData: false,
            //     contentType: false,
            //     success: function(response) {
            //         document.activeElement.blur(); // Warning de accesibilidad

            //         // Cerrar el modal
            //         $('#modalUSer').modal('hide');

            //         $('#form')[0].reset();
            //         $('#uploadImage').html('');
            //         $('#myTable').DataTable().ajax.reload();
            //         // Mostrar toast
            //         showToast('¡Usuario actualizado correctamente!');
            //     },
            //     error: function(xhr, status, error) {
            //         console.error('Error al guardar:', error);
            //         showToast('Ocurrió un error al guardar. Intenta de nuevo.', false);
            //     }
            // });
        });

        // Mostrar toast
        function showToast(message, isSuccess = true) {
            const toastEl = $('#toastNotification');
            const toastBody = $('#toastBody');

            toastBody.html(message);

            toastEl.removeClass('bg-success', 'bg-danger');
            toastEl.addClass(isSuccess ? 'bg-success' : 'bg-danger');

            const toast = new bootstrap.Toast(toastEl);
            toast.show();
        }

    });
</script>