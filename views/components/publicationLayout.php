<div class="border p-3 bg-light h-auto">
    <p>Historial últimas publicaciones</p>
    <!-- Aquí irían tus publicaciones renderizadas dinámicamente -->
    <div class="row">

        <?php foreach ($posts as $post): ?>
            <div class="col-12 col-md-6 col-lg-4 mb-3">
                <div class="card h-100">
                    <img src="<?= base_url . $post->getCoverImg() ?>" class="card-img-top" alt="<?= $post->getTitle() ?>">
                    <div class="card-body">
                        <h5 class="card-title  "><?= $post->getTitle() ?></h5>
                        <p class="card-text"><strong>Autor:</strong> <?= $post->getAuhtor()->getName() ?></p>
                        <p class="card-text"><strong>Fecha:</strong> <?= $post->getCreatedAt() ?></p>
                        <p class="card-text"><?= $post->getContent() ?></p>
                        <a href="<?= base_url ?>post/view/<?= $post->getId() ?>" class="btn btn-primary">Ver publicación</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>