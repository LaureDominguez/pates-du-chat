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
}