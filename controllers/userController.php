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

    public function profile()
    {
        require_once 'views/profiles/userProfile.php';
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
        // Verificar si hay datos POST
        if (!isset($_POST['email']) || !isset($_POST['password'])) {
            $_SESSION['error_login'] = 'Credenciales no proporcionadas';
            header("Location:" . base_url . 'user/login');
            exit();
        }

        // Crear objeto usuario y setear credenciales
        $usuario = new User();
        $usuario->setEmail(trim($_POST['email']));
        $usuario->setPassword($_POST['password']); // Asegúrate de que el modelo hashea la contraseña

        // Intentar login
        $identity = $usuario->login();

        // Si el login falla
        if (!$identity || !is_object($identity)) {
            $_SESSION['error_login'] = 'Credenciales incorrectas';
            header("Location:" . base_url . 'user/login');
            exit();
        }

        // Iniciar sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Limpiar sesiones anteriores
        unset($_SESSION['admin'], $_SESSION['author'], $_SESSION['reader'], $_SESSION['role'], $_SESSION['error_login']);

        // Guardar identidad del usuario
        $_SESSION['identity'] = $identity;

        // Obtener roles del usuario (asumo que getRoles() devuelve los roles del usuario logueado)
        $roles = $usuario->getRoles($identity->id); // Pasar el ID del usuario logueado

        $user_id_role = $identity->id_role;

        var_dump($roles);
        var_dump($user_id_role);

        foreach ($roles as $rol) {
            if (isset($rol['id']) && $rol['id'] == $user_id_role) {
                switch (strtolower($rol['name'])) {
                    case 'admin':
                        $_SESSION['admin'] = true;
                        $_SESSION['role'] = 'admin';
                        break;
                    case 'author':
                        $_SESSION['author'] = true;
                        $_SESSION['role'] = 'author';
                        break;
                    case 'reader':
                        $_SESSION['reader'] = true;
                        $_SESSION['role'] = 'reader';
                        break;
                }
            }
        }

        // Redirigir al dashboard
        header("Location:" . base_url . 'dashboard');
        exit();
    }



    // Método para cerrar sesión

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
