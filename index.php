<?php
// Controlador frontal
// Recoger parámetros GET
// Llevará a los controllers (función autoload que al coger los parámetros GET carge un controlador concreto- investigar)
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/styles.css">
    <title>Alejandría</title>
</head>

<body>
    <!-- Cabecera -->
    <header id="header" style="border: 1px solid blue;">
        <div id="logo">
            <img src="./assets/img/logo_prueba.png" alt="logo de Alejandría">
            <a href="index.php">Alejandría</a>
        </div>
        <div id="perfil_container">
            <div id="user_logo">
                <img src="./assets/img/icono-user.webp" alt="" srcset="">
            </div>
            <div id="desplegable_menu">
                <!-- Menu -->
                <nav id="menu">
                    <ul>
                        <li>
                            <a href="#">Mi perfil</a>
                        </li>
                        <li>
                            <a href="#">Publciaciones</a>
                        </li>
                        <li>
                            <a href="#">Configuración</a>
                        </li>
                        <li>
                            <a href="#">Cerrar sesión</a>
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
            <p>Contenido pincipal</p>
        </div>
        <aside id="lateral" style="border: 1px solid yellow;">
            <!-- Búsqueda -->
            <div id="search">
                <form action="">
                    <input type="text" name="" id="" placeholder="El camino de los ...">
                    <input type="submit" value="Buscar">
                </form>
            </div>
            <!-- Recomendaciones -->
            <div id="recomendation">
                <p>Aquí las recomendaciones</p>
            </div>
            <!-- Lectura actual -->
            <div id="current_book">
                <p>Aquí el libro que estás leyendo</p>

            </div>
        </aside>
    </div>
    <!-- Pie de página -->
    <footer id="footer" style="border: 1px solid grey;">
        <p>Desarrollado por Eva Alonso &copy; <?= date('Y') ?></p>
    </footer>
</body>

</html>