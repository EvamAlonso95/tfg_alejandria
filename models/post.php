<?php
class Post
{
    private ?int $id = null;
    private ?string $title = null;
    private ?string $content = null;
    private ?string $post_img = null;
    private ?string $date = null;

    private ?User $user;
    private ?PDO $db;


    public static function createById(int $id): self
    {

        $post = new self();
        $post->setId($id);

        // Obtenemos el post de la base de datos
        $data =  $post->getOnePost();
        $post->setTitle($data->title);
        $post->setContent($data->content);
        $post->setCoverImg($data->post_img);
        $post->setDate($data->date);

        $post->setUser(User::createById($data->id_author));

        return $post;
    }

    public function __construct()
    {
        try {
            $this->db = Database::connect();
        } catch (PDOException $e) {
            throw new RuntimeException("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }

    // Setters
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
    public function setContent(string $content): void
    {
        $this->content = $content;
    }
    public function setCoverImg(string $post_img): void
    {
        $this->post_img = $post_img;
    }
    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    //GETTERS
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getTitle(): ?string
    {
        return $this->title;
    }
    public function getContent(): ?string
    {
        return $this->content;
    }
    public function getCoverImg(): ?string
    {
        return $this->post_img;
    }
    public function getCreatedAt(): ?string
    {
        return $this->date;
    }
    public function getAuhtor(): User
    {
        return $this->user;
    }


    //Métodos
    //getPostsByAuthor TODO

    public function getOnePost(): ?object
    {
        $sql = "SELECT * FROM posts WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    //TODO Devolverlo
    public static function getAllPosts(): array
    {
        $temp = Database::connect();
        $sql = "SELECT * FROM posts ORDER BY date DESC";
        $stmt = $temp->prepare($sql);
        $stmt->execute();
        $dataPosts = $stmt->fetchAll(PDO::FETCH_OBJ);
        $posts = [];
        foreach ($dataPosts as $dataPost) {
            $posts[] = Post::createById($dataPost->id);
        }
        return $posts;
    }

    // Método para crear un nuevo post
    public function createPost(): bool
    {
        $sql = "INSERT INTO posts (title, content, post_img, date, id_author) VALUES (:title, :content, :post_img, now(), :id_author)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':content', $this->content);
        $stmt->bindParam(':post_img', $this->post_img);
        $stmt->bindParam(':id_author', $this->user->getId());
        return $stmt->execute();
    }

    // Método para eliminar un post
    public function deletePost(): bool
    {
        $stmt = $this->db->prepare("DELETE FROM posts WHERE id = :id");
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
