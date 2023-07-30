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
    { //création d'un nouveau compte user
        //check si email deja utilisé
        $errors = $success = [];
        $model = new Users();
        $isUsed = $model->checkEmail(trim($_POST['email']));

        if($isUsed !== false){ // si error on arrete le script et renvoi l'erreur
            $errors = "Cet email est déjà utilisé";
            $_SESSION['visitor']['flash_message']['error'] = [
                'register' => $errors
            ];
            header('Location: ' . $_SESSION['visitor']['currentPage']);
            exit;
        } else { //sinon on créer le compte
            $newUser = [
                trim($_POST['email']),
                password_hash(trim($_POST['pswd']), PASSWORD_DEFAULT),
            ];

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
    }

////////////////////////// connexion //////////////////////////

    public function loginUser()
    { //connexion à un compte
        $errors = $success = [];
        $email = trim($_POST['email']);
        $model = new Users();

        //check si l'email est dans la db
        $userExist = $model->checkEmail($email);

        if(!$userExist){
            $errors[] = "L'email ou le mot de passe est incorrect";
            $_SESSION['visitor']['flash_message']['error'] = [
                'login' => $errors
            ];
            header('Location: ' . $_SESSION['visitor']['currentPage']);
            exit();
        } else { // si oui, récup les infos
            $user = $model->getUser($userExist['id']);
            $pswd = trim($_POST['pswd']);

            if (password_verify($pswd, $user['pswd'])){
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
            } else {
                $errors[] = "L'email ou le mot de passe est incorrect";
                $_SESSION['visitor']['flash_message']['error'] = [
                    'login' => $errors
                ];
            }
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
        $success = $name = "";

        if (isset($_POST['name'])) {
            $name = trim($_POST['name']);
            $this->replaceSpecialChar($name);

            if (empty($name)) {
                $errors[] = "Veuillez entrer votre nom";
            }

            if (count($errors) == 0) {
                $newData = [
                    'name' => $name
                ];
                $model = new Users();
                $model->updateUser($newData);

                $_SESSION['user']['name'] = $name;

                $success = "Votre nom a bien été modifié !";
                $_SESSION['visitor']['flash_message'] = [
                    'success' => $success
                ];

                header('Location: index.php?route=myAccount');
                exit();
            }
        }
        $_SESSION['visitor']['flash_message'] = [
            'error' => $errors
        ];
        $template = "users/profil.phtml";
        include_once 'views/layout.phtml';
    }

    // public function updateUserMail()
    // { // change email de user
    //     $errors = [];
    //     $success = $email = "";

    //     if (isset($_POST['email'])) {
    //         $email = trim($_POST['email']);
    //         $this->replaceSpecialChar($email);

    //         if (empty($email)) {
    //             $errors[] = "Veuillez renseigner la nouvelle adresse mail";
    //         }

    //         if (count($errors) == 0
    //         ) {
    //             $newData = [
    //                 'email' => $email,
    //                 'activate' => 0
    //             ];

    //             $model = new Users();
    //             $model->updateUser($newData);

    //             $_SESSION['user']['email'] = $email;

    //             $success = "Votre email a bien été modifié !";
    //             $_SESSION['visitor']['flash_message'] = [
    //                 'success' => $success
    //             ];

    //             header('Location: index.php?route=myAccount');
    //             exit();
    //         }
    //     }
    //     $_SESSION['visitor']['flash_message'] = [
    //         'error' => $errors
    //     ];
    //     $template = "users/profil.phtml";
    //     include_once 'views/layout.phtml';
    // }

    public function resetPswd()
    { //reset du password de user
        $errors = [];
        $success = "";

        var_dump($_POST);
        die;

        if (isset($_POST['pswd'])) {
            $restUser = [
                    'pswd' => password_hash(trim($_POST['pswd']), PASSWORD_DEFAULT)
                ];

            $model = new Users();
            $model->updateUser($restUser);

            $_SESSION['user'] = [
                'id' => $restUser['id'],
                'email' => $restUser['email'],
                'name' => $restUser['name'],
                'role' => $restUser['role']
            ];

            $success = "Votre mot de passe a bien été modifié !";
            $_SESSION['visitor']['flash_message'] = [
                'success' => $success
            ];

            header('Location: index.php?route=myAccount');
            exit();
        }
        $_SESSION['visitor']['flash_message'] = [
            'error' => $errors
        ];
        $template = "users/reset.phtml";
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