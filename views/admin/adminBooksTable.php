<?php

/** @var Book[] $book */
/** @var string $authors */
/** @var string $genres */

?>
<div class="container">
    <div class="row">
        <div class="col-2 offset-10">
            <div class="text-center">

                <!-- Boton -->
                <?php if (isset($vista) && $vista === 'libros'): ?>
                    <button type="button" class="btn btn-earth w-100" data-bs-toggle="modal" data-bs-target="#modalBook" id="buttonCreate">
                        Crear
                    </button>
                <?php endif; ?>

            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table id="myTable" class="table table-striped table-bordered table-admin">
            <thead>
                <tr>
                    <th class="table-header">Id</th>
                    <th class="table-header">Portada</th>
                    <th class="table-header">Título</th>
                    <th class="table-header">Sinopsis</th>
                    <th class="table-header">Autor</th>
                    <th class="table-header">Género</th>
                    <th class="table-header">Editar</th>
                    <th class="table-header">Eliminar</th>
                </tr>
            </thead>

        </table>

    </div>

</div>

<!-- Modal -->

<div class="modal fade" id="modalBook" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Editar libro</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form">

                    <label for="cover">Archivo de portada:</label>
                    <input required type="file" name="cover" id="cover" class="form-control">
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
                            <input type="hidden" name="idUser" id="idUser">
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
    const availableAuthors = <?= $authors ?>;
    const availableGenres = <?= $genres ?>;
    $(document).ready(function() {
        // Inicializar DataTable solo si estamos en la vista de libros
        const vistaActual = "<?= $vista ?? 'usuarios' ?>";

        if (vistaActual === 'libros') {
            $('#myTable').DataTable({
                language: {
                    url: "https://cdn.datatables.net/plug-ins/2.2.2/i18n/es-ES.json"
                },
                ajax: "<?= base_url ?>api/books",
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
                            return '<button class="btn btn-warning btn-edit" role="button">Editar</button>';
                        }
                    },
                    {
                        data: null,
                        render: function() {
                            return '<button class="btn btn-outline-danger btn-delete" role="button">Eliminar</button>';
                        }
                    }
                ]
            });

            // Evento para Editar libro
            $('#myTable').on('click', '.btn-edit', function(e) {
                e.preventDefault();
                const table = $('#myTable').DataTable();
                const rowData = table.row($(this).closest('tr')).data();

                $('#idUser').val(rowData.id);
                $('#title').val(rowData.title);
                $('#synopsis').val(rowData.synopsis);
                $('#author').val(rowData.author);
                $('#genre').val(rowData.genre);
                $('#uploadImage').html('<img src="' + rowData.cover + '" width="100"/>');

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
                    $.ajax({
                        url: "<?= base_url ?>api/deleteBook",
                        type: 'POST',
                        data: {
                            id: rowData.id
                        },
                        success: function() {
                            table.ajax.reload();
                            showToast('¡Libro eliminado correctamente!');
                        },
                        error: function() {
                            showToast('Error al eliminar el libro.', false);
                        }
                    });
                }
            });

            // Enviar formulario por AJAX
            $('#form').on('submit', function(e) {
                e.preventDefault();
                // TODO: evitar que al hacer ENTER se envíe el formulario
                const isEdit = $('#operation').val() === 'edit';
                const url = isEdit ? "<?= base_url ?>api/editBook" : "<?= base_url ?>api/saveBook";
                const formData = new FormData();
                formData.append('id', $('#idUser').val());
                formData.append('title', $('#title').val());
                formData.append('synopsis', $('#synopsis').val());
                formData.append('authors', $('#authors').val());
                formData.append('genres', $('#genres').val());
                formData.append('cover', $('#cover')[0].files[0]);

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
                    error: function() {
                        showToast('Error al guardar el libro.', false);
                    }
                });

            });

            $('#modalBook').on('hidden.bs.modal', function() {
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
        }

        setupAutocomplete("#authors", availableAuthors);
        setupAutocomplete("#genres", availableGenres);
    });

    function split(val) {
        return val.split(/,\s*/);
    }

    function extractLast(term) {
        return split(term).pop();
    }

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
                }
            });
    }
</script>