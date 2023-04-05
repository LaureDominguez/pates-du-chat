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

    //database

    public function newUser()
    {
        $errors = $errors_pswd = $success = [];
        $email = $pswd = $pswd_confirm = "";
        $model = new \Models\Users();

        if (array_key_exists('email', $_POST) && array_key_exists('pswd', $_POST)&& array_key_exists('pswd_confirm', $_POST)) {
        //validation email
            if (empty($_POST['email']))
                $errors[] = "Veuillez renseigner le champs email";
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
                $errors[] = "Veuillez renseigner un email valide";
            //stockage du mail pour verification dans db
            if (!empty($_POST['email']))
                $email = trim($_POST['email']);
            $isItFree = $model->checkEmail($email);
            if(!empty ($isItFree))
                $errors[] = "Cet email est éjà utilisé";
            
        //validation mot de passe
            if (empty($_POST['pswd']))
                $errors[] = $errors_pswd [] = "Veuillez choisir un mot de passe";
            if (strlen(trim($_POST['pswd'])) < 6){
                $errors[] = $errors_pswd[] = "Le mot de passe doit contenièr au moins 6 caractères";
            }
            //stockage du mdp pour verification
            $pswd = trim($_POST['pswd']);
            if (empty($_POST['pswd_confirm']))
            $errors[] = $errors_pswd[] = "Veuillez confirmer votre mot de passe";
            //stockage de la confirm du mdp
            $pswd_confirm = trim($_POST['pswd_confirm']);
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

    public function checkUser(){
        $errors = $success = $UserExist = [];
        $email = $pswd = $userExist = "";
        $model = new \Models\Users();

        if (array_key_exists('email', $_POST) && array_key_exists('pswd', $_POST)) {
            //validation email
            if (empty($_POST['email']))
                $errors[] = "Veuillez renseigner le champs email";
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
                $errors[] = "Veuillez renseigner un email valide";
            //stockage du mail pour verification dans db
            if (!empty($_POST['email']))
                $email = trim($_POST['email']);
            $emailUsed = $model->checkEmail($email);
            if (empty($emailUsed))
                $errors[] = "Email inconnu";

            $userExist = $model->findUser($emailUsed['id']);

            //validation mot de passe
            if (empty($_POST['pswd']))
                $errors[] = "Veuillez entrer votre mot de passe";
            //stockage du mdp pour verification
            $pswd = trim($_POST['pswd']);

            if (count($errors) == 0){

                if(password_verify($pswd, $userExist['pswd'])){
                    
                    $_SESSION['user'] = [
                        'id' => $userExist['id'],
                        'email' => $userExist['email']
                        ];
                    }

                var_dump($_SESSION['user']);
                die;
                }
            }
        }
    }