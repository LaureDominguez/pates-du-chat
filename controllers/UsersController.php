<?php

namespace Controllers;

class UsersController{
    public function register()
    {
        $template = "users/register.phtml";
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
}