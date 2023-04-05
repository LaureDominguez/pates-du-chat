<?php

namespace Controllers;

class UsersController{
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

    public function verifForm()
    {
        $errors = [];
        $errors_pswd = [];
        $success = [];
        $model = new \Models\Users();
        if (array_key_exists('email', $_POST) && array_key_exists('pswd', $_POST)&& array_key_exists('pswd_confirm', $_POST)) {
        //validation email
            if (empty($_POST['email']))
                $errors[] = "→ Veuillez renseigner le champs email";
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
                $errors[] = "→ Veuillez renseigner un email valide";
            //stockage du mail pour verification dans db
            $email = trim($_POST['email']);
            $isItFree = $model->checkEmail($email);

            if(!empty ($isItFree))
                $errors[] = "→ Cet email est éjà utilisé";
            
        //validation mot de passe
            if (empty($_POST['pswd']))
                $errors[] = $errors_pswd [] = "→ Veuillez choisir un mot de passe";
            if (strlen(trim($_POST['pswd'])) < 6){
                $errors[] = $errors_pswd[] = "→ Le mot de passe doit contenièr au moins 6 caractères";
            }
            //stockage du mdp pour verification
            $pswd = trim($_POST['pswd']);
            if (empty($_POST['pswd_confirm']))
            $errors[] = $errors_pswd[] = "→ Veuillez confirmer votre mot de passe";
            //stockage de la confirm du mdp
            $pswd_confirm = trim($_POST['pswd_confirm']);
            if (empty($errors_pswd) && ($pswd != $pswd_confirm))
            $errors[] = $errors_pswd[] = "→ Les mots de passe ne correspondent pas";

            if (count($errors) == 0) {
                $newUser = [
                    $param_email = $email,
                    $param_pswd = password_hash($pswd, PASSWORD_DEFAULT),
                ];

                $model = new \Models\Users();

                $model->creatNew($newUser);
                $success[] = "Votre compte a bien été créé !";
            }
        }
        $template = "users/register.phtml";
        include_once 'views/layout.phtml';
    }
}