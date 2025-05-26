<!-- TODO REVISAR COMPONENTE AÑADIR EL HTML -->
<?php if (isset($_SESSION['toast'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            showToast("<?= addslashes($_SESSION['toast']['message']) ?>", <?= $_SESSION['toast']['isSuccess'] ? 'true' : 'false' ?>);
        });
    </script>
    <?php unset($_SESSION['toast']); ?>
<?php endif; ?>

<script>
    function showToast(message, isSuccess = true) {
        const toastEl = document.getElementById('toastNotification');
        const toastBody = document.getElementById('toastBody');

        toastBody.textContent = message;

        // Limpiar clases previas y aplicar nueva
        toastEl.classList.remove('bg-success', 'bg-danger');
        toastEl.classList.add(isSuccess ? 'bg-success' : 'bg-danger');

        // Instanciar el toast (con delay de 4 segundos)
        const toast = new bootstrap.Toast(toastEl, {
            autohide: true,
            delay: 4000
        });

        toast.show();
    }
</script>