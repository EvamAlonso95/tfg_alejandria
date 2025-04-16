 <!-- Pie de página -->
 <?php
    if ($this->showFooter):
    ?>
     <footer id="footer" class="border-top py-3 text-center bg-light">
         <div class="container">
             <p class="mb-0">Desarrollado por Eva Alonso &copy; <?= date('Y') ?></p>
         </div>
     </footer>

 <?php
    endif;
    ?>
 <!-- Bootstrap JS Bundle -->

 <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
 <script src="<?= base_url ?>assets/js/bootstrap.bundle.min.js"></script>

 </body>

 </html>