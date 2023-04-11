<?php

namespace Controllers;

class UsersController{
    //routes
    public function register()
    {
        $template = "register.phtml";
        include_once'views/layout.phtml';
    }

    public function login()
    {
        $template = "users/login.phtml";
        include_once 'views/layout.phtml';
    }

    public function profil()
    {
        $template = "users/profil.phtml";
        include_once 'views/layout.phtml';
    }

    public function logout()
    {
        session_destroy();
        header('Location: index.php');
        exit();
    }

    //token
    // function generateToken($length = 40)
    // {
    //     $characters       = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_!?./$';
    //     $charactersLength = strlen($characters);
    //     $token            = '';
    //     for ($i = 0; $i < $length; $i++) {
    //         $token .= $characters[rand(0, $charactersLength - 1)];
    //     }
    //     return $token;
    // }

    //session

    //register
    public function newUser()
    {
        $errors = $errors_pswd = $success = [];
        $email = $pswd = $pswd_confirm = "";
        $model = new \Models\Users();

        if (array_key_exists('email', $_POST) && array_key_exists('pswd', $_POST)&& array_key_exists('pswd_confirm', $_POST)) {
            //validation email
            $email = trim($_POST['email']);

            if (empty($email))
                $errors[] = "Veuillez renseigner le champs email";
            else
                switch ($email) {
                    case !filter_var(($_POST['email']), FILTER_VALIDATE_EMAIL):
                        $errors[] = "Veuillez renseigner un email valide";
                        break;
                    case !empty($email):
                        $isItFree = $model->checkEmail($email);
                        if (!empty($isItFree))
                            $errors[] = "Cet email est éjà utilisé";
                        break;
                }

            //validation mot de passe
            $pswd = trim($_POST['pswd']);

            if (empty($pswd))
                $errors[] = "Veuillez choisir un mot de passe";
            elseif (strlen($pswd) < 6){
                $errors[] = $errors_pswd[] = "Le mot de passe doit contenièr au moins 6 caractères";
            }

            $pswd_confirm = trim($_POST['pswd_confirm']);

            if (empty($_POST['pswd_confirm']))
                $errors[] = $errors_pswd[] = "Veuillez confirmer votre mot de passe";

            if (empty($errors_pswd) && ($pswd != $pswd_confirm))
                $errors[] = $errors_pswd[] = "Les mots de passe ne correspondent pas";

            if (count($errors) == 0) {
                $newUser = [
                    $param_email = $email,
                    $param_pswd = password_hash($pswd, PASSWORD_DEFAULT),
                ];

                $model->creatNew($newUser);
                $success[] = "Votre compte a bien été créé !";
            }
        }
        $template = "users/register.phtml";
        include_once 'views/layout.phtml';
    }

    //connexion
    public function checkUser(){
        $errors = $success = $userExist = [];
        $email = $pswd = $emailUsed  = "";
        $model = new \Models\Users();

        if (array_key_exists('email', $_POST) && array_key_exists('pswd', $_POST)) {

            $email = trim($_POST['email']);
            //validation email
            if(empty($email))
                $errors[] = "Veuillez renseigner le champs email";
            else
                switch ($email) {
                    case !filter_var(($_POST['email']), FILTER_VALIDATE_EMAIL):
                        $errors[] = "Veuillez renseigner un email valide";
                        break;
                    case !empty($email):
                        $emailUsed = $model->checkEmail($email);
                        if (empty($emailUsed))
                            $errors[] = "Email inconnu";
                        if (!empty($emailUsed))
                            $userExist = $model->getUser($emailUsed['id']);
                        break;
                }         

            //validation mot de passe
            if (empty($_POST['pswd']))
                $errors[] = "Veuillez entrer votre mot de passe";
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
                    }
                    
                    else {
                        $user = $userExist['email'];
                    }
                    $success [] = "Bienvenue, ". $user;
                }
            }
        // $modale = "users/login.phtml";
        $template = "users/login.phtml";
        include_once 'views/layout.phtml';
        }
    }
    }