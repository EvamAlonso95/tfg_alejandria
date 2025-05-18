<main class=" full-page " id="content">
    <div class="container ">

        <div class="row">
            <div class="col-md-8 ">

                <?php require_once 'views/components/publicationLayout.php'; ?>
            </div>
            <!-- Barra lateral -->
            <?php include_once 'sidebar.php'; ?>
        </div>

    </div>
</main>
<!-- TOAST HACER UN INCLUDE -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1100">
    <div id="toastNotification" class="toast bg-success text-white" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body" id="toastBody">
                <!-- Aquí va el mensaje -->
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Cerrar"></button>
        </div>
    </div>
</div>

<!-- TODO REVISAR EL BOTON Y EL SCRIPT -->
<button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>

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