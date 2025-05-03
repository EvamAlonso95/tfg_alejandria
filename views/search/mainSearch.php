<!-- Search Bar -->
<section class="py-3 border-bottom">
    <div class="container">
        <form class="row g-2">
            <div class="col-md-10 col-8">
                <input type="text" class="form-control" placeholder="Tu búsqueda...">
            </div>
            <div class="col-md-2 col-4">
                <button type="submit" class="btn btn-primary w-100">Buscar</button>
            </div>
        </form>
    </div>
</section>

<main class="py-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <h5>Resultados de tu búsqueda:</h5>
                <div class="row gy-3">
                    <?php require_once 'views/components/bookSearch.php'; ?>
                </div>
            </div>
        </div>
</main>