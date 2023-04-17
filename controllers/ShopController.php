<?php

namespace Controllers;

class ShopController{
    public function displayAllShop(){
        $model = new \Models\Products();
        $products = $model->getAllProducts();

        $model = new \Models\Categories();
        $categories = $model->getAllCategoriesWithProducts();

        $template = "shop/index.phtml";
        $css = [
            "public/css/shop.css"
        ];
        include_once'views/layout.phtml';
    }

    public function displayOneProduct($id)
    {
        $modelProducts = new \Models\Products();
        $product = $modelProducts->getOneProduct($id);

        $modelCategories = new \Models\Categories();
        $category = $modelCategories->getOneCategory($product['cat_id']);

        $template = "shop/detail.phtml";
        $css = [
            "public/css/shop.css"
        ];
        include_once 'views/layout.phtml';
    }
}