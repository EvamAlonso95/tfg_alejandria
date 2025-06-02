<?php
class User
{
	private ?int $id = null;
	private ?string $name = null;
	private ?string $email = null;
	private ?string $password = null;
	private ?string $biography = null;
	private ?string $profileImage = null;
	private Role $role;

	public static function createById(int $id)
	{
		$sql = "SELECT * FROM users WHERE id = :id"; // Usamos un placeholder fijo ":id"
		$stmt = Database::getInstance()->prepare($sql);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$data = $stmt->fetch(PDO::FETCH_OBJ);
		if (!$data) {
			throw new Exception("Usuario no encontrado con ID: $id");
		}

		$user = new User();
		$user->setId($data->id);
		$user->setName($data->name);
		$user->setEmail($data->email);
		$user->setBiography($data->biography);
		$user->setProfileImage($data->profile_img);
		$user->setRole($data->id_role);
		$user->setPassword($data->password);
		return $user;
	}

	public function __construct() {}

	// -- GETTERS --
	public function getId(): ?int
	{
		return Utils::escapeData($this->id);
	}

	public function getName(): ?string
	{
		return Utils::escapeData($this->name);
	}

	public function getEmail(): ?string
	{
		return Utils::escapeData($this->email);
	}

	public function getBiography(): ?string
	{
		return Utils::escapeData($this->biography);
	}

	public function getProfileImage(): ?string
	{
		return BASE_URL . $this->profileImage;
	}

	public function getRole(): Role
	{
		return $this->role;
	}

	public function getpassword(): ?string
	{
		return password_hash($this->password, PASSWORD_BCRYPT, ['cost' => 4]);
	}

	// -- SETTERS --

	public function setId(int $id): void
	{

		$this->id = $id;
	}

	public function setName(string $name): void
	{
		$name = trim($name);
		if (empty($name)) {
			throw new InvalidArgumentException("El nombre no puede estar vacío");
		}
		$this->name = $name;
	}

	public function setEmail(string $email): void
	{
		$this->email = trim($email);
	}

	public function setPassword(string $password): void
	{
		$this->password = $password;
	}

	public function setBiography(string $biography): void
	{
		$this->biography = trim($biography);
	}

	public function setProfileImage(string $profileImage): void
	{
		$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
		$extension = strtolower(pathinfo($profileImage, PATHINFO_EXTENSION));

		if (!in_array($extension, $allowedExtensions)) {
			throw new InvalidArgumentException("Formato de imagen no permitido");
		}

		$this->profileImage = $profileImage;
	}


	public function setRole(string | int $nameRole): void
	{
		if (is_int($nameRole)) {
			$this->role = Role::createById($nameRole);
			return;
		}
		$this->role = Role::createByName($nameRole);;
	}


	// -- MÉTODOS  --
	// Método para guardar el usuario en la base de datos
	public function save(): bool
	{
		try {
			$this->validateForSave();

			$stmt = Database::getInstance()->prepare(
				"INSERT INTO users (name, email, password, id_role, biography, profile_img) 
                VALUES (:name, :email, :password, :role, :biography, :profileImage)"
			);

			$stmt->execute([
				':name' => $this->name,
				':email' => $this->email,
				':password' => $this->getPassword(),
				':role' => $this->role->getId(),
				':biography' => $this->biography,
				':profileImage' => $this->profileImage
			]);

			$this->id = Database::getInstance()->lastInsertId();
			return true;
		} catch (InvalidArgumentException $e) {

			error_log("Error de validación: " . $e->getMessage());
			return false;
		} catch (PDOException $e) {
			error_log("Error al guardar usuario: " . $e->getMessage());
			return false;
		}
	}

	// Método para comprobar si el email ya existe en la base de datos
	public function emailExists(): bool
	{
		try {
			$stmt = Database::getInstance()->prepare(
				"SELECT COUNT(*) FROM users WHERE email = :email"
			);
			$stmt->execute([':email' => $this->email]);
			return $stmt->fetchColumn() > 0;
		} catch (PDOException $e) {
			error_log("Error al comprobar email: " . $e->getMessage());
			throw $e; // Re-lanza la excepción para manejo superior
		}
	}

	// Método para validar los datos antes de guardar
	private function validateForSave(): void
	{
		if (empty($this->name) || empty($this->email) || empty($this->password)) {
			$_SESSION['register'] = "failed";
			throw new InvalidArgumentException("Los campos no pueden estar vacíos");
		}
		if ($this->emailExists()) {
			$_SESSION['register'] = "failed";
			throw new InvalidArgumentException("El email ya existe");
		}
		if (!preg_match('/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[^a-zA-Z\d]).{8,}$/', $this->password)) {
			$_SESSION['register'] = "failed";
			throw new InvalidArgumentException("La contraseña debe tener al menos 8 caracteres, incluir letras, números y un símbolo");
		}
	}


	// Método para verificar la contraseña
	public function verifyPassword(string $password): bool
	{
		return password_verify($password, $this->password);
	}
	// Método para iniciar sesión
	public function login()
	{
		$result = false;
		$email = $this->email;
		$password = $this->password;

		// Comprobar si existe el usuario usando parámetros preparados  
		$sql = "SELECT * FROM users WHERE email = :email ";
		$stmt = Database::getInstance()->prepare($sql);
		$stmt->bindParam(':email', $email);
		$stmt->execute();

		// Obtener el resultado
		$usuario = $stmt->fetch(PDO::FETCH_OBJ);

		if ($usuario) {
			// Verificar la contraseña
			if (password_verify($password, $usuario->password)) {
				$result = $usuario;
			}
		}
		return $result;
	}

	// Método para obtener todos los usuarios
	/**
	 * @return User[]
	 */
	public static function getAllUsers(): array
	{
		$temp = new User();
		$sql = "SELECT id FROM users";
		$stmt = Database::getInstance()->prepare($sql);
		$stmt->execute();
		$dataUsers = $stmt->fetchAll(PDO::FETCH_OBJ);
		$users = [];
		// Crear un array de objetos User a partir de los IDs obtenidos
		foreach ($dataUsers as $user) {
			array_push($users, self::createById($user->id));
		}
		return $users;
	}

	//Método para editar los datos del usuario
	public function editUser()
	{
		try {
			$stmt = Database::getInstance()->prepare(
				"UPDATE users SET name = :name, biography = :biography, profile_img = :profileImage, id_role = :role WHERE id = :id"
			);

			$stmt->execute([
				':name' => $this->name,
				':biography' => $this->biography,
				':profileImage' => $this->profileImage,
				':id' => $this->id,
				':role' => $this->role->getId()
			]);

			return true;
		} catch (PDOException $e) {

			error_log("Error al editar usuario: " . $e->getMessage());
			return false;
		}
	}

	// Método para eliminar un usuario
	public function deleteUser()
	{
		try {
			$stmt = Database::getInstance()->prepare(
				"DELETE FROM users WHERE id = :id"
			);
			$stmt->execute([':id' => $this->id]);
			return true;
		} catch (PDOException $e) {
			error_log("Error al eliminar usuario: " . $e->getMessage());
			return false;
		}
	}
}
