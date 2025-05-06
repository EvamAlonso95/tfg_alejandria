<?php
require_once 'views/layout/head.php'; ?>
<!-- Main content -->
<main class="container py-4 h-auto">
    <div class="row">
        <!-- Historial de publicaciones -->
        <div class="col-md-8 mb-4">
            <h5>Tus publicaciones:</h5>
            <!-- TODO foreach para mostrar las ultimas publicaciones -->
            <?php require_once 'views/components/publicationLayout.php'; ?>
        </div>
        <!-- Formulario de publicación -->
        <div class="col-md-4 mb-4">
            <h5>Publica:</h5>
            <form  action="<?= base_url ?>post/save" method="post" enctype="multipart/form-data">


                <div class="border p-3 bg-light h-100">
                    <!-- Imagen -->
                    <div class="mb-3 text-center">
                        <label class="form-label d-block">Imagen del post</label>
                        <input type="file" class="form-control" name="cover_img">
                    </div>

                    <!-- Título -->
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="Título" name="title" required>
                    </div>

                    <!-- Texto -->
                    <div class="mb-3">
                        <textarea class="form-control" rows="4" placeholder="Texto" name="content"></textarea>
                    </div>

                    <!-- Botón Publicar -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-earth">Publicar</button>

                    </div>
                </div>
            </form>
        </div>
    </div>
</main>


<?php require_once 'views/layout/footer.php'; ?>