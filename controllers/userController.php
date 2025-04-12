<?php
require_once './models/user.php';

class userController
{

    public function index()
    {
        echo 'Hola soy un usuario';
    }

    public function register()
    {
        require_once 'views/landing/register.php';
    }


    public function save()
    {
        if (isset($_POST)) {

            // Si existe el post, será el valor de la variable, sino será false
            $nombre = isset($_POST['username']) ? $_POST['username'] : false;
            $email = isset($_POST['email']) ? $_POST['email'] : false;
            $password = isset($_POST['password']) ? $_POST['password'] : false;
            $role = isset($_POST['role']) ? $_POST['role'] : false;


            // Cada valor se le pasa al setter FALTARÍA LA VALIDACIÓN DEL PROYECTO ANTERIOR
            if ($nombre  && $email && $password && $role) {
                $usuario = new User();
                $usuario->setName($nombre);
                $usuario->setEmail($email);
                $usuario->setPassword($password);
                $usuario->setRole($role);

                $save = $usuario->save();
                var_dump($save);
                if ($save) {
                    $_SESSION['register'] = "complete";
                } else {
                    $_SESSION['register'] = "failed";
                }
            } else {
                $_SESSION['register'] = "failed";
            }
        } else {
            $_SESSION['register'] = "failed";
        }
        // header("Location:" . base_url . 'user/register');
        var_dump($_SESSION['register']);
    }

    public function login()
    {
        require_once 'views/landing/login.php';
    }
}
