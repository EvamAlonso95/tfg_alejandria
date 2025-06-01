<?php

class ErrorController extends BaseController
{

	public function index()
	{
		require_once 'views/errorPage.php';
	}

	public function notFound()
	{
		$this->showFooter = true;
		$this->showUserMenu = false;
		http_response_code(404);
		require_once 'views/errorPage.php';
	}

	public function forbidden()
	{
		$this->showFooter = true;
		$this->showUserMenu = false;
		http_response_code(403);
		require_once 'views/forbiddenPage.php';
	}

	public function apiNotFound()
	{
		http_response_code(404);
		echo json_encode(['error' => 'No existe el método solicitado']);
		exit();
	}
	public function apiForbidden()
	{
		http_response_code(403);
		echo json_encode(['error' => 'No tienes permisos']);
		exit();
	}

	public function apiError(string $message = 'Faltan datos')
	{
		http_response_code(422);
		echo json_encode(['error' => $message]);
		exit();
	}
}
