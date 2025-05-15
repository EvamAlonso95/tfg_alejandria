<?php

class BookController extends BaseController
{
	public function index()
	{
		$this->_checkLogged();
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
		foreach ($recommended as $rec) { 
			$recommendedBooks[] = Book::createById($rec['id']);
		}

		// $bookUser = BookUser::createById($_SESSION['identity']->id); //Cuidado con esto porque $_SESSION identity es false
		// var_dump($recommendedBooks);
		require_once 'views/book/bookInfo.php';
	}
}
