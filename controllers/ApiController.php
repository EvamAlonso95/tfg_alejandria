<?php
class ApiController
{
    //USERS

    public function users()
    {
        if (Utils::isAdmin()) {

            $userRaw = User::getAllUsers();
            $users = [];
            foreach ($userRaw as $user) {
                $users[] = [
                    'id' => $user->getId(),
                    'name' => $user->getName(),
                    'biography' => $user->getBiography(),
                    'email' => $user->getEmail(),
                    'profile_img' => base_url . $user->getProfileImage(),
                    'role' => $user->getRole()->getName(),
                    'role_id' => $user->getRole()->getId(),
                ];
            }
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['data' => $users]);
        } else {
            $error = new ErrorController();
            $error->forbidden();
        }
    }

    // validar que sea el admin
    public function editUser()
    {


        if (Utils::isAdmin()) {
            if (isset($_POST['idUser'])) {
                $user = User::createById($_POST['idUser']);
                // $user->setName($_POST['name']);
                $user->setRole(intval($_POST['role']));

                // Para no romper el método de User de edición, pues espera mas campos
                $user->setName($user->getName());
                $user->setEmail($user->getEmail());
                $user->setBiography($user->getBiography());
                $user->setProfileImage($user->getProfileImage());


                $user->editUser();
                echo json_encode(['success' => 'Se ha podido editar el usuario.']);
                return;
            } else {
                echo json_encode(['error' => 'No existe el método solicitado']);
            }
        } else {
            $error = new ErrorController();
            $error->forbidden();
        }
    }

    // validar que sea el admin
    public function deleteUser()
    {
        if (Utils::isAdmin()) {
            if (isset($_POST['idUser'])) {
                $user = User::createById($_POST['idUser']);
                $user->deleteUser();
                echo json_encode(['success' => 'Se ha podido eliminar el usuario.']);
                return;
            } else {
                echo json_encode(['error' => 'No existe el método solicitado']);
            }
        } else {
            $error = new ErrorController();
            $error->forbidden();
        }
    }

    //BOOKS  

    // Método para obtener todos los libros
    public function books()
    {
        if (Utils::isAdmin()) {
            $bookRaw = Book::getAllBooks();
            $books = [];
            foreach ($bookRaw as $book) {
                $authors = $book->getAuthors();
                $authorsNames = array_map(function ($author) {
                    return $author->getName();
                }, $authors);
                $authorsNames = implode(', ', $authorsNames);
                $genres = $book->getGenres();
                $genresNames = array_map(function ($genre) {
                    return $genre->getName();
                }, $genres);
                $genresNames = implode(', ', $genresNames);
                $books[] = [
                    'id' => $book->getId(),
                    'cover' => base_url . $book->getCoverImg(),
                    'title' => $book->getTitle(),
                    'synopsis' => $book->getSynopsis(),
                    'author' => $authorsNames,
                    'genre' => $genresNames,
                ];
            }
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['data' => $books]);
        } else {
            $error = new ErrorController();
            $error->forbidden();
        }
    }

    // Método para guardar un libro
    public function save()
    {
        if (Utils::isAdmin()) {
            $title = $_POST['title'] ?? null;
            $synopsis = $_POST['synopsis'] ?? null;
            $rawAuthors = $_POST['authors'] ?? '';
            $rawGenres = $_POST['genres'] ?? '';
            $cover = $_FILES['cover'] ?? null;
            $authors = array_filter(array_map('trim', explode(',', $rawAuthors)));
            $genres = array_filter(array_map('trim', explode(',', $rawGenres)));

            if (!$title || !$synopsis || !$authors || !$genres || !$cover) {
                echo json_encode(['error' => 'Faltan datos para crear el libro.']);
                return;
            }
            $book = new Book();
            $book->setTitle($title);
            $book->setSynopsis($synopsis);

            foreach ($genres as $genre) {
                $book->setGenre($genre);
            }
            foreach ($authors as $author) {
                $book->setAuthor($author);
            }


            $extension = pathinfo($cover['name'], PATHINFO_EXTENSION);
            $uniqueName = uniqid('book_', true) . '.' . $extension;

            $filePath = 'uploads/books/' . $uniqueName;
            $book->setCoverImg($filePath);

            if (!move_uploaded_file($cover['tmp_name'], $filePath)) {
                echo json_encode(['error' => 'Error al mover la imagen del libro.']);
                return;
            }

            $book->save();
            echo json_encode(['success' => 'Se ha podido crear el libro.']);
        } else {
            $error = new ErrorController();
            $error->forbidden();
        }
    }

    // Método para editar un libro
    public function edit()
    {
        if (Utils::isAdmin()) {
            var_dump($_POST);
            if (isset($_POST['idBook'])) {

                $book = Book::createById($_POST['idBook']);
                $book->setTitle($_POST['title']);
                $book->setSynopsis($_POST['synopsis']);

                // TODO Revisar porque no quiero que se mande vacio
                $rawAuthors = $_POST['authors'];
                $rawGenres = $_POST['genres'];
                $authors = array_filter(array_map('trim', explode(',', $rawAuthors)));
                $genres = array_filter(array_map('trim', explode(',', $rawGenres)));

                foreach ($genres as $genre) {
                    $book->setGenre($genre);
                }
                foreach ($authors as $author) {
                    $book->setAuthor($author);
                }

                if (isset($_FILES['cover']) && $_FILES['cover']['error'] == 0) {
                    $cover = $_FILES['cover'];
                    $extension = pathinfo($cover['name'], PATHINFO_EXTENSION);
                    $uniqueName = uniqid('book_', true) . '.' . $extension;
                    $filePath = 'uploads/books/' . $uniqueName;
                    if (!move_uploaded_file($cover['tmp_name'], $filePath)) {
                        echo json_encode(['error' => 'Error al mover la imagen del libro.']);
                        return;
                    }
                    $book->setCoverImg($filePath);
                }

                $book->edit();
                echo 'hola';
                echo json_encode(['success' => 'Se ha podido editar el libro.']);
            } else {
                echo json_encode(['error' => 'No existe el método solicitado']);
            }
        } else {
            $error = new ErrorController();
            $error->forbidden();
        }
    }

    // Método para eliminar un libro
    public function delete()
    {
        var_dump($_POST);
        if (Utils::isAdmin()) {
            if (isset($_POST['idBook'])) {
                $book = Book::createById(intval($_POST['idBook']));

                $book->delete();
                echo json_encode(['success' => 'Se ha podido eliminar el libro.']);
                return;
            } else {
                echo json_encode(['error' => 'No existe el método solicitado']);
            }
        } else {
            $error = new ErrorController();
            $error->forbidden();
        }
    }

    //AUTHORS

    public function authors()
    {
        if (Utils::isAdmin()) {
            $authorRaw = Author::getAllAuthors();
            $authors = [];
            foreach ($authorRaw as $author) {
                $authors[] = [
                    'id' => $author->getId(),
                    'authorName' => $author->getName(),
                    'biography' => $author->getBiography(),
                    'profileImage' => base_url . $author->getProfileImage(),

                ];
                if ($author->getUser() != null) {
                    $authors[count($authors) - 1]['userName'] = $author->getUser()->getId();
                }
            }
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['data' => $authors]);
        } else {
            $error = new ErrorController();
            $error->forbidden();
        }
    }

    // Método para guardar un autor
    public function saveAuthor()
    {
        if (Utils::isAdmin()) {
            $authorName = $_POST['authorName'] ?? null;
            $biography = $_POST['biography'] ?? null;
            $profileImage = $_FILES['profileImage'] ?? null;

            if (!$authorName || !$biography || !$profileImage) {
                echo json_encode(['error' => 'Faltan datos para crear el autor.']);
                return;
            }
            $author = new Author();
            $author->setName($authorName);
            $author->setBiography($biography);

            $extension = pathinfo($profileImage['name'], PATHINFO_EXTENSION);
            $uniqueName = uniqid('author_', true) . '.' . $extension;

            $filePath = 'uploads/authors/' . $uniqueName;
            $author->setProfileImage($filePath);

            if (!move_uploaded_file($profileImage['tmp_name'], $filePath)) {
                echo json_encode(['error' => 'Error al mover la imagen del autor.']);
                return;
            }


            $author->save();
            echo json_encode(['success' => 'Se ha podido crear el autor.']);
        } else {
            $error = new ErrorController();
            $error->forbidden();
        }
    }

    // Método para editar un autor
    public function editAuthor()
    {
        if (Utils::isAdmin()) {
            if (isset($_POST['idAuthor'])) {
                $author = Author::createById($_POST['idAuthor']);
                $author->setName($_POST['authorName']);
                $author->setBiography($_POST['biography']);

                if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] == 0) {
                    $profileImage = $_FILES['profileImage'];
                    $extension = pathinfo($profileImage['name'], PATHINFO_EXTENSION);
                    $uniqueName = uniqid('author_', true) . '.' . $extension;
                    $filePath = 'uploads/authors/' . $uniqueName;
                    if (!move_uploaded_file($profileImage['tmp_name'], $filePath)) {
                        echo json_encode(['error' => 'Error al mover la imagen del autor.']);
                        return;
                    }
                    $author->setProfileImage($filePath);
                }

                $author->edit();
                echo json_encode(['success' => 'Se ha podido editar el autor.']);
            } else {
                echo json_encode(['error' => 'No existe el método solicitado']);
            }
        } else {
            $error = new ErrorController();
            $error->forbidden();
        }
    }

    // Método para eliminar un autor
    public function deleteAuthor()
    {
        if (Utils::isAdmin()) {
            if (isset($_POST['idAuthor'])) {
                $author = Author::createById(intval($_POST['idAuthor']));
                $author->delete();
                echo json_encode(['success' => 'Se ha podido eliminar el autor.']);
                return;
            } else {
                echo json_encode(['error' => 'No existe el método solicitado']);
            }
        } else {
            $error = new ErrorController();
            $error->forbidden();
        }
    }
}
