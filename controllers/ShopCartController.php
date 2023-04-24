<?php

namespace Controllers;

use \Models\Products;

class ShopCartController{

    public function saveCart()
    {
        global $panier;
        setcookie(COOKIE_NAME, json_encode($panier), COOKIE_EXPIRE, '/');
    }

    public function addCartToCookie($id)
    {
        define('COOKIE_NAME', 'panier');
        define('COOKIE_EXPIRE', time() + 86400); //expire dans 1 jour

        if (array_key_exists('quantity', $_POST)) {
            $quantity = $_POST['quantity'];

            $modelProducts = new Products();
            $product = $modelProducts->getOneProduct($id);
            $productName = $product['name'];
            $price = $product['price'];

            global $panier;

            if (isset($_COOKIE[COOKIE_NAME])) {
                $panier = json_decode($_COOKIE[COOKIE_NAME], true);
            } else {
                $panier = array();
            }

            if (isset($panier[$id])) {
                $panier[$id][$quantity] += $quantity;
            } else {
                $panier[$id] = array(
                    'id' => $id,
                    'product' => $productName,
                    'quantity' => $quantity,
                    'price' => $price
                );
            }
            $this->saveCart();
            // var_dump($panier[$id][$quantity]);
            // die;

            $_SESSION['message'] = 'L\'article "' . $productName . '" a bien été ajouté !';

            header('Location: index.php?route=shopDetail&id=' . $id);
            exit();
        }
    }

    public function changeQuantity($id, $quantity){
        global $panier;
        if(isset($panier[$id])){
            $panier[$id]['quantity'] = $quantity;
        }
        $this->saveCart();
    }

    public function deleteItem($id){
        global $panier;
        unset($panier[$id]);
        $this->saveCart();
    }

    public function total(){
        global $panier;
        $total = 0;
        if(isset($panier)) {
            foreach ($panier as $id => $article) {
                $total += $article['quantity'] * $article['price'];
            }
        }
        return $total;
    }

    public function displayCart(){
        global $panier;
        $total = $this->total();
        $template = "shop/cart.phtml";
        include_once 'views/layout.phtml';
    }
}