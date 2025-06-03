<?php

class SearchController extends BaseController
{
	public function index()
	{
		$this->_checkLogged();
		$this->title = 'Búsqueda de libros';
		$books = null;
		if (!empty($_GET['search'])) {
			$books = Book::search($_GET['search']);
		}else{
			$books = Book::getAllBooks();

		}
		require_once 'views/search/search.php';
	}
}
