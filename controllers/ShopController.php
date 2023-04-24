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

    public function addToCart($id)
    {
        if(array_key_exists('quantity', $_POST)){
            $id = $_GET['id'];
            $quantity = $_POST['quantity'];

            $modelProducts = new Products();
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