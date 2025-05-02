<div class="container">
    <div class="row">
        <div class="col-2 offset-10">
            <div class="text-center">
                <button type="button" class="btn btn-earth w-100" data-bs-toggle="modal" data-bs-target="#modalAuthor" id="buttonCreate">
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
                    <th class="table-header">Biografía</th>
                    <th class="table-header">Imagen perfil</th>
                    <th class="table-header">Nombre de usuario</th>
                    <th class="table-header">Editar</th>
                    <th class="table-header">Eliminar</th>
                </tr>
            </thead>

        </table>

    </div>

</div>

<!-- Modal -->

<div class="modal fade" id="modalAuthor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Editar autor</h1>
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
                    <input required type="file" name="profileImage" id="profileImage" class="form-control">
                    <span id="uploadImage"></span>
                    <br>
                  
                    <label for="userName">Nombre Usuario</label>
                    <input  type="text" name="userName" id="userName" class="form-control">
                    <br>

                    <div class="modal-footer">
                        <input type="hidden" name="idAuthor" id="idAuthor">
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
            ajax: "<?= base_url ?>api/authors",
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
                    data: 'userName',
                    render: function(data, type, row) {
                        return data ? data : 'Autor sin nombre de usuario';
                    }
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

            $('#idAuthor').val(rowData.id);
            $('#authorName').val(rowData.authorName);
            $('#biography').val(rowData.biography);
            $('#uploadImage').html('<img src="' + rowData.profileImage + '" width="100"/>');

            $('#action').val('Actualizar');
            $('#operation').val('edit');

            const modal = new bootstrap.Modal(document.getElementById('modalAuthor'));
            modal.show();
        });

        // Evento para Eliminar libro
        $('#myTable').on('click', '.btn-delete', function(e) {
            e.preventDefault();
            const table = $('#myTable').DataTable();
            const rowData = table.row($(this).closest('tr')).data();

            if (confirm("¿Estás seguro de que deseas eliminar este autor?")) {
                $.ajax({
                    url: "<?= base_url ?>api/deleteAuthor",
                    type: 'POST',
                    data: {
                        idAuthor: rowData.id
                    },
                    success: function() {
                        table.ajax.reload();
                        showToast('¡Autor eliminado correctamente!');
                    },
                    error: function() {
                        showToast('Error al eliminar el autor.', false);
                    }
                });
            }
        });

        // Enviar formulario por AJAX
        $('#form').on('submit', function(e) {
            e.preventDefault();
            // TODO: evitar que al hacer ENTER se envíe el formulario
            const isEdit = $('#operation').val() === 'edit';
            const url = isEdit ? "<?= base_url ?>api/editAuthor" : "<?= base_url ?>api/saveAuthor";
            const formData = new FormData();
            formData.append('idAuthor', $('#idAuthor').val());
            formData.append('authorName', $('#authorName').val());
            formData.append('biography', $('#biography').val());
            formData.append('profileImage', $('#profileImage')[0].files[0]);

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
                error: function() {
                    showToast('Error al guardar el autor.', false);
                }
            });

        });

        $('#modalAuthor').on('hidden.bs.modal', function() {
            $('#form')[0].reset();
            $('#uploadImage').html('');
            $('#action').val('Crear');
            $('#operation').val('create');
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