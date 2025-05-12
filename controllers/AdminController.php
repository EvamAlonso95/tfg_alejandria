<?php
// Iniciamos la sesión para poder usarla en el controlador frontal

class AdminController extends BaseController
{
    public function index()
    {
        if (isset($_SESSION['identity'])) {
            //TODO añadir isAdmin() para comprobar que es admin
            $this->title = 'Panel de administración';
            // TODO: añadir if según la vista que toque
            $users = User::getAllUsers();


            require_once 'views/admin/adminUsers.php';
        } else {
            header('Location:' . base_url);
        }
    }

    public function authors()
    {
        $this->title = 'Panel de administración - Autores';
        require_once 'views/admin/adminAuthors.php';
    }




    public function genres()
    {
        $this->title = 'Panel de administración - Generos';
        $genres = Genre::getAllGenres();
        require_once 'views/admin/adminGenres.php';
    }

    public function books()
    {
        $this->title = 'Panel de administración - Libros';
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
        require_once 'views/admin/adminBooks.php';
    }


    public function qdrant()
    {
        $qdrant = new QdrantLogic();
        $qdrant->restart();

        header('Location:' . base_url . 'admin/index');
    }
}
