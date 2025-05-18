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
}
