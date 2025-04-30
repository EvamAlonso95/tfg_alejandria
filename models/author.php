<?php
class Author
{
    private ?int $id = null;
    private ?string $name = null;
    private ?string $biography = null;
    private ?string $profileImage = null;
    // el id del usuario si lo tuviera
    private ?User $user = null;
    private ?PDO $db;

    public static function createById(int $id): self
    {
        $author = new self();

        $stmt = $author->db->prepare("SELECT * FROM authors WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_OBJ);

        $author->setId($data->id);
        $author->setName($data->name);
        $author->setBiography($data->biography);
        $author->setProfileImage($data->profile_img);
        if ($data->id_user) {
            $author->setUser(User::createById($data->id_user));
        }
        return $author;
    }

    public static function createByName(string $name): self
    {
        $author = new self();

        $stmt = $author->db->prepare("SELECT * FROM authors WHERE name = :name");
        $stmt->execute([':name' => $name]);
        $data = $stmt->fetch(PDO::FETCH_OBJ);

        $author->setId($data->id);
        $author->setName($data->name);
        $author->setBiography($data->biography);
        $author->setProfileImage($data->profile_img);
        if ($data->id_user) {
            $author->setUser(User::createById($data->id_user));
        }
        return $author;
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
    public function getBiography(): ?string
    {
        return $this->biography;
    }
    public function getProfileImage(): ?string
    {
        return $this->profileImage;
    }
    //TODO Revisar
    public function getUser(): User
    {
        return $this->user;
    }
    // -- SETTERS --    
    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function setBiography(string $biography): void
    {
        $this->biography = $biography;
    }
    public function setProfileImage(string $profileImage): void
    {
        $this->profileImage = $profileImage;
    }

    //TODO Revisar
    public function setUser(User $user): void
    {
        $this->user = $user;
    }
    // -- METODOS --
    //TODO Revisar
    public function getOneAuthor(): object
    {
        $stmt = $this->db->prepare("SELECT * FROM authors WHERE id = :id");
        var_dump($this->id);
        $stmt->execute([':id' => $this->id]);
        $data = $stmt->fetch(PDO::FETCH_OBJ);
        var_dump($data);
        return $data;
    }
    public static function getAllAuthors(): array
    {
        $temp = Database::connect();
        $stmt = $temp->query("SELECT * FROM authors");
        $stmt->execute();
        $dataAuthor = $stmt->fetchAll(PDO::FETCH_OBJ);
        $authors = [];
        foreach ($dataAuthor as $author) {
            array_push($authors, self::createById($author->id));
        }
        $temp = null; // Cerrar la conexión a la base de datos
        return $authors;
    }

    function __destruct()
    {
        $this->db = null;
    }
}
