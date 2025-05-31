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

		try {
			$book = Book::createById($_GET['bookId']);
		} catch (Exception $e) {

			Utils::setToast('Libro no encontrado', false);
			Utils::redirect('error/notFound');
		}
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

		$referer = $_SERVER['HTTP_REFERER'] ?? '';
		Utils::setToast('Libro añadido a tu biblioteca');

		if (strpos($referer, '/recommendedBook') !== false) {
			Utils::redirectReferer();
		} else {
			Utils::redirect('/book?bookId=' . $_GET['bookId']);
		}
	}


	public function removeLibrary()
	{

		$this->_checkLogged();
		$this->_checkBookId();

		$bookUser = BookUser::getBooksByBookIdAndUserId($_SESSION['identity']->id,  $_GET['bookId']);
		$bookUser->remove();
		Utils::setToast('Libro eliminado de la biblioteca');
		Utils::redirect('/book?bookId=' . $_GET['bookId']);
	}

	public function updateBookStatus()
	{
		$this->_checkLogged();
		if (empty($_POST['bookId'])) {
			Utils::redirect();
		}

		if (empty($_POST['status'])) {
			Utils::redirect();
		}

		$bookUser = BookUser::getBooksByBookIdAndUserId($_SESSION['identity']->id, $_POST['bookId']);
		$bookUser->setStatus($_POST['status']);



		$bookUser->updateStatus();
		Utils::setToast('Estado del libro actualizado');
		Utils::redirect('/book?bookId=' . $_POST['bookId']);
	}
}
