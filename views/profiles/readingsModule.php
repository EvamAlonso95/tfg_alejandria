 <?php
  /** @var BookUser[] $booksReading */
  /** @var BookUser[] $booksRead */
  /** @var BookUser[] $booksWantToRead */
  ?>
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
      // TODO: si no hay libros, mostrar un mensaje
      foreach ($booksReading as $bookUser) :
        $book = $bookUser->getBook();
        require 'views/components/bookProfile.php';

      endforeach; ?>
   </div>

   <!-- Otras pestañas pueden tener contenido similar -->
   <div class="tab-pane fade" id="quiero" role="tabpanel">
     <?php
      // TODO: si no hay libros, mostrar un mensaje
      foreach ($booksWantToRead as $bookUser) :
        $book = $bookUser->getBook();
        require 'views/components/bookProfile.php';
      endforeach; ?>
   </div>
   <div class="tab-pane fade" id="finalizadas" role="tabpanel">
     <?php
      // TODO: si no hay libros, mostrar un mensaje
      foreach ($booksRead as $bookUser) :
        $book = $bookUser->getBook();
        require 'views/components/bookProfile.php';

      endforeach; ?>
   </div>
 </div>