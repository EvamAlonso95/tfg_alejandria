<?php
class PostController extends BaseController
{

	/**
	 * @param Post $post
	 */
	private function _checkIsAuthorPost($post)
	{
		if (!Utils::isAuthor() || $post->getAuhtor()->getId() !== Author::createByUserId($_SESSION['identity']->id)->getId()) {
			Utils::redirect('post');
		}
	}

	public function index()
	{
		$this->_checkLogged();
		$this->_checkAuthor();;
		$posts = Post::getAllPostsByAuthor(Author::createByUserId($_SESSION['identity']->id)->getId());
		// var_dump($posts);
		$this->title = 'Publicaciones';
		require_once 'views/publication/publication.php';
	}

	public function info()
	{
		$this->_checkLogged();
		if (!isset($_GET['postId'])) {
			Utils::redirect('post');
		}
		try {
			$post = Post::createById($_GET['postId']);
		} catch (Exception $e) {
			Utils::setToast('Publicación no encontrada', false);
			Utils::redirect('error/notFound');
		}
		$this->title = 'Post: ' . $post->getTitle();
		require_once 'views/publication/postInfo.php';
	}

	public function save()
	{
		$this->_checkLogged();
		$this->_checkAuthor();
		if (!isset($_POST)) {
			Utils::redirect('post/create');
		}
		if (empty($_POST['title']) || empty($_POST['content']) || empty($_FILES['cover_img'])) {
			$_SESSION['post'] = 'error';
			Utils::redirect('post/create');
		}
		$title = $_POST['title'];
		$content = $_POST['content'];
		$post_img = $_FILES['cover_img'];

		$post = new Post();
		$post->setTitle($title);
		$post->setContent($content);

		// Procesar imagen
		$extension = pathinfo($post_img['name'], PATHINFO_EXTENSION);
		$uniqueName = uniqid('post_', true) . '.' . $extension;
		$uploadDir = 'uploads/post/';
		$filePath = $uploadDir . $uniqueName;

		if (!is_dir($uploadDir)) {
			mkdir($uploadDir, 0755, true);
		}

		if (!move_uploaded_file($post_img['tmp_name'], $filePath)) {
			echo json_encode(['error' => 'Error al mover la imagen del post.']);
			exit;
		}

		$post->setCoverImg($filePath);
		$post->setDate(date('Y-m-d H:i:s'));


		$post->setAuthor(Author::createByUserId($_SESSION['identity']->id));

		// Guardar en la base de datos
		$post->createPost();
		Utils::setToast('Publicación creada correctamente');
		Utils::redirect('post');
	}

	public function delete()
	{
		$this->_checkLogged();
		$this->_checkAuthor();
		if (!isset($_POST['post_id'])) {
			Utils::setToast('Error al eliminar la publicación', false);
			Utils::redirect('post');
		}

		$post = Post::createById($_POST['post_id']);
		$this->_checkIsAuthorPost($post);
		$post->deletePost();
		Utils::setToast('Publicación eliminada con éxito');
		Utils::redirect('post');
	}
}
