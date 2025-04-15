<?php Utils::requireLogin(); ?>
<!-- Cabecera -->
<header id="header" style="border: 1px solid blue;">
    <div id="logo">
        <img src="<?= base_url ?>/assets/img/logo_prueba.png" alt="logo de Alejandría">
        <a href="<?= base_url ?>dashboard">Alejandría</a>
    </div>
    <div id="perfil_container">
        <div id="user_logo">
            <img src="<?= isset($_SESSION['identity']->profile_img) && file_exists($_SESSION['identity']->profile_img)
                            ? base_url . '/' . $_SESSION['identity']->profile_img
                            : base_url . '/assets/img/icono-user.webp' ?>"
                alt="Foto de perfil">
        </div>
        <div id="desplegable_menu">
            <!-- Menu -->
            <nav id="menu" aria-label="Navegación principal">
                <ul>
                    <!-- Elemento común para todos los usuarios -->
                    <li>
                        <a href="<?= base_url ?>user/profile" class="menu-link">Mi perfil</a>
                    </li>

                    <!-- Solo visible para autores -->
                    <?php if ($_SESSION['role'] === 'author'): ?>
                        <li class="author-only">
                            <a href="<?= base_url ?>post/manage" class="menu-link">Publicaciones</a>
                        </li>
                    <?php endif; ?>

                    <!-- Elemento común para todos los usuarios -->
                    <li>
                        <a href="<?= base_url ?>user/settings" class="menu-link">Configuración</a>
                    </li>

                    <!-- Opción de cierre de sesión -->
                    <li>
                        <a href="<?= base_url ?>user/logout" class="menu-link logout">Cerrar sesión</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>