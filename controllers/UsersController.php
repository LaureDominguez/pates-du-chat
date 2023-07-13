<?php

namespace Controllers;

use \Models\Users;

class UsersController{

////////////////////////// routes //////////////////////////
    public function profil()
    {//affiche le compte user
        $model = new Users();
        $user = $model->getUser($_SESSION['user']['id']);

        $template = "users/profil.phtml";
        include_once 'views/layout.phtml';
    }

    public function cart()
    {//affiche le panier de l'utilisateur (gestion dans ShopCartController)
        $model = new Users();
        $user = $model->getUser($_SESSION['user']['id']);
        $model = new ShopCartController();

        $template = "users/cart.phtml";
        include_once 'views/layout.phtml';
    }

    public function logout()
    {//deconnexion de la session 'user'
        session_destroy();
        $currentPage = $_SESSION['visitor']['currentPage'];
        if($currentPage = 'myAccount' || 'myShopCart' || 'admin'){
            header('Location: index.php?route=home');
            exit();
        }
        header('Location: ' . $currentPage);
        exit();
    }

////////////////////////// register //////////////////////////
    public function newUser()
    {//création d'un nouveau compte user
        $errors = $errors_email = $errors_pswd = $errors_verif = [];
        $email = $pswd = $pswd_confirm = $success = "";

        if (array_key_exists('email', $_POST) && array_key_exists('pswd', $_POST)&& array_key_exists('pswd_confirm', $_POST)) {

            //validation email
            $email = trim($_POST['email']);

            //si erreur, alors stock le message d'erreur
            if (empty($email)) {
                $errors[] = $errors_email[] = "Veuillez entrer une adresse mail";
            } else
                switch ($email) {
                    case !filter_var(($_POST['email']), FILTER_VALIDATE_EMAIL):
                        $errors[] = $errors_email[] = "Veuillez renseigner un email valide";
                        break;
                    case !empty($email):
                        $model = new Users();
                        $isItFree = $model->checkEmail($email);
                        if (!empty($isItFree))
                            $errors[] = $errors_email[] = "Cet email est déjà utilisé";
                        break;
                }

            //validation mot de passe
            $pswd = trim($_POST['pswd']);
            $numberMinimal = 8;

            if (empty($pswd)) {
                $errors[] = $errors_pswd[] = "Veuillez choisir un mot de passe";
            } else
                switch ($pswd) {
                    case strlen($pswd) < $numberMinimal:
                        $errors[] = $errors_pswd [] = "Le mot de passe doit contenir au minimum $numberMinimal caractères";
                        break;
                    case preg_match('@[A-Z]@', $pswd)?:
                        $errors[] = $errors_pswd[] = "Le mot de passe doit inclure au moins une lettre majuscule";
                        break;
                    case preg_match('@[a-z]@', $pswd)?:
                        $errors[] = $errors_pswd[] = "Le mot de passe doit inclure au moins une lettre minuscule";
                        break;
                    case preg_match('@[0-9]@', $pswd)?:
                        $errors[] = $errors_pswd[] = "Le mot de passe doit inclure au moins un chiffre";
                        break;
                    case preg_match('@[^\w]@', $pswd)?:
                        $errors[] = $errors_pswd[] = "Le mot de passe doit inclure au moins un caractère spécial";
                        break;
                }
            
            $pswd_confirm = trim($_POST['pswd_confirm']);

            if (empty($_POST['pswd_confirm']))
                $errors[] = $errors_verif[] = "Veuillez confirmer votre mot de passe";
            if (empty($errors_pswd) && ($pswd != $pswd_confirm))
                $errors[] = $errors_verif[] = "Les mots de passe ne correspondent pas";
            
            //si erreur, alors stock dans la session visitor pour les afficher
            $_SESSION['visitor']['msg'] = [
                'new_email_errors' => $errors_email,
                'new_pswd_errors' => $errors_pswd,
                'new_verif_errors' => $errors_verif
            ];

            if (count($errors) == 0) {
                $newUser = [
                    $email,
                    password_hash($pswd, PASSWORD_DEFAULT),
                ];

                //si pas d'erreur, création du compte user
                $model = new Users();
                $model->creatNew($newUser);

                //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                //MODIF DU NEW USER ID DANS DB

                // if (isset($_SESSION['visitor']) && !isset($_SESSION['user']))
                // $_SESSION['visitor']['id'] = $newID;

                // A CORRIGER
                //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

                //recupère l'id créé pour le connecter directement
                $newID = $_SESSION['visitor']['id'];
                $newUser = $model->getUser($newID);

                $_SESSION['user'] = [
                    'id' => $newUser['id'],
                    'email' => $newUser['email'],
                    'name' => $newUser['name'],
                    'role' => $newUser['role']
                ];

                $success = "Votre compte a bien été créé !";
                $_SESSION['visitor']['msg'] = [
                    'success' => $success
                ];
            }
        }
        header('Location: ' . $_SESSION['visitor']['currentPage']);
    }

////////////////////////// connexion //////////////////////////
    public function checkUser()
    {//connexion d'un compte user
        $errors = $errors_email = $errors_pswd = $userExist = [];
        $email = $pswd = $emailUsed  = $success = "";

        if (array_key_exists('email', $_POST) && array_key_exists('pswd', $_POST)) {

            //validation email
            $email = trim($_POST['email']);
            
            //si erreur, alors stock le message d'erreur
            if(empty($email))
            $errors[] = $errors_email[] = "Veuillez saisir un email";
            else
                switch ($email) {
                    case !filter_var(($_POST['email']), FILTER_VALIDATE_EMAIL):
                        $errors[] = $errors_email[] = "Email ou mot de passe incconu";
                        break;
                    case !empty($email):
                        $model = new Users();
                        $emailUsed = $model->checkEmail($email);
                        if (empty($emailUsed))
                            $errors[] = $errors_email[] = "Email ou mot de passe incconu";
                        if (!empty($emailUsed))
                            $model = new Users();
                            $userExist = $model->getUser($emailUsed['id']);
                        break;
                }


            //validation mot de passe
            if (empty($_POST['pswd']))
                $errors[] = $errors_pswd[] = "Veuillez entrer votre mot de passe";

            //si erreur, alors stock dans la session visitor
            var_dump($errors);
            // $_SESSION['visitor']['msg'] = [
            //     'log_email_errors' => $errors_email,
            //     'log_pswd_errors' => $errors_pswd,
            // ];

            //stockage du mdp pour verification
            $pswd = trim($_POST['pswd']);
            //si pas d'erreur, alors créer la session user. else à la fin
            if (count($errors) == 0) {
                if(password_verify($pswd, $userExist['pswd'])){
                    $_SESSION['user'] = [
                        'id' => $userExist['id'],
                        'email' => $userExist['email'],
                        'name' => $userExist['name'],
                        'role' => $userExist['role']
                        ];
                        
                    $user = "";
                    //si user a un nom, alors on l'appelle par son nom, sinon par email
                    if(isset($userExist['name'])) {
                        $user = $userExist['name'];
                    } else {
                        $user = $userExist['email'];
                    }

                    //si user a le role admin, alors on lui dit
                    if($userExist['role']==1){
                        $success = "Bienvenue admin " . $userExist['email'];
                        $_SESSION['admin'] = [
                            'dashboardPages' => [
                                'tab1' => 'checked',
                                'tab2' => '',
                                'tab3' => '',
                                'tab4' => '',
                                ]
                            ];
                        } else
                        $success = "Bienvenue, ". $user;

                    $_SESSION['visitor']['msg'] = [
                        'success' => $success,
                    ];

                    header('Location: index.php?route=home');
                    exit;
                } else $errors[] = $errors_email[] = "Email ou mot de passe incconu";

                //sinon on affiche les erreurs
                $_SESSION['visitor']['msg'] = [
                    'log_email_errors' => $errors_email,
                    'log_pswd_errors' => $errors_pswd,
                ];
            }

            header('Location: ' . $_SESSION['visitor']['currentPage']);
            exit;
        }
    }

    ////////////////////////// check session //////////////////////////

    public function isConnected()
    {
        if (!isset($_SESSION['user']))
            header('Location: index.php?route=login');
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
        $name = $success = "";
        if (array_key_exists('name', $_POST)) {

            $name = trim($_POST['name']);
            $this->replaceSpecialChar($name);

            if (empty($name))
                $errors[] = "Veuillez entrer votre nom";
            }

            $_SESSION['visitor']['msg'] = [
                'name_error' => $errors,
            ];

            if (count($errors) == 0) {

                $model = new Users();
                $model->updateUser($name);

                $_SESSION['user']['name']=$name;

                $success = "Votre nom a bien été modifié !";
                $_SESSION['visitor']['msg'] = [
                    'name_success' => $success,
                ];
                
                header('Location: index.php?route=myAccount');
                exit();
            }
        $_SESSION['visitor']['msg'] = [
            'name_error' => $errors,
        ];
        $template = "users/profil.phtml";
        include_once 'views/layout.phtml';
    }
}