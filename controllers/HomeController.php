<?php

namespace Controllers;

use \Models\News;
use \Models\Categories;
use \Models\Products;
use \Models\Recipes;

class HomeController{
    public function displayHomePage(){
        var_dump($_SESSION);
        
        $modelNews = new News();
        $news = $modelNews->getAllNews();

        $modelProduct = new Products();
        $products = $modelProduct->getAllProducts();

        $modelCategory = new Categories();
        $categories = $modelCategory->getAllCategories();

        $modelRecipes = new Recipes();
        $recipes = $modelRecipes->getAllRecipes();

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
            ];
        else $_SESSION['visitor']['currentPage'] = $currentPage;         
    }

    public function clearMsg()
    {//efface les messages d'erreur stockés dans la session
        if (isset($_SESSION['visitor']['msg']))
            $_SESSION['visitor']['msg'] = "";
            
        header('Location: ' . $_SESSION['visitor']['currentPage']);
        exit;
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