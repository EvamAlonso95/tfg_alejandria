<?php

class SearchController extends BaseController
{
    public function index()
    {
        $books = null;
        if (!empty($_GET['search'])) {
            $books = Book::search($_GET['search']);
        }
        require_once 'views/search/search.php';
    }
}
