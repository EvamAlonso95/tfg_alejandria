<?php
// Iniciamos la sesión para poder usarla en el controlador frontal
require_once './models/user.php';

class UserController extends BaseController
{

    public function index()
    {
        echo 'Hola soy un usuario';
    }

    public function register()
    {
        $this->showFooter = false;
        $this->showUserMenu = false;
        require_once 'views/landing/register.php';
    }

    public function login()
    {
        $this->showFooter = false;
        $this->showUserMenu = false;
        require_once 'views/landing/login.php';
    }

    public function profile()
    {
        if (isset($_SESSION['identity'])) {
            $user =  User::createById($_SESSION['identity']->id);
            $title = 'Perfil de usuario - ' . $user->getName();


            require_once 'views/profiles/userProfile.php';
        }
    }

    // Método para ir a la vista editar guardando el id
    public function edit()
    {

        if (isset($_SESSION['identity'])) {
            $user =  User::createById($_SESSION['identity']->id);
            require_once 'views/profiles/editProfile.php';
        }
    }


    // Método para guardar el usuario
    public function save()
    {
        if (isset($_POST)) {

            // Si existe el post, será el valor de la variable, sino será false
            $name = isset($_POST['username']) ? $_POST['username'] : false;
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
            if ($name  && $email && $password && $role) {
                $user = new User();
                $user->setName($name);
                $user->setEmail($email);
                $user->setPassword($password);
                $user->setRole($role);
                $user->setProfileImage('uploads/images/default.jpg'); // Imagen por defecto
                $user->setBiography('');

                $save = $user->save();
                // var_dump($usuario);


                if ($save) {
                    $_SESSION['register'] = "complete";
                    // Cookie o por GET
                    $_SESSION['email'] = $user->getEmail();
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

    // Método para logear al usuario
    public function loginUser()
    {
        // Verificar si hay datos POST
        if (!isset($_POST['email']) || !isset($_POST['password'])) {
            $_SESSION['error_login'] = 'Credenciales no proporcionadas';
            header("Location:" . base_url . 'user/login');
            exit();
        }

        // Crear objeto usuario y setear credenciales
        $user = new User();
        $user->setEmail(trim($_POST['email']));
        $user->setPassword($_POST['password']); // Asegúrate de que el modelo hashea la contraseña

        // Intentar login
        $identity = $user->login();

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

        $role = new Role();
        // Obtener roles del usuario (asumo que getRoles() devuelve los roles del usuario logueado)
        $roles = $role->getRoles($identity->id); // Pasar el ID del usuario logueado

        $user_id_role = $identity->id_role;

        // var_dump($roles);
        // var_dump($user_id_role);

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

    // Método para editar el usuario
    public function editUser()
    {
        var_dump($_POST);

        if (isset($_POST)) {
            $user = new User();
            $user->setId($_SESSION['identity']->id);
            $user->setName($_POST['name']);
            $user->setEmail($_POST['email']);
            $user->setBiography($_POST['biography']);

            // Comprobar si se ha subido una imagen
            if (isset($_FILES['profileImg']) && $_FILES['profileImg']['error'] == 0) {
                $file = $_FILES['profileImg'];
                $fileName = $file['name'];
                $filePath = 'uploads/images/' . $fileName;
                move_uploaded_file($file['tmp_name'], $filePath);
                $user->setProfileImage($filePath);
            }

            // Guardar los cambios
            $user->editUser();

            // Actualizar la sesión con los nuevos datos
            $_SESSION['identity']->name = $_POST['name'];
            $_SESSION['identity']->email = $_POST['email'];
            $_SESSION['identity']->biography = $_POST['biography'];
            if (isset($filePath)) {
                $_SESSION['identity']->profile_img = $filePath;
            }

            header("Location:" . base_url . 'user/profile');
        } else {
            header("Location:" . base_url . 'user/edit');
        }
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
        header("Location:" . base_url);
    }
}
