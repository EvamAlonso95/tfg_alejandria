<?php

/**
 * @var Author $author
 * @var Author[] $authors
 */
// var_dump($author);

// var_dump($booksPublished);
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
        <div class=" col-md-8">
        <h2><?= $author->getName() ?></h2>
        <p><strong>Biografía:</strong> <?= $author->getBiography() ?></p>
      </div>
    </div>

    <!-- Libros del autor -->
    <div>
      <h4>Libros del autor</h4>
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        <?php
        if (isset($booksPublished) && count($booksPublished) > 0) {
          foreach ($booksPublished as $book):
            require 'views/components/bookAuthorCard.php';
          endforeach;
        }
        ?>
      </div>

    </div>
  </div>

  </div>
</main>