<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?= base_url ?>/assets/css/styles.css">
    <title>Tu Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php require_once 'views/layout/header.php'; ?>

    <?php var_dump($user); ?>

    <!-- Contenido -->
    <main class="container my-5">
        <form action="<?= base_url ?>user/editUser" method="post" enctype="multipart/form-data">
            <div class="card p-4">
                <h5 class="mb-4">Tus datos:</h5>

                <!-- Imagen y carga -->
                <div class="row mb-3">
                    <div class="col-md-4 text-center mb-2">
                        <!-- Aquí puedes mostrar una imagen previa si ya existe -->
                        <div style="width: 100px; height: 100px; background-color: #e9ecef;" class="mx-auto mb-2">
                            <img src="<?= base_url . $user->profile_img ?>" alt="Foto de perfil" class="img-fluid h-100 object-fit-cover rounded">
                        </div>
                    </div>
                    <div class="col-md-8 d-flex align-items-center">
                        <input type="file" class="form-control" name="profileImg">
                    </div>
                </div>

                <!-- Nombre -->
                <div class="mb-3">
                    <input type="text" class="form-control" name="name" placeholder="Nombre" value="<?= $user->name ?>">
                </div>

                <!-- Correo -->
                <div class="mb-3">
                    <input type="email" class="form-control" name="email" placeholder="Correo" value="<?= $user->email ?>">
                </div>

                <!-- Biografía -->
                <div class="mb-3">
                    <textarea class="form-control" name="biography" rows="4" placeholder="Biografía"><?= $user->biography ?></textarea>
                </div>

                <!-- Botón -->
                <div class="text-center">
                    <input type="submit" class="btn btn-primary w-100" value="Subir cambios" />
                </div>
            </div>
        </form>
    </main>


    <?php require_once 'views/layout/footer.php'; ?>