<?php

namespace Controllers;

use DateTimeImmutable;
use \Models\News;
use \Models\Categories;
use \Models\Products;
use \Models\Recipes;
use \Models\Gallery;

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
        include'views/layout.phtml';
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
                $_SESSION['visitor']['flash_message'] = [
                    'success' => $success
                ];
            }
        }

        // $_SESSION['admin']['dashboardPages'] = [
        //     'tab1' => 'checked',
        //     'tab2' => '',
        //     'tab3' => '',
        //     'tab4' => ''
        // ];  
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
                $_SESSION['visitor']['flash_message'] = [
                    'success' => $success
                ];

                // $_SESSION['admin']['dashboardPages'] = [
                //     'tab1' => 'checked',
                //     'tab2' => '',
                //     'tab3' => '',
                //     'tab4' => ''
                // ];  
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

    public function verifProdForm()
    { // vérifie et créer le nouveau produit
        $errors = $imgErrors = [];
        $success = [];
        $img = null;

        if (array_key_exists('name', $_POST)) {

            if (empty($_POST['name']))
                $errors[] = "Veuillez donner un nom au produit";
            if (empty($_POST['category']))
                $errors[] = "Veuillez selectionner une catégorie";
            if (empty($_POST['descript']))
                $errors[] = "Veuillez entrer une description";
            if (empty($_POST['price']))
                $errors[] = "Veuillez définir un prix";

            if (count($errors) == 0){
                //si il y a une image à uploader :
                if (!empty($_FILES['img'])) {
                    $imgFile = strtolower($_FILES['img']['name']);
                    $file = $_FILES['img']['tmp_name'];
                    $imgSize = $_FILES['img']['size'];


                    $folder = "./public/img/produits/";
                    $path = $folder . $imgFile;
                    $targetFile = $folder . basename($imgFile);

                    $imgType = pathinfo($targetFile, PATHINFO_EXTENSION);

                    if ($imgType !== 'jpg' && $imgType !== 'jpeg' && $imgType !== 'png')
                        $imgErrors[] = "Seul les images de type 'jpg', 'jpeg' et 'png' sont autorisés";
                    if ($imgSize > 1000000)
                        $imgErrors[] = "L'image doit peser moins de 1 Mo";

                    // si l'image est conforme :
                    if (count($imgErrors) == 0) {

                        //on déplace l'image dans le dossier
                        move_uploaded_file($file, $targetFile);
                        $addNew = [
                            trim($_POST['name']),
                            $imgFile,
                        ];
                        
                        $modelGallery = new Gallery();
                        $img = $modelGallery->creatNew($addNew);
                        $success[] = "L'image a bien été envoyée !";
                        $_SESSION['visitor']['flash_message'] = [
                            'success' => $success
                        ];
                    }
                }

                //on créer le produit avec l'id de l'image si elle existe
                $addNew = [
                    trim($_POST['name']),
                    trim($_POST['category']),
                    trim($_POST['descript']),
                    trim($_POST['price']),
                    $img
                ];
                $modelProduct = new Products();
                $modelProduct->creatNew($addNew);
                $success[] = "Le nouveau produit a bien été créé !";
                $_SESSION['visitor']['flash_message'] = [
                    'success' => $success
                ];
            }
        }
        // $_SESSION['admin']['dashboardPages'] = [
        //     'tab1' => '',
        //     'tab2' => 'checked',
        //     'tab3' => '',
        //     'tab4' => ''
        // ];  

        $template = "views/shop/prodForm.phtml";
        include_once 'views/layout.phtml';
    }

    //active ou désactive un produit
    public function activeProduct($id)
    {
        $id = $_GET['id'];

        $modelProduct = new Products();
        $currentProduct = $modelProduct->getOneProduct($id);
        $newData = [
            'id' => $id,
            'active' => ($currentProduct['active'] ? 0 : 1)
        ];
        $modelProduct->updateProduct($newData);

        // $_SESSION['admin']['dashboardPages']['tab1'] = '';
        // $_SESSION['admin']['dashboardPages']['tab2'] = 'checked';
        // $_SESSION['admin']['dashboardPages']['tab3'] = '';
        // $_SESSION['admin']['dashboardPages']['tab4'] = '';
    }

    public function displayUpdateProdForm($id)
    {//affiche form d'update d'un produit existant
        $id = $_GET['id'];
        $modelNews = new Products();
        $product = $modelNews->getOneProduct($id);

        $modelCategory = new Categories();
        $categories = $modelCategory->getAllCategories();

        $template = "views/shop/prodForm.phtml";
        include_once 'views/layout.phtml';
    }

    public function verifUpdateProdForm($id)
    { // vérifie et créer le produit 
        $errors = $imgErrors = [];
        $success = [];
        $img = null;

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

                if (!empty($_FILES['img'])) {
                    $imgFile = strtolower($_FILES['img']['name']);
                    $file = $_FILES['img']['tmp_name'];
                    $imgSize = $_FILES['img']['size'];

                    $folder = "./public/img/produits/";
                    $path = $folder . $imgFile;
                    $targetFile = $folder . basename($imgFile);

                    $imgType = pathinfo($targetFile, PATHINFO_EXTENSION);

                    if ($imgType !== 'jpg' && $imgType !== 'jpeg' && $imgType !== 'png')
                        $imgErrors[] = "Seul les images de type 'jpg', 'jpeg' et 'png' sont autorisés";
                    if ($imgSize > 1000000)
                        $imgErrors[] = "L'image doit peser moins de 1 Mo";

                    // si l'image est conforme :
                    if (count($imgErrors) == 0) {

                        //on déplace l'image dans le dossier
                        move_uploaded_file($file, $targetFile);
                        $addNew = [
                            trim($_POST['name']),
                            $imgFile,
                        ];
                        $modelGallery = new Gallery();
                        $img = $modelGallery->creatNew($addNew);
                        $success[] = "L'image a bien été envoyée !";
                    }
                }

                $id = $_GET['id'];
                $newData = [
                    'id' => $id,
                    'name' => trim($_POST['name']),
                    'cat_id' => trim($_POST['category']),
                    'descript' => trim($_POST['descript']),
                    'price' => trim($_POST['price']),
                    'img' => $img
                ];

                $modelProduct = new Products();
                $modelProduct->updateProduct($newData);
                $success[] = "Le produit a bien été modifié !";
            }
        }
        $_SESSION['admin']['dashboardPages'] = [
            'tab1' => '',
            'tab2' => 'checked',
            'tab3' => '',
            'tab4' => ''
        ];  
        $template = "views/shop/prodForm.phtml";
        include_once 'views/layout.phtml';
    }

    /////////////////////// categories ///////////////////////
    public function displayCreateCatForm()
    { // affiche form de création d'une nouvelle catégorie 
        $modelCategory = new Categories();
        $categories = $modelCategory->getAllCategories();

        $template = "views/shop/catForm.phtml";
        include_once 'views/layout.phtml';
    }

    public function verifCatForm()
    { // vérifie et créer la catégorie
        $errors = [];
        $success = [];
        if (array_key_exists('name', $_POST) && array_key_exists('descript', $_POST)
        ) {
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

        $_SESSION['admin']['dashboardPages']['tab1'] = '';
        $_SESSION['admin']['dashboardPages']['tab2'] = 'checked';
        $_SESSION['admin']['dashboardPages']['tab3'] = '';
        $_SESSION['admin']['dashboardPages']['tab4'] = '';
        
        $template = "dashboard.phtml";
        include_once 'views/layout.phtml';
    }

    public function displayUploadCatForm($id)
    { //affiche le formulaire d'update d'une catégorie existante
        $id = $_GET['id'];
        $modelCategory = new Categories();
        $category = $modelCategory->getOneCategory($id);

        $template = "views/shop/catForm.phtml";
        include_once 'views/layout.phtml';
    }

    public function verifUpdateCatForm($id)
    { // vérifie et met à jour la catégorie 
        $errors = [];
        $success = [];
        if (array_key_exists('name', $_POST) && array_key_exists('descript', $_POST)
        ) {
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
        $_SESSION['admin']['dashboardPages'] = [
            'tab1' => '',
            'tab2' => 'checked',
            'tab3' => '',
            'tab4' => ''
        ];  
        $template = "dashboard.phtml";
        include_once 'views/layout.phtml';
    }

    public function activeCategory($id)
    {
        $id = $_GET['id'];

        $modelCategory = new Categories();
        $currentCategory = $modelCategory->getOneCategory($id);
        $newData = [
            'id' => $id,
            'active' => ($currentCategory['active'] ? 0 : 1)
        ];

        $_SESSION['admin']['dashboardPages']['tab1'] = '';
        $_SESSION['admin']['dashboardPages']['tab2'] = 'checked';
        $_SESSION['admin']['dashboardPages']['tab3'] = '';
        $_SESSION['admin']['dashboardPages']['tab4'] = '';

        $modelCategory->updateCategory($newData);
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
        $_SESSION['admin']['dashboardPages'] = [
            'tab1' => '',
            'tab2' => '',
            'tab3' => 'checked',
            'tab4' => ''
        ];  
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