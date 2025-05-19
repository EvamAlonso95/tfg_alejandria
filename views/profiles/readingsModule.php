 <?php
	/** @var BookUser[] $booksReading */
	/** @var BookUser[] $booksRead */
	/** @var BookUser[] $booksWantToRead */
	?>
 <!-- Sección de pestañas -->
 <div class="mt-5 container-fluid">
 	<!-- Tabs con scroll horizontal en pantallas pequeñas -->
 	<ul class="nav nav-tabs custom-tabs d-flex flex-nowrap overflow-auto text-center" id="tabsLectura" role="tablist">
 		<li class="nav-item" role="presentation">
 			<button class="nav-link active custom-link" id="leyendo-tab" data-bs-toggle="tab" data-bs-target="#leyendo" type="button" role="tab"> Leyendo</button>
 		</li>
 		<li class="nav-item" role="presentation">
 			<button class="nav-link custom-link" id="quiero-tab" data-bs-toggle="tab" data-bs-target="#quiero" type="button" role="tab">Quiero leer</button>
 		</li>
 		<li class="nav-item" role="presentation">
 			<button class="nav-link custom-link" id="finalizadas-tab" data-bs-toggle="tab" data-bs-target="#finalizadas" type="button" role="tab"> Finalizadas</button>
 		</li>
 	</ul>

 	<!-- Contenido de las pestañas -->
 	<div class="tab-content lecturas p-3" id="tabContentLecturas">
 		<div class="tab-pane fade show active" id="leyendo" role="tabpanel" aria-labelledby="leyendo-tab">
 			<?php if (empty($booksReading)): ?>
 				<div class="text-center my-4">
 					<p class="fs-5 profile-p">📚 No estás leyendo ningún libro en este momento</p>
 					<small class="text-muted">😊 Está bien, tómate un respiro ☕</small>
 				</div>
 			<?php endif;
				foreach ($booksReading as $bookUser):
					$book = $bookUser->getBook();
					require 'views/components/bookProfile.php';
				endforeach; ?>
 		</div>

 		<div class="tab-pane fade" id="quiero" role="tabpanel" aria-labelledby="quiero-tab">
 			<?php if (empty($booksWantToRead)): ?>
 				<div class="text-center my-4">
 					<p class="fs-5 profile-p">😔 No quieres leer ningún libro...</p>
 					<small class="text-muted">📺 Tal vez estás en modo maratón de series. ¡Los libros te esperarán!</small>
 				</div>
 			<?php endif;
				foreach ($booksWantToRead as $bookUser):
					$book = $bookUser->getBook();
					require 'views/components/bookProfile.php';
				endforeach; ?>
 		</div>

 		<div class="tab-pane fade" id="finalizadas" role="tabpanel" aria-labelledby="finalizadas-tab">
 			<?php if (empty($booksRead)): ?>
 				<div class="text-center my-4">
 					<p class="fs-5 profile-p">📖 No tienes libros leídos aún</p>
 					<small class="text-muted">😅 ¡Tu historial de lectura está más limpio que una hoja en blanco!</small>
 				</div>
 			<?php endif;
				foreach ($booksRead as $bookUser):
					$book = $bookUser->getBook();
					require 'views/components/bookProfile.php';
				endforeach; ?>
 		</div>
 	</div>
 </div>