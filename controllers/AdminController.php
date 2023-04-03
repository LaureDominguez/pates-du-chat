<?php

namespace Controllers;

use Models\Categories;
use PDO;
use PDOException;

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
        if (array_key_exists('name', $_POST)) {
            if (empty($_POST['name']))
                $errors[] = "Veuillez renseigner ce champs";
            if (!filter_var($_POST['name']))
                $errors[] = "Veuillez utiliser des caractères valides";
            if (array_key_exists('descript', $_POST)) {
                if (!filter_var($_POST['descript']))
                    $errors[] = "Veuillez utiliser des caractères valides";
            }
            if (count($errors) == 0) {
                $model = new \Models\Categories();
                $model->creatNew();
            }
        }
        else{
            echo $errors;
        }
    }
}