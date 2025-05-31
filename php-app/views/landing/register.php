<?php require_once './views/layout/head.php' ?>

<main class="full-page d-flex align-items-center justify-content-center ">
	<div class="container pt-4">
		<div class="row  justify-content-center">
			<div class="col-md-8 col-lg-6 col-xl-5">
				<div class="card shadow-sm rounded-3 overflow-hidden">
					<div class="card-body p-4 p-md-5">
						<div class="text-center mb-4">
							<h2 class="fw-bold mb-2">Crea tu cuenta</h2>
							<p class="text-muted">Únete a nuestra comunidad literaria</p>
						</div>

						<!-- Alertas -->
						<?php if (isset($_SESSION['register']) && $_SESSION['register'] == 'failed'): ?>
							<div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
								<i class="bi bi-exclamation-triangle-fill me-2"></i>
								<span class="flex-grow-1">Registro fallido, introduce bien los datos</span>
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							</div>
						<?php elseif (isset($_SESSION['error_password'])): ?>
							<div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
								<i class="bi bi-exclamation-triangle-fill me-2"></i>
								<span class="flex-grow-1"><?= $_SESSION['error_password'] ?></span>
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							</div>
						<?php endif; ?>
						<?php Utils::deleteSession('register'); ?>
						<?php Utils::deleteSession('error_password'); ?>

						<!-- Formulario -->
						<form method="post" action="<?= BASE_URL ?>user/save" class="needs-validation" novalidate>
							<!-- Nombre de usuario -->
							<div class="mb-3">
								<label for="username" class="form-label fw-semibold">Nombre de usuario</label>
								<div class="input-group has-validation">
									<input type="text" class="form-control" id="username" name="username"
										placeholder="Tu nombre de usuario" required>
									<div class="invalid-feedback">
										Por favor ingresa un nombre de usuario
									</div>
								</div>
							</div>

							<!-- Email -->
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

							<!-- Contraseña -->
							<div class="mb-3">
								<label for="password" class="form-label fw-semibold">Contraseña</label>
								<div class="input-group has-validation">
									<input type="password" class="form-control" id="password" name="password"
										placeholder="Contraseña"
										pattern="^(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[^a-zA-Z0-9]).{8,}$"
										title="Contraseña"
										required>
									<div class="invalid-feedback">
										Contraseña
									</div>
								</div>
								<div class="form-text">Mínimo 8 caracteres con letras, números y un símbolo.</div>
							</div>

							<!-- Confirmar contraseña -->
							<div class="mb-3">
								<label for="confirmPassword" class="form-label fw-semibold">Repite la contraseña</label>
								<div class="input-group has-validation">

									<input type="password" class="form-control" id="confirmPassword"
										name="confirmPassword" placeholder="Repite la contraseña" required>
									<div class="invalid-feedback">
										Las contraseñas deben coincidir
									</div>
								</div>
							</div>

							<!-- Rol -->
							<div class="mb-4">
								<label for="role" class="form-label fw-semibold">¿Quieres entrar en Alejandría como...?</label>
								<select class="form-select" id="role" name="role" required>
									<option value="reader">Lector</option>
									<option value="author">Autor</option>
								</select>
							</div>

							<!-- Botón de registro -->
							<div class="d-grid mb-3">
								<button type="submit" class="btn btn-standar py-2 fw-semibold">
									<i class="bi bi-person-plus me-2"></i>Regístrate
								</button>
							</div>
						</form>

						<div class="text-center pt-3">
							<p class="mb-0 text-muted">¿Ya tienes cuenta?
								<a href="<?= BASE_URL ?>user/login" class="text-decoration-none custom-link landing-link">Inicia sesión</a>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</main>


<?php require_once './views/layout/footer.php' ?>