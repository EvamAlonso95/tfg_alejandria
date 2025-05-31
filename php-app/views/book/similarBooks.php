<div class="mt-5 container-similar-books p-4">
  <h5 class="mb-4 ">Libros similares</h5>
  <div class="row gy-4">
    <?php foreach ($recommendedBooks as $recommendedBook): ?>
      <div class="col-sm-6 col-md-4">
        <div class="card h-100 shadow-sm border-0 rounded-3">
          <img 
            src="<?= $recommendedBook->getCoverImg() ?>" 
            alt="Imagen del libro" 
            class="card-img-top" 
            style="height: 180px; object-fit: cover;"
          >
          <div class="card-body d-flex flex-column">
            <h6 class="card-title mb-1"><?= $recommendedBook->getTitle() ?></h6>
            <?php
              $authorNames = [];
              foreach ($recommendedBook->getAuthors() as $author) {
                $authorNames[] = $author->getName();
              }
            ?>
            <p class="card-text text-muted small mb-2">Autor/es: <?= implode(', ', $authorNames) ?></p>
            <a 
              href="<?= BASE_URL ?>book?bookId=<?= $recommendedBook->getId() ?>" 
              class="btn btn-standar btn-sm mt-auto align-self-end"
            >Ver más</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
