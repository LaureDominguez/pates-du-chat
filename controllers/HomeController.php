<?php

namespace Controllers;

class HomeController{
    public function displayHomePage(){
        $template = "home.phtml";
        include_once'views/layout.phtml';
    }
}