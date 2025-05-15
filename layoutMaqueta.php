<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css">

	<title>Alejandría</title>
</head>

<body>
	<!-- Cabecera -->
	<header id="header" style="border: 1px solid blue;">
		<div id="logo">
			<img src="<?= BASE_URL ?>/assets/img/logo_prueba.png" alt="logo de Alejandría">
			<a href="index.php">Alejandría</a>
		</div>
		<div id="perfil_container">
			<div id="user_logo">
				<img src="<?= BASE_URL ?>/assets/img/icono-user.webp" alt="" srcset="">
			</div>
			<div id="desplegable_menu">
				<!-- Menu -->
				<nav id="menu" aria-label="Navegación principal">
					<ul>
						<!-- Elemento común para todos los usuarios -->
						<li>
							<a href="<?= BASE_URL ?>user/profile" class="menu-link">Mi perfil</a>
						</li>

						<!-- Solo visible para autores -->
						<?php if ($_SESSION['role'] === 'author'): ?>
							<li class="author-only">
								<a href="<?= BASE_URL ?>post/manage" class="menu-link">Publicaciones</a>
							</li>
						<?php endif; ?>

						<!-- Elemento común para todos los usuarios -->
						<li>
							<a href="<?= BASE_URL ?>user/settings" class="menu-link">Configuración</a>
						</li>

						<!-- Opción de cierre de sesión -->
						<li>
							<a href="<?= BASE_URL ?>user/logout" class="menu-link logout">Cerrar sesión</a>
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
	<!-- Bootstrap JS Bundle -->

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>