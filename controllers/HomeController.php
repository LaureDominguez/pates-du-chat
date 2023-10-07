<?php

namespace Controllers;

use \Models\Categories;
use \Models\Products;
use \Models\Horaires;

class HomeController{
    public function displayHomePage(){
        
        $modelProduct = new Products();
        $products = $modelProduct->getAllProducts();

        $modelCategory = new Categories();
        $categories = $modelCategory->getAllCategories();

        $modelHoraires = new Horaires();
        $dates = $modelHoraires->getAllDates();

        $maxProducts = 11;
        $count = 0;

        // $description = "";
        $template = "home.phtml";
        include_once'views/layout.phtml';
    }

    public function visitor()
    {//stock la page actuelle et le token du visitor
        if(isset($_SERVER["HTTP_REFERER"]))
            $currentPage = $_SERVER["HTTP_REFERER"];
        if(!isset($_SESSION['visitor']))
            $_SESSION['visitor'] = [
                'token' => $this->generateToken(),
                'currentPage' => $currentPage,
                'flash_message' => []
            ];
        else $_SESSION['visitor']['currentPage'] = $currentPage;         
    }
    
    function generateToken($length = 40)
    {
        $characters       = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_!?./$';
        $charactersLength = strlen($characters);
        $token            = '';
        for ($i = 0; $i < $length; $i++) {
            $token .= $characters[rand(0, $charactersLength - 1)];
        }
        return $token;
    }

    public function alertMsg()
    {
        // var_dump($_SESSION['visitor']);

        // Affiche les messages d'erreur
        if (isset($_SESSION['visitor']['flash_message'])) {
            $errorLog = '';
            $errorRegist = '';
            $errors = '';
            $success = '';
            var_dump($_SESSION['visitor']['flash_message']);

            switch (true) {
                case isset($_SESSION['visitor']['flash_message']['success']):
                    var_dump("youpi1");
                    $success = $_SESSION['visitor']['flash_message']['success'];
                    break;
                case isset($_SESSION['visitor']['flash_message']['error']):
                    var_dump("youpi2");
                    $errorType = $_SESSION['visitor']['flash_message']['error'];
                    switch (true) {
                        case isset($errorType['login']):
                    var_dump("youpi3");
                            $errorLog = $errorType['login'][0];
                            break;
                        case isset($errorType['register']):
                    var_dump("youpi4");
                            $errorRegist = $errorType['register'][0];
                            break;
                        default:
                    var_dump("youpi5");
                            $errors = $errorType[0];
                            break;
                    }
                    break;
            }
        }
    }
}