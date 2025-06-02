<?php

/** @var User $user */

require_once 'views/layout/head.php'; ?>

<!-- Contenido -->
<main class="container my-5 full-page">
	<form action="<?= BASE_URL ?>user/editUser" method="post" enctype="multipart/form-data">
		<div class="card p-4 card-edit-profile">
			<h5 class="mb-4">Tus datos:</h5>

			<!-- Imagen y carga -->
			<div class="row mb-3">
				<div class="col-md-4 text-center mb-2">
					<div class="mx-auto mb-2 w-50">
						<img src="<?= $user->getProfileImage() ?>" alt="Foto de perfil" class="img-fluid profile-image">
					</div>
				</div>
				<div class="col-md-8 d-flex align-items-center">
					<input type="file" class="form-control" name="profileImg" accept="image/*">
				</div>
			</div>

			<!-- Nombre -->
			<div class="mb-3">
				<input type="text" class="form-control" name="name" placeholder="Nombre" value="<?= $user->getName() ?>">
			</div>

			<!-- Correo -->
			<div class="mb-3">
				<input type="email" class="form-control" readonly name="email" placeholder="Correo" value="<?= $user->getEmail() ?>">
			</div>

			<!-- Biografía -->
			<div class="mb-3">
				<textarea class="form-control" name="biography" rows="4" placeholder="Biografía"><?= $user->getBiography() ?></textarea>
			</div>

			<!-- Botón -->
			<div class="text-center">
				<input type="submit" class="btn btn-standar w-100" value="Subir cambios" />
			</div>
		</div>
	</form>
</main>


<?php require_once 'views/layout/footer.php'; ?>