<?php

namespace Controllers;

use \Models\Users;

class UsersController{

////////////////////////// routes //////////////////////////
    public function profil()
    {
        $model = new Users();
        $user = $model->getUser($_SESSION['user']['id']);

        $template = "users/profil.phtml";
        include_once 'views/layout.phtml';
    }
    public function cart()
    {
        $model = new Users();
        $user = $model->getUser($_SESSION['user']['id']);
        $model = new ShopCartController();
        // $cart = $model->displayCart();

        $template = "users/cart.phtml";
        include_once 'views/layout.phtml';
    }

    public function logout()
    {
        session_destroy();
        header('Location: '. $_SESSION['visitor']['currentPage']);
        exit();
    }

    public function saveSession()
    {
        global $session;
        setcookie('session', json_encode($session), time() +86400, true);
    }

////////////////////////// register //////////////////////////
    public function newUser()
    {
        $errors = $errors_pswd = $success = [];
        $email = $pswd = $pswd_confirm = "";
        $currentPage = $_SERVER["HTTP_REFERER"];
        $_SESSION['visitor']['currentPage'] = $currentPage;
        $_SESSION['visitor']['message'] = [];
        $this->saveSession();
        $session = [
            'id',
            'errors' => [],
            'succes'
        ];

        setcookie('session', json_encode($session), time() + 86400, true);



        if (array_key_exists('email', $_POST) && array_key_exists('pswd', $_POST)&& array_key_exists('pswd_confirm', $_POST)) {

            //validation email
            $email = trim($_POST['email']);

            if (empty($email)) {
                $session['errors'][] = "Veuillez entrer une adresse mail";
                $this->saveSession();
            }
            else
                switch ($email) {
                    case !filter_var(($_POST['email']), FILTER_VALIDATE_EMAIL):
                        $session['errors'][] = "Veuillez renseigner un email valide";
                        $this->saveSession();
                        break;
                    case !empty($email):
                        $model = new Users();
                        $isItFree = $model->checkEmail($email);
                        if (!empty($isItFree))
                            $session['errors'][] = "Cet email est déjà utilisé";
                            $this->saveSession();
                        break;
                }
            
            //validation mot de passe
            $pswd = trim($_POST['pswd']);

            if (empty($pswd)) {
                $session['errors'][] = "Veuillez choisir un mot de passe";
                $this->saveSession();
            }
            else 
                $numberMinimal = 8;

                switch ($pswd) {
                    case strlen($pswd) < $numberMinimal:
                        $session['errors'][] = "Le mot de passe doit contenir au minimum $numberMinimal caractères";
                        $this->saveSession();
                        break;
                    case preg_match('@[A-Z]@', $pswd)?:
                        $session['errors'][] = "Le mot de passe doit inclure au moins une lettre majuscule";
                        $this->saveSession();
                        break;
                    case preg_match('@[a-z]@', $pswd)?:
                        $session['errors'][] = "Le mot de passe doit inclure au moins une lettre minuscule";
                        $this->saveSession();
                        break;
                    case preg_match('@[0-9]@', $pswd)?:
                        $session['errors'][] = "Le mot de passe doit inclure au moins un chiffre";
                        $this->saveSession();
                        break;
                    case preg_match('@[^\w]@', $pswd)?:
                        $session['errors'][] = "Le mot de passe doit inclure au moins un caractère spécial";
                        $this->saveSession();   
                        break;
                }
            
            $pswd_confirm = trim($_POST['pswd_confirm']);

            if (empty($_POST['pswd_confirm']))
                $session['errors'][] = $errors_pswd[] = "Veuillez confirmer votre mot de passe";
                $this->saveSession();

            if (empty($errors_pswd) && ($pswd != $pswd_confirm))
                $session['errors'][] = $errors_pswd[] = "Les mots de passe ne correspondent pas";
                $this->saveSession();

            if (count($errors) == 0) {
                $newUser = [
                    $email,
                    password_hash($pswd, PASSWORD_DEFAULT),
                ];
                // var_dump($_GET);
                // die;
                $model->creatNew($newUser);
                // var_dump('coucou1');
                // var_dump($_COOKIE);
                // die;
                $newID = $_COOKIE['session']['id'];

                $this->saveSession();
                // var_dump('ici');
                // var_dump($newID);
                // die;
                $newUser = $model->getUser($newID);

                // var_dump('coucou3');
                // var_dump($newUser);
                // die;
                $_SESSION['user'] = [
                    'id' => $newUser['id'],
                    'email' => $newUser['email'],
                    'name' => $newUser['name'],
                    'role' => $newUser['role']
                ];

                $session['succes'] = "Votre compte a bien été créé !";

                $this->saveSession();

                // var_dump($_SESSION);
                // var_dump($_COOKIE);
                // die;
            }
        }

        header('Location: ' . $currentPage);
    }

////////////////////////// connexion //////////////////////////
    public function checkUser(){
        $errors = $success = $userExist = [];
        $email = $pswd = $emailUsed  = "";
        $currentPage = $_SERVER["HTTP_REFERER"];
        $_SESSION['visitor']['currentPage'] = $currentPage;
        $_SESSION['visitor']['message'] = [];
        


        if (array_key_exists('email', $_POST) && array_key_exists('pswd', $_POST)) {

            //validation email
            $email = trim($_POST['email']);

            if(empty($email))
            $_SESSION['visitor']['message'][] = $errors[] = "Veuillez renseigner le champs email";
            else
                switch ($email) {
                    case !filter_var(($_POST['email']), FILTER_VALIDATE_EMAIL):
                        $_SESSION['visitor']['message'][] = $errors[] = "Veuillez renseigner un email valide";
                        break;
                    case !empty($email):
                        $model = new Users();
                        $emailUsed = $model->checkEmail($email);
                        if (empty($emailUsed))
                            $_SESSION['visitor']['message'][] = $errors[] = "Email inconnu";
                        if (!empty($emailUsed))
                            $model = new Users();
                            $userExist = $model->getUser($emailUsed['id']);
                        break;
                }

            //validation mot de passe
            if (empty($_POST['pswd']))
            $_SESSION['visitor']['message'][] = $errors[] = "Veuillez entrer votre mot de passe";
            //stockage du mdp pour verification
            $pswd = trim($_POST['pswd']);
            if (count($errors) == 0) {
                if(password_verify($pswd, $userExist['pswd'])){
                    $_SESSION['user'] = [
                        'id' => $userExist['id'],
                        'email' => $userExist['email'],
                        'name' => $userExist['name'],
                        'role' => $userExist['role']
                        ];
                        
                    $user = "";
                    if(isset($userExist['name'])) {
                        $user = $userExist['name'];
                    } else {
                        $user = $userExist['email'];
                    }

                    if($userExist['role']==1)
                        $_SESSION['visitor']['message'] = $success[] = "Bienvenue admin " . $userExist['email'];
                    else
                        $_SESSION['visitor']['message'] = $success [] = "Bienvenue, ". $user;

                    

                    header('Location: index.php?route=home');
                    exit;

                }
            }
            header('Location: ' . $currentPage);
            // var_dump($_SESSION);
            // die;
            exit;
        // $template = "users/login.phtml";
        // include_once 'views/layout.phtml';
        // include_once '/views/errors.phtml';
        }
    }

    ////////////////////////// check session //////////////////////////

    public function isConnected(){
        var_dump($_SESSION);
        if (!isset($_SESSION['user']))
            header('Location: index.php?route=login');
    }

    ////////////////////////// update //////////////////////////

    public function replaceSpecialChar($string){
        $string =  "";
        return str_replace([",", "<", ">", "!"], "", $string);
    }

    public function updateUserName()
    {
        $errors = $success = [];
        $name = "";
        if (array_key_exists('name', $_POST)) {

            $name = trim($_POST['name']);
            $this->replaceSpecialChar($name);

            if (empty($name))
                $errors[] = "Veuillez entrer votre nom";
            }

            if (count($errors) == 0) {

                $model = new Users();
                $model->updateUser($name);

                $_SESSION['user']['name']=$name;
                $success[] = "Votre nom a bien été modifié !";
            header('Location: index.php?route=myAccount');
            exit();
            }

        $template = "users/profil.phtml";
        include_once 'views/layout.phtml';
    }
}