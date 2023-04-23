<?php

namespace Controllers;

class ContactController{
    public function displayContactPage(){

        $template = "contact/index.phtml";
        include_once'views/layout.phtml';
    }
}