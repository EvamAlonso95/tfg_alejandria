 <?php
	/**  
	 * @var Book[] $books
	 */
	?>


 <main class="full-page py-4">
 	<div class="container">
 		<!-- Buscador -->
 		<section class="py-3 section-search">
 			<form class="row g-2 container-form d-flex" action="<?= BASE_URL ?>search">
 				<div class="col-md-10 col-8">
 					<input type="text" name="search" class="form-control" placeholder="Tu búsqueda..." value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
 				</div>

 				<div class="col-md-2 col-4">
 					<input type="submit" class="btn btn-standar btn-search w-100 h-100" value="Buscar">
 				</div>
 			</form>
 		</section>

 		<!-- Resultados -->
 		<div class="row mt-4">
 			<div class="col-lg-12">
 				<?php if (empty($books)) { ?>
 					<h4 class="text-center no-results">No se encontraron resultados</h4>
 				<?php } else { ?>
 					<div class="row gy-3">
 						<?php
							foreach ($books as $book):
								require 'views/components/bookSearch.php';
							endforeach; ?>
 					</div>
 				<?php } ?>
 			</div>
 		</div>
 	</div>
 	<!-- TODO REVISAR EL BOTON Y EL SCRIPT -->
 	<button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>
 </main>


 <script>
 	// Get the button:
 	let mybutton = document.getElementById("myBtn");

 	// When the user scrolls down 20px from the top of the document, show the button
 	window.onscroll = function() {
 		scrollFunction()
 	};

 	function scrollFunction() {
 		if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
 			mybutton.style.display = "block";
 		} else {
 			mybutton.style.display = "none";
 		}
 	}

 	// When the user clicks on the button, scroll to the top of the document
 	function topFunction() {
 		document.body.scrollTop = 0; // For Safari
 		document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
 	}
 </script>