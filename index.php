<?php

$ExpirationTime = 3600; // 1h
session_set_cookie_params($ExpirationTime);
session_start();

spl_autoload_register(function ($class) {       
    require_once lcfirst(str_replace('\\', '/', $class)) . '.php';
});
// charge les configs du site
require('config/config.php');

//session visiteur
$controller = new Controllers\HomeController();
$controller->visitor();
if (array_key_exists('route', $_GET)):
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

        case 'contactPage':
            $controller = new Controllers\ContactController();
            $controller->displayContactPage();
            break;

        case 'contactMail':
            $controller = new Controllers\ContactController();
            $controller->displayContactForm();
            break;

        case 'legal':
            $controller = new Controllers\ContactController();
            $controller->displayMLPage();
            break;

        case 'admin':
            $controller = new Controllers\AdminController();
            $controller->isAdmin();
            $controller->displayDashboard();
            break;

/////////////////////// contact mail ///////////////////////

        case 'sendContactMail':
            $controller = new Controllers\ContactController();
            $controller->submitMessage();
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


/////////////////////// User profil ///////////////////////
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

        case 'resetPswd':
            $controller = new Controllers\UsersController();
            $controller->sendPswdLink();
            break;

        case 'resetPswdForm':
            $controller = new Controllers\UsersController();
            $controller->resetPswd();
            break;

        case 'desactivateUser':
            $controller = new Controllers\UsersController();
            $controller->isConnected();
            $controller->disable($id);
            break;

/////////////////////// Admin dashboard ///////////////////////
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

        case 'submitImgForm':
            $controller = new Controllers\AdminController();
            $controller->isAdmin();
            $controller->imageForm();
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

/////////////////////// fetch

        case 'productsFetch':
            require('./config/switchActiveFetch.php');
            break;

        case 'imagesFetch':
            require('./config/imagesFetch.php');
            break;
            
        case 'horairesFetch':
            require ('./config/horairesFetch.php');
            break;

        case 'deleteFetch':
            require('./config/deleteFetch.php');
            break;

/////////////////////// end ///////////////////////
        default:
            header('Location: index.php?route=home');
            exit;
    }

else:
    header('Location: index.php?route=home');
    exit;
endif;

