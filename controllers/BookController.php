<?php
class BookController extends BaseController
{
    public function index()
    {       
        
        $book = Book::createById($_GET['bookId']);
        require_once 'views/book/bookInfo.php';
    }

}
