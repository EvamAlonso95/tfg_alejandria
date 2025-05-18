<?php

class BookController extends BaseController
{

	private function _checkBookId()
	{
		if (empty($_GET['bookId'])) {
			Utils::redirect();
		}
	}

	public function index()
	{
		$this->_checkLogged();
		$this->_checkBookId();
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

		$bookUser = false;
		if (BookUser::userHadBook($_SESSION['identity']->id, $book->getId())) {
			$bookUser = BookUser::getBooksByBookIdAndUserId($_SESSION['identity']->id, $book->getId());
		}

		require_once 'views/book/bookInfo.php';
	}

	public function addLibrary()
	{

		$this->_checkLogged();
		$this->_checkBookId();

		$bookUser = new BookUser();
		$bookUser->setBook(Book::createById($_GET['bookId']));
		$bookUser->setUser(User::createById($_SESSION['identity']->id));
		$bookUser->setStatus('want to read');
		$bookUser->save();
		Utils::redirect('/book?bookId=' . $_GET['bookId']);
	}

	public function removeLibrary()
	{

		$this->_checkLogged();
		$this->_checkBookId();

		$bookUser = BookUser::getBooksByBookIdAndUserId($_SESSION['identity']->id,  $_GET['bookId']);
		$bookUser->remove();
		Utils::redirect('/book?bookId=' . $_GET['bookId']);
	}

	public function updateBookStatus()
	{

		$this->_checkLogged();
		$this->_checkBookId();

		if (empty($_GET['status'])) {
			Utils::redirect();
		}
		$bookUser = BookUser::getBooksByBookIdAndUserId($_SESSION['identity']->id,  $_GET['bookId']);
		$bookUser->setStatus($_GET['status']);
		$bookUser->updateStatus();
		Utils::redirect('/book?bookId=' . $_GET['bookId']);
	}
}
