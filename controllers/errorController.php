<?php

class ErrorController extends BaseController
{

    public function index()
    {
        require_once 'views/errorPage.php';
    }

    public function notFound()
    {
        $this->showFooter = false;
        $this->showUserMenu = false;
        require_once 'views/error404.php';
    }

    public function forbidden()
    {
        $this->showFooter = false;
        $this->showUserMenu = false;
        require_once 'views/forbiddenPage.php';
    }
}
