<?php

class DashboardController
{

    public function index()
    {
        if(isset($_SESSION['identity'])){
            require_once 'views/dashboard.php';
        }else{
            header('Location:'.base_url);
        }
    }
}
