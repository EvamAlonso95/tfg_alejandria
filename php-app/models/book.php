<?php
class Book
{
	private ?int $id = null;
	private ?string $title = null;
	private ?string $synopsis = null;
	private ?string $cover_img = null;

	/** @var Author[] */
	private array $authors = [];

	/** @var Genre[] */
	private array $genres = [];

	public static function createById(int $id): self
	{
		$sql = "SELECT 
            books.id AS book_id,
            books.title,
            books.synopsis,
            books.cover_img
            FROM books 
            WHERE id = :id";
		$stmt =  Database::getInstance()->prepare($sql);
		$stmt->execute([':id' => $id]);
		$data = $stmt->fetch(PDO::FETCH_OBJ);

		if (!$data) {
			throw new Exception("Libro no encontrado con ID: $id");
		}
		// Obtenemos los géneros y autores del libro
		$book = new self();
		$book->setId($data->book_id);
		$dataGenres = $book->getGenresByBook();
		foreach ($dataGenres as $genreId) {
			// Seteamos el género del libro
			$book->setGenre($genreId->id_genre);
		}
		$book->setTitle($data->title);
		$book->setSynopsis($data->synopsis);
		$book->setCoverImg($data->cover_img);
		// Obtenemos los autores del libro
		$dataAuthor = $book->getAuthorsByBook();
		foreach ($dataAuthor as $authorId) {
			// Seteamos el autor del libro
			$book->setAuthor($authorId->id_author);
		}
		return $book;
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

	public function setSynopsis(string $synopsis): void
	{
		$this->synopsis = $synopsis;
	}

	public function setCoverImg(string $cover_img): void
	{
		$this->cover_img = $cover_img;
	}

	public function setGenre(string | int $nameGenre): void
	{
		if (is_int($nameGenre)) {
			$genre = Genre::createById($nameGenre);
		} else {
			$genre = Genre::createByName($nameGenre);
		}
		// Compruebo si ya existe el género
		foreach ($this->genres as $existing) {
			if ($existing->getId() === $genre->getId()) {
				// Ya estaba añadido: salgo sin añadirlo de nuevo
				return;
			}
		}
		// Si no existía, lo añado
		$this->genres[] = $genre;
	}

	public function setAuthor(string | int $nameAuthor): void
	{

		if (is_int($nameAuthor)) {
			$author = Author::createById($nameAuthor);
		} else {
			$author = Author::createByName($nameAuthor);
		}
		foreach ($this->authors as $existing) {
			if ($existing->getId() === $author->getId()) {
				return;
			}
		}
		$this->authors[] = $author;
	}

	public function cleanAuthors()
	{

		$this->authors = [];
	}

	public function cleanGenres()
	{

		$this->genres = [];
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

	public function getSynopsis(): ?string
	{
		return $this->synopsis;
	}

	public function getCoverImg(): ?string
	{
		return BASE_URL . $this->cover_img;
	}

	/**
	 * @return Genre[]
	 */
	public function getGenres(): array
	{
		return $this->genres;
	}

	/**
	 * @return Author[]
	 */
	public function getAuthors(): array
	{
		return $this->authors;
	}

	// Métodos para obtener libros
	/**
	 * @return Book[]
	 */
	public static function getAllBooks(): array
	{
		$temp = Database::getInstance();
		$sql = "SELECT id FROM books";
		$stmt = $temp->prepare($sql);
		$stmt->execute();
		$dataBooks = $stmt->fetchAll(PDO::FETCH_OBJ);
		$books = [];
		foreach ($dataBooks as $book) {
			array_push($books, self::createById($book->id));
		}
		$temp = null; // Cerrar la conexión a la base de datos
		return $books;
	}



	public function getGenresByBook(): array
	{
		$sql = "SELECT books_genres.id_genre
                FROM books_genres  
                WHERE id_book = :id_book";
		$stmt = Database::getInstance()->prepare($sql);
		$stmt->execute([':id_book' => $this->id]);
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}

	public function getAuthorsByBook(): array
	{
		$sql = "SELECT books_published.id_author
                FROM books_published  
                WHERE id_book = :id_book";
		$stmt = Database::getInstance()->prepare($sql);
		$stmt->execute([':id_book' => $this->id]);
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}

	// Método para guardar un libro en la base de datos
	public function save(): bool
	{

		$insertBook = Database::getInstance()->prepare(
			"INSERT INTO books (title, synopsis, cover_img) 
                VALUES (:title, :synopsis, :cover_img)"
		);
		$insertBook->execute([
			':title' => $this->title,
			':synopsis' => $this->synopsis,
			':cover_img' => $this->cover_img
		]);
		$bookId = Database::getInstance()->lastInsertId();
		$this->setId($bookId);

		foreach ($this->authors as $author) {
			$stmt = Database::getInstance()->prepare(
				"INSERT INTO books_published (id_book, id_author) 
                    VALUES (:id_book, :id_author)"
			);
			$stmt->execute([
				':id_book' => $bookId,
				':id_author' => $author->getId()
			]);
		}

		foreach ($this->genres as $genre) {
			$stmt = Database::getInstance()->prepare(
				"INSERT INTO books_genres (id_book, id_genre) 
                    VALUES (:id_book, :id_genre)"
			);
			$stmt->execute([
				':id_book' => $bookId,
				':id_genre' => $genre->getId()
			]);
		}


		return true;
	}

	// Método para editar un libro en la base de datos
	public function edit(): bool
	{
		$stmt = Database::getInstance()->prepare(
			"UPDATE books 
                SET title = :title, synopsis = :synopsis, cover_img = :cover_img 
                WHERE id = :id"
		);
		$stmt->execute([
			':id' => $this->id,
			':title' => $this->title,
			':synopsis' => $this->synopsis,
			':cover_img' => $this->cover_img
		]);

		// Eliminar autores y géneros existentes
		$stmt = Database::getInstance()->prepare(
			"DELETE FROM books_published WHERE id_book = :id_book"
		);
		$stmt->execute([':id_book' => $this->id]);

		$stmt = Database::getInstance()->prepare(
			"DELETE FROM books_genres WHERE id_book = :id_book"
		);
		$stmt->execute([':id_book' => $this->id]);

		// Insertar nuevos autores y géneros
		foreach ($this->authors as $author) {
			$stmt = Database::getInstance()->prepare(
				"INSERT INTO books_published (id_book, id_author) 
                    VALUES (:id_book, :id_author)"
			);
			$stmt->execute([
				':id_book' => $this->id,
				':id_author' => $author->getId()
			]);
		}

		foreach ($this->genres as $genre) {
			$stmt = Database::getInstance()->prepare(
				"INSERT INTO books_genres (id_book, id_genre) 
                    VALUES (:id_book, :id_genre)"
			);
			$stmt->execute([
				':id_book' => $this->id,
				':id_genre' => $genre->getId()
			]);
		}

		return true;
	}

	//Método que ejecuta una query para eliminar un libro
	public function delete(): bool
	{
		try {
			$stmt = Database::getInstance()->prepare(
				"DELETE FROM books WHERE id = :id"
			);
			$stmt->execute([':id' => $this->id]);

			return true;
		} catch (PDOException $e) {
			error_log("Error al eliminar libro: " . $e->getMessage());
			return false;
		}
	}

	// Método para buscar libros por título o autor
	/**
	 * @return Book[]
	 */
	public static function search(string $search): array
	{
		$temp = Database::getInstance();
		$stmt = $temp->prepare(
			"SELECT books.id AS book_id
             FROM books 
             JOIN books_published ON books.id = books_published.id_book
             JOIN authors ON books_published.id_author = authors.id
             WHERE books.title LIKE :search_title OR authors.name LIKE :search_author"
		);

		$stmt->execute([
			':search_title' => '%' . $search . '%',
			':search_author' => '%' . $search . '%'
		]);

		$dataBooks = $stmt->fetchAll(PDO::FETCH_OBJ);
		$books = [];
		foreach ($dataBooks as $book) {
			array_push($books, self::createById($book->book_id));
		}
		$temp = null; // Cerrar la conexión a la base de datos
		return $books;
	}
}
