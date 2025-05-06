<?php

class DashboardController extends BaseController
{

    public function index()
    {
        if (isset($_SESSION['identity'])) {
            $posts = Post::getAllPosts();
            require_once 'views/dashboard.php';
        } else {
            header('Location:' . base_url);
        }

        
    }
}
