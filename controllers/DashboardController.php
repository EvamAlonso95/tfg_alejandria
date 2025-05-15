<?php

class DashboardController extends BaseController
{

	public function index()
	{
		$this->_checkLogged();

		$posts = Post::getAllPosts();
		require_once 'views/dashboard.php';
	}
}
