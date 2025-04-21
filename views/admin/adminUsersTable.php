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
        <table id="myTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Biografía</th>
                    <th>Imagen</th>
                    <th>Rol</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($users as $user) { ?>
                    <tr>
                        <td><?php echo $user->getId(); ?></td>
                        <td><?php echo $user->getName(); ?></td>
                        <td><?php echo $user->getEmail(); ?></td>
                        <td><?php echo $user->getBiography(); ?></td>
                        <td><img src="<?php echo base_url  . $user->getProfileImage(); ?>" alt="Imagen de perfil" width="50"></td>
                        <td><?php echo $user->getRole()->getName(); ?></td>
                        <td><a href="#" class="btn btn-warning" role="button">Editar</a></td>
                        <td><a href="#" class="btn btn-outline-danger" role="button">Eliminar</a></td>
                    </tr>

                <?php }
                ?>


            </tbody>
        </table>

    </div>

</div>

<!-- Modal -->

<div class="modal fade" id="modalUSer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Nuevo registro</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url ?>user/save" method="post" id="form" enctype="multipart/form-data">

                    <label for="name">Introduce el nombre</label>
                    <input type="text name=" name" id="name" class="form-control">
                    <br>
                    <label for="email">Introduce el correo</label>
                    <input type="email" name="email" id="email" class="form-control">
                    <br>
                    <label for="biography">Introduce la biografía</label>
                    <textarea name="biography" id="biography" class="form-control"></textarea>
                    <br>
                    <label for="image">Selecciona una imagen</label>
                    <input type="file" name="image" id="image" class="form-control">
                    <span id="uploadImage"></span>
                    <br>
                    <label for="role">Selecciona un rol</label>
                    <select name="role" id="role" class="form-select">
                        <option value="1">Autor</option>
                        <option value="2">Lector</option>
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
<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            language: {
                url: "https://cdn.datatables.net/plug-ins/2.2.2/i18n/es-ES.json"
            },

        });
    });
</script>