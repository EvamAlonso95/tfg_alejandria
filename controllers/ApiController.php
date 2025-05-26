<?php
class ApiController extends BaseController
{
	private $error;

	public function __construct()
	{
		$this->error = new ErrorController();
	}

	protected function _checkAdmin()
	{
		header('Content-Type: application/json; charset=utf-8');
		if (!Utils::isAdmin()) {
			$this->error->apiForbidden();
		}
	}

	private function restartQdrantLogic()
	{
		$qdrant = new QdrantLogic();
		$qdrant->restart();
	}

	public function users()
	{
		$this->_checkAdmin();
		$userRaw = User::getAllUsers();
		$users = [];
		foreach ($userRaw as $user) {
			$users[] = [
				'id' => $user->getId(),
				'name' => $user->getName(),
				'biography' => $user->getBiography(),
				'email' => $user->getEmail(),
				'profile_img' => $user->getProfileImage(),
				'role' => $user->getRole()->getName(),
				'role_id' => $user->getRole()->getId(),
			];
		}
		echo json_encode(['data' => $users]);
		return;
	}

	// validar que sea el admin
	public function editUser()
	{
		$this->_checkAdmin();
		if (empty($_POST['idUser']) || empty($_POST['role'])) {
			$this->error->apiError('Faltan datos para editar el usuario');
		}

		$user = User::createById($_POST['idUser']);
		$user->setRole(intval($_POST['role']));
		$user->editUser();

		echo json_encode(['success' => 'Se ha podido editar el usuario.']);
		return;
	}

	// validar que sea el admin
	public function deleteUser()
	{
		$this->_checkAdmin();
		if (empty($_POST['idUser'])) {
			$this->error->apiError('Faltan datos para eliminar el usuario');
		}

		$user = User::createById($_POST['idUser']);
		$user->deleteUser();
		echo json_encode(['success' => 'Se ha podido eliminar el usuario.']);
		return;
	}

	//BOOKS  

	// Método para obtener todos los libros
	public function books()
	{
		$this->_checkAdmin();
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
				'cover' =>  $book->getCoverImg(),
				'title' => $book->getTitle(),
				'synopsis' => $book->getSynopsis(),
				'author' => $authorsNames,
				'genre' => $genresNames,
			];
		}
		echo json_encode(['data' => $books]);
		return;
	}

	// Método para guardar un libro
	public function saveBook()
	{
		$this->_checkAdmin();
		if (empty($_POST['title']) || empty($_POST['synopsis']) || empty($_POST['authors']) || empty($_POST['genres']) || empty($_FILES['cover'])) {
			$this->error->apiError('Faltan datos para guardar el libro');
		}

		$rawAuthors = $_POST['authors'];
		$rawGenres = $_POST['genres'];
		$cover = $_FILES['cover'];
		$authors = array_filter(array_map('trim', explode(',', $rawAuthors)));
		$genres = array_filter(array_map('trim', explode(',', $rawGenres)));

		$book = new Book();
		$book->setTitle($_POST['title']);
		$book->setSynopsis($_POST['synopsis']);

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
			$this->error->apiError('Error al mover la imagen del libro.');
		}

		$book->save();

		$qdrant = new QdrantLogic();
		$bookVector = $qdrant->createVectors([$book], $qdrant->getDictionary());
		$qdrant->getQdrantClient()->uploadVectors('books', $bookVector);

		echo json_encode(['success' => 'Se ha podido crear el libro.']);
		return;
	}

	// Método para editar un libro
	public function editBook()
	{
		$this->_checkAdmin();
		if (empty($_POST['idBook']) || empty($_POST['title']) || empty($_POST['synopsis']) || empty($_POST['authors']) || empty($_POST['genres'])) {
			$this->error->apiError('Faltan datos para editar el libro');
		}

		$book = Book::createById($_POST['idBook']);
		$book->setTitle($_POST['title']);
		$book->setSynopsis($_POST['synopsis']);

		$rawAuthors = $_POST['authors'];
		$rawGenres = $_POST['genres'];

		$authors = array_filter(array_map('trim', explode(',', $rawAuthors)));
		$genres = array_filter(array_map('trim', explode(',', $rawGenres)));
		$book->cleanAuthors();
		$book->cleanGenres();
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
				$this->error->apiError('Error al mover la imagen del libro.');
			}
			$book->setCoverImg($filePath);
		}
		$book->edit();

		// Eliminamos el point de qdrant y lo volvemos a subir con la nueva informacion
		$qdrant = new QdrantLogic();
		$qdrant->getQdrantClient()->deletePoints('books', [$book->getId()]);
		$bookVector = $qdrant->createVectors([$book], $qdrant->getDictionary());
		$qdrant->getQdrantClient()->uploadVectors('books', $bookVector);
		echo json_encode(['success' => 'Se ha podido editar el libro.']);
		return;
	}

	// Método para eliminar un libro
	public function deleteBook()
	{
		$this->_checkAdmin();
		if (empty($_POST['idBook'])) {
			$this->error->apiError('Faltan datos para eliminar el libro');
		}

		$book = Book::createById(intval($_POST['idBook']));
		$book->delete();
		$qdrant = new QdrantLogic();
		$qdrant->getQdrantClient()->deletePoints('books', [$book->getId()]);
		echo json_encode(['success' => 'Se ha podido eliminar el libro.']);
		return;
	}

	//AUTHORS

	public function authors()
	{
		$this->_checkAdmin();
		$authorRaw = Author::getAllAuthors();
		$authors = [];
		foreach ($authorRaw as $author) {
			$authors[] = [
				'id' => $author->getId(),
				'authorName' => $author->getName(),
				'biography' => $author->getBiography(),
				'profileImage' => $author->getProfileImage(),

			];
			if ($author->getUser() != null) {
				$authors[count($authors) - 1]['userName'] = $author->getUser()->getId();
			}
		}
		echo json_encode(['data' => $authors]);
		return;
	}

	// Método para guardar un autor
	public function saveAuthor()
	{
		$this->_checkAdmin();
		if (empty($_POST['authorName']) || empty($_POST['biography']) || empty($_FILES['profileImage'])) {
			$this->error->apiError('Faltan datos para guardar el autor');
		}
		$profileImage = $_FILES['profileImage'];
		$author = new Author();
		$author->setName($_POST['authorName']);
		$author->setBiography($_POST['biography']);

		$extension = pathinfo($profileImage['name'], PATHINFO_EXTENSION);
		$uniqueName = uniqid('author_', true) . '.' . $extension;

		$filePath = 'uploads/authors/' . $uniqueName;
		$author->setProfileImage($filePath);

		if (!move_uploaded_file($profileImage['tmp_name'], $filePath)) {
			$this->error->apiError('Error al mover la imagen del autor.');
		}

		$author->save();
		$this->restartQdrantLogic();
		echo json_encode(['success' => 'Se ha podido crear el autor.']);
		return;
	}

	// Método para editar un autor
	public function editAuthor()
	{
		$this->_checkAdmin();
		if (empty($_POST['idAuthor']) || empty($_POST['authorName']) || empty($_POST['biography'])) {
			$this->error->apiError('Faltan datos para editar el autor');
		}

		$author = Author::createById($_POST['idAuthor']);
		$author->setName($_POST['authorName']);
		$author->setBiography($_POST['biography']);

		if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] == 0) {
			$profileImage = $_FILES['profileImage'];
			$extension = pathinfo($profileImage['name'], PATHINFO_EXTENSION);
			$uniqueName = uniqid('author_', true) . '.' . $extension;
			$filePath = 'uploads/authors/' . $uniqueName;
			if (!move_uploaded_file($profileImage['tmp_name'], $filePath)) {
				$this->error->apiError('Error al mover la imagen del autor.');
			}
			$author->setProfileImage($filePath);
		}

		$author->edit();
		$this->restartQdrantLogic();
		echo json_encode(['success' => 'Se ha podido editar el autor.']);
		return;
	}

	// Método para eliminar un autor
	public function deleteAuthor()
	{
		$this->_checkAdmin();
		if (empty($_POST['idAuthor'])) {
			$this->error->apiNotFound();
		}

		$author = Author::createById(intval($_POST['idAuthor']));
		$author->delete();
		$this->restartQdrantLogic();
		echo json_encode(['success' => 'Se ha podido eliminar el autor.']);
		return;
	}

	//GENRES
	public function genres()
	{
		$this->_checkAdmin();
		$genreRaw = Genre::getAllGenres();
		$genres = [];
		foreach ($genreRaw as $genre) {
			$genres[] = [
				'id' => $genre->getId(),
				'genreName' => $genre->getName(),
			];
		}
		echo json_encode(['data' => $genres]);
	}

	// Método para guardar un género

	public function saveGenre()
	{
		$this->_checkAdmin();
		if (empty($_POST['genreName'])) {
			$this->error->apiError('Faltan datos para guardar el género');
		}

		$genre = new Genre();
		$genre->setName($_POST['genreName']);
		$exists = $genre->existsByName();
		if ($exists) {
			$this->error->apiError('Ya existe un género con ese nombre.');
		}
		$genre->save();
		$this->restartQdrantLogic();
		echo json_encode(['success' => 'Se ha podido crear el género.']);
		return;
	}

	// Método para editar un género
	public function editGenre()
	{
		$this->_checkAdmin();
		if (empty($_POST['idGenre']) || empty($_POST['genreName'])) {
			$this->error->apiError('Faltan datos para editar el género');
		}

		$genre = Genre::createById($_POST['idGenre']);
		$genre->setName($_POST['genreName']);
		$genre->edit();
		$this->restartQdrantLogic();
		echo json_encode(['success' => 'Se ha podido editar el género.']);
		return;
	}

	//Método para eliminar un género
	public function deleteGenre()
	{
		$this->_checkAdmin();
		if (empty($_POST['idGenre'])) {
			$this->error->apiError('Faltan datos para eliminar el género');
		}

		$genre = Genre::createById(intval($_POST['idGenre']));
		$genre->delete();
		$this->restartQdrantLogic();
		echo json_encode(['success' => 'Se ha podido eliminar el género.']);
		return;
	}

	public function restartQdrant()
	{
		$this->_checkAdmin();
		$this->restartQdrantLogic();
		echo json_encode(['success' => 'Se ha podido reiniciar Qdrant.']);
		return;
	}
}
