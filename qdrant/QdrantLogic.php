<?php
class QdrantLogic
{
    private QdrantClient $qdrantClient;

    public function __construct()
    {
        $this->qdrantClient = new QdrantClient();
    }


    function getDictionary(): array
    {
        $authors = Author::getAllAuthors();
        $genres = Genre::getAllGenres();

        $dictionary = [];
        foreach ($authors as $author) {
            $dictionary[] = $author->getName();
        }
        foreach ($genres as $genre) {
            $dictionary[] = $genre->getName();
        }

        return $dictionary;
    }

    function restart()
    {

        $this->qdrantClient->deleteCollection('books');
        $dictionary = $this->getDictionary();
        $this->qdrantClient->createCollection('books', count($dictionary));
        $this->qdrantClient->uploadVectors('books', $this->createVectors(Book::getAllBooks(), $dictionary));
    }

    public function getQdrantClient()
    {
        return $this->qdrantClient;
    }

    /**
     * Crea los vectores para cada libro
     * @param Book[] $books
     * @param array $dictionary
     * @return array
     */
    function createVectors($books, $dictionary)
    {
        $vectors = [];
        foreach ($books as $book) {
            $authors = '';
            foreach ($book->getAuthors() as $author) {
                $authors .= $author->getName() . ', ';
            }
            $genres = '';
            foreach ($book->getGenres() as $genre) {
                $genres .= $genre->getName() . ', ';
            }
            $vectors[] = [
                'id' => $book->getId(),
                'vector' => $this->createBookVector($book->getId(), $dictionary),
                'payload' => [
                    'id' => $book->getId(),
                    'title' => $book->getTitle(),
                    'author' => $authors,
                    'genre' => $genres,
                ]
            ];
        }
        return $vectors;
    }

    function createBookVector($bookId, $dictionary)
    {
        $book = Book::createById($bookId);

        $vector = array_fill(0, count($dictionary), 0);

        foreach ($book->getAuthors() as $author) {
            $position = array_search($author->getName(), $dictionary);
            if ($position !== false) {
                $vector[$position] = 1;
            }
        }
        foreach ($book->getGenres() as $genre) {
            $position = array_search($genre->getName(), $dictionary);
            if ($position !== false) {
                $vector[$position] = 1;
            }
        }
        return $vector;
    }

    function getBookVector($bookId)
    {
        $qdrant = new QdrantClient();
        $response = $qdrant->getPoints('books', 100);
        foreach ($response['result']['points'] as $point) {
            if ($point['id'] == $bookId) {
                return $point['vector'];
            }
        }
        return null;
    }
    function getUserVector($userId)
    {
        // TODO: Implementar
        return null;
    }
}
