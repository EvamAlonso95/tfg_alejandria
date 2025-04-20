  <?php
  /** @var User $user */

  require_once 'views/layout/head.php'; ?>


  <main class="container my-4">
    <h1 class="text-start mb-4"><?= $user->getName() ?></h1>

    <!-- Datos del usuario -->
    <section class="profile-section">
      <div class="row mb-4">
        <!-- Foto -->
        <div class="col-md-2">
          <div class="border p-3">
            <img src="<?= base_url . $user->getProfileImage() ?>" alt="Foto de perfil" class="img-fluid object-fit-cover rounded">
          </div>
        </div>


        <div class="col-md-10">
          <div class="border p-3">
            <div class="profile-data">
              <span class="data-name">Nombre:</span>
              <span class="data-value"><?= $user->getName() ?> </span>
            </div>
            <div class="profile-data">
              <span class="data-name">Correo:</span>
              <span class="data-value"><?= $user->getEmail() ?></span>
            </div>
            <div class="profile-data block">
              <span class="data-name">Biografía:</span>
              <span class="data-value"><?= $user->getBiography() ?></span>
            </div>

          </div>
        </div>
      </div>
    </section>

    <?php require_once 'views/profiles/readingsModule.php'; ?>


  </main>

  <?php require_once 'views/layout/footer.php'; ?>