<?php

namespace Controllers;

class ShopController{
    public function displayAllShop(){
        $model = new \Models\Products();
        $products = $model->getAllProducts();

        $model = new \Models\Categories();
        $categories = $model->getAllCategoriesWithProducts();

        $template = "shop/index.phtml";
        include_once'views/layout.phtml';
    }

    public function displayOneProduct($id)
    {
        $modelProducts = new \Models\Products();
        $product = $modelProducts->getOneProduct($id);

        $modelCategories = new \Models\Categories();
        $category = $modelCategories->getOneCategory($product['cat_id']);

        $template = "shop/detail.phtml";
        include_once 'views/layout.phtml';
    }

    public function checkCart(){
        // var_dump($_SESSION);
        // 3 cas du cookie
        // echo $_COOKIE['token'];
        // switch($_COOKIE){
        //     case ''
        // }
    }

    public function addToCart($id)
    {
        if(array_key_exists('quantity', $_POST)){
            $id = $_GET['id'];
            $quantity = $_POST['quantity'];

            $modelProducts = new \Models\Products();
            $product = $modelProducts->getOneProduct($id);
            $price = $product['price'];

            setcookie(
                'item', 
                $_COOKIE['token'] = $_SESSION['visitor']['token'],
                $_COOKIE['productID'] = $id,
                $_COOKIE['quantity'] = $quantity,
                $_COOKIE['price'] = $price, 
                time() + 86400
            );

            // var_dump($_COOKIE);
            // die;

            $template = "shop/cart.phtml";
            include_once 'views/layout.phtml';
        }
    }

    public function flushCart(){
        unset($_COOKIE);
        $template = "shop/cart.phtml";
        include_once 'views/layout.phtml';
    }
}