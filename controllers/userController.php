<?php
require_once 'models/user.php';

class userController
{

    public function index()
    {
        echo 'Hola soy un usuario';
    }

    public function register()
    {
        require_once 'views/landing/register.php';
    }

    public function login()
    {
        require_once 'views/landing/login.php';
    }
}
