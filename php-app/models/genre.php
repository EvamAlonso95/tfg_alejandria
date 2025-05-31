<?php

class Genre
{
	private int $id;
	private string $name;

	public function __construct() {}

	public static function createById(int $id): self
	{
		$instance = new self();

		$stmt = Database::getInstance()->prepare("SELECT * FROM genres WHERE id = :id");
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

		$stmt = Database::getInstance()->prepare("SELECT * FROM genres WHERE name = :name");
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

	// Setters
	public function setId(int $id): void
	{
		$this->id = $id;
	}

	public function setName(string $name): void
	{
		$this->name = $name;
	}

	//Método para obtener todos los géneros

	public static function getAllGenres(): array
	{
		$temp = new Genre();
		$sql = "SELECT id FROM genres";
		$stmt = Database::getInstance()->prepare($sql);
		$stmt->execute();
		$dataGenres = $stmt->fetchAll(PDO::FETCH_OBJ);
		$genres = [];

		// Crear un array de objetos Gener a partir de los IDs obtenidos
		foreach ($dataGenres as $genre) {
			array_push($genres, self::createById($genre->id));
		}
		return $genres;
	}


	// Método para guardar un género
	public function save(): bool
	{
		$stmt = Database::getInstance()->prepare("INSERT INTO genres (name) VALUES (:name)");
		$stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
		return $stmt->execute();
	}

	// Método para actualizar un género
	public function edit(): bool
	{
		$stmt = Database::getInstance()->prepare("UPDATE genres SET name = :name WHERE id = :id");
		$stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
		$stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
		return $stmt->execute();
	}

	// Método para eliminar

	public function delete(): bool
	{
		$stmt = Database::getInstance()->prepare("DELETE FROM genres WHERE id = :id");
		$stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
		return $stmt->execute();
	}

	public function existsByName(): bool
	{
		$stmt = Database::getInstance()->prepare("SELECT COUNT(*) FROM genres WHERE name = :name");
		$stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetchColumn() > 0;
	}

	static function getTotal(): int
	{
		$temp = Database::getInstance();
		$sql = "SELECT COUNT(*) FROM genres";
		$stmt = $temp->prepare($sql);
		$stmt->execute();
		return (int)$stmt->fetchColumn();
	}
}
