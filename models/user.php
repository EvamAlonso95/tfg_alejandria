<?php
require_once 'role.php';
class User
{
    private ?int $id = null;
    private ?string $name = null;
    private ?string $email = null;
    private ?string $passwordHash = null;
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

    // SETTERS con validación

    // SETTERS MEJORADOS
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
        if (strlen($password) < 6) {
            throw new InvalidArgumentException("La contraseña debe tener al menos 6 caracteres");
        }
        $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
        if ($hash === false) {
            throw new RuntimeException("Error al generar el hash de la contraseña");
        }
        $this->passwordHash = $hash;
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
        $this->validateForSave();

        try {
            $stmt = $this->db->prepare(
                "INSERT INTO users (name, email, password, id_role, biography, profile_img) 
                 VALUES (:name, :email, :password, :role, :biography, :profileImage)"
            );

            $stmt->execute([
                ':name' => $this->name,
                ':email' => $this->email,
                ':password' => $this->passwordHash,
                ':role' => $this->role->getId(),
                ':biography' => $this->biography,
                ':profileImage' => $this->profileImage
            ]);

            $this->id = $this->db->lastInsertId();
            return true;
        } catch (PDOException $e) {
            var_dump("Error al guardar usuario: " . $e->getMessage());
            return false;
        }
    }

    public function login(): bool
    {
        try {
            $stmt = $this->db->prepare(
                "SELECT id, name, email, password, role, biography, profile_image 
                 FROM users WHERE email = :email LIMIT 1"
            );

            $stmt->execute([':email' => $this->email]);
            $user = $stmt->fetch(PDO::FETCH_OBJ);

            if ($user && password_verify($this->passwordHash, $user->password)) {
                $this->id = $user->id;
                $this->name = $user->name;
                $this->email = $user->email;
                $this->role = $user->role;
                $this->biography = $user->biography;
                $this->profileImage = $user->profile_image;
                return true;
            }

            return false;
        } catch (PDOException $e) {
            error_log("Error en login: " . $e->getMessage());
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
            error_log("Error al verificar email: " . $e->getMessage());
            return false;
        }
    }

    // Métodos auxiliares
    private function validateForSave(): void
    {
        if (empty($this->name) || empty($this->email) || empty($this->passwordHash)) {
            throw new RuntimeException("Faltan datos");
        }

        if ($this->emailExists()) {
            throw new RuntimeException("El email ya está registrado");
        }
    }

    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->passwordHash);
    }

    // MÉTODO PARA DEBUG
    public function debugDump(): void
    {
        echo "<pre>DEBUG User Object:\n";
        echo "ID: " . $this->id . "\n";
        echo "Name: " . $this->name . "\n";
        echo "Email: " . $this->email . "\n";
        echo "Password Hash: " . ($this->passwordHash ? '***HASHED***' : 'NULL') . "\n";
        echo "Biography: " . $this->biography . "\n";
        echo "Profile Image: " . $this->profileImage . "\n";
        echo "Role: " . $this->role . "\n";
        echo "</pre>";
    }
}
