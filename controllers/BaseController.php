<?php
abstract class BaseController
{
	public $showFooter = true;
	public $showHeader = true;
	public $showUserMenu = true;
	public $title = 'Alejandria';
	public $toastData;

	public function __construct()
	{
		$this->toastData = Utils::getToast();
	}

	protected function _checkLogged()
	{
		if (!Utils::isLogged()) {
			Utils::redirect();
		}
	}

	protected function _checkAuthor()
	{
		if (!Utils::isAuthor()) {
			Utils::redirect();
		}
	}

	protected function _checkAdmin()
	{
		if (!Utils::isAdmin()) {
			Utils::redirect('error/forbidden');
		}
	}
}
