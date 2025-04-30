<?php
// Iniciamos la sesión para poder usarla en el controlador frontal

class AdminController extends BaseController
{
    public function index()
    {
        if (isset($_SESSION['identity'])) {

            $this->title = 'Panel de administración';
            $users = User::getAllUsers();
            require_once 'views/admin/adminPage.php';
        } else {
            header('Location:' . base_url);
        }
    }

    // public function user(){

    // }

    /*public function books(){
        $this->title = 'Panel de administración - Libros';
        $books = Book::getAllBooks();
        require_once 'views/admin/adminBooks.php';
    }*/
}
