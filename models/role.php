<?php

class Role
{
    private int $id;
    private string $name;
    private ?PDO $db;

    public function __construct()
    {
        try {
            $this->db = Database::getInstance();
        } catch (PDOException $e) {
            throw new RuntimeException("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }
    public static function createById(int $id): self
    {
        $instance = new self();

        $stmt = $instance->db->prepare("SELECT * FROM roles WHERE id = :id");
        $stmt->execute([':id' => $id]);

        $role = $stmt->fetch(PDO::FETCH_OBJ);

        if (!$role) {
            throw new RuntimeException("Rol con ID $id no encontrado");
        }
        $instance->id = $role->id;
        $instance->name = $role->name;

        return $instance;
    }

    public static function createByName(string $name): self
    {

        $instance = new self();

        $stmt = $instance->db->prepare("SELECT * FROM roles WHERE name = :name");
        $stmt->execute([':name' => $name]);

        $role = $stmt->fetch(PDO::FETCH_OBJ);

        if (!$role) {
            throw new RuntimeException("Role con nombre $name no encontrado");
        }

        $instance->id = $role->id;
        $instance->name = $role->name;

        return $instance;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    // Método para obtener todos los roles
    public function getRoles(): array
    {
        $sql = "SELECT * FROM roles";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    function __destruct()
    {
        $this->db = null;
    }
}
