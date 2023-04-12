<?php

namespace Controllers;

class AdminController{

    public function displayDashboard()
    {
        $modelNews = new \Models\News();
        $news = $modelNews->getAllNews();

        $modelProduct = new \Models\Products();
        $products = $modelProduct->getAllProducts();

        $modelCategory = new \Models\Categories();
        $categories = $modelCategory->getAllCategories();

        $modelRecipes = new \Models\Recipes();
        $recipes = $modelRecipes->getAllRecipes();

        $template = "dashboard.phtml";
        $css = "public/css/dashboard.css"; 

        include_once'views/layout.phtml';
    }

    public function isAdmin()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 1){
            header('Location: index.php?route=login');
            exit;
        }
    }
    
/////////////////////// News ///////////////////////
    public function veriNewsForm()
    {
        $errors = [];
        $success = [];
        if (array_key_exists('title', $_POST) && array_key_exists('message', $_POST)) {
            if (empty($_POST['title']))
            $errors[] = "Veuillez entrer un titre";
            if (empty($_POST['message']))
            $errors[] = "Veuillez entrer votre article";

            if (count($errors) == 0) {
                $addNew = [
                    trim($_POST['title']),
                    trim($_POST['message'])
                ];

                $modelNews = new \Models\News();
                $modelNews->creatNew($addNew);
                $success[] = "Le nouvel article a bien été créé !";
            }
        }
        $template = "dashboard.phtml";
        include_once 'views/layout.phtml';
    }

/////////////////////// categories ///////////////////////
    public function verifCatForm()
    {
        $errors = [];
        $success = [];
        if (array_key_exists('name', $_POST) && array_key_exists('descript', $_POST)) {
            if (empty($_POST['name']))
                $errors[] = "Veuillez renseigner le nom de la catgéorie";
            if (empty($_POST['descript']))
                $errors[] = "Veuillez entrer une description";

            if (count($errors) == 0) {
                $addNew = [
                    trim($_POST['name']),
                    trim($_POST['descript'])
                ];

                $modelCategory = new \Models\Categories();
                $modelCategory->creatNewCat($addNew);
                $success[] = "La nouvelle catégorie a bien été créée !";
            }
        }
        $template = "dashboard.phtml";
        include_once 'views/layout.phtml';
    }

/////////////////////// produits ///////////////////////
    public function verifProdForm()
    {
        $errors = [];
        $success = [];

        if (array_key_exists('name', $_POST)) {

            if (empty($_POST['name']))
                $errors[] = "Veuillez donner un nom au produit";
            if (empty($_POST['category']))
                $errors[] = "Veuillez selectionner une catégorie";
            if (empty($_POST['descript']))
                $errors[] = "Veuillez entrer une description";
            if (empty($_POST['price']))
                $errors[] = "Veuillez définir un prix";

            if (count($errors) == 0) {
                $addNew = [
                    trim($_POST['name']),
                    trim($_POST['category']),
                    trim($_POST['descript']),
                    trim($_POST['price']),
                    trim($_POST['img'])
                ];

                $modelProduct = new \Models\Products();
                $modelProduct->creatNew($addNew);
                $success[] = "Le nouveau produit a bien été créé !";
            }
        }
        $template = "dashboard.phtml";
        include_once 'views/layout.phtml';
    }

/////////////////////// recettes ///////////////////////
    public function verifRecipeForm(){
        $errors = [];
        $success = [];

        if (array_key_exists('name', $_POST)) {

            // var_dump($_POST);
            // die;

            if (empty($_POST['name']))
                $errors[] = "Veuillez donner un nom à la recette";
            if (empty($_POST['product']))
            $errors[] = "Veuillez selectionner l'ingrédient phare de la recette";
            if (empty($_POST['recipe']))
                $errors[] = "Veuillez écrire ici votre recette";

            if (count($errors) == 0) {
                $addNew = [
                    trim($_POST['name']),
                    trim($_POST['product']),
                    trim($_POST['difficulty']),
                    trim($_POST['time']),
                    trim($_POST['thermostat']),
                    trim($_POST['portions']),
                    trim($_POST['recipe']),
                    trim($_POST['img'])
                ];

                $modelRecipes = new \Models\Recipes();
                $modelRecipes->creatNew($addNew);
                $success[] = "La nouvelle recette a bien été créée !";
            }
        }
        $template = "dashboard.phtml";
        include_once 'views/layout.phtml';
    }
}