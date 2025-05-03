<?php
class BookController extends BaseController
{
    public function index()
    {
        // Aquí puedes implementar la lógica para mostrar la información del libro
        // Por ejemplo, cargar los detalles del libro desde la base de datos y mostrarlos en una vista
        require_once 'views/book/bookInfo.php';
    }
}
