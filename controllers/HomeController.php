<?php

namespace Controllers;

class HomeController{
    public function displayHomePage(){
        $template = "home.phtml";
        include_once'views/layout.phtml';
        // var_dump($_GET['route']);
    }

    public function visitor(){
        if (!isset($_SESSION['visitor']))
        $_SESSION['visitor'] = [
            'token' => $this->generateToken(),
        ];
        // var_dump($_SESSION);
    }
    
    function generateToken($length = 40)
    {
        $characters       = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_!?./$';
        $charactersLength = strlen($characters);
        $token            = '';
        for ($i = 0; $i < $length; $i++) {
            $token .= $characters[rand(0, $charactersLength - 1)];
        }
        return $token;
    }
}