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

    public function __construct()
    {
        try {
            $this->db = Database::connect();
        } catch (PDOException $e) {
            throw new RuntimeException("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }

    // GETTERS
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

    // SETTERS con validación

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
        $email = trim($email);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Email inválido: " . $email);
        }
        $this->email = $email;
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


    public function setRole(string $nameRole): void
    {
        $role = Role::createByName($nameRole);
        $this->role = $role;
    }

    // MÉTODOS DE BASE DE DATOS
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

    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }


    public function login()
    {
        $result = false;
        $email = $this->email;
        $password = $this->password;


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
    // public function login(): bool
    // {

    //     $result = false;
    //     if (empty($this->email) || empty($this->password)) {
    //         return $result;
    //     }


    //     try {
    //         $stmt = $this->db->prepare(
    //             "SELECT * FROM users WHERE email = :email"
    //         );

    //         $stmt->execute([':email' => $this->email]);
    //         $user = $stmt->fetch(PDO::FETCH_OBJ);
    //         // var_dump($user);
    //         // die();
    //         if ($user && password_verify($this->password, $user->password)) {
    //             // var_dump(password_verify($this->password, $user->password));
    //             // die();
    //             $this->id = $user->id;
    //             $this->name = $user->name;
    //             $this->email = $user->email;
    //             $this->role = $user->role;
    //             $this->biography = $user->biography;
    //             $this->profileImage = $user->profile_image;
    //             return true;
    //         }

    //         return false;
    //     } catch (PDOException $e) {
    //         error_log("Error en login: " . $e->getMessage());
    //         return false;
    //     }
    // }

    // MÉTODO PARA DEBUG
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
