<div class="position-fixed top-0 end-0 p-3" style="z-index: 1100">
	<div id="toastNotification" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
		<div class="d-flex">
			<div class="toast-body" id="toastBody">
			</div>
			<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Cerrar"></button>
		</div>
	</div>
</div>
<script>
	const toastData = <?= json_encode($this->toastData) ?>;
</script>