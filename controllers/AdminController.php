<?php

namespace Controllers;


class AdminController{
    public function displayDashboard(){
        $model = new \Models\Products();
        $products = $model->getAllProducts();

        $model = new \Models\Categories();
        $categories = $model->getAllCategories();

        $template = "dashboard.phtml";
        include_once'views/layout.phtml';
    }

    public function verifForm()
    {
        $errors = [];
        $success = [];
        if (array_key_exists('name', $_POST) && array_key_exists('descript', $_POST)) {
            if (empty($_POST['name']))
                $errors[] = "Veuillez renseigner le nom de la catgéorie";
            if (empty($_POST['descript']))
                $errors[] = "Veuillez entrer une description";

            if (count($errors) == 0) {
                $addCategory = [
                    trim($_POST['name']),
                    trim($_POST['descript'])
                ];

                $model = new \Models\Categories();
                $model->creatNew($addCategory);
                $success[] = "La nouvelle catégorie a bien été créée !";
            }
        }
        $template = "dashboard.phtml";
        include_once 'views/layout.phtml';
    }
}