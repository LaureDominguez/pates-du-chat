<?php

session_start();

spl_autoload_register(function ($class) {                            // $class = new Controllers\HomeController
    require_once lcfirst(str_replace('\\', '/', $class)) . '.php';   // require_once controllers/HomeController.php
});

if(array_key_exists('route', $_GET)):
    
    switch ($_GET['route']) {
        //pages
        case 'home':
            $controller = new Controllers\HomeController();
            $controller->displayHomePage();
            break;

        case 'news':
            # code...
            break;

        case 'shop':
            $controller = new Controllers\ShopController();
            $controller->displayAllProducts();
            break;
            
        case 'recipes':
            # code...
            break;

        case 'admin':
            # code...
            break;

        //login
        case 'login':
            $controller = new Controllers\UsersController();
            break;

        case 'register':
            # code...
            break;

        case 'logout':
            # code...
            break;

        //profil
        case 'myAccount':
            # code...
            break;

        case 'myShopCart':
            # code...
            break;

        case 'myShopHist':
            # code...
            break;

        default:
            header('Location : index.php?route=home');
            exit;
            break;
    }
else:
    header('Location : index.php?route=home');
    exit;
endif;