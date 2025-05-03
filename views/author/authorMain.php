<?php
/**
 * @var Author $author
 * @var Author[] $authors
  */

// var_dump($author);
?>
<!-- Perfil del autor -->
<main class="py-4">
    <div class="container">

      <!-- Foto y datos del perfil -->
      <div class="row mb-5 align-items-center">
        <!-- Foto -->
        <div class="col-md-4 text-center mb-3 mb-md-0">
          
          <img class="container-img" src="<?= $author->getProfileImage() ?>" alt="Imgen perfilt del Author" ">
        </div>

        <!-- Datos del perfil -->
        <div class="col-md-8">
          <h2><?=$author->getName()?></h2>
          <p><strong>Biografía:</strong> <?=$author->getBiography()?></p>
        </div>
      </div>

      <!-- Libros del autor -->
      <div>
        <h4>Libros del autor</h4>
        <div class="row gy-4">
          <!-- Tarjeta de libro -->
          <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card h-100">
              <div class="bg-light" style="height: 200px;"></div> <!-- Aquí va la imagen -->
              <div class="card-body d-flex flex-column">
                <h6 class="card-title">Título del libro</h6>
                <a href="#" class="btn btn-primary mt-auto">Añadir</a>
              </div>
            </div>
          </div>

          <!-- Puedes duplicar este bloque para más libros -->
        </div>
      </div>

    </div>
  </main>