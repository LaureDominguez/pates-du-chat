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
            $controller->displayAllShop();
            break;
            
        case 'recipes':
            # code...
            break;

        case 'admin':
            $controller = new Controllers\AdminController();
            $controller->displayDashboard();
            break;

        //login
        case 'login':
            $controller = new Controllers\UsersController();
            $controller->login();
            break;

        case 'connect':
            $controller = new Controllers\UsersController();
            $controller->checkUser();
            break;

        case 'register':
            $controller = new Controllers\UsersController();
            $controller->newUser();
            break;

        case 'logout':
            $controller = new Controllers\UsersController();
            $controller->logout();
            break;

        //profil
        case 'myAccount':
            $controller = new Controllers\UsersController();
            $controller->profil();
            break;

        case 'myShopCart':
            # code...
            break;

        case 'myShopHist':
            # code...
            break;

        //form
        case 'submitCatForm':
            $controller = new Controllers\AdminController;
            $controller->verifForm();
            break;

        case 'submitProdForm':
            # code...
            break;

        //end
        default:
            header('Location: index.php?route=home');
            exit;
            break;
    }
else:
    header('Location: index.php?route=home');
    exit;
endif;

