<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?= base_url ?>/assets/css/styles.css">
  <title>Tu Perfil</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>

  </style>
</head>

<body>

  <?php require_once 'views/layout/header.php'; ?>


  <main class="container my-4">
    <h1 class="text-start mb-4">Tu perfil</h1>


    <!-- Datos del usuario -->
    <div class="row text-center text-md-start mb-4 align-items-stretch">
      <!-- Foto -->
      <div class="col-md-4 mb-3">
        <div class="border p-3 h-100 d-flex justify-content-center align-items-center">
          <img src="https://via.placeholder.com/150" alt="Foto de perfil" class="img-fluid h-100 object-fit-cover rounded">
        </div>
      </div>

      <!-- Tus datos (ocupa el resto del ancho disponible) -->
      <div class="col mb-3">
        <div class="border p-3 d-flex flex-column gap-2 h-100">
          <div>
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" id="nombre" class="form-control" value="Juan Pérez" readonly>
          </div>
          <div>
            <label for="correo" class="form-label">Correo</label>
            <input type="email" id="correo" class="form-control" value="juan@example.com" readonly>
          </div>
          <div>
            <label for="biografia" class="form-label">Biografía</label>
            <textarea id="biografia" class="form-control" rows="3" readonly>Apasionado por la lectura y la tecnología.</textarea>
          </div>
          <div class="text-end mt-2">
            <a href="#editar-perfil" class="btn btn-sm btn-outline-primary">Editar perfil</a>
          </div>
        </div>
      </div>
    </div>



    <!-- Sección de pestañas -->
    <ul class="nav nav-tabs mb-3" id="tabsLectura" role="tablist">
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
    <div class="tab-content" id="tabContentLecturas">
      <div class="tab-pane fade show active" id="leyendo" role="tabpanel">
        <!-- Lista de libros -->
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
          <ul class="pagination">
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
  </main>

  <?php require_once 'views/layout/footer.php'; ?>