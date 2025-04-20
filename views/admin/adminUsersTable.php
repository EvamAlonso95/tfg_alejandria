<?php

/** @var User[] $users */

?>
<div class="container">
    <table id="myTable" class="table table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Biografía</th>
                <th>Imagen</th>
                <th>Rol</th>
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
                </tr>
    
            <?php }
            ?>
    
    
        </tbody>
    </table>

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