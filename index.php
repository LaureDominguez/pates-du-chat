<?php

session_start();

spl_autoload_register(function ($class) {                            // $class = new Controllers\HomeController
    require_once lcfirst(str_replace('\\', '/', $class)) . '.php';   // require_once controllers/HomeController.php
});
// var_dump($_SESSION);
//session visitor
$controller = new Controllers\HomeController();
$controller->visitor();


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
            $controller->isAdmin();
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

        case 'changeNameForm':
            $controller = new Controllers\UsersController();
            $controller->updateUserName();
            break;

        case 'changeMailForm':
            $controller = new Controllers\UsersController();
            $controller->profil();
            break;

        case 'changePswdForm':
            $controller = new Controllers\UsersController();
            $controller->profil();
            break;

        case 'deleteUser':
            $controller = new Controllers\UsersController();
            $controller->profil();
            break;

        case 'myShopCart':
            # code...
            break;

        case 'myShopHist':
            # code...
            break;


            //gestion du site
            //news

        case 'displayCreateNewsForm':
            $controller = new Controllers\AdminController();
            $controller->isAdmin();
            $controller->displayCreateNewsForm();
            break;

        case 'submitNews':
            $controller = new Controllers\AdminController;
            $controller->isAdmin();
            $controller->VerifCreatNewsForm();
            break;

        case 'displayUpdateNewsForm':
            $id = $_GET['id'];
            $controller = new Controllers\AdminController();
            $controller->isAdmin();
            $controller->displayUpdateNewsForm($id);
            break;

        case 'updateNews':
            $id = $_GET['id'];
            $controller = new Controllers\AdminController();
            $controller->VerifUpdateNewsForm($id);
            break;

        case 'deleteNews':
            $id = $_GET['id'];
            $controller = new Controllers\AdminController();
            $controller->deleteNews($id);
            header('Location: index.php?route=admin');
            break;

            //shop
        case 'displayCreateProdForm':
            $controller = new Controllers\AdminController();
            $controller->isAdmin();
            $controller->displayCreateProdForm();
            break;

        case 'displayCreateCatForm':
            $controller = new Controllers\AdminController();
            $controller->isAdmin();
            $controller->displayCreateCatForm();
            break;

        //form

        case 'submitCatForm':
            $controller = new Controllers\AdminController;
            $controller->isAdmin();
            $controller->verifCatForm();
            break;

        case 'submitProdForm':
            $controller = new Controllers\AdminController;
            $controller->isAdmin();
            $controller->verifProdForm();
            break;

        case 'submitRecipeForm':
            $controller = new Controllers\AdminController;
            $controller->isAdmin();
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

