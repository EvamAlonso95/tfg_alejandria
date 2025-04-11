<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicia sesión</title>
</head>
<body>
    <form method="post" action="<?=base_url?>index">
        <input type="email" name="" id="" placeholder="Tu correo">
        <input type="password" name="" id="" placeholder="Contraseña">
        <input type="submit" value="Iniciar sesión">
    </form>
    <span>¿No tienes cuenta? <a href="<?= base_url ?>user/register">Regístrate</a></span>
</body>
</html>