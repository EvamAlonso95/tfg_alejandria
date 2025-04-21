<?php

class LandingController extends BaseController
{
    public function index()
    {
        if (isset($_SESSION['identity'])) {
            require_once 'views/dashboard.php';
        } else {
            $this->showFooter = false;
            $this->showUserMenu = false;
            require_once 'views/landing/landing.php';
        }
    }
}
