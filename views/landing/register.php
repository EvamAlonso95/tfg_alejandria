<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrate</title>
</head>
<body>
    <form method="post" action="<?=base_url?>index">
        <input type="text" placeholder="Tu nombre de usuario">
        <input type="email" name="" id="" placeholder="Tu correo">
        <input type="password" name="" id="" placeholder="Contraseña">
        <input type="password" placeholder="Repite la contraseña">
        <label for="profile">Quieres entrar en Alejandría como...</label>
        <select name="profile" id="profile">
            <option value="author">Autor</option>
            <option value="reader">Lector</option>
        </select>
        <input type="submit" value="Registrate">
    </form>
    <span>¿Ya tienes cuenta? <a href="<?= base_url ?>user/login">Inicia sesión</a></span>
</body>
</html>