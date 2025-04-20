<?php
// Iniciamos la sesión para poder usarla en el controlador frontal
require_once './models/user.php';

class AdminController extends BaseController
{
    public function index()
    {
        $this->title = 'Panel de administración';
        require_once 'views/profiles/adminPage.php';
    }

}