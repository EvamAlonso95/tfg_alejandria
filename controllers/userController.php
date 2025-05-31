<?php

class UserController extends BaseController
{

	public function index()
	{
		$this->_checkLogged();
		Utils::redirect('user/profile');
	}

	public function register()
	{
		if (Utils::isLogged()) {
			Utils::redirect();
		}
		$this->showFooter = false;
		$this->showUserMenu = false;
		$this->title = 'Registro de usuario';
		require_once 'views/landing/register.php';
	}

	public function login()
	{
		if (Utils::isLogged()) {
			Utils::redirect();
		}
		$this->showFooter = false;
		$this->showUserMenu = false;
		$this->title = 'Iniciar sesión';
		require_once 'views/landing/login.php';
	}

	public function profile()
	{
		$this->_checkLogged();
		$user =  User::createById($_SESSION['identity']->id);
		$this->title = 'Perfil de usuario - ' . $user->getName();
		// Obtener los libros del usuario
		$booksReading = BookUser::getBooksByUserIdAndStatus($user->getId(), 'reading');
		$booksRead = BookUser::getBooksByUserIdAndStatus($user->getId(), 'read');
		$booksWantToRead = BookUser::getBooksByUserIdAndStatus($user->getId(), 'want to read');
		require_once 'views/profiles/userProfile.php';
	}

	// Método para ir a la vista editar guardando el id
	public function edit()
	{

		$this->_checkLogged();
		$user =  User::createById($_SESSION['identity']->id);
		$this->title = 'Editar perfil - ' . $user->getName();
		require_once 'views/profiles/editProfile.php';
	}


	// Método para guardar el usuario
	public function save()
	{
		if (!isset($_POST)) {
			$_SESSION['register'] = "failed";
			return Utils::redirect('user/register');
		}

		$name = $_POST['username'] ?? false;
		$email = $_POST['email'] ?? false;
		$password = $_POST['password'] ?? false;
		$confirmPassword = $_POST['confirmPassword'] ?? false;
		$role = $_POST['role'] ?? false;

		if ($password !== $confirmPassword) {
			$_SESSION['error_password'] = "Error, las contraseñas no coinciden";
			return Utils::redirect('user/register');
		}

		if ($name && $email && $password && $role) {
			$user = new User();
			$user->setName($name);
			$user->setEmail($email);
			$user->setPassword($password);
			$user->setRole($role);
			$user->setProfileImage('uploads/images/default.jpg');
			$user->setBiography('');

			if ($user->save()) {
				$_SESSION['register'] = "complete";
				$_SESSION['email'] = $user->getEmail();
				return Utils::redirect('user/login');
			}
		}

		$_SESSION['register'] = "failed";
		return Utils::redirect('user/register');
	}


	// Método para logear al usuario
	public function loginUser()
	{

		// Verificar si hay datos POST
		if (empty($_POST['email']) || empty($_POST['password'])) {
			$_SESSION['error_login'] = 'Credenciales no proporcionadas';
			Utils::redirect('user/login');
		}

		// Crear objeto usuario y setear credenciales
		$user = new User();
		$user->setEmail(trim($_POST['email']));
		$user->setPassword($_POST['password']);


		$identity = $user->login();

		if (!$identity || !is_object($identity)) {
			$_SESSION['error_login'] = 'Credenciales incorrectas';
			Utils::redirect('user/login');
		}

		// Limpiar sesiones anteriores
		unset($_SESSION['admin'], $_SESSION['author'], $_SESSION['reader'], $_SESSION['role'], $_SESSION['error_login']);

		// Guardar el usuario
		$_SESSION['identity'] = $identity;

		$role = new Role();
		// Obtener roles del usuario 
		$roles = $role->getRoles($identity->id); // Pasar el ID del usuario logueado
		$user_id_role = $identity->id_role;

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
		Utils::redirect();
	}

	// Método para editar el usuario
	public function editUser()
	{
		$this->_checkLogged();
		if (empty($_POST)) {
			Utils::redirect('user/edit');
		}

		$user = User::createById($_SESSION['identity']->id);
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

		Utils::redirect('user/profile');
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
		Utils::redirect();
	}

	//Método para cambiar el libro de estado en mi perfil
	public function changeBookStatus()
	{
		if (isset($_GET['bookId']) && isset($_GET['status'])) {
			$bookUser = new BookUser();
			$bookUser->setBook(Book::createById($_GET['bookId']));
			$bookUser->setUser(User::createById($_SESSION['identity']->id));
			$bookUser->setStatus($_GET['status']);
			$bookUser->updateStatus();
		}
		Utils::redirect('user/profile');
	}
}
