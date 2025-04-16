<?php

class LandingController extends BaseController
{
    public function index()
    {
        $this->showFooter = false;
        $this->showUserMenu = false;
        require_once 'views/landing/landing.php';
    }
}
