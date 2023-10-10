<?php

namespace Controllers;

use \Models\Categories;
use \Models\Products;

class ShopController{
    public function displayAllShop(){
        $model = new Products();
        $products = $model->getAllProducts();

        $model = new Categories();
        $categories = $model->getAllCategoriesWithProducts();

        $description = "Découvrez toutes nos recettes !";
        $template = "shop/index.phtml";
        include_once'views/layout.phtml';
    }

    public function displayOneProduct($id)
    {//affiche un produit
        $modelProducts = new Products();
        $product = $modelProducts->getOneProduct($id);

        $modelCategories = new Categories();
        $category = $modelCategories->getOneCategory($product['cat_id']);

        $description = "Détails du produit";
        $template = "shop/detail.phtml";
        include_once 'views/layout.phtml';
    }
}