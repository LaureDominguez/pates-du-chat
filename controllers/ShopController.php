<?php

namespace Controllers;

class ShopController{
    public function displayAllProducts(){
        $model = new \Models\Products();
        $tousMesArticles = $model->getAllProducts();

        $template = "shop/shop_view.phtml";
        include_once'views/layout.phtml';
    }
}