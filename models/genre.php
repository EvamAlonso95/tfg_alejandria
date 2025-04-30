<?php

class Genre
{
    private int $id;
    private string $name;
    private ?PDO $db;

    public function __construct()
    {
        try {
            $this->db = Database::connect();
        } catch (PDOException $e) {
            throw new RuntimeException("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }

    public static function createById(int $id): self
    {
        $instance = new self();

        $stmt = $instance->db->prepare("SELECT * FROM genres WHERE id = :id");
        $stmt->execute([':id' => $id]);

        $genre = $stmt->fetch(PDO::FETCH_OBJ);

        if (!$genre) {
            throw new RuntimeException("Género con ID $id no encontrado");
        }

        $instance->id = $genre->id;
        $instance->name = $genre->name;

        return $instance;
    }

    public static function createByName(string $name): self
    {
        $instance = new self();

        $stmt = $instance->db->prepare("SELECT * FROM genres WHERE name = :name");
        $stmt->execute([':name' => $name]);
        $genre = $stmt->fetch(PDO::FETCH_OBJ);
        if (!$genre) {
            throw new RuntimeException("Género con nombre $name no encontrado");
        }
        
        $instance->id = $genre->id;
        $instance->name = $genre->name;

        return $instance;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    //Método para obtener todos los géneros
    public static function getAllGenres(): array
    {
        $temp = new Genre();
        $sql = "SELECT id FROM genres";
        $stmt = $temp->db->prepare($sql);
        $stmt->execute();
        $dataGenres = $stmt->fetchAll(PDO::FETCH_OBJ);
        $genres = [];

        // Crear un array de objetos Gener a partir de los IDs obtenidos
        foreach ($dataGenres as $genre) {
            array_push($genres, self::createById($genre->id));
        }
        return $genres;
    }

    function __destruct()
    {
        $this->db = null;
    }
}
