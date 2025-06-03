<?php

class AuthorController extends BaseController
{
	public function index()
	{
		$this->_checkLogged();
		$this->title = 'Información del autor';
		try {
			$author = Author::createById($_GET['authorId']);
		} catch (Exception $e) {
			Utils::setToast('Autor no encontrado', false);
			Utils::redirect('error/notFound');
		}

		$booksPublished = $author->getAllBooksByAuthorID();
		require_once 'views/author/authorInfo.php';
	}
}
