<?php

session_start();
$_SESSION['visitor'] = [
    'token' => generateToken()
];
// var_dump($_SESSION);

function generateToken($length = 40)
{
    $characters       = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_!?./$';
    $charactersLength = strlen($characters);
    $token            = '';
    for ($i = 0; $i < $length; $i++) {
        $token .= $characters[rand(0, $charactersLength - 1)];
    }
    return $token;
}

spl_autoload_register(function ($class) {                            // $class = new Controllers\HomeController
    require_once lcfirst(str_replace('\\', '/', $class)) . '.php';   // require_once controllers/HomeController.php
});


if (array_key_exists('route', $_GET)):
    switch ($_GET['route']) {
        //pages
        case 'home':
            $controller = new Controllers\HomeController();
            $controller->displayHomePage();
            break;

        case 'news':
            $controller = new Controllers\NewsController();
            $controller->displayAllNews();
            break;

        case 'newsDetail':
            $id = $_GET['id'];
            $controller = new Controllers\NewsController();
            $controller->displayOneActu($id);
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
            
        case 'recipes':
            $controller = new Controllers\RecipesController();
            $controller->displayAllRecipes();
            break;

        case 'recipeDetail':
            $id = $_GET['id'];
            $controller = new Controllers\RecipesController();
            $controller->displayOneRecipe($id);
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
        case 'submitNewsForm':
            $controller = new Controllers\AdminController;
            $controller->veriNewsForm();
            break;

        case 'submitCatForm':
            $controller = new Controllers\AdminController;
            $controller->verifCatForm();
            break;

        case 'submitProdForm':
            $controller = new Controllers\AdminController;
            $controller->verifProdForm();
            break;

        case 'submitRecipeForm':
            $controller = new Controllers\AdminController;
            $controller->verifRecipeForm();
            break;

        //end
        default:
            header('Location: index.php?route=home');
            exit;
    }

else:
    header('Location: index.php?route=home');
    exit;
endif;

