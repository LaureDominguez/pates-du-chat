<?php

namespace Controllers;

class ShopController{
    public function displayAllShop(){
        $model = new \Models\Products();
        $products = $model->getAllProducts();

        $model = new \Models\Categories();
        $categories = $model->getAllCategories();

        $template = "shop/index.phtml";
        include_once'views/layout.phtml';
    }
}