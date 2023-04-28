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

        $template = "shop/index.phtml";
        include_once'views/layout.phtml';
    }

    public function displayOneProduct($id)
    {
        $modelProducts = new Products();
        $product = $modelProducts->getOneProduct($id);

        $modelCategories = new Categories();
        $category = $modelCategories->getOneCategory($product['cat_id']);

        $template = "shop/detail.phtml";
        include_once 'views/layout.phtml';
    }
}