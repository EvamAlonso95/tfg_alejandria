<?php

/**  
 * @var Post $post
 */

?>

<div class="col-sm-6 col-md-4">
	<div class="card h-100 shadow-sm border-0 rounded-3">
		<img
			src="<?= $post->getCoverImg() ?>"
			alt="Imagen del libro"
			class="card-img-top"
			style="height: 180px; object-fit: cover;">
		<div class="card-body d-flex flex-column">
			<h6 class="card-title mb-1">				
					<?= $post->getTitle() ?>				
			</h6>
			<a
				href="<?= BASE_URL ?>post?postId=<?= $post->getId() ?>"
				class="btn btn-standar btn-sm mt-auto align-self-end">Ver más</a>
		</div>
	</div>
</div>