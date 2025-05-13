<?php

class BookController extends BaseController
{
    public function index()
    {
        $book = Book::createById($_GET['bookId']);
        $client = new QdrantClient();
        $vector = $client->getVectorId('books', $book->getId());
        $filter = [
            'must_not' => [
                'key'   => 'id',
                'match' => ['value' => $book->getId()]
            ]
        ];

        $recommended = $client->search('books', $vector, 3, $filter)['result'];
        $recommendedBooks = [];
        foreach ($recommended as $book) {
            $recommendedBooks[] = Book::createById($book['id']);
        }
        // var_dump($recommendedBooks);
        require_once 'views/book/bookInfo.php';
    }
}
