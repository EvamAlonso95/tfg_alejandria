<?php
$user = isset($_SESSION['identity']) ? user::createById($_SESSION['identity']->id)  : null;
$isLogged = false;
$profileImg =  base_url . '/assets/img/icono-user.webp';
$urlHome = base_url;
$isAdmin = false;
$isAuthor = false;
if (!is_null($user)) {
    $profileImg = $user->getProfileImage();
    $roleName = $user->getRole()->getName();
    if ($roleName == 'admin') {
        $isAdmin = true;
    } elseif ($roleName == 'author') {
        $isAuthor = true;
    }
    $isLogged = true;
    $urlHome = base_url . 'dashboard';
}
?>
<nav class="navbar navbar-expand-md bg-body-tertiary">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="<?= $urlHome ?>">
            <img src="<?= base_url ?>/assets/img/logo_prueba.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
            Alejandría
        </a>

        <!-- Toggler solo visible en móvil -->
        <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#mobileNavbar" aria-controls="mobileNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <img height="32" class="rounded-circle" src="<?= $profileImg ?>" alt="Foto de perfil">
        </button>

        <!-- Menú colapsable SOLO para móviles -->
        <div class="collapse navbar-collapse d-md-none" id="mobileNavbar">
            <ul class="navbar-nav ms-auto">
                <?php if ($isLogged): ?>
                    <li class="nav-item d-md-none">
                        <a class="nav-link" href="<?= base_url ?>user/profile">Mi perfil</a>
                    </li>
                    <li class="nav-item d-md-none">
                        <a class="nav-link" href="<?= base_url ?>user/edit">Configuración</a>
                    </li>
                    <?php if ($isAdmin): ?>
                        <li class="nav-item d-md-none">
                            <a class="nav-link" href="<?= base_url ?>admin">Panel de administración</a>
                        </li>
                    <?php endif; ?>
                    <?php if ($isAuthor): ?>
                        <li class="nav-item d-md-none">
                            <a class="nav-link" href="#">Publicaciones</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item d-md-none">
                        <a class="nav-link" href="<?= base_url ?>user/logout">Cerrar sesión</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item d-md-none">
                        <a class="nav-link" href="<?= base_url ?>user/login">Iniciar sesión</a>
                    </li>
                    <li class="nav-item d-md-none">
                        <a class="nav-link" href="<?= base_url ?>user/register">Registrarse</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Menú de escritorio SOLO visible en md y superiores -->
        <div class="d-none d-md-block ms-auto">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img height="32" class="rounded-circle" src="<?= $profileImg ?>" alt="Foto de perfil">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <?php if ($isLogged): ?>
                            <li><a class="dropdown-item" href="<?= base_url ?>user/profile">Mi perfil</a></li>
                            <li><a class="dropdown-item" href="<?= base_url ?>user/edit">Configuración</a></li>
                            <?php if ($isAdmin): ?>
                                <li>
                                    <a class="dropdown-item" href="<?= base_url ?>admin">Panel de administración</a>
                                </li>
                            <?php endif; ?>
                            <?php if ($isAuthor): ?>
                                <li>
                                    <a class="dropdown-item" href="#">Publicaciones</a>
                                </li>
                            <?php endif; ?>

                            <li><a class="dropdown-item" href="<?= base_url ?>user/logout">Cerrar sesión</a></li>
                        <?php else: ?>
                            <li><a class="dropdown-item" href="<?= base_url ?>user/login">Iniciar sesión</a></li>
                            <li><a class="dropdown-item" href="<?= base_url ?>user/register">Registrarse</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>