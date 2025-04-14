<?php
// Iniciamos la sesión para poder usarla en el controlador frontal
require_once './models/user.php';

class UserController
{

    public function index()
    {
        echo 'Hola soy un usuario';
    }

    public function register()
    {
        require_once 'views/landing/register.php';
    }

    public function login()
    {
        require_once 'views/landing/login.php';
    }


    // Método para guardar el usuario
    public function save()
    {
        if (isset($_POST)) {

            // Si existe el post, será el valor de la variable, sino será false
            $nombre = isset($_POST['username']) ? $_POST['username'] : false;
            $email = isset($_POST['email']) ? $_POST['email'] : false;
            $password = isset($_POST['password']) ? $_POST['password'] : false;
            $confirmPassword = isset($_POST['confirmPassword']) ? $_POST['confirmPassword'] : false;
            $role = isset($_POST['role']) ? $_POST['role'] : false;

            if ($password != $confirmPassword) {
                $_SESSION['error_password'] = "Error, las contraseñas no coinciden";
                header("Location:" . base_url . 'user/register');
                exit();
            }

            // Cada valor se le pasa al setter FALTARÍA LA VALIDACIÓN DEL PROYECTO ANTERIOR
            if ($nombre  && $email && $password && $role) {
                $usuario = new User();
                $usuario->setName($nombre);
                $usuario->setEmail($email);
                $usuario->setPassword($password);
                $usuario->setRole($role);

                $save = $usuario->save();
                // var_dump($usuario);


                if ($save) {
                    $_SESSION['register'] = "complete";
                    // Cookie o por GET
                    $_SESSION['email'] = $usuario->getEmail();
                    header("Location:" . base_url . 'user/login');
                    exit();
                } else {
                    $_SESSION['register'] = "failed";

                }
            } else {
                $_SESSION['register'] = "failed";
            }
        } else {
            $_SESSION['register'] = "failed";
            // Control de errores 
        }
        header("Location:" . base_url . 'user/register');
        
    }

    public function loginUser()
    {
        // Si hay datos por post
        if (isset($_POST)) {
            // Identificar al usuario
            // Consulta a la base de datos
            //Creamos un objeto del modelo
            $usuario = new User();
            // Seteamos el email y la pasword al objeto
            $usuario->setEmail($_POST['email']);
            $usuario->setPassword($_POST['password']);

            $identity = $usuario->login();



            //Si llega identity y es un objeto
            if ($identity && is_object($identity)) {
                // Creamos la sesion donde va la identidad del usuario
                $_SESSION['identity'] = $identity;
                // Si el rol es admin, creamos una sesion para el admin como true
                if ($identity->rol == 'admin') {
                    $_SESSION['admin'] = true;
                }
            } else {
                $_SESSION['error_login'] = 'Credenciales incorrectas';
                header("Location:" . base_url . 'user/login');
                exit();
            }
        }
        // Redirigimos a la base_url siempre
        header("Location:" . base_url . 'dashboard');
    }

    public function logout()
    {
        if (isset($_SESSION['identity'])) {
            unset($_SESSION['identity']);
        }
        if (isset($_SESSION['admin'])) {
            unset($_SESSION['admin']);
        }
        header("Location:" . base_url . 'user/login');
    }
}
