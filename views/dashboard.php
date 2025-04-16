<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?= base_url ?>/assets/css/styles.css">
  <title>Tu Perfil</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>

  </style>
</head>

<body>

  <?php

  require_once 'views/layout/header.php';

  require_once 'views/layout/main.php';
  require_once 'views/layout/sidebar.php';

  var_dump($_SESSION['identity']);
  var_dump($_SESSION['role']);



  require_once 'views/layout/footer.php';
