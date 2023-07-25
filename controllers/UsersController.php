<?php

namespace Controllers;

use \Models\Users;

class UsersController{


    ////////////////////////// check session //////////////////////////

    public function isConnected()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?route=login');
        }
        
    }

////////////////////////// Profile //////////////////////////
    public function profil()
    {//affiche le compte user
        $model = new Users();
        $user = $model->getUser($_SESSION['user']['id']);

        $template = "users/profil.phtml";
        include_once 'views/layout.phtml';
    }

////////////////////////// register //////////////////////////
    public function newUser()
    {//création d'un nouveau compte user
        $newUser = [
            trim($_POST['email']),
            trim($_POST['pswd'])
            // password_hash(trim($_POST['pswd']), PASSWORD_DEFAULT),
        ];

        $model = new Users();
        $newID = $model->creatNew($newUser);

        //recupère l'id créé pour le connecter directement
        $newUser = $model->getUser($newID);

        $_SESSION['user'] = [
            'id' => $newUser['id'],
            'email' => $newUser['email'],
            'name' => $newUser['name'],
            'role' => $newUser['role']
        ];

        $success = "Votre compte a bien été créé !";
        $_SESSION['visitor']['flash_message'] = [
            'success' => $success
        ];

        header('Location: ' . $_SESSION['visitor']['currentPage']);
    }

////////////////////////// connexion //////////////////////////
    public function loginUser()
    { //connexion à un compte
        $errors = [];
        $email = trim($_POST['email']);
        $pswd = trim($_POST['pswd']);
        // $pswd = password_hash(trim($_POST['pswd']), PASSWORD_DEFAULT);

        // var_dump($pswd);
        // die;
        $model = new Users();

        $userExist = $model->checkEmail($email);
        $user = $model->getUser($userExist['id']);

        // if (!$user || !password_verify($pswd, $user['pswd'])) {
        //     $errors[] = "Email ou mot de passe incorrect";
        // }

        if (count($errors) > 0) {
            $_SESSION['visitor']['flash_message'] = [
                'error' => $errors
            ];
        } else {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'email' => $user['email'],
                'name' => $user['name'],
                'role' => $user['role']
            ];

            //si user a un nom, alors on l'appelle par son nom, sinon par email
            $userName = isset($user['name']) ? $user['name'] : $user['email'];

            //si user a le role admin, alors on lui dit
            if ($user['role'] == 1) {
                $success = "Bienvenue admin " . $userName;
                $_SESSION['admin']['adminToken'];
            } else {
                $success = "Bienvenue, " . $userName;
            }

            $_SESSION['visitor']['flash_message'] = [
                'success' => $success
            ];
        }
        header('Location: ' . $_SESSION['visitor']['currentPage']);
        exit();
    }

    ////////////////////////// update //////////////////////////

    public function replaceSpecialChar($string)
    {
        $string =  "";
        return str_replace([",", "<", ">", "!"], "", $string);
    }

    public function updateUserName()
    {//création ou modification du nom de user
        $errors = [];
        $success = "";

        $name = trim($_POST['name']);

        if (empty($name)) {
            $errors[] = "Veuillez entrer votre nom";
        }


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

                $success = "Votre nom a bien été modifié !";
                $_SESSION['visitor']['flash_message'] = [
                        'success' => $success
                    ];
                
                header('Location: index.php?route=myAccount');
                exit();
            }
        $_SESSION['visitor']['flash_message'] = [
            'error' => $errors
        ];
        $template = "users/profil.phtml";
        include_once 'views/layout.phtml';
    }

    ////////////////////////// logout //////////////////////////
    public function logout()
    { //deconnexion de la session 'user'
        session_destroy();
        $currentPage = $_SESSION['visitor']['currentPage'];

        if ($currentPage == 'myAccount' || $currentPage == 'myShopCart' || $currentPage == 'admin') {
            header('Location: index.php?route=home');
        } else {
            header('Location: ' . $currentPage);
        }
    }
}