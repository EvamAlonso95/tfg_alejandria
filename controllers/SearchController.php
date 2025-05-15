<?php

class SearchController extends BaseController
{
	public function index()
	{
		$this->_checkLogged();
		$books = null;
		if (!empty($_GET['search'])) {
			$books = Book::search($_GET['search']);
		}
		require_once 'views/search/search.php';
	}

	public function saveBookUser()
	{
		$this->_checkLogged();
		$status = 'want to read';
		if (isset($_GET['bookId']) && isset($_GET['userId'])) {
			$bookUser = new BookUser();
			$bookUser->setBook(Book::createById($_GET['bookId']));
			$bookUser->setUser(User::createById($_GET['userId']));
			$bookUser->setStatus($status);
			var_dump($bookUser);
			echo 'hola2';
			$bookUser->saveBookUser();
			// DEbugear la query
			//  var_dump($bookUser);
		}
		Utils::redirect('search');
	}
}
