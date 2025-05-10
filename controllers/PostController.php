<?php
class PostController extends BaseController
{
    public function index()
    {
        $posts = Post::getAllPosts();
        // var_dump($posts);
        $this->title = 'Publicaciones';
        require_once 'views/publication/publication.php';
        //TODO aquí controlo la vsta del post, no en AUTOR
    }

    public function info()
    {
        if (isset($_GET['postId'])) {
            $post = Post::createById($_GET['postId']);
            $this->title = 'Post: ' . $post->getTitle();
            require_once 'views/publication/postInfo.php';
        } else {
            header('Location: ' . base_url . 'post');
        }
    }

    public function save()
    {
        //TODO validar que solo los autores puedan crear publicaciones
        if (isset($_POST)) {



            $title = $_POST['title'] ?? null;
            $content = $_POST['content'] ?? null;
            $post_img = $_FILES['cover_img'] ?? null;

            if (!$title || !$content || !$post_img || $post_img['error'] !== UPLOAD_ERR_OK) {
                $_SESSION['post'] = 'error';
                header('Location: ' . base_url . 'post/create');
                exit;
            }

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


            $post->setUser(User::createById($_SESSION['identity']->id));

            // Guardar en la base de datos
            $post->createPost();
        }

        header('Location: ' . base_url . 'post');
    }

    public function delete()
    {
        //TODO validar que solo los autores puedan eliminar publicaciones
        if (isset($_POST['post_id'])) {
            $post = new Post();
            $post->setId($_POST['post_id']);
            $post->setUser(User::createById($_SESSION['identity']->id));
            $post->deletePost();
            $_SESSION['toast'] = [
                'message' => 'Publicación eliminada con éxito',
                'isSuccess' => true
            ];          
        }else {
            $_SESSION['toast'] = [
                'message' => 'Error al eliminar la publicación',
                'isSuccess' => false
            ];
        }
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
}
