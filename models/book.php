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
    private ?PDO $db;

    public static function createById(int $id): self
    {
        $book = new self();
        $book->setId($id);

        $data =  $book->getOneBook();
        $dataGenres = $book->getGenresByBook();
        foreach ($dataGenres as $genreId) {
            $book->setGenre($genreId->id_genre);
        }
        $book->setTitle($data->title);
        $book->setSynopsis($data->synopsis);
        $book->setCoverImg($data->cover_img);
        $dataAuthor = $book->getAuthorsByBook();
        foreach ($dataAuthor as $authorId) {
            $book->setAuthor($authorId->id_author);
        }
        return $book;
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

    public function setSynopsis(string $synopsis): void
    {
        $this->synopsis = $synopsis;
    }

    public function setCoverImg(string $cover_img): void
    {
        $this->cover_img = $cover_img;
    }

    //TODO Revisar

    public function setGenre(string | int $nameGenre): void
    {
        if (is_int($nameGenre)) {
            $this->genres[] = Genre::createById($nameGenre);
            return;
        }
        $this->genres[] = Genre::createByName($nameGenre);;
    }

    public function setAuthor(string | int $nameAuthor): void
    {
        if (is_int($nameAuthor)) {
            $this->authors[] = Author::createById($nameAuthor);
            return;
        }
        $this->authors[] = Author::createByName($nameAuthor);
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
        return $this->cover_img;
    }
    //TODO son tablas relacionadas, no se pueden acceder directamente
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
        $temp = new self();
        $sql = "SELECT id FROM books";
        $stmt = $temp->db->prepare($sql);
        $stmt->execute();
        $dataBooks = $stmt->fetchAll(PDO::FETCH_OBJ);
        $books = [];
        foreach ($dataBooks as $book) {
            array_push($books, self::createById($book->id));
        }

        return $books;
    }

    public function getOneBook(): object
    {
        $sql = "SELECT 
            books.id AS book_id,
            books.title,
            books.synopsis,
            books.cover_img
            FROM books 
            WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $this->id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getGenresByBook(): array
    {
        $sql = "SELECT books_genres.id_genre
                FROM books_genres  
                WHERE id_book = :id_book";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_book' => $this->id]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getAuthorsByBook(): array
    {
        $sql = "SELECT books_published.id_author
                FROM books_published  
                WHERE id_book = :id_book";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_book' => $this->id]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Método para obtener libros por género
    //TODO: REVISAR
    /*
    public function getBooksByGenre(int $id): array
    {
        $sql = "SELECT * FROM books WHERE id_genre = :id_genre";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_genre' => $id]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }*/


    public function save(): bool
    {

        $insertBook = $this->db->prepare(
            "INSERT INTO books (title, synopsis, cover_img) 
                VALUES (:title, :synopsis, :cover_img)"
        );
        $insertBook->execute([
            ':title' => $this->title,
            ':synopsis' => $this->synopsis,
            ':cover_img' => $this->cover_img
        ]);
        $bookId = $this->db->lastInsertId();

        foreach ($this->authors as $author) {
            $stmt = $this->db->prepare(
                "INSERT INTO books_published (id_book, id_author) 
                    VALUES (:id_book, :id_author)"
            );
            $stmt->execute([
                ':id_book' => $bookId,
                ':id_author' => $author->getId()
            ]);
        }

        foreach ($this->genres as $genre) {
            $stmt = $this->db->prepare(
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
    function __destruct()
    {
        $this->db = null;
    }
}
