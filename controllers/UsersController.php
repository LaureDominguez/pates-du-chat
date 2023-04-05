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
        $success = [];
        $model = new \Models\Users();
        if (array_key_exists('email', $_POST) && array_key_exists('pswd', $_POST)) {
            if (empty($_POST['email']))
                $errors[] = "→ Veuillez renseigner le champs email";
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
                $errors[] = "→ Veuillez renseigner un email valide";
                
            $email = trim($_POST['email']);
            $isItFree = $model->checkEmail($email);

            if($isItFree == false)
                $errors[] = "→ Cet email est éjà utilisé";
            
            var_dump($errors);
            die;

            // var_dump($model);
            // die;
                //verif mail dans model

            if (empty($_POST['pswd']))
                $errors[] = "→ Veuillez choisir un mot de passe";

            if (count($errors) == 0) {
                $newUser = [
                    trim($_POST['email']),
                    trim($_POST['pswr']),
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