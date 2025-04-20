<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS Bootstrap y estilos -->
    <link rel="stylesheet" href="<?= base_url ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url ?>assets/css/styles.css">

    <!-- CSS DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>

    <!-- JS DataTables -->
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>

    <title><?= $this->title ?? 'Alejandria' ?></title>

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                language: {
                    url: "https://cdn.datatables.net/plug-ins/2.2.2/i18n/es-ES.json"
                }
            });
        });
    </script>



<body>
    <?php require_once 'header.php'; ?>