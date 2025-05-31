<?php

/**
 * @var User $user
 */
?>
<?php require_once 'views/layout/head.php'; ?>


<main class="container my-5 full-page">

	<!-- Datos del usuario -->
	<div class="card p-4 ">
		<div class="row g-4 align-items-start">
			<!-- Foto -->
			<div class="col-md-3 my-2">
				<div class="profile-card p-3 text-center">
					<img src="<?= $user->getProfileImage() ?>" alt="Foto de perfil" class="img-fluid profile-image">
				</div>
			</div>

			<!-- Datos -->
			<div class="col-md-9">
				<div class="profile-card p-4">
					<div class="profile-data">
						<span class="data-name">Nombre:</span>
						<span class="data-value"><?= $user->getName() ?></span>
					</div>
					<div class="profile-data">
						<span class="data-name">Correo:</span>
						<span class="data-value"><?= $user->getEmail() ?></span>
					</div>
					<div class="profile-data">
						<span class="data-name">Biografía:</span>
						<span class="data-value"><?= $user->getBiography() ?></span>
					</div>
				</div>
			</div>
		</div>
	</div>



	<?php require_once 'views/profiles/readingsModule.php'; ?>
	<button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>
</main>

<?php
require_once 'views/components/scrollUp.php';
require_once 'views/layout/footer.php';
?>