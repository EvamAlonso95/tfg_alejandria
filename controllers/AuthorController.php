<?php

class AuthorController extends BaseController
{
    public function index()
    {
        $author = Author::createById($_GET['authorId']);
        require_once 'views/author/authorInfo.php';
    }

    
}
