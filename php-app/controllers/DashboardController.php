<?php

class DashboardController extends BaseController
{

	public function index()
	{
		$this->_checkLogged();

		$posts = Post::getAllPosts();
		$actualBooks = BookUser::getBooksByUserId($_SESSION['identity']->id);
		
		
		require_once 'views/dashboard.php';
	}
}
