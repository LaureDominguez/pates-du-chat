<?php

namespace Controllers;

class AdminController{

    public function displayDashboard()
    {
        $modelProduct = new \Models\Products();
        $products = $modelProduct->getAllProducts();

        $modelCategory = new \Models\Categories();
        $categories = $modelCategory->getAllCategories();

        $modelRecipes = new \Models\Recipes();
        $recipes = $modelRecipes->getAllRecipes();

        $template = "dashboard.phtml";
        include_once'views/layout.phtml';
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
        include_once 'views/layout.phtml';
    }

    public function verifProdForm()
    {
        $errors = [];
        $success = [];

        if (array_key_exists('name', $_POST)) {
            // $model = new \Models\Categories();

            if (empty($_POST['name']))
                $errors[] = "Veuillez donner un nom au produit";
            if (empty($_POST['category']))
                $errors[] = "Veuillez selectionner une catégorie";
            // if (!empty($_POST['category']))
            //     $cat = $model->findCat(trim($_POST['category']));
            //     var_dump($cat);
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
}