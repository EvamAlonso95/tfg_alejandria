<?php
class LandingController extends BaseController
{
	public function index()
	{
		if (Utils::isLogged()) {
			Utils::redirect('dashboard');
		}

		$this->showFooter = false;
		$this->showUserMenu = false;
		$quote = Utils::obtenerFraseLiterariaAleatoria(); //TODO: obtener de bbdd
		require_once 'views/landing/landing.php';
	}
}
