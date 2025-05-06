<div class="border p-3 bg-light h-auto">
    <p>Historial últimas publicaciones</p>
    <!-- Aquí irían tus publicaciones renderizadas dinámicamente -->
    <div class="row">

        <?php foreach ($posts as $post): ?>
            <div class="col-12 col-md-6 col-lg-4 mb-3">
                <div class="card h-100">
                    <!-- Botón eliminar en la esquina superior derecha -->
                    <form action="<?= base_url ?>post/delete" method="post" class="position-absolute top-0 end-0 m-2">
                        <input type="hidden" name="post_id" value="<?= $post->getId(); ?>">
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este post?');">
                            &times;
                        </button>
                    </form>
                    <img src="<?= base_url . $post->getCoverImg() ?>" class="card-img-top" alt="<?= $post->getTitle() ?>">
                    <div class="card-body">
                        <h5 class="card-title  "><?= $post->getTitle() ?></h5>
                        <p class="card-text"><strong>Autor:</strong> <?= $post->getAuhtor()->getName() ?></p>
                        <p class="card-text"><strong>Fecha:</strong> <?= $post->getCreatedAt() ?></p>
                        <p class="card-text"><?= $post->getContent() ?></p>
                        <a href="<?= base_url ?>" class="btn btn-primary">Ver publicación</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>