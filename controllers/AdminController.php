<?php

namespace Controllers;

use \Models\Categories;
use \Models\Products;
use \Models\Gallery;
use \Models\Horaires;

class AdminController{
//gère toutes les options de la page 'Tableau de bord' du site

    public function displayDashboard()
    {//affiche la page admin, voir plus bas pour les options de chaque onglets

        $modelProduct = new Products();
        $products = $modelProduct->getAllProducts();

        $modelCategory = new Categories();
        $categories = $modelCategory->getAllCategories();

        foreach ($categories as $category):
            $id = $category['id'];
            $countProducts = $modelCategory->countProductsFromCat($id);
            $nbProducts = $countProducts['nbProducts'];
        endforeach;

        $modelDate = new Horaires;
        $dates = $modelDate->getAllDates();

        $template = "dashboard.phtml";
        include'views/layout.phtml';
    }

    public function isAdmin()
    {
        // autoriser le fetch
        if(
            isset($_GET['route'])
            && $_GET['route'] === 'horairesFetch'
            || $_GET['route'] === 'productsFetch'
            || $_GET['route'] === 'imagesFetch'
            || $_GET['route'] === 'deleteFetch'
        ){
            // Autoriser l'accès sans authentification
            return;
        }
        // check authentification pour admin
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 1){
            header('Location: index.php?route=home');
            exit;
        }
    }

    /////////////////////// Onglet Boutique ///////////////////////
    /////////////////////// shop - produits ///////////////////////
    public function displayCreateProdForm()
    {//affiche le form de création d'un nouveau produit
        $modelProducts = new Products();
        $products = $modelProducts->getAllProducts();

        $modelCategory = new Categories();
        $categories = $modelCategory->getAllCategories();

        $template = "views/shop/prodForm.phtml";
        include_once 'views/layout.phtml';
    }

    //Fonction pour gérer l'upload d'image
    public function imageForm(){
        $imgErrors = [];
        $success = "";

        //la destination de l'image à uploader
        $uploadDir = "./public/img/produits/";
        $imgName = strtolower($_FILES['img']['name']);
        $imagePath = $uploadDir . basename($imgName);

        //les données de l'image
        $imgFile = $_FILES['img']['tmp_name'];
        $imgSize = $_FILES['img']['size'];
        $imgType = pathinfo($imagePath, PATHINFO_EXTENSION);

        if ($imgType !== 'jpg' && $imgType !== 'jpeg' && $imgType !== 'png')
            $imgErrors[] = "Seul les images de type 'jpg', 'jpeg' et 'png' sont autorisés";
        if ($imgSize > 10000000)
            $imgErrors[] = "L'image doit peser moins de 10 Mo";

        // si l'image est conforme :
        if (count($imgErrors) == 0) {

            //on déplace l'image dans le dossier
            move_uploaded_file($imgFile, $imagePath);
            $addNew = [
                trim($_POST['name']),
                $imgName,
            ];

            //et on l'enregistre dans la db
            $modelGallery = new Gallery();
            $img = $modelGallery->creatNew($addNew);
            $success = "L'image a bien été enregistrée !";
            $_SESSION['visitor']['flash_message'] = [
                    'success' => $success
                ];

            return $img;
        }
        $_SESSION['visitor']['flash_message'] = [
            'error' => $imgErrors
        ];
    }

    public function verifProdForm()
    { // vérifie et créer le nouveau produit
        $errors = [];
        $success = "";
        $img = null;

        // vérifie si il y a une image à uploader
        if ($_FILES && $_FILES["img"]["size"] !== 0) {
            $img = $this->imageForm();
        }

        if (empty($_POST['name']))
            $errors[] = "Veuillez donner un nom au produit";
        if (empty($_POST['category'])) {
            $category = 1;
        } else {
            $category = trim($_POST['category']);
        }
        if (empty($_POST['descript']))
            $errors[] = "Veuillez entrer une description";
        // if (empty($_POST['ingredients']))
        //     $errors[] = "Veuillez renseigner les ingrédients";
        if (empty($_POST['price']))
            $errors[] = "Veuillez définir un prix";

        if (count($errors) == 0){
            //on créer le produit avec l'id de l'image si elle existe
            $addNew = [
                trim($_POST['name']),
                $category,
                trim($_POST['descript']),
                trim($_POST['ingredients']),
                trim($_POST['price']),
                $img
            ];

            $modelProduct = new Products();
            $modelProduct->creatNew($addNew);
            $success = "Le nouveau produit a bien été créé !";
            $_SESSION['visitor']['flash_message'] = [
                'success' => $success
            ];
            header('Location: index.php?route=admin');
        }
        $_SESSION['visitor']['flash_message'] = [
                'error' => $errors
            ];
        
        $template = "views/shop/prodForm.phtml";
        include_once 'views/layout.phtml';
    }

    public function displayUpdateProdForm($id)
    {//affiche form d'update d'un produit existant
        $id = $_GET['id'];
        $modelProduct = new Products();
        $product = $modelProduct->getOneProduct($id);

        $modelCategory = new Categories();
        $categories = $modelCategory->getAllCategories();

        $template = "views/shop/prodForm.phtml";
        include_once 'views/layout.phtml';
    }

    public function verifUpdateProdForm($id)
    { // vérifie et met à jour le produit 
        $errors = [];
        $success = "";
        $id = $_GET['id'];

        if (empty($_POST['name']))
            $errors[] = "Veuillez donner un nom au produit";
        if (empty($_POST['category']))
        $errors[] = "Veuillez selectionner une catégorie";
        if (empty($_POST['descript']))
        $errors[] = "Veuillez entrer une description";
        if (empty($_POST['price']))
            $errors[] = "Veuillez définir un prix";

        if (count($errors) == 0) {
            // Récupère les données actuelles du produit
            $modelProduct = new Products();
            $currentProductData = $modelProduct->getOneProduct($id);

            // Compare les données
            if ($_POST['name'] !== $currentProductData['name']) {
                $newData['name'] = trim($_POST['name']);
            }
            if ($_POST['category'] !== $currentProductData['cat_id']) {
                $newData['cat_id'] = trim($_POST['category']);
            }
            if ($_POST['descript'] !== $currentProductData['descript']) {
                $newData['descript'] = trim($_POST['descript']);
            }
            if ($_POST['ingredients'] !== $currentProductData['ingredients']) {
                $newData['ingredients'] = trim($_POST['ingredients']);
            }
            if ($_POST['price'] !== $currentProductData['price']) {
                $newData['price'] = trim($_POST['price']);
            }

            $newData['img'] = $currentProductData['img'];

            $newData['id'] = $id;
            $modelProduct->updateProduct($newData);
            $success = "Le produit a bien été modifié !";
            $_SESSION['visitor']['flash_message'] = [
                'success' => $success
            ];

            header('Location: index.php?route=admin');
        }
        $_SESSION['visitor']['flash_message'] = [
                'error' => $errors
            ];

        $template = "views/shop/prodForm.phtml";
        include_once 'views/layout.phtml';
    }

    /////////////////////// shop - categories ///////////////////////
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
        $success = "";

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
            $success = "La nouvelle catégorie a bien été créée !";
            $_SESSION['visitor']['flash_message'] = [
                'success' => $success
            ];

            header('Location: index.php?route=admin');
        }
        $_SESSION['visitor']['flash_message'] = [
            'error' => $errors
        ];

        $template = "views/shop/catForm.phtml";
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
        $success = "";
        $id = $_GET['id'];

        if (empty($_POST['name']))
        $errors[] = "Veuillez renseigner le nom de la catgéorie";
        if (empty($_POST['descript']))
        $errors[] = "Veuillez entrer une description";

        if (count($errors) == 0) {
            // Récupère les données actuelles
            $modelCategory = new Categories();
            $currentCatData = $modelCategory->getOneCategory($id);

            // Compare les données
            $newData = ['id' => $id]; 
            if ($_POST['name'] !== $currentCatData['name']) {
                $newData['name'] = trim($_POST['name']);
            }
            if ($_POST['descript'] !== $currentCatData['descript']) {
                $newData['descript'] = trim($_POST['descript']);
            }
            $newData = [
                'id' => $id,
                'name' => trim($_POST['name']),
                'descript' => trim($_POST['descript'])
            ];

            $modelCategory->updateCategory($newData);
            $success = "La catégorie a bien été modifiée !";
            $_SESSION['visitor']['flash_message'] = [
                'success' => $success
            ];

            header('Location: index.php?route=admin');
        }
        $_SESSION['visitor']['flash_message'] = [
                'error' => $errors
            ];

        $template = "views/shop/catForm.phtml";
        include_once 'views/layout.phtml';
    }

    /////////////////////// Onglet Contact ///////////////////////
    // géré dans /config/horairesFetch.php

}