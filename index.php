<?php

session_start();

spl_autoload_register(function ($class) {                            // $class = new Controllers\HomeController
    require_once lcfirst(str_replace('\\', '/', $class)) . '.php';   // require_once controllers/HomeController.php
});

if(array_key_exists('route', $_GET)):
    
    switch ($_GET['route']) {
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

        case 'login':
            $controller = new Controllers\UsersController();
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