<?php
class PostController extends BaseController
{
    public function index()
    {
        $posts = Post::getAllPosts();
        $this->title = 'Publicaciones'; 
        require_once 'views/publication/publication.php';    
        //TODO aquí controlo la vsta del post, no en AUTOR
    }
}