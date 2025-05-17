<?php
$user = isset($_SESSION['identity']) ? User::createById($_SESSION['identity']->id)  : null;
$isLogged = false;
$profileImg =  BASE_URL . 'assets/img/default_perfil.jpg';
$logoImg = BASE_URL . 'assets/img/book.svg';
$urlHome = BASE_URL;
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
	$urlHome = BASE_URL . 'dashboard';
}
?>
<nav class="navbar navbar-expand-md ">
	<div class="container">
		<!-- Logo -->
		<a class="navbar-brand " href="<?= $urlHome ?>">
			<img src="<?= $logoImg?>" alt="Logo" width="30" height="24" class="d-inline-block align-text-top nav-logo">
			Alejandría
		</a>

		<!-- Toggler solo visible en móvil -->
		<button class="navbar-toggler d-md-none mobile-element" type="button" data-bs-toggle="collapse" data-bs-target="#mobileNavbar" aria-controls="mobileNavbar" aria-expanded="false" aria-label="Toggle navigation">
			<img height="32" class="rounded-circle" src="<?= $profileImg ?>" alt="Foto de perfil">
		</button>

		<!-- Menú colapsable SOLO para móviles -->
		<div class="collapse navbar-collapse d-md-none" id="mobileNavbar">
			<ul class="navbar-nav ms-auto collapse-element">
				<?php if ($isLogged): ?>
					<li class="nav-item d-md-none">
						<a class="nav-link" href="<?= BASE_URL ?>user/profile">Mi perfil</a>
					</li>
					<li class="nav-item d-md-none">
						<a class="nav-link" href="<?= BASE_URL ?>user/edit">Configuración</a>
					</li>
					<?php if ($isAdmin): ?>
						<li class="nav-item d-md-none">
							<a class="nav-link" href="<?= BASE_URL ?>admin">Panel de administración</a>
						</li>
					<?php endif; ?>
					<?php if ($isAuthor): ?>
						<li class="nav-item d-md-none">
							<a class="nav-link" href="<?= BASE_URL ?>post">Publicaciones</a>
						</li>
					<?php endif; ?>
					<li class="nav-item d-md-none">
						<a class="nav-link" href="<?= BASE_URL ?>user/logout">Cerrar sesión</a>
					</li>
				<?php else: ?>
					<li class="nav-item d-md-none">
						<a class="nav-link" href="<?= BASE_URL ?>user/login">Iniciar sesión</a>
					</li>
					<li class="nav-item d-md-none">
						<a class="nav-link" href="<?= BASE_URL ?>user/register">Registrarse</a>
					</li>
				<?php endif; ?>
			</ul>
		</div>

		<!-- Menú de escritorio SOLO visible en md y superiores -->
		<div class="d-none d-md-block ms-auto">
			<ul class="navbar-nav">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle after-element" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
						<img height="32" class="rounded-circle" src="<?= $profileImg ?>" alt="Foto de perfil">
					</a>
					<ul class="dropdown-menu dropdown-menu-end">
						<?php if ($isLogged): ?>
							<li><a class="dropdown-item" href="<?= BASE_URL ?>user/profile">Mi perfil</a></li>
							<li><a class="dropdown-item" href="<?= BASE_URL ?>user/edit">Configuración</a></li>
							<?php if ($isAdmin): ?>
								<li>
									<a class="dropdown-item" href="<?= BASE_URL ?>admin">Panel de administración</a>
								</li>
							<?php endif; ?>
							<?php if ($isAuthor): ?>
								<li>
									<a class="dropdown-item" href="<?= BASE_URL ?>post">Publicaciones</a>
								</li>
							<?php endif; ?>

							<li><a class="dropdown-item" href="<?= BASE_URL ?>user/logout">Cerrar sesión</a></li>
						<?php else: ?>
							<li><a class="dropdown-item" href="<?= BASE_URL ?>user/login">Iniciar sesión</a></li>
							<li><a class="dropdown-item" href="<?= BASE_URL ?>user/register">Registrarse</a></li>
						<?php endif; ?>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>