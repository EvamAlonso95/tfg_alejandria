<?php

/** @var Post[] $posts */
?>


<div class="container div-background my-4 pt-4">


	<div class="row">
		<?php foreach ($posts as $index => $post): ?>
			<div class="col-12 container-card-post">
				<!-- Cada publicación tiene un id único para scrollspy -->
				<div class="card h-100 mb-3 card-post" id="post<?= $index ?>">
					<img src="<?= $post->getCoverImg() ?>" class="card-img-top card-post-img" alt="<?= $post->getTitle() ?>">
					<div class="card-body card-post-body">
						<h5 class="card-title card-post-title"><?= $post->getTitle() ?></h5>
						<p class="card-text card-post-text"><strong>Autor:</strong> <?= $post->getAuhtor()->getName() ?></p>
						<p class="card-text card-post-text"><strong>Fecha:</strong> <?= $post->getCreatedAt() ?></p>
						<p class="card-text card-post-text"><?= $post->getContent() ?></p>
						<a href="<?= BASE_URL ?>post/info?postId=<?= $post->getId() ?>" class="btn btn-standar">Ver publicación</a>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>