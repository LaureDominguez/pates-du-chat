<?php

// $ExpirationTime = 3600; // 1h
// session_set_cookie_params($ExpirationTime);
session_start();

spl_autoload_register(function ($class) {       
    require_once lcfirst(str_replace('\\', '/', $class)) . '.php';   // require_once controllers/HomeController.php
});
// charge les configs du site
require('config/config.php');

//session visiteur
$controller = new Controllers\HomeController();
$controller->visitor();
if (array_key_exists('route', $_GET)):
    // var_dump($_SESSION);
    switch ($_GET['route']) {

/////////////////////// pages ///////////////////////
        case 'home':
            $controller = new Controllers\HomeController();
            $controller->displayHomePage();
            break;

        case 'shop':
            $controller = new Controllers\ShopController();
            $controller->displayAllShop();
            break;

        case 'shopDetail':
            $id = $_GET['id'];
            $controller = new Controllers\ShopController();
            $controller->displayOneProduct($id);
            break;
            
        case 'sendContactMail':
            $controller = new Controllers\ContactController();
            $controller->submitMessage();
            break;

        case 'admin':
            $controller = new Controllers\AdminController();
            $controller->isAdmin();
            $controller->displayDashboard();
            break;

/////////////////////// login ///////////////////////
        // case 'login':
        //     $controller = new Controllers\UsersController();
        //     $controller->login();
        //     break;

        case 'connect':
            $controller = new Controllers\UsersController();
            $controller->loginUser();
            break;

        case 'register':
            $controller = new Controllers\UsersController();
            $controller->newUser();
            break;

        case 'logout':
            $controller = new Controllers\UsersController();
            $controller->logout();
            break;


/////////////////////// profil ///////////////////////
        case 'myAccount':
            $controller = new Controllers\UsersController();
            $controller->isConnected();
            $controller->profil();
            break;

        case 'changeNameForm':
            $controller = new Controllers\UsersController();
            $controller->isConnected();
            $controller->updateUserName();
            break;

        case 'changeMailForm':
            $controller = new Controllers\UsersController();
            $controller->isConnected();
            $controller->profil();
            break;

        case 'changePswdForm':
            $controller = new Controllers\UsersController();
            $controller->isConnected();
            $controller->profil();
            break;

        case 'deleteUser':
            $controller = new Controllers\UsersController();
            $controller->isConnected();
            $controller->profil();
            break;

/////////////////////// Dashboard ///////////////////////
///////////////////////shop
        //products
        case 'displayCreateProdForm':
            $controller = new Controllers\AdminController();
            $controller->isAdmin();
            $controller->displayCreateProdForm();
            break;

        case 'submitProdForm':
            $controller = new Controllers\AdminController();
            $controller->isAdmin();
            $controller->verifProdForm();
            break;

        case 'displayUpdateProdForm':
            $id = $_GET['id'];
            $controller = new Controllers\AdminController();
            $controller->isAdmin();
            $controller->displayUpdateProdForm($id);
            break;

        case 'updateProdForm':
            $id = $_GET['id'];
            $controller = new Controllers\AdminController();
            $controller->isAdmin();
            $controller->verifUpdateProdForm($id);
            break;

        //categories
        case 'displayCreateCatForm':
            $controller = new Controllers\AdminController();
            $controller->isAdmin();
            $controller->displayCreateCatForm();
            break;

        case 'submitCatForm':
            $controller = new Controllers\AdminController;
            $controller->isAdmin();
            $controller->verifCatForm();
            break;

        case 'displayUploadCatForm':
            $id = $_GET['id'];
            $controller = new Controllers\AdminController();
            $controller->isAdmin();
            $controller->displayUploadCatForm($id);
            break;

        case 'updateCatForm':
            $id = $_GET['id'];
            $controller = new Controllers\AdminController();
            $controller->isAdmin();
            $controller->verifUpdateCatForm($id);
            break;

///////////////////////contact

/////////////////////// end ///////////////////////
        default:
            header('Location: index.php?route=home');
            exit;
    }

else:
    header('Location: index.php?route=home');
    exit;
endif;

