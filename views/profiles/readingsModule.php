 <!-- Sección de pestañas -->
 <ul class="nav nav-tabs " id="tabsLectura" role="tablist">
   <li class="nav-item" role="presentation">
     <button class="nav-link active" id="leyendo-tab" data-bs-toggle="tab" data-bs-target="#leyendo" type="button" role="tab">Leyendo</button>
   </li>
   <li class="nav-item" role="presentation">
     <button class="nav-link" id="quiero-tab" data-bs-toggle="tab" data-bs-target="#quiero" type="button" role="tab">Quiero leer</button>
   </li>
   <li class="nav-item" role="presentation">
     <button class="nav-link" id="finalizadas-tab" data-bs-toggle="tab" data-bs-target="#finalizadas" type="button" role="tab">Finalizadas</button>
   </li>
 </ul>

 <!-- Contenido de cada pestaña -->
 <div class="tab-content lecturas" id="tabContentLecturas">
   <div class="tab-pane fade show active" id="leyendo" role="tabpanel">
     <!-- Lista de libros -->
      <?php
       //TODO Foreach con los libros de este idUser que coincidan con reading, want to read o finised
       ?>
     <div class="book-card">
       <div class="book-cover">Portada</div>
       <div class="flex-grow-1 ms-3">Título y detalles del libro</div>
       <button class="btn btn-secondary">Botón</button>
     </div>
     <div class="book-card">
       <div class="book-cover">Portada</div>
       <div class="flex-grow-1 ms-3">Título y detalles del libro</div>
       <button class="btn btn-secondary">Botón</button>
     </div>
     <div class="book-card">
       <div class="book-cover">Portada</div>
       <div class="flex-grow-1 ms-3">Título y detalles del libro</div>
       <button class="btn btn-secondary">Botón</button>
     </div>

     <!-- Paginación -->
     <nav>
       <ul class="pagination d-flex justify-content-center">
         <li class="page-item"><a class="page-link" href="#">1</a></li>
         <li class="page-item"><a class="page-link" href="#">2</a></li>
         <li class="page-item"><a class="page-link" href="#">3</a></li>
       </ul>
     </nav>
   </div>

   <!-- Otras pestañas pueden tener contenido similar -->
   <div class="tab-pane fade" id="quiero" role="tabpanel">Contenido de "Quiero leer"</div>
   <div class="tab-pane fade" id="finalizadas" role="tabpanel">Contenido de "Finalizadas"</div>
 </div>