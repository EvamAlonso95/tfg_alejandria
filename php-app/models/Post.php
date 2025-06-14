<?php
class Post
{
	private ?int $id = null;
	private ?string $title = null;
	private ?string $content = null;
	private ?string $post_img = null;
	private ?string $date = null;
	private ?Author $author;

	public static function createById(int $id): self
	{
		// Obtenemos el post de la base de datos
		$sql = "SELECT * FROM posts WHERE id = :id";
		$stmt = Database::getInstance()->prepare($sql);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$data = $stmt->fetch(PDO::FETCH_OBJ);
		if (!$data) {
			throw new Exception("Post no encontrado con ID: $id");
		}
		$post = new self();
		$post->setId($data->id);
		$post->setTitle($data->title);
		$post->setContent($data->content);
		$post->setCoverImg($data->post_img);
		$post->setDate($data->date);

		$post->setAuthor(Author::createById($data->id_author));

		return $post;
	}

	public function __construct() {}

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

	public function setAuthor(Author $author): void
	{
		$this->author = $author;
	}

	//GETTERS
	public function getId(): ?int
	{
		return Utils::escapeData($this->id);
	}
	public function getTitle(): ?string
	{
		return Utils::escapeData($this->title);
	}
	public function getContent(): ?string
	{
		return Utils::escapeData($this->content);
	}
	public function getCoverImg(): ?string
	{
		return BASE_URL . $this->post_img;
	}
	public function getCreatedAt(): ?string
	{
		return Utils::escapeData($this->date);
	}
	public function getAuhtor(): Author
	{
		return $this->author;
	}

	//Métodos

	/**
	 * @return Post[]
	 */
	public static function getAllPosts(): array
	{
		$temp = Database::getInstance();
		$sql = "SELECT * FROM posts ORDER BY date DESC ";
		$stmt = $temp->prepare($sql);
		$stmt->execute();
		$dataPosts = $stmt->fetchAll(PDO::FETCH_OBJ);
		$posts = [];
		foreach ($dataPosts as $dataPost) {
			$posts[] = self::createById($dataPost->id);
		}
		return $posts;
	}

	/**
	 * @return Post[]
	 */
	public static function getAllPostsByAuthor($authorId): array
	{
		$temp = Database::getInstance();
		$sql = "SELECT * FROM posts WHERE id_author = :id_author ORDER BY date DESC";
		$stmt = $temp->prepare($sql);
		$stmt->execute([':id_author' => $authorId]);
		$dataPosts = $stmt->fetchAll(PDO::FETCH_OBJ);
		$posts = [];
		foreach ($dataPosts as $dataPost) {
			$posts[] = self::createById($dataPost->id);
		}
		return $posts;
	}

	// Método para crear un nuevo post
	public function createPost(): bool
	{
		$sql = "INSERT INTO posts (title, content, post_img, date, id_author) VALUES (:title, :content, :post_img, now(), :id_author)";
		$stmt = Database::getInstance()->prepare($sql);
		$stmt->bindParam(':title', $this->title);
		$stmt->bindParam(':content', $this->content);
		$stmt->bindParam(':post_img', $this->post_img);
		$stmt->bindParam(':id_author', $this->author->getId());
		return $stmt->execute();
	}

	// Método para eliminar un post
	public function deletePost(): bool
	{
		$stmt = Database::getInstance()->prepare("DELETE FROM posts WHERE id = :id AND id_author = :id_author");
		$stmt->bindParam(':id_author', $this->author->getId(), PDO::PARAM_INT);
		$stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
		return $stmt->execute();
	}
}
