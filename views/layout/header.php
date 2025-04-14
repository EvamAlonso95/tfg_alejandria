<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url ?>/assets/css/styles.css">
    <title>Alejandría</title>
</head>

<body>
    <!-- Cabecera -->
    <header id="header" style="border: 1px solid blue;">
        <div id="logo">
            <img src="<?= base_url ?>/assets/img/logo_prueba.png" alt="logo de Alejandría">
            <a href="index.php">Alejandría</a>
        </div>
        <div id="perfil_container">
            <div id="user_logo">
                <img src="<?= base_url ?>/assets/img/icono-user.webp" alt="" srcset="">
            </div>
            <div id="desplegable_menu">
                <!-- Menu -->
                <nav id="menu">
                    <ul>
                        <li>
                            <a href="#">Mi perfil</a>
                        </li>
                        <li>
                            <a href="#">Publicaciones</a>
                        </li>
                        <li>
                            <a href="#">Configuración</a>
                        </li>
                        <li>
                            <a href="<?=base_url?>user/logout">Cerrar sesión</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <!-- Contenido central -->
    <div id="content" style="border: 1px solid green;">
        <!-- Barra lateral -->
        <div id="central" style="border: 1px solid pink;">