<?php
class Utils
{
    public static function deleteSession($name)
    {
        if (isset($_SESSION[$name])) {
            $_SESSION[$name] = null;
            unset($_SESSION[$name]);
        }
        return $name;
    }

    // Si no hay una sesión iniciada como usuario, redirige a la página de login
    public static function isIdentity()
    {
        if (!isset($_SESSION['identity'])) {
            header('Location:' . base_url);
        } else {
            return true;
        }
    }

    //TODO: MEterselo a todas las páginas que correspondan
    public static function requireLogin()
    {
        if (isset($_SESSION['identity'])) {
            header('Location:' . base_url );
            exit();
        } else {
            return true;
        }
    }

    //TODO: require admin
    //TODO: require author
    //Una funcion que verifique

    // Redirigir
   
}
