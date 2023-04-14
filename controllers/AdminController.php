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
        // $category = $modelCategory->getOneCategory($products['id']);

        $modelRecipes = new \Models\Recipes();
        $recipes = $modelRecipes->getAllRecipes();

        $template = "dashboard.phtml";
        $css = [
            "public/css/dashboard.css",
            "public/css/switch.css",
            "public/css/tooltip.css"
        ];

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
    public function displayCreateNewsForm()
    {
        $template = "views/news/form.phtml";
        $css = [
            "public/css/dashboard.css"
        ];

        include_once 'views/layout.phtml';
    }

    public function VerifCreatNewsForm()
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

    public function displayUpdateNewsForm($id)
    {
        $id = $_GET['id'];
        $modelNews = new \Models\News();
        $actu = $modelNews->getOneActu($id);

        $template = "views/news/form.phtml";
        $css = [
            "public/css/dashboard.css"
        ];

        include_once 'views/layout.phtml';
    }

    public function VerifUpdateNewsForm($id)
    {
        $success = [];
        if (array_key_exists('title', $_POST) && array_key_exists('message', $_POST)) {
            $id = $_GET['id'];
            $newData = [
                'id' => $id,
                'title' => trim($_POST['title']),
                'message' => trim($_POST['message'])
            ];
            $modelNews = new \Models\News();
            $modelNews->updateNews($newData);
            $success[] = "L'article a bien été modifié !";

            $template = "dashboard.phtml";
            $css = [
                "public/css/dashboard.css"
            ];
            include_once 'views/layout.phtml';

        }
    }

    public function deleteNews($id){
        $id = $_GET['id'];
        $modelNews = new \Models\News();
        $modelNews->deleteOneActu($id);
    }

    /////////////////////// categories ///////////////////////
    public function displayCreateCatForm()
    {
        $modelProduct = new \Models\Products();
        $products = $modelProduct->getAllProducts();

        $modelCategory = new \Models\Categories();
        $categories = $modelCategory->getAllCategories();

        $template = "views/shop/catForm.phtml";
        $css = [
            "public/css/dashboard.css"
        ];

        include_once 'views/layout.phtml';
    }
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
        $css = [
            "public/css/dashboard.css"
        ];
        include_once 'views/layout.phtml';
    }

    /////////////////////// produits ///////////////////////
    public function displayCreateProdForm()
    {
        $modelProduct = new \Models\Products();
        $products = $modelProduct->getAllProducts();

        $modelCategory = new \Models\Categories();
        $categories = $modelCategory->getAllCategories();

        $template = "views/shop/prodForm.phtml";
        $css = [
            "public/css/dashboard.css"
        ];

        include_once 'views/layout.phtml';
    }

    public function displayUpdateProdForm($id)
    {
        $id = $_GET['id'];
        $modelNews = new \Models\Products();
        $product = $modelNews->getOneProduct($id);

        $modelCategory = new \Models\Categories();
        $category = $modelCategory->getAllCategories();

        $template = "views/shop/prodForm.phtml";
        $css = [
            "public/css/dashboard.css"
        ];

        include_once 'views/layout.phtml';
    }

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
    public function displayCreateRecipesForm()
    {
        $modelRecipes = new \Models\Recipes();
        $recipes = $modelRecipes->getAllRecipes();

        $modelProducts = new \Models\Products();
        $products = $modelProducts->getAllProducts();

        $template = "views/recipes/form.phtml";
        $css = [
            "public/css/dashboard.css",
            "public/css/rating.css"
        ];

        include_once 'views/layout.phtml';
    }
    public function displayUpdateRecipesForm($id)
    {
        $id = $_GET['id'];
        $modelRecipes = new \Models\Recipes();
        $recipe = $modelRecipes->getOneRecipe($id);

        $modelProducts = new \Models\Products();
        $products = $modelProducts->getAllProducts();

        $template = "views/recipes/form.phtml";
        $css = [
            "public/css/dashboard.css",
            "public/css/rating.css"
        ];

        include_once 'views/layout.phtml';
    }

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