<?php

class AdminController extends BaseController
{

	public function index()
	{
		$this->_checkAdmin();
		$this->title = 'Panel de administración';
		$users = User::getAllUsers();
		require_once 'views/admin/adminUsers.php';
	}

	public function authors()
	{
		$this->_checkAdmin();
		$this->title = 'Panel de administración - Autores';
		require_once 'views/admin/adminAuthors.php';
	}

	public function genres()
	{
		$this->_checkAdmin();
		$this->title = 'Panel de administración - Generos';
		$genres = Genre::getAllGenres();
		require_once 'views/admin/adminGenres.php';
	}

	public function books()
	{
		$this->_checkAdmin();
		$this->title = 'Panel de administración - Libros';
		$authorsData = Author::getAllAuthors();
		$authors = [];
		foreach ($authorsData as $author) {
			$authors[] = $author->getName();
		}
		$authors = json_encode($authors);

		$genresRaw = Genre::getAllGenres();
		$genres = [];
		foreach ($genresRaw as $genre) {
			$genres[] = $genre->getName();
		}
		$genres = json_encode($genres);
		require_once 'views/admin/adminBooks.php';
	}

	
}
