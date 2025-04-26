<?php
require_once 'role.php';
class User
{
    private ?int $id = null;
    private ?string $name = null;
    private ?string $email = null;
    private ?string $password = null;
    private ?string $biography = null;
    private ?string $profileImage = null;
    private Role $role;
    private PDO $db;

    public static function createById(int $id)
    {
        $user = new User();
        $user->setId($id);

        $data =  $user->getOneUser();

        $user->setName($data->name);
        $user->setEmail($data->email);
        $user->setBiography($data->biography);
        $user->setProfileImage($data->profile_img);
        $user->setRole($data->id_role);
        $user->setPassword($data->password);
        return $user;
    }

    public function __construct()
    {
        try {
            $this->db = Database::connect();
        } catch (PDOException $e) {
            throw new RuntimeException("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }

    // -- GETTERS --
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function getProfileImage(): ?string
    {
        return $this->profileImage;
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

            $stmt = $this->db->prepare(
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

            $this->id = $this->db->lastInsertId();
            return true;
        } catch (InvalidArgumentException $e) {
            // Captura específicamente errores de validación
            $_SESSION['register'] = "failed";
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
            $stmt = $this->db->prepare(
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

        //TODO:CONTRASEÑA TAMBIEN
        // Comprobar si existe el usuario usando parámetros preparados  
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($sql);
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

    // Método para obtener un usuario por su ID
    public function getOneUser()
    {
        $sql = "SELECT * FROM users WHERE id = :id"; // Usamos un placeholder fijo ":id"
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // Método para obtener todos los usuarios
    /**
     * @return User[]
     */
    public static function getAllUsers(): array
    {
        $temp = new User();
        $sql = "SELECT id FROM users";
        $stmt = $temp->db->prepare($sql);
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
            $stmt = $this->db->prepare(
                "UPDATE users SET name = :name, email = :email, biography = :biography, profile_img = :profileImage, id_role = :role WHERE id = :id"
            );

            $stmt->execute([
                ':name' => $this->name,
                ':email' => $this->email,
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
            $stmt = $this->db->prepare(
                "DELETE FROM users WHERE id = :id"
            );
            $stmt->execute([':id' => $this->id]);
            return true;
        } catch (PDOException $e) {
            error_log("Error al eliminar usuario: " . $e->getMessage());
            return false;
        }
    }




    // Método para debugear
    public function debugDump(): void
    {
        echo "<pre>DEBUG User Object:\n";
        echo "ID: " . $this->id . "\n";
        echo "Name: " . $this->name . "\n";
        echo "Email: " . $this->email . "\n";
        echo "Password Hash: " . ($this->password ? '***HASHED***' : 'NULL') . "\n";
        echo "Biography: " . $this->biography . "\n";
        echo "Profile Image: " . $this->profileImage . "\n";
        echo "Role: " . $this->role . "\n";
        echo "</pre>";
    }
}
