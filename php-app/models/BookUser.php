<?php

class BookUser
{
	private Book $book;
	private ?int $bookUserId;
	private User $user;
	private ?BookUserStatus $status;

	public function __construct() {}

	public function getBook(): Book
	{
		return $this->book;
	}

	public function setBook(Book $book): void
	{
		$this->book = $book;
	}
	public function getBookUserId(): ?int
	{
		return Utils::escapeData($this->bookUserId);
	}
	public function setBookUserId(?int $bookUserId): void
	{
		$this->bookUserId = $bookUserId;
	}
	public function getUser(): User
	{
		return $this->user;
	}
	public function setUser(User $user): void
	{
		$this->user = $user;
	}

	public function getStatus(): ?BookUserStatus
	{
		return $this->status;
	}
	public function setStatus(?BookUserStatus $status): void
	{
		$this->status = $status;
	}

	// Método para obtener libros por ID de usuario
	/**
	 * @return BookUser
	 */
	public static function createByBookUserId(int $id): self
	{
		$bookUser = new self();

		$stmt = Database::getInstance()->prepare(
			"SELECT 
                 *
             FROM books_users_saved 
             WHERE books_users_saved.id= :id"
		);
		$stmt->execute([':id' => $id]);
		$data = $stmt->fetch(PDO::FETCH_OBJ);
		if (!$data) {
			throw new Exception("BookUser no encontrado con ID: $id");
		}
		$bookUser->setBook(Book::createById($data->id_book));
		$bookUser->setUser(User::createById($data->id_user));
		$bookUser->setBookUserId($data->id);
		$bookUser->setStatus(BookUserStatus::from($data->status));
		return $bookUser;
	}

	/**
	 * @return BookUser[]
	 */
	public static function getBooksByUserId(int $userId): array
	{
		$temp = Database::getInstance();
		$stmt = $temp->prepare(
			"SELECT 
                 	books_users_saved.id AS id
             FROM books 
             JOIN books_users_saved ON books.id = books_users_saved.id_book
             WHERE books_users_saved.id_user = :user_id"
		);

		$stmt->execute([':user_id' => $userId]);
		$dataBooks = $stmt->fetchAll(PDO::FETCH_OBJ);
		$books = [];
		foreach ($dataBooks as $book) {
			array_push($books, self::createByBookUserId($book->id));
		}
		$temp = null; // Cerrar la conexión a la base de datos
		return $books;
	}

	/**
	 * @return BookUser[]
	 */
	public static function getBooksByUserIdAndStatus(int $userId, BookUserStatus $status): array
	{
		$temp = Database::getInstance();
		$stmt = $temp->prepare(
			"SELECT 
                 books_users_saved.id AS id
             FROM books 
             JOIN books_users_saved ON books.id = books_users_saved.id_book
             WHERE books_users_saved.id_user = :user_id AND books_users_saved.status = :status"
		);

		$stmt->execute([':user_id' => $userId, ':status' => $status->value]);
		$dataBooks = $stmt->fetchAll(PDO::FETCH_OBJ);
		$books = [];
		foreach ($dataBooks as $book) {
			array_push($books, self::createByBookUserId($book->id));
		}
		$temp = null; // Cerrar la conexión a la base de datos
		return $books;
	}

	/**
	 * @return BookUser
	 */

	public static function getBooksByBookIdAndUserId(int $userId, int $bookId): self
	{
		$temp = Database::getInstance();
		$stmt = $temp->prepare(
			"SELECT 
             		books_users_saved.id AS id
             FROM books 
             JOIN books_users_saved ON books.id = books_users_saved.id_book
             WHERE books_users_saved.id_user = :user_id AND books_users_saved.id_book = :book_id"
		);

		$stmt->execute([':user_id' => $userId, ':book_id' => $bookId]);
		$data = $stmt->fetch(PDO::FETCH_OBJ);

		return self::createByBookUserId($data->id);
	}

	public static function userHadBook(int $userId, int $bookId): bool
	{
		$temp = Database::getInstance();
		$stmt = $temp->prepare(
			"SELECT 
                1
             FROM books 
             JOIN books_users_saved ON books.id = books_users_saved.id_book
             WHERE books_users_saved.id_user = :user_id AND books_users_saved.id_book = :book_id"
		);

		$stmt->execute([':user_id' => $userId, ':book_id' => $bookId]);
		return $stmt->fetch(PDO::FETCH_OBJ) !== false;
	}

	public function save(): bool
	{
		$temp = Database::getInstance();

		// Verificar si ya existe la relación libro-usuario
		$checkStmt = $temp->prepare("
        SELECT COUNT(*) FROM books_users_saved 
        WHERE id_book = :book_id AND id_user = :user_id");

		$checkStmt->execute([
			':book_id' => $this->getBook()->getId(),
			':user_id' => $this->getUser()->getId()
		]);

		// Si ya existe, no insertar
		if ($checkStmt->fetchColumn() > 0) {
			return false;
		}

		// Si no existe, insertar
		$insertStmt = $temp->prepare("
        INSERT INTO books_users_saved (id_book, id_user, status) 
        VALUES (:book_id, :user_id, :status)");
		$insertStmt->execute([
			':book_id' => $this->getBook()->getId(),
			':user_id' => $this->getUser()->getId(),
			':status' => $this->getStatus()->value,
		]);
		return true;
	}

	//Método para cambiar el estado de un libro
	public function updateStatus(): bool
	{
		try {
			$stmt = Database::getInstance()->prepare(
				"UPDATE books_users_saved 
             SET status = :status 
             WHERE id_book = :book_id AND id_user = :user_id"
			);

			$stmt->execute([
				':status' => (string) $this->getStatus()->value,
				':book_id' => (int) $this->getBook()->getId(),
				':user_id' => (int) $this->getUser()->getId()
			]);

			return $stmt->rowCount() > 0;
		} catch (PDOException $e) {
			error_log("Error updating status: " . $e->getMessage());
			return false;
		}
	}


	public function remove(): bool
	{
		$stmt = Database::getInstance()->prepare(
			"DELETE FROM books_users_saved WHERE id= :id"
		);

		$stmt->execute([
			':id' => $this->bookUserId,
		]);

		return true;
	}
}
