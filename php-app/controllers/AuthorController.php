<?php

class AuthorController extends BaseController
{
	public function index()
	{
		$this->_checkLogged();
		$author = Author::createById($_GET['authorId']);
		$booksPublished = $author->getAllBooksByAuthorID();
		require_once 'views/author/authorInfo.php';
	}
}
