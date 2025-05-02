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
    public function getUser(): ?User
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

    //Método para guardar un autor

    public function save(): bool
    {
        $sql = "INSERT INTO authors (name, biography, profile_img,id_user) VALUES (:name, :biography, :profile_img, :id_user)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':name', $this->name);
        $stmt->bindValue(':biography', $this->biography);
        $stmt->bindValue(':profile_img', $this->profileImage);
        $stmt->bindValue(':id_user', $this->user ? $this->user->getId() : null); // Si el autor tiene un usuario, se guarda su id, si no, se guarda null


        return $stmt->execute();
    }

    //Método para actualizar un autor
    public function edit(): bool
    {
        $sql = "UPDATE authors SET name = :name, biography = :biography, profile_img = :profile_img , id_user = :id_user WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':name', $this->name);
        $stmt->bindValue(':biography', $this->biography);
        $stmt->bindValue(':profile_img', $this->profileImage);
        $stmt->bindValue(':id', $this->id);
        $stmt->bindValue(':id_user', $this->user ? $this->user->getId() : null); // Si el autor tiene un usuario, se guarda su id, si no, se guarda null
        return $stmt->execute();
    }

    //Método para eliminar un autor
    public function delete(): bool
    {
        $sql = "DELETE FROM authors WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $this->id);
        if($this->user){
            $this->user->setRole('reader'); // Cambiar el rol del usuario a 1 (Usuario normal)
            $this->user->editUser(); // Actualizar el usuario en la base de datos
        }
        return $stmt->execute();
    }

    function __destruct()
    {
        $this->db = null;
    }
}
