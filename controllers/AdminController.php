<?php
// Iniciamos la sesión para poder usarla en el controlador frontal
require_once './models/user.php';
require_once './models/role.php';

class AdminController extends BaseController
{
    public function index()
    {
        $this->title = 'Panel de administración';
        $users = User::getAllUsers();


        require_once 'views/admin/adminPage.php';
    }

    public function user(){

    }

    /*public function books(){
        $this->title = 'Panel de administración - Libros';
        $books = Book::getAllBooks();
        require_once 'views/admin/adminBooks.php';
    }*/
}
