<?php

/**
 * @var POST $post
 */

// var_dump($author);
?><?php

    require_once 'views/layout/head.php'; ?>

<?php var_dump($post); ?>
<!-- Contenido principal -->
<main class="container py-4 position-relative">

    <!-- Imagen destacada -->
    <div class="mb-3">
        <img src="<?= $post->getCoverImg() ?>" class="img-fluid border" alt="Imagen del post">
    </div>

    <!-- Título y metadatos -->
    <div class="mb-3">
        <h2><?= $post->getTitle() ?></h2>
        <small class="text-muted"><?= $post->getAuhtor()->getName() ?> - <?= $post->getCreatedAt() ?></small>
    </div>



    <!-- Contenido del post -->
    <div class="border p-3 bg-light">
        <p><?= $post->getContent() ?></p>
    </div>
</main>

<?php require_once 'views/layout/footer.php'; ?>