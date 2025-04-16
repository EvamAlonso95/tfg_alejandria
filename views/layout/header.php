<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <img
            src="<?= base_url ?>/assets/img/logo_prueba.png" alt="logo de Alejandría"
            class="me-2"
            height="32"
            loading="lazy" />
        <a class="navbar-brand" href="<?= base_url ?>dashboard">Alejandría</a>


        <?php if ($this->showUserMenu): ?>
            <!-- Botón del toggler -->
            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Contenido colapsable -->
            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img height="32" src="<?= isset($_SESSION['identity']->profile_img) && file_exists($_SESSION['identity']->profile_img)
                                                        ? base_url . '/' . $_SESSION['identity']->profile_img
                                                        : base_url . '/assets/img/icono-user.webp' ?>"
                                alt="Foto de perfil">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?= base_url ?>user/profile">Mi perfil</a></li>
                            <li><a class="dropdown-item" href="<?= base_url ?>user/edit">Configuración</a></li>
                            <?php if ($_SESSION['role'] == 'author') : ?>
                                <li><a class="dropdown-item" href="#">Publicaciones</a></li>
                            <?php endif; ?>
                            <li><a class="dropdown-item" href="<?= base_url ?>user/logout">Cerrar sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        <?php else: ?>
            <div class="container d-flex justify-content-end gap-2 py-1">
                <a href="<?= base_url ?>user/register" class="btn btn-sm btn-outline-primary px-3">Regístrate</a>
                <a href="<?= base_url ?>user/login" class="btn btn-sm btn-primary px-3">Inicia sesión</a>
            </div>
        <?php endif; ?>
    </div>
</nav>