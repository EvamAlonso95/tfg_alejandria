<?php
class RecommendedBookController extends BaseController
{

    public function index()
    {
        if (isset($_SESSION['identity'])) {

            require_once 'views/recommendedBook/recommended.php';
        } else {
            header('Location:' . base_url);
        }
    }
}
