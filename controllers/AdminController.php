<?php

namespace Controllers;

use DateTimeImmutable;
use \Models\News;
use \Models\Categories;
use \Models\Products;
use \Models\Recipes;

class AdminController{
//gère toutes les options de la page 'Tableau de bord' du site

    public function displayDashboard()
    {//affiche la page admin, voir plus bas pour les options de chaque onglets
        $modelNews = new News();
        $news = $modelNews->getAllNews();

        $modelProduct = new Products();
        $products = $modelProduct->getAllProducts();

        $modelCategory = new Categories();
        $categories = $modelCategory->getAllCategories();

        foreach ($categories as $category):
            $id = $category['id'];
            $countProducts = $modelCategory->countProductsFromCat($id);
            $nbProducts = $countProducts['nbProducts'];
        endforeach;

        $modelRecipes = new Recipes();
        $recipes = $modelRecipes->getAllRecipes();

        $template = "dashboard.phtml";
        include_once'views/layout.phtml';
    }

    public function isAdmin()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 1){
            header('Location: index.php?route=login');
            exit;
        }
    }

    /////////////////////// Onglet News ///////////////////////
    public function displayCreateNewsForm()
    {//affiche le form pour créer des actus
        $template = "views/news/form.phtml";
        include_once 'views/layout.phtml';
    }

    public function VerifCreatNewsForm()
    {// vérifie et créer la nouvelle actu
        $errors = $success = [];
        
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

                $modelNews = new News();
                $modelNews->creatNew($addNew);
                $success[] = "Le nouvel article a bien été créé !";
            }
        }
        $template = "dashboard.phtml";
        include_once 'views/layout.phtml';
    }

    public function displayUpdateNewsForm($id)
    {// affiche le form pour updater une actu existante
        $id = $_GET['id'];
        $modelNews = new News();
        $actu = $modelNews->getOneActu($id);

        $template = "views/news/form.phtml";
        include_once 'views/layout.phtml';
    }

    public function VerifUpdateNewsForm($id)
    {// vérifie et met à jour l'actu 
        $errors = [];
        $success = [];
        if (array_key_exists('title', $_POST) && array_key_exists('message', $_POST)) {

            if (empty($_POST['title']))
                $errors[] = "Veuillez entrer un titre";
            if (empty($_POST['message']))
                $errors[] = "Veuillez entrer votre article";

            if (count($errors) == 0) {

                $id = $_GET['id'];
                $newData = [
                    'id' => $id,
                    'title' => trim($_POST['title']),
                    'message' => trim($_POST['message'])
                ];
                $modelNews = new News();
                $modelNews->updateNews($newData);
                $success[] = "L'article a bien été modifié !";

                $template = "dashboard.phtml";
                include_once 'views/layout.phtml';

            }
        }
    }

    public function deleteNews($id)
    {//supprime l'actu
        $id = $_GET['id'];
        $modelNews = new News();
        $modelNews->deleteOneActu($id);
    }

    /////////////////////// Onglet Boutique ///////////////////////
    /////////////////////// categories ///////////////////////
    public function displayCreateCatForm()
    {// affiche form de création d'une nouvelle catégorie 
        $modelCategory = new Categories();
        $categories = $modelCategory->getAllCategories();

        $template = "views/shop/catForm.phtml";
        include_once 'views/layout.phtml';
    }
    public function verifCatForm()
    {// vérifie et créer la catégorie
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

                $modelCategory = new Categories();
                $modelCategory->creatNewCat($addNew);
                $success[] = "La nouvelle catégorie a bien été créée !";
            }
        }
        $template = "dashboard.phtml";
        include_once 'views/layout.phtml';
    }

    public function switchCat($id)//à faire
    { //active ou déscative une catégorie
        $success = [];
        $id = $_GET['id'];
        if (array_key_exists('switch', $_POST)) {
            var_dump($_POST);
            die;
        }
    }

    public function displayUploadCatForm($id)
    {//affiche le formulaire d'update d'une catégorie existante
        $id = $_GET['id'];
        $modelCategory = new Categories();
        $category = $modelCategory->getOneCategory($id);

        $template = "views/shop/catForm.phtml";
        include_once 'views/layout.phtml';
    }

    public function verifUpdateCatForm($id)
    {// vérifie et met à jour la catégorie 
        $errors = [];
        $success = [];
        if (array_key_exists('name', $_POST) && array_key_exists('descript', $_POST)) {
            if (empty($_POST['name']))
            $errors[] = "Veuillez renseigner le nom de la catgéorie";
            if (empty($_POST['descript']))
            $errors[] = "Veuillez entrer une description";

            if (count($errors) == 0) {
                $id = $_GET['id'];
                $newData = [
                    'id' => $id,
                    'name' => trim($_POST['name']),
                    'descript' => trim($_POST['descript'])
                ];

                $modelCategory = new Categories();
                $modelCategory->updateCategory($newData);
                $success[] = "La catégorie a bien été modifiée !";
            }
        }
        $template = "dashboard.phtml";
        include_once 'views/layout.phtml';
    }

    /////////////////////// produits ///////////////////////
    public function displayCreateProdForm()
    {//affiche le form de création d'un nouveau produit
        $modelProducts = new Products();
        $products = $modelProducts->getAllProducts();

        $modelCategory = new Categories();
        $categories = $modelCategory->getAllCategories();

        $template = "views/shop/prodForm.phtml";
        include_once 'views/layout.phtml';
    }

    public function verifUpdateProdForm()
    {// vérifie et créer le produit 
        $modelProduct = new Products();
        $products = $modelProduct->getAllProducts();

        $modelCategory = new Categories();
        $categories = $modelCategory->getAllCategories();

        $template = "views/shop/prodForm.phtml";
        include_once 'views/layout.phtml';
    }

    //active ou désactive un produit //à faire

    public function displayUpdateProdForm($id)
    {//affiche form d'update d'un produit existant
        $id = $_GET['id'];
        $modelNews = new Products();
        $product = $modelNews->getOneProduct($id);

        $modelCategory = new Categories();
        $category = $modelCategory->getAllCategories();

        $template = "views/shop/prodForm.phtml";
        include_once 'views/layout.phtml';
    }

    public function verifProdForm()
    {// vérifie et met à jour le produit
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
                $modelProduct = new Products();
                $modelProduct->creatNew($addNew);
                $success[] = "Le nouveau produit a bien été créé !";
            }
        }
        $template = "dashboard.phtml";
        include_once 'views/layout.phtml';
    }

    /////////////////////// recettes ///////////////////////
    public function displayCreateRecipesForm()
    {//affiche le form pour une nouvelle recette
        $modelRecipes = new Recipes();
        $recipes = $modelRecipes->getAllRecipes();

        $modelProducts = new Products();
        $products = $modelProducts->getAllProducts();

        $template = "views/recipes/form.phtml";
        include_once 'views/layout.phtml';
    }

    public function verifRecipeForm()
    {// vérifie et créer la recette 
        $errors = [];
        $success = [];

        if (array_key_exists('name', $_POST)) {

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

                $modelRecipes = new Recipes();
                $modelRecipes->creatNew($addNew);
                $success[] = "La nouvelle recette a bien été créée !";
            }
        }
        $template = "dashboard.phtml";
        include_once 'views/layout.phtml';
    }

    //supprime la recette //à faire

    public function displayUpdateRecipesForm($id)
    { //affiche le form pour updater une recette existante
        $id = $_GET['id'];
        $modelRecipes = new Recipes();
        $recipe = $modelRecipes->getOneRecipe($id);

        $modelProducts = new Products();
        $products = $modelProducts->getAllProducts();

        $template = "views/recipes/form.phtml";
        include_once 'views/layout.phtml';
    }

    //vérifie et met à jour la recette // à faire

    /////////////////////// Onglet Boutique ///////////////////////
}