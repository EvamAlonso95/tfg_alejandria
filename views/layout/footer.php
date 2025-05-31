 <!-- Pie de página -->
 <?php
	if ($this->showFooter):
	?>
 	<footer id="footer" class="border-top  text-muted py-2 mt-1">
 		<div class="container text-center">
 			<p class="mb-1 fw-semibold">Desarrollado por Eva Alonso &copy; <?= date('Y') ?></p>
 			<p class="mb-0 small">Todos los derechos reservados.</p>
 		</div>
 	</footer>


 <?php
	endif;
	?>

 <?php require_once 'views/components/toast.php'; ?>

 <script src="<?= BASE_URL ?>assets/js/bootstrap.bundle.min.js"></script>
 <script src="<?= BASE_URL ?>/assets/js/toastMessage.js"></script>
 </body>

 </html>