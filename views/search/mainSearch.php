 <?php
    /**  
     * @var Book[] $books
     * @var User $user
     */
    var_dump($user);
    var_dump($books);
    ?>
 <section class="py-3 border-bottom">
     <div class="container">
         <form class="row g-2" action="<?= base_url ?>search">
             <div class=" col-md-10 col-8">
                 <input type="text" name="search" class="form-control" placeholder="Tu búsqueda..." value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
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
                 <?php
                    if (empty($books)) {
                        echo '<h4 class="text-center">No se encontraron resultados.</h4>';
                    } else { ?>
                     <h5>Resultados de tu búsqueda:</h5>
                     <div class="row gy-3">
                         <?php
                            if (isset($books) && count($books) > 0) {
                                foreach ($books as $book):
                                    require_once 'views/components/bookSearch.php';
                                endforeach;
                            } else {
                                echo '<p class="text-center">No se encontraron resultados.</p>';
                            } ?>
                     </div>
                 <?php } ?>
             </div>
         </div>
 </main>