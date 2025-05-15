<?php
class RecommendedBookController extends BaseController
{

	public function index()
	{
		$this->_checkLogged();

		require_once 'views/recommendedBook/recommended.php';
	}
}
