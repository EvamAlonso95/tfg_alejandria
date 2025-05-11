<?php

class BookUser
{
    private Book $book;
    private ?int $id_book;
    private User $id_user;
    private ?string $status;
    private ?PDO $db;

    public function __construct()
    {
        try {
            $this->db = Database::connect();
        } catch (PDOException $e) {
            throw new RuntimeException("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }


    public function getBook(): Book
    {
        return $this->book;
    }

    public function setBook(Book $book): void
    {
        $this->book = $book;
    }
    public function getIdBook(): ?int
    {
        return $this->id_book;
    }
    public function setIdBook(?int $id_book): void
    {
        $this->id_book = $id_book;
    }
    public function getUser(): User
    {
        return $this->id_user;
    }
    public function setUser(User $id_user): void
    {
        $this->id_user = $id_user;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }



    // Método para obtener libros por ID de usuario
    /**
     * @return BookUser[]
     */

    public static function createById(int $id): self
    {
        $bookUser = new self();

        $stmt = $bookUser->db->prepare(
            "SELECT 
                 books_users_saved.status
             FROM books_users_saved 
             WHERE books_users_saved.id_book = :id"
        );
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_OBJ);

        $bookUser->setBook(Book::createById($id));

        $bookUser->setStatus($data->status);
        return $bookUser;
    }

    public static function getBooksByUserId(int $userId): array
    {
        $temp = Database::connect();
        $stmt = $temp->prepare(
            "SELECT 
                 books.id AS book_id,
                 books_users_saved.status
             FROM books 
             JOIN books_users_saved ON books.id = books_users_saved.id_book
             WHERE books_users_saved.id_user = :user_id"
        );

        $stmt->execute([':user_id' => $userId]);
        $dataBooks = $stmt->fetchAll(PDO::FETCH_OBJ);
        $books = [];
        foreach ($dataBooks as $book) {

            array_push($books, self::createById($book->book_id));
        }
        $temp = null; // Cerrar la conexión a la base de datos
        return $books;
    }

    public static function getBooksByUserIdAndStatus(int $userId, string $status): array
    {
        $temp = Database::connect();
        $stmt = $temp->prepare(
            "SELECT 
                 books.id AS book_id
             FROM books 
             JOIN books_users_saved ON books.id = books_users_saved.id_book
             WHERE books_users_saved.id_user = :user_id AND books_users_saved.status = :status"
        );

        $stmt->execute([':user_id' => $userId, ':status' => $status]);
        $dataBooks = $stmt->fetchAll(PDO::FETCH_OBJ);
        $books = [];
        foreach ($dataBooks as $book) {
            array_push($books, self::createById($book->book_id));
        }
        $temp = null; // Cerrar la conexión a la base de datos
        return $books;
    }


    //TODO: Revisar los parámetros de la función
    public function saveBookUser(): bool
    {
        $temp = Database::connect();

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
        return $insertStmt->execute([
            ':book_id' => $this->getBook()->getId(),
            ':user_id' => $this->getUser()->getId(),
            ':status' => $this->getStatus()
        ]);
    }

    //Método para cambiar el estado de un libro
    public function updateStatus(): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE books_users_saved 
             SET status = :status 
             WHERE id_book = :book_id AND id_user = :user_id"
        );
        return $stmt->execute([
            ':status' => $this->getStatus(),
            ':book_id' => $this->getBook()->getId(),
            ':user_id' => $this->getUser()->getId()
        ]);
    }


    function __destruct()
    {
        $this->db = null;
    }
}
