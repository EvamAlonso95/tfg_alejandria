<?php require_once './views/layout/head.php' ?>

<main class="full-page d-flex align-items-center justify-content-center">

	<div class="container  pt-4 ">
		<div class="row justify-content-center ">
			<div class="col-md-8 col-lg-6 col-xl-5">
				<div class="card shadow-sm rounded-3 overflow-hidden ">
					<div class="card-body p-4 p-md-5">
						<div class="text-center mb-4">
							<h2 class="fw-bold mb-3">Inicia sesión</h2>
						</div>

						<!-- Alertas -->
						<?php if (isset($_SESSION['register']) && $_SESSION['register'] == 'complete'): ?>
							<div class="alert alert-success alert-dismissible fade show text-center" role="alert">
								<span>Registro completado correctamente</span>
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							</div>
						<?php elseif (isset($_SESSION['error_login'])): ?>
							<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
								<span><?= $_SESSION['error_login'] ?></span>
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							</div>
						<?php endif; ?>
						<?php Utils::deleteSession('register'); ?>
						<?php Utils::deleteSession('error_login'); ?>

						<!-- Formulario -->
						<form method="post" action="<?= BASE_URL ?>user/loginUser" class="needs-validation" novalidate>
							<div class="mb-3">
								<label for="email" class="form-label fw-semibold">Correo electrónico</label>
								<div class="input-group has-validation">
									<input type="email" class="form-control" id="email" name="email"
										placeholder="tucorreo@ejemplo.com" required>
									<div class="invalid-feedback">
										Por favor ingresa un correo válido
									</div>
								</div>
							</div>

							<div class="mb-4">
								<label for="password" class="form-label fw-semibold">Contraseña</label>
								<div class="input-group has-validation">
									<input type="password" class="form-control" id="password" name="password"
										placeholder="Ingresa tu contraseña" required>
									<div class="invalid-feedback">
										Por favor ingresa tu contraseña
									</div>
								</div>
							</div>

							<div class="d-grid mb-3">
								<button type="submit" class="btn btn-standar py-2 fw-semibold">
									Iniciar sesión
								</button>
							</div>
						</form>

						<div class="text-center pt-3">
							<p class="mb-0 text-muted">¿No tienes cuenta?
								<a href="<?= BASE_URL ?>user/register" class="text-decoration-none fw-semibold landing-link">Regístrate</a>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>

<?php require_once './views/layout/footer.php' ?>