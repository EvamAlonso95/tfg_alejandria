<?php

class BookUser
{
    private Book $book;
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

    function __destruct()
    {
        $this->db = null;
    }
}
