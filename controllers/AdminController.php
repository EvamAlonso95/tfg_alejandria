<?php
// Iniciamos la sesión para poder usarla en el controlador frontal

class AdminController extends BaseController
{
    public function index()
    {
        if (isset($_SESSION['identity'])) {

            $this->title = 'Panel de administración';
            // TODO: añadir if según la vista que toque
            $users = User::getAllUsers();
            $authorsData = Author::getAllAuthors();
            $authors = [];
            foreach ($authorsData as $author) {
                $authors[] = $author->getName();
            }
            $authors = json_encode($authors);

            $genresRaw = Genre::getAllGenres();
            $genres = [];
            foreach ($genresRaw as $genre) {
                $genres[] = $genre->getName();
            }
            $genres = json_encode($genres);

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
